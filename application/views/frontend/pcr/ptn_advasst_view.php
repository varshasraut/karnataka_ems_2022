<script> init_autocomplete();cur_pcr_step(6); pat_ass();  </script>

<?php $CI = EMS_Controller::get_instance(); ?>

<div class="head_outer"><h3 class="txt_clr2 width1">PATIENT ASSESSMENT</h3> </div>

<form method="post" name="" id="patient_add_asst">

    <input type="hidden" name="pcr_id" value="<?php echo $pcr_id; ?>">


    <div class="width100">

        <div class="width49 float_left outer_left_pt">

            <div class="width100 inline_fields">


                <div class="form_field dis_blk width20 hide_head">
                    <div class="label hide_head">&nbsp;</div>
                </div>

                <div class="form_field width20 hide_head">
                    <div class="label hide_head">10 Min<span class="md_field">*</span></div>
                </div>

                <div class="form_field width20 hide_head">
                    <div class="label hide_head">20 Min</div>
                </div>

                <div class="form_field width20 hide_head">
                    <div class="label hide_head">30 Min</div>
                </div>

                <div class="form_field width20 hide_head">
                    <div class="label hide_head">40 Min</div>
                </div>



                <div class="form_field dis_blk width20">
                    <div class="label">LOC</div>
                </div>

                

                    <div data-head="*" class="form_field width20 outer_loc">
                        <div class="outer_min"><span class="min">10 Min</span></div>

                    <div class="input top_left">

                        <input type="text" name="min_asst10[asst_loc]"  value="<?php echo $min_asst10[0]->asst_loc; ?>" class="mi_autocomplete filter_required" data-href="{base_url}auto/loc_level"  placeholder="Level" data-errors="{filter_required:'Please select LOC from dropdown list'}"  tabindex="1" data-ten="10 Min" data-value="<?php echo $min_asst10[0]->level_type; ?>">


                    </div>

                </div>

                 

                    <div data-head=" " class="form_field width20 outer_loc">
                       <div class="outer_min"><span class="min">20 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst20[asst_loc]"  value="<?php echo $min_asst20[0]->asst_loc; ?>" class="mi_autocomplete" data-href="{base_url}auto/loc_level"  placeholder="Level" data-value="<?php echo $min_asst20[0]->level_type; ?>" data-nonedit="yes" tabindex="2">


                    </div>

                </div>

                 

                    <div data-head=" " class="form_field width20 outer_loc">
                         <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst30[asst_loc]"  value="<?php echo $min_asst30[0]->asst_loc; ?>" class="mi_autocomplete" data-href="{base_url}auto/loc_level"  placeholder="Level" data-value="<?php echo $min_asst30[0]->level_type; ?>" data-nonedit="yes" tabindex="3">

                    </div>

                </div>

               
                    <div data-head=" " class="form_field width20 outer_loc">
                        <div class="outer_min"><span class="min">40 Min</span></div>


                    <div class="input">

                        <input type="text" name="min_asst40[asst_loc]"  value="<?php echo $min_asst40[0]->asst_loc; ?>" class="mi_autocomplete" data-href="{base_url}auto/loc_level"  placeholder="Level" data-value="<?php echo $min_asst40[0]->level_type; ?>" data-nonedit="yes" tabindex="4">


                    </div>

                </div>

                <div class="form_field dis_blk width20">
                    <div class="label">Pulse</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input type="text" name="min_asst10[asst_pulse]"  value="<?php echo $min_asst10[0]->asst_pulse; ?>" class="filter_required"  placeholder="Value" data-errors="{filter_required:'Pulse should not be blank'}" tabindex="5">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">20 Min</span></div>

                    <div class="input ">

                        <input type="text" name="min_asst20[asst_pulse]"  value="<?php echo $min_asst20[0]->asst_pulse; ?>" class=""  placeholder="Value" tabindex="6">


                    </div>

                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst30[asst_pulse]"  value="<?php echo $min_asst30[0]->asst_pulse; ?>" class=""  placeholder="Value" tabindex="7" >

                    </div>

                </div>

                <div data-head=" "class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst40[asst_pulse]"  value="<?php echo $min_asst40[0]->asst_pulse; ?>" class=""  placeholder="Value" tabindex="8" data-ten="40 Min">


                    </div>

                </div>



                <div class="form_field dis_blk width20">
                    <div class="label">RR</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                      <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input type="text" name="min_asst10[asst_rr]"  value="<?php echo $min_asst10[0]->asst_rr; ?>" class="filter_required"  placeholder="Value" data-errors="{filter_required:'RR should not be blank'}" tabindex="9">


                    </div>
                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">20 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst20[asst_rr]"  value="<?php echo $min_asst40[0]->asst_rr; ?>" class=""  placeholder="Value" tabindex="10">


                    </div>

                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                      <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst30[asst_rr]"  value="<?php echo $min_asst40[0]->asst_rr; ?>" class=""  placeholder="Value" tabindex="11">

                    </div>

                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">40 Min</span></div>

                    <div class="input">

                        <input type="text" name="min_asst40[asst_rr]"  value="<?php echo $min_asst40[0]->asst_rr; ?>" class=""  placeholder="Value" tabindex="12">


                    </div>

                </div>


                <div id="outer_bp">
                   
                    <div class="dyst_bp">
                        <div class="form_field dis_blk width20">
                            <div class="label width100 ">BP</div>
                        </div>

                        <div data-head="*" class="form_field width20 outer_loc">
                             <div class="outer_min"><span class="min">10 Min</span></div>
                            <div class="input top_left">

                                <input name="min_asst10[asst_bp_syt]" value="<?php echo $min_asst10[0]->asst_bp_syt; ?>" class="form_input filter_required" placeholder="Syt" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="13">


                            </div>
                        </div>
                   

                        <div data-head=" " class="form_field width20 outer_loc">
                            <div class="outer_min"><span class="min">20 Min</span></div>
                            <div class="input">

                                <input name="min_asst20[asst_bp_syt]" value="<?php echo $min_asst20[0]->asst_bp_syt; ?>" class="form_input" placeholder="Syt"  type="text" tabindex="14">


                            </div>

                        </div>

                        <div data-head=" " class="form_field width20 outer_loc">
                            <div class="outer_min"><span class="min">30 Min</span></div>

                            <div class="input">

                                <input name="min_asst30[asst_bp_syt]" value="<?php echo $asst[0]->asst_bp_syt; ?>" class="form_input" placeholder="Syt"  type="text" tabindex="15">

                            </div>

                        </div>

                        <div data-head=" " class="form_field width20 outer_loc">
                            <div class="outer_min"><span class="min">40 Min</span></div>

                            <div class="input">

                                <input name="min_asst40[asst_bp_syt]" value="<?php echo $min_asst40[0]->asst_bp_syt; ?>" class="form_input" placeholder="Syt"  type="text" tabindex="16">


                            </div>

                        </div>
                        
                    </div>
                    
                    
                   <div class="dyst_bp">

                        <div class="form_field dis_blk width20">
                            <div class="label">&nbsp;</div>
                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input top_left">

                                <input name="min_asst10[asst_bp_dia]" value="<?php echo $min_asst10[0]->asst_bp_dia; ?>" class="form_input filter_required" placeholder="Dys" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="17">


                            </div>

                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input">

                                <input name="min_asst20[asst_bp_dia]" value="<?php echo $min_asst20[0]->asst_bp_dia; ?>" class="form_input" placeholder="Dys" type="text" tabindex="18">

                            </div>

                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input">

                                <input name="min_asst30[asst_bp_dia]" value="<?php echo $min_asst30[0]->asst_bp_dia; ?>" class="form_input" placeholder="Dys"  type="text" tabindex="19">


                            </div>

                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input">

                                <input name="min_asst40[asst_bp_dia]" value="<?php echo $min_asst40[0]->asst_bp_dia; ?>" class="form_input" placeholder="Dys"  type="text" tabindex="20">


                            </div>

                        </div>
                       
                   </div>

               </div>


                <div class="form_field dis_blk width20">
                    <div class="label">O2sat</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                        <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input name="min_asst10[asst_o2sat]" value="<?php echo $min_asst10[0]->asst_o2sat; ?>"  class="form_input filter_required filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_required:'O2Sats should not be blank',filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="21">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input">

                        <input name="min_asst20[asst_o2sat]" value="<?php echo $min_asst20[0]->asst_o2sat; ?>"  class="filter_if_not_blank form_input filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="22">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>
                    <div class="input">

                        <input name="min_asst30[asst_o2sat]" value="<?php echo $min_asst30[0]->asst_o2sat; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="23">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">40 Min</span></div>
                    <div class="input">

                        <input name="min_asst40[asst_o2sat]" value="<?php echo $min_asst40[0]->asst_o2sat; ?>"  class="form_input  filter_if_not_blank filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="24">


                    </div>
                </div>

                <div class="form_field dis_blk width20">
                    <div class="label">Temp</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                       <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input name="min_asst10[asst_temp]" value="<?php echo $min_asst10[0]->asst_temp; ?>"  class="form_input filter_required filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_required:'Temp should not be blank',filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="25">


                    </div>
                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                       <div class="outer_min"><span class="min">20 Min</span></div>
                    <div class="input">

                        <input name="min_asst20[asst_temp]" value="<?php echo $min_asst20[0]->asst_temp; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="26">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input name="min_asst30[asst_temp]" value="<?php echo $min_asst30[0]->asst_temp; ?>"  class="filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="27">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">40 Min</span></div>
                    <div class="input">

                        <input name="min_asst40[asst_temp]" value="<?php echo $min_asst40[0]->asst_temp; ?>"  class="filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="28">


                    </div>

                </div>


                <div class="form_field dis_blk width20">
                    <div class="label">Pt Status</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input name="min_asst10[asst_pt_status]"  class="form_input mi_autocomplete filter_required" value="<?php echo $min_asst10[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt" data-errors="{filter_required:'Please select patient from dropdown list'}" type="text" data-value="<?php echo $min_asst10[0]->asst_pt_status; ?>" tabindex="29">

                    </div>
                </div>


                <div data-head=" " class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">20 Min</span></div>
                    <div class="input">

                        <input name="min_asst20[asst_pt_status]"  class="form_input mi_autocomplete" value="<?php echo $min_asst20[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt"  type="text" data-value="<?php echo $min_asst20[0]->asst_pt_status; ?>" data-nonedit="yes" tabindex="30">

                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">30 Min</span></div>
                    <div class="input">

                        <input name="min_asst30[asst_pt_status]"  class="form_input mi_autocomplete" value="<?php echo $min_asst30[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt"  type="text" data-value="<?php echo $min_asst30[0]->asst_pt_status; ?>" data-nonedit="yes" tabindex="31">

                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">40 Min</span></div>
                    <div class="input">

                        <input name="min_asst40[asst_pt_status]"  class="form_input mi_autocomplete" value="<?php echo $min_asst40[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt"  type="text" data-value="<?php echo $min_asst40[0]->asst_pt_status; ?>"  data-nonedit="yes" tabindex="32">

                    </div>
                </div>


                <div class="width100">


                    <div class="form_field width100">

                        <div class="label">Physical Assessment Notes</div>

                        <div class="input">

                            <textarea  class="text_area" name="add_asst[asst_phy_notes]" rows="5" cols="30"  data-maxlen="400" tabindex="33"><?php echo $add_asst[0]->asst_phy_notes; ?></textarea>

                        </div>

                    </div>

                </div>




            </div>


        </div>


        <div class="width49 prob_dia float_right">

            <div class="width100">


                <div class="form_field width100">

                    <div class="label">Probable Diagnosis<span class="md_field">*</span></div>



                </div>

            </div>


            <div class="box_type1">     





                <?php
                $tab = 34;

                if (!empty($pdignosis)) {

                    foreach ($pdignosis as $dig) {


                        $oth_opt = array('Others - specify' => 'ptn_other_dig');

                        if (!empty($asst_dig)) {

                            if (in_array($dig->dig_id, $asst_dig)) {

                                $checked[$dig->dig_id] = "checked";

                                $oth_dig = ($dig->dig_title == 'Others - specify') ? 'yes' : '';
                            }
                        }


                        $dig_ids[] = "dig_" . $dig->dig_id;
                        ob_start();
                        ?>

                        <div class="display-inline-block res_ch">

                            <label for="dig_<?php echo $dig->dig_id; ?>" class="chkbox_check">

                                <input name="dig[<?php echo $dig->dig_id; ?>]" class="check_input filter_either_or[(*:ids:*)] <?php echo $oth_opt[$dig->dig_title]; ?>" value="<?php echo $dig->dig_id; ?>" data-errors="{filter_either_or:'should not be blank!'}" id="dig_<?php echo $dig->dig_id; ?>" type="checkbox" <?php echo $checked[$dig->dig_id]; ?> tabindex="<?php echo $tab++; ?>"><span class="chkbox_check_holder"></span><?php echo $dig->dig_title; ?>


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



<?php if ($oth_dig == 'yes') { ?>


                    <div class="form_field width50">

                        <br>

                        <div class="input">

                            <input name="add_asst[asst_other_pdignosis]"  class="form_input" value="<?php echo $add_asst[0]->asst_other_pdignosis; ?>" placeholder="Other specify"  type="text" tabindex="<?php echo $tab++; ?>">

                        </div>
                    </div>


<?php } ?>


            </div>

        </div>



        <div class="save_btn_wrapper">


            <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}/pcr/save_ptn_advasst' data-qr="output_position=pat_details_block"  tabindex="<?php echo $tab++; ?>">


        </div>

    </div>

</form>




<div class="next_pre_outer">
<?php
$step = $this->session->userdata('pcr_details');
if (!empty($step)) {
    ?>
        <a href="#" class="prev_btn btn float_left" onclick="load_next_prev_step(5)" tabindex="<?php echo $tab++; ?>"> < Prev </a>
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(7)" tabindex="<?php echo $tab++; ?>"> Next > </a>
    <?php } ?>
</div>

