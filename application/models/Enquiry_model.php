<?php
class Enquiry_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
    //    $this->tbl_mas_question = $this->db->dbprefix('mas_questionnaire');    
        
          $this->tbl_enquiry = $this->db->dbprefix('enquiry');    
          

    }
    
    //// Created by MI44 ////////////////////
    // 
    // Purpose : Insert Enquiry data.
    // 
    /////////////////////////////////////////
    
    function insert_enquiry($args=array()){
                
        $this->db->insert($this->tbl_enquiry, $args);  
        
        return $this->db->insert_id();
    
    }
    
      //// Created by MI44 ////////////////////
    // 
    // Purpose : Insert Enquiry data.
    // 
    /////////////////////////////////////////
    
    function get_enquiry($args=array()){
     
        if (trim($args['inc_ref_id']) != '') {
            $condition = " AND enq_inc_ref_id = '" . $args['inc_ref_id'] . "' ";
      
            
             $result = $this->db->query("
            SELECT * FROM $this->tbl_enquiry 
            WHERE enqis_deleted='0' $condition
            ");

        return $result->result();
            
        }

       
    
    }
    

    
}