<div id="dublicate_id"></div>

<?php 
$approve ='';
$update ='';
$update_replace ='';
$rerequest ='';
if ($type == 'Update') {
    $update = 'disabled';
}elseif ($type == 'Update_replace') {
    $update_replace = 'disabled';
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
    </div>
    <div class="width100">

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">



                                <?php
                                if (@$preventive[0]->state != '') {
                                    $st = array('st_code' => @$preventive[0]->state, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => $state_id, 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
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
                               
                               if (@$preventive[0]->amb_ref_no != '') {
                                    $dt = array('dst_code' => @$preventive[0]->district, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => @$preventive[0]->amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => $state_id, 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
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
                                if (@$preventive[0]->amb_ref_no != '') {
                                 
                                    $dt = array('dst_code' => @$preventive[0]->district, 'st_code' => @$preventive[0]->state, 'amb_ref_no' => @$preventive[0]->amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                    
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
                            <input name="base_location" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" data-value="<?= @$preventive[0]->base_location; ?>" value="<?= @$preventive[0]->base_location; ?>" readonly="readonly"   <?php echo $update; echo $update_replace; echo $approve; echo $rerequest; ?>  data-callback-funct="load_baselocation_ambulance" data-href="<?php echo base_url();?>auto/get_hospital">


                        </div>
                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div_outer">
                            
                            <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5" <?php echo $update; echo $update_replace; echo $approve; echo $rerequest; ?> >

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type_by_id($preventive[0]->amb_type); ?>
                            </select>


                        </div>


                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Owner</label></div>


                        <div class="filed_input float_left width50" id="amb_owner">
                            

                            <input name="battery[amb_owner]" tabindex="23" class="form_input " placeholder="Owner" type="text"  data-errors="{filter_required:'Ambulance Owner should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_owner; ?>"    <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                           
                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Ambulance Owner should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_make; ?>"    <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_amb_model">
                            

                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Model" type="text"  data-errors="{filter_required:'Ambulance Owner should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_module; ?>"    <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>
                     <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Battery Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            

                            <input name="battery[battery_type]" class="mi_autocomplete"  data-href="<?php echo base_url(); ?>auto/get_battery_type" data-value="<?= @$preventive[0]->battery_type; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Battery Type"  <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>
                            
                        
                        </div>


                    </div>


                       <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id</label></div>

                        <div class="filed_input float_left width50">

                            <input name="battery[mt_pilot_id]" class="mi_autocomplete"  data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input  placeholder="Pilot Name" type="text" name="battery[mt_pilot_name]"  value="<?= @$preventive[0]->pilot_name; ?>" TABINDEX="10"    <?php echo $update; echo $update_replace; echo $approve; echo $rerequest; ?>>
                        </div>
                    </div>
                </div>
                    
         
                <div class="field_row width100" id="battery_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Prev. Odo When Battery Fitted<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="battery[prev_odo_when_battery_fitted]" value="<?=@$preventive[0]->prev_odo_when_battery_fitted;?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Accidental Maintenance Previous Odometer',filter_maxlength:'Accidental Maintenance Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" <?php echo $update; echo $update_replace; echo $approve; echo $rerequest; ?>>


                        </div>
                    </div>
 <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Last Updated Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="previous_odometer" id="previous_odometer" value="<?=@$preventive[0]->mt_previos_odometer;?>"" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div> 
 </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <input type="text" name="in_odometer"  value="<?=@$preventive[0]->mt_in_odometer;?>" class="filter_required" placeholder="In Odometer" data-errors="{filter_required:'In Odometer should not blank'}" TABINDEX="8"  <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>


                        </div>
                    </div>
                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="offroad_datetime">Onroad Date/Time</label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="battery[offroad_datetime]"  value="<?=@$preventive[0]->offroad_datetime;?>" class="mi_timecalender" placeholder="On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $update_replace; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div>
                    </div> 
                </div>
                
                <div class="field_row width100">


                      

                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="battery[remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update; echo $update_replace; echo $approve; echo $rerequest; ?>> <?= @$preventive[0]->remark;  ?></textarea>
                        </div>
                    </div>


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
                            <input id="added_by" type="text" name="battery[added_by]" class=""  data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>" value="<?= @$clg_ref_id;  ?>" disabled="disabled">
                        </div>
                    </div>

                </div>
               
                    
                </div>
           <?php if ($approve) {  ?>
              <div class="field_row width100  fleet"><div class="single_record_back">Approval Information</div></div>
                    <input type="hidden" name="app[bt_id]" id="ud_mt_id" value="<?= @$preventive[0]->bt_id ?>">
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->amb_ref_no;?>">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <?php //$gender[@$current_data[0]->clg_gender] = "checked"; ?>
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$current_data[0]->clg_ref_id?>"  id="Accepted" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}" <?php echo $gender['male'];?> TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="Rejected" type="radio" name="app[mt_approval]" value="2" <?php echo $gender['female'];?> class="approve" data-errors="{filter_required:'Approve should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>


                            </div>
                        </div>

                    </div>

                    <div class="field_row width100 hide_underprocess">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->mt_app_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>


           <?php } ?>
                    
                     <?php if ($update) {  ?>
              <div class="field_row width100  fleet"><h2 class="txt_clr2 width1 txt_pro">Update - Battery Details</h2></div>
                    <input type="hidden" name="app[bt_id]" id="ud_mt_id" value="<?= @$preventive[0]->bt_id ?>">
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->amb_ref_no;?>">
                    
                    <div class="field_row width100  fleet"><div class="single_record_back">NEW Battery Details</div></div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Battery Make
<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                           <select name="app[new_battery_make]" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <?php echo get_battery_make($preventive[0]->new_battery_make); ?>
                            </select>


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Battery Serial No.<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[new_battery_serial_no]" value="<?php echo $preventive[0]->new_battery_serial_no;?>" class="approve" data-errors="{filter_required:'Battery Serial No. should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Product Part Number<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[new_battery_part_no]" value="<?php echo $preventive[0]->new_battery_serial_no;?>" class="approve" data-errors="{filter_required:'Battery Serial No. should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Capacity & Voltage<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                           <select name="app[new_battery_voltage]" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" TABINDEX="5">
                                    <option value="">Select Type</option>
                                    <option value="100AH 12V" <?php if($preventive[0]->new_battery_voltage == '100AH 12V'){ echo "selected"; } ?>>100AH 12V</option>
                                    <option value="80AH 12V" <?php if($preventive[0]->new_battery_voltage == '80AH 12V'){ echo "selected"; } ?>>80AH 12V</option>
                                    <option value="65AH 12V" <?php if($preventive[0]->new_battery_voltage == '65AH 12V'){ echo "selected"; } ?>>65AH 12V</option>
                                    <option value="Others" <?php if($preventive[0]->new_battery_voltage == 'Others'){ echo "selected"; } ?>>Others</option>

                                  
                            </select>


                            </div>
                        </div>
                        

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Estimate Cost
<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[new_estimated_cost]" value="<?php echo $preventive[0]->new_battery_serial_no;?>" class="approve" data-errors="{filter_required:'Battery Serial No. should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>  
                                                <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="old_battery_voltage">Informed To<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                           <select name="app[old_infirm_to]" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" TABINDEX="5">
                              
                                    <option value="">Select Type</option>
                                    <option value="Fleet Manager" <?php if($preventive[0]->old_infirm_to == 'Fleet Manager'){ echo "selected"; } ?>> Fleet Manager</option>
                                    <option value="AOM" <?php if($preventive[0]->old_infirm_to == 'AOM'){ echo "selected"; } ?>>AOM</option>
                                    <option value="Zonal Manager" <?php if($preventive[0]->old_infirm_to == 'Zonal Manager'){ echo "selected"; } ?>>Zonal Manager</option>

                                  
                            </select>


                            </div>
                        </div>

                    </div>

                    <div class="field_row width100">
                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                                
                             
                                <select name="app[new_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}"> 
                                    <option value="" >Select Standard Remark</option>
                                    <option value="New_battery_details_Updated"  <?php 
                                    if (trim($preventive[0]->new_stnd_remark) == 'New_battery_details_Updated') {
                                        echo "selected=selected";
                                    }
                                    ?>  >New battery details Updated</option>
                                        
                                </select>
                            </div>
                        </div>
                        <div class="filed_input float_left width2">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_new_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$preventive[0]->mt_new_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100  fleet"><div class="single_record_back">Old Battery Details</div></div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Battery Make
<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                           <select name="app[old_battery_make]" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <?php echo get_battery_make($preventive[0]->new_battery_make); ?>
                            </select>


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="old_battery_serial_no">Battery Serial No.<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[old_battery_serial_no]" value="<?php echo $preventive[0]->old_battery_serial_no;?>" class="approve" data-errors="{filter_required:'Battery Serial No. should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="old_battery_part_no">Product Part Number<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[old_battery_part_no]" value="<?php echo $preventive[0]->old_battery_part_no;?>" class="approve" data-errors="{filter_required:'Battery Serial No. should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="old_battery_voltage">Capacity & Voltage<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                           <select name="app[old_battery_voltage]" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" TABINDEX="5">
                                    <option value="">Select Type</option>
                                    <option value="100AH 12V" <?php if($preventive[0]->old_battery_voltage == '100AH 12V'){ echo "selected"; } ?>>100AH 12V</option>
                                    <option value="80AH 12V" <?php if($preventive[0]->old_battery_voltage == '80AH 12V'){ echo "selected"; } ?>>80AH 12V</option>
                                    <option value="65AH 12V" <?php if($preventive[0]->old_battery_voltage == '65AH 12V'){ echo "selected"; } ?>>65AH 12V</option>
                                    <option value="Others" <?php if($preventive[0]->old_battery_voltage == 'Others'){ echo "selected"; } ?>>Others</option>

                                  
                            </select>


                            </div>
                        </div>
                        

                    </div>
                    <div class="field_row width100">
        
                                                <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="old_battery_voltage">Old battery Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                           <select name="app[old_battery_status]" class="filter_required" data-errors="{filter_required:'Old battery Status should not be blank'}" TABINDEX="5">
                              
                                    <option value="">Select Type</option>
                                    <option value="With Pilot" <?php if (trim($preventive[0]->old_battery_status) == 'With Pilot') { echo "selected=selected"; } ?>>With Pilot</option>
                                    <option value="With EMT" <?php if (trim($preventive[0]->old_battery_status) == 'With EMT') { echo "selected=selected"; } ?>>With EMT</option>
                                    <option value="With Location" <?php if (trim($preventive[0]->old_battery_status) == 'With Location') { echo "selected=selected"; } ?>>With Location</option>
                                    <option value="With Vendor" <?php if (trim($preventive[0]->old_battery_status) == 'With Vendor') { echo "selected=selected"; } ?>>With Vendor</option>
                                    <option value="With AOM" <?php if (trim($preventive[0]->old_battery_status) == 'With AOM') { echo "selected=selected"; } ?>>With AOM</option>

                                  
                            </select>


                            </div>
                        </div>


                    </div>

                    <div class="field_row width100">
                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                                
                             
                                <select name="app[old_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}"> 
                                    <option value="" >Select Standard Remark</option>
                                    <option value="Old_battery_details_Updated"  <?php 
                                    if (trim($preventive[0]->old_stnd_remark) == 'Old_battery_details_Updated') {
                                        echo "selected=selected";
                                    }
                                    ?>  >Old battery details Updated</option>
                                        
                                </select>
                            </div>
                        </div>
                        <div class="filed_input float_left width2">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_old_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$preventive[0]->mt_old_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>


           <?php } ?>
            <?php if ($update_replace) { ?>
                      <div class="field_row width100  fleet"><h2 class="txt_clr2 width1 txt_pro">Update - Battery Details</h2></div>
                    <input type="hidden" name="app[bt_id]" id="ud_mt_id" value="<?= @$preventive[0]->bt_id ?>">
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->amb_ref_no;?>">
                    
                       <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Vendor Name<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                                <input  type="text" name="app[vendor_name]" value="<?php echo $preventive[0]->vendor_name;?>" class="approve" placeholder="Vendor Name" data-errors="{filter_required:'Battery Serial No. should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Bill Number
<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                                <input  type="text" name="app[bill_no]" value="<?php echo $preventive[0]->bill_no;?>" class="approve" placeholder="Bill Number" data-errors="{filter_required:'Bill Number should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>

                    </div>
                     <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Cost of Spare Parts<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[cost_of_part]" value="<?php echo $preventive[0]->cost_of_part;?>" class="approve" placeholder="Cost of Spare Parts"  data-errors="{filter_required:'Cost of Spare Parts should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Labour Cost
<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <input  type="text" name="app[labour_cost]" value="<?php echo $preventive[0]->labour_cost;?>" class="approve" placeholder="Labour Cost" data-errors="{filter_required:'Labour Cost should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Total Amount<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                                <input  type="text" name="app[total_amount]" value="<?php echo $preventive[0]->total_amount;?>" class="approve" placeholder="Total Amount" data-errors="{filter_required:'Total Amount should not be blank'}" TABINDEX="17" >


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Payment Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                    
                             <select name="app[payment_status]" class="filter_required" data-errors="{filter_required:'Payment Status should not be blank'}" TABINDEX="5">
                              
                                    <option value="">Select Payment Status</option>
                                    <option value="Paid" <?php if (trim($preventive[0]->payment_status) == 'Paid') { echo "selected=selected"; } ?>>Paid</option>
                                    <option value="Unpaid" <?php if (trim($preventive[0]->payment_status) == 'Unpaid') { echo "selected=selected"; } ?>>Unpaid</option>
                                    <option value="Not Known" <?php if (trim($preventive[0]->payment_status) == 'Not Known') { echo "selected=selected"; } ?>>Not Known</option>
                                   

                                  
                            </select>


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
                            <input type="text" name="mt_end_odometer" value="<?=@$preventive[0]->mt_end_odometer;?>" class="filter_required filter_rangelength[<?php echo $preventive[0]->mt_in_odometer;?>-<?php echo $in_odometer_range ?>]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should between <?php echo $preventive[0]->mt_in_odometer; ?>-<?php echo $in_odometer_range; ?>'}" TABINDEX="8" <?php if($preventive[0]->mt_end_odometer !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                           <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Total Distance Travelled<span class="md_field">*</span></label></div>
                            
                  

                            <div class="filed_input float_left width50" >
                            <input type="text" name="total_distance_traveled" value="<?=@$preventive[0]->mt_end_odometer;?>" class="filter_required " placeholder="Total Distance Travelled" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should between <?php echo $preventive[0]->mt_in_odometer; ?>-<?php echo $in_odometer_range; ?>'}" TABINDEX="8" <?php if($preventive[0]->total_distance_traveled !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                    </div>
                      <div class="field_row width100">
                        <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                            <div class="filed_input float_left width50">
                                
                             
                                <select name="app[update_replace_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}"> 
                                    <option value="" >Select Standard Remark</option>
                                    <option value="Battery replacement updated & Ambulance Onroad"  <?php 
                                    if (trim($preventive[0]->update_replace_stnd_remark) == 'Battery replacement updated & Ambulance Onroad') {
                                        echo "selected=selected";
                                    }
                                    ?>  >Battery replacement updated & Ambulance Onroad</option>
                                        
                                </select>
                            </div>
                        </div>
                        <div class="filed_input float_left width2">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_update_replace_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$preventive[0]->mt_update_replace_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
            <?php } ?>
           <?php if (!@$view_clg) { ?>
                    <div class="button_field_row width100 margin_auto save_btn_wrapper">
                        <div class="button_box">
                            <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else if($approve){ ?>Approve<?php } else if($update_replace){ ?>Update<?php }else{ ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request accept_btn " data-href='<?php echo base_url(); ?>battery/<?php if ($update) { ?>update_battery<?php }elseif($approve){ ?>update_approve_battery_life<?php }if($update_replace){ ?>update_battery<?php }else { ?>battery_save<?php } ?>' data-qr='output_position=content&amp;module_name=clg&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$preventive[0]->mt_id; ?>">
 
                        </div>
                    </div>

                <?php } ?>
    </div>
</form>