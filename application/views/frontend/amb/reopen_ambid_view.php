
<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">

<div class="register_outer_block">

    <div class="box3">

        <div class="width1 float_left ">

            <h2 class="txt_clr2 width1 txt_pro">Ambulance Reopen Details</h2>
            <div class="store_details_box">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> Assign Ambulance Number<span class="md_field">*</span>
                        </div>

                        <div class="filed_input float_left width50">

                            <input type="text" name="assign" class="filter_required" data-errors="{filter_required:'Registration Number should not be blank'}" value="<?php echo $update[0]->amb_rto_register_no; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?> disabled>

                            <input type="hidden" name="assign" class="filter_required" data-errors="{filter_required:'Registration Number should not be blank'}" value="<?php echo $update[0]->amb_rto_register_no; ?>" tabindex="1" autocomplete="off">
                        
                        </div>
                    </div> 


                    <div class="width2 float_left">
                        <div class="filed_lable float_left width33"><label for="amb_number">Enter Incident Id<span class="md_field">*</span></label>
                        </div>
                        
                    
                        <div class="filed_input float_left width50 " >
       
                                <input  name="incident_no" class=" filter_required mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_incident_odometer_change?amb_id=<?php  echo $update[0]->amb_rto_register_no; ?>" placeholder="Select Incident Id" data-errors="{filter_required:'Please select Incident Id from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $inc_ref_id; ?>" data-value="<?php echo $inc_ref_id; ?>" data-base="search_btn" TABINDEX="4">
                            
                        </div>

                    </div>

                    
                </div>
                <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="registration_number">Remark<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">


                        <textarea style="height:60px;" name="remark" class="filter_required" data-errors="{filter_required:'Remark should not be blank'}" value="" tabindex="1" autocomplete="off"  ></textarea>
                        
                        </div>

                    </div> 

                <!--<div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> Replacement Ambulance Number<span class="md_field">*</span></div>   

                            <div class="field_input float_left width50">
                           
                                <input name="replace" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_replace_ambulance_list" placeholder="Select Ambulance" data-errors="{filter_required:'Please select Ambulance Number from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>" data-base="search_btn">
                            </div>
                    </div>-->
                    

                </div>


            </div>

        </div>

    </div>    
  
    <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>" />

    <div class="width_11 margin_auto">
        <div class="button_field_row">
            <div class="button_box">

                <input type="hidden" name="submit_amb" value="amb_reg" />

                <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>amb/reopen_ambid_save'  data-qr='amb_id[0]=<?php echo base64_encode($update[0]->amb_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12" >

            </div>
        </div>
    </div>

 

</div>
</form>



