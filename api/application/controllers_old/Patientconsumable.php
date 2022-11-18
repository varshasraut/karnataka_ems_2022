<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Patientconsumable extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $data['con_id_list'] = json_encode($this->post('consumableList'));
            $data['other_con_id_list'] = json_encode($this->post('otherconsumableList'));
            $data['consumable_complete'] = '1';
            // print_r($data);die;
            if(!empty($patientId)){
                $consumabledata = $this->user->insertConsumable($patientId,$data);
                if($consumabledata ==1){
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
    public function addconsumablenonunit_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $data['con_nonunit_id_list'] = json_encode($this->post('consumablenonunitList'));
            $data['other_con_nonunit_id_list'] = json_encode($this->post('otherconsumablenonunitList'));
            $data['consumable_nonunit_complete'] = '1';
            if(!empty($patientId)){
                $consumabledata = $this->user->insertConsumable($patientId,$data);
                if($consumabledata ==1){
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


