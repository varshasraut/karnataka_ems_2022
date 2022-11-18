<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Addvisitors extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
         $this->load->model(array('CommonModel','user'));
        $this->load->helper(array('cookie','url'));
        $this
            ->load
            ->library('encryption');
    }
    public function index_post()
    {
        if ((isset($_COOKIE['cookie'])))
       {
            $visitorid = $this->post('Visitorid');
            $Visitorname = $this->post('Visitorname');
            $vehicle = $this->post('Ambulanceno');
            $veh = explode(' ',$vehicle);
            $ambno = implode('-',$veh);
            $Designation = $this->post('Designation');
            $Organization = $this->post('Organization');
            $Contactnumber = $this->post('Contactnumber');
            $Email = $this->post('Email');
			 $address = $this->post('address');
            $Supervisorname = $this->post('Supervisorname');
			$districtmanager = $this->post('districtmanager');
            $Purposeofvisit = $this->post('Purposeofvisit');
            $Visiteddate = $this->post('Visiteddate');
            $Standardremark = $this->post('Standardremark');
            $Remark = $this->post('Remark');
            $type = $this->post('type');
            $current_date = date('Y-m-d H:i:s');
  
            $amb = $this->CommonModel->getAmbulanceRec($ambno);  
         
            $id =$this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id, $type);
            $user = array();
            if ($type == 3)
            {
                $userLoginArr = explode(',', $logindata['id']);
                foreach ($userLoginArr as $userLoginArr1)
                {
                    $user1 = $this->user->getClgRefid($userLoginArr1);
                    array_push($user, $user1);
                }
               
                $loginUser = implode(',', $user);
            }
            else
            {
                $logindata = $this->user->getUserLogin($id,$type);
                $loginUser=$logindata[0]['clg_ref_id'];
              
            }
		   if(count($districtmanager) > 0){
                $distId = array();
                foreach($districtmanager as $distManager1){
                    $distId1 = $distManager1['id'];
                    array_push($distId,$distId1);
                }
                $districtmanager_arr = implode(',',$distId);
            }else{
               $districtmanager_arr = $distManager['id'];
            }


        $logindata = $this->user->getUserLogin($id,$type);
     
        foreach($logindata as $logindata1){
                                if(count($logindata)==1){
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $pilot_name = "";
                                        $pilot_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }else{
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $emt_name = "";
                                        $emso_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }
                                }else{
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }else{
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }
                                }
                            }
        


    if($visitorid==0)
	    {

            if ($ambno == '' || $Visitorname == '' || $Designation == '')
            {
                $this->response("Please provide data", REST_Controller::HTTP_BAD_REQUEST);
            }
            else
            { 

			
            $data = array(
                'vs_state_code' =>  $amb[0]['amb_state'],
                'vs_district_code' => $amb[0]['amb_district'],
                'vs_amb_ref_number' => $ambno,
                'vs_base_location' => $amb[0]['hp_name'],
                'vs_added_by' => $loginUser,
                'vs_visitor_name' => $Visitorname,
                'vs_designation' => $Designation,
                'vs_oragnization' => $Organization,
                'vs_contact_number' => $Contactnumber,
                'vs_email' => $Email,
                'vs_addres' => $address,
				'vs_supervisor' => $Supervisorname,
				'vs_purposr_visit' => $Purposeofvisit,
                'vs_district_manager' => $districtmanager_arr,
                'vs_visited_datetime' => $Visiteddate,
                'vs_standard_remark' => $Standardremark,
                'vs_remark' => $Remark,
                'vs_added_date' => $current_date,
                'vs_is_deleted' => '1',
                'vs_base_month' => '2',
                'vs_type_user' => $type,
                'vs_addedby_emt' => $emso_id,
                'vs_addedby_pilot' =>$pilot_id
                
               
            );
 
 
  
              $currentId = $this->user->insertvisitor($data);
			  
			 
			   $this->response([
                    'data' => ([
                        'visitorid' => $currentId,
                  
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
               
            }
	    }
         else{
                 $loginUser = $logindata[0]['clg_ref_id'];
                
                 $data = array(
                'vs_state_code' =>  $amb[0]['amb_state'],
                'vs_district_code' => $amb[0]['amb_district'],
                'vs_amb_ref_number' => $ambno,
                'vs_base_location' => $amb[0]['hp_name'],
                'vs_visitor_name' => $Visitorname,
                'vs_designation' => $Designation,
                'vs_oragnization' => $Organization,
                'vs_contact_number' => $Contactnumber,
                'vs_email' => $Email,
                'vs_addres' => $address,
				'vs_supervisor' => $Supervisorname,
				'vs_purposr_visit' => $Purposeofvisit,
                'vs_district_manager' => $districtmanager_arr,
                'vs_visited_datetime' => $Visiteddate,
                'vs_standard_remark' => $Standardremark,
                'vs_remark' => $Remark,
                'vs_is_deleted' => '1',
                'vs_base_month' => '2',
                'vs_modify_by' => $loginUser,
                'vs_modify_date' => $current_date
                
            );
     
                
                $checkDeviceId = $this->user->updatevisitors($data,$visitorid);
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
                        'visitorid' => $visitorid,
                  
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
                }
            }

        }
        
        else
        {
           
            $this->response(['data' => ([]) , 'error' => null], REST_Controller::HTTP_UNAUTHORIZED);
        }

    }


    public function getvisiters_post(){
		$vehicle = $this->post('Ambulanceno');
        $veh = explode(' ',$vehicle);
        $Ambulanceno = implode('-',$veh);
	    $type = $this->post('type');
        $current_date = date('Y-m-d H:i:s');
        $usertype = $this->post('usertype');
        
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
        //$logindata = $this->user->getUserLogin($id,$type);
         $logindata = $this->user->getseparateId($id, $usertype);
      
    if($type == 4){
         
         $pageIndex = $this->post('pageIndex');
         $pageSize = $this->post('pageSize');
         $begin = ($pageIndex * $pageSize) - $pageSize;       
 
     if((isset($_COOKIE['cookie']))){
	    
	    $indReq = $this->user->getaddedlistvisitors($begin,$pageSize);
	  
		if(!empty($indReq)){
            $indRec = array();
            foreach($indReq as $indReq1){
                
                $addedby = explode(',',$indReq1['vs_added_by']);
                $addedbyuser = array();
                foreach($addedby as $addedbyuser1){
                    $logindata = $this->user->getclgname($addedbyuser1);
                   $a= $logindata[0]['clg_first_name'] .' ' .$logindata[0]['clg_mid_name'] .' ' .$logindata[0]['clg_last_name'];
                    array_push($addedbyuser,$a);
                 
                }   
                $addedby = implode(',',$addedbyuser);
               
                
                if($indReq1['vs_modify_date'] == '0000-00-00 00:00:00'){
                    $date = $indReq1['vs_added_date'];
                }else {
                   $date = $indReq1['vs_modify_date'];
                }
                
                
                 
                
                $indRec1 = array(
                   
                    'visitedid' => (int) $indReq1['vs_id'],
                    'visiteddate' => $indReq1['vs_visited_datetime'],
                     'visitername' => $indReq1['vs_visitor_name'],
                    'visitpurpose' => $indReq1['vs_purposr_visit'],
                    'district' => $indReq1['dst_name'],
                    'baseLocation'=>$indReq1['vs_base_location'],
                    'ambRegNo' => $indReq1['vs_amb_ref_number'],
                    'addedby' => $addedby
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
    elseif ($type == 3)
            {
                $userLoginArr = $logindata[0]['clg_id'];
                
                $user1 = $this->user->getClgRefid($userLoginArr);
                $data = $this->user->getvisitorlist($Ambulanceno,$user1,$usertype);
                
        if(!empty($data)){
         if((isset($_COOKIE['cookie']))){    
            if(!empty($data)){
                $dist = explode(',',$data[0]['vs_district_manager']);
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
            
           $approveRem = $this->user->getreamarkvisitor($data[0]['vs_standard_remark']);
	    

           
	
        $visiterlist1 = array();
        foreach($data as $data1){
           
               $visiterlist['visitedid'] = (int) $data1['vs_id'];
               $visiterlist['visitername'] = $data1['vs_visitor_name'];
               $visiterlist['visitpurpose'] = $data1['vs_purposr_visit'];
               $visiterlist['visiteddate'] = $data1['vs_visited_datetime'];
               $visiterlist['email'] = $data1['vs_email'];
               $visiterlist['address'] = $data1['vs_addres'];
               $visiterlist['supervisorname'] = $data1['vs_supervisor'];
               $visiterlist['oragnization'] = $data1['vs_oragnization'];
               $visiterlist['designation'] =  $data1['vs_designation'];
               $visiterlist['contactnumber'] = $data1['vs_contact_number'];
               $visiterlist['distmanager'] = $distManager;
               $visiterlist['stdremark'] = $approveRem;
               $visiterlist['remark'] = $data1['vs_remark'];
               
               
                   $addedby = explode(',',$data1['vs_added_by']);
                $addedbyuser = array();
                foreach($addedby as $addedbyuser1){
                    $logindata = $this->user->getclgname($addedbyuser1);
                   $a= $logindata[0]['clg_first_name'] .' ' .$logindata[0]['clg_mid_name'] .' ' .$logindata[0]['clg_last_name'];
                    array_push($addedbyuser,$a);
                 
                }   
                $addedbyusers = implode(',',$addedbyuser);
               
               
                 if($usertype=='D')
        		  {
        		   $addedby = $data1['vs_addedby_pilot']; 
        		   
        		   $logindata = $this->user->getclgname($addedby);
                 $loginid= $logindata[0]['clg_ref_id'];
                  $clg_first_name= $logindata[0]['clg_first_name'];
                   $clg_mid_name= $logindata[0]['clg_mid_name'];
                    $clg_last_name= $logindata[0]['clg_last_name'];
                 
                    $addedby = $clg_first_name . ' ' . $clg_mid_name . ' ' . $clg_last_name;
        		   
        		  
        		   
        		  } 
        		  if($usertype=='P'){
        		      $addedby = $data1['vs_addedby_emt'];
        		   
        		   $logindata = $this->user->getclgname($addedby);
        		   
                 $loginid= $logindata[0]['clg_ref_id'];
                  $clg_first_name= $logindata[0]['clg_first_name'];
                   $clg_mid_name= $logindata[0]['clg_mid_name'];
                    $clg_last_name= $logindata[0]['clg_last_name'];
                 
                    $addedby = $clg_first_name . ' ' . $clg_mid_name . ' ' . $clg_last_name;    
        		      
        		      
        		     
        		      
        		  } 
               $visiterlist['addedby'] = $addedbyusers;
             array_push($visiterlist1,$visiterlist);
                 
		  }
		  
       
          
		        $this->response([
                'data' => $visiterlist1,
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
          else
            {
               
                $id = $this->encryption->decrypt($_COOKIE['cookie']);
                  $logindata = $this->user->getUserLogin($id,$type);
                 $loginid= $logindata[0]['clg_ref_id'];
                  $clg_first_name= $logindata[0]['clg_first_name'];
                   $clg_mid_name= $logindata[0]['clg_mid_name'];
                    $clg_last_name= $logindata[0]['clg_last_name'];
                 
                    $clg_full_name = $clg_first_name . ' ' . $clg_mid_name . ' ' . $clg_last_name;
                  
		        $data = $this->user->singlevisitorlist($Ambulanceno,$loginid);
		        
		        
	 if(!empty($data)){
         if((isset($_COOKIE['cookie']))){
		        //$data2 = explode(',',$data[0]['vs_added_by']);
		         $addedby = explode(',',$data[0]['vs_added_by']);
                $addedbyuser = array();
                foreach($addedby as $addedbyuser1){
                    $logindata = $this->user->getclgname($addedbyuser1);
                   $a= $logindata[0]['clg_first_name'] .' ' .$logindata[0]['clg_mid_name'] .' ' .$logindata[0]['clg_last_name'];
                    array_push($addedbyuser,$a);
                 
                }   
                $addedbyusers = implode(',',$addedbyuser);
       

            if(!empty($data)){
                $dist = explode(',',$data[0]['vs_district_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                     $str = $this->db->last_query();
         
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
            }
            
             $approveRem = $this->user->getreamarkvisitor($data[0]['vs_standard_remark']);
            
        	
                $visiterlist1 = array();
                foreach($data as $data1){
                   
               $visiterlist['visitedid'] = (int) $data1['vs_id'];
               $visiterlist['visitername'] = $data1['vs_visitor_name'];
               $visiterlist['visitpurpose'] = $data1['vs_purposr_visit'];
               $visiterlist['visiteddate'] = $data1['vs_visited_datetime'];
               $visiterlist['email'] = $data1['vs_email'];
               $visiterlist['address'] = $data1['vs_addres'];
               $visiterlist['supervisorname'] = $data1['vs_supervisor'];
               $visiterlist['oragnization'] = $data1['vs_oragnization'];
               $visiterlist['designation'] =  $data1['vs_designation'];
               $visiterlist['contactnumber'] = $data1['vs_contact_number'];
               $visiterlist['distmanager'] = $distManager;
               $visiterlist['stdremark'] = $approveRem;
               $visiterlist['remark'] = $data1['vs_remark'];
                $visiterlist['addedby'] = $addedbyusers;
               
                array_push($visiterlist1,$visiterlist);
              
        } 
           
		  
		        $this->response([
                'data' => $visiterlist1,
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
     
        
 }
 
   
public function visitorsdetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $accidentaldetailsarr = $this->user->visitorsdetails($requestId);
   
    
     if(empty($accidentaldetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{
        
              $addedby = explode(',',$accidentaldetailsarr[0]['vs_added_by']);
                $addedbyuser = array();
                foreach($addedby as $addedbyuser1){
                    $logindata = $this->user->getclgname($addedbyuser1);
                   $a= $logindata[0]['clg_first_name'] .' ' .$logindata[0]['clg_mid_name'] .' ' .$logindata[0]['clg_last_name'];
                    array_push($addedbyuser,$a);
                 
                }   
                $addedby = implode(',',$addedbyuser);
      
       $dist = explode(',',$accidentaldetailsarr[0]['vs_district_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
      $mt_stnd_remark = $accidentaldetailsarr[0]['vs_standard_remark'];
      $approveRem = $this->user->getApproveRema($mt_stnd_remark);
      

      
      
    
         $data = array(
                        'visitedid' => (int) $accidentaldetailsarr[0]['vs_id'],
                        'visiteddate' => $accidentaldetailsarr[0]['vs_visited_datetime'],
                         'visitername' => $accidentaldetailsarr[0]['vs_visitor_name'],
                        'visitpurpose' => $accidentaldetailsarr[0]['vs_purposr_visit'],
                        'stateCode' => $accidentaldetailsarr[0]['dst_state'],
                        'district' => $accidentaldetailsarr[0]['dst_name'],
                        'baseLocation'=>$accidentaldetailsarr[0]['vs_base_location'],
                        'ambRegNo' => $accidentaldetailsarr[0]['vs_amb_ref_number'],
                        'addedby' => $addedby,
                        'email' => $accidentaldetailsarr[0]['vs_email'],
                        'address' => $accidentaldetailsarr[0]['vs_addres'],
                        'remark' => $accidentaldetailsarr[0]['vs_remark'],
                        'supervisorname' => $accidentaldetailsarr[0]['vs_supervisor'],
                        'oragnization' => $accidentaldetailsarr[0]['vs_oragnization'],
                        'designation'=> $accidentaldetailsarr[0]['vs_designation'],
                         'contactnumber'=> $accidentaldetailsarr[0]['vs_contact_number'],
                        'stdremark' => $approveRem,
                        'distmanager'=>$distManager
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




