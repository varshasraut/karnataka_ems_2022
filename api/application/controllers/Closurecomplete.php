<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("Asia/Calcutta");
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Closurecomplete extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        $this->load->model('user');
        $this->load->helper(array('cookie', 'url'));
        $this->load->library('encryption');
    }
    public function index_post(){
        if((isset($_COOKIE['cookie']))){
            $startodo = $this->post('startOdometer');
            $endodo = $this->post('endOdometer');
            $atSceneResRemark = $this->post('atSceneTimeRemark');
            $atSceneResRemarkOth = $this->post('atSceneTimeRemarkOth');
            $calodo = $this->post('endOdometer') - $this->post('startOdometer');
            $onsceneCallType = $this->post('onsceneCallType');
            // if($calodo <= 500){
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
                    $id = $this->encryption->decrypt($_COOKIE['cookie']);
                    $type = $this->post('type');
                    $loginId = $this->user->getId($id,$type);
                    // print_r($loginId);
                    $ambno = $loginId['vehicle_no'];
                    $assignedIncidenceCalls = $this->user->assignedIncidenceCalls($ambno);
                    $incidentId = $this->post('incidentId');
                    $incPtnCount = $this->user->getincPtnCount($incidentId);

                    $getIncdateTime = $this->user->getIncdateTime($incidentId);
                    if($getIncdateTime != ''){
                        $IncdateTime = $getIncdateTime;
                    }
                    $acknowledge = $this->post('acknowledge');
                    $start_from_base_loc = $this->post('startFromBaseLoc');
                    $at_scene = $this->post('atScene');
                    $from_scene = $this->post('fromScene');
                    $at_hospital = $this->post('atHospital');
                    $patient_handover = $this->post('patienthandover');
                    $back_to_base_loc = $this->post('backToBaseLoc');
                    $acknowledge_km = $this->post('acknowledge_km');
                    $start_from_base_loc_km = $this->post('start_from_base_loc_km');
                    $at_scene_km = $this->post('at_scene_km');
                    $from_scene_km = $this->post('from_scene_km');
                    $at_hospital_km = $this->post('at_hospital_km');
                    $patient_handover_km = $this->post('patient_handover_km');
                    $back_to_base_loc_km = $this->post('back_to_base_loc_km');
                    $pvtHospPayMode = $this->post('pvtHospPayMode');
                    $para['acknowledge'] = (isset($acknowledge)) ? $acknowledge : $IncdateTime;
                    $para['start_from_base_loc'] = (isset($start_from_base_loc)) ? $start_from_base_loc : $IncdateTime;
                    $para['at_scene'] = (isset($at_scene)) ? $at_scene : $IncdateTime;
                    $para['from_scene'] = (isset($from_scene)) ? $from_scene : $IncdateTime;
                    $para['at_hospital'] = (isset($at_hospital)) ? $at_hospital : $IncdateTime;
                    $para['patient_handover'] = (isset($patient_handover)) ? $patient_handover : $IncdateTime;
                    $para['back_to_base_loc'] = (isset($back_to_base_loc)) ? $back_to_base_loc : $IncdateTime;
                    $para['acknowledge_km'] = (isset($acknowledge_km)) ? $acknowledge_km : $IncdateTime;
                    $para['start_from_base_loc_km'] = (isset($start_from_base_loc_km)) ? $start_from_base_loc_km : $IncdateTime;
                    $para['at_scene_km'] = (isset($at_scene_km)) ? $at_scene_km : $IncdateTime;
                    $para['from_scene_km'] = (isset($from_scene_km)) ? $from_scene_km : $IncdateTime;
                    $para['at_hospital_km'] = (isset($at_hospital_km)) ? $at_hospital_km : $IncdateTime;
                    $para['patient_handover_km'] = (isset($patient_handover_km)) ? $patient_handover_km : $IncdateTime;
                    $para['back_to_base_loc_km'] = (isset($back_to_base_loc_km)) ? $back_to_base_loc_km : $IncdateTime;
                    $para['closureCompid'] = $loginId['id'];
                    $logindata = $this->user->getUserLogin($id,$type);
                    $ambdata = $this->user->getVehicleData($ambno);
                    // print_r($ambdata);
                    if(!empty($ambdata)){
                    $ambtype = $ambdata[0]['thirdparty']; 
                    }
                    else
                    {
                        $ambtype=0;
                    }
                    $incidentData = $this->user->getIncidentData($incidentId);
                    $gpsIncidentData = $incidentData;
                    $epcrData = $this->user->getepcrData($incidentId);
                    $checkIncidentIdClose = $this->user->checkIncidentIdClose($incidentId);
                    $dp_operated_by = array();
                    if(empty($epcrData))
                    {
                        if(empty($logindata)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'User not login'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
                            foreach($logindata as $logindata1){
                                if(count($logindata)==1){
                                    if($logindata1['login_type'] == 'P'){
                                        $emso_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$emso_id);
                                    }else{
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$pilot_id);
                                    }
                                }else{
                                    if($logindata1['login_type'] == 'P'){
                                        $emso_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$emso_id);
                                    }else{
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$pilot_id);
                                    }
                                }
                                
                            }
                        }
                        if(count($dp_operated_by) == 2){
                            $dp_operated_by1 = implode(',',$dp_operated_by);
                        }else{
                            if(!empty($dp_operated_by)){
                                $dp_operated_by1 = $dp_operated_by[0];
                            }else{
                                $dp_operated_by1 = null;
                            }
                        }
                        $incidentData = $this->user->getincidentdataall($incidentId); 
                        //  print_r($incidentData);
                        // die;
                        $len = 6;
                        if (function_exists("random_bytes")) {
                            $bytes = random_bytes(ceil($len / 2));
                            $data = "s" . substr(bin2hex($bytes), 0, $len);
                        } elseif (function_exists("openssl_random_pseudo_bytes")) {
                            $bytes = openssl_random_pseudo_bytes(ceil($len / 2));
                            $data = "s" . substr(bin2hex($bytes), 0, $len);
                        } else {
                            $data =  "s" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $len);
                        }
                        $primary_key = "AMB-" . date("Y") . str_pad(date("z"), 3, "0", STR_PAD_LEFT) . time() .$data;
                        $datas['amb_rto_register_no'] = $logindata[0]['vehicle_no'];
                        $datas['start_odmeter'] = $this->post('startOdometer');
                        $datas['end_odmeter'] = $this->post('endOdometer');
                        $datas['scene_odometer'] = $at_scene_km;
                        $datas['from_scene_odometer'] = $from_scene_km;
                        $datas['hospital_odometer'] = $at_hospital_km;
                        $datas['handover_odometer'] = $patient_handover_km;
                        $datas['inc_ref_id'] = $incidentId;
                        $datas['fuel_volume'] = $this->post('fuelVolume') == "-1" ? "" : $this->post('fuelVolume');
                        $datas['remark'] = $this->post('remark');
                        $datas['timestamp'] = date('Y-m-d H:i:s');
                        $datas['total_km'] = $this->post('endOdometer') - $this->post('startOdometer');
                        $datas['odometer_date'] = date('Y-m-d');
                        $datas['odometer_time'] = date('H:i:s');
                        $datas['odometer_type'] = 'closure';
                        //$start_fr_bs_loc = (isset($start_from_base_loc)) ? strtotime($start_from_base_loc) : strtotime($IncdateTime);
                        $at_scene1 = (isset($at_scene)) ? strtotime($at_scene) : strtotime($IncdateTime);
                        $epcr['id'] = $primary_key;
                        $epcr['inc_ref_id'] = $incidentId;
                        $epcr['state_id'] =$incidentData[0]['inc_state_id'];
                        $epcr['tahsil_id'] = $incidentData[0]['inc_tahshil_id'];
                        $epcr['district_id'] = $incidentData[0]['inc_district_id'];
                        $epcr['city_id'] = $incidentData[0]['inc_city_id'];
                        $epcr['locality'] = $incidentData[0]['inc_address'];
                        $epcr['remark'] = $this->post('remark');
                        $epcr['start_odometer'] = $this->post('startOdometer');
                        $epcr['scene_odometer'] = $at_scene_km;
                        $epcr['from_scene_odometer'] = $from_scene_km;
                        $epcr['hospital_odometer'] = $at_hospital_km;
                        $epcr['handover_odometer'] = $patient_handover_km;
                        $epcr['end_odometer'] = $this->post('endOdometer');
                        $epcr['total_km'] = $this->post('endOdometer') - $this->post('startOdometer');
                        $epcr['date'] = date('Y-m-d');
                        $epcr['time'] = date('H:i:s');
                        $epcr['amb_reg_id'] = $ambno;
                        $epcr['ptn_id'] = $incidentData[0]['ptn_id']; 
                        $epcr['inc_datetime'] = $incidentData[0]['inc_datetime'];
                        $epcr['base_month'] = $incidentData[0]['inc_base_month'];
                        $epcr['operate_by'] =$dp_operated_by1;
                        $epcr['third_party']=$ambtype;
                        $epcr['base_location_id'] =$ambdata[0]['hp_id'];
                        $epcr['base_location_name'] =$ambdata[0]['hp_name'];
                        $epcr['wrd_location_id'] =$ambdata[0]['ward_id'];
                        $epcr['wrd_location'] =$ambdata[0]['wname'];
                        $epcr['system_type'] =$ambdata[0]['amb_user'];
                        $epcr['added_date'] = date('Y-m-d H:i:s');
                        $epcrid = $this->user->insertepcr($epcr); 
                        $this->user->updateDriverPara($para,$incidentId);
                        $epcrData = $this->user->getepcrData($incidentId);
                        $dpcr['dp_operated_by'] = $dp_operated_by1;
                        $dpcr['dp_started_base_loc'] = (isset($start_from_base_loc)) ? $start_from_base_loc : $IncdateTime;
                        $dpcr['start_from_base'] = (isset($start_from_base_loc)) ? $start_from_base_loc : $IncdateTime;
                        $dpcr['dp_on_scene'] = (isset($at_scene)) ? $at_scene : $IncdateTime;
                        $dpcr['dp_reach_on_scene'] = (isset($from_scene)) ? $from_scene : $IncdateTime;
                        $dpcr['dp_hosp_time'] = (isset($at_hospital)) ? $at_hospital : $IncdateTime;
                        $dpcr['dp_hand_time'] = (isset($patient_handover)) ? $patient_handover : $IncdateTime;
                        $dpcr['dp_back_to_loc'] = (isset($back_to_base_loc)) ? $back_to_base_loc : $IncdateTime;
                        $dpcr['start_odometer'] = $this->post('startOdometer');
                        $dpcr['end_odometer'] = $this->post('endOdometer');
                        $dpcr['scene_odometer'] = $at_scene_km;
                        $dpcr['from_scene_odometer_pcr'] = $from_scene_km;
                        $dpcr['hospital_odometer'] = $at_hospital_km;
                        $dpcr['handover_odometer'] = $patient_handover_km;
                        $dpcr['dp_date'] = date('Y-m-d H:i:s');
                        $dpcr['responce_time_remark'] = $atSceneResRemark;
                        $dpcr['responce_time_remark_other'] = $atSceneResRemarkOth;
                        $resonse_time = ($at_scene1 - strtotime($incidentData[0]['inc_datetime']));
                        $dpcr['responce_time'] = gmdate('H:i:s',$resonse_time);
                        //$dpcr['responce_time'] = round(abs($start_fr_bs_loc - $at_scene) / 60,2);
                        if(!empty($incidentData)){
                            $dpcr['dp_base_month'] = $incidentData[0]['inc_base_month'];
                        }  
                        // print_r($incidentData);  die;
                        $getepcr = $this->user->getepcrData($incidentId); 
                        foreach($getepcr as $getepcr1){
                            $dpcr['dp_pcr_id'] = $getepcr1['id'];
                            $dpcr['dp_id'] = $primary_key;
                            $dpcr['inc_ref_id'] = $getepcr1['inc_ref_id'];
                            $date = date('Y-m-d',strtotime($getepcr1['inc_datetime']));
                            $time = date('H:i:s',strtotime($getepcr1['inc_datetime']));
                            $dpcr['inc_date'] = $date;
                            $dpcr['inc_dispatch_time'] = $time;
                            $this->user->insertDriverpcr($dpcr);
                            
                            $pcr['pcr_id'] = $getepcr1['id'];
                            $pcr['id'] = $primary_key;
                            $pcr['inc_ref_id'] = $getepcr1['inc_ref_id'];
                            $pcr['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                            $pcr['patient_id'] = $getepcr1['ptn_id'];
                            $pcr['pcr_steps'] = 'PCR';
                            $pcr['base_month'] = $getepcr1['base_month'];
                            $pcr['date'] = date('Y-m-d H:i:s');
                            $this->user->insertpcr($pcr);
                        }
                        if(count($assignedIncidenceCalls) == 1){
                            $this->user->freeAmbulance($ambno);
                        }
                        $data1 = $this->user->submitClosure($datas);
                        $emsIncidence['inc_pcr_status'] = '1';
                        $this->user->incidenceClose($emsIncidence,$incidentId);    
                        //start data pass to GPS
                        $gps['ProjectType'] = "108";
                        $gps['EmType'] = $gpsIncidentData[0]['pname'];
                        $gps['CallDateTime'] = date('Y-m-d H:i', strtotime($gpsIncidentData[0]['inc_recive_time']));
                        $gps['JobNo'] = $gpsIncidentData[0]['inc_ref_id'];
                        $vehicle = $gpsIncidentData[0]['amb_rto_register_no'];
                        $veh = explode('-',$vehicle);
                        $vehicleNumber = implode('',$veh);
                        $gps['AmbulanceNo'] = $vehicleNumber;
                        $gps['DispatchedDateTime'] = date('Y-m-d H:i', strtotime($gpsIncidentData[0]['inc_datetime']));
                        $gps['ReachedtosceneDateTime'] = date('Y-m-d H:i', strtotime($at_scene));
                        $gps['DropHospital'] = $gpsIncidentData[0]['hp_name'];;
                        $gps['HospitalType'] = $gpsIncidentData[0]['full_name'];;
                        $gps['BacktobaseDatetime'] = date('Y-m-d H:i', strtotime($back_to_base_loc));
                        $gps['TripDistance'] = $this->post('endOdometer') - $this->post('startOdometer');
                        $gps['stateCode'] = $gpsIncidentData[0]['inc_state_id'];
                        $gps['ClosingStatus'] = "closed";
                        $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($at_hospital));
                        $gps['EmergencyChiefComplaint'] = $gpsIncidentData[0]['ct_type'];
                        $gps['AyushmanCard'] = isset($gpsIncidentData[0]['ayushman_id']) ? $gpsIncidentData[0]['ayushman_id'] : "";
                        if($gpsIncidentData[0]['ayushman_id'] != "" || $gpsIncidentData[0]['ayushman_id'] != Null){
                            $exemption = "yes";
                        }else{
                            $exemption = "no";
                        }
                        $gps['Exemption'] = $exemption;
                        // echo '22';
                        // $data_string['AmbulanceTripStatus'] = array($gps);
                        // $data_string = json_encode($data_string);
                        // $curl = curl_init('http://13.235.213.74:5577');
                        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                        // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        // 'Content-Type: application/json')
                        // );
                        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
                        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
                        // //curl_setopt($curl, CURLOPT_TIMEOUT, 15 );
                        // $result = curl_exec($curl);
                        // echo $result;die;
                        //End pass to GPS
                        //Update ptn_pcr_status
                        if(!empty($incPtnCount)){
                            foreach($incPtnCount as $incPtnCount1){
                                $ptn_id = $incPtnCount1['ptn_id'];
                                $ptn['ptn_pcr_status'] = '1';
                                $this->user->addPrnRec($ptn_id,$ptn);
                            }
                        }
                        //End Update ptn_pcr_status
                        if(!empty($pvtHospPayMode)){
                            $pvthospPayModeAdd['received_payment_mode'] = $pvtHospPayMode;
                            $this->user->update_pvt_hosp_pay_mode($incidentId,$pvthospPayModeAdd);
                        }
                        if($data1 == 1){
                            $this->response([
                                'data' => ([
                                    'code' => 1,
                                    'message' => 'Inserted'
                                ]),
                                'error' => null
                            ],REST_Controller::HTTP_OK);
                        }else{
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'Not Inserted'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }else{
                        if(empty($checkIncidentIdClose)){
                        if(empty($logindata)){
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 1,
                                    'message' => 'User not login'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }else{
                            foreach($logindata as $logindata1){
                                if(count($logindata)==1){
                                    if($logindata1['login_type'] == 'P'){
                                        $emso_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$emso_id);
                                    }else{
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$pilot_id);
                                    }
                                }else{
                                    if($logindata1['login_type'] == 'P'){
                                        $emso_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$emso_id);
                                    }else{
                                        $pilot_id = $logindata1['clg_ref_id'];
                                        array_push($dp_operated_by,$pilot_id);
                                    }
                                }
                                
                            }
                        }
                        if(count($dp_operated_by) == 2){
                            $dp_operated_by1 = implode(',',$dp_operated_by);
                        }else{
                            if(!empty($dp_operated_by)){
                                $dp_operated_by1 = $dp_operated_by[0];
                            }else{
                                $dp_operated_by1 = null;
                            }
                        }
                            if(empty($logindata)){
                                $this->response([
                                    'data' => ([]),
                                    'error' => null
                                ],REST_Controller::HTTP_UNAUTHORIZED);
                            }else{
                                foreach($logindata as $logindata1){
                                    $datas['amb_rto_register_no'] = $logindata1['vehicle_no'];
                                }
                                $datas['start_odmeter'] = $this->post('startOdometer');
                                $datas['end_odmeter'] = $this->post('endOdometer');
                                $datas['scene_odometer'] = $at_scene_km;
                                $datas['from_scene_odometer'] = $from_scene_km;
                                $datas['hospital_odometer'] = $at_hospital_km;
                                $datas['handover_odometer'] = $patient_handover_km;
                                $datas['inc_ref_id'] = $incidentId;
                                $datas['fuel_volume'] = $this->post('fuelVolume') == "-1" ? "" : $this->post('fuelVolume');
                                $datas['remark'] = $this->post('remark');
                                $datas['timestamp'] = date('Y-m-d H:i:s');
                                $datas['total_km'] = $this->post('endOdometer') - $this->post('startOdometer');
                                $datas['odometer_date'] = date('Y-m-d');
                                $datas['odometer_time'] = date('H:i:s');
                                $datas['odometer_type'] = 'closure';
                                if(!empty($incidentData)){
                                    if($incidentData[0]['hospital_id'] == ""){
                                        $epcr['other_receiving_host'] = $incidentData[0]['hospital_name'];
                                    }else{
                                        $epcr['rec_hospital_name'] = $incidentData[0]['hospital_id'];
                                    }
                                }
                                if($onsceneCallType == 'yes'){
                                    $epcr['rec_hospital_name'] = 'on_scene_care';
                                }
                                $epcr['remark'] = $this->post('remark');
                                $epcr['start_odometer'] = $this->post('startOdometer');
                                $epcr['scene_odometer'] = $at_scene_km;
                                $epcr['from_scene_odometer'] = $from_scene_km;
                                $epcr['hospital_odometer'] = $at_hospital_km;
                                $epcr['handover_odometer'] = $patient_handover_km;
                                $epcr['end_odometer'] = $this->post('endOdometer');
                                $epcr['total_km'] = $this->post('endOdometer') - $this->post('startOdometer');
                                $epcr['operate_by'] =$dp_operated_by1;
                                $epcr['third_party']=$ambtype;
                                $epcr['base_location_id'] =$ambdata[0]['hp_id'];
                                $epcr['base_location_name'] =$ambdata[0]['hp_name'];
                                $epcr['wrd_location_id'] =$ambdata[0]['ward_id'];
                                $epcr['wrd_location'] =$ambdata[0]['wname'];    
                                $epcr['system_type'] =$ambdata[0]['amb_user'];
                                $epcr['added_date'] = date('Y-m-d H:i:s');
                                
                                $this->user->updateDriverPara($para,$incidentId);
                                $epcrInsert = $this->user->epcrremark($epcr,$incidentId);
                                $driverParameter = $this->user->getDriverParameter($incidentId);
                                //$start_fr_bs_loc = (isset($start_from_base_loc)) ? strtotime($start_from_base_loc) : strtotime($IncdateTime);
                                $at_scene1 = (isset($at_scene)) ? strtotime($at_scene) : strtotime($IncdateTime);
                                $getepcr = $this->user->getepcrData($incidentId);
                                $dpcr['dp_operated_by'] = $dp_operated_by1;
                                $dpcr['dp_started_base_loc'] = (isset($start_from_base_loc)) ? $start_from_base_loc : $IncdateTime;
                                $dpcr['start_from_base'] = (isset($start_from_base_loc)) ? $start_from_base_loc : $IncdateTime;
                                $dpcr['dp_on_scene'] = (isset($at_scene)) ? $at_scene : $IncdateTime;
                                $dpcr['dp_reach_on_scene'] = (isset($from_scene)) ? $from_scene : $IncdateTime;
                                $dpcr['dp_hosp_time'] = (isset($at_hospital)) ? $at_hospital : $IncdateTime;
                                $dpcr['dp_hand_time'] = (isset($patient_handover)) ? $patient_handover : $IncdateTime;
                                $dpcr['dp_back_to_loc'] = (isset($back_to_base_loc)) ? $back_to_base_loc : $IncdateTime;
                                $dpcr['start_odometer'] = $this->post('startOdometer');
                                $dpcr['end_odometer'] = $this->post('endOdometer');
                                $dpcr['scene_odometer'] = $at_scene_km;
                                $dpcr['from_scene_odometer_pcr'] = $from_scene_km;
                                $dpcr['hospital_odometer'] = $at_hospital_km;
                                $dpcr['handover_odometer'] = $patient_handover_km;
                                $dpcr['dp_date'] = date('Y-m-d H:i:s');
                                $dpcr['responce_time_remark'] = $atSceneResRemark;
                                $dpcr['responce_time_remark_other'] = $atSceneResRemarkOth;
                                $resonse_time = ($at_scene1 - strtotime($incidentData[0]['inc_datetime']));
                                $dpcr['responce_time'] = gmdate('H:i:s',$resonse_time);
                                //$dpcr['responce_time'] = round(abs($start_fr_bs_loc - $at_scene) / 60,2);
                                if(!empty($incidentData)){
                                    $dpcr['dp_base_month'] = $incidentData[0]['inc_base_month'];
                                }
                                foreach($getepcr as $getepcr1){
                                    if(!empty($getepcr1)){
                                        if($getepcr1['med_id_list'] != null){
                                            $medicine = json_decode($getepcr1['med_id_list']);
                                            foreach($medicine as $medicine1){
                                                $medambstk['incidentId'] = $incidentId;
                                                $medambstk['as_item_id'] = $medicine1->id;
                                                $medambstk['as_item_type'] = "MED";
                                                $medambstk['as_stk_in_out'] = "out";
                                                $medambstk['as_item_qty'] = $medicine1->count;
                                                $medambstk['as_sub_id'] = $getepcr1['id'];
                                                $medambstk['as_sub_type'] = "pcr";
                                                $medambstk['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                                                $medambstk['as_date'] = date('Y-m-d H:i:s');
                                                $medambstk['as_base_month'] = $getepcr1['base_month'];
                                                $this->user->insertMedAmbStk($medambstk);
                                            }
                                        }
                                    }
                                    if(!empty($getepcr1)){
                                        if($getepcr1['med_nonunit_id_list'] != null){
                                            $medicine = json_decode($getepcr1['med_nonunit_id_list']);
                                            foreach($medicine as $medicine1){
                                                $medambstk['incidentId'] = $incidentId;
                                                $medambstk['as_item_id'] = $medicine1->id;
                                                $medambstk['as_item_type'] = "MEDNCA";
                                                $medambstk['as_stk_in_out'] = "out";
                                                $medambstk['as_item_qty'] = 1;
                                                $medambstk['as_sub_id'] = $getepcr1['id'];
                                                $medambstk['as_sub_type'] = "pcr";
                                                $medambstk['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                                                $medambstk['as_date'] = date('Y-m-d H:i:s');
                                                $medambstk['as_base_month'] = $getepcr1['base_month'];
                                                $this->user->insertNonUnitMedAmbStk($medambstk);
                                            }
                                        }
                                    }
                                    if(!empty($getepcr1)){
                                        if($getepcr1['con_id_list'] != null){
                                            $consumable = json_decode($getepcr1['con_id_list']);
                                            foreach($consumable as $consumable1){
                                                $conambstk['incidentId'] = $incidentId;
                                                $conambstk['as_item_id'] = $consumable1->id;
                                                $conambstk['as_item_type'] = "CA";
                                                $conambstk['as_stk_in_out'] = "out";
                                                $conambstk['as_item_qty'] = $consumable1->count;
                                                $conambstk['as_sub_id'] = $getepcr1['id'];
                                                $conambstk['as_sub_type'] = "pcr";
                                                $conambstk['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                                                $conambstk['as_date'] = date('Y-m-d H:i:s');
                                                $conambstk['as_base_month'] = $getepcr1['base_month'];
                                                $this->user->insertConAmbStk($conambstk);
                                            }
                                        }
                                    }
                                    if(!empty($getepcr1)){
                                        if($getepcr1['con_nonunit_id_list'] != null){
                                            $consumable = json_decode($getepcr1['con_nonunit_id_list']);
                                            foreach($consumable as $consumable1){
                                                $conambstk['incidentId'] = $incidentId;
                                                $conambstk['as_item_id'] = $consumable1->id;
                                                $conambstk['as_item_type'] = "NCA";
                                                $conambstk['as_stk_in_out'] = "out";
                                                $conambstk['as_item_qty'] = 1;
                                                $conambstk['as_sub_id'] = $getepcr1['id'];
                                                $conambstk['as_sub_type'] = "pcr";
                                                $conambstk['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                                                $conambstk['as_date'] = date('Y-m-d H:i:s');
                                                $conambstk['as_base_month'] = $getepcr1['base_month'];
                                                $this->user->insertNonUnitConAmbStk($conambstk);
                                            }
                                        }
                                    }
                                    if(!empty($getepcr1)){
                                        if($getepcr1['ini_con_injury'] != null){
                                            $injurydata = json_decode($getepcr1['ini_con_injury']);
                                            foreach($injurydata as $injurydata1){
                            //print_r($injurydata1);die;
                                                $injury['incidentId'] = $incidentId;
                                                $injury['as_item_id'] = $injurydata1->id;
                                                $injury['as_item_type'] = "INJ";
                                                $injury['as_stk_in_out'] = "out";
                                                $injury['as_item_qty'] = 1;
                                                $injury['as_sub_id'] = $getepcr1['id'];
                                                $injury['as_sub_type'] = "pcr";
                                                $injury['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                                                $injury['as_date'] = date('Y-m-d H:i:s');
                                                $injury['as_base_month'] = $getepcr1['base_month'];
                                                $this->user->insertInjury($injury);
                                            }
                                        }
                                    }

                                    $data1 = $this->user->submitClosure($datas);
                                    $len = 6;
                                    if (function_exists("random_bytes")) {
                                        $bytes = random_bytes(ceil($len / 2));
                                        $data = "s" . substr(bin2hex($bytes), 0, $len);
                                    } elseif (function_exists("openssl_random_pseudo_bytes")) {
                                        $bytes = openssl_random_pseudo_bytes(ceil($len / 2));
                                        $data = "s" . substr(bin2hex($bytes), 0, $len);
                                    } else {
                                        $data =  "s" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, $len);
                                    }
                                    $primary_key = "AMB-" . date("Y") . str_pad(date("z"), 3, "0", STR_PAD_LEFT) . time() .$data;
                                    $dpcr['dp_pcr_id'] = $getepcr1['id'];
                                    $dpcr['dp_id'] = $primary_key;
                                    $dpcr['inc_ref_id'] = $getepcr1['inc_ref_id'];
                                    $date = date('Y-m-d',strtotime($getepcr1['inc_datetime']));
                                    $time = date('H:i:s',strtotime($getepcr1['inc_datetime']));
                                    $dpcr['inc_date'] = $date;
                                    $dpcr['inc_dispatch_time'] = $time;
                                    // print_r($dpcr);die;
                                    $this->user->insertDriverpcr($dpcr);
                                    $pcr['pcr_id'] = $getepcr1['id'];
                                    $pcr['id'] = $primary_key;
                                    $pcr['inc_ref_id'] = $getepcr1['inc_ref_id'];
                                    $pcr['amb_rto_register_no'] = $getepcr1['amb_reg_id'];
                                    $pcr['patient_id'] = $getepcr1['ptn_id'];
                                    $pcr['pcr_steps'] = 'PCR';
                                    $pcr['base_month'] = $getepcr1['base_month'];;
                                    $pcr['date'] = date('Y-m-d H:i:s');
                                    $this->user->insertpcr($pcr);
                                }
                                if(count($assignedIncidenceCalls) == 1){
                                    $this->user->freeAmbulance($ambno);
                                }
                        
                                
                                $emsIncidence['inc_pcr_status'] = '1';
                                $this->user->incidenceClose($emsIncidence,$incidentId);
                                
                                //start data pass to GPS
                                $gps['ProjectType'] = "108";
                                $gps['EmType'] = $incidentData[0]['pname'];
                                $gps['CallDateTime'] = date('Y-m-d H:i', strtotime($incidentData[0]['inc_recive_time']));
                                $gps['JobNo'] = $incidentData[0]['inc_ref_id'];
                                $vehicle = $incidentData[0]['amb_rto_register_no'];
                                $veh = explode('-',$vehicle);
                                $vehicleNumber = implode('',$veh);
                                $gps['AmbulanceNo'] = $vehicleNumber;
                                $gps['DispatchedDateTime'] = date('Y-m-d H:i', strtotime($incidentData[0]['inc_datetime']));
                                $gps['ReachedtosceneDateTime'] = date('Y-m-d H:i', strtotime($at_scene));
                                $gps['DropHospital'] = $incidentData[0]['hp_name'];;
                                $gps['HospitalType'] = $incidentData[0]['full_name'];;
                                $gps['BacktobaseDatetime'] = date('Y-m-d H:i', strtotime($back_to_base_loc));
                                $gps['TripDistance'] = $this->post('endOdometer') - $this->post('startOdometer');
                                $gps['stateCode'] = $incidentData[0]['inc_state_id'];
                                $gps['ClosingStatus'] = "closed";
                                $gps['DropDateTime'] = date('Y-m-d H:i', strtotime($at_hospital));
                                $gps['EmergencyChiefComplaint'] = $incidentData[0]['ct_type'];
                                $gps['AyushmanCard'] = isset($incidentData[0]['ayushman_id']) ? $incidentData[0]['ayushman_id'] : "";
                                if($incidentData[0]['ayushman_id'] != "" || $incidentData[0]['ayushman_id'] != Null){
                                    $exemption = "yes";
                                }else{
                                    $exemption = "no";
                                }
                                $gps['Exemption'] = $exemption;
                                // print_r($gps);die;
                                // $data_string['AmbulanceTripStatus'] = array($gps);
                                // $data_string = json_encode($data_string);
                                // $curl = curl_init('http://13.235.213.74:5577');
                                // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                // 'Content-Type: application/json')
                                // );
                                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
                                // curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
                                // //curl_setopt($curl, CURLOPT_TIMEOUT, 15 );
                                // $result = curl_exec($curl);
                                // echo $result;die;
                                //End pass to GPS
                                //Update ptn_pcr_status
                                if(!empty($pvtHospPayMode)){
                                    $pvthospPayModeAdd['received_payment_mode'] = $pvtHospPayMode;
                                    $this->user->update_pvt_hosp_pay_mode($incidentId,$pvthospPayModeAdd);
                                }
                                if(!empty($incPtnCount)){
                                    foreach($incPtnCount as $incPtnCount1){
                                        $ptn_id = $incPtnCount1['ptn_id'];
                                        $ptn['ptn_pcr_status'] = '1';
                                        $this->user->addPrnRec($ptn_id,$ptn);
                                    }
                                }
                                //End Update ptn_pcr_status
                                if($data1 == 1){
                                    $this->response([
                                        'data' => ([
                                            'code' => 1,
                                            'message' => 'Inserted'
                                        ]),
                                        'error' => null
                                    ],REST_Controller::HTTP_OK);
                                }else{
                                    $this->response([
                                        'data' => null,
                                        'error' => ([
                                            'code' => 1,
                                            'message' => 'Not Inserted'
                                        ])
                                    ],REST_Controller::HTTP_OK);
                                }
                            }
                        }else{
                            $this->response([
                                'data' => null,
                                'error' => ([
                                    'code' => 105,
                                    'message' => 'Incident Id Completed'
                                ])
                            ],REST_Controller::HTTP_OK);
                        }
                    }  
                }
            // }else{
            //     $this->response([
            //         'data' => null,
            //         'error' => ([
            //             'code' => 1,
            //             'message' => 'Please enter end odometer less than 500'
            //         ])
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