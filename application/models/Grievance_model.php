<?php

class Grievance_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->tbl_grievance_call_details = $this->db->dbprefix('grievance_call_details');

        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');

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



        $this->tbl_clg = $this->db->dbprefix('colleague');

        $this->tbl_mas_default_ans = $this->db->dbprefix('mas_default_ans');

        $this->tbl_que = $this->db->dbprefix('mas_questionnaire');

        $this->tbl_pptype = $this->db->dbprefix('mas_pupils_type');

        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');

        $this->tbl_cgs_score = $this->db->dbprefix('mas_cgs_score');

        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_mas_grievance_type = $this->db->dbprefix('mas_grievance_type');
        $this->tbl_mas_grievance_sub_type = $this->db->dbprefix('mas_grievance_sub_type');
        $this->tbl_mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_shiftmanager_call_details = $this->db->dbprefix('shiftmanager_call_details');
    }

    function get_all_calls($args=array()) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND gri.gc_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND gri.gc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT gri.gc_inc_ref_id"
            . " FROM $this->tbl_grievance_call_details AS gri"
            . " WHERE 1=1 $condition ";
        //echo $sql;die();
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_all_closure_calls($args = array()) {
        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND gri.gc_closed_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND gri.gc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT gri.gc_inc_ref_id"
            . " FROM $this->tbl_grievance_call_details AS gri"
            . " WHERE gc_closure_status='complaint_close' $condition ";
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_all_pending_calls($args = array()) {
        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND gri.gc_added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND gri.gc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT gri.gc_inc_ref_id"
            . " FROM $this->tbl_grievance_call_details AS gri"
            . " WHERE gc_closure_status='complaint_open' $condition ";
       
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function add_gri_call($args = array()) {

        $this->db->insert($this->tbl_grievance_call_details, $args);
        ///echo $this->db->last_query();die;
        return $this->db->insert_id();
    }

    function get_gr_clg() {
        $condition = 'AND clg_group="UG-Grievance"';

        $sql = "SELECT clg_first_name,clg_last_name,clg_ref_id FROM $this->tbl_colleague where clg_is_deleted='0' $condition $offlim ORDER BY clg_first_name ASC ";

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function grievance_update_call_data($new_data = array()) {
        if ($new_data['gc_id'] != '') {
            $this->db->where_in('gc_id', $new_data['gc_id']);
        }
        if ($new_data['gc_inc_ref_id'] != '') {
            $this->db->where_in('gc_inc_ref_id', $new_data['gc_inc_ref_id']);
        }


        $data = $this->db->update($this->tbl_grievance_call_details, $new_data);

        return $data;
    }
    
    function get_inc_by_grievance($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array()) {


        $condition = $offlim = '';
        if (trim($args['gc_id']) != '') {
            $condition .= "AND gri.gc_id = '" . $args['gc_id'] . "' ";
        }

        if (trim($args['gc_inc_ref_id']) != '') {
            $condition .= "AND gri.gc_inc_ref_id = '" . $args['gc_inc_ref_id'] . "' ";
        }
       /* if (trim($args['operator_id']) != '') {
            $condition .= "AND gri.gc_added_by = '" . $args['operator_id'] . "' ";
        }*/
         if (trim($args['gc_added_by']) != '') {
            $condition .= "AND gri.gc_added_by IN ('" . $args['gc_added_by'] . "') ";
        }

        if (trim($args['gc_inc_call_type']) != '') {
            $condition .= "AND gri.gc_inc_call_type = '" . $args['gc_inc_call_type'] . "' ";
        }

        if ($sortby['complaint_type'] != "") {
            $complaint_type = trim($sortby['complaint_type']);
            $sortby_sql = " AND gri.gc_complaint_type LIKE '%$complaint_type%'";
        }
        if ($sortby['district_id'] != "") {
            $sortby_sql = " AND gri.gc_district_code = '" . $sortby['district_id'] . "'";
        }

        if ($sortby['status'] != "") {
            $sortby_sql = " AND gri.gc_closure_status = '" . $sortby['status'] . "'";
        }


        if ($sortby['complaint_id'] != "") {
            $date = $sortby['complaint_id'];
            $sortby_sql = " AND gri.gc_inc_ref_id = '" . trim($sortby['complaint_id']) . "'";
        }

        if ($sortby['incident_id'] != "") {
            $date = $sortby['incident_id'];
            $sortby_sql = " AND gri.gc_pre_inc_ref_id = '" . trim($sortby['incident_id']) . "'";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND gri.gc_added_date BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($sortby['gri_date_serach'] != "") {
            $date = $sortby['gri_date_serach'];
            $date = date("Y-m-d", strtotime($date));
            $sortby_sql = " AND gri.gc_added_date BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['gri_E_Complaint'] != "") {
            $gri_E_Complaint = $sortby['gri_E_Complaint'];
            $sortby_sql = " AND gri.gc_e_complaint_no = '".trim($gri_E_Complaint)."' ";
        }
        if ($args['clg_group'] != "") {
            $condition .= "AND clg.clg_group = '" . $args['clg_group'] . "' ";
        }
        

        $sql = "SELECT * FROM $this->tbl_grievance_call_details as gri"
            . " LEFT JOIN $this->tbl_mas_districts as district ON ( district.dst_code = gri.gc_district_code ) "
            . " LEFT JOIN $this->tbl_mas_grievance_type as gri_type ON ( gri_type.grievance_id = gri.gc_grievance_type ) "
            . " LEFT JOIN $this->tbl_mas_grievance_sub_type as gri_sub_type ON ( gri_sub_type.g_id = gri.gc_grievance_sub_type ) "
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types as ptn_cmp ON ( ptn_cmp.ct_id = gri.gc_chief_complaint ) "
            . " LEFT JOIN $this->tbl_colleague as clg ON ( clg.clg_ref_id = gri.gc_added_by ) "
           
            . " WHERE gc_is_deleted='0' $condition $sortby_sql ORDER BY gri.gc_added_date DESC "; 
      //echo $sql;
            $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_pt_inc_search_list($args = array()) {
        $c_date = date('Y-m-d');
        
        if ($args['Caller_Number']) {
        $condition .= " AND clr.clr_mobile='" . trim($args['Caller_Number']) . "' ";
                    
        }
        if ($args['district_id']) {
                $condition .= " AND inc.inc_district_id='" . trim($args['district_id']) . "' ";
        }
        if ($args['date_serach']) {
            $date = date("Y-m-d", strtotime($args['date_serach']));
            $condition = " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
           // $condition .= " AND  inc.inc_datetime BETWEEN '" . trim($args['date_serach']) . "' AND  '" . trim($args['date_serach']) . "' ";
        }
        if ($args['incident_id']) {
            $condition = " AND inc.inc_ref_id='" . trim($args['incident_id']) . "' ";
        }
        $result = $this->db->query("SELECT  inc.inc_id,inc.inc_ref_id,inc.inc_address,
                inc.inc_ero_summary,inc.inc_address,inc.inc_datetime,ptn.ptn_fname,
                ptn.ptn_lname
                FROM ($this->tbl_inc AS inc) 
                LEFT JOIN $this->tbl_cls AS cl ON (inc.inc_cl_id = cl.cl_id) 
                LEFT JOIN $this->tbl_clrs AS clr ON (cl.cl_clr_id = clr.clr_id)   
                LEFT JOIN $this->tbl_inc_pt AS incptn ON (incptn.inc_id=inc.inc_ref_id)
                LEFT JOIN $this->tbl_inc_amb AS incamb ON (incamb.inc_ref_id=inc.inc_ref_id)
                LEFT JOIN $this->tbl_pt AS ptn ON(incptn.ptn_id = ptn.ptn_id)
                WHERE inc.inc_base_month = cl.cl_base_month
                AND incis_deleted='0'  $condition GROUP BY incptn.inc_id ORDER BY inc.inc_datetime DESC");
                //echo $this->db->last_query(); die;
                 return $result->result();
        }

        function get_grivience_data($args =array()){
            $condition = '';
     if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND on_main.added_date BETWEEN '$from' AND '$to 23:59:59'";
     }
    
           if (trim($args['dist']) != '' ) {
            // $condition .= "AND on_main.mt_district_id = '" . $args['dist'] . "' ";
            $condition .= "AND on_main.ins_dist = '" . $args['dist'] . "' ";
            // $condition .= "AND district.dst_name = '" . $args['dist'] . "' ";
        }
            if (trim($args['zone']) != '') {
                // $condition .= "AND am_mt.mt_district_id = '" . $args['zone'] . "' ";
                $condition .= "AND div1.div_id = '" . $args['zone'] . "' ";
            }
           
           $sql ="select prilimnari_inform, griv.grievance_type As griv_name, gri_type.grievance_sub_type As gri_sub_type, remark,
          on_main.added_date,clg_gri.clg_first_name,clg_gri.clg_mid_name,clg_gri.clg_last_name
           FROM ems_ins_gri_audit_details as on_main 

           LEFT JOIN ems_mas_districts as district ON ( district.dst_code = on_main.ins_dist )
           LEFT JOIN ems_mas_division AS div1 ON (div1.div_code = district.div_id) 
           LEFT JOIN ems_mas_grievance_type AS griv ON (griv.grievance_id = on_main.grievance_type)
           LEFT JOIN ems_mas_grievance_sub_type AS gri_type ON (gri_type.g_id = on_main.grievance_sub_type)
           LEFT JOIN ems_colleague AS clg_gri ON (clg_gri.clg_ref_id = on_main.added_by)
          
           where 1=1 $condition ORDER BY on_main.added_date DESC" ;
        
            $result = $this->db->query($sql);
            // print_r($result->num_rows());die;
            // echo $this->db->last_query();die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    
        }

}
