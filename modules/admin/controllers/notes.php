<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class notes extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //$this->auth->check_access('1', true);
        $this->auth->is_logged_in();
        $this->load->model("notes_model");
        $this->load->model("patient_model");
    }

    function index() {
        $data['lists'] = $this->notes_model->get_notes_by_doctor();
        $data['patients'] = $this->patient_model->get_patients_by_doctor();
        $data['page_title'] = lang('notes');
        $data['body'] = 'notes/list';
        $this->load->view('template/main', $data);
    }

    function add() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('notes', 'lang:notes', 'required');
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');

            if ($this->form_validation->run() == true) {
                if (isset($_FILES['file'] ['name'])) {
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
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['id'];
                }

                $save['patient_id'] = $this->input->post('patient_id');
                $save['notes'] = $this->input->post('notes');


                $this->notes_model->save($save);


                $this->session->set_flashdata('message', lang('notes_created'));
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

        //$data['page_title'] = 'Add To Do ';
        //$data['body'] = 'to_do_list/add';
        //$this->load->view('template/main', $data);	
    }

    function edit($id = false) {
        $data['list'] = $data['clients'] = $this->notes_model->get_notes_by_id($id);
        $data['id'] = $id;
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('notes', 'lang:notes', 'required');
            $this->form_validation->set_rules('patient_id', 'lang:patient', 'required');

            if ($this->form_validation->run() == true) {
                if (isset($_FILES['file'] ['name'])) {
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
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                $save['patient_id'] = $this->input->post('patient_id');
                $save['notes'] = $this->input->post('notes');

                $this->notes_model->update($save, $id);
                $this->session->set_flashdata('message', lang('notes_updated'));
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

    function delete($id = false, $redirect = false) {

        if ($id) {
            $this->notes_model->delete($id);
            $this->session->set_flashdata('message', lang('notes_deleted'));
            if (!empty($redirect)) {
                redirect('admin/patients/view/' . $redirect . '/notes');
            } else {
                redirect('admin/notes');
            }
        }
    }

}
