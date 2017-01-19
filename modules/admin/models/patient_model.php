<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class patient_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function generate_username($fname, $lname) {
        $raw_username = strtolower($fname)[0] . strtolower($lname);
        $username = $raw_username;
        $suffix = 0;
        a:
        $this->db->where('username', $username);
        $this->db->order_by('add_date', 'DESC');
        $result = $this->db->get('users')->result();
        $result = array_filter($result);
        if (!empty($result)) {
            $suffix ++;
            $username = $raw_username . $suffix;
            goto a;
        } else {
            return $username;
        }
    }

    function convertId($id) {
        $prefix = "PCPU";
        $num_length = strlen((string) $id);
        if ($num_length < 2) {
            return $prefix . "0" . $id;
        } else {
            return $prefix . $id;
        }
    }

    function get_blood_group() {

        return $this->db->get('blood_group_type')->result();
    }

    function get_username() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->where('user_role', 2);
        $this->db->select_max('id');
        $patient = $this->db->get('users')->row();

        $this->db->where('id', $patient->id);
        return $this->db->get('users')->row();
    }

    function get_username_by_assistant() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['doctor_id']);
        $this->db->where('user_role', 2);
        $this->db->select_max('id');
        $patient = $this->db->get('users')->row();

        $this->db->where('id', $patient->id);
        return $this->db->get('users')->row();
    }

    function save($save) {
        $this->db->insert('users', $save);
        return $this->db->insert_id();
    }

    function get_all() {
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_by_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('user_role', 2);
        $this->db->order_by("name", "asc");
        return $this->db->get('users')->result();
    }

    function get_patients_by_doctor_filter($search, $filter_id) {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        if (!empty($filter_id)) {
            if ($filter_id == "dob") {
                $this->db->like($filter_id, date("Y") - $search);
            } else {
                $this->db->like('LOWER(' . $filter_id . ')', strtolower($search));
            }
        }


        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_by_assistant() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['doctor_id']);
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patients_by_doctor_ajax($id) {
        if ($id == 0) {
            $admin = $this->session->userdata('admin');
            if ($admin['user_role'] == 1) {
                $this->db->where('doctor_id', $admin['id']);
            } else {
                $this->db->where('doctor_id', $admin['doctor_id']);
            }
            $this->db->where('user_role', 2);
            return $this->db->get('users')->result();
        }

        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('id', $id);
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_all_patients() {
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patient_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }
    
    function get_patient_by_id_array($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row_array();
    }

    function get_patient_filter($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->result();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $save);
    }

    function get_patients_by_invoice($id) {
        $this->db->where('PT.id', $id);
        $this->db->select('F.*,PM.name mode');
        $this->db->order_by('F.invoice', 'DESC');
        $this->db->join('users PT', 'PT.id = F.patient_id', 'LEFT');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        return $this->db->get('fees F')->result();
    }

    function get_patients_by_medication($id) {
        $this->db->where('P.patient_id', $id);
        $this->db->order_by('P.id', 'DESC');
        $this->db->select('P.*,U.name patient,U.dob,U.gender');
        $this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
        return $this->db->get('prescription P')->result();
    }

    function delete($id) {//delte client
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

}
