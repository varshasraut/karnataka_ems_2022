<?php
class Send_daily_incident_data_model extends CI_Model {

    function __construct() {

            parent::__construct();

        $this->tbl_incidence = $this->db->dbprefix('incidence');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');
        $this->tbl_mas_patient_complaint_types = $this->db->dbprefix('mas_patient_complaint_types');
        $this->tbl_mas_micnature = $this->db->dbprefix('mas_micnature');
        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');
        $this->tbl_ems_summary = $this->db->dbprefix('summary');
        $this->tbl_amb_status = $this->db->dbprefix('amb_status_availablity');
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
        $this->tbl_mas_hospital_type = $this->db->dbprefix('mas_hospital_type');
    }
    
    function get_inc_details($args=array()){
        
        $yes_date = $args['date'];
        if($args['date'] != ""){
            $from = $args['date'];

            $to = $args['date'];

            $condition .= " AND epcr.inc_datetime BETWEEN '$from 00:00:01' AND '$to 23:59:59'";
        }
        $sql = "SELECT epcr.id,epcr.inc_datetime,epcr.inc_ref_id,epcr.ptn_id,epcr.district_id,epcr.amb_reg_id,epcr.start_odometer,epcr.end_odometer,epcr.provider_impressions,epcr.rec_hospital_name,inc.inc_address,amb.amb_base_location,ptn.ptn_fname,ptn.ptn_lname,ptn.ptn_age,clr.clr_mobile,clr.clr_fname,clr.clr_lname,dis.dst_name,inc.inc_complaint,driv_pcr.inc_dispatch_time,driv_pcr.inc_dispatch_time,driv_pcr.start_from_base,driv_pcr.start_odometer,driv_pcr.end_odometer,driv_pcr.dp_on_scene,driv_pcr.dp_reach_on_scene,driv_pcr.dp_cl_from_desk,driv_pcr.dp_hand_time,driv_pcr.dp_hosp_time,driv_pcr.dp_back_to_loc"
              
            . " FROM $this->tbl_epcr AS epcr"
            
            . " LEFT JOIN $this->tbl_incidence as inc ON ( epcr.inc_ref_id = inc.inc_ref_id )"
            
            . " LEFT JOIN  $this->tbl_cls  AS cls ON ( cls.cl_id = inc.inc_cl_id  )"
            
            . " LEFT JOIN  $this->tbl_clrs  AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            
            . " LEFT JOIN  $this->tbl_mas_districts  AS dis ON ( epcr.district_id = dis.dst_code  )"
              
            . " LEFT JOIN $this->tbl_patient AS ptn ON ( epcr.ptn_id = ptn.ptn_id )"
            
            . " LEFT JOIN $this->tbl_ambulance as amb ON (amb.amb_rto_register_no = epcr.amb_reg_id )"
            
            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"
            
            . " WHERE epcris_deleted = '0' $condition ";
            
            $result = $this->db->query($sql);

           // echo $this->db->last_query();die;
        /*
        $sql = "SELECT inc.*,clr.clr_fullname,clr.clr_fname,clr.clr_lname, clr.clr_mobile,cl.cl_purpose,amb.amb_rto_register_no,ptn.ptn_id, ptn.ptn_gender, ptn.ptn_age,ptn.ptn_fname,ptn.ptn_lname,in_fa.rpt_doc,in_fa.new_rpt_doc,in_fa.mo_no,in_fa.new_mo_no,in_fa.new_district,in_fa.current_district,amb.amb_type,amb.amb_base_location,amb.amb_working_area,epcr.provider_impressions,driv_pcr.inc_dispatch_time,driv_pcr.inc_dispatch_time,driv_pcr.start_from_base,driv_pcr.start_odometer,driv_pcr.end_odometer,driv_pcr.dp_on_scene,driv_pcr.dp_reach_on_scene,driv_pcr.dp_cl_from_desk,driv_pcr.dp_hand_time,driv_pcr.dp_hosp_time,driv_pcr.dp_back_to_loc,epcr.rec_hospital_name,epcr.start_odometer,epcr.end_odometer,inc_amb.amb_pilot_id,inc_amb.amb_emt_id,epcr.date,epcr.operate_by,inc.inc_dispatch_time as call_duration"

            . " FROM $this->tbl_incidence AS inc"

            . " LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )"

            . " LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )"

            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON (inc.inc_ref_id = inc_amb.inc_ref_id )"

            . " LEFT JOIN $this->tbl_colleague AS clg ON (inc.inc_added_by = clg.clg_ref_id )"

            . " LEFT JOIN $this->tbl_ambulance as amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"

            . " LEFT JOIN $this->tbl_incidence_patient AS inc_ptn ON ( inc_ptn.inc_id = inc.inc_ref_id )"

            . " LEFT JOIN $this->tbl_patient AS ptn ON ( inc_ptn.ptn_id = ptn.ptn_id )"

            . " LEFT JOIN $this->tbl_inter_facility AS in_fa ON ( in_fa.inc_ref_id = inc.inc_ref_id )"

            . " LEFT JOIN  $this->tbl_epcr  AS epcr ON ( inc.inc_ref_id = epcr.inc_ref_id  )"

            . " LEFT JOIN $this->tbl_driver_pcr AS driv_pcr ON ( driv_pcr.dp_pcr_id = epcr.id)"

            . " WHERE inc.incis_deleted = '0' $condition GROUP BY inc.inc_ref_id ORDER BY inc.inc_datetime DESC";
            */
            
    
            if ($args['get_count']) {
    
                return $result->num_rows();
    
            } else {
    
                return $result->result();
    
            }
        
        
    }
    function get_chief_comp_service($cm_id) {

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
    function get_provider_imp_by_id($pro_id) {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_provider_imp");

        if ($pro_id != "") {

            $this->db->like("$this->tbl_mas_provider_imp.pro_id", $pro_id);
        }


        $this->db->where("$this->tbl_mas_provider_imp.pro_status", '1');
        $this->db->where("$this->tbl_mas_provider_imp.prois_deleted", '0');
        $this->db->order_by("pro_name","asc");
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
}
?>