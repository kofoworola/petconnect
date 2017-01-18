<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of custom_field_reply_model
 *
 * @author kofoworola
 */
class custom_field_reply_model extends CI_Model{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_field_reply($id)
    {
        $this->database->where('custom_field_id', $id);
        return $this->db->get('rel_form_custom_fields')->result();
    }
    
    function get_reply_by_user($id)
    {
        $this->database->where('table_id',$id);
        return $this->db->get('rel_form_custom_fields')->result();
    }
}
