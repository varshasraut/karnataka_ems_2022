<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_amb_details_list extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_Dashboard_list_model','supervisory_app_api_models/Supervisory_Login_model'));
        // $this->load->model('supervisory_app_api_models/Display_model');
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
       
    }
    public function index_post(){

        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $data1['date'] = $this->post('date');
        $data1['param'] = $this->post('param');
        $date = $this->post('date');
       

        
        // echo "<pre>";print_r($data1);die;
        $current_date = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
        $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
       
        $databoard_data = array();
        if($data1['param']=="amb_offroad"){
        $amb_offroad = array('system_type' => array('108','102'),'status' => array('7'),'date'=> $date);
        $databoard_data['preventive'] = $this->Supervisory_Dashboard_list_model->get_offroad_preventive_list($amb_offroad);
        $databoard_data['tyre'] = $this->Supervisory_Dashboard_list_model->get_offroad_tyre_list($amb_offroad);
        $databoard_data['accidental'] = $this->Supervisory_Dashboard_list_model->get_offroad_accidental_list($amb_offroad);
        $databoard_data['manpower'] = $this->Supervisory_Dashboard_list_model->get_offroad_manpower_list($amb_offroad);
        // $databoard_data['scrape'] = $this->Supervisory_Dashboard_list_model->get_offroad_scrape_list($amb_offroad);
        $databoard_data['breakdown'] = $this->Supervisory_Dashboard_list_model->get_offroad_breakdown_list($amb_offroad);
        $databoard_data['on_offroad'] = $this->Supervisory_Dashboard_list_model->get_onroad_offroad_list($amb_offroad);
        }else if($data1['param']=="amb_busy"){
            $amb_busy = array('system_type' => array('108','102'),'status' => array('2'),'date'=> $date);
        $databoard_data['amb_busy'] = $this->Supervisory_Dashboard_list_model->get_amb_list($amb_busy);
        }else if($data1['param']=="amb_available"){
            $amb_available = array('system_type' => array('108','102'),'status' => array('1'),'date'=> $date);
        $databoard_data['amb_available'] = $this->Supervisory_Dashboard_list_model->get_amb_list($amb_available);
        }else if($data1['param']=="amb_onroad"){
            $amb_onroad = array('system_type' => array('108','102'),'status' => array('1,2'),'date'=> $date);
        $databoard_data['amb_onroad'] = $this->Supervisory_Dashboard_list_model->get_amb_list($amb_onroad);
        }else if($data1['param']=="amb_sanjivni"){
            $amb_sanjivni = array('system_type' => array('108','102'),'type' => array('2,3'),'amb_status' => array('1','2'));
        $databoard_data['amb_sanjivni'] =  $this->Supervisory_Dashboard_list_model->get_amb_list_typewise($amb_sanjivni);
        }else if($data1['param']=="amb_janani"){
            $amb_janani = array('system_type' => array('108','102'),'type' =>array('1'),'amb_status' => array('1','2'));
        $databoard_data['amb_janani'] =  $this->Supervisory_Dashboard_list_model->get_amb_list_typewise($amb_janani);
        }
    
        $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){

            $viewdata = $databoard_data;
            $this->response([
                'data' => [$viewdata],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => 'login error'
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }



    public function get_offroad_type_counts_post(){

        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $data1['date'] = $this->post('date');
        $data1['param'] = $this->post('param');
        $date = $this->post('date');
       

        
        // echo "<pre>";print_r($data1);die;
        $current_date = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
        $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
       
        $databoard_data = array();
        $amb_offroad = array('system_type' => array('108','102'),'status' => array('7'),'date'=> $date);
        $offroad_data['preventive'] = $this->Supervisory_Dashboard_list_model->get_offroad_preventive_count($amb_offroad);
        $offroad_data['tyre'] = $this->Supervisory_Dashboard_list_model->get_offroad_tyre_count($amb_offroad);
        $offroad_data['accidental'] = $this->Supervisory_Dashboard_list_model->get_offroad_accidental_count($amb_offroad);
        $offroad_data['manpower'] = $this->Supervisory_Dashboard_list_model->get_offroad_manpower_count($amb_offroad);
        // $databoard_data['scrape'] = $this->Supervisory_Dashboard_list_model->get_offroad_scrape_count($amb_offroad);
        $offroad_data['breakdown'] = $this->Supervisory_Dashboard_list_model->get_offroad_breakdown_count($amb_offroad);
        $offroad_data['on_offroad'] = $this->Supervisory_Dashboard_list_model->get_onroad_offroad_count($amb_offroad);
     
    
        $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){

            $offroaddata = $offroad_data;
            $this->response([
                'data' => [$offroaddata],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => 'login error'
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    function moneyFormatIndia($num) {
        $explrestunits = "" ;
        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }

}