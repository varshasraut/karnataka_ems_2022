<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Patienthandoverissue extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $ptnid = $this->post('patientId');
            $data['hi_pat_handover'] = $this->post('hiPatHandover');
            $data['opd_no_txt'] = $this->post('opdNoTxt');
            $data['pat_handover_issue'] = $this->post('patHandoverIssue');
            $data['hosp_person_name'] = $this->post('hospPersonName');
            $data['corr_action_dt'] = $this->post('corrActionDt');
            $data['com_with_hosp'] = $this->post('comWithHosp');
            $data['hi_remark'] = $this->post('hiRemark');
            $data['handover_issue_complete'] = '1';
            if(!empty($ptnid) && (!empty($data['hi_pat_handover']))){
                $issuedata = $this->user->UpdatePatientHandOverIssue($ptnid,$data);
                if($issuedata ==1){
                    $this->response([
                        'data' => ([
                            'code' =>1,
                            'message' => 'Sucessfully Inserted'
                        ]),
                        'error' => null
                        ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error'=> ([
                            'code' =>1,
                            'message' => 'Not Inserted'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            }else{
                $this->response([
                    'data' => ([]),
                    'error' =>null
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


