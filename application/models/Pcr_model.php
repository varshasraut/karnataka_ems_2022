<?php

class Pcr_model extends CI_Model {

    public $tbl_mas_user_groups, $tbl_colleagues, $tbl_country, $tbl_state, $tbl_city;

    function __construct() {

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
    function get_all_closure_victim($args=array()){
        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND epcr.date BETWEEN '$from' AND '$to'";
        }
        if ($args['operator_id']) {
            $condition .= " AND epcr.operate_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT epcr.inc_ref_id"
            . " FROM $this->tbl_epcr AS epcr"
            . " WHERE 1=1 $condition ";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function get_all_closure($args=array()) {

        $condition = "";

        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= "AND epcr.date BETWEEN '$from' AND '$to'";
        }
        if ($args['operator_id']) {
            $condition .= " AND epcr.operate_by='" . $args['operator_id'] . "' ";
        }

        
        $sql = "SELECT epcr.inc_ref_id"
            . " FROM $this->tbl_epcr AS epcr"
            . " WHERE 1=1 $condition group by inc_ref_id";

        $result = $this->db->query($sql);

        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    function insert_pcr($args = array()) {
        //var_dump( $args['pcr_id']);
//        $result = $this->db->insert($this->tbl_pcr, $args);  
//           
//        if ($result) {
//            return $this->db->insert_id();
//        } else {
//            return false;
//        }

//        $this->db->select('*');
//        $this->db->from("$this->tbl_pcr");
//        //$this->db->where("$this->tbl_epcr.amb_reg_id" , $args['amb_reg_id']);
//        $this->db->where("$this->tbl_pcr.pcr_id", $args['pcr_id']);
//         $this->db->where("$this->tbl_pcr.pcr_isdeleted", '0');
//
//        $fetched = $this->db->get();
//        $present = $fetched->num_rows();
//
//
//        if ($present <= 0) {
            $unique_id = get_uniqid($this->session->userdata('user_default_key'));
            $args['id'] = $unique_id;
  
            $result = $this->db->insert($this->tbl_pcr, $args);
            

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
//        } else {
//
//            // $this->db->where("$this->tbl_epcr.amb_reg_id" , $args['amb_reg_id']);
//            // $this->db->where("$this->tbl_epcr.inc_ref_id" , $args['inc_ref_id']);
//            // $this->db->where("$this->tbl_epcr.ptn_id" , $args['ptn_id']);
//            $this->db->where("pcr_id", $args['pcr_id']);
//            $res = $this->db->update($this->tbl_pcr, $args);
//
//            // $updated_status = $this->db->affected_rows();
//            if ($res) {
//                return $present[0]->id;
//            } else {
//                return false;
//            }
//        }
    }
    function insert_kid_details($args = array()){
        
        $this->db->select('*');
        $this->db->from("ems_epcr_kidbirth");
        $this->db->where("ems_epcr_kidbirth.inc_ref_id", $args['inc_ref_id']);
        $this->db->where("ems_epcr_kidbirth.ptn_id", $args['ptn_id']);

        $fetched = $this->db->get();
        // echo $this->db->last_query();die;
        $present_kids = $fetched->num_rows();
        
        if($present_kids == '0'){
        
        $result = $this->db->insert('ems_epcr_kidbirth', $args);
        //echo $this->db->last_query();die;
        if ($result){
            return $this->db->insert_id();
        } else {
            return false;
        }}else{
            $this->db->where("ems_epcr_kidbirth.inc_ref_id", $args['inc_ref_id']);
            $this->db->where("ems_epcr_kidbirth.ptn_id", $args['ptn_id']);
            $res = $this->db->update('ems_epcr_kidbirth', $args);
            
         //echo $this->db->last_query();die;
            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
    }
    
    function get_kid_details($args = array()) {


        $this->db->select('*');
        $this->db->from("ems_epcr_kidbirth");
        $this->db->where("ems_epcr_kidbirth.inc_ref_id", $args['inc_ref_id']);
        $this->db->where("ems_epcr_kidbirth.ptn_id", $args['ptn_id']);
        $this->db->where("ems_epcr_kidbirth.status", '1');
        $data = $this->db->get();
        $result = $data->result();
       // echo $this->db->last_query();die;
        return $result;
    }
    function insert_epcr($args = array()) {

//        $result = $this->db->insert($this->tbl_epcr, $args);  
//           
//        if ($result) {
//            return $this->db->insert_id();
//        } else {
//            return false;
//        }


        $this->db->select('*');
        $this->db->from("$this->tbl_epcr");
        //$this->db->where("$this->tbl_epcr.amb_reg_id" , $args['amb_reg_id']);
        $this->db->where("$this->tbl_epcr.inc_ref_id", $args['inc_ref_id']);
        $this->db->where("$this->tbl_epcr.ptn_id", $args['ptn_id']);
        $this->db->where("$this->tbl_epcr.epcris_deleted", '0');
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {


            $unique_id = get_uniqid($this->session->userdata('user_default_key'));
            $args['id'] = $unique_id;
           // $args['added_date'] = date('Y-m-d H:i:s');

            $result = $this->db->insert($this->tbl_epcr, $args);
           // if($args['operate_by'] == 'dco-40'){
             //echo $this->db->last_query();die;
           // }
            
            
           
            if ($result) {
                return $unique_id;
            } else {
                return false;
            }
        } else {

            $this->db->where("id", $present[0]->id);
            $res = $this->db->update($this->tbl_epcr, $args);
            // if($args['operate_by'] == 'dco-40'){
            //echo $this->db->last_query();die;
            // }
            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
    }
    
     function get_epcr($args = array()) {


        $this->db->select('*');
        $this->db->from("$this->tbl_epcr");
        //$this->db->where("$this->tbl_epcr.amb_reg_id" , $args['amb_reg_id']);
        $this->db->where("$this->tbl_epcr.inc_ref_id", $args['inc_ref_id']);
        $this->db->where("$this->tbl_epcr.ptn_id", $args['ptn_id']);
        $this->db->where("$this->tbl_epcr.epcris_deleted", '0');
       // $fetched = $this->db->get();
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    
    /////////////////////MI42/////////////////////////////
    //
    //Purpose : Update EPCR loc details.
    //
    ///////////////////////////////////////////////////////


    function update_epcr_loc($args = array()) {

        $sql = "UPDATE $this->tbl_epcr SET loc='" . $args['loc'] . "' WHERE id='" . $args['pcr_id'] . "'";

        $result = $this->db->query($sql);

        return $result;
    }

    function update_is_deleted($args = array()) {

        $sql = "UPDATE $this->tbl_epcr SET epcris_deleted='1' WHERE inc_ref_id='" . $args['inc_ref_id'] . "'";

        $result = $this->db->query($sql);
        

        return $result;
    }
   function update_epcr_details($args,$where){
       
        if($where['inc_ref_id'] != '' || $where['inc_ref_id'] != NULL){ 
            
            $this->db->where('inc_ref_id ', $where['inc_ref_id']);
            $this->db->where('ptn_id ', $where['ptn_id']);
       
            $data = $this->db->update($this->tbl_epcr, $args);
           
            
            return $data;
        
        }    
        
    }
       function update_epcr($args,$where){
        if($where['inc_ref_id'] != '' || $where['inc_ref_id'] != NULL){ 
            
            $this->db->where('inc_ref_id ', $where['inc_ref_id']);

            $data = $this->db->update($this->tbl_epcr, $args);
           
            
            return $data;
        
        }    
        
    }
    function update_driver_details($args,$where){
        if($where['dp_pcr_id'] != '' || $where['dp_pcr_id'] != NULL){ 
            
            $this->db->where('dp_pcr_id', $where['dp_pcr_id']);
            
            $data = $this->db->update($this->tbl_driver_pcr, $args);
           
            
            return $data;
        
        }    
        
    }

    function update_epcr_audit($args = array()) {

        $sql = "UPDATE $this->tbl_epcr SET inc_audit_status='1' WHERE inc_ref_id='" . $args['inc_ref_id'] . "'";

        $result = $this->db->query($sql);

        return $result;
    }

    /////////////////////MI44/////////////////////////////
    //
    //Purpose : Insert Consents 
    //
    ///////////////////////////////////////////////////////


    function insert_consents($args = array()) {

        $res = $this->db->query(" INSERT INTO $this->tbl_consents(cons_pcr_id,cons_name,cons_consentee_name,cons_relation,cons_time,cons_lang,consis_deleted) 

            VALUES('" . $args['cons_pcr_id'] . "','" . $args['cons_name'] . "','" . $args['cons_consentee_name'] . "','" . $args['cons_relation'] . "','" . $args['cons_time'] . "','" . $args['cons_lang'] . "','0')

            ON DUPLICATE KEY UPDATE cons_pcr_id = '" . $args['cons_pcr_id'] . "',cons_name='" . $args['cons_name'] . "',cons_consentee_name='" . $args['cons_consentee_name'] . "',cons_relation='" . $args['cons_relation'] . "',cons_time='" . $args['cons_time'] . "',cons_lang='" . $args['cons_lang'] . "'"
        );

        return $res;
    }

    function check_consents($args = array()) {


        if (isset($args['pcr_id']) && $args['pcr_id'] != '') {
            $condition = " AND cons.cons_pcr_id='" . $args['pcr_id'] . "' ";
        }


        $sql = "SELECT cons.*,mas_cons.cons_name,cons.cons_name as consents_id           
                FROM $this->tbl_consents AS cons 
                LEFT JOIN $this->tbl_mas_consents AS mas_cons ON ( mas_cons.cons_id = cons.cons_name ) 
                WHERE cons.consis_deleted = '0' $condition ";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

        function get_epcr_media($args = array()) {


        if (isset($args['incident_id']) && $args['incident_id'] != '') {
            $condition = " AND app_report.incident_id='" . $args['incident_id'] . "' ";
        }


        $sql = "SELECT ems_mas_app_report.*           
                FROM ems_mas_app_report AS app_report 
              
                WHERE 1=1 $condition ";

        $result = $this->db->query($sql);


        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    /////////////////////MI44/////////////////////////////
    //
    //Purpose : Insert Patient mng 1 in assessment table
    //
    ///////////////////////////////////////////////////////

    function insert_assessment($args = array()) {

        $res = $this->db->query(" INSERT INTO $this->tbl_assessment(as_emt_notes,as_ercp_advice,as_ercp_advice_auto_trans	,as_pcr_id,asis_deleted) 

            VALUES('" . $args['as_emt_notes'] . "','" . $args['as_ercp_advice'] . "','" . $args['as_ercp_advice_auto_trans'] . "','" . $args['as_pcr_id'] . "','0')

            ON DUPLICATE KEY UPDATE as_emt_notes = '" . $args['as_emt_notes'] . "',as_ercp_advice='" . $args['as_ercp_advice'] . "',as_ercp_advice_auto_trans='" . $args['as_ercp_advice_auto_trans'] . "',as_pcr_id='" . $args['as_pcr_id'] . "'"
        );

        return $res;
    }

    /////////////////////MI44/////////////////////////////
    //
    //Purpose : Insert Patient mng 1 in cardic table
    //
    ///////////////////////////////////////////////////////

    function insert_cardic($args = array()) {

        $res = $this->db->query(" INSERT INTO $this->tbl_cardic(cr_bystander_cpr,cr_rosc,cr_start_time,cr_puls_rosc,cr_no_of_shocks,cr_loc_at_rosc,cr_systolic,cr_diastolic,cr_pcr_id,cr_is_deleted) 

            VALUES('" . $args['cr_bystander_cpr'] . "','" . $args['cr_rosc'] . "','" . $args['cr_start_time'] . "','" . $args['cr_puls_rosc'] . "','" . $args['cr_no_of_shocks'] . "','" . $args['cr_loc_at_rosc'] . "','" . $args['cr_systolic'] . "','" . $args['cr_diastolic'] . "','" . $args['cr_pcr_id'] . "','0')

            ON DUPLICATE KEY UPDATE cr_bystander_cpr = '" . $args['cr_bystander_cpr'] . "',cr_rosc='" . $args['cr_rosc'] . "',cr_start_time='" . $args['cr_start_time'] . "',cr_puls_rosc='" . $args['cr_puls_rosc'] . "',cr_no_of_shocks='" . $args['cr_no_of_shocks'] . "',cr_loc_at_rosc='" . $args['cr_loc_at_rosc'] . "',cr_systolic='" . $args['cr_systolic'] . "',cr_diastolic='" . $args['cr_diastolic'] . "',cr_pcr_id='" . $args['cr_pcr_id'] . "'"
        );

        return $res;
    }

    /////////////////////MI44/////////////////////////////
    //
    //Purpose : Insert Patient mng 1 in birth details table
    //
    ///////////////////////////////////////////////////////

    function insert_birth_details($args = array()) {


        $res = $this->db->query(" INSERT INTO $this->tbl_birth_details(birth_time,birth_at_amb,birth_at_home,birth_pcr_id,birthis_deleted) 

            VALUES('" . $args['birth_time'] . "','" . $args['birth_at_amb'] . "','" . $args['birth_at_home'] . "','" . $args['birth_pcr_id'] . "','0')

            ON DUPLICATE KEY UPDATE birth_time = '" . $args['birth_time'] . "',birth_at_amb='" . $args['birth_at_amb'] . "',birth_at_home='" . $args['birth_at_home'] . "',birth_pcr_id='" . $args['birth_pcr_id'] . "'"
        );

        return $res;
    }

    /////////////////////MI44/////////////////////////////
    //
    //Purpose : Insert Patient mng 1 in apgar table 
    //
    ///////////////////////////////////////////////////////

    function insert_apgar($args = array()) {

        // $result = $this->db->insert($this->tbl_apgar, $args);

        $res = $this->db->query(" INSERT INTO $this->tbl_apgar(ap_1min,ap_5min,ap_pcr_id,apis_deleted) 

            VALUES('" . $args['ap_1min'] . "','" . $args['ap_5min'] . "','" . $args['ap_pcr_id'] . "','0')

            ON DUPLICATE KEY UPDATE ap_1min = '" . $args['ap_1min'] . "',ap_5min='" . $args['ap_5min'] . "',ap_pcr_id='" . $args['ap_pcr_id'] . "'"
        );

        return $res;
    }

    /** MI13
     * Get incident ambulance details 
     */
    function get_inc_amb($args = array()) {
        if ($args['inc_ref_id']) {
            $condition = " AND in_am.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['amb_ref_id']) {
            $condition .= " AND in_am.amb_rto_register_no='" . $args['amb_ref_id'] . "' ";
        }
//                    $sql =   "SELECT amb.amb_id, amb.amb_type, amb.amb_rto_register_no, amb.amb_default_mobile, hp.hp_id, hp.hp_name,in_am.amb_pilot_id,in_am.amb_emt_id" 
//                    ." FROM ems_ambulance AS amb"
//                    ." LEFT JOIN ems_hospital AS hp ON ( hp.hp_id = amb.amb_base_location )"
//                    ." LEFT JOIN ems_incidence_ambulance AS in_am ON ( in_am.amb_rto_register_no = amb.amb_rto_register_no )"
//                    ." WHERE amb.ambis_deleted = '0'"
//                 
//                    ." AND amb.amb_status = '1' $condition";

        $sql = "SELECT ar_type.ar_id,amb_type.ambt_id,amb_type.ambt_name,amb.amb_id,wrd.ward_id,wrd.ward_name, amb.amb_type, amb.amb_rto_register_no, amb.amb_default_mobile, hp.hp_id, hp.hp_name,in_am.amb_pilot_id,in_am.amb_emt_id, clg.clg_first_name as pilot_name ,clg.clg_mid_name as p_mid_name,clg.clg_last_name as p_last_name,e_clg.clg_first_name as emt_name,e_clg.clg_emso_id as emso_id, e_clg.clg_mid_name as e_mid_name, e_clg.clg_last_name as e_last_name,ar_name
                    FROM ems_ambulance AS amb 
                    LEFT JOIN $this->tbl_mas_amb_type As amb_type ON (amb_type.ambt_id = amb.amb_type)
                    LEFT JOIN ems_mas_area_types as ar_type ON (ar_type.ar_id = amb.amb_working_area)
                    LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location ) 
                    LEFT JOIN ems_incidence_ambulance AS in_am ON ( in_am.amb_rto_register_no = amb.amb_rto_register_no )
                    LEFT JOIN ems_colleague AS clg ON ( clg.clg_ref_id = in_am.amb_pilot_id )
                    LEFT JOIN ems_colleague AS e_clg ON ( e_clg.clg_ref_id = in_am.amb_emt_id )
                    LEFT JOIN ems_mas_ward AS wrd ON ( wrd.ward_id = amb.ward_name ) 
                    WHERE amb.ambis_deleted = '0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_amb_location($args = array()) {
        if ($args['inc_ref_id']) {
            $condition = " AND in_am.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['amb_ref_id']) {
            $condition .= " AND amb.amb_rto_register_no='" . $args['amb_ref_id'] . "' ";
        }
//                    $sql =   "SELECT amb.amb_id, amb.amb_type, amb.amb_rto_register_no, amb.amb_default_mobile, hp.hp_id, hp.hp_name,in_am.amb_pilot_id,in_am.amb_emt_id" 
//                    ." FROM ems_ambulance AS amb"
//                    ." LEFT JOIN ems_hospital AS hp ON ( hp.hp_id = amb.amb_base_location )"
//                    ." LEFT JOIN ems_incidence_ambulance AS in_am ON ( in_am.amb_rto_register_no = amb.amb_rto_register_no )"
//                    ." WHERE amb.ambis_deleted = '0'"
//                 
//                    ." AND amb.amb_status = '1' $condition";
//        $sql = "SELECT amb.amb_id, amb.amb_type, amb.amb_rto_register_no, amb.amb_default_mobile, hp.hp_id, hp.hp_name,in_am.amb_pilot_id,in_am.amb_emt_id, clg.clg_first_name as pilot_name ,clg.clg_mid_name as p_mid_name,clg.clg_last_name as p_last_name,e_clg.clg_first_name as emt_name,e_clg.clg_emso_id as emso_id, e_clg.clg_mid_name as e_mid_name, e_clg.clg_last_name as e_last_name,ar_name
//                    FROM ems_ambulance AS amb 
//                    LEFT JOIN ems_mas_area_types as ar_type ON (ar_type.ar_id = amb.amb_working_area)
//                    LEFT JOIN ems_hospital AS hp ON ( hp.hp_id = amb.amb_base_location ) 
//                    LEFT JOIN ems_incidence_ambulance AS in_am ON ( in_am.amb_rto_register_no = amb.amb_rto_register_no )
//                    LEFT JOIN ems_colleague AS clg ON ( clg.clg_ref_id = in_am.amb_pilot_id )
//                    LEFT JOIN ems_colleague AS e_clg ON ( e_clg.clg_ref_id = in_am.amb_emt_id )
//                    WHERE amb.ambis_deleted = '0' $condition ";

        $sql = "SELECT amb.amb_id,amb.amb_district,amb.amb_type,ambt.*,amb.amb_rto_register_no, amb.amb_default_mobile, hp.hp_id, hp.hp_name
                    FROM ems_ambulance AS amb 
                    LEFT JOIN ems_base_location AS hp ON ( hp.hp_id = amb.amb_base_location ) 
                    LEFT JOIN ems_mas_ambulance_type AS ambt ON ( ambt.ambt_id = amb.amb_type )
                    WHERE 1=1 $condition ";
        
       

        $result = $this->db->query($sql);
        // echo $this->db->last_query();die; 
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_hospital_location($args = array()) {

        if ($args['hp_district']) {
            $condition .= " AND hosp.hp_district='" . $args['hp_district'] . "' ";
        }

        $sql = "SELECT *
                    FROM ems_hospital AS hosp 
                    WHERE hosp.hpis_deleted = '0' $condition ";



        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    /* MI13
      get ambulance by incident id
     *      */

    function get_inc_amb_by_inc($args = array()) {
        if ($args['inc_ref_id']) {
            $condition = " AND in_am.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        $sql = "SELECT amb.amb_default_mobile,amb.amb_id, amb.amb_rto_register_no,in_am.inc_ref_id,amb_type.ambt_name,amb_type.ambt_id
                FROM ems_ambulance AS amb 
                LEFT JOIN $this->tbl_mas_amb_type As amb_type ON (amb_type.ambt_id = amb.amb_type)
                LEFT JOIN ems_incidence_ambulance AS in_am ON ( in_am.amb_rto_register_no = amb.amb_rto_register_no )
                WHERE 1=1 $condition GROUP BY amb.amb_rto_register_no";
//        echo $sql;
//        die();

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    /* MI13
     * 
     * Get patient details by incident id */

    function get_pat_by_inc($args = array()) {
        if ($args['inc_ref_id']) {
            $condition = " AND in_pt.inc_id='" . $args['inc_ref_id'] . "' ";
        }
         if ($args['gender']) {
            $condition .= " AND pat.ptn_gender='" . $args['gender'] . "' ";
        }
        $sql = "SELECT pat.*
                FROM ems_patient AS pat 
                LEFT JOIN ems_incidence_patient AS in_pt ON ( in_pt.ptn_id = pat.ptn_id )
                WHERE pat.ptnis_deleted = '0' $condition ";


        $result = $this->db->query($sql);

//        if ($result) {
//            return $result->result();
//        } else {
//            return false;
//        }
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    function get_pending_pat_by_inc_reval($args = array()) {
      
        $condition = "";
        if ($args['inc_ref_id'] != '') {
            $condition .= " AND in_pt.inc_id='" . $args['inc_ref_id'] . "' ";
        }
        
        // if ($args['pcr_status'] == '') {
        //     $condition .= " AND pat.ptn_pcr_status='0'  ";
        // }else if($args['pcr_status'] == '1'){
        //    $condition .= " AND pat.ptn_pcr_status IN ('1','0') ";
        // }
        
        // if ($args['pcr_validation_status'] != '') {
        //     $condition .= " AND pat.ptn_pcr_validate_status='0'  ";
        // }
           $sql = "SELECT pat.*
                FROM ems_patient AS pat 
                LEFT JOIN ems_incidence_patient AS in_pt ON ( in_pt.ptn_id = pat.ptn_id )
                WHERE  pat.ptnis_deleted = '0' $condition ";

        $result = $this->db->query($sql);
// echo $this->db->last_query();die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    

   function get_pending_pat_by_inc($args = array()) {
      
        $condition = "";
        if ($args['inc_ref_id'] != '') {
            $condition .= " AND in_pt.inc_id='" . $args['inc_ref_id'] . "' ";
        }
        
        if ($args['pcr_status'] == '') {
            $condition .= " AND pat.ptn_pcr_status='0'  ";
        }else if($args['pcr_status'] == '1'){
           $condition .= " AND pat.ptn_pcr_status IN ('1','0') ";
        }
        
        if ($args['pcr_validation_status'] != '') {
            $condition .= " AND pat.ptn_pcr_validate_status='0'  ";
        }
//         $sql = "SELECT pat.*
//                FROM ems_patient AS pat 
//                LEFT JOIN ems_incidence_patient AS in_pt ON ( in_pt.ptn_id = pat.ptn_id )
//                WHERE in_pt.ptn_id NOT IN (SELECT ems_epcr.ptn_id FROM ems_epcr)  AND pat.ptnis_deleted = '0' $condition ";
           $sql = "SELECT pat.*
                FROM ems_patient AS pat 
                LEFT JOIN ems_incidence_patient AS in_pt ON ( in_pt.ptn_id = pat.ptn_id )
                WHERE  pat.ptnis_deleted = '0' $condition ";
     
        
       
        // $sql = " SELECT inc_ptn.ptn_id FROM `ems_incidence_patient` as inc_ptn WHERE ptn_id NOT IN (SELECT `ems_epcr`.`ptn_id` FROM `ems_epcr` ) AND inc_id ='" . $args['inc_ref_id'] . "'";
        


        $result = $this->db->query($sql);
// echo $this->db->last_query();die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    

    /*
      MI13
     *      */

    function get_police_info($args = array()) {
        if ($args['inc_ref_id']) {
            $condition = " AND op.sub_id='" . $args['inc_ref_id'] . "' ";
        }
        $sql = "SELECT clg.*
                FROM ems_colleague AS clg 
                LEFT JOIN ems_operateby AS op ON ( op.operator_id = clg.clg_ref_id ) 
                WHERE op.sub_id= 'PILOT' AND clg.clg_is_deleted = '0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    /* MI13
     * Update ambulance 
     */

    function update_amb_by_reg($args = array()) {

        if ($args['amb_rto_register_no']) {

            $this->db->where('amb_rto_register_no', $args['amb_rto_register_no']);
            $update = $this->db->update($this->tbl_amb, $args);

            if ($update) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /* MI13
      get trip closer(epcr) details by id
     *      */

    function get_epcr_inc_details($args) {

        if ($args['inc_ref_id']) {
            $condition .= " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['ptn_id']) {
            $condition .= " AND epcr.ptn_id='" . $args['ptn_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND epcr.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") ";
        }


        $sql = "SELECT epcr.*, hp.hp_name,loc.level_type,hp.hp_id,pro_imp.pro_name,procase_imp.case_name,call_type_epcr.id as call_type_epcr_id,call_type_epcr.call_type as calltypenm"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_mas_provider_casetype AS procase_imp ON ( procase_imp.case_id  = epcr.provider_casetype)"
             . " LEFT JOIN ems_mas_call_type_epcr AS call_type_epcr ON ( call_type_epcr.id  = epcr.epcr_call_type)"
            . " WHERE  epcris_deleted ='0' $condition GROUP BY epcr.inc_ref_id order by  epcr.pk_id DESC" ;
      
 

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_epcr_inc_clouser_details($args) {

        if ($args['inc_ref_id']) {
            $condition .= " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['ptn_id']) {
            $condition .= " AND epcr.ptn_id='" . $args['ptn_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND epcr.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") ";
        }

        $sql = "SELECT epcr.*, hp.hp_name,loc.level_type,hp.hp_id,pro_imp.pro_name,inc.*"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN  $this->tbl_incidence AS inc ON ( inc.inc_ref_id = epcr.inc_ref_id )"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " WHERE  epcris_deleted ='0' $condition GROUP BY epcr.inc_ref_id";



        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_epcr_inc_details_by_inc_id($args) {

        if ($args['inc_ref_id']) {
            $condition .= " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['ptn_id']) {  
            $condition .= " AND epcr.ptn_id='" . $args['ptn_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND epcr.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") ";
        }

        $sql = "SELECT epcr.*,clg_emt.clg_last_name,clg_emt.clg_mid_name,clg_emt.clg_first_name, hp.hp_name,loc.level_type,hp.hp_id,pro_imp.pro_name,pro_case.case_name,case_type.call_type"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_mas_provider_casetype AS pro_case ON ( pro_case.case_id = epcr.provider_casetype)"
            . " LEFT JOIN ems_mas_call_type_epcr AS case_type ON ( case_type.id = epcr.epcr_call_type)"
            . " LEFT JOIN   $this->tbl_colleague as clg_emt ON  (clg_emt.clg_ref_id = epcr.operate_by)"
            . " WHERE  epcris_deleted ='0' $condition";
       
        $result = $this->db->query($sql);
         //echo $this->db->last_query();die;

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_epcr_inc_details_by_inc_id_cli($args) {

        if ($args['inc_ref_id']) {
            $condition .= " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }
        if ($args['ptn_id']) {  
            $condition .= " AND epcr.ptn_id='" . $args['ptn_id'] . "' ";
        }
        if ($args['base_month']) {
            $condition .= " AND epcr.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ") ";
        }

        $sql = "SELECT epcr.*,clg_emt.clg_last_name,clg_emt.clg_mid_name,clg_emt.clg_first_name, hp.hp_name,loc.level_type,hp.hp_id,pro_imp.pro_name,pro_case.case_name,case_type.call_type,inter.name,GROUP_CONCAT(CONCAT('{',CONCAT_WS(',',CONCAT('\"med_title\"',':',inv.med_title)),'}')) as titles ,GROUP_CONCAT(CONCAT('{',CONCAT_WS(',',CONCAT('\"inv_title\"',':',ems_inv.inv_title)),'}')) as inv_titles"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = epcr.rec_hospital_name )"
            . " LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = epcr.loc )"
            . " LEFT JOIN $this->tbl_mas_provider_imp AS pro_imp ON ( pro_imp.pro_id = epcr.provider_impressions)"
            . " LEFT JOIN $this->tbl_mas_provider_casetype AS pro_case ON ( pro_case.case_id = epcr.provider_casetype)"
            . " LEFT JOIN ems_mas_call_type_epcr AS case_type ON ( case_type.id = epcr.epcr_call_type)"
            . " LEFT JOIN  $this->tbl_colleague as clg_emt ON  (clg_emt.clg_ref_id = epcr.operate_by)"
            . " LEFT JOIN  ems_ambulance_stock as stock ON  (stock.incidentId = epcr.inc_ref_id)"
            . " LEFT JOIN  ems_inventory_medicine as inv ON  (inv.med_id = stock.as_item_id  AND inv.med_types = stock.as_item_type)"
            . " LEFT JOIN  ems_inventory as ems_inv ON  (ems_inv.inv_id = stock.as_item_id  AND ems_inv.inv_type = stock.as_item_type)"
            . " LEFT JOIN  ems_interventions as inter ON  (inter.id = epcr.ong_intervention)"
            . " WHERE  epcris_deleted ='0' $condition";
    

        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;   

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_pcr_details($args = array()) {

        if ($args['pcr_id']) {
            $condition = " AND pcr.pcr_id='" . $args['pcr_id'] . "' ";
        }
        $sql = "SELECT pcr.*
                FROM $this->tbl_pcr AS pcr  
                WHERE pcr_isdeleted= '0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    /* MI13
      Get EMT Incident to patient count on dashboard
     */

    function get_patient_count($args = array()) {

        if ($args['inc_ref_id']) {
            $condition = " AND pcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


        if ($args['rg_no']) {
            $condition .= " AND epcr.amb_reg_id='" . $args['rg_no'] . "' ";
        }

        if ($args['start_date'] != '' && $args['end_date'] != '') {

            $from = $args['start_date'];
            $to = $args['end_date'];

            $condition .= " AND inc.inc_datetime BETWEEN '$from' AND '$to 23:59:59'";
        }


          $sql = "SELECT COUNT(epcr.inc_ref_id) as pt_cn
                FROM ems_epcr as epcr  
              
                LEFT JOIN ems_incidence as inc ON ( inc.inc_ref_id = epcr.inc_ref_id )
                WHERE epcr.epcris_deleted= '0' $condition "; 
     


        $result = $this->db->query($sql);

       // echo $this->db->last_query();die;

        if ($result) {

            return $result->result();
        } else {
            return false;
        }
    }

    /* MI13
      Get EMT Incident to show on dashboard
     */

    function get_inc_by_emt($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array(), $incomplete_inc_amb = array()) {


        $condition = $offlim = '';
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "'";
        }
        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
           // $offlim = "limit $limit offset $offset ";
            $offlim = "limit 0,100 ";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime ASC";
        }
        
        $epcr='';
        $epr_select= '';
        $sortby_sql = '';
        if ($sortby['close_by_emt'] == "1" ) {
            $EMT = 'DCO';
            $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
            $epcr .=  ' LEFT JOIN  ems_patient AS pat ON ( epcr.ptn_id  = pat.ptn_id  )';
            $epcr .=  ' LEFT JOIN  ems_colleague AS epcr_clg ON ( epcr.operate_by = epcr_clg.clg_ref_id )';
            
            $sortby_sql = " AND epcr.operate_by NOT LIKE '%$EMT%'  AND epcr.epcris_deleted='0' AND is_validate='0' AND pat.ptnis_deleted='0'";
            //$sortby_sql .= " AND epcr_clg.clg_group != 'UG-DCO'  AND epcr.epcris_deleted='0' AND epcr.is_validate='0' ";
            //$sortby_sql .= " AND epcr.epcris_deleted='0' AND epcr.is_validate='0' ";
            $epr_select = " , epcr.operate_by as epcr_operateby, epcr.epcr_call_type as epcr_call_type, epcr.remark as remark";
            $condition .= " AND inc.inc_pcr_status = '1' ";
            $order_by = "ORDER BY inc.inc_datetime ASC";
            if ($sortby['amb_reg_id_new'] != "") {
                $amb_reg_id_new = trim($sortby['amb_reg_id_new']);
                $sortby_sql .= " AND inc_amb.amb_rto_register_no LIKE '%$amb_reg_id_new%'";
            }
            if ($sortby['district_id'] != "") {
               // $sortby_sql .= " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
            }
            if ($sortby['inc_id'] != "") {
                //$sortby_sql .= " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
            }
           
             if ($sortby['provider_impressions'] != "") {
                $sortby_sql .= " AND epcr.provider_impressions = '" . trim($sortby['provider_impressions']) . "'";
            }
             if ($sortby['provider_casetype'] != "") {
                $sortby_sql .= " AND epcr.provider_casetype = '" . trim($sortby['provider_casetype']) . "'";
            }
            if ($sortby['epcr_call_types'] != "") {
               
                if($sortby['epcr_call_types'] == '2' ){
                     $sortby_sql .= " AND inc.patient_ava_or_not = 'yes'";
                }elseif($sortby['epcr_call_types'] == "1"){
                     $sortby_sql .= " AND inc.patient_ava_or_not = 'no'";
                }
            }
            
        if (isset($args['base_month']) && $args['base_month'] != '') {
            $condition.= "AND epcr.base_month IN ('".($args['base_month']-1)."','".$args['base_month']."')";
        }
             $offlim = "limit 0,30 ";
                      
        }else {
            $condition .= "AND inc.inc_pcr_status = '0'";
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
        if ($sortby['reopen_id'] == "1") {
             
            $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
            $sortby_sql .= " AND epcr.is_reopen = '1' AND inc.inc_pcr_status IN ('0','1') ";

        }
        // var_dump($sortby);
        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql .= " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql .= " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }
         if ($args['child_dco']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_dco'] . "')";
        }
        if ($args['system_type']) {
            $condition .= " AND inc.inc_system_type = '" . $args['system_type'] . "'";
        }
       /* if ($args['thirdparty']) {
            $condition .= " AND inc.inc_thirdparty IN ('" . $args['thirdparty'] . "') ";
        }*/
        
        

//        $incomplete_inc_amb_id = implode("','", array_keys($incomplete_inc_amb));
//
//        if (empty($incomplete_inc_amb_id)) {
//            return false;
//        }

          if (isset($args['base_month']) && $args['base_month'] != '') {

            $condition.= "AND inc.inc_base_month IN ('".($args['base_month']-1)."','".$args['base_month']."')";
            
        }
          $sql = "SELECT inc.inc_ref_id,inc.inc_type,purpose.pname,inc.inc_datetime,inc_amb.amb_rto_register_no as amb_rto_register_no,inc_amb.base_location_name as hp_name,clg.clg_mobile_no,clg.clg_first_name,clg.clg_last_name,dist.dst_name,amb.amb_default_mobile,amb.amb_pilot_mobile,amb.amb_pilot_mobile $epr_select
                FROM $this->tbl_incidence AS inc  
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                $epcr  
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )
                LEFT JOIN  $this->tbl_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id )
                LEFT JOIN  ems_mas_call_purpose AS purpose ON ( purpose.pcode = inc.inc_type)
                LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                Where inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc_amb.amb_status = 'assign'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";
          
//          echo $sql;
//          die();
       
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }



    function get_inc_by_emt_re($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array(), $incomplete_inc_amb = array()) {

// print_r($sortby);die;
        $condition = $offlim = '';
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "'";
        }
        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
           // $offlim = "limit $limit offset $offset ";
            $offlim = "limit 0,100 ";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime ASC";
        }
        
        $epcr='';
        $epr_select= '';
        $sortby_sql = '';
     
            $EMT = 'DCO';
            $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
            $epcr .=  ' LEFT JOIN  ems_patient AS pat ON ( epcr.ptn_id  = pat.ptn_id  )';
            $epcr .=  ' LEFT JOIN  ems_colleague AS epcr_clg ON ( epcr.operate_by = epcr_clg.clg_ref_id )';
            
            $sortby_sql = " AND epcr.epcris_deleted='0' AND is_validate='1' AND pat.ptnis_deleted='0'";
            //$sortby_sql .= " AND epcr_clg.clg_group != 'UG-DCO'  AND epcr.epcris_deleted='0' AND epcr.is_validate='0' ";
            //$sortby_sql .= " AND epcr.epcris_deleted='0' AND epcr.is_validate='0' ";
            $epr_select = " , epcr.operate_by as epcr_operateby, epcr.epcr_call_type as epcr_call_type, epcr.remark as remark";
            $condition .= " AND inc.inc_pcr_status = '1' ";
            $condition .= " AND epcr.revalidate_staus = '0' ";
            $order_by = "ORDER BY inc.inc_datetime ASC";

            if ($sortby['amb_reg_id_re'] != "") {
                $amb_reg_id_new = trim($sortby['amb_reg_id_re']);
                $sortby_sql .= " AND inc_amb.amb_rto_register_no LIKE '%$amb_reg_id_new%'";
            }
            if ($sortby['district_id'] != "") {
               // $sortby_sql .= " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
            }
            if ($sortby['inc_id_re'] != "") {
                $sortby_sql .= " AND inc.inc_ref_id = '" . $sortby['inc_id_re'] . "'";
            }
           
             if ($sortby['provider_impressions'] != "") {
                $sortby_sql .= " AND epcr.provider_impressions = '" . trim($sortby['provider_impressions']) . "'";
            }
             if ($sortby['provider_casetype'] != "") {
                $sortby_sql .= " AND epcr.provider_casetype = '" . trim($sortby['provider_casetype']) . "'";
            }
            if ($sortby['epcr_call_types'] != "") {
               
                if($sortby['epcr_call_types'] == '2' ){
                     $sortby_sql .= " AND inc.patient_ava_or_not = 'yes'";
                }elseif($sortby['epcr_call_types'] == "1"){
                     $sortby_sql .= " AND inc.patient_ava_or_not = 'no'";
                }
            }
            
        if (isset($args['base_month']) && $args['base_month'] != '') {
            $condition.= "AND epcr.base_month IN ('".($args['base_month']-1)."','".$args['base_month']."')";
        }
             $offlim = "limit 0,30 ";
                      
    
        if ($sortby['amb_reg_id'] != "") {
            $amb = trim($sortby['amb_reg_id']);
            $sortby_sql .= " AND inc_amb.amb_rto_register_no LIKE '%$amb%'";
        }
        if ($sortby['amb_reg_id_re'] != "") {
            $amb = trim($sortby['amb_reg_id_re']);
            $sortby_sql .= " AND inc_amb.amb_rto_register_no LIKE '%$amb%'";
        }
        if ($sortby['inc_id_re'] != "") {
            $sortby_sql .= " AND inc.inc_ref_id = '" . $sortby['inc_id_re'] . "'";
        }
       
        if ($sortby['district_id'] != "") {
            $sortby_sql .= " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
        }
        if ($sortby['hp_id'] != "") {
            $sortby_sql .= " AND amb.amb_base_location = '" . $sortby['hp_id'] . "'";
        }
        if ($sortby['reopen_id'] == "1") {
             
            $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
            $sortby_sql .= " AND epcr.is_reopen = '1' AND inc.inc_pcr_status IN ('0','1') ";

        }
        // var_dump($sortby);
        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql .= " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql .= " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }
         if ($args['child_dco']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_dco'] . "')";
        }
        if ($args['system_type']) {
            $condition .= " AND inc.inc_system_type = '" . $args['system_type'] . "'";
        }
       /* if ($args['thirdparty']) {
            $condition .= " AND inc.inc_thirdparty IN ('" . $args['thirdparty'] . "') ";
        }*/
        
        

//        $incomplete_inc_amb_id = implode("','", array_keys($incomplete_inc_amb));
//
//        if (empty($incomplete_inc_amb_id)) {
//            return false;
//        }

          if (isset($args['base_month']) && $args['base_month'] != '') {

            $condition.= "AND inc.inc_base_month IN ('".($args['base_month']-1)."','".$args['base_month']."')";
            
        }
          $sql = "SELECT inc.inc_ref_id,inc.inc_type,purpose.pname,inc.inc_datetime,inc_amb.amb_rto_register_no as amb_rto_register_no,inc_amb.base_location_name as hp_name,clg.clg_mobile_no,clg.clg_first_name,clg.clg_last_name,dist.dst_name,amb.amb_default_mobile,amb.amb_pilot_mobile,amb.amb_pilot_mobile $epr_select
                FROM $this->tbl_incidence AS inc  
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                $epcr  
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )
                LEFT JOIN  $this->tbl_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id )
                LEFT JOIN  ems_mas_call_purpose AS purpose ON ( purpose.pcode = inc.inc_type)
                LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                Where inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc_amb.amb_status = 'assign'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";
          
       
        $result = $this->db->query($sql);
        // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
       
    function get_inc_by_inc_id($args = array(), $offset = '', $limit = '') {
        // var_dump($args['base_month']);

        $condition = $offlim = '';
        if ($args['inc_ref_id']) {
            $condition = " AND inc.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        if ($args['operator_id']) {
            $condition = " AND op.operator_id='" . $args['operator_id'] . "'";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter ASC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime DESC";
        }
        if ($offset >= 0 && $limit > 0) {
            $offlim = "limit $limit offset $offset ";
        }
        $sql = "SELECT op.operator_id,op.sub_id,inc.*,inc_amb.amb_rto_register_no,inc_amb.amb_emt_id,clg.clg_mobile_no,clg.clg_first_name,clg.clg_last_name,dist.dst_name,amb.amb_default_mobile,amb.amb_pilot_mobile,hp.hp_name"
            . " FROM $this->tbl_incidence AS inc"
            . " LEFT JOIN $this->tbl_incidence_ambulance AS inc_amb ON ( inc_amb.inc_ref_id = inc.inc_ref_id )"
            . " LEFT JOIN ems_ambulance AS amb ON (amb.amb_rto_register_no = inc_amb.amb_rto_register_no )"
            . " LEFT JOIN $this->tbl_hp AS hp ON (hp.hp_id = amb.amb_base_location )"
            . " LEFT JOIN  $this->tbl_colleague AS clg ON ( inc_amb.amb_emt_id = clg.clg_ref_id )"
            . " LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )"
            . " LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )"
            . " WHERE inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc_amb.amb_status  = 'assign' $condition GROUP BY inc.inc_ref_id $order_by $offlim";
        //." WHERE  inc.incis_deleted = '0' $condition $offlim";


        $result = $this->db->query($sql);
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }

    function get_injury($args = array(), $limit = '', $offset = '') {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_injury ");

        if (trim($args['inj_name']) != "") {

            $this->db->like("$this->tbl_mas_injury.inj_name", $args['inj_name']);
        }
        if ($args['inj_id'] != "") {

            $this->db->where("$this->tbl_mas_injury.inj_id", $args['inj_id']);
        }
        if ($args['inv_id'] != "") {

            $this->db->where("$this->tbl_mas_injury.inj_id", $args['inv_id']);
        }

        $this->db->where("$this->tbl_mas_injury.inj_status", '1');
        $this->db->where("$this->tbl_mas_injury.injis_deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_front($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_front ");

        if (trim($args['front_name']) != "") {

            $this->db->like("$this->tbl_mas_front.front_name", $args['front_name']);
        }
        if ($args['id'] != "") {

            $this->db->where("$this->tbl_mas_front.id", $args['id']);
        }

        $this->db->where("$this->tbl_mas_front.front_status", '1');
        $this->db->where("$this->tbl_mas_front.frontis_deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_back($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_back");

        if (trim($args['back_name']) != "") {

            $this->db->like("$this->tbl_mas_back.back_name", $args['back_name']);
        }
        if ($args['id'] != "") {

            $this->db->where("$this->tbl_mas_back.id", $args['id']);
        }

        $this->db->where("$this->tbl_mas_back.back_status", '1');
        $this->db->where("$this->tbl_mas_back.backis_deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_side($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_mas_side");

        if (trim($args['side_name']) != "") {

            $this->db->like("$this->tbl_mas_side.side_name", $args['side_name']);
        }
        if ($args['id'] != "") {

            $this->db->where("$this->tbl_mas_side.id", $args['id']);
        }

        $this->db->where("$this->tbl_mas_side.side_status", '1');
        $this->db->where("$this->tbl_mas_side.sideis_deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function insert_trauma($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_trauma");
        $this->db->where("$this->tbl_trauma.pcr_id", $args['pcr_id']);
        $this->db->where("$this->tbl_trauma.patient_id", $args['patient_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {

            $result = $this->db->insert($this->tbl_trauma, $args);

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {

            $this->db->where("id", $present[0]->id);
            $res = $this->db->update($this->tbl_trauma, $args);

            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
    }

    /////////////////MI44//////////////////////
    //
    //Purpose : Insert driver pcr
    //
    ////////////////////////////////////////////


    function insert_deriver_pcr($args = array()) {

        $unique_id = get_uniqid($this->session->userdata('user_default_key'));
        $args['dp_id'] = $unique_id;

        $res = $this->db->query(" INSERT INTO $this->tbl_driver_pcr(dp_id,dp_pcr_id,dp_base_month,dp_date,dp_operated_by,dp_cl_from_desk,dp_cl_from_dsk_km,dp_started_base_loc,dp_started_base_loc_km,dp_reach_on_scene,dp_reach_on_scene_km,dp_on_scene,dp_on_scene_km,dp_hosp_time,dp_hosp_time_km,dp_hand_time,dp_back_to_loc,dp_back_to_loc_km,dpis_deleted,start_odometer,scene_odometer,hospital_odometer,end_odometer,start_from_base,inc_ref_id,inc_dispatch_time,inc_date,responce_time_remark,responce_time_remark_other,responce_time) 

            VALUES('" . $args['dp_id'] . "','" . $args['dp_pcr_id'] . "','" . $args['dp_base_month'] . "','" . $args['dp_date'] . "','" . $args['dp_operated_by'] . "','" . $args['dp_cl_from_desk'] . "','" . $args['dp_cl_from_dsk_km'] . "','" . $args['dp_started_base_loc'] . "','" . $args['dp_started_base_loc_km'] . "','" . $args['dp_reach_on_scene'] . "','" . $args['dp_reach_on_scene_km'] . "','" . $args['dp_on_scene'] . "','" . $args['dp_on_scene_km'] . "','" . $args['dp_hosp_time'] . "','" . $args['dp_hosp_time_km'] . "','" . $args['dp_hand_time'] . "','" . $args['dp_back_to_loc'] . "','" . $args['dp_back_to_loc_km'] . "','0','" . $args['start_odometer'] . "','" . $args['scene_odometer'] . "','" . $args['hospital_odometer'] . "','" . $args['end_odometer'] . "','" . $args['start_from_base'] . "','" . $args['inc_ref_id'] . "','" . $args['inc_dispatch_time'] . "','" . $args['inc_date'] . "','" . $args['responce_time_remark'] . "','" . $args['responce_time_remark_other'] . "','" . $args['responce_time'] . "')

            ON DUPLICATE KEY UPDATE dp_pcr_id = '" . $args['dp_pcr_id'] . "',dp_base_month='" . $args['dp_base_month'] . "',dp_date='" . $args['dp_date'] . "',dp_operated_by='" . $args['dp_operated_by'] . "',dp_cl_from_desk='" . $args['dp_cl_from_desk'] . "',dp_cl_from_dsk_km='" . $args['dp_cl_from_dsk_km'] . "',dp_started_base_loc='" . $args['dp_started_base_loc'] . "',dp_started_base_loc_km='" . $args['dp_started_base_loc_km'] . "',dp_reach_on_scene='" . $args['dp_reach_on_scene'] . "',dp_reach_on_scene_km='" . $args['dp_reach_on_scene_km'] . "',dp_on_scene='" . $args['dp_on_scene'] . "',dp_on_scene_km='" . $args['dp_on_scene_km'] . "',dp_hosp_time='" . $args['dp_hosp_time'] . "',dp_hosp_time_km='" . $args['dp_hosp_time_km'] . "',dp_hand_time='" . $args['dp_hand_time'] . "',dp_back_to_loc='" . $args['dp_back_to_loc'] . "',dp_back_to_loc_km='" . $args['dp_back_to_loc_km'] . "',start_odometer='" . $args['start_odometer'] . "',start_from_base='" . $args['start_from_base'] . "',end_odometer='" . $args['end_odometer'] . "',inc_ref_id='" . $args['inc_ref_id'] . "',inc_dispatch_time='" . $args['inc_dispatch_time'] . "',inc_date='" . $args['inc_date'] . "',responce_time_remark='" . $args['responce_time_remark'] . "',responce_time_remark_other='" . $args['responce_time_remark_other'] . "',responce_time='" . $args['responce_time'] . "'"
        );

//echo $this->db->last_query(); die();

        return $res;
    }

    function save_trasfer_hospital($args) {
        $this->db->select('*');
        $this->db->from("$this->tbl_hospital_transfer");
        $this->db->where("$this->tbl_hospital_transfer.pcr_id", $args['pcr_id']);
        $this->db->where("$this->tbl_hospital_transfer.patient_id", $args['patient_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {

            $result = $this->db->insert($this->tbl_hospital_transfer, $args);

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {

            $this->db->where("id", $present[0]->id);
            $res = $this->db->update($this->tbl_hospital_transfer, $args);

            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
    }

    function save_patient_addasst_hos($args = array()) {

        if (!$args['asst_type']) {
            $asst_type = 'amb';
        } else {
            $asst_type = $args['asst_type'];
        }


        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_addasst(pcr_id,asst_breath_satus,asst_breath_rate,asst_breath_effort,asst_pulse_radial,asst_pulse_carotid,asst_pulse_cap,asst_pulse_skin,asst_gcs,asst_bsl,asst_pupils_right,asst_pupils_left,asst_la_right_air,asst_la_right_adds,asst_la_left_air,asst_la_left_adds,asst_ptn_his,asst_date,asst_base_month,asst_type) 

            VALUES('" . $args['pcr_id'] . "','" . $args['asst_breath_satus'] . "','" . $args['asst_breath_rate'] . "','" . $args['asst_breath_effort'] . "','" . $args['asst_pulse_radial'] . "','" . $args['asst_pulse_carotid'] . "','" . $args['asst_pulse_cap'] . "','" . $args['asst_pulse_skin'] . "','" . $args['asst_gcs'] . "','" . $args['asst_bsl'] . "','" . $args['asst_pupils_right'] . "','" . $args['asst_pupils_left'] . "','" . $args['asst_la_right_air'] . "','" . $args['asst_la_right_adds'] . "','" . $args['asst_la_left_air'] . "','" . $args['asst_la_left_adds'] . "','" . $args['asst_ptn_his'] . "','" . $args['asst_date'] . "','" . $args['asst_base_month'] . "','" . $asst_type . "')

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',asst_breath_satus='" . $args['asst_breath_satus'] . "',asst_breath_rate='" . $args['asst_breath_rate'] . "',asst_breath_effort='" . $args['asst_breath_effort'] . "',asst_pulse_radial='" . $args['asst_pulse_radial'] . "',asst_pulse_carotid='" . $args['asst_pulse_carotid'] . "',asst_pulse_cap='" . $args['asst_pulse_cap'] . "',asst_pulse_skin='" . $args['asst_pulse_skin'] . "',asst_gcs='" . $args['asst_gcs'] . "',asst_bsl='" . $args['asst_bsl'] . "',asst_pupils_right='" . $args['asst_pupils_right'] . "',asst_pupils_left='" . $args['asst_pupils_left'] . "',asst_la_right_air='" . $args['asst_la_right_air'] . "',asst_la_right_adds='" . $args['asst_la_right_adds'] . "',asst_la_left_air='" . $args['asst_la_left_air'] . "',asst_la_left_adds='" . $args['asst_la_left_adds'] . "',asst_ptn_his='" . $args['asst_ptn_his'] . "',asst_date='" . $args['asst_date'] . "',asst_base_month='" . $args['asst_base_month'] . "',asst_type ='" . $asst_type . "'"
        );

        return $res;
    }

    function save_patient_asst_hos($args = array()) {


        $res = $this->db->query(" INSERT INTO $this->tbl_ptn_asst(pcr_id,asst_loc,asst_pulse,asst_rr,asst_bp_syt,asst_bp_dia,asst_o2sat,asst_temp,asst_pt_status,asst_date,asst_base_month,asst_min,ongoin_medication) 

            VALUES('" . $args['pcr_id'] . "','" . $args['asst_loc'] . "','" . $args['asst_pulse'] . "','" . $args['asst_rr'] . "','" . $args['asst_bp_syt'] . "','" . $args['asst_bp_dia'] . "','" . $args['asst_o2sat'] . "','" . $args['asst_temp'] . "','" . $args['asst_pt_status'] . "','" . $args['asst_date'] . "','" . $args['asst_base_month'] . "','" . $args['asst_min'] . "','" . $args['ongoin_medication'] . "') 

            ON DUPLICATE KEY UPDATE pcr_id = '" . $args['pcr_id'] . "',asst_loc='" . $args['asst_loc'] . "',asst_pulse='" . $args['asst_pulse'] . "',asst_rr='" . $args['asst_rr'] . "',asst_bp_syt='" . $args['asst_bp_syt'] . "',asst_bp_dia='" . $args['asst_bp_dia'] . "',asst_o2sat='" . $args['asst_o2sat'] . "',asst_temp='" . $args['asst_temp'] . "',asst_pt_status='" . $args['asst_pt_status'] . "',asst_date='" . $args['asst_date'] . "',asst_base_month='" . $args['asst_base_month'] . "',asst_min='" . $args['asst_min'] . "',ongoin_medication='" . $args['ongoin_medication'] . "'"
        );


        return $res;
    }

    function get_trans_hosp($args = array()) {


        if ($args['pcr_id']) {
            $condition = " AND hp_tr.pcr_id='" . $args['pcr_id'] . "' ";
        }

        $sql = "SELECT hp_tr.*, hp.hp_name,hp.hp_id,hp_tp.hosp_type,hp_tp.hosp_id "
            . " FROM $this->tbl_hospital_transfer AS hp_tr"
            . " LEFT JOIN $this->tbl_hp AS hp ON ( hp.hp_id = hp_tr.hospital_name )"
            . " LEFT JOIN $this->tbl_mas_hospital_type  AS hp_tp ON ( hp_tp.hosp_id = hp_tr.type_of_hospital )"
            . " WHERE hp_tr.base_month IN (" . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  AND  hptris_deleted ='0' $condition";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function get_trauma($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_trauma");
        $this->db->where("$this->tbl_trauma.pcr_id", $args['pcr_id']);
        $this->db->where("$this->tbl_trauma.patient_id", $args['patient_id']);
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    ///////////////////MI44//////////////////////////////
    //
    //Purpose : get driver data
    //
    /////////////////////////////////////////////////////


    function get_driver($args = array()) {

        if (isset($args['dp_pcr_id']) && $args['dp_pcr_id'] != '') {
            $condition .= " AND dp_pcr_id='" . $args['dp_pcr_id'] . "' ";
        }
        if (isset($args['inc_ref_id']) && $args['inc_ref_id'] != '') {
            $condition .= " AND inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


         $sql = "SELECT *                
                FROM $this->tbl_driver_pcr 
                WHERE dpis_deleted = '0' $condition ";
      

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    ////////////MI44 get patient mng 1 data/////////////

    function get_pat_mng_data($args = array()) {

        if (isset($args['pcr_id']) && $args['pcr_id'] != '') {
            $condition = " AND asmt.as_pcr_id='" . $args['pcr_id'] . "' ";
        }
        $sql = "SELECT asmt.*,apgar.*,birth.*,cardic.*,loc.*
                FROM $this->tbl_assessment AS asmt 
                LEFT JOIN $this->tbl_cardic AS cardic ON ( cardic.cr_pcr_id = asmt.as_pcr_id ) 
                LEFT JOIN $this->tbl_birth_details AS birth ON ( birth.birth_pcr_id = asmt.as_pcr_id )
                LEFT JOIN $this->tbl_apgar AS apgar ON ( apgar.ap_pcr_id = asmt.as_pcr_id )    
                LEFT JOIN $this->tbl_loc_level AS loc ON ( loc.level_id = cardic.cr_loc_at_rosc )
                WHERE asmt.asis_deleted = '0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }

    function insert_med_inv($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_pcr_med_inv");
        $this->db->where("$this->tbl_pcr_med_inv.pcr_id", $args['pcr_id']);
        $this->db->where("$this->tbl_pcr_med_inv.patient_id", $args['patient_id']);
        $fetched = $this->db->get();
        $present = $fetched->result();

        if (count($present) == 0) {

            $result = $this->db->insert($this->tbl_pcr_med_inv, $args);

            if ($result) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        } else {

            $this->db->where("id", $present[0]->id);
            $res = $this->db->update($this->tbl_pcr_med_inv, $args);

            if ($res) {
                return $present[0]->id;
            } else {
                return false;
            }
        }
    }

    function get_pcr_med_inv($args = array()) {

        $this->db->select('*');
        $this->db->from("$this->tbl_pcr_med_inv");
        $this->db->where("$this->tbl_pcr_med_inv.pcr_id", $args['pcr_id']);
        $this->db->where("$this->tbl_pcr_med_inv.patient_id", $args['patient_id']);
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function get_calltype_epcr($args = array()) {
        //var_dump($args);
        
        $this->db->select('*');
        $this->db->from("ems_mas_call_type_epcr");
        if (trim($args['call_type']) != "") {
            $this->db->like("ems_mas_call_type_epcr.call_type", $args['call_type']);
        }
        if($args['call_type_data'] == 'DROP_BACK' || $args['call_type_data'] == 'PICK_UP')
        {
            $type = array('2','1');
            $this->db->where_in("ems_mas_call_type_epcr.id", $type);
            
        }else{
            if (trim($args['id']) != "") {
            $this->db->where("ems_mas_call_type_epcr.id", $args['id']);
            }
        }
        
        $this->db->where("ems_mas_call_type_epcr.call_type_status", '0');
        $this->db->order_by("id", 'DESC');
        
        //$this->db->order_by("case_name","asc");
        $data = $this->db->get();
        // echo $this->db->last_query();
        //die();
        $result = $data->result();
        return $result;
    }
    function get_provider_casetype($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_provider_casetype");

        if (trim($args['case_name']) != "") {

            $this->db->like("$this->tbl_mas_provider_casetype.case_name", $args['case_name']);
        }
        if($args['epcr_call_type']!=""){
           // $this->db->where("$this->tbl_mas_provider_casetype.case_call_type", $args['epcr_call_type']);
            $this->db->LIKE('case_call_type', $args['epcr_call_type'],'both');
        }
        if ($args['gender'] == 'F') {
            //$id = array('27', '28', '29','55','39');
            $ct_gender = array('1', '3');
            $this->db->where_in("$this->tbl_mas_provider_casetype.ct_gender", $ct_gender);
        }else if ($args['gender'] == 'M'){
            $ct_gender = array('1', '2');
            $this->db->where_in("$this->tbl_mas_provider_casetype.ct_gender", $ct_gender);
        }else{
            $ct_gender = array('1');
            $this->db->where_in("$this->tbl_mas_provider_casetype.ct_gender", $ct_gender);
        }
        if (trim($args['case_id']) != "") {
            $this->db->where("$this->tbl_mas_provider_casetype.case_id",$args['case_id']);
        }
        $this->db->where("$this->tbl_mas_provider_casetype.case_status", '1');
        $this->db->where("$this->tbl_mas_provider_casetype.case_iddeleted", '0');
        $this->db->order_by("case_name","asc");
        $data = $this->db->get();
       // if($_SERVER['remote_addr'] == '183.87.235.49'){
       // echo $this->db->last_query();
       // die();
       // }
         $result = $data->result();
      
        return $result;
    }

    function get_provider_imp($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_provider_imp");

        if (trim($args['pro_name']) != "") {

            $this->db->like("$this->tbl_mas_provider_imp.pro_name", $args['pro_name']);
        }
        if($args['epcr_call_type']!=""){
           // $this->db->where("$this->tbl_mas_provider_imp.pro_call_type", $args['epcr_call_type']);
           $this->db->LIKE('pro_call_type', $args['epcr_call_type'],'both');
        }
        /*if($args['amb_type']!=""){
            if($args['amb_type'] == '1'){
                $drop_call = array('24','46','72', '73','74','78','79');
                $this->db->where_in("$this->tbl_mas_provider_imp.pro_id", $drop_call);
            }
            
         }*/
        if ($args['gender'] == 'F') {
            //$id = array('27', '28', '29','55','39');
            $ct_gender = array('1', '3');
            $this->db->where_in("$this->tbl_mas_provider_imp.ct_gender", $ct_gender);
        }else if ($args['gender'] == 'M'){
            $ct_gender = array('1', '2');
            $this->db->where_in("$this->tbl_mas_provider_imp.ct_gender", $ct_gender);
        }else{
            $ct_gender = array('1');
            $this->db->where_in("$this->tbl_mas_provider_imp.ct_gender", $ct_gender);
        }
        $this->db->where("$this->tbl_mas_provider_imp.pro_status", '1');
        $this->db->where("$this->tbl_mas_provider_imp.prois_deleted", '0');
        $this->db->order_by("pro_name","asc");

        $data = $this->db->get();
        $result = $data->result();
        //echo $this->db->last_query();
       // die();
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
    function get_patient_handover_issues($args = array()){
        $this->db->select('*');
        $this->db->from("$this->tbl_app_patient_handover_issues");

        if (trim($args['remark']) != "") {

            $this->db->like("$this->tbl_app_patient_handover_issues.name", $args['remark']);
        }
        $this->db->where("$this->tbl_app_patient_handover_issues.deleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    function get_eqp_standard_remark($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_eqp_standard_remark");

        if (trim($args['pro_name']) != "") {

            $this->db->like("$this->tbl_eqp_standard_remark.remark", $args['remark']);
        }
        if ($args['remark_id']) {
            $this->db->where("$this->tbl_eqp_standard_remark.remark_id",  $args['remark_id']);
        }
        if ($args['remark_type']) {
            $this->db->where("$this->tbl_eqp_standard_remark.remark_type",  $args['remark_type']);
        }


        $this->db->where("$this->tbl_eqp_standard_remark.remark_status", '1');
        $this->db->where("$this->tbl_eqp_standard_remark.isdeleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_odometer($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_odometer_remark");

        if (trim($args['pro_name']) != "") {

            $this->db->like("$this->tbl_odometer_remark.remark", $args['remark']);
        }
        if ($args['remark_id']) {
            $this->db->where("$this->tbl_odometer_remark.remark_id",  $args['remark_id']);
        }


        $this->db->where("$this->tbl_odometer_remark.remark_status", '1');
        $this->db->where("$this->tbl_odometer_remark.isdeleted", '0');

        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_first_inc_by_amb($first_amb_args = array()) {
        $condition = '';
        
        if($first_amb_args['amb_reg_id'] != ''){
            $amb = $first_amb_args['amb_reg_id'];
            $condition .= " AND ems_incidence_ambulance.amb_rto_register_no ='$amb' ";
        }
        if($first_amb_args['system_type'] != ''){
            $system_type = $first_amb_args['system_type'];
            $condition .= " AND inc.inc_system_type ='$system_type' ";
        }
        if($first_amb_args['thirdparty'] != ''){
            $thirdparty = $first_amb_args['thirdparty'];
            $condition .= " AND inc.inc_thirdparty ='$thirdparty' ";
        }

         $sql = "SELECT inc.inc_ref_id,inc.inc_id,ems_incidence_ambulance.amb_rto_register_no
                FROM $this->tbl_incidence AS inc 
                LEFT JOIN ems_incidence_ambulance  ON ( inc.inc_ref_id = ems_incidence_ambulance.inc_ref_id ) Where inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','on_scene_care','EMG_PVT_HOS','PICK_UP','PICKUP_CALL') AND inc.inc_pcr_status = '0' AND ems_incidence_ambulance.amb_status = 'assign' AND inc.inc_base_month IN ( " . ($first_amb_args['base_month'] - 1) . "," . $first_amb_args['base_month'] . ") $condition GROUP BY ems_incidence_ambulance.inc_ref_id order by inc.inc_datetime ASC";
        //echo $sql;
   
       
        $result = $this->db->query($sql);
        $inc_amb_details = $result->result();
      
		
		

        $inc_records = array();
		
			foreach ($inc_amb_details as $inc_amb_obj) {
				$inc_records[$inc_amb_obj->inc_ref_id]['inc_id'] = $inc_amb_obj->inc_id;
				$inc_records[$inc_amb_obj->inc_ref_id]['inc_ref_id'] = $inc_amb_obj->inc_ref_id;
				$inc_records[$inc_amb_obj->inc_ref_id]['amb'] = $inc_amb_obj->amb_rto_register_no;
				$inc_records[$inc_amb_obj->inc_ref_id]['epcr_count'] = 0;
			}
		
//        if($_SERVER['REMOTE_ADDR']=='45.116.46.94'){
//            var_dump($inc_records);
//        }
       
        $condition1 = '';
        if($first_amb_args['system_type'] != ''){
            $system_type = $first_amb_args['system_type'];
            $condition1 .= " AND inc.inc_system_type ='$system_type' ";
        }
        
        if($first_amb_args['amb_reg_id'] != ''){
            $amb = $first_amb_args['amb_reg_id'];
            $condition1 .= " AND ems_epcr.amb_reg_id ='$amb' ";
        }
        
        if($first_amb_args['thirdparty'] != ''){
            $thirdparty = $first_amb_args['thirdparty'];
            $condition1 .= " AND inc.inc_thirdparty ='$thirdparty' ";
        }

         $sql1 = "SELECT inc.inc_ref_id
                FROM $this->tbl_incidence AS inc, ems_epcr Where inc.inc_ref_id = ems_epcr.inc_ref_id  AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','on_scene_care','EMG_PVT_HOS','PICK_UP','PICKUP_CALL') AND  inc.inc_pcr_status = '0'  AND epcris_deleted = '0' AND inc.inc_base_month IN ( " . ($first_amb_args['base_month'] - 1) . "," . $first_amb_args['base_month'] . ")  $condition1 order by inc.inc_datetime ASC";
        

        
        $result = $this->db->query($sql1);
        $inc_epcr_details = $result->result();
        
		
		

        foreach ($inc_epcr_details as $inc_epcr_obj) {
            $inc_records[$inc_epcr_obj->inc_ref_id]['epcr_count'] += 1;
        }

        $condition_pat = '';
        if($first_amb_args['system_type'] != ''){
            $system_type = $first_amb_args['system_type'];
            $condition_pat .= " AND inc.inc_system_type ='$system_type' ";
        }
        if($first_amb_args['thirdparty'] != ''){
            $thirdparty = $first_amb_args['thirdparty'];
            $condition_pat .= " AND inc.inc_thirdparty ='$thirdparty' ";
        }
    

          $sql_pat = "SELECT inc.inc_ref_id,inc.inc_id
                FROM $this->tbl_incidence AS inc, ems_incidence_patient AS inc_ptn Where inc.inc_ref_id = inc_ptn.inc_id AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','on_scene_care','EMG_PVT_HOS','PICK_UP','PICKUP_CALL') AND inc.inc_pcr_status = '0' AND inc.inc_base_month IN ( " . ($first_amb_args['base_month'] - 1) . "," . $first_amb_args['base_month'] . ")  $condition_pat";
         // echo $sql_pat;
         // die();
      

        $ptn_result = $this->db->query($sql_pat);
        $ptn_result_data = $ptn_result->result();

        foreach ($ptn_result_data as $inc_ptn_obj) {
            $inc_records[$inc_ptn_obj->inc_ref_id]['ptn_count'] += 1;
        }

        
        $inc_records_temp = array();
       foreach ($inc_records as $inc_ref_id => $inc_record) {
           // $inc_id_temp = str_ireplace('A-', '9', $inc_record['inc_id']);
            $inc_records_temp[$inc_record['inc_id']]=$inc_record;
        }
		
        $inc_records = $inc_records_temp;

        
        ksort($inc_records,SORT_NUMERIC);

        
        $incomplete_epcr_inc = array();
        $incomplete_epcr_inc_amb = array();
        $incomplete_epcr_amb = array();
        

        foreach ($inc_records as $inc_id_temp => $inc_record) {
            
            if (((int) $inc_record['epcr_count'] < (int) $inc_record['ptn_count'] || (int) $inc_record['ptn_count'] == 0) && (!in_array($inc_record['amb'],$incomplete_epcr_amb)) ) {
                
                //if ((int) $inc_record['epcr_count'] < (int) $inc_record['ptn_count']) {
                $incomplete_epcr_inc[$inc_record['inc_ref_id']] = $inc_record;
                $incomplete_epcr_inc[$inc_record['inc_ref_id']] = $inc_record;
                $incomplete_epcr_inc_amb[$inc_record['inc_ref_id']] = $inc_record['amb'];
                $incomplete_epcr_amb[] = $inc_record['amb'];
                
            }
        }
		//var_dump($incomplete_epcr_inc_amb);
		//die();

        return $incomplete_epcr_inc_amb;

       // ksort($inc_records, SORT_NUMERIC);

//        $incomplete_epcr_inc = array();
//        $incomplete_epcr_inc_amb = array();
//
//        foreach ($inc_records as $inc_ref_id => $inc_record) {
//
//            if (( (int) $inc_record['epcr_count'] < (int) $inc_record['ptn_count'] && !in_array($inc_record['amb'], $incomplete_epcr_inc_amb)) || (int) $inc_record['ptn_count'] == 0) {
//                $incomplete_epcr_inc[$inc_ref_id] = $inc_record;
//                $incomplete_epcr_inc_amb[$inc_ref_id] = $inc_record['amb'];
//            }
//        }
//
//        return $incomplete_epcr_inc_amb;
    }

    function get_incomplete_inc_amb($args = array()) {

        if ($args['operator_id']) {
            $condition = " AND op.operator_id='" . $args['operator_id'] . "'";
        }

        $sql = "SELECT inc.inc_ref_id,inc_amb.amb_rto_register_no
                FROM $this->tbl_incidence AS inc
                LEFT JOIN ems_operateby AS op ON ( op.sub_id = inc.inc_ref_id )
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                LEFT JOIN $this->tbl_amb as amb ON ( inc_amb.amb_rto_register_no = amb.amb_rto_register_no ) Where inc.inc_set_amb = '1' AND inc.incis_deleted = '0'  AND inc_amb.amb_status = 'assign'  AND inc.inc_base_month IN ( " . ($args['base_month'] - 1) . "," . $args['base_month'] . ")  $condition order by inc.inc_datetime ASC";

        $result = $this->db->query($sql);
        $inc_amb_details = $result->result();

        $inc_records = array();

        foreach ($inc_amb_details as $inc_amb_obj) {

            $inc_records[$inc_amb_obj->inc_ref_id]['amb'] = $inc_amb_obj->amb_rto_register_no;
            $inc_records[$inc_amb_obj->inc_ref_id]['epcr_count'] = 0;
        }

        $sql = "SELECT inc.inc_ref_id
                FROM $this->tbl_incidence AS inc, ems_epcr Where inc.inc_ref_id = ems_epcr.inc_ref_id  AND inc.inc_set_amb = '1' AND inc.incis_deleted = '0'  AND inc.inc_base_month IN ( " . ($args['base_month'] - 1) . "," . $args['base_month'] . ") order by inc.inc_datetime ASC";

        $result = $this->db->query($sql);
        $inc_epcr_details = $result->result();


        foreach ($inc_epcr_details as $inc_epcr_obj) {
            if (!isset($inc_records[$inc_epcr_obj->inc_ref_id])) {
                continue;
            }

            $inc_records[$inc_epcr_obj->inc_ref_id]['epcr_count'] += 1;
        }


        $sql_pat = "SELECT inc.inc_ref_id
                FROM $this->tbl_incidence AS inc, ems_incidence_patient AS inc_ptn Where inc.inc_ref_id = inc_ptn.inc_id AND inc.inc_set_amb = '1' AND inc.incis_deleted = '0'  AND inc.inc_base_month IN ( " . ($args['base_month'] - 1) . "," . $args['base_month'] . ")";

        $ptn_result = $this->db->query($sql_pat);
        $ptn_result_data = $ptn_result->result();


        foreach ($ptn_result_data as $inc_ptn_obj) {
            if (!isset($inc_records[$inc_ptn_obj->inc_ref_id])) {
                continue;
            }

            $inc_records[$inc_ptn_obj->inc_ref_id]['ptn_count'] += 1;
        }

        $inc_records_temp = array();
        foreach ($inc_records as $inc_ref_id => $inc_record) {
            //$inc_id_temp = str_ireplace('A-', '9', $inc_record->inc_id);
            $inc_records_temp[$inc_id_temp]=$inc_record->inc_id;
        }
        $inc_records = $inc_records_temp;
		
        
        ksort($inc_records,SORT_NUMERIC);

        $incomplete_epcr_inc = array();
        $incomplete_epcr_amb = array();

        foreach ($inc_records as $inc_id_temp => $inc_record) {
            
            if (((int) $inc_record['epcr_count'] < (int) $inc_record['ptn_count'] || (int) $inc_record['ptn_count'] == 0) && (!in_array($inc_record['amb'],$incomplete_epcr_amb)) ) {
                
                //if ((int) $inc_record['epcr_count'] < (int) $inc_record['ptn_count']) {
                $incomplete_epcr_inc[$inc_record->inc_ref_id] = $inc_record;
                $incomplete_epcr_amb[] = $inc_record['amb'];
            }
        }

        return $incomplete_epcr_inc;
    }

    function get_obious_death_questions() {

        $sql = "SELECT ques.*"
            . " FROM ems_obvious_death_questions AS ques"
            . " WHERE ques.is_deleted = '0'";

        $result = $this->db->query($sql);



        if ($result) {

            return $result->result();
        } else {

            return false;
        }
    }

    function insert_obvious_death_ques_summary($args = array()) {

        $unique_id = get_uniqid($this->session->userdata('user_default_key'));
        $args['id'] = $unique_id;

        $result = $this->db->insert("ems_obvious_death_ques_summary", $args);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    function get_res_time_remark($args = array()) {
        $this->db->select('*');
        $this->db->from("$this->tbl_mas_responce_remark");

        if (trim($args['remark_title']) != "") {

            $this->db->like("$this->tbl_mas_responce_remark.remark_title", $args['remark_title']);
        }

        if (trim($args['id']) != "") {
            $this->db->where("$this->tbl_mas_responce_remark.id", $args['id']);
        }

        $this->db->where("$this->tbl_mas_responce_remark.remark_status", '1');
        $this->db->where("$this->tbl_mas_responce_remark.is_deleted", '0');
        $this->db->order_by("remark_title", "ASC");
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    
    function get_epcr_count_by_inc($args) {

        if ($args['inc_ref_id']) {
            $condition = " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


        $sql = "SELECT epcr.id"
            . " FROM $this->tbl_epcr AS epcr"
            . " WHERE epcris_deleted = '0'   $condition ";
      

        $result = $this->db->query($sql);

        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
        function get_epcr_dco_count_by_inc($args) {

        if ($args['inc_ref_id']) {
            $condition = " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


        $sql = "SELECT epcr.id"
            . " FROM $this->tbl_epcr AS epcr"
            . " LEFT JOIN ems_patient as ptn ON (ptn.ptn_id = epcr.ptn_id)"
            . " WHERE epcris_deleted = '0' AND ptn_pcr_status='1'  $condition ";
      

        $result = $this->db->query($sql);

        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
    function get_epcr_validated($args) {

        if ($args['inc_ref_id']) {
            $condition = " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


        $sql = "SELECT epcr.id"
            . " FROM $this->tbl_epcr AS epcr"
            . " WHERE epcris_deleted = '0' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
     function get_epcr_deleted($args) {

        if ($args['inc_ref_id']) {
            $condition = " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }


        $sql = "SELECT epcr.id"
            . " FROM $this->tbl_epcr AS epcr"
            . " WHERE epcris_deleted = '1' $condition ";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->num_rows();
        } else {
            return false;
        }
    }
    function get_dist_provide_imp_served( $args = array()) {
     //var_dump($args);die;
        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['provider_imp']) {
            if($args['provider_imp'] != 'all'){
              $condition .= " AND epcr.provider_impressions IN ('" . $args['provider_imp'] . "')";
        }
    }

    if ($args['system'] != '' && $args['system'] != 'all'){
            $condition .= " AND epcr.system_type = '" . $args['system'] . "'";

        }  
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
      $sql = "SELECT count(epcr.inc_ref_id) as total_patient FROM ems_epcr as epcr LEFT JOIN ems_incidence as inc on (epcr.inc_ref_id=inc.inc_ref_id) where inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '0' $condition ";
      
     $result = $this->db->query($sql);
    // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
     
    function get_dist_unavail_provide_imp_served( $args = array()) {
        //var_dump($args);die;
           $condition = $offlim = '';
           if ($args['district_id']) {
               $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
           }
           if ($args['from_date'] != '' && $args['to_date'] != '') {
               $from = $args['from_date'];
               $to = $args['to_date'];
               $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
           }
           if ($args['provider_imp']) {
               if($args['provider_imp'] != 'all'){
                 $condition .= " AND epcr.provider_impressions IN ('" . $args['provider_imp'] . "')";
           }
       }
   
       if ($args['system'] != '' && $args['system'] != 'all'){
               $condition .= " AND epcr.system_type = '" . $args['system'] . "'";
   
           }  
   //
           // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
           $sql = "SELECT count(epcr.inc_ref_id) as total_patient FROM ems_epcr as epcr  LEFT JOIN ems_incidence as inc on (epcr.inc_ref_id=inc.inc_ref_id) where inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '1' $condition ";
         
        $result = $this->db->query($sql);
       // echo $this->db->last_query();die;
           if ($args['get_count']) {
               return $result->num_rows();
           } else {
               return $result->result();
           }
       }

    function get_dist_provide_imp_km_served( $args = array()) {

        $condition = $offlim = '';
        if ($args['district_id']) {
            $condition .= " AND epcr.district_id IN ('" . $args['district_id'] . "')";
        }
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND inc.inc_datetime BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if ($args['provider_imp']) {
            if(trim($args['provider_imp']) != 'all'){
              $condition .= " AND epcr.provider_impressions IN ('" . $args['provider_imp'] . "')";
              }
            }
            
        if ($args['system']) {
            if(trim($args['system']) != 'all'){
            $condition .= " AND epcr.system_type IN ('" . $args['system'] . "')";
        }
    }
//
        // $sql = "SELECT count(inc.inc_ref_id) as total_patient FROM ems_incidence as inc LEFT JOIN ems_incidence_patient as inc_ptn on (inc.inc_ref_id=inc_ptn.inc_id) where inc.inc_set_amb = '1' AND inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' $condition";
     $sql = "SELECT sum(ABS(epcr.total_km))as km FROM ems_incidence as inc LEFT JOIN ems_epcr as epcr on (inc.inc_ref_id=epcr.inc_ref_id) where inc.inc_pcr_status = '1' AND inc.incis_deleted = '0' AND epcr.epcris_deleted = '1' $condition ";
      
     $result = $this->db->query($sql);
  // echo $this->db->last_query();die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    
    //Daily SMS 
    function get_today_calls($args){
        
        
            $from = $args['today'];
            $to = $args['today'];
            $condition .= "AND inc.inc_datetime BETWEEN '$from 12:00:01' AND '$to 23:59:59'";
        
        $sql = "SELECT * FROM ems_incidence AS inc WHERE inc.inc_set_amb = '1' AND inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CARE_CALL','PREGANCY_CALL','Child_CARE_CALL','DROP_BACK_CALL','Child_CARE') AND inc.incis_deleted IN ('0')  $condition";
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function get_all_calls($args){
        
       
        $sql = "SELECT * FROM ems_incidence AS inc WHERE inc.inc_set_amb = '1' AND inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','PREGANCY_CARE_CALL','PREGANCY_CALL','Child_CARE_CALL','DROP_BACK_CALL','Child_CARE') AND inc.incis_deleted IN ('0')";
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->num_rows();
        } else {

            return $result->result();
        }
    }
    function inc_info_today($args)
    {
        
            $from = $args['today'];
            $to = $args['today'];
            $condition .= "AND epcr.date BETWEEN '$from 12:00:01' AND '$to 23:59:59'";
        
        //var_dump('hii');die();
        $sql = "SELECT provider_impressions FROM ems_epcr AS epcr WHERE epcr.epcris_deleted = '0' $condition ";
        $result = $this->db->query($sql);
        //echo $this->db->last_query();die();
        if ($args['get_count']) {

            return $result->result();
        } else {

            return $result->result();
        }
    }
    function inc_info_all($args)
    {
        $sql = "SELECT provider_impressions FROM ems_epcr AS epcr WHERE epcr.epcris_deleted = '0' ";
        $result = $this->db->query($sql);
        if ($args['get_count']) {

            return $result->result();
        } else {

            return $result->result();
        }
    }
 function get_amb_status_avaibility($args = array()){
       $condition .= " AND amb.amb_status='" . $args['status'] . "' ";
        $sql = "SELECT amb.*
                FROM ems_ambulance AS amb 
                where amb.ambis_deleted = '0' $condition";
                
        $result = $this->db->query($sql);
         if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
     function get_past_medical_history($args = array()){

         $sql = "SELECT amb.*
                FROM $this->tbl_past_medical_history AS amb 
                where amb.deleted = '0' $condition";
       
        
                
        $result = $this->db->query($sql);
         if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function insert_amb_data($args = array()){
        $result = $this->db->insert($this->tbl_amb_status_availablity, $args);
    }
    
    function get_inc_by_max_assign($args = array()) {


        if ($args['inc_date'] != "") {
            $date = $args['inc_date'];
            $sortby_sql = " AND inc_amb.assigned_time BETWEEN '$date' AND '$date 23:59:59'";
        }


        $sql = "SELECT MAX( inc_amb.assigned_time) as assigned_time,inc_amb_id,amb_rto_register_no FROM ems_incidence_ambulance as inc_amb   LEFT JOIN ems_incidence as inc ON ( inc.inc_ref_id = inc_amb.inc_ref_id ) where inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc.inc_type IN ('MCI','mci','non-mci','NON_MCI','inter-hos','IN_HO_P_TR','AD_SUP_REQ','VIP_CALL','DROP_BACK','Child_CARE_CALL','PREGANCY_CALL','DROP_BACK','EMG_PVT_HOS','PICK_UP','PICKUP_CALL') AND inc.inc_pcr_status = '0' AND inc_amb.amb_status = 'assign'  GROUP by amb_rto_register_no";
 

        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function dco_validation_report($args = array()) {


         $condition = "";
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            //$condition .= " AND epcr.validate_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
            $condition .= " AND epcr.validate_date BETWEEN '$from' AND '$to'";
        }
        if ($args['from_date_validate'] != '' && $args['to_date_validate'] != '') {
            $from = $args['from_date_validate'];
            $to = $args['to_date_validate'];
            $condition .= " AND epcr.validate_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
           // $condition .= " AND epcr.validate_date BETWEEN '$from' AND '$to'";
        }
        if(trim($args['clg_ref_id']) != ''){
              $condition .= " AND epcr.validate_by IN ('" . $args['clg_ref_id'] . "')";
        }


         $sql = "SELECT clg.clg_ref_id,inc_ref_id,clg.clg_first_name,clg.clg_last_name,epcr.validate_date FROM ems_epcr as epcr LEFT JOIN ems_colleague as clg ON clg.clg_ref_id=epcr.validate_by WHERE epcr.is_validate='1' $condition ";
        
       // echo $sql;die();
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_denail_report($args = array()){
        
           $condition = "";
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND den.added_date BETWEEN '$from 00:00:00' AND '$to 23:59:59'";
        }
        if(trim($args['clg_ref_id']) != ''){
              $condition .= " AND den.added_by IN ('" . $args['clg_ref_id'] . "')";
        }
         if(trim($args['district']) != '' && trim($args['district']) != 'all'){
              $condition .= " AND den.amb_district IN ('" . $args['district'] . "')";
        }



         $sql = "SELECT den.id,den.amb_no,dist.dst_name,den.hp_name,den.challenge_val,rea.meaning,den.added_date,den.denial_remark,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name,clg.clg_ref_id,clg.clg_senior FROM `ems_denial_complaints` as den LEFT JOIN `ems_denial_reason` as rea ON den.meaning = rea.id LEFT JOIN `ems_colleague` as clg ON den.added_by = clg.clg_ref_id LEFT JOIN `ems_mas_districts` as dist ON den.amb_district = dist.dst_code where 1=1 $condition ORDER BY `den`.`added_date` DESC";
         
//        echo $sql;
//        die();
// 
        $result = $this->db->query($sql);
        
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
        
    }
     function get_sms_recipients(){
        

        $sql = "SELECT sms_rc.* FROM   $this->sms_recipients as sms_rc where sms_rc.is_deleted='0' ";

        $result = $this->db->query($sql);


        return $result->result();
        
    }
    function deleted_epcr_details($where = array()){
        if($where['inc_ref_id'] != '' || $where['inc_ref_id'] != NULL){ 
            $this->db->where('inc_ref_id ', $where['inc_ref_id']);
            $this->db->where('ptn_id ', $where['ptn_id']);
            $this->db->delete('ems_epcr'); 
        }
    }
   function delete_driver_details($where){
        if($where['dp_pcr_id'] != '' || $where['dp_pcr_id'] != NULL){ 
            
            $this->db->where('dp_pcr_id',$where['dp_pcr_id']);
            $this->db->delete($this->tbl_driver_pcr); 
           
           
        }    
        
    }
    function get_closure_count_by_ambulance_no($amb_reg_no){

        $sql = "SELECT epcr.inc_ref_id FROM ems_epcr as epcr where 1=1 AND amb_reg_id= '$amb_reg_no'";


        $result = $this->db->query($sql);

           
        return $result->num_rows();
           
    }
    function get_closure_count_by_ambulance_no_validate($amb_reg_no){

        $sql = "SELECT epcr.inc_ref_id FROM ems_epcr as epcr where 1=1 AND is_validate='1' AND amb_reg_id= '$amb_reg_no'";


        $result = $this->db->query($sql);

           
        return $result->num_rows();
           
    }
    function get_nhm_inc_by_rtm($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array(), $incomplete_inc_amb = array()) {
        $condition = $offlim = '';
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "'";
        }
        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
           // $offlim = "limit $limit offset $offset ";
            $offlim = "limit 0,25";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter DESC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime DESC";
        }
        
        $epcr='';
        $epr_select= '';
        $sortby_sql = '';
        //$condition .= "AND inc.inc_pcr_status = '0'";
      
        if ($sortby['amb_reg_id'] != "") {
            $amb = trim($sortby['amb_reg_id']);
            $sortby_sql .= " AND amb.amb_rto_register_no LIKE '%$amb%'";
        }
        if ($sortby['district_id'] != "") {
            $sortby_sql .= " AND inc.inc_district_id = '" . $sortby['district_id'] . "'";
        }
        if ($sortby['hp_id'] != "") {
            $sortby_sql .= " AND amb.amb_base_location = '" . $sortby['hp_id'] . "'";
        }
        if ($sortby['reopen_id'] == "1") {
             
            $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
            $sortby_sql .= " AND epcr.is_reopen = '1' AND inc.inc_pcr_status IN ('0','1') ";

        }
        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql .= " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }else{
            $today = date("Y-m-d");
            $days_ago = date('Y-m-d', strtotime('-5 days', strtotime($today)));
            $sortby_sql .= " AND inc.inc_datetime BETWEEN '$days_ago' AND '$today 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql .= " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }
         if ($args['child_dco']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_dco'] . "')";
        }
        if ($args['system_type']) {
            $condition .= " AND inc.inc_system_type = '" . $args['system_type'] . "'";
        }
        if (isset($args['base_month']) && $args['base_month'] != '') {
            //$condition.= "AND inc.inc_base_month IN ('".($args['base_month']-1)."','".$args['base_month']."')";
        }
        /*  $sql = "SELECT dri_pcr.dp_started_base_loc,dri_pcr.dp_on_scene,dri_pcr.dp_back_to_loc,inc.inc_ref_id,inc.inc_recive_time,inc.inc_district_id,inc.inc_type,purpose.pname,inc.inc_datetime,inc.inc_dispatch_time,inc.incis_deleted,clr.clr_fname,clr.clr_mname,clr.clr_lname,clr.clr_mobile,inc_amb.amb_rto_register_no as amb_rto_register_no,inc_amb.base_location_name as hp_name,colleague.clg_mobile_no,colleague.clg_first_name,colleague.clg_last_name,dist.dst_name,amb.amb_default_mobile,amb.amb_pilot_mobile,amb.amb_pilot_mobile $epr_select
                FROM $this->tbl_incidence AS inc  
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                LEFT JOIN ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )
                LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )
                LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )
                LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )
                LEFT JOIN ems_mas_call_purpose AS purpose ON ( purpose.pcode = inc.inc_type)
                LEFT JOIN ems_driver_pcr As dri_pcr ON (dri_pcr.inc_ref_id = epcr.inc_ref_id)
                LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                Where  epcr.is_validate = '1' AND inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc_amb.amb_status = 'assign'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";       
        */
        $sql = "SELECT epcr.*,dri_para.parameter_count,dri_pcr.dp_started_base_loc,dri_pcr.dp_on_scene,dri_pcr.dp_back_to_loc,inc.inc_ref_id,
                inc.inc_recive_time,inc.inc_district_id,inc.inc_type,purpose.pname,inc.inc_datetime,
                inc.inc_dispatch_time,inc.incis_deleted,
                colleague.clg_mobile_no,colleague.clg_first_name,colleague.clg_last_name,dist.dst_name,
                amb.amb_default_mobile,amb.amb_pilot_mobile,amb.amb_pilot_mobile 
                FROM ems_epcr AS epcr  
                LEFT JOIN $this->tbl_incidence AS inc ON (inc.inc_ref_id = epcr.inc_ref_id)
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = epcr.amb_reg_id )
                LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )
                LEFT JOIN ems_mas_call_purpose AS purpose ON ( purpose.pcode = inc.inc_type)
                LEFT JOIN ems_driver_pcr As dri_pcr ON (dri_pcr.inc_ref_id = epcr.inc_ref_id)
                LEFT JOIN ems_driver_parameters As dri_para ON (dri_para.incident_id = epcr.inc_ref_id)
                LEFT JOIN $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                Where  epcr.is_validate = '1' AND inc.incis_deleted = '0'   $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";       
        
        $result = $this->db->query($sql);
        //echo $this->db->last_query($result);die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function get_inc_by_rtm($args = array(), $offset = '', $limit = '', $filter = '', $sortby = array(), $incomplete_inc_amb = array()) {


        $condition = $offlim = '';
        if ($args['operator_id']) {
            $condition .= " AND inc.inc_added_by='" . $args['operator_id'] . "'";
        }
        if ($args['district_id']) {
            $condition .= " AND inc.inc_district_id='" . $args['district_id'] . "'";
        }

        if ($offset >= 0 && $limit > 0) {
           // $offlim = "limit $limit offset $offset ";
            $offlim = "limit 0,25";
        }
        if ($filter != '') {
            $order_by = "ORDER BY $filter DESC";
        } else {
            $order_by = "ORDER BY inc.inc_datetime DESC";
        }
        
        $epcr='';
        $epr_select= '';
        $sortby_sql = '';
        $condition .= "AND inc.inc_pcr_status = '0'";
      
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
        if ($sortby['reopen_id'] == "1") {
             
            $epcr = 'LEFT JOIN  ems_epcr AS epcr ON (epcr.inc_ref_id = inc.inc_ref_id )';
            $sortby_sql .= " AND epcr.is_reopen = '1' AND inc.inc_pcr_status IN ('0','1') ";

        }
        if ($sortby['inc_date'] != "") {
            $date = $sortby['inc_date'];
            $sortby_sql .= " AND inc.inc_datetime BETWEEN '$date' AND '$date 23:59:59'";
        }
        if ($sortby['inc_id'] != "") {
            $date = $sortby['inc_id'];
            $sortby_sql .= " AND inc.inc_ref_id = '" . trim($sortby['inc_id']) . "'";
        }
         if ($args['child_dco']) {
            $condition .= " AND inc.inc_added_by IN ('" . $args['child_dco'] . "')";
        }
        if ($args['system_type']) {
            $condition .= " AND inc.inc_system_type = '" . $args['system_type'] . "'";
        }
        if (isset($args['base_month']) && $args['base_month'] != '') {
            $condition.= "AND inc.inc_base_month IN ('".($args['base_month']-1)."','".$args['base_month']."')";
        }
          $sql = "SELECT inc.inc_ref_id,inc.inc_recive_time,inc.inc_district_id,inc.inc_type,purpose.pname,inc.inc_datetime,inc.inc_dispatch_time,inc.incis_deleted,clr.clr_fname,clr.clr_mname,clr.clr_lname,clr.clr_mobile,inc_amb.amb_rto_register_no as amb_rto_register_no,inc_amb.base_location_name as hp_name,colleague.clg_mobile_no,colleague.clg_first_name,colleague.clg_last_name,dist.dst_name,amb.amb_default_mobile,amb.amb_pilot_mobile,amb.amb_pilot_mobile $epr_select
                FROM $this->tbl_incidence AS inc  
                LEFT JOIN ems_incidence_ambulance as inc_amb ON ( inc.inc_ref_id = inc_amb.inc_ref_id )
                $epcr  
                LEFT JOIN ems_ambulance as amb ON ( amb.amb_rto_register_no = inc_amb.amb_rto_register_no )
                LEFT JOIN $this->tbl_colleague as colleague ON (colleague.clg_ref_id = inc.inc_added_by )
                LEFT JOIN ems_calls AS cl ON (inc.inc_cl_id = cl.cl_id )
                LEFT JOIN ems_callers AS clr ON (clr.clr_id = cl.cl_clr_id )
                LEFT JOIN  ems_mas_call_purpose AS purpose ON ( purpose.pcode = inc.inc_type)
                LEFT JOIN  $this->tbl_dist AS dist ON (dist.dst_code = inc.inc_district_id )
                Where inc.incis_deleted = '0' AND inc.inc_set_amb = '1' AND inc_amb.amb_status = 'assign'  $condition $sortby_sql GROUP BY inc.inc_ref_id $order_by  $offlim";       
        $result = $this->db->query($sql);
        // echo $this->db->last_query($result);die();
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result();
        }
    }
    function saveremarks($data)
	{
        // print_r($data);die;
        $this->db->insert('ems_rtm_remark',$data);
        return 1;
    }
    function showremarks($inc_id){
    
        $this->db->select('rem.inc_ref_id,rem.remark,rem.added_date,rem.added_by,clg.clg_first_name,clg.clg_mid_name,clg.clg_last_name');
        $this->db->from('ems_rtm_remark rem');
        $this->db->join('ems_colleague clg', 'rem.added_by = clg.clg_ref_id');
        $this->db->where("rem.inc_ref_id", $inc_id);  
        $this->db->where('DATE(rem.added_date)=CURDATE()');
        $this->db->order_by('rem.added_date', 'DESC');
        // $this->db->limit(1);
        $data = $this->db->get();
    
        $result = $data->result();
        // echo $this->db->last_query();
        return $result;

    }
 
    function get_dist_by_name($dst_name) {

        if ($dst_name) {

            $condition .=  "AND dst.dst_name='" . $dst_name . "'";
        }
            $oby = "ORDER BY dst_name ASC";

         $sql = "SELECT dst.*"
            . " FROM $this->tbl_mas_districts as dst "
            . "Where dstis_deleted = '0' $condition $oby ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_base_by_name($hp_name) {

        if ($hp_name) {

            $condition .=  "AND base.hp_name='" . $hp_name . "'";
        }
            $oby = "ORDER BY hp_name ASC";

         $sql = "SELECT base.*"
            . " FROM ems_base_location as base "
            . "Where hpis_deleted = '0' $condition $oby ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die;
        if ($result) {
            return $result->result();
        } else {
            return false;
        }
    }
    function get_caller_details($args) {
        if ($args['inc_ref_id']) {
            $condition = " AND epcr.inc_ref_id='" . $args['inc_ref_id'] . "' ";
        }

        $sql = "SELECT epcr.inc_ref_id, clr.clr_mobile"
            . " FROM $this->tbl_epcr AS epcr"
            ." LEFT JOIN ems_incidence as inc on (epcr.inc_ref_id = inc.inc_ref_id)"
            . " LEFT JOIN  ems_calls AS cls ON (inc.inc_cl_id = cls.cl_id )"
            . " LEFT JOIN ems_callers AS clr ON ( cls.cl_clr_id = clr.clr_id  )"
            . " WHERE epcris_deleted = '0'   $condition ";

        $result = $this->db->query($sql);
        // echo $this->db->last_query(); die;
        return $result->result();   
    }
}
