<?php



function group_link($link){



	 if(is_array($link)){return "<ul>".join("",$link)."</ul>";}else{ return $link;}



}







///$title,$show_title=false,$wrapper_class="",$active_slug	


/* Added by  MI-42
 * 
 *  This function is used to load navigation menu
 */


function load_navigation($arg){

    

  $data = array();



  $link_set = array();
  


  $CI =   get_instance();



  $CI->load->model('cms_model','cms');	



  if($arg['title'] == ""){return false;}



  $navigation = $CI->cms->get_navigation($arg['title']);
  

  if($navigation == false){return false;}
   
  
    if($CI->session->userdata('current_adv')->user_type!="")
    {
     
        $current_user_type=$CI->session->userdata('current_adv')->user_type;
  
        
    }
    else if($CI->session->userdata('current_user')->user_type!="")
    {
        $current_user_type=$CI->session->userdata('current_user')->user_type;
    }
    else if($CI->session->userdata('end_user')->user_type!="")
    {
        $current_user_type=$CI->session->userdata('end_user')->user_type;
    }
    
    
//    var_dump($current_user_type);die;
    
    $link_user_type = isset($arg['user_type'])?$arg['user_type']:$current_user_type;
    
    
    
    $navigation_lnk = $CI->cms->get_navigation_link(array('nav' => $navigation->nav_id,'user_type' => $link_user_type));
    
    
    
   for( $i=0 ; $i < count($navigation_lnk) ;$i++){
       if($navigation_lnk[$i]->lnk_nav_id == '1' && $navigation_lnk[$i]->lnk_id == '54' && $navigation_lnk[$i]->lnk_slug == 'add_resume'){
           if(strtolower($link_user_type) == "seller" && strtolower($CI->session->userdata('current_user')->user_plan) != "paid plus"){
               unset($navigation_lnk[$i]);
           }
       }
   }
   
   
   
  $cnt = 0; 



  if($navigation_lnk){

      

      foreach($navigation_lnk as $link){
  
          
       $flag=0;

       $li = "li".$cnt++;



       if($link->lnk_section != ""){



         $li = "lis".$link->lnk_section;	



       }


	   if($arg['active_slug']!="" && $arg['active_slug'] == $link->lnk_slug){$active_class = "active";}else{$active_class = '';}
       

       
     $cls="";
     

   
     
      if($link->is_dropdown=="yes"){ 
       
           $cls="dropdown"; 
           
           $link_set[$li][] = "<li class='".$active_class." ".$cls."'>".get_link_html($link,@$arg['selector'][$link->lnk_slug],@$arg['dataqr'][$link->lnk_slug]);
         
           ?>

        <?php
           
        
         $CI->load->model('cms_model');	
         
         
         
          $navigation_lnk_childs = $CI->cms_model->get_navigation_link_childs($link->lnk_slug);
          
          
          if($navigation_lnk_childs>0){
        
                     $link_set[$li][]="<ul class='dropdown-content'>";
            
                    foreach($navigation_lnk as $link1){


                        if(($link1->lnk_parent==$link->lnk_slug)){

                               $arr[]=$link1->lnk_slug;
                               $link_set[$li][] = "<li class='".$active_class."  drop-down-list'>".get_link_html($link1,@$arg['selector'][$link1->lnk_slug],@$arg['dataqr'][$link1->lnk_slug])."</li>";

                        }

                    }
                
                        $link_set[$li][]="</ul>";
         
          }
                if($link->is_dropdown=="yes"){ 
                 $link_set[$li][] =  "</li>";
                
                }
               
        }  
        else if($link->lnk_parent=="")
       {
//            var_dump($link->lnk_slug);die;
            
            
         //   var_dump(@$arg['selector'][$link->lnk_slug]);
            
                    $link_set[$li][] = "<li class='".$active_class."'>".get_link_html($link,@$arg['selector'][$link->lnk_slug],@$arg['dataqr'][$link->lnk_slug])."</li>";
                    
           //         var_dump($link_set);die;
           
       }
       
      

     }
     
     
	 $link_set = array_map(group_link,$link_set);

 

  }

  


  $data['navigation'] = $navigation;

  

  $data['navigation_lnk'] = join("",$link_set);



  $data['show_title'] = $arg['show_title'];



  $data['wrapper_class'] = $arg['wrapper_class'];  

  

  $data['nav_type']  = $arg['nav_type']; 

  
  

  $str =  $CI->load->view('frontend/env/navigation_view',$data,true);

  

  return $str;  



}







function get_link_html($link,$class="",$dataqr=""){

        
        

	$CI =   get_instance();
 
    $CI->load->library('session');


	           $reserved_selectors = array('click-xhttp-request','change-xhttp-request','change-base-xhttp-request','form-xhttp-request','base-xhttp-request','onpage_popup', 'fixed_onpage_popup');



	



			   $link->tlcode = $link->lnk_slug; 

               if($link->lnk_type!='http'){
                   
                $qr['output_position']="content";
                
               }
               
			   $qr["tool_code"] = $tool->tlcode;


               parse_str($link->lnk_query_string, $dqr);


			   $tl_query_string = http_build_query(array_merge($qr,$dqr));


			    if($class && count(array_intersect($reserved_selectors,explode(" ",$class))) <= 0 ){



			      $class = "click-xhttp-request ".$class;



			   }
               
               
               

               if($class=="onpage_popup" || $class=="fixed_onpage_popup"){
                   
                   $class = $class;
                   
               } 
               else{
                   
                   $class = "click-xhttp-request ".$class;
                   
               }
               
               
			    if($link->lnk_type=='http'){
                $class="onpage_popup";}


				 if($link->lnk_type == 'http'){

                     
                        if($link->lnk_slug=='Terms'){
                            
                            $pgid=explode("=",$link->lnk_query_string);
                            
                            $CI->session->set_userdata('tc_page_no',$pgid[1]);
                                
                        }
                         
                        
                        
                    if($tl_query_string!=''){
                        $action = "<a class='$link->tlcode $class' href='$link->lnk_url?$tl_query_string' data-name='$link->lnk_name'>".$link->lnk_name."</a>"; 
                    }
                     else{
                         $action = "<a class='$link->tlcode $class' href='$link->lnk_url'  data-name='$link->lnk_name'>".$link->lnk_name."</a>"; 
                     }
					
                    

				 }else{				   

                     

				   $action = "<a class=\"$link->tlcode $class\" href=\"$link->lnk_url\" data-qr=\"$tl_query_string\" ".$dataqr."  data-name='$link->lnk_name'>".$link->lnk_name."</a>";  
                   
                   
       

			  }



			return $action;




}







function load_link($slug, $class = "", $dataqr = ""){

    

	if($slug == ""){ return false;}



	$CI =   get_instance();



    $CI->load->model('cms_model','cms');	

    

    $navigation_lnk = $CI->cms->get_navigation_link(array('slug' => $slug));	
    
    
    
    
    
    return $navigation_lnk?get_link_html($navigation_lnk[0], $class, $dataqr):"<a></a>";
    



}







