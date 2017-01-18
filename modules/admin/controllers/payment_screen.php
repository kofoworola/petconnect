<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payment_screen
 *
 * @author kofoworola
 */
class payment_screen extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('setting_model');
    }

    function index() {
        $data['users'] = $this->user_model->get_all_users();
        $data['page_title'] = lang('payment');
        $data['body'] = 'users/payment';
        $this->load->view('template/main', $data);
    }

    function update($id = false) {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            
            $users = $this->user_model->get_all_users();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('stripe_secret', 'Secret Key', 'required');
            $this->form_validation->set_rules('stripe_publish', 'Publishable Key', 'required');
            $this->form_validation->set_rules('start_invoice','Starting invoive number' ,'required|numeric');

            if ($this->form_validation->run()) {
                $save['stripe_secret'] = $this->input->post('stripe_secret');
                $save['stripe_publish'] = $this->input->post('stripe_publish');
                $save['start_invoice'] = $this->input->post('start_invoice');
                $save['acess_token'] = $this->input->post('acess_token');
                
                $p_key = $this->user_model->save($save, $id);
                
                $this->session->set_flashdata('message', lang('payment_saved'));

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
