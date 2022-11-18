<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Vehicle_Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
    public function getVehicleData($vehicleNumber){
        $this->db->select('veh.*');
        $this->db->from('mas_vehicles veh');
        $this->db->where('veh.veh_rto_register_no',$vehicleNumber);
        return $this->db->get()->result();
    }
    public function getVehicleLogin($vehicleNumber){
        $this->db->select('login_sess.*');
        $this->db->from('driver_app_login_session login_sess');
        $this->db->where('login_sess.login_vehicle_no',$vehicleNumber);
        $this->db->where('login_sess.status','1');
        return $this->db->get()->result();
    }
}