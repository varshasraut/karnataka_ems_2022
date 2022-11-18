<?php

class School_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_school = $this->db->dbprefix('school');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_cluster = $this->db->dbprefix('cluster');
        $this->tbl_atc = $this->db->dbprefix('mas_atc');
        $this->tbl_po = $this->db->dbprefix('mas_po');
        $this->tbl_student = $this->db->dbprefix('student');
        $this->stud_screening = $this->db->dbprefix('stud_screening');
        $this->sms_recipients = $this->db->dbprefix('sms_recipients');
        
        
        
       
    }
    function get_school_data($args = array(), $offset = '', $limit = '') {



        $condition = $offlim = '';



        if (isset($args['school_id'])) {

            $condition .= "AND scl.school_id='" . $args['school_id'] . "'";
        }
          if (isset($args['school_name'])) {

            $condition .= " AND scl.school_name LIKE '%".trim($args['school_name'])."%'";
        }
        if (isset($args['mob_no'])) {

            $condition .= " AND scl.school_mobile LIKE '%".trim($args['mob_no'])."%'";
        }
         if (isset($args['cluster_id'])) {

            $condition .= " AND clu.cluster_id IN (".$args['cluster_id'].")";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }


         $sql = "SELECT scl.*,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,sup.clg_mid_name as sup_mid_name ,sup.clg_last_name as sup_last_name,clg.clg_first_name as sup_first_name,clu.cluster_name FROM  $this->tbl_school as scl LEFT JOIN $this->tbl_colleague as clg ON (scl.school_headmastername = clg.clg_ref_id) LEFT JOIN $this->tbl_colleague as sup ON (scl.school_headmastername = sup.clg_ref_id) LEFT JOIN $this->tbl_cluster as clu ON (scl.cluster_id = clu.cluster_id) where scl.school_isdeleted='0' AND scl.school_type='school'  $condition  $offlim ";

        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
     /////////////Poonam////////////////////////////////////////////////////
    //

    //Purpose : ftech all school name from ems_school
    //

    ///////////////////////////////////////////////////////////////////



    function get_school_type($args) {

        if (trim($args['school_name']) != '') {
            $condition = " AND school_name LIKE '" . $args['school_name'] . "%' ";
        }
        if (trim($args['cluster_id']) != '') {
            $condition = " AND cluster_id IN ('" . $args['cluster_id'] . "') ";
        }
        if (trim($args['health_sup']) != '') {
            $condition = " AND school_heathsupervisior = '" . $args['health_sup'] . "' ";
        }
        
         $sql = " SELECT * FROM $this->tbl_school WHERE school_isdeleted='0' AND school_type='school'  $condition";
        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
        function insert_school($args){
         $result = $this->db->insert($this->tbl_school, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

     function delete_school($school_id = array(), $status = '') {



        $this->db->where_in('school_id', $school_id);



        $status = $this->db->update($this->tbl_school, $status);



        return $status;
    }
    
    function updte_school_details($args = array(), $data = array()) {

        $this->db->where('school_id', $args['school_id']);

        $res = $this->db->update($this->tbl_school, $data);

        return $res;
    }
    function get_school_data_report($args = array(), $offset = '', $limit = '') {



        $condition = $offlim = '';

        if (isset($args['cluster_id']) && $args['cluster_id'] != '') {

            $condition .= " AND clu.cluster_id IN (".$args['cluster_id'].")";
        }


         $sql = "SELECT scl.school_name,scl.cluster_id,scl.school_id,clu.cluster_name,atc.atc_name,po.po_name FROM  $this->tbl_school as scl LEFT JOIN $this->tbl_cluster as clu ON (scl.cluster_id = clu.cluster_id) LEFT JOIN $this->tbl_atc as atc ON (atc.atc_id = clu.atc) LEFT JOIN $this->tbl_po as po ON (po.po_id = clu.po) where scl.school_isdeleted='0' AND scl.school_type='school'  $condition  ";

        $result = $this->db->query($sql);



        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_school_student_screening($args = array()){
        
        $condition = '';

        if (isset($args['school_id'])) {

            $condition .= " AND std.schd_school_id = '" . $args['school_id'] . "'";
        }
        if ($args['from_date'] != '' && $args['to_date']!= ''){
            $from = $args['from_date'];
            $to = $args['to_date']; 
            $condition .= " AND st_scr.added_date BETWEEN '$from' AND '$to'";
        }

        $sql = "SELECT st_scr.* FROM  $this->stud_screening as st_scr LEFT JOIN $this->tbl_student as std ON (st_scr.student_id = std.stud_id) LEFT JOIN $this->tbl_school as sch ON (sch.school_id = std.schd_school_id )  where st_scr.is_deleted='0' AND sch.school_type='school'  $condition ";

        $result = $this->db->query($sql);


        return $result->num_rows();
        
    }
     function get_sms_recipients(){
        

        $sql = "SELECT sms_rc.* FROM   $this->sms_recipients as sms_rc where sms_rc.is_deleted='0' ";

        $result = $this->db->query($sql);


        return $result->result();
        
    }
    
    function get_sickroom_type($args) {

        if (trim($args['school_id']) != '') {
            $condition = " AND school_id LIKE '" . $args['school_id'] . "%' ";
        }
        if (trim($args['school_name']) != '') {
            $condition = " AND school_name LIKE '" . $args['school_name'] . "%' ";
        }
        if (trim($args['cluster_id']) != '') {
            $condition = " AND cluster_id IN ('" . $args['cluster_id'] . "') ";
        }
        if (trim($args['health_sup']) != '') {
            $condition = " AND school_heathsupervisior = '" . $args['health_sup'] . "' ";
        }
        
         $sql = " SELECT * FROM $this->tbl_school WHERE school_isdeleted='0' AND school_type='sickroom'  $condition";
        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
}