<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Listassignincidentcalls extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if(isset($_COOKIE['cookie'])){
            $deviceId = $this->encryption->decrypt($_COOKIE['deviceId']);
            $deviceIdLogin = $this->user->checkDeviceLogin($deviceId);
            // print_r($deviceIdLogin);
            $type = $this->post('type');
            $id = $this->encryption->decrypt($_COOKIE['cookie']);
            $logindata = $this->user->getId($id,$type);
            // print_r($logindata);
            if($logindata == 1 || (empty($deviceIdLogin))){
                $this->response([
                    'data' => ([]),
                    'error' => null
                ],REST_Controller::HTTP_UNAUTHORIZED);
            }else{
                $ambno = $logindata['vehicle_no'];
                $data = $this->user->assignedIncidenceCalls($ambno);
                $a = array();
                if(!empty($data)){
                    foreach($data as $data1) {
                        // print_r($data1);
                        // $currentStatus = $this->user->getCurrentstatus($data1['incidentId']);
                        // if(empty($currentStatus)){
                        //     $driverCurrentStatus = 0;
                        // }else{
                        //     $driverCurrentStatus = $currentStatus[0]['parameter_count'];
                        // }
                        // $this->session->set_userdata('incidentId',$data[0]['incidentId']);
                        $para = $this->user->getDriverParameter($data1['incidentId']);
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
                        $b = array(
                            'callerName' => $data1['callerName'],
                            'callerMob' => $data1['callerMob'],
                            'incidentId' => $data1['incidentId'],
                            'incidentDate' => $data1['incidentDate']." ".$data1['incidentTime'],
                            'incidentTime' => $data1['incidentDate']." ".$data1['incidentTime'],
                            'incidentPatientCount' => $data1['incidentPatientCount'],
                            'cheifComplaint' => (isset($data1['cheifComplaint'])) ? $data1['cheifComplaint'] : "",
                            'incidentStatus' => $data1['incidentStatus'],
                            'incidentAddress' => $data1['incidentAddress'],
                            'lat' => (float) $data1['lat'],
                            'long' => (float) $data1['long'],
                            'incidentPincode' => $data1['incidentPincode'],
                            'callerRelationName' => $data1['CallerRelationName'],
                            'services' => $data1['Services'],
                            'hospitalFlag' => $data1['hospitalFlag'],
                            'hospitalName' => $data1['hospitalName'],
                            'hospitalAddress' => $data1['hospitalAddress'],
                            'hospitalLat' => (float) $data1['hospitalLat'],
                            'hospitalLong' => (float) $data1['hospitalLong'],
                            'currentStatus' => array(
                                'code' => (int) $paraCount,
                                'outOfSych' => $outOfSych,
                                'message' => $msg
                            ),
                            'incidentCallsStatus' => $data1['incidentCallsStatus'],
                            'clikable' => $data1['clikable'],
                            'progress' => $data1['progress'],
                            'completed' => $data1['completed'],
                            'onsceneCare' => (isset($data1['onsceneCare'])) ? (int) $data1['onsceneCare'] : null
                        );
                        array_push($a,$b);
                        // $this->response([
                        //     'data' => ([
                        //         'callerName' => $data1['callerName'],
                        //         'callerMob' => $data1['callerMob'],
                        //         'incidentId' => $data1['incidentId'],
                        //         'incidentDate' => $data1['incidentDate'],
                        //         'incidentTime' => $data1['incidentTime'],
                        //         'incidentPatientCount' => $data1['incidentPatientCount'],
                        //         'cheifComplaint' => $data1['cheifComplaint'],
                        //         'incidentStatus' => $data1['incidentStatus'],
                        //         'incidentAddress' => $data1['incidentAddress'],
                        //         'lat' => (float) $data1['lat'],
                        //         'long' => (float) $data1['long'],
                        //         'incidentPincode' => $data1['incidentPincode'],
                        //         'callerRelationName' => $data1['CallerRelationName'],
                        //         'services' => $data1['Services'],
                        //         'hospitalFlag' => $data1['hospitalFlag'],
                        //         'hospitalName' => $data1['hospitalName'],
                        //         'hospitalAddress' => $data1['hospitalAddress'],
                        //         'hospitalLat' => (float) $data1['hospitalLat'],
                        //         'hospitalLong' => (float) $data1['hospitalLong'],
                        //         'currentStatus' => ([
                        //             'code' => (int) $paraCount,
                        //             'outOfSych' => $outOfSych,
                        //             'message' => $msg
                        //         ])
                        //     ]),
                        //     'error' => null
                        // ],REST_Controller::HTTP_OK);
                    }
                    $this->response([
                        'data' => $a,
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }else{
                    $this->response([
                        'data' => [],
                        'error' => null
                    ],REST_Controller::HTTP_OK);
                }
            }
            // foreach ($data as $data1) {
            //     print_r($data1);
            // }
            
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}