<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->auth->check_session();
		$this->load->model("dashboard_model");
		$this->load->model("hospital_model");
		$this->load->model("patient_model");
		$this->load->model("medical_college_model");
		$this->load->model("manufacturing_company_model");
		$this->load->model("doctor_model");
                $this->load->model("clinic_model");
                $this->load->model("business_model");
                $this->load->model("non_profit_model");
		$this->load->model("patient_model");
		$this->load->model("prescription_model");
		$this->load->model("setting_model");
		$this->load->model("notification_model");
		$this->load->model("contact_model");
	}
	
	
	function index() {
		$admin = $this->session->userdata('admin');
		$data['settings'] = $this->notification_model->get_setting($admin['id']);
			//echo '<pre>'; print_r($data['settings']);die;
		//get scheudle
		$data['todays_week'] = $this->dashboard_model->get_todays_weekly_schedule();
		$data['tomarrow_week'] = $this->dashboard_model->get_tomarrow_weekly_schedule();
		$data['tomarrow_after'] = $this->dashboard_model->get_tomarrow_after_weekly_schedule();
			
		
		$data['todays_week_medi'] = $this->dashboard_model->get_todays_weekly_schedule_medi();
		$data['tomarrow_week_medi'] = $this->dashboard_model->get_tomarrow_weekly_schedule_medi();
		$data['tomarrow_after_medi'] = $this->dashboard_model->get_tomarrow_after_weekly_schedule_medi();
		//echo '<pre>'; print_r($data['tomarrow_after_medi']);die;
		
		
		$data['todays_other'] = $this->dashboard_model->get_todays_other_schedule();
		$data['tomarrow_other'] = $this->dashboard_model->get_tomarrow_other_schedule();
		$data['tomarrow_after_other'] = $this->dashboard_model->get_tomarrow_after_other_schedule();
		
		$data['todays_monthly'] = $this->dashboard_model->get_todays_monthly_schedule();
		$data['tomarrow_monthly'] = $this->dashboard_model->get_tomrrow_monthly_schedule();
		$data['tomarrow_after_monthly'] = $this->dashboard_model->get_tomrrow_after_monthly_schedule();	
			
		
		$data['company'] = $this->manufacturing_company_model->get_manufacturing_company_by_doctor();
		$data['hospital'] = $this->hospital_model->get_hospital_by_doctor();
		$data['mdeical_college'] = $this->medical_college_model->get_medical_college_by_doctor();
		$data['doctors'] = $this->doctor_model->get_all();
                $data['businesses'] = $this->business_model->get_all_businesses();
                $data['clinics'] = $this->clinic_model->get_all_clinics();
                $data['non_profits'] = $this->non_profit_model->get_all_non_profits();
		$data['patients'] = $this->patient_model->get_all();
		$data['earning']   = $this->dashboard_model->get_total_earning();
		$data['doctor_precription'] = $this->prescription_model->get_prescription_by_doctor();
		$data['doctor_contacts'] = $this->contact_model->get_contact_by_doctor();
		$data['patient_precription'] = $this->prescription_model->get_prescription_by_patient();
		$data['doctor_patients'] = $this->patient_model->get_patients_by_doctor();
		
		//$data['months'] = $this->dashboard_model->get_patients_by_month();	
		$data['appointments']   = $this->dashboard_model->get_todays_appointments();
				
		$data['date6']	=	$this->dashboard_model->get_patient_by_date(date('Y-m-d', strtotime("-6 days")));
		$data['date5']	=	 $this->dashboard_model->get_patient_by_date(date('Y-m-d', strtotime("-5 days")));
		$data['date4']	=	 $this->dashboard_model->get_patient_by_date(date('Y-m-d', strtotime("-4 days")));
		$data['date3']	=	 $this->dashboard_model->get_patient_by_date(date('Y-m-d', strtotime("-3 days")));
		$data['date2']	=	 $this->dashboard_model->get_patient_by_date(date('Y-m-d', strtotime("-2 days")));
		$data['date1']	=	 $this->dashboard_model->get_patient_by_date(date('Y-m-d', strtotime("-1 days")));
		$data['date']	=	 $this->dashboard_model->get_patient_by_date(date('Y-m-d'));
		//echo '<pre>'; print_r($data['date6']->count);die;
		//if(empty($data['date6']->count)
			$lastdate	=	 date('Y-m-d', strtotime("-6 days"));
			$dates = array();
			for($i=1;$i<=7;$i++){
				$dates[date('Y-m-d',strtotime($lastdate.'+ '.$i.' days'))] = 0; 
			}
			
			$result = $this->patient_model->get_patients_by_doctor();
			
			foreach($dates as $new){
			
				
			}
						//echo '<pre>'; print_r($result);die;
			//$data['months']=$c;
			
					
		$data['appointment_all'] = $this->dashboard_model->get_appointment_all();
		$data['scheudle_all'] = $this->dashboard_model->get_other_schedule();
			
		$data['to_do'] 		= $this->dashboard_model->get_todays_to_do();
			//echo '<pre>'; print_r($data['to_do']);die;
		$data['patient_appointments'] 	= $this->setting_model->get_appointment_alert_patient();
		$data['page_title'] = lang('dashboard');
		$data['body'] = 'dashboard/dashboard';
		$this->load->view('template/main', $data);	

	}	
	
		
	
}