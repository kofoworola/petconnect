<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class book_appointment extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_access('2', true);
		$this->load->model("appointment_model");
		$this->load->model("custom_field_model");
		$this->load->model("patient_model");
	}
	
	function add(){
		$data['contact_fields'] = $this->custom_field_model->get_custom_fields(4);	
		
		$data['fields'] = $this->custom_field_model->get_custom_fields(2);
		$data['groups'] = $this->patient_model->get_blood_group();
		$data['contacts'] = $this->patient_model->get_patients_by_doctor();
		$admin = $this->session->userdata('admin');	
		if ($this->input->post('ok'))
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('title', 'lang:title', 'required');
			$this->form_validation->set_rules('motive', 'lang:motive', 'required');
			$this->form_validation->set_rules('date_time', 'lang:date', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
			 
			if ($this->form_validation->run()==true)
            {
				$save['title'] = $this->input->post('title');
				$save['doctor_id'] =$admin['doctor_id'];
				$save['patient_id'] = $admin['id'];
				$save['motive'] = $this->input->post('motive');
				$save['notes'] = $this->input->post('notes');
				$save['date'] = $this->input->post('date_time');
				$save['whom'] = 1;
				//echo '<pre>';print_r($save);die;
				$p_key = $this->appointment_model->save($save);
				
				$this->session->set_flashdata('message', lang('appointment_created'));
				redirect('admin/book_appointment');
				
				
			}
		}		
		
		
		$data['page_title'] = lang('add') . lang('appointment');
		$data['body'] = 'book_appointment/add';
		
		$this->load->view('template/main', $data);	
	}
	
	
	
				
	function index(){
		$admin = $this->session->userdata('admin');	
		$data['patient']= $patient = $this->patient_model->get_patient_by_id($admin['id']);
		//$data['times_all'] =	$this->appointment_model->get_appointment_time($patient->doctor_id);
		$data['appointments'] =	$this->appointment_model->get_appointment_by_patient($admin['id']);
		//echo '<pre>';print_r($data['times_all']);die;
		$data['contacts'] = $this->patient_model->get_all();
		
		$data['page_title'] =  lang('appointments');
		$data['body'] = 'book_appointment/list';
		$this->load->view('template/main', $data);	
	}	
	
	
	
	function getWednesdays($day,$month, $year) {
			
			$base_date = strtotime($year . '-' . $month . '-01');
			
			if($day=="mon"){
				$wed = strtotime('first mon of ' . date('F Y', $base_date));
			}
			if($day=="tue"){
				$wed = strtotime('first tue of ' . date('F Y', $base_date));
			}
			if($day=="wed"){
				$wed = strtotime('first wed of ' . date('F Y', $base_date));
			}
			if($day=="thu"){
				$wed = strtotime('first thu of ' . date('F Y', $base_date));
			}
			if($day=="fri"){
				$wed = strtotime('first fri of ' . date('F Y', $base_date));
			}
			if($day=="sat"){
				$wed = strtotime('first sat of ' . date('F Y', $base_date));
			}
			if($day=="sun"){
				$wed = strtotime('first sun of ' . date('F Y', $base_date));
			}
			
			$wednesdays = array();
			
			do {
				$wednesdays[] = new DateTime(date('r', $wed));
				$wed = strtotime('+7 days', $wed);
				
			} while (date('m', $wed) == $month);
		
			return  $wednesdays;
	
	}
	
	
	
	function book($d=false,$t1=false,$t2=false){
		$data['day']= $day= urldecode($d);
		$data['time1'] = urldecode($t1);
		$data['time2'] = urldecode($t2);
			
			$d= strtolower($day);
			
		$data['res'] = $this->getWednesdays($d,date('m'),date('Y'));
		$admin = $this->session->userdata('admin');	
		$data['patient']= $patient = $this->patient_model->get_patient_by_id($admin['id']);
		
		/*if(!$t2){
					$this->session->set_flashdata('error', lang('select_day_must'));
					redirect('admin/book_appointment');	
				}
		*/
		
		if ($this->input->post('ok'))
        {	
		
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('date', 'lang:date', 'required');
			$this->form_validation->set_rules('comment', 'lang:comment', '');
			
			if ($this->form_validation->run()==true)
            {
				
				
				if($this->input->post('date') < date("Y-m-d")){
					$this->session->set_flashdata('message', lang('small_date'));
					redirect('admin/book_appointment');	
				}
			
					$save['doctor_id']  =	$data['patient']->doctor_id;
					$save['patient_id']  =	$admin['id'];
					$save['date'] 		= 	$this->input->post('date');
					$save['time'] 		= 	$this->input->post('time');
					$save['comment']	= 	$this->input->post('comment');
				
			//echo '<pre>'; print_r($save);die;	
				
				$this->appointment_model->save($save);
		       	$this->session->set_flashdata('message', lang('appointment_saved'));
				redirect('admin/book_appointment');
				
				
			}
		}		
		
		$data['page_title'] =  lang('book');
		$data['body'] = 'book_appointment/add';
		$this->load->view('template/main', $data);	
	
	}
	
	function view_appointment($id=false){
		$data['fields'] = $this->custom_field_model->get_custom_fields(5);	
		$data['appointment'] =$this->appointment_model->get_appointment_by_id($id);
		//echo '<pre>'; print_r($data['appointment']);die;
		$data['id'] =$id;
		$this->appointment_model->appointment_view_by_admin($id);
		$data['page_title'] = lang('view') . lang('appointment');
		$data['body'] = 'book_appointment/view';
		$this->load->view('template/main', $data);	

	}	
	
	function view_all(){
		$data['appointments'] = $this->appointment_model->get_appointment_by_date();
		$ids='';
		foreach($data['appointments'] as $ind => $key){
		
			$ids[]=$key->id;
		}
		$this->appointment_model->appointments_view_by_admin($ids);
		$data['page_title'] = lang('view_all') . lang('appointments');
		$data['body'] = 'book_appointment/view_all';
		$this->load->view('template/main', $data);	
	}	
	
	
	function delete($id=false){
		
		if($id){
			$this->appointment_model->delete($id);
			$this->session->set_flashdata('message',lang('appointment_deleted'));
			redirect('admin/book_appointment');
		}
	}	
		
	
}