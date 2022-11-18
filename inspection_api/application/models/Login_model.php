<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Login_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
	}
	
	// public function validate_login(){
	// 	$this->db->select("username,password");
	// 	 $this->db->where(array(
    //             'username'      =>      $this->input->post('username'),
    //             'password'      =>      md5($this->input->post('password')),
	// 			'InActive'		=>		0
    //     ));
    //     $query = $this->db->get('users');
    //     if($query->num_rows() == 1){
    //         return true;
    //     }else{
    //         return false;
    //     }
	// }
	
	// public function getMyModule($user_id){
	// 	$this->db->select("B.module");
	// 	$this->db->where("user_id",$user_id);
	// 	$this->db->join("user_roles B","B.role_id = A.user_role","left outer");
	// 	$query = $this->db->get("users A");
	// 	return $query->row();	
	// }
	public function checkLoginUser($data){
		$this->db->select('id,username,login_status,device_id');
        $this->db->from('ems_insp_app_login_session');
		$this->db->where('username',$data['username'])->where('login_status','1');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
            return $query->result();
        }
	}
	public function logoutPreDevice($data){
		$update['login_status'] = '2';
		$this->db->where('username',$data['username'])->where('login_status','1')->update('ems_insp_app_login_session',$update);
        return 1;
	}
	public function loginCheck($data){
		$where = '((clg_ref_id="'.$data['username'].'") AND (clg_group = "UG-ZM" or clg_group = "UG-INSPECTION" or clg_group = "UG-DM" or clg_group = "UG-Quality"))';
		$this->db->select('clg_id,clg_ref_id,clg_password,clg_group');
        $this->db->from('ems_colleague');
	$this->db->where($where);
		//$this->db->where('clg_ref_id',$data['username'])->where('clg_group','UG-INSPECTION');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
			$query = $query->result_array();
			// print_r($query);
			if(!empty($query) && ($query[0]['clg_password'] == $data['password'])){
				return $query; //success login
			}else if(!empty($query) && ($query[0]['clg_password'] != $data['password'])){
				return 3; //wrong password
			}
        }else{
			return 2; //wrong username
		} 
	}
	public function loginSuccess($data){
		$this->db->insert('ems_insp_app_login_session',$data);
		return 1;
	}
	public function checkLoginUserforAuth($data){
		$this->db->select('id,username,login_status,device_id');
        $this->db->from('ems_insp_app_login_session');
		$this->db->where('login_secret_key',$data['login_secret_key'])->where('device_id',$data['device_id'])->where('username',$data['username'])->where('login_status','1');
        $query = $this->db->get()->result_array();
        if (count($query) > 0 )
        {
            return 1;
        }else{
			return 2;
		}
	}
	public function logoutUser($data){
		$log['login_status'] = '2';
		$this->db->where('login_secret_key',$data['login_secret_key'])->where('device_id',$data['device_id'])->where('username',$data['username'])->where('login_status','1');
		$this->db->update('ems_insp_app_login_session',$log);
		return 1;
	}
	
}