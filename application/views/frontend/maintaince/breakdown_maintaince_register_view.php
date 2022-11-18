<div id="dublicate_id"></div>
<?php 
$haystack = array('docx','doc','pdf','xlsx');
$rerequest = '';
$approve = '';
$update = '';
$mo_rerequest = ''; 

if ($type == 'Update') {
    $update = 'disabled';
}elseif($type == 'Approve'){
    
    $approve = 'disabled';
}elseif($type == 'Rerequest'){
    $rerequest = 'disabled';
}elseif($type == 'Rerequest'){
    $rerequest = 'disabled';
}elseif($type == 'upload_job_card'){
    
    $upload_job_card = 'disabled';
}elseif($type == 'FinalApprove'){
    
    $finalapprove = 'disabled';
}elseif($type == 'upload_invoice'){
    
    $upload_invoice = 'disabled';
}elseif($type == 'Update_Breakdown'){
    
    $Update_Breakdown = 'disabled';
}

?>

<form enctype="multipart/form-data" action="#" method="post" class="breakdown_maintance_block" id="add_colleague_registration_form" style="position: relative;">
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
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50"> <div id="ambulance_state">


                               
                                <?php
                                 
                                if (@$preventive[0]->mt_state_id != '') {
                                    $st = array('st_code' => @$preventive[0]->mt_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                                } else {
                                    $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '', 'readonly' => 'readonly' );
                                }

                                
                                //echo get_state_clo_comp_ambulance($st);
                                echo get_state_break_ambulance($st);
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

                                echo get_district_break_amb($dt);
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

                                    echo get_break_maintaince_ambulance($dt);
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
<!--                            <input name="base_location" tabindex="23" class="form_input filter_required" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $finalapprove; echo $rerequest; ?>>-->
                              <input name="base_location" tabindex="23" class="form_input filter_required mi_autocomplete" placeholder="Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" data-value="<?= @$preventive[0]->mt_base_loc; ?>" value="<?= @$preventive[0]->mt_base_loc; ?>" readonly="readonly"   <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest; ?>  data-callback-funct="load_baselocation_ambulance" data-href="<?php echo base_url();?>auto/get_hospital">

                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Type<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div_outer">
                          
                            
                            <select name="amb_type" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?>" data-errors="{filter_required:'Ambulance type should not be blank'}" <?php echo $view; ?> TABINDEX="5" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest; ?> >

                                    <option value="">Select Type</option>

                                    <?php echo get_amb_type_by_id($preventive[0]->amb_type); ?>
                            </select>


                        </div>


                    </div>
                      <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Make<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_type_div">
                           
                            <input name="ambt_make" tabindex="23" class="form_input " placeholder="Make" type="text"  data-errors="{filter_required:'Estimate Cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_make; ?>"    <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?>>

                        </div>


                    </div>
                    </div>
                    <?php if ($clg_group !== 'UG-VENDOR') { ?>
                    <div class="field_row width100">

                   
                    <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Owner</label></div>


                        <div class="filed_input float_left width50" id="amb_owner">
                            

                            <input name="breakdown[mt_owner]" tabindex="23" class="form_input " placeholder="Owner" type="text"  data-errors="{filter_required:'Estimate Cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_owner; ?>"    <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?>>
                        </div>


                    </div> -->
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Ambulance Model<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_amb_model">
                            

                            <input name="amb_model" tabindex="23" class="form_input " placeholder="Model" type="text"  data-errors="{filter_required:'Estimate Cost should not be blank!',filter_maxlength:'Amount at max 6 digit long',filter_number:'Amount in a number format'}" value="<?= @$preventive[0]->mt_module; ?>"    <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?>>
                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Breakdown Route and Location<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_breakdown_route_location]"  value="<?= @$preventive[0]->mt_breakdown_route_location; ?>" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?> " placeholder="Breakdown Route and Location" data-errors="{filter_required:'Please select Breakdown Route and Location'}" TABINDEX="8"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>


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

                            <input name="breakdown[mt_pilot_id]" class="mi_autocomplete"  data-href="<?php echo base_url(); ?>auto/get_breakdown_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"  data-base="search_btn" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; }   ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="preventive[mt_pilot_name]"  value="<?= @$preventive[0]->mt_pilot_name; ?>" TABINDEX="10"    <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; }?>>
                        </div>
                    </div>
                </div>
                        <?php
                    }else{
                    ?>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">

                            <input name="breakdown[mt_pilot_id]" class="mi_autocomplete <?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?>" data-errors="{filter_required:'Pilot Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_breakdown_pilot_data" data-value="<?= @$preventive[0]->mt_pilot_id; ?>" value="<?= @$preventive[0]->mt_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"  data-base="search_btn" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name</label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="pilot_id" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?>"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$preventive[0]->mt_pilot_name; ?>" TABINDEX="10"    <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="field_row width100">
                   
<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Current Odometer on date of breakdown<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="previous_odometer"  value="<?= @$preventive[0]->mt_in_odometer; ?>" class="filter_required" placeholder="Current Odometer" data-errors="{filter_required:'Current Odometer is required'}" TABINDEX="8"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest; ?>>


                        </div>
                    </div>-->
                </div>
                <div class="field_row width100" id="maintance_previous_odometer">
                    <?php 
                   
                    if($update || $approve || $Update_Breakdown){ ?>
                    
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Breakdown Maintenance Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_accidental_previos_odometer]" id="previous_odometer" value="<?= @$preventive[0]->mt_accidental_previos_odometer; ?>" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?>" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  
                            echo $approve; echo $finalapprove;
                            if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> readonly='readonly'>
                        </div> 
                    </div> 
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Last Updated Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="previous_odometer" id="previous_odometer" value="<?= @$preventive[0]->mt_previos_odometer; ?>" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?>" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  
                            echo $approve; echo $finalapprove;
                            if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> readonly='readonly'>
                        </div> 
                    </div> 
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer on date of breakdown<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >

                            <input type="text" name="in_odometer" value="<?php echo $preventive[0]->mt_in_odometer; ?>" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?> filter_valuegreaterthan[<?php echo $preventive[0]->mt_previos_odometer; ?>] filter_maxlength[7] filter_number" id="end_odometer" placeholder="Current Odometer" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'Current Odometer should greater than or equal Previous Odometer' ,filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  
                            echo $approve; echo $finalapprove;
                            if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> readonly='readonly'>
                        </div>
                    </div>
                    <?php } ?>
<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Breakdown Maintenance Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_accidental_previos_odometer]" id="filling_previous_odometer" value="<?= @$preventive[0]->mt_accidental_previos_odometer; ?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Breakdown Maintenance Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Breakdown MaintenancePrevious Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" readonly='readonly' onkeyup="sum(this);"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?>>


                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Last Updated Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="previous_odometer" id="filling_previous_odometer" value="<?= @$preventive[0]->mt_previos_odometer; ?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Breakdown Maintenance Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Breakdown MaintenancePrevious Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" readonly='readonly' onkeyup="sum(this);"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?>>


                        </div>
                    </div>-->
