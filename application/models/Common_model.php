<?php

class Common_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_groups');

        $this->tbl_mas_amb_type = $this->db->dbprefix('mas_ambulance_type');

        $this->tbl_mas_amb_status = $this->db->dbprefix('mas_ambulance_status');

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_summary = $this->db->dbprefix('summary');

        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');

        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');

        $this->tbl_mas_area_types = $this->db->dbprefix('mas_area_types');

        $this->tbl_mas_city = $this->db->dbprefix('mas_city');

        $this->tbl_mas_units = $this->db->dbprefix('mas_quantity_units');
        $this->tbl_mas_services = $this->db->dbprefix('mas_services');

        $this->tbl_optby = $this->db->dbprefix('operateby');

        $this->tbl_mas_question = $this->db->dbprefix('mas_questionnaire');

        $this->tbl_mas_call_type = $this->db->dbprefix('mas_call_type');

        $this->tbl_mas_default_ans = $this->db->dbprefix('mas_default_ans');

        $this->tbl_mas_hosp_types = $this->db->dbprefix('mas_hospital_type');

        $this->tbl_mas_states = $this->db->dbprefix('mas_states');

        $this->tbl_inc_adv = $this->db->dbprefix('incidence_advice');

        $this->tbl_clg = $this->db->dbprefix('colleague');

        $this->tbl_pptype = $this->db->dbprefix('mas_pupils_type');

        $this->tbl_repiration_type = $this->db->dbprefix('mas_repiration_type');

        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');

        $this->tbl_cgs_score = $this->db->dbprefix('mas_cgs_score');

        $this->tbl_options = $this->db->dbprefix('options');

        $this->tbl_case = $this->db->dbprefix('mas_case_type');

        $this->tbl_diseases = $this->db->dbprefix('mas_ex_diseases');

        $this->tbl_mas_consents = $this->db->dbprefix('mas_consents');

        $this->tbl_mas_relation = $this->db->dbprefix('mas_relation');

        $this->tbl_mas_pdignosis = $this->db->dbprefix('mas_prob_dignosis');

        $this->tbl_mas_dteam = $this->db->dbprefix('amb_default_team');

        $this->tbl_mas_distance = $this->db->dbprefix('mas_distance');

        $this->tbl_police_station = $this->db->dbprefix('police_station');

        $this->tbl_fire_station = $this->db->dbprefix('fire_station');
        
        $this->tbl_mas_shift = $this->db->dbprefix('mas_shift');
        $this->tbl_avaya_extension_summary = $this->db->dbprefix('avaya_extension_summary');
        $this->tbl_mas_division = $this->db->dbprefix('mas_division');
        $this->tbl_pda_assign_call_history = $this->db->dbprefix('pda_assign_call_history');
        $this->tbl_fda_assign_call_history = $this->db->dbprefix('fda_assign_call_history');
         $this->tbl_district_wise_offroad = $this->db->dbprefix('district_wise_offroad');
         $this->tbl_offroad_details = $this->db->dbprefix('offroad_details');
         $this->tbl_onroad_details = $this->db->dbprefix('onroad_details');
         $this->tbl_upload_b12_data = $this->db->dbprefix('upload_b12_data');
         $this->tbl_mas_call_purpose = $this->db->dbprefix('mas_call_purpose');
         
    }

    ////////////MI42////////////////////////////////////
    //
    // Purpose : Close existing DB connections.
    // 
    ////////////////////////////////////////////////////

    function close_db_connection() {
        $this->db->close();
    }
    
    function insert_call_history($args = array()) {

        $this->db->insert($this->tbl_pda_assign_call_history, $args);

        return $this->db->insert_id();
    }
        function insert_fda_call_history($args = array()) {

        $this->db->insert($this->tbl_fda_assign_call_history, $args);

        return $this->db->insert_id();
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : Get district 
    //           ambulance section and hospital section
    //
    ////////////////////////////////////////////////////
    
    function get_feedback_ques_ans($args = array(),$limit = '', $offset = ''){

        if (isset($args['inc_id']) && $args['inc_id'] != "") {

            $condition .= " AND sum_sub_id='" . $args['inc_id'] . "'";
        }
         if (isset($args['ques_id']) && $args['ques_id'] != "") {

            $condition .= " AND sum_que_id='" . $args['ques_id'] . "'";
        }
        $sql = "SELECT *"
        . " FROM ems_summary "
        . "Where sumis_deleted = '0' $condition";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
 function get_division($args = array(),$limit = '', $offset = ''){
        
        if (isset($args['st_id']) && $args['st_id'] != "") {

            $condition .= " AND div_state='" . $args['st_id'] . "'";
        }
         if (isset($args['st_id']) && $args['st_id'] != "") {

            $condition .= " AND div_state='" . $args['st_id'] . "'";
        }
        if (isset($args['div_code']) && $args['div_code'] != "") {

            $condition .= " AND div_code='" . $args['div_code'] . "'";
        }
        if (trim($args['term']) != '') {

            $condition .= " AND div_name LIKE'" . trim($args['term']) . "%' ";
        }   
        
        
        $sql = "SELECT *"
        . " FROM $this->tbl_mas_division "
        . "Where div_deleted = '0' $condition";
  

    $result = $this->db->query($sql);

    //echo $this->db->last_query();die;

    if ($result) {
        return $result->result();
    } else {
        return false;
    }

    }
    

    function get_dist_by_div($args = array(), $limit = '', $offset = ''){
       
            
        if (isset($args['div_code'])) {

            $condition .= "AND div_id='" . $args['div_code'] . "'";
        }
        $sql = "SELECT dst.*"
        . " FROM $this->tbl_mas_districts as dst "
        . "Where dstis_deleted = '0' $condition ";
  

         $result = $this->db->query($sql);
         //echo $this->db->last_query();die;

            if ($result) {
                return $result->result();
            } else {
                return false;
            }

    }
    function get_dist_lists($dist){
        $sql = "SELECT dst.dst_code,dst.dst_name"
        . " FROM $this->tbl_mas_districts as dst "
        . "Where dstis_deleted = '0' AND div_id = $dist ;";
    $data = $this->db->query($sql);

    // echo $this->db->last_query(); die;
    if ($data) {
        return $data->result_array();
    } else {
        return false;
    }
    }
    function get_district($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['dst_id']) && $args['dst_id'] != "") {

            $condition .= "AND dst.dst_code='" . $args['dst_id'] . "'";
        }
       
        if (isset($args['district_id']) && $args['district_id'] != "") {
            $condition .= "AND dst.dst_code IN ('" . $args['district_id'] . "') ";
        }

        if (isset($args['dst_code']) && $args['dst_code'] != "") {

            $condition .= "AND dst.dst_code='" . $args['dst_code'] . "'";
        }

        if (isset($args['st_id']) && $args['st_id'] != "") {

            $condition .= "AND (dst.dst_state='" . $args['st_id'] . "' OR dst.dst_state='MP' )";
        }
        
        if ($args['st_name'] != '') {

            $condition .= " AND dst.dst_name='" . trim($args['st_name']) . "' ";
        }

        if (trim($args['term']) != '') {

            $condition .= " AND dst.dst_name LIKE'" . trim($args['term']) . "%' ";
        }

        if (trim($args['dst_name']) != '') {

            $condition .= " AND dst.dst_name LIKE '%" . trim($args['dst_name']) . "%' ";
        }


        
        if ($args['order'] != '') {

            $oby = " ORDER BY dst_code " . $args['order'];
        } else {

            $oby = "ORDER BY dst_name ASC";
        }



         $sql = "SELECT dst.*"
            . " FROM $this->tbl_mas_districts as dst "
            . "Where dstis_deleted = '0' $condition $oby $lim_off";
       
      

        $result = $this->db->query($sql);

        // echo $this->db->last_query(); die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_divisions(){
         $sql = "SELECT dvs.*"
            . " FROM ems_mas_division as dvs "
            . "Where div_deleted = '0'";
        $result = $this->db->query($sql);

        //echo $this->db->last_query(); die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_offroad_reason(){
         $sql = "SELECT res.*"
            . " FROM ems_mas_offroad_reason as res "
            . "Where is_deleted = '0'";
        $result = $this->db->query($sql);

        //echo $this->db->last_query(); die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_thirdparty_list($args = array(), $limit = '', $offset = ''){
        //var_dump($args); 
        $this->db->select('*');

        $this->db->from("ems_mas_thirdparty");

        if (trim($args['cc_name']) != "") {
            $this->db->like("ems_mas_thirdparty.thirdparty_name", $args['cc_name'], 'both');
        }
        $this->db->where("ems_mas_thirdparty.is_deleted", '0');
       
        $data = $this->db->get();
        $result = $data->result();
         //echo $this->db->last_query();
        // die();
        return $result; 
        
       
    }
    function get_thirdparty_nm($args = array()){
        if (isset($args['thirdparty']) && $args['thirdparty'] != "") {

            $condition .= "AND thirdparty.thirdparty_id ='" . $args['thirdparty'] . "'";
        }
        $sql = "SELECT thirdparty.*"
            . " FROM ems_mas_thirdparty as thirdparty "
            . "Where 1=1 $condition  ";
//echo $sql;
        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_police_station($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['dst_id']) && $args['dst_id'] != "") {

            $condition .= "AND dst.dst_id='" . $args['dst_id'] . "'";
        }

        if (isset($args['dst_code']) && $args['dst_code'] != "") {

            $condition .= "AND police.p_district_code='" . $args['dst_code'] . "'";
        }
        if (isset($args['district_code']) && $args['district_code'] != "") {

            $condition .= "AND police.p_district_code iN ('0','" . $args['district_code'] . "')";
        }
        
        if (isset($args['p_tahsil']) && $args['p_tahsil'] != "") {

            $condition .= "AND police.p_tahsil='" . $args['p_tahsil'] . "'";
        }

        if (isset($args['st_id']) && $args['st_id'] != "") {

            $condition .= "AND (police.p_state_code='" . $args['st_id'] . "' OR police.p_state_code='1')";
        }
        if (isset($args['p_id']) && $args['p_id'] != "") {

            $condition .= " AND police.p_id='" . $args['p_id'] . "'";
        }

        if ($args['st_name'] != '') {

           // $condition .= " AND dst.dst_name='" . trim($args['st_name']) . "' ";
        }

        if (trim($args['term']) != '') {

            $condition .= " AND police.police_station_name LIKE'" . trim($args['term']) . "%' ";
        }




        $sql = "SELECT police.*"
            . " FROM $this->tbl_police_station as police "
            . " Where p_is_deleted = '0' $condition $oby order by police_station_name asc $lim_off ";
        //echo $sql;die();
        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

     function get_shift($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['shift_id']) && $args['shift_id'] != "") {

            $condition .= "AND shift.shift_id='" . $args['shift_id'] . "'";
        }

        $sql = "SELECT shift.*"
            . " FROM $this->tbl_mas_shift as shift "
            . "Where shift_is_deleted = '0' $condition  $lim_off";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_fire_station($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['dst_id']) && $args['dst_id'] != "") {

            $condition .= "AND dst.dst_id='" . $args['dst_id'] . "'";
        }

        if (isset($args['dst_code']) && $args['dst_code'] != "") {

            $condition .= "AND fire.f_district_code='" . $args['dst_code'] . "'";
        }
        if (isset($args['f_tahsil']) && $args['f_tahsil'] != "") {

            $condition .= "AND fire.f_tahsil='" . $args['f_tahsil'] . "'";
        }

        if (isset($args['st_id']) && $args['st_id'] != "") {

            $condition .= "AND fire.f_state_code='" . $args['st_id'] . "'";
        }

        if ($args['st_name'] != '') {

            $condition .= " AND dst.dst_name='" . trim($args['st_name']) . "' ";
        }

        if (trim($args['term']) != '') {

            $condition .= " AND dst.dst_name LIKE'" . trim($args['term']) . "%' ";
        }




        $sql = "SELECT fire.*"
            . " FROM $this->tbl_fire_station as fire "
            . "Where f_is_deleted = '0' $condition $oby $lim_off";
        //echo $sql;
       //die();

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : Get district 
    //           ambulance section and hospital section
    //
    ////////////////////////////////////////////////////
    
    function get_ambulance_type() {
        $sql = "SELECT * FROM $this->tbl_mas_amb_type WHERE ambtis_deleted='0'  order by ambu_level";
        $result = $this->db->query($sql);
        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
    function get_ambulance($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }
        
        if (isset($args['amb_type']) && $args['amb_type'] != "") {

            $condition .= "AND amb.amb_type='" . $args['amb_type'] . "'";
        }
        if (isset($args['amb_id']) && $args['amb_id'] != "") {

            $condition .= "AND amb.amb_id='" . $args['amb_id'] . "'";
        }

        if (isset($args['amb_district']) && $args['amb_district'] != "") {

            $condition .= "AND amb.amb_district='" . $args['amb_district'] . "'";
        }
         if (isset($args['amb_user']) && $args['amb_user'] != "") {
            if($args['amb_user']=='108'){
                $condition .= " AND amb.amb_user  IN ('108','102')";
            }else{
                $condition .= "AND amb.amb_user='" . $args['amb_user'] . "'";
            }
            //$condition .= "AND amb.amb_user='" . $args['amb_user'] . "'";
        }

        if (isset($args['amb_state']) && $args['amb_state'] != "") {

            $condition .= "AND amb.amb_state='" . $args['amb_state'] . "'";
        }
        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= " AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }
        if($args['thirdparty'] != '')
        {
            if($args['thirdparty']=='1'){
               // $condition .= " AND amb.thirdparty IN (1,6)"; 
            }else{
               // $condition .= " AND amb.thirdparty='" . $args['thirdparty'] . "'"; 
            }
        } 
         if (isset($args['amb_base_location'])  != '') {

            $condition .= " AND amb.amb_base_location='" . $args['amb_base_location'] . "'";
        }
        if (isset($args['ambis_backup'])  != '') {

            $condition .= " AND amb.ambis_backup='" . $args['ambis_backup'] . "'";
        }

        if (isset($args['amb_status']) && $args['amb_status'] != "") {
            $amb_status = implode( "','",$args['amb_status']);
            $condition .= " AND amb.amb_status IN ('" .$amb_status . "')";
        }


        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE '%" . trim($args['term']) . "%' ";
        }

         $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' AND ambis_backup != '1' $condition $oby $lim_off";
      



        $result = $this->db->query($sql);
        // echo $this->db->last_query();
        // die();
       


        if($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_closure_comp_fuel_amb($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['amb_id']) && $args['amb_id'] != "") {

            $condition .= " AND amb.amb_id='" . $args['amb_id'] . "'";
        }

        if (isset($args['amb_district']) && $args['amb_district'] != "") {

            $condition .= " AND amb.amb_district='" . $args['amb_district'] . "'";
        }
         if (isset($args['amb_user']) && $args['amb_user'] != "") {

            $condition .= " AND amb.amb_user='" . $args['amb_user'] . "'";
        }

        if (isset($args['amb_state']) && $args['amb_state'] != "") {

            $condition .= " AND amb.amb_state='" . $args['amb_state'] . "'";
        }
        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= " AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }


        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE'%" . trim($args['term']) . "%' ";
        }
        


          //$sql = "SELECT amb.*"
          //  . " FROM $this->tbl_amb as amb "
          //  . "Where ambis_deleted = '0' AND (amb_status = '1' OR amb_status = '7' OR amb_status = '2')  $condition $oby $lim_off";
      
           $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' AND (amb_status = '1' OR amb_status = '7' OR amb_status = '2' OR amb_status = '11')  $condition $oby $lim_off";
