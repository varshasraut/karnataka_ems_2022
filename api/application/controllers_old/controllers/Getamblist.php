<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Getamblist extends REST_Controller
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
        
    
   // $type = $this->post('type');   
   //$pageIndex = $this->post('pageIndex'); 
   //$pageSize = $this->post('pageSize'); 
   //$begin = ($pageIndex * $pageSize) - $pageSize;
   
   $id = $this->encryption->decrypt($_COOKIE['cookie']);    
   $data = $this->user->getamblist($id);  
      
       if(!empty($data)){
         if((isset($_COOKIE['cookie']))){ 
        $stockarray = array();
        
     foreach($data as $data1){
        $stockarray1 = array(
                    'id' => (int) $data1['amb_id'],
                    'name' => $data1['amb_rto_register_no']
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

 public function getambincident_post(){
		
	    $ambid = $this->post('id');
	    $searchfor = $this->post('searchfor');
	    $fromDate = $this->post('fromDate');
	    $toDate = $this->post('toDate');
	    $inctype = $this->post('inctype');
	    $pageIndex = $this->post('pageIndex'); 
        $pageSize = $this->post('pageSize'); 
        $begin = ($pageIndex * $pageSize) - $pageSize;
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
    	if(!empty($ambid)){
    	    
                $ambdata = $this->user->getambdetails($ambid);
                $ambnumber = $ambdata[0]['amb_rto_register_no'];
    	    
    	}  
    	else
    	{
    	    $ambnumber='';
    	    
    	}
    
       
		$data = $this->user->getambwiseinc($searchfor,$fromDate,$toDate,$ambnumber,$inctype,$begin,$pageSize);

		if(!empty($data)){
        $leavelist1 = array();
        
        foreach($data as $data1){
            
            $Date=$data1['assigned_time'];
            $newDate = date("Y-m-d", strtotime($Date));
            $newtime = date("h:m:s", strtotime($Date));
            
                       $recordData1['incidentId'] = (int) $data1['refid'];
                       $recordData1['incidentDate'] = $newDate;
                       $recordData1['incidentTime'] = $newtime;
                       $recordData1['pilotName'] = $data1['pilot_name'];
                       $recordData1['emtName'] = $data1['emt_name'];
                       $recordData1['callerName'] =  $data1['clr_fname'].' '.$data1['clr_mname'].' '.$data1['clr_lname'];
                          if($data1['inc_type'] == 'MCI'){
                       $recordData1['cheifComplaint'] = $data1['ntr_nature'];
                        }else{
                          $recordData1['cheifComplaint'] = $data1['ct_type'];
                        }
                        $inctype=$data1['inc_pcr_status'];
                        if($inctype==0)
                        {
                            $inctype=1;
                        }
                        else
                        {
                            $inctype=2;
                        }
                       $recordData1['inctype'] = $inctype;
                       array_push($leavelist1,$recordData1);
               
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

 public function getambodometer_post(){
		
  
    $type = $this->post('type');
    $vehicalNumber = $this->post('vehicleNumber');
    $current_date = date('Y-m-d H:i:s');  
    $id = $this->encryption->decrypt($_COOKIE['cookie']);
   
    $odometerdetails = $this->user->getendodometer($vehicalNumber);
 
   
                   if((isset($_COOKIE['cookie']))){
                        $this->response([
                        'data' => $odometerdetails,
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
public function getquestions_post(){
    $type = $this->post('qualityType');
    $current_date = date('Y-m-d H:i:s');  
    $id = $this->encryption->decrypt($_COOKIE['cookie']);
   
    $questionlist = $this->user->getquestionsofquality($type);
                   if((isset($_COOKIE['cookie']))){
                        $this->response([
                        'data' => $questionlist,
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
public function addqualitycheck_post(){

 if((isset($_COOKIE['cookie']))){
		 $qualityCheck = $this->post('qualityCheck');
		 $qualityType = $this->post('qualityType');	 
       	 $vehicleNumber = $this->post('vehicleNumber');
       	 $remark = $this->post('remark');
       	 $emtName = $this->post('emtName');
         $pilotname = $this->post('pilotname');
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
       // $logindata = $this->user->getUserLogin($id,$type);
       // $clgid = $logindata[0]['clg_id'];

     
     $amb = $this->CommonModel->getAmbulanceRec($vehicleNumber); 
      $data = array(
            'vehical_no' => $vehicleNumber,
            'qa_ques_type' => $qualityType,
            'state_code' =>  $amb[0]['amb_state'],
            'dist_code' => $amb[0]['amb_district'],
            'base_location' => $amb[0]['hp_name'],
            'emt_name' => $emtName,
            'pilot_name' => $pilotname,
            'remark' => $remark,
            'added_by' => $id,
            'added_date' => $current_date
        ); 
     $currentId = $this->user->insertqualitycheck($data);
   
   foreach($qualityCheck as $data1){ 
     
        $isAvailable =$data1['quality'];
      
        $detaildata = array(
            'q_checkId' => $currentId,
            'question_id' => $data1['questionId'],
            'isAvailable' => $isAvailable,
            'obt_marks' => $data1['marks'],
            'remark' => $data1['remark'],
            'added_by' => $id,
            'added_date' => $current_date
        ); 
      
          $detailedid = $this->user->insertqualitycheckdetails($detaildata);
        
    }          
                $this->response([
                    'data' => ([
                        'qualitycheckId' => $currentId,
                  
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
            }
       
	else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }

   

    
    
    
}

}

