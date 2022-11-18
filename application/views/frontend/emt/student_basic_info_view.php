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

<div class="head_outer"><h3 class="txt_clr2 width1">Student Basic Information</h3> </div>

<form method="post" name="" id="patient_info">


    <input type="hidden" name="schedule_id" value="<?php echo $schedule_id; ?>">

    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">



    <div class="half_div_left">

        <div class="display_inlne_block">

            <div class="style6">Student Information<span class="md_field">*</span></div>

            <div class="pat_width float_left" data-activeerror="">
                <div class="style6">First Name</div>
                <input name="stud_first_name" value="<?=@$student_data[0]->stud_first_name;?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Student first name*"  data-errors="{filter_required:'Student name should not blank'}" readonly="readonly">
            </div>
            <div class="pat_width float_left" data-activeerror="">
                <div class="style6">Middle Name</div>
                <input name="stud_middle_name" value="<?=@$student_data[0]->stud_middle_name;?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Student Middle name*"  data-errors="{filter_required:'Middle name should not blank'}" readonly="readonly">
            </div>
            <div class="pat_width float_left" data-activeerror="">
                <div class="style6">Last Name</div>
                <input name="stud_last_name" value="<?=@$student_data[0]->stud_last_name;?>" class="filter_required" tabindex="1" data-base="" type="text" placeholder="Student Last Name*"  data-errors="{filter_required:'Last Name name should not blank'}" readonly="readonly">
            </div>

            <div class="pat_width">
                <div class="style6">Age</div>
                <input name="student_age" value="<?=@$student_data[0]->stud_age;?>" class="filter_required" tabindex="4" data-base="" type="text" placeholder="Age*" data-errors="{filter_required:'Age should not blank'}" readonly="readonly">

            </div>

            <?php
            if ($student_data[0]->stud_dob) {

                $stud_dob = date('d-m-Y', strtotime($student_data[0]->stud_dob));
            }
            ?>

            <div class="pat_width">
                <div class="style6">DOB</div>
                <input name="stud_dob" value="<?=@$stud_dob;?>" class="mi_calender" tabindex="5" data-base="" type="text" placeholder="DOB:yyyy-mm-dd" readonly="readonly">

            </div>

            <div class="pat_width">
                 <div class="style6">Gender</div>
                <select name="stud_gender" class="filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6" readonly="readonly">
                    <option value="">Gender</option>

                    <?php echo get_gen_type($student_data[0]->stud_gender); ?>

                </select>
            </div>

        </div>



          <div class="width100 display_inlne_block">

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

        </div>
        <?php if($student_data[0]->stud_gender == 'F'){?>
        <div class="width100 display_inlne_block">

            <div class="width50 float_left">

                <div class="style6">Menarche date</div>

                <div class="input">
                    <input name="menarche_date" value="" class=" mi_calender" tabindex="11" data-base="" data-errors="{filter_required:'Menarche date Should not be blank'}" autocomplete="off" type="text" placeholder="Menarche date" >

                </div>

            </div>
        </div>
        <?php } ?>
        <div class="width100 display_inlne_block">
            <div class="display-inline-block width100">
                 <div class="style6">Deworming History</div>

                <div class="width100 float_left on_click_show_input">
                     <label for="done_deworning" class="radio_check width_30 float_left">
                          <input id="done_deworning" type="radio" name="deworning" class="radio_check_input filter_either_or[not_done_deworning,done_deworning]" value="Y" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($student_data[0]->deworning == 'Y'){ echo "checked"; }else{ echo $student_data[0]->deworning ;}?>>
                          <span class="radio_check_holder" ></span>Yes
                     </label>
                     <label for="not_done_deworning" class="radio_check width_30 float_left">
                         <input id="not_done_deworning" type="radio" name="deworning" class="radio_check_input filter_either_or[not_done_deworning,done_deworning]" value="N" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" TABINDEX="10.<?php echo $key;?>"  <?php if($student_data[0]->deworning =='N'){ echo "checked"; }?>>
                         <span class="radio_check_holder" ></span>No
                     </label>
                    <div class="hidden_input hide width_30 float_left">
                     <input type="text" name="deworning_date" class="mi_calender" value="Date" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key;?>">  
                    </div>
                </div>
                
                 

             </div>

        </div> 
        <div class="display-inline-block width100">
            <div class="float_left width69">   
                <div class="style6">Address</div>
   <?php
                    if(empty($student_data[0]->student_address)){
                        $student_address = $student_data[0]->student_address;
                    } ?>
                <input name="student_address" value="<?php echo $student_address; ?>" id="pac-input" class="ptn_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="ptn_dtl" data-auto="ptn_auto_addr"> 

            </div>


            <div class="float_left width30" data-activeerror="">

                <div class="style6">State</div>
                <div id="ptn_dtl_state">
                    

                    <?php
                    if(empty($ptn[0]->ptn_state)){
                        $state= $inc['ptn_state'];
                    }else{
                        $state= $ptn[0]->ptn_state;
                    }
                    
                    $st = array('st_code' => $state, 'auto' => 'ptn_auto_addr', 'rel' => 'ptn_dtl', 'disabled' => '');

                    echo get_state($st);
                    ?>

                </div>


            </div>


            <div class="pat_width">

                <div class="style6">District</div>
                <div id="ptn_dtl_dist">
                    <?php
                   if(empty($ptn[0]->ptn_district)){
                        $ptn_district= $inc['ptn_district'];
                    }else{
                        $ptn_district= $ptn[0]->ptn_state;
                    }
                    
                    $dt = array('dst_code' => $ptn_district, 'st_code' => $state, 'auto' => 'ptn_auto_addr', 'rel' => 'ptn_dtl', 'disabled' => '');

                    echo get_district($dt);
                    ?>



                </div>

            </div>

            <div class="pat_width">

                <div class="style6">City</div>
                <div id="ptn_dtl_city">      

                    <?php
                    
                    if(empty($ptn[0]->ptn_city)){
                        $ptn_city= $inc['ptn_city'];
                    }else{
                        $ptn_city= $ptn[0]->ptn_city;
                    }
                    
                    $ct = array('cty_id' => $ptn_city, 'dst_code' =>$ptn_district, 'auto' => 'ptn_auto_addr', 'rel' => 'ptn_dtl', 'disabled' => '');
                    echo get_city($ct);
                    ?>


                </div>

            </div>
            
            <div class="pat_width" >    
                <div class="style6">Pin Code</div>
                <div id="ptn_dtl_pcode">
                                    <input name="ptn_dtl_pincode" value="<?php echo $ptn[0]->ptn_pincode; ?>" class="auto_pcode" data-base="" type="text" placeholder="Pincode" tabindex="24">
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

