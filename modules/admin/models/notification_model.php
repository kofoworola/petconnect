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
class notification_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_template() {
        $admin = $this->session->userdata('admin');
        if ($admin['user_role'] == 1) {
            $this->db->where('doctor_id', $admin['id']);
        } else {
            $this->db->where('doctor_id', $admin['doctor_id']);
        }

        return $this->db->get('prescription_template')->row();
    }

    function update_template($save) {
        $data = $this->get_template();
        if (empty($data)) {

            $this->db->insert('prescription_template', $save);
        } else {
            $admin = $this->session->userdata('admin');
            $this->db->where('doctor_id', $admin['id']);
            $this->db->update('prescription_template', $save);
        }
    }

    function get_setting() {
        $admin = $this->session->userdata('admin');
        $this->db->where('id', $admin['id']);
        return $this->db->get('users')->row();
    }

    function update($save) {
        $admin = $this->session->userdata('admin');
        $this->db->where('id', $admin['id']);
        $this->db->update('users', $save);
    }

}
