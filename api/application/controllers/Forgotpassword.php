<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Forgotpassword extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $typeId = $this->post('type');
        $pilotId = $this->post('pilotId');
        $emtId = $this->post('emtId');
        $typeThreeMobNo = $this->post('mobile');
        //$pass = rand(1000, 9999);
        $pass = 123456;
        $password = md5($pass);
        if($typeId == 1){
            $emtMobNo = $this->user->getEmtMobNo($pilotId);
            if(!empty($emtMobNo)){
                $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                $txtMsg='';
                $txtMsg .= "Your password is : $pass ";
                
                $data_to_post = array();
                $data_to_post['uname'] = 'bvgmems';
                $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                $data_to_post['send'] = 'SperocHL';
                $data_to_post['dest'] = $emtMobNo; 
                $data_to_post['msg'] = $txtMsg;
                
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL, $form_url);
                curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                $result = curl_exec($curl);
                curl_close($curl);

                $data = array(
                        'clg_password' => $password
                );
                $this->user->insertPilotOtp($data,$pilotId);
                $this->response([
                    'data' => ([
                        'type' => $typeId,
                        'password' => $pass
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 2,
                        'message' => 'Mobile Number Do Not Exist'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else if($typeId == 2){
            $emtMobNo = $this->user->getEmtMobNo($emtId);
            // print_r($emtMobNo);
            if(!empty($emtMobNo)){
                $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                $txtMsg='';
                $txtMsg .= "Your password is : $pass ";
                
                $data_to_post = array();
                $data_to_post['uname'] = 'bvgmems';
                $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                $data_to_post['send'] = 'SperocHL';
                $data_to_post['dest'] = $emtMobNo; 
                $data_to_post['msg'] = $txtMsg;
                
                $curl = curl_init();
                curl_setopt($curl,CURLOPT_URL, $form_url);
                curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                $result = curl_exec($curl);
                curl_close($curl);

                $data = array(
                        'clg_password' => $password
                );
                $this->user->insertEmtOtp($data,$emtId);
                $this->response([
                    'data' => ([
                        'type' => $typeId,
                        'password' => $pass
                    ]),
                    'error' => null
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 2,
                        'message' => 'Mobile Number Do Not Exist'
                    ])
                ],REST_Controller::HTTP_OK);
            }
        }else{
            $mob = $this->user->chkMobNo($typeThreeMobNo);
            // print_r($mob);die;
            if(!empty($mob)){
                if($mob[0]['clg_id'] == $pilotId){
                    // print_r('1');
                    $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                    $txtMsg='';
                    $txtMsg .= "<#> Your password is : $pass 9oAXZ1NZBZi";
                    
                    $data_to_post = array();
                    $data_to_post['uname'] = 'bvgmems';
                    $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                    $data_to_post['send'] = 'SperocHL';
                    $data_to_post['dest'] = $typeThreeMobNo; 
                    // $data_to_post['dest'] = $pilotMobNo;
                    $data_to_post['msg'] = $txtMsg;
                    
                    $curl = curl_init();
                    curl_setopt($curl,CURLOPT_URL, $form_url);
                    curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                    $result = curl_exec($curl);
                    curl_close($curl);

                    $data = array(
                        'clg_password' => $password
                    );
                    // $this->user->insertEmtOtp($data,$emtId);
                    $this->user->insertPilotOtp($data,$pilotId);
                    $this->response([
                        'data' => ([
                            'type' => $typeId,
                            'password' => $pass
                        ]),
                        'error' => null
                    ], REST_Controller::HTTP_OK);
                }else if($mob[0]['clg_id'] == $emtId){
                    $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                    $txtMsg='';
                    $txtMsg .= "<#> Your password is : $pass 9oAXZ1NZBZi";
                    
                    $data_to_post = array();
                    $data_to_post['uname'] = 'bvgmems';
                    $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                    $data_to_post['send'] = 'SperocHL';
                    $data_to_post['dest'] = $typeThreeMobNo; 
                    $data_to_post['msg'] = $txtMsg;
                    
                    $curl = curl_init();
                    curl_setopt($curl,CURLOPT_URL, $form_url);
                    curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                    $result = curl_exec($curl);
                    curl_close($curl);

                    $data = array(
                        'clg_password' => $password
                    );
                    $this->user->insertEmtOtp($data,$emtId);
                    // $this->user->insertPilotOtp($data,$pilotId);
                    $this->response([
                        'data' => ([
                            'type' => $typeId,
                            'password' => $pass
                        ]),
                        'error' => null
                    ], REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 2,
                            'message' => 'Mobile Number Do Not Exist'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 2,
                        'message' => 'Mobile Number Do Not Exist'
                    ])
                ],REST_Controller::HTTP_OK);
            }
            // $pilotMobNo = $this->user->getPilotMobNo($pilotId);
            // $emtMobNo = $this->user->getEmtMobNo($emtId);
            // if(!empty($emtMobNo) || !empty($pilotMobNo)){
                // $form_url = "http://www.unicel.in/SendSMS/sendmsg.php";
                // $txtMsg='';
                // $txtMsg .= "Your password is : $pass ";
                
                // $data_to_post = array();
                // $data_to_post['uname'] = 'bvgmems';
                // $data_to_post['pass'] = 'm2v5c2';//s1M$t~I)';
                // $data_to_post['send'] = 'SperocHL';
                // $data_to_post['dest'] = $emtMobNo; 
                // $data_to_post['dest'] = $pilotMobNo;
                // $data_to_post['msg'] = $txtMsg;
                
                // $curl = curl_init();
                // curl_setopt($curl,CURLOPT_URL, $form_url);
                // curl_setopt($curl,CURLOPT_POST, sizeof($data_to_post));
                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                // curl_setopt($curl,CURLOPT_POSTFIELDS, $data_to_post);
                // $result = curl_exec($curl);
                // curl_close($curl);

            //     $data = array(
            //         'clg_password' => $password
            //     );
            //     $this->user->insertEmtOtp($data,$emtId);
            //     $this->user->insertPilotOtp($data,$pilotId);
            //     $this->response([
            //         'data' => ([
            //             'type' => $typeId,
            //             'password' => $pass
            //         ]),
            //         'error' => null
            //     ], REST_Controller::HTTP_OK);
            // }else{
            //     $this->response([
            //         'data' => null,
            //         'error' => ([
            //             'code' => 2,
            //             'message' => 'Mobile Number Do Not Exist'
            //         ])
            //     ],REST_Controller::HTTP_OK);
            // }
        }
    }
}