<?php $vaccin = json_decode($student_info_data[0]->vacines);?>
    <div class="half_div_right">
        <div class="display_inlne_block width100">
          <div class="width75 display_inlne_block float_left">
              
            <div class="float_left width100">
                <div class="float_left width50">
                    <div class="style6">Father Occupation</div>
                    <div class="input" data-activeerror="">
                        <input  name="stud_father_occupation" value="<?=@$student_data[0]->stud_father_occupation;?>" class="mi_autocomplete width99" data-href="{base_url}auto/pet_occup" data-errors="" data-base="" tabindex="7" data-value="<?php echo $student_data[0]->stud_father_occupation; ?>" data-nonedit="yes" readonly="readonly">

                    </div>
                </div>

            </div>
            <div class="float_left width100">
                <div class="width50 float_left">

                    <div class="style6">Adhaar No</div>

                    <div class="input">
                        <input name="stud_adhar_no" value="<?php echo (strlen($student_data[0]->stud_adhar_no) > 11) ? $student_data[0]->stud_adhar_no : ""; ?>" class="filter_if_not_blank filter_minlength[11] filter_maxlength[13]" tabindex="12" data-base="" type="text" data-errors="{filter_minlength:'Adhar number should be at least 12 digit long',filter_maxlength:'Adhar number should be 12 digit long'}" readonly="readonly">

                    </div>

                </div>
                <div class="width50 float_left">

                    <div class="style6">Insurance No</div>

                    <div class="input">
                        <input name="stud_ins_no" value="<?=@$student_data[0]->stud_ins_no;?>" class="filter_if_not_blank width100" tabindex="12" data-base="" type="text" data-errors="{filter_minlength:'Insurance No should be at least 12 digit long',filter_maxlength:'Adhar number should be 12 digit long'}" readonly="readonly">

                    </div>

                </div>
            </div>
        </div>
          <div class="float_left width25">
                <div class="photo" style="margin-top: 23px;">
                    Photo
                </div>
           </div>
        </div>
        <div class="display_inlne_block width100">
            <table class="student_screening vaccine_list">
                <tr>
                    <td><div class="style6">Name of vaccine scheduled</div></td><td><div class="style6">Given yes/no</div></td><td><div class="style6">Scheduled date</div></td><td></td>
                </tr>
                <tr class="vacine_row">
                    <td><div class="style6">BCG</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[bcg][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date"><div class="float_left" data-activeerror="">
                            <input name="vacin[bcg][date][]" value="<?=$vaccin->bcg_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            
                           
                        </div>
                    </td>
                    <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[bcg][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[bcg][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                
                <tr class="vacine_row">
                    <td><div class="style6">OPV(0)</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[opv0][given][]" class=""  data-errors="{filter_required:'Please select OPV(0)'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes <?php if($vaccin->opv_given == 'yes'){ echo "selected";}?>">Yes</option>
                                <option value="no" <?php if($vaccin->opv_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date"><div class=" float_left" data-activeerror="">
                            <input name="vacin[opv0][date][]" value="<?=$vaccin->opv_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'OPV(0) should not blank'}">
                        </div>
                    </td>
                                        <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[opv0][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[opv0][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">Hep B Birth dose</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[hep_b][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->hep_b_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->hep_b_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date"><div class=" float_left" data-activeerror="">
                            <input name="vacin[hep_b][date][]" value="<?=$vaccin->hep_b_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'Hep B Birth dose should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[hep_b][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[hep_b][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">OPV1, Penta1(DPT+HepB+HiB)</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[opv1][given][]" class=""  data-errors="{filter_required:'Please select OPV1, Penta1(DPT+HepB+HiB)'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->opv1_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->opv1_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date"><div class=" float_left" data-activeerror="">
                            <input name="vacin[opv1][date][]" value="<?=$vaccin->opv1_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'OPV1, Penta1(DPT+HepB+HiB) should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[opv1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[opv1][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">OPV2, Penta2(DPT+HepB+HiB)</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[opv2][given][]" class=""  data-errors="{filter_required:'Please select OPV2, Penta2(DPT+HepB+HiB)'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->opv2_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->opv2_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[opv2][date][]" value="<?=$vaccin->opv2_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'OPV2, Penta2(DPT+HepB+HiB) should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[opv2][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[opv2][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">OPV3, Penta3(DPT+HepB+HiB)</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[opv3][given][]" class=""  data-errors="{filter_required:'Please select OPV3, Penta3(DPT+HepB+HiB)'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->opv3_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->opv3_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[opv3][date][]" value="<?=$vaccin->opv3_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'OPV3, Penta3(DPT+HepB+HiB) should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                            <select name="vacin[opv3][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[opv3][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td><div class="style6">IPV</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[ipv][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->ipv_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->ipv_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date"><div class=" float_left" data-activeerror="">
                            <input name="vacin[ipv][date][]" value="<?=$vaccin->ipv_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'IPV should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[ipv][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[ipv][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">MMR-1, /MR/Measels</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[mmr_mr1][given][]" class=""  data-errors="{filter_required:'Please select MMR-1, /MR/Measels'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->mmr_one_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->mmr_one_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[mmr_mr1][date][]" value="<?=$vaccin->mmr_one_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'MMR-1, /MR/Measels should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[mmr_mr1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[mmr_mr1][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
           
                                
                <tr class="vacine_row">
                    <td ><div class="style6">JE Vaccine-1</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[je1][given][]" class=" "  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->je_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->je_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[je1][date][]" value="<?=$vaccin->je_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'JE Vaccine-1 should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[je1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[je1][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
         
                                
                <tr class="vacine_row">
                    <td ><div class="style6">MMR-1</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[mmr1][given][]" class=""  data-errors="{filter_required:'Please select MMR-1'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->mmr_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->mmr_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[mmr1][date][]" value="<?=$vaccin->mmr_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'MMR-1 should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[mmr1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[mmr1][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">OPV Booster</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[opv_boos][date][]" class=""  data-errors="{filter_required:'Please select OPV Booster'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->opv_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->opv_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[opv_boos][date][]" value="<?=$vaccin->opv_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'OPV Booster should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[opv_boos][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[opv_boos][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">DPT 1st Booster</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[dpt1][date][]" class=""  data-errors="{filter_required:'Please select DPT 1st Booster'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->dpt_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->dpt_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">           
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[dpt1][date][]" value="<?=$vaccin->dpt_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'DPT 1st Booster should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[dpt1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[dpt1][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">JE Vaccine-2</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[je2][given][]" class=""  data-errors="{filter_required:'Please select JE Vaccine-2'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->je_vaccine_two_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->je_vaccine_two_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[je2][date][]" value="<?=$vaccin->je_vaccine_two_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'JE Vaccine-2 should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[je2][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[je2][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">DPT 2nd Booster</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[dpt_2boost][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->dpt_2nd_booter_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->dpt_2nd_booter_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[dpt_2boost][date][]" value="<?=$vaccin->dpt_2nd_booter_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'DPT 2nd Booster should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[dpt_2boost][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[dpt_2boost][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">TT1</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[tt1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->tt1_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->tt1_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[tt1][date][]" value="<?=$vaccin->tt1_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'TT1 should not blank'}">
                        </div>
                    </td>
                     <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[tt1][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[tt1][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <tr class="vacine_row">
                    <td ><div class="style6">TT2</div></td>
                    <td class="given">
                        <div class="input top_left">
                            <select name="vacin[tt2][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->tt2_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no" <?php if($vaccin->tt2_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                        </div>
                    </td>
                    <td class="date">            
                        <div class=" float_left" data-activeerror="">
                            <input name="vacin[tt2][date][]" value="<?=$vaccin->tt2_date;?>" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""   data-errors="{filter_required:'TT2 should not blank'}">
                        </div>
                    </td>
                    <td> 
                        <div class="add_more_vaccine_filed"></div>
                        <div class="hide">
                            <div class="vacine_given">
                                  <select name="vacin[tt2][given][]" class=""  data-errors="{filter_required:'Please select Carious Tooth'}" data-base="" tabindex="6">
                                <option value="">Select</option>
                                <option value="yes" <?php if($vaccin->bcg_given == 'yes'){ echo "selected";}?>>Yes</option>
                                <option value="no"  <?php if($vaccin->bcg_given == 'no'){ echo "selected";}?>>No</option>

                            </select>
                            </div>
                            <div class="vacine_date">
                                 <input name="vacin[tt2][date][]" value="" class=" mi_calender" tabindex="1" data-base="" type="text" placeholder=""  data-errors="{filter_required:'BCG should not blank'}">
                            </div>
                            
                        </div>
                    </td>
                </tr>

            </table>
        </div>


    </div>



    <div class="save_btn_wrapper float_left">


        <input type="button" name="accept" value="Accept" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_student_basic_info' data-qr="output_position=pat_details_block"  tabindex="25">
        <input type="button" name="update" value="Update" class="accept_btn form-xhttp-request" data-href='{base_url}emt/save_student' data-qr="output_position=pat_details_block"  tabindex="25">


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
