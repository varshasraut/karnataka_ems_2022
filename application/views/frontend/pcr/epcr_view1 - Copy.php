<script>cur_pcr_step(1);</script>

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
    <div class="head_outer"><h3 class="txt_clr2 width1">E-PCR (Tablet closure information)</h3> </div>     
    <form method="post" name="" id="call_dls_info" >
        <div class="epcr">
            <div class="width50 float_left left_align">
                <div class="width50 float_left drg">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Date<span class="md_field">*</span> :</div>
                    </div>
                    <div class="width100 float_left">
                        <input name="date" tabindex="1" class="form_input filter_required" placeholder="Date" type="text" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!'}" value="<?php
                        if ($inc_details[0]->date) {
                            echo date('d-m-Y', strtotime($inc_details[0]->date));
                        } else {
                            echo date('d-m-y');
                        }
                        ?>" readonly="readonly">
                    </div>
                </div>
                <div class="width50 float_left drg">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Time<span class="md_field">*</span> :</div>
                    </div>
                    <div class="width100 float_left">
                        <input name="time" tabindex="2" class="form_input filter_required" placeholder="Time" type="text" data-base="search_btn" data-errors="{filter_required:'Time should not be blank!'}" value="<?php
                        if ($inc_details[0]->time == '') {
                            echo date('H:i');
                        } else {
                            echo $inc_details[0]->time;
                        }
                        ?>" readonly="readonly">
                    </div>
                </div>
                <div class="width50 float_left drg">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Incident ID<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="inc_ref_id" tabindex="5" class="form_input filter_required" placeholder=" Incident Id" type="text" data-base="send_sms" data-errors="{filter_required:'Incident Id should not be blank!'}" value="<?php echo $inc_ref_id; ?>" readonly="readonly">
                    </div>
                </div>
                <div id="pat_details_block">
                    <div class="width100">
                        <h3>Patient Details : </h3>
                        <div class="width33 float_left drg">
                            <div class="width100 float_left ">
                                <div class="style6 float_left">Patient ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <?php
                                if (!empty($inc_details[0]->ptn_id)) {
                                    $disabled = "disabled";
                                }
                                ?>

                                <select name="pat_id" tabindex="8" id="pcr_pat_id" class="filter_required" data-errors="{filter_required:'Patient ID should not be blank!'}" data-base="send_sms"> 
                                    <option value="" <?php echo $disabled; ?>>Select patient id</option>
                                    <?php foreach ($patient_info as $pt) { ?>
                                        <option value="<?php echo $pt->ptn_id; ?>" <?php
                                        if ($pt->ptn_id == $patient_id) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $pt->ptn_id . " - " . $pt->ptn_fullname; ?></option>
                                            <?php } ?>
                                    <option value="0" class="onpage_popup" href="{base_url}pcr/patient_details" data-qr="output_position=popup_div"  data-popupwidth="1250" data-popupheight="850">Other</option>
                                </select>

                                <input class="add_button_hp onpage_popup float_right" id="add_button_pt" name="add_patient" value="Add" data-href="{base_url}pcr/patient_details" data-qr="output_position=popup_div&amp;filter_search=search&amp;tool_code=add_patient" type="button" data-popupwidth="1250" data-popupheight="850" style="display:none;">
                            </div>
                        </div>
                        <div class="width33 float_left drg">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Age<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="patient_age" tabindex="9" class="form_input filter_required" placeholder=" Age" type="text" data-base="search_btn" data-errors="{filter_required:'Patient Age should not be blank!'}" value="<?= $pt_info[0]->ptn_age; ?>" readonly="readonly">
                            </div>
                        </div>

                        <div class="width30 float_left gen">
                            <div class="width100 float_left outer_gen">
                                <div class="style6 float_left">Gender<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
        <!--                        <input name="gender" tabindex="13" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient gender should not be blank!'}" value="<?= get_gen($pt_info[0]->ptn_gender); ?>">-->
                                <select id="patient_gender" name="gender" class="filter_required width100" data-errors="{filter_required:'Patient Gender is required'}" <?php echo $view; ?> TABINDEX="10" disabled="disabled">
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
                                    ?>>Other</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="width100">
                        <div class="width33 float_left drg">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Patient Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="patient_name" tabindex="11" class="form_input filter_required" placeholder="Patient Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ptn_fullname; ?>" readonly="readonly">
                            </div>
                        </div>
                       <!-- <div class="width33 float_left drg">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Patient Middle Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="patient_name" tabindex="12" class="form_input filter_required" placeholder="Patient Middle Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ptn_mname; ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="width33 float_left lst_name">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Patient Last Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left drg">
                                <input name="patient_name" tabindex="13" class="form_input filter_required" placeholder="Patient Last Name " type="text" data-base="search_btn" data-errors="{filter_required:'Patient Name should not be blank!'}" value="<?= $pt_info[0]->ptn_lname; ?>" readonly="readonly">
                            </div>
                        </div> -->

                        <div class="width100">

                            <div id="ptn_form_lnk" class="style6 float_left">

 
 
                            </div>

                        </div>

                    </div>
                    <div class="width100">
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
                                     }else{
                                          $state_id ="MH";
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

<!--                    <input name="city" tabindex="17" class="mi_autocomplete  form_input filter_required" placeholder=" City/Village " type="text" data-base="search_btn" data-errors="{filter_required:'City/Village should not be blank!'}" data-href="{base_url}auto/city" data-value="<?= @$inc_details[0]->inc_city_id; ?>">-->

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

                    </div>
                </div>
                <div id="amb_details_block">
                    <div class="width100">
                        <h3>Ambulance Details : </h3>
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Ambulance No<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
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
                            <div class="width100 float_left">
                                <div class="style6 float_left">Base Location<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="base_location" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $inc_emp_info[0]->hp_name; ?>" readonly="readonly">
                            </div>
                        </div>

                    </div>
                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">EMT Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="emt_name" tabindex="24" class="form_input filter_required" placeholder=" EMT Name" type="text" data-base="search_btn" data-errors="{filter_required:'EMT Name should not be blank!'}" value="<?= $inc_emp_info[0]->emt_name; ?>" >
                            </div>
                        </div>
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">EMT ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="emt_id" tabindex="25" class="form_input filter_required" placeholder=" EMT ID" type="text" data-base="search_btn" data-errors="{filter_required:'EMT ID should not be blank!'}" value="<?= $inc_emp_info[0]->emso_id; ?>">
                            </div>
                        </div>

                    </div>
<!--                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Pilot Name<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="pilot_name" tabindex="26" class="form_input filter_required" placeholder=" Pilot Name " type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}"  value="<?= $inc_emp_info[0]->pilot_name; ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="width50 float_left drg">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Pilot ID<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="pilot_id" tabindex="27" class="form_input filter_required" placeholder=" Pilot ID" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot ID should not be blank!'}" value="<?= $inc_emp_info[0]->amb_pilot_id; ?>" readonly="readonly">
                            </div>
                        </div>

                    </div>-->

                    <div class="width100">
                        <div class="width50 drg float_left">
                            <div class="width100 float_left">
                                <div class="style6 float_left">Ambulance Category<span class="md_field">*</span> : </div>
                            </div>
                            <div class="width100 float_left">
                                <input name="category" tabindex="29" class="form_input filter_required" placeholder=" Category" type="text" data-base="search_btn" data-errors="{filter_required:'Category should not be blank!'}" value="<?= @$inc_emp_info[0]->ar_name; ?>" readonly="readonly">
                            </div>
                        </div>

                    </div>
                </div>
            </div>




            <div class="width50 float_left">
                <div class="width100">
                    <div class="width50 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">LOC<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="loc" tabindex="3" class="mi_autocomplete form_input filter_required" placeholder=" LOC " type="text" data-base="search_btn" data-errors="{filter_required:'Please select LOC from dropdown list'}" data-href="{base_url}auto/loc_level" value="<?php echo @$inc_details[0]->loc; ?>"  data-value="<?= @$inc_details[0]->level_type; ?>">
       <!--                     <input type="text" name="asst[asst_loc]"  value="<?php echo $asst[0]->asst_loc; ?>" class="mi_autocomplete filter_required ucfirst" data-href="{base_url}auto/loc_level"  placeholder=" LOC level" data-errors="{filter_required:'LOC level should not be blank'}" data-value="<?php echo $asst[0]->level_type; ?>" tabindex="1">-->
       <!--                    <input name="loc" tabindex="19" class="form_input filter_required" placeholder=" LOC " type="text" data-base="search_btn" data-errors="{filter_required:'LOC should not be blank!'}" value="<?= @$inc_details[0]->loc; ?>">-->
                        </div>
                    </div>
                    <div class="width50 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Provider Impressions<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input filter_required" placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?= @$inc_details[0]->provider_impressions; ?>" data-value="<?= @$inc_details[0]->pro_name; ?>" data-href="{base_url}auto/get_provider_imp" data-qr="">
                        </div>
                    </div>
                </div>
                <div class="width100">
                    <div class="width50 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Drugs and consumables used </div>
                        </div>

                    </div>
                    <div class="width100 float_left">
                        <div class="width50 float_left unit_drags">

