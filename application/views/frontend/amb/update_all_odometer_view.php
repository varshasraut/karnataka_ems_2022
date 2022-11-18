<?php
$view = ($amb_action == 'view') ? 'disabled' : '';

    $edit = 'readonly';
$CI = EMS_Controller::get_instance();

$title =  " Update Ambulance Odometer ";
?>


<form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
    <div class="register_outer_block">

        <div class="box3">


            <div class="width1 float_left ">
                <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
                <div class="store_details_box">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Registration Number<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter Ambulance No" id="amb_validation" name="update_odo[amb_rto_register_no]" class="filter_required filter_vehical_no" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->amb_rto_register_no; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?>>
                                  

                            </div>
                        </div> 
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Odometer Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                                
                                <?php 
                               
                                $odo_type = array('closure'=> "Case Closure",'preventive maintenance'=>'preventive maintenance','breakdown maintenance'=>'breakdown maintenance','update breakdown maintaince'=>'update breakdown maintaince','Chng_new_fitted_odometer'=>'New fitted odometer','old_closure'=>'Old Closure','onroad_offroad maintenance'=>'Onroad Offroad Maintenance','Updated from Back End'=>'Updated from Back End','fuel_filling_during_case'=>'fuel filling during case','oxygen_filling_during_case'=>'Oxygen Filling During Case','Updated from Back End'=>'Updated from Back End');
                                
                                 $odometer_type = str_replace('-',' ', ucfirst($update[0]->odometer_type));
                                   $odometer_type = str_replace('_',' ', ucfirst($odometer_type));
                                
                                ?>

                                <input type="text" placeholder="Odometer Type" name="update_odo[odometer_type]" class="filter_required" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $odometer_type; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?> disabled="disabled">
                                  

                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number"> Inc Ref Id<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter inc_ref_id" id="amb_validation" name="update_odo[inc_ref_id]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->inc_ref_id; ?>" tabindex="1" autocomplete="off" <?php echo $view; ?> <?php echo $edit; ?>>
                                <input type="text" style="display:none" placeholder="Enter inc_ref_id" id="amb_validation" name="update_odo[inc_ref_id_new]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->inc_ref_id; ?>" tabindex="1" autocomplete="off">   

                            </div>
                        </div> 
                         <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Start Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter Start Odometer" onkeyup="sum();" id="previous_odometer" name="update_odo[start_odmeter]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->start_odmeter; ?>" tabindex="1" autocomplete="off" >
                                  

                            </div>
                        </div> 
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">On Scene Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter On Scene Odometer" onkeyup="sum();" id="previous_odometer" name="update_odo[scene_odometer]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->scene_odometer; ?>" tabindex="1" autocomplete="off" >
                                  

                            </div>
                        </div> 
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">From Scene Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter From Scene Odometer" onkeyup="sum();" id="previous_odometer" name="update_odo[from_scene_odometer]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->from_scene_odometer; ?>" tabindex="1" autocomplete="off" >
                                  

                            </div>
                        </div> 
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Handover Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Handover Odometer" onkeyup="sum();" id="previous_odometer" name="update_odo[handover_odometer]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->handover_odometer; ?>" tabindex="1" autocomplete="off" >
                                  

                            </div>
                        </div> 
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Hospital Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Hospital Odometer" onkeyup="sum();" id="previous_odometer" name="update_odo[hospital_odometer]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->hospital_odometer; ?>" tabindex="1" autocomplete="off" >
                                  

                            </div>
                        </div> 
                         <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">End Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter End Odometer" onkeyup="sum();" id="end_odometer" name="update_odo[end_odmeter]" class="" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number'}" value="<?php echo $update[0]->end_odmeter; ?>" tabindex="1" autocomplete="off">
                                  

                            </div>
                        </div> 
                        
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="registration_number">Odometer Difference<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" placeholder="Enter End Odometer" id="distance" name="update_odo[total_km]" class="filter_rangelength[0-1000]" data-errors="{filter_required:'Registration Number should not be blank',filter_vehical_no:'Please enter valid Registration Number',filter_rangelength:'odometer difference between 0-1000'}" value="<?php echo $update[0]->total_km; ?>" tabindex="1" autocomplete="off">
                                  

                            </div>
                        </div> 
                    </div>
                    <!-- <div class="field_row width100">
                    <div class="width20">Remark : </div>
                    <div class="width50">
                    <textarea name='update_odo_remark' class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"></textarea>
                    </div>
                    </div> -->
                </div>


                </div>

                

            </div>

        </div>     



            <div class="width_11 margin_auto">
                <div class="button_field_row">
                    <div class="button_box">
                        
                         <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>amb/update_amb_odo_all'  data-qr='tm_id=<?php echo base64_encode($update[0]->id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                            <!--<input type="reset" name="reset" value="Reset" class="reset_btn" TABINDEX="13">-->
                    </div>
                </div>
            </div>


    </div>
</form>
<script>
function sum() {
      var txtFirstNumberValue = document.getElementById('previous_odometer').value;
      var txtSecondNumberValue = document.getElementById('end_odometer').value;
      var result =  parseInt(txtSecondNumberValue)- parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('distance').value = result;
      }
}

</script>