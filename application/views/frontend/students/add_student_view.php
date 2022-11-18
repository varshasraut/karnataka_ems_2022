<script>
if(typeof H != 'undefined'){
    init_auto_address();
}
</script>

<?php
$view = ($stud_action == 'view') ? 'disabled' : '';
$CI = EMS_Controller::get_instance();

$bgtype[$ptn[0]->ptn_bgroup_type] = "selected='selected'";

$rtncrd[$ptn[0]->ptn_ration_card] = "checked=''";
?>

<div class="head_outer"><h3 class="txt_clr2 width1">Student Information</h3> </div>

<form method="post" name="" id="patient_info">

    <div class="half_div_left">

        <div class="display_inlne_block">

            <div class="style6">Student Information<span class="md_field">*</span></div>

            <div class="pat_width float_left" data-activeerror="">
                <div class="style6">First Name</div>
                <input name="stud[stud_first_name]" value="<?=@$student_data[0]->stud_first_name;?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Student first name*"  data-errors="{filter_required:'Student name should not blank'}" <?php echo $view; ?>>
            </div>
            <div class="pat_width float_left" data-activeerror="">
                <div class="style6">Middle Name</div>
                <input name="stud[stud_middle_name]" value="<?=@$student_data[0]->stud_middle_name;?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Student Middle name*"  data-errors="{filter_required:'Middle name should not blank'}" <?php echo $view; ?>>
            </div>
            <div class="pat_width float_left" data-activeerror="">
                <div class="style6">Last Name</div>
                <input name="stud[stud_last_name]" value="<?=@$student_data[0]->stud_last_name;?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Student Last Name*"  data-errors="{filter_required:'Last Name name should not blank'}" <?php echo $view; ?>>
            </div>

            <div class="pat_width">
                <div class="style6">Age</div>
                <input name="stud[stud_age]" value="<?=@$student_data[0]->stud_age;?>" class="filter_required" tabindex="4" data-base="" type="text" placeholder="Age*" data-errors="{filter_required:'Age should not blank'}" <?php echo $view; ?>>

            </div>

            <?php
            if ($student_data[0]->stud_dob) {

                $stud_dob = date('d-m-Y', strtotime($student_data[0]->stud_dob));
            }
            ?>

            <div class="pat_width">
                <div class="style6">DOB</div>
                <input name="stud[stud_dob]" value="<?=@$stud_dob;?>" class="mi_calender" tabindex="5" data-base="" type="text" placeholder="DOB:yyyy-mm-dd" <?php echo $view; ?>>

            </div>

            <div class="pat_width">
                 <div class="style6">Gender</div>
                <select name="stud[stud_gender]" class="filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6" <?php echo $view; ?>>
                    <option value="">Gender</option>

                    <?php echo get_gen_type($student_data[0]->stud_gender); ?>

                </select>
            </div>

        </div>



<!--          <div class="width100 display_inlne_block">

              <div class="width50 float_left">

                <div class="style6">Past Medical History</div>

                <div  class="input">
                    <input name="past_medicle_history" value="<?php if($student_info_data[0]->past_medicle_history==""){ echo "None"; }else{ echo $student_info_data[0]->past_medicle_history; }?>" class="filter_required" tabindex="11" data-base="" data-errors="{filter_required:'Past Medical History Should not be blank'}" autocomplete="off" type="text" placeholder="Past Medical History" >

                </div>

            </div>
              <div class="width50 float_left">
                <div class="style6">Prev Hospitalisation</div>
                <div class="input">
                    <input name="prev_hospitalization" value="<?php if($student_info_data[0]->prev_hospitalization==""){ echo "None"; }else{ echo $student_info_data[0]->prev_hospitalization; }?>" class="filter_required" tabindex="10" data-base="" type="text" placeholder="Prev Hospitalisation"  data-errors="{filter_required:'Prev Hospitalisation Should not be blank'}">

                </div>

            </div>

        </div>
        <div class="width100 display_inlne_block">

           <div class="width50 float_left">

                <div class="style6">Current medication</div>

                <div class="input">
                    <input name="current_medication" value="<?php if($student_info_data[0]->current_medication==""){ echo "None"; }else{ echo $student_info_data[0]->current_medication; } ?>" class="filter_required" tabindex="11" data-base="" data-errors="{filter_required:'Current medication Should not be blank'}" autocomplete="off" type="text" placeholder="Current medication" >

                </div>

            </div>
            <div class="width50 float_left">
                <div class="style6">Allergies</div>
                <div class="input">
              <input name="allergies" value="<?php if($student_info_data[0]->allergies==""){ echo "None"; }else{ echo $student_info_data[0]->allergies; }?>" class="filter_required" tabindex="11" data-base="" data-errors="{filter_required:'Allergies Should not be blank'}" autocomplete="off" type="text" placeholder="Allergies" >

                </div>

            </div>

        </div>-->
        <?php if($student_data[0]->stud_gender == 'F'){?>
        <div class="width100 display_inlne_block">

            <div class="width50 float_left">

                <div class="style6">Menarche date</div>

                <div class="input">
                    <input name="stud[menarche_date]" value="" class=" mi_calender" tabindex="11" data-base="" data-errors="{filter_required:'Menarche date Should not be blank'}" autocomplete="off" type="text" placeholder="Menarche date" <?php echo $view; ?>>

                </div>

            </div>
        </div>
        <?php } ?>
            <div class="display-inline-block width100">
                 <div class="style6">Deworming History</div>

                <div class="width100 float_left on_click_show_input">
                     <label for="done_deworning" class="radio_check width_30 float_left">
                          <input id="done_deworning" type="radio" name="stud[deworning]" class="radio_check_input filter_either_or[not_done_deworning,done_deworning]" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($student_data[0]->deworning == 'Y'){ echo "checked"; }else{ echo $student_data[0]->deworning ;}?> <?php echo $view; ?>>
                          <span class="radio_check_holder" ></span>Yes
                     </label>
                     <label for="not_done_deworning" class="radio_check width_30 float_left">
                         <input id="not_done_deworning" type="radio" name="stud[deworning]" class="radio_check_input filter_either_or[not_done_deworning,done_deworning]" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($student_data[0]->deworning =='N'){ echo "checked"; }?> <?php echo $view; ?>>
                         <span class="radio_check_holder" ></span>No
                     </label>
                    <div class="hidden_input hide width_30 float_left">
                     <input type="text" name="stud[deworning_date]" class="mi_calender" value="Date" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>" <?php echo $view; ?>>  
                    </div>
                </div>
                
                 

             </div>
  
        
