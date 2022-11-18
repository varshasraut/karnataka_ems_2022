<?php echo $focus_input;
$lat = $app_call_details[0]->lat;
$lng = $app_call_details[0]->lng;
$latlng = '';

if($lat != '' && $lng != ''){
   $latlng =  $lat.",".$lng.",250";
   
}

?>
<script>   
<?php if($latlng != ''){ ?>
    whatthreewordstoaddress('<?php echo $latlng ?>', <?php echo $lat ?>, <?php echo $lng ?>); 
<?php } ?>
</script>
<div class="call_purpose_form_outer">

    <div class="width100">
    <label class="headerlbl">Hospital To Hospital Transfer Call</label>
        <!-- <h3>Hospital To Hospital Transfer Call</h3> -->

        <div class="incident_details">

            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">

                <div class="width100 float_left">
                    <div class="map_outer_div">
                    <div class="width2 float_left interfc_left">
                        <!-- <div class="width100 float_left">

                            <div class="label blue float_left strong">Incident Time<span class="md_field">*</span></div>
                            <div class="input top_left float_left width27" >
                               
                                <input type="text" name="inter[inc_datetime]" id="inc_datetime" value="<?php echo date('Y-m-d h:i:s');?>"  placeholder="Incident Time" class=" filter_required " data-errors="{filter_required:'Incident Time should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Patient no  should not be allowed blank space.'}" TABINDEX="7" >
                            </div>
                      </div>-->
                        <div class="width100 float_left">
                            <div class="label strong">Search Address type</div>

                            <label for="inc_manual_add" class="radio_check width2 float_left">
                                <input id="inc_manual_add" type="radio" name="addtess_type" class="addtess_type radio_check_input filter_either_or[inc_google_add,inc_manual_add]" value="manual_address" data-errors="{filter_either_or:'Answer is required'}" tabindex="32" autocomplete="off">
                                <span class="radio_check_holder"></span>Manual Address
                            </label>

                            <label for="inc_google_add" class="radio_check width2 float_left" >
                                <input id="inc_google_add" type="radio" name="addtess_type" class="addtess_type radio_check_input filter_either_or[inc_google_add,inc_manual_add]" value="google_addres" data-errors="{filter_either_or:'Questions answer is required'}" tabindex="33" autocomplete="off" checked>
                                <span class="radio_check_holder"></span>Map 
                            </label>
                        </div>

                        <div class="width_30 float_left form_field pt_no">

                            <div class="label blue">Number Of Patient<span class="md_field">*</span></div>

                            <div class="input">

                                <input id="ptn_no" type="text" name="inter[inc_patient_cnt]" id="inc_patient_cnt" value="1"  placeholder="Number Of Patient*" class="small half-text filter_required filter_number filter_no_whitespace filter_rangelength[0-10]" data-errors="{filter_rangelength:'Number should be 0 to 10',filter_required:'Patient no should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Patient no should not be allowed blank space.'}" tabindex="7" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="2">

                            </div>

                        </div>
                        
                        <div class="width_30 float_left form_field pt_no">

                            <div class="label blue ">Chief Complaint<span class="md_field">*</span></div>
                            <div class="input nature" id="inter_chief_complete_outer">
                              <input type="text" name="inter[chief_complete]" id="chief_complete" data-value="<?=@$inc_details['chief_complete'];?>" value="<?=@$inc_details['chief_complete_id'];?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_chief_complete?patient_gender=<?php echo $pt_gender;?>"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="chief_complete_change" TABINDEX="8" data-base="ques_btn" <?php echo $autofocus;?>>
                            </div>
                             <div class="input nature top_left hide" id="chief_complete_other">
                              <input type="text" name="inter[chief_complete_other]" id="chief_complete_other_text"  class=""  placeholder="Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8" data-base="ques_btn" <?php echo $autofocus;?>>
                            </div>

                        </div>

                        <div class="width100 float_left form_field">

 <!--                            <div class="label blue">Patient Information</div>

                           <div class="width_16 float_left">

                                <input id="first_name"  type="text" name="patient[first_name]" class="ucfirst"  data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?php if($caller_details_data['clr_fname'] == ''){ echo "Unknown";}else{ echo $caller_details_data['clr_fname']; } ?>" placeholder="First Name" TABINDEX="8">

                            </div>

                            <div class="width_16 float_left">

                                <input id="middle_name" type="text" name="patient[middle_name]" class="ucfirst"  data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_mname']; ?>" placeholder="Middle Name" TABINDEX="9">

                            </div>

                            <div class="width_16 float_left">

                                <input  type="text" name="patient[last_name]" class="ucfirst"  data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_lname']; ?>" placeholder="Last Name" TABINDEX="10">

                            </div>

                            <div class="width_16 float_left">
                      <input id="ptn_dob" type="text" data-fname="patient[age]" name="patient[dob]" class="mi_cur_date"  data-errors="{filter_required:'DOB should not be blank',filter_number:'Age should be in numbers'}" value="<?=@$caller_details_data['patient_age'];?>" placeholder="DOB" TABINDEX="14" readonly="readonly">
                    </div>
                            <div class="width_16 float_left" id="ptn_age_outer">

                                <input id="first_age" type="text" name="patient[age]" class=""  data-errors="{filter_required:'Age should not be blank',filter_rangelength:'Age should be 0 to 100',filter_number:'Age should be in numbers',filter_no_whitespace:'Patient age should not be allowed blank space.'}" value="" placeholder="Age" TABINDEX="11">

                            </div>

                            <div class="width_16 outer_gen float_left">

                                <select id="patient_gender" name="patient[gender]" class="" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> tabindex="12">

                                    <option value="">Gender</option>

                                    <option value="M">Male</option> 

                                    <option value="F">Female</option>

                                    <option value="O">Other</option>

                                </select>

                            </div>-->

                           

                            <div class="width100 pat_cond">

                                <div class="label blue float_left width20">Patient Condition</div>

                                <div class="float_left width20">

                                    <label for="statuesque" class="chkbox_check">

                                        <input type="checkbox" name="patient[condition]" class="groupcheck  check_input" value="statuesque" data-errors="{filter_either_or:'Patient Condition should not be blank!'}" id="statuesque">

                                        <span class="chkbox_check_holder"></span>Statuesque 

                                    </label>

                                </div>

                                <div class="float_left width20">

                                    <label for="worsen" class="chkbox_check">

                                        <input type="checkbox" name="patient[condition]" class="groupcheck check_input" value="worsen" data-errors="{filter_either_or:'Patient Condition should not be blank!'}" id="worsen">

                                        <span class="chkbox_check_holder"></span>Worsen

                                    </label>

                                </div>

                                <div class="float_left width20">

                                    <label for="improved" class="chkbox_check">

                                        <input type="checkbox" name="patient[condition]" class="groupcheck check_input" value="improved" data-errors="{filter_either_or:'Patient Condition should not be blank!'}" id="improved">

                                        <span class="chkbox_check_holder"></span>Improved

                                    </label>

                                </div>

                            </div>

                            <!-- <div class="width100"> -->
                

                            <div class="width100">

                                <div class="label blue  float_left width40 ">Select Questions Language</div>

                                <div class="float_left width25">

                                    <!-- <label for="ques_<?php echo $question->que_id;?>_yes" class="chkbox_check"> -->
                                    <label for="English" class="chkbox_check">

                                        <input type="checkbox" name="fav_language" class="groupcheck  check_input"  value="English" data-errors="{filter_either_or:'Question Language should not be blank!'}" id="questiions_english">

                                        <span class="chkbox_check_holder"></span>English 

                                    </label>

                                </div>

                                <!--<div class="float_left width33">

                                    <!-- <label for="ques_<?php echo $question->que_id;?>_yes"  class="chkbox_check"> -->
                                    <!--<label for="Marathi" class="chkbox_check">
                                        <input type="checkbox" name="fav_language" class="groupcheck check_input" value="Marathi" data-errors="{filter_either_or:'Question Language should not be blank!'}" id="questiions_marathi">

                                        <span class="chkbox_check_holder"></span>Marathi

                                    </label>

                                </div>-->

                                <div class="float_left width25">

                                    <!-- <label for="ques_<?php echo $question->que_id;?>_yes"  class="chkbox_check"> -->
                                    <label for="Hindi" class="chkbox_check">
                                        <input type="checkbox" name="fav_language" class="groupcheck check_input" value="Hindi" data-errors="{filter_either_or:'Question Language should not be blank!'}" id="questiions_hindi">

                                        <span class="chkbox_check_holder"></span>Hindi

                                    </label>

                                </div>

                            </div>
                            <!-- //////////////// -->
                            <!--  -->
                        
                            <div class="width100"  id="questions_english1">

                                <div class="label blue">Questions<span class="md_field">*</span></div>

                                <?php if ($questions) {

                                    foreach ($questions as $question) {

                                        ?>

                                        <div class="width97 questions_row" id="ques_<?php echo $question->que_id; ?>">
<!-- 
                                            <div class="width70 float_left"><?php echo $question->que_question; ?></div> -->


                                            <div class="width70 float_left questions_english" id="questions_english"><?php echo $question->que_question; ?></div>

                                            <div class="width70 float_left questions_marathi" id="questions_marathi"><?php echo $question->que_question_marathi; ?></div>

                                            <div class="width70 float_left questions_hindi" id="questions_hindi"><?php echo $question->que_question_hindi; ?></div>


                                            <div class="width_30 float_right">

                                                <label for="ques_<?php echo $question->que_id; ?>_yes" class="radio_check width2 float_left">

                                                    <input id="ques_<?php echo $question->que_id; ?>_yes" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id; ?>_yes,ques_<?php echo $question->que_id; ?>_no]" value="Y" data-base="ques_btn" data-errors="{filter_either_or:'Answer is required'}">

                                                    <span class="radio_check_holder"></span>Yes

                                                </label>

                                                <label for="ques_<?php echo $question->que_id; ?>_no" class="radio_check width2 float_left">

                                                    <input id="ques_<?php echo $question->que_id; ?>_no" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id; ?>_yes,ques_<?php echo $question->que_id; ?>_no]" value="N" data-base="ques_btn" data-errors="{filter_either_or:'Answer is required'}">

                                                    <span class="radio_check_holder"></span>No

                                                </label>

                                            </div>   

                                        </div>

    <?php }

} ?>

                                    <input type="hidden" name="incient[chief_complete]" id="chief_complaint_id" value="1000" data-base="ques_btns">

                                    <input name="ques_btn" id="get_ques_ans_details" value="SEARCH" style="visibility: hidden;" class="style3 base-xhttp-request" data-href="{base_url}inc/get_ambu_type" data-qr="output_position=inc_details" type="button">

                            </div>
                            <div class="float_left width100">
                                <div class="label blue width100">ERO Note</div>

                                <div class="width100" id="ero_summary_other">
                                    <textarea style="height:60px;" name="inter[inc_ero_summary]" id="inter[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                                </div>
                            </div>

                            
                            <div class="width100 float_left" id="inc_recomended_ambu">

                            </div>
                            <div class="width100" style="display:table;"> 
                        <div class="form_field float_left"  style="width: 50%;">
                           <div class="label blue float_left">Enter Three Word :</div>
                            <div class="input top_left float_left width2" style="display: flex;">
                            <a title="What Three Word SMS" class="three_word click-xhttp-request" data-href="{base_url}calls/three_word_popup" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                            <input id="three_word" type="text" name="inter[3word]"  placeholder="Enter Three Word " class="change-xhttp-request"  TABINDEX="7">
                            </div>

                        </div>
                        <div class="form_field float_left"  style="width: 50%;" id="validation_result">
                           

                        </div>
                      
                    </div>

                        </div>

                    </div>

                    <div class="width2 float_right form_field outer_fc_details">

                        <div class="label blue">Facility Details</div>

                        <div id="width100 current_fc">
                            
                            <div class="float_left width_25">

                                <div class="label">Current District<span class="md_field">*</span>&nbsp;</div>


                                <input  name="inter[current_district]" tabindex="9" class="form_input filter_required mi_autocomplete" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="Current District" type="text" data-nonedit="yes" data-errors="{filter_required:'Please select current District from dropdown list'}" data-callback-funct="district_wise_hospital" id="current_district_id">


                            </div>

                            <div class="float_left width_25">

                                <div class="label">Current Facility</div>

                                <div class="input" id="current_facility_box">

                                    <input name="inter[facility]" class="mi_autocomplete filter_required width100" placeholder="Current Facility" data-href="{base_url}auto/get_auto_hospital_new" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Current Facility should not be blank'}" data-callback-funct="facility_details" id="current_facility" TABINDEX="13">

                                </div>

                            </div>

                            <div class="float_left width_25">

                                <!-- <div class="label">Reporting Doctor</div> -->
                                <div class="label">Reporting Doctor<span class="md_field"></span></div>
                                <div class="input">

                                    <input id="caller_no" type="text" name="inter[rpt_doc]" value=""  placeholder="Reporting Doctor" class="small" style="padding: 6px;" data-errors="{filter_required:'Reporting Doctor should not be blank', filter_word:'Invalid input at Reporting Doctor name. Numbers and special characters not allowed.'}" TABINDEX="14">

                                </div>

                            </div>

                            <div class="float_left width_25">

                                <div class="label">Mobile Number</div>

                                <div class="input">
                                <!-- <input id="caller_no" type="text" name="inter[mo_no]" value=""  placeholder="Mobile Number" class=" " data-errors=""  TABINDEX="15" > -->
                                    <input id="caller_no" type="text" name="inter[mo_no]" value=""  placeholder="Mobile Number" class=" " data-errors="{filter_number:'Mobile number should be in numeric only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_no_whitespace:'Mobile number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')"  TABINDEX="15" maxlength="10">

                                </div>

                            </div>

                            <input class="add_button_hp click-xhttp-request float_right" id="add_button_hp" name="add_hp" value="Add" data-href="{base_url}hp/add_hp" data-qr="output_position=popup_div&amp;filter_search=search&amp;tool_code=add_hosp&amp;req=ero" type="button" data-popupwidth="1000" data-popupheight="800" style="display:none;">

                        </div>

                        <div id="facility_details">



                        </div>

                        <div class="width100 float_right form_field new_fc">

                            <div class="float_left width_25">

                                <div class="label">New District<span class="md_field">*</span>&nbsp;</div>


                                <input  name="inter[new_district]" tabindex="9" class="form_input mi_autocomplete filter_required" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="New District" type="text" data-nonedit="yes" data-errors="{filter_required:'Please select New District from dropdown list'}" data-callback-funct="district_wise_hospital_new" >


                            </div>
                            <div class="float_left width_25">

                                <div class="label">New Facility</div>

                                <div class="input" id="new_facility_box">

                                    <input name="inter[new_facility]" class="mi_autocomplete width100 filter_required" placeholder="New Facility"  data-href="{base_url}auto/get_auto_hospital_new" type="text" data-errors="{filter_required:'Please select new facility from dropdown list',filter_greater_than_zero:'New Facility should not be blank'}" data-callback-funct="facility_new_details" TABINDEX="16">

                                </div>

                            </div>

                            <div class="float_left width_25">

                                <div class="label">Reporting Doctor<span class="md_field"></span></div>

                                <div class="input">

                                    <input id="caller_no" type="text" name="inter[new_rpt_doc]" value=""  placeholder="Reporting Doctor" class="small" data-errors="{filter_required:'Reporting Doctor should not be blank', filter_word:'Invalid input at Reporting Doctor name. Numbers and special characters not allowed.'}" TABINDEX="17" style="padding: 6px;">

                                </div>

                            </div>

                            <div class="float_left width_25">

                                <div class="label">Mobile Number</div>

                                <div class="input">

                                    <!-- <input id="caller_no" type="text" name="inter[new_mo_no]" value=""  placeholder="Mobile Number" class=" " data-errors="" TABINDEX="18"> -->
                                    <input id="caller_no" type="text" name="inter[mo_no]" value=""  placeholder="Mobile Number" class="" data-errors="{filter_number:'Mobile number should be in numeric only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_no_whitespace:'Mobile number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}"  TABINDEX="15" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="10">
                                </div>

                            </div> 

                            <input class="add_button_hp click-xhttp-request float_right" id="add_button_hp_new" name="add_hp" value="Add" data-href="{base_url}hp/add_hp" data-qr="output_position=popup_div&amp;filter_search=search&amp;tool_code=add_hosp&amp;req=ero&amp;fc=new" type="button" data-popupwidth="1000" data-popupheight="800" style="display:none;">

                        </div>

                        <div id="new_facility_details">

                        </div>
                        


                        <div id="add_inc_details_block inc_add">

                          

                            <div class="width_100">

                                <div class="label blue width100">Hospital Address</div>

                                <div class="width33 float_left">
                           <div id="incient_state1">
                    <?php
                    if($inc_details['state_id'] == ''){
                        $state = 'MP';
                    }else {
                        $state = $inc_details['state_id'];
                    }
               

                    $st = array('st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');
                    
                    //echo get_state_tahsil($st);

                    ?>
                    <input name="incient_state" value="MP"  class=" width97 filter_required"  style="display: none;">

                    </div>
                    </div>
