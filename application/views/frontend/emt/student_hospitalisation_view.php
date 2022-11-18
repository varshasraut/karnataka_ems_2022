<script>

    init_auto_address();

</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Hospitalisation details
        <div class="form_field width25 float_right">
            <div class="input">

                <select name="hair" class="filter_required"  data-errors="{filter_required:'Please select hair color'}" data-base="" tabindex="6">
                    <option value="">Previous visit</option>
                    <option value="25_agu">25 Aug 2018</option>
                    <option value="25_agu">20 Aug 2018</option>
                    <option value="25_agu">15 Aug 2018</option>
                </select>

            </div>
        </div></h3> </div>

<form method="post" name="" id="patient_info">

    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">
    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left">

        <div class="row display_inlne_block">
            <div class="form_field width100 select float_left">
                <div class="label">Diagnosis</div>
                <div class="input top_left">
                    <input name="diagnosis_name" value="<?php echo $medical_data[0]->diagnosis_name; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Diagnosis" data-href="{base_url}auto/get_auto_diagosis_code" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" data-value="<?php echo $ins_procedure[0]->diagnosis_title; ?>" tabindex="6" readonly="readonly">

                </div>
            </div>
            <div class="form_field width100 select float_left">
                <div class="label">Brief History</div>
                <div class="input top_left">
                    <textarea name="brief_history"><?php echo $stud_hospitalizaion[0]->brief_history; ?></textarea>
                </div>
            </div>
            <div class="width100 display_inlne_block">
                <div class="display-inline-block res_ch">
                    <div class="style6">Insurance </div>

                    <div class="width100 float_left on_click_show_input">
                        <label for="insurance_yes" class="radio_check width_30 float_left">
                            <input id="insurance_yes" type="radio" name="insurance" class="radio_check_input filter_either_or[insurance_yes,insurance_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php if ($stud_hospitalizaion[0]->insurance == 'Y') {
    echo "selected";
} ?>>
                            <span class="radio_check_holder" ></span>yes
                        </label>
                        <label for="insurance_no" class="radio_check width_30 float_left">
                            <input id="insurance_no" type="radio" name="insurance" class="radio_check_input filter_either_or[insurance_yes,insurance_no]" value="N" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php if ($stud_hospitalizaion[0]->insurance == 'N') {
    echo "selected";
} ?>>
                            <span class="radio_check_holder" ></span>No
                        </label>

                        <div class="form_field width100 select float_left  <?php if ($stud_hospitalizaion[0]->insurance != 'N') { echo " hidden_input hide";} ?>">
                            <div class="label">Procedure for insurance</div>
                            <div class="input top_left">
                                <textarea name="insurance_procedure"><?php echo $ins_procedure[0]->diagnosis_procedure; ?></textarea>
                            </div>
                        </div>

                    </div>  

                </div>

            </div> 



            <div class="width100 display_inlne_block">
                <input type="button" name="accept" value="Transfer To Empannelled Hospital" class="accept_btn form-xhttp-request " data-href="http://mulikas4/TDD/emt/save_hospitalization" data-qr="output_position=content&hosp=empannelled" tabindex="18" autocomplete="off">

                <input type="button" name="accept" value="Transfer to Govt hospital" class="accept_btn form-xhttp-request" data-href="http://mulikas4/TDD/emt/save_hospitalization" data-qr="output_position=content&hosp=govt" tabindex="19" autocomplete="off">
            </div>

        </div>

    </div>


    <div class="width100 float_left">
        <br>
    </div>



</form>
