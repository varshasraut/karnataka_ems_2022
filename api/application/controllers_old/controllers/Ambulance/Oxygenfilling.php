<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Oxygenfilling extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $type = $this->post('type');
            $ambulanceNo = $this->post('vehicleNumber');
            $cylinder = $this->post('cylinderType');
            $oxyStation = $this->post('oxyStation');
            $oxyAmt = $this->post('oxyAmt');
            $oxyQuan = $this->post('oxyQuan');
            $paymentMode = $this->post('paymentMode');
            $otherPaymentMode = $this->post('otherPaymentMode');
            $cardExpdate = $this->post('cardExpdate');
            $distManager = $this->post('distManager');
            $stndRemark = $this->post('stndRemark');
            $otherRemark = $this->post('otherRemark');
            $fillingdate = date('Y-m-d H:i:s');
            $previousOdometer = $this->post('endOdometer');
            $currentOdometer = $this->post('startOdometer');
            $ambStstus['amb_status'] = 8;
            $ambStatus1 = $this->user->getAmbStatus($ambStstus['amb_status']);
            $SummeryOffRdStatus = $ambStatus1[0]['ambs_name'];
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
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
            $oxy['of_amb_ref_no'] = $ambulanceNo;
            $oxy['of_state_code'] = $amb[0]['amb_state'];
            $oxy['of_district_code'] = $amb[0]['amb_district'];
            $oxy['of_base_location'] = $amb[0]['hp_name'];
            $oxy['amb_oxygen_status'] = "Stand By Oxygen Filling";
            $oxy['of_oxygen_station'] = $oxyStation;
            $oxy['of_cylinder_type'] = $cylinder;
            $oxy['of_oxygen_amount'] =  $oxyAmt;
            $oxy['of_oxygen_quantity'] = $oxyQuan;
            $oxy['of_payment_mode'] = $paymentMode;
            $oxy['of_payment_other_mode'] = $otherPaymentMode;
            $oxy['of_card_date'] = $cardExpdate;
            $oxy['of_filling_date'] = $fillingdate;
            $oxy['of_standard_remark'] = $stndRemark;
            $oxy['of_other_remark'] = $otherRemark;
            $oxy['of_added_by'] = $loginUser;
            $oxy['of_in_odometer'] = $currentOdometer;
            $oxy['of_prevoius_odometer'] = $previousOdometer;
            $oxy['of_added_date'] = date('Y-m-d H:i:s');
            $oxy['of_base_month'] = $baseMonth[0]['months'];
            if(count($distManager) > 0){
                $distId = array();
                foreach($distManager as $distManager1){
                    $distId1 = $distManager1['id'];
                    array_push($distId,$distId1);
                }
                $oxy['of_dist_manager'] = implode(',',$distId);
            }else{
                $oxy['of_dist_manager'] = $distManager['id'];
            }

            $ambStstus['amb_status'] = '8';
            $oxygen = $this->user->insertOxyFilling($oxy);
            $ambStstusData = $this->user->updateAmbStatus($ambStstus,$ambulanceNo);
            $summery['amb_rto_register_no'] = $ambulanceNo;
            $summery['amb_status'] = (int) $ambStstus['amb_status'];
            $summery['off_road_status'] = $SummeryOffRdStatus;
            $summery['off_road_remark'] = $stndRemark;
            $summery['off_road_remark_other'] = $otherRemark;
            $summery['off_road_date'] = date('Y-m-d');
            $summery['off_road_time'] = date('H:i:s');
            $summery['start_odometer'] = $currentOdometer;
            $summery['added_date'] = date('Y-m-d H:i:s');
            $addSummery = $this->user->insertAmbSummery($summery);
            $timestamp['amb_rto_register_no'] = $ambulanceNo;
            $timestamp['start_odmeter'] = $previousOdometer;
            $timestamp['end_odmeter'] = $currentOdometer;
            $timestamp['total_km'] = $currentOdometer - $previousOdometer;
            $timestamp['timestamp'] = date('Y-m-d H:i:s');
            $timestamp['remark'] = $stndRemark;
            $timetsamp['odometer_date'] = date('Y-m-d');
            $timetsamp['odometer_time'] = date('H:i:s');
            $timestamp['other_remark'] = $otherRemark ? $otherRemark : "";
            $timestamp['remark_type'] = 'oxygen_filling';
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if(!empty($oxygen) && $ambStstusData == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Insert Successfully',
                        'requestId' => $oxygen
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'code' => 2,
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
    public function updateoxygen_post(){
        if((isset($_COOKIE['cookie']))){
            $type = $this->post('type');
            $stndRemark = $this->post('stndRemark');
            $otherRemark = $this->post('otherRemark');
            $requestId = $this->post('requestId');
            $onRoaddateTime = $this->post('onRoaddateTime');
            $endOdometer = $this->post('endOdometer');
            $ambulanceNo = $this->post('vehicleNumber');
            $previousOdometer = $this->post('previousOdometer');
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
            $oxy['amb_oxygen_status'] = "Available";
            $oxy['of_modify_by'] = $loginUser;
            $oxy['of_modify_date'] = date('Y-m-d H:i:s');
            $oxy['mt_on_stnd_remark'] = $stndRemark;
            $oxy['mt_on_remark'] = $otherRemark;
            $oxy['is_updated'] = "1";
            $oxy['of_on_road_ambulance'] = $onRoaddateTime;
            $updateOxy = $this->user->updateOxyFilling($oxy,$requestId);
            $ambStstus['amb_status'] = '1';
            $ambStstus['amb_status_oxy'] = '1';
            $ambStstusData = $this->user->updateAmbStatus($ambStstus,$ambulanceNo);
            $summery['on_road_status'] = "Oxygen filling on road";
            $summery['on_road_remark'] = $stndRemark;
            $summery['on_road_remark_other'] = $otherRemark;
            $summery['on_road_date'] = date('Y-m-d');
            $summery['on_road_time'] = date('H:i:s');
            $summery['end_odometer'] = $endOdometer;
            $summery['modify_date'] = date('Y-d-m H:i:s');
            $summery['amb_status'] = '8,1';
            $ambStatus1['amb_status_chk'] = '8';
            $ambStatus1['ambNo'] = $ambulanceNo;
            $ambStatus2 = $this->user->getAmbStatus($ambStatus1['amb_status_chk']);
            $SummeryOffRdStatus = $ambStatus2[0]['ambs_name'];
            $ambStatus1['off_road_status'] = $SummeryOffRdStatus;
            $updateAmbStatus = $this->user->updateSummery($ambStatus1,$summery);
            $timestamp['amb_rto_register_no'] = $ambulanceNo;
            $timestamp['start_odmeter'] = $previousOdometer;
            $timestamp['end_odmeter'] = $endOdometer;
            $timestamp['total_km'] = $endOdometer - $previousOdometer;
            $timestamp['timestamp'] = date('Y-m-d H:i:s');
            $timestamp['remark'] = $stndRemark;
            $timestamp['other_remark'] = $otherRemark ? $otherRemark : "";
            $timestamp['remark_type'] = 'oxygen_filling';
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if($updateOxy == 1){
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Update Successfully'
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'code' => 2,
                        'message' => 'Not Updated'
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
    public function oxystndremark_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->getOxyRemark();
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
    public function oxystndUpdateremark_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->getOxyUpdateRemark();
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
    public function oygentStation_post(){
        if((isset($_COOKIE['cookie']))){
            $station = $this->user->getOxygenStation();
            $data1 = array();
            foreach($station as $station1){
                $data = array(
                    'id' => (int) $station1['os_id'],
                    'name' => $station1['os_oxygen_name']
                );
                array_push($data1,$data);
            }
            $this->response([
                'data' => $data1,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

public function listOxygenfilling_post(){
      
         $type = $this->post('type');
         $pageIndex = $this->post('pageIndex');
         $pageSize = $this->post('pageSize');
         $begin = ($pageIndex * $pageSize) - $pageSize;       
 
     if((isset($_COOKIE['cookie']))){
	    
	    $indReq = $this->user->getalllistOxygenfilling($begin,$pageSize);
	    
		if(!empty($indReq)){
            $indRec = array();
            foreach($indReq as $indReq1){
                if($indReq1['is_updated'] == '1'){
                    $status = "Completed";
                }else {
                    $status = "Sent";
                }
                $indRec1 = array(
                    'id' => (int) $indReq1['of_id'],
                    'dateTime' => $indReq1['of_added_date'],
                    'district' => $indReq1['dst_name'],
                    'baseLocation'=>$indReq1['of_base_location'],
                    'ambRegNo' => $indReq1['of_amb_ref_no'],
                    'status' => $status
                );
                array_push($indRec,$indRec1);
            }
            $this->response([
                'data' => $indRec,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
		else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
		
	}
	      
	  }
	else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
	

        }
 
   }
public function oxygenfillingdetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $accidentaldetailsarr = $this->user->getoxygenfillingDetails($requestId);
    
     if(empty($accidentaldetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{
   
      
       $dist = explode(',',$accidentaldetailsarr[0]['of_dist_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
      $mt_stnd_remark = $accidentaldetailsarr[0]['of_standard_remark'];
      $approveRem = $this->user->getApproveRema($mt_stnd_remark);
         
          if($accidentaldetailsarr[0]['of_filling_date'] == "0000-00-00 00:00:00")
            {
              $accidentaldetailsarr[0]['of_filling_date']=null;
                        
            } 
            if($accidentaldetailsarr[0]['of_on_road_ambulance'] == "0000-00-00 00:00:00")
             {
              $accidentaldetailsarr[0]['of_on_road_ambulance']=null;
                        
             }
                
     
      
         $data = array(
                        'requestId' => (int) $accidentaldetailsarr[0]['of_id'],
                        'stateCode' => $accidentaldetailsarr[0]['dst_state'],
                        'district' => $accidentaldetailsarr[0]['dst_name'],
                        'ambRegNo' => $accidentaldetailsarr[0]['of_amb_ref_no'],
                        'baseLocation' => $accidentaldetailsarr[0]['of_base_location'],
                        'oxygenStation' => $accidentaldetailsarr[0]['os_oxygen_name'],
                        'oxygenStatus' => $accidentaldetailsarr[0]['amb_oxygen_status'],
                        'cylinderType' => $accidentaldetailsarr[0]['of_cylinder_type'],
                        'oxygenAmount' => $accidentaldetailsarr[0]['of_oxygen_amount'],
                        'oxygenQuantity' => $accidentaldetailsarr[0]['of_oxygen_quantity'],
                        'paymentMode' => $accidentaldetailsarr[0]['of_payment_mode'],
                        'previosOdometer' => $accidentaldetailsarr[0]['of_prevoius_odometer'],
                        'endOdometer' => $accidentaldetailsarr[0]['of_in_odometer'],
                        'cardDate' => $accidentaldetailsarr[0]['of_card_date'],
                        'fillingDate' => $accidentaldetailsarr[0]['of_filling_date'],
                        'remark' => json_decode($accidentaldetailsarr[0]['of_other_remark']),
                        'supervisor' => $accidentaldetailsarr[0]['of_supervisor'],
                        'onroadAmbulance' => $accidentaldetailsarr[0]['of_on_road_ambulance'],
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