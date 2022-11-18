<?php



class manufacture_model extends CI_Model {

    function __construct() {

        parent::__construct();

        $this->load->database();
        
        $this->tbl_man = $this->db->dbprefix('manufacture');
       
    }
    function get_manufacture_tyre($args=array()){
        $condition='';
        if(!empty($args['keyword'])){
            
            $condition.=" AND man_name like '%".$args['keyword']."%' ";
            
        }
        if($args['type']){
            $condition.=" AND man_type = ".$args['type']." ";
        }
        
        $result=$this->db->query("select * from $this->tbl_man where man_status='1' AND manis_deleted='0' $condition");
        //echo $this->db->last_query();
        //die();
        return $result->result();
    
    }
    
    function get_manufacture($args=array()){
    
        if(!empty($args['keyword'])){
            
            $condition.=" AND man_name like '%".$args['keyword']."%' ";
            
        }
        
        $result=$this->db->query("select * from $this->tbl_man where man_status='1' AND manis_deleted='0' $condition");

        return $result->result();
    
    }
    
}
