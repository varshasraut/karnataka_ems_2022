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
    <label class="headerlbl">MCI / Disaster call</label>
        <!-- <h3>MCI / Disaster call </h3> -->
        <div class="incident_details">
            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">
                <div class="width100 float_left">
                    <div class="width2 float_left lf_side">
                              <!-- <div class="width100 float_left">

                            <div class="label blue float_left strong">Incident Time<span class="md_field">*</span></div>
                            <div class="input top_left float_left width27" >
                               
                                <input type="text" name="incient[inc_datetime]" id="inc_datetime" value="<?php echo date('Y-m-d h:i:s');?>"  placeholder="Incident Time" class=" filter_required " data-errors="{filter_required:'Incident Time should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Patient no  should not be allowed blank space.'}" TABINDEX="7" >
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
                         
                        <div class="width100" style="display:table;">
                        <div class="form_field"  style="display:table-cell; width: 35%;">

                            <div class="label blue float_left">Number Of Patient<span class="md_field">*</span></div>
                            <div class="input float_left width27 ml-2">
                                <input id="ptn_no" type="text" name="incient[inc_patient_cnt]" value="<?= @$int_count; ?>"  placeholder="Number Of Patient*" class="change-xhttp-request small half-text filter_required filter_no_whitespace filter_number filter_rangelength[0-10]" data-errors="{filter_rangelength:'Number should be 0 to 10',filter_required:'Patient no should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Number Of Patient should not be allowed blank space.'}" data-href="{base_url}inc/change_view" data-qr="output_position=content&amp;call_type=mci" TABINDEX="7" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="2">
                            </div>
                        </div>

                        <div class="form_field" style="display:table-cell; margin-left: 5px; width: 65%;">
                            <div class="label blue float_left width30 mt-1">MCI Nature:<span class="md_field">*</span></div>
                            <div class="input nature top_left float_left width_66">
                                <input id="chief_complete" type="text" name="incient[mci_nature]" class="mi_autocomplete filter_required width97" data-href="{base_url}auto/get_mci_nature"  placeholder="MCI Nature is required" data-errors="{filter_required:'Please select MCI Nature from dropdown list', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" TABINDEX="8" data-callback-funct="nature_complete_change" data-base="ques_btn" <?php echo $autofocus; ?>>

                                <script type="text/javascript">

                                    function nature_complete_change(ft) {
                                        xhttprequest($(this), base_url + 'inc/get_mci_nature_service', 'ntr_id=' + ft['id']);


                                    }
                                </script>
                            </div>
                        </div>
                        </div>
                        
                        <div class="width100 float_left" id="inc_services_details">
                            <?php 
                            if($services){
                            foreach ($services as $key => $service) { ?>
                                <div class="width_20 float_left">
                                    <label for="service_<?php echo $service->srv_id; ?>" class="chkbox_check">
                                        <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" class="check_input unit_checkbox" value="<?php echo $service->srv_id; ?>"  id="service_<?php echo $service->srv_id; ?>" <?php if ($service->srv_name == 'Medical') {
                                echo "checked";
                            } ?>>
                                        <span class="chkbox_check_holder"></span><?php echo $service->srv_name; ?><br>
                                    </label>
    <!--                <input type="checkbox" name="incient[service][<?php echo $service->srv_id; ?>]" TABINDEX="10"  <?php if ($service->srv_name == 'Medical') {
                                    echo "checked";
                                } ?>>-->
    <?php //echo $service->srv_name;  ?>
                                </div>
                            <?php } } ?>

                        </div>
                        
                    <div class="width100 form_field outer_smry">
                        <div class="label blue float_left width30">ERO Summary<span class="md_field">*</span>&nbsp;</div>
                          <div class="width70 float_left">
                         <input type="text" name="incient[inc_ero_standard_summary]" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['inc_ero_standard_summary']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="{base_url}auto/get_ero_standard_summary?call_type=MCI"  placeholder="ERO Summary" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change" TABINDEX="8" >
                          </div>
                    </div>
                     <div class="width100 form_field outer_smry">
                        <div class="label blue float_left">ERO Note</div>
      
                        <div class="width97" id="ero_summary_other">
                             <textarea style="height:60px;" name="incient[inc_ero_summary]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?=@$inc_details['inc_ero_summary'];?></textarea>
                        </div>
                    </div>
