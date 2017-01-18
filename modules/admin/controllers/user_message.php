<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . '/third_party/Twilio/autoload.php';

use Twilio\Rest\Client;

class user_message extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("act_model");
        $this->load->model("assistant_model");
        $this->load->model("message_model");
        $this->load->model("setting_model");
        $this->load->model("user_model");
    }

    function index() {
        $this->auth->check_access('1', true);
        $data['clients'] = $this->assistant_model->get_assistants_by_doctor();
        //print_r($data['clients']);die();
        $data['page_title'] = lang('message');
        $data['body'] = 'message/user';
        $this->load->view('template/main', $data);
    }

    function messages() {
        $this->auth->check_access('3', true);
        $data['clients'] = $this->assistant_model->get_users_by_assistant();
        $data['page_title'] = lang('message');
        $data['body'] = 'message/user';
        $this->load->view('template/main', $data);
    }

    function send($id = false) {

        $data['setting'] = $this->setting_model->get_setting();
        $this->message_model->message_is_view_by_admin($id);
        $data['patient'] = $patient = $this->message_model->get_patient_by_id($id);
        $data['messages'] = $this->message_model->get_message_by_id($id);
        $data['id'] = $id;
        $number = $patient->contact;
        $admin = $this->session->userdata('admin');
        $user_id = '';
        if ($admin['user_role'] == 1) {
            $user_id = $admin['id'];
        } else if ($admin['user_role'] == 3) {
            $user_id = $admin['doctor_id'];
        }
        $admin_user = $this->user_model->get_user_by_id($user_id);
        $twillo_id = $admin_user->twillo_id;
        $twillo_auth = $admin_user->twillo_auth;
        $message_id = $admin_user->message_id;


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('message', 'lang:message', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if (isset($_FILES['file'] ['name'])) {
                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {
                        echo 'failed';
                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                        echo "done";
                    }
                }

                $save['from_id'] = $admin['id'];
                $save['to_id'] = $id;
                $save['message'] = $this->input->post('message');
                $save['is_view_to'] = 1;

                $this->message_model->save_user_message($save);

                $this->load->library('email');
                $this->load->helper('string');
                /* $config = array(
                  'protocol' => "smtp",
                  'smtp_host' => "ssl://smtp.gmail.com",
                  'smtp_port' => "465",
                  'smtp_user' => "",
                  'smtp_pass' => "",
                  'charset' => "utf-8",
                  'mailtype' => "html",
                  'newline' => "\r\n"
                  ); */
                $config['mailtype'] = 'html';
                $config['charset'] = 'utf-8';


                $this->load->library('email', $config);

                $this->email->initialize($config);
                $this->email->from($admin_user->email, 'Message');
                $this->email->to($data['patient']->email);
                $this->email->subject('Message From Doctor');
                $this->email->message(html_entity_decode($save['message'], ENT_QUOTES, 'UTF-8'));
                $sent = $this->email->send();

                $account_sid = $twillo_id;
                $auth_token = $twillo_auth;


                $this->session->set_flashdata('message', lang('message_sent'));

                if ($this->input->post('sms') == 'yes') {
                    try {
                        $client = new Client($account_sid, $auth_token);
                        $client->messages->create(
                                $number, array(
                            'messagingServiceSid' => $message_id,
                            'body' => $save['message']
                                )
                        );
                    } catch (\Twilio\Exceptions\TwilioException $e) {
                        $this->session->set_flashdata('error', "Couldn't send sms :" . $e->getMessage());
                    }
                }


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
        $admin = $this->session->userdata('admin');
        if ($id) {
            $this->message_model->delete_user_message($id);
            $this->session->set_flashdata('message', lang('message_deleted'));
            if ($admin['user_role'] == 1) {
                redirect('admin/user_message');
            } elseif ($admin['user_role'] == 1) {
                redirect('admin/user_message/messages');
            }
        }
    }

}
