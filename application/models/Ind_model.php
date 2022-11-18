<?php

class Ind_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_ind_item = $this->db->dbprefix('indent_item');

        $this->tbl_inv = $this->db->dbprefix('inventory');

        $this->tbl_inv_med = $this->db->dbprefix('inventory_medicine');

        $this->tbl_inv_equipment = $this->db->dbprefix('inventory_equipment');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_ind_req = $this->db->dbprefix('indent_request');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_colleague = $this->db->dbprefix('colleague');

        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');

        $this->tbl_inv_stock = $this->db->dbprefix('inventory_stock');

        $this->tbl_school = $this->db->dbprefix('school');
         $this->tbl_inveqp = $this->db->dbprefix('inventory_equipment');

         $this->tbl_tyre_item = $this->db->dbprefix('tyre_item');

         $this->tbl_tyre_req = $this->db->dbprefix('tyre_request');
         $this->tbl_tyre = $this->db->dbprefix('tyre');

         $this->tbl_tyr_stock = $this->db->dbprefix('tyre_stock');

         $this->tbl_amb_tyre_stock = $this->db->dbprefix('ambulance_tyre_stock');
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert indent request.
    // 
    /////////////////////////////////////////

    function insert_ind_req($args = array()) {

        $res = $this->db->insert($this->tbl_ind_req, $args);

        return $this->db->insert_id();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert indent request.
    // 
    /////////////////////////////////////////


    
    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert indent item.
    // 
    /////////////////////////////////////////

    function insert_ind($args = array()) {

        $res = $this->db->insert($this->tbl_ind_item, $args);
        //echo $this->db->last_query();
        //die();

        return $this->db->insert_id();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert ambulance stock.
    // 
    /////////////////////////////////////////

    function insert_amb_stock($args = array()) {
//
//        $res = $this->db->insert($this->tbl_amb_stock, $args);
//
//        return $this->db->insert_id();
        
        $this->db->select('*');
        $this->db->from($this->tbl_amb_stock);
        $this->db->where("as_item_id", $args['as_item_id']);
        $this->db->where("as_item_type", $args['as_item_type']);
        $this->db->where("as_sub_id", $args['as_sub_id']);

        $fetched = $this->db->get();
        // echo $this->db->last_query();die;
        $present = $fetched->num_rows();
        
        if($present == '0'){
        
            $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
            $args['as_id'] = $unique_id;

            $res = $this->db->insert($this->tbl_amb_stock, $args);    

            return $unique_id;
        
        
        }else{
            $this->db->where("as_item_id", $args['as_item_id']);
            $this->db->where("as_sub_id", $args['as_sub_id']);
            $this->db->where("as_item_type", $args['as_item_type']);
            $res = $this->db->update($this->tbl_amb_stock, $args);
            
         //echo $this->db->last_query();die;
            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
        
           $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
        $args['as_id'] = $unique_id;
            
        $res = $this->db->insert($this->tbl_amb_stock, $args);    
       
        return $unique_id;
    }

    ///////////////////MI44////////////////////
    //
    //Purpose : Indent list action view get data
    //
    ////////////////////////////////////////////

    function get_ind_data($args = array()) {


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

        if (isset($args['ind_item_type'])) {
            $condition .= "AND ind.ind_item_type='" . $args['ind_item_type'] . "'";
        }

         $sql = "SELECT "
            . "(SELECT SUM(inv_stk.stk_qty)  FROM $this->tbl_inv_stock as inv_stk where inv_stk.stk_inv_id = ind.ind_item_id AND inv_stk.stk_inv_type=ind.ind_item_type AND inv_stk.stk_in_out='in') as stk_total,"
            . "ind.*,inv.inv_title,inv.inv_id,inv_med.med_id,inv_med.med_title,inv_med.med_quantity,inv_med.med_quantity_unit,equipment.eqp_id,equipment.eqp_name,equipment.eqp_base_quantity,ind_req.*"
            . "   FROM "
            . "$this->tbl_ind_req as ind_req"
            . " LEFT JOIN $this->tbl_ind_item as ind "
            . "ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_inv as inv"
            . " ON (inv.inv_id = ind.ind_item_id) "
            . "LEFT JOIN $this->tbl_inv_med as inv_med  "
            . "ON (inv_med.med_id = ind.ind_item_id) "
            . "LEFT JOIN $this->tbl_inv_equipment as equipment  "
            . "ON (equipment.eqp_id = ind.ind_item_id) "
            . "Where req_isdeleted = '0' $condition ORDER By ind.ind_item_type";
        
        



        $result = $this->db->query($sql);




        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_indent_data($args = array()) {


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
        if (isset($args['amb_no'])) {
            $condition .= "AND ind_req.req_amb_reg_no='" . $args['amb_no'] . "'";
        }
        
        

        if (isset($args['ind_item_type'])) {
            $condition .= "AND ind.ind_item_type='" . $args['ind_item_type'] . "'";
        }


  $sql = "SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk,"
        
            . "(SELECT SUM(inv_stk.stk_qty)  FROM $this->tbl_inv_stock as inv_stk where inv_stk.stk_inv_id = ind.ind_item_id AND inv_stk.stk_inv_type=ind.ind_item_type AND inv_stk.stk_in_out='in') as stk_total,"
            ."(SELECT SUM(inv_stk.stk_qty) FROM ems_inventory_stock as inv_stk where inv_stk.stk_inv_id = ind.ind_item_id AND inv_stk.stk_inv_type=ind.ind_item_type AND inv_stk.stk_in_out='out' ) as stk_total_out,"
            . "ind.*,inv.inv_title,inv.inv_id,inv_med.med_id,inv_med.med_title,inv_med.med_quantity,inv_med.med_quantity_unit,equipment.eqp_id,equipment.eqp_name,equipment.eqp_base_quantity,ind_req.*"
            . "   FROM "
            . "$this->tbl_ind_req as ind_req"
            . " LEFT JOIN $this->tbl_ind_item as ind "
            . "ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_inv as inv"
            . " ON (inv.inv_id = ind.ind_item_id) "
            . "LEFT JOIN $this->tbl_inv_med as inv_med  "
            . "ON (inv_med.med_id = ind.ind_item_id) "
            . "LEFT JOIN $this->tbl_inv_equipment as equipment  "
            . "ON (equipment.eqp_id = ind.ind_item_id) "
            . "LEFT JOIN $this->tbl_amb_stock as amb_stk  "
            . "ON (amb_stk.as_item_id = ind.ind_item_id) "
            . "Where req_isdeleted = '0' AND ind.ind_item_type !='EQP' $condition Group by ind.ind_id";


//echo $sql;
//die();
        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_eqp_data($args = array()) {


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

        if (isset($args['ind_item_type'])) {
            $condition .= "AND ind.ind_item_type='" . $args['ind_item_type'] . "'";
        }


//   $sql = "SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk,"
        $sql = "SELECT"
            . "(SELECT SUM(inv_stk.stk_qty)  FROM $this->tbl_inv_stock as inv_stk where inv_stk.stk_inv_id = ind.ind_item_id AND inv_stk.stk_inv_type=ind.ind_item_type AND inv_stk.stk_in_out='in') as stk_total, SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, "
            . "ind.*,equipment.eqp_id,equipment.eqp_name,equipment.eqp_base_quantity,ind_req.*"
            . "   FROM "
            . "$this->tbl_ind_req as ind_req"
            . " LEFT JOIN $this->tbl_ind_item as ind "
            . "ON (ind.ind_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_inv_equipment as equipment  "
            . "ON (equipment.eqp_id = ind.ind_item_id) "
            . "LEFT JOIN $this->tbl_amb_stock as amb_stk  "
            . "ON (amb_stk.as_item_id = ind.ind_item_id) "
            . "Where req_isdeleted = '0' $condition Group by ind.ind_item_id";
        
        

        $result = $this->db->query($sql);


        // echo $this->db->last_query();die;

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_eqp_data_stock($args = array()) {


     
        $condition = $offlim = '';




        if ($args['inv_id']) {
            $condition.=" AND inveqp.eqp_id=" . $args['inv_id'] . " ";
        }

        if (trim($args['eqp_name']) != '') {
            $condition.=" AND inveqp.eqp_name like '%" . $args['eqp_name'] . "%' ";
        }
        
         if (trim($args['inv_type']) != '') {
           // $condition.=" AND inveqp.eqp_type = '" . $args['inv_type'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }
       
        if ($args['inv_amb'] != '') {
            
            if ($args['from_date'] != '' && $args['to_date']!= ''){   

                $from = $args['from_date'];
                $to = $args['to_date']; 
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";

            }

            $sql = "SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inveqp.*,amb_stk.*

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inveqp AS inveqp ON(inveqp.eqp_id=amb_stk.as_item_id AND amb_stk.as_item_type='EQP') 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' AND amb_stk.as_item_type='EQP' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type  ORDER BY inveqp.eqp_name ASC $offlim  ";
//            echo $this->db->last_query();
            
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['eqp_ids']) {
                $condition.=" AND inveqp.eqp_id not in(" . $args['eqp_ids'] . ") ";
            }

            
            /////////////////////////////////////////////////////////////////////////////////////

            $sql = "
            
            SELECT inveqp.*,
            

                        (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = inveqp.eqp_id AND inv_stk1.stk_inv_type='EQP'  AND inv_stk1.stk_in_out='in') AS in_stk,

                        (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = inveqp.eqp_id  AND inv_stk2.stk_inv_type='EQP'  AND inv_stk2.stk_in_out='out') AS out_stk 
            


            FROM $this->tbl_inveqp AS inveqp 
            
            WHERE inveqp.eqpis_deleted='0' $condition ORDER BY inveqp.eqp_name ASC $offlim";
           
        }
         $result = $this->db->query($sql);
        // var_dump($result->result());
        //echo $this->db->last_query();
        return $result->result();
        
    }
    //////////////MI44/////////////////////////////////
    //
    //Purpose : Indents list get data
    //
    ///////////////////////////////////////////////////

    function get_indent_item($args = array(), $offset = '', $limit = '') {

        $condition = '';

        if ((isset($args['ref_id'])) && $args['ref_id'] != "") {
            $condition .= "AND ind_req.req_emt_id='" . $args['ref_id'] . "'";
        }
        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= "AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= "AND ind_req.req_type = '$req_type'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }


        $sql = "SELECT ind_req.*,hp.hp_name,clg.clg_first_name,clg.clg_last_name,clg.clg_group "
            . "FROM ($this->tbl_ind_req as ind_req,$this->tbl_amb as amb) "
            . "LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) "
            . "LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . "where ind_req.req_isdeleted ='0' AND amb.amb_rto_register_no = ind_req.req_amb_reg_no $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";


        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_sick_indent_item($args = array(), $offset = '', $limit = '') {

        $condition = '';

        if ((isset($args['ref_id'])) && $args['ref_id'] != "") {
            $condition .= "AND ind_req.req_emt_id='" . $args['ref_id'] . "'";
        }
        if ((isset($args['cluster_id'])) && $args['cluster_id'] != "") {
            $cluster_id = $args['cluster_id'];
            $condition .= "AND clg.cluster_id IN ($cluster_id)";
        }
        if ((isset($args['req_type']))) {
            $req_type = $args['req_type'];
            $condition .= "AND ind_req.req_type = '$req_type'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT ind_req.*,sc.school_name as hp_name,sc.school_name as req_amb_reg_no,clg.clg_first_name,clg.clg_last_name,clg.clg_group "
            . "FROM ($this->tbl_ind_req as ind_req) "
            . "LEFT JOIN $this->tbl_school as sc ON (sc.school_id = ind_req.req_school_id) "
            . "LEFT JOIN $this->tbl_colleague as clg ON (clg.clg_ref_id = ind_req.req_emt_id) "
            . "where ind_req.req_isdeleted ='0' $condition Group By ind_req.req_id ORDER BY ind_req.req_date DESC $offlim ";


        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function update_ind_req($args = array()) {

        $this->db->where_in('req_id', $args['req_id']);

        $result = $this->db->update($this->tbl_ind_req, $args);
        //echo $this->db->last_query(); die();

        return $result;
    }

    function update_ind_item($args = array(), $data = array()) {

        $this->db->where_in('ind_id', $args['ind_id']);

        $result = $this->db->update($this->tbl_ind_item, $data);
      // echo $this->db->last_query();

        return $result;
    }

    function deletet_amb_stock($args = array()) {

        if($args['pcr_id'] != ''){
        $this->db->where('as_sub_id', $args['pcr_id']);
        
        $this->db->where('as_sub_type', $args['sub_type']);
        unset($args['pcr_id']);
         unset($args['sub_type']);
        //$this->db->delete($this->tbl_amb_stock);
         $result = $this->db->update($this->tbl_amb_stock, $args);
        }
    }

    function get_amb_stock($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_amb_stock");
        $this->db->where("$this->tbl_amb_stock.as_sub_id", $args['pcr_id']);
        $this->db->where("$this->tbl_amb_stock.as_sub_type", $args['sub_type']);
        $this->db->where("$this->tbl_amb_stock.as_item_type", $args['as_item_type']);
     
        //$this->db->order_by('name', 'ASC');
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }


############################  Tyre ######################


    function insert_tyre_req($args = array()) {

        $res = $this->db->insert($this->tbl_tyre_req, $args);

        return $this->db->insert_id();
    }

    function insert_tyre($args = array()) {

        $res = $this->db->insert($this->tbl_tyre_item, $args);
        //echo $this->db->last_query();
        //die();

        return $this->db->insert_id();
    }


    function get_tyr_data($args = array()) {


        $condition = '';

        if (isset($args['req_id'])) {
            $condition .= "AND ind.tyre_req_id='" . $args['req_id'] . "'";
        }

        if (isset($args['req_group'])) {
            $condition .= "AND ind_req.req_group='" . $args['req_group'] . "'";
        }

        if (isset($args['ind_id'])) {
            $condition .= "AND ind.tyre_id='" . $args['ind_id'] . "'";
        }

        if (isset($args['ind_item_type'])) {
            $condition .= "AND ind.tyre_item_type='" . $args['ind_item_type'] . "'";
        }


//   $sql = "SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk,"
        $sql = "SELECT"
            . "(SELECT SUM(inv_stk.tyre_qty)  FROM $this->tbl_tyr_stock as inv_stk where inv_stk.stk_tyre_id = ind.tyre_item_id  AND inv_stk.tyre_in_out='in') as stk_total, SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, "
            . "ind.*,equipment.tyre_id,equipment.tyre_title,equipment.tyre_base_quantity,ind_req.*"
            . "   FROM "
            . "$this->tbl_tyre_req as ind_req"
            . " LEFT JOIN $this->tbl_tyre_item as ind "
            . "ON (ind.tyre_req_id = ind_req.req_id) "
            . "LEFT JOIN $this->tbl_tyre as equipment  "
            . "ON (equipment.tyre_id = ind.tyre_item_id) "
            // . "LEFT JOIN $this->tbl_amb_stock as amb_stk  "
            . "LEFT JOIN $this->tbl_amb_tyre_stock as amb_stk  "
            . "ON (amb_stk.as_item_id = ind.tyre_item_id) "
            . "Where req_isdeleted = '0' $condition Group by ind.tyre_item_id";
        
        

        $result = $this->db->query($sql);


        // echo $this->db->last_query();die;

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }


    function update_tyre_req($args = array()) {

        $this->db->where_in('req_id', $args['req_id']);

        $result = $this->db->update($this->tbl_tyre_req, $args);
        //echo $this->db->last_query(); die();

        return $result;
    }


    function update_tyre_item($args = array(), $data = array()) {

        $this->db->where_in('tyre_id', $args['ind_id']);

        $result = $this->db->update($this->tbl_tyre_item, $data);
      // echo $this->db->last_query();

        return $result;
    }

            function insert_amb_tyre_stock($args = array()) {
                //
                //        $res = $this->db->insert($this->tbl_amb_stock, $args);
                //
                //        return $this->db->insert_id();
                        
                        $this->db->select('*');
                        $this->db->from($this->tbl_amb_tyre_stock);
                        $this->db->where("as_item_id", $args['as_item_id']);
                        // $this->db->where("as_item_type", $args['as_item_type']);
                        $this->db->where("as_sub_id", $args['as_sub_id']);
                
                        $fetched = $this->db->get();
                        // echo $this->db->last_query();die;
                        $present = $fetched->num_rows();
                        
                        if($present == '0'){
                        
                            $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
                            $args['as_id'] = $unique_id;
                
                            $res = $this->db->insert($this->tbl_amb_tyre_stock, $args);    
                
                            return $unique_id;
                        
                        
                        }else{
                            $this->db->where("as_item_id", $args['as_item_id']);
                            $this->db->where("as_sub_id", $args['as_sub_id']);
                            // $this->db->where("as_item_type", $args['as_item_type']);
                            $res = $this->db->update($this->tbl_amb_tyre_stock, $args);
                            
                         //echo $this->db->last_query();die;
                            if ($res) {
                                return $present[0]->id;
                            } else {
                                return false;
                            }
                        }
                        
                           $unique_id = get_uniqid( $this->session->userdata('user_default_key'));
                        $args['as_id'] = $unique_id;
                            
                        $res = $this->db->insert($this->tbl_amb_tyre_stock, $args);    
                       
                        return $unique_id;
                    }
}
