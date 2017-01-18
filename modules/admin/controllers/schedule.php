<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class schedule extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_access('1', true);
		$this->load->model("schedule_model");
		$this->load->model("custom_field_model");
		
	}
	
	
	function index()
	{
		if($this->input->post('s1'))
		{
			$schedule_type=$this->input->post('schedule_type');
				if($schedule_type==1)
				{//redirect('admin/schedule/fixed_schedule');}
				redirect('admin/schedule/select_weekly_monthly');}
				else if($schedule_type==2){
				redirect('admin/schedule/other_schedule');}
		}
		$data['body'] = 'schedule/select_fixed_other';
		$this->load->view('template/main', $data);	
	}	
	
	function fixed_schedule()
	{
	if($this->input->post('s2'))
		{
				$admin=$this->session->userdata('admin');
				
				foreach($_POST['schedule'] as $key=>$value)
				{		$day_id=$key;
						foreach($value as $data)
						{
							if(!empty($data['form'])){
							$save = array(
										'doctor_id'=>$admin['id'],
										 'day'=>$day_id,
										 'timing_from'=>$data['form'], 
										 'timing_to'=>$data['to'],
										 'work'=>$data['work']
										 );
						
							if($this->schedule_model->save_schedule($save))
							{
							$this->session->set_flashdata('message',"Your Fixed Schedule is Saved!!");
							}
						}
				}
		}
			
			
		}
		$data['days']=$this->schedule_model->get_days();
		$data['page_title'] =  lang('schedules');
		$data['body'] = 'schedule/add';
		$this->load->view('template/main', $data);
	
	}
	function other_schedule()
	{
	if($this->input->post('s3'))
		{
			$admin=$this->session->userdata('admin');
			foreach($_POST['schedule'] as $data)
			{		
				$save = array(
							'doctor_id'=>$admin['id'],
							'dates'=>$data['dates'],
							'timing_from'=>$data['time_from'], 
							 'timing_to'=>$data['time_to'],
							 'work'=>$data['work'],
							 'hospital_id'=>$data['hospital']
							 );
			
				if($this->schedule_model->save_other_schedule($save))
				{
							$this->session->set_flashdata('message',"Your Specific Schedule is Saved!!");
							
				}
				
				
			}	
			redirect('admin/schedule/view_specific_schedule');
		}	
		$this->load->model('hospital_model');
		$data['hospital']=$this->hospital_model->get_all();
		$data['days']=$this->schedule_model->get_days();
		$data['page_title'] =  lang('schedules');
		$data['body'] = 'schedule/add_other_schedule';
		$this->load->view('template/main', $data);
	
	}
	
	function view_schedule()
	{
	$data['days']=$this->schedule_model->get_days();
	$data['fixed_schedule']=$this->schedule_model->get_all_fixed_schedule($this->session->userdata['admin']['id']);
	$data['body'] = 'schedule/view';
	$this->load->view('template/main', $data);
	}
	
	function view_specific_schedule()
	{
	$data['specific_schedule']=$this->schedule_model->get_all_specific_schedule($this->session->userdata['admin']['id']);
	$data['body'] = 'schedule/view_other_schedule';
	$this->load->view('template/main', $data);
	}
	
	function edit_schedule()
	{
	if($this->input->post('s2'))
	{
	//echo '<pre>' ;print_r($_POST); die;
	$admin=$this->session->userdata('admin');
	$this->schedule_model->delete_fixed_schedule($admin['id']);
	foreach($_POST['schedule'] as $key=>$value)
				{		
					$day_id=$key;
					//$this->schedule_model->delete_row($day_id);
						foreach($value as $data)
						{
							if(!empty($data['from'])){
							$save = array(
										'doctor_id'=>$admin['id'],
										 'day'=>$day_id,
										 'timing_from'=>$data['from'], 
										 'timing_to'=>$data['to'],
										 'work'=>$data['work'],
										 'hospital'=>$data['hospital']
										 );
							//echo '<pre>'; print_r($save); die;
							if($this->schedule_model->update_schedule($save))
							{
							$this->session->set_flashdata('message',"Your Schedule is Updated!!");
							}
						}
				}
	}
	}
	$this->load->model('hospital_model');
	$data['hospital']=$this->hospital_model->get_all();
	$data['days']=$this->schedule_model->get_days();
	$data['fixed_schedule']=$this->schedule_model->get_all_fixed_schedule($this->session->userdata['admin']['id']);
	$data['body'] = 'schedule/edit';
	$this->load->view('template/main', $data);
	}	
	
	function edit_specific_schedule($id)
	{

	if($this->input->post('s1'))
	{ //echo '<pre>' ; print_r($_POST); die;
		$arr=array(
					'id'=>$this->input->post('id'),
					'work'=>$this->input->post('work'),
					'dates'=>$this->input->post('dates'),
					'timing_from'=>$this->input->post('timing_from'),
					'timing_to'=>$this->input->post('timing_to'),
					'hospital_id'=>$this->input->post('hospital')
					);
		if($this->schedule_model->edit_specific_schedule($this->session->userdata['admin']['id'],$arr))
		{
		$this->session->set_flashdata('message','Your Specific Schedule is Updated');
		redirect('admin/schedule/view_specific_schedule');
		}
	}
	$this->load->model('hospital_model');
	$data['hospital']=$this->hospital_model->get_all();
	$data['specific_schedule_details']=$this->schedule_model->specific_schedule_details($id);
	$data['body'] = 'schedule/edit_other_schedule';
	$this->load->view('template/main', $data);
	}
	
	function add()
	{
		$data['page_title'] = lang('add') . lang('appointment');
		$data['body'] = 'schedule/add';
		
		$this->load->view('template/main', $data);	
	}	
	
	
	
	function delete_specific_schedule($id)
	{
	
		if($this->schedule_model->delete_specific_schedule($id))
		{
		$this->session->set_flashdata('message','Sucessfully deleted!!');
		redirect('admin/schedule/view_specific_schedule');
		
		}
	}
	
	function select_weekly_monthly()
	{
		if($this->input->post('s1'))
		{
			$fixed_type=$this->input->post('fixed_type');
				if($fixed_type==1)
				{redirect('admin/schedule/edit_schedule');
				}
				else if($fixed_type==2){
				redirect('admin/schedule/monthly_schedule');}
		}
		$data['body'] = 'schedule/select';
		$this->load->view('template/main', $data);
	}
	
	function monthly_schedule()
	{
		
		if($this->input->post('s1'))
		{
		$admin=$this->session->userdata('admin');
		
		$this->schedule_model->delete_monthly_schedule($admin['id']);
		
		foreach($_POST['schedule'] as $key=>$value)
		{		
			 $day_id=$key; 
			//$this->schedule_model->delete_row($day_id);
				foreach($value as $data)
				{
					if(!empty($data['from'])){
					$save = array(
								'date_id'=>$day_id,
								'doctor_id'=>$this->session->userdata['admin']['id'],
								 'timing_from'=>$data['from'], 
								 'timing_to'=>$data['to'],
								 'work'=>$data['work'],
								 'hospital'=>$data['hospital']
								 );
					//echo '<pre>'; print_r($save); die;
					$this->schedule_model->monthly_schedule($save);
					
				}
					
		}
				
	}		
	
			$this->session->set_flashdata('message',"Your Monthly Schedule Entry is Saved!!");
			    redirect('admin/schedule/monthly_schedule');
		}
		$data['monthly_schedule']=$this->schedule_model->get_monthly_schedule($this->session->userdata['admin']['id']);
		//echo '<pre>'; print_r($data['monthly_schedule']); die;
		$this->load->model('hospital_model');
		$data['hospital']=$this->hospital_model->get_all();
		$data['body'] = 'schedule/edit_monthly_schedule';
		$this->load->view('template/main', $data);
	
	}
	
	function view_monthly_schedule()
	{
		$data['monthly_schedule']=$this->schedule_model->get_monthly_schedule($this->session->userdata['admin']['id']);
		$data['body'] = 'schedule/view_monthly_schedule';
		$this->load->view('template/main', $data);
	
	}
	
	
	
}