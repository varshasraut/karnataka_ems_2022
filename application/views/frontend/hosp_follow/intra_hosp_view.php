
<div class="width100">
    <h2>Intra Hospitalisation</h2><br>
        <div class="width100">
        <a class="click-xhttp-request action_button btn" id="hosp_step_one" data-href="{base_url}hosp_follow/hosp_follow_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Hospitalisation</a>
        <a class="click-xhttp-request action_button btn" id="hosp_step_two"  data-href="{base_url}hosp_follow/intra_hosp_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Intra Hospitalisation</a>
        <a class="click-xhttp-request action_button btn" id="hosp_step_three"  data-href="{base_url}hosp_follow/post_hospitalisation_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Post Hospitalisation</a>
    </div>
    <form enctype="multipart/form-data" action="#" method="post" id="medication_form">
        <br>

        <div class="width100 form_field display_inlne_block">
            <div class="width100" >

                <div class="form_field width100 select float_left">

<!--                    <div class="label">Hospsital address</div>-->

                    <table class="student_screening intra_hospital">
                        <tr><td>Date</td><td>Doctor Visit</td><td>Meds taken</td><td>Investigation Done</td><td>Nursing Care</td><td>Procedure done</td><td>Remarks</td><td></td></tr>
                        
                                                     <?php //var_dump($result);?>
                            <?php $inter_hosp_details = json_decode($result[0]->inter_hosp_details);
                            if(!empty($inter_hosp_details)){
                                for($i=0; $i < count($inter_hosp_details->date)-1 ; $i++){ ?>
                                     <tr>

                            <td> 
                                <input name="intra[date][]" value="<?php echo $inter_hosp_details->date[$i];?>"  class="form_input  mi_calender" placeholder="Date" type="text"  tabindex="6">
                            </td>
                            <td> 
                                <select name="intra[dr_visit][]" class=""  data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($inter_hosp_details->dr_visit[$i] == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($inter_hosp_details->dr_visit[$i] == 'no'){ echo "selected";}?>>No</option>

                                </select>
                            </td>
                            <td> <select name="intra[med_taken][]" class=""   data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($inter_hosp_details->med_taken[$i] == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($inter_hosp_details->med_taken[$i] == 'no'){ echo "selected";}?>>No</option>

                                </select></td>
                            <td> <input name="intra[inv_done][]" value="<?= @$inter_hosp_details->inv_done[$i]; ?>"  class="form_input" placeholder="Investigation Done" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6"></td>
                            <td> 
                                <select name="intra[nursing_care][]" class=""   data-base="" tabindex="6">
                                    
                                <option value="">Select</option>
                                <option value="done" <?php if($inter_hosp_details->nursing_care[$i] == 'done'){ echo "selected";}?>>Done</option>
                                <option value="not_done"  <?php if($inter_hosp_details->nursing_care[$i] == 'not_done'){ echo "selected";}?>>Not Done</option>

                                </select>
                            </td>
                            <td> 
                                <select name="intra[procedure_done][]" class=""   data-base="" tabindex="6">
                                    
                                <option value="">Select</option>
                                <option value="done" <?php if($inter_hosp_details->procedure_done[$i] == 'done'){ echo "selected";}?>>Done</option>
                                <option value="not_done"  <?php if($inter_hosp_details->procedure_done[$i] == 'not_done'){ echo "selected";}?>>Not Done</option>

                                </select>
                            </td>
                            <td> <input name="intra[reamark][]" value="<?= @$inter_hosp_details->reamark[$i]; ?>" class="form_input" placeholder="Remarks"  type="text" tabindex="6"></td>
                            <td>
                                <?php if($i == 0){?><div class="add_more_button"></div><?php } else {?><div class="remove_add_more_button"></div><?php }?></td>
                        </tr>
                            <?php    }
                            }else{
                            ?>
                        <tr>

                            <td> 
                                <input name="intra[date][]" value=""  class="form_input mi_calender" placeholder="Date" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">
                            </td>
                            <td> 
                                <select name="intra[dr_visit][]" class=""   data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no" >No</option>

                                </select>
                            </td>
                            <td> <select name="intra[med_taken][]" class=""   data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no" >No</option>

                                </select></td>
                            <td> <input name="intra[inv_done][]" value=""  class="form_input" placeholder="Investigation Done" type="text" data-value="" tabindex="6"></td>
                            <td> 
                                <select name="intra[nursing_care][]" class=""   data-base="" tabindex="6">
                                    
                                <option value="">Select</option>
                                <option value="done">Done</option>
                                <option value="not_done">Not Done</option>

                                </select>
                            </td>
                            <td> 
                                <select name="intra[procedure_done][]" class=""   data-base="" tabindex="6">
                                    
                                <option value="">Select</option>
                                <option value="done">Done</option>
                                <option value="not_done">Not Done</option>

                                </select>
                            </td>
                            <td> <input name="intra[reamark][]" value="" class="form_input" placeholder="Remarks"  type="text" tabindex="6"></td>
                            <td><div class="add_more_button"></div></td>
                        </tr>
                            <?php }?>
                            <tr class="hide intra_hospital_row">
                            <td> 
                                <input name="intra[date][]" value=""  class="form_input mi_calender" placeholder="Date" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">
                            </td>
                            <td> 
                                <select name="intra[dr_visit][]" class=""   data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>

                                </select>
                            </td>
                            <td> <select name="intra[med_taken][]" class=""   data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes">Yes</option>
                                <option value="no" >No</option>

                                </select></td>
                            <td> <input name="intra[inv_done][]" value=""  class="form_input" placeholder="Investigation Done" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6"></td>
                            <td> 
                                <select name="intra[nursing_care][]" class=""   data-base="" tabindex="6">
                                    
                                <option value="">Select</option>
                                <option value="done" >Done</option>
                                <option value="not_done">Not Done</option>

                                </select>
                            </td>
                            <td> 
                                <select name="intra[procedure_done][]" class=""   data-base="" tabindex="6">
                                    
                                <option value="">Select</option>
                                <option value="done" >Done</option>
                                <option value="not_done">Not Done</option>

                                </select>
                            </td>
                            <td> <input name="intra[reamark][]" value="" class="form_input" placeholder="Remarks"  type="text" tabindex="6"></td>
                            <td><div class="remove_add_more_button"></div></td>
                        </tr>
                        
                    </table>

                </div>

                <div class="form_field width25 select float_left">

                    <div class="label">Discharge date</div>

                    <div class="input top_left">

                        <input name="hosp[discharge_date]" value="<?php if($result[0]->discharge_date != '0000-00-00'){ echo date('d-m-Y', strtotime($result[0]->discharge_date)); }?>"  class="form_input mi_calender" placeholder="Discharge date"  type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">

                    </div>

                </div>
                <div class="form_field width25 select float_left">

                    <div class="label">Drop back booked date time</div>

                    <div class="input top_left">

                        <input name="hosp[drop_back_datetime]" value="<?php if($result[0]->drop_back_datetime != '0000-00-00 00:00:00'){ echo date('d-m-Y H:i:s', strtotime($result[0]->drop_back_datetime)); }?>"  class="form_input  mi_timecalender" placeholder="Drop back booked date time" type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6">

                    </div>

                </div>
                <div class="form_field width100 select float_left">
                    
                     <input type="hidden" name="hosp[student_id]" id="hosp_id" value="<?php echo $result[0]->student_id; ?>">
                    <input type="hidden" name="hosp[schedule_id]" id="hosp_id" value="<?php echo $result[0]->schedule_id; ?>">
                    <input type="button" name="submit" value="Save" class="action_button btn form-xhttp-request" data-href="<?php echo base_url(); ?>hosp_follow/save_intra_hospitalisation" data-qr="output_position=content" >
                </div>
                <br><br>
            </div>

        </div>
    </form>
</div>