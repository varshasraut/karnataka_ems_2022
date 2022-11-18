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
        <label class="headerlbl">VIP Call</label>
        <div class="incident_details">
            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">
                <div class="width2 float_left lf_side">
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
                    <div class="width100" style="display:table;"> 
                        <div class="form_field"  style="display:table-cell; width: 35%;">
                            <div class="label blue float_left">Number Of Patient<span class="md_field">*</span></div>
                            <div class="input top_left float_left width27 ml-2" s>
                                <?php 
                                if(empty($int_count)){
                                    $int_count = 1;
                                }
                                ?>
                                <input id="ptn_no" type="text" name="incient[inc_patient_cnt]" value="<?=@$int_count;?>"  placeholder="Number Of Patient*" class="change-xhttp-request small half-text filter_required filter_no_whitespace filter_number  filter_rangelength[0-10]" data-errors="{filter_rangelength:'Number should be 0 to 10',filter_required:'Patient no should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Patient no  should not be allowed blank space.'}" TABINDEX="7"  data-href="{base_url}inc/change_view" data-qr="output_position=content&amp;call_type=nonmci" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="2">
                            </div>

                        </div>
                        <div class="form_field mt-1" style="display:table-cell; width: 65%;">
                            <div class="label blue float_left width30">Chief Complaint<span class="md_field">*</span></div>
                            <div class="input nature top_left float_left width_66" id="chief_complete_outer">
                              <input type="text" name="incient[chief_complete]" id="chief_complete" data-value="<?=@$inc_details['chief_complete'];?>" value="<?=@$inc_details['chief_complete_id'];?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_chief_complete"  placeholder="Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="chief_complete_change" TABINDEX="8" data-base="ques_btn" <?php echo $autofocus;?>>
                            </div>
                             <div class="input nature top_left hide" id="chief_complete_other">
                              <input type="text" name="incient[chief_complete_other]" id="chief_complete_other_text"  class=""  placeholder="Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" TABINDEX="8" data-base="ques_btn" <?php echo $autofocus;?>>
                            </div>
                        </div>
                    </div>
                    <div id="inc_services_details" class="width97">  
<!--                        <div class="width100 float_left">

                            <?php if($services){
                            foreach ($services as $key=>$service) { ?>
                                <div class="width_20 float_left">
                                    <label for="service_<?php echo $service->srv_id; ?>" class="chkbox_check">
                                            <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" class="check_input unit_checkbox" value="<?php echo $service->srv_id; ?>"  id="service_<?php echo $service->srv_id; ?>" <?php if($service->srv_name == 'Medical'){ echo "checked";} ?>>
                                            <span class="chkbox_check_holder"></span><?php echo $service->srv_name; ?>
                                     </label>
                           
                                    <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" TABINDEX="<?php echo $key+9;?>">
                                        <?php //echo $service->srv_name; ?>
                                </div>
                            <?php } }
                            ?>
                        </div>-->
                        <div class="width97 form_field questions_row ">
                            <div class="label blue">Questions <span class="md_field">*</span></div>
                            <?php if($questions){
                            foreach ($questions as $key=>$question) { ?>
                                <div class="width97 questions_row">
                                    <div class="width75 float_left"><?php echo $question->que_question; ?></div>
                                    <div class="width_15 float_right">
                                        <input type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="" value="yes" TABINDEX="10.<?php echo $key;?>">Yes
                                        <input type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="" value="no" TABINDEX="10<?php echo $key;?>">no
                                    </div>   
                                </div>
                            <?php } } ?>

                        </div>
                    </div>
