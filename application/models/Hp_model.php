<?php

class Hp_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_base_location = $this->db->dbprefix('base_location');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        
        
        $this->tbl_hp1 = $this->db->dbprefix('hospital1');
        $this->tbl_amb = $this->db->dbprefix('ambulance');
        $this->tbl_mas_hospital_type = $this->db->dbprefix('mas_hospital_type');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');

        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');

        $this->tbl_mas_city = $this->db->dbprefix('mas_city');
        $this->tbl_hos_bed_avaibility = $this->db->dbprefix('hos_bed_avaibility');
        $this->tbl_mas_ward = $this->db->dbprefix('mas_ward');
    }
     function insert_hos_bed_details($args = array())
    {
        $this->db->select('*');
        $this->db->from("$this->tbl_hos_bed_avaibility");
        $this->db->where("$this->tbl_hos_bed_avaibility.Hospital_id", $args['Hospital_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();
       
        if (count($present) == 0)
        {
            $arr = array(
               'temp_id'=>'1',
            );
          
            $this->db->where_in('hp_id', $args['Hospital_id']);
            $data = $this->db->update("$this->tbl_hp", $arr);
            
           
            $result = $this->db->insert($this->tbl_hos_bed_avaibility, $args);
            $result = $this->db->query($result);
            if ($result) {
    
                    return $this->db->insert_id();
            } else {
    
                    return false;
            }
        }
        else{
            $args['modify_datetime']=$todaydate;
            $this->db->where_in('Hospital_id', $args['Hospital_id']);
            $data = $this->db->update("$this->tbl_hos_bed_avaibility", $args);
            return $data;
        }
    }
    function update_hospital_API($args = array()){
        $this->db->select('*');
        $this->db->from("$this->tbl_hp");
        $this->db->where("$this->tbl_hp.hp_name", $args['hp_name']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        //var_dump($present[0]->hp_id);die();
        $todaydate=$this->today = date('Y-m-d H:i:s');
        if (count($present) == 0)
        {
            $args['modify_date_sync']= $todaydate;
            $result = $this->db->insert($this->tbl_hp, $args);
            $result = $this->db->query($result);
            if ($result) {
    
                    return true;
            } else {
    
                    return false;
            }

        }else{
            $args['modify_date_sync']=$todaydate;
            $this->db->where_in('hp_name', $args['hp_name']);
            $data = $this->db->update("$this->tbl_hp", $args);
           // return $data;

            //$args['modify_datetime']=$todaydate;
            $args_bed = array('Hospital_id'=>$present[0]->hp_id,'API_hospital_id'=>$args['API_hospital_id']);
            $this->db->where_in('API_hospital_id', $args['API_hospital_id']);
            $data = $this->db->update("$this->tbl_hos_bed_avaibility", $args_bed);
            //return $data;
        }
    }
    function update_hospital_data($args = array(),$hp_args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_hos_bed_avaibility");
        $this->db->where("$this->tbl_hos_bed_avaibility.API_hospital_id", $args['API_hospital_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        $todaydate=$this->today = date('Y-m-d H:i:s');
        if (count($present) == 0)
        {
           
            $result = $this->db->insert($this->tbl_hp, $hp_args);
            $result = $this->db->query($result);
           // $result = $this->db->last_inserted_id($result);
           $hp_id =  $this->db->insert_id();
            $args['Hospital_id']=$hp_id;
            $args['added_datetime']= $todaydate;
            $result = $this->db->insert($this->tbl_hos_bed_avaibility, $args);
            $result = $this->db->query($result);
            if ($result) {
    
                    return true;
            } else {
    
                    return false;
            }
        }
        else{
            $args['modify_datetime']=$todaydate;
            $this->db->where_in('API_hospital_id', $args['API_hospital_id']);
            $data = $this->db->update("$this->tbl_hos_bed_avaibility", $args);
            return $data;
        }
        
    }
    function get_hos_details($args)
    {
        //var_dump($args);die();
        if($args != ''){
            $condition .= " AND Hospital_id='" . $args . "'";
        }

        // $sql = "SELECT * FROM $this->tbl_hos_bed_avaibility WHERE status='1' $condition order by `added_datetime` DESC limit 1  ";

        $sql ="select t1.* from ems_hos_bed_avaibility as t1 right join (SELECT max(version) as version, Hospital_id FROM ems_hos_bed_avaibility where status='1' $condition) AS derived on t1.version = derived.version AND t1.Hospital_id = derived.Hospital_id";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_bed_count_details($args = array()){
        $bed_type = $args['bed_type'];
        $sql = "SELECT bed_type,count(*) as bed_count FROM ems_incidence WHERE incis_deleted='0' AND bed_type=$bed_type AND admitted_status = 'book' group by bed_type";

        $result = $this->db->query($sql);
       
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_hospital_details_ERO($args)
    {
        //var_dump($args);die();
        if($args != ''){
            if($args != ''){
                $condition .= " AND hp_id='" . $args . "'";
            }

             $sql = "SELECT * FROM $this->tbl_hp WHERE hp_status='1' $condition";
             //echo $sql;die();

            $result = $this->db->query($sql);

            if ($result) {
                return $result->result();
            } else {
                return false;
            }
        }
    }
    function get_hospital_details_ERO_new($args)
    {
        //var_dump($args);die();
        if($args != ''){
            if($args != ''){
                $condition .= " AND hp_id='" . $args . "'";
            }

             $sql = "SELECT hp_type FROM $this->tbl_hp WHERE hp_status='1' $condition";
             //echo $sql;die();

            $result = $this->db->query($sql);

            if ($result) {
                return $result->result();
            } else {
                return false;
            }
        }
    }
    function insert_wrd($args = array()) {

        $result = $this->db->insert($this->tbl_mas_ward, $args);
        //echo $this->db->last_query(); die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_hp($args = array()) {

        $result = $this->db->insert($this->tbl_base_location, $args);
        //echo $this->db->last_query(); die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    function insert_hp1($args = array()) {

        $result = $this->db->insert($this->tbl_hp, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function get_hp1_data($args) {
        
        //var_dump($args);die();
        $condition .= "AND hp_id='" . $args . "'";
        //var_dump($condition);die();
        $sql = "SELECT * FROM $this->tbl_hp where hpis_deleted='0' $condition";
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
     function get_ward_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['ward_id'])) {
            $condition .= "AND ward_id='" . $args['ward_id'] . "'";
        }
        if (isset($args['district_id'])  != '') {

            $condition .= " AND wrd_district='" . $args['district_id'] . "'";
        }
       /* if (isset($args['thirdparty'])  != '') {

            $condition .= " AND amb.thirdparty IN ('" . $args['thirdparty'] . "') ";
        }
*/
        if (trim($args['hp_name']) != '') {

            $condition .= "AND ward_name like '%" . $args['hp_name'] . "%' OR mob_no LIKE '%" . $args['hp_name'] . "%' ";
        }
        //        if(isset($args['mob_no']) && $args['mob_no']!=''){   $condition .= "AND hp_mobile='".$args['mob_no']."'" ;} 

       /* if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }*/

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_mas_ward where status='1' $condition order by ward_id ASC $offlim ";
       

        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_hp_data($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';
       // var_dump($args);die;
        if (isset($args['hp_id'])) {
            $condition .= "AND hp_id='" . $args['hp_id'] . "'";
        }
        
        if (isset($args['amb_district'])) {
            $condition .= "AND hp_district IN ('" . $args['amb_district'] . "') ";
        }

        if (trim($args['hp_name']) != '') {

            $condition .= "AND hp_name like '%" . $args['hp_name'] . "%' ";
        }
        




//        if(isset($args['mob_no']) && $args['mob_no']!=''){   $condition .= "AND hp_mobile='".$args['mob_no']."'" ;} 

        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_base_location where hpis_deleted='0' $condition order by hp_id DESC $offlim ";
       

        $result = $this->db->query($sql);

        //echo $this->db->last_query(); die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_hp_data_with_amb($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp_id='" . $args['hp_id'] . "'";
        }

        if (trim($args['hp_name']) != '') {
            $condition .= "AND hp_name like '%" . $args['hp_name'] . "%' ";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {
            $condition .= "AND hp_mobile='" . $args['mob_no'] . "'";
        }
        if (isset($args['dist']) && $args['dist'] != '' && $args['dist'] != 0) {
            $condition .= "AND hp_district='" . $args['dist'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT amb.amb_rto_register_no,hp.* FROM $this->tbl_base_location as hp"
            . " LEFT JOIN $this->tbl_amb as amb ON (hp.hp_id = amb.amb_base_location) where hpis_deleted='0'  $condition  $offlim ";

        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_amb_base_location($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp_id='" . $args['hp_id'] . "'";
        }

        if (trim($args['hp_name']) != '') {
            $condition .= "AND hp_name like '%" . $args['hp_name'] . "%' ";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {
            $condition .= "AND hp_mobile='" . $args['mob_no'] . "'";
        }
        if (isset($args['dist']) && $args['dist'] != '' && $args['dist'] != 0) {
            $condition .= "AND hp_district='" . $args['dist'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT hp.* FROM $this->tbl_base_location as hp"
            . " LEFT JOIN $this->tbl_amb as amb ON (hp.hp_id = amb.amb_base_location) where hpis_deleted='0'  $condition  $offlim ";

        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_wrd_to_city($args = array()){
        //  var_dump('hii');die();
          $condition = '';
  
          if (isset($args['ward_id'])) {
              $condition .= "AND ward_id='" . $args['ward_id'] . "'";
          }
  
          $sql = "SELECT city.cty_id,city.cty_name,wrd.ward_id,wrd.ward_name"
              . " FROM $this->tbl_mas_ward as wrd "
              . "LEFT JOIN $this->tbl_mas_city as city  "
              . "ON (city.cty_id = wrd.wrd_city) "
              . "Where isdeleted = '0' $condition";
  
          $result = $this->db->query($sql);
        // echo $this->db->last_query(); die;
          if ($result){
              return $result->result();
          }else{
              return false;
          }
      }
    function get_hp_to_city($args = array()) {

        $condition = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp_id='" . $args['hp_id'] . "'";
        }

        $sql = "SELECT city.cty_id,city.cty_name,hp.hp_id,hp.hp_name"
            . " FROM $this->tbl_base_location as hp "
            . "LEFT JOIN $this->tbl_mas_city as city  "
            . "ON (city.cty_id = hp.hp_city) "
            . "Where hpis_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
     function get_hp_to_city1($args = array()) {

        $condition = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp_id='" . $args['hp_id'] . "'";
        }

        $sql = "SELECT city.cty_id,city.cty_name,hp.hp_id,hp.hp_name"
            . " FROM $this->tbl_hp as hp "
            . "LEFT JOIN $this->tbl_mas_city as city  "
            . "ON (city.cty_id = hp.hp_city) "
            . "Where hpis_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_hp_to_dist($args = array()) {

        $condition = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp_id='" . $args['hp_id'] . "'";
        }

        $sql = "SELECT dst.dst_code,dst.dst_name,hp.hp_id,hp.hp_name"
            . " FROM $this->tbl_base_location as hp "
            . "LEFT JOIN $this->tbl_mas_districts as dst "
            . "ON (dst.dst_code = hp.hp_district) "
            . "Where hpis_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    } 
    function delete_wrd($ward_id = array(), $status = '') {
        $this->db->where_in('ward_id', $ward_id);

        $status = $this->db->update($this->tbl_mas_ward, $status);

        return $status;
    }
    function delete_hp($hp_id = array(), $status = '') {

        $this->db->where_in('hp_id', $hp_id);

        $status = $this->db->update($this->tbl_hp, $status);

        return $status;
    }
    
    function delete_hp1($hp_id = array(), $status = '') {

        $this->db->where_in('hp_id', $hp_id);

        $status = $this->db->update($this->tbl_hp, $status);

        return $status;
    }
    function update_wrd($args = array()){
        //var_dump($args);die();
        if ($args['ward_id']) {
            $this->db->where('ward_id', $args['ward_id']);
            $update = $this->db->update($this->tbl_mas_ward, $args);
            //echo $this->db->last_query(); die;
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function update_hp($args = array()) {

        if ($args['hp_id']) {
            $this->db->where('hp_id', $args['hp_id']);
            $update = $this->db->update($this->tbl_hp, $args);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
        function update_hp1($args = array()) {

        if ($args['hp_id']) {
            $this->db->where('hp_id', $args['hp_id']);
            $update = $this->db->update($this->tbl_hp, $args);
            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function get_hp_data_DCO($args = array(), $offset = '', $limit = '') {
        $condition = $offlim = '';

        
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= "AND hp.hp_name like '%" . $args['hp_name'] . "%'  ";
        }
        if (isset($args['hp_temp_id'])) {
            $condition .= "AND hp.temp_id='" . $args['hp_temp_id'] . "'";
        }
        

        $sql = "SELECT hp.* FROM $this->tbl_hp as hp 
        where hp.hpis_deleted='0' $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query(); die;

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }

    }
   // function get_hos_data($args = array(), $offset = '', $limit = '') (){
        function get_hos_data($args = array(), $offset = '', $limit = '') {
        //var_dump($args['district_id']);die();
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id_new'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_district']) && $args['amb_district'] != '') {
            $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        }
        if (isset($args['hosp_type']) && $args['hosp_type'] != '') {
            $condition .= "AND h_type.hosp_type IN ('" . $args['hosp_type'] . "') ";
        }
        
         if (trim($args['hp_name']) != '') {
            $condition .= "AND hp.hp_name like '%" . $args['hp_name'] . "%'";
           // $condition .= "AND hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile='" . $args['hp_name'] . "' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%' ";
            
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_hp as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where hpis_deleted='0' $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
            //echo $this->db->last_query();die();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_hp_data1($args = array(), $offset = '', $limit = '') {
       //var_dump($args['district_id']);die();
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id_new'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_district']) && $args['amb_district'] != '') {
            $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        }
        if (isset($args['hosp_type']) && $args['hosp_type'] != '') {
            $condition .= "AND h_type.hosp_type IN ('" . $args['hosp_type'] . "') ";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
            
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_hp as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where hpis_deleted='0' $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
            //echo $this->db->last_query();die();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_hp_data1_new($args = array(), $offset = '', $limit = '') {
        //var_dump($args['district_id']);die();
         $condition = $offlim = '';
 
         if (isset($args['hp_id'])) {
             $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
         }
         if (isset($args['district_id_new'])) {
             $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
         }
         if (isset($args['district_id'])) {
             $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
         }
         if (isset($args['amb_district']) && $args['amb_district'] != '') {
             $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
         }
         if (isset($args['hosp_type']) && $args['hosp_type'] != '') {
             $condition .= "AND h_type.hosp_type IN ('" . $args['hosp_type'] . "') ";
         }
         
          if (trim($args['hp_name']) != '') {
 
             $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
             
         }
 
 
         if (isset($args['mob_no']) && $args['mob_no'] != '') {
 
             if ($args['mob_no'] == 'Active') {
                 $status = '1';
             } else if ($args['mob_no'] == 'Inactive') {
                 $status = '0';
             }
             $condition .= "AND (hp_status = '$status')";
         }
 
         if ($offset >= 0 && $limit > 0) {
             $offlim = "limit $limit offset $offset ";
         }
 
         $sql = "SELECT h_type.full_name FROM $this->tbl_hp as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where hpis_deleted='0' $condition order by hp_name ASC  $offlim ";
 
         $result = $this->db->query($sql);
             //echo $this->db->last_query();die();
 
         if ($args['get_count']) {
 
             return $result->num_rows();
         } else {
 
             return $result->result();
         }
     }
        function get_hp_data_pvt($args = array(), $offset = '', $limit = '') {
       //var_dump($args['district_id']);die();
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id_new'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_district']) && $args['amb_district'] != '') {
            $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        }
        if (isset($args['ptn_ayu_id']) && $args['ptn_ayu_id'] != '') {
            $condition .= "AND hp.hp_pvt_ayush IN ('24') ";
        }
        if (isset($args['hosp_type']) && $args['hosp_type'] != '' && $args['ptn_ayu_id'] == '') {
            $condition .= "AND h_type.hosp_type IN ('" . $args['hosp_type'] . "') ";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
            
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_hp as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where hpis_deleted='0' $condition group by hp.hp_name order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
            //echo $this->db->last_query();die();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_amb_data1($args = array(), $offset = '', $limit = '') {
        // print_r($args['district_id']);die();
         $condition = $offlim = '';
 
        //  if (isset($args['hp_id'])) {
        //      $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        //  }
        //  if (isset($args['district_id_new'])) {
        //      $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        //  }
         if (isset($args['district_id'])) {
             $condition .= "AND hp.amb_district='" . $args['district_id'] . "'";
         }
        //  if (isset($args['amb_district']) && $args['amb_district'] != '') {
        //      $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        //  }
        //  if (isset($args['hosp_type']) && $args['hosp_type'] != '') {
        //      $condition .= "AND h_type.hosp_type IN ('" . $args['hosp_type'] . "') ";
        //  }
         
        //   if (trim($args['hp_name']) != '') {
 
        //      $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
             
        //  }
 
 
        //  if (isset($args['mob_no']) && $args['mob_no'] != '') {
 
        //      if ($args['mob_no'] == 'Active') {
        //          $status = '1';
        //      } else if ($args['mob_no'] == 'Inactive') {
        //          $status = '0';
        //      }
        //      $condition .= "AND (hp_status = '$status')";
        //  }
            $dist = $args['district_id'];
            // print_r($dist);die;
         if ($offset >= 0 && $limit > 0) {
             $offlim = "limit $limit offset $offset ";
         }
 
         $sql = "SELECT * FROM ems_ambulance as hp 
         LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.amb_district) 
         LEFT JOIN ems_mas_districts as h_type ON (h_type.dst_id = hp.amb_district) 
         where hp.ambis_deleted='0'AND hp.amb_district = '".$dist."' $condition order by dst.dst_name ASC  $offlim ";
 
         $result = $this->db->query($sql);
            //  echo $this->db->last_query();die();
 
         if ($args['get_count']) {
 
             return $result->num_rows();
         } else {
 
             return $result->result();
         }
     }
     function get_ambs_data1($args = array(), $offset = '', $limit = '') {
        // print_r($args['district_id']);die();
         $condition = $offlim = '';
 
        //  if (isset($args['hp_id'])) {
        //      $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        //  }
        //  if (isset($args['district_id_new'])) {
        //      $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        //  }
         if (isset($args['district_id'])) {
             $condition .= "AND hp.amb_district='" . $args['district_id'] . "'";
         }
        //  if (isset($args['amb_district']) && $args['amb_district'] != '') {
        //      $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        //  }
        //  if (isset($args['hosp_type']) && $args['hosp_type'] != '') {
        //      $condition .= "AND h_type.hosp_type IN ('" . $args['hosp_type'] . "') ";
        //  }
         
        //   if (trim($args['hp_name']) != '') {
 
        //      $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
             
        //  }
 
 
        //  if (isset($args['mob_no']) && $args['mob_no'] != '') {
 
        //      if ($args['mob_no'] == 'Active') {
        //          $status = '1';
        //      } else if ($args['mob_no'] == 'Inactive') {
        //          $status = '0';
        //      }
        //      $condition .= "AND (hp_status = '$status')";
        //  }
            $dist = $args['district_id'];
            // print_r($dist);die;
         if ($offset >= 0 && $limit > 0) {
             $offlim = "limit $limit offset $offset ";
         }
 
         $sql = "SELECT * FROM ems_ambulance as hp 
         LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.amb_district) 
         LEFT JOIN ems_app_login_session as sessi ON (sessi.vehicle_no = hp.amb_rto_register_no) 
         LEFT JOIN ems_mas_districts as h_type ON (h_type.dst_id = hp.amb_district) 
         where hp.ambis_deleted='0' AND sessi.status = '1' AND hp.amb_district = '".$dist."' $condition order by dst.dst_name ASC  $offlim ";
 
         $result = $this->db->query($sql);
            //  echo $this->db->last_query();die();
 
         if ($args['get_count']) {
 
             return $result->num_rows();
         } else {
 
             return $result->result();
         }
     }
    
    function get_hp_data_hospital($args = array(), $offset = '', $limit = '') {
       //var_dump($args['district_id']);die();
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id_new'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_district']) && $args['amb_district'] != '') {
            $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
            
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_hp as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where 1=1 $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
           // echo $this->db->last_query();die();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
        function get_report_hospital_data($args = array(), $offset = '', $limit = '') {
       //var_dump($args['district_id']);die();
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id_new'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_district']) && $args['amb_district'] != '') {
            $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
            
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_hp as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where 1=1 $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
           // echo $this->db->last_query();die();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
      function get_wrd_to_dist($args = array()){

        $condition = '';

        if (isset($args['ward_id'])) {
            $condition .= "AND ward_id='" . $args['ward_id'] . "'";
        }

       $sql = "SELECT dst.dst_code,dst.dst_name,wrd.*"
            . " FROM $this->tbl_mas_ward as wrd "
            . "LEFT JOIN $this->tbl_mas_districts as dst "
            . "ON (dst.dst_code = wrd.wrd_district)  "
            . "Where isdeleted = '0' $condition";

        $result = $this->db->query($sql);
 //echo $this->db->last_query(); die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    } 
    function get_hpbed_data($args = array(), $offset = '', $limit = '') {
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
         if (isset($args['hp_code'])) {
             
             $hp_code = str_replace(',', "','", $args['hp_code']);
             
            $condition .= " AND hp_typ.hosp_type IN ('" . $hp_code . "')";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= "AND hp.hp_name like '%" . $args['hp_name'] . "%'";
        }
        if (isset($args['hp_temp_id'])) {
            $condition .= "AND hp.temp_id='" . $args['hp_temp_id'] . "'";
        }
        



        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT hp.* FROM $this->tbl_hp as hp 
            LEFT JOIN ems_mas_hospital_type as hp_typ on (hp.hp_type = hp_typ.hosp_id)
         where hpis_deleted='0' $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
       // echo $this->db->last_query(); die;

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }

    }
    function get_hospital_arrived_inc($args){ 
        $sql ="select inc.*,comp.ct_type, pat.ptn_fname, pat.ptn_lname, pat.ptn_gender, pat.ptn_age,  inc_amb.amb_rto_register_no,amb.amb_lat from ems_incidence as inc left join ems_incidence_patient as inc_pat ON inc.inc_ref_id = inc_pat.inc_id left join ems_patient as pat ON inc_pat.ptn_id = pat.p_id left join ems_mas_patient_complaint_types as comp ON inc.inc_complaint = comp.ct_id left join ems_incidence_ambulance as inc_amb ON inc.inc_ref_id = inc_amb.inc_ref_id LEFT JOIN ems_ambulance as amb ON (amb.amb_rto_register_no=inc_amb.amb_rto_register_no )where inc.destination_hospital_id='".$args."' AND inc.incis_deleted='0'  AND admitted_status='Admitted' ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
    function get_epcr_inc_details_handover($args){
        $sql ="select inc.*,epcr.*,chief_com.ct_type,pup_left.pp_type as pp_type_left,pup_right.pp_type as pp_type_right,pat.ptn_fname, pat.ptn_lname, pat.ptn_gender, pat.ptn_age,loc.level_type,pt_status.name,pro.pro_name
        from ems_incidence as inc 
        left join ems_epcr as epcr ON epcr.inc_ref_id = inc.inc_ref_id 
        left join ems_mas_loc_level as loc ON loc.level_id = epcr.hc_loc 
        left join ems_patient as pat ON inc_pat.ptn_id = pat.ptn_id 
        left join ems_mas_patient_complaint_types as chief_com ON chief_com.ct_id = epcr.ong_ph_sign_symptoms 
        left join ems_mas_pupils_type as pup_left ON pup_left.pp_id  = epcr.hc_con_pupils 
        left join ems_mas_pupils_type as pup_right ON pup_right.pp_id  = epcr.hc_con_pupils_right 
        left join ems_patient_status as pt_status ON pt_status.name  = epcr.hc_ps 
        left join ems_mas_provider_imp as pro ON pro.pro_id  = epcr.provider_impressions 
        where epcr.inc_ref_id='".$args['inc_ref_id']."' AND inc.incis_deleted='0' AND inc.inc_pcr_status='1'    ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
    function get_epcr_past_his($args){
        $sql ="select * from ems_past_medical_history 
        where id='".$args['past_his_id']."' ";

        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
    function get_epcr_intervention($args){
        $sql ="select * from ems_interventions 
        where id='".$args['id']."' ";

        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
    function get_epcr_inc_details($args){

        $sql ="select inc.*,epcr.*,chief_com.ct_type,pup_left.pp_type as pp_type_left,pup_right.pp_type as pp_type_right
        from ems_incidence as inc 
        left join ems_epcr as epcr ON epcr.inc_ref_id = inc.inc_ref_id 
        left join ems_mas_patient_complaint_types as chief_com ON chief_com.ct_id = epcr.ong_ph_sign_symptoms 
        left join ems_mas_pupils_type as pup_left ON pup_left.pp_id  = epcr.ini_con_pupils 
        left join ems_mas_pupils_type as pup_right ON pup_right.pp_id  = epcr.ini_con_pupils_right 
        where epcr.inc_ref_id='".$args['inc_ref_id']."' AND inc.incis_deleted='0' AND inc.inc_pcr_status='1'  AND admitted_status IS NULL  ";

        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
    function get_hospital_arriving_inc_serch($args){ 
        //$args['curt_time_one_hr'] =  date('Y-m-d H:i:s', strtotime('-10 minute'));
        $sql ="select inc.*,inc_bed.bed_type as bed_nm,comp.ct_type, pat.ptn_fname, pat.ptn_lname, pat.ptn_gender, pat.ptn_age,  inc_amb.amb_rto_register_no 
        from ems_incidence as inc left join ems_incidence_patient as inc_pat ON inc.inc_ref_id = inc_pat.inc_id 
        left join ems_patient as pat ON inc_pat.ptn_id = pat.ptn_id 
        left join ems_mas_type_of_beds as inc_bed ON inc.bed_type = inc_bed.id 
        left join ems_mas_patient_complaint_types as comp ON inc.inc_complaint = comp.ct_id 
        left join ems_incidence_ambulance as inc_amb ON inc.inc_ref_id = inc_amb.inc_ref_id 
        where  inc.inc_ref_id='".$args."' AND inc.incis_deleted='0'  AND admitted_status IS NULL  ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
    function get_hospital_arriving_inc($args){ 
        //$args['curt_time_one_hr'] =  date('Y-m-d H:i:s', strtotime('-10 minute'));
        $sql ="select inc.*,inc_bed.bed_type as bed_nm,comp.ct_type, pat.ptn_fname, pat.ptn_lname, pat.ptn_gender, pat.ptn_age,  inc_amb.amb_rto_register_no,amb.amb_lat,amb_log
        from ems_incidence as inc left join ems_incidence_patient as inc_pat ON inc.inc_ref_id = inc_pat.inc_id 
        left join ems_patient as pat ON inc_pat.ptn_id = pat.ptn_id 
        left join ems_mas_type_of_beds as inc_bed ON inc.bed_type = inc_bed.id 
        left join ems_mas_patient_complaint_types as comp ON inc.inc_complaint = comp.ct_id 
        left join ems_incidence_ambulance as inc_amb ON inc.inc_ref_id = inc_amb.inc_ref_id 

        left join ems_ambulance as amb ON amb.amb_rto_register_no = inc_amb.amb_rto_register_no 
       
        where  (inc.inc_datetime BETWEEN '". date('Y-m-d H:i:s', strtotime('-4 hour'))."' AND  '".date('Y-m-d H:i:s')."') AND ( inc.destination_hospital_id='".$args."' || inc.destination_hospital_two='".$args."' ) AND inc.incis_deleted='0'  AND admitted_status IS NULL  ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        }else{
            return false;
        }
    }
        function get_baselocation_data($args = array(), $offset = '', $limit = '') {
       //var_dump($args['district_id']);die();
        $condition = $offlim = '';

        if (isset($args['hp_id'])) {
            $condition .= "AND hp.hp_id='" . $args['hp_id'] . "'";
        }
        if (isset($args['district_id_new'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id_new'] . "'";
        }
        if (isset($args['district_id'])) {
            $condition .= "AND hp.hp_district='" . $args['district_id'] . "'";
        }
        if (isset($args['amb_district']) && $args['amb_district'] != '') {
            $condition .= "AND hp.hp_district IN ('" . $args['amb_district'] . "') ";
        }
        
         if (trim($args['hp_name']) != '') {

            $condition .= " AND (hp.hp_name like '%" . $args['hp_name'] . "%' OR hp.hp_mobile LIKE '%" . $args['hp_name'] . "%' OR dst.dst_name like '%" . $args['hp_name'] . "%' OR h_type.hosp_type like '%" . $args['hp_name'] . "%') ";
            
        }


        if (isset($args['mob_no']) && $args['mob_no'] != '') {

            if ($args['mob_no'] == 'Active') {
                $status = '1';
            } else if ($args['mob_no'] == 'Inactive') {
                $status = '0';
            }
            $condition .= "AND (hp_status = '$status')";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT * FROM $this->tbl_base_location as hp LEFT JOIN $this->tbl_mas_districts as dst ON (dst.dst_code = hp.hp_district) LEFT JOIN $this->tbl_mas_hospital_type as h_type ON (h_type.hosp_id = hp.hp_type) where hpis_deleted='0' $condition order by hp_name ASC  $offlim ";

        $result = $this->db->query($sql);
            //echo $this->db->last_query();die();

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
}

