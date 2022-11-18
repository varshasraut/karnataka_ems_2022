
<div class="call_purpose_form_outer">

    <h3 class="txt_clr2 width1 txt_pro">CALL DETAILS</h3>

    <div class="inline_fields width100">

        <div class="form_field width17">

            <div class="label">Patient Name</div>
            <div class="input top_left">
                <select name="" tabindex="8" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms" disabled=""> 
                    <option value="" <?php echo $disabled; ?>>Select patient id</option>
                    <?php foreach ($patient_info as $pt) { ?>
                        <option value="<?php echo $pt->ptn_id; ?>" <?php
                        if ($pt->ptn_id == $cl_dtl[0]->adv_cl_ptn_id) {
                            echo "selected";
                        }
                        ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                            <?php } ?>

                </select>
            </div>


        </div>
        <!--        <div class="form_field width17">
        
                    <div class="label">LOC</div>
                    <div class="input">
                        <input name="" tabindex="1" value="<?php echo $cl_dtl[0]->lv_type; ?>"  data-href=""  type="text" disabled="">
                    </div>
        
        
                </div>-->

        <div class="form_field width17">

            <div class="label">GCS</div>
            <div class="input">
                <input name="" tabindex="2" value="<?php echo $cl_dtl[0]->cg_score; ?>" type="text" disabled="">
            </div>


        </div>

        <div class="form_field width17">

            <div class="label">Pupils</div>

            <div class="input">
                <input name="" tabindex="3" value="<?php echo $cl_dtl[0]->right_pp; ?>" class=""  type="text" disabled="">
            </div>


        </div>

        <div class="form_field width17">

            <div class="label">&nbsp;</div>

            <div class="input">


                <input name="" tabindex="4" value="<?php echo $cl_dtl[0]->left_pp; ?>" class="" placeholder="Left"  type="text" disabled="">

            </div>

        </div>

        <div class="form_field width17">

            <div class="label">Pulse</div>

            <div class="input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_pulse; ?>" tabindex="5" class="" placeholder="" type="text" disabled=""> 

            </div>

        </div> 

        <div class="form_field width15">

            <div class="width50 float_left">

                <div class="label">BP</div>

                <div class="input">

                    <input name="" value="<?php echo $cl_dtl[0]->adv_cl_bp_sy; ?>" tabindex="6" class="" placeholder="Sy" type="text" disabled=""> 

                </div>

            </div>

            <div class="width50 float_left">

                <div class="label">&nbsp;</div>

                <div class="input">

                    <input name="" value="<?php echo $cl_dtl[0]->adv_cl_bp_dia; ?>" tabindex="7" class="" placeholder="Dia" type="text" disabled=""> 

                </div>

            </div>

        </div>


    </div>


    <div class="inline_fields width100">


        <div class="form_field width17">

            <div class="label">RR</div>

            <div class="input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_rr; ?>" tabindex="8" class="" placeholder="" type="text" disabled=""> 

            </div>

        </div> 
        <div class="form_field width17">

            <div class="label">O2Sats</div>

            <div class="input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_o2sats; ?>" tabindex="9" class="" placeholder="1 to 100" type="text" disabled=""> 

            </div>

        </div> 
        <div class="form_field width17">

            <div class="label">Temp</div>

            <div class="input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_temp; ?>" tabindex="10" class="" placeholder="82 to 110" type="text" disabled="">  

            </div>

        </div> 

        <div class="form_field width17">

            <div class="label">BSLR</div>

            <div class="input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_bslr; ?>" tabindex="11" class="" placeholder="" type="text" disabled=""> 

            </div>

        </div> 
        <div class="form_field width17">

            <div class="label">Added By</div>

            <div class="input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_added_by; ?>" tabindex="11" class="" placeholder="" type="text" disabled=""> 

            </div>

        </div> 

        <div class="form_field width15">

            <div class="label">Date</div>

            <div class="input">

                <?php
                $date = explode(' ', $cl_dtl[0]->adv_cl_date);

                echo date('d-m-Y', strtotime($date[0]));
                ?>

            </div>

        </div> 





        <div class="form_field width50">

            <div class="label">Impressions</div>

            <div class="field_input">

                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_pro_dia; ?>" tabindex="12" class="" placeholder="" type="text" disabled=""> 


            </div>

        </div>

        <div class="form_field width50">

            <div class="label">Chief Complaint</div>

            <div class="field_input">


                <input name="" value="<?php echo $cl_dtl[0]->que_question; ?>" tabindex="14" class="" placeholder="Select Protocol"  type="text" disabled="">


            </div>

        </div>
        <div class="form_field width50">

            <div class="label">Additional Information</div>

            <div class="field_input">

                <textarea rows="3"  name="" style="text-transform: lowercase;" disabled=""><?php echo $cl_dtl[0]->adv_cl_addinfo; ?></textarea>
<!--                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_addinfo; ?>" tabindex="13" class="" placeholder="" type="text" disabled=""> -->

            </div>

        </div>
        <div class="form_field width50">

            <div class="label">ERCP Additional Information</div>

            <div class="field_input">

<!--                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_ercp_addinfo; ?>" tabindex="15" class="" placeholder="" type="text" disabled=""> -->
                <textarea rows="3" name="" style="text-transform: lowercase;" disabled=""><?php echo $cl_dtl[0]->adv_cl_ercp_addinfo; ?></textarea>

            </div>

        </div>


        <?php if ($cl_dtl[0]->adv_cl_madv_que == '243' || $cl_dtl[0]->adv_cl_madv_que == '246') { ?>
            <div class="width50 float_left">
                <div class="form_field width97">

                    <div class="label">Chief Complaint Other</div>

                    <div class="field_input">
                        <input name="" value="<?php echo $cl_dtl[0]->adv_cl_madv_que_other; ?>" tabindex="14" class="width100" placeholder="Chief Complaint Other"  type="text" disabled="">

                    </div>

                </div>
            </div>
        <?php } ?>
        <div class="ans_block_box float_left">



            <p><?php echo $cl_dtl[0]->que_question; ?></p>



            <?php echo $cl_dtl[0]->ans_answer; ?>


        </div>


    </div>

</div>

