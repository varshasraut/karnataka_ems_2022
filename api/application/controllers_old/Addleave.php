<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Addleave extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
		if((isset($_COOKIE['cookie']))){
            $leaveID = $this->post('leaveId');	  
            $startDateTime = $this->post('startDateTime');
            $endDateTime = $this->post('endDateTime');
            $reason = $this->post('reason');
            $type = $this->post('type');
            $usertype= $this->post('userType');
            $current_date = date('Y-m-d H:i:s');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            if($type==3){
                $userLoginArr = $this->user->getlogin($id, $usertype);
                $id = $userLoginArr[0]['clg_id'];
                $usergroup = $userLoginArr[0]['clg_group'];
                if($usertype =='P'){
                $type=1;
                }else{
                    $type=2; 
                }
            }else{
                $logindata = $this->user->getUserLogin($id,$type);
                $id = $logindata[0]['clg_id'];
                $usergroup = $logindata[0]['clg_group'];
            }
                /*$logindata = $this->user->getId($id,$type);
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
                }*/
            $data = array(
                'colleague_id' => $id,
                'clg_type' => $type,
                'date_form' => $startDateTime,
                'date_to' => $endDateTime,
                'reason' => $reason,
                'added_date' => $current_date,
                'Leave_status' => '1',
                'status' => '1',
                'clg_group' => $usergroup
            ); 
            if($leaveID==0){
                if($startDateTime == '' || $endDateTime == '' || $type == '' ){
                    $this->response("Please provide data", REST_Controller::HTTP_BAD_REQUEST);
                }else{
                    $currentId = $this->user->insertclgleave($data);
                    $this->response([
                        'data' => ([
                            'leaveId' => $currentId,
                    
                        ]),
                        'error' => null
                    ], REST_Controller::HTTP_OK);
                }
            }else{
                if($startDateTime == '' || $endDateTime == '' || $type == '' ){
                    $this->response("Please provide data", REST_Controller::HTTP_BAD_REQUEST);
                }else{
                    $data = array(
                        'colleague_id' => $id,
                        'date_form' => $startDateTime,
                        'date_to' => $endDateTime,
                        'reason' => $reason,
                        'modified_date' => $current_date,
                        'Leave_status' => '1',
                        'status' => '1'
                    ); 
                    $checkDeviceId = $this->user->updateleave($data,$leaveID);
                    if($checkDeviceId == 1){
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Leave ID Do not exist'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                        'data' => ([
                            'leaveId' => $leaveID,
                    
                        ]),
                        'error' => null
                    ], REST_Controller::HTTP_OK);
                    }
                }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
 public function getlist_post(){
		
	    $type = $this->post('type');
	    $getLeave = $this->post('getleave');
	     $usertype = $this->post('userType');
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        
       
        if($type==3)
        {
          $userLoginArr = $this->user->getlogin($id, $usertype);
    
          $id = $userLoginArr[0]['clg_id'];
          $usergroup = $userLoginArr[0]['clg_group'];  
          
        if($usertype =='P')
       {
           $type='1';
       }
       if($usertype=='D')
       {
           $type='2'; 
       }
        }
        else{
           $logindata = $this->user->getUserLogin($id,$type);  
           $id = $logindata[0]['clg_id'];
           $usergroup = $logindata[0]['clg_group'];
		   $clgdistrict = $logindata[0]['clg_district_id'];
		  $clgdistrict= preg_replace('/[^A-Za-z0-9\-]/', '', $clgdistrict);
        }
        
        
 
		 
		$data = $this->user->getleavelist($id,$type,$getLeave,$usergroup,$clgdistrict);

		if(!empty($data)){
        $leavelist1 = array();
        foreach($data as $data1){
            
             
               
               if($getLeave==2)
               {
                       $leavestatus= $data1['Leave_status'];
                                   if($leavestatus==1)
                                   {
                                       $leavestatus='3';
                                   }
                                   else
                                   {
                                       $leavestatus=$data1['Leave_status'];
                                   }
                        $clgid = $data1['colleague_id'];           
                        $clgdata = $this->user->getclgdetails1($clgid);
                        // print_r($data1);
                        $clg_first_name= $clgdata[0]['clg_first_name'];
                        $clg_mid_name= $clgdata[0]['clg_mid_name'];
                        $clg_last_name= $clgdata[0]['clg_last_name'];
                        
                        $clganame = $clg_first_name . ' ' . $clg_mid_name . ' ' . $clg_last_name;
                                   
                       $leavelist['id'] = (int) $data1['colleague_leave_id'];
                        $leavelist['userName'] = $clganame;
                       $leavelist['startDateTime'] = $data1['date_form'];
                       $leavelist['endDateTime'] = $data1['date_to'];
                       $leavelist['reason'] = $data1['reason'];
                       $leavelist['rejectionReason'] = $data1['rejection_reason'];
                       $leavelist['status'] = $leavestatus;    
               }
               else{
                           $leavelist['id'] = (int) $data1['colleague_leave_id'];
                           $leavelist['startDateTime'] = $data1['date_form'];
                           $leavelist['endDateTime'] = $data1['date_to'];
                           $leavelist['reason'] = $data1['reason'];
                           $leavelist['status'] = (string) $data1['Leave_status']; 
                           $leavelist['rejectionReason'] = $data1['rejection_reason'];
               }
              
               array_push($leavelist1,$leavelist);
        }      
		   if((isset($_COOKIE['cookie']))){
		       
		        $this->response([
                'data' => $leavelist1,
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
		    else{
		        $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
		    }
		
		
 }
    public function cancleleave_post(){
    
     if((isset($_COOKIE['cookie']))){
	    $type = $this->post('type');
	    $leaveID = $this->post('leaveId');
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        // print_r($id);
        $logindata = $this->user->getUserLogin($id,$type);
        
         $data = array(
            'modified_date' => $current_date,
            'Leave_status' => '5',
        ); 
     
		  
	 $checkDeviceId = $this->user->cancleleave($data,$leaveID);
                if($checkDeviceId == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Leave ID Do not exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                    'data' => ([
                        'leaveId' => $leaveID,
                  
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
 public function actiononleave_post(){
    
     if((isset($_COOKIE['cookie']))){
	    $type = $this->post('type');
	    $leaveID = $this->post('leaveId');
	     $leaveStatus = $this->post('leaveStatus');
	     $rejectionReason = $this->post('rejectionReason');
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        // print_r($id);
        $logindata = $this->user->getUserLogin($id,$type);
        if($leaveStatus==4)
        {
         $data = array(
            'modified_date' => $current_date,
            'Leave_status' => $leaveStatus,
            'rejection_reason' => $rejectionReason,
              'modify_by' => $id
            
        ); 
        }
        else{
              $data = array(
            'modified_date' => $current_date,
            'Leave_status' => $leaveStatus,
              'modify_by' => $id
        ); 
        }
			  
	 $checkDeviceId = $this->user->updateleave($data,$leaveID);
	 
                if($checkDeviceId == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Leave ID Do not exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                     $getleavedetails=$this->user->getleavedetails($leaveID);
                     
                     $api_url = base_url() ."leavenotification";
                    //  echo $api_url;die;
	            	$json_data = array('leaveid'=>$leaveID,
						   'clgid'=>$getleavedetails[0]['colleague_id'],
						   'status' =>$leaveStatus,
						   'remark'=>$rejectionReason);

        	$json_data= json_encode($json_data);
             $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$api_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            $result = curl_exec($ch);
            curl_close($ch);
  
    
                    
                    $this->response([
                    'data' => ([
                        'leaveId' => $leaveID,
                  
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
 
 
 public function getdateleaves_post(){
		
	   $fromDate = $this->post('fromDate');
	    $toDate = $this->post('toDate');
        $current_date = date('Y-m-d');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
 
       
		$datas = $this->user->getdatedleave($fromDate,$toDate,$current_date);
       
		if(!empty($datas)){
        $leavelist1 = array();
         foreach($datas as $data){

             
        foreach($data as $data1){
            
            
                        $clgid = $data1['colleague_id'];           
                        $clgdata = $this->user->getclgdetails1($clgid);
                        $clg_first_name= $clgdata[0]['clg_first_name'];
                        $clg_mid_name= $clgdata[0]['clg_mid_name'];
                        $clg_last_name= $clgdata[0]['clg_last_name'];
                        $clganame = $clg_first_name . ' ' . $clg_mid_name . ' ' . $clg_last_name;           
                       $leavelist['id'] = (int) $data1['colleague_leave_id'];
                       $leavelist['userName'] = $clganame;
                       $leavelist['startDateTime'] = $data1['date_form'];
                       $leavelist['endDateTime'] = $data1['date_to'];
                       $leavelist['reason'] = $data1['reason'];
                       
                        
              
              array_push($leavelist1,$leavelist);
          }    
        }   
		   if((isset($_COOKIE['cookie']))){
		       
		        $this->response([
                'data' => $leavelist1,
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
		    else{
		        $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_OK);
		    }
		
		
 } 


}