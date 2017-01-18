<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class disease extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->auth->check_access('Admin', true);
		$this->auth->is_logged_in();
		$this->load->model("disease_model");
	}
	
	
	function index(){
		$admin = $this->session->userdata('admin');
		if($admin['user_role']=="Admin"){
			$data['diseases'] = $this->disease_model->get_all();
		}
		if($admin['user_role']==1||$admin['user_role']==3){
			$data['diseases'] = $this->disease_model->get_disease_by_doctor();
		}	
		$data['page_title'] = lang('disease');
		$data['body'] = 'disease/list';
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
				$save['description'] = $this->input->post('description');
			   
				$this->disease_model->save($save);
                $this->session->set_flashdata('message', lang('disease_saved'));
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
		
		$data['disease'] = $this->disease_model->get_disease_by_id($id);
		$admin = $this->session->userdata('admin');
		$data['id'] =$id;
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			 
			if ($this->form_validation->run()==true)
            {
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
				$save['description'] = $this->input->post('description');
				
				$this->disease_model->update($save,$id);
                $this->session->set_flashdata('message', lang('disease_updated'));
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
			$this->disease_model->delete($id);
			$this->session->set_flashdata('message',lang('disease_deleted'));
			redirect('admin/disease');
		}
	}	
		
	
}