<script>
if(typeof H != 'undefined'){
    init_auto_address();
}
</script>
    <form enctype="multipart/form-data" action="#" method="post" id="add_caller_details">

    <div class="call_purpose_form_outer">
        <div class="head_outer float_left width100"><h4 class="txt_clr2 width100">MANUAL CALL</h4> </div>
        <div class="single_record float_left width100"> 
            <div class="single_record_back">
                <div >Caller Details</div>
            </div>
        </div>
        <?php
        $view = "";


        $CI = EMS_Controller::get_instance();
        ?>
        <script>jQuery("#call_purpose").focus();</script>
        <div class="caller_details" id="caller_details">
            <!--<form enctype="multipart/form-data" action="#" method="post" id="add_caller_details">-->
                <div >
                    <?php
                    if (!isset($emt_details)) {
                        $cl_class = "width_11";
                    } else {

                        $cl_class = "width_16";
                    }
                    ?>

                    <div class="width100">


                    </div>


                    <?php if ($m_no == '') { ?>
                        <div class="width_17 lefterror float_left">
                            <div class="filed_lable float_left "><label for="station_name">Caller No<span class="md_field">*</span></label></div>
                            <div class="float_left">
                                <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>"  placeholder="Mobile No" class="width90 float_left small half-text filter_required filter_mobile filter_minlength[8] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}fire_calls/get_fire_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                                <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="width_17 lefterror float_left">
                            <div class="filed_lable float_left "><label for="station_name">Caller No<span class="md_field">*</span></label></div>
                            <div class="float_left">
                                <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>"  placeholder="Mobile No" class="width90 float_left small half-text filter_required filter_mobile filter_minlength[9] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}fire_calls/get_fire_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                                <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                            </div>
                        </div>
                    <?php } ?>


                    <div id="clr_rcl">
                        <span></span>
                    </div>

                    <?php if (!isset($emt_details)) { ?>


                        <div class="width_16 float_left input" id="caller_relation_div">
                            <div class="filed_lable float_left "><label for="station_name">Relation<span class="md_field">*</span></label></div>
                            <div class="float_left">
                                <select id="caller_relation" name="caller[cl_relation]" class="filter_required" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no"  data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                    <option value="">Select Relation</option>   
                                    <?php echo get_relation(); ?>
                                </select>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="<?php echo $cl_class; ?> float_left input">

                        <input id="first_name" type="text" name="caller[cl_firstname]" class=" ucfirst filter_required"  data-errors="{ filter_required:'Caller first name should not be blank',filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_fname ?>" placeholder="First Name" TABINDEX="1.4" >

                    </div>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="middle_name" type="text" name="caller[cl_middlename]" class=" ucfirst"  data-errors="{filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_mname ?>" placeholder="Middle Name" TABINDEX=1.5">
                    </div> 
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="last_name" type="text" name="caller[cl_lastname]" class="float_left ucfirst"  data-errors="{filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_lname ?>" placeholder="Last Name" TABINDEX="1.6" >

                        <input type="hidden" id="hidden_caller_id" name="caller[caller_id]" value="<?= @$caller_details->clr_id ?>" data-base="caller[cl_purpose]">
                        <input type="hidden" id="caller_call_id" name="caller[call_id]" value="<?= @$caller_details->cl_id ?>" data-base="caller[cl_purpose]">
                        <input type="button" id="caller_details_form" name="submit" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}fire_calls/save_call_details" class="form-xhttp-request" data-base="caller[cl_purpose]" style="visibility:hidden;">
                        <a id="submit_call" class="hide form-xhttp-request float_left" data-href="{base_url}fire_calls/save_call_details" data-qr="output_position=content&module_name=calls&showprocess=no"></a>
                    </div>

                    <div  id="dis_timer_clock" class="<?php // echo $cl_class;      ?> width_17  float_left input">
                        <input type='text' id="timer_clock" value="" readonly="readonly" name="incient[dispatch_time]"/>

                        <div class="float_right input">

                            <div id="cur_date_time_clock"> <?php echo date('d-m-Y H:i:s', strtotime($attend_call_time)); ?></div>
                            <input type="hidden" name="caller[attend_call_time]" value="<?php echo $attend_call_time; ?>">
                        </div>
                    </div>
                </div>
            <!--</form>-->    
        </div>
    </div>      
