<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class calendar_beta extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model("appointment_model");
        $this->load->model("to_do_list_model");
    }


    function index() {
        $admin = $this->session->userdata('admin');
        $data['appointments'] = $this->appointment_model->get_appointment_by_doctor($admin['id']);
        $data['page_title'] = lang('event_calendar');
        $data['body'] = 'calendar/beta';
        $this->load->view('template/main', $data);
    }

}
