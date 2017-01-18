<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my_prescription extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('dompdf_helper');
		$this->load->model("prescription_model");
		$this->load->model("patient_model");
		$this->load->model("medicine_model");
		$this->load->model("disease_model");
		$this->load->model("medical_test_model");
		$this->load->model('setting_model');
		$this->load->model('custom_field_model');
		$this->auth->is_logged_in();
	}
	
	
	function index(){
		$this->auth->check_access('2', true);
		$data['template']  = $this->prescription_model->get_template_patient();
		$data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
		$data['prescriptions'] = $this->prescription_model->get_prescription_by_patient();
		$data['fields'] = $this->custom_field_model->get_custom_fields(5);
		
		$data['page_title'] = lang('prescription');
		$data['body'] = 'my_prescription/list';
		$this->load->view('template/main', $data);	

	}	
	
	function view($id){
		$data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
		///echo '<pre>'; print_r($data['prescription']);die;
		$data['body'] = 'my_prescription/view';
		$this->load->view('template/main', $data);	
	}
	
	
	function view_all_reports(){
		$this->auth->check_access('2', true);
		
		
		$data['reports'] = $this->prescription_model->get_reports_notification();
		
		$data['page_title'] = lang('reports');
		$data['body'] = 'prescription/view_all_reports';
		$this->load->view('template/main', $data);	

	}	

	
	
	
	
	function pdf($id){
		$data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
		$data['setting']   = $this->setting_model->get_setting();	
		$html = $this->load->view('prescription/pdf', $data, true);	
		pdf_create($html, 'Prescription_'.$data['prescription']->patient);
	}
	
	function fees($id){
		$this->auth->check_access('2', true);
		$data['priscrition']			= $this->prescription_model->get_prescription_by_id($id);
		$data['payment_modes']			= $this->prescription_model->get_all_payment_modes();
		$data['fees_all']				= $this->prescription_model->get_fees_all($id);
		$data['id'] 					= $id;
				
		
		$data['body'] = 'my_prescription/fees';
		$this->load->view('template/main', $data);
	}	
	
	
	
	function reports($id){
		$data['id'] = $id;
		$this->prescription_model->report_is_view_by_user($id);
		$data['reports'] 	 = $this->prescription_model->get_reports_by_id($id);
		$data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
		$admin = $this->session->userdata('admin');
		$access = $admin['user_role'];
			
			if ($this->input->server('REQUEST_METHOD') === 'POST')
			{	
				$this->load->library('form_validation');
				$this->form_validation->set_rules('remark', 'lang:remark', 'required');
				$this->form_validation->set_message('required', lang('custom_required'));
				 
				if ($this->form_validation->run()==true)
				{
					if($_FILES['file'] ['name'] !='')
					{ 
						
					
						$config['upload_path'] = './assets/uploads/files/';
						$config['allowed_types'] = '*';
						$config['max_size']	= '10000';
						$config['max_width']  = '10000';
						$config['max_height']  = '6000';
				
						$this->load->library('upload', $config);
				
						if ( !$img = $this->upload->do_upload('file'))
							{
								
							}
							else
							{
								$img_data = array('upload_data' => $this->upload->data());
								$save['file'] = $img_data['upload_data']['file_name'];
							}
						
					}	
				
					$save['prescription_id'] = $id;
					$save['from_id'] = $admin['id'];
					
					if($admin['user_role']==2){
						$save['to_id'] = $data['prescription']->doctor_id;
					}else{
						$save['to_id'] = $data['prescription']->patient_id;
					}
					$save['remark'] = $this->input->post('remark');
					$this->prescription_model->save_report($save);
					$this->session->set_flashdata('message', lang('report_saved'));
					redirect('admin/prescription/reports/'.$id);
					
				}
			}		
		
		$data['page_title'] = lang('prescription');
		$data['body'] = 'prescription/reports';
		$this->load->view('template/main', $data);	

	}	
	
	function delete($id=false){
		$this->auth->check_access('1', true);
		
		if($id){
			$this->prescription_model->delete($id);
			$this->session->set_flashdata('message',lang('prescription_deleted'));
			redirect('admin/prescription');
		}
	}	
		
	
}
