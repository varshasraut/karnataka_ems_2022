<?php 
$com_cheif_service = explode(',',$chief_comps_services[0]->ct_services);

if($clg_group == 'UG-ERO'){
if($cmp_service){
    foreach ($cmp_service as $service) { ?>
    <div class="width_15 float_left mt-4">
          <label for="service_<?php echo $service->srv_id; ?>" class="chkbox_check">
                                            <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" class="check_input unit_checkbox" value="<?php echo $service->srv_id; ?>"  id="service_<?php echo $service->srv_id; ?>" <?php if(in_array($service->srv_id, $com_cheif_service)){ echo "checked";} ?>>
                                            <span class="chkbox_check_holder"></span><?php echo $service->srv_name; ?><br>
                                     </label>
<!--        <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" <?php if(in_array($service->srv_id, $com_cheif_service)){ echo "checked";} ?> TABINDEX="<?php echo $key+9;?>">-->
            <?php //echo $service->srv_name; ?>
    </div>
<?php } 
} 
}
?>
<?php 

if(in_array(2, $com_cheif_service)){ 
    $police_show = ''; 
    
}else{
     $police_show = 'hide';
}?>
<!--    <div class="width100 float_left form_field float_left <?php echo $police_show;?>" id="police_cheif">
        <div class="label blue float_left width30">Police Complaint</div>
        <div class="input nature top_left float_left width70" >
            <div class="input">
            <input type="text" name="incient[police_chief_complete]" id="police_chief_complete" class="mi_autocomplete"  data-href="{base_url}auto/get_police_chief_complete"  placeholder="Police Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="police_chief_complete_change" TABINDEX="8">
            </div>
            <div class="input nature top_left hide" id="police_chief_complete_other">
                <input type="text" name="incient[police_chief_complete_other]" id="police_chief_complete_other_text"  class=""  placeholder="Other Police Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8">
            </div>
       </div>

  
    </div>-->
<?php 
if(in_array(3, $com_cheif_service)){     
    $fire_show = ''; 
    
}else{
    $fire_show = 'hide';
} ?>
<!--    <div class="width100 float_left form_field float_left <?php echo $fire_show;?>" id="fire_cheif">
        <div class="label blue float_left width30">Fire Complaint</div>
        <div class="input nature top_left float_left width70" >
             <div class="input">
                <input type="text" name="incient[fire_chief_complete]" id="fire_chief_complete" class="mi_autocomplete"  data-href="{base_url}auto/get_fire_chief_complete"  placeholder="Fire Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="fire_chief_complete_change" TABINDEX="8" >
             </div>
               <div class="input nature top_left hide" id="fire_chief_complete_other">
            <input type="text" name="incient[fire_chief_complete_other]" id="fire_chief_complete_other_text"  class=""  placeholder="Other Fire Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8" >
        </div>
        </div>
        
     
    </div>-->