<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="previous_odometer">Current Odometer on date of breakdown<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="previous_odometer"  value="<?= @$preventive[0]->mt_in_odometer; ?>" class="filter_required" placeholder="Current Odometer" data-errors="{filter_required:'Current Odometer is required'}" TABINDEX="8"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?>>


                        </div>
                    </div>-->
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Breakdown Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >

                            <input type="text" name="breakdown[mt_breakdown_datetime]"  id="offroad_datetime" value=" <?php
                        if ($preventive[0]->mt_breakdown_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '') {
                        echo $preventive[0]->mt_breakdown_datetime;
                        }else{ echo date('Y-m-d H:i:s'); } 
                        ?>" class="mi_timecalenderoff filter_required" placeholder="Breakdown Date/Time" data-errors="{filter_required:'Breakdown Date/Time should not be blank'}" TABINDEX="8" <?php
                        if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; }
                        ?> <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>



                        </div>
                        </div>
                            <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected On-road Date/Time <span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input id="onroad_datetime_exp" type="text" name="breakdown[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="<?php if($approve == '' && $rerequest == '' && $update == '')?> mi_next_timecalender filter_required" data-errors="{filter_required:'Expected On-road Date/Time should not be blank'}" placeholder="Expected On-road Date/Time" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>



                            </div>
                            </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="city">No. of Breakdown of this Vehicle<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" id="breakdown_count" >
                            <input type="text" name="breakdown[mt_brakdown_count]"  value="<?= @$preventive[0]->mt_brakdown_count; ?>" class="<?php if($approve == '' && $rerequest == '' && $update == ''){ echo "filter_required"; } ?>" placeholder="No. of Breakdown of this Vehicle" data-errors="{filter_required:'No. of Breakdown of this Vehicle should not be blank'}" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>

                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="city">Breakdown Severity<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <select name="breakdown[mt_brakdown_severity]" tabindex="8" data-errors="{filter_required:'Breakdown Severity should not be blank!'}"  <?php echo $update;  echo $upload_invoice;  echo $Update_Breakdown; echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> class="change-xhttp-request filter_required" data-href="<?php echo base_url();?>ambulance_maintaince/breakdown_severity" data-qr="output_position=content" > 
                                <option value="">Select Breakdown Severity</option>
                                <option value="Major" <?php
                                        if ($preventive[0]->mt_brakdown_severity == 'Major') {
                                            echo "selected";
                                        }
                                        ?>>Major</option>
                                <option value="Minor" <?php
                                if ($preventive[0]->mt_brakdown_severity == 'Minor') {
                                    echo "selected";
                                }
                                        ?>>Minor</option>

                            </select>

                        </div>
                    </div>
                    
                </div>
                <div id="major_severity">
                    
                    <?php if ($preventive[0]->mt_brakdown_severity == 'Minor'){ 
                      
                        ?>
                    <div class="field_row width100">


                        <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_payment_type">Payment Type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_payment_type]"  data-errors="{filter_required:'Payment Type should not be blank'}" <?php echo $update; echo $approve; echo $rerequest;  echo $upload_job_card;  echo $upload_invoice;  ?> TABINDEX="5"  class="filter_required change-xhttp-request" data-href="" data-qr="output_position=content" onchange="showDiv('hidden_div', this)" disabled >
                
                <option value="">Select Type</option>
                <option value="vendor" <?php
                                        if ($preventive[0]->mt_payment_type == 'vendor') {
                                            echo "selected=selected";
                                        }
                                        ?>>Vendor</option>
                <option value="hppay_card" <?php
                                        if ($preventive[0]->mt_payment_type == 'hppay_card') {
                                            echo "selected=selected";
                                        }
                                        ?>>HPPAY Card</option>

            </select>
        </div>
</div>
    <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Material used<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_material_used]"  data-errors="{filter_required:'Material used should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> TABINDEX="5"  class="<?php if($approve != 'disabled'){ echo 'filter_required'; } ?> change-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/material_used" data-qr="output_position=content">

                <option value="">Select Type</option>
                <option value="Available Stock"  <?php
                if ($preventive[0]->mt_material_used == 'Available Stock') {
                    echo "selected=selected";
                }
                ?>>Available Stock</option>
                <option value="Local Purchase" <?php
                if ($preventive[0]->mt_material_used == 'Local Purchase') {
                    echo "selected=selected";
                }
                ?>>Local Purchase</option>

            </select>
        </div>
    </div>
</div>
<div  class="field_row width100" id="material_type_block">
                    <?php if ($preventive[0]->mt_material_used == 'Local Purchase'){  ?>
     <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_local_purchase">Local Purchase<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              
                               <textarea style="height:60px;" name="breakdown[mt_local_purchase]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Local Purchase should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;?> <?php echo $view; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> ><?= @$preventive[0]->mt_local_purchase; ?></textarea>
                              
                              
                           
                           
                        </div> 
 </div> 
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="labor_cost">Local Purchase Cost<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="breakdown[part_cost]" id="local_purchase_cost" value="<?= @$preventive[0]->part_cost; ?>" class="filter_required filter_maxlength[7] filter_number" placeholder="Local Purchase Cost" data-errors="{filter_required:'Local Purchase Cost should not be blank',filter_maxlength:'Local Purchase Cost at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" onchange="cost_sum()"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;?> <?php echo $view; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> >
    </div>
</div>
                    <?php } ?>
    
</div>
<div  class="field_row width100">
        <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_labour_type">Labor Type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_labor_type]"  data-errors="{filter_required:'Labor Type should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> TABINDEX="5"  class="<?php if($approve != 'disabled'){ echo 'filter_required'; } ?> change-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/labor_type" data-qr="output_position=content">

                <option value="">Select Type</option>
                <option value="Inhouse-Free"  <?php
                if ($preventive[0]->mt_labor_type == 'Inhouse-Free') {
                    echo "selected=selected";
                }
                ?>>Inhouse-Free</option>
                <option value="Outside Vendor/Mech" <?php
                if ($preventive[0]->mt_labor_type == 'Outside Vendor/Mech') {
                    echo "selected=selected";
                }
                ?>>Outside Vendor/Mech</option>

            </select>
        </div>
    </div>
    <div class="width2 float_left" id="labour_cost_block">
         <?php 
         //var_dump($preventive[0]);
         if ($preventive[0]->labour_cost != '') { ?>
         <div class="field_lable float_left width33"><label for="mt_labour_type">Labor Cost<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <input type="text" name="breakdown[labour_cost]" id="labor_cost" value="<?php echo $preventive[0]->labour_cost; ?>" class="filter_required filter_maxlength[7] filter_number" placeholder="Labor Cost" data-errors="{filter_required:'Labor Cost should not be blank',filter_maxlength:'Labor Cost at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" onchange="cost_sum()" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>
        </div>
         <?php } ?>

    </div>
    <div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="labor_cost">Total Cost</label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="breakdown[total_cost]" id="total_cost" value="<?php echo $preventive[0]->total_cost; ?>" class="<?php if($approve != 'disabled') ?>" placeholder="Labor Cost" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>
    </div>
</div>
           
</div>
                    <?php } ?>
                     <?php if ($preventive[0]->mt_brakdown_severity == 'Major'){ ?>
                    
      <div class="field_row width100">
          <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_payment_type">Payment Type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_payment_type]"  data-errors="{filter_required:'Payment Type should not be blank'}" <?php echo $update; echo $approve; echo $rerequest; ?> TABINDEX="5"  class="filter_required change-xhttp-request" data-href="" data-qr="output_position=content" onchange="showDiv('hidden_div', this)" disabled>
                <option value="">Select Type</option>
                <option value="vendor" <?php
                                        if ($preventive[0]->mt_payment_type == 'vendor') {
                                            echo "selected=selected";
                                        }
                                        ?>>Vendor</option>
                <!-- <option value="hppay_card" <?php
                                        if ($preventive[0]->mt_payment_type == 'hppay_card') {
                                            echo "selected=selected";
                                        }
                                        ?>>HPPAY Card</option> -->

            </select>
        </div>
</div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="city">Breakdown type<span class="md_field"></span></label></div>
                              <?php //var_dump($preventive[0]->mt_breakdown_type);?>
                        <div class="filed_input float_left width50" >
                            <select name="breakdown[mt_breakdown_type]" tabindex="8" id="break_type"   class=""  data-errors="{filter_required:'Breakdown Severity should not be blank!'}"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Breakdown Type</option>
                                <option value="Fuel Air lock" <?php
                                        if ($preventive[0]->mt_breakdown_type == 'Fuel Air lock') {
                                            echo "selected=selected";
                                        }
                                        ?>>Fuel Air lock</option>
                                
                                 <option value="Engine overheating (Cooling system)" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Engine overheating (Cooling system)') {
                                    echo "selected=selected";
                                }
                            ?>>Engine overheating (Cooling system)</option>
                            
                                <option value="Turbo Charger (Heavy smoke, Oil leakage)" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Turbo Charger (Heavy smoke, Oil leakage)') {
                                    echo "selected=selected";
                                }
                                        ?>>Turbo Charger (Heavy smoke, Oil leakage)</option>
                                        <option value="Engine Oil dilution" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Engine Oil dilution') {
                                    echo "selected=selected";
                                }
                                        ?>>Engine Oil dilution</option>
                                        <option value="Alternator Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Alternator Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Alternator Problem</option>
                                        <option value="Starter Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Starter Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Starter Problem</option>
                                        <option value="Battery Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Battery Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Battery Problem</option>
                                        <option value="Fuel Injector & Fuel Pump Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Fuel Injector & Fuel Pump Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Fuel Injector & Fuel Pump Problem</option>
                                        <option value="Clutch plate / Pressure plate problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Clutch plate / Pressure plate problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Clutch plate / Pressure plate problem</option>
                                        <option value="Gear Box" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Gear Box') {
                                    echo "selected=selected";
                                }
                                        ?>>Gear Box</option>
                                        <option value="Crown wheel pinion Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Crown wheel pinion Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Crown wheel pinion Problem</option>
                                         <option value="Tyre Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Tyre Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Tyre Problem</option>
                                          <option value="Steering System Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Steering System Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Steering System Problem</option>
                                           <option value="Break System Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Break System Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>Break System Problem</option>
                                            <option value="Electrical lights" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Electrical lights') {
                                    echo "selected=selected";
                                }
                                        ?>>Electrical lights</option>
                                             <option value="Body Damages" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Body Damages') {
                                    echo "selected=selected";
                                }
                                        ?>>Body Damages</option>
                                              <option value="AC System Problem" <?php
                                if ($preventive[0]->mt_breakdown_type == 'AC System Problem') {
                                    echo "selected=selected";
                                }
                                        ?>>AC System Problem</option>
                                        <option value="Others" <?php
                                if ($preventive[0]->mt_breakdown_type == 'Others') {
                                    echo "selected=selected";
                                }
                                        ?>>Others</option>
                            </select>

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div id="remark_other_textbox">
                        </div>
                    </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Nature Of Breakdown<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                <select name="breakdown[mt_add_nature_of_breakdown]" class="<?php if($approve != 'disabled'){ echo 'filter_required'; } ?>" data-errors="{filter_required:' Nature of breakdown should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> TABINDEX="5">

                                <option value="">Select Type</option>
                                <option value="Avoidable"  <?php
                                if ($preventive[0]->mt_add_nature_of_breakdown == 'Avoidable') {
                                    echo "selected=selected";
                                }
                                        ?>>Avoidable</option>
                                <option value="Unavoidable" <?php
                                if ($preventive[0]->mt_add_nature_of_breakdown == 'Unavoidable') {
                                    echo "selected=selected";
                                }
                                        ?>>Unavoidable</option>
                            
                                </select>
                            </div>
                        </div>
                </div>
                  <div class="width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Estimate Cost<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="Estimatecost" tabindex="23" class="form_input" placeholder="Estimate Cost" type="text"  value="<?= @$preventive[0]->mt_Estimatecost; ?>"    <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>
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
                    <div class="width_100 float_left">
                            
                        <div class="width_100 float_left" >
                            <div class="multiselect  field_row" >
                                 <div class="selectBox" onclick="showCheckboxes()" >
                                    <select <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>>
                                    <option value="" <?php echo $disabled; ?>>Select  Informed Employee</option>  
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
                                    <input type="checkbox" name="user_group[]" <?php echo $c_box1; ?> class="check_input unit_checkbox " value="UG-ShiftManager"   id="one" >
                                    <span class="chkbox_check_holder"></span>ShiftManager<br>
                                    </label>
                                    <label for="two" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]"  <?php echo $c_box2; ?>class="check_input unit_checkbox " value="UG-OperationHR"   id="two" >
                                        <span class="chkbox_check_holder"></span>Operation Manager<br>
                                    </label>
                                    <label for="three" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" <?php if($informed_to=='UG-ShiftManager') {echo "checked=checked"; } ?> class="check_input unit_checkbox " value="UG-ShiftManager"   id="three" >
                                        <span class="chkbox_check_holder"></span>Account<br>
                                    </label>
                                    <label for="four" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]"  <?php echo $c_box3; ?> class="check_input unit_checkbox " value="UG-DM"   id="four" >
                                        <span class="chkbox_check_holder"></span>Area Operation Manager<br>
                                    </label>
                                    <label for="five" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]"  <?php if($informed_to =='UG-ZM') {echo "checked=checked"; } ?> class="check_input unit_checkbox " value="UG-ZM"   id="five" >
                                        <span class="chkbox_check_holder"></span>Zonal Manager<br>
                                    </label>
                                    <label for="six" class="chkbox_check">
                                        <input type="checkbox" name="user_group[]" <?php if($informed_to =='UG-FleetManagement') {echo "checked=checked"; } ?> class="check_input unit_checkbox" value="UG-FleetManagement"   id="six" >
                                        <span class="chkbox_check_holder"></span>Fleet Manager<br>
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
                    <!--<div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                                <select name="maintaince[mt_shift_id]" tabindex="8"class="filter_required" data-errors="{filter_required:'Shift Type should not be blank!'}"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type($preventive[0]->mt_shift_id); ?>
                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Work Shop Name<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="maintaince[mt_work_shop]"  data-value="<?= @$preventive[0]->ws_station_name; ?>"  value="<?= @$preventive[0]->ws_station_name; ?>" class="mi_autocomplete filter_required"  data-href="<?php echo base_url(); ?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Work Shop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus;
                                    echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;?>>

                            </div>
                        </div>

                    </div>-->

                </div>
                 <div class="field_row width100">
                        <!-- <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                                <select name="breakdown[mt_shift_id]" tabindex="8"class="" data-errors="{filter_required:'Shift Type should not be blank!'}"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type($preventive[0]->mt_shift_id); ?>
                                </select>

                            </div>
                        </div> -->
                     <?php  if ($preventive[0]->mt_payment_type == 'vendor') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Workshop Name<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="breakdown[mt_work_shop]"   data-value="<?= @$preventive[0]->ws_station_name; ?>"  value="<?= @$preventive[0]->mt_work_shop; ?>" class="mi_autocomplete filter_required"  data-href="<?php echo base_url(); ?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus;  echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; }
                                    ?>>

                            </div>
                        </div>
                        <div class="width2 float_left hide" id="other_workshop" >
                            <div class="field_lable float_left width33"><label for="work_shop">Other Workshop Name<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="breakdown[wt_other_station_name]"  data-value="<?= @$preventive[0]->ws_other_station_name; ?>"  value="<?= @$preventive[0]->wt_other_station_name; ?>" class=""  placeholder="Work shop" data-errors="{filter_required:'Please select Other Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;?> >

                            </div>
                        </div>
                     <?php } ?>
                    </div>
                <div class="field_row width100">
                    <!--<div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="off_road_date">Off-Road  Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_offroad_datetime]"  value="<?= @$preventive[0]->mt_offroad_datetime; ?>" class="filter_required mi_timecalender" id="offroad_datetime"   placeholder="Off-Road  Date/Time" data-errors="{filter_required:'Off-Road  Date/Time should not be blank'}" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; ?>>



                        </div>
                    </div>-->
                    <!-- <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;?>>



                        </div>
                    </div> -->
                </div>
                     <?php } ?>
                    
                </div>
                <div class="field_row width100">



