<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Getmodules extends REST_Controller
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
        
    
   $type = $this->post('type');   
   $id = $this->encryption->decrypt($_COOKIE['cookie']); 
        if($type==4)
        {
          $data1 = $this->user->getotherusrdetails($id); 
          $usergroup = $data1[0]['clg_group'];
           $data = $this->user->getclgmodule($id,$type,$usergroup);  
        }
        else
        {
          $usergroup='';
          $data = $this->user->getclgmodule($id,$type,$usergroup); 
        } 
      
       if(!empty($data)){
         if((isset($_COOKIE['cookie']))){ 
        $stockarray = array();
        
     foreach($data as $data1){
         
          $status = $data1['status'];
          
          if($status==1){
              $visibilty ='1';
          }
          else{
              $visibilty='';
          }
         
        $stockarray1 = array(
                    'code' => (int) $data1['module_id'],
                    'featureName' => $data1['module_name'],
                     'visibility' =>(boolean) $visibilty
                    );
    
      array_push($stockarray,$stockarray1);
     }
     
     if($type==4){
         $isLeaveApprove='1';
         $isAssignedCallDisplay='';
         $isCallAcceptedDisplay='';
         $dispatchStockEquipmentRequest='1';
         $sendMaintenanceRequest = '';
         $acceptRejectMaintenanceRequest = '1';
         
     }
     else{
          $isLeaveApprove='';
          $isAssignedCallDisplay='1';
          $isCallAcceptedDisplay='1';
           $dispatchStockEquipmentRequest='';
           $sendMaintenanceRequest = '1';
         $acceptRejectMaintenanceRequest = '';
         
     }
     
    $stockarray12= array('listOfDashFeatures' =>$stockarray,
    'isAssignedCallDisplay' =>(boolean) $isAssignedCallDisplay,
    'isLeaveApprove'=> (boolean) $isLeaveApprove,
     'approveStockEquipmentRequest'=> (boolean) $dispatchStockEquipmentRequest,
     'dispatchStockEquipmentRequest'=> (boolean) $dispatchStockEquipmentRequest,
      'sendStockEquipmentRequest'=> (boolean) $isAssignedCallDisplay,
    'isCallAcceptedDisplay'=> (boolean) $isCallAcceptedDisplay,
    'sendMaintenanceRequest' => (boolean) $sendMaintenanceRequest,
     
    'acceptRejectMaintenanceRequest' => (boolean) $acceptRejectMaintenanceRequest);
    
    
        $this->response([
                'data' => $stockarray12,
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



