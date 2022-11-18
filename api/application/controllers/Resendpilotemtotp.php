<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Resendpilotemtotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->model('CommonModel');
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        //$pilotId = $this->post('pilotId'); //pilotId
        //$emtId = $this->post('emtId'); //emtId
        $pilotMobile = $this->post('pilotMobile');
        $emtMobile = $this->post('emtMobile');
        $pilotRec = $this->CommonModel->get_pilot_id_as_per_mobile_no($pilotMobile);
        $emtIdRec = $this->CommonModel->get_emt_id_as_per_mobile_no($emtMobile);
        if(!empty($pilotRec)){
            $data['pilotId'] = $pilotRec[0]['clg_id'];
            $pilotId = $pilotRec[0]['clg_id'];
        }
        if(!empty($emtIdRec)){
            $data['emtId'] = $emtIdRec[0]['clg_id'];
            $emtId = $emtIdRec[0]['clg_id'];
        }
        if($typeId == 1){
            if(!empty($vehicleNumber) && !empty($pilotMobile)){
                $otp = rand(1000, 9999);
                $form_url = "http://www.mgage.solutions/SendSMS/sendmsg.php";
                $txtMsg='';
                $txtMsg .= "BVG,"." \n";
                $txtMsg .=  "OTP for your login is : ".$otp.""." \n";
                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                $txtMsg .=  "MEMS";
                $data_to_post = array();
                $data_to_post['uname'] = 'BVGMEMS';
                $data_to_post['pass'] = 'Mems@108';//s1M$t~I)';
                $data_to_post['send'] = 'BVGMEM';
                $data_to_post['dest'] = $pilotMobile; 
                $data_to_post['msg'] = $txtMsg;
                
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL, $form_url);
                curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                $result = curl_exec($curl);
                curl_close($curl);

                $current_time = date('Y-m-d H:i:s');
                $OTP_timestamp = strtotime($current_time) + 30*60;
                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                $data = array(
                            'otp' => $otp,
                            'otp_expire_time' =>  $otp_expiry_time
                        );
                $this->user->insertPilotOtp($data,$pilotId);
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
        }else if($typeId == 2){
            if(!empty($vehicleNumber) && !empty($emtMobile)){
                $otp = rand(1000, 9999);
                $form_url = "http://www.mgage.solutions/SendSMS/sendmsg.php";
                $txtMsg='';
                $txtMsg .= "BVG,"." \n";
                $txtMsg .=  "OTP for your login is : ".$otp.""." \n";
                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                $txtMsg .=  "MEMS";
                $data_to_post = array();
                $data_to_post['uname'] = 'BVGMEMS';
                $data_to_post['pass'] = 'Mems@108';//s1M$t~I)';
                $data_to_post['send'] = 'BVGMEM';
                $data_to_post['dest'] = $emtMobile; 
                $data_to_post['msg'] = $txtMsg;
                
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL, $form_url);
                curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                $result = curl_exec($curl);
                curl_close($curl);

                $current_time = date('Y-m-d H:i:s');
                $OTP_timestamp = strtotime($current_time) + 30*60;
                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                $data = array(
                            'otp' => $otp,
                            'otp_expire_time' =>  $otp_expiry_time
                        );
                $this->user->insertEmtOtp($data,$emtId);
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
        }else{
            if(!empty($vehicleNumber) && !empty($emtMobile) && !empty($pilotMobile)){
                $otp = rand(1000, 9999);
                $form_url = "http://www.mgage.solutions/SendSMS/sendmsg.php";
                $txtMsg='';
                $txtMsg .= "BVG,"." \n";
                $txtMsg .=  "OTP for your login is : ".$otp.""." \n";
                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                $txtMsg .=  "MEMS";
                $data_to_post = array();
                $data_to_post['uname'] = 'BVGMEMS';
                $data_to_post['pass'] = 'Mems@108';//s1M$t~I)';
                $data_to_post['send'] = 'BVGMEM';
                $data_to_post['dest'] = $emtMobile; 
                $data_to_post['msg'] = $txtMsg;
                
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL, $form_url);
                curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                $result = curl_exec($curl);
                curl_close($curl);

                $current_time = date('Y-m-d H:i:s');
                $OTP_timestamp = strtotime($current_time) + 30*60;
                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                $data = array(
                            'otp' => $otp,
                            'otp_expire_time' =>  $otp_expiry_time
                        );
                $this->user->insertEmtOtp($data,$emtId);
                $otp = rand(1000, 9999);
                $form_url = "http://www.mgage.solutions/SendSMS/sendmsg.php";
                $txtMsg='';
                $txtMsg .= "BVG,"." \n";
                $txtMsg .=  "OTP for your login is : ".$otp.""." \n";
                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                $txtMsg .=  "MEMS";
                $data_to_post = array();
                $data_to_post['uname'] = 'BVGMEMS';
                $data_to_post['pass'] = 'Mems@108';//s1M$t~I)';
                $data_to_post['send'] = 'BVGMEM';
                $data_to_post['dest'] = $pilotMobile; 
                $data_to_post['msg'] = $txtMsg;
                
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL, $form_url);
                curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                $result = curl_exec($curl);
                curl_close($curl);

                $current_time = date('Y-m-d H:i:s');
                $OTP_timestamp = strtotime($current_time) + 30*60;
                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                $data = array(
                            'otp' => $otp,
                            'otp_expire_time' =>  $otp_expiry_time
                        );
                $this->user->insertPilotOtp($data,$pilotId);
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
}