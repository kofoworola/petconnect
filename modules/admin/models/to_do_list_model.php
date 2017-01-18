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
class to_do_list_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function save($save) {
        $this->db->insert('to_do_list', $save);
        return $this->db->insert_id();
    }

    function to_do_view_by_admin($id) {
        $this->db->where('id', $id);
        $this->db->set('is_view', 1);
        $this->db->update('to_do_list');
    }

    function to_dos_view_by_admin($ids) {
        $this->db->where_in('id', $ids);
        $this->db->set('is_view', 1);
        $this->db->update('to_do_list');
    }

    function get_all() {
        $this->db->order_by('date', 'ASC');
        return $this->db->get('to_do_list')->result();
    }

    function get_to_do_by_doctor() {
        $admin = $this->session->userdata('admin');
//        if ($admin['user_role'] == 1) {
//            $this->db->where('doctor_id', $admin['id']);
//        } else {
//            $this->db->where('doctor_id', $admin['doctor_id']);
//        }
        $this->db->where('doctor_id', $admin['id']);
        $this->db->order_by('date', 'DESC');
        return $this->db->get('to_do_list')->result();
    }

    function get_all_by_date() {
        $admin = $this->session->userdata('admin');
        $this->db->where('doctor_id', $admin['id']);
        $this->db->order_by('date', 'ASC');
        $this->db->where('date >=', date('Y-m-d'));
        return $this->db->get('to_do_list')->result();
    }

    function get_list_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('to_do_list')->row();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('to_do_list', $save);
    }

    function delete($id) {//delte
        $this->db->where('id', $id);
        $this->db->delete('to_do_list');
    }

    function check_tables($t1) {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $admin_id = $admin['id'];
        }
        if ($admin['user_role'] == 3) {
            $admin_id = $admin['doctor_id'];
        }
        $next = true;
        if ($next = true) {
            $this->db->where('doctor_id', $admin_id);
            $this->db->where('date =', $t1);
            $this->db->order_by('date', 'DESC');
            $todos = $this->db->get('to_do_list')->result();
        }

        if (!empty($todos)) {
            $next = false;
            return "To Do is available in this time ";
        } else {
            $next = true;
        }


        if ($next = true) {
            $this->db->where('doctor_id', $admin_id);
            $this->db->where('date =', $t1);
            $this->db->order_by('date', 'DESC');
            $appointments = $this->db->get('appointments')->result();
        }


        if (!empty($appointments)) {
            $next = false;
            return "Appointment is available in this time";
        } else {
            $next = true;
        }

        if ($next = true) {

            $this->db->where('doctor_id', $admin_id);
            $this->db->where('day =', date('N', strtotime($t1)));
            $this->db->where('timing_from =', date('H:i:s', strtotime($t1)));
            $schedules = $this->db->get('fixed_schedule')->result();
        }


        if (!empty($schedules)) {
            $next = false;
            return "Hospital / Medical College Schedule is available in this time ";
        } else {
            $next = true;
        }


        if ($next = true) {
            $this->db->where('doctor_id', $admin_id);
            $this->db->where('starttime >=', $t1);
            $this->db->where('endtime <', $t1);
            $events = $this->db->get('event_calendar')->result();
        }

        if (!empty($events)) {
            $next = false;
            return "Other Event Schedule is available in this time";
        } else {
            $next = true;
        }

        if ($next = true) {
            return;
        }
    }

}
