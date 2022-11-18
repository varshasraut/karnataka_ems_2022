<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Checkallinfo extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $incidentID = $this->post('incidentId');
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentID);
            $checkPtnAvaorNot = $this->user->getIncidentData($incidentID);
            $vehicleNumber = $this->post('vehicleNumber');
            $vehicleData = $this->user->getVehicleData($vehicleNumber);
            if(empty($checkIncidentIdClose)){
                if(!empty($checkPtnAvaorNot)){
                    if($checkPtnAvaorNot[0]['patient_ava_or_not'] == 'no'){
                        $this->response([
                            'data' => ([
                                'code' => 1,
                                'message' => 'Patient Not Available'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        if(empty($vehicleData)){
                            $data = $this->user->checkAllInfo($incidentID);
                            $completionChk = array();
                            foreach($data as $data1){
                                // print_r($data1);
                                while((($data1[0]['pat_com_to_hosp'] == '0') || ($data1[0]['pat_com_to_hosp'] == '')) && (($data1[0]['initial_complete'] == '0' || $data1[0]['initial_complete'] == null) || ($data1[0]['ongoing_complete'] == '0' || $data1[0]['ongoing_complete'] == null) || ($data1[0]['handover_cond_complete'] == '0' || $data1[0]['handover_cond_complete'] == null) || ($data1[0]['handover_issue_complete'] == '0' || $data1[0]['handover_issue_complete'] == null) ) )
                                //while(( ($data1[0]['pat_com_to_hosp'] == '') ))
                                {
                                    $a = '1'; //'Not Complete :- 1'
                                    array_push($completionChk,$a);
                                    break;
                                }
                            }
                            if(!empty($completionChk)){
                                $this->response([
                                    'data' => null,
                                    'error' => ([
                                        'code' => 1,
                                        'message' => 'Incompleted Data'
                                    ])
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $this->response([
                                    'data' => ([
                                        'code' => 2,
                                        'message' => 'Completed Data'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                        }else if(!empty($vehicleData)){
                            if($vehicleData[0]['thirdparty'] == 1){
                                $data = $this->user->checkAllInfo($incidentID);
                                $completionChk = array();
                                foreach($data as $data1){
                                    // print_r($data1);
                                     while((($data1[0]['pat_com_to_hosp'] == '0') || ($data1[0]['pat_com_to_hosp'] == '')) && (($data1[0]['initial_complete'] == '0' || $data1[0]['initial_complete'] == null) || ($data1[0]['ongoing_complete'] == '0' || $data1[0]['ongoing_complete'] == null) || ($data1[0]['handover_cond_complete'] == '0' || $data1[0]['handover_cond_complete'] == null) || ($data1[0]['handover_issue_complete'] == '0' || $data1[0]['handover_issue_complete'] == null) ) )
                                    //while(( ($data1[0]['pat_com_to_hosp'] == '') ))
                                    {
                                        $a = '1'; //'Not Complete :- 1'
                                        array_push($completionChk,$a);
                                        break;
                                    }
                                }
                                if(!empty($completionChk)){
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'Incompleted Data'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $this->response([
                                        'data' => ([
                                            'code' => 2,
                                            'message' => 'Completed Data'
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }
                            }else{
                                $this->response([
                                'data' => ([
                                    'code' => 2,
                                    'message' => 'Completed Data'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                            }
                        }
                    }
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'Please add at least one patient'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
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
    }
}