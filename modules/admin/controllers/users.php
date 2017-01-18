<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author kofoworola
 */
class users extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->check_access('Admin', true);
        $this->load->model("user_model");
        $this->load->model("invoice_model");
        $this->load->model("setting_model");
        $this->load->model("custom_field_model");
        $this->load->library('form_validation');
    }

    function index() {
        $data['users'] = $this->user_model->get_all_users();
        $data['fields'] = $this->custom_field_model->get_custom_fields(1);
        $data['page_title'] = lang('clients');
        $data['body'] = 'users/list';
        $this->load->view('template/main', $data);
    }

    function add() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $this->load->helper('string');
            $this->load->library('email');
            $this->load->library('form_validation');

            $users = $this->user_model->get_all_users();
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_message('is_unique', 'This %s already exists.');
            $this->form_validation->set_rules('business_name', 'Business Name', 'required');
            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('user_type', 'User Type', 'required');
            $this->form_validation->set_rules('lname', "Last Name", 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('contact', "Phone Number", 'required');
            $this->form_validation->set_rules('address', "Address", 'required');

            if ($this->form_validation->run() == true) {
                
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');
                $username = $this->user_model->generate_username($fname, $lname);
                $email = $this->input->post('email');
                $save['name'] = $fname . " " . $lname;
                $save['email'] = $email;
                $save['username'] = $username;
                $password = random_string('alnum', '8');
                $save['password'] = sha1($password);
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['user_role'] = 1;
                $save['user_type'] = $this->input->post('user_type');

                $p_key = $this->user_model->add($save);
                $business_name = $this->input->post('business_name');
                $save_business['name'] = $business_name;
                $save_business['doctor_id'] = $p_key;
                $this->setting_model->update_by_id($save_business,$p_key);
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $p_key,
                            'form' => 1,
                        );
                    }
                    $this->custom_field_model->save_answer($save_fields);
                }
                $this->email->from('test@petconnectpro.com', 'PetConnectPro');
                $this->email->to($email);
                $this->email->cc('okesolakofo@gmail.com');

                $this->email->subject('Email Test');
                $this->email->message("Your username is ".$username." \n And your password is ".$password.'');

                $this->email->send();
                
                $this->session->set_flashdata('message', lang('business_saved'));

                
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

    function edit($id = false) {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');

            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'required|trim|valid_email|max_length[128]');
            $this->form_validation->set_rules('username', 'lang:username', 'trim|required|');
            $this->form_validation->set_rules('contact', 'lang:phone', 'required');
            if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id) {
                $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
                $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
            }

            if ($this->form_validation->run()) {

                $save['name'] = $this->input->post('name');
                $save['email'] = $this->input->post('email');
                $save['username'] = $this->input->post('username');
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['user_role'] = 1;
                $save['user_type'] = $this->input->post('user_type');

                if ($this->input->post('password') != '' || !$id) {
                    $save['password'] = sha1($this->input->post('password'));
                }

                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 1,
                        );
                    }
                    $this->custom_field_model->delete_answer($id, $form = 1);
                    $this->custom_field_model->save_answer($save_fields);
                }

                $this->user_model->update($save, $id);
                $business_name = $this->input->post('business_name');
                $save_business['name'] = $business_name;
                $save_business['doctor_id'] = $id;
                $this->setting_model->update_by_id($save_business,$id);
                $this->session->set_flashdata('message', lang('business_updated'));

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

    function delete($id = false) {
        if ($id) {
            $this->user_model->delete($id);
            $this->session->set_flashdata('message', lang('business_deleted'));
            $this->setting_model->delete_setting_by_id($id);
            redirect('admin/users');
        }
    }

}
