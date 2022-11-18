<div class="call_purpose_form_outer">
    <label class="headerlbl">Scheme Related Information</label>

    <div id="totalnon_div">
        <div id="nonleft_half">
            <form method="post" name="complnt_call_form" id="complnt_form">
                <div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                            <input type="text" name="incient[help_standard_summary]" data-value="<?= @$inc_details['help_standard_summary']; ?>" value="<?= @$inc_details['help_standard_summary']; ?>" class="mi_autocomplete filter_required width2" data-href="{base_url}auto/get_ero_standard_summary?call_type=<?php echo $cl_type; ?>" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" TABINDEX="8">
                        </div>

                    </div>
                    <div class="width100 form_field float_left">
                        <div class="label blue float_left width_20">ERO Note</div>

                        <div class=" float_left width75" id="ero_summary_other">
                            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>

                    </div>
                </div>
                <div class="button_field_row  text_align_center">
                    <div class="button_box enquiry_button">
                        <input type="hidden" name="submit" value="sub_enq" />
                        <input id="dist1" type="hidden" name="incient[dist]">
                        <input id="tahsil1" type="hidden" name="incient[tahsil]">
                        <input id="area1" type="hidden" name="incient[area]">
                        <input id="state1" type="hidden" name="incient[state]">

                        <input type="hidden" name="104_call[cl_type]" value="<?php echo $cl_type; ?>" />
                        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
                        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
                        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">
                        <input name="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="{base_url}non_eme_calls/help_104_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                    </div>
                </div>
            </form>
        </div>
        <div id="nonright_half">
            <table id="script_table">
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>कॉलर द्वारा गवर्मेंट स्कीम से सम्बंधित जानकारी के लिए काल किया गया ! इस सम्बन्ध में हमारे द्वारा सम्बंधित जानकारी प्रदान की गई |
                    </td>
                </tr>
                <tr>
                    <td id="script_table_td">Closing Script</td>
                    <td>104 हेल्थ हेल्प लाइन मैं कॉल करने के लिए धन्यवाद ! </td>
                </tr>
            </table>
        </div>
    </div>
</div>


<script>

 var dist = $("input[name='incient_district']").val();
 var tahsil = $("input[name='incient_tahsil']").val();
 var area = $("input[name='area']").val();
 var state = $("input[name='incient_state']").val();;
//  alert(state);

//  $("#dist1").val(dist);
//  $("#tahsil1").val(tahsil);
//  $("#area1").val(area);
$("input[name='incient[dist]']").val(dist);
$("input[name='incient[tahsil]']").val(tahsil);
$("input[name='incient[area]']").val(area);
$("input[name='incient[state]']").val(state);

</script>