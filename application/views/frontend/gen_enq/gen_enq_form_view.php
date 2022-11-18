<?php
$current_user_group=$this->session->userdata['current_user']->clg_group;
if($current_user_group=='UG-ERO'){
    $system="108";
 }elseif($current_user_group = 'UG-BIKE-ERO'){
    $system="108";
 }else{
    $system="102";
}
?>
<div class="call_purpose_form_outer">

    <!-- <h3>General Enquiry Call</h3> -->
    <label class="headerlbl">General Enquiry Call</label>
    <div id="totalnon_div">

<div id="nonleft_half">

    <form method="post" name="gen_enq_form" id="gen_enq_form">

        <input type="hidden" name="caller_id" id="caller_id" value="<?php echo $caller_id; ?>">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="base_month" value="<?php echo $cl_base_month; ?>">

        <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">

        <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
        
        <input type="hidden" name="incient[inc_type]" id="inc_type" value="GEN_ENQ">
        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">

        <div class="width100">               

<!--            <div class="form_field width50 float_left">

                <div class="label">Questions Sample:</div>

                <?php
                if (count($get_question) > 0) {

                    $count = 1;
                    foreach ($get_question as $que) {
                        ?>

                        <div class="test_que"><?php echo $count . "." . $que->que_question; ?></div>

                        <?php
                        $count ++;
                    }
                }
                ?>

            </div>-->
            <div class="width100 enquiry_summary">
                <div class="width100 form_field float_left ">
                    <div class="label blue float_left width_20">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                    <div class="width75 float_left">
                        <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=GEN_ENQ&system_type=<?php echo $system?>"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
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

            <!--            <div class="width50 float_left">
            
                            <div class="form_field">
            
                                <div class="label width50">ERO Notes<span class="md_field">*</span></div>
            
                                <div class="filed_textarea">
                                    <textarea class="text_area filter_required" name="test_notes" rows="5" cols="30" data-errors="{filter_required:'ERO Notes should not be blank.'}" tabindex="7"></textarea>
                                </div>
            
                            </div> 
            
                        </div>-->



        </div>

        <div class="button_field_row text_align_center beforeunload">
            <div class="button_box">

                <input type="hidden" name="submit" value="sub_test"/>

                <input type="button" name="submit" value="Save" class="style5 form-xhttp-request" data-href='{base_url}gen_enq/confirm_save' data-qr="output_position=content;forword=true" tabindex="8">

<!--                <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}tstcall/confirm_save" data-qr="output_position=content&amp;forword=true" type="button" tabindex="9">-->


            </div>
        </div>

    </form>

</div>
<div id="nonright_half">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">1. Standard Remarks Marathi</td>
                    <td>जर कॉलर ने १०८ सर्विसेसची  चौकशी  करण्यासाठी  (ठराविक  गोष्टीची)  कॉल केलेला  असल्यास  हा  कॉल  टाईप  निवडावा.</td>

                </tr>
                <tr>
                    <td id="script_table_td">2. Standard Remarks Marathi</td>
                    <td>१०८ च्या नियमाप्रमाणे ज्या ठराविक कारणासाठी इ.आर.ओ ऍम्ब्युलन्स पाठवू शकत नाही, त्यावेळेस या कॉल टाईप निवडावा. </td>

                </tr>-->
                 <tr>
                    <td id="script_table_td">1. Standard Remarks Hindi</td>
                    <td>यदि कॉलरने 108 संजीवनी सेवाओं के बारे में पूछताछ करने के लिए कॉल किया है तो इस कॉल प्रकार का चयन करें।</td>

                </tr>
                <tr>
                    <td id="script_table_td">2. Standard Remarks Hindi</td>
                    <td>जिस परिस्तिथिओ मे इ.आर.ओ 108 संजीवनी के नियमो के अनुसार एम्बुलेंस नहीं भेज पा रहा है उस समय इस कॉल प्रकार का चयन करें।  </td>

                </tr>
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>1) उपलब्ध जानकारी के अनुसार फोन करने वाले को सूचित करें। <br><br>
                        2) हम नियम 108 संजीवनी के अनुसार इस उद्देश्य के लिए एम्बुलेंस नहीं भेज सकते हैं, आप भविष्य की आपातकालीन स्थिति में एम्बुलेंस के लिए कॉल कर सकते हैं हम इस कारण से नियम 108 संजीवनी के अनुसार एम्बुलेंस नहीं भेज सकते हैं, आप भविष्य में आपातकालीन स्थिति में एम्बुलेंस के लिए कॉल कर सकते हैं।
                    </td>
                </tr>


            </table>
        </div>
</div>
</div>