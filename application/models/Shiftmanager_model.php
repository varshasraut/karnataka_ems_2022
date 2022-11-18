<?php

class Shiftmanager_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_clg_logins = $this->db->dbprefix('clg_logins');
        $this->tbl_clg_break_summary = $this->db->dbprefix('clg_break_summary');
        $this->tbl_standard_break = $this->db->dbprefix('standard_break');
         $this->tbl_shiftmanager_call_details= $this->db->dbprefix('shiftmanager_call_details');
    }
    function add_shiftmanager_call($args = array()) {

        $this->db->insert($this->tbl_shiftmanager_call_details, $args);

        return $this->db->insert_id();
    }
    function get_login_details_ero($args = array(), $offset = '', $limit = '') {
        //var_dump($args);die;
           $condition = $offlim = '';
           if ($args['from_date'] != '' && $args['to_date'] != '') {
               $from = $args['from_date'];
               $to = $args['to_date'];
               $condition .= " AND clg_log.clg_login_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
           }
   
           if ($args['single_date'] != '') {
               $from = $args['single_date'];
               $to = $args['single_date'];
               $condition .= " AND clg_log.clg_login_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
           }
   
   
           if ($args['clg_ref_id']) {
               if ($args['clg_ref_id'] != 'all') {
               $condition .= " AND clg.clg_ref_id IN ('" . $args['clg_ref_id'] . "') ";
               }
           }
           
           if ($args['user_id']) {
               if ($args['user_id'] != 'all') {
               $condition .= " AND clg.clg_ref_id='" . $args['user_id'] . "' ";
               }
           }
   
           if ($args['team_type']) {
               if ($args['team_type'] != 'all') {
               $condition .= " AND clg.clg_group='" . $args['team_type'] . "' ";
           }
       }
   
           if ($args['clg_group']) {
               $condition .= " AND clg.clg_group='" . $args['clg_group'] . "' ";
           }
   
           if ($offset >= 0 && $limit > 0) {
   
               $offlim .= "limit $limit offset $offset ";
           }
           if($args['thirdparty_report'] != '' && $args['thirdparty_report'] != '1'){
   
               // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
               $condition =  " AND clg.thirdparty='" . $args['thirdparty_report'] . "' AND clg.clg_district_id = '" . $args['clg_district_id'] . "' ";
              
           }
            $sql = "SELECT * "
               . " FROM $this->tbl_colleague AS clg "
               . " LEFT JOIN $this->tbl_clg_logins AS clg_log ON ( clg_log.clg_ref_id = clg.clg_ref_id )"
               . " WHERE 1=1   $condition ORDER BY clg_log.clg_login_time DESC LIMIT 1 $offlim";
   

           
           $result = $this->db->query($sql);
         
           if ($args['get_count']) {
               return $result->num_rows();
           } else {
               return $result->result();
           }
       }
   
    function get_login_details($args = array(), $offset = '', $limit = '') {
     //var_dump($args);die;
        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND clg_log.clg_login_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($args['single_date'] != '') {
            $from = $args['single_date'];
            $to = $args['single_date'];
            $condition .= " AND clg_log.clg_login_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }


        if ($args['clg_ref_id']) {
            if ($args['clg_ref_id'] != 'all') {
            $condition .= " AND clg.clg_ref_id IN ('" . $args['clg_ref_id'] . "') ";
            }
        }
        
        if ($args['user_id']) {
            if ($args['user_id'] != 'all') {
            $condition .= " AND clg.clg_ref_id='" . $args['user_id'] . "' ";
            }
        }

        if ($args['team_type']) {
            if ($args['team_type'] != 'all') {
            $condition .= " AND clg.clg_group='" . $args['team_type'] . "' ";
        }
    }

        if ($args['clg_group']) {
            $condition .= " AND clg.clg_group='" . $args['clg_group'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if($args['thirdparty_report'] != '' && $args['thirdparty_report'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND clg.thirdparty='" . $args['thirdparty_report'] . "' AND clg.clg_district_id = '" . $args['clg_district_id'] . "' ";
           
        }
         $sql = "SELECT * "
            . " FROM $this->tbl_colleague AS clg "
            . " LEFT JOIN $this->tbl_clg_logins AS clg_log ON ( clg_log.clg_ref_id = clg.clg_ref_id )"
            . " WHERE 1=1   $condition ORDER BY clg_log.clg_login_time DESC $offlim";


        
        $result = $this->db->query($sql);
       // echo $this->db->last_query();
       // die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_break_details_by_user($args = array(), $offset = '', $limit = '') {
     //var_dump($args);die;
        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND clg_brk.clg_break_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($args['single_date'] != '') {
            $from = $args['single_date'];
            $to = $args['single_date'];
            $condition .= " AND clg_brk.clg_break_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }


        if ($args['clg_ref_id'] && $args['clg_ref_id'] != 'all' ) {
        $condition .= " AND clg.clg_ref_id='" . $args['clg_ref_id'] . "' ";
         //   $condition .= "AND clg.clg_ref_id like '%" . $args['clg_ref_id'] . "%' ";

        }
        if ($args['break_type']) {
            $condition .= " AND clg_brk.clg_break_type='" . $args['break_type'] . "' ";
        }

        if ($args['clg_group']) {
            $condition .= " AND clg.clg_group='" . $args['clg_group'] . "' ";
        }
          if ($args['team_type']) {
            if ($args['team_type'] != 'all') {
            $condition .= " AND clg.clg_group='" . $args['team_type'] . "' ";
        }
    }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
          if($args['thirdparty_report'] != '' && $args['thirdparty_report'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND clg.thirdparty='" . $args['thirdparty_report'] . "' AND clg.clg_district_id = '" . $args['clg_district_id'] . "' ";
           
        }

        $sql = "SELECT stand_brk.* ,clg.*,clg_brk.clg_break_type,clg_brk.clg_break_time,clg_brk.clg_back_to_break_time,clg_brk.break_time,stand_brk.break_name,stand_brk.break_name as break_duration"
            . " FROM $this->tbl_colleague AS clg "
            . " LEFT JOIN $this->tbl_clg_break_summary AS clg_brk ON ( clg_brk.clg_ref_id = clg.clg_ref_id )"
            . " LEFT JOIN $this->tbl_standard_break AS stand_brk ON ( stand_brk.break_id = clg_brk.clg_break_type )"
            . " WHERE 1=1  $condition ORDER BY clg_brk.clg_break_time DESC $offlim";
      

      
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_break_total_time_user($args = array()) {

        $condition = $offlim = '';



        if ($args['clg_ref_id']) {
            $condition .= " AND clg_ref_id='" . $args['clg_ref_id'] . "' ";
        }
        if ($args['break_type']) {
            $condition .= " AND clg_break_type='" . $args['break_type'] . "' ";
        }

        if ($args['clg_group']) {
            $condition .= " AND clg_group='" . $args['clg_group'] . "' ";
        }
       // if ($args['single_date'] != '') {
            $from =date('Y-m-d');;
            $to = date('Y-m-d');
            $condition .= " AND clg_break_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        //}


         $sql = "SELECT SUM(break_time_sec) as break_total_time from ( SELECT TIMESTAMPDIFF(SECOND,`clg_break_time`,`clg_back_to_break_time`) as break_time_sec FROM `ems_clg_break_summary` Where 1=1 $condition) as break_table";        
      
      //echo $sql;
      //die();
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

}

?>