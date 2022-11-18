<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Inspection extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('Inspection_model','Login_model'));
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
    }
    public function index_post(){
        // echo 'jjj';die;
        $data['login_secret_key'] =  $this->post('loginSecretKey');
        $data['device_id'] =  $this->post('uniqueId');
        $data['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data);
        if($auth == 1){
            $vehicleNumber =  $this->post('vehicleNumber');
            $ambCurrentStatus =  $this->post('ambCurrentStatus');
            $gpsworking =  $this->post('gpsworking');
            $kilometerreading =  $this->post('kilometerreading');
            $emsopres =  $this->post('emsopres');
            $district =  $this->post('district');
            $pilotpres =  $this->post('pilotpres');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $formNo = $this->post('formNo');
            $vehicleData = $this->Inspection_model->getambdetails($vehicleNumber);
            $check_insp_inpro = $this->Inspection_model->check_insp_inpro($vehicleNumber);
            if(isset($vehicleNumber) && isset($ambCurrentStatus) && isset($gpsworking) && isset($emsopres) && isset($pilotpres) && isset($lat) && isset($long)){
                if(empty($check_insp_inpro)){
                    if(isset($vehicleData)){
                        $insp['ins_state'] = $vehicleData[0]['amb_state'];
                        $insp['ins_dist'] = $vehicleData[0]['amb_district'];
                        $insp['ins_amb_no'] = $vehicleNumber;
                        $insp['ins_baselocation'] = $vehicleData[0]['hp_name'];
                        $insp['ins_amb_type'] = $vehicleData[0]['amb_type'];
                        $insp['ins_amb_model'] = $vehicleData[0]['vehical_make_type'];
                        $insp['ins_amb_current_status'] = $ambCurrentStatus;
                        $insp['ins_gps_status'] = $gpsworking;
                        $insp['ins_pilot'] = $pilotpres;
			$insp['added_by_source'] = 'MDT';
                        if($emsopres == ''){
                            $emsostatus = 'NA';
                        }else{
                            $emsostatus = $emsopres;
                        }
                        $insp['ins_emso'] = $emsostatus;
                        $insp['ins_odometer'] =  isset($kilometerreading) ? (int) $kilometerreading : (int) '';
                        $insp['ins_app_lat_firstform'] =  $lat;
                        $insp['ins_app_lng_firstform'] =  $long;
                        $insp['ins_app_status'] =  '1';
                        $insp['added_date'] =  date('Y-m-d H:i:s');
                        $insp['added_by'] =  $data['username'];
                        $addinspectionfirstform = $this->Inspection_model->addinspectionfirstform($insp);
                        $latlong['insp_id'] = $addinspectionfirstform;
                        $latlong['lat'] = $lat;
                        $latlong['lng'] = $long;
                        $latlong['form_no'] = $formNo;
                        $addinspfirstformlatlng = $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $formColor['form_color_added_date'] = date('Y-m-d H:i:s');
                        $this->Inspection_model->addFormColor($formColor,$addinspectionfirstform);
                        if($addinspfirstformlatlng == 1){
                            $this->response([
                                'data' => ([
                                    'inspUnqId' => $addinspectionfirstform,
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Previous inspection is in-progress'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function secondInspFormMainVeh_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId = $this->post('inspUnqId');
            $dateOfMaintenance = $this->post('dateOfMaintenance');
            $mainDoneDueDateOrNot = $this->post('mainDoneDueDateOrNot'); //Yes,No
            $presentStatus = $this->post('presentStatus'); //Completed,In_Progress,Pending
            $remark = $this->post('remark');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $formNo = $this->post('formNo'); //2
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $data['ins_main_date'] = $dateOfMaintenance;
            $data['ins_main_due_status'] = $mainDoneDueDateOrNot;
            $data['ins_main_status'] = $presentStatus;
            $data['ins_main_remark'] = $remark;
            if(isset($dateOfMaintenance) && isset($mainDoneDueDateOrNot) && isset($presentStatus) && isset($remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                $formColor['form_color_veh_main'] = '1';
                $formColor['form_color_added_date'] = date('Y-m-d H:i:s');
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $img['upload_img_path'] = '';
                        $img['upload_video_path'] = '';
                        $img['form_no'] = $formNo;
                        $img['chkUploadImg'] = $chkUploadImg;
                        $img['chkUploadVideo'] = $chkUploadVideo;
                        $this->Inspection_model->editImgVidUpload($img,$inspUnqId,$formNo);
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                        $img['upload_img_path'] = '';
                        $img['chkUploadImg'] = $chkUploadImg;
                        $img['chkUploadVideo'] = '';
                        $img['form_no'] = $formNo;
                        $this->Inspection_model->editImgVidUpload($img,$inspUnqId,$formNo);
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                        $img['chkUploadVideo'] = $chkUploadVideo;
                        $img['chkUploadImg'] = '';
                        $img['upload_video_path'] = '';
                        $img['form_no'] = $formNo;
                        $this->Inspection_model->editImgVidUpload($img,$inspUnqId,$formNo);
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            // $insp['ins_main_date'] = $predata['ins_main_date'];
                            // $insp['ins_main_due_status'] = $predata['ins_main_due_status'];
                            // $insp['ins_main_status'] = $predata['ins_main_status'];
                            // $insp['ins_main_remark'] = $predata['ins_main_remark'];
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function thirdInspFormCleanAmb_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $ins_clean_date =  $this->post('ins_clean_date');
            $ins_clean_status =  $this->post('ins_clean_status'); //Yes,No
            $ins_clean_remark =  $this->post('ins_clean_remark');
            $formNo = $this->post('formNo'); //3
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['ins_clean_date'] = $ins_clean_date;
            $data['ins_clean_status'] = $ins_clean_status;
            $data['ins_clean_remark'] = $ins_clean_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_veh_cleanliness'] = '1';
            if(isset($ins_clean_date) && isset($ins_clean_status) && isset($ins_clean_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function forthInspFormAC_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $ac_status =  $this->post('ac_status');
            $ac_working_date =  $this->post('ac_working_date'); 
            $ac_remark =  $this->post('ac_remark');
            $formNo = $this->post('formNo'); //4
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['ac_status'] = $ac_status; //Not_Working,Working
            $data['ac_working_date'] = ($ac_working_date) ? $ac_working_date : Null;
            $data['ac_remark'] = $ac_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_ac'] = '1';
            if(isset($ac_status) && isset($ac_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function fifthInspFormTyre_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $tyre_status =  $this->post('tyre_status');
            $tyre_working_date =  $this->post('tyre_working_date'); //Yes,No
            $tyre_remark =  $this->post('tyre_remark');
            $formNo = $this->post('formNo'); //5
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['tyre_status'] = $tyre_status; //Not_Replaced,Replaced
            $data['tyre_working_date'] = ($tyre_working_date) ? $tyre_working_date : Null;
            $data['tyre_remark'] = $tyre_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_tyre'] = '1';
            // echo $tyre_status;die;
            if(isset($tyre_status) && isset($tyre_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function sixInspFormSiren_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $siren_status =  $this->post('siren_status');
            $siren_working_date =  $this->post('siren_working_date'); //Yes,No
            $siren_remark =  $this->post('siren_remark');
            $formNo = $this->post('formNo'); //6
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['siren_status'] = $siren_status; //Not_Replaced,Replaced
            $data['siren_working_date'] = ($siren_working_date) ? $siren_working_date : Null;
            $data['siren_remark'] = $siren_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_siren'] = '1';
            // echo $tyre_status;die;
            if(isset($siren_status) && isset($siren_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function sevenInspFormInventory_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inv_status =  $this->post('inv_status');
            $inv_working_date =  $this->post('inv_working_date'); 
            $inv_remark =  $this->post('inv_remark');
            $formNo = $this->post('formNo'); //7
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['inv_status'] = $inv_status; //Working,Not_Working
            $data['inv_working_date'] = ($inv_working_date) ? $inv_working_date : Null;
            $data['inv_remark'] = $inv_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_inventory'] = '1';
            // echo $tyre_status;die;
            if(isset($inv_status) && isset($inv_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function eightInspFormBattery_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $batt_status =  $this->post('batt_status');
            $batt_working_date =  $this->post('batt_working_date'); 
            $batt_remark =  $this->post('batt_remark');
            $formNo = $this->post('formNo'); //8
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['batt_status'] = $batt_status; //Working,Not_Working
            $data['batt_working_date'] = ($batt_working_date) ? $batt_working_date : Null;
            $data['batt_remark'] = $batt_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_battery'] = '1';
            // echo $tyre_status;die;
            if(isset($batt_status) && isset($batt_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function nineInspFormGPS_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $gps_status =  $this->post('gps_status');
            $gps_working_date =  $this->post('gps_working_date'); 
            $gps_remark =  $this->post('gps_remark');
            $formNo = $this->post('formNo'); //9
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['gps_status'] = $gps_status; //Working,Not_Working
            $data['gps_working_date'] = ($gps_working_date) ? $gps_working_date : Null;
            $data['gps_remark'] = $gps_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_gps'] = '1';
            // echo $tyre_status;die;
            if(isset($gps_status) && isset($gps_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function tenInspFormPCRReg_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $ins_pcs_stock_date =  $this->post('ins_pcs_stock_date');
            $ins_pcs_stock_status =  $this->post('ins_pcs_stock_status'); 
            $ins_pcs_stock_remark =  $this->post('ins_pcs_stock_remark');
            $formNo = $this->post('formNo'); //10
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['ins_pcs_stock_date'] = $ins_pcs_stock_date; //Working,Not_Working
            $data['ins_pcs_stock_status'] = $ins_pcs_stock_status;
            $data['ins_pcs_stock_remark'] = $ins_pcs_stock_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_pcr'] = '1';
            // echo $tyre_status;die;
            if(isset($ins_pcs_stock_date) && isset($ins_pcs_stock_status) && isset($ins_pcs_stock_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function elevenInspFormSigAtndSheet_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $ins_sign_attnd_date =  $this->post('ins_sign_attnd_date');
            $ins_sign_attnd_due_status =  $this->post('ins_sign_attnd_due_status'); 
            $ins_sign_attnd_status =  $this->post('ins_sign_attnd_status');
            $ins_sign_attnd_remark =  $this->post('ins_sign_attnd_remark');
            $formNo = $this->post('formNo'); //11
            $inspUnqId = $this->post('inspUnqId');
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $data['ins_sign_attnd_date'] = $ins_sign_attnd_date; 
            $data['ins_sign_attnd_due_status'] = $ins_sign_attnd_due_status; //Yes,No
            $data['ins_sign_attnd_status'] = $ins_sign_attnd_status; //Completed,In_Progress,Pending
            $data['ins_sign_attnd_remark'] = $ins_sign_attnd_remark;
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            $formColor['form_color_sig_attend'] = '1';
            // echo $tyre_status;die;
            if(isset($ins_sign_attnd_date) && isset($ins_sign_attnd_due_status) && isset($ins_sign_attnd_status) && isset($ins_sign_attnd_remark)){
                $checkInspIdExist = $this->Inspection_model->checkInspIdExist($inspUnqId);
                if(!empty($checkInspIdExist)){
                    if($chkUploadImg == 'false' && $chkUploadVideo == 'false'){
                        $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                        $this->Inspection_model->addinspfirstformlatlng($latlong);
                        $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                        $this->response([
                        'data' => [
                            "code" => 1,
                            "message" => "Inserted Successfully"
                            ],
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                        exit;
                    }
                    
                    $extractpath = FCPATH . "insp_upload_file";
                    $date = date("Y_m_d");
                    if (is_dir($extractpath)) {
                    if (!is_dir($extractpath)) {
                        $mainDir = mkdir($extractpath);
                    } else {
                        $mainDir = $extractpath;
                    }
                    }
                    if(($chkUploadImg == "true")) {
                        $imageFlag = false;
                        $imageData =  $this->processImagesData($mainDir,$inspUnqId,$formNo);
                        if ($imageData == "UploadError") {
                        return $this->response([
                            'data' => $imageData,
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                        } else {
                        $imageFlag = true;
                        }
                    }else{
                        $imageFlag = false;
                    }
                    if($chkUploadVideo == "true") {
                        $videoFlag = false;
                        $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                        if ($videoData == "UploadError") {
                            return $this->response([
                                'data' => $imageData,
                                'error' => null
                                ],REST_Controller::HTTP_OK);
                        } else {
                            $videoFlag = true;
                        }
                    }else{
                        $videoFlag = false;
                    }
                    if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                        if ($videoFlag || $imageFlag) {
                            $this->Inspection_model->addinspfirstformlatlng($latlong);
                            $this->Inspection_model->insertInspSecForm($data,$inspUnqId);
                            $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                            return $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            "code" => 1,
                            "message" => "Inspection Unique Id Does Not Exist"
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function tweleInspFormMedicineAdd_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId = $this->post('inspUnqId');
            $medTypeId = $this->post('medTypeId');
            $medList = $this->post('medList');
            $postmanMob = $this->post('postmanMob');
            $remark = $this->post('remark');
            if($postmanMob == 'yes'){
                $medListRec = json_encode($medList);
            }else{
                $medListRec = $medList;
            }
            if($medTypeId == 1){ //Injectables
                $med['med_Injectables'] = $medListRec;
                $med['med_Remark'] = $remark;
                $formColor['form_color_med_inj'] = '1';
            }else if($medTypeId == 2){ //Tablets
                $med['med_Tablets'] = $medListRec;
                $med['tab_med_Remark'] = $remark;
                $formColor['form_color_med_tab'] = '1';
            }else{ //Consumables
                $med['med_Consumables'] = $medListRec;
                $med['cons_med_Remark'] = $remark;
                $formColor['form_color_med_consu'] = '1';
            }
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $formNo = $this->post('formNo'); //12
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            // echo $tyre_status;die;
            if(isset($medList) && isset($medTypeId)){
                $this->Inspection_model->insertInspEqup($med,$inspUnqId);
                $this->Inspection_model->addinspfirstformlatlng($latlong);
                $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                return $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Inserted Successfully'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function thirteenInspFormEqpAdd_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId = $this->post('inspUnqId');
            $eqpTypeId = $this->post('eqpTypeId');
            $eqpList = $this->post('eqpList');
            $postmanMob = $this->post('postmanMob');
            $remark = $this->post('remark');
            if($postmanMob == 'yes'){
                $eqpListRec = json_encode($eqpList);
            }else{
                $eqpListRec = $eqpList;
            }
            if($eqpTypeId == 1){ //Minor
                $eqp['eqp_minor'] = $eqpListRec;
                $eqp['eqp_minor_remark'] = $remark;
                $formColor['form_color_eqp_minor'] = '1';
            }else if($eqpTypeId == 2){ //Major
                $eqp['eqp_major'] = $eqpListRec;
                $eqp['eqp_major_remark'] = $remark;
                $formColor['form_color_eqp_major'] = '1';
            }else{ //Critical
                $eqp['eqp_critical'] = $eqpListRec;
                $eqp['eqp_critical_remark'] = $remark;
                $formColor['form_color_eqp_critical'] = '1';
            }
            $lat =  $this->post('lat');
            $long =  $this->post('long');
            $formNo = $this->post('formNo'); //13
            $latlong['insp_id'] = $inspUnqId;
            $latlong['lat'] = $lat;
            $latlong['lng'] = $long;
            $latlong['form_no'] = $formNo;
            // echo $tyre_status;die;

            $checkInspId = $this->Inspection_model->checkInspId($inspUnqId);
            if(isset($eqpList) && isset($eqpTypeId)){
                if(empty($checkInspId)){
                    return $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Inspection Id does not exits'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->Inspection_model->insertInspEqup($eqp,$inspUnqId);
                    $this->Inspection_model->addinspfirstformlatlng($latlong);
                    $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                    return $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => 'Inserted Successfully'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_NO_CONTENT);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function thirteenInspFormEqpImgVid_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $chkUploadImg = $this->post('chkUploadImg');
            $chkUploadVideo = $this->post('chkUploadVideo');
            $formNo = $this->post('formNo'); //13
            $inspUnqId = $this->post('inspUnqId');
            $extractpath = FCPATH . "insp_upload_file";
            $date = date("Y_m_d");
            if (is_dir($extractpath)) {
            if (!is_dir($extractpath)) {
                $mainDir = mkdir($extractpath);
            } else {
                $mainDir = $extractpath;
            }
            }
            if(($chkUploadImg == "true")) {
                $imageFlag = false;
                $imageData =  $this->processMulitipleImagesData($mainDir,$inspUnqId,$formNo);
                if ($imageData == "UploadError") {
                return $this->response([
                    'data' => $imageData,
                    'error' => null
                ],REST_Controller::HTTP_OK);
                } else {
                $imageFlag = true;
                }
            }else{
                $imageFlag = false;
            }
            if($chkUploadVideo == "true") {
                $videoFlag = false;
                $videoData = $this->processVideoData($mainDir,$inspUnqId,$formNo);
                if ($videoData == "UploadError") {
                    return $this->response([
                        'data' => $imageData,
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                } else {
                    $videoFlag = true;
                }
            }else{
                $videoFlag = false;
            }
            if($chkUploadVideo == "true" || $chkUploadImg == "true") {
                if ($videoFlag || $imageFlag) {
                    $formColor['form_color_eqp_img_vid'] = '1';
                    $this->Inspection_model->addFormColor($formColor,$inspUnqId);
                    return $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => 'Inserted Successfully'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    function processImagesData($mainDir,$inspUnqId,$formNo){
        if(isset($mainDir)){
              $files = $_FILES['uploadedimages'];
              $errors = array();
              $errorArr = array();
              if(sizeof($errors)==0)
              {
                $imgSize = 0;
                $config['upload_path'] =  $mainDir;
                $config['allowed_types'] = '*';
                  $_FILES['uploadedimage']['name'] = $files['name'];
                  $_FILES['uploadedimage']['type'] = $files['type'];
                  $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'];
                  $_FILES['uploadedimage']['error'] = $files['error'];
                  $_FILES['uploadedimage']['size'] = $files['size'];
                 
                  
                  $ext = explode(".", $files['name']);
                  $_FILES['uploadedimage']['name'] = $inspUnqId."_".date('Y_m_d_H_i_s') . "." . $ext[1];
                  $image = $inspUnqId."_".date('Y_m_d_H_i_s') . "." . $ext[1];
                
                  $this->upload->initialize($config);
                  if (! $this->upload->do_upload('uploadedimage')) {
                    $data['upload_errors'] = $this->upload->display_errors();
                    $errorArr[] = $data['upload_errors'];
                  }
                  
                  unset($ext, $imageFileName);
                // }
                
                if (empty($errorArr)) {
                    $img['upload_img_path'] = $image;
                    $img['form_no'] = $formNo;
                    // $insp['ins_main_date'] = $predata['ins_main_date'];
                    // $insp['ins_main_due_status'] = $predata['ins_main_due_status'];
                    // $insp['ins_main_status'] = $predata['ins_main_status'];
                    // $insp['ins_main_remark'] = $predata['ins_main_remark'];
                    // $this->Inspection_model->insertInspSecForm($insp,$inspUnqId);
                    $this->Inspection_model->insertInspSecFormFile($img,$inspUnqId,$formNo);
                    
                    return "uploadSuccess";
                  
                } else {
                return "UploadError@#@";
                  
                }
     
              }
              else{
                return $this->response([
                  'data' => $errors,
                  'error' => null
                ],REST_Controller::HTTP_OK);
              }
          }
    }
    function processVideoData($mainDir,$inspUnqId,$formNo){
        // print_r($data);die;
        $configVideo['upload_path'] = FCPATH . 'insp_upload_file';
        $configVideo['max_size'] = '20000000';
        $configVideo['allowed_types'] = '*';
        $configVideo['overwrite'] = FALSE;
        $configVideo['remove_spaces'] = TRUE;
        $video_name = random_string('numeric', 5);
        $configVideo['file_name'] = $inspUnqId. '_' .date('Y_m_d_H_i_s') . '_' .$video_name;
        $configVideo['client_name'] = $inspUnqId. '_' .date('Y_m_d_H_i_s') . '_' .$video_name;
        $this->upload->initialize($configVideo);
        // print_r($configVideo);die;
        if ($this->upload->do_upload('video') === FALSE) 
        {
            return "UploadError@#@";
        } else {
            $data1 = $this->upload->data();
            $full_path = $data1['full_path']; 
            $extractpath = $mainDir;
            // echo $full_path;die;
            if ($full_path == TRUE)
            {
                $VideoName = $data1['file_name'];
                $video['upload_video_path'] = $VideoName;
                $video['form_no'] = $formNo;
                // $insp['ins_main_date'] = $predata['ins_main_date'];
                // $insp['ins_main_due_status'] = $predata['ins_main_due_status'];
                // $insp['ins_main_status'] = $predata['ins_main_status'];
                // $insp['ins_main_remark'] = $predata['ins_main_remark'];
                //  $this->Inspection_model->insertInspSecForm($insp,$inspUnqId);
                 $this->Inspection_model->insertInspSecFormVideoFile($video,$inspUnqId,$formNo);
                $a = "uploadSuccess";
                return  $a;
                
            }  
        }
    }
    public function submitlastinspectionform_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $forwToGriv =  $this->post('forwToGriv');
            $remark =  $this->post('remark');
            $inspUnqId = $this->post('inspUnqId');
            $medEqpRec = $this->Inspection_model->getMedEqpRec($inspUnqId);
            if(!empty($medEqpRec[0]->med_Injectables)){
                $med_Injectables = json_decode($medEqpRec[0]->med_Injectables);
                foreach($med_Injectables as $med_Injectables1){
                    $medInj['med_id'] = $med_Injectables1->med_id;
                    $medInj['ins_id'] = $med_Injectables1->ins_id;
                    $medInj['med_status'] = $med_Injectables1->med_status;
                    $medInj['med_qty'] = $med_Injectables1->med_qty;
                    $medInj['med_type'] = '1';
                    $this->Inspection_model->insertMedInj($medInj);
                }
            }
            if(!empty($medEqpRec[0]->med_Tablets)){
                $med_Tablets = json_decode($medEqpRec[0]->med_Tablets);
                foreach($med_Tablets as $med_Tablets1){
                    $medTab['med_id'] = $med_Tablets1->med_id;
                    $medTab['ins_id'] = $med_Tablets1->ins_id;
                    $medTab['med_status'] = $med_Tablets1->med_status;
                    $medTab['med_qty'] = $med_Tablets1->med_qty;
                    $medTab['med_type'] = '2';
                    $this->Inspection_model->insertMedInj($medTab);
                }
            }
            if(!empty($medEqpRec[0]->med_Consumables)){
                $med_Consumables = json_decode($medEqpRec[0]->med_Consumables);
                foreach($med_Consumables as $med_Consumables1){
                    $medConsu['med_id'] = $med_Consumables1->med_id;
                    $medConsu['ins_id'] = $med_Consumables1->ins_id;
                    $medConsu['med_status'] = $med_Consumables1->med_status;
                    $medConsu['med_qty'] = $med_Consumables1->med_qty;
                    $medConsu['med_type'] = '3';
                    $this->Inspection_model->insertMedInj($medConsu);
                }
            }
            if(!empty($medEqpRec[0]->eqp_minor)){
                $eqp_minor = json_decode($medEqpRec[0]->eqp_minor);
                foreach($eqp_minor as $eqp_minor1){
                    $eqpMinor['eqp_id'] = $eqp_minor1->eqp_id;
                    $eqpMinor['ins_id'] = $eqp_minor1->ins_id;
                    $eqpMinor['status'] = $eqp_minor1->eqp_status;
                    $eqpMinor['oprational'] = $eqp_minor1->eqp_status_oprational;
                    $eqpMinor['date_from'] = $eqp_minor1->eqp_status_date_from;
                    $eqpMinor['type'] = '1';
                    $this->Inspection_model->insertEqup($eqpMinor);
                }
            }
            if(!empty($medEqpRec[0]->eqp_major)){
                $eqp_major = json_decode($medEqpRec[0]->eqp_major);
                foreach($eqp_major as $eqp_major1){
                    $eqpMajor['eqp_id'] = $eqp_major1->eqp_id;
                    $eqpMajor['ins_id'] = $eqp_major1->ins_id;
                    $eqpMajor['status'] = $eqp_major1->eqp_status;
                    $eqpMajor['oprational'] = $eqp_major1->eqp_status_oprational;
                    $eqpMajor['date_from'] = $eqp_major1->eqp_status_date_from;
                    $eqpMajor['type'] = '2';
                    $this->Inspection_model->insertEqup($eqpMajor);
                }
            }
            if(!empty($medEqpRec[0]->eqp_critical)){
                $eqp_critical = json_decode($medEqpRec[0]->eqp_critical);
                foreach($eqp_critical as $eqp_critical1){
                    $eqpCritical['eqp_id'] = $eqp_critical1->eqp_id;
                    $eqpCritical['ins_id'] = $eqp_critical1->ins_id;
                    $eqpCritical['status'] = $eqp_critical1->eqp_status;
                    $eqpCritical['oprational'] = $eqp_critical1->eqp_status_oprational;
                    $eqpCritical['date_from'] = $eqp_critical1->eqp_status_date_from;
                    $eqpCritical['type'] = '3';
                    $this->Inspection_model->insertEqup($eqpCritical);
                }
            }
            $insp['forword_grievance'] = $forwToGriv;
            $insp['remark'] = $remark;
            $insp['ins_app_status'] = '2';
            $insp['gri_status'] = '0';
            $rec = $this->Inspection_model->insertForwToGriv($inspUnqId,$insp);
            if($rec == 1){
                return $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Inserted Successfully'
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
    public function processMulitipleImagesData($mainDir,$inspUnqId,$formNo){
        if(isset($mainDir)){
            // if($chkUploadImg == "true"){
              $number_of_files = sizeof(($_FILES['uploadedimages']['tmp_name']));
              $files = $_FILES['uploadedimages'];
              $errors = array();
              $errorArr = array();
              
              for($i=0;$i<$number_of_files;$i++)
              {
                if($_FILES['uploadedimages']['error'][$i] != 0) $errors[$i][] = 'Couldn\'t upload file '.$_FILES['uploadedimages']['name'][$i];
              }
              if(sizeof($errors)==0)
              {
                $imgSize = 0;
                $config['upload_path'] =  $mainDir;
                $config['allowed_types'] = '*';
                $image1 = array();
                // print_r($config['upload_path']);die;
                for ($i = 0; $i < $number_of_files; $i++) {
                  $_FILES['uploadedimage']['name'] = $files['name'][$i];
                  $_FILES['uploadedimage']['type'] = $files['type'][$i];
                  $_FILES['uploadedimage']['tmp_name'] = $files['tmp_name'][$i];
                  $_FILES['uploadedimage']['error'] = $files['error'][$i];
                  $_FILES['uploadedimage']['size'] = $files['size'][$i];
                  // $imgSizeCal = $imgSize + $_FILES['uploadedimage']['size'];
                  // array_push($imgessize,$imgSizeCal);
                  
                  $ext = explode(".", $files['name'][$i]);
                  $_FILES['uploadedimage']['name'] = $inspUnqId."_".date('Y_m_d_H_i_s_') . $i . "." . $ext[1];
                  $image = $inspUnqId."_".date('Y_m_d_H_i_s_') . $i . "." . $ext[1];
                  array_push($image1,$image);
                  $this->upload->initialize($config);
                  if (! $this->upload->do_upload('uploadedimage')) {
                    $data['upload_errors'][$i] = $this->upload->display_errors();
                    $errorArr[] = $data['upload_errors'][$i];
                  }
                  
                  unset($ext, $imageFileName);
                }
                
                if (empty($errorArr)) {
                    $img['upload_img_path'] = implode(",",$image1);
                    $img['form_no'] = $formNo;
                    $this->Inspection_model->insertInspSecFormFile($img,$inspUnqId,$formNo);
                    return "uploadSuccess";
                } else {
                  $str = '';
                  for($j=0;$j<=count($errorArr);$j++){
                    $str .= $errorArr[$j]."##";
                  }
                  echo "UploadError@#@". $str;
                  exit;
                }
     
              }
              else{
                return $this->response([
                  'data' => $errors,
                  'error' => null
                ],REST_Controller::HTTP_OK);
              }
          }
    }
    public function checkAllFormSubmit_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId = $this->post('inspUnqId');
            $rec = $this->Inspection_model->checkAllFormSubmit($inspUnqId);
            // print_r($rec);
            $completionChk = array();
            foreach($rec as $rec1){
                while( ($rec1['form_color_veh_main'] == '2') || ($rec1['form_color_veh_cleanliness'] == 2) || ($rec1['form_color_ac'] == '2') || ($rec1['form_color_tyre'] == '2') || ($rec1['form_color_siren'] == '2') || ($rec1['form_color_inventory'] == '2') || ($rec1['form_color_battery'] == '2') || ($rec1['form_color_gps'] == '2') || ($rec1['form_color_pcr'] == '2') || ($rec1['form_color_sig_attend'] == '2') || ($rec1['form_color_eqp_minor'] == '2') || ($rec1['form_color_eqp_major'] == '2') || ($rec1['form_color_eqp_critical'] == '2')  )
                {
                    $a = '1'; //'Not Complete :- 1'
                    array_push($completionChk,$a);
                    break;
                }
            }
            if(empty($rec)){
                $a = '1'; //'Not Complete :- 1'
                array_push($completionChk,$a);
            }
            if(!empty($completionChk)){
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'Incompleted Data'
                    ])
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'code' => 2,
                        'message' => 'Completed Data'
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