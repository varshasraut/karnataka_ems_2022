<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Common_controller extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('Common_model','Inspection_model','Login_model'));
        $this->load->helper('string');
        $this->load->helper('number');
    }
    public function index_post(){
        $medTypeId = $this->post('medTypeId');
        $data = $this->Common_model->getmedicine($medTypeId);
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function equipment_post(){
        $id = $this->post('equpId');
        $data = $this->Common_model->getequipment($id);
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function district_post(){
        $dst_state = 'MP';
        $username =  $this->post('username');
        $userdis = $this->Common_model->getdistid($username);
        $data = $this->Common_model->getdistrict($dst_state);
        $defdis = array();
        if(isset($userdis)){
            $userdisid = json_decode($userdis[0]['clg_district_id']);
            $userdisidCount =  sizeof($userdisid);
            foreach($data as $data1){
                $defdis1['dst_code'] = $data1->dst_code;
                $defdis1['dst_name'] = $data1->dst_name;
                $defdis1['dst_state'] = $data1->dst_state;
                if($userdisidCount == 1){
                    if($userdisid == $data1->dst_code){
                        $defdis1['is_selected'] = 1;
                    }else{
                        $defdis1['is_selected'] = 0;
                    }
                }else{
                    $defdis1['is_selected'] = 0;
                }
                array_push($defdis,$defdis1);
            }
        }
        
        $this->response($defdis , REST_Controller::HTTP_OK);
    }
    public function ambulance_post(){
        $dst_code =  $this->post('distCode');
        $data = $this->Common_model->getambulance($dst_code);
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function emso_post(){
        $data = $this->Common_model->getemso();
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function pilot_post(){
        $data = $this->Common_model->getpilot();
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function grievancetype_post(){
        $data = $this->Common_model->getgrievancetype();
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function grievancerelatedto_post(){
        $grievanceId =  $this->post('grievanceTypeId');
        $data = $this->Common_model->getgrievancerelatedto($grievanceId);
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function enableloginbtn_post(){
        $data = $this->Common_model->getenableloginbtn();
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function inspectioncompleted_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $username = $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspInproCount = $this->Common_model->getinspectioninprogress($username);
            $inspCompletedCount = $this->Common_model->getinspectioncompleted($username);
            $grivInprogressCount = $this->Common_model->getgrivinprogress($username);
            $grivCompletedCount = $this->Common_model->getgrivcompleted($username);
            $finalArray = array(
                'inspInproCount' => (int) $inspInproCount,
                'inspCompletedCount' => (int) $inspCompletedCount,
                'grivInprogressCount' => (int) $grivInprogressCount,
                'grivCompletedCount' => (int) $grivCompletedCount
            );
            $this->response([
                'data' => ([$finalArray]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    // public function inspectioninprogress_post(){
    //     $data = $this->Common_model->getinspectioninprogress();
    //     $this->response([
    //         'data' => (int) $data,
    //         'error' => null
    //     ],REST_Controller::HTTP_OK);
    // }
    public function onchangeChkAmbStatus_post(){
        $vehicleNumber =  $this->post('vehicleNumber');
        $check_insp_inpro = $this->Inspection_model->check_insp_inpro($vehicleNumber);
        if(empty($check_insp_inpro)){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Completed'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 1,
                    'inspUnqId' => $check_insp_inpro[0]->id,
                    'message' => 'Previous inspection is in-progress'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
    public function colorcodeinspform_post(){
        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){
            $inspUnqId =  $this->post('inspUnqId');
            $rec = $this->Common_model->getColorCodeInspForm($inspUnqId);
            if(!empty($rec)){
                $this->response([
                    'data' => (
                        $rec
                    ),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([array(
                        'form_color_veh_main' => '',
                        'form_color_veh_cleanliness' => '',
                        'form_color_ac' => '',
                        'form_color_tyre' => '',
                        'form_color_siren' => '',
                        'form_color_inventory' => '',
                        'form_color_battery' => '',
                        'form_color_gps' => '',
                        'form_color_pcr' => '',
                        'form_color_sig_attend' => '',
                        'form_color_med_inj' => '',
                        'form_color_med_tab' => '',
                        'form_color_med_consu' => '',
                        'form_color_eqp_minor' => '',
                        'form_color_eqp_major' => '',
                        'form_color_eqp_critical' => '',
                        'form_color_eqp_img_vid' => '',
                    )]),
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