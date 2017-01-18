<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class prescription extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->helper('dompdf_helper');
        $this->load->model("custom_field_model");
        $this->load->model("instruction_model");
        $this->load->model("prescription_model");
        $this->load->model("patient_model");
        $this->load->model("notification_model");
        $this->load->model("patient_model");
        $this->load->model("medicine_model");
        $this->load->model("disease_model");
        $this->load->model("medical_test_model");
        $this->load->model('setting_model');
        $this->load->model('case_history_model');
    }

    function index() {
        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }


        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['prescriptions'] = $this->prescription_model->get_prescription_by_doctor();
        //print_r($data['prescriptions']); die();

        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);


        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/list';
        $this->load->view('template/main', $data);
    }

    function assistant_prescription() {
        $this->auth->check_access('3', true);
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }


        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['prescriptions'] = $this->prescription_model->get_prescription_by_doctor();

        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);


        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/assistant_prescription';
        $this->load->view('template/main', $data);
    }

    function reports($id, $redirect = false) {
        $data['id'] = $id;
        $this->prescription_model->report_is_view_by_user($id);
        //$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['reports'] = $this->prescription_model->get_reports_by_id($id);
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        //echo '<pre>'; print_r($data['reports']);die;
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('remark', 'lang:remark', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if ($_FILES['file'] ['name'] != '') {


                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {
                        
                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                    }
                }

                $save['prescription_id'] = $id;
                $save['from_id'] = $admin['id'];

                if ($admin['user_role'] == 2) {
                    $save['to_id'] = $data['prescription']->doctor_id;
                } else {
                    $save['to_id'] = $data['prescription']->patient_id;
                }
                $save['remark'] = $this->input->post('remark');
                $save['type_id'] = $this->input->post('type_id');
                //echo '<pre>'; print_r($save);die;
                $this->prescription_model->save_report($save);
                $this->session->set_flashdata('message', lang('report_saved'));
                if ($admin['user_role'] == 1) {
                    if (!empty($redirect)) {
                        redirect('admin/patients/view/' . $redirect . '/medication_history');
                    } else {
                        redirect('admin/prescription');
                    }
                }
                if ($admin['user_role'] == 3) {
                    redirect('admin/prescription/assistant_prescription');
                }
                if ($admin['user_role'] == 2) {
                    redirect('admin/my_prescription/');
                }
            }
        }

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/reports';
        $this->load->view('template/main', $data);
    }

    function medical_history_report($id, $redirect) {
        $data['id'] = $id;
        $this->prescription_model->report_is_view_by_user($id);
        //$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['reports'] = $this->prescription_model->get_reports_by_id($id);
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        //echo '<pre>'; print_r($data['reports']);die;
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('remark', 'lang:remark', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if ($_FILES['file'] ['name'] != '') {


                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {
                        
                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                    }
                }

                $save['prescription_id'] = $id;
                $save['from_id'] = $admin['id'];

                if ($admin['user_role'] == 2) {
                    $save['to_id'] = $data['prescription']->doctor_id;
                } else {
                    $save['to_id'] = $data['prescription']->patient_id;
                }
                $save['remark'] = $this->input->post('remark');
                $save['type_id'] = $this->input->post('type_id');
                //echo '<pre>'; print_r($save);die;
                $this->prescription_model->save_report($save);
                $this->session->set_flashdata('message', lang('report_saved'));
                if ($admin['user_role'] == 1 || $admin['user_role'] == 3) {
                    redirect('admin/patients/medication_history/' . $redirect);
                } else {
                    redirect('admin/my_prescription/');
                }
            }
        }

        $data['page_title'] = lang('prescription');
        $data['body'] = 'prescription/reports';
        $this->load->view('template/main', $data);
    }

    function save_reports() {

        //$data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        //echo '<pre>'; print_r($data['reports']);die;
        $admin = $this->session->userdata('admin');
        $access = $admin['user_role'];
        if ($access == 1) {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        } else {
            $data['tests'] = $this->medical_test_model->get_medical_test_by_patient();
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //echo '<pre>'; print_r($_POST);die;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('remark', 'lang:remark', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                if ($_FILES['file'] ['name'] != '') {
                    $config['upload_path'] = './assets/uploads/files/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10000';
                    $config['max_height'] = '6000';

                    $this->load->library('upload', $config);

                    if (!$img = $this->upload->do_upload('file')) {
                        
                    } else {
                        $img_data = array('upload_data' => $this->upload->data());
                        $save['file'] = $img_data['upload_data']['file_name'];
                    }
                }
                $id = $this->input->post('p_id');
                $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
                $save['prescription_id'] = $id;
                $save['from_id'] = $admin['id'];

                if ($admin['user_role'] == 2) {
                    $save['to_id'] = $data['prescription']->doctor_id;
                } else {
                    $save['to_id'] = $data['prescription']->patient_id;
                }
                $save['remark'] = $this->input->post('remark');
                //echo '<pre>'; print_r($save);die;
                $save['type_id'] = $this->input->post('type_id');
                $this->prescription_model->save_report($save);
                $this->session->set_flashdata('message', lang('report_saved'));
                if ($admin['user_role'] == 1) {
                    redirect('admin/prescription/');
                } else {
                    redirect('admin/my_prescription/');
                }
            } else {
                //redirect('admin/prescription/');
                $this->index();
            }
        }
    }

    function view($id) {
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        $data['template'] = $this->notification_model->get_template();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        //echo '<pre>'; print_r($data['prescription']);die;
        $data['body'] = 'prescription/view';
        $this->load->view('template/main', $data);
    }

    function view_all_reports() {
        $this->auth->check_access('1', true);


        $data['reports'] = $this->prescription_model->get_reports_notification();

        $data['page_title'] = lang('reports');
        $data['body'] = 'prescription/view_all_reports';
        $this->load->view('template/main', $data);
    }

    function fees_dues() {
        $this->auth->check_access('Admin', true);

        $data['prescriptions'] = $this->prescription_model->get_fees_due();

        $data['page_title'] = lang('fees_due');
        $data['body'] = 'prescription/fees_due';
        $this->load->view('template/main', $data);
    }

    function get_case_history() {
        $tests = $this->medical_test_model->get_medical_test_by_doctor();
        $prescription = $this->prescription_model->get_case_history($_POST['patient_id']);
        $medicines = $this->medicine_model->get_medicine_by_doctor();
        //echo '<pre>'; print_r($prescription);die;

        $tests1 = json_decode($prescription->tests);
        $medicine1 = json_decode($prescription->medicines);


        echo '
							
	 <div class="col-md-3">';
        if (!empty($tests1)) {
            $i = 1;
            foreach ($tests1 as $key => $val) {
                if ($i == 1) {
                    $title = "Medical Test";
                } else {
                    $title = "";
                }
                echo '<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;" >' . $title . '</label>
								</div>
								<div class="col-md-8" >
									<div>
												<select name="test_report_id[]" class="form-control chzn history_report_id">
												
												';
                foreach ($tests as $new) {
                    $sel = " ";
                    if ($new->name == $val)
                        $sel = "selected='selected'";
                    echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                }

                echo '
										</select>
									</div>	
                                </div>
                                
								
                            </div>
                        </div>';
                $i++;
            } //end test1 loop
        } //end if condition	

        echo '</div><div class="col-md-3">';
        if (!empty($medicine1)) {
            $c = 1;
            foreach ($medicine1 as $key => $val) {
                if ($c == 1) {
                    $title = "Medicine";
                } else {
                    $title = "";
                }

                echo '	<div class="form-group">
                        	<div class="row  ">
                                <div class="col-md-3">
                                    <label for="name" style="clear:both;"> ' . $title . '</label>
									
								</div>
								
								<div class="col-md-8" >
												<select name="medicine_id[]" class="form-control chzn medicine_id" style="width:100%">
												<option value="">--' . lang('select_medicine') . '--</option>
												';
                foreach ($medicines as $new) {
                    $sel = " ";
                    if ($new->name == $val)
                        $sel = "selected='selected'";
                    echo '<option value="' . $new->name . '" ' . $sel . '>' . $new->name . '</option>';
                }
                echo '
										</select>
								</div>
                                
                            </div>
                        </div>';

                $c++;
            } // end medicine loop
        } //	end if condition	
        echo '</div>';
    }

    function add($id = false) {
        $data = array();
        $data['id'] = $id;
        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $username = $this->patient_model->get_username();
        //echo '<pre>'; print_r($username);die;
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Patient1";
        } else {

            $val = strlen($admin['id']) + 7;

            $sub_str = substr($username->username, $val);

            $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
            ;
        }

        $pre_id = $this->prescription_model->get_prescription_cid();
        //echo '<pre>'; print_r($pre_id);die;
