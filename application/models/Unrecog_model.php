<?php

class Unrecog_model extends CI_Model{
	
    function __construct() {
        
        parent::__construct();
        
        $this->tbl_unrec_call = $this->db->dbprefix('unrec_call');    

    }
    
    
    function add($args=array()){
        
        $this->db->insert($this->tbl_unrec_call, $args);  
        
       // echo $this->db->last_query();die;
        
        return $this->db->insert_id();
        
    }
    
}