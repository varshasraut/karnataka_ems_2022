<?php
$current_time = time();
?>
<script>
    $AVAYA_INCOMING_CALL_FLAG = 0;
    StopTimerFunction();

    clock_timer('police_timer', '<?php echo $current_time; ?>', '<?php echo $current_time; ?>')
</script>
<div class="width100 float_left mt-2">
    <div id="add_caller_details" class="<?php // echo $cl_class;         
                                        ?> width_17  float_left input">
        <span class="strong">Timer : </span> <input type='text' id="police_timer" value="" readonly="readonly" name="incient[dispatch_time]" />
    </div>

    <div id="cur_date_time_clock"> <span class="strong">Date & Time : </span> <?php echo date('d-m-Y H:i:s'); ?> </div>
</div>

<?php 

if($this->clg->clg_group == 'UG-COUNSELOR-104'){
?>
    <div class="width100 float_left">
        <div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer">
            <div class="head_outer1">
                <h4 class="txt_clr2 width1 mb-0">104 COUNSELOR FORM</h4>
            </div>
            <div class="pan_box bottom_border float_left width100">
                <div class=" float_left width100">
                    <?php if (!empty($pt_info[0])) {
                    ?>

                        <div class="width100">
                            <div class="width100 float_left ercp">

                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">Incident Information</td>
                                    </tr>
                                    <tr>
                                        <td class="width">Incident Id</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_ref_id); ?></td>
                                        <td class="width_25">Incidence Purpose</td>
                                        <td class="width_25"><?php echo $pname; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="width">Incident DateTime</td>
                                        <td class="width_25"><?php echo $pt_info[0]->inc_datetime; ?></td>
                                        <td class="width_25">ERO Summary</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>

                                    </tr>
                                    <tr>
                                    <td>ERO Standard Summary</td>
                                    <td class="width_25"><?php echo $help_standard_remark[0]->re_name; ?></td>
                                    <!--<td class="width">Chief Complaint</td>
                                    <td class="width_25"><?php if ($pt_info[0]->help_desk_chief_complaint != '') {
                                                //echo help_chief_comp_types($pt_info[0]->help_desk_chief_complaint);
                                            }
                                            ?></td> -->                        
                                    </tr>
                
                                    
                                </table>
                            </div>
                            <div class="width100 float_right ercp">
                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">Caller Information</td>
                                    </tr>

                                    <tr>
                                        <td class="width_25">Caller Name</td>
                                        <td><?php echo ($pt_info[0]->clr_fname) ? $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname : "-"; ?></td>
                                        <td>Caller Mobile</td>

                                        <td>
                                            <div class="float_left"> <?php echo $pt_info[0]->clr_mobile; ?></div>
                                            <div class="float_left"> <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $pt_info[0]->clr_mobile; ?>"></a></div>

                                        </td>
                                    </tr>
                                    <!--<tr>
                                        <td>Caller Relation</td>
                                        <td><?php echo get_relation_by_id($pt_info[0]->clr_ralation); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>-->

                                </table>

                            </div>
                            <div class="width100 float_left ercp">
                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">ERO 104 Information</td>
                                    </tr>
                                    <tr>
                                        <td class="width_25">Added By Id</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_added_by); ?></td>
                                        <td class="width_25">Added By Name</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->clg_first_name.' '.$pt_info[0]->clg_mid_name.' '.$pt_info[0]->clg_last_name); ?></td>
                                    </tr>
                                </table>
                                </div>
                        </div>
                    <?php } else { ?>
                        <div class="width100 text_align_center"><span> No records found. </span></div>
                    <?php } ?>
                </div>
                <div class="width100 float_left">
                    <?php if (!empty($prev_cl_dtl)) { ?>
                        <ul class="dtl_block">
                            <li>
                                <h3 class="txt_clr2 width1 txt_pro">Previous ERCP Advice</h3>
                            </li>
                            <?php
                            $CALL = 1;
                            foreach ($prev_cl_dtl as $cll_dtl) {
                            ?>
                                <li><a class="onpage_popup" data-href="{base_url}medadv/prev_call_info" data-qr="output_position=popup_div&amp;adv_cl_id=<?php echo $cll_dtl->adv_cl_id; ?>" data-popupwidth="1500" data-popupheight="800"><span><?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->que_question; ?></span></a></li>
                            <?php }
                            ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>

            <div class="head_outer1 mb-2">
                <h4 class="txt_clr2 width1 mb-0">Current Call Details</h4>
            </div>
            <form method="post" name="adv_call_form" id="adv_call_form">
                <input type="hidden" name="cdata[cons_cl_inc_id]" value="<?php echo $cl_dtl[0]->adv_inc_ref_id; ?>">
                <input type="hidden" name="opt_id" value="<?php echo $opt_id; ?>">
                <input type="hidden" name="cdata[cons_cl_adv_id]" value="<?php echo $cl_dtl[0]->adv_id; ?>">
                <input type="hidden" name="sub_id" value="<?php echo $cl_dtl[0]->sub_id; ?>">
                <input type="hidden" name="hi" value="<?php echo date('Y-m-d H:i:s') ?>">
                
                <div class="outer_cl inline_fields width100">
                    
                    <div class="form_field width50">
                        <div class="label float_left width_25">Standard Remark<span class="md_field">*</span></div>
                            <div class="field_input top_left float_left width75" >
                                <input type="text" name="cdata[cons_std_remark]" id="" value="" class="mi_autocomplete filter_required" data-href="{base_url}auto/get_counslor_remark" placeholder="Standard Remark" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8" <?php echo $autofocus; ?>>
                            </div>
                    </div>
                    <div class="form_field width50">
                        <div class="label float_left width_25">Counselor Note</div>
                        <div class="field_input float_left width75 ercp_txt">
                            <textarea name="cdata[cons_counslor_note]" rows="3" style=""><?= $medadv_info[0]->adv_cl_ercp_addinfo; ?></textarea>
                        </div>
                    </div>
                </div>
                <div id="madv_ans" class="ans_block_box float_left">
                </div>
                <div class="save_btn_wrapper">
                    <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}medadv/save_counslor_desk_info" data-qr="" type="button" tabindex="16">
                    <a class="click-xhttp-request ercp_dash" data-href="{base_url}ercp104" data-qr="output_position=content"></a>
                </div>
            </form>
        </div>
    </div>
