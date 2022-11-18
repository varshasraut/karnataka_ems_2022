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
        $isGovtAmbulance = $this->post('isGovtAmbulance');
        $pilotMobNo = $this->post('pilotMobNo');
        $pilotPass = $this->post('pilotPass');
        $emtMobNo = $this->post('emtMobNo');
        $emtPass = $this->post('emtPass');
        $deviceId = $this->post('deviceId');
        $vehicleNumber = $this->post('vehicleNumber');
        // $password = $this->post('password');
        $pilotLoginType = $this->post('pilotLoginType');
        $emtLoginType = $this->post('emtLoginType');
        $skipotp = 'true';
        //$skipotp = $this->post('skipotp');
        // echo $pilotMobNo;
        if(!empty($pilotMobNo)){
            $userdata = $this->user->getClgdetails($pilotMobNo);
        }
        if(!empty($emtMobNo)){
            $userdata1 = $this->user->getemtdetails($emtMobNo);
        }
        $check['typeId'] = $typeId;
        $check['deviceid'] = $deviceId;
        $check['vehicleNumber'] = $vehicleNumber;
        if(!empty($userdata) && empty($userdata1) && $typeId==1){
            $pilotId = $userdata[0]['clg_id'];
            $check['pilotId'] = $userdata[0]['clg_id'];
            $pilotName = "Pilot - ".$userdata[0]['clg_first_name']." ". $userdata[0]['clg_mid_name']." " .$userdata[0]['clg_last_name'];
            $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($check);
            $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($check);
        }else if(!empty($userdata1) && empty($userdata) && $typeId==2){
            $emtId = $userdata1[0]['clg_id'];
            $check['emtId'] = $userdata1[0]['clg_id'];
            $emtName = "EMSO - ".$userdata1[0]['clg_first_name']." ". $userdata1[0]['clg_mid_name']." " .$userdata1[0]['clg_last_name'];
            $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($check);
            $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($check);
        }else if(!empty($userdata) && !empty($userdata1)){
            $pilotId = $userdata[0]['clg_id'];
            $check['pilotId'] = $userdata[0]['clg_id'];
            $pilotName = "Pilot - ".$userdata[0]['clg_first_name']." ". $userdata[0]['clg_mid_name']." " .$userdata[0]['clg_last_name'];
            $emtId = $userdata1[0]['clg_id'];
            $check['emtId'] = $userdata1[0]['clg_id'];
            $emtName = "EMSO - ".$userdata1[0]['clg_first_name']." ". $userdata1[0]['clg_mid_name']." " .$userdata1[0]['clg_last_name'];
            $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($check);
                $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($check);
        }
        if($isGovtAmbulance == false){
            if(!empty($userdata)){ 
                    $clg_id=$userdata[0]['clg_id'];
                    $userName="Pilot - ".$userdata[0]['clg_first_name']." ". $userdata[0]['clg_mid_name']." " .$userdata[0]['clg_last_name'];
                
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
                        if($userdata[0]['clg_password'] != $pilotPass){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 4,
                                    'message' => 'Wrong Password'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                            if($userdata[0]['clg_password'] == $pilotPass){
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
        }else if($isGovtAmbulance == true){
            
            if($typeId == 1){
                if(!empty($userdata)){
                    if(count($userdata) == 1 ){
                        if(!empty($typeId) && !empty($pilotMobNo)){
                            $pilotLoginCheck = $this->user->checkBoth1($check);
                            if(!empty($pilotLoginCheck)){
                                $loginUser = $this->user->getUserLoginAsPerUser($pilotLoginCheck);
                                // print_r($loginUser);die;
                            }
                            // print_r($pilotLoginCheck);die;
                            $otpExpireTime = $this->user->getPilotOtp($pilotId);
                            if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                                if($otpExpireTime[0]['clg_password'] == $pilotPass){
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
                                            'userName'=> $pilotName,
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
                                            'userName'=> $pilotName,
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
                                                'userName'=> $pilotName,
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
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 110,
                                'message' => 'Your mobile number is register with multiple accounts please contact to the operation desk'
                            ])
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
            
            }else if($typeId == 2){
                if(!empty($userdata1)){
                    if(count($userdata1) == 1 ){
                        if(!empty($typeId) && !empty($emtId)){
                            $otpExpireTime = $this->user->getPilotOtp($emtId);
                            $pilotLoginCheck = $this->user->checkBoth1($check);
                            // print_r($pilotLoginCheck);die;
                            if(!empty($pilotLoginCheck)){
                                $loginUser = $this->user->getUserLoginAsPerUser($pilotLoginCheck);
                                // print_r($loginUser);die;
                            }
                            // print_r($pilotLoginCheck);die;
                            if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                                if($otpExpireTime[0]['clg_password'] == $emtPass){
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
                                            'userName'=> $emtName,
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
                                            'userName'=> $emtName,
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
                                                'userName'=> $emtName,
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
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 110,
                                'message' => 'Your mobile number is register with multiple accounts please contact to the operation desk'
                            ])
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
            
            }else{
                if(!empty($userdata) && !empty($userdata1)){
                    if(count($userdata)==1 && count($userdata1)==1){
                        $loginEmp = $pilotName.', '.$emtName;
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
                                    'userName'=> $loginEmp,
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
                                    if(($emtOtp[0]['clg_password'] == $emtPass) && ($pilotOtp[0]['clg_password'] == $pilotPass)){
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
                                                'userName'=> $loginEmp,
                                                'message' => 'Successfully Login'
                                            ),
                                            'error' => null
                                        ],REST_Controller::HTTP_OK);
                                    }else if($pilotOtp[0]['clg_password'] == $pilotPass){
                                        $this->response([
                                            'data' => null,
                                            'error' => ([
                                                'code' => 4,
                                                'message' => 'Pilot Wrong Password'
                                            ])
                                        ],REST_Controller::HTTP_OK);
                                    }else if($emtOtp[0]['clg_password'] == $emtPass){
                                        $this->response([
                                            'data' => null,
                                            'error' => ([
                                                'code' => 4,
                                                'message' => 'EMT Wrong Password'
                                            ])
                                        ],REST_Controller::HTTP_OK);
                                    }else{
                                        $this->response([
                                            'data' => null,
                                            'error' => ([
                                                'code' => 4,
                                                'message' => 'Pilot And EMT Wrong Password'
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
                                        if(($emtOtp[0]['clg_password'] == $emtPass) && ($pilotOtp[0]['clg_password'] == $pilotPass)){
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
                                                    'userName'=> $loginEmp,
                                                    'message' => 'Successfully Login'
                                                ),
                                                'error' => null
                                            ],REST_Controller::HTTP_OK);
                                        }else if($pilotOtp[0]['clg_password'] == $pilotPass){
                                            $this->response([
                                                'data' => null,
                                                'error' => ([
                                                    'code' => 4,
                                                    'message' => 'Pilot Wrong Password'
                                                ])
                                            ],REST_Controller::HTTP_OK);
                                        }else if($emtOtp[0]['clg_password'] == $emtPass){
                                            $this->response([
                                                'data' => null,
                                                'error' => ([
                                                    'code' => 4,
                                                    'message' => 'EMT Wrong Password'
                                                ])
                                            ],REST_Controller::HTTP_OK);
                                        }else{
                                            $this->response([
                                                'data' => null,
                                                'error' => ([
                                                    'code' => 4,
                                                    'message' => 'Pilot And EMT Wrong Password'
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
                        }
                    }else{
                        if(count($userdata)>1){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 110,
                                    'message' => 'Pilot your mobile number is register with multiple accounts please contact to the operation desk'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if(count($userdata1)>1){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 110,
                                    'message' => 'Emt your mobile number is register with multiple accounts please contact to the operation desk'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 110,
                                    'message' => 'Pilot and Emt your mobile number is register with multiple accounts please contact to the operation desk'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    if(empty($userdata)){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 5,
                                'message' => 'Pilot wrong mobile number'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if(empty($userdata1 == '')){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 5,
                                'message' => 'Emt wrong mobile number'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if(empty($userdata) && empty($userdata1 == '')){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 5,
                                'message' => 'Pilot and Emt wrong mobile number'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }
        }
    }
}