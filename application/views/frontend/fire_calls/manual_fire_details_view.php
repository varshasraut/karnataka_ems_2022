


<div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer" >
    <div class="head_outer"><h3 class="txt_clr2 width1">FIRE FORM</h3></div>


    <div class="pan_box bottom_border float_left width100">


        <div class=" float_left width100">


            <?php if (!empty($pt_info[0])) {
                ?>

                <div class="width100">
                   
                    <div class="width50 float_left ercp">

                        <table>
                            <tr class="single_record_back">
                                <td colspan="4">Patient Information</td>
                            </tr>
                            <tr>
                                <td class="width_25 " valign="top">patient Name</td>
                                <td class="width_25" valign="top"><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
                                <td class="width_25" valign="top">Age</td>
                                <td class="width_25" valign="top"><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?></td>
                            </tr>
                            <tr>
                                <td valign="top">Gender</td>
                                <td valign="top"><?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?></td>
                                <td valign="top">ERO  Summary</td>
                                <td valign="top"><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>

                            </tr>
                            <tr>
                                <td valign="top">ERO Standard Summary</td>
                                <td valign="top"><?php echo $re_name; ?></td>
                            </tr>
                            <tr class="single_record_back">
                                <td colspan="4">Caller Information</td>
                            </tr>

                            <tr>
                                <td class="width_25" valign="top">Caller Name</td>
                                <td valign="top"><?php echo ($pt_info[0]->clr_fname) ? $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname : "-"; ?></td>
                                <td valign="top">Caller Mobile</td>
<!--                                <td><?php echo ($pt_info[0]->clr_mobile) ?></td>-->
                                  <td  valign="top" >
                                    <div class="float_left"> <?php echo ($pt_info[0]->clr_mobile) ?></div>
                                    <div class="float_left">   <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $pt_info[0]->clr_mobile; ?>"></a></div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Caller Relation</td>
                                <td valign="top"><?php echo get_relation_by_id($pt_info[0]->clr_ralation); ?></td>
                                <td></td>
                                <td></td>
                            </tr>

                        </table>

                    </div>
                     <div class="width50 float_right ercp">

                        <table>
                            <tr class="single_record_back">
                                <td colspan="4">Incident Information</td>
                            </tr>
                            <tr>
                                <td class="width" valign="top">Call Type</td>
                                <td class="width_25" valign="top"><?php echo ucwords($pname); ?></td>
                                <td class="width" valign="top">No Of Patients</td>
                                <td class="width_25" valign="top"><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : '-'; ?></td>
                            </tr>

                            <tr>     <?php if (trim($pt_info[0]->inc_type) == 'mci') { ?>


                                    <td class="width_25" valign="top">MCI Nature</td>
                                    <td class="width_25" valign="top"><?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></td>

                                <?php } else { ?>


                                    <td class="width_25" valign="top">Chief Complaint Name</td>
                                    <td class="width_25" valign="top"><?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?></td>


                                <?php } ?>
                                <td class="width_25" valign="top">Current Ambulance</td>
                                <td class="width_25" valign="top"><?php echo $pt_info[0]->amb_rto_register_no; ?></td>
                            </tr>

                            <tr>
                                <td class="width_25" valign="top">Ambulance base location</td>
                                <td class="width_25" valign="top"><?php echo ($pt_info[0]->hp_name); ?></td>
                                <td class="width_25" valign="top">Dispatch Date /Time</td>
                                <td class="width_25" valign="top"><?php echo $pt_info[0]->inc_datetime; ?></td>

                            </tr>
                            <tr>                                  
                                <td class="width" valign="top">Incident Id</td>
                                <td class="width_25" valign="top"><?php echo ($pt_info[0]->inc_ref_id); ?></td>
                                <td class="width_25" valign="top">Incident Address</td>
                                <td class="width_25" valign="top"><?php echo $pt_info[0]->inc_address; ?></td>
                            </tr>

                                                
                        </table>
                    </div>
                </div>


            <?php } else { ?>

                <div class="width100 text_align_center"><span> No records found. </span></div>


            <?php } ?>

        </div>

    </div>

    <div><h3 class="txt_clr2 width1 txt_pro">Current call details</h3></div>

    <form method="post" name="adv_call_form" id="adv_call_form">

        
        <!--<input type="hidden" name="fire[fc_pre_inc_ref_id]" value="<?php echo $pt_info[0]->inc_ref_id ?>">-->

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


                            echo get_fire_state($st);
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

                            echo get_district_fire($dt);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="width33 float_left">    
                    <div class="field_lable float_left width33"><label for="police_station">Fire Station <span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <div id="incient_police">
                            <?php
                            if ($pt_info[0]->inc_state_code != '') {
                                $dt = array('dst_code' => $pt_info[0]->inc_district_code, 'st_code' => $pt_info[0]->inc_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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
            <div class="field_row width100">
                <div class="width33 float_left">   
                    <div class="label blue float_left width33">Fire Chief Complaint<span class="md_field">*</span></div>
                    <div class="input  top_left float_left width2" >
                        <input type="text" name="fire[fc_fire_chief_complaint]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_fire_chief_complete"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select fire chief complaint from dropdown list'}"TABINDEX="8" <?php echo $autofocus; ?>>
                    </div>
                </div>
           
                <div class="width33 float_left">
                    <div class="filed_lable float_left width33"><label for="station_name">Call Receiver Name<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50">

                        <input   type="text" name="fire[fc_call_receiver_name]" class="filter_required" placholder="Call Receiver Name" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
                            echo $view;
                            if (@$update) {
                                echo"disabled";
                            }
                            ?> >

                    </div>
                </div>  
                <div class="width33 float_left">

                    <div class="field_lable float_left width33"> <label for="mobile_no"> Mobile No</label></div>

<!--
                    <div class="filed_input float_left width50">
                        <input type="text" name="fire[fc_mobile_no]" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                    </div>-->

                      <div class="filed_input float_left width50">
                      <input type="text" name="fire[fc_mobile_no]" class="width90 float_left  filter_no_whitespace"  data-errors="{filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                        <!--<input type="text" name="fire[fc_mobile_no]" class="width90 float_left filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$police_station[0]->p_station_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>> -->  
                        <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo @$police_station[0]->p_station_mobile_no; ?>"></a>
                    </div>
                    
                </div>

                <div class="width33 float_left">

                    <div class="field_lable float_left width33"> <label for="mobile_no"> Assign Time<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50">
                        <input   type="text" name="fire[fc_assign_time]" class="filter_required mi_cur_timecalender "  data-errors="{filter_required:'Fire should not be blank'}" value="" TABINDEX="10"  <?php echo $view; ?>>
                    </div>
                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width33"> <label for="date_time">Standard Remark<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <select name="fire[fc_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                            <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                            <option value="complaint_register"  <?php
                        if ($fuel_data[0]->ff_standard_remark == 'complaint_register') {
                            echo "selected";
                        }
                            ?>  >Complaint Register Sucessfully </option>


                        </select>
                    </div>
                </div> 
                     <div class="width33 float_left">
                   
                            <label for="service" class="chkbox_check top_left">
                                <input type="checkbox" name="fire[fc_assign_call]" class="check_input unit_checkbox filter_required" value="assign"  data-errors="{filter_required:'Assign call to Fire station should  be checked!'}" id="service">
                                <span class="chkbox_check_holder"></span>Assign call to Fire station<span class="md_field">*</span>
                            </label>
                    </div>
                </div>
        </div>
        <div class="width100 float_left">
                <div class="width33 float_left">
                    <div class="field_lable float_left width33"> <div class="label blue float_left">Remark</div></div>

                    <div class="width2 float_left">
                        <textarea style="height:60px;" name="fire[fc_remark]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Remark should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                    </div>
                </div>
            </div>


            <div class="save_btn_wrapper">

                <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}fire_calls/save_manual_fire" data-qr="" type="button" tabindex="16">

            </div>

    </form>

</div>



