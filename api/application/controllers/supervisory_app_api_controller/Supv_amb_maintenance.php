<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supv_amb_maintenance extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supv_amb_maintenance_model','supervisory_app_api_models/Supervisory_Login_model'));
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
        $report_type= $this->post('type');
        // echo "<pre>";print_r($report_type);die;
        
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        if($report_type=="month"){
            $amb_offroad = array('report_type' =>$report_type,'system_type' => array('108','102'),'status' => array('7'),'from_date' => date('Y-m-d',strtotime($current_month_date)),'to_date' => date('Y-m-t', strtotime($current_month_date)));
            
        }else  if($report_type=="date"){
            $amb_offroad = array('report_type' =>$report_type,'system_type' => array('108','102'),'status' => array('7'),'from_date' => date('Y-m-d',strtotime($date)),'to_date' => date('Y-m-d', strtotime($date)));
            
        }else if($report_type=="total"){
            $amb_offroad = array('report_type' =>$report_type,'system_type' => array('108','102'),'status' => array('7'),'from_date' => date('Y-m-d',strtotime($current_month_date)),'to_date' => date('Y-m-t', strtotime($current_month_date)));
           
        }
       
        $databoard_data = array();
        // $amb_offroad = array('system_type' => array('108','102'),'status' => array('7,11'),'date'=> $date);
        $offroad_data['preventive'] = $this->Supv_amb_maintenance_model->get_offroad_preventive_list($amb_offroad);
        $offroad_data['tyre'] = $this->Supv_amb_maintenance_model->get_offroad_tyre_list($amb_offroad);
        $offroad_data['accidental'] = $this->Supv_amb_maintenance_model->get_offroad_accidental_list($amb_offroad);
        $offroad_data['breakdown'] = $this->Supv_amb_maintenance_model->get_offroad_breakdown_list($amb_offroad);
        // $offroad_data['manpower'] = $this->Supervisory_Dashboard_list_model->get_offroad_manpower_count($amb_offroad);
        // $databoard_data['scrape'] = $this->Supervisory_Dashboard_list_model->get_offroad_scrape_count($amb_offroad);
        // $offroad_data['on_offroad'] = $this->Supervisory_Dashboard_list_model->get_onroad_offroad_count($amb_offroad);
     
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