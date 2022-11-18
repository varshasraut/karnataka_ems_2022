<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Driver_common_model extends CI_Model{
    public function __construct(){
		parent::__construct();	
	}
    public function getClgIdAsPerMobileNo($driverMobile){
        $data = $this->db->where('mobile',$driverMobile)->get('mas_colleague')->result_array();
        if(!empty($data)){
            return $data[0]['userid'];
        }
    }
    public function getClgNameAsPerClgId($getClgId){
        return $this->db->where('userid',$getClgId)->get('mas_colleague')->result_array()[0]['fullname'];
    }
}