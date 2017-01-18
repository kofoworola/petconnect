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

class medical_test_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('medical_test',$save);
	}
	
	function get_all()
	{		
			$this->db->order_by('name','ASC');	
			return $this->db->get('medical_test')->result();
	}
	
	function get_medical_test_by_doctor()
	{		
			$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   } 	
			$this->db->order_by('name','ASC');	
			return $this->db->get('medical_test')->result();
	}
	function get_medical_test_by_patient()
	{		
			$admin = $this->session->userdata('admin');
			$this->db->where('doctor_id',$admin['doctor_id']); 
			$this->db->order_by('name','ASC');	
			return $this->db->get('medical_test')->result();
	}
	
	function get_medical_test_by_id($id)
	{
	
			   $this->db->where('id',$id);
		return $this->db->get('medical_test')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('medical_test',$save);
	}
	
	
	function delete($id)//delte medical_test
	{
			   $this->db->where('id',$id);
		       $this->db->delete('medical_test');
	}
}