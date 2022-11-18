<script>cur_pcr_step(9);</script>

<div class="width100">
    <div class="head_outer">
        <h2>Hospital Transfer/Ambulance</h2>
    </div>
    <form method="post" name="" id="patient_assessment" class="hos_trans">
        <div class="width100">
            <div class="width30 float_left">
                <h3>Hospital Detail/Ambulance</h3>
                <div class="width100">

                    <div class="form_field width100 loc_hosp">
                        <div class="label pad_tp">Hospital Name <span class="md_field">*</span></div>
                        <div class="input">
                            <input name="hosp[hospital_name]" tabindex="1" class="mi_autocomplete form_input filter_required" placeholder="Enter Name of Receiving Hospital" type="text" data-base="search_btn" data-errors="{filter_required:'Please select hospital from dropdown'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?= @$hospital[0]->hp_name; ?>" value="<?= @$hospital[0]->hp_id; ?>">
                        </div>
                    </div>

                    <div class="form_field width100">

                        <div class="label padd_btm"><label for="type_hp">Type of hospital<span class="md_field">*</span></label></div>

                        <div class="input loc_hosp">
                            <select name="hosp[type_of_hospital]" tabindex="1" class="amb_status filter_required" <?php echo $view; ?> TABINDEX="2" data-errors="{filter_required:'Type of hospital should not be blank!'}" >

                                <option value="">Type of hospital <span class="md_field">*</span></option>

                                <?php echo get_hosp_type(@$hospital[0]->type_of_hospital); ?>

                            </select>
                        </div>
                    </div>
                    <div class="form_field hand_time width100 loc_hosp">

                        <div class="label padd_btm tp"><label for="time_of_handover">Time of handover<span class="md_field">*</span></label></div>

                        <div class="input">
                            <input name="hosp[hos_handover_time]" tabindex="2" class="filter_number form_input filter_required" placeholder="Time of handover" type="text" data-base="search_btn" data-errors="{filter_required:'Time of handover should not be blank!',filter_number:'Allowed in numbers'}" value="<?= @$hospital[0]->hos_handover_time; ?>">
                        </div>


                    </div>
                    <div class="form_field hand_time width100 loc_hosp">

                        <div class="label padd_btm"><label for="person_handover">Person taking handover<span class="md_field">*</span></label></div>

                        <div class="input">

                            <input name="hosp[person_handover_name]" tabindex="3" class="form_input filter_required ucfirst filter_string" placeholder="Person taking handover" type="text" data-base="search_btn" data-errors="{filter_required:'Handover should not be blank!',filter_string:'Person taking handover should have alphabets'}" value="<?= @$hospital[0]->person_handover_name; ?>">

                        </div>

                        <div class="input">

                            <input name="hosp[person_designation]" tabindex="4" class="form_input filter_required ucfirst" placeholder="Designation" type="text" data-base="search_btn" data-errors="{filter_required:'Designation should not be blank!'}" value="<?= @$hospital[0]->person_designation; ?>" >


                        </div>


                    </div>
                    <div class="form_field width100">

                        <div class="label hand_time"><label for="police_present">Police Present<span class="md_field">*</span></label></div>

                        <label for="police_present_yes" class="radio_check width20 float_left top_left">         
                            <input id="police_present_yes" type="radio" name="hosp[police_present]" class="radio_check_input filter_either_or[police_present_yes,police_present_no,police_present_na]"  data-errors="{filter_either_or:'Should not be blank'}" value="Yes" data-base="search_btn" <?php
                            if ($hospital[0]->police_present == 'Yes') {
                                echo "checked";
                            }
                            ?>><span class="radio_check_holder"></span>Yes
                        </label>
                        <label for="police_present_no" class="radio_check width20 float_left top_left">         
                            <input id="police_present_no" type="radio" name="hosp[police_present]" class="radio_check_input filter_either_or[police_present_yes,police_present_no,police_present_na]"  data-errors="{filter_either_or:'Should not be blank'}" value="No" data-base="search_btn" <?php
                            if ($hospital[0]->police_present == 'N0') {
                                echo "checked";
                            }
                            ?>><span class="radio_check_holder"></span>No
                        </label>
                        <label for="police_present_na" class="radio_check width20 float_left top_left">         
                            <input id="police_present_na" type="radio"  name="hosp[police_present]" class="radio_check_input filter_either_or[police_present_yes,police_present_no,police_present_na]"  data-errors="{filter_either_or:'Should not be blank'}" value="Na" data-base="search_btn" <?php
                            if ($hospital[0]->police_present == 'Na') {
                                echo "checked";
                            }
                            ?>><span class="radio_check_holder"></span>NA
                        </label>


                    </div>
                    <div class="form_field  width100">

                        <div class="label hand_time"><label for="evidence_handover">Evidence Handed over:<span class="md_field">*</span></label></div>
                        <label for="evidence_handover_yes" class="radio_check width20 float_left top_left">         
                            <input id="evidence_handover_yes" type="radio" name="hosp[evidence_handover]" class="radio_check_input filter_either_or[evidence_handover_yes,evidence_handover_no,evidence_handover_na]" data-errors="{filter_either_or:'Should not be blank'}" value="Yes" data-base="search_btn" <?php
                            if ($hospital[0]->evidence_handover == 'Yes') {
                                echo "checked";
                            }
                            ?>><span class="radio_check_holder"></span>Yes
                        </label>
                        <label for="evidence_handover_no" class="radio_check width20 float_left top_left">         
                            <input id="evidence_handover_no" type="radio" name="hosp[evidence_handover]" class="radio_check_input filter_either_or[evidence_handover_yes,evidence_handover_no,evidence_handover_na]" data-errors="{filter_either_or:'Should not be blank'}" value="No" data-base="search_btn" <?php
                            if ($hospital[0]->evidence_handover == 'No') {
                                echo "checked";
                            }
                            ?>><span class="radio_check_holder"></span>No
                        </label>
                        <label for="evidence_handover_na" class="radio_check width20 float_left top_left">         
                            <input id="evidence_handover_na" type="radio" name="hosp[evidence_handover]" class="radio_check_input filter_either_or[evidence_handover_yes,evidence_handover_no,evidence_handover_na]" data-errors="{filter_either_or:'Should not be blank'}" value="Na" data-base="search_btn" <?php
                            if ($hospital[0]->evidence_handover == 'Na') {
                                echo "checked";
                            }
                            ?>><span class="radio_check_holder"></span>NA
                        </label>


                    </div>
                    <div class="form_field width100">

                        <div class="label"><label for="details">Details:<span class="md_field">*</span></label></div>

                        <div class="input">
                            <textarea name="hosp[hospital_details]" class="filter_required"  data-errors="{filter_required:'Details should not be blank'}" tabindex="5" placeholder="Details"><?= @$hospital[0]->person_designation; ?></textarea>
                        </div>

                    </div>
                </div>


            </div>
            <div class="width70 float_left">
                <h3>Patient condition at handover</h3>
                <div class="width100">
                    <div class="form_field width50 float_left loc_hosp">

                        <div class="label">LOC<span class="md_field">*</span></div>

                        <div class="input">

                            <div class="input">

                                <input type="text" name="asst[asst_loc]"  value="<?php echo $asst[0]->asst_loc; ?>" class="mi_autocomplete filter_required ucfirst" data-href="{base_url}auto/loc_level"  placeholder="Enter LOC level" data-errors="{filter_required:'Please select dropdown list'}" data-value="<?php echo $asst[0]->level_type; ?>" tabindex="6">

                            </div>

                        </div>

                    </div>
                    <div class="width50 float_left pls_outer">
                        <div class="form_field width50 float_left">
                            <div class="label">Pulse<span class="md_field">*</span></div>

                            <div class="input">

                                <input name="asst[asst_pulse]" value="<?php echo $asst[0]->asst_pulse; ?>"  class="form_input filter_required" placeholder="Enter Pulse" data-errors="{filter_required:'Pulse should not be blank!'}" type="text"  tabindex="7">

                            </div>
                        </div>
                        <div class="form_field width50 float_left">

                            <div class="label">RR<span class="md_field">*</span></div>

                            <div class="input">

                                <input name="asst[asst_rr]" value="<?php echo $asst[0]->asst_rr; ?>" class="form_input filter_required" placeholder="Enter RR" data-errors="{filter_required:'RR should not be blank!'}" type="text"  tabindex="15">

                            </div>

                        </div>

                    </div>
                    <div class="width100 inline_fields outer_air">

                        <div class="form_field width100">

                            <div class="label">Airway<span class="md_field">*</span></div>


                        </div>


                        <div class="form_field width25">

                            <div class="label">Patent <span class="md_field">*</span></div>

                            <div class="input">

                                <input name="asst[asst_pt_status]"  class="form_input mi_autocomplete filter_required" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Patent" data-href="{base_url}auto/get_yn_opt" data-errors="{filter_required:'Please select dropdown list'}" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2">

                            </div>

                        </div>

                        <div class="form_field width25">

                            <div class="label">Breathing <span class="md_field">*</span></div>

                            <div class="input">

                                <input name="add_asst[asst_breath_satus]"  class="form_input mi_autocomplete filter_required" value="<?php echo $add_asst[0]->asst_breath_satus; ?>" placeholder="Select Breathing"  data-href="{base_url}auto/get_yn_opt" data-errors="{filter_required:'Please select dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_breath_satus; ?>" tabindex="3">



                            </div>

                        </div>

                        <div class="form_field width25">

                            <div class="label disnon">&nbsp;</div>

                            <div class="input">


                                <input name="add_asst[asst_breath_rate]" value="<?php echo $add_asst[0]->asst_breath_rate; ?>" class="form_input mi_autocomplete filter_required" placeholder="Rate" data-href="{base_url}auto/get_br_rate" data-errors="{filter_required:'Please select dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->rate_type; ?>" tabindex="4">

                            </div>

                        </div>

                        <div class="form_field width25">

                            <div class="label disnon">&nbsp;</div>

                            <div class="input">

                                <input name="add_asst[asst_breath_effort]" value="<?php echo $add_asst[0]->asst_breath_effort; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Effort" data-href="{base_url}auto/get_br_effort" data-errors="{filter_required:'Please select dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->effort_type; ?>" tabindex="5">

                            </div>

                        </div>

                    </div>

                </div>
                <div class="width100 inline_fields outer_air">

                    <div class="form_field width100">
  <h3>Circulation</h3>
