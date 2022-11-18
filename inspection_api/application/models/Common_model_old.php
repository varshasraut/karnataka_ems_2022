<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Common_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
    /* get data from ems_inventory_medicine table */
    function getmedicine($medTypeId){
        $this->db->select('med_id,med_title,exp_stock');
        $this->db->from('ems_inspection_medicine');
        $this->db->where('medis_deleted', '0');
        $this->db->where('title_id', $medTypeId);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    /* get data from ems_inventory_medicine table */
    function getequipment($id){
        $this->db->select('eqp_id,eqp_name');
        $this->db->from('ems_inventory_equipment');
        $this->db->where('eqpis_deleted', '0');
        $this->db->where('eqp_status', '1');
        $this->db->where('eqp_cat', $id);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getdistrict($dst_state){
        $this->db->select('dst_code,dst_name,dst_state');
        $this->db->from('ems_mas_districts');
        $this->db->where('dstis_deleted', '0');
        $this->db->where('dst_status', '1');
        $this->db->where('dst_state', $dst_state);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getambulance($dst_code){
        $this->db->select('amb_id,amb_rto_register_no');
        $this->db->from('ems_ambulance');
        $this->db->where('ambis_deleted', '0');
        $this->db->where('amb_district', $dst_code);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getemso(){
        $this->db->select('clg_id,clg_ref_id,clg_first_name,clg_mid_name,clg_last_name');
        $this->db->from('ems_colleague');
        $this->db->where('clg_is_deleted', '0');
        $this->db->where('clg_is_active', '1');
        $this->db->where('clg_group', 'UG-EMT');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getpilot(){
        $this->db->select('clg_id,clg_ref_id,clg_first_name,clg_mid_name,clg_last_name');
        $this->db->from('ems_colleague');
        $this->db->where('clg_is_deleted', '0');
        $this->db->where('clg_is_active', '1');
        $this->db->where('clg_group', 'UG-Pilot');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getgrievancetype(){
        $this->db->select('grievance_id,grievance_type');
        $this->db->from('ems_mas_grievance_type');
        $this->db->where('grievance_isdeleted', '0');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getgrievancerelatedto($grievanceId){
        $this->db->select('g_id,grievance_sub_type');
        $this->db->from('ems_mas_grievance_sub_type');
        $this->db->where('g_isdeleted', '0');
        $this->db->where('grievance_id', $grievanceId);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getenableloginbtn(){
        $this->db->select('lgbtn_id,lgbtn_code,lgbtn_permission');
        $this->db->from('ems_insp_app_enable_btn_permission');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    function getinspectioncompleted($username){
        // $this->db->select('id,ins_amb_no');
        // $this->db->from('ems_inspection_audit_details');
        // $this->db->where('forword_grievance != ', null);
        $this->db->select('insp.id as inspUnqId,insp.ins_amb_no as vehicleNumber,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.added_date as date,insp.ins_baselocation as baseLoc');
        $this->db->from('ems_inspection_audit_details as insp');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '2');
		$this->db->where('insp.added_by', $username);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        if ( $query->num_rows() > 0 )
        {
            return $query->num_rows();
        }
    }
    function getinspectioninprogress($username){
        // $this->db->select('id,ins_amb_no');
        // $this->db->from('ems_inspection_audit_details');
        // $this->db->where('forword_grievance = ', "");
        $this->db->select('insp.id as inspUnqId,insp.ins_amb_no as vehicleNumber,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.added_date as date,insp.ins_baselocation as baseLoc');
        $this->db->from('ems_inspection_audit_details as insp');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '1');
		$this->db->where('insp.added_by', $username);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->num_rows();
        }
    }
    function getdistid($username){
        $this->db->select('clg_ref_id,clg_district_id');
        $this->db->from('ems_colleague');
        $this->db->where('clg_ref_id',$username);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    function getColorCodeInspForm($inspUnqId){
        $this->db->select('*');
        $this->db->from('ems_insp_app_form_color_status');
        $this->db->where('form_color_insp_id',$inspUnqId);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    } 
    function getgrivinprogress($username){
        $this->db->select('insp.id as inspectionId,insp.ins_amb_no as vehicleNumber,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.added_date as date,insp.ins_baselocation as baseLoc');
        $this->db->from('ems_inspection_audit_details as insp');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '2');
        $this->db->where('insp.gri_status', '0');
		$this->db->where('insp.added_by', $username);
        $this->db->where('insp.forword_grievance', '2');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->num_rows();
        }
    }
    function getgrivcompleted($username){
        $this->db->select('gri.id as grivId,gri.amb_no as vehicleNumber,gri.added_date as gridate,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.ins_baselocation as baseLoc,dis.dst_name as disName');
        $this->db->from('ems_ins_gri_audit_details as gri');
		$this->db->join('ems_inspection_audit_details as insp','gri.ins_id = insp.id','left');
        $this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
		$this->db->where('gri.status', '0');
        $this->db->where('gri.added_by', $username);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->num_rows();
        }
    }
}
