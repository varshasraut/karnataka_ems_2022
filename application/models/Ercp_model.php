<?php

class Ercp_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_pt = $this->db->dbprefix('patient');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_inc_pt = $this->db->dbprefix('incidence_patient');

        $this->tbl_opby = $this->db->dbprefix('operateby');

        $this->tbl_inc_adv = $this->db->dbprefix('incidence_advice');

        $this->tbl_amb_type = $this->db->dbprefix('mas_ambulance_type');

        $this->tbl_dist = $this->db->dbprefix('mas_districts');

        $this->tbl_clg = $this->db->dbprefix('colleague');
        
        $this->tbl_ercp_cldtl = $this->db->dbprefix('ercp_call_details');
    }

    //////////////////MI42/////////////////////////////
    //Purpose : Get ERCP for advice.
    //  
    //////////////////////////////////////////////////

    function add($args = array()) {

        $res = $this->db->insert($this->tbl_ercp_cldtl, $args);

        return $res;
    }

    //////////////////MI42/////////////////////////////
    //Purpose : Get ERCP for advice.
    //  
    //////////////////////////////////////////////////



    function get_ercp($args = array()) {

        $sql = "SELECT opby.operator_id,opby.sub_id "
            . "FROM $this->tbl_opby as opby,$this->tbl_clg as clg1 LEFT JOIN "
            . "$this->tbl_clg as clg2 ON (clg1.clg_senior=clg2.clg_ref_id) LEFT JOIN "
            . "$this->tbl_clg as clg3 ON (clg2.clg_senior=clg3.clg_senior  AND clg3.clg_group='" . $args['clg_group'] . "') "
            . "where opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
            . "clg3.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.sub_type='" . $args['sub_type'] . "' AND opby.sub_status='ATNG'";



        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To get call details.
    // 
    /////////////////////////////////////////

    function call_detials($args = array()) {


        $result = $this->db->query("SELECT  inc.inc_ref_id,amb.amb_rto_register_no,amb.amb_default_mobile,opby.operator_id,hp.hp_name,amb_type.ambt_name,amb.amb_default_mobile,ptn.ptn_fname,ptn.ptn_lname,inc.inc_address,dist.dst_name
  
                FROM ($this->tbl_inc as inc,$this->tbl_inc_pt as incptn, $this->tbl_pt as ptn,$this->tbl_inc_amb as inc_amb,$this->tbl_amb as amb,$this->tbl_opby as opby,$this->tbl_inc_adv inc_adv) 
                   
                LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id  

                LEFT JOIN $this->tbl_amb_type as amb_type ON amb.amb_type=amb_type.ambt_id

                LEFT JOIN $this->tbl_dist as dist ON amb.amb_district=dist.dst_code
                   
                   
                   
                 WHERE inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")
                    
                    AND opby.sub_id=inc_adv.adv_id 
					AND inc_adv.adv_inc_ref_id=inc.inc_ref_id
                    AND incptn.inc_id = inc.inc_ref_id AND incptn.ptn_id = ptn.ptn_id
					AND inc.inc_ref_id = inc_amb.inc_ref_id
					AND TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no)
                    AND inc.incis_deleted='0'  AND opby.operator_id='" . $args['opt_id'] . "' ORDER BY inc.inc_id ASC");


        return $result->result();
    }
    
   


}
