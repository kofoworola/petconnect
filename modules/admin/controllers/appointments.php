<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class appointments extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model("appointment_model");
        $this->load->model("setting_model");
        $this->load->model("patient_model");
        $this->load->model("user_model");
        $this->load->model("contact_model");
        $this->load->model("custom_field_model");
        $this->load->library('log');
    }

    function add() {
        $data['contact_fields'] = $this->custom_field_model->get_custom_fields(4);

        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['contacts'] = $this->patient_model->get_patients_by_doctor();
        $admin = $this->session->userdata('admin');
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //echo '<pre>';print_r($_POST);die;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'lang:title', '');
            //$this->form_validation->set_rules('patient_id', 'lang:contact', 'required');
            $this->form_validation->set_rules('motive', 'lang:motive', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));


            $starttime = $this->input->post('date_time');

            $checked = $this->appointment_model->check_tables($starttime);
            //echo $checked;die;
            if (!empty($checked)) {
                $this->session->set_flashdata('error', $checked);
                //redirect()
                echo 1;
                exit;
            } else {
                //echo '<pre>'; print_r($save);die;	
                $this->session->set_flashdata('message', "Appointment Created");
            }
            if ($this->form_validation->run() == true) {



//                if ($admin['user_role'] == 1) {
//                    $save['doctor_id'] = $admin['id'];
//                }
//                if ($admin['user_role'] == 3) {
//                    $save['doctor_id'] = $admin['doctor_id'];
//                }
                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('title');
                $save['whom'] = $this->input->post('whom');
                $save['patient_id'] = $this->input->post('patient_id');
                $save['contact_id'] = $this->input->post('contact_id');
                $save['other'] = $this->input->post('other');
                $save['motive'] = $this->input->post('motive');
                $save['notes'] = $this->input->post('notes');
                $save['date'] = $this->input->post('date_time');
                $save['is_paid'] = 1;
                $save['status'] = 1;
                //echo '<pre>';print_r($save);die;
                if ($this->input->post('remind_patient') == "yes") {
                    $save['remind_patient'] = 1;
                }
                if ($this->input->post('remind_doctor') == "yes") {
                    $save['remind_doctor'] = 1;
                }
                $save['reminder'] = $this->input->post('reminder');
                $p_key = $this->appointment_model->save($save);
//                if ($this->input->post('whom') == 1) {
//                    $this->log->log_action('User "' . $admin['name'] . '" made an appointment with patient "' . $this->user_model->get_user_by_id($save['patient_id'])->name . '" titled "' . $save['title'] . '" for ' . $save['date']);
//                } elseif ($this->input->post('whom') == 2) {
//                    $this->log->log_action('User "' . $admin['name'] . '" made an appointment with contact "' . $this->user_model->get_user_by_id($save['contact_id'])->name) . '" titled "' . $save['title'] . '" for ' . $save['date'];
//                } else {
//                    $this->log->log_action('User "' . $admin['name'] . '" made an appointment with "' . $save['other'] . '" titled "' . $save['title'] . '" for ' . $save['date']);
//                }
                //$this->session->set_flashdata('message', lang('appointment_created'));
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

    function edit_appointment($id) {
        $data['contact_fields'] = $this->custom_field_model->get_custom_fields(4);

        $data['fields'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['contacts'] = $this->patient_model->get_patients_by_doctor();
        $admin = $this->session->userdata('admin');


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $starttime = $this->input->post('date_time');

            $checked = $this->appointment_model->check_tables($starttime);
            //echo $checked;die;
            if (!empty($checked)) {
                $this->session->set_flashdata('error', $checked);
                //redirect()
                echo 1;
                exit;
            } else {
                //echo '<pre>'; print_r($save);die;	
                $this->session->set_flashdata('message', "Appointment Updated");
            }


            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'lang:title', '');
            $this->form_validation->set_rules('motive', 'lang:motive', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));
            //	echo '<pre>';print_r($_POST);die;



            if ($this->form_validation->run() == true) {
//                if ($admin['user_role'] == 1) {
//                    $save['doctor_id'] = $admin['id'];
//                }
//                if ($admin['user_role'] == 3) {
//                    $save['doctor_id'] = $admin['doctor_id'];
//                }
                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('title');
                $save['whom'] = $this->input->post('whom');
                $save['patient_id'] = $this->input->post('patient_id');
                $save['contact_id'] = $this->input->post('contact_id');
                $save['other'] = $this->input->post('other');
                $save['motive'] = $this->input->post('motive');
                $save['notes'] = $this->input->post('notes');
                $save['date'] = $this->input->post('date_time');
                $save['is_paid'] = 1;
                $save['status'] = 1;
                $save['remind_patient'] = $this->input->post('remind_patient');
                $save['remind_doctor'] = $this->input->post('remind_doctor');
                $save['reminder'] = $this->input->post('reminder');
                $p_key = $this->appointment_model->update($save, $id);

                //$this->session->set_flashdata('message', lang('appointment_created'));
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

    function check_datetime() {
        $starttime = $_POST['datetime'];
        $checked = $this->appointment_model->check_tables($starttime);
        //echo $checked;die;
        if (!empty($checked)) {
            //redirect()
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }

    function set_time() {
        $data['body'] = 'appointments/list';
        $this->load->view('template/main', $data);
    }

    function index() {
        $admin = $this->session->userdata('admin');
//        if ($admin['user_role'] == 3) {
//            //$data['times_all'] = $this->appointment_model->get_appointment_time($admin['doctor_id']);
//            $data['appointments'] = $this->appointment_model->get_appointment_by_doctor($admin['doctor_id']);
//        } else {
//            ///$data['times_all'] = $this->appointment_model->get_appointment_time($admin['id']);
//            $data['appointments'] = $this->appointment_model->get_appointment_by_doctor($admin['id']);
//        }
        $data['appointments'] = $this->appointment_model->get_appointment_by_doctor($admin['id']);

        $data['groups'] = $this->patient_model->get_blood_group();
        $data['contacts'] = $this->patient_model->get_patients_by_doctor();

        $data['contact'] = $this->contact_model->get_contact_by_doctor();

        //echo '<pre>'; print_r($data['appointments']);die;
        $data['page_title'] = lang('appointments');
        $data['body'] = 'appointments/list';
        $this->load->view('template/main', $data);
    }

    function approve($id, $val) {
        $this->appointment_model->update_status($id, $val);
        if ($val == 1)
            $this->session->set_flashdata('message', lang('appointment_approved'));
        else
            $this->session->set_flashdata('message', lang('appointment_reject'));
        redirect('admin/appointments');
    }

    function close_record($id, $p_id = false) {
        $this->appointment_model->close_record($id);

        if (!empty($p_id)) {
            $this->session->set_flashdata('message', "Appointment Closed");
            redirect('admin/patients/view/' . $p_id . '/appointment');
        } else {
            $this->session->set_flashdata('message', "Appointment Closed");
            redirect('admin/appointments');
        }
    }

    function set() {
        $admin = $this->session->userdata('admin');

        $data['fields'] = $this->custom_field_model->get_custom_fields(5);

        //echo '<pre>'; print_r($data['times']);die;
        if ($this->input->post('ok')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start_date', 'lang:start_date', '');

            if ($this->form_validation->run() == true) {

                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('title');
                $save['mon_start'] = $this->input->post('mon_start');
                $save['mon_end'] = $this->input->post('mon_end');

                $save['tue_start'] = $this->input->post('tue_start');
                $save['tue_end'] = $this->input->post('tue_end');

                $save['wed_start'] = $this->input->post('wed_start');
                $save['wed_end'] = $this->input->post('wed_end');

                $save['thu_start'] = $this->input->post('thu_start');
                $save['thu_end'] = $this->input->post('thu_end');

                $save['fri_start'] = $this->input->post('fri_start');
                $save['fri_end'] = $this->input->post('fri_end');

                $save['sat_start'] = $this->input->post('sat_start');
                $save['sat_end'] = $this->input->post('sat_end');

                $save['sun_start'] = $this->input->post('sun_start');
                $save['sun_end'] = $this->input->post('sun_end');
                //echo '<pre>'; print_r($save);die;	

                $this->appointment_model->save_days($save);
                $this->session->set_flashdata('message', lang('appointment_created'));
                redirect('admin/appointments');
            }
        }


        $data['page_title'] = lang('add') . lang('appointment');
        $data['body'] = 'appointments/set';

        $this->load->view('template/main', $data);
    }

    function edit($id) {
        $data['id'] = $id;
        $admin = $this->session->userdata('admin');

        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['times'] = $this->appointment_model->check_time($id);
        //echo '<pre>'; print_r($data['times']);die;
        if ($this->input->post('ok')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('start_date', 'lang:start_date', '');

            if ($this->form_validation->run() == true) {
                //echo '<pre>'; print_r($this->input->post());die;

                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('title');
                $save['mon_start'] = $this->input->post('mon_start');
                $save['mon_end'] = $this->input->post('mon_end');

                $save['tue_start'] = $this->input->post('tue_start');
                $save['tue_end'] = $this->input->post('tue_end');

                $save['wed_start'] = $this->input->post('wed_start');
                $save['wed_end'] = $this->input->post('wed_end');

                $save['thu_start'] = $this->input->post('thu_start');
                $save['thu_end'] = $this->input->post('thu_end');

                $save['fri_start'] = $this->input->post('fri_start');
                $save['fri_end'] = $this->input->post('fri_end');

                $save['sat_start'] = $this->input->post('sat_start');
                $save['sat_end'] = $this->input->post('sat_end');

                $save['sun_start'] = $this->input->post('sun_start');
                $save['sun_end'] = $this->input->post('sun_end');
                //echo '<pre>'; print_r($save);die;	

                $this->appointment_model->update_days($save, $id);
                $this->session->set_flashdata('message', lang('appointment_created'));
                redirect('admin/appointments');
            }
        }


        $data['page_title'] = lang('add') . lang('appointment');
        $data['body'] = 'appointments/edit';

        $this->load->view('template/main', $data);
    }

    function view_appointment($id = false) {
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['appointment'] = $this->appointment_model->get_appointment_by_id($id);
        $data['patients'] = $this->patient_model->get_patients_by_doctor();
        $data['contacts'] = $this->contact_model->get_contact_by_doctor();
        //echo '<pre>'; print_r($data['appointment']);die;
        $data['id'] = $id;
        $this->appointment_model->appointment_view_by_admin($id);
        $data['page_title'] = lang('view') . lang('appointment');
        $data['body'] = 'appointments/view';
        $this->load->view('template/main', $data);
    }

    function view_all() {

        $data['appointments'] = $this->setting_model->get_appointment_alert();
        $ids = '';
        foreach ($data['appointments'] as $ind => $key) {

            $ids[] = $key->id;
        }
        $this->appointment_model->appointments_view_by_admin($ids);
        $data['page_title'] = lang('view_all') . ' ' . lang('appointments');
        $data['body'] = 'appointments/view_all';
        $this->load->view('template/main', $data);
    }

    function delete($id = false, $redirect = false) {

        if ($id) {
            $this->appointment_model->delete($id);
            $this->session->set_flashdata('message', lang('appointment_deleted'));

            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect . '/appointment');
            } else {
                redirect('admin/appointments');
            }
        }
    }

    function delete_days($id = false) {

        if ($id) {
            $this->appointment_model->delete_days($id);
            $this->session->set_flashdata('message', lang('appointment_deleted'));
            redirect('admin/appointments');
        }
    }

}
