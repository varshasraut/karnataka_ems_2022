<script>
if(typeof H != 'undefined'){{
    init_auto_address();
}
</script>

<?php
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Dental Screening</h3> </div>

<form method="post" name="" id="patient_info">


    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left1">

        
        <div class="width100 display_inlne_block">


            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">Oral Hygiene</div>

               <div class="width50 float_left">
                    <label for="oral_hygiene_yes" class="radio_check width_30 float_left">
                         <input id="oral_hygiene_yes" type="radio" name="oral_hygiene" class="radio_check_input" value="good" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>Good
                    </label>
                    <label for="oral_hygiene_no" class="radio_check width_30 float_left">
                        <input id="oral_hygiene_no" type="radio" name="oral_hygiene" class="radio_check_input" value="fair" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>Fair
                    </label>
                    <label for="oral_hygiene_poor" class="radio_check width_30 float_left">
                        <input id="oral_hygiene_poor" type="radio" name="oral_hygiene" class="radio_check_input" value="poor" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>Poor
                    </label>
                </div>  
                     
                <div class="input top_left width25 float_left">
                            <input name="oral_hygiene_text" value="<?php echo $student_dental_data[0]->oral_hygiene_text;?>"  class="form_input" placeholder="Oral Hygiene" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div> 
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">Gum condition</div>

               <div class="width50 float_left">
                    <label for="gum_condition_yes" class="radio_check width_30 float_left">
                         <input id="gum_condition_yes" type="radio" name="gum_condition" class="radio_check_input " value="good" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>Good
                    </label>
                    <label for="gum_condition_no" class="radio_check width_30 float_left">
                        <input id="gum_condition_no" type="radio" name="gum_condition" class="radio_check_input " value="fair" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>Fair
                    </label>
                   <label for="gum_condition_poor" class="radio_check width_30 float_left">
                        <input id="gum_condition_poor" type="radio" name="gum_condition" class="radio_check_input " value="poor" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>Poor
                    </label>
                </div> 
                      <div class="input top_left width25 float_left">
                            <input name="gum_condition_text" value="<?php echo $student_dental_data[0]->gum_condition_text;?>"  class="form_input" placeholder="Gum condition" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div> 
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">oral ulcers</div>

               <div class="width50 float_left">
                    <label for="oral_ulcers_yes" class="radio_check width_30 float_left">
                         <input id="oral_ulcers_yes" type="radio" name="oral_ulcers" class="radio_check_input " value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="oral_ulcers_no" class="radio_check width_30 float_left">
                        <input id="oral_ulcers_no" type="radio" name="oral_ulcers" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="oral_ulcers_text" value="<?php echo $student_dental_data[0]->oral_ulcers_text;?>"  class="form_input" placeholder="Oral ulcers" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div> 
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">Gum bleeding</div>

                <div class="width50 float_left">
                    <label for="gum_bleeding_yes" class="radio_check width_30 float_left">
                         <input id="gum_bleeding_yes" type="radio" name="gum_bleeding" class="radio_check_input " value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="gum_bleeding_no" class="radio_check width_30 float_left">
                        <input id="gum_bleeding_no" type="radio" name="gum_bleeding" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>    
                      <div class="input top_left width25 float_left">
                            <input name="gum_bleeding_text" value="<?php echo $student_dental_data[0]->gum_bleeding_text;?>"  class="form_input" placeholder="Gum bleeding" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div> 
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">sensitive teeth</div>

               <div class="width50 float_left">
                    <label for="sensitive_teeth_yes" class="radio_check width_30 float_left">
                         <input id="sensitive_teeth_yes" type="radio" name="sensitive_teeth" class="radio_check_input " value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="sensitive_teeth_no" class="radio_check width_30 float_left">
                        <input id="sensitive_teeth_no" type="radio" name="sensitive_teeth" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="sensitive_teeth_text" value="<?php echo $student_dental_data[0]->sensitive_teeth_text;?>"  class="form_input" placeholder="Sensitive teeth" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div> 
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">discoloration of teeth</div>

               <div class="width50 float_left">
                    <label for="discoloration_of_teeth_yes" class="radio_check width_30 float_left">
                         <input id="discoloration_of_teeth_yes" type="radio" name="discoloration_of_teeth" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="discoloration_of_teeth_no" class="radio_check width_30 float_left">
                        <input id="discoloration_of_teeth_no" type="radio" name="discoloration_of_teeth" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="discoloration_of_teeth_text" value="<?php echo $student_dental_data[0]->discoloration_of_teeth_text;?>"  class="form_input" placeholder="Discoloration of teeth" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div>
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">Food impaction</div>

               <div class="width50 float_left">
                    <label for="food_impaction_yes" class="radio_check width_30 float_left">
                         <input id="food_impaction_yes" type="radio" name="food_impaction" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="food_impaction_no" class="radio_check width_30 float_left">
                        <input id="food_impaction_no" type="radio" name="food_impaction" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>
                      <div class="input top_left width25 float_left">
                            <input name="food_impaction_text" value="<?php echo $student_dental_data[0]->food_impaction_text;?>"  class="form_input" placeholder="Food impaction" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div>
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">carious teeth</div>

                <div class="width50 float_left">
                    <label for="carious_teeth_yes" class="radio_check width_30 float_left">
                         <input id="carious_teeth_yes" type="radio" name="carious_teeth" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="carious_teeth_no" class="radio_check width_30 float_left">
                        <input id="carious_teeth_no" type="radio" name="carious_teeth" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>
                      <div class="input top_left width25 float_left">
                            <input name="carious_teeth_text" value="<?php echo $student_dental_data[0]->carious_teeth_text;?>"  class="form_input" placeholder="Carious teeth" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div>
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">malalignment</div>

                <div class="width50 float_left">
                    <label for="malalignment_yes" class="radio_check width_30 float_left">
                         <input id="malalignment_yes" type="radio" name="malalignment" class="radio_check_input " value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="malalignment_no" class="radio_check width_30 float_left">
                        <input id="malalignment_no" type="radio" name="malalignment" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div> 
                      <div class="input top_left width25 float_left">
                            <input name="malalignment_text" value="<?php echo $student_dental_data[0]->malalignment_text;?>"  class="form_input" placeholder="Malalignment" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div>
            
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">orthodontic treatment</div>

                <div class="width50 float_left">
                    <label for="orthodontic_treatment_yes" class="radio_check width_30 float_left">
                         <input id="orthodontic_treatment_yes" type="radio" name="orthodontic_treatment" class="radio_check_input " value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="orthodontic_treatment_no" class="radio_check width_30 float_left">
                        <input id="orthodontic_treatment_no" type="radio" name="orthodontic_treatment" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="orthodontic_treatment_text" value="<?php echo $student_dental_data[0]->orthodontic_treatment_text;?>"  class="form_input" placeholder="Orthodontic treatment" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div>
            
            <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">extraction done</div>

                <div class="width50 float_left">
                    <label for="extraction_done_yes" class="radio_check width_30 float_left">
                         <input id="extraction_done_yes" type="radio" name="extraction_done" class="radio_check_input " value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="extraction_done_no" class="radio_check width_30 float_left">
                        <input id="extraction_done_no" type="radio" name="extraction_done" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="extraction_done_text" value="<?php echo $student_dental_data[0]->extraction_done_text;?>"  class="form_input" placeholder="Extraction done" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>

                 </div>

            </div>
             <div class="width100 display_inlne_block">
                <div class="display-inline-block width100">
                     <div class="style6 width25 float_left">Fluorosis</div>

                <div class="width50 float_left">
                    <label for="fluorosis_yes" class="radio_check width_30 float_left">
                         <input id="fluorosis_yes" type="radio" name="fluorosis" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>yes
                    </label>
                    <label for="fluorosis_no" class="radio_check width_30 float_left">
                        <input id="fluorosis_no" type="radio" name="fluorosis" class="radio_check_input" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>No
                    </label>
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="fluorosis_text" value="<?php echo $student_dental_data[0]->fluorosis_text;?>"  class="form_input" placeholder="Fluorosis" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>
                 </div>

            </div>
            
            <div class="width100 display_inlne_block">
               
                     <div class="style6 width25 float_left">tooth brushing frequency</div>

                <div class="width50 float_left">
                    <label for="tooth_brushing_frequency_yes" class="radio_check width_30 float_left">
                         <input id="tooth_brushing_frequency_yes" type="radio" name="tooth_brushing_frequency" class="radio_check_input " value="one_day" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                         <span class="radio_check_holder" ></span>1/day
                    </label>
                    <label for="tooth_brushing_frequency_no" class="radio_check width_30 float_left">
                        <input id="tooth_brushing_frequency_no" type="radio" name="tooth_brushing_frequency" class="radio_check_input " value="two_day" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>2/day
                    </label>
                    <label for="tooth_brushing_frequency_day" class="radio_check width_30 float_left">
                        <input id="tooth_brushing_frequency_day" type="radio" name="tooth_brushing_frequency" class="radio_check_input " value="great_one_day" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                        <span class="radio_check_holder" ></span>1 < day
                    </label> 
                </div>  
                      <div class="input top_left width25 float_left">
                            <input name="tooth_brushing_frequency_text" value="<?php echo $student_dental_data[0]->tooth_brushing_frequency_text;?>"  class="form_input" placeholder="Tooth brushing frequency" data-errors="{filter_required:'Right should not be blank',}" type="text" tabindex="18">

                </div>


            </div>
            <div class="form_field width50 select float_left">
                    <div class="label">Comment</div>
                    <div class="input top_left">
                        <input name="dental_comment" value="<?php echo $student_dental_data[0]->dental_comment;?>" class="" tabindex="51" data-base="" data-errors="{filter_minlength:'Comment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
            </div>
            <div class="form_field width50 select float_left">
                    <div class="label">treatment given</div>
                    <div class="input top_left">
                        <input name="dental_treatment_given" value="<?php echo $student_dental_data[0]->dental_treatment_given;?>" class="" tabindex="51" data-base="" data-errors="{filter_minlength:'Treatment should be at least 12 digit long'}" autocomplete="off" type="text">
                    </div>
            </div>

            
       
        </div>

    </div>


    <div class="half_div_right">


       
           



    </div>



    <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_dental' data-qr="output_position=pat_details_block"  tabindex="25">


    </div>

    <div class="width100 float_left">
        <br>
    </div>



</form>
