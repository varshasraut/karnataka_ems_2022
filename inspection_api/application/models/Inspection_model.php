<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Inspection_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	public function getambdetails($vehicleNumber){
		$this->db->select('amb.amb_id,amb.vehical_make_type,amb.amb_state,amb.amb_district,amb.amb_type,bsloc.hp_name');
        $this->db->from('ems_ambulance as amb');
		$this->db->join('ems_hospital as bsloc','amb.amb_base_location = bsloc.hp_id','left');
		$this->db->where('amb.amb_rto_register_no',$vehicleNumber);
        $query = $this->db->get()->result_array();
		// print_r($this->db->last_query());
		return $query;
	}
	public function addinspectionfirstform($insp){
		$this->db->insert('ems_inspection_audit_details',$insp);
		return $this->db->insert_id();
	}
	public function addinspfirstformlatlng($latlong){
		$this->db->insert('ems_insp_app_latlong',$latlong);
		return 1;
	}
	public function check_insp_inpro($vehicleNumber){
		$this->db->select('id,ins_amb_no,ins_app_status');
        $this->db->from('ems_inspection_audit_details');
        $this->db->where('is_deleted', '1');
        $this->db->where('ins_app_status', '1');
		$this->db->where('ins_amb_no',$vehicleNumber);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function insertInspSecForm($data,$inspUnqId){
		$this->db->where('id',$inspUnqId)->update('ems_inspection_audit_details',$data);
	}
	public function insertInspSecFormFile($img,$inspUnqId,$formNo){
		$form_no = $img['form_no'];
		$inspUploadFileChk = $this->db->where('insp_id',$inspUnqId)->where('form_no',$form_no)->get('ems_insp_upload_file')->result_array();
		if(!empty($inspUploadFileChk)){
			$img['upload_img_path'] = $img['upload_img_path'];
			$this->db->where('insp_id',$inspUnqId)->where('form_no',$formNo)->update('ems_insp_upload_file',$img);
		}else{
			$img['form_no'] = $img['form_no'];
			$img['upload_img_path'] = $img['upload_img_path'];
			$img['insp_id'] = $inspUnqId;
			$this->db->insert('ems_insp_upload_file',$img);
		}
	}
	public function insertInspSecFormVideoFile($video,$inspUnqId,$formNo){
		$form_no = $video['form_no'];
		$inspUploadFileChk = $this->db->where('insp_id',$inspUnqId)->where('form_no',$form_no)->get('ems_insp_upload_file')->result_array();
		if(!empty($inspUploadFileChk)){
			$video1['upload_video_path'] = $video['upload_video_path'];
			$this->db->where('insp_id',$inspUnqId)->where('form_no',$formNo)->update('ems_insp_upload_file',$video1);
		}else{
			$video1['form_no'] = $video['form_no'];
			$video1['upload_video_path'] = $video['upload_video_path'];
			$video1['insp_id'] = $inspUnqId;
			$this->db->insert('ems_insp_upload_file',$video1);
		}
	}
	public function checkInspIdExist($inspUnqId){
		return $this->db->where('id',$inspUnqId)->get('ems_inspection_audit_details')->result_array();
	}
	public function getEditInspFormMainVeh($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.ins_amb_no,insp.ins_main_date,insp.ins_main_due_status,insp.ins_main_status,insp.ins_main_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormCleanAmb($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.ins_clean_date,insp.ins_clean_remark,insp.ins_clean_status,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormAC($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.ac_status,insp.ac_working_date,insp.ac_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormTyre($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.tyre_status,insp.tyre_working_date,insp.tyre_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormSiren($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.siren_status,insp.siren_working_date,insp.siren_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormInventory($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.inv_status,insp.inv_working_date,insp.inv_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormBattery($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.batt_status,insp.batt_working_date,insp.batt_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormGPS($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.gps_status,insp.gps_working_date,insp.gps_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormPCRReg($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.ins_pcs_stock_status,insp.ins_pcs_stock_date,insp.ins_pcs_stock_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getEditInspFormSigAtndSheet($inspUnqId,$formNo){
		$this->db->select('insp.id,insp.ins_sign_attnd_date,insp.ins_sign_attnd_due_status,insp.ins_sign_attnd_status,insp.ins_sign_attnd_remark,file.upload_img_path,file.upload_video_path');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_insp_upload_file as file','insp.id = file.insp_id AND file.form_no = '.$formNo.'','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id',$inspUnqId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getlistofinspection($username){
		$this->db->select('insp.id as inspUnqId,insp.ins_amb_no as vehicleNumber,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.added_date as date,insp.ins_baselocation as baseLoc,dis.dst_name as disName');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '2');
		$this->db->where('insp.added_by', $username);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getdetailslistofinspection($inspUnqId){
		$this->db->select('insp.*,dis.dst_name,eqp_minor_remark,eqp_major_remark,eqp_critical_remark,med_Remark,tab_med_Remark,cons_med_Remark');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '1');
		$this->db->where('insp.id', $inspUnqId);
        $query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getdetailslistofinspectionview($inspUnqId){
		$this->db->select('insp.*,dis.dst_name,eqp_minor_remark,eqp_major_remark,eqp_critical_remark,med_Remark,tab_med_Remark,cons_med_Remark');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '2');
		$this->db->where('insp.id', $inspUnqId);
        $query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getlistofincompinspection($username){
		$this->db->select('insp.id as inspUnqId,insp.ins_amb_no as vehicleNumber,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.added_date as date,insp.ins_baselocation as baseLoc,dis.dst_name as disName');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '1');
		$this->db->where('insp.added_by', $username);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getMedListAsPerInspId($inspUnqId,$medTypeId){
		if($medTypeId == 1){
			$this->db->select('insp.med_Injectables as medList');
			$this->db->from('ems_inspection_audit_details as insp');
			$this->db->where('insp.is_deleted', '1');
			$this->db->where('insp.ins_app_status', '1');
			$this->db->where('insp.id', $inspUnqId);
			$query = $this->db->get();
		}else if($medTypeId == 2){
			$this->db->select('insp.id as inspUnqId,insp.med_Tablets as medList');
			$this->db->from('ems_inspection_audit_details as insp');
			$this->db->where('insp.is_deleted', '1');
			$this->db->where('insp.ins_app_status', '1');
			$this->db->where('insp.id', $inspUnqId);
			$query = $this->db->get();
		}else{
			$this->db->select('insp.id as inspUnqId,insp.med_Consumables as medList');
			$this->db->from('ems_inspection_audit_details as insp');
			$this->db->where('insp.is_deleted', '1');
			$this->db->where('insp.ins_app_status', '1');
			$this->db->where('insp.id', $inspUnqId);
			$query = $this->db->get();
		}
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function insertInspEqup($eqp,$inspUnqId){
		$this->db->where('id',$inspUnqId)->update('ems_inspection_audit_details',$eqp);
	}
	public function checkInspId($inspUnqId){
		return $this->db->where('id',$inspUnqId)->get('ems_inspection_audit_details')->result_array();
	}
	public function getEqpListAsPerInspId($inspUnqId,$medTypeId){
		if($medTypeId == '1'){
			$this->db->select('insp.id as inspUnqId,insp.eqp_minor as eqpList');
			$this->db->from('ems_inspection_audit_details as insp');
			$this->db->where('insp.is_deleted', '1');
			$this->db->where('insp.ins_app_status', '1');
			$this->db->where('insp.id', $inspUnqId);
			$query = $this->db->get();
		}else if($medTypeId == '2'){
			$this->db->select('insp.id as inspUnqId,insp.eqp_major as eqpList');
			$this->db->from('ems_inspection_audit_details as insp');
			$this->db->where('insp.is_deleted', '1');
			$this->db->where('insp.ins_app_status', '1');
			$this->db->where('insp.id', $inspUnqId);
			$query = $this->db->get();
		}else{
			$this->db->select('insp.id as inspUnqId,insp.eqp_critical as eqpList');
			$this->db->from('ems_inspection_audit_details as insp');
			$this->db->where('insp.is_deleted', '1');
			$this->db->where('insp.ins_app_status', '1');
			$this->db->where('insp.id', $inspUnqId);
			$query = $this->db->get();
		}
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function getMainOfVehImg($inspUnqId,$formNo){
		return $this->db->where('insp_id',$inspUnqId)->where('form_no',$formNo)->order_by('upload_id','desc')->limit(1)->get('ems_insp_upload_file')->result_array();
	}
	public function insertForwToGriv($inspUnqId,$insp){
		$this->db->where('id',$inspUnqId)->update('ems_inspection_audit_details',$insp);
		return 1;
	}
	public function getMedEqpRec($inspUnqId){
		$this->db->select('insp.id as inspUnqId,insp.eqp_critical,insp.eqp_major,insp.eqp_minor,insp.med_Consumables,insp.med_Tablets,insp.med_Injectables');
		$this->db->from('ems_inspection_audit_details as insp');
		$this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.id', $inspUnqId);
		$query = $this->db->get();
		if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function insertMedInj($med){
		$rec = $this->db->where('ins_id',$med['ins_id'])->where('med_id',$med['med_id'])->get('ems_inspection_audit_med_details')->result_array();
		if(!empty($rec)){
			$update['med_status'] = $med['med_status'];
			$update['med_qty'] = $med['med_qty'];
			$update['med_type'] = $med['med_type'];
			$this->db->where('ins_id',$med['ins_id'])->where('med_id',$med['med_id'])->update('ems_inspection_audit_med_details',$update);
		}else{
			$this->db->insert('ems_inspection_audit_med_details',$med);
		}
	}
	public function insertEqup($equp){
		$rec = $this->db->where('ins_id',$equp['ins_id'])->where('eqp_id',$equp['eqp_id'])->get('ems_inspection_audit_equp_details')->result_array();
		if(!empty($rec)){
			$update['status'] = $equp['status'];
			$update['oprational'] = $equp['oprational'];
			$update['date_from'] = $equp['date_from'];
			$update['type'] = $equp['type'];
			$this->db->where('ins_id',$equp['ins_id'])->where('eqp_id',$equp['eqp_id'])->update('ems_inspection_audit_equp_details',$update);
		}else{
			$this->db->insert('ems_inspection_audit_equp_details',$equp);
		}
	}
	public function addFormColor($formColor,$inspUnqId){
		$rec = $this->db->where('form_color_insp_id',$inspUnqId)->get('ems_insp_app_form_color_status')->result_array();
		if(!empty($rec)){
			$this->db->where('form_color_insp_id',$inspUnqId)->update('ems_insp_app_form_color_status',$formColor);
		}else{
			$form['form_color_added_date'] = $formColor['form_color_added_date'];
			$form['form_color_insp_id'] = $inspUnqId;
			$this->db->insert('ems_insp_app_form_color_status',$form);
		}
	}
	public function getImgVidInsp($inspUnqId,$formNo){
		return $this->db->where('insp_id',$inspUnqId)->where('form_no',$formNo)->get('ems_insp_upload_file')->result_array();
	}
	public function editImgVidUpload($img,$inspUnqId,$formNo){
		
		$inspUploadFileChk = $this->db->where('insp_id',$inspUnqId)->where('form_no',$formNo)->get('ems_insp_upload_file')->result_array();
		if(!empty($inspUploadFileChk)){
			if($img['chkUploadImg'] == true && $img['chkUploadVideo'] == true){
				$img1['upload_img_path'] = $img['upload_img_path'];
				$img1['upload_video_path'] = $img['upload_video_path'];
			}else if($img['chkUploadImg'] == true){
				$img1['upload_img_path'] = $img['upload_img_path'];
			}else if($img['chkUploadVideo'] == true){
				$img1['upload_video_path'] = $img['upload_video_path'];
			}
			$this->db->where('insp_id',$inspUnqId)->where('form_no',$formNo)->update('ems_insp_upload_file',$img1);
		}
	}
	public function checkAllFormSubmit($inspUnqId){
		return $this->db->where('form_color_insp_id',$inspUnqId)->get('ems_insp_app_form_color_status')->result_array();
	}
}