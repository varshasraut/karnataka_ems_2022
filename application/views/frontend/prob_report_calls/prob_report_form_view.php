<div class="call_purpose_form_outer">

    <!-- <h3>Problem Reporting Call</h3> -->
    <label class="headerlbl">Grievance call</label>


    <form method="post" name="complnt_call_form" id="complnt_form">

       <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
        
        <input type="hidden" name="incient[inc_type]" id="inc_type" value="PRO_REP_SER">


        <div class="width100 float_left">

            <div class=" width2 form_field ">

                <div class="label width_25 blue float_left">Standard <span class="md_field">*</span></div>

                <div class=" float_left width75">
                     <input type="text"  id="rcl_standard" name="rcl_standard"  data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['inc_ero_standard_summary']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=Grievance"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >

<!--                    <select  id="rcl_standard" name="rcl_standard"  class=" filter_required "  data-errors="{filter_required:'Please select Standard from dropdown list'}">
                        <option value="" >Select</option>
                        <option value="address_the_complaint">Addressed the complaint & case closed</option>
                        <option value="forword_to_grivance">Forward to Grievance for further action</option>
                    </select>-->


                </div>

            </div> 

        </div>
        
        <div class="width100 enquiry_summary">
    <div class="width2 form_field float_left ">
        <div class="label blue float_left width_25">ERO Summary<span class="md_field">*</span>&nbsp;</div>
        <div class="width75 float_left">
            <!-- <input type="text" id="sum" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=PRO_REP_SER"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" > -->
            <textarea style="height:60px;" id="sum" class="filter_required width_100" name="incient[inc_ero_standard_summary]" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" ></textarea>
        </div>

    </div>
    <div class="width2 form_field float_left">
        <div class="label blue float_left width_16">ERO Note</div>

        <div class=" float_left width75" id="ero_summary_other">
            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
        </div>
    </div>

</div>

        <div class="button_field_row beforeunload text_align_center" style="width: 300px; margin: 0 auto;" id="problem_reporting_call">

            <div class="button_box enquiry_button">

                <input type="hidden" name="submit" value="sub_enq" />
             
                <div class="forward_button hide">
                    <input name="fwd_btn" value="FORWARD TO GRIEVANCE" class="style4 form-xhttp-request" data-href="{base_url}probreportcall/confirm_save" data-qr="forword=yes" type="button" tabindex="8" style="position: relative;">
                </div>
                <div class="save_button hide">
                    <input name="fwd_btn" value="Save" class=" form-xhttp-request" data-href="{base_url}probreportcall/confirm_save" data-qr="forword=no" type="button" tabindex="8" style="position: relative;">
                </div>

            </div>

        </div>






    </form>


</div>