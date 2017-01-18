<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class medical_test extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();
		//$this->auth->check_access('Admin', true);
		$this->load->model("medical_test_model");
		$this->load->library('form_validation');
	}
	
	
	function index(){
		$admin = $this->session->userdata('admin');
		if($admin['user_role']=="Admin"){
			$data['tests'] = $this->medical_test_model->get_all();
		}
		if($admin['user_role']==1||$admin['user_role']==3){
			$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
		}
			
		$data['page_title'] = lang('medical_test');
		$data['body'] = 'medical_test/list';
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
			    
				$p_key = $this->medical_test_model->save($save);
				$this->session->set_flashdata('message', lang('medical_test_saved'));
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
		$data['test'] = $this->medical_test_model->get_medical_test_by_id($id);
	
		$admin = $this->session->userdata('admin');
		if($admin['user_role']==1){
			if($data['test']->doctor_id!=$admin['id']){
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
			
				
				$admin = $this->session->userdata('admin');	
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
				$this->medical_test_model->update($save,$id);
                $this->session->set_flashdata('message', lang('medical_test_updated'));
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
			$this->medical_test_model->delete($id);
			$this->session->set_flashdata('message',lang('medical_test_deleted'));
			redirect('admin/medical_test');
		}
	}	
		
	
}