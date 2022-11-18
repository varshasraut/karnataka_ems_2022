<?php

class Colleagues_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();



        $this->load->helper('date');

        $this->load->database();



        $this->tbl_ero_users_status = $this->db->dbprefix('ero_users_status');
        $this->tbl_mas_groups = $this->db->dbprefix('mas_groups');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->clg_logins = $this->db->dbprefix('clg_logins');


        $this->tbl_country = $this->db->dbprefix('country');

        $this->tbl_state = $this->db->dbprefix('state');

        $this->tbl_city = $this->db->dbprefix('city');

        $this->tbl_districts = $this->db->dbprefix('mas_districts');

        $this->tbl_report = $this->db->dbprefix('report');

        $this->tbl_sessions = $this->db->dbprefix('sessions');

        $this->tbl_clg_sales_commission = $this->db->dbprefix('clg_sales_commission');

        $this->tbl_stores = $this->db->dbprefix('stores');
        $this->tbl_standard_break = $this->db->dbprefix('standard_break');
        $this->tbl_notice_remark = $this->db->dbprefix('notice_remark');
        $this->tbl_clg_notice_rem = $this->db->dbprefix('clg_notice_rem');
    }

    function get_groups($ugcode = '', $uglevel = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_groups");

        if ($ugcode != '') {

            $this->db->where("$this->tbl_mas_groups.gcode", $ugcode);
        } else {

            $this->db->where("$this->tbl_mas_groups.is_deleted", '0');
        }

        if ($uglevel != '') {
            $this->db->where("$this->tbl_mas_groups.g_type_level >=", $uglevel);
        }


        $data = $this->db->get();


        $result = $data->result();


        return $result;
    }

    function get_higher_groups($ugcode = '', $uglevel = '') {

        $sql = "SELECT * FROM $this->tbl_mas_groups as mas where mas.g_type_level <'" . $uglevel . "' ORDER BY g_type_level DESC LIMIT 1";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function add_group($group_name, $gcode, $glevel, $status, $is_deleted) {



        $result = $this->db->query("INSERT INTO $this->tbl_mas_groups(`ugname`,`gcode`,`glevel`,`status`,`is_deleted`) VALUES('" . $group_name . "','" . $gcode . "','" . $glevel . "','" . $status . "','" . $is_deleted . "') ON DUPLICATE KEY UPDATE `ugname`='" . $group_name . "',`is_deleted`='" . $is_deleted . "',`status`='" . $status . "'");


        if ($result) {

            return true;
        } else {

            return false;
        }
    }

    function edit_group($group_id = '', $gcode = '', $status = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_groups");

        if ($status != '') {
            $this->db->where("$this->tbl_mas_groups.status ='" . $status . "'");
            $this->db->where("$this->tbl_mas_groups.gcode ='" . $gcode . "'");
            $this->db->where("$this->tbl_mas_groups.is_deleted ='0'");
        } else {
            $this->db->where("$this->tbl_mas_groups.gid ='" . $group_id . "'");
        }


        $data = $this->db->get();

        $result = $data->result();


        return $result;
    }

    function update_group($user_group, $group_id) {


        $whr_array = array("$this->tbl_mas_groups.gid " => $group_id,
            "$this->tbl_mas_groups.glevel != " => 'primary');


        $this->db->where($whr_array);

        $data = $this->db->update("$this->tbl_mas_groups", $user_group);

        return $data;
    }

    function update_groups_status($gid, $status) {



        $this->db->where_in('gid', $gid);

        $data = $this->db->update("$this->tbl_mas_groups", $status);

        return $data;
    }

    function delete_groups($group_id, $is_delete) {



        $this->db->where_in('gid', $group_id);

        $data = $this->db->update("$this->tbl_mas_groups", $is_delete);

        return $data;
    }

    function logged_in_clgs_list() {

        $result = $this->db->query("SELECT * FROM $this->tbl_sessions as session WHERE session.usr_type='clg'");


        return $result->result();
    }
    
    function logged_in_clgs() {

       
        $condition = '';

        if (trim($ref_id) != '') {
            $condition .= "AND colleague.clg_ref_id='" . $ref_id . "'";
        }
        
        ($offset !== null && $limit != null) ? $base_query = " LIMIT " . $offset . ", " . $limit : "";

        $result1 = $this->db->query("SELECT colleague.*,dis.*"
            . "FROM `$this->tbl_colleague` AS colleague "
            . "LEFT JOIN `$this->tbl_districts` AS dis "
            . "ON ( dis.dst_code = colleague.clg_district_id ) "
            . "WHERE colleague.clg_is_deleted ='0' AND colleague.clg_is_login IN ('yes','break') $condition $base_query");


        $result = $result1->result();

        return $result;
    }

    function get_user_info($ref_id = "") {


        $condition = '';

        if (trim($ref_id) != '') {
            $condition .= "AND colleague.clg_ref_id='" . $ref_id . "'";
        }

//    $result1 = $this->db->query("SELECT colleague.* , city.city_name, groups.ugname "
//
//               . "FROM `$this->tbl_colleague` AS colleague "
//
//               . "LEFT JOIN `$this->tbl_city` AS city "
//
//               . "ON ( city.city_id = colleague.clg_city ) "
//
//               . "LEFT JOIN `$this->tbl_mas_groups` AS groups "
//
//               . "ON ( groups.gcode = colleague.clg_group ) "
//
//               . "WHERE colleague.clg_ref_id ='".$ref_id."'");
        $result1 = $this->db->query("SELECT third_party.thirdparty_name,colleague.*,dis.*,zn.div_name as zone_name "
            . "FROM `$this->tbl_colleague` AS colleague "
            . "LEFT JOIN `$this->tbl_districts` AS dis "
            . "ON ( dis.dst_code = colleague.clg_district_id ) "
            . " LEFT JOIN `ems_mas_division` as zn "
            . " ON ( zn.div_code = colleague.clg_zone ) "
            . " LEFT JOIN `ems_mas_thirdparty` as third_party "
            . " ON ( third_party.thirdparty_id = colleague.thirdparty ) "
//   . "LEFT JOIN `$this->tbl_mas_groups` AS groups "
//  . "ON ( groups.gcode = colleague.clg_group ) "
            . "WHERE colleague.clg_is_deleted ='0' $condition");


        $result = $result1->result();
       // echo $this->db->last_query();
       // die();
        return $result;
    }

    function load_otp($ref_id, $otp, $timestamp) {



        $result = $this->db->query("UPDATE $this->tbl_colleague as colleague "
            . "SET colleague.clg_otp ='" . $otp . "', colleague.clg_otp_time='" . $timestamp . "' "
            . "WHERE colleague.clg_ref_id='" . $ref_id . "'");



        if ($this->db->affected_rows() == 1) {

            return true;
        } else {



            return false;
        }
    }

    function check_otp($ref_id, $otp) {



        $result1 = $this->db->query("SELECT * FROM $this->tbl_colleague as colleague "
            . "WHERE colleague.clg_ref_id='" . $ref_id . "' "
            . "AND colleague.clg_otp = '" . $otp . "' "
            . "AND colleague.clg_otp_time > " . now() . " - 600");



        $result = $result1->result();



        if (!count($result) == 1) {



            return false;
        } else {



            return $result;
        }
    }

    function check_password($ref_id, $password) {



        $this->db->select('*');

        $this->db->from("$this->tbl_colleague as colleague");

       // $this->db->where(array('colleague.clg_ref_id' => $ref_id, 'colleague.clg_password' => $password, 'colleague.clg_group' => $user_group, 'colleague.clg_is_active' => 1, 'colleague.clg_is_deleted' => '0'));
        
        $this->db->where(array('colleague.clg_ref_id' => $ref_id, 'colleague.clg_password' => $password, 'colleague.clg_is_active' => 1, 'colleague.clg_is_deleted' => '0'));

        $data = $this->db->get();


        $result = $data->result();

        if (!count($result) == 1) {



            return false;
        } else {



            return $result;
        }
    }
    
    function check_mobile_exist( $mobile_no='' ){

        $this->db->select('*');

        $this->db->from("$this->tbl_colleague as colleague");
  
        $this->db->where(array('colleague.clg_mobile_no' => $mobile_no, 'colleague.clg_is_active' => 1, 'colleague.clg_is_deleted' => '0'));

        $data = $this->db->get();

        $result = $data->result();
      

        if (!count($result) == 1) {
            return false;
        } else {
            return $result;
        }
    }

    function update_clg_field($ref_id, $column_name, $value) {


        $result = $this->db->query("UPDATE $this->tbl_colleague as colleague SET colleague." . $column_name . "='" . $value . "' "
            . "WHERE colleague.clg_ref_id ='" . $ref_id . "'");
         // if($_SERVER['REMOTE_ADDR'] == '49.35.206.243'){
                    //   echo $this->db->last_query();
          //          }
      
        //die();

        return $result;
    }

    function update_session_fields($session_id, $usr_ref_id, $usr_type) {



        $result = $this->db->query("UPDATE $this->tbl_sessions as session "
            . "SET session.usr_ref_id='" . $usr_ref_id . "',session.usr_type='" . $usr_type . "' "
            . "WHERE session.id='" . $session_id . "'");



        return $result;
    }

    function delete_user_session($ref_id) {

        $result = $this->db->query("DELETE FROM $this->tbl_sessions WHERE `usr_ref_id`='" . $ref_id . "'");

        return $result;
    }

    function get_countries() {

        $this->db->select('*');

        $this->db->from("$this->tbl_country");

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_all_states() {

        $this->db->select('*');

        $this->db->from("$this->tbl_state");

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_all_cities() {

        $this->db->select('*');

        $this->db->from("$this->tbl_city");

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function clg_register($data = array()) {

        $this->db->select('*');

        $this->db->from("$this->tbl_colleague as colleague");

        $this->db->where("colleague.clg_ref_id ='" . $data['clg_ref_id'] . "'");

        $fetched = $this->db->get();

        $present = $fetched->result();


        if (count($present) == 0) {

            $result = $this->db->insert($this->tbl_colleague, $data);
            //echo $this->db->last_query();
            //die();

            if ($result) {

                return $result;
            } else {
                return false;
            }
        } else {


            return "duplicate";
        }
    }

//    function get_colleagues_count($args=array()) {
//
//    $condition="";
//    
//
//    
//    if($args['clg_group']!='')
//    {
//        $condition.=" and clg_group='".$args['clg_group']."'";
//    }
//    
//    if($args['search']!='')
//    {
//         $condition.=" and  colleague.clg_first_name like '%".$args['search']."%'  ";
//    }
//
// 
//    $count = $this->db->count_all("$this->tbl_colleague as colleague WHERE colleague.clg_is_deleted= '0' $condition");
//    
//    return $count;
//
//}



    function get_all_colleagues($args = array(), $offset = null, $limit = null) {


// var_dump($args);die;

//        $base_query = "SELECT colleague.* ,status.status ,groups.ugname "
//            . "FROM $this->tbl_colleague AS colleague "
//            //. "LEFT JOIN $this->tbl_mas_groups AS groups "
//            //. "ON ( groups.gcode = colleague.clg_group ) "
//            . "LEFT JOIN $this->tbl_ero_users_status AS status "
//            . "ON ( status.user_ref_id = colleague.clg_ref_id ) "
//            . "WHERE colleague.clg_is_deleted='0' ";

        $condition = '';
        $left_join = '';
    if($args['status'] != ''){
        $status = $args['status'];
       
        
//        $current_date =date('Y-m-d H:i:s');
//        $newdate =  date("Y-m-d H:i:s", (strtotime ('-5 minute' , strtotime ($current_date)))) ;
//        $left_join =  "LEFT JOIN ems_avaya_incoming_call AS incoming ON ( incoming.agent_no = colleague.clg_avaya_agentid AND incoming.call_datetime > '$newdate' ) ";
//        if($status == 'atnd'){
//        $condition .= " AND incoming.status = 'C'";
//        }else{
//            $condition .= " AND incoming.status != 'C'";
//        }
         $condition .= " AND status.status = '$status'";
    }
                $base_query = "SELECT colleague.* ,status.added_date as logintime,status.status,status.brk_time ,groups1.ugname ,break_details.break_name "
            . "FROM $this->tbl_colleague AS colleague "
            . "LEFT JOIN $this->tbl_mas_groups AS groups1 "
            . "ON ( groups1.gcode = colleague.clg_group ) "
            . "LEFT JOIN $this->tbl_ero_users_status AS status "
            . "ON ( status.user_ref_id = colleague.clg_ref_id ) "
            //. "LEFT JOIN ems_clg_break_summary AS brk_type "
            //. "ON ( brk_type.clg_ref_id = colleague.clg_ref_id ) "
            . "LEFT JOIN ems_standard_break AS break_details "
            . "ON ( break_details.break_id = status.brktype ) "
            . $left_join
            . "WHERE colleague.clg_is_deleted='0' ";
        ($args['clg_ref_id'] != '' && $args['clg_ref_id'] != 'all') ? $base_query .= " and clg_ref_id IN ('" . $args['clg_ref_id'] . "') " : "";
        ($args['clg_group'] != '') ? $base_query .= " and clg_group IN ('" . $args['clg_group'] . "') " : "";
        if($args['group_code']=='Team_Lead'){
            ($args['group_code'] != '') ? $base_query .= " and clg_group IN ('UG-DCOSupervisor','UG-EROSupervisor','UG-ERCTRAINING') " : "";
        }else if($args['group_code'] == 'feedback'){
            ($args['group_code'] != '') ? $base_query .= " and clg_group IN ('UG-Feedback') " : "";
        }else if($args['group_code'] == 'Manager'){
            ($args['group_code'] != '') ? $base_query .= " and clg_group IN ('UG-ERCManager','UG-ShiftManager','UG-QualityManager','UG-BioMedicalManager','UG-ERCPSupervisor') " : "";
        }else{
            ($args['group_code'] != '') ? $base_query .= " and clg_group IN ('" . $args['group_code'] . "') " : "";
        }
        
        
        ($args['district_id_clg'] != '') ? $base_query .= " and clg_district_id LIKE '%" . $args['district_id_clg'] . "%' " : "";
        
        
        ($args['team_type'] != '') ? $base_query .= " and clg_group IN ('" . $args['team_type'] . "') " : "";

        ($args['clg_status'] != '') ? $base_query .= " and clg_is_active='" . $args['clg_status'] . "' " : "";
         //($args['thirdparty'] != '') ? $base_query .= " and thirdparty='" . $args['thirdparty'] . "' " : "";
        if(is_array($args['clg_is_login'] )){
            $clg_is_login = implode("','",$args['clg_is_login']);
            //var_dump($clg_is_login);
            ($clg_is_login != '') ? $base_query .= " and clg_is_login  IN ('" . $clg_is_login . "')" : "";
        }else{
        ($args['clg_is_login'] != '') ? $base_query .= " and clg_is_login  = '" . $args['clg_is_login'] . "'" : "";
        }
         	 

        if($args['search'] != ''){ 
            $base_query .= " and  (colleague.clg_first_name like '%" . trim($args['search']) . "%' OR  colleague.clg_last_name like '%" . trim($args['search']) . "%'   OR  colleague.clg_ref_id like '%" . trim($args['search']) . "%' OR  colleague.clg_mobile_no like '%" . trim($args['search']) . "%' OR  colleague.clg_avaya_id like '%" . trim($args['search']) . "%' OR  colleague.clg_group like '%" . trim($args['search']) . "%' OR  colleague.clg_email like '%" . trim($args['search']) . "%' OR  CONCAT(colleague.clg_first_name,' ',colleague.clg_last_name)  like '%" . trim($args['search']) . "%')" ;
        } 
        //? $base_query .= " and  colleague.clg_first_name like '%" . trim($args['search']) . "%'  " : "";

        $base_query = $base_query.' '.$condition;
        ($args['column_name'] != '') ? $base_query .= "ORDER BY colleague." . $args['column_name'] . " " . $args['order_type'] : "";
        ($offset !== null && $limit != null) ? $base_query .= " LIMIT " . $offset . ", " . $limit : "";

        //$base_query = $base_query.' '.$condition;
       //echo $base_query;
         //die();
        $result = $this->db->query($base_query);



        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function clg_update_data($new_data = array()) {


        $this->db->where_in('clg_ref_id', $new_data['clg_ref_id']);

        $data = $this->db->update($this->tbl_colleague, $new_data);
        //echo $this->db->last_query();die;
        return $data;
    }

    function delete_colleague($ref_ids = array(), $delete_status = '') {


        $this->db->where_in('clg_ref_id', $ref_ids);

        $data = $this->db->update("$this->tbl_colleague", $delete_status);


        return $data;
    }

    function block_colleague($ref_ids = array(), $data = array()) {

        $this->db->where_in('clg_ref_id', $ref_ids);

        $data = $this->db->update("$this->tbl_colleague", $data);

        return $data;
    }

    function update_clg_status($clg_ref_id, $args = array()) {


// $clg_is_active = $args['clg_is_active'];

        if (isset($clg_ref_id)) {
            $this->db->where_in('clg_ref_id', $clg_ref_id, 'clg_is_active', $args['clg_is_active']);
            $update = $this->db->update("$this->tbl_colleague", $args);


//           echo $this->db->last_query();die;

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function unblock_colleague($ref_ids = array(), $data = array()) {

        $this->db->where_in('clg_ref_id', $ref_ids);

        $data = $this->db->update("$this->tbl_colleague", $data);

        return $data;
    }

    function change_password($ref_id, $password) {

        $this->db->select('*');

        $this->db->from("$this->tbl_colleague as colleague");

        $this->db->where("colleague.clg_ref_id ='" . $ref_id . "'");

        $fetched = $this->db->get();

        $present = $fetched->result();

        if (!$present) {
            return FALSE;
        } else {

            $result = $this->db->query("UPDATE $this->tbl_colleague as colleague SET colleague.clg_password='" . $password . "' "
                . "WHERE colleague.clg_ref_id ='" . $ref_id . "'");



            return $result;
        }
    }

    function search_clg($search_str, $filter = '') {

        $pattern = '/\s+/';

        $search_regex = preg_replace($pattern, "|", $search_str);

        $search_regex = trim($search_regex, "|");


        $base_query1 = "SELECT colleague.* , city.city_name, groups.ugname "
            . "FROM `$this->tbl_colleague` AS colleague "
            . "LEFT JOIN `$this->tbl_city` AS city "
            . "ON ( city.city_id = colleague.clg_city ) "
            . "LEFT JOIN `$this->tbl_mas_groups` AS groups "
            . "ON ( groups.gcode = colleague.clg_group ) "
            . "WHERE ";


        $base_query2 = "(colleague.clg_ref_id REGEXP '" . $search_regex . "' "
            . "OR colleague.clg_group REGEXP '" . $search_regex . "' "
            . "OR colleague.clg_first_name REGEXP '" . $search_regex . "' "
            . "OR colleague.clg_last_name REGEXP '" . $search_regex . "' "
            . "OR colleague.clg_address REGEXP '" . $search_regex . "' "
            . "OR city.city_name REGEXP '" . $search_regex . "' "
            . "OR colleague.clg_email REGEXP '" . $search_regex . "') and  colleague.clg_is_deleted != '1'";

        if ($filter != '') {
            $fetched = $this->db->query($base_query1 . $base_query2 . " AND colleague.clg_group='" . $filter . "' ");
        } else {
            $fetched = $this->db->query($base_query1 . $base_query2);
        }


        $present = $fetched->result();

        if (!$present) {
            return false;
        } else {
            return $present;
        }
    }

    function check_colleague_mail($email = '') {



        $result = $this->db->query("SELECT clg_ref_id,clg_email FROM $this->tbl_colleague WHERE clg_email='" . $email . "'");

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

        function get_collegue_extension($agent = '') {



        $result = $this->db->query("SELECT clg_avaya_extension FROM $this->tbl_colleague WHERE clg_avaya_agentid='" . $agent . "'");
      

        $result = $result->result();

        return $result;
    }

    function insert_report($args = array()) {

        $result = $this->db->insert($this->tbl_report, $args);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    function insert_login_count($args = array()) {

        $result = $this->db->insert('ems_login_attemp_history', $args);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    
    function get_login_count($args = array()) {

        $condition = "";


        if (isset($args['ip_address']) && $args['ip_address'] != "") {
            $condition .= " AND ip_address='" . $args['ip_address'] . "'";
        }
        
         if (isset($args['login_try_date']) && $args['login_try_date'] != "") {
            $start_timestamp = strtotime($args['login_try_date']);
            $start = date('Y-m-d H:i:s', strtotime("-5 minutes",$start_timestamp));
            $end = $args['login_try_date'];
             
            $condition .= " and login_try_date  between '$start' and  '$end' ";
        }



        $result = $this->db->query("SELECT * FROM ems_login_attemp_history as log_attemp where 1=1 $condition ");

 //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function update_login_count($args = array()) {

        if ($args['id']) {

            $this->db->where('id', $args['id']);
            $update = $this->db->update('ems_login_attemp_history', $args);

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function insert_avaya_history($args = array()) {

        $result = $this->db->insert('ems_avaya_ext_login_history', $args);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    function get_report($args = array(), $offset = "", $limit = "") {

        $limit_offset = "";
        $condition = "";

        if (isset($args['select_users']) && $args['select_users'] != "") {
            $condition .= "AND report.clg_ref_id='" . $args['select_users'] . "'";
        }
        if (isset($args['current_date'])) {
            $condition .= "AND date_of_report='" . $args['current_date'] . "'";
        }

        if (isset($args['report_id']) && $args['report_id'] != "") {
            $condition .= "AND report.report_id='" . $args['report_id'] . "'";
        }

        if (isset($args['clg_ref_id']) && $args['clg_ref_id'] != "") {
            $condition .= " AND report.clg_ref_id='" . $args['clg_ref_id'] . "'";
        }

        if (@$args['week'] != '') {

            $startend = unserialize(base64_decode($args['week']));
            $start = $startend['start'];
            $end = $startend['end'];

            $condition .= " and date_of_report between '$start%' and  '$end%' ";
        }

        if (@$args['day'] != '') {

            $day = $args['day'];
            $condition .= " and date_of_report LIKE CONCAT('%',\"$day\",'%') ";
        }

        if (@$args['month'] != '') {

            $end = (date('Y-m-t 12:59:59', strtotime($args['month'])));
            $start = (date('Y-m-01 00:00:00', strtotime($args['month'])));
            $condition .= " and date_of_report between '$start' and  '$end' ";
        }

        if (@$args['year'] != '') {

            $strtotime = "December" . $args['year'];
            $end = (date('Y-12-31 12:59:59', strtotime($strtotime)));
            $start = (date('Y-01-01 00:00:00', strtotime($strtotime)));
            $condition .= " and date_of_report between '$start' and  '$end' ";
        }

        if ($offset >= 0 && $limit > 0) {
            $limit_offset = "LIMIT $limit OFFSET $offset ";
        }


        $result = $this->db->query("SELECT report.*,clg.clg_first_name,clg.clg_last_name,clg.clg_group FROM $this->tbl_report as report left join $this->tbl_colleague as clg on(clg.clg_ref_id=report.clg_ref_id) where report.report_delete_status=0 $condition $limit_offset");

//  echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_report_perticular_date($args = array(), $offset = "", $limit = "") {

        $limit_offset = "";
        $condition = "";
        $report_delete_status = 1;

        if (isset($args['user_type'])) {
            $condition .= " and medical_store_name like'\"%" . $args['user_type'] . "%\"' ";
        }

        if (isset($args['distance_from'])) {
            $condition .= "or report_delete_status='" . $report_delete_status . "'";
        }

        if (isset($args['edit'])) {
            $condition .= " or report.report_delete_status='" . $report_delete_status . "'";
        }
        if (isset($args['select_users'])) {
            $condition .= "AND report.report_id='" . $args['select_users'] . "'";
        }
        if (isset($args['current_date'])) {
            $condition .= "AND report.date_of_report='" . $args['current_date'] . "'";
        }

        if (isset($args['clg_ref_id'])) {
            $condition .= " AND report.clg_ref_id='" . $args['clg_ref_id'] . "'";
        }


        if (@$args['week'] != '') {

            $startend = unserialize(base64_decode($args['week']));
            $start = $startend['start'];
            $end = $startend['end'];
            $condition .= " and report.date_of_report between '$start%' and  '$end%' ";
        }
        if (@$args['day'] != '') {

            $day = $args['day'];
            $condition .= " and report.date_of_report LIKE CONCAT('%',\"$day\",'%') ";
        }

        if (@$args['month'] != '') {

            $end = (date('Y-m-t 12:59:59', strtotime($args['month'])));
            $start = (date('Y-m-01 00:00:00', strtotime($args['month'])));
            $condition .= " and report.date_of_report between '$start' and  '$end' ";
        }

        if (@$args['year'] != '') {

            $strtotime = "December" . $args['year'];
            $end = (date('Y-12-31 12:59:59', strtotime($strtotime)));
            $start = (date('Y-01-01 00:00:00', strtotime($strtotime)));
            $condition .= " and report.date_of_report between '$start' and  '$end' ";
        }


        if ($offset >= 0 && $limit > 0) {
            $limit_offset = "LIMIT $limit OFFSET $offset ";
        }

        $result = $this->db->query("SELECT report.*,clg.clg_first_name,clg.clg_last_name,clg.clg_group FROM $this->tbl_report as report left join $this->tbl_colleague as clg on(clg.clg_ref_id=report.clg_ref_id) where report.report_delete_status=0 $condition $limit_offset");


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function update_report($args = array()) {

        if ($args['report_id']) {

            $this->db->where('report_id', $args['report_id']);
            $update = $this->db->update($this->tbl_report, $args);

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function delete_report_history($report_id, $args = array()) {


        if ($report_id) {
            $this->db->where_in('report_id', $report_id);
            $update = $this->db->update($this->tbl_report, $args);

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function get_report_users($args = array(), $offset = "", $limit = "") {

        $condition = '';

        if (@$args['clg_ref_id'] != '') {
            $condition .= "AND clg_ref_id='" . $args['clg_ref_id'] . "'";
        }
        if (isset($args['report_id']) && $args['report_id'] != '') {
            $condition .= "AND report_id='" . $args['report_id'] . "'";
        }
        if ($offset >= 0 && $limit > 0) {
            $limit_offset = "LIMIT $limit OFFSET $offset ";
        }

        if (@$args['week'] != '') {

            $startend = unserialize(base64_decode($args['week']));
            $start = $startend['start'];
            $end = $startend['end'];
            $condition .= " and date_of_report between '$start%' and  '$end%' ";
        }
        if (@$args['day'] != '') {

            $day = $args['day'];
            $condition .= " and date_of_report LIKE CONCAT('%',\"$day\",'%') ";
        }

        if (@$args['month'] != '') {

            $end = (date('Y-m-t 12:59:59', strtotime($args['month'])));
            $start = (date('Y-m-01 00:00:00', strtotime($args['month'])));
            $condition .= " and date_of_report between '$start' and  '$end' ";
        }

        if (@$args['year'] != '') {

            $strtotime = "December" . $args['year'];
            $end = (date('Y-12-31 12:59:59', strtotime($strtotime)));
            $start = (date('Y-01-01 00:00:00', strtotime($strtotime)));
            $condition .= " and date_of_report between '$start' and  '$end' ";
        }


        $result = $this->db->query("SELECT DISTINCT medical_store_name ,report_id FROM $this->tbl_report  WHERE report_delete_status=0 $condition $limit_offset");


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function total_distance($args = array(), $offset = "", $limit = "") {


        $limit_offset = "";
        $condition = "";

        if (isset($args['clg_ref_id'])) {
            $condition .= " and clg.clg_ref_id like \"%" . $args['clg_ref_id'] . "%\" ";
        }

        if (isset($args['date_of_report'])) {
            $condition .= " and report.date_of_report like \"%" . $args['date_of_report'] . "%\" ";
        }

        if ($offset >= 0 && $limit > 0) {
            $limit_offset = "LIMIT $limit OFFSET $offset ";
        }

        if (@$args['week'] != '') {

            $startend = unserialize(base64_decode($args['week']));
            $start = $startend['start'];
            $end = $startend['end'];
            $condition .= " and report.date_of_report between '$start%' and  '$end%' ";
        }
        if (@$args['day'] != '') {

            $day = $args['day'];
            $condition .= " and report.date_of_report LIKE CONCAT('%',\"$day\",'%') ";
        }

        if (@$args['month'] != '') {

            $end = (date('Y-m-t 12:59:59', strtotime($args['month'])));
            $start = (date('Y-m-01 00:00:00', strtotime($args['month'])));
            $condition .= " and report.date_of_report between '$start' and  '$end' ";
        }

        if (@$args['year'] != '') {

            $strtotime = "December" . $args['year'];
            $end = (date('Y-12-31 12:59:59', strtotime($strtotime)));
            $start = (date('Y-01-01 00:00:00', strtotime($strtotime)));
            $condition .= " and report.date_of_report between '$start' and  '$end' ";
        }


        $result = $this->db->query("SELECT sum(distance) as distance,clg.clg_ref_id,clg.clg_first_name,clg.clg_last_name FROM $this->tbl_report as report LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = report.clg_ref_id) where report.report_delete_status=0 $condition group by clg.clg_ref_id $limit_offset");

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_distance_from($args = array()) {

        $condition = '';

        $report_delete_status = "1";

        if (isset($args['distance_from'])) {
            $condition .= "or report_delete_status='" . $report_delete_status . "'";
        }

        if (isset($args['clg_ref_id']) && $args['clg_ref_id'] != '') {
            $condition .= "AND clg_ref_id='" . $args['clg_ref_id'] . "'";
        }

        if (@$args['week'] != '') {

            $startend = unserialize(base64_decode($args['week']));
            $start = $startend['start'];
            $end = $startend['end'];
            $condition .= " and date_of_report between '$start%' and  '$end%' ";
        }
        if (@$args['day'] != '') {

            $day = $args['day'];
            $condition .= " and date_of_report LIKE CONCAT('%',\"$day\",'%') ";
        }

        if (@$args['month'] != '') {

            $end = (date('Y-m-t 12:59:59', strtotime($args['month'])));
            $start = (date('Y-m-01 00:00:00', strtotime($args['month'])));
            $condition .= " and date_of_report between '$start' and  '$end' ";
        }

        if (@$args['year'] != '') {

            $strtotime = "December" . $args['year'];
            $end = (date('Y-12-31 12:59:59', strtotime($strtotime)));
            $start = (date('Y-01-01 00:00:00', strtotime($strtotime)));
            $condition .= " and date_of_report between '$start' and  '$end' ";
        }


        if (isset($args['current_date'])) {
            $condition .= " AND date_of_report='" . $args['current_date'] . "'";
        }

        $result = $this->db->query("SELECT report_id,report_time,report_feedback,date_of_report,distance,medical_store_name,distance_form FROM $this->tbl_report where report_delete_status=0 $condition");

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_sales_person_name($args = array(), $offset = "", $limit = "") {

        $condition = '';

        if (@$args['clg_ref_id'] != '') {
            $condition .= " and report.clg_ref_id='" . $args['clg_ref_id'] . "'";
        }

        if (isset($args['date_of_report'])) {
            $condition .= "AND report.date_of_report='" . $args['date_of_report'] . "'";
        }
        if (isset($args['select_users']) && $args['select_users'] != '') {
            $condition .= "AND report.clg_ref_id='" . $args['select_users'] . "'";
        }

        if (@$args['week'] != '') {

            $startend = unserialize(base64_decode($args['week']));
            $start = $startend['start'];
            $end = $startend['end'];
            $condition .= " and report.date_of_report between '$start%' and  '$end%' ";
        }
        if (@$args['day'] != '') {

            $day = $args['day'];
            $condition .= " and report.date_of_report LIKE CONCAT('%',\"$day\",'%') ";
        }

        if (@$args['month'] != '') {

            $end = (date('Y-m-t 12:59:59', strtotime($args['month'])));
            $start = (date('Y-m-01 00:00:00', strtotime($args['month'])));
            $condition .= " and report.date_of_report between '$start' and  '$end' ";
        }

        if (@$args['year'] != '') {

            $strtotime = "December" . $args['year'];
            $end = (date('Y-12-31 12:59:59', strtotime($strtotime)));
            $start = (date('Y-01-01 00:00:00', strtotime($strtotime)));
            $condition .= " and report.date_of_report between '$start' and  '$end' ";
        }


        if ($offset >= 0 && $limit > 0) {
            $limit_offset = "LIMIT $limit OFFSET $offset ";
        }


        $result = $this->db->query("SELECT DISTINCT report.clg_ref_id,clg.clg_first_name,clg.clg_last_name,clg.clg_group,report.report_delete_status FROM $this->tbl_report as report left join $this->tbl_colleague as clg on(clg.clg_ref_id=report.clg_ref_id) where report.report_delete_status=0 $condition $limit_offset");


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

////////////////MI44///////////


    function get_parent_member($args = array()) {

        $condition = '';

        $this->db->select('gparent');

        $this->db->from("$this->tbl_mas_groups as ms_grp");

        $this->db->where("gcode ='" . $args['clg_group'] . "' AND is_deleted='0' AND gparent != ''");


        $fetched = $this->db->get();


        $present = $fetched->result();
        // var_dump(count($present));

        if (count($present) > 0) {

            //if(!empty($present)){

            if (($present[0]->gparent) != '') {
                $condition .= "AND clg_group='" . $present[0]->gparent . "'";
            }

            $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted='0' $condition";

            $result = $this->db->query($sql);
            //  echo $this->db->last_query();die;
            if ($result) {
                return $result->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function select_team_member($args = array()) {

        $condition = '';

        if (isset($args['clg_group'])) {
            $condition .= "AND clg_group='" . $args['clg_group'] . "'";
        }

        $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted='0' $condition";

        $result = $this->db->query($sql);

// echo $this->db->last_query();die;

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

////////////////////////
//    function select_tem_member($args=array()){
//        
//     $condition = '';
//     
//      if(isset($args['clg_senior_group'])){   $condition .= "AND clg2.clg_ref_id='".$args['clg_senior_group']."'" ; }  
//        
//        
//     $sql =   " SELECT clg2.clg_ref_id,clg1.clg_first_name,clg1.clg_last_name,clg2.clg_senior_group "
//            . "FROM $this->tbl_colleague clg2 "
//            . "LEFT JOIN $this->tbl_colleague clg1  
//                ON  clg2.clg_senior_group = clg1.clg_ref_id 
//                WHERE clg1.clg_is_deleted='0'$condition ";
//     
//      $result=$this->db->query($sql); 
//      
//        
//      //echo $this->db->last_query();die;
//      
//       if($result){     
//          return $result->result();
//        }else{
//          return false;
//        }
//     
//    
//    }
////////////////////MI44////////////////////////////////////////////////
//
/// Purpose :To get hospital list and ambulance pilot team autocomplete.
//
///////////////////////////////////////////////////////////////////////
    function get_clg_data_for_new_emp($args = array()){
        $condition = '';
        if (trim($args['clg_ref_id']) != '') {
            $condition .= "AND clg_ref_id like '%" . $args['clg_ref_id'] . "%' ";
        }
        if (trim($args['clg_is_assign_to_qa']) != '') {
            $condition .= "AND clg_is_assign_to_qa = '" . $args['clg_is_assign_to_qa'] . "' ";
        }

        if (trim($args['term']) != '') {
            $condition .= "AND (clg_first_name like '%" . $args['term'] . "%' OR clg_last_name like '%" . $args['term'] . "%')";
        }

        if (trim($args['clg_group']) != '') {
            $condition .= "clg_group = '" . $args['clg_group'] . "' ";
        }
        
        if (trim($args['district_id']) != '') {
            $condition .= "AND clg_district_id = '" . $args['district_id'] . "' ";
        }

        if (is_array($args['user_group']) != '') {
            $conditions_str = implode("','", $args['user_group']);
            $conditions_str = "'" . $conditions_str . "'";
            $condition .= "AND clg_group IN (" . $conditions_str . ")  ";
        }

        if (trim($args['clg_is_login']) != '') {
            $condition .= "AND clg_is_login ='" . $args['clg_is_login'] . "' ";
        }
        if (trim($args['clg_emso_id']) != '') {
            $condition .= "AND clg_emso_id ='" . $args['clg_emso_id'] . "' ";
        }
        if (trim($args['clg_senior']) != '') {
            $condition .= "AND clg_senior ='" . $args['clg_senior'] . "' ";
        }


         $sql = "SELECT * FROM $this->tbl_colleague where $condition $offlim";
        
     
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_clg_data($args = array(), $offset = '', $limit = '') {
//var_dump($args);die;

        $condition = $offlim = '';
        // $condition = '';
        if (trim($args['clg_ref_id']) != '' && trim($args['clg_ref_id']) != 'all' ) {
            $condition .= "AND clg_ref_id LIKE '%".$args['clg_ref_id']."%' ";
        }
        if (trim($args['clg_reff_id']) != '' ) {
            $condition .= "AND clg_ref_id  = '".$args['clg_reff_id']. "' ";
        }
        
        if (trim($args['clg_is_assign_to_qa']) != '') {
            $condition .= "AND clg_is_assign_to_qa = '" . $args['clg_is_assign_to_qa'] . "' ";
        }

        if (trim($args['term']) != '') {
            $condition .= "AND (clg_first_name like '%" . $args['term'] . "%' OR clg_last_name like '%" . $args['term'] . "%')";
        }

        if (trim($args['clg_group']) != '') {
            if(trim($args['clg_group']) == 'all_clg'){
            $condition .= " AND clg_group IN ('UG-ERO','UG-ERO-102') ";
            }else{
                $condition .= " AND clg_group = '" . $args['clg_group'] . "' ";
            }
        }
        
        
        if (trim($args['district_id']) != '') {
            $condition .= " AND clg_district_id = '" . $args['district_id'] . "' ";
        }

        if (is_array($args['user_group']) != '') {
            $conditions_str = implode("','", $args['user_group']);
            $conditions_str = "'" . $conditions_str . "'";
            $condition .= " AND clg_group IN (" . $conditions_str . ")  ";
        }

        if (trim($args['clg_is_login']) != '') {
            $condition .= "AND clg_is_login ='" . $args['clg_is_login'] . "' ";
        }
        if (trim($args['clg_emso_id']) != '') {
            $condition .= " AND clg_emso_id ='" . $args['clg_emso_id'] . "' ";
        }
        if (trim($args['clg_senior']) != '') {
            $condition .= " AND clg_senior ='" . $args['clg_senior'] . "' ";
        }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND thirdparty ='" . $args['thirdparty'] . "' ";
        }
        if($args['thirdparty_report'] != '' ){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND thirdparty='" . $args['thirdparty_report'] . "' ";
           
        }
         if (trim($args['clg_district_id']) != '') {
            $condition .= " AND clg_district_id LIKE '%" . $args['clg_district_id'] . "%' ";
        }
        if ($offset >= 0 && $limit > 0) {
        
            $offlim .= "limit $limit offset $offset ";
        }


             $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted='0' AND clg_is_active='1' $condition  ORDER BY clg_first_name ASC $offlim";
           
         

  //echo $sql;
     //  die;

        $result = $this->db->query($sql);
      


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_clg_all_data($args = array()){
       if($args=="all"){
        $result = $this->db->query("SELECT * FROM $this->tbl_colleague ");
        return $result->result();
       }
       else{
        $result = $this->db->query("SELECT * FROM $this->tbl_colleague WHERE clg_group = '$args'");
        return $result->result();
       }
       
    }

     
    function clg_update_details($new_data = array()) {


        $this->db->where_in('clg_avaya_agentid', $new_data['clg_avaya_agentid']);
        $this->db->where_in('clg_avaya_passwd', $new_data['clg_avaya_passwd']);
        unset($new_data['clg_avaya_passwd']);
        unset($new_data['clg_avaya_agentid']);

        $data = $this->db->update($this->tbl_colleague, $new_data);
        //echo $this->db->last_query();die;
        return $data;
    }
    function clg_is_ameyo_user_exists($args = array()) {

        $condition = '';
        if ($args['clg_avaya_agentid']) {
            $condition .= " AND clg_avaya_agentid='" . $args['clg_avaya_agentid'] . "' ";
        }
//        if ($args['clg_crmsessionId']) {
//            $condition .= " AND clg_crmsessionId='" . $args['clg_crmsessionId'] . "' ";
//        }
        if ($args['clg_avaya_passwd']) {
            $condition .= " AND clg_avaya_passwd='" . $args['clg_avaya_passwd'] . "' ";
        }

        $result = $this->db->query("SELECT clg_ref_id,clg_email FROM $this->tbl_colleague WHERE clg_is_deleted='0' $condition");
     //  echo $this->db->last_query();
      //  die();

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
        function clg_is_ameyo_user($args = array()) {

             $condition = '';
        if ($args['clg_avaya_agentid']) {
            $condition .= " AND clg_avaya_agentid='" . $args['clg_avaya_agentid'] . "' ";
        }
        if ($args['clg_avaya_passwd']) {
            $condition .= " AND clg_avaya_passwd='" . $args['clg_avaya_passwd'] . "' ";
        }
        if ($args['clg_crmsessionId']) {
            $condition .= " AND clg_crmsessionId='" . $args['clg_crmsessionId'] . "' ";
        }

        $result = $this->db->query("SELECT * FROM $this->tbl_colleague WHERE clg_is_deleted='0' $condition");
        //echo $this->db->last_query();
        //die();
                


        if ($result->result()) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

    function get_clg_data_order_by_id($args = array()) {


        $condition = '';
        if (isset($args['thirdparty'])  != '') {

            //$condition .= " AND thirdparty IN ('" . $args['thirdparty'] . "') ";
        }
        if (isset($args['clg_state_id'])  != '') {

            $condition .= " AND clg_state_id IN ('" . $args['clg_state_id'] . "') ";
        }
        if (trim($args['clg_ref_id']) != '' && trim($args['clg_ref_id']) != 'all' ) {
            $condition .= "AND clg_ref_id LIKE '%".$args['clg_ref_id']."%' ";
        }
        if (trim($args['clg_reff_id']) != '' ) {
            $condition .= "AND clg_ref_id  = '".$args['clg_reff_id']. "' ";
        }
        
        if (trim($args['clg_is_assign_to_qa']) != '') {
            $condition .= "AND clg_is_assign_to_qa = '" . $args['clg_is_assign_to_qa'] . "' ";
        }

        if (trim($args['term']) != '') {
            $condition .= "AND (clg_first_name like '%" . $args['term'] . "%' OR clg_last_name like '%" . $args['term'] . "%' OR clg_ref_id like '%" . $args['term'] . "%')";
        }

        if (trim($args['clg_group']) != '') {
            if(trim($args['clg_group']) == 'all_clg'){
            $condition .= "AND clg_group IN ('UG-ERO','UG-ERO-102') ";
            }else{
                $condition .= "AND clg_group = '" . $args['clg_group'] . "' ";
            }
        }
        
        
        if (trim($args['district_id']) != '') {
            $condition .= "AND clg_district_id = '" . $args['district_id'] . "' ";
        }

        if (is_array($args['user_group']) != '') {
            $conditions_str = implode("','", $args['user_group']);
            $conditions_str = "'" . $conditions_str . "'";
            $condition .= "AND clg_group IN (" . $conditions_str . ")  ";
        }

        if (trim($args['clg_is_login']) != '') {
            $condition .= "AND clg_is_login ='" . $args['clg_is_login'] . "' ";
        }
        if (trim($args['clg_emso_id']) != '') {
            $condition .= "AND clg_emso_id ='" . $args['clg_emso_id'] . "' ";
        }
        if (trim($args['clg_senior']) != '') {
            $condition .= "AND clg_senior ='" . $args['clg_senior'] . "' ";
        }



              $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted='0' $condition $offlim ORDER BY clg_id ASC ";
         


        $result = $this->db->query($sql);
//        var_dump($result);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
   
     function get_data(){
        
        $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted='0'  ORDER BY clg_first_name ASC ";



        $result = $this->db->query($sql);
//        var_dump($result);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    
    
     }
    function get_type_level($args = array()) {

        if (trim($args['clg_group']) != '') {
            $condition .= "AND gcode = '" . $args['clg_group'] . "' ";
        }

        $sql = "SELECT * FROM $this->tbl_mas_groups where is_deleted='0' $condition ";

//echo $sql;

        $result = $this->db->query($sql);

//echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_school_clg_data($args = array(), $clg_ref_id = '') {

        $condition = '';

        if (trim($args['clg_ref_id']) != '') {
            $condition .= "AND clg_ref_id like '%" . $args['clg_ref_id'] . "%' ";
        }

        if (trim($args['clg_group']) != '') {
            $condition .= "AND clg_group = '" . $args['clg_group'] . "' ";
        }

        if (trim($args['clg_is_login']) != '') {
            $condition .= "AND clg_is_login ='" . $args['clg_is_login'] . "' ";
        }
        if (trim($args['clg_emso_id']) != '') {
            $condition .= "AND clg_emso_id ='" . $args['clg_emso_id'] . "' ";
        }
        if (trim($clg_ref_id) != '') {
            $clg_ref_id = " OR ( clg_ref_id like '%" . $clg_ref_id . "%' )";
        }


        $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted='0' $condition $clg_ref_id $offlim ";
        $result = $this->db->query($sql);

//echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function clg_is_exists($args = array()) {

        if ($args['clg_ref_id']) {
            $condition = " AND clg_ref_id='" . $args['clg_ref_id'] . "' ";
        }
        if ($args['clg_email']) {
            $condition = " AND clg_email='" . $args['clg_email'] . "' ";
        }

        $result = $this->db->query("SELECT clg_ref_id,clg_email FROM $this->tbl_colleague WHERE clg_is_deleted='0' $condition");

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
     function clg_is_pass_exists($args = array()) {

        if ($args['clg_ref_id']) {
            $condition .= " AND clg_ref_id='" . $args['clg_ref_id'] . "' ";
        }
        if ($args['password']) {
            $condition .= " AND clg_password = '" . $args['password'] . "'";
        }

        $result = $this->db->query("SELECT clg_ref_id,clg_email FROM $this->tbl_colleague WHERE clg_is_deleted='0' $condition");
        //echo $this->db->last_query();
        //die();

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
      function clg_is_group_exists($args = array()) {

        $condition ='';
        if ($args['clg_ref_id']) {
            $condition .= " AND clg_ref_id='" . $args['clg_ref_id'] . "' ";
        }
        if ($args['password']) {
            $condition .= "AND clg_password = '" . $args['password'] . "'";
        }
         if ($args['clg_group']) {
            $condition .= "AND clg_group = '" . $args['clg_group'] . "'";
        }

        $result = $this->db->query("SELECT clg_ref_id,clg_email FROM $this->tbl_colleague WHERE clg_is_deleted='0' $condition");

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function clg_is_agent_login($args = array()) {

        $condition ='';
        if ($args['clg_avaya_agentid']) {
            $condition .= " AND clg_avaya_agentid='" . $args['clg_avaya_agentid'] . "' ";
        }
        $newDate = time()-120;

        $result = $this->db->query("SELECT clg_ref_id,clg_email FROM $this->tbl_colleague WHERE clg_is_deleted='0' AND clg_is_login='yes' AND clg_is_alive_time < $newDate  $condition");

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function add_login_details($ref_id, $last_login_time, $login_type, $login_details = "", $other_break_data = "") {

        $datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("INSERT INTO $this->clg_logins(`clg_ref_id`,`clg_last_login_time`,`clg_login_type`,`clg_login_details`,`clg_login_time`,`clg_other_login_details`) VALUES('" . $ref_id . "','" . $last_login_time . "','" . $login_type . "','" . $login_details . "','" . $datetime . "','" . $other_break_data . "')");


        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    }
    function clg_user_last_login($ref_id) {



        $result = $this->db->query("SELECT * FROM $this->clg_logins WHERE clg_ref_id='" . $ref_id . "'   ORDER BY id DESC limit 0,1");

      
       return $result->result();
        
    }
    function update_login_details( $last_login_time) {

        $datetime = date('Y-m-d H:i:s');

         $result = $this->db->query("UPDATE $this->clg_logins "
            . " SET clg_logout_time ='" . $datetime . "'"
            . " WHERE id = '" . $last_login_time . "'");
       // echo $this->db->last_query();
       // die();



        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

     function update_login_details_cron($ref_id, $id) {


      
        $datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("UPDATE $this->clg_logins "
            . " SET clg_logout_time ='" . $datetime . "'"
            . " WHERE clg_ref_id='" . $ref_id . "' AND id = '" . $id . "'");



        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function break_name($args = array()) {
        $this->db->select('*');

        $this->db->from("$this->tbl_standard_break");
        if($args['break_id'] != ""){
            $this->db->where("$this->tbl_standard_break.break_id", $args['break_id']);
        }

        $this->db->where("$this->tbl_standard_break.is_active", '1');
        $this->db->where("$this->tbl_standard_break.is_deleted", '0');
        $this->db->order_by('break_name','ASC');
            
        $data = $this->db->get();

        $result = $data->result();


        return $result;
    }
    

    function add_break_details($ref_id, $last_login_time, $login_type, $login_details = "", $other_break_data = "", $clg_break_time = "") {

        $datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("INSERT INTO ems_clg_break_summary(`clg_ref_id`,`clg_last_login_time`,`clg_login_type`,`clg_break_type`,`clg_break_time`,`clg_other_break_details`) VALUES('" . $ref_id . "','" . $last_login_time . "','" . $login_type . "','" . $login_details . "','" . $clg_break_time . "','" . $other_break_data . "')");


        if ($result) {

            return true;
        } else {

            return false;
        }
    }

    function update_break_details($ref_id, $last_login_time, $clg_break_time, $break_time) {

        $datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("UPDATE ems_clg_break_summary"
            . " SET clg_back_to_break_time ='" . $datetime . "', break_time ='" . $break_time . "'"
            . " WHERE clg_ref_id='" . $ref_id . "' AND clg_break_time = '" . $clg_break_time . "'");


//echo $this->db->last_query();

        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
        function add_avaya_break_details($ref_id, $last_login_time, $login_type, $login_details = "", $other_break_data = "", $clg_break_time = "") {

        $datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("INSERT INTO ems_clg_avaya_break_summary(`clg_ref_id`,`clg_last_login_time`,`clg_login_type`,`clg_break_type`,`clg_break_time`,`clg_other_break_details`) VALUES('" . $ref_id . "','" . $last_login_time . "','" . $login_type . "','" . $login_details . "','" . $clg_break_time . "','" . $other_break_data . "')");


        if ($result) {

            return true;
        } else {

            return false;
        }
    }

    function update_avaya_break_details($ref_id, $last_login_time, $clg_break_time, $break_time) {

        $datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("UPDATE ems_clg_avaya_break_summary"
            . " SET clg_back_to_break_time ='" . $datetime . "', break_time ='" . $break_time . "'"
            . " WHERE clg_ref_id='" . $ref_id . "' AND clg_break_time = '" . $clg_break_time . "'");


//echo $this->db->last_query();

        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function update_clg_set_school($school_id) {


        $result = $this->db->query("UPDATE $this->tbl_colleague as colleague SET colleague.clg_is_set_school='0' WHERE colleague.clg_is_set_school ='" . $school_id . "'");

        return $result;
    }

    function insert_notice($args = array()) {

        $this->db->insert($this->tbl_notice_remark, $args);
        
//        echo $this->db->last_query();
//        die();

        return $this->db->insert_id();
    }

    function insert_clg_notice($args = array()) {

        $this->db->insert($this->tbl_clg_notice_rem, $args);
        

        return $this->db->insert_id();
    }

    function get_clg_notice($args = array()) {

        $condition = '';

        if (trim($args['nr_user_group']) != '') {
            $condition .= "AND nr_user_group like '%" . $args['nr_user_group'] . "%' ";
        }

        if (trim($args['clg_ref_id']) != '') {
            $condition .= "AND clg_notice.clg_ref_id = '" . $args['clg_ref_id'] . "' ";
        }

        if (trim($args['nr_id']) != '') {
            $condition .= "AND nr_id = '" . $args['nr_id'] . "' ";
        }

        if (trim($args['today']) != '') {
            $condition .= "AND notice_exprity_date >= '" . $args['today'] . "' ";
        }

        $sql = "SELECT * FROM $this->tbl_notice_remark as notice  "
            . "LEFT JOIN `$this->tbl_clg_notice_rem` AS clg_notice "
            . "ON ( clg_notice.nr_notice_id = notice.nr_id ) "
            . " where notice.is_deleted='0'   $condition GROUP by clg_notice.nr_notice_id order by notice.nr_id DESC  $offlim  ";
      


        $result = $this->db->query($sql);

//echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_clg_notice_cnt($args = array()) {

        $condition = '';

        if (trim($args['nr_user_group']) != '') {
            $condition .= "AND nr_user_group like '%" . $args['nr_user_group'] . "%' ";
        }


        if (trim($args['clg_ref_id']) != '') {
            $condition .= "AND clg_notice.clg_ref_id = '" . $args['clg_ref_id'] . "' ";
        }

        if (trim($args['nr_id']) != '') {
            $condition .= "AND nr_id = '" . $args['nr_id'] . "' ";
        }

        if (trim($args['today']) != '') {
            $condition .= "AND notice_exprity_date >= '" . $args['today'] . "' ";
        }

             $sql = "SELECT * FROM $this->tbl_notice_remark as notice  "
            . "LEFT JOIN `$this->tbl_clg_notice_rem` AS clg_notice "
            . "ON ( clg_notice.nr_notice_id = notice.nr_id ) "
            . " where notice.is_deleted='0' AND clg_notice.n_is_closed = '0' $condition GROUP by clg_notice.nr_notice_id order by notice.nr_id DESC $offlim ";
          
           

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function update_notice_rem($args) {
        $this->db->where_in('clg_ref_id', $args['clg_ref_id']);
        $this->db->where_in('nr_notice_id', $args['nr_notice_id']);
        $data = $this->db->update("$this->tbl_clg_notice_rem", $args);
        return $data;
    }

    function get_last_login_user() {

        $newDate = time()-300;
         $sql = " SELECT * FROM $this->tbl_colleague as clg  "
            . " where `clg_is_alive_time` < $newDate AND `clg_is_login` IN ('yes','break') ";
     
       
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
        
    }
    
    function update_auto_logout_flag($is_live_time) {

        //$newDate = strtotime(" -2 minutes");
         $newDate = time()-120;

         $result = $this->db->query("UPDATE `$this->tbl_colleague` as `clg` SET `clg_is_login` = 'no',`clg_break_type` = 'LO' WHERE `clg_is_alive_time` < $newDate AND `clg_is_login` = 'yes'");
  
        return $result;
    }
    
    function update_login_details_live($user_ref_id,$login_history_id,$args) {
        $this->db->where('id', $login_history_id);
        $this->db->where('clg_ref_id', $user_ref_id);
        $data = $this->db->update('ems_clg_logins', $args);
        return $data;
    }
    

    
    function update_auto_logout_colleague($clg_ref_id = "") {

        $newDate = strtotime(" -5 minutes");
          if ($clg_ref_id != '') {
            $condition .= " AND `clg`.`clg_ref_id` = '$clg_ref_id'";
        }
        
        //$newDate = time()-120;
        $current_time = date('Y-m-d H:i:s');

          $result = $this->db->query("UPDATE `ems_clg_logins` as `clg_lg` LEFT JOIN `ems_colleague` as `clg` ON `clg_lg`.`clg_ref_id` = `clg`.`clg_ref_id` SET `clg_logout_time` = '$current_time' WHERE `clg_lg`.`clg_is_alive_time` < $newDate AND `clg_logout_time` = '0000-00-00 00:00:00'  $condition");

       
       
        return $result;
    }

    function clg_user_default_key_exists($args = array()) {

        if ($args['user_default_key']) {
            $condition = " AND user_default_key='" . $args['user_default_key'] . "' ";
        }


        $result = $this->db->query("SELECT clg_ref_id FROM $this->tbl_colleague WHERE clg_is_deleted='0' $condition");

        if ($result->result()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function insert_avaya_agent_status($args = array()) {

        $this->db->insert('ems_avaya_agent_status', $args);
        return $this->db->insert_id();
    }

   function update_avaya_agent_status($args) {
        $this->db->where('avaya_agent_id', $args['avaya_agent_id']);
        $this->db->where('avaya_agent_extension', $args['avaya_agent_extension']);
        $data = $this->db->update('ems_avaya_agent_status', $args);
        return $data;
    }

    function delete_avaya_agent_status($args = array()) {

        $this->db->where('avaya_agent_id', $args['avaya_agent_id']);
        $this->db->where('avaya_agent_extension', $args['avaya_agent_extension']);
        $this->db->delete('ems_avaya_agent_status');
        //echo $this->db->last_query();
        //die();
    }
    function get_all_shiftmanager(){
        //var_dump($args);die;
      
        $condition = '';
     
            $condition .= "AND clg_group IN ('UG-ShiftManager') ";
     
        // if (trim($args['term']) != '') {

        //     $condition .= " AND clg_ref_id LIKE '%" . trim($args['term']) . "%' ";
        // }
        $sql = "SELECT clg_ref_id, clg_first_name, clg_last_name FROM $this->tbl_colleague where clg_is_deleted='0' $condition ORDER BY clg_first_name ASC ";
        $result = $this->db->query($sql);

            return $result->result();
    }
    function get_all_tlname($data){
        //var_dump($clg_ref_id);die;
        $condition = '';
       if($data['clg_ref_id'] == "all_sm"){
            if($data['report_type'] == "ERO"){
            $condition .= "AND clg_group IN ('UG-EROSupervisor')";
            }else{
            $condition .= "AND clg_group IN ('UG-DCOSupervisor')";     
            }
        }
        
        if($data['clg_ref_id'] != "all_sm"){
            if($data['report_type'] == "ERO"){
                $condition .= "AND clg_senior ='" . $data['clg_ref_id'] . "' AND clg_group IN ('UG-EROSupervisor')";
             }else{
                $condition .= "AND clg_senior ='" . $data['clg_ref_id'] . "' AND clg_group IN ('UG-DCOSupervisor')";
             }
           //$condition .= "AND clg_senior ='" . $data['clg_ref_id'] . "' ";
        }
        //if($data['report_type'] == "ERO"){
       //     $condition .= "AND clg_group IN ('UG-EROSupervisor')";
        //}else{
        //    $condition .= "AND clg_group IN ('UG-DCOOSupervisor')";
        //}


        $sql = "SELECT clg_ref_id, clg_first_name, clg_last_name FROM $this->tbl_colleague where clg_is_deleted='0' $condition ORDER BY clg_first_name ASC ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $result->result();
    }

    function get_all_eros($args){
        ///var_dump($args); die;
        $condition = '';
        if($args['tl_list'] != ""){
            $tl_list = $args['tl_list'];
            if($tl_list == "all_tl"){
                if($args['report_type'] == "ERO"){
                $condition .= "AND clg_group IN ('UG-ERO'')";
                }else{
                $condition .= "AND clg_group IN ('UG-DCO')";
                }
            }
            
            if($tl_list != "all_tl"){
                $condition .= "AND clg_senior = '" . $tl_list. "' AND clg_group IN ('UG-ERO','UG-DCO')";
            }
            //else{
            //$condition .= "AND clg_senior = '" . $tl_list. "'";
            //}
        }
        if($args['team_type'] != ""){
            $team_type = $args['team_type'];
            if($team_type == "UG-ERO"){
                $condition .= "AND clg_group IN ('UG-ERO')";
            }elseif($team_type == "UG-DCO"){
                $condition .= "AND clg_group IN ('UG-DCO')";
            }else{
            $condition .= "AND clg_group = '" . $team_type. "'";
            }
        }

        if($args['system_type'] != ""){
            $system = $args['system_type'] ;
            $condition .= "AND clg_group = '" . $system. "'";
        }
        if($args['system'] != ""){
            if($args['system'] != "all_clg"){
            $system = $args['system'] ;
            $condition .= "AND clg_group = '" . $system. "'";
            }
        }
        
        $sql = "SELECT clg_ref_id, clg_first_name, clg_last_name FROM $this->tbl_colleague where clg_is_deleted='0' $condition ORDER BY clg_first_name ASC ";
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        return $result->result();
       
    }


    
    function get_all_ero($args){
        //var_dump($result);die;
      
        $condition = '';
     
            $condition .= "AND clg_group IN ('UG-ERO','UG-ERO-102') ";
     
        // if (trim($args['term']) != '') {

        //     $condition .= " AND clg_senior = '" . trim($args['term']) ."'  ";
        // }
        $sql = "SELECT clg_ref_id, clg_first_name, clg_last_name,clg_avaya_id FROM $this->tbl_colleague where clg_is_deleted='0' $condition ORDER BY clg_first_name ASC ";
        $result = $this->db->query($sql);

            return $result->result();
           // $this->db->last_query();die;
    }

    function get_all_erosupervisor($args){
        //var_dump($args);die;
      
        $condition = '';
     
            $condition .= "AND clg_group IN ('UG-EROSupervisor') ";
     
        if (trim($args['term']) != '') {

            $condition .= " AND clg_senior = '" . trim($args['term']) ."'  ";
        }
        $sql = "SELECT clg_ref_id, clg_first_name, clg_last_name FROM $this->tbl_colleague where clg_is_deleted='0' $condition ORDER BY clg_first_name ASC ";
        $result = $this->db->query($sql);

            echo json_encode($result->result_array());
    }
    
    function insert_forcefully_logout($args = array()){
        $this->db->insert('ems_forcefully_logout', $args);
        //$this->db->last_query();die;
        return $this->db->insert_id();
    }
     function insert_mdt_forcefully_logout($args = array()){
        $this->db->insert('ems_mdt_forcefully_logout', $args);
        //echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    
    function insert_clg($args = array()) {
        $dup_id = array();
        $ref=$args['clg_ref_id'];
        $emp=$args['clg_jaesemp_id'];
        $mob=$args['clg_mobile_no'];
        $this->db->select('*');
        $this->db->from("$this->tbl_colleague as colleague");
        $this->db->where("colleague.clg_ref_id = '$ref' OR colleague.clg_jaesemp_id = '$emp' OR colleague.clg_mobile_no='$mob'" );
        $fetched = $this->db->get();
        $present = $fetched->result();
        if(!empty($present)){
            foreach($present as $present1){
                $where = '(clg_ref_id="'.$present1->clg_ref_id.'" or clg_jaesemp_id = "'.$present1->clg_jaesemp_id.'" or clg_mobile_no = "'.$present1->clg_mobile_no.'")';
                $this->db->select('*');
                $this->db->from("ems_colleague");
                $this->db->where('clg_ref_id',$ref);
                $fetched1 = $this->db->get();
                $numRows1 = $fetched1->num_rows();
                $rec1 = $fetched1->result();

                $this->db->select('*');
                $this->db->from("ems_colleague");
                $this->db->where('clg_mobile_no', $mob);
                $fetched2 = $this->db->get();
                $numRows2 = $fetched2->num_rows();
                $rec2 = $fetched2->result();

                $this->db->select('*');
                $this->db->from("ems_colleague");
                $this->db->where('clg_jaesemp_id',$emp);
                $fetched3 = $this->db->get();
                $numRows3 = $fetched3->num_rows();
                $rec3 = $fetched3->result();
                if($numRows1 > 0){
                    $rec['clg_ref_id'] = $rec1[0]->clg_ref_id; 
                }
                if($numRows2 > 0){
                    $rec['clg_mobile_no'] = $rec2[0]->clg_mobile_no;   
                }
                if($numRows3 > 0){
                    $rec['clg_jaesemp_id'] = $rec3[0]->clg_jaesemp_id;     
                }
                $this->db->select('*');
                $this->db->from("$this->tbl_colleague as colleague");
                $this->db->where("1 ORDER BY colleague.clg_id DESC LIMIT 1" );
                $fetched = $this->db->get();
                $copy = $fetched->result();
                // echo $this->db->last_query();die;
                foreach($copy as $cpy)
                {
                    $last_ref =  $cpy->clg_ref_id;
                    $Last_emp =  $cpy->clg_jaesemp_id;
                    $f_name =  $cpy->clg_first_name; 
                    $l_name =  $cpy->clg_last_name;
                }
                array_push($dup_id,$rec,$last_ref, $Last_emp,$f_name,$l_name);
                return $dup_id;
            }
           
            
        }else{
            $result = $this->db->insert($this->tbl_colleague, $args);
            // $this->db->last_query();die;
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
        function get_all_grps(){
            $sql = "SELECT ugname,gcode FROM $this->tbl_mas_groups where is_deleted = 0";
    
            $result = $this->db->query($sql);

            if ($result) {
                return $result->result();
            } else {
                return false;
            }
        }
    }