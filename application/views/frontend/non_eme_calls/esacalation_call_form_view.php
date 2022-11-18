<?php
$current_user_group=$this->session->userdata['current_user']->clg_group;
if($current_user_group=='UG-ERO'){
    $system="108";
 }else{
    $system="102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Escalation Call</h3> -->
    <label class="headerlbl">Escalation Call</label>
    <div id="totalnon_div">

        <div id="nonleft_half">

    <form method="post" name="complnt_call_form" id="complnt_form">

        
        <div class="width100 enquiry_summary">
    <div class="width100 form_field float_left ">
        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
        <div class="width75 float_left">
            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=<?php echo $cl_type;?>&system_type=<?php echo $system?>"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
        </div>

    </div>
    </div>
    <div class="width100 enquiry_summary">
    <div class="width100 form_field float_left">
        <div class="label blue float_left width_20">ERO Note</div>

        <div class=" float_left width75" id="ero_summary_other">
            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
        </div>
    </div>

</div>

  <div class="button_field_row  text_align_center">

            <div class="button_box enquiry_button">

                <input type="hidden" name="submit" value="sub_enq" />
                <input type="hidden" name="non_eme_call[cl_type]" value="<?php echo $cl_type;?>" />
<!--                 <input type="hidden" name="incient[call_type]" value="<?php echo $cl_type;?>" />-->
                <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
                <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
                <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">
                <input name="fwd_btn" value="FORWARD" class=" form-xhttp-request" data-href="{base_url}non_eme_calls/abuse_confirm_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">
                


            </div>

        </div>






    </form>


</div>
<div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">1. Standard Remarks Marathi</td>
                    <td>सुपरवाईझर / टीम लीडर / शिफ्ट मॅनेजर डेस्क वर कॉल ट्रान्सफर करत असल्यास त्याचे कारण इ.आर.ओ नोट मध्ये लिहून तो कॉल सुपरवाईझर / टीम लीडर / शिफ्ट मॅनेजर डेस्क ला ट्रान्सफर करावा.</td>

                </tr>
                <tr>
                    <td id="script_table_td">2. Standard Remarks Marathi</td>
                    <td>कॉलर ने वरिष्ठांशी बोलण्यासाठी इ.आर.ओ ला आग्रह केल्यास इ.आर.ओ ने सदर कॉल सुपरवाईझर डेस्क वर ट्रान्सफर करावा व त्याचे कारण इ.आर.ओ नोट मध्ये लिहावे.</td>

                </tr>-->
                 <tr>
                    <td id="script_table_td">1. Standard Remarks Hindi</td>
                    <td>यदि सुपरवाइजर/टीम लीडर/शिफ्ट मैनेजर के डेस्क पर कॉल ट्रांसफर किया जा रहा है, तो इसका कारण इ.आर.ओ नोट में लिखिये और कॉल सुपरवाइजर/टीम लीडर/शिफ्ट मैनेजर डेस्क को ट्रांसफर कर दीजिए।</td>

                </tr>
                <tr>
                    <td id="script_table_td">2. Standard Remarks Hindi</td>
                    <td>यदि कॉलर वरिष्ठ अधिकारी से बात करने का आग्रह कर रहे है, तो इ.आर.ओ ने कॉल को सुपरवाइजर के डेस्क पर ट्रांसफर करना चाहिए और इ.आर.ओ नोट में कारण लिखिये। </td>

                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>हम आपकी कॉल ....... विभाग मे ट्रांसफर कर रहे हैं ! विनती करेंगे कृपया लाइन पे बने रहे, कालॅ को ना काटे.
                    </td>
                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>आपकी शंकाओं का समाधान करने के आपके अनुरोध के अनुसार मैं आपके कॉल को हमारे वरिष्ठ अधिकारियों को स्थानांतरित कर रहा हूं। क्या आप कृपया कुछ सेकंड प्रतीक्षा कर सकते हैं?
                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>आपल्या सांगण्यानुसार मी आपला कॉल आमच्या वरिष्ठ अधिकाऱ्यांकडे ट्रान्सफर करत आहे कृपया प्रतीक्षा करू शकता का?
                    </td>
                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>आपल्या शंकेच्या निवारणा साठी आपल्या सांगण्यानुसार मी आपला कॉल आमच्या वरिष्ठ अधिकाऱ्यांकडे ट्रान्सफर करत आहे कृपया काही सेकंद प्रतीक्षा करू शकता का?
                    </td>
                </tr>-->


            </table>
        </div>
</div>
</div>