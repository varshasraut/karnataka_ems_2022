<?php

class Quality_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_qa_team = $this->db->dbprefix('qa_team');
        $this->tbl_qa_assign_team = $this->db->dbprefix('qa_assign_team');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_quality_questions = $this->db->dbprefix('mas_quality_questions');
        $this->tbl_quality_audit = $this->db->dbprefix('quality_audit');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_cross_audit = $this->db->dbprefix('cross_audit');
        $this->tbl_ero_notice = $this->db->dbprefix('ero_notice');
         $this->tbl_shift = $this->db->dbprefix('mas_shift');
         $this->tbl_schedule_crud = $this->db->dbprefix('schedule_crud');
    }

    function insert_ero_notice($args) {

        $this->db->insert($this->tbl_ero_notice, $args);
        return $this->db->insert_id();
    }
    
      function insert_shift($args) {

        $this->db->insert($this->tbl_shift, $args);
        return $this->db->insert_id();
    }

    function get_ero_notice_cnt($args = array()) {

        $condition = '';

//        if (trim($args['nr_user_group']) != '') {
//            $condition .= "AND nr_user_group like '%" . $args['nr_user_group'] . "%' ";
//        }


        if (trim($args['usr_id']) != '') {
            $condition .= "AND er_usr = '" . $args['usr_id'] . "' ";
        }

        if (trim($args['id']) != '') {
            $condition .= "AND id = '" . $args['id'] . "' ";
        }

        if (trim($args['today']) != '') {
            $from = $args['today'];
            $to = $args['today'];
            //$condition .= "AND er_added_date = '" . $args['today'] . "' ";
            $condition .= " AND er_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

         $sql = "SELECT * FROM $this->tbl_ero_notice as notice  "
            . " where notice.er_is_deleted='0' AND notice.er_is_closed='0' $condition GROUP by notice.id $offlim ";
       
     


        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function update_notice_ero($args) {

        $this->db->where_in('id', $args['id']);
        $data = $this->db->update("$this->tbl_ero_notice", $args);
        return $data;
        
    }

    function get_ero_notice($args = array()) {

        $condition = '';
        if (trim($args['usr_id']) != '') {
            $condition .= "AND er_usr = '" . $args['usr_id'] . "' ";
        }
        if (trim($args['id']) != '') {
            $condition .= "AND id = '" . $args['id'] . "' ";
        }



        $sql = "SELECT * FROM $this->tbl_ero_notice as notice  "
            . " where notice.er_is_deleted='0'  $condition GROUP by notice.id $offlim ";


        $result = $this->db->query($sql);

//echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function close_db_connection() {
        $this->db->close();
    }

    function insert_qa_team($args = array()) {

        $this->db->insert($this->tbl_qa_team, $args);
        return $this->db->insert_id();
    }

    function insert_qa_assign_team($args = array()) {

        $this->db->insert($this->tbl_qa_assign_team, $args);
        return $this->db->insert_id();
    }

    function update_qa_team($args = array()) {

        $this->db->where_in('qa_team_id ', $args['qa_team_id ']);
        $data = $this->db->update($this->tbl_qa_team, $args);
        return $data;
    }

    function get_qa_team($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (trim($args['qa_team_id ']) != '') {
            $condition .= "AND am_mt.qa_team_id  = '" . $args['qa_team_id '] . "' ";
        }

        if (trim($args['qa_team_type']) != '') {
            $condition .= "AND am_mt.qa_team_type = '" . $args['qa_team_type'] . "' ";
        }


//        if (isset($args['search']) && $args['search'] != '') {
//
//            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_schedule_service LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%')";
//        }



        $sql = "SELECT am_mt.* FROM $this->tbl_qa_team as am_mt "
            . "where am_mt.is_deleted ='0' $condition $offlim ";

        $result = $this->db->query($sql);

        /// echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_qa_form_team($args = array(), $offset = '', $limit = '') {

        //if (trim($args['qa_team_type']) != '') {
        //    $condition .= "AND am_mt.qa_team_type IN ('" . $args['qa_team_type'] . "') ";
        //}
        if (trim($args['clg_ref_id_qality']) != '') {
            $condition .= "AND am_mt.qa_team_type = '" . $args['clg_ref_id_qality'] . "' ";
        }

        if (trim($args['added_by']) != '') {
            $condition .= "AND am_mt.added_by = '" . $args['added_by'] . "' ";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        $offlim ="";
  
        
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }


        $sql = "SELECT am_mt.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no,clg.clg_ref_id FROM $this->tbl_qa_team as am_mt "
            . "LEFT JOIN $this->tbl_qa_assign_team as team ON am_mt.qa_team_id = team.qa_team_id "
            . "LEFT JOIN $this->tbl_colleague as clg ON clg.clg_ref_id = team.team_member "
            . "where am_mt.is_deleted ='0' $condition $offlim ";


        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_quality_question($args) {
        ///var_dump($args);die;
        $condition = $offlim = '';

        if (trim($args['qa_user_group']) != '') { 
            // if(trim($args['qa_user_group']) == 'UG-ERO,UG-ERO-102') {
            //     $condition .= " AND qa_ques.qa_user_group = 'UG-ERO' ";
            // }elseif(trim($args['qa_user_group']) == 'UG-DCO,UG-DCO-102'){
            //     $condition .= " AND qa_ques.qa_user_group  = 'UG-DCO' ";
            if (trim($args['qa_user_group']) == 'ERO' || trim($args['qa_user_group']) == 'UG-ERO'  || trim($args['qa_user_group']) == 'UG-ERO,UG-ERO-102'){
                //echo "Hi"; die;
            $condition .= " AND qa_ques.qa_user_group  = 'UG-ERO' ";
            }elseif (trim($args['qa_user_group']) == 'DCO' || trim($args['qa_user_group']) == 'UG-DCO'  || trim($args['qa_user_group']) == 'UG-DCO,UG-DCO-102'){
                $condition .= " AND qa_ques.qa_user_group  = 'UG-DCO' ";
            }
            // else{
            //     $condition .= " AND qa_ques.qa_user_group  = '" . $args['qa_user_group'] . "' ";
            // }
        }

        if (trim($args['qa_ques_type']) != '') {
            $condition .= " AND qa_ques.qa_ques_type = '" . $args['qa_ques_type'] . "' ";
        }

        $sql = "SELECT qa_ques.* FROM $this->tbl_quality_questions as qa_ques "
            . " where qa_ques.qa_is_deleted ='0' $condition ";

        $result = $this->db->query($sql);

           //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function insert_qa_audit($args = array()) {

        $this->db->insert($this->tbl_quality_audit, $args);
        return $this->db->insert_id();
    }

    function get_quality_audit($args = array()) {
//var_dump($args);die;
        $condition = $offlim = '';

        if ($args['limit'] != '') {
            $limit1 = $args['limit'];
            $limit .= " limit $limit1 offset ".$args['offset'];
        }
        if (trim($args['inc_ref_id']) != '') {
            $condition .= " AND qa_audit.inc_ref_id = '" . $args['inc_ref_id'] . "' ";
        }
        if (trim($args['qa_ad_user_ref_id']) != '') {
            if (trim($args['qa_ad_user_ref_id']) != 'all') {
            $condition .= " AND qa_audit.qa_ad_user_ref_id = '" . $args['qa_ad_user_ref_id'] . "' ";
            }
        }
         if ($args['qa_ad_ref_id'] != '') {
             if($args['qa_ad_ref_id'] != 'all'){
            $condition .= " AND qa_audit.qa_ad_user_ref_id = '" . $args['qa_ad_ref_id'] . "' ";
             }
        }
        if ($args['qa_id']) {
            if($args['qa_id'] != "all"){
                $condition .= " AND qa_audit.added_by='" . $args['qa_id'] . "' ";
            }
        }
        if (trim($args['team_type']) != '') {
            if (trim($args['team_type']) != 'all') {
            $condition .= " AND qa_audit.user_system_type = '" . $args['team_type'] . "'  ";
            }
        }
    
        
        //if (trim($args['user_type']) != '') {
           // $condition .= " AND qa_audit.qa_ad_user_group = '" . $args['user_type'] . "' ";
        //}
        if ($args['added_date'] != '' && $args['added_date'] != '') {
            $from = $args['added_date'];
            $to = $args['added_date'];
            $condition .= " AND qa_audit.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
              
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND qa_audit.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            
        }
         if ($args['from_datetime'] != '' && $args['to_datetime'] != '') {
              
            $from = $args['from_datetime'];
            $to = $args['to_datetime'];
            $condition .= " AND qa_audit.added_date BETWEEN '$from' AND '$to'";
            
        }

          $sql = "SELECT qa_audit.* FROM $this->tbl_quality_audit as qa_audit"
            . " where qa_audit.is_deleted ='0' $condition $limit"; 
      
        // echo $sql; die();
        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_quality_audit_by_user($args = array(),$offset='',$limit='') {

        $condition = $offlim = '';
        //var_dump($args);

        if (trim($args['qa_ad_id']) != '') {
            $condition .= " AND qa_audit.qa_ad_id = '" . $args['qa_ad_id'] . "' ";
        }
        if (trim($args['inc_ref_id']) != '') {
            $condition .= " AND qa_audit.inc_ref_id = '" . $args['inc_ref_id'] . "' ";
        }
        if (trim($args['added_by']) != '') {
           // if (trim($args['added_by']) != 'all') {
            $condition .= "AND qa_audit.added_by = '" . $args['added_by'] . "' ";
            //}
        }
        if (trim($args['qa_name']) != '') {
            if (trim($args['qa_name']) != 'all') {
            $condition .= "AND qa_audit.added_by = '" . $args['qa_name'] . "' ";
            }
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND qa_audit.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
          
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

         $sql = "SELECT qa_audit.*,inc.inc_datetime,inc.inc_type,clr.* FROM $this->tbl_quality_audit as qa_audit"
            . " LEFT JOIN $this->tbl_incidence as inc ON (qa_audit.inc_ref_id=inc.inc_ref_id)"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " where qa_audit.is_deleted ='0' $condition $offlim";

        $result = $this->db->query($sql);
//  echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function update_qa_audit($args = array()) {
        $this->db->where('inc_ref_id', $args['inc_ref_id']);
        $data = $this->db->update($this->tbl_quality_audit, $args);
       // echo $this->db->last_query();
       // die();
        return $data;
    }

    function insert_cross_audit($args = array()) {

        $this->db->insert($this->tbl_cross_audit, $args);
        return $this->db->insert_id();
    }

    function update_cross_audit($args = array()) {
        $this->db->where_in('cr_id', $args['cr_id']);
        $data = $this->db->update($this->tbl_cross_audit, $args);
        return $data;
    }

    function get_quality_cross_audit($args = array()) {

        $condition = $offlim = '';


        if (trim($args['cr_audit_id']) != '') {
            $condition .= " AND qa_audit.cr_audit_id = '" . $args['cr_audit_id'] . "' ";
        }


        $sql = "SELECT qa_audit.* FROM $this->tbl_cross_audit as qa_audit"
            . " where qa_audit.is_deleted ='0' $condition ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_audit_report($args = array()) {

        $condition = $offlim = '';
    // var_dump($args);   die;

        if (trim($args['inc_ref_id']) != '') {
            $condition .= " AND qa_audit.inc_ref_id = '" . $args['inc_ref_id'] . "' ";
        }
        if (trim($args['report_type']) != '') {
            $condition .= "AND qa_audit.qa_ad_user_group = '" . $args['report_type'] . "' ";
        }
        if (trim($args['system_type']) != '') {
            if(trim($args['system_type']) != 'all'){
                $condition .= " AND qa_audit.user_system_type = '" . $args['system_type'] . "'  ";
                        }}
         if (trim($args['user_id']) != '') {
             if(trim($args['user_id']) != 'all'){
             $condition .= "AND qa_audit.qa_ad_user_ref_id = '" . $args['user_id'] . "' ";
             }
         }
        
        if (trim($args['call_type']) != '') {
            if (trim($args['call_type']) != 'all') {
            $condition .= "AND inc.inc_type = '" . $args['call_type'] . "' ";
            }
        }

        if (trim($args['tna']) != '') {
            $condition .= "AND qa_audit.tna = '" . $args['tna'] . "' ";
        }

        if (trim($args['shift']) != '') {
            $condition .= "AND shift.user_id = '" . $args['shift'] . "' ";
        }
        // if (trim($args['shift']) != '') {
        //     $condition .= "AND qa_audit.tna = '" . $args['shift'] . "' ";
        // }

        if (trim($args['fatal_error_indicator']) != '') {
            $condition .= "AND qa_audit.fetal_error_indicator= '" . $args['fatal_error_indicator'] . "' ";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND qa_audit.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $condition .= " AND qa_audit.added_date BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
        }

        $sql = "SELECT qa_audit.*, inc.inc_type as call_type, COUNT(*) as qa_count FROM $this->tbl_quality_audit as qa_audit"
             ." LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = qa_audit.inc_ref_id )"
            // ." LEFT JOIN  $this->tbl_schedule_crud AS shift ON (shift.user_id= qa_audit.qa_ad_user_ref_id )"
             . " where qa_audit.is_deleted ='0' $condition group by qa_audit.qa_ad_user_ref_id ORDER BY qa_audit.qa_ad_id ASC ";


        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_quality_master_report($args = array()){
         $condition = $offlim = '';
    //  var_dump($args);   die;

        if (trim($args['inc_ref_id']) != '') {
            $condition .= " AND qa_audit.inc_ref_id = '" . $args['inc_ref_id'] . "' ";
        }
        if (trim($args['report_type']) != '') {
            $condition .= "AND qa_audit.qa_ad_user_group = '" . $args['report_type'] . "' ";
        }
        if (trim($args['system_type']) != '') {
            $condition .= "AND qa_audit.qa_ad_user_ref_id LIKE '%" . trim($args['system_type']) . "%'";
        }
        if (trim($args['user_id']) != '') {
             if(trim($args['user_id']) != 'all'){
             $condition .= "AND qa_audit.qa_ad_user_ref_id = '" . $args['user_id'] . "' ";
             }
        }
        
        if (trim($args['call_type']) != '') {
            if (trim($args['call_type']) != 'all') {
                $condition .= "AND inc.inc_type = '" . $args['call_type'] . "' ";
            }
        }
        if (trim($args['tl_name']) != '') {
            if (trim($args['tl_name']) != 'all_tl') {
            $condition .= "AND colleague.clg_senior = '" . $args['tl_name'] . "' ";
        }
    }

        if (trim($args['tna']) != '') {
            $condition .= "AND qa_audit.tna = '" . $args['tna'] . "' ";
        }

        if (trim($args['shift']) != '') {
           // $condition .= "AND shift.user_id = '" . $args['shift'] . "' ";
        }
        // if (trim($args['shift']) != '') {
        //     $condition .= "AND qa_audit.tna = '" . $args['shift'] . "' ";
        // }

        if (trim($args['fatal_error_indicator']) != '') {
            $condition .= "AND qa_audit.fetal_error_indicator= '" . $args['fatal_error_indicator'] . "' ";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $condition .= " AND qa_audit.added_date BETWEEN '$date 00:00:00' AND '$date 23:59:59'";
        }

       /* $sql = "SELECT qa_audit.*, inc.inc_type,inc.inc_datetime as call_type,inc.inc_datetime, COUNT(*) as qa_count,cl.cl_purpose as purpose,clr.*,inc.inc_type,inc.inc_mci_nature,inc.inc_complaint FROM $this->tbl_quality_audit as qa_audit"
             ." LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = qa_audit.inc_ref_id )"
            . " LEFT JOIN ems_calls AS cl ON ( cl.cl_id = inc.inc_cl_id )"  
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = qa_audit.qa_ad_user_ref_id )"
            . " where qa_audit.is_deleted ='0' $condition group by qa_audit.qa_ad_user_ref_id ORDER BY qa_audit.qa_ad_id ASC ";
        */
        $sql = "SELECT qa_audit.*, inc.inc_type,inc.inc_datetime as call_type,inc.inc_datetime,cl.cl_purpose as purpose,clr.*,inc.inc_type,inc.inc_mci_nature,inc.inc_complaint FROM $this->tbl_quality_audit as qa_audit"
        ." LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = qa_audit.inc_ref_id )"
       . " LEFT JOIN ems_calls AS cl ON ( cl.cl_id = inc.inc_cl_id )"  
       . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
       . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = qa_audit.qa_ad_user_ref_id )"
       . " where qa_audit.is_deleted ='0' $condition group by qa_audit.inc_ref_id  ORDER BY qa_audit.qa_ad_id ASC ";
   
        $result = $this->db->query($sql);
      // echo $this->db->last_query();die;


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

}
