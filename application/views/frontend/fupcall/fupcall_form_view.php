<?php
$current_user_group = $this->session->userdata['current_user']->clg_group;
if ($current_user_group == 'UG-ERO') {
    $system = "108";
} else {
    $system = "102";
}
?>


<div class="call_purpose_form_outer">

    <!-- <h3>Follow up Call</h3> -->
    <label class="headerlbl">Follow up Call</label>
    <div id="totalnon_div">

        <div id="nonleft_half">


            <form method="post" name="followup_call_form" id="followup_call_form">

                <input type="hidden" name="cl_purpose" id="cl_purpose" value="<?php echo $cl_purpose; ?>" data-base="search_btn">

                <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

                <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

                <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

                <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

                <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">

                <input type="hidden" name="incient[inc_type]" id="inc_type" value="FOLL_CALL">
                <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">

                <div id="inc_filters">


                </div>


                <div id="inc_details">


                </div>

                <div class="width100 enquiry_summary display_inlne_block">
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2" data-href="{base_url}auto/get_ero_standard_summary?call_type=FOLL_CALL&system_type=<?php echo $system ?>" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8">
                        </div>

                    </div>
                </div>
                <div class="width100 enquiry_summary display_inlne_block">
                    <div class="width100 form_field float_left">
                        <div class="label blue float_left width_20">ERO Note</div>

                        <div class=" float_left width75" id="ero_summary_other">
                            <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600" data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>

                </div>
                <div class="width10 margin_auto" style="margin-bottom: 20px; height: 50px;">



                    <div id="fwdcmp_btn" class="beforeunload ">
                    </div>

                </div>

            </form>


        </div>
        <div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>कॉलर ने आधी केलेल्या कॉल चा आढावा घेण्यासाठी / विचारणा करण्यासाठी / कॉल केल्यास हा कॉल टाईप निवडून आधीचा आयडी इ.आर.ओ नोट मध्ये लिहावा (Eg.आधी मागवलेली ऍम्ब्युलन्स कुठपर्यंत आलेली आहे हे माहिती करून घेण्यासाठी कॉल केल्यास त्या आय डी ची माहिती तपासून कॉलर ला माहिती द्यावी त्याची नोंद इ.आर.ओ नोट मध्ये करावी) </td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉलर पिछली कॉल की पूछताछ करना चाहता है, तो इस कॉल प्रकार का चयन करें और इ.आर.ओ नोट में पिछली आईडी लिखें। (उदाहरण के लिए, यदि आप यह पता लगाने के लिए कॉल करते हैं कि पहले से बुलाई गई एम्बुलेंस कहाँ आई है, तो आईडी की जाँच करें और कॉलर को सूचित करें और इसे इ.आर.ओ नोट में रिकॉर्ड करें).</td>

                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>Scenarion 1:- क्या आपने पहले भी इसी नंबर से कॉल किया है? (यदि हां, तो निम्न स्क्रिप्ट का उपयोग करें)<br>
                        <br>Probing:- मैं आपकी जानकारी की जाँच कर रहा हूँ, क्या आपके मरीज का नाम (-) है? क्या आपको (- स्थान--) यहाँ एम्बुलेंस की आवश्यकता थी?<br>
                        <br>Thanking Statement:- जानकारी की पुष्टि के लिए धन्यवाद।<br>
                        <br>स्क्रिप्ट: - मैं आपको बताना चाहूंगा कि आपके मरीज (_बेस लोकेशन नेम_) को यहां से एक एम्बुलेंस भेजी गई है। आप नंबर पर कॉल करके पूछ सकते हैं कि एम्बुलेंस कहां से आई है। एक लिंक है और आप देख सकते हैं कि कहां है उस पर क्लिक करके एम्बुलेंस आ गई है।<br>
                        <br>Scenarion 2:- क्या आपने पहले इस नंबर से कॉल किया है? (यदि नहीं, तो कॉलर से और जानकारी देखें) <br>
                        <br>Probing:- क्या आप मुझे वह नंबर बता सकते हैं जिससे पहले एम्बुलेंस के लिए कॉल किया गया था?<br>
                        <br>विधि:- (यदि कॉल करने वाला नंबर देता है तो कॉलर हिस्ट्री टैब में कॉलर द्वारा दिया गया नंबर दर्ज करें और जानकारी सत्यापित करें।
                        scenario 1 follow करना चाहिए.)
                        <br>
                        <br>स्क्रिप्ट:- मैं आपको सूचित करना चाहूँगा कि यहाँ से आपके रोगी (_आधार स्थान का नाम_) के लिए एक एम्बुलेंस भेजी गई है। आप नंबर पर कॉल करके पूछ सकते हैं कि एम्बुलेंस कितनी दूर आ गई है। आप क्लिक करके देख सकते हैं कि एम्बुलेंस कहाँ आई है लिंक पर।<br>
                        <br>यदि आप संख्या नहीं जानते हैं <br>
                        <br>जांच:- क्या आप जिले को बता सकते हैं कि मरीज कहां है? क्या आप मुझे अपने मरीज का नाम बता सकते हैं और उन्हें अभी क्या परेशान कर रहा है?<br>
                        <br>क्रिया:- कॉल करने वाले द्वारा दी गई जानकारी के अनुसार रिकॉर्ड ढूंढे और कॉल करने वाले को आगे की जानकारी दें<br>
                        <br>Thanking Statement:- जानकारी की पुष्टि के लिए धन्यवाद <br>
                        <br>स्क्रिप्ट:- मैं आपको बताना चाहूँगा की यहाँ से आपके मरीज (base location name) को एम्बुलेंस भेजी गई है क्या आप खुद उस नंबर पर है
