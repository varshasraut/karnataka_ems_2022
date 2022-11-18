
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
                                if (@$statutory_data[0]->sc_state_code != '') {
                                    $st = array('st_code' => @$statutory_data[0]->sc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                                if (@$statutory_data[0]->sc_state_code != '') {
                                    $dt = array('dst_code' => @$statutory_data[0]->sc_district_code, 'st_code' => @$statutory_data[0]->sc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                                if (@$statutory_data[0]->sc_state_code != '') {
                                    $dt = array('dst_code' => @$statutory_data[0]->sc_district_code, 'st_code' => @$statutory_data[0]->sc_state_code, 'amb_ref_no' => @$statutory_data[0]->sc_amb_ref_number, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                            <input name="stat[sc_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$statutory_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>

                        </div>


                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type</label></div>

                            <div class="filed_input float_left width50">
                                <select name="stat[sc_shift_type]" tabindex="8" id="supervisor_list"  <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type(@$statutory_data[0]->sc_shift_type); ?>
                                </select>

                            </div>
                        </div>

                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="stat[sc_pilot_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-errors="{filter_required:'Pilot Id Name should not be blank!'}" data-value="<?= @$statutory_data[0]->sc_pilot_id; ?>" value="<?= @$statutory_data[0]->sc_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Name" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="stat[sc_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$statutory_data[0]->sc_pilot_name; ?>" TABINDEX="10"    <?php echo $update; ?>>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Id<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="stat[sc_emso_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_all_emso_id?emt=true" data-errors="{filter_required:'EMT Id Name should not be blank!'}" data-value="<?= @$statutory_data[0]->sc_emso_id; ?>" value="<?= @$statutory_data[0]->sc_emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_all_emso_id"  id="emt_list"   <?php echo $update; ?>>
                        </div>

                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">EMT Name<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  id="show_emso_name">
                            <input name="stat[sc_emso_name]" tabindex="25" class="form_input filter_required" placeholder="SHP Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= @$statutory_data[0]->sc_emso_name; ?>"   <?php echo $update; ?>>
<!--                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">-->
                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width100">
                        <!--                                <div class="width2 float_left">
                                                            <div class="field_lable float_left width33"> <label for="mobile_no">Supervisor Name<span class="md_field">*</span></label></div>
                           <div class="filed_input float_left width50">
                        
                                                    <select name="stat[sc_supervisor_name]" tabindex="8" id="supervisor_list" class="filter_required" data-errors="{filter_required:'Supervisor Name should not be blank!'}"    <?php echo $update; ?>> 
                                                        <option value="" <?php echo $disabled; ?>>Select Supervisor</option>
                        <?php foreach ($supervisor_info as $supervisor) { ?>
                                                                        <option value="<?php echo $supervisor->clg_ref_id; ?>" <?php
                            if ($supervisor->clg_ref_id == @$statutory_data[0]->sc_supervisor_name) {
                                echo "selected";
                            }
                            ?>><?php echo $supervisor->clg_first_name . " " . $supervisor->clg_last_name; ?></option>
                        <?php } ?>
                                                               <option value="other">Other supervisor </option>
                        
                                                    </select>
                           </div>
                                                </div>-->
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">District Manager<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                            <input name="demo[dt_district_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= @$demo_data[0]->dt_district_manager; ?>" value="<?= @$demo_data[0]->dt_district_manager; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager Name should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content'>
                            <!-- <input name="stat[sc_supervisor_name]" tabindex="25" class="form_input filter_required" placeholder="Supervisor Name" type="text" data-base="search_btn" data-errors="{filter_required:'Supervisor Name should not be blank!'}" value="<?= @$statutory_data[0]->sc_supervisor_name; ?>"   <?php echo $update; ?>> -->
                            </div>
                        </div>
                        <!--                             <div class="width2 float_left" id="other_supervisor_textbox">
                                                  
                                                     </div>-->

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Compliance Type<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select  name="stat[sc_complaint_type]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Complaint Type should not be blank!'}"    <?php echo $update; ?>>  
                                    <option value="" <?php echo $disabled; ?>>Select Compliance Type</option>
                                    <option value="insurance" <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'insurance') {
                                        echo "selected";
                                    }
                                    ?>>Insurance</option>
                                    <option value="rto" <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'rto') {
                                        echo "selected";
                                    }
                                    ?>>RTO</option>
                                    <option value="clearance" <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'clearance') {
                                        echo "selected";
                                    }
                                    ?>>Clearance</option>
                                    <option value="driver_licence"
                                    <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'driver_licence') {
                                        echo "selected";
                                    }
                                    ?>>Driver Licence</option>
                                    <option value="puc"
                                    <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'puc') {
                                        echo "selected";
                                    }
                                    ?>>PUC</option>
                                    <option value="doctor_licence"
                                    <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'doctor_licence') {
                                        echo "selected";
                                    }
                                    ?>>Doctor Licence</option>
                                    <option value="equipment_insurance"
                                    <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'equipment_insurance') {
                                        echo "selected";
                                    }
                                    ?>>Equipment Insurance</option>
                                    <option value="Other"
                                    <?php
                                    if (@$statutory_data[0]->sc_complaint_type == 'Other') {
                                        echo "selected";
                                    }
                                    ?>>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">

                        <div class="width2 float_left">

                        </div>

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Compliance<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50 "  id="show_emso_name">
                                <select  name="stat[sc_compliance]" tabindex="8" class="filter_required" data-errors="{filter_required:'Compliance should not be blank!'}"    <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Compliance</option>
                                    <option value="Yes"
                                    <?php
                                    if (@$statutory_data[0]->sc_compliance == 'Yes') {
                                        echo "selected";
                                    }
                                    ?>
                                            >Yes</option>
                                    <option value="No"
                                    <?php
                                    if (@$statutory_data[0]->sc_compliance == 'No') {
                                        echo "selected";
                                    }
                                    ?>
                                            >No</option>

                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Date Of Renovation<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <input name="stat[sc_date_of_renovation]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Renovation Date" type="text"  data-errors="{filter_required:'Date Of Renovation should not be blank!'}" value="<?= @$statutory_data[0]->sc_date_of_renovation; ?>"   <?php echo $update; ?>>
                            </div>
                        </div>
                        <!--                        <div class="width2 float_left">
                                                    <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>
                        
                        
                                                    <div class="filed_input float_left width50" >
                                                           <div class="width50 float_left">
                                                <input type="text" name="stat[sc_standard_remark]" data-value="<?= @$re_name; ?>" value="<?= $re_name; ?>" class=" filter_required width2"   placeholder="Standard Remark" data-errors="{filter_required:'Please select Standard Remark from dropdown list'}"  TABINDEX="8" >
                                            </div>
                                                    </div>
                                                </div>-->


                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select name="stat[sc_standard_remark]" tabindex="8" id="supervisor_list" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $update; ?> > 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="statutory_compliance_successfully"  <?php
                                    if (@$statutory_data[0]->sc_standard_remark == 'statutory_compliance_successfully') {
                                        echo "selected";
                                    }
                                    ?>  >Statutory compliance successfully</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">

                        <div class="width100 float_left">
                            <div class="field_lable float_left width_16"> <label for="mobile_no">Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width75 "  id="show_emso_name">
                                <textarea style="height:60px;" name="stat[sc_remark]" class="width100 filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update; ?>><?= @$statutory_data[0]->sc_remark; ?> </textarea>
                            </div>
                        </div>

                    </div>


                </div>



                <?php if ($update) { ?>  
                    <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no"> Next Date Of Renovation<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <input name="stat[sc_next_date_of_renovation]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Next Date Of Renovation" type="text"  data-errors="{filter_required:'Date Of Renovation should not be blank!'}" value="<?= @$statutory_data[0]->sc_next_date_of_renovation; ?>" >
                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="date_time">Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" id="cur_date_time_sat" name="stat[sc_cur_date_time]"  value=" <?php
                                if (@$statutory_data[0]->sc_cur_date_time != '0000-00-00 00:00:00' && @$statutory_data[0]->sc_cur_date_time != '') {
                                    echo @$statutory_data[0]->sc_cur_date_time;
                                }
                                ?>" class="filter_required mi_cur_date" placeholder="Date/Time" data-errors="{filter_required:' Date/Time should not be blank'}" TABINDEX="8" <?php
                                       if (@$statutory_data[0]->sc_cur_date_time != '0000-00-00 00:00:00' && @$statutory_data[0]->sc_cur_date_time != '') {
                                           echo "disabled";
                                       }
                                       ?>>



                            </div>
                        </div>
                    </div>
                    <div class="width100 float_left">
                        <div class="filed_input float_left width50">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Standard Remark<span class="md_field">*</span></label></div>  <div class="filed_input float_left width50">
                                <select name="stat[sc_stand_remark]" tabindex="8" id="supervisor_list" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>

                                    <option value="solve_complaiance"  <?php
                                    if (@$statutory_data[0]->sc_stand_remark == 'solve_complaiance') {
                                        echo "selected";
                                    }
                                    ?>>Solve Complaiance</option> 
                                </select>
                            </div>
                        </div>


                    </div>


                <?php } ?>
                <?php if ($update) { ?>  

                    <input type="hidden" name="stat[sc_id]" id="ud_clg_id" value="<?= @$statutory_data[0]->sc_id ?>">

                <?php } ?>




                <?php if (!@$view_clg) { ?>
                    <div class="button_field_row width_25 margin_auto width100 text_align_center">
                        <div class="button_box">

                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_statutory_compliance<?php } else { ?>registration_statutory_compliance<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                            <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->              
                        </div>
                    </div>

                <?php } ?>

                </form>

                <script>

                    console.log("hiii");
                    var today = new Date();

                    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    var dateTime = date + ' ' + time;

                    $("#cur_date_time_sat").val(dateTime);



                </script>