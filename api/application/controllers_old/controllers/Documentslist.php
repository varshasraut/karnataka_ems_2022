<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Documentslist extends REST_Controller
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

public function index_post(){
		
	    $Ambulanceno = $this->post('vehicleNumber');
	    $type = $this->post('type');
        $current_date = date('Y-m-d H:i:s');
        $documnetType  = $this->post('documnetType');
        $GLOBALS['WEB_SITE_URL'] =  base_url();
        $GLOBALS['PROF_DOCUMENTS'] = "api/uploadeddocuments/";
        $PROF_PROF_DOCUMENTS_URL = $GLOBALS['WEB_SITE_URL'].$GLOBALS['PROF_DOCUMENTS'];
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
       if($type==2)
       {
           $data=[];
          
       }
       else{
       
           $user = array();
            if($type == 3){
                
                $pilotiddata = $this->user->getloginpilot($id);
                 $pilotid=$pilotiddata[0]['clg_id'];
                 $loginUser = $this->user->getClgRefid($pilotid);
                 $data = $this->user->getdocumentlist($documnetType);
                
            }else{
                  $pilotid = $this->encryption->decrypt($_COOKIE['cookie']);
                  $loginUser = $this->user->getClgRefid($pilotid);
                  $data = $this->user->getdocumentlist($documnetType);
           
            }
       
           
           
       }
       
        if(!empty($data)){
         if((isset($_COOKIE['cookie']))){ 
             $documentlist1 = array();
         
        foreach($data as $data1){
            
             $userdocumentlist1 = array();
             $docid=$data1['document_list_id'];
            
             $userdata = $this->user->userdocumentlist($documnetType,$loginUser,$docid,$Ambulanceno);
             
             if(!empty($userdata)){
              $upstatus1=$userdata[0]['path'];
              $upstatus=$PROF_PROF_DOCUMENTS_URL.$upstatus1;
             }
             else{
                 
                   $upstatus='';
             }
            
               $documentlist = array(
                        'documentId' => (int) $data1['document_list_id'],
                        'documentName' => $data1['Documents_name'],
                        'uri' =>$upstatus,
                        'uploadStatus'=>(boolean) $upstatus
                    );
              
              
             array_push($documentlist1,$documentlist);
		  }
		  
		  
		    
		        $this->response([
                'data' => $documentlist1,
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
   
