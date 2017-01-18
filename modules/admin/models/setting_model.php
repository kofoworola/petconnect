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
class setting_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_all_setting()
    {
        return $this->db->get('settings')->result();
    }
    function delete_setting_by_id($id)
    {
        $this->db->where('doctor_id', $id);
        $this->db->delete("settings");
    }

    function get_setting_name_by_id($id) {
        $this->db->where('doctor_id', $id);
        $result = $this->db->get("settings")->result();
        $name = 'No business name assigned';
        if (!empty($result)) {
            $name = $result[0]->name;
        }

        return $name;
    }

    function get_setting_by_id($id) {
        $this->db->where('doctor_id', $id);
        return $this->db->get("settings")->row();
    }

    function get_setting() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == "Admin") {
            $this->db->where('doctor_id', 0);
            return $this->db->get('settings')->row();
        }
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
            return $this->db->get('settings')->row();
        }
        if ($admin['user_role'] == 3) {
            $this->db->where('doctor_id', $admin['doctor_id']);
            return $this->db->get('settings')->row();
        }
    }

    function get_user() {
        $admin = $this->session->userdata('admin');

        $this->db->where('id', $admin['id']);
        return $this->db->get('users')->row();
    }

    function get_notification_setting() {
        $admin = $this->session->userdata('admin');


        $this->db->where('id', $admin['id']);
        return $this->db->get('users')->row();
    }

    function update($save) {
        $admin = $this->session->userdata('admin');

        $result = $this->get_setting();
        if ((empty($result))) {
            $this->db->insert('settings', $save);
        } else {
            if ($admin['user_role'] == "Admin") {
                $this->db->where('doctor_id', 0);
            } else {
                $this->db->where('doctor_id', $admin['id']);
            }


            $this->db->update('settings', $save);
        }
    }

    function update_by_id($save, $id) {
        $result = $this->get_setting_by_id($id);
        if ((empty($result))) {
            $this->db->insert('settings', $save);
        } else {
            $this->db->where('doctor_id', $id);
            $this->db->update('settings', $save);
        }
    }

    function get_notification_setting_client() {
        $admin = $this->session->userdata('admin');
        $this->db->where('id', $admin['id']);
        return $this->db->get('users')->row();
    }

    function get_case_alert() {
        $this->db->where('EC.next_date <=', date("Y-m-d", strtotime("+" . $this->get_notification_setting_client()->client_case_alert . " days")));
        $this->db->where('EC.next_date >=', date("Y-m-d"));
        $this->db->where('EC.is_view', 0);
        $this->db->order_by('EC.next_date', 'ASC');
        $this->db->join('cases C', 'C.id = EC.case_id', 'LEFT');
        return $this->db->get('extended_case EC')->result();
    }

    function get_to_do_alert() {
        $d = $this->get_notification_setting()->to_do_alert;
        $Date = date("Y-m-d");
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->where('date <', date('Y-m-d', strtotime($Date . ' + 14 days')));
        //$this->db->where('date >=', date("Y-m-d"));
        $this->db->where('is_view', 0);
        return $this->db->get('to_do_list')->result();
    }

    function get_appointment_alert() {

        $admin = $this->session->userdata('admin');
        $this->db->where('date <=', date("Y-m-d", strtotime("+" . @$this->get_notification_setting()->appointment_alert . " days")));
        $this->db->where('date >=', date("Y-m-d"));
        $this->db->where('A.doctor_id', $admin['id']);
        $this->db->where('A.is_view ', 0);
        $this->db->select('A.*,U.name,C.name contact');
        $this->db->join('users U', 'U.id = A.patient_id', 'LEFT');
        $this->db->join('contacts  C', 'C.id = A.contact_id', 'LEFT');
        return $this->db->get('appointments A')->result();
    }

    function get_appointment_alert_patient() {
        $admin = $this->session->userdata('admin');
        $this->db->where('date <=', date("Y-m-d", strtotime("+" . @$this->get_notification_setting()->appointment_alert . " days")));
        $this->db->where('date >=', date("Y-m-d"));
        $this->db->where('A.is_view ', 0);
        $this->db->select('A.*,U.name');
        $this->db->where('A.patient_id', $admin['id']);
        $this->db->join('users U', 'U.id = A.patient_id', 'LEFT');
        return $this->db->get('appointments A')->result();
    }

}