<!--                     <div class="float_left width97">
                        <div class="label blue"><b>Patient Information</b></div><?php //var_dump($caller_details_data); ?>
                         <div class="width75 float_left">
                        <input id="first_name"  type="text" name="patient[full_name]" class="filter_required ucfirst"  data-errors="{filter_required:'Patient name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?=@$caller_details_data['clr_full_name'];?>" placeholder="Patient Full Name" TABINDEX="11">
                    </div>
                    <div class="width_16 float_left">
                        <input id="ptn_first_name"  type="text" name="patient[first_name]" class="filter_required ucfirst"  data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?php if($caller_details_data['clr_fname'] == ''){ echo 'Unknown';}else{ echo $caller_details_data['clr_fname']; }?>" placeholder="First Name" TABINDEX="11">
                    </div>
                    <div class="width_16 float_left">
                        <input id="ptn_middle_name" type="text" name="patient[middle_name]" class="ucfirst"  data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?=@$caller_details_data['clr_mname'];?>" placeholder="Middle Name" TABINDEX="12">
                    </div>
                    <div class="width_16 float_left">
                        <input id="ptn_last_name"  type="text" name="patient[last_name]" class="ucfirst"  data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?=@$caller_details_data['clr_lname'];?>" placeholder="Last Name" TABINDEX="13">
                    </div>
                  <div class="width_16 float_left">
                      <input id="ptn_dob" data-fname="patient[age]" type="text" name="patient[dob]" class="mi_cur_date"  data-errors="{filter_required:'DOB should not be blank',filter_number:'Age should be in numbers'}" value="<?=@$caller_details_data['patient_age'];?>" placeholder="DOB" TABINDEX="14" readonly="readonly">
                    </div>
                    <div class="width_16 float_left" id="ptn_age_outer">
                            <input id="ptn_age" type="text" name="patient[age]" class=" filter_rangelength[0-100]"  data-errors="{filter_required:'Age should not be blank',filter_rangelength:'Age should be 0 to 100',filter_number:'Age should be in numbers'}" value="<?=@$caller_details_data['patient_age'];?>" placeholder="Age" TABINDEX="14">
                        </div>
                    <div class="width_16 float_left" id="non_mci_patient_gender">
                            <select id="patient_gender" name="patient[gender]" class="" <?php echo $view; ?> TABINDEX="15">
                                <option value="">Gender</option>
                                <option value="M" <?php if($caller_details_data['patient_gender'] == 'Male' || $caller_details_data['patient_gender'] == 'M'){ echo "selected"; }?>>Male</option> 
                                <option value="F" <?php if($caller_details_data['patient_gender'] == 'Female' || $caller_details_data['patient_gender'] == 'F'){ echo "selected"; }?>>Female</option>
                                <option value="O" <?php if($caller_details_data['patient_gender'] == 'Other' || $caller_details_data['patient_gender'] == 'O'){ echo "selected"; }?>>Other</option>
                            </select>
                        </div>
                    
                    </div>-->
