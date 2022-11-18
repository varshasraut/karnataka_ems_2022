<?php 

if ( ! defined('BASEPATH')){ exit('No direct script access allowed');}

class CI_Application{

	  public $group_modules;

	  public $requster_type,$user_image_upload_path,$upload_path_colleague_images;

	  function __construct(){

	    ini_set('default_charset', 'UTF-8'); 

	  }

	  function __get($var){

		    if($var == "CI"){
                       return get_instance();
                    }else{
                       return $var;		
                    }

      }

    function close_database_connection() {

        $this->CI->load->model(array('options_model'));
        $this->CI->options_model->close_db_connection();
    }
	 function set_backend_environment(){

	      	 if('backend' != $this->CI->get_app_environment()) return false;
           
             
                  $this->CI->load->library('modules');
		  $this->CI->check = 'jolly';
                  $this->CI->modules->load_modulebar(true);
                  $data['modulebar'] = $this->CI->modulebar;
             
                  $this->CI->output->add_to_position($this->CI->load->view('frontend/env/leftsidebar_view',$data,true),'leftsidebar');	
			 

	  } 

	  function set_frontend_environment(){

			 if('frontend' != $this->CI->get_app_environment()) return false;

			 $this->CI->load->helper('router');
                      
                         $data = array();
  
		         $reqtype = $this->CI->input->get_post('reqtype', TRUE);
                    
                         $security_token = $this->CI->input->get_post('Security-Token', TRUE);
				
                         $uri =& load_class('URI', 'core');

                         $last = $uri->total_segments();

                         $get = $this->CI->input->get(NULL);

                         $post =  $this->CI->input->post(NULL); 

                         $data['post'] = array_merge($post,$get);


                         if($reqtype != 'ajax'){

                           $this->CI->load->library('modules');
                           $this->CI->check = 'jolly';
                           $this->CI->modules->load_modulebar(true);
                           $data['modulebar'] = $this->CI->modulebar;

                           $this->CI->output->add_to_position($this->CI->load->view('frontend/env/leftsidebar_view',$data,true),'leftsidebar');	         
                
                   }
                    
          }

}