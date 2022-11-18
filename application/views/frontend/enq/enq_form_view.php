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
<?php
$lng_array = get_lang();     //array language

$ques_id = explode(',', $cookie_ques_id);

$checked_ids = array();
foreach ($ques_id as $key => $val) {
    $checked_ids[$val] = "checked=checked";
}

?>

<div class="call_purpose_form_outer">

    <!-- <h3 class="width50 float_left">Enquiry Call</h3> -->
    <label class="width50 float_left headerlbl">Enquiry Call</label>

    <form method="post"  enctype="multipart/form-data"  name="enq_form" id="enq_form">

        <?php $selected_lang[$lang] = "selected = selected"; ?>
        <div class="width15 float_right">
            <select name="lang" class="change-xhttp-request" data-href="{base_url}enquiry/chng_lang" data-qr= "output_position=content" TABINDEX="7" id="lang_option">

                <option value="">Select Language</option>
                <option value="en" <?php echo $selected_lang['en']; ?>>English</option>
                <option value="hn" <?php echo $selected_lang['hn']; ?>>Hindi</option>
               <!-- <option value="mh" <?php echo $selected_lang['mh']; ?>>Marathi</option>-->


            </select>
        </div>



        <input type="hidden" name="base_month" id="cl_base_month" value="<?php echo $cl_base_month; ?>">

        <div class="width100 details_enq">

            <?php
            if (count($emr_details) > 0) {

                foreach ($emr_details as $info) {

                    $serialize_data = $info->ovalue;
                    ?>
                    <p><?php echo get_lang_data($serialize_data, $lng_array[$lang]); ?></p>

                <?php
                }
            }
            ?>


        </div>

        <div class="que_enq width100">

            <div class="style6">Questions of Enquiry<span class="md_field">*</span></div>

            <div class="ambulance_box float_left enq_scroll">

                <table class="enq_table">

                    <?php
                    if (count($get_question) > 0) {
                        $i = 8;
                        $srno = 0;
                        foreach ($get_question as $key=>$que) {

                            $serialize_data = $que->que_question;
                            $count= $key+1;
                            if($count< 10){
                                $srno = "&nbsp; $count) &nbsp;  ";
                            }
                            else {
                                $srno = "$count) &nbsp; ";
                            }
                            ?>

                            <tr class="border_que">
                                <td style="position:relative;">
                                    <span class="float_left">
                                        <?php echo $srno; ?>
                                    </span>
                                    
                                    <a class="questions click-xhttp-request" data-qr="output_position=get_answer&amp;que=<?php echo $que->que_id; ?>&amp;lang=<?php echo $lang; ?>" data-href="{base_url}enquiry/get_answer"><?php echo get_lang_data($serialize_data, $lng_array[$lang]); ?></a>

                                    <label for="enq_<?php echo $que->que_id; ?>" class="chkbox_check bottom">

                                        <input name="que[<?php echo $que->que_id ?>]" class="check_input checked_que filter_required enq_question" value="<?php echo $que->que_id; ?>" data-href="{base_url}enquiry/check_question" data-qr="output_position=get_answer&amp;que=<?php echo $que->que_id; ?>&amp;lang=<?php echo $lang; ?>"  id="enq_<?php echo $que->que_id; ?>" type="checkbox" <?php echo $checked_ids[$que->que_id]; ?> TABINDEX="<?php echo $i; ?>" data-errors="{filter_required:'please select'}">

                                        <span class="chkbox_check_holder"></span>

                                    </label>



                                </td>
                            </tr>	

                            <?php
                            $i++;
                        }
                    }
                    ?>

                </table>



            </div>


            <div id="get_answer">  

            </div>

        </div>
        <div class="width100 enquiry_summary">
            <div class="width2 form_field float_left ">
                <div class="label blue float_left width_25">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                <div class="width75 float_left">
                    <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=ENQ_CALL&system_type=<?php echo $system?>"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                </div>
                <!--                         <div class="width100" id="ero_summary_other">
                                        <textarea name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="800"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                                        </div>-->
            </div>
            <div class="width2 form_field float_left">
                <div class="label blue float_left width_16">ERO Note</div>

                <div class=" float_left width75" id="ero_summary_other">
                    <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                </div>
            </div>

        </div>


    <div id="totalnon_div">
            <table id="script_table">
                <!--<tr>
                    <td id="script_table_td">Standard Remarks Marathi</td>
                    <td>कॉलर ने १०८ सेवांच्या माहितीसाठी कॉल केला असता इ.आर.ओ ने पूर्ण इन्क्वायरी स्क्रिप्ट वापरून कॉलर ला माहिती द्यावी.</td>

                </tr>-->
                <tr>
                    <td id="script_table_td">Standard Remarks Hindi</td>
                    <td>जब कॉलर 108 संजीवनी सेवाओं के बारे में जानकारी मांगता है, तो इ.आर.ओ को पूरी इन्क्वायरी स्क्रिप्ट का उपयोग करके कॉलर को सूचित करिये| </td>

                </tr> 
                <tr>
                    <td id="script_table_td">Call Type Wise Handling Script In Hindi</td>
                    <td>108 संजीवनी एम्बुलेंस की सेवाओं मे रूची दिखाने के लिए धन्यवाद !
                    108 संजीवनी यह आपात्कालीन चिकित्सा सेवा का टोल फ्री नंबर हैं! मध्य प्रदेश के कोई भी जिले, तालुका, शहर या गांव से कॉल कर के आप एम्बुलेंस की सेवा प्राप्त कर सकते हैं! मध्य प्रदेश 108 संजीवनी आपात्कालीन एम्बुलेंस, यह गवर्नमेंट की पहल हैं! और यह जय अम्बे इमरजेंसी सर्विसेज द्वारा चलाया जा रहा हैं! यह सेवा हफ्ते के सातो दिन और दिन के चोबीस घंटे पुर्ण साल भर उपलब्ध है।

                    </td>
                </tr>
                <!--<tr>
                    <td id="script_table_td">Call Type Wise Handling Script in Marathi</td>
                    <td>108 सेवे मध्ये रुची दाखविल्या बद्दल धन्यवाद, 108 हा आपत्कालीन वैद्यकीय सेवेचा नंबर असून तो Toll free आहे. संपूर्ण महाराष्ट्राच्या कुठल्या हि भागातून कॉल करून आपण अम्बुलंस ची सेवा मिळवू शकत. M.E.M.S हा महाराष्ट्र शासनाचा उपक्रम असून तो भारत विकास ग्रुप मार्फत राबवण्यात येत आहे. ही सेवा 24/7 कार्यरत आहे . आमची अम्बुलंस हि आधुनिक उपकरणाने सुसज्ज असून त्या मध्ये तज्ञ डॉक्टर आहेत ते घटना स्थळापासून ते जवळच्या सरकारी हॉस्पिटल मध्ये नेई पर्यंत रुग्णावर मोफत उपचार केले जातात. गरजे नुसार पोलिस आणि फायर यांची सेवाही दिली जाते. नैसर्गिक आपत्ती किंवा अपघात व आजार यासाठी आपण 108 ला कॉल करून आपले नाव व पत्ता याविषयी माहिती सांगून अम्बुलंस मिळवू शकता.
                    </td>
                </tr>-->


            </table>
        </div>

        <div class="button_field_row  width100">

<div class="button_box enquiry_button beforeunload">

    <input type="hidden" name="submit" value="sub_enq">
    <input type="hidden" name="incient[inc_type]" id="inc_type" value="ENQ_CALL">
    <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
    <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
    <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
    <input type="button" name="submit" value="SAVE" class="style5 form-xhttp-request" data-href='{base_url}enquiry/confirm_save' data-qr="output_position=content" TABINDEX="19">
</div>

</div>




</form>

</div>