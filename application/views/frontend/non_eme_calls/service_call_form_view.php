<?php
$current_user_group = $this->session->userdata['current_user']->clg_group;
if ($current_user_group == 'UG-ERO') {
    $system = "108";
} else {
    $system = "102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Service Not required Call</h3> -->
    <label class="headerlbl">Service Not required Call</label>
    <div id="totalnon_div">

        <div id="nonleft_half">

            <form method="post" name="complnt_call_form" id="complnt_form">
                <!--
       <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
        
        -->
                <input type="hidden" name="incient[inc_type]" id="inc_type" value="SERVICE_NOT_REQUIRED">
                <input type="hidden" name="cl_purpose" value="SERVICE_NOT_REQUIRED" data-base="search_btn">

                <div class="inline_fields width100" id="inc_filters">

                    <div class="form_field width20">

                        <div class="label">Incident Id</div>

                        <input value="<?php echo date('Ymd'); ?>" name="inc_id" tabindex="7" id="cinc_id" class="form_input inc_id_filt" placeholder="Incident Id" type="text" data-base="search_btn">

                    </div>

                    <div class="form_field width20">

                        <div class="label">Mobile Number</div>

                        <div class="input">

                            <input name="clr_mobile" tabindex="8" class="form_input filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[11]" data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.'}" placeholder="Mobile Number" type="text" data-base="search_btn">
                        </div>

                    </div>

                    <div class="form_field width20">

                        <div class="label">Incident District</div>


                        <input name="inc_district" tabindex="9" class="form_input mi_autocomplete" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="Incident District" type="text" data-base="search_btn" data-nonedit="yes">


                    </div>

                    <div class="form_field width20">

                        <div class="label">Date of Incident

                            <!--            <span class="md_field">*</span>-->
                        </div>

                        <div class="input">

                            <input name="inc_date" tabindex="10" class="form_input filter_if_not_blank  mi_calender filter_date inc_date_filt" placeholder="YYYY-MM-DD" type="text" data-errors="{filter_required:'Incident date should not be blank',filter_date:'Date format is not valid'}" data-base="search_btn">

                        </div>

                    </div>

                    <div class="form_field width20">

                        <div class="label">Time Of Incident
                            <!--            <span class="md_field">*</span>-->
                        </div>

                        <div class="input">

                            <input name="inc_time" tabindex="11" class="mi_autocomplete filter_if_not_blank filter_time inc_time_filt" placeholder="12 AM-12 PM" type="text" data-href="{base_url}auto/get_tinterval" data-errors="{filter_required:'Plase select time from dropdown list',filter_time:'Time format is not valid'}" data-base="search_btn" data-autocom="yes">

                        </div>

                    </div>
                    <div class="form_field width_30">
                        <label for="">&nbsp;</label>
                    </div>

                    <div class="form_field width_20" style="display: flex;">

                        <div class="label">&nbsp;</div>
                        <input name="reset_filter" tabindex="12" value="RESET FILTER" class=" click-xhttp-request  width100 float_right" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details&filter=true" type="reset" style="font-weight: bold; margin-top: 5px;">
                    </div>
                    <div class="form_field width_15 ml-3" style="display: flex;">
                        <input name="search_btn" tabindex="12" value="SEARCH" class=" base-xhttp-request  width100" data-href="{base_url}patients/pt_inc_list" data-qr="output_position=inc_details" type="button" style="padding: 5px !important;">



                    </div>


                </div>

                <div id="inc_details">


                </div>

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
                        <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">

                        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">
                        <!--             <input name="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="{base_url}non_eme_calls/abuse_confirm_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">-->

                        <div id="fwdcmp_btn">


                        </div>

                    </div>

                </div>






            </form>


        </div>
        <div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>Scenario 1:-
                        जर कॉलर ने आधी मागवलेली ऍम्ब्युलन्स नको असल्याचे १०८ ला कळवले तर इ.आर.ओ ने आधीच्या आयडी ची माहिती तपासून संबंधित माहिती ऍम्ब्युलन्स टीम ला कळवावी. <br>
                        <br> Scenario 2:-
                        जर हीच माहिती दुसऱ्या वक्ती कडून (दुसऱ्या नंबर वरून) १०८ ला कळवण्यात आली तर इ.आर.ओ ने आधीच्या आयडी ची माहिती तपासून ऍम्ब्युलन्स पाठवलेल्या नंबर वर कॉल करून पडताळणी करून संबंधित माहिती ऍम्ब्युलन्स टीम ला कळवावी व याची नोंद इ.आर.ओ नोट मध्ये करून हा कॉल सुपरवाईझर / टीम लीडर / शिफ्ट मॅनेजर यांस कळवावा.

                    </td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>Scenario 1:-
                        यदि कॉलर ने 108 संजीवनी को सूचित किया है कि अब कॉलर को पहले बुलाई गई एम्बुलेंस की आवश्यकता नहीं है, तो इ.आर.ओ को पिछली आईडी की जानकारी की जांच कर संबंधित जानकारी एम्बुलेंस टीम को देनी चाहिए। <br>
                        <br> Scenario 2:-
                        यदि वही जानकारी किसी अन्य व्यक्ति (दूसरे नंबर से) 108 संजीवनी को सूचित करता है, तो इ.आर.ओ को पिछली आईडी की जानकारी जांच कर, पहले एम्बुलेंस के लिए कॉल आये हुए नंबर पर कॉल करना चाहिए जानकारी जांच कर संबंधित जानकारी एम्बुलेंस टीम को देनी चाहिए और इस कॉल की जानकारी सुपरवाईझर / टीम लीडर / शिफ्ट मॅनेजर बताकर इसे इ.आर.ओ नोट में रिकॉर्ड करें.

                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>Scenario 1:- <br>
                        <br> Probing:-
                        याच्या आधी आपण __(पेशंट चे नाव) साठी __ (लोकेशन)__ला ऍम्ब्युलन्स मागविण्यासाठी कॉल केला होता, आता आपणास ऍम्ब्युलन्स ची आवश्यकता आहे का? <br>
                        <br> (जर कॉलर चे उत्तर नाही असल्यास/ कॉलर ला ऍम्ब्युलन्स ची आवश्यकता नसल्यास) <br>
                        <br>कॉलर ला वापरायची स्क्रिप्ट:-
                        ठीक आहे सर/ मॅडम (कॉलर चे नाव घेऊन) भविष्यात जर आपणास ऍम्ब्युलन्स ची आवश्यकता असल्यास १०८ ला पुन्हा कॉल करावा. <br>
                        <br>
                        ऍम्ब्युलन्स टीम ला वापरायची स्क्रिप्ट:-
                        नमस्ते ईमसओ / पायलट सर, मॅम, आपणास एक आयडी मिळाला होता (आयडी,पेशन्ट चे नाव, लोकेशन सांगावा) . कॉलर ने ऍम्ब्युलन्स साठी मनाई केलेली आहे. <br>
                        <br>Scenario 2) :-
                        जर वरील माहिती कॉलर ने दुसऱ्या नंबर वरून १०८ ला कळवल्यास आली तर- <br>
                        <br>Probing:-
                        या आधी ऍम्ब्युलन्स मागविण्यासाठी ज्या नंबर वरून कॉल केला होता तो नंबर सांगू शकाल का? <br>
                        <br>कृती:-
                        (कॉलर ने नंबर दिल्यास कॉलर हिस्टरी टॅब मध्ये कॉलर ने सांगितलेला नंबर टाकावा) <br>
                        <br>नंबर माहित नसल्यास – <br>
                        <br>Probing:-
                        • पेशंट जिथे आहे तिथला जिल्हा सांगू शकाल का? <br>
                        • मला आपल्या पेशंट चे नाव व त्यांना सध्या काय त्रास होत आहे सांगू शकाल का? <br>
                        <br>कृती :-
                        कॉलर ने सांगितलेल्या माहितीनुसार कॉलर हिस्टरी किव्हा सिंगल रेकॉर्ड टॅब चा वापर करून कॉलर ला पुढील माहिती देणे. <br>
                        <br>स्क्रिप्ट:-
                        माहिती पडताळल्याबद्दल धन्यवाद. तुम्ही सांगितलेली माहिती आम्ही आमच्या ऍम्ब्युलन्स टीम ला कळवतो काही सेकंद मी आपला कॉल प्रतीक्षेत ठेवू शकते का? <br>
                        <br>कृती :-
                        ज्या नंबर वरून ऍम्ब्युलन्स साठी कॉल आला होता त्या नंबर वर कॉल करावा— <br>
                        <br>स्क्रिप्ट:-
                        नमस्ते सर/ मॅम (कॉलर चे नाव घेऊन) आपण (पेशंट चे नाव) करिता ऍम्ब्युलन्स साठी १०८ ला कॉल केला होता, सध्या हि आपल्याला ऍम्ब्युलन्स ची आवश्यकता आहे का ? (जर कॉलर ने नाही म्हणल्यास) तुम्ही ऍम्ब्युलन्स नको असल्याचे १०८ ला कळविण्यासाठी कुणाला सांगितले होते का ? (जर कॉलर चे उत्तर हो असल्यास) ठीक आहे सर/ मॅम भविष्यात जर आपणास ऍम्ब्युलन्स ची आवश्यकता असल्यास १०८ ला पुन्हा कॉल करावा. <br>
                        <br>कृती :-
                        पहिल्या / आधीच्या कॉलर ला अनहोल्ड वर करून --- <br>
                        <br>स्क्रिप्ट:-
                        प्रतीक्षा केल्या बद्दल धन्यवाद सर, मॅम (कॉलर चे नाव घेऊन) आपण सांगितलेली माहिती आम्ही ऍम्ब्युलन्स टीम ला कळवली आहे, आपण दिलेल्या माहिती बद्दल धन्यवाद. भविष्यात जर आपणास ऍम्ब्युलन्स ची आवश्यकता असल्यास १०८ ला पुन्हा कॉल करावा. <br>











                    </td>
                </tr>-->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>Scenario 1:- <br>
                        <br>Probing:- पहले आपने एम्बुलेंस को कॉल करने के लिए __ (मरीज का नाम) के लिए __ (स्थान) __ पर कॉल किया था, अब क्या आपको एम्बुलेंस की आवश्यकता है?
    (यदि कॉल करने वाला उत्तर नहीं देता/कॉल करने वाले को एम्बुलेंस की आवश्यकता नहीं है)
    <br> कॉलर का उपयोग करने के लिए स्क्रिप्ट: - ठीक है सर / मैडम (कॉल करने वाले का नाम लेते हुए) यदि आपको भविष्य में एम्बुलेंस की आवश्यकता है, तो फिर से 108 संजीवनी पर कॉल करें।<br>
                            <br>कॉलर का उपयोग करने के लिए स्क्रिप्ट: - 
                            ठीक है सर / मैडम (कॉल करने वाले का नाम लेते हुए) यदि आपको भविष्य में एम्बुलेंस की आवश्यकता है, तो फिर से 108 पर कॉल करें।<br>
                        <br>
                        एम्बुलेंस टीम के लिए उपयोग की जाने वाली स्क्रिप्ट: - नमस्ते ई.एम.टी / पायलट सर, महोदया, आपको एक आईडी (आईडी, रोगी का नाम, स्थान) मिला है। कॉल करने वाले को एम्बुलेंस के लिए प्रतिबंधित किया गया है
                         <br>Scenario 2) :-
                         यदि उपरोक्त जानकारी फोन करने वाले को दूसरे नंबर से 108 संजीवनी पर प्राप्त होती है-<br>
                        <br>Probing:- क्या आप मुझे वह नंबर बता सकते हैं जिससे आपने पहले एम्बुलेंस को कॉल करने के लिए कॉल किया था?<br>
                        <br>विधि:- (यदि कॉलर नंबर देता है, तो कॉलर हिस्ट्री टैब में कॉलर द्वारा दिया गया नंबर दर्ज करें)<br>
                        <br>यदि आप संख्या नहीं जानते हैं <br>
                        <br>Probing:- • क्या आप बता सकते हैं कि मरीज किस जिले का है?
