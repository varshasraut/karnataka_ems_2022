<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Resendvehicleotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        if(!empty($typeId) && !empty($vehicleNumber)){
            $mobileNo = $this->user->getVehicleData($vehicleNumber);
            $otp = rand(1000, 9999);
            // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
            // $txtMsg='';
            // $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
            
            // $data_to_post = array();
            // $data_to_post['uname'] = 'bvgmems';
            // $data_to_post['pass'] = 'm2v5c2';
            // $data_to_post['send'] = 'SperocHL';
            // $data_to_post['dest'] = $mobileNo; 
            // $data_to_post['msg'] = $txtMsg;
            
            // $curl = curl_init();
            // curl_setopt($curl,CURLOPT_URL, $form_url);
            // curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
            // $result = curl_exec($curl);
            // curl_close($curl);
            
            $current_time = date('Y-m-d H:i:s');
            $OTP_timestamp = strtotime($current_time) + 30*60;
            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
            $data = array(
                        'otp' => $otp,
                        'otp_expire_time' =>  $otp_expiry_time
                    );
            $this->user->insertVehicleOtp($data,$vehicleNumber);
            $this->response([
                'data' => ([
                    'type' => $typeId,
                    'otp' => $otp
                ]),
                'error' => null
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
}