<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
// Authentication
class Supervisory_patient_served extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the user model
        $this->load->model(array('supervisory_app_api_models/Supervisory_patient_served_model','supervisory_app_api_models/Supervisory_Login_model'));
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
            $from_date=date('Y-m-d',strtotime($current_month_date));
            $to_date=date('Y-m-t', strtotime($current_month_date));
        // $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
        //                'to_date' => date('Y-m-t', strtotime($current_month_date)));
                    //    print_r($month_report_args);die;
        }else  if($report_type=="date"){
            $from_date=date('Y-m-d',strtotime($date));
            $to_date= date('Y-m-d', strtotime($date));
            // $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($date)),
            // 'to_date' => date('Y-m-d', strtotime($date)));
            // print_r($month_report_args);die;
        }else if($report_type=="total"){

            $from_date=date('Y-m-d',strtotime($current_month_date));
            $to_date=date('Y-m-t', strtotime($current_month_date));
           
            // $month_report_args =  array('report_type' =>$report_type,'from_date' => date('Y-m-d',strtotime($current_month_date)),
            // 'to_date' => date('Y-m-t', strtotime($current_month_date)));
            // print_r($month_report_args);die;
        }
    
        $current_date = date('Y-m-d');
    
        
        $arg_till_date = array('date_type'=>'to','date'=>$date);
        $databoard_data = array();
        $databoard_data1 = array();
        // $databoard_data['Assault'] =  $this->Supervisory_patient_served_model->get_total_Assault($month_report_args);   
        // $databoard_data['AnimalAttack'] =  $this->Supervisory_patient_served_model->get_total_AnimalAttack($month_report_args);   
        // $databoard_data['Burn'] =  $this->Supervisory_patient_served_model->get_total_Burn($month_report_args);   
        // $databoard_data['Poisoning'] =  $this->Supervisory_patient_served_model->get_total_Poisoning($month_report_args);   
        // $databoard_data['Labour'] =  $this->Supervisory_patient_served_model->get_total_Labour($month_report_args);   
        // $databoard_data['Lighting'] =  $this->Supervisory_patient_served_model->get_total_Lighting($month_report_args);   
        // $databoard_data['Mass_Casualty'] =  $this->Supervisory_patient_served_model->get_total_Mass_Casualty($month_report_args);   
        // $databoard_data['Medical'] =  $this->Supervisory_patient_served_model->get_total_Medical($month_report_args); 
        // $databoard_data['Others'] =  $this->Supervisory_patient_served_model->get_total_Others($month_report_args);   
        // $databoard_data['Suicide'] =  $this->Supervisory_patient_served_model->get_total_Suicide($month_report_args);   
        // $databoard_data['Trauma_nonvehicle'] =  $this->Supervisory_patient_served_model->get_total_Trauma_nonvehicle($month_report_args);   
        // $databoard_data['Trauma_vehicle'] =  $this->Supervisory_patient_served_model->get_total_Trauma_vehicle($month_report_args);   

        // $databoard_data['Accident_Data'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Accident'));
        // $databoard_data['Assault'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Assault'));
        // $databoard_data['Burn'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Burn'));
        // $databoard_data['Cardiac'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Cardiac'));
        // $databoard_data['Fall'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Fall'));
        // $databoard_data['Poisoning'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Intoxication / Poisoning'));
        // $databoard_data['Labour'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Labour / Pregnancy'));
        // $databoard_data['Lighting'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Lighting / Electrocution'));
        // $databoard_data['Mass_Casualty'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Mass_casualty'));
        // $databoard_data['Medical'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Medical','Animal Attack'));
        // $databoard_data['Poly_Trauma'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Trauma (Vehicle)','Trauma (Non-Vehicle)'));
        // $databoard_data['Suicide'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Suicide / Self Inflicted Injury'));
        // $databoard_data['Others'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Other'));
        // $databoard_data['DropCall'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('DropCall'));
        // $databoard_data['Unavail_Calls'] = $this->Supervisory_patient_served_model->get_b12_supv_data($month_report_args,array('Unavail_Calls'));


        // $databoard_data['pickup'] =  $this->Supervisory_patient_served_model->get_total_pick_up($month_report_args);   
        // $databoard_data['drop'] =  $this->Supervisory_patient_served_model->get_total_drop($month_report_args); 
        // $databoard_data['ift'] =  $this->Supervisory_patient_served_model->get_total_ift($month_report_args);   
        
        // $databoard_data['total_dispatch'] =  $this->Supervisory_patient_served_model->get_total_dispatch($month_report_args);
        // $databoard_data['total_dispatch']  =  $this->Supervisory_patient_served_model->get_total_dispatch($month_report_args);
        // $databoard_data['start_frm_base']  =  $this->Supervisory_patient_served_model->get_total_start_frm_base($month_report_args);
        // $databoard_data['at_scene']  =  $this->Supervisory_patient_served_model->get_total_at_scene($month_report_args);
        // $databoard_data['at_destination']  =  $this->Supervisory_patient_served_model->get_total_at_destination($month_report_args);
        // $databoard_data['back_to_base']  =  $this->Supervisory_patient_served_model->get_total_back_to_base($month_report_args);
        // print_r($databoard_data);die;


            $post_reports = $this->input->post();
            if ($date != ''   ) {
                $report_args = array('from_date' => $from_date,
                                    'to_date' => $to_date,
                                    'report_type' => $report_type,
                                    'sys_type' =>  '108'
                                    );
            } else {
                $report_args = array('from_date' => $from_date,
                                    'to_date' => $to_date,
                                    'report_type' => $report_type,
                                    'sys_type' => '108'
                      
                                    );
            }
            // 3functions get_b12_data_report_108 get_drop108_data_report get_pickup108_data_report
            $pro_data = $this->Supervisory_patient_served_model->supv_b12_data_report_108($report_args);
            $databoard_data['drop_108'] = $this->Supervisory_patient_served_model->supv_drop108_data_report($report_args);
            $databoard_data['pick_108'] = $this->Supervisory_patient_served_model->supv_pickup108_data_report($report_args);
            // print_r($databoard_data);die;
            $janani_pro_im = array('11','12','24','39','45','46','65','72','73','74','75','78','79');
            $other_count =0 ;  
            $count=0;

            foreach( $pro_data as $data){
                // print_r($data);die;
                if($count<10 && $data['pro_name'] != 'other' && !in_array($data['provider_impressions'],$janani_pro_im)){
                        $inc_data[] =array(
                        'pro_name' => $data['pro_name'],
                        'total_count' => $data['total_count']
                        );
                    $count++;
                }
                else{
                    $other_count += $data['total_count'];
                    $inc_other_data[] =array(
                        'Other' => $data['pro_name'],
                        'Other_total_count' => $other_count
                        ); 
                }
                
            }
            // 1 function  get_IFT_data_report
            // print_r($inc_data);die;
            $databoard_data['IFT108_data']= $this->Supervisory_patient_served_model->supv_IFT_data_report($report_args);
            // print_r($databoard_data['IFT108_data'][0]['total_count']);die;
            if ($date != ''   ) {
                $report_args1 = array('from_date' => $from_date,
                                    'to_date' => $to_date,
                                    'report_type' => $report_type,
                                    'sys_type' =>  '102'
                                    );
            }else{
                $report_args1 = array('from_date' => $from_date,
                                    'to_date' => $to_date,
                                    'report_type' => $report_type,
                                    'sys_type' => '102'
                      
                                    );
            }
            // 3 function get_IFT_data_report(repeated funtion) get_janani_other_data_report get_Janani_data_report_drop
            $databoard_data['janani_102'] = $this->Supervisory_patient_served_model->supv_janani_other_data_report($report_args1);
            $databoard_data['IFT102_data'] = $this->Supervisory_patient_served_model->supv_IFT_data_report($report_args1);
            $drop_data = $this->Supervisory_patient_served_model->supv_Janani_data_report_drop($report_args1);
            $drop_other_count=0;
            $drop_count=0;
            foreach($drop_data as $drop_data1){
                //var_dump(drop_data1);
                if(in_array($drop_data1['provider_impressions'],$janani_pro_im)){
                    $drop_count += $drop_data1['total_count'];
                    $inc_drop_data[] =array(
                        'pro_name' => $drop_data1['pro_name'],
                        'drop_count' => $drop_count
                    );
                }
                else{
                    $drop_other_count += $drop_data1['total_count'];
                    $inc_drop_other_data[] =array(
                        'Other' => 'Other',
                        'drop_other_count' => $drop_other_count
                    ); 
                }
            }
            // var_dump($drop_count);die();
            // 1 function get_Janani_data_report_pickup
            // print_r($inc_drop_data);die;
            $pickup_data = $this->Supervisory_patient_served_model->supv_Janani_data_report_pickup($report_args1);
            $pick_other_count=0;
            $pick_count=0;
            foreach($pickup_data as $pick_data1){
                if(in_array($pick_data1['provider_impressions'],$janani_pro_im)){
                    $pick_count += $pick_data1['total_count'];
                    $inc_pick_data[] =array(
                        'pro_name' => $pick_data1['pro_name'],
                        'pick_count' => $pick_count
                    );
                }
                else{
                    $pick_other_count += $pick_data1['total_count'];
                    $inc_pick_other_data[] =array(
                        'Other' => 'Other',
                        'pick_other_count' => $pick_other_count
                    ); 
                }
            
        }
        $auth = $this->Supervisory_Login_model->checkLoginUserforAuth($data1);
