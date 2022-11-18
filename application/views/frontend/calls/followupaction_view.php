<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Followup Action</h3>
</div>
<form name="followup_action" method="post" id="followup_action_forms">
<div class="confirm_save width100">
<div class="width100">
        <div class="width100 strong">Incident ID : <?php echo $inc_ref_id; ?></div>
    </div>  
   <!-- <div class="width100 form_field outer_smry">
                        <div class="label blue float_left">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                          <div class="width2 float_left">
                         <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['inc_ero_standard_summary_id']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=NON_MCI"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" data-qr="call_type=NON_MCI" >
                          </div>
    </div>-->
    <div class="width100 form_field outer_smry">
        <div class="label blue float_left">ERO Note</div>
        <div class="width100" id="ero_summary_other">
            <textarea style="height:120px;" name="inc_ero_followup_summary" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?=@$inc_details['inc_ero_summary'];?></textarea>
    </div>
    </div>
   <div class="width100 form_field outer_smry">
        <div class="label blue float_left">Case status</div>
        <div class="width100" id="ero_summary_other">
            <select name="inc_ero_followup_status" tabindex="8" class="filter_required" data-errors="{filter_required:'Case status should not be blank!'}"  <?php echo $disabled; ?>> 
 
                                <option value="" <?php echo $disabled; ?>>Select Case Status</option>
                                <option value="In Follow-up"  <?php
                                if (@$indent_data[0]->inc_ero_followup_status == 'In Follow-up') {
                                    echo "selected";
                                }
                                ?>>In Follow-up</option>  
                                <option value="Ambulance Dispatched"  <?php
                                if (@$indent_data[0]->inc_ero_followup_status == 'Ambulance Dispatched') {
                                    echo "selected";
                                }
                                ?>>Ambulance Dispatched</option> 
                                 <option value="Denied/Cancelled"  <?php
                                if (@$indent_data[0]->inc_ero_followup_status == 'Denied/Cancelled') {
                                    echo "selected";
                                }
                                ?>>Denied/Cancelled</option> 
                            </select>
    </div>
    </div>
<!--       <div class="width100 form_field outer_smry">
        <div class="label blue float_left">Call status remark</div>
        <div class="width100" id="ero_summary_other">
            <textarea style="height:120px;" name="call_status_remark" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Call status remark should not be blank'}"><?=@$inc_details['call_status_remark'];?></textarea>
    </div>
    </div>-->
    <input type="hidden" name="inc_id" value="<?php echo $inc_ref_id; ?>">
    <input type="hidden" name="followup_reason" value="<?php echo $followup_reason; ?>">
    <div class="beforeunload float_left">
            <input type="hidden" name="fwd_com_call" value="yes">
            <input name="" value="Submit" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_followup_action_inc?inc_ref_id=<?php echo $inc_ref_id; ?>" data-qr="output_position=content" type="button" tabindex="20">
            <input name="" tabindex="" value="CANCEL" class="cancel_btn style3"  type="button">
        </div>
</div>
<form>





