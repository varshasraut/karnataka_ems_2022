<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Patientadd extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $patientId = $this->post('patientId');
            $type = $this->post('type');
            $incidentID = $this->post('incidentId');
            $patientFName = $this->post('patientFName');
            $patientMName = $this->post('patientMName');
            $patientLName = $this->post('patientLName');
            $patientCaseType = $this->post('patientCaseType');
            $patientImpProviderKey = $this->post('patientImpProvider');
            $patientImpProvider = isset($patientImpProviderKey) ? $patientImpProviderKey : "";
            $patientRemark = $this->post('patientRemark');
            $fullName = $this->post('patientFName').' '.$this->post('patientMName').' '.$this->post('patientLName');
            $age = $this->post('age');
            $ageType = $this->post('ageType');
            $dob = $this->post('dob');
            $gender = $this->post('gender');
            $bgroup = $this->post('bgroup');
            $onsceneCallType = $this->post('onsceneCallType');
            if($onsceneCallType == 'yes' || $onsceneCallType == null){
                $ptnComToHosp = 0;
            }else{
                $ptnComToHosp = $this->post('ptnComToHosp');
            }
            $result = $this->db->query("SELECT p_id FROM ems_patient ORDER BY p_id DESC LIMIT 1")->result();
            $last_pat_id = $result[0]->p_id + 1;
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getUserLogin($id,$type);
            $incidentData = $this->user->getIncidentData($incidentID);
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentID);
            $dp_operated_by = array();
            if(empty($logindata)){
                $this->response([
                    'data' => null,
                    'error' => ([
                        'code' => 1,
                        'message' => 'User not login'
                    ])
                ],REST_Controller::HTTP_OK);
            }else{
                foreach($logindata as $logindata1){
                    if(count($logindata)==1){
                        if($logindata1['login_type'] == 'P'){
                            $emso_id = $logindata1['clg_ref_id'];
                            array_push($dp_operated_by,$emso_id);
                        }else{
                            $pilot_id = $logindata1['clg_ref_id'];
                            array_push($dp_operated_by,$pilot_id);
                        }
                    }else{
                        if($logindata1['login_type'] == 'P'){
                            $emso_id = $logindata1['clg_ref_id'];
                            array_push($dp_operated_by,$emso_id);
                        }else{
                            $pilot_id = $logindata1['clg_ref_id'];
                            array_push($dp_operated_by,$pilot_id);
                        }
                    }
                    
                }
            }
            if(count($dp_operated_by) == 2){
                $dp_operated_by1 = implode(',',$dp_operated_by);
            }else{
                if(!empty($dp_operated_by)){
                    $dp_operated_by1 = $dp_operated_by[0];
                }else{
                    $dp_operated_by1 = null;
                }
            }
            if($patientId == null) {
                if(empty($checkIncidentIdClose)){
                    if(empty($incidentData)){
                        $this->response([
                            'data' => ([
                                'code' => 3,
                                'message' => 'Incident Id not exist'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $data = array(
                        'ptn_id' => $last_pat_id,
                        'ptn_fname' => $patientFName,
                        'ptn_mname' => $patientMName,
                        'ptn_lname' => $patientLName,
                        'ptn_fullname' => $fullName,
                        'ptn_age' => $age == "-1" ? "" : $age,
                        'ptn_birth_date' => $dob,
                        'ptn_gender' => $gender,
                        'ptn_bgroup' => $bgroup,
                        'ptn_added_date' => date('Y-m-d H:i:s'),
                        'ptn_state' =>  $incidentData[0]['inc_state_id'],
                        'ptn_district' => $incidentData[0]['inc_district_id'],
                        'ptn_tahsil' => $incidentData[0]['inc_tahshil_id'],
                        'ptn_city' => $incidentData[0]['inc_city_id'],
                        'ptn_address' => $incidentData[0]['inc_address'],
                        'ptn_ltd' => $incidentData[0]['inc_lat'],
                        'ptn_lng' => $incidentData[0]['inc_long'],
                        'ptn_area' => $incidentData[0]['inc_area'],
                        'ptn_age_type' => $ageType,
                        'ptn_added_by' => $dp_operated_by
                        );
                        // $loc = $this->post('loc');
                        $ptn_com_with_hosp = $this->post('PtnComWithHosp');
                        $PatientId1 = $this->user->addPatient($data);
                        // print_r($PatientId1);
                        $unique = "AMB--";
                        $len = 6;
                        if (function_exists("random_bytes")) {
                            $bytes = random_bytes(ceil($len / 2));
                            $data = "s" . substr(bin2hex($bytes), 0, $len);
                        } elseif (function_exists("openssl_random_pseudo_bytes")) {
                            $bytes = openssl_random_pseudo_bytes(ceil($len / 2));
                            $data = "s" . substr(bin2hex($bytes), 0, $len);
                        } else {
                            $data =  "s" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $len);
                        }
                        $primary_key = $unique .date("Y") . str_pad(date("z"), 3, "0", STR_PAD_LEFT) . time() .$data;
                        $incPat['inc_id'] = $incidentID;
                        $incPat['ptn_id'] = $PatientId1;
                        $incPat['id'] = $primary_key;
                        $lastIncPtnId = $this->user->insertIncidencePatient($incPat);
                        $patientInfo = $this->user->getPatientInfo($PatientId1);
                        // print_r($patientInfo);
                        $epcr['id'] = $primary_key;
                        $epcr['pat_com_to_hosp'] = $ptnComToHosp;
                        $epcr['pat_com_to_hosp_reason'] = $this->post('ptnComToHospReason');
                        $epcr['pat_com_to_hosp_reason_other'] = $this->post('ptnComToHospReasonOther');
                        // $epcr['loc'] = $this->post('loc');
                        $epcr['date'] = date('m/d/y');
                        $epcr['time'] = date('H:i:s');
                        $epcr['inc_ref_id'] = $this->post('incidentId');
                        $epcr['ptn_id'] = $patientInfo[0]['ptn_id'];
                        // $epcr['state_id'] = $patientInfo[0]['ptn_state'];
                        // $epcr['district_id'] = $patientInfo[0]['ptn_district'];
                        // $epcr['tahsil_id'] = $patientInfo[0]['ptn_tahsil'];
                        // $epcr['city_id'] = $patientInfo[0]['ptn_city'];
                        // $epcr['locality'] = $patientInfo[0]['ptn_address'];
                        $epcr['state_id'] = $incidentData[0]['inc_state_id'];
                        $epcr['district_id'] = $incidentData[0]['inc_district_id'];
                        $epcr['tahsil_id'] = $incidentData[0]['inc_tahshil_id'];
                        $epcr['city_id'] = $incidentData[0]['inc_city_id'];
                        $epcr['locality'] = $incidentData[0]['inc_address'];
                        $epcr['inc_datetime'] = $incidentData[0]['inc_datetime'];
                        $epcr['added_date'] = 'Y-m-d H:i:s';
                        $epcr['operate_by'] = $dp_operated_by1;
                        $epcr['provider_impressions'] = $patientImpProvider;
                        $epcr['provider_casetype'] = $patientCaseType;
                        $epcr['ptn_onscene_app_remark'] = $patientRemark;
                        // print_r($logindata);
                        if(empty($logindata)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'User not login'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
                            foreach($logindata as $logindata1){
                                if(count($logindata)==1){
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $pilot_name = "";
                                        $pilot_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }else{
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $emt_name = "";
                                        $emso_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }
                                }else{
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }else{
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }
                                }
                            }
                            $epcr['emt_name'] = $emt_name;
                            $epcr['emso_id'] = $emso_id;
                            $epcr['pilot_name'] = $pilot_name;
                            $epcr['pilot_id'] = $pilot_id;
                            $epcr['base_month'] = $incidentData[0]['inc_base_month'];
                            $epcrData = $this->user->insertPatientData($epcr);
                            if($epcrData == 1){
                                $this->response([
                                    'data' => ([
                                        'code' => 1,
                                        'message' => 'successfully Inserted'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $this->response([
                                    'data' => ([
                                        'code' => 2,
                                        'message' => 'Not Inserted'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                        }
                    }
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 105,
                            'message' => 'Incident Id Completed'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
                
            }else{
                $chkPtnInEpcr = $this->user->checkPtnInEpcr($patientId);
                if(empty($chkPtnInEpcr)){
                    if(empty($checkIncidentIdClose)){
                        // $loc = $this->post('loc');
                        $ptn_com_with_hosp = $this->post('PtnComWithHosp');
                        $unique = "AMB--";
                        $len = 6;
                        if (function_exists("random_bytes")) {
                            $bytes = random_bytes(ceil($len / 2));
                            $data = "s" . substr(bin2hex($bytes), 0, $len);
                        } elseif (function_exists("openssl_random_pseudo_bytes")) {
                            $bytes = openssl_random_pseudo_bytes(ceil($len / 2));
                            $data = "s" . substr(bin2hex($bytes), 0, $len);
                        } else {
                            $data =  "s" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $len);
                        }
                        $primary_key = $unique .date("Y") . str_pad(date("z"), 3, "0", STR_PAD_LEFT) . time() .$data;
                        // $incPat['inc_id'] = $incidentID;
                        // $incPat['ptn_id'] = $patientId;
                        // $incPat['id'] = $primary_key;
                        // $lastIncPtnId = $this->user->insertIncidencePatient($incPat);
                        $patientInfo = $this->user->getPatientInfo($patientId);
                        $epcr['id'] = $primary_key;
                        $epcr['pat_com_to_hosp'] = $ptnComToHosp;
                        $epcr['pat_com_to_hosp_reason'] = $this->post('ptnComToHospReason');
                        $epcr['pat_com_to_hosp_reason_other'] = $this->post('ptnComToHospReasonOther');
                        // $epcr['loc'] = $this->post('loc');
                        $epcr['date'] = date('m/d/y');
                        $epcr['time'] = date('H:i:s');
                        $epcr['inc_ref_id'] = $this->post('incidentId');
                        $epcr['ptn_id'] = $patientInfo[0]['ptn_id'];
                        // $epcr['state_id'] = $patientInfo[0]['ptn_state'];
                        // $epcr['district_id'] = $patientInfo[0]['ptn_district'];
                        // $epcr['tahsil_id'] = $patientInfo[0]['ptn_tahsil'];
                        // $epcr['city_id'] = $patientInfo[0]['ptn_city'];
                        // $epcr['locality'] = $patientInfo[0]['ptn_address'];
                        $epcr['state_id'] = $incidentData[0]['inc_state_id'];
                        $epcr['district_id'] = $incidentData[0]['inc_district_id'];
                        $epcr['tahsil_id'] = $incidentData[0]['inc_tahshil_id'];
                        $epcr['city_id'] = $incidentData[0]['inc_city_id'];
                        $epcr['locality'] = $incidentData[0]['inc_address'];
                        $epcr['inc_datetime'] = $incidentData[0]['inc_datetime'];
                        $epcr['added_date'] = 'Y-m-d H:i:s';
                        $epcr['operate_by'] = $dp_operated_by1;
                        $epcr['provider_impressions'] = $patientImpProvider;
                        $epcr['provider_casetype'] = $patientCaseType;
                        $epcr['ptn_onscene_app_remark'] = $patientRemark;
                        // print_r($logindata);
                        if(empty($logindata)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'User not login'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
                            foreach($logindata as $logindata1){
                                if(count($logindata)==1){
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $pilot_name = "";
                                        $pilot_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }else{
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                        $emt_name = "";
                                        $emso_id = "";
                                        // $epcr['amb_reg_id'] = "";
                                    }
                                }else{
                                    if($logindata1['login_type'] == 'P'){
                                        $emt_name = $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $emso_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }else{
                                        $pilot_name= $logindata1['clg_first_name'].' '.$logindata1['clg_mid_name'].' '.$logindata1['clg_last_name'];
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        $epcr['amb_reg_id'] = $logindata1['vehicle_no'];
                                    }
                                }
                            }
                            $epcr['emt_name'] = $emt_name;
                            $epcr['emso_id'] = $emso_id;
                            $epcr['pilot_name'] = $pilot_name;
                            $epcr['pilot_id'] = $pilot_id;
                            $epcr['base_month'] = $incidentData[0]['inc_base_month'];
                            $epcrData = $this->user->insertPatientData($epcr);
                            $data = array(
                                'ptn_fname' => $patientFName,
                                'ptn_mname' => $patientMName,
                                'ptn_lname' => $patientLName,
                                'ptn_fullname' => $fullName,
                                'ptn_gender' => $gender,
                                'ptn_age' => $age == "-1" ? "" : $age, 
                                'ptn_birth_date' => $dob,
                                'ptn_bgroup' => $bgroup,
                                'ptn_age_type' => $ageType
                            );
                            $editPtn = $this->user->editPatient($data,$patientId);
                            if($epcrData == 1){
                                $this->response([
                                    'data' => ([
                                        'code' => 1,
                                        'message' => 'successfully Inserted'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }else{
                                $this->response([
                                    'data' => ([
                                        'code' => 2,
                                        'message' => 'Not Inserted'
                                    ]),
                                    'error' => null
                                ],REST_Controller::HTTP_OK);
                            }
                        }
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 105,
                                'message' => 'Incident Id Completed'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
                }else{
                    if(empty($checkIncidentIdClose)){
                        $data = array(
                        'ptn_fname' => $patientFName,
                        'ptn_mname' => $patientMName,
                        'ptn_lname' => $patientLName,
                        'ptn_fullname' => $fullName,
                        'ptn_gender' => $gender,
                        'ptn_age' => $age == "-1" ? "" : $age, 
                        'ptn_birth_date' => $dob,
                        'ptn_bgroup' => $bgroup,
                        'ptn_age_type' => $ageType
                        );
                        $editPtn = $this->user->editPatient($data,$patientId);
                        $patientData = array(
                            // 'loc' => $this->post('loc'),
                            'pat_com_to_hosp' => $ptnComToHosp,
                            'pat_com_to_hosp_reason' => $this->post('ptnComToHospReason'),
                            'pat_com_to_hosp_reason_other' => $this->post('ptnComToHospReasonOther'),
                            'provider_casetype' => $patientCaseType,
                            'provider_impressions' => $patientImpProvider,
                            'ptn_onscene_app_remark' => $patientRemark
                        );
                        $editpatientData = $this->user->editPatientData($patientData,$patientId);
                        if(($editPtn == 1) && ($editpatientData == 1)){
                            $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Update Successfully'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $this->response([
                                'data' => ([
                                    'code' => 2,
                                    'message' => 'Not Updated'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 105,
                                'message' => 'Incident Id Completed'
                            ])
                        ],REST_Controller::HTTP_OK);
                    }
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