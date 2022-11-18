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

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro">
            <?php
            if ($action_type) {
                  echo $action_type . ' Fire Call Details';
            }
            ?></h2>

        <div class = " float_left width100">
            <div><h3 class="txt_clr2 width1 txt_pro">Previous  call details</h3></div>

            <?php if (!empty($pt_info[0])) {
                ?>

                <div class="width100">
                    <div class="width100 float_left ercp">
                        <div class="single_record_back width100 float_left">
                            <div class="strong">Incident Information</div>
                        </div>
                        <div class="field_row width100">
                            <div class="width33 float_left">
                                <div class="filed_lable float_left width33 strong"><label for="call_type">Call Type</label></div>

                                <div class="filed_input float_left width50">
                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="<?= $pname; ?> "  <?php echo $view; ?> >


                                </div>
                            </div>   
                            <div class="width33 float_left">

                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">No Of Patients</label></div>
                                <div class="filed_input float_left width50">


                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="<?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : '-'; ?> "  <?php echo $view; ?> >


                                </div>
                            </div>
                            <div class="width33 float_left">
                                <tr>     <?php if (trim($pt_info[0]->inc_type) == 'mci') { ?>

                                    <div class="field_lable float_left width33 strong"> <label for="no_of_patient">MCI Nature</label></div>
                                    <div class="filed_input float_left width50">
                                        <?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></div>


                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="<?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?> "  <?php echo $view; ?> >
                                <?php } else { ?>

                                    <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Chief Complaint Name</label></div>
                                    <div class="filed_input float_left width50">


                                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="<?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?>"  <?php echo $view; ?> >
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="width100 float_left">
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Current Ambulance</label></div>
                                <div class="filed_input float_left width50">


                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="  <?php echo $pt_info[0]->amb_rto_register_no; ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Ambulance base location</label></div>
                                <div class="filed_input float_left width50">

                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="  <?php echo ($pt_info[0]->hp_name); ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Dispatch Date /Time</label></div>
                                <div class="filed_input float_left width50">

                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="    <?php echo $pt_info[0]->inc_datetime; ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                        </div>
                        <div class="width100 float_left">
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Incident Id</label></div>
                                <div class="filed_input float_left width50">


                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?php echo ($pt_info[0]->inc_ref_id); ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Incident Address</label></div>
                                <div class="filed_input float_left width50">

                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="    <?php echo $pt_info[0]->inc_address; ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                        </div> 
                        <div class="single_record_back width100 float_left">
                            <div class="strong">Patient Information</div>
                        </div>
                        <div class="width100 float_left">
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Patient Name</label></div>
                                <div class="filed_input float_left width50">

                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="  <?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Age</label></div>
                                <div class="filed_input float_left width50">

                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Gender</label></div>
                                <div class="filed_input float_left width50">


                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                        </div>
                        <div class="single_record_back width100 float_left">
                            <div class="strong">Caller Information</div>
                        </div>
                        <div class="width100 float_left">
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Caller Name</label></div>
                                <div class="filed_input float_left width50">
 <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?php echo ($pt_info[0]->clr_fname) ?>"  <?php echo $view; ?> >

                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Caller Mobile</label></div>
                                <div class="filed_input float_left width50">

                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?php echo ($pt_info[0]->clr_mobile) ?>"  <?php echo $view; ?> >

                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div class="field_lable float_left width33 strong"> <label for="no_of_patient">Caller Relation</label></div>
                                <div class="filed_input float_left width50">


                                    <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="  <?php echo get_relation_by_id($pt_info[0]->clr_ralation); ?>"  <?php echo $view; ?> >
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            <?php } else { ?>

                <div class="width100 text_align_center"><span> No records found. </span></div>


            <?php } ?>

        </div>

    </div>
    <div><h3 class="txt_clr2 width1 txt_pro">Current call details</h3></div>

    <?php
    $caller_name = $inc_info[0]->clr_fname . "  " . $inc_info[0]->clr_lname;
    ?>

    <div class="joining_details_box">

        <div class="width100">

            <div class="field_row width100">
                <div class="width33 float_left">
                    <div class="filed_lable float_left width33 strong"><label for="station_name">Incident ID</div>

                    <div class="filed_input float_left width50">



                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="<?= $inc_info[0]->fc_pre_inc_ref_id; ?>"  <?php echo $view; ?> >

                    </div>
                </div>   <div class="width33 float_left">

                    <div class="field_lable float_left width33 strong"> <label for="district">Fire Incident ID</label></div>
                    <div class="filed_input float_left width50">



                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="  <?= $inc_info[0]->fc_inc_ref_id; ?>"  <?php echo $view; ?> >

                    </div>
                </div>

                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"><label for="district">Fire Call Assign Time</label></div>
                    <div class="filed_input float_left width50"> <div id="incient_state">



                            <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="      <?= $inc_info[0]->fc_assign_time; ?>"  <?php echo $view; ?> >

                        </div>

                    </div>

                </div>
            </div>

            <div class="field_row width100">

                <div class="width33 float_left">    
                    <div class="field_lable float_left width33 strong"><label for="district">Caller Name</label></div> 
                    <div class="filed_input float_left width50">


                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?= ucwords($caller_name); ?>"  <?php echo $view; ?> >
                    </div>
                </div>
                <div class="width33 float_left">

                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">District Name</label></div>


                    <div class="filed_input float_left width50">


                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value=" <?= $inc_info[0]->dst_name; ?>"  <?php echo $view; ?> >
                    </div>
                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Caller Mob No</label></div>


                    <div class="filed_input float_left width50">

                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="   <?= $inc_info[0]->clr_mobile; ?>"  <?php echo $view; ?> >
                    </div>
                </div>
            </div>


            <div class="field_row width100">

                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fire Station Name</label></div>


                    <div class="filed_input float_left width50">

                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="     <?= $inc_info[0]->fire_station_name; ?>"  <?php echo $view; ?> >
                    </div>
                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fire Station Number</label></div>


                    <div class="filed_input float_left width50">
                        <input  tabindex="20" class="form_input  " placeholder="Assign Time" type="text"    value="     <?= $inc_info[0]->fc_mobile_no; ?>"  <?php echo $view; ?> >
                    </div>

                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fire station Receiver Name</label></div>


                    <div class="filed_input float_left width50">

                        <input   class="form_input  " placeholder="Assign Time" type="text"    value="  <?= $inc_info[0]->fc_call_receiver_name; ?>"  <?php echo $view; ?> >

                    </div>
                </div>
            </div>


            <div class="field_row width100">


                <div class="width33 float_left">

                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Fire Chief Complaint</label></div>


                    <div class="filed_input float_left width50">


                        <input   class="form_input  " placeholder="Assign Time" type="text"    value="    <?= $inc_info[0]->fi_ct_name; ?>"  <?php echo $view; ?> >
                    </div>
                </div>
                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"> <label for="mobile_no">Ambulance No</label></div>


                    <div class="filed_input float_left width50">

                        <input   class="form_input  " placeholder="Assign Time" type="text"    value="     <?= $inc_info[0]->amb_rto_register_no; ?>"  <?php echo $view; ?> >
                    </div>
                </div>
                <div class="filed_input float_left width33">

                    <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                    <div class="filed_input float_left width50">



                        <select name="police[fc_standard_remark]" tabindex="8" id="standard_remark" class="" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $view; ?>> 
                            <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                            <option value="complaint_register"  <?php
                            if ($inc_info[0]->fc_standard_remark == 'complaint_register') {
                                echo "selected";
                            }
                            ?> >Complaint Register</option>


                        </select>

                    </div>
                </div>

            </div>


            <div class="field_row width100">





                <div class="width33 float_left">
                    <div class="field_lable float_left width33 strong"> <label for="mt_on_remark">Remark</label></div>


                    <div class="filed_input float_left width50" >

                        <input   class="form_input  " placeholder="Assign Time" type="text"    value="  <?= $inc_info[0]->fc_remark; ?>"  <?php echo $view; ?> >
                    </div>
                </div>

            </div>

            <?php if ($action_type == 'Update' || $inc_info[0]->fc_is_close == '1' ) { ?>
                <div><h3 class="txt_clr2 width1 txt_pro">Fire Call Information</h3></div>
                <div class="width100 float_left">
                    <div class="filed_input float_left width33">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Date Time</label></div>


                        <div class="filed_input float_left width50">

                            <input name="fire[fc_curr_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Date Time should not be blank!'}" value="<?php if($inc_info[0]->fc_curr_date_time != '0000-00-00 00:00:00'){ echo $inc_info[0]->fc_curr_date_time; } ?>"    <?php echo $view1; ?> >
                        </div>

                        <input name="fire[fc_id]" tabindex="20" type="hidden" value="  <?= $inc_info[0]->fc_id; ?>"   >

                    </div>
                    <div class="filed_input float_left width33">

                        <div class="field_lable float_left width33 strong"> <label for="mt_stnd_remark">Standard Remark</label></div>


                        <div class="filed_input float_left width50">

                            <select name="fire[fc_curr_stand_remark]" tabindex="8" id="fire_standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}" <?php echo $view1; ?>  > 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="fire_reached"  <?php
                                if ($inc_info[0]->fc_curr_stand_remark == 'fire_reached') {
                                    echo "selected";
                                }
                                ?> >Fire reached at location</option>
                                <option value="other"  <?php
                                if ($inc_info[0]->fc_curr_stand_remark == 'other') {
                                    echo "selected";
                                }
                                ?> >Other</option>


                            </select>



                        </div>
                    </div>
                    <div class="filed_input float_left width33">
                        <div id="fire_remark_other_textbox">
                            
                                 <?php if ($inc_info[0]->fc_curr_other_remark != '') { ?>
                        <div class="field_lable float_left width33"><label for="address">Other Remark<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                            <input type="text" name="fire[fc_curr_other_remark]" value="<?= $inc_info[0]->fc_curr_other_remark; ?>" class="filter_required" placeholder="Remark" data-errors="{filter_required:'Other remark should not be blank!'}" TABINDEX="8" <?php echo $view1; ?> >
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

            <input name="save_btn" value="Update" class="style5 form-xhttp-request" data-href="{base_url}fire_calls/update_fire" data-qr="" type="button" tabindex="16">




        </div>
    <?php } ?>
</form>
