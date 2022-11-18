<?php
class Support_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
    //    $this->tbl_mas_question = $this->db->dbprefix('mas_questionnaire');    
        
          $this->tbl_support = $this->db->dbprefix('support');    
          

    }
    
    //// Created by MI44 ////////////////////
    // 
    // Purpose : Insert Enquiry data.
    // 
    /////////////////////////////////////////
    
    function insert_support_enquiry($args=array()){
                
        $this->db->insert($this->tbl_support, $args);  
        //echo $this->db->last_query(); die();
        
       
        
        return $this->db->insert_id();
    
    }
    

    
}