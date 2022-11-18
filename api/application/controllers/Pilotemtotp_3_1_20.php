<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Pilotemtotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        $pilotId = $this->post('pilotId');
        $emtId = $this->post('emtId');
        
        if($typeId == 1){
            if(!empty($vehicleNumber) && !empty($pilotId)){
                $checkPilotLogin = $this->user->checkBoth($vehicleNumber);
                if($checkPilotLogin == 2){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'type' => 'B',
                            'code' => 1,
                            'message' => 'Already another user is login'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    if(!empty($checkPilotLogin)){
                        $pilot = $checkPilotLogin[0]['type_id'];
                        if($pilot == 1){
                            // print_r('yes');
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'type' => 'D',
                                    'code' => 1,
                                    'message' => 'Driver is already login so please do the emt login'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                    $emtMobNo = $this->user->getEmtMobNo($pilotId);
                    if(!empty($emtMobNo)){
                        $otp = rand(1000, 9999);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        // $txtMsg='';
                        // $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        // $data_to_post = array();
                        // $data_to_post['uname'] = 'bvgmems';
                        // $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        // $data_to_post['send'] = 'SperocHL';
                        // $data_to_post['dest'] = $emtMobNo; 
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
                            'data' => null,
                            'error' => ([
                                'code' => 2,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else if($typeId == 2 ){
            // print_r('2');
            if(!empty($vehicleNumber) && !empty($emtId)){
                $checkPilotLogin = $this->user->checkBoth($vehicleNumber);
                if($checkPilotLogin == 2){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'type' => 'B',
                            'code' => 1,
                            'message' => 'Already another user is login'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $pilot = $checkPilotLogin[0]['type_id'];
                    if($pilot == 2){
                        $this->response([
                            'type' => 'P',
                            'data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Paramedic is already login so do the anyone pilot login'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                    $emtMobNo = $this->user->getEmtMobNo($emtId);
                    if(!empty($emtMobNo)){
                        $otp = rand(1000, 9999);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        // $txtMsg='';
                        // $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        // $data_to_post = array();
                        // $data_to_post['uname'] = 'bvgmems';
                        // $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        // $data_to_post['send'] = 'SperocHL';
                        // $data_to_post['dest'] = $emtMobNo; 
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
                            'data' => null,
                            'error' => ([
                                'code' => 2,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            if(!empty($vehicleNumber) && !empty($pilotId) && !empty($emtId)){
                $checkPilotLogin = $this->user->checkBoth($vehicleNumber);
                if($checkPilotLogin == 2){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'type' => 'B',
                            'code' => 1,
                            'message' => 'Already another user is login'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $pilot = $checkPilotLogin[0]['type_id'];
                    if($pilot == 1){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'type' => 'D',
                                'code' => 1,
                                'message' => 'Driver is already login so do the anyone emt login'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if($pilot == 2){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'type' => 'P',
                                'code' => 1,
                                'message' => 'Paramedic is already login so do the anyone pilot login'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                    $pilotMobNo = $this->user->getPilotMobNo($pilotId);
                    $emtMobNo = $this->user->getEmtMobNo($emtId);
                    if(!empty($emtMobNo) || !empty($pilotMobNo)){
                        $otp = rand(1000, 9999);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        // $txtMsg='';
                        // $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        // $data_to_post = array();
                        // $data_to_post['uname'] = 'bvgmems';
                        // $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        // $data_to_post['send'] = 'SperocHL';
                        // $data_to_post['dest'] = $emtMobNo; 
                        // $data_to_post['dest'] = $pilotMobNo;
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
                        $this->user->insertEmtOtp($data,$emtId);
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
                            'data' => null,
                            'error' => ([
                                'code' => 2,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }
    }
}