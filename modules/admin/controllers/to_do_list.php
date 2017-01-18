<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class to_do_list extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //$this->auth->check_access('1', true);
        $this->auth->is_logged_in();
        $this->load->model("to_do_list_model");
        $this->load->model("custom_field_model");
    }

    function index() {
        $data['lists'] = $this->to_do_list_model->get_to_do_by_doctor();
        $data['fields'] = $this->custom_field_model->get_custom_fields(3);
        $data['page_title'] = lang('to_do_list');
        $data['body'] = 'to_do_list/list';
        $this->load->view('template/main', $data);
    }

    function view_all() {
        $data['lists'] = '';
        $data['lists'] = $this->to_do_list_model->get_all_by_date();
        $ids = '';
        foreach ($data['lists'] as $ind => $key) {

            $ids[] = @$key->case_id;
        }

        $this->to_do_list_model->to_dos_view_by_admin($ids);
        $data['page_title'] = lang('view_all') . " " . lang('to_do');
        $data['body'] = 'to_do_list/view_all';
        $this->load->view('template/main', $data);
    }

    function add() {
        $data['fields'] = $this->custom_field_model->get_custom_fields(3);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Title', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('date_time', 'Date Time', 'required');

            $starttime = $this->input->post('date_time');

            $checked = $this->to_do_list_model->check_tables($starttime);
            //echo $checked;die;
            if (!empty($checked)) {
                $this->session->set_flashdata('error', $checked);
                //redirect()
                echo 1;
                exit;
            } else {
                //echo '<pre>'; print_r($save);die;	
                $this->session->set_flashdata('message', lang('to_do_created'));
            }
            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
//                if ($admin['user_role'] == 1) {
//                    $save['doctor_id'] = $admin['id'];
//                }
//                if ($admin['user_role'] == 3) {
//                    $save['doctor_id'] = $admin['doctor_id'];
//                }

                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('name');
                $save['description'] = $this->input->post('description');
                $save['date'] = $this->input->post('date_time');
                if ($this->input->post('sms') == 1) {
                    $save['remind'] = 1;
                    if ($this->input->post('default') == 1) {
                        $save['reminder'] = $save['date'];
                    } else {
                        $save['reminder'] = $this->input->post('reminder');
                    }
                }
                $p_key = $this->to_do_list_model->save($save);
                $reply = $this->input->post('reply');
                if (!empty($reply)) {

                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $p_key,
                            'form' => 3,
                        );
                    }
                    $this->custom_field_model->save_answer($save_fields);
                }


                //$this->session->set_flashdata('message', lang('to_do_created'));
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
        $data['fields'] = $this->custom_field_model->get_custom_fields(3);
        $data['list'] = $data['clients'] = $this->to_do_list_model->get_list_by_id($id);
        $data['id'] = $id;
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $starttime = $this->input->post('date_time');

            $checked = $this->to_do_list_model->check_tables($starttime);
            //echo $checked;die;
            if (!empty($checked)) {
                $this->session->set_flashdata('error', $checked);
                //redirect()
                echo 1;
                exit;
            } else {
                //echo '<pre>'; print_r($save);die;	
                $this->session->set_flashdata('message', lang('to_do_updated'));
            }

            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'lang:title', 'required');
            $this->form_validation->set_rules('description', 'lang:description', 'required');
            $this->form_validation->set_rules('date_time', 'lang:date_time', 'required');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
//                if ($admin['user_role'] == 1) {
//                    $save['doctor_id'] = $admin['id'];
//                }
//                if ($admin['user_role'] == 3) {
//                    $save['doctor_id'] = $admin['doctor_id'];
//                }

                $save['doctor_id'] = $admin['id'];
                $save['title'] = $this->input->post('name');
                $save['description'] = $this->input->post('description');
                $save['date'] = $this->input->post('date_time');
                if ($this->input->post('sms') == 1) {
                    $save['remind'] = 1;
                    if ($this->input->post('default') == 1) {
                        $save['reminder'] = $save['date'];
                    } else {
                        $save['reminder'] = $this->input->post('reminder');
                    }
                } else {
                    $save['remind'] = 0;
                }

                $this->to_do_list_model->update($save, $id);

                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 3,
                        );
                    }
                    $this->custom_field_model->delete_answer($id, $form = 3);
                    $this->custom_field_model->save_answer($save_fields);
                }
                //$this->session->set_flashdata('message',lang('to_do_updated'));
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

    function view_to_do($id = false) {
        $data['fields'] = $this->custom_field_model->get_custom_fields(3);
        $data['list'] = $data['clients'] = $this->to_do_list_model->get_list_by_id($id);
        $data['id'] = $id;
        //$this->to_do_list_model->to_do_view_by_admin($id);
        $data['page_title'] = 'View To Do ';
        $data['body'] = 'to_do_list/view';
        $this->load->view('template/main', $data);
    }

    function delete($id = false) {

        if ($id) {
            $this->to_do_list_model->delete($id);
            $this->session->set_flashdata('message', lang('to_do_deleted'));
            redirect('admin/to_do_list');
        }
    }

    function mark_as_done($id) {
        $this->to_do_list_model->to_do_view_by_admin($id);
        redirect("/admin/to_do_list/view_to_do/" . $id);
    }

}
