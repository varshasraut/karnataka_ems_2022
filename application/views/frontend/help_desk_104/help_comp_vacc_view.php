<div class="call_purpose_form_outer">
    <label class="headerlbl">Vaccination Related Complaint Call</label>
    <div id="totalnon_div">
        <div id="nonleft_half">
            <form method="post" name="complnt_call_form" id="complnt_form">
                <div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left">
                        <div class="label blue float_left width_20">ERO Note</div>

                        <div class=" float_left width75" id="ero_summary_other">
                            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                        <a id="tree_hours_call" class="hide click-xhttp-request float_left" data-href="{base_url}calls/last_three_hour_call_listing" data-qr="output_position=last_tree_hour_incident&showprocess=no&module_name=calls&amp;tlcode=MT-AGENTS-LOGIN-LIST"></a>

                    </div>
                </div>
                <div class="button_field_row  text_align_center">
                <div class="button_box enquiry_button">
                        <input type="hidden" name="submit" value="sub_enq" />
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

                <!-- <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉलर द्वारा दी गई जानकारी पिछली आईडी से मिलती है, तो इ.आर.ओ को कॉलर से जानकारी जांच कर कॉलर को सूचित करना चाहिए। </td>

                </tr> -->

                <!-- <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>हम जाँच कर रहे हैं, इससे पहले भी इस घटना की सूचना देने के लिए 108 संजीवनी पर कॉल किया गया था और हमने आपके __ (मरीज का नाम) __ के लिए एक एम्बुलेंस __ (स्थान) __ पर भेज दी है, एम्बुलेंस टीम तब बुलाएगी जब एम्बुलेंस घटनास्थल के पास होगी। .
                    </td>
                </tr> -->


            </table>
        </div>
    </div>
</div>
<script>
    setTimeout(function(){ 
            $("#tree_hours_call").click(); 
        
    },100);
</script>