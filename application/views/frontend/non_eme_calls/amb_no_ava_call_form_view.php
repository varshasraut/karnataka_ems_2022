<div class="call_purpose_form_outer">

    <!-- <h3>Caller Denied Ambulance call</h3> -->
    <label class="headerlbl">Caller Denied Ambulance call</label>
    <div id="totalnon_div">

<div id="nonleft_half">

    <form method="post" name="complnt_call_form" id="complnt_form">
  
        <div class="width100 enquiry_summary">
    <div class="width100 form_field float_left ">
        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
        <div class="width75 float_left">
            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=<?php echo $cl_type;?>"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
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
                 <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
                <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
             <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">
             <input name="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="{base_url}non_eme_calls/abuse_confirm_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">


            </div>

        </div>






    </form>


</div>
<div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>कॉलर ने कॉल केला असता घटनास्थळा पासून जवळील ऍम्ब्युलन्स उपलब्ध नसल्याने, लांबची/दूरवरची ऍम्ब्युलन्स पाठवली जाऊ शकते हे सांगितल्यानंतर कॉलर ने ऍम्ब्युलन्स साठी नकार दिल्यास हा कॉल टाईप निवडावा.</td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>घटनास्थल से निकटतम/नजदिकी एम्बुलेंस उपलब्ध नहीं है, पर कुछ दूरी से एम्बुलेंस भेजी जा सकती है यह बताए जाने के बाद कॉलर ने एम्बुलेंस के लिए मना कर दिया, तो इस कॉल प्रकार का चयन करिये|</td>

                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>स्क्रिप्ट: - हम आपको सूचित करना चाहते हैं कि घटनास्थल से निकटतम एम्बुलेंस दूसरे रोगी को भेज दी गई है और निकटतम एम्बुलेंस ---- किमी है और इसे पहुंचने में लगभग --- समय लग सकता है लेकिन यह समय निर्भर करता है यातायात की स्थिति। क्या आप रुकने के लिए तैयार हैं?<br>
                    <br>विधि: - यदि कॉल करने वाला हाँ में उत्तर देता है तो एक एम्बुलेंस भेजें और प्रेषण के लिए उपयुक्त कॉल प्रकार का चयन करें।<br>
                    <br>क्रिया: - यदि कॉलर उत्तर नहीं देता है, तो इस कॉल प्रकार का चयन करें।
                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>स्क्रिप्ट:- आम्ही आपणास सांगू इच्छितो, घटनस्थळा पासून जवळच्या ऍम्ब्युलन्स दुसऱ्या पेशंट करिता पाठविलेल्या आहेत व आपणापासून जवळची ऍम्ब्युलन्स हि ----KM आहे व पोहोचण्यासाठी अंदाजे --- वेळ लागू शकतो तरी हा वेळ रहदारी व ट्रॅफिक कंडिशन वर अवलंबून आहे. आपण थांबण्यास तैयार आहात का?<br>
                    <br>कृती:- जर कॉलर चे उत्तर हो असल्यास ऍम्ब्युलन्स पाठवून द्यावी व डिस्पॅच साठी चा योग्य तो कॉल टाईप निवडावा. <br>
                    <br>कृती:- जर कॉलर चे उत्तर नाही असल्यास हा कॉल टाईप निवडावा.
                    </td>
                </tr>-->
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>स्क्रिप्ट:- आम्ही आपणास सांगू इच्छितो, घटनस्थळा पासून जवळच्या ऍम्ब्युलन्स दुसऱ्या पेशंट करिता पाठविलेल्या आहेत व आपणापासून जवळची ऍम्ब्युलन्स हि ----KM आहे व पोहोचण्यासाठी अंदाजे --- वेळ लागू शकतो तरी हा वेळ रहदारी व ट्रॅफिक कंडिशन वर अवलंबून आहे. आपण थांबण्यास तैयार आहात का?<br>
                    <br>कृती:- जर कॉलर चे उत्तर हो असल्यास ऍम्ब्युलन्स पाठवून द्यावी व डिस्पॅच साठी चा योग्य तो कॉल टाईप निवडावा. <br>
                    <br>कृती:- जर कॉलर चे उत्तर नाही असल्यास हा कॉल टाईप निवडावा.
                    </td>
                </tr>-->


            </table>
        </div>
</div>
</div>