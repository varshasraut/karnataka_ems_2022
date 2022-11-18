<div class="call_purpose_form_outer" id="corona_suspected_medical_advice">
    <div class="width100">
        <!-- <h3>Corona Suspected Medical Advice</h3> -->
        <label class="headerlbl">Corona Suspected Medical Advice</label>
        <div class="incident_details">
            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">
                <div class="call_common_info ">
                                <div class="float_left width97">
                                                    <div class="label blue"><b>Employee Information</b></div><?php //var_dump($caller_details_data); ?>
                                                <div class="width_16 float_left">
                                                    <input type="text" name="patient[full_name]" class="filter_required  "  data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="" placeholder="First Name" TABINDEX="11">
                                                </div>
                                                <div class="width_16 float_left">
                                                    <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="patient[patient_mobile_no]" class="filter_required  "  data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?=@$caller_details_data['clr_mname'];?>" placeholder="Mobile no" TABINDEX="12">
                                                </div>
                                               <div class="width_16 float_left">
                                                  <input id="ptn_dob" data-fname="patient[age]" type="text" name="patient[dob]" class="mi_cur_date"  data-errors="{filter_required:'DOB should not be blank',filter_number:'Age should be in numbers'}" value="<?=@$caller_details_data['patient_dob'];?>" placeholder="DOB" TABINDEX="14" readonly="readonly" >
                                                </div>
                                                <div class="width_16 float_left" id="ptn_age_outer">
                                                        <input id="ptn_age" type="text" name="patient[age]" class="filter_rangelength[0-100]"  data-errors="{filter_rangelength:'Age should be 0 to 100',filter_number:'Age should be in numbers'}" value="<?=@$caller_details_data['patient_age'];?>" placeholder="Age" TABINDEX="14" >
                                                    </div>
                                                    
                                                <div class="width_16 float_left" id="non_mci_patient_gender">
                                                        <select id="patient_gender" name="patient[gender]" class="filter_required" <?php echo $view; ?> TABINDEX="15"  data-errors="{filter_required:'Please select Gender from dropdown list'}">
                                                            <option value="">Gender</option>
                                                            <option value="M" <?php if($caller_details_data['patient_gender'] == 'Male' || $caller_details_data['patient_gender'] == 'M'){ echo "selected"; }?>>Male</option> 
                                                            <option value="F" <?php if($caller_details_data['patient_gender'] == 'Female' || $caller_details_data['patient_gender'] == 'F'){ echo "selected"; }?>>Female</option>
                                                            <option value="O" <?php if($caller_details_data['patient_gender'] == 'Other' || $caller_details_data['patient_gender'] == 'O'){ echo "selected"; }?>>Other</option>
                                                        </select>
                                                    </div>
<!--                                                    <div class="width_16 float_left">
                                                    <input type="text" name="patient[carona_test_date]" class="filter_required  mi_calender"  data-errors="{filter_required:'Test date should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?=@$caller_details_data['clr_mname'];?>" placeholder="Test Date" TABINDEX="12">
                                                </div>-->

                                                </div>
                 </div>
                 <br>
                 <div class="call_common_info ">
                    <div class="float_left width97">
                        <div class="label blue">
                            <b>Official Information</b></div><?php //var_dump($caller_details_data); ?>
                            <div class="width_16 float_left">
                                <input type="text" name="patient[designation]" class="filter_required "  data-errors="{filter_required:'designation should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="" placeholder="Designation" TABINDEX="11">
                            </div>
                            <div class="width_16 float_left">
                                <input type="text" name="patient[emp_code]" class="filter_required "  data-errors="{filter_required:'employee should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="" placeholder="Employee Code" TABINDEX="11">
                            </div>
                        </div>
                 </div>
                 <br>
                 <!--<div class="float_left width97" >
                     <div class="label blue"><b>ERO Advice</b></div><?php //var_dump($caller_details_data);  ?>
                     <div class="width_16 float_left">
                         <select id="patient_gender" name="patient[advice]"  <?php echo $view; ?> TABINDEX="15" >
                            <option value="">Select ERO Advice</option>
                            <?php
                           // var_dump($advice);
                            foreach($advice as $adv){ ?>
                            <option value="<?php echo $adv->id;?>"><?php echo $adv->advice_name;?></option> 
                            <?php } ?>
                        </select>
                     </div>

                 </div>
                 <div class="width97">
