<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . '/third_party/PHPExcel/IOFactory.php';

class contacts extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model("contact_model");
        $this->load->model("patient_model");
        $this->load->model("custom_field_model");
        $this->load->library('excel');
    }

    function index() {
        $data['fields'] = $this->custom_field_model->get_custom_fields(4);
        $data['contacts'] = $this->contact_model->get_contact_by_doctor();
        $data['page_title'] = lang('contacts');
        $data['body'] = 'contacts/list';
        $this->load->view('template/main', $data);
    }

    function export() {
        $data['contacts'] = $this->contact_model->get_all();
        $this->load->view('contacts/export', $data);
    }

    function import_patients() {
        $admin = $this->session->userdata('admin');
        $patients = $this->patient_model->get_patients_by_doctor();
        //print_r($patients);die();
        foreach ($patients as $patient) {

            $save['name'] = $patient->name;
            $save['contact'] = $patient->contact;
            $save['email'] = $patient->email;
            $save['address'] = $patient->address;
            if ($admin['user_role'] == 1) {
                $save['doctor_id'] = $admin['id'];
            }
            $p_key = $this->contact_model->save($save);
        }
        $this->session->set_flashdata('message', 'Contacts have been imported');
        echo 'done';
        redirect('admin/contacts');
    }

    function add() {
        $data['fields'] = $this->custom_field_model->get_custom_fields(4);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_message('required', lang('custom_required'));
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'required');
            $this->form_validation->set_rules('phone', 'lang:phone', '');
            $this->form_validation->set_rules('address', 'lang:address', '');

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                $save['name'] = $this->input->post('name');
                $save['contact'] = $this->input->post('phone');
                $save['email'] = $this->input->post('email');
                $save['address'] = $this->input->post('address');
                $p_key = $this->contact_model->save($save);
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $p_key,
                            'form' => 4,
                        );
                    }
                    $this->custom_field_model->save_answer($save_fields);
                }
                $this->session->set_flashdata('message', lang('contact_created'));
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
        $data['fields'] = $this->custom_field_model->get_custom_fields(4);
        $data['contact'] = $data['clients'] = $this->contact_model->get_contact_by_id($id);
        $data['id'] = $id;
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'lang:name', 'required');
            $this->form_validation->set_rules('email', 'lang:email', 'required');
            $this->form_validation->set_message('required', lang('custom_required'));

            if ($this->form_validation->run() == true) {
                $admin = $this->session->userdata('admin');
                if ($admin['user_role'] == 1) {
                    $save['doctor_id'] = $admin['id'];
                }
                if ($admin['user_role'] == 3) {
                    $save['doctor_id'] = $admin['doctor_id'];
                }

                $save['name'] = $this->input->post('name');
                $save['contact'] = $this->input->post('phone');
                $save['email'] = $this->input->post('email');
                $save['address'] = $this->input->post('address');
                $reply = $this->input->post('reply');
                if (!empty($reply)) {
                    foreach ($this->input->post('reply') as $key => $val) {
                        $save_fields[] = array(
                            'custom_field_id' => $key,
                            'reply' => $val,
                            'table_id' => $id,
                            'form' => 4,
                        );
                    }
                    $this->custom_field_model->delete_answer($id, $form = 4);
                    $this->custom_field_model->save_answer($save_fields);
                }
                $this->contact_model->update($save, $id);
                $this->session->set_flashdata('message', lang('contact_updated'));
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

    function import() {

        if ($this->input->server('REQUEST_METHOD') === 'POST')
            $config['upload_path'] = './assets/uploads/files/';
        $config['file_name'] = 'myfile';
        $config['allowed_types'] = 'xlsx|xml|xls|csv';
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', lang('please_select_correct_file_format'));
            redirect(base_url("admin/contacts/"));
        } else {
            $data = array('upload_data' => $this->upload->data());
        }


        $inputFileName = 'assets/uploads/files/' . $data['upload_data']['file_name']; // 

        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);

        /**  Define how many rows we want to read for each "chunk"  * */
        $chunkSize = 1000000;
        /**  Create a new Instance of our Read Filter  * */
        $chunkFilter = new chunkReadFilter();

        /**  Tell the Reader that we want to use the Read Filter that we've Instantiated  * */
        $objReader->setReadFilter($chunkFilter);

        $chunkFilter->setRows(0, $chunkSize);
        /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $save = array();
        $admin = $this->session->userdata('admin');
        foreach ($sheetData as $ind => $values) {
            $save[$ind] = '';
            $admin = $this->session->userdata('admin');
            $access = $admin['user_role'];

            foreach ($values as $in => $val) {
                if ($access == 1) {
                    $save[$ind]['doctor_id'] = $admin['id'];
                }
                if ($access == 3) {
                    $save[$ind]['doctor_id'] = $admin['doctor_id'];
                }

                if ($in == 'A')
                    $save[$ind]['name'] = $val;
                if ($in == 'B')
                    $save[$ind]['contact'] = $val;
                if ($in == 'C')
                    $save[$ind]['email'] = $val;
                if ($in == 'D')
                    $save[$ind]['address'] = $val;
            }
        }
        //echo '<pre>'; print_r($save);die;
        $this->contact_model->import_data($save);

        $this->session->set_flashdata('message', lang('data_imported'));
        //import code end
        redirect(site_url("admin/contacts/"));
    }

    function delete($id = false) {

        if ($id) {
            $this->contact_model->delete($id);
            $this->session->set_flashdata('message', lang('contact_deleted'));
            redirect('admin/contacts');
        }
    }

}

class chunkReadFilter implements PHPExcel_Reader_IReadFilter {

    private $_startRow = 0;
    private $_endRow = 0;

    /**  Set the list of rows that we want to read  */
    public function setRows($startRow, $chunkSize) {
        $this->_startRow = $startRow;
        $this->_endRow = $startRow + $chunkSize;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
            return true;
        }
        return false;
    }

}
