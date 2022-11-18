<?php
class Inc_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_incidence = $this->db->dbprefix('incidence');

        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_mas_micnature = $this->db->dbprefix('mas_micnature');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_ems_summary = $this->db->dbprefix('summary');
        $this->tbl_mas_questionnaire = $this->db->dbprefix('mas_questionnaire');
        $this->tbl_inter_call = $this->db->dbprefix('inter_call');
        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_incidence_patient = $this->db->dbprefix('incidence_patient');
        $this->tbl_patient = $this->db->dbprefix('patient');
        $this->tbl_amb = $this->db->dbprefix('ambulance');
        $this->tbl_mas_amb_type = $this->db->dbprefix('mas_ambulance_type');
        $this->tbl_cls = $this->db->dbprefix('calls');
        $this->tbl_clrs = $this->db->dbprefix('callers');
        $this->tbl_call_purpose = $this->db->dbprefix('mas_call_purpose');
        $this->tbl_fire_cheif_comp = $this->db->dbprefix('mas_fire_cheif_comp');
        $this->tbl_inter_facility = $this->db->dbprefix('inter_facility');
        $this->tbl_dist = $this->db->dbprefix('mas_districts');
        $this->tbl_tahshil = $this->db->dbprefix('mas_tahshil');
        $this->call_assing_history = $this->db->dbprefix('call_assing_history');
        $this->call_assing_users = $this->db->dbprefix('call_assing_users');
        $this->tbl_ambulance_timestamp = $this->db->dbprefix('ambulance_timestamp_record');
        $this->tbl_epcr = $this->db->dbprefix('epcr');
        $this->tbl_hp = $this->db->dbprefix('hospital');
        $this->tbl_hp1 = $this->db->dbprefix('hospital1');
        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');
        $this->tbl_mas_provider_imp = $this->db->dbprefix('mas_provider_imp');
        $this->tbl_inventory = $this->db->dbprefix('inventory');
        $this->tbl_sms_response = $this->db->dbprefix('sms_response');
        $this->tbl_ambulance_status_summary = $this->db->dbprefix('ambulance_status_summary');
        $this->tbl_mas_relation = $this->db->dbprefix('mas_relation');
        $this->tbl_non_eme_call = $this->db->dbprefix('non_eme_call_type');
        $this->tbl_non_eme_calls = $this->db->dbprefix('non_eme_calls');
        $this->tbl_mas_ero_remark = $this->db->dbprefix('mas_ero_remark');
        $this->tbl_driver_pcr = $this->db->dbprefix('driver_pcr');
        $this->tbl_mas_responce_remark = $this->db->dbprefix('mas_responce_remark');
        $this->tbl_clg = $this->db->dbprefix('colleague');
        $this->tbl_back_drop_call = $this->db->dbprefix('back_drop_call');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_onroad_offroad = $this->db->dbprefix('amb_onroad_offroad');
        $this->tbl_mas_call_purpose = $this->db->dbprefix('mas_call_purpose');
        $this->tbl_division = $this->db->dbprefix('mas_division');
        $this->mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_inc_add_advice = $this->db->dbprefix('inc_add_advice');
        $this->tbl_inc_enable_dispatch = $this->db->dbprefix('incident_amb_enable_dispatch');
        $this->tbl_amb_status = $this->db->dbprefix('amb_status_availablity');
        
        $this->tbl_followup_action_details = $this->db->dbprefix('followup_action_details');
        $this->tbl_mas_ward = $this->db->dbprefix('mas_ward');
        $this->incidanace_analyatics_data = $this->db->dbprefix('incidanace_analyatics_data');
        
    }

    /*  Get all active purpose of calls
     */

    function insert_inc($args = array()) {
        print_r($args);die;
        $this->clg = $this->session->userdata('current_user');

          
        $post_encode = json_encode($args);
        //file_put_contents('./logs/'.date("Y-m-d").'/incidence_call.log', $post_encode."\r\n", FILE_APPEND);

        if(!($args['inc_system_type'])){
            
            if($this->clg->clg_group == 'UG-ERO'){
                $system = '108';
            }else if($this->clg->clg_group == 'UG-ERO-HD'){
                $system = 'hd';
            }else {
                $system = '102';
            }
            $args['inc_system_type'] = $system;
        }
        $args['bk_inc_ref_id'] = $args['inc_ref_id'];
        if($this->clg->thirdparty != ''){
            $args['inc_thirdparty'] = $this->clg->thirdparty;
        }else{
            $args['inc_thirdparty'] = '1';
        }

        $po_encode = json_encode($args);
       // file_put_contents('./logs/'.date("Y-m-d").'/incidence_call_system_group.log', $this->clg->clg_group."\r\n", FILE_APPEND);
        //file_put_contents('./logs/'.date("Y-m-d").'/incidence_call_system.log', $po_encode."\r\n", FILE_APPEND);

        $this->db->select('*');
        $this->db->from("$this->tbl_incidence");
// $this->db->where("$this->tbl_incidence.inc_cl_id" , $args['inc_cl_id']);
        $this->db->where("$this->tbl_incidence.inc_ref_id", $args['inc_ref_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        if (count($present) == 0) {

            $result = $this->db->insert($this->tbl_incidence, $args);
            //echo $this->db->last_query();
            //die();

            if ($result) {
                return $this->db->insert_id();
                
                
            } else {
                return false;
            }
        } else {
           if($args['inc_ref_id'] != '' || $args['inc_ref_id'] != NULL){ 

//            $this->db->where_in('inc_ref_id', $args['inc_ref_id']);
//            $data = $this->db->update("$this->tbl_incidence", $args);
//            return $data;
            }
        }
    }
     function get_inc($args = array()) {
      
        $this->db->select('*');
        $this->db->from("$this->tbl_incidence");
        $this->db->where("$this->tbl_incidence.inc_ref_id", $args['inc_ref_id']);
        $data = $this->db->get();
        $result = $data->result();
        return $result;
        
    }
    function update_inc_details($args){
        if($args['inc_ref_id'] != '' || $args['inc_ref_id'] != NULL){ 
        $this->db->where_in('inc_ref_id ', $args['inc_ref_id']);
        unset($args['inc_ref_id']);
        $data = $this->db->update($this->tbl_incidence, $args);
        return $data;
        }    
        
    }
    function update_incident_by_avayaid($args) {

        $this->db->where_in('inc_avaya_uniqueid', $args['inc_avaya_uniqueid']);
        unset($args['inc_ref_id']);
        $data = $this->db->update("$this->tbl_incidence", $args);
//        echo $this->db->last_query();
//        die();
        return $data;
    }
    
    function get_incident_by_avayaid($args) {
        $avaya_id =  $args['inc_avaya_uniqueid'];
        
        $current_date =date('Y-m-d H:i:s');
        $newdate = date('Y-m-d H:i:s',strtotime ( '-50 minutes' , strtotime($current_date))) ;
        $condition .= " AND (adv.added_date BETWEEN '$newdate' AND '$current_date')";
        
        $sql = "SELECT inc_ref_id"
            . " FROM $this->tbl_incidence"
            . " Where $this->tbl_incidence.inc_avaya_uniqueid = '$avaya_id' $condition";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function update_incident($args) {
if($args['inc_ref_id'] != '' || $args['inc_ref_id'] != NULL){ 
        $this->db->where_in('inc_ref_id', $args['inc_ref_id']);
        unset($args['inc_ref_id']);
        $data = $this->db->update("$this->tbl_incidence", $args);
        return $data;
}
    }

    function update_incident_audit($args, $data) {

        $from = $args['inc_datetime'];
        $to = $args['inc_datetime'];
        if($args['inc_ref_id'] != '' || $args['inc_ref_id'] != NULL){ 
            $condition .= "inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
            $this->db->where($condition);
            $this->db->where('inc_added_by', $args['inc_added_by']);
            unset($data['inc_ref_id']);
            $data = $this->db->update("$this->tbl_incidence", $data);
            return $data;
        }
    }

    function get_incident_ref($clg_ref_id) {


        $sql = "SELECT inc_ref_id,id"
            . " FROM $this->call_assing_history"
            . " WHERE $this->call_assing_history.user_ref_id = '$clg_ref_id' AND ($this->call_assing_history.call_status ='assign' || $this->call_assing_history.call_status ='atnd')";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_last_inc_ref($clg_ref_id) {
        $sql = "SELECT inc_ref_id,id"
            . " FROM $this->call_assing_history"
            . " WHERE $this->call_assing_history.user_ref_id = '$clg_ref_id' AND ($this->call_assing_history.call_status ='assign') ORDER BY $this->call_assing_history.id DESC  limit 0,1";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_incident_by_event_id($event_id) {

        $sql = "SELECT inc_ref_id"
            . " FROM $this->tbl_incidence"
            . " Where $this->tbl_incidence.inc_bvg_ref_number = '$event_id'";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_geo_fence_radius($dst_code) {

        $sql = "SELECT geo_fence_radius"
            . " FROM $this->tbl_dist"
            . " WHERE $this->tbl_dist.dst_code = $dst_code";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function insert_inter_call($args = array()) {

        $result = $this->db->insert($this->tbl_inter_call, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     function insert_dropback($args = array()) {

        $result = $this->db->insert($this->tbl_back_drop_call, $args);
//        echo $this->db->last_query();
//        die();
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    function get_dropback($inc_ref_id) {
        $this->db->select('*');
        $this->db->from("$this->tbl_back_drop_call");

        if ($cm_id != "") {
            $this->db->where("$this->tbl_back_drop_call.inc_ref_id", $inc_ref_id);
        }

        $data = $this->db->get();
// echo $this->db->last_query();
        $result = $data->result();
        return $result;
    }
    function insert_followupinc($args = array()){
        $result = $this->db->insert($this->tbl_followup_action_details, $args);
        //echo $this->db->last_query();
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
     function get_followupinc($args = array()){
        if ($args['inc_ref_id']) {
            $condition = " AND fac.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT fac.* "
            . " FROM $this->tbl_followup_action_details AS fac"
           
            . " WHERE 1=1 $condition order by id desc";
        


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function insert_inc_facility($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_inter_facility");
        $this->db->where("$this->tbl_inter_facility.inc_ref_id", $args['inc_ref_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();
        if (count($present) == 0) {
            $result = $this->db->insert($this->tbl_inter_facility, $args);
           

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {
            $this->db->where('inc_ref_id', $args['inc_ref_id']);
            $data = $this->db->update("$this->tbl_inter_facility", $args);
            return $data;
        }
    }

    function get_hospital_facility($args = array()) {


        if ($args['inc_ref_id']) {
            $condition = " AND fac.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT fac.*, fac.new_facility as new_facility_id,hp.hp_name as current_facility,hosp.hp_name as new_facility "
            . " FROM $this->tbl_inter_facility AS fac"
            . " LEFT JOIN  $this->tbl_hp1 AS hp ON ( hp.hp_id = fac.facility )"
            . " LEFT JOIN  $this->tbl_hp1 AS hosp ON ( hosp.hp_id = fac.new_facility )"
            . " LEFT JOIN  $this->tbl_incidence AS inc ON ( inc.inc_ref_id = fac.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' $condition";
        


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function insert_inc_amb($args = array()) {

        $args['bk_inc_ref_id'] = $args['inc_ref_id'];
        $result = $this->db->insert($this->tbl_incidence_ambulance, $args);
       // echo $this->db->last_query();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    function update_inc_amb($args) {

        if($args['inc_ref_id'] != '' || $args['inc_ref_id'] != NULL){ 
            $this->db->where_in('inc_ref_id', $args['inc_ref_id']);
            unset($args['inc_ref_id']);
            $data = $this->db->update("$this->tbl_incidence_ambulance", $args);
            return $data;
        }
    }
    function get_last_incident_by_amb($args) {

        $condition = "";
        if($args['amb_no']) {
            $condition = " AND inc_amb.amb_rto_register_no='" . $args['amb_no'] . "' ";
        }
 
 
        $sql = "SELECT inc.inc_datetime,inc.inc_ref_id,inc_amb.amb_rto_register_no"
         . " FROM ems_incidence_ambulance AS inc_amb"
         . " LEFT JOIN ems_incidence AS inc ON ( inc_amb.inc_ref_id = inc.inc_ref_id )"
         . " WHERE inc.incis_deleted = '0'"
         . " AND inc.inc_set_amb  = '1' $condition order by inc.inc_id DESC limit 0,1";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
        
    }

    function get_amb_emp($amb_reg, $sht) {

//             $sql =   "SELECT amb.amb_id,amb.amb_rto_register_no,tm.tm_id,tm.tm_pilot_id,tm.tm_emt_id,am_sc.*"
//                    ." FROM ems_ambulance AS amb"
//                    ." LEFT JOIN ems_ambulance_schedule AS am_sc ON ( am_sc.scd_amb_rto_reg_id = amb.amb_rto_register_no )"
//                    ." LEFT JOIN ems_amb_default_team AS tm ON ( tm.tm_amb_rto_reg_id = amb.amb_rto_register_no )"
//                    ." WHERE scdis_deleted = '0'"
//                    ." AND amb.amb_rto_register_no = '$amb_reg'"
//                    ." AND am_sc.scd_amb_shift = $sht ";
        $sql = "SELECT am_sc.*"
            . " FROM ems_ambulance AS amb"
            . " LEFT JOIN ems_ambulance_schedule AS am_sc ON ( am_sc.scd_amb_rto_reg_id = amb.amb_rto_register_no )"
            . " WHERE scdis_deleted = '0'"
            . " AND amb.amb_rto_register_no = '$amb_reg'"
            . " AND am_sc.scd_amb_shift = $sht";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_amb_default_emp_shift($amb_reg, $sht, $tm_team_date) {
        

            $sql = '';

                $from = $tm_team_date;
                $to = $tm_team_date;
        //        $condition .= " AND tm.tm_team_date BETWEEN '$from' AND '$to 23:59:59'";

                $sql = "SELECT tm.*"
                    . " FROM ems_amb_default_team AS tm"
                    . " WHERE tm.tmis_deleted = '0'"
                    . " AND tm.tm_amb_rto_reg_id = '$amb_reg'"
                    . " AND tm.tm_shift = $sht "
                    . " AND  tm.tm_team_date BETWEEN '$from' AND '$to'";


                $result = $this->db->query($sql);
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_amb_default_emp($amb_reg, $sht, $tm_team_date = '') {

        $from = $tm_team_date;
        $to = $tm_team_date;
//        $condition .= " AND tm.tm_team_date BETWEEN '$from' AND '$to 23:59:59'";

        $sql = "SELECT tm.*"
            . " FROM ems_amb_default_team AS tm"
            . " WHERE tm.tmis_deleted = '0'"
            . " AND tm.tm_amb_rto_reg_id = '$amb_reg'"
            //. " AND tm.tm_shift = $sht "
            . " AND  tm.tm_team_date BETWEEN '$from' AND '$to'";
//        var_dump($sql);

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_chief_comp_service($cm_id, $limit = '', $offset = '') {
        //var_dump($cm_id);die;
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_patient_complaint_types");

        if ($cm_id != "") {

            $this->db->where("$this->tbl_mas_patient_complaint_types.ct_id", $cm_id);
        }

        $this->db->where("$this->tbl_mas_patient_complaint_types.ct_status", '1');
        $this->db->where("$this->tbl_mas_patient_complaint_types.ctis_deleted", '0');

        $data = $this->db->get();
// echo $this->db->last_query();
        $result = $data->result();
        return $result;
    }

    function get_feedback_id($cm_id, $limit = '', $offset = '') {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_patient_complaint_types");

        if ($cm_id != "") {

            $this->db->where("$this->tbl_mas_patient_complaint_types.ct_id", $cm_id);
        }

        $this->db->where("$this->tbl_mas_patient_complaint_types.ct_status", '1');
        $this->db->where("$this->tbl_mas_patient_complaint_types.ctis_deleted", '0');

        $data = $this->db->get();
// echo $this->db->last_query();
        $result = $data->result();
        return $result;
    }

    function get_chief_comp_service_by_name($cm_name) {


        $sql = "SELECT comp.ct_id"
            . " FROM $this->tbl_mas_patient_complaint_types AS comp"
            . " WHERE comp.ct_status = '1'"
            . " AND comp.ctis_deleted = '0'"
            . " AND comp.ct_type = '$cm_name' ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_mci_nature_service($cm_id) {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_micnature");

        if ($cm_id != "") {

            $this->db->where("$this->tbl_mas_micnature.ntr_id", $cm_id);
        }

        $this->db->where("$this->tbl_mas_micnature.ntr_status", '1');
        $this->db->where("$this->tbl_mas_micnature.ntris_deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function insert_ems_summary($args = array()) {

        $result = $this->db->insert($this->tbl_ems_summary, $args);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    function get_inc_summary($args) {

        if ($args['inc_ref_id']) {
            $condition = " AND sum.sum_sub_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['inc_type']) {
            $condition .= " AND sum.sum_sub_type='" . $args['inc_type'] . "' ";
        }


        $sql = "SELECT sum.*,ques.*"
            . " FROM $this->tbl_ems_summary AS sum"
            . " LEFT JOIN  $this->tbl_mas_questionnaire AS ques ON ( ques.que_id = sum.sum_que_id )"
            . " WHERE sum.sumis_deleted = '0' $condition group by sum.sum_que_id limit 0,8";

//        $sql;
//        die();
        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    //To add quality questions in single record
    function get_inc_audit_summary($inc_audit_args) {

        if($inc_audit_args['inc_ref_id'] != ''){
        if ($inc_audit_args['inc_ref_id']) {
            $condition = " AND inc_ref_id='" . $inc_audit_args['inc_ref_id'] . "' ";
        }

        $sql = "SELECT * FROM ems_quality_audit  WHERE is_deleted = '0' $condition";

        $result = $this->db->query($sql);

        //print_r($result->result());die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
        }
    }
     function get_am_in_inc_area_here($lat = "", $lng = "", $am_tp, $min_distance = '',$inc_status = '',$district_id = '') {
        
        $tm_team_date = date('Y-m-d');

        $sft_id = '';

        $shift_time = explode(":", date('H:i:s'));

        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {

            $sft_id = 3;

        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {

            $sft_id = 1;

        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {

            $sft_id = 2;

        }


        if ($am_tp != '' && $am_tp != 'undefined' && !empty($am_tp)) {

            $am_cond = "AND amb.amb_type IN ($am_tp)";

        }

         if ($district_id != '') {

            //$am_cond .= "AND amb.amb_district IN ($district_id)";

        }


        if ($min_distance != '' && $min_distance != 'defult distance') {

            $having_distance = "  HAVING distance < $min_distance ";

            $limit = "";

        } else {

             //$having_distance = "  HAVING distance < 100 ";

			 $having_distance = "  ";

            // $limit = " limit 5 ";

            $limit = "";

        }

      
        if ($lat != '' && $lng != '') {

            $radius = ", ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( amb.amb_lat ) ) * cos( radians( amb.amb_log ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( amb.amb_lat ) ) ) ) AS distance";

            $orderby = "ORDER BY distance ASC";

             $limit = " limit 30 ";

                

        }else{

            $having_distance = "";

            $orderby = "";

            $limit = " limit 30 ";

        }

        

          $sql = "SELECT amb.amb_id,amb.amb_user_type, amb.amb_type,amb.amb_status,amb.amb_rto_register_no, amb.amb_lat,amb.gps_amb_lat, amb.amb_log,amb.gps_amb_log, amb.amb_default_mobile,amb.amb_pilot_mobile, hp.hp_id, hp.hp_name,hp.hp_lat,hp.hp_long,tm.tm_id,tm.tm_pilot_id,tm.tm_emt_id,amb_ty.ambt_name,amb_staus.ambs_name,hp.geo_fence,amb.pilot_nm"

            . "$radius"

            . " FROM ems_ambulance AS amb"

            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"

            . " LEFT JOIN ems_amb_default_team AS tm ON ( tm.tm_amb_rto_reg_id = amb.amb_rto_register_no )"

            . " LEFT JOIN ems_mas_ambulance_type AS amb_ty ON ( amb_ty.ambt_id = amb.amb_type )"

            . " LEFT JOIN ems_mas_ambulance_status AS amb_staus ON ( amb_staus.ambs_id = amb.amb_status )"

            . " WHERE ambis_deleted = '0'"

            . " $amb_status "

            //. " AND amb_status IN (1,2,3,6) "

           // ." AND tm.tm_team_date = '$tm_team_date'"

            . " $am_cond"

             //." HAVING distance < 5 ORDER BY distance"

            //. "  Group by amb.amb_rto_register_no $having_distance ORDER BY amb_user_type,amb_ty.ambu_level ASC $limit";

            . "  Group by amb.amb_rto_register_no $having_distance $orderby $limit";
			

			

        $result = $this->db->query($sql);

        $results = $result->result_array();



        if (!empty($results)) {

            return $results;

        } else {

            return false;

        }
    }
    /* MI13 == get ambulance in incident area */

    function get_am_in_inc_area($lat = "", $lng = "", $am_tp = array(), $min_distance = '',$inc_status = '',$district_id = '',$thirdparty='',$amb_id='') {

      //  var_dump($thirdparty);die();
        $this->clg = $this->session->userdata('current_user');
        $tm_team_date = date('Y-m-d');
        $sft_id = '';
        $shift_time = explode(":", date('H:i:s'));
        if ($shift_time[0] >= 0 && $shift_time[0] <= 6) {
            $sft_id = 3;
        }if ($shift_time[0] >= 6 && $shift_time[0] <= 16) {
            $sft_id = 1;
        }if ($shift_time[0] >= 16 && $shift_time[0] <= 23) {
            $sft_id = 2;
        }
        if($amb_id !=''){
            $condition .= " AND amb.amb_rto_register_no = '".$amb_id."'  ";
        }
        $tm_team_date = date('Y-m-d');
        if ($thirdparty != '') {
            //$condition .= " AND amb.thirdparty IN ($thirdparty) AND app_lg.status = '1'";
            //$condition .= " AND amb.thirdparty IN ($thirdparty) AND tm.tm_team_date = '$tm_team_date'";
            $condition .= " AND amb.thirdparty IN ($thirdparty)";
        }else{
           // $condition .= "AND (amb.thirdparty = '1' OR (amb.thirdparty = '2' AND app_lg.status = '1') ) ";
             $condition .= "AND (amb.thirdparty = '1' OR amb.thirdparty = '6' OR (amb.thirdparty = '2' AND app_lg.status = '1') OR (amb.thirdparty = '3' AND app_lg.status = '1') OR (amb.thirdparty = '4'AND app_lg.status = '1')) ";
        }

//                if($am_tp != '' && $am_tp != 'undefined'){  
//                    //$am_cond = " AND amb.amb_type = $am_tp";
//                    $sql    =   "SELECT ems_mas_ambulance_type.ambu_level FROM ems_mas_ambulance_type WHERE ambt_id='$am_tp'";
//                    
//                    
//                    $result = $this->db->query($sql); 
//                    $amb_level = $result->result();
//                    $amb_level_no = $amb_level[0]->ambu_level;
//                    
//                    $sql    =   "SELECT ems_mas_ambulance_type.ambt_id FROM ems_mas_ambulance_type WHERE ambu_level BETWEEN $amb_level_no AND 6";
//                    
//                    
//                    $result = $this->db->query($sql); 
//                    $amb_level = $result->result();
//                    
//                           $que_level = array(1);
//                            foreach ($amb_level as $level){
//                                  
//                                $que_level[] = $level->ambt_id ;
//                            }
//                            $level = implode("','", $que_level);
//                            $am_cond = "AND amb.amb_type IN ('$level')";
//                }
       
        if ($am_tp != '' && $am_tp != 'undefined' && !empty($am_tp)) {
            $am_cond = "AND amb.amb_type IN ($am_tp)";
        }
        if ($district_id != '' && $district_id != '0') {
            $am_cond .= " AND amb.amb_district IN ($district_id)";
        }
        
        if($this->clg->clg_group == 'UG-ERO-102'){
            $am_cond .= " AND amb.amb_user IN ('102')";
        }
         if($this->clg->clg_group == 'UG-BIKE-ERO'){
            $am_cond .= " AND amb.amb_user IN ('bike')";
        }
        if($this->clg->clg_group == 'UG-ERO' || $this->clg->clg_group == 'UG-REMOTE'){
            $am_cond .= " AND amb.amb_user  IN ('108')";
        }

//         if ($district_id != '') {
//
//            $am_cond .= " AND amb.amb_district IN ($district_id)";
//
//        }

        if ($min_distance != '' && $min_distance != 'defult distance') {

            $having_distance = "  HAVING distance < $min_distance ";

            $limit = "";

        } else {

             //$having_distance = "  HAVING distance < 100 ";

			 $having_distance = "  ";

            // $limit = " limit 5 ";

            $limit = "";

        }


        if ($lat != '' && $lng != '') {

            $radius = ", ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( amb.amb_lat ) ) * cos( radians( amb.amb_log ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( amb.amb_lat ) ) ) ) AS distance";

            $orderby = "ORDER BY distance ASC";

             $limit = " limit 30 ";

                

        }else{

            $having_distance = "";

            $orderby = "";

            $limit = " limit 30 ";

                

        }
        
       
        if($inc_status == ''){
              if($amb_id !=''){
                  $amb_status =  " AND amb_status IN ('1','2','3') ";
              }else{
                $amb_status =  " AND amb_status IN ('1','3') ";
              }
        }else{
            $amb_status =  " AND amb_status IN ($inc_status) ";
        }

        $sql = "SELECT app_lg.status,app_lg.clg_id as app_clg_id,amb.thirdparty,amb.amb_district,amb.ward_name,wrd.ward_name as mumbai_wrd_nm,amb.ward_name,amb.amb_id,amb.amb_user_type, amb.amb_type,amb.amb_status,amb.amb_rto_register_no, amb.amb_lat,amb.gps_amb_lat, amb.amb_log,amb.gps_amb_log, amb.amb_default_mobile,amb.amb_pilot_mobile, hp.hp_id, hp.hp_name,hp.hp_lat,hp.hp_long,tm.tm_id,tm.tm_pilot_id,tm.tm_emt_id,amb_ty.ambt_name,amb_staus.ambs_name,hp.geo_fence,amb.pilot_nm"

            . "$radius"

            . " FROM ems_ambulance AS amb"

            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"

            . " LEFT JOIN ems_amb_default_team AS tm ON ( tm.tm_amb_rto_reg_id = amb.amb_rto_register_no )"

            . " LEFT JOIN ems_mas_ambulance_type AS amb_ty ON ( amb_ty.ambt_id = amb.amb_type )"

            . " LEFT JOIN ems_mas_ambulance_status AS amb_staus ON ( amb_staus.ambs_id = amb.amb_status )"

            . " LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id "

            . " LEFT JOIN ems_app_login_session as app_lg ON amb.amb_rto_register_no = app_lg.vehicle_no "

            . " WHERE ambis_deleted = '0'"

            . " $amb_status $condition"

           // . " AND amb_status Not IN ('2') "

           // ." AND tm.tm_team_date = '$tm_team_date'"

            . " $am_cond"

             //." HAVING distance < 5 ORDER BY distance"

            //. "  Group by amb.amb_rto_register_no $having_distance ORDER BY amb_user_type,amb_ty.ambu_level ASC $limit";

            . "  Group by amb.amb_rto_register_no $having_distance $orderby $limit";
       // echo $sql;
       // die();
        $result = $this->db->query($sql);
        $results = $result->result();

        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }
    }

    function get_fire_user($sr_id, $user_group) {

        $this->db->select('*');
        $this->db->from("$this->tbl_colleague");
        $this->db->where("$this->tbl_colleague.clg_group", $user_group);
        $this->db->where("$this->tbl_colleague.clg_senior", $sr_id);
        $this->db->where("$this->tbl_colleague.clg_is_deleted", '0');
        $this->db->where("$this->tbl_colleague.clg_is_active", '1');
        $this->db->where("$this->tbl_colleague.clg_is_login", 'yes');
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $data = $this->db->get();
        $result = $data->result();

        if (empty($result)) {
            $this->db->select('*');
            $this->db->from("$this->tbl_colleague");
            $this->db->where("$this->tbl_colleague.clg_group", $user_group);
            $this->db->where("$this->tbl_colleague.clg_is_deleted", '0');
            $this->db->where("$this->tbl_colleague.clg_is_active", '1');
            $this->db->where("$this->tbl_colleague.clg_is_login", 'yes');
            $this->db->order_by('rand()');
            $this->db->limit(1);
            $data = $this->db->get();
            $result = $data->result();
        }
        //echo $this->db->last_query();
        return $result[0];
    }
    function get_situational_desk_user($sr_id, $user_group){

        $this->db->select('*');
        $this->db->from("$this->tbl_colleague");
        $this->db->where("$this->tbl_colleague.clg_group", $user_group);
        $this->db->where("$this->tbl_colleague.clg_senior", $sr_id);
        $this->db->where("$this->tbl_colleague.clg_is_deleted", '0');
        $this->db->where("$this->tbl_colleague.clg_is_active", '1');
        $this->db->where("$this->tbl_colleague.clg_is_login", 'yes');
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $data = $this->db->get();
        $result = $data->result();

        if (empty($result)) {
            $this->db->select('*');
            $this->db->from("$this->tbl_colleague");
            $this->db->where("$this->tbl_colleague.clg_group", $user_group);
            $this->db->where("$this->tbl_colleague.clg_is_deleted", '0');
            $this->db->where("$this->tbl_colleague.clg_is_active", '1');
            $this->db->where("$this->tbl_colleague.clg_is_login", 'yes');
            $this->db->order_by('rand()');
            $this->db->limit(1);
            $data = $this->db->get();
            $result = $data->result();
        }
        //echo $this->db->last_query();
        return $result[0];
    }
    function get_situational_desk_list_calls(){
        $sql = "SELECT * FROM ems_situational_call_details ";
           ;
      //echo $sql;
            $result = $this->db->query($sql);


        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_situational_call_detials($args = array()) {

        $condition = "";

        if ($args['base_month'] != '') {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if ($args['inc_ref_id']) {

            $condition .= " AND inc.inc_ref_id='" . trim($args['inc_ref_id']) . "' ";
        }


       /* $sql = "SELECT * "
            . "FROM  $this->tbl_cls as cl, $this->tbl_clrs as clr ,$this->tbl_inc as inc "
            . " LEFT JOIN $this->tbl_problem_reporting_calls as prcl on (prcl.rcl_inc_ref_id=inc.inc_ref_id) "
            . "WHERE    inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id  AND inc.incis_deleted='0' $condition ORDER BY inc.inc_id DESC ";
        */
        $sql = "SELECT inc.*,cls.*,clr.*,rel.*,mn.*,ero_remark.re_name,call_pur.pname,clg.clg_first_name,clg.clg_last_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN  $this->tbl_mas_relation  AS rel ON ( cls.clr_ralation = rel.rel_id  )"
            . "LEFT JOIN  $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"
            . " LEFT JOIN  ems_mas_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . " LEFT JOIN ems_colleague AS clg ON ( clg.clg_ref_id = inc.inc_added_by )"
            . " WHERE inc.incis_deleted = '0'  $condition GROUP BY inc.inc_ref_id";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_user_by_group($user_group) {

        $this->db->select('*');
        $this->db->from("$this->tbl_colleague");
        $this->db->where("$this->tbl_colleague.clg_group", $user_group);
        $this->db->where("$this->tbl_colleague.clg_is_deleted", '0');
        $this->db->where("$this->tbl_colleague.clg_is_active", '1');
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $data = $this->db->get();
        $result = $data->result();
        return $result[0];
    }
    function get_inc_details_ref_id_driver_para($args)
    {
        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        
        $sql = "SELECT inc.* , driver_para.*,epcr.* "
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_driver_parameters as driver_para ON driver_para.incident_id =inc.inc_ref_id "
            . " LEFT JOIN $this->tbl_epcr AS epcr ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " WHERE  inc.inc_duplicate ='No'  $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inc_details($args) {
        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
        if (isset($args['base_month']) && $args['base_month'] != '') {

            $condition .= "AND inc.inc_base_month IN (" . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        $sql = "SELECT inc.*,inc_amb.*,clg_emt.clg_emso_id,clg_emt.clg_last_name,clg_emt.clg_mid_name,clg_emt.clg_first_name,clg_pilot.clg_last_name as pilot_lastnm,clg_pilot.clg_mid_name as pilot_midnm,clg_pilot.clg_first_name as pilot_firstnm,inc_ptn.ptn_id,amb.amb_type as ambulance_type,amb.amb_district,dst.dst_name as dst_name,amb_type.ambt_name,cl_purpose.pcode,cl_purpose.pname"
        
            . " FROM $this->tbl_incidence AS inc"
            
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON ( inc_amb.inc_ref_id = inc.inc_ref_id )"
            
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            
            . " LEFT JOIN  $this->mas_patient_complaint_types AS inc_com ON ( inc_com.ct_id = inc.inc_complaint )"
            
           // . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"

            . " LEFT JOIN ems_mas_ambulance_type AS amb_type ON ( amb_type.ambt_id = amb.amb_type)"

            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            // . " LEFT JOIN ems_mas_ambulance_type AS dst ON ( amb_district.ambt_id = amb.amb_district )"

            . " LEFT JOIN ems_mas_districts AS dst ON ( dst.dst_code = inc.inc_district_id )"

            . " LEFT JOIN   $this->tbl_colleague as clg_emt ON  (clg_emt.clg_ref_id = inc_amb.amb_emt_id )"
            . " LEFT JOIN   $this->tbl_colleague as clg_pilot ON  (clg_emt.clg_ref_id = inc_amb.amb_pilot_id )"
            . " WHERE 1=1 $condition GROUP BY amb_rto_register_no";

        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die();
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_details_mul_amb($args) {
        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' GROUP BY inc.inc_ref_id";
        }

        $sql = "SELECT inc.*,inc_amb.*,inc_ptn.ptn_id,hp.hp_name,clg.clg_first_name,clg.clg_last_name"
            . " FROM  $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON ( inc_amb.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_amb as amb  ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
            . " LEFT JOIN $this->tbl_clg as clg ON inc_amb.amb_emt_id = clg.clg_ref_id"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE 1=1 $condition GROUP BY inc_amb.amb_rto_register_no";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_details_ref_id($args) {

        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' ";
        }
      if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['inc_type'] != '' && $args['inc_type'] != 'all') {
            
            $inc_type = $args['inc_type'];
            $condition .= " AND inc.inc_type = '$inc_type' ";
        }

         $sql = "SELECT inc.*,inc_ptn.ptn_id,ptn.*,cls.*,clr.*,rel.*,mn.*,ems_cl_type.cl_name,call_pur.pname,clg.clg_first_name,clg.clg_last_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  ems_mas_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . " LEFT JOIN $this->tbl_non_eme_calls AS ems_calls ON ( ems_calls.ncl_inc_ref_id = inc.inc_ref_id  AND ems_calls.nclis_deleted = '0')"
            . " LEFT JOIN $this->tbl_non_eme_call AS ems_cl_type ON ( ems_cl_type.cl_code = ems_calls.ncl_call_type  )"
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN  $this->tbl_mas_relation  AS rel ON ( cls.clr_ralation = rel.rel_id  )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"
            . " LEFT JOIN ems_colleague AS clg ON ( clg.clg_ref_id = inc.inc_added_by )"
            . " WHERE 1=1 $condition GROUP BY inc.inc_ref_id";


        $result = $this->db->query($sql);
// var_dump($result);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_call_details_ref_id($args) {

        $condition = " ";
     // var_dump($args);die;
        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
         if ($args['system']) {
            $condition = " AND inc.inc_system_type='" . $args['system'] . "' ";
        }
        

        if ($args['operator_id']) {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' ";
        }
        
        if ($args['inc_type'] != '' && $args['inc_type'] != 'all') {
            
            $inc_type = $args['inc_type'];
            $condition .= " AND inc.inc_type = '$inc_type' ";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

         $sql = "SELECT inc.*,cls.*,clr.*,rel.*,mn.*,ero_remark.re_name,call_pur.pname,clg.clg_first_name,clg.clg_last_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN  $this->tbl_mas_relation  AS rel ON ( cls.clr_ralation = rel.rel_id  )"
            . "LEFT JOIN  $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"
            . " LEFT JOIN  ems_mas_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . " LEFT JOIN ems_colleague AS clg ON ( clg.clg_ref_id = inc.inc_added_by )"
            . " WHERE inc.incis_deleted IN ('0')  $condition GROUP BY inc.inc_ref_id";


        $result = $this->db->query($sql);
// var_dump($result);
     //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_inc_call_details_ref_id1($args) {

        $condition = " ";

        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' ";
        }

        if ($args['clg_group']!= '' && $args['clg_group'] != 'all_clg') {
            $condition .= " AND clg.clg_group='" . $args['clg_group'] . "' ";
        }
        
        if ($args['inc_type'] != '' && $args['inc_type'] != 'all') {
            
            $inc_type = $args['inc_type'];
            $condition .= " AND inc.inc_type = '$inc_type' ";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        $sql = "SELECT  count(inc.inc_ref_id) as inc_count "
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN  $this->tbl_colleauge  AS clg ON ( clg.cl_ref_id = inc.added_by  )"
            . " LEFT JOIN  $this->tbl_mas_relation  AS rel ON ( cls.clr_ralation = rel.rel_id  )"
            . "LEFT JOIN  $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"
            . " WHERE inc.incis_deleted = '0'  $condition GROUP BY inc.inc_ref_id";


        $result = $this->db->query($sql);
// var_dump($result);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_ref_id($args) {

        if ($args['inc_ref_id'] != "") {
            $condition = "  AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id'] !=  "") {
            $condition .= " AND op.operator_id='" . $args['operator_id'] . "' ";
        }

         $sql = "SELECT inc.*,cl.cl_purpose as purpose"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_calls AS cl ON ( cl.cl_id = inc.inc_cl_id )"  
            . " WHERE 1=1   $condition GROUP BY inc.inc_ref_id";

        $result = $this->db->query($sql);
 
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_sugg_amb_type($args) {

        if ($args) {
            $condition = " AND ambt_id = '" . $args['inc_suggested_amb'] . "'  ";
        }
        $sql = "SELECT *"
            . " FROM $this->tbl_mas_amb_type "
            . " WHERE ambtis_deleted = '0' $condition";


        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_purpose_call($args) {

        if ($args) {
            $condition = " AND pcode = '" . $args['pcode'] . "'  ";
        }
        $sql = "SELECT *"
            . " FROM $this->tbl_call_purpose "
            . " WHERE pis_deleted = '0' $condition";


        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_state_id($state) {

        if ($state) {
            $condition = " AND st.st_name SOUNDS LIKE '" . $state . "' ";
        }
        $sql = "SELECT st.st_code"
            . " FROM ems_mas_states AS st"
            . " WHERE st.stis_deleted = '0' $condition";


        $results = $this->db->query($sql);

        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }

    function get_state_name($state) {

        if ($state) {
            $condition = " AND st.st_code = '" . $state['st_code'] . "'  ";
        }
        $sql = "SELECT st.*"
            . " FROM ems_mas_states AS st"
            . " WHERE st.stis_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_district_id($district, $state) {
        if ($district) {
            $condition = " AND dst.dst_name SOUNDS LIKE '" . $district . "' ";
        }
        if ($state) {
            $condition .= " AND st.st_code = '$state'";
        }

        $sql = "SELECT dst.dst_code"
            . " FROM ems_mas_districts AS dst"
            . " LEFT JOIN ems_mas_states AS st ON ( dst.dst_state = st.st_code )"
            . " WHERE dst.dstis_deleted = '0' $condition";

        $results = $this->db->query($sql);

        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }

    function get_district_name($state = array()) {

        if ($state['dst_code'] != '') {
            $condition = " AND dst.dst_code = '" . $state['dst_code'] . "'  ";
        }

        if ($state['st_code'] != '') {
            $condition .= " AND st.st_code = '" . $state['st_code'] . "'  ";
        }
        if ($state['district_id'] != '') {

            $condition .= " AND dst.dst_code IN ('" . $state['district_id'] . "')  ";

        }

        if ($state['div_id'] != '') {

            $condition .= " AND dst.div_id IN ('" . $state['div_id'] . "')  ";

        }
        if ($state['div_code'] != '') {

            $condition .= " AND dst.div_id = '" . $state['div_code'] . "'  ";

        }


        $sql = "SELECT dst.*"
            . " FROM ems_mas_districts AS dst"
            . " LEFT JOIN ems_mas_states AS st ON ( dst.dst_state = st.st_code )"
            . " WHERE dst.dstis_deleted = '0' $condition";
      


        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }
    
    function get_tahshil($args) {

        if ($args) {
            $condition = " AND tahshil.thl_id = '" . $args['thl_id'] . "'  ";
        }

        $sql = "SELECT tahshil.*"
            . " FROM $this->tbl_tahshil AS tahshil"
            . " WHERE tahshil.thlis_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_city_id($city, $district_id, $state_id = '') {
        if ($city) {
            $condition = " AND ct.cty_name SOUNDS LIKE '" . $city . "' ";
        }
        if ($district_id) {
            $condition .= " AND ct.cty_dist_code = '" . $district_id . "' ";
        }

        $sql = "SELECT ct.cty_id"
            . " FROM ems_mas_city AS ct"
            . " LEFT JOIN ems_mas_districts AS dst ON ( dst.dst_code = ct.cty_dist_code )"
            . " WHERE ct.ctyis_deleted = '0' $condition";

        $results = $this->db->query($sql);

        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }

    function get_city_name($args) {

        if ($args) {
            $condition = " AND ct.cty_id = '" . $args['cty_id'] . "'  ";
        }

        if ($args) {
            $condition .= " AND ct.cty_dist_code = '" . $args['dst_code'] . "'  ";
        }

        $sql = "SELECT ct.*"
            . " FROM ems_mas_city AS ct"
            . " LEFT JOIN ems_mas_districts AS dst ON ( dst.dst_code = ct.cty_dist_code )"
            . " WHERE ct.ctyis_deleted = '0' $condition";


        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }
function get_inc_details_API($args)
    {
        $condition .= "inc_ref_id='" . $args . "'";
        $sql = "SELECT inc.* FROM $this->tbl_incidence as inc"
                . " where  $condition ";
                $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {

            return $result->result();

        } else {

            return false;

        }
    }
    function get_ambulance_details_API($args)
    {
        //var_dump($args);die();
        $condition .= "AND amb_rto_register_no='" . $args . "'";
        $sql = "SELECT amb.*, wrd.ward_id,wrd.ward_name, hp.hp_id, hp.hp_name FROM $this->tbl_ambulance as amb"
                . " LEFT JOIN ems_mas_ward AS wrd ON ( wrd.ward_id = amb.ward_name ) "
                . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location ) "
                . " where ambis_deleted='0' $condition ";
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {

            return $result->result();

        } else {

            return false;

        }
    }
    function get_amb_details($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if (isset($args['amb_id'])) {
            $condition .= "AND amb_id='" . $args['amb_id'] . "'";
        }

        if (isset($args['mob_no']) && $args['mob_no'] != '') {
            $condition .= "AND amb_default_mobile='" . $args['mob_no'] . "'";
        }

        if (isset($args['rg_no']) && $args['rg_no'] != '') {
            $condition .= "AND amb_rto_register_no='" . $args['rg_no'] . "'";
        }

        if (isset($args['district']) && $args['district'] != '') {
            $condition .= "AND amb_district='" . $args['district'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT amb.* ,amb_ty.ambt_name,amb_staus.ambs_name FROM $this->tbl_amb as amb"
            . " LEFT JOIN  $this->tbl_mas_amb_type  AS amb_ty ON ( amb_ty.ambt_id = amb.amb_type )"
            . " LEFT JOIN ems_mas_ambulance_status AS amb_staus ON ( amb_staus.ambs_id = amb.amb_status ) "
            . " where ambis_deleted='0' $condition $offlim ";



        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    /* get previous incident in nearer area */

    function get_pre_inc_area($args) {

        $order = "inc.inc_datetime";
        if (isset($args['comp_tp']) || $args['inc_type'] == 'non-mci') {
            $selct = ",comp.ct_type";
            $tables = ", $this->tbl_mas_patient_complaint_types as comp ";
            $condition = " AND (comp.ct_id = inc.inc_complaint) AND inc.inc_complaint = ".$args['comp_tp'];
            $order = "inc.inc_complaint";
        }
        if (isset($args['nature_id']) || $args['inc_type'] == 'mci') {
            $selct = ",nature.ntr_nature";
            $tables = ", $this->tbl_mas_micnature as nature ";
            $condition = " AND (nature.ntr_id = inc.inc_mci_nature) AND inc.inc_mci_nature  =".$args['nature_id'] ;
            $order = "inc.inc_mci_nature";
        }
        if (!empty($args['lat']) && !empty($args['lng'])) {
            $distance = ", ( 6372.797 * acos( cos( radians( " . $args['lat'] . " ) ) * cos( radians( inc.inc_lat ) ) * cos( radians( inc.inc_long ) - radians( " . $args['lng'] . " ) ) + sin( radians( " . $args['lat'] . " ) ) * sin( radians( inc.inc_lat ) ) ) ) AS distance";
            $distance_having = " HAVING distance < " . $args['distance'];
        }
        $current_date = date('Y-m-d');
        $condition .= " AND inc.inc_datetime BETWEEN '$current_date 00:00:00' AND '$current_date 23:59:59'";

        $sql = "SELECT inc.*,cl.*,clr.* $selct $distance"
            . " FROM $this->tbl_incidence AS inc,$this->tbl_cls as cl,$this->tbl_clrs as clr $tables"
            . " WHERE (inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") AND inc.inc_base_month = cl.cl_base_month "
            . " AND inc.inc_cl_id = cl.cl_id AND cl.cl_clr_id = clr.clr_id) AND (inc.inc_type ='" . $args['inc_type'] . "') AND inc.incis_deleted ='0' AND inc.inc_pcr_status ='0' $condition"
            . " $distance_having ORDER BY $order limit 5";
      
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_ambulance($args) {
      // var_dump($args);die;
        if ($args['inc_ref_id']) {
            $condition = " inc_amb.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if (isset($args['rg_no']) && $args['rg_no'] != '') {
            $condition .= " amb.amb_rto_register_no='" . $args['rg_no'] . "'";
        }


        $sql = "SELECT inc_amb.*,wrd.ward_name,inc_amb.amb_type as inc_amb_type,inc_amb.amb_type as assign,hp.*,amb.amb_default_mobile,amb.pilot_nm,amb.amb_pilot_mobile,amb.amb_lat,amb.amb_log,amb.amb_type,amb_ty.ambt_name,amb_staus.ambs_name,amb.amb_status"
            . " FROM $this->tbl_incidence_ambulance AS inc_amb"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_mas_ambulance_type AS amb_ty ON ( amb_ty.ambt_id = amb.amb_type )"
            . " LEFT JOIN ems_mas_ambulance_status AS amb_staus ON ( amb_staus.ambs_id = amb.amb_status )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . "LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id "
            . " WHERE $condition GROUP BY amb.amb_rto_register_no";
     // die();


        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_fourwheeler_ambulance($args) {

        if ($args['inc_ref_id']) {
            $condition = " inc_amb.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if (isset($args['rg_no']) && $args['rg_no'] != '') {
            $condition .= " amb.amb_rto_register_no='" . $args['rg_no'] . "'";
        }


        $sql = "SELECT inc_amb.*,hp.*,amb.amb_default_mobile,amb.amb_lat,amb.amb_log,amb.amb_type"
            . " FROM $this->tbl_incidence_ambulance AS inc_amb"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " WHERE $condition AND amb.amb_type='4' GROUP BY amb.amb_rto_register_no";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_ambulance_details($args) {

        if (isset($args['rg_no']) && $args['rg_no'] != '') {
            $condition .= " amb.amb_rto_register_no='" . $args['rg_no'] . "'";
        }


        $sql = "SELECT hp.*,amb.amb_rto_register_no,amb.amb_default_mobile"
            . " FROM ems_ambulance AS amb"
// . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " WHERE $condition GROUP BY amb.amb_rto_register_no";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_total_by_month($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['inc_type'] != '' && $args['inc_type'] != 'all') {
            
            $inc_type = $args['inc_type'];
            $condition .= " AND inc.inc_type = '$inc_type' ";
        }

        $sql = "SELECT inc.*,inc_ptn.ptn_id,ptn.ptn_fullname,ptn.ptn_age,clr.clr_fullname,clr.clr_mobile,dist.dst_name,clg_emt.clg_emso_id,cheif.ct_type,inc_amb.amb_rto_register_no,epcr.provider_impressions"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN   $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN   $this->tbl_colleague as clg_emt ON  (clg_emt.clg_ref_id = inc_amb.amb_emt_id )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN  $this->tbl_epcr  AS epcr ON ( epcr.ptn_id = ptn.ptn_id  )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE $condition AND inc_amb.amb_status='assign' GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";


        $result = $this->db->query($sql);
       //echo $this->db->last_query();die;
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_inc_total($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['incis_deleted'] != '') {
            $isdelete = $args['incis_deleted'];
            $condition .= " AND inc.incis_deleted = '$isdelete'";
        }
         if ($args['system'] != '' && $args['system'] != 'all' ) {
            $system =$args['system'];
            $condition .= " AND inc.inc_system_type = '$system'";
        }

        $sql = "SELECT count(inc.inc_ref_id) as total_calls FROM $this->tbl_incidence as inc Where $condition"; 

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }
        function get_inc_call_type_total($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
         if ($args['system'] != '' ) {
            $system =$args['system'];
            $condition .= " AND inc.inc_system_type = '$system'";
        }
        

         $sql = "select  pur.pname as call_purpose,count(inc_ref_id) as total_call from ems_incidence as inc left join ems_incidence_patient as inc_ptn on (inc.inc_ref_id = inc_ptn.inc_id) LEFT JOIN ems_mas_call_purpose as pur on (inc.inc_type=pur.pcode)  Where inc.incis_deleted = '0' $condition group by pur.pcode";
    

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_active_inc_total($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT count(inc.inc_ref_id) as total_calls FROM $this->tbl_incidence as inc Where inc.incis_deleted = '0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_active_inc_by_cluster($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        if (isset($args['cluster_id']) && $args['cluster_id'] != '') {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND amb.cluster_id IN ($cluster_id)";
        }
        $sql = "SELECT count(inc.inc_ref_id) as total_calls FROM $this->tbl_incidence as inc LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_amb AS amb ON (inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . "  Where inc.incis_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_all_report_by_date($args = array()) {


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['base_month'] != '') {
            $condition .= " AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        $sql = "SELECT inc.inc_ref_id as inc_id,inc.incis_deleted,inc.inc_ero_summary as summary,inc.inc_district_id,inc.inc_datetime,inc.inc_dispatch_time,inc.inc_cl_id,clr.clr_fullname,clr.clr_mobile,cheif.ct_type,op.operator_id,inc_amb.amb_rto_register_no as transport_amb_no,hp.hp_name as transport_amb,ptn.ptn_fullname as patient_name,ptn.ptn_age as patient_age"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN   $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE  op.operator_type = 'UG-ERO' $condition  GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";

//           $sql =   "SELECT inc.inc_ref_id,inc.incis_deleted,inc.inc_ero_summary,inc.inc_district_id,inc.inc_datetime,inc.inc_dispatch_time,inc.inc_cl_id"
//                    . " FROM $this->tbl_incidence AS inc"
//                    . " WHERE $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC limit 0,100";



        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_dispatch_inc_question_by_report($args = array(), $offset = '', $limit = '') 
    {
        $condition = $offlim = '';




        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";

        }

        if ($filter != '') {

            $order_by = "ORDER BY $filter ASC";

        } else {

            $order_by = "ORDER BY inc.inc_datetime ASC";

        }

        if ($sortby['inc_date'] != "") {

            $date = $sortby['inc_date'];
            $sortby_sql = " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";

        }
        if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
           
     }

        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";

        }



        $sql = "SELECT *"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL')  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";
      
    $result = $this->db->query($sql);
 // echo $this->db->last_query();die;
        if ($args['get_count']) {

            return $result->num_rows();

        } else {

            return $result->result();

        }

    }
    
    function get_dispatch_inc_by_report($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['operator_id']) {
            $condition = " AND op.operator_id='" . $args['operator_id'] . "'";
        }
         if($args['thirdparty'] != '' && $args['thirdparty'] != '1' && $args['thirdparty'] != '5' ){

               // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
               $condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
              
        }
         if($args['thirdparty'] == '5' ){

               // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
               $condition .=  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' ";
               
              
        }


        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime ASC";
        }

        if ($sortby['amb_reg_id'] != "") {
            $amb = trim($sortby['amb_reg_id']);
            $sortby_sql = " AND inc_amb.amb_rto_register_no LIKE '%$amb%'";
        }
        if ($sortby['district_id'] != "") {
            $sortby_sql = " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
        }
        if ($sortby['hp_id'] != "") {
            $sortby_sql = " AND amb.amb_base_location = '" . $sortby['hp_id'] . "'";
        }

        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql = " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql = " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }

        if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND inc.inc_system_type = '" . $args['system'] . "'";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT *,wrd.*,inc_amb.base_location_name,inc_amb.ward_name,hp.hp_name,wrd.ward_name as wrd_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN   $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN   ems_mas_micnature  AS mci_nature ON (mci_nature.ntr_id = inc.inc_mci_nature )"
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN ems_mas_ward AS wrd ON ( wrd.ward_id = amb.ward_name )"
            . " LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN   $this->tbl_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . " LEFT JOIN  $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP','EMG_PVT_HOS') AND inc_amb.amb_status = 'assign' $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";

       //echo $sql;
        //die();


        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_other_inc_by_report($args = array(), $offset = '', $limit = '') {

        $condition = $offlim = '';

        if ($args['operator_id']) {
            $condition = " AND op.operator_id='" . $args['operator_id'] . "'";
        }

        if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
           
     }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime ASC";
        }

        if ($sortby['amb_reg_id'] != "") {
            $amb = trim($sortby['amb_reg_id']);
            $sortby_sql = " AND inc_amb.amb_rto_register_no LIKE '%$amb%'";
        }
        if ($sortby['district_id'] != "") {
            $sortby_sql = " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
        }
        if ($sortby['hp_id'] != "") {
            $sortby_sql = " AND amb.amb_base_location = '" . $sortby['hp_id'] . "'";
        }

        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql = " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql = " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }



        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND inc.inc_system_type = '" . $args['system'] . "'";
        }
         $sql = "SELECT inc.*,clr.clr_fullname,clr.clr_fname,clr.clr_lname,clr.clr_mobile,call_pur.pname,ero_remark.re_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN   $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . "LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . "LEFT JOIN   $this->tbl_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . "LEFT JOIN  $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb ='0' AND inc.inc_pcr_status = '0'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";
        


        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_inc_report_by_date($args = array()) {

        if ($args['base_month'] != '') {
            $condition .= "AND inc.inc_base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ")";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }


        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile, cheif.ct_type, op.operator_id"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
// . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS cheif ON (cheif.ct_id = inc.inc_complaint )"
//. " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
// . " LEFT JOIN $this->tbl_colleague as clg_emt ON (clg_emt.clg_ref_id = inc_amb.amb_emt_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";



        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_caller_by_inc($args = array()) {

        $condition = "";

        if ($args['cl_id'] != '') {
            $cl_id = $args['cl_id'];
            $condition .= "WHERE cls.cl_id = $cl_id";
        }


        $sql = "SELECT clr.clr_fullname, clr.clr_mobile"
            . " FROM $this->tbl_cls as cls "
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " $condition ";



        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_all_inc_by_date($args = array(), $offset = '', $limit = '') {
    //var_dump($args);die;
  
          if ($args['from_date'] != '' && $args['to_date'] != '') {
              $from = $args['from_date'];
              $to = $args['to_date'];
              $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59' ";
          }
          if($args['last_three_hours'] != ''){
            $condition .= "AND inc.inc_datetime >= DATE_SUB(NOW(),INTERVAL 3 HOUR) AND inc_type IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP')";
        }
        if($args['ero'] != '' && $args['ero'] != 'all'){
              $condition .= "AND  inc.inc_added_by = '" . $args['ero'] . "'";
        }
          if($args['user_id'] != '' && $args['user_id'] != 'all'){
            
            $condition .= "AND  inc.inc_added_by = '" . $args['user_id'] . "'";
             
            }  

       if($args['incis_deleted'] != ''){
            $condition .= "AND inc.incis_deleted = '" . $args['incis_deleted'] . "' ";
        }
          if($args['avaya'] != ''){
            $condition .= "AND clg_ero.clg_avaya_agentid = '" . $args['avaya'] . "' ";
        }
          $search1 = "";
       
        if ($args['call_search']) {
            
            $search1 .= " AND (clg_ero.clg_last_name LIKE '%" .trim($args['call_search']). "%' OR clg_ero.clg_first_name LIKE '%" . trim($args['call_search']). "%' OR clg_ero.clg_avaya_id LIKE '%" . trim($args['call_search']). "%' OR clg_ero.clg_avaya_agentid LIKE '%" . trim($args['call_search']). "%' OR inc.inc_ref_id='" . trim($args['call_search']) . "' OR dis.dst_name LIKE '%"  . trim($args['call_search']). "'  OR clr.clr_mobile LIKE '%" . trim($args['call_search']). "%'  ) ";
            
        }
        if ($args['call_purpose']!= '') {
            
            if($args['call_purpose'] != "all"){
               // echo $args['call_purpose'];die;
                $condition .= " AND inc.inc_type='" . $args['call_purpose'] . "' ";
            }
        }
        if ($args['team_type'] != '') {
            $condition .= " AND clg_ero.clg_group ='" . $args['team_type'] . "' ";
        }
         if ($args['base_month'] != '') {
            $condition .= "AND inc.inc_base_month IN ( " . $args['base_month'] . ")";
        }

        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }
  
// %Y %m %d

           $sql = "SELECT inc.inc_ref_id,dis.dst_name,inc.inc_type,cl_purpose.pname,clg_ero.clg_first_name,clg_ero.clg_group,clg_ero.clg_avaya_id,inc.inc_type, clg_ero.clg_last_name, clr.clr_mobile,clr.clr_fname,clr.clr_lname, inc.incis_deleted, inc.inc_ero_summary, inc.inc_district_id, inc.inc_datetime, inc.inc_dispatch_time, inc.inc_cl_id, inc.inc_added_by, inc.inc_complaint, inc.inc_pcr_status,inc.inc_avaya_uniqueid"
              . " FROM $this->tbl_incidence AS inc"
              . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON (cl_purpose.pcode = inc.inc_type )"
              . " LEFT JOIN $this->tbl_cls AS cl ON (inc.inc_cl_id = cl.cl_id )"
              . " LEFT JOIN $this->tbl_colleague as clg_ero ON (clg_ero.clg_ref_id = inc.inc_added_by )"
             // . " LEFT JOIN $this->tbl_colleague as clg_system ON (clg_ero.clg_group = inc.inc_added_by )"
              . " LEFT JOIN $this->tbl_clrs AS clr ON (clr.clr_id = cl.cl_clr_id )"
              . " LEFT JOIN $this->tbl_mas_districts AS dis ON (dis.dst_code = inc.inc_district_id )"
              . " WHERE 1=1  $condition $search1 ORDER BY inc.inc_datetime DESC $offlim";

        $result = $this->db->query($sql);



        $result = $this->db->query($sql);
     // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_all_inc_by_closure($args = array(), $offset = '', $limit = '') {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        
        if ($args['amb_district'] != '' ) {
             $condition .= " AND inc.inc_district_id IN ('".$args['amb_district']."')";
        }
        
        if ($offset >= 0 && $limit > 0) {

            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT inc.inc_ref_id,colleague.clg_first_name,colleague.clg_last_name, inc.incis_deleted, inc.inc_ero_summary, inc.inc_district_id, inc.inc_datetime, inc.inc_dispatch_time, inc.inc_cl_id, inc.inc_added_by, op.operator_id, inc.inc_complaint, inc.inc_pcr_status"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_colleague AS colleague ON ( colleague.clg_ref_id = inc.inc_added_by )"
            . " WHERE inc.inc_set_amb = '1'  $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC $offlim";
        //echo $sql;
        //die();


        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_all_inc($args=array()) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT inc.inc_ref_id"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE 1=1 $condition ORDER BY inc.inc_datetime DESC";


       // echo $sql;
       // die();
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_closure_pending_inc($args=array()) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT inc.inc_ref_id"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc_pcr_status = '0' AND inc_set_amb = '1' AND inc_ref_id != '' $condition ORDER BY inc.inc_datetime DESC";
        
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_all_dispatch_inc($args) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
         if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
        
         $sql = "SELECT inc.inc_ref_id"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('on_scene_care','MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CARE_CALL','PREGANCY_CALL','Child_CARE_CALL','DROP_BACK_CALL','Child_CARE','DROP_BACK','EMG_PVT_HOS') $condition ORDER BY inc.inc_datetime DESC";
     

//    if($_SERVER['REMOTE_ADDR']=='45.116.46.94'){
        //echo $sql;
       //die();
//    }
  
        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    
    function get_patient_report_by_date($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= "AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
//$condition .=  " AND STR_TO_DATE(`ems_epcr`.`date`, '%m/%d/%Y') BETWEEN '$from' AND '$to'";
        }
        if ($args['system']) {
            $condition .= " AND ems_epcr.system_type ='" . $args['system'] . "' ";
        }


        $sql = "SELECT ems_patient.*, inc.inc_ref_id, inc.inc_datetime, inc.inc_address, ems_epcr.rec_hospital_name,ems_epcr.other_receiving_host, ems_epcr.id as epcr_id, clr.clr_fullname, clr.clr_mobile FROM ems_incidence_patient Left JOIN ems_epcr ON ems_epcr.ptn_id = ems_incidence_patient.ptn_id LEFT JOIN ems_patient ON ems_patient.ptn_id = ems_incidence_patient.ptn_id LEFT JOIN ems_incidence as inc ON inc.inc_ref_id = ems_epcr.inc_ref_id LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id ) LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id ) WHERE inc.incis_deleted = '0' AND ems_patient.ptnis_deleted = '0' $condition  GROUP BY inc.inc_ref_id";

        $result = $this->db->query($sql);
//echo $this->db->last_query();die;
//            if($result){     
//                
//              return $result->result_array();        
//            }else{            
//              return false;
//            }
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_patient_epcr_report_by_date($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";

// $condition .=  " STR_TO_DATE(`epcr`.`date`, '%m/%d/%Y') BETWEEN '$from' AND '$to'";
        }
        
        if ($args['inc_ref_id']) {
            $condition .= " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        $sql = "SELECT inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, epcr.provider_impressions, epcr.rec_hospital_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_epcr AS epcr ON ( epcr.ptn_id = ptn.ptn_id )"
            . " WHERE inc.incis_deleted = '0' $condition GROUP BY inc_ptn.ptn_id ORDER BY inc.inc_datetime DESC";

         $sql = "SELECT epcr.provider_impressions, epcr.rec_hospital_name"
            . " FROM $this->tbl_epcr as epcr"
            . " LEFT JOIN $this->tbl_incidence AS inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " WHERE 1=1 $condition GROUP BY epcr.ptn_id ORDER BY epcr.inc_datetime DESC"; 

        $result = $this->db->query($sql);

        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_patient_by_provider_impression($args = array()){
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";

// $condition .=  " STR_TO_DATE(`epcr`.`date`, '%m/%d/%Y') BETWEEN '$from' AND '$to'";
        }
        
         if ($args['system'] != '' ) {
            $system =$args['system'];
            $condition .= " AND inc.inc_system_type = '$system'";
        }
          $sql = "SELECT count(epcr.provider_impressions) as total_imp,pro.pro_name FROM ems_epcr as epcr LEFT JOIN ems_mas_provider_imp AS pro ON ( epcr.provider_impressions = pro.pro_id ) LEFT JOIN $this->tbl_incidence AS inc ON ( epcr.inc_ref_id = inc.inc_ref_id )  WHERE epcr.epcris_deleted='0' $condition GROUP BY epcr.provider_impressions ORDER BY epcr.inc_datetime DESC";
        
      
          $result = $this->db->query($sql);
         // echo $this->db->last_query();
         // var_dump($result->result());

        if ($result) {

             return $result->result();
        } else {
            return false;
        }
    }

    function get_total_patient_count_by_month($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= "AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT count(inc_ptn.ptn_id) as pnt_count"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " WHERE inc.incis_deleted = '0' $condition GROUP BY inc_ptn.ptn_id ORDER BY inc.inc_datetime DESC";



        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_distance_report_by_date($args = array()) {
     //var_dump($args);die;
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= " AND inc.inc_datetime  BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['amb_reg_no'] != '') {
            $condition .= " AND amb.amb_rto_register_no = '" . $args['amb_reg_no'] . "'";
        }

        if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND amb.amb_user_type  = '" . $args['system'] . "'";
        }        
        
        $sql = "SELECT epcr.*, amb.amb_user FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
            . " LEFT JOIN $this->tbl_amb AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
            . " Where inc.incis_deleted = '0' $condition ORDER BY amb.amb_rto_register_no ";
        
//           $sql = "SELECT amb_tms.*,amb.amb_rto_register_no as amb_reg_id, amb.amb_user FROM $this->tbl_amb AS amb"
//            . " LEFT JOIN $this->tbl_ambulance_timestamp AS amb_tms ON (amb.amb_rto_register_no = amb_tms.amb_rto_register_no )"
//            . " Where amb.ambis_deleted  = '0' AND amb_tms.flag='1'  $condition ORDER BY amb.amb_rto_register_no ";
      
     
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_inc_ambu_for_report($args) {



        $inc_ref_id = $args['inc_ref_id'];

        $sql = "SELECT inc_amb.*, amb.amb_base_location, hp.hp_name"
            . " FROM $this->tbl_incidence_ambulance AS inc_amb"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " WHERE $condition inc_amb.inc_ref_id = '$inc_ref_id' GROUP BY inc_amb.amb_rto_register_no";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_inc_ambulance_for_report($args) {

        if ($args['inc_ref_id']) {
            $condition = " inc_amb.inc_ref_id = '" . $args['inc_ref_id'] . "' ";
        }
        if (isset($args['rg_no']) && $args['rg_no'] != '') {
            $condition .= " amb.amb_rto_register_no = '" . $args['rg_no'] . "'";
        }


        $sql = "SELECT inc_amb.*, hp.hp_name, hp.hp_type, hp.hp_status, amb.amb_default_mobile, amb.amb_lat, amb.amb_log, amb.amb_type, amb.amb_status, clg.clg_emso_id as clg_emso_id"
            . " FROM $this->tbl_incidence_ambulance AS inc_amb"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " WHERE $condition GROUP BY inc_amb.amb_rto_register_no";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_district_amb_details($args = array()) {
        //var_dump($args);die;
        // if (isset($args['district']) && $args['district'] != '') {
        //     if ($args['district'] == 'other') {
        //         $condition .= "AND amb.amb_district IN (30, 35, 10, 28, 3)";
        //     } else {
        //         $condition .= "AND amb.amb_district = '" . $args['district'] . "'";
        //     }
        // }
        if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND inc.inc_system_type = '" . $args['system'] . "' ";
        } 
        if ($args['incient_district'] != '') {
            $condition .= " AND amb.amb_district = '" . $args['incient_district'] . "' ";
        }  
        if ($args['district'] != '') {
            $condition .= " AND amb.amb_district = '" . $args['district'] . "' ";
        } 
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
//$condition .= "AND amb_tms.timestamp BETWEEN '$from' AND '$to 23:59:59'";
//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '%m/%d/%Y') BETWEEN '$from' AND '$to'";
        }


        $sql = "SELECT epcr.*, amb.amb_district as amb_district, amb.amb_rto_register_no as amb_rto_register_no FROM $this->tbl_epcr AS epcr "
            . " LEFT JOIN $this->tbl_amb AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " Where inc.incis_deleted = '0' $condition ORDER BY amb.amb_rto_register_no " ;

        $result = $this->db->query($sql);
      // echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }

    function get_district_by_id($district) {
        if ($district) {
            $condition = " AND dst.dst_code IN ($district)";
        }

        $sql = "SELECT dst.dst_name"
            . " FROM ems_mas_districts AS dst"
            . " WHERE dst.dstis_deleted = '0' $condition";

        $results = $this->db->query($sql);
          //echo $this->db->last_query($results);die;
        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }
    function get_division_district_by_id($district) {
        if ($district) {
            $condition = " AND dst.dst_code IN ($district)";
        }

        $sql = "SELECT divs.div_name"
            . " FROM ems_mas_districts AS dst"
            . " LEFT JOIN  ems_mas_division as divs ON (divs.div_code = dst.div_code)"
            . " WHERE dst.dstis_deleted = '0' $condition";

        $results = $this->db->query($sql);
          //echo $this->db->last_query($results);die;
        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }
    function get_amb_type($amb_no) {
        if ($amb_no) {
            $condition = " AND amb_rto_register_no IN ('$amb_no')";
        }

        $sql = "SELECT amb_type"
            . " FROM ems_ambulance "
            . " WHERE ambis_deleted = '0' $condition";

        $results = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }
    function get_city_by_id($city, $district_id) {

        if ($city) {
            $condition = " AND ct.cty_id IN ($city)";
        }
        if ($district_id) {
            $condition .= " AND ct.cty_dist_code = '" . $district_id . "' ";
        }

        $sql = "SELECT ct.cty_name"
            . " FROM ems_mas_city AS ct"
            . " WHERE ct.ctyis_deleted = '0' $condition";

        $results = $this->db->query($sql);

        if ($results) {
            $results = $results->result();
            return $results[0];
        } else {
            return false;
        }
    }

    function get_dst($args = array())
    {
        $sql= "Select  dst_code,dst_name FROM $this->tbl_mas_districts WHERE dst_state='MH'";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;

         if ($args['get_count']) {
             return $result->num_rows();
         } else {
             return $result->result();
         }
    }
    function get_epcr_by_month($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
            $date_format = '%m/%d/%Y';

//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            $condition .= "  AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND epcr.validate_date  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
         if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
           
     }

        if (isset($args['district']) && $args['district'] != '') {
            if ($args['district'] == 'other') {
                $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
            } else {
                $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            }
        }
        
       if ($args['system'] != '' && $args['system'] != 'all') {
        //var_dump($args['system']);
            $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        }
       
          $sql = "SELECT epcr.*,casetype.case_name,dist.dst_name,baseLoc.hp_name as baselocation,clr.clr_mobile,clr.clr_fname,clr.clr_lname,epcr.inc_ref_id as incident_id,epcr.date as closure_datetime,epcr.scene_odometer as scene_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,amb.amb_district,hp.hp_name,hp.hp_code, loc.level_type, hp.hp_id,inc.inc_added_by,pro_imp.pro_name,epcr.base_location_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,hp.hp_district,cl_pur.pname,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name,inc.inc_address"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_hp1 AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
            . " LEFT JOIN $this->tbl_amb  AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN $this->tbl_hp AS baseLoc ON ( baseLoc.hp_id = amb.amb_base_location )"
            . " LEFT JOIN ems_mas_districts AS dist ON ( dist.dst_code = epcr.district_id )"
            . " LEFT JOIN ems_mas_provider_casetype AS casetype ON ( casetype.case_id  = epcr.provider_casetype )"
            . " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0'  $condition ";
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
      // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_closure_responce_report($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
            $date_format = '%m/%d/%Y';

//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
         if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
           
     }

        if (isset($args['district']) && $args['district'] != '') {
            if ($args['district'] == 'other') {
                $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
            } else {
                $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            }
        }
        
       if ($args['system'] != '' && $args['system'] != 'all') {
        //var_dump($args['system']);
            $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        }
       
          $sql = "SELECT epcr.*,epcr.inc_ref_id as incident_id,epcr.date as closure_datetime,epcr.scene_odometer as scene_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,inc.inc_added_by,epcr.base_location_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
            
            . " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0'  $condition  group by inc.inc_ref_id";
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_unavailed_epcr_by_month($args) {
         //var_dump($args);die;
        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
            $date_format = '%m/%d/%Y';

//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
        //    $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= " AND epcr.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if (isset($args['district']) && $args['district'] != '') {
            if ($args['district'] == 'other') {
                $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
            } else {
                $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            }
        }
        
        if ($args['system'] != '' && $args['system'] != 'all' ) {
            $system =$args['system'];
            $condition .= " AND inc.inc_system_type = '$system'";
        }
        // if (($args['system'] != '') && ($args['system'] != "all")) {

        //     $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        // }
       
          $sql = "SELECT epcr.*,epcr.scene_odometer as scene_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,inc.inc_ref_id"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_hp1 AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
//            . " LEFT JOIN ems_ambulance_stock AS amb_stk ON ( amb_stk.as_sub_id = epcr.id)"
            . " WHERE epcr.provider_impressions IN ('21','41','42','43','44') $condition ";


        $result = $this->db->query($sql);
     //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_epcr_by_month_closure_datewise($args) {
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
           // $condition .= "  AND epcr.date BETWEEN '$from' AND '$to'";
            $condition .= " AND epcr.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";

        }
        if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
           
        }
        if (isset($args['district']) && $args['district'] != '') {
            if ($args['district'] == 'other') {
                $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
            } else {
                $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            }
        }
        
       if ($args['system'] != '' && $args['system'] != 'all') {
        //var_dump($args['system']);
            $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        }
        //$sql = "SELECT epcr.*,inc.inc_recive_time as inc_recive_time ,cl_pur.pname,inc.inc_type,hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,clr.*"

        $sql = "SELECT casetype.case_name,epcr.provider_casetype,epcr.added_date,epcr.provider_impressions,epcr.id as epcr_id,epcr.time as jctime,epcr.base_location_name,epcr.wrd_location,epcr.third_party,epcr.date as closure_date,epcr.remark,epcr.other_provider_img,epcr.start_odometer,epcr.end_odometer,epcr.rec_hospital_name,epcr.other_receiving_host,epcr.total_km,epcr.inc_ref_id as inc_reference_id,epcr.inc_datetime as inc_date,epcr.date,epcr.amb_reg_id,epcr.district_id,epcr.locality,loc.level_type,epcr.operate_by,epcr.end_odometer_remark,epcr.scene_odometer as scene_odo,epcr.hospital_odometer  as hospital_odo,hp.hp_name,hp.hp_code,hp.hp_id,hp.hp_district,cl_pur.pname,cl_pur.pname as inc_purpose, ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender,clr.clr_mobile,clr.clr_fname,clr.clr_lname,pro_imp.pro_name,inc.inc_added_by,epcr.inc_area_type,epcr.ercp_advice,epcr.ercp_advice_Taken,amb.amb_district,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_hp1 AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_amb  AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN ems_mas_provider_casetype  AS casetype ON (casetype.case_id = epcr.provider_casetype)"
            . " WHERE epcris_deleted = '0'  $condition ";
            //. " WHERE epcris_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";
        $result = $this->db->query($sql);

        // echo $this->db->last_query($result);die;

        if ($result) {

            return $result->result_array();

        } else {

            return false;

        }

    }
    function get_epcr_by_month_closure($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";

        }

        if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
           
     }
        if (isset($args['district']) && $args['district'] != '') {

            if ($args['district'] == 'other') {

                $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";

            } else {

                $condition .= " AND epcr.district_id = '" . $args['district'] . "'";

            }

        }
        //$sql = "SELECT epcr.*,inc.inc_recive_time as inc_recive_time ,cl_pur.pname,inc.inc_type,hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,clr.*"
        $sql = "SELECT epcr.provider_impressions,epcr.base_location_name,epcr.wrd_location,epcr.third_party,epcr.remark,epcr.other_provider_img,epcr.start_odometer,epcr.end_odometer,epcr.rec_hospital_name,epcr.other_receiving_host,epcr.total_km,epcr.inc_ref_id,epcr.inc_datetime,epcr.date,epcr.amb_reg_id,epcr.district_id,epcr.locality,loc.level_type,hp.hp_name,hp.hp_id,cl_pur.pname,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_gender,clr.clr_mobile,clr.clr_fname,clr.clr_lname,pro_imp.pro_name,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_hp1 AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " WHERE epcris_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";





        $result = $this->db->query($sql);

         // echo $this->db->last_query($result);die;

        if ($result) {

            return $result->result_array();

        } else {

            return false;

        }

    }
    function get_medical_b12_report($args) {
        //var_dump($args);die;
       if ($args['from_date'] != '' && $args['to_date'] != '') {

           $from = $args['from_date'];
           $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
           $date_format = '%m/%d/%Y';

           // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
          // $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
             $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
       }
       if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }

       if (isset($args['district']) && $args['district'] != '') {
           if ($args['district'] == 'other') {
               $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
           } else {
               $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
           }
       }
       $sql = "SELECT count(epcr.inc_ref_id) as total_count"
       . " FROM  $this->tbl_epcr as epcr"
    . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
    ." where epcr.provider_impressions IN ('1','3','4','5','7','16','17','18','19','20','22','25','26','27','28','29','30','31','32','37','38','39','47','48','49','51','52','53') AND epcris_deleted = '0' $condition ";
 $result = $this->db->query($sql);
  //echo $this->db->last_query($result);die;
  if ($args['get_count']) {
    return $result->num_rows();
} else {
    return $result->result();
}

   }
  
  
   function get_other_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

   // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
       $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
  // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' $condition ";

   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
       . " FROM $this->tbl_epcr as epcr "
        ." where epcr.provider_impressions IN ('21','35','36','45','46') AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_Accident_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

        //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
        $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
       $sql = "SELECT count(epcr.inc_ref_id) as total_count"
       . " FROM $this->tbl_epcr as epcr "
        ." where epcr.provider_impressions IN ('15','58') AND  epcr.epcris_deleted = '0' $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);
//die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_assault_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

    //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
       $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
       $sql = "SELECT count(epcr.inc_ref_id) as total_count"
       . " FROM $this->tbl_epcr as epcr "
        ." where epcr.provider_impressions IN ('6') AND epcr.epcris_deleted = '0' $condition ";
   $result = $this->db->query($sql);
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_labour_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

        //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to 23:59:59'";  
       $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('24','34') AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_assists_calls_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

       // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to 23:59:59'";  
         $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
       //$condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('11','12','75')  AND epcris_deleted = '0' $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_poision_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

        //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
        $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
     //  $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('13','23','50') AND epcris_deleted = '0' $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_birthinamb_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

        //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to 23:59:59'";  
        //$condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
  
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('11','12') AND  epcris_deleted = '0'  $condition ";
 $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_light_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

    //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
    $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    //   $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
  
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM  $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('55') AND  epcris_deleted = '0'  $condition ";
 $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_trauma_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
  $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
     //  $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }

    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM  $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('2','33') AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_traumanon_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

        //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
        $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
       //$condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM  $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('56') AND  epcris_deleted = '0' $condition ";
$result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_attack_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

       // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
         $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
      // $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
  
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('8','9','10') AND  epcris_deleted = '0' $condition ";
$result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_fall_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

   // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
      $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
      // $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
  
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM  $this->tbl_epcr as epcr"
        ." where epcr.provider_impressions IN ('54')  AND epcris_deleted = '0' $condition ";
$result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_suicide_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
  $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
       //$condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr"
        ." where epcr.provider_impressions IN ('40') AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_delivery_in_amb_b12_report($args){
//var_dump($args);die;
if ($args['from_date'] != '' && $args['to_date'] != '') {

    $from = $args['from_date'];
    $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
    $date_format = '%m/%d/%Y';

    //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
  $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    //$condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
}

if (isset($args['district']) && $args['district'] != '') {
    if ($args['district'] == 'other') {
        $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
    } else {
        $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
    }
 }
  if($args['system_type'] != ''){
          $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
    }
$sql = "SELECT count(epcr.inc_ref_id) as total_count"
. " FROM $this->tbl_epcr as epcr"
     ." where epcr.provider_impressions IN ('11','12')  AND epcris_deleted = '0'  $condition ";
$result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}
}
function get_pt_manage_on_veti_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
      // $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
    }
     if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('57')  AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_pt_manage_on_unavail_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
      // $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
    }
     if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ."where epcr.provider_impressions IN ('41','42','43','44')  AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}
function get_burn_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
       //$condition .= "  AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
    }
     if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM  $this->tbl_epcr as epcr"
        ." where epcr.provider_impressions IN ('14') AND epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

function get_mass_b12_report($args) {
    //var_dump($args);die;
   if ($args['from_date'] != '' && $args['to_date'] != '') {

       $from = $args['from_date'];
       $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
       $date_format = '%m/%d/%Y';

$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
     //  $condition .= "  AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
   }

   if (isset($args['district']) && $args['district'] != '') {
       if ($args['district'] == 'other') {
           $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
       } else {
           $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
       }
   }
    if($args['system_type'] != ''){
             $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
       }
   $sql = "SELECT count(epcr.inc_ref_id) as total_count"
   . " FROM $this->tbl_epcr as epcr "
        ." where epcr.provider_impressions IN ('56') AND  epcris_deleted = '0'  $condition ";
   $result = $this->db->query($sql);
//echo $this->db->last_query($result);die;
if ($args['get_count']) {
return $result->num_rows();
} else {
return $result->result();
}}

    function get_consumable_data_new($args) {
        $condition = '';

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND amb_stk.as_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";

        }
        $sql = "SELECT amb_stk.* "
            . " FROM ems_ambulance_stock AS amb_stk"
            . " WHERE 1=1 AND as_stk_in_out='out' AND as_sub_type='pcr' $condition ";
        $result = $this->db->query($sql);
         //echo $this->db->last_query();die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_consumable_data($args) {
        $condition = '';

        if ($args['as_item_type'] != '') {
            $condition .= " AND amb_stk.as_item_type = '" . $args['as_item_type'] . "' ";
        }
        if ($args['as_sub_id'] != '') {
            $condition .= " AND amb_stk.as_sub_id = '" . $args['as_sub_id'] . "' ";
        }

        $sql = "SELECT sum(amb_stk.as_item_qty) as count"
            . " FROM ems_ambulance_stock AS amb_stk"
            . " WHERE 1=1  $condition ";



        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_epcr_by_hourly($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') = '$from'";
        }
        if ($args['inc_type'] != '') {
            $inc_type = $args['inc_type'];
            $condition .= " AND inc.inc_type = '$inc_type' ";
        }


        $sql = "SELECT epcr.*, hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fullname, inc.inc_datetime as inc_date"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " WHERE epcr.base_month IN (" . ($args['base_month'] - 1) . ", " . $args['base_month'] . ") AND epcris_deleted = '0' $condition ";

        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function NHM1_get_patient_report_by_date($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }


        $sql = "SELECT epcr.*, hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fullname, inc.inc_datetime as inc_date"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " WHERE epcris_deleted = '0' $condition ";
        //echo $sql;
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_consumable_list() {
        /*
          $sql = "SELECT epcr.* FROM $this->tbl_epcr AS epcr "
          . " LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id )"
          . " LEFT JOIN $this->tbl_amb AS amb ON (epcr.amb_reg_id = amb.amb_rto_register_no )"
          . " Where amb.amb_type = '1' AND inc.incis_deleted = '0' $condition ORDER BY amb.amb_rto_register_no ";
          // echo $sql;
         */

        $sql = "select * from $this->tbl_inventory AS inv";
        //echo $sql;
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_ambulance_list() {
        $sql = "select * from ems_ambulance where ambis_deleted = '0' AND amb_user_type='108'";
        //echo $sql;
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_all_inc_report_by_date($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile, dist.dst_name, clg_emt.clg_emso_id, cheif.ct_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_colleague as clg_emt ON (clg_emt.clg_ref_id = inc_amb.amb_emt_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_eme_inc_report_by_date($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile, dist.dst_name, clg_emt.clg_emso_id, cheif.ct_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_colleague as clg_emt ON (clg_emt.clg_ref_id = inc_amb.amb_emt_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.inc_type IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP','EMG_PVT_HOS') AND $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
        //echo $sql;
        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    
    function get_eme_inc_report_NHM5($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        
        if ($args['inc_system_type'] != '' ) {
            $system = $args['inc_system_type'];
            $condition .= "AND amb.amb_user_type  = '$system'";
        }
        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " WHERE inc.inc_type IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP','EMG_PVT_HOS')  $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
       // echo $sql;
       // die();
        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
        function get_noneme_inc_report_NHM6($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
          
        if ($args['inc_system_type'] != '' ) {
            $system = $args['inc_system_type'];
            $condition .= " AND inc.inc_system_type = '$system'";
        }
        $sql = "SELECT inc.*,  clr.clr_fullname, clr.clr_mobile"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " WHERE inc.inc_type NOT IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP')  $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
       // echo $sql;
       // die();
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        //var_dump($result);
       // die();
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_noneme_inc_report_by_date($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile, dist.dst_name, clg_emt.clg_emso_id, cheif.ct_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_colleague as clg_emt ON (clg_emt.clg_ref_id = inc_amb.amb_emt_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.inc_type NOT IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP') AND $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
        //echo $sql;
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_EMT_Data() {

        $sql = "select clg_emt.*,dist.dst_name from $this->tbl_colleague as clg_emt"
        . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = clg_emt.clg_district_id )"
        ." where clg_emt.clg_group = 'UG-EMT'";

        $result = $this->db->query($sql);
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_Onroadoffroad_Data($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= "amb_timestamp.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $sql = "select amb_timestamp.* from $this->tbl_ambulance_timestamp as amb_timestamp where $condition";
    
      

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function insert_sms_response($args = array()) {

        $result = $this->db->insert($this->tbl_sms_response, $args);
       // echo $this->db->last_query();die;

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    function get_inc_sms_response($inc_ref_id) {
        
        if($inc_ref_id != ""){
            $condition = " AND sms.inc_ref_id = '$inc_ref_id'";
        }

        $sql = "select sms.* from $this->tbl_sms_response as sms where 1=1 $condition";

        $result = $this->db->query($sql);
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_amb_status_summary_date($args) {
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= "AND status_summary.on_road_date BETWEEN '$from' AND '$to'";
        }
        if ($args['amb_status']) {
            $amb_status = $args['amb_status'];
            $condition .= " AND status_summary.amb_status IN ($amb_status)";
        }
        
        if ($args['system']) {
            $system = $args['system'];
            $condition .= " AND amb.amb_user_type = '$system'";
        }

        if ($args['district_code']) {
            $amb_status = $args['district_code'];
            $condition .= " AND amb.amb_district = '$amb_status'";
        }



         $sql = "select status_summary.*, hp.hp_name,dist.dst_name,amb.amb_type,amb_type.ambt_name from $this->tbl_ambulance_status_summary as status_summary LEFT JOIN $this->tbl_amb As amb ON (status_summary.amb_rto_register_no = amb.amb_rto_register_no) LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = amb.amb_district ) LEFT JOIN ems_mas_ambulance_type AS amb_type ON (amb_type.ambt_id = amb.amb_type ) where 1=1 $condition";
      
         
        
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
        function get_amb_offroad_summary_date($args) {
        
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];

            $condition .= "AND status_summary.on_road_date BETWEEN '$from' AND '$to'";
        }
        if ($args['amb_status']) {
            $amb_status = $args['amb_status'];
            $condition .= " AND status_summary.amb_status IN ($amb_status)";
        }

        if ($args['district_code']) {
            $amb_status = $args['district_code'];
            $condition .= " AND amb.amb_district = '$amb_status'";
        }



         $sql = "select status_summary.*, hp.hp_name,dist.dst_name,amb.amb_type,amb_type.ambt_name from $this->tbl_ambulance_status_summary as status_summary LEFT JOIN $this->tbl_amb As amb ON (status_summary.amb_rto_register_no = amb.amb_rto_register_no) LEFT JOIN $this->tbl_hp as hp ON (amb.amb_base_location = hp.hp_id) LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = amb.amb_district ) LEFT JOIN ems_mas_ambulance_type AS amb_type ON (amb_type.ambt_id = amb.amb_type ) where 1=1 $condition";

        
        $result = $this->db->query($sql);
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_epcr_by_date_group_inc($args = array(), $offset = '', $limit = '') {

        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';

            $condition .= " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        if ($args['operator_id']) {
            $condition .= " AND epcr.operate_by='" . $args['operator_id'] . "' ";
        }

        if ($args['rec_hospital_name']) {
            $rec_hospital_name = $args['rec_hospital_name'];
            $condition .= " AND epcr.rec_hospital_name = '$rec_hospital_name'";
        }

        $sql = " SELECT epcr.* FROM ems_epcr AS epcr WHERE epcris_deleted = '0' $condition GROUP BY epcr.inc_ref_id";


        $result = $this->db->query($sql);

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_epcr_by_group($args = array(), $offset = '', $limit = '') {

        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';

            $condition .= " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";
        }
        if ($offset >= 0 && $limit > 0) {

            $offlim .= "limit $limit offset $offset ";
        }

        // if ($args['team_type']) {
        //     if($args['team_type'] != "all"){
        //         $condition .= "  ";
        //     }
        // }

        if ($args['call_purpose']) {
            if($args['call_purpose'] != "all"){
                $condition .= " AND inc.inc_type='" . $args['call_purpose'] . "' ";
            }
        }
        if ($args['operator_id']) {
            $condition .= " AND epcr.operate_by='" . $args['operator_id'] . "' ";
        }
        if ($args['inc_ref_id']) {
            $condition .= " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['rec_hospital_name']) {
            $rec_hospital_name = $args['rec_hospital_name'];
            $condition .= " AND epcr.rec_hospital_name = '$rec_hospital_name'";
        }

        $sql = " SELECT epcr.*,inc.inc_added_by,clr.*,cl_purpose.* FROM ems_epcr AS epcr LEFT JOIN $this->tbl_incidence AS inc ON ( inc.inc_ref_id = epcr.inc_ref_id )"
            
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id ) WHERE epcris_deleted = '0' $condition GROUP BY epcr.inc_ref_id";


        $result = $this->db->query($sql);
        //echo $this->db->last_query(); die;

        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }

    function get_epcr_by_cluster($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            $condition .= " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";
        }
        if ($args['rec_hospital_name']) {
            $rec_hospital_name = $args['rec_hospital_name'];
            //var_dump($rec_hospital_name);
            if ($rec_hospital_name == 'sickroom')
                $condition .= " AND epcr.rec_hospital_name IN ('$rec_hospital_name', '0','on_scene_care')";
        }
        if (isset($args['cluster_id']) && $args['cluster_id'] != '') {
            $cluster_id = $args['cluster_id'];
            $condition .= " AND amb.cluster_id IN ($cluster_id)";
        }

        $sql = "SELECT epcr.* FROM ems_epcr AS epcr LEFT JOIN $this->tbl_amb As amb ON (epcr.amb_reg_id = amb.amb_rto_register_no) WHERE epcris_deleted = '0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_ambulance_min_odometer($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND amb_tm.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['to_date'] != '') {
            $to = $args['to_date'];
            $condition .= " AND amb_tm.timestamp <= '$to 23:59:59'";
        }
        if ($args['amb_reg_no'] != '') {
            $condition .= " AND amb_tm.amb_rto_register_no = '" . $args['amb_reg_no'] . "'";
        }

        $sql = "SELECT MIN(start_odmeter) as start_odmeter FROM $this->tbl_ambulance_timestamp AS amb_tm"
            . " LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = amb_tm.amb_rto_register_no )"
            . " where amb.ambis_deleted = '0' and amb_tm.flag ='1' $condition ORDER BY amb_tm.timestamp ";


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_ambulance_max_odometer($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];


            $condition .= " AND amb_tm.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['to_date'] != '' && !isset($args['from_date'])) {
            $to = $args['to_date'];
            $condition .= " AND amb_tm.timestamp <= '$to 23:59:59'";
        }
        if ($args['amb_reg_no'] != '') {
            $condition .= " AND amb_tm.amb_rto_register_no = '" . $args['amb_reg_no'] . "'";
        }

         $sql = "SELECT MAX(end_odmeter) as end_odmeter FROM $this->tbl_ambulance_timestamp AS amb_tm"
            . " LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = amb_tm.amb_rto_register_no )"
            . " where amb.ambis_deleted = '0' and amb_tm.flag ='1' $condition ORDER BY amb_tm.timestamp ";
       
        


        $result = $this->db->query($sql);

        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_ambulance_odometer_count($args) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];


            $condition .= " AND amb_tm.timestamp BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['to_date'] != '' && !isset($args['from_date'])) {
            $to = $args['to_date'];
            $condition .= " AND amb_tm.timestamp <= '$to 23:59:59'";
        }
        if ($args['amb_reg_no'] != '') {
            $condition .= " AND amb_tm.amb_rto_register_no = '" . $args['amb_reg_no'] . "'";
        }

         $sql = "SELECT end_odmeter FROM $this->tbl_ambulance_timestamp AS amb_tm"
            . " LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = amb_tm.amb_rto_register_no )"
            . " where amb.ambis_deleted = '0' $condition ORDER BY amb_tm.timestamp ";
       
        


        $result = $this->db->query($sql);

        if ($result) {
             return $result->num_rows();
        } else {
            return false;
        }
    }

    function get_all_inc_dash_by_date($args = array()) {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile, dist.dst_name, clg_emt.clg_emso_id, cheif.ct_type"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_ambulance as amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " WHERE inc.incis_deleted = '0' $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";

        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_total_eme_calls() {

        $condition = $offlim = '';

        if ($args['inc_added_by']) {
            $condition = " AND inc.inc_added_by='" . $args['inc_added_by'] . "'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT *"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CALL','DROP_BACK','Child_CARE_CALL','EMG_PVT_HOS') AND $condition  GROUP BY inc.inc_ref_id $order_by  ";

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_total_noneme_calls($args = array()) {

        $condition = $offlim = '';

        if ($args['inc_added_by']) {
            $condition = " AND inc.inc_added_by='" . $args['inc_added_by'] . "'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT *"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' AND inc_type IN ('ABUSED_CALL','APP_CALL','AMB_NOT_AVA','CHILD_CALL','DEMO_CALL','DISS_CON_CALL','DUP_CALL','AMB_TO_ERC','ENQ_CALL','ESCALATION_CALL','FOLL_CALL','GEN_ENQ','MISS_CALL','NO_RES_CALL','NUS_CALL','SERVICE_NOT_REQUIRED','SLI_CALL','SUGG_CALL','TEST_CALL','UNATT_CALL','WRONG_CALL') $condition  GROUP BY inc.inc_ref_id $order_by  ";
    

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_total_all_calls($args =array()) {

        $condition = $offlim = '';

        if ($args['inc_added_by']) {
            $condition = " AND inc.inc_added_by='" . $args['inc_added_by'] . "'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        

        $sql = "SELECT *"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1'  AND $condition  GROUP BY inc.inc_ref_id $order_by  ";

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_total_by_call_type_closure($args =array()){
        // var_dump($args);die;
        $condition = $offlim = '';

        if (trim($args['inc_added_by'])) {
            if (trim($args['inc_added_by']) != "all") {
            $inc_added_by=trim($args['inc_added_by']);
            $condition .= " AND epcr.operate_by='" .$inc_added_by. "'";
            }
        }
        if (trim($args['user_id']) != '' &&$args['user_id'] != "all" ) {
            $inc_added_by=trim($args['user_id']);
            $condition .= " AND epcr.operate_by='" .$inc_added_by. "'";
        }
        if (trim($args['system']) != "all_clg" && trim($args['system']) != "") {
            $system=trim($args['system']);
            $condition .= " AND colleague.clg_group = '" . $system . "'";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND epcr.date BETWEEN '$from' AND '$to'";
        }
        
         if ($args['inc_type']) {
            $condition .= " AND inc.inc_type IN ('" . $args['inc_type'] . "')";
         }
        
        if ($args['base_month'] != '') {
            $condition .= "AND epcr.base_month IN ( " . $args['base_month'] . ")";
         }
        // $sql='SELECT * FROM ems_epcr where epcris_deleted = "0" AND operate_by ="'.$clg_ref_id.'" '.$where.' AND DATE(STR_TO_DATE(`date`,"%m/%d/%Y")) = CURRENT_DATE ';
        $sql = "SELECT epcr.*, colleague.clg_group "
            . " FROM ems_epcr  AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON (inc.inc_ref_id = epcr.inc_ref_id)"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = epcr.operate_by )"
            . " WHERE epcr.epcris_deleted = '0'  $condition   $order_by  ";

        $result = $this->db->query($sql);
        // print_r($args);die;
        // return $result;
    //// echo $this->db->last_query(); 
    // die;  
        if ($args['get_count']) {
            // print_r($result->num_rows());die;
            return $result->num_rows();
        } else {
            return $result->result();
        }

    }
    function get_total_by_call_type($args =array()) {
   // var_dump($args);die;
        $condition = $offlim = '';

        if (trim($args['inc_added_by'])) {
            if (trim($args['inc_added_by']) != "all") {
            $inc_added_by=trim($args['inc_added_by']);
            $condition .= " AND inc.inc_added_by='" .$inc_added_by. "'";
            }
        }

       // var_dump($args);

            if (trim($args['user_id']) != '' &&$args['user_id'] != "all" ) {
                
                    $inc_added_by=trim($args['user_id']);
                    $condition .= " AND inc.inc_added_by='" .$inc_added_by. "'";
            }
            if (trim($args['system']) != "all_clg" && trim($args['system']) != "") {
                $system=trim($args['system']);
                $condition .= " AND colleague.clg_group = '" . $system . "'";
                
            }
  
        // if ($args['inc_system_type']) {
        //     $condition .= " AND inc.inc_system_type IN ('" . $args['inc_system_type'] . "')";
        // }
        

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        
         if ($args['inc_type']) {
            $condition .= " AND inc.inc_type IN ('" . $args['inc_type'] . "')";
         }
        
        if ($args['base_month'] != '') {
            $condition .= "AND inc.inc_base_month IN ( " . $args['base_month'] . ")";
         }

        $sql = "SELECT inc.*, colleague.clg_group "
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )"
            . " WHERE inc.incis_deleted = '0'  $condition  GROUP BY inc.inc_ref_id $order_by  ";

        $result = $this->db->query($sql);
        // print_r($args);die;
        // return $result;
     //echo $this->db->last_query(); die;  
        if ($args['get_count']) {
            // print_r($result->num_rows());die;
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function get_total_by_call_type_inc($args =array()) {
        //var_dump($args);
        $condition = $offlim = '';

        if (trim($args['inc_added_by'])) {
            $inc_added_by=trim($args['inc_added_by']);
            $condition .= " AND inc.inc_added_by='" .$inc_added_by. "'";
        }

        if (trim($args['user_id'])) {
            $inc_added_by=trim($args['user_id']);
            $condition .= " AND inc.inc_added_by='" .$inc_added_by. "'";
        }
        if (trim($args['inc_ref_id'])) {
            $inc_ref_id=trim($args['inc_ref_id']);
            $condition .= " AND inc.inc_ref_id='" .$inc_ref_id. "'";
        }
        if (trim($args['is_pda_inc'])) {
            $is_pda_inc=trim($args['is_pda_inc']);
            $condition .= " AND inc.is_pda_inc='" .$is_pda_inc. "'";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
         if ($args['system'] != '' && $args['system'] != 'all' ) {
            $system =$args['system'];
            $condition .= " AND inc.inc_system_type = '$system'";
        }
        
        if ($args['inc_type']) {
            $condition .= " AND inc.inc_type IN ('" . $args['inc_type'] . "')";
        }
        
        if ($args['base_month'] != '') {
            //$condition .= "AND inc.inc_base_month IN ( " . (int)$args['base_month'] . " ," . (int)$args['base_month'] - 1 . "," . (int)$args['base_month'] - 2 . ")";
         }

           $sql = "SELECT inc.inc_ref_id,inc.inc_datetime,inc.inc_recive_time,inc.CADIncidentID"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' $condition  GROUP BY inc.inc_ref_id";
        
      
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_master_report($args =array()){
         $condition = $offlim = '';
       //var_dump($args);
        if ($args['inc_added_by'] != '' && $args['inc_added_by'] != 'all') {
            $condition .= " AND inc.inc_added_by='" . $args['inc_added_by'] . "'";
        }

        if ($args['team_type'] != '' && $args['team_type'] != 'all') {
            $condition .= " AND inc.inc_system_type='" . $args['team_type'] . "'";
        }
        // if ($args['team_type'] != '' && $args['team_type'] != 'all') {
        //     $condition .= " AND clg.clg_group ='" . $args['team_type'] . "' ";
        // }
        if ($args['user_id'] != '' ) {
            if ($args['inc_added_by'] != 'all' )
            $condition .= " AND inc.inc_added_by='" . $args['user_id'] . "'";
        }
         if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){

            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            $condition .=  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
           
     }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        
        if ($args['inc_type'] != '' && $args['inc_type'] != 'all') {
            $condition .= " AND inc.inc_type IN ('" . $args['inc_type'] . "')";
        }
          if ($args['base_month'] != '') {
              //$condition .= "AND inc.inc_base_month IN ( " . (int)$args['base_month'] . " ," . (int)$args['base_month'] - 1 . "," . (int)$args['base_month'] - 2 . ")";
             $condition .= " AND inc.inc_base_month IN ( " . ($args['base_month']-1) . "," . $args['base_month'] . ")";
         }
        

//         $sql = "SELECT *"
//            . " FROM $this->tbl_incidence AS inc "
//            . " WHERE inc.incis_deleted = '0' $condition  GROUP BY inc.inc_ref_id  ";
         
            
            $sql = "SELECT inc.*,epcr.provider_casetype,casetype.case_type,inc_amb.ward_name,amb.amb_default_mobile,amb.amb_pilot_mobile,std_remark.re_name,inc_amb.base_location_name,clr.clr_fullname,clr.clr_fname,clr.clr_lname,epcr.other_receiving_host,epcr.other_provider_img,epcr.scene_odometer as scene_odo,epcr.hospital_odometer  as hospital_odo,epcr.remark,epcr.ercp_advice,epcr.ercp_advice_Taken, clr.clr_mobile,cl.clr_ralation,cl.cl_purpose,amb.amb_rto_register_no, ptn.ptn_gender, ptn.ptn_age, ptn.ptn_age_type,ptn.ptn_district,ptn.ptn_fname,ptn.ptn_lname,in_fa.rpt_doc,in_fa.new_rpt_doc,in_fa.mo_no,in_fa.new_mo_no,in_fa.new_district,in_fa.current_district,in_fa.facility,in_fa.new_facility,amb.amb_type,amb.amb_base_location,amb.amb_working_area,epcr.provider_impressions,driv_pcr.inc_dispatch_time,driv_pcr.inc_dispatch_time,driv_pcr.start_from_base,driv_pcr.start_odometer,driv_pcr.end_odometer,driv_pcr.dp_on_scene,driv_pcr.dp_reach_on_scene,driv_pcr.dp_cl_from_desk,driv_pcr.dp_hand_time,driv_pcr.dp_hosp_time,driv_pcr.dp_back_to_loc,epcr.rec_hospital_name,inc_amb.amb_pilot_id,inc_amb.amb_emt_id,epcr.date,epcr.operate_by,inc.inc_dispatch_time as call_duration,epcr.emso_id,epcr.emt_name,epcr.emt_id_other,epcr.pilot_id,epcr.pilot_name,epcr.pilot_id_other"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
           // . " LEFT JOIN $this->tbl_colleague AS clg ON (inc.inc_added_by = clg.clg_ref_id )"
            . " LEFT JOIN $this->tbl_ambulance as amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
           // . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = ptn.ptn_district  )"
            . " LEFT JOIN $this->tbl_inter_facility AS in_fa ON ( in_fa.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_epcr  AS epcr ON ( inc.inc_ref_id = epcr.inc_ref_id  )"
            . " LEFT JOIN ems_mas_case_type AS casetype ON (epcr.provider_casetype = casetype.case_id  )"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN ems_mas_ero_remark AS std_remark ON ( std_remark.re_id = inc.inc_ero_standard_summary)"
            // . " LEFT JOIN $this->tbl_colleague AS clg_ercp ON (clg_ercp.clg_ref_id = epcr.ercp_advice_Taken )"
          //  . " LEFT JOIN $this->tbl_inc_add_advice AS ercp ON ( ercp.adv_cl_inc_id = inc.inc_ref_id)"
            . " WHERE inc.incis_deleted IN ('0','3') $condition group by inc_ptn.ptn_id, inc.inc_ref_id ORDER BY inc.inc_datetime DESC";

      
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    
    function get_district_patient_served( $args = array()) {

        $condition = $offlim = '';
        // var_dump($args);die;
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['system']) {
            $condition .= " AND inc.inc_system_type IN ('".$args['system']."')";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['to_date'] != '' && $args['from_date'] == '') {
           // $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime <= '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' $condition ";
      
     $result = $this->db->query($sql);
    //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_dist_pta_patient_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id)LEFT JOIN ems_ambulance as amb on (epcr.amb_reg_id=amb.amb_rto_register_no) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0'AND amb.amb_type = '2' $condition ";
      
     $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_dist_bls_patient_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id)LEFT JOIN ems_ambulance as amb on (epcr.amb_reg_id=amb.amb_rto_register_no) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0'AND amb.amb_type = '3' $condition ";
      
     $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_dist_als_patient_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id)LEFT JOIN ems_ambulance as amb on (epcr.amb_reg_id=amb.amb_rto_register_no) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0'AND amb.amb_type = '4' $condition ";
      
     $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_dist_hosp_patient_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' AND inc.inc_type = 'IN_HO_P_TR' $condition ";
      
     $result = $this->db->query($sql);
   //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_dist_other_patient_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' AND inc.inc_type IN ('MCI','AD_SUP_REQ','NON_MCI','EMT_MED_AD','VIP_CALL','DROP_BACK','PREGANCY_CALL','Child_CARE_CALL') $condition ";
      
     $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_dist_drop_back_patient_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        if ($args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime <= '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' AND inc.inc_type  IN ('DROP_BACK','PREGANCY_CALL','Child_CARE_CALL') $condition ";
      
     $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_dist_drop_back_cl_received( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc where  inc.incis_deleted IN ('0','2','3')  AND inc.inc_type IN ('DROP_BACK','PREGANCY_CALL','Child_CARE_CALL') $condition ";
      
     $result = $this->db->query($sql);
   // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function insert_inc_enable_dispatch($args = array()) {

        $result = $this->db->insert($this->tbl_inc_enable_dispatch, $args);
       // echo $this->db->last_query();die;
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    function get_unable_to_dispatch_report( $args = array()) {

        $condition = $offlim = '';

        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['system']) {
            $condition .= " AND inc.inc_system_type IN ('".$args['system']."')";
        }

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }

        $sql = "SELECT inc.*,clr.*,drop_call.home_district_id  FROM ems_incidence as inc LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id ) LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id ) LEFT JOIN $this->tbl_back_drop_call as drop_call ON (drop_call.inc_ref_id=inc.inc_ref_id) where inc.incis_deleted = '3' $condition group by inc.inc_ref_id";
     

    
        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
    }
}
    function get_unable_to_dispatch_ambulace($inc_ref_id) {


           $sql = "SELECT en_dis.*,hp.hp_name "
            . " FROM $this->tbl_inc_enable_dispatch AS en_dis"
            ." LEFT JOIN $this->tbl_ambulance as amb ON (amb.amb_rto_register_no = en_dis.amb_reg_no )"
            . " LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id"
            . " WHERE en_dis.inc_ref_id = '$inc_ref_id' ";
      
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_closure_pending_ambulance_wise($args = array()){
        
        $condition = $offlim = '';
        
        if ($args['amb_reg_no']) {

            $condition .= " AND inc_amb.amb_rto_register_no = '".$args['amb_reg_no']."'";

        }


        $sql = "SELECT inc.inc_ref_id,inc.inc_datetime FROM ems_incidence as inc LEFT JOIN ems_incidence_ambulance as inc_amb on (inc.inc_ref_id=inc_amb.inc_ref_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' $condition group by inc.inc_ref_id";
    
     

        $result = $this->db->query($sql);
// echo $this->db->last_query();die();
        return $result->result();
        
    }
    function get_amb_details_single_date($args) {
        //var_dump($args);die();
                if ($args['from_date'] != '' ) {
                    $from = $args['from_date'];
                }
           //   var_dump( $from );die();
        
                $sql = "SELECT `id`, `available_count`, `busy_count`, `inactive_count`, `date_time` FROM $this->tbl_amb_status WHERE "." date_time LIKE '%$from%'";
            
                $result = $this->db->query($sql);
              // var_dump( $result );die();
                if ($result) {
                    return $result->result();
                } else {
                    return false;
                }
            }
    function get_epcr_by_month_mcgm_responsetime($args){

        if ($args['from_date'] != '' && $args['to_date'] != '') {



            $from = $args['from_date'];

            $to = $args['to_date'];

            $date_format = '%m/%d/%Y';
 $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";

        }



     


/*
        $sql = "SELECT epcr.*,count(*) as total_patient,inc.inc_recive_time as inc_recive_time ,cl_pur.pname,inc.inc_type,hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,clr.*"

            . " FROM $this->tbl_epcr AS epcr"

            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"

            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"

            . " LEFT JOIN $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"

            . " LEFT JOIN $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"

            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"

            . " LEFT JOIN $this->tbl_hp1 AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"

            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"

            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"

            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"

            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"

            //. " LEFT JOIN  $this->tbl_epcr AS closure ON ( inc.inc_ref_id = closure.inc_ref_id)"

            . " WHERE epcris_deleted = '0' $condition group by epcr.inc_ref_id";

*/

        $sql = "SELECT epcr.base_location_name,epcr.wrd_location,epcr.ptn_id,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_age,ptn.ptn_gender,driv_pcr.dp_pcr_id,driv_pcr.dp_on_scene,driv_pcr.responce_time,epcr.id,hp.hp_name,hp.hp_id,epcr.rec_hospital_name,epcr.amb_reg_id,epcr.inc_ref_id,count(*) as total_patient,cl_pur.pname,inc.inc_datetime,inc.inc_type,inc.inc_cl_id,cls.cl_clr_id,clr.clr_mobile,clr.clr_fname,clr.clr_lname"

            . " FROM $this->tbl_epcr AS epcr"

           . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"

            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"

            . " LEFT JOIN $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"

            . " LEFT JOIN $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"

            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"

            . " LEFT JOIN $this->tbl_hp1 AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"

           // . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"

           // . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"

            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"

          //  . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"

            . " WHERE epcris_deleted = '0' $condition group by epcr.inc_ref_id";





        $result = $this->db->query($sql);

          //echo $this->db->last_query($result);die;

        if ($result) {

            return $result->result_array();

        } else {

            return false;

        }

    }
    function get_amb_type_new() {

        $sql = "SELECT amb_ty.*  "
 
             . " FROM $this->tbl_mas_amb_type as amb_ty"
 
             . " WHERE ambtis_deleted = '0' ";
         $result = $this->db->query($sql);
         if ($args['get_count']) {
              return $result->result();
         } else {
 
             return $result->result();
         }
     }
     function get_amb_data($args = array()) {
        if ($args['district'] !=  "") {

            $condition .= " AND amb.amb_district='" . $args['district'] . "' ";

        }
        if ($args['amb_type_id'] !=  "") {

            $condition .= " AND amb.amb_type='" . $args['amb_type_id'] . "' ";

        }
        if ($args['thirdparty_type'] !=  "") {

            $condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

        }
        
        $sql = "SELECT `amb_district`,`thirdparty`, COUNT(*) as amb_count
                FROM `ems_ambulance` as amb 
                where ambis_deleted='0' $condition  ";
      // echo $sql;
        $result = $this->db->query($sql);
        if ($args['get_count']) {
             return $result->result();
        } else {

            return $result->result();
        }

    }
    function get_amb_all_data($args = array()) {
        if ($args['district'] !=  "") {

            $condition .= " AND amb.amb_district='" . $args['district'] . "' ";

        }
        if ($args['amb_type_id'] !=  "") {

            $condition .= " AND amb.amb_type='" . $args['amb_type_id'] . "' ";

        }
        if ($args['thirdparty_type'] !=  "") {

            $condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

        }
        
        $sql = "SELECT `amb_district`,`thirdparty`, COUNT(*) as amb_count
                FROM `ems_ambulance` as amb 
                where 1=1 $condition  ";
      // echo $sql;
        $result = $this->db->query($sql);
        if ($args['get_count']) {
             return $result->result();
        } else {

            return $result->result();
        }
    }
    function get_ambulance_dispatch_data($args = array()){
        if ($args['district'] !=  "") {

            $condition .= " AND amb.amb_district='" . $args['district'] . "' ";

        }
        if ($args['amb_type_id'] !=  "") {

            $condition .= " AND amb.amb_type='" . $args['amb_type_id'] . "' ";

        }
        if ($args['thirdparty_type'] !=  "") {

            $condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {



            $from = $args['from_date'];

            $to = $args['to_date'];

            $date_format = '%m/%d/%Y';
            $condition .= "  AND inc_amb.assigned_time BETWEEN '$from' AND '$to 23:59:59'";

        }
        $sql = "SELECT `amb_district`,`thirdparty`,count(inc_ref_id) as dispatch_count
                FROM `ems_ambulance` as amb 
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )
                where ambis_deleted='0' $condition  ";
       
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
             return $result->result();
        } else {

            return $result->result();
        }
    }
    function get_patient_data($args = array()) {
        if ($args['district'] !=  "") {

            $condition .= " AND amb.amb_district='" . $args['district'] . "' ";

        }
        if ($args['amb_type_id'] !=  "") {

            $condition .= " AND amb.amb_type='" . $args['amb_type_id'] . "' ";

        }
        if ($args['thirdparty_type'] !=  "") {

            $condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {



            $from = $args['from_date'];

            $to = $args['to_date'];

            $date_format = '%m/%d/%Y';
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";

        }
        $sql = "SELECT `amb_district`,`thirdparty`,count(inc_ref_id) as inc_ref_id
                FROM `ems_ambulance` as amb 
                LEFT JOIN ems_epcr as epcr ON ( epcr.amb_reg_id = amb.amb_rto_register_no )
                where ambis_deleted='0' $condition  ";
       
        $result = $this->db->query($sql);
        if ($args['get_count']) {
             return $result->result();
        } else {

            return $result->result();
        }

    }
    function get_district_name_Summary($state = array()) {
        
        if ($state['district_id'] != '') {

            $condition .= " AND dst_mapping.dst_code IN ('" . $state['district_id'] . "')  ";

        }
        if ($state['third_party'] != '') {

            $condition .= " AND dst_mapping.third_party IN ('" . $state['third_party'] . "')  ";

        }
        $sql = "SELECT dst_mapping.*,dist.*"

            . " FROM ems_dis_thirdparty_mapping AS dst_mapping"

            . " LEFT JOIN ems_mas_districts AS dist ON ( dist.dst_code = dst_mapping.dst_code )"

            . " WHERE dst_mapping.status = '1' $condition";
        $result = $this->db->query($sql);

       //echo $this->db->last_query();die;

        if ($result) {



            return $result->result();

        } else {

            return false;

        }
    }
    function get_responsetime_closuredatewise_by_month($args){
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $date_format = '%m/%d/%Y';
            //$condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
            //$condition .= "  AND epcr.date BETWEEN '$from' AND '$to'";
            $condition .= " AND epcr.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['thirdparty'] != '' && $args['thirdparty'] != '1'){
            $condition .=  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
        }
        if (isset($args['district']) && $args['district'] != '') {
            if ($args['district'] == 'other') {
                $condition .= " AND epcr.district_id IN (30, 35, 10, 28, 3)";
            } else {
                $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            }
        }
        if ($args['system'] != '' && $args['system'] != 'all') {
            //var_dump($args['system']);
                $condition .= " AND epcr.system_type IN ('".$args['system']."')";
    
        }
            $sql = "SELECT epcr.*,epcr.inc_ref_id as incident_id,inc.inc_recive_time as inc_recive_time ,inc.inc_type, ptn.ptn_fname, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id"
            
                . " FROM $this->tbl_epcr AS epcr"
    
                . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
    
                . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
    
                 . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
    
                . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
                . " WHERE epcris_deleted = '0'  $condition ";
                //. " WHERE epcris_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";
            //echo $sql;
           // die();
            $result = $this->db->query($sql);
            if ($result) {
                return $result->result_array();
            } else {
                return false;
            }
}
function avarage_call_per_minute($args = array()){
        $from = date('Y-m-d');
        $to   = date('Y-m-d');
        
        if ($args['system'] != '') {

            $condition .= " AND inc.inc_system_type = '".$args['system']."' ";

        }

        $sql = "SELECT AVG(a.Cnt) as avg_calls FROM (select count(*) as Cnt,inc_datetime from ems_incidence WHERE inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59' group by minute(inc_datetime) order by minute(inc_datetime) desc) as a";
        $result = $this->db->query($sql);

       //echo $this->db->last_query();die;

        if ($result) {



            return $result->result();

        } else {

            return false;

        }
}
function get_inc_details_otp($args){
    $args['admitted_status']='Admitted';
    $this->db->where('inc_ref_id', $args['inc_ref_id']);
    $update = $this->db->update($this->tbl_incidence, $args);
    // echo $this->db->last_query(); die();
    return  $update;
}
function bed_confirmation($args){
    $args['admitted_status']='Admitted';
    $this->db->where('inc_ref_id', $args['inc_ref_id']);
    $update = $this->db->update($this->tbl_incidence, $args);
   // echo $this->db->last_query(); die();
}
function get_incident_by_inc_ref_id($inc_ref_id) {

    $sql = "SELECT *"
        . " FROM $this->tbl_incidence"
        . " Where $this->tbl_incidence.inc_ref_id = '$inc_ref_id'";

    $result = $this->db->query($sql);

    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
function get_inc_analytics_data(){
    $to_date = date('Y-m-d', strtotime('now - 1day'));
    $from_date = date('Y-m-d', strtotime('now - 1day'));
    $condition .= "AND inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
    $sql = "SELECT inc.inc_system_type,inc.inc_ref_id,inc.inc_lat,inc.inc_long,inc.inc_datetime,mn.ntr_nature,inc_com.ct_type,inc_amb.amb_rto_register_no,dst.dst_name,tahsil.thl_name,city.cty_name,amb.amb_lat,amb.amb_log,div.div_name"
    
        . " FROM $this->tbl_incidence AS inc"
        
        . " LEFT JOIN  $this->mas_patient_complaint_types AS inc_com ON ( inc_com.ct_id = inc.inc_complaint )"
        
        . " LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"

        . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
        
        . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
        
        . " LEFT JOIN ems_mas_districts AS dst ON ( dst.dst_code = inc.inc_district_id )"

        . " LEFT JOIN ems_mas_division AS div ON ( div.div_code = inc.inc_div_id )"
        . " LEFT JOIN $this->tbl_tahshil AS tahsil ON ( tahsil.thl_code = inc.inc_tahshil_id )"
        . " LEFT JOIN ems_mas_city AS city ON ( city.cty_id = inc.inc_city_id )"
        . " WHERE 1=1 AND inc_lat != ' ' AND inc_long != ' ' $condition ";

    $result = $this->db->query($sql);
    // echo $this->db->last_query(); die();
    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
function insert_inc_analytics_data($args){
    $result = $this->db->insert($this->incidanace_analyatics_data, $args);
     //echo $this->db->last_query();die;
     if ($result) {

         return $result;
     } else {

         return false;
     }
     die();
}

    public function insertEmgVehDis($data){
        $this->db->insert('ems_app_policefire_to_emg',$data);
        return 1;
    }
    
    function update_insertEmgVehDis($args){
      
        $this->db->where('emg_cad_inc_id', $args['emg_cad_inc_id']);
        $update = $this->db->update('ems_app_policefire_to_emg', $args);
       // echo $this->db->last_query(); die();
    }
     function get_pda_api_calls($state = array()) {
        
        if ($state['asign_pda'] != '') {
            $condition .= " AND policefire.asign_pda IN ('" . $state['asign_pda'] . "')  ";
        }
        if ($state['emg_cad_inc_id'] != '') {
            $condition .= " AND policefire.emg_cad_inc_id IN ('" . $state['emg_cad_inc_id'] . "')  ";
        }

        $sql = "SELECT policefire.* "
            . " FROM ems_app_policefire_to_emg AS policefire"
            . " WHERE policefire.call_status = 'assign' $condition";
        $result = $this->db->query($sql);

    
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

   // B12 Data New
    function get_b12_data_dashord($args,$pro=array()) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
           // $date_format = '%m/%d/%Y';
           // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['system_type'] != ''){
           
            $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
        }
        if(!empty($pro)){
            $provider = implode("','",$pro);
            $condition .= " AND epcr.provider_impressions IN ('$provider')";
        }
        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                ." where  epcr.epcris_deleted = '0' AND epcr.validate_by = ''  AND is_validate='0' $condition ";
        $result = $this->db->query($sql);

        if ($args['get_count']) {
        return $result->num_rows();
        } else {
        return $result->result();
        }
    }
        function get_b12_data_dashord_validate($args,$pro=array()) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
           // $date_format = '%m/%d/%Y';
           // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            $condition .= "  AND epcr.validate_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['system_type'] != ''){
           
            $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
        }
        if(!empty($pro)){
            $provider = implode("','",$pro);
            $condition .= " AND epcr.provider_impressions IN ('$provider')";
        }
        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                ." where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
        $result = $this->db->query($sql);
       
        if ($args['get_count']) {
        return $result->num_rows();
        } else {
        return $result->result();
        }
    }
    function get_validation_report($args = array()){
  
      
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND epcr.validate_date  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['system_type'] != ''){
           
            $condition .= " AND epcr.system_type = '" . $args['system_type'] . "'";
        }

         $sql =  "SELECT epcr.inc_ref_id,clg.clg_first_name,clg.clg_last_name,epcr.validate_date FROM ems_epcr as epcr LEFT JOIN ems_colleague as clg ON clg.clg_ref_id=epcr.validate_by
WHERE epcr.epcris_deleted = '0' AND is_validate='1' $condition group by epcr.inc_ref_id ";
        // echo $sql;
        // die();
       
        
        $result = $this->db->query($sql);

        if ($args['get_count']) {
        return $result->num_rows();
        } else {
        return $result->result();
        }
    }
   
}
