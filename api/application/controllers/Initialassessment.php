<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Initialassessment extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $patientId = $this->post('patientId');
            $data['ini_airway'] = $this->post('iniAirway');
            $data['ini_breathing'] = $this->post('iniBreathing');
            $data['ini_breathing_txt'] = $this->post('iniBreathingTxt');
            $data['ini_oxy_sat_get_nf'] = $this->post('iniOxySatGetNf');
            $data['ini_oxy_sat_get_nf_txt'] = $this->post('iniOxySatGetNfTxt');
            $data['ini_cir_pulse_p'] = $this->post('iniCirPulsePresent');
            $data['ini_cir_pulse_p_txt'] = $this->post('iniCirPulsePresentTxt');
            $data['ini_cir_cap_refill_tsec'] = $this->post('iniCirCapRefillTsec');
            $data['ini_bp_sysbp_txt'] = $this->post('iniBpSysbpTxt');
            $data['ini_bp_dysbp_txt'] = $this->post('iniBpDysbpTxt');
            $ini_con_gcs = $this->post('iniConGcs');
            $data['ini_con_gcs'] = isset($ini_con_gcs) ? $ini_con_gcs : '';
            $data['ini_con_bsl'] = $this->post('iniConBsl');
            $iniConPupilsLeft = $this->post('iniConPupilsLeft');
            $iniConPupilsRight = $this->post('iniConPupilsRight');
            $data['ini_con_pupils'] = isset($iniConPupilsLeft) ? $iniConPupilsLeft : '';
            $data['ini_con_pupils_right'] = isset($iniConPupilsRight) ? $iniConPupilsRight : '';
            $data['initial_complete'] = '1';
            $data['loc'] = $this->post('loc');
	        $data['ini_con_circulation_radial'] = $this->post('iniCirRadial');
            $data['ini_con_circulation_carotid'] = $this->post('iniCirCarotid');
            $data['ini_con_circulation_brachial'] = $this->post('iniCirBrachial');
	        $data['ini_con_rr'] = $this->post('iniRR');
            $ercp_advice = $this->post('iniMedAdGiven');
            if($ercp_advice == 'yes'){
                $data['ercp_advice'] = 'advice_Yes';
                $data['ercp_advice_Taken'] = $this->post('iniAdGivenBy');
            }else if($ercp_advice == 'no'){
                $data['ercp_advice_Taken'] = '';
                $data['ercp_advice'] = 'advice_No';
            }
            $data['ini_con_injury']= json_encode($this->post('iniInjury'));
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
                if(!empty($patientId) && (!empty($data['ini_cir_pulse_p'])) ){
                // if(!empty($patientId) && (!empty($data['ini_airway'])) && (!empty($data['ini_breathing'])) && (!empty($data['ini_oxy_sat_get_nf'])) 
                // &&(!empty($data['ini_cir_pulse_p'])) && (!empty($data['ini_cir_cap_refill_tsec'])) ){
                    $initialdata = $this->user->addPatientInitialAssessment($patientId,$data);
            //print_r($initialdata);
                    // $iniInjMatrixArray  = array();
                    // if(isset($initialdata)){
                    //     foreach($iniInjMatrix  as $iniInjMatrix1){
                            // $injury['incidentId'] = $initialdata[0]->inc_ref_id;
                            // $injury['as_item_id'] = $iniInjMatrix1['id'];
                            // $injury['as_item_type'] = "INJ";
                            // $injury['as_stk_in_out'] = "out";
                            // $injury['as_item_qty'] = 1;
                            // $injury['as_sub_id'] = $initialdata[0]->id;
                            // $injury['as_sub_type'] = "pcr";
                            // $injury['amb_rto_register_no'] = $initialdata[0]->amb_reg_id;
                            // $injury['as_date'] = date('Y-m-d H:i:s');
                            // $injury['as_base_month'] = $initialdata[0]->base_month;
                            // array_push($iniInjMatrixArray,$injury);
                    //     }
                    // }
                    // $this->user->insertInjury($iniInjMatrixArray);
                    if(isset($initialdata)){
                        $this->response([
                            'data' => ([
                                'code' => 1,
                                'message' => 'Sucessfully Inserted'
                            ]),
                            'error' => null
                        ],REST_Controller::HTTP_OK);
                    }else{
                        $this->response([
                            'data' => null,
                            'error' => ([
                                'code' => 1,
                                'message' => 'Not Inserted'
                            ])
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