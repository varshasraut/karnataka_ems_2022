


<div class="inc_pt_info float_left width100">


    <?php if (!empty($pt_info[0])) { ?>

        <div class="width100">
            <div class="width47 float_left">

                <span class="font_weight600">Incident Information</span>

                <table class="style3">

                    <tr>
                        <td class="width40">No Of Patients</td>
                        <td><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : '-'; ?></td>
                    </tr>

                    <tr>

                        <?php if (trim($pt_info[0]->ntr_nature) != '') { ?>


                            <td>MCI Nature</td>
                            <td><?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></td>



                        <?php } else { ?>


                            <td>Chief Complaint Name</td>
                            <td><?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?></td>


                        <?php } ?>

                    </tr>

                    <tr>
                        <td>Incident Address</td>
                        <td><?php echo $pt_info[0]->inc_address; ?></td>
                    </tr>
                    <tr>
                        <td>Incidence Purpose</td>
    <!--                    <td><?php echo $pt_info[0]->inc_type; ?></td>-->
                        <td><?php echo get_purpose_of_call($pt_info[0]->inc_type); ?></td>
                    </tr>

                </table>

            </div>
            <div class="width47 float_right">

                <span class="font_weight600">Patient Information</span>

                <table class="style3">

                    <tr>
                        <td class="width40">Patient Name</td>
                        <td><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
                    </tr>

                    <tr>
                        <td>Age</td>
                        <td><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age : "-"; ?></td>
                    </tr>

                    <tr>
                        <td>Gender</td>
                        <td><?php echo ($pt_info[0]->ptn_gender) ? get_gen($pt_info[0]->ptn_gender) : "-"; ?></td>
                    </tr>

                    <tr>
                        <td>ERO Summary</td>
                        <td><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>
                    </tr>

                </table>

            </div> 
        </div>

        <div class="width100">
            <div class="width47 float_left">

                <span class="font_weight600">Ambulance Information</span>

                <?php
                foreach ($amb_data as $amb_data) {
                    if ($amb_data->amb_rto_register_no != '') {
                        ?>

                        <table class="style3">

                            <tr>
                                <td class="width40">Ambulances No</td>
                                <td><?php echo ($amb_data->amb_rto_register_no) ?></td>
                            </tr>

                            <tr>

                                <td>Base location</td>
                                <td><?php echo ($amb_data->hp_name) ?></td>

                            </tr>

                            <tr>
                                <td>Mobile No</td>
                                <td><?php echo $amb_data->amb_default_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb_data->amb_default_mobile; ?>"></a></td>
                            </tr>
                            <tr>
                                <td>Doctor Name</td>
                                <td><?php echo $amb_data->clg_first_name; ?> <?php echo $amb_data->clg_last_name; ?></td>
                            </tr>
                        </table>
                        <!--
                                                <tr>
                                                    <td class="width_16 strong">Base location Name</td>
                                                    <td colspan="4"><?php echo get_amb_hp($amb_data->amb_rto_register_no); ?></td>
                                                </tr><tr>
                                                    <td class="width_16 strong">Ambulance Name</td>
                                                    <td><?php echo $amb_data->amb_rto_register_no; ?></td>
                                                    <td class="width_16 strong">Ambulance Status</td>
                                                    <td><?php echo $amb_data->amb_status; ?></td>
                                                    <td class="width_16 strong">Mobile No </td>
                                                    <td colspan="5"><?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></td>
                                                </tr>
                                                <tr>
                        
                                                    <td class="width_16 strong">EMT Name</td>
                                                    <td><?php echo $amb_data->amb_emt_id; ?></td>
                                                    <td class="width_16 strong">Pilot Name</td>
                                                    <td colspan="3"><?php echo $amb_data->amb_pilot_id; ?></td>
                                                </tr>-->
                        <?php
                    }
                }
                ?>

               

            </div>
            <div class="width47 float_right">

                <span class="font_weight600">Caller Information</span>

                <table class="style3">

                    <tr>
                        <td class="width40">Caller Name</td>
                        <td><?php echo ($pt_info[0]->clr_fname) ? $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname : "-"; ?></td>
                    </tr>

                    <tr>

                        <td>Caller Mobile</td>
                        <td><?php echo ($pt_info[0]->clr_mobile) ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $pt_info[0]->clr_mobile; ?>"></a></td>

                    </tr>

                    <tr>
                        <td>Caller Relation</td>
                        <td><?php if ($pt_info[0]->clr_ralation != '') {
                echo get_relation_by_id($pt_info[0]->clr_ralation);
            } else {
                echo 'Medical';
            } ?></td>
                    </tr>
                </table>

            </div>
        </div>

    <?php } else { ?>

        <div class="width100 text_align_center"><span> No records found. </span></div>


<?php } ?>

</div>
<div class="width100 enquiry_summary">
    <div class="width2 form_field float_left ">
        <div class="label blue float_left width_25">ERO Summary<span class="md_field">*</span>&nbsp;</div>
        <div class="width75 float_left">
            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
        </div>

    </div>
    <div class="width2 form_field float_left">
        <div class="label blue float_left width_16">ERO Note</div>

        <div class=" float_left width75" id="ero_summary_other">
            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
        </div>
    </div>

</div>



<?php if (!empty($pt_info[0])) { ?>

    <div class="save_btn_wrapper">

        <input name="fwd_btn" value="FORWARD TO ERCP" class="style4 form-xhttp-request" data-href="{base_url}medadv/confirm_save" data-qr="output_position=summary_div" type="button" tabindex="8">

    </div>

    <input type="hidden" name="increfid" value="<?php echo $increfid; ?>">

<?php } ?>




