<div id="dublicate_id"></div>

<?php 
$approve ='';
$update ='';
$rerequest ='';
if ($type == 'Update') {
    $update = 'disabled';
}elseif($type == 'Approve'){
  //  $update = 'disabled';
    $approve = 'disabled';
}elseif($type == 'Rerequest'){
    $rerequest = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form" style="position: relative;">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="joining_details_box">
              <?php if ($update) {
                ?>  
                <div class="field_row width100  fleet" ><div class="single_record_back">Previous Information</div></div>
            <?php } ?>
<!--            <div class="field_row width100  fleet"><div class="single_record_back">Previous Information</div></div>-->
            <div class="width100">

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                if (@$preventive[0]->mt_state_id != '') {
                                    $st = array('st_code' => @$preventive[0]->mt_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }


                                  echo get_state_accident_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_district">
                                <?php
                               
                               if (@$preventive[0]->mt_amb_no != '') {
                                    $dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => @$preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }

                               echo get_district_accidental_amb($dt);
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
                                if (@$preventive[0]->mt_amb_no != '') {
                                 
                                    $dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => @$preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    
                                    echo get_break_maintaince_ambulance($dt);
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                     echo get_clo_comp_ambulance($dt);
                                }

                                 
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="base_location" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" data-value="<?= @$preventive[0]->mt_base_loc; ?>" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update; echo $approve; echo $rerequest; ?>  data-callback-funct="load_baselocation_ambulance" data-href="<?php echo base_url();?>auto/get_hospital">
                            
<!--                            <input name="base_location" class="mi_autocomplete " data-href="{base_url}auto/get_hospital" value="<?php echo $update[0]->amb_base_location; ?>" data-value="<?php echo $hp_name; ?>" type="text" <?php echo $view; ?> TABINDEX="10"  data-nonedit="no" data-callback-funct="load_baselocation_address" id="baselocation_address" <?php //echo $edit; ?> > -->

                        </div>
                          </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div_outer">
                            
                            <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $update; echo $approve; echo $rerequest;?> TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type_by_id($preventive[0]->amb_type); ?>
                            </select>


                        </div>


                    </div>
<!--                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Owner</label></div>


                        <div class="filed_input float_left width50" id="amb_owner">
                            

                            <input name="accidental[amb_owner]" tabindex="23" class="form_input " placeholder="Owner" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_owner; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>-->

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                           
                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_make; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" id="amb_amb_model">
                            

                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Model" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_module; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="accident_date">Accident Date & Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="accidental[mt_accidentdate]" id="offroad_datetime" value="<?=@$preventive[0]->mt_accidentdate;?>" class="filter_required mi_timecalender" id="accidentdate" placeholder="Accident date and time" data-errors="{filter_required:'Accident date should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Accident Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="accidental[mt_accident_location]" tabindex="23" class="form_input filter_required" placeholder="Accident Location" type="text"  data-errors="{filter_required:'Accident Location should not be blank!'}" value="<?= @$preventive[0]->mt_accident_location; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                     </div>
                    </div>
                    
                    <div class="field_row width100">
<!--                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">
                                
                                <select name="accidental[mt_shift_id]" tabindex="8" class="" data-errors="{filter_required:'Shift Type should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type($preventive[0]->mt_shift_id);?>
                                </select>

                            </div>
                        </div>-->
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Work Shop Name<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">
                              
                               <input type="text" name="accidental[mt_work_shop]"  data-value="<?=@$preventive[0]->ws_station_name;?>"  value="<?=@$preventive[0]->ws_station_name;?>" class="mi_autocomplete"  data-href="<?php echo base_url();?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Work shop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update; echo $approve; echo $rerequest; ?>>

                            </div>
                        </div>
                         
                        <div class="width2 float_left hide" id="other_workshop" >
                            <div class="field_lable float_left width33"><label for="work_shop">Other Work Shop Name<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="accidental[wt_other_station_name]"  data-value="<?= @$preventive[0]->ws_other_station_name; ?>"  value="<?= @$preventive[0]->wt_other_station_name; ?>" class=""  placeholder="Work shop" data-errors="{filter_required:'Please select Other Work Shop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update; echo $approve;?> >

                            </div>
                        </div>

                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Insurance<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">
                              
                                <select name="accidental[mt_insurance]" tabindex="8" class="" data-errors="{filter_required:'Insurance should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Insurance</option>
                                    <option value="Valid" <?php if($preventive[0]->mt_insurance == 'Valid'){ echo "selected"; } ?>>Valid</option>
                                    <option value="In-Valid" <?php if($preventive[0]->mt_insurance == 'In-Valid'){ echo "selected"; } ?>>In-Valid</option>
                                    
                                    
                            </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Insurance Estimate cost in Rs<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Estimate cost" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                     </div>
                    </div>
                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Repair Estimate Cost In Rs<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="repair_Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_maxlength[8] filter_number" placeholder="Estimate cost" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 7 digit long',filter_number:'Enter only number only.'}" value="<?= @$preventive[0]->mt_repair_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                     </div>
                    </div>
                         <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Police Panchnama<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">
                              
                                <select name="accidental[mt_police_panchanama]" tabindex="8" class="" data-errors="{filter_required:'Insurance should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Police Panchnama</option>
                                    <option value="Yes" <?php if($preventive[0]->mt_police_panchanama == 'Yes'){ echo "selected"; } ?>>Yes</option>
                                    <option value="No" <?php if($preventive[0]->mt_police_panchanama == 'No'){ echo "selected"; } ?>>No</option>
                                    
                                    
                            </select>

                            </div>
                        </div>
                        
                    </div>
                    <?php 
                    if($state_id == 'MP')
                    {
                       ?>
                       <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id <span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="accidental[mt_pilot_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'Pilot Id should not be blank!'}"  data-href="<?php echo base_url(); ?>auto/get_breakdown_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name <span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" class="filter_required" data-errors="{filter_required:'Pilot Id should not be blank!'}" placeholder="Pilot Name" type="text" name="accidental[mt_pilot_name]"  value="<?= @$preventive[0]->mt_pilot_name; ?>" TABINDEX="10"    <?php echo $update;echo $approve; echo $rerequest; ?>>
                        </div>
                    </div>
                </div>
                        <?php
                    }else{
                    ?>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id <span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="accidental[mt_pilot_id]" class="filter_required mi_autocomplete" data-errors="{filter_required:'Pilot Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name <span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="accidental[mt_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$preventive[0]->mt_pilot_name; ?>" TABINDEX="10"    <?php echo $update;echo $approve; echo $rerequest; ?>>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Accidental Maintenance Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="accidental[mt_accidental_previos_odometer]" value="<?=@$preventive[0]->mt_accidental_previos_odometer;?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Accidental Maintenance Previous Odometer',filter_maxlength:'Accidental Maintenance Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" <?php echo $update;echo $approve; echo $rerequest; ?>>


                        </div>
                    </div>
 <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Last Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="previous_odometer" id="previous_odometer" value="<?=@$preventive[0]->mt_previos_odometer;?>"" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div> 
 </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <input type="text" name="in_odometer"  value="<?=@$preventive[0]->mt_in_odometer;?>" class="filter_required" placeholder="In Odometer" data-errors="{filter_required:'In Odometer should not blank'}" TABINDEX="8"  <?php echo $update; echo $approve; echo $rerequest;?>>


                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="city">Accidental Severity<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="accidental[mt_accidental_severity]" tabindex="8" class="" data-errors="{filter_required:'Accidental Severity should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Accidental Severity</option>
                                    <option value="Major" <?php if($preventive[0]->mt_accidental_severity == 'Major'){ echo "selected"; } ?>>Major</option>
                                    <option value="Minor" <?php if($preventive[0]->mt_accidental_severity == 'Minor'){ echo "selected"; } ?>>Minor</option>
                                    <option value="Other" <?php if($preventive[0]->mt_accidental_severity == 'Other'){ echo "selected"; } ?>>Other</option>
                                    
                            </select>
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="accidental[mt_ex_onroad_datetime]"  value="<?=@$preventive[0]->mt_ex_onroad_datetime;?>" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div>
                    </div> 
                </div>
                <div class="field_row width100" id="">
                <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="city">Accidental Type<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                             <!-- <input type="text" name="accidental[mt_accidental_type]"  value="<?=@$preventive[0]->mt_accidental_type;?>" class="" placeholder="Accidental type" data-errors="{filter_required:'Accidental type'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>> -->
                             <select name="accidental[mt_accidental_type]" id="accidental_type" tabindex="8" class="" data-errors="{filter_required:'Accidental Type should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Accidental Type</option>
                                    <option value="Head-On Collision" <?php if($preventive[0]->mt_accidental_type == 'Head-On Collision'){ echo "selected"; } ?>>Head-On Collision</option>
                                    <option value="Rear-End Collision" <?php if($preventive[0]->mt_accidental_type == 'Rear-End Collision'){ echo "selected"; } ?>>Rear-End Collision</option>
                                    <option value="Sidewipe Collision" <?php if($preventive[0]->mt_accidental_type == 'Sidewipe Collision'){ echo "selected"; } ?>>Sidewipe Collision</option>
                                    <option value="Vehicle Roll Over" <?php if($preventive[0]->mt_accidental_type == 'Vehicle Roll Over'){ echo "selected"; } ?>>Vehicle Roll Over</option>
                                    <option value="Single Accident" <?php if($preventive[0]->mt_accidental_type == 'Single Accident'){ echo "selected"; } ?>>Single Accident</option>
                                    <option value="Multiple Vehicle Collision" <?php if($preventive[0]->mt_accidental_type == 'Multiple Vehicle Collision'){ echo "selected"; } ?>>Multiple Vehicle Collision</option>
                                    <option value="Hit and Run Accident" <?php if($preventive[0]->mt_accidental_type == 'Hit and Run Accident'){ echo "selected"; } ?>>Hit and Run Accident</option>
                                    <option value="Falling Boulders" <?php if($preventive[0]->mt_accidental_type == 'Falling Boulders'){ echo "selected"; } ?>>Falling Boulders</option>
                                    <option value="Stray Animals" <?php if($preventive[0]->mt_accidental_type == 'Stray Animals'){ echo "selected"; } ?>>Stray Animals</option>
                                    <option value="Other" <?php if($preventive[0]->mt_accidental_type == 'Other'){ echo "selected"; } ?>>Any Other</option>


                            </select>
                            

                        </div>
                </div>
                        <div class="width2 float_left">
                            <div id="remark_other_textbox">

                            </div>
                        </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="damage_details">Damage Details<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <input type="text" name="accidental[mt_damage_details]"  value="<?=@$preventive[0]->mt_damage_details;?>" class="filter_required" placeholder="Damage Details" data-errors="{filter_required:'Damage Details should not blank'}" TABINDEX="8"  <?php echo $update; echo $approve; echo $rerequest;?>>


                        </div>
                    </div> 
                    
                    <!-- <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="accidental[mt_ex_onroad_datetime]"  value="<?=@$preventive[0]->mt_ex_onroad_datetime;?>" class=" filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div>
                    </div> -->
                    <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="in_odometer">In Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <input type="text" name="in_odometer"  value="<?=@$preventive[0]->mt_in_odometer;?>" class="filter_required" placeholder="In Odometer" data-errors="{filter_required:'In Odometer should not blank'}" TABINDEX="8"  <?php echo $update; echo $approve; echo $rerequest;?>>


                        </div>
                    </div> -->
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="city">Extent Damage<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="accidental[mt_extent_demage]" tabindex="8" class="" data-errors="{filter_required:'Extent Damage should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Extent Damage</option>
                                    <option value="Yes" <?php if($preventive[0]->mt_extent_demage == 'Yes'){ echo "selected"; } ?>>Yes</option>
                                    <option value="No" <?php if($preventive[0]->mt_extent_demage == 'No'){ echo "selected"; } ?>>No</option>
                                    
                            </select>
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="informed_to">Informed To<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <?php 
                            $informed_to = array();
                            if($preventive[0]->informed_to != ''){
                            $informed_to = json_decode($preventive[0]->informed_to); 
                            
                            } ?>
                            <?php //print_r($informed_to)?>
                            <div class="width_40 float_left">
                                <label for="service_police" class="chkbox_check">
                                    <input type="checkbox"  name="accidental[informed_to][]" class="check_input unit_checkbox" value="police"  id="service_police" <?php echo $update; echo $approve; echo $rerequest;?> <?php if(!empty($informed_to)){ if (in_array('police', $informed_to)) {
                                echo 'checked="checked"';
                            }}  ?>  <?php echo $update;?>>
                                    <span class="chkbox_check_holder"></span>Police<br>
                                </label>
                            </div>
                            <div class="width_40 float_left">
                                <label for="service_fire" class="chkbox_check">
                                    <input type="checkbox" name="accidental[informed_to][]" class="check_input unit_checkbox" value="fire"  id="service_fire" <?php echo $update; echo $approve; echo $rerequest;?> <?php if(!empty($informed_to)){ if (in_array('fire', $informed_to)) {
                                echo 'checked="checked"';
                            } }?>  <?php echo $update;?>>
                                    <span class="chkbox_check_holder"></span>Fire<br>
                                </label>
                            </div>
                            <div class="width_40 float_left">
                                <label for="service_insurance" class="chkbox_check">
                                    <input type="checkbox" name="accidental[informed_to][]" class="check_input unit_checkbox" value="insurance"  id="service_insurance" <?php echo $update; echo $approve; echo $rerequest;?> <?php if(!empty($informed_to)){ if (in_array('insurance', $informed_to)) {
                                echo 'checked="checked"';
                             }}?>  <?php echo $update;?>>
                                    <span class="chkbox_check_holder"></span>Insurance<br>
                                </label>
                            </div>
                            
                            <?php //Ashwini ?>
                            
                        <div class="width_80 float_left" >
                            <div class="multiselect  field_row" >
                                 <div class="selectBox" onclick="showCheckboxes()" >
                                    <select <?php echo $update; echo $approve; echo $rerequest;?>>
                                    <option value="">Select  Informed Employee</option>  
                                    </select>
                                </div>
                                <div id="checkboxes" >
                                    <label for="ADM" class="chkbox_check">
                                    <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-FLEETDESK" id="ADM">
                                    <span class="chkbox_check_holder"></span>ADM<br>
                                    </label>
                                    <label for="DM" class="chkbox_check">
                                    <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-FLEETDESK" id="DM">
                                    <span class="chkbox_check_holder"></span>DM<br>
                                    </label>
                                    <label for="Mechanic" class="chkbox_check">
                                    <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-FLEETDESK" id="Mechanic">
                                    <span class="chkbox_check_holder"></span>Mechanic<br>
                                    </label>
                                    <label for="one" class="chkbox_check">
                                    <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ShiftManager"   id="one" >
                                    <span class="chkbox_check_holder"></span>ShiftManager<br>
                                    </label>
                                    <label for="two" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-OperationHR"   id="two" >
                                        <span class="chkbox_check_holder"></span>Operation Manager<br>
                                    </label>
                                    <label for="three" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ShiftManager"   id="three" >
                                        <span class="chkbox_check_holder"></span>Account<br>
                                    </label>
                                    <label for="four" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-FleetManagement"   id="four" >
                                        <span class="chkbox_check_holder"></span>Fleet Manager<br>
                                    </label>
                                    <label for="five" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ZM"   id="five" >
                                        <span class="chkbox_check_holder"></span>Zonal Manager<br>
                                    </label>
                                    <label for="six" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-DM"   id="six" >
                                        <span class="chkbox_check_holder"></span>Area Operation Manager<br>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <script>
                            var expanded = false;               
                            function showCheckboxes() {
                            var checkboxes = document.getElementById("checkboxes");
                            if (!expanded) {
                                checkboxes.style.display = "block";
                                expanded = true;
                            } else {
                            checkboxes.style.display = "none";
                            expanded = false;
                            }
                            }
                        </script>
                        <?php //ashwini ?>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_towing_required">Towing Required<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="accidental[mt_towing_required]" tabindex="8" class="" data-errors="{filter_required:'Towing Required should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Towing Required</option>
                                    <option value="Yes" <?php if($preventive[0]->mt_towing_required == 'Yes'){ echo "selected"; } ?>>Yes</option>
                                    <option value="No" <?php if($preventive[0]->mt_towing_required == 'No'){ echo "selected"; } ?>>No</option>
                                    
                            </select>
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_police_on_scene">Police On Scene<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="accidental[mt_police_on_scene]" tabindex="8" class="" data-errors="{filter_required:'Police On Scene should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Police On Scene</option>
                                    <option value="Yes" <?php if($preventive[0]->mt_police_on_scene == 'Yes'){ echo "selected"; } ?>>Yes</option>
                                    <option value="No" <?php if($preventive[0]->mt_police_on_scene == 'No'){ echo "selected"; } ?>>No</option>
                                    
                            </select>
                           
                        </div>
                    </div>
                </div>
                
                <div class="field_row width100">
                    <!--<div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="off_road_date">Off-Road Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="accidental[mt_offroad_datetime]"  value="<?=@$preventive[0]->mt_offroad_datetime;?>" class="filter_required mi_timecalender" id="offroad_datetime" placeholder="Off-Road  Date/Time" data-errors="{filter_required:'Off-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>
                    </div>-->
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_fire_on_scene">Fire On Scene<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="accidental[mt_fire_on_scene]" tabindex="8" class="" data-errors="{filter_required:'Fire On Scene should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
                                    <option value="">Select Fire On Scene</option>
                                    <option value="Yes" <?php if($preventive[0]->mt_fire_on_scene == 'Yes'){ echo "selected"; } ?>>Yes</option>
                                    <option value="No" <?php if($preventive[0]->mt_fire_on_scene == 'No'){ echo "selected"; } ?>>No</option>
                                    
                            </select>
                           
                        </div>
                    </div>
                    <!-- <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="accidental[mt_ex_onroad_datetime]"  value="<?=@$preventive[0]->mt_ex_onroad_datetime;?>" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div>
                    </div> -->
                </div>
                <div class="field_row width100">

                 

<!--                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                                
                             
                                <select name="accidental[mt_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $update; echo $approve; echo $rerequest;?> > 
                                    <option value="" >Select Standard Remark</option>
                                    <option value="Ambulance_accidental_maintaince"  <?php 
                                    if (trim($preventive[0]->mt_stnd_remark) == 'Ambulance_accidental_maintaince') {
                                        echo "selected=selected";
                                    }
                                    ?>  >Ambulance Accidental Maintenance</option>
                                         <?php if ($update) { ?>  
                                    <option value="Ambulance_accidental_maintaince_onroad"  <?php 
                                    if (trim($preventive[0]->mt_stnd_remark) == 'Ambulance_accidental_maintaince_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Accidental Ambulance On-Road</option>  
                                        <?php } ?>
                                     <option value="Accidental Maintenance"  <?php
                                   if (trim($preventive[0]->mt_stnd_remark) == 'Accidental Maintenance') {
                                       echo "selected";
                                   }
                                   ?>>Accidental Maintenance</option>
                                </select>
                            </div>
                        </div>-->
                      

                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="accidental[mt_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update; echo $approve; echo $rerequest; ?>> <?= @$preventive[0]->mt_remark;  ?></textarea>
                        </div>
                    </div>
                                   
                                   
     <!--            <div class="width2 float_left">


                    <div class="field_lable float_left width33"> <label for="mt_send_material_request">Send Material Request<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50" >
                         <div class="width100 float_left send_material_request" id="send_material_request">
                <label for="mt_send_material_request_yes" class="radio_check width2 float_left">
                     <input id="mt_send_material_request_yes" type="radio" name="accidental[mt_send_material_request]" class="radio_check_input filter_either_or[mt_send_material_request_yes,mt_send_material_request_no]" value="Yes" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($preventive[0]->mt_send_material_request == "Yes"){ echo "checked";}?>>
                     <span class="radio_check_holder" ></span>Yes
                </label>
                <label for="mt_send_material_request_no" class="radio_check width2 float_left">
                    <input id="mt_send_material_request_no" type="radio" name="accidental[mt_send_material_request]" class="radio_check_input filter_either_or[mt_send_material_request_yes,mt_send_material_request_no]" value="No" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($preventive[0]->mt_send_material_request == "No"){ echo "checked";}?>>
                    <span class="radio_check_holder" ></span>No
                </label>
            </div> 
                    </div>

               
                </div> -->

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="added_by">Added By<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                            <?php if(empty($preventive)){
                                $clg_ref_id = $clg_ref_id ;
                            }else{
                                 $clg_ref_id = $preventive[0]->added_by ;
                            }?>
                            <input id="added_by" type="text" name="accidental[added_by]" class=""  data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>" value="<?= @$clg_ref_id;  ?>" disabled="disabled">
                        </div>
                    </div>

                </div>
               
                    
                </div>
                 <div id="send_material_request_block">
                    
                </div>
                <div id="hidden_maintence_part">
                    
                </div>
                
                <div class="width100">
                     <div class="field_row width100">
                    <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width15">
                                    <label for="photo">Upload Document</label>
                                </div>
                                <div class="field_lable width100 float_left">
                                    
                                    <i class="width100" style="height:30px; display: block;">Accident FIR, Investigation Report, Copy of Insurance estimate & JAES estimate, Accident Spot photo and vehicle damage photos</i>
                                </div>

                                <div class="field_row filter_width">

                                    <div class="field_lable">

<?php if (@$update) { ?>

                                            <div class="prev_profile_pic_box">

                                                <div class="clg_photo_field edit_form_pic_box" >

                                                    <?php
                                                    $name = $preventive[0]->mt_amb_photo;

                                                    $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                                    ?>

                                                </div>

                                            </div>

                                        </div>
                            <?php } ?>

                                </div>
                             
                            </div>
                            
                            <div class="filed_input outer_clg_photo field">
<!--                                <input type="hidden" name="prev_photo" value="<?= @$current_data[0]->clg_photo ?>"  <?php echo $update;?>/>-->
                                   <!--<div class="width1 text_align_center add_more_ind">

                                       <?php 
                                           if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                        <a class="image_more btn">Add more image +</a>
                                       <?php } ?>

                                    </div>-->
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                            <input multiple="multiple" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; echo $rerequest; ?> <?php echo $update; ?>  class="files_amb_photo">


                                        </div>
                                    </div>
                                 
                                </div>
                                
                                
        <?php if ($media) {
            //var_dump($media);
            foreach($media as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
            

                                        <div class="images_block" id="image_<?php echo $img->id;?>">
                            <?php if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                    <a class="remove_images click-xhttp-request" style="color:#000;" data-href="<?php echo base_url();?>ambulance_maintaince/remove_images" data-qr="id=<?php echo $img->id; ?>&output_position=image_<?php echo $img->id;?>"></a>
                            <?php } ?>
                                    <a class="ambulance_photo" target="blank" href="<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } else {
                                        echo $blank_pic_path;
                                    }
                                    ?>" style="background: url('<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } else {
                                        echo $blank_pic_path;
                                    }
                                    ?>') no-repeat left center; background-size: cover; height: 100px; width:150px; float:left;"  <?php echo $view; ?>></a>
                                </div>

        <?php } } ?>
              </div>
                </div>
                </div>
                </div>
            </div>
        </div>
                                    <?php if ($req_mate_part) { 
                           // var_dump($req_mate_part);
                            ?>
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Requested Maintenance Part Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Part Name</th>     
                                <th nowrap>Quantity</th>        

                            </tr>
                            <?php  //var_dump($his);
                            if ($req_mate_part > 0) {
                            //$count = 1;
                           foreach ($req_mate_part as $part_used) { ?>
                               
                            <tr>
                                <td><?php echo $part_used->inv_title; ?></td>  
                                <td><?php echo $part_used->ind_quantity; ?></td>
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
            </div>
     
                <?php } ?>
               
                <?php if ($update) { 
                    //var_dump($preventive[0]);
                    $previous_odo = $preventive[0]->mt_in_odometer;
                    ?>  
                    <div class="field_row width100  fleet"><div class="single_record_back">Current Information</div></div>
                    <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                   <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                 
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="mt_bill_number">Bill Number</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_bill_number" value="<?=@$preventive[0]->bill_number;?>" class="" placeholder="Bill Number" data-errors="{filter_required:'Bill Number should not be blank'}" TABINDEX="8" <?php if($preventive[0]->bill_number !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Cost Of Spare Parts</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_part_cost" id="part_cost" onkeyup="sum();" value="<?=@$preventive[0]->part_cost;?>" class=" " placeholder="Cost Of Spare Parts" data-errors="{filter_required:'Cost Of Spare Parts should not be blank'}" TABINDEX="8" <?php if($preventive[0]->part_cost !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Labour Cost</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_labour_cost" id="labour_cost" onkeyup="sum();" value="<?=@$preventive[0]->labour_cost;?>" class="" placeholder="Labour Cost" data-errors="{filter_required:'Labour Cost should not be blank'}" TABINDEX="8" <?php if($preventive[0]->labour_cost !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Total Amount</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_total_cost" id="total_cost" value="<?=@$preventive[0]->total_cost;?>" class=" " placeholder="Total Amount" data-errors="{filter_required:'Total Amount should not be blank'}" TABINDEX="8" <?php if($preventive[0]->total_cost !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>
                            
                            <?php 
                            $in_odometer_range = $preventive[0]->mt_in_odometer + 300;
                            ?>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_end_odometer" value="<?=@$preventive[0]->mt_end_odometer;?>" class="filter_required filter_valuegreaterthan[<?=@$preventive[0]->mt_in_odometer?>]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer'}" TABINDEX="8" <?php if($preventive[0]->mt_end_odometer !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-Road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="accidental[mt_onroad_datetime]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
<!--                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark</label></div>


                            <div class="filed_input float_left width50">
                                <select name="accidental[mt_on_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                    <option value="">Select Standard Remark</option>
                                    <?php if ($update) { ?>  <option value="Ambulance_maintaince_onroad"  <?php 
                                    if (@$preventive[0]->mt_on_stnd_remark == 'Ambulance_maintaince_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Accidental Ambulance On-road</option>  <?php } ?>
                                </select>
                            </div>
                        </div>-->
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark</label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="accidental[mt_on_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php if($preventive[0]->mt_on_remark  != ''){echo "disabled"; }?>><?= @$preventive[0]->mt_on_remark; ?></textarea>
                        </div>
                        </div>
                        
                    </div>
                    <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width33">
                                    <label for="photo">Jobcard/Invoice Photo</label>
                                </div>

                            <div class="filed_input outer_clg_photo width100">
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                            <input type="file" name="amb_job_card[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; echo $rerequest; ?>  class="files_amb_photo" multiple="multiple">


                                        </div>
                                    </div>
                                 
                                </div>
     

                            </div>

                    </div>
                </div>
            <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width33">
                                    <label for="photo">Other Photo</label>
                                </div>

                            <div class="filed_input outer_clg_photo width100">
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                            <input type="file" name="amb_invoice[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; echo $rerequest; ?>  class="files_amb_photo" multiple="multiple">


                                        </div>
                                    </div>
                                 
                                </div>
     

                            </div>

                    </div>
                </div>
                    

                <?php } ?>

                <?php if ($approve) {  ?>
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Re-Request Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Request Date</th>     
                                <th nowrap>Request by</th>        
                                <th nowrap>Re-Request Remark</th>
                                <th colspan="5" >Photo</th>
                            </tr>
                            <?php  
                            if ($his > 0) {
                           // $count = 1;
                           foreach ($his as $stat_data) {
                              /// var_dump($stat_data);
                              // die();
                           
                            ?>
                            <tr>
                                <td><?php echo $stat_data->re_request_date; ?></td>  
                                <td><?php echo $stat_data->re_requestby; ?></td>
                                <td><?php echo $stat_data->re_request_remark; ?></td> 
                                <?php /*
                                    $stat_data->re_request_remark;
                                */ 
                                     if($stat_data->his_photo){
                                        foreach($stat_data->his_photo as $im){

                                       // foreach($img as $im){
                                           
                                            $name = $im->media_name;
                                            //print_r($img);
                                            $pic_path = FCPATH . "uploads/ambulance/" . $name;
                                            if (file_exists($pic_path)) {
                                                $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                            }
                                            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                 ?>
                                <td><a class="ambulance_photo" target="blank" href="<?php if (file_exists($pic_path)) { echo $pic_path1; } else { echo $blank_pic_path; } ?>" style="background: url('<?php if (file_exists($pic_path)) { echo $pic_path1;  } else { echo $blank_pic_path; }  ?>') no-repeat left center; background-size: contain; height: 75px; width:100px;margin:5px;float:left;"  <?php echo $view; ?>></a></td>
                                        <?php //}
                                        }}
                                ?>
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
                    </div>




                    <div class="field_row width100  fleet"><div class="single_record_back">Approval Information</div></div>
                    <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            <?php //$gender[@$current_data[0]->clg_gender] = "checked"; ?>
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}" <?php echo $gender['male'];?> TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="2" <?php echo $gender['female'];?> class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Expected On-Road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_onroad_datetime]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->mt_app_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Estimate Amount<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_est_amt]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class=" OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Repairing Time</label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_rep_time]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class=" OnroadDate" placeholder="Repairing Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>

                    <div class="field_row width100 ap">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Work Shop<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_work_shop]"  data-value="<?=@$preventive[0]->ws_station_name;?>"  value="<?=@$preventive[0]->ws_station_name;?>" class="mi_autocomplete"  data-href="<?php echo base_url();?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Work Shop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update;?>>

                            </div>
                        </div>
<!--                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Ambulance Off-Road Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            <select name="app[mt_app_amb_off_status]" tabindex="8" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"  > 
                                    <option value="">Select Ambulance Off-road Status</option>
                                    <option value="Yes" >Yes</option>
                                    <option value="No">No</option>
                            </select>
                           

                            </div>
                        </div>-->
                       
                    </div>


                </div>

                <?php } ?>    
                <?php if ($req_mate_part) { ?>
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Requested Maintenance Part Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Part Name</th>     
                                <th nowrap>Quantity</th>        

                            </tr>
                            <?php  //var_dump($his);
                            if ($req_mate_part > 0) {
                            //$count = 1;
                           foreach ($req_mate_part as $part_used) { ?>
                               
                            <tr>
                                <td><?php echo $part_used->inv_title; ?></td>  
                                <td><?php echo $part_used->ind_quantity; ?></td>
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
            </div>
     
                <?php } ?>

                <?php if ($rerequest) {  ?>
                    
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Approve & Reject Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Date</th>     
                                <th nowrap>Approve/Reject by</th>        
                                <th nowrap>Remark</th>
                                <th nowrap>On Road Date</th>        
                                <th nowrap>Status</th>
                            </tr>
                            <?php  //var_dump($his);
                            if ($app_rej_his > 0) {
                            //$count = 1;
                           foreach ($app_rej_his as $stat_data) { 
                               if($stat_data->re_approval_status=="1"){$re_approval_status="Approved";}else{$re_approval_status="Reject";}?>
                            <tr>
                                <td><?php echo $stat_data->re_rejected_date; ?></td>  
                                <td><?php echo $stat_data->re_rejected_by; ?></td>
                                <td><?php echo $stat_data->re_remark; ?></td> 
                                <td><?php echo $stat_data->re_app_onroad_datetime; ?></td> 
                                <td><?php echo $re_approval_status; ?></td> 
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
                    </div>

                    <div class="field_row width100  fleet"><div class="single_record_back">Re-Request Information</div></div>
                    <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_previos_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                    <div class="field_row width100">
                        
                      
                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[re_request_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->re_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap">
                    <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Photo<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left" style="width: 50%;">
                        <input type="hidden" name="main_type" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>" data-base="amb_photo">
                        <input id="rerequest_reset_img" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  <?php echo $update;?> class="change-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/upload_photos"> 
                    </div>
                     </div>
                    </div>
                    <div class="field_row width100 ap">
                    <div class="button_box field_lable float_left" style="width: 60%;">
                        <input type="button" name="Reset" value="Reset Image" class="btn" id="remove_reset_img">
                    </div>
                    </div>
                <?php } ?>   
                <?php if (!@$view_clg) { ?>
                    <div class="button_field_row width100 margin_auto save_btn_wrapper">
                        <div class="button_box">
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } elseif($approve){ ?>Approve<?php }elseif($rerequest){ ?>Re-Request<?php }else{ ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request accept_btn " data-href='<?php echo base_url(); ?>ambulance_maintaince/<?php if ($update) { ?>update_accidental_maintaince<?php }elseif($approve){ ?>update_approval_accidental_maintaince<?php }elseif($rerequest){ ?>update_re_request_accidental_maintaince<?php }else { ?>accidental_maintaince_save<?php } ?>' data-qr='output_position=content&amp;module_name=clg&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$preventive[0]->mt_id; ?>">
                            
                            <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->
                        </div>
                    </div>

                <?php } ?>

                
                    
    </div>         
</form>
<script>

    
    jQuery(document).ready(function () {
    var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('#mt_onroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
   $("#offroad_datetime").change(function(){
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('.OnroadDate').datetimepicker({
            dateFormat: "yy-mm-dd ",
            minDate: $mindate,
            // minTime: jsDate[1],
            
        });
    });

    $('input[type=radio][name="app[mt_approval]"]').change(function(){
        //$("#ap").show();
        var app = $("input[name='app[mt_approval]']:checked").val();
        if(app == "1"){
            $(".ap").show();
        }else{
            $(".ap").hide();
        }
    });
    });
    function sum() {
      var txtFirstNumberValue = document.getElementById('part_cost').value;
      var txtSecondNumberValue = document.getElementById('labour_cost').value;
      var result =  parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total_cost').value = result;
      }
}
</script>
<style>
    .mi_loader{
        display: none !important;
    }
</style>