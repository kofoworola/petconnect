<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/third_party/stripe/init.php';
require_once APPPATH . '/vendor/autoload.php';

class payment extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->is_logged_in();
        $this->load->helper('dompdf_helper');
        $this->load->model("custom_field_model");
        $this->load->model("user_model");
        $this->load->model("instruction_model");
        $this->load->model("prescription_model");
        $this->load->model("notification_model");
        $this->load->model("patient_model");
        $this->load->model("medicine_model");
        $this->load->model("disease_model");
        $this->load->model("medical_test_model");
        $this->load->model("setting_model");
        $this->load->model("invoice_model");
        $this->load->model("payment_mode_model");
    }

    function index($id = false) {
        $data['p_id'] = $id;
        $data['payments'] = array();
        $admin = $this->session->userdata('admin');
        $user = $this->user_model->get_user_by_id($admin['id']);

        $data['payments'] = $this->prescription_model->get_payment_by_doctor();
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['setting'] = $this->setting_model->get_setting();

        $data['pay_details'] = $details = $this->prescription_model->get_payment_details($admin['id']);
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();

        //print_r($data['details']->stripe_publish);die();
        if ($invoice->invoice == 0) {
            $dr_invoice = $this->invoice_model->get_doctor_invoice_number();
            //print_r($details);die();
            if (empty($dr_invoice->invoice)) {
                $data['i_no'] = $details->start_invoice;
            } else {
                $data['i_no'] = $dr_invoice->invoice;
            }
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }

        $gateway = new Braintree_Gateway(array(
            'accessToken' => $user->access_token,
        ));

        $data['token'] = $gateway->clientToken()->generate();
        $data['order_no'] = $this->prescription_model->get_order_no();
        $data['page_title'] = lang('payment');
        $data['body'] = 'prescription/payment_list';
        $this->load->view('template/main', $data);
    }

    function paypal_confrim() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $admin = $this->session->userdata('admin');
            $user = $this->user_model->get_user_by_id($admin['id']);
            $amount = $this->input->post('amount');
            $nonce = $this->input->post('amount');
            $order_no = $this->input->post('order_no');
            $setting = $this->setting_model->get_setting_by_id($admin['id']);

            $gateway = new Braintree_Gateway(array(
                'accessToken' => $user->access_token,
            ));
            $result = $gateway->transaction()->sale([
                "amount" => $amount,
                'merchantAccountId' => 'USD',
                "paymentMethodNonce" => $nonce,
                "orderId" => $order_no,
                "descriptor" => [
                    "name" => $setting->name,
                    "phone" => $seting->contact
                ]
            ]);
            if ($result->success) {
                $this->session->set_flashdata('message', 'Payment was complete, transaction id: '. $result->transaction->id);
            } else {
                $this->session->set_flashdata('error', 'Payment could not be complete: '. $result->message);
            }
        } else {
            redirect('admin/dshboard');
        }
    }

    function edit_payment($id) {
        $data['payment'] = $this->prescription_model->get_payment_by_id($id);
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('date', 'lang:date', 'required');
            $this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');
            if ($this->form_validation->run() == true) {
                $save['amount'] = $this->input->post('amount');
                $save['payment_mode_id'] = $this->input->post('payment_mode_id');
                //$save['prescription_id'] = $id;
                $save['patient_id'] = $this->input->post('patient_id');
                $save['date'] = $this->input->post('date');
                $save['invoice'] = $data['payment']->invoice;
                //echo '<pre>'; print_r($save);die;
                $this->prescription_model->update_fees($save, $data['payment']->id);
                $this->session->set_flashdata('message', lang('fees_updated'));
                echo 1;
            } else {

                echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>' . validation_errors() . '
											</div>
				';
            }
        }
    }

    function add_payment($id = false) {
        $admin = $this->session->userdata('admin');
        $data['pateints'] = $this->patient_model->get_patients_by_doctor();
        $data['payment_modes'] = $this->prescription_model->get_all_payment_modes();
        //$data['fees_all']				= $this->prescription_model->get_fees_all($id);
        $data['invoice'] = $invoice = $this->prescription_model->get_invoice_number();
        if ($invoice->invoice == 0) {
            $dr_invoice = $this->invoice_model->get_doctor_invoice_number();
            if (empty($dr_invoice->invoice)) {
                $data['i_no'] = 1;
            } else {
                $data['i_no'] = $dr_invoice->invoice;
            }
        } else {
            $data['i_no'] = $invoice->invoice + 1;
        }
        //echo '<pre>'; print_r($_POST);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('amount', 'lang:amount', 'required');
            $this->form_validation->set_rules('date', 'lang:date', 'required');
            $this->form_validation->set_rules('invoice_no', 'lang:invoice', 'required');
            if ($this->form_validation->run() == true) {
                $details = $this->prescription_model->get_payment_details($admin['id']);
                \Stripe\Stripe::setApiKey($details->stripe_secret);
                $token = $this->input->post('stripeToken');

                try {
                    $charge = \Stripe\Charge::create(array(
                                "amount" => $this->input->post('amount'), // Amount in cents
                                "currency" => "usd",
                                "source" => $token,
                                "description" => "Example charge"
                    ));
                    $save['amount'] = $this->input->post('amount');
                    $save['patient_id'] = $this->input->post('patient_id');
                    $save['payment_mode'] = "Stripe";
                    $save['date'] = $this->input->post('date');
                    $save['invoice'] = $data['i_no'];
                    $this->prescription_model->save_fees($save);
                    $this->session->set_flashdata('message', "Payment Was Successful");
                    redirect('admin/payment');
                } catch (\Stripe\Error\Card $e) {
                    echo "failed";
                }

                // $this->input->post('invoice_no');
                //echo '<pre>';print_r($save);die;

                echo 1;
            } else {

                echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>' . validation_errors() . '
											</div>
				';
            }
        }
    }

    function delete($id = false) {

        if ($id) {
            $this->prescription_model->delete_fees($id);
            $this->session->set_flashdata('message', "Payment Deleted");
            redirect('admin/payment');
        }
    }

    function delete_payment($id = false, $redirect) {

        if ($id) {
            $this->prescription_model->delete_fees($id);
            $this->session->set_flashdata('message', "Payment Deleted");
            redirect('admin/patients/view/' . $redirect . '/payment_history');
        }
    }

}
