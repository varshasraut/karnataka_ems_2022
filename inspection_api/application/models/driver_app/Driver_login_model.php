<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Driver_login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
    public function chkLoginAnotherVeh($data){
        return $this->db->where('clg_id',$data['clg_id'])->where('status','1')->get('driver_app_login_session')->result_array();
    }
    public function chkVehLogin($data){
        return $this->db->where('login_vehicle_no',$data['vehicleNumber'])->where('status','1')->get('driver_app_login_session')->result_array();
    }
    public function insertOtpOnClgTable($otpAddInClgtable,$getClgId){
        $this->db->where('userid',$getClgId)->update('mas_colleague',$otpAddInClgtable);
    }
    public function getDriverOtp($getClgId){
        return $this->db->where('userid',$getClgId)->get('mas_colleague')->result_array();
    }
    public function updateDriverOtp($getClgId,$data){
        $this->db->where('userid',$getClgId)->insert('mas_colleague',$data);
    }
    public function insertDriverLoginData($data1){
        $this->db->insert('driver_app_login_session',$data1);
    }
    public function getDriverOtpCount($getClgId){
        $this->db->select('otp_count');
        $this->db->from('mas_colleague');
        $this->db->where('userid',$getClgId);
        return $this->db->get()->row()->otp_count;
    }
    public function emptydata($getClgId,$emptydata){
        $this->db->where('userid',$getClgId)->update('mas_colleague',$emptydata);
    }
    public function insertOtpCount($data,$getClgId){
        $this->db->where('userid',$getClgId)->update('mas_colleague',$data);
    }
}