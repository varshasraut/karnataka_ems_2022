<?php

class Clinical_model extends CI_Model
{
    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct()
    {

        parent::__construct();

        $this->load->helper('date');

        $this->load->database();

        $this->tbl_mas_store_groups = $this->db->dbprefix('mas_groups');

        $this->tbl_mas_amb_type = $this->db->dbprefix('mas_ambulance_type');

        $this->tbl_mas_amb_status = $this->db->dbprefix('mas_ambulance_status');

        $this->tbl_amb = $this->db->dbprefix('ambulance');

        $this->tbl_mas_districts = $this->db->dbprefix('mas_districts');

        $this->tbl_mas_tahshil = $this->db->dbprefix('mas_tahshil');

        $this->tbl_mas_city = $this->db->dbprefix('mas_city');

        $this->tbl_mas_area_types = $this->db->dbprefix('mas_area_types');

        $this->tbl_hp = $this->db->dbprefix('hospital');

        $this->tbl_ambulance_base = $this->db->dbprefix('ambulance_base');

        $this->tbl_hp1 = $this->db->dbprefix('hospital1');

        $this->tbl_default_team = $this->db->dbprefix('amb_default_team');

        $this->tbl_pcr = $this->db->dbprefix('pcr');

        $this->tbl_epcr = $this->db->dbprefix('epcr');
        $this->tbl_consents = $this->db->dbprefix('consents');

        $this->tbl_incidence = $this->db->dbprefix('incidence');

        $this->tbl_mas_injury = $this->db->dbprefix('mas_injury');

        $this->tbl_mas_front = $this->db->dbprefix('mas_front');

        $this->tbl_mas_back = $this->db->dbprefix('mas_back');

        $this->tbl_mas_side = $this->db->dbprefix('mas_side');

        $this->tbl_trauma = $this->db->dbprefix('trauma');

        $this->tbl_hospital_transfer = $this->db->dbprefix('hospital_transfer');

        $this->tbl_ptn_addasst = $this->db->dbprefix('ptn_add_assessment');

        $this->tbl_ptn_asst = $this->db->dbprefix('ptn_assessment');

        $this->tbl_mas_hospital_type = $this->db->dbprefix('mas_hospital_type');

        $this->tbl_mas_provider_imp = $this->db->dbprefix('mas_provider_imp');
        $this->tbl_mas_provider_casetype = $this->db->dbprefix('mas_provider_casetype');

        $this->tbl_assessment = $this->db->dbprefix('assessment');
        $this->tbl_cardic = $this->db->dbprefix('cardic');
        $this->tbl_apgar = $this->db->dbprefix('apgar');
        $this->tbl_birth_details = $this->db->dbprefix('birth_details');
        $this->tbl_mas_consents = $this->db->dbprefix('mas_consents');
        $this->tbl_driver_pcr = $this->db->dbprefix('driver_pcr');

        $this->tbl_pcr_med_inv = $this->db->dbprefix('pcr_med_inv');

        $this->tbl_loc_level = $this->db->dbprefix('mas_loc_level');
        $this->tbl_incidence_ambulance = $this->db->dbprefix('incidence_ambulance');

        $this->tbl_colleague = $this->db->dbprefix('colleague');
        $this->tbl_dist = $this->db->dbprefix('mas_districts');
        $this->tbl_odometer_remark = $this->db->dbprefix('mas_odometer_remark');
        $this->tbl_mas_responce_remark = $this->db->dbprefix('mas_responce_remark');
        $this->tbl_amb_status_availablity = $this->db->dbprefix('amb_status_availablity');
        $this->tbl_eqp_standard_remark = $this->db->dbprefix('mas_eqp_standard_remark');
        $this->tbl_past_medical_history = $this->db->dbprefix('past_medical_history');
        $this->tbl_app_patient_handover_issues = $this->db->dbprefix('app_patient_handover_issues');
        $this->sms_recipients = $this->db->dbprefix('sms_recipients');
    }

    /*  public function get_list_data_old($filter = '', $sortby = array())
    {
        $condition = $offlim = '';
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime ASC";
        }

        $sql = "SELECT inc.inc_ref_id,inc.inc_datetime,inc_amb.amb_rto_register_no,hp.hp_name,epcr.date,dist.dst_name,clg.clg_mobile_no,clg.clg_first_name,clg.clg_last_name,amb.amb_default_mobile,amb.amb_pilot_mobile,inc.inc_type,epcr.remark $epr_select
        FROM $this->tbl_incidence AS inc
        LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
        LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )

        LEFT JOIN $this->tbl_hp AS hp ON (inc_amb.base_location_id = hp.hp_id)
        LEFT JOIN $this->tbl_epcr AS epcr ON ( inc.inc_ref_id = epcr.inc_ref_id)
        LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
        LEFT JOIN  $this->tbl_colleague AS clg ON ( clg.clg_ref_id = inc_amb.amb_emt_id )


         Where inc.incis_deleted = '0' AND inc.inc_set_amb = '1'AND inc.inc_pcr_status = '1' AND inc.inc_type IN ('MCI','on_scene_care','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','DROP_BACK')  AND inc.inc_set_amb = '1' AND inc_amb.amb_status = 'assign' AND epcr.operate_by NOT LIKE '%DCO%'  $condition GROUP BY inc.inc_ref_id $order_by";

        //  Where inc.incis_deleted = '0' AND inc.inc_datetime > DATE_SUB(NOW(), INTERVAL 12 HOUR) AND inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.inc_type IN ('MCI','on_scene_care','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','DROP_BACK') AND inc_amb.amb_status = 'assign' AND epcr.operate_by  NOT LIKE '%DCO%'  $condition GROUP BY inc.inc_ref_id $order_by";


        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die();
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    } */


