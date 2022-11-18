<?php if ($clg_group !== 'UG-VENDOR') { ?>
      <div class="field_row width100">

            <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="mt_payment_type">Payment Type<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50" >

                        <select name="breakdown[mt_payment_type]"  id="selfield" data-errors="{filter_required:'Payment Type should not be blank'}" <?php echo $update; echo $approve; echo $rerequest; ?> TABINDEX="5"  class="filter_required change-xhttp-request" data-href="" data-qr="output_position=content" onchange="showDiv('hidden_div', this)">
                            <option value="">Select Type</option>
                            <option value="vendor">Vendor</option>
                            <!-- <option value="hppay_card">HPPAY Card</option> -->

                        </select>
                    </div>
            </div>


                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="city">Breakdown type<span class="md_field">*</span></label></div>
                              <?php //var_dump($preventive[0]->mt_breakdown_type);?>
                        <div class="filed_input float_left width50" >
                            <select name="breakdown[mt_breakdown_type]" tabindex="8" id="break_type"   class="filter_required"  data-errors="{filter_required:'Breakdown Type should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest;?>> 
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
                                        ?>>Gear Box/option>
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
                               
                                <select name="breakdown[mt_add_nature_of_breakdown]" class="filter_required" data-errors="{filter_required:' Nature of breakdown should not be blank'}" <?php echo $update; echo $approve; echo $rerequest;?> TABINDEX="5">

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
                        <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_estimatecost">Estimate cost<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50" >
                        <input name="Estimatecost" tabindex="23" class="" id="numberbox" placeholder="Estimate cost" type="text" value="<?= @$preventive[0]->mt_Estimatecost; ?>"    <?php echo $update; echo $approve; echo $rerequest;?> data-errors="{filter_required:'Estimate Cost should not be blank',filter_rangelength:'Estimate Cost between range  0 - 3000'}">
                     </div>
                    </div>
                </div>
                  <div class="width100">
                  
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
                                    <select <?php echo $update; echo $approve; echo $rerequest;?>>
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
                                <select name="maintaince[mt_shift_id]" tabindex="8"class="filter_required" data-errors="{filter_required:'Shift Type should not be blank!'}"  <?php echo $update; echo $approve; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type($preventive[0]->mt_shift_id); ?>
                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="work_shop">Work shop Name<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="maintaince[mt_work_shop]"  data-value="<?= @$preventive[0]->ws_station_name; ?>"  value="<?= @$preventive[0]->ws_station_name; ?>" class="mi_autocomplete filter_required"  data-href="<?php echo base_url(); ?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Work shop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus;
                                    echo $update; echo $approve;?>>

                            </div>
                        </div>

                    </div>-->

                </div>
                 <div class="field_row width100">
                        <!-- <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">
                                <select name="breakdown[mt_shift_id]" tabindex="8" class="filter_required" data-errors="{filter_required:'Shift Type should not be blank!'}"  <?php echo $update; echo $approve; echo $rerequest; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type($preventive[0]->mt_shift_id); ?>
                                </select>

                            </div>
                        </div> -->
                        <div class="width2 float_left" id="hidden_div">
                            <div class="field_lable float_left width33"><label for="work_shop">Workshop Name<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="breakdown[mt_work_shop]"  data-value="<?= @$preventive[0]->ws_station_name; ?>"  value="<?= @$preventive[0]->ws_station_name; ?>" class="mi_autocomplete filter_required" id="mt_work_shop" data-href="<?php echo base_url(); ?>auto/get_work_shop"  placeholder="Work shop" data-errors="{filter_required:'Please select Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus;
                                    echo $update; echo $approve; echo $rerequest;
                                    ?>>

                            </div>
                        </div>
                        <div class="width2 float_left hide" id="other_workshop" >
                            <div class="field_lable float_left width33"><label for="work_shop">Other Workshop Name<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="breakdown[wt_other_station_name]"  data-value="<?= @$preventive[0]->ws_other_station_name; ?>"  value="<?= @$preventive[0]->wt_other_station_name; ?>" class=""  placeholder="Work shop" data-errors="{filter_required:'Please select Other Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update; echo $approve;?> >

                            </div>
                        </div>

                    </div>

                    <?php } ?>
                <div class="field_row width100">
                    <!--<div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="off_road_date">Off-Road  Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_offroad_datetime]"  value="<?= @$preventive[0]->mt_offroad_datetime; ?>" class="filter_required mi_timecalender" id="offroad_datetime"   placeholder="Off-Road  Date/Time" data-errors="{filter_required:'Off-Road  Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; ?>>



                        </div>
                    </div>-->
                    <!-- <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="breakdown[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve;?>>



                        </div>
                    </div> -->
                </div>

                <script>
                     function showDiv(hidden_div, element)
                            {
                                var target = $('#selfield option:selected').val();
                                // alert (target);
                                if(target == "hppay_card"){
                                    $("#mt_work_shop").parent().find('input').removeClass("filter_required");
                                    $("#mt_work_shop").parent().find('input').removeClass("has_error");
                                    $("#removeclass").removeClass("filter_required");
                                   // $("#numberbox").addClass("has_error filter_required filter_rangelength[0-3000]");
//                                    $('#numberbox').keyup(function(){
//                                    if ($(this).val() > 3000){
//                                        alert("Estimate cost must be less than 3000");
//                                        $(this).val('');
//                                    }
//                                    });
                                }else{
                                     //$("#numberbox").removeClass("has_error filter_required filter_rangelength[0-3000]");
                                }
                                document.getElementById(hidden_div).style.display = element.value == 'vendor' ? 'block' : 'none';

                                
                            }
                </script>
                <style>
                    #hidden_div {
                                display: block;
                        }
                </style>