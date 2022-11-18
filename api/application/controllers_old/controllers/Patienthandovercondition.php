<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Patienthandovercondition extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->model('CommonModel');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $patientId = $this->post('patientId');
            $incidentId = $this->post('incidentId');
            $data['hc_airway'] = $this->post('hcAirway');
            $data['hc_breathing'] = $this->post('hcBreathing');
            $data['hc_breathing_txt'] = $this->post('hcBreathingTxt');
            $data['hc_oxy_sat_get_nf'] = $this->post('hcOxySatGetNf');
            $data['hc_oxy_sat_get_nf_txt'] = $this->post('hcOxySatGetNfTxt');
            $data['hc_cir_pulse_p'] = $this->post('hcCirPulsePresent');
            $data['hc_cir_pulse_p_txt'] = $this->post('hcCirPulsePresentTxt');
            $data['hc_cir_cap_refill_great_t'] = $this->post('hcCirCapRefillGreatT');
            $data['hc_bp_sysbp_txt'] = $this->post('hcBpSysbpTxt');
            $data['hc_bp_dibp_txt'] = $this->post('hcBpDibpTxt');
            $data['hc_pi_txt'] = $this->post('hcPiTxt');
            $data['provider_impressions'] = $this->post('hcPiTxt');
            $data['hc_ps'] = $this->post('hcPs');
            $data['handover_cond_complete'] = '1';
            $data['hc_loc'] = $this->post('loc');
            $hcConGcs = $this->post('hcConGcs');
            $data['hc_con_gcs'] = isset($hcConGcs) ? $hcConGcs : '';
            $data['hc_con__bsl'] = $this->post('hcConBsl');
            $hcConPupilsLeft = $this->post('hcConPupilsLeft');
            $hcConPupilsRight = $this->post('hcConPupilsRight');
            $data['hc_con_pupils'] = isset($hcConPupilsLeft) ? $hcConPupilsLeft : '';
            $data['hc_con_pupils_right'] =isset($hcConPupilsRight) ? $hcConPupilsRight : '';
            $obvioudDeathQuesAns = $this->post('obvioudDeathQuesAns');
            $patientCaseType = $this->post('patientCaseType');
            $data['provider_impressions'] = $this->post('hcPiTxt');
            $data['provider_casetype'] = $patientCaseType;
            $basemonth = $this->CommonModel->baseMonth();
            $sum_epcr_id = $this->user->getEpcrPkId($patientId,$incidentId);
            if(!empty($obvioudDeathQuesAns)){
                foreach($obvioudDeathQuesAns as $obvioudDeathQuesAns1){ 
                    $data1['patientId'] = $patientId;
                    $data1['incidentId'] = $incidentId;
                    $obviousQueAns['sum_que_id'] = $obvioudDeathQuesAns1['id'];
                    $obviousQueAns['sum_que_ans'] = $obvioudDeathQuesAns1['queAns'];
                    $obviousQueAns['sum_epcr_id'] = $sum_epcr_id[0]['pk_id'];
                    $obviousQueAns['inc_ref_id'] = $incidentId;
                    $obviousQueAns['ptn_id'] = $patientId;
                    $obviousQueAns['sum_base_month'] = $basemonth[0]['months'];
                    $this->user->insertObviousQueAns($obviousQueAns,$data1);
                }
            }
            // if(!empty($patientId) && (!empty($data['hc_airway'])) && (!empty($data['hc_breathing'])) && (!empty($data['hc_oxy_sat_get_nf'])) 
            // && (!empty($data['hc_cir_pulse_p'])) && (!empty($data['hc_cir_cap_refill_great_t'])) && (!empty($data['hc_pi_txt']))
            // && (!empty($data['hc_ps'])) ){
                $initialdata = $this->user->addPatientHandoverCondition($patientId,$data);
                if($initialdata ==1){
                    $this->response([
                        'data' => ([
                            'code' => 1,
                            'message' => 'Sucessfully Inserted'
                        ]),
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->reponse([
                        'data' => null,
                        'error' => ([
                            'code' => 1,
                            'message' => 'Not Inserted'
                        ])
                    ],REST_Controller::HTTP_OK);
                }
            // }else{
            //     $this->response([
            //         'data' => ([]),
            //         'error' => null
            //     ],REST_Controller::HTTP_OK);
            // }
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}