<div class="float_left width100">
    <?php
    $CI = EMS_Controller::get_instance();

    if (@$th_id != '') {
        $th_id = @$th_id;
    }

    if (@$amb_dst != '') {
        $dst_id = @$amb_dst;
    }
  // var_dump($driver_data[0]);
  // die();
    ?>
    <div class="head_outer"><h3 class="txt_clr2 width1">Closure Information : Patient Available</h3> </div>     
    <form method="post" name="" id="call_dls_info" >
        <div class="epcr">

            <div class="width50 float_left left_align">
                
                <div id="pat_details_block">
                <div class="width100">
                        <div class="single_record_back">                                     
                            <h3>Patient Details  <?php echo '[Total Patient Count'.' '.$pt_count.''.']'; ?></h3>
                        </div>
                        <div class="width_25 float_left drg">
                            <!--<div class=" float_left ">
                                <div class="style6 float_left">Patient ID  <span class="md_field"> * </span> :   </div>
                            </div>-->
                            
                                <?php
                                if (!empty($inc_details[0]->ptn_id)) {
                                    $disabled = "disabled";
                                }
                                ?>

                                <select name="pat_id" tabindex="8" id="pcr_pat_id_new" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms"> 
                                    <option value="" <?php //echo $disabled; ?>>Select patient id</option>
                                    <?php foreach ($patient_info as $pt) { ?>
                                        <option value="<?php echo $pt->ptn_id; ?>" <?php
                                        if ($pt->ptn_id == $pt_info[0]->ptn_id ) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                                            <?php } ?>
                                            <?php 
                                            $count = $inc_details_data[0]->inc_patient_cnt + 5 ; 
                                            
                                            ?>
                                            <?php if($pt_count < $count ){
                                                ?>
                                                <option value="0">Add Patients</option>
                                                <?php
                                            }?>
                                </select>

                                <input class="add_button_hp click-xhttp-request float_right mipopup" id="add_button_pt" name="add_patient" value="Add" data-href="{base_url}pcr/add_patient_details?pt_count=<?php echo $pt_count; ?>&epcr_call_type=<?php echo '2';?>&pt_count_ero=<?php echo $inc_details_data[0]->inc_patient_cnt; ?>" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes&inc_ref_id=<?php echo $inc_ref_id; ?>&reopen=<?php echo $reopen;?>" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">
                           
                        </div>
                        <div class="width_25 float_left drg">
                            
                                <input name="patient_age" tabindex="9" class="form_input" placeholder=" Age" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Age should not be blank!'}" value="<?php echo $pt_info[0]->ptn_age; ?>" readonly="readonly">
                            
                        </div>

                       
                        <div class="width_25 float_left">
                        <select id="ptn_age_type" name="ptn[0][ptn_age_type]">
                        <option value="Year" <?php if($pt_info[0]->ptn_age_type == 'Year'){
                       echo "selected";     
                        } ?>>Year</option>
                        <option value="Month" <?php if($pt_info[0]->ptn_age_type == 'Month'){
                       echo "selected";     
                        } ?>>Month</option>
                        <option value="Day" <?php if($pt_info[0]->ptn_age_type == 'Day'){
                       echo "selected";     
                        } ?>>Day</option>
                        </select>
                        </div>
                        <div class="width_25 float_left">
                                            <!--                        <input name="gender" tabindex="13" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient gender should not be blank!'}" value="<?= get_gen($pt_info[0]->ptn_gender); ?>">-->
                                <select id="patient_gender" name="gender"  data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="10" disabled="disabled">
                                    <option value=''>Gender</option>
                                    <option value="M" <?php
                                    if ($pt_info[0]->ptn_gender == 'M') {
                                        echo "Selected";
                                    }
                                    ?>>Male</option> 
                                    <option value="F" <?php
                                    if ($pt_info[0]->ptn_gender == 'F') {
                                        echo "Selected";
                                    }
                                    ?>>Female</option>
                                    <option value="O" <?php
                                    if ($pt_info[0]->ptn_gender == 'O') {
                                        echo "Selected";
                                    }
                                    ?>>Transgender</option>
                                </select>
                            </div>
                    </div>
                    <div class="width100">
                        <div class="width100 float_left drg">
                            <!--<div class=" width_16 float_left">
                                <div class="style6 float_left">Patient Name<span class="md_field">*</span> : </div>
                            </div>-->
                            <div class="width_25 float_left">
                                <input name="ptn_fname" id="ptn_fname" tabindex="11" class="form_input filter_required ucfirst_letter" placeholder="Patient First Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php echo $pt_info[0]->ptn_fname; ?>" readonly="readonly">
                            </div>
                            <!--<div class="width_27 float_left">
                                <input name="ptn_mname" tabindex="12" class="form_input" placeholder="Patient Middle Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php //$pt_info[0]->ptn_mname; ?>" readonly="readonly">
                            </div>-->
                            <div class="width_25 float_left drg">
                                <input name="ptn_lname" tabindex="13" class=" " placeholder="Patient Last Name " type="text" data-base="search_btn" value="<?php echo $pt_info[0]->ptn_lname; ?>" readonly="readonly">
                            </div>
                            
                            
                            <div class="width_25 float_left drg">
                                <input name="ayu_id" tabindex="13" class="form_input" placeholder="Ayushman ID" type="text" data-base="search_btn" value="<?php echo $pt_info[0]->ayushman_id; ?>" readonly="readonly">
                            </div>
                            <div class="width_25 float_left drg">
                                <input name="blood_gp" tabindex="13" class="form_input" placeholder="Blood Group" type="text" data-base="search_btn" value="<?php if($pt_info[0]->ptn_bgroup == ''){ echo get_blood_group_name($pt_info[0]->ptn_bgroup); }  ?>" readonly="readonly">

                            </div>
                        </div>


                        <div class="width100">

                            <div id="ptn_form_lnk" class="width100 float_left">
   <?php if($pt_info[0]->ptn_id != ''){ ?>
                                <a data-href='{base_url}pcr/add_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=<?php echo @$pt_info[0]->ptn_id; ?>&amp;inc_ref_id=<?php echo $inc_ref_id; ?>&amp;reopen=<?php echo $reopen;?>' data-popupwidth='1250' data-popupheight='870'>( Update Patient Details )</a>
                                 <a data-href='{base_url}pcr/delete_patient_details' class='click-xhttp-request style1' style="color:#f00  !important" data-qr='ptn_id=<?php echo @$pt_info[0]->ptn_id; ?>&amp;inc_ref_id=<?php echo $inc_ref_id; ?>' data-popupwidth='1250' data-popupheight='870' data-confirm='yes' data-confirmmessage='Are you sure to delete'>( Delete Patient )</a>
   <?php } ?>

                            </div>

                        </div>

                    </div>
                    <!--                    <div class="width100">
                                            <h3>Patient Address : </h3>
                                            <div class="width50 drg float_left">
                                                <div class="width100 float_left">
                                                    <div class="style6 float_left">State<span class="md_field">*</span>  : </div>
                                                </div>
                                                <div class="width100 float_left">
                                                    <div id="tc_dtl_state">
                    
                    
                    <?php
                    if ($pt_info[0]->ptn_state != '') {

                        $state_id = $pt_info[0]->ptn_state;
                    } else {
                        $state_id = "MH";
                    }
                    ?>
                    
                    
                    <?php
                    $st = array('st_code' => $state_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');

                    echo get_state($st);
                    ?>
                    
                    
                    
                    
                                                    </div>
                    
                                                </div>
                                            </div>
                                            <div class="width50 drg float_left">
                                                <div class="width100 float_left">
                                                    <div class="style6 float_left">District<span class="md_field">*</span>  : </div>
                                                </div>
                                                <div class="width100 float_left">
                                                    <div id="tc_dtl_dist">
                    
                    
                    
                    <?php
                    $district_id = '';

                    // if ($inc_details[0]->inc_district_id == '') {
                    $district_id = $pt_info[0]->ptn_district;



                    //  }
                    ?>
                    
                    <?php
                    $dt = array('dst_code' => $district_id, 'st_code' => $state_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => $view);



                    echo get_district($dt);
                    ?>
                    
                    
                                                    </div>
                                                </div>
                                            </div>
                    
                                        </div>
                                        <div class="width100">
                                            <div class="width50 drg float_left">
                                                <div class="width100 float_left">
                                                    <div class="style6 float_left">City/Village<span class="md_field">*</span> : </div>
                                                </div>
                                                <div class="width100 float_left">
                    
                                        <input name="city" tabindex="17" class="mi_autocomplete  form_input filter_required" placeholder=" City/Village " type="text" data-base="search_btn" data-errors="{filter_required:'City/Village should not be blank!'}" data-href="{base_url}auto/city" data-value="<?php echo @$inc_details[0]->inc_city_id; ?>">
                    
                                                    <div id="tc_dtl_city">      
                    
                    <?php
                    $city_id = '';
                    //  if ($inc_details[0]->inc_city_id == '') {
                    $city_id = $pt_info[0]->ptn_city;
                    //  }
                    ?>
                    
                    <?php
                    $ct = array('cty_id' => $city_id, 'dst_code' => $district_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');
                    echo get_city($ct);
                    ?>
                    
                    
                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="width50 drg float_left">
                                                <div class="width100 float_left">
                                                    <div class="style6 float_left">Locality<span class="md_field">*</span>   : </div>
                                                </div>
                                                <div class="width100 float_left">
                    <?php
                    //   if ($inc_details[0]->inc_address == '') {
                    $inc_address = $pt_info[0]->ptn_address;
                    //  } 
                    ?>
                                                    <input name="locality" tabindex="33" class="form_input filter_required" placeholder="Locality" type="text" data-base="search_btn" data-errors="{filter_required:'Locality should not be blank!'}" value="<?php echo @inc_address ?>">
                                                </div>
                                            </div>
                    
                                        </div>-->
                </div>
               
                <div id="amb_details_block">
                    <div class="width100">
                        <div class="single_record_back">                                     
                            <h3>Ambulance Details</h3>
                        </div>
                    </div>
                    <?php if($amb_type != 1){  ?>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php //var_dump($inc_emp_info); ?>
<!--                                <input name="emt_name" tabindex="24" class="form_input filter_required" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?php echo @$inc_details[0]->emt_name; ?>" >-->
                                <input name="emt_id" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_emso_id" data-value="<?php  echo $inc_details[0]->emso_id; ?>" value="<?php echo $inc_details[0]->emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_emso_id"  id="emt_list" data-errors="{filter_required:'Ambulance should not be blank!'}">
                            </div>
                        </div>
                        <div class="width50 drg float_left" id="show_emso_name">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left" >
                                <input name="emt_name" id="emt_id_new" tabindex="25" class="form_input" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'Name should not be blank!'}" value="<?php echo @$inc_details[0]->emt_name; ?>">
                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?php echo $inc_details[0]->emso_id; ?>">
                            </div>
                            
                        </div>

                    </div>
                    <?php } ?>
                    <div class="width100" id="emt_other_textbox">
                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php //var_dump($inc_emp_info); ?>
                                <input name="pilot_id"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_pilot_id" data-value="<?php echo $inc_details[0]->pilot_id; ?>" value="<?php echo $inc_details[0]->pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot ID" data-callback-funct="show_pilot_idnew"  id="pilot_list" data-errors="{filter_required:'Pilot ID should not be blank!'}">
                            </div>
                          
                        </div>
                        <div class="width50 drg float_left" id="show_pilot_name">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left" >
                                <input name="pilot_name" id="pilot_id_new" tabindex="25" class="form_input" placeholder="Pilot Name1" type="text" data-base="search_btn" data-errors="{filter_required:'Name should not be blank!'}" value="<?php echo $inc_details[0]->pilot_name; ?>">
                                <input name="pilot_id" tabindex="25" class="form_input"  type="hidden" value="<?php echo $inc_details[0]->pilot_id; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="width100" id="pilot_other_textbox">
                            </div>
         
                   
                    
                    </div>
                    <div class="width100 float_left">
                    <div class="width100">
                    <div class="single_record_back">                                     
                        <h3>Medical Information</h3>
                    </div>
                    </div>
                    <div class="width100">
                    <?php if($amb_type != 1){  ?>
                        <div class="width50 drg float_left">
                            <div class="width50 ">
                                <div class="style6 float_left">Medical Advice<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left">
                                <input name="ercp_advice" id="ercp_advice_input" tabindex="3" class="mi_autocomplete form_input filter_required" placeholder="ERCP Advice" type="text" data-base="search_btn" data-errors="{filter_required:'Please select ERCP advice from dropdown list'}" data-href="{base_url}auto/ercp_advice" value="<?php echo @$inc_details[0]->ercp_advice; ?>"  data-value="<?php echo @$inc_details[0]->ercp_advice; ?>"  data-callback-funct="ercp_advice_taken">
                            </div>
                        </div>
                        <div  class="width33 float_left hide" id="ercp_advice">
                            <?php //if (@$inc_details[0]->ercp_advice != '') { ?>
                                <div class="width100">
                                    <div class="width100 rec_hp float_left ">
                                        <input name="ercp_advice_Taken" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_auto_clg_dm?clg_group=UG-ERCP" data-value="<?php echo @$inc_details[0]->ercp_advice_Taken; ?>" value="<?php echo @$indent_data[0]->ercp_advice_Taken; ?>" type="text" tabindex="1" placeholder="Advice given by [Dr.Name]" data-errors="{filter_required:'Advice given by [Dr.Name] should not be blank!'}" data-qr='clg_group=UG-ERCP&amp;output_position=content'  <?php echo $update; ?>>
                                    </div>
                                </div>
                            <?php // } ?>

                        </div>
                         <div class="width50 drg float_left">
                            <div class="width50 ">
                                <div class="style6 float_left">Inc. Area Type<span class="md_field">*</span> : </div>
                            </div>
                             <div class="width50 float_left">
                                <select name="inc_area_type" id="inc_area_type" tabindex="8"  class="filter_required" data-errors="{filter_required:'Inc. Area Type should not be blank!'}" data-base="send_sms"> 
                                    <option value="">Select Area Type</option>
                                    <option value="Rural" <?php if($ar_name  == 'Rural'){ echo "selected"; }?>>Rural</option>
                                    <option value="Urban" <?php if($ar_name == 'Urban'){ echo "selected"; }?>>Urban</option>
                                    <option value="Tribal" <?php if($ar_name  == 'Tribal'){ echo "selected"; }?>>Tribal</option>
                                    <option value="Metro/NA" <?php if($ar_name  == 'Metro/NA'){ echo "selected"; }?>>Metro/NA</option>
                                </select>
                            </div>
                        </div><?php } ?>
                    </div> 
                    
                    <div class="width100">
                    <!--<div class="width50 drg float_left">
                        <div class="width32 float_left">
                            <div class="style6 float_left">Case Type <span class="md_field">*</span> : </div>
                        </div>
                        <?php 
                       // var_dump($inc_details);
                        if($user_group == 'UG-BIKE-DCO'){
                          ?>
                          <div class="width50 float_left base_location">
                            <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}"  value="<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="{base_url}auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype" >
                        </div>
                          <?php  
                            
                        }else{
                            ?>
                            <div class="width50 float_left base_location">
                            <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}"  value="<?php echo @$inc_details[0]->provider_casetype;?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="{base_url}auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype" data-callback-funct="remove_mandatory_fields_new">
                        </div>
                            <?php
                        }?>
                           <div class="form_field width100 float_left hide" id='provider_casetype_other'>
                    <div class="style6 float_left">Other Case Type :</div>
                    <div class="width50 float_left base_location">
                    <input name="provider_casetype_other" id="provider_casetype_other_text"   class="form_input" placeholder="Other Case Type"  type="text" value="<?php echo @$inc_details[0]->provider_casetype_other; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div> 
                        
                    </div>-->
                    <?php if($amb_type != 1){  ?>
                    <div class="width50 drg float_left">
                        <div class="width34 float_left">
                            <div class="style6 float_left">Provider Impressions<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left base_location">
                            
                            <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}"  value="<?php echo @$inc_details[0]->provider_impressions;?>" data-value="<?php echo @$inc_details[0]->pro_name; ?>" data-href="{base_url}auto/get_provider_imp_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_impressions" >
                        </div>
                    </div><?php }else{ ?>
                        <div class="width50 drg float_left">
                        <div class="width34 float_left">
                            <div class="style6 float_left">Provider Impressions<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width50 float_left base_location">
                            
                            <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}"  value="<?php echo @$inc_details[0]->provider_impressions;?>" data-value="<?php echo @$inc_details[0]->pro_name; ?>" data-href="{base_url}auto/get_provider_imp_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>&amb_type=<?php echo $amb_type; ?>" data-qr="" id="provider_impressions" >
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($amb_type != 1){  ?>
                    <div class="width50 drg float_left" style="display: flex;">
                    <div class="label">Past Medical History :</div>
                  
                    <div class="input" style="width: 50%;">
                        <?php  $history_data = json_decode($inc_details[0]->ong_past_med_hist);
                            ?>
                        <select name="pt_con_ongoing[Past_medical_history][]" id="pt_con_ongoing_pastmed_his"   class="form_input" multiple="">
                            <?php $medical_history = get_ongoing_past_med_his_list();
                           
                            foreach($medical_history as $history){
                                $selected = '';
                                foreach($history_data as $his){
                                    if($his->id == $history->id){
                                        $selected  = "selected=selcted";
                                    }
                                }
                            ?>
                            
                            <option value="<?php echo $history->id;?>" <?php echo $selected;?>><?php echo $history->name;?></option>
                            <?php } ?>
                            
                        </select>
                           
<!--                    <input name="pt_con_ongoing[Past_medical_history]" id="pt_con_ongoing_pastmed_his"   class="form_input mi_autocomplete" placeholder="Past Medical history" data-href="{base_url}auto/get_ongoing_past_medical_history"  type="text" value="<?php echo @$inc_details[0]->ong_past_med_hist; ?>"  data-value="<?php echo @$inc_details[0]->ong_past_med_hist; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">-->
                    </div>
                </div> <?php } ?>
                    </div>

                    <div class="width100">
                    
                <!--<div class="form_field width50 float_left" style="display: flex;">
                    <div class="label">Chief Complaint<span class="md_field">*</span> :</div>
                    <div class="input" style="width: 50%;">
                    <input name="pt_con_ongoing[chief_comp]" id="pt_con_ongoing_chief_comp"   class="form_input mi_autocomplete filter_required" placeholder="Chief Complaint" data-errors="{filter_required:'Plase select Case type from dropdown list'}" data-href="{base_url}auto/get_chief_complete?patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>"  type="text" value="<?php echo $ct_type; ?>"  data-value="<?php echo $ct_type; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}" data-callback-funct="chief_comp_fields">
                    </div>
                </div>
                  <div class="form_field width50 float_left hide" id='ongoing_chief_comp_other'>
                    <div class="label">Other Chief Complaint :</div>
                    <div class="input" style="width: 50%;">
                    <input name="pt_con_ongoing[other_chief_comp]" id="pt_con_ongoing_chief_comp_other"   class="form_input" placeholder="Chief Complaint"  type="text" value="<?php echo @$inc_details[0]->other_chief_comp; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div> -->      
                
                
                </div>
                
                <div class="width100" id='other_provider_impression'>
                      <?php 
                      
                      if($inc_details[0]->other_provider_img != ''){ ?>
                    <div class="width100">
                        <div class="width100 rec_hp float_left">
                            <div class="style6 float_left">Other Provider Impressions <span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 rec_hp float_left">
                            <input name="other_provider" class="filter_required" value="<?php echo $inc_details[0]->other_provider_img;?>" type="text" tabindex="2" placeholder="Provider Impressions" data-errors="{filter_required:'Provider Impressions should not be blank!'}">
                        </div>
                    </div>
                    <?php } ?>
                     <?php if($kid_details){ ?>
                    <div class="width100 patient_blk display_inlne_block">
                        <div class="single_record_back">                                     
                            <h3>Kids Information  </h3>
                        </div>
                    </div>
                    <div class="row">
                    <div class=" width_30 float_left">
                        <select name="kid[gender]" class="form_input  filter_required"  data-errors="{filter_required:'Please select gender'}" data-base="" tabindex="6">
                            <option value="">Gender</option>
                            <?php echo get_gen_type($kid_details[0]->ptn_gender); ?>
                        </select>
                    </div>

                    <div class=" width_30 float_left">

                    <select name="kid[apgar_score]" class="filter_required" data-errors="{filter_required:'Please select score from dropdown'}" tabindex="18">

                    <option value="">APGAR SCORE</option>

                    <?php echo get_number($kid_details[0]->apgar_score); ?>

                    </select>

                    </div>
                    <div class=" width_30 float_left">
                    <input name="kid[birth_datetime]" tabindex="1" class="form_input mi_timecalender StartDate filter_required" placeholder="Select kids birth date time" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $kid_details[0]->birth_datetime; ?>" readonly="readonly" id="from_date">
                    </div>
                    </div>

                    <div class="row">
                        <textarea class="width_100" rowspan="5" name='kid[birth_remark]' class="filter_required has_error" data-errors="{filter_required:'Remark should not be blank!'}"><?php echo $kid_details[0]->birth_remark; ?></textarea>
                    </div>
                    <?php } ?>
                    
                </div>
                            </div>
                    <?php if($amb_type != 1){ 
                        ?>        
                    <div class="width100">
                    <div class="width100 drg float_left">
                    
                        <div class="width100 float_left">
                        <div class="single_record_back">                                     
                            <h3>Patient Condition At Hospital</h3>
                        </div>
                        </div>

                    </div>
                            </div>
                            <div class="width100">
                <div class="width20 form_field float_left">
                    <div class="label">LOC<span class="md_field">*</span></div>
                    <div class="input">
                        <input name="baseline_con[loc]" tabindex="3" class="mi_autocomplete form_input " placeholder=" LOC " type="text"  data-href="{base_url}auto/loc_level" value="<?php echo @$inc_details[0]->loc; ?>"  data-value="<?php echo @$inc_details[0]->level_type; ?>" id="loc" data-errors="{filter_required:'LOC should not be blank!'}"  >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Airway</div>
                    <div class="input">
                        <input name="baseline_con[airway]"  id="baseline_con_airway" class="form_input mi_autocomplete" placeholder="Select Patient" data-href="{base_url}auto/get_airway" type="text" value="<?php echo @$inc_details[0]->ini_airway; ?>"  data-value="<?php echo @$inc_details[0]->ini_airway; ?>" tabindex="2" >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Breathing</div>
                    <div class="input">
                        <input name="baseline_con[breathing]" id="baseline_con_breathing" class="form_input mi_autocomplete" placeholder="Select Patent" data-href="{base_url}auto/get_breathing" type="text" value="<?php echo @$inc_details[0]->ini_breathing; ?>"  data-value="<?php echo @$inc_details[0]->ini_breathing; ?>" tabindex="2" >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Circulation</div>
                    <div class="input">
                    <input name="baseline_con[circulation_radial]" id="baseline_con_circulation_radial"   class="form_input mi_autocomplete" placeholder="Radial" data-href="{base_url}auto/get_pa_opt"  type="text" value="<?php echo @$inc_details[0]->ini_con_circulation_radial; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_circulation_radial; ?>" tabindex="6" >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">&nbsp;</div>
                    <div class="input">
                    <input name="baseline_con[circulation_carotid]" id="baseline_con_circulation_carotid"   class="form_input mi_autocomplete" placeholder="Carotid" data-href="{base_url}auto/get_pa_opt"  type="text" value="<?php echo @$inc_details[0]->ini_con_circulation_carotid; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_circulation_carotid; ?>" tabindex="7" >
                    </div>
                </div>
                </div>
                
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">Temp</div>
                    <div class="input">
                        <input  maxlength="5" name="baseline_con[temp]" id="baseline_con_temp" value="<?php echo @$inc_details[0]->ini_con_temp; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_temp; ?>"  class="inp_bp form_input filter_if_not_blank filter_float " placeholder="82 to 110"  type="text" tabindex="19" data-errors="{filter_float:'enter valid data'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">Pulse</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[pulse]" value="<?php echo @$inc_details[0]->ini_cir_pulse_p_txt; ?>"  data-value="<?php echo @$inc_details[0]->ini_cir_pulse_p_txt; ?>"  class="form_input" placeholder="Enter Pulse"  type="text"  tabindex="7">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">RR</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[rr]" id="baseline_con_rr" value="<?php echo @$inc_details[0]->ini_con_rr; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_rr; ?>" class="form_input" placeholder="Enter RR" type="text"  tabindex="15" >
                    </div>
                </div>
                
                <div class="form_field width20 float_left">
                    <div class="label">BP</div>
                    <div class="input top_left">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[bp_syt]" id="baseline_con_bp_syt" value="<?php echo @$inc_details[0]->ini_bp_sysbp_txt; ?>"  data-value="<?php echo @$inc_details[0]->ini_bp_sysbp_txt; ?>" class="inp_bp form_input " placeholder="SYT"  type="text" tabindex="16" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label none_prop">&nbsp;</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[bp_dia]" id="baseline_con_bp_dia" value="<?php echo @$inc_details[0]->ini_bp_dysbp_txt; ?>"  data-value="<?php echo @$inc_details[0]->ini_bp_dysbp_txt; ?>" class="inp_bp form_input " placeholder="Dia"  type="text" tabindex="17" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">BSL</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[bsl]" value="<?php echo @$inc_details[0]->ini_con_bsl; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_bsl; ?>" class="form_input" placeholder="Enter BSL"   type="text" tabindex="11">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">O2Sat</div>
                    <div class="input">
                         <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[osat]" id="baseline_con_osat" value="<?php echo @$inc_details[0]->ini_oxy_sat_get_nf_txt; ?>"  data-value="<?php echo @$inc_details[0]->ini_oxy_sat_get_nf_txt; ?>"  class="inp_bp form_input" placeholder="1 To 100"  type="text" tabindex="18" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">GCS</div>
                    <div class="input top_left">
                        <input name="baseline_con[gcs]" id="baseline_con_gcs"  class="form_input mi_autocomplete " placeholder="Score" data-href="{base_url}auto/gcs_score">
                    </div>
                </div>
               
               
                <div class="form_field width20 float_left">
                    <div class="label disnon">Skin</div>
                    <div class="input">
                        <input name="baseline_con[skin]" id="baseline_con_skin"  class="form_input mi_autocomplete" placeholder="Skin" data-href="{base_url}auto/get_pulse_skin"   type="text" value="<?php echo @$inc_details[0]->ini_con_skin; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_skin; ?>" tabindex="9" >
                    </div>
                </div>
                
                 <div class="form_field width20 float_left">
                    <div class="label">Respiration Sound</div>
                    <div class="input">
                    <input name="baseline_con[ini_respiression]" id="baseline_respiression" class="form_input mi_autocomplete" placeholder="respiration Sound" data-href="{base_url}auto/respiration_type" type="text" value="<?php echo @$inc_details[0]->ini_respiression; ?>" data-value="<?php echo @$inc_details[0]->ini_respiression; ?>" tabindex="12" >
                    </div>
                 </div>
                 </div>
                 <div class="width100">
                 <div class="form_field width20 float_left">
                    <div class="label">Pupils</div>
                    <div class="input">
                    <input name="baseline_con[pupils_left]" id="baseline_con_pupils"   class="form_input mi_autocomplete" placeholder="left" data-href="{base_url}auto/pupils_type"  type="text" value="<?php echo @$inc_details[0]->ini_con_pupils; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_pupils; ?>" tabindex="12" >
                    </div>
                 </div>   
                 <div class="form_field width20 float_left">
                    <div class="label">&nbsp;</div>
                    <div class="input">
                    <input name="baseline_con[pupils_right]" id="baseline_con_pupils_right"   class="form_input mi_autocomplete" placeholder="Right" data-href="{base_url}auto/pupils_type"  type="text" value="<?php echo @$inc_details[0]->ini_con_pupils_right; ?>"  data-value="<?php echo @$inc_details[0]->ini_con_pupils_right; ?>" tabindex="12" >
                    </div>
                 </div> 
                 <div class="width20 form_field float_left">
                    <div class="label">Capillary Refill < 2sec</div>
                    <div class="input">
                        <input name="baseline_con[caprefil]" id="baseline_con_caprefil" class="form_input mi_autocomplete" placeholder="Select CapRefill" data-href="{base_url}auto/get_yesno_opt" type="text" value="<?php echo @$inc_details[0]->ini_cir_cap_refill_tsec; ?>"  data-value="<?php echo @$inc_details[0]->ini_cir_cap_refill_tsec; ?>" tabindex="2" >
                    </div>
                </div>
                    </div>     <?php } ?> 
                    <?php if($amb_type != 1){  ?>
                <div class="width100">
                    <div class="width100 drg float_left">
                    <div class="single_record_back">     
                            <div class="style6 float_left">Drugs and consumables used </div>
                        </div>
                       
                    </div>


                    <div class="width100 float_left">
                        <div class="width33 float_left non_unit_drags">

<!--                          <input name="non_unit_drags" tabindex="22" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_non_unit_box()">-->
                            <input name="non_unit_drags" id="non_unit_drags" tabindex="7" class="form_input" placeholder="Injury" type="text" data-base="search_btn" data-errors="{filter_required:'Injury used should not be blank!'}" readonly="readonly">
                            <div id="non_unit_drugs_box">

                                <?php
                                $med_inv_data[0] = array();

                                if ($pcr_na_med_inv_data) {


                                    foreach ($pcr_na_med_inv_data as $pcr_med) {
                                        //var_dump($pcr_med);

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">

                                    <?php if ($injury_list) { ?>
                                        <ul class="width100">
                                            <li class="unit_block" id="non_unit_other">
                                                <label for="injury_na" class="chkbox_check">


                                                    <input type="checkbox" name="injury['NA'][id]" class="check_input unit_checkbox" value="NA"  id="injury_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>
                                            <?php foreach ($injury_list as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="inj_<?php echo $item->inj_id; ?>" class="chkbox_check">
                                                        <input type="checkbox" name="injury[<?php echo $item->inj_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->inj_id; ?>" id="inj_<?php echo $item->inj_id; ?>" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->inj_id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="inj_iteam" onclick="show_injury_box();">
                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->inj_name); ?><br>
                                                    </label>
                                                    <div class="unit_div">
                                                        <input type="hidden" name="injury[<?php echo $item->inj_id; ?>][type]" value="INJ" class="width50" data-base="inj_iteam">
                                                    </div>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                        <input name="inj_iteam" id="show_injury_box_selected" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_injury_drugs" data-qr="output_position=content" type="button">
                                    <?php } ?>
                                </div>


                            </div>  
                            <div style="width:95%" id="selected_injury_box_view">
                            </div>
                        </div>
                        <div class="width33   float_left non_unit_drags">

<!--                          <input name="non_unit_drags" tabindex="22" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_non_unit_box()">-->
                            <input name="non_unit_drags" id= "non_unit_drags_intervenrion" tabindex="7" class="form_input" placeholder="Intervention" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" readonly="readonly">
                            <div id="non_unit_drugs_box">

                                <?php
                                $med_inv_data[0] = array();

                                if ($pcr_na_med_inv_data) {


                                    foreach ($pcr_na_med_inv_data as $pcr_med) {
                                        //var_dump($pcr_med);

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">

                                    <?php if ($intervention_list) { ?>
                                        <ul class="width100">
                                            <li class="unit_block" id="non_unit_other">
                                                <label for="intervention_na" class="chkbox_check">


                                                    <input type="checkbox" name="intervention['NA'][id]" class="check_input unit_checkbox" value="NA"  id="intervention_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>
                                            <?php foreach ($intervention_list as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="int_<?php echo $item->int_id; ?>" class="chkbox_check">
                                                        <input type="checkbox" name="intervention[<?php echo $item->int_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->int_id; ?>" id="int_<?php echo $item->int_id; ?>" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->int_id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="int_iteam" onclick="show_intervention_box();">
                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->int_name); ?><br>
                                                    </label>
                                                    <div class="unit_div">
                                                        <input type="hidden" name="intervention[<?php echo $item->int_id; ?>][type]" value="INT" class="width50" data-base="int_iteam">
                                                    </div>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                        <input name="int_iteam" id="show_intervention_box_selected" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_intervention_drugs" data-qr="output_position=content" type="button">
                                    <?php } ?>
                                </div>


                            </div>  
                            <div style="width:95%" id="selected_intervention_box_view">
                            </div>
                        </div>
                        <div class="width33  float_left unit_drags">

<!--                        <input name="unit_drags" tabindex="21" class="form_input" placeholder="Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_unit_box()">-->
                            <input name="unit_drags"  id="unit_drags" tabindex="6" class="form_input unit_drags_input" placeholder="Medication" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" readonly="readonly">

                            <div id="unit_drugs_box">

                                <?php
                                //  var_dump($pcr_med_inv_data);
                                if ($pcr_med_inv_data) {
                                    $med_inv_data = array();


                                    foreach ($pcr_med_inv_data as $pcr_med) {

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                if ($pcr_med_data) {
                                    $med_data = array();


                                    foreach ($pcr_med_data as $pcr_med) {

                                        $med_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">
                                    <ul class="width100">
                                        <?php if ($med_list) { ?>
                                            <li class="unit_block" id="unit_other">
                                                <label for="unit_na" class="chkbox_check">


                                                    <input type="checkbox" name="med['NA'][id]" class="check_input unit_checkbox" value="NA"  id="unit_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>

                                            <?php foreach ($med_list as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_M<?php echo $item->med_id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="med[<?php echo $item->med_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->med_id; ?>"  id="unit_M<?php echo $item->med_id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_data) && array_key_exists($item->med_id, $med_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->med_title); ?><br>
                                                    </label>
                                        <!--            <input type="checkbox" value="<?php echo $item->med_id ?>" name="unit[<?php echo $item->med_id; ?>][id]" class="unit_checkbox"><?php echo $item->med_title; ?><br>-->
                                                    <?php if (isset($med_data[$item->med_id])) {
                                                        ?>
                                                        <div class="unit_div">
                                                            <input type="text" name="med[<?php echo $item->med_id; ?>][value]" value="<?php echo $med_data[$item->med_id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_unit_box();">
                                                            <input type="hidden" name="med[<?php echo $item->med_id; ?>][type]" value="MED" class="width50" data-base="unit_iteam" >
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="unit_div hide">
                                                            <input type="text" name="med[<?php echo $item->med_id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_unit_box();">
                                                            <input type="hidden" name="med[<?php echo $item->med_id; ?>][type]" value="MED" class="width50" data-base="unit_iteam">
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                <input name="unit_iteam" id="show_unit_box_selected" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_unit_drugs" data-qr="output_position=content" type="button">
                                    </ul>

                                </div>
                                <div id="show_selected_unit_item" style="width:95%">
                                </div>



                            </div>  

                        </div>
                                <?php 
        
        if ($media) {
          //  var_dump($media);
            foreach($media as $img) {
                
                $name = $img->media_name;
                   $pic_path = FCPATH . "api/incidentData/" . $name;
                  // echo $pic_path;

                                                    if (file_exists($pic_path)) {
                                                        $pic_path1 = base_url() . "api/incidentData/" . $name;
                                                    }
                                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
     <div class="images_block" id="image_<?php echo $img->id;?>">
                                               <?php 
                                      if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
                                  
                                      <?php } ?>
                                        <a class="ambulance_photo float_left" target="blank" href="<?php
                                    if (file_exists($pic_path)) {
                                        echo $pic_path1;
                                    } else {
                                        echo $blank_pic_path;
                                    }
                                    ?>" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>

 </div>
        <?php } } ?>
                        
                       
                    </div>
                    <div class="width100 float_left">
                         <div class="width33  float_left unit_drags">

<!--                        <input name="unit_drags" tabindex="21" class="form_input" placeholder="Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_unit_box()">-->
                            <input name="unit_drags" id="unit_drags_consum" tabindex="6" class="form_input unit_drags_input" placeholder="Consumables" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" readonly="readonly">

                            <div id="unit_drugs_box">

                                <?php
                                //  var_dump($pcr_med_inv_data);
                                if ($pcr_med_inv_data) {
                                    $med_inv_data = array();


                                    foreach ($pcr_med_inv_data as $pcr_med) {

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                if ($pcr_med_data) {
                                    $med_data = array();


                                    foreach ($pcr_med_data as $pcr_med) {

                                        $med_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">
                                    <ul class="width100">
                                        <?php if ($invitem) { ?>
                                            <li class="unit_block" id="unit_other">
                                                <label for="unit_na" class="chkbox_check">


                                                    <input type="checkbox" name="unit['NA'][id]" class="check_input unit_checkbox" value="NA"  id="unit_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>

                                            <?php foreach ($invitem as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $item->inv_id; ?>" class="chkbox_check">


                                                        <input type="checkbox" name="unit[<?php echo $item->inv_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->inv_id; ?>"  id="unit_<?php echo $item->inv_id; ?>" onclick="GetCheckedUnit(this);" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->inv_id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->inv_title); ?><br>
                                                    </label>
                                        <!--            <input type="checkbox" value="<?php echo $item->med_id ?>" name="unit[<?php echo $item->inv_id; ?>][id]" class="unit_checkbox"><?php echo $item->inv_title; ?><br>-->
                                                    <?php if (isset($med_inv_data[$item->inv_id])) {
                                                    ?>
                                              <div class="unit_div">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->inv_id; ?>][value]" value="<?php echo $med_inv_data[$item->inv_id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_ca_unit_box();">
                                                                                                                                                            <input type="hidden" name="unit[<?php echo $item->inv_id; ?>][type]" value="<?php echo $item->inv_type; ?>" class="width50" data-base="unit_iteam" >
                                                                                                                                                        </div>
                                                    <?php } else { ?>
                                              <div class="unit_div hide">
                                                                                                                                                            <input type="text" name="unit[<?php echo $item->inv_id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_ca_unit_box();">
                                                                                                                                                            <input type="hidden" name="unit[<?php echo $item->inv_id; ?>][type]" value="<?php echo $item->inv_type; ?>" class="width50" data-base="unit_iteam">
                                                                                                                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>


                                        <?php } ?>
                                                <input name="unit_iteam" id="show_unit_box_selected_ca" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_unit_drugs_ca" data-qr="output_position=content" type="button">
                                    </ul>

                                </div>
                                <div id="show_selected_unit_item_ca" style="width:95%">
                                </div>



                            </div>  

                        </div>
                        <div class="width33  float_left non_unit_drags">

<!--                          <input name="non_unit_drags" tabindex="22" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_non_unit_box()">-->
                            <input name="non_unit_drags" tabindex="7" class="form_input" placeholder="Non Consumables" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" readonly="readonly">
                            <div id="non_unit_drugs_box">

                                <?php
                                $med_inv_data[0] = array();

                                if ($pcr_na_med_inv_data) {


                                    foreach ($pcr_na_med_inv_data as $pcr_med) {
                                        //var_dump($pcr_med);

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">

                                    <?php if ($noninvitem) { ?>
                                        <ul class="width100">
                                            <li class="unit_block" id="non_unit_other">
                                                <label for="non_unit_na" class="chkbox_check">


                                                    <input type="checkbox" name="non_unit['NA'][id]" class="check_input unit_checkbox" value="NA"  id="non_unit_na" data-base="unit_iteam">


                                                    <span class="chkbox_check_holder"></span>Other<br>
                                                </label>
                                            </li>
                                            <?php foreach ($noninvitem as $item) { ?>
                                                <li class="unit_block">
                                                    <label for="unit_<?php echo $item->inv_id; ?>" class="chkbox_check">
                                                        <input type="checkbox" name="non_unit[<?php echo $item->inv_id; ?>][id]" class="check_input unit_checkbox" value="<?php echo $item->inv_id; ?>" id="unit_<?php echo $item->inv_id; ?>" <?php
                                                        if (is_array($med_inv_data) && array_key_exists($item->inv_id, $med_inv_data)) {
                                                            echo "checked";
                                                        }
                                                        ?> data-base="non_unit_iteam" onclick="show_non_unit_box();">
                                                        <span class="chkbox_check_holder"></span><?php echo stripslashes($item->inv_title); ?><br>
                                                    </label>
                                                    <div class="unit_div">
                                                        <input type="hidden" name="non_unit[<?php echo $item->inv_id; ?>][type]" value="<?php echo $item->inv_type; ?>" class="width50" data-base="non_unit_iteam">
                                                    </div>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                        <input name="non_unit_iteam" id="show_non_unit_drugs_box" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_non_unit_drugs" data-qr="output_position=content" type="button">
                                    <?php } ?>
                                </div>


                            </div>  
                            <div style="width:95%" id="selected_non_unit_drugs_view">
                            </div>

                        </div>

                    </div>
                </div>
                <?php } ?>
                <div class="width100 float_left">
                    <div class="width50 float_left">
                        <div id="show_other_unit">
                        </div>
                    </div>
                    <div class="width50 float_left">
                        <div id="show_non_unit_other">
                        </div>
                    </div>
                </div> 
                
                <?php 

                if($user_group == 'UG-BIKE-DCO'){ ?>
<div class="width100">
                    <div class="width100 rec_hp float_left">
                        <div class="style6 float_left">Destination Hospital<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width100 rec_hp float_left">
                        <input name="inter[new_facility]" tabindex="7.2" class="mi_autocomplete form_input filter_required" placeholder="Destination Hospital" type="text" data-base="send_sms" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?php echo @$inc_details[0]->hp_name; ?>" value="<?php echo @$inc_details[0]->hp_id; ?>" id="receiving_host" data-callback-funct="hospital_other_textbox">
                    </div>
                    <div id="other_hospital_textbox">
                         <?php if($inc_details[0]->other_receiving_host != ''){ ?>
                        <div class="width100">
                            <div class="width100 rec_hp float_left">
                                <div class="style6 float_left">Name of Other Receiving Hospital/Ambulance<span class="md_field">*</span> :</div>
                            </div>
                            <div class="width100 rec_hp float_left">
                                   <input name="other_receiving_host" class="filter_required" value="" type="text" tabindex="2" placeholder="Name of Other Receiving Hospital/Ambulance" data-errors="{filter_required:'Name of Other Receiving Hospital/Ambulance should not be blank!'}">
                            </div>
                        </div>
                         <?php } ?>
                    </div>
                    <div class="width100 float_left">
                        <input type="button" name="send_sms" data-href="{base_url}pcr/send_hospital_sms" value="Send SMS" data-qr='output_position=inc_details' class="base-xhttp-request btn">
                    </div>
                    

                </div>
<div class="width100 dr_para">
                    <h3>Driver Parameters : </h3>
                    
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Call received<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            
                            <input name="call_rec_time" tabindex="14" class="form_input filter_required filter_time_hm " placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Call received should not be blank!',filter_time_hms:'Please enter valid time(H:i)'}" value="<?php echo date("H:i", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly" >
                        </div>
                    </div>
                  
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Start From Base: </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="start_from_base" tabindex="20" class="form_input EndDate filter_required" placeholder="H:i" type="text" value="<?php if(isset($driver_data[0]->start_from_base)){  date('H:i',strtotime($driver_data[0]->start_from_base)); }else{ echo $inc_details_data[0]->inc_datetime; } ?>"  data-errors="{filter_required:'Start From Base should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly"  >
                        </div>
                    </div>
              
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="at_scene" tabindex="15" class="form_input filter_if_not_blank EndDate filter_required" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php if(isset($driver_data[0]->dp_on_scene)){  echo date('H:i:s',strtotime($driver_data[0]->dp_on_scene)); } ?>"  readonly="readonly" >
                        </div>
                    </div>
                    <?php 
                    $responce_time_remark = '';
                    $hide_remark = 'hide';
                 
                    if($driver_data[0]->responce_time_remark != ''){ 
                        $responce_time_remark = get_responce_time_remark($driver_data[0]->responce_time_remark);                        $hide_remark = '';
                        
                    }
                      
                    ?>
                    <div class="width100 float_left">
                        <div class="width50 drg float_left <?php echo $hide_remark ;?>" id="responce_time_remark">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Remark<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                 <input type="text"  name="responce_time_remark" id="responce_remark" data-value="<?php echo $responce_time_remark ;?>" value="<?php echo $driver_data[0]->responce_time_remark ;?>" class="mi_autocomplete"  data-href="{base_url}auto/get_responce_time_remark"  placeholder="Remark" data-callback-funct="responce_remark_change" TABINDEX="8" data-errors="{filter_required:'Remark should not be blank!'}" >
                                 
                            </div>
                        </div>
                           <?php 
                   
                    $hide_remark_other = 'hide';
                  
                    if($driver_data[0]->responce_time_remark_other != ''){ 
                        $hide_remark_other = '';
                        
                    } ?>
                           <div class="width50 drg float_left <?php echo $hide_remark_other;?>" id="responce_time_remark_other">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Other Remark<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="responce_time_remark_other" tabindex="19" class=" form_input" placeholder="Remark" type="text" data-base="search_btn" value="<?php if(isset($driver_data[0]->responce_time_remark_other)){ echo $driver_data[0]->responce_time_remark_other; }?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" >
                            </div>
                        </div>
                    </div>


                </div>
                <div class="width100">

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">From Scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="from_scene" tabindex="16" class="form_input filter_if_not_blank EndDate " placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'From Scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php if(isset($driver_data[0]->dp_reach_on_scene)){ echo date('H:i',strtotime($driver_data[0]->dp_reach_on_scene)); } ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At Hospital/ Ambulance <span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class="form_input filter_required filter_if_not_blank EndDate " placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  value="<?php if(isset($driver_data[0]->dp_hosp_time)){ echo date('H:i',strtotime($driver_data[0]->dp_hosp_time)); } ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Hand over : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="hand_over" tabindex="18" class="form_input filter_if_not_blank EndDate " placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'Hand over  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php if(isset($driver_data[0]->dp_hand_time)){  echo date('H:i',strtotime($driver_data[0]->dp_hand_time)); } ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Back to base<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="back_to_base" tabindex="19" class="filter_required form_input EndDate " placeholder="H:i" type="text" data-base="search_btn" value="<?php if(isset($driver_data[0]->dp_back_to_loc)){ echo date('H:i',strtotime($driver_data[0]->dp_back_to_loc)); }?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly">
                        </div>
                    </div>

            
                </div>
                <?php }else{ ?>
<div class="width100">
                    <div class="float_left width_25">

                        <div class="style6 float_left">District<span class="md_field">*</span>&nbsp;</div>
                        
                        <?php
                        $hospital_district_name = '';
                        if($inc_details[0]->hospital_district != ''){
                            $hospital_district_name  = get_district_by_id($inc_details[0]->hospital_district);
                        }else{
                             $inc_details[0]->hospital_district = $inc_details[0]->inc_district_id;
                              $hospital_district_name  = get_district_by_id($inc_details[0]->inc_district_id);
                        }
                        
                        ?>
                          <?php
                          
                        $hospital_name = '';
                      
                        if($inc_details[0]->rec_hospital_name != ''){
                            if($inc_details[0]->rec_hospital_name == 'Patient_Not_Available'){
                                $hospital_name = 'Patient Not Available';
                            }else if($inc_details[0]->rec_hospital_name == 'on_scene_care'){
                                 $hospital_name = 'On Scene Care';
                            }else if($inc_details[0]->rec_hospital_name == 'at_scene_care'){
                                 $hospital_name = 'At Scene Care';
                            }else{
                                
                              
                                $hospital_data  = get_hospital_by_id($inc_details[0]->rec_hospital_name);
                                
                                
                                $hospital_name  = $hospital_data[0]->hp_name;
                               
                                if($inc_details[0]->hospital_district != '' && $hospital_district_name == ''){
                                    $hospital_district_name  = get_district_by_id($hospital_data[0]->hp_district);
                                }
                                if($inc_details[0]->hospital_district == '' && $hospital_name != ''){
                                    $hospital_district_name  = get_district_by_id($hospital_data[0]->hp_district);
                                    $inc_details[0]->hospital_district = $hospital_data[0]->hp_district;
                                }
                            }
                            
                        }
                        ?>
                        
                        <input id="pcr_district" name="pcr_district" tabindex="9" class="form_input mi_autocomplete filter_required" data-href="{base_url}auto/get_district/MP" placeholder="District" type="text" data-nonedit="yes" data-errors="{filter_required:'Please select New District from dropdown list'}" data-callback-funct="district_wise_hospital_epcr" value="<?php echo $inc_details[0]->hospital_district;?>" data-value="<?php echo $hospital_district_name;?>" >


                    </div>
                   
                    <div class="float_left width_52">
                        <?php if($inc_type == 'DROP_BACK'){ ?>
                        <div class="style6 float_left">Source Hospital<span class="md_field">*</span>&nbsp;</div>
                        <?php }else{
                            ?>
                        <div class="style6 float_left">Destiination Hospital<span class="md_field">*</span>&nbsp;</div>   
                            <?php
                        } ?>
                        <div class="input" id="new_facility_box">
                            
                           

                            <input name="inter[new_facility]" id="receiving_host" class="filter_required mi_autocomplete width100" placeholder="Destination Hospital" data-href="{base_url}auto/get_auto_hospital_new?district_id=<?php echo $inc_details[0]->hospital_district;?>" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Destination Hospital should not be blank'}" id="current_facility" TABINDEX="13" data-callback-funct="hospital_other_textbox" value="<?php echo $inc_details[0]->rec_hospital_name;?>" data-value="<?php echo $hospital_name;?>"> 
                            

                        </div>

                    </div>
                    
<!--                    <div class="width_30 rec_hp float_left">
                        <div class="style6 float_left">Name of Receiving Hospital<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width_52 rec_hp float_left">
                        <?php
                        if ($inc_details[0]->hp_id == '') {
                            $inc_details[0]->hp_id = $inc_details[0]->rec_hospital_name;
                            $inc_details[0]->hp_name = $inc_details[0]->rec_hospital_name;
                        }
                        ?>

                    </div>-->
                    <div id="other_hospital_textbox">
                        <?php if (@$inc_details[0]->other_receiving_host != '') { ?>
                            <div class="width100">
                                <div class="width100 rec_hp float_left">
                                    <div class="style6 float_left">Name of Other Receiving Hospital/Ambulance<span class="md_field">*</span> :</div>
                                </div>
                                <div class="width100 rec_hp float_left ">
                                    <input name="other_receiving_host" class="filter_required " value="<?php echo $inc_details[0]->other_receiving_host; ?>" type="text"  placeholder="Name of Other Receiving Hospital/Ambulance" data-errors="{filter_required:'Name of Other Receiving Hospital/Ambulance should not be blank!'}" autocomplete="off">
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="width100">
                        <?php 
                        if($inc_type == 'DROP_BACK'){
                            $drop_district_name  = get_district_by_id($dropback_details[0]->home_district_id);
                            ?>
                            <div class="float_left width_25">
                            <div class="style6 float_left">Home District&nbsp;</div>
                            <div class="input" id="new_facility_box">
                                <input name="drop_district" id="drop_district" data-href="{base_url}auto/get_district_by_name/MP" class="mi_autocomplete width100" placeholder="Select District"  type="text"  id="drop_district" TABINDEX="13" value="<?php echo $drop_district_name;?>" data-value="<?php echo $drop_district_name; ?>"> 
                            </div>
                            </div>
                             <div class="float_left width_52">
                            <div class="style6 float_left">Home Address&nbsp;</div>
                            <div class="input" id="new_facility_box">
                                <input  name="drop_home_address" id="drop_home_address" class="width100" placeholder="Enter Home Address"  type="text"  id="drop_home_address" TABINDEX="13" value="<?php echo $dropback_details[0]->home_address;?>" > 
                            </div>
                            </div>
                            <?php
                        }
                        if($inc_type == 'IN_HO_P_TR'){
                           
                        ?>
                        <div class="float_left width_30">
                        <div class="style6 float_left">Current Facility&nbsp;</div>
                        <div class="input" id="new_facility_box">
                            <input disabled name="current_facility" id="current_facility" class="mi_autocomplete width100" placeholder="Select Hospital" data-href="{base_url}auto/get_auto_hospital_new?district_id=<?php echo $inter_facility_details[0]->current_district;?>" type="text"  id="current_facility" TABINDEX="13" value="<?php echo $inter_facility_details[0]->current_facility;?>" data-value="<?php echo $inter_facility_details[0]->current_facility;?>"> 
                        </div>
                        </div>
                        <div class="float_left width_30">
                        <div class="style6 float_left">New Facility&nbsp;</div>
                        <div class="input" id="new_facility_box">
                            <input disabled name="new_facility" id="new_facility" class="mi_autocomplete width100" placeholder="Select Hospital" data-href="{base_url}auto/get_auto_hospital_new?district_id=<?php echo $inter_facility_details[0]->new_district;?>" type="text"  id="new_facility" TABINDEX="13" value="<?php echo $inter_facility_details[0]->new_facility;?>" data-value="<?php echo $inter_facility_details[0]->new_facility;?>"> 
                        </div>
                        </div>
                        <?php

                        } ?>
                    </div>
                    <div class="width_16 float_left">
                        <input type="button" name="send_sms" data-href="{base_url}pcr/send_hospital_sms" value="Send SMS" data-qr='output_position=inc_details' class="base-xhttp-request btn hide" style="width:92%;">
                    </div>


                </div>
            </div>




            <div class="width50 float_left">
            <?php 
             if($amb_type != 1){ 
            if($reopen == 'y'){ ?>
            <div class="width100">
                    <div class="width100 drg float_left">
                    
                        <div class="width100 float_left">
                        <div class="single_record_back">                                     
                            <h3>Patient Condition Ongoing</h3>
                        </div>
                        </div>

                    </div>
                            </div>
                
                
                <div class="width100">
               
                <div class="form_field width25 float_left">
                    <div class="label">Allergy</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_ongoing[allergy]"  id="pt_con_ongoing_allergy"  value="<?php echo @$inc_details[0]->ong_ph_allergy; ?>"  data-value="<?php echo @$inc_details[0]->ong_ph_allergy; ?>"  class="form_input" placeholder="Allergy"  type="text"  tabindex="7">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Vetilator Support with BVM</div>
                    <div class="input">
                    <input name="pt_con_ongoing[vent_sup_bvm]" id="pt_con_ongoing_vent_sup_bvm"   class="form_input mi_autocomplete" placeholder="Vetilator support in BVM" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_ven_supp_bvm; ?>"  data-value="<?php echo @$inc_details[0]->ong_ven_supp_bvm; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                
                
                <div class="form_field width25 float_left">
                    <div class="label">Oral intake</div>
                    <div class="input">
                    <input name="pt_con_ongoing[oral_intake]" id="pt_con_ongoing_oral_intake"   class="form_input mi_autocomplete" placeholder="Oral Intake" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_ph_last_oral_intake; ?>"  data-value="<?php echo @$inc_details[0]->ong_ph_last_oral_intake; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Suction</div>
                    <div class="input">
                    <input name="pt_con_ongoing[pt_con_ongoing_suction]" id="suction"   class="form_input mi_autocomplete" placeholder="Sction" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_suction; ?>"  data-value="<?php echo @$inc_details[0]->ong_suction; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Positioning of the Airway</div>
                    <div class="input">
                    <input name="pt_con_ongoing[airway]" id="pt_con_ongoing_airway"   class="form_input mi_autocomplete" placeholder="Posioning of Airway" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_pos_airway; ?>"  data-value="<?php echo @$inc_details[0]->ong_pos_airway; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Scoop Stretcher</div>
                    <div class="input">
                    <input name="pt_con_ongoing[scoop_stretcher]" id="pt_con_ongoing_scoop_stretcher"   class="form_input mi_autocomplete" placeholder="Scoope Strechture" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_scoop_stretcher; ?>"  data-value="<?php echo @$inc_details[0]->ong_scoop_stretcher; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                
                
                
                <div class="form_field width25 float_left">
                    <div class="label">Stretcher</div>
                    <div class="input">
                    <input name="pt_con_ongoing[stretcher]" id="pt_con_ongoing_stretcher"   class="form_input mi_autocomplete" placeholder="Stretcher" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_stretcher; ?>"  data-value="<?php echo @$inc_details[0]->ong_stretcher; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Wheelchair</div>
                    <div class="input">
                    <input name="pt_con_ongoing[wheelchair]" id="pt_con_ongoing_wheelchair"   class="form_input mi_autocomplete" placeholder="Wheelchair" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_wheelchair; ?>"  data-value="<?php echo @$inc_details[0]->ong_wheelchair; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Spine Board</div>
                    <div class="input">
                    <input name="pt_con_ongoing[spine_board]" id="pt_con_ongoing_spine_board"   class="form_input mi_autocomplete" placeholder="Spine Board" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_spine_board; ?>"  data-value="<?php echo @$inc_details[0]->ong_spine_board; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Event leading to incident</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_ongoing[event_leading_to_inc]" id="pt_con_ongoing_event_leading_to_inc" value="<?php echo @$inc_details[0]->ong_ph_event_led_inc; ?>"  data-value="<?=@$inc_details[0]->ong_ph_event_led_inc; ?>" class="form_input" placeholder="Event leading to incident" type="text"  tabindex="15" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                
                
              
                <div class="form_field width25 float_left">
                    <div class="label">On Medication</div>
                    <div class="input">
                    <input name="pt_con_ongoing[on_medication]" id="pt_con_ongoing_on_medication"   class="form_input mi_autocomplete" placeholder="On Medication" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_medication; ?>"  data-value="<?=@$inc_details[0]->ong_medication; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Supplemental oxygen therapy</div>
                    <div class="input">
                    <input name="pt_con_ongoing[supplemental_oxy_thrpy]" id="pt_con_ongoing_supplemental_oxy_thrpy"   class="form_input mi_autocomplete" placeholder="Supplemental oxygen therapy" data-href="{base_url}auto/get_ongoing_option"  type="text" value="<?php echo @$inc_details[0]->ong_supp_oxy_thp; ?>"  data-value="<?php echo @$inc_details[0]->ong_supp_oxy_thp; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
            </div>
            <?php } }
            
            if($amb_type != 1){ 
            ?>
                <div class="width100">
                    <div class="width100 drg float_left">
                    
                        <div class="width100 float_left">
                        <div class="single_record_back">                                     
                            <h3>Patient Condition At Scene</h3>
                        </div>
                        </div>

                    </div>
                            </div>
                <div class="width100">
                <div class="width20 form_field float_left">
                    <div class="label">LOC</div>
                    <div class="input">
                        <?php if($inc_details[0]->hc_loc != ''){
                            $hc_loc_name = get_loc_level($inc_details[0]->hc_loc );
                                }
                            ?>
                        
                        <input name="pt_con_handover[loc]" tabindex="3" class="mi_autocomplete form_input" placeholder=" LOC " type="text" data-base="search_btn"  data-href="{base_url}auto/loc_level" value="<?php echo @$inc_details[0]->hc_loc; ?>"  data-value="<?php echo @$hc_loc_name; ?>" id="loc_handover" >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Airway</div>
                    <div class="input">
                        <input name="pt_con_handover[airway]"  id="pt_con_handover_airway" class="form_input mi_autocomplete" value="<?php echo @$inc_details[0]->hc_airway; ?>"  data-value="<?php echo @$inc_details[0]->hc_airway; ?>" placeholder="Select Airway" data-href="{base_url}auto/get_airway" type="text" tabindex="2">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Breathing</div>
                    <div class="input">
                        <input name="pt_con_handover[breathing]" id="pt_con_handover_breathing" class="form_input mi_autocomplete" value="<?php echo @$inc_details[0]->hc_breathing; ?>"  data-value="<?php echo @$inc_details[0]->hc_breathing; ?>" placeholder="Select Breathing" data-href="{base_url}auto/get_breathing" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Circulation</div>
                    <div class="input">
                    <input name="pt_con_handover[circulation_radial]" id="pt_con_handover_circulation_radial"   class="form_input mi_autocomplete" placeholder="Radial" data-href="{base_url}auto/get_pa_opt"  type="text" value="<?php echo @$inc_details[0]->hc_con_circulation_radial; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_circulation_radial; ?>" tabindex="6" >
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">&nbsp;</div>
                    <div class="input">
                    <input name="pt_con_handover[circulation_carotid]" id="pt_con_handover_circulation_carotid"   class="form_input mi_autocomplete" placeholder="Carotid" data-href="{base_url}auto/get_pa_opt"  type="text" value="<?php echo @$inc_details[0]->hc_con_circulation_carotid; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_circulation_carotid; ?>" tabindex="7" >
                    </div>
                </div>
                </div>
                
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">Temp</div>
                    <div class="input">
                        <input  maxlength="5" name="pt_con_handover[temp]"  id="pt_con_handover_temp" value="<?php echo @$inc_details[0]->hc_con_temp; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_temp; ?>"  class="inp_bp form_input" placeholder="82 to 110"  type="text" tabindex="19" data-errors="{filter_float:'enter valid data'}">
                    </div>
                </div>
               
                <div class="form_field width20 float_left">
                    <div class="label">Pulse</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[pulse]" value="<?php echo @$inc_details[0]->hc_cir_pulse_p_txt; ?>"  data-value="<?php echo @$inc_details[0]->hc_cir_pulse_p_txt; ?>"  class="form_input" placeholder="Enter Pulse"  type="text"  tabindex="7">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">RR</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[rr]" id="pt_con_handover_rr" value="<?php echo @$inc_details[0]->hc_con_rr; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_rr; ?>" class="form_input" placeholder="Enter RR" type="text"  tabindex="15" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">BP </div>
                    <div class="input top_left">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[bp_syt]" id="pt_con_handover_bp_syt" value="<?php echo @$inc_details[0]->hc_bp_sysbp_txt; ?>"  data-value="<?php echo @$inc_details[0]->hc_bp_sysbp_txt; ?>" class="inp_bp form_input " placeholder="SYST"  type="text" tabindex="16" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label none_prop">&nbsp;</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[bp_dia]" id="pt_con_handover_bp_dia" value="<?php echo @$inc_details[0]->hc_bp_dibp_txt; ?>"  data-value="<?php echo @$inc_details[0]->hc_bp_dibp_txt; ?>" class="inp_bp form_input " placeholder="DIAST"  type="text" tabindex="17" >
                    </div>
                </div>
                
                </div>
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">BSL</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[bsl]" value="<?php echo @$inc_details[0]->hc_con__bsl; ?>"  data-value="<?php echo @$inc_details[0]->hc_con__bsl; ?>" class="form_input" placeholder="Enter BSL"   type="text" tabindex="11" >
                    </div>
                </div>
                
                <div class="form_field width20 float_left">
                    <div class="label">O2Sat </div>
                    <div class="input">
                         <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[osat]"  id="pt_con_handover_osat" value="<?php echo @$inc_details[0]->hc_oxy_sat_get_nf_txt; ?>"  data-value="<?php echo @$inc_details[0]->hc_oxy_sat_get_nf_txt; ?>"  class="inp_bp form_input" placeholder="1 To 100"  type="text" tabindex="18" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">GCS </div>
                    <div class="input top_left">
                        <input name="pt_con_handover[gcs]"  id="pt_con_handover_gcs" value="<?php echo @$inc_details[0]->hc_con_gcs; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_gcs; ?>" class="form_input mi_autocomplete " placeholder="Score" data-href="{base_url}auto/gcs_score"  type="text" data-value="<?php echo $add_asst[0]->score; ?>"  tabindex="10" >
                    </div>
                </div>
               
                
                <div class="form_field width20 float_left">
                    <div class="label disnon">Skin</div>
                    <div class="input">
                        <input name="pt_con_handover[skin]"  id="pt_con_handover_skin" value="<?php echo @$inc_details[0]->hc_con_skin; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_skin; ?>"  class="form_input mi_autocomplete" placeholder="Skin" data-href="{base_url}auto/get_pulse_skin"   type="text"   tabindex="9" >
                    </div>
                </div>
                
                <div class="form_field width20 float_left">
                    <div class="label">Respiration Sound</div>
                    <div class="input">
                    <input name="pt_con_handover[hc_con_respiression]" id="baseline_respiression" class="form_input mi_autocomplete" placeholder="Respiration Sound" type="text" data-href="{base_url}auto/respiration_type" value="<?php echo @$inc_details[0]->hc_con_respiression; ?>" data-value="<?php echo @$inc_details[0]->hc_con_respiression; ?>" tabindex="12" >
                    </div>
                 </div>
                </div>
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">Pupils </div>
                    <div class="input">
                    <input name="pt_con_handover[pupils_left]"  id="pt_con_handover_pupils" value="<?php echo @$inc_details[0]->hc_con_pupils; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_pupils; ?>"  class="form_input mi_autocomplete" placeholder="Left" data-href="{base_url}auto/pupils_type"  type="text"  tabindex="12" >
                    </div>
                 </div>
                 <div class="form_field width20 float_left">
                    <div class="label">&nbsp;</div>
                    <div class="input">
                    <input name="pt_con_handover[pupils_right]"  id="pt_con_handover_pupils_right" value="<?php echo @$inc_details[0]->hc_con_pupils_right; ?>"  data-value="<?php echo @$inc_details[0]->hc_con_pupils_right; ?>"  class="form_input mi_autocomplete" placeholder="Right" data-href="{base_url}auto/pupils_type"  type="text"  tabindex="12" >
                    </div>
                 </div>
                    

                <div class="form_field width20 float_left">
                    <div class="label">Cardiac Arrest </div>
                    <div class="input">
                        <input name="pt_con_handover[cardiac]" id="pt_con_handover_cardiac"  class="inp_bp form_input  mi_autocomplete" value="<?php echo @$inc_details[0]->hc_cardiac; ?>"  data-value="<?php echo @$inc_details[0]->hc_cardiac; ?>" placeholder="Select Cardiac" data-href="{base_url}auto/get_cardiac_arrest" type="text"  tabindex="2" data-callback-funct="cardiact_change">
                    </div>
                </div>
                <div class="form_field width20 float_left" id="Cardiact_time_div" style="display:none" >
                    <div class="label">Cardiac Time</div>
                    <div class="input">
                    <input name="pt_con_handover[cardiac_time]" value="<?php echo @$inc_details[0]->hc_cardiac_time; ?>"  data-value="<?php echo @$inc_details[0]->hc_cardiac_time; ?>" tabindex="1"  class="form_input mi_timecalender StartDate" placeholder="Select cardiact date time" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  >

                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Capillary Refill < 2sec</div>
                    <div class="input">
                        <input name="pt_con_handover[caprefil]" id="pt_con_handover_caprefil" class="form_input mi_autocomplete" placeholder="Select CapRefill" data-href="{base_url}auto/get_yesno_opt" type="text" value="<?php echo @$inc_details[0]->hc_cir_cap_refill_great_t; ?>"  data-value="<?php echo @$inc_details[0]->hc_cir_cap_refill_great_t; ?>" tabindex="2" >
                    </div>
                </div>
                </div>
                <div class="width100">
                <div class="form_field width40 float_left">
                    <div class="label">Pt. Status during Transport </div>
                    <div class="input">
                        <input name="pt_con_handover[pt_status_during_status]" id="pt_con_handover_pt_status_during_status" class="inp_bp form_input  mi_autocomplete" value="<?php echo @$inc_details[0]->hc_status_during_status; ?>"  data-value="<?php echo @$inc_details[0]->hc_status_during_status; ?>" placeholder="Select Patent" data-href="{base_url}auto/get_yn_opt" type="text"  tabindex="2">
                    </div>
                </div>
                <div class="width40 form_field float_left">
                    <div class="label">Patient Handover Issue</div>
                    <div class="input">
                        <input name="pt_con_handover[pt_hndover_issue]" id="pt_con_handover_issue" class="form_input mi_autocomplete" placeholder="Select Handover issue" data-href="{base_url}auto/get_yesno_opt" type="text" value="<?php echo @$inc_details[0]->hi_pat_handover; ?>"  data-value="<?php echo @$inc_details[0]->hi_pat_handover; ?>" tabindex="2"   data-callback-funct="pt_handover_issue_change">
                    </div>
                </div>
                            </div>
                <div class="width100" id="handover_issue_no" style="display:none">
                    <div class="form_field width25 float_left"  >
                    <div class="label">OPD No.[Casualty No]</div>
                    <div class="input">
                    <input   name="pt_con_handover[issue_opd_no]" value="<?php echo @$inc_details[0]->opd_no_txt; ?>"  data-value="<?php echo @$inc_details[0]->opd_no_txt; ?>" class="form_input" placeholder="OPD No.[Casualty No]"   type="text" tabindex="11" >

                    </div>
                    </div>
                   
                </div>
                <div class="width100" id="handover_issue_yes" style="display:none">
                <div class="form_field width33 float_left">
                    <div class="label">Select Reason</div>
                    <div class="input">
                        <input name="pt_con_handover[issue_reson]" id="pt_con_handover_issue_op" class="inp_bp form_input  mi_autocomplete" value="<?php echo @$inc_details[0]->pat_handover_issue; ?>"  data-value="<?php echo @$inc_details[0]->pat_handover_issue; ?>" placeholder="Select Handover Reason" data-href="{base_url}auto/patient_handover_issues" type="text"  tabindex="2" >
                    </div>
                </div>
                <div class="form_field width33 float_left" >
                    <div class="label">Hospital Person Name</div>
                    <div class="input">
                    <input  name="pt_con_handover[handover_issue_hos_nm]" value="<?php echo @$inc_details[0]->hosp_person_name; ?>"  data-value="<?php echo @$inc_details[0]->hosp_person_name; ?>" class="form_input" placeholder="Hospital Person Name"   type="text" tabindex="11" >

                    </div>
                    </div>
                    <div class="form_field width33 float_left">
                    <div class="label">Corrective Action Date/time</div>
                    <div class="input">
                    <input name="pt_con_handover[handover_issue_datetime]" value="<?php echo @$inc_details[0]->corr_action_dt; ?>"  data-value="<?php echo @$inc_details[0]->corr_action_dt; ?>" tabindex="1"  class="form_input mi_timecalender StartDate" placeholder="Corrective Action Date/time" type="text" data-base="search_btn" data-errors="{filter_time_hm:'Please enter valid time(H:i)'}"  >

                    </div>
                </div>
                <div class="form_field width33 float_left" >
                    <div class="label">Communication with hos</div>
                    <div class="input">
                    <input  name="pt_con_handover[handover_issue_comm_withhos]" value="<?php echo @$inc_details[0]->com_with_hosp; ?>"  data-value="<?php echo @$inc_details[0]->com_with_hosp; ?>" class="form_input" placeholder="Comminication with hos"   type="text" tabindex="11" >

                    </div>
                    </div>
                    <div class="form_field width33 float_left" >
                    <div class="label">Remark</div>
                    <div class="input">
                    <input  name="pt_con_handover[handover_issue_remark]" value="<?php echo @$inc_details[0]->hi_remark; ?>"  data-value="<?php echo @$inc_details[0]->hi_remark; ?>" class="form_input" placeholder="Enter Remark"   type="text" tabindex="11" >

                    </div>
                    </div>
                </div> <?php } ?>
                <div class="width100 dr_para">
                    <div class=" width100 single_record_back">                                     
                        <h3 class="width_25 float_left">Driver Parameters: </h3>
                        
                        <?php 
                        $disabled = "";
                        if(empty($driver_data)){
                            $disabled = "disabled";
                        } ?>
                        <span class=" float_left" style="    margin-top: 3px;">Call DateTime<span class="md_field">*</span> : <?php echo date("d-m-Y H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?> </span>
                        <div class=" float_left" style="margin-left: 10px;   margin-top: 3px;">Response Time<span id="md_field">*</span> : <span id="driver_responce_time"></span>
                            <div class="hide" id='driver_responce_time_alarm'>Increase:<span id="responce_time_alarm"></span></div>
                        </div>
                    </div>
                    </div>
                <div class="width100">
                    <!--                    <h3>Driver Parameters : </h3>-->

                    <!--                    <div class="width33 drg float_left">
                                            <div class="width100 float_left">
                                                <div class="style6 float_left">Call received<span class="md_field">*</span> : </div>
                                            </div>
                                            <div class="width100 float_left">
                    
                                                <input name="call_rec_time" tabindex="14" class="form_input filter_required filter_time_hm call_rec_time" placeholder="H:i:s" type="hidden" data-base="search_btn" data-errors="{filter_required:'Call received should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}" value="<?php echo date("H:i", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly" >
                                            </div>
                                        </div>-->

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            
                            <div class="style6 float_left">Start From Base <span class="md_field">*</span> :  <?php if($reopen == 'y'){ ?><?php

                        if(date('Y-m-d H:i:s', strtotime($driver_data[0]->start_from_base)) == ''){
                            
                            echo "00:00:00";
                        }
                        else{
                            $p_login_time = date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime));
                            $current_time = date('Y-m-d H:i:s', strtotime($driver_data[0]->start_from_base));
                            // $difference = ($current_time - $p_login_time);
                            $datetime1 = new DateTime($p_login_time);
                            $datetime2 = new DateTime($current_time);
                            $interval = $datetime1->diff($datetime2);
                            echo $interval->format('%h') . ":" . $interval->format('%i') .  ":" . $interval->format('%s');
                        }?>
                        <?php }?> </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="start_from_base" id="start_from_base" tabindex="20" class="form_input filter_required EndDate filter_required filter_gretherthan[inc_datetime]" placeholder="Y-m-d H:i:s" type="text" value="<?php
                            if (isset($driver_data[0]->start_from_base)) {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->start_from_base));
                            }else{ echo $inc_details_data[0]->inc_datetime; 
                                }
                            
                            ?>"  data-errors="{filter_required:'Start From Base should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'Start from base should not be grater than Call DateTime'}"  readonly="readonly" >
                        </div>
                    </div>

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene <span class="md_field">*</span> :<?php if($reopen == 'y'){ ?> <?php
                         if(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_on_scene)) == ''){
                            
                            echo "00:00";
                        }
                        else{
                        $p_login_time = date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime));
                        $current_time = date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_on_scene));
                        // $difference = ($current_time - $p_login_time);
                        $datetime1 = new DateTime($p_login_time);
                        $datetime2 = new DateTime($current_time);
                        $interval = $datetime1->diff($datetime2);
                        echo $interval->format('%h') . ":" . $interval->format('%i') .":" . $interval->format('%s');
                        }?><?php }?></div>
                        </div>
                        <div class="width100 float_left">
                            <input name="at_scene" tabindex="15" class="form_input filter_required StartDate  filter_required filter_gretherthan[start_from_base]" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'At Scene should not be grater than Start from base'}" value="<?php
                            if (isset($driver_data[0]->dp_on_scene)) {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_on_scene));
                            }else{ echo $inc_details_data[0]->inc_datetime; 
                            }
                            ?>" id="at_scene" readonly  <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">From Scene <span class="md_field">*</span> :<?php if($reopen == 'y'){ ?><?php
                          if(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_reach_on_scene)) == ''){
                            
                            echo "00:00";
                        }
                        else{
                        $p_login_time = date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime));
                        $current_time = date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_reach_on_scene));
                        // $difference = ($current_time - $p_login_time);
                        $datetime1 = new DateTime($p_login_time);
                        $datetime2 = new DateTime($current_time);
                        $interval = $datetime1->diff($datetime2);
                        //echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                         echo $interval->format('%h') . ":" . $interval->format('%i') .":" . $interval->format('%s');
                        }?> <?php }?></div>
                        </div>
                        <div class="width100 float_left">
                            <input name="from_scene" tabindex="16" class="form_input filter_required FromDate filter_gretherthan[at_scene]" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'From Scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'From Scene should not be grater than At Scene'}" value="<?php
                            if (isset($driver_data[0]->dp_reach_on_scene) && $driver_data[0]->dp_reach_on_scene != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_reach_on_scene));
                            }else{ echo $inc_details_data[0]->inc_datetime; 
                            }
                            ?>" readonly="readonly" id="from_scene" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width100 float_left">
                          <?php 
                    $responce_time_remark = '';
                    $hide_remark = 'hide';
                  
                    if($driver_data[0]->responce_time_remark != ''){ 
                        $responce_time_remark = get_responce_time_remark($driver_data[0]->responce_time_remark);                        $hide_remark = '';
                        
                    }                 
                    ?>
                        <div class="width50 drg float_left <?php echo $hide_remark; ?>" id="responce_time_remark">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Remark : </div>
                            </div>
                            <div class="width_60 float_left">
                                <input type="text" name="responce_time_remark" id="responce_remark" data-value="<?php echo $responce_time_remark; ?>" value="<?php echo $driver_data[0]->responce_time_remark; ?>" class="mi_autocomplete"  data-href="{base_url}auto/get_responce_time_remark"  placeholder="Remark" data-callback-funct="responce_remark_change" TABINDEX="8" data-errors="{filter_required:'Remark should not be blank!'}">

                            
                            </div>
                        </div>
                            <?php 
                   
                    $hide_remark_other = 'hide';
                  
                    if($driver_data[0]->responce_time_remark_other != ''){ 
                        $hide_remark_other = '';
                        
                    } ?>
                        <div class="width50 drg float_left <?php echo $hide_remark_other;?>" id="responce_time_remark_other">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Other Remark : </div>
                            </div>
                            <div class="width_60 float_left">
                                <input name="responce_time_remark_other" tabindex="19" class=" form_input" placeholder="Remark" type="text" data-base="search_btn" value="<?php echo $driver_data[0]->responce_time_remark_other; ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}">
                            
                            </div>
                        </div>
                    </div>



                </div>
                <div class="width100">

                    <!--                    <div class="width33 drg float_left">
                                            <div class="width100 float_left">
                                                <div class="style6 float_left">From Scene : </div>
                                            </div>
                                            <div class="width100 float_left">
                                                <input name="from_scene" tabindex="16" class="form_input filter_if_not_blank EndDate" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'From Scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php
                    if (isset($driver_data[0]->dp_reach_on_scene)) {
                        echo date('Y-m-d H:i', strtotime($driver_data[0]->dp_reach_on_scene));
                    }
                    ?>" readonly="readonly" >
                                            </div>
                                        </div>-->
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At Hospital/ Ambulance <span class="md_field">*</span> :<?php if($reopen == 'y'){ ?> <?php
                        if(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hosp_time)) == ''){
                            
                            echo "00:00";
                        }
                        else{
                        $p_login_time = date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime));
                        $current_time = date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hosp_time));
                        // $difference = ($current_time - $p_login_time);
                        $datetime1 = new DateTime($p_login_time);
                        $datetime2 = new DateTime($current_time);
                        $interval = $datetime1->diff($datetime2);
                        //echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                        echo $interval->format('%h') . ":" . $interval->format('%i') .":" . $interval->format('%s');
                        }?><?php }?></div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class=" form_input filter_required AtHospDate filter_gretherthan[from_scene]" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'At Hospital/ Ambulance should not be grater than From Scene'}"  value="<?php
                            if (isset($driver_data[0]->dp_hosp_time) && $driver_data[0]->dp_hosp_time != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hosp_time));
                            }else{ echo $inc_details_data[0]->inc_datetime; 
                            }
                            ?>" readonly="readonly" id="at_hospitals_ambulance1" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Hand over <span class="md_field">*</span> :<?php if($reopen == 'y'){ ?> <?php
                             if(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hand_time)) == ''){
                            
                                echo "00:00";
                            }
                            else{
                        $p_login_time = date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime));
                        $current_time = date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hand_time));
                        // $difference = ($current_time - $p_login_time);
                        $datetime1 = new DateTime($p_login_time);
                        $datetime2 = new DateTime($current_time);
                        $interval = $datetime1->diff($datetime2);
                        //echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                       echo $interval->format('%h') . ":" . $interval->format('%i') .":" . $interval->format('%s');
                            }?><?php }?></div>
                        </div>
                        <div class="width100 float_left">
                            <input name="hand_over" tabindex="18" class="form_input filter_required HandoverDate filter_gretherthan[at_hospitals_ambulance1]" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Hand over should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'Hand over should not be grater than At Hospital/ Ambulance'}" value="<?php
                            if (isset($driver_data[0]->dp_hand_time) && $driver_data[0]->dp_hand_time != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hand_time));
                            }else{ echo $inc_details_data[0]->inc_datetime; 
                            }
                            ?>" readonly="readonly" id="hand_over" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Back to base<span class="md_field">*</span> :<?php if($reopen == 'y'){ ?> <?php
                        if(date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc)) == ''){
                            
                            echo "00:00";
                        }
                        else{
                        $p_login_time = date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime));
                        $current_time = date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc));
                        // $difference = ($current_time - $p_login_time);
                        $datetime1 = new DateTime($p_login_time);
                        $datetime2 = new DateTime($current_time);
                        $interval = $datetime1->diff($datetime2);
                        //echo $interval->format('%h') . ":" . $interval->format('%I') . " Hours";
                        echo $interval->format('%h') . ":" . $interval->format('%i') .":" . $interval->format('%s');
                        }?><?php }?></div>
                        </div>
                        <div class="width100 float_left">
                            <input name="back_to_base" tabindex="19" class="filter_required form_input BacktobaseDate filter_gretherthan[hand_over]" placeholder="H:i" type="text" data-base="search_btn" value="<?php
                            if (isset($driver_data[0]->dp_back_to_loc) && $driver_data[0]->dp_back_to_loc != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc));
                            }else{ echo $inc_details_data[0]->inc_datetime; 
                            }
                            ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_gretherthan:'Back to base should not be grater Hand over'}" readonly="readonly" id="back_to_base_epcr" <?php echo $disabled; ?>>
                        </div>
                    </div>

                </div>
                <?php } ?>
                <!--                <div  class="width100">
                                    <div class="width50 drg float_left">
                                        <div class="width33 float_left">
                                            <div class="style6 float_left">Back to base<span class="md_field">*</span> : </div>
                                        </div>
                                        <div class="width50 float_left">
                                            <input name="back_to_base" tabindex="19" class="filter_required form_input EndDate" placeholder="H:i" type="text" data-base="search_btn" value="<?php
                if (isset($driver_data[0]->dp_back_to_loc)) {
                    echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc));
                }
                ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly" >
                                        </div>
                                    </div>
                                </div>-->

                <div id="ercp_odometer_block">
                    <?php
                   // $previous_odometer = "";
                   
                    if (!empty($get_odometer)) {

                        $previous_odometer = $get_odometer[0]->start_odmeter;
                    }
   
                    ?>
                    <div class="width100">
                        <div class="width100 single_record_back">                                     

                            <h3 class=" width_25 float_left">Odometer :</h3>
                            <span class=" float_left width_25" style="margin-top: 3px;">Previous Odometer: <?php echo @$previous_odometer; ?> </span>
                             <a class="float_left click-xhttp-request odometer_icon" style="margin-top: 3px; color:#2F419B;" data-href="<?php echo base_url();?>/pcr/last_ten_odometer" data-qr="amb_no=<?php echo $vahicle_info[0]->amb_rto_register_no; ?>">Previous Odometer List</a>
                        </div>

                        <!--                    <div class="width50 drg float_left">
                                                <div class="width50 float_left">
                                                    <div class="style6 float_left">Previous Odometer: </div>
                                                </div>
                                                <div class="width50 float_left">
                                                    <input name="previous_odmeter" tabindex="20" class="form_input" placeholder="Enter Previous Odometer" type="text" data-base="search_btn" value="<?php echo @$previous_odometer; ?>"  data-errors="{filter_required:'Previous Odometer should not be blank!'}" readonly="readonly" id="previous_odometer_pcr">
                                                </div>
                                            </div>-->
                    </div>
                    <?php
                    $odo_disabled = "";
                    $previous_odo = $previous_odometer;
                    $filter_greterthan = "filter_valuegreaterthan[" . $previous_odo . "]";
                    $odometer =  $previous_odometer+500;
                    

                    $filter_rangelength = "filter_rangelength[" . $previous_odometer . "-".$odometer."]";
                    if (!($previous_odometer)){
                       
                        $odo_disabled = 'readonly="readonly"';
                        //$odo_end_disabled = 'readonly="readonly"';
                        //$odo_scene_disabled = 'readonly="readonly"';
                        //$odo_hospital_disabled = 'readonly="readonly"';
                       
                        //$odo_handover_disabled = 'readonly="readonly"';
                        $filter_greterthan = "";
                        //$filter_rangelength = "";
                    }
                     
                    if($get_odometer[0]->from_scene_odometer != '' &&  $reopen != 'y'){
                        //$odo_from_scene_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->end_odmeter != '' &&  $reopen != 'y'){
                       // $odo_end_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->scene_odometer != '' &&  $reopen != 'y'){
                       // $odo_scene_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->hospital_odometer != '' && $reopen != 'y'){
                       // $odo_hospital_disabled = 'readonly="readonly"';
                    }
               
                    ?>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Start Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left">
                                <input name="start_odmeter" tabindex="20" class="filter_required form_input <?php //echo $filter_rangelength; ?> filter_maxlength[8]" placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?php echo $previous_odometer; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!',filter_valuegreaterthan:'Start Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Start Odometer should <?php echo $previous_odometer; ?>',filter_maxlength:'Start Odometer number at max 7 digit long.'}" id="start_odometer_pcr" <?php if($total_closure_count >= 1 && $reopen != 'y'){ echo 'readonly="readonly"'; echo $odo_disabled;  } ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">At Scene Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="scene_view">
                               
                                  <?php
                                 $odometer_scene =  $previous_odometer+100;
                                $filter_rangelength = "filter_rangelength[" . $previous_odometer . "-".$odometer_scene."]"; ?>
                                <input name="scene_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8] filter_required <?php echo $filter_rangelength;?>" placeholder="Enter Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->scene_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $odometer_scene; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="scene_odometer_pcr" <?php if( $reopen != 'y'){  echo $odo_scene_disabled; } ?> >
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">From Scene Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="from_scene_view">
                                <input name="from_scene_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8] filter_required" placeholder="Enter from Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->from_scene_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $get_odometer[0]->scene_odometer; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="from_scene_odometer_pcr" <?php if( $reopen != 'y'){  echo $odo_from_scene_disabled; } ?> >
                            </div>
                        </div>
                       <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">At Hospital Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="hos_view">
                                <input name="hospiatl_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input  filter_maxlength[8] filter_required" placeholder="Enter hospital Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->hospital_odometer; ?>"  data-errors="{filter_required:'hospital Odometer should not be blank!',filter_valuegreaterthan:'hospital Odometer should greater than or equlto Previous Odometer',filter_rangelength:'At Hospital Odometer should less than At Scene Odometer+500',filter_maxlength:'Hospital Odometer number at max 7 digit long.'}" id="hospital_odometer_pcr"  <?php if( $reopen != 'y'){  echo $odo_hospital_disabled1; } ?> >
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Handover Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="handover_view">
                                <input name="handover_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8] filter_required" placeholder="Enter Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->handover_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Handover Odometer should less than At Hospital Odometer+100',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="handover_odometer_pcr" <?php  if( $reopen != 'y'){  echo $odo_handover_disabled; } ?> >
                            </div>
                        </div>

                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">END Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="end_odometer_textbox">
                                <input name="end_odmeter" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="21"  maxlength="7" id="end_odometer_input" class="filter_required form_input  filter_maxlength[8] filter_rangelength_old[<?php echo $previous_odometer; ?>-<?php echo $previous_odometer+1000;?>] filter_valuegreaterthan_old[<?php echo $previous_odometer; ?>]" placeholder="Enter END Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->end_odmeter; ?>"  data-errors="{filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_maxlength:'END Odometer at max 7 digit long.',filter_required:'End Odometer should be not blank',filter_rangelength:'End Odometer should less than At Hospital Odometer + 500'}" <?php if( $reopen != 'y'){ echo $odo_end_disabled1; } ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Distance Travelled<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="end_odometer_textbox">
                                <input name="distance_travelled_odmeter" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="21"  maxlength="7" id="distance_travelled_odmeter" class="filter_required form_input  filter_maxlength[8]" placeholder="Distance Travelled" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->total_km; ?>"  data-errors="{filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_maxlength:'END Odometer at max 7 digit long.',filter_required:'End Odometer should be not blank'}" <?php echo $odo_end_disabled; ?>>
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left"><span id="gps_odo" class="odo_btn" onclick="gps_odo();">GPS Odometer</span> : </div>
                            </div>
                            <div class="width50 float_left" id="gps_odmeter_textbox">
                            <input name="gps_odmeter" onkeyup="" tabindex="21"  maxlength="7" id="" class="form_input" placeholder="GPS Odometer" type="text" data-base="search_btn" value="" readonly>
                            </div>
                        </div>
                                                
                        <div class="width100">

                            <div id="remark_textbox">
                            </div>

                            <div id="odometer_remark_other_textbox">
                            </div>

                        </div>
                        <div class="width100">

                            <div id="show_remark_end_odometer">
                                <?php 
                                if(@$inc_details[0]->end_odometer_remark != ''){ ?>
                                     <div class="width50 drg float_left">
                                        <div class="width33 float_left">
                                            <div class="style6 float_left">End Odometer Remark<span class="md_field">*</span> : </div>
                                        </div>
                                        <div class="width_60 float_left">

                                        <input name="end_odometer_remark" id="end_remark_input" class="mi_autocomplete filter_required" data-href="{base_url}auto/get_odometer_remark" data-value="<?php echo get_end_odo_remark(@$inc_details[0]->end_odometer_remark); ?>" value="<?php echo @$inc_details[0]->end_odometer_remark; ?>" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_end_other_odometer" data-errors="{filter_required:'End Odometer Remark should not be blank!'}">
                                        </div>
                                    </div>
                                <?php } ?>
                                
                            </div>

                            <div id="end_odometer_remark_other_textbox">
                                <?php if(@$inc_details[0]->endodometer_remark_other != ''){ ?>
                                <div class="width50 drg float_left">
                                    <div class="width33 float_left">
                                        <div class="style6 float_left">End Odometer Other Remark<span class="md_field">*</span> : </div>
                                    </div>
                                    <div class="width_60 float_left">

                                        <input name="endodometer_remark_other" class="filter_required"  value="<?php echo @$inc_details[0]->endodometer_remark_other; ?>" type="text" tabindex="2" placeholder="Other Remark" data-errors="{filter_required:'Odometer Other Remark should not be blank!'}" >
                                    </div>
                                </div>
                                 <?php } ?>
                                
                            </div>

                        </div>
                    </div>
                </div>
                <div class="width100">
                    <div class="width_25 rec_hp float_left">
                        <div class="style6 float_left">Remark :<span class="md_field">*</span> </div>
                    </div>
                    <div class="width75 rec_hp float_left">
                        <textarea name='epcr_remark' class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"><?php echo $inc_details[0]->remark; ?></textarea>
                    </div>

                </div>
                <?php if($reopen == 'y'){ ?>
                 <div class="width100">
               <div class="width_25 rec_hp float_left">
                   <div class="style6 float_left">Validation Remark :<span class="md_field">*</span> </div>
               </div>
               <div class="width75 rec_hp float_left">
                    <textarea name='valid_remark' class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"><?php echo $inc_details[0]->valid_remark; ?></textarea>
               </div>
            </div> 
                <?php }?>

            </div>
            <?php if(($inc_emp_info[0]->hp_id == '' || $inc_emp_info[0]->hp_id == null || $inc_emp_info[0]->hp_id == 0) && $user_group != 'UG-BIKE-DCO'){
             ?>
            <input name="wrd_location" id="wrd_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->ward_name; ?>" readonly="readonly">
            <input name="wrd_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->ward_id; ?>">
            <?php
            }else{ //hosvar_dump($inc_emp_info[0]->hp_name);?>
                <input name="base_location" tabindex="23" id="base_location" class="form_input filter_required" placeholder=" Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>" readonly="readonly">
                <input name="base_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_id; ?>">
            <?php } ?>
            <input type="hidden" name="amb_type_id" tabindex="23" id="amb_type_id" class="form_input filter_required" placeholder=" Ambulance Type"  data-base="search_btn" data-errors="{filter_required:'Amb type should not be blank!'}" value="<?= $inc_emp_info[0]->ambt_id; ?>" readonly="readonly">
            <input type="hidden" name="category_id" id="amb_category_id" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_id; ?>" readonly="readonly">
            
            <input type="hidden" name="Amb_type" tabindex="23" id="amb_type" class="form_input filter_required" placeholder=" Ambulance Type"  data-base="search_btn" data-errors="{filter_required:'Amb type should not be blank!'}" value="<?= $inc_emp_info[0]->ambt_name; ?>" readonly="readonly">
            <input type="hidden" name="category" id="amb_category" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?php echo @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
            
            <input type="hidden" name="tc_dtl_state" id="tc_dtl_state" value="<?php echo $inc_details_data[0]->inc_state_id; ?>">
            <input type="hidden" name="tc_dtl_districts" id="tc_dtl_districts" value="<?php echo $inc_details_data[0]->inc_district_id; ?>">
            <input type="hidden" name="tc_dtl_ms_city" id="tc_dtl_ms_city" value="<?php echo $inc_details_data[0]->inc_city_id; ?>">
            <input type="hidden" id="pcr_amb_id" name="amb_reg_id" value="<?php echo $vahicle_info[0]->amb_rto_register_no;  ?>">
            <input type="hidden" id="pcr_amb_id" name="amb_reg_id" value="<?php echo $vahicle_info[0]->amb_rto_register_no;  ?>">
            
            <input id="add_pcr_amb" class=" onpage_popup float_right" name="add_amb" value="Add Ambulance" data-href="{base_url}/amb/add_amb" data-qr="output_position=popup_div&amp;tool_code=add_ambu" data-popupwidth="1000" data-popupheight="800" type="button" style="display:none;">
            <input name="date" tabindex="1" class="form_input filter_required " placeholder="Date" type="hidden" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!'}" value="<?php echo date('d-m-Y', strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
            <input name="time" tabindex="2" class="form_input filter_required" placeholder="Time" type="hidden" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
            <input name="inc_ref_id" tabindex="5" class="form_input filter_required" placeholder=" Incident Id" type="hidden" data-base="send_sms" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>" readonly="readonly">
            <input id="incident_datetime_res_remark" tabindex="1" class="form_input filter_required " placeholder="Date" type="hidden" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!'}" value="<?php echo date('Y-m-d H:i:s', strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
           
            
            <div class="width100 text_center">
                <div class="text_center">

                    <div class="label">&nbsp;</div>

    <!--                    <input name="search_btn" value="Save" class="style3 base-xhttp-request" data-href="{base_url}/pcr/epcr" data-qr="output_position=content" type="button">-->
                    <?php //if($user_group != 'UG-DCO'){ ?>
                        <input type="hidden" id="pt_count_ero" name="pt_count_ero" value="<?php echo $inc_details_data[0]->inc_patient_cnt; ?>"> 
                       <input type="hidden" id="pt_count" name="pt_count" value="<?php echo $pt_count; ?>"> 
                    <input type="hidden" name="epcr_call_type" id="epcr_call_type" value="2">
                    <input type="hidden" name="reopen" id="reopen" value="<?php echo $reopen;?>">
                    <input type="hidden" name="inc_datetime" id="inc_datetime" value="<?php echo $inc_details_data[0]->inc_datetime; ?>">
                    <?php if ($revalidate == '1') {?>
                        
                        <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}job_closer/save_job_closure_revalidate' data-qr='' TABINDEX="33">
                        <?php } else { ?>

                            <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}job_closer/save_job_closure' data-qr='' TABINDEX="33">
                            
                            <?php }  ?>
  <!--                  <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}/bike/save_epcr' data-qr='' TABINDEX="33">-->
                    <?php // }  ?>
                </div> 
            </div>
        </div>
    </form>
