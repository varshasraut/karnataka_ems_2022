<div class="call_purpose_form_outer">
    <div class="width100">
        <!-- <h3>On Scene Care</h3> -->
        <label class="headerlbl">On Scene Care</label>
        <div class="incident_details">
            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">
               
                <div class="row" style="display: flex;">

                    <div class="col-md-2" style="width: 25%;">
                        <div class="label blue float_left">Number Of Patient<span class="md_field">*</span></div>
                            <div  class="width100 float_left">
                                <?php
                                if (empty($int_count)) {
                                    $int_count = 1;
                                }
                                ?>
                                <input id="ptn_no" type="text" name="inc_patient_cnt" value="<?= @$int_count; ?>" placeholder="Number Of Patient*" class="change-xhttp-request small half-text filter_required filter_no_whitespace filter_number filter_rangelength[0-10]" data-errors="{filter_rangelength:'Number should be 0 to 10',filter_required:'Patient no should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Patient no  should not be allowed blank space.'}" TABINDEX="7" data-href="{base_url}inc/change_view" data-qr="output_position=content&amp;call_type=nonmci" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="2">
                            </div>
                       
                    </div>

                    <div class="col-md-2" id="search_amb" style="width: 25%;">
                    <div class="label blue float_left">Ambulance No<span class="md_field">*</span>&nbsp;</div>
                        <div class="width100 float_left">
                        <input name="amb_reg_id" id="amb_id" class="mi_autocomplete dropdown_per_page width97 filter_required" data-href="{base_url}auto/get_onscene_ambulance?clg_group=<?php echo $clg_group; ?>" placeholder="Search Ambulance" tabindex="2" autocomplete="off" value="" data-value="" data-errors="{filter_required:'Please select Ambulance No from dropdown list'}" data-callback-funct="onscene_ambulance_change" >
                        </div>
                    </div>

                    <div class="col-md-2" style="width: 25%;">
                             <div class="label blue float_left">Base Location<span class="md_field">*</span>&nbsp;</div>
                  

                        <div class="width100 float_left" id="amb_base_location">
                            <input name="main[eq_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$equp_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; echo $Approve; echo $Re_request; ?>>

                        </div>
                    </div>
      
                     <div class="col-md-2" style="width: 25%;">
                             <div class="label blue float_left">District<span class="md_field">*</span>&nbsp;</div>
                  

                        <div class="width100 float_left" id="amb_district">
                            <input name="main[district]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$equp_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; echo $Approve; echo $Re_request; ?>>

                        </div>
                    </div>


                    <div class="col-md-2" id="search_amb" style="width: 30%;">
                        <div class="label blue float_left">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                          <div class="width100 float_left">
                         <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['inc_ero_standard_summary_id']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=on_scene_care"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" data-qr="call_type=NON_MCI" >
                          </div>
                    </div>
                    
                   
                </div>
                <div class="row" style="display: flex;">
                    <div class="col-md-4" id="search_amb" style="width: 35%;">
                        <div class="label blue float_left">ERO Note</div>
      
                         <div class="width100 float_left" id="ero_summary_other">
                             <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?=@$inc_details['inc_ero_summary'];?></textarea>
                        </div>
                    </div>
                </div>
            <div class="row">
            <div id="fwdcmp_btn"  class="col-md-4">
                <input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc102/confirm_onscenecare_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=dispatch' TABINDEX="21" >
            </div>
        </div>

        <div class="width2 float_right">

            <!--            <div id="inc_ambu_type_details">
                <input type="hidden" name="incient[amb_type]" id="amb_type" value="<?php echo $amb_type; ?>">
            </div>-->
            <div id="SelectedAmbulance">

            </div>
            <?php //var_dump($inc_details);
            ?>
            <input type="hidden" name="geo_fence" id="geo_fence" value="<?= @$geo_fence; ?>">
            <input type="hidden" name="incient[lat]" id="lat" value="<?= @$inc_details['lat']; ?>">
            <input type="hidden" name="incient[lng]" id="lng" value="<?= @$inc_details['lng']; ?>">
            <input type="hidden" name="incient[inc_ref_id]" id="inc_ref_id" value="<?= @$inc_details['inc_ref_id']; ?>">
            <!--<input type="hidden" name="incient[amb_id]" id="amb_id" value="">-->
            <input type="hidden" name="incient[base_month]" value="<?php echo $cl_base_month; ?>">
            <input type="hidden" name="incient[inc_type]" id="inc_type" value="on_scene_care">
            <input type="hidden" name="incient[inc_google_add]" id="google_id" value="">
            <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
            <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
            <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time; ?>">
            <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID; ?>">
            <div id="patient_hidden_div">
                <input type="hidden" name="patient[full_name]" value="<?php echo $common_data_form['full_name']; ?>">
                <input type="hidden" name="patient[first_name]" value="<?php echo $common_data_form['first_name']; ?>">
                <input type="hidden" name="patient[middle_name]" value="<?php echo $common_data_form['middle_name']; ?>">
                <input type="hidden" name="patient[last_name]" value="<?php echo $common_data_form['last_name']; ?>">
                <input type="hidden" name="patient[dob]" value="<?php echo $common_data_form['dob']; ?>">
                <input type="hidden" name="patient[age]" value="<?php echo $common_data_form['age']; ?>">
                <input type="hidden" name="patient[gender]" value="<?php echo $common_data_form['gender']; ?>">

            </div>
            <!--                <input type="hidden" name="incient[inc_ero_standard_summary]" value="<?php echo $common_data_form['inc_ero_standard_summary']; ?>">
                <input type="hidden" name="incient[inc_ero_summary]" value="<?php echo $common_data_form['inc_ero_summary']; ?>">-->

            <!--                <div id="fwdcmp_btn"><input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/save_inc' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">
                    <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/save_inc?cl_type=forword" data-qr="output_position=content" tabindex="28" type="button"></div>-->
        </div>
        </form>
    </div>
</div>
</div>