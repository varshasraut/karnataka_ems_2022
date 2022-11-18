<?php
class Hpcl_model_api extends CI_Model {

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
        $this->tbl_hpcl_data = $this->db->dbprefix('hpcl_data');
      
    }
    
  function hpcl_data_insert($args = array()) {



            $result = $this->db->insert($this->tbl_hpcl_data, $args);
           // echo $this->db->last_query();die;
            if ($result) {
    
                return $result;
            } else {
    
                return false;
            }
            die();
    }
    function get_hpcl_amb_details($args = array()){
        if ($args['hpcl_amb'] != '') {
            $hpcl_amb = str_replace(' ', '', $args['hpcl_amb']);
           // $hpcl_amb = trim($args['hpcl_amb'],' ');
            $condition .= " AND hpcl.VehicleNoUserName = '" . $hpcl_amb . "' ";
        } 
        if ($args['from_date'] != '' && $args['to_date'] != '') {
            $from = $args['from_date'];
            $to = $args['to_date'];
            $condition .= " AND hpcl.TransactionDate BETWEEN '$from' AND '$to 23:59:59'";
        }
        $sql = "SELECT hpcl.* FROM $this->tbl_hpcl_data AS hpcl "
           // . " LEFT JOIN $this->tbl_amb AS amb ON (hpcl.VehicleNoUserName = amb.amb_rto_register_no )"
            . " Where 1=1 $condition ";

        $result = $this->db->query($sql);
       //  echo $this->db->last_query($result);die;
        if ($args['get_count']) {
            return $result->num_rows();
        } else {
            return $result->result_array();
        }
    }
    
    
}
?>