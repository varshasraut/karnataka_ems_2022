<script>
    //if(typeof H != 'undefined'){
    //init_auto_address();
    //}
</script>



<div id="dublicate_id"></div>

<?php
//if ($type == 'Update') {
   // $update = 'disabled';
//}

//var_dump($fuel_data);
// ?>

<form enctype="multipart/form-data" action="#" method="post">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
                                            if ($action_type) {
                                                echo $action_type;
                                            }
                                            ?></h2>


        <div class="joining_details_box">
            <?php //if ($update) {
            ?>
                <!-- <div class="field_row width100  fleet">
                    <div class="single_record_back">Previous Info</div>
                </div> -->
            <?php //} ?>


            <div class="field_row width100">

                <div class="width100 float_left">
                    <div class="field_lable float_left width_20"><label for="district">Fuel Filling Type<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width33">
                        <label for="ques_yes" class="radio_check width100 float_left">
                            <input id="ques_yes" type="radio" onClick="check()"  name="fuel[fuel_filling_case]" id="fuel[fuel_filling_case]" class="radio_check_input filter_either_or[ques_yes,ques_no]" value="fuel_filling_during_case" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key; ?>" <?php if ($fuel_data[0]->fuel_filling_case == "fuel_filling_during_case") {
                                                                                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                                                                                        } ?>>
                            <span class="radio_check_holder"></span>Fuel Filling during case
                        </label>

                    </div>

                    <div class="filed_input float_left width33">
                        <label for="ques_no" class="radio_check width100 float_left">
                            <input id="ques_no" onClick="check()" type="radio" name="fuel[fuel_filling_case]" id="fuel[fuel_filling_case]" class="radio_check_input filter_either_or[ques_yes,ques_no]" value="fuel_filling_without_case" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key; ?>" <?php if ($fuel_data[0]->fuel_filling_case == "fuel_filling_without_case") {
                                                                                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                                                                                        } ?>>
                            <span class="radio_check_holder"></span>Fuel Filling without Case
                        </label>

                    </div>

                </div> 
            </div>
        </div>
        <div class="width100">

            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <div id="ambulance_state">
                            <?php //print_r($fuel_data[0]->ff_state_code);die;
                           //if (@$fuel_data[0]->ff_state_code != '') {
                            //    $st = array('st_code' => @$fuel_data[0]->ff_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'ambulance_state');
                            //} else {
                                $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            // }
                            echo get_state_fuel_ambulance($st);
                            ?>
                        </div>

                    </div>

                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label name="fuel[ff_district_code]" for="district">District<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <div id="incient_district">
                            <?php 
                            //if (@$fuel_data[0]->ff_state_code != '') {
                               $dt = array('dst_code' => @$fuel_data[0]->ff_district_code, 'st_code' => @$fuel_data[0]->ff_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                           // } else {
                                // $dt = array('dst_code' => @$fuel_data[0]->dst_name , 'st_code' =>  @$fuel_data[0]->ff_state_code, 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            //}

                            echo get_district_fuel_amb($dt);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district" >Ambulance Number<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <!-- <div name="fuel[ff_amb_ref_no]"> -->
                        <input name="fuel[ff_amb_ref_no]"  id="fuel[ff_amb_ref_no]" tabindex="23" class="form_input filter_required" placeholder="Ambulance Number" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$fuel_data[0]->ff_amb_ref_no ;?>"  readonly="readonly"  >
                            <?php
                            
                            // if (@$fuel_data[0]->ff_state_code != '') {
                                // $dt = array('dst_code' => @$fuel_data[0]->ff_district_code,'name'=>'fuel[ff_amb_ref_no]', 'st_code' => @$fuel_data[0]->ff_state_code, 'amb_ref_no' => @$fuel_data[0]->ff_amb_ref_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');

                                // echo get_update_clo_comp_ambulance($dt);
                            // } else {
                                // $dt = array('dst_code' =>  @$fuel_data[0]->ff_amb_ref_no , 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            // }
                            // echo get_clo_comp_ambulance($dt);

                            ?>

                        <!-- </div> -->

                    </div>

                </div>

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district" >Base Location<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50" id="amb_base_location">
                        <input name="fuel[ff_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$fuel_data[0]->ff_base_location; ?>" readonly="readonly" >
                    </div>


                </div>
                <!-- <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="city">Shift Type</label></div>

                        <div class="filed_input float_left width50">
                            <select name="fuel[ff_shift_type]" tabindex="8" id="supervisor_list" class="" data-errors="{filter_required:'Shift Type Name should not be blank!'}" <?php echo $update; ?>>
                                <option value="" >Select Shift Type</option>
                                <?php echo get_shift_type(@$fuel_data[0]->ff_shift_type); ?>
                            </select>

                        </div>
                    </div>
                    <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="date_time">Fuel Filling Date / Time<span class="md_field">*</span></label></div>
                    <div class="width50 float_left">
                        <input name="fuel[ff_fuel_date_time]" tabindex="20" class="form_input mi_timecalender_month filter_required" placeholder="Fuel Filling Date / Time" type="text" data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_date_time; ?>" <?php echo $update; ?>>

                    </div>
                </div>
                </div> -->

            </div>
            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="city">Pilot Id</label></div>

                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_pilot_id]" class="mi_autocomplete" data-errors="{filter_required:'Pilot Id should not be blank!'}" data-href="<?php echo base_url(); ?>auto/get_pilot_data" data-value="<?= @$fuel_data[0]->ff_pilot_id; ?>" value="<?= @$fuel_data[0]->ff_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot Id" data-callback-funct="show_pilot_data" id="pilot_name_list" disabled>
                    </div>
                </div>
                <div class="width2 float_left">

                    <div class="field_lable float_left width33"> <label for="mobile_no">Pilot Name</label></div>


                    <div class="filed_input float_left width50" id="show_pilot_id">
                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>" placeholder="Pilot Name" type="text" name="fuel[ff_pilot_name]" class="" data-errors="{filter_required:'Pilot Name should not be blank'}" value="<?= @$fuel_data[0]->ff_pilot_name; ?>" TABINDEX="10" readonly>
                    </div>
                </div>
            </div>
            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mobile_no">EMT Id</label></div>


                    <div class="filed_input float_left width50">
                        <!-- <input type="text" name="fuel[ff_emso_id]" readonly value=" <?= @$fuel_data[0]->ff_emso_id; ?>"/> -->
                        <input name="fuel[ff_emso_id]" class="mi_autocomplete  " data-href="<?php echo base_url(); ?>auto/get_all_emso_id?emt=true" data-value="<?= @$fuel_data[0]->ff_emso_id; ?>" value="<?= @$fuel_data[0]->ff_emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_all_emso_id" id="emt_list" disabled>
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mobile_no">EMT Name</label></div>


                    <div class="filed_input float_left width50 " id="show_emso_name">
                        <!-- <input type="text" name="fuel[ff_emso_name]" readonly value=" <?= @$fuel_data[0]->ff_emso_name; ?>"/> -->
                        <input name="fuel[ff_emso_name]" tabindex="25" class="form_input" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= @$fuel_data[0]->ff_emso_name; ?>" readonly>
                        <!--                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">-->
                    </div>
                </div>

            </div>
            <div class="field_row width100">
                <?php if($fuel_data[0]->f_station_name != ''){ ?>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mobile_no">Fuel Station Name<span class="md_field"><span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <!-- <input name="fuel[ff_fuel_station]" id="fuel[ff_fuel_station]" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_all_fuel_station?emt=true" data-value="<?= @$fuel_data[0]->f_station_name; ?>"value="<?php $fuel_data[0]->ff_fuel_station; ?>" type="text" tabindex="1" placeholder="Fuel Sation Name" data-callback-funct="get_fuel_station_data"> -->
                        <input name="fuel[ff_fuel_station]" id="fuel[ff_fuel_station]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_all_fuel_station?emt=true" data-value="<?= @$fuel_data[0]->f_station_name; ?>" data-errors="{filter_required:'Fuel Sation Name should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_station; ?>" type="text" tabindex="1" placeholder="Fuel Sation Name" data-callback-funct="get_fuel_station_data">

                    </div>
                </div>
                <div class="width2 float_left" id='fuel_address'>
                    <div class="field_lable float_left width33"> 
                        <label for="mobile_no">Address1</label>
                    </div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_fuel_address]" id="fuel[ff_fuel_address]" tabindex="25" class="form_input" placeholder="Place" type="text" data-base="search_btn" data-errors="{filter_required:'Address should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_address; ?>" >
                    </div>
                   
                </div>
                <?php }else{?>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> 
                        <label for="mobile_no">Fuel Station Name<span class="md_field"><span class="md_field">*</span></label>
                    </div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_fuel_station]" id="fuel[ff_fuel_station]" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_all_fuel_station?emt=true" data-value="<?= @$fuel_data[0]->ff_fuel_station; ?>" value="<?php $fuel_data[0]->ff_fuel_station; ?>" type="text" tabindex="1" placeholder="Fuel Sation Name" data-callback-funct="get_fuel_station_data">
                    </div>
                </div>
                <div class="width2 float_left" id='fuel_address'>
                    <div class="field_lable float_left width33"> 
                        <label for="mobile_no">Address1</label>
                    </div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_other_fuel_station]" id="fuel[ff_other_fuel_station]" tabindex="25" class="form_input" placeholder="Place" type="text" data-base="search_btn" data-errors="{filter_required:'Address should not be blank!'}" value="<?= @$fuel_data[0]->ff_other_fuel_station; ?>" >
                    </div>
                   
                </div>
                <?php }?>
                <!-- <?php //if($fuel_data[0]->f_station_name != ''){ ?>
                <div class="width2 float_left" id='fuel_address'>
                    <div class="field_lable float_left width33"> <label for="mobile_no">Address1</label></div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_fuel_address]" id="fuel[ff_fuel_address]" tabindex="25" class="form_input" placeholder="Place" type="text" data-base="search_btn" data-errors="{filter_required:'Address should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_address; ?>" >
                    </div>
                </div>
                <?php //}?> -->
                <!-- <?php //if($fuel_data[0]->ff_other_fuel_station != ''){ ?>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="mobile_no">Address2<span class="md_field"><span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                    <input name="fuel[ff_other_fuel_station]" id="fuel[ff_other_fuel_station]" tabindex="25" class="form_input" placeholder="Place" type="text" data-base="search_btn" data-errors="{filter_required:'Address should not be blank!'}" value="<?= @$fuel_data[0]->ff_other_fuel_station; ?>" >
                    </div>
                </div>
                <?php// }?> -->
            </div>
            <div class="field_row width100">
                <div class="width2 float_left" id='fuel_mobile_no'>
                    <div class="field_lable float_left width33"> <label for="mobile_no">Mobile No</label></div>
                    <div class="filed_input float_left width50 ">
                        <input name="fuel[ff_fuel_mobile_no]" id="fuel[ff_fuel_mobile_no]" tabindex="25" class="form_input filter_if_not_blank filter_number" maxlength="10" onkeyup="this.value=this.value.replace(/[^\d]/,'')" pattern="[7-9]{1}[0-9]{9}" placeholder="Mobile Number" type="text" data-base="search_btn" value="<?= @$fuel_data[0]->ff_fuel_mobile_no; ?>" <?php echo $update; ?> readonly >
                    </div>
                </div>
                <div class="width2 float_left" id="KMPL">
                    <div class="field_lable float_left width33"> <label for="kmpl">KMPL<span class="md_field"></span></label></div>


                    <div class="filed_input float_left width50">
                        <input name="fuel[kmpl]" id="fuel[kmpl]" tabindex="25" class="form_input" placeholder="KMPL" id="kmpl" type="text" data-base="search_btn" data-errors="{filter_required:'KMPL should not be blank!',filter_maxlength:'KMPL at max 7 digit long.'}" value="<?= @$fuel_data[0]->kmpl; ?>" <?php echo $update; ?> readonly>
                    </div>
                </div>
                <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="fuel_quantity">Fuel Quantity<span class="md_field"></span></label></div>


                        <div class="filed_input float_left width50">
                            <input name="fuel[ff_fuel_quantity]" tabindex="25" id= "fuel" onkeyup="diff();"class="form_input filter_maxlength[6] filter_required" placeholder="Fuel Quantity" type="text" data-base="search_btn" data-errors="{filter_required:'Fuel Quantity should not be blank!',filter_maxlength:'Fuel Quantity at max 4 digit long'}" value="<?= @$fuel_data[0]->ff_fuel_quantity; ?>"   <?php echo $update; ?>>
                        </div>
                    </div> -->
            </div>
            <div class="field_row width100" id="maintance_previous_odometer">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="previous_odometer">Fuel Filling Previous Odometer<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50 ">
                        <input name="fuel[ff_fuel_previous_odometer]" id="fuel[ff_fuel_previous_odometer]" tabindex="25" onkeyup="sum();" class="form_input filter_required filter_number filter_maxlength[7]" placeholder="Previous Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Previous Odometer should not be blank!',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" value="<?= @$fuel_data[0]->ff_fuel_previous_odometer; ?>" <?php echo $update; ?> maxlength="6" readonly>
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="last_update_odometer" >Last Updated Odometer<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50 ">
                        <input name="fuel[ff_previous_odometer]" id="fuel[ff_previous_odometer]" tabindex="25" onkeyup="sum();" class="form_input filter_required filter_number filter_maxlength[7]" placeholder="Previous Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Previous Odometer should not be blank!',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" value="<?= @$fuel_data[0]->ff_previous_odometer; ?>" <?php echo $update; ?> maxlength="6" readonly>
                    </div>
                </div>
            </div>
            <div class="field_row width100" id="distance_travelled">
            <div class="width2 float_left" id="curr_odo">
                    <div class="field_lable float_left width33"> <label for="mobile_no">Current Odometer<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_current_odometer]" id="fuel[ff_current_odometer]" tabindex="25" onchange="sum();" class="form_input filter_required filter_number filter_maxlength[7]" placeholder="Current Odometer" type="text" data-base="search_btn" data-errors="{filter_required:'Current Odometer should not be blank!',filter_maxlength:'Current Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" value="<?= @$fuel_data[0]->ff_current_odometer; ?>" <?php echo $update; ?> maxlength="6">
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="distance_travelled">Distance Travelled<span class="md_field"></span></label></div>


                    <div class="filed_input float_left width50 ">
                    <input name="fuel[distance_travelled]" tabindex="25" id="distance" class="form_input" placeholder="Distance Travelled" type="text" data-base="search_btn" data-errors="{filter_required:'Distance Travelled should not be blank!',filter_maxlength:'Distance Travelled at max 7 digit long.'}" value="<?= @$fuel_data[0]->distance_travelled; ?>" <?php echo $update; ?> readonly>
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="date_time">Fuel Filling Date / Time<span class="md_field">*</span></label></div>
                    <div class="width50 float_left">
                        <input name="fuel[ff_fuel_date_time]" id="fuel[ff_fuel_date_time]" tabindex="20" class="form_input mi_timecalender_month filter_required" placeholder="Fuel Filling Date / Time" type="text" data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_date_time; ?>" <?php echo $update; ?> disabled>
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="fuel_quantity">Fuel Quantity<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_fuel_quantity]" onchange="handleChange(this);" tabindex="25" id="fuel" onkeyup="diff();" class="form_input filter_maxlength[6] filter_required" placeholder="Fuel Quantity" type="text" data-base="search_btn" data-errors="{filter_required:'Fuel Quantity should not be blank and not more than 70!',filter_maxlength:'Fuel Quantity at max 4 digit long'}" value="<?= @$fuel_data[0]->ff_fuel_quantity; ?>" <?php echo $update; ?>>
                    </div>
                </div>
                <div class="field_row width100" id="end_odo">
                    <div class="width2 float_left">
                    <?php
            //if //($update) {

                $previous_odo = $fuel_data[0]->ff_current_odometer;
            ?>
                        <div class="field_lable float_left width33"><label for="end_odometer">End Odometer</label></div>

                        <div class="filed_input float_left width50">
                        <input type="text" name="fuel[ff_end_odometer]" id="fuel[ff_end_odometer]" value="<?= @$fuel_data[0]->ff_end_odometer; ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?= @$fuel_data[0]->ff_end_odometer; ?>" placeholder="End Odometer"  TABINDEX="8" <?php if ($fuel_data[0]->ff_end_odometer != '') {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        // echo "disabled";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?>>       </div> 
            </div>
                <!-- <div class="width2 float_left" id="KMPL">
           <div class="field_lable float_left width33"> <label for="kmpl">KMPL<span class="md_field"></span></label></div>


         <div class="filed_input float_left width50">
            <input name="fuel[kmpl]" tabindex="25" class="form_input" placeholder="KMPL" id="kmpl" type="text" data-base="search_btn" data-errors="{filter_required:'KMPL should not be blank!',filter_maxlength:'KMPL at max 7 digit long.'}" value="<?= @$fuel_data[0]->kmpl; ?>"   <?php echo $update; ?>>
        </div>
   </div> -->

            </div>
            <div class="field_row width100">
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="amount">Fuel Rate<span class="md_field">*</span></label></div>
                    <div class="width50 float_left">
                        <input name="fuel[ff_rate]" id="fuel_rate" onchange="get_amt()" tabindex="20" class="filter_required" data-errors="{filter_required:'Fuel Rate should not be blank and greater than 70!'}" placeholder="Fuel Rate"  type="text" value="<?= @$fuel_data[0]->ff_rate; ?>" <?php echo $update; ?> >

                    </div>
                </div>


                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="amount">Total Amount<span class="md_field">*</span></label></div>
                    <div class="width50 float_left">
                        <input name="fuel[ff_amount]" onchange="handleChange_odo(this);" tabindex="20" id="fuel_amt" class="" maxlenght="5" placeholder="Total Amount" type="text" data-errors="{filter_required:'Total Amount should not be blank!'}" value="<?= @$fuel_data[0]->ff_amount; ?>" <?php echo $update; ?> readonly>
                    </div>
                </div>
            </div>
            <div class="field_row width100">
            </div>

            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="payment_mode">Payment Mode<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50">
                        <select name="fuel[ff_payment_mode]" tabindex="8" class="filter_required" data-errors="{filter_required:'Payment Mode should not be blank!'}" <?php echo $update; ?> disabled>
                            <option value="" <?php echo $disabled; ?>>Select Payment Mode</option>
                            <option value="fleet_card_payment" <?php if ($fuel_data[0]->ff_payment_mode == 'fleet_card_payment') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Fleet Card Payment</option>
                            <option value="voucher_payment" <?php
                                                            if ($fuel_data[0]->ff_payment_mode == 'voucher_payment') {
                                                                echo "selected";
                                                            }
                                                            ?>>Voucher Payment</option>
                            <option value="Other" <?php
                                                    if ($fuel_data[0]->ff_payment_mode == 'Other') {
                                                        echo "selected";
                                                    }
                                                    ?>>Other</option>

                        </select>
                    </div>
                </div>

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="voucher_no">Bill No</label></div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_voucher_no]" tabindex="25" class="form_input " placeholder="Bill No" type="text" data-base="search_btn" data-errors="{filter_required:'Voucher No should not be blank!'}" value="<?= @$fuel_data[0]->ff_voucher_no; ?>" <?php echo $update; ?>disabled>
                    </div>
                </div>



            </div>


            <div class="field_row width100 float_left">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="date_time">Standard Remark</label></div>
                    <div class="filed_input float_left width50">
                        <select name="fuel[ff_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $update; ?> disabled>
                            <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                            <option value="ambulance_fuel_filling" <?php
                                                                    if ($fuel_data) {
                                                                        if ($fuel_data[0]->ff_standard_remark == 'ambulance_fuel_filling') {
                                                                            echo "selected";
                                                                        }
                                                                    } else {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Ambulance Fuel Filling </option>
                            <option value="other" <?php
                                                    if ($fuel_data[0]->ff_standard_remark == 'other') {
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

            <div class="field_row width100 float_left">

                <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="autority_name">Higher Authority Name<span class="md_field"></span></label></div>
                        <div class="filed_input float_left width50">
                            <select name="fuel[ff_higher_autority_name]" tabindex="8" id="higher_authority" class="" data-errors="{filter_required:'Higher Autority Name should not be blank!'}" <?php echo $update; ?> > 
                                <option value="" <?php echo $disabled; ?>>Select Higher Authority Name</option>
                                <option value="supervisor"  <?php
                                                            if ($fuel_data[0]->ff_higher_autority_name == 'supervisor') {
                                                                echo "selected";
                                                            }
                                                            ?>  >Supervisor</option>
                                <option value="dm"  <?php
                                                    if ($fuel_data[0]->ff_higher_autority_name == 'dm') {
                                                        echo "selected";
                                                    }
                                                    ?>  >DM</option>
                                <option value="zm"  <?php
                                                    if ($fuel_data[0]->ff_higher_autority_name == 'zm') {
                                                        echo "selected";
                                                    }
                                                    ?>  >ZM</option>
                                <option value="other"  <?php
                                                        if ($fuel_data[0]->dt_standard_remark == 'other') {
                                                            echo "selected";
                                                        }
                                                        ?>>other</option> 

                            </select>
                        </div>
                    </div> -->



                <!-- <div class="width2 float_left">
                    <div class="field_lable float_left width33"> <label for="name">Name</label></div>
                    <div class="filed_input float_left width50">
                        <input name="fuel[ff_authority_name]" tabindex="25" class="form_input" placeholder="Name" type="text" data-base="search_btn" data-errors="{filter_required:'Name should not be blank!'}" value="<?= @$fuel_data[0]->ff_authority_name; ?>" <?php echo $update; ?>>
                    </div>
                </div> -->

            </div>

            <div class="field_row width100">
                <div class="width2 float_left">
                    <div id="higher_authority_other_textbox">
                    </div>
                </div>

            </div>
            <div class="field_row width100" id="fuel_filling_case_type_remark">
                <?php //if ($fuel_data[0]->fuel_filling_case == "fuel_filling_during_case") { ?>
                    <div class="field_lable float_left width33"><label for="end_odometer">Fuel Filling Type Remark<span class="md_field"></span></label></div>
                    <div class="width2 float_left">

                        <textarea style="height:60px;" name="fuel[ff_case_type_remark]" id="fuel[ff_case_type_remark]"  TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'Remark should not be blank'}"> <?= @$fuel_data[0]->ff_case_type_remark; ?></textarea>

                    </div>
                <?php //} ?>
            </div>

            
                <!-- <div class="field_row width100  fleet">
                    <div class="single_record_back">Current Info</div>
                </div>

                <input type="hidden" name="previous_odometer" value="<?= @$fuel_data[0]->ff_current_odometer; ?>">
                <input type="hidden" name="maintaince_ambulance" value="<?= @$fuel_data[0]->ff_amb_ref_no; ?>">
-->
               
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!--  
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="mt_onroad_datetime">Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <input type="text" name="fuel[ff_on_road_ambulance]" value=" <?php if ($fuel_data[0]->ff_on_road_ambulance != '0000-00-00 00:00:00' && $fuel_data[0]->ff_on_road_ambulance != '') {
                                                                                                echo $fuel_data[0]->ff_on_road_ambulance;
                                                                                            } ?>" class="filter_required mi_timecalender" placeholder="On-road Date/Time" data-errors="{filter_required:'On-road Date/Time should not be blank'}" TABINDEX="8" <?php if ($fuel_data[0]->ff_on_road_ambulance != '0000-00-00 00:00:00' && $fuel_data[0]->ff_on_road_ambulance != '') {
                                                                                                                                                                                                                                                                    echo "disabled";
                                                                                                                                                                                                                                                                } ?>>



                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <select name="fuel[mt_on_stnd_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php //if ($fuel_data[0]->mt_on_stnd_remark != '') {
                                                                                                                                                                                    //echo "disabled";
                                                                                                                                                                                //} ?>>
                                <option value="">Select Standard Remark</option>
                                <?php //if ($update) { ?> <option value="ambulance_fuel_fill_done" <?php
                                                                                                    if (@$fuel_data[0]->mt_on_stnd_remark == 'ambulance_fuel_fill_done') {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                    ?>>Ambulance Fuel Filling Done</option> <?php //} ?>
                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="mt_on_remark">Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <textarea style="height:60px;" name="fuel[mt_on_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'Remark should not be blank'}" <?php if ($fuel_data[0]->mt_on_remark != '') {
                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                            } ?>><?= @$fuel_data[0]->mt_on_remark; ?></textarea>
                        </div>
                    </div>
                </div>
 -->

            <?php //} ?>

            <?php //if ($type == 'Update') { ?>

                <input type="hidden" name="fuel[ff_gen_id]" id="fuel[ff_gen_id]" value="<?= @$fuel_data[0]->ff_gen_id ?>">

            <?php// } ?>

                <input type="hidden" name="fuel[ff_id]" id="ud_clg_id" value="<?= @$fuel_data[0]->ff_id ?>">

            <?php //if (@$fuel_data[0]->is_updated != '1') { ?>

                <div class="button_field_row  margin_auto float_left width100 text_align_center">
                    <div class="button_box">

                        <!-- <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/modify_fuel_filling'  TABINDEX="23">
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24"> -->
                        <input type="button" name="submit" value="Update" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>fleet/modify_fuel_filling'  TABINDEX="23">
                    </div>
                </div>
            <?php //}
            ?>
</form>
<script>
    function sum() {
        var txtFirstNumberValue = document.getElementById('fuel[ff_fuel_previous_odometer]').value;
        var txtSecondNumberValue = document.getElementById('fuel[ff_current_odometer]').value;
        var lastupdateodo = document.getElementById('fuel[ff_previous_odometer]').value;
        if(((parseInt(txtFirstNumberValue) < parseInt(txtSecondNumberValue)) || (parseInt(txtFirstNumberValue) == parseInt(txtSecondNumberValue))) && ((parseInt(lastupdateodo) < parseInt(txtSecondNumberValue)) || (parseInt(txtFirstNumberValue) == parseInt(lastupdateodo)))){
            var result = parseInt(txtSecondNumberValue) - parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('distance').value = result;
            }
        }else{
            alert("Current Odometer should be greater than Previous Odometer and Last Updated odometer.")
            document.getElementById('fuel[ff_current_odometer]').value = '';
        }
    }
    function check() {
            if (document.getElementById('ques_yes').checked) {
            document.getElementById('end_odo').style.display = 'none';
            document.getElementById('fuel[ff_end_odometer]').disabled = true;
            document.getElementById('fuel_filling_case_type_remark').style.display = 'block';
            }
            else {
                document.getElementById('end_odo').style.display = 'block';   
                document.getElementById('fuel[ff_end_odometer]').disabled = false;
                document.getElementById('fuel_filling_case_type_remark').style.display = 'none';   
        }
    }
    function diff() {
        var txtFirstNumberValue = document.getElementById('distance').value;
        var txtSecondNumberValue = document.getElementById('fuel').value;
        var result = (txtFirstNumberValue) / (txtSecondNumberValue);
        // var res = result.tofixed(2);
        if (!isNaN(result)) {
            // alert(res);
            //var res= Math.round( result,2);
            var res = Math.round(result * 100) / 100;
            document.getElementById('fuel[kmpl]').value = res;
            //var res= result.tofixed(2);
            //alert(res);
        }

        var qty = document.getElementById('fuel').value;
        var amt = document.getElementById('fuel_rate').value;
        var fl_amt = (qty * amt);
        var float = fl_amt.toFixed(2);
            $maxval = 7000;
        if (fl_amt > 1 && fl_amt <= $maxval) {
            document.getElementById('fuel_amt').value = float;
        } else if(fl_amt == ''|| fl_amt == '0'){
            document.getElementById('fuel_amt').value = '';
        }
        else{
            alert('Amount Should Be Less Than 7000');
            $("#fuel_amt").addClass("filter_required");
            document.getElementById('fuel_amt').value = '';
        }
    }
    function get_amt() {
        var qty = document.getElementById('fuel').value;
        var amt = document.getElementById('fuel_rate').value;

        if (amt < 70 )
        {
            // alert('Amount Should Be Proper.');
            $("#fuel_amt").addClass("filter_required");
            document.getElementById('fuel_rate').value = ''; 
        }else{
            var fl_amt = (qty * amt);
            var float = fl_amt.toFixed(2);
            $maxval = 7000;
        if (fl_amt != '' && fl_amt <= $maxval) {
            document.getElementById('fuel_amt').value = float;
        }
        else{
            alert('Amount Should Be Less Than 7000');
            $("#fuel_amt").addClass("filter_required");
            document.getElementById('fuel_amt').value = '';
        }
        }
    
    };

    $('#container').on('focus', '.mi_timecalender_month', function() {

        $(this).datepicker("destroy");
        event.preventDefault();
        $(this).datetimepicker({

            changeMonth: true,
            changeYear: true,
            showAnim: 'slideDown',
            dateFormat: 'yy-mm-dd',
            timeFormat: "HH:mm:ss",
            minDate: '-1M',


        });
        $(this).datepicker("slow");

        //return false;

    });
    
    function handleChange(input) {
    // this.value = parseFloat(this.value).toFixed(2);
    if (input.value < 0) input.value = '';
    if (input.value > 70) input.value = '';
  }
  function handleChange_odo(input) {
    if (input.value < 0) input.value = '';
    if (input.value > 7000) input.value = '' ;
  }
  $(function() {
    $('#fuel_rate').on('input', function() {
        match = (/(\d{0,3})[^.]*((?:\.\d{0,2})?)/g).exec(this.value.replace(/[^\d.]/g, ''));
        this.value = match[1] + match[2];
    });
});
$(document).ready(function() {
    var station = document.querySelector('input[name="fuel[fuel_filling_case]"]:checked').value;
    // document.getElementById("fuel[fuel_filling_case]").checked;
    console.log(station);
    if(station == 'fuel_filling_during_case'){
        document.getElementById('end_odo').style.display = 'none';
        document.getElementById('fuel_filling_case_type_remark').style.display = 'block';
    }else if(station == 'fuel_filling_without_case'){
    document.getElementById('fuel_filling_case_type_remark').style.display = 'none';
    }
});
$('document').ready(function()
{
    $('#fuel[ff_case_type_remark]').each(function(){
            $(this).val($(this).val().trim());
            // $('#fuel[ff_end_odometer]').removeAttr('required')
        }
    );
});
</script>