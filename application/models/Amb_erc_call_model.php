<?php
class Amb_erc_call_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
        $this->tbl_amb_erc_calls = $this->db->dbprefix('amb_erc_calls');
        $this->tbl_call_details_summary = $this->db->dbprefix('call_details_summary');
        
         $this->tbl_erosupervisor_call = $this->db->dbprefix('erosupervisor_call_details');
        
     

    }
    
    function insert_amb_erc($args=array()){
        
        $this->db->insert($this->tbl_amb_erc_calls, $args);  
        
         return $this->db->insert_id();
        
    }
    
    function add_call_summary($args = array()) {

        $this->db->insert($this->tbl_call_details_summary, $args);

        return $this->db->insert_id();
    }
    
    function insert_supervisor_inc($args=array()){
        
        $this->db->insert($this->tbl_erosupervisor_call, $args);  
        return $this->db->insert_id();
    }
    
}