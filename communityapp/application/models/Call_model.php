<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Call_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insertCall($data){
        $this->db->select('*');
        $this->db->from('ems_comu_app_call');
        $this->db->where('mobile_no',$data['mobile_no']);
        $checkRec = $this->db->get();
        if ($checkRec->num_rows() > 0 )
        {
            $this->db->where('mobile_no',$data['mobile_no'])->update('ems_comu_app_call',$data);
        }else{
            $this->db->insert('ems_comu_app_call',$data);
        }
        $data1['mobile_no'] = $data['mobile_no'];
        $data1['lat'] = $data['lat'];
        $data1['lng'] = $data['lng'];
        $data1['added_date'] = date('Y-m-d H:i:s');
        $data1['call_status'] = "Call Dial";
        $this->db->insert('ems_comu_app_call_details',$data1);
        return $this->db->insert_id();
        //return 1;
    }
    public function saveImg($data){
        $this->db->insert('ems_comu_app_call_imgvideo',$data);
    }
//function for fetch link
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
    public function addAmbRequest($req){
        $this->db->insert('ems_comu_app_user_amb_req',$req);
        return 1;
    }
    public function getUserMobId($userMobNo){
        $this->db->select('usr_id');
        $this->db->from('ems_comu_app_user_reg');
        $this->db->where('mobile',$userMobNo);
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    public function getAmbReqData($userMobNo){
        $this->db->select('ambreq.user_req_id,ambreq.user_req_unique_id,ambreq.user_req_dispatched,ambreq.user_req_added_date,purpose.pname,comp.ct_type,user.f_name,user.l_name,usrfamily.fam_f_name,usrfamily.fam_l_name');
        $this->db->from('ems_comu_app_user_amb_req as ambreq');
        $this->db->join('ems_mas_call_purpose as purpose','ambreq.user_req_calltype=purpose.pid','left');
        $this->db->join('ems_mas_patient_complaint_types as comp','ambreq.user_req_chiefcomplaint=comp.ct_id','left');
        $this->db->join('ems_comu_app_user_reg as user','ambreq.user_req_usertype=1 AND ambreq.user_req_patient=user.usr_id','left');
        $this->db->join('ems_comu_app_family_info as usrfamily','ambreq.user_req_usertype=2 AND ambreq.user_req_patient=usrfamily.fam_id','left');
        $this->db->where('ambreq.user_req_mobile',"$userMobNo");
        $this->db->order_by('ambreq.user_req_id','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
    public function getAmbReqDisData($userMobNo){
        $this->db->select('ambreq.user_req_id,ambreq.user_req_unique_id,ambreq.user_req_dispatched,ambreq.user_req_added_date,purpose.pname,comp.ct_type,user.f_name,user.l_name,usrfamily.fam_f_name,usrfamily.fam_l_name,tracklink.track_link,tracklink.track_status,amb.amb_default_mobile,incamb.amb_rto_register_no,incamb.inc_ref_id');
        $this->db->from('ems_comu_app_user_amb_req as ambreq');
        $this->db->join('ems_mas_call_purpose as purpose','ambreq.user_req_calltype=purpose.pid','left');
        $this->db->join('ems_mas_patient_complaint_types as comp','ambreq.user_req_chiefcomplaint=comp.ct_id','left');
        $this->db->join('ems_comu_app_user_reg as user','ambreq.user_req_usertype=1 AND ambreq.user_req_patient=user.usr_id','left');
        $this->db->join('ems_comu_app_family_info as usrfamily','ambreq.user_req_usertype=2 AND ambreq.user_req_patient=usrfamily.fam_id','left');
        $this->db->join('ems_incident_tracklink as tracklink','ambreq.user_req_inc_ref_id=tracklink.incident_id','left');
        $this->db->join('ems_incidence_ambulance as incamb','ambreq.user_req_inc_ref_id=incamb.inc_ref_id','left');
        $this->db->join('ems_ambulance as amb','incamb.amb_rto_register_no=amb.amb_rto_register_no','left');
        $this->db->where('ambreq.user_req_mobile',"$userMobNo");
        $this->db->where('ambreq.user_req_dispatched','Dispatch');
        $this->db->order_by('ambreq.user_req_id','DESC');
        $query = $this->db->get();
        // print_r($this->db->last_query());
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }
    }
}