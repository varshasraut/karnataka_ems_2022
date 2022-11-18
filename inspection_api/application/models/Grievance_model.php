<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Grievance_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
    public function insertGrievance($gri){
        $this->db->insert('ems_ins_gri_audit_details',$gri);
        return 1;
    }
    public function getGrievanceCompletedList($username){
        $this->db->select('gri.id as grivId,gri.amb_no as vehicleNumber,gri.added_date as gridate,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.ins_baselocation as baseLoc,dis.dst_name as disName');
        $this->db->from('ems_ins_gri_audit_details as gri');
		$this->db->join('ems_inspection_audit_details as insp','gri.ins_id = insp.id','left');
        $this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
		$this->db->where('gri.status', '0');
        $this->db->where('gri.added_by', $username);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
	public function getgrievanceListInPro($username){
        $this->db->select('insp.id as inspectionId,insp.ins_amb_no as vehicleNumber,insp.ins_amb_current_status as ambCurrentStatus,insp.ins_gps_status as gpsworking,insp.ins_pilot as pilotpres,insp.ins_emso as emsopres,insp.added_date as date,insp.ins_baselocation as baseLoc,dis.dst_name as disName');
        $this->db->from('ems_inspection_audit_details as insp');
		$this->db->join('ems_mas_districts as dis','insp.ins_dist = dis.dst_code','left');
        $this->db->where('insp.is_deleted', '1');
		$this->db->where('insp.ins_app_status', '2');
        $this->db->where('insp.gri_status', '0');
		$this->db->where('insp.added_by', $username);
        $this->db->where('insp.forword_grievance', '2');
        $query = $this->db->get();
		//echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function getGrievanceDetails($griUniqeId){
        $this->db->select('gri.id as grivId,gri.amb_no as vehicleNumber,gri.added_date as gridate,gri.prilimnari_inform as prilimnariInform, gri.remark as remark,gritype.grievance_type as grievanceType,grisubtype.grievance_sub_type as grievanceSubtype');
        $this->db->from('ems_ins_gri_audit_details as gri');
		$this->db->join('ems_mas_grievance_type as gritype','gri.grievance_type = gritype.grievance_id','left');
        $this->db->join('ems_mas_grievance_sub_type as grisubtype','gri.grievance_sub_type = grisubtype.g_id','left');
		$this->db->where('gri.status', '0');
        $this->db->where('gri.id', $griUniqeId);
        $query = $this->db->get();
		// echo $this->db->last_query();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
    }
    public function closedGriv($insp,$insp_id){
        $this->db->where('id',$insp_id)->update('ems_inspection_audit_details',$insp);
    }
}