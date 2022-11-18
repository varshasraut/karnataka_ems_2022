<?php

class Biomedical_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_state = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_ind_req = $this->db->dbprefix('indent_request');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_equp_ser_cen = $this->db->dbprefix('equipment_service_center');
        $this->tbl_bio_medical_equipment_maintaince = $this->db->dbprefix('bio_medical_equipment_maintaince');
        $this->break_equip = $this->db->dbprefix('break_equip_maintaince');
        $this->tbl_ambulance_status_summary = $this->db->dbprefix('ambulance_status_summary');
        $this->tbl_inveqp = $this->db->dbprefix('inventory_equipment');
        $this->tbl_media = $this->db->dbprefix('media');
        $this->tbl_break_equip_maintaince = $this->db->dbprefix('break_equip_maintaince');
        $this->ems_amb_accidental_maintaince_history = $this->db->dbprefix('amb_accidental_maintaince_history');
        $this->amb_accidental_maintaince_re_request_history = $this->db->dbprefix('amb_accidental_maintaince_re_request_history');
        $this->tbl_break_equip_spare_part = $this->db->dbprefix('break_equip_spare_part');
         $this->tbl_equipment_audit = $this->db->dbprefix('equipment_audit');
         $this->tbl_equipment_audit_item = $this->db->dbprefix('equipment_audit_item');

         $this->tbl_tyre_req = $this->db->dbprefix('tyre_request');
       // $this->ems_bio_medical_equipment_maintaince = $this->db->dbprefix('bio_medical_equipment_maintaince');
        
       
    }

    function get_all_equipment_item($args = array(), $offset = '', $limit = '') {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.req_id='" . $args['req_id'] . "'";
        }
        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= " AND ind_req.req_type = '$req_type'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= " AND ind_req.req_group = '$req_grp'";
        }

        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= " AND ind_req.req_is_approve = '$req_grp'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= " AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= " AND (ind_req.req_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }

        $sql = "SELECT ind_req.*,hp.hp_name,district.dst_name "
            . "FROM $this->tbl_ind_req as ind_req "
            //. "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON (  amb.amb_rto_register_no = ind_req.req_amb_reg_no ) "
             . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code ) "
            //. " LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . " where ind_req.req_isdeleted ='0'  $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";





        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_all_equipment_item_details($args = array(), $offset = '', $limit = '') {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.req_id='" . $args['req_id'] . "'";
        }
        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= " AND ind_req.req_type = '$req_type'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= " AND ind_req.req_group = '$req_grp'";
        }

        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= " AND ind_req.req_is_approve = '$req_grp'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= " AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= " AND (ind_req.req_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }

        $sql = "SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk "
            . "FROM $this->tbl_ind_req as ind_req "
            . "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON (  amb.amb_rto_register_no = ind_req.req_amb_reg_no ) "
             . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code ) "
            . " LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . " where ind_req.req_isdeleted ='0'  $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";


