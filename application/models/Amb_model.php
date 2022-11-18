<?php

class Amb_model extends CI_Model {

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
    }

    /////////////MI44////////////////////////////////////////////////////
    //

    //Purpose : ftech all ambulance type on mas_ambulance_type table
    //

    ///////////////////////////////////////////////////////////////////

    function update_amb_status($args = array()) {
       // var_dump($args);die();
        if($args['amb_status'] == '5')
        {
            $args['amb_status'] = '1';
           // $args['ambis_deleted'] = '0';
        }else{
            $args['amb_status'] = '5';
           // $args['ambis_deleted'] = '1';
        }
        
        if ($args['amb_id']) {
            $this->db->where('amb_id', $args['amb_id']);
            $update = $this->db->update($this->tbl_amb, $args);
            //echo $this->db->last_query(); die;
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function get_amb_status_detail($args=array()){
        $condition = '';
        if($args['amb_no'] != ''){
            $condition .= " AND amb_rto_register_no = '" . $args['amb_no'] . "' ";
        }
        $sql = "SELECT amb.*,amb_status.ambs_name FROM ems_ambulance as amb
                LEFT JOIN ems_mas_ambulance_status AS amb_status ON amb_status.ambs_id=amb.amb_status
                WHERE ambis_deleted = '0' $condition ";
       

        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_amb_detail($args=array()) {
        $condition = '';
        if($args['amb_no'] != ''){
            $condition .= " AND amb_rto_register_no = '" . $args['amb_no'] . "' ";
        }
        $sql = "SELECT * FROM ems_ambulance WHERE ambis_deleted = '0' $condition ";
       

        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_amb_type($args=array()) {



        if($args['ambt_id'] != ''){
            $condition .= " AND ambt_id='" . $args['ambt_id'] . "'";
        }
         if($args['ambty_id'] != ''){
            $condition .= " AND ambt_id IN (" . $args['ambty_id'] . ")";
        }
        if($args['not_ambty_id'] != ''){
            $not_amb_it = implode("','",$args['not_ambty_id'] );
            $condition .= " AND ambt_id NOT IN ('" . $not_amb_it . "')";
        }
        
         $sql = "SELECT * FROM $this->tbl_mas_amb_type WHERE ambtis_deleted='0' $condition order by ambu_level";
       

        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function get_amb_thirdparty($args=array()) {



        if($args['thirdparty_id'] != ''){
            $condition .= " AND thirdparty_id='" . $args['thirdparty_id'] . "'";
        }
         
        
         $sql = "SELECT * FROM `ems_mas_thirdparty` WHERE is_deleted='0' $condition";
    

        $result = $this->db->query($sql);

        // echo $this->db->last_query();
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function get_amb_vendor($args=array()) {



        if($args['vendor_id '] != ''){
            $condition .= " AND vendor_id ='" . $args['vendor_id '] . "'";
        }
         
        
         $sql = "SELECT * FROM `ems_ambulance_vendor` WHERE vendoris_deleted='0' $condition";
    

        $result = $this->db->query($sql);

        // echo $this->db->last_query();
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_dm_mob_no($args=array()){
        
        $condition ='';
        if($args['amb_no'] != ''){
            $condition .= " AND amb_rto_register_no='" . $args['amb_no'] . "'";
        }
        $sql = "SELECT amb.amb_rto_register_no,amb.amb_district,clg.clg_mobile_no,clg.clg_first_name FROM ems_ambulance as amb  
                LEFT JOIN ems_colleague AS clg ON amb.amb_district=clg.clg_district_id
                where ambis_deleted='0' AND clg.clg_group='UG-DM'  $condition ";
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die; 
        //print_r($result->result());die;
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_drop_hospital_name($args=array()){
        if($args['drop_hospital'] != ''){
            $condition .= " AND hp_id='" . $args['drop_hospital'] . "'";
        }
        $sql = "SELECT * FROM ems_hospital as hos  where 1=1 $condition ";
        // echo $this->db->last_query();die; 
        $result = $this->db->query($sql);
        // print_r($result->result());die;
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
        function get_amb_make_model_by_regno($args=array()) {



        if($args['rto_no'] != ''){
            $condition .= " AND amb_rto_register_no='" . $args['rto_no'] . "'";
        }
         //$sql = "SELECT * FROM $this->tbl_mas_amb_type WHERE ambtis_deleted='0' $condition order by ambu_level";

        $sql = "SELECT amb.vehical_make as ambt_name,amb.vehical_model,tp.ambt_id,tp.ambt_name as ambu_type,amb.amb_owner as amb_owner,amb_pr.prc_price as ambu_price
         FROM $this->tbl_amb as amb  
         LEFT JOIN $this->tbl_mas_amb_type as tp ON (tp.ambt_id=amb.amb_type)
         LEFT JOIN ems_mas_amb_price as amb_pr ON (amb.amb_category=amb_pr.prc_categoy AND amb.amb_type=amb_pr.prc_amb_type_id) 
         where 1=1 $condition GROUP BY amb.amb_rto_register_no ";
        //echo $sql;
        // echo $this->db->last_query();die; 
        $result = $this->db->query($sql);
        // print_r($result->result());die;
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
        
    function get_ward_name($args=array()) {



        if($args['ward_id'] != ''){
            $condition .= " AND ward_id='" . $args['ward_id'] . "'";
        }
         $sql = "SELECT * FROM $this->tbl_mas_ward WHERE isdeleted='0' AND status='1' $condition order by 	ward_name";



        $result = $this->db->query($sql);

        //echo $this->db->last_query(); die;

        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    
    function get_amb_type_level_by_id($amb_id) {

        $sql = "SELECT * FROM $this->tbl_mas_amb_type WHERE ambtis_deleted='0' AND ambt_id IN ($amb_id)";

        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    /////////////MI44////////////////////////////////////////////////////
    //

    //Purpose : ftech all ambulance status on mas_ambulance_status table
    //

    ///////////////////////////////////////////////////////////////////



    function get_amb_status() {



        $sql = "SELECT * FROM $this->tbl_mas_amb_status WHERE ambsis_deleted='0' ";



        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    ////////////////MI44////////////////////
    //

    //Purpose:Get ambulance data
    //

    ////////////////////////////////////////
function get_amb_login_status($args = array()) {
        $condition = "";
        if (isset($args['amb_rto_register_no'])  != '') {

            $condition .= " AND t2.vehicle_no IN ('" . $args['amb_rto_register_no'] . "') ";
        }
        if (isset($args['type'])  != '') {

            $condition .= " AND t2.login_type IN ('" . $args['type'] . "') ";
        }
        if (isset($args['status'])  != '') {

            $condition .= " AND t2.status IN ('" . $args['status'] . "') ";
        }
        $sql = "SELECT t2.* FROM  ems_app_login_session as t2 WHERE  1=1 $condition ORDER BY t2.id DESC limit 1";
        
        //echo $sql;
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query(); 
        //die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function update_amb_login_status($amb_id, $status = '') {


        if($amb_id != ''){

            $this->db->where_in('id', $amb_id);
            $status = $this->db->update('ems_app_login_session', $status);
            //echo $this->db->last_query();die; 
            $sql = $this->db->last_query() . " \n time:'".date('Y-m-d H:i:s') ; 
            file_put_contents('logs/Query_log/web_loginSession_query_log-' . date('Y-m-d') . '.php', $sql.",\r\n", FILE_APPEND);
            return $status;
        }
    }

    function get_amb_emso_name($args = array(), $offset = '', $limit = '') {
        
        if (isset($args['amb_rto_register_no'])  != '') {

            $condition .= " AND t2.vehicle_no IN ('" . $args['amb_rto_register_no'] . "') ";
        }
        if (isset($args['type'])  != '') {

            $condition .= " AND t2.login_type IN ('" . $args['type'] . "') ";
        }
        if (isset($args['status'])  != '') {

            $condition .= " AND t2.status IN ('" . $args['status'] . "') ";
        }
        
        $current_date = date('Y-m-d H:i:s');
        $login_date = date('Y-m-d H:i:s', strtotime('-12 hour', strtotime($current_date)));
        
        $sql = "SELECT t2.*,clg.clg_ref_id,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no FROM  ems_app_login_session as t2 
        LEFT JOIN ems_colleague as clg ON (t2.clg_id = clg.clg_id ) 
        WHERE  1=1 $condition ORDER BY t2.id DESC limit 1";
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
        //echo $sql;
       /* $this->db->select('clg_login.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no');
        $this->db->from('ems_app_login_session clg_login');
        $this->db->join('ems_colleague clg', 'clg_login.clg_id = clg.clg_id', 'left');
        $this->db->where('clg_login.vehicle_no', $args['amb_rto_register_no']);
        */
        //$query = $this->db->get();
        if ( $sql > 0 )
        {
            return $result->result();
        }
       
      /*  $sql = "SELECT t2.* FROM  ems_app_login_session as t2 WHERE  1=1 $condition ORDER BY t2.id DESC limit 1";
        
        //echo $sql;
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query(); 
        //die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        } */
    }

     function get_amb_login_data($args = array(), $offset = '', $limit = '') {
        if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND t2.thirdparty IN ('" . $args['thirdparty'] . "') ";
        }
       /* if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
           
        }*/
        $sql = "SELECT t2.* FROM  ems_ambulance as t2 WHERE  1=1 $condition ";
        
        //echo $sql;
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query(); 
        //die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
        
    }
        function get_amb_data_listing($args = array(), $offset = '', $limit = '') {



        $condition = $offlim = '';


        if (isset($args['amb_id'])) {

            $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
        }
        if (isset($args['district_id'])  != '') {

            $condition .= "AND amb.amb_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_base_location'])  != '') {

            $condition .= "AND amb.amb_base_location='" . $args['amb_base_location'] . "'";
        }
        if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND amb.thirdparty IN ('" . $args['thirdparty'] . "') ";
        }
        
        if (isset($args['amb_supervisor'])  != '') {

            $condition .= " AND amb.amb_supervisor IN ('" . $args['amb_supervisor'] . "') ";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
        }

        if (isset($args['rg_no']) && $args['rg_no'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
        }
        
        if (isset($args['amb_user']) && $args['amb_user'] != '' && $args['amb_user'] != 'all') {

            $condition .= "AND amb.amb_user='" . trim($args['amb_user']) . "'";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . trim($args['amb_rto_register_no']) . "'";
        }
        
        if (isset($args['amb_search']) && $args['amb_search'] != '') {

            if ($args['amb_search'] == 'JE' ||  strtoupper($args['amb_search']) == 'je') {
                $type = '1';
            } else if ($args['amb_search'] == 'BLS' || strtoupper($args['amb_search']) == 'bls') {
                $type = '2';    
            } else if ($args['amb_search'] == 'ALs' || strtoupper($args['amb_search']) == 'als') {
                $type = '3';
            }

            if ($args['amb_search'] == 'Available') {
                $status = '1';
            } else if ($args['amb_search'] == 'Busy') {
                $status = '2';
            } else if ($args['amb_search'] == 'Stand By') {
                $status = '3';
            } else if ($args['amb_search'] == 'Change Location') {
                $status = '4';
            } else if ($args['amb_search'] == 'Deleted / Inactive') {
                $status = '5';
            }  else if ($args['amb_search'] == 'Off Road') {
                $status = '7';
            } else if ($args['amb_search'] == 'Stand by Oxygen Filling') {
                $status = '8';
            } else if ($args['amb_search'] == 'Stand by Fuel Filling') {
                $status = '9';
            } else if ($args['amb_search'] == 'Stand by Demo Traning') {
                $status = '10';
            } else if ($args['amb_search'] == 'In Other General-Off Road') {
                $status = '11';
            } else if ($args['amb_search'] == 'On-Road') {
                $status = '12';
            } else if ($args['amb_search'] == 'In Equipment Maintenance ') {
                $status = '13';
            } 

            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";
        }
        if (isset($args['search_amb']) && $args['search_amb'] != '') {
            
            if ($args['search_amb'] == 'ALS' || $args['search_amb'] == 'als' ) {
                $type = '4';
            } else if ($args['search_amb'] == 'BLS' || $args['search_amb'] == 'bls' ) {
                $type = '3';
            } else if ($args['search_amb'] == 'PTA' || $args['search_amb'] == 'PTA (102)' || $args['search_amb'] == 'pta' ) {
                $type = '2';
            } else if ($args['search_amb'] == 'Two_wheel' || $args['search_amb'] == 'Two wheel' || $args['search_amb'] == 'Two wheeler') {
                $type = '1';
            } else if ($args['search_amb'] == 'CC' || $args['search_amb'] == 'CC') {
                $type = '5';
            } else if ($args['search_amb'] == 'AIR' || $args['search_amb'] == 'air') {
                $type = '6';
            }

            if ($args['search_amb'] == 'Available') {
                $status = '1';
            } else if($args['search_amb'] == 'Busy') {
                $status = '2';
            } else if($args['search_amb'] == 'Stand By') {
                $status = '3';
            } else if ($args['search_amb'] == 'Change Location') {
                $status = '4';
            } else if ($args['search_amb'] == 'In Maintenance On Road' || $args['search_amb'] == 'On Road') {
                $status = '6';
            } else if ($args['search_amb'] == 'In maintenance Off Road' || $args['search_amb'] == 'Off Road') {
                $status = '7';
            } else if ($args['search_amb'] == 'Stand by Oxygen Filling') {
                $status = '8';
            }
            
          

           // $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '" . trim($args['search_amb']) . "' OR amb.amb_status = '" . trim($args['search_amb']) . "')";
            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";

            
        }
        if ($args['amb_district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
            

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        //$order_by = "ORDER BY amb_tm.assigned_time DESC";
        $order_by = "ORDER BY FIELD(amb.amb_user,'108','tdd','102','bike')";


        // $sql = "SELECT amb.*,hp.hp_name,amb_tm.timestamp FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id LEFT JOIN $this->tbl_ambulance_timestamp_record as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no where amb.ambis_deleted='0' $condition GROUP BY amb_tm.amb_rto_register_no  ORDER BY amb_tm.timestamp DESC $offlim ";
      $sql = "SELECT third_party.thirdparty_name,amb.*,wrd.ward_name,dist.dst_name,hp.hp_name,dist.dst_name as dst_name 
       FROM $this->tbl_amb as amb  
       LEFT JOIN $this->tbl_amb_base_location as hp ON amb.amb_base_location = hp.hp_id 
       LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id 
      
       LEFT JOIN $this->tbl_mas_districts as dist ON amb.amb_district = dist.dst_code 
       LEFT JOIN `ems_mas_thirdparty` as third_party ON ( third_party.thirdparty_id = amb.thirdparty )
       where  1=1 $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";
       //where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";

        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }


    function get_amb_data($args = array(), $offset = '', $limit = '') {

    // var_dump($limit);die();

        $condition = $offlim = '';


        if (isset($args['amb_id'])) {

            $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
        }
        if (isset($args['district_id'])  != '') {

            $condition .= "AND amb.amb_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_base_location'])  != '') {

            $condition .= "AND amb.amb_base_location='" . $args['amb_base_location'] . "'";
        }
        if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND amb.thirdparty IN ('" . $args['thirdparty'] . "') ";
        }
        
        if (isset($args['amb_supervisor'])  != '') {

            $condition .= " AND amb.amb_supervisor IN ('" . $args['amb_supervisor'] . "') ";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
        }

        if (isset($args['rg_no']) && $args['rg_no'] != '' && !(is_array($args['rg_no']))) {

            $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
        }
        
        if (isset($args['amb_user']) && $args['amb_user'] != '' && $args['amb_user'] != 'all') {

            $condition .= "AND amb.amb_user='" . trim($args['amb_user']) . "'";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . trim($args['amb_rto_register_no']) . "'";
        }
       
        if (isset($args['amb_search']) && $args['amb_search'] != '') {

            if ($args['amb_search'] == 'JE' ||  strtoupper($args['amb_search']) == 'je') {
                $type = '1';
            } else if ($args['amb_search'] == 'BLS' || strtoupper($args['amb_search']) == 'bls') {
                $type = '2';    
            } else if ($args['amb_search'] == 'ALs' || strtoupper($args['amb_search']) == 'als') {
                $type = '3';
            }

            if ($args['amb_search'] == 'Available') {
                $status = '1';
            } else if ($args['amb_search'] == 'Busy') {
                $status = '2';
            } else if ($args['amb_search'] == 'Stand By') {
                $status = '3';
            } else if ($args['amb_search'] == 'Change Location') {
                $status = '4';
            } else if ($args['amb_search'] == 'Deleted / Inactive') {
                $status = '5';
            }  else if ($args['amb_search'] == 'Off Road') {
                $status = '7';
            } else if ($args['amb_search'] == 'Stand by Oxygen Filling') {
                $status = '8';
            } else if ($args['amb_search'] == 'Stand by Fuel Filling') {
                $status = '9';
            } else if ($args['amb_search'] == 'Stand by Demo Traning') {
                $status = '10';
            } else if ($args['amb_search'] == 'In Other General-Off Road') {
                $status = '11';
            } else if ($args['amb_search'] == 'On-Road') {
                $status = '12';
            } else if ($args['amb_search'] == 'In Equipment Maintenance ') {
                $status = '13';
            } 

            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";
        }
        if (isset($args['search_amb']) && $args['search_amb'] != '') {
            
            if ($args['search_amb'] == 'ALS' || $args['search_amb'] == 'als' ) {
                $type = '4';
            } else if ($args['search_amb'] == 'BLS' || $args['search_amb'] == 'bls' ) {
                $type = '3';
            } else if ($args['search_amb'] == 'PTA' || $args['search_amb'] == 'PTA (102)' || $args['search_amb'] == 'pta' ) {
                $type = '2';
            } else if ($args['search_amb'] == 'Two_wheel' || $args['search_amb'] == 'Two wheel' || $args['search_amb'] == 'Two wheeler') {
                $type = '1';
            } else if ($args['search_amb'] == 'CC' || $args['search_amb'] == 'CC') {
                $type = '5';
            } else if ($args['search_amb'] == 'AIR' || $args['search_amb'] == 'air') {
                $type = '6';
            }

            if ($args['search_amb'] == 'Available') {
                $status = '1';
            } else if($args['search_amb'] == 'Busy') {
                $status = '2';
            } else if($args['search_amb'] == 'Stand By') {
                $status = '3';
            } else if ($args['search_amb'] == 'Change Location') {
                $status = '4';
            } else if ($args['search_amb'] == 'In Maintenance On Road' || $args['search_amb'] == 'On Road') {
                $status = '6';
            } else if ($args['search_amb'] == 'In maintenance Off Road' || $args['search_amb'] == 'Off Road') {
                $status = '7';
            } else if ($args['search_amb'] == 'Stand by Oxygen Filling') {
                $status = '8';
            }
            
          

           // $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '" . trim($args['search_amb']) . "' OR amb.amb_status = '" . trim($args['search_amb']) . "')";
            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";

            
        }
        if ($args['amb_district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
            

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        // var_dump( $offlim);die();
        $order_by = "ORDER BY amb_tm.assigned_time DESC";
 $current_date = date('Y-m-d H:i:s');
        $login_date = date('Y-m-d H:i:s', strtotime('-12 hour', strtotime($current_date)));

        // $sql = "SELECT amb.*,hp.hp_name,amb_tm.timestamp FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id LEFT JOIN $this->tbl_ambulance_timestamp_record as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no where amb.ambis_deleted='0' $condition GROUP BY amb_tm.amb_rto_register_no  ORDER BY amb_tm.timestamp DESC $offlim ";
      $sql = "SELECT third_party.thirdparty_name,amb.*,app_clg.status,app_clg.vehicle_no,wrd.ward_name,dist.dst_name,hp.hp_name,max(amb_tm.assigned_time) as timestamp,dist.dst_name as dst_name 
       FROM $this->tbl_amb as amb  
       LEFT JOIN $this->tbl_amb_base_location as hp ON amb.amb_base_location = hp.hp_id 
       LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id 
       LEFT JOIN $this->tbl_inc_amb as amb_tm ON amb.amb_rto_register_no = amb_tm.amb_rto_register_no 
       LEFT JOIN $this->tbl_mas_districts as dist ON amb.amb_district = dist.dst_code 
       LEFT JOIN ems_app_login_session as app_clg ON (app_clg.vehicle_no = amb.amb_rto_register_no AND  app_clg.login_time > '$login_date')
       LEFT JOIN `ems_mas_thirdparty` as third_party ON ( third_party.thirdparty_id = amb.thirdparty )
       where  1=1 $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";
       //where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";
    //    $limit
        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_amb_data_new($args = array(), $offset = '', $limit = '') {

        // var_dump($limit);die();
    
            $condition = $offlim = '';
    
    
            if (isset($args['amb_id'])) {
    
                $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
            }
            if (isset($args['district_id'])  != '') {
    
                $condition .= "AND amb.amb_district='" . $args['district_id'] . "'";
            }
            if (isset($args['amb_base_location'])  != '') {
    
                $condition .= "AND amb.amb_base_location='" . $args['amb_base_location'] . "'";
            }
            if (isset($args['thirdparty'])  != '') {
    
                //$condition .= " AND amb.thirdparty IN ('" . $args['thirdparty'] . "') ";
            }
            
            if (isset($args['amb_supervisor'])  != '') {
    
                $condition .= " AND amb.amb_supervisor IN ('" . $args['amb_supervisor'] . "') ";
            }
    
            if (isset($args['mob_no']) && $args['mob_no'] != '') {
    
                $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
            }
    
            if (isset($args['rg_no']) && $args['rg_no'] != '' && !(is_array($args['rg_no']))) {
    
                $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
            }
            
            if (isset($args['amb_user']) && $args['amb_user'] != '' && $args['amb_user'] != 'all') {
    
                $condition .= "AND amb.amb_user='" . trim($args['amb_user']) . "'";
            }
    
            if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != '') {
    
                $condition .= "AND amb.amb_rto_register_no='" . trim($args['amb_rto_register_no']) . "'";
            }
           
            if (isset($args['amb_search']) && $args['amb_search'] != '') {
    
                if ($args['amb_search'] == 'JE' ||  strtoupper($args['amb_search']) == 'je') {
                    $type = '1';
                } else if ($args['amb_search'] == 'BLS' || strtoupper($args['amb_search']) == 'bls') {
                    $type = '2';    
                } else if ($args['amb_search'] == 'ALs' || strtoupper($args['amb_search']) == 'als') {
                    $type = '3';
                }
    
                if ($args['amb_search'] == 'Available') {
                    $status = '1';
                } else if ($args['amb_search'] == 'Busy') {
                    $status = '2';
                } else if ($args['amb_search'] == 'Stand By') {
                    $status = '3';
                } else if ($args['amb_search'] == 'Change Location') {
                    $status = '4';
                } else if ($args['amb_search'] == 'Deleted / Inactive') {
                    $status = '5';
                }  else if ($args['amb_search'] == 'Off Road') {
                    $status = '7';
                } else if ($args['amb_search'] == 'Stand by Oxygen Filling') {
                    $status = '8';
                } else if ($args['amb_search'] == 'Stand by Fuel Filling') {
                    $status = '9';
                } else if ($args['amb_search'] == 'Stand by Demo Traning') {
                    $status = '10';
                } else if ($args['amb_search'] == 'In Other General-Off Road') {
                    $status = '11';
                } else if ($args['amb_search'] == 'On-Road') {
                    $status = '12';
                } else if ($args['amb_search'] == 'In Equipment Maintenance ') {
                    $status = '13';
                } 
    
                $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";
            }
            if (isset($args['search_amb']) && $args['search_amb'] != '') {
                
                if ($args['search_amb'] == 'ALS' || $args['search_amb'] == 'als' ) {
                    $type = '4';
                } else if ($args['search_amb'] == 'BLS' || $args['search_amb'] == 'bls' ) {
                    $type = '3';
                } else if ($args['search_amb'] == 'PTA' || $args['search_amb'] == 'PTA (102)' || $args['search_amb'] == 'pta' ) {
                    $type = '2';
                } else if ($args['search_amb'] == 'Two_wheel' || $args['search_amb'] == 'Two wheel' || $args['search_amb'] == 'Two wheeler') {
                    $type = '1';
                } else if ($args['search_amb'] == 'CC' || $args['search_amb'] == 'CC') {
                    $type = '5';
                } else if ($args['search_amb'] == 'AIR' || $args['search_amb'] == 'air') {
                    $type = '6';
                }
    
                if ($args['search_amb'] == 'Available') {
                    $status = '1';
                } else if($args['search_amb'] == 'Busy') {
                    $status = '2';
                } else if($args['search_amb'] == 'Stand By') {
                    $status = '3';
                } else if ($args['search_amb'] == 'Change Location') {
                    $status = '4';
                } else if ($args['search_amb'] == 'In Maintenance On Road' || $args['search_amb'] == 'On Road') {
                    $status = '6';
                } else if ($args['search_amb'] == 'In maintenance Off Road' || $args['search_amb'] == 'Off Road') {
                    $status = '7';
                } else if ($args['search_amb'] == 'Stand by Oxygen Filling') {
                    $status = '8';
                }
                
              
    
               // $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '" . trim($args['search_amb']) . "' OR amb.amb_status = '" . trim($args['search_amb']) . "')";
                $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";
    
                
            }
            if ($args['amb_district'] != '') {
                    $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
            }
                
    
            if ($offset >= 0 && $limit > 0) {
    
                $offlim = "limit $limit offset $offset ";
            }
            // var_dump( $offlim);die();
            $order_by = "ORDER BY amb_tm.assigned_time DESC";
     $current_date = date('Y-m-d H:i:s');
            $login_date = date('Y-m-d H:i:s', strtotime('-12 hour', strtotime($current_date)));
    
            // $sql = "SELECT amb.*,hp.hp_name,amb_tm.timestamp FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id LEFT JOIN $this->tbl_ambulance_timestamp_record as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no where amb.ambis_deleted='0' $condition GROUP BY amb_tm.amb_rto_register_no  ORDER BY amb_tm.timestamp DESC $offlim ";
          $sql = "SELECT hp.hp_id,third_party.thirdparty_name,amb.*,hp.hp_address,app_clg.status,app_clg.vehicle_no,wrd.ward_name,dist.dst_name,hp.hp_name,time_stamp.start_odmeter AS start_odo,max(amb_tm.assigned_time) as timestamp,dist.dst_name as dst_name 
           FROM $this->tbl_amb as amb   
           LEFT JOIN $this->tbl_amb_base_location as hp ON amb.amb_base_location = hp.hp_id 
           LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id 
           LEFT JOIN $this->tbl_inc_amb as amb_tm ON amb.amb_rto_register_no = amb_tm.amb_rto_register_no 
           LEFT JOIN $this->tbl_mas_districts as dist ON amb.amb_district = dist.dst_code 
           LEFT JOIN ems_app_login_session as app_clg ON (app_clg.vehicle_no = amb.amb_rto_register_no AND  app_clg.login_time > '$login_date')
           LEFT JOIN `ems_mas_thirdparty` as third_party ON ( third_party.thirdparty_id = amb.thirdparty )
           LEFT JOIN ems_ambulance_timestamp_record as time_stamp ON amb.amb_rto_register_no = time_stamp.amb_rto_register_no
           where  1=1 $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";
           //where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";
        //    $limit
            $result = $this->db->query($sql);
           //echo $this->db->last_query();die;
            if ($args['get_count']) {
    
                return $result->num_rows();
            } else {
    
                return $result->result();
            }
        }

    function get_working_area($args = array()) {



        $condition = '';



        if (isset($args['amb_id'])) {

            $condition .= "AND amb_id='" . $args['amb_id'] . "'";
        }



        $sql = "SELECT dst.dst_code,dst.dst_name,wrd.ward_name,amb_st.ambs_name,offroad.mt_offroad_reason,amb_st.ambs_id,area_type.ar_name,amb.amb_id,city.cty_id,amb.amb_type,city.cty_name ,amb_tp.ambt_id,amb_tp.ambt_name,hp.hp_id,hp.hp_name,state.st_name"
            . " FROM $this->tbl_amb as amb "
            . "LEFT JOIN $this->tbl_mas_area_types as area_type  "
            . "ON (area_type.ar_id = amb.amb_working_area) "
            . "LEFT JOIN $this->tbl_mas_city as city  "
            . "ON (city.cty_id = amb.amb_city) "
            . "LEFT JOIN $this->tbl_mas_amb_type as amb_tp  "
            . "ON (amb_tp.ambt_id = amb.amb_type) "
            . "LEFT JOIN $this->tbl_mas_amb_status as amb_st  "
            . "ON (amb_st.ambs_id = amb.amb_status) "
            . "LEFT JOIN $this->tbl_mas_states as state  "
            . "ON (state.st_code = amb.amb_state) "
            . "LEFT JOIN ems_amb_onroad_offroad as offroad  "
            . "ON (offroad.mt_amb_no = amb.amb_rto_register_no) "
            . "LEFT JOIN $this->tbl_mas_districts as dst  "
            . "ON (dst.dst_code = amb.amb_district) "
            . "LEFT JOIN $this->tbl_hp as hp  "
            . "ON (hp.hp_id = amb.amb_base_location) "
            . "LEFT JOIN $this->tbl_mas_ward as wrd  "
            . "ON (wrd.ward_id = amb.ward_name) "
            . "Where ambis_deleted = '0' $condition order by offroad.mt_id DESC ";


        $result = $this->db->query($sql);

       //echo $this->db->last_query();die;

        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    ////////////////MI44////////////////////
    //

    //Purpose:delete ambulance
    //

    ////////////////////////////////////////



    function delete_amb($amb_id = array(), $status = '') {



        $this->db->where_in('amb_id', $amb_id);



        $status = $this->db->update($this->tbl_amb, $status);



        return $status;
    }

    ////////////////MI44////////////////////
    //

    //Purpose:Update ambulance
    //

    /////////////////////////////////////



    function update_amb($args = array()) {


        if ($args['amb_id']) {

            $this->db->where('amb_id', $args['amb_id']);
        }

        if ($args['amb_rto_register_no']) {

            $this->db->where('amb_rto_register_no', $args['amb_rto_register_no']);
        }

        $update = $this->db->update($this->tbl_amb, $args);


        if ($update) {

            return true;
        } else {

            return false;
        }
    }

    ////////////LOGOUT Pilot and EMT////////////////

    function logout_emt_pilot($args = array()) {

            $data['status'] = '2';
            $data['logout_time'] = date('Y-m-d H:i:s');
            $data['log_remark'] = 'Offroad By Web';

        if ($args['vehicle_no'] != '') {
            $this->db->where('vehicle_no', $args['vehicle_no']);
            $this->db->where('status','1');
            $update = $this->db->update('ems_app_login_session', $data);
        }

        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////////////////////////

    ////////////////MI44////////////////////
    //

    //Purpose:Update ambulance lat,lng
    //

    /////////////////////////////////////



    function update_amb_ln($args = array()) {



        if ($args['amb_rto_register_no'] != "") {



            $amb_reg_no = strtolower(str_replace('-', '', str_replace(' ', '', trim($args['amb_rto_register_no']))));



            //$sql = "UPDATE $this->tbl_amb SET `amb_lat`='" . $args['gps_amb_lat'] . "',`amb_log`='" . $args['gps_amb_log'] . "' WHERE  '" . $amb_reg_no . "' LIKE CONCAT(LOWER(REPLACE(REPLACE(TRIM(`amb_rto_register_no`), ' ', ''), '-', '')), '%')";

             $sql = "UPDATE $this->tbl_amb SET  `gps_date_time`='" . $args['gps_date_time'] . "',`amb_Ignition_status`='" . $args['amb_Ignition_status'] . "',`amb_speed`='" . $args['amb_speed'] . "',`amb_lat`='" . $args['amb_lat'] . "',`amb_log`='" . $args['amb_log'] . "' ,`gps_amb_lat`='" . $args['gps_amb_lat'] . "',`gps_amb_log`='" . $args['gps_amb_log'] . "' WHERE  '" . $amb_reg_no . "' LIKE CONCAT(LOWER(REPLACE(REPLACE(TRIM(`amb_rto_register_no`), ' ', ''), '-', '')), '%')";
         
             //$sql = "UPDATE $this->tbl_amb SET  `amb_Ignition_status`='" . $args['amb_Ignition_status'] . "',`amb_speed`='" . $args['amb_speed'] . "',`amb_lat`='" . $args['amb_lat'] . "',`amb_log`='" . $args['amb_log'] . "',`gps_amb_lat`='" . $args['gps_amb_lat'] . "',`gps_amb_log`='" . $args['gps_amb_log'] . "' WHERE  amb_rto_register_no  ='" . $args['amb_rto_register_no'] ."'";
            //echo $sql;die();




            $result = $this->db->query($sql);



            if ($result) {

                return true;
            } else {

                return false;
            }
        }
    }

        function update_amb_hpcl($args = array()) {



        if ($args['amb_rto_register_no'] != "") {



            $amb_reg_no = strtolower(str_replace('-', '', str_replace(' ', '', trim($args['amb_rto_register_no']))));



            $sql = "UPDATE $this->tbl_amb SET `card`='" . $args['card'] . "',`vendor`='" . $args['vendor'] . "' WHERE  '" . $amb_reg_no . "' LIKE CONCAT(LOWER(REPLACE(REPLACE(TRIM(`amb_rto_register_no`), ' ', ''), '-', '')), '%')";

        
      
            $result = $this->db->query($sql);



            if ($result) {

                return true;
            } else {

                return false;
            }
        }
    }
    ////////////////MI44////////////////////
    //

    //Purpose: Manage team am list action
    //

    /////////////////////////////////////



    function insert_manage_team($pilot, $manage_date, $rto_no, $tm_shift) {
        $rto_no != '';


        //for ($i = 0; $i < count($pilot); $i++) {

            $sql = '';
            //if ($pilot[$i] != '' && $emt[$i] != '') {
                $sql .= "insert into $this->tbl_default_team (`tm_amb_rto_reg_id`, `tm_shift`,`tm_pilot_id`,`tm_emt_id`,`tm_team_date`,`tmis_deleted`) values ('$rto_no','$tm_shift','$pilot','$emt','$manage_date','0')";
            //}

            $result = $this->db->query($sql);
        //}  

        if ($result) {

            return $result;
        } else {

            return false;
        }
    }
    
    function insert_excel_manage_team($args) {
        
        $rto_no = $args['tm_amb_rto_reg_id'];
        $tm_shift = $args['tm_shift'];
        $tm_team_date = $args['tm_team_date'];
        $tm_pilot_id = $args['tm_pilot_id'];
        $tm_emt_id= $args['tm_pilot_id'];
 
        $sql .= "insert into $this->tbl_default_team (`tm_amb_rto_reg_id`, `tm_shift`,`tm_pilot_id`,`tm_emt_id`,`tm_team_date`,`tmis_deleted`) values ('$rto_no','$tm_shift','$tm_pilot_id','$tm_emt_id','$tm_team_date','0')";


    $result = $this->db->query($sql);
        

        if ($result) {

            return $result;
        } else {

            return false;
        }
    }

    function get_manage_team($args) {

        if (isset($args['rto_no']) && $args['rto_no'] != '') {
            $condition .= "AND amb_team.tm_amb_rto_reg_id='" . $args['rto_no'] . "'";
        }


        $sql = "SELECT amb_team.* FROM $this->tbl_default_team as amb_team where amb_team.tmis_deleted='0' $condition  ";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_clg_by_refid($args = array()) {

        if ($args['clg_ref_id']) {
            $condition = " AND clg.clg_ref_id='" . $args['clg_ref_id'] . "' ";
        }

        $result = $this->db->query("SELECT clg.clg_ref_id,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name FROM $this->tbl_colleague as clg WHERE clg_is_deleted='0' $condition");
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    /* MI13 == get ambulance in incident area */

    function get_am_in_inc_area($lat, $lng) {





//            $sql = "SELECT amb.amb_id,amb.amb_type,amb.amb_rto_register_no,amb.amb_lat,amb.amb_log,amb.amb_default_mobile,hp.hp_id,hp.hp_name"
//               .", ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( amb.amb_lat ) ) * cos( radians( amb.amb_log ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( amb.amb_lat ) ) ) ) AS distance"
//               . " FROM $this->tbl_amb as amb "
//               . " LEFT JOIN $this->tbl_ambulance_base as amb_bs"
//               . " ON (amb.amb_rto_register_no = amb_bs.amb_rto_register_no)"
//               . " LEFT JOIN $this->tbl_hp as hp  "
//               . " ON (hp.hp_id = amb_bs.hp_id) "
//               . " Where ambis_deleted = '0' AND amb_status ='1'"
//               . " HAVING distance < 5 ORDER BY distance";  



        $sql = "SELECT amb.amb_id, amb.amb_type, amb.amb_rto_register_no, amb.amb_lat, amb.amb_log, amb.amb_default_mobile, hp.hp_id, hp.hp_name"
            . ", ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( amb.amb_lat ) ) * cos( radians( amb.amb_log ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( amb.amb_lat ) ) ) ) AS distance"
            . " FROM ems_ambulance AS amb"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " WHERE ambis_deleted = '0'"
            . " AND amb_status = '1'"
            . " HAVING distance < 5 ORDER BY distance";



//           $sql =   "SELECT amb.amb_id, amb.amb_type, amb.amb_rto_register_no, amb.amb_lat, amb.amb_log, amb.amb_default_mobile, hp.hp_id, hp.hp_name,tm.tm_id,tm.tm_pilot_id,tm.tm_emt_id,am_sc.*"
//                    .", ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( amb.amb_lat ) ) * cos( radians( amb.amb_log ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( amb.amb_lat ) ) ) ) AS distance"
//                    ." FROM ems_ambulance AS amb"
//                    ." LEFT JOIN ems_hospital AS hp ON ( hp.hp_id = amb.amb_base_location )"
//                    ." LEFT JOIN ems_ambulance_schedule AS am_sc ON ( am_sc.scd_amb_rto_reg_id = amb.amb_rto_register_no )"
//                    ." LEFT JOIN ems_amb_default_team AS tm ON ( tm.tm_amb_rto_reg_id = amb.amb_rto_register_no )"
//                    ." WHERE ambis_deleted = '0'"
//                    ." AND amb_status = '1'"
//                    ." AND am_sc.scd_amb_shift = $sht "
//                    ." HAVING distance < 5 ORDER BY distance";









        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    ////////////MI44////
    //

    //Purpose :Insert amb and check register id is exit or not
    ///////////////////////
//     function check_amb_reg($args=array()) {
//         
//        $this->db->select('*');
//
//		$this->db->from("$this->tbl_amb as amb");
//        
//        $this->db->where("amb.amb_rto_register_no ='".$args['amb_rto_register_no']."'");
//
//        $fetched = $this->db->get();
//
//		$present = $fetched->result();          
//                
//        if(count($present)==0){
//           
//            $result = $this->db->insert($this->tbl_amb,$args);
//            
//            if($result){
//                return $result;
//            }else{
//                return false;
//            }  
//
//        }else{
//
//            return "duplicate_register_no";
//
//        }
//
//    }





    function check_reg_no($args = array()) {



        $this->db->select('*');



        $this->db->from("$this->tbl_amb as amb");



        $this->db->where("amb.amb_rto_register_no ='" . $args['amb_rto_register_no'] . "'");



        $fetched = $this->db->get();



        $present = $fetched->result();



        if (count($present) == 0) {

            return true;
        } else {

            return false;
        }
    }

    function insert_amb_timestamp_record($args = array()) {
        $clg = $this->session->userdata('current_user');
        $args['added_by'] =$clg->clg_ref_id;

        $this->db->select('*');
        $this->db->from("$this->tbl_ambulance_timestamp_record");
        $this->db->where("$this->tbl_ambulance_timestamp_record.inc_ref_id", $args['inc_ref_id']);
        $this->db->where("$this->tbl_ambulance_timestamp_record.odometer_type", 'closure');
        
        $this->db->where("$this->tbl_ambulance_timestamp_record.flag", '1');
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {
            $result = $this->db->insert($this->tbl_ambulance_timestamp_record, $args);
            
            //echo $this->db->last_query();die;
            if ($result) {

                return $result;
            } else {

                return false;
            }
        }else {
            $this->db->where("id", $present[0]->id);
            $res = $this->db->update($this->tbl_ambulance_timestamp_record, $args);
            // if($args['operate_by'] == 'dco-40'){
            //echo $this->db->last_query();die;
            // }
            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }

        /*$result = $this->db->insert($this->tbl_ambulance_timestamp_record, $args);

        if ($result) {

            return $result;
        } else {

            return false;
        }*/
    }

    function get_amb_by_id($args = array()) {
        $amb_id = $args['amb_id'];

        $sql = "Select amb_rto_register_no From $this->tbl_amb WHERE amb_id = $amb_id";


        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    
    function update_amb_timestamp_record($args = array()) {
        if ($args['amb_rto_register_no']) {
  
            $this->db->where('amb_rto_register_no', $args['amb_rto_register_no']);


            $update = $this->db->update($this->tbl_ambulance_timestamp_record , $args);
            

            if ($update) {

               return true;
            } else {

              return false;
            }
        }
  
        }

    function insert_timestamp_record($args = array()) {
        $clg = $this->session->userdata('current_user');
        $args['added_by'] =$clg->clg_ref_id;

        $this->db->select('*');
        $this->db->from("$this->tbl_ambulance_timestamp_record");
        $this->db->where("$this->tbl_ambulance_timestamp_record.inc_ref_id", $args['inc_ref_id']);
        $this->db->where("$this->tbl_ambulance_timestamp_record.odometer_type",$args['odometer_type']);
        
        $this->db->where("$this->tbl_ambulance_timestamp_record.flag", '1');
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {
            $result = $this->db->insert($this->tbl_ambulance_timestamp_record, $args);
            
//echo $this->db->last_query();die;
            if ($result) {

                return $result;
            } else {

                return false;
            }
        }else {
            $this->db->where("id", $present[0]->id);
            $res = $this->db->update($this->tbl_ambulance_timestamp_record, $args);
            // if($args['operate_by'] == 'dco-40'){
            //echo $this->db->last_query();die;
            // }
            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }

        /*$result = $this->db->insert($this->tbl_ambulance_timestamp_record, $args);

        if ($result) {

            return $result;
        } else {

            return false;
        }*/
    }

    function get_amb_odometer_by_inc($args = array()) {


        //$sql = "Select * From $this->tbl_ambulance_timestamp_record as tm_re Where  tm_re.odometer_type  IN ('fuel_filling_during_case','oxygen_filling_during_case') AND tm_re.inc_ref_id ='" . $args['inc_ref_id'] . "'";
        
        $sql = "Select * From $this->tbl_ambulance_timestamp_record as tm_re Where  tm_re.odometer_type  IN ('closure','get_amb_odometer_by_inc') AND tm_re.inc_ref_id ='" . $args['inc_ref_id'] . "'";


        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function get_amb_odometer_by_inc_amb_no($args = array()) {


        $sql = "Select * From $this->tbl_ambulance_timestamp_record as tm_re Where flag = '1' AND tm_re.inc_ref_id ='" . $args['inc_ref_id'] . "' AND  tm_re.amb_rto_register_no ='" . $args['amb_rto_register_no'] . "'";

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function insert_amb($args = array()) {



        $result = $this->db->insert($this->tbl_amb, $args);
                // echo $this->db->last_query(); die;

        
        if ($result) {

            return $result;
        } else {

            return false;
        }
    }
    function insert_update_amb_summary($args = array()) {



        $result = $this->db->insert('ems_ambulance_change_status_summary', $args);
        
        if ($result) {

            return $result;
        } else {

            return false;
        }
    }
    function update_odometer_amb( $odometer_amb = array(), $odometer = array() ) {
        

        if ($odometer['inc_ref_id']) {
  
            $this->db->where('inc_ref_id', $odometer['inc_ref_id']);


            $update = $this->db->update($this->tbl_epcr , $odometer_amb);


            if ($update) {

               return true;
            } else {

              return false;
            }
        }
  
      }
      function update_timestamp_odometer_amb_new($update_timestamp_record = array(), $amb_no= array()){
        if ($amb_no['amb_no']) {

            $this->db->where('amb_rto_register_no', $amb_no['amb_no']);
             $update = $this->db->update( $this->tbl_ambulance_timestamp_record ,$update_timestamp_record);
             
        if ($update) {

             return true;
        } else {

          return false;
        }
        }

      }
      function update_timestamp_odometer_amb($timestamp_odometer_amb = array(), $timestamp= array()) {



        if ($timestamp['insident_no']) {

            $this->db->where('inc_ref_id', $timestamp['insident_no']);
             $update = $this->db->update( $this->tbl_ambulance_timestamp_record ,$timestamp_odometer_amb);
             
        if ($update) {

             return true;
        } else {

          return false;
        }
        }

    }

    function update_driver_pcr_odometer ( $pcr_odometer = array(), $pcr= array()) {
 
        if ($pcr['insident_no']) {

            $this->db->where('inc_ref_id', $pcr['insident_no']);
       
            $update = $this->db->update( $this->tbl_driver_pcr , $pcr_odometer);
          //  echo $this->db->last_query();
            if ($update) {

                 return true;
            } else {

              return false;
            }
        }

    }

    function insert_amb_odometer($args = array()) {

        $result = $this->db->insert($this->tbl_odometer_detail, $args);

        if ($result) {

            return $result;
        } else {

            return false;
        }
    }

    function get_amb_working_area($args = array()) {



        $condition = '';



        if (isset($args['amb_id'])) {

            $condition .= "AND amb_id='" . $args['amb_id'] . "'";
        }



        $sql = "SELECT DISTINCT dst.dst_code,dst.dst_name,city.cty_id,city.cty_name ,state.st_name"
            . " FROM $this->tbl_amb as amb "
            . "LEFT JOIN $this->tbl_mas_area_types as area_type  "
            . "ON (area_type.ar_id = amb.amb_working_area) "
            . "LEFT JOIN $this->tbl_mas_city as city  "
            . "ON (city.cty_id = amb.amb_city) "
            . "LEFT JOIN $this->tbl_mas_amb_type as amb_tp  "
            . "ON (amb_tp.ambt_id = amb.amb_type) "
            . "LEFT JOIN $this->tbl_mas_amb_status as amb_st  "
            . "ON (amb_st.ambs_id = amb.amb_status) "
            . "LEFT JOIN $this->tbl_mas_states as state  "
            . "ON (state.st_code = amb.amb_state) "
            . "LEFT JOIN $this->tbl_mas_districts as dst  "
            . "ON (dst.dst_code = amb.amb_district) "
            . "LEFT JOIN $this->tbl_hp as hp  "
            . "ON (hp.hp_id = amb.amb_base_location) "
            . "Where ambis_deleted = '0' $condition";


        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_amb_odometer_fuel($args) {

        if (isset($args['rto_no']) && $args['rto_no'] != '') {
            $condition .= " AND amb_time.amb_rto_register_no='" . $args['rto_no'] . "'";
        }

        if ($args['odometer_type'] != '') {
            //$condition .= " AND amb_time.odometer_type='" . $args['odometer_type'] . "'";
        }

        //$sql = "SELECT amb_time.* FROM $this->tbl_ambulance_timestamp_record as amb_time $condition  ORDER BY amb_time.end_odmeter DESC Limit 0, 1";
         $sql = "SELECT amb_time.*,max(end_odmeter*1) as end_odmeter 
         FROM $this->tbl_ambulance_timestamp_record as amb_time Where   
          flag = '1' $condition ORDER BY amb_time.end_odmeter DESC,amb_time.timestamp DESC Limit 0, 1";
       
     
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_amb_district($args){
        if (isset($args['amb_id']) && $args['amb_id'] != '') {
            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_id'] . "'";
        }
         $sql = "SELECT amb.*
        FROM $this->tbl_amb as amb
        where 1=1 $condition ";

        //echo $sql;
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_amb_odometer($args) {

        if (isset($args['rto_no']) && $args['rto_no'] != '') {
            $condition .= " AND amb_time.amb_rto_register_no='" . $args['rto_no'] . "'";
        }


        //$sql = "SELECT amb_time.* FROM $this->tbl_ambulance_timestamp_record as amb_time $condition  ORDER BY amb_time.end_odmeter DESC Limit 0, 1";
       // $sql = "SELECT amb_time.* FROM $this->tbl_ambulance_timestamp_record as amb_time $condition  ORDER BY amb_time.timestamp DESC  Limit 0, 1";
         $sql = "SELECT max(end_odmeter*1) as end_odmeter FROM $this->tbl_ambulance_timestamp_record as amb_time where flag = '1' AND  amb_time.odometer_type != 'fuel_filling_during_case' AND amb_time.odometer_type != 'oxygen_filling_during_case' $condition  ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC Limit 0, 1";
    //$sql = "SELECT max(end_odmeter*1) as end_odmeter FROM $this->tbl_ambulance_timestamp_record as amb_time where flag = '1' $condition  ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC Limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_amb_odometer_closure($args = array()) {

        if (isset($args['rto_no']) && $args['rto_no'] != '') {
            $condition .= " AND amb_time.amb_rto_register_no='" . $args['rto_no'] . "'";
        }


        //$sql = "SELECT amb_time.* FROM $this->tbl_ambulance_timestamp_record as amb_time $condition  ORDER BY amb_time.end_odmeter DESC Limit 0, 1";
       // $sql = "SELECT amb_time.* FROM $this->tbl_ambulance_timestamp_record as amb_time $condition  ORDER BY amb_time.timestamp DESC  Limit 0, 1";
       //  $sql = "SELECT max(end_odmeter*1) as end_odmeter FROM $this->tbl_ambulance_timestamp_record as amb_time where flag = '1' AND  amb_time.odometer_type IN ('closure','Chng_closure_inc','Chng_new_fitted_odometer') $condition  ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC Limit 0, 1";
         
            //$sql = "SELECT max(end_odmeter*1) as end_odmeter FROM $this->tbl_ambulance_timestamp_record as amb_time where flag = '1'  AND  amb_time.odometer_type NOT IN ('fuel_filling_during_case','oxygen_filling_during_case') $condition  ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC Limit 0, 1";
        $sql = "SELECT max(end_odmeter*1) as end_odmeter FROM $this->tbl_ambulance_timestamp_record as amb_time where flag = '1'  AND  amb_time.odometer_type IN ('closure','Chng_new_fitted_odometer','update tyre maintaince','tyre maintenance','update onroad offroad maintaince','onroad_offroad maintenance','update accidental maintaince','accidental maintenance','Scrape Vahicle Update','Scrape Vahicle','update preventive maintenance','preventive maintenance','Manpower Update','Manpower','update breakdown maintaince','breakdown maintenance') $condition  ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC Limit 0, 1";  
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_update_status_amb(){
        $sql = "SELECT * FROM ems_mas_amb_petrol_card ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function update_amb_by_reg_pet($args = array()) {
        $upadate_amb_data = array('card' => $args['card'] ,'vendor' => $args['vendor']);
        if ($args['amb_rto_register_no']) {
            $condition .= "(amb_rto_register_no LIKE '%" . trim($args['amb_rto_register_no']) . "%')";
            $this->db->where($condition);
            $update = $this->db->update($this->tbl_amb, $upadate_amb_data);
            // echo $this->db->last_query();
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function get_amb_to_update_status() {


        $sql = "SELECT amb.amb_id, amb.amb_rto_register_no,MAX(in_am.assigned_time)
                FROM ems_ambulance AS amb 
                LEFT JOIN ems_incidence_ambulance AS in_am ON ( in_am.amb_rto_register_no = amb.amb_rto_register_no )
                WHERE amb.ambis_deleted = '0' AND amb.amb_status = '2' GROUP BY amb.amb_rto_register_no ORDER BY in_am.assigned_time DESC";
          
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_stock_information($args = array(), $offset = '', $limit = '') {


        if ($args['start_date'] != '' && $args['end_date'] != '') {
            $Stock_id = $args['inv_id'];
            $from = $args['start_date'];
            $to = $args['end_date'];
            $date_format = '%m/%d/%Y';
            $condition .= " stk.as_item_id='" . $args['inv_id'] . "' AND (stk.as_date BETWEEN '$from' AND '$to 23:59:59')";
        }


        $sql = "SELECT stk.as_item_id,COUNT(stk.as_item_qty) as total_qty FROM $this->tbl_ambulance_stock as stk where $condition GROUP BY stk.as_item_id";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_patient_information($args = array(), $offset = '', $limit = '') {

        if ($args['start_date'] != '' && $args['end_date'] != '') {

            $Stock_id = $args['clg_emso_id'];
            $from = $args['start_date'];
            $to = $args['end_date'];
            $date_format = '%m/%d/%Y';
            $condition .= " epcr.emso_id='" . $args['clg_ref_id'] . "' AND (epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59')";
        }

        $sql = "SELECT count(epcr.emso_id) as patient_count FROM $this->tbl_epcr as epcr where $condition";
        


        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_emt_district($args = array(), $offset = '', $limit = '') {

        if ($args['start_date'] != '' && $args['end_date'] != '') {

            $Stock_id = $args['clg_emso_id'];
            $from = $args['start_date'];
            $to = $args['end_date'];
            $date_format = '%m/%d/%Y';
            $condition .= " epcr.emso_id='" . $args['clg_ref_id'] . "' AND (epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59')";
        }

        $sql = "select dist.dst_name"
        ." from $this->tbl_epcr as epcr"
        . " LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = epcr.amb_reg_id )"
        . " LEFT JOIN $this->tbl_mas_districts AS dist ON (dist.dst_code = amb.amb_district )"
        ." where $condition";

        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_remark($args = array(), $offset = '', $limit = '') {
        $remark_id = $args['remark_id'];
        $sql = "SELECT remark.remark FROM $this->tbl_mas_odometer_remark as remark where remark_id=$remark_id";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_emso_count() {
        $sql = "select  Count(clg_emt.clg_first_name) as total_count from  $this->tbl_colleague as clg_emt where clg_emt.clg_group='UG-EMT'";
        //$sql = "SELECT ems_patient.*,inc.inc_ref_id,inc.inc_datetime,inc.inc_address,ems_epcr.rec_hospital_name,ems_epcr.id as epcr_id,clr.clr_fullname,clr.clr_mobile FROM ems_incidence_patient Left JOIN ems_epcr ON ems_epcr.ptn_id = ems_incidence_patient.ptn_id LEFT JOIN ems_patient ON ems_patient.ptn_id = ems_incidence_patient.ptn_id LEFT JOIN ems_incidence as inc ON inc.inc_ref_id =ems_epcr.inc_ref_id LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  ) LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  ) WHERE inc.incis_deleted = '0' AND ems_patient.ptnis_deleted = '0' $condition";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function insert_amb_staus_summary($args = array()) {

        $result = $this->db->insert($this->tbl_ambulance_status_summary, $args);

        if ($result) {

            return $result;
        } else {

            return false;
        }
    }

    function update_amb_staus_summary($amb_update_summary = array()) {

        $this->db->where('amb_rto_register_no', $amb_update_summary['amb_rto_register_no']);
        $this->db->where('end_odometer', '');
        $this->db->where('on_road_status', '');
        $this->db->where('off_road_status', 'Ambulance off road');

        $status = $this->db->update($this->tbl_ambulance_status_summary, $amb_update_summary);
        //echo $this->db->last_query();
        return $status;
    }

    function get_amb_staus_summary($args = array()) {
        $condition = $offlim = '';

        if (isset($args['amb_rto_register_no'])) {

            $condition .= " amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }
        $sql = "SELECT amb.*,odo.* FROM $this->tbl_ambulance_status_summary as amb LEFT JOIN ems_mas_odometer_remark as odo ON(odo.remark_id = amb.on_road_remark) where $condition ";

//        echo $sql;
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_amb_status_list($args = array()) {

        if (isset($args['ambs_id'])) {
            if (is_array($args['ambs_id'])) {
                $amb_ids = implode("','", $args['ambs_id']);
            } else {
                $amb_ids = $args['ambs_id'];
            }
            $condition .= "AND amb_st.ambs_id IN ('" . $amb_ids . "')";
        }
        if (isset($args['ambs_id_not'])) {

            $condition .= "AND amb_st.ambs_id NOT IN ('" . $args['ambs_id_not'] . "')";
        }


        $sql = "SELECT amb_st.* FROM $this->tbl_mas_amb_status as amb_st WHERE amb_st.ambsis_deleted='0' $condition";



        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function update_amb_emos_staus_summary($amb_update_summary = array()) {

        $this->db->where('amb_rto_register_no', $amb_update_summary['amb_rto_register_no']);
        $this->db->where('off_road_status', 'EMSO Not Available');
        $this->db->order_by("id", "desc");
        $this->db->limit('1');

        $status = $this->db->update($this->tbl_ambulance_status_summary, $amb_update_summary);
        // echo $this->db->last_query();
        return $status;
    }

    function get_amb_base_location($args = array(), $offset = '', $limit = '') {
        $condition = $offlim = '';
        if (isset($args['rg_no'])) {

            $condition .= "AND amb.amb_rto_register_no='" . $args['rg_no'] . "'";
        }
        //$sql = "SELECT amb.*,hp.hp_name FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id where amb.ambis_deleted='0' $condition ";
        $sql = "SELECT amb.*,hp.hp_name,hp.hp_id,wrd.ward_name
        FROM $this->tbl_amb as amb 
        LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id 
        LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id
        where amb.ambis_deleted='0' $condition ";

        //echo $sql;
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_amb_disctrict($args = array(), $offset = '', $limit = '') {
        $condition = $offlim = '';
        if (isset($args['amb_district'])) {

            $condition .= "disct.dst_code='" . $args['amb_district'] . "'";
        }
        $sql = "SELECT disct.dst_name FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_mas_districts as disct ON amb.amb_district = disct.dst_code where  $condition ";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_amb_type1($args = array(), $offset = '', $limit = '') {
        $condition = $offlim = '';
        if (isset($args['amb_type'])) {

            $condition .= "ambt.ambt_id='" . $args['amb_type'] . "'";
        }
        $sql = "SELECT ambt.ambt_name FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_mas_amb_type as ambt ON amb.amb_type = ambt.ambt_id where  $condition ";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_ambstk($args = array(), $offset = '', $limit = '') {
        $ambulance_no = $args['rg_no'];

        if ($args['start_date'] != '' && $args['end_date'] != '') {
            $Stock_id = $args['inv_id'];
            $from = $args['start_date'];
            $to = $args['end_date'];
            $date_format = '%m/%d/%Y';

            $condition .= " AND stk.as_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT Count(stk.as_item_qty) as total_qty,invmd.med_title,inv.inv_title,stk.as_date FROM $this->tbl_amb as amb 
		LEFT JOIN $this->tbl_epcr as epcr ON epcr.amb_reg_id = amb.amb_rto_register_no
		LEFT JOIN $this->tbl_ambulance_stock as stk ON stk.as_sub_id = epcr.id
        LEFT JOIN $this->tbl_inv as inv ON inv.inv_id = stk.as_item_id
        LEFT JOIN $this->tbl_invmd as invmd ON invmd.med_id = stk.as_item_id
		where amb.ambis_deleted='0' and  amb.amb_rto_register_no='$ambulance_no' $condition  GROUP BY stk.as_sub_id";


        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
        function get_ambstk_case($args = array(), $offset = '', $limit = '') {
        $ambulance_no = $args['rg_no'];

        if ($args['start_date'] != '' && $args['end_date'] != '') {
            $Stock_id = $args['inv_id'];
            $from = $args['start_date'];
            $to = $args['end_date'];
            $date_format = '%m/%d/%Y';

            //$condition .= " AND stk.as_date BETWEEN '$from' AND '$to 23:59:59'";
            $condition .= " AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
         if (isset($args['amb_user_type'])) {

            $condition .= "amb.amb_user_type='" . $args['amb_user_type'] . "'";
        }

//          $sql = "SELECT Count(stk.as_item_qty) as total_qty,invmd.med_title,inv.inv_title,stk.as_date,stk.as_item_type,invint.int_name,invinj.inj_name,epcr.amb_reg_id,epcr.district_id,epcr.inc_ref_id  FROM $this->tbl_epcr as epcr 
//        LEFT JOIN $this->tbl_ambulance_stock as stk ON stk.as_sub_id = epcr.id     
//		LEFT JOIN $this->tbl_amb as amb ON (epcr.amb_reg_id = amb.amb_rto_register_no AND amb.amb_user_type ='108')
//        LEFT JOIN $this->tbl_inv as inv ON ( inv.inv_id = stk.as_item_id AND stk.as_item_type=inv.inv_type)
//        LEFT JOIN $this->tbl_invmd as invmd ON (invmd.med_id = stk.as_item_id AND stk.as_item_type=invmd.med_types)
//        LEFT JOIN ems_mas_intervention as invint ON (invint.int_id = stk.as_item_id AND stk.as_item_type=invint.int_type)
//          LEFT JOIN ems_mas_injury as invinj ON (invinj.inj_id = stk.as_item_id AND stk.as_item_type=invinj.inj_type)
//		where epcr.epcris_deleted='0'  $condition  GROUP BY stk.as_sub_id,stk.as_item_id ";
        
                  $sql = "SELECT Count(stk.as_item_qty) as total_qty,invmd.med_title,inv.inv_title,stk.as_date,stk.as_item_type,epcr.amb_reg_id,epcr.district_id,epcr.inc_ref_id  FROM $this->tbl_epcr as epcr 
        LEFT JOIN $this->tbl_ambulance_stock as stk ON stk.as_sub_id = epcr.id     
		LEFT JOIN $this->tbl_amb as amb ON (epcr.amb_reg_id = amb.amb_rto_register_no AND amb.amb_user_type ='108')
        LEFT JOIN $this->tbl_inv as inv ON ( inv.inv_id = stk.as_item_id AND stk.as_item_type=inv.inv_type)
        LEFT JOIN $this->tbl_invmd as invmd ON (invmd.med_id = stk.as_item_id AND stk.as_item_type=invmd.med_types)
      
         
		where epcr.epcris_deleted='0' AND stk.as_stk_in_out='out' AND stk.as_item_type NOT IN ('INJ','INT') $condition  GROUP BY stk.as_sub_id,stk.as_item_id ";


//echo $sql;
//die();
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }


    function get_tdd_total_amb($args = array()) {

        $condition = "";
        if (isset($args['cluster_id'])) {
            $condition .= " AND amb.cluster_id IN (" . $args['cluster_id'] . ")";
        }
        if (isset($args['amb_status'])) {
            $condition .= " AND amb.amb_status IN (" . $args['amb_status'] . ")";
        }

        $sql = "SELECT amb.* FROM $this->tbl_amb as amb where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no ";

        $result = $this->db->query($sql);

        return $result->num_rows();
    }

    function get_tdd_amb($args = array()) {
         // var_dump($args);die;
        if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND amb.amb_user = '" . $args['system'] . "'";
        }

        $sql = "SELECT amb.*,hp.hp_name FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no ";
//        echo $sql;
//        die();
        $result = $this->db->query($sql);

        return $result->result();
    }


    
    // function get_busy_amb_data($args = array(), $offset = '', $limit = '') {

    //     $condition = $offlim = '';

    //     if (isset($args['dist_search'])) {

    //         $condition .= "AND inc.inc_district_id='" . $args['dist_search'] . "'";
    //     }


    //     if (isset($args['amb_id'])) {

    //         $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
    //     }


    //     if (isset($args['amb_status'])) {

    //         $condition .= "AND amb.amb_status IN ('" . $args['amb_status'] . "')";
    //     }



    //     if (isset($args['mob_no']) && $args['mob_no'] != '') {

    //         $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
    //     }
    //     if (isset($args['amb_user_type']) && $args['amb_user_type'] != '') {

    //         $condition .= "AND amb.amb_user_type='" . $args['amb_user_type'] . "' ";

    //         $order_by = "ORDER BY amb.amb_rto_register_no ASC";
    //     }



    //     if (isset($args['rg_no']) && $args['rg_no'] != '') {

    //         $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
    //     }

    //     if (isset($args['amb_search']) && $args['amb_search'] != '') {

    //          if ($args['amb_search'] == 'ALS' ||  strtoupper($args['amb_search']) == 'ALS') {
    //             $type = '4';
    //         } else if ($args['amb_search'] == 'BLS' || strtoupper($args['amb_search']) == 'BLS') {
    //             $type = '3';
    //         } else if ($args['amb_search'] == 'PTA' || $args['amb_search'] == 'PTA (102)' || strtoupper($args['amb_search']) == 'PTA') {
    //             $type = '2';
    //         } else if ($args['amb_search'] == 'Two_wheel' || $args['amb_search'] == 'Two wheel' || $args['amb_search'] == 'Two wheeler') {
    //             $type = '1';
    //         } else if ($args['amb_search'] == 'CC' || strtoupper($args['amb_search']) == 'CC') {
    //             $type = '5';
    //         } else if ($args['amb_search'] == 'AIR' || strtoupper($args['amb_search']) == 'AIR') {
    //             $type = '6';
    //         }

    //         if ($args['amb_search'] == 'Available') {
    //             $status = '1';
    //         } else if ($args['amb_search'] == 'Busy') {
    //             $status = '2';
    //         } else if ($args['amb_search'] == 'In-Return' || $args['amb_search'] == 'Return') {
    //             $status = '3';
    //         } else if ($args['amb_search'] == 'In-Maintenance' || $args['amb_search'] == 'Maintenance') {
    //             $status = '4';
    //         } else if ($args['amb_search'] == 'Stand By') {
    //             $status = '6';
    //         } else if ($args['amb_search'] == 'In maintenance-OFF Road' || $args['amb_search'] == 'OFF Road') {
    //             $status = '7';
    //         } else if ($args['amb_search'] == 'In maintenance On Road' || $args['amb_search'] == 'On Road') {
    //             $status = '8';
    //         } else if ($args['amb_search'] == 'EMSO Not Available') {
    //             $status = '9';
    //         }
    //        // GROUP BY
    //         $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status'OR inc.inc_ref_id LIKE '%" . trim($args['amb_search']) . "%')";
    //     }
       
    //     if ($args['amb_district'] != '') {
    //         $condition .= "AND amb.amb_district='" . $args['amb_district'] . "' ";
    //        //  $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
    //     }

    //     if ($args['amb_no_search'] != '') {
          
    //         $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search'] . "' ";
          
    //     }

    //     if ($offset >= 0 && $limit > 0) {

    //         $offlim = "limit $limit offset $offset ";
    //     }

        
    //     $order_by = "ORDER BY inc.inc_datetime ASC";

    //     $sql = "SELECT *,cmp_type.ct_type,max(inc_amb.assigned_time) as timestamp  FROM ems_incidence AS inc LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id ) LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id ) LEFT JOIN $this->tbl_inc_amb AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id ) LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )  LEFT JOIN   $this->tbl_mas_districts AS dist ON (dist.dst_code = inc.inc_district_id ) LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_ambulance_type as amb_type ON (amb_type.ambt_id = amb.amb_type) LEFT JOIN ems_mas_ambulance_status as amb_status ON (amb_status.ambs_id = amb.amb_status) LEFT JOIN $this->tbl_mas_patient_complaint_types as cmp_type ON (cmp_type.ct_id = inc.inc_complaint) where amb.ambis_deleted='0' AND inc.inc_pcr_status = '0'  $condition  GROUP BY amb.amb_rto_register_no"
    //         . "   $order_by  $offlim ";

    //     $result = $this->db->query($sql);
    //     //  echo $this->db->last_query(); die;
    //     if ($args['get_count']) {

    //         return $result->num_rows();
    //     } else {

    //         return $result->result();
    //     }
    // }


    // get_busy_amb_data_popup
    function get_busy_amb_data_popup($args = array(), $offset = '', $limit = '') {
// print_r($args);die;
        $condition = $offlim = '';
  
        if (isset($args['dist_search'])) {

            $condition .= "AND inc.inc_district_id='" . $args['dist_search'] . "'";
        }


        if ($args['call_search_0_2'] != '') {
                
            $args['call_search'] = $args['call_search_0_2'];
         
            $search1 .= " AND ( inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_first_name LIKE '%".$args['call_search']."%' OR colleague.clg_last_name LIKE '%".$args['call_search']."%' OR colleague.clg_mid_name LIKE '%".$args['call_search']."%' ) ";
            
        }
        
        if ($args['dist_search_0_2'] != '') {
           
            $condition .= "AND amb.amb_district='" . $args['dist_search_0_2'] . "' ";
    
        }
       
        if ($args['amb_no_search_0_2'] != '') {
        
            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search_0_2'] . "' ";
        
        }

       if ($args['filter_time'] == '0_2') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
            $to_date = date('Y-m-d H:i:s');
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
     
       }

       if ($args['filter_time'] == '2_6') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-6 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-2 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '6_12') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-12 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-6 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '12_18') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-18 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-12 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '18_24') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-24 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-18 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '24_more') {
    
            $from_date = "2022-08-01 00:00:00";
            $to_date = date('Y-m-d H:i:s', strtotime('-24 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
    
        }

        if ($args['amb_no_search'] != '') {
          
            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search'] . "' ";
          
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
      
        $order_by = "ORDER BY inc.inc_datetime ASC";
       
        $sql = "SELECT *,base.hp_name as base_location_name,amb.amb_default_mobile,cmp_type.ct_type,max(inc_amb.assigned_time) as timestamp  FROM ems_incidence_ambulance AS inc_amb LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id ) LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )  LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )  LEFT JOIN   $this->tbl_mas_districts AS dist ON (dist.dst_code = inc.inc_district_id ) LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_ambulance_type as amb_type ON (amb_type.ambt_id = amb.amb_type) LEFT JOIN ems_base_location as base ON (base.hp_id = amb.amb_base_location) LEFT JOIN ems_mas_ambulance_status as amb_status ON (amb_status.ambs_id = amb.amb_status) LEFT JOIN $this->tbl_mas_patient_complaint_types as cmp_type ON (cmp_type.ct_id = inc.inc_complaint) where inc.inc_pcr_status = '0' and inc.inc_set_amb = '1' $condition GROUP BY amb.amb_rto_register_no" . " $order_by  $offlim ";

        $result = $this->db->query($sql);
        //  echo $this->db->last_query(); die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }


    // get_validation_busy_amb_data_popup
    function get_validation_busy_amb_data_popup($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';
        $Where = "where epcr.is_validate = '0'";
        $condition .= "AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%'";
        if (isset($args['dist_search'])) {

            $condition .= "AND inc.inc_district_id='" . $args['dist_search'] . "'";
        }


        if ($args['call_search_0_2'] != '') {
                
            $args['call_search'] = $args['call_search_0_2'];
         
            $search1 .= " AND ( inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_first_name LIKE '%".$args['call_search']."%' OR colleague.clg_last_name LIKE '%".$args['call_search']."%' OR colleague.clg_mid_name LIKE '%".$args['call_search']."%' ) ";
            
        }
        
        if ($args['dist_search_0_2'] != '') {
           
            $condition .= "AND amb.amb_district='" . $args['dist_search_0_2'] . "' ";
    
        }
       
        if ($args['amb_no_search_0_2'] != '') {
        
            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search_0_2'] . "' ";
        
        }

       if ($args['filter_time'] == '0_2') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
            $to_date = date('Y-m-d H:i:s');
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
     
       }

       if ($args['filter_time'] == '2_6') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-6 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-2 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '6_12') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-12 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-6 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '12_18') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-18 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-12 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '18_24') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-24 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-18 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '24_more') {
    
            $from_date = "2022-08-01 00:00:00";
            $to_date = date('Y-m-d H:i:s', strtotime('-24 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['amb_district'] != '') {
            // $condition .= "AND amb.amb_district='" . $args['amb_district'] . "' ";
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";

    
        }

        if ($args['amb_no_search'] != '') {
          
            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search'] . "' ";
          
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        
        $order_by = "ORDER BY inc.inc_datetime ASC";
       
        $sql = "SELECT *,base.hp_name as base_location_name,amb.amb_default_mobile,cmp_type.ct_type,max(inc_amb.assigned_time) as timestamp  FROM ems_incidence_ambulance AS inc_amb LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id ) LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )  LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )  LEFT JOIN   $this->tbl_mas_districts AS dist ON (dist.dst_code = inc.inc_district_id ) LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_ambulance_type as amb_type ON (amb_type.ambt_id = amb.amb_type) LEFT JOIN ems_base_location as base ON (base.hp_id = amb.amb_base_location) LEFT JOIN ems_mas_ambulance_status as amb_status ON (amb_status.ambs_id = amb.amb_status) LEFT JOIN $this->tbl_mas_patient_complaint_types as cmp_type ON (cmp_type.ct_id = inc.inc_complaint)  $Where $condition GROUP BY amb.amb_rto_register_no" . " $order_by  $offlim ";

        $result = $this->db->query($sql);
        //  echo $this->db->last_query(); die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_busy_amb_data($args = array(), $offset = '', $limit = '') {
// print_r($args);die;
        $condition = $offlim = '';
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }
        if (isset($args['dist_search'])) {

            $condition .= "AND inc.inc_district_id='" . $args['dist_search'] . "'";
        }
        if ($args['assign_amb_district'] != '') {
            $condition .= " AND inc.inc_district_id IN ('" . $args['assign_amb_district'] . "') ";
        }
        if (isset($args['amb_id'])) {

            $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
        }

        if (isset($args['amb_status'])) {

            $condition .= "AND amb.amb_status IN ('" . $args['amb_status'] . "')";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
        }
        if (isset($args['amb_user_type']) && $args['amb_user_type'] != '') {

            $condition .= "AND amb.amb_user_type='" . $args['amb_user_type'] . "' ";

            $order_by = "ORDER BY amb.amb_rto_register_no ASC";
        }

        if (isset($args['rg_no']) && $args['rg_no'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
        }

        if (isset($args['amb_search']) && $args['amb_search'] != '') {
             if ($args['amb_search'] == 'JE' ||  strtoupper($args['amb_search']) == 'je') {
                $type = '1';
            } else if ($args['amb_search'] == 'BLS' || strtoupper($args['amb_search']) == 'bls') {
                $type = '2';    
            } else if ($args['amb_search'] == 'ALS' || strtoupper($args['amb_search']) == 'als') {
                $type = '3';
            } 

            if ($args['amb_search'] == 'Available') {
                $status = '1';
            } else if ($args['amb_search'] == 'Busy') {
                $status = '2';
            } else if ($args['amb_search'] == 'Stand By') {
                $status = '3';
            } else if ($args['amb_search'] == 'Change Location') {
                $status = '4';
            } else if ($args['amb_search'] == 'Deleted / Inactive') {
                $status = '5';
            }  else if ($args['amb_search'] == 'Off Road') {
                $status = '7';
            } else if ($args['amb_search'] == 'Stand by Oxygen Filling') {
                $status = '8';
            } else if ($args['amb_search'] == 'Stand by Fuel Filling') {
                $status = '9';
            } else if ($args['amb_search'] == 'Stand by Demo Traning') {
                $status = '10';
            } else if ($args['amb_search'] == 'In Other General-Off Road') {
                $status = '11';
            } else if ($args['amb_search'] == 'On-Road') {
                $status = '12';
            } else if ($args['amb_search'] == 'In Equipment Maintenance ') {
                $status = '13';
            }  
           // GROUP BY
            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status' OR inc.inc_ref_id LIKE '%" . trim($args['amb_search']) . "%')";
        }

        if ($args['amb_district'] != '') {
           //$condition .= "AND amb.amb_district='" . $args['amb_district'] . "' ";
             $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }

        if ($args['amb_no_search'] != '') {
          
            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search'] . "' ";
          
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $order_by = "ORDER BY inc.inc_datetime ASC";

        $sql = "SELECT *,cmp_type.ct_type,max(inc_amb.assigned_time) as timestamp  FROM ems_incidence AS inc LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id ) LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id ) LEFT JOIN $this->tbl_inc_amb AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id ) LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )  LEFT JOIN   $this->tbl_mas_districts AS dist ON (dist.dst_code = inc.inc_district_id ) LEFT JOIN $this->tbl_amb_base_location as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_ambulance_type as amb_type ON (amb_type.ambt_id = amb.amb_type) LEFT JOIN ems_mas_ambulance_status as amb_status ON (amb_status.ambs_id = amb.amb_status) LEFT JOIN $this->tbl_mas_patient_complaint_types as cmp_type ON (cmp_type.ct_id = inc.inc_complaint) where amb.ambis_deleted='0' AND inc.inc_pcr_status = '0'  AND inc_system_type = '108' $condition GROUP BY inc.inc_cl_id" . " $order_by  $offlim ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query(); die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_closure_pending($args = array()) {
    // print_r($dist);die;
        $from_date = date("2022-08-01 00:00:00");
        $to_date = date('Y-m-d H:i:s');

        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date."' AND  '".$to_date."'"; 
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
        
        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";

        $result = $this->db->query($sql);
        // print_r($result);die;
        // echo $this->db->last_query();die;
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }


        // $condition = $offlim = '';

        // if (isset($args['rg_no']) && $args['rg_no'] != '') {

        //     $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
        // }

        // if (isset($args['amb_search']) && $args['amb_search'] != '') {

        //      if ($args['amb_search'] == 'ALS' ||  strtoupper($args['amb_search']) == 'ALS') {
        //         $type = '4';
        //     } else if ($args['amb_search'] == 'BLS' || strtoupper($args['amb_search']) == 'BLS') {
        //         $type = '3';
        //     } else if ($args['amb_search'] == 'PTA' || $args['amb_search'] == 'PTA (102)' || strtoupper($args['amb_search']) == 'PTA') {
        //         $type = '2';
        //     } else if ($args['amb_search'] == 'Two_wheel' || $args['amb_search'] == 'Two wheel' || $args['amb_search'] == 'Two wheeler') {
        //         $type = '1';
        //     } else if ($args['amb_search'] == 'CC' || strtoupper($args['amb_search']) == 'CC') {
        //         $type = '5';
        //     } else if ($args['amb_search'] == 'AIR' || strtoupper($args['amb_search']) == 'AIR') {
        //         $type = '6';
        //     }

        //     if ($args['amb_search'] == 'Available') {
        //         $status = '1';
        //     } else if ($args['amb_search'] == 'Busy') {
        //         $status = '2';
        //     } else if ($args['amb_search'] == 'In-Return' || $args['amb_search'] == 'Return') {
        //         $status = '3';
        //     } else if ($args['amb_search'] == 'In-Maintenance' || $args['amb_search'] == 'Maintenance') {
        //         $status = '4';
        //     } else if ($args['amb_search'] == 'Stand By') {
        //         $status = '6';
        //     } else if ($args['amb_search'] == 'In maintenance-OFF Road' || $args['amb_search'] == 'OFF Road') {
        //         $status = '7';
        //     } else if ($args['amb_search'] == 'In maintenance On Road' || $args['amb_search'] == 'On Road') {
        //         $status = '8';
        //     } else if ($args['amb_search'] == 'EMSO Not Available') {
        //         $status = '9';
        //     }

        //     $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status'OR inc.inc_ref_id LIKE '%" . trim($args['amb_search']) . "%')";
        // }
       
        // $sql = "SELECT *,cmp_type.ct_type,max(inc_amb.assigned_time) as timestamp  FROM ems_incidence AS inc LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id ) LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id ) LEFT JOIN $this->tbl_inc_amb AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id ) LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )  LEFT JOIN  $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_ambulance_type as amb_type ON (amb_type.ambt_id = amb.amb_type)  LEFT JOIN $this->tbl_mas_patient_complaint_types as cmp_type ON (cmp_type.ct_id = inc.inc_complaint) where amb.ambis_deleted='0' AND inc.inc_pcr_status = '0'  $condition  GROUP BY amb.amb_rto_register_no";

        // $result = $this->db->query($sql);
        // echo $this->db->last_query(); die;
        // if ($args['get_count']) {

        //     return $result->num_rows();
        // } else {

        //     return $result->result();
        // }
    }


    


    function get_closure_pending_0_2($args = array()) {

        $from_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
        $to_date = date('Y-m-d H:i:s');
       
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";

        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";
     

        $result = $this->db->query($sql);
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }

    function get_closure_pending_2_6($args = array()) {

        $from_date = date('Y-m-d H:i:s', strtotime('-6 hour'));
        $to_date = date('Y-m-d H:i:s', strtotime('-2 hour')); 
       
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";

        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";
        $result = $this->db->query($sql);
       //  echo $this->db->last_query();die;
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }

    function get_closure_pending_6_12($args = array()) {

        $from_date = date('Y-m-d H:i:s', strtotime('-12 hour'));
        $to_date = date('Y-m-d H:i:s', strtotime('-6 hour')); 
    
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";

        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";
        $result = $this->db->query($sql);
      // echo $this->db->last_query();die;
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }

    function get_closure_pending_12_18($args = array()) {
        
        $from_date = date('Y-m-d H:i:s', strtotime('-18 hour'));
        $to_date = date('Y-m-d H:i:s', strtotime('-12 hour')); 
       
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";

        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }

    function get_closure_pending_18_24($args = array()) {
    
        $from_date = date('Y-m-d H:i:s', strtotime('-24 hour'));
        $to_date = date('Y-m-d H:i:s', strtotime('-18 hour')); 
       
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";

        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";
        $result = $this->db->query($sql);
       //  echo $this->db->last_query();die;
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }
    function get_closure_pending_24_more($args = array()) {
    
        $from_date = "2022-08-01 00:00:00";
        $to_date = date('Y-m-d H:i:s', strtotime('-24 hour')); 
       
        $condition ='';
        $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
        $condition .= " AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1'";

        // if ($args['base_month'] != '') {
        //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
        // }
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
        }
       
        $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
        LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
        where $condition GROUP BY inc.inc_ref_id";
        $result = $this->db->query($sql);
       //  echo $this->db->last_query();die;
        //return $result->result();
         if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }


    
    function get_validation_pending($args = array()) {
        // print_r($dist);die;
            $from_date = date("2022-08-01 00:00:00");
            $to_date = date('Y-m-d H:i:s');
    
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date."' AND  '".$to_date."'"; 
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0' AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%'";
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
            
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
    
            $result = $this->db->query($sql);
            // print_r($result);die;
            // echo $this->db->last_query();die;
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
    
    
        }
    
    
        
    
    
        function get_validation_pending_0_2($args = array()) {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
            $to_date = date('Y-m-d H:i:s');
           
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%'";
    
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
         
    
            $result = $this->db->query($sql);
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
        }
    
        function get_validation_pending_2_6($args = array()) {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-6 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-2 hour')); 
           
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%'";
    
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
            $result = $this->db->query($sql);
           //  echo $this->db->last_query();die;
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
        }
    
        function get_validation_pending_6_12($args = array()) {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-12 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-6 hour')); 
        
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%'";
    
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
            $result = $this->db->query($sql);
          // echo $this->db->last_query();die;
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
        }
    
        function get_validation_pending_12_18($args = array()) {
            
            $from_date = date('Y-m-d H:i:s', strtotime('-18 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-12 hour')); 
           
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%' ";
    
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
            $result = $this->db->query($sql);
            // echo $this->db->last_query();die;
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
        }
    
        function get_validation_pending_18_24($args = array()) {
        
            $from_date = date('Y-m-d H:i:s', strtotime('-24 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-18 hour')); 
           
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%' ";
    
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
            $result = $this->db->query($sql);
           //  echo $this->db->last_query();die;
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
        }
        function get_validation_pending_24_more($args = array()) {
        
            $from_date = "2022-08-01 00:00:00";
            $to_date = date('Y-m-d H:i:s', strtotime('-24 hour')); 
           
            $condition ='';
            $condition = " inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
            $condition .= " AND epcr.is_validate = '0' AND inc.incis_deleted = '0'  AND epcr.epcris_deleted='0'  AND  operate_by NOT LIKE '%DCO%'";
    
            // if ($args['base_month'] != '') {
            //     $condition .= " AND  inc.inc_base_month IN ('" . $args['base_month'] . "')";
            // }
            if ($args['district'] != '') {
                $condition .= " AND amb.amb_district IN ('" . $args['district'] . "') ";
            }
           
            $sql = "select inc.inc_pcr_status, inc.inc_ref_id, inc_amb.inc_ref_id,inc_amb.amb_rto_register_no from ems_incidence_ambulance AS inc_amb 
            LEFT JOIN ems_incidence AS inc ON inc.inc_ref_id = inc_amb.inc_ref_id 
            LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
            LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no
            where $condition GROUP BY inc.inc_ref_id";
            $result = $this->db->query($sql);
            // echo $this->db->last_query();die;
            //return $result->result();
             if($result){
                    if ($args['get_count']) {
                        return $result->num_rows();
                    } else {
                    return $result->result();
                    }
                }
        }


    function get_avialable_amb_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['dist_search']) && $args['dist_search'] != '') {

            $condition .= "AND amb.amb_district='" . $args['dist_search'] . "'";
        }
        if (isset($args['amb_no_search']) && $args['amb_no_search'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_no_search'] . "'";
        }

        if (isset($args['amb_id'])) {

            $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
        }


        if (isset($args['amb_status'])) {

            $condition .= "AND amb.amb_status IN (" . $args['amb_status'] . ")";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
        }


        if (isset($args['amb_user_type']) && $args['amb_user_type'] != '') {

            $condition .= "AND amb.amb_user_type='" . $args['amb_user_type'] . "' ";

            $order_by = "ORDER BY amb.amb_rto_register_no ASC";
        }


        if (isset($args['rg_no']) && $args['rg_no'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
        }

        if (isset($args['amb_search']) && $args['amb_search'] != '') {

            if ($args['amb_search'] == 'JE') {
                $type = '1';
            } else if ($args['amb_search'] == 'BLS') {
                $type = '2';
            } else if ($args['amb_search'] == 'ALS') {
                $type = '3';
            } 

            if ($args['amb_search'] == 'Available') {
                $status = '1';
            } else if ($args['amb_search'] == 'Busy') {
                $status = '2';
            } else if ($args['amb_search'] == 'In-Return' || $args['amb_search'] == 'Return') {
                $status = '3';
            } else if ($args['amb_search'] == 'In-Maintenance' || $args['amb_search'] == 'Maintenance') {
                $status = '4';
            } else if ($args['amb_search'] == 'Stand By') {
                $status = '6';
            } else if ($args['amb_search'] == 'In maintenance-OFF Road' || $args['amb_search'] == 'OFF Road') {
                $status = '7';
            } else if ($args['amb_search'] == 'In maintenance On Road' || $args['amb_search'] == 'On Road') {
                $status = '8';
            } else if ($args['amb_search'] == 'EMSO Not Available') {
                $status = '9';
            }

            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $order_by = "ORDER BY inc_amb.assigned_time DESC";

        $sql = "SELECT *,offroad.mt_offroad_reason,max(inc_amb.assigned_time) as timestamp,amb.amb_rto_register_no as amb_no FROM  ems_ambulance AS amb   LEFT JOIN  ems_incidence_ambulance AS inc_amb ON  (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )  LEFT JOIN ems_mas_districts AS dist ON (dist.dst_code = amb.amb_district ) LEFT JOIN ems_base_location as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN ems_mas_ambulance_type as amb_type ON (amb_type.ambt_id = amb.amb_type) LEFT JOIN ems_mas_ambulance_status as amb_status ON (amb_status.ambs_id = amb.amb_status) LEFT JOIN ems_amb_onroad_offroad as offroad ON (offroad.mt_amb_no = amb.amb_rto_register_no)   where amb.ambis_deleted='0'  $condition  GROUP BY amb.amb_rto_register_no"
            . "   $order_by  $offlim ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_amb_supervisor_remark($args = array()) {
    
                $this->db->insert($this->tbl_supervisor_remark, $args);
        
                return $this->db->insert_id();
    }


    // 


    function update_stud_status($args = array()) {
        $this->db->set('stud_status', '1');
        $this->db->where('stud_id', $args['stud_id']);
        $data = $this->db->update($this->tbl_student);
        return $data;
    }

    function update_amb_release_data($amb_update_summary = array()) {

            $this->db->set('amb_status', $amb_update_summary['amb_status']);
            $this->db->where('amb_rto_register_no', $amb_update_summary['r_amb_rto_register_no']);
            $data = $this->db->update('ems_ambulance');
            return $data;

    }


    function insert_amb_release_data($args = array()) {

        $this->db->insert($this->tbl_supervisor_release, $args);

        return $this->db->insert_id();
    }

    function update_ambulance_staus_summary($amb_update_summary = array(), $off_road_status = '') {
        // print_r($amb_update_summary);die;
        $this->db->where('amb_rto_register_no', $amb_update_summary['amb_rto_register_no']);
        $this->db->where('off_road_status', $off_road_status);
        $this->db->order_by("id", "desc");
        $this->db->limit('1');

        $status = $this->db->update($this->tbl_ambulance_status_summary, $amb_update_summary);
        //echo $this->db->last_query();
        //die();

        return $status;
    }

    function get_gps_amb_data($args = array(), $offset = '', $limit = '') {

        $condition ='';

        if (isset($args['base_month']) && $args['base_month'] != '') {

            //$condition.= "AND inc.inc_base_month IN (" . ($args['base_month'] - 4) . "," . ($args['base_month'] - 3) . "," . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

          if ($args['amb_rto_register'] != '') {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register'] . "'";
        }
        if (isset($args['thirdparty'])) {

            //$condition .= "AND amb.thirdparty IN ('" . $args['thirdparty'] . "')";
        }

        if ($args['div_code'] != '') {

            $condition .= "AND amb.amb_div_code='" . $args['div_code'] . "'";
        }
        if ($args['district_id'] != '' && $args['district_id'] != 'undefined') {

             $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
    
         if ($args['amb_type_not'] != '') {

            $amb_typ = implode($args['amb_type_not']);
            $condition .= " AND amb.amb_type NOT IN ('" . $amb_typ . "')  ";
        }
        if (isset($args['108amb'])) {
            $condition .= "AND amb.amb_user='" . 108 . "'";
        }
        if (isset($args['102amb'])) {

            $condition .= "AND amb.amb_user='" . 102 . "'";
        }
        if (isset($args['104amb'])) {

            $condition .= "AND amb.amb_user='" . 104 . "'";
        }
         if (isset($args['all_amb'])) {

            $condition .= " AND amb.amb_user IN ('102','108')";
        }
        

       /* $sql = "SELECT amb.*,hp.hp_name,max(amb_tm.assigned_time) as timestamp,amb_tm.inc_ref_id,pat.*,inc.inc_mci_nature,
        inc.inc_complaint,inc.inc_complaint_other,inc.inc_datetime 
        FROM $this->tbl_amb as amb 
        LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id 
        LEFT JOIN $this->tbl_inc_amb as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no 
        LEFT JOIN ems_incidence_patient as inc_pat ON inc_pat.inc_id =amb_tm.inc_ref_id 
        LEFT JOIN ems_patient as pat ON inc_pat.ptn_id=pat.ptn_id 
        LEFT JOIN ems_incidence as inc ON inc_pat.inc_id =inc.inc_ref_id  
        where amb.ambis_deleted='0' $condition  GROUP BY amb.amb_rto_register_no  ORDER BY inc.inc_datetime DESC "; */

//        $sql = "select t1.*,t2.inc_ref_id,t2.assigned_time,pat.ptn_fullname,pat.ptn_fname,pat.ptn_lname,pat.ptn_age_type,pat.ptn_gender,
//        pat.ptn_age,inc.destination_hospital_id,
//        driver_para.parameter_count,driver_para.start_from_base_loc,driver_para.at_scene,driver_para.from_scene,driver_para.at_hospital,driver_para.patient_handover,driver_para.back_to_base_loc,
//        hos.hp_name as destination_hos,inc.inc_mci_nature,inc.inc_complaint,inc.inc_complaint_other,inc.inc_datetime from (SELECT amb.*,hp.hp_name,max(amb_tm.assigned_time) as timestamp,amb_type.ambt_name
//        FROM ems_ambulance as amb 
//        LEFT JOIN ems_mas_ambulance_type as amb_type ON amb_type.ambt_id = amb.amb_type 
//        LEFT JOIN ems_hospital as hp ON amb.amb_base_location = hp.hp_id 
//        LEFT JOIN ems_incidence_ambulance as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no 
//        where amb.ambis_deleted='0' AND amb.amb_status NOT IN('5','7') $condition GROUP BY amb.amb_rto_register_no ) 
//        t1 LEFT JOIN ems_incidence_ambulance t2 on t1.timestamp = t2.assigned_time
//        LEFT JOIN ems_incidence_patient as inc_pat ON inc_pat.inc_id =t2.inc_ref_id 
//        LEFT JOIN ems_patient as pat ON inc_pat.ptn_id=pat.ptn_id 
//        LEFT JOIN ems_incidence as inc ON inc_pat.inc_id =inc.inc_ref_id 
//        LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id 
//        LEFT JOIN ems_hospital1 as hos ON hos.hp_id =inc.destination_hospital_id  ORDER BY inc.inc_datetime DESC " ;
        
                $sql = "select t1.*,t2.inc_ref_id,t2.assigned_time,pat.ptn_fullname,pat.ptn_fname,pat.ptn_lname,pat.ptn_age_type,pat.ptn_gender,
        pat.ptn_age,inc.destination_hospital_id,
        driver_para.parameter_count,driver_para.start_from_base_loc,driver_para.at_scene,driver_para.from_scene,driver_para.at_hospital,driver_para.patient_handover,driver_para.back_to_base_loc,
        hos.hp_name as destination_hos,inc.inc_mci_nature,inc.inc_complaint,inc.inc_complaint_other,inc.inc_datetime from (SELECT amb.*,hp.hp_name,max(amb_tm.assigned_time) as timestamp,amb_type.ambt_name
        FROM ems_ambulance as amb 
        LEFT JOIN ems_mas_ambulance_type as amb_type ON amb_type.ambt_id = amb.amb_type 
        LEFT JOIN ems_base_location as hp ON amb.amb_base_location = hp.hp_id 
        LEFT JOIN ems_incidence_ambulance as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no 
        where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no ) 
        t1 LEFT JOIN ems_incidence_ambulance t2 on t1.timestamp = t2.assigned_time
        LEFT JOIN ems_incidence_patient as inc_pat ON inc_pat.inc_id =t2.inc_ref_id 
        LEFT JOIN ems_patient as pat ON inc_pat.ptn_id=pat.ptn_id 
        LEFT JOIN ems_incidence as inc ON inc_pat.inc_id =inc.inc_ref_id 
        LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id 
        LEFT JOIN ems_hospital as hos ON hos.hp_id =inc.destination_hospital_id  ORDER BY inc.inc_datetime DESC " ;

        

        $result = $this->db->query($sql);
        ///echo $this->db->last_query(); die;
        return $result->result();
    }
    function get_mdt_amb_data($args = array(), $offset = '', $limit = '') {

        $condition ='';
        
        if (($args['from_date'] != '' && $args['to_date'] != '') ) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= "  AND app_login.login_time  BETWEEN '$from' AND '$to 23:59:59'";

        }
        
        if ($args['district_id'] != '') {

             $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
        if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        if (trim($args['amb_type'])  != '') {

            $condition .= " AND amb.amb_type = '" . $args['amb_type'] . "' ";
        }
        if ($args['system'] != '') {

             $condition .= " AND amb.amb_user  IN ('" . $args['system'] . "')  ";
        }
        
        $sql = "SELECT amb_type.ambt_name,dist.dst_name,amb.amb_rto_register_no,thirdparty,stat.ambs_name,amb.amb_district,amb.amb_state,amb.amb_status,amb.amb_id,amb_rem.remark,amb.amb_base_location,amb.amb_default_mobile,hp.hp_name as baselocation,app_login.status
                FROM ems_ambulance as amb 
                
                LEFT JOIN ems_mas_ambulance_type as amb_type ON amb.amb_type = amb_type.ambt_id 
                LEFT JOIN ems_operationhr_remarks as amb_rem ON amb_rem.amb_id = amb.amb_id
                LEFT JOIN ems_base_location as hp ON amb.amb_base_location = hp.hp_id 
                LEFT JOIN ems_mas_ambulance_status as stat ON stat.ambs_id = amb.amb_status
                LEFT JOIN ems_mas_districts AS dist ON (dist.dst_code = amb.amb_district )
                LEFT JOIN ems_app_login_session as app_login ON amb.amb_rto_register_no =app_login.vehicle_no
                where amb.ambis_deleted='0' AND amb.amb_status != '5' AND amb.ambis_backup = '0' $condition GROUP BY amb.amb_rto_register_no";
       // echo $sql;
        // $sql ="SELECT amb.*,hp.hp_name,dist.dst_name as baselocation,app_login.status
        //         FROM ems_ambulance as amb 
        //         LEFT JOIN ems_hospital as hp ON amb.amb_base_location = hp.hp_id 
        //         LEFT JOIN ems_mas_districts AS dist ON (dist.dst_code = amb.amb_district )
        //         LEFT JOIN ems_app_login_session as app_login ON amb.amb_rto_register_no =app_login.vehicle_no
        //         where amb.ambis_deleted='0' AND amb_user_type='108' $condition GROUP BY amb.amb_rto_register_no";
        //echo $sql;
      
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die();
        return $result->result();
    }
    function als_p_count($args = array()){
        $condition ='';
        if ($args['amb_district'] != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "')  ";
        }
        $sql =  "SELECT COUNT(amb.amb_type) as count FROM `ems_ambulance` as `amb`
        left join `ems_app_login_session` as `typ` on `amb`.`amb_rto_register_no` = `typ`.`vehicle_no` 
         WHERE `amb`.`amb_type` = '3' AND  `typ`.`login_type`= 'P' AND `typ`.`status`= '1' $condition";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function als_d_count($args = array()){
        $condition ='';
        if ($args['amb_district'] != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "')  ";
       }
        $sql =  "SELECT COUNT(amb.amb_type) as count FROM `ems_ambulance` as `amb`
        left join `ems_app_login_session` as `typ` on `amb`.`amb_rto_register_no` = `typ`.`vehicle_no` 
         WHERE `amb`.`amb_type` = '3' AND  `typ`.`login_type`= 'D' AND `typ`.`status`= '1'  $condition ";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function bls_p_count($args = array()){
        $condition ='';
        if ($args['amb_district'] != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "')  ";
       }
        $sql =  "SELECT COUNT(amb.amb_type) as count FROM `ems_ambulance` as `amb`
        left join `ems_app_login_session` as `typ` on `amb`.`amb_rto_register_no` = `typ`.`vehicle_no` 
         WHERE `amb`.`amb_type` = '2' AND  `typ`.`login_type`= 'P' AND `typ`.`status`= '1' $condition";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function bls_d_count($args = array()){
        $condition ='';
        // var_dump($args['amb_district']);die();
        if ($args['amb_district'] != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "')  ";
       }
        $sql =  "SELECT COUNT(amb.amb_type) as count FROM `ems_ambulance` as `amb`
        left join `ems_app_login_session` as `typ` on `amb`.`amb_rto_register_no` = `typ`.`vehicle_no` 
         WHERE `amb`.`amb_type` = '2' AND  `typ`.`login_type`= 'D' AND `typ`.`status`= '1' $condition";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function je_count($args = array()){
        $condition ='';
        if ($args['amb_district'] != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "')  ";
       }
        $sql =  "SELECT COUNT(amb.amb_type) as count FROM `ems_ambulance` as `amb`
        left join `ems_app_login_session` as `typ` on `amb`.`amb_rto_register_no` = `typ`.`vehicle_no` 
        WHERE `amb`.`amb_type` = '1' AND  `typ`.`login_type`= 'D' AND `typ`.`status`= '1' $condition";
        $result = $this->db->query($sql);
        return $result->result();
    }
    function off_road_count($args = array()){
        $condition ='';
        if ($args['amb_district'] != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "')  ";
       }
        $sql =  "SELECT COUNT(amb.amb_status) as count FROM ems_ambulance as amb 
        WHERE amb.amb_status IN ('7') AND amb.ambis_deleted='0' $condition";
        $result = $this->db->query($sql);
        return $result->result();
    }
    
        function get_mdt_login_user($args = array(), $offset = '', $limit = '') {

        $condition ='';
        
        if (($args['from_date'] != '' && $args['to_date'] != '') ) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= "  AND app_login.login_time  BETWEEN '$from' AND '$to 23:59:59'";

        }
        
        if ($args['district_id'] != '') {

             $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
  
        $sql = "SELECT dist.dst_name,amb.amb_rto_register_no,amb.amb_district,amb.amb_state,amb.amb_status,amb.amb_id,amb.amb_base_location,app_login.status,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no,app_login.logout_time,app_login.login_time,app_login.id as login_id,clg.clg_ref_id
                FROM ems_ambulance as amb 
                LEFT JOIN ems_mas_districts AS dist ON (dist.dst_code = amb.amb_district )
                LEFT JOIN ems_app_login_session as app_login ON amb.amb_rto_register_no =app_login.vehicle_no
                LEFT JOIN ems_colleague AS clg ON (app_login.clg_id = clg.clg_id )
                where amb.ambis_deleted='0' AND amb.amb_status!='5' AND app_login.status ='1' AND amb_user_type='108' $condition";

        // $sql ="SELECT amb.*,hp.hp_name,dist.dst_name as baselocation,app_login.status
        //         FROM ems_ambulance as amb 
        //         LEFT JOIN ems_hospital as hp ON amb.amb_base_location = hp.hp_id 
        //         LEFT JOIN ems_mas_districts AS dist ON (dist.dst_code = amb.amb_district )
        //         LEFT JOIN ems_app_login_session as app_login ON amb.amb_rto_register_no =app_login.vehicle_no
        //         where amb.ambis_deleted='0' AND amb_user_type='108' $condition GROUP BY amb.amb_rto_register_no";
//        echo $sql;
//        die();
        $result = $this->db->query($sql);
        return $result->result();
    }

    function get_forcefully_mdt_login_user($args = array(), $offset = '', $limit = '') {

        $condition ='';
        
        if (($args['from_date'] != '' && $args['to_date'] != '') ) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            //$condition .= "  AND app_login.login_time  BETWEEN '$from' AND '$to 23:59:59'";

        }
        
        if ($args['district_id'] != '') {

             $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
  
        $sql = "SELECT dist.dst_name,amb.amb_rto_register_no,amb.amb_district,amb.amb_state,amb.amb_status,amb.amb_id,amb.amb_base_location,app_login.status,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no,app_login.logout_time,app_login.login_time,app_login.id as login_id,clg.clg_ref_id,app_login.login_type
                FROM  ems_app_login_session as app_login 
                LEFT JOIN ems_ambulance as amb ON amb.amb_rto_register_no =app_login.vehicle_no
                LEFT JOIN ems_mas_districts AS dist ON (dist.dst_code = amb.amb_district )
                LEFT JOIN ems_colleague AS clg ON (app_login.clg_id = clg.clg_id )
                where amb.ambis_deleted='0' AND app_login.status ='1' $condition";

        $result = $this->db->query($sql);
        return $result->result();
    }


    function get_mdt_other_data($args = array(), $offset = '', $limit = '') {

        $condition ='';
        if (($args['from_date'] != '' && $args['to_date'] != '') ) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= "  AND lgn.login_time  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";

        }
        
        if ($args['district_id'] != '') {

             $condition .= " AND clg.clg_district_id IN ('" . $args['district_id'] . "')  ";
        }

                $sql ="SELECT lgn.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no,clg.clg_email,clg.clg_designation,clg.clg_zone,clg.clg_district_id,dist.dst_name,grp.gcode,grp.ugname
                FROM `ems_app_login_session` AS lgn
                LEFT JOIN `ems_colleague` AS clg ON (lgn.clg_id = clg.clg_id )
                LEFT JOIN `ems_mas_groups` AS grp ON (clg.clg_group = grp.gcode )
                LEFT JOIN `ems_mas_districts` AS dist ON (clg.clg_district_id = dist.dst_code) 
                where lgn.type_id='4'AND (lgn.status ='1' OR lgn.status='2') $condition AND DATE(lgn.login_time) = CURDATE() ORDER BY lgn.login_time DESC";       
        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die;
        return $result->result();
    }



    function get_nhm_amb_data($args = array(), $offset = '', $limit = '') {

        $condition ='';
        
        if (($args['from_date'] != '' && $args['to_date'] != '') ) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= "  AND app_login.login_time  BETWEEN '$from' AND '$to 23:59:59'";

        }
        $current_date = date('Y-m-d H:i:s');
        $login_date = date('Y-m-d H:i:s', strtotime('-12 hour', strtotime($current_date)));
       
        
        if ($args['district_id'] != '') {

             $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
        if (isset($args['thirdparty'])  != '') {

           //$condition .= " AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
            }
        $sql = "SELECT amb.*,hp.hp_name as baselocation,app_login.status
                FROM ems_ambulance as amb 
                LEFT JOIN ems_base_location as hp ON amb.amb_base_location = hp.hp_id 
                LEFT JOIN ems_incidence_ambulance as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no 
                LEFT JOIN ems_app_login_session as app_login ON ( amb.amb_rto_register_no = app_login.vehicle_no AND app_login.login_time > '$login_date' )
                where amb.ambis_deleted='0' AND amb_user_type='108' AND amb.amb_status NOT IN ('5','7') $condition GROUP BY amb.amb_rto_register_no ORDER BY app_login.logout_time = '0000-00-00 00:00:00' DESC";
        
        $result = $this->db->query($sql);
        return $result->result();
    }
    function get_total_mdt(){
         $current_date = date('Y-m-d H:i:s');
        $login_date = date('Y-m-d', strtotime('-12 hour', strtotime($current_date)));
         $sql="SELECT * FROM ems_ambulance as amb LEFT JOIN ems_app_login_session as lgn on (lgn.vehicle_no=amb.amb_rto_register_no AND lgn.login_time > '$login_date' )
        LEFT join ems_mas_districts as dst ON dst.dst_code=amb.amb_district
        WHERE lgn.status='1' AND amb.amb_user_type='108' AND amb.amb_status IN ('1','2') GROUP BY amb_rto_register_no";
      // echo $sql;
      // die();
    
        $result = $this->db->query($sql);
        return $result->result();
    }
    function total_offroad($args = array()){
        $current_date = $args['from_date'];
        
         $current_date = $args['from_date'];
         if($args['select_time'] != ''){
            $select_time = $args['select_time'];
            $condition = " AND select_time = '$select_time'";
        }
        
        // $sql="SELECT `total_offroad` FROM `ems_district_wise_offroad` WHERE `district_name` LIKE 'total'";
        $sql="SELECT SUM(`total_offroad`) as total_offroad FROM `ems_district_wise_offroad` WHERE `district_name`!='total' AND (added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59') $condition;";
       // echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }
    function total_onroad($args = array()){
        $current_date = $args['from_date'];
        
         $current_date = $args['from_date'];
         if($args['select_time'] != ''){
            $select_time = $args['select_time'];
            $condition = " AND select_time = '$select_time'";
        }
        
        // $sql="SELECT `total_offroad` FROM `ems_district_wise_offroad` WHERE `district_name` LIKE 'total'";
        $sql="SELECT SUM(`off_road_doctor`) as total_onroad FROM `ems_district_wise_offroad` WHERE `district_name`!='total' AND (added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59') $condition;";
       // echo $sql;
        $result = $this->db->query($sql);
        return $result->result();
    }


     function get_tracking_amb_data($args = array(), $offset = '', $limit = '') {

        $condition ='';
        //var_dump($args['thirdparty']);

        if (isset($args['base_month']) && $args['base_month'] != '') {

            //$condition.= "AND inc.inc_base_month IN (" . ($args['base_month'] - 4) . "," . ($args['base_month'] - 3) . "," . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if (isset($args['amb_rto_register'])) {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register'] . "'";
        }
        if (isset($args['thirdparty'])) {

            $condition .= "AND amb.thirdparty IN ('" . $args['thirdparty'] . "')";
        }

        if ($args['div_code'] != '') {

            $condition .= "AND amb.amb_div_code='" . $args['div_code'] . "'";
        }
        if ($args['district_id'] != '') {

             $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "')  ";
        }
        if ($args['amb_type'] != '') {

             $condition .= " AND amb.amb_type IN ('" . $args['amb_type'] . "')  ";
        }
        if ($args['amb_status'] != '') {

             $condition .= " AND app_login.status IN ('" . $args['amb_status'] . "')  ";
        }

       // $sql = "select t1.*,t2.inc_ref_id from (SELECT amb.*,hp.hp_name,max(amb_tm.assigned_time) as timestamp,pat.ptn_fullname,pat.ptn_gender,pat.ptn_age,inc.inc_mci_nature,inc.inc_complaint,inc.inc_complaint_other,inc.inc_datetime FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id LEFT JOIN $this->tbl_inc_amb as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no LEFT JOIN ems_incidence_patient as inc_pat ON inc_pat.inc_id =amb_tm.inc_ref_id LEFT JOIN ems_patient as pat ON inc_pat.ptn_id=pat.ptn_id LEFT JOIN ems_incidence as inc ON inc_pat.inc_id =inc.inc_ref_id  where amb.ambis_deleted='0' $condition  GROUP BY amb.amb_rto_register_no  ORDER BY inc.inc_datetime DESC) t1 LEFT JOIN ems_incidence_ambulance t2 on t1.timestamp = t2.assigned_time ";
       
            $sql = "select t1.*,t2.inc_ref_id,t2.assigned_time,pat.ptn_fullname,pat.ptn_gender,
                pat.ptn_age,inc.destination_hospital_id,
                driver_para.parameter_count,driver_para.start_from_base_loc,driver_para.at_scene,driver_para.from_scene,driver_para.at_hospital,driver_para.patient_handover,driver_para.back_to_base_loc,
                hos.hp_name as destination_hos,inc.inc_mci_nature,inc.inc_complaint,inc.inc_complaint_other,inc.inc_datetime from (SELECT amb.*,hp.hp_name,max(amb_tm.assigned_time) as timestamp,amb_type.ambt_name,app_login.status
                FROM ems_ambulance as amb 
                LEFT JOIN ems_mas_ambulance_type as amb_type ON amb_type.ambt_id = amb.amb_type 
                LEFT JOIN ems_base_location as hp ON amb.amb_base_location = hp.hp_id 
                LEFT JOIN ems_incidence_ambulance as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no 
                LEFT JOIN ems_app_login_session as app_login ON amb.amb_rto_register_no =app_login.vehicle_no
                where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no ) 
                t1 LEFT JOIN ems_incidence_ambulance t2 on t1.timestamp = t2.assigned_time
                LEFT JOIN ems_incidence_patient as inc_pat ON inc_pat.inc_id =t2.inc_ref_id 
                LEFT JOIN ems_patient as pat ON inc_pat.ptn_id=pat.ptn_id 
                LEFT JOIN ems_incidence as inc ON inc_pat.inc_id =inc.inc_ref_id 
                LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id 
                
                
                LEFT JOIN ems_hospital as hos ON hos.hp_id =inc.destination_hospital_id  ORDER BY driver_para.parameter_count ASC" ;
          //echo $sql;
          //die();


        $result = $this->db->query($sql);

        
        return $result->result();
    }
    function get_area_type($args) {
        
          if($args['ar_id'] != ''){
            $condition .= " AND ar_id='" . $args['ar_id'] . "'";
        }

         $sql = "SELECT * FROM $this->tbl_mas_area_types WHERE aris_deleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function insert_reopen_ambid($args = array()) {

        $result = $this->db->insert($this->tbl_ambid_reopen_details, $args);
       // echo $this->db->last_query();die();
        if ($result) {

            return $result;
        } else {

            return false;
        }
    }
       function insert_replace_amb($args = array()) {

        $result = $this->db->insert($this->tbl_amb_replacement_details, $args);
        
        if ($result) {

            return $result;
        } else {

            return false;
        }
    }
    function update_reopen_id($args){
        $updateArray['epcris_deleted']='1';
        $updateArray['is_reopen']='1';
        
        $this->db->where('inc_ref_id', $args['incident_no']);
        $update = $this->db->update($this->tbl_epcr, $updateArray);
        
        if ($update) {
        return true;
        } else {
    
            return false;
        }
    }
     function update_reopen_timestam($args){
         
        if($args['incident_no'] != ''){
            $updateArray['flag']='2';
            $updateArray['odometer_type']='reopen_closure';
            $this->db->where('inc_ref_id', $args['incident_no']);
            $update = $this->db->update($this->tbl_ambulance_timestamp_record , $updateArray);
        
        if ($update) {
            return true;
        } else {
    
            return false;
        }
        }else{
             return false;
        }
    }
    function update_reopen_id_incident($args){
        $updateArray['inc_pcr_status']='0';
        $this->db->where('inc_ref_id', $args['incident_no']);
        $update = $this->db->update($this->tbl_incidence, $updateArray);
        
        if ($update) {
        return true;
        } else {
    
            return false;
        }
    }
    
    function update_replace_amb($args) {
        //var_dump($args);die();
        $updateArray['amb_rto_register_no']=$args['replace'];
        $updateArray['base_location_name']=$args['base_location_name'];
        $this->db->where('inc_ref_id', $args['incident_no']);
        $update = $this->db->update($this->tbl_inc_amb, $updateArray);
        //amb_rto_register_no
         //echo $this->db->last_query();
        // die();
         if ($update) {
        return true;
        } else {

            return false;
        }
    }
     function update_epcr_replace_amb($args) {
        //var_dump($args);die();
        $updateArray['amb_rto_register_no']=$args['replace'];
        $updateArray['base_location_name']=$args['base_location_name'];
        $this->db->where('inc_ref_id', $args['incident_no']);
        $update = $this->db->update($this->tbl_inc_amb, $updateArray);
        //amb_rto_register_no
        // echo $this->db->last_query();
        // die();
         if ($update) {
        return true;
        } else {

            return false;
        }
    }
    function get_amb_res_report($args){
        if($args['from_date'] != ''){
            $condition .= " AND from_date='" . $args['from_date'] . "'";
        }

        if($args['to_date'] != ''){
            $condition .= " AND to_date='" . $args['to_date'] . "'";
        }

        if($args['system_type'] != ''){
            $condition .= " AND system_type='" . $args['system_type'] . "'";
        }

        if($args['amb_type'] != ''){
            $condition .= " AND amb_type='" . $args['amb_type'] . "'";
        }

         $sql = "SELECT * FROM $this->tbl_mas_area_types WHERE aris_deleted='0' ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }

    }

    function get_amb_res_report_typewise_count($args, $type){
        //var_dump($args); die;
        $condition = '';
        if($args['system_type'] != ''){
            $condition .= " AND amb_user='" . $args['system_type'] . "'";
        }

        if($type != ''){
            $condition .= " AND amb_type='" . $type . "'";
        }

         $sql = "SELECT count(*) as amb FROM ems_ambulance WHERE ambis_deleted='0' $condition ";

        $result = $this->db->query($sql);
//echo $this->db->last_query(); die;
        if ($result > 0) {
            return $result->result();
        } else {
            return false;
        }

    }

    function call_to_scene_time($args, $working_area, $type)
    {
        

        $sql='SELECT dr.`dp_reach_on_scene`, CONCAT(dr.`inc_date`," ",dr.`inc_dispatch_time`) AS ind_datetime, TRUNCATE(AVG(TIMESTAMPDIFF(MINUTE, CONCAT(dr.`inc_date`," ", dr.`inc_dispatch_time`), dr.`dp_reach_on_scene`)),2) AS avg from ems_ambulance a RIGHT JOIN ems_epcr ep ON a.amb_rto_register_no=ep.amb_reg_id RIGHT JOIN ems_driver_pcr dr ON dr.inc_ref_id=ep.inc_ref_id WHERE a.amb_type="'.$type.'" AND a.amb_working_area="'.$working_area.'" AND DATE(STR_TO_DATE(`date`,"%m/%d/%Y")) BETWEEN "'.$args['from_date'].'" AND "'.$args['to_date'].'"';
        

        $query = $this->db->query($sql);
        //echo $this->db->last_query(); die;
         if($query->num_rows() > 0){
           $result = $query->result_array();
            return ($result[0]['avg'] ? $result[0]['avg'] : 0);
       }else{
           return 0;
       }
    }   

    function call_to_hosp_time($args, $working_area, $type)
    {
        
        $sql='SELECT dr.`dp_hosp_time`, CONCAT(dr.`inc_date`," ", dr.`inc_dispatch_time`) AS ind_datetime, TRUNCATE(AVG(TIMESTAMPDIFF(MINUTE, CONCAT(dr.`inc_date`," ", dr.`inc_dispatch_time`), dr.`dp_hosp_time`)),2) AS avg from ems_ambulance a RIGHT JOIN ems_epcr ep ON a.amb_rto_register_no=ep.amb_reg_id RIGHT JOIN ems_driver_pcr dr ON dr.inc_ref_id=ep.inc_ref_id WHERE a.amb_type="'.$type.'" AND a.amb_working_area="'.$working_area.'" AND DATE(STR_TO_DATE(`date`,"%m/%d/%Y")) BETWEEN "'.$args['from_date'].'" AND "'.$args['to_date'].'"';
        $query = $this->db->query($sql);
         if($query->num_rows() > 0){
           $result = $query->result_array();
            return ($result[0]['avg'] ? $result[0]['avg'] : 0);
       }else{
           return 0;
       }
    }   

    function amb_unavailability_percentage($args, $type)
    {
        $sql='SELECT TRUNCATE(((COUNT( * ) / ( SELECT COUNT( * ) FROM ems_incidence)) * 100 ),2) AS percentage from ems_incidence i JOIN ems_epcr ep on i.inc_ref_id=ep.inc_ref_id JOIN ems_ambulance a ON ep.amb_reg_id=a.amb_rto_register_no WHERE termination_reason="Ambulance Unavability" AND amb_type='.$type.' ';
        $query = $this->db->query($sql);
         if($query->num_rows()){
           $result = $query->result_array();
            return $result[0]['percentage'];
            //return 22;
       }else{
           return 0;
       }
    }   
    function get_amb_data1($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

      
        if(isset($args['amb_type'])&& ($args['amb_type'])  != 'all'){
            $condition .= " AND amb.amb_type='" . $args['amb_type'] . "'";
        }

        if (isset($args['amb_id']) && ($args['amb_id'])  != '') {

            $condition .= " AND amb.amb_id='" . $args['amb_id'] . "'";
        }

        if (($args['amb_district'])  != '') {
            if(($args['amb_district'])  != 'all'){
                $condition .= " AND amb.amb_district='" . $args['amb_district'] . "'";
            }
            
        }
        if (($args['amb_user'])  != '') {
            if(($args['amb_user'])  != 'all'){
                $condition .= " AND amb.amb_user='" . $args['amb_user'] . "'";
            }
            
        }
        if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND amb.thirdparty IN ('" . $args['thirdparty'] . "') ";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            $condition .= "AND amb.amb_default_mobile='" . $args['mob_no'] . "' OR amb.amb_pilot_mobile='" . $args['mob_no'] . "' ";
        }

        if (isset($args['rg_no']) && $args['rg_no'] != '') {

            $condition .= " AND amb.amb_rto_register_no='" . trim($args['rg_no']) . "'";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != '') {

            $condition .= " AND amb.amb_rto_register_no='" . trim($args['amb_rto_register_no']) . "'";
        }

        if (isset($args['amb_search']) && $args['amb_search'] != '') {

            if ($args['amb_search'] == 'ALS') {
                $type = '4';
            } else if ($args['amb_search'] == 'BLS') {
                $type = '3';
            } else if ($args['amb_search'] == 'PTA' || $args['amb_search'] == 'PTA (102)') {
                $type = '2';
            } else if ($args['amb_search'] == 'Two_wheel' || $args['amb_search'] == 'Two wheel' || $args['amb_search'] == 'Two wheeler') {
                $type = '1';
            } else if ($args['amb_search'] == 'CC') {
                $type = '5';
            } else if ($args['amb_search'] == 'AIR') {
                $type = '6';
            }

            if ($args['amb_search'] == 'Available') {
                $status = '1';
            } else if($args['amb_search'] == 'Busy') {
                $status = '2';
            } else if($args['amb_search'] == 'Stand By') {
                $status = '3';
            } else if ($args['amb_search'] == 'Change Location') {
                $status = '4';
            } else if ($args['amb_search'] == 'In Maintenance On Road' || $args['amb_search'] == 'On Road') {
                $status = '6';
            } else if ($args['amb_search'] == 'In maintenance Off Road' || $args['amb_search'] == 'Off Road') {
                $status = '7';
            } else if ($args['amb_search'] == 'Stand by Oxygen Filling') {
                $status = '8';
            }

            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['amb_search']) . "%' OR hp.hp_name LIKE '%" . trim($args['amb_search']) . "%' OR dist.dst_name LIKE '%" . trim($args['amb_search']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";
        }
        if (isset($args['search_amb']) && $args['search_amb'] != '') {
            
            if ($args['search_amb'] == 'ALS') {
                $type = '4';
            } else if ($args['search_amb'] == 'BLS') {
                $type = '3';
            } else if ($args['search_amb'] == 'PTA' || $args['search_amb'] == 'PTA (102)') {
                $type = '2';
            } else if ($args['search_amb'] == 'Two_wheel' || $args['search_amb'] == 'Two wheel' || $args['search_amb'] == 'Two wheeler') {
                $type = '1';
            } else if ($args['search_amb'] == 'CC') {
                $type = '5';
            } else if ($args['search_amb'] == 'AIR') {
                $type = '6';
            }

            if ($args['search_amb'] == 'Available') {
                $status = '1';
            } else if($args['search_amb'] == 'Busy') {
                $status = '2';
            } else if($args['search_amb'] == 'Stand By') {
                $status = '3';
            } else if ($args['search_amb'] == 'Change Location') {
                $status = '4';
            } else if ($args['search_amb'] == 'In Maintenance On Road' || $args['search_amb'] == 'On Road') {
                $status = '6';
            } else if ($args['search_amb'] == 'In maintenance Off Road' || $args['search_amb'] == 'Off Road') {
                $status = '7';
            } else if ($args['search_amb'] == 'Stand by Oxygen Filling') {
                $status = '8';
            }

           // $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '" . trim($args['search_amb']) . "' OR amb.amb_status = '" . trim($args['search_amb']) . "')";
            $condition .= "AND (amb.amb_rto_register_no LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_default_mobile LIKE '%" . trim($args['search_amb']) . "%' OR hp.hp_name LIKE '%" . trim($args['search_amb']) . "%' OR dist.dst_name LIKE '%" . trim($args['search_amb']) . "%' OR amb.amb_type = '$type' OR amb.amb_status = '$status')";

            
        }


        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        $order_by = "ORDER BY amb_tm.assigned_time DESC";
        // $amb_user = $args['amb_user'];
        // $dist = $args['amb_district'];
        // echo $amb_user;die;
        // $sql = "SELECT amb.*,hp.hp_name,amb_tm.timestamp FROM $this->tbl_amb as amb LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id LEFT JOIN $this->tbl_ambulance_timestamp_record as amb_tm ON amb.amb_rto_register_no =amb_tm.amb_rto_register_no where amb.ambis_deleted='0' $condition GROUP BY amb_tm.amb_rto_register_no  ORDER BY amb_tm.timestamp DESC $offlim ";
        // $sql = "SELECT amb_dri_para.parameter_count,lgsession.status as app_status,lgsession.login_type,amb.*,amb_type.ambt_name,app_clg.status,app_clg.vehicle_no,wrd.ward_name as wrdnm,dist.dst_name,hp.hp_name,max(amb_tm.assigned_time) as timestamp,dist.dst_name as dst_name 
        // FROM $this->tbl_amb as amb  
        // LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id 
        // LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id 
        // LEFT JOIN $this->tbl_inc_amb as amb_tm ON amb.amb_rto_register_no = amb_tm.amb_rto_register_no 
        // LEFT JOIN $this->tbl_mas_districts as dist ON amb.amb_district = dist.dst_code 
        // LEFT JOIN ems_app_login_session as app_clg ON app_clg.vehicle_no = amb.amb_rto_register_no AND lgsession.status = '1'
        // LEFT JOIN ems_mas_ambulance_type as amb_type ON amb.amb_type = amb_type.ambt_id
        // LEFT JOIN ems_app_login_session as lgsession ON amb.amb_rto_register_no = lgsession.vehicle_no AND lgsession.status = '1'
        // LEFT JOIN ems_driver_parameters as amb_dri_para ON amb_dri_para.amb_no = amb.amb_rto_register_no AND amb_dri_para.id = (select max(id) from ems_driver_parameters where amb_no = amb.amb_rto_register_no )
        // where amb.ambis_deleted='0'  $condition GROUP BY amb.amb_rto_register_no  $order_by  $offlim ";

        // $sql="SELECT dist.dst_name,hp.hp_name,amb_dri_para.parameter_count,amb.*,amb_type.ambt_name,app_clg.id as login_pk_id,app_clg.login_type,app_clg.status as app_status,app_clg.vehicle_no,max(amb_tm.assigned_time) as timestamp 
        // FROM ems_ambulance as amb 
        // LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
        // LEFT JOIN $this->tbl_mas_districts as dist ON amb.amb_district = dist.dst_code 
        // LEFT JOIN ems_incidence_ambulance as amb_tm ON amb.amb_rto_register_no = amb_tm.amb_rto_register_no 
        // LEFT JOIN ems_app_login_session as app_clg ON app_clg.vehicle_no = amb.amb_rto_register_no AND app_clg.status = '1' 
        // LEFT JOIN ems_mas_ambulance_type as amb_type ON amb.amb_type = amb_type.ambt_id 
        // LEFT JOIN ems_driver_parameters as amb_dri_para ON amb_dri_para.amb_no = amb.amb_rto_register_no AND amb_dri_para.id = (select max(id) from ems_driver_parameters where amb_no = amb.amb_rto_register_no ) 
        // where amb.ambis_deleted='0'  $condition 
        // GROUP BY amb.amb_rto_register_no 
        // ORDER BY amb_tm.assigned_time DESC";

        $sql = "SELECT amb.amb_id,dist.dst_name,hp.hp_name,amb_dri_para.parameter_count,amb.*,amb_type.ambt_name,GROUP_CONCAT(CONCAT('{',CONCAT_WS(',',CONCAT('\"status\"',':\"',app_clg.status,'\"'),CONCAT('\"id\"',':\"',app_clg.id,'\"'),CONCAT('\"logintype\"',':\"',app_clg.login_type,'\"')),'}')) as logindetails
        FROM ems_ambulance as amb 
        LEFT JOIN ems_app_login_session as app_clg ON amb.amb_rto_register_no = app_clg.vehicle_no AND app_clg.status = '1'
        LEFT JOIN ems_base_location as hp ON amb.amb_base_location = hp.hp_id 
        LEFT JOIN ems_mas_districts as dist ON amb.amb_district = dist.dst_code 
        LEFT JOIN ems_mas_ambulance_type as amb_type ON amb.amb_type = amb_type.ambt_id 
        LEFT JOIN ems_driver_parameters as amb_dri_para ON amb.amb_rto_register_no = amb_dri_para.amb_no AND amb_dri_para.id = (select max(id) from ems_driver_parameters where amb_no = amb.amb_rto_register_no ) 
        where amb.ambis_deleted='0' $condition ";
        
        //echo $sql;die;

        $result = $this->db->query($sql);
        // echo $this->db->last_query(); 
        // die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_amb_login_status_dist_wise($args = array(), $offset = '', $limit = '') {
        if (isset($args['amb_rto_register'])  != '') {

            $condition .= " AND t2.vehicle_no IN ('" . $args['amb_rto_register'] . "') ";
        }
         if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND amb.thirdparty IN ('" . $args['thirdparty'] . "') ";
        }
         if (isset($args['district_id'])  != '') {

            $condition .= " AND amb.amb_district IN ('" . $args['district_id'] . "') ";
        }
          if (isset($args['amb_type'])  != '') {

            $condition .= " AND amb.amb_type IN ('" . $args['amb_type'] . "') ";
        }
        if (isset($args['status'])  != '') {

            $condition .= " AND t2.status IN ('" . $args['status'] . "') ";
        }
        if (isset($args['login_type'])  != '') {

            $condition .= " AND t2.login_type IN ('" . $args['login_type'] . "') ";
        }
       // $sql = "SELECT t2.* FROM  ems_app_login_session as t2 
       // LEFT JOIN $this->tbl_amb as amb on (t2.vehicle_no=amb.amb_rto_register_no) 
       //WHERE  1=1 $condition group by vehicle_no  ORDER BY t2.id DESC";
       $sql = "SELECT amb.* FROM ems_ambulance as amb 
       LEFT JOIN ems_app_login_session as t2 on (amb.amb_rto_register_no=t2.vehicle_no) 
       WHERE 1=1 $condition group by amb_rto_register_no   ORDER BY t2.id DESC";
       
       $result = $this->db->query($sql);
      //  echo $this->db->last_query(); 
        //die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_app_login_user_remote($amb_id){
        
        $amb_no = $this->db->where('amb_id',$amb_id)->get('ems_ambulance')->result_array()[0]['amb_rto_register_no'];
        // echo $amb_no;die;
        $this->db->select('clg_login.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no');
        $this->db->from('ems_app_login_session clg_login');
        $this->db->join('ems_colleague clg', 'clg_login.clg_id = clg.clg_id', 'left');
        $this->db->where('clg_login.vehicle_no', $amb_no);
        $this->db->where('clg_login.status', '1');
        $this->db->group_by('clg_login.clg_id');
        $query = $this->db->get();
    //    echo $this->db->last_query();die;
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function get_app_login_user($amb_id){
        
        $amb_no = $this->db->where('amb_id',$amb_id)->get('ems_ambulance')->result_array()[0]['amb_rto_register_no'];
        // echo $amb_no;die;
        $this->db->select('clg_login.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no');
        $this->db->from('ems_app_login_session clg_login');
        $this->db->join('ems_colleague clg', 'clg_login.clg_id = clg.clg_id', 'left');
        $this->db->where('clg_login.vehicle_no', $amb_no);
        $this->db->where('clg_login.status', '1');
        $this->db->group_by('clg_login.clg_id');
        $query = $this->db->get();
       // echo $this->db->last_query();
      //  die();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    } 
        function get_app_login_user_reg($amb_id){
        
     
        $this->db->select('clg_login.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no');
        $this->db->from('ems_app_login_session clg_login');
        $this->db->join('ems_colleague clg', 'clg_login.clg_id = clg.clg_id', 'left');
        $this->db->where('clg_login.vehicle_no', $amb_id);
        $this->db->where('clg_login.status', '1');
        $this->db->group_by('clg_login.clg_id');
        $this->db->order_by('clg_login.clg_id','DESC');
        $query = $this->db->get();
         
           
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    } 
    function get_amb_no($amb_id){
        $amb_no = $this->db->where('amb_id',$amb_id)->get('ems_ambulance')->result_array()[0]['amb_rto_register_no'];
        return $amb_no;
    }
    function fuel_report($args = array()){
        $condition = '';



      if ($args['system'] != '' && $args['system'] != 'all') {
           $condition .= " AND amb.amb_user = '" . $args['system'] . "'";
        }


       $sql = "SELECT  amb.*,vah_data.vahicle_make,vah_data.aom_name"
            . " FROM $this->tbl_amb as amb "
            . " LEFT JOIN $this->tbl_vahicle_data as vah_data ON amb.amb_rto_register_no = vah_data.amb_reg_no"
            
            . " Where ambis_deleted = '0' $condition";
       
     


        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_fuel_filling($args= array()){
     
        $from = $args['from_date'];
        $to = $args['to_date'];
        $amb =$args['amb_rto'];
          

       $sql = "SELECT sum(ff.ff_fuel_quantity) as ff_fuel_quantity,sum(ff.ff_amount) as ff_amount"
            . " FROM  $this->tbl_fleet_fuel_filling as ff Where ff.ff_amb_ref_no='$amb' AND ff.ff_fuel_date_time BETWEEN '$from' AND '$to 23:59:59'  ";
            

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_fuel_odometer($args= array()){
     
        $from = $args['from_date'];
        $to = $args['to_date'];
        $amb =$args['amb_rto'];
          

        $sql = "SELECT min(start_odmeter*1) as start_odmeter,max(end_odmeter*1) as end_odmeter"
            . " FROM  $this->tbl_ambulance_timestamp_record as time_st Where flag = '1' AND time_st.amb_rto_register_no='$amb'  AND time_st.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
       
           

        $result = $this->db->query($sql);
       

        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_fuel_hpcl_data($args= array()){
     
        $from = $args['from_date'];
        $to = $args['to_date'];
        $amb =$args['amb_rto'];
          

        $sql = "SELECT sum(Amount*1) as hpcl_amount"
            . " FROM  ems_hpcl_data as hpcl where (hpcl.VehicleNoUserName ='$amb' AND hpcl.TransactionDate BETWEEN '$from 00:00:00' AND '$to 23:59:59' )";
      
            

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    
    function get_amb_odometer_listing($args=array(), $offset = '', $limit = '') {

        if (isset($args['incient_ambulance']) && $args['incient_ambulance'] != '') {
            $condition .= " AND amb_time.amb_rto_register_no='" . $args['incient_ambulance'] . "'";
        }
        if (isset($args['id']) && $args['id'] != '') {
            $condition .= " AND amb_time.id='" . $args['id'] . "'";
        }
        if (isset($args['incient_district']) && $args['incient_district'] != '') {
            $condition .= " AND amb.amb_district ='" . $args['incient_district'] . "'";
        }
        if (isset($args['to_date']) && $args['to_date'] != '' && $args['from_date'] == '') {
            $from = $args['to_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$from 23:59:59'";
        }
         if ( $args['to_date'] != '' && $args['from_date'] != '') {
            $to = $args['to_date'];
            $from = $args['from_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

       

  if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
          $sql = "SELECT amb_time.*,hp.hp_name,amb.amb_rto_register_no,amb.amb_district,wrd.ward_name as wrdnm FROM $this->tbl_ambulance_timestamp_record as amb_time left join $this->tbl_amb as amb on (amb_time.amb_rto_register_no = amb.amb_rto_register_no)  LEFT JOIN $this->tbl_amb_base_location as hp ON amb.amb_base_location = hp.hp_id   LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id  where 1= 1 $condition  ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC $offlim ";
          
          
//          echo $sql;
//          die();
        
       
        $result = $this->db->query($sql);

        if ($result) {
           if ($args['get_count']) {

                return $result->num_rows();
            } else {

                return $result->result();
            }
        } else {
            return false;
        }
    }
    

    function update_amb_odometer($args = array()) {

        
        if ($args['id']) {
            $this->db->where('id', $args['id']);
            $update = $this->db->update($this->tbl_ambulance_timestamp_record, $args);
            //echo $this->db->last_query(); die;
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function logoutappuser($hrs){
        $data['status'] = 2;
        $data['logout_time'] = date('Y-m-d H:i:s');
        $this->db->where('status','1')->where('login_time <=',$hrs)->update('ems_app_login_session',$data);
        return 1;
    }
        function get_amb_lat_lng($args) {

        if (isset($args['to_date']) && $args['to_date'] != '') {
            $from = $args['to_date'];
            $condition .= " AND amb_lat.packetdatetime <= '$from 23:59:59'";
        }

        $sql = "SELECT * FROM ems_mas_amb_latlong as amb_lat where 1= 1 $condition  ORDER BY amb_lat.id ASC";
       

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_amb_lat_lng_delete($args) {

        if (isset($args['to_date']) && $args['to_date'] != '') {
            $from = $args['to_date'];
            $condition .= "  packetdatetime <= '$from 23:59:59'";
        }

        $sql = "DELETE FROM ems_mas_amb_latlong where $condition";

        $result = $this->db->query($sql);

        return true;
        
    }
     function get_battery_type($args) {

        if (isset($args['id']) && $args['id'] != '') {
            $from = $args['id'];
            $condition .= " AND bat_type.id = '$from'";
        }

        $sql = "SELECT * FROM $this->tbl_battery_type as bat_type where 1= 1 $condition  ORDER BY bat_type.battery_type ASC";
       

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_map_amb_data($args){
 
        if ( $args['amb_type'] != '' ) {
             $amb_type = $args['amb_type'];
            $condition .= " AND amb.amb_type = '$amb_type'";
        }
        if ( $args['hp_id'] != '' ) {
            $hp_id = $args['hp_id'];
            $condition .= " AND amb.amb_base_location = '$hp_id'";
       }
       if ( $args['amb_rto_register_no'] != '' ) {
            $amb_rto_register_no= $args['amb_rto_register_no'];
            $condition .= " AND amb.amb_rto_register_no = '$amb_rto_register_no'";
       }

          $sql = "SELECT amb.*,ambtype.ambt_name,hp.hp_name,hp.hp_address,hp.hp_lat,hp.hp_long,hp.hp_id FROM  $this->tbl_amb as amb  
                  LEFT JOIN ems_base_location as hp ON amb.amb_base_location = hp.hp_id 
                  LEFT JOIN ems_mas_ambulance_type as ambtype ON amb.amb_type = ambtype.ambt_id 
                  where 1= 1 AND amb.amb_lat != '' AND amb.amb_lat != '#NA' $condition   ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_amb_odometer_listing_all($args=array(), $offset = '', $limit = '') {

        if (isset($args['incient_ambulance']) && $args['incient_ambulance'] != '') {
            $condition .= " amb_time.amb_rto_register_no='" . $args['incient_ambulance'] . "'";
        }
        if (isset($args['id']) && $args['id'] != '') {
            $condition .= " AND amb_time.id='" . $args['id'] . "'";
        }
        // if (isset($args['incient_district']) && $args['incient_district'] != '') {
        //     $condition .= " AND amb.amb_district ='" . $args['incient_district'] . "'";
        // }
        if (isset($args['to_date']) && $args['to_date'] != '' && $args['from_date'] == '') {
            $from = $args['to_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$from 23:59:59'";
        }
         if ( $args['to_date'] != '' && $args['from_date'] != '') {
            $to = $args['to_date'];
            $from = $args['from_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

       

  if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
          $sql = "SELECT amb_time.*,hp.hp_name,amb.amb_rto_register_no,amb.amb_district,wrd.ward_name as wrdnm FROM $this->tbl_ambulance_timestamp_record as amb_time left join $this->tbl_amb as amb on (amb_time.amb_rto_register_no = amb.amb_rto_register_no)  LEFT JOIN $this->tbl_amb_base_location as hp ON amb.amb_base_location = hp.hp_id   LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id  where $condition AND amb_time.odometer_type IN ('closure','Chng_new_fitted_odometer','update tyre maintaince','tyre maintenance','update onroad offroad maintaince','onroad_offroad maintenance','update accidental maintaince','accidental maintenance','Scrape Vahicle Update','Scrape Vahicle','update preventive maintenance','preventive maintenance','Manpower Update','Manpower','update breakdown maintaince','breakdown maintenance') ORDER BY amb_time.timestamp DESC,amb_time.end_odmeter DESC $offlim ";
          
          
        //  echo $sql;
        //  die();
        
       
        $result = $this->db->query($sql);

        if ($result) {
           if ($args['get_count']) {

                return $result->num_rows();
            } else {

                return $result->result();
            }
        } else {
            return false;
        }
    }

    
    function get_amb_odometer_enable_all($args=array()) {

        if (isset($args['incient_ambulance']) && $args['incient_ambulance'] != '') {
            $condition .= " amb_time.amb_rto_register_no='" . $args['incient_ambulance'] . "'";
        }
        if (isset($args['id']) && $args['id'] != '') {
            $condition .= " AND amb_time.id='" . $args['id'] . "'";
        }
        // if (isset($args['incient_district']) && $args['incient_district'] != '') {
        //     $condition .= " AND amb.amb_district ='" . $args['incient_district'] . "'";
        // }
        if (isset($args['to_date']) && $args['to_date'] != '' && $args['from_date'] == '') {
            $from = $args['to_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$from 23:59:59'";
        }
         if ( $args['to_date'] != '' && $args['from_date'] != '') {
            $to = $args['to_date'];
            $from = $args['from_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        $flag=1;

        $update = $this->db->query( "UPDATE ems_ambulance_timestamp_record as amb_time SET flag = $flag WHERE  $condition AND flag=2 AND amb_time.odometer_type='closure';");
         
        if ($update) {

            return true;
       } else {

         return false;
       }
    }
    function get_amb_odometer_disable_all($args=array()){
        // print_r("Hello");die;
        if (isset($args['incient_ambulance']) && $args['incient_ambulance'] != '') {
            $condition .= " amb_time.amb_rto_register_no='" . $args['incient_ambulance'] . "'";
        }
        if (isset($args['id']) && $args['id'] != '') {
            $condition .= " AND amb_time.id='" . $args['id'] . "'";
        }
        // if (isset($args['incient_district']) && $args['incient_district'] != '') {
        //     $condition .= " AND amb.amb_district ='" . $args['incient_district'] . "'";
        // }
        if (isset($args['to_date']) && $args['to_date'] != '' && $args['from_date'] == '') {
            $from = $args['to_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$from 23:59:59'";
        }
         if ( $args['to_date'] != '' && $args['from_date'] != '') {
            $to = $args['to_date'];
            $from = $args['from_date'];
            $condition .= " AND amb_time.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        $flag=2;
        
        $update = $this->db->query( "UPDATE ems_ambulance_timestamp_record as amb_time SET flag = $flag WHERE  $condition AND flag=1 AND amb_time.odometer_type='closure';");
        // echo $this->db->last_query(); die;
        if ($update) {

            return true;
       } else {

         return false;
       }

    }
    function update_timestamp_odometer_amb_all($update_timestamp_record = array(), $amb_no= array()){
        // print_r($amb_no);die();
        if ($amb_no['amb_rto_register_no']) {

            $this->db->where($amb_no);
             $update = $this->db->update( $this->tbl_ambulance_timestamp_record ,$update_timestamp_record);
            //  echo $this->db->last_query(); die;
        if ($update) {

             return true;
        } else {

          return false;
        }
        }

      }

// toggle flag between 1 & 2
      function update_timestamp_flag($ref_id,$flag){
             $update = $this->db->query( "UPDATE ems_ambulance_timestamp_record SET flag = $flag WHERE inc_ref_id = $ref_id;");
            //  echo $this->db->last_query(); die;
        if ($update) {

             return true;
        } else {

          return false;
        }
      }
    //   show_timestamp_flag
    function show_timestamp_flag($ref_id){
      
             $show = $this->db->query( "SELECT flag from ems_ambulance_timestamp_record WHERE inc_ref_id = $ref_id;");
             
             return $show->result_array();     
      }
      
      function get_last_ten_odometer($args) {

        if (isset($args['rto_no']) && $args['rto_no'] != '') {
            $condition .= " AND amb_time.amb_rto_register_no='" . $args['rto_no'] . "'";
        }
         $sql = "SELECT * FROM $this->tbl_ambulance_timestamp_record as amb_time where flag = '1' $condition  ORDER BY amb_time.timestamp DESC Limit 0, 10";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
}