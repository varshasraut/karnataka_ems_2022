<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Updateodometer extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
		  if((isset($_COOKIE['cookie']))){
			  
		 $ambno = $this->post('ambulanceNo');	  
        $prevodometer = $this->post('prevodometer');
        $newodometer = $this->post('newodometer');
        $remark = $this->post('remark');
        $type = $this->post('type');
        $current_date = date('Y-m-d H:i:s');
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
      
         
       
       
            if($ambno == '' || $prevodometer == '' || $newodometer == '' )
            {
                $this->response("Please provide data", REST_Controller::HTTP_BAD_REQUEST);
            }
            else
            {
                 $data = array(
            'amb_rto_register_no' => $ambno,
            'start_odmeter' => $prevodometer,
            'end_odmeter' => $newodometer,
            'total_km' => $newodometer - $prevodometer,
            'timestamp' => date('Y-m-d H:i:s'),
            'remark' => $remark,
            'modify_by' => $loginUser,
            'remark_type' => 'update_odometer_amb',
            'modify_date_sync' => $current_date,
            'odometer_date' => date('Y-m-d'),
            'odometer_time' => date('H:i:s'),
            
        ); 
     
     
     
                
                $updateId = $this->user->updateodometer($data,$ambno,$prevodometer);
                if($updateId == 1){
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Update ID Do not exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                    'data' => ([
                        'id' => null,
                  
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
                }
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


