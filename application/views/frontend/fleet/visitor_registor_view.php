<script>

//    init_auto_address();

</script>


<div id="dublicate_id"></div>

<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
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

            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">
                                <?php
                                if (@$visitor_data[0]->vs_state_code != '') {
                                    $st = array('st_code' => @$visitor_data[0]->vs_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
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
                                if (@$visitor_data[0]->vs_state_code != '') {
                                    $dt = array('dst_code' => @$visitor_data[0]->vs_district_code, 'st_code' => @$visitor_data[0]->sc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
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
                                if (@$visitor_data[0]->vs_state_code != '') {
                                    $dt = array('dst_code' => @$visitor_data[0]->vs_district_code, 'st_code' => @$visitor_data[0]->sc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
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
                            <input name="visitor[vs_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$visitor_data[0]->hp_name; ?>" readonly="readonly">
                        </div>
                    </div>
                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <select name="visitor[vs_shift_type]" tabindex="8" id="supervisor_list" class="filter_required" data-errors="{filter_required:'Supervisor Name should not be blank!'}"> 
                                <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                <?php echo get_shift_type(@$visitor_data[0]->vs_shift_type); ?>
                            </select>

                        </div>
                    </div>
                    <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">District Manager<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">
                                <!-- <input data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="District Manager" type="text" name="visitor[vs_district_manager]" class="filter_required"  data-errors="{filter_required:'District Manager should not be blank'}" value="<?= @$visitor_data[0]->vs_district_manager; ?>" TABINDEX="10"  <?php echo $view; ?>> -->
                                <input name="demo[dt_district_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= @$visitor_data[0]->dt_district_manager; ?>" value="<?= @$visitor_data[0]->dt_district_manager; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager Name should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content'>

                            </div>
                        </div>
                    
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Visitor Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" >
                            <input  name="visitor[vs_visitor_name]"  data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Visitor Name" type="text" name="stat[sc_pilot_name]" class="filter_required"  data-errors="{filter_required:'Visitor Name should not be blank'}" value="<?= @$visitor_data[0]->vs_visitor_name; ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Designation<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input  name="visitor[vs_designation]" data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Desigation" type="text" name="stat[sc_pilot_name]" class="filter_required"  data-errors="{filter_required:'Visitor Name should not be blank'}" value="<?= @$visitor_data[0]->vs_designation; ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>

                    </div>
                   
                </div>
                <div class="field_row width100">
                    <div class="width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Organisation<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="visitor[vs_oragnization]"  placeholder="Organisation" type="text" class="filter_required"  data-errors="{filter_required:'Visitor Name should not be blank'}" value="<?= @$visitor_data[0]->vs_oragnization; ?>" TABINDEX="10"  <?php echo $view; ?>>
                        </div>
                    </div>

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Contact Number<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="visitor[vs_contact_number]" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$visitor_data[0]->vs_contact_number; ?>" TABINDEX="10"  <?php echo $view; ?>>
                            </div>
                        </div>
                        </div>
                        <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Email</label></div>


                            <div class="filed_input float_left width50">
                                <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="visitor[vs_email]"  class=" filter_email filter_is_exists no_ucfirst"  data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}" value="<?= @$visitor_data[0]->vs_email; ?>" TABINDEX="10"  <?php echo $view; ?>>
                            </div></div>
                        <div class="field_row width100">

                        </div>
                        <div class="width100 float_left">
                            <div class="field_lable float_left width_16"> <label for="mobile_no">Address</label></div>


                            <div class="filed_input float_left width74 "  >
                                <textarea  name="visitor[vs_addres]" class="width100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Address should not be blank'}"><?= @$visitor_data[0]->vs_addres; ?></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="field_row width100">
                        <!--                        <div class="width2 float_left">
                                                    <div class="field_lable float_left width33"> <label for="mobile_no">Supervisor<span class="md_field">*</span></label></div>
                        
                        
                                                    <div class="filed_input float_left width50">
                                                          <select name="visitor[vs_supervisor]" tabindex="8" class="filter_required" data-errors="{filter_required:'Supervisor Name should not be blank!'}"> 
                                                        <option value="" <?php echo $disabled; ?>>Select Supervisor</option>
                        <?php foreach ($supervisor_info as $supervisor) { ?>
                                                                <option value="<?php echo $supervisor->clg_ref_id; ?>" <?php
                            if ($supervisor->clg_ref_id == @$visitor_data[0]->vs_supervisor) {
                                echo "selected";
                            }
                            ?>><?php echo $supervisor->clg_first_name . " " . $supervisor->clg_last_name; ?></option>
<?php } ?>
                                                               <option value="other">Other supervisor </option>
                        
                                                    </select>
                                                    </div>
                                                </div>-->

                        <!-- <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Supervisor Name<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="visitor[vs_supervisor]" tabindex="25" class="form_input " placeholder="Supervisor Name" type="text" data-base="search_btn" data-errors="{filter_required:'Supervisor Name should not be blank!'}" value="<?= @$visitor_data[0]->vs_supervisor; ?>"   <?php echo $update; ?>>
                            </div>
                        </div> -->
                       
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Purpose of visit<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <input data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Purpose of visit" type="text" name="visitor[vs_purposr_visit]" class="filter_required"  data-errors="{filter_required:'District Manager should not be blank'}" value="<?= @$visitor_data[0]->vs_purposr_visit; ?>" TABINDEX="10"  <?php echo $view; ?>>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Visited Date Time<span class="md_field">*</span></label></div>


                            <!--<div class="filed_input float_left width50" >-->
                            <div class="width50 float_left">
                                <input name="visitor[vs_visited_datetime]" tabindex="20" class="form_input mi_timecalender_sch filter_required" placeholder="Visited Date Time" type="text"  data-errors="{filter_required:'Visited Date Time should not be blank!'}" value="<?= @$visitor_data[0]->vs_visited_datetime; ?>" >
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <!-- <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Purpose of visit<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <input data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Purpose of visit" type="text" name="visitor[vs_purposr_visit]" class="filter_required"  data-errors="{filter_required:'District Manager should not be blank'}" value="<?= @$visitor_data[0]->vs_purposr_visit; ?>" TABINDEX="10"  <?php echo $view; ?>>
                            </div>
                        </div> -->
                        
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select name="visitor[vs_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="visitor_update"  <?php
                                    if (@$visitor_data[0]->vs_standard_remark == 'visitor_update') {
                                        echo "selected";
                                    }
                                    ?> >Visitor Updated </option>
                                    <option value="other"  <?php
                                    if (@$visitor_data[0]->vs_standard_remark == 'other') {
                                        echo "selected";
                                    }
                                    ?>>other</option> 

                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50 "  >
                                <textarea  name="visitor[vs_remark]" class="width100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Address should not be blank'}"><?= @$visitor_data[0]->vs_remark; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <!-- <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select name="visitor[vs_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="visitor_update"  <?php
                                    if (@$visitor_data[0]->vs_standard_remark == 'visitor_update') {
                                        echo "selected";
                                    }
                                    ?> >Visitor Updated </option>
                                    <option value="other"  <?php
                                    if (@$visitor_data[0]->vs_standard_remark == 'other') {
                                        echo "selected";
                                    }
                                    ?>>other</option> 

                                </select>

                            </div>
                        </div> -->
                        
                        

                    </div>


                </div>

<?php if ($update) { ?>  

                    <input type="hidden" name="visitor[vs_id]" id="ud_clg_id" value="<?= @$visitor_data[0]->vs_id ?>">

<?php } ?>




<?php if (!@$view_clg) { ?>
                    <div class="button_field_row width100 margin_auto">
                        <div class="button_box text_center">
                            <input type="hidden" name="hasfiles" value="yes" />
                            <input type="hidden" name="formid" value="add_colleague_registration" />
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_visitor<?php } else { ?>registration_visitor<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
    <!--                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">          -->

                        </div>
                    </div>

<?php } ?>

                </form>

