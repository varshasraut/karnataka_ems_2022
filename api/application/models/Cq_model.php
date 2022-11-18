<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cq_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_cq_data($vehicleNumber){
        return $this->db->where('cq_vehicle',$vehicleNumber)->order_by('cq_id','DESC')->limit(10)->get('ems_app_cq')->result_array();
    }
}