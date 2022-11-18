<?php

class Corona_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_corona_list = $this->db->dbprefix('corona_list');
        $this->tbl_corona_followup = $this->db->dbprefix('corona_followup');
        $this->tbl_corona_followup_details= $this->db->dbprefix('corona_followup_details');
        $this->tbl_avaya_corona_outgoing_call= $this->db->dbprefix('avaya_corona_outgoing_call');
        $this->tbl_updated_corona_list = $this->db->dbprefix('updated_corona_list');
        $this->tbl_updated_corona_followup = $this->db->dbprefix('updated_corona_followup');
        $this->tbl_updated_corona_followup_details= $this->db->dbprefix('updated_corona_followup_details');
        $this->tbl_avaya_corona_outgoing_call= $this->db->dbprefix('avaya_corona_outgoing_call');
        $this->tbl_corona_doctor= $this->db->dbprefix('corona_doctor');
        $this->tbl_corona_standard_remark= $this->db->dbprefix('corona_standard_remark');

        
    }
    function get_corona_list($args=array(), $offset = '', $limit = ''){

        if ($offset >= 0 && $limit > 0) {

                $offlim .= "limit $limit offset $offset ";
        }
         
        if (trim($args['corona_id']) != '') {
            $condition .= " AND corona_id = '" . $args['corona_id'] . "' ";
        }
        
        if (trim($args['added_by']) != '') {
            $condition .= " AND added_by = '" . $args['added_by'] . "' ";
        }
       /* if (trim($args['extension_no']) != '') {
            $condition .= " AND avaya_extension = '" . $args['extension_no'] . "' ";
        }*/


        $sql = "SELECT * "
                . "FROM  $this->tbl_corona_list Where is_deleted = '0' AND is_case_close = '0' $condition order by corona_id ASC $offlim";
       
        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
       function get_updated_corona_list($args=array(), $offset = '', $limit = ''){

        if ($offset >= 0 && $limit > 0) {

                $offlim .= "limit $limit offset $offset ";
        }
         
        if (trim($args['corona_id']) != '') {
            $condition .= " AND corona_id = '" . $args['corona_id'] . "' ";
        }
        if (trim($args['added_by']) != '') {
            $condition .= " AND added_by = '" . $args['added_by'] . "' ";
        }
        if (trim($args['extension_no']) != '') {
            $condition .= " AND avaya_extension = '" . $args['extension_no'] . "' ";
        }

          $sql = "SELECT * "
                . "FROM  $this->tbl_updated_corona_list Where is_deleted = '0' AND is_case_close = '0' $condition order by corona_id ASC $offlim";

     
        $result = $this->db->query($sql);

           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    

    function get_updated_max_corona_id($args=array(), $offset = '', $limit = ''){


          $sql = "SELECT max(corona_id) as corona_id  "
                . "FROM  $this->tbl_updated_corona_list ";

     
        $result = $this->db->query($sql);
      //  var_dump($result);die();
         
         return $result->result();
            
    }
        
    function get_max_corona_id($args=array(), $offset = '', $limit = ''){


          $sql = "SELECT max(corona_id) as corona_id  "
                . "FROM  $this->tbl_corona_list ";

     
        $result = $this->db->query($sql);
      //  var_dump($result);die();
         
         return $result->result();
            
    }
    
    function insert_follow_up($args =array()){
        
        $this->db->insert($this->tbl_corona_followup, $args);
        //echo $this->db->last_query();
        //die();
        return $this->db->insert_id();
    }
    function insert_updated_follow_up($args =array()){
        
        $this->db->insert($this->tbl_updated_corona_followup, $args);
        
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
            $condition .= " AND fd.follow_up_id = '" . $args['follow_up_id'] . "' ";
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
        function get_updated_followup_details($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['follow_up_id']) != '') {
            $condition .= " AND fd.follow_up_id = '" . $args['follow_up_id'] . "' ";
        }

         $sql = "SELECT fd.*,cl.address,cf.avaya_unique_id "
                . "FROM  $this->tbl_updated_corona_followup_details as fd 
                    inner join $this->tbl_updated_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_updated_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition order by fd.added_date ";
      

        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    
        function get_updated_followup_by_patient_id($args =array()){
        if (trim($args['follow_up_patient_id']) != '') {
            $condition .= "AND follow_up_patient_id = '" . $args['follow_up_patient_id'] . "' ";
        }

         $sql = "SELECT * "
                . "FROM  $this->tbl_updated_corona_followup as cf left join $this->tbl_updated_corona_followup_details as fd on  (fd.follow_up_id = cf.follow_up_id) Where 1=1 $condition order by cf.added_date ";

      
        $result = $this->db->query($sql);
       
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
        
   function get_corona_calls_details($args =array()){
        //var_dump($args['follow_up_id']);
           if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date = '$from'";
        }

//
//           $sql = "SELECT cl.inc_ref_id,cf_d.*,cl.carona_test_date,cl.patient_gender,cl.patient_gender,cl.is_case_close,cl.mobile_no,cl.district_id,cl.address  FROM  $this->tbl_corona_list as cl
//                    left join $this->tbl_corona_followup as cf on (cl.corona_id = cf.follow_up_patient_id)
//                    left join $this->tbl_corona_followup_details as cf_d on (cl.corona_id = cf.follow_up_patient_id)
//                    Where 1=1 $condition GROUP by cf.follow_up_patient_id order by cl.added_date DESC";
//    

       $sql = "SELECT cl.corona_id as corona_id_cl,fd.*,cl.address,cf.avaya_unique_id,cl.inc_ref_id,cl.carona_test_date,cl.patient_gender,cl.patient_gender,cl.is_case_close,cl.mobile_no,cl.district_id,cl.address "
                . "FROM  $this->tbl_corona_followup_details as fd 
                    inner join $this->tbl_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition  GROUP by fd.corona_id order by fd.id DESC ";
   // die();
   

        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
           function get_corona_updated_calls_details($args =array()){
        //var_dump($args['follow_up_id']);
           if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            //$condition .= " AND fd.follow_up_date = '$from'";
            $condition .= " AND fd.follow_up_date BETWEEN  '$from 00:00:00' AND '$from 23:59:59'";
        }


       $sql = "SELECT cl.corona_id as corona_id_cl,fd.*,cl.address,cf.avaya_unique_id,cl.inc_ref_id,cl.carona_test_date,cl.patient_gender,cl.patient_gender,cl.is_case_close,cl.mobile_no,cl.district_id,cl.address,cl.avaya_extension,cf.follow_up_date as follow_up_date_time,cl.is_phone_connected as phone_connected "
                . "FROM  $this->tbl_updated_corona_followup_details as fd 
                    inner join $this->tbl_updated_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_updated_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition  GROUP by fd.corona_id order by fd.id DESC ";
       
      
    
       

        $result = $this->db->query($sql);
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function corona_out_calls($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date = '$from'";
        }
        if (trim($args['corona_id']) != '') {
            $follow_up_id = $args['corona_id'];
            $condition .= " AND fd.corona_id  = '$follow_up_id'";
        }

          $sql = "SELECT fd.* "
               . "FROM  $this->tbl_corona_followup_details as fd
                    Where 1=1 $condition order by fd.added_date "; 
         
        
        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
        function get_corona_upated_group_test_date($args =array()){
         if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
           // $condition .= " AND fd.follow_up_date = '$from'";
             $condition .= " AND fd.follow_up_date BETWEEN  '$from 00:00:00' AND '$from 23:59:59'";
        }
        if (trim($args['corona_id']) != '') {
            $follow_up_id = $args['corona_id'];
            $condition .= " AND fd.corona_id  = '$follow_up_id'";
        }

//          $sql = "SELECT fd.* "
//               . "FROM  $this->tbl_updated_corona_followup_details as fd
//                    Where 1=1 $condition order by fd.added_date "; 
          
          
         $sql = "SELECT cl.carona_test_date "
                . "FROM  $this->tbl_updated_corona_followup_details as fd 
                    inner join $this->tbl_updated_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_updated_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1  $condition GROUP BY DATE(carona_test_date)  order by fd.id DESC ";
        
   
         
         
        
        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function corona_updated_out_calls($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date BETWEEN  '$from 00:00:00' AND '$from 23:59:59'";
        }
        if (trim($args['test_date']) != '') {
            $test_date = $args['test_date'];
            $condition .= " AND cl.carona_test_date BETWEEN '$test_date 00:00:00' AND '$test_date 23:59:59'";
        }
        if (trim($args['corona_id']) != '') {
            $follow_up_id = $args['corona_id'];
            $condition .= " AND fd.corona_id  = '$follow_up_id'";
        }

//          $sql = "SELECT fd.* "
//               . "FROM  $this->tbl_updated_corona_followup_details as fd
//                    Where 1=1 $condition order by fd.added_date "; 
//          
          
         $sql = "SELECT cl.corona_id as corona_id_cl,fd.*,cl.address,cf.avaya_unique_id,cl.inc_ref_id,cl.carona_test_date,cl.patient_gender,cl.patient_gender,cl.is_case_close,cl.mobile_no,cl.district_id,cl.address,cl.avaya_extension,cf.follow_up_date as follow_up_date_time "
                . "FROM  $this->tbl_updated_corona_followup_details as fd 
                    inner join $this->tbl_updated_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_updated_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition  order by fd.id DESC ";

       
         
        
        $result = $this->db->query($sql);
      //  var_dump($result);die();
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function corona_connected_calls($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date = '$from'";
        }
        
        if (trim($args['is_phone_connected']) != '') {
            $is_phone_connected = $args['is_phone_connected'];
            $condition .= " AND fd.is_phone_connected = '$is_phone_connected'";
        }

         $sql = "SELECT fd.* "
                . "FROM  $this->tbl_corona_followup_details as fd
                    Where 1=1 $condition order by fd.added_date ";

        $result = $this->db->query($sql);
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function corona_updated_connected_calls($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date BETWEEN  '$from 00:00:00' AND '$from 23:59:59'";
        }
        if (trim($args['test_date']) != '') {
            $test_date = $args['test_date'];
            $condition .= " AND cl.carona_test_date BETWEEN '$test_date 00:00:00' AND '$test_date 23:59:59'";
        }
        
        if (trim($args['is_phone_connected']) != '') {
            $is_phone_connected = $args['is_phone_connected'];
            $condition .= " AND fd.is_phone_connected IN ('$is_phone_connected')";
        }
      
//
//         $sql = "SELECT fd.* "
//                . "FROM  $this->tbl_updated_corona_followup_details as fd
//                    Where 1=1 $condition order by fd.added_date ";
                
        $sql = "SELECT cl.corona_id as corona_id_cl,fd.*,cl.address,cf.avaya_unique_id,cl.inc_ref_id,cl.carona_test_date,cl.patient_gender,cl.patient_gender,cl.is_case_close,cl.mobile_no,cl.district_id,cl.address,cl.avaya_extension,cf.follow_up_date as follow_up_date_time "
                . "FROM  $this->tbl_updated_corona_followup_details as fd 
                    inner join $this->tbl_updated_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_updated_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition  order by fd.id DESC ";

        $result = $this->db->query($sql);
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
     function corona_updated_symptomatic_calls($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date BETWEEN  '$from 00:00:00' AND '$from 23:59:59'";
        }
        if (trim($args['test_date']) != '') {
            $test_date = $args['test_date'];
            $condition .= " AND cl.carona_test_date BETWEEN '$test_date 00:00:00' AND '$test_date 23:59:59'";
        }
        if (trim($args['is_phone_connected']) != '') {
            $is_phone_connected = $args['is_phone_connected'];
            $condition .= " AND fd.is_phone_connected = '$is_phone_connected'";
        }
        if(trim($args['symptomatic']) == 'symptomatic'){
             $condition .= " AND ( body_pain = 'yes' OR fever = 'yes' OR cough='yes' OR diarrhoea = 'yes' OR Fatigue_weakness = 'yes' OR abdominal_pain = 'yes' OR breathlessness ='yes' OR nausea='yes' OR vomiting='yes' OR chest_pain = 'yes' OR sputum='yes' OR nasal_discharge='yes' )";
        }
         if(trim($args['symptomatic']) == 'asymptomatic'){
             $condition .= " AND ( body_pain = 'no' AND fever = 'no' AND cough='no' AND diarrhoea = 'no' AND Fatigue_weakness = 'no' AND abdominal_pain = 'no' AND breathlessness ='no' AND nausea='no' AND vomiting='no' AND chest_pain = 'no' AND sputum='no' AND nasal_discharge='no' )";
        }
    

//         $sql = "SELECT fd.* "
//                . "FROM  $this->tbl_updated_corona_followup_details as fd
//                    Where 1=1 $condition order by fd.added_date ";
      
                
        $sql = "SELECT cl.corona_id as corona_id_cl,fd.*,cl.address,cf.avaya_unique_id,cl.inc_ref_id,cl.carona_test_date,cl.patient_gender,cl.patient_gender,cl.is_case_close,cl.mobile_no,cl.district_id,cl.address,cl.avaya_extension,cf.follow_up_date as follow_up_date_time "
                . "FROM  $this->tbl_updated_corona_followup_details as fd 
                    inner join $this->tbl_updated_corona_followup as cf on (fd.follow_up_id = cf.follow_up_id)
                    inner join $this->tbl_updated_corona_list as cl on (cl.corona_id = cf.follow_up_patient_id)
                    Where 1=1 $condition  order by fd.id DESC ";
       
        

        $result = $this->db->query($sql);
           if($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
    }
    function corona_symptomatic_calls($args =array()){
        //var_dump($args['follow_up_id']);
        if (trim($args['from_date']) != '') {
            $from = $args['from_date'];
            $condition .= " AND fd.follow_up_date = '$from'";
        }
        
        if (trim($args['is_phone_connected']) != '') {
            $is_phone_connected = $args['is_phone_connected'];
            $condition .= " AND fd.is_phone_connected = '$is_phone_connected'";
        }
        if(trim($args['symptomatic']) == 'symptomatic'){
             $condition .= " AND ( fever = 'yes' OR cough='yes' OR diarrhoea = 'yes' OR abdominal_pain = 'yes' OR breathlessness ='yes' OR nausea='yes' OR vomiting='yes' OR chest_pain = 'yes' OR sputum='yes' OR nasal_discharge='yes' )";
        }
         if(trim($args['symptomatic']) == 'asymptomatic'){
             $condition .= " AND ( fever = 'no' AND cough='no' AND diarrhoea = 'no' AND abdominal_pain = 'no' AND breathlessness ='no' AND nausea='no' AND vomiting='no' AND chest_pain = 'no' AND sputum='no' AND nasal_discharge='no' )";
        }
        

         $sql = "SELECT fd.* "
                . "FROM  $this->tbl_corona_followup_details as fd
                    Where 1=1 $condition order by fd.added_date ";
        

        $result = $this->db->query($sql);
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
    function insert_updated_corona_followup_details($args =array()){
        
        $this->db->insert($this->tbl_updated_corona_followup_details, $args);
     
        return $this->db->insert_id();
    }
    function insert_corona_call($args =array()){
    //var_dump($args);die();
        $this->db->insert($this->tbl_corona_list, $args);
        //echo $this->db->last_query();
        //var_dump($this->db->insert_id());
        //die();
        return $this->db->insert_id();
    }
         function insert_updated_corona_call($args =array()){
        $this->db->insert($this->tbl_updated_corona_list, $args);
        
        return $this->db->insert_id();
    }
        function update_corona_call($args = array()) {

        if($args['corona_id'] != ""){
            $this->db->where('corona_id', $args['corona_id']);
        }
        //unset($args['CallUniqueID']);
        //unset($args['agent_no']);

        $data = $this->db->update("$this->tbl_corona_list", $args);
        //echo $this->db->last_query();
        //die();

        //$result = $this->db->query($sql);
        

        return $data;
    }
        function update_new_corona_call($args = array()) {

        if($args['corona_id'] != ""){
            $this->db->where('corona_id', $args['corona_id']);
        }
        $data = $this->db->update("$this->tbl_updated_corona_list", $args);

        return $data;
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
     function corona_doctor($args = array()){

        
        if (trim($args['doctor_full_name']) != '') {
            $inc_datetime = $args['doctor_full_name'];
            $condition .= "AND doctor_full_name LIKE '%$inc_datetime%'";
        }

          $sql = "SELECT *"
            . " FROM $this->tbl_corona_doctor"
            . " WHERE is_deleted='0' $condition ORDER BY id desc"; 
       

        $result = $this->db->query($sql);
  
        if ($result) {
            return $result->result();
        } else {
            return false;
        }

    }
    
    function corona_standard_remark($args = array()){

        
        if (trim($args['remark']) != '') {
            $remark = $args['remark'];
            $condition .= "AND standard_remark LIKE '%$remark%'";
        }
          if (trim($args['id']) != '') {
            $remark = $args['id'];
            $condition .= " AND id = '$remark'";
        }

          $sql = "SELECT *"
            . " FROM $this->tbl_corona_standard_remark"
            . " WHERE is_deleted='0' $condition ORDER BY id desc"; 
       

        $result = $this->db->query($sql);
  
        if ($result) {
            return $result->result();
        } else {
            return false;
        }

    }
      
}
