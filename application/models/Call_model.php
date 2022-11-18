<?php

class Call_model extends CI_Model {

    function __construct() {



        parent::__construct();

        $this->load->helper('date');

        $this->load->database();


        $this->tbl_quality_audit = $this->db->dbprefix('quality_audit');
        $this->tbl_mas_call_purpose = $this->db->dbprefix('mas_call_purpose');

        $this->tbl_call = $this->db->dbprefix('calls');

        $this->tbl_callers = $this->db->dbprefix('callers');

        $this->tbl_mas_questionnaire = $this->db->dbprefix('mas_questionnaire');

        $this->tbl_complaints_type_questions = $this->db->dbprefix('complaints_type_questions');

        $this->tbl_mas_micnature = $this->db->dbprefix('mas_micnature');

        $this->tbl_mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_mas_police_cheif_comp = $this->db->dbprefix('mas_police_cheif_comp');
        $this->tbl_mas_police_help_comp = $this->db->dbprefix('mas_police_help_comp');
        $this->tbl_mas_fire_cheif_comp = $this->db->dbprefix('mas_fire_cheif_comp');
        $this->tbl_mas_ero_remark = $this->db->dbprefix('mas_ero_remark');

        $this->tbl_mas_default_ans = $this->db->dbprefix('mas_default_ans');

        $this->tbl_comp_ques_ambu = $this->db->dbprefix('comp_ques_ambu');

        $this->tbl_colleague = $this->db->dbprefix('colleague');

        $this->tbl_ambulance = $this->db->dbprefix('ambulance');

        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_pt = $this->db->dbprefix('patient');

        $this->tbl_incidence = $this->db->dbprefix('incidence');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_amb_type = $this->db->dbprefix('mas_ambulance_type');

        $this->tbl_dist = $this->db->dbprefix('mas_districts');

        $this->tbl_inc_patient = $this->db->dbprefix('incidence_patient');

        $this->tbl_patient = $this->db->dbprefix('patient');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->call_assing_history = $this->db->dbprefix('call_assing_history');
        $this->call_assing_users = $this->db->dbprefix('call_assing_users');
        $this->ero_users_status = $this->db->dbprefix('ero_users_status');
        $this->tbl_avaya_call_summary = $this->db->dbprefix('avaya_call_summary');
        $this->ero_avaya_extensions = $this->db->dbprefix('ero_avaya_extensions');
        $this->tbl_avaya_incoming_call = $this->db->dbprefix('avaya_incoming_call');
        $this->tbl_non_eme_call = $this->db->dbprefix('non_eme_call_type');
        $this->tbl_non_eme_calls = $this->db->dbprefix('non_eme_calls');
        $this->tbl_mas_grievance_type = $this->db->dbprefix('mas_grievance_type');
        $this->tbl_mas_grievance_sub_type = $this->db->dbprefix('mas_grievance_sub_type');
        $this->tbl_mas_feedback_standard_remark = $this->db->dbprefix('mas_feedback_standard_remark');
        $this->tbl_erosupervisor_call_details = $this->db->dbprefix('erosupervisor_call_details');
        $this->tbl_extension_summary = $this->db->dbprefix('avaya_extension_summary');
        $this->tbl_corona_advice= $this->db->dbprefix('corona_advice');
        $this->tbl_provide_imp= $this->db->dbprefix('mas_provider_imp');
        $this->tbl_wrap= $this->db->dbprefix('avaya_wrapping');
        $this->tbl_situational_call_details = $this->db->dbprefix('situational_call_details');
        $this->tbl_comu_app_user_amb_req = $this->db->dbprefix('comu_app_user_amb_req');
        $this->tbl_base_location =$this->db->dbprefix('base_location');
        $this->tbl_lbs_data =$this->db->dbprefix('lbs_data');
    }
    function add_situational_call($args = array()) {

        $this->db->insert($this->tbl_situational_call_details, $args);
       // echo $this->db->last_query();
        return $this->db->insert_id();
    }
    function add_erosupervisor_call($args = array()) {

        $this->db->insert($this->tbl_erosupervisor_call_details, $args);

        return $this->db->insert_id();
    }

    function get_inc_type($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';


        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }



        $sql = "SELECT inc.inc_ref_id,inc.inc_type,cl_purpose.pname"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " WHERE 1=1 $condition $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";



        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    /* MI13

      Get EMT Incident to show on dashboard

     */
    function get_inc_by_followupero($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        /*if ($args['operator_id'] && $args['call_search'] == '' && $args['operator_id'] != 'all') {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }*/
          if ($args['child_ero']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_ero'] . "') ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
         if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['search_chief_comp']) {

            $search .= " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
        }
        if ($args['system_type']) {
            $condition .= " AND inc.inc_system_type = '" . $args['system_type'] . "'";
        }
        $search1 = "";

        if ($args['call_search']) {
            
            $search1 .= " AND ( inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_first_name LIKE '%".$args['call_search']."%' OR colleague.clg_last_name LIKE '%".$args['call_search']."%' OR colleague.clg_mid_name LIKE '%".$args['call_search']."%' ) ";
            
        }
        $call_type="";

