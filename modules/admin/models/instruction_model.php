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

class instruction_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('instruction',$save);
	}
	
	function get_all()
	{		
			$this->db->order_by('name','ASC');	
			return $this->db->get('instruction')->result();
	}
	
	function get_instruction_by_doctor()
	{		
			$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
			$this->db->order_by('name','ASC');	
			return $this->db->get('instruction')->result();
	}
	
	function get_instruction_by_doctor_medicine()
	{		
			$admin = $this->session->userdata('admin');
			$this->db->where('doctor_id',$admin['id']); 
			$this->db->where('type',1); 
			$this->db->order_by('name','ASC');	
			return $this->db->get('instruction')->result();
	}
	
	function get_instruction_by_doctor_test()
	{		
			$admin = $this->session->userdata('admin');
			$this->db->where('doctor_id',$admin['id']); 
			$this->db->where('type',2); 
			$this->db->order_by('name','ASC');	
			return $this->db->get('instruction')->result();
	}
	
	function get_instruction_by_id($id)
	{
	
			   $this->db->where('id',$id);
		return $this->db->get('instruction')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('instruction',$save);
	}
	
	
	function delete($id)//delte medical_test
	{
			   $this->db->where('id',$id);
		       $this->db->delete('instruction');
	}
}
