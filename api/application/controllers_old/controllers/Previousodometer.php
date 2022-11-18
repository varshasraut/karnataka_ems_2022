<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Previousodometer extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
    }
    public function index_post(){
        $ambulanceno = $this->post('vehicleNumber');
        if(!empty($ambulanceno)){
            $odometer = $this->user->getendodometer($ambulanceno);
            $this->response([
                 'data' =>  $odometer,
                 'error' => null
                ],REST_Controller::HTTP_OK);
        }else{
             $this->response([
                 'data' =>([]),
                 'error' =>null
            ],REST_Controller::HTTP_OK);
        }
    }
}