<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class calendar extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->auth->check_session();
		$this->load->model("calendar_model");
		$this->load->model("dashboard_model");
		$this->load->model("hospital_model");
		$this->load->model("patient_model");
		$this->load->model("medical_college_model");
		$this->load->model("manufacturing_company_model");
		$this->load->model("doctor_model");
		$this->load->model("patient_model");
		$this->load->model("prescription_model");
		$this->load->model("setting_model");
		$this->load->model("notification_model");
		$this->load->model("contact_model");
		$this->load->model("to_do_list_model");
		$this->load->model("appointment_model");
		$this->load->model("hospital_model");
		$this->load->model("medical_college_model");
		$this->load->model("schedule_model");
	}
	
	
	function show_form(){
			$data['contacts'] = $this->patient_model->get_patients_by_doctor();
			$data['contact'] = $this->contact_model->get_contact_by_doctor();
	
		$data['body'] = 'calendar/calendar';
		$this->load->view('template/main', $data);	
	}
	
	function edit_form(){
		$data = '';	
		
		$this->load->view('calendar/edit', $data);	
	}
	
	function add_form(){
		$data = '';	
		$this->load->view('calendar/add', $data);	
	}
	
	function delete_event(){
		//echo '<pre>'; print_r($_POST);die;
		$type_id = $_POST['type_id'];
		$id = $_POST['id'];	
		if($type_id==1){
			$this->to_do_list_model->delete($id);
		}
		if($type_id==2){
			$this->appointment_model->delete($id);
		
		}
		if($type_id==3){
			$this->schedule_model->delete_week_schedule($id);
		}
		if($type_id==4){
			$this->schedule_model->delete_week_schedule($id);
		}
		if($type_id==5){
			$this->calendar_model->delete($id);
		}
		$this->session->set_flashdata('message', "Event Deleted");
		die;
	}
	
	function index($event=false) {
		$data['event'] = $event;
		$admin = $this->session->userdata('admin');
		
		if($data['event']==0){   //show all
			$data['todos'] = $this->calendar_model->get_todos();
		$data['appointments'] = $this->calendar_model->get_appointments();
		$data['others'] = $this->calendar_model->get_other_schedule();
		}
		if($data['event']=="todo"){
			$data['todos'] = $this->calendar_model->get_todos();
			$data['appointments'] = array();
			$data['others'] = array();
		}
		
		if($data['event']=="appointment"){
			$data['todos'] = array();
			$data['appointments'] = $this->calendar_model->get_appointments();
			$data['others'] = array();
		}
		
		if($data['event']=="other"){
			$data['todos'] = array();
			$data['appointments'] = array();
			$data['others'] = $this->calendar_model->get_other_schedule();
		}
		
		$data['contacts'] = $this->patient_model->get_patients_by_doctor();
		$data['contact'] = $this->contact_model->get_contact_by_doctor();
		//echo '<pre>'; print_r($data['others']);die;
		
		
		$data['page_title'] = lang('event_calendar');
		$data['body'] = 'calendar/calendar';
		$this->load->view('template/main', $data);	

	}	
	
	
	
	function add(){
		//echo '<pre>'; print_r($_POST);die;	
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			 
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('title', 'Detail', '');
			$this->form_validation->set_rules('schedule_category', 'Schedule Category', 'required');
		
			if ($this->form_validation->run()==true)
            {	
				$type = $this->input->post('schedule_category');
				$starttime =$this->input->post('starttime');
				$endtime =$this->input->post('endtime');
				
					$checked = $this->calendar_model->check_tables($starttime,$endtime);
					//echo $checked;die;
					if(!empty($checked)){
						$this->session->set_flashdata('error', $checked);
					}else{
						//echo '<pre>'; print_r($save);die;	
						$this->session->set_flashdata('message', "Schedule Created");
					}
			
				$admin = $this->session->userdata('admin');
				$type_id = $this->input->post('schedule_category');
				if($type_id==1){
					$save['title'] = $this->input->post('title');
					$save['date'] = $this->input->post('starttime');
					$save['doctor_id'] = $admin['id'];
					
					$this->to_do_list_model->save($save);
				}
				if($type_id==2){
					$save['title'] = $this->input->post('title');
					$save['whom'] = $this->input->post('whom');
					$save['patient_id'] = $this->input->post('patient_id');
					$save['contact_id'] = $this->input->post('contact_id');
					$save['other'] = $this->input->post('other');
					$save['motive'] = $this->input->post('motive');
					$save['date'] = $this->input->post('starttime');
					$save['is_paid'] = $this->input->post('is_paid');
					$save['status'] = 1;
					$save['doctor_id'] = $admin['id'];
					
					$this->appointment_model->save($save);
				}
				if($type_id==5){
					$save['schedule_category_id'] = $this->input->post('schedule_category');
					$save['title'] = $this->input->post('title');
					$save['starttime'] = $this->input->post('starttime');
					$save['endtime'] = $this->input->post('endtime');
					$save['doctor_id'] = $admin['id'];
					$this->calendar_model->save($save);
					
				}
								
				
				
					
					//echo '<pre>'; print_r($todos);die;	
			
				
				echo 1;
			}else{
			
			echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>'.validation_errors().'
											</div>
				';
			}
			
			
		}	
	}	
	
	
	function edit(){
		//echo '<pre>'; print_r($_POST);die;
		
		$type = $this->input->post('schedule_category');
				$starttime =$this->input->post('starttime');
				$endtime =$this->input->post('endtime');
				
					$checked = $this->calendar_model->check_tables($starttime,$endtime);
					if(!empty($checked)){
						$this->session->set_flashdata('error', $checked);
						redirect(site_url('admin/calendar'));
					}else{
						//echo '<pre>'; print_r($save);die;	
						$this->session->set_flashdata('message', "Schedule Updated");
					}
			
				$admin = $this->session->userdata('admin');
				$type_id = $this->input->post('schedule_category');
				$id = $this->input->post('id');
				if($type_id==1){
					$save['title'] = $this->input->post('title');
					$save['date'] = $this->input->post('starttime');
					$save['doctor_id'] = $admin['id'];
					
					$this->to_do_list_model->update($save,$id);
				}
				if($type_id==2){
					$save['title'] = $this->input->post('title');
					$save['whom'] = $this->input->post('whom');
					$save['patient_id'] = $this->input->post('patient_id');
					$save['contact_id'] = $this->input->post('contact_id');
					$save['other'] = $this->input->post('other');
					$save['motive'] = $this->input->post('motive');
					$save['date'] = $this->input->post('starttime');
					$save['is_paid'] = $this->input->post('is_paid');
					$save['status'] = 1;
					$save['doctor_id'] = $admin['id'];
					
					$this->appointment_model->update($save,$id);
				}
				if($type_id==5){
					$save['schedule_category_id'] = $this->input->post('schedule_category');
					$save['title'] = $this->input->post('title');
					$save['id'] = $this->input->post('id');
					$save['starttime'] = $this->input->post('starttime');
					$save['endtime'] = $this->input->post('endtime');
					$save['doctor_id'] = $admin['id'];
					$this->calendar_model->update($save);
					
				}
			redirect(site_url('admin/calendar'));	
	}
	
	function get_schedule(){
		//echo '<pre>'; print_r($_POST);die;
		$data['type']	= 	$type 	= 	$_POST['type'];
		$id = $_POST['id'];
		$data['contacts'] = $this->patient_model->get_patients_by_doctor();
		$data['contact'] = $this->contact_model->get_contact_by_doctor();
		
		$data['app']=array();
		$data['result']=array();
		if($type==1){
			$data['result'] =$this->to_do_list_model->get_list_by_id($id);
			$this->load->view('calendar/ajax', $data);	
		}
		if($type==2){
			$data['app'] =$this->appointment_model->get_appointment_by_id($id);
			$this->load->view('calendar/ajax_appointment', $data);	
		}
		if($type==5){
			$data['result'] =$this->calendar_model->get_event_by_id($id);
			$this->load->view('calendar/ajax_other', $data);	
		}
		
		//echo '<pre>'; print_r($data['app']);
		//echo '<pre>'; print_r($data['result']);die;
		
		//$data['body'] = '';
		//$this->load->view('calendar/ajax', $data);	
	}
	
	function update_other_schedule()	
	{
		//echo '<pre>'; print_r($_POST);die;	
				$type = $this->input->post('type');
				$admin = $this->session->userdata('admin');
				
				if($type==1){
					$save['id'] = $this->input->post('id');
					$save['date'] = $this->input->post('starttime');
					
					$this->to_do_list_model->update($save,$save['id']);
				}
				if($type==2){
					$save['id'] = $this->input->post('id');
					$save['date'] = $this->input->post('starttime');
            	
					$this->appointment_model->update($save,$save['id']);
				}
				if($type==5){
					$save['id'] = $this->input->post('id');
					$save['starttime'] = $this->input->post('starttime');
					$save['endtime'] = $this->input->post('endtime');
					
					$this->calendar_model->update($save);
				}
				
				echo 1;
				
	}
	
	function delete_appointment($id){
		
		$this->appointment_model->delete($id);
		$this->session->set_flashdata('message', lang('appointment_deleted'));
		redirect(site_url('admin/calendar/'));
	}
	
	function delete_other($id){
		
		$this->calendar_model->delete($id);
		$this->session->set_flashdata('message', lang('event_deleted'));
		redirect(site_url('admin/calendar/'));
	}
	
	function delete_todo($id){
	
		$this->to_do_list_model->delete($id);
		$this->session->set_flashdata('message', lang('to_do_deleted'));
		redirect(site_url('admin/calendar/'));
	}
}