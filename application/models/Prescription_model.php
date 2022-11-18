<?php    

class Prescription_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_schedule = $this->db->dbprefix('schedule');
        $this->tbl_student = $this->db->dbprefix('student');
        $this->tbl_school = $this->db->dbprefix('school');
        $this->stud_prescription = $this->db->dbprefix('stud_prescription');
        $this->stud_hospitalizaion = $this->db->dbprefix('stud_hospitalizaion');
        $this->hosp = $this->db->dbprefix('hospital');
        

    }
    
    function get_prescription($args = array(), $offset = '', $limit = '') {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND pre.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND pre.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND pre.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['pre_id'])) {
            $condition .= " AND pre.id = '" . $args['pre_id'] . "'";
        }
        if(isset($args['pre_search'])){
            $condition .= " AND school.school_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_first_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_last_name LIKE '%" . $args['pre_search'] . "%'";
        }
        if(isset($args['is_approve'])){
            $condition .= " AND pre.is_approve = '" . $args['is_approve'] . "'";
        }
        
        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        
        $sql = "SELECT pre.*,std.stud_first_name,std.stud_middle_name,std.stud_last_name,school.school_name FROM  $this->stud_prescription as pre LEFT JOIN $this->tbl_schedule as sch ON (pre.schedule_id=sch.schedule_id) LEFT JOIN $this->tbl_student as std ON (pre.student_id=std.stud_id) LEFT JOIN  $this->tbl_school as school ON (school.school_id=sch.schedule_schoolid)  where pre.is_deleted='0' $condition  $offlim"; 
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function approve_prescription($pre_id , $args) {


        if($pre_id){            
            
           $this->db->where('id',$pre_id);
           $update = $this->db->update($this->stud_prescription,$args);
          
           if($update){   return true;    }else{  return false; }
       
        }else{
           return false;
        }

    }
    
    function update_prescription($pre_id,$args) {

         $this->db->where('id',$pre_id);

        $data = $this->db->update("$this->stud_prescription", $args);
        return $data;
    }
    function get_hospitalization($args = array(), $offset = '', $limit = '') {
        $condition = '';

        if (isset($args['schedule_id'])) {
            $condition .= "AND pre.schedule_id='" . $args['schedule_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND pre.student_id = '" . $args['stud_id'] . "'";
        }
        if (isset($args['stud_id'])) {
            $condition .= " AND pre.student_id = '" . $args['stud_id'] . "'";
        }
         if (isset($args['hosp_id'])) {
            $condition .= " AND pre.id = '" . $args['hosp_id'] . "'";
        }
        if(isset($args['pre_search'])){
            $condition .= " AND school.school_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_first_name LIKE '%" . $args['pre_search'] . "%' OR std.stud_last_name LIKE '%" . $args['pre_search'] . "%'";
        }
        if (isset($args['is_hosp_null'])) {
            $condition .= " AND pre.hosp_id != ''";
        }
        
        
        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
        
         $sql = "SELECT pre.*,std.stud_first_name,std.stud_middle_name,std.stud_last_name,school.school_name,hp.hp_name FROM  $this->stud_hospitalizaion as pre LEFT JOIN $this->tbl_schedule as sch ON (pre.schedule_id=sch.schedule_id) LEFT JOIN $this->tbl_student as std ON (pre.student_id=std.stud_id) LEFT JOIN  $this->hosp as hp ON (pre.hosp_id=hp.hp_id)  LEFT JOIN  $this->tbl_school as school ON (school.school_id=sch.schedule_schoolid)  where pre.is_deleted='0' $condition  $offlim"; 
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
}
