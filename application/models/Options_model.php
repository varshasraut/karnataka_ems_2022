<?php 
class Options_model extends CI_Model 
{
	public  $tbl_option;
	
    function __construct(){
		     parent::__construct();
		     $this->load->database();
			 $this->tbl_option = $this->db->dbprefix('options');
		
			 
	}
   function close_db_connection(){   
	 
       // $this->db->close();
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



	function delete_option($key){
        
            $query_obl = $this->db->query("DELETE FROM  ".$this->tbl_option." WHERE `oname` = '".$key."'");
            $result = $query_obl->result();
	    	if($result){
		    	return true;
		    }else{
			    return false;
		    }
            
	}
        
        
    function update_md_uplimit($usr_ref_id='',$mdcnt=''){

        $this->db->where('oname',$usr_ref_id);
        $result=$this->db->update($this->tbl_option,array('ovalue'=>$mdcnt));
        return $result;

    }
	
}