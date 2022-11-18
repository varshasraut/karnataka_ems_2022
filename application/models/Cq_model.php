<?php

class Cq_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_groups');
        $this->tbl_mas_amb_type = $this->db->dbprefix('mas_ambulance_type');
        $this->tbl_mas_amb_status = $this->db->dbprefix('mas_ambulance_status');
        $this->tbl_amb = $this->db->dbprefix('ambulance');
        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_mas_states = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');
        $this->tbl_mas_city = $this->db->dbprefix('mas_city');
        $this->tbl_driver_pcr = $this->db->dbprefix('driver_pcr');
        $this->tbl_replace = $this->db->dbprefix('amb_replacement_details');
        $this->tbl_odometer_detail = $this->db->dbprefix('amb_odometer_change_detail');
        $this->tbl_mas_area_types = $this->db->dbprefix('mas_area_types');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_amb_base_location = $this->db->dbprefix('base_location');
        $this->tbl_ambulance_base = $this->db->dbprefix('ambulance_base');
        $this->tbl_default_team = $this->db->dbprefix('amb_default_team');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_ambulance_timestamp_record = $this->db->dbprefix('ambulance_timestamp_record');
        $this->tbl_ambulance_status_summary = $this->db->dbprefix('ambulance_status_summary');
        $this->tbl_mas_odometer_remark = $this->db->dbprefix('mas_odometer_remark');
        $this->tbl_ambulance_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_epcr = $this->db->dbprefix('epcr');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_supervisor_remark = $this->db->dbprefix('supervisor_remark');
        $this->tbl_supervisor_release = $this->db->dbprefix('supervisor_release');
        $this->tbl_hos_bed_avaibility = $this->db->dbprefix('hos_bed_avaibility');
        $this->tbl_amb_replacement_details = $this->db->dbprefix('amb_replacement_details');
        $this->tbl_inv = $this->db->dbprefix('inventory');
        $this->tbl_invmd = $this->db->dbprefix('inventory_medicine');
        $this->tbl_mas_ward = $this->db->dbprefix('mas_ward');
        $this->tbl_ambid_reopen_details = $this->db->dbprefix('ambid_repen_details');
        $this->tbl_battery_type = $this->db->dbprefix('battery_type');
        $this->tbl_app_cq = $this->db->dbprefix('app_cq');
    }

    function insert_cq_data($args = array()) {
        $result = $this->db->insert($this->tbl_app_cq, $args);
            //echo $this->db->last_query();die;
            if ($result) {

                return $result;
            } else {

                return false;
            }        
    }
    function get_cq_data_listing($args = array()){
        $condition ='';
        if($args['cq_id'] != ''){
            $condition .="AND cq.cq_id = '".$args['cq_id']."' ";
        }
        $sql = "SELECT * "
            . " FROM $this->tbl_app_cq AS cq "
           . "  where 1=1 $condition ORDER BY cq.cq_added_date DESC ";
        $result = $this->db->query($sql);
       // echo $this->db->last_query();
       // die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
}