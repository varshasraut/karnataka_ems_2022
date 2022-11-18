<?php

class Med_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_invmd = $this->db->dbprefix('inventory_medicine');

        $this->tbl_intervention = $this->db->dbprefix('mas_intervention');

        $this->tbl_man = $this->db->dbprefix('manufacture');

        $this->tbl_mas_units = $this->db->dbprefix('mas_quantity_units');
        
        $this->tbl_inv_stock = $this->db->dbprefix('inventory_stock');
        
        $this->tbl_amb_stock = $this->db->dbprefix('ambulance_stock');
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To insert medicines.
    // 
    /////////////////////////////////////////

    function insert_med($args = array()) {

        $this->db->insert($this->tbl_invmd, $args);

        return $this->db->insert_id();
    }
    
    
    function get_med_list($args = array()) {
                    
            if ($args['med_ids']!='') {
                $condition.=" AND invmd.med_id not in(" . $args['med_ids'] . ") ";
            }
            if ($args['med_id']!='') {
                $condition.=" AND invmd.med_id in ('" . $args['med_id'] . "') ";
            }
            if ($args['inv_id']!='') {
                $condition.=" AND invmd.med_id in(" . $args['inv_id'] . ") ";
            }
             if ($args['med_name'] !='' ) {
                $condition.=" AND invmd.med_title LIKE '%" . $args['med_name'] . "%' ";
            }

        
                    $result = $this->db->query("SELECT  invmd.* 

                                FROM $this->tbl_invmd AS invmd

                                WHERE 1=1 $condition order by invmd.med_title   ");
               
                    
                            if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_intervention_list($args = array()) {
                   
        $condition = '';
        if ($args['inj_id']!='') {
                     $condition.=" AND invmd.int_id in(" . $args['inj_id'] . ") ";
                 }
                  if ($args['inv_id']!='') {
                     $condition.=" AND invmd.int_id = " . $args['inv_id'] . " ";
                 }
     
             
                         $result = $this->db->query("SELECT  invmd.* 
     
                                     FROM $this->tbl_intervention AS invmd
     
                                     WHERE 1=1 $condition");
//                                     echo $this->db->last_query();
//                                     die();
                                 if ($args['get_count']) {
     
                 return $result->num_rows();
             } else {
     
                 return $result->result();
             }
         }

    //// Created by MI13 ///////////////////////
    // 
    // Purpose : To get inventory medicines list.
    // 
    ////////////////////////////////////////////

    function get_med_item($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';



        if ($args['med_id']) {
            $condition.=" AND invmd.med_id=" . $args['med_id'] . " ";
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


        
        
        if ($args['med_amb']!= '') {

            $result = $this->db->query("SELECT invmd.*,man.man_name,units.unt_title  from $this->tbl_invmd AS invmd 
                                LEFT JOIN $this->tbl_man AS man ON (invmd.med_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(invmd.med_quantity_unit=units.unt_id) 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['med_amb'] . "' $condition GROUP BY invmd.med_id order by invmd.med_title ASC $offlim  ");
         //   echo $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['med_ids']!='') {
                $condition.=" AND invmd.med_id not in(" . $args['med_ids'] . ") ";
            }

            /////////////////////////////////////////////////////////////////////////////////////



            $result = $this->db->query("SELECT invmd.*,man.man_name,units.unt_title  FROM $this->tbl_invmd AS invmd  LEFT JOIN $this->tbl_man AS man ON (invmd.med_manufacture=man.man_id) LEFT JOIN $this->tbl_mas_units AS units ON(invmd.med_quantity_unit=units.unt_id) WHERE invmd.medis_deleted='0' $condition GROUP BY invmd.med_id  order by invmd.med_title asc $offlim");
            //echo $this->db->last_query();
           
        }


        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    
    
        //// Created by MI13 ///////////////////////
    // 
    // Purpose : To get inventory medicines list.
    // 
    ////////////////////////////////////////////

    function get_med($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';



        if ($args['med_id']) {
            $condition.=" AND invmd.med_id=" . $args['med_id'] . " ";
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


        
        
        if ($args['med_amb']!= '') {

            $result = $this->db->query("SELECT amb_stk.as_item_id,SUM(IF(amb_stk.as_stk_in_out='in',amb_stk.as_item_qty,0)) as in_stk,SUM(IF(amb_stk.as_stk_in_out='out',amb_stk.as_item_qty,0)) as out_stk, invmd.*,amb_stk.*,man.man_name,units.unt_title 

                                FROM $this->tbl_amb_stock AS amb_stk 

                                LEFT JOIN $this->tbl_invmd AS invmd ON(invmd.med_id=amb_stk.as_item_id AND amb_stk.as_item_type='MED')
                                LEFT JOIN $this->tbl_man AS man ON (invmd.med_manufacture=man.man_id) 

                                LEFT JOIN $this->tbl_mas_units AS units ON(invmd.med_quantity_unit=units.unt_id) 

                                WHERE  amb_stk.amb_rto_register_no='" . $args['med_amb'] . "' AND amb_stk.as_item_type='MED' $condition GROUP BY amb_stk.as_item_id,amb_stk.as_item_type order by invmd.med_title ASC $offlim  ");
         //   echo $this->db->last_query();
        } else {


            /////////////////////////////////////////////////////////////////////////////////////

            if ($args['med_ids']!='') {
                $condition.=" AND invmd.med_id not in(" . $args['med_ids'] . ") ";
            }

            /////////////////////////////////////////////////////////////////////////////////////



            $result = $this->db->query("SELECT invmd.*,inv_stk3.*,man.man_name,units.unt_title, 
            

            (SELECT SUM(inv_stk1.stk_qty)  FROM $this->tbl_inv_stock AS inv_stk1 WHERE inv_stk1.stk_inv_id = invmd.med_id  AND inv_stk1.stk_inv_type='MED' AND inv_stk1.stk_in_out='in') AS in_stk, 

                             (SELECT SUM(inv_stk2.stk_qty)  FROM $this->tbl_inv_stock as inv_stk2 WHERE inv_stk2.stk_inv_id = invmd.med_id  AND inv_stk2.stk_inv_type='MED' AND  inv_stk2.stk_in_out='out') AS out_stk 

            FROM $this->tbl_invmd AS invmd  LEFT JOIN $this->tbl_man AS man ON (invmd.med_manufacture=man.man_id) LEFT JOIN $this->tbl_mas_units AS units ON(invmd.med_quantity_unit=units.unt_id) LEFT JOIN $this->tbl_inv_stock AS inv_stk3 ON(invmd.med_id=inv_stk3.stk_inv_id) WHERE invmd.medis_deleted='0' $condition GROUP BY invmd.med_id  order by invmd.med_title asc $offlim");
           // echo $this->db->last_query();
           
        }


        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    //// Created by MI42 ///////////////////////
    // 
    // Purpose : To delete inventory medicines.
    // 
    ////////////////////////////////////////////


    function delete_med($med_id = array(), $status = '') {

        $this->db->where_in('med_id', $med_id);

        $status = $this->db->update($this->tbl_invmd, $status);

        return $status;
    }

    //// Created by MI42 /////////////////////////////
    // 
    // Purpose : To update inventory medicines details. 
    // 
    /////////////////////////////////////////////////


    function upadte_med($med_id = '', $med_details = array()) {


        $this->db->where('med_id', $med_id);


        $update = $this->db->update($this->tbl_invmd, $med_details);

        if ($update) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function get_med_out_stock($args){
        if ($args['med_id']) {
            $condition.=" AND as_item_id=" . $args['med_id'] . " ";
        }
        if ($args['type']) {
            $condition.=" AND as_item_type='" . $args['type'] . "' ";
        }
        $req_type =  $args['req_type'];
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as out_stk FROM `ems_ambulance_stock` LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id) WHERE ind_req.req_type='$req_type' AND as_stk_in_out='out' $condition");
//echo $this->db->last_query();
        $result =  $result->result();
        return $result[0];  
    }
     function get_med_in_stock($args){
        if ($args['med_id']) {
            $condition.=" AND as_item_id=" . $args['med_id'] . " ";
        }
        if ($args['type']) {
            $condition.=" AND as_item_type='" . $args['type'] . "' ";
        }
        $req_type =  $args['req_type'];
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as in_stk FROM `ems_ambulance_stock` LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id) WHERE ind_req.req_type='$req_type' AND  as_stk_in_out='in' $condition");
         // echo $this->db->last_query();

        $result =  $result->result();
        return $result[0];  
    }

    function get_med_out_in_stock($args){
        if ($args['med_id']) {
            $condition.=" AND stk_inv_id=" . $args['med_id'] . " ";
        }
        if ($args['type']) {
            $condition.=" AND stk_inv_type=" . $args['type'] . " ";
        }
         $req_type =  $args['req_type'];
       
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as in_stk FROM `ems_inventory_stock` LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id) WHERE ind_req.req_type='$req_type' AND  stk_in_out='in' $condition");
         // echo $this->db->last_query();

        $result =  $result->result();
        return $result[0];  
    }
    
    function get_med_out_stock_cluster($args){
        
        $req_type =  $args['req_type'];
        if ($args['med_id']) {
            $condition.=" AND as_item_id=" . $args['med_id'] . " ";
        }
        
        if ($args['type']) {
            $condition.=" AND as_item_type='" . $args['type'] . "' ";
        }
        if ($args['cluster_id']) {
            $condition.=" AND cluster_id IN (" . $args['cluster_id'] . ") ";
        }
        
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as out_stk FROM ems_ambulance_stock  LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id)  LEFT JOIN ems_ambulance ON (ems_ambulance_stock.amb_rto_register_no = ems_ambulance.amb_rto_register_no)  WHERE ind_req.req_type='$req_type' AND as_stk_in_out='out' $condition" ); 
       // echo $this->db->last_query(); die();


        $result =  $result->result();
        return $result[0];  
    }
    function get_med_in_stock_cluster($args){
         $req_type =  $args['req_type'];
         
        if ($args['med_id']) {
            $condition.=" AND as_item_id=" . $args['med_id'] . " ";
        }
        
        if ($args['type']) {
            $condition.=" AND as_item_type='" . $args['type'] . "' ";
        }
        if ($args['cluster_id']) {
            $condition.=" AND cluster_id IN (" . $args['cluster_id'] . ") ";
        }
        
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as in_stk FROM ems_ambulance_stock  LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id) LEFT JOIN ems_ambulance ON (ems_ambulance_stock.amb_rto_register_no = ems_ambulance.amb_rto_register_no)  WHERE ind_req.req_type='$req_type' AND as_stk_in_out='in' $condition" );

        $result =  $result->result();
        return $result[0];  
    }
    
    function get_med_sick_out_stock_cluster($args){
        
        $req_type =  $args['req_type'];
        if ($args['med_id']) {
            $condition.=" AND as_item_id=" . $args['med_id'] . " ";
        }
        
        if ($args['type']) {
            $condition.=" AND as_item_type='" . $args['type'] . "' ";
        }
        if ($args['cluster_id']) {
            $condition.=" AND cluster_id IN (" . $args['cluster_id'] . ") ";
        }
        
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as out_stk FROM ems_ambulance_stock  LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id)  LEFT JOIN ems_school ON (ems_ambulance_stock.amb_rto_register_no = ems_school.school_id)  WHERE ind_req.req_type='$req_type' AND as_stk_in_out='out' $condition" );
        //echo $this->db->last_query();
        //die();

        $result =  $result->result();
        return $result[0];  
    }
    function get_med_sick_in_stock_cluster($args){
         $req_type =  $args['req_type'];
         
        if ($args['med_id']) {
            $condition.=" AND as_item_id=" . $args['med_id'] . " ";
        }
        
        if ($args['type']) {
            $condition.=" AND as_item_type='" . $args['type'] . "' ";
        }
        if ($args['cluster_id']) {
            $condition.=" AND cluster_id IN (" . $args['cluster_id'] . ") ";
        }
        
        $result = $this->db->query("SELECT SUM(ems_ambulance_stock.as_item_qty) as in_stk FROM ems_ambulance_stock  LEFT JOIN ems_indent_request AS ind_req ON(ind_req.req_id=ems_ambulance_stock.as_sub_id) LEFT JOIN ems_school ON (ems_ambulance_stock.amb_rto_register_no = ems_school.school_id)  WHERE ind_req.req_type='$req_type' AND as_stk_in_out='in' $condition" );

        $result =  $result->result();
        return $result[0];  
    }

}
