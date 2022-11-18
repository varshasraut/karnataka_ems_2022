<?php

class Inv_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();
        $this->tbl_tyre = $this->db->dbprefix('tyre');
        $this->tbl_inv = $this->db->dbprefix('inventory');
        $this->tbl_invmd = $this->db->dbprefix('inventory_medicine');

        $this->tbl_man = $this->db->dbprefix('manufacture');

        $this->tbl_mas_units = $this->db->dbprefix('mas_quantity_units');

        $this->tbl_inv_stock = $this->db->dbprefix('inventory_stock');

        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');
        $this->tbl_inventory_medicine = $this->db->dbprefix('inventory_medicine');
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert inventory items.
    // 
    /////////////////////////////////////////

    function insert_inv($args = array()) {

        $this->db->insert($this->tbl_inv, $args);
        // echo $this->db->last_query();die();

        return $this->db->insert_id();

    }
    function insert_tyre($args = array()) {

        $this->db->insert($this->tbl_tyre, $args);
        // echo $this->db->last_query();die();

        return $this->db->insert_id();

    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To get inventory items list.
    // 
    /////////////////////////////////////////
    function get_tyre($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';

       

        if ($args['inv_id']) {
            $condition .= " AND tyre.tyre_id=" . $args['inv_id'] . " ";
        }



        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }




        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        if ($args['inv_amb'] != '') {

            if (trim($args['inv_type']) != '') {
                $condition .= " AND amb_stk.as_item_type='" . $args['inv_type'] . "'";
            }
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inv.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)
                                LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
             $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['inv_ids']) {
                $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
            }

            if ($args['start_date'] != '' && $args['end_date'] != '') {

                $from = $args['start_date'];
                $to = $args['end_date'];
                $condition .= " AND inv_stk3.stk_date BETWEEN '$from' AND '$to'";
            }

            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("SELECT tyre.tyre_id as tyre_id_new,tyre.*,inv_stk3.*,man.man_name,


                            (SELECT SUM(inv_stk1.tyre_qty)  FROM ems_tyre_stock AS inv_stk1 WHERE inv_stk1.stk_tyre_id = tyre.tyre_id AND inv_stk1.tyre_in_out='In') AS in_stk,
 
                             (SELECT SUM(inv_stk2.tyre_qty)  FROM ems_tyre_stock as inv_stk2 WHERE inv_stk2.stk_tyre_id = tyre.tyre_id  AND inv_stk2.tyre_in_out='Out') AS out_stk FROM ems_tyre as tyre 

                            LEFT JOIN $this->tbl_man AS man ON (tyre.tyre_manufacture=man.man_id) 

                            LEFT JOIN ems_tyre_stock AS inv_stk3 ON(tyre.tyre_id=inv_stk3.stk_tyre_id) 

                            WHERE 

                            tyre.tyreis_deleted='0'  $condition

                            GROUP BY tyre.tyre_id $offlim");
              $this->db->last_query();
            
        }
        //echo $this->db->last_query(); die();
        
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_inv($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }



        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }




        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        if ($args['inv_amb'] != '') {

            if (trim($args['inv_type']) != '') {
                $condition .= " AND amb_stk.as_item_type='" . $args['inv_type'] . "'";
            }
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inv.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)
                                LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
             $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['inv_ids']) {
                $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
            }

            if ($args['start_date'] != '' && $args['end_date'] != '') {

                $from = $args['start_date'];
                $to = $args['end_date'];
                $condition .= " AND inv_stk3.stk_date BETWEEN '$from' AND '$to'";
            }

            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("SELECT inv.*,inv_stk3.*,man.man_name,units.unt_title,


                            (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = inv.inv_id AND inv_stk1.stk_inv_type=inv.inv_type AND inv_stk1.stk_in_out='in') AS in_stk,
 
                             (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = inv.inv_id AND inv_stk2.stk_inv_type=inv.inv_type AND inv_stk2.stk_in_out='out') AS out_stk FROM $this->tbl_inv as inv 

                            LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                            LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                            LEFT JOIN $this->tbl_inv_stock AS inv_stk3 ON(inv.inv_id=inv_stk3.stk_inv_id) 

                            WHERE 

                            inv.invis_deleted='0'  $condition

                            GROUP BY inv.inv_id $offlim");
              $this->db->last_query();
            
        }
       // echo $this->db->last_query(); die();
        
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    function get_inv_details_stock($args = array(), $offset = '', $limit = '') {
        //var_dump($args);

        $condition = $offlim = '';

        if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }



        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }




        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        if ($args['inv_amb'] != '') {

            if (trim($args['inv_type']) != '') {
                $condition .= " AND amb_stk.as_item_type='" . $args['inv_type'] . "'";
            }
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }
            if ($args['inv_to_date'] != '' ) {

                $inv_to_date = $args['inv_to_date'];
                $condition .= " AND amb_stk.as_date <= '$inv_to_date'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inv.*,amb_stk.*

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
             $this->db->last_query();
             
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['inv_ids']) {
                $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
            }
             if ($args['inv_to_date'] != '' ) {

                $inv_to_date = $args['inv_to_date'];
                $inv_stk1 = " AND inv_stk1.stk_date  <= '$inv_to_date'";
                $inv_stk2 = " AND inv_stk2.stk_date  <= '$inv_to_date'";
            }

            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $inv_stk1 = " AND inv_stk1.stk_date BETWEEN '$from' AND '$to'";
                $inv_stk2 = " AND inv_stk2.stk_date BETWEEN '$from' AND '$to'";
            }

            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("SELECT inv.*,


                            (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = inv.inv_id AND inv_stk1.stk_inv_type=inv.inv_type AND inv_stk1.stk_in_out='in' $inv_stk1) AS in_stk,
 
                             (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = inv.inv_id AND inv_stk2.stk_inv_type=inv.inv_type AND inv_stk2.stk_in_out='out' $inv_stk2) AS out_stk FROM $this->tbl_inv as inv 
                            WHERE 

                            inv.invis_deleted='0'  $condition

                            GROUP BY inv.inv_id $offlim");
              $this->db->last_query();
            
        }
        //echo $this->db->last_query(); 
       // die();
        
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_medicine_name($args = array(), $offset = '', $limit = '') {
        
        if($args['as_item_id'] != ''){
            $condition.=" AND med.med_id=" . $args['as_item_id'] . " ";
        }
        $result = $this->db->query("SELECT * FROM ems_inventory_medicine AS med WHERE  1=1 $condition");
        
        return $result->result();
    }
    function get_consumable_name1($args = array(), $offset = '', $limit = '') {
        //var_dump($args);die();
        if($args['as_item_id'] != ''){
            $condition.=" AND inv.inv_id=" . $args['as_item_id'] . "  AND inv.inv_type ='CA' ";
        }
        $result = $this->db->query("SELECT * FROM $this->tbl_inv AS inv WHERE  1=1 $condition");
        
        return $result->result();
    }
    function get_non_consumable_name($args = array(), $offset = '', $limit = '') {
        if($args['as_item_id'] != ''){
            $condition.=" AND inv.inv_id=" . $args['as_item_id'] . "  AND inv.inv_type ='CA' ";
        }
      
        $result = $this->db->query("SELECT * FROM $this->tbl_inv AS inv WHERE  1=1 $condition");
    }
    function get_med_details_stock($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';



        if ($args['inv_id']) {
            $condition.=" AND invmd.med_id=" . $args['inv_id'] . " ";
        }

        if ($args['med_man']) {
            $condition.=" AND invmd.med_manufacture=" . $args['med_man'] . " ";
        }

        if (trim($args['med_name']) != '') {
            $condition.=" AND invmd.med_title like '%" . $args['med_name'] . "%' ";
        }



        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        
        
        if ($args['inv_amb'] != '') {
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

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_invmd AS invmd ON(invmd.med_id=amb_stk.as_item_id AND amb_stk.as_item_type='MED')

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' AND amb_stk.as_item_type='MED' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type order by invmd.med_title ASC $offlim  ");
            //echo $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['med_ids']!='') {
                $condition.=" AND invmd.med_id not in(" . $args['med_ids'] . ") ";
            }
            if ($args['inv_to_date'] != '' ) {

                $inv_to_date = $args['inv_to_date'];
                $condition .= " AND amb_stk.as_date <= '$inv_to_date'";
            }

            /////////////////////////////////////////////////////////////////////////////////////



            $result = $this->db->query("SELECT invmd.*,inv_stk3.*, 
            

            (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = invmd.med_id  AND inv_stk1.stk_inv_type='MED' AND inv_stk1.stk_in_out='in') AS in_stk, 

                             (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = invmd.med_id  AND inv_stk2.stk_inv_type='MED' AND  inv_stk2.stk_in_out='out') AS out_stk 

            FROM $this->tbl_invmd AS invmd LEFT JOIN $this->tbl_inv_stock AS inv_stk3 ON(invmd.med_id=inv_stk3.stk_inv_id) WHERE invmd.medis_deleted='0' $condition GROUP BY invmd.med_id  order by invmd.med_title asc $offlim");
           // echo $this->db->last_query();
           
        }


//echo $this->db->last_query();
  

            return $result->result();
        
    }
    function get_tyre_details_list($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';

      

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }



        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }




        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        if ($args['inv_amb'] != '') {

            if (trim($args['inv_type']) != '') {
                $condition .= " AND amb_stk.as_item_type='" . $args['inv_type'] . "'";
            }
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,inv.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)
                                LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
             $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['tyre_id']) {
                $condition .= " AND inv.tyre_id not in(" . $args['tyre_id'] . ") ";
            }

            if ($args['start_date'] != '' && $args['end_date'] != '') {

                $from = $args['start_date'];
                $to = $args['end_date'];
                $condition .= " AND inv_stk3.tyre_date BETWEEN '$from' AND '$to'";
            }

            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("SELECT tyre.tyre_id as tyre_id_new,tyre.*,inv_stk3.*,man.man_name FROM ems_tyre as tyre 

                            LEFT JOIN $this->tbl_man AS man ON (tyre.tyre_manufacture=man.man_id) 

                            LEFT JOIN ems_tyre_stock AS inv_stk3 ON(tyre.tyre_id=inv_stk3.stk_tyre_id) 

                            WHERE 

                            tyre.tyreis_deleted='0'  $condition

                            GROUP BY tyre.tyre_id $offlim");

            
        }
      // echo $this->db->last_query(); die();
       // var_dump($result);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
   
    
    function get_inv_details_list($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }



        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }




        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        if ($args['inv_amb'] != '') {

            if (trim($args['inv_type']) != '') {
                $condition .= " AND amb_stk.as_item_type='" . $args['inv_type'] . "'";
            }
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,inv.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)
                                LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
             $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['inv_ids']) {
                $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
            }

            if ($args['start_date'] != '' && $args['end_date'] != '') {

                $from = $args['start_date'];
                $to = $args['end_date'];
                $condition .= " AND inv_stk3.stk_date BETWEEN '$from' AND '$to'";
            }

            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("SELECT inv.*,inv_stk3.*,man.man_name,units.unt_title FROM $this->tbl_inv as inv 

                            LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                            LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                            LEFT JOIN $this->tbl_inv_stock AS inv_stk3 ON(inv.inv_id=inv_stk3.stk_inv_id) 

                            WHERE 

                            inv.invis_deleted='0'  $condition

                            GROUP BY inv.inv_id $offlim");

            
        }
       // echo $this->db->last_query(); die();
        
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_tyre_list(){
       /* if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }
        if ($args['inv_ids']) {
           $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
        }
        if ($args['inv_item'] != '') {
           $condition .= " AND inv.inv_title LIKE  '%" . $args['inv_item'] . "%' ";
        }
        */
        $result = $this->db->query("SELECT tyre.* FROM ems_tyre as tyre 
                  WHERE tyre.tyreis_deleted='0' AND  tyre.tyreis_status='1'  $condition
                  GROUP BY tyre.tyre_id $offlim");
        
      //  echo $this->db->last_query();
      //  die();
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inv_list($args = array()){
        
        if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }
        if ($args['inv_ids']) {
           $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
        }
        if ($args['inv_item'] != '') {
           $condition .= " AND inv.inv_title LIKE  '%" . $args['inv_item'] . "%' ";
        }
        
        $result = $this->db->query("SELECT inv.* FROM $this->tbl_inv as inv 
                  WHERE inv.invis_deleted='0' AND  inv.inv_status='1'  $condition
                  GROUP BY inv.inv_id $offlim");
        
      // echo $this->db->last_query();
      //  die();
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    
    
    function get_inv_active_item($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }



        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }




        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        if ($args['inv_amb'] != '') {

            if (trim($args['inv_type']) != '') {
                $condition .= " AND amb_stk.as_item_type='" . $args['inv_type'] . "'";
            }
            if ($args['from_date'] != '' && $args['to_date'] != '') {

                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
            }

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inv.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)
                                LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                                WHERE   inv.inv_status='1'  AND amb_stk.amb_rto_register_no='" . $args['inv_amb'] . "' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
            //echo $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['inv_ids']) {
                $condition .= " AND inv.inv_id not in(" . $args['inv_ids'] . ") ";
            }

            if ($args['start_date'] != '' && $args['end_date'] != '') {

                $from = $args['start_date'];
                $to = $args['end_date'];
                $condition .= " AND inv_stk3.stk_date BETWEEN '$from' AND '$to'";
            }

            /////////////////////////////////////////////////////////////////////////////////////

            $result = $this->db->query("SELECT inv.*,inv_stk3.*,man.man_name,units.unt_title,


                            (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = inv.inv_id AND inv_stk1.stk_inv_type=inv.inv_type AND inv_stk1.stk_in_out='in') AS in_stk,
 
                             (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = inv.inv_id AND inv_stk2.stk_inv_type=inv.inv_type AND inv_stk2.stk_in_out='out') AS out_stk FROM $this->tbl_inv as inv 

                            LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                            LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                            LEFT JOIN $this->tbl_inv_stock AS inv_stk3 ON(inv.inv_id=inv_stk3.stk_inv_id) 

                            WHERE 

                            inv.invis_deleted='0' AND  inv.inv_status='1'  $condition

                            GROUP BY inv.inv_id $offlim");
           // echo $this->db->last_query();
            
        }





        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    //// Created by MI42 ////////////////////
    // 
    // Purpose : To delete inventory items. 
    // 
    /////////////////////////////////////////

    function delete_tyre($tyre_id = '', $update = array()){
        $this->db->where_in('tyre_id', $tyre_id);

        $status = $this->db->update('ems_tyre', $update);

        return $status;
    }
    function delete_inv($inv_id = array(), $status = '') {

        $this->db->where_in('inv_id', $inv_id);

        $status = $this->db->update($this->tbl_inv, $status);

        return $status;
    }

    //// Created by MI42 ////////////////////////
    // 
    // Purpose : To update inventory item details. 
    // 
    /////////////////////////////////////////////
    function update_tyre($tyre_id = '', $tyre_details = array()){
        $this->db->where('tyre_id', $tyre_id);


        $update = $this->db->update('ems_tyre', $tyre_details);
       // echo $this->db->last_query();
       // die();
        if ($update) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function upadte_inv($inv_id = '', $inv_details = array()) {


        $this->db->where('inv_id', $inv_id);


        $update = $this->db->update($this->tbl_inv, $inv_details);

        if ($update) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //// Created by MI42 /////////////////////////////
    // 
    // Purpose : To get mas units for inventory items.
    // 
    //////////////////////////////////////////////////

    function get_units($args = array()) {

        if (!empty($args['inv_type'])) {
           // $condition = " AND unt_group REGEXP '[[:<:]]" . $args['inv_type'] . "[[:>:]]' ";
        }
         if (!empty($args['inv_type'])) {
            $condition = " AND unt_group LIKE '%" . $args['inv_type'] . "%' ";
        }
        $result = $this->db->query("select * from $this->tbl_mas_units where unt_status='1' AND untis_deleted='0' $condition");
    //    echo $this->db->last_query();
    //    die();
        return $result->result();
    }

    function get_inv_dashboard($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['inv_type']) {
            $condition .= " AND inv.inv_type='" . $args['inv_type'] . "' ";
        }

        if ($args['inv_id']) {
            $condition .= " AND inv.inv_id=" . $args['inv_id'] . " ";
        }

        if ($args['inv_man']) {
            $condition .= " AND inv.inv_manufacture=" . $args['inv_man'] . " ";
        }

        if (trim($args['inv_item']) != '') {
            $condition .= " AND inv.inv_title like '%" . $args['inv_item'] . "%' ";
        }


        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }



        // if (trim($args['inv_type']) != '') {
        $condition .= " AND amb_stk.as_item_type IN ('CA','NCA')";
        //  }
        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND amb_stk.as_date BETWEEN '$from' AND '$to'";
        }
        $req_type = $args['req_type'];

        $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, inv.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_inv AS inv ON(inv.inv_id=amb_stk.as_item_id AND amb_stk.as_item_type=inv.inv_type)
                                 LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=amb_stk.as_sub_id) 
                                LEFT JOIN $this->tbl_man AS man ON (inv.inv_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(inv.inv_unit=units.unt_id) 

                                WHERE ind_req.req_type='$req_type' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type $offlim  ");
        //  echo $this->db->last_query();




        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_dashboard_med_name($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_inventory_medicine");
        $this->db->where("$this->tbl_inventory_medicine.medis_deleted", '0');

        if ($args['med_type']) {
            $med_type = $args['med_type'];
            $this->db->where("$this->tbl_inventory_medicine.med_type", $med_type);
        }
        $this->db->order_by("med_title","asc");
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_emso_pilot($args = array()){
        $condition ='';
        if ($args['district_id'] != '') {

            $condition .= " AND clg.clg_district_id IN ('" . $args['district_id'] . "')  ";
       }

        $sql ="SELECT clg.clg_ref_id,clg.clg_group,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_mobile_no,clg.clg_is_deleted,clg.thirdparty,clg.clg_district_id,dist.dst_name   
        FROM `ems_colleague` AS clg 
        LEFT JOIN `ems_mas_districts` AS dist ON (clg.clg_district_id = dist.dst_code) 
        WHERE `clg_group` IN('UG-Pilot','UG-EMT') AND clg.clg_is_deleted='0' AND clg.thirdparty='1' $condition GROUP BY clg.clg_ref_id ";
            $result = $this->db->query($sql);
            // echo $this->db->last_query(); die;
            return $result->result();
    }
}
