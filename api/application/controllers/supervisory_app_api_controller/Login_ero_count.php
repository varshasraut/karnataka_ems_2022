<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Login_ero_count extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_Dashboard_model','supervisory_app_api_models/Supervisory_Login_model'));
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
        // $data1['type'] = $this->post('type');
        $report_type= $this->post('type');
        $zone= $this->post('zone');
        $date = $this->post('date');
        // print_r($date);die;
        $username = $this->post('username');
        // print_r($username);die;
        $current_month = date('m');
        $current_year = date('Y');
        $current_month_date =  $current_year.'-'.$current_month.'-01';
        if($report_type=="month"){
           
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                           'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'),'call_status' => 'free');
            }else  if($report_type=="date"){
               
                $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
                'to_date' => date('Y-m-d', strtotime($date)),'system_type' => array('108','102'),'call_status' => 'free');
            }else if($report_type=="total"){
                $prev_count=355526;
                $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'),'call_status' => 'free');
            }
        //echo "ERO free Login Status<br>";
        // $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'free');
        $databoard_data['ero_free'] = $this->Supervisory_Dashboard_model->supv_ero_login_count($month_report_args);
        //echo "ERO On Call Login Status<br>";
        //var_dump('hi');
        if($report_type=="month"){
           
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                           'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'),'call_status' => 'atnd');
            }else  if($report_type=="date"){
               
                $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
                'to_date' => date('Y-m-d', strtotime($date)),'system_type' => array('108','102'),'call_status' => 'atnd');
            }else if($report_type=="total"){
                $prev_count=355526;
                $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'),'call_status' => 'atnd');
            }
        // $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'atnd');
        $databoard_data['ero_atend'] =$this->Supervisory_Dashboard_model->supv_ero_login_count($month_report_args);
        //echo "ERO Break Login Status<br>";
        if($report_type=="month"){
           
            $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                           'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'),'call_status' => 'break');
            }else  if($report_type=="date"){
               
                $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
                'to_date' => date('Y-m-d', strtotime($date)),'system_type' => array('108','102'),'call_status' => 'break');
            }else if($report_type=="total"){
                $prev_count=355526;
                $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
                'to_date' => date('Y-m-t', strtotime($current_month_date)),'system_type' => array('108','102'),'call_status' => 'break');
            }
        // $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'),'call_status' => 'break');
        $databoard_data['ero_break'] = $this->Supervisory_Dashboard_model->supv_ero_login_count($month_report_args);
        
            $dco_args = array('group' => 'UG-DCO');
            $databoard_data['dco_count'] = $this->Supervisory_Dashboard_model->supv_logins_count($dco_args);

            $databoard_data['pda_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-PDA'));
            
            $databoard_data['ero_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-ERO'));

            $databoard_data['ercp_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-ERCP'));

            $databoard_data['grievance_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-Grievance'));

            $databoard_data['feedback_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-Feedback'));

            $databoard_data['quality_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-Quality'));

            $databoard_data['dco_Tl_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-DCOSupervisor'));

            $databoard_data['ero_Tl_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-EROSupervisor'));

            $databoard_data['ero_104_Tl_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-EROSupervisor-104'));

            $databoard_data['SM_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-ShiftManager'));

            $databoard_data['ero104_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-ERO-104'));
            
            $databoard_data['ercp_104_count'] = $this->Supervisory_Dashboard_model->supv_logins_count(array('group'=>'UG-ERCP-104'));
            
            $databoard_data['total_count'] = $databoard_data['dco_count']+$databoard_data['ercp_count']+$databoard_data['grievance_count']+$databoard_data['feedback_count']+$databoard_data['quality_count']+$databoard_data['dco_Tl_count']+$databoard_data['ero_Tl_count']+$databoard_data['ero_104_Tl_count']+$databoard_data['SM_count']+$databoard_data['ero104_count']+$databoard_data['ercp_104_count']+$databoard_data['ero_break']+$databoard_data['ero_atend']+$databoard_data['ero_free'];
            // $data1['login_secret_key'] =  $this->post('loginSecretKey');
            // $data1['device_id'] =  $this->post('uniqueId');
            // $data1['username'] =  $this->post('username');
            $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
            if($auth == 1){

                $viewdata = $databoard_data;
            // print_r($viewdata);die;
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
    

}