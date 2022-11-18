<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Checkvehicleotp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $typeId = $this->post('type');
        $vehicleNumber = $this->post('vehicleNumber');
        $otp = $this->post('otp');
        $skipotp = $this->post('skipotp');
        if($skipotp == 'true'){
            if($typeId == 1){
                $data = array(
                    'otp' => '',
                    'skip_otp' => $skipotp,
                    'otp_verification' => ''
                );
                $this->user->updateOtp($vehicleNumber,$data);
                $Pilotlist = $this->user->getPilot($vehicleNumber);
                if(empty($Pilotlist)){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Driver not assigned'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => ([
                            'code' => 3,
                            'pilot' => $Pilotlist,
                            'emt' => [],
                            'message' => 'success'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else if($typeId == 2){
                $data = array(
                    'otp' => '',
                    'skip_otp' => $skipotp,
                    'otp_verification' => ''
                );
                $this->user->updateOtp($vehicleNumber,$data);
                $Emtlist = $this->user->getEmt($vehicleNumber);
                if(empty($Emtlist)){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'Paramedic not assigned'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => ([
                            'code' => 3,
                            'pilot' => [],
                            'emt' => $Emtlist,
                            'message' => 'success'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $data = array(
                    'otp' => '',
                    'skip_otp' => $skipotp,
                    'otp_verification' => ''
                );
                $this->user->updateOtp($vehicleNumber,$data);
                $Pilotlist = $this->user->getPilot($vehicleNumber);
                $Emtlist = $this->user->getEmt($vehicleNumber);
                if(empty($Emtlist) && empty($Pilotlist)){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 3,
                            'message' => 'Driver & Paramedic not assigned'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => ([
                            'code' => 3,
                            'pilot' => $Pilotlist,
                            'emt' => $Emtlist,
                            'message' => 'success'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }
        }else{
            if(!empty($typeId) && !empty($vehicleNumber) && !empty($otp)){
                $otpExpireTime = $this->user->getOtp($vehicleNumber);
                $current_time = date('Y-m-d H:i:s');
                if(($otpExpireTime[0]['otp'] == $otp)){
                    if(($otpExpireTime[0]['otp_expire_time'] >= $current_time)){
                        if($typeId == 1){
                            $data = array(
                                'otp' => '',
                                'otp_verification' => 2
                            );
                            $this->user->updateOtp($vehicleNumber,$data);
                            $Pilotlist = $this->user->getPilot($vehicleNumber);
                            if(empty($Pilotlist)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'Driver not assigned'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $this->response([
                                    'data' => ([
                                        'code' => 3,
                                        'pilot' => $Pilotlist,
                                        'emt' => [],
                                        'message' => 'success'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                        }else if($typeId == 2){
                            $data = array(
                                'otp' => '',
                                'otp_verification' => 2
                            );
                            $this->user->updateOtp($vehicleNumber,$data);
                            $Emtlist = $this->user->getEmt($vehicleNumber);
                            if(empty($Emtlist)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 2,
                                        'message' => 'Paramedic not assigned'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $this->response([
                                    'data' => ([
                                        'code' => 3,
                                        'pilot' => [],
                                        'emt' => $Emtlist,
                                        'message' => 'success'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                        }else{
                            $data = array(
                                'otp' => '',
                                'otp_verification' => 2
                            );
                            $this->user->updateOtp($vehicleNumber,$data);
                            $Pilotlist = $this->user->getPilot($vehicleNumber);
                            $Emtlist = $this->user->getEmt($vehicleNumber);
                            if(empty($Emtlist) && empty($Pilotlist)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 3,
                                        'message' => 'Driver & Paramedic not assigned'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $this->response([
                                    'data' => ([
                                        'code' => 3,
                                        'pilot' => $Pilotlist,
                                        'emt' => $Emtlist,
                                        'message' => 'success'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                        }
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 4,
                                'message' => 'OTP expired'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 5,
                            'message' => 'Invalid OTP'
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


        // if(!empty($typeId) && !empty($vehicleNumber) && !empty($otp)){
        //     $otpExpireTime = $this->user->getOtp($vehicleNumber);
        //     $current_time = date('Y-m-d H:i:s');
        //     if(empty($otpExpireTime)){
        //         $this->response([
        //             'data' => null,
        //             'error' => ([
        //                 'code' => 7,
        //                 'message' => 'Ambulance not registered'
        //             ])
        //         ],REST_Controller::HTTP_OK);
        //     }else{
        //         if(($otpExpireTime[0]['otp'] == $otp)){
        //             if(($otpExpireTime[0]['otp_expire_time'] >= $current_time)){
        //                 if($typeId == 1){
        //                     $data = array(
        //                         'otp' => '',
        //                         'otp_verification' => 2
        //                     );
        //                     $this->user->updateOtp($vehicleNumber,$data);
        //                     $Pilotlist = $this->user->getPilot($vehicleNumber);
        //                     if(empty($Pilotlist)){
        //                         $this->response([
        //                             'data' => null,
        //                             'error' => ([
        //                                 'code' => 4,
        //                                 'message' => 'Driver not assigned'
        //                             ])
        //                         ],REST_Controller::HTTP_OK);
        //                     }else{
        //                         $this->response([
        //                             'data' => ([
        //                                 'code' => 3,
        //                                 'pilot' => $Pilotlist,
        //                                 'emt' => [],
        //                                 'message' => 'success'
        //                             ]),
        //                             'error' => null
        //                         ],REST_Controller::HTTP_OK);
        //                     }
        //                 }else if($typeId == 2){
        //                     $data = array(
        //                         'otp' => '',
        //                         'otp_verification' => 2
        //                     );
        //                     $this->user->updateOtp($vehicleNumber,$data);
        //                     $Emtlist = $this->user->getEmt($vehicleNumber);
        //                     if(empty($Emtlist)){
        //                         $this->response([
        //                             'data' => null,
        //                             'error' => ([
        //                                 'code' => 5,
        //                                 'message' => 'Paramedic not assigned'
        //                             ])
        //                         ],REST_Controller::HTTP_OK);
        //                     }else{
        //                         $this->response([
        //                             'data' => ([
        //                                 'code' => 3,
        //                                 'pilot' => [],
        //                                 'emt' => $Emtlist,
        //                                 'message' => 'success'
        //                             ]),
        //                             'error' => null
        //                         ],REST_Controller::HTTP_OK);
        //                     }
        //                 }else{
        //                     $data = array(
        //                         'otp' => '',
        //                         'otp_verification' => 2
        //                     );
        //                     $this->user->updateOtp($vehicleNumber,$data);
        //                     $Pilotlist = $this->user->getPilot($vehicleNumber);
        //                     $Emtlist = $this->user->getEmt($vehicleNumber);
        //                     if(empty($Emtlist) && empty($Pilotlist)){
        //                         $this->response([
        //                             'data' => null,
        //                             'error' => ([
        //                                 'code' => 6,
        //                                 'message' => 'Driver & Paramedic not assigned'
        //                             ])
        //                         ],REST_Controller::HTTP_OK);
        //                     }else{
        //                         $this->response([
        //                             'data' => ([
        //                                 'code' => 3,
        //                                 'pilot' => $Pilotlist,
        //                                 'emt' => $Emtlist,
        //                                 'message' => 'success'
        //                             ]),
        //                             'error' => null
        //                         ],REST_Controller::HTTP_OK);
        //                     }
        //                 }
        //             }else{
                        
        //                 $this->response([
        //                     'data' => null,
        //                     'error' => ([
        //                         'code' => 2,
        //                         'message' => 'OTP expired'
        //                     ])
        //                 ],REST_Controller::HTTP_OK);
        //             }
        //         }else{
        //             $this->response([
        //                 'data' => null,
        //                 'error' => ([
        //                     'code' => 1,
        //                     'message' => 'Invalid OTP'
        //                 ])
        //             ],REST_Controller::HTTP_OK);
        //         }
        //     }
        // }else{
        //     $this->response([
        //         'data' => ([]),
        //         'error' => null
        //     ],REST_Controller::HTTP_OK);
        // }
    }
}