क्या आप मुझे अपने मरीज का नाम बता सकते हैं और उन्हें अभी क्या परेशान कर रहा है?
<br>
                        <br>क्रिया: - कॉलर द्वारा प्रदान की गई जानकारी के अनुसार कॉलर हिस्ट्री या सिंगल रिकॉर्ड टैब का उपयोग करके कॉलर को और जानकारी प्रदान करना।<br>स्क्रिप्ट:-
                        स्क्रिप्ट: - जानकारी को सत्यापित करने के लिए धन्यवाद। हम आपकी जानकारी को हमारी एम्बुलेंस टीम को रिपोर्ट करते हैं। क्या मैं आपके कॉल के लिए कुछ सेकंड प्रतीक्षा कर सकता हूं? <br>
                        <br>कार्रवाई:- जिस नंबर से एम्बुलेंस के लिए कॉल आई थी उस नंबर पर कॉल करें।<br>
                        <br>स्क्रिप्ट:- हेलो सर/मैम (कॉलर का नाम लेते हुए) आपने (मरीज का नाम) एम्बुलेंस के लिए 108 संजीवनी पर कॉल किया था, क्या अब आपको एम्बुलेंस की जरूरत है? (यदि कॉल करने वाला कहता है कि नहीं) क्या आपने किसी को 108 संजीवनी को बताने के लिए कहा था कि आपको एम्बुलेंस नहीं चाहिए? (यदि कॉल करने वाले का उत्तर हाँ है) ठीक है महोदय/भविष्य में यदि आपको एम्बुलेंस की आवश्यकता हो तो 108 संजीवनी को फिर से कॉल करें।<br>कृती :-
                        पहले / पिछले कॉलर को अनहुक किया ---<br>
                        <br>स्क्रिप्ट:- प्रतीक्षा करने के लिए धन्यवाद महोदया (कॉलर का नाम लेते हुए) हमने आपके द्वारा दी गई जानकारी की एम्बुलेंस टीम को सूचित कर दिया है, आपके द्वारा दी गई जानकारी के लिए धन्यवाद। यदि आपको भविष्य में एम्बुलेंस की आवश्यकता हो, तो फिर से 108 संजीवनी पर कॉल करें।</td>
                </tr>


            </table>
        </div>
    </div>
</div>