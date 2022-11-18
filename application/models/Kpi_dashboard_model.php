<?php
class kpi_dashboard_model extends CI_Model {
    function __construct() {
        
        parent::__construct();
        $this->tbl_kpi_dashboard  = $this->db->dbprefix('kpi_dashboard');  
    }
    function insert_kpi_data($args = array()) {
        // print_r($args);die;
        $this->db->insert($this->tbl_kpi_dashboard, $args); 
        // echo $this->db->last_query();
        // die(); 
    }
    function get_kpi_data(){

        $sql ="select * from $this->tbl_kpi_dashboard order by kpi_id DESC LIMIT 1";
        
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
}
?>