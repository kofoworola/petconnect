<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notification extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->auth->check_access('1', true);
		//$this->auth->is_logged_in();
		$this->load->model("notification_model");
		
		
	}
	
	

	function index(){
		
		$admin = $this->session->userdata('admin');
		$data['settings'] = $this->notification_model->get_setting($admin['id']);
		
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('appointment', 'lang:case_alert_days', 'required');
			$this->form_validation->set_message('required', lang('custom_required'));
			 
			if ($this->form_validation->run()==true)
            {
				
				//$save['doctor_id'] = $admin['id'];
				$save['to_do_alert'] = $this->input->post('to_do');
				$save['appointment_alert'] = $this->input->post('appointment');
				$save['schedule'] = $this->input->post('schedule');
				
			
				$this->notification_model->update($save);
                $this->session->set_flashdata('message', lang('notification_settings_updated'));
				redirect('admin/notification');
			}
		
		}
		
		$data['page_title'] = lang('notification') . lang('settings');
		$data['body'] = 'notification/notification';
		$this->load->view('template/main', $data);	

			
	}
	
		
	
}