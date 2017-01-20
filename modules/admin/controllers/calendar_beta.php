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
        $data['todos'] = $this->to_do_list_model->get_to_do_by_doctor();
        $data['page_title'] = lang('event_calendar');
        $data['body'] = 'calendar/beta';
        $this->load->view('template/main', $data);
    }

    function move_event($id_raw) {
        $type = substr($id_raw, 0, 1);
        $id = substr($id_raw, 2);
        $time = $this->input->post('date');
        $date_unix = strtotime($time);
        $date = date('y-m-d H:i:00', $date_unix);
        $save['date'] = $date;
        if ($type == 'A') {
            $this->appointment_model->update($save, $id);
        } elseif ($type == 'T') {
            $this->to_do_list_model->update($save, $id);
        }
        echo 1;
    }

}
