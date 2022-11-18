<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Driverparameters extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $type = $this->post('type');
        $incidentId = $this->post('incidentId');
        $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
        if((isset($_COOKIE['cookie']))){
            if(empty($checkIncidentIdClose)){
                $id = $this->encryption->decrypt($_COOKIE['cookie']);
                $logindata = $this->user->getId($id,$type);
                if($logindata == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Wrong Type'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $data['dateTime'] = $this->post('dateTime');
                    $data['incidentId'] = $this->post('incidentId');
                    $incidentId = $data['incidentId'];
                    $data1['accept_incident_id'] = 'accepted';
                    $this->user->acceptIncidentId($incidentId,$data1);
                    $data['parametersType'] = $this->post('parametersType');
                    $para = $this->user->addDriverParameters($data);
                    $para1['incident_id'] =  $data['incidentId'];
                    $para1['amb_no'] = $logindata['vehicle_no'];
                    $with_partner = $this->user->getWithPatner($incidentId);
                    if(empty($para)){
                        $para1['parameter_count'] = 2;
                        $para1['start_from_base_loc'] = $data['dateTime'];
                        $para1['start_fr_bs_loc_id'] = $logindata['id'];
                        if($logindata['login_with_partner'] != ""){
                            $para1['with_partner'] = $logindata['login_with_partner'];
                        }
                        // $para1['with_partner'] = $logindata['login_with_partner'];
                        // $para1['start_fr_bs_loc_pilot'] = $logindata['id'];
                        $count = $this->user->InsertDriverParameters($para1);
                        $this->response([
                            'data' => ([
                                'code' => $count,
                                'outOfSych' => "false",
                                'message' => 'Insert'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else if(!empty($para)){
                        if($para[0]['parameter_count'] == 2){
                            $msg = "Already Start to base";
                        }
                        if($para[0]['parameter_count'] == 3){
                            $msg = "Already At Scene";
                        }
                        if($para[0]['parameter_count'] == 4){
                            $msg = "Already From Scene";
                        }
                        if($para[0]['parameter_count'] == 5){
                            $msg = "Already At hospital";
                        }
                        if($para[0]['parameter_count'] == 6){
                            $msg = "Already Patient handover";
                        }
                        if($para[0]['parameter_count'] == 7){
                            $msg = "Already back to base";
                        }
                        if($data['parametersType'] < $para[0]['parameter_count']){
                            $this->response([
                                'data' => ([
                                    'code' => $para[0]['parameter_count'],
                                    'outOfSych' => "true",
                                    'message' => $msg
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            if($data['parametersType'] == 2){
                                $this->user->acceptIncidentId($incidentId,$data1);
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['at_scene'] = $data['dateTime'];
                                $para1['at_scene_id'] = $logindata['id'];
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                // $para1['at_scene_pilot'] = $logindata['pilotId'];
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else if($data['parametersType'] == 3){
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['from_scene'] = $data['dateTime'];
                                $para1['from_scene_id'] = $logindata['id'];
                                // $para1['from_scene_pilot'] = $logindata['pilotId'];
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else if($data['parametersType'] == 4){
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['at_hospital'] = $data['dateTime'];
                                $para1['at_hosp_id'] = $logindata['id'];
                                // $para1['at_hosp_pilot'] = $logindata['pilotId'];
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else if($data['parametersType'] == 5){
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['patient_handover'] = $data['dateTime'];
                                $para1['patient_hand_id'] = $logindata['id'];
                                // $para1['patient_hand_pilot'] = $logindata['pilotId'];
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else if($data['parametersType'] == 6){
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['back_to_base_loc'] = $data['dateTime'];
                                $para1['back_to_bs_loc_id'] = $logindata['id'];
                                // $para1['back_to_bs_loc_pilot'] = $logindata['pilotId'];
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                            
                        }
                    }
                }
                
                // print_r($para);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 105,
                        'message' => 'Incident Id Completed'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
       
            
        die;


            if($data['parametersType'] > count($para[0]['parameter_count'])){
                print_r('yes');die;
                if($para == 2){
                    $this->response([
                        'data' => ([
                            'code' => $para,
                            'outOfSych' => "false",
                            'message' => 'Insert'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => ([
                            'code' => $para,
                            'outOfSych' => "true",
                            'message' => $at_scene
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }
            // if($data['parametersType'] == 2){
            //     if($para == 2){
            //         $this->response([
            //             'data' => ([
            //                 'code' => $para,
            //                 'outOfSych' => "false",
            //                 'message' => 'Insert'
            //             ]),
            //             'error' => null
            //         ],REST_Controller::HTTP_OK);
            //     }else{
            //         $this->response([
            //             'data' => ([
            //                 'code' => $para + 1,
            //                 'outOfSych' => "true",
            //                 'message' => 'Insert'
            //             ]),
            //             'error' => null
            //         ],REST_Controller::HTTP_OK);
            //     }
            // }
            // print_r($para);
            // if($para == 1){
            //     $this->response([
            //         'data' => ([
            //             'code' => $para,
            //             'outOfSych' => "false",
            //             'message' => 'Already inserted'
            //         ]),
            //         'error' => null
            //     ],REST_Controller::HTTP_OK);
            // }else{
            //     $this->response([
            //         'data' => ([
            //             'code' => $para,
            //         ]),
            //         'error' => null
            //     ],REST_Controller::HTTP_OK);
            // }
        // }else{
        //     $this->response([
        //         'data' => ([]),
        //         'error' => null
        //     ],REST_Controller::HTTP_UNAUTHORIZED);
        // }
    }
}

// if($para == 1){
//     $this->response([
//         'data' => ([
//             "code" => 7,
//             "message" => "Already inserted parameter of start from base location"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// }else if($para == 2){
//     $this->response([
//         'data' => ([
//             "code" => 8,
//             "message" => "Already inserted parameter of start from base location"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// }else if($para == 3){
//     $this->response([
//         'data' => ([
//             "code" => 9,
//             "message" => "Already inserted parameter of start from base location"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// }else if($para == 4){
//     $this->response([
//         'data' => ([
//             "code" => 10,
//             "message" => "Already inserted parameter of start from base location"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// }else if($para == 5){
//     $this->response([
//         'data' => ([
//             "code" => 11,
//             "message" => "Already inserted parameter of start from base location"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// }else if($para == 6){
//     $this->response([
//         'data' => ([
//             "code" => 12,
//             "message" => "Already inserted parameter of start from base location"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// }else{
//     $this->response([
//         'data' => ([
//             'code' => $data['parametersType'],
//             'message' => "Insert"
//         ]),
//         'error' => null
//     ],REST_Controller::HTTP_OK);
// } 