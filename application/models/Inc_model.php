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
        $this->tbl_base_location =$this->db->dbprefix('base_location');
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
        $this->inc_ref_id_gen = $this->db->dbprefix('inc_ref_id_gen');
        $this->inc_ptn_gen  = $this->db->dbprefix('inc_ptn_gen');

        $this->tbl_colleague = $this->db->dbprefix('colleague');
        
        
    }

    /*  Get all active purpose of calls
     */

    function insert_inc($args = array()) {
        // print_r($args);die;
        $this->clg = $this->session->userdata('current_user');
        // print_r($args);die;
          
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
    function get_incident_audio_by_avayaid($args) {
        $avaya_id =  $args['inc_avaya_uniqueid'];
        if($avaya_id != 'direct_atnd_call'){
        
        $sql = "SELECT inc_ref_id,inc_audio_file"
            . " FROM $this->tbl_incidence"
            . " Where $this->tbl_incidence.inc_avaya_uniqueid = '$avaya_id'";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
        }else{
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
    function insert_non_eme_call($args = array()) {
        // print_r($args);die;
        $result = $this->db->insert('non_eme_ambulance_assign', $args);
       
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    function insert_dropback($args = array()) {

        $result = $this->db->insert($this->tbl_back_drop_call, $args);
        if ($result) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    function insert_private_hospital($args = array()) {

        $result = $this->db->insert('ems_private_hospital', $args);

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
    function get_dtld_amb_details($values){
        // print_r($values);die;
        $sql = "SELECT inc_amb.amb_rto_register_no,inc_amb.amb_status,stat.ambs_id,stat.ambs_name,base.hp_id,base.hp_name,sessi.clg_id,sessi.login_type,sessi.status,clg.clg_ref_id,clg.clg_first_name"
        . " FROM ems_ambulance AS inc_amb"
        . " LEFT JOIN ems_mas_ambulance_status AS stat ON ( stat.ambs_id = inc_amb.amb_status )"
        . " LEFT JOIN ems_base_location AS base ON ( base.hp_id = inc_amb.amb_base_location )"
        . " LEFT JOIN ems_app_login_session AS sessi ON ( sessi.vehicle_no = inc_amb.amb_rto_register_no )"
        . " LEFT JOIN ems_colleague AS clg ON ( clg.clg_id = sessi.clg_id )"
        . " WHERE inc_amb.amb_rto_register_no = '".$values."'"
        . " AND sessi.status = '1'";
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
       
    }
    function get_dropback_call_details($args = array()){
        if ($args['inc_ref_id']) {
            $condition = "inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT *"
            . " FROM ems_back_drop_call"
             . " WHERE  $condition";
       // echo $sql;
        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_hospital_facility($args = array()) {


        if ($args['inc_ref_id']) {
            $condition = " AND fac.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT fac.*, fac.new_facility as new_facility_id,hp.hp_name as current_facility,hosp.hp_name as new_facility "
            . " FROM $this->tbl_inter_facility AS fac"
            . " LEFT JOIN  ems_hospital AS hp ON ( hp.hp_id = fac.facility )"
            . " LEFT JOIN  ems_hospital AS hosp ON ( hosp.hp_id = fac.new_facility )"
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

    
    function get_chief_comp_service_help($cm_id, $limit = '', $offset = '') {
        //var_dump($cm_id);die;
        $this->db->select('*');
        $this->db->from('ems_complaint_types_help_desk');

        if ($cm_id != "") {

            $this->db->where('ems_complaint_types_help_desk.ct_id', $cm_id);
        }

        $this->db->where('ems_complaint_types_help_desk.ct_status', '1');
        $this->db->where('ems_complaint_types_help_desk.ctis_deleted', '0');

        $data = $this->db->get();
        // echo $this->db->last_query();die();
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

    function get_am_in_inc_area($lat = "", $lng = "", $am_tp = array(), $min_distance = '',$inc_status = '',$district_id = '',$thirdparty='',$amb_id='',$district_name='',$base_id='') {

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
        if ($base_id != '' && $base_id != '0') {
            $condition .= " AND amb.amb_base_location IN ('$base_id') ";
        }
        $tm_team_date = date('Y-m-d');
        if ($thirdparty != '') {
            //$condition .= " AND amb.thirdparty IN ($thirdparty) AND app_lg.status = '1'";
            //$condition .= " AND amb.thirdparty IN ($thirdparty) AND tm.tm_team_date = '$tm_team_date'";
           // $condition .= " AND amb.thirdparty IN ($thirdparty)";
        }else{
           // $condition .= "AND (amb.thirdparty = '1' OR (amb.thirdparty = '2' AND app_lg.status = '1') ) ";
             //$condition .= "AND (amb.thirdparty = '1' OR amb.thirdparty = '6' OR (amb.thirdparty = '2' AND app_lg.status = '1') OR (amb.thirdparty = '3' AND app_lg.status = '1') OR (amb.thirdparty = '4'AND app_lg.status = '1')) ";
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
            $am_cond .= " AND amb.amb_district IN ($district_id) ";
        }
         if ($district_name != '' && $district_name != '0') {
//            $am_cond .= " AND amb.amb_district IN ($district_id) ";
            $am_cond .= " AND dist.dst_name LIKE '%$district_name%' ";
        }
        
        if($this->clg->clg_group == 'UG-ERO-104'){
            $am_cond .= " AND amb.amb_user IN ('104')";
        }
        
        if($this->clg->clg_group == 'UG-ERO' || $this->clg->clg_group == 'UG-REMOTE'){
            $am_cond .= " AND amb.amb_user  IN ('108','102')";
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
        $having_distance = "  ";


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

        $sql = "SELECT amb.gps_date_time,app_lg.status,app_lg.clg_id as app_clg_id,amb.thirdparty,amb.amb_district,amb.ward_name,wrd.ward_name as mumbai_wrd_nm,amb.ward_name,amb.amb_id,amb.amb_user_type, amb.amb_type,amb.amb_status,amb.amb_rto_register_no, amb.amb_lat,amb.gps_amb_lat, amb.amb_log,amb.gps_amb_log, amb.amb_default_mobile,amb.amb_pilot_mobile, hp.hp_id, hp.hp_name,hp.hp_lat,hp.hp_long,tm.tm_id,tm.tm_pilot_id,tm.tm_emt_id,amb_ty.ambt_name,amb_staus.ambs_name,hp.geo_fence,amb.pilot_nm"

            . "$radius"

            . " FROM ems_ambulance AS amb"

            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location)"

            . " LEFT JOIN ems_amb_default_team AS tm ON ( tm.tm_amb_rto_reg_id = amb.amb_rto_register_no )"

            . " LEFT JOIN ems_mas_ambulance_type AS amb_ty ON ( amb_ty.ambt_id = amb.amb_type )"

            . " LEFT JOIN ems_mas_ambulance_status AS amb_staus ON ( amb_staus.ambs_id = amb.amb_status )"

            . " LEFT JOIN $this->tbl_mas_ward as wrd ON amb.ward_name = wrd.ward_id "
            . " LEFT JOIN ems_mas_districts as dist ON dist.dst_code = amb.amb_district "

            . " LEFT JOIN ems_app_login_session as app_lg ON amb.amb_rto_register_no = app_lg.vehicle_no "

            . " WHERE ambis_deleted = '0' AND ambis_backup = '0' "

            . " $amb_status $condition"

           // . " AND amb_status Not IN ('2') "

           // ." AND tm.tm_team_date = '$tm_team_date'"

            . " $am_cond"

             //." HAVING distance < 5 ORDER BY distance"

            //. "  Group by amb.amb_rto_register_no $having_distance ORDER BY amb_user_type,amb_ty.ambu_level ASC $limit";

            . "  Group by amb.amb_rto_register_no $having_distance $orderby $limit";
        //echo $sql;
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
    function get_gps_closing_parameters($args){
        //var_dump($args);
        $condition='';
        $condition .= "inc.inc_ref_id='" . $args . "'";
        $sql = "SELECT chief_com.ct_type,mci.ntr_nature,inc.inc_type,inc.inc_ref_id,inc.inc_recive_time,inc.inc_datetime,purcall.pname,GROUP_CONCAT(NULLIF(ptn.ayushman_id,'')) as ayushman_id
        FROM `ems_incidence` as inc
        LEFT JOIN ems_incidence_patient as incptn ON (inc.inc_ref_id = incptn.inc_id)
        LEFT JOIN ems_patient as ptn ON (incptn.ptn_id = ptn.ptn_id)
        LEFT JOIN ems_mas_patient_complaint_types as chief_com ON (chief_com.ct_id = inc.inc_complaint)
        LEFT JOIN ems_mas_micnature as mci ON (mci.ntr_id = inc.inc_mci_nature)
        LEFT JOIN ems_mas_call_purpose as purcall ON (inc.inc_type = purcall.pcode)
        WHERE  inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' AND $condition ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($result) {

            return $result->result();

        } else {

            return false;

        }
    }
    function get_inc_details($args) {
        
        $condition = '';
        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "' ";
        }
        if (isset($args['base_month']) && $args['base_month'] != '') {

            $condition .= "AND inc.inc_base_month IN (" . ($args['base_month'] - 2) . "," . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";
        }

        if($condition == ''){
            return false;
        }
        $sql = "SELECT inc.*,inc_amb.*,clg_emt.clg_emso_id,clg_emt.clg_last_name,clg_emt.clg_mid_name,clg_emt.clg_first_name,clg_pilot.clg_last_name as pilot_lastnm,clg_pilot.clg_mid_name as pilot_midnm,clg_pilot.clg_first_name as pilot_firstnm,inc_ptn.ptn_id,amb.amb_type as ambulance_type,amb.amb_district,dst.dst_name as dst_name,amb_type.ambt_name,cl_purpose.pcode,cl_purpose.pname,hosp_name.hp_name as hp_one,hosp_two.hp_name as hp_two"
        
            . " FROM $this->tbl_incidence AS inc"
            
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON ( inc_amb.inc_ref_id = inc.inc_ref_id )"
            
            . " LEFT JOIN  $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            
            . " LEFT JOIN  $this->mas_patient_complaint_types AS inc_com ON ( inc_com.ct_id = inc.inc_complaint )"
            
           // . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"

            . " LEFT JOIN ems_mas_ambulance_type AS amb_type ON ( amb_type.ambt_id = amb.amb_type)"
            . " LEFT JOIN ems_hospital AS hosp_name ON ( hosp_name.hp_id = inc.destination_hospital_id )"
            . " LEFT JOIN ems_mas_call_purpose AS cl_purpose ON ( cl_purpose.pcode = inc.inc_type )"
            // . " LEFT JOIN ems_mas_ambulance_type AS dst ON ( amb_district.ambt_id = amb.amb_district )"
            . " LEFT JOIN ems_hospital AS hosp_two ON ( hosp_two.hp_id = inc.destination_hospital_two )"
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
        $distance_having  ='';
        if (!empty($args['lat']) && !empty($args['lng'])) {
            $distance = ", ( 6372.797 * acos( cos( radians( " . $args['lat'] . " ) ) * cos( radians( inc.inc_lat ) ) * cos( radians( inc.inc_long ) - radians( " . $args['lng'] . " ) ) + sin( radians( " . $args['lat'] . " ) ) * sin( radians( inc.inc_lat ) ) ) ) AS distance";
           // $distance_having = " HAVING distance < " . $args['distance'];
        }
        $current_date = date('Y-m-d');
        $current_date =date('Y-m-d H:i:s');
        $newdate =  date("Y-m-d H:i:s", (strtotime ('-12 hours' , strtotime ($current_date)))) ;
        $condition .= " AND inc.inc_datetime BETWEEN '$newdate' AND '$current_date'";

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
    function get_dispatch_inc_pvt_hos_by_report($args = array(), $offset = '', $limit = ''){
        $condition = $offlim = '';

        if ($args['operator_id']) {
            $condition = " AND op.operator_id='" . $args['operator_id'] . "'";
        }
       // $condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
       if($args['thirdparty'] != '' ){
        $condition .=  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' ";
        // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
        //$condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
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
           // $system = implode("','",$args['system']);
            //$condition .= " AND inc.inc_system_type IN ('".$system."')";
            $condition .= " AND inc.inc_system_type = '" . $args['system'] . "'";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT *,wrd.*,pvt_hos.pr_total_amount,pvt_hos.pr_case_total_distance,third_party.thirdparty_name,inc_amb.base_location_name,inc_amb.ward_name,hp.hp_name,wrd.ward_name as wrd_name,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN ems_mas_micnature  AS mci_nature ON (mci_nature.ntr_id = inc.inc_mci_nature )"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN ems_mas_ward AS wrd ON ( wrd.ward_id = amb.ward_name )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . " LEFT JOIN ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"
            . " LEFT JOIN $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN $this->tbl_colleague AS clg ON (clg.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_private_hospital AS pvt_hos ON ( pvt_hos.pr_inc_ref_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' AND inc_type = 'EMG_PVT_HOS' AND inc.inc_set_amb = '1'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";

       //echo $sql;die();


        $result = $this->db->query($sql);
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
       // $condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
       if($args['thirdparty'] != '' ){
        $condition .=  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' ";
        // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
        //$condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
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
           // $system = implode("','",$args['system']);
            //$condition .= " AND inc.inc_system_type IN ('".$system."')";
            $condition .= " AND inc.inc_system_type = '" . $args['system'] . "'";
        }


        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }

        $sql = "SELECT *,wrd.*,third_party.thirdparty_name,inc_amb.base_location_name,inc_amb.ward_name,hp.hp_name,wrd.ward_name as wrd_name,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_mas_patient_complaint_types  AS cheif ON (cheif.ct_id = inc.inc_complaint )"
            . " LEFT JOIN ems_mas_micnature  AS mci_nature ON (mci_nature.ntr_id = inc.inc_mci_nature )"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no )"
            . " LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN ems_mas_ward AS wrd ON ( wrd.ward_id = amb.ward_name )"
            . " LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN $this->tbl_call_purpose AS call_pur ON (call_pur.pcode = inc.inc_type )"
            . " LEFT JOIN ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"
            . " LEFT JOIN $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN $this->tbl_colleague AS clg ON (clg.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";

       //echo $sql;


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

        if($args['thirdparty'] != '' ){
            $condition .=  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' ";
            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            //$condition =  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
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
         $sql = "SELECT inc.*,third_party.thirdparty_name,clr.clr_fullname,clr.clr_fname,clr.clr_lname,clr.clr_mobile,call_pur.pname,ero_remark.re_name,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name"
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
            . " LEFT JOIN  $this->tbl_colleague AS clg ON (clg.clg_ref_id = inc.inc_added_by )"
            . " LEFT JOIN   ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"
            . "LEFT JOIN  $this->tbl_mas_ero_remark AS ero_remark ON (ero_remark.re_id = inc.inc_ero_standard_summary )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb ='0' AND inc.inc_pcr_status = '0' $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";
        


        $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
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
        if($args['base_month'] != ''){
            $condition .= " AND inc.inc_base_month='" . $args['base_month'] . "' ";
        }

        
        $sql = "SELECT inc.inc_ref_id "
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE 1=1 $condition ORDER BY inc.inc_datetime DESC";
//echo $sql;
//die();


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
         if($args['base_month'] != ''){
            $condition .= " AND inc.inc_base_month='" . $args['base_month'] . "' ";
        }
        
         $sql = "SELECT inc.inc_ref_id"
            . " FROM $this->tbl_incidence AS inc"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('on_scene_care','MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CARE_CALL','PREGANCY_CALL','Child_CARE_CALL','DROP_BACK_CALL','Child_CARE','DROP_BACK','PICK_UP','EMG_PVT_HOS') $condition ORDER BY inc.inc_datetime DESC";
     

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
        if ($args['base_month']) {
            $condition .= " AND ems_epcr.base_month ='" . $args['base_month'] . "' ";
            $condition .= " AND inc.inc_base_month ='" . $args['base_month'] . "' ";
        }
       


        $sql = "SELECT ems_patient.*, inc.inc_ref_id, inc.inc_datetime, inc.inc_address, ems_epcr.rec_hospital_name,ems_epcr.other_receiving_host, ems_epcr.id as epcr_id, clr.clr_fullname, clr.clr_mobile FROM ems_incidence_patient Left JOIN ems_epcr ON ems_epcr.ptn_id = ems_incidence_patient.ptn_id LEFT JOIN ems_patient ON ems_patient.ptn_id = ems_incidence_patient.ptn_id LEFT JOIN ems_incidence as inc ON inc.inc_ref_id = ems_epcr.inc_ref_id LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id ) LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id ) WHERE inc.incis_deleted = '0' AND ems_epcr.epcris_deleted = '0' AND ems_patient.ptnis_deleted = '0' $condition  GROUP BY ems_patient.ptn_id";

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
         var_dump($result->result());

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

     ////Ambulance Listing Report/////

     function get_amb_listing($args = array()) {
        $condition = '';
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
        if ($args['incient_district'] != 'all') {
            $condition .= " AND amb.amb_district = '" . $args['incient_district'] . "' ";
        } 

     
        //  if ($args['district'] != '') {
        //     $condition .= " AND amb.amb_district = '" . $args['district'] . "' ";
        // }
        
        // if ($args['from_date'] != '' && $args['to_date'] != '') {
        //     $from = $args['from_date'];
        //     $to = $args['to_date'];

        //     $condition .= " AND amb.amb_added_date BETWEEN '$from' AND '$to 23:59:59'";
        // }
        // print_r($args['incient_district']);die;

    $sql = "SELECT amb.*,dist.dst_name,amb_vendor.vendor_name, loc.hp_name, area.ar_name,amb_type.ambt_name, tehsil.thl_name, sts.ambs_name, prty.thirdparty_name, clg.clg_first_name, clg.clg_last_name,div_na.div_name  FROM `ems_ambulance` AS amb "
    . " LEFT JOIN `ems_mas_districts` AS dist ON (dist.dst_code = amb.amb_district )"
    . " LEFT JOIN `ems_base_location` AS loc ON (loc.hp_id = amb.amb_base_location )"
    . " LEFT JOIN `ems_mas_area_types` AS area ON (area.ar_id = amb.amb_working_area )"
    . " LEFT JOIN `ems_mas_ambulance_type` AS amb_type ON (amb_type.ambt_id = amb.amb_type )"
    . " LEFT JOIN `ems_mas_tahshil` AS tehsil ON (tehsil.thl_code = amb.amb_tahsil )"
    . " LEFT JOIN `ems_mas_ambulance_status` AS sts ON (sts.ambs_id = amb.amb_status )"
    . " LEFT JOIN `ems_mas_thirdparty` AS prty ON (prty.thirdparty_id = amb.thirdparty )"
    . " LEFT JOIN `ems_colleague` AS clg ON (clg.clg_ref_id = amb.amb_added_by )"
    . " LEFT JOIN `ems_ambulance_vendor` AS amb_vendor ON (amb_vendor.vendor_id = amb.amb_vendor )"
    . " LEFT JOIN `ems_mas_division` AS div_na ON (div_na.div_code = dist.div_id )"
    . " Where amb.ambis_deleted = '0' AND amb.ambis_backup != '1' $condition ORDER BY amb.amb_rto_register_no " ;

      

        $result = $this->db->query($sql);
    //   echo $this->db->last_query($result);die;
    $abc = $result->result_array();
    // print_r($abc);die;
    //     if ($args['get_count']) {
    //         return $result->num_rows();
    //     } else {
    //         return $result->result_array();
    //     }
    return $abc;
    }

      ////All Ambulance Master Report/////

      function get_amb_master($args = array()) {
        $condition = '';
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
        if ($args['incient_district'] != 'all') {
            $condition .= " AND amb.amb_district = '" . $args['incient_district'] . "' ";
        } 

     
        //  if ($args['district'] != '') {
        //     $condition .= " AND amb.amb_district = '" . $args['district'] . "' ";
        // }
        
        // if ($args['from_date'] != '' && $args['to_date'] != '') {
        //     $from = $args['from_date'];
        //     $to = $args['to_date'];

        //     $condition .= " AND amb.amb_added_date BETWEEN '$from' AND '$to 23:59:59'";
        // }

    $sql = "SELECT amb.*,dist.dst_name, amb_vendor.vendor_name,loc.hp_name, area.ar_name,amb_type.ambt_name, tehsil.thl_name, sts.ambs_name, prty.thirdparty_name, clg.clg_first_name, clg.clg_last_name,div_na.div_name  FROM `ems_ambulance` AS amb "
    . " LEFT JOIN `ems_mas_districts` AS dist ON (dist.dst_code = amb.amb_district )"
    . " LEFT JOIN `ems_base_location` AS loc ON (loc.hp_id = amb.amb_base_location )"
    . " LEFT JOIN `ems_mas_area_types` AS area ON (area.ar_id = amb.amb_working_area )"
    . " LEFT JOIN `ems_mas_ambulance_type` AS amb_type ON (amb_type.ambt_id = amb.amb_type )"
    . " LEFT JOIN `ems_mas_tahshil` AS tehsil ON (tehsil.thl_code = amb.amb_tahsil )"
    . " LEFT JOIN `ems_mas_ambulance_status` AS sts ON (sts.ambs_id = amb.amb_status )"
    . " LEFT JOIN `ems_mas_thirdparty` AS prty ON (prty.thirdparty_id = amb.thirdparty )"
    . " LEFT JOIN `ems_colleague` AS clg ON (clg.clg_ref_id = amb.amb_added_by )"
    . " LEFT JOIN `ems_ambulance_vendor` AS amb_vendor ON (amb_vendor.vendor_id = amb.amb_vendor )"
    . " LEFT JOIN `ems_mas_division` AS div_na ON (div_na.div_code = dist.div_id )"
    . " Where 1=1 $condition ORDER BY amb.amb_rto_register_no " ;
        $result = $this->db->query($sql);
    //   echo $this->db->last_query($result);die;
    $abc = $result->result_array();
    // print_r($abc);die;
    //     if ($args['get_count']) {
    //         return $result->num_rows();
    //     } else {
    //         return $result->result_array();
    //     }
    return $abc;
    }
    
////Ambulance Logout Report/////


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
    //for base location
    function get_base_location_by_id($base_id) {
        if ($base_id) {
            $condition = " AND loc.hp_id IN ($base_id)";
        }

        $sql = "SELECT loc.hp_name"
            . " FROM ems_base_location AS loc"
            . " WHERE loc.hpis_deleted = '0' $condition";

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

        $sql = "SELECT amb.amb_type,amb_ty.ambt_name,area.ar_name"
            . " FROM ems_ambulance as amb"
            . " LEFT JOIN ems_mas_ambulance_type as amb_ty ON amb.amb_type=amb_ty.ambt_id"
            . " LEFT JOIN ems_mas_area_types as area ON area.ar_id=amb.amb_working_area"
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

    function get_dco($dco_no) {
        if ($dco_no) {
            $condition = " AND clg_ref_id IN ('$dco_no')";
        }

        $sql = "SELECT concat(`clg_first_name`,' ',`clg_last_name`) as dco_name"
            . " FROM ems_colleague "
            . " WHERE clg_is_deleted = '0' $condition";

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
        $sql= "Select  dst_code,dst_name FROM $this->tbl_mas_districts WHERE dst_state='MP'";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;

         if ($args['get_count']) {
             return $result->num_rows();
         } else {
             return $result->result();
         }
    }
    function get_epcr_lat_long_by_month($args){
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND epcr.validate_date  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
      

        if (isset($args['district']) && $args['district'] != '') {
            
            $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
        }
        
       if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        }
       
        $sql = "SELECT dri_para.at_scene_lat,dri_para.back_to_bs_loc_lat,dri_para.at_scene_lng,dri_para.back_to_bs_loc_lng,clg.clg_first_name,clg.clg_last_name,clg_epcr.clg_first_name as epcr_clg_first_name,clg_epcr.clg_last_name as epcr_clg_last_name,epcr.*,dist.dst_name,baseLoc.hp_name as baselocation,clr.clr_mobile,clr.clr_fname,clr.clr_lname,epcr.inc_ref_id as incident_id,epcr.date as closure_datetime,epcr.scene_odometer as scene_odo,epcr.from_scene_odometer as from_scene_odo,epcr.handover_odometer as handover_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,amb.amb_district,hp.hp_name,hp.hp_code, loc.level_type, hp.hp_id,inc.inc_added_by,pro_imp.b12_type,pro_imp.pro_name,epcr.base_location_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,hp.hp_district,cl_pur.pname,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name,inc.inc_address,inc_amb.base_location_name as inc_base_location_name,inc_amb.ward_name as inc_ward_name,inc.patient_ava_or_not"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
            . " LEFT JOIN $this->tbl_amb  AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN $this->tbl_base_location AS baseLoc ON ( baseLoc.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_colleague as clg ON  (clg.clg_ref_id = epcr.ercp_advice_Taken )"
            . " LEFT JOIN $this->tbl_colleague as clg_epcr ON  (clg_epcr.clg_ref_id = epcr.operate_by )"
            . " LEFT JOIN ems_mas_districts AS dist ON ( dist.dst_code = epcr.district_id )"
            . " LEFT JOIN ems_driver_parameters as dri_para ON ( dri_para.incident_id = epcr.inc_ref_id )"
          //  . " LEFT JOIN ems_hospital AS hosp_name ON ( hosp_name.hp_id = epcr.rec_hospital_name )"
           // . " LEFT JOIN   ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"   
           // . " LEFT JOIN ems_mas_provider_casetype AS casetype ON ( casetype.case_id  = epcr.provider_casetype )"
           
            . " WHERE epcr.is_validate='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' $condition ";
         
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        // echo $result;die;
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_epcr_by_month($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND epcr.validate_date  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
      

        if (isset($args['district']) && $args['district'] != '') {
            
            $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
        }
        
       if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        }
       
        $sql = "SELECT clg.clg_first_name,clg.clg_last_name,clg_epcr.clg_first_name as epcr_clg_first_name,clg_epcr.clg_last_name as epcr_clg_last_name,epcr.*,dist.dst_name,baseLoc.hp_name as baselocation,clr.clr_mobile,clr.clr_fname,clr.clr_lname,epcr.inc_ref_id as incident_id,epcr.date as closure_datetime,epcr.scene_odometer as scene_odo,epcr.from_scene_odometer as from_scene_odo,epcr.handover_odometer as handover_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,amb.amb_district,hp.hp_name,hp.hp_code, loc.level_type, hp.hp_id,inc.inc_added_by,pro_imp.b12_type,pro_imp.pro_name,epcr.base_location_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,hp.hp_district,cl_pur.pname,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name,inc.inc_address,inc_amb.base_location_name as inc_base_location_name,inc_amb.ward_name as inc_ward_name,inc.patient_ava_or_not"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
            . " LEFT JOIN $this->tbl_amb  AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN $this->tbl_base_location AS baseLoc ON ( baseLoc.hp_id = amb.amb_base_location )"
            . " LEFT JOIN $this->tbl_colleague as clg ON  (clg.clg_ref_id = epcr.ercp_advice_Taken )"
            . " LEFT JOIN $this->tbl_colleague as clg_epcr ON  (clg_epcr.clg_ref_id = epcr.operate_by )"
            . " LEFT JOIN ems_mas_districts AS dist ON ( dist.dst_code = epcr.district_id )"
          //  . " LEFT JOIN ems_hospital AS hosp_name ON ( hosp_name.hp_id = epcr.rec_hospital_name )"
           // . " LEFT JOIN   ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"   
           // . " LEFT JOIN ems_mas_provider_casetype AS casetype ON ( casetype.case_id  = epcr.provider_casetype )"
           
            . " WHERE epcr.is_validate='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' $condition ";
         
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        // echo $result;die;
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_mis_by_month($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND epcr.validate_date  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
      

        if (isset($args['district']) && $args['district'] != '') {
            
            $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
        }
        
       if ($args['system'] != '' && $args['system'] != 'all') {
            $condition .= " AND epcr.system_type IN ('".$args['system']."')";

        }

          $sql = "SELECT epcr.*,inc.inc_type,intr_fac.facility,base_dist.dst_name as pre_base_dist,base_tehsil.thl_name as pre_base_teh,intr_fac.new_facility,ift_main_hp_type.full_name as ift_main_type,ift_main_hp.hp_name as ift_main_name,inc.destination_hospital_other as other_dest_hosp,inc.inc_back_hospital as inc_bk_hp,amb_div.div_name as amb_div,srd_rem.re_name as ero_standard_rem,intr_hosp_type_two.full_name as intr_type_two,mci_nat.ntr_nature,ero_dist_one.dst_name as one_dist_name,intr_hosp_two.hp_name as fac_hosp_two,hos_type_two.full_name as ero_type_two,hos_type_one.full_name as ero_type_one, dist.dst_name,baseLoc.hp_name as baselocation,ero_drop_hp.hp_name as ero_drop,ero_drop_hp_two.hp_name as ero_drop_two,hos1.hp_name as drop_back_hp,inc_back_hp.hp_name as back_hospital,inc_back_hp_type.full_name as back_hp_type,clr_rel.rel_name,clr.clr_mobile,clr.clr_fname,clr.clr_lname,epcr.inc_ref_id as incident_id,epcr.date as closure_datetime,epcr.scene_odometer as scene_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_ero_summary,inc.inc_added_by,amb.amb_district,hp.hp_name,hp.hp_code, loc.level_type, hp.hp_id,inc.inc_added_by,pro_imp.b12_type,pro_imp.pro_name,epcr.base_location_name, ptn.ptn_pcf_no,ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.dp_on_scene,driv_pcr.dp_hosp_time,driv_pcr.dp_hand_time,driv_pcr.dp_back_to_loc,resp.*,epcr.id as epcr_id,inc.inc_district_id,hp.hp_district,cl_pur.pname,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name,inc.inc_address,inc_amb.base_location_name as inc_base_location_name,inc_amb.ward_name as inc_ward_name,inc.patient_ava_or_not,amb.amb_district as amb_dis,inc.inc_recive_time,inc.inc_datetime,inc.inc_dispatch_time,inc.inc_added_by,inc.inc_pcr_status,inc.inc_lat,inc.inc_long,dist.dst_name as inc_dist_name,tah.thl_name as inc_tah_name,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,inc.inc_address,amb.amb_gps_imei_no,amb.amb_gps_sim_no,amb.amb_mdt_srn_no,amb.amb_mdt_imei_no,amb.amb_category,inc.inc_patient_cnt,inc.inc_complaint_other,ptn.ptn_district,ptn.ptn_tahsil,ptn.ptn_address,ptn.ptn_mob_no,ptn.ayushman_id,inc.hospital_name,inc.inc_back_home_address,divi.div_name as inc_div_name,cmpl.ct_type as inc_complaint,inc.patient_ava_or_not_other_reason,drv_par.at_scene_lat,drv_par.at_scene_lng,drv_par.back_to_bs_loc_lat,drv_par.back_to_bs_loc_lng,clg1.clg_first_name as dco_fname,clg1.clg_mid_name as dco_midname,clg1.clg_last_name as dco_lname,area.ar_name,prihos.pr_total_amount,amb_area.ar_name as area_type_amb"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_mas_micnature as mci_nat ON ( mci_nat.ntr_id = inc.inc_mci_nature )"

            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  ems_mas_ero_remark AS srd_rem ON ( inc.inc_ero_standard_summary = srd_rem.re_id  )"
            . " LEFT JOIN  ems_base_location AS prev_base ON ( epcr.base_location_name = prev_base.hp_name  )"
            . " LEFT JOIN ems_mas_districts AS base_dist ON ( prev_base.hp_district = base_dist.dst_code )"
            . " LEFT JOIN ems_mas_tahshil AS base_tehsil ON ( prev_base.hp_tahsil = base_tehsil.thl_code )"

            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
            
            . " LEFT JOIN $this->tbl_amb  AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN ems_mas_division AS amb_div ON ( amb.amb_div_code = amb_div.div_code )"
            . " LEFT JOIN  ems_mas_relation AS clr_rel ON ( cls.clr_ralation = clr_rel.rel_id  )"
            . " LEFT JOIN ems_hospital as inc_back_hp ON ( epcr.rec_hospital_name = inc_back_hp.hp_id )"
            . " LEFT JOIN ems_mas_hospital_type as inc_back_hp_type ON ( inc_back_hp.hp_type = inc_back_hp_type.hosp_id )"

            . " LEFT JOIN ems_hospital as ero_drop_hp ON ( epcr.rec_hospital_name = ero_drop_hp.hp_id )"
            . " LEFT JOIN ems_mas_hospital_type AS hos_type_one ON (ero_drop_hp.hp_type = hos_type_one.hosp_id)"
            . " LEFT JOIN ems_mas_districts AS ero_dist_one ON ( ero_drop_hp.hp_district = ero_dist_one.dst_code )"

            . " LEFT JOIN ems_hospital as ero_drop_hp_two ON ( inc.destination_hospital_two = ero_drop_hp_two.hp_id )"
            . " LEFT JOIN ems_mas_hospital_type AS hos_type_two ON ( ero_drop_hp_two.hp_type = hos_type_two.hosp_id )"
            . " LEFT JOIN ems_mas_districts AS ero_dist_two ON ( ero_drop_hp_two.hp_district = ero_dist_two.dst_code )"
            
            . " LEFT JOIN ems_inter_facility as intr_fac ON (inc.inc_ref_id=intr_fac.inc_ref_id)"

            . " LEFT JOIN ems_hospital as ift_main_hp ON (ift_main_hp.hp_id=intr_fac.facility)"

            . " LEFT JOIN ems_hospital as intr_hosp_two ON (intr_hosp_two.hp_id=intr_fac.new_facility)"
            
            . " LEFT JOIN ems_mas_hospital_type as ift_main_hp_type ON (ift_main_hp.hp_type=ift_main_hp_type.hosp_id)"
            . " LEFT JOIN ems_mas_hospital_type as intr_hosp_type_two ON (intr_hosp_two.hp_type=intr_hosp_type_two.hosp_id)"

            . " LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = amb.amb_base_location)"
            . " LEFT JOIN $this->tbl_hp AS baseLoc ON ( baseLoc.hp_id =  epcr.rec_hospital_name  )"
            . " LEFT JOIN  $this->tbl_colleague AS clg ON ( inc.inc_added_by = clg.clg_ref_id )"
            . " LEFT JOIN  $this->tbl_colleague AS clg1 ON ( epcr.validate_by = clg1.clg_ref_id )"
            . " LEFT JOIN ems_mas_districts AS dist ON ( dist.dst_code = epcr.district_id )"
            . " LEFT JOIN ems_mas_tahshil AS tah ON ( tah.thl_code = inc.inc_tahshil_id )"
            . " LEFT JOIN ems_mas_division AS divi ON ( divi.div_code = dist.div_id )"
            . " LEFT JOIN ems_mas_patient_complaint_types AS cmpl ON ( cmpl.ct_id = inc.inc_complaint )"
            . " LEFT JOIN ems_driver_parameters AS drv_par ON ( drv_par.incident_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_mas_area_types AS area ON ( epcr.inc_area_type = area.ar_id )"
            . " LEFT JOIN ems_private_hospital AS prihos ON ( prihos.pr_inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_hospital AS hos1 ON ( hos1.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN ems_mas_area_types AS amb_area ON ( amb.amb_working_area = amb_area.ar_id )"

            
            . " WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '1' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' $condition ";
         

        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }



    /**************************************************/

    function get_gen_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
           // $condition .= "  AND (main_tbl.mt_onroad_datetime = null  || main_tbl.mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";

        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_amb_onroad_offroad` as main_tbl"
            . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
            . "  WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    function get_accidental_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
           // $condition .= "  AND (main_tbl.mt_onroad_datetime = null ||  main_tbl.mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_amb_accidental_maintaince` as main_tbl"
            . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
            . " WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_preventive_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
          //  $condition .= "  AND (main_tbl.mt_onroad_datetime = null ||  main_tbl.mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_ambulance_preventive_maintaince` as main_tbl"
        . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
        . "  WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_manpower_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.added_date) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '' ) {
           // $condition .= "  AND (main_tbl.mt_exp_onroad_date = null ||  main_tbl.mt_exp_onroad_date = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_manpower_offroad` as main_tbl"
        . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
            . "  WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    function get_scrap_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.approved_date) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
            //$condition .= "  AND (main_tbl.mt_ex_onroad_datetime = null || main_tbl.mt_ex_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_scrape_vahicle` as main_tbl"
        . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
            . "  WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    
    function get_tyre_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
            //$condition .= "  AND (main_tbl.mt_onroad_datetime = null || main_tbl.mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_amb_tyre_maintaince` as main_tbl"
        . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
            . "  WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    function get_brk_count($args) {
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(main_tbl.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
           // $condition .= "  AND (main_tbl.mt_onroad_datetime = null  || main_tbl.mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(`mt_id`) as count,main_tbl.amb_type FROM `ems_amb_breakdown_maintaince` as main_tbl"
        . " LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = main_tbl.mt_amb_no"
            . "  WHERE  main_tbl.mt_ambulance_status ='Approved' AND main_tbl.mt_isdeleted = '0' $condition GROUP BY main_tbl.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }

    /******************* */

    function get_zonewise_dtl() {
        
       
          $sql = "SELECT * FROM `ems_mas_division`"
            . "  WHERE div_deleted = '0' ";
         
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    function get_zonewise_count_gen($args) {

        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
           // $condition .= "  AND (mt_onroad_datetime = null ||  mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_amb_onroad_offroad.`mt_id`) as count,ems_amb_onroad_offroad.amb_type,ems_mas_division.div_name FROM `ems_amb_onroad_offroad`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_amb_onroad_offroad.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_amb_onroad_offroad.mt_amb_no"
            . " WHERE ems_amb_onroad_offroad.mt_ambulance_status ='Approved' AND ems_amb_onroad_offroad.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."'  $condition GROUP BY ems_amb_onroad_offroad.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_zonewise_count_accidental($args){
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
           // $condition .= "  AND (mt_onroad_datetime = null ||  mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_amb_accidental_maintaince.`mt_id`) as count,ems_amb_accidental_maintaince.amb_type,ems_mas_division.div_name FROM `ems_amb_accidental_maintaince`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_amb_accidental_maintaince.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_amb_accidental_maintaince.mt_amb_no"
            . " WHERE ems_amb_accidental_maintaince.mt_ambulance_status ='Approved' AND ems_amb_accidental_maintaince.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."'  AND ems_amb_accidental_maintaince.mt_offroad_datetime $condition GROUP BY ems_amb_accidental_maintaince.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_zonewise_count_preventive($args){
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
            //$condition .= "  AND (mt_onroad_datetime = null ||  mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_ambulance_preventive_maintaince.`mt_id`) as count,ems_ambulance_preventive_maintaince.amb_type,ems_mas_division.div_name FROM `ems_ambulance_preventive_maintaince`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_ambulance_preventive_maintaince.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_ambulance_preventive_maintaince.mt_amb_no"
            . " WHERE ems_ambulance_preventive_maintaince.mt_ambulance_status ='Approved' AND ems_ambulance_preventive_maintaince.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."'   $condition GROUP BY ems_ambulance_preventive_maintaince.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_zonewise_count_manpower($args){
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(added_date) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
            //$condition .= "  AND (mt_ex_onroad_datetime = null ||  mt_ex_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_manpower_offroad.`mt_id`) as count,ems_manpower_offroad.amb_type,ems_mas_division.div_name FROM `ems_manpower_offroad`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_manpower_offroad.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_manpower_offroad.mt_amb_no"
            . " WHERE ems_manpower_offroad.mt_ambulance_status ='Approved' AND ems_manpower_offroad.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."'   $condition GROUP BY ems_manpower_offroad.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_zonewise_count_scrap($args){
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(approved_date) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
            //$condition .= "  AND (mt_ex_onroad_datetime = null ||  mt_ex_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_scrape_vahicle.`mt_id`) as count,ems_scrape_vahicle.amb_type,ems_mas_division.div_name FROM `ems_scrape_vahicle`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_scrape_vahicle.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_scrape_vahicle.mt_amb_no"
            . " WHERE ems_scrape_vahicle.mt_ambulance_status ='Approved' AND ems_scrape_vahicle.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."'  $condition GROUP BY ems_scrape_vahicle.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_zonewise_count_tyre($args){
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
            //$condition .= "  AND (mt_onroad_datetime = null ||  mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_amb_tyre_maintaince.`mt_id`) as count,ems_amb_tyre_maintaince.amb_type,ems_mas_division.div_name FROM `ems_amb_tyre_maintaince`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_amb_tyre_maintaince.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_amb_tyre_maintaince.mt_amb_no"
            . " WHERE ems_amb_tyre_maintaince.mt_ambulance_status ='Approved' AND ems_amb_tyre_maintaince.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."'  $condition GROUP BY ems_amb_tyre_maintaince.amb_type";
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_zonewise_count_brk($args){
        $condition = '';
        $from = $args['from_date'];
        if ($args['from_date'] != '') {
            $condition .= "  AND ( DATE(mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        if ($args['from_date'] != '') {
           // $condition .= "  AND (mt_onroad_datetime = null ||  mt_onroad_datetime = '0000-00-00 00:00:00' )";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(ems_amb_breakdown_maintaince.`mt_id`) as count,ems_amb_breakdown_maintaince.amb_type,ems_mas_division.div_name FROM `ems_amb_breakdown_maintaince`"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_id = ems_amb_breakdown_maintaince.mt_district_id
               LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = ems_amb_breakdown_maintaince.mt_amb_no"
            . " WHERE ems_amb_breakdown_maintaince.mt_ambulance_status ='Approved' AND ems_amb_breakdown_maintaince.mt_isdeleted = '0' AND ems_mas_division.div_code = '".$args['zone']."' $condition GROUP BY ems_amb_breakdown_maintaince.amb_type";
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    function get_district_wise_dtl() {
        
       
        $sql = "SELECT ems_mas_division.div_name,ems_mas_districts.dst_name,ems_mas_districts.dst_code FROM `ems_mas_districts` 
        left join ems_mas_division on ems_mas_division.div_id = ems_mas_districts.div_id"
          . "  WHERE dstis_deleted = '0'  AND dst_code NOT IN ('52','53','54')";
       
          //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

      $result = $this->db->query($sql);
       //echo $this->db->last_query($result);die;
      if ($result) {
          return $result->result_array();
      } else {
          return false;
      }
  }

    function get_district_wise_general_offroad($args) {
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_amb_onroad_offroad` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_district_wise_accidental($args){
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_amb_accidental_maintaince` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_district_wise_preventive($args){
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_ambulance_preventive_maintaince` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_district_wise_manpower($args){
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.added_date) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_manpower_offroad` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_district_wise_scrap($args){
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.approved_date) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_scrape_vahicle` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_district_wise_tyre($args){
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_amb_tyre_maintaince` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_district_wise_breakdown($args){
        $condition='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND ( DATE(main_data.mt_offroad_datetime) <= '$from 23:59:59') ";
        }
        $condition .= " AND amb.amb_status IN ('7') ";
        $condition .= " AND amb.ambis_deleted ='0' ";
        $sql = "SELECT COUNT(main_data.`mt_id`) as count,main_data.amb_type,ems_mas_division.div_name FROM `ems_amb_breakdown_maintaince` as main_data"
            . " LEFT JOIN ems_mas_districts ON ems_mas_districts.dst_code = main_data.mt_district_id
              LEFT JOIN ems_mas_division ON ems_mas_division.div_id = ems_mas_districts.div_id"
            . " LEFT JOIN `ems_ambulance` as amb on amb.amb_rto_register_no = main_data.mt_amb_no"
            . " WHERE main_data.mt_ambulance_status ='Approved' AND main_data.mt_isdeleted = '0' AND ems_mas_districts.dst_code = '".$args['district']."'  $condition GROUP BY main_data.amb_type";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function total_ambulance_data(){
        $condition = '';
        $condition .= " AND amb.amb_status NOT IN ('7','11') ";
        $sql = "SELECT * FROM  `ems_ambulance` as amb "
            . " WHERE ambis_deleted='0' $condition";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
    function total_als_ambulance_data(){
        $condition = '';
        $condition .= " AND amb.amb_status NOT IN ('7','11') ";
        $sql = "SELECT * FROM  `ems_ambulance` as amb "
            . " WHERE amb_type='3' AND ambis_deleted='0' $condition";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
    function total_bls_ambulance_data(){
        $condition = '';
        $condition .= " AND amb.amb_status NOT IN ('7','11') ";
        $sql = "SELECT * FROM  `ems_ambulance` as amb "
            . " WHERE amb_type='2' AND ambis_deleted='0' $condition";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
    function total_je_ambulance_data(){
        $condition = '';
        $condition .= " AND amb.amb_status NOT IN ('7','11') ";
        $sql = "SELECT * FROM  `ems_ambulance` as amb "
            . " WHERE amb_type='1' AND ambis_deleted='0' $condition";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }

    function get_gen_offroad_count($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND mt_offroad_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND mt_offroad_datetime  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
      
       
          $sql = "SELECT COUNT(`mt_id`) as count,amb_type FROM `ems_amb_onroad_offroad`"
            . "  WHERE mt_isdeleted = '0' AND `mt_app_amb_off_status` IS NOT NULL $condition GROUP BY amb_type";
         
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    
    function get_gen_onroad_count($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND mt_offroad_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['validation_from_date'] != '' && $args['validation_to_date'] != '') {

            $from = $args['validation_from_date'];
            $to = $args['validation_to_date'];
            $condition .= "  AND mt_offroad_datetime  BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
      
       
          $sql = "SELECT COUNT(`mt_id`) as count,amb_type FROM `ems_amb_onroad_offroad`"
            . "  WHERE mt_isdeleted = '0' AND `mt_app_amb_off_status` IS NULL $condition GROUP BY amb_type";
         
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }




    /**********************************************/

    function get_closure_responce_report($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {

            $from = $args['from_date'];
            $to = $args['to_date'];
//$condition .= " AND STR_TO_DATE(epcr.date, '%m/%d/%Y') >= '$from' AND epcr.date <= '$to'";
            $date_format = '%m/%d/%Y';

//$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            $condition .= "  AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
         if($args['thirdparty'] != ''){
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "'  ";
            // $condition =  " AND inc.inc_thirdparty IN (1,2,3,4) ";
            //$condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
           
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
       
          $sql = "SELECT inc_clg.clg_last_name as inc_clg_last_name,inc_clg.clg_first_name as inc_clg_first_name,
                epcr_clg.clg_last_name as epcr_clg_last_name,epcr_clg.clg_first_name as epcr_clg_first_name,
                epcr_validate.clg_first_name as epcr_validate_clg_first_name,epcr_validate.clg_last_name as epcr_validate_clg_last_name,
                amb_area.ar_name,amb_type.ambt_name,epcr.*,third_party.thirdparty_name,epcr.inc_ref_id as incident_id,epcr.date as closure_datetime,epcr.scene_odometer as scene_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,inc.inc_added_by,epcr.base_location_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN ems_mas_ambulance_type AS amb_type ON ( amb_type.ambt_id = amb.amb_type)"
            . " LEFT JOIN ems_mas_area_types AS amb_area ON ( amb_area.ar_id = amb.amb_working_area)"
            . " LEFT JOIN ems_colleague AS inc_clg ON ( inc_clg.clg_ref_id = inc.inc_added_by)"
            . " LEFT JOIN ems_colleague AS epcr_clg ON ( epcr_clg.clg_ref_id = epcr.operate_by)"
            . " LEFT JOIN ems_colleague AS epcr_validate ON ( epcr_validate.clg_ref_id = epcr.validate_by)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
            . " LEFT JOIN ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"   
            . " WHERE epcr.is_validate ='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' AND epcr.amb_reg_id  NOT IN ('DM 00 DM 0002','DM 00 DM 0001','DM 00 DM 0000','DM 00 AM 0001','DM 00 CL 0001','DM 00 CL 0000') $condition  group by inc.inc_ref_id";
            //. " WHERE epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die;
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
       
          $sql = "SELECT epcr.*,epcr.scene_odometer as scene_odo,epcr.hospital_odometer as hospital_odo,inc.inc_recive_time as inc_recive_time ,inc.inc_added_by,hp.hp_name, loc.level_type, hp.hp_id, pro_imp.pro_name, ptn.ptn_fname,ptn.ptn_fullname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_gender, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id,inc.inc_district_id,inc.inc_ref_id,inc.inc_address"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
//            . " LEFT JOIN ems_ambulance_stock AS amb_stk ON ( amb_stk.as_sub_id = epcr.id)"
            . " WHERE epcr.provider_impressions IN ('21','41','42','43','44') AND epcr.amb_reg_id  NOT IN ('DM 00 DM 0002','DM 00 DM 0001','DM 00 DM 0000','DM 00 AM 0001','DM 00 CL 0001','DM 00 CL 0000') $condition GROUP BY epcr.inc_ref_id";


        $result = $this->db->query($sql);
    //  echo $this->db->last_query($result);die;
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
            //$condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
            $condition =  " AND epcr.third_party='" . $args['thirdparty'] . "'  ";
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

        $sql = "SELECT clg.clg_first_name,clg.clg_last_name,epcr.validate_by,epcr.validate_date,epcr.valid_remark,casetype.case_name,third_party.thirdparty_name,epcr.provider_casetype,epcr.added_date,epcr.provider_impressions,epcr.id as epcr_id,epcr.time as jctime,epcr.base_location_name,epcr.wrd_location,epcr.third_party,epcr.date as closure_date,epcr.remark,epcr.other_provider_img,epcr.start_odometer,epcr.end_odometer,epcr.rec_hospital_name,epcr.other_receiving_host,epcr.total_km,epcr.inc_ref_id as inc_reference_id,epcr.inc_datetime as inc_date,epcr.date,epcr.amb_reg_id,epcr.district_id,epcr.locality,loc.level_type,epcr.operate_by,epcr.end_odometer_remark,epcr.scene_odometer as scene_odo,epcr.from_scene_odometer as from_scene_odo,epcr.handover_odometer as handover_odo,epcr.hospital_odometer  as hospital_odo,hp.hp_name,hp.hp_code,hp.hp_id,hp.hp_district,cl_pur.pname,cl_pur.pname as inc_purpose, ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_id,ptn.ptn_age,ptn.ptn_age_type,ptn.ptn_gender,clr.clr_mobile,clr.clr_fname,clr.clr_lname,pro_imp.pro_name,inc.inc_added_by,epcr.inc_area_type,epcr.ercp_advice,epcr.ercp_advice_Taken,amb.amb_district,epcr.emso_id,epcr.emt_name,epcr.pilot_id,epcr.pilot_name,epcr.epcr_call_type,inc.patient_ava_or_not,inc_amb.base_location_name as inc_base_location_name,inc_amb.ward_name as inc_ward_name"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_call_purpose as cl_pur ON (inc.inc_type=cl_pur.pcode)"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN ems_colleague AS clg ON ( clg.clg_ref_id = epcr.validate_by )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_amb  AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " LEFT JOIN   ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"   
            . " LEFT JOIN ems_mas_provider_casetype  AS casetype ON (casetype.case_id = epcr.provider_casetype)"
            // . " WHERE epcr.is_validate ='1' AND epcris_deleted = '0' AND inc. $condition ";
            //. " WHERE epcris_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";
            . " WHERE epcr.is_validate='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0' $condition ";

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
            //$condition =  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
           
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
            . " LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " WHERE epcris_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";





        $result = $this->db->query($sql);

        //  echo $this->db->last_query($result);die;

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

            //$condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            
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
//  echo $this->db->last_query($result);
  //die;
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
        $sql = "select * from ems_ambulance where ambis_deleted = '0' AND amb_rto_register_no  NOT IN ('DM 00 DM 0002','DM 00 DM 0001','DM 00 DM 0000','DM 00 AM 0001','DM 00 CL 0001','DM 00 CL 0000') AND amb_user_type='108'";
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

    function get_nhm_104_all_call_by_date($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            // $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
            $condition .= "ems_inc.inc_recive_time BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT ems_inc.*, ems_inc.inc_ref_id,ems_inc.inc_recive_time,ems_inc.inc_datetime,ems_inc.inc_dispatch_time,ems_inc.inc_ero_summary,ems_rem.re_name,cl_pur.pname As cl_pur_name ,emp_cmp.cmp_name,ems_clg.clg_first_name,ems_clg.clg_mid_name,ems_clg.clg_last_name,ems_inc.inc_added_by,non_clr.clr_mobile,non_clr.clr_fname,non_clr.clr_lname,non_pur.pname as call_type_name,dis.dst_name,tah.thl_name,ptnt.ptn_fname,ptnt.ptn_mname,ptnt.ptn_lname,ptnt.ptn_gender,ptnt.ptn_age,ptnt.ptn_mob_no,ptnt.ayushman_id,bld_grp.bldgrp_name"
            . " FROM `ems_incidence` as ems_inc"
            . " LEFT JOIN ems_colleague as ems_clg ON ( ems_inc.inc_added_by = ems_clg.clg_ref_id )"
            . " LEFT JOIN ems_mas_ero_remark as ems_rem ON ( ems_inc.help_standard_summary = ems_rem.re_id )"
            . " LEFT JOIN ems_mas_call_purpose as cl_pur ON ( ems_inc.inc_type = cl_pur.pcode )"
            . " LEFT JOIN ems_non_eme_calls as non_call ON ( ems_inc.inc_ref_id = non_call.ncl_inc_ref_id )"
            . " LEFT JOIN ems_mas_call_purpose as non_pur ON ( non_pur.pcode = non_call.ncl_cl_purpose )"
            . " LEFT JOIN ems_callers as non_clr ON ( non_call.ncl_clr_id = non_clr.clr_id )"
            . " LEFT JOIN ems_help_complaints_type as emp_cmp ON ( ems_inc.help_complaint_type = emp_cmp.cmp_id )"
            . " LEFT JOIN ems_mas_districts as dis ON ( dis.dst_id = ems_inc.inc_district_id )"
            . " LEFT JOIN ems_mas_tahshil as tah ON ( tah.thl_id = ems_inc.inc_tahshil_id )"
            . " LEFT JOIN ems_incidence_patient as patient ON ( patient.inc_id = ems_inc.inc_ref_id )"
            . " LEFT JOIN ems_patient as ptnt ON ( ptnt.ptn_id = patient.ptn_id )"
            . " LEFT JOIN ems_mas_bloodgrp_type as bld_grp ON ( bld_grp.bldgrp_id = ptnt.ptn_bgroup )"
            . " WHERE ems_inc.inc_system_type = '104' AND ems_inc.inc_type != 'HELP_EME_CALL_MED' AND ems_inc.incis_deleted = '0' AND $condition GROUP BY ems_inc.inc_ref_id ORDER BY ems_inc.inc_ref_id ASC";
        // echo $sql;
        $result = $this->db->query($sql);
// print_r("This is eresult");   
        if ($result) {
            return $result->result_array(); 
        } else {
            return false;
        }
    }

    function get_nhm_104_medical_call_by_date($args) {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            // $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
            $condition .= "ems_inc.inc_recive_time BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT ems_inc.*, ems_inc.inc_ref_id,ems_inc.inc_recive_time,ems_inc.inc_datetime,ems_inc.inc_dispatch_time,ems_inc.inc_ero_summary,ems_rem.re_name,cl_pur.pname,hp_cmp.ct_type As cheif_comp,ems_clg.clg_first_name As ero_first_name,ems_clg.clg_mid_name As ero_mid_name,ems_clg.clg_last_name As ero_last_name,ems_inc.inc_added_by,non_clr.clr_mobile,non_clr.clr_fname,non_clr.clr_lname,inc_adv.adv_cl_addinfo,inc_adv.adv_cl_pro_dia,inc_adv.adv_cl_ercp_addinfo,emt_cmp.ct_type As epcr_comp,ercp_clg.clg_first_name As ercp_first_name,ercp_clg.clg_mid_name As ercp_mid_name,ercp_clg.clg_last_name As ercp_last_name,inc_adv.adv_cl_added_by,dis.dst_name,tah.thl_name,ptnt.ptn_fname,ptnt.ptn_mname,ptnt.ptn_lname,ptnt.ptn_gender,ptnt.ptn_age,ptnt.ptn_mob_no,ptnt.ayushman_id,bld_grp.bldgrp_name"
            . " FROM `ems_incidence` as ems_inc"
            . " LEFT JOIN ems_colleague as ems_clg ON ( ems_inc.inc_added_by = ems_clg.clg_ref_id )"
            . " LEFT JOIN ems_mas_ero_remark as ems_rem ON ( ems_inc.help_standard_summary = ems_rem.re_id )"
            . " LEFT JOIN ems_mas_call_purpose as cl_pur ON ( ems_inc.inc_type = cl_pur.pcode )"
            . " LEFT JOIN ems_non_eme_calls as non_call ON ( ems_inc.inc_ref_id = non_call.ncl_inc_ref_id )"
            . " LEFT JOIN ems_calls as med_cl ON ( ems_inc.inc_cl_id = med_cl.cl_id )"  
            . " LEFT JOIN ems_callers as non_clr ON ( med_cl.cl_clr_id = non_clr.clr_id )"
            . " LEFT JOIN ems_complaint_types_help_desk as hp_cmp ON ( ems_inc.help_desk_chief_complaint = hp_cmp.ct_id )"
            . " LEFT JOIN ems_help_desk_advice as inc_adv ON ( ems_inc.inc_ref_id = inc_adv.adv_cl_inc_id )"
            . " LEFT JOIN ems_complaint_types_help_desk as emt_cmp ON ( inc_adv.adv_cl_madv_que = emt_cmp.ct_id ) "
            . " LEFT JOIN ems_colleague as ercp_clg ON ( inc_adv.adv_cl_added_by = ercp_clg.clg_ref_id ) "
            . " LEFT JOIN ems_mas_districts as dis ON ( dis.dst_id = ems_inc.inc_district_id )"
            . " LEFT JOIN ems_mas_tahshil as tah ON ( tah.thl_id = ems_inc.inc_tahshil_id )"
            . " LEFT JOIN ems_incidence_patient as patient ON ( patient.inc_id = ems_inc.inc_ref_id )"
            . " LEFT JOIN ems_patient as ptnt ON ( ptnt.ptn_id = patient.ptn_id )"
            . " LEFT JOIN ems_mas_bloodgrp_type as bld_grp ON ( bld_grp.bldgrp_id = ptnt.ptn_bgroup )"
            . " WHERE ems_inc.inc_system_type = '104' AND ems_inc.inc_type = 'HELP_EME_CALL_MED' AND ems_inc.incis_deleted = '0' AND $condition GROUP BY ems_inc.inc_ref_id ORDER BY ems_inc.inc_ref_id ASC";
        // echo $sql;
        $result = $this->db->query($sql);
        // print_r("This is eresult");  
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
            $condition .= " AND amb.amb_user_type  = '$system'";
        }
        $sql = "SELECT inc.*, inc_ptn.ptn_id, ptn.ptn_fullname, ptn.ptn_age, clr.clr_fullname, clr.clr_mobile"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_amb AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " WHERE inc.inc_type IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP','EMG_PVT_HOS') AND inc.incis_deleted='0' $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
        
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
            . " WHERE inc.incis_deleted ='0' AND inc.inc_type NOT IN ('NON_MCI','AD_SUP_REQ','DROP_BACK','IN_HO_P_TR','MCI','EMT_MED_AD','PREGANCY_CALL','VIP_CALL','Child_CARE_CALL','on_scene_care','PICK_UP')  $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
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
            //$condition .=  " AND inc.inc_thirdparty='" . $args['thirdparty'] . "' AND inc.inc_district_id = '" . $args['clg_district_id'] . "' ";
           
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
         
            
            $sql = "SELECT inc.*,epcr.provider_casetype,epcr.time,casetype.case_type,inc_amb.ward_name,amb.amb_default_mobile,amb.amb_pilot_mobile,std_remark.re_name,inc_amb.base_location_name,clr.clr_fullname,clr.clr_fname,clr.clr_lname,epcr.other_receiving_host,epcr.other_provider_img,epcr.scene_odometer as scene_odo,epcr.hospital_odometer  as hospital_odo,epcr.remark,epcr.ercp_advice,epcr.ercp_advice_Taken, clr.clr_mobile,cl.clr_ralation,cl.cl_purpose,amb.amb_rto_register_no, ptn.ptn_gender, ptn.ptn_age, ptn.ptn_age_type, ptn.ptn_condition,ptn.ptn_district,ptn.ptn_fname,ptn.ptn_lname,in_fa.rpt_doc,in_fa.new_rpt_doc,in_fa.mo_no,in_fa.new_mo_no,in_fa.new_district,in_fa.current_district,in_fa.facility,in_fa.new_facility,amb.amb_type,amb.amb_base_location,amb.amb_working_area,epcr.provider_impressions,driv_pcr.inc_dispatch_time,driv_pcr.inc_dispatch_time,driv_pcr.start_from_base,driv_pcr.start_odometer,driv_pcr.end_odometer,driv_pcr.dp_on_scene,driv_pcr.dp_reach_on_scene,driv_pcr.dp_cl_from_desk,driv_pcr.dp_hand_time,driv_pcr.dp_hosp_time,driv_pcr.dp_back_to_loc,epcr.rec_hospital_name,inc_amb.amb_pilot_id,inc_amb.amb_emt_id,epcr.date,epcr.operate_by,inc.inc_dispatch_time as call_duration,epcr.emso_id,epcr.emt_name,epcr.emt_id_other,epcr.pilot_id,epcr.pilot_name,epcr.pilot_id_other"
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
        // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    


    function get_pending_closure_report($args =array()){
        $condition = $offlim = '';
      
       if ($args['from_date'] != '' && $args['to_date'] != '') {
           $from = $args['from_date'];
           $to = $args['to_date'];
           $condition .= " AND  inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
       }

    if($args['district'] != ''){
        $district = $args['district'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND dis.dst_id IN (" . $dis . ")";
    }
        //  if ($args['base_month'] != '') {
        //      //$condition .= "AND inc.inc_base_month IN ( " . (int)$args['base_month'] . " ," . (int)$args['base_month'] - 1 . "," . (int)$args['base_month'] - 2 . ")";
        //     $condition .= " AND inc.inc_base_month IN ( " . ($args['base_month']-1) . "," . $args['base_month'] . ")";
        // }

           $sql ="SELECT incamb.inc_ref_id,incamb.amb_rto_register_no,zon.div_name as zone_name,amb.amb_default_mobile,inc.inc_pcr_status,base.hp_name,inc.inc_datetime,amb.amb_type,dis.dst_name FROM `ems_incidence_ambulance` as incamb 
           LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no 
           LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id 
           LEFT JOIN ems_mas_districts as dis ON dis.dst_id = amb.amb_district
           LEFT JOIN ems_mas_division as zon ON zon.div_code = dis.div_id"
           . " WHERE  (inc.inc_pcr_status = '0' OR inc.inc_pcr_status IS null)  $condition ";

     
       $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }
   }

   function get_amb_logout($args = array()) {
    // $condition = '';
    $condition = $offlim = '';
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
    if ($args['incient_district'] != 'all') {
        $condition .= " AND amb.amb_district = '" . $args['incient_district'] . "' ";
    } 

 
    //  if ($args['district'] != '') {
    //     $condition .= " AND amb.amb_district = '" . $args['district'] . "' ";
    // }
    
    // if ($args['from_date'] != '' && $args['to_date'] != '') {
    //     $from = $args['from_date'];
    //     $to = $args['to_date'];

    //     $condition .= " AND amb.amb_added_date BETWEEN '$from' AND '$to 23:59:59'";
    // }
//     if ($args['login_type'] != '') {
//         $condition .= " AND login_type IN ('" . $args['login_type'] . "')";
//    }

$sql ="SELECT MAX(log_user.login_time *1) AS login_time,log_user.vehicle_no,log_user.status,base.hp_name,dis.dst_name,divi.div_name,am_type.ambt_name,amb.amb_default_mobile
FROM `ems_app_login_session` as log_user"
. " LEFT JOIN `ems_ambulance` as amb ON (amb.amb_rto_register_no = log_user.vehicle_no)"
. " LEFT JOIN `ems_mas_districts` AS dis ON (dis.dst_code = amb.amb_district )"
. " LEFT JOIN `ems_base_location` as base ON (amb.amb_base_location = base.hp_id) "
. " LEFT JOIN `ems_mas_division` AS divi ON (divi.div_code = amb.amb_div_code )"
. " LEFT JOIN `ems_mas_area_types` AS area ON (area.ar_id = amb.amb_working_area )"
. " LEFT JOIN `ems_mas_ambulance_type` AS am_type ON (am_type.ambt_id = amb.amb_type )"
. " WHERE log_user.status = '2' $condition group by log_user.vehicle_no DESC";

    $result = $this->db->query($sql);
//    echo $this->db->last_query($result);die;
//   print_r($result);die;
$abc = $result->result_array();
// print_r($abc);die;
//     if ($args['get_count']) {
//         return $result->num_rows();
//     } else {
//         return $result->result_array();
//     }
return $abc;
}

   function get_mdt_login_report($args =array()){
    $condition = $offlim = '';
  
//    if ($args['to_date'] != '') {
//        $from = $args['from_date'];
//        $to = $args['to_date'];
//        $condition .= "AND  inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
//    }

        if ($args['login_type'] != '') {
            $condition .= " AND login_type IN ('" . $args['login_type'] . "')";
       }
       if($args['district'] != ''){
        $district = $args['district'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND district.dst_code IN (" . $dis . ")";
    }
    if($args['zone'] != '' && $args['zone'] != 'All'){
        $zone=$args['zone'];
        $condition .= " AND zone.div_code IN (" . $zone . ")";
    }
       $sql ="SELECT log_user.vehicle_no,log_user.login_time,log_user.login_type,log_user.status,base.hp_name,district.dst_name,zone.div_name,type.ambt_name,amb.amb_default_mobile
       FROM `ems_app_login_session` as log_user 
       LEFT JOIN ems_ambulance as amb ON amb.amb_rto_register_no = log_user.vehicle_no
       LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id
       LEFT JOIN ems_mas_districts as district ON amb.amb_district = district.dst_code
       LEFT JOIN ems_mas_division as zone ON district.div_id = zone.div_code
       LEFT JOIN ems_mas_ambulance_type as type ON amb.amb_type = type.ambt_id
       WHERE log_user.status = '1' $condition ";


   $result = $this->db->query($sql);
//    echo $this->db->last_query();die ;
   if ($args['get_count']) {
       return $result->num_rows();
   } else {
       return $result->result();
   }
}
   
   function get_pending_validation_report($args =array()){
    $condition = $offlim = '';
  
   if ($args['from_date'] != '' && $args['to_date'] != '') {
       $from = $args['from_date'];
       $to = $args['to_date'];
       $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to' AND ";
   }
   if($args['district'] != ''){
    $district = $args['district'];
    // print_r ( $district );die;
    $dis = implode(",",$district);
    $condition .= " amb_dist.dst_code IN (" . $dis . ")  AND";
    }
 
    //  if ($args['base_month'] != '') {
    //      //$condition .= "AND inc.inc_base_month IN ( " . (int)$args['base_month'] . " ," . (int)$args['base_month'] - 1 . "," . (int)$args['base_month'] - 2 . ")";
    //     $condition .= " AND inc.inc_base_month IN ( " . ($args['base_month']-1) . "," . $args['base_month'] . ")";
    // }

       $sql ="SELECT inc.inc_recive_time,epcr.date as epcr_date,epcr.time as epcr_time,amb_data.amb_default_mobile,inc_amb.amb_rto_register_no,epcr.inc_ref_id,amb_dist.dst_name,amb_div.div_name,epcr.operate_by,base_loc.hp_name,epcr.is_validate,inc.inc_added_by,amb_data.amb_type,CONCAT (col.clg_first_name,' ',col.clg_mid_name,' ',col.clg_last_name) AS operateby_full_name,CONCAT (col1.clg_first_name,' ',col1.clg_mid_name,' ',col1.clg_last_name) AS assignby_full_name,inc.inc_datetime FROM ems_epcr as epcr 
       LEFT JOIN ems_incidence as inc ON (epcr.inc_ref_id=inc.inc_ref_id)
       LEFT JOIN ems_incidence_ambulance as inc_amb ON (epcr.inc_ref_id=inc_amb.inc_ref_id)
       LEFT JOIN ems_ambulance as amb_data ON (inc_amb.amb_rto_register_no=amb_data.amb_rto_register_no)
       LEFT JOIN ems_mas_districts as amb_dist ON (amb_data.amb_district=amb_dist.dst_code)
       LEFT JOIN ems_mas_division as amb_div ON (amb_dist.div_id=amb_div.div_code)
       LEFT JOIN ems_base_location as base_loc ON (amb_data.amb_base_location=base_loc.hp_id)
       LEFT JOIN ems_colleague as col ON (col.clg_ref_id = epcr.operate_by)
       LEFT JOIN ems_colleague as col1 ON (col1.clg_ref_id = inc.inc_added_by)" 
       . " WHERE $condition inc.inc_pcr_status='1' AND epcr.epcris_deleted='0' AND inc_duplicate='no' AND incis_deleted='0' AND epcr.is_validate='0' AND  operate_by NOT LIKE '%DCO%' GROUP BY epcr.inc_ref_id";

 
   $result = $this->db->query($sql);
//    echo $this->db->last_query();die;
   if ($args['get_count']) {
       return $result->num_rows();
   } else {
       return $result->result();
   }
}
function get_assigned_cases_report_zone($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    if($args['district'] != ''){
        $district = $args['district'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND dis.dst_id IN (" . $dis . ")";
    }
    $sql ="SELECT count(incamb.inc_ref_id) as assing,amb_div.div_name FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as dis ON dis.dst_id = amb.amb_district LEFT JOIN ems_mas_division as amb_div ON dis.div_id=amb_div.div_code" 
    . " WHERE amb_div.div_deleted = '0' AND $condition GROUP BY amb_div.div_name ORDER by amb_div.div_name ASC";

    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }

}
function get_closed_cases_report_zone($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    if($args['district'] != ''){
        $district = $args['district'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND dis.dst_id IN (" . $dis . ")";
    }
    
    $sql ="SELECT count(incamb.inc_ref_id) as closed,amb_div.div_name FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as dis ON dis.dst_id = amb.amb_district LEFT JOIN ems_mas_division as amb_div ON dis.div_id=amb_div.div_code"
    ." WHERE inc.inc_pcr_status = '1' AND amb_div.div_deleted = '0' AND $condition GROUP BY amb_div.div_name ORDER by amb_div.div_name ASC";

    $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }
}
function get_pending_colsure_cases_report_zone($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    if($args['district'] != ''){
        $district = $args['district'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND dis.dst_id IN (" . $dis . ")";
    }

    $sql ="SELECT count(incamb.inc_ref_id) as pendclose,amb_div.div_name FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as dis ON dis.dst_id = amb.amb_district LEFT JOIN ems_mas_division as amb_div ON dis.div_id=amb_div.div_code"
    ." WHERE (inc.inc_pcr_status = '0' OR inc.inc_pcr_status IS null) AND amb_div.div_deleted = '0' AND $condition GROUP BY amb_div.div_name ORDER by amb_div.div_name ASC";

    $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }
}
function get_assigned_cases_report_dis($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    $dst = $args['dst_id'];
    // $sql ="SELECT count(incamb.inc_ref_id) as assing,amb_dis.dst_name FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code"
    // . " WHERE amb_dis.dstis_deleted = '0' AND $condition GROUP BY amb_dis.dst_name ORDER by amb_dis.dst_name ASC";

    $sql ="SELECT count(incamb.inc_ref_id) as assing,amb_dis.dst_name FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code"
    . " WHERE amb_dis.dst_id = '$dst' AND $condition ";


    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }
}
function get_closed_cases_report_dis($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    $dst = $args['dst_id'];
    // $sql ="SELECT count(incamb.inc_ref_id) as closed FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code"
    // . " WHERE inc.inc_pcr_status = '1' AND amb_dis.dstis_deleted = '0' AND $condition GROUP BY amb_dis.dst_name ORDER by amb_dis.dst_name ASC";

    $sql ="SELECT count(incamb.inc_ref_id) as closed FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code"
    . " WHERE inc.inc_pcr_status = '1' AND amb_dis.dst_id = '$dst' AND $condition ";


    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }

}
function get_pending_colsure_cases_report_dis($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    $dst = $args['dst_id'];
    // $sql ="SELECT count(incamb.inc_ref_id) as pendclose FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code"
    // . " WHERE (inc.inc_pcr_status = '0' OR inc.inc_pcr_status IS null) AND amb_dis.dstis_deleted = '0' AND $condition GROUP BY amb_dis.dst_name ORDER by amb_dis.dst_name ASC";
    $sql ="SELECT count(incamb.inc_ref_id) as pendclose FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code"
    . " WHERE (inc.inc_pcr_status = '0' OR inc.inc_pcr_status IS null) AND amb_dis.dst_id = '$dst' AND $condition ";

    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }

}


function get_dist(){
    $sql ="SELECT dst_id,dst_name FROM ems_mas_districts WHERE ems_mas_districts.dstis_deleted = '0' ORDER BY dst_name";

    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
       
           return $result->result();
       
}

function get_assigned_cases_report_amb($args =array()){
    $condition = $offlim = '';
  
    // print_r($args);die();
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    if($args['dst_id'] != ''){
        $district = $args['dst_id'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND amb_dis.dst_code IN (" . $dis . ")";
    }
    $amb_no = $args['amb_no'];

    $sql ="SELECT count(incamb.inc_ref_id) as assing,incamb.amb_rto_register_no,amb.amb_default_mobile,base.hp_name,amb_dis.dst_name,amb_div.div_name,amb_type.ambt_name FROM `ems_incidence_ambulance` as incamb 
    LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id 
    LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no 
    LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id
    LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code
    LEFT JOIN ems_mas_division as amb_div ON amb_div.div_id=amb_dis.div_id
    LEFT JOIN ems_mas_ambulance_type as amb_type ON amb_type.ambt_id=amb.amb_type"
    . " WHERE incamb.amb_rto_register_no = '$amb_no' AND  $condition GROUP BY incamb.amb_rto_register_no ORDER by incamb.amb_rto_register_no ASC";

    $result = $this->db->query($sql);
    return $result->result();
    // echo $this->db->last_query();die;
    //    if ($args['get_count']) {
    //        return $result->num_rows();
    //    } else {
    //        return $result->result();
    //    }
}
function get_closed_cases_report_amb($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    if($args['dst_id'] != ''){
        $district = $args['dst_id'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND amb_dis.dst_code IN (" . $dis . ")";
    }
    $amb_no = $args['amb_no'];

    // $sql ="SELECT count(incamb.inc_ref_id) as closed,incamb.amb_rto_register_no FROM `ems_incidence_ambulance` as incamb
    // LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id
    // LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no
    // LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id"
    $sql ="SELECT count(incamb.inc_ref_id) as closed,incamb.amb_rto_register_no,base.hp_name,amb_dis.dst_name,amb_div.div_name,amb_type.ambt_name FROM `ems_incidence_ambulance` as incamb 
    LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id 
    LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no 
    LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id
    LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code
    LEFT JOIN ems_mas_division as amb_div ON amb_div.div_id=amb_dis.div_id
    LEFT JOIN ems_mas_ambulance_type as amb_type ON amb_type.ambt_id=amb.amb_type"
    . " WHERE incamb.amb_rto_register_no = '$amb_no' AND inc.inc_pcr_status = '1' AND $condition GROUP BY incamb.amb_rto_register_no ORDER by incamb.amb_rto_register_no ASC";

    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }

}
function get_pending_colsure_cases_report_amb($args =array()){
    $condition = $offlim = '';
  
    if ($args['from_date'] != '' && $args['to_date'] != '') {
        $from = $args['from_date'];
        $to = $args['to_date'];
        $condition .= "inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
    }
    if($args['dst_id'] != ''){
        $district = $args['dst_id'];
        // print_r ( $district );die;
        $dis = implode(",",$district);
        $condition .= " AND amb_dis.dst_code IN (" . $dis . ")";
    }

    $amb_no = $args['amb_no'];

    // $sql ="SELECT count(incamb.inc_ref_id) as pendclose FROM `ems_incidence_ambulance` as incamb LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id"
    $sql ="SELECT count(incamb.inc_ref_id) as pendclose,incamb.amb_rto_register_no,base.hp_name,amb_dis.dst_name,amb_div.div_name,amb_type.ambt_name FROM `ems_incidence_ambulance` as incamb 
    LEFT JOIN ems_incidence as inc ON incamb.inc_ref_id = inc.inc_ref_id 
    LEFT JOIN ems_ambulance as amb ON incamb.amb_rto_register_no = amb.amb_rto_register_no 
    LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id
    LEFT JOIN ems_mas_districts as amb_dis ON amb.amb_district=amb_dis.dst_code
    LEFT JOIN ems_mas_division as amb_div ON amb_div.div_id=amb_dis.div_id
    LEFT JOIN ems_mas_ambulance_type as amb_type ON amb_type.ambt_id=amb.amb_type"
    . " WHERE incamb.amb_rto_register_no = '$amb_no' AND (inc.inc_pcr_status = '0' OR inc.inc_pcr_status IS null) AND $condition GROUP BY incamb.amb_rto_register_no ORDER by incamb.amb_rto_register_no ASC";

    $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
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
        $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) LEFT JOIN ems_epcr as epcr on (inc_ptn.ptn_id=epcr.ptn_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' AND inc.inc_type IN ('MCI','AD_SUP_REQ','NON_MCI','EMT_MED_AD','VIP_CALL','DROP_BACK','PREGANCY_CALL','Child_CARE_CALL','EMG_PVT_HOS','PICK_UP','PICKUP_CALL') $condition ";
      
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
       //echo $this->db->last_query();die;
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
        if ($args['filter_time'] == '0_2') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
            $to_date = date('Y-m-d H:i:s');
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
     
       }

       if ($args['filter_time'] == '2_6') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-6 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-2 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '6_12') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-12 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-6 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '12_18') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-18 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-12 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '18_24') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-24 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-18 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '24_more') {
    
            $from_date = "2022-08-01 00:00:00";
            $to_date = date('Y-m-d H:i:s', strtotime('-24 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        $sql = "SELECT inc.inc_ref_id,inc.inc_datetime FROM ems_incidence as inc LEFT JOIN ems_incidence_ambulance as inc_amb on (inc.inc_ref_id=inc_amb.inc_ref_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '0' AND inc.incis_deleted = '0' $condition group by inc.inc_ref_id";
        
     

        $result = $this->db->query($sql);
// echo $this->db->last_query();die();
        return $result->result();
        
    }

    // get_validation_pending_ambulance_wise
    function get_validation_pending_ambulance_wise($args = array()){
        
        $condition = $offlim = '';
        $Where = "where epcr.is_validate = '0'";
        $condition .= " AND inc.incis_deleted = '0' AND epcr.epcris_deleted='0'  AND  epcr.operate_by NOT LIKE '%DCO%' ";
        if ($args['amb_reg_no']) {

            $condition .= " AND inc_amb.amb_rto_register_no = '".$args['amb_reg_no']."'";

        }
        if ($args['filter_time'] == '0_2') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-2 hour'));
            $to_date = date('Y-m-d H:i:s');
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
     
       }

       if ($args['filter_time'] == '2_6') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-6 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-2 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '6_12') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-12 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-6 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '12_18') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-18 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-12 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '18_24') {
    
            $from_date = date('Y-m-d H:i:s', strtotime('-24 hour'));
            $to_date = date('Y-m-d H:i:s', strtotime('-18 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        if ($args['filter_time'] == '24_more') {
    
            $from_date = "2022-08-01 00:00:00";
            $to_date = date('Y-m-d H:i:s', strtotime('-24 hour')); 
            $condition .= " AND inc.inc_datetime BETWEEN '".$from_date." ' AND  '".$to_date."'";
 
        }

        $sql = "SELECT inc.inc_ref_id,inc.inc_datetime FROM ems_incidence as inc LEFT JOIN ems_incidence_ambulance as inc_amb on (inc.inc_ref_id=inc_amb.inc_ref_id)  LEFT JOIN ems_epcr AS epcr ON epcr.inc_ref_id = inc_amb.inc_ref_id  
        LEFT JOIN ems_ambulance AS amb ON amb.amb_rto_register_no  = inc_amb.amb_rto_register_no $Where  $condition group by inc.inc_ref_id";
        
     

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

            . " LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"

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

            . " LEFT JOIN $this->tbl_base_location AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"

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

            //$condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

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

            //$condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

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

            //$condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

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

            //$condition .= " AND amb.thirdparty='" . $args['thirdparty_type'] . "' ";

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
        if($args['thirdparty'] != ''){
            $condition .=  " AND epcr.third_party='" . $args['thirdparty'] . "'  ";
            //$condition .=  " AND epcr.third_party='" . $args['thirdparty'] . "' AND epcr.district_id = '" . $args['clg_district_id'] . "' ";
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
            $sql = "SELECT epcr.*,third_party.thirdparty_name,epcr.inc_ref_id as incident_id,inc.inc_recive_time as inc_recive_time ,inc.inc_type, ptn.ptn_fname, inc.inc_datetime as inc_date, inc.inc_datetime as inc_date_time,driv_pcr.*,resp.*,epcr.id as epcr_id"
            
                . " FROM $this->tbl_epcr AS epcr"
    
                . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
    
                . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
    
                 . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
                 . " LEFT JOIN   ems_mas_thirdparty AS third_party ON (third_party.thirdparty_id = inc.inc_thirdparty )"   
                . " LEFT JOIN $this->tbl_mas_responce_remark AS resp ON ( resp.id = driv_pcr.responce_time_remark)"
                . " WHERE epcris_deleted = '0' AND epcr.amb_reg_id  NOT IN ('DM 00 DM 0002','DM 00 DM 0001','DM 00 DM 0000','DM 00 AM 0001','DM 00 CL 0001','DM 00 CL 0000') $condition ";
                //. " WHERE epcris_deleted = '0' AND epcr.provider_impressions NOT IN ('21','41','42','43','44') $condition ";
        //     echo $sql;
        //    die();
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
    //$condition .= "AND inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
    
    if ($args['inc_ref_id'] != '') {
            $condition .= " AND inc.inc_ref_id ='" . $args['inc_ref_id'] . "' ";
    }
        
    $sql = "SELECT inc.inc_pcr_status,inc.inc_system_type,inc.inc_ref_id,inc.inc_lat,inc.inc_long,inc.inc_datetime,mn.ntr_nature,inc_com.ct_type,inc_amb.amb_rto_register_no,dst.dst_name,dst.dst_lat,dst.dst_lang,inc.inc_tahshil_id,inc.inc_address,tahsil.thl_name,tahsil.thl_lat,tahsil.thl_lng,city.cty_name,amb.amb_lat,amb.amb_log,inc.inc_district_id,divs.div_name,amb.amb_type,dst.div_id,inc.inc_type"
    
        . " FROM $this->tbl_incidence AS inc"
        
        . " LEFT JOIN  $this->mas_patient_complaint_types AS inc_com ON ( inc_com.ct_id = inc.inc_complaint )"
        
        . " LEFT JOIN $this->tbl_mas_micnature as mn on(mn.ntr_id=inc.inc_mci_nature)"

        . " LEFT JOIN  $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
        
        . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
        
        . " LEFT JOIN ems_mas_districts AS dst ON ( dst.dst_code = inc.inc_district_id )"
        . " LEFT JOIN ems_mas_division AS divs ON ( divs.div_code = dst.div_id )"    
        . " LEFT JOIN $this->tbl_tahshil AS tahsil ON ( tahsil.thl_code = inc.inc_tahshil_id )"
        . " LEFT JOIN ems_mas_city AS city ON ( city.cty_id = inc.inc_city_id )"
        . " WHERE 1=1 AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type NOT IN ('NON_MCI_WITHOUT_AMB') AND inc_amb.amb_rto_register_no NOT IN ('TT-00-MP-0000')   $condition group by inc.inc_ref_id  ";
    
    $result = $this->db->query($sql);
    //echo $this->db->last_query(); die();
    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
    function get_inc_epcr_data($args){
        if ($args['inc_ref_id'] != '') {
            $condition .= " AND epcr.inc_ref_id ='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT epcr.*,pro_imp.pro_name,pro_imp.b12_type,pt.ptn_fullname,pt.ptn_fname,pt.ptn_lname,pt.ptn_gender,pt.ptn_age,count(epcr.inc_ref_id) as total_patient"
        . " FROM $this->tbl_epcr AS epcr"
        . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
        . " LEFT JOIN ems_patient as pt ON pt.ptn_id = epcr.ptn_id"
        . " WHERE  epcris_deleted ='0' AND is_validate ='1'  AND pt.ptnis_deleted ='0' $condition  ";

    $result = $this->db->query($sql);
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
function insert_non_eme_data($args){
    $result = $this->db->insert($this->tbl_incidence, $args);
    // echo $this->db->last_query();die;
    if ($result) {

        return $result;
    } else {
        return false;
    }
}
function get_analytics_epcr_data(){
   $to_date = date('Y-m-d', strtotime('now - 1day'));
   $to_date = date('Y-m-d');
   // $from_date = date('Y-m-d', strtotime('now - 10day'));
   $from_date = date('2022-08-01');
    $condition .= "AND inc.inc_datetime BETWEEN '$from_date 00:00:00' AND '$to_date 23:59:59'";
    $sql = "SELECT * "
        . " FROM $this->incidanace_analyatics_data AS inc"
        . " WHERE inc.inc_pcr_status = '0'  $condition";

    $result = $this->db->query($sql);
    //echo $this->db->last_query(); die();
    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
function get_analytics_epcr_data_by_date($args = array()){
    
   $to_date = date('Y-m-d', strtotime($args['to_date']));
    $from_date = date('Y-m-d', strtotime($args['from_date']));
    $condition .= "AND inc.inc_datetime BETWEEN '$to_date 00:00:00' AND '$from_date 23:59:59'";
     $sql = "SELECT * "
        . " FROM $this->incidanace_analyatics_data AS inc"
        . " WHERE inc.total_pt = '0'  $condition";

   
    $result = $this->db->query($sql);
    //echo $this->db->last_query(); die();
    if ($result) {
        return $result->result();
    } else {
        return false;
    }
}
        function get_inc_epcr_analytic_data($args){
        if ($args['inc_ref_id'] != '') {
            $condition .= " AND epcr.inc_ref_id ='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT epcr.*,pro_imp.pro_name,pro_imp.b12_type,pt.ptn_fullname,pt.ptn_fname,pt.ptn_lname,pt.ptn_gender,pt.ptn_age,count(epcr.inc_ref_id) as total_patient"
        . " FROM $this->tbl_epcr AS epcr"
        . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
        . " LEFT JOIN ems_patient as pt ON pt.ptn_id = epcr.ptn_id"
        . " WHERE  epcris_deleted ='0' AND is_validate = '1' AND pt.ptnis_deleted ='0'  $condition  ";
   
    $result = $this->db->query($sql);
   // echo $this->db->last_query();die();
    if ($result) {
        return $result->result();
    } else {
        return false;
    }
    }
    function update_analytics_data($args) {

        if($args['inc_ref_id'] != ''){
            $this->db->where_in('inc_ref_id', $args['inc_ref_id']);
            $data = $this->db->update("$this->incidanace_analyatics_data", $args);
            
            return $data;
        }
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
                ." where  epcr.epcris_deleted = '0'  AND is_validate='1' $condition ";
        $result = $this->db->query($sql);

        if ($args['get_count']) {
        return $result->num_rows();
        } else {
        return $result->result();
        }
    }

    function  get_total_district_data_validate($args,$pro=array()){

        $From_date = date('Y-m-01');
        $to_date = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
        $from_date=date('Y-m-d', strtotime($From_date));
        $to_date= date('Y-m-d', strtotime($to_date));
            

        if ($from_date != '' && $to_date != '') {
            $from = $from_date;
            $to = $to_date;
           // $date_format = '%m/%d/%Y';
           // $condition .=  " AND STR_TO_DATE(`epcr`.`date`, '$date_format') BETWEEN '$from' AND '$to'";  
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        
        if($args['district_id'] != ''){
               
            $condition .= " AND epcr.district_id = '" . $args['district_id'] . "'";
        }
                $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                ." where  epcr.epcris_deleted = '0'  AND epcr.is_validate ='1' AND epcr.system_type='108' AND epcr.provider_impressions IN ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','45','46','47','48','49','50','51','52','53','54','55','56','57','58') $condition ";
            $result = $this->db->query($sql);
            // echo $this->db->last_query(); die();
    
            if ($args['get_count']) {
            return $result->num_rows();
            } else {
            return $result->result();
            }
    
      }
      function get_b12_data_report_108($args){
            $condition = '';
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            }
            if ($args['sys_type'] != '') {
                $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
            }
            $condition .= " AND inc.inc_type NOT IN ('DROP_BACK','PICK_UP','IN_HO_P_TR')";
            $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

            $sql =  "SELECT epcr.provider_impressions,pro_imm.pro_name,count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
                . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                ." where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition GROUP By pro_name  order By total_count DESC";
            //echo $sql;die();
            $result = $this->db->query($sql);
            if ($args['get_count']) {

                return $result->num_rows();
            } else {
                return $result->result();
            }
            
      }
      function get_pickup108_data_report($args){
        $condition = '';
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            }
            if ($args['sys_type'] != '') {
                $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
            }
            $condition .= " AND inc.inc_type IN ('PICK_UP')"; 
            $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

            $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
                . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
            //echo $sql;die();
            $result = $this->db->query($sql);
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
      }
      function get_janani_other_data_report($args){
        $condition = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type NOT IN ('DROP_BACK','IN_HO_P_TR','PICK_UP')"; 
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
            . " FROM $this->tbl_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
        //echo $sql;die();
        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
      }
      function get_drop108_data_report($args){
        $condition = '';
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            }
            if ($args['sys_type'] != '') {
                $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
            }
            $condition .= " AND inc.inc_type IN ('DROP_BACK')"; 
            $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

            $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
                . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
            //echo $sql;die();
            $result = $this->db->query($sql);
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
      }
      function get_IFT_data_report($args){
        $condition = '';
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            }
            if ($args['sys_type'] != '') {
                $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
            }
            $condition .= " AND inc.inc_type IN ('IN_HO_P_TR')"; 
            $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

            $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
                . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
            //echo $sql;die();
            $result = $this->db->query($sql);
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
      }
      function get_Janani_data_report_pickup($args){
        $condition = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['sys_type'] != '') {
            $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
        }
        $condition .= " AND inc.inc_type IN ('PICK_UP')"; 
        $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

        $sql =  "SELECT epcr.provider_impressions,pro_imm.pro_name,count(epcr.inc_ref_id) as total_count"
            . " FROM $this->tbl_epcr as epcr "
            . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
            . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
            . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
            . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition GROUP BY epcr.provider_impressions";
        //echo $sql;die();
        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
  }
      function get_Janani_data_report_drop($args){
            $condition = '';
            if ($args['from_date'] != '' && $args['to_date'] != '') {
                $from = $args['from_date'];
                $to = $args['to_date'];
                $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            }
            if ($args['sys_type'] != '') {
                $condition .= " AND amb.amb_user_type  = '" . $args['sys_type'] . "'";
            }
            $condition .= " AND inc.inc_type IN ('DROP_BACK')"; 
            $condition .= " AND epcr.provider_impressions NOT IN ('21','41','42','44','52','53')";

            $sql =  "SELECT epcr.provider_impressions,pro_imm.pro_name,count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                . " LEFT JOIN ems_incidence as inc ON  epcr.inc_ref_id = inc.inc_ref_id"
                . " LEFT JOIN ems_ambulance as amb ON  epcr.amb_reg_id = amb.amb_rto_register_no"
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                . " where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition GROUP BY epcr.provider_impressions";
            //echo $sql;die();
            $result = $this->db->query($sql);
            if ($args['get_count']) {
                return $result->num_rows();
            } else {
                return $result->result();
            }
      }
      function get_b12_data_report($args,$pro=array()){
        $condition = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if(!empty($pro)){
            $provider = implode("','",$pro);
            $condition .= " AND pro_imm.b12_type IN ('$provider')";
        }
        if (isset($args['district']) && $args['district'] != '') {
            
            $condition .= " AND epcr.district_id = '" . $args['district'] . "'";
            
        }
        $sql =  "SELECT count(epcr.inc_ref_id) as total_count"
                . " FROM $this->tbl_epcr as epcr "
                . " LEFT JOIN ems_mas_provider_imp as pro_imm ON pro_imm.pro_id =  epcr.provider_impressions"
                ." where  epcr.epcris_deleted = '0'  AND is_validate ='1' $condition ";
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
            $condition .= "  AND epcr.validate_date  BETWEEN '$from' AND '$to'";
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

    function get_inc_ref_index($clg_id){
        
        if(empty($clg_id)){
            $clg_id = 0;
        }

        $this->db->insert($this->inc_ref_id_gen,array('user_id'=>$clg_id));
        $sql =  "SELECT MAX(id) as `inc_ref_index` FROM `$this->inc_ref_id_gen` WHERE `user_id` = '$clg_id'";
        $result = $this->db->query($sql);
        $res = $result->result();
        
        
        
        return $res[0]->inc_ref_index;
        
    }
    function reset_inc_ref_index(){
        $sql =  "TRUNCATE TABLE `$this->inc_ref_id_gen`";
        $result = $this->db->query($sql);
        $sql =  " ALTER TABLE `$this->inc_ref_id_gen` AUTO_INCREMENT = 1 ";
        $result = $this->db->query($sql);
        
        
    }
    function get_ptn_index($clg_id){
        
        if(empty($clg_id)){
            $clg_id = 0;
        }

        $this->db->insert($this->inc_ptn_gen,array('user_id'=>$clg_id));
        $sql =  "SELECT MAX(id) as `inc_ptn_index` FROM `$this->inc_ptn_gen` WHERE `user_id` = '$clg_id'";
        $result = $this->db->query($sql);
        $res = $result->result();
        
        
        
        return $res[0]->inc_ptn_index;
        
    }
    function reset_ptn_index(){
        $sql =  "TRUNCATE TABLE `$this->inc_ptn_gen`";
        $result = $this->db->query($sql);
    }

    function get_patient_count_epcr($inc_ref_id) {

        if ($inc_ref_id) {
            $condition = " AND epcr.inc_ref_id='" . $inc_ref_id . "' ";
        }


          $sql = "SELECT COUNT(epcr.inc_ref_id) as total_count
                 FROM ems_epcr as epcr  
                LEFT JOIN ems_incidence as inc ON ( inc.inc_ref_id = epcr.inc_ref_id )
                WHERE epcr.epcris_deleted= '0' $condition "; 
    

        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;

       if ($args['get_count']) {
        return $result->num_rows();
        } else {
        return $result->result();
        }
    }
    function get_response_time_als($args){
        $condition ='';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['amb_type']=='1'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' ";
        }elseif($args['amb_type']=='2'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' ";
        }elseif($args['amb_type']=='3'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' "; 
        }
        $sql = "SELECT epcr.inc_ref_id,driv_pcr.responce_time,amb.amb_working_area"
            . " FROM  $this->tbl_epcr  AS epcr" 
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " WHERE epcr.is_validate ='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0'  $condition  group by epcr.inc_ref_id";
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_response_time_bls($args){
        $condition ='';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['amb_type']=='1'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' ";
        }elseif($args['amb_type']=='2'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' ";
        }elseif($args['amb_type']=='3'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' "; 
        }
        $sql = "SELECT epcr.inc_ref_id,driv_pcr.responce_time,amb.amb_working_area"
            . " FROM  $this->tbl_epcr  AS epcr" 
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " WHERE epcr.is_validate ='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0'  $condition  group by epcr.inc_ref_id";
        $result = $this->db->query($sql);
         //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_response_time_je($args){
        $condition ='';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if($args['amb_type']=='1'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' ";
        }elseif($args['amb_type']=='2'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' ";
        }elseif($args['amb_type']=='3'){
            $condition .= "  AND amb.amb_type = '".$args['amb_type']."' "; 
        }
        $sql = "SELECT epcr.inc_ref_id,driv_pcr.responce_time,amb.amb_working_area"
            . " FROM  $this->tbl_epcr  AS epcr" 
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id)"
            . " WHERE epcr.is_validate ='1' AND epcris_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1'  AND inc.inc_duplicate = 'No' AND inc.incis_deleted = '0'  $condition  group by epcr.inc_ref_id";
        $result = $this->db->query($sql);
         //echo $this->db->last_query($result);die;
        if ($result) {
            return $result->result_array();
        } else {
            return false;
        }
    }


    function get_dm_dc_info($dis = array(),$dist=array()){

        $condition = "";
        if($dis != ''){

            if(is_array($dis)){
                $condition .= " AND ( ";
                foreach($dis as $key => $district_id){
                    
                    if($key == 0){
                        $condition .= "clg.clg_district_id LIKE '[" .'"'. $district_id .'"'. "]'";
                    }else{
                        $condition .= " OR clg.clg_district_id LIKE '[" .'"'. $district_id .'"'. "]'";
                    }
                }
                $condition .= ") ";
            }
        }
        else if($dist != ''){
        
            if(is_array($dist)){
                $condition .= " AND ( ";
                foreach($dist as $key => $district_id){
                    
                    if($key == 0){
                        $condition .= "clg.clg_district_id LIKE '[" .'"'. $district_id .'"'. "]'";
                    }else{
                        $condition .= "OR clg.clg_district_id LIKE '[" .'"'. $district_id .'"'. "]'";
                    }
                }
                $condition .= ") ";
            }
        }
        
        $sql = "SELECT clg.clg_ref_id,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_district_id"
            . " FROM  $this->tbl_colleague as clg " 
            . " LEFT JOIN ems_mas_districts as district ON clg.clg_district_id = district.dst_code " 
            . " WHERE clg.clg_is_deleted = '0' $condition AND clg.clg_group = 'UG-DM'  group by clg.clg_id ";
            
        $result = $this->db->query($sql);
        //  echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
            } else {
            return $result->result();
            }
    }

    function get_amb_count($args=array()){
        
        
        $sql = "SELECT dst.dst_name,divi.div_name, count(amb.amb_rto_register_no) as amb_count"
            . " FROM  $this->tbl_mas_districts AS dst "
            . " LEFT JOIN $this->tbl_division as divi ON ( divi.div_id = dst.div_id )"
            . " LEFT JOIN ems_ambulance AS amb ON ( amb.amb_district = dst.div_id)" 
            . " WHERE dst.dst_id = '".$args['dist']."'";
        $result = $this->db->query($sql);
        //  echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
            } else {
            return $result->result();
            }
    }


    function get_dm_dc_login_report($args){
        $condition ='';
        if ($args['from_date'] != '') {
            $from = $args['from_date'];
            $condition .= "  AND clg_login_time LIKE '$from%'";
        }
        // if ($args['from_date'] != '' && $args['to_date'] != '') {
        //     $from = $args['from_date'];
        //     $to = $args['to_date'];
        //     $condition .= "  AND epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        // }
        
        
        $sql = "SELECT clg_login_time,clg_logout_time "
            . " FROM  ems_clg_logins" 
            . " WHERE clg_ref_id='".$args['clg_ref_id']."'  $condition order by id desc";
        $result = $this->db->query($sql);
        //  echo $this->db->last_query($result);die;
         if ($args['get_count']) {
            return $result->num_rows();
            } else {
            return $result->result();
            }   
    }
    function get_incident_for_audio_files(){
          
        
     
        $current_date =date('Y-m-d H:i:s');
        $newdate =  date("Y-m-d H:i:s", (strtotime ('-5 minute' , strtotime ($current_date)))) ;
        $newdate = "2022-09-15 00:00:00";
        $condition .= "AND inc.inc_datetime BETWEEN '$newdate' AND '$current_date'";
       


         $sql = "SELECT *"
            . " FROM ems_incidence as inc"   
            . " WHERE inc.inc_audio_file ='' AND inc.inc_avaya_uniqueid !='direct_atnd_call' $condition ORDER BY inc.inc_datetime ASC"; 
//   echo $sql;
//    die();
        
        $result = $this->db->query($sql);

        if ($result) {
            $result = $result->result();
            return $result;
        } else {
            return false;
        }
    
    }
    function get_inspection_details($args =array()){
        $condition = '';
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND  ins.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $this->db->query('SET group_concat_max_len = 18446744073709551615');  
        $sql = "SELECT ins.ins_amb_type,ins.id,ins.added_date,ins.ins_amb_no,ins.ins_baselocation,ins.added_by,ins.added_date as Audit_Date,dist.dst_name as District_Name,ins.ins_odometer as Current_ODO,
        amb.amb_default_mobile as CUG_Number,amb.amb_mdt_srn_no as MDT_ID,amb.amb_mdt_simcnt_no as MDT_Number,amb.chases_no as Chassis_No,ins.ins_gps_status as GPS_Device ,ins.remark as Overall_Observation_related_Primary_Issue, ins.ins_main_due_status as Maintainance_of_Vehicle, ins.ins_main_status as Vehicle_Present_Status, ins.ins_main_remark as Maintainance_of_Vehicle_Remark, ins.ins_clean_status as Cleanliness_of_Ambulance_Present_Status,ins.ins_clean_remark as Cleanliness_of_Ambulance_Remark, ins.ac_status as Ambulance_AC_Status, ins.ac_remark as Ambulance_AC_Remark, ins.siren_status as Ambulance_Siren_Status, ins.siren_remark as Ambulance_Siren_Remark, ins.inv_status as Ambulance_Inverter_Status, ins.inv_remark as Ambulance_Inverter_Remark, ins.batt_status as Ambulance_Battery_Status, ins.batt_remark as Ambulance_Battery_Remark,ins.tyre_status as Ambulance_Tyre_Status, ins.tyre_remark as Ambulance_Tyre_Remark, ins.ins_pcs_stock_status as PCR_Register_Present_Status, ins.ins_pcs_stock_remark as PCR_Register_Present_Remark, ins.ins_sign_attnd_due_status as Attendance_Sheet_Maintained, ins.ins_sign_attnd_status as Attendance_Sheet_Present_Status, ins.ins_sign_attnd_remark as Attendance_Sheet_Remark,ins.gps_status as GPS_Status,ins.gps_remark as GPS_Remark, ins.forword_grievance as Forward_to_Grievance, ins.gri_status as Grievance_Status ,GROUP_CONCAT(CONCAT('{',CONCAT_WS(',',CONCAT('\"equipmentName\"',':\"',inv_eqp.eqp_name,'\"'),CONCAT('\"status\"',':\"',equipment.status,'\"'),CONCAT('\"eqp_id\"',':\"',equipment.eqp_id,'\"')),'}')) as equpiment
        FROM `ems_inspection_audit_details` as ins
        LEFT JOIN ems_colleague as clg ON ins.ins_dist = clg.clg_district_id
        LEFT JOIN ems_mas_districts as dist ON ins.ins_dist = dist.dst_code
        LEFT JOIN ems_ambulance as amb ON ins.ins_amb_no = amb.amb_rto_register_no 
        LEFT JOIN ems_inspection_audit_equp_details AS equipment ON (equipment.ins_id = ins.id)
        LEFT JOIN ems_inventory_equipment AS inv_eqp ON (inv_eqp.eqp_id = equipment.eqp_id)
        Where 1=1 AND ins_app_status='2' $condition GROUP BY ins.id  ";
        
        $sql = "SELECT ins.ins_amb_type,ins.id,ins.ins_dist,ins.ins_odometer,ins.added_date,ins.ins_amb_no,ins.ins_emso,ins.ins_pilot,ins.ins_baselocation,ins.added_by,clg_name.clg_first_name as first_name,clg_name.clg_last_name as last_name,ins.added_date as Audit_Date,dist.dst_name as District_Name,ins.ins_odometer as Current_ODO,
        amb.amb_default_mobile as CUG_Number,amb.amb_mdt_srn_no as MDT_ID,amb.amb_mdt_simcnt_no as MDT_Number,amb.chases_no as Chassis_No,ins.ins_gps_status as GPS_Device ,ins.remark as Overall_Observation_related_Primary_Issue, ins.ins_main_due_status as Maintainance_of_Vehicle, ins.ins_main_status as Vehicle_Present_Status, ins.ins_main_remark as Maintainance_of_Vehicle_Remark, ins.ins_clean_status as Cleanliness_of_Ambulance_Present_Status,ins.ins_clean_remark as Cleanliness_of_Ambulance_Remark, ins.ac_status as Ambulance_AC_Status, ins.ac_remark as Ambulance_AC_Remark, ins.siren_status as Ambulance_Siren_Status, ins.siren_remark as Ambulance_Siren_Remark, ins.inv_status as Ambulance_Inverter_Status, ins.inv_remark as Ambulance_Inverter_Remark, ins.batt_status as Ambulance_Battery_Status, ins.batt_remark as Ambulance_Battery_Remark,ins.tyre_status as Ambulance_Tyre_Status, ins.tyre_remark as Ambulance_Tyre_Remark, ins.ins_pcs_stock_status as PCR_Register_Present_Status, ins.ins_pcs_stock_remark as PCR_Register_Present_Remark, ins.ins_sign_attnd_due_status as Attendance_Sheet_Maintained, ins.ins_sign_attnd_status as Attendance_Sheet_Present_Status, ins.ins_sign_attnd_remark as Attendance_Sheet_Remark,ins.gps_status as GPS_Status,ins.gps_remark as GPS_Remark, ins.forword_grievance as Forward_to_Grievance, ins.gri_status as Grievance_Status, ins.ins_amb_current_status as Ambulance_Status, ins.added_by_source as added_from
        FROM `ems_inspection_audit_details` as ins
        LEFT JOIN ems_colleague as clg ON ins.ins_dist = clg.clg_district_id
        LEFT JOIN ems_colleague as clg_name ON ins.added_by = clg_name.clg_ref_id
        LEFT JOIN ems_mas_districts as dist ON ins.ins_dist = dist.dst_code
        LEFT JOIN ems_ambulance as amb ON ins.ins_amb_no = amb.amb_rto_register_no 
        Where 1=1 AND ins_app_status='2' $condition GROUP BY ins.id  ";

        $result = $this->db->query($sql);
        //echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function get_inspection_equipment($args =array()){
 
        
        $condition = '';
        if ($args['ins_id'] != '' ) {
            $ins_id = $args['ins_id'];
            $condition .= " AND equipment.ins_id = '$ins_id'";
        }
        if ($args['eqp_id'] != '' ) {
            $eqp_id = $args['eqp_id'];
            $condition .= " AND equipment.eqp_id = '$eqp_id'";
        }
        $this->db->query('SET group_concat_max_len = 18446744073709551615');  
        $sql = "SELECT equipment.eqp_id,equipment.status
        FROM ems_inspection_audit_equp_details AS equipment
        LEFT JOIN ems_inventory_equipment AS inv_eqp ON (inv_eqp.eqp_id = equipment.eqp_id)
        Where 1=1 $condition";
        // echo $sql; die();

        $result = $this->db->query($sql);
     
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inspection_medicine($args =array()){
        $condition = '';
        if ($args['ins_id'] != '' ) {
            $ins_id = $args['ins_id'];
            $condition .= " AND medicine.ins_id = '$ins_id'";
        }
        if ($args['med_id'] != '' ) {
            $med_id = $args['med_id'];
            $condition .= " AND medicine.med_id = '$med_id'";
        }
        $this->db->query('SET group_concat_max_len = 18446744073709551615');  
        $sql = "SELECT medicine.med_id,medicine.med_status
        FROM ems_inspection_audit_med_details AS medicine
        LEFT JOIN ems_inspection_medicine AS inv_med ON (inv_med.med_id = medicine.med_id)
        Where 1=1 $condition";
        //echo $sql; die();

        $result = $this->db->query($sql);
     
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_gps_odometer_report_nhm($args =array()){
        $condition = '';
      
       if ($args['from_date'] != '' && $args['to_date'] != '') {
           $from = $args['from_date'];
           $to = $args['to_date'];
           $condition .= " AND  epcr.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
       }
            $sql = "SELECT epcr.*,zon.div_name,dis.dst_name,base.hp_name  FROM ems_epcr as epcr
            LEFT JOIN ems_ambulance as amb ON epcr.amb_reg_id = amb.amb_rto_register_no 
           LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id 
           LEFT JOIN ems_mas_districts as dis ON dis.dst_id = amb.amb_district
           LEFT JOIN ems_mas_division as zon ON zon.div_id = dis.div_id"
           . " WHERE  (epcr.epcris_deleted = '0' OR epcr.epcris_deleted IS null) AND epcr.is_validate = '1' $condition ";

       $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }
    }
    function get_gps_odometer_report($args =array()){
        $condition = '';
      
       if ($args['from_date'] != '' && $args['to_date'] != '') {
           $from = $args['from_date'];
           $to = $args['to_date'];
           $condition .= " AND  epcr.validate_date BETWEEN '$from' AND '$to 23:59:59'";
       }
            $sql = "SELECT epcr.*,zon.div_name,dis.dst_name,base.hp_name  FROM ems_epcr as epcr
            LEFT JOIN ems_ambulance as amb ON epcr.amb_reg_id = amb.amb_rto_register_no 
           LEFT JOIN ems_base_location as base ON amb.amb_base_location = base.hp_id 
           LEFT JOIN ems_mas_districts as dis ON dis.dst_id = amb.amb_district
           LEFT JOIN ems_mas_division as zon ON zon.div_id = dis.div_id"
           . " WHERE  (epcr.epcris_deleted = '0' OR epcr.epcris_deleted IS null) AND epcr.is_validate = '1' $condition ";

       $result = $this->db->query($sql);
    //    echo $this->db->last_query();die;
       if ($args['get_count']) {
           return $result->num_rows();
       } else {
           return $result->result();
       }
   }
   function get_cmho_data($args =array()){
         $condition ='';
         
        if ($args['cm_zone_id'] != '') {
            $cm_zone_id = $args['cm_zone_id'];
            $condition .= "  AND cm_zone_id = '$cm_zone_id'";
        }
         $sql = "SELECT * "
            . " FROM  ems_cmho_details" 
            . " WHERE 1=1  $condition order by cm_id desc";
      
        $result = $this->db->query($sql);
         if ($args['get_count']) {
            return $result->num_rows();
            } else {
            return $result->result();
            }   
   }
   
   function get_private_hospital_inc($args = array()) {

       $condition ='';
         
        if ($args['pr_inc_ref_id'] != '') {
            $pr_inc_ref_id = $args['pr_inc_ref_id'];
            $condition .= "  AND pr_inc_ref_id = '$pr_inc_ref_id'";
        }
         $sql = "SELECT * "
            . " FROM  ems_private_hospital" 
            . " WHERE 1=1  $condition order by pr_id desc";
      
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
             
            return $result->num_rows();
           
        } else {
            return $result->result();
        }   
    }
    function update_private_hospital($args) {

        if($args['pr_inc_ref_id'] != ''){
            $this->db->where('pr_inc_ref_id', $args['pr_inc_ref_id']);
        }
        unset($args['pr_inc_ref_id']);
        
        if($args['orderId'] != ''){
            $this->db->where('pr_orderId', $args['orderId']);
        }
        unset($args['orderId']);
        
        $data = $this->db->update("ems_private_hospital", $args);
          
        return $data;
        
    }
    
}
