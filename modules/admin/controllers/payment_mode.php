<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment_mode extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->is_logged_in();
		$this->load->model("payment_mode_model");
		
	}
	
	
	function index(){
		$data['modes'] = $this->payment_mode_model->get_payment_mode_by_doctor();
		$data['page_title'] = lang('payment_mode');
		$data['body'] = 'payment_mode/list';
		$this->load->view('template/main', $data);	
	}	
	
	function add(){
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
			 
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
				
				$this->payment_mode_model->save($save);
                $this->session->set_flashdata('message', lang('payment_mode_created'));
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
		
		$data['mode'] = $this->payment_mode_model->get_payment_mode_by_id($id);
		$data['id'] =$id;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
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
				$this->payment_mode_model->update($save,$id);
        		$this->session->set_flashdata('message',lang('payment_mode_updated'));
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
			$this->payment_mode_model->delete($id);
			$this->session->set_flashdata('message',lang('payment_mode_deleted'));
			redirect('admin/payment_mode');
		}
	}	
		
	
}