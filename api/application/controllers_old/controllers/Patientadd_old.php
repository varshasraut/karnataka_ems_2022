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
            $fullName = $this->post('patientFName').' '.$this->post('patientMName').' '.$this->post('patientLName');
            $age = $this->post('age');
            $gender = $this->post('gender');
            $bgroup = $this->post('bgroup');
            if($patientId == null) {
                $id = $this->encryption->decrypt($_COOKIE['cookie']);
                $logindata = $this->user->getUserLogin($id,$type);
                $result = $this->db->query("SELECT p_id FROM ems_patient ORDER BY p_id DESC LIMIT 1")->result();
                $last_pat_id = $result[0]->p_id + 1;
                $incidentData = $this->user->getIncidentData($incidentID);
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
                    'ptn_age' => $age,
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
                    'ptn_area' => $incidentData[0]['inc_area']
                    );
                    $loc = $this->post('loc');
                    $ptn_com_with_hosp = $this->post('PtnComWithHosp');
                    $PatientId = $this->user->addPatient($data);
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
                    $incPat['ptn_id'] = $PatientId;
                    $incPat['id'] = $primary_key;
                    $lastIncPtnId = $this->user->insertIncidencePatient($incPat);
                    $patientInfo = $this->user->getPatientInfo($PatientId);
                    $epcr['id'] = $primary_key;
                    $epcr['pat_com_to_hosp'] = $this->post('ptnComToHosp');
                    $epcr['pat_com_to_hosp_reason'] = $this->post('ptnComToHospReason');
                    $epcr['loc'] = $this->post('loc');
                    $epcr['date'] = date('m/d/y');
                    $epcr['time'] = date('H:i:s');
                    $epcr['inc_ref_id'] = $this->post('incidentId');
                    $epcr['ptn_id'] = $patientInfo[0]['p_id'];
                    $epcr['state_id'] = $patientInfo[0]['ptn_state'];
                    $epcr['district_id'] = $patientInfo[0]['ptn_district'];
                    $epcr['tahsil_id'] = $patientInfo[0]['ptn_tahsil'];
                    $epcr['city_id'] = $patientInfo[0]['ptn_city'];
                    $epcr['locality'] = $patientInfo[0]['ptn_address'];
                    $epcr['inc_datetime'] = $incidentData[0]['inc_datetime'];
                    foreach($logindata as $logindata1){
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
            }else{
                $data = array(
                    'ptn_fname' => $patientFName,
                    'ptn_mname' => $patientMName,
                    'ptn_lname' => $patientLName,
                    'ptn_fullname' => $fullName,
                    'ptn_gender' => $gender,
                    'ptn_age' => $age, 
                    'ptn_bgroup' => $bgroup
                );
                $editPtn = $this->user->editPatient($data,$patientId);
                $patientData = array(
                    'loc' => $this->post('loc'),
                    'pat_com_to_hosp' => $this->post('ptnComToHosp'),
                    'pat_com_to_hosp_reason' => $this->post('ptnComToHospReason')
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
            } 
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}