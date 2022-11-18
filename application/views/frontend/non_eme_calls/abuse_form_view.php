<div class="call_purpose_form_outer">

    <!-- <h3>Abuse Call</h3> -->
    <label class="headerlbl">Abuse Call</label>
    <div id="totalnon_div">

        <div id="nonleft_half">
            <form method="post" name="complnt_call_form" id="complnt_form">


                <div class="width100 enquiry_summary">
                    <div class="width100 form_field float_left ">
                        <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width75 float_left">
                            <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2" data-href="{base_url}auto/get_ero_standard_summary?call_type=<?php echo $cl_type; ?>" placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8">
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
                        <input name="fwd_btn" value="SAVE" class=" form-xhttp-request" data-href="{base_url}non_eme_calls/abuse_confirm_save" data-qr="output_position=summary_div" type="button" tabindex="13" autocomplete="off">


                    </div>

                </div>
            </form>
        </div>
        <div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>कॉलर ने अपशब्द / अयोग्य भाषेचा वापर केल्यास कॉलर ला वॉर्निंग देऊन कॉल डिस्कनेक्ट करावा.</td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉलर गाली-गलौज या फिर अनुचित भाषा का प्रयोग करता है, तो कॉलर को चेतावनी देकर कॉल डिस्कनेक्ट कर दीजिये। </td>

                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>1) हम आपको बताना चाहेंगे के आपने यह कॉल 108 संजीवनी मध्य प्रदेश  आपात्कालीन एम्बुलेंस  सेवांओ मे किया हैं ! आपसे विनती होगी, के आप गलत भाषा का उपयोग ना करे तथा गाली-गलोच ना करे, अन्यथा हमे आपकी कॉल काटनी होगी. क्षमा चाहते हैं! <br>
                       <br> 2) आपसे अनुरोध करने के बावजूद भी आप गलत भाषाका उपयोग कर रहे हैं! इस कारण हमे यह कॉल काटनी होगी. 108 संजीवनी मे कॉल करने के लिए धन्यवाद !
                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>1) आम्ही आपणास कळवू इच्छितो की आपला कॉल 108 महाराष्ट्र आपत्कालीन रुग्णवाहिका सेवेमध्ये आलेला आहे. आपणास विनंती आहे की अपशब्दांचा वापर किव्हा गैरवर्तन करू नका, अन्यथा आम्हाला आपला कॉल डिस्कनेक्ट करावा लागेल. <br>
                        2) आपल्या कडून उचित प्रतिसाद येत नसल्यामुळे मला आपला कॉल डिस्कनेक्ट करावा लागत आहे.
                    </td>
                </tr>-->


            </table>
        </div>
    </div>

</div>
<style>

</style>