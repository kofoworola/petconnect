<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Locations extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model("hospital_model");
        $this->load->model("schedule_model");
    }

    function index() {
        redirect('admin/locations/add');
    }

    function select_hospital($view = false) {
        $data['hospitals'] = $this->hospital_model->get_hospital_by_doctor();
        $view = $this->uri->segment(4);
        $data['view'] = $view;
        if ($view == "view") {
            //$this->session->set_userdata();
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $this->load->library('form_validation');
                $this->form_validation->set_message('required', lang('custom_required'));
                $this->form_validation->set_rules('hospital_id', 'lang:hospital', 'required');

                if ($this->form_validation->run() == true) {
                    $id = $this->input->post('hospital_id');

                    redirect('admin/hospital/manage_schedule/' . $id);
                }
            }
        } else {
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $this->load->library('form_validation');
                $this->form_validation->set_message('required', lang('custom_required'));
                $this->form_validation->set_rules('hospital_id', 'lang:hospital', 'required');

                if ($this->form_validation->run() == true) {
                    $id = $this->input->post('hospital_id');

                    redirect('admin/hospital/add_schedule/' . $id);
                }
            }
        }

        $data['page_title'] = lang('Add') . ' ' . lang('schedule');
        $data['body'] = 'hospitals/select_hospital';
        $this->load->view('template/main', $data);
    }

    function add() {
        //echo '<pre>'; print_r($_POST);die;
        $data['hospital_type'] = $this->hospital_model->get_hospital_type();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');

            if ($this->form_validation->run() == true) {
                $save['name'] = $this->input->post('name');
                $save['address'] = $this->input->post('address');
                $save['phone'] = $this->input->post('phone');
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $this->hospital_model->save($save);

                $this->session->set_flashdata('message', lang('hospital_saved'));
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
        $data['hospital_details'] = $this->hospital_model->get_hospital_by_id($id);
        $data['hospital_type'] = $this->hospital_model->get_hospital_type();
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');

            if ($this->form_validation->run() == true) {
                $save['name'] = $this->input->post('name');
                $save['address'] = $this->input->post('address');
                $save['phone'] = $this->input->post('phone');
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                if ($this->hospital_model->edit_hospital($save, $id)) {
                    //echo '<pre>'; print_r($save);die;	
                    $this->session->set_flashdata('message', lang('hospital_edit'));
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

    function delete($id = false) {

        if ($id) {
            if ($this->hospital_model->delete($id)) {
                $this->session->set_flashdata('message', lang('hospital_deleted'));
                redirect('admin/location/view_all');
            }
        }
    }

    function view_all() {
        $data['hospitals'] = $this->hospital_model->get_hospital_by_doctor();
        $data['page_title'] = lang('view') . ' ' . lang('hospital');
        $data['body'] = 'hospitals/view_all';
        $this->load->view('template/main', $data);
    }

    function view_hospital($id = false) {

        $data['hospital_details'] = $this->hospital_model->get_hospital_by_id($id);
        $data['page_title'] = lang('view') . lang('hospital');
        $data['body'] = 'hospitals/view';
        $this->load->view('template/main', $data);
    }

    function add_schedule($id) {
        $data['h_id'] = $id;
        $data['days'] = $this->schedule_model->get_days();
        $data['schedule'] = $this->schedule_model->get_schedule_by_id($id);
        $data['fixed_schedule'] = $this->schedule_model->get_all_fixed_schedule_for_hospital($id);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('work', 'lang:name', 'required');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $save['day'] = $this->input->post('day_id');
                $save['timing_from'] = date("H:i", strtotime($this->input->post('start')));
                $save['timing_to'] = date("H:i", strtotime($this->input->post('end')));
                $save['work'] = $this->input->post('work');

                $save['hospital'] = $id;
                $save['type'] = 1;
                if ($this->schedule_model->save_schedule($save)) {
                    $this->session->set_flashdata('message', lang('schedule_saved'));
                    redirect('admin/hospital/add_schedule/' . $id);
                }
            }
        }
        $data['page_title'] = lang('add') . lang('schedule');
        $data['body'] = 'hospitals/add_schedule';
        $this->load->view('template/main', $data);
    }

    function edit_schedule($id, $h_id) {
        $data['days'] = $this->schedule_model->get_days();
        $data['schedule'] = $this->schedule_model->get_schedule_by_id($id);
        //echo '<pre>'; print_r($data['schedule']);die;

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('work', 'lang:name', '');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $save['day'] = $this->input->post('day_id');
                $save['timing_from'] = date("H:i", strtotime($this->input->post('start')));
                $save['timing_to'] = date("H:i", strtotime($this->input->post('end')));
                $save['work'] = $this->input->post('work');

                $save['hospital'] = $data['schedule']->h_id;
                $save['type'] = 1;
                //echo '<pre>'; print_r($save);die;
                if ($this->schedule_model->edit_schedule($save, $id)) {
                    $this->session->set_flashdata('message', lang('schedule_saved'));
                    redirect('admin/hospital/add_schedule/' . $h_id);
                }
            }
        }
        $data['page_title'] = lang('edit') . lang('schedule');
        $data['body'] = 'hospitals/edit_schedule';
        $this->load->view('template/main', $data);
    }

    function edit_schedule_manage($id, $h_id) {
        $data['days'] = $this->schedule_model->get_days();
        $data['schedule'] = $this->schedule_model->get_schedule_by_id($id);
        //echo '<pre>'; print_r($data['schedule']);die;

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('work', 'lang:name', '');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }
                $save['day'] = $this->input->post('day_id');
                $save['timing_from'] = date("H:i", strtotime($this->input->post('start')));
                $save['timing_to'] = date("H:i", strtotime($this->input->post('end')));
                $save['work'] = $this->input->post('work');

                $save['hospital'] = $data['schedule']->h_id;
                $save['type'] = 1;
                //echo '<pre>'; print_r($save);die;
                if ($this->schedule_model->edit_schedule($save, $id)) {
                    $this->session->set_flashdata('message', lang('schedule_saved'));
                    redirect('admin/hospital/manage_schedule/' . $h_id);
                }
            }
        }
        $data['page_title'] = lang('edit') . lang('schedule');
        $data['body'] = 'hospitals/edit_schedule';
        $this->load->view('template/main', $data);
    }

    function manage_schedule($id) {
        $data['days'] = $this->schedule_model->get_days();
        $data['schedule'] = $this->schedule_model->get_schedule_by_id($id);
        $data['fixed_schedule'] = $this->schedule_model->get_all_fixed_schedule_for_hospital($id);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('work', 'lang:name', '');

            if ($this->form_validation->run() == true) {
                $save['day'] = $this->input->post('day_id');
                $save['timing_from'] = date("H:i", strtotime($this->input->post('start')));
                $save['timing_to'] = date("H:i", strtotime($this->input->post('end')));
                $save['work'] = $this->input->post('work');
                $save['doctor_id'] = $this->session->userdata['admin']['id'];
                $save['hospital'] = $data['schedule']->hospital;

                if ($this->schedule_model->save_schedule($save)) {
                    $this->session->set_flashdata('message', lang('schedule_saved'));
                    redirect('admin/hospital');
                }
            }
        }
        $data['page_title'] = lang('add') . lang('schedule');
        $data['body'] = 'hospitals/manage_schedule';
        $this->load->view('template/main', $data);
    }

    function manage($id) {
        $data['id'] = $id;
        if ($this->input->post('s1')) {
            $fixed_type = $this->input->post('fixed_type');
            if ($fixed_type == 1) {
                redirect('admin/hospital/view_hospital_schedule/' . $id);
            } else if ($fixed_type == 2) {
                redirect('admin/hospital/view_hospital_2schedule/' . $id);
            }
        }
        $this->load->model('schedule_model');
        $data['days'] = $this->schedule_model->get_days();
        $data['hospital_details'] = $this->hospital_model->get_hospital_by_id($id);
        $data['page_title'] = lang('view') . lang('hospital');
        $data['body'] = 'hospitals/manage';
        $this->load->view('template/main', $data);
    }

    function delete_week_schedule($id, $h_id = false) {
        if ($id) {
            $this->schedule_model->delete_week_schedule($id);
            $this->session->set_flashdata('message', "schedule_deleted");

            redirect('admin/hospital/add_schedule/' . $h_id);
        }
    }

    function delete_week_schedule_manage($id, $h_id = false) {
        if ($id) {
            $this->schedule_model->delete_week_schedule($id);
            $this->session->set_flashdata('message', "schedule_deleted");

            redirect('admin/hospital/manage_schedule/' . $h_id);
        }
    }

    function view_hospital_2schedule($id) {
        $data['id'] = $id;
        if ($this->input->post('s1')) {
            $fixed_type = $this->input->post('fixed_type');
            if ($fixed_type == 1) {
                redirect('admin/hospital/view_weekly_schedule/' . $id);
            } else if ($fixed_type == 2) {
                redirect('admin/hospital/view_monthly_schedule/' . $id);
            }
        }
        $this->load->model('schedule_model');
        $data['days'] = $this->schedule_model->get_days();
        $data['hospital_details'] = $this->hospital_model->get_hospital_by_id($id);
        $data['page_title'] = lang('view') . lang('hospital');
        $data['body'] = 'hospitals/view_hospital_schedule';
        $this->load->view('template/main', $data);
    }

    function view_hospital_schedule($id) {
        $data['id'] = $id;
        if ($this->input->post('s1')) {
            $fixed_type = $this->input->post('fixed_type');
            if ($fixed_type == 1) {
                redirect('admin/hospital/view_week_schedule/' . $id);
            } else if ($fixed_type == 2) {
                redirect('admin/hospital/view_month_schedule/' . $id);
            }
        }
        $this->load->model('schedule_model');
        $data['days'] = $this->schedule_model->get_days();
        $data['hospital_details'] = $this->hospital_model->get_hospital_by_id($id);
        $data['page_title'] = lang('view') . lang('hospital');
        $data['body'] = 'hospitals/view_hospital_schedule';
        $this->load->view('template/main', $data);
    }

    function view_weekly_schedule($id) {

        if ($this->input->post('s2')) {
            //echo '<pre>' ;print_r($_POST); die;
            $admin = $this->session->userdata('admin');
            $this->schedule_model->delete_fixed_schedule_for_hospital($admin['id'], $id);
            foreach ($_POST['schedule'] as $key => $value) {
                $day_id = $key;
                //$this->schedule_model->delete_row($day_id);
                foreach ($value as $data) {
                    if (!empty($data['from'])) {
                        $save = array(
                            'doctor_id' => $admin['id'],
                            'day' => $day_id,
                            'timing_from' => $data['from'],
                            'timing_to' => $data['to'],
                            'work' => $data['work'],
                            'hospital' => $id
                        );
                        //echo '<pre>'; print_r($save); die;
                        if ($this->schedule_model->update_schedule($save)) {
                            $this->session->set_flashdata('message', "Your Schedule is Updated!!");
                        }
                    }
                }
            }
        }
        $this->load->model('schedule_model');
        $data['fixed_schedule'] = $this->schedule_model->get_all_fixed_schedule_for_hospital($this->session->userdata['admin']['id'], $id);
        $data['days'] = $this->schedule_model->get_days();
        $data['hospital'] = $this->hospital_model->get_all();
        $data['body'] = 'hospitals/view_weekly_schedule';
        $this->load->view('template/main', $data);
    }

    function view_monthly_schedule($id) {


        if ($this->input->post('s1')) {
            $admin = $this->session->userdata('admin');

            $this->schedule_model->delete_monthly_schedule_for_hospital($admin['id'], $id);

            foreach ($_POST['schedule'] as $key => $value) {
                $day_id = $key;
                //$this->schedule_model->delete_row($day_id);
                foreach ($value as $data) {
                    if (!empty($data['from'])) {
                        $save = array(
                            'date_id' => $day_id,
                            'doctor_id' => $this->session->userdata['admin']['id'],
                            'timing_from' => $data['from'],
                            'timing_to' => $data['to'],
                            'work' => $data['work'],
                            'hospital' => $id,
                        );
                        //echo '<pre>'; print_r($save); die;
                        $this->schedule_model->monthly_schedule($save);
                    }
                }
            }

            $this->session->set_flashdata('message', "Your Monthly Schedule Entry is Saved!!");
            redirect('admin/hospital/view_monthly_schedule/' . $id);
        }


        $data['monthly_schedule'] = $this->schedule_model->get_monthly_schedule_for_hospital($this->session->userdata['admin']['id'], $id);
        //echo '<pre>'; print_r($data['monthly_schedule']); die;
        $this->load->model('hospital_model');
        $data['hospital'] = $this->hospital_model->get_all();
        $data['body'] = 'hospitals/view_monthly_schedule';
        $this->load->view('template/main', $data);
    }

    function view_month_schedule($id) {
        $data['monthly_schedule'] = $this->schedule_model->get_monthly_schedule_for_hospital($this->session->userdata['admin']['id'], $id);
        //echo '<pre>'; print_r($data['monthly_schedule']); die;
        $this->load->model('hospital_model');
        $data['hospital'] = $this->hospital_model->get_all();
        $data['body'] = 'hospitals/view_monthly_schedule_for_hospital';
        $this->load->view('template/main', $data);
    }

    function view_week_schedule($id) {
        $this->load->model('schedule_model');
        $data['fixed_schedule'] = $this->schedule_model->get_all_fixed_schedule_for_hospital($this->session->userdata['admin']['id'], $id);
        $data['days'] = $this->schedule_model->get_days();
        $data['hospital'] = $this->hospital_model->get_all();
        $data['body'] = 'hospitals/view_weekly_schedule_for_hospital';
        $this->load->view('template/main', $data);
    }

}
