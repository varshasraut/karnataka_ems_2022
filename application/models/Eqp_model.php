<?php

class Eqp_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_inveqp = $this->db->dbprefix('inventory_equipment');
        $this->tbl_inveqp_type = $this->db->dbprefix('inventory_type');

        $this->tbl_inv_stock = $this->db->dbprefix('inventory_stock');

        $this->tbl_tyr_stock = $this->db->dbprefix('tyre_stock');

        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_tyre = $this->db->dbprefix('tyre');
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert equipment.
    // 
    /////////////////////////////////////////

    function insert_eqp($args = array()) {

        $this->db->insert($this->tbl_inveqp, $args);

        return $this->db->insert_id();
    }
    
    function get_eqp_type($args = array()) {
        
        if (trim($args['eqp_type']) != '') {
            $condition .= " AND inveqp_tp.eqp_type = '" . $args['eqp_type'] . "' ";
        }

        $result = $this->db->query("SELECT inveqp_tp.*

                            FROM $this->tbl_inveqp_type AS inveqp_tp

                            WHERE inveqp_tp.is_deleted='0' $condition  ORDER BY inveqp_tp.id ");
        
     

        if ($args['get_count']) {
            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_eqp_break_type($args = array()) {
        
        if (trim($args['eqp_type']) != '') {
            $condition .= " AND inveqp_tp.eb_equipement_id = '" . $args['eqp_type'] . "' ";
        }
         if ($args['eqp_type_id'] != '') {
            $condition .= " AND inveqp_tp.eb_equipement_id IN ('" . $args['eqp_type_id'] . "') ";
        }
        if (trim($args['term']) != '') {
            $condition .= " AND inveqp_tp.eb_name = '" . $args['term'] . "' ";
        }
        
        if (trim($args['eb_type_id']) != '') {
            $condition .= " AND inveqp_tp.eb_type_id = '" . $args['eb_type_id'] . "' ";
        }
        $result = $this->db->query("SELECT inveqp_tp.*

                            FROM ems_eqp_breakdown_type AS inveqp_tp

                            WHERE inveqp_tp.eb_is_deleted='0' $condition  ORDER BY inveqp_tp.eb_type_id ");
        
       
        if ($args['get_count']) {
            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To get inventory equipment list.
    // 
    ////////////////////////////////////////////

    function get_eqp($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';



        if ($args['eqp_id']) {
            $condition.=" AND inveqp.eqp_id=" . $args['eqp_id'] . " ";
        }

        if (trim($args['eqp_name']) != '') {
            $condition.=" AND inveqp.eqp_name like '%" . $args['eqp_name'] . "%' ";
        }
        
         if (trim($args['eqp_type']) != '') {
            $condition.=" AND inveqp.eqp_type = '" . $args['eqp_type'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }
       
        if ($args['eqp_amb'] != '') {
            
            if ($args['from_date'] != '' && $args['to_date']!= ''){   

                $from = $args['from_date'];
                $to = $args['to_date']; 
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";

            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inveqp.*,amb_stk.*

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inveqp AS inveqp ON(inveqp.eqp_id=amb_stk.as_item_id AND amb_stk.as_item_type='EQP') 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['eqp_amb'] . "' AND amb_stk.as_item_type='EQP' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type  ORDER BY inveqp.eqp_name ASC $offlim  ");
           // echo $this->db->last_query();
            
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['eqp_ids']) {
                $condition.=" AND inveqp.eqp_id not in(" . $args['eqp_ids'] . ") ";
            }

            
            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("
            
            SELECT inveqp.*,
            

                        (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = inveqp.eqp_id AND inv_stk1.stk_inv_type='EQP'  AND inv_stk1.stk_in_out='in') AS in_stk,

                        (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = inveqp.eqp_id  AND inv_stk2.stk_inv_type='EQP'  AND inv_stk2.stk_in_out='out') AS out_stk 
            


            FROM $this->tbl_inveqp AS inveqp 
            
            WHERE inveqp.eqpis_deleted='0' $condition ORDER BY inveqp.eqp_name ASC $offlim");
       
        }

//die();
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To delete inventory equipment.
    // 
    ////////////////////////////////////////////


    function delete_eqp($eqp_id = array(), $status = '') {

        $this->db->where_in('eqp_id', $eqp_id);

        $status = $this->db->update($this->tbl_inveqp, $status);

        return $status;
    }

    //// Created by MI42 /////////////////////////////
    // 
    // Purpose : To update inventory equipment details. 
    // 
    /////////////////////////////////////////////////


    function upadte_eqp($eqp_id = '', $eqp_details = array()) {


        $this->db->where('eqp_id', $eqp_id);


        $update = $this->db->update($this->tbl_inveqp, $eqp_details);

        if ($update) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
 function get_eqp_dash($args = array(), $offset = '', $limit = '') {
        
        $req_type =  $args['req_type'];
        $eqp_type =  $args['eqp_type'];

        $result = $this->db->query("SELECT inveqp.*

                            FROM $this->tbl_inveqp AS inveqp

                            WHERE inveqp.eqp_type='$eqp_type'
             ORDER BY inveqp.eqp_id ");

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_inv_type(){
        $query = $this->db->query("SELECT * FROM `ems_inventory_type` WHERE is_deleted='0'");
        // echo $this->db->last_query();
        // die();
    return $query->result();
    }



    
    function get_tyre($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';



        if ($args['rqp_id']) {
            $condition.=" AND inveqp.tyre_id=" . $args['eqp_id'] . " ";
        }

        if (trim($args['eqp_name']) != '') {
            $condition.=" AND inveqp.tyre_title like '%" . $args['eqp_name'] . "%' ";
        }
        
         if (trim($args['eqp_type']) != '') {
            $condition.=" AND inveqp.tyre_type = '" . $args['eqp_type'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }
       
        if ($args['eqp_amb'] != '') {
            
            if ($args['from_date'] != '' && $args['to_date']!= ''){   

                $from = $args['from_date'];
                $to = $args['to_date']; 
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";

            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inveqp.*,amb_stk.*

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN ems_tyre AS inveqp ON(inveqp.tyre_id=amb_stk.as_item_id AND amb_stk.as_item_type='EQP') 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['eqp_amb'] . "' AND amb_stk.as_item_type='EQP' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type  ORDER BY inveqp.tyre_title ASC $offlim  ");
            
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['eqp_ids']) {
                $condition.=" AND inveqp.tyre_id not in(" . $args['eqp_ids'] . ") ";
            }

            
            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("
            
            SELECT inveqp.*,
            

                        (SELECT SUM(inv_stk1.tyre_qty)  FROM $this->tbl_tyr_stock AS inv_stk1 WHERE inv_stk1.stk_tyre_id = inveqp.tyre_id   AND inv_stk1.tyre_in_out='in') AS in_stk,

                        (SELECT SUM(inv_stk2.tyre_qty)  FROM $this->tbl_tyr_stock as inv_stk2 WHERE inv_stk2.stk_tyre_id = inveqp.tyre_id    AND inv_stk2.tyre_in_out='out') AS out_stk 
            


            FROM $this->tbl_tyre AS inveqp 
            
            WHERE inveqp.tyreis_deleted='0' $condition ORDER BY inveqp.tyre_title ASC $offlim");
       
        }
         
    //    echo  $this->db->last_query();die();
               if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

}
