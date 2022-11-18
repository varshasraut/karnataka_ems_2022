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
            $data['initial_complete'] = '1';
            $data['loc'] = $this->post('loc');
            if(!empty($patientId) && (!empty($data['ini_airway'])) && (!empty($data['ini_breathing'])) && (!empty($data['ini_oxy_sat_get_nf'])) 
            &&(!empty($data['ini_cir_pulse_p'])) && (!empty($data['ini_cir_cap_refill_tsec'])) ){
                $initialdata = $this->user->addPatientInitialAssessment($patientId,$data);
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
            }else{
                $this->response([
                    'data' => ([]),
                    'error' => null
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