<?php if($clg_group != 'UG-BIKE-ERO'){ ?>
    <div class="width_55 float_left form_field text-center" >
        <!-- <input type="radio" class="radio_check"id="html" name="fav_language" value="HTML">
        <label for="html">HTML</label>   -->
        <div class="label">Select Questions Language<span class="md_field">*</span>
        </div>
       
        <label for="ques_<?php echo $question->que_id;?>_yes" class="radio_check  float_left">   
        </label>
        <input class="width15" type="radio" id="questiions_english" name="incient[que_lan]" value="English">
        <span></span> English
         
        <!--<input class="width15" type="radio" id="questiions_marathi" name="incient[que_lan]" value="Marathi">
        <span  ></span>Marathi-->
        
        <input class="width15" type="radio" id="questiions_hindi" name="incient[que_lan]" value="Hindi" checked="checked">
        <span ></span>Hindi
        
    </div>     
    
<div class="width97 float_left form_field" id="questions_english1">


<!--    <div class="question_error_div">Please Select Questions answer first</div>-->
    <div class="label">Questions<span class="md_field">*</span></div>
    <?php 
    if($questions){
        if($inc_ref_no == ''){
    foreach ($questions as $key=>$question) { //var_dump($question->sum_que_ans); ?>
        <div class="width100 questions_row flt_nonmci" id="ques_<?php echo $question->que_id;?>">
            <!-- <div class="width70 float_left"><?php echo $question->que_question; ?></div> -->
            <div class="width70 float_left questions_english" id="questions_english"><?php echo $question->que_question; ?>
                    </div>

            <div class="width70 float_left questions_marathi" id="questions_marathi"><?php echo $question->que_question_marathi; ?>
            </div>
            <div class="width70 float_left questions_hindi" id="questions_hindi"><?php echo $question->que_question_hindi; ?>
            </div>

            <div class="width_30 float_right">
                <label for="ques_<?php echo $question->que_id;?>_yes" class="radio_check width2 float_left">
                     <input id="ques_<?php echo $question->que_id;?>_yes" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id;?>_yes,ques_<?php echo $question->que_id;?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>" <?php if($question->sum_que_ans == "Y"){ echo "checked";}?>>
                     <span class="radio_check_holder" ></span>Yes
                </label>
                <label for="ques_<?php echo $question->que_id;?>_no" class="radio_check width2 float_left">
                    <input id="ques_<?php echo $question->que_id;?>_no" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id;?>_yes,ques_<?php echo $question->que_id;?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($question->sum_que_ans == "N"){ echo "checked";}?>>
                    <span class="radio_check_holder" ></span>No
                </label>
            </div>   
        </div>
    <?php }
        }else{
            foreach ($questions as $key=>$question) { //var_dump($question->sum_que_ans);?>
        <div class="width100 questions_row flt_nonmci" id="ques_<?php echo $question->que_id;?>">
            <!-- <div class="width70 float_left"><?php echo $question->que_question; ?></div> -->

            <div class="width70 float_left questions_english"><?php echo $question->que_question; ?>
                    </div>

                    <div class="width70 float_left questions_marathi"  id="questions_marathi"><?php echo $question->que_question_marathi; ?>
                    </div>

                    <div class="width70 float_left questions_hindi" id="questions_hindi"><?php echo $question->que_question_hindi; ?>
                    </div>

            <div class="width_30 float_right">
                <label for="ques_<?php echo $question->que_id;?>_yes" class="radio_check width2 float_left">
                     <input id="ques_<?php echo $question->que_id;?>_yes" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($question->sum_que_ans == "Y"){ echo "checked";}?>>
                     <span class="radio_check_holder" ></span>Yes
                </label>
                <label for="ques_<?php echo $question->que_id;?>_no" class="radio_check width2 float_left">
                    <input id="ques_<?php echo $question->que_id;?>_no" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input " value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($question->sum_que_ans == "N"){ echo "checked";}?>>
                    <span class="radio_check_holder" ></span>No
                </label>
            </div>   
        </div>
    <?php }
        }
    
    } 
    ?>      
     <input type="hidden" name="incient[chief_complete1]" id="chief_complaint_id" value="" data-base="search_btn">
    <input name="ques_btn" id="get_ques_ans_details" value="SEARCH" style="visibility: hidden;" class="style3 base-xhttp-request" data-href="{base_url}inc/get_ambu_type" data-qr="output_position=inc_details" type="button">
 </div>
<?php } ?>



<script >
$(document).ready(function () {
    $('.questions_english').hide();
    $('.questions_marathi').hide();
    $('.questions_hindi').show();
   // $('#questions_english1').hide();
    


$('#questiions_marathi').click(function () {
      
       $('.questions_marathi').show();
       $('.questions_english').hide();
       $('.questions_hindi').hide();
       $('#questions_english1').show();
   });
   
$('#questiions_english').click(function () {
   
       $('.questions_english').show();
       $('.questions_marathi').hide();
       $('.questions_hindi').hide();
       $('#questions_english1').show();
   });

   $('#questiions_hindi').click(function () {
   
       $('.questions_hindi').show();
       $('.questions_marathi').hide();
       $('.questions_english').hide();
       $('#questions_english1').show();
   });
   

   });

   </script >