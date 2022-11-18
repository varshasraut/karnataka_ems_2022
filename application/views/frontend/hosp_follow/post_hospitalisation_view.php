
<div class="width100">
    <h2>Post Hospitalisation</h2><br>
        <div class="width100">
        <a class="click-xhttp-request action_button btn" id="hosp_step_one" data-href="{base_url}hosp_follow/hosp_follow_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Hospitalisation</a>
        <a class="click-xhttp-request action_button btn" id="hosp_step_two"  data-href="{base_url}hosp_follow/intra_hosp_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Intra Hospitalisation</a>
        <a class="click-xhttp-request action_button btn" id="hosp_step_three"  data-href="{base_url}hosp_follow/post_hospitalisation_view" data-qr="output_position=content&amp;hosp_id=<?php echo base64_encode($result[0]->id);?>" >Post Hospitalisation</a>
    </div>
    <form enctype="multipart/form-data" action="#" method="post" id="medication_form">
        <br>

        <div class="width100 form_field display_inlne_block">
            <div class="width100" >

                
                <div class="form_field width25 select float_left">

                    <div class="label">Discharge Date</div>

                    <div class="input top_left">
                        
                        <input name="discharge_date" value="<?php if($result[0]->discharge_date != '0000-00-00'){ echo date('d-m-Y', strtotime($result[0]->discharge_date)); }?>" class="form_input" placeholder="Discharge Date" type="text" tabindex="6" readonly="readonly">

                    </div>

                </div>
                <div class="form_field width100 select float_left">

                    <div class="label">Diagnosis</div>

                    <div class="input top_left">
                        <?php 
                        $diagonosis_array = array();
                        if ($diagonosis) {
                            foreach ($diagonosis as $dia) {
                                $diagonosis_array = array_merge($diagonosis_array, $dia);
                            }
                            echo implode(',', $diagonosis_array);
                        }
                        ?>
<!--                        <textarea name="diagonosis" readonly="readonly"></textarea>-->

                    </div>

                </div>
                <div class="form_field width100 select float_left">

                    <table class="student_screening drugs_table">
                        <tr><td>Date</td><td>Medication name</td><td>Dose</td><td>Meds taken</td></tr>
                        <tr><td></td><td></td><td></td><td></td></tr>
                        <tr><td></td><td></td><td></td><td></td></tr>
                        
                    </table>

                </div>

                <div class="form_field width100 select float_left">
                    <input type="hidden" name="hosp_id" id="pre_id" value="<?php echo $result[0]->id; ?>">
                    <input type="button" name="submit" value="Save" class="action_button btn form-xhttp-request" data-href="<?php echo base_url(); ?>medication/save_medication" data-qr="output_position=content" >
                </div>
                <br><br>
            </div>

        </div>
    </form>
</div>