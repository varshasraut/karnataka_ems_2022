<script>

    // initAutocomplete();

</script>


<div id="dublicate_id"></div>


<?php
if ($action_type == 'View' || $action_type == 'Update') {
    $view = 'disabled';
}

if ($action_type == 'View') {
    $view1 = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form" style="position: relative;">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro">
            <?php
            if ($action_type) {
                echo $action_type . ' Police Call Details';
            }
            ?></h2>


        <?php
        $caller_name = $inc_info[0]->clr_fname . "  " . $inc_info[0]->clr_lname;
        ?>

        <div class="joining_details_box">

            <div class="width100">

                    <div class="call_purpose_form_outer">
        <div class="head_outer float_left width100"><h3 class="txt_clr2 width100">MANUAL CALL</h3> </div>
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



                        <div class="width_17 lefterror float_left">
                            <div class="filed_lable float_left "><label for="station_name">Caller No<span class="md_field">*</span></label></div>
                            <div class="float_left">
                                <input id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $inc_info[0]->clr_mobile; ?>"  placeholder="Mobile No" class=" width90 float_left small half-text filter_required filter_mobile filter_minlength[9] filter_no_whitespace filter_mobile change-base-xhttp-request" data-errors="{filter_required:'Phone no should not be blank', filter_mobile:'Only numbers are allowed.', filter_minlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; echo $view1 ?> data-href="{base_url}police_calls/get_police_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                                  
                            </div>
                        </div>
                  


                    <div id="clr_rcl">
                        <span></span>
                    </div>

                    <div class="<?php echo $cl_class; ?> float_left input">

                        <input id="first_name" type="text" name="caller[cl_firstname]" class="filter_required ucfirst"  data-errors="{filter_required:'Caller first name should not be blank',filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$inc_info[0]->clr_fname ?>" placeholder="First Name" TABINDEX="1.4"  <?php echo $view; echo $view1; ?>>

                    </div>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="middle_name" type="text" name="caller[cl_middlename]" class=" ucfirst"  data-errors="{filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?= @$inc_info[0]->clr_mname; ?>" placeholder="Middle Name" TABINDEX=1.5"  <?php echo $view; echo $view1 ?>>
                    </div> 
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="last_name" type="text" name="caller[cl_lastname]" class="float_left ucfirst"  data-errors="{filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$inc_info[0]->clr_lname; ?>" placeholder="Last Name" TABINDEX="1.6"  <?php echo $view; echo $view1 ?>>


                    </div>


                </div>
            <!--</form>-->    
        </div>
    </div>      


<div id="police_inc_call">
    <!--<form method="post" name="" id="call_dls_info">-->

        <input type="hidden"  name="caller[mc_caller_id]" value="<?= $caller['caller_id'] ?>">

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

                        <input   type="text" name="police[pc_patient_count]" class="filter_required" placholder=" Patient Count" data-errors="{filter_required:'Patient Count should not be blank'}" value="<?= @$inc_info[0]->pc_patient_count; ?>" TABINDEX="1"  <?php
                        echo $view;
                        if (@$update) {
                            echo"disabled";
                        }
                        ?>  <?php echo $view; echo $view1 ?> >

                    </div>
                </div> 


                <div class="width33 float_left">   
                    <div class=" blue float_left width_40">Police Chief Complaint<span class="md_field">*</span></div>
                    <div class="input  top_left float_left width50" >
                        <input type="text" name="police[pc_police_chief_complaint]" id="chief_complete" data-value="<?= @$inc_info[0]->po_ct_name; ?>" value="<?= @$inc_info[0]->pc_police_chief_complaint; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_police_chief_complete"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select Police chief complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>   <?php echo $view; echo $view1 ?>>
                    </div>
                </div>

                <div class="width33 float_left">   
                    <div class="field_lable float_left width_40"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                    <div class="input  top_left float_left width50" >
                        <input type="text" name="police[pc_standard_remark]" id="standard_remark" data-value="<?= @$inc_info[0]->remarks; ?>" value="<?= @$inc_info[0]->pc_standard_remark; ?>" class="mi_autocomplete"  data-href="{base_url}auto/get_pda_remarks"  placeholder="Standard Remarks" data-errors="{filter_required:'Please select standard remark from dropdown list'}" TABINDEX="8" <?php echo $autofocus; ?> data-callback-funct="police_cheif_complaint_filter"  <?php echo $view; echo $view1 ?>>
                    </div>
                </div>

            </div>
            <div class="width100 float_left">
                <div class="field_lable float_left width_8"> <div class=" blue float_left">Remark</div></div>

                <div class="width87 float_left">
                    <textarea style="height:40px;" name="police[pc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php echo $view; echo $view1 ?>><?= @$inc_info[0]->remarks; ?></textarea>
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


                    <input name="hp_add" value="<?= @$inc_info[0]->mc_inc_address; ?>" <?php echo $view; echo $view1; ?> id="pac-input" class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="hp_dtl" data-auto="hp_auto_addr" data-errors="{filter_required:'Address should not be blank.'}"> 

                </div>
            </div>

        </div>

        <div class="width33 float_left">


            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"><label for="state">State<span class="md_field">*</span></label></div>


                <div id="hp_dtl_state" class="float_left width50">


                    <?php
                    $st = array('st_code' => $inc_info[0]->mc_state_code, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view1);

                    echo get_state($st);
                    ?>




                </div>



            </div>






            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"><label for="landmark">Landmark</label></div>

                <div class="filed_input float_left width50" id="hp_dtl_lmark">

                    <input name="hp_dtl_lmark" value="<?= @$inc_info[0]->mc_dtl_lmark ?>" <?php echo $view; echo $view1; ?> class="auto_lmark" data-base="" type="text" placeholder="Landmark" TABINDEX="12">

                </div>
            </div>
            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"> <label for="area">Area/Locality</label></div>

                <div class="filed_input float_left width50" id="hp_dtl_area">


                    <input name="hp_dtl_area" value="<?= @$inc_info[0]->mc_dtl_area ?>" <?php echo $view;  echo $view1; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

                </div>

            </div>




        </div>

        <div class="width33 float_left">

            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"><label for="district">District<span class="md_field">*</span></label></div>                           

                <div id="hp_dtl_dist" class="float_left width50">


                    <?php
                    $dt = array('dst_code' => $inc_info[0]->mc_district_code, 'st_code' => @$inc_info[0]->mc_state_code, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view1);

                    echo get_district($dt);
                    ?>




                </div>

            </div>



            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"> <label for="landmark">Lane</label></div>

                <div class="filed_input float_left width50">

                    <input name="hp_dtl_lane" value="<?= @$inc_info[0]->mc_dtl_lane ?>" <?php echo $view; ?> <?php echo $view1; ?> class="auto_lane"  type="text" placeholder="Lane/Street" TABINDEX="14">

                </div>
            </div>

            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"> <label for="pincode">Pincode</label></div>

                <div class="filed_input float_left width50" id="hp_dtl_pcode">


                    <input name="hp_dtl_pincode" value="<?= @$inc_info[0]->mc_dtl_pincode; ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15" <?php echo $view; ?> <?php echo $view1; ?>>

                </div>
            </div>


        </div>
        <div class="width33 float_left ">

            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"><label for="cty_name">Enter City<span class="md_field">*</span></label></div>

                <div id="hp_dtl_city" class="float_left width50">      

                    <?php
                    $ct = array('cty_id' => @$inc_info[0]->mc_dtl_ms_city, 'dst_code' => @$inc_info[0]->mc_district_code, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view1);
                    echo get_city($ct);
                    ?>





                </div>

            </div>
            <div class="field_row float_left width1">

                <div class="field_lable float_left width_25"> <label for="house_no">House No</label></div>

                <div class="filed_input float_left width50">
                    <input id="landmark" type="text" name="hp_dtl_hno" class="" value="<?= @$inc_info[0]->mc_dtl_hno ?>"<?php echo $view; ?> TABINDEX="14" placeholder="House No" id="hp_hno"  <?php echo $view1; ?>>
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
                        if ($inc_info[0]->pc_state_code != '') {
                            $st = array('st_code' => @$inc_info[0]->pc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
                        if (@$inc_info[0]->pc_state_code != '') {
                            $dt = array('dst_code' => @$inc_info[0]->pc_district_code, 'st_code' => @$fuel_data[0]->pc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                        } else {
                            $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                        }

                        echo get_district_police($dt);
                        ?>
                    </div>
                </div>
            </div>
<!--             <div class="width33 float_left">
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
                        if (@$inc_info[0]->pc_state_code != '') {
                            $dt = array('dst_code' => @$inc_info[0]->pc_district_code, 'st_code' => @$inc_info[0]->pc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled','ps_id'=>@$inc_info[0]->pc_police_station_id);
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

                    <input   type="text" name="police[pc_call_receiver_name]" class="filter_required" placholder="Call Receiver Name" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$inc_info[0]->pc_call_receiver_name ?>" TABINDEX="1"  <?php
                    echo $view;  echo $view1;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?> >

                </div>
            </div>  
            <div class="width33 float_left">

                <div class="field_lable float_left width_25"> <label for="mobile_no"> Mobile No</label></div>


             
                
                
                    <div class="filed_input float_left width50">
                    <input type="text" name="police[pc_mobile_no]" class="width90 float_left filter_required"  data-errors="{filter_required:'Mobile number should not be blank',filter_no_whitespace:'No spaces allowed', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.'}" value="<?= @$inc_info[0]->pc_mobile_no ?>" TABINDEX="10"  <?php echo $view; echo $view1; ?> id="pc_mobile_no">   
                        <!--<input type="text" name="police[pc_mobile_no]" class="width90 float_left filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>   -->
                       
                    </div>
            </div>

            <div class="width33 float_left">

                <div class="field_lable float_left width_25"> <label for="mobile_no"> Assign Time<span class="md_field">*</span></label></div>


                <div class="filed_input float_left width50">


                    <input name="pc_assign_time" id="pc_assign_time" tabindex="20" class="form_input mi_cur_timecalender filter_required" placeholder="Assign Time" type="text"  data-errors="{filter_required:'Assign Time should not be blank!'}" value="<?= @$inc_info[0]->pc_assign_time; ?>"  <?php echo $update; ?>  <?php echo $view; echo $view1; ?> >
                </div>
            </div>
           <div class="width100 float_left" >
      
<!--    <div class="width33 float_left">
                    <div class="field_lable float_left width_25"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
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
                        <input type="text" name="police[pc_police_help_complaint]" id="help_complete" data-value="<?= @$inc_info[0]->po_hp_name; ?>" value="<?= @$inc_info[0]->pc_police_help_complaint; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_police_help_complete"  placeholder="Police Help Complaint" data-errors="{filter_required:'Please select Police Help Complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $view; echo $view1; ?> >
                    </div>
        </div>
        <div class="width33 float_left">
            <div class="field_lable float_left width_25"> <div class="label blue float_left">Remark</div></div>

            <div class="width50 float_left">
                <textarea style="height:40px;" name="police[pc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"  <?php echo $view; echo $view1; ?> ><?= @$inc_info[0]->pc_remark; ?></textarea>
            </div>
        </div>
        
                <div class="width33 float_left">
                    <label for="service" class="chkbox_check top_left">
                        <input type="checkbox" name="police[pc_assign_call]" class="check_input unit_checkbox filter_required" value="assign"  data-errors="{filter_required:'Assign call to police should not be blank!'}" id="service" >
                        <span class="chkbox_check_holder"></span>Assign call to police<span class="md_field">*</span>
                    </label>

                </div>
    </div>

        </div>

  
</div>  

                <?php if ($action_type == 'Update' || $inc_info[0]->pc_is_close == '1' ) { ?>
                    <div><h3 class="txt_clr2 width1 txt_pro">Police Call Information</h3></div>
                    <div class="width100 float_left">
                        <div class="filed_input float_left width33">

                            <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Date Time</label></div>


                            <div class="filed_input float_left width50">

                                <input name="police[pc_curr_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Date Time should not be blank!'}" value="<?php
                                if ($inc_info[0]->pc_curr_date_time != '0000-00-00 00:00:00') {
                                    echo $inc_info[0]->pc_curr_date_time;
                                }
                                ?>"    <?php echo $view1; ?> >
                            </div>

                            <input name="police[pc_id]" tabindex="20" type="hidden" value="  <?= $inc_info[0]->pc_id; ?>"   >

                        </div>
                        <div class="filed_input float_left width33">

                            <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                            <div class="filed_input float_left width50">

                                <select name="police[pc_curr_stand_remark]" tabindex="8" id="police_standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $view1; ?>  > 
                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                    <option value="police_reached"  <?php
                                    if ($inc_info[0]->pc_curr_stand_remark == 'police_reached') {
                                        echo "selected";
                                    }
                                    ?> >Police reached at location</option>
                                    <option value="other"  <?php
                                    if ($inc_info[0]->pc_curr_stand_remark == 'other') {
                                        echo "selected";
                                    }
                                    ?> >Other</option>


                                </select>



                            </div>
                        </div>
                        <div class="filed_input float_left width33">
                            <div id="police_remark_other_textbox">
    <?php if ($inc_info[0]->pc_cur_other_remark != '') { ?>
                                    <div class="field_lable float_left width33"><label for="address">Other Remark<span class="md_field">*</span></label></div>

                                    <div class="filed_input float_left width50" >
                                        <input type="text" name="police[pc_cur_other_remark]" value="<?= $inc_info[0]->pc_cur_other_remark; ?>" class="filter_required" placeholder="Remark" data-errors="{filter_required:'Other remark should not be blank!'}" TABINDEX="8" <?php echo $view1; ?> >
                                    </div>
    <?php }
    ?>
                            </div></div>

                    </div>

        <?php } ?>
            </div>
        </div>
<?php if ($action_type == 'Update') { ?>
            <div class="save_btn_wrapper">

                <input name="save_btn" value="Update" class="style5 form-xhttp-request" data-href="{base_url}police_calls/update_police" data-qr="" type="button" tabindex="16">




            </div>
<?php } ?>
    </div>
</form>
