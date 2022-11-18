<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_UserLogin extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model('supervisory_app_api_models/Supervisory_Login_model');
        $this->load->helper('string');
        $this->load->helper('number');
    }
    public function index_post(){
        $data['username'] =  $this->post('username');
        $data['password'] =  $this->post('password');
        $data['device_id'] =  $this->post('uniqueId');
        if(isset($data['username']) && isset($data['password'])){
            $loginSecretKey = md5($data['username'].date('Y-m-d H:i:s'));
            $loginData = $this->Supervisory_Login_model->checkLoginUser($data);
            // print_r($loginData);
            $loginCheck = $this->Supervisory_Login_model->loginCheck($data);
            // echo $loginSecretKey;
            if(is_array($loginCheck)){
                if(empty($loginData)){
                    // print_r($loginCheck);
                    $login['clg_id'] = $loginCheck[0]['clg_id'];
                    $clg_district_id = $loginCheck[0]['clg_district_id'];
                    
                    $login['username'] = $data['username'];
                    $login['login_secret_key'] = $loginSecretKey;
                    $login['login_time'] = date('Y-m-d H:i:s');
                    $login['device_id'] = $data['device_id'];
                    $login['login_status'] = '1';
                    $loginSuccess = $this->Supervisory_Login_model->loginSuccess($login);
                    if($loginSuccess == 1){
                        $this->response([
                            'data' => ([
                                'code' => 1,
                                'login_secret_key' => $loginSecretKey,
                                'district' => $clg_district_id,
                                'message' => 'Sucessfully login.'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    if(!empty($loginData) && ($data['device_id']==$loginData[0]->device_id)){ 
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'The user is already logged into the username ('.$loginData[0]->username.')'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else if(!empty($loginData) && ($data['device_id']!=$loginData[0]->device_id)){ 
                        $login['clg_id'] = $loginCheck[0]['clg_id'];;
                        $login['username'] = $data['username'];
                        $login['login_secret_key'] = $loginSecretKey;
                        $login['login_time'] = date('Y-m-d H:i:s');
                        $login['device_id'] = $data['device_id'];
                        $login['login_status'] = '1';
                        $loginData = $this->Supervisory_Login_model->logoutPreDevice($data);
                        $loginSuccess = $this->Supervisory_Login_model->loginSuccess($login);
                        if($loginData == 1 && $loginSuccess == 1){
                            $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'login_secret_key' => $loginSecretKey,
                                    'message' => 'Sucessfully login. Your previous device logged out.'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }
            }else{
                if($loginCheck == 3){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'Wrong Password'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else if($loginCheck == 2){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 3,
                            'message' => 'Wrong Username'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' =>null
            ],REST_Controller::HTTP_OK);
        }
    }
}