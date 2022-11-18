<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Hospitaldetails extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $incidentId = $this->post('incidentId');
        $hosp['incidentId'] = $incidentId;
        $hosp['district'] = null;
        if(isset($_COOKIE['cookie'])){
            $hospDetails = $this->user->getHospitalDeatils($incidentId);
            $district = $this->user->getByDefaultDistrict($hosp);
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
            if(empty($checkIncidentIdClose)){
                if($hospDetails[0]['id'] != null){
                    $district1 = array(
                        'id' => (int) $hospDetails[0]['id'],
                        'name' => $hospDetails[0]['name']
                    );
                }else{
                    $district1 = $district;
                }
                if(!empty($hospDetails)){
                    if(empty($hospDetails[0]['hospital_id']) && !empty($hospDetails[0]['hospital_name']) ){
                        $this->response([
                            'data' => ([
                                'district' => $district1,
                                'hospitalType' => $hospDetails[0]['hospital_type'],
                                'hospital' => ([
                                    'other' => 'true',
                                    'hospId' => null,
                                    'hospName' => $hospDetails[0]['hospital_name'],
                                    'hospAdd' => $hospDetails[0]['hospital_address'],
                                    'hospLat' => null,
                                    'hospLong' => null
                                ])
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else if(($hospDetails[0]['hospital_name']) == '' && !empty($hospDetails[0]['hospital_id'])){
                        $this->response([
                            'data' => ([
                                'district' => $district1,
                                'hospitalType' => $hospDetails[0]['hospital_type'],
                                'hospital' => ([
                                    'other' => 'false',
                                    'hospId' => $hospDetails[0]['hp_id'],
                                    'hospName' => $hospDetails[0]['hp_name'],
                                    'hospAdd' => $hospDetails[0]['hp_address'],
                                    'hospLat' => (float) $hospDetails[0]['hp_lat'],
                                    'hospLong' => (float) $hospDetails[0]['hp_long']
                                ])
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'data' => ([
                                'district' => $district1,
                                'hospitalType' => null,
                                'hospital' => ([
                                    'other' => null,
                                    'hospId' => null,
                                    'hospName' => null,
                                    'hospAdd' => null,
                                    'hospLat' => null,
                                    'hospLong' => null
                                ])
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                    // $this->response([
                    //     'data' => ([
                    //         'district' => ([
                    //             'id' => $hospDetails[0]['id'],
                    //             'name' => $hospDetails[0]['name']
                    //         ]),
                    //         'hospitalType' => $hospDetails[0]['hospital_type'],
                    //         'otherHosp' => ([
                    //             'otherHospName' => $hospDetails[0]['hospital_name'],
                    //             'otherHospAdd' => $hospDetails[0]['hospital_address']
                    //         ]),
                    //         'hospital' => ([
                    //             'hospName' => $hospDetails[0]['hp_name'],
                    //             'hospAdd' => $hospDetails[0]['hp_address'],
                    //             'hospLat' => $hospDetails[0]['hp_lat'],
                    //             'hospLong' => $hospDetails[0]['hp_long']
                    //         ])
                    //     ]),
                    //     'error' => null
                    // ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error' => null
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