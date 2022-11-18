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
    public function getCompIncidence($ambno){
        $data = "SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*" 
                ."FROM $this->incidenceamb AS incamb "
                ."LEFT JOIN $this->incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->calls AS cls ON (cls.cl_id = inc.inc_cl_id)"
                . "LEFT JOIN $this->callers AS clr ON (clr.clr_id = cls.cl_clr_id)"
                . "LEFT JOIN $this->relation AS rel ON (cls.clr_ralation = rel.rel_id)"
                . "LEFT JOIN $this->operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
                . "LEFT JOIN $this->micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"
                . "LEFT JOIN $this->patientComplaint as pc on(pc.ct_id=inc.inc_complaint)"
                . "WHERE incamb.amb_rto_register_no = '".$ambno."' AND inc.inc_pcr_status = '1' "
                . "GROUP BY inc.inc_ref_id";
        $compIncidentRec = $this->db->query($data)->result_array();
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
            if($record['inc_pcr_status']==1){
                $recordData1['incidentStatus'] = 'Completed';
            }
            $recordData1['incidentAddress'] = $record['inc_address'];
            $recordData1['lat'] = (float) $record['inc_lat'];
            $recordData1['long'] = (float) $record['inc_long'];
            $recordData1['incidentPincode'] = $record['inc_pincode'];
            $recordData1['CallerRelationName'] = $record['rel_name'];
            array_push($recordData,$recordData1);
        }
        return $recordData;
    }
    public function assignedIncidenceCalls($ambno){
        $data = "SELECT incamb.*,inc.*,cls.*,clr.*,rel.*,op.*,mn.*,pc.*" 
                ."FROM $this->incidenceamb AS incamb "
                ."LEFT JOIN $this->incidence AS inc ON (inc.inc_ref_id = incamb.inc_ref_id) "
                . "LEFT JOIN $this->calls AS cls ON (cls.cl_id = inc.inc_cl_id)"
                . "LEFT JOIN $this->callers AS clr ON (clr.clr_id = cls.cl_clr_id)"
                . "LEFT JOIN $this->relation AS rel ON (cls.clr_ralation = rel.rel_id)"
                . "LEFT JOIN $this->operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
                . "LEFT JOIN $this->micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"
                . "LEFT JOIN $this->patientComplaint as pc on(pc.ct_id=inc.inc_complaint)"
                . "WHERE incamb.amb_rto_register_no = '".$ambno."' AND inc.inc_pcr_status = '0' "
                . "GROUP BY inc.inc_ref_id";
        $compIncidentRec = $this->db->query($data)->result_array();
        $recordData = array();
        
        foreach($compIncidentRec as $record){
            $service = explode(',',$compIncidentRec[0]['ntr_services']);
            // print_r(count($services));
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
            $recordData1['CallerRelationName'] = $record['rel_name'];
            $recordData1['Services'] = $services;
            array_push($recordData,$recordData1);
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
        $this->db->select('hosp_id');
        $this->db->from($this->hospitalType);
        $this->db->where('hosp_type',$hosp['hospitalType']);
        $hp_type =  $this->db->get()->row()->hosp_id;
        $incidentId = $hosp['incidentId'];
        $allList = $hosp['allList'];
        $hosp = array();
        if($allList == 1){
            $data = "SELECT inc.*,hosp.*,st.st_name,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_state_id = hosp.hp_state) "
                ."LEFT JOIN `ems_mas_states` As st ON (hosp.hp_state = st.st_code) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code AND inc.inc_state_id = dis.dst_state) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '$incidentId' AND hosp.hp_type = '$hp_type' ";
            $hosp_list = $this->db->query($data)->result_array();
        }else{
            $data = "SELECT inc.*,hosp.*,st.st_name,dis.dst_name,tah.thl_name,city.cty_name"
                ." FROM `ems_incidence` As inc "
                ."LEFT JOIN `ems_hospital` As hosp ON (inc.inc_state_id = hosp.hp_state AND inc.inc_district_id = hosp.hp_district) "
                ."LEFT JOIN `ems_mas_states` As st ON (hosp.hp_state = st.st_code) "
                ."LEFT JOIN `ems_mas_districts` As dis ON (hosp.hp_district = dis.dst_code AND inc.inc_state_id = dis.dst_state) "
                ."LEFT JOIN `ems_mas_tahshil` AS tah ON (hosp.hp_tahsil = tah.thl_code AND hosp.hp_district = tah.thl_district_code) "
                ."LEFT JOIN `ems_mas_city` As city On (hosp.hp_city = city.cty_id AND hosp.hp_tahsil = city.cty_thshil_code AND hosp.hp_district = city.cty_dist_code) "
                ."WHERE inc.`inc_ref_id` = '$incidentId' AND hosp.hp_type = '$hp_type' ";
            $hosp_list = $this->db->query($data)->result_array();
        }
        foreach($hosp_list as $hosp_list1){
            $hosp1['hospId'] = $hosp_list1['hp_id'];
            $hosp1['hospName'] = $hosp_list1['hp_name'];
            $hosp1['hospLat'] = (float) $hosp_list1['hp_lat'];
            $hosp1['hospLong'] = (float) $hosp_list1['hp_long'];
            $hosp1['hospAddress'] = $hosp_list1['hp_address'];
            $hosp1['hospArea'] = $hosp_list1['hp_area'];
            $hosp1['hospCityName'] = $hosp_list1['cty_name'];
            $hosp1['hospState'] = $hosp_list1['st_name'];
            $hosp1['hospDistrict'] = $hosp_list1['dst_name'];
            $hosp1['hospTahsil'] = $hosp_list1['thl_name'];
            array_push($hosp,$hosp1);
        }
        return $hosp;
    }
    public function logout($data,$data1){
        $this->db->where('clg_id',$data['id'])->where('type_id',$data['typeId'])->where('vehicle_no',$data['ambno'])->where('device_id',$data['deviceId'])->update($this->loginSessionTbl,$data1);
    }
    public function addDriverParameters($data){
        $incidentCount = $this->db->where('incident_id',$data['incidenId'])->get('ems_driver_parameters')->result_array();
        if($data['parametersType'] == 1){
            $para['incident_id'] = $data['incidenId'];
            $para['amb_no'] = $data['ambno'];
            $para['start_from_base_loc'] = $data['dateTime'];
            $para['start_fr_bs_loc_emt'] = $data['emtId'];
            $para['start_fr_bs_loc_pilot'] = $data['pilotId'];
            if(count($incidentCount)==1){
                return 1;
            }else{
                $this->db->insert($this->driverParameter,$para);
            }
        }else if($data['parametersType'] == 2){
            $para['`at_scene`'] = $data['dateTime'];
            $para['at_scene_emt'] = $data['emtId'];
            $para['at_scene_pilot'] = $data['pilotId'];
            $this->db->where('incident_id',$data['incidenId'])->where('amb_no',$data['ambno'])->update($this->driverParameter,$para);
            return 3;
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
}