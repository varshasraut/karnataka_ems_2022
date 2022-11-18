<script>
    if(typeof H != 'undefined'){
        init_auto_address();
    }
</script>



   
  
  
    <div class="single_record float_left width100"> 
        <div class="single_record_back">
            <div >Incident Information</div>
        </div>
    </div>
    <div class="inline_fields width100">

        <div class="form_field width100 pos_rel">


            <div class="width33 float_left">
                <div class="filed_lable float_left width_25"><label for="station_name">Patient Count<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="police[pc_patient_count]" class="filter_required" placholder=" Patient Count" data-errors="{filter_required:'Patient Count should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?> >

                </div>
            </div> 
            <div class="width33 float_left">   
                <div class=" blue float_left width_25">Police Chief Complaint<span class="md_field">*</span></div>
                <div class="input  top_left float_left width50" >
                    <input type="text" name="police[pc_police_chief_complaint]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_police_chief_complete"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select Police chief complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>>
                </div>
            </div>

            <div class="width33 float_left">   
                    <div class="field_lable float_left width_40"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                    <div class="input  top_left float_left width50" >
                        <input type="text" name="police[pc_standard_remark]" id="standard_remark" data-value="<?= @$std_rem['id']; ?>" value="<?= @$std_rem['remarks']; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_pda_remarks"  placeholder="Standard Remarks" data-errors="{filter_required:'Please select standard remark from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?> data-callback-funct="police_cheif_complaint_filter">
                    </div>
                </div>

            <!-- <div class="width33 float_left">
                <div class="field_lable float_left width_25"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                <div class="filed_input float_left width50">
                    <select name="police[pc_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                        <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                        <option value="police_call_register"  <?php
                        if (@$police_station[0]->pc_standard_remark == 'police_call_register') {
                            echo "selected";
                        }
                        ?>  > Police Call Register </option>


                    </select>
                </div>
            </div> -->
        </div>
        <div class="width100 float_left">
            <div class="field_lable float_left width_8"> <div class=" blue float_left">Remark</div></div>

            <div class="width87 float_left">
                <textarea style="height:40px;" name="police[pc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
            </div>
        </div>
    </div>


    <div class="single_record float_left width100"> 
        <div class="single_record_back">
            <div >Incident Address</div>
        </div>
    </div>

    <div class="width100">

        <div class="field_row float_left width100">

            <div class="field_lable float_left width_8"> <label for="address">Address<span class="md_field">*</span></label></div>

            <div class="filed_input float_left width_85">


                <input name="hp_add" value="<?= @$update[0]->hp_address ?>"<?php echo $view; ?> id="pac-input" class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="hp_dtl" data-auto="hp_auto_addr" data-errors="{filter_required:'Address should not be blank.'}"> 

            </div>
        </div>

    </div>

    <div class="width33 float_left">


        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"><label for="state">State<span class="md_field">*</span></label></div>


            <div id="hp_dtl_state" class="float_left width50">


                <?php
                $st = array('st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                echo get_state($st);
                ?>




            </div>



        </div>






        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"><label for="landmark">Landmark</label></div>

            <div class="filed_input float_left width50" id="hp_dtl_lmark">

                <input name="hp_dtl_lmark" value="<?= @$update[0]->hp_lmark ?>"<?php echo $view; ?> class="auto_lmark" data-base="" type="text" placeholder="Landmark" TABINDEX="12">

            </div>
        </div>
        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"> <label for="area">Area/Locality</label></div>

            <div class="filed_input float_left width50" id="hp_dtl_area">


                <input name="hp_dtl_area" value="<?= @$update[0]->hp_area ?>"<?php echo $view; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

            </div>

        </div>




    </div>

    <div class="width33 float_left">

        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"><label for="district">District<span class="md_field">*</span></label></div>                           

            <div id="hp_dtl_dist" class="float_left width50">


                <?php
                $dt = array('dst_code' => $update[0]->hp_district, 'st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                echo get_district($dt);
                ?>




            </div>

        </div>



        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"> <label for="landmark">Lane</label></div>

            <div class="filed_input float_left width50">

                <input name="hp_dtl_lane" value="<?= @$update[0]->hp_lane_street ?>"<?php echo $view; ?> class="auto_lane"  type="text" placeholder="Lane/Street" TABINDEX="14">

            </div>
        </div>

        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"> <label for="pincode">Pincode</label></div>

            <div class="filed_input float_left width50" id="hp_dtl_pcode">


                <input name="hp_dtl_pincode" value="<?= @$update[0]->hp_pincode ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15">

            </div>
        </div>


    </div>
    <div class="width33 float_left ">

        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"><label for="cty_name">Enter City<span class="md_field">*</span></label></div>

            <div id="hp_dtl_city" class="float_left width50">      

                <?php
                $ct = array('cty_id' => $update[0]->hp_city, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);
                echo get_city($ct);
                ?>





            </div>

        </div>
        <div class="field_row float_left width1">

            <div class="field_lable float_left width_25"> <label for="house_no">House No</label></div>

            <div class="filed_input float_left width50">
                <input id="landmark" type="text" name="hp_dtl_hno" class="" value="<?= @$update[0]->hp_house_no ?>"<?php echo $view; ?> TABINDEX="14" placeholder="House No" id="hp_hno">
            </div>
        </div>

    </div>

</div>

<div class="single_record float_left width100"> 
    <div class="single_record_back">
        <div >Police Station</div>
    </div>
</div>
<div class="field_row width100">

    <div class="width33 float_left">
        <div class="field_lable float_left width_25"><label for="district">State<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50">
            <div id="ambulance_state">



                <?php
                if (@$fuel_data[0]->ff_state_code != '') {
                    $st = array('st_code' => @$fuel_data[0]->ff_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                } else {
                    $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                }


                echo get_police_state($st);
                ?>

            </div>

        </div>

    </div>
    <div class="width33 float_left">    
        <div class="field_lable float_left width_25"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
            <div id="incient_dist">
                <?php
                if (@$fuel_data[0]->ff_state_code != '') {
                    $dt = array('dst_code' => @$fuel_data[0]->ff_district_code, 'st_code' => @$fuel_data[0]->ff_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                } else {
                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                }

                echo get_district_police($dt);
                ?>
            </div>
        </div>
    </div>
<!--    <div class="width33 float_left">
        <div class="field_lable float_left width_25"><label for="tahsil">Tehsil</label></div>
        <div class="filed_input float_left width50"> <div id="incient_tahsil">
                <?php
                    $st = array('st_code' => '','dst_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');


                echo get_tahshil($st); ?>
            </div>
        </div>
    </div>-->

    <div class="width33 float_left">    
        <div class="field_lable float_left width_25"><label for="police_station">Police Station <span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
            <div id="incient_police">
                <?php
                if (@$fuel_data[0]->ff_state_code != '') {
                    $dt = array('dst_code' => @$fuel_data[0]->ff_district_code, 'st_code' => @$fuel_data[0]->ff_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                } else {
                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                }

                echo get_dis_police_station($dt);
                ?>
            </div>
        </div>
    </div>
</div>
<div id="police_station_information"></div>

<div class="width100 float_left" >


    <div class="width33 float_left">
        <div class="filed_lable float_left width_25"><label for="station_name">Call Receiver Name<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="police[pc_call_receiver_name]" class="filter_required" placholder="Call Receiver Name" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>
    </div>  
    <div class="width33 float_left">

        <div class="field_lable float_left width_25"> <label for="mobile_no"> Mobile No<span class="md_field">*</span></label></div>


<!--        <div class="filed_input float_left width50">
            <input type="text" name="police[pc_mobile_no]" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
        </div>-->
        <div class="filed_input float_left width50">
                        <input type="text" name="police[pc_mobile_no]" class="width90 float_left filter_required "  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?> id="pc_mobile_no">   
                        <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                    </div>
    </div>

  <div class="width33 float_left">

                <div class="field_lable float_left width_25"> <label for="mobile_no"> Assign Time<span class="md_field">*</span></label></div>


                <div class="filed_input float_left width50">


                    <input name="pc_assign_time" tabindex="20" class="form_input mi_cur_timecalender filter_required" placeholder="Assign Time" type="text"  data-errors="{filter_required:'Assign Time should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_date_time; ?>"  <?php echo $update; ?> id="pc_assign_time">
                </div>
            </div>
    <div class="width100 float_left" >
      
<!--    <div class="width33 float_left">
                    <div class="field_lable float_left width33"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <select name="police[pc_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                            <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                            <option value="police_call_register"  <?php
                        if ($fuel_data[0]->pc_standard_remark == 'police_call_register') {
                            echo "selected";
                        }
                            ?>  >Police Call Register</option>


                        </select>
                    </div>
                </div>-->
                <div class="width33 float_left">
                <div class=" blue float_left width33">Police Help Complaint<span class="md_field">*</span></div>
                    <div class="input  top_left float_left width50" >
                        <input type="text" name="police[pc_police_help_complaint]" id="help_complete" data-value="<?= @$inc_details['help_comp']; ?>" value="<?= @$inc_details['help_comp']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_police_help_complete"  placeholder="Police Help Complaint" data-errors="{filter_required:'Please select Police Help Complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>>
                    </div>
        </div>
        <div class="width33 float_left">
            <div class="field_lable float_left width_25"> <div class="label blue float_left">Remark</div></div>

            <div class="width50 float_left">
                <textarea style="height:40px;" name="police[pc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
            </div>
        </div>
        
                <div class="width33 float_left">
                    <label for="service" class="chkbox_check top_left">
                        <input type="checkbox" name="police[pc_assign_call]" class="check_input unit_checkbox filter_required" value="assign"  data-errors="{filter_required:'>Assign call to police should not be blank!'}" id="service" >
                        <span class="chkbox_check_holder"></span>Assign call to police<span class="md_field">*</span>
                    </label>

                </div>
    </div>
         
            

    </div>
    
  <input type="hidden"  name="caller[mc_caller_id]" value="<?= @$caller_details->clr_id?>">
  <input type="hidden" name="caller1[mc_attend_call_time]" value="<?php echo date('Y-m-d H:i:s', strtotime($attend_call_time));  ?>">
  
    <div class="save_btn_wrapper">

        <input id="caller" name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}police_calls/save_manual_police" data-qr="" type="button" tabindex="16">

        <a class="click-xhttp-request ercp_dash" data-href="{base_url}ercp" data-qr="output_position=content"></a>


    </div>

</div>
</div>
