<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Emergenvehdismodel extends CI_Model {

    public function __construct() {
        parent::__construct();

    }
    public function insertEmgVehDis($data){
        $this->db->insert('ems_app_policefire_to_emg',$data);
        return 1;
    }
}