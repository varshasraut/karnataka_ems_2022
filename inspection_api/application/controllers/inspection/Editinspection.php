<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Editinspection extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('Inspection_model','Login_model','Common_model'));
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
    }
    public function index_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $username = $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $viewdata = $this->Inspection_model->getlistofincompinspection($username);
            $this->response([
                'data' => $viewdata,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function secondEditInspFormMainVeh_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo');
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormMainVeh($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->ins_main_date == '' || $data1->ins_main_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->ins_main_date));
                    }
                    $this->response([
                        'data' => [
                            'dateOfMaintenance' => $WorkingDate,
                            'mainDoneDueDateOrNot' => isset($data1->ins_main_due_status) ? $data1->ins_main_due_status : "",
                            'presentStatus' => isset($data1->ins_main_status) ? $data1->ins_main_status : "",
                            'remark' => isset($data1->ins_main_remark) ? $data1->ins_main_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'dateOfMaintenance' => "",
                        'mainDoneDueDateOrNot' => "",
                        'presentStatus' => "",
                        'remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function thirdEditInspFormCleanAmb_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo');
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormCleanAmb($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->ins_clean_date == '' || $data1->ins_clean_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->ins_clean_date));
                    }
                    $this->response([
                        'data' => [
                            'ins_clean_date' => $WorkingDate,
                            'ins_clean_remark' => isset($data1->ins_clean_remark) ? $data1->ins_clean_remark : "",
                            'ins_clean_status' => isset($data1->ins_clean_status) ? $data1->ins_clean_status : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'ins_clean_date' => "",
                        'ins_clean_remark' => "",
                        'ins_clean_status' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function fourthEditInspFormAC_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //4
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormAC($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->ac_working_date == '' || $data1->ac_working_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->ac_working_date));
                    }
                    $this->response([
                        'data' => [
                            'ac_working_date' => $WorkingDate,
                            'ac_status' => isset($data1->ac_status) ? $data1->ac_status : "",
                            'ac_remark' => isset($data1->ac_remark) ? $data1->ac_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'ac_working_date' => "",
                        'ac_status' => "",
                        'ac_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function fifthEditInspFormTyre_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //5
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormTyre($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->tyre_working_date == '' || $data1->tyre_working_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->tyre_working_date));
                    }
                    $this->response([
                        'data' => [
                            'tyre_status' => isset($data1->tyre_status) ? $data1->tyre_status : "",
                            'tyre_working_date' => $WorkingDate,
                            'tyre_remark' => isset($data1->tyre_remark) ? $data1->tyre_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'tyre_status' => "",
                        'tyre_working_date' => "",
                        'tyre_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function sixEditInspFormSiren_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormSiren($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->siren_working_date == '' || $data1->siren_working_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->siren_working_date));
                    }
                    $this->response([
                        'data' => [
                            'siren_status' => isset($data1->siren_status) ? $data1->siren_status : "",
                            'siren_working_date' => $WorkingDate,
                            'siren_remark' => isset($data1->siren_remark) ? $data1->siren_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'siren_status' => "",
                        'siren_working_date' => "",
                        'siren_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function sevenEditInspFormInventory_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormInventory($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->inv_working_date == '' || $data1->inv_working_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->inv_working_date));
                    }
                    $this->response([
                        'data' => [
                            'inv_status' => isset($data1->inv_status) ? $data1->inv_status : "",
                            'inv_working_date' => $WorkingDate,
                            'inv_remark' => isset($data1->inv_remark) ? $data1->inv_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'inv_status' => "",
                        'inv_working_date' => "",
                        'inv_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function eightEditInspFormBattery_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormBattery($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->batt_working_date == '' || $data1->batt_working_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->batt_working_date));
                    }
                    $this->response([
                        'data' => [
                            'batt_status' => isset($data1->batt_status) ? $data1->batt_status : "",
                            'batt_working_date' => $WorkingDate,
                            'batt_remark' => isset($data1->batt_remark) ? $data1->batt_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'batt_status' => "",
                        'batt_working_date' => "",
                        'batt_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function nineEditInspFormGPS_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormGPS($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->gps_working_date == '' || $data1->gps_working_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->gps_working_date));
                    }
                    $this->response([
                        'data' => [
                            'gps_status' => isset($data1->gps_status) ? $data1->gps_status : "",
                            'gps_working_date' => $WorkingDate,
                            'gps_remark' => isset($data1->gps_remark) ? $data1->gps_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'gps_status' => "",
                        'gps_working_date' => "",
                        'gps_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function tenEditInspFormPCRReg_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormPCRReg($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->ins_pcs_stock_date == '' || $data1->ins_pcs_stock_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->ins_pcs_stock_date));
                    }
                    $this->response([
                        'data' => [
                            'ins_pcs_stock_status' => isset($data1->ins_pcs_stock_status) ? $data1->ins_pcs_stock_status : "",
                            'ins_pcs_stock_date' => $WorkingDate,
                            'ins_pcs_stock_remark' => isset($data1->ins_pcs_stock_remark) ? $data1->ins_pcs_stock_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'ins_pcs_stock_status' => "",
                        'ins_pcs_stock_date' => "",
                        'ins_pcs_stock_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function elevenEditInspFormSigAtndSheet_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $data = $this->Inspection_model->getEditInspFormSigAtndSheet($inspUnqId,$formNo);
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1->upload_video_path != '' || $data1->upload_video_path != null){
                        $video = base_url('/insp_upload_file/'.$data1->upload_video_path);
                    }else{
                        $video = "";
                    }
                    if($data1->upload_img_path != '' || $data1->upload_img_path != null){
                        $img = base_url('/insp_upload_file/'.$data1->upload_img_path);
                    }else{
                        $img = "";
                    }
                    if($data1->ins_sign_attnd_date == '' || $data1->ins_sign_attnd_date == "0000-00-00 00:00:00"){
                        $WorkingDate = '';
                    }else{
                        $WorkingDate = date('Y-m-d',strtotime($data1->ins_sign_attnd_date));
                    }
                    $this->response([
                        'data' => [
                            'ins_sign_attnd_date' => $WorkingDate,
                            'ins_sign_attnd_due_status' => isset($data1->ins_sign_attnd_due_status) ? $data1->ins_sign_attnd_due_status : "",
                            'ins_sign_attnd_status' => isset($data1->ins_sign_attnd_status) ? $data1->ins_sign_attnd_status : "",
                            'ins_sign_attnd_remark' => isset($data1->ins_sign_attnd_remark) ? $data1->ins_sign_attnd_remark : "",
                            'uploadedimages' => $img,
                            'video' => $video,
                        ],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [
                        'ins_sign_attnd_date' => "",
                        'ins_sign_attnd_due_status' => "",
                        'ins_sign_attnd_status' => "",
                        'ins_sign_attnd_remark' => "",
                        'uploadedimages' => "",
                        'video' => "",
                    ],
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
    public function tweleInspFormMedicineEdit_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $medTypeId =  $this->post('medTypeId');
            $medData = $this->Inspection_model->getMedListAsPerInspId($inspUnqId,$medTypeId);
            $amb_type = $this->Common_model->getAmbType($inspUnqId);
            if(!empty($amb_type)){
                $med_List = $this->Common_model->getmedicinelist($medTypeId,$amb_type[0]);
            }
            // print_r($med_List);
            if(isset($med_List)){
                
                // print_r($medData1);die;
                $a = array();
                if(!empty($medData)){
                    $medData1 = json_decode($medData[0]->medList);
                    foreach($med_List as $key=>$med_List1){
                        if(!empty($medData1)){
                            for($i=0;$i<count($medData1);$i++){
                                if($med_List1->med_id == $medData1[$i]->med_id){
                                    $med['med_id'] = $medData1[$i]->med_id;
                                    $med['med_title'] = $med_List1->med_title;
                                    $med['med_stock'] = $med_List1->exp_stock;
                                    $med['ins_id'] = $inspUnqId;
                                    $med['med_status'] = $medData1[$i]->med_status;
                                    $med['med_qty'] = $medData1[$i]->med_qty;
                                    array_push($a,$med);
                                }
                            }
                        }
                    }
                }
                $b = array();
                foreach($med_List as $key=>$med_List1){
                    $med['med_id'] = $med_List1->med_id;
                    $med['med_title'] = $med_List1->med_title;
                    $med['med_stock'] = $med_List1->exp_stock;
                    $med['ins_id'] = $inspUnqId;
                    $med['med_status'] = "";
                    $med['med_qty'] = "";
                    array_push($b,$med);
                }

                $tmpArray = array();
                foreach ($b as $key_1 => $b1) {
                    $duplicate = false;
                    foreach($a as $a1) {
                        if($b1['med_id'] == $a1['med_id']) $duplicate = true;
                      }
                    
                      if($duplicate == false) $tmpArray[] = $b1;

                }
                $c = array_merge($a,$tmpArray);
                $this->response( $c
                ,REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => [],
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
    public function thirteenInspFormEquipmentEdit_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $eqpTypeId =  $this->post('eqpTypeId');
            $eqpData = $this->Inspection_model->getEqpListAsPerInspId($inspUnqId,$eqpTypeId);
            $amb_type = $this->Common_model->getAmbType($inspUnqId);
            if(!empty($amb_type)){
                $eqp_List = $this->Common_model->getequipmentlist($eqpTypeId,$amb_type[0]);
            }
            
            //print_r($eqpData);
            if(isset($eqp_List)){
                
                // print_r($eqp_List);die;
                $a = array();
                if(!empty($eqpData)){
                    // print_r($eqpData);
                    $eqpData1 = json_decode($eqpData[0]->eqpList);
                    foreach($eqp_List as $key=>$eqp_List1){
                        if(!empty($eqpData1)){
                            for($i=0;$i<count($eqpData1);$i++){
                                if($eqp_List1->eqp_id == $eqpData1[$i]->eqp_id){
                                    $eqp['eqp_id'] = $eqpData1[$i]->eqp_id;
                                    $eqp['ins_id'] = $inspUnqId;
                                    $eqp['eqp_name'] = $eqp_List1->eqp_name;
                                    $eqp['eqp_status'] = $eqpData1[$i]->eqp_status;
                                    $eqp['eqp_status_oprational'] = $eqpData1[$i]->eqp_status_oprational;
                                    $eqp['eqp_status_date_from'] = $eqpData1[$i]->eqp_status_date_from;
                                    array_push($a,$eqp);
                                }
                            }
                        }
                    }
                }
                $b = array();
                foreach($eqp_List as $key=>$eqp_List1){
                    $eqp['eqp_id'] = $eqp_List1->eqp_id;
                    $eqp['ins_id'] = $inspUnqId;
                    $eqp['eqp_name'] = $eqp_List1->eqp_name;
                    $eqp['eqp_status'] = "";
                    $eqp['eqp_status_oprational'] = "";
                    $eqp['eqp_status_date_from'] = "";
                    array_push($b,$eqp);
                }

                $tmpArray = array();
                foreach ($b as $key_1 => $b1) {
                    $duplicate = false;
                    foreach($a as $a1) {
                        if($b1['eqp_id'] == $a1['eqp_id']) $duplicate = true;
                      }
                    
                      if($duplicate == false) $tmpArray[] = $b1;

                }
                $c = array_merge($a,$tmpArray);
                $this->response( $c
                ,REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
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
    public function thirteenInspFormEqpEditImgVid_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $formNo = $this->post('formNo');
            $rec = $this->Inspection_model->getImgVidInsp($inspUnqId,$formNo);
            if(!empty($rec)){
                $img = explode(",",$rec[0]['upload_img_path']);
                $url = base_url().'insp_upload_file/';
                $image = array();
                if(!empty($img[0])){
                    foreach($img as $img1){
                        $imgpath['img'] = $url.$img1;
                        array_push($image, $imgpath);
                    }
                }else{
                    $image = [];
                }
                if(!empty($rec[0]['upload_video_path'])){
                    $video = $url.$rec[0]['upload_video_path'];
                }else{
                    $video = "";
                }
                $this->response([
                    'data' => [
                        "image" => $image,
                        'video' => $video
                    ],
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => [
                        "image" => [],
                        'video' => ""
                    ],
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
    public function editeqipmentremark_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Inspection_model->getdetailslistofinspection($inspUnqId);
            //print_r($viewdata);die;
            if(!empty($viewdata)){
                $finalArray = array(
                    'eqpMajorRemark' => $viewdata[0]->eqp_major_remark,
                    'eqpMinorRemark' => $viewdata[0]->eqp_minor_remark,
                    'eqpCriticalRemark' => $viewdata[0]->eqp_critical_remark
                );
                $this->response([
                    'data' => ([$finalArray]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        "code" => 1,
                        "message" => "Inspection Unique Id Does Not Exist"
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
    public function editmedicineremark_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $viewdata = $this->Inspection_model->getdetailslistofinspection($inspUnqId);
            if(!empty($viewdata)){
                $finalArray = array(
                    'medInjectableRemark' => $viewdata[0]->med_Remark,
                    'medTabletsRemark' => $viewdata[0]->tab_med_Remark,
                    'medConsumableRemark' => $viewdata[0]->cons_med_Remark
                );
                $this->response([
                    'data' => ([$finalArray]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        "code" => 1,
                        "message" => "Inspection Unique Id Does Not Exist"
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
}