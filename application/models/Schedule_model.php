<?php

class Schedule_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_schedule = $this->db->dbprefix('schedule');
        $this->tbl_school = $this->db->dbprefix('school');
        $this->tbl_student = $this->db->dbprefix('student');
        $this->tbl_cluster = $this->db->dbprefix('cluster');
        $this->tbl_stud_schedule = $this->db->dbprefix('stud_schedule');
    }

    function get_sch_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';


        if (isset($args['schedule_id'])) {

            $condition .= "AND sch.schedule_id='" . $args['schedule_id'] . "'";
        }

        if (isset($args['is_forward'])) {

            $condition .= "AND sch.schedule_fwdshpm='" . $args['is_forward'] . "'";
        }

        if (isset($args['schedule_isaprove'])) {

            $condition .= "AND sch.schedule_isaprove='" . $args['schedule_isaprove'] . "'";
        }
//        if (isset($args['schedule_clusterid'])) {
//      
//
//            $condition .= "AND sch.schedule_clusterid='" . $args['schedule_clusterid'] . "'";
//        }
        if (isset($args['schedule_clusterid'])) {
            $string = $args['schedule_clusterid'];
            $array = array_map('intval', explode(',', $string));
            $array = implode("','", $array);
            $condition .= "AND sch.schedule_clusterid IN ('" . $array . "')";
        }

        if (isset($args['schedule_item'])) {
            $schedule_date = date('Y-m-d', strtotime($args['schedule_item']));
            $condition .= "AND (cl.cluster_name LIKE '%" . $args['schedule_item'] . "%' OR sc.school_name LIKE '%" . $args['schedule_item'] . "%' OR sch.schedule_date = '$schedule_date')";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT sch.* FROM  $this->tbl_schedule as sch INNER JOIN  $this->tbl_school AS sc ON sch.schedule_schoolid = sc.school_id INNER JOIN  $this->tbl_cluster AS cl ON sch.schedule_clusterid = cl.cluster_id where sch.schedule_isdeleted='0' AND sch.school_type='school' $condition ORDER BY sch.schedule_date DESC $offlim ";

        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_schedule_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';


        if (isset($args['schedule_id'])) {

            $condition .= " AND sch.schedule_id='" . $args['schedule_id'] . "'";
        }

        if (isset($args['is_forward'])) {

            $condition .= " AND sch.schedule_fwdshpm='" . $args['is_forward'] . "'";
        }

        if (isset($args['schedule_isaprove'])) {

            $condition .= " AND sch.schedule_isaprove='" . $args['schedule_isaprove'] . "'";
        }
         if ((isset($args['filter'])) && $args['filter'] != '') {

            $condition .= " AND sch.schedule_isaprove='" . $args['filter'] . "' ";
        }
        if (isset($args['schedule_clusterid']) && $args['schedule_clusterid'] != "") {

            $condition .= " AND sch.schedule_clusterid IN (" . $args['schedule_clusterid'] . ")";
        }


        if (isset($args['schedule_item'])) {
            $schedule_date = date('Y-m-d', strtotime($args['schedule_item']));
            $condition .= "AND (cl.cluster_name LIKE '%" . $args['schedule_item'] . "%' OR sc.school_name LIKE '%" . $args['schedule_item'] . "%' OR sch.schedule_date = '$schedule_date')";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

         $sql = "SELECT sch.*,sc.school_name,school_address,school_headmastername, school_id, school_mobile, cluster_name FROM  $this->tbl_schedule as sch INNER JOIN  $this->tbl_school AS sc ON sch.schedule_schoolid = sc.school_id INNER JOIN  $this->tbl_cluster AS cl ON sch.schedule_clusterid = cl.cluster_id where sch.schedule_isdeleted='0' AND sc.school_type='school' $condition ORDER BY sch.schedule_date DESC $offlim ";

        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    ////////////////MI44////////////////////
    //

    //Purpose:delete ambulance
    //

    ////////////////////////////////////////



    function delete_schedule($schedule_id = array(), $status = '') {



        $this->db->where_in('schedule_id', $schedule_id);



        $status = $this->db->update($this->tbl_schedule, $status);



        return $status;
    }

    function insert_schedule($args = array()) {

        $result = $this->db->insert($this->tbl_schedule, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    

    function update_schedule($args = array()) {

        if ($args['schedule_id']) {
            $this->db->where('schedule_id', $args['schedule_id']);
            $update = $this->db->update($this->tbl_schedule, $args);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function approve_schedule($schedule_id, $args) {


        if ($schedule_id) {

            $this->db->where('schedule_id', $schedule_id);
            $update = $this->db->update($this->tbl_schedule, $args);
            //echo $this->db->last_query();
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function get_student_list_to_schedule($args = array()) {
        $condition = $offlim = '';



        if (isset($args['school_id'])) {

            $condition .= " AND sc.schd_school_id='" . $args['school_id'] . "'";
        }

        if (isset($args['stud_id'])) {

            $condition .= "  OR (sc.stud_id IN ('" . $args['stud_id'] . "') )";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }


         $sql = "SELECT sc.* FROM  $this->tbl_student as sc where sc.stud_isdeleted='0' AND stud_status IN ('2','1') $condition order by FIELD(`stud_status`, '2','1') ASC $offlim ";
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_student_list_schedule_data($args = array(), $offset = '', $limit = '') {



        $condition = $offlim = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND sch.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['school_id'])) {

            $condition .= "AND sch.schedule_schoolid='" . $args['school_id'] . "'";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }


        $sql = "SELECT sch.*, school_name, school_headmastername, school_id, school_mobile , stud_first_name, stud_middle_name, stud_last_name,
								student_std, stud_gender, stud_age 
								FROM  $this->tbl_schedule as sch INNER JOIN  $this->tbl_school AS sc ON sch.schedule_schoolid = sc.school_id  
								INNER JOIN  $this->tbl_student AS st ON sc.school_id = st.schd_school_id 
								where sch.schedule_isdeleted='0' AND sc.school_type='school' $condition  $offlim ";
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

/////////////MI44////////////////////////////////////////////////////
    //

    //Purpose : ftech all cluster name from ems_school
    //

    ///////////////////////////////////////////////////////////////////



    function get_cluster($args) {
        $condition = '';

        if (trim($args['cluster_name']) != '') {
            $condition .= " AND cluster_name LIKE '%" . $args['cluster_name'] . "%' ";
        }
    
        if (($args['cluster_id'])) {
            $condition .= " AND cluster_id IN (" . $args['cluster_id'] . ")";
        }
         if (($args['po_id'])) {
            $condition .= " AND po IN (" . $args['po_id'] . ")";
        }

        $sql = " SELECT * FROM $this->tbl_cluster WHERE isdeleted='0' $condition";
        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function forword_to_shpm($args = array(), $status = '') {


        if ($args['schedule_id']) {
            $this->db->where('schedule_id', $args['schedule_id']);
            $update = $this->db->update($this->tbl_schedule, $args);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function insert_schedule_student($args = array()) {

        $result = $this->db->insert($this->tbl_stud_schedule, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function delete_schedule_student($schedule_id = array(), $status = '') {



        if($schedule_id['schedule_id'] != ''){
        $this->db->where('schedule_id', $schedule_id['schedule_id']);
        $status = $this->db->delete($this->tbl_stud_schedule);
        return $status;
        }
    }

}