<!--                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">


                            <select name="breakdown[mt_stnd_remark]" tabindex="8" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove; echo $rerequest;?> > 
                                
                                <option value="" >Select Standard Remark</option>
                                
                               

                                <option value="Breakdown Maintenance"  <?php
                                   if (trim($preventive[0]->mt_stnd_remark) == 'Breakdown Maintenance') {
                                       echo "selected";
                                   }
                                   ?>>Breakdown Maintenance</option> 
                            </select>
                        </div>
                    </div>-->



                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_remark">Remark<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                            <textarea style="height:60px;" name="breakdown[mt_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   echo $approve; echo $finalapprove;?> <?php echo $view; if($type == 'Rerequest' && ( $clg_group == 'UG-FLEETDESK' || $clg_group =='UG-FleetManagement')){ echo $mo_rerequest; }else{ echo $rerequest; } ?> ><?= @$preventive[0]->mt_remark; ?></textarea>
                        </div>
                    </div>
                <!-- <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mt_send_material_request">Send Material request</label></div>


                    <div class="filed_input float_left width50" >
                         <div class="width100 float_left send_material_request" id="send_material_request">
                <label for="mt_send_material_request_yes" class="radio_check width2 float_left">
                     <input id="mt_send_material_request_yes" type="radio" name="breakdown[mt_send_material_request]" class="radio_check_input filter_either_or[mt_send_material_request_yes,mt_send_material_request_no]" value="Yes" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($preventive[0]->mt_send_material_request == "Yes"){ echo "checked";}?>>
                     <span class="radio_check_holder" ></span>Yes
                </label>
                <label for="mt_send_material_request_no" class="radio_check width2 float_left">
                    <input id="mt_send_material_request_no" type="radio" name="breakdown[mt_send_material_request]" class="radio_check_input filter_either_or[mt_send_material_request_yes,mt_send_material_request_no]" value="No" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($preventive[0]->mt_send_material_request == "No" || $preventive[0]->mt_send_material_request == "" ){ echo "checked";}?>>
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
                            <input id="added_by" type="text" name="breakdown[added_by]" class=""  data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>" value="<?= @$clg_ref_id;  ?>" disabled="disabled">
                        </div>
                    </div>

                </div>

                <?php } ?>
                <div id="send_material_request_block">
                    
                </div>
                <div id="hidden_maintence_part">
                    
                </div>
                <div class="width100">
                     <div class="field_row width100">
                    <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width33">
                                    <label for="photo">Damaged Part Photos</label>
                                </div>

                                <div class="field_row filter_width width100">

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
                            <div class="filed_input outer_clg_photo width100">
                               <!--<div class="width1 text_align_center add_more_ind">
                                      <?php 
 
                                    
                                      if($approve != 'disabled'  && $update != 'disabled' ){ ?>
                                        <a class="image_more btn">Add more image +</a>
                                       <?php } ?>

                                 </div>-->
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                            <input multiple="multiple"  type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; echo $rerequest; ?> <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   ?>  class="files_amb_photo">


                                        </div>
                                    </div>
                                 
                                </div>

        <?php 
        if ($media) {
          //  var_dump($media);
            foreach($media as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;
                  // echo $pic_path;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
     <div class="images_block" id="image_<?php echo $img->id;?>">
                                               <?php 
                                      if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
<!--                                    <a class="remove_images click-xhttp-request" style="color:#000;" data-href="<?php echo base_url();?>ambulance_maintaince/remove_images" data-qr="id=<?php echo $img->id; ?>&output_position=image_<?php echo $img->id;?>"></a>-->
                                      <?php } ?>
                                        <a class="ambulance_photo float_left" target="blank" href="<?php
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
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>

 </div>
        <?php } } ?>

                            
    

                    </div>
                </div>
                </div>
            </div>
        </div>
                <?php if ($used_invitem) {  ?>
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Used Part Information</div>
                        <table class="table report_table">

                            <tr>   
                                <th nowrap>Part Name</th>     
                                <th nowrap>Quantity</th>        

                            </tr>
                            <?php  //var_dump($his);
                            if ($used_invitem > 0) {
                            //$count = 1;
                           foreach ($used_invitem as $used) { ?>
                               
                            <tr>
                                 <td><?php echo $used->Item_Code; ?></td>  
                                <td><?php echo $used->mt_part_title; ?></td>  
                                <td><?php echo $used->as_item_qty; ?></td>
                            </tr>
                            <?php
                        }
                    } else { ?>

                        <tr><td colspan="3" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>
            </div>
                 <?php } ?>
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
        </div>
               
<?php
if ($upload_job_card) {
    ?>  
            <div class="field_row width100  fleet"><div class="single_record_back">Upload Job-Card Image/Photo/Estimate</div></div>
            <input type="hidden" name="breakdown[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
             <input type="hidden" name="mt_id" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
            <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">


        <div class="field_row width100 float_left job_card_breakdown">

            <div class="field_row width100 float_left">
                <div class="field_lable float_left width33">
                    <label for="photo">Upload Job-Card Image/Photo/Estimate</label>
                </div>

                <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">
                                <input type="file" name="vendor_job_card[]" TABINDEX="18"  <?php echo $view; echo $rerequest; ?>  class="files_amb_photo" multiple="multiple" data-errors="{filter_required:'Job-Card Image should not be blank'}">

                            </div>
                        </div>                                
                    </div>    
                </div>
            </div>
        </div>

            

            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark</label></div>


                    <div class="filed_input float_left width50" >
                        <textarea style="height:60px;" name="breakdown[mt_job_card_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php
                              if ($preventive[0]->mt_job_card_remark != '') {
                                  echo "disabled";
                              }
                              ?>><?= @$preventive[0]->mt_job_card_remark; ?></textarea>
                    </div>
                </div>


                </div>

            </div>


        <?php } ?>

<?php if($vendor_job_card){     ?> 
                     <div class="field_row width100  fleet">
                        <div class="single_record_back">Job Card Information</div>
                </div>
                          <div class="filed_input outer_clg_photo width100">
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                            <input multiple="multiple"  type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; echo $rerequest; ?> <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;   ?>  class="files_amb_photo">


                                        </div>
                                    </div>
                                 
                                </div>

        <?php 
        if ($vendor_job_card) {
          //  var_dump($media);
            foreach($vendor_job_card as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;
                  // echo $pic_path;

                                                    if (file_exists($pic_path)) {
                                                       
                                                        $ext = pathinfo($name, PATHINFO_EXTENSION); 
                                                         $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                         if(in_array($ext, $haystack)){
                                                              $pic_path1 = base_url() . "themes/backend/images/allinone.png";
                                                         }
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
     <div class="images_block" id="image_<?php echo $img->id;?>">
                                               <?php 
                                      if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                   
                                      <?php } ?>
                                        <a class="ambulance_photo float_left" target="blank" href="<?php
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
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>

 </div>
        <?php } } ?>

                            
    

                    </div>
                    <div class="field_row width100">
                        <div class="field_lable float_left width33">
                            <label for="photo">Remark</label>
                        </div>
                        <div class="filed_input float_left" style="width: 50%;">
                            
                            <?php echo $preventive[0]->mt_job_card_remark; ?>

                         </div>
                        
                        
                    </div>
                    <?php
                }
                    ?>
            
             <?php if($vendor_invoice){     ?> 
                     <div class="field_row width100  fleet">
                        <div class="single_record_back">Invoice/Bill Information</div>
                </div>
                          <div class="filed_input outer_clg_photo width100">
                                <div class="images_main_block width1" id="images_main_block">
                                    <div class="upload_images_block">
                                        <div class="images_upload_block">
                                          


                                        </div>
                                    </div>
                                 
                                </div>

        <?php 
        if ($vendor_invoice) {
          //  var_dump($media);
            foreach($vendor_invoice as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "uploads/ambulance/" . $name;
                    $ext = pathinfo($name, PATHINFO_EXTENSION); 
                  // echo $pic_path;
  $blank_pic_path = base_url() . "themes/backend/images/allinone.png";
                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                                                        if(in_array($ext, $haystack)){
                                                              $blank_pic_path = base_url() . "themes/backend/images/allinone.png";
                                                         }else{
                                                               $blank_pic_path = base_url() . "uploads/ambulance/" . $name;
                                                         }
                                                    }
                                                  
            ?>
     <div class="images_block" id="image_<?php echo $img->id;?>">
                                               <?php 
                                      if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                  
                                      <?php } ?>
                                        <a class="ambulance_photo float_left" target="blank" href="<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } else {
                                        echo $blank_pic_path;
                                    }
                                    ?>" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $blank_pic_path;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>

 </div>
        <?php } } ?>

                            
    

                    </div>
            <br>
                    <div class="field_row width100">
                        <div class="field_lable float_left width33">
                            <label for="photo">Invoice Remark</label>
                        </div>
                        <div class="filed_input float_left" style="width: 50%;">
                            
                            <?php echo $preventive[0]->mt_invoice_remark; ?>

                         </div>
                        
                        
                    </div>
        <br>
        <br>
        <br>
                    <?php
                }
                    ?>
            <?php
