<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

class medicine_category_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('medicine_category',$save);
	}
	
	function get_all()
	{
			return $this->db->get('medicine_category')->result();
	}
	
	function get_medicine_categoory_by_doctor()
	{
					$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
			return $this->db->get('medicine_category')->result();
	}
	
	function get_medicine_category_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('medicine_category')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('medicine_category',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('medicine_category');
	}
}