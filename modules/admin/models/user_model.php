<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_model
 *
 * @author kofoworola
 */
class user_model extends CI_Model {

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
    
    function get_all_users() {
        $this->db->where('user_role', 1);
        return $this->db->get('users')->result();
    }

    function save($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $save);
    }

    function add($save) {
        $this->db->insert('users', $save);
        return $this->db->insert_id();
    }

    function convert_id($type, $id) {
        $prefix = '';
        switch ($type) {
            case 'clinics':
                $prefix = "PCPVP";
                break;
            case 'business':
                $prefix = "PCPB";
                break;
            case 'non-profit':
                $prefix = "PCPNP";
                break;
        }
        $num_length = strlen((string) $id);
        if ($num_length < 2) {
            return $prefix . "0" . $id;
        } else {
            return $prefix . $id;
        }
    }

    function get_type($type_raw) {
        $type = '';
        switch ($type_raw) {
            case 'clinics':
                $type = lang('clinic');
                break;
            case 'business':
                $type = lang('business');
                break;
            case 'non-profit':
                $type = lang('profit');
                break;
        }

        return $type;
    }

    function get_user_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('users', $save);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

}