if ($upload_invoice) {
    ?>  
            <div class="field_row width100  fleet"><div class="single_record_back">Upload Invoice/Bill</div></div>
            <input type="hidden" name="breakdown[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
            <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">
             <input type="hidden" name="vendor_id" value="<?=@$preventive[0]->vendor_id ;?>">
             <input type="hidden" name="mt_breakdown_id" value="<?=@$preventive[0]->mt_breakdown_id ;?>">


        <div class="field_row width100 float_left job_card_breakdown">

            <div class="field_row width100 float_left">
                <div class="field_lable float_left width33">
                    <label for="photo">Invoice/Bill</label>
                </div>

                <div class="filed_input outer_clg_photo width100">
                    <div class="images_main_block width1" id="images_main_block">
                        <div class="upload_images_block">
                            <div class="images_upload_block">

                                <input type="file" name="vendor_invoice[]"  TABINDEX="18"  <?php echo $view; echo $rerequest; ?>  class="files_amb_photo" multiple="multiple" data-errors="{filter_required:'Invoice/BillImage should not be blank'}">

                            </div>
                        </div>                                
                    </div>    
                </div>
            </div>
        </div>

            

            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark</label></div>


                    <div class="filed_input float_left width50" >
                        <textarea style="height:60px;" name="breakdown[mt_invoice_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php
                              if ($preventive[0]->mt_invoice_remark != '') {
                                  echo "disabled";
                              }
                              ?>><?= @$preventive[0]->mt_invoice_remark; ?></textarea>
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






                    <div class="field_row width100  fleet"><div class="single_record_back">Breakdown Repair Request Approval</div></div>
                    <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                    <input type="hidden" name="previous_odometer" value="<?=@$preventive[0]->mt_previos_odometer;?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?=@$preventive[0]->mt_amb_no;?>">
                    <input type="hidden" name="Breakdown_Severity" value="<?=@$preventive[0]->mt_brakdown_severity;?>">
                    <input type="hidden" name="mt_breakdown_id" value="<?=@$preventive[0]->mt_breakdown_id ;?>">
                    <input type="hidden" name="vendor_id" value="<?=@$preventive[0]->vendor_id ;?>">
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <?php //$gender[@$current_data[0]->clg_gender] = "checked"; ?>
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$preventive[0]->mt_approval;?>"  id="approve" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}"  TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$preventive[0]->mt_approval?>"  id="rejected" type="radio" name="app[mt_approval]" value="2" class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$preventive[0]->mt_approval?>"  id="under_process" type="radio" name="app[mt_approval]" value="3" class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Under Process
                        </div>

                            </div>
                        </div>
                          <div class="field_row width100 hide" id="under_process_remark">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Under Process Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_under_process_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Under Process Remark should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  ?>><?= @$preventive[0]->mt_app_under_process_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                        <div class="width2 float_left hide_underprocess hideon_reject">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                             
                                  <input type="text" name="app[mt_app_onroad_datetime]"  value=" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '1970-01-01 05:30:00' && $preventive[0]->mt_onroad_datetime != ''){ echo $preventive[0]->mt_onroad_datetime;}?>" class="filter_required OnroadDate" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '1970-01-01 05:30:00' && $preventive[0]->mt_onroad_datetime != ''){ echo "disabled";}?> >



                            </div>
                        </div>
                    </div>
                    <div class="width100 float_left">