<!--                    <div class="width100 float_left">
                        <div class="label">Search Address type</div>
                         <label for="inc_google_add" class="radio_check width2 float_left" >
                            <input id="inc_google_add" type="radio" name="addtess_type" class="addtess_type radio_check_input filter_either_or[inc_google_add,inc_manual_add]" value="google_addres" data-errors="{filter_either_or:'Questions answer is required'}" tabindex="33" autocomplete="off" checked="checked" >
                            <span class="radio_check_holder"></span>Map 
                        </label>
                        <label for="inc_manual_add" class="radio_check width2 float_left">
                            <input id="inc_manual_add" type="radio" name="addtess_type" class="addtess_type radio_check_input filter_either_or[inc_google_add,inc_manual_add]" value="manual_address" data-errors="{filter_either_or:'Answer is required'}" tabindex="32" autocomplete="off">
                            <span class="radio_check_holder"></span>Manual Address
                        </label>
                    
                    </div>
                    <div id="cluster_view" class="width100 float_left" >

                    </div>-->
                    <div class="width100 float_left" id="inc_recomended_ambu">
                        
                    </div>
                    <div class="width100" style="display:table;"> 
                        <div class="form_field float_left"  style="width: 50%;">
                           <div class="label blue float_left">Enter Three Word :</div>
                            <div class="input top_left float_left width2" style="display: flex;">
                            <a title="What Three Word SMS" class="three_word click-xhttp-request" data-href="{base_url}calls/three_word_popup" data-qr="mobile_no=<?php echo $m_no; ?>"></a>

                            <input id="three_word" type="text" name="incient[3word]"  placeholder="Enter Three Word " class="change-xhttp-request"  TABINDEX="7">
                            </div>

                        </div>
                        <div class="form_field float_left"  style="width: 50%;" id="validation_result">
                           

                        </div>
                      
                    </div>
                </div>
                <div class="width2 float_left form_field rt_side">
                    <div class="label blue">Incident Address</div>
                                    <div id="add_inc_details_block">
                                    <div class="width_100">
                    <div class="width33 float_left">
                           <div id="incient_state1">



                    <?php
                    if($inc_details['state_id'] == ''){
                        $state = 'MP';
                    }else {
                        $state = $inc_details['state_id'];
                    }
                   // $state = 'MH';

                    $st = array('st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                    //echo get_state_tahsil($st);
                    ?><input name="incient_state" value="MP"  class=" width97 filter_required"  style="display: none;">
<!--                                 <input type="text" name="incient[state]" TABINDEX="70" value="Madhya Pradesh" class="" data-errors="{filter_required:'State is required'}" placeholder="State" id="inc_state" style="margin-bottom: 5px;">
                               <input name="incient_state" value="MH" class=" width97 filter_required" data-href="http://mulikas4/bvg/auto/get_state" placeholder="State" data-errors="{filter_required:'Please select state from dropdown list'}" data-base="" data-value="Madhya Pradesh" data-auto="inc_auto_addr" data-callback-funct="load_auto_dist_tahsil" data-rel="incient" tabindex="15" autocomplete="off" style="display: none;">-->

                    </div>
                    </div>
<!--                    <div class="width33 float_left">
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
                            if($inc_details['inc_city_id'] == '' || $inc_details['inc_city_id'] == 0){
                                 $city_id = '';
                            }else {
                                $city_id = $inc_details['inc_city_id'];
                            }
                            $city = array('cty_id' =>$city_id, 'dst_code' => $district_id,'cty_thshil_code' => $tahsil_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_city_tahsil($city);
                            ?>
                        </div>
<!--                        <input type="text" name="incient[inc_city]" TABINDEX="72" value="<?=@$inc_details['inc_city'];?>" class=" width100 stauto" data-errors="{filter_required:'City/Vilage/Town is required'}" placeholder="City/Vilage/Town" data-auto="" id="inc_city">-->
                    </div>
                    <div class="width33 float_left">
                        <input type="text" name="incient[area]" TABINDEX="73" value="<?=@$inc_details['area'];?>" class=" stauto" data-errors="{filter_required:'Area/Location is required'}" placeholder="Area/Location" data-auto="" id="area_location">
                    </div>
                    <div class="width33 float_left">
                        <input type="text" name="incient[landmark]" TABINDEX="74" value="<?=@$inc_details['landmark'];?>" class="  stauto" data-errors="{filter_required:'Landmark required'}" placeholder="Landmark" id="street_number">
                    </div>
                    <!--<div class="width33 float_left">
                        <input type="text" name="incient[lane]" TABINDEX="75" value="<?=@$inc_details['lane'];?>" class="  stauto" data-errors="{filter_required:'Lane/Street is required'}" placeholder="Lane Street"  id="route">
                    </div>-->

                </div>
                <div class="width_100">

                    <!--<div class="width33 float_left">
                        <input type="text" name="incient[h_no]" TABINDEX="76" value="<?=@$inc_details['h_no'];?>" class="  stauto" data-errors="{filter_required:'House no is required'}" placeholder="House Number" data-auto="">
                    </div>
                    <div class="width33 float_left">
                        <input type="text" name="incient[pincode]" TABINDEX="77" value="<?=@$inc_details['pincode'];?>" class=" stauto" data-errors="{filter_required:'Pincode is required'}" placeholder="PinCode" data-auto="" id="postal_code">
                    </div>-->
                    <div class="width33 float_left">
                        <input type="hidden" name="incient[google_location]" TABINDEX="78" value="" class=" width97 stauto" data-errors="{filter_required:'Google location is required'}" placeholder="google location map address" data-auto="" id="google_formated_add" style="width: 98%;">
                    </div>
                </div>
                </div>
                <div class="width100 form_field outer_smry">
                    <div class="width50 form_field float_left" >
                    
                        <div class="label blue width20 float_left">Hospital Priority<span class="md_field">*</span>&nbsp;&nbsp;&nbsp;</div>
                        <div class="width80 float_left" style="padding-left: 4px;">
                            <select name="priority_change" class="filter_required" data-errors="{filter_required:'Please Hospital Priority from dropdown list'}" id="hospital_prio_dropdown">
                                <option value="priority_one">Priority One Hospital</option>
                                <option value="priority_two">Priority Two Hospital</option>
                            </select>
                             
                        </div>
                        
                    </div>
                           <div class="width50 form_field float_left" id="hospital_one">
                    
                        <div class="label blue width20 float_left">Hospital1<span class="md_field"></span>&nbsp;&nbsp;&nbsp;</div>
                        <div class="width80 float_left" id="inc_one_temp_hospital">
                             <!-- <input  name="incient[hospital_id]" class="mi_autocomplete width100 filter_either_or[host_one,host_two]" placeholder="Priority one Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Hospital should not be blank',filter_either_or:'hospital should not be blank.'}" id="host_one" TABINDEX="13" data-callback-funct="hospital_avaibility" data-value="<?php echo $inc_details['destination_hp_name']; ?>" value="<?=@$inc_details['destination_hospital_id']; ?>"> -->
                             <input  name="incient[hospital_id]" class="mi_autocomplete width100 filter_either_or[host_one,host_two]" placeholder="Priority one Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Hospital should not be blank',filter_either_or:'hospital should not be blank.'}" id="host_one" TABINDEX="13" data-callback-funct="hospital_avaibility_new" data-value="<?php echo $inc_details['destination_hp_name']; ?>" value="<?=@$inc_details['destination_hospital_id']; ?>">
                        </div>
                        <div  id="hospital_details">
                        </div>
                    </div>
                <div class="width50 form_field float_left hide" id="hospital_two" >
                    
                        <div class="label blue width20 float_left">Hospital2<span class="md_field"></span>&nbsp;&nbsp;&nbsp;</div>
                        <div class="width80 float_left" id="inc_two_temp_hospital">
                             <!-- <input  name="incient[hospital_id]" class="mi_autocomplete width100 filter_either_or[host_one,host_two]" placeholder="Priority two Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Priority two Hospital should not be blank',filter_either_or:'hospital should not be blank.'}" id="host_two" TABINDEX="13" data-callback-funct="hospital_avaibility_two" data-value="<?php echo $inc_details['destination_hp_name']; ?>" value="<?=@$inc_details['destination_hospital_id']; ?>"> -->
                             <input  name="incient[hospital_id]" class="mi_autocomplete width100 filter_either_or[host_one,host_two]" placeholder="Priority two Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Priority two Hospital should not be blank',filter_either_or:'hospital should not be blank.'}" id="host_two" TABINDEX="13" data-callback-funct="hospital_avaibility_two_new" data-value="<?php echo $inc_details['destination_hp_name']; ?>" value="<?=@$inc_details['destination_hospital_id']; ?>">
                        </div>
                        <div  id="hospital_details_two">
                        </div>
                    </div>
                    </div>
                    <div class="width100 form_field outer_smry">
                        <div class="label width20 blue float_left">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                          <div class="width80 float_left">
                         <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['inc_ero_standard_summary_id']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=VIP_CALL"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                          </div>
<!--                         <div class="width100" id="ero_summary_other">
                        <textarea name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="800"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?=@$inc_details['inc_ero_summary'];?></textarea>
                        </div>-->
                    </div>
                    <div class="width100 form_field outer_smry">
                        <div class="label blue float_left">ERO Note</div>
      
                         <div class="width100" id="ero_summary_other">
                             <textarea style="height:60px;" name="incient[inc_ero_summary]" class="width_100 " TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?=@$inc_details['inc_ero_summary'];?></textarea>
                        </div>
                    </div>


                </div>
                    <?php if($agent_mobile == 'yes'){?>
                             <div class="address_bar">
                                 <input id="inc_map_address" placeholder="Enter your address" type="text" class="width_100 filter_required" data-errors="{filter_required:'Address Should not blank'}"  style="border-radius:0px !important; width:100% !important; border: 1px solid #ccc; margin-bottom: 0px;" name="incient[place]" TABINDEX="17" data-ignore="ignore" data-state="yes" data-city="yes" data-thl="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr" value="<?=@$inc_details['inc_address'];?>">
                        </div>
                        <div class="col-md-6" id="search_amb" style="display:none">
<!--                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">-->
                            <div class="col-md-12" style="height: 40px; padding: 0px;">
                                <div class="col-md-6 float_left" style="padding: 0px;">
                            <input name="amb_reg_id"  id="amb_id_base" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_baselocation" placeholder="Search Baselocation"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_baselocation_no">
                            </div>

                            <div class="col-md-6 float_left" id="baselocation_ambulance" style="padding: 0px;">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                            </div>
                            </div>
                        </div>
                        <?php } ?>
                   
                <div class="width_100 map_block_outer" id="map_block_outer">
                      <div class="float_right extend_map_block">
                          <a class="btn extend_map" style="margin-right:10px;" href="#" onclick="open_extend_map('{base_url}inc/extend_map');return false;" data-qr="module_name=inc" name="ques_btn">Extend Map</a>
                     </div>
                        <div class="width_15 float_right min_distance_block">
                        <select name="inc_min_distance" id="inc_min_distance" onchange="get_amb_by_distance();">
                            <option>Default distance</option>
                            <option value="1">1 KM</option>
                            <option value="2">2 KM</option>
                            <option value="5">5 KM</option>
                            <option value="10">10 KM</option>
                            <option value="15">15 KM</option>
                            <option value="20"> 20 KM</option>
                        </select>
                       </div>

                 <div class="map_box_inner float_left" id="INCIDENT_MAP" style="height:336px;">

                </div>

                        
                    <div class="ambulance_box float_left">
                           <?php if($agent_mobile == 'no'){?>
                             <div class="address_bar">
                                 <input id="inc_map_address" placeholder="Enter your address" type="text" class="width_100 filter_required" data-errors="{filter_required:'Address Should not blank'}" style="border-radius:0px !important; width:100% !important; border: 1px solid #ccc;" name="incient[place]" TABINDEX="17" data-ignore="ignore" data-state="yes" data-city="yes" data-thl="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr" value="<?=@$inc_details['inc_address'];?>">
                        </div>
                        <div class="col-md-6" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>
                        <?php } ?>
                       
                        <a class="click-xhttp-request" name="ques_btn" style="display: none;" data-href="{base_url}inc/get_inc_ambu?lat=<?=@$inc_details['lat'];?>&lng=<?=@$inc_details['lng'];?>&inc_ref_id=<?=@$inc_details['inc_ref_id'];?>" data-qr="module_name=inc" id="get_ambu_details">get_ambu</a>
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
                                <input id="inc_dup_no" type="radio" name="incient[dup_inc]" class="radio_check_input filter_either_or[inc_dup_no,inc_dup_yes]" value="No" data-errors="{filter_either_or:'Answer is required'}" checked="checked"  TABINDEX="79">
                                <span class="radio_check_holder" ></span>No
                            </label>
                            <label for="inc_dup_yes" class="radio_check width2 float_left">
                                <input id="inc_dup_yes" type="radio" name="incient[dup_inc]" class="radio_check_input filter_either_or[inc_dup_no,inc_dup_yes]" value="Yes" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="80">
                                <span class="radio_check_holder" ></span>Yes
                            </label>
                        </div>
                    <div class="width60 float_left ">
                                            <div class="label">Around Incident (In KM)</div>
<!--                    <input type="text" name="inc_distance" TABINDEX="81" value="" class="width30 stauto change-base-xhttp-request previous_inc_btn" data-href="{base_url}inc/previous_incident?lat=12.9666662&lng=79.9465841" data-qr="output_position=previous_incident_details&inc_type=non-mci" placeholder="Distance" style="width: 98%;" data-base="ques_btn">-->
                                             <input name="inc_distance" class="width30 form_input mi_autocomplete previous_inc_btn" data-href="{base_url}auto/get_distance" type="text" tabindex="81" placeholder="Distance In KM" data-base="ques_btn" data-callback-funct="get_previous_incident" data-autocom="yes">
                     
                    
                     
                    
<!--                      <input name="ques_btn" id="previous_inc_btn" style="display: none;" value="SEARCH" class="style3 base-xhttp-request previous_inc_btn" data-href="{base_url}inc/previous_incident?lat=12.9666662&lng=79.9465841" data-qr="output_position=previous_incident_details&inc_type=non-mci" type="button">
                      
                      
                     -->
                    </div>
                    <div class="width30">
                     <input name="ques_btn" value="SEARCH" class="base-xhttp-request" data-href="{base_url}inc/previous_incident" data-qr="output_position=previous_incident_details&inc_type=non-mci" type="button" id="get_previous_inc_details" style="visibility: hidden; height: 0px;">
                 </div>
                </div>
                <div class="width2 form_field float_left outer_btn">
                     <div id="fwdcmp_btn">
                        <input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_vip_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=dispatch'  TABINDEX="21">
                         <input type="button" name="submit" value="Terminate Call" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_vip_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD&amp;call_type=terminate'  TABINDEX="27">
                         <input type="button" name="submit" value="Ambulance Not Available" class="btn hheadbg submit_btnt form-xhttp-request" data-href='{base_url}inc/app_confirm_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">

  <!--                      <input value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save" output_position="content" tabindex="20" type="button">-->
<!--                        <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save?cl_type=forword" data-qr="output_position=content" tabindex="22" type="button">-->
                    </div>
                </div>
               
        <div class="width2 float_right">
          
<!--            <div id="inc_ambu_type_details">
                <input type="hidden" name="incient[amb_type]" id="amb_type" value="<?php echo $amb_type;?>">
            </div>-->
               <div id="SelectedAmbulance">

                </div>
<?php //var_dump($inc_details);?>
                <input type="hidden" name="geo_fence" id="geo_fence" value="<?=@$geo_fence;?>">
                <input type="hidden" name="incient[lat]" id="lat" value="<?=@$inc_details['lat'];?>">
                <input type="hidden" name="incient[lng]" id="lng" value="<?=@$inc_details['lng'];?>">
                <input type="hidden" name="incient[inc_ref_id]" id="inc_ref_id" value="<?=@$inc_details['inc_ref_id'];?>">
                <!--<input type="hidden" name="incient[amb_id]" id="amb_id" value="">-->
                <input type="hidden" name="incient[base_month]"  value="<?php echo $cl_base_month;?>">
                <input type="hidden" name="incient[inc_type]" id="inc_type" value="VIP_CALL">
                <input type="hidden" name="incient[inc_google_add]" id="google_id" value="">
                <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
                <input type="hidden" name="incient[caller_dis_timer]" id="caller_dis_timer" value="">
                <input type="hidden" name="incient[inc_recive_time]" value="<?php echo $attend_call_time;?>">
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
<!--                <input type="hidden" name="incient[inc_ero_standard_summary]" value="<?php echo $common_data_form['inc_ero_standard_summary'];?>">
                <input type="hidden" name="incient[inc_ero_summary]" value="<?php echo $common_data_form['inc_ero_summary'];?>">-->
                
<!--                <div id="fwdcmp_btn"><input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/save_inc' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">
                    <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/save_inc?cl_type=forword" data-qr="output_position=content" tabindex="28" type="button"></div>-->
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript"> 
var $placeSearch, $autocomplete, $callIncidentMap,$callIncidentMapUI,$H_Platform;
var $callIncidentBehavior;
var $incGeoFence = null;
var $ambMapMarkers = null;
var $DirectionLine = null;
var $DirectionLineGroup = null;

var $infoWindows = [];
var $incGeocoder;
var $incMapMarker,$incMarkerGroup = null;
<?php if($clg_group != 'UG-PDA'){ ?>
     setTimeout(function(){ 
        if(!(typeof H != 'undefined')){
            $("#inc_manual_add").click();
            xhttprequest($(this),base_url+'inc/get_inc_ambu','data-qr=""');  
        }else{
            
                initIncidentMap();
        }
        
    },100);
<?php }else{ ?>
      initIncidentMap();
<?php } ?>
</script>