<!--        <div class="width100 display_inlne_block">
            <div class="display-inline-block width100">
                 <div class="style6">Pulse Polio Vaccination </div>

           <div class="width100 float_left">
                <label for="pulse_polio_done" class="radio_check width_30 float_left">
                     <input id="pulse_polio_done" type="radio" name="pulse_polio" class="radio_check_input filter_either_or[pulse_polio_not_done,pulse_polio_done]" value="done" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                     <span class="radio_check_holder" ></span>Done
                </label>
                <label for="pulse_polio_not_done" class="radio_check width_30 float_left">
                    <input id="pulse_polio_not_done" type="radio" name="pulse_polio" class="radio_check_input filter_either_or[pulse_polio_not_done,pulse_polio_done]" value="not_done" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>">
                    <span class="radio_check_holder" ></span>Not Done
                </label>
            </div>  

             </div>

        </div> -->



    </div>

    <div class="half_div_right">
        <div class="display_inlne_block width100">
          <div class="width75 display_inlne_block float_left">
              
            <div class="float_left width100">
                <div class="float_left width50">
                    <div class="style6">Father Occupation</div>
                    <div class="input" data-activeerror="">
                        <input  name="stud[stud_father_occupation]" value="<?=@$student_data[0]->stud_father_occupation;?>" class="mi_autocomplete width99" data-href="<?php echo base_url();?>auto/pet_occup" data-errors="" data-base="" tabindex="7" data-value="<?php echo $student_data[0]->stud_father_occupation; ?>" data-nonedit="yes" <?php echo $view; ?>>

                    </div>
                </div>

            </div>
            <div class="float_left width100">
                <div class="width50 float_left">

                    <div class="style6">Adhaar No</div>

                    <div class="input">
                        <input name="stud[stud_adhar_no]" value="<?php echo (strlen($student_data[0]->stud_adhar_no) > 11) ? $student_data[0]->stud_adhar_no : $student_data[0]->stud_adhar_no ; ?>" class="filter_if_not_blank filter_minlength[11] filter_maxlength[13]" tabindex="12" data-base="" type="text" data-errors="{filter_minlength:'Adhar number should be at least 12 digit long',filter_maxlength:'Adhar number should be 12 digit long'}" <?php echo $view; ?>>

                    </div>

                </div>
                <div class="width50 float_left">

                    <div class="style6">Insurance No</div>

                    <div class="input">
                        <input name="stud[stud_ins_no]" value="<?=@$student_data[0]->stud_ins_no;?>" class="filter_if_not_blank width100" tabindex="12" data-base="" type="text" data-errors="{filter_minlength:'Insurance No should be at least 12 digit long',filter_maxlength:'Adhar number should be 12 digit long'}" <?php echo $view; ?>>

                    </div>

                </div>
            </div>
        </div>
