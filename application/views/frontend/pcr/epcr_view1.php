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
    <div class="head_outer"><h3 class="txt_clr2 width1">Closure Information</h3> </div>     
    <form method="post" name="" id="call_dls_info" >
        <div class="epcr">

            <div class="width50 float_left left_align">
                <div class="single_record_back">                                     
                    <h3>Incident Information</h3>
                </div>
                <div class="width100 float_left drg">
                    <div class="width_6 float_left">
                        <div class="style6 float_left">Date<span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_14 float_left" style="padding-top: 4px;">
                        <?php echo date('d-m-Y', strtotime($inc_details_data[0]->inc_datetime)); ?>
                    </div>
                    <input name="date" tabindex="1" class="form_input filter_required " placeholder="Date" type="hidden" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!'}" value="<?php echo date('d-m-Y', strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
                    <div class="width_16 float_left">
                        <div class="style6 float_left">Dispatch Time<span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_10 float_left" style="padding-top: 4px;">
                        <?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>
                        <input name="time" tabindex="2" class="form_input filter_required" placeholder="Time" type="hidden" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
                    </div>
                    <div class="width_13 float_left">
                        <div class="style6 float_left">Incident ID<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width_14 float_left" style="padding-top: 4px;">
           
                   <div> <a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc_ref_id; ?>" style="color:#000;"><?php echo $inc_ref_id; ?></a></div>
                        <input name="inc_ref_id" tabindex="5" class="form_input filter_required" placeholder=" Incident Id" type="hidden" data-base="send_sms" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>" readonly="readonly">
                    </div>
                    <div class="width_12 float_left">
                        <div class="style6 float_left">Assign By <span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_11 float_left" style="padding-top: 4px;">
                        <?php echo $inc_added_by; ?>
                    </div>
                </div>
                <div class="width100 float_left drg">
                    <div class="width_20 float_left">
                        <div class="style6 float_left">Chief Complaint <span class="md_field">*</span> :</div>
                    </div>
                    <div class="width_50 float_left">
                        <?php echo $ct_type; ?>
                    </div>
                </div>
                <!--                <div class="width50 float_left drg">
                                    <div class="width33 float_left">
                                        <div class="style6 float_left">Time<span class="md_field">*</span> :</div>
                                    </div>
                                    <div class="width33 float_left">
                <?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>
                                        <input name="time" tabindex="2" class="form_input filter_required" placeholder="Time" type="hidden" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php echo date("H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="width50 float_left drg">
                                    <div class="width33 float_left">
                                        <div class="style6 float_left">Incident ID<span class="md_field">*</span> : </div>
                                    </div>
                                    <div class="width33 float_left">
                <?php echo $inc_ref_id; ?>
                                        <input name="inc_ref_id" tabindex="5" class="form_input filter_required" placeholder=" Incident Id" type="hidden" data-base="send_sms" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>" readonly="readonly">
                                    </div>
                                </div>-->
                <div id="pat_details_block">
                    <div class="width100">
                        <div class="single_record_back">                                     
                            <h3>Patient Details  </h3>
                        </div>
                        <div class="width_40 float_left drg">
                            <div class=" float_left ">
                                <div class="style6 float_left">Patient ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_65 float_left">
                                <?php
                                if (!empty($inc_details[0]->ptn_id)) {
                                    $disabled = "disabled";
                                }
                                ?>

                                <select name="pat_id" tabindex="8" id="pcr_pat_id" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms"> 
                                    <option value="" <?php //echo $disabled; ?>>Select patient id</option>
                                    <?php foreach ($patient_info as $pt) { ?>
                                        <option value="<?php echo $pt->ptn_id; ?>" <?php
//                                        if ($pt->ptn_id == $patient_id) {
//                                            echo "selected";
//                                        }
                                        ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fname . " " . $pt->ptn_lname; ?></option>
                                            <?php } ?>
                                    <option value="0">Other</option>
                                </select>

                                <input class="add_button_hp click-xhttp-request float_right mipopup" id="add_button_pt" name="add_patient" value="Add" data-href="{base_url}pcr/patient_details" data-qr="filter_search=search&amp;tool_code=add_patient&showprocess=yes&inc_ref_id=<?php echo $inc_ref_id; ?>" type="button" data-popupwidth="1250" data-popupheight="1000" style="display:none;">
                            </div>
                        </div>
                        <div class="width_25 float_left drg">
                            <div class=" float_left">
                                <div class="style6 float_left">Age: </div>
                            </div>
                            <div class="width_65 float_left">
                                <input name="patient_age" tabindex="9" class="form_input" placeholder=" Age" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Age should not be blank!'}" value="<?php //$pt_info[0]->ptn_age; ?>" readonly="readonly">
                            </div>
                        </div>

                        <div class="width33 float_left gen">
                            <div class=" float_left outer_gen">
                                <div class="style6 float_left">Gender<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_68 float_left">
        <!--                        <input name="gender" tabindex="13" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient gender should not be blank!'}" value="<?= get_gen($pt_info[0]->ptn_gender); ?>">-->
                                <select id="patient_gender" name="gender"  data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="10" disabled="disabled">
                                    <option value=''>Gender</option>
                                    <option value="M" <?php
//                                    if ($pt_info[0]->ptn_gender == 'M') {
//                                        echo "Selected";
//                                    }
                                    ?>>Male</option> 
                                    <option value="F" <?php
//                                    if ($pt_info[0]->ptn_gender == 'F') {
//                                        echo "Selected";
//                                    }
                                    ?>>Female</option>
                                    <option value="O" <?php
//                                    if ($pt_info[0]->ptn_gender == 'O') {
//                                        echo "Selected";
//                                    }
                                    ?>>Other</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="width100">
                        <div class="width100 float_left drg">
                            <div class=" width_16 float_left">
                                <div class="style6 float_left">Patient Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_27 float_left">
                                <input name="ptn_fname" id="ptn_fname" tabindex="11" class="form_input filter_required" placeholder="Patient First Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php //$pt_info[0]->ptn_fname; ?>" readonly="readonly">
                            </div>
                            <div class="width_27 float_left">
                                <input name="ptn_mname" tabindex="12" class="form_input" placeholder="Patient Middle Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php //$pt_info[0]->ptn_mname; ?>" readonly="readonly">
                            </div>
                            <div class="width_27 float_left drg">
                                <input name="ptn_lname" tabindex="13" class="form_input" placeholder="Patient Last Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?php //$pt_info[0]->ptn_lname; ?>" readonly="readonly">
                            </div>
                        </div>


                        <div class="width100">

                            <div id="ptn_form_lnk" class="style6 float_left">

<!--                                <a data-href='{base_url}pcr/patient_details' class='click-xhttp-request style1' data-qr='ptn_id=<?= @$pt_info[0]->ptn_id; ?>&amp;inc_ref_id=<?php echo $inc_ref_id; ?>' data-popupwidth='1250' data-popupheight='870'>( Update patient details )</a>-->

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
                <div class="width100">
                    <div class="single_record_back">                                     
                        <h3>Incident Address</h3>
                    </div>

                    <div class="width50 float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">State<span class="md_field">*</span>  : </div>
                        </div>
                        <div class="width_62 float_left">
                            <div id="tc_dtl_state">


                                <?php
                                //var_dump( $inc_details_data[0]->inc_state_id);
                                //$state_id = $pt_info[0]->inc_state_id; 
                                $state_id = $inc_details_data[0]->inc_state_id;
                                ?>


                                <?php
                                $st = array('st_code' => $state_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');

                                echo get_state($st);
                                ?>



                            </div>

                        </div>
                    </div>
                    <div class="width50 float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">District<span class="md_field">*</span>  : </div>
                        </div>
                        <div class="width_62 float_left">
                            <div id="tc_dtl_dist">



                                <?php
                                $district_id = '';

// if ($inc_details[0]->inc_district_id == '') {
                                // $district_id = $pt_info[0]->ptn_district;
                                $district_id = $inc_details_data[0]->inc_district_id;
//  }
                                ?>

                                <?php
                                $dt = array('dst_code' => $district_id, 'st_code' => $state_id, 'auto' => 'tc_dtl', 'rel' => 'tc_dtl', 'disabled' => '');

                                echo get_district($dt);
                                ?>


                            </div>
                        </div>
                    </div>

                </div>
                <div class="width100">
                    <div class="width50 float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">City/Village<span class="md_field"></span> : </div>
                        </div>
                        <div class="width_62 float_left">


                            <div id="tc_dtl_city">      

                                <?php
                                $city_id = '';
                                //$city_id = $pt_info[0]->ptn_city;
                                $city_id = $inc_details_data[0]->inc_city_id;
                                ?>


                                <?php
                                $ct = array('cty_id' => $city_id, 'dst_code' => $district_id, 'auto' => 'tc_auto_addr', 'rel' => 'tc_dtl', 'disabled' => '');
                                echo get_city($ct);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="width50 float_left">
                        <div class="width33 float_left">
                            <div class="style6 float_left">Locality<span class="md_field">*</span>   : </div>
                        </div>
                        <div class="width_62 float_left">
                            <?php
//   if ($inc_details[0]->inc_address == '') {
                            $inc_address = $inc_details_data[0]->inc_address;
//  } 
                            ?>
                            <input name="locality" id="locality" tabindex="33" class="form_input filter_required" placeholder="Locality" type="text" data-base="search_btn" data-errors="{filter_required:'Locality should not be blank!'}" value="<?= @$inc_address ?>">
                        </div>
                    </div>

                </div>
                <div id="amb_details_block">
                    <div class="width100">
                        <div class="single_record_back">                                     
                            <h3>Ambulance Details</h3>
                        </div>

                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance No<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <select name="amb_reg_id" tabindex="22" id="pcr_amb_id" class="filter_required" data-errors="{filter_required:'Ambulance should not be blank!'}"> 
                                    <option value="">Select Ambulance</option>
                                    <?php foreach ($vahicle_info as $amb) {
                                        ?>
                                        <option value="<?php echo $amb->amb_rto_register_no; ?>" <?php
                                        if ((trim($amb->amb_rto_register_no)) == (trim($inc_emp_info[0]->amb_rto_register_no))) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $amb->amb_rto_register_no; ?></option>
                                            <?php } ?>

                                </select>
                                <input id="add_pcr_amb" class=" onpage_popup float_right" name="add_amb" value="Add Ambulance" data-href="{base_url}/amb/add_amb" data-qr="output_position=popup_div&amp;tool_code=add_ambu" data-popupwidth="1000" data-popupheight="800" type="button" style="display:none;">
        <!--                              <input name="amb_reg_id" tabindex="5" class="form_input filter_required" placeholder=" Ambulance No" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance No should not be blank!'}" value="<?= @$inc_emp_info[0]->amb_rto_register_no; ?>">-->
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Ambulance Category<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">
                                <input name="category" id="amb_category" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
                            </div>

                        </div>

                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT ID : </div>
                            </div>
                            <div class="width_62 float_left">
                                <?php //var_dump($inc_emp_info); ?>
<!--                                <input name="emt_name" tabindex="24" class="form_input filter_required" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>" >-->
                                <input name="emt_id" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_emso_id" data-value="<?= $inc_emp_info[0]->amb_emt_id; ?>" value="<?= $inc_emp_info[0]->amb_emt_id; ?>" type="text" tabindex="1" placeholder="EMT ID" data-callback-funct="show_emso_id"  id="emt_list" data-errors="{filter_required:'Ambulance should not be blank!'}">
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">EMT Name : </div>
                            </div>
                            <div class="width_62 float_left" id="show_emso_name">
                                <input name="emt_name" id="emt_id_new" tabindex="25" class="form_input" placeholder="EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?> <?= $inc_emp_info[0]->e_last_name; ?>">
                                <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">
                            </div>
                            
                        </div>

                    </div>
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
                                <input name="pilot_id"  class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_pilot_id" data-value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" type="text" tabindex="1" placeholder="Pilot ID" data-callback-funct="show_pilot_idnew"  id="pilot_list" data-errors="{filter_required:'Pilot ID should not be blank!'}">
                            </div>
                          
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot Name : </div>
                            </div>
                            <div class="width_62 float_left" id="show_pilot_name">
                                <input name="pilot_name" id="pilot_id_new" tabindex="25" class="form_input" placeholder="Pilot Name1" type="text" data-base="search_btn" data-errors="{filter_required:'Ambulance should not be blank!'}" value="<?= $inc_emp_info[0]->pilot_name; ?>  <?= $inc_emp_info[0]->p_last_name; ?>">
                                <input name="pilot_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="width100" id="pilot_other_textbox">
                            </div>
                   <!-- <div class="width100">
                        <div class="width50 float_left drg">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left" id="show_pilot_id">
                                <input name="pilot_id" tabindex="27" class="form_input filter_required" placeholder=" Pilot ID" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Pilot Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_62 float_left">

                                <input name="pilot_name" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_clg_pilot" data-value="<?= $inc_emp_info[0]->pilot_name; ?>" value="<?= $inc_emp_info[0]->pilot_name; ?>" type="text" tabindex="1" data-errors="{filter_required:'Pilot Name should not be blank!'}" placeholder="Pilot Name" data-callback-funct="show_pilot_id_name" id="pilot_name_list">
                            </div>
                        </div>


                    </div>-->
                    <?php if(($inc_emp_info[0]->hp_id == '' || $inc_emp_info[0]->hp_id == null || $inc_emp_info[0]->hp_id == 0) && $user_group != 'UG-BIKE-DCO'){
                        ?>
                         <div class="width100">
                        <div class="width100 drg float_left">
                            <div class="width_16 float_left">
                                <div class="style6 float_left">Ward Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_83 float_left base_location">
                                <input name="wrd_location" id="wrd_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->ward_name; ?>" readonly="readonly">
                                <input name="wrd_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->ward_id; ?>">
                            </div>
                        </div>

                    </div>   
                            <?php
                    }else{ //hosvar_dump($inc_emp_info[0]->hp_name);?>
                    <div class="width100">
                        <div class="width100 drg float_left">
                            <div class="width_16 float_left">
                                <div class="style6 float_left">Base Location<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width_83 float_left base_location">
                                <input name="base_location" tabindex="23" id="base_location" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>" readonly="readonly">
                                <input name="base_location_id" tabindex="9" class="form_input filter_required" placeholder="Enter Base Location" type="hidden" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_id; ?>">
                            </div>
                        </div>
                            </div> <?php } ?>
                    
                    </div>
                    <div class="width100 float_left">
                    <div class="width100">
                    <div class="single_record_back">                                     
                        <h3>Medical Information</h3>
                    </div>
                    </div>
                    <div class="width100">
                        <div class="width33 drg float_left">
                            <div class="width50 ">
                                <div class="style6 float_left">Medical Advice<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left">
                                <input name="ercp_advice" id="ercp_advice_input" tabindex="3" class="mi_autocomplete form_input filter_required" placeholder="ERCP Advice" type="text" data-base="search_btn" data-errors="{filter_required:'Please select ERCP advice from dropdown list'}" data-href="{base_url}auto/ercp_advice" value="<?php echo @$inc_details[0]->loc; ?>"  data-value="<?= @$inc_details[0]->level_type; ?>"  data-callback-funct="ercp_advice_taken">
                            </div>
                        </div>
                        <div  class="width33 float_left hide" id="ercp_advice">
                            <?php //if (@$inc_details[0]->ercp_advice != '') { ?>
                                <div class="width100">
                                    <div class="width100 rec_hp float_left ">
                                        <input name="ercp_advice_Taken" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_auto_clg_dm?clg_group=UG-ERCP" data-value="<?= @$inc_details[0]->ercp_advice_Taken; ?>" value="<?= @$indent_data[0]->ercp_advice_Taken; ?>" type="text" tabindex="1" placeholder="Advice given by [Dr.Name]" data-errors="{filter_required:'Advice given by [Dr.Name] should not be blank!'}" data-qr='clg_group=UG-ERCP&amp;output_position=content'  <?php echo $update; ?>>
                                    </div>
                                </div>
                            <?php // } ?>

                        </div>
                         <div class="width33 drg float_left">
                            <div class="width50 ">
                                <div class="style6 float_left">Inc. Area Type<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left">
                                <select name="inc_area_type" id="inc_area_type" tabindex="8"  class="" data-errors="{filter_required:'Inc. Area Type should not be blank!'}" data-base="send_sms"> 
                                    <option value="">Select Area Type</option>
                                    <option value="Rural">Rural</option>
                                    <option value="Urban">Urban</option>
                                    <option value="Tribal">Tribal</option>
                                    <option value="Metro/NA">Metro/NA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="width100">
                    <div class="width_40 drg float_left">
                        <div class="width_35 float_left">
                            <div class="style6 float_left">Case Type <span class="md_field">*</span> : </div>
                        </div>
                        <?php 
                        if($user_group == 'UG-BIKE-DCO'){
                          ?>
                          <div class="width_60 float_left base_location">
                            <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="<?= @$inc_details[0]->provider_casetype; ?>" data-value="<?= @$inc_details[0]->case_name; ?>" data-href="{base_url}auto/get_providercase_type" data-qr="" id="provider_casetype" >
                        </div>
                          <?php  
                            
                        }else{
                            ?>
                            <div class="width_60 float_left base_location">
                            <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="<?= @$inc_details[0]->provider_casetype; ?>" data-value="<?= @$inc_details[0]->case_name; ?>" data-href="{base_url}auto/get_providercase_type" data-qr="" id="provider_casetype" data-callback-funct="remove_mandatory_fields_new">
                        </div>
                            <?php
                        }?>
                        
                    </div>
                    <div class="width_60 drg float_left">
                        <div class="width_34 float_left">
                            <div class="style6 float_left">Provider Impressions<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width_65 float_left base_location">
                            <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?= @$inc_details[0]->provider_impressions; ?>" data-value="<?= @$inc_details[0]->pro_name; ?>" data-href="{base_url}auto/get_provider_imp" data-qr="" id="provider_impressions" data-callback-funct="remove_mandatory_fields">
                        </div>
                    </div>
                </div>
                
                <div class="width100" id='other_provider_impression'>
                </div>
                            </div>
                            
                    <div class="width100">
                    <div class="width100 drg float_left">
                    
                        <div class="width100 float_left">
                        <div class="single_record_back">                                     
                            <h3>Baseline Condition Handover</h3>
                        </div>
                        </div>

                    </div>
                            </div>
                            <div class="width100">
                <div class="width20 form_field float_left">
                    <div class="label">LOC <span class="md_field">*</span></div>
                    <div class="input">
                        <input name="baseline_con[loc]" tabindex="3" class="mi_autocomplete form_input" placeholder=" LOC " type="text" data-base="search_btn"  data-href="{base_url}auto/loc_level" value="<?php echo @$inc_details[0]->loc; ?>"  data-value="<?= @$inc_details[0]->level_type; ?>" id="loc" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Airway</div>
                    <div class="input">
                        <input name="baseline_con[airway]"  id="baseline_con_airway" class="form_input mi_autocomplete" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Patent" data-href="{base_url}auto/get_airway" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Breathing</div>
                    <div class="input">
                        <input name="baseline_con[breathing]" id="baseline_con_breathing" class="form_input mi_autocomplete" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Patent" data-href="{base_url}auto/get_breathing" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Circulation</div>
                    <div class="input">
                    <input name="baseline_con[circulation_radial]" id="baseline_con_circulation_radial" value="<?php echo $add_asst[0]->asst_pulse_radial; ?>"  class="form_input mi_autocomplete" placeholder="Radial" data-href="{base_url}auto/get_pa_opt"  type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">&nbsp;</div>
                    <div class="input">
                    <input name="baseline_con[circulation_carotid]" id="baseline_con_circulation_carotid" value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>"  class="form_input mi_autocomplete" placeholder="Carotid" data-href="{base_url}auto/get_pa_opt"  type="text" data-value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>" tabindex="7" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                </div>
                
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">Temp</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[temp]" id="baseline_con_temp" value="<?php echo $asst[0]->asst_temp; ?>"  class="inp_bp form_input" placeholder="82 to 110"  type="text" tabindex="19" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">BSL</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[bsl]" value="<?php echo $add_asst[0]->asst_bsl; ?>" class="form_input" placeholder="Enter BSL"   type="text" tabindex="11">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">Pulse</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[pulse]" value="<?php echo $asst[0]->asst_pulse; ?>"  class="form_input" placeholder="Enter Pulse"  type="text"  tabindex="7">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">O2Sat</div>
                    <div class="input">
                         <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[osat]" id="baseline_con_osat" value="<?php echo $asst[0]->asst_o2sat; ?>"  class="inp_bp form_input" placeholder="1 To 100"  type="text" tabindex="18" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">RR</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[rr]" id="baseline_con_rr" value="<?php echo $asst[0]->asst_rr; ?>" class="form_input" placeholder="Enter RR" type="text"  tabindex="15" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                
                </div>
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">GCS</div>
                    <div class="input top_left">
                        <input name="baseline_con[gcs]" id="baseline_con_gcs" value="<?php echo $add_asst[0]->asst_gcs; ?>" class="form_input mi_autocomplete " placeholder="Score" data-href="{base_url}auto/gcs_score"  type="text" data-value="<?php echo $add_asst[0]->score; ?>"  tabindex="10" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
               
                <div class="form_field width20 float_left">
                    <div class="label">BP</div>
                    <div class="input top_left">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[bp_syt]" id="baseline_con_bp_syt" value="<?php echo $asst[0]->asst_bp_syt; ?>" class="inp_bp form_input " placeholder="SYT"  type="text" tabindex="16" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label none_prop">&nbsp;</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="baseline_con[bp_dia]" id="baseline_con_bp_dia" value="<?php echo $asst[0]->asst_bp_dia; ?>" class="inp_bp form_input " placeholder="Dia"  type="text" tabindex="17" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label disnon">Skin</div>
                    <div class="input">
                        <input name="baseline_con[skin]" id="baseline_con_skin" value="<?php echo $add_asst[0]->asst_pulse_skin; ?>"  class="form_input mi_autocomplete" placeholder="Skin" data-href="{base_url}auto/get_pulse_skin"   type="text"  data-value="<?php echo $add_asst[0]->ps_type; ?>" tabindex="9" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">Pupils</div>
                    <div class="input">
                    <input name="baseline_con[pupils]" id="baseline_con_pupils" value="<?php echo $add_asst[0]->asst_pupils_right; ?>"  class="form_input mi_autocomplete" placeholder="Right" data-href="{base_url}auto/pupils_type"  type="text" data-value="<?php echo $add_asst[0]->pp_type_right; ?>" tabindex="12" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                 </div>
                </div>
            </div>




            <div class="width50 float_left">
           
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
                        <div class="style6 float_left">Name of Receiving Hospital/Ambulance<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width100 rec_hp float_left">
<!--                        <input name="receiving_host" tabindex="7.2" class="mi_autocomplete form_input filter_required" placeholder=" Name of Receiving Hospital" type="text" data-base="send_sms" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu?dist=<?php echo $inc_details[0]->inc_district_id;?>" data-value="<?= @$inc_details[0]->hp_name; ?>" value="<?= @$inc_details[0]->hp_id; ?>" id="receiving_host" data-callback-funct="hospital_other_textbox">-->
                        
                        <input name="inter[new_facility]" tabindex="7.2" class="mi_autocomplete form_input filter_required" placeholder=" Name of Receiving Hospital" type="text" data-base="send_sms" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?= @$inc_details[0]->hp_name; ?>" value="<?= @$inc_details[0]->hp_id; ?>" id="receiving_host" data-callback-funct="hospital_other_textbox">
                    </div>
                    <div id="other_hospital_textbox">
                        
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
                            <input name="start_from_base" tabindex="20" class="form_input EndDate filter_required" placeholder="H:i" type="text" value="<?php if(isset($driver_data[0]->start_from_base)){  date('H:i',strtotime($driver_data[0]->start_from_base)); } ?>"  data-errors="{filter_required:'Start From Base should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly"  >
                        </div>
                    </div>
              
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="at_scene" tabindex="15" class="form_input filter_if_not_blank EndDate filter_required" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php if(isset($driver_data[0]->dp_on_scene)){  date('H:i',strtotime($driver_data[0]->dp_on_scene)); } ?>"  readonly="readonly" >
                        </div>
                    </div>
                    <div class="width100 float_left">
                        <div class="width50 drg float_left hide" id="responce_time_remark">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Remark<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                 <input type="text" name="responce_time_remark" id="responce_remark" data-value="" value="" class="mi_autocomplete"  data-href="{base_url}auto/get_responce_time_remark"  placeholder="Remark" data-callback-funct="responce_remark_change" TABINDEX="8">
                                 
<!--                                <input name="responce_time_remark" tabindex="19" class="filter_required form_input" placeholder="Remark" type="text" data-base="search_btn" value="<?php if(isset($driver_data[0]->dp_back_to_loc)){ echo date('H:i',strtotime($driver_data[0]->dp_back_to_loc)); }?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}">-->
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
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At Hospital/ Ambulance: </div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class=" form_input filter_if_not_blank EndDate " placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  value="<?php if(isset($driver_data[0]->dp_hosp_time)){ echo date('H:i',strtotime($driver_data[0]->dp_hosp_time)); } ?>" readonly="readonly">
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
                        
                         <input id="pcr_district" name="pcr_district" tabindex="9" class="form_input mi_autocomplete filter_required" data-href="{base_url}auto/get_district/MH" placeholder="Incident District" type="text" data-nonedit="yes" data-errors="{filter_required:'Please select New District from dropdown list'}" data-callback-funct="district_wise_hospital_epcr" >


                    </div>

                    <div class="float_left width_52">

                        <div class="style6 float_left">Name of Receiving Hospital<span class="md_field">*</span>&nbsp;</div>

                        <div class="input" id="new_facility_box">

                            <input name="receiving_host" id="receiving_host" class="mi_autocomplete width100" placeholder="Name of Receiving Hospital" data-href="{base_url}auto/get_auto_hospital_new" type="text" data-errors="{filter_required:'Please select current facility from dropdown list',filter_greater_than_zero:'Name of Receiving Hospital should not be blank'}" id="current_facility" TABINDEX="13" data-callback-funct="hospital_other_textbox"> 

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
                        <input name="receiving_host" tabindex="7.2" class="mi_autocomplete form_input filter_required" placeholder=" Name of Receiving Hospital" type="text" data-base="send_sms" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_auto_hospital_new" data-value="<?= @$inc_details[0]->hp_name; ?>" value="<?= @$inc_details[0]->hp_id; ?>" id="receiving_host" data-callback-funct="hospital_other_textbox">
                    </div>-->
                    <div id="other_hospital_textbox">
                        <?php if (@$inc_details[0]->other_receiving_host != '') { ?>
                            <div class="width100">
                                <div class="width100 rec_hp float_left">
                                    <div class="style6 float_left">Name of Other Receiving Hospital/Ambulance<span class="md_field">*</span> :</div>
                                </div>
                                <div class="width100 rec_hp float_left ">
                                    <input name="other_receiving_host" class="filter_required " value="<?php echo @$inc_details[0]->other_receiving_host; ?>" type="text"  placeholder="Name of Other Receiving Hospital/Ambulance" data-errors="{filter_required:'Name of Other Receiving Hospital/Ambulance should not be blank!'}" autocomplete="off">
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="width_16 float_left">
                        <input type="button" name="send_sms" data-href="{base_url}pcr/send_hospital_sms" value="Send SMS" data-qr='output_position=inc_details' class="base-xhttp-request btn hide" style="width:92%;">
                    </div>


                </div>
                <div class="width100">
                    <div class="width100 drg float_left">
                    
                        <div class="width100 float_left">
                        <div class="single_record_back">                                     
                            <h3>Patient Condition Handover</h3>
                        </div>
                        </div>

                    </div>
                            </div>
                <div class="width100">
                <div class="width20 form_field float_left">
                    <div class="label">LOC <span class="md_field">*</span></div>
                    <div class="input">
                        <input name="pt_con_handover[loc]" tabindex="3" class="mi_autocomplete form_input" placeholder=" LOC " type="text" data-base="search_btn"  data-href="{base_url}auto/loc_level" value="<?php echo @$inc_details[0]->loc; ?>"  data-value="<?= @$inc_details[0]->level_type; ?>" id="loc_handover" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Airway</div>
                    <div class="input">
                        <input name="pt_con_handover[airway]"  id="pt_con_handover_airway" class="form_input mi_autocomplete" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Airway" data-href="{base_url}auto/get_airway" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Breathing</div>
                    <div class="input">
                        <input name="pt_con_handover[breathing]" id="pt_con_handover_breathing" class="form_input mi_autocomplete" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Breathing" data-href="{base_url}auto/get_breathing" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">Circulation</div>
                    <div class="input">
                    <input name="pt_con_handover[circulation__radial]" id="pt_con_handover_circulation_radial" value="<?php echo $add_asst[0]->asst_pulse_radial; ?>"  class="form_input mi_autocomplete" placeholder="Radial" data-href="{base_url}auto/get_pa_opt"  type="text" data-value="<?php echo $add_asst[0]->asst_pulse_radial; ?>" tabindex="6" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="width20 form_field float_left">
                    <div class="label">&nbsp;</div>
                    <div class="input">
                    <input name="pt_con_handover[circulation_carotid]" id="pt_con_handover_circulation_carotid" value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>"  class="form_input mi_autocomplete" placeholder="Carotid" data-href="{base_url}auto/get_pa_opt"  type="text" data-value="<?php echo $add_asst[0]->asst_pulse_carotid; ?>" tabindex="7" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                </div>
                
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">Temp</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[temp]"  id="pt_con_handover_temp" value="<?php echo $asst[0]->asst_temp; ?>"  class="inp_bp form_input" placeholder="82 to 110"  type="text" tabindex="19" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">BSL</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[bsl]" value="<?php echo $add_asst[0]->asst_bsl; ?>" class="form_input" placeholder="Enter BSL"   type="text" tabindex="11" >
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">Pulse</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[pulse]" value="<?php echo $asst[0]->asst_pulse; ?>"  class="form_input" placeholder="Enter Pulse"  type="text"  tabindex="7">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">O2Sat</div>
                    <div class="input">
                         <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[osat]"  id="pt_con_handover_osat" value="<?php echo $asst[0]->asst_o2sat; ?>"  class="inp_bp form_input" placeholder="1 To 100"  type="text" tabindex="18" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">RR</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[rr]" id="pt_con_handover_rr" value="<?php echo $asst[0]->asst_rr; ?>" class="form_input" placeholder="Enter RR" type="text"  tabindex="15" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                
                </div>
                <div class="width100">
                <div class="form_field width20 float_left">
                    <div class="label">GCS</div>
                    <div class="input top_left">
                        <input name="pt_con_handover[gcs]"  id="pt_con_handover_gcs" value="<?php echo $add_asst[0]->asst_gcs; ?>" class="form_input mi_autocomplete " placeholder="Score" data-href="{base_url}auto/gcs_score"  type="text" data-value="<?php echo $add_asst[0]->score; ?>"  tabindex="10" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
               
                <div class="form_field width20 float_left">
                    <div class="label">BP</div>
                    <div class="input top_left">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[bp_syt]" id="pt_con_handover_bp_syt" value="<?php echo $asst[0]->asst_bp_syt; ?>" class="inp_bp form_input " placeholder="SYT"  type="text" tabindex="16" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label none_prop">&nbsp;</div>
                    <div class="input">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')"  maxlength="3" name="pt_con_handover[bp_dia]" id="pt_con_handover_bp_dia" value="<?php echo $asst[0]->asst_bp_dia; ?>" class="inp_bp form_input " placeholder="Dia"  type="text" tabindex="17" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label disnon">Skin</div>
                    <div class="input">
                        <input name="pt_con_handover[skin]"  id="pt_con_handover_skin" value="<?php echo $add_asst[0]->asst_pulse_skin; ?>"  class="form_input mi_autocomplete" placeholder="Skin" data-href="{base_url}auto/get_pulse_skin"   type="text"  data-value="<?php echo $add_asst[0]->ps_type; ?>" tabindex="9" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width20 float_left">
                    <div class="label">Pupils</div>
                    <div class="input">
                    <input name="pt_con_handover[pupils]"  id="pt_con_handover_pupils" value="<?php echo $add_asst[0]->asst_pupils_right; ?>"  class="form_input mi_autocomplete" placeholder="Right" data-href="{base_url}auto/pupils_type"  type="text" data-value="<?php echo $add_asst[0]->pp_type_right; ?>" tabindex="12" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                 </div>
                </div>
                <div class="width100">
                    <div class="form_field width25 float_left">
                    <div class="label">Pt. Status during Transport</div>
                    <div class="input">
                        <input name="pt_con_handover[pt_status_during_status]" id="pt_con_handover_pt_status_during_status" class="inp_bp form_input  mi_autocomplete" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Patent" data-href="{base_url}auto/get_yn_opt" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                <div class="form_field width25 float_left">
                    <div class="label">Cardiac Arrest</div>
                    <div class="input">
                        <input name="pt_con_handover[cardiac]" id="pt_con_handover_cardiac"  class="inp_bp form_input  mi_autocomplete" value="<?php echo $asst[0]->asst_pt_status; ?>" placeholder="Select Cardiac" data-href="{base_url}auto/get_cardiac_arrest" type="text" data-value="<?php echo $asst[0]->asst_pt_status; ?>" tabindex="2" data-errors="{filter_required:'should not be blank!'}">
                    </div>
                </div>
                
                </div>
                <div class="width100 dr_para">
                    <div class=" width100 single_record_back">                                     
                        <h3 class="width_25 float_left">Driver Parameters: </h3>
                        
                        <?php 
                        $disabled = "";
                        if(empty($driver_data)){
                            $disabled = "disabled";
                        } ?>
                        <span class=" float_left" style="    margin-top: 3px;">Call DateTime<span class="md_field">*</span> : <?php echo date("d-m-Y H:i:s", strtotime($inc_details_data[0]->inc_datetime)); ?> </span>
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
                            <div class="style6 float_left">Start From Base <span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="start_from_base" id="start_from_base" tabindex="20" class="form_input filter_required EndDate filter_required" placeholder="Y-m-d H:i:s" type="text" value="<?php
                            if (isset($driver_data[0]->start_from_base)) {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->start_from_base));
                            }
                            ?>"  data-errors="{filter_required:'Start From Base should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  readonly="readonly" >
                        </div>
                    </div>

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene <span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="at_scene" tabindex="15" class="form_input filter_required StartDate  filter_required" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php
                            if (isset($driver_data[0]->dp_on_scene)) {
                                echo date('Y-m-d H:i', strtotime($driver_data[0]->dp_on_scene));
                            }
                            ?>" id="at_scene" readonly  <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">From Scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="from_scene" tabindex="16" class="form_input filter_if_not_blank FromDate" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'From Scene should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php
                            if (isset($driver_data[0]->dp_reach_on_scene) && $driver_data[0]->dp_reach_on_scene != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_reach_on_scene));
                            }
                            ?>" readonly="readonly" id="from_scene" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width100 float_left">
                        <div class="width50 drg float_left hide" id="responce_time_remark">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Remark : </div>
                            </div>
                            <div class="width_60 float_left">
                                <input type="text" name="responce_time_remark" id="responce_remark" data-value="<?php echo $driver_data[0]->responce_time_remark; ?>" value="" class="mi_autocomplete"  data-href="{base_url}auto/get_responce_time_remark"  placeholder="Remark" data-callback-funct="responce_remark_change" TABINDEX="8" >
                                      <!-- <input name="responce_time_remark" tabindex="19" class="filter_required form_input" placeholder="Remark" type="text" data-base="search_btn" value="<?php
                                if (isset($driver_data[0]->dp_back_to_loc)) {
                                    echo date('Y-m-d H:i', strtotime($driver_data[0]->dp_back_to_loc));
                                }
                                ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}">-->
                            
                            </div>
                        </div>
                        <div class="width50 drg float_left hide" id="responce_time_remark_other">
                            <div class="width33 float_left">
                                <div class="style6 float_left">Other Remark : </div>
                            </div>
                            <div class="width_60 float_left">
                                <input name="responce_time_remark_other" tabindex="19" class=" form_input" placeholder="Remark" type="text" data-base="search_btn" value="<?php
                                if (isset($driver_data[0]->dp_back_to_loc)) {
                                    echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc));
                                }
                                ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}">
                            
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
                            <div class="style6 float_left">At Hospital/ Ambulance: </div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class=" form_input filter_if_not_blank AtHospDate" placeholder="H:i" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"  value="<?php
                            if (isset($driver_data[0]->dp_hosp_time) && $driver_data[0]->dp_hosp_time != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hosp_time));
                            }
                            ?>" readonly="readonly" id="at_hospitals_ambulance1" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Hand over : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="hand_over" tabindex="18" class="form_input filter_if_not_blank HandoverDate" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Hand over  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php
                            if (isset($driver_data[0]->dp_hand_time) && $driver_data[0]->dp_hand_time != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_hand_time));
                            }
                            ?>" readonly="readonly" id="hand_over" <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Back to base<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="back_to_base" tabindex="19" class="filter_required form_input BacktobaseDate" placeholder="H:i" type="text" data-base="search_btn" value="<?php
                            if (isset($driver_data[0]->dp_back_to_loc) && $driver_data[0]->dp_back_to_loc != '0000-00-00 00:00:00') {
                                echo date('Y-m-d H:i:s', strtotime($driver_data[0]->dp_back_to_loc));
                            }
                            ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly" id="back_to_base" <?php echo $disabled; ?>>
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
                        $odo_end_disabled = 'readonly="readonly"';
                        $odo_scene_disabled = 'readonly="readonly"';
                        $odo_hospital_disabled = 'readonly="readonly"';
                        $filter_greterthan = "";
                        //$filter_rangelength = "";
                    }
                    if($get_odometer[0]->end_odmeter != ''){
                        $odo_end_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->scene_odometer != ''){
                        $odo_scene_disabled = 'readonly="readonly"';
                    }
                    if($get_odometer[0]->hospital_odometer != ''){
                        $odo_hospital_disabled = 'readonly="readonly"';
                    }
                    //var_dump($get_odometer[0]->hospital_odmeter);
                    ?>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Start Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left">
                                <input name="start_odmeter" tabindex="20" class="filter_required form_input <?php //echo $filter_rangelength; ?> filter_maxlength[8]" placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?php echo $previous_odometer; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!',filter_valuegreaterthan:'Start Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Start Odometer should <?php echo $previous_odometer; ?>',filter_maxlength:'Start Odometer number at max 7 digit long.'}" id="start_odometer_pcr" <?php echo $odo_disabled; ?> readonly="readonly">
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Scene Odometer : </div>
                            </div>
                            <div class="width50 float_left" id="scene_view">
                                <input name="scene_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input filter_maxlength[8]" placeholder="Enter Scene Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->scene_odometer; ?>"  data-errors="{filter_required:'Scene Odometer should not be blank!',filter_valuegreaterthan:'Scene Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Scene Odometer should <?php echo $get_odometer[0]->scene_odometer; ?>',filter_maxlength:'Scene Odometer number at max 7 digit long.'}" id="scene_odometer_pcr" <?php echo $odo_scene_disabled; ?> >
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">Hospital Odometer : </div>
                            </div>
                            <div class="width50 float_left" id="hos_view">
                                <input name="hospiatl_odometer" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="20" class="form_input  filter_maxlength[8]" placeholder="Enter hospital Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->hospital_odometer; ?>"  data-errors="{filter_required:'hospital Odometer should not be blank!',filter_valuegreaterthan:'hospital Odometer should greater than or equlto Previous Odometer',filter_rangelength:'Hospital Odometer should <?php echo $get_odometer[0]->hospital_odometer; ?>',filter_maxlength:'Hospital Odometer number at max 7 digit long.'}" id="hospital_odometer_pcr"  <?php echo $odo_hospital_disabled; ?> >
                            </div>
                        </div>
                        

                        <div class="width50 drg float_left">
                            <div class="width50 float_left">
                                <div class="style6 float_left">END Odometer<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width50 float_left" id="end_odometer_textbox">
                                <input name="end_odmeter" onkeyup="this.value=this.value.replace(/[^\d]/,'')" tabindex="21"  maxlength="7" id="end_odometer_input" class="filter_required form_input  filter_maxlength[8] filter_rangelength[<?php echo $previous_odometer; ?>-<?php echo $previous_odometer+500;?>]" placeholder="Enter END Odometer" type="text" data-base="search_btn" value="<?php echo $get_odometer[0]->end_odmeter; ?>"  data-errors="{filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_valuegreaterthan:'End Odometer should greater than Start Odometer',filter_maxlength:'END Odometer at max 7 digit long.',filter_required:'End Odometer should be not blank',filter_rangelength:'Cannot enter odometer difference more than 500 contact to administrator'}" <?php echo $odo_end_disabled; ?>>
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
                        <textarea name='epcr_remark' class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"></textarea>
                    </div>

                </div>

            </div>

            <div class="width100 text_center">
                <div class="text_center">

                    <div class="label">&nbsp;</div>

    <!--                    <input name="search_btn" value="Save" class="style3 base-xhttp-request" data-href="{base_url}/pcr/epcr" data-qr="output_position=content" type="button">-->
                    <?php //if($user_group != 'UG-DCO'){ ?>
                    <input type="hidden" name="inc_datetime" id="inc_datetime" value="<?php echo $inc_details_data[0]->inc_datetime; ?>">
                    <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}job_closer/save_epcr' data-qr='' TABINDEX="33"><?php // }else{           ?>
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
<script>
    var jsDate = $("#inc_datetime").val();
    var $mindate = new Date(jsDate);

    $('.EndDate').datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",

        minDate: $mindate,
        maxDate: 0
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
        if(start_from_base != null){
            document.getElementById("from_scene").disabled = false;
        }else{
            document.getElementById("from_scene").disabled = true;
        }
    });
    $('#from_scene').on('change',function(){
        var start_from_base = $('#from_scene').val();
        if(start_from_base != null){
            document.getElementById("at_hospitals_ambulance1").disabled = false;
        }else{
            document.getElementById("at_hospitals_ambulance1").disabled = true;
        }
    });
    $('#at_hospitals_ambulance1').on('change',function(){
        var start_from_base = $('#at_hospitals_ambulance1').val();
        if(start_from_base != null){
            document.getElementById("hand_over").disabled = false;
        }else{
            document.getElementById("hand_over").disabled = true;
        }
    });
    $('#hand_over').on('change',function(){
        var start_from_base = $('#hand_over').val();
        if(start_from_base != null){
            document.getElementById("back_to_base").disabled = false;
        }else{
            document.getElementById("back_to_base").disabled = true;
        }
    });
    
    function facility_new_details(ft) {

        if (ft == 'Other' || ft == 0) {

            xhttprequest($(this), base_url + 'bike/other_hospital_textbox', 'output_position=other_hospital_textbox');
        } else {
            $('#other_hospital_textbox').html('');
        }
        
    }

</script>