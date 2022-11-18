<?php

class Fleet_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_fuel_station = $this->db->dbprefix('fuel_station');
        $this->tbl_police_station = $this->db->dbprefix('police_station');
        $this->tbl_fire_station = $this->db->dbprefix('fire_station');
        $this->tbl_state = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');
        $this->tbl_mas_city = $this->db->dbprefix('mas_city');
        $this->tbl_work_station = $this->db->dbprefix('work_station');
        $this->tbl_equipment_service_center = $this->db->dbprefix('equipment_service_center');
        $this->tbl_oxygen_service_center = $this->db->dbprefix('oxygen_service_center');
        $this->tbl_statutory_compliance = $this->db->dbprefix('statutory_compliance');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_base_location = $this->db->dbprefix('base_location');
        $this->tbl_visitor_update = $this->db->dbprefix('visitor_update');
        $this->tbl_patient_handover_issue = $this->db->dbprefix('patient_handover_issue');
        $this->tbl_scene_challenges = $this->db->dbprefix('scene_challenges');
        $this->tbl_fleet_suggetions = $this->db->dbprefix('fleet_suggetions');
        $this->tbl_fleet_demo_training = $this->db->dbprefix('fleet_demo_training'); 
        $this->tbl_fleet_fuel_filling = $this->db->dbprefix('fleet_fuel_filling');
        $this->tbl_fleet_oxygen_filling = $this->db->dbprefix('fleet_oxygen_filling');
        $this->tbl_fleet_vehical_location_change = $this->db->dbprefix('fleet_vehical_location_change');
        $this->tbl_ind_req = $this->db->dbprefix('indent_request');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_indent_item = $this->db->dbprefix('indent_item');
    }

    function insert_fuel_station($args = array()) {

        $this->db->insert($this->tbl_fuel_station, $args);

        return $this->db->insert_id();
    }

    function insert_police_station($args = array()) {

        $this->db->insert($this->tbl_police_station, $args);

        return $this->db->insert_id();
    }

    function insert_fire_station($args = array()) {

        $this->db->insert($this->tbl_fire_station, $args);

        return $this->db->insert_id();
    }

    function get_all_fuel_station($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';
        if (trim($args['f_id']) != '') {
            $condition .= "AND fuel.f_id = '" . $args['f_id'] . "' ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND fuel.f_district_code IN ('" . $args['amb_district'] . "') ";
        }
        if ($args['term'] != '') {
            $condition .= " AND fuel.f_station_name LIKE '%" . $args['term'] . "%' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (fuel.f_station_name LIKE '%" . trim($args['search']) . "%' OR fuel.f_station_mobile_no LIKE '%" . trim($args['search']) . "%' OR fuel.f_oil_co_orportion LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%" . trim($args['search']) . "%')";
        }
         if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_fuel_station as fuel"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = fuel.f_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = fuel.f_district_code )"
            . " LEFT JOIN $this->tbl_mas_tahshil as tahsil ON ( tahsil.thl_code = fuel.f_tahsil )"
            . " LEFT JOIN $this->tbl_mas_city as city ON ( city.cty_id = fuel.f_city )"
            . "where f_is_deleted='0' $condition  ORDER BY fuel.f_station_name ASC $offlim";



        $result = $this->db->query($sql);

        //echo $this->db->last_query();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_all_police_station($args = array(), $limit = '', $offset = '') {

        $condition = $offlim = '';
        if (trim($args['p_id']) != '') {
            $condition .= "AND police.p_id = '" . $args['p_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (police.police_station_name LIKE '%" . trim($args['search']) . "%' OR police.police_station_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%')";
        }  
        if ($args['amb_district'] != '') {
            $condition .= " AND police.p_district_code IN ('" . $args['amb_district'] . "') ";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }


        $sql = "SELECT * FROM $this->tbl_police_station as police"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = police.p_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = police.p_district_code )"
            . "LEFT JOIN $this->tbl_mas_tahshil as tahsil ON (tahsil.thl_code = police.p_tahsil)"
            . "LEFT JOIN $this->tbl_mas_city as city ON (city.cty_id = police.p_city)"
            . "where p_is_deleted='0' $condition ORDER BY police.p_id DESC $offlim ";



        $result = $this->db->query($sql);

        //echo $this->db->last_query();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_all_fire_station($args = array(), $offset = '',  $limit= '') {

        $condition = $offlim = '';
        if (trim($args['f_id']) != '') {
            $condition .= "AND fire.f_id = '" . $args['f_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (fire.fire_station_name LIKE '%" . trim($args['search']) . "%' OR fire.f_station_mobile_no LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%')";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND fire.f_district_code IN ('" . $args['amb_district'] . "') ";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_fire_station as fire"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = fire.f_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = fire.f_district_code )"
            . "LEFT JOIN $this->tbl_mas_tahshil as tahsil ON (tahsil.thl_code = fire.f_tahsil)"
            . "LEFT JOIN $this->tbl_mas_city as city ON (city.cty_id = fire.f_city)"
            . "where f_is_deleted='0' $condition  ORDER BY  fire.f_id DESC  $offlim ";



        $result = $this->db->query($sql);

    
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function fuel_station_update_data($new_data = array()) {


        $this->db->where_in('f_id', $new_data['f_id']);

        $data = $this->db->update($this->tbl_fuel_station, $new_data);

        return $data;
    }

    function police_station_update_data($new_data = array()) {


        $this->db->where_in('p_id', $new_data['p_id']);

        $data = $this->db->update($this->tbl_police_station, $new_data);

        return $data;
    }

    function fire_station_update_data($new_data = array()) {


        $this->db->where_in('f_id', $new_data['f_id']);

        $data = $this->db->update($this->tbl_fire_station, $new_data);

        return $data;
    }

    function insert_work_station($args = array()) {

        $this->db->insert($this->tbl_work_station, $args);;
     //   echo $this->db->last_query();
       // die();

        return $this->db->insert_id();
    }

    function insert_vendor($args = array()) {

        $this->db->insert('ems_ambulance_vendor', $args);;
    //    echo $this->db->last_query();
    //    die();

        return $this->db->insert_id();
    }

    function work_station_update_data($new_data = array()) {

        $this->db->where_in('ws_id', $new_data['ws_id']);

        $data = $this->db->update($this->tbl_work_station, $new_data);

        return $data;
    }

    function vendor_update_data($new_data = array()) {

        $this->db->where_in('vendor_id', $new_data['vendor_id']);

        $data = $this->db->update('ems_ambulance_vendor', $new_data);

        return $data;
    }
    
    function get_work_station($args = array()) {

        $condition = $offlim = '';
        if (trim($args['ws_id']) != '') {
            $condition .= "AND work.ws_id = '" . $args['ws_id'] . "' ";
        }

          $sql = "SELECT * FROM $this->tbl_work_station as work "
            . "where work.ws_is_deleted='0' AND work.ws_is_active = '0' $condition $offlim ";
       
        

        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_vendor($args = array()) {

        $condition = $offlim = '';
        if (trim($args['ws_id']) != '') {
            $condition .= "AND work.ws_id = '" . $args['ws_id'] . "' ";
        }

          $sql = "SELECT * FROM $this->tbl_work_station as work "
            . "where work.ws_is_deleted='0' AND work.ws_is_active = '0' $condition $offlim ";
       
        

        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_all_active_work_station($args = array()) {

        $condition = $offlim = '';
        if (trim($args['ws_id']) != '') {
            $condition .= "AND work.ws_id = '" . $args['ws_id'] . "' ";
        }
        if (trim($args['district_code']) != '') {
            $condition .= "AND work.ws_district_code = '" . $args['district_code'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (work.ws_station_name LIKE '%" . trim($args['search']) . "%' OR work.ws_station_mobile_no LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
         if (isset($args['ws_station_name']) && $args['ws_station_name'] != '') {

            $condition .= "AND (work.ws_station_name LIKE '%" . trim($args['ws_station_name']) . "%')";
        }

          $sql = "SELECT * FROM $this->tbl_work_station as work"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = work.ws_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = work.ws_district_code )"
            
            . "where work.ws_is_deleted='0' AND work.ws_is_active = '0' $condition $offlim ";
        
      

                

        $result = $this->db->query($sql);
        // echo $this->db->last_query();die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_all_active_vendor($args = array()) {

        $condition = $offlim = '';
        if (trim($args['vendor_id']) != '') {
            $condition .= "AND work.vendor_id = '" . $args['vendor_id'] . "' ";
        }
        if (trim($args['district_code']) != '') {
            $condition .= "AND work.vendor_district = '" . $args['vendor_district'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (work.vendor_name LIKE '%" . trim($args['search']) . "%' OR work.vendor_mob_number LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        //  if (isset($args['ws_station_name']) && $args['ws_station_name'] != '') {

        //     $condition .= "AND (work.ws_station_name LIKE '%" . trim($args['ws_station_name']) . "%')";
        // }

          $sql = "SELECT * FROM $this->tbl_work_station as work"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = work.vendor_state ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = work.ws_district_code )"
            
            . "where work.vendoris_deleted='0' $condition $offlim ";
        
      


        $result = $this->db->query($sql);
        // echo $this->db->last_query();die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
        function get_all_work_station($args = array(),  $offset = '',$limit = '') {

        $condition = $offlim = '';
        if (trim($args['ws_id']) != '') {
            $condition .= "AND work.ws_id = '" . $args['ws_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (work.ws_station_name LIKE '%" . trim($args['search']) . "%' OR work.ws_station_mobile_no LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND work.ws_district_code IN ('" . $args['amb_district'] . "') ";
        }
        
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_work_station as work"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = work.ws_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = work.ws_district_code )"
            . " LEFT JOIN $this->tbl_mas_tahshil as tahsil ON ( tahsil.thl_code = work.ws_tahsil )"
            . " LEFT JOIN $this->tbl_mas_city as city ON ( city.cty_id = work.ws_city )"
            . "where ws_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    


    function get_all_vendor($args = array(),  $offset = '',$limit = '') {

            $condition = $offlim = '';
            if (trim($args['vendor_id']) != '') {
                $condition .= "AND work.vendor_id = '" . $args['vendor_id'] . "' ";
            }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (work.vendor_name LIKE '%" . trim($args['search']) . "%' OR work.vendor_mob_number LIKE '%" . trim($args['search']) . "%'  OR work.vendor_district LIKE '%" . trim($args['search']) . "%' OR work.vendor_state LIKE '%" . trim($args['search']) . "%')";
        }
        
        // if ($args['amb_district'] != '') {
        //     $condition .= " AND work.ws_district_code IN ('" . $args['amb_district'] . "') ";
        // }
        
        // if ($offset >= 0 && $limit > 0) {
        //     $offlim = "limit $limit offset $offset ";
        // }

        $sql = "SELECT * FROM ems_ambulance_vendor as work"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = work.vendor_state ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = work.vendor_district )"
            . " LEFT JOIN $this->tbl_mas_tahshil as tahsil ON ( tahsil.thl_code = work.vendor_tehshil )"
            . " LEFT JOIN $this->tbl_mas_city as city ON ( city.cty_id = work.vendor_city )"
            . " where 1 $condition $offlim order by work.vendor_added_date DESC";



        $result = $this->db->query($sql);
// echo $this->db->last_query();die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function insert_equipment_center($args = array()) {

        $this->db->insert($this->tbl_equipment_service_center, $args);

        return $this->db->insert_id();
    }

    function get_all_equipment_center_data($args = array(), $offset='', $limit='') {

        $condition = $offlim = '';
        if (trim($args['es_id']) != '') {
            $condition .= "AND equipment.es_id = '" . $args['es_id'] . "' ";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND equipment.es_district_code IN ('" . $args['amb_district'] . "') ";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (equipment.es_service_center_name LIKE '%" . trim($args['search']) . "%' OR equipment.es_station_mobile_no LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_equipment_service_center as equipment"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = equipment.es_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = equipment.es_district_code )"
            . "LEFT Join $this->tbl_mas_tahshil as tahsil ON (tahsil.thl_code = equipment.es_tahsil_code)"
            . "LEFT Join $this->tbl_mas_city as city ON (city.cty_id = equipment.es_city_code)"
            . "where es_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function equipment_center_update_data($new_data = array()) {

        $this->db->where_in('es_id', $new_data['es_id']);

        $data = $this->db->update($this->tbl_equipment_service_center, $new_data);

        return $data;
    }

    function insert_oxygen_center($args = array()) {

        $this->db->insert($this->tbl_oxygen_service_center, $args);

        return $this->db->insert_id();
    }

    function get_all_oxygen_center_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';
        if (trim($args['os_id']) != '') {
            $condition .= "AND oxygen.os_id = '" . $args['os_id'] . "' ";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (oxygen.os_oxygen_name LIKE '%" . trim($args['search']) . "%' OR oxygen.os_station_mobile_no LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND oxygen.os_district_code IN ('" . $args['amb_district'] . "') ";
        }

        $sql = "SELECT * FROM $this->tbl_oxygen_service_center as oxygen"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = oxygen.os_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = oxygen.os_district_code )"
            . " LEFT JOIN $this->tbl_mas_tahshil as tahsil ON ( tahsil.thl_code = oxygen.os_tahsil )"
            . " LEFT JOIN $this->tbl_mas_city as city ON ( city.cty_id = oxygen.os_city )"
            . "where os_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function oxygen_center_update_data($new_data = array()) {

        $this->db->where_in('os_id', $new_data['os_id']);

        $data = $this->db->update($this->tbl_oxygen_service_center, $new_data);

        return $data;
    }

    function insert_statutory_compliance($args = array()) {

        $this->db->insert($this->tbl_statutory_compliance, $args);

        return $this->db->insert_id();
    }

    function get_all_statutory_compliance_data($args = array(), $offset='', $limit='') {

        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND stat.sc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if (trim($args['sc_id']) != '') {
            $condition .= "AND stat.sc_id = '" . $args['sc_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (stat.sc_amb_ref_number LIKE '%" . trim($args['search']) . "%' OR hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  stat.sc_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND stat.sc_district_code IN ('" . $args['amb_district'] . "') ";
        }
        
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_statutory_compliance as stat"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = stat.sc_amb_ref_number ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = stat.sc_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = stat.sc_district_code )"
            . "where sc_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function statutory_compliance_update_data($new_data = array()) {

        $this->db->where_in('sc_id', $new_data['sc_id']);

        $data = $this->db->update($this->tbl_statutory_compliance, $new_data);

        return $data;
    }

    function insert_visitor($args = array()) {

        $this->db->insert($this->tbl_visitor_update, $args);
       

        return $this->db->insert_id();
    }

    function get_all_visitor_data($args = array(), $offset='', $limit='') {

        $condition = $offlim = '';
        if (trim($args['vs_id']) != '') {
            $condition .= "AND visitor.vs_id = '" . $args['vs_id'] . "' ";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND visitor.vs_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND visitor.vs_district_code IN ('" . $args['amb_district'] . "') ";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (visitor.vs_amb_ref_number LIKE '%" . trim($args['search']) . "%' OR visitor.vs_visitor_name LIKE '%" . trim($args['search']) . "%' OR  visitor.vs_contact_number LIKE '%" . trim($args['search']) . "%' OR  visitor.vs_added_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  visitor.vs_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
          if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_visitor_update as visitor"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = visitor.vs_amb_ref_number ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = visitor.vs_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = visitor.vs_district_code )"
            . "where vs_is_deleted='0' $condition order by  visitor.vs_id desc $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function visitor_update_data($new_data = array()) {

        $this->db->where_in('vs_id', $new_data['vs_id']);

        $data = $this->db->update($this->tbl_visitor_update, $new_data);

        return $data;
    }

    function insert_patient_handover_issue($args = array()) {

        $this->db->insert($this->tbl_patient_handover_issue, $args);

        return $this->db->insert_id();
    }

    function get_all_patient_handover_data($args = array(), $offset='', $limit='') {

        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ptn.ph_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND ptn.ph_district_code IN ('" . $args['amb_district'] . "') ";
        }
        

        if (trim($args['ph_id']) != '') {
            $condition .= "AND ptn.ph_id = '" . $args['ph_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (ptn.ph_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR ptn.ph_added_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  ptn.ph_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        
        $sql = "SELECT *,hosp.hp_id as hosp_id,hosp.hp_name as hosp_name FROM $this->tbl_patient_handover_issue as ptn"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = ptn.ph_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_hp as hosp ON ( hosp.hp_id = ptn.ph_hospital_name )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = ptn.ph_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ptn.ph_district_code )"
            . "where ph_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function patient_handover_update_data($new_data = array()) {

        $this->db->where_in('ph_id', $new_data['ph_id']);

        $data = $this->db->update($this->tbl_patient_handover_issue, $new_data);

        return $data;
    }

    function insert_scene_challenge($args = array()) {

        $this->db->insert($this->tbl_scene_challenges, $args);

        return $this->db->insert_id();
    }

    function get_all_scene_challenges_data($args = array(), $offset='', $limit='') {


        $condition = $offlim = '';
        if (trim($args['cs_id']) != '') {
            $condition .= "AND scene.cs_id = '" . $args['cs_id'] . "' ";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND scene.cs_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  scene.cs_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND scene.cs_district_code IN ('" . $args['amb_district'] . "') ";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (scene.cs_amb_ref_no LIKE '%" . trim($args['search']) . "%' scene.sc_added_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        

        $sql = "SELECT * FROM $this->tbl_scene_challenges as scene"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = scene.cs_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = scene.cs_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = scene.cs_district_code )"
            . "where cs_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function scene_challenges_update_data($new_data = array()) {

        $this->db->where_in('cs_id', $new_data['cs_id']);

        $data = $this->db->update($this->tbl_scene_challenges, $new_data);

        return $data;
    }

    function insert_suggestion($args = array()) {

        $this->db->insert($this->tbl_fleet_suggetions, $args);

        return $this->db->insert_id();
    }

    function get_all_suggestions_data($args = array(), $offset='', $limit='') {


        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND sugg.su_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (trim($args['su_id']) != '') {
            $condition .= "AND sugg.su_id = '" . $args['su_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (sugg.su_type LIKE '%" . trim($args['search']) . "%' OR sugg.su_date_time LIKE '%" . trim($args['search']) . "%' )";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  sugg.su_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT * FROM $this->tbl_fleet_suggetions as sugg  where su_is_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function suggestion_update_data($new_data = array()) {

        $this->db->where_in('su_id', $new_data['su_id']);

        $data = $this->db->update($this->tbl_fleet_suggetions, $new_data);

        return $data;
    }

    function insert_demo_training($args = array()) {

        $this->db->insert($this->tbl_fleet_demo_training, $args);

        return $this->db->insert_id();
    }

    function demo_training_update_data($new_data = array()) {

        $this->db->where_in('dt_id', $new_data['dt_id']);

        $data = $this->db->update($this->tbl_fleet_demo_training, $new_data);

        return $data;
    }

    function get_all_demo_training_data($args = array(), $offset='', $limit='') {
        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND demo.dt_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND demo.dt_district_code IN ('" . $args['amb_district'] . "') ";
        }

        if (trim($args['dt_id']) != '') {
            $condition .= "AND demo.dt_id = '" . $args['dt_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (demo.dt_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR demo.dt_start_date_time LIKE '%" . trim($args['search']) . "%'  OR demo.dt_in_odometer LIKE '%" . trim($args['search']) . "%' OR demo.dt_end_odometer LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  demo.dt_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT * FROM $this->tbl_fleet_demo_training as demo"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = demo.dt_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = demo.dt_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = demo.dt_district_code )"
            . "where dt_is_deleted='0' $condition $offlim ";

        $result = $this->db->query($sql);



        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_demo_training_data($args = array(), $offset='', $limit='') {

        if ($args['rto_no'] != '') {
            $condition .= " AND demo.dt_amb_ref_no  IN ('" . $args['rto_no'] . "') ";
        }
        
        $sql = "SELECT * FROM $this->tbl_fleet_demo_training as demo where dt_is_deleted='0' $condition ORDER BY demo.dt_added_by DESC Limit 1 ";

        $result = $this->db->query($sql);



        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_fuel_filling($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_fleet_fuel_filling");
        $this->db->where("$this->tbl_fleet_fuel_filling.ff_gen_id", $args['ff_gen_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();
       
        if (count($present) == 0) {

            $result =$this->db->insert($this->tbl_fleet_fuel_filling, $args);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {      
            $prev = str_replace('-', '', date('Y-m-d'));
            $prev1 = str_replace(':', '', date('H:i:s'));
            $prev_id = "FF-".$prev.'0'.$prev1.'1';
            $args['ff_gen_id']=$prev_id;
            
            $result = $this->db->insert($this->tbl_fleet_fuel_filling, $args);
            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }

        }

    }
    
    function get_all_fuel_filling_data($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';
        // print_r($args);die;
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND fuel.ff_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if (trim($args['rto_no']) != '') {
            $condition .= "AND fuel.ff_amb_ref_no = '" . $args['rto_no'] . "' ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND fuel.ff_district_code IN ('" . $args['amb_district'] . "') ";
        }
        if (trim($args['ff_id']) != '') {
            $condition .= "AND fuel.ff_id = '" . $args['ff_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (fuel.ff_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR fuel.ff_fuel_date_time LIKE '%" . trim($args['search']) . "%'  OR fuel.ff_previous_odometer LIKE '%" . trim($args['search']) . "%' OR fuel.ff_end_odometer LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR stat.f_station_name LIKE '%" . trim($args['search']) . "%' OR fuel.amb_fuel_status LIKE '%" . trim($args['search']) . "%' )";
        }
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  fuel.ff_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT fuel.*, stat.f_station_name, district.dst_name,state.st_name "
        ."FROM $this->tbl_fleet_fuel_filling as fuel"
            . " LEFT JOIN $this->tbl_fuel_station as stat ON ( stat.f_id = fuel.ff_fuel_station) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = fuel.ff_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_name = fuel.ff_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = fuel.ff_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = fuel.ff_district_code )"
            . "where ff_is_deleted='0' $condition  group by fuel.ff_id ORDER BY fuel.ff_added_date DESC  $offlim ";
        $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
    // print_r($result->result());die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_all_modif_fuel_filling_data($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';
        // print_r($args);die;
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND fuel.ff_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        // if (trim($args['rto_no']) != '') {
        //     $condition .= "AND fuel.ff_amb_ref_no = '" . $args['rto_no'] . "' ";
        // }
        // if ($args['amb_district'] != '') {
        //     $condition .= " AND fuel.ff_district_code IN ('" . $args['amb_district'] . "') ";
        // }
        if (trim($args['search']) != '') {
            $condition .= "AND fuel.ff_gen_id = '" . $args['search'] . "' ";
        }
        // if (isset($args['search']) && $args['search'] != '') {

        //     $condition .= "AND (fuel.ff_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR fuel.ff_fuel_date_time LIKE '%" . trim($args['search']) . "%'  OR fuel.ff_previous_odometer LIKE '%" . trim($args['search']) . "%' OR fuel.ff_end_odometer LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR stat.f_station_name LIKE '%" . trim($args['search']) . "%' OR fuel.amb_fuel_status LIKE '%" . trim($args['search']) . "%' )";
        // }
        // if (isset($args['search1']) && $args['search1'] != '') {

        //     $condition .= "AND  fuel.ff_added_date LIKE '%" . trim($args['search1']) . "%'";
        // }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT fuel.*, stat.f_station_name, district.dst_name,state.st_name "
        ."FROM $this->tbl_fleet_fuel_filling as fuel"
            . " LEFT JOIN $this->tbl_fuel_station as stat ON ( stat.f_id = fuel.ff_fuel_station) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = fuel.ff_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_name = fuel.ff_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = fuel.ff_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = fuel.ff_district_code )"
            . "where ff_is_deleted='0' $condition  group by fuel.ff_id ORDER BY fuel.ff_added_date DESC  $offlim ";
        $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_all_fuel_filling_data1($args = array() , $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND fuel.ff_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if (trim($args['rto_no']) != '') {
            $condition .= "AND fuel.ff_amb_ref_no = '" . $args['rto_no'] . "' ";
        }
        if (trim($args['ff_id']) != '') {
            $condition .= "AND fuel.ff_id = '" . $args['ff_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (fuel.ff_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR fuel.ff_fuel_date_time LIKE '%" . trim($args['search']) . "%'  OR fuel.ff_previous_odometer LIKE '%" . trim($args['search']) . "%' OR fuel.ff_end_odometer LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  fuel.ff_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT fuel.ff_current_odometer,fuel.ff_previous_odometer FROM $this->tbl_fleet_fuel_filling as fuel"
            . " LEFT JOIN $this->tbl_fuel_station as stat ON ( stat.f_id = fuel.ff_fuel_station) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = fuel.ff_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = fuel.ff_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = fuel.ff_district_code )"
            . "where ff_is_deleted='0' $condition $offlim ORDER BY fuel.ff_added_date DESC Limit 1 ";
        $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function fuel_filling_modify_data($new_data = array()) {

        // print_r($new_data);die;
        $this->db->where_in('ff_gen_id', $new_data['ff_gen_id']);

        $data = $this->db->update($this->tbl_fleet_fuel_filling, $new_data);

        return $data;
    }
    function fuel_filling_update_data($new_data = array()) {

        // print_r($new_data);die;
        $this->db->where_in('ff_id', $new_data['ff_id']);

        $data = $this->db->update($this->tbl_fleet_fuel_filling, $new_data);

        return $data;
    }
    function insert_oxgen_filling($args = array()) {

        $this->db->insert($this->tbl_fleet_oxygen_filling, $args);

        return $this->db->insert_id();
    }

    function get_all_oxygen_filling_data($args = array(), $offset = '', $limit = '') {

//var_dump($args);die;
        $condition = $offlim = '';

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND oxygen.of_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (trim($args['of_id']) != '') {
            $condition .= "AND oxygen.of_id = '" . $args['of_id'] . "' ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND oxygen.of_district_code IN ('" . $args['amb_district'] . "') ";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (oxygen.of_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR oxygen.of_added_date LIKE '%" . trim($args['search']) . "%'  OR oxygen.of_prevoius_odometer LIKE '%" . trim($args['search']) . "%' OR oxygen.of_end_odometer LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%' OR stat.os_oxygen_name LIKE '%" . trim($args['search']) . "%' OR oxygen.of_oxygen_amount LIKE '%" . trim($args['search']) . "%' OR oxygen.of_oxygen_quantity LIKE '%" . trim($args['search']) . "%' OR oxygen.amb_oxygen_status LIKE '%" . trim($args['search']) . "%')";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  oxygen.of_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        
        $sql = "SELECT oxygen.*,stat.*,district.dst_name,state.st_name,clg.clg_first_name,clg.clg_last_name FROM $this->tbl_fleet_oxygen_filling as oxygen"
            . " LEFT JOIN $this->tbl_oxygen_service_center as stat ON ( stat.os_id = oxygen.of_oxygen_station) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = oxygen.of_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = oxygen.of_state_code ) "
            . "LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = oxygen.of_dist_manager) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = oxygen.of_district_code )"
            . "where of_is_deleted='0' $condition ORDER BY oxygen.of_id DESC $offlim ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
        function get_all_oxygen_filling_data_by_amb($args = array()) {

//var_dump($args);die;
        $condition = $offlim = '';

        if (trim($args['of_id']) != '') {
            $condition .= "AND oxygen.of_id = '" . $args['of_id'] . "' ";
        }
        if ($args['rto_no'] != '') {
            $condition .= " AND oxygen.of_amb_ref_no  IN ('" . $args['rto_no'] . "') ";
        }
       
        
        $sql = "SELECT oxygen.* FROM $this->tbl_fleet_oxygen_filling as oxygen where of_is_deleted='0' $condition  ORDER BY oxygen.of_added_date DESC Limit 1 ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function oxygen_filling_update_data($new_data = array()) {

        $this->db->where_in('of_id', $new_data['of_id']);

        $data = $this->db->update($this->tbl_fleet_oxygen_filling, $new_data);

        return $data;
    }

    function insert_vehical_location_change($args = array()) {

        $this->db->insert($this->tbl_fleet_vehical_location_change, $args);
        ///echo $this->db->last_query();
        //die();

        return $this->db->insert_id();
    }

    function get_all_vehical_location_data($args = array(), $offset='', $limit='') {


        $condition = $offlim = '';
        if (trim($args['vl_id']) != '') {
            $condition .= "AND vehical.vl_id = '" . $args['vl_id'] . "' ";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND vehical.vl_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  vehical.vl_added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (vehical.vl_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR vehical.vl_expecteed_date_time LIKE '%" . trim($args['search']) . "%'  OR vehical.vl_previous_odometer LIKE '%" . trim($args['search']) . "%' OR vehical.vl_end_odometer LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%' OR vehical.amb_vechicle_status LIKE '%" . trim($args['search']) . "%')";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT * FROM $this->tbl_fleet_vehical_location_change as vehical"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = vehical.vl_amb_ref_no) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = vehical.vl_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = vehical.vl_district_code )"
            . " where vl_is_deleted='0' $condition Order by vehical.vl_added_date DESC $offlim ";
        
        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function get_vehical_location_data($args = array()) {
        
        if ($args['rto_no'] != '') {
            $condition .= " AND vehical.vl_amb_ref_no  IN ('" . $args['rto_no'] . "') ";
        }

        $sql = "SELECT * FROM $this->tbl_fleet_vehical_location_change as vehical"
            . " where vl_is_deleted='0' $condition ORDER BY vehical.vl_added_date DESC Limit 1  ";
        
        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function vehical_location_update_data($new_data = array()) {

        $this->db->where_in('vl_id', $new_data['vl_id']);

        $data = $this->db->update($this->tbl_fleet_vehical_location_change, $new_data);


        return $data;
    }

    function get_all_indent_item($args = array(), $offset = '', $limit = '') {

        $condition = '';

        if ((isset($args['ref_id'])) && $args['ref_id'] != "") {
            $condition .= "AND ind_req.req_emt_id='" . $args['ref_id'] . "'";
        }

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= "AND ind_req.req_id='" . $args['req_id'] . "'";
        }

        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= "AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= "AND ind_req.req_type = '$req_type'";
        }

        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= "AND ind_req.req_group = '$req_grp'";
        }
        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= "AND ind_req.req_is_approve = '$req_grp'";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND ind_req.req_district_code IN ('" . $args['amb_district'] . "') ";
        }

         if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (ind_req.req_amb_reg_no LIKE '%" . trim($args['search']) . "%' OR ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

//        $sql = "SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk "
//            . "FROM ($this->tbl_ind_req as ind_req,$this->tbl_ambulance as amb) "
//            . "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
//            . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
//            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = ind_req.req_state_code ) "
//            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )"
//            . "LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
//            . "where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";
   $sql = "SELECT ind_req.*,hp.hp_name,district.dst_name,CONCAT_WS(' ',ems_clg.clg_first_name,ems_clg.clg_mid_name,ems_clg.clg_last_name) AS 'whole_name' "
            . "FROM ($this->tbl_ind_req as ind_req,$this->tbl_ambulance as amb) " 
            . "LEFT JOIN $this->tbl_base_location as hp ON (amb.amb_base_location = hp.hp_id) "
            . "LEFT JOIN ems_colleague as ems_clg ON (ind_req.req_district_manager = ems_clg.clg_ref_id) "
            . "LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )"
            . "where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";           
        // echo $sql;
        // die();
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
      function get_report_indent_item_data($args = array(), $offset = '', $limit = '') {

        $condition = '';

        if ((isset($args['ref_id'])) && $args['ref_id'] != "") {
            $condition .= "AND ind_req.req_emt_id='" . $args['ref_id'] . "'";
        }

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= "AND ind_req.req_id='" . $args['req_id'] . "'";
        }
        
        if ((isset($args['item_type'])) && $args['item_type'] != "") {
            $condition .= "AND ind_item.ind_item_type='" . $args['item_type'] . "'";
        }

        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= "AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= "AND ind_req.req_type = '$req_type'";
        }

        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= "AND ind_req.req_group = '$req_grp'";
        }
        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= "AND ind_req.req_is_approve = '$req_grp'";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND ind_req.req_district_code IN ('" . $args['amb_district'] . "') ";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (ind_req.req_amb_reg_no LIKE '%" . trim($args['search']) . "%' OR ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT ind_req.*,hp.hp_name,district.dst_name,ind_item.* "
            . "FROM ($this->tbl_ind_req as ind_req,$this->tbl_ambulance as amb) "  
            . "LEFT JOIN $this->tbl_indent_item  AS ind_item  ON (ind_item.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_base_location as hp ON (amb.amb_base_location = hp.hp_id) "
           // . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = ind_req.req_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code ) "
           // . "LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . "where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";
        
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_pervious_fuel_date_time($args = array()){

        $amg_no =$args['amb_ref_id'];
        if ($amg_no) {
            $condition = "ff_amb_ref_no='" . $amg_no . "' ";
        }

        $sql ="SELECT ff_fuel_date_time from ems_fleet_fuel_filling where $condition ORDER BY ff_fuel_date_time desc limit 1";

        $result = $this->db->query($sql);
        // echo $this->db->last_query();die; 
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

}
