<script>
if(typeof H != 'undefined'){
    init_auto_address();
 }

</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Vision Screening </h3> </div>

<form method="post" name="" id="patient_info">

    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left">

        
        <div class="width100 display_inlne_block">
            <div class="style6">Visual Acuity test  <span class="md_field">*</span></div>
<div class="width100 display_inlne_block">
<!--            <div class="style6">Vision With Glasses <span class="md_field">*</span></div>-->
                <div class="form_field width50 select float_left">
                        <div class="label">Vision With Glasses</div>
                        <div class="input top_left">
                             <select name="with_glasses" class="filter_required"  data-errors="{filter_required:'Please select Vision With Glasses'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="good" <?php if($screening[0]->with_glasses == 'good'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>Good</option>
                                <option value="poor" <?php if($screening[0]->with_glasses == 'poor'){ echo "selected"; } ?>>Poor</option>    
                            </select>
<!--                            <input name="with_glasses_right" value="<?=@$student_vison_data[0]->with_glasses_right?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[0-20]" placeholder="0 To 20" data-errors="{filter_required:'Right should not be blank',filter_number:'Right should be in numbers',filter_rangelength:'Right range should be 0 to 20'}" type="text" tabindex="18">-->

                        </div>
                </div>
<!--                        <div class="style6">Vision Without Glasses <span class="md_field">*</span></div>-->
                <div class="form_field width50 select float_left">
                        <div class="label">Vision Without Glasses</div>
                        <div class="input top_left">
<!--                            <input name="without_glasses_right" value="<?=@$student_vison_data[0]->without_glasses_right?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[0-20]" placeholder="0 To 20" data-errors="{filter_required:'Right should not be blank',filter_number:'Right should be in numbers',filter_rangelength:'Right range should be 0 to 20'}" type="text" tabindex="18">-->
 <select name="without_glasses" class="filter_required"  data-errors="{filter_required:'Please select Vision With Glasses'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="good" <?php if($screening[0]->with_glasses == 'good'){ echo "selected"; }else if(empty($screening[0])){ echo "selected"; } ?>>Good</option>
                                <option value="poor" <?php if($screening[0]->with_glasses == 'poor'){ echo "selected"; } ?>>Poor</option>    
                            </select>
                        </div>
                </div>
</div>
<!--                  <div class="form_field width50 select float_left">
                        <div class="label">Left</div>
                        <div class="input top_left">
                            <input name="with_glasses_left" value="<?=@$student_vison_data[0]->with_glasses_left?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[0-20]" placeholder="0 To 20" data-errors="{filter_required:'Left should not be blank',filter_number:'Left should be in numbers',filter_rangelength:'Left range should be 0 to 20'}" type="text" tabindex="18">

                        </div>
                </div>-->