//   $sql = "SELECT amb.*"
//            . " FROM $this->tbl_amb as amb "
//            . "Where ambis_deleted = '0'  $condition $oby $lim_off";

      
        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_closure_comp_amb($args = array(), $limit = '', $offset = '') {
        if($this->clg->clg_group !=  'UG-DCO') {
            $condition .= " AND amb.amb_status != '7'";
            $condition .= " AND amb.ambis_backup = '0'";
        }

        if (isset($args['amb_id']) && $args['amb_id'] != "") {

            $condition .= " AND amb.amb_id='" . $args['amb_id'] . "'";
        }
        if (isset($args['ambis_backup']) && $args['ambis_backup'] != "") {

            $condition .= " AND amb.ambis_backup='" . $args['ambis_backup'] . "'";
        }

        if (isset($args['amb_district']) && $args['amb_district'] != "") {

            $condition .= " AND amb.amb_district='" . $args['amb_district'] . "'";
        }
        if (isset($args['amb_user']) && $args['amb_user'] != "") {

            $condition .= " AND amb.amb_user='" . $args['amb_user'] . "'";
        }
         if (isset($args['thirdparty']) && $args['thirdparty'] != "") {

            //$condition .= " AND amb.thirdparty='" . $args['thirdparty'] . "'";
        }
        

        if (isset($args['amb_state']) && $args['amb_state'] != "") {

            $condition .= " AND amb.amb_state='" . $args['amb_state'] . "'";
        }
        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= " AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }



        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE '%" . trim($args['term']) . "%' ";
        }