<!--                    <div class="width2 float_left hideon_reject">
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
                    <div class="field_row width100 hide_underprocess">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_app_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  ?>><?= @$preventive[0]->mt_app_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap hide_underprocess">
                        <div class="width2 float_left hideon_reject">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Estimate Amount<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_est_amt]"  value="<?php if( $preventive[0]->mt_app_est_amt != ''){ echo $preventive[0]->mt_app_est_amt;}?>" class=" form_input filter_maxlength[7] filter_number" placeholder="Approved Estimate Amount" data-errors="{filter_required:'Approved Estimate Amount should not be blank'}" TABINDEX="8" <?php if($preventive[0]->mt_app_est_amt != ''){ echo "disabled";}?> id="mt_onroad_datetime">

                            </div>
                        </div>
                        <div class="width2 float_left hideon_reject">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Repairing Time</label></div>

                            <div class="filed_input float_left width50" >
                               
                                  <input type="text" name="app[mt_app_rep_time]"  value=" <?php if($preventive[0]->mt_app_rep_time != '0000-00-00 00:00:00' && $preventive[0]->mt_app_rep_time != '1970-01-01 05:30:00' && $preventive[0]->mt_app_rep_time != ''){ echo $preventive[0]->mt_app_rep_time;}?>" class=" " placeholder="Repairing Time" data-errors="" TABINDEX="8" <?php if($preventive[0]->mt_app_rep_time != '0000-00-00 00:00:00'  && $preventive[0]->mt_app_rep_time != '1970-01-01 05:30:00'  && $preventive[0]->mt_app_rep_time != ''){ echo "disabled";}?> id="mt_onroad_datetime">



                            </div>
                        </div>
                    </div>

                    <div class="field_row width100 ap hide_underprocess">
                        <div class="width2 float_left hideon_reject" >
                            <div class="field_lable float_left width33"><label for="end_odometer">Approved Work Shop<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50" >
                            
                            <input type="text" name="app[mt_app_work_shop]"  data-value="<?=@$preventive[0]->ws_station_name;?>"  value="<?=@$preventive[0]->ws_station_name;?>" class="mi_autocomplete"  data-href="<?php echo base_url();?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update;  echo $upload_invoice;  echo $upload_job_card;  ?>>

                            </div>
                        </div>
                            <div class="width2 float_left hideon_reject">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Nature Of Breakdown<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                               
                                <select name="app[nature_of_breakdown]" class="filter_required" data-errors="{filter_required:' Nature of breakdown should not be blank'}"  TABINDEX="5">

                                <option value="">Select Type</option>
                                <option value="Avoidable">Avoidable</option>
                                <option value="Unavoidable">Unavoidable</option>
                            
                                </select>
                            </div>
                          
                        </div>
                           
                       
                       
                    </div>


              

                <?php } ?>   
              <?php