<!--                        <input name="unit_drags" tabindex="21" class="form_input" placeholder="Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_unit_box()">-->
                            <input name="unit_drags" tabindex="6" class="form_input " placeholder="Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}">

                            <div id="unit_drugs_box">

                                <?php
                                if ($pcr_med_inv_data) {
                                    $med_inv_data = array();

                                    foreach ($pcr_med_inv_data as $pcr_med) {

                                        $med_inv_data[$pcr_med->as_item_id] = $pcr_med;
                                    }
                                }
                                ?>

                                <div class="unit_drugs_box">
                                    <ul class="width100">
                                    <?php if ($invitem) { ?>
                                        
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
                                        <!--            <input type="checkbox" value="<?php echo $item->inv_id ?>" name="unit[<?php echo $item->inv_id; ?>][id]" class="unit_checkbox"><?php echo $item->inv_title; ?><br>-->
                                                    <?php if (isset($med_inv_data[$item->inv_id])) {
                                                        ?>
                                                        <div class="unit_div">
                                                            <input type="text" name="unit[<?php echo $item->inv_id; ?>][value]" value="<?php echo $med_inv_data[$item->inv_id]->as_item_qty ?>" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam" onchange="show_unit_box();">
                                                            <input type="hidden" name="unit[<?php echo $item->inv_id; ?>][type]" value="<?php echo $item->inv_type; ?>" class="width50" data-base="unit_iteam" >
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="unit_div hide">
                                                            <input type="text" name="unit[<?php echo $item->inv_id; ?>][value]" value="" class="width50" data-errors="{filter_number:'Only numbers are allowed.'}" data-base="unit_iteam"  onchange="show_unit_box();">
                                                            <input type="hidden" name="unit[<?php echo $item->inv_id; ?>][type]" value="<?php echo $item->inv_type; ?>" class="width50" data-base="unit_iteam">
                                                        </div>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                            <input name="unit_iteam" id="show_unit_box_selected" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_unit_drugs" data-qr="output_position=show_selected_unit_item" type="button">
                                      
                                    <?php } ?>
                                              <li class="unit_block">
                                                    <label for="unit_na" class="chkbox_check">


                                                        <input type="checkbox" name="unit['NA'][id]" class="check_input unit_checkbox" value="NA"  id="unit_na" data-base="unit_iteam">


                                                        <span class="chkbox_check_holder"></span>NA<br>
                                                    </label>
                                              </li>
                                            
                                              </ul>
                                            
                                </div>
                                <div id="show_selected_unit_item" style="width:95%">
                                </div>


                            </div>  

                        </div>

                        <div class="width50 float_left non_unit_drags">

<!--                          <input name="non_unit_drags" tabindex="22" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}" onclick="show_non_unit_box()">-->
                            <input name="non_unit_drags" tabindex="7" class="form_input" placeholder="Non Units" type="text" data-base="search_btn" data-errors="{filter_required:'Drugs and consumables used should not be blank!'}">
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
                                        <input name="non_unit_iteam" id="show_non_unit_drugs_box" style="display: none;" value="SEARCH" class="style3 base-xhttp-request" data-href="{base_url}pcr/show_non_unit_drugs" data-qr="output_position=selected_non_unit_drugs_view" type="button">
                                    <?php } ?>
                                </div>


                            </div>  
                            <div style="width:95%" id="selected_non_unit_drugs_view">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width100">
                    <div class="width100 rec_hp float_left">
                        <div class="style6 float_left">Name of Receiving Hospital/Ambulance<span class="md_field">*</span> : </div>
                    </div>
                    <div class="width100 rec_hp float_left">
                        <input name="receiving_host" tabindex="7.2" class="mi_autocomplete form_input filter_required" placeholder=" Name of Receiving Hospital" type="text" data-base="send_sms" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?= @$inc_details[0]->hp_name; ?>" value="<?= @$inc_details[0]->hp_id; ?>">
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
                            <input name="call_rec_time" tabindex="14" class="form_input filter_required filter_time_hms mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Call received should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}" value="<?php if($driver_data[0]->dp_cl_from_desk == ''){ echo date("H:i:s", strtotime($inc_details[0]->inc_datetime)); } else{ echo $driver_data[0]->dp_cl_from_desk; } ?>" disabled >
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="at_scene" tabindex="15" class="form_input filter_if_not_blank filter_time_hms mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'At scene should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}" value="<?= @$driver_data[0]->dp_on_scene; ?>" >
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">From Scene : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="from_scene" tabindex="16" class="form_input filter_if_not_blank filter_time_hms mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'From Scene should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}" value="<?= @$driver_data[0]->dp_reach_on_scene; ?>" >
                        </div>
                    </div>

                </div>
                <div class="width100">

                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">At Hospital/ Ambulance: </div>
                        </div>
                        <div class="width100 float_left">

                            <input name="at_hospital" tabindex="17" class=" form_input filter_if_not_blank filter_time_hms mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'At Hospital should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}"  value="<?= @$driver_data[0]->dp_hosp_time; ?>" >
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Hand over : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="hand_over" tabindex="18" class="form_input filter_if_not_blank filter_time_hms mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" data-errors="{filter_required:'Hand over  should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}" value="<?= @$driver_data[0]->dp_hand_time; ?>" >
                        </div>
                    </div>
                    <div class="width33 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Back to base<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="back_to_base" tabindex="19" class="filter_required form_input filter_time_hms mi_timepicker" placeholder="H:i:s" type="text" data-base="search_btn" value="<?= @$driver_data[0]->dp_back_to_loc; ?>" data-errors="{filter_required:'Back to base  should not be blank!',filter_time_hms:'Please enter valid time(H:i:s)'}">
                        </div>
                    </div>

                </div>
                 <div class="width100">
                    <div class="width50 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Previous Odometer: </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="previous_odmeter" tabindex="20" class="form_input" placeholder="Enter Previous Odometer" type="text" data-base="search_btn" value="<?= @$previous_odometer; ?>"  data-errors="{filter_required:'Previous Odometer should not be blank!'}" readonly="readonly">
                        </div>
                    </div>
                </div>
                <div class="width100">
                    <div class="width50 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Start Odometer<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="start_odmeter" tabindex="20" class="filter_required form_input" placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?= @ $driver_data[0]->start_odometer; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!'}" >
                        </div>
                    </div>
                    <div class="width50 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">END Odometer<span class="md_field">*</span> : </div>
                        </div>
                        <div class="width100 float_left">
                            <input name="end_odmeter" tabindex="21" class="filter_required form_input" placeholder="Enter END Odometer" type="text" data-base="search_btn" value="<?= @$driver_data[0]->end_odometer; ?>"  data-errors="{filter_required:'END Odometer should not be blank!'}">
                        </div>
                    </div>

                </div>
                <div class="width100">
                    <div class="width100 rec_hp float_left">
                        <div class="style6 float_left">Remark : </div>
                    </div>
                    <div class="width100 rec_hp float_left">
                        <textarea name='epcr_remark'></textarea>
                    </div>

                </div>

            </div>

            <div class="width100 text_center">
                <div class="text_center">

                    <div class="label">&nbsp;</div>

    <!--                    <input name="search_btn" value="Save" class="style3 base-xhttp-request" data-href="{base_url}/pcr/epcr" data-qr="output_position=content" type="button">-->
                  <?php  //if($user_group != 'UG-DCO'){ ?>
                  <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}bike/save_epcr' data-qr='' TABINDEX="33"><?php // }else{?>
<!--                  <input type="button" name="Save" value="SAVE PAGE" class="accept_btn form-xhttp-request" data-href='{base_url}/bike/save_epcr' data-qr='' TABINDEX="33">-->
                      <?php // }?>
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
        <a href="#" class="next_btn btn float_right" onclick="load_next_prev_step(2)"> Next > </a>
    <?php } ?>
</div>