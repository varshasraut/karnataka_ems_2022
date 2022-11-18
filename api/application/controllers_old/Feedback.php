<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Feedback extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
		  if((isset($_COOKIE['cookie']))){
	
		$feedback = $this->post('feedback');	  
        $rating = $this->post('rating');  
        $type = $this->post('type'); 		
        $current_date = date('Y-m-d H:i:s');
        $id = $this->encryption->decrypt($_COOKIE['cookie']);
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
    
       
       
        $data = array(
          
            'feedback' => $feedback,
            'colleague_id' => $rating,
            'added_date' => $current_date
            
        ); 
     
          $currentId = $this->user->insertappfeedback($data);
                $this->response([
                    'data' => ([
                        'feedbackId' => $currentId,
                  
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