आप कॉल करके पूछ सकते हैं कि एम्बुलेंस कितनी दूर आ गई है। आप ऊपर दिए गए लिंक पर क्लिक करके देख सकते हैं कि एम्बुलेंस कहाँ है।





                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>Scenarion 1:- आपण या आधी याच नंबर वरून कॉल केला होता का?
                        (जर हो तर पुढील स्क्रिप्ट चा वापर करावा)<br>
                        <br>Probing:-
                        मी आपली माहिती चेक करत आहे, आपल्या पेशंट चे नाव (--) आहे का?
                        आपण (--लोकेशन--) इथे ऍम्ब्युलन्स हवी होती का? <br>
                        <br>Thanking Statement:-
                        माहिती पडताळल्याबद्दल धन्यवाद.<br>
                        <br>स्क्रिप्ट:-
                        मी आपणास सांगू इच्छितो आपल्या पेशंट करिता (_बेस लोकेशन चे नाव_) इथून ऍम्ब्युलन्स पाठवण्यात आलेली आहे, तरी ऍम्ब्युलन्स आपल्या जवळ पास आली कि ऍम्ब्युलन्स मधील सरांचा आपणास कॉल येईन व तसेच आपल्या नंबर वर एक मॅसेज आला आहे त्यामध्ये ऍम्ब्युलन्स मधील टीम चा नंबर आहे आपण स्वतः त्या नंबर वर कॉल करून ऍम्ब्युलन्स कुठं पर्यंत आलेली आहे हे विचारू शकता./ एक लिंक आहे त्या वरती क्लिक करून आपण स्वतः ऍम्ब्युलन्स कुठं पर्यंत आलेली आहे हे बघू शकता. <br>
                        Scenarion 2:- आपण या आधी याच नंबर वरून कॉल केला होता का ?
                        (जर नाही तर कॉलर कडून पुढील माहिती तपासून घ्यावी)
                        <br>
                        <br>Probing:-
                        या आधी ऍम्ब्युलन्स साठी ज्या नंबर वरून कॉल केला होता तो नंबर सांगू शकाल का? <br>
                        <br>कृती:-
                        (कॉलर ने नंबर दिल्यास कॉलर हिस्टरी टॅब मध्ये कॉलर ने सांगितलेला नंबर टाकावा व माहिती पडताळून scenario 1 follow करावा.)<br>
                        <br>स्क्रिप्ट:-
                        मी आपणास सांगू इच्छितो आपल्या पेशंट करिता (_बेस लोकेशन चे नाव_) इथून ऍम्ब्युलन्स पाठवण्यात आलेली आहे, तरी ऍम्ब्युलन्स आपल्या जवळ पास आली कि ऍम्ब्युलन्स मधील सरांचा आपणास कॉल येईन व तसेच आपल्या नंबर वर एक मॅसेज आला आहे त्यामध्ये ऍम्ब्युलन्स मधील टीम चा नंबर आहे आपण स्वतः त्या नंबर वर कॉल करून ऍम्ब्युलन्स कुठं पर्यंत आलेली आहे हे विचारू शकता./ एक लिंक आहे त्या वरती क्लिक करून आपण स्वतः ऍम्ब्युलन्स कुठं पर्यंत आलेली आहे हे बघू शकता. <br>
                        <br>2.1) नंबर माहित नसल्यास – <br>
                        <br>Probing:-
                        पेशंट जिथे आहे तिथला जिल्हा सांगू शकाल का?
                        मला आपल्या पेशंट चे नाव व त्यांना सध्या काय त्रास होत आहे सांगू शकाल का? <br>
                        <br>कृती:-
                        कॉलर ने सांगितलेल्या माहितीनुसार रेकॉर्ड शोधून कॉलर ला पुढील माहिती देणे. <br>
                        <br>Thanking Statement:-
                        माहिती पडताळल्याबद्दल धन्यवाद. <br>
                        <br>स्क्रिप्ट:-
                        मी आपणास सांगू इच्छितो आपल्या पेशंट करिता (_बेस लोकेशन चे नाव_) इथून ऍम्ब्युलन्स पाठवण्यात आलेली आहे, तरी ऍम्ब्युलन्स आपल्या जवळ पास आली कि ऍम्ब्युलन्स मधील सरांचा आपणास कॉल येईन व तसेच आपल्या नंबर वर एक मॅसेज आला आहे त्यामध्ये ऍम्ब्युलन्स मधील टीम चा नंबर आहे आपण स्वतः त्या नंबर वर कॉल करून ऍम्ब्युलन्स कुठं पर्यंत आलेली आहे हे विचारू शकता. / एक लिंक आहे त्या वरती क्लिक करून आपण स्वतः ऍम्ब्युलन्स कुठं पर्यंत आलेली आहे हे बघू शकता.





                    </td>
                </tr>-->


            </table>
        </div>
    </div>
</div>