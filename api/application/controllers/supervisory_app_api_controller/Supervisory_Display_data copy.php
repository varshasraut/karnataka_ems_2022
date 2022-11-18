<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Display_data extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('dash_app_api_models/Supervisory_Display_model','dash_app_api_models/Supervisory_Login_model'));
        // $this->load->model('dash_app_api_models/Display_model');
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
    }
    // public function index_post(){
    //     $data1['login_secret_key'] =  $this->post('loginSecretKey');
    //     $data1['device_id'] =  $this->post('uniqueId');
    //     $data1['username'] =  $this->post('username');
    //     $username = $this->post('username');
    //     $auth = $this->Login_model->checkLoginUserforAuth($data1);
    //     if($auth == 1){
    //         $viewdata = $this->Inspection_model->getlistofinspection($username);
    //         $this->response([
    //             'data' => $viewdata,
    //             'error' => null
    //         ],REST_Controller::HTTP_OK);
    //     }else{
    //         $this->response([
    //             'data' => ([]),
    //             'error' => null
    //         ],REST_Controller::HTTP_UNAUTHORIZED);
    //     }
    // }
    public function display_amb_data_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
        //     $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Display_model->getdisplaydata();
            // print_r($viewdata);die;
            if(!empty($viewdata)){
                $arr = array();
                foreach($viewdata as $data2){
                    $amb_data =  array(
                        "amb_id" =>$data2->amb_id,
                        "amb_number" => $data2->amb_rto_register_no ,
                        "amb_type" =>$data2->amb_type,
                    );
                    array_push($arr, $amb_data);
                }
                $this->response([
                    'data' =>  $arr,
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
            // print_r("nakotarnako");
        }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

}