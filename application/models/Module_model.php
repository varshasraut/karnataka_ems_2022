<?php
class Module_model extends CI_Model {
	
    function __construct() {
        parent::__construct();
		
		$this->tbl_mas_modules = $this->db->dbprefix('mas_modules');
		$this->tbl_mas_tools = $this->db->dbprefix('mas_tools');
		$this->tbl_group_permissions = $this->db->dbprefix('group_permissions');
    }
 

  
  function get_modules_and_tools($ug){  
            
            $obj_tsk = $this->db->query('SET group_concat_max_len = 10000');
		     $sql = "SELECT mm.*,if(gp.permissions LIKE CONCAT ('%',mm.mcode,'%'),1,0) AS module_selected,GROUP_CONCAT(CONCAT('{',CONCAT_WS(',',CONCAT('\"tl_name\"',':\"',mt.tl_name,'\"'),CONCAT('\"tlcode\"',':\"',mt.tlcode,'\"'),CONCAT('\"tl_selected\"',':\"',if(gp.permissions LIKE CONCAT('%',mt.tlcode,'%'),1,0)))
,'\"}') SEPARATOR  ',') as tools 

FROM ".$this->tbl_mas_modules." AS mm LEFT JOIN (SELECT * FROM ".$this->tbl_mas_tools." ORDER BY `order`) AS mt ON mm.mcode = mt.mcode LEFT JOIN ".$this->tbl_group_permissions." AS gp ON (( gp.permissions LIKE CONCAT('%',mm.mcode,'%') OR gp.permissions LIKE CONCAT('%',mt.tlcode,'%')) AND gp.gcode = '".trim($ug)."' )

GROUP BY mm.mcode,gp.permissions ORDER BY mm.order ASC";
          
  
             $obj_res = $this->db->query($sql);

             
			  $result = $obj_res->result();
			
			  if($result){
				return $result;
			  }else{
				return false;
			  }
	}
 
 
  function get_modules(){  
		  $this->db->select($this->tbl_mas_modules.'.*,'.$this->tbl_mas_tools.'.tlid,'.$this->tbl_mas_tools.'.tl_name,'.$this->tbl_mas_tools.'.tlcode,'.$this->tbl_mas_tools.'.mcode as tl_mcode');
          $this->db->from($this->tbl_mas_modules);
          $this->db->join($this->tbl_mas_tools, $this->tbl_mas_modules.'.mcode = '.$this->tbl_mas_tools.'.mcode','left'); 
          $data = $this->db->get();
          $result = $data->result();
          return $result;
	}
     function get_tools_by_mcode($mcode){  
          $this->db->select('*');
          $this->db->from($this->tbl_mas_tools);
          $this->db->where("is_alias" , '0');
           $this->db->where("mcode" , $mcode);
          $data = $this->db->get();
          $result = $data->result();
          return $result;
   }
  
   function get_users_groups(){  
          $this->db->select('*');
          $this->db->from('mas_groups');
          $this->db->where("mas_groups.is_deleted" , '0');
          $data = $this->db->get();
          $result = $data->result();
          return $result;
   }
 
  function add_group_permissions($user_gcode,$modules_data){
		     $result = $this->db->query("INSERT INTO ".$this->tbl_group_permissions."(`gcode`,`permissions`) VALUES('".$user_gcode."','".$modules_data."') ON DUPLICATE KEY UPDATE `permissions`='".$modules_data."'");
		   
	    	 if($result){
		    	return true;
		     }else{
			    return false;
		     }
		}
		
		
	function get_group_permissions($user_code){  
          $this->db->select('*');
          $this->db->from($this->tbl_group_permissions);   
		  $this->db->where("gcode ='".$user_code."'");                	   
           $data = $this->db->get();
           $result = $data->result();
           return $result;
       
  }
  
} 