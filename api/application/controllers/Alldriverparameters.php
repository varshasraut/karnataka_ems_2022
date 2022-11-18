<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Alldriverparameters extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $incidentId = $this->post('incidentId');
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
            if(empty($checkIncidentIdClose)){
                if(!empty($incidentId)){
                    $call = $this->user->allDriverParameters($incidentId);
                    if(!empty($call)){
                        $this->response([
                            'data' => ([
                                'id' => $call[0]['incident_id'],
                                'acknowledge' => $call[0]['acknowledge'],
                                'startFromBaseLocation' => $call[0]['start_from_base_loc'],
                                'atScene' => $call[0]['at_scene'],
                                'fromScene' => $call[0]['from_scene'],
                                'atHospital' => $call[0]['at_hospital'],
                                'patientHandover' => $call[0]['patient_handover'],
                                'backToBaseLocation' => $call[0]['back_to_base_loc'],
                                'acknowledge_km' => (int) $call[0]['acknowledge_km'],
                                'start_from_base_loc_km' => (int) $call[0]['start_from_base_loc_km'],
                                'at_scene_km' => (int) $call[0]['at_scene_km'],
                                'from_scene_km' => (int) $call[0]['from_scene_km'],
                                'at_hospital_km' => (int) $call[0]['at_hospital_km'],
                                'patient_handover_km' => (int) $call[0]['patient_handover_km'],
                                'back_to_base_loc_km' => (int) $call[0]['back_to_base_loc_km']
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'data' => ([
                                'id' => null,
                                'startFromBaseLocation' => null,
                                'atScene' => null,
                                'fromScene' => null,
                                'atHospital' => null,
                                'patientHandover' => null,
                                'backToBaseLocation' => null,
                                'acknowledge_km' => null,
                                'start_from_base_loc_km' => null,
                                'at_scene_km' => null,
                                'from_scene_km' => null,
                                'at_hospital_km' => null,
                                'patient_handover_km' => null,
                                'back_to_base_loc_km' => null
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    $this->response([
                        'data' => ([]),
                        'error' =>null
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


