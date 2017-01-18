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

class medicine_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function save($save)
	{
		$this->db->insert('medicine',$save);
	}
	
	function get_all()
	{
					$this->db->select('M.*,MC.name category,C.name company');
				   $this->db->join('manufacturing_company C', 'C.id = M.company_id', 'LEFT');
				   $this->db->join('medicine_category MC', 'MC.id = M.category_id', 'LEFT');
			return $this->db->get('medicine M')->result();
	}
	
	function get_medicine_by_doctor()
	{
					$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('M.doctor_id',$admin['id']);	
				   }else{
					$this->db->where('M.doctor_id',$admin['doctor_id']);	
				   }
					$this->db->select('M.*,MC.name category,C.name company');
				   $this->db->join('manufacturing_company C', 'C.id = M.company_id', 'LEFT');
				   $this->db->join('medicine_category MC', 'MC.id = M.category_id', 'LEFT');
			return $this->db->get('medicine M')->result();
	}
	
	
	
	function get_medicine_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('medicine')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('medicine',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('medicine');
	}
}