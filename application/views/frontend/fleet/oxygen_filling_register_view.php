<script>

    //init_auto_address();

</script>


<div id="dublicate_id"></div>

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
                                
                <div class="field_row width100">

                    <div class="width100 float_left">
                        <div class="field_lable float_left width_20"><label for="district">Oxygen Filling Type<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width33"> 
                           <label for="ques_yes" class="radio_check width100 float_left">
                     <input id="ques_yes" type="radio" name="oxygen[oxygen_filling_case]" class="radio_check_input filter_either_or[ques_yes,ques_no]" value="oxygen_filling_during_case" data-errors="{filter_either_or:'Oxygen Filling Type is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($oxygen_data[0]->oxygen_filling_case == "oxygen_filling_during_case"){ echo "checked";}?>>
                     <span class="radio_check_holder" ></span>Oxygen Filling during case
                </label>

                        </div>

                        <div class="filed_input float_left width33"> 
                            <label for="ques_no" class="radio_check width100 float_left">
                     <input id="ques_no" type="radio" name="oxygen[oxygen_filling_case]" class="radio_check_input filter_either_or[ques_yes,ques_no]" value="oxygen_filling_without_case" data-errors="{filter_either_or:'Oxygen Filling Type is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($oxygen_data[0]->oxygen_filling_case == "oxygen_filling_without_case"){ echo "checked";}?>>
                     <span class="radio_check_holder" ></span>Oxygen Filling without Case
                            </label>

                        </div>

                    </div>
                </div>
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


                                echo get_state_oxygen_ambulance($st);
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

                                echo get_district_acc_amb($dt);
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
                                if (@$oxygen_data[0]->of_amb_ref_no != '') {
                                    $dt = array('dst_code' => @$oxygen_data[0]->of_district_code, 'st_code' => @$oxygen_data[0]->of_state_code, 'amb_ref_no' => @$oxygen_data[0]->of_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                                    echo get_update_oxy_feel_ambulance($dt);
                                } else {
                                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                    echo get_clo_comp_ambulance($dt);
                                }
                                ?>

                            </div>

                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="oxygen[of_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$oxygen_data[0]->of_base_location; ?>" readonly="readonly"   <?php echo $update; ?>>

                        </div>


                    </div>
                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></label></div>

                            <div class="filed_input float_left width50">
                                <select name="oxygen[of_shift_type]" tabindex="8" id="supervisor_list" class="filter_required" data-errors="{filter_required:'Supervisor Name should not be blank!'}"  <?php echo $update; ?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                                    <?php echo get_shift_type(@$oxygen_data[0]->of_shift_type); ?>
                                </select>

                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mobile_no">Oxygen station<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="oxygen[of_oxygen_station]" class="mi_autocomplete filter_required" data-errors="{filter_required:'Oxygen station should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_all_oxygen_station?emt=true" data-value="<?= @$oxygen_data[0]->os_oxygen_name; ?>" value="<?= @$oxygen_data[0]->os_oxygen_name; ?>" type="text" tabindex="1" placeholder="Oxygen station" data-callback-funct="" <?php echo $update; ?>>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Pilot Id<span class="md_field">*</span></label></label></div>

                        <div class="filed_input float_left width50">

                            <input name="oxygen[of_pilot_id]" class="mi_autocomplete filter_required" data-errors="{filter_required:'Pilot Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$oxygen_data[0]->of_pilot_id; ?>" value="<?= @$oxygen_data[0]->of_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name<span class="md_field">*</span></label></label></div>


                        <div class="filed_input float_left width50" id="show_pilot_id">
                            <input data-base="<?= @$preventive[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="oxygen[of_pilot_name]" class="filter_required"  data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$oxygen_data[0]->of_pilot_name; ?>" TABINDEX="10"    <?php echo $update; ?>>
                        </div>
                    </div>
                </div>

                <div class="field_row width100">


                    <div class="width2 float_left" id='fuel_address'>
                        <div class="field_lable float_left width33"> <label for="mobile_no">Cylinder Type<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <select name="oxygen[of_cylinder_type]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Cylinder Type should not be blank!'}"  <?php echo $update; ?> > 
                                <option value="" <?php echo $disabled; ?>>Select Cylinder Type</option>
                                <option value="D"  <?php
                                if (@$oxygen_data[0]->of_cylinder_type == 'D') {
                                    echo "selected";
                                }
                                 ?>  >D</option>
                                <!-- // <option value="B"  <?php 
                                // if (@$oxygen_data[0]->of_cylinder_type == 'B') {
                                //     echo "selected";
                                // }
                                //?>>
                                 //B</option> -->
                                <option value="portable"  <?php
                                if (@$oxygen_data[0]->of_cylinder_type == 'portable') {
                                    echo "selected";
                                }
                                ?>>Portable</option>
                                <option value="all_D_&_portable"  <?php
                                if (@$oxygen_data[0]->of_cylinder_type == 'all_D_&_portable') {
                                    echo "selected";
                                }
                                ?>>All D & Portable</option>

                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left" id='fuel_mobile_no'>
                        <div class="field_lable float_left width33"> <label for="mobile_no">Oxygen amount<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 ">
                          
                            <input name="oxygen[of_oxygen_amount]" tabindex="25" class="form_input filter_required filter_number filter_maxlength[5]" placeholder="Oxygen amount" type="text" data-base="search_btn" data-errors="{filter_required:'Oxygen amount should not be blank!',filter_number:'Enter number only',filter_maxlength:'Current Odometer at max 4 digit long.'}" value="<?= @$oxygen_data[0]->of_oxygen_amount; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">


                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="fuel_quantity">Oxygen Quantity<span class="md_field">*</span></label></div>
                       

                        <div class="filed_input float_left width50">
<!--                            <input name="oxygen[of_oxygen_quantity]" tabindex="25" class="form_input filter_required" placeholder="Oxygen Quantity" type="text" data-base="search_btn" data-errors="{filter_required:'Oxygen Quantity should not be blank!'}" value="<?= @$oxygen_data[0]->of_oxygen_quantity; ?>"   <?php echo $update; ?>>-->
                              <select name="oxygen[of_oxygen_quantity]" tabindex="25" class="form_input filter_required"  data-errors="{filter_required:'Oxygen Quantity should not be blank!'}" data-base="search_btn"  <?php  echo $update; ?>>
                                <option value="" <?php echo $disabled; ?>>Select Quantity</option>
                                <option value="1" <?php if ($oxygen_data[0]->of_oxygen_quantity == "1") {
                                            echo "selected";
                                        } ?>>1</option>
                                <option value="2" <?php if ($oxygen_data[0]->of_oxygen_quantity == "2") {
                                            echo "selected";
                                        } ?>>2</option>
                                         <option value="3" <?php if ($oxygen_data[0]->of_oxygen_quantity == "3") {
                                            echo "selected";
                                        } ?>>3</option>
                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="voucher_no">Filling date<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="oxygen[of_filling_date]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Filling date" type="text"  data-errors="{filter_required:'Filling date should not be blank!'}" value="<?= @$oxygen_data[0]->of_filling_date; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>
                   

                </div>

                <div class="field_row width100" id="maintance_previous_odometer">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="previous_odometer">Oxygen Filling Previous Odometer<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  >
                            <input name="oxygen[of_oxygen_previous_odometer]" tabindex="25" class="form_input filter_required filter_maxlength[8]" placeholder="Previous Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Previous Odometer should not be blank!',filter_maxlength:'Previous Odometer at max 7 digit long.'}" value="<?= @$oxygen_data[0]->of_oxygen_previous_odometer; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="previous_odometer">Last Updated Odometer<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50 "  >
                            <input name="oxygen[of_prevoius_odometer]" tabindex="25" class="form_input filter_required filter_maxlength[8]" placeholder="Previous Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Previous Odometer should not be blank!',filter_maxlength:'Previous Odometer at max 7 digit long.'}" value="<?= @$oxygen_data[0]->of_prevoius_odometer; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mobile_no">Current Odometer<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="oxygen[of_in_odometer]" tabindex="25" class="form_input filter_required filter_maxlength[8]" placeholder="In Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Current Odometer should not be blank!',filter_maxlength:'Current Odometer at max 7 digit long.'}" value="<?= @$oxygen_data[0]->of_in_odometer; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>

                </div>
                <div class="field_row width100">




                    <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">Card Expiry Date</label></div>
                        <div class="width50 float_left">

                            <input name="oxygen[of_card_date]" tabindex="20" class="form_input monthYearPicker" placeholder="Card Date" type="text"  data-errors="{filter_required:'Card Date should not be blank!'}" value="<?= @$oxygen_data[0]->of_card_date; ?>"  <?php echo $update; ?>>

                        </div>
                    </div> -->
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="payment_mode">Payment Mode<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <select name="oxygen[of_payment_mode]" tabindex="8"  class="form_input filter_required" data-errors="{filter_required:'Payment Mode should not be blank!'}"  <?php echo $update; ?> > 
                                <option value="" <?php echo $disabled; ?>>Select Payment Mode</option>
                                <!-- <option value="free_card"  <?php
                                        if (@$oxygen_data[0]->of_payment_mode == 'free_card') {
                                            echo "selected";
                                        }
                                ?>  >Fleet card</option> -->
                                <option value="voucher"  <?php
                                        if (@$oxygen_data[0]->of_payment_mode == 'voucher') {
                                            echo "selected";
                                        }
                                ?>>Voucher</option>

                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="voucher_no">Voucher No<span class="md_field"></span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="oxygen[of_voucher_no]" tabindex="20" class="form_input" placeholder="Voucher No" type="text"  data-errors="{filter_required:'Filling date should not be blank!'}" value="<?= @$oxygen_data[0]->of_voucher_no; ?>"   <?php echo $update; ?>>
                        </div>
                    </div>


                </div>

                <div class="field_row width100">





                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="name">District Manager<span class="md_field">*</span></label></label></div>
                        <div class="filed_input float_left width50">
                        <input name="oxygen[of_dist_manager]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-DM" data-value="<?=@$oxygen_data[0]->clg_first_name." ".@$oxygen_data[0]->clg_last_name; ?>" value="<?= @$oxygen_data[0]->clg_first_name." ".@$oxygen_data[0]->clg_last_name; ?>" type="text" tabindex="1" placeholder="District Manager" data-errors="{filter_required:'District Manager Name should not be blank!'}" <?php echo $disabled; ?> data-qr='clg_group=UG-DIS-FILD-MANAGER&amp;output_position=content' <?php echo $update; ?>>
                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <select name="oxygen[of_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="ambulance_oxygen_filling"  <?php
                                        if (@$oxygen_data[0]->of_standard_remark == 'ambulance_oxygen_filling') {
                                            echo "selected";
                                        }
                                ?> >Ambulance Oxygen Filling </option>
                                <option value="other"  <?php
                                        if (@$oxygen_data[0]->of_standard_remark == 'other') {
                                            echo "selected";
                                        }
                                ?>>other</option> 

                            </select>
                        </div>

                    </div>





                    <div class="width2 float_left">
                        <div id="remark_other_textbox">
                        </div>
                    </div>

                </div>
                <div class="field_row width100" id="oxygen_filling_during_case">
                    <?php if($oxygen_data[0]->of_case_type_remark == "oxygen_filling_during_case"){ ?>
                    <div class="field_lable float_left width33"><label for="end_odometer">Oxygen Filling Type Remark<span class="md_field">*</span></label></div>
                    <div class="width2 float_left" >
                        
                       <textarea style="height:60px;" name="oxygen[of_case_type_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php if ($oxygen_data[0]->of_case_type_remark != '') { echo "disabled";} ?>> <?= @$oxygen_data[0]->of_case_type_remark; ?></textarea>
                        
                    </div>
                    <?php } ?>
                </div>



<?php
if ($update) {
    $previous_odo = @$oxygen_data[0]->of_prevoius_odometer;
    ?>  
                    <div class="field_row width100  fleet" ><div class="single_record_back">Current Info</div></div>

                    <input type="hidden" name="previos_odometer" value="<?= @$oxygen_data[0]->of_prevoius_odometer; ?>">
                    <input type="hidden" name="maintaince_ambulance" value="<?= @$oxygen_data[0]->of_amb_ref_no; ?>">

                    <div class="field_row width100">
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"><label for="end_odometer">End Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" name="mt_end_odometer" value="<?= @$oxygen_data[0]->of_end_odometer; ?>" class="filter_required filter_valuegreaterthan[<?php echo $previous_odo; ?>]" placeholder="End Odometer" data-errors="{filter_required:'End Odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'END Odometer should <?php echo $previous_odometer; ?>'}" TABINDEX="8" <?php
                                       if (@$oxygen_data[0]->of_end_odometer != '') {
                                           echo "disabled";
                                       }
                                       ?>>


                            </div>
                        </div>
                        <div class="width2 float_left">

                            <div class="field_lable float_left width33"><label for="mt_onroad_datetime"> Date/Time<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" name="oxygen[of_on_road_ambulance]"  value=" <?php
                                       if (@$oxygen_data[0]->of_on_road_ambulance != '0000-00-00 00:00:00' && @$oxygen_data[0]->ff_on_road_ambulance != '') {
                                           echo @$oxygen_data[0]->of_on_road_ambulance;
                                       }
                                       ?>" class="filter_required mi_timecalender" placeholder="On-Road Date/Time" data-errors="{filter_required:'On-Road Date/Time should not be blank'}" TABINDEX="8" <?php
                                    if (@$oxygen_data[0]->of_on_road_ambulance != '0000-00-00 00:00:00' && @$oxygen_data[0]->of_on_road_ambulance != '') {
                                        echo "disabled";
                                    }
                                    ?>>



                            </div>
                        </div>
                    </div>
                    <div class="field_row width100">
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">
                                <select name="oxygen[mt_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  > 
                                    <option value="">Select Standard Remark</option>
                    <?php if ($update) { ?>  <option value="ambulance_oxygen_filling"  <?php
                        if (@$oxygen_data[0]->mt_on_stnd_remark == 'ambulance_oxygen_filling') {
                            echo "selected";
                        }
                        ?>>Ambulance Oxygen Filling Done</option>  <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50" >
                                <textarea style="height:60px;" name="oxygen[mt_on_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$oxygen_data[0]->mt_on_remark; ?></textarea>
                            </div>
                        </div>
                    </div>


<?php } ?>

<?php if ($update) { ?>  

                    <input type="hidden" name="oxygen[of_id]"  value="<?= @$oxygen_data[0]->of_id ?>">

<?php } ?>



                <div class="button_field_row  margin_auto float_left width100 text_align_center">
                    <div class="button_box">

                        <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/<?php if ($update) { ?>update_oxygen_filling<?php } else { ?>registration_oxygen_filling<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
<!--                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">         -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<script>
                    $(function () {
                        $('.monthYearPicker').datepicker({
                            changeMonth: true,
                            changeYear: true,
                            showButtonPanel: true,
                            dateFormat: 'MM yy'
                        }).focus(function () {
                            var thisCalendar = $(this);
                            $('.ui-datepicker-calendar').detach();
                            $('.ui-datepicker-close').click(function () {
                                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                thisCalendar.datepicker('setDate', new Date(year, month, 1));
                            });
                        });
                    });

                </script>