        if ($args['call_purpose'] != ""){
            if($args['call_purpose'] == "all"){
                 $call_type .= "";
            }else{
                $call_type .= " AND inc.inc_type IN ('" . $args['call_purpose'] . "') ";
            }
            
        }else{
            $call_type .= "AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CALL','DROP_BACK','Child_CARE_CALL','DROP_BACK_CALL','Child_CARE','PREGANCY_CARE_CAL','NON_MCI_WITHOUT_AMB','PICKUP_CALL','EMG_PVT_HOS')";
        }
        if ($args['to_date'] != '' || $args['from_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $search1 .= "AND (inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }
       if ($args['incis_deleted']){
           $condition .=" AND inc.incis_deleted IN ('4')";
       }else{
           $condition .=" AND inc.incis_deleted IN ('0')";
       }
       
       if ($args['followup_status']){
           $condition .=" AND inc.followup_status IN ('1')";
       }
       
       if ($args['pcr_status']){
        $condition .=" AND inc.inc_pcr_status IN ('0','1')";
        }else{
        $condition .=" AND inc.inc_pcr_status IN ('0')";
        }
        if ($args['call_status'] != ""){
            if($args['call_status'] != "all"){
                $condition .= " AND inc.incis_deleted IN ('" . $args['call_status'] . "') ";
            }
            
        }
        if ($args['incident_status'] != ''){
            if($args['incident_status'] == '1'){
                $condition .= " AND inc.inc_pcr_status  IN ('0') ";
            }
            else if($args['incident_status'] == ' '){
                $condition .= "";
            }else{
                $condition .= " AND driver_para.parameter_count IN ('" . $args['incident_status'] . "') ";
            }
            
        }
        
       //var_dump($args);die;
        $sql = "SELECT followup_re.followup_reason as flw_reason,inc.followup_schedule_datetime,inc.followup_reason,inc.followup_reason_other,inc.inc_ref_id,colleague.clg_first_name,colleague.clg_avaya_id, colleague.clg_last_name, inc.inc_dispatch_time,inc.inc_datetime,inc.inc_pcr_status,inc.incis_deleted,inc.inc_ref_id as in_ref_id,inc.inc_audio_file,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,inc.inc_audit_status,complaint.*,driver_para.parameter_count"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id "
            . " LEFT JOIN ems_mas_followup_standered_remark as followup_re ON followup_re.followuo_id =inc.followup_reason "
            
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS complaint ON complaint.ct_id = inc.inc_complaint"
            . " WHERE (inc.inc_base_month IN (" . $args['base_month'] . ") " .$call_type." AND inc.inc_duplicate ='No'  $condition) $search  $search1 GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";

        //echo $sql;

        $result = $this->db->query($sql);

        
//       if($_SERVER['REMOTE_ADDR']=='45.116.46.94' || $_SERVER['REMOTE_ADDR'] == '192.168.1.50' || $_SERVER['REMOTE_ADDR'] == '103.83.213.158'){
        // echo $this->db->last_query();
         //die();
//       }
        if($result){
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
        }
    }
    function get_inc_by_followupero_search($args = array(), $offset = '', $limit = ''){
       

        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        


        if ($args['call_search']) {
            
            $search1 .= " AND ( inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_first_name LIKE '%".$args['call_search']."%' OR colleague.clg_last_name LIKE '%".$args['call_search']."%' OR colleague.clg_mid_name LIKE '%".$args['call_search']."%' ) ";
            
        }
        
        if ($args['to_date'] != '' || $args['from_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $search1 .= "AND (inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }
       if ($args['incis_deleted']){
           $condition .=" AND inc.incis_deleted IN ('4')";
       }
       
        $sql = "SELECT inc.followup_reason,inc.followup_reason_other,inc.inc_ref_id,colleague.clg_first_name,colleague.clg_avaya_id, colleague.clg_last_name, inc.inc_dispatch_time,inc.inc_datetime,inc.inc_pcr_status,inc.incis_deleted,inc.inc_ref_id as in_ref_id,inc.inc_audio_file,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,inc.inc_audit_status,complaint.*,driver_para.parameter_count"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id "
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS complaint ON complaint.ct_id = inc.inc_complaint"
            . " WHERE (inc.inc_base_month IN (" . $args['base_month'] . ") AND inc.inc_duplicate ='No'  $condition) $search  $search1 GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
        $result = $this->db->query($sql);
        if($result){
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
        } 
    }
    function get_inc_by_ero($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id'] && $args['call_search'] == '' && $args['operator_id'] != 'all') {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
          if ($args['child_ero']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_ero'] . "') ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
         if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['search_chief_comp']) {

            $search .= " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
        }
        if ($args['system_type']) {
            $condition .= " AND inc.inc_system_type = '" . $args['system_type'] . "'";
        }
        $search1 = "";

        if ($args['call_search']) {
            
            $search1 .= " AND ( inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_avaya_id LIKE '%".$args['call_search']."%' OR colleague.clg_first_name LIKE '%".$args['call_search']."%' OR colleague.clg_last_name LIKE '%".$args['call_search']."%' OR colleague.clg_mid_name LIKE '%".$args['call_search']."%' ) ";
            
        }
        $call_type="";

        if ($args['call_purpose'] != ""){
            if($args['call_purpose'] == "all"){
                 $call_type .= "";
            }else{
                $call_type .= " AND inc.inc_type IN ('" . $args['call_purpose'] . "') ";
            }
            
        }else{
            $call_type .= "AND inc.inc_type IN ('on_scene_care','MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CALL','DROP_BACK','Child_CARE_CALL','DROP_BACK_CALL','PICK_UP','PICKUP_CALL','Child_CARE','PREGANCY_CARE_CAL','EMG_PVT_HOS')";
        }
        if ($args['to_date'] != '' || $args['from_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $search1 .= "AND (inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }
       if ($args['incis_deleted']){
           $condition .=" AND inc.incis_deleted IN ('0','2')";
       }else{
           $condition .=" AND inc.incis_deleted IN ('0')";
       }
       if ($args['pcr_status']){
        $condition .=" AND inc.inc_pcr_status IN ('0','1')";
        }else{
        $condition .=" AND inc.inc_pcr_status IN ('0')";
        }
        if ($args['call_status'] != ""){
            if($args['call_status'] != "all"){
                $condition .= " AND inc.incis_deleted IN ('" . $args['call_status'] . "') ";
            }
            
        }
        if ($args['incident_status'] != ''){
            if($args['incident_status'] == '1'){
                $condition .= " AND inc.inc_pcr_status  IN ('0') ";
            }
            else if($args['incident_status'] == ' '){
                $condition .= "";
            }else{
                $condition .= " AND driver_para.parameter_count IN ('" . $args['incident_status'] . "') ";
            }
            
        }
        
       //var_dump($args);die;
        $sql = "SELECT inc.inc_ref_id,colleague.clg_first_name,colleague.clg_avaya_id, colleague.clg_last_name, inc.inc_dispatch_time,inc.inc_datetime,inc.inc_pcr_status,inc.incis_deleted,inc.inc_ref_id as in_ref_id,inc.inc_audio_file,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,inc.inc_audit_status,complaint.*,driver_para.parameter_count"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id "
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS complaint ON complaint.ct_id = inc.inc_complaint"
            . " WHERE (inc.inc_base_month IN (" . $args['base_month'] . ") " .$call_type." AND inc.inc_duplicate ='No'  $condition) $search  $search1 GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";



        $result = $this->db->query($sql);

        
//       if($_SERVER['REMOTE_ADDR']=='45.116.46.94' || $_SERVER['REMOTE_ADDR'] == '192.168.1.50' || $_SERVER['REMOTE_ADDR'] == '103.83.213.158'){
        
  
//       }
        if($result){
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
        }
    }

    function get_inc_by_ero_audit($args = array(), $offset = '', $limit = '') {

//var_dump($args);die;
        $condition = $offlim = '';


        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id'] != '') {
            if ($args['operator_id'] != 'all') {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
            }
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['call_purpose']) {
            if($args['call_purpose'] != "all"){
                $condition .= " AND inc.inc_type='" . $args['call_purpose'] . "' ";
            }
        }
        
        if ($args['team_type'] != '') {
            if ($args['team_type'] == 'UG-ERO,UG-ERO-102') {
                $condition .= "AND colleague.clg_group IN ('UG-ERO','UG-ERO-102')";
            }elseif ($args['team_type'] == 'UG-DCO,UG-DCO-102') {
                $condition .= "AND colleague.clg_group IN ('UG-DCO','UG-DCO-102')";
            }else{
            $condition .= " AND colleague.clg_group ='" . $args['team_type'] . "' ";
            }
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['search_chief_comp']) {

            $search = " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
        }

        if($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";}


//        var_dump($condition);
//        die();
        if ($args['call_search']) {

            $search1 = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }
        if($args['closure_done_inc']){
            $condition .= "AND inc.inc_pcr_status IN ('0','1')";
        }else{
            $condition .= "AND inc.inc_pcr_status IN ('0','1')";
        }

       $sql = "SELECT inc.inc_ref_id,inc.inc_added_by,dist.dst_name,colleague.clg_avaya_agentid, colleague.clg_first_name, colleague.clg_last_name,colleague.clg_group,colleague.clg_ref_id, inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,inc.inc_audit_status,complaint.*"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS complaint ON complaint.ct_id = inc.inc_complaint"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND inc.inc_duplicate ='No' AND inc.incis_deleted IN ('0','1') AND inc.inc_audit_status IN ('0','1')  $condition ) $search  $search1  GROUP BY inc.inc_ref_id ORDER BY inc.inc_dispatch_time ASC $offlim";

     //die;

        $result = $this->db->query($sql);
//echo $this->db->last_query(); die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inc_audit_done($args = array(), $offset = '', $limit = '') {

        //var_dump($args);die;
                $condition = $offlim = '';
        
        
                if ($args['clr_mobile']) {
                    $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
                }
                if ($args['operator_id'] != '') {
                    if ($args['operator_id'] != 'all') {
                    $condition .= " AND audit.qa_ad_user_ref_id ='" . $args['operator_id'] . "' ";
                    }
                }
                if ($args['qa_id'] != '') {
                    if ($args['qa_id'] != 'all') {
                    $condition .= " AND audit.added_by ='" . $args['qa_id'] . "' ";
                    }
                }
        
                if ($args['inc_ref_id']) {
                    $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
                }
                if ($args['ero']) {
                    $condition .= " AND audit.qa_ad_user_ref_id='" . $args['ero'] . "' ";
                }
                if ($args['call_purpose']) {
                    if($args['call_purpose'] != "all"){
                        $condition .= " AND inc.inc_type='" . $args['call_purpose'] . "' ";
                    }
                }
                if ($args['team_type'] != '') {
                    if ($args['team_type'] != 'all') {
                    $condition .= " AND colleague.clg_group ='" . $args['team_type'] . "' ";
                    }
                }
        
                if ($args['inc_feedback_status']) {
                    $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
                }
        
                if ($offset >= 0 && $limit > 0) {
        
                    $offlim .= "limit $limit offset $offset ";
                }
                if ($args['search_chief_comp']) {
        
                    $search = " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
                }
        
                if($args['from_date'] != '' && $args['to_date'] != '') {
                    $from = $args['from_date'];
                    $to = $args['to_date'];
                    $condition .= " AND audit.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";}
        
                if ($args['call_search']) {
        
                    $search1 = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
                }
                if($args['closure_done_inc']){
                    $condition .= "AND inc.inc_pcr_status IN ('0','1')";
                }else{
                    $condition .= "AND inc.inc_pcr_status IN ('0','1')";
                }
        
          $sql = "SELECT audit.*,colleague.clg_avaya_agentid,inc.inc_dispatch_time,inc.inc_audit_status,inc.inc_audio_file,inc.inc_datetime,inc.inc_avaya_uniqueid,colleague.clg_first_name,colleague.clg_last_name,inc.inc_type,cl_purpose.pname,inc.inc_added_by"
                    . " FROM $this->tbl_quality_audit AS audit"
                    . " LEFT JOIN ems_incidence AS inc ON (inc.inc_ref_id = audit.inc_ref_id )"
                     . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
                     . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = audit.qa_ad_user_ref_id )"
                    // . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
                    // . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
                     
                    // . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
                    // . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
                    // . "LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
                    // . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
                    // . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
                    // . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS complaint ON complaint.ct_id = inc.inc_complaint"
                    . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  $condition ) $search  $search1  GROUP BY audit.inc_ref_id ORDER BY audit.added_date DESC $offlim";
        
                $result = $this->db->query($sql);
        //echo $this->db->last_query(); die();
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                    return $result->result();
                }
            }
        
    function get_inc_by_ero_dispatch($args = array(), $offset = '', $limit = '') {

        $args['curt_time']= date('Y-m-d H:i:s');
        $args['curt_time_one_hr'] =  date('Y-m-d H:i:s', strtotime('-5 minute'));
        
        $condition = $offlim = '';
  
        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
          if ($args['base_month'] != '') {
            $condition .= " AND  inc.inc_base_month IN (" . $args['base_month'] . ")";
        }
       
        

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }

        $sql = "SELECT inc.inc_ref_id,colleague.clg_first_name,colleague.clg_last_name,colleague.clg_avaya_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types as chief ON (chief.ct_id = inc.inc_complaint)"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " WHERE (inc.inc_datetime BETWEEN '".  $args['curt_time_one_hr']."' AND  '".$args['curt_time']." 'AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','on_scene_care','PICK_UP','PICKUP_CALL','DROP_BACK','PICK_UP','EMT_MED_AD','EMG_PVT_HOS') AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status = '0' $condition) $search GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
    
            $result = $this->db->query($sql);
            //echo $this->db->last_query();die;
            if($result){
                if ($args['get_count']) {
                    return $result->num_rows();
                } else {
                return $result->result();
                }
            }
    }


          /// old_function 
//     function get_inc_by_ero_dispatch($args = array(), $offset = '', $limit = '') {

//         // var_dump($args, $offset, $limit);die();
//         $condition = $offlim = '';

//         if ($args['clr_mobile']) {
//             $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
//         }

//         if ($args['operator_id']) {
//             $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
//         }

//         if ($args['inc_ref_id']) {
//             $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
//         }

//         if ($args['inc_feedback_status']) {
//             $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
//         }

//         if ($args['amb_district'] != '') {
//             $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
//         }
        

//         if ($offset >= 0 && $limit > 0) {

//             $offlim .= "limit $limit offset $offset ";
//         }
//         if ($args['call_search']) {

//             $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
//         }

//         $sql = "SELECT inc.inc_ref_id,colleague.clg_first_name,colleague.clg_last_name,colleague.clg_avaya_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type"
//             . " FROM $this->tbl_incidence AS inc"
//             . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
//             . " LEFT JOIN $this->tbl_mas_patient_complaint_types as chief ON (chief.ct_id = inc.inc_complaint)"
//             . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
//             . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
//             . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
//             . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
//             . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
//             . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
//             . "LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
//             . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
//             . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
//             . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL') AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status = '0' $condition) $search GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";


//         $result = $this->db->query($sql);
// //echo $this->db->last_query();die;
//         if($result){
//             if ($args['get_count']) {
//                 return $result->num_rows();
//             } else {
//                return $result->result();
//             }
//         }
//     }

// old function function

