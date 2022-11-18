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
        if(isset($_COOKIE['cookie'])){
            $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
            // $deviceId = 2;
            $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
            $incidentId = $this->post('incidentId');
            $patientavailable = $this->user->chkPtnAva($incidentId);
            $data1 = $this->user->incidentCallsDetails($incidentId);
            $vehicle = $this->post('vehicleNumber');
            $veh = explode(' ',$vehicle);
            $ambulanceno = implode('-',$veh);
            if(!empty($ambulanceno)){
                $odo  = $this->user->getendodometer($ambulanceno);
                $odometer = $odo['endOdometer'];
            }
            // $basemonth = $this->CommonModel->baseMonth();
		  $inctype=$patientavailable[0]['inc_type'];
		  
		  if($inctype != 'on_scene_care')
		  {
			
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
                $ptnComeTohosp = 0; //ptn come to hosp
            }else if(empty($a) && !empty($b)){
                $ptnComeTohosp = 1; //ptn not come to hosp
            }else{
                $ptnComeTohosp = -1; //not selected
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
				//$str = $this->db->last_query();
		// print_r($checkAllInfo);

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
			}
		else{
			$ptnComeTohosp = -1;
		}
        // echo $ptnComeTohosp;die;
            if($data1[0]['isAnyPatientAvailable'] == 0){
                $isAnyPatientAvailable1 = 0;
            }else if($data1[0]['isAnyPatientAvailable'] == 1){
                $isAnyPatientAvailable1 = 1;
            }else{
                $isAnyPatientAvailable1 = -1;
            }
            if(!empty($data1)){
                    $para = $this->user->getDriverParameter($data1[0]['incidentId']);
                    // print_r($para);
                    if(empty($para)){
                        $paraCount = 0;
                        $msg = "Not Started";
                        $outOfSych = 'true';
                        $odometer = isset($odometer) ? $odometer : Null;
                    }else if($para[0]['parameter_count'] == 2){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already Acknowledgement";
                        $outOfSych = 'false';
                        $odometer = (int) $para[0]['acknowledge_km'];
                    }else if($para[0]['parameter_count'] == 3){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already Start to base";
                        $outOfSych = 'false';
                        $odometer = (int) $para[0]['start_from_base_loc_km'];
                    }else if($para[0]['parameter_count'] == 4){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already At Scene"; //4 is from scene
                        $outOfSych = 'false';
                        $odometer = (int) $para[0]['at_scene_km'];
                    }else if($para[0]['parameter_count'] == 5){
                        if(($isAnyPatientAvailable1 == 1 && $ptnComeTohosp == -1) || ($isAnyPatientAvailable1 == 0 && $ptnComeTohosp == 1)){
                            $paraCount = 7; //Back to base Loc
                            $outOfSych = 'false';
                            $msg = "Already From Scene";
                            $odometer = (int) $para[0]['from_scene_km'];
                        }else{
                            $paraCount = $para[0]['parameter_count'];
                            $msg = "Already From Scene";
                            $outOfSych = 'false';
                            $odometer = (int) $para[0]['from_scene_km'];
                        }
                    }else if($para[0]['parameter_count'] == 6){
                        if(($isAnyPatientAvailable1 == 1 && $ptnComeTohosp == -1) || ($isAnyPatientAvailable1 == 0 && $ptnComeTohosp == 1)){
                            $paraCount = 7; //Back to base Loc
                            $outOfSych = 'false';
                            $msg = "Already At hospital";
                            $odometer = (int) $para[0]['from_scene_km'];
                        }else{
                            $paraCount = $para[0]['parameter_count'];
                            $msg = "Already At hospital";
                            $outOfSych = 'false';
                            $odometer = (int) $para[0]['at_hospital_km'];
                        }
                    }else if($para[0]['parameter_count'] == 7){
                        if(($isAnyPatientAvailable1 == 1 && $ptnComeTohosp == -1) || ($isAnyPatientAvailable1 == 0 && $ptnComeTohosp == 1)){
                            $paraCount = 7; //Back to base Loc
                            $outOfSych = 'false';
                            $msg = "Already Patient handover";
                            $odometer = (int) $para[0]['from_scene_km'];
                        }else{
                            $paraCount = $para[0]['parameter_count'];
                            $msg = "Already Patient handover";
                            $outOfSych = 'false';
                            $odometer = (int) $para[0]['patient_handover_km'];
                        }
                    }else if($para[0]['parameter_count'] == 8){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already back to base";
                        $outOfSych = 'false';
                        $odometer = (int) $para[0]['back_to_base_loc_km'];
                    }
                    else if($para[0]['parameter_count'] == 9){
                        $paraCount = $para[0]['parameter_count'];
                        $msg = "Already Abandoned";
                        $outOfSych = 'false';
                        $odometer = (int) '';
                    }
                    //Handle for disable Btn
                    if(!empty($para)){
                        if($para[0]['parameter_count']>=5){
                            if($data1[0]['isAnyPatientAvailable'] == -1){
                                $ptnAvaOrNot['patient_ava_or_not'] = 'yes';
                                $this->user->updatePtnAvaOrNot($ptnAvaOrNot,$incidentId);
                                $isAnyPatientAvailable = 0;
                            }else if($data1[0]['isAnyPatientAvailable'] == 0){
				                $isAnyPatientAvailable = 0;
                            }else if($data1[0]['isAnyPatientAvailable'] == 1){
				                $isAnyPatientAvailable = 1;
                            }else{
                                $isAnyPatientAvailable = -1;
                            }
                        }else if($data1[0]['isAnyPatientAvailable'] == 0){
                            $isAnyPatientAvailable = 0;
                        }else if($data1[0]['isAnyPatientAvailable'] == 1){
                            $isAnyPatientAvailable = 1;
                        }else{
                            $isAnyPatientAvailable = -1;
                        }

                        //Handle for crash app
                        if($para[0]['at_hospital'] != '' || $para[0]['patient_handover'] != ''){
                            $paraAtHosp = true;
                            $paraPtnHandover = true;
                        }else{
                            $paraAtHosp = false;
                            $paraPtnHandover = false;
                        }
                        //End handle for crash app
                    }else{
                        $isAnyPatientAvailable = -1;

                        //Handle for crash app
                        $paraAtHosp = false;
                        $paraPtnHandover = false;
                        //End handle for crash app
                    }
                //End handle for disable btn
                    // print_r($data1);
                    if(isset($data1[0]['pr_total_amount'])){
                        $inc = $data1[0]['incidentId'].' Amt('.$data1[0]['pr_total_amount'].')';
                    }else{
                        $inc =$data1[0]['incidentId'];
                    }
                if($data1[0]['pcode'] == 'DROP_BACK'){
                    $incCallType = (int) '2';
                    $dropbackaddress = $data1[0]['dropBackHomeAddress'];
                }else{
                    $incCallType = (int) '1';
                }
                $this->response([
                    'data' => ([
                        'callerName' => $data1[0]['callerName'],
                        'callerMob' => $data1[0]['callerMob'],
                        'incCallType' => $incCallType,
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
                            'message' => $msg,
                            'odometer' => $odometer
                        ),
                        'isAnyPatientComing' =>  $ptnComeTohosp,
                        'isAnyPatientAvailable' => (isset($isAnyPatientAvailable)) ? $isAnyPatientAvailable : -1, //$data1[0]['isAnyPatientAvailable']
                        'allPatientDetailsSubmitted' => (!empty($completionChk)) ? 'false' : 'true',
                        'onsceneCare' => (isset($data1[0]['onsceneCare'])) ? (int) $data1[0]['onsceneCare'] : null,
                        'pcrformupload' => $data1[0]['pcrformupload'],
                        'dropBackAddress' => isset($dropbackaddress) ? $dropbackaddress : "",
                        'dropBackLat' => isset($dropBackLat) ? (float) $dropBackLat : null,
                        'dropBackLong' => isset($dropBackLong) ? (float) $dropBackLong : null,
                        'pcfRequired' => true,
                        'patientComClk' => true,
                        'patientNotComClk' => true,
                        'paraAtHosp' => $paraAtHosp,
                        'paraPtnHandover' => $paraPtnHandover
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
                        'onsceneCare' => null,
                        'pcrformupload' => null,
                        'dropBackHomeAddress' => null,
                        'pcfRequired' => null,
                        'patientComClk' => null,
                        'patientNotComClk' => null,
                        'paraAtHosp' => null,
                        'paraPtnHandover' => null
                    ]),
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