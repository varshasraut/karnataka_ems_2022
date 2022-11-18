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
        //Neous API
        if(empty($userName)){
            
            if(!empty($data['pilot_id'])){
                $data1 = $this->user->getpilotdata($data['pilot_id']);
                if(!empty($data1)){
                    $pilotName = $data1[0]['clg_first_name'].' '.$data1[0]['clg_mid_name'].' '.$data1[0]['clg_last_name'];
                    $pilotMbNo = (double) $data1[0]['clg_mobile_no'];
                    $pilot_id = (double) $data1[0]['clg_id'];
                }
                
            }else{
                $pilotName = "";
                $pilotMbNo = (double) "";
                $pilot_id = 0;
            }
            // print_r($data['emt_id']);die;
            if(!empty($data['emt_id'])){
                $data = $this->user->getemtdata($data['emt_id']);
                 
                if(!empty($data)){
                    $emsoName = $data[0]['clg_first_name'].' '.$data[0]['clg_mid_name'].' '.$data[0]['clg_last_name'];
                    $emsoMbNo = (double) $data[0]['clg_mobile_no'];
                    $emt_id = (double) $data[0]['clg_id'];
                }
            }else{
                $emsoName = "";
                $emsoMbNo = (double) "";
                $emt_id = 0;
            }
            // print_r($this->post('vehicleNumber'));die;
            $veh = $this->user->getvehicledata1($this->post('vehicleNumber'));
            // print_r($veh);
            if(!empty($veh)){
                $ambBaseloc = $veh[0]['hp_name'];
                $ambType = $veh[0]['ambt_name'];
                $ambStatus = $veh[0]['ambs_name'];
                $distName = $veh[0]['dst_name'];
            }
            // echo $pilot_id;die;
           //http://api.nuevastech.com:1214/api/ERCDash/PostData
            // $serverName = $_SERVER['HTTP_HOST'];
            // if($serverName == 'http://10.108.1.67/mhems/'){
            //     $NeousURL = 'http://10.108.1.85/api/ERCDash/PostData';
            // }else if($serverName == 'http://mhems.in'){
            //     $NeousURL = 'http://210.212.165.118:1111/api/ERCDash/PostData';
            // }
            // if($serverName == 'http://10.108.1.64/mhems_test'){
            //     $NeousURL = 'http://10.108.1.85/api/ERCDash/PostData';
            // }else if($serverName == 'http://210.212.165.119/mhems_test'){
            //     $NeousURL = 'http://210.212.165.118:1111/api/ERCDash/PostData';
            // }
            // die;
            $form_url = 'http://10.108.1.85:1111/api/ERCDash/PostData';
            $data_to_post = array();
            $data_to_post['Data']['pilotId'] = $pilot_id;
            $data_to_post['Data']['pilotName'] = $pilotName;
            $data_to_post['Data']['pilotMbNo'] = $pilotMbNo;
            $data_to_post['Data']['emsoId'] = $emt_id;
            $data_to_post['Data']['emsoName'] = $emsoName;
            $data_to_post['Data']['emsoMbNo'] = $emsoMbNo;
            $data_to_post['Data']['ambNo'] = $this->post('vehicleNumber');
            $data_to_post['Data']['ambBaseloc'] = $ambBaseloc;
            $data_to_post['Data']['ambStatus'] = $ambStatus;
            $data_to_post['Data']['ambType'] = $ambType;
            $data_to_post['Data']['distName'] =  $distName;
            $data_to_post['Data']['incidenceId'] =  $this->post('incidenceId') == '-1' || $this->post('incidenceId') == '' ? '' : (double) $this->post('incidenceId');
            $data_to_post['Data']['ignition'] = (int) $this->post('ignition');
            $data_to_post['Data']['speed'] = (float) $this->post('speed');
            $data_to_post['Data']['gpsStatus'] = $this->post('gpsStatus');
            $data_to_post['Data']['latitude'] = (double) $this->post('lat');
            $data_to_post['Data']['longitude'] = (double) $this->post('long');
            $data_to_post['Data']['packetdatetime'] = $this->post('packetdatetime');
            
            $data_to_post1 = '{"Data":[{"pilotId":"","pilotName":"","pilotMbNo":"","emsoId":"","emsoName":"Dr.Suhas  Deshmukh","emsoMbNo":9850840562,"ambNo":"DM 00 CL 0000","ambBaseloc":"TEST Base Location","ambStatus":"Available","ambType":"BLS","distName":"Pune","incidenceId":20000000000,"ignition":0,"speed":10,"gpsStatus":1,"latitude":21.55295,"longitude":73.85252,"packetdatetime":"2022-01-31 13:46:21"}]}';
            // print_r(json_encode($data_to_post));die;
            // $resultSet = Array();
            // $curl = curl_init($form_url);
            // if($data_to_post1){
            //     foreach($data_to_post1 as $result) {
            //     $resultSet[] = $result;
            //     }
            // }
            // $data_string['Data'] = $data_to_post1;
            // $data_to_post1 = $data_to_post[];
            // $data_string = json_encode($data_string);
            // print_r(($data_string));die;
            $curl = curl_init('http://10.108.1.85:1111/api/ERCDash/PostData');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_post1);  // Insert the data
            
            $result = curl_exec($curl);
            // var_dump($result);
            // die();
            // echo $result;die;
            $filepath =  'logs/neoustech_query_log/App-Query-log-' . date('Y-m-d') .$this->post('vehicleNumber'). '.php'; 
            $fp = fopen($filepath, "a+");
            fwrite($fp, $data_to_post1);
            fclose($fp);
            curl_close($curl);
          //die;
            
        }
        //End Neous API

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
    }
    public function latLngForNuevas_post($data){
        $logindata = $this->user->get_latlng_neuvas();

        if(!empty($data)){
            $this->response([
                'data' => $data,
                'error' => null
            ],REST_Controller::HTTP_OK);
        }
    }
}