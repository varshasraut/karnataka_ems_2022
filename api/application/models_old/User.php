<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->colleague = 'ems_colleague';
        $this->loginSessionTbl = 'ems_app_login_session';
        $this->deviceVersion = 'ems_app_device_version';
        $this->appVersion = 'ems_app_device_version_info';
        $this->ambulance = 'ems_ambulance';
        $this->loginType = 'ems_app_login_type';
        $this->ambPilot = 'ems_amb_assign_pilot';
        $this->ambEmt = 'ems_amb_assign_emt';
        $this->incidenceamb = 'ems_incidence_ambulance';
        $this->incidence = 'ems_incidence';
        $this->calls = 'ems_calls';
        $this->callers = 'ems_callers';
        $this->relation = 'ems_mas_relation';
        $this->operateby = 'ems_operateby';
        $this->micnature = 'ems_mas_micnature';
        $this->patientComplaint = "ems_mas_patient_complaint_types";
        $this->hospitalType = 'ems_mas_hospital_type';
        $this->driverParameter = 'ems_driver_parameters';
        $this->patient = 'ems_patient';
        $this->incidencePatient = 'ems_incidence_patient';
        $this->epcr = 'ems_epcr';
        $this->pcr = 'ems_pcr';
        $this->closure = 'ems_ambulance_timestamp_record';
        $this->driverpcr = 'ems_driver_pcr';
        $this->ambulanceStock = 'ems_ambulance_stock';
        $this->interventions = 'ems_interventions';
        $this->pastMedicalHistory = 'ems_past_medical_history';
        $this->inventory = 'ems_inventory';
        $this->invMedicine = "ems_inventory_medicine";
        $this->hospital = 'ems_hospital';
        $this->chiefComplaint = 'ems_mas_patient_complaint_types';
        $this->indentRequest = 'ems_indent_request';
        $this->indentItem = 'ems_indent_item';
        $this->remark = 'ems_app_ambstock_remark';
        $this->equipment = 'ems_inventory_equipment';
        $this->oxyFilling = 'ems_fleet_oxygen_filling';
        $this->fuelfilling = 'ems_fleet_fuel_filling';
        $this->fuelstation = 'ems_fuel_station';
        $this->ambStatus = 'ems_mas_ambulance_status';
        $this->ambStatusSummery = 'ems_ambulance_status_summary';
        $this->district = 'ems_mas_districts';
        $this->offRoadMaintenance = 'ems_amb_onroad_offroad';
        $this->tbl_media = 'ems_media';
        $this->ambReReqHist = 'ems_amb_accidental_maintaince_re_request_history';
        $this->accidentalMainHist = 'ems_amb_accidental_maintaince_history';
        $this->report = 'ems_mas_app_report';
        $this->oxygentStation = 'ems_oxygen_service_center';
        $this->obviousDeathQueAns = 'ems_obvious_death_ques_summary';
        $this->obviousDeathQue = 'ems_obvious_death_questions';
        $this->tyreMaintenance = 'ems_amb_tyre_maintaince';
        $this->accidentalMaintenance = 'ems_amb_accidental_maintaince';
        $this->breakdownMaintenance = 'ems_amb_breakdown_maintaince';
        $this->latlong = 'ems_mas_amb_latlong';
        $this->leave = 'ems_colleague_leave';
        $this->ambtimestamp = 'ems_ambulance_timestamp_record';
        $this->visitor = 'ems_visitor_update';
        $this->traineedemo='ems_fleet_demo_training';
        $this->odometer='ems_ambulance_timestamp_record';
        $this->ambulanceupdate='ems_ambulance';
        $this->clgdocuments='ems_clg_documents';
        $this->preventivemaintenance = 'ems_ambulance_preventive_maintaince';
        $this->feedback = 'ems_feedback_for_app';
        $this->invstock = 'ems_inventory_stock';
        $this->attendance = 'ems_attendance';
        $this->qualitydetails = 'ems_quality_check_details';
        $this->qualitycheck = 'ems_quality_check';
        $this->districtwiseoffroad = 'ems_district_wise_offroad';
    }
    /*
     * Get rows from the users table
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->colleague);
        $this->db->where('clg_ref_id',$params['clg_ref_id']);
        $this->db->where('clg_password',$params['clg_password']);
        $data = $this->db->get()->result_array();
        foreach($data as $data){
            $data['clg_group'] = $this->getTypeID($data['clg_group']);
        }
        return $data;
    }
    function getTypeID($data){
        $data = $this->db->where('gcode',$data)->get('ems_mas_groups')->result_array();
        return $data;
    }
    /* Insert data into login session table */
    function insertData($data){
        $checkLogin = $this->db->where('clg_id',$data['clg_id'])->where('status',1)->get($this->loginSessionTbl)->result_array();
        if(count($checkLogin)==1){
            return 1;
        }else{
            $this->db->insert($this->loginSessionTbl,$data);
        }
    }
    /* Insert data into Device Version table */
    function insertDeviceVersion($data){
        // print_r($data);
        $this->db->insert($this->deviceVersion,$data);
        return $this->db->insert_id();
    }
    /* Update data into Device Version table */
    function updateDeviceVersion($data,$deviceId){
        $checkId = $this->db->where('device_id',$deviceId)->get($this->deviceVersion)->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('device_id',$deviceId)->update($this->deviceVersion,$data);
        }
    }
    function getCurrentversion($osName){
        return $this->db->where('osName',$osName)->get($this->appVersion)->result_array();
    }
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        
        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);
        
        //return the status
        return $insert?$this->db->insert_id():false;
    }
    
    /*
     * Update user data
     */
    public function update($data, $id){
        //add modified date if not exists
        if(!array_key_exists('modified', $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        
        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('id'=>$id));
        
        //return the status
        return $update?true:false;
    }
    
    /*
     * Delete user data
     */
    public function delete($id){
        //update user from users table
        $delete = $this->db->delete('users',array('id'=>$id));
        //return the status
        return $delete?true:false;
    }
    public function getVehicleData($vehicleNumber){
     $data="SELECT *,ward.ward_name as wname FROM ems_ambulance as amb LEFT JOIN ems_mas_ward as ward ON ward.ward_id=amb.ward_name LEFT JOIN ems_hospital as base ON base.hp_id =amb.amb_base_location WHERE amb.amb_rto_register_no= '".$vehicleNumber."' AND amb.ambis_deleted = '0' AND FIND_IN_SET(amb.amb_status,'1,2,3,4,6,8,9,10,12,13') ";
     return $this->db->query($data)->result_array();
    }
    public function insertVehicleOtp($data,$vehicleNumber){
        $this->db->where('amb_rto_register_no',$vehicleNumber)->update($this->ambulance,$data);
    }
    public function getOtp($vehicleNumber){
        return $this->db->where('amb_rto_register_no',$vehicleNumber)->get($this->ambulance)->result_array();
    }
    public function getPilot($vehicleNumber){
        // $this->db->select('amb_id');
        // $this->db->from($this->ambulance);
        // $this->db->where('amb_rto_register_no',$vehicleNumber);
        // $ambId = $this->db->get()->row()->amb_id;

        // $this->db->select('pilot_id');
        // $this->db->from($this->ambPilot);
        // $this->db->where('amb_id',$ambId);
        // $pilotId = $this->db->get()->result_array();

        // $pilotName = array();
        // foreach($pilotId as $pilot){
        //     $data = $this->db->where('clg_id',$pilot['pilot_id'])->get($this->colleague)->result_array();
        //     $pilotJoinName = $data[0]['clg_first_name']. ' '.$data[0]['clg_mid_name'].' '.$data[0]['clg_last_name'];
        //     $pilot_Name = array(
        //         'id' => $data[0]['clg_id'],
        //         'name' => $pilotJoinName
        //     );
        //     array_push($pilotName,$pilot_Name);
        // }
        // return $pilotName;
        $ambdata = "SELECT * FROM ems_ambulance  WHERE amb_rto_register_no  = '$vehicleNumber' ";
        $ambdata1 = $this->db->query($ambdata)->result_array();       
        
        $ambdist =  $ambdata1 [0]['amb_district']; 
        
        $data = $this->db->where('clg_group','UG-PILOT')->where('thirdparty',1)->where('clg_district_id',$ambdist)->where('clg_is_deleted','0')->get($this->colleague)->result_array();
        $pilotName = array();
        foreach($data as $pilot){
            $pilotJoinName = $pilot['clg_first_name']. ' '.$pilot['clg_mid_name'].' '.$pilot['clg_last_name'];
            $pilot_Name = array(
                'id' => $pilot['clg_id'],
                'name' => $pilotJoinName
            );
            array_push($pilotName,$pilot_Name);
        }
        return $pilotName;
    }
    public function getEmt($vehicleNumber){
        // $this->db->select('amb_id');
        // $this->db->from($this->ambulance);
        // $this->db->where('amb_rto_register_no',$vehicleNumber);
        // $ambId = $this->db->get()->row()->amb_id;

        // $this->db->select('emt_id');
        // $this->db->from($this->ambEmt);
        // $this->db->where('amb_id',$ambId);
        // $EmtId = $this->db->get()->result_array();

        // $emtName = array();
        // foreach($EmtId as $Emt){
        //     $data = $this->db->where('clg_id',$Emt['emt_id'])->get($this->colleague)->result_array();
        //     $emtJoinName = $data[0]['clg_first_name']. ' '.$data[0]['clg_mid_name'].' '.$data[0]['clg_last_name'];
        //     $emt_Name = array(
        //         'id' => $data[0]['clg_id'],
        //         'name' => $emtJoinName
        //     );
        //     array_push($emtName,$emt_Name);
        // }
        // return $emtName;
        $ambdata = "SELECT * FROM ems_ambulance  WHERE amb_rto_register_no  = '$vehicleNumber' ";
        $ambdata1 = $this->db->query($ambdata)->result_array();       
        
        $ambdist =  $ambdata1 [0]['amb_district'];       

        $data = $this->db->where('clg_group','UG-EMT')->where('thirdparty',1)->where('clg_district_id',$ambdist)->where('clg_is_deleted','0')->get($this->colleague)->result_array();
        $emtName = array();
        foreach($data as $Emt){
            $emtJoinName = $Emt['clg_first_name']. ' '.$Emt['clg_mid_name'].' '.$Emt['clg_last_name'];
            $emt_Name = array(
                'id' => $Emt['clg_id'],
                'name' => $emtJoinName
            );
            array_push($emtName,$emt_Name);
        }
        return $emtName;
    }
    public function getPilotMobNo($pilotId){
        // print_r($pilotId);
        $this->db->select('clg_mobile_no');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$pilotId);
        return $this->db->get()->row()->clg_mobile_no;
    }
    public function getEmtMobNo($emtId){
        $this->db->select('clg_mobile_no');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$emtId);
        return $this->db->get()->row()->clg_mobile_no;
    }
    public function insertPilotOtp($data,$pilotId){
        $this->db->where('clg_id',$pilotId)->update($this->colleague,$data);
    }
    public function insertEmtOtp($data,$emtId){
        $this->db->where('clg_id',$emtId)->update($this->colleague,$data);
    }
    public function insertuserOtp($data,$userId){
        $this->db->where('clg_ref_id',$userId)->update($this->colleague,$data);
    }
    public function updateOtp($vehicleNumber,$data){
        $this->db->where('amb_rto_register_no',$vehicleNumber)->update($this->ambulance,$data);
    }
    public function getPilotOtp($pilotId){
        return $this->db->where('clg_id',$pilotId)->get($this->colleague)->result_array();
    }
    public function getuserOtp($userdata){
        return $this->db->where('clg_id',$userdata)->get($this->colleague)->result_array();   
    }
    public function updatepilotOtp($pilotId,$data){
        $this->db->where('clg_id',$pilotId)->update($this->colleague,$data);
    }
    public function getEmtOtp($emtId){
        return $this->db->where('clg_id',$emtId)->get($this->colleague)->result_array();
    }
    public function updateemtOtp($emtId,$data){
        $this->db->where('clg_id',$emtId)->update($this->colleague,$data);
    }
    public function insertLoginData($data1){
        $this->db->insert($this->loginSessionTbl,$data1);
    }
    public function checkLogin($vehicleNumber){
        $loginData = $this->db->where('vehicle_no',$vehicleNumber)->where('status',1)->get($this->loginSessionTbl)->result_array();
        if(count($loginData) == 2){
            return 2;
        }else{
            return $loginData;
        }
        // $both = array();
        // if(count($loginData)==2){
        //     foreach($loginData as $loginData1){
        //         if($loginData1['type_id'] == 3){
        //             array.push($both,$loginData1);
        //             return 3;
        //         }
        //     }
        // }
        // if((count($loginData) == 2) && ($loginData['type_id'] == 1) && ($loginData['type_id'] == 2)){
        //     print_r('Already login');
        // }else if((count($loginData) == 1)){

        // }
    }
    public function loginCheckPilotEmt($vehicleNumber){
        return $this->db->where('vehicle_no',$vehicleNumber)->where('status',1)->get($this->loginSessionTbl)->result_array();
        // if(count($data1) == 2){
        //     foreach($data1 as $login){
        //         if($login['type_id'] == 1){
        //             return 'D';
        //         }else if($login['type_id'] == 2){
        //             return 'E';
        //         }else{
        //             return 'B';
        //         }
        //     }
        // }else if(count($data1) == 1){
        //     foreach($data1 as $login){
        //         if($login['type_id'] == 1){
        //             return 'D';
        //         }else if($login['type_id'] == 2){
        //             return 'E';
        //         }
        //     }
        // }
        // $data = $this->db->where('vehicle_no',$vehicleNumber)->where('type_id',$typeId)->where('status',1)->get($this->loginSessionTbl)->result_array();
        // if(!empty($data)){
        //     return 1;
        // }else{
        //     return 2;
        // }
    }
    public function checkPilot($data){
        // return $this->db->where('clg_id',$pilotId)->where('status',1)->get($this->loginSessionTbl)->result_array();
        $pilot = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['pilotId']."' || loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
        return  $this->db->query($pilot)->result_array(); 
    }
    public function checkEmt($data){
        // return $this->db->where('clg_id',$emtId)->where('status',1)->get($this->loginSessionTbl)->result_array();
        $pilot = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['emtId']."' || loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
        return  $this->db->query($pilot)->result_array();
    }
    public function checkBoth($vehicleNumber){
        $data =  $this->db->where('vehicle_no',$vehicleNumber)->where('status',1)->get($this->loginSessionTbl)->result_array();
        if(count($data) == 2){
            return 2;
        }else if(empty($data)){
            return null;
        }else{
            return $data;
        }
    }
    public function getotpcount($id){
        $this->db->select('otp_count');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$id);
        return $this->db->get()->row()->otp_count;
    }
    public function getemtotpcount($emtId){
        $this->db->select('otp_count');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$emtId);
        return $this->db->get()->row()->otp_count;
    }
    public function insertOtpCount($data,$id){
        $this->db->where('clg_id',$id)->update($this->colleague,$data);
    }
     public function insertEmtOtpCount($emtdata,$id){
        $this->db->where('clg_id',$id)->update($this->colleague,$emtdata);
    }
    public function emptydata($id,$emptydata){
        $this->db->where('clg_id',$id)->update($this->colleague,$emptydata);
    }
    public function emptyemtdata($emtId,$emptydata){
        $this->db->where('clg_id',$emtId)->update($this->colleague,$emptydata); 
    }
    public function getCompIncidence($ambno,$loginId){
        $data = "SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.* " 
                . "FROM $this->incidenceamb AS incamb "
                . "LEFT JOIN $this->driverParameter AS para ON (para.incident_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->calls AS cls ON (cls.cl_id = inc.inc_cl_id) "
                . "LEFT JOIN $this->callers AS clr ON (clr.clr_id = cls.cl_clr_id) "
                . "LEFT JOIN $this->relation AS rel ON (cls.clr_ralation = rel.rel_id) "
                . "LEFT JOIN $this->operateby AS op ON ( op.sub_id = inc.inc_ref_id ) "
                . "LEFT JOIN $this->micnature as mn on(mn.ntr_id=inc.inc_mci_nature) "
                . "LEFT JOIN $this->patientComplaint as pc on(pc.ct_id=inc.inc_complaint) "
                . "WHERE incamb.amb_rto_register_no = '".$ambno."' AND inc.inc_pcr_status = '1' "
                . "GROUP BY inc.inc_ref_id "
                . "ORDER BY inc.inc_ref_id DESC LIMIT 2;";
                // . "WHERE (".$loginId." IN (para.with_partner) || ".$loginId." IN (para.start_fr_bs_loc_id) || ".$loginId." IN (para.at_scene_id) || ".$loginId." IN (para.from_scene_id) || ".$loginId." IN (para.at_hosp_id) || ".$loginId." IN (para.patient_hand_id) || ".$loginId." IN (para.back_to_bs_loc_id) || incamb.amb_rto_register_no = '".$ambno."') AND inc.inc_pcr_status = '1' "
                // . "AND inc.modify_date_sync >= DATE(NOW()) - INTERVAL 1 DAY "
                // . "GROUP BY inc.inc_ref_id "
                // . "ORDER BY inc.inc_ref_id DESC;";
        $compIncidentRec = $this->db->query($data)->result_array();
       //  print_r($data);die;
        // print_r($compIncidentRec);die;
        $recordData = array();
        foreach($compIncidentRec as $record){
            $datetime = new DateTime($record['inc_datetime']);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i:s');
            $recordData1['callerName'] = $record['clr_fname']." ".$record['clr_mname']." ".$record['clr_lname'];
            $recordData1['callerMob'] = (float) $record['clr_mobile'];
            $recordData1['incidentId'] = $record['inc_ref_id'];
            $recordData1['incidentDate'] = $date;
            $recordData1['incidentTime'] = $time;
            if($record['inc_type'] == 'MCI'){
                $recordData1['cheifComplaint'] = $record['ntr_nature'];
            }else{
                $recordData1['cheifComplaint'] = $record['ct_type'];
            }
            $recordData1['incidentAddress'] = $record['inc_address'];
            $recordData1['lat'] = (float) $record['inc_lat'];
            $recordData1['long'] = (float) $record['inc_long'];
            $recordData1['incidentPincode'] = $record['inc_pincode'];
            $recordData1['CallerRelationName'] = $record['rel_name'];
            if($record['inc_pcr_status']==1){
                $recordData1['incidentCallsStatus'] = 'Completed';
            }
            array_push($recordData,$recordData1);
        }
        return $recordData;
    }
    public function assignedIncidenceCalls($ambno){
        $data = "SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,hosp.*" 
                ."FROM $this->incidenceamb AS incamb "
                ."LEFT JOIN $this->incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->calls AS cls ON (cls.cl_id = inc.inc_cl_id) "
                . "LEFT JOIN $this->callers AS clr ON (clr.clr_id = cls.cl_clr_id) "
                . "LEFT JOIN $this->relation AS rel ON (cls.clr_ralation = rel.rel_id) "
                . "LEFT JOIN $this->operateby AS op ON ( op.sub_id = inc.inc_ref_id ) "
                . "LEFT JOIN $this->micnature as mn on(mn.ntr_id=inc.inc_mci_nature) "
                . "LEFT JOIN $this->patientComplaint as pc on(pc.ct_id=inc.inc_complaint) "
                . "LEFT JOIN $this->hospital as hosp on(inc.hospital_id=hosp.hp_id) "
                . "WHERE incamb.amb_rto_register_no = '".$ambno."' AND inc.inc_pcr_status = '0' "
                . "GROUP BY inc.inc_ref_id";
        $compIncidentRec = $this->db->query($data)->result_array();
        $recordData = array();
        $j = 0;
        foreach($compIncidentRec as $record){
            $service = explode(',',$compIncidentRec[0]['ntr_services']);
            $sr = array();
            for ($i=0; $i < count($service); $i++) { 
                $serv = $this->getServices($service[$i]);
                array_push($sr,$serv);
            }
            $vehicleData = $this->getVehicleData($ambno);
            
            if($vehicleData[0]['thirdparty'] == 1){
                if($j == 0) {
                    // print_r($record['accept_incident_id']);die;
                    if($record['accept_incident_id'] == 'accepted'){
                        $recordData1['clikable'] = 'true';
                        $recordData1['progress'] = 'true';
                        $recordData1['completed'] = 'false';
                        $recordData1['incidentCallsStatus'] = 'In-progress';
                        $recordData1['chkForLogout'] = 'true';
                    }else{
                        $recordData1['clikable'] = 'true';
                        $recordData1['progress'] = 'false';
                        $recordData1['completed'] = 'false';
                        $recordData1['incidentCallsStatus'] = 'Pending';
                        $recordData1['chkForLogout'] = 'false';
                    }
                }else{
                    $recordData1['clikable'] = 'false';
                    $recordData1['progress'] = 'false';
                    $recordData1['completed'] = 'false';
                    $recordData1['incidentCallsStatus'] = 'Pending';
                    $recordData1['chkForLogout'] = 'false';
                }
            }else{
                if($record['accept_incident_id'] == 'accepted'){
                        $recordData1['clikable'] = 'true';
                        $recordData1['progress'] = 'true';
                        $recordData1['completed'] = 'false';
                        $recordData1['incidentCallsStatus'] = 'In-progress';
                        $recordData1['chkForLogout'] = 'true';
                }else{
                    $recordData1['clikable'] = 'true';
                    $recordData1['progress'] = 'false';
                    $recordData1['completed'] = 'false';
                    $recordData1['incidentCallsStatus'] = 'Pending';
                    $recordData1['chkForLogout'] = 'false';
                }
            }
            
            $services = implode(',',$sr);
            $datetime = new DateTime($record['inc_datetime']);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i:s');
            $recordData1['callerName'] = $record['clr_fname']." ".$record['clr_mname']." ".$record['clr_lname'];
            $recordData1['callerMob'] = (float) $record['clr_mobile'];
            $recordData1['incidentId'] = $record['inc_ref_id'];
            $recordData1['incidentDate'] = $date;
            $recordData1['incidentTime'] = $time;
            $recordData1['incidentPatientCount'] = (int) $record['inc_patient_cnt'];
            if($record['inc_type'] == 'MCI'){
                $recordData1['cheifComplaint'] = $record['ntr_nature'];
            }else{
                $recordData1['cheifComplaint'] = $record['ct_type'];
            }
            if($record['inc_pcr_status']==0){
                $recordData1['incidentStatus'] = 'Received';
            }else{
                $recordData1['incidentStatus'] = 'Completed';
            }
            $recordData1['incidentAddress'] = $record['inc_address'];
            $recordData1['lat'] = (float) $record['inc_lat'];
            $recordData1['long'] = (float) $record['inc_long'];
            $recordData1['incidentPincode'] = (float) $record['inc_pincode'];
            $recordData1['CallerRelationName'] = $record['rel_name'];
            $recordData1['Services'] = $services;
            // 'hospitalFlag' : if selected hospital with other 'true' and not selected 'false'
            if(empty($record['hospital_id']) && empty($record['hospital_name'])){
                $recordData1['hospitalFlag'] = 'false';
                $recordData1['hospitalName'] = null;
                $recordData1['hospitalAddress'] = null;
                $recordData1['hospitalLat'] = null;
                $recordData1['hospitalLong'] = null;
            }else if(!empty($record['hospital_id'])){
                $recordData1['hospitalFlag'] = 'true';
                $recordData1['hospitalName'] = $record['hp_name'];
                $recordData1['hospitalAddress'] = $record['hp_address'];
                $recordData1['hospitalLat'] = (float) $record['hp_lat'];
                $recordData1['hospitalLong'] = (float) $record['hp_long'];
            }else{
                $recordData1['hospitalFlag'] = 'true';
                $recordData1['hospitalName'] = $record['hospital_name'];
                $recordData1['hospitalAddress'] = $record['hospital_address'];
                $recordData1['hospitalLat'] = null;
                $recordData1['hospitalLong'] = null;
            }
            array_push($recordData,$recordData1);
            $j++;
        }
        return $recordData;
    }
    public function getServices($id){
        if(!empty($id)){
            $this->db->select('srv_name');
            $this->db->from('ems_mas_services');
            $this->db->where('srv_id',$id);
            return $this->db->get()->row()->srv_name;
        }
    }
    public function StateDisHospitalIncidentID($hosp){
        $incidentId = $hosp['incidentId'];
        // $allList = $hosp['allList'];
        $district = $hosp['district'];
        $hospital = array();
        if(!empty($hosp['hospitalType']) && $hosp['hospitalType'] != 'all'){
            $this->db->select('hosp_id');
            $this->db->from($this->hospitalType);
            $this->db->where('hosp_type',$hosp['hospitalType']);
            $hp_type =  $this->db->get()->row()->hosp_id;
        }
        if(empty($hosp['hospitalType'])){
            $data = "SELECT inc.*,hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital1` As hosp ON (inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '".$incidentId."' limit 50 ";
            $hosp_list = $this->db->query($data)->result_array();
        }else if(!empty($hosp['hospitalType']) && empty($hosp['district'])){
            if($hosp['hospitalType'] == 'all'){
                $data = "SELECT inc.*,hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital1` As hosp ON (inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '".$incidentId."' limit 50 ";
                $hosp_list = $this->db->query($data)->result_array();
            }else{
                $data = "SELECT inc.*,hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital1` As hosp ON (inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '".$incidentId."' AND hosp.hp_type = '$hp_type' limit 50 ";
                $hosp_list = $this->db->query($data)->result_array();
            }
        }else if(!empty($hosp['district']) && !empty($hosp['hospitalType'])){
            if($hosp['hospitalType'] == 'all'){
                $data = "SELECT hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_hospital1` As hosp "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE hosp.`hp_district` = '$district' limit 50 ";
                $hosp_list = $this->db->query($data)->result_array();
            }else{
                $data = "SELECT hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_hospital1` As hosp "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE hosp.`hp_district` = '$district' AND hosp.hp_type = '$hp_type' limit 50 ";
                $hosp_list = $this->db->query($data)->result_array();
            }
        }
        foreach($hosp_list as $hosp_list1){
            $hosp1['hospId'] = (int) $hosp_list1['hp_id'];
            $hosp1['hospName'] = $hosp_list1['hp_name'];
            $hosp1['hospLat'] = (float) $hosp_list1['hp_lat'];
            $hosp1['hospLong'] = (float) $hosp_list1['hp_long'];
            $hosp1['hospAddress'] = $hosp_list1['hp_address'];
            $hosp1['hospArea'] = $hosp_list1['hp_area'];
            $hosp1['hospCityName'] = $hosp_list1['cty_name'];
            $hosp1['hospDistrict'] = $hosp_list1['dst_name'];
            $hosp1['hospTahsil'] = $hosp_list1['thl_name'];
            array_push($hospital,$hosp1);
        }
        // print_r($hospital);
        return $hospital;
        
        // $this->db->select('hosp_id');
        // $this->db->from($this->hospitalType);
        // $this->db->where('hosp_type',$hosp['hospitalType']);
        // $hp_type =  $this->db->get()->row()->hosp_id;
        // $incidentId = $hosp['incidentId'];
        // $allList = $hosp['allList'];
        // $hosp = array();
        // if($allList == 1){
        //     $data = "SELECT inc.*,hosp.*,st.st_name,dis.dst_name,tah.thl_name,city.cty_name"
        //         ." FROM `ems_incidence` As inc "
        //         ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_state_id = hosp.hp_state) "
        //         ."LEFT JOIN `ems_mas_states` As st ON (hosp.hp_state = st.st_code) "
        //         ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code AND inc.inc_state_id = dis.dst_state) "
        //         ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
        //         ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
        //         ."WHERE inc.`inc_ref_id` = '$incidentId' AND hosp.hp_type = '$hp_type' ";
        //     $hosp_list = $this->db->query($data)->result_array();
        // }else{
        //     $data = "SELECT inc.*,hosp.*,st.st_name,dis.dst_name,tah.thl_name,city.cty_name"
        //         ." FROM `ems_incidence` As inc "
        //         ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_state_id = hosp.hp_state AND inc.inc_district_id = hosp.hp_district) "
        //         ."LEFT JOIN `ems_mas_states` As st ON (hosp.hp_state = st.st_code) "
        //         ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code AND inc.inc_state_id = dis.dst_state) "
        //         ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
        //         ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
        //         ."WHERE inc.`inc_ref_id` = '$incidentId' AND hosp.hp_type = '$hp_type' ";
        //     $hosp_list = $this->db->query($data)->result_array();
        // }
        // foreach($hosp_list as $hosp_list1){
        //     $hosp1['hospId'] = (int) $hosp_list1['hp_id'];
        //     $hosp1['hospName'] = $hosp_list1['hp_name'];
        //     $hosp1['hospLat'] = (float) $hosp_list1['hp_lat'];
        //     $hosp1['hospLong'] = (float) $hosp_list1['hp_long'];
        //     $hosp1['hospAddress'] = $hosp_list1['hp_address'];
        //     $hosp1['hospArea'] = $hosp_list1['hp_area'];
        //     $hosp1['hospCityName'] = $hosp_list1['cty_name'];
        //     $hosp1['hospState'] = $hosp_list1['st_name'];
        //     $hosp1['hospDistrict'] = $hosp_list1['dst_name'];
        //     $hosp1['hospTahsil'] = $hosp_list1['thl_name'];
        //     array_push($hosp,$hosp1);
        // }
        // return $hosp;
    }
    public function logout($id,$type){
        if($type == 1){
            $data = $this->db->where('status','1')->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        }else if($type == 2){
            $data = $this->db->where('status','1')->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        }else if($type == 4){
            $data = $this->db->where('status','1')->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        }else{
            $data = $this->db->where('status','1')->where('vehicle_no',$id)->get($this->loginSessionTbl)->result_array();
        }
        foreach($data as $data1){
            $logout['status'] = 2;
            $logout['logout_time'] = date('Y-m-d H:i:s');
            $this->db->where('status','1')->where('clg_id',$data1['clg_id'])->update($this->loginSessionTbl,$logout);
        }
        return 1;
    }
    public function updateDriverParameters($para1){
        $this->db->where('incident_id',$para1['incident_id'])->update($this->driverParameter,$para1);
        $data = $this->db->where('incident_id',$para1['incident_id'])->get('ems_driver_parameters')->result_array();
        return $data[0]['parameter_count'];
    }
    public function InsertDriverParameters($para1){
        $this->db->insert($this->driverParameter,$para1);
        $data = $this->db->where('incident_id',$para1['incident_id'])->get('ems_driver_parameters')->result_array();
        return $data[0]['parameter_count'];
    }
    public function addDriverParameters($data){
        // print_r($data);
        return $this->db->where('incident_id',$data['incidentId'])->get('ems_driver_parameters')->result_array();
        if($data['parametersType'] == 1){
            $incidentCount = $this->db->where('incident_id',$data['incidenId'])->get('ems_driver_parameters')->result_array();
            $para['incident_id'] = $data['incidenId'];
            $para['amb_no'] = $data['ambno'];
            $para['parameter_count'] = $data['parametersType'] + 1;
            $para['start_from_base_loc'] = $data['dateTime'];
            $para['start_fr_bs_loc_emt'] = $data['emtId'];
            $para['start_fr_bs_loc_pilot'] = $data['pilotId'];
            if(count($incidentCount)==1){
                return 0;
            }else{
                $this->db->insert($this->driverParameter,$para);
                return 2;
            }
        }else if($data['parametersType'] == 2){
            $incidentCount = $this->db->where('incident_id',$data['incidenId'])->where('at_scene',null)->get('ems_driver_parameters')->result_array();
            $para['at_scene'] = $data['dateTime'];
            $para['parameter_count'] = $data['parametersType'] + 1;
            $para['at_scene_emt'] = $data['emtId'];
            $para['at_scene_pilot'] = $data['pilotId'];
            if(!empty($incidentCount)){
                $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
                return 3;
            }else{
                return $count[0]['parameter_count'];
            }
        }
        else if($data['parametersType'] == 3){
            $para['from_scene'] = $data['dateTime'];
            $para['from_scene_emt'] = $data['emtId'];
            $para['from_scene_pilot'] = $data['pilotId'];
            $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
            return 4;
        }
        else if($data['parametersType'] == 4){
            $para['from_scene'] = $data['dateTime'];
            $para['from_scene_emt'] = $data['emtId'];
            $para['from_scene_pilot'] = $data['pilotId'];
            $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
            return 5;
        }
        else if($data['parametersType'] == 5){
            $para['from_scene'] = $data['dateTime'];
            $para['from_scene_emt'] = $data['emtId'];
            $para['from_scene_pilot'] = $data['pilotId'];
            $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
            return 6;
        }
        else if($data['parametersType'] == 6){
            $para['from_scene'] = $data['dateTime'];
            $para['from_scene_emt'] = $data['emtId'];
            $para['from_scene_pilot'] = $data['pilotId'];
            $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
            return 7;
        }
        // else if($data['parametersType'] == 2){
        //     $incidentCount = $this->db->where('incident_id',$data['incidenId'])->where('at_scene',null)->get('ems_driver_parameters')->result_array();
        //     $para['`at_scene`'] = $data['dateTime'];
        //     $para['at_scene_emt'] = $data['emtId'];
        //     $para['at_scene_pilot'] = $data['pilotId'];
        //     if(count($incidentCount) == 1){
        //         $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
        //     }else{
        //         return 2;
        //     }
        // }
        // else if($data['parametersType'] == 3){
        //     $incidentCount = $this->db->where('incident_id',$data['incidenId'])->where('from_scene',null)->get('ems_driver_parameters')->result_array();
        //     $para['from_scene'] = $data['dateTime'];
        //     $para['from_scene_emt'] = $data['emtId'];
        //     $para['from_scene_pilot'] = $data['pilotId'];
        //     if(count($incidentCount) == 1){
        //         $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
        //     }else{
        //         return 3;
        //     }  
        // }
        // else if($data['parametersType'] == 4){
        //     $incidentCount = $this->db->where('incident_id',$data['incidenId'])->where('at_hospital',null)->get('ems_driver_parameters')->result_array();
        //     $para['at_hospital'] = $data['dateTime'];
        //     $para['at_hosp_emt'] = $data['emtId'];
        //     $para['at_hosp_pilot'] = $data['pilotId'];
        //     if(count($incidentCount) == 1){
        //         $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
        //     }else{
        //         return 4;

        //     } 
        // }
        // else if($data['parametersType'] == 5){
        //     $incidentCount = $this->db->where('incident_id',$data['incidenId'])->where('patient_handover',null)->get('ems_driver_parameters')->result_array();
        //     $para['patient_handover'] = $data['dateTime'];
        //     $para['patient_hand_emt'] = $data['emtId'];
        //     $para['patient_hand_pilot'] = $data['pilotId'];
        //     if(count($incidentCount) == 1){
        //         $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
        //     }else{
        //         return 5;
        //     } 
        // }
        // else if($data['parametersType'] == 6){
        //     $incidentCount = $this->db->where('incident_id',$data['incidenId'])->where('back_to_base_loc',null)->get('ems_driver_parameters')->result_array();
            
        //     $para['back_to_base_loc'] = $data['dateTime'];
        //     $para['back_to_bs_loc_emt'] = $data['emtId'];
        //     $para['back_to_bs_loc_pilot'] = $data['pilotId'];
        //     if(count($incidentCount) == 1){
        //         $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
        //     }else{
        //         return 6;
        //     } 
        // }
    } 
    public function addOtherHospital($incidentid,$data){
        $incidentcount = $this->db->where('inc_ref_id',$incidentid)->get($this->incidence)->result_array();
        if(!empty($incidentcount)){
            $this->db->where('inc_ref_id',$incidentid)->update($this->incidence,$data);
            return 1; 
        }else{
            return 2;
        }     
    }
    public function getId($id,$type){
        if($type == 1){
            $data = $this->db->where('clg_id',$id)->where('status',1)->get($this->loginSessionTbl)->result_array();
            if(empty($data)){
                return 1;
            }else{
                $ambNo = $data[0]['vehicle_no'];
                $login = $this->db->where('vehicle_no',$ambNo)->get($this->loginSessionTbl)->result_array();
                $a = array();
                for($i=0;$i<count($login);$i++){
                    if($login[$i]['clg_id'] == $id){
                    }else{
                        array_push($a,$login[$i]);
                    }
                }
                $data1['login_type'] = $data[0]['login_type'];
                $data1['id'] = $data[0]['clg_id'];
                $data1['vehicle_no'] = $data[0]['vehicle_no'];
                if(!empty($a)){
                    $data1['login_with_partner'] = $a[0]['clg_id'];
                }else{
                    $data1['login_with_partner'] = null;
                }
                return $data1;
            }
        }else if($type == 2){
            $data = $this->db->where('clg_id',$id)->where('status',1)->get($this->loginSessionTbl)->result_array();
            if(empty($data)){
                return 1;
            }else{
                $ambNo = $data[0]['vehicle_no'];
                $login = $this->db->where('vehicle_no',$ambNo)->get($this->loginSessionTbl)->result_array();
                $a = array();
                for($i=0;$i<count($login);$i++){
                    if($login[$i]['clg_id'] == $id){
                    }else{
                        array_push($a,$login[$i]);
                    }
                }
                $data1['login_type'] = $data[0]['login_type'];
                $data1['id'] = $data[0]['clg_id'];
                $data1['vehicle_no'] = $data[0]['vehicle_no'];
                if(!empty($a)){
                    $data1['login_with_partner'] = $a[0]['clg_id'];
                }else{
                    $data1['login_with_partner'] = null;
                }
                
                return $data1;
            }
        }else{
            $this->db->select('*');
            $this->db->from($this->loginSessionTbl);
            $this->db->where('vehicle_no',$id);
            $this->db->where('status',1);
            $data = $this->db->get()->result_array();
            if(empty($data)){
                $data2['id'] = '';
                $data2['vehicle_no'] = '';
                return $data2;
            }else{
                $id = array();
                $loginType = array();
                foreach($data as $data1){
                    array_push($id,$data1['clg_id']);
                    array_push($loginType,$data1['login_type']);
                }
                $data2['login_type'] = implode(',',$loginType);
                $data2['id'] = implode(',',$id);
                $data2['vehicle_no'] = $data[0]['vehicle_no'];
                $data2['login_with_partner'] = implode(',',$id);
                return $data2;
            } 
        }
        // if($type == 1){
        //     $data = $this->db->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        //     if(empty($data)){
        //         return 1;
        //     }else{
        //         $data1['id'] = $data[0]['clg_id'];
        //         $data1['vehicle_no'] = $data[0]['vehicle_no'];
        //         return $data1;
        //     }
        // }else if($type == 2){
        //     $data = $this->db->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        //     if(empty($data)){
        //         return 1;
        //     }else{
        //         $data1['id'] = $data[0]['clg_id'];
        //         $data1['vehicle_no'] = $data[0]['vehicle_no'];
        //         return $data1;
        //     }
        // }else{
        //     $this->db->select('*');
        //     $this->db->from($this->loginSessionTbl);
        //     $this->db->where('vehicle_no',$id);
        //     $this->db->where('status',1);
        //     $data = $this->db->get()->result_array();
        //     $id = array();
        //     foreach($data as $data1){
        //         array_push($id,$data1['clg_id']);
        //     }
        //     if(empty($data)){
        //         return 1;
        //     }else{
        //         $data2['id'] = implode(',',$id);
        //         $data2['vehicle_no'] = $data[0]['vehicle_no'];
        //         return $data2;
        //     } 
        // }
    }
    public function addPatient($data){
        $this->db->insert($this->patient,$data);
        return $this->db->insert_id();
    }
    public function insertIncidencePatient($incPat){
        $this->db->insert($this->incidencePatient,$incPat);
        return $this->db->insert_id();
    }
    public function getPatientInfo($PatientId){
        return  $this->db->where('ptn_id',$PatientId)->get($this->patient)->result_array();
    }
    public function getPatientDetails($incidentId){
        $incPtnId = $this->db->where('inc_id',$incidentId)->get($this->incidencePatient)->result_array();
        $ptn = array();
        $pt1 = array(); 
        foreach($incPtnId as $incPtnId1){
            $patient = array(
                'id' => $incPtnId1['ptn_id']
            );
            array_push($ptn,$patient);
            $id = $patient['id'];
            $data1 = "SELECT ptn.*,epcr.initial_complete,epcr.ongoing_complete,epcr.handover_cond_complete,epcr.handover_issue_complete,epcr.medicine_complete,epcr.consumable_complete,epcr.pat_com_to_hosp,epcr.pat_com_to_hosp,epcr.pat_com_to_hosp_reason,epcr.pat_com_to_hosp_reason_other,ptnreason.id,ptnreason.reason "
                    ."FROM `ems_patient` AS ptn "
                    ."LEFT JOIN `ems_epcr` AS epcr ON (ptn.ptn_id = epcr.ptn_id) "
                    ."LEFT JOIN `ems_patient_notcomtohosp_reason` AS ptnreason ON (epcr.pat_com_to_hosp_reason = ptnreason.id) "
                    ."WHERE ptn.ptn_id = '$id' ";
            // $data = $this->db->where('ptn_id',$patient['id'])->get($this->patient)->result_array();
            $data = $this->db->query($data1)->result_array();
            // print_r($data);die;
            foreach($data as $ptn1){
                if(($ptn1['pat_com_to_hosp'] == '1') || ($ptn1['initial_complete'] == '1') && ($ptn1['ongoing_complete'] == '1') && ($ptn1['handover_cond_complete'] == '1') && ($ptn1['handover_issue_complete'] == '1')){
                    // (($ptn1['pat_com_to_hosp'] == '1') || ($ptn1['initial_complete'] == '1') && ($ptn1['ongoing_complete'] == '1') && ($ptn1['handover_cond_complete'] == '1') && ($ptn1['handover_issue_complete'] == '1') && ($ptn1['medicine_complete'] == '1') && ($ptn1['consumable_complete'] == '1'))
                    $patientCompleteInfo = 1;
                    $flag = 'true';
                }else{
                    $patientCompleteInfo = 0;
                    $flag = 'false';
                }
                if($ptn1['pat_com_to_hosp'] == '0'){
                    $patientComToHosp = 0;
                }else if($ptn1['pat_com_to_hosp'] == '1'){
                    $patientComToHosp = 1;
                }else{
                    $patientComToHosp = -1;
                }
                if($ptn1['initial_complete'] == '0'){
                    $initial_complete = 0;
                }else if($ptn1['initial_complete'] == '1'){
                    $initial_complete = 1;
                }else{
                    $initial_complete = -1;
                }
                if($ptn1['ongoing_complete'] == '0'){
                    $ongoing_complete = 0;
                }else if($ptn1['ongoing_complete'] == '1'){
                    $ongoing_complete = 1;
                }else{
                    $ongoing_complete = -1;
                }
                if($ptn1['handover_cond_complete'] == '0'){
                    $handover_cond_complete = 0;
                }else if($ptn1['handover_cond_complete'] == '1'){
                    $handover_cond_complete = 1;
                }else{
                    $handover_cond_complete = -1;
                }
                if($ptn1['handover_issue_complete'] == '0'){
                    $handover_issue_complete = 0;
                }else if($ptn1['handover_issue_complete'] == '1'){
                    $handover_issue_complete = 1;
                }else{
                    $handover_issue_complete = -1;
                }
                if($ptn1['medicine_complete'] == '0'){
                    $medicine_complete = 0;
                }else if($ptn1['medicine_complete'] == '1'){
                    $medicine_complete = 1;
                }else{
                    $medicine_complete = -1;
                }
                if($ptn1['consumable_complete'] == '0'){
                    $consumable_complete = 0;
                }else if($ptn1['consumable_complete'] == '1'){
                    $consumable_complete = 1;
                }else{
                    $consumable_complete = -1;
                }
                if((empty($ptn1['pat_com_to_hosp_reason'])) && (!empty($ptn1['pat_com_to_hosp_reason_other']))){
                    $otherSelected = true;
                    $other = $ptn1['pat_com_to_hosp_reason_other'];
                }else{
                    $otherSelected = false;
                    $other = null;
                }
                $patientDetails = array(
                    'id' => (float) $ptn1['ptn_id'],
                    'firstName' => $ptn1['ptn_fname'],
                    'middleName' => $ptn1['ptn_mname'],
                    'lastName' => $ptn1['ptn_lname'],
                    'gender' => $ptn1['ptn_gender'],
                    'age' => (int) $ptn1['ptn_age'] == "" ? null : (int) $ptn1['ptn_age'],
                    'bloodGroup' => $ptn1['ptn_bgroup'],
                    'patientCompleteInfo' => $patientCompleteInfo,
                    'patientCompleteInfoFlag' => $flag,
                    'patientComToHosp' => (int) $patientComToHosp,
                    'patientComToHospRes' => ([
                        'id' => (int) $ptn1['id'],
                       'name' =>  $ptn1['reason'],
                       'otherSelected' => $otherSelected,
                        'other' => $other
                    ]),
                    'initial_complete' => (int) $initial_complete,
                    
                    'ongoing_complete' => (int) $ongoing_complete,
                    'handover_cond_complete' => (int) $handover_cond_complete,
                    'handover_issue_complete' => (int) $handover_issue_complete,
                    'medicine_complete' => (int) $medicine_complete,
                    'consumable_complete' => (int) $consumable_complete
                );
                array_push($pt1,$patientDetails);
            }
        }
        return $pt1;
    }
    public function getIncidentData($incidentID){
        return $this->db->where('inc_ref_id',$incidentID)->get($this->incidence)->result_array();
    }
    
    
    
    public function getUserLogin($id,$type){
        if($type == 1){
            $data = "SELECT lg.*,clg.* "
                ."FROM `ems_app_login_session` As lg "
                ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
                ."WHERE lg.type_id = '$type' AND lg.status = '1' AND lg.clg_id = '$id' ";
            $loginData = $this->db->query($data)->result_array();
            return $loginData;
        }else if($type == 2){
            $data = "SELECT lg.*,clg.* "
                    ."FROM `ems_app_login_session` As lg "
                    ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
                    ."WHERE lg.type_id = '$type' AND lg.status = '1' AND lg.clg_id = '$id' ";
            $loginData = $this->db->query($data)->result_array();
            return $loginData;
        }elseif($type == 4){
             $data = "SELECT lg.*,clg.* "
                    ."FROM `ems_app_login_session` As lg "
                    ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
                    ."WHERE lg.type_id = '$type' AND lg.status = '1' AND lg.clg_id = '$id' ";
            $loginData = $this->db->query($data)->result_array();
            return $loginData;
            
        }else{
            $data = "SELECT lg.*,clg.* "
            ."FROM `ems_app_login_session` As lg "
            ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
            ."WHERE lg.type_id = '$type' AND lg.status = '1' AND lg.vehicle_no = '$id' ";
            $loginData = $this->db->query($data)->result_array();
            return $loginData;
        }  
    }
    public function insertPatientData($epcr){
        $this->db->insert($this->epcr,$epcr);
        return 1;
    }
    public function getCurrentstatus($data){
        return $this->db->where('incident_id',$data)->get($this->driverParameter)->result_array();
    }
    public function editPatient($data,$patientId){
        $this->db->where('ptn_id',$patientId)->update($this->patient,$data);
        return 1;
    }
    public function getPatientMedInfo($patientId){
        $data = "SELECT epcr.*,ptn.*,dst.*,thl.*,city.*,loc.*,proimp.*,ptnres.reason "
                ."FROM `ems_epcr` AS epcr "
                ."LEFT JOIN `ems_patient` As ptn ON (ptn.ptn_id = epcr.ptn_id) "
                ."LEFT JOIN `ems_mas_districts` As dst ON (epcr.district_id = dst.dst_code AND dst.dstis_deleted = '0') "
                ."LEFT JOIN `ems_mas_tahshil` As thl ON (epcr.tahsil_id = thl.thl_code AND epcr.district_id = thl.thl_district_code AND thl.thlis_deleted = '0') "
                ."LEFT JOIN `ems_mas_city` As city ON (epcr.city_id = city.cty_id AND epcr.district_id = city.cty_dist_code AND epcr.district_id = city.cty_thshil_code AND city.ctyis_deleted = '0') "
                ."LEFT JOIN `ems_mas_loc_level` AS loc ON (epcr.loc = loc.level_id AND loc.levelis_deleted = '0') "
                ."LEFT JOIN `ems_mas_provider_imp` AS proimp ON (epcr.provider_impressions = proimp.pro_id AND proimp.pro_status = '1' AND proimp.prois_deleted = '0')"
                ."LEFT JOIN `ems_patient_notcomtohosp_reason` AS ptnres ON (epcr.pat_com_to_hosp_reason = ptnres.id AND ptnres.deleted = '0') "
                ."WHERE epcr.ptn_id = '$patientId' " ;
        $rec = $this->db->query($data)->result_array();
        return $rec;
    }
    public function editPatientData($patientData,$patientId){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$patientData);
        return 1;
    }
    public function addPatientInitialAssessment($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    public function EditPatientInitialAssessment($patientId){
        $data = "SELECT * FROM `ems_epcr` As epcr "
                ."LEFT JOIN `ems_mas_loc_level` AS loc ON (epcr.loc = loc.level_id) "
                ."WHERE epcr.ptn_id = '$patientId' ";
        $initial = $this->db->query($data)->result_array();
        // $initial = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        // $data = array();
        // foreach($initial as $initial1){
        if($initial[0]['level_id'] == '' || empty($initial[0]['level_id'])){
                $loc = array(
                    'id' => 1,
                    'name' => 'Alert'
                );
            }else{
                $loc = array(
                    'id' => (int) $initial[0]['level_id'],
                    'name' => $initial[0]['level_type']
                );
            }
        if(!empty($initial)){
            $iniedit = array(
                'id' => (int) $initial[0]['ptn_id'],
                'loc' => $loc,
                'iniAirway' => $initial[0]['ini_airway'],
                'iniBreathing' => $initial[0]['ini_breathing'],
                'iniBreathingTxt' => $initial[0]['ini_breathing_txt'],
                'iniOxySatGetNf' => $initial[0]['ini_oxy_sat_get_nf'],
                'iniOxySatGetNfTxt' => $initial[0]['ini_oxy_sat_get_nf_txt'],
                'iniCirPulsePresent' => $initial[0]['ini_cir_pulse_p'],
                'iniCirPulsePresentTxt' => $initial[0]['ini_cir_pulse_p_txt'],
                'iniCirCapRefillTsec' => $initial[0]['ini_cir_cap_refill_tsec'],
                'iniBpSysbpTxt' => $initial[0]['ini_bp_sysbp_txt'],
                'iniBpDysbpTxt' => $initial[0]['ini_bp_dysbp_txt']
            );
            // array_push($data,$iniedit);
        // }
            return $iniedit;
        }
    }
    public function EditPatientOngoingAssessment($patientId){
        $incidentId = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        if(!empty($incidentId)){
            $incidentId1 = $incidentId[0]['inc_ref_id'];
            $data = "SELECT incamb.*,inc.*,mn.*,pc.* " 
                ."FROM $this->incidenceamb AS incamb "
                ."LEFT JOIN $this->incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->micnature as mn on(mn.ntr_id=inc.inc_mci_nature) "
                . "LEFT JOIN $this->patientComplaint as pc on(pc.ct_id=inc.inc_complaint) "
                . "WHERE incamb.inc_ref_id = '".$incidentId1."' "
                . "GROUP BY inc.inc_ref_id";
            $compIncidentRec = $this->db->query($data)->result_array();
            //  print_r($compIncidentRec);
            $recordData = array();
            foreach($compIncidentRec as $record){
                $service = explode(',',$compIncidentRec[0]['ntr_services']);
                $sr = array();
                for ($i=0; $i < count($service); $i++) { 
                    $serv = $this->getServices($service[$i]);
                    array_push($sr,$serv);
                }
                $services = implode(',',$sr);
                if($record['inc_type'] == 'MCI'){
                    $id = $record['ntr_id'];
                    $cheifComplaint = $record['ntr_nature'];
                }else{
                    $id = $record['ct_id'];
                    $cheifComplaint = $record['ct_type'];
                }
            }
           
        }
        $data = "SELECT * FROM $this->epcr AS epcr "
                ."LEFT JOIN $this->chiefComplaint AS chief ON (epcr.ong_ph_sign_symptoms = chief.ct_id) " 
                ."WHERE epcr.ptn_id = $patientId ";
        $initial = $this->db->query($data)->result_array();
        if(!empty($initial)){
            if($initial[0]['ong_intervention'] != null){
                $intervention = json_decode($initial[0]['ong_intervention']);
                $inter = array();
                foreach($intervention as $intervention1){
                    $this->db->select('id,name');
                    $this->db->from($this->interventions);
                    $this->db->where('id',$intervention1->id);
                    $inter1 = $this->db->get()->row();
                    array_push($inter,$inter1);
                }
            }else{
                $inter = [];
            }
        }
        if(!empty($initial)){
            if($initial[0]['ong_past_med_hist'] != null){
                $medical = json_decode($initial[0]['ong_past_med_hist']);
                $med = array();
                foreach($medical as $medical1){
                    $this->db->select('id,name');
                    $this->db->from($this->pastMedicalHistory);
                    $this->db->where('id',$medical1->id);
                    $med1 = $this->db->get()->row();
                    array_push($med,$med1);
                }
            }else{
                $med = [];
            }
        }
        // $data = array();
        // foreach($initial as $initial1){
        if(!empty($initial)){
            $iniedit = array(
                'id' => $initial[0]['ptn_id'],
                'ongIntervention' => $inter,
                'otherOngIntervention' => $initial[0]['other_ong_intervention'],
                'ongSuction' => $initial[0]['ong_suction'],
                'ongPosAirway' => $initial[0]['ong_pos_airway'],
                'ongSuppOxyThp' => $initial[0]['ong_supp_oxy_thp'],
                'ongSuppOxyThpTxt' => $initial[0]['ong_supp_oxy_thp_txt'],
                'ongVenSuppBvm' => $initial[0]['ong_ven_supp_bvm'],
                'ongStretcher' => $initial[0]['ong_stretcher'],
                'ongWheelchair' => $initial[0]['ong_wheelchair'],
                'ongSpineBoard' => $initial[0]['ong_spine_board'],
                'ongScoopStretcher' => $initial[0]['ong_scoop_stretcher'],
                'ongMedication' => $initial[0]['ong_medication'],
                'ongMedicationTxt' => $initial[0]['ong_medication_txt'],
                'ongPastMedHist' => $med,
                'otherOngPastMedHist' => $initial[0]['other_ong_past_med_hist'],
                // 'ongPhSignSymptoms' => ([
                //     'id' => (int) $initial[0]['ct_id'],
                //     'name' => $initial[0]['ct_type']
                // ]),
                'ongPhSignSymptoms' => ([
                    'id' => (int) $id,
                    'name' => $cheifComplaint
                ]),
                'ongOtherPhSignSymptoms' => $initial[0]['ong_other_ph_sign_symptoms'],
                'ongPhAllergy' => $initial[0]['ong_ph_allergy'],
                'ongPhEventLedInc' => $initial[0]['ong_ph_event_led_inc'],
                'ongPhLastOralIntake' => $initial[0]['ong_ph_last_oral_intake']
            );
            return $iniedit;
        }
    }
    public function addPatientOngoingAssessment($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    public function addPatientHandoverCondition($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    public function EditPatientHandoverCondition($patientId){
        $hand = "SELECT epcr.*,imp.*,stats.id,stats.name,loc.* FROM `ems_epcr` as epcr "
                ."LEFT JOIN `ems_mas_provider_imp` as imp ON (epcr.hc_pi_txt = imp.pro_id) " 
                ."LEFT JOIN `ems_mas_loc_level` AS loc ON (epcr.loc = loc.level_id) AND epcr.hc_loc IS NUll || (epcr.hc_loc = loc.level_id) "
                ."LEFT JOIN `ems_patient_status` as stats On (epcr.hc_ps = stats.id) WHERE `ptn_id` = $patientId ";
        $handover = $this->db->query($hand)->result_array();
        // $data = array();
        // foreach($handover as $handover1){
        //     $hcedit = array(
        //         'id' => $handover1['ptn_id'],
        //         'hcAirway' => $handover1['hc_airway'],
        //         'hcBreathing' => $handover1['hc_breathing'],
        //         'hcBreathingTxt' => $handover1['hc_breathing_txt'],
        //         'hcOxySatGetNf' => $handover1['hc_oxy_sat_get_nf'],
        //         'hcOxySatGetNfTxt' => $handover1['hc_oxy_sat_get_nf_txt'],
        //         'hcCirPulsePresent' => $handover1['hc_cir_pulse_p'],
        //         'hcCirPulsePresentTxt' => $handover1['hc_cir_pulse_p_txt'],
        //         'hcCirCapRefillGreatT' => $handover1['hc_cir_cap_refill_great_t'],
        //         'hcBpSysbpTxt' => $handover1['hc_bp_sysbp_txt'],
        //         'hcBpDibpTxt' => $handover1['hc_bp_dibp_txt'],
        //         'hcPiTxt' => $handover1['hc_pi_txt'],
        //         'hcPs' => $handover1['hc_ps']
        //     );
        //     array_push($data,$hcedit);
        // }
        return $handover;
    }
    public function submitClosure($data){
        //print_r($data);
        $record = $this->db->where('inc_ref_id',$data['inc_ref_id'])->get($this->closure)->result_array();
        if(empty($record)){
            $this->db->insert($this->closure,$data);
            return 1;
        }else{
            $this->db->where('inc_ref_id',$data['inc_ref_id'])->update($this->closure,$data);
            return 1;
        } 
    }
    public function getepcrData($incidentId){
        return $this->db->where('inc_ref_id',$incidentId)->get($this->epcr)->result_array();
    }
    public function getDriverParameter($incidentId){
        return $this->db->where('incident_id',$incidentId)->get($this->driverParameter)->result_array();
    }
    public function epcrremark($epcr,$incidentId){
        $this->db->where('inc_ref_id',$incidentId)->update($this->epcr,$epcr);
    }
    public function insertDriverpcr($dpcr){
        $data = $this->db->where('dp_pcr_id',$dpcr['dp_pcr_id'])->where('dpis_deleted','0')->get($this->driverpcr)->result_array();
        if(!empty($data)){
            $this->db->where('dp_pcr_id',$dpcr['dp_pcr_id'])->update($this->driverpcr,$dpcr);
        }else{
          $this->db->insert($this->driverpcr,$dpcr);  
        }
    }
    public function incidenceClose($emsIncidence,$incidentId){
        if(!empty($incidentId)){
            $this->db->where('inc_ref_id',$incidentId)->update($this->incidence,$emsIncidence);
        }
    }
    public function patientAvaOrNot($incidentId,$patientAvaOrNot){
        $data = $this->db->where('inc_ref_id',$incidentId)->get($this->incidence)->result_array();
        if(!empty($data)){
            $this->db->where('inc_ref_id',$incidentId)->update($this->incidence,$patientAvaOrNot);
            return 1;
        }else{
            return 2;
        }
    }
    public function UpdatePatientHandOverIssue($ptnid,$data){
        $this->db->where('ptn_id',$ptnid)->update($this->epcr,$data);
        return 1;
    }
    public function getissuesname($patientId){
        $data = "SELECT * FROM `ems_epcr` AS epcr "
                ."LEFT JOIN `ems_app_patient_handover_issues` AS issue ON (epcr.pat_handover_issue = issue.id) "
                ."WHERE epcr.ptn_id = $patientId";
        $patientHandOverIssue = $this->db->query($data)->result_array();
        // $data = array();
        // foreach($patientHandOverIssue as $patientHandOverIssue1){
        //     $data1 = array(
        //         'id' => $patientHandOverIssue1['ptn_id'],
        //         'patientHandoverIssue' => $patientHandOverIssue1['hi_pat_handover'],
        //         'opdNo' => $patientHandOverIssue1['opd_no_txt'],
        //         'patientHandoverIssueReason' => $patientHandOverIssue1['pat_handover_issue'],
        //         'hospPersonName' => $patientHandOverIssue1['hosp_person_name'],
        //         'hospCorrDateTime' => $patientHandOverIssue1['corr_action_dt'],
        //         'hospCommHosp' => $patientHandOverIssue1['com_with_hosp'],
        //         'hospRemark' => $patientHandOverIssue1['hi_remark']
        //     );
        //     array_push($data,$data1);
        // }
        return $patientHandOverIssue;
    }
    public function allDriverParameters($incidentId){
        $driverPara = $this->db->where('incident_id',$incidentId)->get( $this->driverParameter)->result_array();
        // $data = array();
        // foreach($driverPara as $driverPara1){
        //     $data1 = array(
        //         'id' => $driverPara1['incident_id'],
        //         'startFromBaseLocation' => $driverPara1['start_from_base_loc'],
        //         'atScene' => $driverPara1['at_scene'],
        //         'fromScene' => $driverPara1['from_scene'],
        //         'atHospital' => $driverPara1['at_hospital'],
        //         'patientHandover' => $driverPara1['patient_handover'],
        //         'backToBaseLocation' => $driverPara1['back_to_base_loc']
        //     );
        //     array_push($data,$data1);
        // }
        return $driverPara;
    }
    // public function ConsumableList($patientId){
    //     $consumable = $this->db->where('inv_type','CA')->get($this->inventory)->result_array();
    //     $a1 = array();
    //     foreach($consumable as $consumable1){
    //         $a = array(
    //             'id' => (int) $consumable1['inv_id'],
    //             'name' => $consumable1['inv_title'],
    //             'count' => 0,
    //             'checked' => null
    //         );
    //         array_push($a1,$a);
    //     }
    //     $consumable1 = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
    //     if(!empty($consumable1)){
    //         if($consumable1[0]['other_con_id_list'] == ''){
    //             $otherConsumable = [];
    //         }else{
    //             $otherConsumable = json_decode($consumable1[0]['other_con_id_list']);
    //         }
    //     }else{
    //         $otherConsumable = [];
    //     }
    //     $consumables = array();
        
    //     foreach($consumable1 as $con){
    //         $data = json_decode($con['con_id_list']);
    //         array_push($consumables,$data);
    //     }
    //     $list = array();
    //     foreach($consumables as $consumables1){
    //         if(empty($consumables1)){

    //         }else{
    //             for ($i=0; $i < count($consumables1); $i++) { 
    //                 $cons = array(
    //                     'id' => (int) $consumables1[$i]->id,
    //                     'name' => $consumables1[$i]->name,
    //                     'count' => $consumables1[$i]->count,
    //                     'checked' => null
    //                 );
    //                 array_push($list,$cons);
    //             }
    //         }
            
    //     }
    //     $tmpArray = array();
    //     foreach($a1 as $data1) {
        
    //       $duplicate = false;
    //       foreach($list as $data2) {
    //         if($data1['id'] == $data2['id']) $duplicate = true;
    //       }
        
    //       if($duplicate == false) $tmpArray[] = $data1;
    //     }
    //     $cons = array(
    //             "list" => array_merge($list,$tmpArray),
    //             "otherList" => $otherConsumable
    //         );
    //     return $cons;
    // }
    // public function ConsumableNonUnitList($patientId){
    //     $consumable = $this->db->where('inv_type','NCA')->where('invis_deleted','0')->get($this->inventory)->result_array();
    //     $a1 = array();
    //     foreach($consumable as $consumable1){
    //         $a = array(
    //             'id' => (int) $consumable1['inv_id'],
    //             'name' => $consumable1['inv_title'],
    //             'checked' => false,
    //             'count' => null
    //         );
    //         array_push($a1,$a);
    //     }
    //     $consumable1 = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
    //     if(!empty($consumable1)){
    //         if($consumable1[0]['other_con_nonunit_id_list'] == ''){
    //             $otherConsumable = [];
    //         }else{
    //             $otherConsumable = json_decode($consumable1[0]['other_con_nonunit_id_list']);
    //         }
    //     }else{
    //         $otherConsumable = [];
    //     }
    //     $consumables = array();
        
    //     foreach($consumable1 as $con){
    //         $data = json_decode($con['con_nonunit_id_list']);
    //         array_push($consumables,$data);
    //     }
    //     $list = array();
    //     foreach($consumables as $consumables1){
    //         if(empty($consumables1)){

    //         }else{
    //             for ($i=0; $i < count($consumables1); $i++) { 
    //                 $cons = array(
    //                     'id' => (int) $consumables1[$i]->id,
    //                     'name' => $consumables1[$i]->name,
    //                     'checked' => $consumables1[$i]->checked,
    //                     'count' => null
    //                 );
    //                 array_push($list,$cons);
    //             }
    //         }
            
    //     }
    //     $tmpArray = array();
    //     foreach($a1 as $data1) {
        
    //       $duplicate = false;
    //       foreach($list as $data2) {
    //         if($data1['id'] == $data2['id']) $duplicate = true;
    //       }
        
    //       if($duplicate == false) $tmpArray[] = $data1;
    //     }
    //     $cons = array(
    //             "list" => array_merge($list,$tmpArray),
    //             "otherList" => $otherConsumable
    //         );
    //     return $cons;
    // }
    public function ConsumableList($id,$args){
        $consumable = $this->db->where('inv_type','CA')->where('invis_deleted','0')->get($this->inventory)->result_array();
        $a1 = array();
        foreach($consumable as $consumable1){
            $a = array(
                'id' => (int) $consumable1['inv_id'],
                'name' => $consumable1['inv_title'],
                'count' => 0
            );
            array_push($a1,$a);
        }
        if($args == 'CA'){
            $consumable1 = $this->db->where('ptn_id',$id)->get($this->epcr)->result_array();
            if(!empty($consumable1)){
                if($consumable1[0]['other_con_id_list'] == ''){
                    $otherConsumable = [];
                }else{
                    $otherConsumable = json_decode($consumable1[0]['other_con_id_list']);
                }
            }else{
                $otherConsumable = [];
            }
            $consumables = array();
            
            foreach($consumable1 as $con){
                $data = json_decode($con['con_id_list']);
                array_push($consumables,$data);
            }
            $list = array();
            foreach($consumables as $consumables1){
                if(empty($consumables1)){

                }else{
                    for ($i=0; $i < count($consumables1); $i++) { 
                        $cons = array(
                            'id' => (int) $consumables1[$i]->id,
                            'name' => $consumables1[$i]->name,
                            'count' => $consumables1[$i]->count
                        );
                        array_push($list,$cons);
                    }
                }
                
            }
        }else{
            $consumable = "SELECT * "
                        . "FROM $this->indentItem as item "
                        . "LEFT JOIN $this->inventory as inv ON (item.ind_item_id = inv.inv_id) "
                        . "WHERE item.ind_req_id = $id AND item.ind_item_type = 'CA' AND item.indis_deleted = '0' ";
            $consumable1 = $this->db->query($consumable)->result_array();
            $list = array();
            foreach($consumable1 as $con){
                $data = array(
                    'id' => (int) $con['inv_id'],
                    'name' => $con['inv_title'],
                    'checked' => 'true',
                    'count' => $con['ind_quantity']
                );
                array_push($list,$data);
            }
            $otherConsumable = [];
        }
        $tmpArray = array();
        foreach($a1 as $data1) {
        $duplicate = false;
        foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
        }
        
        if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
            "list" => array_merge($list,$tmpArray),
            "otherList" => $otherConsumable
        );
        return $cons;
    }
    public function ConsumableNonUnitList($id,$args){
        $consumable = $this->db->where('inv_type','NCA')->where('invis_deleted','0')->get($this->inventory)->result_array();
        $a1 = array();
        foreach($consumable as $consumable1){
            $a = array(
                'id' => (int) $consumable1['inv_id'],
                'name' => $consumable1['inv_title'],
                'checked' => false,
                'count' => null
            );
            array_push($a1,$a);
        }
        if($args == 'CA'){
            $consumable1 = $this->db->where('ptn_id',$id)->get($this->epcr)->result_array();
            if(!empty($consumable1)){
                if($consumable1[0]['other_con_nonunit_id_list'] == ''){
                    $otherConsumable = [];
                }else{
                    $otherConsumable = json_decode($consumable1[0]['other_con_nonunit_id_list']);
                }
            }else{
                $otherConsumable = [];
            }
            $consumables = array();
        
            foreach($consumable1 as $con){
                $data = json_decode($con['con_nonunit_id_list']);
                array_push($consumables,$data);
            }
            $list = array();
            foreach($consumables as $consumables1){
                if(!empty($consumables1)){
                    for ($i=0; $i < count($consumables1); $i++) { 
                        $cons = array(
                            'id' => (int) $consumables1[$i]->id,
                            'name' => $consumables1[$i]->name,
                            'checked' => $consumables1[$i]->checked,
                            'count' => null
                        );
                        array_push($list,$cons);
                    }
                }
            }
        }else{
            $consumable = "SELECT * "
                        . "FROM $this->indentItem as item "
                        . "LEFT JOIN $this->inventory as inv ON (item.ind_item_id = inv.inv_id) "
                        . "WHERE item.ind_req_id = $id AND item.ind_item_type = 'NCA' AND item.indis_deleted = '0' ";
            $consumable1 = $this->db->query($consumable)->result_array();
            $list = array();
            foreach($consumable1 as $con){
                $data = array(
                    'id' => (int) $con['inv_id'],
                    'name' => $con['inv_title'],
                    'checked' => 'true',
                    'count' => $con['ind_quantity']
                );
                array_push($list,$data);
            }
            $otherConsumable = [];
        }
        $tmpArray = array();
        foreach($a1 as $data1) {
        
        $duplicate = false;
        foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
        }
        
        if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
                "list" => array_merge($list,$tmpArray),
                "otherList" => $otherConsumable
            );
        return $cons;
    }
    public function EquipmentList($id,$args){
        $consumable = $this->db->where('eqp_type','amb')->where('eqpis_deleted','0')->get($this->equipment)->result_array();
        $a1 = array();
        foreach($consumable as $consumable1){
            $a = array(
                'id' => (int) $consumable1['eqp_id'],
                'name' => $consumable1['eqp_name'],
                'checked' => false,
                'count' => 0
            );
            array_push($a1,$a);
        }
        if($args == 'EQP'){
            $consumable1 = $this->db->where('ptn_id',$id)->get($this->epcr)->result_array();
            if(!empty($consumable1)){
                if($consumable1[0]['other_con_id_list'] == ''){
                    $otherConsumable = [];
                }else{
                    $otherConsumable = json_decode($consumable1[0]['other_con_id_list']);
                }
            }else{
                $otherConsumable = [];
            }
            $consumables = array();
            
            foreach($consumable1 as $con){
                $data = json_decode($con['con_id_list']);
                array_push($consumables,$data);
            }
            $list = array();
            foreach($consumables as $consumables1){
                if(empty($consumables1)){

                }else{
                    for ($i=0; $i < count($consumables1); $i++) { 
                        $cons = array(
                            'id' => (int) $consumables1[$i]->id,
                            'name' => $consumables1[$i]->name,
                            'count' => $consumables1[$i]->count
                        );
                        array_push($list,$cons);
                    }
                }
                
            }
        }else{
            $consumable = "SELECT * "
                        . "FROM $this->indentItem as item "
                        . "LEFT JOIN $this->equipment as eqp ON (item.ind_item_id = eqp.eqp_id) "
                        . "WHERE item.ind_req_id = $id AND item.ind_item_type = 'EQP' AND item.indis_deleted = '0' ";
            $consumable1 = $this->db->query($consumable)->result_array();
            $list = array();
            foreach($consumable1 as $con){
                $data = array(
                    'id' => (int) $con['eqp_id'],
                    'name' => $con['eqp_name'],
                    'checked' => true,
                    'count' => $con['ind_quantity']
                );
                array_push($list,$data);
            }
        }
        $tmpArray = array();
        foreach($a1 as $data1) {
        $duplicate = false;
        foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
        }
        
        if($duplicate == false) $tmpArray[] = $data1;
        }
        // $cons = array(
        //     "list" => array_merge($list,$tmpArray)
        // );
        return array_merge($list,$tmpArray);
    }
    public function insertConsumable($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    public function insertMedicine($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    // public function getmedicinename($patientId){
    //     $ambMedicine = $this->db->where('med_type','amb')->where('med_unit','CA')->where('medis_deleted','0')->get($this->invMedicine)->result_array();
    //     $a1 = array();
    //     foreach($ambMedicine as $ambMedicine1){
    //         $a = array(
    //             'id' => (int) $ambMedicine1['med_id'],
    //             'name' => $ambMedicine1['med_title'],
    //             'count' => 0,
    //             'checked' => null
    //         );
    //         array_push($a1,$a);
    //     }
    //     $medicine = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
    //     if(!empty($medicine)){
    //         if($medicine[0]['other_med_id_list'] == ''){
    //             $othermedicine = [];
    //         }else{
    //             $othermedicine = json_decode($medicine[0]['other_med_id_list']);
    //         }
    //     }else{
    //         $othermedicine = [];
    //     }
    //     $medicines = array();
    //     foreach($medicine as $med){
    //         $data = json_decode($med['med_id_list']);
    //         array_push($medicines,$data);
    //     }
    //     $list = array();
    //     foreach($medicines as $medicines1){
    //         if(empty($medicines1)){

    //         }else{
    //             for ($i=0; $i < count($medicines1); $i++) { 
    //                 $cons = array(
    //                     'id' => (int) $medicines1[$i]->id,
    //                     'name' => $medicines1[$i]->name,
    //                     'count' => $medicines1[$i]->count,
    //                     'checked' => null
    //                 );
    //                 array_push($list,$cons);
    //             }
    //         }
            
    //     }
    //     $tmpArray = array();
    //     foreach($a1 as $data1) {
        
    //       $duplicate = false;
    //       foreach($list as $data2) {
    //         if($data1['id'] == $data2['id']) $duplicate = true;
    //       }
        
    //       if($duplicate == false) $tmpArray[] = $data1;
    //     }
    //     $cons = array(
    //             "list" => array_merge($list,$tmpArray),
    //             "otherList" => $othermedicine
    //         );
    //     return $cons;
        
    //     // $medicine = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
    //     // $medicines = array();
    //     // foreach($medicine as $med){
    //     //     $meds = array(
    //     //         'id' => $med['ptn_id'],
    //     //         'medicineList' => json_decode($med['med_id_list']),
    //     //         'otherMedicineList' =>  json_decode($med['other_med_id_list'])
    //     //     ) ;
    //     //     array_push($medicines,$meds);
    //     // }
    //     // return $medicines;
    // }
     public function getmedicinename($id,$args){
        $ambMedicine = $this->db->where('med_type','amb')->where('med_unit',"MCA")->where('medis_deleted','0')->get($this->invMedicine)->result_array();
        $a1 = array();
        foreach($ambMedicine as $ambMedicine1){
            $a = array(
                'id' => (int) $ambMedicine1['med_id'],
                'name' => $ambMedicine1['med_title'],
                'count' => 0
            );
            array_push($a1,$a);
        }
        if($args == 'MCA'){
            $medicine = $this->db->where('ptn_id',$id)->get($this->epcr)->result_array();
            if(!empty($medicine)){
                if($medicine[0]['other_med_id_list'] == ''){
                    $othermedicine = [];
                }else{
                    $othermedicine = json_decode($medicine[0]['other_med_id_list']);
                }
            }else{
                $othermedicine = [];
            }
            $medicines = array();
            foreach($medicine as $med){
                $data = json_decode($med['med_id_list']);
                array_push($medicines,$data);
            }
            $list = array();
            foreach($medicines as $medicines1){
                if(empty($medicines1)){

                }else{
                    for ($i=0; $i < count($medicines1); $i++) { 
                        $cons = array(
                            'id' => (int) $medicines1[$i]->id,
                            'name' => $medicines1[$i]->name,
                            'count' => $medicines1[$i]->count
                        );
                        array_push($list,$cons);
                    }
                }
                
            }
        }else{
            $medicine = "SELECT * "
                        . "FROM $this->indentItem as item "
                        . "LEFT JOIN $this->invMedicine as med ON (item.ind_item_id = med.med_id) "
                        . "WHERE item.ind_req_id = $id AND item.ind_item_type = 'MCA' AND item.indis_deleted = '0' ";
            $medicine1 = $this->db->query($medicine)->result_array();
            $list = array();
            foreach($medicine1 as $con){
                $data = array(
                    'id' => (int) $con['med_id'],
                    'name' => $con['med_title'],
                    'checked' => 'true',
                    'count' => $con['ind_quantity']
                );
                array_push($list,$data);
            }
            $othermedicine = [];
        }
        $tmpArray = array();
        foreach($a1 as $data1) {
        
          $duplicate = false;
          foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
          }
        
          if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
                "list" => array_merge($list,$tmpArray),
                "otherList" => $othermedicine
            );
        return $cons;
    }
    // public function getNonUnitMedicineName($patientId){
    //     $ambMedicine = $this->db->where('med_type','amb')->where('med_unit','NCA')->where('medis_deleted','0')->get($this->invMedicine)->result_array();
    //     $a1 = array();
    //     foreach($ambMedicine as $ambMedicine1){
    //         $a = array(
    //             'id' => (int) $ambMedicine1['med_id'],
    //             'name' => $ambMedicine1['med_title'],
    //             'checked' => false,
    //             'count' => null
    //         );
    //         array_push($a1,$a);
    //     }
    //     $medicine = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
    //     if(!empty($medicine)){
    //         if($medicine[0]['other_med_nonunit_id_list'] == ''){
    //             $othermedicine = [];
    //         }else{
    //             $othermedicine = json_decode($medicine[0]['other_med_nonunit_id_list']);
    //         }
    //     }else{
    //         $othermedicine = [];
    //     }
    //     $medicines = array();
    //     foreach($medicine as $med){
    //         $data = json_decode($med['med_nonunit_id_list']);
    //         array_push($medicines,$data);
    //     }
    //     $list = array();
    //     foreach($medicines as $medicines1){
    //         if(empty($medicines1)){

    //         }else{
    //             for ($i=0; $i < count($medicines1); $i++) { 
    //                 $cons = array(
    //                     'id' => (int) $medicines1[$i]->id,
    //                     'name' => $medicines1[$i]->name,
    //                     'checked' => $medicines1[$i]->checked,
    //                     'count' => null
    //                 );
    //                 array_push($list,$cons);
    //             }
    //         }
            
    //     }
    //     $tmpArray = array();
    //     foreach($a1 as $data1) {
        
    //       $duplicate = false;
    //       foreach($list as $data2) {
    //         if($data1['id'] == $data2['id']) $duplicate = true;
    //       }
        
    //       if($duplicate == false) $tmpArray[] = $data1;
    //     }
    //     $cons = array(
    //             "list" => array_merge($list,$tmpArray),
    //             "otherList" => $othermedicine
    //         );
    //     return $cons;
    // }
    public function getNonUnitMedicineName($id,$args){
        $ambMedicine = $this->db->where('med_type','amb')->where('med_unit','MNCA')->where('medis_deleted','0')->get($this->invMedicine)->result_array();
        $a1 = array();
        foreach($ambMedicine as $ambMedicine1){
            $a = array(
                'id' => (int) $ambMedicine1['med_id'],
                'name' => $ambMedicine1['med_title'],
                'checked' => false
            );
            array_push($a1,$a);
        }
        if($args == 'MNCA'){
            $medicine = $this->db->where('ptn_id',$id)->get($this->epcr)->result_array();
            if(!empty($medicine)){
                if($medicine[0]['other_med_nonunit_id_list'] == ''){
                    $othermedicine = [];
                }else{
                    $othermedicine = json_decode($medicine[0]['other_med_nonunit_id_list']);
                }
            }else{
                $othermedicine = [];
            }
            $medicines = array();
            foreach($medicine as $med){
                $data = json_decode($med['med_nonunit_id_list']);
                array_push($medicines,$data);
            }
            $list = array();
            foreach($medicines as $medicines1){
                if(empty($medicines1)){

                }else{
                    for ($i=0; $i < count($medicines1); $i++) { 
                        $cons = array(
                            'id' => (int) $medicines1[$i]->id,
                            'name' => $medicines1[$i]->name,
                            'checked' => $medicines1[$i]->checked
                        );
                        array_push($list,$cons);
                    }
                }
                
            }
        }else{
            $medicine = "SELECT * "
                        . "FROM $this->indentItem as item "
                        . "LEFT JOIN $this->invMedicine as med ON (item.ind_item_id = med.med_id) "
                        . "WHERE item.ind_req_id = $id AND item.ind_item_type = 'MNCA' AND item.indis_deleted = '0' ";
            $medicine1 = $this->db->query($medicine)->result_array();
            $list = array();
            foreach($medicine1 as $con){
                $data = array(
                    'id' => (int) $con['med_id'],
                    'name' => $con['med_title'],
                    'checked' => 'true',
                    'count' => $con['ind_quantity']
                );
                array_push($list,$data);
            }
            $othermedicine = [];
        }
        $tmpArray = array();
        foreach($a1 as $data1) {
        
          $duplicate = false;
          foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
          }
        
          if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
                "list" => array_merge($list,$tmpArray),
                "otherList" => $othermedicine
            );
        return $cons;
    }
    public function insertMedAmbStk($medambstk){
        $this->db->insert($this->ambulanceStock,$medambstk);
    }
    public function insertConAmbStk($conambstk){
        $this->db->insert($this->ambulanceStock,$conambstk);
    }
    public function updateDriverPara($para,$incidentId){
        $this->db->where('incident_id',$incidentId)->update($this->driverParameter,$para);
    }
    public function checkAllInfo($incidentID){
        // return $this->db->where('inc_ref_id',$incidentID)->get($this->epcr)->result_array();
        $incPtnId = $this->db->where('inc_id',$incidentID)->get($this->incidencePatient)->result_array();
        $ptn = array();
        $pt1 = array(); 
        foreach($incPtnId as $incPtnId1){
            $patient = array(
                'id' => $incPtnId1['ptn_id']
            );
            array_push($ptn,$patient);
            $id = $patient['id'];
            $data1 = "SELECT ptn.*,epcr.initial_complete,epcr.ongoing_complete,epcr.handover_cond_complete,epcr.handover_issue_complete,epcr.medicine_complete,epcr.consumable_complete,epcr.pat_com_to_hosp,epcr.pat_com_to_hosp,epcr.pat_com_to_hosp_reason,ptnreason.id,ptnreason.reason "
                    ."FROM `ems_patient` AS ptn "
                    ."LEFT JOIN `ems_epcr` AS epcr ON (ptn.ptn_id = epcr.ptn_id) "
                    ."LEFT JOIN `ems_patient_notcomtohosp_reason` AS ptnreason ON (epcr.pat_com_to_hosp_reason = ptnreason.id) "
                    ."WHERE ptn.ptn_id = '$id' ";
            // $data = $this->db->where('ptn_id',$patient['id'])->get($this->patient)->result_array();
            $data = $this->db->query($data1)->result_array();
                array_push($pt1,$data);
        }
        // print_r($pt1);
        return $pt1;
    }

    public function getprevmaintanceodo($ambulanceno){
        $this->db->select('*');
        $this->db->from($this->preventivemaintenance);
        $this->db->where('mt_amb_no',$ambulanceno);
        $this->db->where('mt_end_odometer != ','');
        $end = $this->db->get()->result_array();
        // print_r($end);die;
        if(empty($end)){
            $odometers = array();
            $odometer = array(
                'id' => 0,
                'endOdometer' => 0
            );
            array_push($odometers,$odometer);
            return $odometers;
        }else{
            $odometers = array();
            foreach($end as $time){
                $odometer = array(
                    'id' => $time['mt_id'],
                    'endOdometer' => $time['mt_end_odometer']
                );
                array_push($odometers,$odometer);
            }
            $arr = end($odometers);
            return $arr;
        }
    }

    public function getbreakdownmaintanceodo($ambulanceno){
        $this->db->select('*');
        $this->db->from($this->breakdownMaintenance);
        $this->db->where('mt_amb_no',$ambulanceno);
        $this->db->where('mt_end_odometer != ','');
        $end = $this->db->get()->result_array();
        // print_r($end);die;
        if(empty($end)){
            $odometers = array();
            $odometer = array(
                'id' => 0,
                'endOdometer' => 0
            );
            array_push($odometers,$odometer);
            return $odometers;
        }else{
            $odometers = array();
            foreach($end as $time){
                $odometer = array(
                    'id' => $time['mt_id'],
                    'endOdometer' => $time['mt_end_odometer']
                );
                array_push($odometers,$odometer);
            }
            $arr = end($odometers);
            return $arr;
        }
    }


    public function getsystemodo($ambulanceno){
        $this->db->select('*');
        $this->db->from($this->closure);
        $this->db->where('amb_rto_register_no',$ambulanceno);
        $this->db->where('end_odmeter != ','');
        $this->db->where('flag','1');
        $end = $this->db->get()->result_array();
       
        if(empty($end)){
            // $odometers = array();
            $odometer = array(
                'id' => 0,
                'endOdometer' => 0
            );
            // array_push($odometers,$odometer);
            return $odometer;
        }else{
            $odometers = array();
            foreach($end as $time){
                $odometer = array(
                    'id' => $time['id'],
                    'endOdometer' => $time['end_odmeter']
                );
                array_push($odometers,$odometer);
            }
            $arr = end($odometers);
            return $arr;
        }
    }

    public function getendodometer($ambulanceno){
        $this->db->select('*');
        $this->db->from($this->closure);
        $this->db->where('amb_rto_register_no',$ambulanceno);
        $this->db->where('end_odmeter != ','');
        $this->db->where('flag','1');
        $end = $this->db->get()->result_array();
        if(empty($end)){
            $odometers = array(
                'id' => 0,
                'endOdometer' => 0
            );
            return $odometers;
        }else{
            $odometers = array();
            foreach($end as $time){
                $odometer = array(
                    'id' => $time['id'],
                    'endOdometer' => $time['end_odmeter']
                );
                array_push($odometers,$odometer);
            }
            $arr = end($odometers);
            return $arr;
        }
    }
    public function getHospitalDeatils($incidentId){
         $data = "SELECT inc.*,hosp.*,dist.dst_code as id,dist.dst_name as name FROM `ems_incidence` as inc"
                ." LEFT JOIN `ems_hospital1` as hosp ON (inc.inc_district_id = hosp.hp_district) "
                ." LEFT JOIN `ems_mas_districts` as dist ON (inc.inc_district_id = dist.dst_code)"
                ."WHERE inc.inc_ref_id = '".$incidentId."' limit 50 ";
	//echo $this->db->last_query();die;
        $hospDetails = $this->db->query($data)->result_array();
        return $hospDetails;
    }
    public function getClgRefid($loginId){
        $this->db->select('clg_ref_id');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$loginId);
        return $this->db->get()->row()->clg_ref_id;
    }
    public function insertpcr($pcr){
        $data = $this->db->where('id',$pcr['id'])->where('pcr_id',$pcr['pcr_id'])->get($this->pcr)->result_array();
        if(empty($data)){
            $this->db->insert($this->pcr,$pcr);
        }else{
            $this->db->where('id',$pcr['id'])->update($this->pcr,$pcr);
        }
    }
    // public function getLoginAmb(){
    //     $data = "SELECT * FROM `ems_app_login_session` AS loginsess"
    //             ." LEFT JOIN `ems_app_device_version` AS devicever ON (loginsess.device_id = devicever.device_id)"
    //             ." LEFT JOIN `ems_incidence_ambulance` AS incamb ON (loginsess.vehicle_no = incamb.amb_rto_register_no)"
    //             ." LEFT JOIN `ems_incidence` AS inc ON (incamb.inc_ref_id = inc.inc_ref_id)"
    //             ." WHERE loginsess.status = 1 AND inc.inc_pcr_status = '0' ";
    //     $data1 = $this->db->query($data)->result_array();
    //     return $data1;
    // }
    public function chkUserLogin($amb_no){
        $data = $this->db->where('vehicle_no',$amb_no)->where('status',1)->get($this->loginSessionTbl)->result_array();
        $a = array();
        if(!empty($data)){
            if($data[0]['type_id'] == 3){
                $b = $this->db->where('device_id',$data[0]['device_id'])->get($this->deviceVersion)->result_array();
                array_push($a,$b);
            }else{
                foreach($data as $data1){
                    $b = $this->db->where('device_id',$data1['device_id'])->get($this->deviceVersion)->result_array();
                    array_push($a,$b);
                }
            }
        }
        return $a;
    }
    public function getDistrict($incidentId){
        $data = "SELECT dis.dst_code,dst_name FROM `ems_incidence`"
                ." As inc LEFT JOIN `ems_mas_districts` As dis ON (inc.inc_state_id = dis.dst_state)"
                ." WHERE inc.inc_ref_id = '".$incidentId."' AND dis.dstis_deleted = '0' ";
        return $this->db->query($data)->result_array();
    }
    public function chkSameDeviceLogin($data){
        if($data['typeId'] == 1){
            $chk = $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->get($this->loginSessionTbl)->result_array();
            if(!empty($chk)){
                return 1;
            }
            else{
                return 2;
            }
        }else if($data['typeId'] == 2){
            $chk = $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->get($this->loginSessionTbl)->result_array();
            if(!empty($chk)){
                return 1;
            }
            else{
                return 2;
            }
        }else if($data['typeId'] == 4 ){
            $chk = $this->db->where('clg_id',$data['clg_id'])->where('type_id',$data['typeId'])->where('status','1')->where('device_id',$data['deviceid'])->get($this->loginSessionTbl)->result_array();
             if(!empty($chk)){
                return 1;
            }
            else{
                return 2;
            }
        }else{
            $chk = $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->get($this->loginSessionTbl)->result_array();
            $chk1 = $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->get($this->loginSessionTbl)->result_array();
            if(!empty($chk) && !empty($chk1)){
                return 1;
            }
        }
    }
    public function updateLoginSession($data1,$data){
        if($data['typeId'] == 3){
            $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->update($this->loginSessionTbl,$data1);
            $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->update($this->loginSessionTbl,$data1);
        }else if($data['typeId'] == 1){
            $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->update($this->loginSessionTbl,$data1);
        }else if($data['typeId'] == 4){
            $this->db->where('clg_id',$data['clg_id'])->where('type_id',$data['typeId'])->where('status','1')->where('device_id',$data['deviceid'])->update($this->loginSessionTbl,$data1);
        }else{
            $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->where('device_id',$data['deviceid'])->update($this->loginSessionTbl,$data1);
        }
    }
     public function chkAnotherDeviceLogin($data){
        $data1['status'] = '2';
        if($data['typeId'] == 1){         
            $chk = $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            if((count($chk)==1) && ($chk[0]['device_id'] != $data['deviceid']) && ($chk[0]['vehicle_no'] == $data['vehicleNumber'])){
                $this->db->where('clg_id',$data['pilotId'])->update($this->loginSessionTbl,$data1);
                return 1;
            }else{
                return 2;
            }
        }else if($data['typeId'] == 2){           
            $chk = $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            if((count($chk)==1) && ($chk[0]['device_id'] != $data['deviceid']) && ($chk[0]['vehicle_no'] == $data['vehicleNumber'])){
                $this->db->where('clg_id',$data['emtId'])->update($this->loginSessionTbl,$data1);
                return 1;
            }else{
                return 2;
            }
        }else if($data['typeId'] == 4){
            $chk = $this->db->where('clg_id',$data['clg_id'])->where('type_id',$data['typeId'])->where('status','1')->get($this->loginSessionTbl)->result_array();
           
            if((count($chk)==1) && ($chk[0]['device_id'] != $data['deviceid'])){
                $this->db->where('clg_id',$data['clg_id'])->update($this->loginSessionTbl,$data1);
                return 1;
            }else{
                return 2;
            }
        }else{
            $pilot = $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            $emt = $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            if(((count($pilot)==1) && ($pilot[0]['device_id'] != $data['deviceid']) && ($pilot[0]['vehicle_no'] == $data['vehicleNumber'])) && ((count($emt)==1) && ($emt[0]['device_id'] != $data['deviceid']) && ($emt[0]['vehicle_no'] == $data['vehicleNumber']))){
                $this->db->where('clg_id',$data['pilotId'])->update($this->loginSessionTbl,$data1);
                $this->db->where('clg_id',$data['emtId'])->update($this->loginSessionTbl,$data1);
                return 1;
            }else{
                return 2;
            }
        }
    }
    public function checkBoth1($data){
        if($data['typeId'] == 1){
         
            $sameUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['pilotId']."' AND loginSession.status = '1'  ";
            $vehicleUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
            ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.clg_id = '".$data['pilotId']."' AND loginSession.status = '1' ";
            $vehicleLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
            ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' AND login_type ='D' ";
            // $data1 = $this->db->where('clg_id',$data['pilotId'])->where('status',1)->get($this->loginSessionTbl)->result_array();
            // print_r($sameUserLogin);
            
            $sameUserLogin1 = $this->db->query($sameUserLogin)->result_array();
     
            $vehicleUserLogin1 = $this->db->query($vehicleUserLogin)->result_array();
            $vehicleLogin1 = $this->db->query($vehicleLogin)->result_array();
           
          
            if(!empty($sameUserLogin1)){
                
                return $sameUserLogin1;
            }else if(!empty($vehicleUserLogin1)){
                return $vehicleUserLogin1;
            }else{
                return $vehicleLogin1;
            }
         
        }else if($data['typeId'] == 2){
            // print_r($data['emtId']);
            $sameUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['emtId']."' AND loginSession.status = '1'  ";
            $vehicleUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.clg_id = '".$data['emtId']."' AND loginSession.status = '1' ";
            // $data1 = $this->db->where('clg_id',$data['emtId'])->where('status',1)->get($this->loginSessionTbl)->result_array();
            $vehicleLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
            ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' AND login_type ='P' ";
            // print_r($this->db->query($data1)->result_array());
            $sameUserLogin1 = $this->db->query($sameUserLogin)->result_array();
            $vehicleUserLogin1 = $this->db->query($vehicleUserLogin)->result_array();
            $vehicleLogin1 = $this->db->query($vehicleLogin)->result_array();
            
            if(!empty($sameUserLogin1)){
                return $sameUserLogin1;
            }else if(!empty($vehicleUserLogin1)){
                return $vehicleUserLogin1;
            }else{
                return $vehicleLogin1;
            }
        }else if($data['typeId'] == 4){
           
            $sameUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['clg_id']."' AND loginSession.status = '1' AND type_id='4' AND device_id!= ' ".$data['deviceid']."' ";
         
            $sameUserLogin1 = $this->db->query($sameUserLogin)->result_array();
           
                return $sameUserLogin1;
          
        }else{
            $pilot = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['pilotId']."' || loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
            $d = $this->db->query($pilot)->result_array();
            $emt = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['emtId']."' || loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
            $p = $this->db->query($emt)->result_array();
            // $d = $this->db->where('clg_id',$data['pilotId'])->where('status',1)->get($this->loginSessionTbl)->result_array();
            // $p = $this->db->where('clg_id',$data['emtId'])->where('status',1)->get($this->loginSessionTbl)->result_array();
            if(!empty($p) && !empty($d)){
                return 1;
            }else if(!empty($p)){
                return 2;
            }else if(!empty($d)){
                return 3;
            }
        }
    }
    public function chkMobNo($typeThreeMobNo){
        return $this->db->where('clg_mobile_no',$typeThreeMobNo)->get($this->colleague)->result_array();
    }
    public function getByDefaultDistrict($hosp){
        $incidentId = $hosp['incidentId'];
        $district = $hosp['district'];
        if(empty($hosp['district'])){
            $data = "SELECT dis.dst_code,dst_name FROM `ems_incidence` As inc"
            ." LEFT JOIN `ems_mas_districts` As dis ON (inc.inc_district_id = dis.dst_code)"
            ." WHERE inc.inc_ref_id = '".$incidentId."' ";
            $dist =  $this->db->query($data)->result_array();
        }else{
            $data = "SELECT dis.dst_code,dst_name FROM `ems_mas_districts` As dis"
            ." WHERE dis.dst_code = $district ";
            $dist =  $this->db->query($data)->result_array();
        }
        foreach($dist as $dist1){
            $district = array(
                'id' => (int) $dist1['dst_code'],
                'name' => $dist1['dst_name']
            );
        }
        return $district;
    }
    public function getpatientAvaOrNot($incidentId){
        $data = $this->db->where('inc_ref_id',$incidentId)->get($this->incidence)->result_array();
        if(!empty($data)){
            $data1 = "SELECT inc.*,res.id,res.reason As 'name' "
                    ."FROM `ems_incidence` as inc "
                    ."LEFT JOIN `ems_patient_not_ava_reason` As res ON (inc.patient_ava_or_not_reason = res.id) "
                    ."WHERE inc.inc_ref_id = $incidentId ";
            return $this->db->query($data1)->result_array();
        }else{
            return 2;
        }
    }
    public function checkPtnInEpcr($patientId){
        return $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
    }
    public function acceptIncidentId($incidentId,$data){
        $this->db->where('inc_ref_id',$incidentId)->update($this->incidence,$data);
    }
    public function checkDeviceLogin($deviceId){
        return $this->db->where('device_id',$deviceId)->where('status','1')->get($this->loginSessionTbl)->result_array();
    }
    public function incidentCallsDetails($incidentId){
        $data = "SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,hosp.*" 
                ."FROM $this->incidenceamb AS incamb "
                ."LEFT JOIN $this->incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->calls AS cls ON (cls.cl_id = inc.inc_cl_id) "
                . "LEFT JOIN $this->callers AS clr ON (clr.clr_id = cls.cl_clr_id) "
                . "LEFT JOIN $this->relation AS rel ON (cls.clr_ralation = rel.rel_id) "
                . "LEFT JOIN $this->operateby AS op ON ( op.sub_id = inc.inc_ref_id ) "
                . "LEFT JOIN $this->micnature as mn on(mn.ntr_id=inc.inc_mci_nature) "
                . "LEFT JOIN $this->patientComplaint as pc on(pc.ct_id=inc.inc_complaint) "
                . "LEFT JOIN $this->hospital as hosp on(inc.hospital_id=hosp.hp_id) "
                . "WHERE incamb.inc_ref_id = '".$incidentId."' "
                . "GROUP BY inc.inc_ref_id";
        $compIncidentRec = $this->db->query($data)->result_array();
        $recordData = array();
        foreach($compIncidentRec as $record){
            $service = explode(',',$compIncidentRec[0]['ntr_services']);
            $sr = array();
            for ($i=0; $i < count($service); $i++) { 
                $serv = $this->getServices($service[$i]);
                array_push($sr,$serv);
            }
            $services = implode(',',$sr);
            $datetime = new DateTime($record['inc_datetime']);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i:s');
            $recordData1['callerName'] = $record['clr_fname']." ".$record['clr_mname']." ".$record['clr_lname'];
            $recordData1['callerMob'] = (float) $record['clr_mobile'];
            $recordData1['incidentId'] = $record['inc_ref_id'];
            $recordData1['incidentDate'] = $date;
            $recordData1['incidentTime'] = $time;
            $recordData1['incidentPatientCount'] = (int) $record['inc_patient_cnt'];
            if($record['inc_type'] == 'MCI'){
                $recordData1['cheifComplaint'] = $record['ntr_nature'];
            }else{
                $recordData1['cheifComplaint'] = $record['ct_type'];
            }
            if($record['inc_pcr_status']==0){
                $recordData1['incidentStatus'] = 'Received';
            }else{
                $recordData1['incidentStatus'] = 'Completed';
            }
            $recordData1['incidentAddress'] = $record['inc_address'];
            $recordData1['lat'] = (float) $record['inc_lat'];
            $recordData1['long'] = (float) $record['inc_long'];
            $recordData1['incidentPincode'] = (float) $record['inc_pincode'];
            $recordData1['CallerRelationName'] = $record['rel_name'];
            $recordData1['Services'] = $services;
            // 'hospitalFlag' : if selected hospital with other 'true' and not selected 'false'
            if(empty($record['hospital_id']) && empty($record['hospital_name'])){
                $recordData1['hospitalFlag'] = 'false';
                $recordData1['hospitalName'] = null;
                $recordData1['hospitalAddress'] = null;
                $recordData1['hospitalLat'] = null;
                $recordData1['hospitalLong'] = null;
            }else if(!empty($record['hospital_id'])){
                $recordData1['hospitalFlag'] = 'true';
                $recordData1['hospitalName'] = $record['hp_name'];
                $recordData1['hospitalAddress'] = $record['hp_address'];
                $recordData1['hospitalLat'] = (float) $record['hp_lat'];
                $recordData1['hospitalLong'] = (float) $record['hp_long'];
            }else{
                $recordData1['hospitalFlag'] = 'true';
                $recordData1['hospitalName'] = $record['hospital_name'];
                $recordData1['hospitalAddress'] = $record['hospital_address'];
                $recordData1['hospitalLat'] = null;
                $recordData1['hospitalLong'] = null;
            }
            if($record['patient_ava_or_not'] == 'yes'){
                $recordData1['isAnyPatientAvailable'] = 0;
            }else if($record['patient_ava_or_not'] == 'no'){
                $recordData1['isAnyPatientAvailable'] = 1;
            }else{
                $recordData1['isAnyPatientAvailable'] = -1;
            }
            array_push($recordData,$recordData1);
        }
        return $recordData;
    }
    public function getWithPatner($incidentId){
        $this->db->select('with_partner');
        $this->db->from($this->driverParameter);
        $this->db->where('incident_id',$incidentId);
        return  $this->db->get()->result_array();
    }
    public function checkPtnComToTheHosp($incidentId){
        // $data = "SELECT * FROM ems_incidence AS ei "
        //         ."LEFT OUTER JOIN `ems_epcr` AS ee ON ei.inc_ref_id = ee.inc_ref_id AND ei.patient_ava_or_not IS NOT NULL AND ei.patient_ava_or_not = 'yes' "
        //         ."WHERE ee.pat_com_to_hosp = '0'  AND ei.inc_ref_id = '$incidentId' ";
        $data = "SELECT * FROM ems_incidence AS ei "
                ."LEFT JOIN `ems_epcr` AS ee ON ei.inc_ref_id = ee.inc_ref_id "
                ."WHERE ei.patient_ava_or_not = 'yes' AND ei.inc_ref_id = '$incidentId' ";
        return $this->db->query($data)->result_array();
    }
    public function freeAmbulance($ambno){
        $data['amb_status'] = 1;
        $this->db->where('amb_rto_register_no',$ambno)->update($this->ambulance,$data);
    }
    public function chkPilotUserLogin($data){
        // print_r($data);
        $pilot = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['pilotId']."' AND loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
        return  $this->db->query($pilot)->result_array(); 
    }
    public function chkEmtUserLogin($data){
        $emt = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['emtId']."' AND loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
        return  $this->db->query($emt)->result_array(); 
    }
    public function chkAmbLogin($data){
        $amb = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
        return  $this->db->query($amb)->result_array(); 
    }
    public function chkpilotLogin($data){
        $pilot = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['pilotId']."' AND loginSession.status = '1' ";
        return  $this->db->query($pilot)->result_array(); 
    }
    public function chkEmtLogin($data){
        $pilot = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['emtId']."' AND loginSession.status = '1' ";
        return  $this->db->query($pilot)->result_array(); 
    }
    public function insertNonUnitMedAmbStk($medambstk){
        $data = $this->db->where('incidentId',$medambstk['incidentId'])->where('as_item_id',$medambstk['as_item_id'])->where('as_item_type','MEDNCA')->get($this->ambulanceStock)->result_array();
        if(empty($data)){
            $this->db->insert($this->ambulanceStock,$medambstk);
        }
    }
    public function insertNonUnitConAmbStk($conambstk){
        $data = $this->db->where('incidentId',$conambstk['incidentId'])->where('as_item_id',$conambstk['as_item_id'])->where('as_item_type','NCA')->get($this->ambulanceStock)->result_array();
        if(empty($data)){
            $this->db->insert($this->ambulanceStock,$conambstk);
        }
    }
    public function checkIncidentIdClose($incidentId){
        return $this->db->where('inc_pcr_status','1')->where('inc_ref_id',$incidentId)->get($this->incidence)->result_array();
    }
    public function insertImages($img,$incidentId){
        $this->db->where('inc_ref_id',$incidentId)->update($this->incidence,$img);
        return 1;
    }
    public function insertVideo($video,$incidentId){
        $this->db->where('inc_ref_id',$incidentId)->update($this->incidence,$video);
        return 1;
    }
    public function getIndentReqDistManager($ambulanceNo){
       // $data = "SELECT amb.amb_district,user.clg_ref_id,user.clg_id"
            //  ..  ." FROM $this->ambulance as amb"
              //  ." LEFT JOIN $this->colleague as user ON (amb.amb_district = user.clg_district_id)"
              //  ." WHERE amb.amb_rto_register_no = '$ambulanceNo' AND user.clg_group = 'UG-DM' ";

                $data = "SELECT user.clg_ref_id,user.clg_id FROM  ems_colleague as user  WHERE user.clg_group = 'UG-DM' ";       
        $query = $this->db->query($data)->result_array();
        return $query;
    }
    public function getListOfIndentReq($ambulanceNo){
        $this->db->select('*');    
        $this->db->from($this->indentRequest);
        $this->db->where('req_amb_reg_no',$ambulanceNo);
        $this->db->where('req_isdeleted','0');
        $this->db->where('req_group != ','EQUP');
        return  $this->db->get()->result_array();
        // return $this->db->where('req_amb_reg_no',$ambulanceNo)->where('req_isdeleted','0')->get($this->indentRequest)->result_array();
    }
    public function insertIndentReq($indReq){
        $this->db->insert($this->indentRequest,$indReq);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }
    public function insertIndItem($indItem){
        $record = $this->db->where('ind_req_id',$indItem['ind_req_id'])->where('ind_item_id',$indItem['ind_item_id'])->where('ind_item_type',$indItem['ind_item_type'])->get($this->indentItem)->result_array();
        if(empty($record)){
            $this->db->insert($this->indentItem,$indItem);
        }else{
            $this->db->where('ind_req_id',$indItem['ind_req_id'])->where('ind_item_id',$indItem['ind_item_id'])->where('ind_item_type',$indItem['ind_item_type'])->update($this->indentItem,$indItem);
        }
    }
    // public function editIndentReq($requestId){
    //     $data = "SELECT * "
    //         . "FROM $this->indentRequest as indReq "
    //         . "LEFT JOIN $this->colleague as clg ON (indReq.req_district_manager = clg.clg_ref_id) "
    //         . "LEFT JOIN $this->remark as remark ON (indReq.req_standard_remark = remark.remark_val) "
    //         . "WHERE indReq.req_id = $requestId ";
    //     return $this->db->query($data)->result_array();
    // }
    // public function editIndentReq($requestId){
    //     $data = "SELECT * "
    //         . "FROM $this->colleague as clg ,$this->indentRequest as indReq "
    //         . "WHERE indReq.req_id = $requestId AND FIND_IN_SET(clg.clg_id,indReq.req_district_manager)";
    //     $data1 = $this->db->query($data)->result_array();
    //     print_r($data1);
    // }
    public function editIndentReq($requestId){
        $data = "SELECT * "
            . "FROM $this->indentRequest as indReq "
            . "LEFT JOIN $this->remark as remark ON (indReq.req_standard_remark = remark.remark_val) "
            . "WHERE indReq.req_id = $requestId ";
        $data1 = $this->db->query($data)->result_array();
        $data2 = explode(',',$data1[0]['req_district_manager']);
        
        for ($i=0; $i < count($data2); $i++) { 
            $data1[1][$i] = $this->getDistrictManager($data2[$i]);
        }
        return $data1;
    }
    public function getIndetnReqItem($reqId){
        $item = "SELECT * "
                . "FROM $this->indentItem as item "
                . "LEFT JOIN $this->inventory as inv ON (item.ind_item_id = inv.inv_id AND item.ind_item_type = inv.inv_type) "
                . "LEFT JOIN $this->invMedicine as med ON (item.ind_item_id = med.med_id AND item.ind_item_type = med.med_unit) "
                . "WHERE item.ind_req_id = $reqId AND item.indis_deleted = '0' ";
        return $this->db->query($item)->result_array();
    }
    public function updateIndentReq($requestId,$indReq){
        $this->db->where('req_id',$requestId)->update($this->indentRequest,$indReq);
    }
    public function getRemark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 0, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function indReqRecremark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 3, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function indentReqReceive($requestId){
        $data = "SELECT remark.*, amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk,(SELECT SUM(inv_stk.stk_qty)  "
            . "FROM ems_inventory_stock as inv_stk "
            . "where inv_stk.stk_inv_id = ind.ind_item_id AND inv_stk.stk_inv_type=ind.ind_item_type AND inv_stk.stk_in_out='in') as stk_total,ind.*,inv.inv_title,inv.inv_id,inv_med.med_id,inv_med.med_title,inv_med.med_quantity,inv_med.med_quantity_unit,equipment.eqp_id,equipment.eqp_name,equipment.eqp_base_quantity,ind_req.* "
            . "FROM ems_indent_request as ind_req "
            . "LEFT JOIN ems_indent_item as ind ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN ems_inventory as inv ON (inv.inv_id = ind.ind_item_id) "
            . "LEFT JOIN ems_inventory_medicine as inv_med  ON (inv_med.med_id = ind.ind_item_id) "
            . "LEFT JOIN ems_inventory_equipment as equipment  ON (equipment.eqp_id = ind.ind_item_id) "
            . "LEFT JOIN ems_ambulance_stock as amb_stk  ON (amb_stk.as_item_id = ind.ind_item_id) "
            . "LEFT JOIN $this->remark as remark ON (ind_req.req_standard_remark = remark.remark_val || ind_req.req_approve_remark = remark.remark_val) "
            . "Where req_isdeleted = '0' AND ind.ind_item_type !='EQP' AND ind.ind_req_id= $requestId Group by ind.ind_id";
        return $this->db->query($data)->result_array();
    }
    public function getApproveRema($remark){
        $data =  $this->db->where('remark_val',$remark)->get($this->remark)->result_array();
        if(!empty($data)){
            $approveRem1 = array(
                'id' => (int) $data[0]['id'],
                'value' => $data[0]['remark_val'],
                'name' => $data[0]['message']
            );
            return $approveRem1;
        }
    }
    public function getDispatchRema($remark){
        $data = $this->db->where('remark_val',$remark)->get($this->remark)->result_array();
        if(!empty($data)){
            $dispatchRem1 = array(
                'id' => (int) $data[0]['id'],
                'value' => $data[0]['remark_val'],
                'name' => $data[0]['message']
            );
            return $dispatchRem1;
        }
    }
    public function getReceiveRema($remark){
        $data = $this->db->where('remark_val',$remark)->get($this->remark)->result_array();
        if(!empty($data)){
            $dispatchRem1 = array(
                'id' => (int) $data[0]['id'],
                'value' => $data[0]['remark_val'],
                'name' => $data[0]['message']
            );
            return $dispatchRem1;
        }
    }
    public function updateIndItem($indItem,$updateItem){
        $this->db->where('ind_item_id',$indItem['ind_item_id'])->where('ind_item_type',$indItem['ind_item_type'])->where('ind_req_id',$indItem['ind_req_id'])->update($this->indentItem,$updateItem);
        return 1;
    }
    public function insertAmbStk($ambStk){
        $this->db->insert($this->ambulanceStock,$ambStk);
        return 1;
    }
    public function getIndetnReqEquip($reqId){
        $item = "SELECT * "
                . "FROM $this->indentItem as item "
                . "LEFT JOIN $this->equipment as equp ON (item.ind_item_id = equp.eqp_id) "
                . "WHERE item.ind_req_id = $reqId AND item.indis_deleted = '0' ";
        return $this->db->query($item)->result_array();
    }
    public function equipmentReceive($requestId){
        $data = "SELECT clg.clg_id,clg.clg_ref_id,remark.*, amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk,(SELECT SUM(inv_stk.stk_qty)  "
            . "FROM ems_inventory_stock as inv_stk "
            . "where inv_stk.stk_inv_id = ind.ind_item_id AND inv_stk.stk_inv_type=ind.ind_item_type AND inv_stk.stk_in_out='in') as stk_total,ind.*,equipment.eqp_id,equipment.eqp_name,equipment.eqp_base_quantity,ind_req.* "
            . "FROM ems_indent_request as ind_req "
            . "LEFT JOIN ems_indent_item as ind ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN ems_inventory_equipment as equipment  ON (equipment.eqp_id = ind.ind_item_id) "
            . "LEFT JOIN ems_ambulance_stock as amb_stk  ON (amb_stk.as_item_id = ind.ind_item_id) "
            . "LEFT JOIN $this->colleague as clg ON (ind_req.req_district_manager = clg.clg_ref_id) "
            . "LEFT JOIN $this->remark as remark ON (ind_req.req_standard_remark = remark.remark_val || ind_req.req_approve_remark = remark.remark_val) "
            . "Where req_isdeleted = '0' AND ind.ind_item_type = 'EQP' AND ind.ind_req_id= $requestId Group by ind.ind_item_id";
        return $this->db->query($data)->result_array();
    }
    public function insertOxyFilling($oxy){
        $this->db->insert($this->oxyFilling,$oxy);
        return 1;
    }
    public function updateAmbStatus($ambStstus,$ambulanceNo){
        $this->db->where('amb_rto_register_no',$ambulanceNo)->update($this->ambulance,$ambStstus);
        return 1;
    }
    public function updateOxyFilling($oxy,$requestId){
        $this->db->where('of_id',$requestId)->update($this->oxyFilling,$oxy);
        return 1;
    }
    public function getOxyRemark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 4, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function getOxyUpdateRemark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 5, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function getDistrictManager($district){
        $this->db->select('*');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$district);
        return  $this->db->get()->result_array();
		
		
    }
	   public function getcurrentDistManager($district){
        $data="SELECT *  FROM `ems_colleague` WHERE `clg_group` LIKE 'UG-DM' AND `clg_district_id` LIKE '%$district%' ";
        $data1 =  $this->db->query($data)->result_array();
        return $data1;
    }
	
	
    public function getListOfEquipment($ambulanceNo){
        return $this->db->where('req_amb_reg_no',$ambulanceNo)->where('req_group','EQUP')->where('req_isdeleted','0')->get($this->indentRequest)->result_array();
    }
    public function getfuelstation($fuelStation){
        $data = "SELECT station.f_google_address,station.f_mobile_no"
                ." FROM $this->fuelstation as station"
               ." WHERE station.f_id = '$fuelStation'  ";
        $query = $this->db->query($data)->result_array();
        return $query;
    }
    public function insertfuelfilling($data){
        $this->db->insert($this->fuelfilling,$data);
        return 1;
    }
    public function updatefuelfillings($requestId,$data2){
        $this->db->where('ff_id',$requestId)->update($this->fuelfilling,$data2);
        return 1;
    }
    public function getFuelRemark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 6, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function getFuelUpdateRemark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 7, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function getAmbStatus($ambStatus){
        $this->db->select('ambs_id,ambs_name');
        $this->db->from($this->ambStatus);
        $this->db->where('ambs_id',$ambStatus);
        $this->db->where('ambs_status','1');
        $this->db->where('ambsis_deleted','0');
        return  $this->db->get()->result_array();
    }
    public function insertAmbSummery($summery){
        $this->db->insert($this->ambStatusSummery,$summery);
        return 1;
    }
    public function updateSummery($ambStatus1,$summery){
        $this->db->select('*');
        $this->db->from($this->ambStatusSummery);
        $this->db->where('amb_rto_register_no',$ambStatus1['ambNo']);
        $this->db->where('off_road_status',$ambStatus1['off_road_status']);
        $this->db->where('amb_status',$ambStatus1['amb_status_chk']);
        $this->db->where('on_road_status','');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $data = $this->db->get()->result_array();
        if(!empty($data)){
            $id = $data[0]['id'];
            $this->db->where('id',$id)->update($this->ambStatusSummery,$summery);
            return 1;
        }
    }
    public function insertTimestampRec($timestamp){
        $this->db->insert($this->closure,$timestamp);
        return 1;
    }
    public function getFuelFilling($requestId){
        $data = "SELECT fuel.*,dist.dst_code,dist.dst_name,fuelstation.f_id,fuelstation.f_station_name,remark.* "
            . "FROM $this->fuelfilling as fuel "
            . "LEFT JOIN $this->district as dist ON (fuel.ff_district_code = dist.dst_code AND fuel.ff_state_code = dist.dst_state) "
            . "LEFT JOIN $this->fuelstation fuelstation ON (fuel.ff_fuel_station = fuelstation.f_id) "
            . "LEFT JOIN $this->remark remark ON (fuel.ff_standard_remark = remark.remark_val)"
            . "WHERE fuel.ff_id = '$requestId' ";
        return $this->db->query($data)->result_array();
    }
    public function insertOffRoad($offRoad){
        $this->db->insert($this->offRoadMaintenance,$offRoad);
        return $this->db->insert_id();
    }
    public function insert_media_maintance($media_args_merge) {
        $this->db->insert($this->tbl_media, $media_args_merge);
        return $this->db->insert_id();
    }
    public function insertReReq($rerequest){
        $this->db->insert($this->ambReReqHist, $rerequest);
        return $this->db->insert_id();
    }
    public function updateOffRoad($requestId,$offRoad){
        $this->db->where('mt_id',$requestId)->update($this->offRoadMaintenance,$offRoad);
        return 1;
    }
    public function insertBreakDown($breakdown){
        $this->db->insert($this->breakdownMaintenance,$breakdown);
        return $this->db->insert_id();
    }
    public function getoffroadstndremark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 8, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function updateoffroadstndremark(){
        $data = "SELECT * FROM `ems_app_ambstock_remark` LIMIT 9, 1 ";
        return $this->db->query($data)->result_array();
    }
    public function insertReport($data){
        $this->db->insert($this->report,$data);
    }
    public function getOxygenStation(){
        return $this->db->get($this->oxygentStation)->result_array();
    }
    public function FuelStation(){
        return $this->db->get($this->fuelstation)->result_array();
    }
    public function getEpcrPkId($patientId,$incidentId){
        $this->db->select('pk_id');
        $this->db->from($this->epcr);
        $this->db->where('inc_ref_id',$incidentId);
        $this->db->where('ptn_id',$patientId);
        return  $this->db->get()->result_array();
    }
    public function insertObviousQueAns($obviousQueAns,$data1){
        $data = $this->db->where('ptn_id',$data1['patientId'])->where('inc_ref_id',$data1['incidentId'])->where('sum_que_id',$obviousQueAns['sum_que_id'])->get($this->obviousDeathQueAns)->result_array();
        if(empty($data)){
            $this->db->insert($this->obviousDeathQueAns,$obviousQueAns);
        }else{
            $this->db->where('ptn_id',$data1['patientId'])->where('inc_ref_id',$data1['incidentId'])->where('sum_que_id',$obviousQueAns['sum_que_id'])->update($this->obviousDeathQueAns,$obviousQueAns);
        }
    }
    public function getObviusDeathQueAns($patientId,$incidentId){
        $data = "SELECT *"
           . "FROM $this->obviousDeathQueAns as queans "
           . "LEFT JOIN $this->obviousDeathQue as ques ON (queans.sum_que_id = ques.id) "
           . "WHERE queans.inc_ref_id = '$incidentId' AND  queans.ptn_id = $patientId ";
       return $this->db->query($data)->result_array();
    }
    public function getReportData($incidentId){
       $data = "SELECT COUNT(images) as images,COUNT(video) as video FROM $this->report WHERE incident_id = $incidentId ";
       return $this->db->query($data)->result_array();
    }
    public function insertTyre($tyre){
       $this->db->insert($this->tyreMaintenance,$tyre);
       return $this->db->insert_id();
    }
    public function insertLatLong($data){
        $this->db->insert($this->latlong,$data);
        return 1;
    }
    public function getIncWisePtnId($incidentId){
        return $this->db->where('inc_id',$incidentId)->get($this->incidencePatient)->result_array();
    }
    public function getAmbNo($incidentId){
        return $this->db->where('inc_ref_id',$incidentId)->get($this->incidenceamb)->result_array();
    }
    public function UpdateLatLong($data){
        $data1 = $this->db->where('amb_rto_register_no',$data['vehicleNumber'])->get('ems_ambulance')->result_array();
        if(!empty($data1)){
            if($data1[0]['thirdparty'] == '2'){
                $amb = array(
                    'amb_lat' => $data['lat'],
                    'amb_log' => $data['long']
                );
                $this->db->where('amb_rto_register_no',$data['vehicleNumber'])->update($this->ambulance,$amb);
            }
        }
    }
    
