<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Accidentalmentainance extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->load->helper('string');
        $this->accidental = $this->config->item('accidental');
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
            $accidentDate = $this->post('accidentDate');
            $estimateCost = $this->post('estimateCost');
            $workShop = $this->post('workShop');
            $accidentalDate = $this->post('accidentalDate');
            $previousOdometer = $this->post('endOdometer');
            $currentOdometer = $this->post('startOdometer');
            $accidentalSeverity = $this->post('accidentalSeverity');
            $expOnroadDateTime = $this->post('expOnroadDateTime');
            $accidentalType = $this->post('accidentalType');
            $accidentalTypeOther = $this->post('accidentalTypeOther');
            $extentDamage = $this->post('extentDamage');
            $policFireInsu = json_encode($this->post('policFireInsu'));
            $informed = json_encode($this->post('informed'));
            $towingRequired = $this->post('towingRequired');
            $policeOnScene = $this->post('policeOnScene');
            $fireOnScene = $this->post('fireOnScene');
            $standardremark = $this->post('standardremark');
            $remark = $this->post('remark');
            $photoEmpty = $this->post('photoEmpty');
            $distManager = implode(',',$this->post('distManager'));
            $baseMonth = $this->CommonModel->baseMonth();
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
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
            $accidental['mt_amb_no'] = $ambulanceNo;
            $accidental['mt_accidentdate'] = $accidentalDate;
            $accidental['mt_district_manager'] = $distManager;
            $accidental['mt_Estimatecost'] = $estimateCost;
            $accidental['mt_previos_odometer'] = $previousOdometer;
            $accidental['mt_in_odometer'] = $currentOdometer;
            $accidental['mt_accidental_severity'] = $accidentalSeverity;
            $accidental['mt_accidental_type'] = $accidentalType;
            $accidental['mt_accidental_type_other'] = $accidentalTypeOther;
            $accidental['informed_to'] = $policFireInsu;
            $accidental['mt_informed_group'] = $informed;
            $accidental['mt_police_on_scene'] = $policeOnScene;
            $accidental['mt_fire_on_scene'] = $fireOnScene;
            $accidental['mt_towing_required'] = $towingRequired;
            $accidental['mt_extent_demage'] = $extentDamage;
            $accidental['mt_ex_onroad_datetime'] =  $expOnroadDateTime;
            $accidental['mt_stnd_remark'] = $standardremark;
            $accidental['mt_remark'] = $remark;
            $accidental['mt_type'] = 'accidental';
            $accidental['mt_ambulance_status'] = 'Pending Approval';
            $accidental['mt_base_month'] = $baseMonth[0]['months'];
            $accidental['added_by'] = $loginUser;
            $accidental['added_date'] =  date('Y-m-d H:i:s');
            $accidental['modify_by'] = $loginUser;
            $accidental['modify_date'] =  date('Y-m-d H:i:s');
            $accidental['mt_state_id'] = $amb[0]['amb_state'];
            $accidental['mt_district_id'] =$amb[0]['amb_district'];
            $accidental['mt_base_loc'] = $amb[0]['hp_name'];
            /*Add 'ems_ambulance_status_summary' table */ 
            $summery['amb_rto_register_no'] = $ambulanceNo;
            $summery['amb_status'] = '7';
            $summery['off_road_status'] ='Pending for approval';
            $summery['off_road_remark'] = $standardremark;
            $summery['off_road_remark_other'] = $remark;
            $summery['off_road_date'] = date('Y-m-d');
            $summery['off_road_time'] = date('H:i:s');
            $summery['start_odometer'] = $previousOdometer;
            $summery['added_date'] = date('Y-m-d H:i:s');
            
            /*Add 'ems_ambulance_timestamp_record' table */
            $timestamp['amb_rto_register_no'] = $ambulanceNo;
            $timestamp['start_odmeter'] = $previousOdometer;
            $timestamp['end_odmeter'] = $currentOdometer;
            $timestamp['total_km'] = $currentOdometer - $previousOdometer;
            $timestamp['timestamp'] = date('Y-m-d H:i:s');
            $timestamp['remark'] = $standardremark;
            $timestamp['other_remark'] = $remark;
            $timestamp['remark_type'] = 'accidental_maintenance';
                
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            $addSummery = $this->user->insertAmbSummery($summery);
            $accidentalmaintaince = $this->user->insertAccidentalMaintenance($accidental);
            if($photoEmpty == 0){
                if(!empty($_FILES['amb_photo']['name'])){
                    $media_args1 = array();
                    foreach ($_FILES['amb_photo']['name'] as $key => $image){
                        $media_args = array();
                        $_FILES['photo']['name']= $_FILES['amb_photo']['name'][$key];
                        $_FILES['photo']['type']= $_FILES['amb_photo']['type'][$key];
                        $_FILES['photo']['tmp_name']= $_FILES['amb_photo']['tmp_name'][$key];
                        $_FILES['photo']['error']= $_FILES['amb_photo']['error'][$key];
                        $_FILES['photo']['size']= $_FILES['amb_photo']['size'][$key];
                        $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
                        $rsm_config = $this->accidental;
                        $this->upload->initialize($rsm_config);
                        if (!$this->upload->do_upload('photo')) {
                           $this->response([
                                'data' => 'error',
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $media_args['media_name'] = $_FILES['photo']['name'];
                            $media_args['media_data'] = 'accidental';
                            array_push($media_args1,$media_args);
                        }
                    }
                }
            }
            if(!empty($media_args)){
                $media_args['user_id'] = $accidentalmaintaince;
                foreach($media_args1 as $media_args2){
                    $media_args_merge = array_merge($media_args2,$media_args);
                    $this->user->insert_media_maintance($media_args_merge);
                }
            }
            if(!empty($accidentalmaintaince) && !empty($addSummery) && !empty($addtimestamp)){
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
    
    public function accidentaldetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $accidentaldetailsarr = $this->user->getAccidentalDetails($requestId);
  
     if(empty($accidentaldetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{
       
      $mediatype='1';
      $media = $this->user->getmedia($requestId,$mediatype);
      
     $distcode= $accidentaldetailsarr[0]['mt_district_id'];
           $dist = explode(',',$accidentaldetailsarr[0]['mt_district_manager']);
                    $distManager = array();
                    foreach($dist as $dist1){
                    $distManager1 = $this->user->getcurrentDistManager($distcode);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
      $mt_stnd_remark = $accidentaldetailsarr[0]['mt_stnd_remark'];
      $approveRem = $this->user->getApproveRema($mt_stnd_remark);
      
       if(!empty($accidentaldetailsarr[0]['mt_end_odometer']))
        {
            $enodometer=$accidentaldetailsarr[0]['mt_end_odometer'];                
        } 
        else{
             $enodometer=$accidentaldetailsarr[0]['mt_in_odometer'];    
        }
        $maintenanceType = 7;
         $miantaincehistory = $this->user->maintaincehisotory($requestId,$maintenanceType);
           if(!empty($miantaincehistory))
           {
              $otheruseremark= $miantaincehistory[0]['re_remark'];
           }
           else
           {
               $otheruseremark= '';
           }
       
        
        if($accidentaldetailsarr[0]['mt_ambulance_status'] == "Pending Approval"){
          
              $approvedcost = $accidentaldetailsarr[0]['mt_app_est_amt'];
            }
            else{
                
                if(!empty($accidentaldetailsarr[0]['mt_app_est_amt']))
                {
                    $approvedcost = $accidentaldetailsarr[0]['mt_app_est_amt'];
                }
                else{
                    
                     $approvedcost = $accidentaldetailsarr[0]['mt_Estimatecost'];
                     
                }
            
            }
           
        
        
        
        
        
        
       
         $data = array(
                        'requestId' => (int) $accidentaldetailsarr[0]['mt_id'],
                        'accidentalSeverity' => $accidentaldetailsarr[0]['mt_accidental_severity'],
                        'towingRequired' => $accidentaldetailsarr[0]['mt_towing_required'],
                        'extentDemage' => $accidentaldetailsarr[0]['mt_extent_demage'],
                        'policeonScene' => $accidentaldetailsarr[0]['mt_police_on_scene'],
                        'fireonScene' => $accidentaldetailsarr[0]['mt_fire_on_scene'],
                        'accidentalType' => $accidentaldetailsarr[0]['mt_accidental_type'],
                        'previosOdometer' => $accidentaldetailsarr[0]['mt_previos_odometer'],
                        'endOdometer' => $enodometer,
                        'inOdometer' => $accidentaldetailsarr[0]['mt_in_odometer'],
                        'estimateCost' => $accidentaldetailsarr[0]['mt_Estimatecost'],
                        'approvedCost'=>$approvedcost,
                        'otherUserRemark ' =>$otheruseremark ,
                        'workShop' => $accidentaldetailsarr[0]['mt_work_shop'],
                        'informedTo' => json_decode($accidentaldetailsarr[0]['mt_informed_group']),
                        'informedtoOther' => json_decode($accidentaldetailsarr[0]['informed_to']),
                        'expectedonroadDatetime' => $accidentaldetailsarr[0]['mt_ex_onroad_datetime'],
                        'uploadedImages' =>$media,
                        'stdremark' => $approveRem,
                        'distManager'=>$distManager
                        ); 
       
                $this->response([
                        'data' => $data,
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