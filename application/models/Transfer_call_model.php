<?php
class Transfer_call_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
        $this->tbl_transfer_calls = $this->db->dbprefix('transfer_calls');    
        
     

    }
    
    function insert_transfer_call($args=array()){
        
        $this->db->insert($this->tbl_transfer_calls, $args);  
        
         return $this->db->insert_id();
        
    }
    
}