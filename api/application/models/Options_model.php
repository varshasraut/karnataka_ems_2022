<?php 
class Options_model extends CI_Model 
{
	public  $tbl_option;
	
    function __construct(){
		parent::__construct();
		$this->load->database();
		$this->tbl_option = $this->db->dbprefix('ems_options');
		$this->inc_ptn_gen  = $this->db->dbprefix('ems_inc_ptn_gen'); 
	}
	function get_option($key){
		$query_obl = $this->db->query('SELECT opt.* FROM '.$this->tbl_option.' as opt WHERE opt.`oname`="'.$key.'"');
		$result = $query_obl->result();
		if($result){
			return $result[0]->ovalue;
		}else{
			return false;
		}
			 
	}

	function add_option($key,$value){
		$result = $this->db->query("INSERT INTO ".$this->tbl_option."(`oname`,`ovalue`) VALUES('".$key."','".$value."') ON DUPLICATE KEY UPDATE `ovalue`='".$value."'");           
		if($result){
			return true;
		}else{
			return false;
		}
	}
	function get_ptn_index($clg_id){
        if(empty($clg_id)){
            $clg_id = 0;
        }
        $this->db->insert($this->inc_ptn_gen,array('user_id'=>$clg_id));
        $sql =  "SELECT MAX(id) as `inc_ptn_index` FROM `$this->inc_ptn_gen` WHERE `user_id` = '$clg_id'";
        $result = $this->db->query($sql);
        $res = $result->result();
        return $res[0]->inc_ptn_index; 
    }
}