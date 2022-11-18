<?php    

class Sickroom_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_schedule = $this->db->dbprefix('schedule');
        $this->tbl_student = $this->db->dbprefix('student');
        $this->tbl_school = $this->db->dbprefix('school');
        $this->stud_prescription = $this->db->dbprefix('stud_prescription');
        $this->stud_sick_room = $this->db->dbprefix('stud_sick_room');
        $this->sickroom_assessment = $this->db->dbprefix('sickroom_assessment');
        $this->sickroom_admission = $this->db->dbprefix('sickroom_admission');
        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');

    }
    
    function get_sickroom($args = array(), $offset = '', $limit = '') {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND sick.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND sick.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND sick.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['sick_id'])) {
            $condition .= " AND sick.id = '" . $args['sick_id'] . "'";
        }
         if (isset($args['clg_ref_id'])) {
            $condition .= " AND school.school_heathsupervisior = '" . $args['clg_ref_id'] . "'";
        }
        if(isset($args['sick_search'])){
            $condition .= " AND school.school_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_first_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_last_name LIKE '%" . $args['pre_search'] . "%'";
        }
        
        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        
        $sql = "SELECT sick.*,std.stud_first_name,std.stud_middle_name,std.stud_last_name,school.school_name FROM  $this->stud_sick_room as sick LEFT JOIN $this->tbl_schedule as sch ON (sick.schedule_id=sch.schedule_id) LEFT JOIN $this->tbl_student as std ON (sick.student_id=std.stud_id) LEFT JOIN  $this->tbl_school as school ON (school.school_id=sch.schedule_schoolid)  where sick.is_deleted='0' $condition  $offlim"; 
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function save_sick_asst($args = array()) {

        $res = $this->db->query(" INSERT INTO $this->sickroom_assessment(sick_id,student_id,schedule_id,asst_loc,asst_pulse,asst_rr,asst_bp_syt,asst_bp_dia,asst_o2sat,asst_temp,asst_pt_status,asst_date,asst_base_month,asst_min) 

            VALUES('" . $args['sick_id'] . "','" . $args['student_id'] . "','" . $args['schedule_id'] . "','" . $args['asst_loc'] . "','" . $args['asst_pulse'] . "','" . $args['asst_rr'] . "','" . $args['asst_bp_syt'] . "','" . $args['asst_bp_dia'] . "','" . $args['asst_o2sat'] . "','" . $args['asst_temp'] . "','" . $args['asst_pt_status'] . "','" . $args['asst_date'] . "','" . $args['asst_base_month'] . "','" . $args['asst_min'] . "')

            ON DUPLICATE KEY UPDATE sick_id = '" . $args['sick_id'] . "',student_id = '" . $args['student_id'] . "',schedule_id = '" . $args['schedule_id'] . "',asst_loc='" . $args['asst_loc'] . "',asst_pulse='" . $args['asst_pulse'] . "',asst_rr='" . $args['asst_rr'] . "',asst_bp_syt='" . $args['asst_bp_syt'] . "',asst_bp_dia='" . $args['asst_bp_dia'] . "',asst_o2sat='" . $args['asst_o2sat'] . "',asst_temp='" . $args['asst_temp'] . "',asst_pt_status='" . $args['asst_pt_status'] . "',asst_date='" . $args['asst_date'] . "',asst_base_month='" . $args['asst_base_month'] . "',asst_min='" . $args['asst_min'] . "'"
        );




        return $res;
    }
    function updte_sickroom_details($args = array(), $data = array()) {

        $this->db->where('student_id', $args['student_id']);
        $this->db->where('schedule_id', $args['schedule_id']);

        $res = $this->db->update($this->stud_sick_room, $data);
        return $res;
    }
    
    function get_sick_asst($args = array()) {

        $condition = "";

        if ($args['sick_id']) {
            $condition.= " AND sick_asst.sick_id='" . $args['sick_id'] . "'";
        }

        if ($args['asst_min']) {
            $condition.= " AND sick_asst.asst_min='" . $args['asst_min'] . "'";
        } else {
            $condition.= " AND sick_asst.asst_min='0'";
        }

        $result = $this->db->query("
            SELECT sick_asst.*,loc_level.level_type 
            FROM   $this->sickroom_assessment as sick_asst 
            LEFT JOIN $this->tbl_loc_level as loc_level ON(sick_asst.asst_loc=loc_level.level_id) 
            WHERE  sick_asst.asst_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND sick_asst.asst_isdeleted='0'  
            $condition");



        return $result->result();
    }
    
    function get_sickroom_addmission($args = array(), $offset = '', $limit = '') {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND sick.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND sick.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND sick.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['sick_id'])) {
            $condition .= " AND sick.id = '" . $args['sick_id'] . "'";
        }
      
        if(isset($args['sick_search'])){
            $condition .= " AND school.school_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_first_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_last_name LIKE '%" . $args['pre_search'] . "%'";
        }
        
        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        
        $sql = "SELECT sick.*,std.stud_first_name,std.stud_middle_name,std.stud_last_name,school.school_name FROM  $this->sickroom_admission as sick LEFT JOIN $this->tbl_student as std ON (sick.student_id=std.stud_id) LEFT JOIN  $this->tbl_school as school ON (school.school_id=sick.school_id)  where sick.is_deleted='0' $condition  $offlim"; 
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function insert_add_sickroom_details($args){
          $result = $this->db->insert($this->sickroom_admission, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
}
