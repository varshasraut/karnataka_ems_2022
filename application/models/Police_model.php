<?php

class Police_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->tbl_inc = $this->db->dbprefix('incidence');

        $this->tbl_cls = $this->db->dbprefix('calls');

        $this->tbl_clrs = $this->db->dbprefix('callers');

        $this->tbl_pt = $this->db->dbprefix('patient');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_inc_amb = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_inc_pt = $this->db->dbprefix('incidence_patient');

        $this->tbl_opby = $this->db->dbprefix('operateby');

        $this->tbl_inc_adv = $this->db->dbprefix('incidence_advice');

        $this->tbl_inc_add_adv = $this->db->dbprefix('inc_add_advice');

        $this->tbl_amb_type = $this->db->dbprefix('mas_ambulance_type');

        $this->tbl_dist = $this->db->dbprefix('mas_districts');

        $this->tbl_clg = $this->db->dbprefix('colleague');

        $this->tbl_mas_default_ans = $this->db->dbprefix('mas_default_ans');

        $this->tbl_que = $this->db->dbprefix('mas_questionnaire');

        $this->tbl_pptype = $this->db->dbprefix('mas_pupils_type');

        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');
        $this->tbl_cgs_score = $this->db->dbprefix('mas_cgs_score');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_mas_police_cheif_comp = $this->db->dbprefix('mas_police_cheif_comp');
        $this->tbl_police_station_calls_details = $this->db->dbprefix('police_station_calls_details');
        $this->tbl_police_station = $this->db->dbprefix('police_station');
        $this->tbl_police_station_manual_calls = $this->db->dbprefix('police_station_manual_calls');
        $this->tbl_mas_police_help_comp = $this->db->dbprefix('mas_police_help_comp');
    }
    function get_all_calls($args=array()) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND pcall.pc_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND pcall.pc_added_by='" . $args['operator_id'] . "' ";
        }

        
         $sql = "SELECT pcall.pc_inc_ref_id"
            . " FROM $this->tbl_police_station_calls_details AS pcall"
            . " WHERE 1=1 $condition group by pc_inc_ref_id";

      
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_all_calls_assign($args=array()) {
        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND pcall.pc_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND pcall.pc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT pcall.pc_inc_ref_id"
            . " FROM $this->tbl_police_station_calls_details AS pcall"
            . " WHERE pc_assign_call='assign' $condition group by pc_inc_ref_id";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_inc_by_manual_police_call($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND police_call.pc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }

        if ($args['pc_inc_ref_id']) {
            $condition .= " AND police_call.pc_inc_ref_id='" . $args['pc_inc_ref_id'] . "' ";
        }
        
        if ($args['child_pda']) {
            $condition .= " AND police_call.pc_added_by IN ('" . $args['child_pda'] . "') ";
        }


        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND ( clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND police_call.pc_district_code IN ('" . $args['amb_district'] . "') ";
        }


        $sql = "SELECT * ,pdare.remarks as pda_remark"
            . " FROM $this->tbl_police_station_calls_details AS police_call "
            . " LEFT JOIN $this->tbl_police_station AS police ON ( police.p_id = police_call.pc_police_station_id )"
            . " LEFT JOIN $this->tbl_mas_police_cheif_comp AS chief ON ( chief.po_ct_id = police_call.pc_police_chief_complaint )"
            . " LEFT JOIN $this->tbl_mas_police_help_comp AS help_comp ON ( help_comp.po_hp_id = police_call.pc_police_help_complaint )"
            . " LEFT JOIN  $this->tbl_police_station_manual_calls AS police_manual ON ( police_manual.mc_inc_ref_id = police_call.pc_inc_ref_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = police_manual.mc_caller_id )"
            . " LEFT JOIN ems_pda_remarks AS pdare ON (pdare.id = police_call.pc_standard_remark )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = police_call.pc_district_code )"
            . " WHERE  police_manual.mc_is_deleted = '0'  $condition $search  GROUP BY police_call.pc_inc_ref_id order by police_call.pc_added_date DESC $offlim";
    // echo $sql;die();


        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function add_police($args = array()) {

        $res = $this->db->insert($this->tbl_police_station_calls_details, $args);
//        echo $this->db->last_query();
//        die();

        return $res;
    }

    function update_police($new_data = array()) {

        if ($new_data['pc_id'] != '') {
            $this->db->where_in('pc_id', $new_data['pc_id']);
        }
        if ($new_data['pc_inc_ref_id'] != '') {
            $this->db->where_in('pc_inc_ref_id', $new_data['pc_inc_ref_id']);
        }


        $data = $this->db->update($this->tbl_police_station_calls_details, $new_data);

        return $data;
    }

    function add_police_manual_call($args = array()) {

        $res = $this->db->insert($this->tbl_police_station_manual_calls, $args);
       

        return $res;
    }

    function get_inc_by_police($args = array(), $offset = '', $limit = '') {


 

        $condition = $offlim = '';

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND police_call.pc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
        
        if ($args['pda_operator_id']) {
            $condition .= " AND police_call.pc_added_by='" . $args['pda_operator_id'] . "' ";
        }
        

        if ($args['pc_inc_ref_id']) {
            $condition .= " AND police_call.pc_inc_ref_id='" . $args['pc_inc_ref_id'] . "' ";
        }
        if ($args['inc_ref_id']) {
            $condition .= " AND police_call.pc_pre_inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['district_code']) {
            $condition .= " AND police_call.pc_district_code='" . $args['district_code'] . "' ";
        }
        if ($args['child_pda']) {
            $condition .= " AND police_call.pc_added_by IN ('" . $args['child_pda'] . "') ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
            
        }


          $sql = "SELECT * ,pdare.remarks as pda_remark"
            . " FROM $this->tbl_police_station_calls_details AS police_call "
            . " LEFT JOIN $this->tbl_police_station AS police ON ( police.p_id = police_call.pc_police_station_id )"
            . " LEFT JOIN $this->tbl_mas_police_cheif_comp AS chief ON ( chief.po_ct_id = police_call.pc_police_chief_complaint )"
            . " LEFT JOIN $this->tbl_incidence AS inc ON ( police_call.pc_pre_inc_ref_id = inc.inc_ref_id AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND inc.incis_deleted = '0'  AND inc.inc_set_amb = '1' )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_pda_remarks AS pdare ON (pdare.id = police_call.pc_standard_remark )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = police_call.pc_district_code )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " WHERE (1=1 $condition) $search  GROUP BY police_call.pc_inc_ref_id ORDER BY police_call.pc_added_date DESC $offlim";
 

      

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_ercp($args = array()) {

        $sql = "SELECT opby.operator_id,opby.sub_id "
            . "FROM $this->tbl_opby as opby,$this->tbl_clg as clg1 LEFT JOIN "
            . "$this->tbl_clg as clg2 ON (clg1.clg_senior=clg2.clg_ref_id) LEFT JOIN "
            . "$this->tbl_clg as clg3 ON (clg2.clg_senior=clg3.clg_senior  AND clg3.clg_group='" . $args['clg_group'] . "') "
            . "where opby.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND "
            . "clg1.clg_ref_id=opby.operator_id AND "
            . "clg3.clg_ref_id='" . $args['clg_ref_id'] . "' AND "
            . "opby.sub_type='" . $args['sub_type'] . "' AND opby.sub_status='ATNG'  ";



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

        $condition = "";

        if ($args['opt_id']) {

            $condition .= " AND opby.operator_id='" . $args['opt_id'] . "' ";
        }

        if ($args['sub_id']) {

            $condition .= " AND opby.sub_id='" . $args['sub_id'] . "' ";
        }
//         if ($args['inc_ref_id']) {
//
//            $condition.=" AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
//        }

        $result = $this->db->query("SELECT  inc_adv.adv_inc_ref_id,inc_adv.adv_id,amb.amb_rto_register_no,amb.amb_default_mobile,opby.operator_id,opby.sub_id,hp.hp_name,amb_type.ambt_name,amb.amb_default_mobile,ptn.ptn_fname,ptn.ptn_lname,inc.inc_address,dist.dst_name
  
                FROM ($this->tbl_inc as inc,$this->tbl_inc_amb as inc_amb,$this->tbl_amb as amb,$this->tbl_opby as opby,$this->tbl_inc_adv inc_adv) 
                   
                LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
                    
                LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 

                LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id  

                LEFT JOIN $this->tbl_amb_type as amb_type ON amb.amb_type=amb_type.ambt_id

                LEFT JOIN $this->tbl_dist as dist ON amb.amb_district=dist.dst_code
                   
                   
                   
                 WHERE inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")
                    
                    AND opby.sub_id=inc_adv.adv_id 
					AND inc_adv.adv_inc_ref_id=inc.inc_ref_id
					AND inc.inc_ref_id = inc_amb.inc_ref_id
					AND TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no)
                    AND inc.incis_deleted='0' $condition ORDER BY inc.inc_id ASC");

        //echo $this->db->last_query();die();
        return $result->result();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To get call details.
    // 
    /////////////////////////////////////////

    function prev_call_adv($args = array()) {


        $condition = "";

        if ($args['adv_cl_inc_id']) {

            $condition .= "AND add_adv.adv_cl_inc_id='" . $args['adv_cl_inc_id'] . "'  ";
        }

        if ($args['adv_cl_adv_id']) {

            $condition .= "  AND add_adv.adv_cl_adv_id IN (" . $args['adv_cl_adv_id'] . ")";
        }

        if ($args['is_deleted'] != 'false') {
            $condition .= " AND que_isdeleted='0'";
        }



//        $result = $this->db->query("SELECT que.que_question,add_adv.adv_cl_id,add_adv.adv_cl_adv_id
//            FROM $this->tbl_inc_add_adv as add_adv,$this->tbl_que as que 
//            WHERE add_adv.adv_cl_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")"
//            . " AND add_adv.adv_cl_madv_que=que.que_id $condition");

        $result = $this->db->query("SELECT que.que_question,add_adv.adv_cl_id,add_adv.adv_cl_adv_id
            FROM $this->tbl_inc_add_adv as add_adv,$this->tbl_que as que 
            WHERE  add_adv.adv_cl_madv_que=que.que_id $condition");




//        
//      echo $this->db->last_query();die;


        return $result->result();
    }

    //// Created by MI42 ////////////////////
    // 
    // Purpose : To get call details.
    // 
    /////////////////////////////////////////

    function prev_call_dtl($args = array()) {

        $condition = "";

        if ($args['adv_cl_id']) {

            $condition = " add_adv.adv_cl_id='" . $args['adv_cl_id'] . "' AND ";
        }

//        $result = $this->db->query("
//            
//            SELECT que.que_question,add_adv.*,ans.ans_answer,loc.level_type as lv_type,cgs.score as cg_score,pptype1.pp_type as left_pp,pptype2.pp_type as right_pp
//            
//            FROM $this->tbl_inc_add_adv as add_adv 
//                
//            LEFT JOIN $this->tbl_que as que ON(add_adv.adv_cl_madv_que=que.que_id) 
//            LEFT JOIN $this->tbl_mas_default_ans as ans ON(que.que_id=ans.ans_que_id) 
//             
//            LEFT JOIN $this->tbl_loc_level as loc ON(add_adv.adv_cl_loc_level=loc.level_id)
//            LEFT JOIN $this->tbl_pptype as pptype1 ON(add_adv.adv_cl_pup_left=pptype1.pp_id)
//            LEFT JOIN $this->tbl_pptype as pptype2 ON(add_adv.adv_cl_pup_right=pptype2.pp_id)
//            LEFT JOIN $this->tbl_cgs_score as cgs ON(add_adv.adv_cl_gcs_score=cgs.score_id)
//
//            WHERE add_adv.adv_cl_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")" .
//            " AND $condition que_isdeleted='0' 
//            
//            
//            ");
        $result = $this->db->query("
            
            SELECT que.que_question,add_adv.*,ans.ans_answer,loc.level_type as lv_type,cgs.score as cg_score,pptype1.pp_type as left_pp,pptype2.pp_type as right_pp
            FROM $this->tbl_inc_add_adv as add_adv 
            LEFT JOIN $this->tbl_que as que ON(add_adv.adv_cl_madv_que=que.que_id) 
            LEFT JOIN $this->tbl_mas_default_ans as ans ON(que.que_id=ans.ans_que_id)   
            LEFT JOIN $this->tbl_loc_level as loc ON(add_adv.adv_cl_loc_level=loc.level_id)
            LEFT JOIN $this->tbl_pptype as pptype1 ON(add_adv.adv_cl_pup_left=pptype1.pp_id)
            LEFT JOIN $this->tbl_pptype as pptype2 ON(add_adv.adv_cl_pup_right=pptype2.pp_id)
            LEFT JOIN $this->tbl_cgs_score as cgs ON(add_adv.adv_cl_gcs_score=cgs.score_id)

            WHERE $condition que_isdeleted='0' 
            
            
            ");




        return $result->result();
    }

    function check_inc_ref_id($args = array()) {

        $condition = "";

        if (isset($args['adv_inc_ref_id'])) {
            $condition .= "AND adv.adv_inc_ref_id='" . $args['adv_inc_ref_id'] . "'";
        }

        $sql = "SELECT clg.clg_first_name,clg.clg_last_name,clg.clg_ref_id,GROUP_CONCAT(adv.adv_id) as adv_ids,adv.adv_inc_ref_id ,opby.operator_id,opby.operator_type,opby.base_month FROM $this->tbl_inc_adv as adv,$this->tbl_opby as opby , $this->tbl_clg as clg where adv.adv_id = opby.sub_id AND opby.sub_type = 'ADV' AND opby.operator_id = clg.clg_ref_id AND opby.operator_type='UG-ERCP' $condition GROUP BY opby.operator_id";



        $result = $this->db->query($sql);


//       echo $this->db->last_query();die;



        if (!$result) {
            return false;
        } else {
            return $result->result();
        }
    }

    function get_epcr_by_inc_id($args = array(), $offset = '', $limit = '') {


        if ($args['inc_ref_id']) {

            $condition = " AND add_adv.adv_cl_inc_id='" . trim($args['inc_ref_id']) . "' ";
        }


        $result = $this->db->query("SELECT que.*,add_adv.*
            FROM $this->tbl_inc_add_adv as add_adv,$this->tbl_que as que 
            WHERE  add_adv.adv_cl_madv_que=que.que_id $condition");

        return $result->result();
    }

    //// Created by MI42 //////////////////////////////
    // 
    // Purpose : To get inc details opetated by EPCR.
    // 
    ///////////////////////////////////////////////////


    function get_inc_by_ercp($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['opt_id']) {
            $condition .= "opby.operator_id='" . $args['opt_id'] . "' AND ";
        }
        if ($args['sub_type']) {
            $condition .= "opby.sub_type='" . $args['sub_type'] . "' AND ";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }

//     echo   $sql = "
//            
//        SELECT inc_adv.adv_id,inc.inc_ref_id,inc.inc_datetime,inc.inc_address,clr.clr_fname,clr.clr_lname,clr.clr_mobile
//        FROM $this->tbl_opby as opby,$this->tbl_inc_adv as inc_adv,$this->tbl_inc as inc,$this->tbl_cls as cl
//        LEFT JOIN $this->tbl_clrs as clr ON(cl.cl_clr_id=clr.clr_id)
//        WHERE 	$condition
//                opby.sub_id=inc_adv.adv_id AND
//                inc_adv.adv_inc_ref_id=inc.inc_ref_id AND
//                inc.inc_cl_id=cl.cl_id GROUP BY inc_adv.adv_inc_ref_id ORDER BY inc_adv.adv_id DESC $offlim";
        $sql = "
            
        SELECT inc_adv.*,inc.*,clr.*,opby.*,dist.*,amb.*,clg.*
        FROM $this->tbl_opby as opby,$this->tbl_inc_adv as inc_adv"
            . " LEFT JOIN $this->tbl_inc as inc ON(inc.inc_ref_id=inc_adv.adv_inc_ref_id)"
            . "LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )"
            . "LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . "LEFT JOIN $this->tbl_cls as cl ON(cl.cl_clr_id=inc_adv.adv_inc_ref_id)"
            . "LEFT JOIN $this->tbl_clrs as clr ON(cl.cl_id=inc.inc_cl_id)"
            . "LEFT JOIN  $this->tbl_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id )"
            . "LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
        WHERE 	$condition
                opby.sub_id=inc_adv.adv_id AND
                inc_adv.adv_inc_ref_id=inc.inc_ref_id GROUP BY inc_adv.adv_inc_ref_id ORDER BY inc_adv.adv_id DESC $offlim";


        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_ercp_call_detials($args = array()) {

        $condition = "";

        if ($args['inc_ref_id']) {

            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "' ";
        }

        $result = $this->db->query("SELECT inc.inc_ref_id as adv_inc_ref_id,inc.inc_cl_id as adv_id,hp.hp_name,amb.amb_default_mobile,ptn.ptn_fname,ptn.ptn_lname,inc.inc_address  
                FROM ($this->tbl_inc as inc,$this->tbl_inc_amb as inc_amb,$this->tbl_amb as amb) 
                    LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
                    LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id  
                    LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 
                    WHERE  inc.inc_ref_id = inc_amb.inc_ref_id
					AND TRIM(inc_amb.amb_rto_register_no) = TRIM(amb.amb_rto_register_no)
                    AND inc.incis_deleted='0' $condition ORDER BY inc.inc_id ASC");

        // echo $this->db->last_query();
        // die();
        return $result->result();
    }

    function get_medadv_by_inc($args = array()) {

        $condition = "";

        if ($args['adv_cl_ptn_id']) {

            $condition = " add_adv.adv_cl_ptn_id='" . $args['adv_cl_ptn_id'] . "' AND ";
        }


        if ($args['adv_cl_inc_id']) {

            $condition .= " add_adv.adv_cl_inc_id='" . $args['adv_cl_inc_id'] . "' AND ";
        }

        $result = $this->db->query("
            
            SELECT que.que_question,add_adv.*,ans.ans_answer,loc.level_type as lv_type,cgs.score as cg_score,pptype1.pp_type as left_pp,pptype2.pp_type as right_pp,cgs.*
            FROM $this->tbl_inc_add_adv as add_adv 
            LEFT JOIN $this->tbl_que as que ON(add_adv.adv_cl_madv_que=que.que_id) 
            LEFT JOIN $this->tbl_mas_default_ans as ans ON(que.que_id=ans.ans_que_id)   
            LEFT JOIN $this->tbl_loc_level as loc ON(add_adv.adv_cl_loc_level=loc.level_id)
            LEFT JOIN $this->tbl_pptype as pptype1 ON(add_adv.adv_cl_pup_left=pptype1.pp_id)
            LEFT JOIN $this->tbl_pptype as pptype2 ON(add_adv.adv_cl_pup_right=pptype2.pp_id)
            LEFT JOIN $this->tbl_cgs_score as cgs ON(add_adv.adv_cl_gcs_score=cgs.score_id)

            WHERE $condition que_isdeleted='0' 
            
            
            ");





        return $result->result();
    }
     function get_inc_for_police($args = array(), $offset = '', $limit = '') {


 

        $condition = $offlim = '';

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
        
        if ($args['pda_operator_id']) {
            $condition .= " AND police_call.pc_added_by='" . $args['pda_operator_id'] . "' ";
        }
        

        if ($args['pc_inc_ref_id']) {
            $condition .= " AND police_call.pc_inc_ref_id='" . $args['pc_inc_ref_id'] . "' ";
        }
        if ($args['inc_ref_id']) {
            $condition .= " AND police_call.pc_pre_inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['district_code']) {
            $condition .= " AND police_call.pc_district_code='" . $args['district_code'] . "' ";
        }
        if ($args['child_pda']) {
            $condition .= " AND police_call.pc_added_by IN ('" . $args['child_pda'] . "') ";
        }
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
            
        }


//          $sql = "SELECT * "
//            . " FROM $this->tbl_police_station_calls_details AS police_call "
//            . " LEFT JOIN $this->tbl_police_station AS police ON ( police.p_id = police_call.pc_police_station_id )"
//            . " LEFT JOIN $this->tbl_mas_police_cheif_comp AS chief ON ( chief.po_ct_id = police_call.pc_police_chief_complaint )"
//            . " LEFT JOIN $this->tbl_incidence AS inc ON ( police_call.pc_pre_inc_ref_id = inc.inc_ref_id )"
//            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
//            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
//            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
//            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = police_call.pc_district_code )"
//            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
//            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND inc.incis_deleted = '0'  AND inc.inc_set_amb = '1'  $condition) $search  GROUP BY police_call.pc_inc_ref_id ORDER BY police_call.pc_added_date DESC $offlim";
          
          
                    $sql = "SELECT * "
            . " FROM $this->tbl_incidence AS inc LEFT JOIN $this->tbl_police_station_calls_details AS police_call ON ( police_call.pc_pre_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_police_station AS police ON ( police.p_id = police_call.pc_police_station_id )"
            . " LEFT JOIN $this->tbl_mas_police_cheif_comp AS chief ON ( chief.po_ct_id = police_call.pc_police_chief_complaint )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND inc.incis_deleted = '0'  AND inc.inc_set_amb = '1'  $condition) $search  ORDER BY inc.inc_datetime DESC $offlim";
 
                   
      

        $result = $this->db->query($sql);

       

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

}
