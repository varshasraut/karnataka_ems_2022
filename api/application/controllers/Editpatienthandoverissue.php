<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Editpatienthandoverissue extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $type = $this->post('type');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $chklogindata = $this->user->getId($id,$type);
            $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
            $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
            if($chklogindata == 1 || (empty($deviceIdLogin))){
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_UNAUTHORIZED);
            }else{
                if(!empty($patientId)){
                    $issues = $this->user->getissuesname($patientId);
                    if(!empty($issues)){
                        $this->response([
                            'data' => ([ 
                                'id' => (int) $issues[0]['ptn_id'],
                                'patientHandoverIssue' => $issues[0]['hi_pat_handover'],
                                'opdNo' => $issues[0]['opd_no_txt'],
                                'hospPersonName' => $issues[0]['hosp_person_name'],
                                'hospCorrDateTime' => $issues[0]['corr_action_dt'],
                                'hospCommHosp' => $issues[0]['com_with_hosp'],
                                'hospRemark' => $issues[0]['hi_remark'],
                                'patientHandoverIssueReason' => ([
                                    'id' => (int) $issues[0]['id'],
                                    'name' => $issues[0]['name'],
                                ])
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => null
                        ],REST_Controller::HTTP_OK); 
                    }
                }else{
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK); 
                }
            }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        } 
    }
}


