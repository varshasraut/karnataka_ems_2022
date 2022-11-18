<div class="call_purpose_form_outer">
    <label class="headerlbl">Other Complaint Call</label>
    <div id="totalnon_div">
        <div id="nonleft_half">
            <form method="post" name="complnt_call_form" id="complnt_form">
                <div class="width100 form_field float_left">
                <div class="width100 form_field float_left margin_top_10">
                <div class="label blue width_20 float_left">Complaint Type <span class="md_field">*</span>&nbsp;
                    </div>
                    <div class="input width75 float_left">
                        <select name="incient[help_complaint_type]" class="filter_required" data-errors="{filter_required:'Complaint should not blank'}"  TABINDEX="1.1">
                            <option value="">Select Complaint</option>
                            <?php
                            foreach ($get_other_cmp_type as $cmp_amp) { ?>

                                <option value="<?php echo $cmp_amp->cmp_id; ?>"><?php echo $cmp_amp->cmp_name; ?></option>
                                
                                <?php }  ?>
                        </select>
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
                    </div>
            </form>
        </div>
        <div id="nonright_half">
            <table id="script_table">

                 <tr>
                    <td id="script_table_td">Complaint Call Holding Script</td>
                    <td>आपकी जानकारी के लिए क्या मैं आपकी कॉल को कुछ समय के लिए होल्ड कर सकता हूँ /कर सकती हूँ। </td>

                </tr> 

                <tr>
                    <td id="script_table_td">Un-hold Script</td>
                    <td>लाइन पर बने रहने के लिए धन्यवाद , आपकी शिकायत दर्ज कर ली गई हैं, आप शिकायत नंबर लिख लीजिये, आप शिकायत की जानकारी के लिए 104 पर कॉल करके शिकायत नंबर के माध्यम से शिकायत सम्बंधित जानकारी ले सकते हैं !
                    </td>
                </tr> 

                <tr>
                    <td id="script_table_td">Closing Script</td>
                    <td>104  हेल्थ हेल्प लाइन मैं कॉल करने के लिए धन्यवाद !
                    </td>
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
