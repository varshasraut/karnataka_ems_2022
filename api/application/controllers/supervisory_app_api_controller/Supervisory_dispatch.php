<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_dispatch extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_Dispatch_model','supervisory_app_api_models/Supervisory_Login_model'));
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
        $data1['type'] = $this->post('type');
        $report_type= $this->post('type');
        $zone= $this->post('zone');
        $date = $this->post('date');
        // print_r($date);die;
        $username = $this->post('username');
       
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        // print_r($current_month_date);die;
        if($report_type=="month"){
           
        $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'));
        }else  if($report_type=="date"){
           
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
            'to_date' => date('Y-m-d', strtotime($date)),'system_type' => array('108','102'));
        }else if($report_type=="total"){
            $prev_count=355526;
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
            'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'));
        }
    
        $current_date = date('Y-m-d');
    
        
        $arg_till_date = array('date_type'=>'to','date'=>$date);
        $databoard_data = array();
        $databoard_data1 = array();
       
           
        $databoard_data['total_dispatch'] =  $this->Supervisory_Dispatch_model->get_total_dispatch($month_report_args);

        $databoard_data['start_frm_base']  =  $this->Supervisory_Dispatch_model->get_total_start_frm_base($month_report_args);
        $databoard_data['at_scene']  =  $this->Supervisory_Dispatch_model->get_total_at_scene($month_report_args);
        $databoard_data['at_destination']  =  $this->Supervisory_Dispatch_model->get_total_at_destination($month_report_args);
        $databoard_data['back_to_base']  =  $this->Supervisory_Dispatch_model->get_total_back_to_base($month_report_args);
        $databoard_data['pending_closure']  =  $this->Supervisory_Dispatch_model->get_total_pending_closure($month_report_args);
        $databoard_data['pending_validation']  =  $this->Supervisory_Dispatch_model->get_total_pending_validation($month_report_args);
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