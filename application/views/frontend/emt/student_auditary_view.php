<script>
if(typeof H != 'undefined'){{
    init_auto_address();
}
</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Auditary  Screening</h3> </div>

<form method="post" name="" id="ent_info">


    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

    <div class="half_div_left">
                    <div class="style6">Hearing Test <span class="md_field">*</span></div>
                    <div class="form_field width50 select float_left">
                        <div class="label">Right</div>
                        <div class="input top_left">
                            <select name="hearing_right" class="filter_required"  data-errors="{filter_required:'Please select Right Auditary Screening'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="Y" <?php if ($student_ent_data[0]->hearing_right == 'Y') {
    echo "selected";
} ?>>Yes</option>
                                <option value="N" <?php if ($student_ent_data[0]->hearing_right == 'N') {
    echo "selected";
} ?>>No</option>

                            </select>

                        </div>
                    </div>
                    <div class="form_field width50 select float_left">
                        <div class="label">Left</div>
                        <div class="input top_left">
                            <select name="hearing_left" class="filter_required"  data-errors="{filter_required:'Please select Right Auditary Screening'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="Y" <?php if ($student_ent_data[0]->hearing_left == 'Y') {
    echo "selected";
} ?>>Yes</option>
                                <option value="N" <?php if ($student_ent_data[0]->hearing_left == 'N') {
    echo "selected";
} ?>>No</option>

                            </select>


                        </div>
                </div>
                    <div class="form_field width100 select float_left">
                    <div class="label">otoscopic exam</div>
                    <div class="input top_left">
                        <input name="otoscopic_exam" value="<?php echo $student_ent_data[0]->otoscopic_exam;?>" class="width97" tabindex="51" data-base="" data-errors="{filter_minlength:'Comment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
                </div>

        
    </div>
    <div class="half_div_right">
                <div class="form_field width100 select float_left">
                    <div class="label">Comment</div>
                    <div class="input top_left">
                        <input name="ent_comment" value="<?php echo $student_ent_data[0]->otoscopic_exam;?>" class="" tabindex="51" data-base="" data-errors="{filter_minlength:'Comment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
                </div>
                <div class="form_field width100 select float_left">
                        <div class="label">treatment given</div>
                        <div class="input top_left">
                            <input name="ent_treatment" value="<?php echo $student_ent_data[0]->otoscopic_exam;?>" class="" tabindex="51" data-base="" data-errors="{filter_minlength:'Comment should be at least 12 digit long'}" autocomplete="off" type="text">
                        </div>
                </div>
    </div>
    <div class="width100">
       <div class="width100 float_left">
                <div class="style6 width30 float_left"><strong>Check if Present</strong></div>
                <div class="checkbox_input width30 float_left" style="margin-top:0px;"></div>


                <div class="hide_screening_checkbox checkbox_div width100">

                <?php
                $tab = 34;

                $checked_auditary = json_decode($student_ent_data[0]->ent_check_if_present);
                
                
                if (!empty($auditary)) {

                    foreach ($auditary as $dig) {

                        $auditary_id =  $dig->id;
                        
                        $oth_opt = array('Others - specify' => 'birth_eff_other');

                        if (!empty($checked_auditary)) {

                             if (in_array($dig->id, $checked_auditary)) {

                                $checked[$auditary_id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $dig_ids[] = "auditary_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="float_left width30">

                            <label for="auditary_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="auditary_[]" class="check_input <?php echo $oth_opt[$dig->auditary_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="auditary_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$auditary_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->auditary_title; ?>


                            </label>

                        </div>

                        <?php
                        $dig_opt[] = ob_get_contents();

                        ob_get_clean();
                    }
                }


                $html = join("", $dig_opt);

                echo $html = str_replace("(*:ids:*)", join(",", $dig_ids), $html);
                ?>

            </div>
                    </div>
    </div>
        <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Submit" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_auditary' data-qr="output_position=pat_details_block"  tabindex="25">


    </div>

    <div class="width100 float_left">
       
    </div>
</form>