<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function chkMobExist($data){
        $this->db->select('*');
        $this->db->from('ems_comu_app_user_reg');
        $this->db->where('mobile',$data['mobile']);
        $this->db->where('usr_acc_activation','0');
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return 1;
        }else{
            // $this->db->insert('ems_comu_app_user_reg',$data);
            return 2;
        }
    }
    public function insertUsrReg($data){
        $this->db->insert('ems_comu_app_user_reg',$data);
    }
    public function usrLogin($data){
        $this->db->select('*');
        $this->db->from('ems_comu_user_login_session');
        $this->db->where('mobile',$data['mobile']);
        $this->db->where('login_status','1');
        $checkLogin = $this->db->get();
        if ($checkLogin->num_rows() > 0 )
        {
            $data1['modified_time'] = date('Y-m-d H:i:s');
            $this->db->where('mobile',$data['mobile'])->update('ems_comu_user_login_session',$data1);
        }else{
            $this->db->insert('ems_comu_user_login_session',$data);
        }
        
    }
    public function getUsrLogin($data){
        $this->db->select('*');
        $this->db->from('ems_comu_user_login_session');
        $this->db->where('mobile',$data['mobile']);
        $this->db->where('login_status','1');
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }else{
            return 2;
        }
    }
    public function updateOtp($data,$update){
        $this->db->where('mobile',$data['mobile'])->update('ems_comu_app_user_reg',$update);
        return 1;
    }
    public function logout($data,$activate){
        $updateRec['login_status'] = 2;
        $this->db->where('mobile',$data['mobile'])->where('login_secret_key',$data['login_secret_key'])->where('unique_id',$data['uniqueId'])->where('login_status',1)->update('ems_comu_user_login_session',$updateRec);
        return 1;
    }
    public function resendOtpUpdate($data,$mobile){
       $this->db->where('mobile',$mobile)->update('ems_comu_app_user_reg',$data);
        return 1;
    }
    public function checkLoginUserforAuth($data){
        $rec = $this->db->where('mobile',$data['mobile'])->where('login_secret_key',$data['login_secret_key'])->where('unique_id',$data['uniqueId'])->where('login_status',1)->get('ems_comu_user_login_session')->result_array();
        if(count($rec) > 0){
            return 1;
        }else{
            return 2;
        }
    }
    public function logoutOtherDeviceUser($mobile){
        $updateRec['login_status'] = 2;
        $this->db->where('mobile',$mobile)->where('login_status',1)->update('ems_comu_user_login_session',$updateRec);
        return 1;
    }
    public function chkUserLogin($user_mob_no){
        $this->db->select('session.unique_id,session.mobile,version.token');
        $this->db->from('ems_comu_user_login_session as session');
        $this->db->join('ems_comu_app_device_version as version','session.unique_id=version.unique_id','left');
        $this->db->where('session.mobile',$user_mob_no);
        $this->db->where('session.login_status','1');
        $query = $this->db->get();
        if ($query->num_rows() > 0 )
        {
            return $query->result_array();
        }else{
            return 2;
        }
    }
    public function userAccDeactivation($activate,$userMob){
        $data['usr_acc_activation'] = $activate;
        $this->db->where('mobile',$userMob)->update('ems_comu_app_user_reg',$data);
    }
}