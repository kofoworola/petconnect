<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once APPPATH . '/third_party/Twilio/autoload.php';

use Twilio\Rest\Client;

class cron extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("appointment_model");
        $this->load->model("to_do_list_model");
        $this->load->model("setting_model");
        $this->load->model("patient_model");
        $this->load->model("user_model");
    }

    function index() {
        echo "Appointments";
        $all = $this->appointment_model->get_all();
        $now = date('Y:m:d H:i:s');
        $time = strtotime($now);
        foreach ($all as $new) {
            $timestamp = strtotime($new->reminder);
            $timereal = strtotime($new->date);
            if ($time > $timestamp && $new->sent == 0) {
                $patient = $this->patient_model->get_patient_by_id($new->patient_id);
                $doctor = $this->user_model->get_user_by_id($new->doctor_id);
                echo '<br>';


                $date = date('m:d', $timereal);
                $time = date('H:s', $timereal);
                try {
                    if ($new->remind_doctor == 1) {
                        echo 'Doctor: ' . $doctor->email . '<br>';
                        $doctor_sms = new Client($doctor->twillo_id, $doctor->twillo_auth);
                        $doctor_sms->messages->create(
                                $doctor->contact, array(
                            'messagingServiceSid' => $doctor->message_id,
                            'body' => "Appointment reminder: " . $patient->name . " at " . $time . " on " . $date . "\xA"
                                )
                        );
                    }
                    if ($new->remind_patient == 1) {
                        echo 'Patient: ' . $patient->email . '<br>';
                        $patient_sms = new Client($doctor->twillo_id, $doctor->twillo_auth);
                        $patient_sms->messages->create(
                                $patient->contact, array(
                            'messagingServiceSid' => $doctor->message_id,
                            'body' => "Appointment reminder: Dr. " . $doctor->name . " at " . $time . " on " . $date . "\xA"
                                )
                        );
                    }

                    echo 'done<br>';
                } catch (\Twilio\Exceptions\TwilioException $e) {
                    echo $e->getMessage();
                }
                $save['sent'] = 1;
                $this->appointment_model->update($save, $new->id);
            }
        }
        unset($save);
        echo '<br>TO-DO';
        $todos = $this->to_do_list_model->get_all();
        $now = date('Y:m:d H:i:s');
        $time = strtotime($now);
        foreach ($todos as $new) {
            $timestamp = strtotime($new->reminder);
            $timereal = strtotime($new->date);
            if ($time > $timestamp && $new->sent == 0) {
                $doctor = $this->user_model->get_user_by_id($new->doctor_id);
                echo '<br>';

                $date = date('m:d', $timereal);
                try {
                    if ($new->remind == 1) {
                        echo 'Doctor: ' . $doctor->email . '<br>';
                        $doctor_sms = new Client($doctor->twillo_id, $doctor->twillo_auth);
                        $doctor_sms->messages->create(
                                $doctor->contact, array(
                            'messagingServiceSid' => $doctor->message_id,
                            'body' => "To-Do Reminder: " . $new->title . " at " . $date . "\xA"
                                )
                        );
                    }
                } catch (\Twilio\Exceptions\TwilioException $e) {
                    echo $e->getMessage();
                }
                $save['sent'] = 1;
                $this->to_do_list_model->update($save, $new->id);
            }
        }
    }

    function upload_drive() {
        require_once APPPATH . '/vendor/autoload.php';
        //define('GOOGLE_APPLICATION_CREDENTIALS', APPPATH . '/assets/petconnect-account.json');
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.APPPATH. '/assets/petconnect-account.json');
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Drive::DRIVE_FILE);
        $service = new Google_Service_Drive($client);
        $file = new Google_Service_Drive_DriveFile();
        $file->setName("kofo file");
        $result = $service->files->create($file, array(
            'data' => "hello google drive",
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media'
        ));
        print_r($result->id);
    }

}
