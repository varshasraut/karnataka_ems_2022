<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Compincidentinfo extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
            // print_r($deviceId);
            $type = $this->post('type');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id,$type);
            $loginId = $logindata['id'];
            $ambno = $logindata['vehicle_no'];
            
         
            
            $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
            // print_r($deviceIdLogin);
            if(!empty($deviceIdLogin)){
                if($type == 2){
                    $emtId = $this->user->getClgRefid($loginId);
                    $driver = [];
                    $emt = $this->user->getCompIncidence($ambno,$loginId);
                    if(empty($emt)){
                        $emt = [];
                    }else{
                        $emt = $emt;
                    }
                }else if($type == 1){
                    $pilotId = $this->user->getClgRefid($loginId);
                    $driver = $this->user->getCompIncidence($ambno,$loginId);
                    if(empty($driver)){
                        $driver = [];
                    }else{
                        $driver = $driver;
                    }
                    $emt = [];
                }else{
                    if($logindata != 1){
                        $login_type = explode(',',$logindata['login_type']);
                        $loginId = explode(',',$logindata['id']);
                        $combine = array_combine($login_type,$loginId);
                        $emt = $combine['P'];
                        $pilot = $combine['D'];
                        if(!empty($emt)){
                            $emtId = $this->user->getClgRefid($emt);
                            $emt = $this->user->getCompIncidence($ambno,$emt);
                            if(empty($emt)){
                                $emt = [];
                            }else{
                                $emt = $emt;
                            }
                        }
                        if(!empty($pilot)){
                            $pilotId = $this->user->getClgRefid($pilot);
                            $driver = $this->user->getCompIncidence($ambno,$pilot);
                            if(empty($driver)){
                                $driver = [];
                            }else{
                                $driver = $driver;
                            }
                        }
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 401
                            ])
                        ],REST_Controller::HTTP_UNAUTHORIZED);
                    }
                }
                $this->response([
                    'data' => ([
                        'driver' => $driver,
                        'emt' => $emt,
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
                'error' => ([
                    'code' => 401
                ])
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}