<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getAllUsrData($data){
        if($data['mobile'] != ''){
            $this->db->select('*');
            $this->db->from('ems_comu_app_user_reg');
            $this->db->where('mobile',$data['mobile']);
            $this->db->where('usr_acc_activation','0');
            $query = $this->db->get();
            if ($query->num_rows() > 0 )
            {
                return $query->result_array();
            }
        }
    }
    public function getUsrData($data){
        if($data['mobile'] != ''){
            $this->db->select('reg.usr_id,reg.f_name,reg.l_name,reg.age,reg.age_grp,reg.blood_grp,reg.email,reg.mobile,reg.gender,reg.user_ayushman_id,reg.address,blood.bldgrp_name');
            $this->db->from('ems_comu_app_user_reg reg');
            $this->db->join('ems_mas_bloodgrp_type blood',"reg.blood_grp = blood.bldgrp_id","left");
            $this->db->where('reg.mobile',$data['mobile']);
            $this->db->where('reg.usr_acc_activation','0');
            $query = $this->db->get();
            if ($query->num_rows() > 0 )
            {
                return $query->result_array();
            }
        }
    }
    public function getUserLogs($mobile1){
        $this->db->select('*');
        $this->db->from('ems_comu_app_call_details');
        $this->db->where('mobile_no',$mobile1);
        $this->db->order_by("added_date", "DESC");
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    public function getbloodgrp(){
        $this->db->select('*');
        $this->db->from('ems_mas_bloodgrp_type');
        $this->db->where('bldgrp_deleted','0');
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    public function updateuserdeatils($mobile,$updateData){
        $this->db->where('mobile',$mobile);
        $this->db->where('usr_acc_activation','0');
        $this->db->update('ems_comu_app_user_reg',$updateData);
        return 1;
    }
    public function getcalltype(){
        $data = "SELECT pid,pname,pcode FROM ems_mas_call_purpose WHERE pid IN (2, 18, 46)";
        return $this->db->query($data)->result_array();
    }
    public function getchiefcomplaint($callType){
        if($callType == 'EMG'){
            $call_type = '';
        }else if($callType == 'IN_HO_P_TR'){
            $call_type = '';
        }else{
            $call_type = $callType;
        }
        // echo $call_type;die;
        $this->db->select('ct_id as chfId,ct_type as chfName');
        $this->db->from('ems_mas_patient_complaint_types');
        $this->db->where('ct_call_type',$call_type);
        $this->db->where('ctis_deleted','0');
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    public function getnearbloodbank($data){
        $lat = $data['lat'];
        $lng = $data['lng'];
        $data = "SELECT *, ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( bld_lat ) ) * cos( radians( bld_long ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( bld_lat ) ) ) ) AS distance FROM ems_mas_blood_bank HAVING distance < 10 ORDER BY distance ASC LIMIT 0 , 10";
        return $this->db->query($data)->result_array();
    }
    public function gethospitaltype(){
        $this->db->select('hosp_id,full_name');
        $this->db->from('ems_mas_hospital_type');
        $this->db->where('hospis_deleted','0');
        $this->db->where_in('hosp_id',[1,2,15]);
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    public function gethospitallist($hospitalType,$data){
        $lat = $data['lat'];
        $lng = $data['lng'];
        if($hospitalType == 1){
            $hosp = '1,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23';
        }elseif($hospitalType == 15){
            $hosp = '15';
        }else{
            $hosp = '2';
        }
        $data = "SELECT *, ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( hp_lat ) ) * cos( radians( hp_long ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( hp_lat ) ) ) ) AS distance "
                ."FROM ems_hospital WHERE hp_type IN ($hosp) AND hpis_deleted = '0'  HAVING distance < 10 "
                ."ORDER BY distance ASC LIMIT 0 , 10";
        return $this->db->query($data)->result_array();
        // $this->db->select('hp_id,hp_name');
        // $this->db->from('ems_hospital');
        // $this->db->where('hpis_deleted','0');
        // $this->db->where('hp_type',"$hospitalType");
        // $query = $this->db->get();
        // if ($query->num_rows() > 0 )
        // {
        //     return $query->result_array();
        // }
    }
    public function getnearhospital($data){
        $lat = $data['lat'];
        $lng = $data['lng'];
        if($data['hospitalType'] == 1){
            $hosp = '1,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17';
        }else{
            $hosp = '2';
        }
        $data = "SELECT *, ( 3959 * acos( cos( radians( $lat ) ) * cos( radians( hp_lat ) ) * cos( radians( hp_long ) - radians( $lng ) ) + sin( radians( $lat ) ) * sin( radians( hp_lat ) ) ) ) AS distance FROM ems_hospital "
                ."WHERE hp_type IN ($hosp) AND hpis_deleted = '0' HAVING distance < 10 "
                ."ORDER BY distance ASC LIMIT 0 , 10 ";
        return $this->db->query($data)->result_array();
    }
    public function getmaplink($mobile){
        $this->db->select('*');
        $this->db->from('ems_incident_tracklink');
        $this->db->where('mobile_no',$mobile);
        $this->db->order_by("added_date", "ASC");
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
}