//          $sql = "SELECT amb.*"
//            . " FROM $this->tbl_amb as amb "
//            . "Where ambis_deleted = '0' AND (amb_status = '1' OR amb_status = '7' OR amb_status = '2')  $condition $oby $lim_off";
      
            $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where 1=1 AND ambis_deleted = '0' $condition ";
        //    echo $sql;
        //    die();
      
         

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_update_closure_comp_amb($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }



        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE'" . trim($args['term']) . "%' ";
        }


        $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' AND amb_status = '9' $condition $oby $lim_off";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_update_oxy_feel_ambulance($args = array(), $limit = '', $offset = '') {

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }



        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE'" . trim($args['term']) . "%' ";
        }


        $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' AND amb_status = '8' $condition $oby $lim_off";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_break_maintaince_ambulance($args = array(), $limit = '', $offset = '') {
        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }



        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE'" . trim($args['term']) . "%' ";
        }


        $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' AND amb_status != '7' $condition $oby $lim_off";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_tyre_life_amb($args = array(), $limit = '', $offset = '') {
      

        if ($offset >= 0 && $limit > 0) {

            $lim_off = " limit $limit offset $offset ";
        }

        if (isset($args['amb_rto_register_no']) && $args['amb_rto_register_no'] != "") {

            $condition .= "AND amb.amb_rto_register_no='" . $args['amb_rto_register_no'] . "'";
        }



        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no LIKE'" . trim($args['term']) . "%' ";
        }


        $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' AND amb_status = '6' $condition $oby $lim_off";
        
     

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : Get tahshil on dst code 
    //           ambulance section and hospital section
    //
    ////////////////////////////////////////////////////

    function get_tahshil($args = array()) {

        if (isset($args['dst_id']) && $args['dst_id'] != "") {
            $condition .= "AND tahshil.thl_district_code='" . $args['dst_id'] . "'";
        }
        if ($args['tah_name'] != '') {

            $condition .= " AND tahshil.thl_name like '" . trim($args['tah_name']) . "%' ";
            $lim_off = " limit 10 offset 0 ";
        }
        if ($args['thl_name'] != '') {

            $condition .= " AND tahshil.thl_name like '" . trim($args['thl_name']) . "%' ";
            $lim_off = " limit 10 offset 0 ";
        }

        if ($args['thl_id'] != '') {
            $condition .= " AND tahshil.thl_id ='" . $args['thl_id'] . "'";
            $lim_off = " limit 10 offset 0 ";
        }


        $sql = "SELECT tahshil.*"
            . " FROM $this->tbl_mas_tahshil as tahshil "
            . "Where thlis_deleted = '0' $condition ORDER BY thl_name ASC $lim_off ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_tahshil_max_code() {
        $sql = "SELECT MAX(tahshil.thl_code) as tahsil_code"
            . " FROM $this->tbl_mas_tahshil as tahshil "
            . "Where thlis_deleted = '0'";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : Get area type 
    //           ambulance section and hospital section
    //
    ////////////////////////////////////////////////////

    function get_area_type() {

        $sql = "SELECT * FROM $this->tbl_mas_area_types WHERE aris_deleted='0' ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_city($args = array(), $limit = '', $offset = '') {

        $lim_off = "";

        if ($limit > 0 && $offset >= 0) {

            $lim_off = " limit $limit offset $offset ";
        }


        if (isset($args['cty_id'])) {

            $condition .= "AND cty.cty_id='" . $args['cty_id'] . "'";
        }

        if (isset($args['thl_code']) && $args['thl_code'] != "") {
            $condition .= "AND cty.cty_thshil_code='" . $args['thl_code'] . "'";
        }

        if (isset($args['dist_code'])) {

            $condition .= "AND cty.cty_dist_code='" . $args['dist_code'] . "'";
        }


        if (trim($args['term']) != "") {

            $condition .= " AND cty.cty_name like '" . $args['term'] . "%' ";
        }


        if (trim($args['cty_name']) != "") {

            $condition .= " AND cty.cty_name='" . $args['cty_name'] . "' ";
        }



        $sql = "SELECT cty.* "
            . "FROM $this->tbl_mas_city as cty "
            . "Where cty.ctyis_deleted = '0' $condition ORDER BY cty.cty_name ASC $lim_off";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    //// Created by MI42 /////////////////////////////
    // 
    // Purpose : To get mas units for inventory items.
    // 
    //////////////////////////////////////////////////

    function get_units($args = array()) {

        if (!empty($args['inv_type'])) {
            $condition = " AND unt_group REGEXP '[[:<:]]" . $args['inv_type'] . "[[:>:]]' ";
        }
        $result = $this->db->query("select * from $this->tbl_mas_units where unt_status='1' AND untis_deleted='0' $condition");
        return $result->result();
    }

    public function get_base_month($curent_date = '') {

        if ($curent_date == '') {
            $curent_date = date("Y-m-d");
        }
        $result = $this->db->query("SELECT period_diff( date_format( '$curent_date' , '%Y%m' ) , date_format('2008-01-01' , '%Y%m' ) ) AS months");

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function get_services() {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_services ");
        $this->db->where("$this->tbl_mas_services.srv_status", '1');
        $this->db->where("$this->tbl_mas_services.srvis_deleted", '0');
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To assign operator.
    // 
    /////////////////////////////////////////

    public function assign_operator($args = array()) {

        $res = $this->db->insert($this->tbl_optby, $args);
//        echo $this->db->last_query();
//        die();


        return $res;
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To update operator.
    // 
    /////////////////////////////////////////

    function update_operator($args = array(), $data = array()) {



        $this->db->where($args);

        $res = $this->db->update($this->tbl_optby, $data);
        //echo $this->db->last_query();die;

        return $res;
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To get question.
    // 
    /////////////////////////////////////////

    function get_question($args = array()) {

        $condition = '';

        if (isset($args['que_type'])) {
            $condition .= "AND que_type='" . $args['que_type'] . "'";
        }
        if (trim($args['que_question']) != '') {
            $condition .= "AND que_question LIKE '" . $args['que_question'] . "%'";
        }
        if (trim($args['que_id']) != '') {
            $condition .= "AND que_id=" . $args['que_id'] . " ";
        }


        $result = $this->db->query("select * from $this->tbl_mas_question where que_isdeleted='0' $condition order by que_question asc");

        // echo $this->db->last_query();die;

        return $result->result();
    }
    
    function get_question_by_id_asc($args = array()) {

        $condition = '';

        if (isset($args['que_type'])) {
            $condition .= "AND que_type='" . $args['que_type'] . "'";
        }
        if (trim($args['que_question']) != '') {
            $condition .= "AND que_question LIKE '" . $args['que_question'] . "%'";
        }
        if (trim($args['que_id']) != '') {
            $condition .= "AND que_id=" . $args['que_id'] . " ";
        }


        $result = $this->db->query("select * from $this->tbl_mas_question where que_isdeleted='0' $condition order by que_id  ASC");

        /// echo $this->db->last_query();die;

        return $result->result();
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To get answer.
    // 
    /////////////////////////////////////////

    function get_answer($args = array()) {

        $condition = '';

        if (isset($args['ans_que_id'])) {
            $condition .= "AND ans_que_id='" . $args['ans_que_id'] . "'";
        }

        $result = $this->db->query("select * from $this->tbl_mas_default_ans where ansis_deleted='0' $condition");

        // echo $this->db->last_query();die;

        return $result->result();
    }

    //// Created by MI44 ////////////////////
    // 
    // Purpose : To get call type
    // 
    /////////////////////////////////////////

    function get_call_type($args = array()) {

        $condition = '';

        if ($args['cl_id']) {
            $condition = " AND cl_id=" . $args['cl_id'] . " ";
        }

        $result = $this->db->query("select * from $this->tbl_mas_call_type where clis_deleted='0' $condition");

        return $result->result();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add summary details.
    // 
    /////////////////////////////////////////

    function add_summary($args = array()) {

        $this->db->insert($this->tbl_summary, $args);

        $this->db->insert_id();
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : Get hospital type fetch on mas_hospital_type table 
    //           ambulance section and hospital section
    //
    ////////////////////////////////////////////////////

    function get_hp_type($hosp_type_id = '') {

        if ($hosp_type_id) {

            $condition .= " AND hosp_id='" .$hosp_type_id . "'";
        }
        
        $sql = "SELECT * FROM $this->tbl_mas_hosp_types WHERE hospis_deleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : get all state 
    //           ambulance section and hospital section
    //
    ////////////////////////////////////////////////////

    function get_state($args = array()) {


        if ($args['st_id']) {

            $condition .= " AND st_id='" . $args['st_id'] . "'";
        }

        if ($args['st_code']) {

            $condition .= " AND st_code='" . $args['st_code'] . "'";
        }

        if ($args['st_name']) {

            $condition .= " AND st_name='" . $args['st_name'] . "'";
        }

        if (trim($args['term']) != '') {

            $condition .= " AND st_name LIKE '" . $args['term'] . "%'";
        }




        $sql = "SELECT * FROM $this->tbl_mas_states WHERE stis_deleted='0' $condition ORDER BY st_name ASC";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_state_vendor($args = array()) {


        if ($args['st_id']) {

            $condition .= " AND st_id='" . $args['st_id'] . "'";
        }

        if ($args['st_code']) {

            $condition .= " AND st_code='" . $args['st_code'] . "'";
        }

        if ($args['st_name']) {

            $condition .= " AND st_name='" . $args['st_name'] . "'";
        }

        if (trim($args['term']) != '') {

            $condition .= " AND st_name LIKE '" . $args['term'] . "%'";
        }




        $sql = "SELECT * FROM $this->tbl_mas_states WHERE stis_deleted='0' AND st_code= 'MP' $condition ORDER BY st_name ASC";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_state_104($args = array()) {


        if ($args['st_id']) {

            $condition .= " AND st_id='" . $args['st_id'] . "'";
        }

        if ($args['st_code']) {

            $condition .= " AND st_code='" . $args['st_code'] . "'";
        }

        if ($args['st_name']) {

            $condition .= " AND st_name='" . $args['st_name'] . "'";
        }

        if (trim($args['term']) != '') {

            $condition .= " AND st_name LIKE '" . $args['term'] . "%'";
        }




        $sql = "SELECT * FROM $this->tbl_mas_states WHERE stis_deleted='0' AND (st_code = 'MP' OR st_code = 'OT') $condition ORDER BY st_name ASC";

        $result = $this->db->query($sql);
//echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ///////////////MI44////////////////////
    //
    //Purpose : get senior current user login
    //          Test call and enquiry call
    //
    //////////////////////////////////////

    function select_senior($args = array()) {

        $condition = '';

        if (isset($args['operator_id'])) {
            $condition .= "AND clg2.clg_ref_id='" . $args['operator_id'] . "'";
        }

        if (isset($args['clg_group'])) {
            $condition .= "AND clg2.clg_group='" . $args['clg_group'] . "'";
        }


        $sql = " SELECT clg2.clg_ref_id,clg1.clg_group,clg2.clg_senior "
            . "FROM $this->tbl_clg clg2 "
            . "LEFT JOIN $this->tbl_clg clg1  
                ON  clg2.clg_senior = clg1.clg_ref_id 
                WHERE clg1.clg_is_deleted='0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    //// Created by MI42 /////////////////////////////
    // 
    // Purpose : To get current incidence of ambulence.
    // 
    //////////////////////////////////////////////////

    function get_curinc($args = array()) {


        $result = $this->db->query("
        SELECT inc.inc_ref_id,amb.amb_rto_register_no 
        FROM $this->tbl_amb as amb , $this->tbl_inc as inc , $this->tbl_inc_amb as inc_amb 
        WHERE   inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND
                TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no) AND 
                inc.inc_ref_id = inc_amb.inc_ref_id AND 
                amb.amb_default_mobile='" . $args['amb_mob'] . "' AND 
                inc_amb.amb_status='current'");

        return $result->result();
    }

    //////////////////MI44/////////////////////////////
    //
    //Purpose : to ftech city by tashil code
    //
    //           HOspital section / ambulance section
    //
    //////////////////////////////////////////////////


    function get_th_to_city($args = array()) {

        $condition = '';

        if (isset($args['thl_code']) && $args['thl_code'] != "") {
            $condition .= "AND thl.thl_district_code='" . $args['thl_code'] . "'";
        }

        if (isset($args['cty_name'])) {

            $condition .= "AND cty.cty_name='" . $args['cty_name'] . "' ";
        }

        $sql = "SELECT thl.thl_code,cty.cty_name ,cty.* "
            . "FROM $this->tbl_mas_tahshil as thl "
            . ",$this->tbl_mas_city as cty "
            . "Where thl.thlis_deleted = '0' $condition AND thl.thl_code = cty.cty_thshil_code ORDER BY thl_name ASC";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    //////////////////MI42/////////////////////////////
    //Purpose : Get ERCP for advice.
    //  
    //////////////////////////////////////////////////

    
    function get_ercp_104($args = array()){
        $sql = "SELECT opby.operator_id,opby.sub_id,inc_adv.adv_inc_ref_id  "
        . "FROM $this->tbl_optby as opby,ems_help_desk_inc_advice as inc_adv,$this->tbl_clg as clg1 "
        . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
        . "opby.sub_id=inc_adv.adv_id AND "
        . "clg1.clg_ref_id=opby.operator_id AND "
//            . "clg3.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
        . " opby.operator_type='UG-ERO-104'  AND opby.sub_status='ATNG' ORDER BY opby.sub_id ASC ";
    
    
         $sql = "SELECT opby.* "
        . "FROM $this->tbl_optby as opby "
        . "WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
        . " opby.operator_type='UG-ERCP-104' AND opby.sub_status='ASG' AND modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR ORDER BY opby.sub_id ASC ";
       
        

    $result = $this->db->query($sql);

    if ($result) {
        return $result->result();
    } else {
        return false;
    }
    }
    function get_counsler_calls_104($args = array()) {
        $sql = " SELECT opby.* "
        . " FROM $this->tbl_optby as opby "
         ." LEFT JOIN $this->tbl_inc as inc ON (inc.inc_ref_id = opby.sub_id )" 
        . " WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
        . " opby.operator_type='UG-COUNSELOR-104' AND opby.sub_status='ASG' AND opby.modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR AND inc.inc_pcr_status ='0' ORDER BY opby.sub_id ASC "; 


    $result = $this->db->query($sql);

    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
    function get_counsler_104($args = array()){
       
         $sql = "SELECT opby.* "
        . "FROM $this->tbl_optby as opby "
        . "WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
        . " opby.operator_type='UG-COUNSELOR-104' AND opby.sub_status='ASG' AND modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR ORDER BY opby.sub_id ASC ";
   //echo $sql;die();   
        

    $result = $this->db->query($sql);

    if ($result) {
        return $result->result();
    } else {
        return false;
    }
    }
    function get_ercp($args = array()) {

        $sql = "SELECT opby.operator_id,opby.sub_id,inc_adv.adv_inc_ref_id  "
            . "FROM $this->tbl_optby as opby,$this->tbl_inc_adv as inc_adv,$this->tbl_clg as clg1 "
            . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc_adv.adv_id AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
//            . "clg3.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . " opby.operator_type='UG-ERO' AND opby.sub_status='ATNG' ORDER BY opby.sub_id ASC ";
        
        
             $sql = "SELECT opby.* "
            . "FROM $this->tbl_optby as opby "
            . "WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
            . " opby.operator_type='UG-ERCP' AND opby.sub_status='ASG' AND modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR ORDER BY opby.sub_id ASC ";
           


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
        function get_ercp_calls($args = array()) {
            $sql = " SELECT opby.* "
            . " FROM $this->tbl_optby as opby "
             ." LEFT JOIN $this->tbl_inc as inc ON (inc.inc_ref_id = opby.sub_id )" 
            . " WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
            . " opby.operator_type='UG-ERCP' AND opby.sub_status='ASG' AND opby.modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR AND inc.inc_pcr_status ='0' ORDER BY opby.sub_id ASC "; 


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_ercp_calls_104($args = array()) {
        $sql = " SELECT opby.* "
        . " FROM $this->tbl_optby as opby "
         ." LEFT JOIN $this->tbl_inc as inc ON (inc.inc_ref_id = opby.sub_id )" 
        . " WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
        . " opby.operator_type='UG-ERCP-104' AND opby.sub_status='ASG' AND opby.modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR AND inc.inc_pcr_status ='0' ORDER BY opby.sub_id ASC "; 


    $result = $this->db->query($sql);

    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}

    function get_police_calls($args = array()) {
         $sql = "SELECT * "
            . "FROM $this->tbl_optby as opby,$this->tbl_clg as clg1, $this->tbl_inc as inc "
            . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc.inc_ref_id AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
            . "clg1.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.operator_type='UG-PDA' AND opby.sub_status='ASG' ORDER BY opby.sub_id ";
        


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_grieviance_calls($args = array()) {
        $sql = "SELECT * "
            . "FROM $this->tbl_optby as opby,$this->tbl_clg as clg1, $this->tbl_inc as inc "
            . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc.inc_ref_id AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
            . "clg1.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.operator_type='UG-Grievance' AND opby.sub_status='ASG' ORDER BY opby.sub_id DESC";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_erosupervisor_calls($args = array()) {
        $sql = "SELECT * "
            . "FROM $this->tbl_optby as opby,$this->tbl_clg as clg1, $this->tbl_inc as inc "
            . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc.inc_ref_id AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
            . "clg1.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.operator_type='UG-EROSupervisor' AND opby.sub_status='ASG' ORDER BY opby.sub_id DESC ";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_shiftmanager_calls($args = array()) {
        $to = date('Y-m-d');
        $from = date('Y-m-d', strtotime("-24 hours"));;
         $sql = "SELECT * "
            . "FROM $this->tbl_optby as opby,$this->tbl_clg as clg1, $this->tbl_inc as inc "
            . "WHERE opby.base_month IN (" . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc.inc_ref_id AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
            . "clg1.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.operator_type='UG-ShiftManager' AND opby.sub_status='ASG' AND  opby.modify_date_sync between '$from' AND '$to' ORDER BY opby.sub_id DESC";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_dcosupervisor_calls($args = array()) {
        
        $sql = "SELECT * "
            ."FROM $this->tbl_optby as opby,$this->tbl_clg as clg1, $this->tbl_inc as inc "
            ."WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            ."opby.sub_id=inc.inc_ref_id AND "
            ."clg1.clg_ref_id=opby.operator_id AND "
            ."clg1.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            ."opby.operator_type='" . $args['clg_group'] . "' AND opby.sub_status='ASG' AND opby.modify_date_sync >= CURRENT_TIMESTAMP - INTERVAL '24' HOUR ORDER BY opby.sub_id DESC";
        
        //echo $sql;
       // die();

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_situaltional_calls($args = array()){
        $sql = "SELECT * "
            . "FROM $this->tbl_optby as opby, $this->tbl_inc as inc "
            . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc.inc_ref_id AND "
            //. "clg1.clg_ref_id=opby.operator_id AND "
            . "opby.operator_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.operator_type='UG-SITUATIONAL-DESK' AND opby.sub_status='ASG' ORDER BY opby.sub_id DESC";
     

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_fire_calls($args = array()) {
          $sql = "SELECT * "
            . "FROM $this->tbl_optby as opby, $this->tbl_inc as inc "
            . "WHERE opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "opby.sub_id=inc.inc_ref_id AND "
            //. "clg1.clg_ref_id=opby.operator_id AND "
            . "opby.operator_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.operator_type='UG-FDA' AND opby.sub_status='ASG' ORDER BY opby.sub_id DESC";
     

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : To get LOC level.
    //           
    ////////////////////////////////////////////////////

    function get_loc_level($args = array()) {

        $condition = "";

        if (trim($args['loc_level']) != '') {

            $condition .= " AND level_type LIKE '" . $args['loc_level'] . "%' ";
        }

         if (trim($args['level_id']) != '') {

            $condition .= " AND level_id LIKE '" . $args['level_id'] . "%' ";
        }


        $sql = "SELECT * FROM $this->tbl_loc_level WHERE levelis_deleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : To get CGS score.
    //           
    ////////////////////////////////////////////////////

    function get_gcs_score($args = array()) {

        $condition = "";

        if (trim($args['cgs_score']) != '') {

            $condition .= " AND score LIKE '" . $args['cgs_score'] . "%' ";
        }

        $sql = "SELECT * FROM $this->tbl_cgs_score WHERE scoreis_deleted='0' $condition ORDER BY score DESC";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44////////////////////////////////////
    //
    // Purpose : To get CGS score.
    //           
    ////////////////////////////////////////////////////
    function get_repiration_list($args = array()){
        $condition = "";

        if (trim($args['res_type']) != '') {

            $condition .= " AND res_type LIKE '" . $args['res_type'] . "%' ";
        }
        

        $sql = "SELECT * FROM $this->tbl_repiration_type WHERE resis_deleted='0' $condition";
        
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_pupils_type($args = array()) {

        $condition = "";

        if (trim($args['pupils_type']) != '') {

            $condition .= " AND pp_type LIKE '" . $args['pupils_type'] . "%' ";
        }
         if (trim($args['pp_id']) != '') {

            $condition .= " AND pp_id = '" . $args['pp_id'] . "' ";
        }

        $sql = "SELECT * FROM $this->tbl_pptype WHERE ppis_deleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////////MI44////////////////////////////////
    //
    //Purpose: about 108 details fetch on option table.
    //
    ////////////////////////////////////////////////////


    function emergency_details($args = array()) {

        $condition = "";

        if (isset($args['oname'])) {

            $condition .= "oname='" . $args['oname'] . "'";
        }

        $sql = "SELECT * FROM $this->tbl_options WHERE $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    /////////////////MI44 //////////////////////////
    //
    //Pusrpose: get consents details
    //
    ////////////////////////////////////////////////

    function consents_info($args = array()) {

        $condition = "";

        if (isset($args['cons_id'])) {

            $condition .= "AND cons_id='" . $args['cons_id'] . "'";
        }

        $sql = "SELECT * FROM $this->tbl_mas_consents WHERE consis_deleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////////MI44////////////////////////////////
    //
    //Purpose: Get case types.
    //
    ////////////////////////////////////////////////////


    function case_type() {

        $sql = "SELECT * FROM $this->tbl_case WHERE case_isdeleted='0'";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////////MI44////////////////////////////////
    //
    //Purpose: Get past medical history types.
    //
    ////////////////////////////////////////////////////


    function past_med_his() {

        $sql = "SELECT * FROM $this->tbl_diseases WHERE dis_isdeleted='0'";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_relation() {

        $sql = "SELECT * FROM $this->tbl_mas_relation WHERE relis_deleted='0'";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_relation_by_id($id) {

        $sql = "SELECT rel_name FROM $this->tbl_mas_relation WHERE rel_id = '$id' AND relis_deleted='0'";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    ////////////////MI44////////////////////////////////
    //
    //Purpose: Get probable diagnosis.
    //
    ////////////////////////////////////////////////////

    function get_pdignosis() {

        $condition = "";

        if (isset($args['dig_title'])) {

            $condition .= "AND dig_title LIKE '" . $args['dig_title'] . "'";
        }

        $sql = "SELECT * FROM $this->tbl_mas_pdignosis WHERE dig_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI42////////////////////////////////////
    //
    // Purpose : Insert state.
    // 
    ////////////////////////////////////////////////////

    function insert_state($args = array()) {

        $this->db->insert($this->tbl_mas_states, $args);

        return $this->db->insert_id();
    }

    ////////////MI42////////////////////////////////////
    //
    // Purpose : Insert district.
    // 
    ////////////////////////////////////////////////////

    function insert_distrcit($args = array()) {

        $this->db->insert($this->tbl_mas_districts, $args);

        return $this->db->insert_id();
    }

    ////////////MI42////////////////////////////////////
    //
    // Purpose : Insert city.
    // 
    ////////////////////////////////////////////////////

    function insert_city($args = array()) {

        $this->db->insert($this->tbl_mas_city, $args);

        return $this->db->insert_id();
    }

    function insert_tahsil($args = array()) {

        $this->db->insert($this->tbl_mas_tahshil, $args);

        return $this->db->insert_id();
    }

    function get_emt_by_shift($args = array()) {

        if ($args['tm_emt_id']) {

            $condition .= " AND  tm_emt_id='" . $args['tm_emt_id'] . "' ";
        }

        if ($args['tm_shift']) {

            $condition .= " AND  tm_shift='" . $args['tm_shift'] . "' ";
        }

        $result = $this->db->query("select * from $this->tbl_mas_dteam where tmis_deleted='0' $condition");


        return $result->result();
    }

    /* mi13 */

    function get_distance($args = array()) {

        $condition = "";

        if (trim($args['distance']) != '') {

            $condition .= " AND distance LIKE '" . $args['distance'] . "%' ";
        }

        $sql = "SELECT * FROM $this->tbl_mas_distance WHERE distanceis_deleted='0' $condition ORDER BY distance";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_birth_effects($args = array()) {

        $condition = "";

        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }


        if (isset($args['birth_effects_title'])) {

            $condition .= "AND birth_effects_title LIKE '" . $args['birth_effects_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_birth_effects WHERE birth_effects_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_childhood_disease($args = array()) {

        $condition = "";

        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }

        if (isset($args['childhood_disease_title'])) {

            $condition .= "AND childhood_disease_title LIKE '" . $args['childhood_disease_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_childhood_disease WHERE childhood_disease_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_deficiencies($args = array()) {

        $condition = "";

        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }

        if (isset($args['deficiencies_title'])) {

            $condition .= "AND deficiencies_title LIKE '" . $args['deficiencies_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_deficiencies WHERE deficiencies_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_skin_condition($args = array()) {

        $condition = "";

        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }
        if (isset($args['skin_condition_title'])) {

            $condition .= "AND skin_condition_title LIKE '" . $args['skin_condition_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_skin_condition WHERE skin_condition_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_orthopedics($args = array()) {

        $condition = "";

        if (isset($args['orthopedics_title'])) {

            $condition .= "AND orthopedics_title LIKE '" . $args['orthopedics_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_orthopedics WHERE orthopedics_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_diagnosis($args = array()) {
        $condition = "";
        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }


        if (isset($args['diagnosis_title'])) {

            $condition .= "AND diagnosis_title LIKE '" . $args['diagnosis_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_diagnosis WHERE diagnosis_isdeleted='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_normal_checkbox($args = array()) {

        $condition = "";

        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }

        if (isset($args['normal_checkbox_title'])) {

            $condition .= "AND normal_checkbox_title LIKE '" . $args['normal_checkbox_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_normal_checkbox WHERE normal_checkbox_isdeleted ='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_opthalmological($args = array()) {

        $condition = "";
        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }

        if (isset($args['opthalmological_title'])) {

            $condition .= "AND opthalmological_title LIKE '" . $args['opthalmological_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_opthalmological WHERE opthalmological_isdeleted ='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_auditary($args = array()) {


        $condition = "";
        if (isset($args['id'])) {
            $id_nums = implode(",", $args['id']);
            $condition .= "AND id IN ($id_nums)";
        }

        if (isset($args['auditary_title'])) {

            $condition .= "AND auditary_title LIKE '" . $args['auditary_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_auditary WHERE auditary_isdeleted ='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_tests($args = array()) {

        $condition = "";

        if (isset($args['test_id'])) {

            $condition .= "AND id = '" . $args['test_id'] . "'";
        }
        if (isset($args['test_title'])) {

            $condition .= "AND test_title LIKE '" . $args['test_title'] . "'";
        }

        $sql = "SELECT * FROM ems_mas_tests WHERE test_isdeleted ='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_drugs($args = array()) {

        $condition = "";

        if (isset($args['drug_id'])) {

            $condition .= "AND id = '" . $args['drug_id'] . "'";
        }

        if (isset($args['drug_title'])) {
            $condition .= "AND drug_title LIKE '%" . $args['drug_title'] . "%'";
        }


        $sql = "SELECT * FROM ems_mas_drug_list WHERE drug_isdeleted ='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_mas_diagonosis($args = array()) {

        $condition = "";

        if (isset($args['diagnosis_id'])) {

            $condition .= "AND id = '" . $args['diagnosis_id'] . "'";
        }


        if (isset($args['diagnosis_title'])) {

            $condition .= "AND diagnosis_title LIKE '%" . $args['diagnosis_title'] . "%'";
        }

        $sql = "SELECT * FROM ems_mas_diagnosis_code WHERE diagnosis_isdeleted ='0' $condition";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_zone($args = array()) {

        $condition = "";

        if (trim($args['term']) != '') {

            $condition .= " AND zn.zone_name LIKE'" . trim($args['term']) . "%' ";
        }

         $sql = "SELECT * FROM ems_mas_zone as zn WHERE isdeleted ='0' $condition"; 

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_replace_ambulance_dropdown($args = array(), $limit = '', $offset = '') {

        if (trim($args['term']) != '') {

            $condition .= " AND amb.amb_rto_register_no  LIKE '%" . trim($args['term']) . "%' ";
        }

         $sql = "SELECT amb.*"
            . " FROM $this->tbl_amb as amb "
            . "Where ambis_deleted = '0' $condition $oby $lim_off";


        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function  get_incident_odometer($args = array()) {

      
        if (trim($args['term']) != '') {

            $condition .= " AND amb.inc_ref_id  LIKE '%" . trim($args['term']) . "%' ";
        }

         $sql = "SELECT amb.* FROM ems_incidence as amb ". "Where inc_pcr_status = '1' $condition ";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
     function get_incident_replacement_amb($args = array()) {
        $sql = "SELECT amb.* FROM ems_incidence_ambulance as amb " . "Where amb_rto_register_no ='". $args['amb_id']."'   and inc_ref_id in (SELECT inc_ref_id from ems_incidence Where inc_pcr_status = '0' ) ";
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
      function  get_incident_odometer_amb($args = array()) {

        if (trim($args['term']) != '') {

            $condition .= " AND amb.inc_ref_id  LIKE '%" . trim($args['term']) . "%' ";
        }

        $sql = "SELECT amb.* FROM ems_epcr as amb " . "Where amb_reg_id ='".$args['amb_id']."'  AND amb.epcris_deleted='0' and inc_ref_id in (SELECT inc_ref_id from ems_incidence  WHERE inc_pcr_status = '1')  $condition GROUP by amb.inc_ref_id order by amb.inc_ref_id DESC limit 1 ";
      //$sql = "SELECT amb.* FROM ems_epcr as amb " . "Where amb_reg_id ='".$args['amb_id']."'  AND amb.is_deleted='0' and inc_ref_id in (SELECT inc_ref_id from ems_incidence Where inc_pcr_status = '1' )  $condition GROUP by inc_ref_id ";
//    echo $sql;
       $result = $this->db->query($sql);
      
        if ($result) {

            return $result->result();

        } else {
            
            return false;
        }
    }
    function get_ward($args = array(), $limit = '', $offset = '') {

        $lim_off = "";

        if ($limit > 0 && $offset >= 0) {

            $lim_off = " limit $limit offset $offset ";
        }


        if (isset($args['ward_id'])) {

            $condition .= "AND wrd.ward_id='" . $args['ward_id'] . "'";
        }

      

        if (isset($args['dist_code'])) {

            $condition .= "AND wrd.wrd_district='" . $args['dist_code'] . "'";
        }


        if (trim($args['term']) != "") {

            $condition .= " AND wrd.ward_name like '" . $args['term'] . "%' ";
        }


        $sql = "SELECT wrd.* "
            . "FROM ems_mas_ward as wrd "
            . "Where wrd.isdeleted = '0' $condition ORDER BY wrd.ward_name ASC $lim_off";


        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }

    }
    function get_hospital($args){
        $this->db->select('*');
        $this->db->from("ems_hospital");
        $this->db->where("hp_id", $args);
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function get_B12_data($args = array()){
        $this->db->select('*');
        $this->db->from($this->tbl_upload_b12_data);
        if(!empty($args)){
                 $this->db->where($args);
        }
        $this->db->order_by('B12_Type');
        $data = $this->db->get();
        //echo $this->db->last_query();
       // die;
       
        $result = $data->result();
        return $result;
    }
      function get_district_wise_offroad($args = array()){
          $current_date = $args['from_date'];
          
        $this->db->select('*');
        $this->db->from($this->tbl_district_wise_offroad);
        
        if(!empty($args)){
            //$this->db->where('added_date',$current_date);
            $this->db->where( " (added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59')", NULL, FALSE );
           
        }
         if ($args['select_time']) {
            $this->db->where('select_time', $args['select_time']);
         }
        $this->db->order_by('id');
        $data = $this->db->get();
           
        $result = $data->result();
        return $result;
    }
    function get_district_wise_offroad_last($args = array()){
          $current_date = $args['from_date'];
          
        $this->db->select('*');
        $this->db->from($this->tbl_district_wise_offroad);
        $this->db->order_by('id' ,'ASC');
        $this->db->limit('36' ,'0');
        $data = $this->db->get();
      
           
        $result = $data->result();
        return $result;
    }
    function get_district_wise_offroad_mapcount($args = array()){
        $current_date = $args['from_date'];
        
      $this->db->select('*');
      $this->db->from($this->tbl_district_wise_offroad);
      
      if(!empty($args)){
          //$this->db->where('added_date',$current_date);
          $this->db->where( " district_name='total' AND (added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59')", NULL, FALSE );
      }
       if ($args['select_time']) {
            $this->db->where('select_time', $args['select_time']);
        }
      $this->db->order_by('id');
      $data = $this->db->get();
      //echo $this->db->last_query();
      //die;
     
      $result = $data->result();
      return $result;
  }
    function get_offroad_details($args = array()){
        $current_date = $args['from_date'];
        $this->db->select('*');
        $this->db->from($this->tbl_offroad_details);
        if(!empty($args)){
                // $this->db->where($args);
                $this->db->where( "added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59'", NULL, FALSE );
        }
         if ($args['select_time']) {
            $this->db->where('select_time', $args['select_time']);
        }
        $this->db->order_by('id');
        $data = $this->db->get();
       // echo $this->db->last_query();
        //die;
       
        $result = $data->result();
        return $result;
    }
    public function get_main_dash_data($args = array())
    {   
        $current_date = $args['from_date'];
        $data=$this->db->query("SELECT * FROM `ems_dash_data` WHERE updated_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59';");
        //echo $this->db->last_query(); die;
        if($data->num_rows()){
            return $data->result();
        }else{
            return 0;
        }

    }
    public function get_onroad_count($args = array())
    {   
        $current_date = $args['from_date'];
        $condition = "";
        
        if($args['select_time'] != ''){
            $select_time = $args['select_time'];
            $condition = " AND select_time = '$select_time'";
        }
        $data=$this->db->query("SELECT COUNT(amb_number) as count FROM `ems_onroad_details` WHERE added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59' $condition;");
       // echo $this->db->last_query(); die;
        if($data->num_rows()){
            return $data->result();
        }else{
            return 0;
        }

    }
    public function get_offroad_count($args = array())
    {   
        $current_date = $args['from_date'];
         if($args['select_time'] != ''){
            $select_time = $args['select_time'];
            $condition = " AND select_time = '$select_time'";
        }
        
        $data=$this->db->query("SELECT COUNT(amb_number) as count FROM `ems_offroad_details` WHERE added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59' $condition;");
        // echo $this->db->last_query(); die;
        if($data->num_rows()){
            return $data->result();
        }else{
            return 0;
        }

    }
    function get_onroad_details($args = array()){
        $current_date = $args['from_date'];
        $this->db->select('*');
        $this->db->from($this->tbl_onroad_details);
        if(!empty($args)){
                 //$this->db->where($args);
                 $this->db->where( "added_date BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59'", NULL, FALSE );
        }
        if ($args['select_time']) {
            $this->db->where('select_time', $args['select_time']);
        }
        $this->db->order_by('id');
        $data = $this->db->get();
     //   echo $this->db->last_query();
    //    die;
       
        $result = $data->result();
        return $result;
        
    }

    function get_nonnetwork_details(){
        $sql = "SELECT * FROM ems_nonnetwork_details ORDER BY 'id'" ;
        //    echo $sql;
        //    die();
        $result = $this->db->query($sql);
        return $result->result();
    }
      function insert_report_tracking($args = array()) {

        $res = $this->db->insert('ems_report_download_track', $args);
       


        return $res;
    }
        function get_purpose_of_calls($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_call_purpose");

        if (trim($args['pcode']) != "") {
            $this->db->where("$this->tbl_mas_call_purpose.pcode", $args['pcode']);
        }
        if (trim($args['p_parent']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.p_parent", $args['p_parent']);
        }
         if (trim($args['p_systen']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.p_systen", $args['p_systen']);
        }


         $this->db->order_by('pname');

        $data = $this->db->get();
        
//        echo $this->db->last_query();
//        die();

        $result = $data->result();
     

        return $result;
    }
    function get_realtime_offroad(){

    $sql = "SELECT onamb.mt_district_id,onamb.mt_amb_no,onamb.mt_base_loc,ambt.ambt_id
            FROM ems_amb_onroad_offroad as onamb 
            LEFT JOIN ems_mas_ambulance_type as ambt on onamb.amb_type=ambt.ambt_id
            WHERE DATE(onamb.mt_offroad_datetime)=CURDATE()" ;
        // echo $sql;
        //   die();
        $result = $this->db->query($sql);
        return $result->result();
    }
    function get_biodata_critical(){
        $sql = "SELECT * FROM ems_biodata_critical" ;
             // echo $sql;
             //   die();
             $result = $this->db->query($sql);
             return $result->result();

    }
    function get_biodata_major(){
        $sql = "SELECT * FROM ems_biodata_major" ;
             // echo $sql;
             //   die();
             $result = $this->db->query($sql);
             return $result->result();

    }
    function get_biodata_minor(){
        $sql = "SELECT * FROM ems_biodata_minor" ;
             // echo $sql;
             //   die();
             $result = $this->db->query($sql);
             return $result->result();

    }
    function get_opt_details(){
        $sql = "SELECT clg_mobile_no FROM ems_colleague
                WHERE `clg_group` IN('UG-Pilot','UG-EMT') AND clg_is_deleted='0' AND clg_is_active= '1'AND thirdparty='1'" ;
             // echo $sql;
             //   die();
             $result = $this->db->query($sql);
             return $result->result();
    }

    function get_data_bynumber($args = array()){
        $condition ='';
        if ($args['clg_mobile_no'] != '') {

            $condition .= " AND clg_mobile_no IN ('" . $args['clg_mobile_no'] . "')  ";
       }

        $sql ="SELECT clg_ref_id,clg_group,clg_group,clg_first_name,clg_mid_name,clg_last_name,clg_mobile_no,clg_is_deleted,otp,thirdparty 
        FROM `ems_colleague` 
        WHERE `clg_group` IN('UG-Pilot','UG-EMT') AND clg_is_deleted='0'AND clg_is_active= '1' AND thirdparty='1' $condition";
            $result = $this->db->query($sql);
            // echo $this->db->last_query(); die;
            return $result->result();
    }
    // function amb_realtime_status(){

    //     $sql = "SELECT amb.amb_rto_register_no,hos.hp_id,hos.hpname,hos.hp_district,hos.hp_status,hos.hpis_deleted,hos.thirdparty
    //             amb.amb_type
    //             FROM ems_hospital as hos 
    //             LEFT JOIN ems_ambulance as amb on hos.hp_id=amb.amb_base_location
    //             WHERE hos.thirdparty='1' AND hos.hpis_deleted='0' DATE(onamb.mt_offroad_datetime)=CURDATE()" ;
    //         // echo $sql;
    //         //   die();
    //         $result = $this->db->query($sql);
    //         return $result->result();
    //     }
    // function get_realtime_offroad(){

    //     $sql = "SELECT onamb.mt_district_id,onamb.mt_amb_no,onamb.mt_base_loc,ambt.ambt_id
    //         FROM ems_amb_onroad_offroad as onamb 
    //         LEFT JOIN ems_mas_ambulance_type as ambt on onamb.amb_type=ambt.ambt_id
    //         WHERE DATE(onamb.mt_offroad_datetime)=CURDATE()" ;
    //     // echo $sql;
    //     //   die();
    //     $result = $this->db->query($sql);
    //     return $result->result();
    // }
}