if(isset($inc_data)){
        //below $data for top 10 providers
        foreach($inc_data as $inc){
            
            $databoard_data1['top_10'][] = array (
                'Pro_Name' => $inc['pro_name'],
                'Count' => $inc['total_count']
            );      
            // fputcsv($fp, $data);
        }
        // $pick_count for JE/JANANI pickup Call
         // $drop_count for JE/JANANI Drop Call
        // echo ($pick_count);
        // echo $drop_count
        // die;
        //  print_r($inc_drop_data);die;
        // $data_other for other provider after top 10
         $data_other = $other_count + $databoard_data['drop_108'][0]['total_count'] + $databoard_data['pick_108'][0]['total_count'];
        // $data_other_janani_count for JANANi Other
        $data_other_janani_count=  $drop_other_count + $pick_other_count + $databoard_data['janani_102'][0]['total_count'];
    //  SANJIVANI
        // print_r($data_other_janani_count);die;
        // $databoard_data1['top_10']=$data;
        $databoard_data1['other_after_top_10']=$data_other;
        $databoard_data1['IFT108_data']=$databoard_data['IFT108_data'][0]['total_count'];
    // JANANI
        $databoard_data1['pick_up_call']=$pick_count;
        $databoard_data1['drop_call']=$drop_count;
        $databoard_data1['other_je']=$data_other_janani_count;
        $databoard_data1['ift_102']=$databoard_data['IFT102_data'][0]['total_count'];
        
    }else{
        $databoard_data1 =null;
    }
        if($auth == 1){

            $viewdata = $databoard_data1;
          
            $this->response([
                'data' => $viewdata==null?null:[$viewdata],
              
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