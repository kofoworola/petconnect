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

class reports_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}
	
	function save($save)
	{
		$this->db->insert('acts',$save);
	}
	
	function get_earning_by_dates($date)
	{
		$admin = $this->session->userdata('admin');
	
				   $this->db->like('F.date',$date);
				   $this->db->where('U.doctor_id',$admin['id']);
				   $this->db->select('date, SUM(amount) amount');
				  $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $x= $this->db->get('fees F')->row();
		
		if(empty($x->date)){
			return $date;
				
		}else{
		return $x;
		}
	}
	

	
	function get_earning_by_month()
	{
	$y= date("Y");
	$m= date("m");
	$d=@cal_days_in_month(CAL_GREGORIAN,$m,$y);
	$admin = $this->session->userdata('admin');
	
				   $this->db->where('date >=',date("Y-m-d", strtotime("-".$d." days")));
				   $this->db->where('U.doctor_id',$admin['id']);
				   $this->db->group_by('date', 'ASC');
				   $this->db->select('date');
				   $this->db->select_sum('amount');
				   $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
			return $this->db->get('fees F')->result();
	}
	
	function get_earning_by_week()
	{
		$admin = $this->session->userdata('admin');
				   $this->db->where('date >=',date("Y-m-d", strtotime("- 7 days")));
				   $this->db->where('U.doctor_id',$admin['id']);
				   $this->db->group_by('date', 'ASC');
				   $this->db->select('date');
				   $this->db->select_sum('amount');
				  $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
			return $this->db->get('fees F')->result();
	}
	
	function get_earning_by_year()
	{
		$admin = $this->session->userdata('admin');
				   $this->db->group_by('YEAR(date)');
				   $this->db->where('U.doctor_id',$admin['id']);
				   $this->db->select('date');
				   $this->db->select_sum('amount');
				  $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
			return $this->db->get('fees F')->result();
	}
	
	function get_earning_by_patient()
	{
		$admin = $this->session->userdata('admin');
	
				   $this->db->where('U.doctor_id',$admin['id']);
				 
			$this->db->select('date,U.name, SUM(amount) as amount');
			 $this->db->group_by('U.name'); 
			 $this->db->join('users U', 'U.id = F.patient_id', 'LEFT');
		return $this->db->get('fees F')->result();
	}
	
	

}
