<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Applunchauth extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
	    $type = $this->post('type');
        if(!empty($type)){
            if(isset($_COOKIE['cookie'])){
                $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
                
                $id = $this->encryption->decrypt($_COOKIE['cookie']);
                $logindata = $this->user->getId($id,$type);
                $loginId = $logindata['id'];
                $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
                if(!empty($deviceIdLogin)){
                    $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => "User Logged In"
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error' => null
                    ],REST_Controller::HTTP_UNAUTHORIZED);
                }
            }else{
                $this->response([
                    'data' => null,
                    'error' => null
                ],REST_Controller::HTTP_UNAUTHORIZED);
            }
        }else{
            $this->response([
                'data' => null,
                'error' => ([
                    'code' => 1,
                    'message' => "Empty Data"
                ])
            ],REST_Controller::HTTP_OK);
        }
    }
}
    