<?php
$CI = EMS_Controller::get_instance();


?>

<div class="head_outer"><h3 class="txt_clr2 width1">Sick Room Treatment</h3> </div>

<form method="post" name="" id="sick_room">

    <input type="hidden" name="sick_id" value="<?php echo $sick_id; ?>">
    <input type="hidden" name="student_id" value="<?php echo $stud_sickroom[0]->student_id; ?>">
    <input type="hidden" name="schedule_id" value="<?php echo $stud_sickroom[0]->schedule_id; ?>">


    <div class="width2 float_left">
        <div class="width100 float_left">
          <h3 class="txt_clr2 width1">Sick Room</h3>
                <div class="form_field width100 select float_left">
                            <div class="label">Doctor's treatment notes</div>
                            <div class="input top_left">

                                <textarea name="sick[doctor_note]"><?php echo $stud_sickroom[0]->doctor_note;?></textarea>

                            </div>
                </div>
                <div class="form_field width100 select float_left">
                            <div class="label">Reassessment notes</div>
                            <div class="input top_left">
                                <textarea name="sick[treatment_order]"><?php echo $stud_sickroom[0]->treatment_order;?></textarea>
                            </div>
                    </div>


        </div>
        <div class="width100 float_left">
          <h3 class="txt_clr2 width1">Health supervisor remarks</h3>
                    <div class="form_field width100 select float_left">
                            <div class="label">Health supervisor remarks</div>
                            <div class="input top_left">

                                <textarea name="sick[health_supervisor_remark]" ><?php echo $stud_sickroom[0]->health_supervisor_remark;?></textarea>

                            </div>
                    </div>



        </div>
        <div class="width100 float_left">

                    <div class="form_field width100 select float_left">
                            <div class="label">Time in</div>
                            <div class="input top_left">

                                <input type="text" name="sick[in_time]" class="mi_timecalender" value="<?php if($stud_sickroom[0]->in_time != '0000-00-00 00:00:00') { date('Y-m-d h:i A',strtotime($stud_sickroom[0]->in_time)); }?>" placeholder="Time in">

                            </div>
                    </div>
                    <div class="form_field width100 select float_left">
                            <div class="label">Time Out</div>
                            <div class="input top_left">

                                <input type="text" name="sick[out_time]" class="mi_timecalender" value="<?php if($stud_sickroom[0]->out_time != '0000-00-00 00:00:00') { date('Y-m-d h:i A',strtotime($stud_sickroom[0]->out_time)); } ?>" placeholder="Time Out">

                            </div>
                    </div>
                    <div class="form_field width100 select float_left">
                        <div class="label">Discharge To</div>
                        <label for="home" class="radio_check width_33 float_left">
                            <input type="radio" name="sick[discharge_to]" class="radio_check_input unit_checkbox" value="home"  id="home" <?php
                            if ($stud_sickroom[0]->discharge_to == "home") {
                                echo "checked";
                            }
                            ?>>
                            <span class="radio_check_holder"></span>Home
                        </label>
                        <label for="hospital" class="radio_check width_33 float_left">
                            <input type="radio" name="sick[discharge_to]" class="radio_check_input unit_checkbox" value="hospital"  id="hospital" <?php
                           if ($stud_sickroom[0]->discharge_to == "hospital") {
                                echo "checked";
                            }
                            ?>>
                            <span class="radio_check_holder"></span>Hospital
                        </label>
                    </div>
                    <div class="form_field width100 select float_left">
                            <div class="label">Seen by</div>
                            <div class="input top_left">

                                 <input name="sick[send_by]" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=UG-HEALTH-SUP"  data-value="<?php echo $stud_sickroom[0]->send_by ;?>" value="<?php echo $stud_sickroom[0]->send_by ;?>" type="text" tabindex="2" placeholder="Send By">

                            </div>
                     </div>


        </div>
    </div>
    <div class="width2 float_left">
        <div class="width100">
            <h3 class="txt_clr2 width1">Periodic Assessment</h3>
            <div class="width100 float_left outer_left_pt" style="margin-top:5px;">

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

                        <input type="text" name="sick_asst10[asst_loc]"  value="<?php echo $min_asst10[0]->asst_loc; ?>" class="mi_autocomplete filter_required" data-href="{base_url}auto/loc_level"  placeholder="Level" data-errors="{filter_required:'Please select LOC from dropdown list'}"  tabindex="1" data-ten="10 Min" data-value="<?php echo $min_asst10[0]->level_type; ?>">


                    </div>

                </div>

                 

                    <div data-head=" " class="form_field width20 outer_loc">
                       <div class="outer_min"><span class="min">20 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst20[asst_loc]"  value="<?php echo $min_asst20[0]->asst_loc; ?>" class="mi_autocomplete" data-href="{base_url}auto/loc_level"  placeholder="Level" data-value="<?php echo $min_asst20[0]->level_type; ?>" data-nonedit="yes" tabindex="2">


                    </div>

                </div>

                 

                    <div data-head=" " class="form_field width20 outer_loc">
                         <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst30[asst_loc]"  value="<?php echo $min_asst30[0]->asst_loc; ?>" class="mi_autocomplete" data-href="{base_url}auto/loc_level"  placeholder="Level" data-value="<?php echo $min_asst30[0]->level_type; ?>" data-nonedit="yes" tabindex="3">

                    </div>

                </div>

               
                    <div data-head=" " class="form_field width20 outer_loc">
                        <div class="outer_min"><span class="min">40 Min</span></div>


                    <div class="input">

                        <input type="text" name="sick_asst40[asst_loc]"  value="<?php echo $min_asst40[0]->asst_loc; ?>" class="mi_autocomplete" data-href="{base_url}auto/loc_level"  placeholder="Level" data-value="<?php echo $min_asst40[0]->level_type; ?>" data-nonedit="yes" tabindex="4">


                    </div>

                </div>

                <div class="form_field dis_blk width20">
                    <div class="label">Pulse</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input type="text" name="sick_asst10[asst_pulse]"  value="<?php echo $min_asst10[0]->asst_pulse; ?>" class="filter_required"  placeholder="Value" data-errors="{filter_required:'Pulse should not be blank'}" tabindex="5">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">20 Min</span></div>

                    <div class="input ">

                        <input type="text" name="sick_asst20[asst_pulse]"  value="<?php echo $min_asst20[0]->asst_pulse; ?>" class=""  placeholder="Value" tabindex="6">


                    </div>

                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst30[asst_pulse]"  value="<?php echo $min_asst30[0]->asst_pulse; ?>" class=""  placeholder="Value" tabindex="7" >

                    </div>

                </div>

                <div data-head=" "class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst40[asst_pulse]"  value="<?php echo $min_asst40[0]->asst_pulse; ?>" class=""  placeholder="Value" tabindex="8" data-ten="40 Min">


                    </div>

                </div>



                <div class="form_field dis_blk width20">
                    <div class="label">RR</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                      <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input type="text" name="sick_asst10[asst_rr]"  value="<?php echo $min_asst10[0]->asst_rr; ?>" class="filter_required"  placeholder="Value" data-errors="{filter_required:'RR should not be blank'}" tabindex="9">


                    </div>
                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">20 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst20[asst_rr]"  value="<?php echo $min_asst40[0]->asst_rr; ?>" class=""  placeholder="Value" tabindex="10">


                    </div>

                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                      <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst30[asst_rr]"  value="<?php echo $min_asst40[0]->asst_rr; ?>" class=""  placeholder="Value" tabindex="11">

                    </div>

                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">40 Min</span></div>

                    <div class="input">

                        <input type="text" name="sick_asst40[asst_rr]"  value="<?php echo $min_asst40[0]->asst_rr; ?>" class=""  placeholder="Value" tabindex="12">


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

                                <input name="sick_asst10[asst_bp_syt]" value="<?php echo $min_asst10[0]->asst_bp_syt; ?>" class="form_input filter_required" placeholder="Syt" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="13">


                            </div>
                        </div>
                   

                        <div data-head=" " class="form_field width20 outer_loc">
                            <div class="outer_min"><span class="min">20 Min</span></div>
                            <div class="input">

                                <input name="sick_asst20[asst_bp_syt]" value="<?php echo $min_asst20[0]->asst_bp_syt; ?>" class="form_input" placeholder="Syt"  type="text" tabindex="14">


                            </div>

                        </div>

                        <div data-head=" " class="form_field width20 outer_loc">
                            <div class="outer_min"><span class="min">30 Min</span></div>

                            <div class="input">

                                <input name="sick_asst30[asst_bp_syt]" value="<?php echo $asst[0]->asst_bp_syt; ?>" class="form_input" placeholder="Syt"  type="text" tabindex="15">

                            </div>

                        </div>

                        <div data-head=" " class="form_field width20 outer_loc">
                            <div class="outer_min"><span class="min">40 Min</span></div>

                            <div class="input">

                                <input name="sick_asst40[asst_bp_syt]" value="<?php echo $min_asst40[0]->asst_bp_syt; ?>" class="form_input" placeholder="Syt"  type="text" tabindex="16">


                            </div>

                        </div>
                        
                    </div>
                    
                    
                   <div class="dyst_bp">

                        <div class="form_field dis_blk width20">
                            <div class="label">&nbsp;</div>
                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input top_left">

                                <input name="sick_asst10[asst_bp_dia]" value="<?php echo $min_asst10[0]->asst_bp_dia; ?>" class="form_input filter_required" placeholder="Dys" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="17">


                            </div>

                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input">

                                <input name="sick_asst20[asst_bp_dia]" value="<?php echo $min_asst20[0]->asst_bp_dia; ?>" class="form_input" placeholder="Dys" type="text" tabindex="18">

                            </div>

                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input">

                                <input name="sick_asst30[asst_bp_dia]" value="<?php echo $min_asst30[0]->asst_bp_dia; ?>" class="form_input" placeholder="Dys"  type="text" tabindex="19">


                            </div>

                        </div>

                        <div class="form_field width20 outer_loc">


                            <div class="input">

                                <input name="sick_asst40[asst_bp_dia]" value="<?php echo $min_asst40[0]->asst_bp_dia; ?>" class="form_input" placeholder="Dys"  type="text" tabindex="20">


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

                        <input name="sick_asst10[asst_o2sat]" value="<?php echo $min_asst10[0]->asst_o2sat; ?>"  class="form_input filter_required filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_required:'O2Sats should not be blank',filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="21">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input">

                        <input name="sick_asst20[asst_o2sat]" value="<?php echo $min_asst20[0]->asst_o2sat; ?>"  class="filter_if_not_blank form_input filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="22">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>
                    <div class="input">

                        <input name="sick_asst30[asst_o2sat]" value="<?php echo $min_asst30[0]->asst_o2sat; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="23">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">40 Min</span></div>
                    <div class="input">

                        <input name="sick_asst40[asst_o2sat]" value="<?php echo $min_asst40[0]->asst_o2sat; ?>"  class="form_input  filter_if_not_blank filter_number filter_rangelength[1-100]" placeholder="1 To 100" data-errors="{filter_number:'O2Sats should be in numbers',filter_rangelength:'O2Sats range should be 1 to 100'}" type="text" tabindex="24">


                    </div>
                </div>

                <div class="form_field dis_blk width20">
                    <div class="label">Temp</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                       <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input name="sick_asst10[asst_temp]" value="<?php echo $min_asst10[0]->asst_temp; ?>"  class="form_input filter_required filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_required:'Temp should not be blank',filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="25">


                    </div>
                </div>

                <div data-head=" " class="form_field width20 outer_loc">
                       <div class="outer_min"><span class="min">20 Min</span></div>
                    <div class="input">

                        <input name="sick_asst20[asst_temp]" value="<?php echo $min_asst20[0]->asst_temp; ?>"  class="form_input filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="26">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">30 Min</span></div>

                    <div class="input">

                        <input name="sick_asst30[asst_temp]" value="<?php echo $min_asst30[0]->asst_temp; ?>"  class="filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="27">


                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                     <div class="outer_min"><span class="min">40 Min</span></div>
                    <div class="input">

                        <input name="sick_asst40[asst_temp]" value="<?php echo $min_asst40[0]->asst_temp; ?>"  class="filter_if_not_blank filter_number filter_rangelength[82-100]" placeholder="82 to 110" data-errors="{filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="28">


                    </div>

                </div>


                <div class="form_field dis_blk width20">
                    <div class="label">Pt Status</div>
                </div>

                <div data-head="*" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">10 Min</span></div>
                    <div class="input top_left">

                        <input name="sick_asst10[asst_pt_status]"  class="form_input mi_autocomplete filter_required" value="<?php echo $min_asst10[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt" data-errors="{filter_required:'Please select patient from dropdown list'}" type="text" data-value="<?php echo $min_asst10[0]->asst_pt_status; ?>" tabindex="29">

                    </div>
                </div>


                <div data-head=" " class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">20 Min</span></div>
                    <div class="input">

                        <input name="sick_asst20[asst_pt_status]"  class="form_input mi_autocomplete" value="<?php echo $min_asst20[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt"  type="text" data-value="<?php echo $min_asst20[0]->asst_pt_status; ?>" data-nonedit="yes" tabindex="30">

                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">30 Min</span></div>
                    <div class="input">

                        <input name="sick_asst30[asst_pt_status]"  class="form_input mi_autocomplete" value="<?php echo $min_asst30[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt"  type="text" data-value="<?php echo $min_asst30[0]->asst_pt_status; ?>" data-nonedit="yes" tabindex="31">

                    </div>
                </div>

                <div data-head="" class="form_field width20 outer_loc">
                    <div class="outer_min"><span class="min">40 Min</span></div>
                    <div class="input">

                        <input name="sick_asst40[asst_pt_status]"  class="form_input mi_autocomplete" value="<?php echo $min_asst40[0]->asst_pt_status; ?>" placeholder="Status" data-href="{base_url}auto/get_yn_opt"  type="text" data-value="<?php echo $min_asst40[0]->asst_pt_status; ?>"  data-nonedit="yes" tabindex="32">

                    </div>
                </div>





            </div>


        </div>


    </div>
    </div>
        <div class="save_btn_wrapper float_left">

<?php if($stud_sickroom[0]->sick_status == '0'){?>
        <input type="button" name="save" value="Save" class="accept_btn form-xhttp-request" data-href='{base_url}sickroom/save_sickroom' data-qr="output_position=content&amp;action=1"  tabindex="25">
        
        <input type="button" name="discharge" value="Discharge" class="accept_btn form-xhttp-request" data-href='{base_url}sickroom/save_sickroom' data-qr="output_position=content&amp;action=2"  tabindex="25">
        <input type="button" name="shift_to_hospital" value="Shift to hopsital" class="accept_btn form-xhttp-request" data-href='{base_url}sickroom/save_sickroom' data-qr="output_position=content&amp;action=3"  tabindex="25">
<?php } ?>

    </div>

    <div class="width100 float_left">
       
    </div>
</form>