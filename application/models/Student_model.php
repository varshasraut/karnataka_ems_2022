<?php

class Student_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_schedule = $this->db->dbprefix('schedule');
        $this->tbl_school = $this->db->dbprefix('school');
        $this->tbl_stud_schedule = $this->db->dbprefix('stud_schedule');
        $this->tbl_student = $this->db->dbprefix('student');
        $this->stud_basic_info = $this->db->dbprefix('stud_basic_info');
        $this->stud_screening = $this->db->dbprefix('stud_screening');
        $this->stud_ent = $this->db->dbprefix('student_ent');
        $this->stud_vision = $this->db->dbprefix('student_vision');
    }
     
     function get_all_students($args, $offset = '', $limit = '',$filter = '',$sortby = ''){
        
         $condition = $offlim = '';

        if (isset($args['stud_id'])) {
            $condition .= "AND stud.stud_id='" . $args['stud_id'] . "'";
        }
        if (isset($args['stud_reg_no'])) {
            $condition .= "AND stud.stud_reg_no='" . $args['stud_reg_no'] . "'";
        }
        if (isset($args['stud_status'])) {
            $condition .= "AND stud.stud_status='" . $args['stud_status'] . "'";
        }
        if (isset($args['school_warden'])) {
            $condition .= "AND school.school_warden='" . $args['school_warden'] . "'";
        }
        if (isset($args['school_heathsupervisior'])) {
            $condition .= "AND school.school_heathsupervisior='" . $args['school_heathsupervisior'] . "'";
        }
        if (isset($args['school_headmastername'])) {
            $condition .= "AND school.school_headmastername='" . $args['school_headmastername'] . "'";
        }
    
          if ($filter != '') {

            $condition .= " AND (stud.stud_last_name LIKE '%".trim($filter)."%' OR stud.stud_middle_name LIKE '%".trim($filter)."%' OR stud.stud_first_name LIKE '%".trim($filter)."%')";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

         $sql = "SELECT stud.*,school.* FROM  $this->tbl_student as stud LEFT JOIN $this->tbl_school as school ON (stud.schd_school_id = school.school_id) where stud.stud_isdeleted='0' AND school.school_type='school' $condition ORDER BY stud.stud_first_name  $offlim ";
        
       
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_students($args, $offset = '', $limit = '',$filter = '',$sortby = ''){
        
         $condition = $offlim = '';

        if (isset($args['stud_id'])) {
            $condition .= "AND stud.stud_id='" . $args['stud_id'] . "'";
        }
        if (isset($args['stud_reg_no'])) {
            $condition .= "AND stud.stud_reg_no='" . $args['stud_reg_no'] . "'";
        }
    
          if ($filter != '') {

            $condition .= " AND (stud.stud_last_name LIKE '%" . $filter. "%' OR stud.stud_middle_name LIKE '%" . $filter. "%' OR stud.stud_first_name LIKE '%" . $filter. "%')";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT stud.*,school.* FROM  $this->tbl_student as stud LEFT JOIN $this->tbl_school as school ON (stud.schd_school_id = school.school_id) where stud.stud_isdeleted='0' AND stud.stud_status='0' AND school.school_type='school' $condition ORDER BY stud.stud_first_name  $offlim ";
        
       
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_stud_schedule() {
         $sql = "SELECT stud_sche.* FROM  $this->tbl_stud_schedule as stud_sche";
               
        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
        
    }
    
    function get_search_stud_by_shedule_id($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['schedule_id'])) {

            $condition .= "AND stud_sche.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['reg_no'])) {

            $condition .= " AND stud.stud_reg_no LIKE '%".$args['reg_no']."%'";
        }
        if (isset($args['first_name'])) {

            $condition .= " AND stud.stud_first_name LIKE '%".$args['first_name']."%'";
        }
        if (isset($args['last_name'])) {

            $condition .= " AND stud.stud_last_name LIKE '%".$args['last_name']."%'";
        }
        if (isset($args['stud_id'])) {
            $condition .= "AND stud.stud_id='" . $args['stud_id'] . "'";
//            $condition .= " AND stud.stud_id LIKE '%" . $args['stud_id'] . "%'";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT stud.* FROM  $this->tbl_student as stud LEFT JOIN $this->tbl_stud_schedule as stud_sche ON (stud.stud_id = stud_sche.stud_id) where stud.stud_isdeleted='0' $condition ORDER BY stud.stud_first_name $offlim ";
        
       
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function update_stud_status($args = array()) {
        $this->db->set('stud_status', '1');
        $this->db->where('stud_id', $args['stud_id']);
        $data = $this->db->update($this->tbl_student);
        return $data;
    }

    function insert_stud_basic_info($args = array()) {
        $result = $this->db->insert($this->stud_basic_info, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function get_stud_basic_info($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND st_in.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {

            $condition .= " AND st_in.student_id = '" . $args['stud_id'] . "'";
        }

         $sql = "SELECT st_in.* FROM  $this->stud_basic_info as st_in where st_in.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function updte_student_details($args = array(), $data = array()) {

        $this->db->where('stud_id', $args['stud_id']);

        $res = $this->db->update($this->tbl_student, $data);
       // echo $this->db->last_query();
        return $res;
    }

    function update_stud_basic_info($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_basic_info", $args);
        return $data;
    }

    function get_stud_screening($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND st_scr.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {

            $condition .= " AND st_scr.student_id = '" . $args['stud_id'] . "'";
        }

        $sql = "SELECT st_scr.* FROM  $this->stud_screening as st_scr where st_scr.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_screening($args = array()) {

        $result = $this->db->insert($this->stud_screening, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_screening($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_screening", $args);
        return $data;
    }
    function insert_students($args){
         $result = $this->db->insert($this->tbl_student, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

     function delete_stud($stud_id = array(), $status = '') {



        $this->db->where_in('stud_id', $stud_id);



        $status = $this->db->update($this->tbl_student, $status);



        return $status;
    }
    
    function get_last_schedule($args,$offset=''){
        if (isset($args['stud_id'])) {
            $condition .= " stud_sch.stud_id='" . $args['stud_id'] . "'";
        }
        if($offset == ''){
            $offset =1;
        }
          $sql = "SELECT stud_sch.*,sch.schedule_date FROM  $this->tbl_stud_schedule as stud_sch LEFT JOIN $this->tbl_schedule as sch ON (stud_sch.schedule_id = sch.schedule_id) where  $condition ORDER BY sch.schedule_date DESC LIMIT 0, $offset";
        
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_screening_by_date($args = array()) {

        $condition = '';

        if ($args['from_date'] != '' && $args['to_date']!= '') {
            
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND st_scr.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT st_scr.* FROM  $this->stud_screening as st_scr where st_scr.is_deleted='0' $condition  ";
        
        

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_screening_atc_by_date($args = array()) {



        $condition = '';

        if ($args['from_date'] != '' && $args['to_date']!= '') {
            
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND st_scr.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (isset($args['cluster_id']) && $args['cluster_id'] != '') {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND sch.schedule_clusterid IN ($cluster_id)";
        }

         if (isset($args['school_id']) && $args['school_id'] != '') {
            $school_id= $args['school_id'];
            $condition .= " AND sch.schedule_schoolid IN ('$school_id')";
        }

        $sql = "SELECT st_scr.birth_deffects,st_scr.deficiencies,st_scr.skin_condition,st_scr.childhood_disease,st_scr.orthopedics,st_scr.orthopedics,st_scr.checkbox_if_normal,st_scr.diagnosis FROM $this->stud_screening as st_scr LEFT JOIN $this->tbl_schedule as sch ON (st_scr.schedule_id = sch.schedule_id) where st_scr.is_deleted='0' $condition  "; 

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_ent_atc_by_date($args = array()) {



        $condition = '';

        if ($args['from_date'] != '' && $args['to_date']!= '') {
            
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND st_ent.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (isset($args['cluster_id']) && $args['cluster_id'] != '') {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND sch.schedule_clusterid IN ($cluster_id)";
        }

         if (isset($args['school_id']) && $args['school_id'] != '') {
            $school_id= $args['school_id'];
            $condition .= " AND sch.schedule_schoolid IN ('$school_id')";
        }

         $sql = "SELECT st_ent.* FROM  $this->stud_ent as st_ent LEFT JOIN $this->tbl_schedule as sch ON (st_ent.schedule_id = sch.schedule_id) where st_ent.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_vision_atc_by_date($args = array()) {

        $condition = '';

        if ($args['from_date'] != '' && $args['to_date']!= '') {
            
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND st_vision.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (isset($args['cluster_id']) && $args['cluster_id'] != '') {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND sch.schedule_clusterid IN ($cluster_id)";
        }

         if (isset($args['school_id']) && $args['school_id'] != '') {
            $school_id= $args['school_id'];
            $condition .= " AND sch.schedule_schoolid IN ('$school_id')";
        }

        $sql = "SELECT st_vision.* FROM  $this->stud_vision as st_vision LEFT JOIN $this->tbl_schedule as sch ON (st_vision.schedule_id = sch.schedule_id) where st_vision.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_students_by_school($args){
        
         $condition = '';

        if (isset($args['school_id'])) {
            $condition .= "AND stud.schd_school_id='" . $args['school_id'] . "'";
        }

        $sql = "SELECT stud.* FROM  $this->tbl_student as stud LEFT JOIN $this->tbl_school as school ON (stud.schd_school_id = school.school_id) where stud.stud_isdeleted='0' AND school.school_type='school' $condition ORDER BY stud.stud_first_name ";

        $result = $this->db->query($sql);

        return $result->result();
       
    }

}
