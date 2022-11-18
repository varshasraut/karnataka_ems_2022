<?php


class Reports_model extends CI_Model
{



    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;



    function __construct()
    {

        parent::__construct();



        $this->load->helper('date');

        $this->load->database();



        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_groups');
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
        $this->tbl_driver_pcr = $this->db->dbprefix('driver_pcr');
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
        $this->tbl_mas_responce_remark = $this->db->dbprefix('mas_responce_remark');
        $this->tbl_clg = $this->db->dbprefix('colleague');
        $this->tbl_back_drop_call = $this->db->dbprefix('back_drop_call');
        $this->tbl_ambulance = $this->db->dbprefix('ambulance');
        $this->tbl_onroad_offroad = $this->db->dbprefix('amb_onroad_offroad');
        $this->tbl_mas_call_purpose = $this->db->dbprefix('mas_call_purpose');

        $this->mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_inc_add_advice = $this->db->dbprefix('inc_add_advice');
        $this->tbl_inc_enable_dispatch = $this->db->dbprefix('incident_amb_enable_dispatch');
        $this->tbl_mas_nhm_report = $this->db->dbprefix('mas_nhm_report');
    }
    function get_response_time($args = array())
    {
        //var_dump($args);
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to'";
            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }
        if ($args['system']) {
            $condition .= " AND inc.inc_system_type='" . $args['system'] . "' ";
        }

