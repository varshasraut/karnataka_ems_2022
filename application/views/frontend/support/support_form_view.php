
<?php
$lng_array = get_lang();     //array language

$ques_id = explode(',', $cookie_ques_id);

$checked_ids = array();
foreach ($ques_id as $key => $val) {
    $checked_ids[$val] = "checked=checked";
}
?>

<div class="call_purpose_form_outer">

    <h3 class="width50 float_left">SUPPORT CALL</h3>

    <form method="post" name="enq_form" id="enq_form">

        <?php $selected_lang[$lang] = "selected = selected"; ?>
        <div class="width15 float_right">
            <select name="lang" class="change-xhttp-request" data-href="{base_url}support/chng_lang" data-qr= "output_position=content" TABINDEX="7">

                <option value="">Select Language</option>
                <option value="en" <?php echo $selected_lang['en']; ?>>English</option>
                <option value="hn" <?php echo $selected_lang['hn']; ?>>Hindi</option>
                <option value="kn" <?php echo $selected_lang['kn']; ?>>Kannada</option>


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

                <?php }
} ?>


        </div>

        <div class="que_enq width100">

            <div class="style6">Questions of Enquiry<span class="md_field">*</span></div>

            <div class="ambulance_box float_left enq_scroll">

                <table class="enq_table">

                    <?php
                    if (count($get_question) > 0) {
                        $i=8;
                        foreach ($get_question as $que) {

                            $serialize_data = $que->que_question;
                            ?>

                            <tr class="border_que">
                                <td style="position:relative;">

                                    <a class="questions click-xhttp-request" data-qr="output_position=get_answer&amp;que=<?php echo $que->que_id; ?>&amp;lang=<?php echo $lang; ?>" data-href="{base_url}support/get_answer"><?php echo get_lang_data($serialize_data, $lng_array[$lang]); ?></a>

                                    <label for="enq_<?php echo $que->que_id; ?>" class="chkbox_check bottom">

                                        <input name="que[<?php echo $que->que_id ?>]" class="check_input checked_que filter_required" value="<?php echo $que->que_id; ?>" data-href="{base_url}support/check_question"  id="enq_<?php echo $que->que_id; ?>" type="checkbox" <?php echo $checked_ids[$que->que_id]; ?> TABINDEX="<?php echo $i; ?>" data-errors="{filter_required:'please select'}">

                                        <span class="chkbox_check_holder"></span>

                                    </label>



                                </td>
                            </tr>	

                        <?php  $i++; }
                        }
                    ?>

                </table>



            </div>


            <div id="get_answer">  

            </div>

        </div>

        <div class="button_field_row float_right width40">

            <div class="button_box">

                <input type="hidden" name="submit" value="sub_support" />

                <input type="button" name="submit" value="Save" class="style5 form-xhttp-request" data-href='{base_url}support/confirm_save' data-qr="output_position=content" TABINDEX="19">

<!--                <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 enq_search form-xhttp-request" data-href="{base_url}support/confirm_save" data-qr="forword=yes" type="button" TABINDEX="20">-->
            </div>

        </div>




    </form>



</div>