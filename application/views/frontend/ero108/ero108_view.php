

<div class="call_purpose_form_outer event_outer">

    
    <div class="event_outer_inner" >
        
        <h2 class="text_align_center">Incident Details</h2><br>


        <form method="post" name="event_add_form" id="event_add" >

            <div class="inline_fields outer_med_details width100">

                <div class="form_field width100 outer_inc_id">

                    <div class="label">Enter Incident Id<span class="md_field">*</span></div>

                    <div class="input">

                        <input name="event_id" id="cmadv_incid" tabindex="1" value="<?php echo $event_id;?>" class="form_input filter_required filter_no_whitespace" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Event Id should not be blank',filter_no_whitespace:'White space not allowed'}">

                    </div>


                </div>


                <div class="form_field width100">

                    <div class="label none_prop">&nbsp;</div>
                    
                        <input name="user_ref_id" value="<?php echo $user_ref_id;?>" class="form_input" placeholder="Enter user ref Id" type="hidden" data-base="search_btn">
                    

                    <input name="search_btn" tabindex="2" value="Submit" class="style3 base-xhttp-request" data-href="{base_url}calls/save_ero108" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=yes" type="button">

                </div> 


            </div>

        </form>
    </div>

<!--    
 <form method="post" name="amb_form" id="amb_list">  
            
        <div id="amb_filters"></div>
            
            <div id="list_table">
            
            
                <ul class="" style="border: 1px solid #faae31;  width: 30%; margin:0 auto; ">

                    <li style="border-bottom: 1px solid #faae31; padding-left: 10px; font-weight: bold; height:30px; line-height:30px;">State District City</li>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    foreach($result as $value){  
                       ?>
                    <li style="padding-left: 10px; border-bottom: 1px solid #e8e8e8; height:30px; line-height:30px;">
                        <?php echo $value->st_name;?> <?php echo $value->dst_name;?> <?php echo $value->cty_name;?>   
                    </li>
                     <?php } }else{   ?>

                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>
                    
                 <?php } ?>   

                </ul>
                
      
            </div>
        </form>-->

</div>