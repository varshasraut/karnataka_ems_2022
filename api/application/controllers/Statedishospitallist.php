<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Statedishospitallist extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
       $hosp['incidentId'] = $this->post('incidentId');
        $hosp['hospitalType'] = $this->post('hospitalType');
        $incidentId = $this->post('incidentId');
        // $hosp['allList'] = $this->post('allList'); //all - 1 & state/dist - 0
        $hosp['district'] = $this->post('district');
        $district = $this->user->getByDefaultDistrict($hosp);
        // print_r($hosp['hospitalType']);
        if(isset($_COOKIE['cookie'])){
            $hospList = $this->user->StateDisHospitalIncidentID($hosp);
             //print_r($hospList);die;
            $hospDetails = $this->user->getHospitalDeatils($incidentId);
            $a = array();
            if(!empty($hospDetails)){
                foreach($hospList as $key=>$hospList1){
                    if(!empty($hospDetails)){

                        for($i=0;$i<count($hospDetails);$i++){

                            if($hospList1['hospId'] == $hospDetails[$i]['hp_id']){
                                $hosp['hospId'] = $hospDetails[$i]['hp_id'];
                                $hosp['hospName'] = $hospDetails[$i]['hp_name'];
                                $hosp['hospAddress'] = $hospDetails[$i]['hp_address'];
                                $hosp['hospLat'] =  (float) $hospDetails[$i]['hp_lat'];
                                $hosp['hospLong'] =  (float) $hospDetails[$i]['hp_long'];
				$hosp['hospArea'] = $hospDetails[$i]['hp_area_type'];
				//$hosp['hospCityName'] = $hospDetails[$i]['cty_name'];
				//$hosp['hospDistrict'] = $hospDetails[$i]['dst_name'];
				//$hosp['hospTahsil'] = $hospDetails[$i]['thl_name'];
                                array_push($a,$hosp);
                            }
                        }
                    }
                }
            }
            $tmpArray = array();
            foreach ($hospList as $key_1 => $b1) {
                $duplicate = false;
                foreach($a as $a1) {
                    if($b1['hospId'] == $a1['hospId']) $duplicate = true;
                    }
                
                    if($duplicate == false) $tmpArray[] = $b1;

            }
            $data = array_merge($a,$tmpArray);
            if(!empty($hospDetails)){
                
                if($hosp['hospitalType'] == 'all'){
                    if(empty($hospDetails[0]['hospital_id']) && !empty($hospDetails[0]['hospital_name'])){
                        $hospitalType = $hospDetails[0]['hospital_type'];
                        $hospital = array(
                                'other' => 'true',
                                'hospId' => null,
                                'hospName' => $hospDetails[0]['hospital_name'],
                                'hospAdd' => $hospDetails[0]['hospital_address'],
                                'hospLat' => null,
                                'hospLong' => null
                        );
                    }else if((($hospDetails[0]['hospital_name']) == '') && (!empty($hospDetails[0]['hospital_id']))){
                        $hospitalType = $hospDetails[0]['hospital_type'];
                        $hospital = array(
                                'other' => 'false',
                                'hospId' => $hospDetails[0]['hp_id'],
                                'hospName' => $hospDetails[0]['hp_name'],
                                'hospAdd' => $hospDetails[0]['hp_address'],
                                'hospLat' => (float) $hospDetails[0]['hp_lat'],
                                'hospLong' => (float) $hospDetails[0]['hp_long']
                        );
                    }else if(($hospDetails[0]['hospital_name']) == '' && (empty($hospDetails[0]['hospital_id']))){
                        $hospitalType = null;
                        $hospital = null;
                    }
                }else{
                    if(empty($hospDetails[0]['hospital_id']) && !empty($hospDetails[0]['hospital_name']) ){
                        if($hospDetails[0]['hospital_type'] == $hosp['hospitalType']){
                            // $district1 = array(
                            //     'id' => $hospDetails[0]['id'],
                            //     'name' => $hospDetails[0]['name']
                            // );
                            $hospitalType = $hospDetails[0]['hospital_type'];
                            $hospital = array(
                                    'other' => 'true',
                                    'hospId' => null,
                                    'hospName' => $hospDetails[0]['hospital_name'],
                                    'hospAdd' => $hospDetails[0]['hospital_address'],
                                    'hospLat' => null,
                                    'hospLong' => null
                            );
                        }else{
                            $hospitalType = $hospDetails[0]['hospital_type'];
                            $hospital = array(
                                    'other' => 'true',
                                    'hospId' => null,
                                    'hospName' => null,
                                    'hospAdd' => null,
                                    'hospLat' => null,
                                    'hospLong' => null
                            );
                        }
                    }else if((($hospDetails[0]['hospital_name']) == '') && (!empty($hospDetails[0]['hospital_id']))){
                        if($hospDetails[0]['hospital_type'] == $hosp['hospitalType']){
                            // $district1 = array(
                            //     'id' => $hospDetails[0]['id'],
                            //     'name' => $hospDetails[0]['name']
                            // );
                            $hospitalType = $hospDetails[0]['hospital_type'];
                            $hospital = array(
                                    'other' => 'false',
                                    'hospId' => $hospDetails[0]['hp_id'],
                                    'hospName' => $hospDetails[0]['hp_name'],
                                    'hospAdd' => $hospDetails[0]['hp_address'],
                                    'hospLat' => (float) $hospDetails[0]['hp_lat'],
                                    'hospLong' => (float) $hospDetails[0]['hp_long']
                            );
                        }else{
                            $hospitalType = $hospDetails[0]['hospital_type'];
                            $hospital = array(
                                    'other' => 'false',
                                    'hospId' => null,
                                    'hospName' => null,
                                    'hospAdd' => null,
                                    'hospLat' => null,
                                    'hospLong' => null
                            );
                        }
                    }else if(($hospDetails[0]['hospital_name']) == '' && (empty($hospDetails[0]['hospital_id']))){
                        $hospitalType = null;
                        $hospital = null;
                    }
                }
                 
                // else{
                //     print_r('ggf');
                    
                //     // $district1 = array(
                //     //     'id' => $hospDetails[0]['id'],
                //     //     'name' => $hospDetails[0]['name']
                //     // );
                //     // $hospitalType = null;
                //     // $hospital = array(
                //     //         'other' => null,
                //     //         'hospId' => null,
                //     //         'hospName' => null,
                //     //         'hospAdd' => null,
                //     //         'hospLat' => null,
                //     //         'hospLong' => null
                //     // );
                // }
            }
            else{
                //  print_r('5');
                // $district1 = null;
                $hospitalType = null;
                $hospital = null;
            }
            $this->response([
                'data' => ([
                    'district' => $district,
                    'hospital_list' => $data,
                    // 'district1' => $district1,
                    'hospitalType' => $hospitalType,
                    'hospital' => $hospital
                ]),
                'error' => null
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'data' => ([]),
                'error' => null
            ],REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
        // $hosp['incidentId'] = $this->post('incidentId');
        // $hosp['hospitalType'] = $this->post('hospitalType');
        // // $hosp['allList'] = $this->post('allList'); //all - 1 & state/dist - 0
        // $hosp['district'] = $this->post('district');
        // $district = $this->user->getByDefaultDistrict($hosp);
        // if(isset($_COOKIE['cookie'])){
        //     $data = $this->user->StateDisHospitalIncidentID($hosp);
        //     $this->response([
        //         'data' => ([
        //             'district' => $district,
        //             'hospital_list' => $data
        //         ]),
        //         'error' => null
        //     ],REST_Controller::HTTP_OK);
        // }else{
        //     $this->response([
        //         'data' => ([]),
        //         'error' => null
        //     ],REST_Controller::HTTP_UNAUTHORIZED);
        // }
    
}