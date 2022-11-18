<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Userlogs extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('Call_model','Common_model','Login_model'));
        $this->load->library('encryption');
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        if($auth == 1){
            $mobile = $this->post('mobile');
            $userlog = $this->Common_model->getUserLogs($mobile);
            if(empty($userlog)){
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                 $data1 = array();
                foreach($userlog as $userlog1){
                    $data = array(
                        "callTime" => $userlog1['added_date'],
                        "callStatus" => $userlog1['call_status']
                    );
                    array_push($data1,$data);
                }
                $this->response([
                    'data' => $data1,
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
    public function getuserdeatils_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        $data['mobile'] = $this->post('mobile');
        if($auth == 1){
            $rec = $this->Common_model->getUsrData($data);
            $this->response([
                'data' => $rec,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function updateuserdeatils_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        $mobile = $this->post('mobile');
        $updateData['f_name'] = $this->post('fName');
        $updateData['l_name'] = $this->post('lName');
        $updateData['email'] = $this->post('email');
        $updateData['gender'] = $this->post('gender');
        $updateData['address'] = $this->post('address');
        $updateData['age'] = $this->post('age');
        $updateData['blood_grp'] = $this->post('bloodGrp');
        $updateData['user_ayushman_id'] = $this->post('ayushmanId');
        $updateData['age_grp'] = $this->post('ageGroup');
        if($auth == 1){
            $rec = $this->Common_model->updateuserdeatils($mobile,$updateData);
            if($rec == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => "Updated Sucessfully"
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