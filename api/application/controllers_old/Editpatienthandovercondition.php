<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Editpatienthandovercondition extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $patientId = $this->post('patientId');
            if(!empty($patientId)){
                $hanover = $this->user->EditPatientHandoverCondition($patientId);
                // if(!empty($hanover)){
                //     $hcedit = array(
                //         'id' => $hanover[0]['ptn_id'],
                //         'iniAirway' => $hanover[0]['hc_airway'],
                //         'iniBreathing' => $hanover[0]['hc_breathing'],
                //         'iniBreathingTxt' => $hanover[0]['hc_breathing_txt'],
                //         'iniOxySatGetNf' => $hanover[0]['hc_oxy_sat_get_nf'],
                //         'iniOxySatGetNfTxt' => $hanover[0]['hc_oxy_sat_get_nf_txt'],
                //         'iniCirPulsePresent' => $hanover[0]['hc_cir_pulse_p'],
                //         'iniCirPulsePresentTxt' => $hanover[0]['hc_cir_pulse_p_txt'],
                //         'iniCirCapRefillTsec' => $hanover[0]['hc_cir_cap_refill_great_t'],
                //         'iniBpSysbpTxt' => $hanover[0]['hc_bp_sysbp_txt'],
                //         'iniBpDysbpTxt' => $hanover[0]['hc_bp_dibp_txt']
                //     );
                //     $providerImpression = array(
                //         'id' => $hanover[0]['pro_id'],
                //         'name' => $hanover[0]['pro_name']
                //     );
                //     $status = array(
                //         'id' => $hanover[0]['id'],
                //         'name' => $hanover[0]['name']
                //     );
                // }
                if(!empty($hanover)){
                    $this->response([
                        'data' => ([
                            'id' => (int) $hanover[0]['ptn_id'],
                            'loc' => ([
                                'id' => (int) ($hanover[0]['hc_loc'] == '') ? $hanover[0]['level_id'] : $hanover[0]['level_id'],
                                'name' => ($hanover[0]['hc_loc'] == '') ? $hanover[0]['level_type'] : $hanover[0]['level_type']
                                
                            ]),
                            'iniAirway' => ($hanover[0]['hc_airway'] == '') ? $hanover[0]['ini_airway'] : $hanover[0]['hc_airway'],
                            'iniBreathing' => ($hanover[0]['hc_breathing'] == '') ? $hanover[0]['ini_breathing'] : $hanover[0]['hc_breathing'],
                            'iniBreathingTxt' => ($hanover[0]['hc_breathing_txt'] == '') ? $hanover[0]['ini_breathing_txt'] : $hanover[0]['hc_breathing_txt'],
                            'iniOxySatGetNf' => ($hanover[0]['hc_oxy_sat_get_nf'] == '') ? $hanover[0]['ini_oxy_sat_get_nf'] : $hanover[0]['hc_oxy_sat_get_nf'],
                            'iniOxySatGetNfTxt' => ($hanover[0]['hc_oxy_sat_get_nf_txt'] == '') ? $hanover[0]['ini_oxy_sat_get_nf_txt'] : $hanover[0]['hc_oxy_sat_get_nf_txt'],
                            'iniCirPulsePresent' => ($hanover[0]['hc_cir_pulse_p'] == '') ? $hanover[0]['ini_cir_pulse_p'] : $hanover[0]['hc_cir_pulse_p'],
                            'iniCirPulsePresentTxt' => ($hanover[0]['hc_cir_pulse_p_txt'] == '') ? $hanover[0]['ini_cir_pulse_p_txt'] : $hanover[0]['hc_cir_pulse_p_txt'],
                            'iniCirCapRefillTsec' => ($hanover[0]['hc_cir_cap_refill_great_t'] == '') ? $hanover[0]['ini_cir_cap_refill_tsec'] : $hanover[0]['hc_cir_cap_refill_great_t'],
                            'iniBpSysbpTxt' => ($hanover[0]['hc_bp_sysbp_txt'] == '') ? $hanover[0]['ini_bp_sysbp_txt'] : $hanover[0]['hc_bp_sysbp_txt'],
                            'iniBpDysbpTxt' => ($hanover[0]['hc_bp_dibp_txt'] == '') ? $hanover[0]['ini_bp_dysbp_txt'] : $hanover[0]['hc_bp_dibp_txt'],
                            'providerImpression' => ([
                            'id' => (int)  $hanover[0]['pro_id'],
                            'name' => $hanover[0]['pro_name']
                            ]),
                            'status' => ([
                            'id' => (int) $hanover[0]['id'],
                            'name' => $hanover[0]['name']
                            ]),
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
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}