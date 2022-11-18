<?php
$current_user_group=$this->session->userdata['current_user']->clg_group;
if($current_user_group=='UG-ERO'){
    $system="108";
 }else{
    $system="102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Child  Call</h3> -->
    <label class="headerlbl">Child  Call</label>
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
                    <td>लहान मूल कॉल वर असल्यास ERO ने मोढ्या व्यक्ती कडे (जो माहिती देऊ शकतो) फोन देण्यास सांगावे आणि जर कुणी उपलब्ध नसल्यास कॉलर ला १०८ सर्विस ची माहिती व वॉर्निंग स्टेटमेंट वापरून कॉल क्लोज़िंग स्क्रिप्ट देऊन संपवावा. </td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉल पर बच्चा है, तो इ.आर.ओ को वयस्क व्यक्ती (जो जानकारी प्रदान कर सकता है) को फोन देने के लिए कहना चाहिए और यदि कोई उपलब्ध नहीं है, तो कॉलर को 108 संजीवनी सेवा कि  सूचना और चेतावनी देकर कॉल क्लोजिंग स्क्रिप्ट के देकर कॉल समाप्त करिये| </td>

                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>स्क्रिप्ट:- विनंती आहे आपण आमचं बोलणं कोणी मोठ्या व्यक्तीशी करून द्या जो आम्हास माहिती देऊ शकतो.<br>
                    <br>कृती:- जर कुणी उपलब्ध नसेन तर कॉलर ला पुढील स्क्रिप्ट सांगावी. <br> 
                    <br>स्क्रिप्ट:- आम्ही आपणास सांगू इच्छितो कि आपला कॉल १०८ ऍम्ब्युलन्स सेवे मध्ये आलेला आहे, आपणास विनंती आहे आपत्कालीन परिस्तिथी मध्ये किंवा १०८ सेवांच्या माहिती मिळवण्यासाठी १०८ वर कॉल करावा अन्यथा आपल्यावर योग्य ती कारवाई केली जाईल. 

                    </td>
                </tr>-->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>स्क्रिप्ट:- क्या आप हमारी बात किसी वयस्क / अपने से किसी बड़े / घर के किसी अन्य सदस्य से करा सकते हैं !<br>
                    <br>क्रिया: - यदि कोई उपलब्ध नहीं है, तो कॉल करने वाले को निम्न स्क्रिप्ट बताएं<br>
                    <br>स्क्रिप्ट:- हम आपको बताना चाहेंगे के आपने यह कॉल 108 संजीवनी मध्य प्रदेश आपात्कालीन सेवांओ मे किया हैं ! आपसे विनती होगी, आप 108 संजीवनी मे केवल 
आपात्कालीन परिस्थितियों के दौरान या 108 संजीवनी एम्बुलेंस की सेवाओं की जानकरी के लिए, केवल कॉल करे.


                    </td>
                </tr>


            </table>
        </div>
</div>

</div>