<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class logs extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);
        $this->load->model("setting_model");
        $this->load->model("custom_field_model");
        $this->load->library('form_validation');
        $this->load->library('log');
    }
    
    function index()
    {
        if(isset($_POST['date']))
        {
            $date = $_POST['date'];
            $data['text'] = $this->log->read_log($date);
        }
        else
        {
            $data['text'] = $this->log->read_log();
        }
        $data['page_title'] = lang('logs'); 
        $data['body'] = 'logs/index';
        $this->load->view('template/main', $data);
    }
}
