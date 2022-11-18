<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Fuelfilling extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $type = $this->post('type');
            $ambulanceNo = $this->post('vehicleNumber');
            $fuelStation = $this->post('fuelStation');
            $stndRemark = $this->post('stndRemark');
            $otherRemark = $this->post('otherRemark');
            $distManager1 = $this->post('distManager');
            $paymentMode = $this->post('paymentMode');
            $otherPaymentMode = $this->post('otherPaymentMode');
            $cardExpdate = $this->post('cardExpdate');
            $voucherNo = $this->post('voucherNo');
            $fuelQuan = $this->post('fuelQuan');
            $fuelAmt = $this->post('fuelAmt');
            $previousOdometer = $this->post('endOdometer');
            $currentOdometer = $this->post('startOdometer');
            $ambStstus['amb_status'] = 9;
            $ambStstus['amb_status_fuel'] = 9;
            $ambStatus1 = $this->user->getAmbStatus($ambStstus['amb_status']);
            $SummeryOffRdStatus = $ambStatus1[0]['ambs_name'];
            $dist = array();
            foreach($distManager1 as $distManager2){
                $dist1 = implode(',',$distManager2);
                array_push($dist,$dist1);
            }
            $distManager = implode(',',$dist);
            $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
            $station = $this->user->getfuelstation($fuelStation);
            // $previousodometers = $this->user->getendodometer($ambulanceNo);
            $requestId = $this->post('requestId');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id,$type);
            // $user = array();
            if($type == 3){
                $userLoginArr = explode(',',$logindata['id']);
                $userLoginArr1 = explode(',',$logindata['login_type']);
                $added_by = array();
                    for($i=0;$i<count($userLoginArr);$i++){
                        if($userLoginArr[$i] && $userLoginArr1[$i] == 'D'){
                            $user2 = $this->user->getClgRefid($userLoginArr[$i]);
                            $data['ff_pilot_id'] = $userLoginArr[$i];
                            $data['ff_pilot_name'] = $user2;
                            array_push($added_by,$data['ff_pilot_name']);
                        }else if($userLoginArr[$i] && $userLoginArr1[$i] == 'P'){
                            $user1 = $this->user->getClgRefid($userLoginArr[$i]);
                            $data['ff_emso_id'] = $userLoginArr[$i];
                            $data['ff_emso_name'] = $user1;
                            array_push($added_by,$data['ff_emso_name']);
                        }
                    }
                    $data['ff_added_by'] = implode(',',$added_by);
                    $data2['ff_modify_by'] = implode(',',$added_by);
            }else if($type == 1){
                $loginUser = $this->user->getClgRefid($logindata['id']);
                $data['ff_pilot_id'] = $logindata['id'];
                $data['ff_pilot_name'] = $loginUser;
                $data['ff_added_by'] = $data['ff_pilot_name'];
                $data2['ff_modify_by'] = $data['ff_pilot_name'];
            }else{
                $loginUser = $this->user->getClgRefid($logindata['id']);
                $data['ff_emso_id'] =$logindata['id'];
                $data['ff_emso_name'] = $loginUser;
                $data['ff_added_by'] = $data['ff_emso_name'];
                $data2['ff_modify_by'] = $data['ff_emso_name'];
            }
            if(empty($requestId)){
                $baseMonth = $this->CommonModel->baseMonth();
                $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
                if($logindata == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Wrong Type'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
                else{
                    if(!empty($amb) && !empty($station)){
                        // print_r('jjj');
                        $data['ff_amb_ref_no'] = $ambulanceNo;
                        $data['ff_fuel_station'] = $fuelStation;
                        $data['ff_fuel_address'] = $station ? $station[0]['f_google_address'] : "";
                        $data['ff_fuel_mobile_no'] = $station ? $station[0]['f_mobile_no'] : "";
                        // $data1['amb_status'] = $this->post('ambulanceStatus');
                        $data['ff_fuel_quantity'] = $fuelQuan;
                        $data['ff_previous_odometer'] = $previousOdometer;
                        $data['ff_in_odometer'] = $currentOdometer;
                        $data['ff_fuel_date_time'] = date('Y-m-d H:i:s');
                        $data['ff_amount'] = $fuelAmt;
                        $data['ff_payment_mode'] = $paymentMode;
                        $data['ff_voucher_no'] = $voucherNo;
                        $data['ff_card_date'] = $cardExpdate;
                        $data['ff_dist_manager'] = $distManager;
                        $data['ff_standard_remark'] = $stndRemark;
                        $data['ff_base_month'] = $baseMonth[0]['months'];
                        $data['ff_state_code'] = $amb[0]['amb_state'];
                        $data['ff_district_code'] =$amb[0]['amb_district'];
                        $data['ff_base_location'] = $amb[0]['hp_name'];
                        $data['ff_other_remark'] = $otherRemark ? $otherRemark : "";
                        $data['ff_added_date'] = date('Y-m-d H:i:s');
                        $data['amb_fuel_status'] = "Stand By Fuel Filling";
                        $data['ff_voucher_no'] = $voucherNo;
                        $data['ff_payment_other_mode'] = $otherPaymentMode;
                        $fuelfilling = $this->user->insertfuelfilling($data);
                        // $ambStatus1 = $this->user->updateAmbStatus($ambStstus,$ambulanceNo);
                        $summery['amb_rto_register_no'] = $ambulanceNo;
                        $summery['amb_status'] = (int) $ambStstus['amb_status'];
                        $summery['off_road_status'] = $SummeryOffRdStatus;
                        $summery['off_road_remark'] = $stndRemark;
                        $summery['off_road_remark_other'] = $otherRemark ? $otherRemark : "";
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
                        $timestamp['other_remark'] = $otherRemark ? $otherRemark : "";
                        $timestamp['remark_type'] = 'fuel_filling';
                        $addtimestamp = $this->user->insertTimestampRec($timestamp);
                        
                        if((!empty($fuelfilling)) && ($addtimestamp == 1) && ($addSummery == 1)){
                            
                            $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Insert Successfully',
                                    'requestId' => $fuelfilling
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
                }
                
            }else{
                $data2['ff_on_road_ambulance'] = $this->post('onRoadAmbDateTime');
                $data2['mt_on_stnd_remark'] = $this->post('OnStndRemark');
                $data2['mt_on_remark'] = $this->post('onRemark');
                $data2['amb_fuel_status'] = "Available";
                $data2['is_updated'] = '1';
                $data2['ff_modify_date'] = date('Y-d-m H:i:s');
                $fuelfilling = $this->user->updatefuelfillings($requestId,$data2);
                $ambStatus['amb_status'] = '1';
                // $ambStatusUpdate = $this->user->updateAmbStatus($ambStatus,$ambulanceNo);
                $summery['on_road_status'] = "Fuel filling on road";
                $summery['on_road_remark'] = $this->post('onRemark');
                $summery['on_road_remark_other'] = $this->post('OnStndRemark');
                $summery['on_road_date'] = date('Y-m-d');
                $summery['on_road_time'] = date('H:i:s');
                $summery['end_odometer'] = $this->post('updateendodometer');
                $summery['modify_date'] = date('Y-d-m H:i:s');
                $summery['amb_status'] = '9,1';
                $ambStatus1['amb_status_chk'] = '9';
                $ambStatus1['ambNo'] = $ambulanceNo;
                $ambStatus1['off_road_status'] = $SummeryOffRdStatus;
                $updateAmbStatus = $this->user->updateSummery($ambStatus1,$summery);
                $Odometer = $this->user->getendodometer($ambulanceNo);
                $previousOdometer = $Odometer['endOdometer'];
                $timestamp['amb_rto_register_no'] = $ambulanceNo;
                $timestamp['start_odmeter'] = $previousOdometer;
                $timestamp['end_odmeter'] = $this->post('endodometer');
                $timestamp['total_km'] = $this->post('endodometer') - $this->post('previousodometer');
                $timestamp['timestamp'] = date('Y-m-d H:i:s');
                $timestamp['remark'] = $this->post('standardremark');
                $timestamp['other_remark'] = $otherRemark ? $otherRemark : "";
                $addtimestamp = $this->user->insertTimestampRec($timestamp);
                if(($fuelfilling == 1) && ($addtimestamp == 1) || ($updateAmbStatus == 1)){
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
                            'code' => 1,
                            'message' => 'Not Updated'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            } 
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function updatefuelfilling_post(){
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
            $data2['ff_on_road_ambulance'] = $onRoaddateTime;
            $data2['mt_on_stnd_remark'] = $stndRemark;
            $data2['mt_on_remark'] = $otherRemark;
            $data2['amb_fuel_status'] = "Available";
            $data2['is_updated'] = '1';
            $data2['ff_modify_date'] = date('Y-d-m H:i:s');
            $data2['ff_end_odometer'] = $endOdometer;
            $fuelfilling = $this->user->updatefuelfillings($requestId,$data2);
            $ambStatus['amb_status'] = '1';
            $ambStatus['amb_status_fuel'] = '1';
            // $ambStatusUpdate = $this->user->updateAmbStatus($ambStatus,$ambulanceNo);
            $summery['on_road_status'] = "Fuel filling on road";
            $summery['on_road_remark'] = $stndRemark;
            $summery['on_road_remark_other'] = $otherRemark;
            $summery['on_road_date'] = date('Y-m-d');
            $summery['on_road_time'] = date('H:i:s');
            $summery['end_odometer'] = $endOdometer;
            $summery['modify_date'] = date('Y-d-m H:i:s');
            $summery['amb_status'] = '9,1';
            $timestamp['remark_type'] = 'fuel_filling';
            $ambStatus1['amb_status_chk'] = '9';
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
            $addtimestamp = $this->user->insertTimestampRec($timestamp);
            if(($fuelfilling == 1) && ($addtimestamp == 1) || ($updateAmbStatus == 1)){
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
                        'code' => 1,
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
    public function fuelstndremark_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->getFuelRemark();
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
    public function fuelstndUpdateremark_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->getFuelUpdateRemark();
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
    public function viewFuelFilling_post(){
        if((isset($_COOKIE['cookie']))){
            $ambulanceNo = $this->post('ambulanceNo');
            $previousOdometer = $this->user->getendodometer($ambulanceNo);
            $requestId = $this->post('requestId');
            $fuelFilling = $this->user->getFuelFilling($requestId);
            if(!empty($fuelFilling)){
                $dist = explode(',',$fuelFilling[0]['ff_dist_manager']);
                $distManager = array();
                foreach($dist as $district){
                    $dist2 = $this->user->getDistrictManager($district);
                    foreach($dist2 as $dist3){
                        $dist1 = array(
                            'id' =>  (int) $dist3['clg_id'],
                            'name' => $dist3['clg_ref_id']
                        );
                        array_push($distManager,$dist1);
                    }
                }
                $this->response([
                    'data' => ([
                        'id' => $fuelFilling[0]['ff_id'],
                        'state' => $fuelFilling[0]['ff_state_code'],
                        'district' => $fuelFilling[0]['dst_name'],
                        'baseLocation' => $fuelFilling[0]['ff_base_location'],
                        'fuelStation' => $fuelFilling[0]['f_station_name'],
                        'fuelquantity' => $fuelFilling[0]['ff_fuel_quantity'],
                        'previousOdometer' => $previousOdometer ? $previousOdometer['endOdometer'] : "",
                        'currentOdometer' => $fuelFilling[0]['ff_previous_odometer'],
                        'dateTime' => $fuelFilling[0]['ff_added_date'],
                        'fuelAmt' => $fuelFilling[0]['ff_amount'],
                        'paymentMode' => $fuelFilling[0]['ff_payment_mode'],
                        'voucherNo' => $fuelFilling[0]['ff_voucher_no'],
                        'remark' => $fuelFilling[0]['message'],
                        'districtManager' => $distManager
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
    public function fuelStation_post(){
        if((isset($_COOKIE['cookie']))){
            $station = $this->user->FuelStation();
            $data1 = array();
            foreach($station as $station1){
                $data = array(
                    'id' => (int) $station1['f_id'],
                    'name' => $station1['f_station_name']
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
    

public function listFuelfilling_post(){
      
         $type = $this->post('type');
         $pageIndex = $this->post('pageIndex');
         $pageSize = $this->post('pageSize');
         $begin = ($pageIndex * $pageSize) - $pageSize;       
 
     if((isset($_COOKIE['cookie']))){
	    
	    $indReq = $this->user->getalllistFuelfilling($begin,$pageSize);
	    
		if(!empty($indReq)){
            $indRec = array();
            foreach($indReq as $indReq1){
                if($indReq1['is_updated'] == '1'){
                    $status = "Completed";
                }else {
                    $status = "Sent";
                }
                $indRec1 = array(
                    'id' => (int) $indReq1['ff_id'],
                    'dateTime' => $indReq1['ff_added_date'],
                    'district' => $indReq1['dst_name'],
                    'baseLocation'=>$indReq1['ff_base_location'],
                    'ambRegNo' => $indReq1['ff_amb_ref_no'],
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
   
public function fuelfillingdetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $accidentaldetailsarr = $this->user->getfuelfillingDetails($requestId);
    
    
     if(empty($accidentaldetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{
   
      
       $dist = explode(',',$accidentaldetailsarr[0]['ff_dist_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
      $mt_stnd_remark = $accidentaldetailsarr[0]['ff_standard_remark'];
      $approveRem = $this->user->getApproveRema($mt_stnd_remark);
    
         if($accidentaldetailsarr[0]['ff_fuel_date_time'] == "0000-00-00 00:00:00")
          {
                $accidentaldetailsarr[0]['ff_fuel_date_time']=null;
                        
          } 
         if($accidentaldetailsarr[0]['ff_on_road_ambulance'] == "0000-00-00 00:00:00" || $accidentaldetailsarr[0]['ff_on_road_ambulance'] =="")
         {
                $accidentaldetailsarr[0]['ff_on_road_ambulance']=null;
                        
          }
                
    
    
         $data = array(
                        'requestId' => (int) $accidentaldetailsarr[0]['ff_id'],
                        'stateCode' => $accidentaldetailsarr[0]['dst_state'],
                        'district' => $accidentaldetailsarr[0]['dst_name'],
                        'ambRegNo' => $accidentaldetailsarr[0]['ff_amb_ref_no'],
                        'baseLocation' => $accidentaldetailsarr[0]['ff_base_location'],
                        'fuelstation' => $accidentaldetailsarr[0]['f_station_name'],
                        'fuelAddress' => $accidentaldetailsarr[0]['ff_fuel_address'],
                        'fuelStatus' => $accidentaldetailsarr[0]['amb_fuel_status'],
                        'fuelMobileno' => $accidentaldetailsarr[0]['ff_fuel_mobile_no'],
                        'fillingDate' => $accidentaldetailsarr[0]['ff_fuel_date_time'],
                        'fuelQuantity' => $accidentaldetailsarr[0]['ff_fuel_quantity'],
                        'fuelamount' => $accidentaldetailsarr[0]['ff_amount'],
                        'previosOdometer' => $accidentaldetailsarr[0]['ff_previous_odometer'],
                        'endOdometer' => $accidentaldetailsarr[0]['ff_in_odometer'],
                        'paymentMode' => $accidentaldetailsarr[0]['ff_payment_mode'],
                        'remark' => $accidentaldetailsarr[0]['ff_other_remark'],
                        'cardDate' => $accidentaldetailsarr[0]['ff_card_date'],
                        'higherautorityName' => $accidentaldetailsarr[0]['ff_higher_autority_name'],
                        'higherautoritynameOther'=> $accidentaldetailsarr[0]['ff_higher_autority_name_other'],
                         'authorityName'=> $accidentaldetailsarr[0]['ff_authority_name'],
                        'onroadAmbulance'=> $accidentaldetailsarr[0]['ff_on_road_ambulance'],
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