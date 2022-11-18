<?php
$current_user_group = $this->session->userdata['current_user']->clg_group;
if ($current_user_group == 'UG-ERO') {
    $system = "108";
} else {
    $system = "102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Suggestion Call</h3> -->
    <label class="headerlbl">Suggestion Call</label>
    <div id="totalnon_div">

        <div id="nonleft_half">

            <form method="post" name="complnt_call_form" id="complnt_form">
                <!--
       <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
        
        <input type="hidden" name="incient[inc_type]" id="inc_type" value="NON_EME_CALL">-->


                <div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2" data-href="{base_url}auto/get_ero_standard_summary?call_type=<?php echo $cl_type; ?>&system_type=<?php echo $system ?>" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8">
                        </div>

                    </div>
                    </div>
                    <div class="width100 enquiry_summary">
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
                        <input type="hidden" name="non_eme_call[cl_type]" value="<?php echo $cl_type; ?>" />
                        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
                        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
                        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">
                        
                        <input name="fwd_btn" value="FORWARD TO GRIEVANCE" class=" accept_btn form-xhttp-request" data-href="{base_url}non_eme_calls/abuse_confirm_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">


                    </div>

                </div>






            </form>


        </div>
        <div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>कॉलर ने १०८ च्या सेवेमध्ये फेरबदल संबंधित सल्ला देण्यासाठी कॉल केल्यास तो कॉल Grievance डेस्क ला सांगून तो कॉल ट्रान्सफर करावा.</td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standards Remarks Hindi</td>
                    <td>यदि कॉलर 108 संजीवनी सेवा के संशोधनों या नियोजन पर सलाह देने के लिए कॉल करता है, तो यह कॉल ग्रीवन्स डेस्क को सूचित कर कॉल को ट्रांसफर करें। </td>

                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>स्क्रिप्ट:-
                        आपला सल्ला/ फीडबॅक आमच्यासाठी महत्वाचा आहे. याची नोंद घेण्यासाठी मी आपला कॉल आमच्या संबंधित विभागाकडे ट्रान्सफर करत आहे तरी काही सेकंद मी आपला कॉल होल्ड वर ठेवू शकते का?
                        <br>
                        कृती :-
                        वरील प्रमाणे कॉल आल्यास कॉल ग्रीविव्हन्स डेस्क ला ट्रान्सफर करावा.

                    </td>
                </tr>-->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>स्क्रिप्ट:- आपकी सलाह/प्रतिक्रिया हमारे लिए महत्वपूर्ण है। मैं इस पर ध्यान देने के लिए आपके कॉल को हमारे संबंधित विभाग में स्थानांतरित कर रहा हूं, लेकिन क्या मैं आपकी कॉल को कुछ सेकंड के लिए होल्ड पर रख सकता हूं?<br>
                   <br> विधि:- उपरोक्त कॉल की स्थिति में कॉल को ग्रीवेंस डेस्क पर ट्रांसफर कर देना चाहिए।

                    </td>
                </tr>


            </table>
        </div>
    </div>
    
</div>

<style>
    .accept_btn{
        position: none !important;
        margin-left: 120px !important;
    }
</style>