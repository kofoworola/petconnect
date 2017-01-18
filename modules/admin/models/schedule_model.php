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

class schedule_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_all_fixed_schedule($id)
	{	$this->db->where('FS.doctor_id',$id);
		$this->db->join('hospitals HP','FS.hospital=HP.id','LEFT');
		return $this->db->get('fixed_schedule FS')->result();
	}
	
	
	function get_schedule_by_id($id)
	{	$this->db->where('FS.id',$id);
		$this->db->select('FS.*, HP.name hospital,HP.id h_id');
		$this->db->join('hospitals HP','FS.hospital=HP.id','LEFT');
		return $this->db->get('fixed_schedule FS')->row();
	}
	
	function get_schedule_by_id_m($id)
	{	$this->db->where('FS.id',$id);
		$this->db->select('FS.*, HP.name hospital,HP.id h_id');
		$this->db->join('medical_college HP','FS.hospital=HP.id','LEFT');
		return $this->db->get('fixed_schedule FS')->row();
	}
	
	
	function get_days()
	{
	return $this->db->get('days')->result();
	
	}
	
	function save_schedule($save)
	{
	
	return $this->db->insert('fixed_schedule',$save);
	
	}
	
	function save_other_schedule($save)
	{
	return $this->db->insert('other_schedule',$save);
	}
	
	
	function delete_fixed_schedule($id)
	{
	$this->db->where('doctor_id',$id);
	$this->db->delete('fixed_schedule');
	
	}
	
	function delete_row($day_id)
	{
	$this->db->where('day',$day_id);
	$this->db->delete('fixed_schedule');
	
	}
	
	
	function delete_week_schedule($id)
	{
	$this->db->where('id',$id);
	$this->db->delete('fixed_schedule');
	
	}
	
	function update_schedule($save)
	{
	
	return $this->db->insert('fixed_schedule',$save);
	}
	
	
	function edit_schedule($save,$id)
	{
		$this->db->where('id',$id);
	return $this->db->update('fixed_schedule',$save);
	}
	
	
	function get_all_specific_schedule($id)
	{	
		$this->db->select('OS.*, HP.name ');
		$this->db->where('OS.doctor_id',$id);
		$this->db->join('hospitals HP','OS.hospital_id=HP.id','LEFT');
		return $this->db->get('other_schedule OS')->result();
		
	}
	
	function specific_schedule_details($id)
	{	$this->db->select('OS.*, HP.name ');
		$this->db->where('OS.id',$id);
		$this->db->join('hospitals HP','OS.hospital_id=HP.id','LEFT');
		return $this->db->get('other_schedule OS')->row();
		
		
	}
	
	function edit_specific_schedule($doctor_id,$arr)
	{
	$this->db->where('id',$arr['id']);
	return $this->db->update('other_schedule',$arr);
	}
	
	function delete_specific_schedule($id)
	{
	$this->db->where('id',$id);
	return $this->db->delete('other_schedule');
	
	}
	
	function monthly_schedule($save)
	{
	return $this->db->insert('monthly_schedule',$save);
	}
	
	function get_monthly_schedule($id)
	{
		
		$this->db->select('OS.*, HP.name ');
		$this->db->where('OS.doctor_id',$id);
		$this->db->join('hospitals HP','OS.hospital=HP.id','LEFT');
		return $this->db->get('monthly_schedule OS')->result();
	}
	
	function delete_monthly_schedule($id)
	{
		
	$this->db->where('doctor_id',$id);
	return $this->db->delete('monthly_schedule');
	}
	
	function get_all_fixed_schedule_for_hospital($hos_id)
	{
	$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
	$this->db->where('hospital',$hos_id);
	$this->db->where('type',1);
	$this->db->order_by('timing_from','ASC');
	return $this->db->get('fixed_schedule')->result();
	
	}
	
	function get_all_fixed_schedule_for_medical($hos_id)
	{
	$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
	$this->db->where('hospital',$hos_id);
	$this->db->where('type',2);
	$this->db->order_by('timing_from','ASC');
	
	return $this->db->get('fixed_schedule')->result();
	
	}
	
	function get_monthly_schedule_for_hospital($doctor_id,$id)
	{
		
		$this->db->where('doctor_id',$doctor_id);
		$this->db->where('hospital',$id);
		return $this->db->get('monthly_schedule')->result();
		//echo '<pre>'; print_r($q);die;
	}
	
	function delete_monthly_schedule_for_hospital($doctor_id,$id)
	{
	
	$this->db->where('hospital',$id);
	$this->db->where('doctor_id',$doctor_id);
	$this->db->delete('monthly_schedule');
	
	}
	
	function delete_fixed_schedule_for_hospital($doctor_id,$id)
	{
	
	$this->db->where('doctor_id',$doctor_id);
	$this->db->where('hospital',$id);
	return $this->db->delete('fixed_schedule');
	
	}
}
