<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Testapi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
public function testuserdata($data)
{
    $this->db->insert('ems_comu_app_testapi',$data);
    return 1;
}
}