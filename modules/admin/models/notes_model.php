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
class notes_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function convert_id($id) {
        $prefix = "PCPN";
        $num_length = strlen((string) $id);
        if ($num_length < 2) {
            return $prefix . "0" . $id;
        } else {
            return $prefix.$id;
        }
    }
    
    function save($save) {
        $this->db->insert('notes', $save);
        return $this->db->insert_id();
    }

    function get_all() {
        $this->db->order_by('datetime', 'DESC');
        return $this->db->get('notes')->result();
    }

    function get_notes_by_doctor() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('N.doctor_id', $admin['id']);
        } else {
            $this->db->where('N.doctor_id', $admin['id']);
        }
        $this->db->order_by('N.datetime', 'DESC');
        $this->db->select('N.*,U.name patient');
        $this->db->join('users  U', 'U.id = N.patient_id', 'LEFT');
        return $this->db->get('notes N')->result();
    }

    function get_notes_by_patient($id) {
        $this->db->where('N.patient_id', $id);
        $this->db->order_by('N.datetime', 'DESC');
        $this->db->select('N.*,U.name patient');
        $this->db->join('users  U', 'U.id = N.patient_id', 'LEFT');
        return $this->db->get('notes N')->result();
    }

    function get_notes_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('notes')->row();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('notes', $save);
    }

    function delete($id) {//delte
        $this->db->where('id', $id);
        $this->db->delete('notes');
    }

}
