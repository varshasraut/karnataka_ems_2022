<script>//cur_pcr_step(1);</script>

<div class="float_left width100">
    <?php
    $CI = EMS_Controller::get_instance();

    if (@$th_id != '') {
        $th_id = @$th_id;
    }

    if (@$amb_dst != '') {
        $dst_id = @$amb_dst;
    }
    ?>
    <div class="head_outer"><h3 class="txt_clr2 width1">Closure Information : Patient Not Available</h3> </div>     
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

                                <input class="add_button_hp click-xhttp-request float_right mipopup" id="add_button_pt" name="add_patient" value="Add" data-href="{base_url}pcr/add_patient_details?pt_count=<?php echo $pt_count; ?>&epcr_call_type=<?php echo '1';?>&pt_count_ero=<?php echo $inc_details_data[0]->inc_patient_cnt; ?>" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes&inc_ref_id=<?php echo $inc_ref_id; ?>&reopen=<?php echo $reopen;?>" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">
                            
                        </div>
                        <div class="width_25 float_left drg">
                            <!--<div class=" float_left">
                                <div class="style6 float_left">Age: </div>
                            </div>-->
                            <input name="patient_age" tabindex="9" class="form_input" placeholder=" Age" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Age should not be blank!'}" value="<?php echo $pt_info[0]->ptn_age; ?>" readonly="readonly">
                            
                        </div>

                       
                        <div class="width_25 float_left">
                        <select id="ptn_age_type" name="ptn[0][ptn_age_type]">
                        <option value="Year"  <?php if($pt_info[0]->ptn_age_type == 'Year'){
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
                                <input name="ptn_fname" id="ptn_fname" tabindex="11" class="form_input ucfirst_letter" placeholder="Patient First Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php echo $pt_info[0]->ptn_fname; ?>" readonly="readonly">
                            </div>
                            <!--<div class="width_27 float_left">
                                <input name="ptn_mname" tabindex="12" class="form_input" placeholder="Patient Middle Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php //$pt_info[0]->ptn_mname; ?>" readonly="readonly">
                            </div>-->
                            <div class="width_25 float_left drg">
                                <input name="ptn_lname" tabindex="13" class=" " placeholder="Patient Last Name " type="text"  value="<?php echo $pt_info[0]->ptn_lname; ?>" readonly="readonly">
                            </div>
                            
                            
                            <div class="width_25 float_left drg">
                                <input name="ayu_id" tabindex="13" class="form_input" placeholder="Ayushman ID" type="text" data-base="search_btn" value="<?php echo $pt_info[0]->ayushman_id; ?>" readonly="readonly">
                            </div>
                            <div class="width_25 float_left drg">
                                <input name="blood_gp" tabindex="13" class="form_input" placeholder="Blood Group" type="text" data-base="search_btn" value="<?php if($pt_info[0]->ptn_bgroup == ''){ echo get_blood_group_name($pt_info[0]->ptn_bgroup); } ?>" readonly="readonly">
                            </div>
                        </div>


                        <div class="width100">

                            <div id="ptn_form_lnk" class="width100 float_left">
   <?php if($pt_info[0]->ptn_id != ''){ ?>
                               <a data-href='{base_url}pcr/add_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=<?= @$pt_info[0]->ptn_id; ?>&amp;inc_ref_id=<?php echo $inc_ref_id; ?>&amp;reopen=<?php echo $reopen;?>' data-popupwidth='1250' data-popupheight='870'>( Update Patient Details )</a>
                               <a data-href='{base_url}pcr/delete_patient_details' class='click-xhttp-request style1' data-qr='ptn_id=<?= @$pt_info[0]->ptn_id; ?>&amp;inc_ref_id=<?php echo $inc_ref_id; ?>' data-popupwidth='1250' data-popupheight='870' data-confirm='yes' data-confirmmessage='Are you sure to delete'>( Delete Patient Details )</a>
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
                        $state_id = "MP";
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
                    
                                        <input name="city" tabindex="17" class="mi_autocomplete  form_input filter_required" placeholder=" City/Village " type="text" data-base="search_btn" data-errors="{filter_required:'City/Village should not be blank!'}" data-href="{base_url}auto/city" data-value="<?= @$inc_details[0]->inc_city_id; ?>">
                    
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
                                                    <input name="locality" tabindex="33" class="form_input filter_required" placeholder="Locality" type="text" data-base="search_btn" data-errors="{filter_required:'Locality should not be blank!'}" value="<?= @$inc_address ?>">
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
                                <div class="style6 float_left">EMT ID : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php 
//var_dump($inc_emp_info);
                                
                                ?>
<!--                                <input name="emt_name" tabindex="24" class="form_input filter_required" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>" >-->
                                <input name="emt_id" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_emso_id" data-value="<?php echo $inc_details[0]->emso_id; ?>" value="<?php echo $inc_details[0]->emso_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_emso_id"  id="emt_list" data-errors="{filter_required:'Ambulance should not be blank!'}">
                            </div>
                        </div>
                        <div class="width50 drg float_left" id="show_emso_name">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT Name : </div>
                            </div>
                            <div class="width_62 float_left" >
                                <input name="emt_name" id="emt_id_new" tabindex="25" class="form_input" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?php echo @$inc_details[0]->emt_name; ?>">
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
                                <div class="style6 float_left">Pilot ID : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php //var_dump($inc_emp_info); ?>
<!--                                <input name="emt_name" tabindex="24" class="form_input filter_required" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $inc_emp_info[0]->pilot_name; ?>" >-->
                                <input name="pilot_id"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_pilot_id" data-value="<?php echo $inc_details[0]->pilot_id; ?>"" value="<?php echo $inc_details[0]->pilot_id; ?>"" type="text" tabindex="1" placeholder="Pilot ID" data-callback-funct="show_pilot_idnew"  id="pilot_list" data-errors="{filter_required:'Pilot ID should not be blank!'}">
                            </div>
                          
                        </div>
                        <div class="width50 drg float_left" id="show_pilot_name">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot Name : </div>
                            </div>
                            <div class="width_62 float_left" >
                                <input name="pilot_name" id="pilot_id_new" tabindex="25" class="form_input" placeholder="Pilot Name1" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?php echo $inc_details[0]->pilot_name; ?>">
                                <input name="pilot_id" tabindex="25" class="form_input"  type="hidden" value="<?php echo $inc_details[0]->pilot_id; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="width100" id="pilot_other_textbox">
                            </div>
         
                            <div class="width100 float_left">
                   <div class="width100">
                    <div class="single_record_back">                                     
                        <h3>Medical Information</h3>
                    </div>
                    </div>
            
                    
                    <div class="width100">
                    <!--<div class="width_40 drg float_left">
                        <div class="width_35 float_left">
                            <div class="style6 float_left">Case Type <span class="md_field">*</span> : </div>
                        </div>
                        <?php 
                         //var_dump($inc_details[0]->provider_casetype);
                        if($user_group == 'UG-BIKE-DCO'){
                          ?>
                          <div class="width_60 float_left base_location">
                            <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}"  value="<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="{base_url}auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype" >
                        </div>
                          <?php  
                            
                        }else{
                            ?>
                            <div class="width_60 float_left base_location">
                            <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}"  value="<?php echo $inc_details[0]->provider_casetype; ?>" data-value="<?php echo $inc_details[0]->case_name; ?>" data-href="{base_url}auto/get_providercase_type_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_casetype" data-callback-funct="remove_mandatory_fields_new">
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
                    <div class="width_40 float_left">
                            <div class="style6 float_left">Provider Impressions<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width_60 float_left base_location">
                            <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}"  value="<?php echo @$inc_details[0]->provider_impressions;?>" data-value="<?php echo @$inc_details[0]->pro_name; ?>" data-href="{base_url}auto/get_provider_imp_new?epcr_call_type=<?php echo $epcr_call_type;?>&patient_gender=<?php echo $pt_info[0]->ptn_gender; ?>" data-qr="" id="provider_impressions">
                        </div>
                   
                </div>
                
                <div class="width100" id='other_provider_impression'>
                    <?php if($inc_details[0]->other_provider_img != ''){ ?>
                    <div class="width100">
                        <div class="width100 rec_hp float_left">
                            <div class="style6 float_left">Other Provider Impressions <span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 rec_hp float_left">
                            <input name="other_provider" class="filter_required" value="<?php echo $inc_details[0]->other_provider_img;?>" type="text" tabindex="2" placeholder="Provider Impressions" data-errors="{filter_required:'Provider Impressions should not be blank!'}">
                        </div>
                    </div>
                    <?php } ?>
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
                    
                    </div>

       
              
                
                <?php 

                if($user_group == 'UG-BIKE-DCO'){ ?>
</div>

<!--<div class="width100 dr_para">-->
<div class="width50 float_left">

                
<div class="width100 dr_para">
    <div class=" width100 single_record_back"> 
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
                            <input name="start_from_base" tabindex="20" class="form_input EndDate filter_required" placeholder="H:i" type="text" value="<?php if(isset($driver_data[0]->start_from_base)){  date('H:i:s',strtotime($driver_data[0]->start_from_base)); }else{ echo $inc_details_data[0]->inc_datetime; 
                                } ?>"  data-errors="{filter_required:'Start From Base should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly"  >
                            }
                        </div>
                    </div>
               <?php 
                     $responce_time_remark = '';
                    $hide_remark = 'hide';
                  
                    if($driver_data[0]->responce_time_remark != ''){ 
                        $responce_time_remark = get_responce_time_remark($driver_data[0]->responce_time_remark);                        $hide_remark = '';
                        
                    }
                  
                    ?>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="at_scene" tabindex="15" class="form_input filter_if_not_blank EndDate filter_required" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php if(isset($driver_data[0]->dp_on_scene)){ echo date('H:i:s',strtotime($driver_data[0]->dp_on_scene)); } ?>"  readonly="readonly" >
                        </div>
                    </div>
                    <div class="width100 float_left">
                        <div class="width50 drg float_left <?php echo $hide_remark; ?>" id="responce_time_remark">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Remark<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                 <input type="text" data-errors="{filter_required:'Remark should not be blank!' } " name="responce_time_remark" id="responce_remark" data-value="<?php echo $responce_time_remark; ?>" value="<?php echo $driver_data[0]->responce_time_remark; ?>" class="mi_autocomplete"  data-href="{base_url}auto/get_responce_time_remark"  placeholder="Remark" data-callback-funct="responce_remark_change" TABINDEX="8">

                            </div>
                        </div>
                           <div class="width50 drg float_left hide" id="responce_time_remark_other">
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
                    <div class="width33 drg float_left hide">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At Hospital/ Ambulance: </div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class="form_input filter_if_not_blank EndDate " placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  value="<?php if(isset($driver_data[0]->dp_hosp_time)){ echo date('H:i',strtotime($driver_data[0]->dp_hosp_time)); } ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="width33 drg float_left hide">
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
                </div>
            </div>




            <div class="width50 float_left">

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
             

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Start From Base <span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="start_from_base" id="start_from_base" tabindex="20" class="form_input filter_required EndDate filter_required filter_gretherthan[inc_datetime]" placeholder="Y-m-d H:i:s" type="text" value="<?php
                            if (isset($driver_data[0]->start_from_base)) {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->start_from_base));
                            }else{ echo $inc_details_data[0]->inc_datetime;
                                }
                            
                            ?>"  data-errors="{filter_required:'Start From Base should not be blank!',filter_time_hm:'Please enter valid time(H:i)' ,filter_gretherthan:'Start from base should not be grater than Call DateTime'}"  readonly="readonly" >
                        </div>
                    </div>

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene <span class="md_field">*</span> : </div>
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
                            <div class="style6 float_left">From Scene <span class="md_field">*</span> : </div>
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
                     <?php 
                    $responce_time_remark = '';
                    $hide_remark = 'hide';
                  
                    if($driver_data[0]->responce_time_remark != ''){ 
                        $responce_time_remark = get_responce_time_remark($driver_data[0]->responce_time_remark);                        $hide_remark = '';
                        
                    }                 
                    ?>
                    <div class="width100 float_left">
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
                    <div class="width33 drg float_left hide">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At Hospital/ Ambulance : </div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class=" form_input AtHospDate filter_gretherthan[from_scene]" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'At Hospital/ Ambulance should not be grater than From Scene'}"  value="<?php
                            if (isset($driver_data[0]->dp_hosp_time) && $driver_data[0]->dp_hosp_time != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hosp_time));
                            }else{ echo $inc_details_data[0]->inc_datetime;
                            }
                            ?>" readonly="readonly" id="at_hospitals_ambulance1" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left hide">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Hand over : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="hand_over" tabindex="18" class="form_input  HandoverDate" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Hand over  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php
                            if (isset($driver_data[0]->dp_hand_time) && $driver_data[0]->dp_hand_time != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hand_time));
                            }else{ echo $inc_details_data[0]->inc_datetime;
                            }
                            ?>" readonly="readonly" id="hand_over" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Back to base<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="back_to_base" tabindex="19" class="filter_required form_input BacktobaseDate filter_gretherthan[at_hospitals_ambulance1]" placeholder="H:i" type="text" data-base="search_btn" value="<?php
                            if (isset($driver_data[0]->dp_back_to_loc) && $driver_data[0]->dp_back_to_loc != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc));
                            }else{ echo $inc_details_data[0]->inc_datetime;
                            }
                            ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)',filter_gretherthan:'Hand over should not be grater than At Hospital/ Ambulance'}" id="back_to_base_not" <?php echo $disabled; ?>>
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
                    //var_dump($previous_odometer);
                   
                    ?>
                    <div class="width100">
                        <div class="width100 single_record_back">                                     

                            <h3 class=" width_25 float_left">Odometer :</h3>
                            <span class=" float_left" style="    margin-top: 3px;">Previous Odometer: <?php echo @$previous_odometer; ?> </span>
                            <a class="float_left click-xhttp-request odometer_icon" style="margin-top: 3px; color:#2F419B;" data-href="<?php echo base_url();?>/pcr/last_ten_odometer" data-qr="amb_no=<?php echo $vahicle_info[0]->amb_rto_register_no; ?>">Previous Odometer List</a>
                        </div>

                    </div>
                    <?php
                    $odo_disabled = "";
                    $previous_odo = $previous_odometer;
                    $filter_greterthan = "filter_valuegreaterthan[" . $previous_odo . "]";
                    $odometer =  $previous_odometer+500;
                    

                    $filter_rangelength = "filter_rangelength[" . $previous_odometer . "-".$odometer."]";

                    if (!($previous_odometer)){
                       
                        $odo_disabled = 'readonly="readonly"';
                       // $odo_end_disabled = 'readonly="readonly"';
                       // $odo_scene_disabled = 'readonly="readonly"';
                        //$odo_hospital_disabled = 'readonly="readonly"';
                        //$odo_from_scene_disabled = 'readonly="readonly"';
                       // $odo_handover_disabled = 'readonly="readonly"';
                        
                        $filter_greterthan = "";
                        //$filter_rangelength = "";
                    }
                    if($get_odometer[0]->from_scene_odometer != '' && $reopen != 'y'){
                        $odo_from_scene_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->end_odmeter != '' && $reopen != 'y'){
                        //$odo_end_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->scene_odometer != '' && $reopen != 'y'){
                        $odo_scene_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->hospital_odometer != '' && $reopen != 'y'){
                        $odo_hospital_disabled = 'readonly="readonly"';
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
                                <input name="scene_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8] filter_required <php echo $filter_rangelength;?>" placeholder="Enter Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->scene_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $odometer_scene; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="scene_odometer_pcr" <?php if( $reopen != 'y'){  echo $odo_scene_disabled1; } ?> >
                            </div>
                        </div>
                        <input name="from_scene_odometer"  tabindex="20" class="form_input  filter_maxlength[8] " placeholder="Enter from Scene Odometer" type="text" data-base="search_btn" value="" hidden>
                        <input name="hospiatl_odometer"  tabindex="20" class="form_input  filter_maxlength[8] " placeholder="Enter hospital Odometer" type="text" data-base="search_btn" value=""  hidden>

                        <!-- <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">From Scene Odometer : </div>
                            </div>
                            <div class="width50 float_left" id="from_scene_view">
                                <input name="from_scene_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input  filter_maxlength[8] " placeholder="Enter from Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->from_scene_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $get_odometer[0]->scene_odometer; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="from_scene_odometer_pcr" <?php  if( $reopen != 'y'){ echo $odo_from_scene_disabled; } ?> >
                            </div>
                        </div> -->
                        <!-- <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">At Hospital Odometer : </div>
                            </div>
                            <div class="width50 float_left" id="hos_view">
                                <input name="hospiatl_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input  filter_maxlength[8] " placeholder="Enter hospital Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->hospital_odometer; ?>"  data-errors="{filter_required:'hospital Odometer should not be blank!',filter_valuegreaterthan:'hospital Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Hospital Odometer should At Scene Odometer+100',filter_maxlength:'Hospital Odometer number at max 7 digit long.'}" id="hospital_odometer_pcr"  <?php if( $reopen != 'y'){  echo $odo_hospital_disabled1; } ?> >
                            </div>
                        </div> -->
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Handover Odometer : </div>
                            </div>
                            <div class="width50 float_left" id="handover_view">
                                <input name="handover_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8] " placeholder="Enter Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->handover_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $get_odometer[0]->handover_odometer; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="handover_odometer_pcr" <?php if( $reopen != 'y'){  echo $odo_handover_disabled; } ?> >
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">END Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="end_odometer_textbox">
                                <input name="end_odmeter" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="21"  maxlength="7" id="end_odometer_input" class="filter_required form_input  filter_maxlength[8] filter_rangelength_old[<?php echo $previous_odometer; ?>-<?php echo $previous_odometer+1000;?>] filter_valuegreaterthan_old[<?php echo $previous_odometer; ?>]" placeholder="Enter END Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->end_odmeter; ?>"  data-errors="{filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_valuegreaterthan:'End Odometer should less than At Hospital Odometer + 500',filter_maxlength:'END Odometer at max 7 digit long.',filter_required:'End Odometer should be not blank',filter_rangelength:'End Odometer should less than At Hospital Odometer + 500'}" <?php if( $reopen != 'y'){  echo $odo_end_disabled; } ?>>
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
                    <textarea name='valid_remark' class="filter_required " data-errors="{filter_required:'Remark should not be blank!'}"><?php echo $inc_details[0]->valid_remark; ?></textarea>
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
            <input type="hidden" name="category" id="amb_category" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
            
            <input  type="hidden" name="receiving_host" id="receiving_host" value="Patient_Not_Available">
            <input  type="hidden" name="tc_dtl_state" id="tc_dtl_state" value="<?php echo $inc_details_data[0]->inc_state_id; ?>">
            <input  type="hidden" name="tc_dtl_districts" id="tc_dtl_districts" value="<?php echo $inc_details_data[0]->inc_district_id; ?>">
            <input  type="hidden" name="tc_dtl_ms_city" id="tc_dtl_ms_city" value="<?php echo $inc_details_data[0]->inc_city_id; ?>">
            <input  type="hidden" name="ercp_advice" id="ercp_advice_input" value="advice_No">
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
                        <input type="hidden"  name="epcr_call_type" id="epcr_call_type" value="1">
                    <input type="hidden" name="inc_datetime" id="inc_datetime" value="<?php echo $inc_details_data[0]->inc_datetime; ?>">
                     <input type="hidden" name="reopen" id="reopen" value="<?php echo $reopen;?>">
                     <?php if ($revalidate == '1') {?>
                        <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}job_closer/save_job_closure_revalidate' data-qr='' TABINDEX="33">
                        <?php } else {?>

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
       // defaultValue: $mindate,
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
        $("#at_scene" ).datepicker( "destroy" );
        $('#at_scene').last().datepicker('refresh');
        var start_from_base = $('#at_scene').val();
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
            document.getElementById("back_to_base_not").disabled = false;
        }else{
            document.getElementById("at_hospitals_ambulance1").disabled = true;
            document.getElementById("back_to_base_not").disabled = true;
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
            document.getElementById("back_to_base").disabled = false;
        }else{
            document.getElementById("back_to_base").disabled = true;
        }
    });
    $('#back_to_base').on('change',function(){
        $("#back_to_base" ).datepicker( "destroy" );
        $('#back_to_base').last().datepicker('refresh');
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

    // // $('#gps_odo').click(function(){
    // function gps_odo(){
    //     var vehicle_no = $("input[name='amb_reg_id']").val();
    //     vehicle_no = vehicle_no.replace (/-/g, "");
    //     // vehicle_no = "MA55NU2247";
    //     var start_time = $("input[name='start_from_base']").val();
    //     // var start_time = "06-09-2022 10:51:00";
    //     var end_time = $("input[name='back_to_base']").val();
    //     // var end_time = "06-09-2022 13:21:00";
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
        var start_time = $("input[name='start_from_base']").val();
        // var start_time = "06-09-2022 10:51:00";
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