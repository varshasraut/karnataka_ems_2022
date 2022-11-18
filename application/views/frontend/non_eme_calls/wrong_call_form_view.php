<?php
$current_user_group=$this->session->userdata['current_user']->clg_group;
if($current_user_group=='UG-ERO'){
    $system="108";
 }else{
    $system="102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>Wrong Call</h3> -->
    <label class="headerlbl">Wrong Call</label>
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
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>यदि कॉलर 108 संजीवनी के उपरोक्त अन्य सेवाओं के बारे में जानकारी जानने हेतु 108 संजीवनी में कॉल करते हैं! तो, इ.आर.ओ कॉलर को 108 संजीवनी के सेवाओं के बारे मे जानकारी दे कर इस कॉल टाइप का चयन करें ! </td>

                </tr>
                <!-- <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>कॉलर को १०८ सेवाओं के अलावा किसी भी बारे में संदेह/प्रश्न,अनुरोध/बिनती या शिकायतों के बारे में सूचित करने के लिए कॉल किया है तो कॉलर को १०८ सेवा की जानकारी देकर इस कॉल प्रकार का चयन करें। </td>

                </tr> -->
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>आप जिस जानकारी को पाना चाहते है, यह उस सेवा का नंबर नही है, आपकी यह कॉल मध्य प्रदेश सरकार की संजीवनी 108 सेवाओं मे लगी है ! <br>आपसे अनुरोध होगा कि दुबारा इच्छित सेवाओं के नंबर जांचकर कॉल करें !
                    </td>
                </tr>


            </table>
        </div>
</div>
</div>