<script>cur_pcr_step(7);</script>
<?php $CI = EMS_Controller::get_instance();
$date = new \DateTime();



?>
<div class="call_purpose_form_outer">

    <div class="head_outer"><h3 class="txt_clr2 width1">PATIENT MANAGEMENT</h3> </div>


    <form method="post" name="patient_form" id="patient_form" class="pat_mng1">

        <div class="width100 display_inlne_block">

            <div class="cases case_mr_btm btm_mng">

                <div class="style6">SHP Notes<span class="md_field">*</span></div>

                <div class="input">

                    <textarea tabindex="1" class="text_area width100 filter_required" name="emt_notes" rows="10" cols="25" data-errors="{filter_required:'EMT notes should not be blank!'}" tabindex="1"><?php echo $get_pat_mng_data[0]->as_emt_notes; ?></textarea>

                </div>

                <div class="width100 display_inlne_block">

                    <div class="width40 float_left">

                        <div class="style6">ERCP Advice<span class="md_field">*</span></div>
                        <div id="purpose_of_calls" class="input" data-activeerror="">


                            <select id="" name="ercp_adv" class="" tabindex="10">
                                <option value="">Select</option>
                                <?php //if (!empty($check_inc_id)) { ?>
                                    <option value="taken" selected="selected">Taken</option>
                                <?php //} else { ?>
                                    <option value="non_taken" selected="selected">Non Taken</option>
<?php // } ?>
                            </select>


                        </div>                        

                    </div>

                </div>

                <?php
                if (count($check_inc_id) > 0) {

                    foreach ($check_inc_id as $inc_id) {

                        $adv_ids = explode(",", $inc_id->adv_ids);
                        ?>


                        <div class="display_inlne_block width100 loc_btm">

                            <div class="style6">ERCP advice_Auto Transfer,by <?php echo $inc_id->clg_ref_id . " " . $inc_id->clg_first_name . " " . $inc_id->clg_last_name; ?></div>

                            <div id="get_answer">

                                <table class="pat_mng_table">

                                    <?php
                                    if (count($result) > 0) {


                                        $tabcount = 11;

                                        foreach ($result as $adv_data) {

                                            if (isset($adv_data[0]->adv_cl_adv_id) && in_array($adv_data[0]->adv_cl_adv_id, $adv_ids)) {

                                                $CALL = 1;
                                                $checked[$get_pat_mng_data[0]->as_ercp_advice_auto_trans] = "checked";
                                                ?>


                                                <tr class="border_que">
                                                    <td>
                                                        <a class="onpage_popup que_fit" data-href="{base_url}medadv/prev_call_info" data-qr="output_position=popup_div" data-popupwidth="900" data-popupheight="680">
                    <?php echo "CALL " . $CALL++; ?> : </span><?php echo $adv_data[0]->que_question; ?></a>

                                                        <label for="auto_trans" class="chkbox_check">      



                                                            <input name="adv_id[<?php echo $adv_data[0]->adv_cl_adv_id ?>]" class="check_input" value="<?php echo $adv_data[0]->adv_cl_adv_id; ?>" id="ques_check" type="checkbox" <?php echo $checked[$adv_data[0]->adv_cl_adv_id]; ?> tabindex="<?php echo $tabcount; ?>" >
                                                            <span class="chkbox_check_holder"></span>

                                                        </label>

                                                    </td>
                                                </tr>


                <?php } $tabcount++;
            }
        } ?>

                                </table>


                            </div>

                        </div>

    <?php }
} ?>

            </div>

            <div clas="rt_outer">
                <div class="cf_comp">

                    <div class="child_outer">

                        <div class="style6">CARDIC ARREST</div>

                        <div class="pat_width">

                            <h4 class="padding_btm">Bystander CPR</h4>

                            <div class="rosc">
                               <?php $selected_cpr[$get_pat_mng_data[0]->cr_bystander_cpr] = "selected = selected"; ?>
                                <select name="bystan_cpr" class="" tabindex="2">

                                    <option value="">Select</option>

                                    <option value="done" <?php echo $selected_cpr['done']; ?>>Done</option>
                                    <option value="not_done"<?php echo $selected_cpr['not_done']; ?>>Not Done</option>
                                </select>

                            </div>

                        </div>


                        <div class="pat_width">

                            <h4 class="padding_btm">ROSC</h4>

                            <div class="rosc">
                                 <?php $selected_rosc[$get_pat_mng_data[0]->cr_rosc] = "selected = selected"; ?>
                                <select name="rosc" class="" tabindex="3">


                                    <option value="">Select</option>  
                                    <option value="yes" <?php echo $selected_rosc['yes'] ?>>Yes</option>
                                    <option value="no" <?php echo $selected_rosc['no'] ?>>No</option>

                                </select>


                            </div>

                        </div>

                        <div class="pat_width">

                            <h4 class="padding_btm">CPR Start time(24 hrs)</h4>

                            <?php $time = explode(" ", $get_pat_mng_data[0]->cr_start_time); ?>

                            <input name="start_time" value="<?php if ($get_pat_mng_data != '') { echo $time[1];} else { echo date_format($date, 'H:i:s');} ?>" class="mar_btm filter_if_not_blank filter_time_hms" data-errors="{filter_time_hms:'Time is not valid'}" type="text" tabindex="4" placeholder="H:m:s">


                        </div>

                        <div class="pat_width">

                            <h4 class="padding_btm">Puls At ROSC</h4>

                            <div class="pulse_at_rosc">

                                <input name="pulse_at_rosc" value="<?php echo $get_pat_mng_data[0]->cr_puls_rosc; ?>" class="" type="text" tabindex="5">

                            </div>

                        </div>

                        <div class="pat_width">       

                            <h4 class="padding_btm">No of shocks</h4>

                            <div class="shocks">   
