<?php

class Ambmain_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_amb_main = $this->db->dbprefix('ambulance_preventive_maintaince');
        $this->tbl_amb_brek_main = $this->db->dbprefix('amb_breakdown_maintaince');
        $this->tbl_amb_acc_main = $this->db->dbprefix('amb_accidental_maintaince');
        $this->tbl_amb_on_of = $this->db->dbprefix('amb_onroad_offroad');
        $this->tbl_amb_tyre = $this->db->dbprefix('amb_tyre_maintaince');
        $this->tbl_state = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_base_location = $this->db->dbprefix('base_location');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_work_station = $this->db->dbprefix('work_station');
        $this->tbl_media = $this->db->dbprefix('media');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_clg_logins = $this->db->dbprefix('clg_logins');
        $this->tbl_clg_break_summary = $this->db->dbprefix('clg_break_summary');
        $this->tbl_fleet_fuel_filling = $this->db->dbprefix('fleet_fuel_filling');
        $this->tbl_fuel_station = $this->db->dbprefix('fuel_station');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->ems_amb_accidental_maintaince_history = $this->db->dbprefix('amb_accidental_maintaince_history');
        $this->amb_accidental_maintaince_re_request_history = $this->db->dbprefix('amb_accidental_maintaince_re_request_history');
        $this->tbl_epcr = $this->db->dbprefix('epcr');
        $this->tbl_offroad_reason = $this->db->dbprefix('mas_offroad_reason');
    }
    function get_ambulance($args = array())
    {
        $sql= "Select amb_rto_register_no  FROM $this->tbl_ambulance";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;

         if ($args['get_count']) {
             return $result->num_rows();
         } else {
             return $result->result();
         }
    }
    function get_ambulance1($args)
    {
        if($args['dist']=='')
        {
            $condition= "1";
        }
        else
        {
            $condition="dist.dst_code = '".$args['dist']."'";
        }
        $sql= "Select amb.amb_rto_register_no  FROM $this->tbl_ambulance as amb"
        . " LEFT JOIN  ems_base_location as base ON (base.hp_id=amb.amb_base_location)"
        . " LEFT JOIN  ems_mas_districts as dist ON (base.hp_district=dist.dst_code)"
        . " Where ".$condition;
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;

         if ($args['get_count']) {
             return $result->num_rows();
         } else {
             return $result->result();
         }
    }
    function get_total_call_count($args = array())
    {
        //var_dump($args);die();
        $condition = $offlim = '';
        if ($args['amb_rto_register_no'] != '') {
            $condition1 .= "amb.amb_rto_register_no IN ('" . $args['amb_rto_register_no'] . "') ";
            $sql1= "Select dist.dst_name,base.hp_name,amb.amb_type  FROM $this->tbl_ambulance as amb"
        . " LEFT JOIN  ems_base_location as base ON (base.hp_id=amb.amb_base_location)"
        . " LEFT JOIN  ems_mas_districts as dist ON (base.hp_district=dist.dst_code)"
        . " Where amb.amb_rto_register_no = '" . $args['amb_rto_register_no'] . "'";
        
        $result1 = $this->db->query($sql1);
        // echo $this->db->last_query();die;
        $xyz=$result1->result();
        $dst_name1 = (array)$xyz[0];
        $dst_name = $dst_name1['dst_name'];
        $hp_name = $dst_name1['hp_name'];
        $amb_type = $dst_name1['amb_type'];
        // print_r($dst_name['dst_name']);die();
            // $condition1 .= "amb.amb_rto_register_no IN ('MP-02-AV-6655') ";
        }
       // $ambulance=$args['amb_rto_register_no'];
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc_amb.assigned_time BETWEEN '$from' AND '$to 23:59:59' ";
        }
        if ($args['from_datetime'] != '' && $args['to_datetime'] != '') {
            $from = $args['from_datetime'];
            $to = $args['to_datetime'];
            $condition .= " AND inc_amb.assigned_time BETWEEN '$from' AND '$to' ";
        }
        if ($args['base_month'] != '') {
            //$condition .= " AND inc_amb.inc_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
        }
        
        // $condition .= " AND amb.amb_rto_register_no='$ambulance' ";
        
        
       $sql= "Select inc_amb.amb_rto_register_no,count(*) as total_count,dist.dst_name,base.hp_name,amb.amb_type"
            . " FROM $this->tbl_incidence_ambulance as inc_amb"
            . " LEFT JOIN  $this->tbl_ambulance as amb ON (amb.amb_rto_register_no=inc_amb.amb_rto_register_no)"
            . " LEFT JOIN  ems_base_location as base ON (amb.amb_base_location=base.hp_id)"
            . " LEFT JOIN  ems_mas_districts as dist ON (base.hp_district=dist.dst_code)"
            . " where $condition1 $condition GROUP BY inc_amb.amb_rto_register_no";
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;

         if ($args['get_count']) {
             return $result->num_rows();
         } else {
            if(empty($result->result()))
            {
                $abc=['amb_rto_register_no'=> $args['amb_rto_register_no'],
                'total_count'=>0,
                'dst_name'=>$dst_name,
                'hp_name'=>$hp_name,
                'amb_type'=>$amb_type];
                // print_r((object)$abc);die();
                return (object)$abc;
            }
            else{
             $abc=$result->result();
            //  print_r($abc[0]);die();
                return $abc[0];
            }
         }
    }
    function get_Patient_served_count_ambulancewise($args = array())
    {
         
        $condition = $offlim = '';
      // var_dump($args);die;
       // $ambulance=$args['amb_rto_register_no'];
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59' ";
        }
        if ($args['from_datetime'] != '' && $args['to_datetime'] != '') {
            $from = $args['from_datetime'];
            $to = $args['to_datetime'];
            $condition .= " epcr.inc_datetime BETWEEN '$from' AND '$to' ";
        }
        if ($args['base_month'] != '') {
           // $condition .= " AND epcr.base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
        }
       /*$sql= "Select epcr.amb_reg_id as amb_rto_register_no,count(*) as total_count"
            . " FROM $this->tbl_epcr as epcr"
            . " where $condition GROUP BY epcr.amb_reg_id";*/
            if ($args['amb_rto_register_no'] != '') {

                $condition .= "AND amb.amb_rto_register_no IN ('" . $args['amb_rto_register_no'] . "') ";
                
            }
        
           /* $sql= "Select amb.amb_rto_register_no,count(*) as total_count"
                 . " FROM $this->tbl_ambulance as amb"
                 . " LEFT JOIN  $this->tbl_incidence_ambulance as inc_amb ON (inc_amb.amb_rto_register_no=amb.amb_rto_register_no)"
                 . " where 1=1 $condition GROUP BY amb.amb_rto_register_no";
*/
            $sql= "Select epcr.amb_reg_id as amb_rto_register_no,count(*) as total_count"
            . " FROM $this->tbl_epcr as epcr"
            . " LEFT JOIN  $this->tbl_ambulance as amb ON (amb.amb_rto_register_no=epcr.amb_reg_id)"
            . " where $condition GROUP BY epcr.amb_reg_id";
        $result = $this->db->query($sql);
     //echo $this->db->last_query();die;

       if ($args['get_count']) {
        return $result->num_rows();
    } else {
        $abc=$result->result();
       return $abc[0];
    }
    }
    function get_fuel_filling_data($args =array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ff.ff_fuel_date_time BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT ff.*,district.dst_name,fs.f_station_name,clg.clg_first_name,amb.amb_default_mobile,clg.clg_mid_name,clg.clg_last_name,clg_pilot.clg_mobile_no,amb_type.ambt_name,div_code.div_name"
            . " FROM $this->tbl_fleet_fuel_filling as ff"
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ff.ff_district_code )"
            . " LEFT JOIN $this->tbl_fuel_station as fs ON ( fs.f_id = ff.ff_fuel_station )" 
            . " LEFT JOIN $this->tbl_colleague as clg ON ( clg.clg_ref_id = ff.ff_added_by )" 
            . " LEFT JOIN $this->tbl_colleague as clg_pilot ON ( clg_pilot.clg_ref_id = ff.ff_pilot_id )" 
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = ff.ff_amb_ref_no )" 
            . " LEFT JOIN ems_mas_ambulance_type as amb_type ON ( amb_type.ambt_id = amb.amb_type )" 
            . " LEFT JOIN ems_mas_division as div_code ON (div_code.div_id = district.div_id )"
            . " where 1=1 $condition";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function close_db_connection() {
        $this->db->close();
    }

    function get_ambulance_maintance_data($args =array(), $offset = '', $limit = ''){
        //var_dump($args);die;
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.mt_offroad_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if (isset($args['search']) && $args['search'] != '') {
            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%'  OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%".trim($args['search'])."%')";
        }
        
        if ($args['search_status'] != '') {
            if($args['search_status'] == 'mt_isupdated'){
                $condition .= " AND am_mt.mt_isupdated = '1' ";
            }else{
                $condition .= " AND am_mt.mt_ambulance_status = '" . $args['search_status'] . "' ";
            }
        }
        if($args['mt_approval'] == '1'){
             $condition .= " AND am_mt.mt_approval = '" . $args['mt_approval'] . "'";
        }else if($args['mt_approval'] == '0'){
             $condition .= " AND am_mt.mt_approval = '" . $args['mt_approval'] . "'";
        }
         if($args['mt_isupdated'] != ''){
             $condition .= " AND am_mt.mt_isupdated = '" . $args['mt_isupdated'] . "'";
        }
        

        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        if (trim($args['thirdparty']) != '') {
            //$condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        $sql = "SELECT am_mt.*,hp.hp_name,district.dst_name,ws.ws_station_name,state.st_name,amb.amb_status"
            . " FROM $this->tbl_amb_main as am_mt"
            . " LEFT JOIN $this->tbl_work_station as ws ON ( ws.ws_id = am_mt.mt_work_shop ) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = am_mt.mt_state_id ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' $condition  order by am_mt.added_date DESC $offlim";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();
        //die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
        function get_preventive_ambulance_maintance_data($args =array(), $offset = '', $limit = ''){
        //var_dump($args);die;
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
          if (trim($args['rto_no']) != '') {
            $condition .= "AND am_mt.mt_amb_no = '" . $args['rto_no'] . "' ";
        }
          if (trim($args['mt_approval']) != '') {
            $condition .= "AND am_mt.mt_approval  = '" . $args['mt_approval'] . "' ";
        }

        $sql = " SELECT am_mt.* "
             . " FROM $this->tbl_amb_main as am_mt"
             . " where am_mt.mt_isdeleted='0' $condition order by am_mt.added_date DESC limit 1";
         
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function insert_ambulance_maintance($args = array()) {

        $this->db->insert($this->tbl_amb_main, $args);
        //echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    
    function insert_media_maintance($args = array()) {

        $this->db->insert($this->tbl_media, $args);
        // echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    function get_photo_history($args =array())
    {//var_dump($args);die;
        $sql="select re_request_id from ems_amb_accidental_maintaince_re_request_history where mt_id= '" . $args['mt_id']. "' AND re_mt_type= '" . $args['mt_type']. "' ";
        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        return $result->result_array();
    }
    
    function get_media_maintance($args = array()) {
       // var_dump($args); die;
         if (trim($args['re_mt_id']) != '') {
            $condition .= "AND media.user_id = '" . trim($args['re_mt_id']) . "' ";
            //echo $this->db->last_query();die;
        }
        if (trim($args['mt_id']) != '') {
            $condition .= "AND media.user_id = '" . trim($args['mt_id']) . "' ";
            //echo $this->db->last_query();die;
        }
        if (trim($args['re_request_id']) != '') {
            $condition .= "AND media.re_request_id IN ('" . $args['re_request_id'] . "') ";
            //echo $this->db->last_query();die;
        }
        
        if (trim($args['mt_type']) != '') {
            if($args['mt_type'] == 'vendor_invoice_breakdown'){
                 $condition .= "AND media.media_data IN ('vendor_invoice_breakdown','invoice_breakdown') ";
            }else{
            $condition .= "AND media.media_data = '" . $args['mt_type'] . "' ";
            }
           // echo $this->db->last_query();die;
        }
         if (trim($args['id']) != '') {
            $condition .= "AND media.id = '" . $args['id'] . "' ";
           //echo $this->db->last_query();die;
        }


        $sql = "SELECT media.* FROM $this->tbl_media as media "
            . "where 1=1 $condition";
        
      //die();
        $result = $this->db->query($sql);
        

    

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function delete_media($id){
        
        $this->db->where('id', $id);
        $data=$this->db->delete($this->tbl_media);
        
        return $data;
    }
    
    
    function update_ambulance_maintance($args = array()) {

        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update($this->tbl_amb_main, $args);
        //echo $this->db->last_query();
       // die();

        return $data;
    }
    
    function get_ambulance_break_maintance_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
//var_dump($args);die;
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        
         if (trim($args['amb_district']) != '') {
            $condition .= "AND am_mt.mt_district_id IN ('" . $args['amb_district'] . "') ";
        }
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%'  OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_base_loc LIKE '%" . trim($args['search']) . "%'OR am_mt.mt_ambulance_status LIKE '%" . trim($args['search']) . "%')";
        }
         if ($args['search_status'] != '' && $args['search_status'] != '') {
           $condition .= "AND am_mt.mt_ambulance_status = '" . $args['search_status'] . "' ";
        }
        if ($args['vendor_id'] != '' && $args['vendor_id'] != '') {
           $condition .= "AND ws.vendor_id  = '" . $args['vendor_id'] . "' ";
        }
         if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if (trim($args['thirdparty']) != '') {
            //$condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        $sql = "SELECT am_mt.*,district.dst_name,ws.ws_station_name,state.st_name,amb.amb_status FROM $this->tbl_amb_brek_main as am_mt"
            . " LEFT JOIN $this->tbl_work_station as ws ON ( ws.ws_id = am_mt.mt_work_shop ) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            //. " LEFT JOIN $this->tbl_hp as hp ON ( hp.hp_name = am_mt.mt_base_loc )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = am_mt.mt_state_id ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' AND am_mt.mt_ambulance_status != 'Available' $condition group by am_mt.mt_id order by am_mt.added_date DESC $offlim";
     // die();
        
        $result = $this->db->query($sql);

//echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
function get_ambulance_break_maintance_data_odo($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
//var_dump($args);die;
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
         if ($args['rto_no'] != '') {
            $condition .= " AND am_mt.mt_amb_no   IN ('" . $args['rto_no'] . "') ";
        }

        $sql = "SELECT am_mt.* FROM $this->tbl_amb_brek_main as am_mt where am_mt.mt_isdeleted='0' $condition group by am_mt.mt_id order by am_mt.added_date DESC limit 1";
        
        $result = $this->db->query($sql);

//echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }    
    function get_ambulance_break_maintance_data_by_amb($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';

         if ($args['rto_no'] != '') {
            $condition .= " AND am_mt.mt_amb_no IN ('" . $args['rto_no'] . "') ";
        }

         $sql = "SELECT am_mt.* FROM $this->tbl_amb_brek_main as am_mt where am_mt.mt_isdeleted='0' $condition group by am_mt.mt_id order by am_mt.added_date DESC";
       
        
        $result = $this->db->query($sql);

        return $result->num_rows();
      
    }
    function insert_ambulance_break_maintance($args = array()) {

        $this->db->insert($this->tbl_amb_brek_main, $args);
    //    echo $this->db->last_query();
    //     die();
        return $this->db->insert_id();
    }
    
    function update_ambulance_break_maintance($args = array()) {

        if($args['mt_id'] != ''){
            $this->db->where_in('mt_id', $args['mt_id']);

            $data = $this->db->update($this->tbl_amb_brek_main, $args);
            //echo $this->db->last_query();
          // die();
     
            return $data;
        }
    }
    function get_incident_data($args = array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59' ";
        }
        if ($args['from_datetime'] != '' && $args['to_datetime'] != '') {
            $from = $args['from_datetime'];
            $to = $args['to_datetime'];
            $condition .= " inc.inc_datetime BETWEEN '$from' AND '$to' ";
        }
        if ($args['base_month'] != '') {
            $condition .= "AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
        }
       $sql= "Select inc.inc_added_by,inc.inc_type"
            . " FROM $this->tbl_incidence as inc"
            . " where $condition";
        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;

         if ($args['get_count']) {
             return $result->num_rows();
         } else {
             return $result->result();
         }
    }
    function get_login_details($args = array())
    {
       // var_dump($args);die;
       $group='UG-ERO';
       if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= " AND clg_log.clg_login_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
       
        if ($args['from_datetime'] != '' && $args['to_datetime'] != '') {
            $from = $args['from_datetime'];
            $to = $args['to_datetime'];
            $condition .= " AND clg_log.clg_login_time BETWEEN '$from' AND '$to' ";
        }
        
        if ($args['qa_ad_user_ref_id'] != '') {
            $condition .= " AND clg_log.clg_ref_id LIKE '%".$args['qa_ad_user_ref_id']."%' ";
        }
//        $sql = "SELECT * "
//            . " FROM $this->tbl_colleague AS clg "
//            . " LEFT JOIN $this->tbl_clg_logins AS clg_log ON ( clg_log.clg_ref_id = clg.clg_ref_id )"
//            . " WHERE 1=1  AND clg_log.clg_login_time != '' $condition ORDER BY clg_log.clg_login_time";
        
        
          $sql = "SELECT SUM(TIME_TO_SEC(timediff(clg_logout_time,clg_login_time))) as login_total"
         . " FROM $this->tbl_clg_logins as clg_log"
         . " WHERE  clg_logout_time != '0000-00-00 00:00:00'  $condition ORDER BY clg_login_time ";
      
         
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
    function get_break_details($args = array())
    {
       // $group='UG-ERO';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND clg_brk.clg_break_time BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        
        if ($args['from_datetime'] != '' && $args['to_datetime'] != '') {
            $from = $args['from_datetime'];
            $to = $args['to_datetime'];
             $condition .= " AND clg_brk.clg_break_time BETWEEN '$from' AND '$to'";
        }
        
        
        if ($args['qa_ad_user_ref_id'] != '') {
            $condition .= " AND clg_brk.clg_ref_id LIKE '%".$args['qa_ad_user_ref_id']."%'";
        }
        
//        $sql = "SELECT clg.clg_ref_id,clg_brk.clg_break_type,clg_brk.clg_break_time,clg_brk.clg_back_to_break_time,clg_brk.break_time"
//         . " FROM $this->tbl_colleague AS clg "
//         . " LEFT JOIN $this->tbl_clg_break_summary AS clg_brk ON ( clg_brk.clg_ref_id = clg.clg_ref_id )"
//         . " WHERE 1=1 AND clg_brk.clg_break_time != ' '  $condition ORDER BY clg_brk.clg_break_time ";
          
        $sql = "SELECT SUM(TIME_TO_SEC(timediff(clg_back_to_break_time,clg_break_time))) as brk_total"
         . " FROM $this->tbl_clg_break_summary AS clg_brk "
         . " WHERE clg_brk.clg_back_to_break_time != '0000-00-00 00:00:00'  $condition ORDER BY clg_brk.clg_break_time ";
        
         $result = $this->db->query($sql);
//        echo $this->db->last_query();
//        die();
         if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
    function preventive_maintenance_report($args = array()){
        
          if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND prv_mian.mt_offroad_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            }
            if($args['mt_approval'] != ''){
                $condition .= " AND prv_mian.mt_approval = '" . $args['mt_approval'] . "' ";
            }
            if($args['mt_isupdated'] != ''){
                $condition .= " AND prv_mian.mt_isupdated = '" . $args['mt_isupdated'] . "' ";
            }
             $sql= "Select prv_mian.*"
                . " FROM $this->tbl_amb_main as prv_mian"
                . " where 1=1 $condition ";
            
             $result = $this->db->query($sql);
 
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_preventive_maintenance_to_update($args = array()){
       
          if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND prv_mian.mt_offroad_datetime BETWEEN '$from' AND '$to'";
            }
            if($args['mt_approval'] != ''){
                $condition .= " AND prv_mian.mt_approval = '" . $args['mt_approval'] . "' ";
            }
            if($args['mt_isupdated'] != ''){
                $condition .= " AND prv_mian.mt_isupdated = '" . $args['mt_isupdated'] . "' ";
            }
             $sql= "Select prv_mian.*"
                . " FROM $this->tbl_amb_main as prv_mian"
                . " where 1=1 $condition ";
            
            
             $result = $this->db->query($sql);
 
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        } 
    }
    function get_maintenance_report($args = array())
    {
       $condition = $offlim = '';
       
        
        if($args['maintenance_type']=='preventive_maintenance'){
            
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " prv_mian.added_date BETWEEN '$from' AND '$to 23:59:59'";
            }
            if ($args['base_month'] != '') {
               // $condition .= "AND prv_mian.mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
            }
            $sql= "Select prv_mian.*,state.st_name"
                . " FROM $this->tbl_amb_main as prv_mian"
                . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = prv_mian.mt_state_id ) "
                // . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = prv_mian.mt_district_id )"
                // . " LEFT JOIN $this->tbl_hospital as hos ON ( hos.hp_name = prv_mian.mt_base_loc )" 
                . " LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prv_mian.mt_amb_no)"
                . " where $condition ";
       }else if($args['maintenance_type']=='onroad_offroad_maintenance' ){
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " onoff_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
            }
            if ($args['base_month'] != '') {
                //$condition .= "AND onoff_main.mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
            }
            $sql= "Select onoff_main.*,state.st_name"
                . " FROM $this->tbl_amb_on_of as onoff_main"
                . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = onoff_main.mt_state_id ) "
                . " LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = onoff_main.mt_amb_no)"
                // . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = onoff_main.mt_district_id )"
                . " where $condition ";
        }elseif($args['maintenance_type']=='breakdown_maintenance')
        {
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " brk_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
            }
            if ($args['base_month'] != '') {
                //$condition .= "AND brk_main.mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
            }
            $sql= "Select brk_main.*,state.st_name"
            . " FROM $this->tbl_amb_brek_main as brk_main"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = brk_main.mt_state_id ) "
            // . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = brk_main.mt_district_id )"
            . " LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = brk_main.mt_amb_no)"
            . " where $condition ";

         }elseif($args['maintenance_type']=='tyre_life_maintenance')
        {
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " tyre_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
            }
            if ($args['base_month'] != '') {
                //$condition .= "AND tyre_main.mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
            }
            $sql= "Select tyre_main.*,state.st_name"
            . " FROM $this->tbl_amb_tyre as tyre_main"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = tyre_main.mt_state_id ) "
            // . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = tyre_main.mt_district_id )"
            . " LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = tyre_main.mt_amb_no)"
            . " where $condition ";
        }elseif($args['maintenance_type']=='accidental_maintenance'){
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " acc_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
            }
            if ($args['base_month'] != '') {
                //$condition .= "AND acc_main.mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
            }
            $sql= "Select acc_main.*,state.st_name"
            . " FROM $this->tbl_amb_acc_main as acc_main"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = acc_main.mt_state_id ) "
            // . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = acc_main.mt_district_id )"
            . " LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = acc_main.mt_amb_no)"
             . " where $condition ";
        }
    
        elseif($args['maintenance_type']=='all'){
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " added_date BETWEEN '$from' AND '$to 23:59:59'";
            }
            if ($args['base_month'] != '') {
                //$condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
            }
           $sql ="select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_acc_main as acc_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = acc_main.mt_amb_no ) where $condition"
           ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_tyre as tyre_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = tyre_main.mt_amb_no ) where $condition"
           ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_brek_main as break_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = break_main.mt_amb_no )where $condition"
           ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_on_of as on_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no )where $condition"
           ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_main as prev_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev_main.mt_amb_no )"
            . " where $condition ";
        }
        $result = $this->db->query($sql);
   //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }

    // function get_ambulance_onoff_data($args =array(), $offset = '', $limit = ''){
    //     $condition = $offlim = '';
    //    // var_dump($args);die;
    //     if ($args['from_date'] != '' && $args['to_date'] != '') {
    //         $from = $args['from_date'];
    //         $to = $args['to_date'];
    //         $condition .= " added_date BETWEEN '$from' AND '$to 23:59:59'";
    //     }
    //     if ($args['base_month'] != '') {
    //         $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
    //     }
    //    $sql ="select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_acc_main as acc_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = acc_main.mt_amb_no ) where $condition"
    //    ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_tyre as tyre_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = tyre_main.mt_amb_no ) where $condition"
    //    ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_brek_main as break_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = break_main.mt_amb_no )where $condition"
    //    ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_on_of as on_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no )where $condition"
    //    ."UNION ALL select mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type FROM $this->tbl_amb_main as prev_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev_main.mt_amb_no )"
    //     . " where $condition ";
    
    // $result = $this->db->query($sql);
    //     //echo $this->db->last_query();die;
    // if ($args['get_count']) {
    //     return $result->num_rows();
    // } else {
    //     return $result->result();
    // }

    // }
    function get_ambulance_onoff_data($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['base_month'] != '') {
           // $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
        }
       $sql ="select mt_accidental_id,mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,mt_ex_onroad_datetime,mt_accidental_previos_odometer as mt_prev_odo,mt_previos_odometer,mt_in_odometer,mt_end_odometer,added_by,approved_by   FROM $this->tbl_amb_acc_main as acc_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = acc_main.mt_amb_no ) where $condition"
       ."UNION ALL select mt_tyre_id,mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,mt_ex_onroad_datetime,mt_tyre_previos_odometer as mt_prev_odo,mt_previos_odometer,mt_in_odometer,mt_end_odometer,added_by,approved_by  FROM $this->tbl_amb_tyre as tyre_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = tyre_main.mt_amb_no ) where $condition"
       ."UNION ALL select mt_breakdown_id,mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,mt_ex_onroad_datetime,mt_accidental_previos_odometer as mt_prev_odo,mt_previos_odometer,mt_in_odometer,mt_end_odometer,added_by,approved_by  FROM $this->tbl_amb_brek_main as break_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = break_main.mt_amb_no ) where $condition"
       ."UNION ALL select mt_onoffroad_id,mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,mt_ex_onroad_datetime,mt_onraod_previos_odometer as mt_prev_odo,mt_previos_odometer,mt_in_odometer,mt_end_odometer,added_by,approved_by  FROM $this->tbl_amb_on_of as on_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) where $condition"
       ."UNION ALL select mt_preventive_id,mt_amb_no,added_date,mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,mt_ex_onroad_datetime,mt_preventive_previos_odometer as mt_prev_odo,mt_previos_odometer,mt_in_odometer,mt_end_odometer,added_by,approved_by  FROM $this->tbl_amb_main as prev_main LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = prev_main.mt_amb_no )"
        . " where $condition ";
    
    $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_maintainance_data($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (trim($args['dist']) != '' ) {
            $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
        }
        if ($args['base_month'] != '') {
            $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
        }
        $sql ="SELECT * from ems_amb_onroad_offroad
        UNION       
        SELECT * from ems_amb_breakdown_maintaince";
        /*$sql ="select mt_onoffroad_id,mt_amb_no,on_main.added_date,div1.div_name,
                mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
                mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,
                mt_ex_onroad_datetime,mt_onraod_previos_odometer as mt_prev_odo,mt_previos_odometer,
                mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,mt_offroad_reason,clg.clg_first_name as first_name,
                clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
                clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
                FROM ems_amb_onroad_offroad as on_main 
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
                LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
                LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
                LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
                LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
                where $condition";*/
    
                $result = $this->db->query($sql);
         echo $this->db->last_query();die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_onoff_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        //$condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
       if (trim($args['dist']) != '' ) {
        $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
    }
    if ($args['base_month'] != '') {
        $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
     }
     $condition .= "AND mt_ambulance_status = 'Approved' AND mt_isdeleted = '0'" ;
     $condition .= " AND amb.amb_status IN ('7') "; 
     $condition .= " AND amb.ambis_deleted ='0' "; 
        // if (trim($args['zone']) != '') {
        //     $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        // }
       
       $sql ="select mt_onoffroad_id,mt_amb_no,on_main.remark_after_approval,on_main.added_date,on_main.mt_other_offroad_reason,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_onraod_previos_odometer as mt_prev_odo,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,mt_offroad_reason,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_onroad_offroad as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die();
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_accidental_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
       // $condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
       $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
       if (trim($args['dist']) != '' ) {
        $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
    }
    if ($args['base_month'] != '') {
        $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
     }
     $condition .= "AND mt_ambulance_status = 'Approved' AND mt_isdeleted = '0'" ;
     $condition .= " AND amb.amb_status IN ('7') ";
     $condition .= " AND amb.ambis_deleted ='0' ";
        // if (trim($args['zone']) != '') {
        //     $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        // }
       $sql ="select on_main.mt_accidental_id,mt_amb_no,on_main.remark_after_approval,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_accidental_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_preventive_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        //$condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
       if (trim($args['dist']) != '' ) {
        $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
    }
    if ($args['base_month'] != '') {
        $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
     }
     
     $condition .= " AND amb.amb_status IN ('7') ";
     $condition .= " AND amb.ambis_deleted ='0' ";
       
        // if (trim($args['zone']) != '') {
        //     $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        // }
        $condition .= "AND mt_ambulance_status = 'Approved' AND mt_isdeleted = '0'" ;
       $sql ="select on_main.mt_preventive_id,mt_amb_no,on_main.remark_after_approval,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_ambulance_preventive_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
         //echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_manpower_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        //$condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= "  AND (DATE(on_main.added_date) <= '$to 23:59:59') ";
    }
       if (trim($args['dist']) != '' ) {
        $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
    }
    if ($args['base_month'] != '') {
        $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
     }
       
       
        // if (trim($args['zone']) != '') {
        //     $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        // }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $condition .= "AND mt_ambulance_status = 'Approved' AND mt_isdeleted = '0'" ;
        
       $sql ="Select on_main.mt_manpower_id,mt_amb_no,on_main.remark_after_approval,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_on_remark,amb.amb_type,amb.amb_status,
       on_main.mt_ex_onroad_datetime,on_main.mt_offroad_date,on_main.mt_ontime_onroad_date,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_manpower_offroad as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
    function get_tyre_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
       // $condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
       if (trim($args['dist']) != '' ) {
        $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
    }
    if ($args['base_month'] != '') {
        $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
     }
       
       
        // if (trim($args['zone']) != '') {
        //     $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        // }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $condition .= "AND mt_ambulance_status = 'Approved' AND mt_isdeleted = '0'" ;
       $sql ="select on_main.mt_tyre_id,mt_amb_no,on_main.remark_after_approval,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_tyre_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_breakdown_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        //$condition .= " on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
       if (trim($args['dist']) != '' ) {
        $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
    }
    if ($args['base_month'] != '') {
        $condition .= "AND mt_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
     }
       
       
        // if (trim($args['zone']) != '') {
        //     $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        // }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $condition .= "AND mt_ambulance_status = 'Approved' AND mt_isdeleted = '0'" ;
       $sql ="select on_main.mt_breakdown_id,mt_amb_no,on_main.remark_after_approval,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_breakdown_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_ambulance_accidental_maintance_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        // if (trim($args['thirdparty']) != '') {
        //     $condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        // }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_ambulance_status LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR hp.hp_name LIKE '%" . trim($args['search']) . "%')";
        }
        
        if ($args['search_status'] != '' && $args['search_status'] != '') {
           $condition .= "AND amb.amb_status = '" . $args['search_status'] . "' ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
      //  $condition .= "AND mt_ambulance_status = 'Approved' " ;
         $sql = "SELECT am_mt.*,clg.clg_first_name,clg.clg_last_name,hp.hp_name,district.dst_name,ws.ws_station_name,state.st_name,amb.amb_status,district.dst_name FROM $this->tbl_amb_acc_main as am_mt"
            . " LEFT JOIN $this->tbl_work_station as ws ON ( ws.ws_id = am_mt.mt_work_shop ) "
            . " LEFT JOIN $this->tbl_colleague as clg ON ( clg.clg_ref_id = am_mt.added_by ) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = am_mt.mt_state_id ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' AND am_mt.mt_ambulance_status != 'Available' $condition group by am_mt.mt_id order by am_mt.added_date DESC $offlim ";
        
        $result = $this->db->query($sql);

        // echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
        function get_accidental_maintance_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        if ($args['rto_no'] != '') {
            $condition .= " AND am_mt.mt_amb_no  IN ('" . $args['rto_no'] . "') ";
        }

         $sql = "SELECT am_mt.* FROM $this->tbl_amb_acc_main as am_mt "
            . " where am_mt.mt_isdeleted='0' $condition group by am_mt.mt_id order by am_mt.added_date DESC Limit 1 ";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_preventive_maintance_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        if ($args['rto_no'] != '') {
            $condition .= " AND am_mt.mt_amb_no  IN ('" . $args['rto_no'] . "') ";
        }

         $sql = "SELECT am_mt.* FROM $this->tbl_amb_main as am_mt "
            . " where am_mt.mt_isdeleted='0' $condition group by am_mt.mt_id order by am_mt.added_date DESC Limit 1 ";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_ambulance_accidental_maintance($args = array()) {

        $this->db->insert($this->tbl_amb_acc_main, $args);
      //echo $this->db->last_query();
        //die();
        return $this->db->insert_id();
    }

    function insert_accidental_maintaince_history($args = array()) {
        $this->db->insert($this->ems_amb_accidental_maintaince_history, $args);
        //echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    
    function update_ambulance_accidental_maintance($args = array()) {


        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update($this->tbl_amb_acc_main, $args);
       // echo $this->db->last_query();
        //die();

        return $data;
    }
    function re_request_ambulance_accidental_maintance($args = array()) {

        $this->db->insert($this->amb_accidental_maintaince_re_request_history, $args);
        //echo $this->db->last_query();die;
        return $this->db->insert_id();
        
    }

    function get_history($args = array()){
        //var_dump($args); die;   
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "mt_id = '" . $args['mt_id'] . "' ";
        }
       if (trim($args['mt_type']) != '') {
            $condition .= "AND re_mt_type = '" . $args['mt_type'] . "' ";
        }
         if (trim($args['re_request_id']) != '') {
            $condition .= "AND re_request_id = '" . $args['re_request_id'] . "' ";
        }
        $sql = "SELECT *"
        . " FROM $this->amb_accidental_maintaince_re_request_history"
        . " where $condition";
    
        //echo $sql;
    
    $result = $this->db->query($sql);

    //echo $this->db->last_query();die;

    
        return $result->result();
   

    }
    function get_history_photo($args = array()){
//var_dump($args['re_request_id']);die;
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "user_id = '" . $args['mt_id'] . "' ";
        }
        if (trim($args['re_request_id']) != '') {
            $condition .= "AND re_request_id IN ('" . $args['re_request_id'] . "')";
        }
        $sql = "SELECT *"
        . " FROM $this->tbl_media"
        . " where $condition";
    
        //echo $sql;
    
    $result = $this->db->query($sql);

   // echo $this->db->last_query();die;

    if($result){
        return $result->result();
    }

    }
    function get_grievance_photo($args = array()){
        $condition = $offlim = '';
        if (trim($args['gc_id']) != '') {
            $condition .= "user_id = '" . $args['gc_id'] . "' ";
        }
        $sql = "SELECT *"
                . " FROM $this->tbl_media"
                . " where $condition AND media_data='Grievace'";
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        if($result){
            return $result->result();
        }
    }
    function get_app_rej_his($args = array()){
       //var_dump($args); die;
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "re_mt_id = '" . $args['mt_id'] . "' AND re_mt_type = '" . $args['mt_type'] . "' ";
        }
       /* if (trim($args['mt_type']) != '') {
            $condition .= "re_mt_type = '" . $args['mt_type'] . "' ";
        }*/
        $sql = "SELECT *"
        . " FROM $this->ems_amb_accidental_maintaince_history"
        . " where $condition";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if($result){
            return $result->result();
        }
    }
    
    function get_ambulance_onroad_offroad_maintance_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%' OR hp.hp_name LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%" . trim($args['search']) . "%')";
        }
        
        if ($args['search_status'] != '' && $args['search_status'] != '') {
           $condition .= "AND amb.amb_status = '" . $args['search_status'] . "' ";
        }
        if (trim($args['thirdparty']) != '') {
            //$condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
         if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        $sql = "SELECT am_mt.*,clg.clg_first_name,clg.clg_last_name,hp.hp_name,district.dst_name,state.st_name,amb.amb_status"
            . " FROM $this->tbl_amb_on_of as am_mt"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_colleague as clg ON ( clg.clg_ref_id = am_mt.approved_by ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = am_mt.mt_state_id ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' AND am_mt.mt_ambulance_status != 'Available' AND  am_mt.mt_offroad_reason NOT IN ('Breakdown Maintenance','Accidental Maintenance','Schedule Service') $condition  order by am_mt.added_date DESC $offlim";
        
     
        
        $result = $this->db->query($sql);

        // echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
        function get_ambulance_onroad_offroad_maintance($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        if (trim($args['rto_no']) != '') {
            $condition .= "AND am_mt.mt_amb_no = '" . $args['rto_no'] . "' ";
        }
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }

        $sql = "SELECT am_mt.* "
            . " FROM $this->tbl_amb_on_of as am_mt"
            . " where am_mt.mt_isdeleted='0' $condition  order by am_mt.added_date DESC limit 1";
        
//        echo $sql;
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_ambulance_on_off_maintance($args = array()) {

        $this->db->insert($this->tbl_amb_on_of, $args);
//        echo $this->db->last_query();
//       die();
//          
        return $this->db->insert_id();
        
        
        $this->db->insert($this->tbl_amb_main, $args);
        
        return $this->db->insert_id();
        
        
    }
    function insert_manpower_maintance($args = array()) {

        $this->db->insert('ems_manpower_offroad', $args);    
      
        return $this->db->insert_id();

    }
    
    
    function update_ambulance_on_off_maintance($args = array()) {

        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update($this->tbl_amb_on_of, $args);
      //  echo $this->db->last_query();
       // die();

        return $data;
    }
    
    function get_ambulance_tyre_data($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
         if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        
            
        if ($args['search_status'] != '' && $args['search_status'] != '') {
           $condition .= "AND amb.amb_status = '" . $args['search_status'] . "' ";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        if (trim($args['thirdparty']) != '') {
            //$condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_ambulance_status LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%')";
        }

        $sql = "SELECT am_mt.*,hp.hp_name,district.dst_name,state.st_name,amb.amb_status,amb.amb_type FROM $this->tbl_amb_tyre as am_mt "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = am_mt.mt_state_id ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' $condition group by am_mt.mt_id order by am_mt.added_date DESC $offlim ";
        
        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
        
    function get_offroad_reason_list($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        

        if (trim($args['term']) != '') {
            $condition .= "AND am_mt.offroad_reason LIKE '%" . $args['term'] . "%' ";
        }
        if (trim($args['id']) != '') {
            $condition .= "AND am_mt.id = '" . $args['id'] . "' ";
        }

        
        $sql = "SELECT * FROM $this->tbl_offroad_reason as am_mt"
            . " where am_mt.is_deleted='0' $condition order by am_mt.id";
        
        $result = $this->db->query($sql);

       //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function get_ambulance_tyre_data_auto($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
         if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        if (trim($args['rto_no']) != '') {
            $condition .= "AND am_mt.mt_amb_no = '" . $args['rto_no'] . "' ";
        }
        

        $sql = "SELECT am_mt.* FROM $this->tbl_amb_tyre as am_mt"
            . " where am_mt.mt_isdeleted='0' $condition order by am_mt.added_date DESC limit 1 ";
        
        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_ambulance_tyre_maintance($args = array()) {
        $this->db->insert($this->tbl_amb_tyre, $args);
    //    echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    function update_ambulance_tyre_maintance($args = array()) {
        $this->db->where_in('mt_id', $args['mt_id']);
        $data = $this->db->update($this->tbl_amb_tyre, $args);
        //echo $this->db->last_query();
        //die();
        return $data;
    }
    
    function get_ambulance_onroad_offroad_report($args =array(), $offset = '', $limit = ''){
        
        $condition = $offlim = '';
    //     print_r($args);
    //    die();
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        if (trim($args['dist']) != '' ) {
            $condition .= "AND am_mt.mt_district_id = '" . $args['dist'] . "' ";
        }
        if (trim($args['zone']) != '') {
            $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%' OR hp.hp_name LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%')";
        }
        
        
       
         if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        $sql = "SELECT am_mt.*,am_mt.added_date as mt_added_date,am_mt.modify_date as mt_modify_date,hp.hp_name,district.dst_name,amb.amb_status,amb.amb_type,amb_type.ambt_name,div1.div_name"
            . " FROM $this->tbl_amb_on_of as am_mt"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN ems_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . " LEFT JOIN ems_mas_ambulance_type AS amb_type ON (amb_type.ambt_id = amb.amb_type ) "
            . "LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)"  
            . " where am_mt.mt_isdeleted='0' $condition  order by am_mt.added_date DESC";
            // echo $sql;
            // SELECT am_mt.*,am_mt.added_date as mt_added_date,am_mt.modify_date as mt_modify_date,
            // hp.hp_name,district.dst_name,amb.amb_status,amb.amb_type,amb_type.ambt_name 
            // FROM ems_amb_onroad_offroad as am_mt 
            // LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no )  
            // LEFT JOIN ems_base_location as hp ON ( hp.hp_id = amb.amb_base_location ) 
            // LEFT JOIN ems_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id ) 
            // LEFT JOIN ems_mas_ambulance_type AS amb_type ON (amb_type.ambt_id = amb.amb_type )  
            // where am_mt.mt_isdeleted='0'  
            // AND am_mt.added_date BETWEEN '2022-08-20' AND '2022-08-22 23:59:59'  
            // order by am_mt.added_date DESC 
        
        $result = $this->db->query($sql);
        // print_r($result->result());die;
        // echo $this->db->last_query();
            // return $result->result();   
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }    
    }
   function get_preventive_amb($args =array()){
        //var_dump($args);die;
        $condition = $offlim = '';
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to'";
        }
        

        $sql = " SELECT am_mt.* "
             . " FROM $this->tbl_amb_main as am_mt"
             . " where am_mt.mt_isdeleted='0' AND am_mt.mt_approval = '0' AND am_mt.mt_isupdated = '0' $condition order by am_mt.added_date DESC";
         
        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function last_insert_preventive_id() {
        $result = $this->db->query("SELECT mt_id FROM $this->tbl_amb_main ORDER BY mt_id DESC LIMIT 1");

        return $result->result();
    }
     function last_insert_breakdown_id() {
        $result = $this->db->query("SELECT mt_id FROM $this->tbl_amb_brek_main ORDER BY mt_id DESC LIMIT 1");

        return $result->result();
    }
    function get_ambulance_manpower_data($args =array(), $offset = '', $limit = ''){
        //var_dump($args);die;
        $condition = $offlim = '';
                     
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if (isset($args['search']) && $args['search'] != '') {
            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%'  OR am_mt.mt_offroad_date LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_ex_onroad_datetime LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%".trim($args['search'])."%')";
        }

        if ($args['search_status'] != '') {
            if($args['search_status'] == 'mt_isupdated'){
                $condition .= " AND am_mt.mt_isupdated = '1' ";
            }else{
                $condition .= " AND am_mt.mt_ambulance_status = '" . $args['search_status'] . "' ";
            }
        }
        if($args['mt_approval'] == '1'){
            $condition .= " AND am_mt.mt_approval = '" . $args['mt_approval'] . "'";
        }else if($args['mt_approval'] == '0'){
            $condition .= " AND am_mt.mt_approval = '" . $args['mt_approval'] . "'";
        }
        if($args['mt_isupdated'] != ''){
            $condition .= " AND am_mt.mt_isupdated = '" . $args['mt_isupdated'] . "'";
        }


        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        if (trim($args['thirdparty']) != '') {
            //$condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        $sql = "SELECT am_mt.*,hp.hp_name,district.dst_name,amb.amb_status"
            . " FROM ems_manpower_offroad as am_mt"

            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' $condition  order by am_mt.added_date DESC $offlim";
        
        $result = $this->db->query($sql);

        //echo $this->db->last_query();
        //die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function update_manpower($args = array()) {

        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update('ems_manpower_offroad', $args);
        //echo $this->db->last_query();
        //die();

        return $data;
    }
    
    function get_ambulance_scrape_vahicle_data($args =array(), $offset = '', $limit = ''){
        //var_dump($args);die;
        $condition = $offlim = '';
        
        if (trim($args['mt_id']) != '') {
            $condition .= "AND am_mt.mt_id = '" . $args['mt_id'] . "' ";
        }
        if (trim($args['mt_type']) != '') {
            $condition .= "AND am_mt.mt_type = '" . $args['mt_type'] . "' ";
        }
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND am_mt.mt_offroad_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if (isset($args['search']) && $args['search'] != '') {
            // $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%'  OR am_mt.mt_offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%' OR district.dst_name LIKE '%".trim($args['search'])."%')";
            $condition .= "AND (am_mt.mt_amb_no LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%".trim($args['search'])."%')";
        }
        
        if ($args['search_status'] != '') {
            if($args['search_status'] == 'mt_isupdated'){
                $condition .= " AND am_mt.mt_isupdated = '1' ";
            }else{
                $condition .= " AND am_mt.mt_ambulance_status = '" . $args['search_status'] . "' ";
            }
        }
        if($args['mt_approval'] == '1'){
             $condition .= " AND am_mt.mt_approval = '" . $args['mt_approval'] . "'";
        }else if($args['mt_approval'] == '0'){
             $condition .= " AND am_mt.mt_approval = '" . $args['mt_approval'] . "'";
        }
         if($args['mt_isupdated'] != ''){
             $condition .= " AND am_mt.mt_isupdated = '" . $args['mt_isupdated'] . "'";
        }
        

        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        if (trim($args['thirdparty']) != '') {
            //$condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        $sql = "SELECT am_mt.*,hp.hp_name,district.dst_name,amb.amb_status"
            . " FROM ems_scrape_vahicle as am_mt"

            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.mt_district_id )"
            . "where am_mt.mt_isdeleted='0' $condition  order by am_mt.added_date DESC $offlim";
        
        $result = $this->db->query($sql);

        // echo $this->db->last_query();
        // die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function update_scrape_vahicle($args = array()) {

        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update('ems_scrape_vahicle', $args);
        //echo $this->db->last_query();
        //die();

        return $data;
    }
    function insert_scrape_vahicle_maintance($args = array()) {

        $this->db->insert('ems_scrape_vahicle', $args);    
      //echo $this->db->last_query();
        //die();
        return $this->db->insert_id();

    }
    function get_detail_onoff_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        if ($args['to_date'] != '') {
        $to = $args['to_date'];
            $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
        }
        //$condition .= "AND mt_ambulance_status != 'Available' AND mt_isdeleted = '0'" ;
        //$condition .= " AND amb.amb_status IN ('7','11') "; 
        $sql ="select on_main.mt_other_offroad_reason,mt_onoffroad_id,mt_amb_no,on_main.added_date,div1.div_name,
        mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
        mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
        mt_ex_onroad_datetime,mt_onraod_previos_odometer as mt_prev_odo,mt_previos_odometer,
        mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,mt_offroad_reason,clg.clg_first_name as first_name,
        clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
        clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
        FROM ems_amb_onroad_offroad as on_main 
        LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
        LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
        LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
        LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
        LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
        where 1=1 $condition";
        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_detail_accidental_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
        if ($args['to_date'] != '') {
        $to = $args['to_date'];
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
        }
    
        //$condition .= "AND mt_ambulance_status != 'Available' AND mt_isdeleted = '0'" ;
        //$condition .= " AND amb.amb_status IN ('7','11') ";
    
       
       $sql ="select on_main.mt_accidental_id,mt_amb_no,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_accidental_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
    function get_detail_preventive_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
    //$condition .= " AND amb.amb_status IN ('7','11') ";
    //$condition .= "AND mt_ambulance_status != 'Available' AND mt_isdeleted = '0'" ;

       $sql ="select on_main.mt_preventive_id,mt_amb_no,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_ambulance_preventive_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_detail_manpower_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $to = $args['to_date'];
        $condition .= "  AND (DATE(on_main.added_date) <= '$to 23:59:59') ";
        }
       
        //$condition .= " AND amb.amb_status IN ('7','11') ";
        //$condition .= "AND mt_ambulance_status != 'Available' AND mt_isdeleted = '0'" ;
       $sql ="Select on_main.mt_manpower_id,mt_amb_no,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_on_remark,amb.amb_type,amb.amb_status,
       on_main.mt_ex_onroad_datetime,on_main.mt_offroad_date,on_main.mt_ontime_onroad_date,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_manpower_offroad as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
    function get_detail_tyre_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        //$from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
   
        //$condition .= " AND amb.amb_status IN ('7','11') ";
       // $condition .= "AND mt_ambulance_status != 'Available' AND mt_isdeleted = '0'" ;
       $sql ="select on_main.mt_tyre_id,mt_amb_no,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_tyre_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
    function get_detail_breakdown_data_only($args =array(), $offset = '', $limit = ''){
        $condition = $offlim = '';
       // var_dump($args);die;
       if ($args['to_date'] != '') {
        $to = $args['to_date'];
        $condition .= "  AND (DATE(on_main.mt_offroad_datetime) <= '$to 23:59:59') ";
    }
    //$condition .= " AND amb.amb_status IN ('7','11') ";
    //$condition .= "AND mt_ambulance_status != 'Available' AND mt_isdeleted = '0'" ;
       $sql ="select on_main.mt_breakdown_id,mt_amb_no,on_main.added_date,div1.div_name,
       mt_base_month,mt_base_loc,mt_district_id,mt_type,mt_offroad_datetime,mt_stnd_remark,
       mt_remark,mt_ambulance_status,mt_onroad_datetime,mt_on_remark,amb.amb_type,amb.amb_status,
       mt_ex_onroad_datetime,mt_previos_odometer,
       mt_in_odometer,mt_end_odometer,on_main.added_by,approved_by,clg.clg_first_name as first_name,
       clg.clg_mid_name as mid_name,clg.clg_last_name as last_name,clg_add.clg_first_name AS add_first,
       clg_add.clg_mid_name AS add_mid,clg_add.clg_last_name AS add_last
       FROM ems_amb_breakdown_maintaince as on_main 
       LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = on_main.mt_amb_no ) 
       LEFT JOIN ems_colleague as clg ON ( clg.clg_ref_id = on_main.added_by) 
       LEFT JOIN ems_colleague as clg_add ON ( clg_add.clg_ref_id = on_main.approved_by) 
       LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.mt_district_id )
       LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id)  
       where 1=1 $condition";
    
        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
    if ($args['get_count']) {
        return $result->num_rows();
    } else {
        return $result->result();
    }

    }
}