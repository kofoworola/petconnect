<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Memento admin_model model
 *
 * This class handles admin_model management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model
 * @author		propertyjar
 * @link		#
 */
class assistant_model extends CI_Model {

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

    function convert_rule($rules_raw) {
        $rules_made = explode(',', $rules_raw);
        $rules = Array();

        foreach ($rules_made as $value) {
            switch ($value) {
                case 'patients':
                    $rules['patient'] = 1;
                    break;
                case 'payments':
                    $rules['payments'] = 1;
                    break;
                case 'prescriptions':
                    $rules['prescriptions'] = 1;
                    break;
                case 'calendar':
                    $rules['calendar'] = 1;
                    break;
                case 'message':
                    $rules['message'] = 1;
                    break;
                case 'todo':
                    $rules['todo'] = 1;
                    break;
                case 'notes':
                    $rules['notes'] = 1;
                    break;
                case 'contacts':
                    $rules['contacts'] = 1;
                    break;
                case 'appointment':
                    $rules['appointment'] = 1;
                    break;
                case 'locations':
                    $rules['locations'] = 1;
                    break;
                default:
                    break;
            }
        }
        return $rules;
    }

    function get_type($type_raw) {
        $type = '';
        switch ($type_raw) {
            case 'management':
                $type = 'Management Staff';
                break;
            case 'office':
                $type = 'Office Staff';
                break;
            case 'medical':
                $type = 'Medical Staff';
                break;
        }
        return $type;
    }

    function get_payment_by_doctor() {
        $admin = $this->session->userdata('admin');
        $this->db->where('U.doctor_id', $admin['id']);

        $this->db->order_by('AP.invoice', 'DESC');
        $this->db->select('AP.*,PM.name mode,U.name assistant');
        $this->db->join('payment_modes PM', 'PM.id = AP.payment_mode_id', 'LEFT');
        $this->db->join('users U', 'U.id = AP.assistant_id', 'LEFT');
        return $this->db->get('assistant_payment AP')->result();
    }

    function get_payment_by_id($id) {
        $this->db->where('F.id', $id);

        $this->db->select('F.*,PM.name mode,U.name assistant');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        $this->db->join('users U', 'U.id = F.assistant_id', 'LEFT');
        return $this->db->get('assistant_payment F')->row();
    }

    function get_assistants_by_invoice($id) {
        $this->db->where('PT.id', $id);
        $this->db->select('F.*,PM.name mode');
        $this->db->order_by('F.invoice', 'DESC');
        $this->db->join('users PT', 'PT.id = F.assistant_id', 'LEFT');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        return $this->db->get('assistant_payment F')->result();
    }

    function update_fees($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('assistant_payment', $save);
    }

    function get_invoice_number() {
        $admin = $this->session->userdata('admin');
        $this->db->where('U.doctor_id', $admin['id']);
        $this->db->select_max('invoice');
        $this->db->join('users U', 'U.id = F.assistant_id', 'LEFT');
        return $this->db->get('assistant_payment F')->row();
    }

    function save_payment($save) {
        $this->db->insert('assistant_payment', $save);
    }

    function get_username() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->where('user_role', 3);
        $this->db->select_max('id');
        $assistant = $this->db->get('users')->row();

        $this->db->where('id', $assistant->id);
        return $this->db->get('users')->row();
    }

    function save($save) {
        $this->db->insert('users', $save);
        return $this->db->insert_id();
    }

    function get_all() {
        $this->db->where('user_role', 3);
        return $this->db->get('users')->result();
    }

    function get_assistants_by_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } elseif ($admin['user_role'] == 3) {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('user_role', 3);
        $this->db->order_by("name", "asc");
        return $this->db->get('users')->result();
    }

    function get_users_by_assistant() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 3) {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }
        $this->db->where('user_role', 3);
        $this->db->where('id !=',$admin['id']);
        $result = $this->db->get('users')->result();
        $this->db->where('id', $admin['doctor_id']);
        $this->db->where('user_role', 1);
        $doctor = $this->db->get('users')->result();
        return array_merge($doctor, $result);
    }

    function get_assistants_by_doctor_ajax($id) {
        if ($id == 0) {
            $admin = $this->session->userdata('admin');
            $this->db->where('doctor_id', $admin['id']);
            $this->db->where('user_role', 3);
            return $this->db->get('users')->result();
        }

        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->where('id', $id);
        $this->db->where('user_role', 3);
        return $this->db->get('users')->result();
    }

    function get_all_assistant() {
        $this->db->where('user_role', 3);
        return $this->db->get('users')->result();
    }

    function get_assistant_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }

    function get_assistant_filter($id) {
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

        $this->db->join('users PT', 'PT.id = F.patient_id', 'LEFT');
        $this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
        return $this->db->get('fees F')->result();
    }

    function delete($id) {//delte client
        $this->db->where('id', $id);
        $this->db->delete('assistant_payment');
    }

    function delete_assistant($id) {//delte client
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

}
