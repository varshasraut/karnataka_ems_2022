<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Profile_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();	
		date_default_timezone_set("Asia/Manila");
	}
	
	public function getMyProfile(){
		$this->db->where('username', $this->session->userdata('username'));	
		$query = $this->db->get("users");
		return $query->row();
	}
	public function getstates(){
		// $this->db->where('stis_deleted', '0');	

		$query = $this->db->where('stis_deleted', '0')->get("mas_states");
		return $query->result_array();		
	}
	public function getdist(){
		// $this->db->where('stis_deleted', '0');	

		$query = $this->db->where('dstis_deleted', '0')->get("mas_district");
		return $query->result_array();		
	}
	public function getgroups(){
		// $this->db->where('stis_deleted', '0');	

		$query = $this->db->where('is_deleted', '0')->where('gpname !=' ,'Superadmin')->get("mas_group");
		return $query->result_array();		
	}
	
	public function getcolldetails($limit = 10, $offset = 0){
		$this->db->select("*");
        // $query = $this->db->get('mas_colleague');
		$query = $this->db->get("mas_colleague", $limit, $offset);
        return $query->result_array();
	}
	
	public function count_all(){
		$this->db->select("*");
		// $where = "(A.lastname like '%".$this->session->userdata("search_user")."%' 
		// 			or A.firstname like '%".$this->session->userdata("search_user")."%' 
		// 			or A.user_id like '%".$this->session->userdata("search_user")."%' 
		// 			or C.designation like '%".$this->session->userdata("search_user")."%' 
		// 			or B.dept_name like '%".$this->session->userdata("search_user")."%' 
		// 			or A.email_address like '%".$this->session->userdata("search_user")."%' 
		// 			or A.InActive like '%".$this->session->userdata("search_user")."%')";
		// $this->db->where($where);
		// $this->db->join("department B","B.department_id = A.department","left outer");
		// $this->db->join("designation C","C.designation_id = A.designation","left outer");
		// $this->db->join("system_parameters D","D.param_id = A.title","left outer");
		$this->db->order_by('userid','asc');
		$query = $this->db->get("mas_colleague A");
		return $query->num_rows();
	}
	public function edit_user(){
	
		$this->data = array(
			'fullname'			=>		$this->input->post('fullname'),
			'gender'			=>		$this->input->post('gender'),
			'state'			    =>		$this->input->post('state'),
			'district'			=>		$this->input->post('dist'),
			'city'				=>		$this->input->post('city'),
			'address'			=>		$this->input->post('address'),
			'mobile'			=>		$this->input->post('mobile'),
			'email'				=>		$this->input->post('email'),
			'userid'			=>		$this->input->post('ref_id'),
			'added_by'			=>		$this->input->post('userid'),
			'clg_dob'			=>		$this->input->post('birthday'),
			'join_date'			=>		$this->input->post('joindate'),
			'password'			=>		MD5('111111'),
			
			'added_by'			=>		$this->input->post('userid'),
			'user_group'		=>		$this->input->post('group')
			
		);	
		// $this->db->where('user_id', $this->input->post('userid'));
		$this->db->insert("mas_colleague",$this->data);

		// print_r($this->data);
		// $this->db->insert("mas_colleague",$this->data);
		//    echo $this->db->last_query();
        // die();
	}
	
	public function validate_password(){
		$this->db->select("password");
		 $this->db->where(array(
                'password'      =>      md5($this->input->post('oldPwd')),
				'user_id'		=>		$this->session->userdata('user_id')
        ));
        $query = $this->db->get('users');
        if($query->num_rows() == 1){
            return true;
        }else{
            return false;
        }
	}
	
	
	public function userid_exists($key){
		{
			$this->db->where('userid',$key);
			$query = $this->db->get('mas_colleague');
			if ($query->num_rows() > 0){
				return true;
			}
			else{
				return false;
			}
		}
	}
	
	
	
	
	
	
}