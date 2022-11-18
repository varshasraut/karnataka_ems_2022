<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Addotherhosp extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $incidentid = $this->post('incidentId');
            $data['hospital_name'] = $this->post('hospitalName');
            $data['hospital_address'] = $this->post('hospitalAddress');
            $data['hospital_id'] = $this->post('hospitalId');
            $data['hospital_type'] = $this->post('hospitalType');
            $data['hospital_district'] = $this->post('hospitalDistrict');
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentid);
            if(empty($checkIncidentIdClose)){
                if((!empty($incidentid) || (!empty($data['hospital_name'])) || (!empty($data['hospital_address']))) || (!empty($data['hospital_id']))){
                    $hospitalsname = $this->user->addOtherHospital($incidentid,$data);
                    if($hospitalsname == 1){
                        $this->response([
                            'data' => ([
                                'code' => 1,
                                'message' => 'Successfully inserted'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 2,
                                'message' => 'Incident ID not matched'
                            ])
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