<!--                <div class="form_field width50 select float_left">
                        <div class="label">Left</div>
                        <div class="input top_left">
                            <input name="without_glasses_left" value="<?=@$student_vison_data[0]->without_glasses_right?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[0-20]" placeholder="0 To 20" data-errors="{filter_required:'Left should not be blank',filter_number:'Left should be in numbers',filter_rangelength:'Left range should be 0 to 20'}" type="text" tabindex="18">

                </div>
                </div>-->
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6">eye muscle control</div>

               <div class="width100 float_left">
                  

                            <label for="eye_muscle_control_good" class="chkbox_check width_30 float_left">

                                <input name="eye_muscle_control[]" class="check_input" value="good" data-errors="{filter_either_or:'should not be blank!'}" id="eye_muscle_control_good" type="checkbox" tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span>Good


                            </label>
                   <label for="eye_muscle_control_poor_control" class="chkbox_check width_30 float_left">

                                <input name="eye_muscle_control[]" class="check_input " value="poor_control" data-errors="{filter_either_or:'should not be blank!'}" id="eye_muscle_control_poor_control" type="checkbox"  tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span>Poor Control


                            </label>
                        <label for="eye_muscle_control_poor_coordinaion" class="chkbox_check width_30 float_left">

                                <input name="eye_muscle_control[]" class="check_input" value="poor_coordinaion" data-errors="{filter_either_or:'should not be blank!'}" id="eye_muscle_control_poor_coordinaion" type="checkbox" <?php echo $checked[$diagnosis_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span>Poor Coordination


                            </label>

                      
<!--                    <label for="eye_muscle_control_yes" class="radio_check width_30 float_left">
                         <input id="eye_muscle_control_yes" type="radio" name="eye_muscle_control" class="radio_check_input filter_either_or[eye_muscle_control_yes,eye_muscle_control_no,eye_muscle_control_poor]" value="good" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>Good
                    </label>
                    <label for="eye_muscle_control_no" class="radio_check width_30 float_left">
                        <input id="eye_muscle_control_no" type="radio" name="eye_muscle_control" class="radio_check_input filter_either_or[eye_muscle_control_yes,eye_muscle_control_no,eye_muscle_control_poor]" value="poor_control" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>Poor Control
                    </label>
                    <label for="eye_muscle_control_poor" class="radio_check width_30 float_left">
                        <input id="eye_muscle_control_poor" type="radio" name="eye_muscle_control" class="radio_check_input filter_either_or[eye_muscle_control_yes,eye_muscle_control_no,eye_muscle_control_poor]" value="poor_coordination" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>Poor Coordination
                    </label>-->
                </div>  

                 </div>

            </div> 
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6">refractive error </div>

                <div class="width100 float_left on_click_show_input">
                    <label for="refractive_error_yes" class="radio_check width_30 float_left">
                         <input id="refractive_error_yes" type="radio" name="refractive_error" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="refractive_error_no" class="radio_check width_30 float_left">
                        <input id="refractive_error_no" type="radio" name="refractive_error" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                    <div class="hidden_input hide width50 float_left">
                            <input type="text" name="refractive_error_text" class="width100" value="" placeholder="Refractive Error" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>">  
                    </div>
                    
                </div>    

                 </div>

            </div> 
            <div class="form_field width30 select float_left on_click_show_input">
                        <div class="label">visual field perimetry</div>
                        <div class="input top_left">
                            <select name="visual_perimetry" class="filter_required"  data-errors="{filter_required:'Please select Visual field perimetry'}" data-base="" tabindex="6" id="visual_perimetry_value">
                                <option value="">Select</option>
                                <option value="NAD" <?php if($student_vison_data[0]->visual_perimetry == 'NAD'){ echo "selected"; } ?>>NAD</option>
                                <option value="other" <?php if($student_vison_data[0]->visual_perimetry == 'other'){ echo "selected"; } ?>>Other</option>
                            </select>
                        </div>
                        <div class="input top_left hidden_input hide">

                            <input name="visual_perimetry_other" value="<?php echo $medical_data[0]->visual_perimetry_other; ?>"  class="form_input" placeholder="Visual Field Perimetry" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" tabindex="6">

                        </div>
            </div>
            <div class="form_field width50 select float_left">
                <div id="visual_perimetry_other">
                </div>
            </div>
            <div class="form_field width30 select float_left">
                    <div class="label">Comment</div>
                    <div class="input top_left">
                        <input name="vision_comment" value="<?=@$student_vison_data[0]->vision_comment?>" class="" tabindex="51" data-base="" data-errors="{filter_minlength:'Comment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
            </div>
            <div class="form_field width30 select float_left">
                    <div class="label">treatment given</div>
                    <div class="input top_left">
                        <input name="vision_treatment" value="<?=@$student_vison_data[0]->vision_treatment?>" class="" tabindex="51" data-base="" data-errors="{filter_minlength:'Treatment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
            </div>

            
       
        </div>

    </div>


    <div class="half_div_right">


         <div class="width100 float_left">

                <div class="style6"><strong>Check if Present</strong></div>
                <div class="checkbox_input"></div>

                <div class="hide_screening_checkbox checkbox_div">

                <?php
                $checked_opthalmological = json_decode($student_vison_data[0]->opthalmological);
                $tab = 34;

                if (!empty($opthalmological)) {

                    foreach ($opthalmological as $dig) {
                        
                        $opthalmologica_id =  $dig->id;

                        $oth_opt = array('Others - specify' => 'birth_eff_other');

                        if (!empty($checked_opthalmological)) {

                            if (in_array($dig->id, $checked_opthalmological)) {

                                $checked[$opthalmologica_id] = "checked";

                                $oth_dig = ($dig->birth_effects_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $dig_ids[] = "opthalmological_" . $dig->id;
                        ob_start();
                        ?>

                        <div class="display-inline-block width50 float_left">

                            <label for="opthalmological_<?php echo $dig->id; ?>" class="chkbox_check">

                                <input name="opthalmological_[]" class="check_input  <?php echo $oth_opt[$dig->opthalmological_title]; ?>" value="<?php echo $dig->id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="opthalmological_<?php echo $dig->id; ?>" type="checkbox" <?php echo $checked[$opthalmologica_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->opthalmological_title; ?>


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


        <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_vision' data-qr="output_position=content"  tabindex="25">


    </div>

    <div class="width100 float_left">
       
    </div>



</form>
