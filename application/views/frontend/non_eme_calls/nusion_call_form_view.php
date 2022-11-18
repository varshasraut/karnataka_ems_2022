<?php
$current_user_group=$this->session->userdata['current_user']->clg_group;
if($current_user_group=='UG-ERO'){
    $system="108";
 }else{
    $system="102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Nuisance Call</h3> -->
    <label class="headerlbl">Nuisance Call</label>
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
                <!-- <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value=""> -->
                     <input type="hidden" id="hidden_caller_id" name="caller_id" value="<?php echo $caller_id; ?>">
                <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
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
                    <td>कॉलर शी बोलत असताना असे आढळून आले की कॉलर ला १०८ सेवेबद्दल कुठलीही माहिती किव्हा ऍम्ब्युलन्स ची सुविधा ही नको आहे आणि तरी ही कॉलर १०८ सेवेच्या व्यतिरिक्त बोलत असल्यास अश्या वेळेस इ.आर.ओ ने कॉलर ला १०८ सेवेची माहिती आणि वॉर्निंग देऊन तो कॉल डिस्कनेक्ट करावा.</td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉलर को 108 संजीवनी सेवा या एम्बुलेंस सेवा के बारे में कोई जानकारी नहीं चाहिए और अगर कॉलर 108 संजीवनी के सेवा के अलावा बात कर रहा है,तो इ.आर.ओ ने कॉलर को 108 संजीवनी सेवा की जानकारी और चेतावनी स्क्रिप्ट देकर कॉल को समाप्त करना चाहिए|</td>

                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>हम आपको बताना चाहेंगे की आपने यह कॉल मध्य प्रदेश 108 संजीवनी आपात्कालीन एम्बुलेंस सेवांओ में किया हैं ! 
                    <br><br>आपसे विनती होगी, के आप गलत भाषा का उपयोग ना करे तथा गाली-गलौच ना करे, अन्यथा हमें आपकी कॉल काटनी होगी. जिसके लिए हम क्षमा चाहते हैं! 
                    <br><br>आपसे अनुरोध करने के बावजूद भी आप गलत भाषा का उपयोग कर रहे हैं! इस कारण हमें यह कॉल काटनी होगी. 108 संजीवनी में कॉल करने के लिए धन्यवाद !  
                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>आम्ही आपणास सांगू इच्छितो कि आपला कॉल १०८ ऍम्ब्युलन्स सेवे मध्ये आलेला आहे, आपणास विनंती आहे आपत्कालीन परिस्तिथी मध्ये किंवा १०८ सेवांच्या माहिती साठी १०८ वर कॉल करावा अन्यथा अश्या प्रकारे विनाकारण १०८ ला कॉल केल्यास आपल्यावर योग्य ती कारवाई केली जाईल.
                    </td>
                </tr>-->


            </table>
        </div>
</div>
</div>