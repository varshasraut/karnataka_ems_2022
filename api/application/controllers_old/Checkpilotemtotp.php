<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Checkpilotemtotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->model('CommonModel');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $typeId = $this->post('type');
        $pilotId = $this->post('pilotId');
        $emtId = $this->post('emtId');
        $otp = $this->post('otp');
        $deviceId = $this->post('deviceId');
        $userName = $this->post('userName');
        $vehicleNumber = $this->post('vehicleNumber');
        $emtLoginType = $this->post('emtLoginType');
        $pilotLoginType = $this->post('pilotLoginType');
        $password = $this->post('password');
        $skipotp = $this->post('skipotp');
      //  print_r($pilotLoginCheck);die;
        if($typeId== 4)
        {
            $userdata = $this->user->getClgid($userName);
            $check['clg_id'] = $userdata;
            $check['typeId'] = $typeId;
            $check['deviceid'] = $deviceId;
        }
        else{
            $check['typeId'] = $typeId;
            $check['pilotId'] = $pilotId;
            $check['emtId'] = $emtId;
            $check['deviceid'] = $deviceId;
            $check['vehicleNumber'] = $vehicleNumber;
            $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($check);
           //  $str = $this->db->last_query();
        // print_r($str);
       //  die();
            $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($check);
        }
        //$plain_text = '1234567890';
        if($skipotp == 'true'){
            if($typeId == 4)
			{
			   if(!empty($userdata)){ 
                    if(!empty($typeId) && !empty($userName)){
                    $checklogin['deviceid'] = $deviceId;
                    $checklogin['typeId'] = $typeId;
                    $checklogin['clg_id'] = $userdata;
                    $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($checklogin);
                    $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($checklogin);
                    $pilotLoginCheck = $this->user->checkBoth1($checklogin);
                    
                        $otpExpireTime = $this->user->getuserOtp($userdata);
            
                        if($otpExpireTime[0]['clg_password'] != $password){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 4,
                                    'message' => 'Wrong Password'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if($chkAnotherDeviceLogin == 1){
                            if($otpExpireTime[0]['clg_password'] == $password){
                                $data = array(
                                    'otp' => '',
                                    'otp_expire_time' => '',
                                    'skipotp' => $skipotp,
                                    'otp_verification' => ''
                                );
                                $this->user->updateusertOtp($userdata,$data);
                                $current_time = date('Y-m-d H:i:s');
                                $data1 = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $userdata,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => ''
                                );
                                $this->user->insertLoginData($data1);
                                $cookie = array(
                                    'name'   => 'cookie',
                                    'value'  => $this->encryption->encrypt($userdata),
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
                                    'value'  => $this->encryption->encrypt($userdata),
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
                            }
                            elseif($chkSameDeviceLogin == 2){
                                $data1['modified_time'] = date('Y-m-d H:i:s');
                                $this->user->updateLoginSession($data1,$check);
                                $cookie = array(
                                    'name'   => 'cookie',
                                    'value'  => $this->encryption->encrypt($userdata),
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
                                $current_time = date('Y-m-d H:i:s');
                                $data1 = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $userdata,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => ''
                                );
                                $this->user->insertLoginData($data1);
                                
                                $this->response([
                                    'data' => array(
                                        'userName' => $userName,
                                        'message' => 'Successfully Login'
                                    ),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else{
                                if(($pilotLoginCheck[0]['clg_id'] == $userdata)){
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'The user/users are already logged onto another app('.$pilotLoginCheck[0]['device_id'].')'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }
                                }
                            }
                        }
                    
                    else{
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
                            'message' => 'Wrong Username'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
			   
			}else if($typeId == 1){
            
                if(!empty($typeId) && !empty($pilotId)){
                    $pilotLoginCheck = $this->user->checkBoth1($check);
                    if(!empty($pilotLoginCheck)){
                        $loginUser = $this->user->getUserLoginAsPerUser($pilotLoginCheck);
                        // print_r($loginUser);die;
                    }
                    // print_r($pilotLoginCheck);die;
                    $otpExpireTime = $this->user->getPilotOtp($pilotId);
                    if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                        if($otpExpireTime[0]['clg_password'] == $password){
                            $data = array(
                                'otp' => '',
                                'otp_expire_time' => '',
                                'skipotp' => $skipotp,
                                'otp_verification' => ''
                            );
                            $this->user->updatepilotOtp($pilotId,$data);
                            $current_time = date('Y-m-d H:i:s');
                            $data1 = array(
                                'type_id' => $typeId,
                                'vehicle_no' => $vehicleNumber,
                                'clg_id' => $pilotId,
                                'login_time' => $current_time,
                                'device_id' => $deviceId,
                                'status' => 1,
                                'login_type' => $pilotLoginType
                            );
                            $this->user->insertLoginData($data1);
                            $cookie = array(
                                'name'   => 'cookie',
                                'value'  => $this->encryption->encrypt($pilotId),
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
                                'value'  => $this->encryption->encrypt($pilotId),
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
                                    'message' => 'Successfully Login'
                                ),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            if(($pilotLoginCheck[0]['vehicle_no'] == $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] == $pilotId)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The user/users ('.$loginUser[0]['clg_first_name'].' '.$loginUser[0]['clg_mid_name'].' '.$loginUser[0]['clg_last_name'].') are already logged into the ambulance('.$pilotLoginCheck[0]['vehicle_no'].')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(($pilotLoginCheck[0]['vehicle_no'] == $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] != $pilotId  && ($pilotLoginCheck[0]['login_type'] == 'D'))){
                                // print_r($pilotLoginCheck[0]['vehicle_no']);
                                // print_r($pilotLoginCheck[0]['clg_id']);
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'Other User Already Logged In'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(($pilotLoginCheck[0]['vehicle_no'] != $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] == $pilotId)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'This driver ('.$loginUser[0]['clg_first_name'].' '.$loginUser[0]['clg_mid_name'].' '.$loginUser[0]['clg_last_name'].') is already logged into the ambulance('.$pilotLoginCheck[0]['vehicle_no'].')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }
                            else{
                                $current_time = date('Y-m-d H:i:s');
                                $data1 = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $pilotId,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => $pilotLoginType
                                );
                                $this->user->insertLoginData($data1);
                                $cookie = array(
                                    'name'   => 'cookie',
                                    'value'  => $this->encryption->encrypt($pilotId),
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
                                        'message' => 'Successfully Login',
                                        'otherDevice' => 1
                                    ),
                                    'error' => null
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
            
            }else if($typeId == 2){
               
                if(!empty($typeId) && !empty($emtId)){
                    $otpExpireTime = $this->user->getPilotOtp($emtId);
                    $pilotLoginCheck = $this->user->checkBoth1($check);
                    if(!empty($pilotLoginCheck)){
                        $loginUser = $this->user->getUserLoginAsPerUser($pilotLoginCheck);
                        // print_r($loginUser);die;
                    }
                    // print_r($pilotLoginCheck);die;
                    if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                        if($otpExpireTime[0]['clg_password'] == $password){
                            $data = array(
                                'otp' => '',
                                'otp_expire_time' => '',
                                'skipotp' => $skipotp,
                                'otp_verification' => ''
                            );
                            $this->user->updatepilotOtp($emtId,$data);
                            $current_time = date('Y-m-d H:i:s');
                            $data1 = array(
                                'type_id' => $typeId,
                                'vehicle_no' => $vehicleNumber,
                                'clg_id' => $emtId,
                                'login_time' => $current_time,
                                'device_id' => $deviceId,
                                'status' => 1,
                                'login_type' => $emtLoginType
                            );
                            $this->user->insertLoginData($data1);
                            $cookie = array(
                                'name'   => 'cookie',
                                'value'  => $this->encryption->encrypt($emtId),
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
                                    'message' => 'Successfully Login'
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
                                'value'  => $this->encryption->encrypt($emtId),
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
                                    'message' => 'Successfully Login'
                                ),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            if(($pilotLoginCheck[0]['vehicle_no'] == $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] == $emtId)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'Already User ('.$loginUser[0]['clg_first_name'].' '.$loginUser[0]['clg_mid_name'].' '.$loginUser[0]['clg_last_name'].') is login on ('.$pilotLoginCheck[0]['vehicle_no'].') ambulance no '
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(($pilotLoginCheck[0]['vehicle_no'] == $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] != $emtId  && ($pilotLoginCheck[0]['login_type'] == 'P' ) ) ){
               
                              
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'Other User Already Logged In'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(($pilotLoginCheck[0]['vehicle_no'] != $vehicleNumber) && ($pilotLoginCheck[0]['clg_id'] == $emtId)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'Already User ('.$loginUser[0]['clg_first_name'].' '.$loginUser[0]['clg_mid_name'].' '.$loginUser[0]['clg_last_name'].') is login on ('.$pilotLoginCheck[0]['vehicle_no'].') ambulance no '
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }
                            else{
                                $current_time = date('Y-m-d H:i:s');
                                $data1 = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $emtId,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => $emtLoginType
                                );
                                $this->user->insertLoginData($data1);
                                $cookie = array(
                                    'name'   => 'cookie',
                                    'value'  => $this->encryption->encrypt($emtId),
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
                                        'message' => 'Successfully Login'
                                    ),
                                    'error' => null
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
                if($chkSameDeviceLogin == 1){
                    $data1['modified_time'] = date('Y-m-d H:i:s');
                    $this->user->updateLoginSession($data1,$check);
                    $cookie = array(
                        'name'   => 'cookie',
                        'value'  => $this->encryption->encrypt($vehicleNumber),
                        'secure' => false,
                        'expire' =>  172800,
                        'httponly' => true
                    );
                    $this->input->set_cookie($cookie);
                    $deviceIdCookie = array(
                        'name'   => 'deviceId',
                        'value'  => $this->encryption->encrypt($deviceId),
                        'secure' => false,
                        'expire' =>  172800,
                        'httponly' => true
                    );
                    $this->input->set_cookie($deviceIdCookie);
                    $this->response([
                        'data' => array(
                            'message' => 'Successfully Login'
                        ),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    if(!empty($typeId) && !empty($pilotId) && !empty($emtId)){
                        $emtOtp = $this->user->getEmtOtp($emtId);
                        $pilotOtp = $this->user->getPilotOtp($pilotId);
                        $current_time = date('Y-m-d H:i:s');
                        $pilot = $this->user->checkPilot($check);
                        $emt = $this->user->checkEmt($check);
                        $chkPilotUserLogin = $this->user->chkPilotUserLogin($check);
                        $chkEmtUserLogin = $this->user->chkEmtUserLogin($check);
                        $chkAmbLogin = $this->user->chkAmbLogin($check);
                        $chkpilotLogin = $this->user->chkpilotLogin($check);
                        $chkEmtLogin = $this->user->chkEmtLogin($check);
                        if($chkAnotherDeviceLogin == 1){
                            if(($emtOtp[0]['clg_password'] == $password) || ($pilotOtp[0]['clg_password'] == $password)){
                                $data = array(
                                    'otp' => '',
                                    'otp_expire_time' => '',
                                    'skipotp' => $skipotp,
                                    'otp_verification' => ''
                                );
                                $this->user->updateemtOtp($emtId,$data);
                                $this->user->updatepilotOtp($pilotId,$data);
                                $emtdata = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $emtId,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => $emtLoginType
                                );
                                $this->user->insertLoginData($emtdata);
                                $pilotdata = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $pilotId,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => $pilotLoginType
                                );
                                $this->user->insertLoginData($pilotdata);
                                $cookie = array(
                                    'name'   => 'cookie',
                                    'value'  => $this->encryption->encrypt($vehicleNumber),
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
                                        'message' => 'Successfully Login'
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
                            if(!empty($chkPilotUserLogin) && !empty($chkEmtUserLogin)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The user/users are already logged into the ambulance('.$vehicleNumber.')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(!empty($chkPilotUserLogin)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The driver is already logged into this ambulance('.$vehicleNumber.')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(!empty($chkEmtUserLogin)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The paramedic is already logged into this ambulance('.$vehicleNumber.')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if((!empty($chkpilotLogin)) && (!empty($chkEmtLogin))){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The user/users are already logged into the ambulance('.$chkEmtLogin[0]['vehicle_no'].')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(!empty($chkAmbLogin)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The users are already logged into this ambulance('.$chkAmbLogin[0]['vehicle_no'].')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(!empty($chkEmtLogin)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The paramedic is already logged into this ambulance('.$chkEmtLogin[0]['vehicle_no'].')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else if(!empty($chkpilotLogin)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'The driver is already logged into this ambulance('.$chkpilotLogin[0]['vehicle_no'].')'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else{
                                if(($emtOtp[0]['clg_password'] == $password) || ($pilotOtp[0]['clg_password'] == $password)){
                                    $data = array(
                                        'otp' => '',
                                        'otp_expire_time' => '',
                                        'skipotp' => $skipotp,
                                        'otp_verification' => ''
                                    );
                                    $this->user->updateemtOtp($emtId,$data);
                                    $this->user->updatepilotOtp($pilotId,$data);
                                    $emtdata = array(
                                        'type_id' => $typeId,
                                        'vehicle_no' => $vehicleNumber,
                                        'clg_id' => $emtId,
                                        'login_time' => $current_time,
                                        'device_id' => $deviceId,
                                        'status' => 1,
                                        'login_type' => $emtLoginType
                                    );
                                    $this->user->insertLoginData($emtdata);
                                    $pilotdata = array(
                                        'type_id' => $typeId,
                                        'vehicle_no' => $vehicleNumber,
                                        'clg_id' => $pilotId,
                                        'login_time' => $current_time,
                                        'device_id' => $deviceId,
                                        'status' => 1,
                                        'login_type' => $pilotLoginType
                                    );
                                    $this->user->insertLoginData($pilotdata);
                                    $cookie = array(
                                        'name'   => 'cookie',
                                        'value'  => $this->encryption->encrypt($vehicleNumber),
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
                                            'message' => 'Successfully Login'
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
                            }
                            // if(!empty($pilot) && !empty($emt)){
                            //     $this->response([
                            //         'data' => null,
                            //         'error' => ([
                            //             'code' => 1,
                            //             'message' => 'Already user is login on these ambulance no ('.$pilot[0]['vehicle_no'].')'
                            //         ])
                            //     ],REST_Controller::HTTP_OK);
                            // }else if(!empty($pilot)){
                            //     $this->response([
                            //         'data' => null,
                            //         'error' => ([
                            //             'code' => 1,
                            //             'message' => 'Already Driver is login on ('.$pilot[0]['vehicle_no'].') ambulance no '
                            //         ])
                            //     ],REST_Controller::HTTP_OK);
                            // }else if(!empty($emt)){
                            //     $this->response([
                            //         'data' => null,
                            //         'error' => ([
                            //             'code' => 1,
                            //             'message' => 'Already Paramedic is login on ('.$emt[0]['vehicle_no'].') ambulance no '
                            //         ])
                            //     ],REST_Controller::HTTP_OK);
                            // }else{
                            //     if(($emtOtp[0]['clg_password'] == $password) || ($pilotOtp[0]['clg_password'] == $password)){
                            //         $data = array(
                            //             'otp' => '',
                            //             'otp_expire_time' => '',
                            //             'skipotp' => $skipotp,
                            //             'otp_verification' => ''
                            //         );
                            //         $this->user->updateemtOtp($emtId,$data);
                            //         $this->user->updatepilotOtp($pilotId,$data);
                            //         $emtdata = array(
                            //             'type_id' => $typeId,
                            //             'vehicle_no' => $vehicleNumber,
                            //             'clg_id' => $emtId,
                            //             'login_time' => $current_time,
                            //             'device_id' => $deviceId,
                            //             'status' => 1,
                            //             'login_type' => $emtLoginType
                            //         );
                            //         $this->user->insertLoginData($emtdata);
                            //         $pilotdata = array(
                            //             'type_id' => $typeId,
                            //             'vehicle_no' => $vehicleNumber,
                            //             'clg_id' => $pilotId,
                            //             'login_time' => $current_time,
                            //             'device_id' => $deviceId,
                            //             'status' => 1,
                            //             'login_type' => $pilotLoginType
                            //         );
                            //         $this->user->insertLoginData($pilotdata);
                            //         $cookie = array(
                            //             'name'   => 'cookie',
                            //             'value'  => $this->encryption->encrypt($vehicleNumber),
                            //             'expire' =>  172800,
                            //             'secure' => false,
                            //             'httponly' => true
                            //         );
                            //         $this->input->set_cookie($cookie);
                            //         $deviceIdCookie = array(
                            //             'name'   => 'deviceId',
                            //             'value'  => $this->encryption->encrypt($deviceId),
                            //             'expire' =>  172800,
                            //             'secure' => false,
                            //             'httponly' => true
                            //         );
                            //         $this->input->set_cookie($deviceIdCookie);
                            //         $this->response([
                            //             'data' => array(
                            //                 'message' => 'Successfully Login'
                            //             ),
                            //             'error' => null
                            //         ],REST_Controller::HTTP_OK);
                            //     }else{
                            //         $this->response([
                            //             'data' => null,
                            //             'error' => ([
                            //                 'code' => 4,
                            //                 'message' => 'Wrong Password'
                            //             ])
                            //         ],REST_Controller::HTTP_OK);
                            //     }
                            // }
                        }
                    }else{
                        $this->response([
                            'data' => ([]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }
        }else{
            if($typeId == 4)
			{
			    if(!empty($typeId) && !empty($userName)){
                    $checklogin['deviceid'] = $deviceId;
                    $checklogin['typeId'] = $typeId;
                    $checklogin['clg_id'] = $userdata;
                    $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($checklogin);
                    $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($checklogin);
                    $pilotLoginCheck = $this->user->checkBoth1($checklogin);
                    if($chkSameDeviceLogin == 1){
                        $data1['modified_time'] = date('Y-m-d H:i:s');
                        $this->user->updateLoginSession($data1,$checklogin);
                        $cookie = array(
                            'name'   => 'cookie',
                            'value'  => $this->encryption->encrypt($userdata),
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
                                 'userName'=>$userName,
                                'message' => 'Successfully Login'
                            ),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $otpExpireTime = $this->user->getuserOtp($userdata);
                        $current_time = date('Y-m-d H:i:s');
                        if($otpExpireTime[0]['otp_expire_time'] >= $current_time){
                            if($otpExpireTime[0]['otp'] == $otp){
                                    $data = array(
                                        'otp' => '',
                                        'otp_expire_time' => '',
                                        'otp_verification' => 2
                                    );
                                    $this->user->updateusertOtp($userdata,$data);
                                    $data1 = array(
                                        'type_id' => $typeId,
                                        'vehicle_no' => '',
                                        'clg_id' => $userdata,
                                        'login_time' => $current_time,
                                        'device_id' => $deviceId,
                                        'status' => 1,
                                        'login_type' => ''
                                    );
                                    $this->user->insertLoginData($data1); 
                                 
                                    $cookie = array(
                                        'name'   => 'cookie',
                                        'value'  => $this->encryption->encrypt($userdata),
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
                                             'userName'=>$userName,
                                            'message' => 'Successfully Login'
                                        ),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                            }else{
                                $id = $userdata;
                                $getcount = $this->user->getotpcount($id);
                                if($getcount == 3){
                                    $emptydata = array(
                                        'otp' => '',
                                        'otp_count' => 0
                                    );
                                    $this->user->emptydata($id,$emptydata);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 3,
                                            'message' => 'Too many attempts'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $count = $getcount + 1;
                                    $data = array(
                                        'otp_count' => $count
                                    );
                                    $this->user->insertOtpCount($data,$id);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'Invalid OTP'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                } 
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
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else if($typeId == 1){
                if(!empty($typeId) && !empty($pilotId)){
                    if($chkSameDeviceLogin == 1){
                        $data1['modified_time'] = date('Y-m-d H:i:s');
                        $this->user->updateLoginSession($data1,$check);
                        $cookie = array(
                            'name'   => 'cookie',
                            'value'  => $this->encryption->encrypt($pilotId),
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
                                'message' => 'Successfully Login'
                            ),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $otpExpireTime = $this->user->getPilotOtp($pilotId);
                        $current_time = date('Y-m-d H:i:s');
                        if($otpExpireTime[0]['otp_expire_time'] >= $current_time){
                            if($otpExpireTime[0]['otp'] == $otp){
                                    $data = array(
                                        'otp' => '',
                                        'otp_expire_time' => '',
                                        'otp_verification' => 2
                                    );
                                    $this->user->updatepilotOtp($pilotId,$data);
                                    $data1 = array(
                                        'type_id' => $typeId,
                                        'vehicle_no' => $vehicleNumber,
                                        'clg_id' => $pilotId,
                                        'login_time' => $current_time,
                                        'device_id' => $deviceId,
                                        'status' => 1,
                                        'login_type' => $pilotLoginType
                                    );
                                    $this->user->insertLoginData($data1); 
                                    // $cookieData = array(
                                    //     'type'   => $typeId,
                                    //     'ambno'  => $vehicleNumber,
                                    //     'pilotId' => $pilotId,
                                    //     'deviceId' => $deviceId
                                    // );
                                    // $this->session->set_userdata('cookie',$cookieData);
                                    $cookie = array(
                                        'name'   => 'cookie',
                                        'value'  => $this->encryption->encrypt($pilotId),
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
                                            'message' => 'Successfully Login'
                                        ),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                            }else{
                                $id = $pilotId;
                                $getcount = $this->user->getotpcount($id);
                                if($getcount == 3){
                                    $emptydata = array(
                                        'otp' => '',
                                        'otp_count' => 0
                                    );
                                    $this->user->emptydata($id,$emptydata);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 3,
                                            'message' => 'Too many attempts'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $count = $getcount + 1;
                                    $data = array(
                                        'otp_count' => $count
                                    );
                                    $this->user->insertOtpCount($data,$id);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'Invalid OTP'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                } 
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
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else if($typeId == 2){
                if(!empty($typeId) && !empty($emtId)){
                    if($chkSameDeviceLogin == 1){
                        $data1['modified_time'] = date('Y-m-d H:i:s');
                        $this->user->updateLoginSession($data1,$check);
                        $cookie = array(
                            'name'   => 'cookie',
                            'value'  => $this->encryption->encrypt($emtId),
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
                                'message' => 'Successfully Login'
                            ),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $otpExpireTime = $this->user->getEmtOtp($emtId);
                        $current_time = date('Y-m-d H:i:s');
                        if($otpExpireTime[0]['otp_expire_time'] >= $current_time){
                            if($otpExpireTime[0]['otp'] == $otp){
                                    $data = array(
                                        'otp' => '',
                                        'otp_expire_time' => '',
                                        'otp_verification' => 2
                                    );
                                    $this->user->updateemtOtp($emtId,$data);
                                    $data1 = array(
                                        'type_id' => $typeId,
                                        'vehicle_no' => $vehicleNumber,
                                        'clg_id' => $emtId,
                                        'login_time' => $current_time,
                                        'device_id' => $deviceId,
                                        'status' => 1,
                                        'login_type' => $emtLoginType
                                    );
                                    $this->user->insertLoginData($data1);
                                    // $cookieData = array(
                                    //     'type'   => $typeId,
                                    //     'ambno'  => $vehicleNumber,
                                    //     'emtId' => $emtId,
                                    //     'deviceId' => $deviceId
                                    // );
                                    // $this->session->set_userdata('cookie',$cookieData);
                                    $cookie = array(
                                        'name'   => 'cookie',
                                        'value'  => $this->encryption->encrypt($emtId),
                                        'secure' => false,
                                        'expire' =>  172800,
                                        'httponly' => true
                                    );
                                    $this->input->set_cookie($cookie);
                                    $deviceIdCookie = array(
                                        'name'   => 'deviceId',
                                        'value'  => $this->encryption->encrypt($deviceId),
                                        'secure' => false,
                                        'expire' =>  172800,
                                        'httponly' => true
                                    );
                                    $this->input->set_cookie($deviceIdCookie);
                                    $this->response([
                                        'data' => array(
                                            'message' => 'Successfully Login'
                                        ),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                            }else{
                                $id = $emtId;
                                $getcount = $this->user->getotpcount($id);
                                if($getcount == 3){
                                    $emptydata = array(
                                        'otp' => '',
                                        'otp_count' => 0
                                    );
                                    $this->user->emptydata($id,$emptydata);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 3,
                                            'message' => 'Too many attempts'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $count = $getcount + 1;
                                    $data = array(
                                        'otp_count' => $count
                                    );
                                    $this->user->insertOtpCount($data,$id);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'Invalid OTP'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                } 
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
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                if(!empty($typeId) && !empty($pilotId) && !empty($emtId)){
                    if($chkSameDeviceLogin == 1){
                        $data1['modified_time'] = date('Y-m-d H:i:s');
                        $this->user->updateLoginSession($data1,$check);
                        $cookie = array(
                            'name'   => 'cookie',
                            'value'  => $this->encryption->encrypt($vehicleNumber),
                            'secure' => false,
                            'expire' =>  172800,
                            'httponly' => true
                        );
                        $this->input->set_cookie($cookie);
                        $deviceIdCookie = array(
                            'name'   => 'deviceId',
                            'value'  => $this->encryption->encrypt($deviceId),
                            'secure' => false,
                            'expire' =>  172800,
                            'httponly' => true
                        );
                        $this->input->set_cookie($deviceIdCookie);
                        $this->response([
                            'data' => array(
                                'message' => 'Successfully Login'
                            ),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $emtOtp = $this->user->getEmtOtp($emtId);
                        $pilotOtp = $this->user->getPilotOtp($pilotId);
                        $current_time = date('Y-m-d H:i:s');
                        if(($emtOtp[0]['otp_expire_time'] >= $current_time) || ($pilotOtp[0]['otp_expire_time'] >= $current_time)){
                            if(($emtOtp[0]['otp'] == $otp) || ($pilotOtp[0]['otp'] == $otp)){
                                $data = array(
                                    'otp' => '',
                                    'otp_expire_time' => '',
                                    'otp_verification' => 2
                                );
                                $this->user->updateemtOtp($emtId,$data);
                                $this->user->updatepilotOtp($pilotId,$data);
                                $emtdata = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $emtId,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => $emtLoginType
                                );
                                $this->user->insertLoginData($emtdata);
                                $pilotdata = array(
                                    'type_id' => $typeId,
                                    'vehicle_no' => $vehicleNumber,
                                    'clg_id' => $pilotId,
                                    'login_time' => $current_time,
                                    'device_id' => $deviceId,
                                    'status' => 1,
                                    'login_type' => $pilotLoginType
                                );
                                $this->user->insertLoginData($pilotdata);
                                // $cookieData = array(
                                //     'type'   => $typeId,
                                //     'ambno'  => $vehicleNumber,
                                //     'emtId' => $emtId,
                                //     'pilotId' => $pilotId,
                                //     'deviceId' => $deviceId
                                // );
                                // $this->session->set_userdata('cookie',$cookieData);
                                $cookie = array(
                                    'name'   => 'cookie',
                                    'value'  => $this->encryption->encrypt($vehicleNumber),
                                    'secure' => false,
                                    'expire' =>  172800,
                                    'httponly' => true
                                );
                                $this->input->set_cookie($cookie);
                                $deviceIdCookie = array(
                                    'name'   => 'deviceId',
                                    'value'  => $this->encryption->encrypt($deviceId),
                                    'secure' => false,
                                    'expire' =>  172800,
                                    'httponly' => true
                                );
                                $this->input->set_cookie($deviceIdCookie);
                                $this->response([
                                    'data' => array(
                                        'message' => 'Successfully Login'
                                    ),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $id = $pilotId;
                                $emtId = $emtId;
                                $getcount = $this->user->getotpcount($id);
                                $getemtcount = $this->user->getemtotpcount($emtId);
                                if(($getcount == 3) && ($getemtcount == 3)){
                                    $emptydata = array(
                                        'otp' => '',
                                        'otp_count' => 0
                                    );
                                    $this->user->emptydata($id,$emptydata);
                                    $this->user->emptyemtdata($emtId,$emptydata);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 3,
                                            'message' => 'Too many attempts'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $count = $getcount + 1;
                                    $emtcount = $getemtcount + 1;
                                    $data = array(
                                        'otp_count' => $count
                                    );
                                    $emtdata = array(
                                        'otp_count' => $emtcount
                                    );
                                    $this->user->insertOtpCount($data,$id);
                                    $this->user->insertEmtOtpCount($emtdata,$emtId);
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'Invalid OTP'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                } 
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
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }
        }
    }
    public function check_get(){
        if(isset($_COOKIE['cookie'])){
            print_r($_COOKIE['cookie']);
        }else{
            print_r('no');
        }
    }
    public function key_post(){
        $plain_text = '1234567890';
        $ciphertext = $this->encryption->encrypt($plain_text);
        echo '<pre>';
        print_r($ciphertext);
        echo '</pre>';
        // Outputs: This is a plain-text message!
        echo $this->encryption->decrypt($ciphertext);
    }
    public function validateUser_post()
    {
		$type = $this->post('type');
		$userName = $this->post('userName');
	    $clgdata = $this->user->getClgid($userName);
		if(!empty($clgdata)){
        
            $this->response([
                'data' => null,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
		else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => 'Please enter validate username'
                ])
            ],REST_Controller::HTTP_OK);
	    } 
    }
    public function usercheckinout_post(){
        $checkInout = $this->post('checkInout');
        $checkInid = $this->post('checkInid');
        $type = $this->post('type');
        $usertype = $this->post('userType');
        $current_date = date('Y-m-d H:i:s');  
        $checkoutdateTime = $this->post('checkoutdateTime');
        if($checkoutdateTime=='')
        {
            $checkout_datetime = $checkoutdateTime;
        }
        else{
            $checkout_datetime = date('Y-m-d H:i:s'); 
        }
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        if($type==3){
            $data = $this->user->logindetails($id,$type,$usertype);
        }
        else{
            $usertype='';
            $data = $this->user->logindetails($id,$type,$usertype);
        }
        $amb_no= $data[0]['vehicle_no'];
        if(empty($amb_no))
        {
            $amb_no='';
        }
        if(!empty($data)){
            if($checkInout==1)
            {
                foreach($data as $data1){
                    $insertdata = array(
                        'clg_id' => $data1['clg_id'],
                        'amb_rto_reg_no'=>$amb_no,
                        'check_in' => $current_date,
                        'status'=>1
                        
                    );
                }
                // $instertedid= $this->user->checklastcheckout($insertdata,$id);  
            
                $instertedid= $this->user->insertattendance($insertdata);   
            }else{
                foreach($data as $data1){
                    $insertdata = array(
                        
                        'check_out' => $checkout_datetime,
                        'status'=>2
                        
                    );
                }
            $instertedid= $this->user->updatecheckout($insertdata,$checkInid);     
            }
            if(!empty($instertedid)){   
                if((isset($_COOKIE['cookie']))){
                    $this->response([
                        'data' => 
                            ([
                                'checkInid' => $instertedid
                            ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
                else{
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_UNAUTHORIZED);
                }
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Not inserted,please try again'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }
        else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }  
    } 

    public function getcheckinout_post(){
        $type = $this->post('type');
        $usertype = $this->post('userType');
        $current_date = date('Y-m-d H:i:s');  
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        $out_time = date('Y-m-d H:i:s', strtotime($current_date) - 60 * 60 * 1);
        if($type==3){
            $data = $this->user->logindetails($id,$type,$usertype);
            $clg_id= $data[0]['clg_id'];
            $checkoutdetails = $this->user->getcheckoutdetails($clg_id,$out_time);
            $checkindetails = $this->user->getcheckins($clg_id);
            if(!empty($checkindetails))
            {
                $checkinid= $checkindetails[0]['attendance_id'];
            }
            else
            {
                $checkinid= ''; 
            }
            if(!empty($checkoutdetails))
            {
                $details = array(
                    'checkInid' =>(int)$checkoutdetails[0]['attendance_id'] ,
                    'prevCheckOut'=>false
                    
                );                          
            }else{
                $details = array(
                    'checkInid' => $checkinid,
                    'prevCheckOut'=>true
                );
            }
        }else{
            $usertype='';
            $data = $this->user->logindetails($id,$type,$usertype);

            $checkoutdetails = $this->user->getcheckoutdetails($id,$out_time);
            $checkindetails = $this->user->getcheckins($id);
            if(!empty($checkindetails))
            {
                $checkinid= $checkindetails[0]['attendance_id'];
            }
            else
            {
                $checkinid= ''; 
            }
            if(!empty($checkoutdetails))
            {
                $details = array(
                    'checkInid' => (int) $checkoutdetails[0]['attendance_id'],
                    'prevCheckOut'=>false
                    
                );                         
            }else{
                $details = array(
                    'checkInid' => $checkinid,
                    'prevCheckOut'=>true
                );
            }
        }
        if((isset($_COOKIE['cookie']))){
                $this->response([
                'data' => $details,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
        else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function getattendacewise_post(){
        $type = $this->post('type');
        $vehicalNumber = $this->post('vehicleNumber');
        $current_date = date('Y-m-d H:i:s');  
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
    
        $logindetails = $this->user->getamblogindetails($vehicalNumber);
        $ambstatusdetails = $this->CommonModel->getAmbulanceStatus($vehicalNumber);
        if(!empty($ambstatusdetails)){
            $ambcurrentstatus=$ambstatusdetails[0]['amb_status'];
            //print_r($ambcurrentstatus);
            $ambcurrentstatusdetails = $this->user->getcurrentAmbStatus($ambcurrentstatus);     
            //$ambstatus=$ambcurrentstatusdetails[0]['ambs_name'];
            $ambstatus="Available";
        }else{
             $ambstatus="";
        }
        if(!empty($logindetails)){
            foreach($logindetails as $logindata1){
                if(count($logindetails)==1){
                    if($logindata1['login_type'] == 'P'){
                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                        $pilot_id = $logindata1['clg_ref_id'];
                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                        $emt_name = "";
                        $emso_id = "";
                        // $epcr['amb_reg_id'] = "";
                    }else{
                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                        $emso_id = $logindata1['clg_ref_id'];
                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                        $pilot_name = "";
                        $pilot_id = "";
                        // $epcr['amb_reg_id'] = "";
                    }
                }else{
                    if($logindata1['login_type'] == 'P'){
                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                        $pilot_id = $logindata1['clg_ref_id'];
                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                    }else{
                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                        $emso_id = $logindata1['clg_ref_id'];
                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                    }
                }
            }
            $loginuser = array(
                'emtname' => $emt_name,
                'pilotname'=>$pilot_name,
                'ambstatus'=>$ambstatus
            );
            if((isset($_COOKIE['cookie']))){
                    $this->response([
                    'data' => $loginuser,
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_UNAUTHORIZED);
            }  
        }else{
            $loginuser = null;
            if((isset($_COOKIE['cookie']))){
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'No one is logged into ambulance'
                    ])
                ],REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }
    } 
}