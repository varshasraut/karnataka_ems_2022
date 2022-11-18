<?php

class Stock_req_model extends CI_Model {

	
    function __construct() {

        parent::__construct();

        $this->load->database();
        
        $this->tbl_inditem = $this->db->dbprefix('indent_item');
        
       
    }
    
    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert indent item.
    // 
    /////////////////////////////////////////

	function insert_ind($args=array()){
        
        $this->db->insert($this->tbl_inditem,$args);
        
        $this->db->where_in('ind_id',$this->db->insert_id());

        $this->db->update($this->tbl_inditem,array('ind_req_id'=>$this->db->insert_id()));
        
        return $this->db->insert_id();
        	
	}
    
    
}
