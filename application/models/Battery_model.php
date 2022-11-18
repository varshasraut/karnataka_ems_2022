<?php

class Battery_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {
        parent::__construct();
        $this->load->helper('date');
        $this->load->database();
        $this->tbl_battery = $this->db->dbprefix('battery');
        $this->tbl_battery_make = $this->db->dbprefix('mas_battery_make');
        $this->tbl_hp = $this->db->dbprefix('hospital');
         $this->tbl_base_location = $this->db->dbprefix('base_location');
        $this->tbl_state = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        
    }

    function get_total_battery($args =array(), $offset = '', $limit = ''){
        
                
        $condition = $offlim = '';
        
        if (trim($args['bt_id']) != '') {
            $condition .= "AND am_mt.bt_id = '" . $args['bt_id'] . "' ";
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
            $condition .= "AND amb.thirdparty = '" . $args['thirdparty'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (am_mt.amb_ref_no LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_ambulance_status LIKE '%" . trim($args['search']) . "%' OR am_mt.offroad_datetime LIKE '%" . trim($args['search']) . "%' OR am_mt.mt_onroad_datetime LIKE '%" . trim($args['search']) . "%')";
        }

        $sql = "SELECT am_mt.*,hp.hp_name,district.dst_name,state.st_name,amb.amb_status FROM $this->tbl_battery as am_mt"
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = am_mt.amb_ref_no  ) "
            . " LEFT JOIN $this->tbl_base_location as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = am_mt.state ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = am_mt.district )"
            . "where am_mt.bt_isdeleted='0' $condition group by am_mt.bt_id order by am_mt.added_date DESC $offlim ";
      
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_battery_life($args = array()) {

        $this->db->insert($this->tbl_battery, $args);
        return $this->db->insert_id();
    }
    
    function update_battery_life($args = array()) {

        $this->db->where_in('bt_id', $args['bt_id']);
        $data = $this->db->update($this->tbl_battery, $args);
        //echo $this->db->last_query();
        //die();
       
        return $data;
    }
    function get_battery_make($args = array()){
         if( $args['id'] != ''){
            $condition .= " AND id = '" . $args['id'] . "'  ";
        }

        $result=$this->db->query("select * from $this->tbl_battery_make where 1=1 $condition ");
        //echo $this->db->last_query();
        //die();
         if ($result) {
          return $result->result();
      } else {
          return false;
      }
    }
 
}