    function get_list_data($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array(), $incomplete_inc_amb = array())
    {


        $condition = $offlim = '';
        // if ($args['operator_id']) {
        //     $condition .= " AND op.operator_id='" . $args['operator_id'] . "'";
        // }
        // if ($args['district_id']) {
        //     $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "'";
        // }

        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit 0,100 ";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime ASC";
        }

        $epcr = '';
        $epr_select = '';
        $sortby_sql ='';

        $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
        $epcr .=  ' LEFT JOIN  ems_colleague AS epcr_clg ON ( epcr.operate_by = epcr_clg.clg_ref_id )';
        $sortby_sql .= "AND epcr.epcris_deleted ='0' AND epcr.operate_by NOT LIKE '%DCO%' ";
        $epr_select = " , epcr.operate_by as epcr_operateby, epcr.epcr_call_type as epcr_call_type, epcr.remark as remark,epcr.date as date";
        $order_by = "ORDER BY inc.inc_datetime DESC";

        if ($sortby['amb_reg_id_new'] != "") {
            $amb_reg_id_new = trim($sortby['amb_reg_id_new']);
            $sortby_sql .= " AND inc_amb.amb_rto_register_no LIKE '%$amb_reg_id_new%'";
        }
        if ($sortby['provider_impressions'] != "") {
            $sortby_sql .= " AND epcr.provider_impressions = '" . trim($sortby['provider_impressions']) . "'";
        }
        if ($sortby['provider_casetype'] != "") {
            $sortby_sql .= " AND epcr.provider_casetype = '" . trim($sortby['provider_casetype']) . "'";
        }
        if ($sortby['epcr_call_types'] != "") {

            if ($sortby['epcr_call_types'] == '2') {
                $sortby_sql .= " AND inc.patient_ava_or_not = 'yes'";
            } elseif ($sortby['epcr_call_types'] == "1") {
                $sortby_sql .= " AND inc.patient_ava_or_not = 'no'";
            }
        }
        if ($sortby['amb_reg_id'] != "") {
            $amb = trim($sortby['amb_reg_id']);
            $sortby_sql .= " AND inc_amb.amb_rto_register_no LIKE '%$amb%'";
        }
        if ($sortby['district_id'] != "") {
            $sortby_sql .= " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
        }
        if ($sortby['hp_id'] != "") {
            $sortby_sql .= " AND amb.amb_base_location = '" . $sortby['hp_id'] . "'";
        }

        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql .= " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql .= " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }

        $sql = "SELECT inc.inc_ref_id,inc.inc_type,inc.inc_datetime,inc.patient_ava_or_not,inc_amb.amb_rto_register_no as amb_rto_register_no,hp.hp_name,clg.clg_mobile_no,clg.clg_first_name,clg.clg_last_name,dist.dst_name,amb.amb_default_mobile,amb.amb_pilot_mobile,amb.amb_pilot_mobile,cli.status,pur.pname $epr_select
                FROM $this->tbl_incidence AS inc  
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                $epcr  
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )
                LEFT JOIN $this->tbl_hp AS hp ON (hp.hp_id = amb.amb_base_location )
                LEFT JOIN  $this->tbl_colleague AS clg ON (  clg.clg_ref_id = inc_amb.amb_emt_id )
                LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )
                LEFT JOIN ems_clinical_gov AS cli ON ( cli.inc_ref_id = inc.inc_ref_id )
                LEFT JOIN ems_mas_call_purpose AS pur ON ( pur.pcode = inc.inc_type )
                Where inc.incis_deleted = '0' AND inc.inc_type !='on_scene_care' AND inc.inc_set_amb = '1' AND epcr.added_date > DATE_SUB(NOW(), INTERVAL 12 HOUR) AND inc.inc_pcr_status = '1' AND inc.inc_type IN ('MCI','on_scene_care','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','DROP_BACK','EMG_PVT_HOS','PICK_UP','PICKUP_CALL') AND inc_amb.amb_status = 'assign'  AND epcr.system_type='108' AND epcr.epcris_deleted='0' $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";;

                // Where inc.incis_deleted = '0' AND inc.inc_type !='on_scene_care' AND inc.inc_set_amb = '1'AND inc.inc_pcr_status = '1' AND inc.inc_type IN ('MCI','on_scene_care','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','DROP_BACK') AND inc_amb.amb_status = 'assign' AND epcr.system_type='108'  AND epcr.epcris_deleted='0' $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";;

        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die();

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    public function saverecords($data){
        $sql_query= $this->db->insert('ems_clinical_gov',$data);
        //    echo $this->db->last_query();
        // die();
        if($sql_query){
            $this->session->set_flashdata('success', "<div class='alert alert-success hide-it'> Saved Successfully </div>");
            redirect('clinical/clinical_list');
        }
        else{
            $this->session->set_flashdata('error', "<div class='alert alert-danger hide-it'> Somthing worng. Error!! </div>");
            redirect('clinical/clinical_list');
        }
      
    }

    public function get_clinical_data($id,$limit=1){
        $query = $this->db->get_where('ems_clinical_gov',$id,$limit);
        //    echo $this->db->last_query();
        // die();
        return $query->result();

    }
}
