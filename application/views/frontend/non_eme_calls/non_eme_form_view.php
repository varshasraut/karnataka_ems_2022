<div class="call_purpose_form_outer">

    <h3>Non-Emergency Call</h3>


    <form method="post" name="call_form" >

        <input type="hidden" name="caller_no" id="caller_no" value="<?php echo $caller_no; ?>">
        
        <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">

        <input type="hidden" name="incient[inc_type]" id="inc_type" value="NON_EME_CALL">
<input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">

        <div class="width100 float_left">

            <div class=" width2 form_field ">

                <div class="label width_25 blue float_left">Call Type <span class="md_field">*</span></div>

                <div class=" float_left width75">

                    <select id="call_purpose" name="non_eme_call[cl_type]" class="filter_required change-base-xhttp-request" data-href="{base_url}non_eme_calls/save_non_eme_call_details" data-qr="output_position=content&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}"  data-base="non_eme_call[cl_type]" TABINDEX="1.1" onchange="submit_caller_non_eme_form()">
                        <option value="">Purpose Of calls</option>
                        <?php
                        foreach ($non_eme_calls as $purpose_of_call) {
                            echo "<option value='" . $purpose_of_call->cl_code . "'  ";
                            echo $select_group[$purpose_of_call->cl_code];
                            echo" >" . $purpose_of_call->cl_name;
                            echo "</option>";
                        }
                        ?>
                    </select>

                </div>

            </div> 

        </div>

        <div id="non_eme_call"></div>

        <!--        <div class="width100 enquiry_summary">
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
        
        </div>-->

        <!--  <div class="button_field_row  text_align_center">
        
                    <div class="button_box enquiry_button">
        
                        <input type="hidden" name="submit" value="sub_enq" />
                     
                     <input name="fwd_btn" value="Save" class="style5 form-xhttp-request" data-href="{base_url}ambercp/confirm_save" data-qr="forword=yes" type="button" tabindex="8">
        
        
                    </div>
        
                </div>-->






    </form>


</div>