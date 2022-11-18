<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';

class Uploaddocuments extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model(array('CommonModel','user'));
        $this->load->library('encryption');
        $this->offroad = $this->config->item('offroad');
        $this->load->library('upload');
        $this->load->helper(['url','file','form']); 
    }
 
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            
           
            
            $type = $this->post('type');
            $ambulanceNo = $this->post('ambulanceNumber');
            $documentType = $this->post('documentType');
            $doclistId = $this->post('doclistId'); 
            
            $uniqid=uniqid();
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id,$type);
            $user = array();
            if($type == 3){
                
                 $pilotiddata = $this->user->getloginpilot($id);
                 $pilotid=$pilotiddata[0]['clg_id'];
              
                 $pilot_ref_id = $this->user->getClgRefid($pilotid);
                
                $userLoginArr = explode(',',$logindata['id']);
                foreach($userLoginArr as $userLoginArr1){
                    $user1 = $this->user->getClgRefid($userLoginArr1);
                    array_push($user,$user1);
                }
                $loginUser = implode(',',$user);
            }else{
                $loginUser = $this->user->getClgRefid($logindata['id']);
            }
            
            
                        	
					      $file_name = $_FILES['documentFile']['name'];
						  $file_size = $_FILES['documentFile']['size'];
						  $file_tmp = $_FILES['documentFile']['tmp_name'];
						  $file_type = $_FILES['documentFile']['type'];

                          $tmp = explode('.', $file_name);
                          $file_ext = end($tmp);
						  $expensions= array("jpeg","jpg","png","pdf","PDF");
							 
							  
							 if(in_array($file_ext,$expensions)=== false)
                    							  {
                    							 $this->response([
                                        'data' => ([
                                            'code' => 1,
                                            'message' => 'Incorrect format'
                                        ]),
                                        'error' => null
                                         ],REST_Controller::HTTP_OK);
							  }
							  
							 else if(empty($errors)==true) 
							  {
								  $extension=(".$file_ext");
								  
								 move_uploaded_file($file_tmp,"../api/uploadeddocuments/".$uniqid.$extension);
								 $file=$uniqid.$extension;
                        		 $GLOBALS['WEB_SITE_URL'] =  base_url();
                                $GLOBALS['PROF_DOCUMENTS'] = "uploadeddocuments/";
                                $PROF_PROF_DOCUMENTS_URL = $GLOBALS['WEB_SITE_URL'].$GLOBALS['PROF_DOCUMENTS'];
                        								 
								 $fileuri=$PROF_PROF_DOCUMENTS_URL.$file;
								 
    								        $uploaddoc['amb_number'] = $ambulanceNo; 
    								        if($type==3){
                                            $uploaddoc['clg_ref_id'] = $pilot_ref_id;
    								        }
    								        else{
    								          $uploaddoc['clg_ref_id'] = $loginUser;
    								        }
    								        $uploaddoc['documenttype'] = $documentType;
                                            $uploaddoc['document_list_id'] = $doclistId;
                                            $uploaddoc['path'] = $file;
                                            $uploaddoc['added_by'] = $loginUser;
                                            $uploaddoc['added_date'] = date('Y-m-d H:i:s');
                                if($type==3)
                                {
                                      $userdata = $this->user->userdocumentlist($documentType,$pilot_ref_id,$doclistId,$ambulanceNo); 
                                }
                                
                                  else{
                                        $userdata = $this->user->userdocumentlist($documentType,$loginUser,$doclistId,$ambulanceNo); 
                                  }
                                
                               
                                if(!empty($userdata))
                                {
                                      $clg_doc_id=$userdata[0]['Clg_Documents_id'];
                                     $document_list_id=$userdata[0]['document_list_id'];
                                    $uploaddocId = $this->user->updatedocuments($clg_doc_id,$uploaddoc);
                                    
                                            if(!empty($uploaddocId)) 
                                          { 
                          
                                                                $this->response([
                                                                    'data' => ([
                                                                        'uploaddocId' => $document_list_id,
                                                                        'uri'=>$fileuri
                                                                  
                                                                    ]),
                                                                    'error' => null
                                                                ], REST_Controller::HTTP_OK);
                                                     	 
                                                			  
                            							  }
                            							    else{
                            								   $this->response([
                                                'data' => ([
                                                    'code' => 1,
                                                    'message' => 'Not Inserted'
                                                ]),
                                                'error' => null
                                            ],REST_Controller::HTTP_OK);
								 
							             }
                                    
                                    
                                }
                                else{
                                     $uploaddocId = $this->user->insertdocuments($uploaddoc);
                                     
                                            if(!empty($uploaddocId)) 
                                          { 
                          
                                                                $this->response([
                                                                    'data' => ([
                                                                        'uploaddocId' => $doclistId,
                                                                          'uri'=>$fileuri
                                                                  
                                                                    ]),
                                                                    'error' => null
                                                                ], REST_Controller::HTTP_OK);
                                                     	 
                                                			  
                            							  }
                            							    else{
                            								   $this->response([
                                                'data' => ([
                                                    'code' => 1,
                                                    'message' => 'Not Inserted'
                                                ]),
                                                'error' => null
                                            ],REST_Controller::HTTP_OK);
								 
							             }
                                     
                                     
                                     
                                }
                               
                               // $addSummery = $this->user->insertAmbSummery($summery);
                                //$addtimestamp = $this->user->insertTimestampRec($timestamp);
                                
              
      
       }
       }
       else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
public function getuserlistofdocuments_post()
{
     $id = $this->encryption->decrypt($_COOKIE['cookie']);   
    $documentType = $this->post('documentType');
   $data = $this->user->getlistofuser($documentType);  
      
      
         if((isset($_COOKIE['cookie']))){ 
        $this->response([
                'data' => $data,
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
    public function getuserdocuments_post() {
        $id = $this->encryption->decrypt($_COOKIE['cookie']);   
        $documentType = $this->post('documentType');
        $doclistid=$this->post('doclistid');
        $data = $this->user->getlistofuserdoc($documentType,$doclistid);  
        $GLOBALS['WEB_SITE_URL'] =  base_url();
        $GLOBALS['PROF_DOCUMENTS'] = "api/uploadeddocuments/";
        $PROF_PROF_DOCUMENTS_URL = $GLOBALS['WEB_SITE_URL'].$GLOBALS['PROF_DOCUMENTS'];
        if((isset($_COOKIE['cookie']))){
            if(!empty($data)){   
                $stockarray = array();
                    foreach($data as $data1){
                        $fileuri=$PROF_PROF_DOCUMENTS_URL.$data1['path'];  
                        $stockarray1 = array(
                                    'id' => (int) $data1['Clg_Documents_id'],
                                    'name' => $data1['clg_ref_id'],
                                    'uri'=>$fileuri
                                    );
                            array_push($stockarray,$stockarray1);
                    }
                    $this->response([
                        'data' => $stockarray,
                        'error' => null
                    ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => [],
                    'error' => null
                ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }else{
            $this->response([
                'data' => [],
                'error' => null
            ],REST_Controller::HTTP_OK);
        }  
    }

}