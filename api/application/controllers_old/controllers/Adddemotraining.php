<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Adddemotraining extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
         $this->training = $this->config->item('training');
        $this->load->helper(array('cookie','url'));
         $this->load->model(array('CommonModel','user'));
        $this->load->library('upload');
         $this->load->library('encryption');
         $this->load->helper(['url','file','form']); 
    }
       function sanitize_string( $string, $sep = '-' ){
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9 -_\.]+/', '', $string);
        $string = trim($string);
        $string = str_replace(' ', $sep, $string);
        return trim($string, '-_');
    }

public function index_post()
{
        
        
         $traineeid = $this->post('traineeid'); 
         $ambulanceNo = $this->post('ambulanceNo'); 
         $districtmanager = implode(',',$this->post('districtmanager'));
         //$districtmanager = $this->post('districtmanager'); 
         $place = $this->post('place'); 
         $noofcandidates = $this->post('noofcandidates');  
         $purposeoftraning = $this->post('purposeoftraning'); 
         $startodometer = $this->post('startodometer');
         $endodometer = $this->post('endodometer');
         $photoEmpty = $this->post('photoEmpty');
         $currentdate= date('Y-m-d H:i:s');
         $standardremark = $this->post('standardremark');
         $remark =  $this->post('remark');
         $type =  $this->post('type');
       
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
		  /* if(count($districtmanager) > 0){
                $distId = array();
                foreach($districtmanager as $distManager1){
                    $distId1 = $distManager1['id'];
                    array_push($distId,$distId1);
                }
                $districtmanager_arr = implode(',',$distId);
            }else{
               $districtmanager_arr = $distManager['id'];
            }*/


        $logindata = $this->user->getUserLogin($id,$type);
        $amb = $this->CommonModel->getAmbulanceRec($ambulanceNo);  
     
        foreach($logindata as $logindata1){
                                if(count($logindata)==1){
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $pilot_name = "";
                                        $pilot_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }elseif($logindata1['login_type'] == 'D'){
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $emt_name = "";
                                        $emso_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }
                                    else
                                    {
                                       $pilot_id=''; 
                                       $pilot_name='';
                                       $emso_id='';
                                       $emt_name='';
                                    }
                                }else{
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }elseif($logindata1['login_type'] == 'D'){
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }
                                     else
                                    {
                                       $pilot_id=''; 
                                       $pilot_name='';
                                       $emso_id='';
                                       $emt_name='';
                                    }
                                }
                            }
                     
    if($photoEmpty == 0){
                /*Add 'ems_media' table */
                if(!empty($_FILES['training_photo']['name'])){
                    $media_args1 = array();
                    foreach ($_FILES['training_photo']['name'] as $key => $image) {
                        $media_args = array();
                        
                        $_FILES['photo']['name']= $_FILES['training_photo']['name'][$key];
                        $_FILES['photo']['type']= $_FILES['training_photo']['type'][$key];
                        $_FILES['photo']['tmp_name']= $_FILES['training_photo']['tmp_name'][$key];
                        $_FILES['photo']['error']= $_FILES['training_photo']['error'][$key];
                        $_FILES['photo']['size']= $_FILES['training_photo']['size'][$key];

                        $_FILES['photo']['name'] = time() .'_'.  $this->sanitize_string($_FILES['photo']['name']);
                        
                        $rsm_config = $this->training;
                        $this->upload->initialize($rsm_config);
                        if (! $this->upload->do_upload('photo')) {
                            $this->response([
                                'data' => 'error',
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                            // die;
                        }else{
                            $media_args['media_name'] = $_FILES['photo']['name'];
                            $media_args['media_data'] = 'training';
                            array_push($media_args1,$media_args);
                            // $this->user->insert_media_maintance($media_args);
                        }
                    }
                }
            }
                
                $data = array(
                
                'dt_amb_ref_no' => $ambulanceNo,
                'dt_state_code' =>  $amb[0]['amb_state'],
                'dt_district_code' => $amb[0]['amb_district'],
                'dt_base_location' => $amb[0]['hp_name'],
                'dt_pilot_id' => $pilot_id,
                'dt_pilot_name' => $pilot_name,
                'dt_emso_id' => $emso_id,
                'dt_emso_name' => $emt_name,
                'dt_district_manager' => $districtmanager,
                'dt_place' => $place,
                'dt_no_of_candidate' => $noofcandidates,
				'dt_pupose_of_training' => $purposeoftraning,
				'dt_previous_odometer' => $startodometer,
                'dt_end_odometer' => $endodometer,
                'dt_start_date_time' => $currentdate,
                'dt_standard_remark' => $standardremark,
                'dt_remark' => $remark,
                'dt_added_by' => $loginUser,
               'dt_added_date' => $currentdate
               /*
                'vs_is_deleted' => '1',
                'vs_base_month' => '2',
                'vs_type_user' => $type,
                'vs_addedby_emt' => $emso_id,
                'vs_addedby_pilot' =>$pilot_id*/
                
               
            );
            
             $total_km = $this->post('endodometer') - $this->post('startodometer');
            $amb_record_data = array(
            'amb_rto_register_no' => $ambulanceNo,
            'start_odmeter' => $startodometer,
            'end_odmeter' => $endodometer ,
            'total_km' => $total_km,
            'timestamp' => date('Y-m-d H:i:s'));
     
                   
                 if($traineeid==0)
                 {
                     $demotraineeid = $this->user->adddemotrainee($ambulanceNo,$data);
                     if(!$demotraineeid==0){
                      $odometerid = $this->user->insertodometer($ambulanceNo,$amb_record_data);
                        //$ambstatusid = $this->user->updatedambstatus($ambulanceNo,$ambstatus);
                          if(!empty($media_args)){
                                              $media_args['user_id'] = $demotraineeid;
                                              foreach($media_args1 as $media_args2){
                                                  $media_args_merge = array_merge($media_args2,$media_args);
                                                     $this->user->insert_media_maintance($media_args_merge);
                                                  }
                                   }  
                          } 
               
                     
                         $this->response([
                    'data' => ([
                        'traineeid' => $demotraineeid,
                  
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
                }
                else{
                      $loginUser = $logindata[0]['clg_ref_id'];
               
                $data = array(
                
                'dt_amb_ref_no' => $ambulanceNo,
                'dt_state_code' =>  $amb[0]['amb_state'],
                'dt_district_code' => $amb[0]['amb_district'],
                'dt_base_location' => $amb[0]['hp_name'],                
                'dt_pilot_id' => $pilot_id,
                'dt_pilot_name' => $pilot_name,
                'dt_emso_id' => $emso_id,
                'dt_emso_name' => $emt_name,
                'dt_district_manager' => $districtmanager,
                'dt_place' => $place,
                'dt_no_of_candidate' => $noofcandidates,
				'dt_pupose_of_training' => $purposeoftraning,
				'dt_previous_odometer' => $startodometer,
                'dt_end_odometer' => $endodometer,
                'dt_start_date_time' => $currentdate,
                'dt_standard_remark' => $standardremark,
                'dt_remark' => $remark,
                'dt_added_by' => $loginUser,
                'dt_is_deleted' => '0',                
                'dt_modify_by' => $loginUser,
                'dt_modify_date' => $currentdate,
                'is_updated' => '1'
                
            );
                
                $checkDeviceId = $this->user->updatedemotraining($data,$traineeid);
                 
                
                
                if($checkDeviceId == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'ID Do not exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    //$checkId = $this->user->removecurrentmedia($traineeid);
                     if(!empty($media_args)){
                                              $media_args['user_id'] = $traineeid;
                                              foreach($media_args1 as $media_args2){
                                                  $media_args_merge = array_merge($media_args2,$media_args);
                                                $this->user->insert_media_maintance($media_args_merge);
                                                  }
                                   }  
                          } 
               
                    
                    $this->response([
                    'data' => ([
                        'traineingid' => $traineeid,
                  
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
                }
                    
                
}

  public function gettraininglist_post(){
		
	    $Ambulanceno = $this->post('Ambulanceno');
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
	    
	    $indReq = $this->user->getaddedemolist($begin,$pageSize);
	  
		if(!empty($indReq)){
            $indRec = array();
            foreach($indReq as $indReq1){
                
                $addedby = explode(',',$indReq1['dt_added_by']);
                $addedbyuser = array();
                foreach($addedby as $addedbyuser1){
                    $logindata = $this->user->getclgname($addedbyuser1);
                   $a= $logindata[0]['clg_first_name'] .' ' .$logindata[0]['clg_mid_name'] .' ' .$logindata[0]['clg_last_name'];
                    array_push($addedbyuser,$a);
                 
                }   
                $addedby = implode(',',$addedbyuser);
               
                
                if($indReq1['dt_modify_date'] == '0000-00-00 00:00:00'){
                    $date = $indReq1['dt_added_date'];
                }else {
                   $date = $indReq1['dt_modify_date'];
                }
                
            
                
                
                
                $indRec1 = array(
                    'trainingid' => (int) $indReq1['dt_id'],
                    'trainingdate' => $indReq1['dt_start_date_time'],
                    'trainingpurpose' => $indReq1['dt_pupose_of_training'],
                    'noofcandidate' => $indReq1['dt_no_of_candidate'],
                    'place' => $indReq1['dt_place'],
                    'district' => $indReq1['dst_name'],
                    'baseLocation'=>$indReq1['dt_base_location'],
                    'ambRegNo' => $indReq1['dt_amb_ref_no'],
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
                $data = $this->user->gettraininglist($Ambulanceno,$user1,$usertype);
                
        if(!empty($data)){
         if((isset($_COOKIE['cookie']))){    
            if(!empty($data)){
                $dist = explode(',',$data[0]['dt_district_manager']);
                $distManager = array();
                foreach($dist as $dist1){
                    $distManager1 = $this->user->getDistrictManager($dist1);
                     $str = $this->db->last_query();
         
                    $a = (object) array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
            }
            
           $approveRem = $this->user->getreamarkvisitor($data[0]['dt_standard_remark']);
	
           
	
        $visiterlist1 = array();
        foreach($data as $data1){
           
               $visiterlist['trainingid'] = (int) $data1['dt_id'];
                $visiterlist['pilotid'] =  $data1['dt_pilot_id'];
                $visiterlist['pilotname'] = $data1['dt_pilot_name'];
                $visiterlist['emtid'] =  $data1['dt_emso_id'];
                $visiterlist['emtname'] = $data1['dt_emso_name'];
                $visiterlist['trainingdate'] = $data1['dt_start_date_time'];
                $visiterlist['place'] = $data1['dt_place'];
                $visiterlist['noofcandidate'] = $data1['dt_no_of_candidate'];
                $visiterlist['trainingpurpose'] = $data1['dt_pupose_of_training'];
                $visiterlist['startodometer'] = $data1['dt_previous_odometer'];
                $visiterlist['endodometer'] = $data1['dt_end_odometer'];
                $visiterlist['distmanager'] = $distManager;
                $visiterlist['stdremark'] = $approveRem;
                $visiterlist['remark'] = $data1['dt_remark'];
                $visitorlist['addeddate'] = date('Y-m-d H:i:s');
               
                if($usertype=='D')
        		  {
        		   $addedby = $data1['dt_pilot_name']; 
        		  
        		   
        		  } 
        		  elseif($usertype=='P'){
        		      $addedby = $data1['dt_emso_name'];
        		     
        		      
        		  } 
               $visiterlist['addedby'] = $addedby;
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
                  
		        $data = $this->user->singletraininglist($Ambulanceno,$loginid);
		        
		        
	 if(!empty($data)){
         if((isset($_COOKIE['cookie']))){
		        $data2 = explode(',',$data[0]['dt_added_by']);
		        
       

            if(!empty($data)){
                $dist = explode(',',$data[0]['dt_district_manager']);
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
            
             $approveRem = $this->user->getreamarkvisitor($data[0]['dt_standard_remark']);
            
        	
                $visiterlist1 = array();
                foreach($data as $data1){
                $visiterlist['trainingid'] = (int) $data1['dt_id'];
                $visiterlist['pilotid'] = $data1['dt_pilot_id'];
                $visiterlist['pilotname'] = $data1['dt_pilot_name'];
                $visiterlist['emtid'] =  $data1['dt_emso_id'];
                 $visiterlist['emtname'] = $data1['dt_emso_name'];
                $visiterlist['trainingdate'] = $data1['dt_start_date_time'];
                $visiterlist['place'] = $data1['dt_place'];
                $visiterlist['noofcandidate'] = $data1['dt_no_of_candidate'];
                $visiterlist['trainingpurpose'] = $data1['dt_pupose_of_training'];
                $visiterlist['startodometer'] = $data1['dt_previous_odometer'];
                $visiterlist['endodometer'] = $data1['dt_end_odometer'];
                $visiterlist['distmanager'] = $distManager;
                $visiterlist['stdremark'] = $approveRem;
                $visiterlist['remark'] = $data1['dt_remark'];
                $visitorlist['addeddate'] = date('Y-m-d H:i:s');
                $visiterlist['addedby'] = $clg_full_name;
               
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
   
public function demotrainigndetails_post(){
       if((isset($_COOKIE['cookie']))){
           
      $requestId = $this->post('requestId');
      $accidentaldetailsarr = $this->user->demotrainigndetails($requestId);
     
    
     if(empty($accidentaldetailsarr))
     {
           $this->response([
                        'data' => '',
                        'error' => null
                ], REST_Controller::HTTP_OK);
     }
     else{
        
              $addedby = explode(',',$accidentaldetailsarr[0]['dt_added_by']);
                $addedbyuser = array();
                foreach($addedby as $addedbyuser1){
                    $logindata = $this->user->getclgname($addedbyuser1);
                   $a= $logindata[0]['clg_first_name'] .' ' .$logindata[0]['clg_mid_name'] .' ' .$logindata[0]['clg_last_name'];
                    array_push($addedbyuser,$a);
                 
                }   
                $addedby = implode(',',$addedbyuser);
       $distcode= $accidentaldetailsarr[0]['dt_district_code'];
           $dist = explode(',',$accidentaldetailsarr[0]['dt_district_manager']);
                    $distManager = array();
                    foreach($dist as $dist1){
                    $distManager1 = $this->user->getcurrentDistManager($distcode);
                    $a = array(
                        'id' => $distManager1[0]['clg_id'],
                        'name' => $distManager1[0]['clg_ref_id']
                    );
                    array_push($distManager,$a);
                }
      $mt_stnd_remark = $accidentaldetailsarr[0]['dt_standard_remark'];
      $approveRem = $this->user->getApproveRema($mt_stnd_remark);
      $mediatype='6';
      $media = $this->user->getmedia($requestId,$mediatype);    

 
    
         $data = array(
                        'trainingid' => (int) $accidentaldetailsarr[0]['dt_id'],
                        'trainingdate' => $accidentaldetailsarr[0]['dt_start_date_time'],
                        'pilotName' => $accidentaldetailsarr[0]['dt_pilot_name'],
                        'emstName' => $accidentaldetailsarr[0]['dt_emso_name'],
                        'trainingpurpose' => $accidentaldetailsarr[0]['dt_pupose_of_training'],
                        'stateCode' => $accidentaldetailsarr[0]['dst_state'],
                        'district' => $accidentaldetailsarr[0]['dst_name'],
                        'baseLocation'=>$accidentaldetailsarr[0]['dt_base_location'],
                        'ambRegNo' => $accidentaldetailsarr[0]['dt_amb_ref_no'],
                        'addedby' => $addedby,
                        'noofcandidate' => $accidentaldetailsarr[0]['dt_no_of_candidate'],
                        'place' => $accidentaldetailsarr[0]['dt_place'],
                        'remark' => $accidentaldetailsarr[0]['dt_remark'],
                        //'previosOdometer' => $accidentaldetailsarr[0]['dt_previous_odometer'],
                       // 'endOdometer' => $accidentaldetailsarr[0]['dt_in_odometer'],
                         'uploadedImages' =>$media,
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
			
			