<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class invoice extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->model("invoice_model");
        $this->load->model('setting_model');
    }

    function index($id = false) {
        $data['details'] = $this->invoice_model->get_detail($id);

        $data['setting'] = $this->setting_model->get_setting();
        $data['page_title'] = lang('invoice');
        $data['body'] = 'invoice/invoice';
        $this->load->view('template/main', $data);
    }

    function pdf($id = false) {

//        $this->load->helper('dompdf_helper');
//        $this->load->helper('download');
//        $data['details'] = $this->invoice_model->get_detail($id);
//
//        $data['setting'] = $this->setting_model->get_setting();
//        $data['page_title'] = lang('invoice');
//        $pdfFilePath = $data['details']->invoice . ".pdf";
//        $this->load->library('m_pdf');
//        $pdf = $this->m_pdf->load();
//        $pdf->autoLangToFont = true;
//
//
//        $data['body'] = 'invoice/pdf';
//        $html = $this->load->view('invoice/pdf', $data, true);
//        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
//        $pdf->WriteHTML($html);
//        $pdf->Output($pdfFilePath, "D");

        $data['details'] = $this->invoice_model->get_detail($id);
        $data['setting'] = $this->setting_model->get_setting();
        $data['page_title'] = lang('invoice');
        $this->load->library('tcpdf_lib');
        $pdf = new tcpdf_lib('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->AddPage();
        $data['body'] = 'invoice/pdf';
        $html = $this->load->view('invoice/pdf', $data, true);
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output();
    }

    public function mail($id = false) {
        $details = $this->invoice_model->get_detail($id);

        $data['setting'] = $this->setting_model->get_setting();
        $data['body'] = 'invoice/pdf';

        if ($data['setting']->image != "") {
            $img = '<td align="left"><img src="' . site_url('assets/uploads/images/' . $data['setting']->image) . '"  height="70" width="80" /></td>';
        } else {
            $img = '<td align="left"><img src="' . site_url('assets/img/doctor_logo.png/') . '"  height="70" width="80" /></td>';
        }

        $message = '
						<html>
							<head>
								<title>' . lang('invoice') . '</title>
							</head>
							<body>
						<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											' . $img . '
											<td align="right">
												<b>' . lang('invoice_number') . ' #' . $details->invoice . '</b><br />
												<b>' . lang('payment_date') . ':</b>' . date("d/m/Y", strtotime($details->date)) . '<br />
												<b>' . lang('payment_mode') . ':</b>' . $details->mode . '<br/>
												<b>' . lang('issue_date') . ':</b> ' . date('d/m/Y') . '<br />
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left">' . lang('payment_to') . '<br />
												 <strong>' . @$setting->name . '</strong><br>
										   ' . @$setting->address . '<br>
											' . lang('phone') . ': ' . @$setting->contact . '<br/>
											' . lang('email') . ': ' . @$setting->email . '		
											
											</td>
											<td align="right" colspan="2">' . lang('bill_to') . '<br />
											
											<strong>' . $details->patient . '</strong><br>
											' . $details->address . ' <br>
											' . lang('phone') . ': ' . $details->contact . '<br/>
											' . lang('email') . ': ' . $details->email . '
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;">' . lang('invoice_entries') . '</th>
							</tr>
							<tr>  
								<td>
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b>' . lang('entry') . '</b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b>' . lang('price') . '</b></td>
										</tr>
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" >1</td>
											 <td width="75%" style="border-right:1px solid #CCCCCC">' . lang('prescription_fee') . '</td>
											 <td width="15%" >' . $details->amount . '</td>
											
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
        /* $config = array(
          'protocol' => "smtp",
          'smtp_host' => "ssl://smtp.gmail.com",
          'smtp_port' => "465",
          'smtp_user' => "",
          'smtp_pass' => "",
          'charset' => "utf-8",
          'mailtype' => "html",
          'newline' => "\r\n"
          ); */
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';


        $this->load->library('email', $config);

        $this->email->initialize($config);



        //echo '<pre>';print_r($message);exit;
        $this->email->from($data['setting']->email, 'Invoice');

        $email = $details->email;
        $this->email->to($email);
        $this->email->subject('Invoice');
        $this->email->message(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $sent = $this->email->send();
        $this->session->set_flashdata('message', lang('mail_sent_success'));
        redirect('admin/payment');
    }

}
