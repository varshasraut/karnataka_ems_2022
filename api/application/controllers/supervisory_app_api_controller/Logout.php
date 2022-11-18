<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Logout extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model('supervisory_app_api_models/Login_model');
        $this->load->helper('string');
        $this->load->helper('number');
    }
    public function index_post(){
        $data['login_secret_key'] =  $this->post('loginSecretKey');
        $data['device_id'] =  $this->post('uniqueId');
        $data['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data);
        if($auth == 1){
            $log = $this->Login_model->logoutUser($data);
            if($log == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Sucessfully Logout'
                    ]),
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