<script>cur_pcr_step(4);</script>

<?php $CI = EMS_Controller::get_instance(); ?>

<div class="head_outer"><h3 class="txt_clr2 width1">PATIENT ASSESSMENT - ON SCENE</h3> </div>

<form method="post" name="" id="patient_assessment">



    <input type="hidden" name="pcr_id" value="<?php echo $pcr_id; ?>">


    <div class="width100 ptn_asst">

        <div class="width49 float_left">



            <div class="form_field width50">

                <div class="label">LOC<span class="md_field">*</span></div>

                <div class="input">

                    <div class="input top_left">

                        <input type="text" name="asst[asst_loc]"  value="<?php echo $loc[0]->loc; ?>" class="mi_autocomplete filter_required" data-href="{base_url}auto/loc_level"  placeholder="LOC level" data-errors="{filter_required:'Please select LOC dropdown list'}" data-value="<?php echo $loc[0]->level_type; ?>" tabindex="1">

                    </div>

                </div>

            </div>


            <div class="width100 inline_fields">

                <div class="form_field width100">

                    <div class="label">Airway<span class="md_field">*</span></div>


                </div>


                <div class="form_field width25 select">

                    <div class="label">Patent</div>

                    <div class="input top_left">

                        <input name="asst[asst_pt_status]"  class="form_input mi_autocomplete filter_required" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Patent" data-href="{base_url}auto/get_yn_opt" data-errors="{filter_required:'Please select patient from dropdown list'}" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2">

                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label">Breathing</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_breath_satus]"  class="form_input mi_autocomplete filter_required" value="<?php echo $add_asst[0]->asst_breath_satus; ?>" placeholder="Select Breathing"  data-href="{base_url}auto/get_yn_opt" data-errors="{filter_required:'Please select breathing from dropdown'}" type="text" data-value="<?php echo $add_asst[0]->asst_breath_satus; ?>" tabindex="3">



                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label non_clss">&nbsp;</div>

                    <div class="input top_left">


                        <input name="add_asst[asst_breath_rate]" value="<?php echo $add_asst[0]->asst_breath_rate; ?>" class="form_input mi_autocomplete filter_required" placeholder="Rate" data-href="{base_url}auto/get_br_rate" data-errors="{filter_required:'Please select breathing from dropdown'}" type="text" data-value="<?php echo $add_asst[0]->rate_type; ?>" tabindex="4">

                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label non_clss">&nbsp;</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_breath_effort]" value="<?php echo $add_asst[0]->asst_breath_effort; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Effort" data-href="{base_url}auto/get_br_effort" data-errors="{filter_required:'Please select breathing from dropdown'}" type="text" data-value="<?php echo $add_asst[0]->effort_type; ?>" tabindex="5">

                    </div>

                </div>

            </div>



            <div class="width100 inline_fields">

                <div class="form_field width100">

                    <div class="label">Circulation<span class="md_field">*</span></div>

                </div>


                <div class="form_field width25 select">

                    <div class="label">Pulse</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_pulse_radial]" value="<?php echo $add_asst[0]->asst_pulse_radial; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Radial" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">

                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label dis_none1 none_prop">&nbsp;</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_pulse_carotid]" value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Carotid" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select pulse from dropdown'}" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>" tabindex="7">

                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label non_clss">&nbsp;</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_pulse_cap]"  value="<?php echo $add_asst[0]->asst_pulse_cap; ?>" class="form_input mi_autocomplete filter_required" placeholder="CAP Refil" data-href="{base_url}auto/get_pulse_cap" data-errors="{filter_required:'Please select CAP from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->pc_type; ?>" tabindex="8">


                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label non_clss">&nbsp;</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_pulse_skin]"  value="<?php echo $add_asst[0]->asst_pulse_skin; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Skin" data-href="{base_url}auto/get_pulse_skin"  data-errors="{filter_required:'Please select skin from dropdown list'}" type="text"  data-value="<?php echo $add_asst[0]->ps_type; ?>" tabindex="9">

                    </div>

                </div>


                <div class="form_field width25 select">

                    <div class="label">GCS</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_gcs]" value="<?php echo $add_asst[0]->asst_gcs; ?>" class="form_input mi_autocomplete filter_required" placeholder="Score" data-href="{base_url}auto/gcs_score" data-errors="{filter_required:'Please select GCS from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->score; ?>"  tabindex="10">

                    </div>

                </div>

                <div class="form_field width25 ">

                    <div class="label">BSL</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_bsl]" value="<?php echo $add_asst[0]->asst_bsl; ?>" class="form_input" placeholder="BSL"  data-errors="{filter_required:'BSL should not be blank'}" type="text" tabindex="11">

                    </div>

                </div>

                <div class="form_field width25 select">

                    <div class="label">Pupils</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_pupils_right]" value="<?php echo $add_asst[0]->asst_pupils_right; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Right" data-href="{base_url}auto/pupils_type" data-errors="{filter_required:'Please select pupils from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->pp_type_right; ?>" tabindex="12">

                    </div>


                </div>

                <div class="form_field width25 select">

                    <div class="label dis_none1 none_prop">&nbsp;</div>

                    <div class="input top_left">

                        <input name="add_asst[asst_pupils_left]" value="<?php echo $add_asst[0]->asst_pupils_left; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Left" data-href="{base_url}auto/pupils_type" data-errors="{filter_required:'Please select pupils from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->pp_type_left; ?>" tabindex="13">

                    </div>

                </div>

            </div>

        </div>


        <div class="width49 float_right">

            <div class="width100 inline_fields">

                <div class="form_field width50">

                    <div class="label">Pulse<span class="md_field">*</span></div>

                    <div class="input">

                        <input name="asst[asst_pulse]" value="<?php echo $asst[0]->asst_pulse; ?>"  class="form_input filter_required" placeholder="Pulse" data-errors="{filter_required:'Pulse should not be blank!'}" type="text"  tabindex="14">

                    </div>

                </div>


                <div class="form_field width50">

                    <div class="label">RR<span class="md_field">*</span></div>

                    <div class="input">

                        <input name="asst[asst_rr]" value="<?php echo $asst[0]->asst_rr; ?>" class="form_input filter_required" placeholder="RR" data-errors="{filter_required:'RR should not be blank!'}" type="text"  tabindex="15">

                    </div>

                </div>

                <div class="form_field width50">

                    <div class="label">BP<span class="md_field">*</span></div>

                    <div class="input">

                        <input name="asst[asst_bp_syt]" value="<?php echo $asst[0]->asst_bp_syt; ?>" class="form_input filter_required" placeholder="Syt" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16">

                    </div>

                </div>

                <div class="form_field width50">

                    <div class="label dis_none1 none_prop">&nbsp;</div>

                    <div class="input">

                        <input name="asst[asst_bp_dia]" value="<?php echo $asst[0]->asst_bp_dia; ?>" class="form_input filter_required" placeholder="Dia" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="17">

                    </div>

                </div>

                <div class="form_field width50">

                    <div class="label">O2Sat</div>

                    <div class="input">

                        <input name="asst[asst_o2sat]" value="<?php echo $asst[0]->asst_o2sat; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_required:'O2Sats should not be blank',filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="18">

                    </div>


                </div>



                <div class="form_field width50">

                    <div class="label">Temp</div>

                    <div class="input">

                        <input name="asst[asst_temp]" value="<?php echo $asst[0]->asst_temp; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_required:'Temp should not be blank',filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="19">

                    </div>



                </div>


                <div class="width100 inline_fields outer_lf_rf">

                    <div class="form_field width100">

                        <div class="label">Lung Auscultation</div>

                    </div>


                    <div class="form_field width25 select">

                        <div class="label">Right<span class="md_field">*</span></div>

                        <div class="input">

                            <input name="add_asst[asst_la_right_air]" value="<?php echo $add_asst[0]->asst_la_right_air; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Air Entry" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select right from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_la_right_air; ?>" tabindex="20">



                        </div>

                    </div>

                    <div class="form_field width25 select">

                        <div class="label dis_none1 none_prop">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_la_right_adds]" value="<?php echo $add_asst[0]->asst_la_right_adds; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Add. Sound" data-href="{base_url}auto/get_lung_aus" data-errors="{filter_required:'Please select right from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->right_la; ?>" tabindex="21">


                        </div>

                    </div>

                    <div class="form_field width25 select">

                        <div class="label">Left<span class="md_field">*</span></div>

                        <div class="input">

                            <input name="add_asst[asst_la_left_air]"  value="<?php echo $add_asst[0]->asst_la_left_air; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Air Entry" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select left from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->asst_la_left_air; ?>" tabindex="22">

                        </div>

                    </div>

                    <div class="form_field width25 select">

                        <div class="label dis_none1 none_prop">&nbsp;</div>

                        <div class="input">

                            <input name="add_asst[asst_la_left_adds]" value="<?php echo $add_asst[0]->asst_la_left_adds; ?>" class="form_input mi_autocomplete filter_required" placeholder="Add. Sound" data-href="{base_url}auto/get_lung_aus" data-errors="{filter_required:'Please select left from dropdown list'}" type="text" data-value="<?php echo $add_asst[0]->left_la; ?>" tabindex="23">

                        </div>


                    </div>

                </div>


                <div class="width100">


                    <div class="form_field width100">

                        <div class="label">Patient History<span class="md_field">*</span></div>

                        <div class="input">

                            <textarea tabindex="24" class="text_area  filter_required" name="add_asst[asst_ptn_his]" rows="5" cols="30" data-errors="{filter_required:'History should not be blank'}" data-maxlen="400"><?php echo $add_asst[0]->asst_ptn_his; ?></textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="accept_outer width100">


            <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_ptn_asst' data-qr="output_position=pat_details_block"  tabindex="25">


        </div>

    </div>

</form>
<div class="next_pre_outer">
    <?php
    $step = $this->session->userdata('pcr_details');
    if (!empty($step)) {
        ?>
        <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(3)"> < Prev </a>
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(5)"> Next > </a>
    <?php } ?>
</div>


