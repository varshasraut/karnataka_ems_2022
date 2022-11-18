<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Patientmedicine extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $data['med_id_list'] = json_encode($this->post('medicineList'));
            $data['other_med_id_list'] = json_encode($this->post('otherMedicineList'));
            $data['medicine_complete'] = '1';
            if(!empty($patientId)){
                    $medicinedata = $this->user->insertMedicine($patientId,$data);
                    if($medicinedata ==1){
                    $this->response([
                        'data' => ([
                            'code' => 1,
                        'message' => 'Sucessfully Inserted'
                    ]),
                    'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->reponse([
                        'data' => null,
                        'error' => ([
                            'code' =>1,
                            'message' => 'Not Inserted'
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
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function addmedicinenonunit_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $data['med_nonunit_id_list'] = json_encode($this->post('medicineNonUnitList'));
            $data['other_med_nonunit_id_list'] = json_encode($this->post('otherMedicineNonUnitList'));
            $data['medicine_nonunit_complete'] = '1';
            if(!empty($patientId)){
                    $medicinedata = $this->user->insertMedicine($patientId,$data);
                    if($medicinedata ==1){
                    $this->response([
                        'data' => ([
                            'code' => 1,
                        'message' => 'Sucessfully Inserted'
                    ]),
                    'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->reponse([
                        'data' => null,
                        'error' => ([
                            'code' =>1,
                            'message' => 'Not Inserted'
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
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
}


