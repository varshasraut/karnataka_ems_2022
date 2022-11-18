<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Patienteditconsumable extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $requestId = $this->post('requestId');
            if(!empty($patientId)){
                $args = "CA";
                $consumable = $this->user->ConsumableList($patientId,$args);
            }else{
                $args = "Req";
                $consumable = $this->user->ConsumableList($requestId,$args);
            }
            if(!empty($consumable)){
                $this->response([
                    'data' => $consumable,
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_COntroller::HTTP_OK);
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
    //         $data['consumable_complete'] = '1';
    //         if(!empty($patientId)){
    //             $consumable = $this->user->ConsumableList($patientId);
    //             $this->response([
    //                 'data' => $consumable,
    //                 'error' => null
    //             ],REST_Controller::HTTP_OK);
    //         }else{
    //             $this->response([
    //                 'data' => ([]),
    //                 'error' => null
    //             ],REST_COntroller::HTTP_OK);
    //         }
    //     }else{
    //         $this->response([
    //             'data' => ([]),
    //             'error' => null
    //         ],REST_Controller::HTTP_UNAUTHORIZED);
    //     } 
    // }
    //  public function cosumablenonunit_post(){
    //     if((isset($_COOKIE['cookie']))){
    //         $patientId = $this->post('patientId');
    //         if(!empty($patientId)){
    //             $consumable = $this->user->ConsumableNonUnitList($patientId);
    //             $this->response([
    //                 'data' => $consumable,
    //                 'error' => null
    //             ],REST_Controller::HTTP_OK);
    //         }else{
    //             $this->response([
    //                 'data' => ([]),
    //                 'error' => null
    //             ],REST_COntroller::HTTP_OK);
    //         }
    //     }else{
    //         $this->response([
    //             'data' => ([]),
    //             'error' => null
    //         ],REST_Controller::HTTP_UNAUTHORIZED);
    //     } 
    // }
     public function cosumablenonunit_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $requestId = $this->post('requestId');
            if(!empty($patientId)){
                $args = "CA";
                $consumable = $this->user->ConsumableNonUnitList($patientId,$args);
            }else{
                $args = "Req";
                $consumable = $this->user->ConsumableNonUnitList($requestId,$args);
            }
            if(!empty($consumable)){
                $this->response([
                    'data' => $consumable,
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_COntroller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
}


