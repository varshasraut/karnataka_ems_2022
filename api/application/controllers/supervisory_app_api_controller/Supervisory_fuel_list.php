<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_fuel_list extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_Dashboard_list_model','supervisory_app_api_models/Supervisory_Login_model'));
        // $this->load->model('supervisory_app_api_models/Display_model');
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
       
    }
    public function index_post(){

        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $data1['date'] = $this->post('date');
        $data1['param'] = $this->post('param');
        $date = $this->post('date');
       

        
        // echo "<pre>";print_r($data1);die;
        $current_date = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
        $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
       
        $fuel = array();
            $fuel = $this->Supervisory_Dashboard_list_model->get_fuel_filling_list($date); 
        
    
        $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){

            $viewdata = $fuel;
            $this->response($viewdata,
             REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    

}