<!--          <div class="float_left width25">
                <div class="photo" style="margin-top: 23px;">
                    Photo
                </div>
           </div>-->
        </div>
    

    </div>
  <div class="display-inline-block width100">
            <div class="field_row width30" >

                <div class="field_lable"><label for="schedule_schoolid">School Name<span class="md_field">*</span></label></div>   

                <div class="field_input" id="schedule_clusterid">
                    <select name="stud[schd_school_id]" class="filter_required" data-errors="{filter_required:'School should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                        <option value="">Select School</option>

                        <?php echo get_school_type($student_data[0]->schd_school_id); ?>
                    </select>
                </div>

            </div>
            <div class="float_left width69">   
                <div class="style6">Address</div>
   <?php
                    if(empty($student_data[0]->student_address)){
                        $student_address = $student_data[0]->student_address;
                    } ?>
                <input name="stud[stud_address]" value="<?php echo $student_address; ?>" id="pac-input" class="stud_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="stud_dtl" data-auto="ptn_auto_addr" <?php echo $view; ?>> 

            </div>


            <div class="float_left width30" data-activeerror="">

                <div class="style6">State</div>
                <div id="stud_dtl_state">
                    

                    <?php

                        $state= $student_data[0]->stud_district;
                    
                    
                    $st = array('st_code' => $state, 'auto' => 'ptn_auto_addr', 'rel' => 'stud_dtl', 'disabled' => '');

                    echo get_state($st);
                    ?>

                </div>


            </div>


            <div class="pat_width">

                <div class="style6">District</div>
                <div id="stud_dtl_dist">
                    <?php
 
                        $ptn_district= $student_data[0]->stud_district;
                    
                    
                    $dt = array('dst_code' => $ptn_district, 'st_code' => $state, 'auto' => 'ptn_auto_addr', 'rel' => 'stud_dtl', 'disabled' => '');

                    echo get_district($dt);
                    ?>



                </div>

            </div>

            <div class="pat_width">

                <div class="style6">City</div>
                <div id="stud_dtl_city">      

                    <?php
                    
               
                        $ptn_city= $student_data[0]->stud_city;
                    
                    
                    $ct = array('cty_id' => $ptn_city, 'dst_code' =>$ptn_district, 'auto' => 'ptn_auto_addr', 'rel' => 'stud_dtl', 'disabled' => '');
                    echo get_city($ct);
                    ?>


                </div>

            </div>
            
           
            <div class="pat_width" >
                           <div class="style6">Area/Location</div>
                           <div id="stud_dtl_area">
                               
                <input name="stud_dtl_area" value="<?php echo $student_data[0]->locality; ?>" class="auto_area" data-base="" type="text" placeholder="Area/Location" tabindex="20" <?php echo $view; ?>>
                           </div>

            </div>

            <div class="pat_width" id="stud_dtl_lmark">
                <div class="style6">Landmark</div>
                <input name="stud_dtl_lmark" value="<?php echo $student_data[0]->lankmark; ?>" class="auto_lmark" data-base="" type="text" placeholder="Landmark" tabindex="21" <?php echo $view; ?>>

            </div>

            <div class="pat_width" id="stud_dtl_lane">   
                 <div class="style6">Lane/Street</div>
                <input name="stud_dtl_lane" value="<?php echo $student_data[0]->road; ?>" class="auto_lane" data-base="" type="text" placeholder="Lane/Street" tabindex="22" <?php echo $view; ?>>
            </div>
             <div class="pin_house">

            <div class="pat_width" id="stud_dtl_hno">    
                 <div class="style6">House Number</div>
                <input name="stud_dtl_hno" value="<?php echo $student_data[0]->house_no; ?>" class="auto_hno" data-base="" type="text" placeholder="House Number" tabindex="23" <?php echo $view; ?>>
            </div>
            <div class="pat_width" > 
                 <div class="style6">Pincode</div>
                 <div id="stud_dtl_pcode">
                     
                <input name="stud_dtl_pincode" value="<?php echo $student_data[0]->pincode; ?>" class="auto_pcode" data-base="" type="text" placeholder="Pincode" tabindex="24" <?php echo $view; ?>>
                 </div>
            </div> 

        </div>

        </div>


    <div class="save_btn_wrapper float_left">


<!--        <input type="button" name="save" value="Submit" class="accept_btn form-xhttp-request" data-href='<?php echo base_url();?>students/save_students' data-qr="output_position=content"  tabindex="25">-->
            <input type="button" name="save" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url();?>students/<?php if ($student_data) { ?>update_students<?php } else { ?>save_students<?php } ?>' data-qr='stud_id[0]=<?php echo base64_encode($student_data[0]->stud_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">


    </div>

    <div class="width100 float_left">
        <br>
    </div>



</form>
<script>

            $("option").each(function() {
            $(this).text($(this).text().charAt(0).toUpperCase() + $(this).text().slice(1));
        });
  
</script>