<?php
}else
if ($this->clg->clg_group == 'UG-ERCP-104') { ?>
    <div class="width100 float_left">
        <div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer">
            <div class="head_outer1">
                <h4 class="txt_clr2 width1 mb-0">104 ERCP FORM</h4>
            </div>
            <div class="pan_box bottom_border float_left width100">
                <div class=" float_left width100">
                    <?php if (!empty($pt_info[0])) {
                    ?>

                        <div class="width100">
                            <div class="width100 float_left ercp">

                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">Incident Information</td>
                                    </tr>
                                    <tr>
                                        <td class="width">Incident Id</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_ref_id); ?></td>
                                        <td class="width_25">Incidence Purpose</td>
                                        <td class="width_25"><?php echo $pname; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="width">Incident DateTime</td>
                                        <td class="width_25"><?php echo $pt_info[0]->inc_datetime; ?></td>
                                        <td class="width_25">ERO Summary</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>

                                    </tr>
                                    <tr>
                                    <td>ERO Standard Summary</td>
                                    <td class="width_25"><?php echo $help_standard_remark[0]->re_name; ?></td>
                                    <td class="width">Chief Complaint</td>
                                    <td class="width_25"><?php if ($pt_info[0]->help_desk_chief_complaint != '') {
                                                echo help_chief_comp_types($pt_info[0]->help_desk_chief_complaint);
                                            }
                                            ?></td>                                    
                                    </tr>
                
                                    
                                </table>
                            </div>
                            <div class="width100 float_right ercp">
                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">Caller Information</td>
                                    </tr>

                                    <tr>
                                        <td class="width_25">Caller Name</td>
                                        <td><?php echo ($pt_info[0]->clr_fname) ? $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname : "-"; ?></td>
                                        <td>Caller Mobile</td>

                                        <td>
                                            <div class="float_left"> <?php echo $pt_info[0]->clr_mobile; ?></div>
                                            <div class="float_left"> <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $pt_info[0]->clr_mobile; ?>"></a></div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caller Relation</td>
                                        <td><?php echo get_relation_by_id($pt_info[0]->clr_ralation); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                </table>

                            </div>
                            <div class="width100 float_left ercp">
                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">ERO 104 Information</td>
                                    </tr>
                                    <tr>
                                        <td class="width_25">Added By Id</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_added_by); ?></td>
                                        <td class="width_25">Added By Name</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->clg_first_name.' '.$pt_info[0]->clg_mid_name.' '.$pt_info[0]->clg_last_name); ?></td>
                                    </tr>
                                </table>
                                </div>
                        </div>
                    <?php } else { ?>
                        <div class="width100 text_align_center"><span> No records found. </span></div>
                    <?php } ?>
                </div>
                <div class="width100 float_left">
                    <?php if (!empty($prev_cl_dtl)) { ?>
                        <ul class="dtl_block">
                            <li>
                                <h3 class="txt_clr2 width1 txt_pro">Previous ERCP Advice</h3>
                            </li>
                            <?php
                            $CALL = 1;
                            foreach ($prev_cl_dtl as $cll_dtl) {
                            ?>
                                <li><a class="onpage_popup" data-href="{base_url}medadv/prev_call_info" data-qr="output_position=popup_div&amp;adv_cl_id=<?php echo $cll_dtl->adv_cl_id; ?>" data-popupwidth="1500" data-popupheight="800"><span><?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->que_question; ?></span></a></li>
                            <?php }
                            ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>

            <div class="head_outer1 mb-2">
                <h4 class="txt_clr2 width1 mb-0">Current Call Details</h4>
            </div>
            <form method="post" name="adv_call_form" id="adv_call_form">
                <input type="hidden" name="cdata[adv_cl_inc_id]" value="<?php echo $cl_dtl[0]->adv_inc_ref_id; ?>">
                <input type="hidden" name="opt_id" value="<?php echo $opt_id; ?>">
                <input type="hidden" name="cdata[adv_cl_adv_id]" value="<?php echo $cl_dtl[0]->adv_id; ?>">
                <input type="hidden" name="sub_id" value="<?php echo $cl_dtl[0]->sub_id; ?>">
                <input type="hidden" name="hi" value="<?php echo date('Y-m-d H:i:s') ?>">
                
                <!-- <div class="inline_fields width100">
                     <div id="pat_details_block">
                        <div class="form_field width17">
                            <div class="label float_left width_40">Patient Name</div>
                            <div class="input top_left float_left width_60">
                                <select name="cdata[adv_cl_ptn_id]" tabindex="8" id="ercp_pat_id" class="" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms">
                                    <option value="" <?php echo $disabled; ?>>Select patient id</option>
                                    <?php foreach ($patient_info as $pt) { ?>
                                        <option value="<?php echo $pt->ptn_id; ?>" <?php
                                                                                    if ($pt->ptn_id == $patient_id) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                                    <?php } ?>
                                    <option value="0">Other</option>
                                </select>
                                <input class="add_button_hp onpage_popup  float_right " id="add_button_ercp" name="add_patient" value="Add" data-href="{base_url}medadv/ercp_patient_details" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">
                            </div>
                        </div>
                    </div> 
                </div> -->
                <div class="outer_cl inline_fields width100">
                    <div class="form_field width50">
                        <div class="label float_left width_25">Impressions</div>
                        <div class="field_input float_left width75">
                            <input name="cdata[adv_cl_pro_dia]" tabindex="12" class="" placeholder="" type="text" value="<?= $medadv_info[0]->adv_cl_pro_dia; ?>" data-errors="{filter_required:'Impressions should not be blank'}">
                        </div>
                    </div>
                    <div class="form_field width50">
                        <div class="label float_left width_25">Chief Complaint<span class="md_field">*</span></div>
                            <div class="field_input top_left float_left width75" >
                                <input type="text" name="cdata[adv_cl_madv_que]" id="" value="" class="mi_autocomplete filter_required" data-href="{base_url}auto/get_chief_complaint_help_desk" placeholder="Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8" <?php echo $autofocus; ?>>
                            </div>
                    </div>
                    <div class="form_field width50">
                        <div class="label float_left width_25">Additional Information</div>
                        <div class="field_input float_left width75 ercp_txt">
                            <textarea name="cdata[adv_cl_addinfo]" rows="3" style=""><?= $medadv_info[0]->adv_cl_addinfo; ?></textarea>
                        </div>
                    </div>
                    <div class="form_field width50">
                        <div class="label float_left width_25">ERCP Note</div>
                        <div class="field_input float_left width75 ercp_txt">
                            <textarea name="cdata[adv_cl_ercp_addinfo]" rows="3" style=""><?= $medadv_info[0]->adv_cl_ercp_addinfo; ?></textarea>
                        </div>
                    </div>
                    <div id="madv_other" class="width50 float_left hide">
                        <div class="form_field ">
                            <div class="label">Chief Complaint Other</div>
                            <div class="field_input">
                                <input name="cdata[adv_cl_madv_que_other]" tabindex="13" class="" placeholder="" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="madv_ans" class="ans_block_box float_left">
                </div>
                <div class="save_btn_wrapper">
                    <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}medadv/save_help_desk_adv" data-qr="" type="button" tabindex="16">
                    <a class="click-xhttp-request ercp_dash" data-href="{base_url}ercp104" data-qr="output_position=content"></a>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="width100 float_left">
        <div class="call_purpose_form_outer ercp_table" id="call_purpose_form_outer">
            <div class="head_outer1">
                <h4 class="txt_clr2 width1 mb-0">ERCP FORM</h4>
            </div>

            <div class="pan_box bottom_border float_left width100">

                <!--        <div class="width30 float_left">
        
                    <ul class="dtl_block">
                        <li><span>Incident Information</span></li>
                        <li>Patient Name: <span><?php echo ($cl_dtl[0]->ptn_fname) ? $cl_dtl[0]->ptn_fname . " " . $cl_dtl[0]->ptn_lname : "-"; ?></span></li>
                        <li>Incident Address: <span><?php echo $cl_dtl[0]->inc_address; ?></span></li>
                    </ul>
        
        
                </div>-->
                <div class=" float_left width100">


                    <?php if (!empty($pt_info[0])) {
                    ?>

                        <div class="width100">
                            <div class="width100 float_left ercp">

                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">Incident Information</td>
                                    </tr>
                                    <tr>
                                        <td class="width">Incident Id</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_ref_id); ?></td>
                                        <?php if (trim($pt_info[0]->inc_type) == 'MCI') { ?>


                                            <td class="width_25">MCI Nature</td>
                                            <td class="width_25"><?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></td>



                                        <?php } else { ?>


                                            <td class="width_25">Chief Complaint Name</td>
                                            <td class="width_25"><?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?></td>


                                        <?php } ?>
                                    </tr>

                                    <tr>
                                        <td class="width_25">Incident Address</td>
                                        <td class="width_25"><?php if ($pt_info[0]->inc_address == '') {
                                                                    echo $pt_info[0]->inc_area;
                                                                    echo " ";
                                                                    echo $pt_info[0]->inc_landmark;
                                                                } else {
                                                                    echo $pt_info[0]->inc_address;
                                                                }; ?></td>
                                        <td class="width_25">Incidence Purpose</td>
                                        <td class="width_25"><?php echo $pname; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="width">No Of Patients</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : '-'; ?></td>
                                        <td class="width">Incident DateTime</td>
                                        <td class="width_25"><?php echo $pt_info[0]->inc_datetime; ?></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4" class="strong">Question & Answer</td>
                                    </tr>

                                    <?php
                                    if ($questions) {
                                        foreach ($questions as $key => $question) {
                                    ?>
                                            <tr>
                                                <td colspan="3"><?php echo $question->que_question; ?>
                                                </td>
                                                <td colspan="1"> <?php
                                                                    if ($question->sum_que_ans == 'N') {
                                                                        echo "No";
                                                                    } else {
                                                                        echo "Yes";
                                                                    }
                                                                    ?>
                                                <td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <tr class="single_record_back">
                                        <td colspan="4">Ambulance Information</td>
                                    </tr>
                                    <?php
                                    foreach ($amb_data as $amb_data) {
                                        if ($amb_data->amb_rto_register_no != '') {
                                    ?>
                                            <tr>
                                                <td class="width_25">Ambulance No</td>
                                                <td class="width_25"><?php echo ($amb_data->amb_rto_register_no) ?></td>
                                                <td class="width_25">Base location</td>
                                                <td class="width_25"><?php echo get_amb_hp($amb_data->amb_rto_register_no); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="width_25">Mobile No</td>
                                                <td class="width_25">


                                                    <div class="float_left"> <?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></div>
                                                    <div class="float_left"> <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo get_amb_mob($amb_data->amb_rto_register_no); ?>"></a></div><br><br>
                                                    <div class="float_left"> <?php echo get_amb_mob_pilot($amb_data->amb_rto_register_no); ?></div>
                                                    <div class="float_left"> <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo get_amb_mob_pilot($amb_data->amb_rto_register_no); ?>"></a></div>

                                                </td>
                                                <td class="width_25">Doctor</td>
                                                <td class="width_25"><?php echo $amb_data->amb_emt_id; ?> </td>
                                            </tr>
                                            <!-- <tr>
                                        <td class="width_25">Mobile No.2</td>
                                        <td class="width_25">


                                            <div class="float_left"> <?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></div>
                                            <div class="float_left">   <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo get_amb_mob($amb_data->amb_rto_register_no); ?>"></a></div>
                                        </td>
                                        <td class="width_25">Ambulance Type</td>
                                        <td class="width_25"><?php echo $amb_data->ambt_name; ?> </td>
                                    </tr> -->
                                            <tr>
                                                <td class="width_25">District</td>
                                                <td class="width_25"><?php echo $amb_data->dst_name; ?> </td>
                                                <td class="width_25">Ambulance Type</td>
                                                <td class="width_25"><?php echo $amb_data->ambt_name; ?> </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                            <div class="width100 float_right ercp">

                                <table>
                                    <tr class="single_record_back">
                                        <td colspan="4">Patient Information</td>
                                    </tr>
                                    <tr>
                                        <td class="width_25">Patient Name</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
                                        <td class="width_25">Age</td>
                                        <td class="width_25"><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td><?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?></td>
                                        <td>ERO Summary</td>
                                        <td><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>

                                    </tr>
                                    <tr>
                                        <td>ERO Standard Summary</td>
                                        <td><?php echo $re_name; ?></td>
                                    </tr>
                                    <tr class="single_record_back">
                                        <td colspan="4">Caller Information</td>
                                    </tr>

                                    <tr>
                                        <td class="width_25">Caller Name</td>
                                        <td><?php echo ($pt_info[0]->clr_fname) ? $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname : "-"; ?></td>
                                        <td>Caller Mobile</td>

                                        <td>
                                            <div class="float_left"> <?php echo $pt_info[0]->clr_mobile; ?></div>
                                            <div class="float_left"> <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $pt_info[0]->clr_mobile; ?>"></a></div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Caller Relation</td>
                                        <td><?php echo get_relation_by_id($pt_info[0]->clr_ralation); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                </table>

                            </div>
                        </div>


                    <?php } else { ?>

                        <div class="width100 text_align_center"><span> No records found. </span></div>


                    <?php } ?>

                </div>

                <div class="width100 float_left">



                    <?php if (!empty($prev_cl_dtl)) { ?>

                        <ul class="dtl_block">
                            <li>
                                <h3 class="txt_clr2 width1 txt_pro">Previous ERCP Advice</h3>
                            </li>



                            <?php
                            $CALL = 1;

                            foreach ($prev_cl_dtl as $cll_dtl) {
                            ?>

                                <li><a class="onpage_popup" data-href="{base_url}medadv/prev_call_info" data-qr="output_position=popup_div&amp;adv_cl_id=<?php echo $cll_dtl->adv_cl_id; ?>" data-popupwidth="1500" data-popupheight="800"><span><?php echo "CALL " . $CALL++; ?> : <?php echo $cll_dtl->que_question; ?></span></a></li>


                            <?php }
                            ?>
                        </ul>

                    <?php } ?>



                </div>

            </div>


            <div class="head_outer1 mb-2">
                <h4 class="txt_clr2 width1 mb-0">Current Call Details</h4>
            </div>
            <form method="post" name="adv_call_form" id="adv_call_form">

                <input type="hidden" name="cdata[adv_cl_inc_id]" value="<?php echo $cl_dtl[0]->adv_inc_ref_id; ?>">
                <input type="hidden" name="opt_id" value="<?php echo $opt_id; ?>">

                <input type="hidden" name="cdata[adv_cl_adv_id]" value="<?php echo $cl_dtl[0]->adv_id; ?>">

                <input type="hidden" name="sub_id" value="<?php echo $cl_dtl[0]->sub_id; ?>">

                <input type="hidden" name="hi" value="<?php echo date('Y-m-d H:i:s') ?>">

                <div class="inline_fields width100">
                    <div id="pat_details_block">
                        <div class="form_field width17">

                            <div class="label float_left width_40">Patient Name</div>
                            <div class="input top_left float_left width_60">
                                <select name="cdata[adv_cl_ptn_id]" tabindex="8" id="ercp_pat_id" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms">
                                    <option value="" <?php echo $disabled; ?>>Select patient id</option>
                                    <?php foreach ($patient_info as $pt) { ?>
                                        <option value="<?php echo $pt->ptn_id; ?>" <?php
                                                                                    if ($pt->ptn_id == $patient_id) {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                                    <?php } ?>
                                    <option value="0">Add Parient</option>
                                </select>
                                <input class="add_button_hp onpage_popup  float_right " id="add_button_ercp" name="add_patient" value="Add" data-href="{base_url}medadv/ercp_patient_details" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">
                                <!--                         <input class="add_button_hp click-xhttp-request  float_right " id="add_button_ercp" name="add_patient" value="Add" data-href="{base_url}/pcr/ercp_patient_details" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">-->
                            </div>




                        </div>
                    </div>
                    <div class="form_field width17">

                        <div class="label float_left width_25">GCS</div>
                        <div class="input float_left width75">
                            <input name="cdata[adv_cl_gcs_score]" tabindex="2" value="" class="mi_autocomplete" data-href="{base_url}auto/gcs_score" placeholder="GCS score" type="text" data-nonedit="yes" data-value="<?= $medadv_info[0]->score; ?>" value="<?= $medadv_info[0]->adv_cl_gcs_score; ?>">
                        </div>
                    </div>

                    <div class="form_field width17">

                        <div class="label float_left width_25">Pupils</div>

                        <div class="input float_left width75">
                            <input name="cdata[adv_cl_pup_left]" tabindex="3" value="" class="mi_autocomplete" data-href="{base_url}auto/pupils_type" placeholder="Right" type="text" data-value="<?= $medadv_info[0]->left_pp; ?>" value="<?= $medadv_info[0]->adv_cl_pup_left; ?>">
                        </div>


                    </div>

                    <div class="form_field width17">

                        <div class="label float_left">&nbsp;</div>

                        <div class="input float_left">


                            <input name="cdata[adv_cl_pup_right]" tabindex="4" value="" class="mi_autocomplete" data-href="{base_url}auto/pupils_type" placeholder="Left" type="text" data-value="<?= $medadv_info[0]->right_pp; ?>" value="<?= $medadv_info[0]->adv_cl_pup_right; ?>">

                        </div>

                    </div>

                    <div class="form_field width15">

                        <div class="label float_left width_25">Pulse</div>

                        <div class="input float_left width75">

                            <input name="cdata[adv_cl_pulse]" tabindex="5" class="filter_if_not_blank filter_number filter_rangelength[0-200]" placeholder="0-200" type="text" value="<?= $medadv_info[0]->adv_cl_pulse; ?>" data-errors="{filter_required:'Pulse field not be blank',filter_rangelength:'Pulse range should be 0 to 100',filter_number:'Pulse should be number'}">

                        </div>

                    </div>

                    <div class="form_field width17">

                        <!--                <div class="width50 float_left">-->

                        <div class="label float_left width_16">BP</div>

                        <div class="input float_left width33">

                            <input name="cdata[adv_cl_bp_sy]" tabindex="6" class="filter_if_not_blank filter_number filter_rangelength[0-200]" placeholder="0 to 200" type="text" value="<?= $medadv_info[0]->adv_cl_bp_sy; ?>" data-errors="{filter_required:'BP field should not be blank',filter_rangelength:'BP range should be 0 to 200',filter_number:'BP should be number'}">

                        </div>

                        <!--</div>-->

                        <!--<div class="width50 float_left">-->

                        <div class="label float_left">&nbsp;</div>

                        <div class="input float_left width33">

                            <input name="cdata[adv_cl_bp_dia]" tabindex="7" class="filter_if_not_blank filter_number filter_rangelength[0-200] float_right" placeholder="0 to 200" type="text" value="<?= $medadv_info[0]->adv_cl_bp_dia; ?>" data-errors="{filter_required:'BP field should not be blank',filter_rangelength:'BP range should be 0 to 200',filter_number:'BP should be number'}">

                        </div>

                        <!--</div>-->

                    </div>


                </div>


                <div class="inline_fields width100">


                    <div class="form_field width17">

                        <div class="label float_left width_40">RR</div>

                        <div class="input float_left width_60">

                            <input name="cdata[adv_cl_rr]" tabindex="8" class="filter_if_not_blank filter_number filter_rangelength[0-40]" placeholder="0-40" type="text" value="<?= $medadv_info[0]->adv_cl_rr; ?>" data-errors="{filter_number:'RR should be in numbers',filter_rangelength:'RR range should be 0 to 40',filter_number:'RR should be number'}">

                        </div>

                    </div>
                    <div class="form_field width17">

                        <div class="label float_left width_25">O2Sats</div>

                        <div class="input float_left width75">

                            <input name="cdata[adv_cl_o2sats]" tabindex="9" class="filter_if_not_blank filter_number filter_rangelength[1-100]" placeholder="1 to 100" type="text" value="<?= $medadv_info[0]->adv_cl_o2sats; ?>" data-errors="{filter_required:'O2Sats should not be blank',filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}">

                        </div>

                    </div>
                    <div class="form_field width17">

                        <div class="label float_left width_25">Temp oF</div>

                        <div class="input float_left width75">

                            <input name="cdata[adv_cl_temp]" tabindex="10" class="filter_if_not_blank filter_rangelength[82-110]" placeholder="82 to 110" type="text" value="<?= $medadv_info[0]->adv_cl_temp; ?>" data-errors="{filter_number:'Temp should be in numbers',filter_rangelength:'Temp range should be 82 to 110'}">

                        </div>

                    </div>
                    <div class="form_field width17">
                        <div class="label float_left width_25"></div>

                        <div class="input float_left width75">

                            <input tabindex="11" class="filter_if_not_blank filter_number filter_rangelength[1-200]" placeholder="1 to 200" type="hidden" value="<?= $medadv_info[0]->adv_cl_bslr; ?>" data-errors="{filter_number:'BSLR should be in numbers',filter_rangelength:'BSLR range should be 1 to 200'}">

                        </div>

                    </div>

                    <!--</div>-->
                    <div class="form_field width15">

                        <div class="label float_left width_25">BSLR</div>

                        <div class="input float_left width75">

                            <input name="cdata[adv_cl_bslr]" tabindex="11" class="filter_if_not_blank filter_number filter_rangelength[1-600]" placeholder="1 to 600" type="text" value="<?= $medadv_info[0]->adv_cl_bslr; ?>" data-errors="{filter_number:'BSLR should be in numbers',filter_rangelength:'BSLR range should be 1 to 600'}">

                        </div>

                    </div>

                </div>
                <div class="outer_cl">
                    <div class="form_field width50">

                        <div class="label float_left width_25">Impressions</div>

                        <div class="field_input float_left width75">

                            <input name="cdata[adv_cl_pro_dia]" tabindex="12" class="" placeholder="" type="text" value="<?= $medadv_info[0]->adv_cl_pro_dia; ?>" data-errors="{filter_required:'Impressions should not be blank'}">


                        </div>

                    </div>

                    <div class="form_field width50">

                        <div class="label float_left width_25">Chief Complaint<span class="md_field">*</span></div>

                        <div class="field_input top_left float_left width75">


                            <input name="cdata[adv_cl_madv_que]" tabindex="14" class="filter_required mi_autocomplete" data-href="{base_url}auto/madv_que" placeholder="Select Protocol" data-errors="{filter_required:'Please select ERCP advice from dropdown list'}" type="text" data-callback-funct="get_madv_ans" data-value="<?= $medadv_info[0]->que_question; ?>" value="<?= $medadv_info[0]->adv_cl_madv_que; ?>">


                        </div>

                    </div>
                    <div class="form_field width50">

                        <div class="label float_left width_25">Additional Information</div>

                        <div class="field_input float_left width75 ercp_txt">

                            <!--                    <input name="cdata[adv_cl_addinfo]" tabindex="13" class="" placeholder="" type="text"> -->
                            <textarea name="cdata[adv_cl_addinfo]" rows="3" style=""><?= $medadv_info[0]->adv_cl_addinfo; ?></textarea>

                        </div>

                    </div>
                    <div class="form_field width50">

                        <div class="label float_left width_25">ERCP Note</div>

                        <div class="field_input float_left width75 ercp_txt">


                            <textarea name="cdata[adv_cl_ercp_addinfo]" rows="3" style=""><?= $medadv_info[0]->adv_cl_ercp_addinfo; ?></textarea>


                        </div>

                    </div>
                    <div id="madv_other" class="width50 float_left hide">
                        <div class="form_field ">

                            <div class="label">Chief Complaint Other</div>

                            <div class="field_input">

                                <input name="cdata[adv_cl_madv_que_other]" tabindex="13" class="" placeholder="" type="text">

                            </div>

                        </div>
                    </div>

                </div>
                <div id="madv_ans" class="ans_block_box float_left">




                </div>


                <div class="save_btn_wrapper">

                    <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}medadv/save_adv" data-qr="" type="button" tabindex="16">

                    <a class="click-xhttp-request ercp_dash" data-href="{base_url}ercp" data-qr="output_position=content"></a>


                </div>

            </form>

        </div>
    </div>
<?php } ?>
<style>
    .head_outer1 .txt_clr2 {
        display: inline-block;
        margin-left: 0px;
        color: white;
        text-align: center;
        margin-top: 2px;
        background-color: #2F419B !important;
    }

    #add_caller_details #police_timer {
        background: #F3F1F1 !important;
    }

    .single_record_back {
        font-weight: bold;
    }
</style>