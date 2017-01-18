<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class instruction extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->auth->check_access('Admin', true);
		
		$this->auth->is_logged_in();	
		$this->load->model("instruction_model");
		$this->load->model("medicine_category_model");
		$this->load->model("manufacturing_company_model");
		$this->load->model("medicine_model");
		$this->load->model("doctor_model");
	}
	
	
	function index(){
		
		$admin = $this->session->userdata('admin');
		if($admin['user_role']=="Admin"){
			$data['tests'] = $this->instruction_model->get_all();
		}
		if($admin['user_role']==1 || $admin['user_role']==3){
			$data['tests'] = $this->instruction_model->get_instruction_by_doctor();
		}	
		$data['page_title'] = lang('instruction');
		$data['body'] = 'instruction/list';
		$this->load->view('template/main', $data);	

	}	
	
	function add(){
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_rules('type', 'lang:type', 'required');
			 
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
				$save['type'] = $this->input->post('type');
			   
				$this->instruction_model->save($save);
                $this->session->set_flashdata('message', lang('instruction_saved'));
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
		$data['instruction'] = $this->instruction_model->get_instruction_by_id($id);
		
		$data['id'] =$id;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_rules('type', 'lang:type','' );
			 
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
				$save['type'] = $this->input->post('type');
				
				$this->instruction_model->update($save,$id);
                $this->session->set_flashdata('message', lang('instruction_updated'));
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

		if($admin['user_role']==1){
			if($data['instruction']->doctor_id!=$admin['id']){
				 $this->session->set_flashdata('error', lang('invalid'));
				redirect('admin/dashboard');
			}	
		}	
		
		
	}	
	
	
	
	
	function view($id=false){
		$admin = $this->session->userdata('admin');
		$data['instruction'] = $this->instruction_model->get_instruction_by_id($id);
		$data['id'] =$id;
		
		if($admin['user_role']==1){
			if($data['instruction']->doctor_id!=$admin['id']){
				 $this->session->set_flashdata('error', lang('invalid'));
				redirect('admin/dashboard');
			}	
		}	
		$data['page_title'] = lang('view') . lang('instruction');
		$data['body'] = 'instruction/view';
		$this->load->view('template/main', $data);	

	}	
	
	
	
	function delete($id=false){
		
		if($id){
			$this->instruction_model->delete($id);
			$this->session->set_flashdata('message',lang('instruction_deleted'));
			redirect('admin/instruction');
		}
	}	
		
	
}
