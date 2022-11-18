<?php
class Gen_enq_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
        //$this->tbl_mas_question = $this->db->dbprefix('mas_questionnaire');    
        
        $this->tbl_gen_enq_calls = $this->db->dbprefix('gen_enq_calls');    

    }
    
//    //// Created by MI44 ////////////////////
//    // 
//    // Purpose : To get question.
//    // 
//    /////////////////////////////////////////
//    
//    function get_question(){
//        
//        $result=$this->db->query("select * from $this->tbl_mas_question where que_isdeleted='0' AND que_type='test'");
//                
//        return $result->result();
//        
//    }
    
    
     //// Created by MI44 ////////////////////
    // 
    // Purpose :Insert test call details
    // 
    /////////////////////////////////////////
    
    
    function insert_gen_enq($args=array()){
        
        $this->db->insert($this->tbl_gen_enq_calls, $args);  
        
         return $this->db->insert_id();
        
    }
    
}