
<div class="register_outer_block">
    
    <div class="box3">
      
        <form method="post" action="" id="manage_team">   
            
            <input type="hidden" name="rto_no" id="amb_id" value="<?php echo $rto_no;?>">
            
                 <h2 class="txt_clr2 width1 txt_pro">Manage Team</h2>      
            <h4>Ambulance details</h4>  
            
            <?php 
                if(count($get_amb_details)>0){
                    foreach($get_amb_details as $details){ ?>
            
                        <div class="outer_table_format width100">
                            <div class="float_left width50 border_right">                    
                                <div class="border_bottom paadding5">Mobile Number</div>
                                <div class="border_bottom paadding5">Register Number</div>
                                <div class="border_bottom paadding5">City</div>
                                <div class="border_bottom paadding5">Type</div>
                                <div class="paadding5">Status</div>                    
                            </div>
                            <div class="float_right width50">                    
                                <div class="border_bottom paadding5"><?php echo $details->amb_default_mobile; ?></div>
                                <div class="border_bottom paadding5"><?php echo $details->amb_rto_register_no?></div>
                                <div class="border_bottom paadding5"><?php echo @$cty_name;?></div>
                                <div class="border_bottom paadding5"><?php echo @$amb_type;?></div>
                                <div class="paadding5"><?php echo @$amb_sts; ?></div>  
                            </div>
                        </div>

            <?php   }
               }?>
            
            <div class="field_row width100">
            
                <div class="shift width20 float_left"><label for="sft1">Shift1</label></div>

                <div class="shift width40 float_left">
                  

                    <input name="pilot[1]" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>auto/get_clg" data-value="<?php echo $first_shift_pilot;?>-<?php echo $first_shift_pilot_name;?>" value="<?php echo $first_shift_pilot;?>" type="text" tabindex="1" placeholder="Pilot Name" data-errors="{filter_required:'Pilot should not blank'}" >
                    
                    
                    
                </div>
                
                <div class="shift width40 float_left">
                    
                 
                    <input name="emt[1]" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>auto/get_clg?emt=true" data-value="<?php echo $first_shift_emt;?>-<?php echo $first_shift_emt_name;?>" value="<?php echo $first_shift_emt;?>" type="text" tabindex="2" placeholder="EMT Name" data-errors="{filter_required:'EMT should not blank'}" >
                </div>
                
            </div>
            
            <div class="field_row width100">
            
                <div class="shift width20 float_left"><label for="sft2">Shift2</label></div>                

                <div class="shift width40 float_left">

                    <input name="pilot[2]" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>auto/get_clg" data-value="<?php echo $second_shift_pilot;?>-<?php echo $second_shift_pilot_name;?>" value="<?php echo $second_shift_pilot;?>" type="text" tabindex="1" placeholder="Pilot Name" data-errors="{filter_required:'Pilot should not blank'}">
                </div>

                <div class="shift width40 float_left">                   

                    <input name="emt[2]" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>auto/get_clg?emt=true" data-value="<?php echo $second_shift_emt;?>-<?php echo $second_shift_emt_name;?>" value="<?php echo $second_shift_emt;?>" type="text" tabindex="2" placeholder="EMT Name" data-errors="{filter_required:'EMT should not blank'}" >
                </div>

            </div>
            
            <div class="field_row width100">
            
                <div class="shift width20 float_left"><label for="sft3">Shift3</label></div>                

                <div class="shift width40 float_left">
                    
                    <input name="pilot[3]" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>auto/get_clg" data-value="<?php echo $third_shift_pilot;?>-<?php echo $third_shift_pilot_name;?>" value="<?php echo $third_shift_pilot;?>" type="text" tabindex="1" placeholder="Pilot Name" data-errors="{filter_required:'Pilot should not blank'}">
                    
                </div>
                
                 <div class="shift width40 float_left">
                     
                   
                    <input name="emt[3]" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>auto/get_clg?emt=true"  data-value="<?php echo $third_shift_emt;?>-<?php echo $third_shift_emt_name;?>" value="<?php echo $third_shift_emt;?>" type="text" tabindex="2" data-errors="{filter_required:'EMT should not blank'}" placeholder="EMT Name">
                </div>
            </div>
            
            <div class="width40 margin_auto">
                <div class="button_field_row">
                    <div class="button_box">
                        
                        <input type="hidden" name="submit_amb_team" value="sub_amb_team" />
                         
                        <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>amb/add_manage_team' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">
                    </div>
                </div>
            </div>
            
        </form>                
    </div>       
</div>