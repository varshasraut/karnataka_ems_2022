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
        $this->load->model('Common_model');
        $this->load->helper('string');
        $this->load->helper('number');
    }
    public function index_post(){
        $data = $this->Common_model->getmedicine();
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function equipment_post(){
        $id = $this->post('equpId');
        $data = $this->Common_model->getequipment($id);
        $this->response($data , REST_Controller::HTTP_OK);
    }
    public function district_post(){
        $dst_state = 'MH';
        $data = $this->Common_model->getdistrict($dst_state);
        $this->response($data , REST_Controller::HTTP_OK);
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
        $data = $this->Common_model->getinspectioncompleted();
        $this->response([
            'data' => (int) $data,
            'error' => null
        ],REST_Controller::HTTP_UNAUTHORIZED);
    }
    public function inspectioninprogress_post(){
        $data = $this->Common_model->getinspectioninprogress();
        $this->response([
            'data' => (int) $data,
            'error' => null
        ],REST_Controller::HTTP_UNAUTHORIZED);
    }
}