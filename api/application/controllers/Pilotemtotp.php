<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Pilotemtotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('user','CommonModel'));
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){

       
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        $pilotMobile = $this->post('pilotMobile');
        $emtMobile = $this->post('emtMobile');
        $userName = $this->post('userName');
        $pilotRec = $this->CommonModel->get_pilot_id_as_per_mobile_no($pilotMobile);
        $emtIdRec = $this->CommonModel->get_emt_id_as_per_mobile_no($emtMobile);
       
        // $pilotLoginCheck = $this->user->checkBoth1($data);
        if( (!empty($pilotRec) && ($typeId == '1')) || (!empty($emtIdRec) && ($typeId == '2')) || ($typeId == '3' && !empty($pilotRec) && !empty($emtIdRec)) || (!empty($userName))){
           
            if(!empty($pilotRec)){
                $data['pilotId'] = $pilotRec[0]['clg_id'];
                $pilotId = $pilotRec[0]['clg_id'];
            }
            if(!empty($emtIdRec)){
                $data['emtId'] = $emtIdRec[0]['clg_id'];
                $emtId = $emtIdRec[0]['clg_id'];
            }
            if($typeId == 1 || $typeId == 2 || $typeId == 3){
                $data['vehicleNumber'] = $vehicleNumber;
                $data['typeId'] = $typeId;
                $data['deviceid'] = $this->post('deviceId');
                $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($data);
                $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($data);
                $checklogin['deviceid'] = $data['deviceid'];
                $checklogin['typeId'] = $typeId;
                $checklogin['vehicleNumber'] = $vehicleNumber;
            }
             
            if($typeId == 1){
                $checklogin['pilotId'] = $pilotId;
                //  echo 'll';die;
                $pilotLoginCheck = $this->user->checkBoth1($checklogin);
                if(!empty($pilotLoginCheck)){
                    $loginUser = $this->user->getUserLoginAsPerUser($pilotLoginCheck);
                }
                // print_r($chkSameDeviceLogin);
                // die;
                
                if( $chkSameDeviceLogin == 1){
                    // $emtMobNo = $this->user->getEmtMobNo($pilotId);
                    // echo $emtMobile;die;
                    // var_dump('hi');die();
                    if(isset($pilotMobile)){
                        // echo 'll';die;
                        $otp = rand(1000, 9999);
                        $txtMsg='';
                        $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                        $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                        $txtMsg .=  "JAES";
                        $text_msg = urlencode($txtMsg);
                        $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$pilotMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                        $data_to_post = array();
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $form_url);
                        curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                        curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                        $result = curl_exec($curl);
                        curl_close($curl);
        
                        $current_time = date('Y-m-d H:i:s');
                        $OTP_timestamp = strtotime($current_time) + 20*60;
                        
                        $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                        // echo $otp_expiry_time;die;
                        $data = array(
                                    'otp' => $otp,
                                    'otp_expire_time' =>  $otp_expiry_time
                                );
                                // print_r($data);
                                // print_r($pilotId);die;
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
                                'message' => 'Mobile Number Does Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                        // echo 'kk';
                        //$emtMobNo = $this->user->getEmtMobNo($pilotId);
                        if(isset($pilotMobile)){
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$pilotMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
                            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                            $data = array(
                                        'otp' => $otp,
                                        'otp_expire_time' =>  $otp_expiry_time
                                    );
                            $this->user->insertPilotOtp($data,$pilotId);
                            $this->response([
                                'data' => ([
                                    'type' => $typeId,
                                    'otp' => $otp,
                                    'otherDevice' => 1,
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
                        // print_r($chkSameDeviceLogin);die;
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
                        }else{
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$pilotMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
            
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
                            
                            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                            // echo $otp_expiry_time;die;
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
                        }
                    }
                }
            }else if($typeId == 2){
                $pilotLoginCheck = $this->user->checkBoth1($data);
                if($chkSameDeviceLogin == 1){
                    // $emtMobNo = $this->user->getEmtMobNo($emtId);
                    if(!empty($emtMobile)){
                        $otp = rand(1000, 9999);
                        $txtMsg='';
                        $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                        $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                        $txtMsg .=  "JAES";
                        $text_msg = urlencode($txtMsg);
                        $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$emtMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                        $data_to_post = array();
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $form_url);
                        curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                        curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                        $result = curl_exec($curl);
                        curl_close($curl);
        
                        $current_time = date('Y-m-d H:i:s');
                        $OTP_timestamp = strtotime($current_time) + 20*60;
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
                                'message' => 'Mobile Number Does Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    if($chkAnotherDeviceLogin == 1 || empty($pilotLoginCheck)){
                        // $emtMobNo = $this->user->getEmtMobNo($emtId);
                        if(!empty($emtMobile)){
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$emtMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
                            
            
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
                            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                            $data = array(
                                        'otp' => $otp,
                                        'otp_expire_time' =>  $otp_expiry_time
                                    );
                            $this->user->insertEmtOtp($data,$emtId);
                            $this->response([
                                'data' => ([
                                    'type' => $typeId,
                                    'otp' => $otp,
                                    'otherDevice' => 1,
                                ]),
                                'error' => null
                            ], REST_Controller::HTTP_OK);
                        }else{
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 2,
                                    'message' => 'Mobile Number Does Not Exist'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
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
                        }else{
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$emtMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
            
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
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
                        }
                    }
                }
            }else if($typeId == 3){
                if(empty($pilotRec) || empty($emtIdRec)){
                    if(!empty($pilotId) && !empty($emtId)){
                        $user = 'Both';
                    }else if(!empty($pilotId)){
                        $user = 'Pilot';
                    }else if(!empty($emtId)){
                        $user = 'EMSO';
                    }
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => $user.' Mobile Number Does Not Exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    if($chkSameDeviceLogin == 1){
                        // $pilotMobNo = $this->user->getPilotMobNo($pilotId);
                        // $emtMobNo = $this->user->getEmtMobNo($emtId);
                        // print_r($pilot);
                        // print_r($emt);die;
                        if(!empty($pilotMobile) || !empty($emtMobile)){
                            //start pilot
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$pilotMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
            
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
                            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                            $data = array(
                                        'otp' => $otp,
                                        'otp_expire_time' =>  $otp_expiry_time
                                    );
                            $this->user->insertPilotOtp($data,$pilotId);
                            //end start pilot
                            //start emso
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$emtMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
            
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
                            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                            $data = array(
                                        'otp' => $otp,
                                        'otp_expire_time' =>  $otp_expiry_time
                                    );
                            $this->user->insertEmtOtp($data,$emtId);
                            //end start emso
                            $bothotp = $pilototp.','.$emtotp;
                            $this->response([
                                'data' => ([
                                    'type' => $typeId,
                                    'otp' => $bothotp,
                                    'otherDevice' => 1,
                                ]),
                                'error' => null
                            ], REST_Controller::HTTP_OK);
                        }else{
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 2,
                                    'message' => 'Mobile Number Does Not Exist'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }else{
                        // print_r('ggg');
                        $chkPilotUserLogin = $this->user->chkPilotUserLogin($data);
                        $chkEmtUserLogin = $this->user->chkEmtUserLogin($data);
                        $chkAmbLogin = $this->user->chkAmbLogin($data);
                        $chkpilotLogin = $this->user->chkpilotLogin($data);
                        $chkEmtLogin = $this->user->chkEmtLogin($data);
                        // print_r($chkEmtLogin);
                        if($chkAnotherDeviceLogin == 1){
                        //start pilot
                        $otp = rand(1000, 9999);
                        $pilototp = $otp;
                        $txtMsg='';
                        $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                        $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                        $txtMsg .=  "JAES";
                        $text_msg = urlencode($txtMsg);
                        $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$pilotMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                        $data_to_post = array();
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $form_url);
                        curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                        curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                        $result = curl_exec($curl);
                        curl_close($curl);
        
                        $current_time = date('Y-m-d H:i:s');
                        $OTP_timestamp = strtotime($current_time) + 20*60;
                        $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                        $data = array(
                                    'otp' => $otp,
                                    'otp_expire_time' =>  $otp_expiry_time
                                );
                        $this->user->insertPilotOtp($data,$pilotId);
                        //end start pilot
                        //start emso
                        $otp = rand(1000, 9999);
                        $emtotp = $otp;
                        $txtMsg='';
                        $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                        $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                        $txtMsg .=  "JAES";
                        $text_msg = urlencode($txtMsg);
                        $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$emtMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                        $data_to_post = array();
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $form_url);
                        curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                        curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                        curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                        $result = curl_exec($curl);
                        curl_close($curl);
        
                        $current_time = date('Y-m-d H:i:s');
                        $OTP_timestamp = strtotime($current_time) + 20*60;
                        $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                        $data = array(
                                    'otp' => $otp,
                                    'otp_expire_time' =>  $otp_expiry_time
                                );
                        $this->user->insertEmtOtp($data,$emtId);
                        //end start emso
                        $bothotp = $pilototp.','.$emtotp;
                            $this->response([
                                'data' => ([
                                    'type' => $typeId,
                                    'otp' => $bothotp
                                ]),
                                'error' => null
                            ], REST_Controller::HTTP_OK);
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
                                //start pilot
                                $otp = rand(1000, 9999);
                                $pilototp = $otp;
                                $txtMsg='';
                                $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                                $txtMsg .=  "JAES";
                                $text_msg = urlencode($txtMsg);
                                $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$pilotMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                                $data_to_post = array();
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, $form_url);
                                curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                                curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                                curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                                $result = curl_exec($curl);
                                curl_close($curl);
                
                                $current_time = date('Y-m-d H:i:s');
                                $OTP_timestamp = strtotime($current_time) + 20*60;
                                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                                $data = array(
                                            'otp' => $otp,
                                            'otp_expire_time' =>  $otp_expiry_time
                                        );
                                $this->user->insertPilotOtp($data,$pilotId);
                                //end start pilot
                                //start emso
                                $otp = rand(1000, 9999);
                                $emtotp = $otp;
                                $txtMsg='';
                                $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                                $txtMsg .=  "JAES";
                                $text_msg = urlencode($txtMsg);
                                $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$emtMobile&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                                $data_to_post = array();
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, $form_url);
                                curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                                curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                                curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                                $result = curl_exec($curl);
                                curl_close($curl);
                
                                $current_time = date('Y-m-d H:i:s');
                                $OTP_timestamp = strtotime($current_time) + 20*60;
                                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                                $data = array(
                                            'otp' => $otp,
                                            'otp_expire_time' =>  $otp_expiry_time
                                        );
                                $this->user->insertEmtOtp($data,$emtId);
                                $bothotp = $pilototp.','.$emtotp;
                                //end start emso
                                    $this->response([
                                        'data' => ([
                                            'type' => $typeId,
                                            'otp' => $bothotp
                                        ]),
                                        'error' => null
                                    ], REST_Controller::HTTP_OK);
                            }
                        }
                    }
                }
                
            }else{
                $clg_id = $this->user->getClgid($userName);
                if(($clg_id) == 0){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'Username Do Not Exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $data['clg_id'] = $clg_id;
                    $data['typeId'] = $typeId;
                    $data['deviceid'] = $this->post('deviceId');
                    $chkAnotherDeviceLogin = $this->user->chkAnotherDeviceLogin($data);
                    $chkSameDeviceLogin = $this->user->chkSameDeviceLogin($data);
                    $userLoginCheck = $this->user->checkBoth1($data);
                    if($chkAnotherDeviceLogin == 1 || empty($userLoginCheck)){
                        $clgmobno = $this->user->getclgMobNo($clg_id);
                        if(isset($clgmobno)){
                            $otp = rand(1000, 9999);
                            $txtMsg='';
                            $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                            $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                            $txtMsg .=  "JAES";
                            $text_msg = urlencode($txtMsg);
                            $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$clgmobno&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                            $data_to_post = array();
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $form_url);
                            curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                            curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                            curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                            $result = curl_exec($curl);
                            curl_close($curl);
            
                            $current_time = date('Y-m-d H:i:s');
                            $OTP_timestamp = strtotime($current_time) + 20*60;
                            $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                            $data = array(
                                        'otp' => $otp,
                                        'otp_expire_time' =>  $otp_expiry_time
                                    );
                            $this->user->insertPilotOtp($data,$clg_id);
                            $this->response([
                                'data' => ([
                                    'type' => $typeId,
                                    'otp' => $otp,
                                    'otherDevice' => 1,
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
                    }else{
                        if($chkSameDeviceLogin == 1){
                            if(isset($clgmobno)){
                                $otp = rand(1000, 9999);
                                $txtMsg='';
                                $txtMsg .=  "OTP for your login is:".$otp.""." \n";
                                $txtMsg .=  "OTP is valid for 15 Minutes"." \n";
                                $txtMsg .=  "JAES";
                                $text_msg = urlencode($txtMsg);
                                $form_url = "http://hindit.biz/api/pushsms?user=jaes&authkey=92zRsmUQr4uUs&sender=JAESPL&mobile=$clgmobno&text=$text_msg&entityid=1701164198802150041&templateid=1707165797181147210&rpt=1&summary=1&output=json";
                                $data_to_post = array();
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, $form_url);
                                curl_setopt($curl, CURLOPT_POST, sizeof($data_to_post));
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post);
                                curl_setopt( $curl, CURLOPT_TIMEOUT, 2 );
                                curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 2 );
                                $result = curl_exec($curl);
                                curl_close($curl);
                
                                $current_time = date('Y-m-d H:i:s');
                                $OTP_timestamp = strtotime($current_time) + 20*60;
                                $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                                $data = array(
                                            'otp' => $otp,
                                            'otp_expire_time' =>  $otp_expiry_time
                                        );
                                $this->user->insertPilotOtp($data,$clg_id);
                                $this->response([
                                    'data' => ([
                                        'type' => $typeId,
                                        'otp' => $otp,
                                        'otherDevice' => 1,
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
                        }else{
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'The user/users are already logged onto another app('.$userLoginCheck[0]['device_id'].')'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }
            }
        }else{
            if($typeId == 1){
                $user = 'Pilot';
            }else if($typeId == 2){
                $user = 'EMSO';
            }else{
                if(empty($pilotId) && empty($emtId)){
                    $user = 'Both';
                }else if(empty($pilotId)){
                    $user = 'Pilot';
                }else if(empty($emtId)){
                    $user = 'EMSO';
                }
            }
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 2,
                    'message' => $user.' Mobile Number Does Not Exist'
                ])
            ],REST_Controller::HTTP_OK);
        }
        die;


        
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
                        $OTP_timestamp = strtotime($current_time) + 20*60;
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
                                'message' => 'Mobile Number Does Not Exist'
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
                        $OTP_timestamp = strtotime($current_time) + 20*60;
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
                                'message' => 'Mobile Number Does Not Exist'
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
                        $OTP_timestamp = strtotime($current_time) + 20*60;
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
                                'message' => 'Mobile Number Does Not Exist'
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