public function checklogindetails(){
    
        $checkLogin = $this->db->where('clg_id',$data['clg_id'])->where('status',1)->get($this->loginSessionTbl)->result_array();
        if(count($checkLogin)==1){
            return 1;
        }else{
            $this->db->insert($this->loginSessionTbl,$data);
        }
    
} 
 public function updateusertOtp($userdata,$data){    
     $this->db->where('clg_id',$userdata)->update($this->colleague,$data);  
     }
   public function getclgdetails($mobilebNo){
        $this->db->select('*');
        $this->db->from($this->colleague);
        $this->db->where('clg_mobile_no',$mobilebNo);
        $this->db->where('clg_group','UG-PILOT');
         $data1 = $this->db->get()->result_array();
        return $data1;
        // $this->db->select('*');
        // $this->db->from($this->colleague);
        // $this->db->where('clg_id',$clgid);
        // //$data1 = $this->db->get()->result_array();
        // $data1 = $this->db->get()->result_array();
        // return $data1;
    }
    public function getclgdetails1($clgid){
        // $this->db->select('*');
        // $this->db->from($this->colleague);
        // $this->db->where('clg_mobile_no',$mobilebNo);
        // $this->db->where('clg_group','UG-PILOT');
        //  $data1 = $this->db->get()->result_array();
        // return $data1;
        $this->db->select('*');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$clgid);
        //$data1 = $this->db->get()->result_array();
        $data1 = $this->db->get()->result_array();
        return $data1;
    }
    public function getincidentdataall($incidentId){
        $data = "SELECT * FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as pt ON inc.inc_ref_id = pt.inc_id WHERE inc.inc_ref_id='$incidentId'";

        return $this->db->query($data)->result_array();
    }
    function insertepcr($data){
        $this->db->insert($this->epcr,$data);
        return $this->db->insert_id();
    }  
    public function getpmcamb($ambnumber){
        $data = "SELECT * FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as pt ON inc.inc_ref_id = pt.inc_id WHERE inc.inc_ref_id='$incidentId'";

        return $this->db->query($data)->result_array();
    }
    public function getlistofuserdoc($documentType,$doclistid){
        $data = "SELECT * FROM ems_clg_documents WHERE documenttype = $documentType AND clg_ref_id = '$doclistid' ";
        $data_array = $this->db->query($data)->result_array();  
        return $data_array;
    } 
    public function getlistofuser($documentType){
        if($documentType==1){
              $data = "SELECT * FROM ems_clg_documents WHERE documenttype = $documentType GROUP BY clg_ref_id ";
            $data_array = $this->db->query($data)->result_array();  
            if(!empty($data_array)){   
                $stockarray = array();
                foreach($data_array as $data1){
                    $stockarray1 = array(
                                'id' => (int) $data1['Clg_Documents_id'],
                                'name' => $data1['clg_ref_id']
                                );
                        array_push($stockarray,$stockarray1);
                }
            } 
        }else{
            $data = "SELECT * FROM ems_clg_documents WHERE documenttype = $documentType GROUP BY amb_number ";
            $data_array = $this->db->query($data)->result_array();
            if(!empty($data_array)){ 
                $stockarray = array();
                foreach($data_array as $data1){
                    $stockarray1 = array(
                                'id' => (int) $data1['Clg_Documents_id'],
                                'name' => $data1['amb_number']
                                );
                array_push($stockarray,$stockarray1);
                }
            }
        }
        return $stockarray; 
    } 
    function insertqualitycheck($data){
        $this->db->insert($this->qualitycheck,$data);
        return $this->db->insert_id();
    }  
    function insertqualitycheckdetails($data){
        $this->db->insert($this->qualitydetails,$data);
        return $this->db->insert_id();
    } 
    function getquestionsofquality($type){
        if($type=="MEDICINES" OR $type=="CONSUMABLES" ){
           if($type=="MEDICINES") {
                $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='MEDICINES' ";
           }else{
                $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='CONSUMABLES' ";
           }
            $data1=$this->db->query($data)->result_array();
            if(!empty($data1)){
                $questionist = array();
                foreach ($data1 as $value) {   
                    $questions = array(
                    'id' => (int) $value['qa_ques_id'],
                    'name' => $value['qa_ques'],
                    'min_quantity' =>(int) $value['min_quantity'],
                    'max_quantity' =>(int) $value['max_quantity'],
                    'outofMarks' =>(int) $value['outof_marks']
                    
                    );
                    array_push($questionist,$questions);
                }
                return $questionist;
            }
            else
            {
              $questions ='';
                return $questions;
            }
        }else{
            if($type=="DOCUMENTS_EMSO") {
                    $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='DOCUMENTS_EMSO' ";   
            }elseif($type=="DOCUMENTS_PILOT"){
                $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='DOCUMENTS_PILOT' "; 
            }
            elseif($type=="EQUIPMENT_ALS"){
                $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='EQUIPMENT_ALS' "; 
            }
            elseif($type=="VEHICAL"){
            
                $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='VEHICAL' "; 
            }
            elseif($type=="EQUIPMENT_BLS"){
            
                    $data = "SELECT * FROM `ems_mas_quality_check` WHERE qa_is_deleted='0' AND qa_ques_type='EQUIPMENT_BLS' ";
            }
            $data1=$this->db->query($data)->result_array();
            if(!empty($data1)){
                $questionist = array();
                foreach ($data1 as $value) {   
                    $questions = array(
                        'id' => (int) $value['qa_ques_id'],
                        'name' => $value['qa_ques'],
                        'outofMarks' =>(int) $value['outof_marks']
                    );
                    array_push($questionist,$questions);
                }
                return $questionist;
            }
            else
            {
              $questions ='';
             return $questions;
            }
        
        }
    }  
    public function getdatedleave($fromDate,$toDate,$current_date,$format = "Y-m-d"){
        if($fromDate == '' || $toDate = ''){
             $data = "SELECT * FROM ems_colleague_leave WHERE Leave_status='2' AND (clg_group ='UG-EMT' OR clg_group ='UG-Pilot' ) AND '$current_date' BETWEEN date_form AND date_to GROUP By colleague_leave_id ORDER BY date_to DESC ";
            return $this->db->query($data)->result_array();
        }else{                       
            $begin = new DateTime($fromDate);
            $todate = new DateTime($toDate);
            $interval = new DateInterval('P1D'); // 1 Day
            $dateRange = new DatePeriod($begin, $interval, $todate);
            $leavelist1 = array();
            foreach ($dateRange as $date) {
                $date = $date->format($format);
                $data = "SELECT * FROM ems_colleague_leave WHERE Leave_status=2 AND (clg_group ='UG-EMT' OR clg_group ='UG-Pilot' OR clg_group ='UG-PILOT' ) AND '$date' BETWEEN date_form AND date_to GROUP By colleague_leave_id ORDER BY date_to DESC ";
                $leavesdetails=$this->db->query($data)->result_array();
                array_push($leavelist1,$leavesdetails);
            }
            $leavelist1 =  array_values(array_map("unserialize", array_unique(array_map("serialize", $leavelist1))));
            return $leavelist1;
        }
    }  
    public function getcurrentAmbStatus($ambStatus){
        $this->db->select('*');
        $this->db->from($this->ambStatus);
        $this->db->where('ambs_id',$ambStatus);
        $this->db->where('ambs_status','1');
        $this->db->where('ambsis_deleted','0');
        return  $this->db->get()->result_array();
    }  
    public function getamblogindetails($id){
        $data = "SELECT * FROM `ems_app_login_session` As lg "
           ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
           ."WHERE  lg.status = '1' AND lg.vehicle_no = '$id' ";
           $loginData = $this->db->query($data)->result_array();
        return $loginData;
    }
    function getcheckins($checkInid){
        $data = "SELECT * FROM ems_attendance Where status = 1 AND clg_id = $checkInid   ORDER BY attendance_id  DESC  LIMIT 1";
        $checkId=$this->db->query($data)->result_array();
        return $checkId;
    }  
    function getcheckoutdetails($checkInid,$out_time){
        $data = "SELECT * FROM ems_attendance Where status = 1 AND clg_id = $checkInid AND check_in <= '$out_time'  ORDER BY attendance_id  DESC  LIMIT 1";
        $checkId=$this->db->query($data)->result_array();
        return $checkId;
    } 
    function updatecheckout($data,$checkInid){
        $checkId = $this->db->where('attendance_id',$checkInid)->limit(1)->get($this->attendance)->result_array();
        if(empty($checkId)){
            return 0;
        }else{
            $this->db->where('attendance_id',$checkInid)->update($this->attendance,$data);
             return $checkInid;
        }
    }
    function insertattendance($data) {
        $this->db->insert($this->attendance, $data);
        return $this->db->insert_id();
    }
    public function logindetails($id,$type,$usertype){
        if($type == 3){
            $this->db->select('*');
            $this->db->from($this->loginSessionTbl);
            $this->db->where('vehicle_no',$id);
            $this->db->where('status',1);
            $this->db->where('login_type',$usertype);
            $data = $this->db->get()->result_array();
            return $data;
            }
        else{
            $data = $this->db->where('clg_id',$id)->where('status',1)->get($this->loginSessionTbl)->result_array();
               return $data;
            
        }
    } 
    public function demotrainigndetails($requestId){
        $data="SELECT * FROM ems_fleet_demo_training as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.dt_district_code) WHERE t1.dt_id='$requestId' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }      
    public function maintaincehisotory($requestId,$maintenanceType){
        if($maintenanceType == 7){
        $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = $requestId AND hist.re_mt_type = 'accidental' ORDER BY hist.re_id DESC LIMIT 1 ";
        $data1 =  $this->db->query($chk)->result_array();
        return $data1;
        }
        elseif($maintenanceType == 14){
        $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = $requestId AND hist.re_mt_type = 'tyre' ORDER BY hist.re_id DESC LIMIT 1 ";
        $data1 =  $this->db->query($chk)->result_array();
        return $data1;
        }
        elseif($maintenanceType == 12){
        $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = $requestId AND hist.re_mt_type = 'onroad_offroad' ORDER BY hist.re_id DESC LIMIT 1 ";
        $data1 =  $this->db->query($chk)->result_array();
        return $data1;
        }
        elseif($maintenanceType == 16){
        $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = $requestId AND hist.re_mt_type = 'preventive' ORDER BY hist.re_id DESC LIMIT 1 ";
        $data1 =  $this->db->query($chk)->result_array();
        return $data1;
        }
        elseif($maintenanceType == 18){
        $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = $requestId AND hist.re_mt_type = 'breakdown' ORDER BY hist.re_id DESC LIMIT 1 ";
        $data1 =  $this->db->query($chk)->result_array();
        return $data1;
        }  
   }
   public function getoxygenfillingDetails($requestId){       
        $data="SELECT * FROM ems_fleet_oxygen_filling as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.of_district_code) LEFT JOIN ems_oxygen_service_center as ox on ox.os_id=t1.of_oxygen_station WHERE t1.of_id = '$requestId' ";
        $data1 = $this->db->query($data)->result_array();
       return $data1;
    }    
    public function getfuelfillingDetails($requestId){
        $data="SELECT * FROM ems_fleet_fuel_filling as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.ff_district_code) LEFT JOIN ems_fuel_station as t2 ON t2.f_id =t1.ff_fuel_station WHERE t1.ff_id = '$requestId' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }      
    public function visitorsdetails($requestId){
        $data="SELECT * FROM ems_visitor_update as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.vs_district_code) WHERE t1.vs_id= '$requestId' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    } 
    public function getaddedemolist($begin,$pageSize){
        if($pageSize=='0')
        {
            $data= "SELECT * FROM ems_fleet_demo_training as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.dt_district_code) ORDER BY dt_id DESC";   
        }
        else{     
            $data="SELECT * FROM ems_fleet_demo_training as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.dt_district_code) ORDER BY dt_id DESC LIMIT $begin, $pageSize  ";  
        } 
        $data1 = $this->db->query($data)->result_array();
        return $data1;  
        $data = "SELECT * FROM ems_visitor_update ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    } 
    public function getaddedlistvisitors($begin,$pageSize){
        if($pageSize=='0')
        {
            $data= "SELECT * FROM ems_visitor_update as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.vs_district_code) ORDER BY vs_added_date DESC";
        }
        else{     
            $data="SELECT * FROM ems_visitor_update as t1 LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.vs_district_code) ORDER BY vs_added_date DESC LIMIT $begin, $pageSize  ";
        }    
        $data1 = $this->db->query($data)->result_array();
        return $data1;  
        $data = "SELECT * FROM ems_visitor_update ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    } 
    public function getalllistFuelfilling($begin,$pageSize){
        if($pageSize=='0')
        {
            $data= "SELECT * FROM ems_fleet_fuel_filling as t1  LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.ff_district_code) ORDER BY ff_added_date DESC ";   
        }
        else{     
            $data="SELECT * FROM ems_fleet_fuel_filling as t1  LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.ff_district_code)   ORDER BY ff_added_date DESC LIMIT $begin, $pageSize  "; 
        }      
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getalllistOxygenfilling($begin,$pageSize){
        if($pageSize=='0')
        {
            $data= "SELECT * FROM ems_fleet_oxygen_filling as t1  LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.of_district_code) ORDER BY of_added_date DESC ";  
        }
        else{     
            $data="SELECT * FROM ems_fleet_oxygen_filling as t1  LEFT JOIN ems_mas_districts as district ON (district.dst_code = t1.of_district_code)   ORDER BY of_added_date DESC LIMIT $begin, $pageSize  "; 
        }    
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function updatemaintaincedata($updatedata,$reqId,$maintenanceType){ 
        if($maintenanceType == '7'){
            $result=  $this->db->where('mt_id',$reqId)->update($this->accidentalMaintenance,$updatedata);
        }else if($maintenanceType == '14'){
            $result= $this->db->where('mt_id',$reqId)->update($this->tyreMaintenance,$updatedata);
        }else if($maintenanceType == '18'){
          $result=   $this->db->where('mt_id',$reqId)->update($this->breakdownMaintenance,$updatedata);
        }else if($maintenanceType == '12'){
          $result=  $this->db->where('mt_id',$reqId)->update($this->offRoadMaintenance,$updatedata);
        }else if($maintenanceType == '16'){
            $result=  $this->db->where('mt_id',$reqId)->update($this->preventivemaintenance,$updatedata);
        }
        return $result;
    }
    public function getoffroadmaintanceDetails($requestId){
        $data="SELECT * FROM ems_amb_onroad_offroad WHERE mt_id = '$requestId' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }  
    public function getpreventivemaintenanceDetails($requestId){
        $data="SELECT * FROM ems_ambulance_preventive_maintaince WHERE mt_id = '$requestId' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getAccidentalDetails($requestId){
        $query="SELECT * FROM ems_amb_accidental_maintaince WHERE mt_id = '$requestId' ";
        $data = $this->db->query($query)->result_array();
        return $data;
    }
    public function getbreakdownDetails($requestId){
        $query="SELECT * FROM ems_amb_breakdown_maintaince WHERE mt_id = '$requestId' ";
        $data = $this->db->query($query)->result_array();
        return $data;
    }
    public function gettyremaintanceDetails($requestId){
        $data="SELECT * FROM ems_amb_tyre_maintaince WHERE mt_id = '$requestId' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getmedia($requestId,$mediatype){
        if($mediatype==1){
            $data="SELECT * FROM ems_media WHERE user_id = '$requestId' AND media_data='accidental' ";
            $data1 = $this->db->query($data)->result_array();
            $mediaData=array();
            foreach($data1 as $data12){
                $tyreData1="http://www.speroems.com/jkemsnewinstance/uploads/ambulance/accidental/". $data12['media_name'];
                array_push($mediaData,$tyreData1);
            }
        }
        elseif($mediatype==2){
            $data="SELECT * FROM ems_media WHERE user_id = '$requestId' AND media_data='breakdown' ";
            $data1 = $this->db->query($data)->result_array();
            $mediaData=array();
            foreach($data1 as $data12){
                $tyreData1 = "http://www.speroems.com/jkemsnewinstance/uploads/ambulance/breakdown/". $data12['media_name'];
                array_push($mediaData,$tyreData1);
            }
        }
          elseif($mediatype==3){
            $data="SELECT * FROM ems_media WHERE user_id = '$requestId' AND media_data='tyre' ";
            $data1 = $this->db->query($data)->result_array();
            $mediaData=array();
            foreach($data1 as $data12){
                $tyreData1= "http://www.speroems.com/jkemsnewinstance/uploads/ambulance/tyre/". $data12['media_name'];
                array_push($mediaData,$tyreData1);
            }
        }
        elseif($mediatype==4){
            $data="SELECT * FROM ems_media WHERE user_id = '$requestId' AND media_data='onroad_offroad' ";
            $data1 = $this->db->query($data)->result_array();
            $mediaData=array();
            foreach($data1 as $data12){
                $tyreData1="http://www.speroems.com/jkemsnewinstance/uploads/ambulance/offroad/". $data12['media_name'];
                array_push($mediaData,$tyreData1);
            }
        }      
        elseif($mediatype==5){
            $data="SELECT * FROM ems_media WHERE user_id = '$requestId' AND media_data='preventive' ";
            $data1 = $this->db->query($data)->result_array();
            $mediaData=array();
            foreach($data1 as $data12){
                $tyreData1 = "http://www.speroems.com/jkemsnewinstance/uploads/ambulance/preventive/". $data12['media_name'];  
                array_push($mediaData,$tyreData1);
            }
        }
        elseif($mediatype==6){
            $data="SELECT * FROM ems_media WHERE user_id = '$requestId' AND media_data='training' ";
            $data1 = $this->db->query($data)->result_array();
            $mediaData=array();
            foreach($data1 as $data12){
                $tyreData1 = "http://www.speroems.com/jkemsnewinstance/uploads/ambulance/training/". $data12['media_name'];
                array_push($mediaData,$tyreData1);
            }
        }
        return $mediaData;
    } 
    public function getMaintenanceListOUsr($maintenanceType,$data){
        $tyreData = array();
        if($maintenanceType == 14){
            $tyre1 = 'tyre';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->tyreMaintenance as tyre ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->tyreMaintenance as tyre ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }else if($maintenanceType == 7){
            $tyre1 = 'accidental';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->accidentalMaintenance as tyre ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->accidentalMaintenance as tyre ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }else if($maintenanceType == 18){
            $tyre1 = 'breakdown';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->breakdownMaintenance as tyre ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->breakdownMaintenance as tyre ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }else if($maintenanceType == 12){
            $tyre1 = 'onroad_offroad';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->offRoadMaintenance as tyre ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->offRoadMaintenance as tyre ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }
        else if($maintenanceType == 16){
            $tyre1 = 'preventive';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->preventivemaintenance as tyre ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->preventivemaintenance as tyre ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }
       
        foreach($data as $data1){
            $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = '".$data1['mt_id']."' AND hist.re_mt_type = '".$tyre1."' ORDER BY hist.re_id DESC LIMIT 1 ";
         
            $approve =  $this->db->query($chk)->result_array();
            if($data1['mt_ambulance_status'] == "Available"){
                if(!empty($data1['mt_approved_cost'])){
                        $approvedcost = $data1['mt_approved_cost'];
                }else{
                    if($maintenanceType == 7){
                        $approvedcost = $data1['mt_Estimatecost'];
                    } else if($maintenanceType == 12){
                        $approvedcost = $data1['mt_Estimatecost'];
                    }
                    else if($maintenanceType == 14){
                        $approvedcost = $data1['mt_estimate_cost'];
                    } else if($maintenanceType == 16){
                        $approvedcost = $data1['mt_estimatecost'];
                    }
                    else if($maintenanceType == 18){
                        $approvedcost = $data1['mt_Estimatecost'];
                    }
                }
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                    'status' => 'Completed',
                    'approvedCost'=>$approvedcost,
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }
                     
            else if(empty($approve) || ($approve[0]['re_approval_rerequest'] == '0')){
                 $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Pending',
                     'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                     'approvedCost'=>" ",
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }else if($approve[0]['re_approval_status'] == '1'){
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],    
                    'status' => 'Rejected',
                    'approvedCost'=>" ",
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }else{
                if(!empty($data1['mt_approved_cost']))
                {
                    $approvedcost = $data1['mt_approved_cost'];
                }else{
                     if($maintenanceType == 7){
                     $approvedcost = $data1['mt_Estimatecost'];
                     } else if($maintenanceType == 12){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                    else if($maintenanceType == 14){
                     $approvedcost = $data1['mt_estimate_cost'];
                     } else if($maintenanceType == 16){
                      $approvedcost = $data1['mt_estimatecost'];
                     }
                     else if($maintenanceType == 18){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                }
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Approved',
                     'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                     'approvedCost'=>$approvedcost,
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }
            array_push($tyreData,$tyreData1);
        }
        return $tyreData;
    }
    public function insertAprroveRejData($data){
        $this->db->insert($this->accidentalMainHist,$data);
        return 1;
    }
    public function getallListOfEquipment($pageSize,$begin){
        if($pageSize=='0'){
            $data="SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,
            SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) 
            as out_stk FROM (ems_indent_request as ind_req,ems_ambulance as amb)
                LEFT JOIN ems_ambulance_stock AS amb_stk ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no)
                LEFT JOIN ems_hospital as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_states as state ON ( state.st_code = ind_req.req_state_code )
                LEFT JOIN ems_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )
                LEFT JOIN ems_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id)
                where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no AND ind_req.req_group = 'EQUP' 
            Group By ind_req.req_id ORDER BY ind_req.req_date ASC";
        }
        else
        {
            $data="SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,
            SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) 
            as out_stk FROM (ems_indent_request as ind_req,ems_ambulance as amb)
                LEFT JOIN ems_ambulance_stock AS amb_stk ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no)
                LEFT JOIN ems_hospital as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_states as state ON ( state.st_code = ind_req.req_state_code )
                LEFT JOIN ems_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )
                LEFT JOIN ems_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id)
                where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no AND ind_req.req_group = 'EQUP' 
            Group By ind_req.req_id ORDER BY ind_req.req_date ASC LIMIT $begin, $pageSize";
        }
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    function update_ind_dispatch($data,$indid) {
        $checkId = $this->db->where('req_id',$indid)->get($this->indentRequest)->result_array();
        if(empty($checkId)){
             return 1;
        }else{
             $this->db->where('req_id',$indid)->update($this->indentRequest,$data);
        }
    }
    public function insertinvitem($data){
        $this->db->insert($this->invstock,$data);
        return 1;
    }
    function approve_ind_req($data,$reqid) {
        $checkId = $this->db->where('req_id',$reqid)->get($this->indentRequest)->result_array();
            if(empty($checkId)){
                return 1;
            }else{
                $this->db->where('req_id',$reqid)->update($this->indentRequest,$data);
            }
        }
    function update_ind_item($data,$indid) {
        $this->db->where('ind_id',$indid)->update($this->indentItem,$data);
        return $result;
    }
    function getallindentreqfordispatch() {
        $data="SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,
               SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) 
               as out_stk FROM (ems_indent_request as ind_req,ems_ambulance as amb)
                LEFT JOIN ems_ambulance_stock AS amb_stk ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no)
                LEFT JOIN ems_hospital as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_states as state ON ( state.st_code = ind_req.req_state_code )
                LEFT JOIN ems_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )
                LEFT JOIN ems_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id)
                where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no AND ind_req.req_group = 'IND' AND ind_req.req_is_approve ='1'
               Group By ind_req.req_id ORDER BY ind_req.req_date ASC";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    function getallindentreq($begin,$pageSize) {
        /* $sql = "SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk "
             . "FROM ($this->tbl_ind_req as ind_req,$this->tbl_ambulance as amb) "
             . "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
             . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
             . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = ind_req.req_state_code ) "
             . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )"
             . "LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
             . "where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no  Group By ind_req.req_id ORDER BY ind_req.req_date DESC ";*/
        if($pageSize=='0')
        {
            $data= "SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,
                SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) 
                as out_stk FROM (ems_indent_request as ind_req,ems_ambulance as amb)
                LEFT JOIN ems_ambulance_stock AS amb_stk ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no)
                LEFT JOIN ems_hospital as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_states as state ON ( state.st_code = ind_req.req_state_code )
                LEFT JOIN ems_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )
                LEFT JOIN ems_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id)
                where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no AND ind_req.req_group = 'IND'
                Group By ind_req.req_id ORDER BY ind_req.req_date DESC ";
        }
        else{     
              $data="SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,
                 SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) 
                 as out_stk FROM (ems_indent_request as ind_req,ems_ambulance as amb)
                  LEFT JOIN ems_ambulance_stock AS amb_stk ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no)
                  LEFT JOIN ems_hospital as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_states as state ON ( state.st_code = ind_req.req_state_code )
                  LEFT JOIN ems_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )
                  LEFT JOIN ems_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id)
                  where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no AND ind_req.req_group = 'IND'
                 Group By ind_req.req_id ORDER BY ind_req.req_date DESC LIMIT $begin, $pageSize  ";
        }      
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getallListOfIndentReq(){
        $this->db->select('*');    
        $this->db->from($this->indentRequest);
        //$this->db->where('req_amb_reg_no',$ambulanceNo);
        $this->db->where('req_isdeleted','0');
        $this->db->where('req_group != ','EQUP');
        return  $this->db->get()->result_array();
        // return $this->db->where('req_amb_reg_no',$ambulanceNo)->where('req_isdeleted','0')->get($this->indentRequest)->result_array();
    }
    function updatefeedback($data,$feedbackId){
        $checkId = $this->db->where('app_feedback_id',$feedbackId)->get($this->feedback)->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('app_feedback_id',$feedbackId)->update($this->feedback,$data);
        }
    }
    function insertappfeedback($data){
        $this->db->insert($this->feedback,$data);
        return $this->db->insert_id();
    }
    public function updatePreventiveMaintennance($requestId,$tyre){
        $this->db->where('mt_id',$requestId)->update($this->preventivemaintenance,$tyre);
        return 1;
    }
    public function insertusertOtp($data,$userid){
        $this->db->where('clg_id',$userid)->update($this->colleague,$data);
    }
    public function insertPreventiveRoad($preventive){
        $this->db->insert($this->preventivemaintenance,$preventive);
        return $this->db->insert_id();
    }
    public function insertAccidentalMaintenance($accidental){
        $this->db->insert($this->accidentalMaintenance,$accidental);
        return $this->db->insert_id();
    }
    public function getclgMobNo($userid){
        $this->db->select('clg_mobile_no');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$userid);
        return $this->db->get()->row()->clg_mobile_no;
    }
    public function getClgid($userName)
    {
        $data = "SELECT * from ems_colleague WHERE clg_ref_id='$userName' AND clg_is_active='1' AND clg_is_deleted='0' ";
        $data1 = $this->db->query($data)->result_array();
        if(!empty($data1)){
            $Userid=$data1[0]['clg_id'];
           return $Userid;   
        }
        else{
            return 0;
        }
    }
    public function getambwiseinc($searchfor,$fromDate,$toDate,$ambnumber,$inctype,$begin,$pageSize){
        if(!empty($searchfor))
        {
             if(!empty($toDate))
            {
               $toDate=$toDate; 
            }
            else
            {
                $toDate = date('Y-m-d H:i:s');
            }
            if($inctype==1 && !empty($fromDate)){
                
                 $condition="(epcr.pilot_name LIKE '%" . trim($searchfor) . "%' OR epcr.emt_name LIKE '%" . trim($searchfor) . "%' ) AND (inc.inc_datetime BETWEEN '$fromDate' AND '$toDate') AND incamb.amb_rto_register_no= '$ambnumber' AND  inc.inc_pcr_status = '0' ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize";
            }
           elseif($inctype==2 && !empty($fromDate))
           {
               $condition="(epcr.pilot_name LIKE '%" . trim($searchfor) . "%' OR epcr.emt_name LIKE '%" . trim($searchfor) . "%' ) AND (inc.inc_datetime BETWEEN '$fromDate' AND '$toDate') AND incamb.amb_rto_register_no= '$ambnumber' AND  inc.inc_pcr_status = '1' ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize";
           }
           else
           {
             $condition="(epcr.pilot_name LIKE '%" . trim($searchfor) . "%' OR epcr.emt_name LIKE '%" . trim($searchfor) . "%' ) AND (inc.inc_datetime BETWEEN '$fromDate' AND '$toDate') AND incamb.amb_rto_register_no= '$ambnumber'  ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize";
           }
            $data ="SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,epcr.*,inc.inc_ref_id as refid FROM ems_incidence_ambulance AS incamb 
                   LEFT JOIN ems_driver_parameters AS para ON (para.incident_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_calls AS cls ON (cls.cl_id = inc.inc_cl_id) 
                   LEFT JOIN ems_callers AS clr ON (clr.clr_id = cls.cl_clr_id) 
                   LEFT JOIN ems_mas_relation AS rel ON (cls.clr_ralation = rel.rel_id) 
                   LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id ) 
                   LEFT JOIN ems_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
                   LEFT JOIN ems_mas_patient_complaint_types as pc on(pc.ct_id=inc.inc_complaint)
                   LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id
                    WHERE $condition ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif(!empty($fromDate))
        {
            if(!empty($toDate))
            {
               $toDate=$toDate; 
            }
            else
            {
                $toDate = date('Y-m-d H:i:s');
            }
            if($inctype==1){
                $condition="(inc.inc_datetime BETWEEN '$fromDate' AND '$toDate') AND incamb.amb_rto_register_no= '$ambnumber' AND  inc.inc_pcr_status = '0' ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize";
            }
           elseif($inctype==2)
           {
               $condition="(inc.inc_datetime BETWEEN '$fromDate' AND '$toDate') AND incamb.amb_rto_register_no= '$ambnumber' AND  inc.inc_pcr_status = '1' ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize";
           }
           else
           {
             $condition="(inc.inc_datetime BETWEEN '$fromDate' AND '$toDate') AND incamb.amb_rto_register_no= '$ambnumber'  ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize";
           }
            $data = "SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,epcr.*,inc.inc_ref_id as refid FROM ems_incidence_ambulance AS incamb 
                   LEFT JOIN ems_driver_parameters AS para ON (para.incident_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_calls AS cls ON (cls.cl_id = inc.inc_cl_id) 
                   LEFT JOIN ems_callers AS clr ON (clr.clr_id = cls.cl_clr_id) 
                   LEFT JOIN ems_mas_relation AS rel ON (cls.clr_ralation = rel.rel_id) 
                   LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id ) 
                   LEFT JOIN ems_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
                   LEFT JOIN ems_mas_patient_complaint_types as pc on(pc.ct_id=inc.inc_complaint)
                   LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id
                   WHERE $condition ";
            $data1 = $this->db->query($data)->result_array();
            return $data1; 
        }
        elseif($inctype==1){
            $data="SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,epcr.*,inc.inc_ref_id as refid FROM ems_incidence_ambulance AS incamb 
                   LEFT JOIN ems_driver_parameters AS para ON (para.incident_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_calls AS cls ON (cls.cl_id = inc.inc_cl_id) 
                   LEFT JOIN ems_callers AS clr ON (clr.clr_id = cls.cl_clr_id) 
                   LEFT JOIN ems_mas_relation AS rel ON (cls.clr_ralation = rel.rel_id) 
                   LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id ) 
                   LEFT JOIN ems_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
                   LEFT JOIN ems_mas_patient_complaint_types as pc on(pc.ct_id=inc.inc_complaint)
                   LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id
                   WHERE incamb.amb_rto_register_no = '$ambnumber' AND inc.inc_pcr_status = '0'  GROUP BY inc.inc_ref_id ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize "; 
            // $data = "SELECT t1.inc_ref_id,t1.amb_rto_register_no,inc.inc_pcr_status,epcr.emt_name,epcr.pilot_name,inc.inc_datetime,clr.clr_fname, clr.clr_mname,clr.clr_lname from ems_incidence_ambulance as t1 JOIN ems_incidence as inc on t1.inc_ref_id=inc.inc_ref_id LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id) WHERE (inc.inc_pcr_status = $incstatus) AND (t1.amb_rto_register_no= '$ambnumber') GROUP BY t1.inc_ref_id  LIMIT $begin,$pageSize ";
            $data1 = $this->db->query($data)->result_array();
            return $data1; 
        } 
        elseif($inctype==2)
        {
            $data="SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,epcr.*,inc.inc_ref_id as refid FROM ems_incidence_ambulance AS incamb 
            LEFT JOIN ems_driver_parameters AS para ON (para.incident_id = incamb.inc_ref_id) 
            LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) 
            LEFT JOIN ems_calls AS cls ON (cls.cl_id = inc.inc_cl_id) 
            LEFT JOIN ems_callers AS clr ON (clr.clr_id = cls.cl_clr_id) 
            LEFT JOIN ems_mas_relation AS rel ON (cls.clr_ralation = rel.rel_id) 
            LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id ) 
            LEFT JOIN ems_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
            LEFT JOIN ems_mas_patient_complaint_types as pc on(pc.ct_id=inc.inc_complaint)
            LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id
            WHERE incamb.amb_rto_register_no = '$ambnumber' AND inc.inc_pcr_status = '1'  GROUP BY inc.inc_ref_id ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize"; 
            // $data = "SELECT t1.inc_ref_id,t1.amb_rto_register_no,inc.inc_pcr_status,epcr.emt_name,epcr.pilot_name,inc.inc_datetime,clr.clr_fname, clr.clr_mname,clr.clr_lname from ems_incidence_ambulance as t1 JOIN ems_incidence as inc on t1.inc_ref_id=inc.inc_ref_id LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id) WHERE (inc.inc_pcr_status = $incstatus) AND (t1.amb_rto_register_no= '$ambnumber') GROUP BY t1.inc_ref_id  LIMIT $begin,$pageSize ";
            $data1 = $this->db->query($data)->result_array();
            return $data1; 
        }
        else
        { 
            $data="SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*,epcr.*,inc.inc_ref_id as refid FROM ems_incidence_ambulance AS incamb 
                   LEFT JOIN ems_driver_parameters AS para ON (para.incident_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) 
                   LEFT JOIN ems_calls AS cls ON (cls.cl_id = inc.inc_cl_id) 
                   LEFT JOIN ems_callers AS clr ON (clr.clr_id = cls.cl_clr_id) 
                   LEFT JOIN ems_mas_relation AS rel ON (cls.clr_ralation = rel.rel_id) 
                   LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id ) 
                   LEFT JOIN ems_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature) 
                   LEFT JOIN ems_mas_patient_complaint_types as pc on(pc.ct_id=inc.inc_complaint)
                   LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id
                   WHERE incamb.amb_rto_register_no = '$ambnumber'  GROUP BY inc.inc_ref_id ORDER BY incamb.assigned_time DESC LIMIT $begin,$pageSize"; 
            //$data = " SELECT t1.inc_ref_id,t1.amb_rto_register_no,inc.inc_pcr_status,epcr.emt_name,epcr.pilot_name,inc.inc_datetime,clr.clr_fname, clr.clr_mname,clr.clr_lname from ems_incidence_ambulance as t1 JOIN ems_incidence as inc on t1.inc_ref_id=inc.inc_ref_id LEFT JOIN ems_epcr as epcr ON inc.inc_ref_id=epcr.inc_ref_id LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id) WHERE t1.amb_rto_register_no= '$ambnumber' LIMIT $begin,$pageSize ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }  
    }
    public function getloginpilot($id){
        $data = "SELECT * from ems_app_login_session WHERE type_id=3 AND login_type='D' AND vehicle_no='$id' AND status='1' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getloginpilotdetails($loginUser){
        $data = "SELECT * FROM ems_colleague WHERE  clg_ref_id='$loginUser' AND clg_group='UG-PILOT' ";
       
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getambdetails($ambid){
        $data = "SELECT * FROM `ems_ambulance` WHERE amb_id = '$ambid' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getamblist($id){
        $data = "SELECT * FROM `ems_ambulance` WHERE ambis_deleted = '0' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function getclgmodule($id,$type,$usergroup){
        if($type==3){
            $data = "SELECT * FROM ems_app_assigned_module as t1 JOIN ems_app_module as t2 ON t1.module_id=t2.moduleid WHERE t1.clg_group='UG-BOTH' AND t1.status='1'  ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($type==4){
            $data = "SELECT * FROM ems_app_assigned_module as t1 JOIN ems_app_module as t2 ON t1.module_id=t2.moduleid WHERE t1.clg_group='$usergroup' AND t1.status='1' ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($type==1){
            $data = "SELECT * FROM ems_app_assigned_module as t1 JOIN ems_app_module as t2 ON t1.module_id=t2.moduleid WHERE t1.clg_group='UG-Pilot' AND t1.status='1' ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($type==2){
         $data = "SELECT * FROM ems_app_assigned_module as t1 JOIN ems_app_module as t2 ON t1.module_id=t2.moduleid WHERE t1.clg_group='UG-EMT' AND t1.status='1' ";
         $data1 = $this->db->query($data)->result_array();
         return $data1;
        }
    }
    public function getinventoryname1($inventoryType,$Ambulanceno){
        if($inventoryType==1)
        {
            //medicine unit data
            //$data= "SELECT * FROM ems_inventory_medicine as  t2 JOIN  ems_ambulance_stock as t1 on t2.med_id=t1.as_item_id WHERE t2.med_unit ='MCA'   ORDER BY t1.as_item_qty ASC "; 
            $data = "SELECT * FROM ems_inventory_medicine as  t2 JOIN  ems_ambulance_stock as t1 on t2.med_id=t1.as_item_id WHERE t2.med_unit ='MCA' AND t1.amb_rto_register_no='$Ambulanceno' GROUP BY t2.med_id ORDER BY t1.as_item_qty ASC ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($inventoryType==2)
        {
            //medicine non unit data
            $data = "SELECT * FROM ems_inventory_medicine as  t2 JOIN  ems_ambulance_stock as t1 on t2.med_id=t1.as_item_id WHERE t2.med_unit ='MNCA' AND t1.amb_rto_register_no='$Ambulanceno' GROUP BY t2.med_id ORDER BY t1.as_item_qty ASC ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($inventoryType==3)
        {
            //consumables unit data
            $data = "SELECT * FROM ems_inventory as t2 JOIN ems_ambulance_stock as t1 on t2.inv_id=t1.as_item_id WHERE t1.as_item_type='CA' AND t1.amb_rto_register_no='$Ambulanceno' GROUP BY t2.inv_id ORDER BY t1.as_item_qty ASC ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($inventoryType==4)
        {
            //consumbles non unit data
            $data = "SELECT * FROM ems_inventory as t2 JOIN ems_ambulance_stock as t1 on t2.inv_id=t1.as_item_id WHERE t1.as_item_type='NCA' AND t1.amb_rto_register_no='$Ambulanceno'  GROUP BY t2.inv_id  ORDER BY t1.as_item_qty ASC ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
            elseif($inventoryType==5)
        {
            //equiment data
            $data = "SELECT * FROM ems_inventory_equipment  as t2 JOIN ems_ambulance_stock as t1 on t2.eqp_id=t1.as_item_id WHERE t1.as_item_type='EQP' AND t1.amb_rto_register_no='$Ambulanceno'  GROUP BY t2.eqp_id ORDER BY t1.as_item_qty ASC";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        //$str = $this->db->last_query();
        // print_r($str);
        // die();
    }
    public function getinventoryname($inventoryType,$Ambulanceno){
        if($inventoryType == 'MCA' || $inventoryType == 'MNCA'){
            // $med = $this->db->where('med_unit',$inventoryType)->where('med_type','amb')->where('medis_deleted','0')->get('ems_inventory_medicine')->result_array();
            // $stk = "SELECT a.as_id,a.as_item_id,a.as_item_type, "
            // ."(SELECT COUNT(*) FROM ems_ambulance_stock WHERE as_stk_in_out='in' and as_item_type = 'MCA' and amb_rto_register_no = 'JK 01 DL 1003') as incount, "
            // ."(SELECT COUNT(*) FROM ems_ambulance_stock WHERE as_stk_in_out='out' and as_item_type = 'MCA' and amb_rto_register_no = 'JK 01 DL 1003') as outcount "
            // ."FROM (SELECT * FROM ems_ambulance_stock WHERE as_item_type = 'MCA' and amb_rto_register_no = 'JK 01 DL 1003') a";
            $stk = "SELECT *, "
                    ."(SELECT SUM(ems_ambulance_stock.as_item_qty) FROM ems_ambulance_stock WHERE as_stk_in_out='in' and as_item_type = '".$inventoryType."' and amb_rto_register_no = '".$Ambulanceno."' and as_item_id = med.med_id) as incount, "
                    ."(SELECT SUM(ems_ambulance_stock.as_item_qty)FROM ems_ambulance_stock WHERE as_stk_in_out='out' and as_item_type = '".$inventoryType."' and amb_rto_register_no = '".$Ambulanceno."' and as_item_id = med.med_id) as outcount "
                    ."FROM ems_inventory_medicine as med "
                    ."LEFT JOIN ems_ambulance_stock AS stk ON (med.med_id = stk.as_item_id AND med.med_unit = stk.as_item_type) "
                    ."GROUP BY med.med_id";
            $stk1 = $this->db->query($stk)->result_array();
            $medList = array();
            foreach($stk1 as $stk2){
                $array1 = array(
                    'id' => (int) $stk2['med_id'],
                    'name' => $stk2['med_title'],
                    'count' => $stk2['incount'] - $stk2['outcount']
                );
                array_push($medList,$array1);
            }
            return $medList;
        }else if($inventoryType == 'CA' || $inventoryType == 'NCA'){
            $stk = "SELECT *, "
                    ."(SELECT SUM(ems_ambulance_stock.as_item_qty) FROM ems_ambulance_stock WHERE as_stk_in_out='in' and as_item_type = '".$inventoryType."' and amb_rto_register_no = '".$Ambulanceno."' and as_item_id = med.inv_id) as incount, "
                    ."(SELECT SUM(ems_ambulance_stock.as_item_qty)FROM ems_ambulance_stock WHERE as_stk_in_out='out' and as_item_type = '".$inventoryType."' and amb_rto_register_no = '".$Ambulanceno."' and as_item_id = med.inv_id) as outcount "
                    ."FROM ems_inventory as med "
                    ."LEFT JOIN ems_ambulance_stock AS stk ON (med.inv_id = stk.as_item_id AND med.inv_type = stk.as_item_type) "
                    ."GROUP BY med.inv_id";
            $stk1 = $this->db->query($stk)->result_array();
            $medList = array();
            foreach($stk1 as $stk2){
                $array1 = array(
                    'id' => (int) $stk2['inv_id'],
                    'name' => $stk2['inv_title'],
                    'count' => $stk2['incount'] - $stk2['outcount']
                );
                array_push($medList,$array1);
            }
            return $medList;
        }else if($inventoryType == 'EQP'){
            $stk = "SELECT *, "
                    ."(SELECT SUM(ems_ambulance_stock.as_item_qty) FROM ems_ambulance_stock WHERE as_stk_in_out='in' and as_item_type = '".$inventoryType."' and amb_rto_register_no = '".$Ambulanceno."' and as_item_id = med.eqp_id) as incount, "
                    ."(SELECT SUM(ems_ambulance_stock.as_item_qty)FROM ems_ambulance_stock WHERE as_stk_in_out='out' and as_item_type = '".$inventoryType."' and amb_rto_register_no = '".$Ambulanceno."' and as_item_id = med.eqp_id) as outcount "
                    ."FROM ems_inventory_equipment as med "
                    ."LEFT JOIN ems_ambulance_stock AS stk ON (med.eqp_id = stk.as_item_id AND stk.as_item_type = 'EQP') "
                    ."GROUP BY med.eqp_id";
            $stk1 = $this->db->query($stk)->result_array();
            $medList = array();
            foreach($stk1 as $stk2){
                $array1 = array(
                    'id' => (int) $stk2['eqp_id'],
                    'name' => $stk2['eqp_name'],
                    'count' => $stk2['incount'] - $stk2['outcount']
                );
                array_push($medList,$array1);
            }
            return $medList;
        }
    }
    public function updatedocuments($clg_doc_id,$uploaddoc){
        $this->db->where('Clg_Documents_id',$clg_doc_id)->update($this->clgdocuments,$uploaddoc);
        return $clg_doc_id;
    }
     public function getpilotid($id){
        $this->db->select('clg_id');
        $this->db->from($this->loginSessionTbl);
        $this->db->where('type_id','3');
        $this->db->where('login_type','D');
        $this->db->where('vehicle_no',$id);
        $this->db->where('status','1');
        return $this->db->get()->row()->clg_id;
    }
    public function insertdocuments($uploaddoc){
        $this->db->insert($this->clgdocuments,$uploaddoc);
         return $this->db->insert_id();
    }
    public function userdocumentlist($documnetType,$pilot_ref_id,$docid,$Ambulanceno){
        if($documnetType==1){
            $data = "SELECT * FROM ems_clg_documents WHERE amb_number = '$Ambulanceno' AND documenttype = '$documnetType' AND document_list_id= '$docid' ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        else{
            $data = "SELECT * FROM ems_clg_documents WHERE clg_ref_id = '$pilot_ref_id' AND documenttype = '$documnetType' AND document_list_id= '$docid' ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
    }
    public function getdocumentlist($documnetType){
        $data = "SELECT * FROM ems_documetns_list WHERE status = '1' AND user_type = '$documnetType' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function gettraininglist($Ambulanceno,$id,$usertype){
        if($usertype=='P')  
        {
            $data = "SELECT * FROM ems_fleet_demo_training WHERE dt_amb_ref_no = '$Ambulanceno' AND dt_emso_id = '$id' ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        }
        elseif($usertype=='D')
        {
            $data = "SELECT * FROM ems_fleet_demo_training WHERE dt_amb_ref_no = '$Ambulanceno' AND  dt_pilot_id = '$id' ";
            $data1 = $this->db->query($data)->result_array();
            return $data1;
        } 
    }
    public function singletraininglist($Ambulanceno,$id){
        $data = "SELECT * FROM ems_fleet_demo_training WHERE dt_amb_ref_no = '$Ambulanceno' AND  (dt_pilot_id = '$id' OR dt_emso_id = '$id')  ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    function updatedemotraining($data,$traineeid) {
        $checkId = $this->db->where('dt_id',$traineeid)->get($this->traineedemo)->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('dt_id',$traineeid)->update($this->traineedemo,$data);
        }
     }
    function updatedambstatus($ambstatus,$ambulanceNo) {
        $this->db->where('amb_rto_register_no',$ambulanceNo)->update($this->ambulanceupdate,$ambstatus);
    }
    public function singlevisitorlist($Ambulanceno,$id){
        $data = "SELECT * FROM ems_visitor_update WHERE vs_amb_ref_number = '$Ambulanceno' AND  (vs_addedby_pilot = '$id' OR vs_addedby_emt = '$id')  ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
    }
    public function insertodometer($ambulanceNo,$data){
        $this->db->insert($this->odometer,$data);
        return $this->db->insert_id();
    }
    function updatevisitors($data,$visitorid) {
        $checkId = $this->db->where('vs_id',$visitorid)->get($this->visitor)->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('vs_id',$visitorid)->update($this->visitor,$data);
        }
    }
    public function adddemotrainee($ambulanceNo,$data){
        $this->db->insert($this->traineedemo,$data);
        return $this->db->insert_id();
    } 
    public function updateOffroadMaintennance($requestId,$tyre){
        $this->db->where('mt_id',$requestId)->update($this->offRoadMaintenance,$tyre);
        return 1;
    }
    public function updateBreakdownMaintennance($requestId,$tyre){
        $this->db->where('mt_id',$requestId)->update($this->breakdownMaintenance,$tyre);
        return 1;
    }
    public function removecurrentmedia($traineeid)
    {
        $delete = $this->db->delete('ems_media',array('user_id'=>$traineeid,'media_data'=>'training'));
        //$data = "DELETE FROM ems_media WHERE user_id = $traineeid AND  media_data='training' ";
        //print_r($data);
       // die;
       return 1;
    }
    public function getclgname($clgrefid){
        $this->db->select('*');
        $this->db->from($this->colleague);
        $this->db->where('clg_ref_id',$clgrefid);
        $clgdata = $this->db->get()->result_array();      
       return $clgdata;
    }
    public function getreamarkvisitor($remark){
        $data =  $this->db->where('remark_val',$remark)->get($this->remark)->result_array();
        if(!empty($data)){
            $approveRem1 = array(
                'id' => (int) $data[0]['id'],
                'value' => $data[0]['remark_val'],
                'name' => $data[0]['message']
            );
            return $approveRem1;
        }
    }
    public function getleavedetails($leaveID)
    {
        $data = "SELECT * FROM ems_colleague_leave WHERE colleague_leave_id =$leaveID ";
        return $this->db->query($data)->result_array();      
    }
    public function getleavelist($id,$type,$getLeave,$usergroup,$clgdistrict){
        if($getLeave == '2'){
          //  $data = "SELECT * FROM ems_colleague_leave WHERE Leave_status!='5' AND clg_group !='$usergroup' AND =$clgdistrict  ORDER BY colleague_leave_id DESC ";
            $data = "SELECT * FROM ems_colleague_leave AS clglv LEFT JOIN ems_colleague AS clg ON clg.clg_id=clglv.colleague_id
			WHERE Leave_status!='5' AND clg.clg_district_id='$clgdistrict' AND clg.clg_group !='$usergroup'
			ORDER BY clglv.added_date DESC";
			
			
			return $this->db->query($data)->result_array();
        }
        else
        {
            $data = "SELECT * FROM ems_colleague_leave WHERE colleague_id ='$id'  ORDER BY colleague_leave_id DESC ";
            //print_r($data);
            //exit();
            return $this->db->query($data)->result_array();
        }
    }
    public function gettoken($clgid){
        $data = "SELECT t2.token  FROM ems_app_login_session as t1 LEFT JOIN ems_app_device_version as t2 on t1.device_id=t2.device_id WHERE t1.status = '1' AND t1.clg_id= $clgid ";
        return $this->db->query($data)->result_array();
    }
    public function getvisitorlist($Ambulanceno,$id,$usertype){ 
        if($usertype=='P')  
        {
        $data = "SELECT * FROM ems_visitor_update WHERE vs_amb_ref_number = '$Ambulanceno' AND vs_addedby_emt = '$id' ";
        $data1 = $this->db->query($data)->result_array();
        return $data1;
        }
        elseif($usertype=='D')
        {
              $data = "SELECT * FROM ems_visitor_update WHERE vs_amb_ref_number = '$Ambulanceno' AND  vs_addedby_pilot = '$id' ";
        $data1 = $this->db->query($data)->result_array();
        
    
        return $data1;
        }
    }
    public function getamblogin($id,$type){
        $data = "SELECT lg.*,clg.* "
        ."FROM `ems_app_login_session` As lg "
        ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
        ."WHERE lg.type_id = '$type' AND lg.status = '1' AND lg.vehicle_no = '$id' ";
        $loginData = $this->db->query($data)->result_array();
        return $loginData;
   }
    public function getlogin($id,$usertype){
        $data = "SELECT lg.*,clg.* "
        ."FROM `ems_app_login_session` As lg "
        ."LEFT JOIN `ems_colleague` As clg On (lg.clg_id = clg.clg_id) "
        ."WHERE lg.login_type = '$usertype' AND lg.status = '1' AND lg.vehicle_no = '$id' ";
        $loginData = $this->db->query($data)->result_array();
        return $loginData;
    }
    public function getseparateId($id,$usertype){
        $this->db->select('*');
        $this->db->from($this->loginSessionTbl);
        $this->db->where('vehicle_no',$id);
        $this->db->where('status',1);
        $this->db->where('login_type',$usertype);
        $data = $this->db->get()->result_array();
       return $data;
    }
    function cancleleave($data,$leaveID){
        $checkId = $this->db->where('colleague_leave_id',$leaveID)->get($this->leave)->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('colleague_leave_id',$leaveID)->update($this->leave,$data);
        }
    }
    /* Update data into leave table */
    function updateleave($data,$leaveID){
        $checkId = $this->db->where('colleague_leave_id',$leaveID)->get($this->leave)->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('colleague_leave_id',$leaveID)->update($this->leave,$data);
        }
    }
    /* Insert data into Colleague leave table */
    function insertclgleave($data){
        $this->db->insert($this->leave,$data);
        return $this->db->insert_id();
    }
    function insertvisitor($data) {
        $this->db->insert($this->visitor, $data);
        /* $str = $this->db->last_query();
         print_r($str);
         die();*/
        return $this->db->insert_id();
    }
    function updateodometer($data,$ambno,$prevodometer){
        $this->db->insert($this->ambtimestamp,$data);
        // $checkId = $this->db->where('amb_rto_register_no', $ambno)->where('end_odmeter',$prevodometer)->get($this->ambtimestamp)->result_array();
        // if(empty($checkId)){
        //     return 1;
        // }else{
        //     $this->db->where('amb_rto_register_no', $ambno)->where('end_odmeter',$prevodometer)->update($this->ambtimestamp,$data);
        // }
    }
    function getotherusrdetails($id){
        $this->db->select('*');
        $this->db->from($this->colleague);
        $this->db->where('clg_id',$id);
        $data1 = $this->db->get()->result_array();
        return $data1;
    }
    public function getMaintenanceList($maintenanceType,$data){
        
        $tyreData = array();
        if($maintenanceType == 14){
            $tyre1 = 'tyre';
            // $tyre = "SELECT * FROM $this->tyreMaintenance as tyre WHERE tyre.mt_amb_no = '".$ambulanceNo."' ORDER BY mt_id DESC LIMIT 10";
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->tyreMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->tyreMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }else if($maintenanceType == 7){
            $tyre1 = 'accidental';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->accidentalMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->accidentalMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }else if($maintenanceType == 18){
            $tyre1 = 'breakdown';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->breakdownMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->breakdownMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }else if($maintenanceType == 12){
            $tyre1 = 'onroad_offroad';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->offRoadMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->offRoadMaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }
        else if($maintenanceType == 16){
            $tyre1 = 'preventive';
            if($data['pageSize'] != 0){
                $tyre = "SELECT * FROM $this->preventivemaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC LIMIT ".$data['begin'].", ".$data['pageSize']." ";
            }else{
                $tyre = "SELECT * FROM $this->preventivemaintenance as tyre WHERE tyre.mt_amb_no = '".$data['ambulanceNo']."' ORDER BY mt_id DESC ";
            }
            $data = $this->db->query($tyre)->result_array();
        }
        
          foreach($data as $data1){
            // print_r($data1);die;
            $chk = "SELECT * FROM $this->accidentalMainHist as hist WHERE hist.re_mt_id = '".$data1['mt_id']."' AND hist.re_mt_type = '".$tyre1."' ORDER BY hist.re_id DESC LIMIT 1 ";
            //print_r($chk);die;
            $approve =  $this->db->query($chk)->result_array();
            if($data1['mt_ambulance_status'] == "Available"){
          if(!empty($data1['mt_approved_cost']))
                {
                    $approvedcost = $data1['mt_approved_cost'];
                }
                else{
                     if($maintenanceType == 7){
                     $approvedcost = $data1['mt_Estimatecost'];
                     } else if($maintenanceType == 12){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                    else if($maintenanceType == 14){
                     $approvedcost = $data1['mt_estimate_cost'];
                     } else if($maintenanceType == 16){
                      $approvedcost = $data1['mt_estimatecost'];
                     }
                     else if($maintenanceType == 18){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                     
                }
                
                
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Completed',
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                    'approvedCost'=>$approvedcost,
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }
            else if($data1['mt_approval'] == '1'){
                if(!empty($data1['mt_app_est_amt']))
                {
                    $approvedcost = $data1['mt_app_est_amt'];
                }
                else{
                     if($maintenanceType == 7){
                     $approvedcost = $data1['mt_Estimatecost'];
                     } else if($maintenanceType == 12){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                    else if($maintenanceType == 14){
                     $approvedcost = $data1['mt_estimate_cost'];
                     } else if($maintenanceType == 16){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                     else if($maintenanceType == 18){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                     
                }

                
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Approved',
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                    'approvedCost'=>$approvedcost,
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }

            
            
            else if(empty($approve) || ($approve[0]['re_approval_rerequest'] == '0')){
                 $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Pending',
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                     'approvedCost'=>" ",
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }else if($approve[0]['re_approval_status'] == '1'){
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Rejected',
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                    'approvedCost'=>" ",
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }else{
                
                
               if(!empty($data1['mt_approved_cost']))
                {
                    $approvedcost = $data1['mt_approved_cost'];
                }else{
                     if($maintenanceType == 7){
                     $approvedcost = $data1['mt_Estimatecost'];
                     } else if($maintenanceType == 12){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                    else if($maintenanceType == 14){
                     $approvedcost = $data1['mt_estimate_cost'];
                     } else if($maintenanceType == 16){
                      $approvedcost = $data1['mt_estimatecost'];
                     }
                     else if($maintenanceType == 18){
                      $approvedcost = $data1['mt_Estimatecost'];
                     }
                }
                
                $tyreData1 = array(
                    'reqId' => (int) $data1['mt_id'],
                    'reqDate' => $data1['added_date'],
                    'status' => 'Approved',
                    'exOnroadDatetime' => $data1['mt_ex_onroad_datetime'],
                     'approvedCost'=>$approvedcost,
                    'vehicleNumber' => $data1['mt_amb_no']
                );
            }
            array_push($tyreData,$tyreData1);
        }
        return $tyreData;
        
    }
    function getUserLoginAsPerUser($pilotLoginCheck){
        $login = array();
        foreach($pilotLoginCheck as $pilotLoginCheck1){
            $data="SELECT * FROM ems_app_login_session as applogin LEFT JOIN ems_colleague as coll ON applogin.clg_id=coll.clg_id WHERE applogin.clg_id= '".$pilotLoginCheck1['clg_id']."' AND  applogin.status= 1 ";
            $login1 =  $this->db->query($data)->result_array()[0];
            array_push($login,$login1);
        }
        return $login;
    }
    function getallambulances($district){
        $data="SELECT * FROM `ems_district_wise_offroad` WHERE district_name = '$district'";
        $data1 =  $this->db->query($data)->result_array();

        return $data1;
    }
function getallambulancesstatus($ambno){
        $data="SELECT ambtype.ambt_name,clg.clg_first_name,clg.clg_mobile_no,log.type_id, log.login_type, log.clg_id, dst.dst_name,amb_rto_register_no,bs.hp_name,tp.ambt_name,st.ambs_name,amb.amb_user, amb.amb_user_type, amb.amb_default_mobile,amb.amb_pilot_mobile   
        FROM ems_app_login_session as log
        LEFT JOIN ems_colleague as clg ON log.clg_id=clg.clg_id
        LEFT JOIN ems_ambulance as amb ON log.vehicle_no=amb.amb_rto_register_no
        LEFT JOIN ems_mas_ambulance_type as ambtype ON amb.amb_type=ambtype.ambt_id
        LEFT JOIN ems_hospital as bs ON bs.hp_id=amb.amb_base_location
        LEFT JOIN ems_mas_districts as dst ON dst.dst_code=amb.amb_district
        LEFT JOIN ems_mas_ambulance_status as st ON st.ambs_id=amb.amb_status
        LEFT JOIN ems_mas_ambulance_type as tp ON tp.ambt_id=amb.amb_type
        WHERE log.vehicle_no = '$ambno' AND log.status = '1' ";
        $data1 =  $this->db->query($data)->result_array();
       //echo $this->db->last_query();
        return $data1;
    }
    public function get_login_for_latlng($cookie,$type){
        if($type==3){
            return $this->db->where('type_id',$type)->where('vehicle_no',$cookie)->where('status',1)->get('ems_app_login_session')->result_array();
        }else{
            return $this->db->where('clg_id',$cookie)->where('status',1)->get('ems_app_login_session')->result_array();
        }
    }
    public function getambulancesdetails($dist){
        if($dist == 'All'){
            $data="SELECT amb.amb_rto_register_no,amb.amb_lat,amb.amb_log,st.ambs_name,apidist.api_dis_name
            FROM ems_ambulance as amb
            LEFT JOIN ems_mapapi_district as apidist ON apidist.api_dis_code=amb.amb_district
            LEFT JOIN ems_mas_ambulance_status as st ON st.ambs_id=amb.amb_status
            WHERE amb.ambis_deleted = '0' AND amb.amb_user_type='108' ";
        }else{
            $data="SELECT amb.amb_rto_register_no,amb.amb_lat,amb.amb_log,st.ambs_name,apidist.api_dis_name
            FROM ems_ambulance as amb
            LEFT JOIN ems_mapapi_district as apidist ON apidist.api_dis_code=amb.amb_district
            LEFT JOIN ems_mas_ambulance_status as st ON st.ambs_id=amb.amb_status
            WHERE amb.ambis_deleted = '0' AND amb.amb_user_type='108' AND apidist.api_dis_name = '$dist' ";
        }
        // echo $this->db->last_query();die;
        $data1 =  $this->db->query($data)->result_array();
        return $data1;
    }
    public function getambstatuscount($dist){
         if($dist == 'All'){
            $data="SELECT amb.amb_rto_register_no,amb.amb_lat,amb.amb_log,st.ambs_name,apidist.api_dis_name
            FROM ems_ambulance as amb
            LEFT JOIN ems_mapapi_district as apidist ON apidist.api_dis_code=amb.amb_district
            LEFT JOIN ems_mas_ambulance_status as st ON st.ambs_id=amb.amb_status
            WHERE amb.ambis_deleted = '0' AND amb.amb_user_type='108' ";
        }else{
            $data="SELECT amb.amb_rto_register_no,amb.amb_lat,amb.amb_log,st.ambs_name,apidist.api_dis_name
            FROM ems_ambulance as amb
            LEFT JOIN ems_mapapi_district as apidist ON apidist.api_dis_code=amb.amb_district
            LEFT JOIN ems_mas_ambulance_status as st ON st.ambs_id=amb.amb_status
            WHERE amb.ambis_deleted = '0' AND apidist.api_dis_name = '$dist' AND amb.amb_user_type='108' ";
        }
        // echo $this->db->last_query();die;
        $data1 =  $this->db->query($data)->result_array();
        return $data1;
    }
    public function getoffroadcount(){
        $this->db->select('*');
        $this->db->from('ems_district_wise_offroad');
        $this->db->order_by('id','DESC');
        $this->db->limit(1);
        $data1 = $this->db->get()->result_array();
        return $data1;
    }
}