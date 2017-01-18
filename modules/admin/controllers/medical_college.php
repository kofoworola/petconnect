<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class medical_college extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();
		$this->load->model("medical_college_model");
		$this->load->model("schedule_model");
		$this->load->library('form_validation');
	}
	
	
	function index(){
		$admin = $this->session->userdata('admin');
		if($admin['user_role']=="Admin"){
			$data['tests'] = $this->medical_college_model->get_all();
		}else{
			$data['tests'] = $this->medical_college_model->get_medical_college_by_doctor();
		}
		$data['page_title'] = lang('medical_college');
		$data['body'] = 'medical_college/list';
		$this->load->view('template/main', $data);	

	}	
	
	
	function view($id=false){
		$data['id']=$id;
		$data['college'] = $this->medical_college_model->get_medical_college_by_id($id);
	
		$admin = $this->session->userdata('admin');
		
		if($admin['user_role']==1){
			if($data['college']->doctor_id!=$admin['id']){
				 $this->session->set_flashdata('error', lang('invalid'));
				redirect('admin/dashboard');
			}
		}
		$data['page_title'] = lang('view') . lang('medical_college');
		$data['body'] = 'medical_college/view';
		$this->load->view('template/main', $data);	

	}	
	function select_medical_college($view=false){
		$data['colleges'] = $this->medical_college_model->get_medical_college_by_doctor();
		$view = $this->uri->segment(4);
		$data['view']=$view;
		if($view=="view"){
			//$this->session->set_userdata();
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{	
				$this->load->library('form_validation');
				$this->form_validation->set_message('required', lang('custom_required'));
				$this->form_validation->set_rules('college_id', 'lang:medical_college', 'required');
				
				if ($this->form_validation->run()==true)
				{
					$id = $this->input->post('college_id');
					redirect('admin/medical_college/manage_schedule/'.$id);
				}
				
			}
		
		}else{
	 		if ($this->input->server('REQUEST_METHOD') === 'POST')
			{	
				$this->load->library('form_validation');
				$this->form_validation->set_message('required', lang('custom_required'));
				$this->form_validation->set_rules('college_id', 'lang:medical_college', 'required');
				
				if ($this->form_validation->run()==true)
				{
					$id = $this->input->post('college_id');
					
					redirect('admin/medical_college/add_schedule/'.$id);
				}
				
			}
		}	
		
		$data['page_title'] = lang('Add') .' '.lang('schedule');
		$data['body'] = 'medical_college/select_medical_college';
		$this->load->view('template/main', $data);
	
	}
	
	function add(){
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			 
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
	       
			if ($this->form_validation->run()==true)
            {
			
				$admin = $this->session->userdata('admin');
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
				$save['phone'] = $this->input->post('phone');
				$save['address'] = $this->input->post('address');
			    
				$p_key = $this->medical_college_model->save($save);
				
				$this->session->set_flashdata('message', lang('medical_college_saved'));
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
	

	
	function edit($id=false){
		$data['id']=$id;
		$data['college'] = $this->medical_college_model->get_medical_college_by_id($id);
		$admin = $this->session->userdata('admin');
		if($admin['user_role']==1){
			if($data['college']->doctor_id!=$admin['id']){
				 $this->session->set_flashdata('error', lang('invalid'));
				redirect('admin/dashboard');
			}
		}
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			if ($this->form_validation->run())
            {
			
				
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
				$save['phone'] = $this->input->post('phone');
				$save['address'] = $this->input->post('address');
				$this->medical_college_model->update($save,$id);
                $this->session->set_flashdata('message', lang('medical_college_updated'));
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
	
	function delete($id=false){
		
		if($id){
			$this->medical_college_model->delete($id);
			$this->session->set_flashdata('message',lang('medical_college_deleted'));
			redirect('admin/medical_college');
		}
	}	
	
	
	
	
	function add_schedule($id){
		$data['h_id'] = $id;
		$data['days']=$this->schedule_model->get_days();	
		$data['schedule']=$this->schedule_model->get_schedule_by_id($id);
		$data['fixed_schedule']=$this->schedule_model->get_all_fixed_schedule_for_medical($id);
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('work', 'lang:name', '');
			
			if ($this->form_validation->run()==true)
            {
				$admin = $this->session->userdata('admin');	
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['day'] = $this->input->post('day_id');
				$save['timing_from'] = date("H:i",strtotime($this->input->post('start')));
				$save['timing_to'] = date("H:i",strtotime($this->input->post('end')));
				$save['work'] = $this->input->post('work');
				
				$save['hospital'] = $id;
				$save['type'] = 2;
				//echo '<pre>'; print_r($save);die;
				if($this->schedule_model->save_schedule($save))
				{
				$this->session->set_flashdata('message', lang('sechdule_saved'));
				redirect('admin/medical_college/add_schedule/'.$id);
				}
                
			}
			
		}
		$data['page_title'] = lang('add') . lang('schedule');
		$data['body'] = 'medical_college/add_schedule';
		$this->load->view('template/main', $data);	

	}
	
	
	function edit_schedule($id,$h_id){
		$data['days']=$this->schedule_model->get_days();	
		$data['schedule']=$this->schedule_model->get_schedule_by_id_m($id);
		//echo '<pre>'; print_r($data['schedule']);die;
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('work', 'lang:name', '');
			
			if ($this->form_validation->run()==true)
            {
				$admin = $this->session->userdata('admin');	
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['day'] = $this->input->post('day_id');
				$save['timing_from'] = date("H:i",strtotime($this->input->post('start')));
				$save['timing_to'] = date("H:i",strtotime($this->input->post('end')));
				$save['work'] = $this->input->post('work');
				$save['hospital'] = $data['schedule']->h_id;
				$save['type'] = 2;
				
				
				if($this->schedule_model->edit_schedule($save,$id))
				{
				$this->session->set_flashdata('message', lang('sechdule_saved'));
				redirect('admin/medical_college/add_schedule/'.$h_id);
				}
                
			}
			
		}
		$data['page_title'] = lang('edit') . lang('schedule');
		$data['body'] = 'medical_college/edit_schedule';
		$this->load->view('template/main', $data);	

	}	
	
	function edit_schedule_manage($id,$h_id){
		$data['days']=$this->schedule_model->get_days();	
		$data['schedule']=$this->schedule_model->get_schedule_by_id_m($id);
		//echo '<pre>'; print_r($data['schedule']);die;
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('work', 'lang:name', '');
			
			if ($this->form_validation->run()==true)
            {
			$admin = $this->session->userdata('admin');	
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['day'] = $this->input->post('day_id');
				$save['timing_from'] = date("H:i",strtotime($this->input->post('start')));
				$save['timing_to'] = date("H:i",strtotime($this->input->post('end')));
				$save['work'] = $this->input->post('work');
				$save['hospital'] = $data['schedule']->h_id;
				$save['type'] = 2;
				
				
				if($this->schedule_model->edit_schedule($save,$id))
				{
				$this->session->set_flashdata('message', lang('sechdule_saved'));
				redirect('admin/medical_college/manage_schedule/'.$h_id);
				}
                
			}
			
		}
		$data['page_title'] = lang('edit') . lang('schedule');
		$data['body'] = 'medical_college/edit_schedule';
		$this->load->view('template/main', $data);	

	}	

	
	
	function manage_schedule($id){
		$data['days']=$this->schedule_model->get_days();	
		$data['schedule']=$this->schedule_model->get_schedule_by_id($id);
		$data['fixed_schedule']=$this->schedule_model->get_all_fixed_schedule_for_medical($id);
		
		$data['page_title'] = lang('manage') . lang('schedule');
		$data['body'] = 'medical_college/manage_schedule';
		$this->load->view('template/main', $data);	

	}	
	
	  
	  
	  
	function delete_week_schedule($id,$h_id=false)
	{
		if($id)
		{
			$this->schedule_model->delete_week_schedule($id);
			
			$this->session->set_flashdata('message',"schedule_deleted");
			redirect('admin/medical_college/add_schedule/'.$h_id);
			
		}
	}
	
	function delete_week_schedule_manage($id,$h_id=false)
	{
		if($id)
		{
			$this->schedule_model->delete_week_schedule($id);
			
			$this->session->set_flashdata('message',"schedule_deleted");
			redirect('admin/medical_college/manage_schedule/'.$h_id);
			
		}
	}
		
	
}
