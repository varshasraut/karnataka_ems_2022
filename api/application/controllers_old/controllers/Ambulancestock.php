<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Ambulancestock extends REST_Controller
{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie','url'));
        $this
            ->load
            ->library('encryption');
    }
    public function index_post()
    {
        $inventoryType = $this->post('inventoryType');
        
          $inventoryid = $this->post('inventoryType');
        
        
        if($inventoryid==1)
        {
           $inventoryType='MCA'; 
        }
        elseif($inventoryid==2)
        {
             $inventoryType='MNCA'; 
        }
          elseif($inventoryid==3)
        {
             $inventoryType='CA'; 
        }
            elseif($inventoryid==4)
        {
             $inventoryType='NCA'; 
        }
            elseif($inventoryid==5)
        {
             $inventoryType='EQP'; 
        }
        
        
        $Ambulanceno = $this->post('vehicleNumber');
        $data = $this->user->getinventoryname($inventoryType,$Ambulanceno);
        $keys = array_column($data, 'count');
        array_multisort($keys, SORT_ASC, $data);
        $arr1 = array();
        $arr2 = array();
        foreach($data as $data1){
            if($data1['count'] == 0){
                array_push($arr1,$data1);
            }else{
                array_push($arr2,$data1);
            }
        }
        $this->response([
            'data' => array_merge($arr2,$arr1),
            'error' => null
        ],REST_Controller::HTTP_OK);
    }
    public function index1_post()
    {
        
    
     $inventoryType = $this->post('inventoryType');
      $Ambulanceno = $this->post('vehicleNumber');
     
        $data = $this->user->getinventoryname($inventoryType,$Ambulanceno);
       //$upstatus1=$userdata[0]['path'];  
       print_r($data);die;
       if(!empty($data)){
         if((isset($_COOKIE['cookie']))){ 
        $stockarray = array();
        
     foreach($data as $data1){
         
             if($inventoryType==1 || $inventoryType== 2)
                        {
                           $nameofInventory= $data1['med_title'];
                        }
                      elseif($inventoryType==3 || $inventoryType== 4)
                          {
                               $nameofInventory= $data1['inv_title'];
                          }
                           elseif($inventoryType==5 )
                          {
                               $nameofInventory= $data1['eqp_name'];
                          }
         
         
             $stockarray1 = array(
                        'id' => (int) $data1['as_id'],
                        'nameofInventory' => $nameofInventory,
                        'stockCount' =>(int) $data1['as_item_qty']
                        
                    );
              
         
    
      array_push($stockarray,$stockarray1);
     }
        $this->response([
                'data' => $stockarray,
                'error' => null
            ],REST_Controller::HTTP_OK);
     
    
    
     }else
        {
         
		        $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
        
		  }
		  else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }

}
 public function indentreqlistfordispatch_post()
    {
		
		$type = $this->post('type');
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        
	  if((isset($_COOKIE['cookie']))){
	 $indReq = $this->user->getallindentreqfordispatch();
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
 public function indentrequestdetails_post(){
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
                $recieveDate = $indReq[0]['req_receive_date_time'];
                
                foreach ($indReq as $ind_details) {
                    if ($ind_details['ind_item_type'] == 'CA') {
                        $comsumableUnit = array(
                             'id' => (int) $ind_details['inv_id'],
                            'name' => $ind_details['inv_title'],
                            'sku' => $ind_details['inv_id'],
                            'type' => 'CA',
                            'sku_name' => "Consumable",
                            'avaQuanInAmb' => (int) ($ind_details['in_stk'] > $ind_details['out_stk']) ? $ind_details['in_stk'] - $ind_details['out_stk'] : 0,
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 50,
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
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 50,
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
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 50,
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
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 50,
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
                            'dispatchRemark' =>$dispatchRem,
                            'receiveRemark' => $receiveRem,
                            'approveDate' => $approveDate,
                            'dispatchDate' => $dispatchDate,
                            'receiveDate' => $recieveDate,
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
    
 public function indentreqapprove_post()
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
     
  public function indentreqdispatch_post()
{
    $type = $this->post('type');
    	$requestId = $this->post('requestId');
    	$dispatchqty = $this->post('list');
    	$remark = "request_dispatch";
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        
     if((isset($_COOKIE['cookie']))){
       $data = array(
                'req_dis_by' => $id,
                'req_dispatch_date_time' => $current_date,
                'req_dispatch_remark' => $remark
            );
            
            
     foreach ($dispatchqty as $dispatchqtydetails){
         
         
                $itemdata = array(
                'req_dispatch_date_time' => $current_date,
                'req_dispatch_remark' => $remark,
                'req_dis_by'=> $id,
               'req_dis_date'=> $current_date
            );
            
          foreach($dispatchqtydetails as $detailsind){
              
              
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
     }
                
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
       
     
     
 /*public function indentreqdispatch_post()
     
    {
     
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
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity']
                           
                        );
                        array_push($comsumableUnit1,$comsumableUnit);
                    } else if ($ind_details['ind_item_type'] == 'NCA') {
                        $comsumableNonUnit = array(
                            'id' => (int) $ind_details['inv_id'],
                            'name' => $ind_details['inv_title'],
                            'sku' => $ind_details['ind_id'],
                            'type' => 'NCA',
                            'sku_name' => "Non Consumable",
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity']
                        );
                        array_push($comsumableNonUnit1,$comsumableNonUnit);
                    } else if ($ind_details['ind_item_type'] == 'MCA') {
                        $medicineUnit = array(
                            'id' => (int) $ind_details['med_id'],
                            'name' => $ind_details['med_title'],
                            'sku' => $ind_details['med_id'],
                            'type' => "MCA",
                            'sku_name' => 'Medicine Unit',
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity']
                        );
                        array_push($medicineUnit1,$medicineUnit);
                    } else if ($ind_details['ind_item_type'] == 'MNCA') {
                        $medicineNonUnit = array(
                            'id' => (int) $ind_details['med_id'],
                            'name' => $ind_details['med_title'],
                            'sku' => $ind_details['med_id'],
                            'type' => "MNCA",
                            'sku_name' => 'Medicine Non Unit',
                            'avaStock' => (int) ($ind_details['stk_total']) ? $ind_details['stk_total'] : 0,
                            'requestQuan' => (int) $ind_details['ind_quantity']
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
                   // $dispatchRem = $this->user->getDispatchRema($ind_details['req_dispatch_remark']);
                    $receiveRem = $this->user->getReceiveRema($ind_details['req_receive_remark']);
                    $this->response([
                        'data' => ([
                            'distManager' => $distManager,
                            'sendRemark' => $remark,
                            'approveRemark' => $approveRem,
                            'approveDate' => $approveDate,
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
    
   } */

}






