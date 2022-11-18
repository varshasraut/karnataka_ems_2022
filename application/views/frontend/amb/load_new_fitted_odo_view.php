<div class="register_outer_block" id="closure_odo_div">

        <div class="box3">


            <div class="width1 float_left ">
               
                <div class="store_details_box">
                <div class="field_row width100">
                       
                       <div class="width2 float_left">
                           <div class="field_lable float_left width33"> Ambulance Number<span class="md_field">*</span></div>

                           <div class="filed_input float_left width50">

                               <input type="text" name="amb" class="filter_required" data-errors="{filter_required:'Registration Number should not be blank'}" value="<?php echo $amb; ?>" tabindex="1" autocomplete="off" disabled>

                               <input type="hidden" name="amb" class="filter_required" data-errors="{filter_required:'Registration Number should not be blank'}" value="<?php echo $amb; ?>" tabindex="1" autocomplete="off">
                           
                           </div>
                          
                       </div> 
                        </div>
                    <div class="field_row width100">
                       
                        
                        <div class="width2 float_left">
                            <div class="filed_lable float_left width33">Start Odometer<span class="md_field">*</span></div>
                            

                            <div class="filed_input float_left width50 " >
                                    
                                    <input readonly value="0" id="start_odometer_textbox_odo_change" type="text" name="start_odometer" value=""  tabindex="20" maxlength="7" class="form_input <?php echo $filter_rangelength; ?> filter_maxlength[8] filter_required filter_number filter_no_whitespace" data-errors="{filter_required:'Start Odometer should not be blank', filter_number:'Odometer Number should be in numeric characters only.',filter_no_whitespace:'Ambulance Mobile Number should not be allowed blank space.'}" placeholder="Enter Start Odometer" type="text" data-base="search_btn"   >

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> End Odometer<span class="md_field">*</span></div> 

                                <div class="field_input float_left width50"  >
                              
                                <input id="end_odometer_textbox_odo_change" type="text"  name="end_odometer" value="" maxlength="7" class="filter_required filter_number filter_no_whitespace" data-errors="{filter_required:'End Odometer should not be blank', filter_number:'Odometer Number  should be in numeric characters only.',filter_no_whitespace:'Ambulance Mobile Number should not be allowed blank space.'}" placeholder="End Odometer"   data-base="search_btn" >      

                            </div>
                        </div>
                        
                    </div>
                    <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
    
                            
                            <textarea style="height:60px;" name="remark" class="filter_required" data-errors="{filter_required:'Remark should not be blank'}" value="" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?> > </textarea>
                            
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>    
      
        <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" />

    
            <div class="width_11 margin_auto">
                <div class="button_field_row">
                    <div class="button_box">

                    <input type="hidden" name="submit_amb" value="amb_reg" />

                         <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>amb/set_odometer'  data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12" >

                    </div>
                </div>
            </div>
    </div>