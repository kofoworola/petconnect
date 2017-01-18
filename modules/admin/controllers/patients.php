<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class patients extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        //$this->auth->check_access('1', true);
        $this->load->model("patient_model");
        $this->load->model("notes_model");
        $this->load->model("custom_field_reply_model");
        $this->load->model("contact_model");
        $this->load->model("prescription_model");
        $this->load->model("setting_model");
        $this->load->model("custom_field_model");
        $this->load->model("invoice_model");
        $this->load->model("medical_test_model");
        $this->load->model("notification_model");
        $this->load->model("medicine_model");
        $this->load->model("disease_model");
        $this->load->model("instruction_model");
        $this->load->model("payment_mode_model");
        $this->load->model("appointment_model");
        $this->load->model("case_history_model");

        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('log');
    }

    function index() {

        $admin = $this->session->userdata('admin');
        //$username = $this->patient_model->get_username();
        //echo '<pre>'; print_r($username);die;
        $data['user'] = 'test';
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Patient1";
        } else {

            $val = strlen($admin['id']) + 7;

            $sub_str = substr($username->username, $val);

            $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
            //echo '<pre>';            print_r($data);die;
        }
        //echo '<pre>'; print_r($_POST);die;	

        @$search = $_POST['search'];
        @$filter_id = $_POST['filter_id'];

        $data['patients'] = $this->patient_model->get_patients_by_doctor_filter($search, $filter_id);

        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['page_title'] = lang('patients');
        $data['body'] = 'patients/list';
        $data['bodyboy'] = 'duff';
        $this->load->view('template/main', $data);
    }

    function view($id = false, $tab = false) {

        $data = array();
        $data['tab'] = $tab;
        $data['id'] = $id;
        $admin = $this->session->userdata('admin');
        $data['user'] = $admin;
        $data['patients'] = $this->patient_model->get_patients_by_doctor();  //patients
        $data['contacts'] = $this->patient_model->get_patients_by_doctor(); //patients
        $data['contact'] = $this->contact_model->get_contact_by_doctor(); //contacts
        $data['appointments'] = $this->appointment_model->get_appointment_by_patient($id);
        $data['notes'] = $this->notes_model->get_notes_by_patient($id);
        $data['reports'] = $this->prescription_model->get_reports_by_id($id);
        $data['pay_details'] = $details = $this->prescription_model->get_payment_details($admin['id']);
        $data['patient'] = $this->patient_model->get_patient_by_id($id);
        $data['prescriptions'] = $this->patient_model->get_patients_by_medication($id);
        $data['payment_modes'] = $this->payment_mode_model->get_payment_mode_by_doctor();
        $data['setting'] = $this->setting_model->get_setting();
        $pre_id = $this->prescription_model->get_prescription_id();
        //echo '<pre>'; print_r($pre_id);die;
        if (empty($pre_id) || $pre_id->prescription_id == 0) {
            $data['pre_id'] = 1001;
        } else {

            $data['pre_id'] = $pre_id->prescription_id + 1;
        }




        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }


        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['template'] = $this->notification_model->get_template();
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();
        if ($invoice->invoice == 0) {
            $dr_invoice = $this->invoice_model->get_doctor_invoice_number();
            if (empty($dr_invoice->invoice)) {
                $data['i_no'] = 1;
            } else {
                $data['i_no'] = $dr_invoice->invoice;
            }
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }
        //echo '<pre>'; print_r($data['prescriptions']);die;
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['fees_all'] = $this->patient_model->get_patients_by_invoice($id);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['body'] = 'patients/view_tabs';
        $this->load->view('template/main', $data);
    }

    function reports($pre_id) {
        $data['pre_id'] = $pre_id;
        $data['patients'] = $this->patient_model->get_patients_by_doctor();  //patients
        $data['reports'] = $this->prescription_model->get_reports_by_id($pre_id);

        $data['prescriptions'] = $this->patient_model->get_patients_by_medication($id);
        //echo '<pre>'; print_r($data['prescriptions']);die;	
        $data['body'] = 'patients/reports';
        $this->load->view('template/main', $data);
    }

    function view_report($id) {
        $data['report'] = $this->prescription_model->get_report_by_id($id);
        $data['body'] = 'patients/report';
        $this->load->view('template/main', $data);
    }

    function patient() {
        $admin = $this->session->userdata('admin');

        //echo '<pre>'; print_r($data['username']);die;	
        $data['patients'] = $this->patient_model->get_patients_by_assistant();
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['page_title'] = lang('patients');
        $data['body'] = 'patients/list';
        $this->load->view('template/main', $data);
    }

    function export() {
        $data['patients'] = $this->patient_model->get_patients_by_doctor();
        $this->load->view('patients/export', $data);
    }

    function payment_history($id) {
        $data['p_id'] = $id;
        $data['payment_modes'] = $this->payment_mode_model->get_payment_mode_by_doctor();
        $data['setting'] = $this->setting_model->get_setting();
        $data['fees_all'] = $this->patient_model->get_patients_by_invoice($id);
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();
        if ($invoice->invoice == 0) {
            $dr_invoice = $this->invoice_model->get_doctor_invoice_number();
            if (empty($dr_invoice->invoice)) {
                $data['i_no'] = 1;
            } else {
                $data['i_no'] = $dr_invoice->invoice;
            }
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }

        $data['pateints'] = $this->patient_model->get_patients_by_doctor();

        $data['id'] = $id;
        $data['page_title'] = lang('payment_history');
        $data['body'] = 'patients/payment_history';
        $this->load->view('template/main', $data);
    }

    function medication_history($id) {
        $data['prescriptions'] = $this->patient_model->get_patients_by_medication($id);
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        //echo '<pre>'; print_r($data['prescriptions']);die;
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();
        $data['page_title'] = lang('medication_history');
        $data['body'] = 'patients/medication_history';
        $this->load->view('template/main', $data);
    }

    function add() {
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $admin = $this->session->userdata('admin');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->load->library('form_validation');
            $this->load->helper('string');
            $this->load->library('email');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('fname', 'First Name', 'required');
            $this->form_validation->set_rules('lname', 'Last Name', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
            $this->form_validation->set_rules('contact', 'lang:phone', '');
            $this->form_validation->set_rules('address', 'lang:address', 'required');


            if ($this->form_validation->run() == true) {

                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');
                $username = $this->patient_model->generate_username($fname, $lname);
                $email = $this->input->post('email');
                $save['name'] = $fname . " " . $lname;
                $save['pet_name'] = $this->input->post('pet_name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = date("Y") - $this->input->post('dob');
                $save['email'] = $email;
                $save['username'] = $username;
                $password = random_string('alnum', '8');
                $save['password'] = sha1($password);
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $savecon['name'] = $fname . " " . $lname;
                $savecon['email'] = $this->input->post('email');
                $savecon['contact'] = $this->input->post('contact');
                $savecon['address'] = $this->input->post('address');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                    $savecon['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                    $savecon['doctor_id'] = $admin['doctor_id'];
                }

                $save['user_role'] = 2;

                //echo '<pre>'; print_r($save);die;	

                $p_key = $this->patient_model->save($save);
                $this->log->log_action('User "' . $admin['name'] . '" added the patient "' . $save['name'] . '"');
                $this->contact_model->save($savecon);
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $p_key,
                            'form' => 2,
                        );
                    }
                    $this->custom_field_model->save_answer($save_fields);
                }
                $this->email->from('test@petconnectpro.com', 'PetConnectPro');
                $this->email->to($email);
                $this->email->cc('okesolakofo@gmail.com');

                $this->email->subject('Email Test');
                $this->email->message("Your username is " . $username . " \n And your password is " . $password . '');

                $this->email->send();
                $this->session->set_flashdata('message', "Patient is saved and username is :" . $save['username'] . " ");
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

    function get_patient() {
        $username = $this->patient_model->get_username();
        if (empty($username)) {
            $data['username'] = "Patient1";
        } else {
            $val = substr($username->username, 7);
            $data['username'] = "Patient" . ($val + 1);
            ;
        }
        //echo '<pre>'; print_r($data['username']);die;	
        $data['patients'] = $this->patient_model->get_patients_by_doctor_ajax($_POST['id']);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['page_title'] = lang('patients');
        //$data['body'] = 'patients/list';
        $this->load->view('patients/ajax_list', $data);
        /* 	$patients = $this->patient_model->get_patient_filter($_POST['id']);
          echo '
          <table id="example1" class="table table-bordered table-striped table-mailbox">
          <thead>
          <tr>
          <th>'.lang('serial_number').'</th>
          <th>'.lang('name').'</th>
          <th>'.lang('phone').'</th>
          <th width="20%">'.lang('action').'</th>
          </tr>
          </thead>

          ';
          if(isset($patients)):
          echo '
          <tbody>
          ';
          $i=1;foreach ($patients as $new){

          echo '
          <tr class="gc_row">
          <td>'.$i.'</td>
          <td>'.ucwords($new->name).'</td>
          <td>'.$new->contact.'</td>
          <td width="27%">
          <div class="btn-group">
          <a class="btn btn-default"  href="'.site_url('admin/patients/view_patient/'.$new->id).'"><i class="fa fa-eye"></i>'.lang('view').'</a>
          <a class="btn btn-primary"  style="margin-left:12px;" href="'.site_url('admin/patients/edit/'.$new->id).'"><i class="fa fa-edit"></i>'.lang('edit').'</a>
          <a class="btn btn-danger" style="margin-left:20px;" href="'.site_url('admin/patients/delete/'.$new->id).'" onclick="return areyousure()"><i class="fa fa-trash"></i>'.lang('delete').'</a>
          </div>
          </td>
          </tr>
          ';
          $i++;}
          echo '
          </tbody>';
          endif;

          echo '</table>';
         */
    }

    function edit($id = false) {
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['patient'] = $this->patient_model->get_patient_by_id($id);
        $data['groups'] = $this->patient_model->get_blood_group();
        $admin = $this->session->userdata('admin');

        ///echo '<pre>'; print_r($_POST);die;
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('blood_id', 'lang:select_blood_type', '');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
            //$this->form_validation->set_rules('username', 'lang:username', 'trim|required|');
            $this->form_validation->set_rules('contact', 'lang:phone', '');
            $this->form_validation->set_rules('address', 'Address', 'required');
            if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id) {
                $this->form_validation->set_rules('password', 'lang:password', 'min_length[6]');
                $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'matches[password]');
            }

            if ($this->form_validation->run()) {

                //$id = $this->input->post('id');
                $save['name'] = $this->input->post('name');
                $save['pet_name'] = $this->input->post('pet_name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = date("Y") - $this->input->post('dob');
                $save['email'] = $this->input->post('email');

                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['user_role'] = 2;
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                } else {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                if ($this->input->post('password') != '' || !$id) {
                    $save['password'] = sha1($this->input->post('password'));
                }

                $user = $this->patient_model->get_patient_by_id_array($id);
                $diff = array_diff($save, $user);
                
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 2,
                        );
                    }
                    $this->custom_field_model->delete_answer($id, $form = 1);
                    $this->custom_field_model->save_answer($save_fields);
                }


                $this->patient_model->update($save, $id);
                $this->log->edit_patient($diff, $user, $admin['name']);
                $this->session->set_flashdata('message', lang('patient_updated'));
                echo 1;
            } else {

                echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>												<b>Alert!</b>' . validation_errors() . '
											</div>
				';
            }
        }
    }

    function add_patient() {
        $admin = $this->session->userdata('admin');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('blood_id', 'lang:select_blood_type', '');
            $this->form_validation->set_rules('dob', 'lang:date_of_birth', '');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
            $this->form_validation->set_rules('contact', 'lang:phone', 'required');
            $this->form_validation->set_rules('address', 'lang:address', '');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $username = $this->patient_model->get_username();
                    if (empty($username)) {
                        $data['username'] = $admin['id'] . "Patient1";
                    } else {

                        $val = strlen($admin['id']) + 7;

                        $sub_str = substr($username->username, $val);

                        $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
                        ;
                    }
                }
                if ($admin['user_role'] == 3) {
                    $username = $this->patient_model->get_username_by_assistant();
                    if (empty($username)) {
                        $data['username'] = $admin['doctor_id'] . "Patient1";
                    } else {

                        $val = strlen($admin['doctor_id']) + 7;

                        $sub_str = substr($username->username, $val);

                        $data['username'] = $admin['doctor_id'] . "Patient" . ($sub_str + 1);
                        ;
                    }
                }



                $save['name'] = $this->input->post('name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = $this->input->post('dob');
                $save['email'] = $this->input->post('email');
                $save['username'] = $data['username'];
                $save['password'] = sha1($this->input->post('password'));
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['user_role'] = 2;
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                } else {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                $p_key = $this->patient_model->save($save);
                //$this->log->log_action('User "' . $admin['name'] . '" added the patient "' . $save['name'] . '"');
                $this->session->set_flashdata('message', "Patient is saved and username is :" . $data['username'] . " ");
                echo "Success";
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

    function test() {
        $array1 = array("a" => "green", "b" => "yellow");
        $array2 = array("a" => "green", "b" => "red",);
        $result = array_diff($array1, $array2);

        print_r($result);
    }

    function view_patient($id = false) {
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['patient'] = $this->patient_model->get_patient_by_id($id);
        $data['page_title'] = lang('view') . lang('patient');
        $data['body'] = 'patients/view';
        $this->load->view('template/main', $data);
    }

    function delete($id = false) {

        if ($id) {
            $patient = $this->patient_model->get_patient_by_id($id);
            $name = $patient->name;
            $this->patient_model->delete($id);
            //$this->log->log_action('User "' . $admin['name'] . '" deleted the patient "' . $name . '"');
            $this->session->set_flashdata('message', lang('patient_deleted'));
            redirect('admin/patients');
        }
    }

}
