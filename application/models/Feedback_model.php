<?php

class Feedback_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_feed = $this->db->dbprefix('feedback');

        $this->tbl_cct = $this->db->dbprefix('mas_feedback_type');

        $this->tbl_feedt_que = $this->db->dbprefix('feed_type_questions');

        $this->tbl_que = $this->db->dbprefix('mas_questionnaire');

        $this->tbl_ans = $this->db->dbprefix('mas_default_ans');

        $this->tbl_optby = $this->db->dbprefix('operateby');
        $this->tbl_incidence = $this->db->dbprefix('incidence');

        $this->tbl_feedback_call_details = $this->db->dbprefix('feedback_call_details');
        $this->tbl_feedback_standard_remark = $this->db->dbprefix('mas_feedback_standard_remark');
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To get call feedback type.
    // 
    /////////////////////////////////////////
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
            . " FROM $this->tbl_feedback_call_details AS fcall"
            . " WHERE 1=1 $condition group by fc_inc_ref_id";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_fdbk_type($args = array()) {


        if (trim($args['fdbk_type']) != '') {
            $condition = " AND fdt_type like '%" . $args['fdbk_type'] . "%' ";
        }
        if ($args['fdt_id'] != '') {
            $condition = " AND fdt_id=" . $args['fdt_id'] . " ";
        }

        $result = $this->db->query("select * from $this->tbl_cct where fdt_status='1' AND fdtis_deleted='0' $condition");

        return $result->result();
    }

    function get_feedback_call_detials($args = array()) {
//var_dump($args); die;
        $condition = "";

        if ($args['inc_ref_id']) {

            $condition .= " AND fc_inc_ref_id='" . trim($args['inc_ref_id']) . "' ";
        }


        $sql = "SELECT fc_employee_remark "
            . "FROM  $this->tbl_feedback_call_details "
            . "WHERE fc_is_deleted='1' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    //// Created by MI42 ///////////////////////////////////
    // 
    // Purpose : To get feedback question on feedback type.
    // 
    ////////////////////////////////////////////////////////

    function get_fdbk_qa($args = array()) {


        if (trim($args['ft_id']) != '') {
            $condition = " AND fdt_type like '%" . $args['ft_id'] . "%' ";
        }

        $result = $this->db->query(""
            . "SELECT que.que_id,que.que_question,ans.ans_answer "
            . "from $this->tbl_cct as ft "
            . "left join $this->tbl_feedt_que  as fdq on (ft.fdt_id=fdq.ft_id) "
            . "left join $this->tbl_que as que on (fdq.que_id=que.que_id) "
            . "left join $this->tbl_ans as ans on (que.que_id=ans.ans_que_id) "
            . "where ft.fdt_id='" . $args['ft_id'] . "' order by que.que_id ASC");



        return $result->result();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To add feedback details.
    // 
    /////////////////////////////////////////

    function add($args = array()) {

        $this->db->insert($this->tbl_feed, $args);

        return $this->db->insert_id();
    }
    function update_incident($args) {

        $this->db->where_in('fc_inc_ref_id', $args['inc_ref_id']);
        $data = $this->db->update("$this->tbl_feedback_call_details", $args);
       // echo $this->db->last_query($result);die;
        return $data;
    }
    function add_feedback($args = array()) {

        $this->db->insert($this->tbl_feedback_call_details, $args);

        return $this->db->insert_id();
    }

    function update_feedback($args = array()) {

        $this->db->insert($this->tbl_feedback_call_details, $args);

        return $this->db->insert_id();
    }

    function get_feedback_details($args = array()) {


        $condition = $offlim = '';



        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        if ($args['inc_ref_id'] != '') {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


        if( $args['inc_ref_id'] != ''){
            
            $sql = "SELECT *"
                . " FROM $this->tbl_incidence AS inc"
                . " LEFT JOIN $this->tbl_feedback_call_details AS feed_call ON ( feed_call.fc_inc_ref_id = inc.inc_ref_id )"
                . " WHERE  inc.inc_duplicate ='No' AND inc.incis_deleted = '0' $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";



            $result = $this->db->query($sql);

            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
            
        }else{
            return false;
        }
    }

    function get_feedback_details_by_user($args = array()) {

        $condition = $offlim = '';

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND feed_call.fc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
//         if ($args['from_date'] != '' && $args['to_date'] != '') {
//            $from = $args['from_date'];
//            $to = $args['to_date'];
//            $condition .= "AND feed_call.fc_added_date BETWEEN '$from' AND '$to 23:59:59'";
//        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['inc_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND feed_call.fc_added_by='" . $args['operator_id'] . "' ";
        }
        
        if ($args['child_feedback']) {
            $condition .= " AND feed_call.fc_added_by IN ('" . $args['child_feedback'] . "') ";
        }


        if ($args['feedback_id']) {
            $filter_cond .= " AND  (feed_call.fc_added_by ='" . $args['feedback_id'] . "')";
        }
        if ($sortby['date'] != "") {
            $sortby_sql = " AND inc.inc_datetime = '" . $sortby['date'] . "'";
        }
        
        if($args['clg_user_group'] == 'UG-FeedbackManager')
        {
            $condition .= " AND inc.inc_feedback_status ='1' ";
        }else{
            $condition .= " AND inc.inc_feedback_status ='0' ";
        }   

         $sql = "SELECT *"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_feedback_call_details AS feed_call ON ( feed_call.fc_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_mas_feedback_standard_remark AS feedback_remak ON (feedback_remak.fdsr_id = feed_call.fc_standard_type )"
            . " WHERE  inc.inc_duplicate ='No' AND inc.incis_deleted = '0'  $condition $filter_cond GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
        //echo $sql;
        //die();
        
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

     function get_feedback_reports($args = array()) {

        $condition = $offlim = '';
//var_dump($args);die;
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND feed_call.fc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if ($args['operator_id']) {
            $condition .= " AND feed_call.fc_added_by='" . $args['operator_id'] . "' ";
        }
        
        if ($args['child_feedback']) {
            $condition .= " AND feed_call.fc_added_by IN ('" . $args['child_feedback'] . "') ";
        }


        if ($args['feedback_id']) {
            $filter_cond .= " AND  (feed_call.fc_added_by ='" . $args['feedback_id'] . "')";
        }


        //  $sql = "SELECT *"
            // . " FROM $this->tbl_feedback_call_details AS feed_call WHERE  inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_feedback_status ='0' $condition $filter_cond GROUP BY feed_call.fc_inc_ref_id  ORDER BY feed_call.fc_dispatch_date_time DESC $offlim";
          $sql =  "SELECT feed_call.*,inc.*,feed.*"
            . " FROM $this->tbl_feedback_call_details AS feed_call"
          
            . " LEFT JOIN $this->tbl_incidence AS inc ON ( feed_call.fc_inc_ref_id= inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_feedback_standard_remark AS feed ON ( feed_call.fc_standard_type= feed.fdsr_id )"
            . " WHERE  inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_feedback_status ='1' $condition $filter_cond GROUP BY feed_call.fc_inc_ref_id  ORDER BY feed_call.fc_dispatch_date_time DESC $offlim";
        
        $result = $this->db->query($sql);
       // echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
            
        } else {
            return $result->result();
        }
    }

}
