<?php

class Add_res_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
        $this->tbl_mas_question = $this->db->dbprefix('mas_questionnaire');    
        
        $this->tbl_inc_additional = $this->db->dbprefix('inc_additional_resource');    
        
        $this->tbl_colleague = $this->db->dbprefix('colleague');
    

    }

    
     //// Created by MI44 ////////////////////
    // 
    // Purpose : Insert  add resource call details
    // 
    /////////////////////////////////////////
    
    function insert($inc_id,$inc_old_id,$base_month,$resource_type){        
        
        $base_month!='';
        $inc_id!='';
        $inc_old_id!='';
        
        $ads_date =date('Y-m-d H:i:s');
        
        $sql = "insert into $this->tbl_inc_additional (`ads_inc_id`,`ads_old_inc_id`,`ads_resource_type`,`ads_date`,`ads_base_month`,`adsis_deleted`) values";
        
                       
        foreach($resource_type as $key=>$val){
            
            if($key!=''){
                
                $sql.="('$inc_id','$inc_old_id','$key','$ads_date','$base_month','0'),";      
                  
            }               
        }
        
        $query = trim($sql,',');     
        $result = $this->db->query($query);   
                           
        if($result){               
          return $this->db->insert_id();
        }else{
          return false;
        } 
        
        
    }
    
    
    function select_senior($clg_ref_id='',$resource_type=''){   
        
      $condition =  '';
     
      if(isset($clg_ref_id)){   $condition .= "AND clg1.clg_ref_id='".$clg_ref_id."'" ; }
      
        $sql = " SELECT DISTINCT clg1.clg_senior "
               . "FROM $this->tbl_colleague clg2 "
               . "LEFT JOIN $this->tbl_colleague clg1  
                 ON  clg2.clg_senior = clg1.clg_ref_id 
                 Where clg1.clg_is_deleted='0' $condition ";
     
        $result=$this->db->query($sql);           
            
        if($result){   

            $senior = $result->result();
            $condition = " clg_is_deleted ='0' ";
                
            $limit = count($resource_type);

            if(isset($resource_type['police']) && isset($resource_type['fire'])){   $condition .= "AND (clg_group ='UG-POLICE' OR clg_group ='UG-FIRE') " ; }else if(isset($resource_type['police'])){  $condition .= " AND clg_group ='UG-POLICE' ";} else if(isset($resource_type['fire'])){  $condition .= " AND clg_group ='UG-FIRE'" ; }
              
            $not_senior_check = $condition;
              
            if($senior[0]->clg_senior!= 'NA'){

               $condition .= " AND clg_senior = '".$senior[0]->clg_senior."' ";    
            } 
                
            if($limit>0){ $limit="limit $limit"; }
            
            $sql = "SELECT clg_group,clg_ref_id FROM $this->tbl_colleague WHERE $condition $limit";
                
            $result = $this->db->query($sql);      
            
            
            if(count($result->result())==0){  
                 
               $sql = "SELECT clg_group,clg_ref_id FROM $this->tbl_colleague WHERE $not_senior_check $limit";
                   
               $result = $this->db->query($sql);     
            }
                                
              return $result->result();

        }else{ 
            return false;
        }
     
    
    }
  
   
}