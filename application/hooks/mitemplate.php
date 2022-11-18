<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CI_MIOutput{

	public $config_file = "config.xml";

	public $theme_config = "";

	public $current_theme = array();

	public $template_pos_html = array();

	public $notifications_ouput = array();

	public $popup_ouput = array();

	public $message = "";

	public $status = 1;

	public $set_focus_to = "";  

   function __construct(){

	   
	    if(APPLICATION_ENVIRONMENT == 'backend'){

		$this->current_theme["theme"] = $this->CI->config->item('backend_theme');		

		}else{

		$this->current_theme["theme"] = $this->CI->config->item('frontend_theme');

		}

		$this->current_theme["theme_path"] = trim($this->CI->config->item('theme_path'),"/")."/".trim($this->current_theme["theme"],"/");		

		$this->current_theme["config_path"] = $this->current_theme["theme_path"]."/".$this->config_file;	

		$this->current_theme["css_path"] = $this->CI->config->item('base_url').$this->current_theme["theme_path"]."/css";	

		$this->current_theme["js_path"] = $this->CI->config->item('base_url').$this->current_theme["theme_path"]."/js";	

		$this->current_theme["image_path"] = $this->CI->config->item('base_url').$this->current_theme["theme_path"]."/images";

		$this->current_theme["base_url"] = $this->CI->config->item('base_url');
        
                $this->current_theme["site_name"] = $this->CI->config->item('site_name');

		$this->current_theme["config"] = array();


	}

	  function __get($var){

		    if($var == "CI"){
                       return get_instance();
                    }else{
                       return $var;		
                    }

         }


	function get_theme_config(){

				

		if($this->current_theme["config"]){ return $this->current_theme["config"];}

		

	    if(!is_dir($this->current_theme["theme_path"])){ return false;}									

	

        if(!is_file($this->current_theme["config_path"])){ return false;}									

	    

		$configxml = file_get_contents($this->current_theme["config_path"]);



		$config = $this->xml2array($configxml);

		

        $templates = $config["templates"]["template"];



		if(is_array($templates) && is_array(@$templates[0])){

		   foreach($templates as $tpl){

           	    $tpl["positions"] = $tpl["positions"]["position"];			   

			    $this->current_theme["config"]["templates"][$tpl["name"]]=$tpl;    

			    if($tpl["type"]=="default"){

                   $this->current_theme["config"]["templates"]["default"]=$tpl;   

			    }

			}

		}else{

			

			$templates["positions"] = $templates["positions"]["position"];			   

			    $this->current_theme["config"]["templates"][$templates["name"]]=$templates;    

			    if($templates["type"]=="default"){

                   $this->current_theme["config"]["templates"]["default"]=$templates;   

			    }

			

		}

		unset($config["templates"]);

		$this->current_theme["config"] = array_merge($config,$this->current_theme["config"]);

		

		return $this->current_theme;

		

	}   

   

   function get_theme(){

	   return $this->current_theme;

   }

    

   function get_custom_positions_html(){

	   

	   if(is_array($this->CI->output->positions_ouput)){
          

		

		  foreach($this->CI->output->positions_ouput as $pos => $poshtml){

			 

			  foreach($poshtml as $phtml){

			     if($phtml['overwrite']==true){

				    $this->template_pos_html[$pos] = array();

			     }

				 $this->template_pos_html[$pos][] = $phtml["html"];
                 

			  

			  }

			

		  }

		}

		

		return $this->template_pos_html;

	   

   }

	

   function get_positions_html(){

	  

	   if(@$this->CI->output->template!=""){

		  $this->template_pos = $this->current_theme["config"]["templates"][$this->CI->output->template]["positions"];  

	   }else{

	     $this->template_pos = $this->current_theme["config"]["templates"]['default']["positions"];  

	   }

	

	   

	    $this->template_pos_html = array();

	   

	   if(is_array($this->template_pos)){

		   foreach($this->template_pos as $pos){

			   if(is_file($this->current_theme["theme_path"]."/".$pos.".php")){

				   ob_start();

				   include $this->current_theme["theme_path"]."/".$pos.".php";

		           $this->template_pos_html[$pos][] = ob_get_clean();



			   }

		   }

		   

	   }else{

		

			   if(is_file($this->current_theme["theme_path"]."/".$this->template_pos.".php")){

				   ob_start();

				   include $this->current_theme["theme_path"]."/".$this->template_pos.".php";

		           $this->template_pos_html[$this->template_pos][] = ob_get_clean();



			   }

		

		   

		}

		

		

		 $this->get_custom_positions_html();

		 $this->template_pos_html["content"][] = $this->CI->output->get_output();



	   return $this->template_pos_html;

	   

   }	

   

   function get_template(){

	 
	   if(@$this->CI->output->template!=""){

		  $template_path = $this->current_theme["theme_path"]."/".$this->current_theme["config"]["templates"][$this->CI->output->template]["file"];  

	   }else{

	     $template_path = $this->current_theme["theme_path"]."/".$this->current_theme["config"]["templates"]['default']["file"];  

		}


		if(is_file($template_path)){

			ob_start();

			include ($template_path);

		    $this->template_html  = ob_get_clean();

		}else{

		   $this->template_html = "{content}";	

	  	}

	 

	 return $this->template_html;

	   

   }	

	   

	function load_theme(){

		

		     $this->get_theme_config();



             $this->get_positions_html();

			 

			return $this->get_template();

	 

    }	

	

	// status : 0 = error,1 = ok, 2= session out

	function _display($output = ''){

            

	        $reqtype = $this->CI->input->get_post('reqtype', TRUE);

		

			if($reqtype == 'ajax'){ 

				$positions = array();

				$this->get_custom_positions_html();

                foreach($this->template_pos_html as $pos => $tpl_pos){

					

	            	 $poshml = join("",$tpl_pos);

				     $positions[$pos] = iconv('UTF-8', 'UTF-8//IGNORE', $poshml);


                }

			

			     $tpl_row_html = json_encode($positions,JSON_HEX_TAG);	

                 
                 
				// echo json_last_error();
                $tpl_row_html = $this->replace_ms_links($tpl_row_html, "link_ajax");
				  

			 }else{

				 $tpl_row_html = $this->load_theme(); 
                 
                 foreach($this->template_pos_html as $pos => $tpl_pos){

	            	$poshml = join("",$tpl_pos);

				    $tpl_row_html = str_replace("{".$pos."}", $poshml, $tpl_row_html);
                    
                    
                    
                    $tpl_row_html = $this->replace_ms_links($tpl_row_html, "link_http");

                }
                

			 }

            $this->CI->load->model('cms_model');
            $page_slug = explode("-", $this->CI->uri->segment(2));
            $page_id = end($page_slug);
            $page_details = $this->CI->cms_model->get_pages($page_id);
            $title = (isset($page_details[0]->meta_title) && !empty($page_details[0]->meta_title) && is_numeric($page_id)) ? $page_details[0]->meta_title : $this->CI->config->item('site_name');
        
            $metadata ='';
            if(isset($page_details[0]->meta_keywords) && !empty($page_details[0]->meta_keywords) && is_numeric($page_id)){
                $metadata.= '<meta name="keywords" content="'.$page_details[0]->meta_keywords.'" />';
            }
            if(isset($page_details[0]->meta_desc) && !empty($page_details[0]->meta_desc) && is_numeric($page_id)){
                $metadata.= '<meta name="description" content="'.$page_details[0]->meta_desc.'" />';
            }
            
	    $tpl_row_html = str_replace("{activemenu}", $this->CI->active_menu, $tpl_row_html);

            $tpl_row_html = str_replace("{title}", $title, $tpl_row_html);

            $tpl_row_html = str_replace("{css_path}", $this->current_theme["css_path"], $tpl_row_html);

            $tpl_row_html = str_replace("{js_path}", $this->current_theme["js_path"], $tpl_row_html);

            $tpl_row_html = str_replace("{image_path}", $this->current_theme["image_path"], $tpl_row_html);

            $tpl_row_html = str_replace("{base_url}", $this->current_theme["base_url"], $tpl_row_html);

	    $tpl_row_html = str_replace("{metadata}", $metadata, $tpl_row_html);
            
             if('backend' != $this->CI->get_app_environment()) {
               
            $tpl_row_html = str_replace("{site_name}", $this->current_theme["site_name"], $tpl_row_html);
            
             
             }       
            
            
			if($this->CI->config->item('developer_profiling')){

				 $this->CI->load->library('profiler');

                 
				 $tpl_row_html = str_replace("{profiler}", $this->CI->profiler->run(), $tpl_row_html);
                 
                // $pro_data = $this->CI->profiler->run();
                // $file_data = file_get_contents('profiler_data.html');
                // file_put_contents('profiler_data.html', $pro_data."\r\n".$file_data);
                 
                // $tpl_row_html = "";

			
				}else{

				  $tpl_row_html = str_replace("{profiler}","", $tpl_row_html);

				}

             $this->CI->output->memory_get_peak_usage[] =  memory_get_peak_usage();

			 gc_enable();

          	 if(gc_enabled()){ gc_collect_cycles();}

             gc_disable();	

			

            if($reqtype == 'ajax'){

				//echo $tpl_row_html;

				$result = array();

				

				$result['xhttprequestid'] = $this->CI->input->get_post('xhttprequestid');

				$result['showprocess'] = $this->CI->input->get_post('showprocess');

				$result['status'] = $this->CI->output->status;

				$result['message'] = $this->CI->output->message;

				$result['notifications'] = $this->CI->output->get_notifications_output();

                $result['popup'] = $this->CI->output->get_popup_output();				

				$result['closepopup'] = $this->CI->output->closepopup;

                $result['moveto'] = $this->CI->output->moveto;
				
				$result['set_focus_to'] = $this->CI->output->set_focus_to;
				
				
                
                //$result['loader'] = $this->CI->output->loader;
                
				$result['memory_get_peak_usage'] = json_encode($this->CI->output->memory_get_peak_usage);

				$tpl_row_html = json_decode($tpl_row_html);
             
				if(!is_array($tpl_row_html) && !empty($tpl_row_html)){

				if($this->CI->config->item('developer_profiling')){
                 
				   $tpl_row_html->profiler = $this->CI->profiler->run();
		                 
				}else{

				   $tpl_row_html->profiler = "";

				}

			    }

				$result['position'] = $tpl_row_html;

				

				echo json_encode($result);

				die();

			

			}else{

				  $this->CI->output->enable_profiler(FALSE);

                  $this->CI->output->set_output($tpl_row_html);
                  
                  close_db_con();
                  
			      $this->CI->output->_display();

			}



	}

	

	// XML to Array

	function xml2array(&$string) {

	

		$array = json_decode(json_encode((array)simplexml_load_string($string)),1);

	

		return $array; 

	}
    
    
    
    //Replace Ms Links
    
    function replace_ms_links($request_html = "", $link_request_type = ""){
         $start = "[";
        $finish = "]";
        $content = array();
        $replaced_html = $request_html;
        
        
        
        
        $startDelimiterLength = strlen($start);
        $endDelimiterLength = strlen($finish);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($request_html, $start, $startFrom))) {
          $contentStart += $startDelimiterLength;
          $contentEnd = strpos($request_html, $finish, $contentStart);
          if (false === $contentEnd) {
            break;
          }
          $content[] = substr($replaced_html, $contentStart, $contentEnd - $contentStart);
          $startFrom = $contentEnd + $endDelimiterLength;
        }
        
        
        
        foreach($content as $link_shortcode){
            $ms_shortcode = $link_request_type == "link_ajax"?stripslashes($link_shortcode):$link_shortcode;
            
            
            $shortcode_params = explode(" ", $ms_shortcode);
            
            if($shortcode_params[0] == "MS_Links"){
                // Get slug links and data qr
                $slug_data = explode("=", $shortcode_params[1]);
                $link_classes = explode("=", $shortcode_params[2]);
                $extra_data = explode("=", $shortcode_params[3]);
                
                // Replace " and , in the data
                $slug = str_replace('"', '', $slug_data[1]);
                $classes = str_replace(",", " ", str_replace('"', '', $link_classes[1]));
                $dataqr = str_replace(",", " ", str_replace('"', '', $extra_data[1]));
                
             
                
                // Get Link
                
                
               $ms_link = load_link($slug, $classes, $dataqr);
                
                $actual_ms_link = $link_request_type == "link_ajax"?addslashes($ms_link):$ms_link;
                
                // Replace Link
                
                $replaced_html = str_replace("[$link_shortcode]", $actual_ms_link, $replaced_html);
                
            }
        }
        
        
        
        return $replaced_html;


    }

	

}