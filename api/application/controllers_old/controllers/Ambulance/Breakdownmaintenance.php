<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Breakdownmaintenance extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->breakdown = $this->config->item('breakdown');
        $this->load->library('upload');
        $this->load->helper(['url','file','form']); 
    }
    function sanitize_string( $string, $sep = '-' ){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_\.]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        return trim($string, '-_');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $type = $this->post('type');
            $ambulanceNo = $this->post('vehicleNumber');
            $estimateCost = $this->post('estimateCost');
            $expOnroadDateTime = $this->post('expOnroadDateTime');
            $standardremark = $this->post('standardremark');
            $remark = $this->post('remark');
            $currentOdometer = $this->post('endOdometer');
           // $currentOdometer = '10';
            $informed = json_encode($this->post('informed'));
            $photoEmpty = $this->post('photoEmpty');
            $workshop = $this->post('workshop');
            $breakDownSeverity = $this->post('breakDownSeverity');
            $breakDownType = $this->post('breakDownType');
            $breakDownTypeOther = $this->post('breakDownTypeOther');
            $distManager = implode(',',$this->post('distManager'));
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
            $previousOdometer = $this->user->getendodometer($ambulanceNo);
            $breakdownmaintanceodo = $this->user->getbreakdownmaintanceodo($ambulanceNo);
            $baseMonth = $this->CommonModel->baseMonth();
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id,$type);
            $user = array();
            if($type == 3){
                $userLoginArr = explode(',',$logindata['id']);
                foreach($userLoginArr as $userLoginArr1){
                    $user1 = $this->user->getClgRefid($userLoginArr1);
                    array_push($user,$user1);
                }
                $loginUser = implode(',',$user);
            }else{
                $loginUser = $this->user->getClgRefid($logindata['id']);
            }
            $ambpilotdata = $this->user->getloginpilotdetails($loginUser);
            /*Add 'ems_amb_onroad_offroad' table */
            $breakdown['mt_amb_no'] = $ambulanceNo;
            $breakdown['mt_state_id'] = $amb[0]['amb_state'];
            $breakdown['mt_district_id'] = $amb[0]['amb_district'];
            $breakdown['mt_make'] = $amb[0]['vehical_make'];
            $breakdown['mt_module'] = $amb[0]['vehical_model'];
            $breakdown['amb_type'] = $amb[0]['amb_type'];  
            $breakdown['mt_base_loc'] = $amb[0]['hp_name'];
            $breakdown['mt_pilot_id'] = $ambpilotdata[0]['clg_ref_id'];
            $breakdown['mt_pilot_name'] = $ambpilotdata[0]['clg_first_name'] ." ". $ambpilotdata[0]['clg_mid_name']." ". $ambpilotdata[0]['clg_last_name']  ;



            $breakdown['mt_work_shop'] = $workshop;
            $breakdown['mt_accidental_previos_odometer'] = $breakdownmaintanceodo[0]['endOdometer'];
            $breakdown['mt_in_odometer'] = $currentOdometer;
            $breakdown['mt_previos_odometer'] = $previousOdometer['endOdometer'];
            $breakdown['mt_brakdown_severity'] =  $breakDownSeverity;
            $breakdown['mt_breakdown_type'] = $breakDownType;
            $breakdown['mt_breakdown_type_other'] = $breakDownTypeOther;
            $breakdown['mt_ex_onroad_datetime'] = $expOnroadDateTime;
            $breakdown['mt_stnd_remark'] = $standardremark;
            $breakdown['mt_remark'] = $remark;
            $breakdown['mt_district_manager'] = $distManager;
            $breakdown['mt_type'] = "breakdown";
            $breakdown['mt_ambulance_status'] = "Pending Approval";
            $breakdown['mt_isdeleted'] = '0';
            $breakdown['mt_base_month'] = $baseMonth[0]['months'];
            $breakdown['added_by'] = $loginUser;
            $breakdown['added_date'] = date('Y-m-d H:i:s');
            $breakdown['modify_by'] = $loginUser;
            $breakdown['modify_date'] = date('Y-m-d H:i:s');
            $breakdown['mt_Estimatecost'] = $estimateCost;
            $breakdown['informed_to'] = $informed;
            
            /*Add 'ems_ambulance_status_summary' table */
            $summery['amb_rto_register_no'] = $ambulanceNo;
            $summery['amb_status'] = 18;
            $summery['off_road_status'] = "Pending for approval";
            $summery['off_road_remark'] = $standardremark;
            $summery['off_road_remark_other'] = $remark;
            $summery['off_road_date'] = date('Y-m-d');
            $summery['off_road_time'] = date('H:i:s');
            $summery['start_odometer'] = $currentOdometer;
            $summery['added_date'] = date('Y-m-d H:i:s');
            /*Add 'ems_ambulance_timestamp_record' table */
            $timestamp['amb_rto_register_no'] = $ambulanceNo;
            $timestamp['start_odmeter'] = $currentOdometer;
            $timestamp['end_odmeter'] = $currentOdometer;
            $timestamp['total_km'] = $currentOdometer - $currentOdometer;
            $timestamp['timestamp'] = date('Y-m-d H:i:s');
            $timestamp['remark'] = $standardremark;
            $timestamp['other_remark'] = $remark;

            if($photoEmpty == 0){
                /*Add 'ems_media' table */
                if(!empty($_FILES['amb_photo']['name'])){
                    $media_args1 = array();
                    foreach ($_FILES['amb_photo']['name'] as $key => $image) {
                        $media_args = array();
                        
                        $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                        $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                        $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                        $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                        $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];

                        $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
                        
                        $rsm_config = $this->breakdown;
                        $this->upload->initialize($rsm_config);
                        if (! $this->upload->do_upload('photo')) {
                            $this->response([
                                'data' => 'error',
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                            die;
                        }else{
                            $media_args['media_name'] = $_FILES['photo']['name'];
                            $media_args['media_data'] = 'breakdown';
                            array_push($media_args1,$media_args);
                        }
                    }
                }
            }
            $breakDownId = $this->user->insertBreakDown($breakdown);
            $addSummery = $this->user->insertAmbSummery($summery);
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if(!empty($media_args)){
                $media_args['user_id'] = $breakDownId;
                foreach($media_args1 as $media_args2){
                    $media_args_merge = array_merge($media_args2,$media_args);
                    $this->user->insert_media_maintance($media_args_merge);
                }
            }


            if(!empty($breakDownId) && !empty($addSummery) && !empty($addtimestamp)){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Insert Successfully'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Not Inserted'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
  public function breakdowndetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $breakdowndetailsarr = $this->user->getbreakdownDetails($requestId);
      if(empty($breakdowndetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{
      
      $mediatype='2';
       $media = $this->user->getmedia($requestId,$mediatype);    
     $distcode= $breakdowndetailsarr[0]['mt_district_id'];
           $dist = explode(',',$breakdowndetailsarr[0]['mt_district_manager']);
                    $distManager = array();
                    foreach($dist as $dist1){
                    $distManager1 = $this->user->getcurrentDistManager($distcode);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
       $mt_stnd_remark = $breakdowndetailsarr[0]['mt_stnd_remark'];
      $approveRem = $this->user->getApproveRema($mt_stnd_remark);
       if(!empty($breakdowndetailsarr[0]['mt_end_odometer']))
        {
            $enodometer=$breakdowndetailsarr[0]['mt_end_odometer'];                
        } 
        else{
             $enodometer=$breakdowndetailsarr[0]['mt_in_odometer'];    
        }    
     $maintenanceType = 18;
      $miantaincehistory = $this->user->maintaincehisotory($requestId,$maintenanceType);
      if(!empty($miantaincehistory))
           {
              $otheruseremark= $miantaincehistory[0]['re_remark'];
           }
           else
           {
               $otheruseremark= '';
           }  
          if($breakdowndetailsarr[0]['mt_ambulance_status'] == "Pending Approval"){
          
              $approvedcost = $breakdowndetailsarr[0]['mt_app_est_amt'];
            }
            else{
                
                if(!empty($breakdowndetailsarr[0]['mt_app_est_amt']))
                {
                    $approvedcost = $breakdowndetailsarr[0]['mt_app_est_amt'];
                }
                else{
                    
                     $approvedcost = $breakdowndetailsarr[0]['mt_Estimatecost'];
                     
                }
            
            }   
        $data = array(
                        'requestId' =>(int) $breakdowndetailsarr[0]['mt_id'],
                        'brakdownSeverity' => $breakdowndetailsarr[0]['mt_brakdown_severity'],
                        'breakdownType' => $breakdowndetailsarr[0]['mt_breakdown_type'],
                        'previosOdometer' =>  $breakdowndetailsarr[0]['mt_previos_odometer'], 
                        'endOdometer' => $enodometer,
                        'inOdometer' => $breakdowndetailsarr[0]['mt_in_odometer'],
                        'estimateCost' => $breakdowndetailsarr[0]['mt_Estimatecost'],
                        'approvedCost'=>$approvedcost,
                        'workShop' => $breakdowndetailsarr[0]['mt_work_shop'],
                        'otherUserRemark ' => $otheruseremark,
                        'exOnroadDatetime' => $breakdowndetailsarr[0]['mt_ex_onroad_datetime'],
                        'uploadedImages' => $media,
                        'informedTo' => json_decode($breakdowndetailsarr[0]['informed_to']),
                        'stdremark' => $approveRem,
                        'distManager'=>$distManager               
                ); 
          
       
                $this->response([
                        'data' =>  $data,
                    'error' => null
                ], REST_Controller::HTTP_OK);
         
        }
    }
    else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    
 }
}