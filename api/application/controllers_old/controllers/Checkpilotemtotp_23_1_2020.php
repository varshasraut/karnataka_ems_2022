<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Checkpilotemtotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $typeId = $this->post('type');
        $pilotId = $this->post('pilotId');
        $emtId = $this->post('emtId');
        $otp = $this->post('otp');
        $deviceId = $this->post('deviceId');
        $vehicleNumber = $this->post('vehicleNumber');
        $emtLoginType = $this->post('emtLoginType');
        $pilotLoginType = $this->post('pilotLoginType');
        $password = $this->post('password');
        $skipotp = $this->post('skipotp');

        $check['typeId'] = $typeId;
        $check['pilotId'] = $pilotId;
        $check['emtId'] = $emtId;
        $check['deviceid'] = $deviceId;
        $check['vehicleNumber'] = $vehicleNumber;
        $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($check);
        // print_r($chkAnotherDeviceLogin);die;
        // die;

        //$plain_text = '1234567890';
        if($skipotp == 'true'){
            if($typeId == 1){
                if(!empty($typeId) && !empty($pilotId)){
                    $pilotLoginCheck = $this->user->checkBoth1($check);
                    $otpExpireTime = $this->user->getPilotOtp($pilotId);
                    if($chkAnotherDeviceLogin == 1){
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
                        if(!empty($pilotLoginCheck)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Already User is login on ('.$pilotLoginCheck[0]['vehicle_no'].') ambulance no '
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
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
                    if($chkAnotherDeviceLogin == 1){
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
                        if(!empty($pilotLoginCheck)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Already User is login on ('.$pilotLoginCheck[0]['vehicle_no'].') ambulance no '
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
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
                    $emtOtp = $this->user->getEmtOtp($emtId);
                    $pilotOtp = $this->user->getPilotOtp($pilotId);
                    $current_time = date('Y-m-d H:i:s');
                    $pilot = $this->user->checkPilot($check);
                    $emt = $this->user->checkEmt($check);
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
                        if(!empty($pilot) && !empty($emt)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Already user is login on these ambulance no ('.$pilot[0]['vehicle_no'].')'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if(!empty($pilot)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Already Driver is login on ('.$pilot[0]['vehicle_no'].') ambulance no '
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else if(!empty($emt)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Already Paramedic is login on ('.$emt[0]['vehicle_no'].') ambulance no '
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
                    }
                }else{
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }
        }else{
            if($typeId == 1){
                if(!empty($typeId) && !empty($pilotId)){
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
                }else{
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else if($typeId == 2){
                if(!empty($typeId) && !empty($emtId)){
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
                }else{
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                if(!empty($typeId) && !empty($pilotId) && !empty($emtId)){
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
}