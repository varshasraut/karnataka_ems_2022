<script>
//if(typeof H != 'undefined'){
    //init_auto_address();
//}
</script>

<?php
if ($type == 'Update') {
    $disabled = 'disabled';
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
                                if (@$scene_data[0]->cs_state_code != '') {
                                    $st = array('st_code' => @$scene_data[0]->cs_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_dist">

                            

                                <?php
                                if (@$scene_data[0]->cs_state_code != '') {
                                    $dt = array('dst_code' => @$scene_data[0]->cs_district_code, 'st_code' => @$scene_data[0]->cs_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }

                                echo get_district_amb($dt);
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
                                //var_dump($scene_data[0]->cs_amb_ref_no);
                                    if (@$scene_data[0]->cs_amb_ref_no != '') {
                                        $dt = array('dst_code' => @$scene_data[0]->cs_district_code, 'st_code' => @$scene_data[0]->cl_state_code, 'amb_ref_no' => @$scene_data[0]->cs_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                    } else {
                                        $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                    }



                                echo get_district_ambulance($dt);
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="base_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$scene_data[0]->hp_name; ?>" readonly="readonly" <?php echo $disabled; ?>>

                        </div>


                    </div>
                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="shift_type">Shift Type</label></div>

                        <div class="filed_input float_left width50">

                            <select name="scene[cs_shift_type]" tabindex="8"   <?php echo $disabled; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                <?php echo get_shift_type(@$scene_data[0]->cs_shift_type); ?>
                            </select>


                        </div>
                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="shift_type">Add Challenge<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                         <input   type="text" name="scene[cs_challenge]" class="filter_required"  data-errors="{filter_required:'>Add Challenge should not be blank'}" value="<?= @$scene_data[0]->cs_challenge; ?>" TABINDEX="10"  <?php echo $disabled; ?>>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="scene[cs_pilot_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-errors="{filter_required:'Pilot Id should not be blank!'}"  data-value="<?= @$scene_data[0]->cs_pilot_id; ?>" value="<?= @$scene_data[0]->cs_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"  <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input   type="text" name="scene[cs_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$scene_data[0]->cs_pilot_name; ?>" TABINDEX="10"  <?php echo $disabled; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Id<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="scene[cs_emso_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'EMT Id should not be blank!'}"  data-href="<?php echo base_url(); ?>auto/get_all_emso_id?emt=true" data-value="<?= @$scene_data[0]->cs_emso_id; ?>" value="<?= @$scene_data[0]->cs_emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_all_emso_id"  id="emt_list"  <?php echo $disabled; ?>>
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="scene[cs_emso_name]" tabindex="25" class="form_input filter_required" placeholder="SHP Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= @$scene_data[0]->cs_emso_name; ?>"  <?php echo $disabled; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">District Manager<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">
                                <!-- <input data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="District Manager" type="text" name="visitor[vs_district_manager]" class="filter_required"  data-errors="{filter_required:'District Manager should not be blank'}" value="<?= @$visitor_data[0]->vs_district_manager; ?>" TABINDEX="10"  <?php echo $view; ?>> -->
                                <input name="demo[dt_district_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= @$visitor_data[0]->dt_district_manager; ?>" value="<?= @$visitor_data[0]->dt_district_manager; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager Name should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content'>

                            </div>
                        </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Place<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 " >
                            <input  name="scene[cs_place]"  placeholder="Place" type="text"  class="filter_required"  data-errors="{filter_required:'Visitor Name should not be blank'}" value="<?= @$scene_data[0]->cs_place; ?>" TABINDEX="10"   <?php echo $disabled; ?>>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Incident type<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input  name="scene[cs_incident_type]" placeholder="Incident type" type="text" name="stat[sc_pilot_name]" class="filter_required"  data-errors="{filter_required:'Incident type should not be blank'}" value="<?= @$scene_data[0]->cs_incident_type; ?>" TABINDEX="10"   <?php echo $disabled; ?>>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="dard_time">Date / Time<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="scene[cs_pre_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?= @$scene_data[0]->cs_pre_date_time; ?>"   <?php echo $disabled; ?>>
                        </div>
                    </div>

                </div>

                <div class="width100 float_left">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">No of patients<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input   type="text"  name="scene[cs_no_of_patient]" class="filter_required "  
                                     data-errors="{filter_required:'No of patient should not be blank'}" placeholder="No of patient" value="<?= @$scene_data[0]->cs_no_of_patient; ?>" TABINDEX="10"   <?php echo $disabled; ?>>
                        </div></div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no"> Informed to Police<span class="md_field">*</span></label></div>

                        <div class="filed_input width2 float_left">
                       <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                            <?php $police[@$scene_data[0]->cs_police] = "checked"; ?>

                            <div class="radio_button_div1">
                                <label for="police_y" class="radio_check float_left width50">  
                                    <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="police_y" type="radio" name="scene[cs_police]" value="yes" class="radio_check_input" data-errors="{}" <?php echo $police['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                </label>

                                <label for="police_n" class="radio_check float_left width50">  
                                    <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="police_n" type="radio" name="scene[cs_police]" value="no" <?php echo $police['no']; ?> class="radio_check_input" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder"></span>No
                                </label>
                            </div>
                        </div>
                        <!--<div class="filed_input float_left width50" >-->

                    </div>


                </div>



                <div class="field_row width100">


                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no"> Informed to Fire<span class="md_field">*</span></label></div>

                        <div class="filed_input width2 float_left">
                       <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                            <?php $fire[@$scene_data[0]->cs_fire] = "checked"; ?>

                            <div class="radio_button_div1">
                                <label for="fire_y" class="radio_check float_left width50">  
                                    <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_y" type="radio" name="scene[cs_fire]" value="yes" class="radio_check_input" data-errors="{}" <?php echo $fire['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                </label>

                                <label for="fire_n" class="radio_check float_left width50">  
                                    <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_n" type="radio" name="scene[cs_fire]" value="no" <?php echo $fire['no']; ?> class="radio_check_input" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder"></span>No
                                </label>
                            </div>
                        </div>
                        <!--<div class="filed_input float_left width50" >-->

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Relatives<span class="md_field">*</span></label></div>

                        <div class="filed_input width2 float_left">
                       <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                            <?php $rel[@$scene_data[0]->cs_relatives] = "checked"; ?>

                            <div class="radio_button_div1">
                                <label for="relatives_y" class="radio_check float_left width50">  
                                    <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="relatives_y" type="radio" name="scene[cs_relatives]" value="yes" class="radio_check_input" data-errors="{}" <?php echo $rel['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                </label>

                                <label for="relatives_n" class="radio_check float_left width50">  
                                    <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="relatives_n" type="radio" name="scene[cs_relatives]" value="no" <?php echo $rel['no']; ?> class="radio_check_input" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder"></span>No
                                </label>
                            </div>
                        </div>
                        <!--<div class="filed_input float_left width50" >-->

                    </div>

                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">By-stander<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input  name="scene[cs_by_stander]"  placeholder="By-stander" type="text" class="filter_required"  data-errors="{filter_required:'By-stander should not be blank'}" value="<?= @$scene_data[0]->cs_by_stander; ?>" TABINDEX="10"   <?php echo $disabled; ?>>
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Action Taken<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 ">
<!--                            <select   name="scene[cs_action_taken]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Action Taken should not be blank!'}"  <?php echo $disabled; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select</option>
                                <option value="additional_resource" <?php
                            if (@$scene_data[0]->cs_action_taken == 'additional_resource') {
                                echo "selected";
                            }
                            ?>>Additional Resource</option>
                                <option value="informed_to_Police" <?php
                                        if (@$scene_data[0]->cs_action_taken == 'informed_to_Police') {
                                            echo "selected";
                                        }
                                        ?>>Informed to Police</option>
                                <option value="informed_to_fire" <?php
                                if (@$scene_data[0]->cs_action_taken == 'informed_to_fire') {
                                    echo "selected";
                                }
                                        ?>>Informed to Fire</option>
                            </select>-->
                                         <textarea name="scene[cs_action_taken]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Action should not be blank'}" <?php echo $disabled; ?>><?= @$scene_data[0]->cs_action_taken; ?></textarea>

                        </div>
                    </div>

                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="standard_remark">Standard Remark<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <select name="scene[cs_standard_remark]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $disabled; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="scene_challeges_register"  <?php
                                        if (@$scene_data[0]->cs_standard_remark == 'scene_challeges_register') {
                                            echo "selected";
                                        }
                                        ?> >Scene Challenges Register </option>

                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="remark">Remark<span class="md_field">*</span></label></div>



                        <div class="width50 float_left">
                            <textarea  name="scene[cs_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php echo $disabled; ?>><?= @$scene_data[0]->cs_remark; ?></textarea>

                        </div>
                    </div>

                </div>


            </div>

<?php if ($update) { ?>  

                <input type="hidden" name="scene[cs_id]"  value="<?= @$scene_data[0]->cs_id ?>">


                <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="dard_time">Date / Time<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="scene[cs_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?= @$scene_data[0]->cswe_date_time; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="action">Action<span class="md_field">*</span></label></div>



                        <div class="width50 float_left">
                            <input name="scene[cs_action]" tabindex="20" class=" filter_required" placeholder="action" type="text"  data-errors="{filter_required:'Action should not be blank!'}" value="<?= @$scene_data[0]->cs_action; ?>"   <?php echo $update; ?>>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="district_manager">District manager<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">
                            <input name="scene[cs_district_manager]" tabindex="20" class=" filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District manager should not be blank!'}" value="<?= @$scene_data[0]->cs_district_manager; ?>"   <?php echo $update; ?>>

                        </div>

                    </div>
              
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="district_manager">Remark<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">
                            <input name="scene[cs_cur_remark]" tabindex="20" class=" filter_required" placeholder="Remark" type="text"  data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$scene_data[0]->cs_district_manager; ?>"   <?php echo $update; ?>>

                        </div>

                    </div>
                </div>

<?php } ?>





            <div class="button_field_row  margin_auto float_left width100 text_align_center">
                <div class="button_box">

                    <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_scene_challeges<?php } else { ?>registration_scene_challenges<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                    <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->        
                    <!--<input type="hidden" name="clg_data" value=<?php echo $data; ?>>-->
                </div>
            </div>



            </form>

