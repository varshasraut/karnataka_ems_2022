<?php

class Ambmain_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_amb_main = $this->db->dbprefix('ambulance_preventive_maintaince');
        $this->tbl_amb_brek_main = $this->db->dbprefix('amb_breakdown_maintaince');
        $this->tbl_amb_acc_main = $this->db->dbprefix('amb_accidental_maintaince');
        $this->tbl_amb_on_of = $this->db->dbprefix('amb_onroad_offroad');
        $this->tbl_amb_tyre = $this->db->dbprefix('amb_tyre_maintaince');
        $this->tbl_state = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_base_location = $this->db->dbprefix('base_location');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_work_station = $this->db->dbprefix('work_station');
        $this->tbl_media = $this->db->dbprefix('media');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_clg_logins = $this->db->dbprefix('clg_logins');
        $this->tbl_clg_break_summary = $this->db->dbprefix('clg_break_summary');
        $this->tbl_fleet_fuel_filling = $this->db->dbprefix('fleet_fuel_filling');
        $this->tbl_fuel_station = $this->db->dbprefix('fuel_station');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->ems_amb_accidental_maintaince_history = $this->db->dbprefix('amb_accidental_maintaince_history');
        $this->amb_accidental_maintaince_re_request_history = $this->db->dbprefix('amb_accidental_maintaince_re_request_history');
        $this->tbl_epcr = $this->db->dbprefix('epcr');
        $this->tbl_offroad_reason = $this->db->dbprefix('mas_offroad_reason');
    }
    function get_fuel_filling_data()
    {
        if () {
          
            // $condition .= " AND ff.ff_fuel_date_ti";
        }
        $sql = "SELECT ff.*,district.dst_name,fs.f_station_name,clg.clg_first_name,amb.amb_default_mobile,clg.clg_mid_name,clg.clg_last_name,clg_pilot.clg_mobile_no,amb_type.ambt_name,div_code.div_name"
            . " FROM $this->tbl_fleet_fuel_filling as ff"
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ff.ff_district_code )"
            . " LEFT JOIN $this->tbl_fuel_station as fs ON ( fs.f_id = ff.ff_fuel_station )" 
            . " LEFT JOIN $this->tbl_colleague as clg ON ( clg.clg_ref_id = ff.ff_added_by )" 
            . " LEFT JOIN $this->tbl_colleague as clg_pilot ON ( clg_pilot.clg_ref_id = ff.ff_pilot_id )" 
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = ff.ff_amb_ref_no )" 
            . " LEFT JOIN ems_mas_ambulance_type as amb_type ON ( amb_type.ambt_id = amb.amb_type )" 
            . " LEFT JOIN ems_mas_division as div_code ON (div_code.div_id = district.div_id )"
            . " where 1=1";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
}