<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Offroadmaintenance extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->offroad = $this->config->item('offroad');
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
            $currentOdometer = $this->post('currentOdometer');
            $informed = $this->post('informed');
            $photoEmpty = $this->post('photoEmpty');
            $distManager = implode(',',$this->post('distManager'));
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
            $previousOdometer = $this->user->getendodometer($ambulanceNo);
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

            /*Add 'ems_amb_onroad_offroad' table */
            $offRoad['mt_amb_no'] = $ambulanceNo;
            $offRoad['mt_state_id'] = $amb[0]['amb_state'];
            $offRoad['mt_district_id'] = $amb[0]['amb_district'];
            $offRoad['mt_base_loc'] = $amb[0]['hp_name'];
            $offRoad['mt_Estimatecost'] = $estimateCost;
            $offRoad['mt_previos_odometer'] = $previousOdometer ? $previousOdometer['endOdometer'] : "0";
            $offRoad['mt_ex_onroad_datetime'] = $expOnroadDateTime;
            $offRoad['mt_stnd_remark'] = $standardremark;
            $offRoad['mt_remark'] = $remark;
            $offRoad['mt_district_manager'] = $distManager;
            $offRoad['mt_informed_group'] = json_encode($informed);
            $offRoad['mt_type'] = "onroad_offroad";
            $offRoad['mt_ambulance_status'] = "Pending Approval";
            $offRoad['mt_base_month'] = $baseMonth[0]['months'];
            $offRoad['added_by'] = $loginUser;
            $offRoad['added_date'] = date('Y-m-d H:i:s');
            $offRoad['mt_isdeleted'] = '0';
            $offRoad['modify_by'] = $loginUser;
            $offRoad['modify_date'] = date('Y-m-d H:i:s');
            /*Add 'ems_ambulance_status_summary' table */
            $summery['amb_rto_register_no'] = $ambulanceNo;
            $summery['amb_status'] = 12;
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
                        
                        $rsm_config = $this->offroad;
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
                            $media_args['media_data'] = 'onroad_offroad';
                            array_push($media_args1,$media_args);
                            // $this->user->insert_media_maintance($media_args);
                        }
                    }
                }
            }
            $offRoadId = $this->user->insertOffRoad($offRoad);
            $addSummery = $this->user->insertAmbSummery($summery);
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if(!empty($media_args)){
                $media_args['user_id'] = $offRoadId;
                foreach($media_args1 as $media_args2){
                    $media_args_merge = array_merge($media_args2,$media_args);
                    $this->user->insert_media_maintance($media_args_merge);
                }
            }
            if(!empty($offRoadId) && !empty($addSummery) && !empty($addtimestamp)){
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
    public function rerequest_post(){
        $type = $this->post('type');
        $requestId = $this->post('requestId');
        $rereq_remark = $this->post('reReqRemark');
        $photoEmpty = $this->post('photoEmpty');
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
        $rerequest['mt_id'] = $requestId;
        $rerequest['re_mt_type'] = "onroad_offroad";
        $rerequest['re_request_remark'] = $rereq_remark;
        $rerequest['re_requestby'] = $loginUser;
        $rerequest['re_request_date'] = date('Y-m-d H:i:s');

      if($photoEmpty == 0){
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
                    
                    $rsm_config = $this->amb_pic;
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
                        $media_args['user_id'] = $requestId;
                        $media_args['media_data'] = 'onroad_offroad';
                        array_push($media_args1,$media_args);
                    }
                }
            }
        }
        $reRequestId = $this->user->insertReReq($rerequest);
        if(!empty($media_args)){
            $media_args['re_request_id'] = $reRequestId;
            foreach($media_args1 as $media_args2){
                $media_args_merge = array_merge($media_args2,$media_args);
                $this->user->insert_media_maintance($media_args_merge);
            }
        }
        if(!empty($reRequestId)){
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
    }
    public function updatererequest_post(){
        $requestId = $this->post('requestId');
        $type = $this->post('type');
        $remark = $this->post('remark');
        $standardremark = $this->post('standardremark');
        $ambulanceNo = $this->post('vehicleNumber');
        $onRoadDateTime = $this->post('onRoadDateTime');
        $currentOdometer = $this->post('currentOdometer');
        $previousOdometer = $this->user->getendodometer($ambulanceNo);

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
        /*Add 'ems_ambulance_timestamp_record' table */
        $timestamp['amb_rto_register_no'] = $ambulanceNo;
        $timestamp['start_odmeter'] = $previousOdometer ? $previousOdometer['endOdometer'] : "0";
        $timestamp['end_odmeter'] = $currentOdometer;
        $timestamp['total_km'] = $this->post('endodometer') - $timestamp['start_odmeter'];
        $timestamp['timestamp'] = date('Y-m-d H:i:s');
        $timestamp['remark'] = $standardremark;
        $timestamp['other_remark'] = $remark;
        $timestamp['modify_date'] = date('Y-m-d H:i:s');
        $addtimestamp = $this->user->insertTimestampRec($timestamp);
        /*Add 'ems_ambulance_status_summary' table */
        $amb_status_chk = '7';
        $summery['amb_rto_register_no'] = $ambulanceNo;
        $summery['amb_status'] = '7,1';
        $summery['on_road_status'] = "Ambulance onroad offroad maintenance on road";
        $summery['on_road_remark'] = $standardremark;
        $summery['on_road_remark_other'] = $remark;
        $summery['on_road_date'] = date('Y-m-d');
        $summery['on_road_time'] = date('H:i:s');
        $summery['end_odometer'] = $currentOdometer;
        $summery['added_date'] = date('Y-m-d H:i:s');
        $ambStatus1['off_road_status'] = "Ambulance onroad_offroad maintenance off road";
        $ambStatus1['ambNo'] = $ambulanceNo;
        $ambStatus1['amb_status_chk'] = $amb_status_chk;
        $updateSummery = $this->user->updateSummery($ambStatus1,$summery);
        /*Update 'ems_amb_onroad_offroad' table */
        $offRoad['mt_end_odometer'] = $currentOdometer;
        $offRoad['mt_onroad_datetime'] = $onRoadDateTime;
        $offRoad['mt_isupdated'] = '1';
        $offRoad['modify_by'] = $loginUser;
        $offRoad['modify_date'] = date('Y-m-d H:i:s');
        $offRoad['mt_ambulance_status'] = 'Available';
        $offRoad['mt_on_remark'] = $remark;
        $offRoad['mt_on_stnd_remark'] = $standardremark;
        $UpdateOffRoad = $this->user->updateOffRoad($requestId,$offRoad);
        if(!empty($addtimestamp) && !empty($updateSummery) && !empty($UpdateOffRoad)){
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
    }
    public function offroadstndremark_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->getoffroadstndremark();
            $data1 = array();
            foreach($remark as $remark1){
                $data = array(
                    'id' => (int) $remark1['id'],
                    'value' => $remark1['remark_val'],
                    'name' => $remark1['message']
                );
                array_push($data1,$data);
            }
            if(!empty($remark)){
                $this->response([
                    'data' => $data1,
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
    public function offroadstndremarkupdate_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->updateoffroadstndremark();
            $data1 = array();
            foreach($remark as $remark1){
                $data = array(
                    'id' => (int) $remark1['id'],
                    'value' => $remark1['remark_val'],
                    'name' => $remark1['message']
                );
                array_push($data1,$data);
            }
            if(!empty($remark)){
                $this->response([
                    'data' => $data1,
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
    
public function offroadmaintenancedetails_post(){
       
       if((isset($_COOKIE['cookie']))){
          $requestId = $this->post('requestId');
          $offroaddetailsarr = $this->user->getoffroadmaintanceDetails($requestId);
     if(empty($offroaddetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{         
          
          $mediatype='4';
           $media = $this->user->getmedia($requestId,$mediatype);  
             $distcode= $offroaddetailsarr[0]['mt_district_id'];
           $dist = explode(',',$offroaddetailsarr[0]['mt_district_manager']);
                    $distManager = array();
                    foreach($dist as $dist1){
                    $distManager1 = $this->user->getcurrentDistManager($distcode);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
   
          
     $mt_stnd_remark = $offroaddetailsarr[0]['mt_stnd_remark'];  
     $approveRem = $this->user->getApproveRema($mt_stnd_remark);
    
        if(!empty($offroaddetailsarr[0]['mt_end_odometer']))
        {
            $enodometer=$offroaddetailsarr[0]['mt_end_odometer'];                
        } 
        else{
             $enodometer=$offroaddetailsarr[0]['mt_in_odometer'];    
        }    
           $maintenanceType = 12;
     $miantaincehistory = $this->user->maintaincehisotory($requestId,$maintenanceType);
      if(!empty($miantaincehistory))
           {
              $otheruseremark= $miantaincehistory[0]['re_remark'];
           }
           else
           {
               $otheruseremark= '';
           }    
        if($offroaddetailsarr[0]['mt_ambulance_status'] == "Pending Approval"){
          
              $approvedcost = $offroaddetailsarr[0]['mt_Estimatecost'];
            }
            else{
                
                if(!empty($offroaddetailsarr[0]['mt_Estimatecost']))
                {
                    $approvedcost = $offroaddetailsarr[0]['mt_Estimatecost'];
                }
                else{
                    
                     $approvedcost = $offroaddetailsarr[0]['mt_Estimatecost'];
                     
                }
            
            }
           
        
        
          
      $data = array(
                'requestId' => (int) $offroaddetailsarr[0]['mt_id'],
                'previosOdometer' => $offroaddetailsarr[0]['mt_previos_odometer'],
                 'endOdometer' => $enodometer,
                'inOdometer' => $offroaddetailsarr[0]['mt_in_odometer'],
                'remark' => $offroaddetailsarr[0]['mt_remark'],
                'estimateCost' => $offroaddetailsarr[0]['mt_Estimatecost'],
                'approvedCost'=>$approvedcost,
                'otherUserRemark ' => $otheruseremark,
                'exOnroadDatetime' => $offroaddetailsarr[0]['mt_ex_onroad_datetime'], 
                'informedTo' => json_decode($offroaddetailsarr[0]['mt_informed_group']),
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