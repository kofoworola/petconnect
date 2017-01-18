<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class doctor_payment extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_access('Admin', true);
		$this->auth->is_logged_in();	
		$this->load->helper('dompdf_helper');
		$this->load->model("custom_field_model");
		$this->load->model("patient_model");
		$this->load->model("instruction_model");
		$this->load->model("prescription_model");
		$this->load->model("notification_model");
		$this->load->model("assistant_model");
		$this->load->model("medicine_model");
		$this->load->model("disease_model");
		$this->load->model("medical_test_model");
		$this->load->model("payment_mode_model");
		$this->load->model("setting_model");
		$this->load->model("doctor_model");
		$this->load->model("invoice_model");
	}
	
	
	function index($id=false){
		$data['p_id']= $id;
		
			$data['payments'] = $this->doctor_model->get_payment_by_doctor_all();
		
		$data['doctors']				= $this->doctor_model->get_all();
		$data['payment_modes']			= $this->payment_mode_model->get_payment_mode_by_doctor();
		
		$data['setting']   = $this->setting_model->get_setting();	
		
		$data['invoice']	=	$invoice 	= $this->doctor_model->get_invoice_number();
		//echo '<pre>';  print_r($data['setting']);die;
		if($invoice->invoice==0){
				$dr_invoice = $this->invoice_model->get_admin_invoice_number();
				if(empty($dr_invoice->invoice)){
					$data['i_no'] =1;
				}else{
					$data['i_no'] =$dr_invoice->invoice;
				}	
			}else{
				$data['i_no'] = $invoice->invoice+1;
				}
	
	
		$data['page_title'] = lang('payment');
		$data['body'] = 'doctors/payment_list';
		$this->load->view('template/main', $data);	

	}	
	
	
	
	
	function payment_history($id=false){
		$data['p_id']= $id;
		
			$data['doc'] = $this->doctor_model->get_doctor_by_id($id);
			$data['payments'] = $this->doctor_model->get_payment_by_doctor($id);
		
		$data['doctors']				= $this->doctor_model->get_all();
		$data['payment_modes']			= $this->payment_mode_model->get_payment_mode_by_doctor();
		
		$data['setting']   = $this->setting_model->get_setting();	
		
		$data['invoice']	=	$invoice 	= $this->doctor_model->get_invoice_number();
		//echo '<pre>';  print_r($data['setting']);die;
		if($invoice->invoice==0){
			$data['i_no'] =1;
			}else{
				$data['i_no'] = $invoice->invoice+1;
				}
	
		$data['page_title'] = lang('payment');
		$data['body'] = 'doctors/payment_history';
		$this->load->view('template/main', $data);	

	}	
	
	function edit_payment($id){
		//$this->auth->check_access('1', true);
		$data['payment']			= $this->doctor_model->get_payment_by_id($id);
		$data['pateints']				= $this->patient_model->get_patients_by_doctor();
			//echo '<pre>'; print_r($data['pateints']);die;
		//$data['fees_all']				= $this->prescription_model->get_fees_all($id);
		
		//echo '<pre>'; print_r($_POST);die;
		
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('amount', 'lang:amount', 'required');
			$this->form_validation->set_rules('payment_mode_id', 'lang:payment_mode', 'required');
			$this->form_validation->set_rules('date', 'lang:date', 'required');
			$this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');
			if ($this->form_validation->run()==true)
            {
				$save['amount'] = $this->input->post('amount');
				$save['payment_mode_id'] = $this->input->post('payment_mode_id');
				
				$save['doctor_id'] = $this->input->post('doctor_id');
				$save['date'] = $this->input->post('date');
				//echo '<pre>'; print_r($save);die;
				$this->doctor_model->update_fees($save,$data['payment']->id);
              	$this->session->set_flashdata('message', lang('fees_updated'));
			echo 1;
			}else{
			
			echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>'.validation_errors().'
											</div>
				';
			}
		}
	}	
	
	
	
	
	function add_payment($id=false){
		//$data['pateints']				= $this->patient_model->get_patients_by_doctor();
		//$data['payment_modes']			= $this->prescription_model->get_all_payment_modes();
		//$data['fees_all']				= $this->prescription_model->get_fees_all($id);
		$data['invoice']	=	$invoice 	= $this->doctor_model->get_invoice_number();
		//echo '<pre>';  print_r($data['setting']);die;
		if($invoice->invoice==0){
				$dr_invoice = $this->invoice_model->get_admin_invoice_number();
			if(empty($dr_invoice->invoice)){
					$data['i_no'] =1;
				}else{
					$data['i_no'] =$dr_invoice->invoice;
				}	
			}else{
				$data['i_no'] = $invoice->invoice+1;
				}
		//echo '<pre>'; print_r($_POST);
	
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->load->library('form_validation');
			$this->form_validation->set_rules('amount', 'lang:amount', 'required');
			$this->form_validation->set_rules('payment_mode_id', 'lang:payment_mode', 'required');
			$this->form_validation->set_rules('date', 'lang:date', 'required');
			$this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');
			if ($this->form_validation->run()==true)
            {
				$save['amount'] = $this->input->post('amount');
				$save['payment_mode_id'] = $this->input->post('payment_mode_id');
				//$save['prescription_id'] = $id;
				//echo $data['p_id'];die;
				
				$save['doctor_id'] = $this->input->post('doctor_id');		
						
				$save['date'] = $this->input->post('date');
				$save['invoice'] = $data['i_no']; // $this->input->post('invoice_no');
				//echo '<pre>';print_r($save);die;
				$this->doctor_model->save_payment($save);
              	$this->session->set_flashdata('message', lang('fees_updated'));
				echo 1;
			}else{
			
			echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>'.validation_errors().'
											</div>
				';
			}
		}
		
	}
	
	
	
	
	
	
	function delete($id=false){
		
		if($id){
			$this->assistant_model->delete($id);
			$this->session->set_flashdata('message',"Payment Deleted");
			redirect('admin/assistant_payment');
		}
	}	
	
	function delete_payment($id=false){
		
		if($id){
			$this->doctor_model->delete_payment($id);
			$this->session->set_flashdata('message',"Payment Deleted");
			redirect('admin/doctor_payment');
		}
	}	
		
		
	function pdf($id=false){
		$this->load->helper('dompdf_helper');
		$this->load->helper('download');
		$data['details'] = $this->invoice_model->get_doctor_invoice_detail($id);
			//echo '<pre>'; print_r($data['details']);die;
		$data['setting']   = $this->setting_model->get_setting();	
		$data['page_title'] = lang('invoice');
		$pdfFilePath =$data['details']->invoice.".pdf";
		$this->load->library('m_pdf');
		$pdf = $this->m_pdf->load();
		$pdf->autoLangToFont = true;
		
		
		//$data['body'] = 'invoice/pdf';
		$html = $this->load->view('invoice/doctor_pdf', $data,true);		
		$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
		pdf_create($html, 'Prescription_'.$data['prescription']->patient);
		$pdf->WriteHTML($html);
		$pdf->Output($pdfFilePath, "I");
		

	}	
	
	
	public function mail($id=false)
	{ 
		$details = $this->invoice_model->get_doctor_invoice_detail($id);
			
		$setting = $data['setting']   = $this->setting_model->get_setting();	
	    $data['body'] = 'invoice/pdf';
		
			if($data['setting']->image!=""){
				$img ='<td align="left"><img src="'.site_url('assets/uploads/images/'.$data['setting']->image).'"  height="70" width="80" /></td>';
			}else{
				$img ='<td align="left"><img src="'.site_url('assets/img/doctor_logo.png/').'"  height="70" width="80" /></td>';
			}
			if($details->payment_mode_id==1){
			$mode="Cash";
			}else{
			$mode ="Cheque";
			}		
		$message = '
						<html>
							<head>
								<title>Invoice</title>
							</head>
							<body>
						<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											'.$img.'
											<td align="right">
												<b>'.lang('invoice_number').' #'.$details->invoice.'</b><br />
												<b>Payment Date:</b>'.date("d/m/Y", strtotime($details->date)).'<br />
												<b>'.lang('payment_mode') .':</b>'.$mode.'<br/>
												<b>Issue Date:</b> '.date('d/m/Y').'<br />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left">Payment To<br />
												 <strong>'.@$setting->name .'</strong><br>
										   '.@$setting->address .'<br>
											'.lang('phone').': '.@$setting->contact.'<br/>
											'.lang('email').': '.@$setting->email .'		
											
											</td>
											<td align="right" colspan="2">Bill To<br />
											
											<strong>'.$details->doctor.'</strong><br>
											'.$details->address.' <br>
											'.lang('phone').': '.$details->contact.'<br/>
											'.lang('email').': '.$details->email.'
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;">Invoice Entries</th>
							</tr>
							<tr>  
								<td>
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b>Entry</b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b>Price</b></td>
										</tr>
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" >1</td>
											 <td width="75%" style="border-right:1px solid #CCCCCC">'. lang('payment').'</td>
											 <td width="15%" >'.$details->amount.'</td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>


							</body>
						</html>
				';
		
		$this->load->library('email');
		$this->load->helper('string');    
		/*$config = array(
				'protocol' => "smtp",
				'smtp_host' => "ssl://smtp.gmail.com",
				'smtp_port' => "465",
				'smtp_user' => "",
				'smtp_pass' => "",
				'charset' => "utf-8",
				'mailtype' => "html",
				'newline' => "\r\n"
			);*/
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		

        $this->load->library('email', $config);
			
		$this->email->initialize($config);
		
													
			
			//echo '<pre>';print_r($message);exit;
			$this->email->from($data['setting']->email,'Invoice');
			
			$email = $details->email;
			$this->email->to($email);
			$this->email->subject('Invoice');
			$this->email->message(html_entity_decode($message,ENT_QUOTES, 'UTF-8'));
			$sent = $this->email->send();
			//$this->session->set_flashdata('message', "Invoice is sent to doctor�s email");
			//redirect('admin/doctor_payment');
			$this->session->set_flashdata('message', 'Mail sent successfully');
			redirect('admin/doctor_payment');
	}
		
	
}
