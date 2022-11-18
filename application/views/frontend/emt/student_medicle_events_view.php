<script>
if(typeof H != 'undefined'){
    init_auto_address();
}

</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Medical Event Exam
            <div class="form_field width25 float_right">
                        <div class="input">

                            <select name="hair" class="filter_required"  data-errors="{filter_required:'Please select hair color'}" data-base="" tabindex="6">
                                <option value="">Previous visit</option>
                                <option value="25_agu">25 Aug 2018</option>
                                <option value="25_agu">20 Aug 2018</option>
                                <option value="25_agu">15 Aug 2018</option>
                            </select>

                        </div>
        </div></h3> </div>

<form method="post" name="" id="patient_info">


    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left">

<!--        <div class=" display_inlne_block">

            <div class="width100 display_inlne_block">
                <div class="pat_width float_left" data-activeerror="">
                    <input name="data" value="" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Date"  data-errors="{filter_required:'Date should not blank'}">
                </div>
                <div class="pat_width float_left" data-activeerror="">
                    <input name="doctore_id" value="" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Doctor Id"  data-errors="{filter_required:'Mother name should not blank'}">
                </div>
            </div>

        </div>-->

        <div class="width100 display_inlne_block">
            <div class="style6">Chief complaint</div>

            <div class="width100 float_left">

                <div id="purpose_of_calls" class="input">
                    <input name="chief_complaint" value="<?php echo $medical_data[0]->chief_complaint; ?>" class="width100" tabindex="10" data-base="" type="text" placeholder="Chief complaint"  data-errors="">

                </div>

            </div>
        </div>
        <div class="width100 display_inlne_block">

            <div class="form_field width25 select float_left">

                <div class="label">Pulse- beats/min</div>

                <div class="input top_left">

                    <input name="pulse" value="<?php echo $medical_data[0]->pulse; ?>"  class="form_input  filter_required" placeholder="Pulse" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" data-value="<?php echo $medical_data[0]->pulse; ?>" tabindex="6">

                </div>

            </div>
   <div class=" width75 float_left">
             <div class="form_field width50 float_left">

                <div class="style6">BP- mm Hg</div>
                

                 <div class="input width100 float_left">

                    <input name="sys_mm" value="<?php echo $medical_data[0]->sys_mm; ?>" class="form_input filter_required" placeholder="SYS" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16">
<!--                    <input name="sys_hg" value="<?php echo $medical_data[0]->sys_hg; ?>" class="form_input filter_required width40 float_left" placeholder="SYS" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16" style="margin-left: 10px;">-->

                </div>

            </div>
              <div class="form_field width50 float_left">

                  <div class="style6">&nbsp;</div>

                 <div class="input width100 float_left">

                    <input name="dys_hg" value="<?php echo $medical_data[0]->dys_mm; ?>" class="form_input filter_required" placeholder="DYS" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16">
