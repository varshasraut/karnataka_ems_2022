<?php

class Fire_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_cls = $this->db->dbprefix('calls');

        $this->tbl_clrs = $this->db->dbprefix('callers');

        $this->tbl_pt = $this->db->dbprefix('patient');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_inc_pt = $this->db->dbprefix('incidence_patient');

        $this->tbl_opby = $this->db->dbprefix('operateby');

        $this->tbl_fire_station_calls_details = $this->db->dbprefix('fire_station_calls_details');

        $this->tbl_mas_fire_cheif_comp = $this->db->dbprefix('mas_fire_cheif_comp');

        $this->tbl_fire_station = $this->db->dbprefix('fire_station');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_dist = $this->db->dbprefix('mas_districts');
        $this->tbl_fire_station_manual_calls = $this->db->dbprefix('fire_station_manual_calls');
    }
    function get_all_calls($args=array()) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND fcall.fc_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND fcall.fc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT fcall.fc_inc_ref_id"
            . " FROM $this->tbl_fire_station_calls_details AS fcall"
            . " WHERE 1=1 $condition group by fc_inc_ref_id";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_all_calls_assign($args=array()) {
        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND fcall.fc_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND fcall.fc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT fcall.fc_inc_ref_id"
            . " FROM $this->tbl_fire_station_calls_details AS fcall"
            . " WHERE fc_assign_call='assign' $condition group by fc_inc_ref_id";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function add_fire($args = array()) {

        $res = $this->db->insert($this->tbl_fire_station_calls_details, $args);

        return $res;
    }

    function add_fire_manual_call($args = array()) {

        $res = $this->db->insert($this->tbl_fire_station_manual_calls, $args);

        return $res;
    }

    function get_inc_by_fire($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND fire_call.fc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if ($args['operator_id']) {
            $condition .= " AND fire_call.fc_added_by='" . $args['operator_id'] . "' ";
        }
         if ($args['child_fda']) {
            $condition .= " AND fire_call.fc_added_by IN ('" . $args['child_fda'] . "') ";
        }
        

        if ($args['fc_inc_ref_id']) {
            $condition .= " AND fire_call.fc_inc_ref_id='" . $args['fc_inc_ref_id'] . "' ";
        }

        if ($args['district_code']) {
            $condition .= " AND fire_call.fc_district_code='" . $args['district_code'] . "' ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND fire_call.fc_district_code IN ('" . $args['amb_district'] . "') ";
        }
         if ($args['inc_system_type']) {
             $condition .= " AND inc.inc_system_type IN ('" . $args['inc_system_type'] . "')";
         }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }


        $sql = "SELECT * "
            . " FROM $this->tbl_fire_station_calls_details AS fire_call "
            . " LEFT JOIN $this->tbl_fire_station AS fire ON ( fire.f_id = fire_call.fc_fire_station_id )"
            . " LEFT JOIN $this->tbl_mas_fire_cheif_comp AS chief ON ( chief.fi_ct_id = fire_call.fc_fire_chief_complaint )"
            . " LEFT JOIN $this->tbl_incidence AS inc ON ( fire_call.fc_pre_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = fire_call.fc_district_code )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND inc.incis_deleted = '0'  $condition) $search  GROUP BY fire_call.fc_inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";


        $result = $this->db->query($sql);
//        echo $this->db->last_query();
//        die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_inc_by_fire_manual_calls($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';


        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND fire_call.fc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }


        if ($args['child_fda']) {
            $condition .= " AND fire_call.fc_added_by IN ('" . $args['child_fda'] . "') ";
        }
        if ($args['operator_id']) {
            $condition .= " AND fire_call.fc_added_by='" . $args['operator_id'] . "' ";
        }

        if ($args['fc_inc_ref_id']) {
            $condition .= " AND fire_call.fc_inc_ref_id='" . $args['fc_inc_ref_id'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND ( clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND fire_call.fc_district_code IN ('" . $args['amb_district'] . "') ";
        }


        $sql = "SELECT * "
            . " FROM $this->tbl_fire_station_calls_details AS fire_call "
            . " LEFT JOIN $this->tbl_fire_station AS fire ON ( fire.f_id = fire_call.fc_fire_station_id )"
            . " LEFT JOIN $this->tbl_mas_fire_cheif_comp AS chief ON ( chief.fi_ct_id = fire_call.fc_fire_chief_complaint )"
            . " LEFT JOIN  $this->tbl_fire_station_manual_calls AS fire_manual ON ( fire_manual.mc_inc_ref_id = fire_call.fc_inc_ref_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = fire_manual.mc_caller_id )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = fire_call.fc_district_code )"
            . " WHERE  fire_manual.mc_is_deleted = '0'  $condition $search  GROUP BY fire_manual.mc_inc_ref_id  ORDER BY fire_call.fc_added_date DESC $offlim";
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function update_fire($new_data = array()) {

        if ($new_data['fc_id'] != '') {
            $this->db->where_in('fc_id', $new_data['fc_id']);
        }
        if ($new_data['fc_inc_ref_id'] != '') {
            $this->db->where_in('fc_inc_ref_id', $new_data['fc_inc_ref_id']);
        }


        $data = $this->db->update($this->tbl_fire_station_calls_details, $new_data);

        return $data;
    }

}