<!--					<div class="width33 float_left">
                        <div id="incient_div">
                            <?php
                           
                            $dt = array('auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '','div_code' => '');
                            echo get_division_tahsil($dt);
                            ?>
                        </div>
                    </div>-->
                    <div class="width33 float_left">
                        <div id="incient_dist">
                            <?php
                            if($inc_details['district_id'] == '' || $inc_details['district_id'] == 0){
                                 $district_id = '';
                            }else {
                                $district_id = $inc_details['district_id'];
                            }
                            
                            $dt = array('dst_code' => $district_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_district_tahsil($dt);
                            ?>
                        </div>
                    </div>
                    <div class="width33 float_left">
                        <div id="incient_tahsil">
                            <?php
                            if($inc_details['tahsil_id'] == '' || $inc_details['tahsil_id'] == 0){
                                 $tahsil_id = '';
                            }else {
                                $tahsil_id = $inc_details['tahsil_id'];
                            }
                            $thl = array('thl_id' =>$tahsil_id, 'dst_code' => $district_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_tahshil($thl);
                            ?>
                        </div>
                    </div>
                    <div class="width33 float_left">
                           <div id="incient_city">
                            <?php
                           // var_dump($inc_details);
                            if($inc_details['inc_city_id'] == '' || $inc_details['inc_city_id'] == 0){
                                 $city_id = '';
                            }else {
                                $city_id = $inc_details['inc_city_id'];
                            }
                            $city = array('cty_id' =>$city_id, 'dst_code' => $district_id,'cty_thshil_code' => $tahsil_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_city_tahsil($city);
                            ?>
                        </div>

                    </div>
                    <div class="width33 float_left" id="incient_area">
                        <input type="text" name="incient[area]" TABINDEX="73" value="<?=@$inc_details['area'];?>" class=" stauto" data-errors="{filter_required:'Area/Location is required'}" placeholder="Area/Location" data-auto="" id="area_location">
                    </div>
                    <div class="width33 float_left">
                        <input type="text" name="incient[landmark]" TABINDEX="74" value="<?=@$inc_details['landmark'];?>" class="  stauto" data-errors="{filter_required:'Landmark required'}" placeholder="Landmark" id="street_number">
                    </div>


                            </div>

                            <div class="width_100">



                                <!--<div class="width33 float_left">

                                    <input type="text" name="inter[h_no]" TABINDEX="27" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="House Number" data-auto="">

                                </div>

                                <div class="width33 float_left">

                                    <input type="text" name="inter[pincode]" TABINDEX="28" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="PinCode" data-auto="" id="postal_code">

                                </div>-->

                                <div class="width33 float_left">

                                    <input type="hidden" name="inter[google_location]" TABINDEX="29" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="google location map address" data-auto="" id="google_formated_add">

                                </div>

                            </div>

                        </div>
<!--                        <div class="width100 form_field inthp_sumry">

                            <div class="label blue">ERO Summary</div>

                            <textarea name="inter[inc_ero_summary]" class="width100" TABINDEX="19" data-maxlen="400"></textarea>
                            <br>
                            <br> <br>

                        </div>-->
<!--                        <div class="width100 form_field outer_smry">
                            <div class="label width20 blue float_left">Select Hospital<span class="md_field"></span>&nbsp;&nbsp;&nbsp;</div>
                            <div class="width80 float_left" id="inc_temp_hospital">
                                 <input  name="incient[hospital_id]" class="mi_autocomplete width100" placeholder="Name of Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Hospital should not be blank'}" id="host" TABINDEX="13" data-callback-funct="hospital_avaibility">
                            </div>
                            <div  id="hospital_details">
                            </div>
                        </div>-->
                        <div class="width100 form_field outer_smry">
                            
                                <div class="label width20 blue float_left">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                                <div class="width80 float_left">
                                    <input type="text" name="inter[inc_ero_standard_summary]" data-value="<?= @$inc_details['inc_ero_standard_summary']; ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=IN_HO_P_TR"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                                </div>
                            
                            <br>
                        </div>
                    </div>

                 </div>

                   <?php if($agent_mobile == 'yes'){?>

                         <div class="address_bar interfc">

                                 <input id="inc_map_address" placeholder="Enter your address"  type="text" class="width_100 filter_required" data-errors="{filter_required:'Address Should not blank'}" style="border-radius:0px !important; width:100% !important; border:7px solid #4688f1; margin-bottom: 0px;" name="incient[place]" TABINDEX="20" data-ignore="ignore" data-state="yes" data-thl="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr">

                    </div>
                    <div class="col-md-6" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>

                   <?php } ?>

               

                    

                    <div class="width_100 map_block_outer" id="map_block_outer" style="clear:both;">

                        <!--                         <div class="map_inc_button"><div class="bullet">INCIDENT ADDRESS</div></div>-->
                                                <div class="float_right extend_map_block">

                                                            <a class="btn extend_map" href="#" onclick="open_extend_map('{base_url}inc/extend_map');return false;" data-qr="module_name=inc" name="ques_btn">Extend Map</a>

                                                     </div>

                        <div class="width_15 float_right min_distance_block">

<!--                            <input name="inc_min_distance" class="width30 form_input mi_autocomplete" data-href="{base_url}auto/get_distance" type="text" tabindex="81" placeholder="Radius in KM" data-base="ques_btn" data-callback-funct="get_amb_by_distance" data-autocom="yes">-->

                            <select name="inc_min_distance" id="inc_min_distance" onchange="get_amb_by_distance();">

                                <option>defult value</option>

                                <option value="1">1 KM</option>

                                <option value="2">2 KM</option>

                                <option value="5">5 KM</option>

                                <option value="10">10 KM</option>

                                <option value="15">15 KM</option>

                                <option value="20"> 20 KM</option>

                            </select>

                        </div>

                        

                        <div class="map_box_inner float_left" id="INCIDENT_MAP">

                        </div>

                        <div class="ambulance_box float_left">

                                <?php if($agent_mobile == 'no'){?>

                        <div class="address_bar interfc">

                                 <input id="inc_map_address" placeholder="Enter your address"  type="text" class="width_100 filter_required" data-errors="{filter_required:'Address Should not blank'}" style="border-radius:0px !important; width:100% !important; border: 1px solid #ccc;" name="incient[place]" TABINDEX="20" data-ignore="ignore" data-state="yes" data-thl="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr">

                    </div>
                    <div class="col-md-6" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>

                   <?php } ?>
                            <a class="click-xhttp-request" style="display: none;" data-href="{base_url}inc/get_inc_ambu?lat=&lng" data-qr="module_name=inc" id="get_ambu_details">get_ambu</a>

                            <div id="inc_map_details"></div>

                        </div>

                    </div>
                    <div class="width100">
                   <div id="previous_incident_details">
                        
                    </div>
                </div>
                <div class="width100">
                     <div id="photo_notification">
                         
                     </div>
                </div>
                    <div class="width2 form_field float_left dub_inc">
                        <div class="width33 float_left">
                            <div class="label">Duplicate Incident</div>
                            <label for="inc_dup_no" class="radio_check width2 float_left">
                                <input id="inc_dup_no" type="radio" name="incient[dup_inc]" class="radio_check_input filter_either_or[inc_dup_no,inc_dup_yes]" value="No" data-errors="{filter_either_or:'Questions answer is required'}" checked="checked" TABINDEX="79">
                                <span class="radio_check_holder" ></span>No
                            </label>
                            <label for="inc_dup_yes" class="radio_check width2 float_left">
                                <input id="inc_dup_yes" type="radio" name="incient[dup_inc]" class="radio_check_input filter_either_or[inc_dup_no,inc_dup_yes]" value="Yes" data-errors="{filter_either_or:'Questions answer is required'}" TABINDEX="80">
                                <span class="radio_check_holder" ></span>Yes
                            </label>
                            <input name="ques_btn" value="SEARCH" class="base-xhttp-request" data-href="{base_url}inc/previous_incident?lat=&lng=" data-qr="output_position=previous_incident_details&inc_type=IN_HO_P_TR" type="button" id="get_previous_inc_details" style="visibility: hidden; height: 0px;">
                        </div>
                        <div class="width60 float_left">
                            <div class="label">Around Incident( In KM)</div>
                            <input name="inc_distance" class="width30 form_input mi_autocomplete previous_inc_btn" data-href="{base_url}auto/get_distance" type="text" tabindex="81" placeholder="Distance in KM" data-base="ques_btn" data-callback-funct="get_previous_incident" data-autocom="yes">
                        </div>
                    </div>


                    <div class="width100">

                        <div id="SelectedAmbulance">



                        </div>

                        <input type="hidden" name="inter[lat]" id="lat" value="">
                        <input type="hidden" name="inter[lng]" id="lng" value="">
<!--                        <input type="hidden" name="inter[amb_id]" id="amb_id" value="">-->
                        <input type="hidden" name="inter[base_month]"  value="<?php echo $cl_base_month; ?>">
                        <input type="hidden" name="inter[inc_type]" id="inc_type" value="IN_HO_P_TR">
                        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
                        <input type="hidden" name="inter[caller_dis_timer]" id="caller_dis_timer" value="">
                        <input type="hidden" name="inter[inc_recive_time]" value="<?php echo $attend_call_time;?>">
                        <input type="hidden" name="incient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">
                        <div id="patient_hidden_div">
                        <input type="hidden" name="patient[full_name]" value="<?php echo $common_data_form['full_name'];?>">
                        <input type="hidden" name="patient[first_name]" value="<?php echo $common_data_form['first_name'];?>">
                        <input type="hidden" name="patient[middle_name]" value="<?php echo $common_data_form['middle_name'];?>">
                        <input type="hidden" name="patient[last_name]" value="<?php echo $common_data_form['last_name'];?>">
                        <input type="hidden" name="patient[dob]" value="<?php echo $common_data_form['dob'];?>">
                        <input type="hidden" name="patient[age]" value="<?php echo $common_data_form['age'];?>">
                        <input type="hidden" name="patient[age_type]" value="<?php echo $common_data_form['age_type'];?>">
                        <input type="hidden" name="patient[gender]" value="<?php echo $common_data_form['gender'];?>">
                        </div>
<!--                        <input type="hidden" name="inter[inc_ero_standard_summary]" value="<?php echo $common_data_form['inc_ero_standard_summary'];?>">
                        <input type="hidden" name="inter[inc_ero_summary]" value="<?php echo $common_data_form['inc_ero_summary'];?>">-->



                        <!--<div id="fwdcmp_btn">

                                                    <input type="button" name="submit" value="DISPATCH" TABINDEX="30" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/save_inter' data-qr='output_position=content'>

                                                    <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/save_inc?cl_type=forword" data-qr="output_position=content" tabindex="31" type="button"></div>-->



                        <div id="fwdcmp_btn" class="save_btn_wrapper">
                        

                            <input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_inter_hos_save' data-qr='output_position=content&amp;module_name=inc&amp'  TABINDEX="27">

                            <input type="button" name="submit" value="Termination Call" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_inter_hos_terminate' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">
                            <input type="button" name="submit" value="Ambulance Not Available" class="btn hheadbg submit_btnt form-xhttp-request" data-href='{base_url}inc/app_inter_hos_confirm_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">
                         <?php // if($clg_user_type == '108'){ ?>
                          <!--<input type="button" name="submit" value="Call Transfer to 102" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_inter_hos_save?cl_type=transfer_102' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&call_type=transfer_102&cl_type=transfer_102'  TABINDEX="27">-->
                       <?php // }else if($clg_user_type == '102'){ ?>
                           <!--<input type="button" name="submit" value="Call Transfer to 108" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_inter_hos_save?cl_type=transfer_108' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=transfer_108&cl_type=transfer_108'  TABINDEX="27">-->
                          <?php //} ?>
      <!--                      <input value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save" output_position="content" tabindex="20" type="button">-->

<!--                            <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_inter_hos_save?cl_type=forword" data-qr="output_position=content" tabindex="28" type="button"></div>-->


<br>
<br>
                    </div>

                </div>  





            </form>

        </div>

    </div>

</div>
</div>
<style>
    body{
        font-size: 14px !important;
    }
</style>
<script type="text/javascript">

    var $incMapMarker,$incMarkerGroup = null;
    initIncidentMap();

//  get_tahshil_ambulance();  

    function facility_details(ft) {



        if (ft['id'] == 0) {

          //  $("#add_button_hp").click();

        } else {



            // xhttprequest($(this), base_url + 'inc/get_facility_details', 'hp_id=' + ft['id']);
            xhttprequest($(this), base_url + 'inc/get_facility_details_new', 'hp_id=' + ft['id']);
            

        }



    }

    function facility_new_details(ft) {

        if (ft['id'] == 0) {

           // $("#add_button_hp_new").click();

        } else {

            // xhttprequest($(this), base_url + 'inc/get_facility_details?facility=new', 'hp_id=' + ft['id']);
            xhttprequest($(this), base_url + 'inc/get_facility_details_new?facility=new', 'hp_id=' + ft['id']);
            xhttprequest($(this), base_url + 'inc/show_selected_hospital', 'hp_id=' + ft['id']);

        }

    }

</script>

<script >
$(document).ready(function () {
   $('.questions_marathi').hide();
       $('.questions_english').hide();
       $('.questions_hindi').show();
       $('#questions_english1').show();
    


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