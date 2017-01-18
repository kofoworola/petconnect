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

class disease_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('disease',$save);
	}
	
	function get_all()
	{
					
			return $this->db->get('disease')->result();
	}
	
	function get_disease_by_doctor()
	{
			$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   } 		
			return $this->db->get('disease')->result();
	}
	
	function get_disease_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('disease')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('disease',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('disease');
	}
}