        $sql = "SELECT inc.inc_ref_id,inc.inc_type,inc.inc_datetime,inc.inc_address,inc.inc_district_id,inc.inc_area,inc.inc_landmark, inc_ptn.ptn_id,ptn.ptn_fname,inc.inc_complaint,inc.inc_mci_nature,ptn.ptn_lname, ptn.ptn_fullname, ptn.ptn_age,clr.clr_fname,clr.clr_lname,clr.clr_fullname, clr.clr_mobile,epcr.date,epcr.time,inc_amb.amb_rto_register_no,epcr.rec_hospital_name,epcr.hospital_district,inc.inc_recive_time,dr_pcr.dp_on_scene,dr_pcr.dp_reach_on_scene,dr_pcr.dp_hosp_time,dr_pcr.dp_hand_time,dr_pcr.dp_back_to_loc,dr_pcr.responce_time,epcr.inc_area_type,epcr.total_km,dr_pcr.responce_time_remark,epcr.end_odometer_remark,dr_pcr.dp_started_base_loc,dr_pcr.start_from_base"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"
            . " LEFT JOIN $this->tbl_cls AS cls ON ( cls.cl_id = inc.inc_cl_id )"
            . " LEFT JOIN $this->tbl_clrs AS clr ON ( cls.cl_clr_id = clr.clr_id )"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"
            . " LEFT JOIN $this->tbl_epcr AS epcr ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN $this->tbl_driver_pcr AS dr_pcr ON ( epcr.id = dr_pcr.dp_pcr_id)"
            . " WHERE inc.inc_set_amb='1' AND inc.inc_pcr_status='1' AND inc.incis_deleted='0' AND epcr.epcris_deleted='0' $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
        // echo $sql;
        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_report($args = array())
    {

        if ($args['type'] != '') {
            $condition .= " AND inc.type = '" . $args['type'] . "'";
        }
        if ($args['report_code'] != '') {
            $condition .= " AND inc.report_code = '" . $args['report_code'] . "'";
        }
        $sql = "SELECT *"
            . " FROM $this->tbl_mas_nhm_report AS inc where 1=1 $condition";

        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_b_ii_a($args = array(), $offset = '', $limit = '')
    {

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_ii_a.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT *"
            . " FROM ems_Annaxture_BIIA AS b_ii_a where 1=1 $condition $offlim";
        //         echo $sql;
        //         die();

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_nhm_b_vii($args = array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_vii.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $sql = "SELECT *"
            . " FROM ems_annexture_b_vii AS b_vii where 1=1 $condition";


        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_b_vi($args = array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_vi.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $sql = "SELECT *"
            . " FROM ems_annexture_b_vi AS b_vi where 1=1 $condition";


        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_b_v($args = array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_v.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $sql = "SELECT *"
            . " FROM ems_annexture_b_v AS b_v where 1=1 $condition";

        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_a_ii($args = array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND a_ii.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $sql = "SELECT *"
            . " FROM ems_annexure_aii AS a_ii where 1=1 $condition";

        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_a_i($args = array())
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND a_i.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        $sql = "SELECT *"
            . " FROM ems_annexture_AI AS a_i where 1=1 $condition";

        $result = $this->db->query($sql);
        if ($result) {

            return $result->result_array();
        } else {
            return false;
        }
    }
    function get_nhm_b_i($args = array(), $offset = '', $limit = '')
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_i.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT *"
            . " FROM ems_Annexure_BI AS b_i where 1=1 $condition $offlim";
        //die();

        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_nhm_b_iii($args = array(), $offset = '', $limit = '')
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_iii.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT *"
            . " FROM ems_Annexure_BIII AS b_iii where 1=1 $condition $offlim";


        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_nhm_b_ii_b($args = array(), $offset = '', $limit = '')
    {
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND b_ii_b.report_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }

        $sql = "SELECT *"
            . " FROM ems_Annexure_BIIB AS b_ii_b where 1=1 $condition $offlim";


        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
        //        if ($result) {
        //
        //            return $result->result_array();
        //        } else {
        //            return false;
        //        }

    }
    function get_base_loc_data($args = array())
    {
        $condition = '';

        if ($args['district_id'] != '') {

            $condition .= " AND hp.hp_district IN ('" . $args['district_id'] . "')  ";
        }

        if ($args['system'] != '') {

            $condition .= " AND hp.hp_system  IN ('" . $args['system'] . "')  ";
        }


        $sql = "SELECT hp.hp_name,hp.hp_mobile,hp.hp_system,hp.geo_fence,hp.hp_register_no,hp.hp_address,hp.hp_area,hp.hp_lmark,hp.hp_lane_street,hp.hp_pincode,hp.hp_lat,hp.hp_long,hp.hp_contact_person,hp.hp_contact_mobile,hp.hp_email,hp.hp_adm,area.ar_name, hosp.full_name,state.st_name,dist.dst_name,tehshil.thl_name,city.cty_name,hp.base_added_by,hp.base_added_date FROM ems_base_location as hp 
    LEFT JOIN ems_mas_area_types as area on (area.ar_id = hp.hp_area_type)
    LEFT JOIN ems_mas_hospital_type as hosp ON (hosp.hosp_id = hp.hp_type) 
    LEFT JOIN ems_mas_states as state ON (state.st_code = hp.hp_state)
    LEFT JOIN ems_mas_districts as dist ON (dist.dst_code = hp.hp_district)
    LEFT JOIN ems_mas_tahshil as tehshil ON (tehshil.thl_code = hp.hp_tahsil)
    LEFT JOIN ems_mas_city AS city ON (city.cty_id = hp.hp_city) WHERE hp.hpis_deleted = '0' $condition";
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;

        return $result->result();
    }

    function get_dipatch_count($args){
        $condition="";

    //     if ($args['system'] != '') {

    //         $condition .= " AND amb.amb_user  IN ('" . $args['system'] . "')  ";
    //    }
       if ($args['district_id'] != '') {

        $condition .= " AND inc.inc_district_id IN ('" . $args['district_id'] . "')  ";
        }

        $data=$this->db->query("SELECT inc.inc_ref_id  FROM `ems_incidence` as inc 
    WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1'  $condition ");
//    echo $this->db->last_query();die();
    if($data->num_rows()){
        return $data->num_rows();
    }else{
        return 0;
    }

    }
    function get_closure_data_count($args){
        $condition="";

            //     if ($args['system'] != '') {

            //         $condition .= " AND amb.amb_user  IN ('" . $args['system'] . "')  ";
            //    }
       if ($args['district_id'] != '') {

        $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')  ";
        }

        $data=$this->db->query("SELECT epcr.inc_ref_id  FROM `ems_epcr` as epcr 
        WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '0' $condition ");
        //    echo $this->db->last_query();die();
    if($data->num_rows()){
        return $data->num_rows();
    }else{
        return 0;
    }

    }
    function get_mdt_clo_count($args){
        $condition="";

            //     if ($args['system'] != '') {

            //         $condition .= " AND amb.amb_user  IN ('" . $args['system'] . "')  ";
            //    }
       if ($args['district_id'] != '') {

        $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')  ";
        }

        $data=$this->db->query("SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr 
        WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '0' AND epcr.operate_by NOT LIKE '%DCO%' $condition");
        //    echo $this->db->last_query();die();
    if($data->num_rows()){
        return $data->num_rows();
    }else{
        return 0;
    }

    }
    function get_dco_clo_count($args){
        $condition="";

            //     if ($args['system'] != '') {

            //         $condition .= " AND amb.amb_user  IN ('" . $args['system'] . "')  ";
            //    }
       if ($args['district_id'] != '') {

        $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')  ";
        }

        $data=$this->db->query("SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr 
        WHERE epcr.epcris_deleted = '0' AND epcr.operate_by LIKE '%DCO%' $condition ");
        //    echo $this->db->last_query();die();
    if($data->num_rows()){
        return $data->num_rows();
    }else{
        return 0;
    }

    }
    function get_val_clo_count($args){
        $condition="";

            //     if ($args['system'] != '') {

            //         $condition .= " AND amb.amb_user  IN ('" . $args['system'] . "')  ";
            //    }
       if ($args['district_id'] != '') {

        $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')  ";
        }

        $data=$this->db->query("SELECT epcr.inc_ref_id FROM `ems_epcr` as epcr 
        WHERE epcr.epcris_deleted = '0' AND epcr.is_validate = '1' $condition ");
        //    echo $this->db->last_query();die();
    if($data->num_rows()){
        return $data->num_rows();
    }else{
        return 0;
    }

    }
    function get_tdd_amb($args = array()) {
        // var_dump($args);die;
       if ($args['system'] != '' && $args['system'] != 'all') {
           $condition .= " AND amb.amb_user = '" . $args['system'] . "'";
       }

       $sql = "SELECT amb.*,hp.hp_name,vendor.vendor_name,amb_type.ambt_name, area.ar_name FROM $this->tbl_amb as amb 
       LEFT JOIN $this->tbl_hp as hp ON amb.amb_base_location = hp.hp_id 
       LEFT JOIN ems_ambulance_vendor as vendor ON amb.amb_vendor = vendor.vendor_id
       LEFT JOIN ems_mas_ambulance_type as amb_type ON amb.amb_type = amb_type.ambt_id 
       LEFT JOIN ems_mas_area_types as area ON amb.amb_working_area = area.ar_id
       where amb.ambis_deleted='0' $condition GROUP BY amb.amb_rto_register_no ";
    //    echo $sql;
    //    die();
       $result = $this->db->query($sql);

       return $result->result();
   }
}
