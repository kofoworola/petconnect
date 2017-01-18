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


class dashboard_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_patients_by_month()
	{
	$y= date("Y");
	$m= date("m");
	$d=@cal_days_in_month(CAL_GREGORIAN,$m,$y);
	$admin = $this->session->userdata('admin');
	
				   $this->db->where('U.add_date >=',date("Y-m-d", strtotime("-".$d." days")));
				   $this->db->where('U.doctor_id',$admin['id']);
				   $this->db->where('U.user_role',2);
				   $this->db->group_by('U.add_date', 'ASC');
				   $this->db->select('add_date, count(*) count');
				  
			return $this->db->get('users U')->result();
	}
	
	
	function get_patient_by_date($date)
	{
	$admin = $this->session->userdata('admin');
	
				   $this->db->like('U.add_date',$date);
				   $this->db->where('U.doctor_id',$admin['id']);
				   $this->db->where('U.user_role',2);
				   $this->db->select('add_date, count(*) count');
				  
		return	$x =$this->db->get('users U')->row();
		
		if(empty($x->add_date)){
			return $add_date[]=date("Y-m-d", strtotime($date));
				
		}else{
		return $x;
		}
		
	}
	
	
	function get_todays_weekly_schedule()
	{
					$cur_day = date('l');
					switch($cur_day){
						case "Monday":
							$day = 1;
							break;
						case "Tuesday":
							$day = 2;
							break;
						case "Wednesday":
							$day = 3;
							break;
						case "Thursday":
							$day = 4;
							break;
						case "Friday":
							$day = 5;
							break;
						case "Saturday":
							$day = 6;
							break;			
						case "Sunday":
							$day = 7;
							break;
					}
				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.day',$day);
				$this->db->where('FS.type',1);
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('fixed_schedule FS')->result();
	}
	
	function get_tomarrow_weekly_schedule()
	{
					$cur_day = date('l');
					switch($cur_day){
						case "Monday":
							$day = 1;
							break;
						case "Tuesday":
							$day = 2;
							break;
						case "Wednesday":
							$day = 3;
							break;
						case "Thursday":
							$day = 4;
							break;
						case "Friday":
							$day = 5;
							break;
						case "Saturday":
							$day = 6;
							break;			
						case "Sunday":
							$day = 7;
							break;
					}
				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.day',$day+1);
				$this->db->where('FS.type',1);
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('fixed_schedule FS')->result();
	}
	
	function get_tomarrow_after_weekly_schedule()
	{
					$cur_day = date('l',strtotime('+ 2 days'));
					switch($cur_day){
						case "Monday":
							$day = 1;
							break;
						case "Tuesday":
							$day = 2;
							break;
						case "Wednesday":
							$day = 3;
							break;
						case "Thursday":
							$day = 4;
							break;
						case "Friday":
							$day = 5;
							break;
						case "Saturday":
							$day = 6;
							break;			
						case "Sunday":
							$day = 7;
							break;
					}
				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.day',$day);
				$this->db->where('FS.type',1);
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('fixed_schedule FS')->result();
	}
	
	
	
	
	
	
	function get_todays_weekly_schedule_medi()
	{
					$cur_day = date('l');
					switch($cur_day){
						case "Monday":
							$day = 1;
							break;
						case "Tuesday":
							$day = 2;
							break;
						case "Wednesday":
							$day = 3;
							break;
						case "Thursday":
							$day = 4;
							break;
						case "Friday":
							$day = 5;
							break;
						case "Saturday":
							$day = 6;
							break;			
						case "Sunday":
							$day = 7;
							break;
					}
				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.day',$day);
				$this->db->select('FS.*,H.name hospital');
				$this->db->where('FS.type',2);
				$this->db->join('medical_college H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('fixed_schedule FS')->result();
	}
	
	function get_tomarrow_weekly_schedule_medi()
	{
					$cur_day = date('l');
					switch($cur_day){
						case "Monday":
							$day = 1;
							break;
						case "Tuesday":
							$day = 2;
							break;
						case "Wednesday":
							$day = 3;
							break;
						case "Thursday":
							$day = 4;
							break;
						case "Friday":
							$day = 5;
							break;
						case "Saturday":
							$day = 6;
							break;			
						case "Sunday":
							$day = 7;
							break;
					}
				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.day',$day+1);
				$this->db->select('FS.*,H.name hospital');
				$this->db->where('FS.type',2);
				$this->db->join('medical_college H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('fixed_schedule FS')->result();
	}
	
	function get_tomarrow_after_weekly_schedule_medi()
	{
					$cur_day = date('l',strtotime('+ 2 days'));
					switch($cur_day){
						case "Monday":
							$day = 1;
							break;
						case "Tuesday":
							$day = 2;
							break;
						case "Wednesday":
							$day = 3;
							break;
						case "Thursday":
							$day = 4;
							break;
						case "Friday":
							$day = 5;
							break;
						case "Saturday":
							$day = 6;
							break;			
						case "Sunday":
							$day = 7;
							break;
					}
				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.day',$day);
				$this->db->select('FS.*,H.name hospital');
				$this->db->where('FS.type',2);
				$this->db->join('medical_college H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('fixed_schedule FS')->result();
	}
	
	function get_todays_other_schedule()
	{				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.dates',date("Y-m-d"));
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital_id', 'LEFT');
		return  $this->db->get('other_schedule FS')->result();
	}
	
	function get_tomarrow_other_schedule()
	{				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.dates',date("Y-m-d", strtotime("+1 days")));
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital_id', 'LEFT');
		return  $this->db->get('other_schedule FS')->result();
	}
	
	function get_tomarrow_after_other_schedule()
	{				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->where('FS.dates',date("Y-m-d", strtotime("+2 days")));
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital_id', 'LEFT');
		return  $this->db->get('other_schedule FS')->result();
	}
	
	
	function get_todays_monthly_schedule()
	{				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->like('FS.date_id',date("d"));
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('monthly_schedule FS')->result();
	}
	
	function get_tomrrow_monthly_schedule()
	{				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->like('FS.date_id',date("d")+1);
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('monthly_schedule FS')->result();
	}
	
	function get_tomrrow_after_monthly_schedule()
	{				
				$admin = $this->session->userdata('admin');
				$this->db->where('FS.doctor_id',$admin['id']);
				$this->db->like('FS.date_id',date("d")+2);
				$this->db->select('FS.*,H.name hospital');
				$this->db->join('hospitals H', 'H.id = FS.hospital', 'LEFT');
		return  $this->db->get('monthly_schedule FS')->result();
	}
	
	function get_setting()
	{
		 
		return $this->db->get('settings')->row();
	}
	
	function get_todays_appointments()
	{		
		$admin = $this->session->userdata('admin');
		$this->db->where('date <',date("Y-m-d", strtotime("+ 1 days")));
		$this->db->where('date >=',date("Y-m-d"));
		$this->db->where('A.doctor_id',$admin['id']);
		$this->db->select('A.*,U.name,C.name contact');
		$this->db->join('users U', 'U.id = A.patient_id', 'LEFT');
		$this->db->join('contacts  C', 'C.id = A.contact_id', 'LEFT');
		return  $this->db->get('appointments A')->result();			
	}	
	
	function get_total_earning()
	{		
		$this->db->select_sum('amount');
		return  $this->db->get('fees')->result();		
	}	
	
	function  get_todays_to_do()
	{
				$admin = $this->session->userdata('admin');
				$this->db->where('doctor_id',$admin['id']);
				$this->db->like('date',date("Y-m-d"));
		return  $this->db->get('to_do_list')->result();
	}	
	
	
	
	
	
	function get_appointment_all()
	{
				$admin = $this->session->userdata('admin');
				$this->db->where('A.doctor_id',$admin['id']);
				$this->db->where('A.status',1);
				$this->db->select('A.*,U.name patient');
				$this->db->join('users U', 'U.id = A.patient_id', 'LEFT');
		return  $this->db->get('appointments A')->result();
	}
	
	function get_other_schedule()
	{
				$admin = $this->session->userdata('admin');
				$this->db->where('OS.doctor_id',$admin['id']);
				return  $this->db->get('other_schedule OS')->result();
	}
	
}