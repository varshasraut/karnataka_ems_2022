<?php if ($clg_group !== 'UG-VENDOR') { ?>
<div class="field_row width100">
<div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_payment_type">Payment Type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_payment_type]"  data-errors="{filter_required:'Payment Type should not be blank'}" <?php echo $update; echo $approve; echo $rerequest; ?> TABINDEX="5"  class="filter_required change-xhttp-request" data-href="" data-qr="output_position=content" id="selfield" onchange="showDiv('hidden_div', this)">
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

        <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Material used<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_material_used]"  data-errors="{filter_required:'Material used should not be blank'}" <?php echo $update; echo $approve; echo $rerequest; ?> TABINDEX="5"  class="filter_required change-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/material_used" data-qr="output_position=content">

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
    
</div>
<div  class="field_row width100">
        <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_labour_type">Labor Type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >

            <select name="breakdown[mt_labor_type]"  data-errors="{filter_required:'Labor Type should not be blank'}" <?php echo $update; echo $approve; echo $rerequest; ?> TABINDEX="5"  class="filter_required change-xhttp-request" data-href="<?php echo base_url();?>ambulance_maintaince/labor_type" data-qr="output_position=content">

                <option value="">Select Type</option>
                <option value="Inhouse-Free"  <?php
                if ($preventive[0]->mt_material_used == 'Inhouse-Free') {
                    echo "selected=selected";
                }
                ?>>Inhouse-Free</option>
                <option value="Outside Vendor/Mech" <?php
                if ($preventive[0]->mt_material_used == 'Outside Vendor/Mech') {
                    echo "selected=selected";
                }
                ?>>Outside Vendor/Mech</option>

            </select>
        </div>
    </div>
    <div class="width2 float_left" id="labour_cost_block">

    </div>
    <div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="labor_cost">Total Cost<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="breakdown[total_cost]" id="total_cost" value="" class="filter_required" placeholder="Labor Cost" TABINDEX="8" data-errors="{filter_required:'Total Cost should not be blank',filter_rangelength:'Total Cost between range  0 - 3000'}">
    </div>
</div>
<div class="field_row width100">

                        <div class="width2 float_left" id="hidden_div">
                            <div class="field_lable float_left width33"><label for="work_shop">Workshop Name<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" id="mt_work_shop" name="breakdown[mt_work_shop]"  data-value="<?= @$preventive[0]->ws_station_name; ?>"  value="<?= @$preventive[0]->ws_station_name; ?>" class="mi_autocomplete filter_required"  data-href="<?php echo base_url(); ?>auto/get_work_shop"  placeholder="Work shop"  TABINDEX="8"  <?php echo $autofocus;
                                    echo $update; echo $approve; echo $rerequest;
                                    ?> data-errors="{filter_required:'Please select Workshop Name from dropdown list'}">

                            </div>
                        </div>
                        <div class="width2 float_left hide" id="other_workshop" >
                            <div class="field_lable float_left width33"><label for="work_shop">Other Workshop Name<span class="md_field"></span></label></div>

                            <div class="filed_input float_left width50">

                                <input type="text" name="breakdown[wt_other_station_name]"  data-value="<?= @$preventive[0]->ws_other_station_name; ?>"  value="<?= @$preventive[0]->wt_other_station_name; ?>" class=""  placeholder="Work shop" data-errors="{filter_required:'Please select Other Workshop Name from dropdown list'}" TABINDEX="8"  <?php echo $autofocus; echo $update; echo $approve;?> >

                            </div>
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

                            function showDiv(hidden_div, element)
                            {
                                var target = $('#selfield option:selected').val();
                                // alert (target);
                                if(target == "hppay_card"){
                                    $("#mt_work_shop").parent().find('input').removeClass("filter_required");
                                    $("#mt_work_shop").parent().find('input').removeClass("has_error");
                                    $("#removeclass").removeClass("filter_required");
                                     $("#removeclass").removeClass("has_error");
                                   // $("#total_cost").addClass("has_error filter_required filter_rangelength[0-3000]");
                                }else{
                                    
                                   
                                    //$("#total_cost").removeClass("filter_rangelength[0-3000]");
                                }
                                document.getElementById(hidden_div).style.display = element.value == 'vendor' ? 'block' : 'none';

                                
                            }
                        </script>

                        <style>
                            #hidden_div {
                                    display: block;
                                }
                        </style>
                        <?php //ashwini ?>
                        </div>
                    </div>
                    </div>

                    
           
</div>
<?php } ?>