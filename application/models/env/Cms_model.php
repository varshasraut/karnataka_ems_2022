<?php 

class Cms_model extends CI_Model 

{

	public  $tbl_option;

	

    function __construct(){

		     parent::__construct();

		     $this->load->database();

			 $this->tbl_navigation = $this->db->dbprefix('navigation');

			 $this->tbl_navigation_link = $this->db->dbprefix('navigation_link');

		

			 

	}

	

	function get_navigation($title){

		     if($title ==""){ return false; }
		     $result = $this->db->query('SELECT nav.* FROM '.$this->tbl_navigation.' as nav WHERE nav.`nav_tite` LIKE "%'.trim($title).'%" AND nav.`nav_status`="active" ');

		   ///  $result = $result->result();

	    	 if($result){

		    	return $result->first_row();;

		     }else{

			    return false;

		     }

			 

		}



	function get_navigation_link($arg){

         
                          if($arg['nav'] != ""){ $sql_patch[] = 'lnk.lnk_nav_id = "'.$arg['nav'].'"';}
                          
			  if($arg['user_type'] != ""){ $sql_patch[] = "lnk.lnk_for_users REGEXP CONCAT( '[[:<:]]','".$arg['user_type']."' , '[[:>:]]' ) ";}

			  if($arg['slug'] != ""){ $sql_patch[] = 'lnk.lnk_slug = "'.$arg['slug'].'"';}

			  

			  if(is_array($sql_patch)){

				  $sql_patch  = " WHERE ".join(" AND ",$sql_patch);

			  }else{

				  $sql_patch  = "";

				  }

				 /// echo 'SELECT lnk.* FROM '.$this->tbl_navigation_link.' as lnk WHERE  lnk.`lnk_nav_id`="'.$arg['nav'].'"  ORDER BY lnk.lnk_section, FIELD(lnk.lnk_order,"1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30") ASC';

		       

			//  echo 'SELECT lnk.* FROM '.$this->tbl_navigation_link.' as lnk  '.$sql_patch.'  ORDER BY lnk.lnk_order ASC';

			  $query_obl = $this->db->query('SELECT lnk.* FROM '.$this->tbl_navigation_link.' as lnk  '.$sql_patch.'  ORDER BY lnk.lnk_order ASC');

		      $result = $query_obl->result();

		   

	    	 if($result){

		    	return $result;

		     }else{

			    return false;

		     }

		}



	

	

}