//        if (empty($pre_id) || $pre_id->prescription_id == 0) {
//            $data['pre_id'] = 1001;
//        } else {
//
//            $data['pre_id'] = $pre_id->prescription_id + 1;
//        }

        if (empty($pre_id) || $pre_id->id == 0) {
            $data['pre_id'] = $this->prescription_model->convert_id(1);
        } else {

            $data['pre_id'] = $this->prescription_model->convert_id($pre_id->id + 1);
        }
        
        $this->auth->check_access('1', true);
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['fields_patient'] = $this->custom_field_model->get_custom_fields(2);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();


        if ($this->input->server('REQUEST_METHOD') === 'POST') {


            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');
            $this->form_validation->set_rules('disease_id', 'lang:disease', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            $this->form_validation->set_rules('case_history_id', 'Case History Options', '');
            $this->form_validation->set_rules('oe_description', 'O/E Description', '');
            $this->form_validation->set_rules('remark', 'Remark', '');
            $this->form_validation->set_rules('medicine_id', 'Medicine', '');
            $this->form_validation->set_rules('instruction', 'Medicine instruction', '');
            $this->form_validation->set_rules('report_id', 'Medical Test', '');
            $this->form_validation->set_rules('test_instruction', 'Medical Test instruction', '');
            $this->form_validation->set_rules('prescription_id', 'Prescription Id', '');
            $this->form_validation->set_rules('case_history', 'Case History', '');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {

                $save['patient_id'] = $this->input->post('patient_id');
                $save['prescription_id'] = $this->input->post('prescription_id');
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($this->input->post('medicine_id'));
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($this->input->post('report_id'));
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));

                //echo '<pre>'; print_r($save);die;
                $p_key = $this->prescription_model->save($save);

                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $p_key,
                            'form' => 5,
                        );
                    }
                    $this->custom_field_model->save_answer($save_fields);
                }

                $this->session->set_flashdata('message', lang('prescription_saved'));
                if (!empty($id)) {
                    redirect('admin/patients/view/' . $id);
                } else {
                    redirect('admin/prescription');
                }
            }
        }
        $data['page_title'] = lang('add') . lang('prescription');
        $data['body'] = 'prescription/add';
        $this->load->view('template/main', $data);
    }

    function edit($id, $redirect = false) {
        $this->auth->check_access('1', true);
        //echo '<pre>'; print_r($_POST);die;
        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        $data['id'] = $id;
        $data['redirect'] = $redirect;
        //echo '<pre>'; print_r($data['prescription']);'</pre>';die;
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();

        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();


        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');
            $this->form_validation->set_rules('disease_id', 'lang:disease', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {


                $medicines = array();
                $medi_id = $this->input->post('medicine_id');
                if (!empty($medi_id)) {
                    foreach ($this->input->post('medicine_id') as $key => $val) {
                        if (!empty($val))
                            $medicines[] = $val;
                    }
                }
                /* $medicines_ins = array();
                  foreach($this->input->post('instruction') as $key =>$val){
                  if(!empty($val))
                  $medicines_ins[] = $val;
                  } */

                $tests = array();
                $rep_id = $this->input->post('report_id');
                if (!empty($rep_id)) {
                    foreach ($this->input->post('report_id') as $key => $val) {
                        if (!empty($val))
                            $tests[] = $val;
                    }
                }
                /* 				$tests_ins = array();
                  foreach($this->input->post('test_instruction') as $key =>$val){
                  if(!empty($val))
                  $tests_ins[] = $val;
                  } */


                $save['patient_id'] = $this->input->post('patient_id');
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($medicines);
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($tests);
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));

                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 5,
                        );
                    }
                    $this->custom_field_model->delete_answer($id, $form = 1);
                    $this->custom_field_model->save_answer($save_fields);
                }
                //echo '<pre>'; print_r($_POST);die;
                $this->prescription_model->update($save, $id);
                $this->session->set_flashdata('message', lang('prescription_saved'));
                if (!empty($redirect)) {
                    redirect('admin/patients/view/' . $redirect);
                } else {
                    redirect('admin/prescription');
                }
            }
        }

        $data['body'] = 'prescription/edit';
        $this->load->view('template/main', $data);
    }

    function edit_prescription($id, $redirect = false) {
        $this->auth->check_access('1', true);
        //echo '<pre>'; print_r($_POST);die;

        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');
            $this->form_validation->set_rules('disease_id', 'lang:disease', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {


                $medicines = array();
                $medi_id = $this->input->post('medicine_id');
                if (!empty($medi_id)) {
                    foreach ($this->input->post('medicine_id') as $key => $val) {
                        if (!empty($val))
                            $medicines[] = $val;
                    }
                }
                /* $medicines_ins = array();
                  foreach($this->input->post('instruction') as $key =>$val){
                  if(!empty($val))
                  $medicines_ins[] = $val;
                  } */

                $tests = array();
                $rep_id = $this->input->post('report_id');
                if (!empty($rep_id)) {
                    foreach ($this->input->post('report_id') as $key => $val) {
                        if (!empty($val))
                            $tests[] = $val;
                    }
                }
                /* 				$tests_ins = array();
                  foreach($this->input->post('test_instruction') as $key =>$val){
                  if(!empty($val))
                  $tests_ins[] = $val;
                  } */


                $save['patient_id'] = $this->input->post('patient_id');
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($medicines);
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($tests);
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));

                //echo '<pre>'; print_r($_POST);die;
                $this->prescription_model->update($save, $id);
                $this->session->set_flashdata('message', lang('prescription_saved'));
                echo 1;
            }else {

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

    function add_prescription($id = false) {

        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
        $username = $this->patient_model->get_username();
        //echo '<pre>'; print_r($username);die;
        if (empty($username)) {
            $data['username'] = $admin['id'] . "Patient1";
        } else {

            $val = strlen($admin['id']) + 7;

            $sub_str = substr($username->username, $val);

            $data['username'] = $admin['id'] . "Patient" . ($sub_str + 1);
            ;
        }

        $pre_id = $this->prescription_model->get_prescription_id();
        //echo '<pre>'; print_r($_POST);die;
        if (empty($pre_id) || $pre_id->prescription_id == 0) {
            $data['pre_id'] = 1001;
        } else {

            $data['pre_id'] = $pre_id->prescription_id + 1;
        }

        $this->auth->check_access('1', true);
        $data['case_historys'] = $this->case_history_model->get_case_history_by_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
        $data['groups'] = $this->patient_model->get_blood_group();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['diseases'] = $this->disease_model->get_disease_by_doctor();
        $data['medicines'] = $this->medicine_model->get_medicine_by_doctor();
        $data['tests'] = $this->medical_test_model->get_medical_test_by_doctor();
        $data['medicine_ins'] = $this->instruction_model->get_instruction_by_doctor_medicine();
        $data['test_ins'] = $this->instruction_model->get_instruction_by_doctor_test();


        if ($this->input->server('REQUEST_METHOD') === 'POST') {


            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');
            $this->form_validation->set_rules('disease_id', 'lang:disease', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date', 'required');
            $this->form_validation->set_rules('case_history_id', 'Case History Options', '');
            $this->form_validation->set_rules('oe_description', 'O/E Description', '');
            $this->form_validation->set_rules('remark', 'Remark', '');
            $this->form_validation->set_rules('medicine_id', 'Medicine', '');
            $this->form_validation->set_rules('instruction', 'Medicine instruction', '');
            $this->form_validation->set_rules('report_id', 'Medical Test', '');
            $this->form_validation->set_rules('test_instruction', 'Medical Test instruction', '');
            $this->form_validation->set_rules('prescription_id', 'Prescription Id', '');
            $this->form_validation->set_rules('case_history', 'Case History', '');
            //$this->form_validation->set_rules('medicine_id', 'lang:medicine', 'required');

            if ($this->form_validation->run() == true) {

                $save['patient_id'] = $this->input->post('patient_id');
                $save['prescription_id'] = $data['pre_id'];
                $save['disease'] = json_encode($this->input->post('disease_id'));
                $save['oe_description'] = $this->input->post('oe_description');
                $save['medicines'] = json_encode($this->input->post('medicine_id'));
                $save['medicine_instruction'] = json_encode($this->input->post('instruction'));
                $save['tests'] = json_encode($this->input->post('report_id'));
                $save['test_instructions'] = json_encode($this->input->post('test_instruction'));
                $save['remark'] = $this->input->post('remark');
                $save['date_time'] = $this->input->post('date_time');
                $save['case_history'] = $this->input->post('case_history');
                $save['case_history_id'] = json_encode($this->input->post('case_history_id'));

                //echo '<pre>'; print_r($save);die;
                $p_key = $this->prescription_model->save($save);


                $this->session->set_flashdata('message', lang('prescription_saved'));
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

    function pdf($id) {
        $data['template'] = $this->notification_model->get_template();

        $data['prescription'] = $this->prescription_model->get_prescription_by_id($id);
        $data['setting'] = $this->setting_model->get_setting();
        $data['fields'] = $this->custom_field_model->get_custom_fields(5);
//        $this->load->library('tcpdf_lib');
//        $pdf = new tcpdf_lib('P', 'mm', 'A4', true, 'UTF-8', false);
//        $pdf->SetCreator(PDF_CREATOR);
//        // Add a page
//        $pdf->AddPage();
//        $html = $this->load->view('prescription/pdf', $data, true);
//        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
//        $pdf->writeHTML($html, true, false, true, false, '');
//        ob_clean();
//        $pdf->Output();
        $this->load->view('prescription/pdf', $data);
    }

    function fees($id) {
        //$this->auth->check_access('1', true);
        $data['priscrition'] = $this->prescription_model->get_prescription_by_id($id);
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        $data['fees_all'] = $this->prescription_model->get_fees_all($id);
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();

        //echo '--->'. $invoice->invoice;die;
        if ($invoice->invoice == 0) {
            $data['i_no'] = 1;
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }
        $data['id'] = $id;


        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('payment_mode_id', 'lang:payment_mode', 'required');
            $this->form_validation->set_rules('date', 'lang:date', 'required');
            $this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');
            if ($this->form_validation->run() == true) {
                $save['amount'] = $this->input->post('amount');
                $save['payment_mode_id'] = $this->input->post('payment_mode_id');
                $save['prescription_id'] = $id;
                $save['date'] = $this->input->post('date');
                $save['invoice'] = $data['i_no']; // $this->input->post('invoice_no');

                $this->prescription_model->save_fees($save);
                $this->session->set_flashdata('message', lang('fees_updated'));
                redirect('admin/prescription/fees/' . $id);
            }
        }
        $data['body'] = 'prescription/fees';
        $this->load->view('template/main', $data);
    }

    function get_prescription() {
        $data['prescriptions'] = $this->prescription_model->get_prescription_by_doctor_ajax($_POST['id']);

        $this->auth->check_access('1', true);
        $admin = $this->session->userdata('admin');
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

        $data['page_title'] = lang('prescription');
        //$data['body'] = 'patients/list';
        $this->load->view('prescription/ajax_list', $data);
    }

    function delete($id = false, $redirect = false) {
        $this->auth->check_access('1', true);

        if ($id) {

            $this->prescription_model->delete($id);
            $this->session->set_flashdata('message', lang('prescription_deleted'));

            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect);
            } else {
                redirect('admin/prescription');
            }
        }
    }

    function delete_report($id, $redirect = false) {


        if ($id) {
            $this->prescription_model->delete_report($id);
            $this->session->set_flashdata('message', lang('report_deleted'));
            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect . '/medication_history');
            } else {
                redirect('admin/prescription');
            }
        }
    }

    function delete_report_history($id, $redirect) {


        if ($id) {
            $this->prescription_model->delete_report($id);
            $this->session->set_flashdata('message', lang('report_deleted'));
            redirect('admin/patients/medication_history/' . $redirect);
        }
    }

}
