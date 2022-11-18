<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Indentrequest extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
    }
    public function indentreqdistmanager_post(){
        if((isset($_COOKIE['cookie']))){
            $ambulanceNo = $this->post('vehicleNumber');
            $distManager = $this->user->getIndentReqDistManager($ambulanceNo);
            $distMagRec = array();
            foreach($distManager as $distManager1){
                $distMagRec1 = array(
                    'id' => (int) $distManager1['clg_id'],
                    'name' => $distManager1['clg_ref_id']
                );
                array_push($distMagRec,$distMagRec1);
            }
            $this->response([
                'data' => $distMagRec,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
    public function listindentreq_post(){
   
     $ambulanceNo = $this->post('vehicleNumber');
     $type = $this->post('type');
     $pageIndex = $this->post('pageIndex');
     $pageSize = $this->post('pageSize');
     $begin = ($pageIndex * $pageSize) - $pageSize;       
  if($type== '4')
  {
     if((isset($_COOKIE['cookie']))){
	    
	    $indReq = $this->user->getallindentreq($begin,$pageSize);
		if(!empty($indReq)){
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
    else
           {
            
            if((isset($_COOKIE['cookie']))){
            $indReq = $this->user->getListOfIndentReq($ambulanceNo,$begin,$pageSize);
    
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
    public function addindentrequest_post(){
        if((isset($_COOKIE['cookie']))){
            $type = $this->post('type');
            $requestId = $this->post('requestId');
            $ambulanceNo = $this->post('vehicleNumber');
            $expectedDate = $this->post('expectedDate');
            $distManager = $this->post('distManager');
            $dist = array();
            foreach($distManager as $distManager1){
                array_push($dist,$distManager1['id']);
            }
            $dist1 = implode(',',$dist);
            $stndRemark = $this->post('stndRemark');
            $list = $this->post('list');
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
                        $indReq['req_group'] = "IND";
                        $indReq['req_isdeleted'] = "0";
                        $insertId = $this->user->insertIndentReq($indReq);
                        foreach($list as $list1){
                            foreach($list1 as $list2){
                                array(
                                    $indItem['ind_item_id'] = $list2['id'],
                                    $indItem['ind_quantity'] = $list2['count'],
                                    $indItem['ind_item_type'] = $list2['req'],
                                    $indItem['ind_req_id'] = $insertId,
                                    $indItem['indis_deleted'] = '0'
                                );
                                $this->user->insertIndItem($indItem);
                            }
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
                    foreach($list1 as $list2){
                        array(
                            $indItem['ind_item_id'] = $list2['id'],
                            $indItem['ind_quantity'] = $list2['count'],
                            $indItem['ind_item_type'] = $list2['req'],
                            $indItem['ind_req_id'] = $requestId,
                            $indItem['indis_deleted'] = '0'
                        );
                        $this->user->insertIndItem($indItem);
                    }
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
    public function editindentrequest_post(){
        if((isset($_COOKIE['cookie']))){
            $requestId = $this->post('requestId');
            $indReq = $this->user->editIndentReq($requestId);
            if(!empty($indReq)){
                $comsumableUnit1 = array();
                $comsumableNonUnit1 = array();
                $medicineUnit1 = array();
                $medicineNonUnit1 = array();
                $indReqItem = $this->user->getIndetnReqItem($indReq[0]['req_id']);
                foreach($indReqItem as $indReqItem1){
                    if($indReqItem1['ind_item_type'] == 'CA'){
                        $comsumableUnit = array(
                            'id' => (int) $indReqItem1['ind_item_id'],
                            'name' => $indReqItem1['inv_title'],
                            'count' => (int) $indReqItem1['ind_quantity']
                        );
                        array_push($comsumableUnit1,$comsumableUnit);
                    }else if($indReqItem1['ind_item_type'] == 'NCA'){
                        $comsumableNonUnit = array(
                            'id' => (int) $indReqItem1['ind_item_id'],
                            'name' => $indReqItem1['inv_title'],
                            'count' => (int) $indReqItem1['ind_quantity']
                        );
                        array_push($comsumableNonUnit1,$comsumableNonUnit);
                    }else if($indReqItem1['ind_item_type'] == 'MCA'){
                        $medicineUnit = array(
                            'id' => (int) $indReqItem1['ind_item_id'],
                            'name' => $indReqItem1['med_title'],
                            'count' => (int) $indReqItem1['ind_quantity']
                        );
                        array_push($medicineUnit1,$medicineUnit);
                    }else if($indReqItem1['ind_item_type'] == 'MNCA'){
                        $medicineNonUnit = array(
                            'id' => (int) $indReqItem1['ind_item_id'],
                            'name' => $indReqItem1['med_title'],
                            'count' => (int) $indReqItem1['ind_quantity']
                        );
                        array_push($medicineNonUnit1,$medicineNonUnit);
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
                        'comsumableUnit' => $comsumableUnit1,
                        'comsumableNonUnit' => $comsumableNonUnit1,
                        'medicineUnit' => $medicineUnit1,
                        'medicineNonUnit' => $medicineNonUnit1
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
    public function standardremark_post(){
        if((isset($_COOKIE['cookie']))){
            // $remarkType = $this->post('remarkType');
            $remark = $this->user->getRemark();
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
    public function indReqRecremark_post(){
        if((isset($_COOKIE['cookie']))){
            $remark = $this->user->indReqRecremark();
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
    public function indentrequestreceive_post(){
        if((isset($_COOKIE['cookie']))){
            $requestId = $this->post('requestId');
            $indReq = $this->user->indentReqReceive($requestId);
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
            $comsumableUnit1 = array();
            $comsumableNonUnit1 = array();
            $medicineUnit1 = array();
            $medicineNonUnit1 = array();
            if (count($indReq) > 0) {
                $approveDate = $indReq[0]['req_apr_date_time'];
                $dispatchDate = $indReq[0]['req_dispatch_date_time'];
                foreach ($indReq as $ind_details) {
                    if ($ind_details['ind_item_type'] == 'CA') {
                        $comsumableUnit = array(
                            'id' => (int) $ind_details['inv_id'],
                            'name' => $ind_details['inv_title'],
                            'sku' => $ind_details['inv_id'],
                            'type' => 'CA',
                            'sku_name' => "Consumable",
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity'],
                            'dispatchQuan' => (int) $ind_details['ind_dis_qty']
                        );
                        array_push($comsumableUnit1,$comsumableUnit);
                    } else if ($ind_details['ind_item_type'] == 'NCA') {
                        $comsumableNonUnit = array(
                            'id' => (int) $ind_details['inv_id'],
                            'name' => $ind_details['inv_title'],
                            'sku' => $ind_details['ind_id'],
                            'type' => 'NCA',
                            'sku_name' => "Non Consumable",
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity'],
                            'dispatchQuan' => (int) $ind_details['ind_dis_qty']
                        );
                        array_push($comsumableNonUnit1,$comsumableNonUnit);
                    } else if ($ind_details['ind_item_type'] == 'MCA') {
                        $medicineUnit = array(
                            'id' => (int) $ind_details['med_id'],
                            'name' => $ind_details['med_title'],
                            'sku' => $ind_details['med_id'],
                            'type' => "MCA",
                            'sku_name' => 'Medicine Unit',
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity'],
                            'dispatchQuan' => (int) $ind_details['ind_dis_qty']
                        );
                        array_push($medicineUnit1,$medicineUnit);
                    } else if ($ind_details['ind_item_type'] == 'MNCA') {
                        $medicineNonUnit = array(
                            'id' => (int) $ind_details['med_id'],
                            'name' => $ind_details['med_title'],
                            'sku' => $ind_details['med_id'],
                            'type' => "MNCA",
                            'sku_name' => 'Medicine Non Unit',
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity'],
                            'dispatchQuan' => (int) $ind_details['ind_dis_qty']
                        );
                        array_push($medicineNonUnit1,$medicineNonUnit);
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
                            'comsumableUnit' => $comsumableUnit1,
                            'comsumableNonUnit' => $comsumableNonUnit1,
                            'medicineUnit' => $medicineUnit1,
                            'medicineNonUnit' => $medicineNonUnit1
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
    public function addindentrequestreceive_post(){
        $type = $this->post('type');
        $requestId = $this->post('requestId');
        $list = $this->post('list');
        $ambulanceNo = $this->post('vehicleNumber');
        $receiveRemark = $this->post('receiveRemark');
        $date = $this->post('dateTime');
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
        foreach($list as $list1){
            foreach($list1 as $list2){
                
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
}