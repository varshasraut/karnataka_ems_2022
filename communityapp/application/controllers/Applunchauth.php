<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Applunchauth extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('Login_model'));
        $this->load->helper('string');
        $this->load->helper('number');
    }
    public function index_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        //echo $auth;
        if($auth == 1){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Logged In'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}