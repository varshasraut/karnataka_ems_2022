<?php

class Corona_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_corona_list = $this->db->dbprefix('corona_list');
        $this->tbl_corona_followup = $this->db->dbprefix('corona_followup');
        $this->tbl_corona_followup_details= $this->db->dbprefix('corona_followup_details');
        $this->tbl_avaya_corona_outgoing_call= $this->db->dbprefix('avaya_corona_outgoing_call');

        
    }
    function get_corona_list($args=array(), $offset = '', $limit = ''){

        if ($offset >= 0 && $limit > 0) {

                $offlim .= "limit $limit offset $offset ";
        }
         
        if (trim($args['corona_id']) != '') {
            $condition .= "AND corona_id = '" . $args['corona_id'] . "' ";
        }

         $sql = "SELECT * "
                . "FROM  $this->tbl_corona_list Where 1=1 $condition order by added_date $offlim";

        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function insert_follow_up($args =array()){
        
        $this->db->insert($this->tbl_corona_followup, $args);
        //echo $this->db->last_query();
        //die();
        return $this->db->insert_id();
    }
    function get_followup_by_patient_id($args =array()){
        if (trim($args['follow_up_patient_id']) != '') {
            $condition .= "AND follow_up_patient_id = '" . $args['follow_up_patient_id'] . "' ";
        }

         $sql = "SELECT * "
                . "FROM  $this->tbl_corona_followup Where 1=1 $condition order by added_date ";

        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function get_followup_details($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['follow_up_id']) != '') {
            $condition .= "AND fd.follow_up_id = '" . $args['follow_up_id'] . "' ";
        }

//         $sql = "SELECT * "
//                . "FROM  $this->tbl_corona_followup_details Where 1=1 $condition order by added_date ";
         
         

          $sql = "SELECT fd.*,cl.address,cf.avaya_unique_id "
                . "FROM  $this->tbl_corona_followup_details as fd 
                    inner join $this->tbl_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition order by fd.added_date ";
     
   

        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function insert_corona_followup_details($args =array()){
        
        $this->db->insert($this->tbl_corona_followup_details, $args);
        //echo $this->db->last_query();
       // die();
        return $this->db->insert_id();
    }
    function insert_corona_call($args =array()){
        $this->db->insert($this->tbl_corona_list, $args);
        //echo $this->db->last_query();
       // die();
        return $this->db->insert_id();
    }
     function insert_softdial_details($args = array()) {

        $result = $this->db->insert($this->tbl_avaya_corona_outgoing_call, $args);
            //echo $this->db->last_query();
        //die();

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    }
    function update_avaya_call_by_calluniqueid($args = array()) {

        if($args['CallUniqueID'] != ""){
            $this->db->where('CallUniqueID', $args['CallUniqueID']);
        }
        if($args['agent_no'] != ""){
            $this->db->where('agent_no', $args['agent_no']);
        }

        $data = $this->db->update("$this->tbl_avaya_corona_outgoing_call", $args);
        //echo $this->db->last_query();
        //die();

        //$result = $this->db->query($sql);
        

        return $data;
    }
       function get_avaya_audio($args = array()) {

        if (trim($args['CallUniqueID']) != '') {
            $condition .= "AND CallUniqueID = '" . $args['CallUniqueID'] . "' ";
        }
        
        if (trim($args['inc_datetime']) != '') {
            $inc_datetime = $args['inc_datetime'];
            $condition .= "AND call_datetime BETWEEN '$inc_datetime 00:00:00' AND '$inc_datetime 23:59:59'";
        }

         $sql = "SELECT *"
            . " FROM $this->tbl_avaya_corona_outgoing_call"
            . " WHERE 1=1 $condition ORDER BY call_datetime DESC limit 0, 1"; 
        

        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }
}
