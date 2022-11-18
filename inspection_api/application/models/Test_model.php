<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Test_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
	}

    public function addtest($data){
        $this->db->insert('test',$data);
        return 1;
    }
}