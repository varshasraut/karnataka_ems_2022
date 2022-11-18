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
        $this->ambulance = 'ems_ambulance';
        $this->user = 'ems_colleague';
        $this->indentRequest = 'ems_indent_request';
        $this->district = 'ems_mas_districts';
        $this->hospital = 'ems_hospital';
        $this->equipment = 'ems_inventory_equipment';
        $this->paymentMode = 'ems_mas_app_payment_mode';
        $this->cylinderType = 'ems_mas_app_cylinder_type';
        $this->remark = 'ems_app_ambstock_remark';
        $this->oxyFilling = 'ems_fleet_oxygen_filling'; 
        $this->fuelFilling = 'ems_fleet_fuel_filling';
        $this->closure = 'ems_ambulance_timestamp_record';
        $this->obviousDeathQueAns = 'ems_obvious_death_ques_summary';
        $this->obviousDeathQue = 'ems_obvious_death_questions';
        $this->tyretype = 'ems_mas_tyre_type';
        $this->accidentalType = 'ems_mas_accidental_maintenance_type';
        $this->workstation = 'ems_work_station';
        $this->breakdownType = 'ems_mas_breakdown_type';
        $this->mcinature = 'ems_mas_micnature';
        $this->incidence = 'ems_incidence';
    }
    public function baseMonth(){
        $date = date('Y-d-m');
        $baseMonth = "SELECT period_diff( date_format( CURRENT_DATE , '%Y%m' ) , date_format('2008-01-01' , '%Y%m' ) ) AS months";
        return $this->db->query($baseMonth)->result_array();
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
    public function getChiefComplaint($incidentId){
        if(!empty($incidentId)){
            $incidenceRec = $this->db->where('inc_ref_id',$incidentId)->get($this->incidence)->result_array();
            $a = array();
            if(!empty($incidenceRec)){
                if($incidenceRec[0]['inc_type'] == "MCI"){
                    $chief1 = "SELECT mci.ntr_id as `id`, mci.ntr_nature as `name` FROM $this->mcinature AS mci "
                    ."WHERE mci.ntris_deleted = '0' AND mci.ntr_status = '1' ";
                    $data = $this->db->query($chief1)->result_array();
                    foreach($data as $data1){
                        $a1 = array(
                            'id' => (int) $data1['id'],
                            'name' => $data1['name']
                        );
                        array_push($a,$a1);
                    }
                }else{
                    $chief = "SELECT cheif.ct_id as `id`, cheif.ct_type as `name` FROM $this->chiefComplaint AS cheif "
                    ."WHERE cheif.ctis_deleted = '0' AND cheif.ct_status = '1' ";
                    $data = $this->db->query($chief)->result_array();
                    foreach($data as $data1){
                        $a1 = array(
                            'id' => (int) $data1['id'],
                            'name' => $data1['name']
                        );
                        array_push($a,$a1);
                    }
                }
            }
            return $a;
        }else{
            $chief = "SELECT cheif.ct_id as `id`, cheif.ct_type as `name` FROM $this->chiefComplaint AS cheif "
                    ."WHERE cheif.ctis_deleted = '0' AND cheif.ct_status = '1' ";
            $chief1 = "SELECT mci.ntr_id as `id`, mci.ntr_nature as `name` FROM $this->mcinature AS mci "
                    ."WHERE mci.ntris_deleted = '0' AND mci.ntr_status = '1' ";
            $data = $this->db->query($chief)->result_array();
            $data2 = $this->db->query($chief1)->result_array();
            $a = array();
            foreach($data as $data1){
                $a1 = array(
                    'id' => (int) $data1['id'],
                    'name' => $data1['name']
                );
                array_push($a,$a1);
            }
            $b = array();
            foreach($data2 as $data3){
                $b1 = array(
                    'id' => (int) $data3['id'],
                    'name' => $data3['name']
                );
                array_push($b,$b1);
            }
            return array_merge($a,$b);
        }
    }
    public function insertLatLong($data){
        $this->db->insert($this->latlong,$data);
        return 1;
    }
    public function loginvisibility(){
        $this->db->select('id,name,visibility');
        $this->db->from('ems_app_loginvisibility');
        $this->db->where('type_delete','0');
        $data = $this->db->get()->result_array();
        return $data;
    }
    public function getAmbulanceRec($ambulanceNo){
        $data = "SELECT amb.*,dist.dst_name,hosp.hp_name"
                ." FROM $this->ambulance as amb"
                ." LEFT JOIN $this->district as dist ON (amb.amb_district = dist.dst_code AND amb.amb_state = dist.dst_state)"
                ." LEFT JOIN $this->hospital as hosp ON (amb.amb_base_location = hosp.hp_id)"
                ." WHERE amb.amb_rto_register_no = '$ambulanceNo' ";
        return $this->db->query($data)->result_array();
    }
    public function getEquipment(){
        return $this->db->where('eqp_type','amb')->where('eqpis_deleted','0')->where('eqp_status','1')->get($this->equipment)->result_array();
    }
    public function getPayementMode(){
        return $this->db->where('is_deleted','0')->get($this->paymentMode)->result_array();
    }
    public function getCylinderType(){
       return $this->db->where('is_deleted','0')->get($this->cylinderType)->result_array();
    }    
    public function getRemark($remarkType){
       $data = "SELECT * FROM $this->remark where $remarkType IN (type_value)";
       return $this->db->query($data)->result_array();
        //   return $this->db->where('type_value',$remarkType)->get($this->remark)->result_array();
    }
    public function getStartOdometer($odometerType,$ambulanceno){
       if($odometerType == 1){
            $this->db->select('*');
            $this->db->from($this->oxyFilling);
            $this->db->where('of_amb_ref_no',$ambulanceno);
            $this->db->where('of_end_odometer != ','');
            $odometer = $this->db->get()->result_array();
            if(empty($odometer)){
               return $this->chkOdometerInTymStamprec($odometer,$ambulanceno);
            }else{
                $this->db->select('*');
                $this->db->from($this->oxyFilling);
                $this->db->where('of_amb_ref_no',$ambulanceno);
                $this->db->where('of_end_odometer != ','');
                $end = $this->db->get()->result_array();
                $odometers = array();
                foreach($end as $time){
                    $odometer = array(
                        'id' => $time['of_id'],
                        'endOdometer' => $time['of_end_odometer']
                    );
                    array_push($odometers,$odometer);
                }
                $arr = end($odometers);
                return $arr;
            }
       }else if($odometerType == 2){
            $this->db->select('*');
            $this->db->from($this->fuelFilling);
            $this->db->where('ff_amb_ref_no',$ambulanceno);
            $this->db->where('ff_end_odometer != ','');
            $odometer = $this->db->get()->result_array();
            if(empty($odometer)){
               return $this->chkOdometerInTymStamprec($odometer,$ambulanceno);
            }else{
                $this->db->select('*');
                $this->db->from($this->fuelFilling);
                $this->db->where('ff_amb_ref_no',$ambulanceno);
                $this->db->where('ff_end_odometer != ','');
                $end = $this->db->get()->result_array();
                $odometers = array();
                foreach($end as $time){
                    $odometer = array(
                        'id' => $time['ff_id'],
                        'endOdometer' => $time['ff_end_odometer'] == '' ? $time['ff_in_odometer'] : $time['ff_end_odometer']
                    );
                    array_push($odometers,$odometer);
                }
                $arr = end($odometers);
                return $arr;
            }
       }
    }
    public function chkOdometerInTymStamprec($odometer,$ambulanceno){
        $this->db->select('*');
        $this->db->from($this->closure);
        $this->db->where('amb_rto_register_no',$ambulanceno);
        $this->db->where('end_odmeter != ','');
        $this->db->where('flag','1');
        $end = $this->db->get()->result_array();
        if(empty($end)){
            $odometers = array(
                'id' => 0,
                'endOdometer' => 0
            );
            return $odometers;
        }else{
            $odometers = array();
            foreach($end as $time){
                $odometer = array(
                    'id' => $time['id'],
                    'endOdometer' => $time['end_odmeter']
                );
                array_push($odometers,$odometer);
            }
            $arr = end($odometers);
            return $arr;
        }
    }
    public function getAmbStatusOxyFuel($typeValue,$ambulanceno){
            $this->db->select('amb_status_oxy,amb_status_fuel');
            $this->db->from($this->ambulance);
            $this->db->where('amb_rto_register_no',$ambulanceno);
            $oxyStatus = $this->db->get()->result_array();
            if($typeValue == 1){
                if($oxyStatus[0]['amb_status_oxy'] == 0 || $oxyStatus[0]['amb_status_oxy'] == 1){
                    return $status = array(
                            'code' => 1,
                            'message' => 'Add New Record'
                        );
                }else{
                    return $status = array(
                            'code' => 2,
                            'message' => 'Update Record'
                        );
                }
            }else{
                if($oxyStatus[0]['amb_status_fuel'] == 0 || $oxyStatus[0]['amb_status_fuel'] == 1){
                    return $status = array(
                            'code' => 1,
                            'message' => 'Add New Record'
                        );
                }else{
                    return $status = array(
                            'code' => 2,
                            'message' => 'Update Record'
                        );
                }
            }
    }
    public function getObviusDeath($patientId,$incidentId){
        $obviousDeath =  $this->db->get($this->obviousDeathQue)->result_array();
        $a1 = array();
        foreach($obviousDeath as $obviousDeath1){
            $a = array(
                'id' => (int) $obviousDeath1['id'],
                'name' => $obviousDeath1['questions'],
                'selected' => null
            );
            array_push($a1,$a);
        }
        $data = "SELECT *"
            . "FROM $this->obviousDeathQueAns as queans "
            . "LEFT JOIN $this->obviousDeathQue as ques ON (ques.id = queans.sum_que_id) "
            . "WHERE queans.inc_ref_id = '$incidentId' AND  queans.ptn_id = $patientId ";
        $data1 = $this->db->query($data)->result_array();
        // print_r($data1);
        $list = array();
        foreach($data1 as $data2){
            $data3 = array(
                'id' => (int) $data2['id'],
                'name' => $data2['questions'],
                'selected' => $data2['sum_que_ans'] == 'yes' ? true : false
            );
            array_push($list,$data3);
        }
        $tmpArray = array();
        foreach($a1 as $data1) {
        
          $duplicate = false;
          foreach($list as $data2) {
            if($data1['id'] == $data2['id']) $duplicate = true;
          }
        
          if($duplicate == false) $tmpArray[] = $data1;
        }
        $obviousList = array_merge($list,$tmpArray);
        $obviousList1 = array_multisort($obviousList,SORT_ASC);
        return $obviousList;
    }
    public function getAmbulanceStatus($vehicleNumber){
        // return $this->db->where('amb_rto_register_no',$vehicleNumber)->get($this->ambulance)->result_array();
        $this->db->select('*');
        $this->db->from('ems_ambulance amb');
        $this->db->join('ems_incidence_ambulance incamb', 'amb.amb_rto_register_no = incamb.amb_rto_register_no', 'left');
        $this->db->join('ems_incidence inc', 'incamb.inc_ref_id = inc.inc_ref_id', 'left');
        $this->db->where('amb.amb_rto_register_no', $vehicleNumber);
        //$this->db->where('inc.accept_incident_id', 'accepted');
        $this->db->where('inc.inc_pcr_status', '0');
        $data = $this->db->get()->result_array();
        if(empty($data)){
            return $this->db->where('amb_rto_register_no',$vehicleNumber)->get($this->ambulance)->result_array();
        }else{
            return $data;
        }
    }
    public function getTyreType(){
       return $this->db->get($this->tyretype)->result_array();
    }
    public function getInformedTo(){
        $data = "SELECT * FROM ems_mas_groups AS parent LEFT JOIN ems_mas_groups AS child ON child.gcode = parent.gparent WHERE parent.gparent != '' GROUP BY parent.gparent";
        return $this->db->query($data)->result_array();
    }
    public function getAccidentalType(){
        $this->db->select('id,name');
        $this->db->from($this->accidentalType);
        $this->db->where('isdeleted','0');
        return $this->db->get()->result_array();
    }
    public function getWorkStation($ambulanceno){
       // $data = "SELECT * FROM $this->ambulance as amb "
        //   ."LEFT JOIN $this->workstation as work ON (amb.amb_state = work.ws_state_code) 
         //  AND (amb.amb_district = work.ws_district_code)";
        $data = "SELECT * FROM ems_work_station";
            //$data ="SELECT * FROM ems_work_station as work LEFT JOIN ems_mas_states as state ON ( state.st_code = work.ws_state_code ) 
            // LEFT JOIN ems_mas_districts as district ON ( district.dst_code = work.ws_district_code )
            // where work.ws_is_deleted='0' AND work.ws_is_active = '0' AND (work.ws_station_name LIKE '%%')";

        return $this->db->query($data)->result_array();
    }
    public function getBreakdownType(){
        $this->db->select('id,name');
        $this->db->from( $this->breakdownType);
        $this->db->where('isdeleted','0');
        return $this->db->get()->result_array();
    }
}
?>