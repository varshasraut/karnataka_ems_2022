<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Tyremaintenance extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->load->helper('string');
        $this->amb_pic = $this->config->item('amb_pic');
        $this->accidental = $this->config->item('accidental');
        $this->breakdown = $this->config->item('breakdown');
        $this->offroad = $this->config->item('offroad');
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
            $tyreType = $this->post('tyreType');
            $estimateCost = $this->post('estimateCost');
            $uidNo = $this->post('uidNo');
            $informed = json_encode($this->post('informed'));
            $tyreModel = $this->post('tyreModel');
            $tyreRemark = $this->post('tyreRemark');
            $previousOdometer = $this->post('endOdometer');
            $photoEmpty = $this->post('photoEmpty');
            $distManager = implode(',',$this->post('distManager'));
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
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
            $tyre['mt_amb_no'] = $ambulanceNo;
            $tyre['mt_state_id'] = $amb[0]['amb_state'];
            $tyre['mt_district_id'] = $amb[0]['amb_district'];
            $tyre['mt_base_loc'] = $amb[0]['hp_name'];
            $tyre['mt_tyre_type'] = $tyreType;
            $tyre['mt_informed_group'] = $informed;
            $tyre['mt_estimate_cost'] = $estimateCost;
            $tyre['mt_uid_no'] = $uidNo;
            $tyre['mt_tyre_model'] = $tyreModel;
            $tyre['mt_tyre_remark'] = $tyreRemark;
            $tyre['mt_reported_date'] = date('Y-m-d H:i:s');
            // $tyre['mt_supervisor_name'] = $supervisorName;
          
            $tyre['mt_district_manager'] = $distManager;
            $tyre['mt_previos_odometer'] = $previousOdometer;
            $tyre['mt_ex_onroad_datetime'] = $expOnroadDateTime;
            $tyre['mt_stnd_remark'] = $standardremark;
            $tyre['mt_remark'] = $remark;
            $tyre['mt_type'] = 'tyre';
            $tyre['mt_ambulance_status'] = 'Pending Approval';
            $tyre['mt_base_month'] = $baseMonth[0]['months'];
            $tyre['added_by'] = $loginUser;
            $tyre['added_date'] = date('Y-m-d H:i:s');
            $tyre['modify_by'] = $loginUser;
            $tyre['modify_date'] = date('Y-m-d H:i:s');
            /*Add 'ems_ambulance_status_summary' table */
            $summery['amb_rto_register_no'] = $ambulanceNo;
            $summery['amb_status'] = 14;
            $summery['off_road_status'] = "Pending for approval";
            $summery['off_road_remark'] = $standardremark;
            $summery['off_road_remark_other'] = $remark;
            $summery['off_road_date'] = date('Y-m-d');
            $summery['off_road_time'] = date('H:i:s');
            $summery['start_odometer'] = $previousOdometer;
            $summery['added_date'] = date('Y-m-d H:i:s');
            /*Add 'ems_ambulance_timestamp_record' table */
            $timestamp['amb_rto_register_no'] = $ambulanceNo;
            $timestamp['start_odmeter'] = $previousOdometer;
            $timestamp['end_odmeter'] = $previousOdometer;
            $timestamp['total_km'] = $previousOdometer - $previousOdometer;
            $timestamp['timestamp'] = date('Y-m-d H:i:s');
            $timestamp['remark'] = $standardremark;
            $timestamp['other_remark'] = $remark;
            $timstamp['remark_type'] = 'tyre_maintenance';
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
                        
                        $rsm_config = $this->amb_pic;
                        $this->upload->initialize($rsm_config);
                        if (! $this->upload->do_upload('photo')) {
                            $this->response([
                                'data' => 'error',
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                            // die;
                        }else{
                            $media_args['media_name'] = $_FILES['photo']['name'];
                            $media_args['media_data'] = 'tyre';
                            array_push($media_args1,$media_args);
                            // $this->user->insert_media_maintance($media_args);
                        }
                    }
                }
            }
            $tyreId = $this->user->insertTyre($tyre);
            $addSummery = $this->user->insertAmbSummery($summery);
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if(!empty($media_args)){
                $media_args['user_id'] = $tyreId;
                foreach($media_args1 as $media_args2){
                    $media_args_merge = array_merge($media_args2,$media_args);
                    $this->user->insert_media_maintance($media_args_merge);
                }
            }
            if(!empty($tyreId) && !empty($addSummery) && !empty($addtimestamp)){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Insert Successfully',
                        'requestId' => $tyreId
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
    public function maintenanceList_post(){
        /*
        Tyre Maintennace = 14
        Accidental Maintenace = 7
        Breakdown Maintenance = 18
        OffRoad Maintenance = 12
        Preventive Maintenance = 16
        */
        if((isset($_COOKIE['cookie']))){
            $maintenanceType = $this->post('maintenanceType');
            $ambulanceNo = $this->post('vehicleNumber');
            $pageIndex = $this->post('pageIndex');
            $pageSize = $this->post('pageSize');
            $type = $this->post('type');
            $begin = ($pageIndex * $pageSize) - $pageSize; 
            $data['ambulanceNo'] = $ambulanceNo;
            $data['begin'] = $begin;
            $data['pageSize'] = $pageSize;
            $data['pageIndex'] = $pageIndex;
            
            if($type != 4){
				
                $list = $this->user->getMaintenanceList($maintenanceType,$data);
            }else{
				
                $list = $this->user->getMaintenanceListOUsr($maintenanceType,$data);
            }
            $this->response([
                'data' => $list,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function tyrerereuqestadd_post(){
         /*
        Tyre Maintennace = 14
        Accidental Maintenance = 7
        Breakdown Maintenance = 18
        OffRoad Maintenance = 12
        Preventive Maintenance = 16
        */
        $maintenanceType = $this->post('maintenanceType');
        $type = $this->post('type');
        $requestId = $this->post('requestId');
        $rereq_remark = $this->post('reReqRemark');
        $photoEmpty = $this->post('photoEmpty');
        if(!empty($type) && !empty($requestId) && !empty($rereq_remark)){
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
            if($maintenanceType == 14){
                $rerequest['re_mt_type'] = "tyre";
            }else if($maintenanceType == 7){
                $rerequest['re_mt_type'] = "accidental";
            }else if($maintenanceType == 18){
                $rerequest['re_mt_type'] = "breakdown";
            }else if($maintenanceType == 12){
                $rerequest['re_mt_type'] = "onroad_offroad";
            }else if($maintenanceType == 16){
                $rerequest['re_mt_type'] = "preventive";
            }
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
                        if($maintenanceType == 14){
                            $rsm_config = $this->amb_pic;
                        }else if($maintenanceType == 7){
                            $rsm_config = $this->accidental;
                        }else if($maintenanceType == 18){
                            $rsm_config = $this->breakdown;
                        }else if($maintenanceType == 12){
                            $rsm_config = $this->offroad;
                        }else if($maintenanceType == 16){
                            $rsm_config = $this->preventive;
                        }
                        $this->upload->initialize($rsm_config);
                        if (! $this->upload->do_upload('photo')) {
                             $this->response([
                                'data' => 'error',
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $media_args['media_name'] = $_FILES['photo']['name'];
                            $media_args['user_id'] = $requestId;
                            if($maintenanceType == 14){
                                $media_args['media_data'] = 'tyre';
                            }else if($maintenanceType == 7){
                                $media_args['media_data'] = "accidental";
                            }else if($maintenanceType == 18){
                                $media_args['media_data'] = "breakdown";
                            }else if($maintenanceType == 12){
                                $media_args['media_data'] = "onroad_offroad";
                            }else if($maintenanceType == 16){
                                $media_args['media_data'] = "preventive";
                            }
                            array_push($media_args1,$media_args);
                        }
                    }
                }
            }
            $this->user->udateMaintenanceHist($requestId,$rerequest);
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
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function rerequestdata_post(){
        /*
        Tyre Maintennace = 14
        Accidental Maintennace = 7
        Breakdown Maintenance = 18
        OffRoad Maintenance = 12
        Preventive Maintenance = 16
        */
        $maintenanceType = $this->post('maintenanceType');
        $requestId = $this->post('requestId');
        $ambulanceNo = $this->post('vehicleNumber');
        if(!empty($requestId) && !empty($ambulanceNo)){
                $data['requestId'] = $requestId;
                $data['ambulanceNo'] = $ambulanceNo;
                $data['maintenanceType'] = $maintenanceType;
            if($maintenanceType == '14'){
                $data['maintenance'] = 'tyre';
            }else if($maintenanceType == '7'){
                $data['maintenance'] = 'accidental';
            }else if($maintenanceType == '18'){
                $data['maintenance'] = 'breakdown';
            }else if($maintenanceType == '12'){
                $data['maintenance'] = 'onroad_offroad';
            }else if($maintenanceType == '16'){
                $data['maintenance'] = 'preventive';
            }
            $rerequest = $this->user->getReRequestdata($data);
            $this->response([
                'data' => $rerequest,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function tyremaintenanaceupdate_post(){
         /*
        Tyre Maintennace = 14
        Accidental Maintennace = 7
        Breakdown Maintenance = 18
        OffRoad Maintenance = 12
        Preventive Maintenance = 16
        */
        $maintenanceType = $this->post('maintenanceType');
        $requestId = $this->post('requestId');
        $type = $this->post('type');
        $remark = $this->post('remark');
        $standardremark = $this->post('standardremark');
        $ambulanceNo = $this->post('vehicleNumber');
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
        $timestamp['total_km'] = $currentOdometer - $timestamp['start_odmeter'];
        $timestamp['timestamp'] = date('Y-m-d H:i:s');
        $timestamp['remark'] = $standardremark;
        $timestamp['other_remark'] = $remark;
        if($maintenanceType == 14){
            $timstamp['remark_type'] = 'tyre_maintenance';
        }else if($maintenanceType == 7){
            $timstamp['remark_type'] = 'accidental_maintenance';
        }else if($maintenanceType == 18){
            $timstamp['remark_type'] = 'breakdown_maintenance';
        }else if($maintenanceType == 12){
            $timstamp['remark_type'] = 'offroad_maintenance';
        }else if($maintenanceType == 16){
            $timstamp['remark_type'] = 'preventive';
        }
        $addtimestamp = $this->user->insertTimestampRec($timestamp);
        /*Add 'ems_ambulance_status_summary' table */
        $summery['amb_rto_register_no'] = $ambulanceNo;
        if($maintenanceType == 14){
            $ambStatus1['off_road_status'] = "In Tyre Life Maintenance-OFF Road";
            $amb_status_chk = '14';
            $summery['amb_status'] = '14,1';
            $summery['on_road_status'] = "In Tyre Life Maintenance-On Road";
        }else if($maintenanceType == 7){
            $ambStatus1['off_road_status'] = "In Accidental Maintenance-OFF Road";
            $amb_status_chk = 7;
            $summery['amb_status'] = '7,1';
            $summery['on_road_status'] = "In Accidental Maintenance On Road";
        }else if($maintenanceType == 18){
            $ambStatus1['off_road_status'] = "In Breakdown Maintenance-OFF Road";
            $amb_status_chk = 18;
            $summery['amb_status'] = '18,1';
            $summery['on_road_status'] = "In Breakdown Maintenance On Road";
        }else if($maintenanceType == 12){
            $ambStatus1['off_road_status'] = "In Maintenance OFF Road";
            $amb_status_chk = 12;
            $summery['amb_status'] = '12,1';
            $summery['on_road_status'] = "In Maintenance On Road";
        }else if($maintenanceType == 16){
            $ambStatus1['off_road_status'] = "In Preventive Maintenance-OFF Road";
            $amb_status_chk = 16;
            $summery['amb_status'] = '16,1';
            $summery['on_road_status'] = "In Preventive Maintenance On Road";
        }
        $summery['on_road_remark'] = $standardremark;
        $summery['on_road_remark_other'] = $remark;
        $summery['on_road_date'] = date('Y-m-d');
        $summery['on_road_time'] = date('H:i:s');
        $summery['end_odometer'] = $currentOdometer;
        $summery['added_date'] = date('Y-m-d H:i:s');
        $summery['modify_date'] = date('Y-m-d H:i:s');
        $ambStatus1['ambNo'] = $ambulanceNo;
        $ambStatus1['amb_status_chk'] = $amb_status_chk;
        $updateSummery = $this->user->updateSummery($ambStatus1,$summery);
        
        /*Ambulance Status */
        $ambStstus['amb_status'] = '1';
        $ambStstusData = $this->user->updateAmbStatus($ambStstus,$ambulanceNo);
        
         /*Update 'ems_amb_onroad_offroad' table */
            $tyre['mt_end_odometer'] = $currentOdometer;
            $tyre['mt_onroad_datetime'] = date('Y-m-d H:i:s');
            $tyre['mt_isupdated'] = '1';
            $tyre['modify_by'] = $loginUser;
            $tyre['modify_date'] = date('Y-m-d H:i:s');
            $tyre['mt_ambulance_status'] = 'Available';
            $tyre['mt_on_remark'] = $remark;
            $tyre['mt_on_stnd_remark'] = $standardremark;
        if($maintenanceType == 14){
            $UpdateTyre = $this->user->updateTyreMaintennance($requestId,$tyre);
        }else if($maintenanceType == 7){
            $UpdateTyre = $this->user->updateAccidentalMaintennance($requestId,$tyre);
        }else if($maintenanceType == 18){
            $UpdateTyre = $this->user->updateBreakdownMaintennance($requestId,$tyre);
        }else if($maintenanceType == 12){
            $UpdateTyre = $this->user->updateOffroadMaintennance($requestId,$tyre);
        }else if($maintenanceType == 16){
            $UpdateTyre = $this->user->updatePreventiveMaintennance($requestId,$tyre);
        }
        // print_r($addtimestamp);echo '1';
        // print_r($updateSummery);echo '2';
        // print_r($UpdateTyre);echo '3';
        if(!empty($addtimestamp) && !empty($updateSummery) && !empty($UpdateTyre)){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Insert Successfully'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => 'Not Inserted'
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
    
 public function tyremaintenancedetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $tyrelifedetailsarr = $this->user->gettyremaintanceDetails($requestId);
if(empty($tyrelifedetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{       
      $mediatype='3';
       $media = $this->user->getmedia($requestId,$mediatype);    
  $distcode= $tyrelifedetailsarr[0]['mt_district_id'];
           $dist = explode(',',$tyrelifedetailsarr[0]['mt_district_manager']);
                    $distManager = array();
                    foreach($dist as $dist1){
                    $distManager1 = $this->user->getcurrentDistManager($distcode);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
     
       
     $mt_stnd_remark = $tyrelifedetailsarr[0]['mt_stnd_remark'];  
     $approveRem = $this->user->getApproveRema($mt_stnd_remark);
      $maintenanceType = 14;
     $miantaincehistory = $this->user->maintaincehisotory($requestId,$maintenanceType);
      if(!empty($miantaincehistory))
           {
              $otheruseremark= $miantaincehistory[0]['re_remark'];
           }
           else
           {
               $otheruseremark= '';
           }
       
        if(!empty($tyrelifedetailsarr[0]['mt_end_odometer']))
        {
            $enodometer=$tyrelifedetailsarr[0]['mt_end_odometer'];                
        } 
        else{
             $enodometer=$tyrelifedetailsarr[0]['mt_previos_odometer'];    
        } 
        
        if($tyrelifedetailsarr[0]['mt_ambulance_status'] == "Pending Approval"){
          
              $approvedcost = $tyrelifedetailsarr[0]['mt_approved_cost'];
            }
            else{
                
                if(!empty($tyrelifedetailsarr[0]['mt_approved_cost']))
                {
                    $approvedcost = $tyrelifedetailsarr[0]['mt_approved_cost'];
                }
                else{
                    
                     $approvedcost = $tyrelifedetailsarr[0]['mt_estimate_cost'];
                     
                }
            
            }
               
                     
          
    $data = array(
                'requestId' => (int) $tyrelifedetailsarr[0]['mt_id'],
                'tyreType' => $tyrelifedetailsarr[0]['mt_tyre_type'],
                'tyreModel' => $tyrelifedetailsarr[0]['mt_tyre_model'],
                'tyreRemark' => $tyrelifedetailsarr[0]['mt_tyre_remark'],
                'vehicleNumber' => $tyrelifedetailsarr[0]['mt_amb_no'],
                'uidNo' => $tyrelifedetailsarr[0]['mt_uid_no'],
                'previosOdometer' => $tyrelifedetailsarr[0]['mt_previos_odometer'],
                'endOdometer' => $enodometer,
                'estimateCost'=>$tyrelifedetailsarr[0]['mt_estimate_cost'],
                'approvedCost'=>$approvedcost,
                'inOdometer' => $tyrelifedetailsarr[0]['mt_in_odometer'],
                'remark' => $tyrelifedetailsarr[0]['mt_remark'],
                'otherUserRemark ' => $otheruseremark,
                'exOnroadDatetime' => $tyrelifedetailsarr[0]['mt_ex_onroad_datetime'], 
                'informedTo' => json_decode($tyrelifedetailsarr[0]['mt_informed_group']),
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