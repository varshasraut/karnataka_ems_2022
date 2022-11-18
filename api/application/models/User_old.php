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
        $this->db->select('amb_default_mobile');
        $this->db->from($this->ambulance);
        $this->db->where('amb_rto_register_no',$vehicleNumber);
        return $this->db->get()->row()->amb_default_mobile;
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
}