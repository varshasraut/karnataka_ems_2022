<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class User_family_info extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model(array('User_family_info_model','Common_model','Login_model'));
    }
  
    public function usrfamilyregister_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        if($auth == 1){
            $usrMobNo = $this->post('mobile');
            $userId = $this->User_family_info_model->checkUserId($usrMobNo);
            // print_r($userId);
            if($userId != 1) {
                $data['usr_id'] =$userId[0]->usr_id;
                $data['fam_f_name'] = $this->post('fFName');
                $data['fam_l_name'] = $this->post('fLName');
                $data['fam_email'] = $this->post('fEmail');
                $data['fam_mobile'] = $this->post('fMobile');
                $data['fam_gender'] = $this->post('fGender');
                $data['fam_address'] = $this->post('fAddress');
                $data['fam_age'] = $this->post('fAge');
                $data['fam_age_grp'] = $this->post('ageGroup');
                $data['fam_blood_grp'] = $this->post('fBloodGrp');
                $data['fam_ayushman_id'] = $this->post('fAyushmanId');
                $data['fam_added_date'] = date('Y-m-d H:i:s');
                $rec = $this->User_family_info_model->storeUserFamilyInfo($data);
                if($rec == 1){
                    $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => "Sucessfully Inserted"
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Mobile number not register'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function deleteUserFamRecords_post()
    {
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        if($auth == 1){
            $id=$this->post('usrFamId');
            $res=$this->User_family_info_model->delete_user_fam_records($id);
            if($res == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => "Sucessfully Deleted"
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Error'
                    ]),
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function updateUserFamRecords_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        if($auth == 1){
            $id=$this->post('usrFamId');
            $data['fam_f_name'] = $this->post('fFName');
            $data['fam_l_name'] = $this->post('fLName');
            $data['fam_email'] = $this->post('fEmail');
            $data['fam_mobile'] = $this->post('fMobile');
            $data['fam_gender'] = $this->post('fGender');
            $data['fam_address'] = $this->post('fAddress');
            $data['fam_age'] = $this->post('fAge');
            $data['fam_age_grp'] = $this->post('ageGroup');
            $data['fam_blood_grp'] = $this->post('fBloodGrp');
            $data['fam_ayushman_id'] = $this->post('fAyushmanId');
            $res=$this->User_family_info_model->update_user_fam_records($id,$data);
            if($res == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => "Sucessfully updated"
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
            else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Error'
                    ]),
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function getuserallfaminfo_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        if($auth == 1){
            $usrMobNo=$this->post('mobile');
            $rec = $this->User_family_info_model->get_user_all_fam_info($usrMobNo);
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
    public function viewuserallfaminfo_post(){
        $chkLoging['login_secret_key'] =  $this->post('loginSecretKey');
        $chkLoging['uniqueId'] =  $this->post('uniqueId');
        $chkLoging['mobile'] =  $this->post('mobile');
        $auth = $this->Login_model->checkLoginUserforAuth($chkLoging);
        if($auth == 1){
            $usrFamId = $this->post('usrFamId');
            $rec = $this->User_family_info_model->get_user_fam_info_as_id($usrFamId);
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
}