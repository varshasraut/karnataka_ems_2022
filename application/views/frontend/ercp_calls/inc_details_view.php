



<div class="call_purpose_form_outer">

    <h3>INCIDENT CALL</h3>

    <div class="pan_box bottom_border float_left">

        <div class="width30 float_left">

            <ul class="dtl_block">
                <li><span>Incident Information</span></li>
                <li>Patient Name: <span><?php echo $cl_dtl[0]->ptn_fname . " " . $cl_dtl[0]->ptn_lname; ?></span></li>
                <li>Incident Address: <span><?php echo $cl_dtl[0]->inc_address; ?></span></li>
            </ul>


        </div>

        <div class="width50 float_left">

            <ul class="dtl_block">
                <li><span>Previous ERCP Advice</span></li>
                <li><span>CALL 1: </span> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                <li><span>CALL 2: </span> Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
            </ul>

        </div>

    </div>

    <h3>CURRENT CALL DETAILS</h3>


    <form method="post" name="ercp_call_form" id="ercp_call_form">


        <input type="hidden" name="cdata[cl_ero_id]" value="<?php echo $opt_id; ?>">
        <input type="hidden" name="cdata[cl_adv_id]" value="<?php echo $sub_id; ?>">
        


        <div class="inline_fields width100">

            <div class="form_field width17">

                <div class="label">LOC*</div>
                <div class="input">
                    <input name="cdata[cl_loc_level]" tabindex="1" value="" class="mi_autocomplete filter_required" data-href="{base_url}auto/loc_level" placeholder="LOC Level" data-errors="{filter_required:'LOC level should not be blank'}"  type="text">
                </div>


            </div>

            <div class="form_field width17">

                <div class="label">GCS</div>
                <div class="input">
                    <input name="cdata[cl_gcs_score]" tabindex="2" value="" class="mi_autocomplete filter_required" data-href="{base_url}auto/gcs_score" placeholder="GCS score" data-errors="{filter_required:'GCS score should not be blank'}"  type="text">
                </div>


            </div>

            <div class="form_field width17">

                <div class="label">Pupils</div>

                <div class="input">
                    <input name="cdata[cl_pup_left]" tabindex="3" value="" class="mi_autocomplete" data-href="{base_url}auto/pupils_type" placeholder="Right"   type="text">
                </div>


            </div>

            <div class="form_field width17">

                <div class="label">&nbsp;</div>

                <div class="input">


                    <input name="cdata[cl_pup_right]" tabindex="4" value="" class="mi_autocomplete" data-href="{base_url}auto/pupils_type" placeholder="Left"  type="text">

                </div>

            </div>

            <div class="form_field width17">

                <div class="label">Pulse*</div>

                <div class="input">

                    <input name="cdata[cl_pulse]" tabindex="5" class="filter_required" placeholder="" type="text" data-errors="{filter_required:'Pulse field not be blank'}"> 

                </div>

            </div> 

            <div class="form_field width15">

                <div class="width50 float_left">

                    <div class="label">BP*</div>

                    <div class="input">

                        <input name="cdata[cl_bp_sy]" tabindex="6" class="filter_required" placeholder="Sy" type="text" data-errors="{filter_required:'BP field should not be blank'}"> 

                    </div>

                </div>

                <div class="width50 float_left">

                    <div class="label">&nbsp;</div>

                    <div class="input">

                        <input name="cdata[cl_bp_dia]" tabindex="7" class="filter_required float_right" placeholder="Dia" type="text" data-errors="{filter_required:'BP field should should not be blank'}"> 

                    </div>

                </div>

            </div>


        </div>


        <div class="inline_fields width100">


            <div class="form_field width17">

                <div class="label">RR*</div>

                <div class="input">

                    <input name="cdata[cl_rr]" tabindex="8" class="filter_required" placeholder="" type="text" data-errors="{filter_required:'RR field should not be blank'}"> 

                </div>

            </div> 
            <div class="form_field width17">

                <div class="label">O2Sats*</div>

                <div class="input">

                    <input name="cdata[cl_o2sats]" tabindex="9" class="filter_if_not_blank filter_required filter_number" placeholder="1 to 100" type="text" data-errors="{filter_required:'O2Sats should not be blank',filter_number:'O2Sats should be in numbers'}"> 

                </div>

            </div> 
            <div class="form_field width17">

                <div class="label">Temp</div>

                <div class="input">

                    <input name="cdata[cl_temp]" tabindex="10" class="filter_if_not_blank filter_number" placeholder="82 to 110" type="text" data-errors="{filter_number:'Temp should be in numbers'}">  

                </div>

            </div> 

            <div class="form_field width17">

                <div class="label">BSLR</div>

                <div class="input">

                    <input name="cdata[cl_bslr]" tabindex="11" class="" placeholder="" type="text"> 

                </div>

            </div> 


            <div class="form_field width50">

                <div class="label">Probabale Diagnosis*</div>

                <div class="field_input">

                    <input name="cdata[cl_pro_dia]" tabindex="12" class="filter_required" placeholder="" type="text" data-errors="{filter_required:'Incident time should not be blank'}"> 


                </div>

            </div>
            <div class="form_field width50">

                <div class="label">Additional Information</div>

                <div class="field_input">

                    <input name="cdata[cl_addinfo]" tabindex="13" class="" placeholder="" type="text"> 

                </div>

            </div>
            <div class="form_field width50">

                <div class="label">ERCP Advice Given*</div>

                <div class="field_input">


                    <input name="cdata[cl_madv_que]" tabindex="14" value="" class="mi_autocomplete filter_required" data-href="{base_url}auto/madv_que" placeholder="Select Protocol" data-errors="{filter_required:'ERCP advice should not be blank'}"  type="text" data-callback-funct="get_madv_ans">


                </div>

            </div>
            <div class="form_field width50">

                <div class="label">ERCP Additional Information</div>

                <div class="field_input">

                    <input name="cdata[cl_ercp_addinfo]" tabindex="15" class="" placeholder="" type="text"> 


                </div>

            </div>


            <div id="madv_ans" class="ans_block_box float_left">




            </div>


            <div class="save_btn_wrapper">

                <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}/Ercpcall/save" data-qr="" type="button" tabindex="16">


            </div>



        </div>


    </form>


</div>
