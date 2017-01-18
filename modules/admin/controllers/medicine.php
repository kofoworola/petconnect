<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class medicine extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->auth->check_access('Admin', true);
		$this->auth->is_logged_in();	
		$this->load->model("medicine_category_model");
		$this->load->model("manufacturing_company_model");
		$this->load->model("medicine_model");
		$this->load->model("doctor_model");
	}
	
	
	function index(){
		$admin = $this->session->userdata('admin');
		if($admin['user_role']=="Admin"){
			$data['medicines'] = $this->medicine_model->get_all();
		}
		if($admin['user_role']==1 || $admin['user_role']==3){
			$data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
		}
		
		if($admin['user_role']==1 || $admin['user_role']==3){
			$data['category'] = $this->medicine_category_model->get_medicine_categoory_by_doctor();
			$data['company'] = $this->manufacturing_company_model->get_manufacturing_company_by_doctor();
		}else{
			$data['category'] = $this->medicine_category_model->get_all();
			$data['company'] = $this->manufacturing_company_model->get_all();
			$data['doctors'] = $this->doctor_model->get_all();
		}	
		$data['page_title'] = lang('medicine');
		$data['body'] = 'medicine/list';
		$this->load->view('template/main', $data);	

	}	
	
	function add(){
		$data['category'] = $this->medicine_category_model->get_medicine_categoory_by_doctor();
		$data['company'] = $this->manufacturing_company_model->get_manufacturing_company_by_doctor();
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_rules('category_id', 'lang:medicine_category', 'required');
			$this->form_validation->set_rules('price', 'lang:price','' );
			 
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
				$save['category_id'] = $this->input->post('category_id');
				$save['company_id'] = $this->input->post('company_id');
				$save['description'] = $this->input->post('description');
				$save['price'] = $this->input->post('price');
				$save['status'] = $this->input->post('status');
			   
				$this->medicine_model->save($save);
                $this->session->set_flashdata('message', lang('medicine_saved'));
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
		$admin = $this->session->userdata('admin');
		$data['medicine'] = $this->medicine_model->get_medicine_by_id($id);
		if($admin['user_role']==1 || $admin['user_role']==3){
			$data['category'] = $this->medicine_category_model->get_medicine_categoory_by_doctor();
			$data['company'] = $this->manufacturing_company_model->get_manufacturing_company_by_doctor();
		}else{
			$data['category'] = $this->medicine_category_model->get_all();
			$data['company'] = $this->manufacturing_company_model->get_all();
			$data['doctors'] = $this->doctor_model->get_all();
		}
			
		$data['id'] =$id;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_message('required', lang('custom_required'));
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_rules('category_id', 'lang:medicine_category', 'required');
			$this->form_validation->set_rules('price', 'lang:price','' );
			 
			if ($this->form_validation->run()==true)
            {
				
				if($admin['user_role']==1){
					$save['doctor_id'] = $admin['id'];
				   }
				  if($admin['user_role']==3){
					$save['doctor_id'] = $admin['doctor_id'];
				   }
				$save['name'] = $this->input->post('name');
				$save['category_id'] = $this->input->post('category_id');
				$save['company_id'] = $this->input->post('company_id');
				$save['description'] = $this->input->post('description');
				$save['price'] = $this->input->post('price');
				$save['status'] = $this->input->post('status');
				
				$this->medicine_model->update($save,$id);
                $this->session->set_flashdata('message', lang('medicine_updated'));
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
	
	
	
	
	function view($id=false){
		$admin = $this->session->userdata('admin');
		$data['medicine'] = $this->medicine_model->get_medicine_by_id($id);
		if($admin['user_role']==1){
			$data['category'] = $this->medicine_category_model->get_medicine_categoory_by_doctor();
			$data['company'] = $this->manufacturing_company_model->get_manufacturing_company_by_doctor();
		}else{
			$data['category'] = $this->medicine_category_model->get_all();
			$data['company'] = $this->manufacturing_company_model->get_all();
			$data['doctors'] = $this->doctor_model->get_all();
		}
		
		$data['id'] =$id;
		
		if($admin['user_role']==1){
			if($data['medicine']->doctor_id!=$admin['id']){
				 $this->session->set_flashdata('error', lang('invalid'));
				redirect('admin/dashboard');
			}	
		}	
		$data['page_title'] = lang('view') . lang('medicine');
		$data['body'] = 'medicine/view';
		$this->load->view('template/main', $data);	

	}	
	
	
	
	function delete($id=false){
		
		if($id){
			$this->medicine_model->delete($id);
			$this->session->set_flashdata('message',lang('medicine_deleted'));
			redirect('admin/medicine');
		}
	}	
		
	
}