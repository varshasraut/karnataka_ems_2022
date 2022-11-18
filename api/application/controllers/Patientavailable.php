<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Patientavailable extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $type = $this->post('type');
            $incidentId = $this->post('incidentId');
            $patientAvaOrNot['patient_ava_or_not'] = $this->post('patientAvaOrNot');
            $patientAvaOrNot['patient_ava_or_not_reason'] = $this->post('reason');
            $patientAvaOrNot['patient_ava_or_not_other_reason'] = $this->post('otherResaon');
            $patientAvaOrNot['patient_ava_or_not_remark'] = $this->post('remark');
            $data1 = $this->user->patientAvaOrNot($incidentId,$patientAvaOrNot);
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
            // $incidentData = $this->user->getIncidentData($incidentId);
            if($patientAvaOrNot['patient_ava_or_not'] == 'no' && !empty($type)){
                $id = $this->encryption->decrypt($_COOKIE['cookie']);
                $logindata = $this->user->getUserLogin($id,$type);
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
                $ptnId = $this->user->getIncWisePtnId($incidentId);
                $ambNo = $this->user->getAmbNo($incidentId);
                $incidentData = $this->user->getIncidentData($incidentId);
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
                $epcr['id'] = $primary_key;
                $epcr['date'] = date('Y-m-d');
                $epcr['time'] = date('H:i:s');
                $epcr['amb_reg_id'] = $ambNo[0]['amb_rto_register_no'];
                $epcr['inc_ref_id'] = $incidentId;
                $epcr['ptn_id'] = $ptnId[0]['ptn_id'];
                $epcr['state_id'] = $incidentData[0]['inc_state_id'];
                $epcr['district_id'] = $incidentData[0]['inc_district_id'];
                $epcr['tahsil_id'] = $incidentData[0]['inc_tahshil_id'];
                $epcr['city_id'] = $incidentData[0]['inc_city_id'];
                $epcr['locality'] = $incidentData[0]['inc_address'];
                $epcr['inc_datetime'] = $incidentData[0]['inc_datetime'];
                $epcr['emt_name'] = $emt_name;
                $epcr['emso_id'] = $emso_id;
                $epcr['pilot_name'] = $pilot_name;
                $epcr['pilot_id'] = $pilot_id;
                $epcr['base_month'] = $incidentData[0]['inc_base_month'];
                $epcr['provider_impressions'] = "45";
                $epcr['other_provider_img'] = $patientAvaOrNot['patient_ava_or_not_reason'] == "" ? $patientAvaOrNot['patient_ava_or_not_other_reason'] : $patientAvaOrNot['patient_ava_or_not_reason'] ;
                $epcr['added_date'] = date('Y-m-d H:i:s');
                $epcr['ercp_advice'] = 'no';
                $epcr['ercp_advice_Taken'] = '0';
               $epcrData = $this->user->insertPatientData($epcr);
            }
            if(empty($checkIncidentIdClose)){
                if($data1 == 1){
                    $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => 'Updated'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Incident Id Not Exist'
                        ])
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
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function editpatientavailable_post(){
        if((isset($_COOKIE['cookie']))){
            $incidentId = $this->post('incidentId');
            $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
			
            $data = $this->user->getpatientAvaOrNot($incidentId);
		
            if(empty($checkIncidentIdClose)){
                if($data != 2){
                    $this->response([
                        'data' => ([
                            'patientAvaOrNot' => [
                                'patientAvaOrNot' => $data[0]['patient_ava_or_not'],
                                'id' => (int) $data[0]['id'],
                                'name' => $data[0]['name'],
                            ],
                            'other' => $data[0]['patient_ava_or_not_other_reason'],
                            'remark' => $data[0]['patient_ava_or_not_remark']
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Incident Id Not Exist'
                        ])
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
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }  
    }
}