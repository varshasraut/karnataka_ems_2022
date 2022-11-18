<?php
class Rtd_model extends CI_Model {
	
    function __construct() {
        
        parent::__construct();
        
        $this->tbl_responce_time_date  = $this->db->dbprefix('responce_time_date ');   
        $this->tbl_upload_B12_data  = $this->db->dbprefix('upload_B12_data');
         $this->tbl_district_wise_offroad = $this->db->dbprefix('district_wise_offroad');
         $this->tbl_offroad_details = $this->db->dbprefix('offroad_details');
         $this->tbl_onroad_details = $this->db->dbprefix('onroad_details');
         
           

    }

    function insert_excel_rtd($args=array()){
        
        $this->db->insert($this->tbl_responce_time_date, $args);  
        //echo $this->db->last_query();
        //die();
        
         return $this->db->insert_id();
        
    }
    function insert_excel_B12($args=array()){
        
        $this->db->insert($this->tbl_upload_B12_data, $args);  
        //echo $this->db->last_query();
        //die();
        
         return $this->db->insert_id();
        
    }

   function delete_district_wise_offroad(){
        

        $sql = "DELETE FROM ems_district_wise_offroad";

        $result = $this->db->query($sql);
        
         return true;
        
    }
     function insert_district_wise_offroad($args=array()){
        
        $this->db->insert($this->tbl_district_wise_offroad, $args);  
        //echo $this->db->last_query();
        //die();
        
         return $this->db->insert_id();
        
    }
    function insert_offroad_detalis($args=array()){
        
        $this->db->insert($this->tbl_offroad_details, $args);  
        //echo $this->db->last_query();
        //die();
        
         return $this->db->insert_id();
        
    }
    function insert_onroad_detalis($args=array()){
        
        $this->db->insert($this->tbl_onroad_details, $args);  
        //echo $this->db->last_query();
        //die();
        
         return $this->db->insert_id();
        
    }
    function get_rtd_data( $args = array()){
        
         if ($args['from_date'] != '') {

            $from = $args['from_date'];
            $condition .= " res_time.res_date = '$from'";

        }

        $sql = "select res_time.* from $this->tbl_responce_time_date as res_time where $condition";

    

      



        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($result) {

            return $result->result_array();

        } else {

            return false;

        }

    }
    
}