

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

<input type="hidden" name="amb" value="<?php echo @$demo_data[0]->dt_amb_ref_no; ?>" >
<input type="hidden" name="start_odometer" value="<?php echo @$demo_data[0]->dt_in_odometer; ?>" >

        <div class="joining_details_box">
            <?php if ($update) {
                ?>  
                <div class="field_row width100  fleet" ><div class="single_record_back">Previous  Info</div></div>
            <?php } ?>

            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state"><?php //var_dump($demo_data); ?>



                                <?php
                                // if (@$demo_data[0]->dt_state_code != '') {
                                //     $st = array('st_code' => @$demo_data[0]->dt_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                // } else {
                                //     $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                // }
                                if (@$demo_data[0]->dt_state_code != '') {
                                    $st = array('st_code' => @$demo_data[0]->dt_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }

                                //echo get_state_acc_ambulance($st);
                                echo get_state_demo_training_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="maintaince_district">
                                <?php
                                // if (@$demo_data[0]->dt_state_code != '') {
                                //     $dt = array('dst_code' => @$demo_data[0]->dt_district_code, 'st_code' => @$demo_data[0]->dt_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                // } else {
                                //     $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                // }
                                if (@$demo_data[0]->dt_district_code != '') {
                                    $dt = array('dst_code' => @$demo_data[0]->dt_district_code, 'st_code' => @$demo_data[0]->dt_state_code, 'amb_ref_no' => @$demo_data[0]->dt_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
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
                            <div id="maintaince_ambulance">



                                <?php
                                // if (@$demo_data[0]->dt_state_code != '') {
                                //     $dt = array('dst_code' => @$demo_data[0]->dt_district_code, 'st_code' => @$demo_data[0]->dt_state_code, 'amb_ref_no' => @$demo_data[0]->dt_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                // } else {
                                //     $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                // }

                                if (@$demo_data[0]->dt_state_code != '') {
                                 
                                    $dt = array('dst_code' => @$demo_data[0]->dt_district_code, 'st_code' => @$demo_data[0]->dt_state_code, 'amb_ref_no' => @$demo_data[0]->dt_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    
                                        echo get_break_maintaince_ambulance($dt);
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                     echo get_clo_comp_ambulance($dt);
                                }

                               // echo get_district_ambulance($dt);
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="demo[sc_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$demo_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>

                        </div>


                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type</div>

                            <div class="filed_input float_left width50">
                                <select name="demo[dt_shift_type]" tabindex="8" id="supervisor_list"   <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type(@$demo_data[0]->dt_shift_type); ?>
                                </select>

                            </div>
                        </div>

                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="demo[dt_pilot_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$demo_data[0]->dt_pilot_id; ?>" value="<?= @$demo_data[0]->dt_pilot_id; ?>" type="text" tabindex="1"  data-errors="{filter_required:'Pilot Id should not be blank'}"  placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="demo[dt_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$demo_data[0]->dt_pilot_name; ?>" TABINDEX="10"    <?php echo $update; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Id<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="demo[dt_emso_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'EMT Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_all_emso_id?emt=true" data-value="<?= @$demo_data[0]->dt_emso_id; ?>" value="<?= @$demo_data[0]->dt_emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_all_emso_id"  id="emt_list"   <?php echo $update; ?>>
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="demo[dt_emso_name]" tabindex="25" class="form_input filter_required" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= @$demo_data[0]->dt_emso_name; ?>"   <?php echo $update; ?>>
<!--                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">-->
                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">District Manager<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
<!--                            <input name="demo[dt_district_manager]" tabindex="25" class="form_input filter_required" placeholder="District Manager" type="text" data-base="search_btn" data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$demo_data[0]->dt_district_manager; ?>"   <?php echo $update; ?>>-->
                            <input name="demo[dt_district_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= @$demo_data[0]->dt_district_manager; ?>" value="<?= @$demo_data[0]->dt_district_manager; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager Name should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content'>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Place<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="demo[dt_place]" tabindex="25" class="form_input filter_required" placeholder="Place" type="text" data-base="search_btn" data-errors="{filter_required:'Place should not be blank!'}" value="<?= @$demo_data[0]->dt_place; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">No of Trainees</label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="demo[dt_no_of_candidate]" tabindex="25" class="form_input filter_number" placeholder="No of Trainees" type="text" data-base="search_btn"  data-errors="{filter_number:'Enter number only'}" value="<?= @$demo_data[0]->dt_no_of_candidate; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Pupose of Training / Demo<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="demo[dt_pupose_of_training]" tabindex="25" class="form_input filter_required" placeholder="Pupose of training" type="text" data-base="search_btn" data-errors="{filter_required:'Pupose of training should not be blank!'}" value="<?= @$demo_data[0]->dt_pupose_of_training; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>

                </div>

                <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Demo Training Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="demo[dt_demo_previous_odometer]" value="<?= @$demo_data[0]->dt_demo_previous_odometer; ?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Fuel Filling Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" readonly='readonly'  <?php echo $update; ?>>


                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Last Updated Odometer<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  >
                            <input name="demo[dt_previous_odomete]" tabindex="25" class="form_input filter_required filter_maxlength[8]" placeholder="Previous Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Current Odometer should not be blank!',filter_maxlength:'Start Odometer at max 7 digit long.'}" value="<?= @$demo_data[0]->dt_previous_odometer; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Current odometer<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="demo[dt_in_odometer]" tabindex="25" class="form_input filter_required filter_maxlength[7]" placeholder="Current odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Current odometer should not be blank!',filter_maxlength:'Current Odometer at max 7 digit long.'}" value="<?= @$demo_data[0]->dt_in_odometer; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no"> Date / Time<span class="md_field">*</span></label></div>


                        <!--<div class="filed_input float_left width50" >-->
                        <div class="width50 float_left">
                            <input name="demo[dt_start_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Start Date / Time" type="text"  data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$demo_data[0]->dt_start_date_time; ?>"   <?php echo $update; ?>>
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <select name="demo[dt_standard_remark]" tabindex="8" id="supervisor_list" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $update; ?> > 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="demo_training_register_sucessfully"  <?php
                                    if (@$demo_data[0]->dt_standard_remark == 'demo_training_register_sucessfully') {
                                        echo "selected";
                                    }
                                    ?>   >Demo Training Register Sucessfully</option>
                                   

                            </select>
                        </div>
                    </div>

                </div>

                <div class="field_row width100">

                    <div class="field_lable float_left width_16"> <label for="mobile_no">Remark<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width75 "  >
                        <textarea style="height:60px;" name="demo[dt_remark]" class="width100 filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php echo $update; ?>><?= @$demo_data[0]->dt_remark; ?></textarea>

                    </div>


                </div>
                <?php if ($update) { ?>  
                    <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>
                    <div class="field_row width100">
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"> <label for="mobile_no">End Odometer<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50 "  >
                                <input name="demo[dt_end_odometer]" tabindex="25" class="form_input filter_maxlength[8] filter_valuegreaterthan[<?php echo @$demo_data[0]->dt_in_odometer;?>]" placeholder="End Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'End Odometer should not be blank!',filter_maxlength:'END Odometer at max 7 digit long.',filter_valuegreaterthan:'END Odometer should equal to or greater than current Odometer'}" value="<?= @$demo_data[0]->dt_end_odometer; ?>" >
                            </div>
                        </div>
                        
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                 <input name="demo[dt_current_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?= @$scene_data[0]->dt_current_date_time; ?>"  >
                            </div>
                        </div>
                    </div>
                    
                     <div class="field_row width100">
                                 <div class="width2 float_left">
                <div class="field_lable float_left width33"> <label for="district_manager">Remark<span class="md_field">*</span></label></div>
                                            <div class="width50 float_left">
                                   <input name="demo[dt_current_remark]" tabindex="20" class=" filter_required" placeholder="Remark" type="text"  data-errors="{filter_required:'District manager should not be blank!'}" value="<?= @$scene_data[0]->cs_district_manager; ?>"  >
                             
                            </div>

                                 </div></div>

                </div>
            <?php } ?>
            <?php if ($update) { ?>  

                <input type="hidden" name="demo[dt_id]" id="ud_clg_id" value="<?= @$demo_data[0]->dt_id ?>">

            <?php } ?>





            <div class="button_field_row  margin_auto float_left width100 text_align_center">
                <div class="button_box">

                    <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_demo_training<?php } else { ?>registration_demo_training<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                    <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->          
                    <!--<input type="hidden" name="clg_data" value=<?php echo $data; ?>>-->
                </div>
            </div>



            </form>

