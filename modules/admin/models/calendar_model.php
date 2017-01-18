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


class calendar_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function save($save)
	{
		
		$this->db->insert('jqcalendar',$save);
		return $this->db->insert_id(); 
	}
	
	function update($save){
		$this->db->where('id',$save['id']);	
	$this->db->update('jqcalendar',$save);
	}
	
	function delete($id){
		$this->db->where('id',$id);	
	$this->db->delete('jqcalendar');
	}
	
	function get_event_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('event_calendar')->row();
	}
	function get_tables()
	{
		//$this->db->select('a.*,b.course_name');
		$this->db->from('to_do_list,appointments,fixed_schedule');
		//$this->db->where('a.course_id = b.course_id',NULL,FALSE);
		$query = $this->db->get();
		return $query->result();
	}
	function check_tables($t1,$t2)
	{
		$t1 = date("Y-m-d H:i:s", strtotime($t1));
		$t2 = date("Y-m-d H:i:s", strtotime($t2));
		$admin = $this->session->userdata('admin');
		
		/*$this->db->select('T.date as to_do_date,A.date,EC.starttime,EC.endtime,');
		$this->db->from('to_do_list as T,appointments as A,fixed_schedule as FS,event_calendar as EC');
		//$this->db->where('a.course_id = b.course_id',NULL,FALSE);
		$query = $this->db->get();
		return $query->result();
		*/	
		$next = true;
			if($next = true){
					$this->db->where('doctor_id',$admin['doctor_id']);
					$this->db->where('date >=',$t1);
					$this->db->where('date <',$t2);	
					$this->db->order_by('date','DESC');
				$todos = $this->db->get('to_do_list')->result();
			}
			
			if(!empty($todos)){
			 $next = false;
			 return "To Do is available in this time slot";
			}else{
				$next = true;
			}
			
			
			if($next = true){
					$this->db->where('doctor_id',$admin['doctor_id']);
					$this->db->where('date >=',$t1);
					$this->db->where('date <',$t2);	
					$this->db->order_by('date','DESC');
				$appointments = $this->db->get('appointments')->result();
			}
			
			
			if(!empty($appointments)){
			 $next = false;
			 return "Appointment is available in this time slot";
			}else{
				$next = true;
			}
			
			if($next = true){
			
			
					$this->db->where('doctor_id',$admin['doctor_id']);
					$this->db->where('day =',date('N', strtotime($t1)));
					//$this->db->where('day <',date('N', strtotime($t2)));	
					$this->db->where('timing_from =',date('H:i:s', strtotime($t1)));
					//$this->db->where('timing_to <',date('H:i:s', strtotime($t2)));	
				$schedules = $this->db->get('fixed_schedule')->result();
			}
			
			
			if(!empty($schedules)){
			 $next = false;
			 return "Hospital / Medical College Schedule is available in this time slot";
			}else{
				$next = true;
			}
			
			
			if($next = true){
					$this->db->where('doctor_id',$admin['doctor_id']);
					$this->db->where('StartTime >=',$t1);
					$this->db->where('EndTime <',$t2);	
				$events = $this->db->get('jqcalendar')->result();
			}
			
			if(!empty($events)){
			 $next = false;
			 return "Other Event Schedule is available in this time slot";
			}else{
				$next = true;
			}
			
			if($next = true){
				return;
			}
			
	}
	
	
	
	function get_todos(){
		$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
					$this->db->order_by('date','DESC');
			return $this->db->get('to_do_list')->result();
	
	}
	
	function get_appointments(){
		$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
					$this->db->order_by('date','DESC');
			return $this->db->get('appointments')->result();
	
	}
	
	
	function get_other_schedule(){
		$admin = $this->session->userdata('admin');
					if($admin['user_role']==1){
					$this->db->where('doctor_id',$admin['id']);	
				   }else{
					$this->db->where('doctor_id',$admin['doctor_id']);	
				   }
			return $this->db->get('event_calendar')->result();
		
	
	}
	
	
}