</div>
<div class="next_pre_outer">
    <?php
    $step = $this->session->userdata('pcr_details');
    if (!empty($step)) {
        ?>
        <!--        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(2)"> Next > </a>-->
    <?php } ?>
</div>
<style>
    .odo_btn{
        background: #42a142;
        border-radius: 10px;
        border: none;
        padding: 5px;
        color: white;
        cursor: pointer;
    }
</style>
<script>
    var jsDate = $("#inc_datetime").val();
    var $mindate = new Date(jsDate);
    var $stdate_limit1 = new Date($mindate.getTime() + 5 * 60000);

    $('.EndDate').datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: $mindate,
         highlight : $mindate,
        maxDate: $stdate_limit1,
        //defaultValue: $mindate,
        // minTime: jsDate[1],

    });
</script>
<script>
//    $(document).ready(function(){
//        document.getElementById("at_scene").disabled = true;
//        document.getElementById("from_scene").disabled = true;
//        document.getElementById("at_hospitals_ambulance1").disabled = true;
//        document.getElementById("hand_over").disabled = true;
//        document.getElementById("back_to_base").disabled = true;
//    });


    $('#start_from_base').on('change',function(){
        var start_from_base = $('#start_from_base').val();
        if(start_from_base != null){
            document.getElementById("at_scene").disabled = false;
        }else{
            document.getElementById("at_scene").disabled = true;
        }
    });
    $('#at_scene').on('change',function(){
        var start_from_base = $('#at_scene').val();
        
        $("#at_scene" ).datepicker( "destroy" );
        $('#at_scene').last().datepicker('refresh');
        if(start_from_base != null){
            document.getElementById("from_scene").disabled = false;
        }else{
            document.getElementById("from_scene").disabled = true;
        }
    });
    $('#from_scene').on('change',function(){
        $("#from_scene" ).datepicker( "destroy" );
        $('#from_scene').last().datepicker('refresh');
        var start_from_base = $('#from_scene').val();
        if(start_from_base != null){
            document.getElementById("at_hospitals_ambulance1").disabled = false;
        }else{
            document.getElementById("at_hospitals_ambulance1").disabled = true;
        }
    });
    $('#at_hospitals_ambulance1').on('change',function(){
        $("#at_hospitals_ambulance1" ).datepicker( "destroy" );
        $('#at_hospitals_ambulance1').last().datepicker('refresh');
        var start_from_base = $('#at_hospitals_ambulance1').val();
        if(start_from_base != null){
            document.getElementById("hand_over").disabled = false;
        }else{
            document.getElementById("hand_over").disabled = true;
        }
    });
    $('#hand_over').on('change',function(){
        $("#hand_over" ).datepicker( "destroy" );
        $('#hand_over').last().datepicker('refresh');
        var start_from_base = $('#hand_over').val();
        if(start_from_base != null){
            document.getElementById("back_to_base_epcr").disabled = false;
        }else{
            document.getElementById("back_to_base_epcr").disabled = true;
        }
    });
     $('#back_to_base_epcr').on('change',function(){
        $("#back_to_base_epcr" ).datepicker( "destroy" );
        $('#back_to_base_epcr').last().datepicker('refresh');
    });
    
    
    function facility_new_details(ft) {

        if (ft == 'Other' || ft == 0) {

            xhttprequest($(this), base_url + 'bike/other_hospital_textbox', 'output_position=other_hospital_textbox');
        } else {
            $('#other_hospital_textbox').html('');
        }
        
    }
    $("input[type=text]").each(function() {
        var str = $(this).val();
        if( $.trim(str) != '' && $.trim(str) != '<empty string>'){
            $('input[type=text]').removeClass("has_error");
        }
    });

    // $('#gps_odo').click(function(){
    //     function gps_odo(){
    //     var vehicle_no = $("input[name='amb_reg_id']").val();
    //     // vehicle_no = vehicle_no.replace (/-/g, "");
    //     vehicle_no = "MA55NU2247";
    //     // var start_time = $("input[name='start_from_base']").val();
    //     var start_time = "06-09-2022 10:51:00";
    //     // var end_time = $("input[name='back_to_base']").val();
    //     var end_time = "06-09-2022 13:21:00";
    //     // alert(end_time);


        
    // $.ajax({
    //            url: "http://3.6.6.255/webservice?token=getHistoryDataTracknovate&vehicle_no="+vehicle_no+"&start_time="+start_time+"&end_time="+end_time,
    //              dataType: "json",
    //              success: function (data) {
    //                 //  alert();
    //                 // console.log(data['data'][0].distance);
    //                 dist = data['data'][0].distance;
    //                 gps_odo = dist/1000;
    //                 $("input[name='gps_odmeter']").val(gps_odo);
                    
    //              },
                 
    //          });
    // // });
    //     }
        function gps_odo(){
        var vehicle_no = $("input[name='amb_reg_id']").val();
        vehicle_no = vehicle_no.replace (/-/g, "");
        // vehicle_no = "MA55NU2247";
      
        // var start_time = "06-09-2022 10:51:00";
        var start_time = $("input[name='start_from_base']").val();

        var end_time = $("input[name='back_to_base']").val();

        // var end_time = "06-09-2022 13:21:00";
        // alert(end_time);
            $.post('<?= site_url('job_closer/get_odometer_by_gps') ?>', {
            vehicle_no,start_time,end_time
    },function(result) {
        
        var new_var = JSON.parse(result);
       // alert(new_var);
        $("input[name='gps_odmeter']").val(new_var);
    }
        )};


</script>