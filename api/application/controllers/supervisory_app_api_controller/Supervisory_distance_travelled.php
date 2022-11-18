<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_distance_travelled extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_Distance_travelled_model','supervisory_app_api_models/Supervisory_Login_model'));
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
        $date = $this->post('date');
        // print_r($date);die;
        $username = $this->post('username');
       
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        if($report_type=="month"){
            $prev_count=0;
        $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-t', strtotime($current_month_date)));
        }else  if($report_type=="date"){
            $prev_count=0;
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
            'to_date' => date('Y-m-d', strtotime($date)));
        }else if($report_type=="total"){
            $prev_count=355526;
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
            'to_date' => date('Y-m-t', strtotime($current_month_date)));
        }
    
        $current_date = date('Y-m-d');
    
        
        $arg_till_date = array('date_type'=>'to','date'=>$date);
        $databoard_data = array();
        $district_list = array();
       
       $district_list= $this->Supervisory_Distance_travelled_model->get_district_list();
       $districtwise=array();
        // $databoard_data =  $this->Supervisory_Distance_travelled_model->get_total_distance_travelled($month_report_args);
        foreach ($district_list as $item) {
            $dist_code=$item['disti_code'];
            $databoard_data =  $this->Supervisory_Distance_travelled_model->get_total_distance_travelled($month_report_args,$dist_code);
           foreach($databoard_data as $databoard_data1){
            $rec['dist'] = $databoard_data1['dst_name'];
            if($databoard_data1['ambt_name'] == 'JE'){
                $rec['jesum'] = $databoard_data1['sum'];
                // $rec['JE'] = $databoard_data1['ambt_name'];
            }
            if($databoard_data1['ambt_name'] == 'BLS'){
                $rec['blssum'] = $databoard_data1['sum'];
                // $rec['BLS'] = $databoard_data1['ambt_name'];
            }
            if($databoard_data1['ambt_name'] == 'ALS'){
                $rec['alssum'] = $databoard_data1['sum'];
                // $rec['ALS'] = $databoard_data1['ambt_name'];
            }
           }
            // print_r(json_encode($databoard_data)); die;
            if(isset($rec)){
                array_push($districtwise,$rec);
            }else{
               
            }
            
            
        }
        // print_r($districtwise);

       
        $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){

            $viewdata = $districtwise;
          
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