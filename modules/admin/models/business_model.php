<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of business_model
 *
 * @author kofoworola
 */
class business_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_all_businesses() {
        $this->db->where('user_role', 1);
        $this->db->where('user_type', "business");
        return $this->db->get('users')->result();
    }

    function get_business_by_id($id) {
        $this->db->where('id', $id);
        $this->db->where('user_type', "business");
        return $this->db->get('users')->row();
    }

    function save($save) {
        $this->db->insert('users', $save);
        return $this->db->insert_id();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $save);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->where('user_type', "business");
        $this->db->delete('users');
    }

    function convert_id($id) {
        $prefix = "PCPB";
        $num_length = strlen((string) $id);
        if ($num_length < 2) {
            return $prefix . "0" . $id;
        } else {
            return $prefix.$id;
        }
    }

}
