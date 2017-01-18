<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class assistants extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        //$this->auth->check_access('1', true);
        $this->load->model("assistant_model");
        $this->load->model("patient_model");
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
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    function index() {
        $data = array();
        $admin = $this->session->userdata('admin');
        $username = $this->assistant_model->get_username();
        //echo '<pre>'; print_r($username);die;
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Assistant1";
        } else {

            $val = strlen($admin['id']) + 9;

            $sub_str = substr($username->username, $val);

            $data['username'] = $admin['id'] . "Assistant" . ($sub_str + 1);
            ;
        }

        //echo '<pre>'; print_r($data['username']);die;	
        $data['assistants'] = $this->assistant_model->get_assistants_by_doctor();
        $data['page_title'] = lang('assistants');
        $data['body'] = 'assistants/list';
        $this->load->view('template/main', $data);
    }

    function export() {
        $data['patients'] = $this->patient_model->get_patients_by_doctor();
        $this->load->view('patients/export', $data);
    }

    function payment_history($id) {
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        $data['setting'] = $this->setting_model->get_setting();
        $data['fees_all'] = $this->patient_model->get_patients_by_invoice($id);




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
        $admin = $this->session->userdata('admin');

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $type = $this->input->post('user_type');
            
            if($type == 'management')
            {
                $rules_raw = array("patients","payments","prescriptions","calendar","message","todo","notes","contacts","appointments","locations","settings");
            }
            else
            {
                $rules_raw = $this->input->post('rules');
            }
            if(empty($rules_raw))
            {
                $rules_raw = Array();
            }
            //print_r($rules_raw);
            $rules_string = implode(',', $rules_raw);
            $this->load->library('form_validation');
            $this->load->library('email');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('fname', 'lang:firstname', 'required');
            $this->form_validation->set_rules('lname', 'lang:lastname', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('user_type', 'User Type', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
            $this->form_validation->set_rules('contact', 'lang:phone', 'required');
            $this->form_validation->set_rules('address', 'lang:address', '');


            if ($this->form_validation->run() == true) {
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');
                $username = $this->patient_model->generate_username($fname,$lname);
                $password = random_string('alnum', '8');
                $save['name'] = $fname . " " . $lname;
                $save['gender'] = $this->input->post('gender');
                $save['email'] = $this->input->post('email');
                $save['username'] = $username;
                $save['password'] = sha1($password);
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $savecon['name'] = $fname . " " . $lname;
                $savecon['email'] = $this->input->post('email');
                $savecon['contact'] = $this->input->post('contact');
                $savecon['address'] = $this->input->post('address');
                $save['doctor_id'] = $admin['id'];
                $savecon['doctor_id'] = $admin['id'];
                $save['user_role'] = 3;
                $save['user_type'] = $this->input->post('user_type');
                $rules = Array();


                $save['rules'] = $rules_string;
                //echo '<pre>'; print_r($save);die;	

                $p_key = $this->assistant_model->save($save);

                $this->email->from('test@petconnectpro.com', 'PetConnectPro');
                $this->email->to($save['email']);
                $this->email->cc('okesolakofo@gmail.com');

                $this->email->subject('Email Test');
                $this->email->message("Your username is " . $username . " \n And your password is " . $password . '');

                $this->email->send();

                $this->contact_model->save($savecon);
                $this->session->set_flashdata('message', lang('assistant_saved'));
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
        $admin = $this->session->userdata('admin');

        
        ///echo '<pre>'; print_r($_POST);die;
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $type = $this->input->post('user_type');
            
            
            if($type == 'management')
            {
                $rules_raw = array("patients","payments","prescriptions","calendar","message","todo","notes","contacts","appointments","locations","settings");
            }
            else{
                $rules_raw = $this->input->post('rules');
            }
            if(empty($rules_raw))
            {
                $rules_raw = Array();
            }
            //print_r($rules_raw);
            $rules_string = implode(',', $rules_raw);
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('gender', 'lang:gender', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'trim|valid_email|max_length[128]');
            //$this->form_validation->set_rules('username', 'lang:username', 'trim|required|');
            $this->form_validation->set_rules('contact', 'lang:phone', 'required');
            if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id) {
                $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
                $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
            }

            if ($this->form_validation->run()) {

                //$id = $this->input->post('id');
                $save['name'] = $this->input->post('name');
                $save['gender'] = $this->input->post('gender');
                $save['email'] = $this->input->post('email');
                $save['doctor_id'] = $admin['id'];
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['user_role'] = 3;
                $save['user_type'] = $this->input->post('user_type');
                $save['rules'] = $rules_string;
                if ($this->input->post('password') != '' || !$id) {
                    $save['password'] = sha1($this->input->post('password'));
                }

                $this->patient_model->update($save, $id);
                $this->session->set_flashdata('message', lang('assistant_updated'));
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
            $this->form_validation->set_rules('username', 'lang:username', 'trim|required|');
            $this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
            $this->form_validation->set_rules('contact', 'lang:phone', 'required');
            $this->form_validation->set_rules('address', 'lang:address', '');

            if ($this->form_validation->run() == true) {


                $save['name'] = $this->input->post('name');
                $save['blood_group_id'] = $this->input->post('blood_id');
                $save['gender'] = $this->input->post('gender');
                $save['dob'] = $this->input->post('dob');
                $save['email'] = $this->input->post('email');
                $save['username'] = $this->input->post('username');
                $save['password'] = sha1($this->input->post('password'));
                $save['contact'] = $this->input->post('contact');
                $save['address'] = $this->input->post('address');
                $save['doctor_id'] = $admin['id'];
                $save['user_role'] = 2;
                $p_key = $this->patient_model->save($save);
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
            $this->assistant_model->delete_assistant($id);
            $this->session->set_flashdata('message', lang('assistant_deleted'));
            redirect('admin/assistants');
        }
    }

}
