<div id="dublicate_id"></div>

<?php
if ($type == 'Update') {
    $update = 'disabled';
}if($type == 'Approve')
{
    $Approve = 'disabled';
}if($type == 'Re_request')
{
    $Re_request = 'disabled';
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
           <!-- <div class="field_row width100  fleet"><div class="single_record_back">Previous Info</div></div>-->
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


                                  echo get_state_clo_comp_ambulance($st);
                                ?>

                            </div>

                        </div>

                    </div>
                    <div class="width2 float_left">    
                        <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   
                        <div class="filed_input float_left width50">
                            <div id="maintaince_district">
                                <?php
                                if (@$preventive[0]->mt_state_id != '') {
                                    $dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
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
                            <div id="maintaince_ambulance">



                                <?php
                              
                                if (@$preventive[0]->mt_district_id != '') {
                                    $dt = array('dst_code' => @$preventive[0]->mt_district_id, 'st_code' => @$preventive[0]->mt_state_id, 'amb_ref_no' => @$preventive[0]->mt_amb_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                                }

                                  echo get_clo_comp_ambulance($dt);
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="base_location" tabindex="23" class="form_input filter_required" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update; echo $Approve; echo $Re_request; ?>>

                        </div>
                         


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div_outer">
                            
                            <select name="amb_type" class="filter_required" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type_by_id($preventive[0]->amb_type); ?>
                            </select>


                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                           
                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_model; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_amb_model">
                            

                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Model" type="text"  data-errors="{filter_required:'Ambulance Model should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->amb_model; ?>"    <?php echo $update; echo $approve; echo $rerequest;?>>
                        </div>


                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">EMT ID : </div>
                            </div>
                            <div class="width50 float_left">
                                <input name="mt_emt_id" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_emso_id" data-value="<?= @$preventive[0]->mt_emt_id; ?>" value="<?= @$preventive[0]->mt_emt_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_emso_id"  id="emt_list" data-errors="{filter_required:'Ambulance should not be blank!'}" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">EMT Name : </div>
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
                                <div class=" float_left">Pilot ID : </div>
                            </div>
                            <div class="width50 float_left">
                             
                                <input name="mt_pilot_id" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_pilot_id" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot ID" data-callback-funct="show_pilot_idnew"  id="pilot_list" data-errors="{filter_required:'Pilot ID should not be blank!'}" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class=" float_left">Pilot Name : </div>
                            </div>
                            <div class="width50 float_left" id="show_pilot_name">
                                <input name="pilot_name" tabindex="25" class="form_input" placeholder="Pilot Name" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= @$preventive[0]->mt_pilot_name; ?>" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                                
                            </div>
                        </div>

                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="city">Equipment Type<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input type="text" name="breakdown[eq_equip_name_type]" tabindex="1"  class="mi_autocomplete width1" data-href="<?php echo base_url(); ?>auto/get_inv_eqp_type/" value="<?= @$preventive[0]->type_id; ?>" data-value="<?php echo @$preventive[0]->type_name; ?>"  placeholder="Equipment Type" autocomplete="off" data-auto="EQP"  data-nonedit="yes" <?php echo $update; echo $Approve; echo $Re_request; ?> data-callback-funct="show_equipments_by_type">
                             
                            </div>
                    </div>
                    <div class="width2 float_left">
                     <div class="field_lable float_left width33"><label for="city">Equipments<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50" id="show_equipments_by_type">
<!--                                <input type="text" name="main[eq_equip_name]" tabindex="1"  class="mi_autocomplete width1" data-href="<?php echo base_url(); ?>auto/get_inv_eqp/dq/<?php echo $equp_data[0]->eqp_id; ?>" data-value="<?= @$preventive[0]->eqp_name; ?>" value="<?php echo @$equp_data[0]->eqp_id; ?>"  placeholder="Equipment Name" autocomplete="off" data-auto="EQP"  data-nonedit="yes" <?php echo $update; echo $Approve; echo $Re_request; ?> >-->
                                <select name="main[eq_equip_name][]" class="filter_required" data-errors="{filter_required:'Equipment Name should not be blank'}" <?php echo $update; echo $Approve; echo $Re_request; ?> TABINDEX="5" id="equipments_name" onchange="equipments_by_type()">

                                    <option value="">Select Equipment Name</option>
                                    <?php
                                    foreach($eqp as $eq){
                                        $eq_equip_name = unserialize($preventive[0]->eq_equip_name);
                                      
                                         $selected = "";
                                        if (is_array($eq_equip_name)) {
                                            if (in_array($eq->eqp_id, $eq_equip_name)) {
                                                $selected = "Selected=selected";
                                            }
                                        }else{
                                           if ($eq->eqp_id== $preventive[0]->eq_equip_name) {
                                                $selected = "Selected=selected";
                                            } 
                                        }
                                        ?>
                                    
                                    <option value="<?php echo $eq->eqp_id; ?>" <?php echo $selected;?>><?php echo $eq->eqp_name; ?></option>
                                    
                                    <?php    
                                    }?>
                                </select>
                                <?php //var_dump($preventive[0]->eqp_name);?>
                            </div>
                    </div>
                    <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Equipment Serial No</label></div>
                            <div class="filed_input float_left width50">
                                <input type="text" name="breakdown[eq_equip_serial_no]" tabindex="1"  class="width1"  value="<?php echo @$preventive[0]->eq_equip_serial_no; ?>"  placeholder="Equipment Serial No" autocomplete="off" data-auto="EQP"  data-nonedit="yes" <?php echo $update; echo $Approve; echo $Re_request; ?>>                                
                            </div>
                    </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                                <select name="breakdown[mt_shift_id]" tabindex="8"class="filter_required" data-errors="{filter_required:'Shift Type should not be blank!'}"  <?php echo $update; echo $Approve; echo $Re_request; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type($preventive[0]->mt_shift_id);?>
                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Service Center</label></div>

                            <div class="filed_input float_left width50">
                              
                               <input type="text" name="breakdown[mt_service_center]"  data-value="<?=@$preventive[0]->es_service_center_name;?>"  value="<?=@$preventive[0]->mt_service_center;?>" class="mi_autocomplete"  data-href="<?php echo base_url();?>auto/get_server_station"  placeholder="Service Center" data-errors="{filter_required:'Please select Service Center Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update; echo $Approve; echo $Re_request; ?>>

                            </div>
                        </div>

                    </div>
                    

                </div>
                
<!--                <div class="field_row width100" id="maintance_previous_odometer">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                             <input type="text" name="previous_odometer"  value="<?=@$preventive[0]->mt_previos_odometer;?>" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Work shop Name from dropdown list'}" TABINDEX="8"  <?php echo $update;?>>


                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="in_odometer">In Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                             <input type="text" name="in_odometer"  value="<?=@$preventive[0]->mt_in_odometer;?>" class="filter_required" placeholder="In Odometer" data-errors="{filter_required:'In Odometer should not blank'}" TABINDEX="8"  <?php echo $update;?>>


                        </div>
                    </div>
                </div>-->
                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="city">Breakdown Severity<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="breakdown[mt_brakdown_severity]" tabindex="8" class="filter_required" data-errors="{filter_required:'Breakdown Severity should not be blank!'}"  <?php echo $update; echo $Approve; echo $Re_request;?>> 
                                    <option value="">Select Breakdown Severity</option>
                                    <option value="Major" <?php if($preventive[0]->mt_brakdown_severity == 'Major'){ echo "selected"; } ?>>Major</option>
                                    <option value="Minor" <?php if($preventive[0]->mt_brakdown_severity == 'Minor'){ echo "selected"; } ?>>Minor</option>
                                    <option value="Other" <?php if($preventive[0]->mt_brakdown_severity == 'Other'){ echo "selected"; } ?>>Other</option>
                                    
                            </select>
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="city">Problem observed<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" id="show_breakdown_type">
<!--                             <input type="text" name="breakdown[mt_breakdown_type]"  value="<?=@$preventive[0]->mt_breakdown_type;?>" class="filter_required" placeholder="Problem Observed" data-errors="{filter_required:'Problem Observed'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request;?>>-->
                            
<!--                           
                           <select name="breakdown[mt_breakdown_type][]" class="filter_required" data-errors="{filter_required:'Problem observed*should not be blank'}" <?php echo $update; echo $Approve; echo $Re_request; ?> TABINDEX="5"  multiple="multiple">

                                    <option>Select Problem observed*</option>
                                    <?php
//                                    if($eqp_obs){
//                                    foreach($eqp_obs as $eq){ 
//                                          $selected = "";
//                                          $mt_breakdown_type = array();
//                                          $mt_breakdown_type = unserialize($preventive[0]->mt_breakdown_type);
//                                       
//                                          
//                                        if(in_array($eq->eb_type_id,$mt_breakdown_type)){
//                                            $selected = "Selected=selected";
//                                        }
                                        
                                        ?>
                                    
                                    <option value="<?php echo $eq->eb_type_id; ?>" <?php echo $selected;?>><?php echo $eq->eb_name; ?></option>
                                    
                                    <?php    
                                    //} } ?>
                                </select>-->
                               <div class="width100 float_left non_unit_drags">

                            <input name="non_unit_drags" tabindex="7" class="form_input" placeholder="Problem observed" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}"  <?php echo $update; echo $Approve; echo $Re_request;?>>
                            <div id="non_unit_drugs_box">

                                <?php
                                 $mt_breakdown_type = array();
                                 $mt_breakdown_type = unserialize($preventive[0]->mt_breakdown_type);
                              
                                if ($mt_breakdown_type) {


                                    foreach ($mt_breakdown_type as $key=>$type) {
                                        //var_dump($pcr_med);
                                        if(isset($type['id'])){
                                            $med_inv_data[$key] = $type['id'];
                                        }
                                    }
                                }
                                    
                                
                                ?>

                                <div class="unit_drugs_box">
                                    <?php if ($eqp_obs) { ?>
                                        <ul class="width100">
                                            <?php foreach ($eqp_obs as $eq) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $eq->eb_type_id; ?>" class="chkbox_check">
                                                        <input type="checkbox" name="breakdown[mt_breakdown_type][<?php echo $eq->eb_type_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $eq->eb_type_id; ?>" id="unit_<?php echo $eq->eb_type_id; ?>" <?php
                                                      if(is_array($med_inv_data)){
                                                        if(in_array($eq->eb_type_id,$med_inv_data)){
                                            echo "checked";
                                                      } }
                                                        ?> data-base="non_unit_iteam" onclick="show_non_unit_box();"  <?php echo $update; echo $Approve; echo $Re_request;?>>
                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($eq->eb_name); ?><br>
                                                    </label>
                                                </li>
                                                
                                                <input name="non_unit_iteam" id="show_non_unit_drugs_box" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="<?php echo base_url(); ?>/biomedical/show_problem_observed" data-qr="output_position=show_selected_unit_item" type="button">
                                            <?php } ?>
<!--                                                <li class="unit_block">
                                                    <label for="unit_na" class="chkbox_check">


                                                        <input type="checkbox" name="unit['other'][id]" class="check_input unit_checkbox" value="other"  id="unit_na" data-base="non_unit_iteam">


                                                        <span class="chkbox_check_holder"></span>Other<br>
                                                    </label>
                                                </li>-->
                                                <li class="unit_block">
                                                    <label for="unit_na" class="chkbox_check">


                                                        <input type="checkbox" name="unit['missing'][id]" class="check_input unit_checkbox" value="missing"  id="unit_missing" data-base="non_unit_iteam">


                                                        <span class="chkbox_check_holder"></span>Missing<br>
                                                    </label>
                                                </li>
                                        </ul>
                                     
                                        
                                    <?php } ?>
                                </div>
                                 <div id="show_selected_unit_item" style="width:95%">
                                </div>



                            </div>  
                        </div>
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="breakdown_date">Breakdown Date<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="breakdown_date"  value="<?=@$preventive[0]->mt_breakdown_date; ?>" class="filter_required mi_timecalender" id="breakdown_date" placeholder="Breakdown date and time" data-errors="{filter_required:'Accident date should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="estimatecost">Estimate cost</label></div>


                        <div class="filed_input float_left width50" >
                        <input name="Estimatecost" tabindex="23" class="form_input filter_if_not_blank filter_number" placeholder="Estimate cost" type="text"  data-errors="{filter_required:'Estimate cost should not be blank!',filter_number:'Estimate cost should be Number!'}"  value="<?=@$preventive[0]->mt_estimatecost; ?>"   <?php echo $update; echo $Approve; echo $Re_request; ?>>
                     </div>
                    </div>
                </div>
<!--                <div class="field_row width100">
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="off_road_date">Off-Road  Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="breakdown[mt_offroad_datetime]"  value="<?=@$preventive[0]->mt_offroad_datetime;?>" class="filter_required" id="offroad_datetime" placeholder="Off-Road  Date/Time" data-errors="{filter_required:'Off-Road  Date/Time should not be blank'}" TABINDEX="8" <?php echo $update;?>>
                              
                           
                           
                        </div>
                    </div>
                    <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="breakdown[mt_ex_onroad_datetime]"  value="<?=@$preventive[0]->mt_ex_onroad_datetime;?>" class="filter_required On road Date" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update;?>>
                              
                           
                           
                        </div>
                    </div>
                </div>-->
                <div class="field_row width100">

                 

                       <!-- <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                
                             
                                <select name="breakdown[mt_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $disabled; ?> <?php echo $update; echo $Approve; echo $Re_request; ?> > 
                                    <option value="" >Select Standard Remark</option>
                                    <option value="Ambulance_breakdown_maintaince"  <?php 
                                    if (trim($preventive[0]->mt_stnd_remark) == 'Ambulance_breakdown_maintaince') {
                                        echo "selected=selected";
                                    }
                                    ?>  >Ambulance Equipment Maintenance</option>
                                         <?php if ($update) { ?>  <option value="Ambulance_breakdown_maintaince_onroad"  <?php 
                                    if (trim($preventive[0]->mt_stnd_remark) == 'Ambulance_breakdown_maintaince_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Ambulance Equipment Maintenance On-road</option>  <?php } ?>
                                </select>
                            </div>
                        </div>-->
                      

                   
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_remark">Remark</label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="breakdown[mt_remark]"  TABINDEX="16" data-maxlen="1600"   <?php echo $update; echo $Approve; echo $Re_request; ?>><?= @$preventive[0]->mt_remark; ?></textarea>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">


                
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Off-road Ambulance<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50" id="break_is_amb_offroad">
                                <div class="float_left width33">

                                    <label for="no" class="chkbox_check">

                                        <input type="checkbox" name="breakdown[is_amb_offroad]" class="groupcheck check_input" value="no" data-errors="{filter_either_or:'Off-Road Ambulance should not be blank!'}" id="no" <?php if ($preventive[0]->is_amb_offroad == 'no' || $preventive[0]->is_amb_offroad == '') { echo "checked";} ?> <?php echo $update; echo $Approve; echo $Re_request; ?>>

                                        <span class="chkbox_check_holder"></span>No 

                                    </label>

                                </div>

                                <div class="float_left width33">

                                    <label for="yes" class="chkbox_check">

                                        <input type="checkbox" name="breakdown[is_amb_offroad]" class="groupcheck check_input" value="yes" data-errors="{filter_either_or:'Off-Road Ambulance should not be blank!'}" id="yes"  <?php if ($preventive[0]->is_amb_offroad == 'yes') { echo "checked";} ?> <?php echo $update; echo $Approve; echo $Re_request; ?>>

                                        <span class="chkbox_check_holder"></span>Yes

                                    </label>

                                </div>
                        </div>
                          <input type="hidden" name="is_amb_offroad" value="<?=@$preventive[0]->is_amb_offroad;?>">
                    </div>
                </div>
                <div class="field_row width100" id="change_maintance_status">
                    <?php if($preventive[0]->is_amb_offroad == 'yes'){ ?>
                    
                    <div class="width100">

    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Previous Breakdown Equipment Odometer<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
            <input name="previous_odmeter" tabindex="0" class="form_input filter_required" placeholder="" type="text" data-base="search_btn" value="<?php echo $preventive[0]->mt_previous_breakdown_odmeter ; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!'}" readonly="readonly"  <?php echo $update; echo $Approve; echo $Re_request; ?>>
        </div>
    </div>
    <?php
//    if ($amb_status == '6') {
//        $disable = "disabled";
//        $start = $previous_odometer;
//    } else {
//        $disable = "";
//        $previous_odometer = $preventive[0]->mt_previos_odometer;
//    }
    ?>
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Last Latest Odometer<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
            <input name="start_odmeter" tabindex="1" class="filter_required form_input filter_number"  placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?php echo $preventive[0]->mt_previos_odometer; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!',filter_number:'Start Odometer should not be Number!',filter_rangelength:'Start Odometer should not be same as previous odometer!'}" <?php echo $disable; ?>  <?php echo $update; echo $Approve; echo $Re_request; ?>>
        </div>
    </div>
 
        <div class="width50 drg float_left">
            <div class="width33 float_left">
                <div class=" float_left">Current Odometer<span class="md_field">*</span> : </div>
            </div>
            <div class="width50 float_left">
                <input name="end_odmeter" value="<?php echo $preventive[0]->mt_in_odometer; ?>" tabindex="1" class="filter_required form_input"  placeholder="Enter End Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'End Odometer should not be blank!',filter_valuegreaterthan:'Start Odometer should not be Greater than previous odometer!'}"   <?php echo $update; echo $Approve; echo $Re_request;?>>
            </div>
        </div>
   
    
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Off-Road Standard Remark<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
           

            <input name="remark"  id="remark_input" class="mi_autocomplete filter_required" data-href="{base_url}auto/get_eqp_standard_emark/add" data-value="<?php echo get_eqp_breakdown_standard_remark($preventive[0]->mt_off_stnd_remark); ?>" value="<?php echo $preventive[0]->mt_off_stnd_remark; ?>" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_other_offroad_standard_remark" data-errors="{filter_required:'Remark should not be blank!'}" <?php echo $update; echo $Approve; echo $Re_request;?>>
        </div>
    </div>
    <?php if($preventive[0]->other_offroad_standard_remark != '' && $preventive[0]->other_offroad_standard_remark != NULL){ ?>
        <div class="width50 drg float_left" id='show_other_offroad_standard_remark'>
            <div class="width33 float_left">
                <div class=" float_left">Other Standard Remark<span class="md_field">*</span> : </div>
            </div>
            <div class="width50 float_left">

                <input name="other_offroad_standard_remark" class=""  value="<?php echo $preventive[0]->other_offroad_standard_remark; ?>" type="text" tabindex="2" placeholder=" Remark" data-errors="{filter_required:'Remark should not be blank!'}" <?php echo $update; echo $Approve; echo $Re_request;?>>
            </div>
        </div>    
    <?php } ?>
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left"> Remark<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">

            <input name="common_remark_other" class="filter_required" value="<?php echo $preventive[0]->common_remark_other; ?>"  type="text" tabindex="2" placeholder=" Remark" data-errors="{filter_required:'  Remark should not be blank!'}"   <?php echo $update; echo $Approve; echo $Re_request;?>>
        </div>
    </div> 
</div>
<div class="field_row width100">
    <div id="odometer_remark_other_textbox">

    </div>
</div>

<div class="field_row width100">
    <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="off_road_date">Off-road  Date/Time<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >
            <input type="text" name="breakdown[mt_offroad_datetime]"  value="<?= @$preventive[0]->mt_offroad_datetime; ?>" class="filter_required mi_timecalender" id="offroad_datetime" placeholder="Off-road  Date/Time" data-errors="{filter_required:'Off-road  Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>



        </div>
    </div>
    <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >
            <input type="text" name="breakdown[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="filter_required OnroadDate" placeholder="Expected On-road Date/Time" data-errors="{filter_required:'Expected On-road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $Approve; echo $Re_request; ?>>



        </div>
    </div>
</div>


                    
                    <?php } ?>
                    
                </div>
            </div>
        </div>

                <?php if ($update) { 
                    $previous_odo = $preventive[0]->mt_in_odometer;
                    ?>  
        <div class="field_row width100  fleet"><div class="single_record_back">Current Info</div></div>

                    <input type="hidden" name="breakdown[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                    <input type="hidden" name="breakdown[is_amb_offroad]" id="ud_mt_id" value="<?= @$preventive[0]->is_amb_offroad ?>">
                    <input type="hidden" name="previos_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                  
                 <?php if ($preventive[0]->is_amb_offroad == 'yes') { ?>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                 <input type="text" name="mt_end_odometer" value="<?=@$preventive[0]->mt_end_odometer;?>" class="filter_required filter_valuegreaterthan[<?php echo $previous_odo;?>]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should <?php echo $previous_odometer; ?>'}" TABINDEX="8" <?php if($preventive[0]->mt_end_odometer !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="breakdown[mt_onroad_datetime]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class="filter_required On road Date" placeholder="On-road Date/Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
             <div class="field_row width100">
                 <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Complaint current status<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
<!--                                <select name="breakdown[mt_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                    <option value="">Select Standard Remark</option>
                                    <?php if ($update) { ?>  <option value="Ambulance_breakdown_maintaince_onroad"  <?php 
                                    if (@$preventive[0]->mt_on_stnd_remark == 'Ambulance_breakdown_maintaince_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Breakdown Ambulance On-road</option>  <?php } ?>
                                </select>-->
                                      <input name="breakdown[mt_complaint_current_status]" id="remark_input" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>/auto/get_eqp_standard_emark/break_update" data-value="" value="" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_onroad_standard" data-errors="{filter_required:'Remark should not be blank!'}">
                            </div>
                           
                        </div>
                                          <div class="width100 hide" id='show_onroad_standard_remark_other'>
                             <div class="width50 drg float_left" >
                                     <div class="width33 float_left">
                                         <div class=" float_left">No of days required : </div>
                                     </div>
                                     <div class="width50 float_left">

                                         <input name="breakdown[no_of_days_required]" class=""  value="" type="text" tabindex="2" placeholder="Pending Reason" data-errors="{filter_required:'Remark should not be blank!'}" >
                                     </div>
                                 </div> 
                                 <div class="width50 drg float_left" >
                                     <div class="width33 float_left">
                                         <div class=" float_left">Attach PMC snap shot: </div>
                                     </div>
                                     <div class="width50 float_left">
                                        <div class="filed_input outer_clg_photo field">
                                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="files" type="file" name="pmc_snap_shot[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  >
                                        <?php if ($update) {
                                            //var_dump($media);
                                            if($media){
                                            foreach($media as $img) {
                                            $name = $img->media_name;
                                            $pic_path = FCPATH . "uploads/ambulance/" . $name;
                                            if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                            }
                                            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                            ?>
                                        <div class="clg_photo float_right" style="background: url('<?php
                                        if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                        } else {
                                        echo $blank_pic_path;
                                        }
                                        ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></div>
                                        <?php } } } ?>
                                        </div>
                                        <!-- <input name="breakdown[pmc_snap_shot]" class=""  value="" type="text" tabindex="2" placeholder="Pending Reason" data-errors="{filter_required:'Remark should not be blank!'}" >
                                    --> </div>
                                 </div> 
                         </div>
                        <div class="width100 hide" id="resolve_issue_block">
                           <!--  <div class="width2 float_left">

                <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Material Used</label></div>

                <div class="filed_input float_left width50 unit_drags" style="position:relative;">
                    <input type="text" name="breakdown[mt_part_cost]" id="part_cost" value="<?= @$preventive[0]->part_cost; ?>" class="filter_if_not_blank filter_number unit_drags_input" placeholder="Material Used" data-errors="{filter_required:'Material Used should not be blank',filter_number:'Material Used should be Number'}" TABINDEX="8" <?php if ($preventive[0]->part_cost != '') {
        echo "disabled";
    } ?> readonly="readonly">
               
                      <div id="unit_drugs_box">

                                

                                <div class="unit_drugs_box">
                                    <ul class="width100">
                                        <?php if ($invitem) { ?>
                                            <li class="unit_block" id="unit_other">
                                                <label for="unit_na" class="chkbox_check">


                                                    <input type="checkbox" name="unit['NA'][id]" class="check_input unit_checkbox" value="NA"  id="unit_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>

                                            <?php foreach ($invitem as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $item->id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="unit[<?php echo $item->id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->id; ?>"  id="unit_<?php echo $item->id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->spare_part_name); ?><br>
                                                    </label>
                                                    <?php if (isset($med_inv_data[$item->inv_id])) {
                                                    ?>
                                              <div class="unit_div">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->inv_id; ?>][value]" value="<?php echo $med_inv_data[$item->inv_id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_spare_part_box();">
                                  
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_spare_part_box();">
                                                                                                                                                              <input type="hidden" name="unit[<?php echo $item->id; ?>][title]" value="<?php echo $item->spare_part_name; ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam">
                                                                                                                                                         
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                <input name="unit_iteam" id="show_unit_box_selected_ca" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>/biomedical/show_spare_part_list" data-qr="output_position=content" type="button">
                                    </ul>

                                </div>
                                <div id="show_selected_unit_item_ca" style="width:95%">
                                </div>



                            </div>  
                               


                </div>
            </div> !-->
            
            <div class="width2 float_left">

                <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Part Used</label></div>

                <div class="filed_input float_left width50 non_unit_drags" style="position:relative;">
                    <input type="text" name="breakdown[mt_part_cost]" id="part_cost" value="<?= @$preventive[0]->part_cost; ?>" class="filter_if_not_blank filter_number unit_drags_input" placeholder="Part Used" data-errors="{filter_required:'Material Used should not be blank',filter_number:'Part Used should be Number'}" TABINDEX="8" <?php if ($preventive[0]->part_cost != '') {
        echo "disabled";
    } ?> readonly="readonly">
               
                      <div id="non_unit_drugs_box">

                                

                                <div class="unit_drugs_box">
                                    <ul class="width100">
                                        <?php if ($partitem) { ?>
                                            <li class="unit_block" id="non_unit_other">
                                                <label for="part_na" class="chkbox_check">


                                                    <input type="checkbox" name="part['NA'][id]" class="check_input unit_checkbox" value="NA"  id="part_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>

                                            <?php foreach ($partitem as $part) { ?>
                                                <li class="unit_block">
                                                    <label for="part_<?php echo $part->id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="part[<?php echo $part->id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->id; ?>"  id="part_<?php echo $part->id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($part->id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="part_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($part->spare_part_name); ?><br>
                                                    </label>
                                                    <?php if (isset($med_inv_data[$part->inv_id])) {
                                                    ?>
                                              <div class="unit_div">
                                                                                                                                                            <input type="text" name="part[<?php echo $part->inv_id; ?>][value]" value="<?php echo $med_inv_data[$part->id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="part_iteam" onchange="show_part_box();">
                                  
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                            <input type="text" name="part[<?php echo $part->id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="part_iteam"  onchange="show_part_box();">
                                                                                                                                                              <input type="hidden" name="part[<?php echo $part->id; ?>][title]" value="<?php echo $part->spare_part_name; ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="part_iteam">
                                                                                                                                                               <input type="hidden" name="part[<?php echo $part->id; ?>][id]" value="<?php echo $part->id; ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="part_iteam">
                                                                                                                                                         
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                <input name="part_iteam" id="show_part_selected" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>/biomedical/show_part_list" data-qr="output_position=content" type="button">
                                    </ul>

                                </div>
                                <div id="show_selected_spare_part" style="width:95%">
                                </div>



                            </div>  
                               


                </div>
            </div>
            <div class="field_row width100">
            <div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="end_odometer">Labour Cost</label></div>

                <div class="filed_input float_left width50" >
                    <input type="text" name="breakdown[mt_labour_cost]" id= "labour_cost" onkeyup="sum();" value="<?= @$preventive[0]->labour_cost; ?>" class="filter_if_not_blank filter_number" placeholder="Labour Cost" data-errors="{filter_required:'Labour Cost should not be blank',filter_number:'Labour Cost should be Number'}" TABINDEX="8" <?php if ($preventive[0]->labour_cost != '') {
        echo "disabled";
    } ?>>


                </div>
            </div>
            <div class="width2 float_left">

                <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Total Amount</label></div>

                <div class="filed_input float_left width50" >
                    <input type="text" name="breakdown[mt_total_cost]" id="total_cost" value="<?= @$preventive[0]->total_cost; ?>" class="filter_if_not_blank filter_number" placeholder="Total Amount" data-errors="{filter_required:'Total Amount should not be blank',filter_number:'Total Amount should be Number'}" TABINDEX="8" <?php if ($preventive[0]->total_cost != '') {
        echo "disabled";
    } ?>>


                </div>
            </div>
        </div>
        <div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="end_odometer">Bill Number</label></div>

                <div class="filed_input float_left width50" >
                    <input type="text" name="breakdown[mt_bill_number]" value="<?= @$preventive[0]->mt_bill_number; ?>" class=" " placeholder="Bill Number" data-errors="{filter_required:'Bill Number should not be blank'}" TABINDEX="8" <?php if ($preventive[0]->mt_bill_number != '') {
        echo "disabled";
    } ?>>


                </div>
            </div>
           <!-- <div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
<!--                                <select name="breakdown[mt_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                    <option value="">Select Standard Remark</option>
                                    <?php if ($update) { ?>  <option value="Ambulance_breakdown_maintaince_onroad"  <?php 
                                    if (@$preventive[0]->mt_on_stnd_remark == 'Ambulance_breakdown_maintaince_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Breakdown Ambulance On-road</option>  <?php } ?>
                                </select>-->
                                     <!-- <input name="breakdown[mt_on_stnd_remark]" id="remark_input" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>/auto/get_eqp_standard_emark/update" data-value="" value="" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_onroad_standard_remark_other" data-errors="{filter_required:'Remark should not be blank!'}">
                            </div>
                           
                        </div>-->
<!--                             <div class="width50 drg float_left">
                                <div class="width33 float_left">
                                    <div class=" float_left">Part Used: </div>
                                </div>
                                <div class="width50 float_left">

                                    <input name="breakdown[part_used]" class=""  value="" type="text" tabindex="2" placeholder="Part Used" data-errors="{filter_required:'Part Used should not be blank!'}" >
                                </div>
                            </div>-->
<!--                             <div class="width50 drg float_left" >
                                <div class="width33 float_left">
                                    <div class=" float_left">Quantity : </div>
                                </div>
                                <div class="width50 float_left">

                                    <input name="breakdown[quantity]" class=""  value="" type="text" tabindex="2" placeholder="Quantity" data-errors="{filter_required:'Quantity should not be blank!'}" >
                                </div>
                            </div>-->
                            
                        </div>
                        <div class="width100 hide" id="pending_block">
                        <div class="width50 drg float_left" >
                            <div class="width33 float_left">
                                <div class="  float_left"> <label for="mt_stnd_remark">Pending Reason</label></div>
                            </div>
                            <div class="width50 float_left">
                                <select name="pending_Reason" tabindex="8" id="pending_Reason"  onchange="show_pending_Reason();"   > 
                                   <option value="">Select Pending Reason</option>
                                   <?php if ($update) { ?>
                                     <option value="1">Required Spare from HQ</option> 
                                     <option value="2">System/Spare/Part send to HQ</option> 
                                     <option value="3">Inverter Issue</option> 
                                    <?php } ?>
                               </select>
                            </div>
                        </div>
                            <div class="width50 hide drg float_left" id="Required_Spare_from_HQ_block">
                                <div class="width50 float_left">
                                    <div class=" float_left">Required Spare from HQ : </div>
                                </div>
                                
                               <!-- <div class="width50 float_left"> <select name="breakdown[required_spare_from_hq]"  TABINDEX="5">

                                <option value="">Select Spare</option>
                                    <?php 
                                  //  var_dump($invitem);die();
                                if ($invitem_update) 
                                {
                                    foreach ($invitem_update as $item) 
                                    { ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo stripslashes($item->spare_part_name); ?></option>
                                    <?php }
                                } ?>
                                </select>-->
                                    <!--<input name="breakdown[required_spare_from_hq]" class=""  value="" type="text" tabindex="2" placeholder="Required Spare from HQ" data-errors="{filter_required:'Material Used should not be blank!'}" >
                              </div>  --> 
                               
                               <div class="filed_input float_left width50 unit_drags" style="position:relative;">
<input type="text" name="breakdown[required_spare_from_hq]" id="part_cost" value="<?= @$preventive[0]->part_cost; ?>" class="filter_if_not_blank filter_number unit_drags_input" placeholder="Spare Part" data-errors="{filter_required:'Material Used should not be blank',filter_number:'Material Used should be Number'}" TABINDEX="8" readonly="readonly">
<div id="unit_drugs_box">
            <div class="unit_drugs_box">
            <ul class="width100">
                        <?php if ($invitem_update) { ?>
                                            <li class="unit_block" id="unit_other">
                                                <label for="unit_na" class="chkbox_check">


                                                    <input type="checkbox" name="unit['NA'][id]" class="check_input unit_checkbox" value="NA"  id="unit_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>

                                            <?php foreach ($invitem_update as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $item->id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="unit[<?php echo $item->id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->id; ?>"  id="unit_<?php echo $item->id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->spare_part_name); ?><br>
                                                    </label>
                                                    <?php if (isset($med_inv_data[$item->inv_id])) {
                                                    ?>
                                              <div class="unit_div">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->inv_id; ?>][value]" value="<?php echo $med_inv_data[$item->inv_id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_spare_part_box();">
                                  
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                             <input type="text" name="unit[<?php echo $item->id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_spare_part_box();">
                                                                                                                                                              <input type="hidden" name="unit[<?php echo $item->id; ?>][title]" value="<?php echo $item->spare_part_name; ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam">
                                                                                                                                                              <input type="hidden" name="unit[<?php echo $item->id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->id; ?>"  id="unit_<?php echo $item->id; ?>" data-base="unit_iteam">
                                                                                                                                                         
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                <input name="unit_iteam" id="show_unit_box_selected_ca" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>/biomedical/show_spare_part_list" data-qr="output_position=content" type="button">
                                    </ul>

                                </div>
                                <div id="show_selected_unit_item_ca" style="width:95%">
                                </div>



                            </div>  
                               


               
                               </div>
                            </div>
                             <div class="width50 hide drg float_left" id="System_send_to_HQ_for_further_repair_block">
                                <div class="width50 float_left">
                                    <div class=" float_left">System send to HQ: </div>
                                </div>
                               <!-- <div class="width50 float_left">
                                <select name="breakdown[system_send_to_hq]"  TABINDEX="5">

                                <option value="">Select Spare</option>
                                    <?php 
                                //  var_dump($invitem);die();
                                if ($invitem_update) 
                                {
                                    foreach ($invitem_update as $item) 
                                    { ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo stripslashes($item->spare_part_name); ?></option>
                                    <?php }
                                } ?>
                                </select>
                                    <input name="breakdown[system_send_to_hq]" class=""  value="" type="text" tabindex="2" placeholder="System send to HQ for further repair" data-errors="{filter_required:'Part Used should not be blank!'}" >
                                 </div>-->
                                 <divs class="filed_input float_left width50 unit_drags" style="position:relative;">
<input type="text" name="breakdown[system_send_to_hq]" id="part_cost" value="<?= @$preventive[0]->part_cost; ?>" class="filter_if_not_blank filter_number unit_drags_input" placeholder="Spare Part" data-errors="{filter_required:'Material Used should not be blank',filter_number:'Material Used should be Number'}" TABINDEX="8" readonly="readonly">
<div id="unit_drugs_box">
            <div class="unit_drugs_box">
            <ul class="width100">
                        <?php if ($invitem_update) { ?>
                                            <li class="unit_block" id="unit_other">
                                                <label for="unit_hq_na" class="chkbox_check">


                                                    <input type="checkbox" name="unit['NA'][id]" class="check_input unit_checkbox" value="NA"  id="unit_hq_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>

                                            <?php foreach ($invitem_update as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_hq_<?php echo $item->id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="unit_hq[<?php echo $item->id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->id; ?>"  id="unit_hq_<?php echo $item->id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->spare_part_name); ?><br>
                                                    </label>
                                                    <?php if (isset($med_inv_data[$item->inv_id])) {
                                                    ?>
                                              <div class="unit_div">
                                                                                                                                                            <input type="text" name="unit_hq[<?php echo $item->inv_id; ?>][value]" value="<?php echo $med_inv_data[$item->inv_id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_spare_part_box();">
                                  
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                            <input type="text" name="unit_hq[<?php echo $item->id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_spare_part_box();">
                                                                                                                                                              <input type="hidden" name="unit_hq[<?php echo $item->id; ?>][title]" value="<?php echo $item->spare_part_name; ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam">
                                                                                                                                                              <input type="hidden" name="unit_hq[<?php echo $item->id; ?>][id]" value="<?php echo $item->id; ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam">
                                                                                                                                                         
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                <input name="unit_iteam" id="show_unit_box_selected_ca" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>/biomedical/show_spare_part_list" data-qr="output_position=content" type="button">
                                    </ul>

                                </div>
                                <div id="show_selected_unit_item_ca" style="width:95%">
                                </div>



                            </div>  
                               


               
                               </div>
                            </div>
                             <div class="width50 hide drg float_left" id="Inverter_Issue_block" >
                                <div class="width33 float_left">
                                    <div class=" float_left">Inverter Issue : </div>
                                </div>
                                <div class="width50 float_left">

                                    <input name="breakdown[inverter_issue]" class=""  value="" type="text" tabindex="2" placeholder="Inverter Issue" data-errors="{filter_required:'Quantity should not be blank!'}" >
                                </div>
                            </div>
                            
                        </div>
            <!--<div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="end_odometer">Bill Number</label></div>

                <div class="filed_input float_left width50" >
                    <input type="text" name="breakdown[mt_bill_number]" value="<?= @$preventive[0]->mt_bill_number; ?>" class=" " placeholder="Bill Number" data-errors="{filter_required:'Bill Number should not be blank'}" TABINDEX="8" <?php if ($preventive[0]->mt_bill_number != '') {
        echo "disabled";
    } ?>>


                </div>
            </div>-->
           
        </div>

    <!--<div class="field_row width100">
            <div class="width2 float_left">
                <div class="field_lable float_left width33"><label for="end_odometer">Labour Cost</label></div>

                <div class="filed_input float_left width50" >
                    <input type="text" name="breakdown[mt_labour_cost]" id= "labour_cost" onkeyup="sum();" value="<?= @$preventive[0]->labour_cost; ?>" class="filter_if_not_blank filter_number" placeholder="Labour Cost" data-errors="{filter_required:'Labour Cost should not be blank',filter_number:'Labour Cost should be Number'}" TABINDEX="8" <?php if ($preventive[0]->labour_cost != '') {
        echo "disabled";
    } ?>>


                </div>
            </div>
            <div class="width2 float_left">

                <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Total Amount</label></div>

                <div class="filed_input float_left width50" >
                    <input type="text" name="breakdown[mt_total_cost]" id="total_cost" value="<?= @$preventive[0]->total_cost; ?>" class="filter_if_not_blank filter_number" placeholder="Total Amount" data-errors="{filter_required:'Total Amount should not be blank',filter_number:'Total Amount should be Number'}" TABINDEX="8" <?php if ($preventive[0]->total_cost != '') {
        echo "disabled";
    } ?>>


                </div>
            </div>
        </div>-->
                    <div class="field_row width100">
                        <!--<div class="filed_input float_left width2">
                           
                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
<!--                                <select name="breakdown[mt_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                    <option value="">Select Standard Remark</option>
                                    <?php if ($update) { ?>  <option value="Ambulance_breakdown_maintaince_onroad"  <?php 
                                    if (@$preventive[0]->mt_on_stnd_remark == 'Ambulance_breakdown_maintaince_onroad') {
                                        echo "selected";
                                    }
                                    ?>>Breakdown Ambulance On-road</option>  <?php } ?>
                                </select>-->
                                      <!--<input name="breakdown[mt_on_stnd_remark]" id="remark_input" class="mi_autocomplete filter_required" data-href="<?php echo base_url();?>/auto/get_eqp_standard_emark/update" data-value="" value="" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_onroad_standard_remark_other" data-errors="{filter_required:'Remark should not be blank!'}">
                            </div>
                           
                        </div>-->

                        <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark</label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="breakdown[mt_on_remark]"  TABINDEX="16" data-maxlen="1600"  <?php if($preventive[0]->mt_on_remark  != ''){echo "disabled"; }?>><?= @$preventive[0]->mt_on_remark; ?></textarea>
                        </div>
                        </div>
                    </div>
                    

                <?php } ?>
                    
                <div class="width100">
                     <div class="field_row width100">
                    <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width15">
                                    <label for="photo">Photo</label>
                                </div>
                                
                                <div class="button_box">
                                <input type="button" name="Reset" value="Reset Image" class="btn" id="reset_img">
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
                                <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="files" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  >
                                
        <?php if ($update) {
            //var_dump($media);
            if($media){
            foreach($media as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
            

                                        <div class="clg_photo float_right" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></div>


            <?php } } } ?>
              </div>
                </div>
                </div>
                </div>
                <?php if($Approve)
                            {  ?>
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
                            if ($his) {
                            $count = 1;
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
                    <input type="hidden" name="previos_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
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
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="approve" type="radio" name="app[mt_approval]" value="0" <?php echo $gender['female'];?> class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="mt_app_onroad_datetime"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_app_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-road Date/Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;?>><?= @$preventive[0]->mt_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Estimate Amount<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_est_amt]"  value=" <?php  echo $preventive[0]->mt_app_est_amt; ?>" class=" filter_required filter_number " placeholder="On-road Date/Time" data-errors="{filter_required:'Approved Estimate Amount should not be blank',}" TABINDEX="8" <?php if($preventive[0]->mt_app_est_amt != '0000-00-00 00:00:00' && $preventive[0]->mt_app_est_amt != ''){ echo "disabled";}?>  >

                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_app_rep_time">Repairing Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_rep_time]"  value=" <?php if($preventive[0]->mt_app_rep_time != '0000-00-00 00:00:00' && $preventive[0]->mt_app_rep_time != ''){ echo $preventive[0]->mt_app_rep_time;} ?>" class="filter_required OnroadDate" placeholder="Repairing Time" data-errors="{filter_required:'Repairing Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_app_rep_time != '0000-00-00 00:00:00' && $preventive[0]->mt_app_rep_time != ''){ echo "disabled";}?> >



                            </div>
                        </div>
                    </div>
 </div> 
                                

                           <?php } ?>

                           <?php if ($Re_request) {  ?>
                    
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
                            if (count($app_rej_his) > 0) {
                            $count = 1;
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
                    <input type="hidden" name="previos_odometer" value="<?=@$preventive[0]->mt_in_odometer;?>">
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
                <?php } ?> 


                    <div class="field_row width100">
                        <div class="button_field_row width33 margin_auto">
                            <div class="button_box">
                                <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } elseif($Approve){ ?>Approval<?php } elseif($Re_request){ ?>Re-Request<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>biomedical/<?php if ($update) { ?>breakdown_equip_update<?php }elseif($Approve){ ?>breakdown_equip_approve<?php } elseif($Re_request){ ?>breakdown_equip_re_request<?php } else{ ?>breakdown_equip_save<?php } ?>' data-qr='output_position=content&amp;module_name=clg&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$preventive[0]->mt_id; ?>">
                                <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">
                            </div>
                        </div>
                    </div>
    </div>         
</form>
<script>
$(document).ready(function() {
    

    if (window.File && window.FileList && window.FileReader) {

$("#rerequest_reset_img").on("change", function(e) {
    //alert();
  var files = e.target.files,
    filesLength = files.length;
  for (var i = 0; i < filesLength; i++) {
    var f = files[i]
    var fileReader = new FileReader();
    fileReader.onload = (function(e) {
      var file = e.target;
      $("<span class=\"pip\">" +
        "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
         +
        "</span>").insertAfter("#rerequest_reset_img");
        $("#remove_reset_img").click(function(){
    $("#rerequest_reset_img").val("");
    $("span[class=pip]").remove();
});
      $(".remove").click(function(){
        
      });
      
      
      // Old code here
      /*$("<img></img>", {
        class: "imageThumb",
        src: e.target.result,
        title: file.name + " | Click to remove"
      }).insertAfter("#files").click(function(){$(this).remove();});*/
      
    });
    fileReader.readAsDataURL(f);
  }
});
} else {
alert("Your browser doesn't support to File API")
}    

  if (window.File && window.FileList && window.FileReader) {

    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
             +
            "</span>").insertAfter("#files");
            $("#reset_img").click(function(){
        $("#files").val("");
        $("span[class=pip]").remove();
    });
          $(".remove").click(function(){
            
          });
          
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
    
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
      var txtFirstNumberValue = document.getElementById('labour_cost').value;
      var txtSecondNumberValue = document.getElementById('part_cost').value;
      var result =  parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total_cost').value = result;
      }
}
function diff() {
      var txtFirstNumberValue = document.getElementById('distance').value;
      var txtSecondNumberValue = document.getElementById('fuel').value;
      var result = (txtFirstNumberValue) /(txtSecondNumberValue);
     //var res = result.tofixed(2);
      if (!isNaN(result)) {
         // alert(res);
         //var res= Math.round( result,2);
        var res=Math.round(result*100)/100;
         document.getElementById('kmpl').value = res;
         //var res= result.tofixed(2);
         //alert(res);
      }
}
</script>