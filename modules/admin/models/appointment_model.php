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
class appointment_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function save($save) {
        $this->db->insert('appointments', $save);
        return $this->db->insert_id();
    }

    function get_appointment_by_patient($id) {

        $this->db->where('A.patient_id', $id);
        $this->db->order_by('A.date', 'DESC');
        $this->db->where('A.whom', 1);
        $this->db->select('A.*,U1.name doctor,U.name patient');
        $this->db->join('users  U', 'U.id = A.patient_id', 'LEFT');
        $this->db->join('users  U1', 'U1.id = A.doctor_id', 'LEFT');
        return $this->db->get('appointments A')->result();
    }

    function get_appointment_by_doctor($id) {

        $this->db->where('A.doctor_id', $id);
        $this->db->order_by('A.date', 'DESC');
        $this->db->select('A.*,U.name patient,C.name contact');
        $this->db->join('users  U', 'U.id = A.patient_id', 'LEFT');
        $this->db->join('users  U1', 'U1.id = A.doctor_id', 'LEFT');
        $this->db->join('contacts C', 'C.id = A.contact_id', 'LEFT');
        return $this->db->get('appointments A')->result();
    }

    function get_appointment_by_doctor_id($id) {

        $this->db->where('A.id', $id);
        $this->db->select('A.*,U.name patient');
        $this->db->join('users  U', 'U.id = A.patient_id', 'LEFT');
        $this->db->join('users  U1', 'U1.id = A.doctor_id', 'LEFT');
        return $this->db->get('appointments A')->row();
    }

    function appointment_view_by_admin($id) {
        $this->db->where('id', $id);
        $this->db->set('is_view', 1);
        $this->db->update('appointments');
    }

    function close_record($id) {
        $this->db->where('id', $id);
        $this->db->set('is_closed', 1);
        $this->db->update('appointments');
    }

    function update_status($id, $val) {
        $this->db->where('id', $id);
        $this->db->set('status', $val);
        $this->db->update('appointments');
    }

    function appointments_view_by_admin($ids) {
        $this->db->where_in('id', $ids);
        $this->db->set('is_view', 1);
        $this->db->update('appointments');
    }

    function get_appointment_by_date() {

        //$this->db->where('date_time >=',date('Y-m-d'));
        //$this->db->order_by('date_time','ASC');
        //$this->db->join('contacts C', 'C.id = A.contact_id', 'LEFT');
        return $this->db->get('appointments A')->result();
    }

    function get_all() {
        return $this->db->get('appointments A')->result();
    }

    function get_appointment_by_id($id) {


        $this->db->where('A.id', $id);
        $this->db->select('A.*,U.name,C.name contact');
        $this->db->join('users U', 'U.id = A.patient_id', 'LEFT');
        $this->db->join('contacts C', 'C.id = A.contact_id', 'LEFT');

        return $this->db->get('appointments A')->row();
    }

    function get_contacts() {
        return $this->db->get('contacts')->result();
    }

    function get_days() {
        return $this->db->get('days')->result();
    }

    function update($save, $id) {

        $this->db->where('id', $id);
        $this->db->update('appointments', $save);
    }

    function update_days($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('rel_days_doctors', $save);
    }

    function check_time($id) {
        $this->db->where('id', $id);
        return $this->db->get('rel_days_doctors')->row();
    }

    function get_appointment_time($id) {
        $this->db->where('doctor_id', $id);
        return $this->db->get('rel_days_doctors')->result();
    }

    function save_days($save) {
        $this->db->insert('rel_days_doctors', $save);
    }

    function delete_days($id) {
        $this->db->where('id', $id);
        $this->db->delete('rel_days_doctors');
    }

    function delete($id) {//delte client
        $this->db->where('id', $id);
        $this->db->delete('appointments');
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