<?php $selected_shocks[$get_pat_mng_data[0]->cr_no_of_shocks] = "selected = selected"; ?>
                                <select name="shocks" class="" data-href="" tabindex="6">

                                    <option value="">Select</option>
                                    <option value="0"<?php echo $selected_shocks['0']; ?>>Zero</option>
                                    <option value="1" <?php echo $selected_shocks['1']; ?>>One</option>
                                    <option value="2" <?php echo $selected_shocks['2']; ?>>Two</option>
                                    <option value="3" <?php echo $selected_shocks['3']; ?>>Three</option>
                                    <option value="4" <?php echo $selected_shocks['4']; ?>>Four</option>
                                </select>
                            </div>
                        </div>


                        <div class="pat_width">

                            <h4 class="padding_btm width50">BP at ROSC</h4>

                            <div class="p_mng_lft">
                                <input name="syst" value="<?php echo $get_pat_mng_data[0]->cr_systolic; ?>" class="filter_number filter_if_not_blank" data-errors="{filter_number:'Allowed only number.'}" placeholder="syst" type="text" tabindex="7">
                            </div>


                            <div class="p_mng_right">
                                <input name="dyast" value="<?php echo $get_pat_mng_data[0]->cr_diastolic; ?>" class="filter_number filter_if_not_blank" data-base="" placeholder="dyast" type="text" data-errors="{filter_number:'Allowed only number.'}" tabindex="8">
                            </div>

                        </div>

                        <div class="pat_width">       

                            <h4 class="padding_btm">Loc at ROSC</h4>
                            <div class="loc_rosc">

                                <input type="text" name="loc_at_rosc" data-value="<?php echo $get_pat_mng_data[0]->level_type; ?>" value="<?php echo $get_pat_mng_data[0]->cr_loc_at_rosc; ?>" class="mi_autocomplete ucfirst" data-href="{base_url}auto/loc_level" placeholder="Enter LOC Level" tabindex="9">

                            </div>
                        </div>

                    </div>

                </div>

                <div class="cf_comp">

                    <div class="child_outer">

                        <div class="style6">CHILD BIRTH DETAILS</div>

                        <div class="pat_width">

                            <h4 class="padding_btm">Child birth at Home</h4>

                            <div class="birth_home">   
<?php $selected_bh_hm[$get_pat_mng_data[0]->birth_at_home] = "selected = selected"; ?>
                                <select name="birth_home" class="change-xhttp-request" data-base="birth_amb" data-href='{base_url}pcr/birth_amb' data-qr="output_position=birth_amb" data-errors="" tabindex="15">

                                    <option value="">Select</option>
                                    <option value="yes"<?php echo $selected_bh_hm['yes']; ?>>Yes</option>
                                    <option value="no" <?php echo $selected_bh_hm['no']; ?>>No</option>

                                </select>

                            </div>
                        </div>

                        <div class="pat_width">

                            <h4 class="padding_btm">Child birth at Ambulance</h4>
                            <div id="birth_amb"><?php $selected_bh_amb[$get_pat_mng_data[0]->birth_at_amb] = "selected = selected"; ?>
                                <select name="birth_amb" class="" data-errors="" tabindex="16">

                                    <option value="">Select</option>
                                    <option value="yes" <?php echo $selected_bh_amb['yes']; ?>>Yes</option>
                                    <option value="no" <?php echo $selected_bh_amb['no']; ?>>No</option>
                                </select>
                            </div>
                        </div>


                        <div class="pat_width">

                            <h4 class="padding_btm">Time of birth(24 hrs)</h4>

                            <div class="time_birth">

                                <input name="time_of_birth" value="<?php echo $get_pat_mng_data[0]->birth_time; ?>" class="mar_btm filter_if_not_blank filter_time_hms" data-errors="{filter_time_hms:'Time is not valid'}" placeholder="H:i:s" type="text" tabindex="17">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="cf_comp outer_apgr">

                    <div class="display_inlne_block width100">

                        <div class="style6">APGAR</div>

                        <div class="pat_width">

                            <h4 class="padding_btm">1 Min</h4>
                            <div class="score5">

                                <select name="score1" class="" data-errors="{filter_required:'Please select score from dropdown'}" tabindex="18">

                                    <option value="">Score</option>

<?php echo get_number($get_pat_mng_data[0]->ap_1min); ?>

                                </select>
                            </div>
                        </div>

                        <div class="pat_width">

                            <h4 class="padding_btm">5 Min</h4>

                            <div class="score5">

                                <select name="score5" class="" data-errors="{filter_required:'Please select score from dropdown'}" tabindex="19">

                                    <option value="">Score</option>

<?php echo get_number($get_pat_mng_data[0]->ap_1min); ?>
                                </select>

                            </div>


                        </div>


                    </div>
                </div>

            </div>


        </div>

        <div class="accept_outer">


            <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}pcr/save_patient_mng' data-qr='' tabindex="20">


        </div>

    </form>


</div>


<div class="next_pre_outer">
<?php
$step = $this->session->userdata('pcr_details');
if (!empty($step)) {
    ?>
        <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(6)"> < Prev </a>
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(8)"> Next > </a>
<?php } ?>
</div>
