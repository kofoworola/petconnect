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

class invoice_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function get_detail($id)
	{
			$this->db->where('F.id',$id);
			$this->db->select('F.*,U.name patient,PM.name mode,U.email,U.contact,U.address');
			$this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
			$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
			return $this->db->get('fees F')->row();
	}
	
	function get_doctor_invoice_number()
	{
		$admin = $this->session->userdata('admin');	
		if($admin['user_role']==1){
			   $this->db->where('doctor_id',$admin['id']); 
		return $this->db->get('settings')->row();
		}else{
			$this->db->where('doctor_id',$admin['doctor_id']); 
		return $this->db->get('settings')->row();
		}
	}
	
	function get_admin_invoice_number()
	{
		
			   $this->db->where('doctor_id',0); 
		return $this->db->get('settings')->row();
		
	}
	
	function get_assistant_invoice_detail($id)
	{
		$this->db->where('F.id',$id);
		$this->db->select('F.*,U.name patient,PM.name mode,U.email,U.contact,U.address');
		$this->db->join('users U', 'U.id = F.assistant_id', 'LEFT');
		$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
		return $this->db->get('assistant_payment F')->row();		   
		
	}
	
	
	function get_doctor_invoice_detail($id)
	{
		$this->db->where('F.id',$id);
		$this->db->select('F.*,U.name doctor,U.email,U.contact,U.address');
		$this->db->join('users U', 'U.id = F.doctor_id', 'LEFT');
		return $this->db->get('doctor_payment F')->row();		   
		
	}
	
	
	
	function get_detail_assistant($id)
	{
			$this->db->where('F.id',$id);
			$this->db->select('F.*,U.name assistant,PM.name mode,U.email,U.contact,U.address');
			$this->db->join('users U', 'U.id = F.assistant_id', 'LEFT');
			$this->db->join('payment_modes PM', 'PM.id = F.payment_mode_id', 'LEFT');
			return $this->db->get('assistant_payment F')->row();
	}
	
	
	function get_detail_doctor($id)
	{
			$this->db->where('F.id',$id);
			$this->db->select('F.*,U.name doctor,U.email,U.contact,U.address');
			$this->db->join('users U', 'U.id = F.doctor_id', 'LEFT');
			return $this->db->get('doctor_payment F')->row();
	}
	
	
}
