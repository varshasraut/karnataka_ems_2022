<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Ambulance_dash extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Dashboard_model_final_updated','supervisory_app_api_models/Login_model'));
        // $this->load->model('supervisory_app_api_models/Display_model');
        $this->load->helper('string');
        $this->load->helper('number');
        $this->load->library('upload');
       
    }
    public function index_post(){

        $data1['login_secret_key'] =  $this->post('loginSecretKey');
        $data1['device_id'] =  $this->post('uniqueId');
        $data1['username'] =  $this->post('username');
        $username = $this->post('username');
        



        // 

        $data =array();
        $data = $this->Dashboard_model_final_updated->get_total_calls_frm_dashboard_tbl();
        // echo "<pre>";print_r($data);die;
        $current_date = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime($current_date)).' 00:00:00';
        $to_date = date('Y-m-d', strtotime($current_date)).' 23:59:59';
       
        $databoard_data = array();
        $databoard_data2['fuel'] = $this->Dashboard_model_final_updated->get_fuel_filling_data(); 
    //    echo "<pre>";print_r($databoard_data2['fuel'][0]['fueltotal']);die;
       $databoard_data['fuel'] = $databoard_data2['fuel'][0]['fueltotal'];
        $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
        $databoard_data['count_today'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
       
       //Closure count Today
        $closure_report = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
        $databoard_data['closure_today'] = $this->Dashboard_model_final_updated->Total_closure_data($closure_report,array('21','41','42','43','44'));
        
        //Total today inc cases closed
        $closure_report_td = array('to_date' => $to_date,'from_date' => $from_date,'system_type' => array('108','102'));
        $databoard_data['today_cases_closed'] =  $this->Dashboard_model_final_updated->Total_closure_data_today($closure_report_td,array('21','41','42','43','44'));

        // echo "eme_count_today_date<br>";
        $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
        $databoard_data['eme_count_today_date']  =  $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        $databoard_data['count_today_dispatch'] = $databoard_data['eme_count_today_date'];
        //var_dump($dashboard_data['count_today_dispatch']);die();
        //echo "noneme_count_today_date<br>";
        $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
        $databoard_data['noneme_count_today_date']  =  $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
        //Ambulance Type
        $amb_je = array('system_type' => array('108','102'),'type' => '1','amb_status' => array('1','2'));
        $databoard_data['amb_je'] =  $this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je);

        $amb_je = array('system_type' => array('108','102'),'type' =>'3','amb_status' => array('1','2'));
        $databoard_data['amb_als'] =  $this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je);

        $amb_je = array('system_type' => array('108','102'),'type' => '2','amb_status' => array('1','2'));
        $databoard_data['amb_bls'] =  $this->Dashboard_model_final_updated->get_amb_count_typewise($amb_je);

        //Total Ambulances
        $amb_all = array('system_type' => array('108','102'),'status' => 'all');
        $databoard_data['amb_total'] =  $this->Dashboard_model_final_updated->get_amb_count($amb_all);
        
        $amb_available = array('system_type' => array('108','102'),'status' => '1');
        $databoard_data['amb_available'] = $this->Dashboard_model_final_updated->get_amb_count($amb_available);
        
        $amb_busy = array('system_type' => array('108','102'),'status' => '2');
        $databoard_data['amb_busy'] = $this->Dashboard_model_final_updated->get_amb_count($amb_busy);
        $databoard_data['amb_on_road'] =  $databoard_data['amb_busy'] + $databoard_data['amb_available'];
        $amb_maintainance = array('system_type' => array('108','102'),'status' => '7');
        $databoard_data['amb_maintainance'] =  $this->Dashboard_model_final_updated->get_amb_count($amb_maintainance);
        //Ambulance Status parameter
        $databoard_data['start_frm_base']  =  $this->Dashboard_model_final_updated->get_total_start_frm_base($arg_till_date);
        $databoard_data['at_scene']  =  $this->Dashboard_model_final_updated->get_total_at_scene($arg_till_date);
        $databoard_data['at_destination']  =  $this->Dashboard_model_final_updated->get_total_at_destination($arg_till_date);
        $databoard_data['back_to_base']  =  $this->Dashboard_model_final_updated->get_total_back_to_base($arg_till_date);
        //EMT Pilot Data
        $databoard_data['emt_present']  = $this->Dashboard_model_final_updated->get_total_emt_present($arg_till_date);
        $databoard_data['pilot_present']  = $this->Dashboard_model_final_updated->get_total_pilot_present($arg_till_date);
        
       // setlocale(LC_MONETARY, 'en_IN');
        
        $databoard_data['count_till_date'] =  $data[0]['count_till_date']+1526531+ $databoard_data['count_today'];
        $databoard_data['count_till_month'] =  $data[0]['count_till_month']+ $databoard_data['count_today'];
        $databoard_data['eme_count_till_date'] =  $data[0]['eme_count_till_date']+355526+$databoard_data['eme_count_today_date'];
        $databoard_data['eme_count_till_month'] =  $data[0]['eme_count_till_month']+$databoard_data['eme_count_today_date'];
        $databoard_data['noneme_count_till_date'] =  $data[0]['noneme_count_till_date']+1171005+$databoard_data['noneme_count_today_date'];
        $databoard_data['noneme_count_till_month'] =  $data[0]['noneme_count_till_month']+$databoard_data['noneme_count_today_date'];
        
        $databoard_data['dispatch_till_date'] =  $data[0]['dispatch_till_date']+355526+$databoard_data['count_today'];

        $databoard_data['closure_till_date'] =  $data[0]['closure_till_date']+ $databoard_data['closure_today'];
        $databoard_data['closure_till_month'] =  $data[0]['closure_till_month']+ $databoard_data['closure_today'];
        

        $arg_till_date = array('date_type'=>'to','type'=>'non-eme','system_type' => array('108','102'));
        $databoard_data['pei_chart_non_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
    
        $arg_till_date = array('date_type'=>'to','type'=>'eme','system_type' => array('108','102'));
        $databoard_data['pei_chart_eme_today']  = $this->Dashboard_model_final_updated->get_total_call_type($arg_till_date);
       
        $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102'));
        $databoard_data['pei_chart_total_today'] = $this->Dashboard_model_final_updated->get_total_call_count($arg_month_date);
        
        $databoard_data['pei_chart_non_eme_till_date'] = $data[0]['noneme_count_till_date']+1171005+$databoard_data['pei_chart_non_eme_today'];
        $databoard_data['pei_chart_eme_till_date'] = $data[0]['eme_count_till_date']+355526+$databoard_data['pei_chart_eme_today'] ;   
        
        $databoard_data['pei_chart_total_till_date'] = $data[0]['count_till_date']+1526531+ $databoard_data['pei_chart_total_today'];
        $databoard_data['pei_chart_non_eme_till_month'] = $data[0]['noneme_count_till_month']+$databoard_data['pei_chart_non_eme_today'];

        $databoard_data['pei_chart_eme_today_till_month'] = $data[0]['eme_count_till_month']+$databoard_data['pei_chart_eme_today'] ;
        $databoard_data['pei_chart_total_today_till_month'] = $data[0]['count_till_month']+ $databoard_data['pei_chart_total_today'];     
      
        

        // 
        $auth = $this->Login_model->checkLoginUserforAuth($data1);
        if($auth == 1){

            $viewdata = $databoard_data;
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