<script>
//if(typeof H != 'undefined'){
    //init_auto_address();
//}

</script>


<div id="dublicate_id"></div>

<?php
if ($type == 'Update') {
    $update = 'disabled';
}
?>



<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro">Add Equipment Audit</h2>


        <div class="joining_details_box">
            
            <div class="width100">

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                if (@$oxygen_data[0]->of_state_code != '') {
                                    $st = array('st_code' => @$oxygen_data[0]->of_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }


                                echo get_state_clo_comp_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                            <div id="incient_district">
                                <?php
                                if (@$oxygen_data[0]->of_state_code != '') {
                                    $dt = array('dst_code' => @$oxygen_data[0]->of_district_code, 'st_code' => @$oxygen_data[0]->of_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                }

                                echo get_district_closer_amb($dt);
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
                                if (@$oxygen_data[0]->of_state_code != '') {
                                    $dt = array('dst_code' => @$oxygen_data[0]->of_district_code, 'st_code' => @$oxygen_data[0]->of_state_code, 'amb_ref_no' => @$oxygen_data[0]->req_amb_reg_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                            <input name="req[req_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$oxygen_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>

                        </div>


                    </div>
                </div>
                <div class="field_row width100">

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="amb_type">Ambulance Type<span class="md_field">*</span></label></div>   

                            <div class="field_input float_left width50" id="type_of_ambulance">
                                <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type($update_data[0]->ambt_name); ?>
                                </select>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">AOM<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
    <!--                            <input name="demo[dt_district_manager]" tabindex="25" class="form_input filter_required" placeholder="District Manager" type="text" data-base="search_btn" data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$demo_data[0]->dt_district_manager; ?>"   <?php echo $update; ?>>-->
                                <input name="aom" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?= @$update_data[0]->aom; ?>" value="<?= @$update_data[0]->dt_district_manager; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'AOM should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DM&amp;output_position=content'>
                            </div>
                        </div>
                </div>
                <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">EMT ID<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left">
                                <input name="mt_emt_id" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_emso_id" data-value="<?= @$preventive[0]->mt_emt_id; ?>" value="<?= @$preventive[0]->mt_emt_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_emso_id"  id="emt_list" data-errors="{filter_required:'Ambulance should not be blank!'}" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">EMT Name<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left" id="show_emso_name">
                                <?php //var_dump($inc_emp_info);?>
                                <input name="emt_name" tabindex="25" class="form_input" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= @$preventive[0]->mt_emt_name; ?>" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                                
                            </div>
                        </div>

                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">Pilot ID<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left">
                             
                                <input name="mt_pilot_id" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_pilot_id" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot ID" data-callback-funct="show_pilot_idnew"  id="pilot_list" data-errors="{filter_required:'Pilot ID should not be blank!'}" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">Pilot Name<span class="md_field">*</span></div>
                            </div>
                            <div class="width50 float_left" id="show_pilot_name">
                                <input name="pilot_name" tabindex="25" class="form_input" placeholder="Pilot Name" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= @$preventive[0]->mt_pilot_name; ?>" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                                
                            </div>
                        </div>

                    </div>
                 <div class="field_row width100">
                    
                     <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="breakdown_date">Previous Audit Date<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"  id='previous_audit_date'>
                              <input type="text" name="previous_audit_date"  value="<?= @$equp_data[0]->previous_maintaince_date; ?>" class="filter_required mi_timecalender" placeholder="Breakdown date and time" data-errors="{filter_required:'Accident date should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                     <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="breakdown_date">Current Audit Date<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" >
                              <input type="text" name="current_audit_date"  value="<?= @$equp_data[0]->previous_maintaince_date; ?>" class="filter_required mi_timecalender" placeholder="Breakdown date and time" data-errors="{filter_required:'Accident date should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                        
                    </div>
                 </div>
                <div class="field_row width100">
                    <table class="report_table">
                        <tr><td>S.No.</td><td>Item name</td><td>Availability</td><td>Working Status</td><td>Any Damage/Broken</td><td>If Not Working then Reason</td><td>If Damage / Broken then details</td><td>Other Remarks</tr>
                        <tr><td>1)</td><td>Autoloader Collapsible Strecther</td>
                            <td>
                                <select name="audit[0][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option> 
                                </select>
                            </td>
                            <td>
                                <select name="audit[0][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option>
                                    <option value="Not Functional">Not Functional</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
                            </td><td><select name="audit[0][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select></td>
                            <td> <input type="text" name="audit[0][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
                            <td>
                                <input type="text" name="audit[0][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
                            </td>

                            <td> <input type="text" name="audit[0][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
                                <input type="hidden" name="audit[0][item_name]"  value="Autoloader Collapsible Strecther" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
                            </td></tr>
                        <tr><td>2)</td><td>Scoop Stretcher with Bracket</td><td>
                                <select name="audit[1][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
                            </td>
                            <td>
                                <select name="audit[1][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Working">Working</option>
                                    <option value="Not Working">Not Working</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
                            </td><td><select name="audit[1][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select></td>
                            <td> <input type="text" name="audit[1][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
                            <td>
                                <input type="text" name="audit[1][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
                            </td>

                            <td> <input type="text" name="audit[1][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
                                <input type="hidden" name="audit[1][item_name]"  value="Scoop Stretcher with Bracket" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
                            </td>
                        </tr>
<tr><td>3)</td><td>Spine Board with Head Blocks</td>   <td>
                                <select name="audit[2][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[2][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                   <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[2][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[2][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[2][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[2][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[2][item_name]"  value="Spine Board with Head Blocks" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
 <tr><td>4)</td><td>Wheel Chair</td><td>
                                <select name="audit[3][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[3][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Working">Working</option>
                                    <option value="Not Working">Not Working</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[3][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[3][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[3][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[3][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[3][item_name]"  value="Wheel Chair" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
 <tr><td>5)</td><td>Nebulizer Machine</td><td>
                                <select name="audit[4][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[4][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[4][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[4][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[4][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[4][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[4][item_name]"  value="Nebulizer Machine" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>6)</td><td>Digital Thermometer</td><td>
                                <select name="audit[5][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[5][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[5][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[5][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[5][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[5][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[5][item_name]"  value="Digital Thermometer" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>7)</td><td>Glucometer Set</td><td>
                                <select name="audit[6][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[6][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[6][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[6][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[6][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[6][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[6][item_name]"  value="Glucometer Set" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>8)</td><td>Stethoscope</td><td>
                                <select name="audit[7][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[7][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[7][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[7][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[7][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[7][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[7][item_name]"  value="Stethoscope" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>9)</td><td>Handheld Suction Pump with Tubing</td><td>
                                <select name="audit[8][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[8][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[8][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[8][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[8][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[8][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[8][item_name]"  value="Handheld Suction Pump with Tubing" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>10)</td><td>AC/DC Suction Pump</td><td>
                                <select name="audit[9][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[9][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[9][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[9][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[9][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[9][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[9][item_name]"  value="AC/DC Suction Pump" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Filter</td><td>
                                <select name="audit[10][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[10][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[10][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[10][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[10][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[10][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[10][item_name]"  value="Filter" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Tubing</td><td>
                                <select name="audit[11][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                </select>
    </td>
    <td>
        <select name="audit[11][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[11][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[11][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[11][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[11][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[11][item_name]"  value="Tubing" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iii</td><td>Suction Jar</td><td>
                                <select name="audit[12][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[12][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[12][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[12][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[12][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[12][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[12][item_name]"  value="Suction Jar" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>11)</td><td>Sphygmomanometer</td><td>
                                <select name="audit[13][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[13][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[13][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option> 
        </select></td>
        <td> <input type="text" name="audit[13][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[13][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[13][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[13][item_name]"  value="Sphygmomanometer" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Adult cuff with Baloon</td><td>
                                <select name="audit[14][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[14][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[14][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[14][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[14][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[14][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[14][item_name]"  value="Adult cuff with Baloon" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Pead cuff with Baloon</td><td>
                                <select name="audit[15][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[15][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[15][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[15][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[15][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[15][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[15][item_name]"  value="Pead cuff with Baloon" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iii</td><td>Neonatal cuff with Baloon</td><td>
                                <select name="audit[16][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[16][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[16][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[16][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[16][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[16][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[16][item_name]"  value="Neonatal cuff with Baloon" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>12)</td><td>Transport Ventilator (Portable)</td><td>
                                <select name="audit[17][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[17][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[17][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[17][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[17][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[17][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[17][item_name]"  value="Transport Ventilator (Portable)" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Breathing Hose Pipe</td><td>
                                <select name="audit[18][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[18][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                   <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[18][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[18][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[18][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[18][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[18][item_name]"  value="Breathing Hose Pipe" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Test Lung</td><td>
                                <select name="audit[19][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[19][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[19][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[19][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[19][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[19][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[19][item_name]"  value="Test Lung" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>13)</td><td>Defibrillator</td><td>
                                <select name="audit[21][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[21][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[21][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[21][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[21][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[21][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[21][item_name]"  value="Defibrillator" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Spo2 sensor cable</td><td>
                                <select name="audit[22][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[22][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[22][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[22][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[22][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[22][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[22][item_name]"  value="Spo2 sensor cable" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>ECG cable</td><td>
                                <select name="audit[23][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[23][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[23][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[23][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[23][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[23][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[23][item_name]"  value="ECG cable" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iii</td><td>NIBP Tube and Cuff</td><td>
                                <select name="audit[24][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[24][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                   <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[24][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[24][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[24][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[24][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[24][item_name]"  value="NIBP Tube and Cuff" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iv</td><td>Shock Paddles</td><td>
                                <select name="audit[25][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[25][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[25][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[25][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[25][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[25][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[25][item_name]"  value="Shock Paddles" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>14)</td><td>Pulse Oximeter</td><td>
                                <select name="audit[26][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[26][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[26][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[26][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[26][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[26][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[26][item_name]"  value="Pulse Oximeter" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Handheld System</td><td>
                                <select name="audit[27][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                    
                                </select>
    </td>
    <td>
        <select name="audit[27][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[27][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[27][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[27][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[27][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[27][item_name]"  value="Handheld System" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Charging station</td><td>
                                <select name="audit[28][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[28][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[28][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[28][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[28][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[28][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[28][item_name]"  value="Charging station" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iii</td><td>Spo2 sensor cable</td><td>
                                <select name="audit[29][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[29][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[29][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[29][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[29][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[29][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[29][item_name]"  value="Spo2 sensor cable" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>15)</td><td>Syringe Pump</td><td>
                                <select name="audit[30][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[30][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Working">Working</option>
                                    <option value="Not Working">Not Working</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[30][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[30][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[30][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[30][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[30][item_name]"  value="Syringe Pump" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>16)</td><td>Oxygen Delivery system</td><td>
                                <select name="audit[31][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[31][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Working">Working</option>
                                    <option value="Not Working">Not Working</option>
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[31][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[31][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[31][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[31][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[31][item_name]"  value="Oxygen Delivery system" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>ODS display</td><td>
                                <select name="audit[32][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[32][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[32][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[32][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[32][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[32][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[32][item_name]"  value="ODS display" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Perflowmeter</td><td>
                                <select name="audit[33][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[33][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[33][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[33][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[33][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[33][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[33][item_name]"  value="Perflowmeter" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iii</td><td>O2 Regulator</td><td>
                                <select name="audit[34][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[34][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                   <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[34][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[34][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[34][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[34][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[34][item_name]"  value="O2 Regulator" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>17)</td><td>Oxygen Cylinder D Type (2 Nos)</td><td>
                                <select name="audit[35][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[35][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[35][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[35][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[35][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[35][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[35][item_name]"  value="Oxygen Cylinder D Type (2 Nos)" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>18)</td><td>Oxygen Cylinder AA (Portable)Type</td><td>
                                <select name="audit[36][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[36][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                   <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[36][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[36][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[36][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[36][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[36][item_name]"  value="Oxygen Cylinder AA (Portable)Type" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Portable O2 Regulator with Humdifer Bottle</td><td>
                                <select name="audit[37][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[37][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[37][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[37][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[37][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[37][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[37][item_name]"  value="Portable O2 Regulator with Humdifer Bottle" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Oxygen Key</td><td>
                                <select name="audit[38][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[38][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[38][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[38][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[38][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[38][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[38][item_name]"  value="Oxygen Key" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>19)</td><td>Cervical collar</td><td>
                                <select name="audit[39][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[39][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[39][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[39][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[39][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[39][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[39][item_name]"  value="Cervical collar" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>20)</td><td>Splints</td><td>
                                <select name="audit[40][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[40][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[40][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[40][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[40][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[40][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[40][item_name]"  value="Splints" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>21)</td><td>Laryngoscope</td><td>
                                <select name="audit[41][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[41][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[41][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[41][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[41][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[41][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[41][item_name]"  value="Laryngoscope" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>i</td><td>Blade 1</td><td>
                                <select name="audit[42][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[42][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[42][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[42][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[42][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[42][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[42][item_name]"  value="Blade 1" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>ii</td><td>Blade 2</td><td>
                                <select name="audit[43][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[43][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[43][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                      <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[43][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[43][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[43][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[43][item_name]"  value="Blade 2" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>iii</td><td>Blade 3</td><td>
                                <select name="audit[44][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[44][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[44][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                     <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[44][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[44][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    
    <td> <input type="text" name="audit[44][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[44][item_name]"  value="Blade 3" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
<tr><td>Iv</td><td>Blade 4</td><td>
                                <select name="audit[45][availability]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td>
    <td>
        <select name="audit[45][working_status]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>
                                   <option value="Functional">Functional</option> 
                                    <option value="Not Functional">Not Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
                                </select>
    </td><td><select name="audit[45][damage_broken]" class="filter_required" data-errors="{filter_required:'Availability should not be blank'}"  TABINDEX="5">

                                    <option value="">Select Type</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Broken">Broken</option> 
                                    <option value="Missing">Missing</option> 
                                    <option value="Functional">Functional</option> 
                                    <option value="Not Issued">Not Issued</option>
        </select></td>
        <td> <input type="text" name="audit[45][not_working_reason]"  value="<?= @$equp_data[0]->not_working_reason; ?>" class="" placeholder="Not Working then Reason" data-errors="{filter_required:'Not Working then Reason should not be blank'}" TABINDEX="8" ></td>
        <td>
            <input type="text" name="audit[45][damage_reason]"  value="<?= @$equp_data[0]->damage_reason; ?>" class="" placeholder="Any Damage/Broken " data-errors="{filter_required:'Any Damage/Broken should not be blank'}" TABINDEX="8" >
    </td>
    <td> <input type="text" name="audit[45][other_remark]"  value="<?= @$equp_data[0]->other_remark; ?>" class="" placeholder="Other Remark" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    <input type="hidden" name="audit[45][item_name]"  value="Blade 4" class="filter_required" placeholder="" data-errors="{filter_required:'Other Remark should not be blank'}" TABINDEX="8" >
    </td></tr>
                    </table>
                    
                </div>
                <div class="field_row width100">
                    

                    <div class="button_field_row  margin_auto float_left width100 text_align_center">
                        <div class="button_box">
                            <input type="hidden" name="eqiup[req_group]"  value="EQUP">
                            <input type="button" name="submit" value="Save Request" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>biomedical/save_equipment_audit' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=MT-CLG-ADD&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" >
                            <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">--> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

 
<script>

    jQuery(document).ready(function () {
        var $min = new Date();

        $('#offroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd ",
            // timeFormat: "hh:mm:ss",
            minDate: $min,
            // minTime: jsDate[1],

        });

        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('#mt_onroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
        $("#offroad_datetime").change(function () {


            var jsDate = $("#offroad_datetime").val();
            var $mindate = new Date(jsDate);


            $('.OnroadDate').datetimepicker({
                dateFormat: "yy-mm-dd ",
                minDate: $mindate,
                // minTime: jsDate[1],

            });
        });
    });

</script>