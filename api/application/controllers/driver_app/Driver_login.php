<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Driver_login extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('driver_app/Driver_login_model','driver_app/Driver_common_model'));
    }
    public function index_post(){
        $vehicleNumber = $this->post('vehicleNumber');
        $driverMobile = $this->post('driverMobile');
        $uniqueId = $this->post('uniqueId');
        $data['vehicleNumber'] = $vehicleNumber;
        $data['driverMobile'] = $driverMobile;
        $data['uniqueId'] = $uniqueId;
        if(!empty($vehicleNumber) || !empty($driverMobile) || !empty($uniqueId)){
            $getClgId = $this->Driver_common_model->getClgIdAsPerMobileNo($driverMobile);
            if(!empty($getClgId)){
                $data['clg_id'] = $getClgId;
                $chkLogin = $this->Driver_login_model->chkLoginAnotherVeh($data);
                $chkVehLogin = $this->Driver_login_model->chkVehLogin($data);
                if(!empty($chkLogin)){
                    if(($data['clg_id'] == $chkLogin[0]['clg_id'] && $data['vehicleNumber'] == $chkLogin[0]['login_vehicle_no'] && $data['uniqueId'] == $chkLogin[0]['device_id'] && $chkLogin[0]['status'] == '1') ){
                        // echo 'dd';die;
                        $this->createOtp($getClgId,$driverMobile);
                    }else if($data['clg_id'] == $chkLogin[0]['clg_id'] && $data['vehicleNumber'] == $chkLogin[0]['login_vehicle_no'] && $data['uniqueId'] != $chkLogin[0]['device_id'] && $chkLogin[0]['status'] == '1'){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Already login on another device'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if($data['clg_id'] == $chkLogin[0]['clg_id'] && $data['vehicleNumber'] != $chkLogin[0]['login_vehicle_no'] && $chkLogin[0]['status'] == '1' ){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 2,
                                'message' => 'The user is already logged into the vehicle ('.$chkLogin[0]['login_vehicle_no'].')'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if(count($chkLogin)>1){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 3,
                                'message' => 'The user is login multiple time please contact to the manager'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    if(!empty($chkVehLogin)){
                        if($data['clg_id'] != $chkVehLogin[0]['clg_id'] && $data['vehicleNumber'] == $chkVehLogin[0]['login_vehicle_no'] && $chkVehLogin[0]['status'] == '1' ){
                            $clgName = $this->Driver_common_model->getClgNameAsPerClgId($getClgId);
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 4,
                                    'message' => 'Already User ('.$clgName.') is login on same vehicle number'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }else{
                        $this->createOtp($getClgId,$driverMobile);
                    }
                    
                }
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 5,
                        'message' => 'Mobile number not registered'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function createOtp($getClgId,$driverMobile){
        $otp = rand(1000, 9999);
        $form_url = "http://www.mgage.solutions/SendSMS/sendmsg.php";
        $txtMsg='';
        // $txtMsg .= "<#> OTP password is : $otp. " ." \n"
        //           ."OTP is valid for 30 Minutes jdr3VXi/QKh";
        //$txtMsg .= "BVG Ambulance On Maintenance Ambulance Number: ".$otp." MHEMS";
        $txtMsg .= "BVG,"." \n";
        $txtMsg .=  "OTP for your login is : ".$otp.""." \n";
        $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
        $txtMsg .=  "MEMS";
        $data_to_post = array();
        $data_to_post['uname'] = 'BVGMEMS';
        $data_to_post['pass'] = 'Mems@108';//s1M$t~I)';
        $data_to_post['send'] = 'BVGMEM';
        $data_to_post['dest'] = $driverMobile; 
        $data_to_post['msg'] = $txtMsg;
        // $curl = curl_init();
        // curl_setopt($curl,CURLOPT_URL, $form_url);
        // curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
        // $result = curl_exec($curl);
        // curl_close($curl);
        $current_time = date('Y-m-d H:i:s');
        $OTP_timestamp = strtotime($current_time) + 20*60;
        $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
        $otpAddInClgtable = array(
                    'otp' => $otp,
                    'otp_expire_time' =>  $otp_expiry_time
                );
        $this->Driver_login_model->insertOtpOnClgTable($otpAddInClgtable,$getClgId);
        $this->response([
            'data' => ([
                'otp' => $otp
            ]),
            'error' => null
        ], REST_Controller::HTTP_OK);
    }
    public function checkOtp_post(){
        $vehicleNumber = $this->post('vehicleNumber');
        $driverMobile = $this->post('driverMobile');
        $uniqueId = $this->post('uniqueId');
        $otp = $this->post('otp');
        $data['vehicleNumber'] = $vehicleNumber;
        $data['driverMobile'] = $driverMobile;
        $data['uniqueId'] = $uniqueId;
        if(!empty($vehicleNumber) || !empty($driverMobile) || !empty($uniqueId) || !empty($otp)){
            $getClgId = $this->Driver_common_model->getClgIdAsPerMobileNo($driverMobile);
            if(!empty($getClgId)){
                $driverOtpCount = $this->Driver_login_model->getDriverOtpCount($getClgId);
                $otpExpireTime = $this->Driver_login_model->getDriverOtp($getClgId);
                $current_time = date('Y-m-d H:i:s');
                if($otpExpireTime[0]['otp_expire_time'] >= $current_time){
                    if($otpExpireTime[0]['otp'] == $otp){
                        if($driverOtpCount == 3){
                            $emptydata = array(
                                'otp' => '',
                                'otp_count' => 0
                            );
                            $this->Driver_login_model->emptydata($getClgId,$emptydata);
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 3,
                                    'message' => 'Too many attempts'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $data = array(
                                'otp' => '',
                                'otp_expire_time' => '',
                                'otp_verification' => 2
                            );
                            $this->Driver_login_model->updateDriverOtp($getClgId,$data);
                            $login_secret_key = md5(rand(10,100).$getClgId.date('YmdHis'));
                            // echo $login_secret_key;die;
                            $data1 = array(
                                'login_vehicle_no' => $vehicleNumber,
                                'clg_id' => $getClgId,
                                'login_time' => $current_time,
                                'device_id' => $uniqueId,
                                'status' => 1,
                                'login_secret_key' => $login_secret_key
                            );
                            $this->Driver_login_model->insertDriverLoginData($data1); 
                            $this->response([
                                'data' => array(
                                    'loginSecretKey' => $login_secret_key,
                                    'message' => 'Successfully Login'
                                ),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }else{
                        // $driverOtpCount = $this->Driver_login_model->getDriverOtpCount($getClgId);
                        // if($driverOtpCount == 3){
                        //     $emptydata = array(
                        //         'otp' => '',
                        //         'otp_count' => 0
                        //     );
                        //     $this->Driver_login_model->emptydata($getClgId,$emptydata);
                        //     $this->response([
                        //         'data' => null,
                        //         'error' => ([
                        //             'code' => 3,
                        //             'message' => 'Too many attempts'
                        //         ])
                        //     ],REST_Controller::HTTP_OK);
                        // }else{
                            $count = $driverOtpCount + 1;
                            $data = array(
                                'otp_count' => $count
                            );
                            $this->Driver_login_model->insertOtpCount($data,$getClgId);
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Invalid OTP'
                                ])
                            ],REST_Controller::HTTP_OK);
                        // } 
                    }
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'OTP expired'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function resendOtp_post(){
        $driverMobile = $this->post('driverMobile');
        if(!empty($driverMobile)){
            $getClgId = $this->Driver_common_model->getClgIdAsPerMobileNo($driverMobile);
            $this->createOtp($getClgId,$driverMobile);
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
}