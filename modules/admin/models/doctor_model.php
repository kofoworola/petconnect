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


class doctor_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_blood_group()
	{
	  
		return $this->db->get('blood_group_type')->result();
	}
	
	function update_fees($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('doctor_payment',$save);
	}
	function delete_payment($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('doctor_payment');
	}

	
	
	function get_payment_by_doctor($id)
	{
		$this->db->where('DP.doctor_id',$id);
		$this->db->order_by('DP.invoice','DESC');
		$this->db->select('DP.*,U.name doctor');
		$this->db->join('users U', 'U.id = DP.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment DP')->result();
	}
	
	
	function get_payment_by_doctor_all()
	{
		
		$this->db->order_by('DP.invoice','DESC');
		$this->db->select('DP.*,U.name doctor');
		$this->db->join('users U', 'U.id = DP.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment DP')->result();
	}
	
	
	function get_payment_by_id($id)
	{
		$this->db->where('F.id',$id);	

		$this->db->select('F.*,U.name doctor');
		$this->db->join('users U', 'U.id = F.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment F')->row();
	}
	
	
	
	function get_invoice_number()
	{
		 
		$this->db->select_max('invoice');
		return $this->db->get('doctor_payment')->row();
	}
	
	
	function save_payment($save){
		$this->db->insert('doctor_payment',$save);
	}
	
	
	
	function get_detail($id)
	{
		
		$this->db->where('U.doctor_id',$id);	
		$this->db->order_by('F.date','DESC');
		$this->db->select('F.*,PM.name mode,U.name patient');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('fees F')->result();
	}
	
	
	
	function save($save)
	{
		$this->db->insert('users',$save);
		return $this->db->insert_id(); 
	}
	
	function get_all()
	{
				$this->db->where('user_role',1);
		return $this->db->get('users')->result();
	}
	
	function get_doctors_by_medication($id)
	{
		 $this->db->where('U.doctor_id',$id);
		$this->db->select('P.*,U.name patient');
		$this->db->join('users U', 'U.id = P.patient_id', 'LEFT');
		return $this->db->get('prescription P')->result();		   
		
	}
	
	function get_all_doctors()
	{
		$this->db->where('user_role',1);
		return $this->db->get('users')->result();
	}
	
	function get_doctor_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('users')->row();
	}
	
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('users',$save);
	}
	
	
	function delete($id)//delte client
	{
			   $this->db->where('id',$id);
		       $this->db->delete('users');
	}
}
