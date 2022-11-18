<?php 

class Modules_model extends CI_Model 

{

	public  $tbl_group_permissions,$tbl_mas_modules,$tbl_mas_tools;

	

    function __construct(){

		     parent::__construct();

		     $this->load->database();

			 $this->tbl_group_permissions = $this->db->dbprefix('group_permissions');

			 $this->tbl_mas_modules = $this->db->dbprefix('mas_modules');

			 $this->tbl_mas_tools = $this->db->dbprefix('mas_tools');			  

	}

	

	function get_group_modules($gcode){

      


	///SELECT gm.* FROM gb_mas_modules as gm,gb_group_permissions as gpm WHERE gpm.`permissions` LIKE CONCAT('%', gm.`mcode`,'%') AND gpm.`gcode`="UG-ADMIN" order by gm.`order`
$query_obl = $this->db->query('SELECT gm.*,gm.module as module_name FROM '.$this->tbl_mas_modules.' as gm,'.$this->tbl_group_permissions.' as gpm WHERE gpm.`permissions` LIKE CONCAT("%", gm.`mcode`,"%") AND gpm.`gcode`="'.$gcode.'" order by gm.`order` ASC');
//		$query_obl = $this->db->query('SELECT gm.*,gm.module as module_name FROM '.$this->tbl_mas_modules.' as gm,'.$this->tbl_group_permissions.' as gpm WHERE gpm.`permissions` LIKE CONCAT("%", gm.`mcode`,"%")  order by gm.`order`');

		$result = $query_obl->result();



		if($result){

			

			foreach($result as $record){ $output[$record->mcode] = $record;	}

			

			return $output;



		}else{

			return false;

		}

		

	}

	function get_group_tools($gcode){



		

		$query_obl = $this->db->query('SELECT gt.* FROM '.$this->tbl_mas_tools.' as gt,'.$this->tbl_group_permissions.' as ggt WHERE ggt.`permissions` LIKE CONCAT("%", gt.`tlcode`,"%")  AND ggt.`gcode`="'.$gcode.'" order by gt.`order`');

		

		$result = $query_obl->result();

	

		if($result){

			foreach($result as $record){ $output[$record->mcode][$record->tlcode] = $record;	}

		

			return $output;

		}else{

			return false;

		}

		

	}



	

}