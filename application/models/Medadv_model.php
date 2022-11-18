<?php


class Medadv_model extends CI_Model {

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
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');

    }

    //// Created by MI42 ////////////////////////
    // 
    // Purpose : To add medical advice details.
    // 
    /////////////////////////////////////////////

    function add($args = array()) {


        $this->db->insert($this->tbl_inc_adv, $args);

        return $this->db->insert_id();
    }
    //////////To add 104  medical advice 
    function add_help_desk($args = array()) {


        $this->db->insert('ems_help_desk_inc_advice', $args);

        return $this->db->insert_id();
    }

    //////////////////MI42/////////////////////////////
    //Purpose : Get ERCP for advice.
    //  
    //////////////////////////////////////////////////

    function add_adv($args = array()) {

        $res = $this->db->insert($this->tbl_inc_add_adv, $args);
        

        return $res;
    }
    //Counslor Desk
    function add_counslor_desk_adv($args = array()){
        $res = $this->db->insert('ems_counslor_desk_advice', $args);
        return $res;
    }
    function add_counslor_desk($args = array()){
        //var_dump($args);
         
        $this->db->insert('ems_counslor_desk_inc_advice', $args);
      // $this->db->last_query();die(); 
        return $this->db->insert_id();
    }
    //////////////104 Ercp advive

    
    function add_help_desk_adv($args = array()) {

        $res = $this->db->insert('ems_help_desk_advice', $args);
        

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
         if ($args['inc_ref_id']) {

            $condition.=" AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

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
    function prev_call_adv_help($args = array()) {


        $condition = "";

        if ($args['adv_cl_inc_id']) {

            $condition .= "AND add_adv.adv_cl_inc_id='" . $args['adv_cl_inc_id'] . "'  ";
        }

        if ($args['adv_cl_adv_id']) {

            $condition .= "  AND add_adv.adv_cl_adv_id IN (" . $args['adv_cl_adv_id'] . ")";
        }

        if ($args['is_deleted'] != 'false') {
            $condition .= " AND ctis_deleted='0'";
        }

        $result = $this->db->query("SELECT help_desk.ct_type,add_adv.adv_cl_id,add_adv.adv_cl_adv_id
            FROM ems_help_desk_advice as add_adv,ems_complaint_types_help_desk as help_desk 
            WHERE  add_adv.adv_cl_madv_que=help_desk.ct_id $condition");
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

    function prev_call_dtl_help_desk($args = array()) {

        $condition = "";

        if ($args['adv_cl_id']) {

            $condition = " add_adv.adv_cl_id='" . $args['adv_cl_id'] . "' AND ";
        }
        $result = $this->db->query("SELECT add_adv.*,help_desk.ct_type
            FROM ems_help_desk_advice as add_adv 
            LEFT JOIN ems_complaint_types_help_desk as help_desk ON(add_adv.adv_cl_madv_que=help_desk.ct_id) 
            WHERE $condition ctis_deleted='0'");

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
            $condition .= " AND inc_adv.adv_emt='" . $args['opt_id'] . "'  ";
        }

        if ($args['child_ercp']) {
            $condition .= " AND inc_adv.adv_emt IN ('" . $args['child_ercp'] . "')  ";
        }


        if ($args['clg_senior']) {
           //$condition .= "clg.clg_senior='" . $args['clg_senior'] . "' AND ";
        }
        if ($args['sub_type']) {
            //$condition .= " AND opby.sub_type='" . $args['sub_type'] . "'  ";
        }
        
        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "'  ";
        }
        $filter_cond = '';
        if($args['filter']){
            $filter = $args['filter'];
            //var_dump($filter);
            if ($filter['from_date'] && $filter['to_date']) {
               $to_date = date('Y-m-d', strtotime($filter['to_date']));
               $from_date = date('Y-m-d', strtotime($filter['from_date']));
               $filter_cond .= " OR  inc_datetime BETWEEN '$from_date 00:00:01' AND '$to_date 23:59:59'    ";

           }
           if ($args['ercp_id']) {
               $filter_cond .= " OR  inc_adv.adv_emt='" . $filter['ercp_id'] . "'";
           }
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        $sql = " SELECT inc_adv.*,inc.*,clr.*,dist.*,amb.*,clg.*
        FROM $this->tbl_inc_adv as inc_adv"
            . " LEFT JOIN $this->tbl_inc as inc ON(inc.inc_ref_id=inc_adv.adv_inc_ref_id)"
            . " LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id ) "
            . " LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_cls as cl ON(cl.cl_clr_id=inc_adv.adv_inc_ref_id) "
            . " LEFT JOIN $this->tbl_clrs as clr ON(cl.cl_id=inc.inc_cl_id) "
            . " LEFT JOIN  $this->tbl_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id ) "
            . " LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id ) WHERE ( inc.inc_pcr_status = '0'  $condition) $filter_cond GROUP BY inc_adv.adv_inc_ref_id ORDER BY inc_adv.adv_id DESC $offlim";

      
        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_inc_by_helpdesk_ercp($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['opt_id']) {
            $condition .= " AND inc_adv.adv_emt='" . $args['opt_id'] . "'  ";
        }

        if ($args['child_ercp']) {
            $condition .= " AND inc_adv.adv_emt IN ('" . $args['child_ercp'] . "')  ";
        }


        // if ($args['clg_senior']) {
        //    //$condition .= "clg.clg_senior='" . $args['clg_senior'] . "' AND ";
        // }
        // if ($args['sub_type']) {
        //     //$condition .= " AND opby.sub_type='" . $args['sub_type'] . "'  ";
        // }
        
        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "'  ";
        }
        $filter_cond = '';
        if($args['filter']){
            $filter = $args['filter'];
            
            if ($filter['from_date'] && $filter['to_date']) {
               $to_date = date('Y-m-d', strtotime($filter['to_date']));
               $from_date = date('Y-m-d', strtotime($filter['from_date']));
               $filter_cond .= " AND  inc_datetime BETWEEN '$from_date 00:00:01' AND '$to_date 23:59:59'    ";
            //    var_dump($filter_cond);
           }
           if ($args['ercp_id']) {
               $filter_cond .= " OR  inc_adv.adv_emt='" . $filter['ercp_id'] . "'";
           }
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }


        $sql = "SELECT inc_adv.*,inc.*,clr.* FROM ems_help_desk_inc_advice as inc_adv"
            . " LEFT JOIN $this->tbl_inc as inc ON(inc.inc_ref_id=inc_adv.adv_inc_ref_id)"
            . " LEFT JOIN $this->tbl_cls as cl ON(cl.cl_clr_id=inc_adv.adv_inc_ref_id) "
            . " LEFT JOIN $this->tbl_clrs as clr ON(cl.cl_id=inc.inc_cl_id) WHERE ( inc.inc_pcr_status = '0'  $condition) $filter_cond GROUP BY inc_adv.adv_inc_ref_id ORDER BY inc_adv.adv_id DESC $offlim";

      
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die();
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_inc_report_by_ercp($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($args['opt_id']) {
            $condition .= " AND opby.operator_id='" . $args['opt_id'] . "'  ";
        }
        if ($args['sub_type']) {
            $condition .= " AND opby.sub_type='" . $args['sub_type'] . "'  ";
        }
       
        if ($offset >= 0 && $limit > 0) {
            $offlim = " limit $limit offset $offset ";
        }
        $sql = "SELECT inc_adv.*,add_adv.*,inc.inc_type,inc.inc_complaint,inc.inc_ref_id,inc.inc_datetime,inc.inc_pcr_status,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_fullname,ptn.ptn_age,ptn.ptn_gender
                FROM  $this->tbl_inc_add_adv as add_adv"
                . " LEFT JOIN $this->tbl_inc_adv as inc_adv ON (add_adv.adv_cl_inc_id =inc_adv.adv_inc_ref_id)"
                . " LEFT JOIN $this->tbl_inc as inc ON (inc.inc_ref_id=inc_adv.adv_inc_ref_id)"
                . " LEFT JOIN $this->tbl_pt as ptn ON (add_adv.adv_cl_ptn_id = ptn.ptn_id) "
                . " LEFT JOIN $this->tbl_patient_complaint_types as ct ON (ct.ct_id =inc.inc_complaint)"
                . " LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
                . " WHERE 1=1 $condition" ;
             //   echo $sql; die();
       // var_dump($condition);die;
       /* $sql = "SELECT inc_adv.*,inc.inc_ref_id FROM $this->tbl_opby as opby,$this->tbl_inc_adv as inc_adv"
            . " LEFT JOIN $this->tbl_inc as inc ON(inc.inc_ref_id=inc_adv.adv_inc_ref_id)"
            . "LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )"
            . "LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . "LEFT JOIN $this->tbl_cls as cl ON(cl.cl_id =inc_adv.adv_cl_id)"
            . "LEFT JOIN $this->tbl_inc_add_adv as add_adv ON(add_adv.adv_cl_inc_id =inc_adv.adv_inc_ref_id)"
            . "LEFT JOIN $this->tbl_clrs as clr ON(cl.cl_clr_id=clr.clr_id)"
            . "LEFT JOIN $this->tbl_patient_complaint_types as ct ON(ct.ct_id =inc.inc_complaint)"
            . "LEFT JOIN  $this->tbl_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id )"
            . "LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)"
            . "LEFT JOIN $this->tbl_que as que on(que.que_id = add_adv.adv_cl_madv_que) "
            . "LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id) 
           
        WHERE 1=1 $condition
                AND opby.sub_id=inc_adv.adv_id AND
                inc_adv.adv_inc_ref_id=inc.inc_ref_id GROUP BY inc_adv.adv_inc_ref_id ORDER BY inc_adv.adv_id DESC $offlim";
            */ 
         // echo $sql;die();
   

        $result = $this->db->query($sql);
        echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_ercp_call_detials($args = array()) {

        $condition = "";

        if ($args['inc_ref_id']) {

            //if(strlen(trim($args['inc_ref_id'])) == 12){
                $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "' ";
           // }
        }
        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }

        $result = $this->db->query("SELECT inc.inc_ref_id as adv_inc_ref_id,inc.inc_cl_id as adv_id,hp.hp_name,amb.amb_default_mobile,ptn.ptn_fname,ptn.ptn_lname,inc.inc_address  
                FROM ($this->tbl_inc as inc) 
                LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )            
                    LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )
                     LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                    LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )
                    LEFT JOIN $this->tbl_inc_pt as incptn on (incptn.inc_id=inc.inc_ref_id)
                    LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id  
                    LEFT JOIN $this->tbl_pt as ptn on(incptn.ptn_id = ptn.ptn_id)             
                    WHERE inc.incis_deleted='0'  $condition ORDER BY inc.inc_id DESC");

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


    function get_medadv_by_inc_help_desk($args = array()) {
        $condition = "";
        if ($args['adv_cl_ptn_id']) {
            $condition = " add_adv.adv_cl_ptn_id='" . $args['adv_cl_ptn_id'] . "' AND ";
        }
        if ($args['adv_cl_inc_id']) {
            $condition .= " add_adv.adv_cl_inc_id='" . $args['adv_cl_inc_id'] . "' AND ";
        }
        $result = $this->db->query("SELECT que.que_question,add_adv.*,ans.ans_answer
            FROM ems_help_desk_advice as add_adv 
            LEFT JOIN $this->tbl_que as que ON(add_adv.adv_cl_madv_que=que.que_id) 
            LEFT JOIN $this->tbl_mas_default_ans as ans ON(que.que_id=ans.ans_que_id)   
            WHERE $condition que_isdeleted='0'");
        return $result->result();
    }
    
    function get_ercp_by_group($args = array(), $offset = '', $limit = '') {


        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc_adv.adv_emt='" . $args['operator_id'] . "' ";
        }


        $sql = " SELECT inc_adv.*,inc_adv.adv_inc_ref_id as inc_ref_id,clr.*,cl_purpose.*,inc.inc_datetime FROM ems_incidence_advice AS inc_adv LEFT JOIN $this->tbl_inc AS inc ON ( inc.inc_ref_id = inc_adv.adv_inc_ref_id )"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id ) WHERE advis_deleted = '0' $condition GROUP BY inc_adv.adv_inc_ref_id";



        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function update_incidence_advice($args) {

        $this->db->where_in('adv_inc_ref_id', $args['adv_inc_ref_id']);
        $data = $this->db->update("ems_incidence_advice", $args);
        return $data;
    }

}
