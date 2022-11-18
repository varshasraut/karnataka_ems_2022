<?php
class Cms_model extends CI_Model {
	
    function __construct() {
        parent::__construct();
      
        
        $this->tbl_cms_pages = $this->db->dbprefix('cms_pages');      
        $this->tbl_navigation = $this->db->dbprefix('navigation');
        $this->tbl_navigation_link = $this->db->dbprefix('navigation_link');
    }
    
           

     function get_pages($page_id = ""){
         
        $where = $page_id != ""?array("is_deleted" => "0", "id"=>$page_id):array("is_deleted" => "0");
        $this->db->select('*');
        $this->db->from($this->tbl_cms_pages);
        if($page_id != ''){
           //$this->db->where('id',$page_id); 
        }
        //$this->db->where('is_deleted','0');  
        $data = $this->db->get();
        //echo $this->db->last_query();
       // die();
        $result = $data->result();
        return $result;
        
    }
    

    function add_pages($data = ""){
		if(is_array($data)){
            
             $this->db->insert($this->tbl_cms_pages, $data);             
             return $this->db->insert_id();
		}
    }
    

    function edit_pages($data = "", $page_id = ""){
        $this->db->where('id', $page_id);
        $result = $this->db->update($this->tbl_cms_pages , $data);
        return $result;
    }

    function delete_pages($page_id = ""){
        $this->db->where_in('id', $page_id);
        $result = $this->db->update($this->tbl_cms_pages , array("is_deleted"=>"1"));
        return $result;
    }
    
    
   
    function get_navigation_list($navigation_id = ""){
        $this->db->select('*');
        $this->db->from($this->tbl_navigation);
        if($navigation_id != ""){
            $this->db->where('nav_id', $navigation_id);
        }
        $arr=array('nav_delete_status'=>'0');
        $this->db->where($arr);
        $data=$this->db->get();
        $result = $data->result();
        return $result;
    }
    
   
    function get_navigation_by_id($navigation_id = ""){
        $this->db->select('*');
        $this->db->from($this->tbl_navigation);
        $this->db->where(array("nav_id"=>$navigation_id));
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }

    function get_navigation_links_count($navigation_id = ""){
        $this->db->select('*');
        $this->db->from($this->tbl_navigation_link);
        $this->db->where(array("lnk_nav_id"=>$navigation_id));
        $data = $this->db->get();

        $result = $data->num_rows();
        return $result;
    }

    function get_navigation_links_by_id($navigation_id = ""){
        $this->db->select('*');
        $this->db->from($this->tbl_navigation_link);
        $this->db->where(array("lnk_nav_id"=>$navigation_id));
        $data = $this->db->get();
        $result = $data->result();
        return $result;
    }
    

    function add_navigations($data = ""){
		if(is_array($data)){
		
		   
           $this->db->insert($this->tbl_navigation, $data);
           return $this->db->insert_id();
		}
    }
    
    
 
    function edit_navigations($data = array(), $navigation_id = ""){
        

        if($data['nav_status']=="active" || $data['nav_status']=="inactive")
        {
            
            $this->db->where('nav_id', $navigation_id);
            
            $result = $this->db->update($this->tbl_navigation,$data);
            
            
            
        }
        else
        {
            
            $this->db->where('nav_id', $navigation_id);
            
            $result = $this->db->update($this->tbl_navigation , $data);
            
        }
        return $result;
        
    }
    
    function delete_navigations($nav_id = "",$del_status=array())
    {
        
        $this->db->where_in('nav_id', $nav_id);
        $result =  $this->db->update($this->tbl_navigation,$del_status); 
        return $result;

    }
    

    function delete_navigations_links($nav_id = ""){
        if($nav_id != ''){
        $this->db->where_in('lnk_id', $nav_id);
        $result = $this->db->delete($this->tbl_navigation_link); 
        return $result;
        }
    }
    
    
    
 
    function update_navigations_links($data = "", $link_id = ""){
        
        
        
        $this->db->where_in('lnk_id', $link_id);
        $result = $this->db->update($this->tbl_navigation_link , $data);
        return $result;
        
    }
    
  
    function get_navigation_link_by_id($lnk_id){
        $this->db->select('*');
        $this->db->from($this->tbl_navigation_link);
        $this->db->where(array("lnk_id"=>$lnk_id));
        $data = $this->db->get();
//        var_dump($this->db->last_query());
        $result = $data->result();
        return $result;
    }

    function save_navigation_links($link_data = ""){
		if(is_array($link_data)){
			
             $this->db->insert($this->tbl_navigation_link, $link_data);
        return $this->db->insert_id();
		}
    }
    
    
    
    
    
    
    /*  MI18 
      *  Env cms model function
    */
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


                  
                  
			  $query_obl = $this->db->query('SELECT lnk.* FROM '.$this->tbl_navigation_link.' as lnk  '.$sql_patch.'  ORDER BY lnk.lnk_order ASC');

		      $result = $query_obl->result();

              
		   

	    	 if($result){

		    	return $result;

		     }else{

			    return false;

		     }

		}
        
        function get_navigation_link_childs($lnk_slug)
        {
            
             $query= $this->db->query("SELECT * FROM ".$this->tbl_navigation_link." where lnk_parent='".$lnk_slug."'");
             
             return $query->num_rows();
             
        }
  
}