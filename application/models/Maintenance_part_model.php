<?php
class Maintenance_part_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

     
        $this->tbl_ind_req = $this->db->dbprefix('maintenance_part_request');
        $this->tbl_maintenance_part = $this->db->dbprefix('maintenance_part');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_state = $this->db->dbprefix('mas_states');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_maintenance_part_stock = $this->db->dbprefix('maintenance_part_stock');
        $this->tbl_maintenance_part_item = $this->db->dbprefix('maintenance_part_item');
        $this->tbl_maintenance_part_warehouse_stock = $this->db->dbprefix('maintenance_part_warehouse_stock');
        
    }
function get_all_maintenance_part($args = array(), $offset = '', $limit = '') {

        $condition = '';

        if ((isset($args['ref_id'])) && $args['ref_id'] != "") {
            $condition .= "AND ind_req.req_emt_id='" . $args['ref_id'] . "'";
        }

        if ((isset($args['req_id'])) && $args['req_id'] != "") {
            $condition .= "AND ind_req.req_id='" . $args['req_id'] . "'";
        }
        if ((isset($args['req_maintanance_id'])) && $args['req_maintanance_id'] != "") {
            $condition .= "AND ind_req.req_maintanance_id='" . $args['req_maintanance_id'] . "'";
        }


        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= "AND ind_req.req_type = '$req_type'";
        }

        if ($args['req_group'] != '' && $args['req_group'] != '') {
            $req_grp = $args['req_group'];
            $condition .= "AND ind_req.req_group = '$req_grp'";
        }
        if ($args['req_is_approve'] != '' && $args['req_is_approve'] != '') {
            $req_grp = $args['req_is_approve'];
            $condition .= "AND ind_req.req_is_approve = '$req_grp'";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND ind_req.req_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        

        if (isset($args['search1']) && $args['search1'] != '') {

            $condition .= "AND  ind_req.req_date LIKE '%" . trim($args['search1']) . "%'";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND ind_req.req_district_code IN ('" . $args['amb_district'] . "') ";
        }

        if (isset($args['search']) && $args['search'] != '') {

            $condition .= "AND (ind_req.req_date LIKE '%" . trim($args['search']) . "%'  OR ind_req.req_expected_date_time LIKE '%" . trim($args['search']) . "%' OR ind_req.req_rec_date LIKE '%" . trim($args['search']) . "%'  OR district.dst_name LIKE '%" . trim($args['search']) . "%' )";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT ind_req.*,district.dst_name "
            . "FROM ($this->tbl_ind_req as ind_req) "
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = ind_req.req_district_code )"
            . "where ind_req.req_isdeleted ='0'  $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";
       
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_maintenance_part_list($args = array(), $offset = '', $limit = ''){
         if ($args['inv_type']) {
            $condition .= " AND inv.mt_part_type LIKE '%" . $args['inv_type'] . "%' ";
        }

        
        if ($args['mt_maintanance_type']) {
            $condition .= " AND inv.mt_maintanance_type=" . $args['mt_maintanance_type'] . " ";
        }
        if ($args['make']) {
            $condition .= " AND inv.make='" . $args['make'] . "' ";
        }
        if ($args['mt_part_id']) {
            $condition .= " AND inv.mt_part_id=" . $args['mt_part_id'] . " ";
        }
        if ($args['term']) {
            $condition .= " AND (inv.mt_part_title LIKE '%" . $args['term'] . "%' OR inv.Item_Code LIKE '%" . $args['term'] . "%')";
        }
        if ($args['inv_item']) {
            $condition .= " AND (inv.mt_part_title LIKE '%" . $args['inv_item'] . "%' OR inv.Item_Code LIKE '%" . $args['inv_item'] . "%')";
        }
        if ($args['inv_ids']) {
           $condition .= " AND inv.mt_part_id not in(" . $args['inv_ids'] . ") ";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        
        $result = $this->db->query("SELECT inv.* FROM $this->tbl_maintenance_part as inv 
                  WHERE inv.mt_part_deleted ='0' AND  inv.mt_part_status ='1'  $condition
                  GROUP BY inv.mt_part_id $offlim");
   
       // echo $this->db->last_query();
      //  die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_maintenance_part($args = array()) {

        $res = $this->db->insert($this->tbl_ind_req, $args);
//        echo $this->db->last_query();
//        die();

        return $this->db->insert_id();
    }
    function maintenance_part_item($args = array()) {

        $res = $this->db->insert($this->tbl_maintenance_part_item, $args);
        //echo $this->db->last_query();
       // die();

        return $this->db->insert_id();
    }
    
    function get_item_maintenance_part_data($args = array()){

      
        $condition = '';

        if (isset($args['req_id'])) {
            $condition .= "AND ind.ind_req_id='" . $args['req_id'] . "'";
        }

        if (isset($args['req_group'])) {
            $condition .= "AND ind_req.req_group='" . $args['req_group'] . "'";
        }

        if (isset($args['ind_id'])) {
            $condition .= "AND ind.ind_id='" . $args['ind_id'] . "'";
        }


    $sql = "SELECT ind.*,inv.make,inv.mt_part_type,inv.mt_part_title as inv_title,inv.mt_part_id as inv_id,inv.Item_Code,ind_req.*"
            . "   FROM "
            . "$this->tbl_ind_req as ind_req"
            . " LEFT JOIN $this->tbl_maintenance_part_item as ind "
            . "ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_maintenance_part as inv"
            . " ON (inv.mt_part_id = ind.ind_item_id) "
            . "Where req_isdeleted = '0' $condition Group by ind.ind_id";




        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function update_maintenance_part_req($args = array()) {

        $this->db->where_in('req_id', $args['req_id']);

        $result = $this->db->update($this->tbl_ind_req, $args);
//        echo $this->db->last_query();
//        die();

        return $result;
    }
    
    function update_maintenance_part_item($args = array(), $data = array()) {

        $this->db->where_in('ind_id', $args['ind_id']);

        $result = $this->db->update($this->tbl_maintenance_part_item, $data);
      // echo $this->db->last_query();

        return $result;
    }
    
    function insert_maintenance_part_warehouse_stock($args = array()) {


        $this->db->insert($this->tbl_maintenance_part_warehouse_stock, $args);
//        echo $this->db->last_query();
//        die();

        return $this->db->insert_id();
    }
    function insert_maintenance_part_stock($args = array()) {


        $this->db->insert($this->tbl_maintenance_part_stock, $args);
//        echo $this->db->last_query();
//        die();

        return $this->db->insert_id();
    }
    function insert_maintenance_part_data($args = array()) {

        $res = $this->db->insert($this->tbl_maintenance_part , $args);

        return $this->db->insert_id();
    }
      function get_maintenance_part_details_stock($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';



        if ($args['inv_id']) {
            $condition.=" AND invmd.mt_part_id=" . $args['inv_id'] . " ";
        }





        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        
            //var_dump($args);
        if ($args['inv_district_id'] != '') {
            //var_dump($args);
            
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }
            if ($args['inv_to_date'] != '' ) {

                $inv_to_date = $args['inv_to_date'];
                $condition .= " AND amb_stk.as_date <= '$inv_to_date'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, invmd.*,amb_stk.* 

                                FROM $this->tbl_maintenance_part_stock AS amb_stk 

                                LEFT JOIN $this->tbl_maintenance_part AS invmd ON(invmd.mt_part_id=amb_stk.as_item_id)

                                WHERE  amb_stk.as_district_id='" . $args['inv_district_id'] . "'  $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type order by invmd.mt_part_title ASC $offlim  ");
            //echo $this->db->last_query();
            //die();
           
        }else if ($args['inv_amb'] != '') {
            //var_dump($args);
            
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }
            if ($args['inv_to_date'] != '' ) {

                $inv_to_date = $args['inv_to_date'];
                $condition .= " AND amb_stk.as_date <= '$inv_to_date'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, invmd.*,amb_stk.* 

                                FROM $this->tbl_maintenance_part_stock AS amb_stk 

                                LEFT JOIN $this->tbl_maintenance_part AS invmd ON(invmd.mt_part_id=amb_stk.as_item_id)

                                WHERE  amb_stk.as_amb_reg_no='" . $args['inv_amb'] . "'  $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type order by invmd.mt_part_title ASC $offlim  ");
            //echo $this->db->last_query();
           // die();
           
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['mt_part_ids']!='') {
                $condition.=" AND invmd.mt_part_id  not in(" . $args['mt_part_ids'] . ") ";
            }
            if ($args['inv_to_date'] != '' ) {

                $inv_to_date = $args['inv_to_date'];
                $condition .= " AND amb_stk.as_date <= '$inv_to_date'";
            }

            /////////////////////////////////////////////////////////////////////////////////////



            $result = $this->db->query("SELECT invmd.*,inv_stk3.*, 
            

            (SELECT SUM(inv_stk1.stk_qty) FROM $this->tbl_maintenance_part_warehouse_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = invmd.mt_part_id  AND inv_stk1.stk_in_out='in') AS in_stk, 

            (SELECT SUM(inv_stk2.stk_qty)  FROM ems_maintenance_part_warehouse_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = invmd.mt_part_id  AND inv_stk2.stk_in_out='out') AS out_stk 

            FROM $this->tbl_maintenance_part AS invmd LEFT JOIN ems_maintenance_part_warehouse_stock AS inv_stk3 ON(invmd.mt_part_id =inv_stk3.stk_inv_id) WHERE invmd.mt_part_deleted ='0' $condition GROUP BY invmd.mt_part_id  order by invmd.mt_part_title asc $offlim");
            // echo $this->db->last_query();
            //die();
           
        }

            return $result->result();
        
    }
    function get_breakdown_maintaince_part($args = array()){
        $condition = "";
        if ($args['as_sub_id']) {
            $condition.=" AND amb_stk.as_sub_id=" . $args['as_sub_id'] . " ";
        }
         if ($args['as_sub_type']) {
            $condition.=" AND amb_stk.as_sub_type='" . $args['as_sub_type'] . "' ";
        }
        if ($args['as_stk_in_out']) {
            $condition.=" AND amb_stk.as_stk_in_out='" . $args['as_stk_in_out'] . "' ";
        }
            $result = $this->db->query("SELECT amb_stk.as_item_id, invmd.*,amb_stk.* 

                                FROM $this->tbl_maintenance_part_stock AS amb_stk 

                                LEFT JOIN $this->tbl_maintenance_part AS invmd ON(invmd.mt_part_id=amb_stk.as_item_id)

                                WHERE 1=1  $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type order by invmd.mt_part_title ASC $offlim  ");
            
          return $result->result();

    }
    function get_maintenance_part_item($args = array()) {


        $condition = '';

        if (isset($args['req_id'])) {
            $condition .= "AND ind.ind_req_id='" . $args['req_id'] . "'";
        }

        if (isset($args['ind_id'])) {
            $condition .= "AND ind.ind_id='" . $args['ind_id'] . "'";
        }

        if (isset($args['ind_item_type'])) {
            $condition .= "AND ind.ind_item_type='" . $args['ind_item_type'] . "'";
        }

         $sql = "SELECT "
            
            . "ind.*,inv.mt_part_title  as inv_title,inv.mt_part_id  as inv_id,ind_req.*"
            . "   FROM "
            . "$this->tbl_ind_req as ind_req"
            . " LEFT JOIN $this->tbl_maintenance_part_item as ind "
            . "ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_maintenance_part as inv"
            . " ON (inv.mt_part_id = ind.ind_item_id) "
            . "Where req_isdeleted = '0' $condition ORDER By ind.ind_item_type";
        
       



        $result = $this->db->query($sql);




        if ($result) {
            return $result->result();
        } else {
            return false;
        }
        }
       function insert_stock($args = array()) {

            $this->db->insert($this->tbl_maintenance_part_warehouse_stock, $args);
            return $this->db->insert_id();
    }
    
}