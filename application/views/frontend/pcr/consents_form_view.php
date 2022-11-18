<script>cur_pcr_step(2);</script>

<?php $args=get_lang();  

 $update_time = explode(" ",$consent_data[0]->cons_time);?>

<form enctype="multipart/form-data" action="#" method="post" id="consent_form">
        <div class="width1">
            
            <div class="head_outer"><h3 class="txt_clr2 width1">CONSENTS FORM</h3> </div>
            
            <input type="hidden" name="pcr_id" value="<?php echo $pcr_id; ?>">
             
           <div class="outer_consents">
             
                <div class="select_left">
                    
                    
                        <div class="filed_input">
                            <div class="field_lable"><label for="">Consents Name<span class="md_field">*</span></label></div>
                            <div class="filed_input">

                                <select id="group" name="cons_name" class="filter_required change-base-xhttp-request" data-href="{base_url}pcr/consent_name_info" data-base="lang" data-qr="output_position=get_details" data-errors="{filter_required:'Please select consents name from dropdown list'}" TABINDEX="1" >
                                     <option value="">Select Name</option>
                                   
                                     <?php echo consents_info($consent_data[0]->cons_name);?>
                                   
                                </select>
                            </div>
                        </div>
                    
                    
                </div>
                    
                      
                     <div class="select_middle">
                        <div class="filed_row">
                    
                            <div class="field_lable hide_class"><label for=""></label></div>
                    
                            <div id="parent_member">  
                                <?php   $selected_lang[$consent_data[0]->cons_lang] = "selected = selected";?>
                                <select name="lang" class="change-base-xhttp-request" data-href="{base_url}pcr/consent_name_info" data-qr= "output_position=get_details" data-base="cons_name" TABINDEX="2">

                                    <option value="">Select Language</option>
                                    <option value="en" <?php echo $selected_lang['en'];?>>English</option>
                                    <option value="hn" <?php echo $selected_lang['hn'];?>>Hindi</option>
                                    <option value="kn" <?php echo $selected_lang['kn'];?>>Kannada</option>

                                </select>

                            </div>
                            
                        </div>
            
                </div>
               </div>
             
             
              <div id="get_details">
                  
                   <?php  $lng_array= get_lang();
    
                    if(count($consent_info)>0){

                         foreach($consent_info as $con_value){  

                            $serialize_data = $con_value->cons_value;

                            $data = nl2br(get_lang_data($serialize_data,$lng_array[$lang]));           

                            ?>
                            <p><?php echo str_replace("{amb_services}",@$amb_services[0]->ovalue,$data);?> </p>

                    <?php } }?>

               </div>  
             
             
           <div class="outer_consents">
             
                <div class="select_left">
                    
                    
                        <div class="filed_input">
                            <div class="field_lable"><label for="">Consentee Name<span class="md_field">*</span></label></div>
                            <div class="filed_input">

                                <input type="text" name="consentee_name" value="<?php echo $consent_data[0]->cons_consentee_name;?>" class="filter_required" data-errors="{filter_required:'Consentee name should not be blank'}" placeholder="Consentee Name" TABINDEX="3">
                            </div>
                        </div>
                    
                    
                </div>
                    
                      
                    <div class="select_middle">
                        <div class="filed_row">
                    
                            <div class="field_lable rel_tp"><label for="">Relation</label></div>
                    
                            <div id="parent_member">                            
                                <select name="cons_rel" data-base=""  class="" data-errors="{filter_required:'Relation should not be blank'}" TABINDEX="4" >


                                    <option value="">Select Relation</option>     
                                    <?php echo get_relation($consent_data[0]->cons_relation);?>


                                </select>

                            </div>
                            
                        </div>
            
                     </div>
               
                    <div class="select_right">
                        <div class="filed_row">
                        <?php $date = new \DateTime();?>
 
                            <span class="time_con">Time: <b><?php if(empty($consent_data)){ echo date_format($date, 'H:i:s'); }else{ echo $update_time[1];} ?></b></span>
                            <input type="hidden" name="cons_time"  value="<?php echo date_format($date, 'Y-m-d H:i:s') ;?>">                                                     
                        </div>
            
                     </div>
               </div>
                
                
              
                
                <div class="accept_outer">
                        
                         <input type="hidden" name="cons_sub_form" value="cons_form"/>
                         
                         <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}pcr/save_consents' data-qr='' TABINDEX="12">
                         
                       
                </div>
        </div>
        
        
           
    </form>
        <div class="next_pre_outer">
           <?php  $step = $this->session->userdata('pcr_details'); 
           if(!empty($step)){
           ?>
             <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(1)"> < Prev </a>
            <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(3)"> Next > </a>
           <?php } ?>
        </div>
