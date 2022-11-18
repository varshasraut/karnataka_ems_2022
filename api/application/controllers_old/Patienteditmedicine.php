<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class PatientEditmedicine extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $requestId = $this->post('requestId');
            if(!empty($patientId)){
                $args = "MCA";
                $medicine = $this->user->getmedicinename($patientId,$args);
            }else{
                $args = "Req";
                $medicine = $this->user->getmedicinename($requestId,$args);
            }
            if(!empty($medicine)){
                $this->response([
                    'data' => $medicine,
                    'error' => null
                ],REST_Controller::HTTP_OK);
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
    // public function index_post(){
    //     if((isset($_COOKIE['cookie']))){
    //         $patientId = $this->post('patientId');
    //         $data['medicine_complete'] = '1';
    //         if(!empty($patientId)){
    //             $medicine = $this->user->getmedicinename($patientId);
    //             $this->response([
    //                 'data' => $medicine,
    //                 'error' => null
    //             ],REST_Controller::HTTP_OK);
    //         }else{
    //             $this->response([
    //                 'data' => ([]),
    //                 'error' => null
    //             ],REST_Controller::HTTP_OK);
    //         }
    //     }else{
    //         $this->response([
    //             'data' => ([]),
    //             'error' => null
    //         ],REST_Controller::HTTP_UNAUTHORIZED);
    //     } 
    // }
    // public function medicinenonunit_post(){
    //     if((isset($_COOKIE['cookie']))){
    //         $patientId = $this->post('patientId');
    //         if(!empty($patientId)){
    //             $medicine = $this->user->getNonUnitMedicineName($patientId);
    //             $this->response([
    //                 'data' => $medicine,
    //                 'error' => null
    //             ],REST_Controller::HTTP_OK);
    //         }else{
    //             $this->response([
    //                 'data' => ([]),
    //                 'error' => null
    //             ],REST_Controller::HTTP_OK);
    //         }
    //     }else{
    //         $this->response([
    //             'data' => ([]),
    //             'error' => null
    //         ],REST_Controller::HTTP_UNAUTHORIZED);
    //     } 
    // }
    public function medicinenonunit_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $requestId = $this->post('requestId');
            if(!empty($patientId)){
                $args = "MNCA";
                $medicine = $this->user->getNonUnitMedicineName($patientId,$args);
            }else{
                $args = "Req";
                $medicine = $this->user->getNonUnitMedicineName($requestId,$args);
            }
            if(!empty($medicine)){
                $this->response([
                    'data' => $medicine,
                    'error' => null
                ],REST_Controller::HTTP_OK);
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


