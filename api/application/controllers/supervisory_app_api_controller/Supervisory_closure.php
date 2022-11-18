<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_closure extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_Closure_model','supervisory_app_api_models/Supervisory_Login_model'));
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
        $data1['division_type'] = $this->post('division_type');
        $data1['pending_type'] = $this->post('pending_type');
        $report_type= $this->post('type');
        $date = $this->post('date');
     
        $division_type = $this->post('division_type');
        // print_r($date);die;
        if($division_type=="zone"){
        $argument = $this->post('zone');
        }else if($division_type=="district"){
        $argument = $this->post('district');
        }else{
            $argument = '';
           
        }
        $username = $this->post('username');
       
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        // print_r($current_month_date);die;
        if($report_type=="month"){
            $prev_count=0;
        $month_report_args =  array('division_type'=>$division_type,'argument'=>$argument,'report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                       'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'));
        }else  if($report_type=="date"){
            $prev_count=0;
            $month_report_args =  array('division_type'=>$division_type,'argument'=>$argument,'report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
            'to_date' => date('Y-m-d', strtotime($date)),'system_type' => array('108','102'));
        }else if($report_type=="total"){
            $prev_count=355526;
            $month_report_args =  array('division_type'=>$division_type,'argument'=>$argument,'report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
            'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'));
        }
    
        $current_date = date('Y-m-d');
        $arg_till_date = array('date_type'=>'to','date'=>$date);
        $databoard_data = array();
        $databoard_data1 = array();

        if($data1['pending_type']=="closure"){
            $databoard_data['result']  =  $this->Supervisory_Closure_model->get_total_pending_closure($month_report_args);
        }else if($data1['pending_type']=="validation"){
        $databoard_data['result']  =  $this->Supervisory_Closure_model->get_total_pending_validation($month_report_args);
        }else{
            $databoard_data['result']="Missing or incorrect : 'pending_type'";
        }
        $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
        
        // zone and district list
       
        // $district_list= $this->Supervisory_Closure_model->get_district_list();
        //    print_r($databoard_data);
        // //    print_r($district_list);
        //    die;
        if($division_type=="zone"){
            $zone = $this->post('zone');
            $district_list= $this->Supervisory_Closure_model->get_district_list($zone);
            $result_data=array();
                foreach ($district_list as $item) {
                    $rec['count']=0;
                    // print_r($databoard_data['result']);die;
                    $dist_code=$item['dst_code'];
                    foreach($databoard_data['result'] as $distwise_closure){
                        //   print_r($a);die;
                        if($distwise_closure['amb_district']==$dist_code){
                            $rec['divcode'] = $distwise_closure['div_code'];
                            $rec['divname'] = $distwise_closure['div_name'];
                            $rec['distid']= $distwise_closure['amb_district'];
                            $rec['distname'] = $distwise_closure['dst_name'];
                            $rec['count'] =$distwise_closure['count']+$rec['count'];
                        }
                    }
                        if($rec['count']){
                            array_push($result_data,$rec);
                        }else{
                        
                        }

                }
        }else if($division_type=="zonewise"){
            $zone_list = $this->Supervisory_Closure_model->get_zone_list();
            $result_data=array();
            foreach ($zone_list as $zone) {
                $rec1['count']=0;
                // print_r($zone);
                $zone_code=$zone['div_code'];
                foreach($databoard_data['result'] as $zonewise_closure){
                    // print_r($zonewise_closure);die;  
                    if($zonewise_closure['div_code']==$zone_code){
                        $rec1['divcode'] = $zonewise_closure['div_code'];
                        $rec1['divname'] = $zonewise_closure['div_name'];
                        $rec1['distid']= $zonewise_closure['amb_district'];
                        $rec1['distname'] = $zonewise_closure['dst_name'];
                        $rec1['count'] =$zonewise_closure['count']+$rec1['count'];
                    }
                    
                    
                }
                    if($rec1['count']){
                        array_push($result_data,$rec1);
                    }else{
                        $databoard_data['result'];
                    }

            }
        }else if($division_type=="district"){
            $result_data=array();
            $result_data=$databoard_data['result'];
        }else if($division_type=="all"){
            $result_data=array();
            $result_data=$databoard_data['result'];
        }else{
            // $result_data=array();
            $result_data="Missing or incorrect parameter 'division_type:'";
        }
        //    die;
        //    print_r($result_data);die;
        if($auth == 1){

            $viewdata = $result_data;
          
            $this->response([
                'data' => $viewdata,
              
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => 'login error'
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    

}