    function get_inc_by_ero_calls($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array()) {

//var_dump($args);die;
        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }
        if ($args['system_filter']) {
            $condition .= " AND inc.inc_system_type='" . $args['system_filter'] . "' ";
        }
         if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }


        if ($sortby['call_type'] != "") {
            $call_type = trim($sortby['call_type']);
            $sortby_sql = " AND cl_purpose.pcode = '$call_type'";
        }
        if ($sortby['date'] != "") {
            //$sortby_sql = " AND inc.inc_datetime = '" . $sortby['date'] . "'";
            
        }
        if ($sortby['status'] != "") {
            $sortby_sql = " AND gri.gc_closure_status = '" . $sortby['status'] . "'";
        }


        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql = " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }
        if($args['clg_user_group']=='UG-FeedbackManager')
        {
            $condition .= " AND inc.inc_feedback_status ='1' ";
        }else{
            $condition .= " AND inc.inc_feedback_status ='0' ";
        } 
        if ($args['48hours']) {

            $condition .= " AND inc.inc_datetime > NOW() - INTERVAL 48 HOUR";
        }


        $sql = "SELECT inc.inc_ref_id,inc.inc_system_type,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,ems_cl_type.cl_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN $this->tbl_non_eme_calls AS ems_calls ON ( ems_calls.ncl_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_calls.ncl_call_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status IN ('0','1')  $condition $sortby_sql) $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";


        $result = $this->db->query($sql);
//echo $this->db->last_query();die;


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inc_by_ero_calls_reopen($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array()) {
        
//var_dump($args);die;
$condition = $offlim = '';

if ($args['clr_mobile']) {
    $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
}
if ($args['operator_id']) {
    $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
}

if ($args['inc_ref_id']) {
    $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
}

if ($args['inc_feedback_status']) {
    $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
}
if ($args['system_filter']) {
    $condition .= " AND inc.inc_system_type='" . $args['system_filter'] . "' ";
}
 if ($args['from_date'] != '' && $args['to_date'] != '') {
    $from = $args['from_date'];
    $to = $args['to_date'];
    $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
}


if ($sortby['call_type'] != "") {
    $call_type = trim($sortby['call_type']);
    $sortby_sql = " AND cl_purpose.pcode = '$call_type'";
}
if ($sortby['date'] != "") {
    //$sortby_sql = " AND inc.inc_datetime = '" . $sortby['date'] . "'";
    
}
if ($sortby['status'] != "") {
    $sortby_sql = " AND gri.gc_closure_status = '" . $sortby['status'] . "'";
}


if ($sortby['inc_id'] != "") {
    $date = $sortby['inc_id'];
    $sortby_sql = " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
}

if ($offset >= 0 && $limit > 0) {

    $offlim .= "limit $limit offset $offset ";
}
if ($args['call_search']) {

    $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
}
if ($args['48hours']) {

    $condition .= " AND inc.inc_datetime > NOW() - INTERVAL 48 HOUR";
}


$sql = "SELECT feed.*,feed_re.*,inc.inc_ref_id,inc.inc_system_type,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,ems_cl_type.cl_name"
    . " FROM $this->tbl_incidence AS inc"
    . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
    . " LEFT JOIN $this->tbl_non_eme_calls AS ems_calls ON ( ems_calls.ncl_inc_ref_id = inc.inc_ref_id )"
    . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_calls.ncl_call_type )"
    . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
    . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
    . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
    . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
    . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
    . "LEFT JOIN $this->tbl_base_location as hp ON amb.amb_base_location = hp.hp_id"
    . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
    . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
    . " LEFT JOIN ems_feedback_call_details AS feed ON feed.fc_inc_ref_id = inc.inc_ref_id"
    . " LEFT JOIN ems_mas_feedback_standard_remark AS feed_re ON feed_re.fdsr_id  = feed.fc_standard_type"
    . " WHERE (inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status IN ('0','1')  $condition $sortby_sql) $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";


$result = $this->db->query($sql);
//echo $this->db->last_query();die;


if ($args['get_count']) {
    return $result->num_rows();
} else {
    return $result->result();
}
    }
    function get_inc_by_ero_calls_history($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array()) {

        //var_dump($args);die();
        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile LIKE '%" . $args['clr_mobile'] . "%' ";
        }
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "' ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }
        if ($args['call_type'] != "" && $args['call_type'] != "all" ) {
            $call_type = trim($args['call_type']);
            
            $sortby_sql = " AND cl_purpose.pcode = '$call_type'";
        }


        if ($sortby['call_type'] != "") {
            $call_type = trim($sortby['call_type']);
            $sortby_sql = " AND cl_purpose.pcode = '$call_type'";
        }
        if ($sortby['date'] != "") {
            $sortby_sql = " AND inc.inc_datetime = '" . $sortby['date'] . "'";
        }
        if ($sortby['status'] != "") {
            $sortby_sql = " AND gri.gc_closure_status = '" . $sortby['status'] . "'";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }

        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql = " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }
        if (isset($args['search_caller_details']) && $args['search_caller_details'] != '') {
            $condition .= "AND (clr.clr_mobile LIKE '%" . trim($args['search_caller_details']) . "%' OR clr.clr_fname LIKE '%" . trim($args['search_caller_details']) . "%' OR clr.clr_lname LIKE '%" . trim($args['search_caller_details']) . "%' )";
        }


         $sql = "SELECT clg.clg_first_name,clg.clg_last_name,inc.inc_complaint,inc.inc_mci_nature,inc.inc_ref_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,ptn.ptn_id,ptn.ptn_fname,ptn.ptn_gender,ptn.ptn_age,inc.inc_type,ems_cl_type.cl_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN $this->tbl_non_eme_calls AS ems_calls ON ( ems_calls.ncl_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_calls.ncl_call_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " LEFT JOIN $this->tbl_colleague AS clg ON clg.clg_ref_id = inc.inc_added_by"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")   AND inc.incis_deleted = '0'  $condition $sortby_sql) $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
       


        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_terminate_inc_by_ero($args = array(), $offset = '', $limit = '') {

        //var_dump($args['inc_sup_remark_status']);

        $condition = $offlim = '';

        if ($args['operator_id']) {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' ";
        }
        if($args['inc_sup_remark_status'] != "") {
            
            $condition .= " AND inc.inc_sup_remark_status='".$args['inc_sup_remark_status']."' ";
        }
        
        if ($args['amb_district'] != '') {
            $condition .= " AND amb.amb_district IN ('" . $args['amb_district'] . "') ";
        }
        
         if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }


        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%')";
        }


         $sql = "SELECT inc.inc_ref_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,inc.inc_avaya_uniqueid,cl_purpose.pname,cl_purpose.pname as cl_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