<!--                        <div class="width100 float_left">
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
                        <div class="form_field float_left"  style="width: 60%;">
                           <div class="label blue float_left">Enter Three Word :</div>
                            <div class="input top_left float_left width2" style="display: flex;">
                            <a title="What Three Word SMS" class="three_word click-xhttp-request" data-href="{base_url}calls/three_word_popup" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                            <what3words-autosuggest id="three_word" name="incient[3word]" class="change-xhttp-request"  />
                              <!-- <input id="three_word" type="text" name="incient[3word]"  placeholder="Enter Three Word " class="change-xhttp-request"  TABINDEX="7" what3words-autosuggest />-->
                            </div>

                        </div>
                        <div class="form_field float_left"  style="width: 40%;" id="validation_result">
                           

                        </div>
                      
                    </div>
                    </div>
                    <div class="width2 float_left form_field rt_side">
                        <div id="add_inc_details_block">
                            <div class="label blue">Incident Address</div>
                            <div class="width_100">
                                <div class="width33 float_left">
                                    <div id="incient_state1">



                                        <?php
                                        $st = array('st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                      // echo get_state_tahsil($st);
                                        ?>

                                    </div>
                                    <input name="incient_state" value="MP"  class=" width97 filter_required"  style="display: none;">
<!--                                <input type="text" name="incient[state]" TABINDEX="70" value="Maharashtra" class="" data-errors="{filter_required:'State is required'}" placeholder="State" id="inc_state" style="margin-bottom: 5px;">
                               <input name="incient_state" value="MH" class=" width97 filter_required" data-href="http://mulikas4/bvg/auto/get_state" placeholder="State" data-errors="{filter_required:'Please select state from dropdown list'}" data-base="" data-value="Maharashtra" data-auto="inc_auto_addr" data-callback-funct="load_auto_dist_tahsil" data-rel="incient" tabindex="15" autocomplete="off" >-->
                                </div>
<!--                                <div class="width33 float_left">
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
                                        $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                         echo get_district_tahsil($dt);
                                        ?>
                                    </div>
                                </div>
                                <div class="width33 float_left">
                                    <div id="incient_tahsil">
                                        <?php
                                        $thl = array('thl_code' => '','dst_code' => '', 'st_code' => '', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                        echo get_tahshil($thl);
                                        ?>
                                    </div>
                                </div>
                                <div class="width33 float_left">
                                      <div id="incient_city">
                                        <?php
                                        if($inc_details['inc_city'] == '' || $inc_details['inc_city'] == 0){
                                             $city_id = '';
                                        }else {
                                            $city_id = $inc_details['inc_city'];
                                        }
                                        $city = array('cty_id' =>$city_id, 'dst_code' => $district_id,'cty_thshil_code' => $tahsil_id, 'st_code' => $state, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                        echo get_city_tahsil($city);
                                        ?>
                                    </div>
                                </div>
                                <div class="width33 float_left">
                                    <input type="text" name="incient[area]"  value="" class="" placeholder="Area / Location" data-errors="{filter_required:'Area / Location is required'}"  id="area_location" TABINDEX="73">
                                </div>
                                <div class="width33 float_left">
                                    <input type="text" name="incient[landmark]" value="" class="" placeholder="Landmark" data-errors="{filter_required:'Landmark is required'}" id="street_number" TABINDEX="74">
                                </div>
                                <!--<div class="width33 float_left">
                                    <input type="text" name="incient[lane]" value="" class="" placeholder="Lane / Street" data-errors="{filter_required:'Lane / Street is required'}" id="route" TABINDEX="75">
                                </div>-->

                            </div>
                            <div class="width_100">

                                <!--<div class="width33 float_left">
                                    <input type="text" name="incient[h_no]" value="" class="" placeholder="House Number" data-auto="" TABINDEX="76" data-errors="{filter_required:'House Number is required'}">
                                </div>
                                <div class="width33 float_left">
                                    <input type="text" name="incient[pincode]" value="" class="" placeholder="PinCode" data-auto="" id="postal_code" TABINDEX="77" data-errors="{filter_required:'PinCode is required'}">
                                </div>-->
                                <div class="width33 float_left">
                                    <input type="hidden" name="incient[google_location]" value="" class=" width_100" placeholder="google location map address" data-auto="" id="google_formated_add" style="width: 98%;" TABINDEX="78" data-errors="{filter_required:'Google location is required'}">
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
                <div class="width50 form_field float_left hide" id="hospital_two">
                    
                        <div class="label blue width20 float_left">Hospital2<span class="md_field"></span>&nbsp;&nbsp;&nbsp;</div>
                        <div class="width80 float_left" id="inc_two_temp_hospital">
                             <!-- <input  name="incient[hospital_id]" class="mi_autocomplete width100 filter_either_or[host_one,host_two]" placeholder="Priority two Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Priority two Hospital should not be blank',filter_either_or:'hospital should not be blank.'}" id="host_two" TABINDEX="13" data-callback-funct="hospital_avaibility_two" data-value="<?php echo $inc_details['destination_hp_name']; ?>" value="<?=@$inc_details['destination_hospital_id']; ?>"> -->
                             <input  name="incient[hospital_id]" class="mi_autocomplete width100 filter_either_or[host_one,host_two]" placeholder="Priority two Hospital" data-href="{base_url}auto/get_hospital_bed_ero" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of  Priority two Hospital should not be blank',filter_either_or:'hospital should not be blank.'}" id="host_two" TABINDEX="13" data-callback-funct="hospital_avaibility_two_new" data-value="<?php echo $inc_details['destination_hp_name']; ?>" value="<?=@$inc_details['destination_hospital_id']; ?>">
                        </div>
                        <div  id="hospital_details_two">
                        </div>
                    </div>
                    </div>
                    </div>
                    
                </div>
  <?php if($agent_mobile == 'yes'){?>
                         <div class="address_bar">
                        <input id="inc_map_address" placeholder="Enter your address"  type="text" class="width_100 incient filter_required" data-errors="{filter_required:'Address Should not blank'}" style="border-radius:0px !important; width:100% !important; border: 1px solid #ccc; margin-bottom: 0px;" name="incient[place]" TABINDEX="11" data-ignore="ignore" data-state="yes" data-dist="yes" data-thl="yes" data-city="yes" data-rel="incient" data-auto="inc_auto_addr">
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
                                     
                    <!--            <div class="map_inc_button"><div class="bullet">INCIDENT ADDRESS</div></div>-->
                    <div class="float_right extend_map_block">
                            <a class="btn extend_map" href="#" onclick="open_extend_map('{base_url}inc/extend_map');return false;" data-qr="module_name=inc" name="ques_btn">Extend Map</a>
                     </div>
                    <div class="width_15 float_right min_distance_block">
        <!--                 <input name="inc_min_distance" class="width30 form_input mi_autocomplete" data-href="{base_url}auto/get_distance" type="text" tabindex="81" placeholder="Radius in KM" data-base="ques_btn" data-callback-funct="get_amb_by_distance" data-autocom="yes">-->
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
                        <input id="inc_map_address" placeholder="Enter your address"  type="text" class="width_100 incient filter_required" data-errors="{filter_required:'Address Should not blank'}" style="border-radius:0px !important; width:100% !important; border: 1px solid #ccc;" name="incient[place]" TABINDEX="11" data-ignore="ignore" data-state="yes" data-thl="yes" data-dist="yes" data-city="yes" data-rel="incient" data-thl="yes" data-auto="inc_auto_addr">
<!--                        <div id="result"><table id="sugg"></table></div>-->
                   </div>
                   <div class="col-md-6" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>
                   <?php } ?>
                        <a class="click-xhttp-request" style="display: none;" data-href="{base_url}inc/get_inc_ambu?lat=<?=@$inc_details['lat'];?>&lng=<?=@$inc_details['lng'];?>" data-qr="module_name=inc" id="get_ambu_details" name="ques_btn">get_ambu</a>
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
                        <input name="ques_btn" value="SEARCH" class="base-xhttp-request" data-href="{base_url}inc/previous_incident?lat=&lng=" data-qr="output_position=previous_incident_details&inc_type=mci" type="button" id="get_previous_inc_details" style="visibility: hidden; height: 0px;">
                    </div>
                    <div class="width60 float_left">
                        <div class="label">Around Incident( In KM)</div>
                        <input name="inc_distance" class="width30 form_input mi_autocomplete previous_inc_btn" data-href="{base_url}auto/get_distance" type="text" tabindex="81" placeholder="Distance in KM" data-base="ques_btn" data-callback-funct="get_previous_incident" data-autocom="yes">
                    </div>
                </div>
                
                
                <div class="width2 float_left outer_btn">
                    <div id="SelectedAmbulance">

                    </div>
                    <div id="StandbyAmbulance">

                    </div>

                    <input type="hidden" name="incient[lat]" id="lat" value="">
                    <input type="hidden" name="incient[lng]" id="lng" value="">
    <!--                <input type="hidden" name="incient[amb_id]" id="amb_id" value="" class="filter_required" data-errors="{filter_required:'Please select Ambulance'}">-->
                    <input type="hidden" name="incient[base_month]"  value="<?php echo $cl_base_month; ?>">
                    <input type="hidden" name="incient[inc_type]" id="inc_type" value="MCI">
                    <input type="hidden" name="incient[inc_google_add]" id="google_id" value="">
                    <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">
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
                    
                    <div id="fwdcmp_btn">
                    <!--<input type="button" name="submit" value="Follow Up" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_mci_save_followup' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="21">-->
                        <input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_mci_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="21">
                         <input type="button" name="submit" value="Terminate Call" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_mci_terminate' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">
                         <input type="button" name="submit" value="Ambulance Not Available" class="btn hheadbg submit_btnt form-xhttp-request" data-href='{base_url}inc/app_confirm_save' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="27">

  <!--                      <input value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save" output_position="content" tabindex="20" type="button">-->
<!--                        <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save?cl_type=forword" data-qr="output_position=content" tabindex="22" type="button">-->
                    </div>

                </div>
               
            </form>

        </div>
    </div>

    <script>
   var $placeSearch, $autocomplete, $callIncidentMap,$callIncidentMapUI,$H_Platform;
var $callIncidentBehavior;
var $incGeoFence = null;
var $ambMapMarkers = null;
var $DirectionLine = null;
var $DirectionLineGroup = null;

var $infoWindows = [];
var $incGeocoder;
var $incMapMarker,$incMarkerGroup = null;
    setTimeout(function(){ 
        if(!(H)){
            $("#inc_manual_add").click();
            xhttprequest($(this),base_url+'inc/get_inc_ambu','data-qr=""');  
        }
        
    },100);
    if(typeof H != 'undefined'){
        initIncidentMap();
        // get_tahshil_ambulance();
     }
    </script>

<style>
    body{
        font-size: 14px !important;
    }
</style>