<div class="width70 float_left form_field" id="corona_question_view">

    <div class="label">Questions<span class="md_field">*</span></div>
    <?php 
    if($questions){
       
    foreach ($questions as $key=>$question) { //var_dump($question->sum_que_ans); ?>
        <div class="width100 corona_question_view flt_nonmci" id="ques_<?php echo $question->que_id;?>">
            <div class="width70 float_left"><?php echo $question->que_question; ?></div>
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
            <div class="feedback_input hide">
                 <?php if($key == 0){?>
                <div class="width80">
                  
                   
                    <div class="width40 first_ques_1 float_left">
                        <input type="text" name="incient[other][<?php echo $question->que_id ?>][long_symptoms]" placeholder="how long you have been experiencing these symptoms">
                    </div>  
                   
                    <div class="width40 first_ques_2 float_left">
                        <input type="text" name="incient[other][<?php echo $question->que_id ?>][suffering_disease]" placeholder="are you above 60 years of age or suffering from diabetes, hypertension, chronic kidney or respiratory disease">
                    </div> 
                </div>
                 <?php }else if($key == 1){ ?>
                <div class="width80">
                
                <div class="width40 second_ques_1 float_left">
                    <input type="text" name="incient[other][<?php echo $question->que_id ?>][visited_place]" placeholder="name of the country/state within India visited by you">
                </div> 
               
                <div class="width40 second_ques_2 float_left">
                    <input type="text" name="incient[other][<?php echo $question->que_id ?>][contact_with_person]" placeholder="If yes, have you come in contact with anyone suffering from fever, cough, and difficulty in breathing">
                </div> 
            </div>
                <?php }else if($key == 2){ ?>
                <div class="width80">
                
                <div class="width80 third_ques_1 float_left">
                    <input type="text" name="incient[other][<?php echo $question->que_id ?>][details_there]" placeholder="details there of">
                </div> 
            </div>
                <?php }else if($key == 3){ ?>
                <div class="width80">
                    
                    <div class="width80 fourth_ques_4 ">
                        <input type="text" name="incient[other][<?php echo $question->que_id ?>][deatils]" placeholder="Deatils">
                    </div> 
                </div>
                <?php } ?>
            </div>


        </div>
        
    <?php }
     } ?>      
   </div></div>
                <div class="width2 float_left">
                    <div class="width100 form_field outer_smry">
                        <div class="label blue float_left width30">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                        <div class="width60 float_left">
                            <input type="text" name="patient[inc_ero_standard_summary]" data-value="<?php if ($inc_details['inc_ero_standard_summary'] != '') {
                    get_ero_remark($inc_details['inc_ero_standard_summary']);
                } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=CORONA"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                        </div>
                    </div>
                    <div class="width100 form_field outer_smry">
                        <div class="label blue float_left">ERO Note</div>

                        <div class="width97" id="ero_summary_other">
                            <textarea style="height:60px;" name="patient[inc_ero_summary]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                        </div>
                    </div>
                </div>-->
                <div class="width97 float_left form_field rt_side">
                    <div id="add_inc_details_block">
                        <div class="label blue">Address</div>
                        <div class="width_100">
                            <div class="address_bar float_left">
                                <input placeholder="Enter your address"  type="text" class="width_100" name="patient[address]" TABINDEX="11" data-ignore="ignore" data-state="yes" data-dist="yes" data-thl="yes" data-city="yes" data-rel="incient" data-auto="inc_auto_addr">
                            </div>
                            <div class="width33 float_left">
                                <div id="incient_state">



                                    <?php
                                    $st = array('st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                    echo get_state_tahsil($st);
                                    ?>

                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div id="incient_dist">
                                    <?php
                                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                    echo get_district_tahsil($dt);
                                    ?>
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div id="incient_tahsil">
                                    <?php
                                    $thl = array('thl_code' => '', 'dst_code' => '', 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                    echo get_tahshil($thl);
                                    ?>
                                </div>
                            </div>
                            <div class="width33 float_left">
                                <div id="incient_city">
                                    <?php
                                    if ($inc_details['inc_city'] == '' || $inc_details['inc_city'] == 0) {
                                        $city_id = '';
                                    } else {
                                        $city_id = $inc_details['inc_city'];
                                    }
                                    $city = array('cty_id' => $city_id, 'dst_code' => $district_id, 'cty_thshil_code' => $tahsil_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                    echo get_city_tahsil($city);
                                    ?>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="call_common_info ">
                    <div class="float_left width97">
                        <div class="label blue"><b>Medical Information</b></div>
                        <div class="width_16 float_left">COVID 19 test</div>
                            <div class="width_16 float_left">
                                <select  id="covid_status" name="patient[covid_status]"  <?php echo $view; ?> TABINDEX="15" onchange="covid_status_change()">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        <div class="width_16 float_left">Shatplus Medicine</div>
                            <div class="width_16 float_left">
                                <select id="Shatplus_status"  name="patient[Shatplus_status]"  <?php echo $view; ?> TABINDEX="15" onchange="shatplus_change()">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            
                        <div class="width_16 float_left">Arsenicum Medicine</div>
                            <div class="width_16 float_left">
                                <select id="Arsenicum_status"  name="patient[Arsenicum_status]"  <?php echo $view; ?> TABINDEX="15" onchange="arsenicum_change()">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                           
                            
                        </div>
                 </div>
                 <div class="call_common_info " > 
                 <div class="float_left width97" id="covide_div" style="display:none">
                        <div class="label blue">Covide Information</div><br>
                        <div class="width_16 float_left">COVID Test</div>
                        <div class="width_16 float_left">
                        <select id="covid_test" name="patient[covid_test]"  <?php echo $view; ?> TABINDEX="15">
                                    <option value="">Select</option>
                                    <option value="Positive">Positive</option>
                                    <option value="Negative">Negative</option>
                                </select>
                        </div>
                        <div class="width_16 float_left">Test Date</div>
                        <div class="width_16 float_left">
                            <input type="text" class="mi_timecalender"  name="patient[covid_test_date]"  value="" placeholder="Select Date" TABINDEX="11">
                            
                        </div>
                        <div class="width_16 float_left">Result Received Date</div>
                        <div class="width_16 float_left">
                            <input type="text" class="mi_timecalender"  name="patient[covid_tst_result_date]"  value="" placeholder="Select Date" TABINDEX="11">
                            
                        </div>
                    </div>
                    <div class="float_left width97" id="Shatplus_div" style="display:none">
                        <div class="label blue">Shatplus Information</div><br>
                        <div class="width_16 float_left">Date</div>
                        <div class="width_16 float_left">
                            <input type="text" class="mi_timecalender"  name="patient[Shatplus_date]"  value="" placeholder="Select Date" TABINDEX="11">
                            
                        </div>
                        <div class="width_16 float_left">Name</div>
                        <div class="width_16 float_left">
                            <input type="text" name="patient[Shatplus_Name]"   value="" placeholder="Enter Given by Name" TABINDEX="11">
                        </div>
                        <div class="width_16 float_left">Quantity</div>
                        <div class="width_16 float_left">
                            <input type="text" name="patient[Shatplus_Quantity]"    value="" placeholder="Enter Qyantity" TABINDEX="11">
                        </div>
                    </div>
                    <br><br>
                    <div class="float_left width97" id="Arsenicum_div" style="display:none">
                        <div class="label blue"> Arsenicum album-30 Information</div><br>
                        <div class="width_16 float_left">Date</div>
                        <div class="width_16 float_left">
                            <input type="text" class="mi_timecalender" name="patient[Arsenicum_date]" value="" placeholder="Select Date" TABINDEX="11">
                        </div>
                        <div class="width_16 float_left">Name</div>
                        <div class="width_16 float_left">
                            <input type="text" name="patient[Arsenicum_Name]"  value="" placeholder="Enter Given by Name" TABINDEX="11">
                        </div>
                        <div class="width_16 float_left">Quantity</div>
                        <div class="width_16 float_left">
                            <input type="text" name="patient[Arsenicum_Quantity]"  value="" placeholder="Enter Qyantity" TABINDEX="11">
                        </div>
                    </div>
                 </div>
                 <br>
                <div id="fwdcmp_btn" class="width100">
                    <input type="hidden" name="patient[inc_type]" id="inc_type" value="CORONA">
                    <input type="hidden" name="patient[caller_dis_timer]" id="caller_dis_timer" value="">
                    <input type="hidden" name="patient[inc_recive_time]" value="<?php echo $attend_call_time;?>">
                    <input type="hidden" name="patient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">
                    <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
                        <input type="button" name="submit" value="Save" class="btn submit_btnt form-xhttp-request" data-href='{base_url}corona/confirm_corona_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="21">
                         <?php 
  
                 if($clg_user_type == '102' || $clg_user_type == '108'){ ?>
                          <input type="button" name="submit" value="Call Transfer to HD" class="btn submit_btnt form-xhttp-request" data-href='{base_url}corona/confirm_corona_save?cl_type=transfer_hd' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&call_type=transfer_hd&cl_type=transfer_hd'  TABINDEX="27">
                       <?php } ?>
                    </div>
                
            </form>
        </div>
    </div>
</div>
