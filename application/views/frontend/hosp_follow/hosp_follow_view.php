
<div class="width100">
    <h2>Hospitalisation</h2><br>
    <div class="width100">
        <a class="click-xhttp-request action_button btn" id="hosp_step_one" data-href="{base_url}hosp_follow/hosp_follow_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Hospitalisation</a>
        <a class="click-xhttp-request action_button btn" id="hosp_step_two"  data-href="{base_url}hosp_follow/intra_hosp_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Intra Hospitalisation</a>
        <a class="click-xhttp-request action_button btn" id="hosp_step_three"  data-href="{base_url}hosp_follow/post_hospitalisation_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Post Hospitalisation</a>
    </div>
    <form enctype="multipart/form-data" action="#" method="post" id="medication_form">
    <br>
    
     <div class="width100 form_field display_inlne_block">
         <div class="width100" >
                 <div class="form_field width_60 select float_left">

                        <div class="label">Admitted to hospital</div>

                        <div class="input top_left">
<?=@$hosp_data[0]->hp_name; ?>
<!--                            <input name="admitted_hosp" value="<?=@$hosp_data[0]->hp_name; ?>" class="form_input" placeholder="Admitted to hospital" type="text"  tabindex="6" readonly="readonly">-->

                        </div>

                    </div>

              <div class="form_field width100 select float_left">

                        <div class="label">Hospsital address</div>

                        <div class="input top_left">
<?=@$hosp_data[0]->hp_address; ?>
<!--                            <input name="hosp_address" value="<?=@$hosp_data[0]->hp_address; ?>" class="form_input" placeholder="Hospsital address" type="text" tabindex="6" readonly="readonly">-->

                        </div>

                    </div>
             <div class="form_field width100 select float_left">

                        <div class="label">Diagnosis</div>

                        <div class="input top_left">
                                                           <?php 
                        $diagonosis_array = array();
                
                    if($diagonosis){
                      foreach($diagonosis as $dia){
                        $diagonosis_array = array_merge($diagonosis_array,$dia);
                      }
                     
                     echo implode(',',$diagonosis_array);
                    }
                     ?>
<!--                           <textarea name="diagonosis" readonly="readonly">

                           </textarea>-->

                        </div>

                    </div>
                    <div class="form_field width_30 select float_left">

                        <div class="label">Admitted Under</div>

                        <div class="input top_left">

                            <input name="hosp[admitted_under]" value="<?=@$result[0]->admitted_under; ?>"  class="form_input" placeholder="Admitted Under" type="text" tabindex="6">

                        </div>

                    </div>
              <div class="form_field width25 select float_left">

                        <div class="label">Admitted On</div>

                        <div class="input top_left">

                            <input name="hosp[admitted_on]" value="<?php if($result[0]->admitted_on == '0000-00-00'){ echo ""; }else{ echo date('d-m-Y', strtotime($result[0]->admitted_on)); }?>"  class="form_input mi_calender" placeholder="Admitted On"  type="text" tabindex="6">

                        </div>

                    </div>
                <div class="form_field width100 select float_left">
<!--                    <input type="hidden" name="hosp[hospitalisation_id]" id="hosp_id" value="<?php echo $result[0]->id; ?>">-->
                    <input type="hidden" name="hosp[student_id]" id="hosp_id" value="<?php echo $result[0]->student_id; ?>">
                    <input type="hidden" name="hosp[schedule_id]" id="hosp_id" value="<?php echo $result[0]->schedule_id; ?>">
                    <input type="button" name="submit" value="Save" class="action_button btn form-xhttp-request" data-href="<?php echo base_url();?>hosp_follow/save_hospitalisation" data-qr="output_position=content" >
                </div>
 <br><br>
         </div>

     </div>
    </form>
</div>