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
            $rating = $this->post('rating');
            $vehicle = $this->post('vehicleNumber');
            $veh = explode(' ',$vehicle);
            $vehicleNumber = implode('-',$veh);
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
            // echo $loginUser;die;
            $data = array(
                'feedbck_vehicle_number' => $vehicleNumber,
                'feedbck_remark' => $feedback,
                'feedback_rating' => $rating,
                'feedback_collegue_id' => $loginUser,
                'feedback_added_date' => $current_date
            ); 
            // print_r($data);die;
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