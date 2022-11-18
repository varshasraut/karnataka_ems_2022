<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_calls extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_calls_model','supervisory_app_api_models/Supervisory_Login_model'));
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
        $date = $this->post('date');
        // print_r($date);die;
        $username = $this->post('username');


        // $data =array();
        // $data = $this->Supervisory_calls_model->get_total_calls_frm_dashboard_tbl();
        $current_date = date('Y-m-d');
        $from_date =  $date;
        $to_date =  $date;
        
        $databoard_data = array();
        $databoard_data1 = array();
        $arg_month_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('108','102','104'));
        $databoard_data['108_count_by_date'] = $this->Supervisory_calls_model->get_total_call_count($arg_month_date);


        $arg_day_date = array('To_date'=>$to_date,'from_date'=>$from_date,'system_type' => array('104'));
        $databoard_data['104_count_by_date'] = $this->Supervisory_calls_model->get_total_104_call_count($arg_day_date);
        
        
        $arg_till_date = array('date_type'=>'to','date'=>$date,'type'=>'eme','system_type' => array('108','102'));
        $databoard_data['108_eme_count_by_date']  =  $this->Supervisory_calls_model->get_total_call_type($arg_till_date);
  
        $arg_till_date = array('date_type'=>'to','date'=>$date,'type'=>'non-eme','system_type' => array('108','102'));
        $databoard_data['108_noneme_count_by_date']  =  $this->Supervisory_calls_model->get_total_call_type($arg_till_date);
        //Ambulance Type
        // $databoard_data1['count_till_date'] =  $data[0]['count_till_date']+1526531+ $databoard_data1['count_today'];
        
        // $databoard_data1['eme_count_till_date'] =  $data[0]['eme_count_till_date']+355526+$databoard_data1['eme_count_today_date'];
        
        // $databoard_data1['noneme_count_till_date'] =  $data[0]['noneme_count_till_date']+1171005+$databoard_data1['noneme_count_today_date'];
       
       

        // 
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