<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Patientdetails extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        $patientId = $this->post('patientId');
        if((isset($_COOKIE['cookie']))){
            // if(empty($patientId)){
            //     if(!empty($incidentId)){
            //         $patient = $this->user->getPatientDetails($incidentId);
            //         $this->response([
            //             'data' =>  $patient,
            //             'error' => null
            //         ],REST_Controller::HTTP_OK);
            //     }else{
            //         $this->response([
            //             'data' => ([]),
            //             'error' => null
            //         ],REST_Controller::HTTP_OK);
            //     }
            // }else{
                if(!empty($patientId)){
                    $patientRecord = $this->user->getPatientMedInfo($patientId);
                    // print_r($patientRecord);die;
                    if(empty($patientRecord)){
                        $patient = $this->user->getPatientInfo($patientId);
                        // print_r($patient);
                        if(!empty($patient)){
                            $this->response([
                                'data' =>  ([
                                    'id' => (int) $patient[0]['ptn_id'],
                                    'firstName' => $patient[0]['ptn_fname'],
                                    'middleName' => $patient[0]['ptn_mname'],
                                    'lastName' => $patient[0]['ptn_lname'],
                                    'age' => (int) $patient[0]['ptn_age'] == "" ? null : (int) $patient[0]['ptn_age'],
                                    'ageType' => isset($patient[0]['ptn_age_type']) ? $patient[0]['ptn_age_type'] : "",
                                    'patientImpProvider' => ([
                                        'id' => (int) -1,
                                        'name' => null,
                                    ]),
                                    'patientCaseType' => ([
                                        'id' => (int) -1,
                                        'name' => null,
                                    ]),
                                    'patientRemark' => null,
                                    'dob' => $patient[0]['ptn_birth_date'] == "0000-00-00 00:00:00" ? null : $patient[0]['ptn_birth_date'],
                                    'gender' => $patient[0]['ptn_gender'],
                                    'bloodGroup' => $patient[0]['ptn_bgroup'],
                                    'locId' => (int) 0,
                                    'loc' => null,
                                    'patientComToHosp' => (int) -1,
                                    'patientComToHospRes' => ([
                                    'id' => (int) 0,
                                    'name' => null,
                                    'otherSelected' => null,
                                    'other' => null
                                    ])
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $this->response([
                                'data' =>  null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Empty Data'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                        
                    }else{
                        if(empty($patientRecord[0]['pat_com_to_hosp_reason']) && (!empty($patientRecord[0]['pat_com_to_hosp_reason_other']))){
                            $otherSelected = true;
                            $other = $patientRecord[0]['pat_com_to_hosp_reason_other'];
                        }else{
                            // print_r('ll');
                            $otherSelected = false;
                            $other = null;
                        }
                        $this->response([
                            'data' => ([
                                'id' => (int) $patientRecord[0]['ptn_id'],
                                'firstName' => $patientRecord[0]['ptn_fname'],
                                'middleName' => $patientRecord[0]['ptn_mname'],
                                'lastName' => $patientRecord[0]['ptn_lname'],
                                'age' => (int) $patientRecord[0]['ptn_age'] == "" ? null : (int) $patientRecord[0]['ptn_age'],
                                'ageType' => isset($patientRecord[0]['ptn_age_type']) ? $patientRecord[0]['ptn_age_type'] : "",
                                'patientImpProvider' => ([
                                    'id' => (int) $patientRecord[0]['provider_impressions'],
                                    'name' => $patientRecord[0]['pro_name'],
                                ]),
                                'patientCaseType' => ([
                                    'id' => (int) $patientRecord[0]['provider_casetype'],
                                    'name' => $patientRecord[0]['case_name'],
                                ]),
                                'patientRemark' => $patientRecord[0]['ptn_onscene_app_remark'],
                                'dob' => $patientRecord[0]['ptn_birth_date'] == "0000-00-00 00:00:00" ? null : $patientRecord[0]['ptn_birth_date'],
                                'gender' => $patientRecord[0]['ptn_gender'],
                                'bloodGroup' => $patientRecord[0]['ptn_bgroup'],
                                'patientAddress' => $patientRecord[0]['ptn_address'],
                                'locId' => (int) $patientRecord[0]['level_id'],
                                'loc' => $patientRecord[0]['level_type'],
                                'patientComToHosp' => $patientRecord[0]['pat_com_to_hosp'],
                                'patientComToHospRes' => ([
                                    'id' => (int) $patientRecord[0]['pat_com_to_hosp_reason'],
                                    'name' => $patientRecord[0]['reason'],
                                    'otherSelected' => $otherSelected,
                                    'other' => $other
                                ]),
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    $this->response([
                        'data' => ([]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            // }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}