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

class Hospital_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		return $this->db->insert('hospitals',$save);
	}
	
	function get_all()
	{
			 return $this->db->get('hospitals')->result();
	}
	function get_hospital_by_doctor()
	{			$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
			$this->db->order_by('name','ASC');	
			 return $this->db->get('hospitals')->result();
	}
	
	function get_hospital_by_id($id)
	{
			  $this->db->where('id',$id);	
			  return $this->db->get('hospitals')->row();
	}
	
	function get_hospital_by_doctor_id($id)
	{
			  $this->db->where('doctor_id',$id);	
			  return $this->db->get('hospitals')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('medicine',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       return $this->db->delete('hospitals');
	}
	
	function get_hospital_type()
	{
			  return $this->db->get('hospital_type')->result();
	}
	
	function edit_hospital($save,$id)
	{		
			$this->db->where('id',$id);
			return $this->db->update('hospitals',$save);
	
	}
	
	function update_hospital_fixed_schedule($save,$entry_id)
	{
	$this->db->where('id',$entry_id);
	return $this->db->update('fixed_schedule',$save);
	
	}
	
	function add_hospital_fixed_schedule($save)
	{
	return $this->db->insert('fixed_schedule',$save);
	
	}


}


