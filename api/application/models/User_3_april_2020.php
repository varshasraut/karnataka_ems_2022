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
        $data = $this->db->where('amb_rto_register_no',$vehicleNumber)->get($this->ambulance)->result_array();
        // if(em)
        // $this->db->select('amb_default_mobile');
        // $this->db->from($this->ambulance);
        // $this->db->where('amb_rto_register_no',$vehicleNumber);
        // $data =  $this->db->get()->row()->amb_default_mobile;
        // print_r($data);
        return $data;
        // if(empty($data)){
        //     return 1;
        // }else{
        //     return $data;
        // }
    }
    public function insertVehicleOtp($data,$vehicleNumber){
        $this->db->where('amb_rto_register_no',$vehicleNumber)->update($this->ambulance,$data);
    }
    public function getOtp($vehicleNumber){
        return $this->db->where('amb_rto_register_no',$vehicleNumber)->get($this->ambulance)->result_array();
    }
    public function getPilot($vehicleNumber){
        $this->db->select('amb_id');
        $this->db->from($this->ambulance);
        $this->db->where('amb_rto_register_no',$vehicleNumber);
        $ambId = $this->db->get()->row()->amb_id;

        $this->db->select('pilot_id');
        $this->db->from($this->ambPilot);
        $this->db->where('amb_id',$ambId);
        $pilotId = $this->db->get()->result_array();

        $pilotName = array();
        foreach($pilotId as $pilot){
            $data = $this->db->where('clg_id',$pilot['pilot_id'])->get($this->colleague)->result_array();
            $pilotJoinName = $data[0]['clg_first_name']. ' '.$data[0]['clg_mid_name'].' '.$data[0]['clg_last_name'];
            $pilot_Name = array(
                'id' => $data[0]['clg_id'],
                'name' => $pilotJoinName
            );
            array_push($pilotName,$pilot_Name);
        }
        return $pilotName;
    }
    public function getEmt($vehicleNumber){
        $this->db->select('amb_id');
        $this->db->from($this->ambulance);
        $this->db->where('amb_rto_register_no',$vehicleNumber);
        $ambId = $this->db->get()->row()->amb_id;

        $this->db->select('emt_id');
        $this->db->from($this->ambEmt);
        $this->db->where('amb_id',$ambId);
        $EmtId = $this->db->get()->result_array();

        $emtName = array();
        foreach($EmtId as $Emt){
            $data = $this->db->where('clg_id',$Emt['emt_id'])->get($this->colleague)->result_array();
            $emtJoinName = $data[0]['clg_first_name']. ' '.$data[0]['clg_mid_name'].' '.$data[0]['clg_last_name'];
            $emt_Name = array(
                'id' => $data[0]['clg_id'],
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
    public function updateOtp($vehicleNumber,$data){
        $this->db->where('amb_rto_register_no',$vehicleNumber)->update($this->ambulance,$data);
    }
    public function getPilotOtp($pilotId){
        return $this->db->where('clg_id',$pilotId)->get($this->colleague)->result_array();
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
                . "WHERE ".$loginId." IN (para.with_partner) || ".$loginId." IN (para.start_fr_bs_loc_id) || ".$loginId." IN (para.at_scene_id) || ".$loginId." IN (para.from_scene_id) || ".$loginId." IN (para.at_hosp_id) || ".$loginId." IN (para.patient_hand_id) || ".$loginId." IN (para.back_to_bs_loc_id) || incamb.amb_rto_register_no = '".$ambno."' AND inc.inc_pcr_status = '1' "
                . "AND inc.modify_date_sync >= DATE(NOW()) - INTERVAL 7 DAY "
                . "GROUP BY inc.inc_ref_id";
        $compIncidentRec = $this->db->query($data)->result_array();
        // print_r($data);
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
                ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '$incidentId' ";
            $hosp_list = $this->db->query($data)->result_array();
        }else if(!empty($hosp['hospitalType']) && empty($hosp['district'])){
            if($hosp['hospitalType'] == 'all'){
                $data = "SELECT inc.*,hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '$incidentId' ";
                $hosp_list = $this->db->query($data)->result_array();
            }else{
                $data = "SELECT inc.*,hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '$incidentId' AND hosp.hp_type = '$hp_type' ";
                $hosp_list = $this->db->query($data)->result_array();
            }
        }else if(!empty($hosp['district']) && !empty($hosp['hospitalType'])){
            if($hosp['hospitalType'] == 'all'){
                $data = "SELECT hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_hospital` As hosp "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE hosp.`hp_district` = '$district' ";
                $hosp_list = $this->db->query($data)->result_array();
            }else{
                $data = "SELECT hosp.*,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_hospital` As hosp "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE hosp.`hp_district` = '$district' AND hosp.hp_type = '$hp_type' ";
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
            $data = $this->db->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        }else if($type == 2){
            $data = $this->db->where('clg_id',$id)->get($this->loginSessionTbl)->result_array();
        }else{
            $data = $this->db->where('vehicle_no',$id)->get($this->loginSessionTbl)->result_array();
        }
        foreach($data as $data1){
            $logout['status'] = 2;
            $logout['logout_time'] = date('Y-m-d H:i:s');
            $this->db->where('clg_id',$data1['clg_id'])->update($this->loginSessionTbl,$logout);
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
        return  $this->db->where('p_id',$PatientId)->get($this->patient)->result_array();
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
            $data1 = "SELECT ptn.*,epcr.initial_complete,epcr.ongoing_complete,epcr.handover_cond_complete,epcr.handover_issue_complete,epcr.medicine_complete,epcr.consumable_complete,epcr.pat_com_to_hosp,epcr.pat_com_to_hosp,epcr.pat_com_to_hosp_reason,ptnreason.id,ptnreason.reason "
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
                $patientDetails = array(
                    'id' => (float) $ptn1['ptn_id'],
                    'firstName' => $ptn1['ptn_fname'],
                    'middleName' => $ptn1['ptn_mname'],
                    'lastName' => $ptn1['ptn_lname'],
                    'gender' => $ptn1['ptn_gender'],
                    'age' => (int) $ptn1['ptn_age'],
                    'bloodGroup' => $ptn1['ptn_bgroup'],
                    'patientCompleteInfo' => $patientCompleteInfo,
                    'patientCompleteInfoFlag' => $flag,
                    'patientComToHosp' => (int) $patientComToHosp,
                    'patientComToHospRes' => ([
                        'id' => (int) $ptn1['id'],
                       'name' =>  $ptn1['reason']
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
        $this->db->where('p_id',$patientId)->update($this->patient,$data);
        return 1;
    }
    public function getPatientMedInfo($patientId){
        $data = "SELECT epcr.*,ptn.*,dst.*,thl.*,city.*,loc.*,proimp.*,ptnres.reason "
                ."FROM `ems_epcr` AS epcr "
                ."LEFT JOIN `ems_patient` As ptn ON (ptn.p_id = epcr.ptn_id) "
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
        if(!empty($initial)){
            // print_r($initial);
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
        $data = "SELECT * FROM $this->epcr AS epcr "
                ."LEFT JOIN $this->chiefComplaint AS chief ON (epcr.ong_ph_sign_symptoms = chief.ct_id) " 
                ."WHERE epcr.ptn_id = $patientId ";
        $initial = $this->db->query($data)->result_array();
        // print_r($initial);die;
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
                'ongPhSignSymptoms' => ([
                    'id' => (int) $initial[0]['ct_id'],
                    'name' => $initial[0]['ct_type']
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
        $this->db->where('inc_ref_id',$incidentId)->update($this->incidence,$emsIncidence);
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
    public function ConsumableList($patientId){
        
        $consumable = $this->db->where('inv_type','CA')->get($this->inventory)->result_array();
        $a1 = array();
        foreach($consumable as $consumable1){
            $a = array(
                'id' => (int) $consumable1['inv_id'],
                'name' => $consumable1['inv_title'],
                'count' => 0
            );
            array_push($a1,$a);
        }
        $consumable1 = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        if(!empty($consumable1)){
            if($consumable1[0]['other_con_id_list'] == ''){
                $otherConsumable = [];
            }else{
                $otherConsumable = json_decode($consumable1[0]['other_con_id_list']);
            }
        }else{
            $otherConsumable = [];
        }
        // print_r($consumable1);die;
        $consumables = array();
        
        foreach($consumable1 as $con){
            // $cons = array(
            //     "id" => $con['ptn_id'],
            //     "consumableList" => json_decode($con['con_id_list']),
            //     "otherconsumableList" => json_decode($con['other_con_id_list'])
            // );
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
        $tmpArray = array();
        foreach($a1 as $data1) {
        
          $duplicate = false;
          foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
          }
        
          if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
                "consumableList" => array_merge($list,$tmpArray),
                "otherconsumableList" => $otherConsumable
            );
        return $cons;
        
        // $consumable = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        // $consumables = array();
        // foreach($consumable as $con){
        //     $cons = array(
        //         "id" => $con['ptn_id'],
        //         "consumableList" => json_decode($con['con_id_list']),
        //         "otherconsumableList" => json_decode($con['other_con_id_list'])
        //     );
        //     array_push($consumables,$cons);
        // }
        // return $consumables;
    }
    public function ConsumableNonUnitList($patientId){
        $consumable = $this->db->where('inv_type','NCA')->where('invis_deleted','0')->get($this->inventory)->result_array();
        $a1 = array();
        foreach($consumable as $consumable1){
            $a = array(
                'id' => (int) $consumable1['inv_id'],
                'name' => $consumable1['inv_title'],
                'checked' => false
            );
            array_push($a1,$a);
        }
        $consumable1 = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        if(!empty($consumable1)){
            if($consumable1[0]['other_con_nonunit_id_list'] == ''){
                $otherConsumable = [];
            }else{
                $otherConsumable = json_decode($consumable1[0]['other_con_nonunit_id_list']);
            }
        }else{
            $otherConsumable = [];
        }
        
        // print_r($consumable1);die;
        $consumables = array();
        
        foreach($consumable1 as $con){
            // $cons = array(
            //     "id" => $con['ptn_id'],
            //     "consumableList" => json_decode($con['con_id_list']),
            //     "otherconsumableList" => json_decode($con['other_con_id_list'])
            // );
            $data = json_decode($con['con_nonunit_id_list']);
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
                        'checked' => $consumables1[$i]->checked
                    );
                    array_push($list,$cons);
                }
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
        $cons = array(
                "consumableNonUnitList" => array_merge($list,$tmpArray),
                "otherconsumableNonUnitList" => $otherConsumable
            );
        return $cons;
    }
    public function insertConsumable($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    public function insertMedicine($patientId,$data){
        $this->db->where('ptn_id',$patientId)->update($this->epcr,$data);
        return 1;
    }
    public function getmedicinename($patientId){
        $ambMedicine = $this->db->where('med_type','amb')->where('med_unit','CA')->where('medis_deleted','0')->get($this->invMedicine)->result_array();
        $a1 = array();
        foreach($ambMedicine as $ambMedicine1){
            $a = array(
                'id' => (int) $ambMedicine1['med_id'],
                'name' => $ambMedicine1['med_title'],
                'count' => 0
            );
            array_push($a1,$a);
        }
        $medicine = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        // print_r($medicine);
        if(!empty($medicine)){
            if($medicine[0]['other_med_id_list'] == ''){
                $othermedicine = [];
            }else{
                $othermedicine = json_decode($medicine[0]['other_med_id_list']);
            }
        }else{
            $othermedicine = [];
        }
        
        // print_r($othermedicine);die;
        $medicines = array();
        foreach($medicine as $med){
            // $meds = array(
            //     'id' => $med['ptn_id'],
            //     'medicineList' => json_decode($med['med_id_list']),
            //     'otherMedicineList' =>  json_decode($med['other_med_id_list'])
            // ) ;
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
        $tmpArray = array();
        foreach($a1 as $data1) {
        
          $duplicate = false;
          foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
          }
        
          if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
                "medicineList" => array_merge($list,$tmpArray),
                "otherMedicineList" => $othermedicine
            );
        return $cons;
        
        // $medicine = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        // $medicines = array();
        // foreach($medicine as $med){
        //     $meds = array(
        //         'id' => $med['ptn_id'],
        //         'medicineList' => json_decode($med['med_id_list']),
        //         'otherMedicineList' =>  json_decode($med['other_med_id_list'])
        //     ) ;
        //     array_push($medicines,$meds);
        // }
        // return $medicines;
    }
    public function getNonUnitMedicineName($patientId){
        $ambMedicine = $this->db->where('med_type','amb')->where('med_unit','NCA')->where('medis_deleted','0')->get($this->invMedicine)->result_array();
        $a1 = array();
        foreach($ambMedicine as $ambMedicine1){
            $a = array(
                'id' => (int) $ambMedicine1['med_id'],
                'name' => $ambMedicine1['med_title'],
                'checked' => false
            );
            array_push($a1,$a);
        }
        $medicine = $this->db->where('ptn_id',$patientId)->get($this->epcr)->result_array();
        if(!empty($medicine)){
            if($medicine[0]['other_med_nonunit_id_list'] == ''){
                $othermedicine = [];
            }else{
                $othermedicine = json_decode($medicine[0]['other_med_nonunit_id_list']);
            }
        }else{
            $othermedicine = [];
        }
        // print_r($othermedicine);die;
        $medicines = array();
        foreach($medicine as $med){
            // $meds = array(
            //     'id' => $med['ptn_id'],
            //     'medicineList' => json_decode($med['med_id_list']),
            //     'otherMedicineList' =>  json_decode($med['other_med_id_list'])
            // ) ;
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
        $tmpArray = array();
        foreach($a1 as $data1) {
        
          $duplicate = false;
          foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
          }
        
          if($duplicate == false) $tmpArray[] = $data1;
        }
        $cons = array(
                "medicineNonUnitList" => array_merge($list,$tmpArray),
                "otherMedicineNonUnitList" => $othermedicine
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
    public function getendodometer($ambulanceno){
        $this->db->select('*');
        $this->db->from($this->closure);
        $this->db->where('amb_rto_register_no',$ambulanceno);
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
                ." LEFT JOIN `ems_hospital` as hosp ON (inc.hospital_id = hosp.hp_id) "
                ." LEFT JOIN `ems_mas_districts` as dist ON (inc.hospital_district = dist.dst_code)"
                ."WHERE inc.inc_ref_id = '$incidentId' ";
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
                ." WHERE inc.inc_ref_id = $incidentId ";
        return $this->db->query($data)->result_array();
    }
     public function chkAnotherDeviceLogin($data){
        $data1['status'] = '2';
        if($data['typeId'] == 1){
            $chk = $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            if((count($chk)==1) && ($chk[0]['device_id'] != $data['deviceid'])){
                $this->db->where('clg_id',$data['pilotId'])->update($this->loginSessionTbl,$data1);
                return 1;
            }else{
                return 2;
            }
        }else if($data['typeId'] == 2){
            $chk = $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            if((count($chk)==1) && ($chk[0]['device_id'] != $data['deviceid'])){
                $this->db->where('clg_id',$data['emtId'])->update($this->loginSessionTbl,$data1);
                return 1;
            }else{
                return 2;
            }
        }else{
            $pilot = $this->db->where('clg_id',$data['pilotId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            $emt = $this->db->where('clg_id',$data['emtId'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['vehicleNumber'])->where('status','1')->get($this->loginSessionTbl)->result_array();
            if(((count($pilot)==1) && ($pilot[0]['device_id'] != $data['deviceid'])) && ((count($emt)==1) && ($emt[0]['device_id'] != $data['deviceid']))){
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
            // print_r($data);
            $sameUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['pilotId']."' AND loginSession.status = '1' ";
            $vehicleLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
            ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.status = '1' ";
            // $data1 = $this->db->where('clg_id',$data['pilotId'])->where('status',1)->get($this->loginSessionTbl)->result_array();
            // print_r($sameUserLogin);die;
            $sameUserLogin1 = $this->db->query($sameUserLogin)->result_array();
            // print_r($sameUserLogin1);die;
            $vehicleLogin1 = $this->db->query($vehicleLogin)->result_array();
            // print_r($vehicleLogin1);die;
            if(!empty($sameUserLogin1)){
                return $sameUserLogin1;
            }else{
                return $vehicleLogin1;
            }
        }else if($data['typeId'] == 2){
            // print_r($data['emtId']);
            $sameUserLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.clg_id = '".$data['emtId']."' AND loginSession.status = '1' ";
            $vehicleLogin = "SELECT * FROM `ems_app_login_session` AS loginSession " 
                    ."WHERE loginSession.vehicle_no = '".$data['vehicleNumber']."' AND loginSession.clg_id = '".$data['emtId']."' AND loginSession.status = '1' ";
            // $data1 = $this->db->where('clg_id',$data['emtId'])->where('status',1)->get($this->loginSessionTbl)->result_array();
            // print_r($this->db->query($data1)->result_array());
            $sameUserLogin1 = $this->db->query($sameUserLogin)->result_array();
            $vehicleLogin1 = $this->db->query($vehicleLogin)->result_array();
            if(!empty($sameUserLogin1)){
                return $sameUserLogin1;
            }else{
                return $vehicleLogin1;
            }
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
            ." WHERE inc.inc_ref_id = $incidentId ";
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
        $data = "SELECT amb.amb_district,user.clg_ref_id,user.clg_id"
                ." FROM $this->ambulance as amb"
                ." LEFT JOIN $this->colleague as user ON (amb.amb_district = user.clg_district_id)"
                ." WHERE amb.amb_rto_register_no = '$ambulanceNo' AND user.clg_group = 'UG-DIS-FILD-MANAGER' ";
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
}