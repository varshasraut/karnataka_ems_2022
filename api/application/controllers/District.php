<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class District extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->model('CommonModel');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $incidentId = $this->post('incidentId');
        $data = $this->user->getDistrict($incidentId);
        $district1 = array();
        foreach($data as $data1){
            $district['id'] = $data1['dst_code'];
            $district['name'] = $data1['dst_name'];
            array_push($district1,$district);
        }
        if(isset($_COOKIE['cookie'])){
            $this->response([
                'data' => $district1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function fueldistrict_post(){
        $vehicleNumber = $this->post('vehicleNumber');
        $veh = explode(' ',$vehicleNumber);
        $ambulanceNo = implode('-',$veh);
        $dst_state = 'MH';
        $data = $this->CommonModel->getdistrict($dst_state);
        $ambdis = $this->user->getAmbDistrict($ambulanceNo);
        $district1 = array();
        foreach($data as $data1){
            $district['id'] = $data1['dst_code'];
            $district['name'] = $data1['dst_name'];
            foreach($ambdis as $ambdis1){
                if($data1['dst_code'] == $ambdis1['amb_district']){
                    $district['is_selected'] = 1;
                }else{
                    $district['is_selected'] = 0;
                }
            }
            array_push($district1,$district);
        }
        if(isset($_COOKIE['cookie'])){
            $this->response([
                'data' => $district1,
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