<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Latlong extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
	$cookie = $this->encryption->decrypt($_COOKIE['cookie']);
        $cookie1 = explode(' ', $cookie);
        if($cookie1[0] == 'MH'){
            $type = '3';
            $logindata = $this->user->get_login_for_latlng($cookie,$type);
            
            if(!empty($logindata)){
                $driver = array();
                $emt = array();
                foreach($logindata as $logindata1){
                    if($logindata1['login_type'] == 'D'){
                        array_push($driver,$logindata1['clg_id']);
                    }else if($logindata1['login_type'] == 'P'){
                        array_push($emt,$logindata1['clg_id']);
                    }
                }
                if(!empty($driver)){
                    $data['pilot_id'] = $driver[0];
                }
                if(!empty($emt)){
                    $data['emt_id'] = $emt[0];
                }
            }
        }else{
            $type = '';
            $logindata = $this->user->get_login_for_latlng($cookie,$type);
            if(!empty($logindata)){
                $driver = array();
                $emt = array();
                if($logindata[0]['login_type'] == 'D'){
                    array_push($driver,$logindata[0]['clg_id']);
                }else if($logindata[0]['login_type'] == 'P'){
                    array_push($emt,$logindata[0]['clg_id']);
                }
                if(!empty($driver)){
                    $data['pilot_id'] = $driver[0];
                }
                if(!empty($emt)){
                    $data['emt_id'] = $emt[0];
                }
            }
        }
	
        $data['vehicleNumber'] = $this->post('vehicleNumber');
        $data['lat'] = $this->post('lat');
        $data['long'] = $this->post('long');
        $data['incidenceId'] = $this->post('incidenceId') == '-1' || $this->post('incidenceId') == '' ? '' : $this->post('incidenceId');
        $data['ignition'] = $this->post('ignition');
        $data['packetdatetime'] = $this->post('packetdatetime');
        $data['speed'] = $this->post('speed');
        $data['gps_status'] = $this->post('gpsStatus');
        $latlong = $this->user->insertLatLong($data);
        $this->user->UpdateLatLong($data);
        if($latlong == 1){
            $this->response([
                'data' => array(
                    'message' => 'Insert Successfully'
                ),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => array(
                    'message' => 'Not Inserted'
                ),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
}