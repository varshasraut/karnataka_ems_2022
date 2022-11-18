<?php

class Inv_stock_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_inv = $this->db->dbprefix('inventory');

        $this->tbl_man = $this->db->dbprefix('manufacture');

        $this->tbl_mas_units = $this->db->dbprefix('mas_quantity_units');

        $this->tbl_inv_stock = $this->db->dbprefix('inventory_stock');

        $this->tbl_tyre_stock = $this->db->dbprefix('tyre_stock');
    }

    //// Created by MI42 ///////////////////////////
    // 
    // Purpose : To save inventory stock details.
    // 
    ///////////////////////////////////////////////
    function insert_tyre_stock($args = array()){
        // print_r($args);die;
        $this->db->insert($this->tbl_tyre_stock, $args);
        //echo $this->db->last_query();
        //die();

        return $this->db->insert_id();
    }
    function insert_stock($args = array()) {



//        $res = $this->db->query(" INSERT INTO $this->tbl_inv_stock(stk_inv_id,stk_inv_type,stk_in_out,stk_qty,stk_handled_by,stk_base_month,stk_date) 
//
//            VALUES('" . $args['stk_inv_id'] . "','" . $args['stk_inv_type'] . "','" . $args['stk_in_out'] . "','" . $args['stk_qty'] . "','" . $args['stk_handled_by'] . "','" . $args['stk_base_month'] . "','" . $args['stk_date'] . "')
//
//            ON DUPLICATE KEY UPDATE stk_inv_id = '" . $args['stk_inv_id'] . "',stk_in_out='" . $args['stk_in_out'] . "',stk_qty='" . $args['stk_qty'] . "',stk_handled_by='" . $args['stk_handled_by'] . "',stk_date='" . $args['stk_date'] . "',stk_base_month='" . $args['stk_base_month'] . "',stk_inv_type='" . $args['stk_inv_type'] . "'"
//        );
//
//
//        return $res;



        $this->db->insert($this->tbl_inv_stock, $args);
        //echo $this->db->last_query();
        //die();

        return $this->db->insert_id();
    }

    //// Created by MI42 /////////////////////////////
    // 
    // Purpose : To get inventory stock items list.
    // 
    //////////////////////////////////////////////////

    function get_stock_inv($args = array(), $offset = '', $limit = '') {



        $condition = $offlim = '';

        /////////////////////////////////////////////////////////////////////////////////////

        if ($args['stk_inv_ids']) {
            $condition.=" AND stk_inv.stk_inv_id not in(" . $args['stk_inv_ids'] . ") ";
        }

        /////////////////////////////////////////////////////////////////////////////////////

        if ($args['stk_inv_type']) {
            $condition.=" AND stk_inv.stk_inv_type='" . $args['stk_inv_type'] . "' ";
        }

        if ($args['stk_inv_id']) {
            $condition.=" AND stk_inv.stk_inv_id=" . $args['stk_inv_id'] . " ";
        }


        if (trim($args['inv_item']) != '') {
            $condition.=" AND inv.inv_title like '" . $args['inv_item'] . "%' ";
        }



        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }

        $result = $this->db->query("select stk_inv.*,inv.*,man.man_name,units.unt_title 
            from $this->tbl_inv_stock as stk_inv,$this->tbl_inv as inv  left join $this->tbl_man as man on (inv.inv_manufacture=man.man_id) 
            left join $this->tbl_mas_units as units on(inv.inv_unit=units.unt_id) 
            where stk_inv.stk_inv_id=inv.inv_id AND stk_inv.stk_isdeleted='0'
            inv.invis_deleted='0'  $condition $offlim "
        );




        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    //// Created by MI42 ///////////////////////////
    // 
    // Purpose : To save inventory stock details.
    // 
    ///////////////////////////////////////////////

    function update_stock($args = array(), $data = array()) {

        $this->db->where_in('stk_inv_id', $args['stk_inv_id'], 'stk_inv_type', $args['stk_inv_type']);

        $res = $this->db->update($this->tbl_inv_stock, $data);

        return $res;
    }

}