//echo $sql;
//die();

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function insert_equipment_maintaince($args = array()) {

        $this->db->insert($this->tbl_bio_medical_equipment_maintaince, $args);

        return $this->db->insert_id();
    }

    function get_all_equipment_maintaince_data($args = array()) {

        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND main.eq_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if (trim($args['mt_id']) != '') {
            $condition .= "AND main.eq_id = '" . $args['eq_id'] . "' ";
        }
        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (stat.sc_amb_ref_number LIKE '%" . trim($args['search']) . "%' OR hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  main.eq_added_date LIKE '%" . trim($args['search1']) . "%'";
        }

        $sql = "SELECT * FROM $this->tbl_bio_medical_equipment_maintaince as main"
            . " LEFT JOIN $this->tbl_inveqp AS inveqp ON(inveqp.eqp_id=main.eq_equip_name) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = main.eq_amb_ref_no ) "
            . " LEFT JOIN $this->tbl_hp as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = main.eq_state_code ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = main.eq_district_code )"
            . "where eq_is_deleted='0' $condition $offlim ";

        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function equipment_maintaince_update_data($new_data = array()) {

        $this->db->where_in('eq_id', $new_data['eq_id']);

        $data = $this->db->update($this->tbl_bio_medical_equipment_maintaince, $new_data);

        return $data;
    }

    function get_break_equipment_maintaince_data($args = array()) {

        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND main.added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if (trim($args['mt_id']) != '') {
            $condition .= " AND main.mt_id = '" . $args['mt_id'] . "' ";
        }

        if (isset($args['search']) && $args['search'] != '') {

             $condition .= " AND (main.mt_amb_no LIKE '%" . trim($args['search']) . "%' OR hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' OR state.st_name LIKE '%" . trim($args['search']) . "%')";
        }

   
        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= " AND  main.added_date LIKE '%" . trim($args['search1']) . "%'";
        }
        if ($args['search_status'] != '' && $args['search_status'] != '') {
            $condition .= " AND amb.amb_status = '" . $args['search_status'] . "' ";
        }

        $sql = "SELECT main.*,hp.hp_name,district.dst_name,state.st_name,amb.amb_status,ser.es_service_center_name,eqip.type_name, eqip.id as type_id FROM $this->break_equip as main"
            . " LEFT JOIN $this->tbl_equp_ser_cen as ser ON ( ser.es_id = main.mt_service_center ) "
//            . " LEFT JOIN $this->tbl_ambulance_status_summary as summery ON ( summery.amb_rto_register_no = main.mt_amb_no ) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON ( amb.amb_rto_register_no = main.mt_amb_no ) "
            . " LEFT JOIN ems_inventory_type as eqip ON ( eqip.id = main.eq_equip_name_type ) "
         . " LEFT JOIN $this->tbl_hp as hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_state as state ON ( state.st_code = main.mt_state_id ) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = main.mt_district_id )"
            . " where mt_isdeleted='0' $condition order by main.mt_id DESC $offlim ";

//        echo $sql;

        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function insert_equipment_break_maintance($args = array()) {

        $this->db->insert($this->break_equip, $args);
        //echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    function insert_spare_part($args = array()){
        $this->db->insert($this->tbl_break_equip_spare_part, $args);
        return $this->db->insert_id();
    }

    function insert_media_maintance($args = array()) {
//var_dump($args);die();

        $this->db->insert($this->tbl_media, $args);
        return $this->db->insert_id();

           //echo $this->db->last_query();die;
    }

    function update_ambulance_maintance($args = array()) {

        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update($this->break_equip, $args);


        return $data;
    }
    function update_equ_breakdown_maintance($args = array()) {


        $this->db->where_in('mt_id', $args['mt_id']);

        $data = $this->db->update($this->tbl_break_equip_maintaince, $args);
        return $data;
    }
    function insert_qui_break_maintaince_history($args = array()){
        $this->db->insert($this->ems_amb_accidental_maintaince_history, $args);
         //echo $this->db->last_query();die;
        return $this->db->insert_id();
    }
    function update_equ_maintance($args = array()){
        //var_dump($args);die();
        $this->db->where_in('eq_id', $args['eq_id']);
        $data = $this->db->update($this->tbl_bio_medical_equipment_maintaince, $args);
        //echo $this->db->last_query();die;
        return $data;

    }
    function re_request_breakdown_equipment_maintance($args = array()){
        //var_dump($args);die();
        $this->db->insert($this->amb_accidental_maintaince_re_request_history, $args);
        return $this->db->insert_id();
        
    }
    function get_photo_history($args =array())
    {   $sql="select re_request_id from ems_amb_accidental_maintaince_re_request_history where mt_id= '" . $args['mt_id']. "' AND re_mt_type= '" . $args['mt_type']. "' ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;

        return $result->result_array();
    }
    function get_media_maintance($args = array()) {
        //var_dump($args['re_request_id']); die;
         if (trim($args['mt_id']) != '') {
            $condition .= "AND media.user_id = '" . $args['mt_id'] . "' ";
            //echo $this->db->last_query();die;
        }
        if (trim($args['re_request_id']) != '') {
            $condition .= "AND re_request_id IN ('" . $args['re_request_id'] . "') ";
            //echo $this->db->last_query();die;
        }
        
        if (trim($args['mt_type']) != '') {
            $condition .= "AND media.media_data = '" . $args['mt_type'] . "' ";
        }


        $sql = "SELECT media.* FROM $this->tbl_media as media "
            . "where 1=1 $condition";
        
        $result = $this->db->query($sql);

       //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
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
        $sql = "SELECT *"
        . " FROM $this->amb_accidental_maintaince_re_request_history"
        . " where $condition";
    
        //echo $sql;
        //echo $this->db->last_query();die;
    
         $result = $this->db->query($sql);

    

    
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
        
            
                return $result->result();
        
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
                 return $result->result();
             }
function get_last_breakdown_maintaince_data($args = array()) {



        if (trim($args['rto_no']) != '') {
            $condition .= " AND main.mt_amb_no = '" . $args['rto_no'] . "' ";
        }


        $sql = " SELECT main.* FROM $this->break_equip as main"
             . " LEFT JOIN $this->tbl_equp_ser_cen as ser ON ( ser.es_id = main.mt_service_center ) "
             . " where mt_isdeleted='0' $condition order by main.mt_id DESC limit 1";

      // echo $sql;
      // die();

        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_sparepart_list($args = array()){
        
        $condition= '';
        if (trim($args['type']) != '') {
            $condition .= " AND type IN ('" . $args['type'] . "') ";
        }
        
        $sql = " SELECT * FROM ems_spare_part as main"
             . " where is_deleted='0' $condition ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
     function get_equipment_audit($args = array(), $offset = '', $limit = '') {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.id='" . $args['req_id'] . "'";
        }
        if ((isset($args['ambulance_no'])) && $args['ambulance_no'] != "") {
            $condition .= " AND ind_req.ambulance_no='" . $args['ambulance_no'] . "'";
        }
        

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= " AND (ind_req.ambulance_no LIKE '%" . trim($args['search']) . "%' OR ind_req.base_location LIKE '%" . trim($args['search']) . "%' )";
        }

        $sql = "SELECT * "
            . "FROM $this->tbl_equipment_audit as ind_req "
            . " where ind_req.is_deleted  ='0'  $condition ORDER BY ind_req.id DESC $offlim ";
//        echo $sql;
//        die();

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_equipment_audit($args = array()) {

        $this->db->insert($this->tbl_equipment_audit, $args);
      
        return $this->db->insert_id();
    }
    function insert_equipment_audit_item($args = array()) {

        $this->db->insert($this->tbl_equipment_audit_item, $args);
   
        return $this->db->insert_id();
    }
function get_equipment_audit_item($args = array()) {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.equipment_audit_id='" . $args['req_id'] . "'";
        }



        $sql = "SELECT * "
            . "FROM $this->tbl_equipment_audit_item as ind_req "
            . " where 1=1 $condition ORDER BY ind_req.id ASC $offlim ";
        

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
      function get_equipment_audit_amb($args = array(), $offset = '', $limit = '') {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.id='" . $args['req_id'] . "'";
        }
        if ((isset($args['ambulance_no'])) && $args['ambulance_no'] != "") {
            $condition .= " AND ind_req.ambulance_no='" . $args['ambulance_no'] . "'";
        }
        

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= " AND (ind_req.ambulance_no LIKE '%" . trim($args['search']) . "%' OR ind_req.base_location LIKE '%" . trim($args['search']) . "%' )";
        }

        $sql = "SELECT * "
            . "FROM $this->tbl_equipment_audit as ind_req "
            . " where ind_req.is_deleted  ='0'  $condition  ORDER BY ind_req.id DESC $offlim ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }



    ################# Tyre ###############

    function get_all_tyre_item_details($args = array(), $offset = '', $limit = '') {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.req_id='" . $args['req_id'] . "'";
        }
        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= " AND ind_req.req_type = '$req_type'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= " AND ind_req.req_group = '$req_grp'";
        }

        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= " AND ind_req.req_is_approve = '$req_grp'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= " AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= " AND (ind_req.req_amb_ref_no LIKE '%" . trim($args['search']) . "%' OR ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }

        $sql = "SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group,district.dst_name,amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk "
            . "FROM $this->tbl_tyre_req as ind_req "
            . "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON (  amb.amb_rto_register_no = ind_req.req_amb_reg_no ) "
             . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code ) "
            . " LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . " where ind_req.req_isdeleted ='0'  $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";


// echo $sql;
// die();

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }




    function get_all_tyre_item($args = array(), $offset = '', $limit = '') {


        $condition = '';

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= " AND ind_req.req_id='" . $args['req_id'] . "'";
        }
        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= " AND ind_req.req_type = '$req_type'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= " AND ind_req.req_group = '$req_grp'";
        }

        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= " AND ind_req.req_is_approve = '$req_grp'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= " AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= " AND ( ind_req.req_amb_reg_no LIKE '%" . trim($args['search']) . "%' OR ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%' OR  hp.hp_name LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }

        $sql = "SELECT ind_req.*,hp.hp_name,district.dst_name "
            . "FROM $this->tbl_tyre_req as ind_req "
            //. "LEFT JOIN $this->tbl_amb_stock AS amb_stk  ON (amb_stk.amb_rto_register_no = ind_req.req_amb_reg_no) "
            . " LEFT JOIN $this->tbl_ambulance as amb ON (  amb.amb_rto_register_no = ind_req.req_amb_reg_no ) "
             . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code ) "
            //. " LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . " where ind_req.req_isdeleted ='0'  $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";




// echo $sql;
// die();
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
}
