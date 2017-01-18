<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payment_history
 *
 * @author kofoworola
 */
class payment_history extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model('prescription_model');
        $this->load->model('invoice_model');
        $this->load->model('setting_model');
    }

    public function index($id = false) {
        $data['payments'] = array();
        $admin = $this->session->userdata('admin');
        if (isset($_POST['search'])) {
            @$search = $_POST['search'];
            $data['payments'] = $this->prescription_model->get_payment_by_admin_filter($search);
            $data['search'] = $search;
        }
        else
        {
            $data['payments'] = $this->prescription_model->get_payment_by_admin();
        }
//        print_r($data['payments']);die();
        $data['businesses'] = $this->setting_model->get_all_setting();
        $data['page_title'] = lang('payment');
        $data['body'] = 'prescription/admin_payment';
        $this->load->view('template/main', $data);
    }

    public function export($search = false)
    {
        if(empty($search))
            $data['payments'] = $this->prescription_model->get_payment_by_admin();
        else
            $data['payments'] = $this->prescription_model->get_payment_by_admin_filter($search);
        $this->load->view('prescription/export', $data);
    }
}