<!--                        <div class="label">Circulation<span class="md_field">*</span></div>-->

                    </div>


                    <div class="form_field width25">

                        <div class="label">Pulse <span class="md_field">*</span></div>

                        <div class="input top_left">

                            <input name="add_asst[asst_pulse_radial]" value="<?php echo $add_asst[0]->asst_pulse_radial; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Radial" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">



                        </div>

                    </div>

                    <div class="form_field width25">

                        <div class="label none_prop">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_pulse_carotid]" value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Carotid" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>" tabindex="7">

                        </div>

                    </div>

                    <div class="form_field width25">

                        <div class="label disnon">&nbsp;</div>

                        <div class="input top_left">

                            <input name="add_asst[asst_pulse_cap]"  value="<?php echo $add_asst[0]->asst_pulse_cap; ?>" class="form_input mi_autocomplete filter_required" placeholder="CAP Refil" data-href="{base_url}auto/get_pulse_cap" data-errors="{filter_required:'Please select CAP from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->pc_type; ?>" tabindex="8">


                        </div>

                    </div>

                    <div class="form_field width25">

                        <div class="label disnon">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_pulse_skin]"  value="<?php echo $add_asst[0]->asst_pulse_skin; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Skin" data-href="{base_url}auto/get_pulse_skin"  data-errors="{filter_required:'Please select skin from dropdown list'}" type="text"  data-value="<?php echo $add_asst[0]->ps_type; ?>" tabindex="9">

                        </div>

                    </div>


                    <div class="form_field width25 outer_air">

                        <div class="label">GCS <span class="md_field">*</span></div>

                        <div class="input top_left">

                            <input name="add_asst[asst_gcs]" value="<?php echo $add_asst[0]->asst_gcs; ?>" class="form_input mi_autocomplete filter_required" placeholder="Score" data-href="{base_url}auto/gcs_score" data-errors="{filter_required:'Please select GCS from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->score; ?>"  tabindex="10">



                        </div>

                    </div>

                    <div class="form_field width25 outer_air">

                        <div class="label">BSL <span class="md_field">*</span></div>

                        <div class="input">

                            <input name="add_asst[asst_bsl]" value="<?php echo $add_asst[0]->asst_bsl; ?>" class="form_input filter_required" placeholder="Enter BSL"  data-errors="{filter_required:'BSL should not be blank'}" type="text" tabindex="11">

                        </div>

                    </div>

                    <div class="form_field width25 outer_air">

                        <div class="label">Pupils <span class="md_field">*</span></div>

                        <div class="input top_left">

                            <input name="add_asst[asst_pupils_right]" value="<?php echo $add_asst[0]->asst_pupils_right; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Right" data-href="{base_url}auto/pupils_type" data-errors="{filter_required:'Please select pupils from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->pp_type_right; ?>" tabindex="12">

                        </div>


                    </div>

                    <div class="form_field width25 outer_air">

                        <div class="label none_prop">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_pupils_left]" value="<?php echo $add_asst[0]->asst_pupils_left; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Left" data-href="{base_url}auto/pupils_type" data-errors="{filter_required:'Please select pupils from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->pp_type_left; ?>" tabindex="13">

                        </div>

                    </div>

                </div>
                <div class="form_field width50 float_left">

                    <div class="label">BP<span class="md_field">*</span></div>

                    <div class="input top_left">

                        <input name="asst[asst_bp_syt]" value="<?php echo $asst[0]->asst_bp_syt; ?>" class="inp_bp form_input filter_required" placeholder="SYT" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16">

                    </div>

                </div>

                <div class="form_field width50 float_left">

                    <div class="label none_prop">&nbsp;</div>

                    <div class="input">

                        <input name="asst[asst_bp_dia]" value="<?php echo $asst[0]->asst_bp_dia; ?>" class="inp_bp form_input filter_required" placeholder="Dia" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="17">

                    </div>

                </div>

                <div class="form_field width50 float_left">

                    <div class="label">O2Sat<span class="md_field">*</span></div>

                    <div class="input">

                        <input name="asst[asst_o2sat]" value="<?php echo $asst[0]->asst_o2sat; ?>"  class="inp_bp form_input filter_required filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_required:'O2Sats should not be blank',filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="18">

                    </div>


                </div>



                <div class="form_field width50 float_left">

                    <div class="label">Temp <span class="md_field">*</span></div>

                    <div class="input">

                        <input name="asst[asst_temp]" value="<?php echo $asst[0]->asst_temp; ?>"  class="inp_bp form_input filter_required filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_required:'Temp should not be blank',filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="19">

                    </div>



                </div>


                <div class="width100 inline_fields outer_air">

                    <div class="form_field width100">

                        <h3>Lung Auscultation</h3>

                    </div>


                    <div class="form_field width25 ">

                        <div class="label">Right<span class="md_field">*</span></div>

                        <div class="input top_left">

                            <input name="add_asst[asst_la_right_air]" value="<?php echo $add_asst[0]->asst_la_right_air; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Air Entry" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select right from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_la_right_air; ?>" tabindex="20">



                        </div>

                    </div>

                    <div class="form_field width25">

                        <div class="label none_prop">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_la_right_adds]" value="<?php echo $add_asst[0]->asst_la_right_adds; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Add. Sound" data-href="{base_url}auto/get_lung_aus" data-errors="{filter_required:'Please select right from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->right_la; ?>" tabindex="21">


                        </div>

                    </div>

                    <div class="form_field width25">

                        <div class="label">Left<span class="md_field">*</span></div>

                        <div class="input top_left">

                            <input name="add_asst[asst_la_left_air]"  value="<?php echo $add_asst[0]->asst_la_left_air; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Air Entry" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select left from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_la_left_air; ?>" tabindex="22">

                        </div>

                    </div>

                    <div class="form_field width25">

                        <div class="label none_prop">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_la_left_adds]" value="<?php echo $add_asst[0]->asst_la_left_adds; ?>" class="form_input mi_autocomplete filter_required" placeholder="Add. Sound" data-href="{base_url}auto/get_lung_aus" data-errors="{filter_required:'Please select left from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->left_la; ?>" tabindex="23">

                        </div>


                    </div>
                    <div class="form_field width100 out_med">

                        <div class="label">Ongoing Medication<span class="md_field">*</span></div>

                        <div class="input">
                            <textarea name="asst[ongoin_medication]" placeholder="Ongoing Medication" class="inp_bp filter_required"  data-errors="{filter_required:'Medication should not be blank'}"><?php echo $asst[0]->ongoin_medication; ?></textarea>


                        </div>


                    </div>

                </div>
            </div>

            <div class="accept_outer width100">


                <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_transfer_hospital' data-qr="output_position=pat_details_block"  tabindex="22">


            </div>
        </div>
    </form>
</div>
<div class="next_pre_outer">
    <?php
    $step = $this->session->userdata('pcr_details');
    if (!empty($step)) {
        ?>
        <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(8)"> < Prev </a>
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(10)"> Next > </a>
    <?php } ?>
</div>