if ($update) {
    $previous_odo = $preventive[0]->mt_in_odometer;
    ?>  
            <div class="field_row width100  fleet"><div class="single_record_back">Closure Information</div></div>
            <input type="hidden" name="breakdown[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
            <input type="hidden" name="previous_odometer" value="<?= @$preventive[0]->mt_in_odometer; ?>">
            <input type="hidden" name="maintaince_ambulance" value="<?= @$preventive[0]->mt_amb_no; ?>">
             <input type="hidden" name="maintaince_district" value="<?= @$preventive[0]->mt_district_id ; ?>">
              <input type="hidden" name="base_location" value="<?= @$preventive[0]->mt_base_loc; ?>">
<input type="hidden" name="maintaince_state" value="<?= @$preventive[0]->mt_state_id ; ?>">


 <?php if($preventive[0]->mt_approval == '1'){?>
            <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Bill Number</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_clo_bill_number" value="<?=@$preventive[0]->bill_number;?>" class="" placeholder="Bill Number" data-errors="{filter_required:'Bill Number should not be blank'}" TABINDEX="8" <?php if($preventive[0]->bill_number !=''){ echo "disabled"; }?>>


                            </div>
                        </div>
               
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Cost Of Spare Parts</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_clo_part_cost" id="closure_part_cost" onkeyup="closure_sum();" value="<?=@$preventive[0]->part_cost;?>" class="" placeholder="Cost Of Spare Parts" data-errors="{filter_required:'Cost Of Spare Parts should not be blank'}" TABINDEX="8" >


                            </div>
                        </div>
                    </div>

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Labour Cost</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_clo_labour_cost" id="closure_labour_cost" onkeyup="closure_sum();" value="<?=@$preventive[0]->labour_cost;?>" class="" placeholder="Labour Cost" data-errors="{filter_required:'Labour Cost should not be blank'}" TABINDEX="8" >


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Total Amount<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="mt_clo_total_cost" id="closure_total_cost" value="<?=@$preventive[0]->total_cost;?>" class="filter_required" placeholder="Total Amount" data-errors="{filter_required:'Total Amount should not be blank'}" TABINDEX="8" >


                            </div>
                        </div>
                    </div>
 <?php } ?>
            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50" >
                        <input type="text" name="mt_end_odometer" value="<?= @$preventive[0]->mt_end_odometer; ?>" class="filter_required filter_number filter_valuegreaterthan[<?= @$preventive[0]->mt_in_odometer; ?>] filter_maxlength[7]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'End Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Current Odometer should greater than or equal to Previous Odometer',filter_number:'Enter number only',filter_maxlength:'Preventive Maintenance Previous Odometer at max 6 digit long.'}" TABINDEX="8" <?php
    if ($preventive[0]->mt_end_odometer != '') {
        echo "disabled";
    }
    ?>>


                    </div>
                </div>
                <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time</label></div>

                    <div class="filed_input float_left width50" >

                        <input type="text" name="breakdown[mt_onroad_datetime]"  value=" <?php
    if ($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '') {
        echo $preventive[0]->mt_onroad_datetime;
    }
    ?>" class="OnroadDate mi_timecalenderon" placeholder="On road Date/Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php
    if ($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '') {
        echo "disabled";
    }
    ?>  id="mt_onroad_datetime">



                    </div>
                </div>
            </div>
            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark</label></div>


                    <div class="filed_input float_left width50" >
                        <textarea style="height:60px;" name="breakdown[mt_on_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php
                              if ($preventive[0]->mt_on_remark != '') {
                                  echo "disabled";
                              }
                              ?>><?= @$preventive[0]->mt_on_remark; ?></textarea>
                    </div>
                </div>
         <div class="width2 float_left unit_drags">

    <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Maintenance Parts</label></div>
    
    <input name="unit_drags" tabindex="6" class="form_input unit_drags_input width2" placeholder="Maintenance Parts" type="text" data-base="search_btn" data-errors="{filter_required:'Maintenance Parts used should not be blank!'}" style="width:50%;" id="maintananace_part_input" oninput="maintananace_part_search()">

                            <div id="unit_drugs_box">

                                <?php
                                //  var_dump($pcr_med_inv_data);
                                if ($pcr_med_inv_data) {
                                    $med_inv_data = array();


                                    foreach ($pcr_med_inv_data as $pcr_med) {

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                if ($pcr_med_data) {
                                    $med_data = array();


                                    foreach ($pcr_med_data as $pcr_med) {

                                        $med_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box" id="unit_drugs_box_list">
                                    <ul class="width100">
                                        <?php if ($invitem) { ?>

                                            <?php foreach ($invitem as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $item->mt_part_id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="unit[<?php echo $item->mt_part_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->mt_part_id; ?>"  id="unit_<?php echo $item->mt_part_id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->mt_part_id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->Item_Code); ?> - <?php echo stripslashes($item->mt_part_title); ?><br>
                                                    </label>
                                        <!--            <input type="checkbox" value="<?php echo $item->med_id ?>" name="unit[<?php echo $item->mt_part_id; ?>][id]" class="unit_checkbox"><?php echo $item->mt_part_title; ?><br>-->
                                                    <?php if (isset($med_inv_data[$item->mt_part_id])) {
                                                    ?>
                                              <div class="unit_div">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->mt_part_id; ?>][value]" value="<?php echo $med_inv_data[$item->mt_part_id]->as_item_qty ?>" class="filter_if_not_blank filter_float width50" data-errors="{filter_float:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_ca_unit_box();">
                                                                                                                                                            <input type="hidden" name="unit[<?php echo $item->mt_part_id; ?>][type]" value="<?php echo $item->mt_part_type; ?>" class="width50" data-base="unit_iteam" >
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->mt_part_id; ?>][value]" value="" class="width50 filter_if_not_blank filter_float" data-errors="{filter_float:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_ca_unit_box();">
                                                                                                                                                            <input type="hidden" name="unit[<?php echo $item->mt_part_id; ?>][type]" value="<?php echo $item->mt_part_type; ?>" class="width50" data-base="unit_iteam">
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                                               
                                    </ul>
                                </div>
                                <input name="unit_iteam" id="show_unit_box_selected_ca" style="display: none;" value="Done" class="style3 base-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/show_maintanance_part_list" data-qr="output_position=show_selected_unit_item_ca" type="button">     
                               
                                <div id="show_selected_unit_item_ca" style="width:95%">
                                </div>



                            </div>  

                        </div>


                </div>
                <div id="app_send_material_request_block">
                    
                </div>
                <div id="app_hidden_maintence_part">
                    
                </div>
            </div>
            <div class="field_row width100 float_left">

                         <div class="field_row width100 float_left">
                             
                                <div class="field_lable float_left width33">
                                    <label for="photo">Photo</label>
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

                <?php if ($finalapprove) {  ?>
                    
                    <div class="field_row width100  fleet">
                        <div class="single_record_back">Final Approval Information</div>
                        
                           <input type="hidden" name="app[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">
                </div>
                <div class="field_row width100">
                <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Bill Number</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="final_bill_number" value="<?=@$preventive[0]->bill_number;?>" class="" placeholder="Bill Number" data-errors="" TABINDEX="8" <?php //echo "disabled"; ?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Cost Of Spare Parts</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="final_part_cost" id="closure_part_cost" value="<?=@$preventive[0]->part_cost;?>" class="" placeholder="Cost Of Spare Parts" data-errors="" onkeyup="closure_sum();" TABINDEX="8" <?php  //echo "disabled"; ?>>


                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Labour Cost</label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="final_labour_cost" id="closure_labour_cost"  value="<?=@$preventive[0]->labour_cost;?>" class="" placeholder="Labour Cost" data-errors="" onkeyup="closure_sum();" TABINDEX="8" <?php //echo "disabled"; ?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Total Amount<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                            <input type="text" name="final_total_cost" id="closure_total_cost"  value="<?=@$preventive[0]->total_cost;?>" class="" placeholder="Total Amount" data-errors="" TABINDEX="8" <?php //echo "disabled"; ?>>

                            </div>
                        </div>
<!--                        <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50" >
                        <input type="text" name="mt_end_odometer" value="<?= @$preventive[0]->mt_end_odometer; ?>" class="" placeholder="End Odometer" data-errors="" TABINDEX="8" <?php //echo "disabled";?>>


                    </div>
                </div>-->


                <div class="width2 float_left">

                                <div class="field_lable float_left width33"><label for="mt_onroad_datetime">On-road Date/Time</label></div>

                                <div class="filed_input float_left width50" >

                                    <input type="text" name="breakdown[mt_onroad_datetime]"  value=" <?php
                                if ($preventive[0]->mt_onroad_datetime != '0000-00-00 00:00:00' && $preventive[0]->mt_onroad_datetime != '') {
                                echo $preventive[0]->mt_onroad_datetime;
                                }
                                ?>" class="OnroadDate mi_timecalenderon" placeholder="On road Date/Time" data-errors="" TABINDEX="8" <?php //echo "disabled";?>  id="mt_onroad_datetime">

                                </div>
                                </div>
              
                 </div>

                <div class="field_row width100">
                <div class="field_lable float_left width33">
                                    <label for="photo">Damaged Part Photos</label>
                                </div></div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">Approval<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50 approve_selection" >
                            
                            <?php //$gender[@$current_data[0]->clg_gender] = "checked"; ?>
                        
                        <div class="radio_button_div">
                            <input  data-base="<?=@$preventive[0]->mt_app_fn_approval;?>"  id="approve" type="radio" name="app[mt_approval]" value="1" class="approve" data-errors="{}"  TABINDEX="16" checked  <?php echo $view;?>>Accepted
                        </div>
                        <div class="radio_button_div">
                            <input data-base="<?=@$preventive[0]->mt_app_fn_approval?>"  id="approve" type="radio" name="app[mt_approval]" value="2" class="approve" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17"  <?php echo $view;?>>Rejected
                        </div>
                       

                            </div>
                        </div>
                        
                      
                    </div>
                    <div class="field_row width100 hide_underprocess">
                        <div class="width100 float_left">
                            <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Remark<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left" style="width: 78%;">
                            
                            <textarea style="height:60px;" name="app[mt_final_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  ?>><?= @$preventive[0]->mt_app_fn_remark; ?></textarea>

                            </div>
                        </div>
           
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
                            
                            <textarea style="height:60px;" name="app[re_request_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}" <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  ?>><?= @$preventive[0]->re_remark; ?></textarea>

                            </div>
                        </div>
           
                    </div>
                    
                    <div class="field_row width100 ap">
                    <div class="field_lable float_left" style="width: 16.5%;"><label for="end_odometer">Photo<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left" style="width: 50%;">
                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>" id="rerequest_reset_img" type="file" name="amb_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"  <?php echo $view; ?> multiple="multiple"  <?php echo $update;  echo $upload_invoice;  echo $upload_job_card;  ?>> 
                    </div>
                     </div>
                    </div>
                    <div class="field_row width100 ap">
                    <div class="button_box field_lable float_left" style="width: 60%;">
                        <input type="button" name="Reset" value="Reset Image" class="btn" id="remove_reset_img">
                    </div>
                    </div>

                <?php } 
                
                if($Update_Breakdown){?> 
                    
  <input type="hidden" name="breakdown[mt_id]" id="ud_mt_id" value="<?= @$preventive[0]->mt_id ?>">


<?php
                }

if (!@$view_clg) { ?>
            <div class="button_field_row width100 margin_auto save_btn_wrapper">
                <div class="button_box">
<input type="button" name="submit" value="<?php if ($update) { ?>Closure<?php } elseif($approve) { ?>Approve<?php }elseif($finalapprove) { ?>Final Approve<?php }elseif($rerequest){ ?>Re-Request<?php }else {?>Submit<?php } ?>" class="btn submit_btnt accept_btn form-xhttp-request" data-href='<?php echo base_url(); ?>ambulance_maintaince/<?php if ($update) { ?>update_breakdown_maintaince<?php } elseif($approve) { ?>update_approve_breakdown_maintaince<?php }elseif($finalapprove) { ?>final_update_approve_breakdown_maintaince<?php } elseif($rerequest){ ?>update_rerequest_breakdown_maintaince<?php }elseif($upload_job_card){ echo "upload_job_card"; }elseif($upload_invoice){ echo "upload_invoice_bill"; }else if($Update_Breakdown){ echo "breakdown_maintaince_update"; }else { ?>breakdown_maintaince_save<?php } ?>' data-qr='output_position=content&amp;module_name=clg&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$preventive[0]->mt_id; ?>">

        <!--<input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">-->
                </div>
            </div>

<?php } ?>



    </div>         
</form>
<script>
$(document).ready(function() {
    
         $(".approve_selection input").change(function(){
         $approve_val = $(this).val();
            if($approve_val == 1){
             $('.hideon_reject').removeClass('hide');
             $('.hideon_reject').addClass('show');
             $('.hideon_reject input').addClass('filter_required');

             $('#under_process_remark').removeClass('show');
             $('#under_process_remark').addClass('hide');
              $('#under_process_remark input').removeClass('filter_required');
              }
             else if($approve_val == 2){
              $('#under_process_remark').removeClass('show');
              $('#under_process_remark').addClass('hide');
              $('#under_process_remark input').removeClass('filter_required');

              $('.hideon_reject').addClass('hide');
              $('.hideon_reject').removeClass('has_error');
              $('.hideon_reject input').removeClass('filter_required filter_maxlength[7] filter_number');
              $('.hideon_reject select').removeClass('filter_required filter_maxlength[7] filter_number');

           
         }
         else if($approve_val == 3){
              $('#under_process_remark').removeClass('hide');
              $('#under_process_remark input').addClass('filter_required');

              $('.hideon_reject').removeClass('hide');
             $('.hideon_reject').addClass('show');
             $('.hideon_reject input').addClass('filter_required');
         }

    });
    

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
      console.log(file);
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
        console.log(jsDate);
        var $mindate = new Date(jsDate);
        console.log($mindate);

        $('.OnroadDate').datetimepicker({
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss",
                minDate: $mindate,
                // minTime: jsDate[1],

        });
        $("#offroad_datetime").change(function () {
            var jsDate = $("#offroad_datetime").val();
            var $mindate = new Date(jsDate);


            $('.OnroadDate').datetimepicker({
                dateFormat: "yy-mm-dd",
                 timeFormat: "HH:mm:ss",
                minDate: $mindate,
                // minTime: jsDate[1],

            });
        });
    });

    function cost_sum() {
       var txtFirstNumberValue = 0;
       var txtSecondNumberValue = 0;
       txtFirstNumberValue = document.getElementById('labor_cost').value;
       txtSecondNumberValue = document.getElementById('local_purchase_cost').value;
      var result =  parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('total_cost').value = result;
      }
}
    function closure_sum() {
       var txtFirstNumberValue = 0;
       var txtSecondNumberValue = 0;
       txtFirstNumberValue = document.getElementById('closure_part_cost').value;
       txtSecondNumberValue = document.getElementById('closure_labour_cost').value;
      var result =  parseInt(txtSecondNumberValue) + parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('closure_total_cost').value = result;
      }
}
</script>
<style>
    .mi_loader{
        display: none !important;
    }
</style>
