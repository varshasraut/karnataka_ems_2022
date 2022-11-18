<?php
class Bpcl_model extends CI_Model {

    function __construct() {

        parent::__construct();


        $this->tbl_bpcl_data = $this->db->dbprefix('bpcl_data');
         $this->tbl_amb = $this->db->dbprefix('ambulance');
      
    }
    
  function hpcl_data_insert($args = array()) {
        $result = $this->db->insert($this->tbl_bpcl_data, $args);
        if ($result) {

            return $result;
        } else {

            return false;
        }
        
    }
    
   function get_bpcl_data($args = array()){

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND bpcl.TransactionDate BETWEEN '$from' AND '$to 23:59:59'";
        }

         $sql = "SELECT bpcl.*,amb.amb_rto_register_no,amb.card_no,amb.amb_district,amb.amb_base_location FROM $this->tbl_bpcl_data AS bpcl "
           . " LEFT JOIN $this->tbl_amb AS amb ON (bpcl.cardId  = amb.card_no AND amb.fctype='BPCL')"
            . " Where bpcl.is_deleted ='0' $condition group by bpcl_id";

        $result = $this->db->query($sql);
         //echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_bpcl_amb_details($args = array()){
        if ($args['hpcl_amb'] != '') {
            $hpcl_amb = str_replace(' ', '', $args['hpcl_amb']);
            $condition .= " AND bpcl.vehicleNumber = '" . $hpcl_amb . "' ";
        } 
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND bpcl.createdDT BETWEEN '$from' AND '$to 23:59:59'";
        }

        
         $sql = "SELECT bpcl.*,amb.amb_rto_register_no,amb.card_no,amb.amb_district,amb.amb_base_location FROM $this->tbl_bpcl_data AS bpcl "
           . " LEFT JOIN $this->tbl_amb AS amb ON (bpcl.cardId  = amb.card_no AND amb.fctype='BPCL')"
            . " Where bpcl.is_deleted ='0' $condition group by bpcl.bpcl_id";

        $result = $this->db->query($sql);
         //echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
 
}