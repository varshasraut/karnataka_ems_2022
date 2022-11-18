<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CommonModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        $this->loginType = 'ems_app_login_type';
        $this->pastMedicalHistory = 'ems_past_medical_history';
        $this->medicine = 'ems_inventory_medicine';
        $this->loc =  'ems_mas_loc_level';
        $this->ptnNotComToHospReason = 'ems_patient_notcomtohosp_reason';
        $this->interventions = 'ems_interventions';
        $this->patientstatus = "ems_patient_status";
        $this->patientAvaOrNot = 'ems_patient_not_ava_reason';
        $this->patientHandoverIssueList = 'ems_app_patient_handover_issues';
        $this->providerImpression = 'ems_mas_provider_imp';
        $this->chiefComplaint = 'ems_mas_patient_complaint_types';
        $this->latlong = 'ems_latlong';
    }
    public function getLoginType(){
        return $this->db->get($this->loginType)->result_array();
    }
    public function getPastMedicalHistory(){
        $data =  $this->db->where('deleted','0')->get($this->pastMedicalHistory)->result_array();
        $pastHistory = array();
        foreach($data as $data1){
            $pastHistory1 = array(
                'id' => (int) $data1['id'],
                'name' => $data1['name']
            );
            array_push($pastHistory,$pastHistory1);
        }
        return $pastHistory;
    } 
    public function insertPastMedicalHis($pastMed){
        foreach($pastMed as $pastMed1){
            $this->db->insert($this->pastMedicalHistory,$pastMed1);
        }
        return 1;
    }
    public function getMedicine(){
        $data =  $this->db->where('med_type','amb')->where('med_status','1')->where('medis_deleted','0')->get($this->medicine)->result_array();
        $medicine = array();
        foreach($data as $data1){
            $medicine1 = array(
                'id' => (int) $data1['med_id'],
                'name' => $data1['med_title']
            );
            array_push($medicine,$medicine1);
        }
        return $medicine;
    }
    public function insertMedicine($pastMed){
        foreach($pastMed as $pastMed1){
            $this->db->insert($this->medicine,$pastMed1);
        }
        return 1;
    }
    public function getLocList(){
        $this->db->select('level_id,level_type');
        $this->db->from($this->loc);
        $this->db->where('levelis_deleted','0');
        $loc = $this->db->get()->result_array();
        $data = array();
        foreach($loc as $loc1){
            $data1 = array(
                'id' => $loc1['level_id'],
                'name' => $loc1['level_type']
            );
            array_push($data,$data1);
        }
        return $data;
    }
    public function getPtnNotComToHospReason(){
        return $this->db->where('deleted','0')->get($this->ptnNotComToHospReason)->result_array();
    }
    public function getInterventions(){
        $this->db->select('*');
        $this->db->where('deleted','0');
        $this->db->from($this->interventions);
        $var = $this->db->get()->result_array();
        $interventions = array();
        foreach($var as $itr){
            $interventions1 = array(
                'id' => (int) $itr['id'],
                'name' => $itr['name']
            );
        array_push($interventions,$interventions1);
        }
        return $interventions;
    }
    public function getPatientStatus(){
        return $this->db->where('deleted','0')->get($this->patientstatus)->result_array();
    }
    public function getPatientAvaOrNot(){
        $this->db->select('*');
        $this->db->from($this->patientAvaOrNot);
        $data = $this->db->get()->result_array();
        $reason = array();
        foreach($data as $reas){
            $reason1 = array(
                'id' => (int) $reas['id'],
                'name' => $reas['reason']
            );
            array_push($reason,$reason1);
        }
        return $reason;
    }
    public function PatientHandoverIssuesList(){
        $this->db->select('id,name');
        $this->db->from($this->patientHandoverIssueList);
        $this->db->where('deleted','0');
        $issues = $this->db->get()->result_array();
        return $issues;
    }
    public function PatientProviderImpression(){
        $this->db->select('*');
        $this->db->from($this->providerImpression);
        $this->db->where('pro_status','1');
        $this->db->where('prois_deleted','0');
        $data2 = $this->db->get()->result_array();
        $ip = array();
        foreach($data2 as $imp){
            $impression = array(
                'id' => $imp['pro_id'],
                'name' => $imp['pro_name']
            );
            array_push($ip,$impression);
        }
        return $ip;
    }
    public function getChiefComplaint(){
        $chief = "SELECT cheif.ct_id as `id`, cheif.ct_type as `name` FROM $this->chiefComplaint AS cheif "
                ."WHERE cheif.ctis_deleted = '0' AND cheif.ct_status = '1' ";
        $data = $this->db->query($chief)->result_array();
        $a = array();
        foreach($data as $data1){
            $a1 = array(
                'id' => (int) $data1['id'],
                'name' => $data1['name']
            );
            array_push($a,$a1);
        }
        return $a;
    }
    public function insertLatLong($data){
        $this->db->insert($this->latlong,$data);
        return 1;
    }
}
?>