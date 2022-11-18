<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Assignincidentcallsdeatils extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->model('CommonModel');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        // if(isset($_COOKIE['cookie'])){
            // $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
            $deviceId = 2;
            $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
            $incidentId = $this->post('incidentId');
            $patientavailable = $this->user->chkPtnAva($incidentId);
            $data1 = $this->user->incidentCallsDetails($incidentId);
            // $basemonth = $this->CommonModel->baseMonth();
            $checkPtnComToTheHosp = $this->user->checkPtnComToTheHosp($incidentId);
            // print_r($checkPtnComToTheHosp);
            $a = array();
            $b = array();
            foreach($checkPtnComToTheHosp as $checkPtnComToTheHosp1){
                if($checkPtnComToTheHosp1['pat_com_to_hosp'] == '0'){
                    array_push($a,$checkPtnComToTheHosp1['pat_com_to_hosp']);
                    break;
                }
                if($checkPtnComToTheHosp1['pat_com_to_hosp'] == '1'){
                    array_push($b,$checkPtnComToTheHosp1['pat_com_to_hosp']);
                    
                }
            }
            if(!empty($a)){
                $ptnComeTohosp = 0;
            }else if(empty($a) && !empty($b)){
                $ptnComeTohosp = 1;
            }else{
                $ptnComeTohosp = -1;
            }
            // $data = $this->user->checkAllInfo($incidentId);
            // $completionChk = array();
            // foreach($data as $data1){
            //     while((($data1[0]['pat_com_to_hosp'] == '0') || ($data1[0]['pat_com_to_hosp'] == '')) && (($data1[0]['initial_complete'] == '0' || $data1[0]['initial_complete'] == null) || ($data1[0]['ongoing_complete'] == '0' || $data1[0]['ongoing_complete'] == null) || ($data1[0]['handover_cond_complete'] == '0' || $data1[0]['handover_cond_complete'] == null) || ($data1[0]['handover_issue_complete'] == '0' || $data1[0]['handover_issue_complete'] == null) ) )
            //     {
            //         $a = '1'; //'Not Complete :- 1'
            //         array_push($completionChk,$a);
            //         break;
            //     }
            // }
	    $checkAllInfo = $this->user->checkAllInfo($incidentId);
            $completionChk = array();
            foreach($checkAllInfo as $checkAllInfo1){
                 //print_r($checkAllInfo1[0]['pat_com_to_hosp']);
                while((($checkAllInfo1[0]['pat_com_to_hosp'] == '0') || ($checkAllInfo1[0]['pat_com_to_hosp'] == '')) && (($checkAllInfo1[0]['initial_complete'] == '0' || $checkAllInfo1[0]['initial_complete'] == NULL) || ($checkAllInfo1[0]['ongoing_complete'] == '0' || $checkAllInfo1[0]['ongoing_complete'] == NULL) || ($checkAllInfo1[0]['handover_cond_complete'] == '0' || $checkAllInfo1[0]['handover_cond_complete'] == NULL) || ($checkAllInfo1[0]['handover_issue_complete'] == '0' || $checkAllInfo1[0]['handover_issue_complete'] == null) ) )
                {
                    // ((($data1[0]['pat_com_to_hosp'] == '0') || ($data1[0]['pat_com_to_hosp'] == '')) && (($data1[0]['initial_complete'] == '0' || $data1[0]['initial_complete'] == null) || ($data1[0]['ongoing_complete'] == '0' || $data1[0]['ongoing_complete'] == null) || ($data1[0]['handover_cond_complete'] == '0' || $data1[0]['handover_cond_complete'] == null) || ($data1[0]['handover_issue_complete'] == '0' || $data1[0]['handover_issue_complete'] == null) || ($data1[0]['medicine_complete'] == '0' || $data1[0]['medicine_complete'] == null) || ($data1[0]['consumable_complete'] == '0' || $data1[0]['consumable_complete'] == null)) )
                    $a = '1'; //'Not Complete :- 1'
                    array_push($completionChk,$a);
                    break;
                }
            }
            if(!empty($data1)){
                    $para = $this->user->getDriverParameter($data1[0]['incidentId']);
                    if(empty($para)){
                        $paraCount = 0;
                        $msg = "Not Started";
                        $outOfSych = 'true';
                    }else if($para[0]['parameter_count'] == 2){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already Start to base";
                        $outOfSych = 'false';
                    }else if($para[0]['parameter_count'] == 3){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already At Scene";
                        $outOfSych = 'false';
                    }else if($para[0]['parameter_count'] == 4){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already From Scene";
                        $outOfSych = 'false';
                    }else if($para[0]['parameter_count'] == 5){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already At hospital";
                        $outOfSych = 'false';
                    }else if($para[0]['parameter_count'] == 6){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already Patient handover";
                        $outOfSych = 'false';
                    }else if($para[0]['parameter_count'] == 7){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already back to base";
                        $outOfSych = 'false';
                    }
                $this->response([
                    'data' => ([
                        'callerName' => $data1[0]['callerName'],
                        'callerMob' => $data1[0]['callerMob'],
                        'incidentId' => $data1[0]['incidentId'],
                        'incidentDate' => $data1[0]['incidentDate']." ".$data1[0]['incidentTime'],
                        'incidentTime' => $data1[0]['incidentDate']." ".$data1[0]['incidentTime'],
                        'incidentPatientCount' => $data1[0]['incidentPatientCount'],
                        'cheifComplaint' => (isset($data1[0]['cheifComplaint'])) ? $data1[0]['cheifComplaint'] : "",
                        'incidentStatus' => $data1[0]['incidentStatus'],
                        'incidentAddress' => $data1[0]['incidentAddress'],
                        'lat' => (float) $data1[0]['lat'],
                        'long' => (float) $data1[0]['long'],
                        'incidentPincode' => $data1[0]['incidentPincode'],
                        'callerRelationName' => $data1[0]['CallerRelationName'],
                        'services' => $data1[0]['Services'],
                        'hospitalFlag' => $data1[0]['hospitalFlag'],
                        'hospitalName' => $data1[0]['hospitalName'],
                        'hospitalAddress' => $data1[0]['hospitalAddress'],
                        'hospitalLat' => (float) $data1[0]['hospitalLat'],
                        'hospitalLong' => (float) $data1[0]['hospitalLong'],
                        'currentStatus' => array(
                            'code' => (int) $paraCount,
                            'outOfSych' => $outOfSych,
                            'message' => $msg
                        ),
                        'isAnyPatientComing' =>  $ptnComeTohosp,
                        'isAnyPatientAvailable' => $data1[0]['isAnyPatientAvailable'],
                        'allPatientDetailsSubmitted' => (!empty($completionChk)) ? 'false' : 'true',
                        'onsceneCare' => (isset($data1[0]['onsceneCare'])) ? (int) $data1[0]['onsceneCare'] : null
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => ([
                        'callerName' => "",
                        'callerMob' => null,
                        'incidentId' => "",
                        'incidentDate' => null,
                        'incidentTime' => null,
                        'incidentPatientCount' => "",
                        'cheifComplaint' => "",
                        'incidentStatus' => "",
                        'incidentAddress' => "",
                        'lat' => null,
                        'long' => null,
                        'incidentPincode' => "",
                        'callerRelationName' => "",
                        'services' => "",
                        'hospitalFlag' => "",
                        'hospitalName' => "",
                        'hospitalAddress' => "",
                        'hospitalLat' => null,
                        'hospitalLong' => null,
                        'currentStatus' => ([
                            'code' => (int) "",
                            'outOfSych' => "",
                            'message' => ""
                        ]),
                        'isAnyPatientComing' =>  null,
                        'isAnyPatientAvailable' => null,
                        'onsceneCare' => null
                    ]),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }
        // }else{
        //     $this->response([
        //         'data' => ([]),
        //         'error' => null
        //     ],REST_Controller::HTTP_UNAUTHORIZED);
        // }
    }
}