<?php

class Bed_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_hp = $this->db->dbprefix('hospital1');
        $this->tbl_hp_bed = $this->db->dbprefix('hos_bed_avaibility');
        
    }

    function get_total_bed($args = array()){
        
        if ($args['district_id'] != '') {

            $condition = " AND hp.hp_district IN ('" . $args['district_id'] . "')  ";

        }

       // $sql = "SELECT max(version) as version,C19_Total_Beds,C19_Occupied,C19_Vacant,NonC19_Total_Beds,NonC19_Occupied,NonC19_Vacant FROM  $this->tbl_hp_bed group by Hospital_id";
       $sql = "select t1.* from ems_hos_bed_avaibility as t1 right join (SELECT max(version) as version, Hospital_id FROM ems_hos_bed_avaibility group by Hospital_id) AS derived on t1.version = derived.version AND t1.Hospital_id = derived.Hospital_id left join ems_hospital as hp on t1.Hospital_id = hp.hp_id where  1=1 $condition ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        return $result->result();

    }
    function get_total_bed_district($args = array()){
        
        if ($args['district_id'] != '') {

            $condition = " AND hp.hp_district IN ('" . $args['district_id'] . "')  ";

        }
         if ($args['hp_id'] != '') {

            $condition = " AND hp.hp_id = '" . $args['hp_id'] . "'  ";

        }
        
        //$sql = "SELECT max(version) as version,C19_Total_Beds,C19_Occupied,C19_Vacant,NonC19_Total_Beds,NonC19_Occupied,NonC19_Vacant,hp.hp_name,hp.hp_id FROM  $this->tbl_hp_bed as bed LEFT JOIN $this->tbl_hp as hp on (hp.hp_id=bed.Hospital_id)  where 1=1 $condition group by bed.Hospital_id"; 
        $sql = "select t1.*,hp.hp_name,hp.hp_id,hp.hp_district from ems_hos_bed_avaibility as t1 right join (SELECT max(version) as version, Hospital_id FROM ems_hos_bed_avaibility group by Hospital_id) AS derived on t1.version = derived.version AND t1.Hospital_id = derived.Hospital_id left join ems_hospital as hp on t1.Hospital_id = hp.hp_id where 1=1 $condition ";
      
       
        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        return $result->result();
            
    }
    
    function get_total_bed_division($args = array()){
        
        
        if ($args['division_id'] != '') {

            $condition = " AND dik.div_id IN ('" . $args['division_id'] . "')  ";

        }
         if ($args['district_id'] != '') {

             $condition = " AND hp.hp_district IN ('" . $args['district_id'] . "')  ";

         }

       
        
        $sql = "select t1.*,hp.hp_name,hp.hp_id,dik.div_name,dis.dst_code,dis.div_id,dik.div_code,dik.div_id from ems_hos_bed_avaibility as t1 
        right join (SELECT max(version) as version, Hospital_id FROM ems_hos_bed_avaibility group by Hospital_id) AS derived on t1.version = derived.version AND t1.Hospital_id = derived.Hospital_id 
        left join ems_hospital as hp on t1.Hospital_id = hp.hp_id 
        left Join  ems_mas_districts  AS dis on hp.hp_district = dis.dst_code 
        left join ems_mas_division as dik on dis.div_id = dik.div_code  
        where 1=1 $condition ";

     //  var_dump($sql); die();
        
        $result = $this->db->query($sql);
        return $result->result();
            
    }
    function get_total_call_launch($args = array()){
        if('district_id' != ''){
            $condition .= " AND inc_district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition = " AND inc_thirdparty = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] =='total_call'){
            $condition .= " AND incis_deleted IN ('0','2') ";
        }
        if($args['type'] == 'total_dispatch') {
            $condition .= " AND incis_deleted IN ('0')  ";
        }
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_incidence where 1=1 '.$condition.' ');
        if ($result) {
          return $result->result();
        } else {
          return false;
        }
    }
    function get_total_call_month($args = array()){
        if('district_id' != ''){
            $condition .= " AND inc_district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition = " AND inc_thirdparty = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] =='total_call'){
            $condition .= " AND incis_deleted IN ('0','2') ";
        }
        if($args['type'] == 'total_dispatch') {
            $condition .= " AND incis_deleted IN ('0')  ";
        }
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_incidence where (DATE(inc_datetime) BETWEEN DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) '.$condition.' ');
        
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_total_call_week($args = array()){
        if('district_id' != ''){
            $condition .= " AND inc_district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition = " AND inc_thirdparty = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] =='total_call'){
            $condition .= " AND incis_deleted IN ('0','2') ";
        }
        if($args['type'] == 'total_dispatch') {
            $condition .= " AND incis_deleted IN ('0')  ";
        }
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_incidence where yearweek(DATE(inc_datetime), 1) = yearweek(curdate(), 1) '.$condition.' ');
       // echo $this->db->last_query();die;
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_total_call_today($args = array()){

        if('district_id' != ''){
            $condition .= " AND inc_district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND inc_thirdparty = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] =='total_call'){
            $condition .= " AND incis_deleted IN ('0','2') ";
        }
        if($args['type'] == 'total_dispatch') {
            $condition .= " AND incis_deleted IN ('0')  ";
        }
        $currentDateTime = date('Y-m-d');
        $todate = $currentDateTime.' '.'23:59:59';
      
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_incidence  where 1=1 '.$condition.'   AND inc_datetime BETWEEN "'. $currentDateTime .'" AND "'.$todate.'" ');
       
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_travel_today($args = array()){

        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
        /*if($args['type'] =='km_travel'){
            $condition .= " AND incis_deleted IN ('0','2') ";
        }*/
        $currentDateTime = date('Y-m-d');
        $todate = $currentDateTime.' '.'23:59:59';
        $result=$this->db->query('select min(start_odometer*1) as min_odo, max(end_odometer*1) as max_odo from ems_epcr  where 1=1 '.$condition.'   AND inc_datetime BETWEEN "'. $currentDateTime .'" AND "'.$todate.'" ');
        
        if ($result) {
            return $result->result();
        } else {
            return false;
        }

    }
    function get_travel_week($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition = " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
       
        $result=$this->db->query('select min(start_odometer*1) as min_odo, max(end_odometer*1) as max_odo from ems_epcr where yearweek(DATE(inc_datetime), 1) = yearweek(curdate(), 1) '.$condition.' GROUP BY  inc_ref_id ');
        
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_travel_month($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition = " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
       
        $result=$this->db->query('select min(start_odometer*1) as min_odo, max(end_odometer*1) as max_odo from ems_epcr where (DATE(inc_datetime) BETWEEN DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) '.$condition.' GROUP BY  inc_ref_id ');
        
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_travel_launch($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition = " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
        $result=$this->db->query('select min(start_odometer*1) as min_odo, max(end_odometer*1) as max_odo from ems_epcr where 1=1 '.$condition.' GROUP BY  inc_ref_id ');
         if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_amb_today($args = array()){
       // var_dump($args);die();
       if('district_id' != ''){
        $condition .= " AND amb_district = '" . $args['district_id'] . "'  ";
    }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND thirdparty = '" . $args['thirdparty'] . "'  ";
        }
        $condition .= " AND amb_status = '1'  ";
        $result=$this->db->query('select count(amb_status) as amb_status from ems_ambulance where 1=1 '.$condition.'  ');
       
       
         if ($result) {
          return $result->result();
      } else {
          return false;
      }

    }
    function get_c19_today($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        // var_dump($args);die();
        if ($args['thirdparty'] != '') {
            //$condition .= " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] == 'c19') {
            $condition .= " AND provider_impressions IN ('52','53')  ";
        }
        $currentDateTime = date('Y-m-d');
        $todate = $currentDateTime.' '.'23:59:59';
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_epcr  where 1=1 '.$condition.'   AND inc_datetime BETWEEN "'. $currentDateTime .'" AND "'.$todate.'" ');
        //echo $this->db->last_query();die;
       
        if ($result) {
          return $result->result();
      } else {
          return false;
      }

    }
    function get_c19_week($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] == 'c19') {
            $condition .= " AND provider_impressions IN ('52','53')  ";
        }
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_epcr where yearweek(DATE(inc_datetime), 1) = yearweek(curdate(), 1) '.$condition.' ');
        //echo $this->db->last_query();die;
       
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_c19_month($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] == 'c19') {
            $condition .= " AND provider_impressions IN ('52','53')  ";
        }
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_epcr where (DATE(inc_datetime) BETWEEN DATE_FORMAT(NOW(),"%Y-%m-01") and NOW()) '.$condition.' ');
        //echo $this->db->last_query();die;
       
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_c19_launch($args = array()){
        if('district_id' != ''){
            $condition .= " AND district_id = '" . $args['district_id'] . "'  ";
        }
        if ($args['thirdparty'] != '') {
            //$condition .= " AND third_party = '" . $args['thirdparty'] . "'  ";
        }
        if($args['type'] == 'c19') {
            $condition .= " AND provider_impressions IN ('52','53')  ";
        }
        
        $result=$this->db->query('select count(inc_ref_id) as inc_ref_id from ems_epcr  where 1=1 '.$condition.' ');
        //echo $this->db->last_query();die;
       
        if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
    function get_amb_status(){
        if (isset($args['amb_rto_register_no'])  != '') {

            $condition .= " AND t2.vehicle_no IN ('" . $args['amb_rto_register_no'] . "') ";
        }
        $sql = "SELECT t2.* FROM  ems_app_login_session as t2 WHERE  1=1 $condition ORDER BY t2.id DESC limit 1";
        
        //echo $sql;
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query(); 
        //die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_inc_ref_id_data($args = array()){
        // $incident_id = $args['inc_ref_id'];
         if ($args['inc_ref_id'] != '') {
 
             $condition .= " AND amb_tm.inc_ref_id = '" . $args['inc_ref_id'] . "' ";
         }
         $sql = "SELECT amb_tm.inc_ref_id as inc_id,amb_tm.amb_rto_register_no as amb_rto_register_no,amb_tm.assigned_time,t2.* FROM  ems_incidence_ambulance as amb_tm 
                 LEFT JOIN ems_driver_parameters as t2 ON t2.incident_id = amb_tm.inc_ref_id
                 WHERE  1=1 $condition ";
         $result = $this->db->query($sql);
         //echo $this->db->last_query(); 
         //die;
         if ($args['get_count']) {
             return $result->result();
         }else{
             return $result->result();
         }
     }
     function bed_update($args){
  
        $this->db->where('Hospital_id', $args['Hospital_id']);
        $update = $this->db->update($this->tbl_hp_bed, $args);
      //  echo $this->db->last_query(); die();
    }
}