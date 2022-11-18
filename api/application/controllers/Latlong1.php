<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
require APPPATH . '/libraries/REST_Controller.php';
class Latlong extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        //return false;
	//echo 'kkk';
	$cookie = $this->encryption->decrypt($_COOKIE['cookie']);
        $cookie1 = explode(' ', $cookie);
        if($cookie1[0] == 'MH'){
            $type = '3';
            $logindata = $this->user->get_login_for_latlng($cookie,$type);
            
            if(!empty($logindata)){
                $driver = array();
                $emt = array();
                foreach($logindata as $logindata1){
                    if($logindata1['login_type'] == 'D'){
                        array_push($driver,$logindata1['clg_id']);
                    }else if($logindata1['login_type'] == 'P'){
                        array_push($emt,$logindata1['clg_id']);
                    }
                }
                if(!empty($driver)){
                    $data['pilot_id'] = $driver[0];
                }
                if(!empty($emt)){
                    $data['emt_id'] = $emt[0];
                }
            }
        }else{
            $type = '';
            $logindata = $this->user->get_login_for_latlng($cookie,$type);
            if(!empty($logindata)){
                $driver = array();
                $emt = array();
                if($logindata[0]['login_type'] == 'D'){
                    array_push($driver,$logindata[0]['clg_id']);
                }else if($logindata[0]['login_type'] == 'P'){
                    array_push($emt,$logindata[0]['clg_id']);
                }
                if(!empty($driver)){
                    $data['pilot_id'] = $driver[0];
                }
                if(!empty($emt)){
                    $data['emt_id'] = $emt[0];
                }
            }
        }
        $userName = $this->post('userName');
        $colldata = $this->user->getCollId($userName);
        if(!empty($userName)){
            $data['other_user_id'] = $colldata[0]['clg_id'];
        }else{
            $data['other_user_id'] = '';
        }
        if(!empty($data['pilot_id'])){
            $data1 = $this->user->getpilotdata($data['pilot_id']);
            if(!empty($data1)){
                $data['pilotName'] = $data1[0]['clg_first_name'].' '.$data1[0]['clg_mid_name'].' '.$data1[0]['clg_last_name'];
                $data['pilotMbNo'] = (double) $data1[0]['clg_mobile_no'];
                // $data['pilot_id'] = $data1[0]['clg_id'];
            }
            
        }else{
            $data['pilotName'] = "";
            $data['pilotMbNo'] = (double) "";
            $data['pilot_id'] = "";
        }
        if(!empty($data['emt_id'])){
            $data1 = $this->user->getemtdata($data['emt_id']);
            if(!empty($data1)){
                $data['emsoName'] = $data1[0]['clg_first_name'].' '.$data1[0]['clg_mid_name'].' '.$data1[0]['clg_last_name'];
                $data['emsoMbNo'] =  (double) $data1[0]['clg_mobile_no'];
                // $data['emt_id'] = $data1[0]['clg_id'];
            }
        }else{
            $data['emsoName'] = "";
            $data['emsoMbNo'] = (double) "";
            $data['emt_id'] = "";
        }

        if($data['pilot_id']!='' && $data['emt_id']!='' && $data['other_user_id']!=''){
            $veh = $this->user->getvehicledata1($this->post('vehicleNumber'));
            if(!empty($veh)){
                $data['ambBaseloc'] = $veh[0]['hp_name'];
                $data['ambType'] = $veh[0]['ambt_name'];
                $data['ambStatus'] = $veh[0]['ambs_name'];
                $data['distName'] = $veh[0]['dst_name'];
            }
            $data['vehicleNumber'] = $this->post('vehicleNumber');
            $data['lat'] = $this->post('lat');
            $data['long'] = $this->post('long');
            $data['incidenceId'] = $this->post('incidenceId') == '-1' || $this->post('incidenceId') == '' ? '' : $this->post('incidenceId');
            $data['ignition'] = $this->post('ignition');
            $data['packetdatetime'] = $this->post('packetdatetime');
            $data['speed'] = $this->post('speed');
            $data['gps_status'] = $this->post('gpsStatus');
            $latlong = $this->user->insertLatLong($data);
            $this->user->UpdateLatLong($data);
        
            if($latlong == 1){
                $this->response([
                    'data' => array(
                        'message' => 'Insert Successfully'
                    ),
                    'error' => null
                ],REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'data' => array(
                        'message' => 'Not Inserted'
                    ),
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
    // public function latLngForNuevas($data){
    //     if(!empty($data)){
    //         $this->response([
    //             'data' => $data,
    //             'error' => null
    //         ],REST_Controller::HTTP_OK);
    //     }
    // }
    public function nuevasPassData_post(){
        $countId = $this->db->get('ems_nuevas_count')->result_array();
        // $countId = array('countId'=> 8426);
        if(!empty($countId)){
            $countId1 = $countId[0]['count_latlong_last_id'];
            $latlongrec = $this->user->getlatlong($countId1);
            // print_r($countId1);die;
            $resultSet = Array();
            foreach($latlongrec as $latlongrec1){
                if($latlongrec1['vehicleNumber']!=''){
                    $data['pilotId'] = $latlongrec1['pilot_id'] == '' ? (int) 0 : (int) $latlongrec1['pilot_id'];
                    $data['pilotName'] = $latlongrec1['pilotName'] == '' ? '' : $latlongrec1['pilotName'];
                    $data['pilotMbNo'] = $latlongrec1['pilotMbNo'] == 0 ? (double) 0 : (double) $latlongrec1['pilotMbNo'];
                    $data['emsoId'] = $latlongrec1['emt_id'] == '' ? (int) 0 : (int) $latlongrec1['emt_id'];
                    $data['emsoName'] = $latlongrec1['emsoName'] == '' ? '' : $latlongrec1['emsoName'];
                    $data['emsoMbNo'] = $latlongrec1['emsoMbNo'] == '' ? (double) 0 : (double) $latlongrec1['emsoMbNo'];
                    $data['ambNo'] = $latlongrec1['vehicleNumber'];
                    $data['ambBaseloc'] = $latlongrec1['ambBaseloc'];
                    $data['ambStatus'] = $latlongrec1['ambStatus'];
                    $data['ambType'] = $latlongrec1['ambType'];
                    $data['distName'] = $latlongrec1['distName'];
                    $data['incidenceId'] = $latlongrec1['incidenceId']== '' ? (int) 0 : (double) $latlongrec1['incidenceId'];
                    $data['ignition'] = $latlongrec1['ignition'] == 'On' ? (int) 1 : (int) 0 ;
                    $data['speed'] = (float) $latlongrec1['speed'];
                    $data['gpsStatus'] = (int) $latlongrec1['gps_status'];
                    $data['latitude'] = (double) $latlongrec1['lat'];
                    $data['longitude'] = (double) $latlongrec1['long'];
                    $data['packetdatetime'] = $latlongrec1['packetdatetime'];
                    array_push($resultSet,$data);
                }
                $keyId['count_latlong_last_id'] = $latlongrec1['id'];
                // $countId .= $latlongrec1['id'];
            }
            // print_r($countId);die;
            // $this->db->where('id',1)->update('ems_nuevas_count',$keyId);
            $resultSet1['Data'] = $resultSet;
            // $resultSet2 = '{"Data":[{"pilotId":0,"pilotName":"","pilotMbNo":0,"emsoId":73,"emsoName":"Dr.Suhas  Deshmukh","emsoMbNo":9850840562,"ambNo":"DM 00 CL 0000","ambBaseloc":"TEST Base Location","ambStatus":"Available","ambType":"BLS","distName":"Pune","incidenceId":20000000000,"ignition":0,"speed":10,"gpsStatus":1,"latitude":21.55295,"longitude":73.85252,"packetdatetime":"2022-01-31 13:46:21"}]}';
            $resultSet2 = json_encode($resultSet1);
            // print_r($resultSet2);die;
            //'http://210.212.165.118:1111/api/ERCDash/PostData'
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_POSTFIELDS, $resultSet2);  // Insert the data
            //curl_setopt($curl, CURLOPT_TIMEOUT, 15 );
            $result = curl_exec($curl);
            echo $result;
            curl_close($curl);
        }
        
    }
}