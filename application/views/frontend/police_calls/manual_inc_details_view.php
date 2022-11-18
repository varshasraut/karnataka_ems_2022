<?php
$current_time = time();
?>
<script>
    $AVAYA_INCOMING_CALL_FLAG = 0;
    StopTimerFunction();

    clock_timer('police_timer', '<?php echo $current_time; ?>', '<?php echo $current_time; ?>')


</script>
<div class="width100 float_left">
    <div  id="add_caller_details" class="<?php // echo $cl_class;      ?> width_17  float_left input">
        <span class="strong">Timer </span>  <input type='text' id="police_timer" style="background-color: #F3F1F1;" value="" readonly="readonly" name="incient[dispatch_time]"/>
    </div>

    <div id="cur_date_time_clock"> <span class="strong">Date & Time </span>  <?php echo date('d-m-Y H:i:s'); ?></div>

</div>
<!--<div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer" >-->

<div class="width100 float_left">
    <div class="head_outer"><h4 class="txt_clr2 width1 txt_pro">POLICE FORM</h4></div>



    <div class="pan_box bottom_border float_left width100">


        <div class=" float_left width100">


            <?php if (!empty($pt_info[0])) {
                ?>

                <div class="width100">
                    <div class="width100 float_left ercp">

                        <table>
                            <tr class="single_record_back">
                                <td colspan="4">Caller Information</td>
                            </tr>

                            <tr>
                                <td  valign="top" class="width_25">Caller Name</td>
                                <td  valign="top" ><?php echo ($pt_info[0]->clr_fname) ? $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname : "-"; ?></td>
                                <td  valign="top" >
                                    <div class="float_left"> <?php echo ($pt_info[0]->clr_mobile) ?></div>
                                    <div class="float_left">   <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $pt_info[0]->clr_mobile; ?>"></a></div>
                                </td>
                                <td  valign="top" ><?php echo ($pt_info[0]->clr_mobile) ?></td>
                            </tr>
                            <tr>
                                <td  valign="top" >Caller Relation</td>
                                <td  valign="top" ><?php echo get_relation_by_id($pt_info[0]->clr_ralation); ?></td>
                                <td valign="top" ></td>
                                <td valign="top" ></td>
                            </tr>
                            <tr class="single_record_back">
                                <td colspan="4">Patient Information</td>
                            </tr>
                            <tr>
                                <td  valign="top" class="width_25">patient Name</td>
                                <td  valign="top" class="width_25"><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
                                <td  valign="top" class="width_25">Age</td>
                                <td  valign="top" class="width_25"><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?></td>
                            </tr>
                            <tr>
                                <td valign="top" >Gender</td>
                                <td  valign="top" ><?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?></td>
                                <td  valign="top" >ERO  Summary</td>
                                <td  valign="top" ><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>

                            </tr>
                            <tr>
                                <td  valign="top" >ERO Standard Summary</td>
                                <td  valign="top" ><?php echo $re_name; ?></td>
                                  <td colspan="2"></td>
                            </tr>


                        </table>

                    </div>
                    <div class="width100 float_right ercp">

                        <table>
                            <tr class="single_record_back">
                                <td colspan="4">Incident Information</td>
                            </tr>
                            <tr>
                                <td  valign="top" class="width">Call Type</td>
                                <td  valign="top" class="width_25"><?php echo ucwords($pname); ?></td>
                                <td  valign="top" class="width">No Of Patients</td>
                                <td  valign="top" class="width_25"><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : '-'; ?></td>
                            </tr>

                            <tr>     <?php if (trim($pt_info[0]->inc_type) == 'mci') { ?>


                                    <td  valign="top" class="width_25">MCI Nature</td>
                                    <td  valign="top" class="width_25"><?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></td>

                                <?php } else { ?>


                                    <td  valign="top"  class="width_25">Chief Complaint Name</td>
                                    <td  valign="top" class="width_25"><?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?></td>


                                <?php } ?>
                                <td  valign="top"  class="width_25">Current Ambulance</td>
                                <td  valign="top"  class="width_25"><?php echo $pt_info[0]->amb_rto_register_no; ?></td>
                            </tr>

                            <tr>
                                <td  valign="top"  class="width_25">Ambulance base location</td>
                                <td  valign="top"  class="width_25"><?php echo ($pt_info[0]->hp_name); ?></td>
                                <td  valign="top"  class="width_25">Dispatch Date /Time</td>
                                <td  valign="top"  class="width_25"><?php echo $pt_info[0]->inc_datetime; ?></td>

                            </tr>
                            <tr>                                  
                                <td  valign="top"  class="width">Incident Id</td>
                                <td  valign="top"  class="width_25"><?php echo ($pt_info[0]->inc_ref_id); ?></td>
                                <td  valign="top" class="width_25">Incident Address</td>
                                <td  valign="top" class="width_25"><?php echo $pt_info[0]->inc_address; ?></td>
                            </tr>


                        </table>
                    </div>
                </div>


            <?php } else { ?>

                <div class="width100 text_align_center"><span> No records found. </span></div>


            <?php } ?>

        </div>

    </div>

    <div><h4 class="txt_clr2 width1 txt_pro">Current Call Details</h4></div>

    <form method="post" name="police_call_form" id="police_call_form">

        <input type="hidden" name="police[pc_pre_inc_ref_id]" value="<?php echo $pt_info[0]->inc_ref_id ?>">

        <input type="hidden" name="caller[mc_caller_id]" value="<?php echo $pt_info[0]->clr_id ?>">


        <div class="inline_fields width100">
            <div class="field_row width100">

                <div class="width33 float_left">
                    <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <div id="ambulance_state">



                            <?php
                            if ($pt_info[0]->inc_state_id != '') {
                                $st = array('st_code' => $pt_info[0]->inc_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            } else {
                                $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }


                            echo get_police_state($st);
                            ?>

                        </div>

                    </div>

                </div>
                <div class="width33 float_left">    
                    <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <div id="incient_dist">
                            <?php
                            if ($pt_info[0]->inc_state_id != '') {
                                $dt = array('dst_code' => $pt_info[0]->inc_district_id, 'st_code' => $pt_info[0]->inc_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            } else {
                                $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }

                            echo get_district_police($dt);
                            ?>
                        </div>
                    </div>
                </div>
<!--                <div class="width33 float_left">
                        <div class="field_lable float_left width_25"><label for="tahsil">Tehsil</label></div>
                        <div class="filed_input float_left width50"> <div id="incient_tahsil">
                                <?php
                                    $st = array('st_code' => '','dst_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                echo get_tahshil($st); ?>
                            </div>
                        </div>
                </div>-->
                <div class="width33 float_left">    
                    <div class="field_lable float_left width33"><label for="police_station">Police Station <span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <div id="incient_police">
                            <?php
                            if ($pt_info[0]->inc_state_id != '') {
                                $dt = array('dst_code' => $pt_info[0]->inc_district_id, 'st_code' => $pt_info[0]->inc_state_id, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
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

            <div class="field_row width100">
                <div class="width33 float_left">   
                    <div class="label blue float_left width33">Police Chief Complaint<span class="md_field">*</span></div>
                    <div class="input  top_left float_left width2" >
                        <input type="text" name="police[pc_police_chief_complaint]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_police_chief_complete"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select Police chief complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>>
                    </div>
                </div>

                <div class="width33 float_left">
                    <div class="filed_lable float_left width33"><label for="station_name">Call Receiver Name<span class="md_field">*</span></label></div>

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

                    <div class="field_lable float_left width33"> <label for="mobile_no"> Mobile No</label></div>


              
                    
                    
                    <div class="filed_input float_left width50">
                    <input type="text" name="police[pc_mobile_no]" class="width90 float_left  filter_no_whitespace"  data-errors="{ filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?> id="pc_mobile_no">   
                        <!--<input type="text" name="police[pc_mobile_no]" class="width90 float_left filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>> -->  
                        <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                    </div>
                </div>

                <div class="width33 float_left">

                    <div class="field_lable float_left width33"> <label for="mobile_no"> Assign Time<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50">
                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="pc_assign_time" class="filter_required  mi_cur_timecalender"  data-errors="{filter_required:'Assign Time should not be blank'}" value="" TABINDEX="10"  readonly="readonly" <?php echo $view; ?> id="pc_assign_time">
                    </div>
                </div>
                <!--<div class="width33 float_left">
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
                    <div class="field_lable float_left width33"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                    <input type="text" name="police[pc_standard_remark]" id="standard_remark" data-value="<?= @$std_rem['remarks']; ?>" value="<?= @$std_rem['id']; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_pda_remarks"  placeholder="Standard Remarks" data-errors="{filter_required:'Please select standard remark from dropdown list'}"TABINDEX="8" <?php echo $update; ?> data-callback-funct="police_cheif_complaint_filter">
                    </div>
                </div>
                <div class="width33 float_left">
                        <label for="service" class="chkbox_check top_left">
                            <input id="service" type="checkbox" name="police[pc_assign_call]" class="check_input unit_checkbox filter_required  "value="assign"  data-errors="{filter_required:'Assign call to police should  be checked!'}">
                            <span class="chkbox_check_holder"></span>Assign call to police<span class="md_field">*</span>
                        </label>
                </div>
                <div class="width100 float_left">
                <div class="width33 float_left">
                <div class=" blue float_left width33">Police Help Complaint<span class="md_field">*</span></div>
                    <div class="input  top_left float_left width50" >
                        <input type="text" name="police[pc_police_help_complaint]" id="help_complete" data-value="<?= @$inc_details['help_comp']; ?>" value="<?= @$inc_details['help_comp']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_police_help_complete"  placeholder="Police Help Complaint" data-errors="{filter_required:'Please select Police Help Complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>>
                    </div>
        </div>
                    <div class="width33 float_left">
                        <div class="field_lable float_left width33"> <div class="label blue float_left">Remark</div></div>

                        <div class="width2 float_left">
                            <textarea style="height:60px;" name="police[pc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>
                </div>


                <div class="save_btn_wrapper">

                    <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}police_calls/save_manual_police" data-qr="" type="button" tabindex="16">

                    <a class="click-xhttp-request ercp_dash" data-href="{base_url}ercp" data-qr="output_position=content"></a>


                </div>

                </form>

            </div>