<!--                     <input name="dys_mm" value="<?php echo $medical_data[0]->dys_mm; ?>" class="form_input filter_required  width40 float_left" placeholder="DYS" data-errors="{filter_required:'BP should not be blank!'}" type="text" tabindex="16" style="margin-left: 10px;">-->

                </div>

            </div>
        </div>



            
 <div class="width100 display_inlne_block">
                   <div class="form_field width25 float_left">

                <div class="style6">Edema</div>
                

                <div id="purpose_of_calls" class="input">
                   <select name="edema" class="filter_required"  data-errors="{filter_required:'Please select Edema'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="present" <?php if($medical_data[0]->edema == 'present'){ echo "selected"; }?>>Present</option>
                            <option value="absent" <?php if($medical_data[0]->edema == 'absent'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>Absent</option>
                           
                        </select>

                </div>

            </div>
            <div class="form_field width25 float_left">
                <div class="style6">Pallor</div>
                <div id="purpose_of_calls" class="input">
                    <select name="pallor" class="filter_required"  data-errors="{filter_required:'Please select Tenderness'}" data-base="" tabindex="6">  
                            <option value="present" <?php if($medical_data[0]->pallor == 'present'){ echo "selected"; }?>>Present</option>
                            <option value="absent" <?php if($medical_data[0]->pallor == 'absent'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>Absent</option>
                           
                    </select>

                </div>

            </div>
             <div class="form_field width25 float_left">

                <div class="label">Temperature- &deg;F </div>

                <div class="input">

                    <input name="temp" value="<?php echo $medical_data[0]->temp; ?>"  class="form_input filter_if_not_blank filter_number " placeholder="Degree/Fahrenheit" data-errors="{filter_required:'Temp should not be blank',filter_rangelength:'Temp range should be 82 to 100'}" type="text" tabindex="19">

                </div>
            </div>
            <div class="form_field width25 float_left">

                <div class="label">O2 Sats %</div>

                <div class="input">

                    <input name="sats" value="<?php echo $medical_data[0]->sats; ?>"  class="form_input" placeholder="Sats" data-errors="{filter_required:'Sats should not be blank',filter_rangelength:'Sats range should be 82 to 100'}" type="text" tabindex="19">

                </div>
            </div>
            <div class="form_field width50 float_left">

                <div class="label">Lymphadenopathy</div>

                <div class="input">

                     <select name="lymphadenopathy" class="filter_required"  data-errors="{filter_required:'Please select Lymphadenopathy'}" data-base="" tabindex="6">
                           
                            <option value="present" <?php if($medical_data[0]->lymphadenopathy == 'present'){ echo "selected"; }?>>Present</option>
                            <option value="absent" <?php if($medical_data[0]->lymphadenopathy == 'absent'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>Absent</option>
                           
                        </select>

                </div>
            </div>
                 <div class="form_field width50 float_left">

                <div class="label">Icterus</div>

                <div class="input">

                   <select name="icterus" class="filter_required"  data-errors="{filter_required:'Please select Icterus'}" data-base="" tabindex="6">
                            <option value="present" <?php if($medical_data[0]->icterus == 'present'){ echo "selected"; }?>>Present</option>
                            <option value="absent" <?php if($medical_data[0]->icterus == 'absent'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>Absent</option>
                        </select>

                </div>
            </div>
      </div>


        </div>
              
        <div class="width100 display_inlne_block">
            <div class="form_field width33 select float_left">
                    <div class="label">CVS</div>
                    <div class="input top_left">
                        <select name="cvs" class="filter_required"  data-errors="{filter_required:'Please select CVS'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="NAD" <?php if($medical_data[0]->cvs == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>NAD</option>
                            <option value="murmer_systolic" <?php if($medical_data[0]->cvs == 'murmer_systolic'){ echo "selected"; }?>>Murmer - systolic</option>
                            <option value="murmer_diastolic" <?php if($medical_data[0]->cvs == 'murmer_diastolic'){ echo "selected"; }?>>murmers - diastolic</option>
                            <option value="pericardial_rub" <?php if($medical_data[0]->cvs == 'pericardial_rub'){ echo "selected"; }?>>pericardial rub</option>
                            <option value="other" <?php if($medical_data[0]->cvs == 'other'){ echo "selected"; }?>>other</option>
                        </select>
                    </div>
            </div>
            
           <div class="form_field width33 float_left">
                <div class="style6">Reflexes</div>

                <div class="width100 float_left">

                    <div  class="input">
                        <select name="reflexes" class="filter_required"  data-errors="{filter_required:'Please select Abdomen'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="plus"  <?php if($medical_data[0]->reflexes == 'plus'){ echo "selected"; }?>>+</option>
                            <option value="2plus"  <?php if($medical_data[0]->reflexes == '2plus'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>++</option>
                            <option value="3plus"  <?php if($medical_data[0]->reflexes == '3plus'){ echo "selected"; }?>>+++</option>
                            <option value="4plus"  <?php if($medical_data[0]->reflexes == '4plus'){ echo "selected"; }?>>++++</option>
                            <option value="absent"  <?php if($medical_data[0]->reflexes == 'absent'){ echo "selected"; }?>>Absent</option>
                        </select>

                    </div>
                </div>
            </div>
           
            <div class="form_field width33 select float_left">
                    <div class="label">Pupils</div>
                    <div class="input top_left">
                        <select name="pupils" class="filter_required width100"  data-errors="{filter_required:'Please select Pupils'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="BERL" <?php if($medical_data[0]->pupils == 'BERL'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; }?>>BERL</option>
                            <option value="unequal" <?php if($medical_data[0]->pupils == 'unequal'){ echo "selected"; }?>>unequal</option>
                            <option value="bilatral_dialated" <?php if($medical_data[0]->pupils == 'bilatral_dialated'){ echo "selected"; }?>>bilatral dialated</option>
                            <option value="bilateral_constricted" <?php if($medical_data[0]->pupils == 'bilateral_constricted'){ echo "selected"; }?>>bilateral constricted</option>
                        </select>
                    </div>
            </div>


        </div>
        


    </div>


    <div class="half_div_right">


  
        <div class="width100 display_inlne_block">
            
            <div class="width25 float_left">

                <div class="style6">RS Right</div>

                <div  class="input">
                    <select name="resp_right" class="filter_required"  data-errors="{filter_required:'Please select Resp Right'}" data-base="" tabindex="6">
                        <option value="">Select</option>
                        <option value="NAD"  <?php if($medical_data[0]->resp_right == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>NAD</option>
                        <option value="sputum_plus"  <?php if($medical_data[0]->resp_right == 'sputum_plus'){ echo "selected"; }?>>Sputum +</option>
                        <option value="crackels_plus"  <?php if($medical_data[0]->resp_right == 'crackels_plus'){ echo "selected"; }?>>crackels +</option>
                        <option value="conducted_sounds"  <?php if($medical_data[0]->resp_right == 'conducted_sounds'){ echo "selected"; }?>>Conducted sounds</option>
                        <option value="other"  <?php if($medical_data[0]->resp_right == 'other'){ echo "selected"; }?>>other</option>
                    </select>
                </div>

            </div>
            

            <div class="width25 float_left">
                <div class="style6">RS Left</div>
                <div  class="input">
                   <select name="resp_left" class="filter_required"  data-errors="{filter_required:'Please select Resp Left'}" data-base="" tabindex="6">
                        <option value="">Select</option>
                        <option value="NAD" <?php if($medical_data[0]->resp_left == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>NAD</option>
                        <option value="sputum_plus" <?php if($medical_data[0]->resp_left == 'sputum_plus'){ echo "selected"; }?>>Sputum +</option>
                        <option value="crackels_plus" <?php if($medical_data[0]->resp_left == 'crackels_plus'){ echo "selected"; }?>>crackels +</option>
                        <option value="conducted_sounds" <?php if($medical_data[0]->resp_left == 'conducted_sounds'){ echo "selected"; }?>>Conducted sounds</option>
                        <option value="other" <?php if($medical_data[0]->resp_left == 'other'){ echo "selected"; }?>>other</option>
                    </select>
                </div>

            </div>
                        <div class="form_field width25 select float_left">
                    <div class="style6">CNS</div>
                    <div class="input top_left">
                        <select name="cns" class="filter_required"  data-errors="{filter_required:'Please select CNS'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="NAD" <?php if($medical_data[0]->cns == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>NAD</option>
                            <option value="hemiparesis_right" <?php if($medical_data[0]->cns == 'hemiparesis_right'){ echo "selected"; }?>>hemiparesis - Right side</option>
                            <option value="hemiparesis_left" <?php if($medical_data[0]->cns == 'hemiparesis_left'){ echo "selected"; }?>>hemiparesis - left side</option>
                            <option value="paraperesis" <?php if($medical_data[0]->cns == 'paraperesis'){ echo "selected"; }?>>paraperesis</option>
                            <option value="quadriparesis" <?php if($medical_data[0]->cns == 'quadriparesis'){ echo "selected"; }?>>quadriparesis</option>
                            <option value="facial_palsy" <?php if($medical_data[0]->cns == 'facial_palsy'){ echo "selected"; }?>>facial palsy</option>
                            <option value="other" <?php if($medical_data[0]->cns == 'other'){ echo "selected"; }?>>other</option>
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="style6">Romberg's</div>
                    <div class="input top_left">
                        <select name="rombergs" class="filter_required"  data-errors="{filter_required:'Please select Romberg'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="positive" <?php if($medical_data[0]->rombergs == 'positive'){ echo "selected"; }?>>+ ve</option>
                            <option value="negative" <?php if($medical_data[0]->rombergs == 'negative'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>- ve</option>
                           
                        </select>
                    </div>
            </div>


  
        </div>
                 <div class="width100 display_inlne_block">


            <div class="form_field width25 select float_left">
                    <div class="label">P/A</div>
                    <div class="input top_left">
                        <select name="p_a" class="filter_required"  data-errors="{filter_required:'Please select P/A'}" data-base="" tabindex="6">
                                          
                                            <option value="NAD" <?php if($medical_data[0]->p_a == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){echo "selected";}?>>NAD</option>
                                            <option value="hepatomegaly" <?php if($medical_data[0]->p_a == 'hepatomegaly'){ echo "selected"; }?>>Hepatomegaly</option>
                                            <option value="spleenomegaly" <?php if($medical_data[0]->p_a == 'spleenomegaly'){ echo "selected"; }?>>Spleenomegaly</option>
                                            <option value="hepatospleenomegaly" <?php if($medical_data[0]->p_a == 'hepatospleenomegaly'){ echo "selected"; }?>>Hepatospleenomegaly</option>
                                            <option value="other" <?php if($medical_data[0]->p_a == 'other'){ echo "selected"; }?>>Other</option>
                           
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">tenderness</div>
                    <div class="input top_left">
                        <select name="tenderness" class="filter_required"  data-errors="{filter_required:'Please select Tenderness'}" data-base="" tabindex="6">
                             <option value="absent" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; }  ?>>Absent</option>
                                <option value="epigastric" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Epigastric</option>
                                <option value="hypogastric" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Hypogastric</option>
                                <option value="umbilical" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Umbilical</option>
                                <option value="rt_iliac" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Rt iliac</option>
                                <option value="lt_iliac" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Lt iliac</option>
                                <option value="rt_lumbar" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>Rt lumbar</option>
                                <option value="lt_lumbar" <?php if($screening[0]->tenderness == 'positive'){ echo "selected"; } ?>>LT lumbar</option>
                           
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Guarding</div>
                    <div class="input top_left">
                        <select name="guarding" class="filter_required"  data-errors="{filter_required:'Please select Guarding'}" data-base="" tabindex="6">
                            <option value="present" <?php if($screening[0]->guarding == 'present'){ echo "selected"; } ?>>Present</option>
                            <option value="absent" <?php if($screening[0]->guarding == 'absent'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; } ?>>Absent</option>
                           
                        </select>
                    </div>
            </div>
            <div class="form_field width25 select float_left">
                    <div class="label">Ascitis</div>
                    <div class="input top_left">
                        <select name="ascitis" class="filter_required"  data-errors="{filter_required:'Please select Ascitis'}" data-base="" tabindex="6">
                              <option value="present" <?php if($screening[0]->ascitis == 'present'){ echo "selected"; } ?>>Present</option>
                            <option value="absent" <?php if($screening[0]->ascitis == 'absent'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; } ?>>Absent</option>
                        </select>
                    </div>
            </div>
            <div class="form_field width50 select float_left">
                <div id="other_ascitis">
                </div>
            </div> 
            
        </div>
        <div class="width100 display_inlne_block">

            <div class="form_field width33 select float_left">
                    <div class="label">Joints</div>
                    <div class="input top_left">
                        <select name="joints" class="filter_required"  data-errors="{filter_required:'Please select Joints'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="swollen"  <?php if($medical_data[0]->joints == 'swollen'){ echo "selected"; }?>>swollen</option>
                            <option value="NAD"  <?php if($medical_data[0]->joints == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; }?>>normal</option>
                        </select>
                    </div>
            </div>
            <div class="form_field width33 select float_left">
                    <div class="label">Varicose veins</div>
                    <div class="input top_left">
                         <select name="varicose_veins" class="filter_required"  data-errors="{filter_required:'Please select Varicose veins'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="NAD" <?php if($medical_data[0]->varicose_veins == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; }?>>NAD</option>
                            <option value="right_leg" <?php if($medical_data[0]->varicose_veins == 'right_leg'){ echo "selected"; }?>>Right leg</option>
                            <option value="left_leg" <?php if($medical_data[0]->varicose_veins == 'left_leg'){ echo "selected"; }?>>Left leg </option>    
                        </select>
                    </div>
            </div>
            <div class="form_field width33 select float_left">
                    <div class="label">swollen joints</div>
                    <div class="input top_left">
                        <select name="No_swollen_joints" class="filter_required width100"  data-errors="{filter_required:'Please select No of swollen joints'}" data-base="" tabindex="6">
                            <option value="">Select</option>
                            <option value="great_5" <?php if($medical_data[0]->No_swollen_joints == 'great_5'){ echo "selected"; }?>>>5</option>
                            <option value="10" <?php if($medical_data[0]->No_swollen_joints == '10'){ echo "selected"; }?>>>10</option>
                            <option value="5_less" <?php if($medical_data[0]->No_swollen_joints == '5_less'){ echo "selected"; }?>><5</option>
                            <option value="NAD" <?php if($medical_data[0]->No_swollen_joints == 'NAD'){ echo "selected"; }else if(empty($medical_data[0])){ echo "selected"; }?>>NAD</option>
                        </select>
                    </div>
            </div>     
        </div>
        <div class="width100 display_inlne_block">
            <div class="form_field width33 select float_left other_textbox_outer">

                <div class="label">Diagnosis</div>

                <div class="input top_left">
                    <input name="diagnosis_name" value="<?php echo $medical_data[0]->diagnosis_name; ?>"  class="form_input mi_autocomplete filter_required" placeholder="Diagnosis" data-href="{base_url}auto/get_auto_diagosis_code" data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" data-value="<?php echo $ins_procedure[0]->diagnosis_title; ?>" tabindex="6" data-callback-funct="show_hidden_textbox" id="diagnosis_id">

                </div>
                <div class="input top_left hidden_input hide">

                    <input name="diagnosis_name_other" value="<?php echo $medical_data[0]->diagnosis_name_other; ?>"  class="form_input" placeholder="Diagnosis" d data-errors="{filter_required:'Please select pulse from dropdown list'}" type="text" tabindex="6">

                </div>
            </div>
            <div class="form_field width33 select float_left">

                <div class="label">Symptoms</div>

                <div class="input top_left">

                    <input name="symptoms" value="<?php echo $medical_data[0]->symptoms; ?>"  class="form_input  filter_required" placeholder="Symptoms" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select Symptoms from dropdown list'}" type="text" data-value="<?php echo $medical_data[0]->symptoms; ?>" tabindex="6">

                </div>

            </div>

            <div class="form_field width33 select float_left">

                <div class="label">Other Signs</div>

                <div class="input top_left">

                    <input name="other_signs" value="<?php echo $medical_data[0]->other_signs; ?>"  class="form_input  filter_required width100" placeholder="Other Signs" data-href="{base_url}auto/get_pa_opt" data-errors="{filter_required:'Please select Other Signs from dropdown list'}" type="text" data-value="<?php echo $medical_data[0]->other_signs; ?>" tabindex="6">

                </div>

            </div>

        </div>


    </div>



    <div class="save_btn_wrapper float_left">




    </div>

    <div class="width100 float_left">
        
        <div class="width100 display_inlne_block">
            <input type="button" name="accept" value="Admit to SickRoom" class="btn onpage_popup " data-href='{base_url}emt/sick_room' data-qr="output_position=popup_div"  tabindex="25">

            <input type="button" name="accept" value="Transfer to hospital" class="btn form-xhttp-request" data-href='{base_url}emt/save_medicle_events' data-qr="output_position=content&type=transper_hospital"  tabindex="25">
            <input type="button" name="accept" value="OPD prescription" class="btn form-xhttp-request" data-href='{base_url}emt/save_medicle_events' data-qr="output_position=content&type=prescription"  tabindex="25">
<!--        <input type="button" name="accept" value="Submit" class="btn form-xhttp-request" data-href='{base_url}emt/save_medicle_events' data-qr="output_position=popup_div&type=sick_room"  tabindex="25">-->
        </div>
    </div>



</form>