</div>
<div id="fire_incident_calls">
    <!--<form method="post" name="" id="call_dls_info">-->
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

                        <input   type="text" name="fire[fc_patient_count]" class="filter_required" placholder=" Patient Count" data-errors="{filter_required:'Patient Count should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
                        echo $view;
                        if (@$update) {
                            echo"disabled";
                        }
                        ?> >

                    </div>
                </div> 
                <div class="width33 float_left">   
                    <div class=" blue float_left width_25">Fire Chief Complaint<span class="md_field">*</span></div>
                    <div class="input  top_left float_left width50" >
                        <input type="text" name="fire[fc_fire_chief_complaint]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_fire_chief_complete"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select Police chief complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>>
                    </div>
                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width_25"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <select name="fire[fc_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                            <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                            <option value="fire_call_register"  <?php
                            if ($fuel_data[0]->ff_standard_remark == 'fire_call_register') {
                                echo "selected";
                            }
                            ?>  > Fire Call Register </option>


                        </select>
                    </div>
                </div>
            </div>
            <div class="width100 float_left">
                <div class="field_lable float_left width_8"> <div class=" blue float_left">Remark</div></div>

                <div class="width87 float_left">
                    <textarea style="height:40px;" name="fire[fc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
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


        <div class="single_record float_left width100"> 
            <div class="single_record_back">
                <div >Fire Station</div>
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


                        echo get_fire_state($st);
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

                        echo get_district_fire($dt);
                        ?>
                    </div>
                </div>
            </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width_25"><label for="tahsil">Tehsil</label></div>
                    <div class="filed_input float_left width50"> <div id="incient_tahsil">
                            <?php
                                $st = array('st_code' => '','dst_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                          
                            echo get_tahshil($st); ?>
                        </div>
                    </div>
                </div>

            <div class="width33 float_left">    
                <div class="field_lable float_left width_25"><label for="police_station">Fire Station <span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                    <div id="incient_police">
                        <?php
                        if (@$fuel_data[0]->ff_state_code != '') {
                            $dt = array('dst_code' => @$fuel_data[0]->ff_district_code, 'st_code' => @$fuel_data[0]->ff_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                        } else {
                            $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                        }

                        echo get_dis_fire_station($dt);
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

                    <input   type="text" name="fire[fc_call_receiver_name]" class="filter_required filter_word" placholder="Call Receiver Name" data-errors="{filter_required:'Call Receiver Name should not be blank',filter_word:'Call Receiver Name should be valid'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?> >

                </div>
            </div>  
            <div class="width33 float_left">

                <div class="field_lable float_left width_25"> <label for="mobile_no"> Mobile No</label></div>


                <div class="filed_input float_left width50">
                <input type="text" name="fire[fc_mobile_no]" class="width90 float_left  filter_no_whitespace"  data-errors="{ filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                    <!--<input type="text" name="fire[fc_mobile_no]" class="width90 float_left filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>-->
                     <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                </div>
            </div>

            <div class="width33 float_left">

                <div class="field_lable float_left width_25"> <label for="mobile_no"> Assign Time<span class="md_field">*</span></label></div>


                <div class="filed_input float_left width50">


                    <input name="fire[fc_assign_time]" tabindex="20" class="form_input mi_cur_timecalender filter_required" placeholder="Assign Time" type="text"  data-errors="{filter_required:'Assign Time should not be blank!'}" value="<?= @$fuel_data[0]->ff_fuel_date_time; ?>"  <?php echo $update; ?> >
                </div>
            </div>
            <div class="width100 float_left" >
          

                <div class="width33 float_left">
                    <div class="field_lable float_left width_25"> <div class="label blue float_left">Remark</div></div>

                    <div class="width50 float_left">
                        <textarea style="height:40px;" name="fire[fc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                    </div>
                </div>

                <div class="width33 float_left">
                    <label for="service" class="chkbox_check top_left">
                        <input type="checkbox" name="fire[fc_assign_call]" class="check_input unit_checkbox filter_required" value="assign"  data-errors="{filter_required:'Assign call to fire should not be blank!'}" id="service" > 
                        <span class="chkbox_check_holder"></span>Assign call to police<span class="md_field">*</span>
                    </label>

                </div>

            </div>

            <div class="save_btn_wrapper">
                <input  value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}fire_calls/save_manual_fire" data-qr="" type="button" tabindex="16">
              
            </div>

        </div>
</div>
</form>


<?php

$current_time = time();
?>
<script>
    $AVAYA_INCOMING_CALL_FLAG = 0;
    StopTimerFunction();

    clock_timer('timer_clock', '<?php echo $current_time; ?>', '<?php echo $current_time; ?>')


</script>
