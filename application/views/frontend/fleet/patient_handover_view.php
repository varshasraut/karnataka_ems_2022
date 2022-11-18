<script>

    //init_auto_address();

</script>


<div id="dublicate_id"></div>

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
if (@$ptn_data[0]->ph_state_code != '') {
    $st = array('st_code' => @$ptn_data[0]->ph_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
} else {
    $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
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
if (@$ptn_data[0]->ph_state_code != '') {
    $dt = array('dst_code' => @$ptn_data[0]->ph_district_code, 'st_code' => @$ptn_data[0]->ph_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
if (@$ptn_data[0]->ph_state_code != '') {
    $dt = array('dst_code' => @$ptn_data[0]->ph_district_code, 'st_code' => @$ptn_data[0]->ph_state_code, 'amb_ref_no' => @$ptn_data[0]->ph_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                            <input name="base_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$ptn_data[0]->hp_name; ?>" readonly="readonly" <?php echo $disabled; ?>>

                        </div>


                    </div>
                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Shift Type</label></div>

                        <div class="filed_input float_left width50">
                            <select name="ptn[ph_shift_type]" tabindex="8" id="supervisor_list"  <?php echo $disabled; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
<?php echo get_shift_type(@$ptn_data[0]->ph_shift_type); ?>
                            </select>

                        </div>
                    </div>
                    <!--                    <div class="width2 float_left">
                    
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Visitor Name<span class="md_field">*</span></label></div>
                    
                    
                                            <div class="filed_input float_left width50" >
                                                <input  name="visitor[vs_visitor_name]"  data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Visitor Name" type="text" name="stat[sc_pilot_name]" class="filter_required"  data-errors="{filter_required:'Visitor Name should not be blank'}" value="<?= @$visitor_data[0]->vs_visitor_name; ?>" TABINDEX="10"  <?php echo $view; ?>>
                                            </div>
                                        </div>-->
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="ptn[ph_pilot_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$ptn_data[0]->ph_pilot_id; ?>" data-errors="{filter_required:'Pilot Id should not be blank!'}" value="<?= @$ptn_data[0]->ph_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Name" data-callback-funct="show_pilot_data" id="pilot_name_list" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="ptn[ph_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$ptn_data[0]->ph_pilot_name; ?>" TABINDEX="10" <?php echo $disabled; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Id<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="ptn[ph_emso_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_all_emso_id?emt=true" data-value="<?= @$ptn_data[0]->ph_emso_id; ?>" data-errors="{filter_required:'EMT Id should not be blank!'}" value="<?= @$ptn_data[0]->ph_emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_all_emso_id"  id="emt_list" <?php echo $disabled; ?>>
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="ptn[ph_emso_name]" tabindex="25" class="form_input filter_required" placeholder="SHP Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= @$ptn_data[0]->ph_emso_name; ?>"<?php echo $disabled; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Manager Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
<!--                            <input  name="ptn[ph_mananger_name]" data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Manager Name" type="text" name="stat[sc_pilot_name]" class="filter_required"  data-errors="{filter_required:'Visitor Name should not be blank'}" value="<?= @$ptn_data[0]->ph_mananger_name; ?>" TABINDEX="10" <?php echo $disabled; ?>>
                            -->
                            <input name="ptn[ph_mananger_name]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= @$current_data[0]->clg_ref_id ?>" value="<?= @$current_data[0]->clg_ref_id ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager Name should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content'>
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Hospital Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="ptn[ph_hospital_name]"  tabindex="7.2" class="mi_autocomplete form_input filter_required" placeholder="  Hospital Name" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="<?php echo base_url() ?>auto/get_ptn_hospital" data-value="<?= @$ptn_data[0]->hosp_name; ?>" value="<?= @$ptn_data[0]->hosp_id; ?>" <?php echo $disabled; ?>>

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Issue Type<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <select  name="ptn[ph_issue_type]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Complaint Type should not be blank!'}" <?php echo $disabled; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Issue Type</option>
                                    <option value="hospital_refueses" <?php
if (@$ptn_data[0]->ph_issue_type == 'patient_refueses') {
    echo "selected";
}
?>>Hospital Refuses</option>
                                     <option value="patient_refueses" <?php
if (@$ptn_data[0]->ph_issue_type == 'patient_refueses') {
    echo "selected";
}
?>>Patient Refuses</option>
                                    <option value="infrastructure" <?php
                                    if (@$ptn_data[0]->ph_issue_type == 'infrastructure') {
                                        echo "selected";
                                    }
                                    ?>>Infrastructure</option>
                                    <!-- <option value="patient_refueses_himself" <?php
                                    if (@$ptn_data[0]->ph_issue_type == 'patient_refueses_himself') {
                                        echo "selected";
                                    }
                                    ?>>Patient Refuses himself</option> -->
                                    <option value="relative_refuses"
                                    <?php
                                    if (@$ptn_data[0]->ph_issue_type == 'relative_refuses') {
                                        echo "selected";
                                    }
                                    ?>
                                            >Relative Refuses</option>
                                    <option value="ambulance_staff"
                                    <?php
                                    if (@$ptn_data[0]->ph_issue_type == 'ambulance_staff') {
                                        echo "selected";
                                    }
                                    ?>
                                            >Ambulance Staff related</option>
                                    <option value="other"
<?php
if (@$ptn_data[0]->ph_issue_type == 'other') {
    echo "selected";
}
?>
                                            >Other</option>

                                </select>
                            </div>
                        </div>
                        <div class="width2 float_left">
<!--                           <div class="field_lable float_left width33"> <label for="mobile_no">Patient Name<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                             <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="visitor[vs_email]" class="filter_required "  data-errors="{filter_required:'Email should not be blank'" value="<?= @$ptn_data[0]->vs_email; ?>" TABINDEX="10"  <?php echo $view; ?>>
                            </div>-->
                        </div>

                        <div class="width100 float_left">
                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="mobile_no">Patient Name<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50">
                                    <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text"  name="ptn[ph_patient_name]" class="filter_required "  data-errors="{filter_required:'Email should not be blank'}" value="<?= @$ptn_data[0]->ph_patient_name; ?>" TABINDEX="10"  <?php echo $disabled; ?>>
                                </div></div>
                            <div class="width2 float_left">
                                <div class="field_lable float_left width33"> <label for="mobile_no">Action<span class="md_field">*</span></label></div>


                                <div class="filed_input float_left width50">
                                    <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="ptn[ph_action]" class="filter_required "  data-errors="{filter_required:'Action should not be blank'}" value="<?= @$ptn_data[0]->ph_action; ?>" TABINDEX="10"  <?php echo $disabled; ?>>
                                </div>
                            </div>


                        </div>

                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Report To<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="ptn[ph_report_to]" class="filter_required "  data-errors="{filter_required:'Email should not be blank'}" value="<?= @$ptn_data[0]->ph_report_to; ?>" TABINDEX="10"  <?php echo $disabled; ?>>
                            </div>
                        </div>

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Communicated to Hospital<span class="md_field">*</span></label></div>

                            <div class="filed_input width2 float_left">
                           <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
<?php $gender[@$ptn_data[0]->ph_comm_to_hosp] = "checked"; ?>

                                <div class="radio_button_div1">
                                    <label for="gender_male" class="radio_check float_left width50">  
                                        <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="gender_male" type="radio" name="ptn[ph_comm_to_hosp]" value="yes" class="radio_check_input" data-errors="{}" <?php echo $gender['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                    </label>

                                    <label for="gender_female" class="radio_check float_left width50">  
                                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="gender_female" type="radio" name="ptn[ph_comm_to_hosp]" value="no" <?php echo $gender['no']; ?> class="radio_check_input" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder"></span>No
                                    </label>
                                </div>
                            </div>
                            <!--<div class="filed_input float_left width50" >-->

                        </div>

                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">

                                <select name="ptn[ph_standard_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $disabled; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="patient_handover_issue"  <?php
if ($fuel_data[0]->ph_standard_remark == 'patient_handover_issue') {
    echo "selected";
}
?>  >Patient handover issue register sucessfully </option>


                                </select>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Remark<span class="md_field">*</span></label></div>


                            <!--<div class="filed_input float_left width50" >-->
                            <div class="width50 float_left">
                                <textarea  name="ptn[ph_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Address should not be blank'}" <?php echo $disabled; ?>><?= @$ptn_data[0]->ph_remark; ?></textarea>
                                <!--</div>-->
                            </div>
                        </div>

                    </div>


                </div>

<?php if ($update) { ?>  

                    <input type="hidden" name="ptn[ph_id]" id="ud_clg_id" value="<?= @$ptn_data[0]->ph_id ?>">

                    <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="ptn[ph_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?php if( @$ptn_data[0]->ph_date_time != ''  && @$ptn_data[0]->ph_date_time != '0000-00-00 00:00:00' ){ echo @$ptn_data[0]->ph_date_time;
                                       } ?>"   <?php echo $update; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="action">Action<span class="md_field">*</span></label></div>



                            <div class="width50 float_left">
                                <input name="ptn[ph_update_action]" tabindex="20" class=" filter_required" placeholder="action" type="text"  data-errors="{filter_required:'Action should not be blank!'}" value="<?= @$ptn_data[0]->ph_update_action; ?>"   <?php echo $update; ?>>

                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="district_manager">District manager<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">
                                <input name="ptn[ph_district_manager]" tabindex="20" class=" filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District manager should not be blank!'}" value="<?= @$ptn_data[0]->ph_district_manager; ?>"   <?php echo $update; ?>>

                            </div>

                        </div>
                          <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="remark">Remark<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">
                                <input name="ptn[ph_cur_remark]" tabindex="20" class=" filter_required" placeholder="Remark" type="text"  data-errors="{filter_required:'Remark should not be blank!'}" value="<?= @$ptn_data[0]->ph_cur_remark; ?>"   <?php echo $update; ?>>

                            </div>

                        </div>
                        
                    </div>

<?php } ?>




                <div class="button_field_row  margin_auto float_left width100 text_align_center">
                    <div class="button_box">

                        <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_ptn_handover_issue<?php } else { ?>registration_ptn_handover_issue<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                        <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->         
                    </div>
                </div>


                </form>

