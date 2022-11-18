<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends EMS_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('cms_model');
        $this->active_module = "M-CMS";
        $this->load->library(array('modules'));
    }

    public function index() {
        
        $this->output->add_to_position("User controller loaded");
        
    }

    /* Added by MI-42
    *  
    *  This function is used to add pages from CMS.
    */
    
    public function add_pages() {

        $this->tool_code = 'MT-CMS-ADD-PAGES';
     
        $data = array();
        
        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);
     
        $data["view"] = $this->input->post("page_id") != ""?"edit":"add";
        
        $page_id = $this->input->post("page_id") != ""?$this->input->post("page_id"):"";
        
        $page_details = $page_id != ""?$this->cms_model->get_pages($page_id):"";
        
        $existing_page_title = isset($page_details[0]->title) ? $page_details[0]->title : "";
        
        $existing_desc = isset($page_details[0]->description) ? $page_details[0]->description : "";

        $page_title = $this->input->post('page_title');
        
        $page_desc = $this->input->post('page_desc');
        
        $pages_data = array("title"=>$page_title, "description"=>$page_desc, "meta_title"=>$this->input->post("meta_title"), "meta_keywords"=>$this->input->post("meta_keywords"), "meta_desc"=>$this->input->post("meta_desc"), "updated_at"=> date("Y-m-d"));
        
        if($this->input->post("action") != "" && $this->input->post("action") == "edit"){
            
            $this->cms_model->edit_pages($pages_data, $page_id);
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Page edited Successfully...</div>";
            $this->list_pages();
            
        }else if($this->input->post("action") != "" && $this->input->post("action") == "add"){
            
            
            
            $this->cms_model->add_pages(array_merge($pages_data, array("created_at"=>date("Y-m-d"))));
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Page added Successfully...</div>";
            $this->list_pages();
        }else{
            
            $data["page_details"] = $page_details;
            
            $this->output->add_to_position($this->load->view('ems-admin/cms/add_pages_view',$data,true),"content",TRUE);
        }
    }
    
    
    /* Added by MI-42
    *  
    *  This function is used to list pages.
    */
   
    public function list_pages() {

        
         $this->tool_code = 'MT-CMS-PAGES-LIST';
        
        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);
        
        
        if($this->input->post("delete_page") != "" && $this->input->post("delete_page") == "true"){
            $page_ids = $this->input->post("id");
            $ids = is_array($page_ids)?$page_ids:array($page_ids);
            if(!isset($ids[0])){
                $this->output->message = "<div class='error'>Please select atleast one record!!</div>";
            }else{
                $this->cms_model->delete_pages($ids);
                $this->output->status = 1;
                $this->output->message = "<div class='success'>Record(s) deleted successfully...</div>";
            }
        }
        
        $data["page_list"] = $this->cms_model->get_pages();
       
        
        $this->output->add_to_position($this->load->view('ems-admin/cms/page_list_view',$data,true),"content",TRUE);
    }
    
    
    /* Added by MI-42
    *  
    *  This function is used to manage navigation menu.
    */
    
    function manage_navigation()
    {
        $this->tool_code = 'MT-CMS-ADD-PAGES';
        $data = $links_count = array();
        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);
      
        if($this->input->post("delete_navigation") != "" && $this->input->post("delete_navigation") == "true")
        {
            $navigation_ids = $this->input->post("id");
            $ids = is_array($navigation_ids)?$navigation_ids:array($navigation_ids);
            
            if(isset($ids[0]))
            {    
                $status=array('nav_delete_status'=>'1');
                $this->cms_model->delete_navigations($ids,$status);
                $this->output->status = 1;
                $this->output->message = "<div class='success'>Record(s) deleted successfully...</div>";
            }
            else
            {
                $this->output->message = "<div class='error'>Please select atleast one record...</div>";
            }
        }
        
        $navigation_list = $this->cms_model->get_navigation_list();

        foreach($navigation_list as $navigation)
        {
            $links_count[$navigation->nav_id] = $this->cms_model->get_navigation_links_count($navigation->nav_id);
        }
        
        
        $data["navigation_list"] = $navigation_list;
        $data["links_count"] = $links_count;
        

        $this->output->add_to_position($this->load->view('ems-admin/cms/manage_navigation_view',$data,true),"content",TRUE);
    }
    
    
    /* Added by MI-42
    *  
    *  This function is used to add navigation menu.
    */
   
    function add_navigation(){
        
        $this->tool_code = 'MT-CMS-ADD-PAGES';
    
        $data = $links_count = array();
        
        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);
            
        $navigation_id = $this->input->post("nav_id") != ""?$this->input->post("nav_id"):"";
        
        $data["view"] = $navigation_id != ""?"edit":"add";
        
        $navigation_details = $this->cms_model->get_navigation_by_id($navigation_id);
       
        $existing_title = isset($navigation_details) && !empty($navigation_details)?$navigation_details[0]->nav_tite:"";
        
        $navigation_title =$this->input->post('nav_title');
        
        
        $navigation_data = array("nav_tite"=>$navigation_title, "nav_type"=>$this->input->post("nav_type"), "nav_status"=>$this->input->post("nav_status"));
        
        if($this->input->post("action") != "" && $this->input->post("action") == "edit"){
            $this->cms_model->edit_navigations($navigation_data, $navigation_id);
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Navigation updated Successfully...</div>";
            $this->manage_navigation();
        }else if($this->input->post("action") != "" && $this->input->post("action") == "add"){            
           
            $this->cms_model->add_navigations(array_merge($navigation_data));
            $this->output->status = 1;
            $this->output->message = "<div class='success'>Navigation added Successfully...</div>";
            $this->manage_navigation();
        }else{
            $data["navigation_details"] = $navigation_details;
            $data["navigation_id"] =$navigation_id;
            $this->output->add_to_position($this->load->view('ems-admin/cms/add_navigation_view',$data,true),"ms_add_navigations",TRUE);
        }

    }
    

    /* Added by MI-42
    *  
    *  This function is used to add navigation links.
    */
    
    function add_navigation_links()
    {
      
        $this->tool_code = 'MT-CMS-ADD-PAGES';
        
        $data = $links_count = array();
        
        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);
        
        $navigation_id = $this->input->post("nav_id");
        
	
		
        $navigation_links = $this->cms_model->get_navigation_links_by_id($navigation_id);
        
       // var_dump($navigation_links);exit;
        
        $link_names = array_map(function($link){ return $link->lnk_name; }, $navigation_links);
        
        $link_sections = array_map(function($section){ return $section->lnk_section; }, $navigation_links);
     
        $nav_link_format = $this->input->post("nav_link_format") != ""?$this->input->post("nav_link_format"):"external";
        
        if($this->input->post("add_navigation_links") == "true"){
            
            $link_user_type = "'".implode("','", $this->input->post("link_user_type"))."'";
            
            $link_url = $this->input->post("link_url")?"{base_url}".$this->input->post("link_url"):"{base_url}page/get_page/".$this->input->post("link_slug");
            
            $link_section = $this->input->post("link_section")?$this->input->post("link_section"):"page";
            
            $link_slug = $this->input->post("link_type") == "httpajax"?"p".$this->input->post("link_slug"):$this->input->post("link_slug");
            
            $link_parent= $this->input->post("link_parent");
            
            $is_dropdown=$this->input->post("is_dropdown");
            
            ($is_dropdown[0]!='')?$dropdown="yes":$dropdown="no";
            
            $link_data = array("lnk_section"=>$link_section, "lnk_nav_id"=>$navigation_id, "lnk_slug"=>$link_slug, "lnk_parent"=>$link_parent,"lnk_name"=>$this->input->post("link_name"), "lnk_url"=>$link_url, "lnk_query_string"=>$this->input->post("link_query_string"), "lnk_type"=>$this->input->post("link_type"), "lnk_meta_title"=>$this->input->post("link_meta_title"), "lnk_meta_keywords"=>$this->input->post("link_meta_keywords"), "lnk_meta_description"=>$this->input->post("link_meta_desc"), "lnk_for_users"=>$link_user_type, "is_dropdown"=>$dropdown, "lnk_format"=> $this->input->post("link_format"));
            
            if(in_array($this->input->post("link_name"), $link_names)){
                
                $this->output->message = "<div class='error'>Link name already exists!!</div>";
            }
            else{
                
                $this->cms_model->save_navigation_links($link_data);
                $this->output->status = 1;
                $this->output->message = "<div class='success'>Link added successfully...</div>";
                $this->manage_navigation();
            }
            
        }
        else{
            
            $data["navigation_id"] = $navigation_id;
            
            $data["nav_link_format"] = $nav_link_format;
         
            $data["link_sections"] = array_unique($link_sections);
            
            $data["page_list"] = $this->cms_model->get_pages();
         
            $data['nav_title']=$this->input->post("nav_title");
            
            $this->output->add_to_position($this->load->view('ems-admin/cms/add_navigation_links_view',$data,true),"content",TRUE);
        }
    }
    
    
    /* Added by MI-42
    *  
    *  This function is used to update navigation links.
    */
    
    function update_navigation_links()
    {
        $this->tool_code = 'MT-CMS-ADD-PAGES';
        $data = array();
        $data['action'] = $this->modules->get_tool_config($this->tool_code, $this->active_module, true);
      
        $link_id = $this->input->post("lnk_id");
        $navigation_id = $this->input->post("nav_id");
        
		
        $link_details = $this->cms_model->get_navigation_link_by_id($link_id);
        
        $existing_link_title = isset($link_details) && !empty($link_details)?$link_details[0]->lnk_name:"";
        
		
        $link_title =$this->input->post('link_name');
        

        if($this->input->post("save_details") == "yes")
        {
            $link_user_type = "'".implode("','", $this->input->post("link_user_type"))."'";
            $link_data = array("lnk_name"=>$link_title, "lnk_for_users"=>$link_user_type);
     
			
            $navigation_links = $this->cms_model->get_navigation_links_by_id($navigation_id);
        
			$link_names = array_map(function($link){ return $link->lnk_name; }, $navigation_links);
			
			$link_sections = array_map(function($section){ return $section->lnk_section; }, $navigation_links);
		 
			$nav_link_format = $this->input->post("nav_link_format") != ""?$this->input->post("nav_link_format"):"external";
			
			
            $link_url = $this->input->post("link_url")?"{base_url}".$this->input->post("link_url"):"{base_url}page/get_page/".$this->input->post("link_slug");
            
            $link_section = $this->input->post("link_section")?$this->input->post("link_section"):"page";
            
            $link_slug = $this->input->post("link_type") == "httpajax"?"p".$this->input->post("link_slug"):$this->input->post("link_slug");
            
            $link_parent= $this->input->post("link_parent");
            
            $is_dropdown=$this->input->post("is_dropdown");
            
            ($is_dropdown[0]!='')?$dropdown="yes":$dropdown="no";
            
            $link_data = array("lnk_section"=>$link_section, "lnk_nav_id"=>$navigation_id, "lnk_slug"=>$link_slug, "lnk_parent"=>$link_parent,"lnk_name"=>$this->input->post("link_name"), "lnk_url"=>$link_url, "lnk_query_string"=>$this->input->post("link_query_string"), "lnk_type"=>$this->input->post("link_type"), "lnk_meta_title"=>$this->input->post("link_meta_title"), "lnk_meta_keywords"=>$this->input->post("link_meta_keywords"), "lnk_meta_description"=>$this->input->post("link_meta_desc"), "lnk_for_users"=>$link_user_type, "is_dropdown"=>$dropdown, "lnk_format"=> $this->input->post("link_format"));
            
	
            
            if(in_array($this->input->post("link_name"), $link_names) && $this->input->post("link_name")!=$existing_link_title){
                $this->output->message = "<div class='error'>Link name already exists!!</div>";
            }
			else
			{
				$result = $this->cms_model->update_navigations_links($link_data, $link_id);
				$this->output->status = 1;
				$this->output->message = "<div class='success'>Link updated successfully...</div>";
				$this->view_navigation_links($this->input->post("nav_id"));
			}
            
        }
        else
        {
            $data["link_details"] = $link_details;
            
            $data["link_id"] = $link_id;
            
            $data["navigation_id"] = $navigation_id;
            
            $data['nav_details']= $this->cms_model->get_navigation_by_id($navigation_id);
			
			$data['nav_title']=$data['nav_details'][0]->nav_tite;
		 
            $data['update_nav_links']="true";
            
            $navigation_links = $this->cms_model->get_navigation_links_by_id($navigation_id);
        
            $link_sections = array_map(function($section){ return $section->lnk_section; }, $navigation_links);
        
            $data['link_sections']=$link_sections;
            
            $this->output->add_to_position($this->load->view('ems-admin/cms/add_navigation_links_view',$data,true),"content",TRUE);
        }
    }

    
    /* Added by MI-42
    *  
    *  This function is used to list navigation links according to the navigation menu.
    */
    
    function view_navigation_links($nav_id = ""){
        $data = array();

        $navigation_id = $nav_id != ""?$nav_id:$this->input->post("nav_id");
        
        
        
        if($this->input->post("delete_links") != "" && $this->input->post("delete_links") == "true"){
            $link_ids = $this->input->post("id");
            
    
            if(empty($link_ids)){
                
                $this->output->message = "<div class='error'>Please select atleast one record!!</div>";
            }else{
                $this->cms_model->delete_navigations_links($link_ids);
                $this->output->status = 1;
                $this->output->message = "<div class='success'>Link(s) deleted successfully...</div>";
            }
        }
        
        $navigation_links = $this->cms_model->get_navigation_links_by_id($navigation_id);
        
        $navigation_details = $this->cms_model->get_navigation_list($navigation_id);
        
       // var_dump($navigation_details);exit;
        
        $link_names = array_map(function($link){ return $link->lnk_name; }, $navigation_links);
        $link_ids = array_map(function($lnk){ return $lnk->lnk_id; }, $navigation_links);
        
        $parent_names = array_combine($link_ids, $link_names);
        
        $data["navigation_links"] = $navigation_links;
        $data["navigation_id"] = $navigation_id;
        $data["navigation_details"] = $navigation_details;
        $data["parent_names"] = $parent_names;
        
        
        $this->output->add_to_position($this->load->view('ems-admin/cms/navigation_links_view',$data,true),"content",TRUE);
    }
    
    /* Added by MI-42
    *  
    *  This function is used to update status of navigation menu.
    */
    
    function update_nav_status()
    {
         if($this->input->get_post('nav_id',TRUE))
        {
            
            $status=$this->input->post('status',TRUE);
            
            
            $st=$status;
            
            if($status=="active")
            {
                $status="inactive";
            }
            else if($status=="inactive")
            {
                $status="active";
            }
           
            $args=array('nav_status'=>$status);
            
            $position = $this->input->get_post('output_position',true);
            
            $nav_id=base64_decode($this->input->get_post('nav_id',TRUE));
            
            $update_status=$this->cms_model->edit_navigations($args,$nav_id);
            
            
            
           if($update_status)
           {
              
                $this->output->message = "<div class='success'> Status updated successfully !!</div>";
               
			if($st == "active")
            {
                
				$status = "<a href=\"{base_url}cms/update_nav_status\"  class=\"click-xhttp-request block_status\" data-qr=\"status=inactive&nav_id=".base64_encode($nav_id)."&output_position=".$position."\"> <div class=\"block_status\"></div></a>";

                
			}
            
			elseif($st == "inactive")
            {
            
				$status = "<a href=\"{base_url}cms/update_nav_status\"  class=\"click-xhttp-request unblock_status\" data-qr=\"status=active&nav_id=".base64_encode($nav_id)."&output_position=".$position."\"> <div class=\"unblock_status\"></div></a>";
				
				
			}
			
			$this->output->add_to_position($status,$position,TRUE);
            
          }
        }
    }
    
}

