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
        $lat = $this->post('lat');
        $lng = $this->post('lng');
        $abandoned = $this->post('abandoned');
        $abandonedReason = $this->post('abandonedReason');
        $abandonedRemark = $this->post('abandonedRemark');
        $vehicle = $this->post('vehicleNumber');
        $kilometer = $this->post('kilometer');
        $veh = explode(' ',$vehicle);
        $vehicleNumber = implode('-',$veh);
        $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
        $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
        $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
        $patientavailable = $this->user->chkPtnAva($incidentId);
        // print_r($patientavailable);die;
        $inctype=$patientavailable[0]['inc_type'];
        // $checkPtnComToTheHosp = $this->user->checkPtnComToTheHosp($incidentId);
        $a = array();
        $b = array();
        if(!empty($patientavailable)){
            if($patientavailable[0]['patient_ava_or_not'] == 'yes'){
                $isAnyPatientAvailable1 = 0; //ptn available
            }else if($patientavailable[0]['patient_ava_or_not'] == 'no'){
                $isAnyPatientAvailable1 = 1; //ptn not available
            }else{
                $isAnyPatientAvailable1 = -1; //not selected
            }
        }
        if($inctype != 'on_scene_care')
		{
            $checkPtnComToTheHosp = $this->user->checkPtnComToTheHosp($incidentId);
            $a = array();
            $b = array();
            foreach($checkPtnComToTheHosp as $checkPtnComToTheHosp1){
                if($checkPtnComToTheHosp1['pat_com_to_hosp'] == '0'){
                    array_push($a,$checkPtnComToTheHosp1['pat_com_to_hosp']);
                    break;
                }
                if($checkPtnComToTheHosp1['pat_com_to_hosp'] == '1'){
                    array_push($b,$checkPtnComToTheHosp1['pat_com_to_hosp']);
                    
                }
            }
            if(!empty($a)){
                $ptnComeTohosp = 0; //ptn come to the hosp
            }else if(empty($a) && !empty($b)){
                $ptnComeTohosp = 1; //ptn not come to the hosp
            }else{
                $ptnComeTohosp = -1; //not selected
            }
		}
		else{
			$ptnComeTohosp = -1; //not selected
		}
        // echo $ptnComeTohosp;die;
        if((isset($_COOKIE['cookie']))){
            if(empty($checkIncidentIdClose)){
                $id = $this->encryption->decrypt($_COOKIE['cookie']);
                $logindata = $this->user->getId($id,$type);
                if(($logindata == 1) || (empty($deviceIdLogin))){
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_UNAUTHORIZED);
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
                        if($abandoned == '' && $data['parametersType'] != '9'){
                            $para1['parameter_count'] = 2;
                            $para1['acknowledge'] = $data['dateTime'];
                            $para1['acknowledge_id'] = $logindata['id'];
                            $para1['acknowledge_lat'] = $lat;
                            $para1['acknowledge_lng'] = $lng;
                            $para1['acknowledge_km'] = $kilometer;
                            if($logindata['login_with_partner'] != ""){
                                $para1['with_partner'] = $logindata['login_with_partner'];
                            }
                        }else{
                            $para1['parameter_count'] = 9;
                            $para1['abandoned'] = $data['dateTime'];
                            $para1['abandoned_id'] = $logindata['id'];
                            $para1['abandoned_lat'] = $lat;
                            $para1['abandoned_lng'] = $lng;
                            if($logindata['login_with_partner'] != ""){
                                $para1['with_partner'] = $logindata['login_with_partner'];
                            }
                            $abond['denial_id'] = $abandonedReason;
                            $abond['amb_id'] = $vehicleNumber;
                            $abond['denial_id'] = $abandonedReason;
                            $abond['denial_mdt_remark'] = $abandonedRemark;
                            $abond['denial_app_type'] = 'mdt';
                            $abond['denial_inc_ref_Id'] = $incidentId;
                            $abond['added_date'] = date('Y-m-d H:i:s');
                            if($logindata['login_with_partner'] != ""){
                                $abond['added_by'] = $logindata['login_with_partner'];
                            }
                            $this->user->insertAbandoneRem($abond);
                        }
                        $count = $this->user->InsertDriverParameters($para1);
                        $this->response([
                            'data' => ([
                                'code' => $count,
                                'outOfSych' => "false",
                                'message' => 'Insert',
                                'odometer' => $kilometer
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else if(!empty($para)){
                        if($para[0]['parameter_count'] == 2){
                            $msg = "Already Acknowledgement";
                            $odometer = (int) $para[0]['acknowledge_km'];
                        }
                        if($para[0]['parameter_count'] == 3){
                            $msg = "Already Start to base";
                            $odometer = (int) $para[0]['start_from_base_loc_km'];
                        }
                        if($para[0]['parameter_count'] == 4){
                            $msg = "Already At Scene";
                            $odometer = (int) $para[0]['at_scene_km'];
                        }
                        if($para[0]['parameter_count'] == 5){
                            $msg = "Already From Scene";
                            $odometer = (int) $para[0]['from_scene_km'];
                        }
                        if($para[0]['parameter_count'] == 6){
                            $msg = "Already At hospital";
                            $odometer = (int) $para[0]['at_hospital_km'];
                        }
                        if($para[0]['parameter_count'] == 7){
                            $msg = "Already Patient handover";
                            $odometer = $para[0]['patient_handover_km'];
                        }
                        if($para[0]['parameter_count'] == 8){
                            $msg = "Already back to base";
                            $odometer = (int) $para[0]['back_to_base_loc_km'];
                        }
                        if($para[0]['parameter_count'] == 9){
                            $msg = "Already Abandoned";
                            $odometer = null;
                        }
                        if($data['parametersType'] < $para[0]['parameter_count']){
                            // echo 'lll';die;
                            $this->response([
                                'data' => ([
                                    'code' => $para[0]['parameter_count'],
                                    'outOfSych' => "true",
                                    'message' => $msg,
                                    'odometer' => $odometer
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            // echo $data['parametersType'];die;
                            if($data['parametersType'] == 2){
                                $this->user->acceptIncidentId($incidentId,$data1);
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['start_from_base_loc'] = $data['dateTime'];
                                $para1['start_fr_bs_loc_id'] = $logindata['id'];
                                $para1['start_fr_bs_loc_lat'] = $lat;
                                $para1['start_fr_bs_loc_lng'] = $lng;
                                $para1['start_from_base_loc_km'] = $kilometer;
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                // $para1['at_scene_pilot'] = $logindata['pilotId'];
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert',
                                        'odometer' => $kilometer
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else if($data['parametersType'] == 3){
                                $this->user->acceptIncidentId($incidentId,$data1);
                                $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                $para1['at_scene'] = $data['dateTime'];
                                $para1['at_scene_id'] = $logindata['id'];
                                $para1['at_scene_lat'] = $lat;
                                $para1['at_scene_lng'] = $lng;
                                $para1['at_scene_km'] = $kilometer;
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                // $para1['at_scene_pilot'] = $logindata['pilotId'];
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert',
                                        'odometer' => $kilometer
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else if($data['parametersType'] == 4){
                                if(($isAnyPatientAvailable1 == 1 && $ptnComeTohosp == -1) || $ptnComeTohosp == 1){
                                    $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                    $para1['from_scene'] = $data['dateTime'];
                                    $para1['from_scene_id'] = $logindata['id'];
                                    $para1['from_scene_lat'] = $lat;
                                    $para1['from_scene_lng'] = $lng;
                                    $para1['from_scene_km'] = $kilometer;
                                    // $para1['from_scene_pilot'] = $logindata['pilotId'];
                                    if($with_partner[0]['with_partner'] == ""){
                                        $para1['with_partner'] = $logindata['login_with_partner'];
                                    }
                                    $count = $this->user->updateDriverParameters($para1);
                                    $this->response([
                                        'data' => ([
                                            'code' => 7,
                                            'outOfSych' => "false",
                                            'message' => 'Insert',
                                            'odometer' => $kilometer
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                    $para1['from_scene'] = $data['dateTime'];
                                    $para1['from_scene_id'] = $logindata['id'];
                                    $para1['from_scene_lat'] = $lat;
                                    $para1['from_scene_lng'] = $lng;
                                    $para1['from_scene_km'] = $kilometer;
                                    // $para1['from_scene_pilot'] = $logindata['pilotId'];
                                    if($with_partner[0]['with_partner'] == ""){
                                        $para1['with_partner'] = $logindata['login_with_partner'];
                                    }
                                    $count = $this->user->updateDriverParameters($para1);
                                    $this->response([
                                        'data' => ([
                                            'code' => $count,
                                            'outOfSych' => "false",
                                            'message' => 'Insert',
                                            'odometer' => $kilometer
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }
                            }else if($data['parametersType'] == 5){
                                if(($isAnyPatientAvailable1 == 1 && $ptnComeTohosp == -1) || $ptnComeTohosp == 1){
                                    $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                    $para1['at_hospital'] = $data['dateTime'];
                                    $para1['at_hosp_id'] = $logindata['id'];
                                    $para1['at_hosp_lat'] = $lat;
                                    $para1['at_hosp_lng'] = $lng;
                                    $para1['at_hospital_km'] = $kilometer;
                                    // $para1['from_scene_pilot'] = $logindata['pilotId'];
                                    if($with_partner[0]['with_partner'] == ""){
                                        $para1['with_partner'] = $logindata['login_with_partner'];
                                    }
                                    $count = $this->user->updateDriverParameters($para1);
                                    $this->response([
                                        'data' => ([
                                            'code' => 7,
                                            'outOfSych' => "false",
                                            'message' => 'Insert',
                                            'odometer' => $kilometer
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                    $para1['at_hospital'] = $data['dateTime'];
                                    $para1['at_hosp_id'] = $logindata['id'];
                                    $para1['at_hosp_lat'] = $lat;
                                    $para1['at_hosp_lng'] = $lng;
                                    $para1['at_hospital_km'] = $kilometer;
                                    // $para1['at_hosp_pilot'] = $logindata['pilotId'];
                                    if($with_partner[0]['with_partner'] == ""){
                                        $para1['with_partner'] = $logindata['login_with_partner'];
                                    }
                                    $count = $this->user->updateDriverParameters($para1);
                                    $this->response([
                                        'data' => ([
                                            'code' => $count,
                                            'outOfSych' => "false",
                                            'message' => 'Insert',
                                            'odometer' => $kilometer
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }
                            }else if($data['parametersType'] == 6){
                                if(($isAnyPatientAvailable1 == 1 && $ptnComeTohosp == -1) || $ptnComeTohosp == 1){
                                    $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                    $para1['patient_handover'] = $data['dateTime'];
                                    $para1['patient_hand_id'] = $logindata['id'];
                                    $para1['patient_hand_lat'] = $lat;
                                    $para1['patient_hand_lng'] = $lng;
                                    $para1['patient_handover_km'] = $kilometer;
                                    // $para1['from_scene_pilot'] = $logindata['pilotId'];
                                    if($with_partner[0]['with_partner'] == ""){
                                        $para1['with_partner'] = $logindata['login_with_partner'];
                                    }
                                    $count = $this->user->updateDriverParameters($para1);
                                    $this->response([
                                        'data' => ([
                                            'code' => 7,
                                            'outOfSych' => "false",
                                            'message' => 'Insert',
                                            'odometer' => $kilometer
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $para1['parameter_count'] = $para[0]['parameter_count'] + 1;
                                    $para1['patient_handover'] = $data['dateTime'];
                                    $para1['patient_hand_id'] = $logindata['id'];
                                    $para1['patient_hand_lat'] = $lat;
                                    $para1['patient_hand_lng'] = $lng;
                                    $para1['patient_handover_km'] = $kilometer;
                                    // $para1['patient_hand_pilot'] = $logindata['pilotId'];
                                    if($with_partner[0]['with_partner'] == ""){
                                        $para1['with_partner'] = $logindata['login_with_partner'];
                                    }
                                    $count = $this->user->updateDriverParameters($para1);
                                    $this->response([
                                        'data' => ([
                                            'code' => $count,
                                            'outOfSych' => "false",
                                            'message' => 'Insert',
                                            'odometer' => $kilometer
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }
                            }else if($data['parametersType'] == 7){
                                $para1['parameter_count'] = $data['parametersType'] + 1;
                                $para1['back_to_base_loc'] = $data['dateTime'];
                                $para1['back_to_bs_loc_id'] = $logindata['id'];
                                $para1['back_to_bs_loc_lat'] = $lat;
                                $para1['back_to_bs_loc_lng'] = $lng;
                                $para1['back_to_base_loc_km'] = $kilometer;
                                // $para1['back_to_bs_loc_pilot'] = $logindata['pilotId'];
                                if($with_partner[0]['with_partner'] == ""){
                                    $para1['with_partner'] = $logindata['login_with_partner'];
                                }
                                $count = $this->user->updateDriverParameters($para1);
                                $this->response([
                                    'data' => ([
                                        'code' => $count,
                                        'outOfSych' => "false",
                                        'message' => 'Insert',
                                        'odometer' => $kilometer
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