<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Preventivemaintenance extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->preventive = $this->config->item('preventive');
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
            $scheduleService = $this->post('scheduleService');
            $workShop = $this->post('workShop');
            $serviceName = $this->post('serviceName');
            $currentOdometer = $this->post('currentOdometer');
            $informed = $this->post('informed');
            $photoEmpty = $this->post('photoEmpty');
            $distManager = implode(',',$this->post('distManager'));
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
            $previousOdometer = $this->user->getsystemodo($ambulanceNo);
            $prevmaintanceodo = $this->user->getprevmaintanceodo($ambulanceNo);
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
            $preventive['mt_amb_no'] = $ambulanceNo;
            $preventive['mt_state_id'] = $amb[0]['amb_state'];
            $preventive['mt_district_id'] = $amb[0]['amb_district'];
            $preventive['mt_make'] = $amb[0]['vehical_make'];
            $preventive['mt_module'] = $amb[0]['vehical_model'];
            $preventive['amb_type'] = $amb[0]['amb_type'];            
            $preventive['mt_base_loc'] = $amb[0]['hp_name'];
            $preventive['mt_pilot_id'] = $ambpilotdata[0]['clg_ref_id'];
            $preventive['mt_pilot_name'] = $ambpilotdata[0]['clg_first_name'] ." ". $ambpilotdata[0]['clg_mid_name']." ". $ambpilotdata[0]['clg_last_name']  ;


            $preventive['mt_estimatecost'] = $estimateCost;
            $preventive['mt_work_shop'] = $workShop;
            $preventive['mt_preventive_previos_odometer'] = $prevmaintanceodo[0]['endOdometer'];
            $preventive['mt_previos_odometer'] = $previousOdometer['endOdometer'];
            $preventive['mt_in_odometer'] = $currentOdometer;
            $preventive['mt_ex_onroad_datetime'] = $expOnroadDateTime;
            $preventive['mt_offroad_datetime'] = date('Y-m-d');
            $preventive['mt_stnd_remark'] = $standardremark;
            $preventive['mt_remark'] = $remark;
            $preventive['mt_service_name'] = $serviceName;
            $preventive['mt_schedule_service'] = $scheduleService;
            $preventive['mt_informed_group'] = json_encode($informed);
            $preventive['mt_type'] = "preventive";
            $preventive['mt_ambulance_status'] = "Pending Approval";
            $preventive['mt_base_month'] = $baseMonth[0]['months'];
            $preventive['added_by'] = $loginUser;
            $preventive['added_date'] = date('Y-m-d H:i:s');
            $preventive['mt_isdeleted'] = '0';
            $preventive['modify_by'] = $loginUser;
            $preventive['modify_date'] = date('Y-m-d H:i:s');
            $preventive['mt_district_manager'] = $distManager;
            /*Add 'ems_ambulance_status_summary' table */
            $summery['amb_rto_register_no'] = $ambulanceNo;
            $summery['amb_status'] = 16;
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
            $timestamp['end_odmeter'] =$currentOdometer;
            $timestamp['total_km'] = $this->post('endodometer') - $this->post('previousodometer');
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
                        
                        $rsm_config = $this->preventive;
                        $this->upload->initialize($rsm_config);
                        if (!$this->upload->do_upload('photo')) {
                            $this->output->message = "Photo type is invalid .. Please upload again..!";
                            $upload_err = TRUE;
                            $this->response([
                                'data' => $this->output->message,
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                            die;
                        }else{
                            $media_args['media_name'] = $_FILES['photo']['name'];
                            // $media_args['user_id'] = $offRoadId;
                            $media_args['media_data'] = 'preventive';
                            array_push($media_args1,$media_args);
                            // $this->user->insert_media_maintance($media_args);
                        }
                    }
                }
            }
            $preventiveId = $this->user->insertPreventiveRoad($preventive);
            $addSummery = $this->user->insertAmbSummery($summery);
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if(!empty($media_args)){
                $media_args['user_id'] = $preventiveId;
                foreach($media_args1 as $media_args2){
                    $media_args_merge = array_merge($media_args2,$media_args);
                    $this->user->insert_media_maintance($media_args_merge);
                }
            }
            if(!empty($preventiveId) && !empty($addSummery) && !empty($addtimestamp)){
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
    
public function preventivemaintenancedetails_post(){
       
       if((isset($_COOKIE['cookie']))){
          $requestId = $this->post('requestId');
          $preventivedetailsarr = $this->user->getpreventivemaintenanceDetails($requestId);
   if(empty($preventivedetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{            
          $mediatype='5';
           $media = $this->user->getmedia($requestId,$mediatype);    
		   
		   $distcode= $preventivedetailsarr[0]['mt_district_id'];
           $dist = explode(',',$preventivedetailsarr[0]['mt_district_manager']);
                    $distManager = array();
                    foreach($dist as $dist1){
                    $distManager1 = $this->user->getcurrentDistManager($distcode);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
                       
                     
     $mt_stnd_remark = $preventivedetailsarr[0]['mt_stnd_remark'];  
     $approveRem = $this->user->getApproveRema($mt_stnd_remark);

       if(!empty($preventivedetailsarr[0]['mt_end_odometer']))
        {
            $enodometer=$preventivedetailsarr[0]['mt_end_odometer'];                
        } 
        else{
             $enodometer=$preventivedetailsarr[0]['mt_in_odometer'];    
        }        
      $maintenanceType = 16;
      $miantaincehistory = $this->user->maintaincehisotory($requestId,$maintenanceType);
      if(!empty($miantaincehistory))
           {
              $otheruseremark= $miantaincehistory[0]['re_remark'];
           }
           else
           {
               $otheruseremark= '';
           }    
       if($preventivedetailsarr[0]['mt_ambulance_status'] == "Pending Approval"){
          
              $approvedcost = $preventivedetailsarr[0]['mt_app_est_amt'];
            }
            else{
                
                if(!empty($preventivedetailsarr[0]['mt_app_est_amt']))
                {
                    $approvedcost = $preventivedetailsarr[0]['mt_app_est_amt'];
                }
                else{
                    
                     $approvedcost = $preventivedetailsarr[0]['mt_Estimatecost'];
                     
                }
            
            }   
                $data = array(
                        'requestId' => (int) $preventivedetailsarr[0]['mt_id'],
                        'previosOdometer' => $preventivedetailsarr[0]['mt_previos_odometer'],
                        'endOdometer' =>  $preventivedetailsarr[0]['mt_end_odometer'],
                        'inOdometer' => $preventivedetailsarr[0]['mt_in_odometer'],
                        'scheduleService' => $preventivedetailsarr[0]['mt_schedule_service'],
                        'serviceName' => $preventivedetailsarr[0]['mt_service_name'],
                        'workShop' => $preventivedetailsarr[0]['mt_work_shop'],//confirm work shop name
                        'estimateCost' => $preventivedetailsarr[0]['mt_Estimatecost'],
                        'approvedCost'=>$approvedcost,
                        'otherUserRemark ' => $otheruseremark,
                        'exOnroadDatetime' => $preventivedetailsarr[0]['mt_ex_onroad_datetime'],
                        'informedTo' => json_decode($preventivedetailsarr[0]['mt_informed_group']),
                        'uploadedImages' => $media,
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