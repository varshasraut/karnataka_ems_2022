<div class="call_purpose_form_outer">

    <!-- <h3>Call Transfer To 102</h3> -->
    <label class="headerlbl">Call Transfer To 104</label>


    <form method="post" name="complnt_call_form" id="complnt_form">

       <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
        
        <input type="hidden" name="incient[inc_type]" id="inc_type" value="CALL_TRANS_102">
        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">

        
        <div class="width100 enquiry_summary">
    <div class="width2 form_field float_left ">
        <div class="label blue float_left width_25">ERO Summary<span class="md_field">*</span>&nbsp;</div>
        <div class="width75 float_left">
            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=CALL_TRANS_102"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
        </div>

    </div>
    <div class="width2 form_field float_left">
        <div class="label blue float_left width_16">ERO Note</div>

        <div class=" float_left width75" id="ero_summary_other">
            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
        </div>
    </div>

</div>

  <div class="button_field_row  text_align_center">

            <div class="button_box call_transfer">

                <input type="hidden" name="submit" value="sub_enq" />
             
             <input name="fwd_btn" value="Call Transfer To 104" class="style5 style10 form-xhttp-request" data-href="{base_url}transfercall/confirm_save" data-qr="forword=yes" type="button" tabindex="8">


            </div>

        </div>






    </form>


</div>