<div class="call_purpose_form_outer">
    <div class="width100">
        <h3>Inter Facility Transfer</h3>
        <div class="incident_details">
            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">
                <div class="width100 float_left">
                    
                    <div class="map_outer_div">
                    <div class="width2 float_left interfc_left">
                        <div class="width_30 float_left form_field pt_no">
                            <div class="label blue">Number Of Patient<span class="md_field">*</span></div>
                            <div class="input">
                                <input id="ptn_no" type="text" name="inter[inc_patient_cnt]" value=""  placeholder="Number Of Patient*" class="small half-text filter_required filter_number filter_no_whitespace" data-errors="{filter_required:'Patient no should not be blank', filter_number:'Only numbers are allowed.',filter_no_whitespace:'Patient no should not be allowed blank space.'}" tabindex="7">
                            </div>
                        </div>
                        <div class="width100 float_left form_field">
                            <div class="label blue">Patient Information</div>
                            <div class="width33 float_left">
                                <input id="first_name"  type="text" name="patient[first_name]" class="ucfirst"  data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_fname']; ?>" placeholder="First Name" TABINDEX="8">
                            </div>
                            <div class="width33 float_left">
                                <input id="middle_name" type="text" name="patient[middle_name]" class="ucfirst"  data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_mname']; ?>" placeholder="Middle Name" TABINDEX="9">
                            </div>
                            <div class="width33 float_left">
                                <input id="last_name"  type="text" name="patient[last_name]" class="ucfirst"  data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_lname']; ?>" placeholder="Last Name" TABINDEX="10">
                            </div>
                            <div class="width100 outer_age">
                                <div class="width33 float_left">
                                    <input id="first_name" type="text" name="patient[age]" class="filter_rangelength[0-100] filter_no_whitespace"  data-errors="{filter_required:'Age should not be blank',filter_rangelength:'Age should be 0 to 100',filter_number:'Age should be in numbers',filter_no_whitespace:'Patient age should not be allowed blank space.'}" value="" placeholder="Age" TABINDEX="11">
                                </div>
                                <div class="width33 outer_gen float_left">
                                    <select id="patient_gender" name="patient[gender]" class="" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> tabindex="12">
                                        <option value="">Gender</option>
                                        <option value="M">Male</option> 
                                        <option value="F">Female</option>
                                        <option value="O">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="width100 pat_cond">
                                <div class="label blue">Patient Condition</div>
                                <div class="float_left width33">
                                    <label for="statuesque" class="chkbox_check">
                                        <input type="checkbox" name="patient[condition]" class="groupcheck  check_input" value="statuesque" data-errors="{filter_either_or:'Patient Condition should not be blank!'}" id="statuesque">
                                        <span class="chkbox_check_holder"></span>Statuesque 
                                    </label>
                                </div>
                                <div class="float_left width33">
                                    <label for="worsen" class="chkbox_check">
                                        <input type="checkbox" name="patient[condition]" class="groupcheck check_input" value="worsen" data-errors="{filter_either_or:'Patient Condition should not be blank!'}" id="worsen">
                                        <span class="chkbox_check_holder"></span>Worsen
                                    </label>
                                </div>
                                <div class="float_left width33">
                                    <label for="improved" class="chkbox_check">
                                        <input type="checkbox" name="patient[condition]" class="groupcheck check_input" value="improved" data-errors="{filter_either_or:'Patient Condition should not be blank!'}" id="improved">
                                        <span class="chkbox_check_holder"></span>Improved
                                    </label>
                                </div>
                            </div>
                            <div class="width100">
                                <div class="label blue">Questions<span class="md_field">*</span></div>
                                <?php if ($questions) {
                                    foreach ($questions as $question) {
                                        ?>
                                        <div class="width100 questions_row" id="ques_<?php echo $question->que_id; ?>">
                                            <div class="width70 float_left"><?php echo $question->que_question; ?></div>
                                            <div class="width_30 float_right">
                                                <label for="ques_<?php echo $question->que_id; ?>_yes" class="radio_check width2 float_left">
                                                    <input id="ques_<?php echo $question->que_id; ?>_yes" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id; ?>_yes,ques_<?php echo $question->que_id; ?>_no]" value="Y" data-base="search_btn" data-errors="{filter_either_or:'Answer is required'}">
                                                    <span class="radio_check_holder"></span>Yes
                                                </label>
                                                <label for="ques_<?php echo $question->que_id; ?>_no" class="radio_check width2 float_left">
                                                    <input id="ques_<?php echo $question->que_id; ?>_no" type="radio" name="incient[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id; ?>_yes,ques_<?php echo $question->que_id; ?>_no]" value="N" data-base="search_btn" data-errors="{filter_either_or:'Answer is required'}">
                                                    <span class="radio_check_holder"></span>No
                                                </label>
                                            </div>   
                                        </div>
    <?php }
} ?>
                        <!--                                  <input name="search_btn" id="get_ques_ans_details" value="SEARCH" style="visibility: hidden;" class="style3 base-xhttp-request" data-href="{base_url}inc/get_ambu_type" data-qr="output_position=inc_details" type="button">-->
                            </div>
                        </div>
                    </div>
                    <div class="width2 float_right form_field outer_fc_details">
                        <div class="label blue">Facility Details</div>
                        <div id="width100 current_fc">
                            <div class="float_left width33">
                                <div class="label">Current Facility<span class="md_field">*</span></div>
                                <div class="input" id="current_facility_box">
                                    <input name="inter[facility]" class="mi_autocomplete width100 filter_required filter_greater_than_zero" placeholder="Current Facility*" data-href="{base_url}auto/get_auto_hospital" type="text" data-errors="{filter_required:'Current Facility should not be blank',filter_greater_than_zero:'Current Facility should not be blank'}" data-callback-funct="facility_details" id="current_facility" TABINDEX="13">
                                </div>
                            </div>
                            <div class="float_left width33">
                                <div class="label">Reporting Doctor<span class="md_field">*</span></div>
                                <div class="input">
                                    <input id="caller_no" type="text" name="inter[rpt_doc]" value=""  placeholder="Reporting Doctor*" class="small filter_required" data-errors="{filter_required:'Reporting Doctor should not be blank', filter_word:'Invalid input at Reporting Doctor name. Numbers and special characters not allowed.'}" TABINDEX="14">
                                </div>
                            </div>
                            <div class="float_left width33">
                                <div class="label">Mobile Number<span class="md_field">*</span></div>
                                <div class="input">
                                    <input id="caller_no" type="text" name="inter[mo_no]" value=""  placeholder="Mobile Number*" class="filter_required filter_number filter_minlength[9] filter_maxlength[13] filter_no_whitespac"  data-errors="{filter_required:'Mobile should not be blank', filter_number:'Mobile should be in numeric characters only', filter_minlength:'Mobile should be at least 10 digits long', filter_maxlength:'Mobile should less then 12 digits.', filter_no_whitespace:'No spaces allowed'}" TABINDEX="15" >
                                </div>
                            </div>
                            <input class="add_button_hp onpage_popup float_right" id="add_button_hp" name="add_hp" value="Add" data-href="{base_url}hp/add_hp" data-qr="output_position=popup_div&amp;filter_search=search&amp;tool_code=add_hosp&amp;req=ero" type="button" data-popupwidth="1000" data-popupheight="800" style="display:none;">
                        </div>
                        <div id="facility_details">

                        </div>
                        <div class="width100 float_right form_field new_fc">
                            <div class="float_left width33">
                                <div class="label">New Facility<span class="md_field">*</span></div>
                                <div class="input" id="new_facility_box">
                                    <input name="inter[new_facility]" class="mi_autocomplete width100 filter_required filter_greater_than_zero" placeholder="Current Facility*"  data-href="{base_url}auto/get_auto_hospital" type="text" data-errors="{filter_required:'New Facility should not be blank',filter_greater_than_zero:'New Facility should not be blank'}" data-callback-funct="facility_new_details" TABINDEX="16">
                                </div>
                            </div>
                            <div class="float_left width33">
                                <div class="label">Reporting Doctor<span class="md_field">*</span></div>
                                <div class="input">
                                    <input id="caller_no" type="text" name="inter[new_rpt_doc]" value=""  placeholder="Reporting Doctor*" class="small filter_required" data-errors="{filter_required:'Reporting Doctor should not be blank', filter_word:'Invalid input at Reporting Doctor name. Numbers and special characters not allowed.'}" TABINDEX="17">
                                </div>
                            </div>
                            <div class="float_left width33">
                                <div class="label">Mobile Number<span class="md_field">*</span></div>
                                <div class="input">
                                    <input id="caller_no" type="text" name="inter[new_mo_no]" value=""  placeholder="Mobile Number" class="filter_required filter_number filter_minlength[9] filter_maxlength[13] filter_no_whitespac"  data-errors="{filter_required:'Mobile should not be blank', filter_number:'Mobile should be in numeric characters only', filter_minlength:'Mobile should be at least 10 digits long', filter_maxlength:'Mobile should less then 12 digits.', filter_no_whitespace:'No spaces allowed'}"TABINDEX="18">
                                </div>
                            </div> 
                            <input class="add_button_hp onpage_popup float_right" id="add_button_hp_new" name="add_hp" value="Add" data-href="{base_url}hp/add_hp" data-qr="output_position=popup_div&amp;filter_search=search&amp;tool_code=add_hosp&amp;req=ero&amp;fc=new" type="button" data-popupwidth="1000" data-popupheight="800" style="display:none;">
                        </div>
                        <div id="new_facility_details">
                        </div>
                        <div id="add_inc_details_block inc_add">
                          
                            <div class="width_100">
                                  <div class="label blue width100">Incident Address</div>
                                <div class="width33 float_left">
                                    <div id="incient_state">



                                        <?php
                                        $st = array('st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                        //echo get_state($st);
                                        ?>

                                    </div>
                                    <input name="incient_state" value="MP"  class=" width97 filter_required"  style="display: none;">
                <!--                        <input type="text" name="inter[state]" TABINDEX="21" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="Enter State" data-auto="" id="inc_state">-->
                                </div>
                                <div class="width33 float_left">
                                    <div id="incient_dist">
                                        <?php
                                        $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                        echo get_district($dt);
                                        ?>
                                    </div>
                    <!--                        <input type="text" name="inter[inc_district]" TABINDEX="22" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="Enter District" data-auto="" id="inc_district">-->
                                </div>
                                <div class="width33 float_left">
                                    <input type="text" name="inter[inc_city]" TABINDEX="23" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="City / Vilage / Town" data-auto="" id="inc_city">
                                </div>
                                <div class="width33 float_left">
                                    <input type="text" name="inter[area]" TABINDEX="24" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="Area / Location" data-auto="" id="area_location">
                                </div>
                                <!--<div class="width33 float_left">
                                    <input type="text" name="inter[landmark]" TABINDEX="25" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="Landmark" data-auto="" id="street_number">
                                </div>
                                <div class="width33 float_left">
                                    <input type="text" name="inter[lane]" TABINDEX="26" value="" class="stauto" data-href="{base_url}auto/get_state"  data-qr="" placeholder="Lane / Street" data-auto="" id="route">
                                </div>-->

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
                        <div class="width100 form_field inthp_sumry">
                            <div class="label blue">ERO Summary</div>
                            <textarea name="inter[inc_ero_summary]" class="width100" TABINDEX="19" data-maxlen="400"></textarea>
                        </div>
                    </div>
                 </div>
                <div class="res_address_bar">
                 <div class="address_bar">
                              <input id="inc_map_address" placeholder="Enter your address" type="text" class="width_100 filter_required" data-errors="{filter_required:'Address Should not blank'}"  style="border-radius:0px !important; width:100% !important; border:7px solid #4688f1" name="incient[place]" TABINDEX="17" data-ignore="ignore" data-state="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr">
                        </div>
                        <div class="col-md-3" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>
                </div>
                    
                    <div class="width_100 map_block_outer" id="map_block_outer">
                        <!--                         <div class="map_inc_button"><div class="bullet">INCIDENT ADDRESS</div></div>-->
                        <!--                           <div class="float_right extend_map_block">
                                                            <a class="btn extend_map" href="#" onclick="open_extend_map('{base_url}inc/extend_map');return false;" data-qr="module_name=inc" name="ques_btn">Extend Map</a>
                                                     </div>-->
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
                                                <div class="address_bar interfc">
                                 <input id="inc_map_address" placeholder="Enter your address"  type="text" class="width_100" style="border-radius:0px !important; width:100% !important; border:7px solid #4688f1" name="incient[place]" TABINDEX="20" data-ignore="ignore" data-state="yes" data-dist="yes" data-rel="incient" data-auto="inc_auto_addr">
                    </div>
                    <div class="col-md-3" id="search_amb" style="display:none">
                            <input name="amb_reg_id"  id="amb_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Search Ambulance"  tabindex="2" autocomplete="off" value="" data-value="" data-callback-funct="serch_by_amb_no">
                        </div>
                    
                             
                            <a class="click-xhttp-request" style="display: none;" data-href="{base_url}inc/get_inc_ambu?lat=&lng" data-qr="module_name=inc" id="get_ambu_details">get_ambu</a>
                            <div id="inc_map_details"></div>
                        </div>
                    </div>

                    <div class="width100">
                        <div id="SelectedAmbulance">

                        </div>
                        <input type="hidden" name="inter[lat]" id="lat" value="">
                        <input type="hidden" name="inter[lng]" id="lng" value="">
<!--                        <input type="hidden" name="inter[amb_id]" id="amb_id" value="">-->
                        <input type="hidden" name="inter[base_month]"  value="<?php echo $cl_base_month; ?>">
                        <input type="hidden" name="inter[inc_type]" id="inc_type" value="inter-hos">
                        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

                        <!--                        <div id="fwdcmp_btn">
                                                    <input type="button" name="submit" value="DISPATCH" TABINDEX="30" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/save_inter' data-qr='output_position=content'>
                                                    <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/save_inc?cl_type=forword" data-qr="output_position=content" tabindex="31" type="button"></div>-->

                        <div id="fwdcmp_btn">
                            <input type="button" name="submit" value="DISPATCH" class="btn submit_btnt form-xhttp-request" data-href='{base_url}inc/confirm_inter_hos_save' data-qr='output_position=content&amp;module_name=inc&amp'  TABINDEX="27">
      <!--                      <input value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_mci_save" output_position="content" tabindex="20" type="button">-->
                            <input name="search_btn" value="FORWARD TO SUPERVISER" class="style4 form-xhttp-request" data-href="{base_url}inc/confirm_inter_hos_save?cl_type=forword" data-qr="output_position=content" tabindex="28" type="button">
                        </div>

                    </div>
                </div>  


            </form>
        </div>
    </div>
</div>
<br>
<br>
<script type="text/javascript">
    initIncidentMap();
//  get_tahshil_ambulance();  
    function facility_details(ft) {

        if (ft['id'] == 0) {
         //   $("#add_button_hp").click();
        } else {

            xhttprequest($(this), base_url + 'inc/get_facility_details', 'hp_id=' + ft['id']);
        }

    }
    function facility_new_details(ft) {
        if (ft['id'] == 0) {
         //   $("#add_button_hp_new").click();
        } else {
            xhttprequest($(this), base_url + 'inc/get_facility_details?facility=new', 'hp_id=' + ft['id']);
        }
    }
</script>