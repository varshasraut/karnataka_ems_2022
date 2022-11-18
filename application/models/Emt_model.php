<?php

class Emt_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_schedule = $this->db->dbprefix('schedule');
        $this->tbl_stud_schedule = $this->db->dbprefix('stud_schedule');
        $this->tbl_student = $this->db->dbprefix('student');
        $this->stud_basic_info = $this->db->dbprefix('stud_basic_info');
        $this->stud_screening = $this->db->dbprefix('stud_screening');
        $this->stud_dental = $this->db->dbprefix('student_dental');
        $this->stud_vision = $this->db->dbprefix('student_vision');
        $this->stud_ent = $this->db->dbprefix('student_ent');
        $this->stud_medicle_exam = $this->db->dbprefix('stud_medicle_exam');
        $this->stud_prescription = $this->db->dbprefix('stud_prescription');
        $this->stud_investigation = $this->db->dbprefix('stud_investigation');
        $this->stud_sick_room = $this->db->dbprefix('stud_sick_room');
        $this->stud_hospitalizaion = $this->db->dbprefix('stud_hospitalizaion');
        $this->screening_steps = $this->db->dbprefix('screening_steps');
        $this->hospital = $this->db->dbprefix('hospital');
    }

     function get_hospital($args = array()) {
        $condition = "";
        if (isset($args['hp_name'])) {
            $condition .= "AND hp_name LIKE '%" . $args['hp_name'] . "%'";
        }

        $sql = "SELECT hosp.* FROM  $this->hospital as hosp where hosp.hpis_deleted='0' $condition  ";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
            function get_emplanned_hospital($args = array()) {
        $condition = "";
        if (isset($args['hp_name'])) {
            $condition .= "AND hp_name LIKE '%" . $args['hp_name'] . "%'";
        }

        $sql = "SELECT hosp.* FROM  $this->hospital as hosp where hosp.hpis_deleted='0' AND hosp.hp_type='1' $condition  ";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_govt_hospital($args = array()) {
      $condition = "";
        if (isset($args['hp_name'])) {
            $condition .= "AND hp_name LIKE '%" . $args['hp_name'] . "%'";
        }

        $sql = "SELECT hosp.* FROM  $this->hospital as hosp where hosp.hpis_deleted='0' AND hosp.hp_type='2' $condition  ";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_stud_dental($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND dental.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {

            $condition .= " AND dental.student_id = '" . $args['stud_id'] . "'";
        }

        $sql = "SELECT dental.* FROM  $this->stud_dental as dental where dental.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_dental($args = array()) {

        $result = $this->db->insert($this->stud_dental, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_dental($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_dental", $args);
        return $data;
    }

    function get_stud_vision($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND vision.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {

            $condition .= " AND vision.student_id = '" . $args['stud_id'] . "'";
        }

        $sql = "SELECT vision.* FROM  $this->stud_vision as vision where vision.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_vision($args = array()) {

        $result = $this->db->insert($this->stud_vision, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_vision($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_vision", $args);
        return $data;
    }

    function get_stud_ent($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND ent.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {

            $condition .= " AND ent.student_id = '" . $args['stud_id'] . "'";
        }

        $sql = "SELECT ent.* FROM  $this->stud_ent as ent where ent.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_ent($args = array()) {

        $result = $this->db->insert($this->stud_ent, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_ent($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_ent", $args);
        return $data;
    }

    function get_stud_medicle_exam_dignosis($args = array()) {

        $condition = '';
        if (isset($args['schedule_id'])) {
            $condition .= "AND medical_exam.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND medical_exam.student_id = '" . $args['stud_id'] . "'";
        }

        $sql = "SELECT medical_exam.diagnosis_name FROM  $this->stud_medicle_exam as medical_exam where medical_exam.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);


        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_stud_medicle_exam($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND medical_exam.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {

            $condition .= " AND medical_exam.student_id = '" . $args['stud_id'] . "'";
        }

        $sql = "SELECT medical_exam.* FROM  $this->stud_medicle_exam as medical_exam where medical_exam.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_medicle_exam($args = array()) {

        $result = $this->db->insert($this->stud_medicle_exam, $args);
        // echo $this->db->last_query();
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_medicle_exam($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_medicle_exam", $args);
        //echo $this->db->last_query();
        return $data;
    }

    function get_stud_investigation($args = array()) {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND investigation.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND investigation.student_id = '" . $args['stud_id'] . "'";
        }
        $sql = "SELECT investigation.* FROM  $this->stud_investigation as investigation where investigation.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_investigation($args = array()) {

        $result = $this->db->insert($this->stud_investigation, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_investigation($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_investigation", $args);
        return $data;
    }

    function get_stud_prescription($args = array()) {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND prescription.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND prescription.student_id = '" . $args['stud_id'] . "'";
        }
         $sql = "SELECT prescription.* FROM  $this->stud_prescription as prescription where prescription.is_deleted='0' $condition  ";
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_prescription($args = array()) {

        $result = $this->db->insert($this->stud_prescription, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_prescription($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_prescription", $args);
        return $data;
    }

    function get_stud_sickroom($args = array()) {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND sick.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND sick.student_id = '" . $args['stud_id'] . "'";
        }
        if ($args['from_date'] != '' && $args['to_date']!= ''){
            $from = $args['from_date'];
            $to = $args['to_date']; 
            $condition .= " AND sick.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
       
        $sql = "SELECT sick.* FROM  $this->stud_sick_room  as sick where sick.is_deleted='0' $condition  ";
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_sickroom($args = array()) {

        $result = $this->db->insert($this->stud_sick_room, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_sickroom($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_sick_room", $args);
        return $data;
    }

    function get_stud_hospitalizaion($args = array()) {



        $condition = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND hospitalizaion.schedule_id='" . $args['schedule_id'] . "'";
        }
        
        if (isset($args['stud_id'])) {

            $condition .= " AND hospitalizaion.student_id = '" . $args['stud_id'] . "'";
        }
        
        if ($args['from_date'] != '' && $args['to_date']!= ''){   
            
            $from = $args['from_date'];
            $to = $args['to_date']; 
            $condition .= " AND hospitalizaion.added_date BETWEEN '$from' AND '$to 23:59:59'";
            
        }

        $sql = "SELECT hospitalizaion.* FROM  $this->stud_hospitalizaion as hospitalizaion where hospitalizaion.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function insert_stud_hospitalizaion($args = array()) {

        $result = $this->db->insert($this->stud_hospitalizaion, $args);
        // echo $this->db->last_query();
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function update_stud_hospitalizaion($args) {

        $this->db->where_in('schedule_id', $args['schedule_id']);
        $this->db->where_in('student_id', $args['student_id']);

        $data = $this->db->update("$this->stud_hospitalizaion", $args);
        return $data;
    }

    function get_sreening_steps($args = array()) {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND steps.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['student_id'])) {
            $condition .= " AND steps.student_id = '" . $args['student_id'] . "'";
        }
        $sql = "SELECT steps.* FROM  $this->screening_steps as steps where steps.is_deleted='0' $condition  ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function insert_screening_steps($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->screening_steps");
        $this->db->where("$this->screening_steps.schedule_id", $args['schedule_id']);
        $this->db->where("$this->screening_steps.student_id", $args['student_id']);

        $fetched = $this->db->get();
        $present = $fetched->result();


        if (count($present) == 0) {

            $result = $this->db->insert($this->screening_steps, $args);

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {
            $this->db->where("$this->screening_steps.schedule_id", $args['schedule_id']);
            $this->db->where("$this->screening_steps.student_id", $args['student_id']);
            $res = $this->db->update($this->screening_steps, $args);

            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
    }

}
