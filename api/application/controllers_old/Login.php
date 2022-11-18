<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Login extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->library('session');
        $this->load->helper(array('cookie','url'));
    }
    public function login_post() {
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        if(!empty($typeId) && !empty($vehicleNumber)){
            $checkLogin = $this->user->checkLogin($vehicleNumber);
            if(empty($checkLogin)){
                $mobileNo = $this->user->getVehicleData($vehicleNumber);
                if($mobileNo){
                    $otp = rand(1000, 9999);
                    // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                    $txtMsg='';
                    $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                    
                    $data_to_post = array();
                    $data_to_post['uname'] = 'bvgmems';
                    $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                    $data_to_post['send'] = 'SperocHL';
                    $data_to_post['dest'] = $mobileNo; 
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
                    $this->user->insertVehicleOtp($data,$vehicleNumber);
                    $this->response([
                        'Data' => ([
                            'role' => $typeId,
                            'otp' => $otp
                        ]),
                        'error' => null
                    ], REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Mobile Number Do Not Exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                if($checkLogin == 2){
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'message' => 'Already Login this ambulance number'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else if(($checkLogin[0]['type_id'] == 1) && ($typeId == 1)){
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'type' => 1,
                            'message' => 'Already Driver is Login this ambulance number'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else if(($checkLogin[0]['type_id'] == 2) && ($typeId == 2)){
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'type' => 2,
                            'message' => 'Already Pilot is Login this ambulance number'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $mobileNo = $this->user->getVehicleData($vehicleNumber);
                    if($mobileNo){
                        $otp = rand(1000, 9999);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        $txtMsg='';
                        $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        $data_to_post = array();
                        $data_to_post['uname'] = 'bvgmems';
                        $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        $data_to_post['send'] = 'SperocHL';
                        $data_to_post['dest'] = $mobileNo; 
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
                        $this->user->insertVehicleOtp($data,$vehicleNumber);
                        $this->response([
                            'Data' => ([
                                'role' => $typeId,
                                'otp' => $otp
                            ]),
                            'error' => null
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }
        }else{
            $this->response([
                'Data' => null,
                'error' => ([
                    'message' => 'Provide Type & VehicleNumber'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
    public function vehicleotpcheck_post(){
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        $otp = $this->post('otp');
        if((!empty($typeId)) && (!empty($vehicleNumber)) && (!empty($otp))){
            $otpExpireTime = $this->user->getOtp($vehicleNumber);
            $current_time = date('Y-m-d H:i:s');
            if($otpExpireTime[0]['otp_expire_time'] >= $current_time){
                if($otpExpireTime[0]['otp'] == $otp){
                    if($typeId == 1){
                        $Pilotlist = $this->user->getPilot($vehicleNumber);
                        $data = array(
                            'otp' => '',
                            'otp_verification' => 2
                        );
                        $this->user->updateOtp($vehicleNumber,$data);
                        $this->response([
                            'Data' => $Pilotlist,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else if($typeId == 2){
                        $Emtlist = $this->user->getEmt($vehicleNumber);
                        $data = array(
                            'otp' => '',
                            'otp_verification' => 2
                        );
                        $this->user->updateOtp($vehicleNumber,$data);
                        $this->response([
                            'Data' => $Emtlist,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $Pilotlist = $this->user->getPilot($vehicleNumber);
                        $Emtlist = $this->user->getEmt($vehicleNumber);
                        $data = array(
                            'otp' => '',
                            'otp_verification' => 2
                        );
                        $this->user->updateOtp($vehicleNumber,$data);
                        $this->response([
                            'Data' => ([
                                'pilot' => $Pilotlist,
                                'emt' => $Emtlist
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Invalid OTP'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'Data' => null,
                    'error' => ([
                        'code' => 2,
                        'message' => 'OTP expired'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'Data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function pilotemtotp_post(){
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        $pilotId = $this->post('pilotId');
        $emtId = $this->post('emtId');
        
        if($typeId == 1){
            if(!empty($vehicleNumber) && !empty($pilotId)){
                // $checkPilotLogin = $this->user->loginCheckPilotEmt($vehicleNumber,$typeId);
                $checkPilotLogin = $this->user->checkBoth($vehicleNumber);
                // print_r($checkPilotLogin);
                if($checkPilotLogin == 2){
                    $this->response([
                        'Data' => null,
                        'error' => ([
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Pilot is already login so please do the emt login'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                        // else if($pilot == 2){
                        //     $this->response([
                        //         'Data' => null,
                        //         'error' => ([
                        //             'code' => 1,
                        //             'message' => 'EMT is already login so please anyone pilot login'
                        //         ])
                        //     ],REST_Controller::HTTP_OK);
                        // }
                    }
                    $emtMobNo = $this->user->getEmtMobNo($pilotId);
                    // print_r($emtMobNo);
                    if($emtMobNo){
                        $otp = rand(1000, 9999);
                        print_r($otp);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        $txtMsg='';
                        $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        $data_to_post = array();
                        $data_to_post['uname'] = 'bvgmems';
                        $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        $data_to_post['send'] = 'SperocHL';
                        $data_to_post['dest'] = $emtMobNo; 
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
                            'Data' => ([
                                'role' => $typeId,
                                'otp' => $otp
                            ]),
                            'error' => null
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
                // if($checkPilotLogin == 1){
                //     $this->response([
                //         'Data' => null,
                //         'error' => ([
                //             'code' => 1,
                //             'message' => 'Already another user is login'
                //         ])
                //     ],REST_Controller::HTTP_OK);
                // }else{
                //     $pilotMobNo = $this->user->getPilotMobNo($pilotId);
                //     // print_r($pilotMobNo);die;
                //     if($pilotMobNo){
                //         $otp = rand(1000, 9999);
                //         // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                //         $txtMsg='';
                //         $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                //         $data_to_post = array();
                //         $data_to_post['uname'] = 'bvgmems';
                //         $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                //         $data_to_post['send'] = 'SperocHL';
                //         $data_to_post['dest'] = $pilotMobNo; 
                //         $data_to_post['msg'] = $txtMsg;
                        
                //         $curl = curl_init();
                //         curl_setopt($curl,CURLOPT_URL, $form_url);
                //         curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                //         curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                //         $result = curl_exec($curl);
                //         curl_close($curl);
        
                //         $current_time = date('Y-m-d H:i:s');
                //         $OTP_timestamp = strtotime($current_time) + 30*60;
                //         $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                //         $data = array(
                //                     'otp' => $otp,
                //                     'otp_expire_time' =>  $otp_expiry_time
                //                 );
                //         $this->user->insertPilotOtp($data,$pilotId);
                //         $this->response([
                //             'Data' => ([
                //                 'role' => $typeId,
                //                 'otp' => $otp
                //             ]),
                //             'error' => null
                //         ], REST_Controller::HTTP_OK);
                //     }else{
                //         $this->response([
                //             'Data' => null,
                //             'error' => ([
                //                 'code' => 1,
                //                 'message' => 'Mobile Number Do Not Exist'
                //             ])
                //         ],REST_Controller::HTTP_OK);
                //     }
                // }
            }else{
                $this->response([
                    'Data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else if($typeId == 2 ){
            // print_r('2');
            if(!empty($vehicleNumber) && !empty($emtId)){
                $checkPilotLogin = $this->user->checkBoth($vehicleNumber);
                if($checkPilotLogin == 2){
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Already another user is login'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $pilot = $checkPilotLogin[0]['type_id'];
                    // if($pilot == 1){
                    //     $this->response([
                    //         'Data' => null,
                    //         'error' => ([
                    //             'code' => 1,
                    //             'message' => 'Pilot is already login so please anyone emt login'
                    //         ])
                    //     ],REST_Controller::HTTP_OK);
                    // }else 
                    if($pilot == 2){
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'EMT is already login so do the anyone pilot login'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                    $emtMobNo = $this->user->getEmtMobNo($emtId);
                    print_r($emtMobNo);
                    if($emtMobNo){
                        $otp = rand(1000, 9999);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        $txtMsg='';
                        $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        $data_to_post = array();
                        $data_to_post['uname'] = 'bvgmems';
                        $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        $data_to_post['send'] = 'SperocHL';
                        $data_to_post['dest'] = $emtMobNo; 
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
                            'Data' => ([
                                'role' => $typeId,
                                'otp' => $otp
                            ]),
                            'error' => null
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
                // if($checkPilotLogin == 1){
                //     $this->response([
                //         'Data' => null,
                //         'error' => ([
                //             'code' => 1,
                //             'message' => 'Already another user is login '
                //         ])
                //     ],REST_Controller::HTTP_OK);
                // }else{
                //     $emtMobNo = $this->user->getEmtMobNo($emtId);
                //     if($emtMobNo){
                //         $otp = rand(1000, 9999);
                //         // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                //         $txtMsg='';
                //         $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                //         $data_to_post = array();
                //         $data_to_post['uname'] = 'bvgmems';
                //         $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                //         $data_to_post['send'] = 'SperocHL';
                //         $data_to_post['dest'] = $emtMobNo; 
                //         $data_to_post['msg'] = $txtMsg;
                        
                //         $curl = curl_init();
                //         curl_setopt($curl,CURLOPT_URL, $form_url);
                //         curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                //         curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                //         $result = curl_exec($curl);
                //         curl_close($curl);
        
                //         $current_time = date('Y-m-d H:i:s');
                //         $OTP_timestamp = strtotime($current_time) + 30*60;
                //         $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                //         $data = array(
                //                     'otp' => $otp,
                //                     'otp_expire_time' =>  $otp_expiry_time
                //                 );
                //         $this->user->insertEmtOtp($data,$emtId);
                //         $this->response([
                //             'Data' => ([
                //                 'role' => $typeId,
                //                 'otp' => $otp
                //             ]),
                //             'error' => null
                //         ], REST_Controller::HTTP_OK);
                //     }else{
                //         $this->response([
                //             'Data' => null,
                //             'error' => ([
                //                 'code' => 1,
                //                 'message' => 'Mobile Number Do Not Exist'
                //             ])
                //         ],REST_Controller::HTTP_OK);
                //     }
                // }
            }else{
                $this->response([
                    'Data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            if(!empty($vehicleNumber) && !empty($pilotId) && !empty($emtId)){
                $checkPilotLogin = $this->user->checkBoth($vehicleNumber);
                if($checkPilotLogin == 2){
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Already another user is login'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $pilot = $checkPilotLogin[0]['type_id'];
                    if($pilot == 1){
                        print_r('yes');
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Pilot is already login so do the anyone emt login'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if($pilot == 2){
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'EMT is already login so do the anyone pilot login'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                    $pilotMobNo = $this->user->getPilotMobNo($pilotId);
                    $emtMobNo = $this->user->getEmtMobNo($emtId);
                    if(!empty($emtMobNo) || !empty($pilotMobNo)){
                        $otp = rand(1000, 9999);
                        // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                        $txtMsg='';
                        $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                        $data_to_post = array();
                        $data_to_post['uname'] = 'bvgmems';
                        $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                        $data_to_post['send'] = 'SperocHL';
                        $data_to_post['dest'] = $emtMobNo; 
                        $data_to_post['dest'] = $pilotMobNo;
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
                        $this->user->insertPilotOtp($data,$pilotId);
                        $this->response([
                            'Data' => ([
                                'role' => $typeId,
                                'otp' => $otp
                            ]),
                            'error' => null
                        ], REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'Data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Mobile Number Do Not Exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }
                // if($checkPilotLogin == 1){
                //     $this->response([
                //         'Data' => null,
                //         'error' => ([
                //             'code' => 1,
                //             'message' => 'Already another user is login'
                //         ])
                //     ],REST_Controller::HTTP_OK);
                // }else{
                    // $pilotMobNo = $this->user->getPilotMobNo($pilotId);
                    // $emtMobNo = $this->user->getEmtMobNo($emtId);
                    // if(!empty($emtMobNo) || !empty($pilotMobNo)){
                    //     $otp = rand(1000, 9999);
                    //     // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                    //     $txtMsg='';
                    //     $txtMsg .= "OTP password is : $otp. OTP is valid for 30 Minutes";
                        
                    //     $data_to_post = array();
                    //     $data_to_post['uname'] = 'bvgmems';
                    //     $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                    //     $data_to_post['send'] = 'SperocHL';
                    //     $data_to_post['dest'] = $emtMobNo; 
                    //     $data_to_post['dest'] = $pilotMobNo;
                    //     $data_to_post['msg'] = $txtMsg;
                        
                    //     $curl = curl_init();
                    //     curl_setopt($curl,CURLOPT_URL, $form_url);
                    //     curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    //     curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                    //     $result = curl_exec($curl);
                    //     curl_close($curl);
        
                    //     $current_time = date('Y-m-d H:i:s');
                    //     $OTP_timestamp = strtotime($current_time) + 30*60;
                    //     $otp_expiry_time = date('Y-m-d H:i:s', $OTP_timestamp);
                    //     $data = array(
                    //                 'otp' => $otp,
                    //                 'otp_expire_time' =>  $otp_expiry_time
                    //             );
                    //     $this->user->insertEmtOtp($data,$emtId);
                    //     $this->user->insertPilotOtp($data,$pilotId);
                    //     $this->response([
                    //         'Data' => ([
                    //             'role' => $typeId,
                    //             'otp' => $otp
                    //         ]),
                    //         'error' => null
                    //     ], REST_Controller::HTTP_OK);
                    // }else{
                    //     $this->response([
                    //         'Data' => null,
                    //         'error' => ([
                    //             'code' => 1,
                    //             'message' => 'Mobile Number Do Not Exist'
                    //         ])
                    //     ],REST_Controller::HTTP_OK);
                    // }
                // }
            }else{
                $this->response([
                    'Data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }
    }
    public function checkpilotemtotp_post(){
        $typeId = $this->post('type');
        $pilotId = $this->post('pilotId');
        $emtId = $this->post('emtId');
        $otp = $this->post('otp');
        $vehicleNumber = $this->post('vehicleNumber');
        if($typeId == 1){
            if(!empty($typeId) && !empty($pilotId) && !empty($otp)){
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
                                'status' => 1
                            );
                            $this->user->insertLoginData($data1);
                            $cookie = array(
                                'name'   => 'cookie',
                                'value'  => 123456789,
                                'expire' =>  86400,
                                'secure' => false
                            );
                            $this->input->set_cookie($cookie);
                            // print_r($this->input->cookie('test', true));
                            $this->response([
                                'Data' => array(
                                    'id' => $this->input->cookie('test', true),
                                    'msg' => 'Successfully Login'
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 2,
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Invalid OTP'
                                ])
                            ],REST_Controller::HTTP_OK);
                        } 
                    }
                }else{
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'OTP expired'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'Data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else if($typeId == 2){
            if(!empty($typeId) && !empty($emtId) && !empty($otp)){
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
                                'status' => 1
                            );
                            $this->user->insertLoginData($data1);
                            $cookie = array(
                                'name'   => 'cookie',
                                'value'  => 123456789,
                                'expire' =>  86400,
                                'secure' => false
                            );
                            $this->input->set_cookie($cookie);
                            $this->response([
                                'Data' => array(
                                    'msg' => 'Successfully Login'
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 2,
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Invalid OTP'
                                ])
                            ],REST_Controller::HTTP_OK);
                        } 
                    }
                }else{
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'OTP expired'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'Data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            if(!empty($typeId) && !empty($pilotId) && !empty($emtId) && !empty($otp)){
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
                            'status' => 1
                        );
                        $this->user->insertLoginData($emtdata);
                        $pilotdata = array(
                            'type_id' => $typeId,
                            'vehicle_no' => $vehicleNumber,
                            'clg_id' => $pilotId,
                            'login_time' => $current_time,
                            'status' => 1
                        );
                        $this->user->insertLoginData($pilotdata);
                        $cookie = array(
                                'name'   => 'cookie',
                                'value'  => 123456789,
                                'expire' =>  86400,
                                'secure' => false
                            );
                            $this->input->set_cookie($cookie);
                        $this->response([
                            'Data' => array(
                                'msg' => 'Successfully Login'
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 2,
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
                                'Data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Invalid OTP'
                                ])
                            ],REST_Controller::HTTP_OK);
                        } 
                    }
                }else{
                    $this->response([
                        'Data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'OTP expired'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'Data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }
    }
    public function test_get(){
        print_r(get_cookie('test'));
    }
}