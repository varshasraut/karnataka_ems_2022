<script>
if(typeof H != 'undefined'){
    init_auto_address();
}
</script>


<?php
if ($type == 'Update') {
    $update = 'disabled';
}
?>


<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">
            <?php if ($update) {
                ?>  
                <div class="field_row width100  fleet" ><div class="single_record_back">Previous  Info</div></div>
            <?php } ?>

            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                if (@$vehical_data[0]->vl_state_code != '') {
                                    $st = array('st_code' => @$vehical_data[0]->vl_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_vahicle_change_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_district">
                                <div >
                                    <?php
                                    if (@$vehical_data[0]->vl_state_code != '') {
                                        $dt = array('dst_code' => @$vehical_data[0]->vl_district_code, 'st_code' => @$vehical_data[0]->vl_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                    } else {
                                        $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                    }

                                    echo get_district_acc_amb($dt);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <div id="incient_ambulance">



                                    <?php
                                    if (@$vehical_data[0]->vl_state_code != '') {
                                        $dt = array('dst_code' => @$vehical_data[0]->vl_district_code, 'st_code' => @$vehical_data[0]->vl_state_code, 'amb_ref_no' => @$vehical_data[0]->vl_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                    } else {
                                        $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                    }


                                    echo get_clo_comp_ambulance($dt);
                                    ?>

                                </div>

                            </div>

                        </div>

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50" id="amb_base_location">
                                <input name="vehical[vl_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$vehical_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>

                            </div>


                        </div>
                        <div class="field_row width100">
                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"><label for="city">Shift Type</label></div>

                                <div class="filed_input float_left width50">
                                    <select name="vehical[vl_shift_type]" tabindex="8" id="supervisor_list"  <?php echo $update; ?>> 
                                        <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                        <?php echo get_shift_type(@$vehical_data[0]->vl_shift_type); ?>
                                    </select>

                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="field_row width100" id="maintance_previous_odometer">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="previous_odometer">Last Updated Odometer<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50 "  >
                                <input name="vehical[vl_prevoius_odometer]" tabindex="25" class="form_input filter_required filter_maxlength[8]" placeholder="Previous Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Previous Odometer should not be blank!',filter_maxlength:'Previous Odometer at max 7 digit long.'}" value="<?= @$vehical_data[0]->vl_previous_odometer; ?>"   <?php echo $update; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Current Odometer<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <input name="vehical[vl_in_odometer]" tabindex="25" class="form_input filter_required filter_maxlength[8]" placeholder="Current Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'In Odometer should not be blank!',filter_maxlength:'Current Odometer at max 7 digit long.'}" value="<?= @$vehical_data[0]->vl_in_odometer; ?>"   <?php echo $update; ?>>
                            </div>
                        </div>

                    </div>
                     <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id</label></div>

                        <div class="filed_input float_left width50">

                            <input name="vehical[vl_pilot_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'Pilot Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$vehical_data[0]->vl_pilot_id; ?>" value="<?= @$vehical_data[0]->vl_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="vehical[vl_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$vehical_data[0]->vl_pilot_name; ?>" TABINDEX="10"    <?php echo $update; ?>>
                        </div>
                    </div>
                </div>

                    <div class="field_row width100">

                        <div class="field_lable float_left width_16"><label for="district">Address <span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width75">

                            <?php
                            if (@$vehical_data[0]->vl_google_address) {
                                $work_address = @$vehical_data[0]->vl_google_address;
                            }
                            ?>
                            <input name="vehical[vl_google_address]" value="<?php echo $work_address; ?>" id="pac-input" class="incient filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Google location map address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="incient" data-auto="inc_auto_addr" style="width:99%" <?php echo $update; ?>> 


                        </div>
                    </div>
                    <!--                <div class="field_row width100">
                    
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50"> <div id="incient_state">
                    
                    
                    
                    <?php
                    if (@$vehical_data[0]->vl_state_code != '') {
                        $st = array('st_code' => @$vehical_data[0]->vl_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                    } else {
                        $st = array('st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                    }


                    echo get_state_tahsil($st);
                    ?>
                    
                                                </div>
                    
                                            </div>
                    
                                        </div>
                                        <div class="width2 float_left">    
                                            <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                                                <div id="incient_dist">
                    <?php
                    if (@$vehical_data[0]->vl_state_code != '') {
                        $dt = array('dst_code' => @$vehical_data[0]->vl_district_code, 'st_code' => @$vehical_data[0]->vl_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                    } else {
                        $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                    }


                    echo get_district_tahsil($dt);
                    ?>
                                                </div>
                    
                    
                    
                    
                    
                                            </div>
                                        </div>
                                    </div>-->

                    <div class="field_row width100">




                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">Reason for change<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">

                                <input name="vehical[vl_reason_for_change]" tabindex="20" class=" filter_required" placeholder="Reason for change" type="text"  data-errors="{filter_required:'Reason for change should not be blank!'}" value="<?= @$vehical_data[0]->vl_reason_for_change; ?>"  <?php echo $update; ?>>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="voucher_no">Expected date/Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="vehical[vl_expecteed_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Expected date/Timee" type="text"  data-errors="{filter_required:'Expected date/Timee should not be blank!'}" value="<?= @$vehical_data[0]->vl_expecteed_date_time; ?>"   <?php echo $update; ?>>
                            </div>
                        </div>


                    </div>

                    <div class="field_row width100">


                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <select name="vehical[vl_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="ambulance_location_change"  <?php
                                    if (@$vehical_data[0]->vl_standard_remark == 'ambulance_location_change') {
                                        echo "selected";
                                    }
                                    ?> >Ambulance Location Change </option>
                                    <option value="other"  <?php
                                    if (@$vehical_data[0]->vl_standard_remark == 'other') {
                                        echo "selected";
                                    }
                                    ?>>other</option> 

                                </select>
                            </div>

                        </div>
                        <div class="width2 float_left">
                            <div id="remark_other_textbox">
                            </div>
                        </div>

                    </div>



                    <?php
                    if ($update) {
                        $previous_odo = @$vehical_data[0]->vl_in_odometer;
                        ?>  
                        <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>


                        <input type="hidden" name="previous_odometer" value="<?= @$vehical_data[0]->vl_in_odometer; ?>">
                        <input type="hidden" name="maintaince_ambulance" value="<?= @$vehical_data[0]->vl_amb_ref_no; ?>">

                        <div class="field_row width100">

                            <div class="field_lable float_left width_16"><label for="district">Address <span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width75">

                                <?php
                                if (@$vehical_data[0]->vl_current_google_address) {
                                    $address = @$vehical_data[0]->vl_current_google_address;
                                }
                                ?>
                                <input name="vehical[vl_current_google_address]" value="<?php echo $address; ?>" class="incient filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="address" style="width:99%"> 


                            </div>
                        </div>

                        <div class="field_row width100">
                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                                <div class="filed_input float_left width50" >
                                    <input type="text" name="vl_end_odometer" value="<?= @$vehical_data[0]->vl_end_odometer; ?>" class="filter_required filter_valuegreaterthan[<?php echo $previous_odo; ?>]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should <?php echo $previous_odometer; ?>'}" TABINDEX="8" <?php
                                    if (@$vehical_data[0]->vl_end_odometer != '') {
                                        echo "disabled";
                                    }
                                    ?>>


                                </div>
                            </div>
                            <div class="width2 float_left">

                                <div class="field_lable float_left width33"><label for="mt_onroad_datetime"> Date/Time<span class="md_field">*</span></label></div>

                                <div class="filed_input float_left width50" >
                                    <input type="text" name="vehical[vl_on_road_ambulance]"  value=" <?php
                                    if (@$vehical_data[0]->vl_on_road_ambulance != '0000-00-00 00:00:00' && @$vehical_data[0]->vl_on_road_ambulance != '') {
                                        echo @$vehical_data[0]->vl_on_road_ambulance;
                                    }
                                    ?>" class="filter_required mi_timecalender" placeholder=" Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php
                                           if (@$vehical_data[0]->vl_on_road_ambulance != '0000-00-00 00:00:00' && @$vehical_data[0]->vl_on_road_ambulance != '') {
                                               echo "disabled";
                                           }
                                           ?>>



                                </div>
                            </div>
                        </div>
                        <div class="field_row width100">
                            <div class="filed_input float_left width2">

                                <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50">
                                    <select name="vehical[vl_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                        <option value="">Select Standard Remark</option>
                                        <?php if ($update) { ?>  <option value="location_change"  <?php
                                            if (@$vehical_data[0]->mt_on_stnd_remark == 'location_change') {
                                                echo "selected";
                                            }
                                            ?>>Ambulance Location Changed</option>  <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50" >
                                    <textarea style="height:60px;" name="vehical[vl_on_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$vehical_data[0]->vl_on_remark; ?></textarea>
                                </div>
                            </div>
                        </div>


                    <?php } ?>

                    <?php if ($update) { ?>  

                        <input type="hidden" name="vehical[vl_id]"  value="<?= @$vehical_data[0]->vl_id ?>">

                    <?php } ?>



                    <div class="button_field_row  margin_auto float_left width100 text_align_center">
                        <div class="button_box">

                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_vehical_location<?php } else { ?>registration_vehical_location_change<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                            <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->              
                            <!--<input type="hidden" name="clg_data" value=<?php echo $data; ?>>-->
                        </div>
                    </div>

                    </form>
