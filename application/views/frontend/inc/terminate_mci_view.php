<div class="box_head text_align_center width100">
    <h4 class="txt_pro">DISPATCH AMBULANCE</h4>
</div>

<div class="confirm_save width100">

    <div id="summary_div">

        <div class="width100 float_right">

            <span class="font_weight600">Incident Information</span>

            <table class="style3" style="margin-bottom: 10px;">
                <tr>
                    <td style="width: 40%;">Incident Id </td>
                    <td><?php echo $inc_ref_id; ?></td>

                </tr>

                <tr>
                    <td style="width: 40%;">Type Of MCI Nature </td>
                    <td><?php echo $nature[0]->ntr_nature; ?></td>
                </tr>
                <?php
                if ($inc_details['police_chief_complete'] != '') {
                    if ($police_chief[0]->po_ct_name != 'Other') {
                ?>
                        <tr>
                            <td style="width: 40%;">Police Chief Complaint </td>
                            <td><?php echo $police_chief[0]->po_ct_name; ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td style="width: 40%;">Police Chief Complaint </td>
                            <td><?php echo $inc_details['police_chief_complete_other']; ?></td>
                        </tr>
                <?php }
                } ?>

                <?php if ($inc_details['fire_chief_complete'] != '') {
                    if ($fire_chief[0]->fi_ct_name != 'Other') {
                ?>
                        <tr>
                            <td style="width: 40%;">Fire Chief Complaint </td>
                            <td><?php echo $fire_chief[0]->fi_ct_name; ?></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td style="width: 40%;">Police Chief Complaint </td>
                            <td><?php echo $inc_details['fire_chief_complete_other']; ?></td>
                        </tr>
                <?php }
                } ?>
                <tr>
                    <td>Address </td>
                    <td><?php echo $place; ?></td>
                </tr>
                <tr>
                    <td>ERO Summary :</td>
                    <td><?php echo $inc_ero_summary; ?></td>

                </tr>

            </table>

        </div>

        <div class="width100 float_right">

            <span class="font_weight600">Ambulance Information</span>
            <?php
            if ($get_amb_details) {
                foreach ($get_amb_details as $amb) { ?>
                    <table class="style3" style="margin-bottom: 10px;">

                        <tr>
                            <td style="width: 40%;">Ambulance No </td>
                            <td><?php echo $amb[0]->amb_rto_register_no; ?></td>
                        </tr>

                        <tr>
                            <td>Mobile No</td>
                            <td><?php echo $amb[0]->amb_default_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb[0]->amb_default_mobile; ?>"></a></td>

                        </tr>

                        <tr>
                            <td>Type of Ambulance</td>
                            <td><?php echo $amb[0]->ambt_name; ?></td>
                        </tr>



                    </table>
            <?php }
            } ?>


        </div>
        <?php if (!empty($stand_amb_id)) { ?>
            <div class="width100 float_right">

                <span class="font_weight600">Standby Ambulance Information</span>
                <?php

                foreach ($stand_amb_id as $amb) { ?>
                    <table class="style3" style="margin-bottom: 10px;">

                        <tr>
                            <td style="width: 40%;">RTO Registation no </td>
                            <td><?php echo $amb[0]->amb_rto_register_no; ?></td>
                        </tr>

                        <tr>
                            <td>Mobile No</td>
                            <td><?php echo $amb[0]->amb_default_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb[0]->amb_default_mobile; ?>"></a></td>

                        </tr>

                        <tr>
                            <td>Type of Ambulance</td>
                            <td><?php echo $amb[0]->ambt_name; ?></td>
                        </tr>



                    </table>
                <?php } ?>


            </div>
        <?php } ?>

    </div>


    <form name="com_call_fwd" method="post" id="dispatch_call_forms">
        <div class="form_field width100">
            <div class="label blue float_left width30">Termination Reason<span class="md_field">*</span></div>
            <div class="input nature top_left float_left width_66">
                <select name="termination_reason" id="termination_reason" class="filter_required" data-errors="{filter_required:'Please select Termination Reason from dropdown list'}">
                    <option value="">Select Termination Reason</option>
                    <option value="Ambulance Unavability">Ambulance Unavability [Busy]</option>
                    <option value="Already Dispatched">Already Dispatched</option>
                    <option value="Duplicate Call">Duplicate Call</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="form_field width100 hide" id="termination_reason_other">
            <div class="label blue float_left width30">Other Termination Reason</div>
            <div class="input nature top_left float_left width_66">
                <input type="text" name="termination_reason_other" value="" class="" placeholder="Other Termination Reason" data-errors="{filter_required:'Other Termination Reason is required'}" TABINDEX="73">
            </div>
        </div>

        <div class="beforeunload float_left" style="margin-top: 0px;">
            <input type="hidden" name="fwd_com_call" value="yes">
            <?php if ($cl_type["cl_type"] == '') { ?>
                <input name="" value="Terminate Call" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/terminate_mci_inc" data-qr="output_position=content" type="button" tabindex="20">
            <?php } else { ?>
                <input name="" value="FORWARD" class="inc_confirm_button accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inc?cl_type=forword" data-qr="output_position=content" type="button" tabindex="20">
            <?php } ?>
            <input name="" tabindex="" value="CANCEL" class="cancel_btn style3" type="button">
        </div>
    </form>

</div>