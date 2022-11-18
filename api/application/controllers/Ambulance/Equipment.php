<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Equipment extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
    }
    public function editequipmentlist_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $requestId = $this->post('requestId');
            if(!empty($patientId)){
                $args = "EQP";
                $consumable = $this->user->EquipmentList($patientId,$args);
            }else{
                $args = "Req";
                $consumable = $this->user->EquipmentList($requestId,$args);
            }
            if(!empty($consumable)){
                $this->response([
                    'data' => $consumable,
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_COntroller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function addequipment_post(){
        if((isset($_COOKIE['cookie']))){
            $requestId = $this->post('requestId');
            $type = $this->post('type');
            $ambulanceNo = $this->post('vehicleNumber');
            $expectedDate = $this->post('expectedDate');
            $distManager = $this->post('distManager');
            $dist = array();
            foreach($distManager as $distManager1){
                array_push($dist,$distManager1['id']);
            }
            $dist1 = implode(',',$dist);
            $stndRemark = $this->post('stndRemark');
            $list = $this->post('equipment');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id,$type);
            $user = array();
            if(empty($requestId)){
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
                $baseMonth = $this->CommonModel->baseMonth();
                $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);
                if($logindata == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 3,
                            'message' => 'Wrong Type'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    if(!empty($amb)){
                        $indReq['req_amb_reg_no'] = $amb[0]['amb_rto_register_no'];
                        $indReq['req_date'] = date('Y-m-d H:i:s');
                        $indReq['req_type'] = "amb";
                        $indReq['req_base_month'] = $baseMonth[0]['months'];
                        $indReq['req_state_code'] = $amb[0]['amb_state'];
                        $indReq['req_district_code'] = $amb[0]['amb_district'];
                        $indReq['req_base_location'] = $amb[0]['hp_name'];
                        $indReq['req_expected_date_time'] = $expectedDate;
                        $indReq['req_district_manager'] = $dist1;
                        $indReq['req_standard_remark'] = $stndRemark;
                        $indReq['req_emt_id'] = $loginUser;
                        $indReq['req_by'] = $loginUser;
                        $indReq['req_group'] = "EQUP";
                        $indReq['req_isdeleted'] = "0";
                        $insertId = $this->user->insertIndentReq($indReq);
                        foreach($list as $list1){
                            array(
                                $indItem['ind_item_id'] = $list1['id'],
                                $indItem['ind_quantity'] = $list1['count'],
                                $indItem['ind_item_type'] = $list1['req'],
                                $indItem['ind_req_id'] = $insertId,
                                $indItem['indis_deleted'] = '0'
                            );
                            $this->user->insertIndItem($indItem);
                        }
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
                                'code' => 2,
                                'message' => 'Ambulance Number Not Register'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                }
            }else{
                $indReq['req_expected_date_time'] = $expectedDate;
                $indReq['req_district_manager'] = $dist1;
                $indReq['req_standard_remark'] = $stndRemark;
                $this->user->updateIndentReq($requestId,$indReq);
                foreach($list as $list1){
                    array(
                        $indItem['ind_item_id'] = $list1['id'],
                        $indItem['ind_quantity'] = $list1['count'],
                        $indItem['ind_item_type'] = $list1['req'],
                        $indItem['ind_req_id'] = $requestId,
                        $indItem['indis_deleted'] = '0'
                    );
                    $this->user->insertIndItem($indItem);
                }
                $this->response([
                    'data' => ([
                        'code' => 1,
                        'message' => 'Update Successfully'
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
    public function editequipment_post(){
        if((isset($_COOKIE['cookie']))){
            $requestId = $this->post('requestId');
            $indReq = $this->user->editIndentReq($requestId);
            // print_r($indReq);
            if(!empty($indReq)){
                $equipment = array();
                $indReqItem = $this->user->getIndetnReqEquip($indReq[0]['req_id']);
                foreach($indReqItem as $indReqItem1){
                    if($indReqItem1['ind_item_type'] == 'EQP'){
                        $equipment1 = array(
                            'id' => (int) $indReqItem1['ind_item_id'],
                            'name' => $indReqItem1['eqp_name'],
                            'count' => (int) $indReqItem1['ind_quantity']
                        );
                        array_push($equipment,$equipment1);
                    }
                }
                if($indReq[0]['req_other_remark'] == ''){
                    $remark = array(
                        'id' => (int) $indReq[0]['id'],
                        'value' => $indReq[0]['remark_val'],
                        'name' => $indReq[0]['message']
                    );
                }else{
                    $remark = array(
                        'id' => 0,
                        'value' => "other",
                        'name' => $indReq[0]['req_other_remark']
                    );
                }
                $dist = array();
                if($indReq[1] != ""){
                    foreach($indReq[1] as $distManager){
                        $dist1 = array(
                            'id' => (int) $distManager[0]['clg_id'],
                            'name' => $distManager[0]['clg_ref_id']
                        );
                        array_push($dist,$dist1);
                    }
                }
                $this->response([
                    'data' => ([
                        'distManager' => $dist,
                        'stndRemark' => $remark,
                        'expectedDate' => $indReq[0]['req_expected_date_time'],
                        'equipment' => $equipment
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
    public function equipmentreceive_post(){
        if((isset($_COOKIE['cookie']))){
            $requestId = $this->post('requestId');
            $indReq = $this->user->equipmentReceive($requestId);
            if(!empty($indReq)){
                $dist = explode(',',$indReq[0]['req_district_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
            }
            $equipment = array();
            if (count($indReq) > 0) {
                $approveDate = $indReq[0]['req_apr_date_time'];
                $dispatchDate = $indReq[0]['req_dispatch_date_time'];
                foreach ($indReq as $ind_details) {
                    if ($ind_details['ind_item_type'] == 'EQP') {
                        $equipment1 = array(
                            'id' => (int) $ind_details['eqp_id'],
                            'name' => $ind_details['eqp_name'],
                            'sku' => $ind_details['eqp_id'],
                            'type' => 'EQP',
                            'sku_name' => "Equipment",
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity'],
                            'dispatchQuan' => (int) $ind_details['ind_dis_qty']
                        );
                        array_push($equipment,$equipment1);
                    }
                }
                foreach ($indReq as $ind_details){
                    if($ind_details['req_other_remark'] == ''){
                        $remark = array(
                            'id' => (int) $ind_details['id'],
                            'value' =>$ind_details['remark_val'],
                            'name' => $ind_details['message']
                        );
                    }else{
                        $remark = array(
                            'id' => 0,
                            'value' => "other",
                            'name' => $ind_details['req_other_remark']
                        );
                        array_push($sendReq,$remark);
                    }
                    // print_r($ind_details);
                    $approveRem = $this->user->getApproveRema($ind_details['req_approve_remark']);
                    $dispatchRem = $this->user->getDispatchRema($ind_details['req_dispatch_remark']);
                    $receiveRem = $this->user->getReceiveRema($ind_details['req_receive_remark']);
                    $this->response([
                        'data' => ([
                            'distManager' => $distManager,
                            'sendRemark' => $remark,
                            'approveRemark' => $approveRem,
                            'dispatchRemark' => $dispatchRem,
                            'receiveRemark' => $receiveRem,
                            'approveDate' => $approveDate,
                            'dispatchDate' => $dispatchDate,
                            'receiveDate' => $indReq[0]['req_receive_date_time'],
                            'expectedDate' => $indReq[0]['req_expected_date_time'],
                            'equipment' => $equipment,
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                    break;
                }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function addequipmentreceive_post(){
        $type = $this->post('type');
        $requestId = $this->post('requestId');
        $list = $this->post('equipment');
        $ambulanceNo = $this->post('vehicleNumber');
        $receiveRemark = $this->post('receiveRemark');
        $date = $this->post('dateTime');
        $baseMonth = $this->CommonModel->baseMonth();
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        $logindata = $this->user->getId($id,$type);
        if($type == 3){
               $user = array();
            $userLoginArr = explode(',',$logindata['id']);
            foreach($userLoginArr as $userLoginArr1){
                $user1 = $this->user->getClgRefid($userLoginArr1);
                array_push($user,$user1);
            }
            $loginUser = implode(',',$user);
        }else{
            $loginUser = $this->user->getClgRefid($logindata['id']);
        }
        foreach($list as $list2){
            
            $indItem['ind_item_id'] = $list2['id'];
            $indItem['ind_item_type'] = $list2['req'];
            $indItem['ind_req_id'] = $requestId;
            $updateItem['ind_rec_qty'] = $list2['reccount'];

            $ambStk['as_item_id'] = $list2['id'];
            $ambStk['as_item_type'] = $list2['req'];
            $ambStk['as_stk_in_out'] = 'in';
            $ambStk['as_item_qty'] = $list2['reccount'];
            $ambStk['as_sub_id'] = $requestId;
            $ambStk['as_sub_type'] = 'ind';
            $ambStk['amb_rto_register_no'] = $ambulanceNo;
            $ambStk['as_date'] = date('Y-m-d H:i:s');
            $ambStk['as_base_month'] = $baseMonth[0]['months'];

            
            $updateIndItem = $this->user->updateIndItem($indItem,$updateItem);
            $insertAmbStk = $this->user->insertAmbStk($ambStk);
        }
        $indReq['req_receive_remark'] = $receiveRemark;
        $indReq['req_receive_date_time'] = $date;
        $indReq['req_rec_by'] = $loginUser;
        $this->user->updateIndentReq($requestId,$indReq);
        if($updateIndItem==1 && $insertAmbStk==1){
            $this->response([
                'data' => ([
                    'code' => 1,
                    'message' => 'Insert Successfully'
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
    public function listequipment_post(){
       
            $ambulanceNo = $this->post('vehicleNumber');
             $type = $this->post('type');
     $pageIndex = $this->post('pageIndex');
     $pageSize = $this->post('pageSize');
     $begin = ($pageIndex * $pageSize) - $pageSize; 
            
            if($type==4)
            {
                 if((isset($_COOKIE['cookie']))){
                 $indReq = $this->user->getallListOfEquipment($pageSize,$begin);
          
            $indRec = array();
            foreach($indReq as $indReq1){
                if($indReq1['req_dis_by'] == '' && $indReq1['req_rec_by'] == '' && $indReq1['req_approve_remark'] == ''){
                    $status = "Pending";
                }else if($indReq1['req_rec_by'] == '' && $indReq1['req_dis_by'] != ''){
                    $status = "Dispatched";
                }else if($indReq1['req_rec_by'] != ''){
                    $status = "Received";
                }else if($indReq1['req_approve_remark'] != '' && $indReq1['req_dis_by'] == ''){
                    $status = "approved";
                }
                $indRec1 = array(
                     'id' => (int) $indReq1['req_id'],
                    'dateTime' => $indReq1['req_date'],
                    'district' => $indReq1['dst_name'],
                    'baseLocation'=>$indReq1['req_base_location'],
                    'ambRegNo' => $indReq1['req_amb_reg_no'],
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
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
        }
        else
        { 
         if((isset($_COOKIE['cookie']))){
            $indReq = $this->user->getListOfEquipment($ambulanceNo,$pageSize,$begin);
            $indRec = array();
            foreach($indReq as $indReq1){
                if($indReq1['req_dis_by'] == '' && $indReq1['req_rec_by'] == '' && $indReq1['req_approve_remark'] == ''){
                    $status = "Pending";
                }else if($indReq1['req_rec_by'] == '' && $indReq1['req_dis_by'] != ''){
                    $status = "Dispatched";
                }else if($indReq1['req_rec_by'] != ''){
                    $status = "Received";
                }else if($indReq1['req_approve_remark'] != '' && $indReq1['req_dis_by'] == ''){
                    $status = "approved";
                }
                $indRec1 = array(
                    'id' => (int) $indReq1['req_id'],
                    'dateTime' => $indReq1['req_date'],
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
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
            
        }
     }
     
 public function equipmentdetails_post(){
        if((isset($_COOKIE['cookie']))){
            $requestId = $this->post('requestId');
            $indReq = $this->user->equipmentReceive($requestId);
            if(!empty($indReq)){
                $dist = explode(',',$indReq[0]['req_district_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
            }
            $equipment = array();
            if (count($indReq) > 0) {
                $approveDate = $indReq[0]['req_apr_date_time'];
                $dispatchDate = $indReq[0]['req_dispatch_date_time'];
                $recieveDate = $indReq[0]['req_receive_date_time'];
                foreach ($indReq as $ind_details) {
                    if ($ind_details['ind_item_type'] == 'EQP') {
                        $equipment1 = array(
                            'id' => (int) $ind_details['eqp_id'],
                            'name' => $ind_details['eqp_name'],
                            'sku' => $ind_details['eqp_id'],
                            'type' => 'EQP',
                            'sku_name' => "Equipment",
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 50,
                            'requestQuan' => (int) $ind_details['ind_quantity'],
                            'dispatchQuan' => (int) $ind_details['ind_dis_qty']
                        );
                        array_push($equipment,$equipment1);
                    }
                }
                foreach ($indReq as $ind_details){
                    if($ind_details['req_other_remark'] == ''){
                        $remark = array(
                            'id' => (int) $ind_details['id'],
                            'value' =>$ind_details['remark_val'],
                            'name' => $ind_details['message']
                        );
                    }else{
                        $remark = array(
                            'id' => 0,
                            'value' => "other",
                            'name' => $ind_details['req_other_remark']
                        );
                        array_push($sendReq,$remark);
                    }
                    // print_r($ind_details);
                    $approveRem = $this->user->getApproveRema($ind_details['req_approve_remark']);
                    $dispatchRem = $this->user->getDispatchRema($ind_details['req_dispatch_remark']);
                    $receiveRem = $this->user->getReceiveRema($ind_details['req_receive_remark']);
                     if($approveDate == "0000-00-00 00:00:00")
                    {
                        $approveDate=null;
                        
                    } 
                     if($dispatchDate == "0000-00-00 00:00:00")
                    {
                        $dispatchDate=null;
                        
                    }
                    if($recieveDate == "0000-00-00 00:00:00")
                    {
                        $recieveDate=null;
                        
                    }
                    $this->response([
                        'data' => ([
                            'distManager' => $distManager,
                            'sendRemark' => $remark,
                            'approveRemark' => $approveRem,
                            'dispatchRemark' => $dispatchRem,
                            'receiveRemark' => $receiveRem,
                            'approveDate' => $approveDate,
                            'dispatchDate' => $dispatchDate,
                            'receiveDate' => $recieveDate ,
                            'expectedDate' => $indReq[0]['req_expected_date_time'],
                            'equipment' => $equipment,
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                    break;
                }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    } 
public function equimentreqapprove_post()
{
    $type = $this->post('type');
    	$requestId = $this->post('requestId');	
    	$approveremark = "request_approve";
    	$req_apr_date_time = $this->post('approvaldate');
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        
     if((isset($_COOKIE['cookie']))){
       $data = array(
                'req_is_approve' => '1',
                'req_apr_date_time' => $current_date,
                'req_approve_remark' => $approveremark
            );

                $checkId = $this->user->approve_ind_req($data,$requestId);
                if($checkId == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'ID Do not exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                    'data' => ([
                        'requestId' => $requestId,
                  
                    ]),
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
     
     

public function equipmentreqdispatch_post()
{
    $type = $this->post('type');
    	$requestId = $this->post('requestId');
    	$dispatchqty = $this->post('equipment');
    	$remark = "request_dispatch";
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        
     if((isset($_COOKIE['cookie']))){
   
         
                $itemdata = array(
                'req_dispatch_date_time' => $current_date,
                'req_dispatch_remark' => $remark,
                'req_dis_by'=> $id,
               'req_dis_date'=> $current_date
            );
            
          foreach($dispatchqty as $detailsind){
              
              
                $indItem['ind_item_id'] = $detailsind['id'];
                $indItem['ind_item_type'] = $detailsind['req'];
                $indItem['ind_req_id'] = $requestId;
                $updateItem['ind_dis_qty'] = $detailsind['reccount'];
         
                $invstock['stk_inv_id'] = $detailsind['id'];
                $invstock['stk_inv_type'] = $detailsind['req'];
                $invstock['stk_in_out'] = 'in';
                $invstock['stk_qty'] = $detailsind['reccount'];
                $invstock['stk_handled_by'] = $id;
                $invstock['stk_date'] = date('Y-m-d H:i:s');
                
                 $updateIndItem = $this->user->updateIndItem($indItem,$updateItem);
                $insertdata = $this->user->insertinvitem($invstock);
               
         }   
          $checkId = $this->user->update_ind_dispatch($itemdata,$requestId);
     
                
                if($checkId == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'ID Do not exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                    'data' => ([
                        'requestId' => (int) $requestId,
                  
                    ]),
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


?>