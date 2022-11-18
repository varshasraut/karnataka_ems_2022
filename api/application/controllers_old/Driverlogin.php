<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Driverlogin extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
       $typeId = $this->post('type');
        $mobilebNo = $this->post('mobileNo');
        $deviceId = $this->post('deviceId');
        $vehicleNumber = $this->post('vehicleNumber');
        $password = $this->post('password');
        $pilotLoginType = $this->post('pilotLoginType');
        //$skipotp = $this->post('skipotp');
     
        $userdata = $this->user->getClgdetails($mobilebNo);
        // print_r($userdata);
	   if(!empty($userdata)){ 
	        $clg_id=$userdata[0]['clg_id'];
	        $userName=$userdata[0]['clg_ref_id'];
	       
    		$check['typeId'] = $typeId;
            $check['pilotId'] = $userdata[0]['clg_id'];
            $check['deviceid'] = $deviceId;
            $check['vehicleNumber'] = $vehicleNumber; 
	       
	        if(!empty($typeId) && !empty($vehicleNumber)){
				 $checklogin['deviceid'] = $deviceId;
				 $checklogin['typeId'] = $typeId;
				 $checklogin['vehicleNumber'] = $vehicleNumber;
				 $checklogin['pilotId'] = $userdata[0]['clg_id'];
				 $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($checklogin);
				 $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($checklogin);
			     $pilotLoginCheck = $this->user->checkBoth1($checklogin);
                // $otpExpireTime = $this->user->getuserOtp( $userdata[0]['clg_id']);
                if($userdata[0]['clg_password'] != $password){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 4,
                            'message' => 'Wrong Password'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                    if($userdata[0]['clg_password'] == $password){
                        $data = array(
                            'otp' => '',
                            'otp_expire_time' => '',
                            'skipotp' => 'true',
                            'otp_verification' => ''
                        );
                        $this->user->updateusertOtp($clg_id,$data);
                        $current_time = date('Y-m-d H:i:s');
                        $data1 = array(
                            'type_id' => $typeId,
                            'vehicle_no' => $vehicleNumber,
                            'clg_id' => $clg_id,
                            'login_time' => $current_time,
                            'device_id' => $deviceId,
                            'status' => 1,
                            'login_type' => $pilotLoginType
                        );
                        $this->user->insertLoginData($data1);
                        $cookie = array(
                            'name'   => 'cookie',
                            'value'  => $this->encryption->encrypt($clg_id),
                            'expire' =>  172800,
                            'secure' => false,
                            'httponly' => true
                        );
                        $this->input->set_cookie($cookie);
                        $deviceIdCookie = array(
                            'name'   => 'deviceId',
                            'value'  => $this->encryption->encrypt($deviceId),
                            'expire' =>  172800,
                            'secure' => false,
                            'httponly' => true
                        );
                        $this->input->set_cookie($deviceIdCookie);
                        $this->response([
                            'data' => array(
                                'userName'=> $userName,
                                'message' => 'Successfully Login',
                                'otherDevice' => 1
                            ),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 4,
                                'message' => 'Wrong Password'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    if($chkSameDeviceLogin == 1){
                        $data1['modified_time'] = date('Y-m-d H:i:s');
                        $this->user->updateLoginSession($data1,$check);
                        $cookie = array(
                            'name'   => 'cookie',
                            'value'  => $this->encryption->encrypt($clg_id),
                            'expire' =>  172800,
                            'secure' => false,
                            'httponly' => true
                        );
                        $this->input->set_cookie($cookie);
                        $deviceIdCookie = array(
                            'name'   => 'deviceId',
                            'value'  => $this->encryption->encrypt($deviceId),
                            'expire' =>  172800,
                            'secure' => false,
                            'httponly' => true
                        );
                        $this->input->set_cookie($deviceIdCookie);
                           $this->response([
                            'data' => array(
                                 'userName'=> $userName,
                                'message' => 'Successfully Login'
                            ),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        if(($pilotLoginCheck[0]['vehicle_no'] == $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] == $clg_id)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'The user/users are already logged into the ambulance('.$pilotLoginCheck[0]['vehicle_no'].')'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if(($pilotLoginCheck[0]['vehicle_no'] == $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] != $clg_id)){
                            // print_r($pilotLoginCheck[0]['vehicle_no']);
                            // print_r($pilotLoginCheck[0]['clg_id']);
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'The users are already logged into the ambulance('.$pilotLoginCheck[0]['vehicle_no'].')'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if(($pilotLoginCheck[0]['vehicle_no'] != $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] == $clg_id)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'This driver is already logged into the ambulance('.$pilotLoginCheck[0]['vehicle_no'].')'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
	   }else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 5,
                    'message' => 'Wrong mobile number'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
          
      

}