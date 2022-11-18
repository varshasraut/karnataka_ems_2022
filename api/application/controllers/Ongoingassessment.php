<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Ongoingassessment extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $patientId = $this->post('patientId');
            $data['ong_intervention'] = json_encode($this->post('ongIntervention'));
            $data['	other_ong_intervention'] = $this->post('otherOngIntervention');
            $data['ong_suction'] = $this->post('ongSuction');
            $data['ong_pos_airway'] = $this->post('ongPosAirway');
            $data['ong_supp_oxy_thp'] = $this->post('ongSuppOxyThp');
            $data['ong_supp_oxy_thp_txt'] = $this->post('ongSuppOxyThpTxt');
            $data['ong_ven_supp_bvm'] = $this->post('ongVenSuppBvm');
            $data['ong_stretcher'] = $this->post('ongStretcher');
            $data['ong_wheelchair'] = $this->post('ongWheelchair');
            $data['ong_spine_board'] = $this->post('ongSpineBoard');
            $data['ong_scoop_stretcher'] = $this->post('ongScoopStretcher');
            $data['ong_medication'] = $this->post('ongMedication');
            $data['ong_medication_txt'] = $this->post('ongMedicationTxt');
            $data['ongoing_complete'] = '1';
            if($this->post('ongPastMedHist') == []){
                $data['ong_past_med_hist'] = null;
            }else{
                $data['ong_past_med_hist'] = json_encode($this->post('ongPastMedHist'));
            }
            $data['other_ong_past_med_hist'] = $this->post('otherOngPastMedHist');
            $data['ong_ph_sign_symptoms'] = $this->post('ongPhSignSymptoms');
            $data['ong_other_ph_sign_symptoms'] = $this->post('ongOtherPhSignSymptoms');
            $data['ong_ph_allergy'] = $this->post('ongPhAllergy');
            $data['ong_ph_event_led_inc'] = $this->post('ongPhEventLedInc');
            $data['ong_ph_last_oral_intake'] = $this->post('ongPhLastOralIntake');
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
                if(!empty($patientId) && (!empty($data['ong_intervention'])) &&(!empty($data['ong_suction'])) 
                && (!empty($data['ong_pos_airway'])) && (!empty($data['ong_supp_oxy_thp'])) && (!empty($data['ong_ven_supp_bvm']))
                && (!empty($data['ong_stretcher'])) && (!empty($data['ong_wheelchair'])) && (!empty($data['ong_spine_board'])) && (!empty($data['ong_scoop_stretcher']))
                && (!empty($data['ong_medication'])) || (!empty($data['ong_past_med_hist'])) || (!empty($data['ong_past_med_hist'])==null) ){
                    $ongoingdata = $this->user->addPatientOngoingAssessment($patientId,$data);
                    if($ongoingdata ==1){
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
                                'code' =>1,
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