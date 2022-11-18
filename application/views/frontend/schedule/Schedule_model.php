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
      
    }
    function get_schedule_data($args = array(), $offset = '', $limit = '') {



        $condition = $offlim = '';



        if (isset($args['schedule_id'])) {

            $condition .= "AND sch.schedule_id='" . $args['schedule_id'] . "'";
        }



        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }


        $sql = "SELECT sch.*, school_name, school_headmastername, school_id, school_mobile, cluster_name FROM  $this->tbl_schedule as sch INNER JOIN  $this->tbl_school AS sc ON sch.schedule_schoolid = sc.school_id INNER JOIN  $this->tbl_cluster AS cl ON sch.schedule_clusterid = cl.cluster_id where sch.schedule_isdeleted='0' $condition  $offlim ";

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

    function insert_schedule($args=array()){
        
        $result = $this->db->insert($this->tbl_schedule, $args);  
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    
    } 
    function update_schedule($args=array()){
        
        if($args['schedule_id']){            
           $this->db->where('schedule_id',$args['schedule_id']);
           $update = $this->db->update($this->tbl_schedule,$args);
           if($update){   return true;    }else{  return false; }
       
        }else{
           return false;
        }
    
    } 
    function approve_schedule($schedule_id = array(), $status = '') {


        if($args['schedule_id']){            
           $this->db->where('schedule_id',$args['schedule_id']);
           $update = $this->db->update($this->tbl_schedule,$args);
           if($update){   return true;    }else{  return false; }
       
        }else{
           return false;
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
								where sch.schedule_isdeleted='0' $condition  $offlim ";
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



    function get_cluster() {

        $sql = " SELECT * FROM $this->tbl_cluster WHERE isdeleted='0' ";
        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }
}
