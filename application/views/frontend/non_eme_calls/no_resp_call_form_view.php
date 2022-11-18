<div class="call_purpose_form_outer">

    <!-- <h3>No Response Call</h3> -->
    <label class="headerlbl">No Response Call</label>

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
                    <td>कॉलवर कॉलर कडून काहीच प्रतिउत्तर न आल्यास आणि केवळ आजूबाजूचा आवाज येत असल्यास इ.आर.ओ ने कॉलर ला विनंती करावी कि पुन्हा १०८ ला कॉल करावा आणि क्लोजिंग स्क्रिप्ट वापरून कॉल संपवावा.</td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉलर की ओर से कॉल पर कोई प्रतिक्रिया नहीं आ रही  है और केवल आसपास की आवाज आ रही है, तो इ.आर.ओ ने कॉलर को अनुरोध करना चाहिए की वो फिर से 108 संजीवनी पर कॉल करे और क्लोजिंग स्क्रिप्ट का उपयोग करके कॉल को समाप्त करना चाहिए।</td>

                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>आपला आवाज आमच्या पर्यंत येत नाही/ आपल्या कडून उचित प्रतिसाद येत नसल्याने मला आपला कॉल डिस्कनेक्ट करावा लागत आहे. जर माझा आवाज आपल्या पर्यंत येत असल्यास कृपया १०८ ला पुन्हा कॉल बॅक करावा.
                    </td>
                </tr>-->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>हम आपकी आवाज नही सुन पा रहे हैं/हमे आपकी और से कोई उचित प्रतिसाद नही मिल पा रहा हैं, यदि आप मेरी आवाज सुन पा रहे हैं, तो कृपया 108 संजीवनी इस टोल फ्री नंबर पर दुबारा कॉल करे. <br>108 संजीवनी मे कॉल करने के लिए धन्यवाद !
                    </td>
                </tr>

            </table>
        </div>
</div>
</div>