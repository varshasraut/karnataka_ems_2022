

<div class="box_head text_align_center width100">
<label class="headerlbl">Additional Resources</label>
    <!-- <h3 class="txt_pro">ADDITIONAL RESOURCES</h3> -->
</div>

<div class="confirm_save width100">




    <div class="summary_info">

        <ul class="dtl_block">
            <li><span>Previous Incident Id:</span><?php echo " " . $increfid; ?></li>
            <li><span>Incident Id:</span><?php echo $inc_ref_id; ?></li>



        </ul>

    </div>

    <div id="summary_div">


    </div>
    
    <form name="com_call_fwd" method="post" id="dispatch_call_forms">
        <?php if ($cl_type == 'terminate') { ?>
        <div class="form_field width100">
            <div class="label blue float_left width30">Termination Reason<span class="md_field">*</span></div>
            <div class="input nature top_left float_left width_66">
                <select name="termination_reason" id="termination_reason" class="filter_required" data-errors="{filter_required:'Please select Termination Reason from dropdown list'}">
                    <option value="">Select Termination Reason</option>
                    <option value="Ambulance Unavability">Ambulance Unavability[Busy]</option>
                    <option value="Already Dispatched">Already Dispatched</option>
                    <option value="Duplicate Call">Duplicate Call</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="form_field width100 hide" id="termination_reason_other">
            <div class="label blue float_left width30">Other Termination Reason</div>
            <div class="input nature top_left float_left width_66">
                <input type="text" name="termination_reason_other"  value="" class="" placeholder="Other Termination Reason" data-errors="{filter_required:'Other Termination Reason is required'}"   TABINDEX="73">
            </div>
        </div>
        <?php } ?>
    <div class="save_btn_wrapper beforeunload ">
            <input name="inc_id" value="<?php echo $increfid; ?>" type="hidden">
            <input name="resource_type" value="<?php echo $resource_type; ?>" type="hidden">
            <!--
                        <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>resource/save" data-qr="output_position=content" type="button" tabindex="20">-->


            <?php if ($cl_type == 'terminate') { ?>
                <input type="hidden" name="terminate" value="yes">
                <input name="" value="Terminate Call" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>resource/save" data-qr="output_position=content" type="button" tabindex="20">
            <?php } else { ?>
                <input name="" value="DISPATCH" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>resource/save" data-qr="output_position=content" type="button" tabindex="20">

            <?php } ?>

            <input name="" tabindex="" value="CANCEL" class="cancel_btn style3"  type="button">
    </div>
    </form>

</div>