//            . " LEFT JOIN $this->tbl_non_eme_calls AS ems_calls ON ( ems_calls.ncl_inc_ref_id = inc.inc_ref_id )"
//            . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_calls.ncl_call_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " WHERE (inc.inc_base_month IN (" . $args['base_month'] . ") AND inc.inc_type IN ('COMP_CALL','TEST_CALL','ENQ_CALL','FEED_CALL','FOLL_CALL','UNREC_CALL','SUPPORT','CALL_TRANS_102','CALL_TRANS_108','AMB_TO_ERC','PRO_REP_SER','NON_EME_CALL','AMB_NOT_AVA','DUP_CALL','ESCALATION_CALL','MISS_CALL','NUS_CALL','SERVICE_NOT_REQUIRED','SLI_CALL','WRONG_CALL','SUGG_CALL','DEMO_CALL','APP_CALL','DISS_CON_CALL','ABUSED_CALL')  AND inc.inc_duplicate ='No' AND inc.inc_pcr_status = '0' $condition) $search   AND inc.incis_deleted ='0' GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
     
        
        

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_terminate_inc($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['operator_id']) {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%' OR hp.hp_name LIKE '%" . $args['call_search'] . "%' OR dist.dst_name LIKE '%" . $args['call_search'] . "%'  OR cl_purpose.pname LIKE '%" . $args['call_search'] . "%')";
        }

        $sql = "SELECT inc.inc_ref_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,clr.*,dist.dst_name,amb.amb_pilot_mobile,amb.amb_rto_register_no,inc_amb.amb_emt_id,inc_amb.amb_pilot_id,amb.amb_default_mobile,inc.inc_address,hp.hp_name,inc.inc_added_by,inc.inc_avaya_uniqueid,cl_purpose.pname,ems_cl_type.cl_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN $this->tbl_non_eme_calls AS ems_calls ON ( ems_calls.ncl_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_calls.ncl_call_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN   $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_inc_patient AS iptn ON inc.inc_ref_id = iptn.inc_id "
            . " LEFT JOIN $this->tbl_patient AS ptn ON iptn.ptn_id = ptn.ptn_id"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND ( inc.inc_type IN ('MCI','NON_MCI','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','EMG_PVT_HOS') AND inc.incis_deleted = '2') AND inc.inc_duplicate ='No' AND inc.inc_pcr_status = '0' $condition) $search AND inc.inc_is_closed='0' GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_caller_details_by_callid($call_id) {


        $sql = " Select clr.clr_fullname,clr.clr_fname,clr.clr_lname,clr.clr_mname,clr.clr_mobile From  $this->tbl_callers as clr, $this->tbl_call as cl Where (clr.clr_id = cl.cl_clr_id ) AND cl.cl_id = $call_id";
        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_incedence_details_by_c_no($args) {


        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition = "  clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }




        $sql = " Select clr.*,cl.*,inc.*"
            . " FROM  $this->tbl_callers as clr"
            . " LEFT JOIN ems_calls AS cl ON (cl.cl_id = clr.clr_id )"
            . " LEFT JOIN ems_incidence AS inc ON (inc.inc_cl_id = cl.cl_id )"
            . " WHERE $condition ORDER BY inc.inc_datetime DESC limit 1";


        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_emt_pilot_amb_by_inc_id($inc_ref_id) {
        $sql = "Select inc_amb.*, clg_emt.clg_mobile_no, clg_pilot.clg_mobile_no as clg_pilot_mobile From $this->tbl_incidence_ambulance as inc_amb LEFT JOIN $this->tbl_colleague as clg_emt ON (clg_emt.clg_ref_id = inc_amb.amb_emt_id ) LEFT JOIN $this->tbl_colleague as clg_pilot ON (clg_pilot.clg_ref_id = inc_amb.amb_pilot_id ) Where inc_amb.inc_ref_id = '$inc_ref_id' AND inc_amb.amb_status = 'assign'";

        $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    /*  Get all active purpose of calls

     */
    function get_parent_purpose_of_calls($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_call_purpose");

        if (trim($args['pcode']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.pcode", $args['pcode']);
        }
        if (trim($args['p_systen']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.p_systen", $args['p_systen']);
        }

        $this->db->where("$this->tbl_mas_call_purpose.pstatus", '1');
        $this->db->where("$this->tbl_mas_call_purpose.p_parent", '');

        $this->db->where("$this->tbl_mas_call_purpose.pis_deleted", '0');
        $this->db->order_by('pname');

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_purpose_of_calls($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_call_purpose");

        if (trim($args['pcode']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.pcode", $args['pcode']);
        }
        if (trim($args['p_parent']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.p_parent", $args['p_parent']);
        }
         if (trim($args['p_systen']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.p_systen", $args['p_systen']);
        }

        $this->db->where("$this->tbl_mas_call_purpose.pstatus", '1');

        $this->db->where("$this->tbl_mas_call_purpose.pis_deleted", '0');
         $this->db->order_by('pname');

        $data = $this->db->get();

        $result = $data->result();
       // echo $this->db->last_query();

        return $result;
    }
   function get_all_child_purpose_of_calls() {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_call_purpose");

        $this->db->where("$this->tbl_mas_call_purpose.pstatus", '1');
        $this->db->where("$this->tbl_mas_call_purpose.p_parent != ", '');

        $this->db->where("$this->tbl_mas_call_purpose.pis_deleted", '0');
       // $this->db->where_("$this->tbl_mas_call_purpose.p_parent IN 'EMG');
        $this->db->where("$this->tbl_mas_call_purpose.p_parent IN ('EMG')");
        $this->db->order_by('pname');

        $data = $this->db->get();
            //        echo $this->db->last_query();
            //        die();

        $result = $data->result();

        return $result;
    }
    function get_all_child_purpose_of_104_calls() {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_call_purpose");

        $this->db->where("$this->tbl_mas_call_purpose.pstatus", '1');
        $this->db->where("$this->tbl_mas_call_purpose.p_parent != ", '');
        $this->db->where("$this->tbl_mas_call_purpose.p_systen", '104');

        $this->db->where("$this->tbl_mas_call_purpose.pis_deleted", '0');
        $this->db->order_by('pname');

        $data = $this->db->get();
            //        echo $this->db->last_query();
            //        die();

        $result = $data->result();

        return $result;
    }
  function get_all_provide_imp() {

        $this->db->select('*');
        $this->db->from("$this->tbl_provide_imp");

        $this->db->where("$this->tbl_provide_imp.pro_status", '1');
        $this->db->where("$this->tbl_provide_imp.prois_deleted", '0');
        $this->db->where("$this->tbl_provide_imp.pro_id NOT IN (21,41,42,44,43,52,53)");

         $this->db->order_by('pro_name');

        $data = $this->db->get();
      // echo $this->db->last_query();
        //die();

        $result = $data->result();

        return $result;
    }

    function get_unavail_provide_imp() {

        $this->db->select('*');
        $this->db->from("$this->tbl_provide_imp");

        $this->db->where("$this->tbl_provide_imp.pro_status", '1');
        $this->db->where("$this->tbl_provide_imp.prois_deleted", '0');
        $this->db->where("$this->tbl_provide_imp.pro_id IN (21,41,42,44,43,52,53)");

         $this->db->order_by('pro_name');

        $data = $this->db->get();
      // echo $this->db->last_query();
        //die();

        $result = $data->result();

        return $result;
    }


    function get_all_qa() {

        $this->db->select('*');
        $this->db->from("$this->tbl_colleague");
        $qa = array('UG-Quality', 'UG-QualityManager');
        $this->db->where_in('clg_group', $qa);
        //$this->db->where("$this->tbl_mas_call_purpose.p_parent != ", '');
        $this->db->where("clg_is_deleted", '0');
         $this->db->order_by('clg_first_name', 'ASC');

        $data = $this->db->get();
//        echo $this->db->last_query();
//        die();

        $result = $data->result();

        return $result;
    }

    function get_non_eme_calls() {

        $this->db->select('*');

        $this->db->from("$this->tbl_non_eme_call");

        $this->db->where("$this->tbl_non_eme_call.cl_status", '1');

        $this->db->where("$this->tbl_non_eme_call.cl_is_deleted", '0');

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_mic_nat($args = array(), $limit = '', $offset = '') {



        $this->db->select('*');

        $this->db->from("$this->tbl_mas_micnature");



        if (trim($args['ntr_nature']) != "") {



            $this->db->like("$this->tbl_mas_micnature.ntr_nature", $args['ntr_nature']);
        }



        $this->db->where("$this->tbl_mas_micnature.ntr_status", '1');

        $this->db->where("$this->tbl_mas_micnature.ntris_deleted", '0');



        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_grievance_type($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_grievance_type");

        if (trim($args['grievance_type']) != "") {

            $this->db->like("$this->tbl_mas_grievance_type.grievance_type", $args['grievance_type']);
        }

        $this->db->where("$this->tbl_mas_grievance_type.grievance_isdeleted", '0');
        $this->db->where("$this->tbl_mas_grievance_type.grievance_new", '1');
        $this->db->order_by("grievance_type",'ASC');

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_feedback_stand_remark($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_feedback_standard_remark");

        if (trim($args['fdsr_type']) != "") {

            $this->db->like("$this->tbl_mas_feedback_standard_remark.fdsr_type", $args['fdsr_type']);
        }
        if (trim($args['fdsr_id']) != "") {

            $this->db->where("$this->tbl_mas_feedback_standard_remark.fdsr_id", $args['fdsr_id']);
        }
        if (trim($args['feed_type']) != "") {

            $this->db->like("$this->tbl_mas_feedback_standard_remark.fdsr_key", $args['feed_type']);
        }


        $this->db->where("$this->tbl_mas_feedback_standard_remark.fdsr_is_deleted", '0');
        $this->db->order_by('fdsr_type','ASC');

        $data = $this->db->get();

        $result = $data->result();
  //echo  $this->db->last_query();
        //die;
        return $result;
    }

    function get_grievance_sub_type($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_grievance_sub_type");

        if (trim($args['grievance_sub_type']) != "") {

            $this->db->like("$this->tbl_mas_grievance_sub_type.grievance_sub_type", $args['grievance_sub_type']);
        }
        if (trim($args['chief_complete']) != "") {

            $this->db->where("$this->tbl_mas_grievance_sub_type.grievance_id",$args['chief_complete']);
        }

        $this->db->where("$this->tbl_mas_grievance_sub_type.g_isdeleted", '0');
        $this->db->where("$this->tbl_mas_grievance_sub_type.grievance_new", '1');
        $this->db->order_by("grievance_sub_type","asc");

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }

    function get_caller_details($m_no) {

        $this->db->select('*');
        $this->db->from("$this->tbl_callers");
        $this->db->where("$this->tbl_callers.clr_mobile", $m_no);
        $this->db->order_by("$this->tbl_callers.clr_id", "DESC");
        $this->db->limit(1, 0);
        $data = $this->db->get();
        $result = $data->result();
        return $result[0];
    }

    function get_emt_user_details($m_no) {

        $data = $this->db->query("SELECT amb.*, hp.hp_name, dist.dst_name, amb_type.*
            FROM $this->tbl_ambulance as amb
            LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id
            LEFT JOIN $this->tbl_amb_type as amb_type ON amb.amb_type = amb_type.ambt_id
            LEFT JOIN $this->tbl_dist as dist ON amb.amb_district = dist.dst_code
            WHERE amb.amb_default_mobile = '$m_no' ");

//        echo $this->db->last_query();
//        die();


        $result = $data->result();



        return $result[0];
    }

    function insert_caller_details($args = array()) {



        $this->db->select('*');

        $this->db->from("$this->tbl_callers");

        $this->db->where("$this->tbl_callers.clr_mobile", $args['clr_mobile']);
        $this->db->where("$this->tbl_callers.clr_fname", $args['clr_fname']);
        $this->db->where("$this->tbl_callers.clr_lname", $args['clr_lname']);

        $fetched = $this->db->get();

        $present = $fetched->result();
        if (count($present) == 0) {
            $result = $this->db->insert($this->tbl_callers, $args);
            
            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {
            return $present[0]->clr_id;
        }
    }

    function update_caller_details($args = array(), $caller_id) {



        $this->db->where_in('clr_id', $caller_id);

        $data = $this->db->update("$this->tbl_callers", $args);
        

        return $data;
    }

    function insert_call_details($args = array()) {



        $result = $this->db->insert($this->tbl_call, $args);

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    }

    function insert_softdial_details($args = array()) {



        $result = $this->db->insert($this->tbl_avaya_call_summary, $args);

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    }

    function update_call_details($args = array(), $caller_id) {



        $this->db->where_in('cl_id', $caller_id);

        $data = $this->db->update("$this->tbl_call", $args);
        

        return $data;
    }

    function get_inter_questions($que_type) {



        $this->db->select('*');

        $this->db->from("$this->tbl_mas_questionnaire");

        $this->db->where("$this->tbl_mas_questionnaire.que_type", $que_type);

        $data = $this->db->get();

        $result = $data->result();

        return $result;
    }
    function get_questions($ct_id) {

        //        $this->db->select('*');
        //        $this->db->from("$this->tbl_mas_questionnaire");
        //        $this->db->where("$this->tbl_mas_questionnaire.que_type" , $que_type);
        //        $data = $this->db->get();
        //        $result = $data->result();
        //        return $result;
        
        
        
                $sql = "SELECT ques.*, qu_an.ans_answer"
                    . " FROM " . $this->tbl_mas_questionnaire . " AS ques"
                    . " LEFT JOIN " . $this->tbl_complaints_type_questions . " AS qu_tp ON ( ques.que_id = qu_tp.que_id )"
                    . " LEFT JOIN " . $this->tbl_mas_default_ans . " AS qu_an ON ( ques.que_id = `qu_an`.`ans_que_id`)"
                    . " WHERE 1=1 "
                    . " AND qu_tp.ct_id = '$ct_id'";
        
        
        
        
        
                $result = $this->db->query($sql);
        
        
        
                if ($result) {
        
                    return $result->result();
                } else {
        
                    return false;
                }
            }
    function get_active_questions($ct_id) {

//        $this->db->select('*');
//        $this->db->from("$this->tbl_mas_questionnaire");
//        $this->db->where("$this->tbl_mas_questionnaire.que_type" , $que_type);
//        $data = $this->db->get();
//        $result = $data->result();
//        return $result;



        $sql = "SELECT ques.*, qu_an.ans_answer"
            . " FROM " . $this->tbl_mas_questionnaire . " AS ques"
            . " LEFT JOIN " . $this->tbl_complaints_type_questions . " AS qu_tp ON ( ques.que_id = qu_tp.que_id )"
            . " LEFT JOIN " . $this->tbl_mas_default_ans . " AS qu_an ON ( ques.que_id = `qu_an`.`ans_que_id`)"
            . " WHERE ques.que_isdeleted = '0'"
            . " AND qu_tp.ct_id = '$ct_id'";





        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function get_chief_comp($args = array(), $limit = '', $offset = '') {
        //var_dump($args['gender']);die();
        $this->db->select('*');

        $this->db->from("$this->tbl_mas_patient_complaint_types");

        if (trim($args['cc_name']) != "") {
            $this->db->like("$this->tbl_mas_patient_complaint_types.ct_type", $args['cc_name'], 'both');
        }
       // if($args['gender'] != ''){
            if ($args['gender'] == 'F') {
                //$id = array('27', '28', '29','55','39');
                $ct_gender = array('1', '3');
                $this->db->where_in("$this->tbl_mas_patient_complaint_types.ct_gender", $ct_gender);
            }else if ($args['gender'] == 'M'){
                $ct_gender = array('1', '2');
                $this->db->where_in("$this->tbl_mas_patient_complaint_types.ct_gender", $ct_gender);
            }else if ($args['gender'] == 'O'){
                $ct_gender = array('1');
                $this->db->where_in("$this->tbl_mas_patient_complaint_types.ct_gender", $ct_gender);
            }
        //}
       // else{
            //$ct_gender = array('1');
            //$this->db->where_in("$this->tbl_mas_patient_complaint_types.ct_gender", ' ');
        //}
        if (trim($args['ct_call_type']) != "") {
            $this->db->where("$this->tbl_mas_patient_complaint_types.ct_call_type", $args['ct_call_type']);
        }
        $this->db->where("$this->tbl_mas_patient_complaint_types.ct_status", '1');
        $this->db->where("$this->tbl_mas_patient_complaint_types.ctis_deleted", '0' );
        $this->db->group_by('ct_type');
        $this->db->order_by('ct_type','ASC');
         
        $data = $this->db->get();
        //echo  $this->db->last_query();
        // die;
        $result = $data->result();
        return $result;
    }
    function get_counslor_remark_list($args = array(), $limit = '', $offset = ''){
        $this->db->select('*');
        $this->db->from('ems_mas_counslor_standard_remark');

        if (trim($args['counslor_remark']) != "") {
            $this->db->like('ems_mas_counslor_standard_remark.counslor_remark', $args['counslor_remark'], 'both');
        }
    
        $this->db->where('ems_mas_counslor_standard_remark.status', '1');
        $this->db->where('ems_mas_counslor_standard_remark.is_deleted', '0' );
        $this->db->order_by('counslor_remark','ASC');
        $data = $this->db->get();
        //echo  $this->db->last_query();
        //die;
        $result = $data->result();
        return $result;
    }
    function get_chief_comp_help_desk($args = array(), $limit = '', $offset = '') {
        $this->db->select('*');
        $this->db->from('ems_complaint_types_help_desk');

        if (trim($args['ct_type']) != "") {
            $this->db->like('ems_complaint_types_help_desk.ct_type', $args['ct_type'], 'both');
        }
    
        $this->db->where('ems_complaint_types_help_desk.ct_status', '1');
        $this->db->where('ems_complaint_types_help_desk.ctis_deleted', '0' );
        $this->db->order_by('ct_type','ASC');
        $data = $this->db->get();
    //    echo  $this->db->last_query();
    //    die;
        $result = $data->result();
        return $result;
    }

    function get_police_help_comp($args = array(), $limit = '', $offset = '') {
        $this->db->select('*');

        $this->db->from("$this->tbl_mas_police_help_comp");

        if (trim($args['cc_name']) != "") { 
            $this->db->like("$this->tbl_mas_police_help_comp.po_hp_name", $args['cc_name'], 'both');
        }
        if (trim($args['po_hp_id']) != "") {
            $this->db->where("$this->tbl_mas_police_help_comp.po_hp_id", $args['po_hp_id']);
        }

        $this->db->where("$this->tbl_mas_police_help_comp.po_hp_status", '1');
        $this->db->where("$this->tbl_mas_police_help_comp.po_hp_deleted", '0');
        $this->db->order_by("po_hp_name", "asc");
        $data = $this->db->get();
       // echo  $this->db->last_query();
        //die;
        $result = $data->result();
        return $result;
    }
    function get_police_chief_comp($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_police_cheif_comp");

        if (trim($args['cc_name']) != "") {
            $this->db->like("$this->tbl_mas_police_cheif_comp.po_ct_name", $args['cc_name'], 'both');
        }
        if (trim($args['po_ct_id']) != "") {
            $this->db->where("$this->tbl_mas_police_cheif_comp.po_ct_id", $args['po_ct_id']);
        }

        $this->db->where("$this->tbl_mas_police_cheif_comp.po_ct_status", '1');
        $this->db->where("$this->tbl_mas_police_cheif_comp.po_ct_deleted", '0');
        $this->db->order_by("po_ct_name", "asc");
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function get_pda_stand_remarks($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');
        $this->db->from("ems_pda_remarks");

        if (trim($args['cc_name']) != "") {
            $this->db->like("ems_pda_remarks.remarks", $args['cc_name'], 'both');
        }
        $this->db->order_by("id", "asc");
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }


    function get_fire_chief_comp($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_fire_cheif_comp");

        if (trim($args['cc_name']) != "") {
            $this->db->like("$this->tbl_mas_fire_cheif_comp.fi_ct_name", $args['cc_name'], 'both');
        }
        if (trim($args['fi_ct_id']) != "") {
            $this->db->where("$this->tbl_mas_fire_cheif_comp.fi_ct_id", $args['fi_ct_id']);
        }

        $this->db->where("$this->tbl_mas_fire_cheif_comp.fi_ct_status", '1');
        $this->db->where("$this->tbl_mas_fire_cheif_comp.fi_ct_deleted", '0');
        $this->db->order_by("fi_ct_name", "asc");
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function get_ero_summary_remark_followup($args = array(), $limit = '', $offset = ''){
        //var_dump($args); 
        $this->db->select('*');

        $this->db->from("ems_mas_followup_standered_remark");

        if (trim($args['cc_name']) != "") {
            $this->db->like("ems_mas_followup_standered_remark.followup_reason", $args['cc_name'], 'both');
        }
        $this->db->where("ems_mas_followup_standered_remark.is_deleted", '0');
       
        $data = $this->db->get();
        $result = $data->result();
         //echo $this->db->last_query();
        // die();
        return $result; 
        
       
    }
    function get_ero_summary_remark($args = array(), $limit = '', $offset = '') {

        $this->db->select('*');

        $this->db->from("$this->tbl_mas_ero_remark");

        if (trim($args['cc_name']) != "") {
            $this->db->like("$this->tbl_mas_ero_remark.re_name", $args['cc_name'], 'both');
        }
        if (trim($args['system_type']) != "") {
            $this->db->where("$this->tbl_mas_ero_remark.system_type", $args['system_type']);
        }
        if (trim($args['call_type']) != "") {
            $this->db->where("$this->tbl_mas_ero_remark.call_type", $args['call_type']);
        }
        if (trim($args['re_id']) != "") {
            $this->db->where("$this->tbl_mas_ero_remark.re_id", $args['re_id']);
        }

        $this->db->where("$this->tbl_mas_ero_remark.re_status", '1');
        $this->db->where("$this->tbl_mas_ero_remark.re_deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        
        return $result;
    }
    function get_district_name($args = array()) {
        // print_r($args);die;
        $dist = $args['inc_district_id'];
        $sql = "SELECT dst.*"
        . " FROM  ems_mas_districts AS dst"
        . " WHERE dst.dst_code = $dist";
            $result = $this->db->query($sql);
            // echo $this->db->last_query();die;
            return $result->result();
    }
    function get_cm_ambu_type($ct_id, $ques_details) {
        $sql = "SELECT am_tp.ambu_type"
            . " FROM " . $this->tbl_comp_ques_ambu . " AS am_tp"
            . " WHERE am_tp.ct_id = $ct_id"
            . " AND am_tp.question_ans LIKE '%$ques_details%'";
            $result = $this->db->query($sql);



        if ($result) {

            $result = $result->result();

            return $result[0];
        } else {

            return false;
        }
    }

    function get_reference_ambu_type($ambu_type) {

        //$ambu_type = $ambu_type[0];

        if ($ambu_type != '' && $ambu_type != 'undefined') {
            //$am_cond = " AND amb.amb_type = $am_tp";

            $sql = "SELECT ems_mas_ambulance_type.ambu_level FROM ems_mas_ambulance_type WHERE ambt_id = '$ambu_type'";

            $result = $this->db->query($sql);
            $amb_level = $result->result();

            $amb_level_no = $amb_level[0]->ambu_level;
            
            $sql = "SELECT ems_mas_ambulance_type.ambt_id, ems_mas_ambulance_type.ambt_name, ems_mas_ambulance_type.ambu_level FROM ems_mas_ambulance_type WHERE ambu_level BETWEEN $amb_level_no AND 6";

            $result = $this->db->query($sql);
            $amb_level = $result->result();
        }

        if (!empty($amb_level)) {
            return $amb_level;
        } else {
            return false;
        }
    }

    function get_user_info_inc($clg_mobile_no = "", $group = "") {


        $condition = '';

        if (trim($clg_mobile_no) != '') {
            $condition .= " AND colleague.clg_mobile_no = '" . $clg_mobile_no . "'";
        }
        if ($group != "") {
            $condition .= " AND colleague.clg_group = '" . $group . "'";
        }

        $result1 = $this->db->query("SELECT colleague.clg_ref_id, colleague.clg_group "
            . "FROM `$this->tbl_colleague` AS colleague "
            . "WHERE colleague.clg_is_deleted = '0' $condition");


        $result = $result1->result();




        return $result;
    }

    function insert_patient_details($args = array()) {
        // print_r($args);die;
        $result = $this->db->insert($this->tbl_pt, $args);

        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function get_inc_ero_108($inc_id) {

        $sql = "SELECT *"
            . " FROM ems_operateby"
            . " WHERE sub_id = '$inc_id'"
            . " AND operator_type = 'UG-ERO-108'";





        $result = $this->db->query($sql);



        if ($result) {

            $result = $result->result();

            return $result[0];
        } else {

            return false;
        }
    }

    function get_free_ero_user($status) {


        $sql = "SELECT *"
            . " FROM $this->call_assing_users "
            . " WHERE call_status = '$status' ORDER BY datetime ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

    function get_free_ero_user_by_status($user_group = '') {
        if (trim($user_group) != '') {
            $condition .= " AND user_group  = '" . $user_group . "'";
        }else{
            $condition .= " AND user_group  = 'UG-ERO'";
        }

        $sql = "SELECT *"
            . " FROM $this->call_assing_users where 1=1 $condition"
            . " ORDER BY FIELD('call_status', 'free', 'atnd', 'assign') ASC, datetime ASC limit 0, 1";


        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

    function assign_call_to_user($args = array()) {

        $result = $this->db->insert($this->call_assing_history, $args);

        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function insert_call_user($args = array()) {

        $result = $this->db->insert($this->call_assing_users, $args);


        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function is_free_user_exists($user_ref_id) {

        $sql = "SELECT *"
            . " FROM $this->call_assing_users "
            . " WHERE user_ref_id = '$user_ref_id' ORDER BY datetime ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

    function update_call_status($id, $status) {

        $call_args = array('call_status' => $status);
        $this->db->where('id', $id);
        $data = $this->db->update($this->call_assing_history, $call_args);
        return $data;
    }
    function update_free_ero_user($args = array(), $user_ref_id) {



        $this->db->where_in('user_ref_id', $user_ref_id);

        $data = $this->db->update($this->call_assing_users, $args);

        return $data;
    }

    function insert_ero_call_user($args = array()) {

        $result = $this->db->insert($this->ero_users_status, $args);


        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function is_ero_free_user_exists($user_ref_id) {

        $sql = "SELECT *"
            . " FROM $this->ero_users_status "
            . " WHERE user_ref_id = '$user_ref_id' ORDER BY added_date ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_ero_102_free_user_exists() {

        $sql = "SELECT *"
            . " FROM $this->ero_users_status "
            . " WHERE status = 'free' AND user_group='UG-ERO-102' ORDER BY added_date ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_ero_108_free_user_exists() {

        $sql = "SELECT *"
            . " FROM $this->ero_users_status "
            . " WHERE status = 'free' AND user_group='UG-ERO' ORDER BY added_date ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_ero_hd_free_user_exists() {

        $sql = "SELECT *"
            . " FROM $this->ero_users_status "
            . " WHERE status = 'free' AND user_group='UG-ERO-HD' ORDER BY added_date ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

      function get_pda_free_user_exists() {

        $sql = "SELECT *"
            . " FROM $this->ero_users_status "
            . " WHERE status = 'free' AND user_group='UG-PDA' ORDER BY added_date ASC limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
     function get_pda_user_exists() {

        $sql = "SELECT *"
            . " FROM $this->ero_users_status "
            . " WHERE user_group='UG-PDA' ORDER BY added_date ASC limit 0, 1";



        $result = $this->db->query($sql);
         if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

    function delete_ero_call_user($user_ref_id) {

        if($user_ref_id != ''){
            $this->db->where('user_ref_id', $user_ref_id);
            $this->db->delete($this->ero_users_status);
        }
    }
    
    function update_ero_user_status($args = array(), $user_ref_id) {
        $this->db->where_in('user_ref_id', $user_ref_id);
        $data = $this->db->update($this->ero_users_status, $args);
       // echo $this->db->last_query();
       // die();
        return $data;
    }
    
     function delete_ero_call_user_cron($is_live_time) {

        $newDate = strtotime(" -1 minutes");

        $result = $this->db->query("DELETE  from `$this->ero_users_status`  WHERE `is_alive_time` < $newDate");
        
        return $result;
    }
    
    function get_ero_user_status($user_ref_id) {
        $condition = '';
        
        if (trim($user_ref_id) != '') {
            $condition .= "AND user_ref_id = '$user_ref_id' ";
        }
        
        $sql = "SELECT * FROM $this->ero_users_status where 1=1 $condition  ";
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function delete_call_user($user_ref_id) {

        $this->db->where('user_ref_id', $user_ref_id);
        $this->db->delete($this->call_assing_users);
    }

    function get_login_clg_data($args = array()) {

        $condition = '';

        if (trim($args['clg_ref_id']) != '') {
            $condition .= "AND clg_ref_id like '%" . $args['clg_ref_id'] . "%' ";
        }

        if (trim($args['clg_group']) != '') {
            $condition .= "AND clg_group = '" . $args['clg_group'] . "' ";
        }

        if (trim($args['clg_is_login']) != '') {
            $condition .= "AND clg_is_login = '" . $args['clg_is_login'] . "' ";
        }

        $sql = "SELECT * FROM $this->tbl_colleague where clg_is_deleted = '0' $condition $offlim ";

        $result = $this->db->query($sql);

        //echo $this->db->last_query();die;

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_calls_to_reassign() {


        $sql = "SELECT *"
            . " FROM $this->call_assing_history "
            . " WHERE (call_status = 'assign' OR call_status = 'atnd') ORDER BY datetime ASC";

        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

    function get_avaya_extension($ip) {


        $sql = "SELECT *"
            . " FROM $this->ero_avaya_extensions"
            . " WHERE ext_ip = '$ip' limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }

    function get_ip_by_avaya_extension($args = array()) {

        if (trim($args['ext_ip']) != '') {
            $condition .= "AND ext_ip = '" . $args['ext_ip'] . "' ";
        }
        if (trim($args['ext_ip']) != '') {
            $condition .= "AND ext_ip = '" . $args['ext_ip'] . "' ";
        }



        $sql = "SELECT *"
            . " FROM $this->ero_avaya_extensions"
            . " WHERE is_deleted = '0' $condition limit 0, 1";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }
    function get_all_avaya_extension_new($args = array()){

          $condition = "";
        if (trim($args['ext_no']) != '') {
            $condition .= "AND ext_no = '" . $args['ext_no'] . "' ";
        }
        $sql = "SELECT *"
        . " FROM ems_avaya_ext"
        . " WHERE is_deleted = '0' $condition ";


        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_all_avaya_extension() {



        $sql = "SELECT *"
            . " FROM ems_mas_avaya_extensions"
            . " WHERE is_deleted = '0' ";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    
    function insert_avaya_incoming_call($args = array()) {



        $result = $this->db->insert($this->tbl_avaya_incoming_call, $args);

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    }
    
    function get_last_call_status($args = array()) {

        if (trim($args['agent_no']) != '') {
            $condition .= "AND agent_no = '" . $args['agent_no'] . "' ";
        }
         if (trim($args['ext_no']) != '') {
            $condition .= "AND ext_no = '" . $args['ext_no'] . "' ";
        }
        if (trim($args['calling_phone_no']) != '') {
            $condition .= "AND calling_phone_no = '" . $args['calling_phone_no'] . "' ";
        }
        if (trim($args['CallUniqueID']) != '') {
            $condition .= "AND CallUniqueID = '" . $args['CallUniqueID'] . "' ";
        }
         if (trim($args['status']) != '') {
            $condition .= "AND status = '" . $args['status'] . "' ";
        }
        

         $sql = "SELECT *"
            . " FROM $this->tbl_avaya_incoming_call"
            . " WHERE is_deleted = '0' $condition ORDER BY id DESC limit 0, 1"; 
     
        

        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }

    function get_avaya_call_by_ext($args = array()) {

        if (trim($args['agent_no']) != '') {
            $condition .= "AND agent_no = '" . $args['agent_no'] . "' ";
        }
         if (trim($args['ext_no']) != '') {
            $condition .= "AND ext_no = '" . $args['ext_no'] . "' ";
        }
        if (trim($args['calling_phone_no']) != '') {
            $condition .= "AND calling_phone_no = '" . $args['calling_phone_no'] . "' ";
        }
        if (trim($args['CallUniqueID']) != '') {
            $condition .= "AND CallUniqueID = '" . $args['CallUniqueID'] . "' ";
        }
         if (trim($args['status']) != '') {
            $condition .= "AND status = '" . $args['status'] . "' ";
        }
        

         $sql = "SELECT *"
            . " FROM $this->tbl_avaya_incoming_call"
            . " WHERE is_deleted = '0' $condition ORDER BY call_datetime DESC limit 0, 1"; 
        

        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }
    function get_avaya_audio($args = array()) {

        if(trim($args['CallUniqueID']) == 'direct_atnd_call'){
          return false;  
        }
        if (trim($args['CallUniqueID']) != '') {
            $condition .= "AND CallUniqueID = '" . $args['CallUniqueID'] . "' ";
        }
        
        if (trim($args['inc_datetime']) != '') {
            $inc_datetime = $args['inc_datetime'];
            $condition .= "AND call_datetime BETWEEN '$inc_datetime 00:00:00' AND '$inc_datetime 23:59:59'";
        }

        $sql = " SELECT *"
            . " FROM $this->tbl_avaya_incoming_call "
            . " WHERE 1=1 $condition ORDER BY call_datetime DESC limit 0, 1"; 
     //  die();
     
        

        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }

    function update_avaya_call_by_ext($args = array(), $caller_id) {



        $this->db->where_in('id', $caller_id);

        $data = $this->db->update("$this->tbl_avaya_incoming_call", $args);

        return $data;
    }
    function update_avaya_call_by_calluniqueid($args = array()) {

        if($args['CallUniqueID'] != ""){
            $this->db->where('CallUniqueID', $args['CallUniqueID']);
                  if($args['agent_no'] != ""){
           // $this->db->where('agent_no', $args['agent_no']);
        }

        $data = $this->db->update("$this->tbl_avaya_incoming_call", $args);

        return $data;
        }
      
    }

    
    function update_avaya_call_by_sessionuuid($args = array()) {

        if($args['sessionuuid'] != ""){
            $this->db->where('sessionuuid', $args['sessionuuid']);
        
        if($args['agent_no'] != ""){
            //$this->db->where('agent_no', $args['agent_no']);
        }

        $data = $this->db->update("$this->tbl_avaya_incoming_call", $args);
        
        return $data;
        }
    }

    function get_tdo_inc($inc_id) {

        if($inc_id != ""){
            $condition = " AND sub_id = '$inc_id' ";
        }

        $sql = "SELECT *"
            . " FROM ems_operateby"
            . " WHERE operator_type = 'UG-ERO' $condition";



        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result[0];
        } else {
            return false;
        }
    }
    function get_inc_escalation($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id'] && $args['call_search'] == '') {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
          if ($args['child_ero']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_ero'] . "') ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['search_chief_comp']) {

            $search = " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
        }
        $search1 = "";

        if ($args['call_search']) {
       
            $search1 .= " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%' ) ";
            
        }
        if ($args['to_date'] || $args['from_date']) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $search1 .= "AND (inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }

        $sql = "SELECT inc.inc_ref_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,clr.*,inc.inc_address,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND inc.inc_type IN ('ESCALATION_CALL') AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status = '0' $condition) $search  $search1 GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";



        $result = $this->db->query($sql);
//echo $this->db->last_query(); die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_inc_closed($args = array(), $offset = '', $limit = '') {


        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id'] && $args['call_search'] == '') {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
          if ($args['child_ero']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_ero'] . "') ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['search_chief_comp']) {

            $search = " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
        }
        $search1 = "";

        if ($args['call_search']) {
       
            $search1 .= " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%' ) ";
            
        }
        if ($args['to_date'] || $args['from_date']) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $search1 .= "AND (inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }

        $sql = "SELECT inc.inc_ref_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,clr.*,inc.inc_address,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND inc.inc_type IN ('ESCALATION_CALL') AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status = '0' $condition) $search  $search1 GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";



        $result = $this->db->query($sql);
//echo $this->db->last_query(); die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inc_professional($args){
           $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id'] && $args['call_search'] == '') {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
          if ($args['child_ero']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_ero'] . "') ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['search_chief_comp']) {

            $search = " AND (inc.inc_complaint='" . $args['search_chief_comp'] . "')";
        }
        $search1 = "";

        if ($args['call_search']) {
       
            $search1 .= " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%' ) ";
            
        }
        if ($args['to_date'] || $args['from_date']) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $search1 .= "AND (inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }

         $sql = "SELECT inc.inc_ref_id,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,clr.*,inc.inc_address,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,inc.inc_avaya_uniqueid "
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND inc.inc_type IN ('AMB_TO_ERC') AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_pcr_status = '0' $condition) $search  $search1 GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
         
      //  die();



        $result = $this->db->query($sql);
//echo $this->db->last_query(); die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inc_supervisor_remark($args){
        
         if ($args['s_inc_ref_id']) {
            $condition .= " AND s_inc_ref_id='" . $args['s_inc_ref_id'] . "' ";

             $sql = "SELECT *"
            . " FROM ems_supervisor_remark"
            . " WHERE s_isdeleted='0' $condition ";



        $result = $this->db->query($sql);
        $result = $result->result();
        // var_dump($result);die();
        if ($result) {
            return $result;
        } else {
            return false;
        }
        }
        // else{
        //     echo " - ";
        // }

              
    }

    function insert_avaya_action($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_extension_summary ");
        $this->db->where("$this->tbl_extension_summary.action_id", $args['action_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        if (count($present) == 0) {

            $result = $this->db->insert($this->tbl_extension_summary, $args);  
            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
            
        } else {
            $this->db->where_in('action_id', $args['action_id']);
            $data = $this->db->update("$this->tbl_extension_summary", $args);
            return $data;
        }
    }
    
    function get_avaya_action_summary($args = array()){
        
        $this->db->select('*');
        $this->db->from("$this->tbl_extension_summary");
        $this->db->where("$this->tbl_extension_summary.action_id", $args['ActionID']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        return $present;
        
    }
    
        function get_inc_feedback_calls($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array()){

//var_dump($args);die;
        $condition = $offlim = '';

        if ($args['clr_mobile']) {
            $condition .= " AND clr.clr_mobile='" . $args['clr_mobile'] . "' ";
        }
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }

        if ($args['inc_ref_id']) {
            $condition .= " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_feedback_status']) {
            $condition .= " AND inc.inc_feedback_status='" . $args['inc_feedback_status'] . "' ";
        }
        if ($args['system_filter']) {
            $condition .= " AND inc.inc_system_type='" . $args['system_filter'] . "' ";
        }
         if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
        }


        if ($sortby['call_type'] != "") {
            $call_type = trim($sortby['call_type']);
            $sortby_sql = " AND cl_purpose.pcode = '$call_type'";
        }
        if ($sortby['date'] != "") {
            //$sortby_sql = " AND inc.inc_datetime = '" . $sortby['date'] . "'";
            
        }
        if ($sortby['patient_status_search'] != "") {

            $patient_status_search = trim($sortby['patient_status_search']);
            //var_dump($patient_status_search);die();
            if($patient_status_search == 'Available'){
                $sortby_sql = " AND epcr.epcr_call_type IN ('2','3') ";
            }else{
                $sortby_sql = " AND epcr.epcr_call_type IN ('1') ";
            }
            //var_dump($sortby_sql);die();
          
        }
       


        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql = " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }

        if ($args['district_id'] != "") {
            $sortby_sql = " AND inc.inc_district_id = '" . $args['district_id'] . "'";
        }

        if ($args['amb_rto_register_no'] != "") {
            $sortby_sql = " AND amb.amb_rto_register_no = '" . $args['amb_rto_register_no'] . "'";
        }
        if ($args['base_location_name1'] != "") {
            $sortby_sql = " AND epcr.base_location_id = '" . $args['base_location_name1'] . "'";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }
        if ($args['call_search']) {

            $search = " AND (inc.inc_ref_id='" . $args['call_search'] . "' OR clr.clr_fname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mname LIKE '%" . $args['call_search'] . "%' OR clr.clr_lname LIKE '%" . $args['call_search'] . "%' OR clr.clr_mobile LIKE '%" . $args['call_search'] . "%'  OR inc_amb.amb_pilot_id LIKE '%" . $args['call_search'] . "%' OR inc_amb.amb_emt_id LIKE '%" . $args['call_search'] . "%' OR amb.amb_pilot_mobile LIKE '%" . $args['call_search'] . "%' OR amb.amb_rto_register_no LIKE '%" . $args['call_search'] . "%')";
        }
        if ($args['48hours'] == '48hours') {

            $condition .= " AND inc.inc_datetime > NOW() - INTERVAL 24 HOUR";
        }
        //var_dump($data['filter']);die();
        if($data['filter']=='Reopen_id'){
            $sql = "SELECT call_type.call_type,epcr.base_location_name,epcr.amb_reg_id,epcr.epcr_call_type,hp.hp_name,epcr.other_receiving_host,inc.inc_ref_id,inc.inc_system_type,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,inc.inc_address,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,inc.inc_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
           // . " LEFT JOIN $this->tbl_non_eme_calls AS ems_cl ON ( ems_cl.ncl_inc_ref_id = inc.inc_ref_id )"
           // . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_cl.ncl_call_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_feedback_call_details AS feed ON (feed.fc_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id AND epcr.base_month IN ('".($args['base_month']-1)."','".$args['base_month']."'))"
            . " LEFT JOIN ems_hospital AS hp ON ( hp.hp_id = epcr.rec_hospital_name  )"
            . " LEFT JOIN ems_mas_call_type_epcr AS call_type ON ( call_type.id = epcr.epcr_call_type  )"
            . "LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = epcr.amb_reg_id )"
            . " LEFT JOIN ems_base_location AS bl ON ( bl.hp_name = epcr.base_location_name )"
            . " WHERE (inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_feedback_status ='0'  AND inc.inc_type IN ('MCI','NON_MCI','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PICK_UP','DROP_BACK','on_scene_care','EMG_PVT_HOS') AND inc.inc_pcr_status ='1' AND IN ('1','2','3') AND epcr.epcris_deleted='0' AND inc.inc_set_amb='1' $condition $sortby_sql) $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime ASC $offlim";


        }
        else{
            $sql = "SELECT call_type.call_type,epcr.base_location_name,epcr.amb_reg_id,epcr.epcr_call_type,hp.hp_name,epcr.other_receiving_host,inc.inc_ref_id,inc.inc_system_type,inc.inc_dispatch_time,inc.inc_datetime,inc.inc_ref_id as in_ref_id,inc.inc_avaya_uniqueid,clr.*,inc.inc_address,inc.inc_added_by,cl_purpose.pname,inc.inc_complaint,cl.clr_ralation,inc.inc_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
           // . " LEFT JOIN $this->tbl_non_eme_calls AS ems_cl ON ( ems_cl.ncl_inc_ref_id = inc.inc_ref_id )"
           // . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_cl.ncl_call_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id  AND epcr.base_month IN ('".($args['base_month']-1)."','".$args['base_month']."'))"
            . " LEFT JOIN ems_hospital AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN ems_mas_call_type_epcr AS call_type ON ( call_type.id = epcr.epcr_call_type  )"
            . "LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN ems_base_location AS bl ON ( bl.hp_name = epcr.base_location_name )"
            . " WHERE (inc.inc_base_month IN ('".($args['base_month']-1)."','".$args['base_month']."') AND inc.inc_feedback_status ='0' AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_type IN ('MCI','NON_MCI','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PICK_UP','DROP_BACK','on_scene_care','EMG_PVT_HOS') AND inc.inc_pcr_status ='1'  AND inc.inc_set_amb='1'  AND epcr.epcr_call_type IN ('1','2','3') AND epcr.epcris_deleted='0' $condition $sortby_sql) $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime ASC $offlim";
            //. " WHERE (inc.inc_base_month IN (".($args['base_month']-1).",".$args['base_month'].")  AND inc.inc_duplicate ='No' AND inc.incis_deleted = '0' AND inc.inc_feedback_status ='0' AND inc.inc_type IN ('MCI','NON_MCI','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL') AND inc_pcr_status ='1' $condition $sortby_sql) $search  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
        }



        $result = $this->db->query($sql);
        //echo $this->db->last_query(); die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_advice(){
         $sql = "SELECT adv.*"
            . " FROM " . $this->tbl_corona_advice . " AS adv"
            . " WHERE adv.status = '1'";
      
            
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_blocked_number(){
        $condition = $offlim = '';

        if ($args['block_number']) {
            $condition .= " AND coral_block.block_number='" . $args['block_number'] . "' ";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        $search1 = "";

        if ($args['to_date'] || $args['from_date']) {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND (coral_block.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59')";
       }

        $sql = " SELECT * "
             . " FROM ems_coral_blocked_number AS coral_block"
             . " WHERE is_deleted='0' $condition ORDER BY coral_block.added_date DESC $offlim";
  
         

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_block_number($args = array()) {
        
        $this->db->select('*');
        $this->db->from("ems_coral_blocked_number");
        $this->db->where("ems_coral_blocked_number.block_number", $args['block_number']);
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {
        $result = $this->db->insert('ems_coral_blocked_number', $args);

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
        }else{
              $this->db->where_in('block_number', $args['block_number']);
            $data = $this->db->update("ems_coral_blocked_number", $args);
             
            return $data;
        }
    }
     function update_block_number($args = array()) {

            $this->db->where('block_number', $args['block_number']);
            $update = $this->db->update('ems_coral_blocked_number', $args);
            //echo $this->db->last_query(); die;
            if ($update) {
                return true;
            } else {
                return false;
            }
        
    }
        function get_comu_app_call_details($args = array()){
        //var_dump($args['mobile_no']);
        $sortby_sql= "";
        if($args['mobile_no'] != ''){
        if ($args['mobile_no'] != "") {
            $mno = $args['mobile_no'];
            $mno = substr($mno, -10);
            $sortby_sql .= " AND mobile_no LIKE '%$mno%'";
        }
        if ($args['call_status'] != "") {
            $call_status = $args['call_status'];
            $sortby_sql .= " AND call_status = '$call_status'";
        }
        $condition='';
        
        
        
        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-5 minutes' , strtotime($current_date))) ;
        $condition .= " AND (adv.added_date BETWEEN '$newdate' AND '$current_date')";
        
         $sql = "SELECT adv.*"
            . " FROM ems_comu_app_call_details AS adv"
            . " WHERE 1=1 $condition $sortby_sql ORDER BY `adv`.`calld_id` DESC limit 1";
      
 
 
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }else{
         return false;
    }
    }
    
    function get_comu_app_reg_details($args = array()){
        //var_dump($args['mobile_no']);
        $sortby_sql= "";
            if($args['mobile_no'] != ''){
                if ($args['mobile_no'] != "") {
                    $mno = $args['mobile_no'];
                    $mno = substr($mno, -10);
                    $sortby_sql .= " AND mobile LIKE '%$mno%'";
                }


                $sql = "SELECT reg.*"
                    . " FROM ems_comu_app_user_reg AS reg"
                    . " WHERE 1=1 $sortby_sql ORDER BY `reg`.`usr_id` DESC limit 1";


                $result = $this->db->query($sql);
                if ($result) {
                    return $result->result();
                } else {
                    return false;
                }
            }else{
                 return false;
            }
    }
    
    function update_app_call_details($args = array()) {



        $this->db->where('calld_id', $args['calld_id']);

        $data = $this->db->update("ems_comu_app_call_details", $args);
       //echo $this->db->last_query();
        //die();

        return $data;
    }
    
    function insert_wrap_status($args = array()) {



        $result = $this->db->insert($this->tbl_wrap, $args);

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    } 
    function insert_track_link($args = array()) {



        $result = $this->db->insert('ems_incident_tracklink', $args);
       

        if ($result) {

            return $this->db->insert_id();
        } else {

            return false;
        }
    }
   function get_wrap_status($args = array()){

        
        $sql = "SELECT adv.*"
            . " FROM $this->tbl_wrap AS adv"
            . " WHERE status='WI' ";
//        echo $sql;
//        die();
  
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function delete_wrap_status($args = array()) {

        if($args['agent_id'] != ''){
        $this->db->where('agent_id', $args['agent_id']);
        
        $this->db->where('extension_no', $args['extension_no']);
        $this->db->delete($this->tbl_wrap);
        }
    }
        function get_avaya_audio_current_date($args = array()) {

        if (trim($args['to_date']) != '') {
            $from_date  = $args['to_date'];
            $inc_datetime = $args['from_date'];
            $condition .= "AND call_datetime BETWEEN '$inc_datetime' AND '$from_date'";
        }

         $sql = "SELECT *"
            . " FROM $this->tbl_avaya_incoming_call"
            . " WHERE status = 'D' AND call_audio != '' $condition ORDER BY call_datetime DESC"; 
    
        
       
        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_photo_notificatin($args = array()){
        
     
        $current_date =date('Y-m-d H:i:s');
        $newdate =  date("Y-m-d H:i:s", (strtotime ('-1 minute' , strtotime ($current_date)))) ;
        $condition .= "AND added_date BETWEEN '$newdate' AND '$current_date'";
       
       
        
        if (($args['mobile_no']) != '') {
            $mno = $args['mobile_no'];
            $mno = substr($mno, -10);
           
            $condition .= " AND cl.mobile_no = '$mno' ";
        }

         $sql = "SELECT *"
            . " FROM ems_comu_app_call_imgvideo as img"
            . " LEFT JOIN ems_comu_app_call AS cl ON (img.call_id = cl.call_id )"     
            . " WHERE 1=1 $condition ORDER BY img.added_date DESC"; 
    
        

        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_emergency_aht($args = array()) {
        
        $to_date  = $args['to_date'];
        $from_date = $args['from_date'];
        $added_by = $args['clg_ref_id'];
        $base_month = $args['base_month'];
        
     

         $sql = "select  SEC_TO_TIME( SUM( TIME_TO_SEC( `inc_dispatch_time` ) ) ) AS timeSum,inc_datetime,inc.inc_type FROM ems_incidence as inc  where inc.incis_deleted='0' AND inc.inc_base_month = '$base_month' AND inc.inc_added_by = '$added_by' AND inc.inc_set_amb = '1' AND inc.inc_datetime BETWEEN '$to_date 00:00:00' AND '$from_date 23:59:59'"; 
        
    
        
       
        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_non_emergency_aht($args = array()) {

        $to_date  = $args['to_date'];
        $from_date = $args['from_date'];
        $added_by = $args['clg_ref_id'];
        $base_month = $args['base_month'];
         
         $sql = "select  SEC_TO_TIME( SUM( TIME_TO_SEC( `inc_dispatch_time` ) ) ) AS timeSum,inc_datetime,inc.inc_type FROM ems_incidence as inc  where inc.incis_deleted='0' AND inc.inc_base_month = '$base_month' AND inc.inc_added_by = '$added_by'  AND inc.inc_set_amb = '0' AND inc.inc_datetime BETWEEN '$to_date 00:00:00' AND '$from_date 23:59:59'"; 
        //die();
    
        
       
        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }
    function get_total_aht($args = array()) {
            
        $to_date  = $args['to_date'];
        $from_date = $args['from_date'];
        $added_by = $args['clg_ref_id'];
        $base_month = $args['base_month'];

        $sql = "select  SEC_TO_TIME( SUM( TIME_TO_SEC( `inc_dispatch_time` ) ) ) AS timeSum,inc_datetime,inc.inc_type FROM ems_incidence as inc  where inc.incis_deleted='0' AND inc.inc_base_month = '$base_month' AND inc.inc_added_by = '$added_by'  AND inc.inc_datetime BETWEEN '$to_date 00:00:00' AND '$from_date 23:59:59'"; 
    
        
       
        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    }

     function get_bloodgp($args = array()){
         
        if (($args['bldgrp_id']) != '') {
            $bldgrp_id = $args['bldgrp_id'];
            $condition .= " AND bldgrp_id = '$bldgrp_id' ";
        }
            $query = $this->db->query("SELECT * FROM `ems_mas_bloodgrp_type` WHERE bldgrp_deleted='0' $condition");
           
            return $query->result();
        }
        
        function get_booking_details($args = array()){
         
            
            if (($args['mobile_no']) != '') {
                $user_req_mobile = $args['mobile_no'];
                $condition .= " AND user_req_mobile = '$user_req_mobile' ";
                
                $newdate =  date("Y-m-d H:i:s", (strtotime ('-5 minute'))) ;
                $condition .= " AND user_req_added_date > '$newdate' ";

                $query = $this->db->query("SELECT req.*,cheif.ct_type,hp.hp_name,fam.*,app_user.* FROM $this->tbl_comu_app_user_amb_req as req LEFT JOIN   $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = req.user_req_chiefcomplaint) LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = req.user_req_hospid ) LEFT JOIN ems_comu_app_family_info as fam on fam.fam_id=req.user_req_patient LEFT JOIN ems_comu_app_user_reg as app_user on app_user.usr_id=req.user_req_patient  WHERE user_req_dispatched='Request' $condition order by user_req_added_date DESC limit 1");
                
                return $query->result();
             }
        }
        
    function update_booking_details($caller_id='') {

        if($caller_id != ''){

        $args = array('user_req_dispatched'=>'Dispatch');
        $this->db->where('user_req_id', $caller_id);

        $data = $this->db->update("$this->tbl_comu_app_user_amb_req", $args);
        

        return $data;
        
        }
    }
    
    function insert_lbs_data($lbs_args =array()){
        
        $result = $this->db->insert($this->tbl_lbs_data, $lbs_args);
        
        if ($result) {

            return $result;
        } else {

            return false;
        }
        
    }
    function update_lbs_data($args = array()){
        $this->db->where("lbs_timestamp", $args['lbs_timestamp']);
        $res = $this->db->update($this->tbl_lbs_data, $args);
        if ($res) {
            return $present[0]->id;
        } else {
            return false;
        }
    }
    function get_help_complaints_types($args = array()) {

        $this->db->select('*');
        $this->db->from("ems_help_complaints_type");

        if (trim($args['id']) != "") {
            
            $this->db->where("ems_help_complaints_type.id", $args['id']);
        }
        if (trim($args['cmp_id']) != "") {
            
            $this->db->where("ems_help_complaints_type.cmp_id", $args['cmp_id']);
        }
        if (trim($args['cmp_type']) != "") {
            $this->db->where("ems_help_complaints_type.cmp_type", $args['cmp_type']);
        }
         if (trim($args['cmp_name']) != "") {
            $this->db->like("$this->tbl_mas_call_purpose.cmp_name", $args['cmp_name']);
        }

        $this->db->where("ems_help_complaints_type.is_delete", '0');

         $this->db->order_by('cmp_name');

        $data = $this->db->get();

        $result = $data->result();
       // echo $this->db->last_query();

        return $result;
    }

    function get_help_complaints_name($args = array()) {
        $condition = '';

        if (($args['cmp_id']) != '') {
            $cmp_id = $args['cmp_id'];
            $condition .= " AND cmp_id = '$cmp_id' ";
            $query = $this->db->query("SELECT * FROM ems_help_complaints_type WHERE is_delete='0' $condition ");

            return $query->result();
         }
    }
}

