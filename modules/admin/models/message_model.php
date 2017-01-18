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
class message_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function save_message($save) {
        $this->db->insert('message', $save);
    }
    
    function save_user_message($save)
    {
        $this->db->insert('user_message', $save);
    }

    function get_all() {
        return $this->db->get('message')->result();
    }

    function get_all_patients() {
        $this->db->where('user_role', 2);
        return $this->db->get('users')->result();
    }

    function get_patient_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('users')->row();
    }

    function get_doctor_by_patient() {
        $admin = $this->session->userdata('admin');
        $this->db->where('id', $admin['doctor_id']);
        return $this->db->get('users')->row();
    }

    function get_message_by_id($id) {
        $this->db->or_where('M.to_id', $id);
        $this->db->or_where('M.from_id', $id);
        $this->db->select('M.*,U1.name from_user,U2.name to_user,U1.image,M.file');
        $this->db->join('users U2', 'U2.id = M.to_id', 'LEFT');
        $this->db->join('users U1', 'U1.id = M.from_id', 'LEFT');
        return $this->db->get('message M')->result();
    }
    
    function get_user_message_by_id($id) {
        $admin = $this->session->userdata('admin');
        $id_where = '(M.to_id="'.$id.'" or M.from_id = "'.$id.'")';
        $admin_where = '(M.to_id="'.$admin['id'].'" or M.from_id = "'.$admin['id'].'")';
//        $this->db->or_where('M.to_id', $id);
//        $this->db->or_where('M.from_id', $id);
        $this->db->where($id_where);
        $this->db->where($admin_where);
        $this->db->select('M.*,U1.name from_user,U2.name to_user,U1.image,M.file');
        $this->db->join('users U2', 'U2.id = M.to_id', 'LEFT');
        $this->db->join('users U1', 'U1.id = M.from_id', 'LEFT');
        return $this->db->get('user_message M')->result();
    }

    function get_message_by_id_order_by($id) {
        $this->db->or_where('M.to_id', $id);
        $this->db->or_where('M.from_id', $id);
        $this->db->order_by('M.id', 'DESC');
        $this->db->select('M.*,U1.name from_user,U2.name to_user,U1.image');
        $this->db->join('users U2', 'U2.id = M.to_id', 'LEFT');
        $this->db->join('users U1', 'U1.id = M.from_id', 'LEFT');
        return $this->db->get('message M')->result();
    }

    function get_message_count_by_id() {
        $admin = $this->session->userdata('admin');

        $this->db->where('M.to_id', $admin['id']);
        $this->db->where('M.is_view_to', 1);
        $this->db->select('M.*,U1.name from_user,U2.name to_user,U1.image');
        $this->db->join('users U2', 'U2.id = M.to_id', 'LEFT');
        $this->db->join('users U1', 'U1.id = M.from_id', 'LEFT');
        return $this->db->get('message M')->result();
    }

    function get_user_message_count_by_id()
    {
        $admin = $this->session->userdata('admin');
        $this->db->where('M.to_id', $admin['id']);
        $this->db->where('M.is_view_to', 1);
        $this->db->select('M.*,U1.name from_user,U2.name to_user,U1.image');
        $this->db->join('users U2', 'U2.id = M.to_id', 'LEFT');
        $this->db->join('users U1', 'U1.id = M.from_id', 'LEFT');
        return $this->db->get('user_message M')->result();
    }
    function message_is_view_by_user() {
        $admin = $this->session->userdata('admin');
        $this->db->where('M.to_id', $admin['id']);
        $this->db->set('M.is_view_to', 0);
        $this->db->update('message M');
    }

    function message_is_view_by_admin($id) {
        $this->db->where('M.from_id', $id);
        $this->db->set('M.is_view_to', 0);
        $this->db->update('message M');
    }
    
    function user_message_is_view_by_admin($id) {
        $this->db->where('M.from_id', $id);
        $this->db->set('M.is_view_to', 0);
        $this->db->update('user_message M');
    }

    function update($save, $id) {
        $this->db->where('id', $id);
        $this->db->update('message', $save);
    }

    function delete($id) {//delte
        $this->db->where('id', $id);
        $this->db->delete('message');
    }
    
    function delete_user_message($id) {//delte
        $this->db->where('id', $id);
        $this->db->delete('user_message');
    }

}
