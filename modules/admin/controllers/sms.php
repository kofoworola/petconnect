<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sms
 *
 * @author kofoworola
 */
class sms extends MX_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('setting_model');
    }

    function index() {
        $data['users'] = $this->user_model->get_all_users();
        $data['page_title'] = lang('sms');
        $data['body'] = 'users/sms';
        $this->load->view('template/main', $data);
    }

    function update($id = false) {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
             
            $this->load->library('form_validation');
            $this->form_validation->set_rules('twillo_id', 'Twillo ID', 'required');
            $this->form_validation->set_rules('twillo_auth','Authentication Token' ,'required');
            $this->form_validation->set_rules('message_id','Messaging Service Id' ,'required');

            if ($this->form_validation->run()) {
                $save['twillo_id'] = $this->input->post('twillo_id');
                $save['twillo_auth'] = $this->input->post('twillo_auth');
                $save['message_id'] = $this->input->post('message_id');
                
                $p_key = $this->user_model->save($save, $id);
                
                $this->session->set_flashdata('message', lang('sms_saved'));

                echo 1;
            } else {

                echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>' . validation_errors() . '
											</div>
				';
            }
        }
    }
}
