<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class template extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //$this->auth->check_access('1', true);
        //$this->auth->is_logged_in();
        $this->load->model("notification_model");
    }

    function index() {

        $admin = $this->session->userdata('admin');
        $data['template'] = $this->notification_model->get_template();


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('header', 'header', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {

                $save['doctor_id'] = $admin['id'];
                $save['header'] = $this->input->post('header');
                $save['footer'] = $this->input->post('footer');


                $this->notification_model->update_template($save);
                $this->session->set_flashdata('message', lang('prescription_template_updated'));
                redirect('admin/template');
            }
        }

        $data['page_title'] = lang('manage_prescription');
        $data['body'] = 'prescription_template/template';
        $this->load->view('template/main', $data);
    }

}
