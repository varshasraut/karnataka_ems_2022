<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Logout extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
       if(isset($_COOKIE['cookie'])){
            $type = $this->post('type');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            // print_r($type);
            // print_r($id);
            $logindata1 = $this->user->getId($id,$type);
            $ambno = $logindata1['vehicle_no'];
            // print_r($logindata1);
            $data = $this->user->assignedIncidenceCalls($ambno);
            // print_r($data);die;
            $a = array();
            if(!empty($data)){
                foreach($data as $data1){
                    if($data1['chkForLogout'] == 'true'){
                        $b = 1;
                        array_push($a,$b);
                    }
                }
            }
            if(empty($a)){
                $logindata = $this->user->logout($id,$type);
                if($logindata == 1){
                    $this->user->logout($id,$type);
                    $cookie = array(
                                'name'   => 'cookie',
                                'value'  => '',
                                'expire' =>  0,
                                'secure' => false
                            );
                    delete_cookie($cookie);
                    $deviceIdCookie = array(
                        'name'   => 'deviceId',
                        'value'  => '',
                        'expire' =>  0,
                        'secure' => false,
                    );
                    delete_cookie($deviceIdCookie);
                    $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => "Successfully Logout"
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => ([
                            'code' => 2,
                            'message' => "Not Logout"
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => ([
                        'code' => 3,
                        'message' => "In-Progress"
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}