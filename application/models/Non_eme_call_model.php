<?php
class Non_eme_call_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
        $this->tbl_non_eme_calls = $this->db->dbprefix('non_eme_calls');    
        
     

    }
    
    function insert_non_eme_call($args=array()){
        
        $this->db->insert($this->tbl_non_eme_calls, $args);  
        
         return $this->db->insert_id();
        
    }
    
}