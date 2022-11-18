<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Supervisory_Device_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
    /* Insert data into Device Version table */
    function insertDeviceVersion($data){
        $this->db->insert('ems_supervisory_app_device_version',$data);
        return $this->db->insert_id();
    }
    /* Update data into Device Version table */
    function updateDeviceVersion($data,$uniqueId){
        $checkId = $this->db->where('unique_id',$uniqueId)->get('ems_supervisory_app_device_version')->result_array();
        if(empty($checkId)){
            return 1;
        }else{
            $this->db->where('unique_id',$uniqueId)->update('ems_supervisory_app_device_version',$data);
        }
    }
    /* Get Current Version */
    function getCurrentversion($osName){
        return $this->db->where('osName',$osName)->get('ems_supervisory_app_device_version_info')->result_array();
        
       
    }
}
