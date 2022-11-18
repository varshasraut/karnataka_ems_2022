<div id="dublicate_id"></div>

<?php 
if ($type == 'Update') {
    $update = 'disabled';
}elseif($type == 'Approve'){
    
    $approve = 'disabled';
}elseif($type == 'Rerequest'){
    $Rerequest = 'disabled';
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
                <div class="field_row width100  fleet" ><div class="single_record_back">Previous Information</div></div>
            <?php } ?>

            <div class="width100">

                <div class="field_row width100">
<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                if (@$preventive[0]->mt_state_id != '') {
                                    $st = array('st_code' => @$preventive[0]->mt_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => "MP", 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }


                                echo get_state_onraod_offraod_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>-->
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_district">
                                <input type="hidden" name="maintaince_state" value="MP">
                                <?php
                                if (@$preventive[0]->mt_amb_no != '') {
                                    $dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => @$preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }

                                echo get_district_onroad_offroad_amb($dt);
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
                                if (@$preventive[0]->mt_state_id != '') {
                                    $amd_dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => $preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    echo get_break_maintaince_ambulance($amd_dt);
                                } else {
                                    $amd_dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                    echo get_clo_comp_ambulance($amd_dt);
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
<!--                            <input name="base_location" tabindex="23" class="form_input filter_required" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update; ?>>-->
                            <input name="base_location" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" data-value="<?= @$preventive[0]->mt_base_loc; ?>" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update; echo $approve; echo $rerequest; ?>  data-callback-funct="load_baselocation_ambulance" data-href="<?php echo base_url();?>auto/get_hospital">

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div_outer">
                            
                            <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5" <?php echo $update; echo $approve; echo $rerequest; ?> >

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type_by_id($preventive[0]->amb_type); ?>
                            </select>


                        </div>


                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Owner</label></div>


                        <div class="filed_input float_left width50" id="amb_owner">
                            

                            <input name="maintaince[amb_owner]" tabindex="23" class="form_input " placeholder="Owner" type="text"  data-errors="{filter_required:'Ambulance Owner should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_owner; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                           
                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Ambulance Make should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_make; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" id="amb_amb_model">
                            

                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Model" type="text"  data-errors="{filter_required:'Ambulance Model should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_module; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>

                </div>
                <?php 
                    if($state_id == 'MP')
                    {
                       ?>
                       <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id</label></div>

                        <div class="filed_input float_left width50">

                            <input name="maintaince[mt_pilot_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'Pilot Id should not be blank!'}"  data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; echo $approve; echo $rerequest; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" class="filter_required" data-errors="{filter_required:'Pilot Name should not be blank!'}" placeholder="Pilot Name" type="text" name="preventive[mt_pilot_name]"  value="<?= @$preventive[0]->mt_pilot_name; ?>" TABINDEX="10"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>
                    </div>
                </div>
                        <?php
                    }else{
                    ?>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*<span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="maintaince[mt_pilot_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'Pilot Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; echo $approve; echo $rerequest; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name<span class="md_field">*<span></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="preventive[mt_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$preventive[0]->mt_pilot_name; ?>" TABINDEX="10"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="field_row width100">
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Estimate Cost<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="Estimatecost" tabindex="23" class="form_input filter_maxlength[7] filter_number filter_required" placeholder="Estimate Cost" type="text"  data-errors="{filter_required:'Estimate Cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
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
                                    <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ZM"   id="one" >
                                    <span class="chkbox_check_holder"></span>Zonal Manager<br>
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
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-DM"   id="four" >
                                        <span class="chkbox_check_holder"></span>Area Operation Manager<br>
                                    </label>
                                    <label for="five" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-FleetManagement"   id="five" >
                                        <span class="chkbox_check_holder"></span>Fleet Manager<br>
                                    </label>
                                    <label for="six" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" class="check_input unit_checkbox checkboxall" value="UG-ShiftManager"   id="six" >
                                        <span class="chkbox_check_holder"></span>Shift Manager<br>
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
                <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Off-road/On-road Maintenance Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="maintaince[mt_onraod_previos_odometer]" value="<?= $preventive[0]->mt_onraod_previos_odometer; ?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Accidental Maintenance Previous Odometer',filter_maxlength:'Accidental Maintenance Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" readonly='readonly'  <?php echo $update;
                                        echo $approve; ?>>


                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="previous_odometer" id="previous_odometer" onkeyup="sum();"  value="<?= $preventive[0]->mt_previos_odometer; ?>" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update;
                    echo $approve;
                    echo $rerequest; ?>>



                        </div> 
                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="in_odometer"  value="<?= @$preventive[0]->mt_in_odometer; ?>" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $update; echo $approve; ?>>


                        </div>
                    </div>
                   
                    <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="in_odometer">In Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <input type="text" name="in_odometer"  value="<?= @$preventive[0]->mt_in_odometer; ?>" class="filter_required" placeholder="In Odometer" data-errors="{filter_required:'In Odometer should not blank'}" TABINDEX="8"  <?php echo $update; echo $approve;?>>


                        </div>
                    </div> -->
                </div>

                <div class="field_row width100">
                    
                    <!-- <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="maintaince[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" readonly="readonly"  <?php echo $update; echo $approve;?>>



                        </div>
                    </div> -->
                </div>
                <div class="field_row width100">
                     <div class="width2 float_left">
                         <?php //var_dump($preventive); ?>

                         <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time</label></div>

                         <div class="filed_input float_left width50" >
                             <input type="text" name="maintaince[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" readonly="readonly"  <?php echo $update;
                echo $approve; ?>>



                         </div>
                     </div>



                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">

                            <select name="maintaince[mt_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $update; echo $approve;?> > 
                                <option value="" >Select Standard Remark</option>
<!--                                <option value="Ambulance_offroad"  <?php
                                if (@$preventive[0]->mt_stnd_remark == 'Ambulance_offroad') {
                                    echo "selected=selected";
                                }
                                ?>  >Ambulance Off road</option>-->
                                <?php if ($update) { ?>  
<!--                                <option value="ambulance_onroad"  <?php
                                    if (@$preventive[0]->mt_stnd_remark == 'ambulance_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Ambulance On road</option> -->
 <?php } ?>
                                    <option value="Ambulance off road"  <?php
                                   if (trim($preventive[0]->mt_stnd_remark) == 'Ambulance off road') {
                                       echo "selected";
                                   }
                                   ?>>Ambulance off road</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_offroad_reason">Off-Road Reason<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">

                           <select name="maintaince[mt_offroad_reason]" tabindex="8" class="" id="offroad_reason" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $update; echo $approve;?> > 
                                <option value="" >Select Off-Road Reason</option>
                                <?php echo get_offroad_reason(); ?>
<!--                                 <option value="Accidental  Maintenance"  <?php
                                if (@$preventive[0]->mt_offroad_reason == 'Accidental Maintenance') {
                                    echo "selected=selected";
                                }
                                ?>  >Accidental Maintenance</option>
                                <option value="Breakdown Maintenance"  <?php
                                if (@$preventive[0]->mt_offroad_reason == 'Breakdown Maintenance') {
                                    echo "selected=selected";
                                }
                                ?>  >Breakdown Maintenance</option>
                               
                                    <option value="Preventive Maintenance"  <?php
                                   if (trim($preventive[0]->mt_offroad_reason) == 'Preventive Maintenance') {
                                       echo "selected";
                                   }
                                   ?>>Preventive Maintenance</option>
                                     <option value="EMT Absent"  <?php
                                   if (trim($preventive[0]->mt_offroad_reason) == 'EMT Absent') {
                                       echo "selected";
                                   }
                                   ?>>EMT Absent</option>
                                      <option value="PILOT Absent"  <?php
                                   if (trim($preventive[0]->mt_offroad_reason) == 'PILOT Absent') {
                                       echo "selected";
                                   }
                                   ?>>PILOT Absent</option>
                                        <option value="Other"  <?php
                                   if (trim($preventive[0]->mt_offroad_reason) == 'Other') {
                                       echo "selected";
                                   }
                                   ?>>Other</option>-->
                            </select>
                        </div>
                    </div>
                     <div class="width2 float_left">
                        <div class="other_offroad hide">
                        <div class="field_lable float_left width33"> <label for="mt_remark">Other offroad reason<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                            <input type="text" name="maintaince[mt_other_offroad_reason]"  value="<?= @$preventive[0]->mt_other_offroad_reason; ?>" class="" placeholder="Other offroad reason" data-errors="{filter_required:'Other offroad reason should not be blank'}" TABINDEX="8"   <?php echo $update;  echo $approve; ?>>
                        </div>
                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="maintaince[mt_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update; echo $approve; ?>><?= @$preventive[0]->mt_remark; ?></textarea>
                        </div>
                    </div>
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
                <div class="width100">
                     <div class="field_row width2">
                    <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width33">
                                    <label for="photo">Photo</label>
                                </div>
                                

                                <div class="field_row filter_width">

                                    <div class="field_lable">

<?php if (@$update) { ?>

                                            <div class="prev_profile_pic_box">

                                                <div class="clg_photo_field edit_form_pic_box">

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
                           
                            <div class="filed_input outer_clg_photo">
                                 <!--<div class="width1 text_align_center add_more_ind">

                                        <?php  if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                        <a class="image_more btn">Add more image +</a>
                                       <?php } ?>

                                    </div>-->
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                            <input multiple="multiple"  type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; echo $rerequest; ?> <?php echo $update; ?>  class="files_amb_photo">


                                        </div>
                                    </div>
                                 
                                </div>
        <?php 
       // var_dump($update);
        if ($media) {
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
                                              <?php 
                                      if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                    <a class="remove_images click-xhttp-request" style="color:#000;" data-href="<?php echo base_url();?>ambulance_maintaince/remove_images" data-qr="id=<?php echo $img->id; ?>&output_position=image_<?php echo $img->id;?>"></a>
                                      <?php }?>

                                        <a class="ambulance_photo" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>


        <?php } } ?>
                                        </div>

                            </div>

                    </div>
                </div>
                </div>
            </div>
        </div>

                    <input type="hidden" name="maintaince[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
 
<?php
//var_dump($preventive);die();

if ($type == 'Update')  {

    $previous_odo = $preventive[0]->mt_in_odometer;
    $previous_odo_end =$preventive[0]->mt_in_odometer+300;
    
    ?>

            <div class="field_row width100  fleet"><div class="single_record_back">Current Information</div></div>

           <input type="hidden" name="previous_odometer" value="<?= @$preventive[0]->mt_in_odometer ; ?>">
            <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">


            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50" >
                        <input type="text" name="mt_end_odometer" value="<?= @$preventive[0]->mt_end_odometer; ?>" class="filter_required filter_rangelength1[<?php echo $preventive[0]->mt_in_odometer;?>-<?php echo $previous_odo_end;?>] filter_valuegreaterthan[<?php echo $preventive[0]->mt_in_odometer;?>] filter_maxlength[7]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should <?php echo $previous_odo; ?>-<?php echo $previous_odo_end; ?>',filter_maxlength:'Preventive Maintenance Previous Odometer at max 6 digit long.'}" TABINDEX="8" <?php if ($preventive[0]->mt_end_odometer != '') {
            echo "disabled";
        } ?>>


                    </div>
                </div>
                <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On road Date/Time<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50" >
                        <input type="text" name="maintaince[mt_onroad_datetime]"  value=" <?php if ($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '') {
            echo $preventive[0]->mt_onroad_datetime;
        } ?>" class="filter_required OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if ($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '') {
            echo "disabled";
        } ?> id="mt_onroad_datetime" readonly="readonly">



                    </div>
                </div>
            </div>
            <div class="field_row width100">
                <div class="filed_input float_left width2">

                    <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50">
                        <select name="maintaince[mt_on_stnd_remark]" tabindex="8"  data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                            <option value="">Select Standard Remark</option>
                                    <?php if ($update) { ?>  <option value="ambulance_onroad"  <?php
                                if (@$preventive[0]->mt_on_stnd_remark == 'ambulance_onroad') {
                                    echo "selected";
                                }
                                ?>>Ambulance On-road</option>  <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50" >
                        <textarea style="height:60px;" name="maintaince[mt_on_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$preventive[0]->mt_on_remark; ?></textarea>
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
                            //$count = 1;
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
                                        foreach($stat_data->his_photo as $img){

                                        foreach($img as $im){
                                           
                                            $name = $im->media_name;
                                            //print_r($img);
                                            $pic_path = FCPATH . "uploads/ambulance/" . $name;
                                            if (file_exists($pic_path)) {
                                                $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                            }
                                            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                 ?>
                                <td><a class="ambulance_photo" target="blank" href="<?php if (file_exists($pic_path)) { echo $pic_path1; } else { echo $blank_pic_path; } ?>" style="background: url('<?php if (file_exists($pic_path)) { echo $pic_path1;  } else { echo $blank_pic_path; }  ?>') no-repeat left center; background-size: contain; height: 75px; width:100px;margin:5px;float:left;"  <?php echo $view; ?>></a></td>
                                        <?php }
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
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_previos_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}" <?php echo $gender['male'];?> TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="2" <?php echo $gender['female'];?> class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_onroad_datetime]"  value=" <?php if($preventive[0]->mt_app_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_app_onroad_datetime != ''){ echo $preventive[0]->mt_app_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_app_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_app_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>
<!--                    <div class="field_row width100">
                    <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Ambulance Off-Road Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            <select name="app[mt_app_amb_off_status]" tabindex="8" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"  > 
                                    <option value="">Select Ambulance Off-road Status</option>
                                    <option value="Yes" >Yes</option>
                                    <option value="No">No</option>
                            </select>
                           

                            </div>
                        </div>
                    </div>-->
                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->mt_app_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <!-- <div class="field_row width100 ap">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Estimate Amount<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_est_amt]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class=" OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Repairing Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_rep_time]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class=" OnroadDate" placeholder="Repairing Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>

                    <div class="field_row width100 ap">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Work Shop<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_work_shop]"  data-value="<?=@$preventive[0]->ws_station_name;?>"  value="<?=@$preventive[0]->ws_station_name;?>" class="mi_autocomplete"  data-href="<?php echo base_url();?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Work shop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update;?>>

                            </div>
                        </div>
                       
                    </div> -->


                </div>

                <?php } ?>  <!-- </form>  
                <form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form1">    -->         
                <?php if($Rerequest){ ?>
                    
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
                           // $count = 1;
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
                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="rerequest_reset_img" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  <?php echo $update;?>> 
                    </div>
                     </div>
                    </div>
                    <div class="field_row width100 ap">
                    <div class="button_box field_lable float_left" style="width: 60%;">
                        <input type="button" name="Reset" value="Reset Image" class="btn" id="remove_reset_img">
                    </div>
                    </div>
                    
                <?php } 
                ?>


<?php if (!@$view_clg) { 
    //var_dump($type); 
    ?>
            <div class="button_field_row width100 margin_auto save_btn_wrapper">
                <div class="button_box">

               
                <input type="button" name="submit" value="<?php if ($type == 'Update') { ?>Update<?php } elseif($type == 'Approve'){ ?>Approve<?php } elseif($type == 'Rerequest'){ ?>Re-Request<?php } else{ ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request accept_btn " data-href='<?php echo base_url(); ?>ambulance_maintaince/<?php if ($type == 'Update'){ ?>update_onroad_offroad_maintaince<?php }elseif($type == 'Approve'){ ?>update_approval_onroad_offroad_maintaince<?php } elseif($type == 'Rerequest'){ ?>update_re_request_onroad_offroad_maintaince<?php }else{ ?>onroad_offroad_maintaince_save<?php } ?>' data-qr='output_position=content&amp;module_name=clg&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$preventive[0]->mt_id; ?>">

    <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->
                </div>
            </div>

<?php } ?>



    </div>         
</form>
<script>
//$(document).ready(function() {
//    
//
//    if (window.File && window.FileList && window.FileReader) {
//
//$("#rerequest_reset_img").on("change", function(e) {
//    //alert();
//  var files = e.target.files,
//    filesLength = files.length;
//  for (var i = 0; i < filesLength; i++) {
//    var f = files[i]
//    var fileReader = new FileReader();
//    fileReader.onload = (function(e) {
//      var file = e.target;
//      $("<span class=\"pip\">" +
//        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
//         +
//        "</span>").insertAfter("#rerequest_reset_img");
//        $("#remove_reset_img").click(function(){
//    $("#rerequest_reset_img").val("");
//    $("span[class=pip]").remove();
//});
//      $(".remove").click(function(){
//        
//      });
//      
//      
//      // Old code here
//      /*$("<img></img>", {
//        class: "imageThumb",
//        src: e.target.result,
//        title: file.name + " | Click to remove"
//      }).insertAfter("#files").click(function(){$(this).remove();});*/
//      
//    });
//    fileReader.readAsDataURL(f);
//  }
//});
//} else {
//alert("Your browser doesn't support to File API")
//}    
//
//  if (window.File && window.FileList && window.FileReader) {
//
//    $("#files").on("change", function(e) {
//      var files = e.target.files,
//        filesLength = files.length;
//      for (var i = 0; i < filesLength; i++) {
//        var f = files[i]
//        var fileReader = new FileReader();
//        fileReader.onload = (function(e) {
//          var file = e.target;
//          $("<span class=\"pip\">" +
//            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
//             +
//            "</span>").insertAfter("#files");
//            $("#reset_img").click(function(){
//        $("#files").val("");
//        $("span[class=pip]").remove();
//    });
//          $(".remove").click(function(){
//            
//          });
//          
//          
//          // Old code here
//          /*$("<img></img>", {
//            class: "imageThumb",
//            src: e.target.result,
//            title: file.name + " | Click to remove"
//          }).insertAfter("#files").click(function(){$(this).remove();});*/
//          
//        });
//        fileReader.readAsDataURL(f);
//      }
//    });
//  } else {
//    alert("Your browser doesn't support to File API")
//  }
//});
    
    jQuery(document).ready(function () {
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
        $("#offroad_reason").change(function () {
             var offroad_reason = $("#offroad_reason").val();
             console.log(offroad_reason);
             if(offroad_reason == 'Other'){
                 
                  $(".other_offroad").removeClass('hide');
             }else{
                 $(".other_offroad").addClass('hide');
             }
        });
    });

</script>