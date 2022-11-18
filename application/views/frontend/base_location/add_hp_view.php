<script>
    if (typeof H != 'undefined') {
        init_auto_address();
    }
</script>


<?php
$CI = EMS_Controller::get_instance();

$view = ($hp_action == 'view') ? 'disabled' : '';

if ($hp_action == 'edit') {
    $edit = 'disabled';
}

$title = ($hp_action == 'edit') ? " Edit Base Location Details " : (($hp_action == 'view') ? "View Base Location Details" : "Add Base Location Details");
?>
<form enctype="multipart/form-data" action="#" method="post" id="hp_form">

    <div class="width1 float_left">

        <div class="box3">

            <!--<h2 class="txt_clr2"><?php echo $title; ?></h2>-->
            <h2 class="txt_clr2 width1 txt_pro"><?php echo $title; ?></h2>
            <div class="store_details_box">
                <div class="field_row width100">
                    <div class="width2 float_left">


                        <div class="field_lable float_left width33"> <label for="hp_name">Base Location Name<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50">
                            <input id="hp_name" type="text" name="hp_name" class="filter_required controls " data-errors="{filter_required:'Base Location Name should not be blank',filter_word:'Base Location Name should be valid'}" value="<?= @$update[0]->hp_name ?>" <?php echo $view; ?> placeholder="Base Location Name" TABINDEX="1" <?php echo $edit; ?>>
                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="mb_no">Mobile Number</label></div>
                        <div class="filed_input float_left width50 ">
                            <input id="marks" onkeyup="this.value=this.value.replace(/[^\d]/,'')" type="text" name="mb_no" value="<?php echo $update[0]->hp_mobile; ?>" pattern="[7-9]{1}[0-9]{9}" maxlength="10" <?php echo $view; ?> TABINDEX="4" placeholder="Mobile Number">
                        </div>
                    </div>
                </div>

                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="reg_local_address">Working Area<span class="md_field">*</span></label></div>
                        <div class="filed_select float_left filed_input width50">
                            <select name="working_area" class="amb_status filter_required" data-errors="{filter_required:'Working area should not be blank'}" <?php echo $view; ?> TABINDEX="4">
                                <option value="">Select Area</option>
                                <?php echo get_area_type($update[0]->hp_area_type); ?>
                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="reg_local_address">Base Location Type<span class="md_field">*</span></label></div>
                        <div class="filed_select float_left filed_input width50">
                            <select name="location_type" class="amb_status filter_required" data-errors="{filter_required:'Base Location Type should not be blank'}" <?php echo $view; ?> TABINDEX="8">
                                <option value="">Select Base Location Type</option>
                                <?php echo get_hosp_type($update[0]->hp_type); ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="email">Base Location Type</label></div>

                        <div class="filed_input  float_left width50 ">
                            <select name="location_type" class="filter_required" tabindex="8" data-errors="{filter_required:'Base Location Type should not blank'}" <?php echo $view; ?> <?php //echo $edit; 
                                                                                                                                                                                            ?>>
                                <option value="">Select Base Location Type</option>
                                <option value="1" <?php if ($update[0]->hp_area_type  == '1') {
                                                        echo "selected";
                                                    } ?>>Railway Station</option>
                                <option value="2" <?php if ($update[0]->hp_area_type  == '2') {
                                                        echo "selected";
                                                    } ?>>Bus stand</option>
                                <option value="3" <?php if ($update[0]->hp_area_type  == '3') {
                                                        echo "selected";
                                                    } ?>>Hospital</option>
                                <option value="4" <?php if ($update[0]->hp_area_type  == '4') {
                                                        echo "selected";
                                                    } ?>>Airport</option>
                                <option value="5" <?php if ($update[0]->hp_area_type  == '5') {
                                                        echo "selected";
                                                    } ?>>School</option>
                            </select>
                        </div>

                    </div> -->
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="email">System Type<span class="md_field">*</span></label></div>

                        <div class="filed_input  float_left width50 ">
                            <select name="system_type" class="filter_required" tabindex="8" data-errors="{filter_required:'System Type should not blank'}" <?php echo $view; ?>>
                                <option value="">Select System Type</option>
                                <option value="108" <?php if ($update[0]->hp_system  == '108') {
                                                        echo "selected";
                                                    } ?>>108</option>
                                <option value="102" <?php if ($update[0]->hp_system  == '102') {
                                                        echo "selected";
                                                    } ?>>102</option>
                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label>Geofence Area<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50 ">
                            <input type="text" name="geo_no" class="filter_required" data-errors="{filter_required:'Geofence Number should not blank'}" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo $update[0]->geo_fence; ?>" maxlength="3" <?php echo $view; ?> placeholder="Geofence Number">
                        </div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="email">Base Location Category<span class="md_field">*</span></label></div>

                        <div class="filed_input  float_left width50 ">
                            <select name="hp_reg_no" class="filter_required" tabindex="8" data-errors="{filter_required:'Hospital Register Number should not blank'}" <?php echo $view; ?>>
                                <option value="">Select System Type</option>
                                <option value="A" <?php if ($update[0]->hp_register_no  == 'A') {
                                                        echo "selected";
                                                    } ?>>A</option>
                                <option value="B" <?php if ($update[0]->hp_register_no  == 'B') {
                                                        echo "selected";
                                                    } ?>>B</option>
                                <option value="C" <?php if ($update[0]->hp_register_no  == 'C') {
                                                        echo "selected";
                                                    } ?>>C</option>
                                <option value="D" <?php if ($update[0]->hp_register_no  == 'D') {
                                                        echo "selected";
                                                    } ?>>D</option>
                            </select>
                        </div>
                    </div>
                </div>



                <div class="add_details"> Base Location Address:</div>

                <div class="width100">

                    <div class="field_row">

                        <div class="field_lable float_left width17"> <label for="address">Address<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width75">

                            <input name="hp_add" value="<?= @$update[0]->hp_address ?>" <?php echo $view; ?> id="pac-input" class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="hp_dtl" data-auto="hp_auto_addr" data-lat="yes" data-log="yes" data-errors="{filter_required:'Address should not be blank.'}">

                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="state">State<span class="md_field">*</span></label></div>


                        <div id="hp_dtl_state" class="float_left filed_input width50">

                            <?php
                            $st = array('st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                            echo get_state($st);
                            ?>

                        </div>


                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable  float_left width33"><label for="district">District<span class="md_field">*</span></label></div>

                        <div id="hp_dtl_dist" class="float_left filed_input width50">
                            <?php

                            $dt = array('dst_code' => $update[0]->hp_district, 'st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                            echo get_district($dt);
                            ?>


                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable  float_left width33"><label for="tahsil">Tehsil</label></div>

                        <div id="hp_dtl_tahsil" class="float_left filed_input width50">
                            <?php

                            $thl = array('thl_id' => $update[0]->hp_tahsil, 'dst_code' => $update[0]->hp_district, 'st_code' => $update[0]->hp_state, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);

                            echo get_tahsil($thl);
                            ?>


                        </div>


                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="state">City</label></div>

                        <div id="hp_dtl_city" class="float_left filed_input width50">

                            <?php
                            $ct = array('cty_id' => $update[0]->hp_city,'thl_id' => $update[0]->hp_tahsil, 'dst_code' => $update[0]->hp_district, 'auto' => 'hp_auto_addr', 'rel' => 'hp_dtl', 'disabled' => $view);
                            echo get_base_city($ct);
                            ?>


                        </div>


                    </div>
                </div>
                <div class="field_row width100">


                    <div class="width2 float_left">



                        <div class="field_lable  float_left width33"> <label for="area">Area/Locality</label></div>

                        <div class="float_left filed_input width50" id="hp_dtl_area">


                            <input name="hp_dtl_area" value="<?= @$update[0]->hp_area ?>" <?php echo $view; ?> class="auto_area" type="text" placeholder="Area/Locality" TABINDEX="12">

                        </div>

                    </div>
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="landmark">Landmark</label></div>

                        <div class="float_left filed_input width50" id="hp_dtl_lmark">

                            <input name="hp_dtl_lmark" value="<?= @$update[0]->hp_lmark ?>" <?php echo $view; ?> class="auto_lmark" data-base="" type="text" placeholder="Landmark" TABINDEX="12">

                        </div>
                    </div>

                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="landmark">Lane / Street</label></div>

                        <div class="float_left filed_input width50">

                            <input name="hp_dtl_lane" value="<?= @$update[0]->hp_lane_street ?>" <?php echo $view; ?> class="" data-base="" type="text" placeholder="Lane / Street" TABINDEX="12">

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable  float_left width33"> <label for="pincode">Pin Code</label></div>

                        <div class="float_left filed_input width50" id="hp_dtl_pcode">


                            <input name="hp_dtl_lat" value="<?= @$update[0]->hp_pincode ?>" <?php echo $view; ?> class="auto_pcode filter_if_not_blank filter_number" data-errors="{filter_number:'Pincode are allowed only number.'}" type="text" placeholder="Pincode" TABINDEX="15">

                        </div>

                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"><label for="lat">Latitude<span class="md_field">*</label></div>

                        <div class="float_left filed_input width50" id="hp_dtl_lat">

                            <input name="lttd" value="<?= @$update[0]->hp_lat ?>" <?php echo $view; ?> class="auto_lmark filter_required" data-errors="{filter_number:'Latitude are allowed only number.',filter_required:'Latitude should not be blank'}" data-base="" type="text" placeholder="Base Latitude" TABINDEX="12">

                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable  float_left width33"> <label for="long">Longitude</label></div>

                        <div class="float_left filed_input width50" id="hp_dtl_log">


                            <input name="lgtd" value="<?= @$update[0]->hp_long ?>" <?php echo $view; ?> class="filter_required  filter_if_not_blank" data-errors="{filter_number:'Longitude are allowed only number.',filter_required:'Longitude should not be blank'}" type="text" placeholder="Base Longitude" TABINDEX="15">

                        </div>

                    </div>
                </div> <br>


                <div class="add_details">Other Base Location Details:</div>
                <div class="field_row width100">
                    <div class="width2 float_left">

                        <div class="field_lable float_left width33"> <label for="">Contact Person Name</label></div>

                        <div class="filed_input float_left width50">
                            <input type="text" name="hp_con_name" value="<?= @$update[0]->hp_contact_person ?>" <?php echo $view; ?> placeholder="Contact Person Name" TABINDEX="1">
                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="mb_no">Contact Person Mobile Number</label></div>
                        <div class="filed_input float_left width50 ">
                            <input onkeyup="this.value=this.value.replace(/[^\d]/,'')" type="text" name="hp_con_no" value="<?php echo $update[0]->hp_contact_mobile; ?>" pattern="[7-9]{1}[0-9]{9}" maxlength="10" <?php echo $view; ?> TABINDEX="4" placeholder="Contact Person Mobile Number">
                        </div>
                    </div>

                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="email">Email ID</label></div>

                        <div class="filed_input  float_left width50 ">
                            <input id="email" type="text" name="hp_email" class="filter_email filter_if_not_blank no_ucfirst" value="<?= @$update[0]->hp_email ?>" data-errors="{filter_email:'Email should be valid.'}" <?php echo $view; ?> TABINDEX="6" placeholder="Email">
                        </div>

                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"><label for="reg_local_address">DM Name<span class="md_field"></span></label></div>
                        <div class="filed_select float_left filed_input width50">
                            <?php if ($update[0]->hp_adm != '') {
                                $qa_name = get_clg_data_by_ref_id($update[0]->hp_adm);
                                $second_shift_pilot =  $qa_name[0]->clg_first_name . ' ' . $qa_name[0]->clg_mid_name . ' ' . $qa_name[0]->clg_last_name;
                            }
                            ?>

                            <input name="adm" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_all_user?clg_group=UG-DM" data-value="<?php if ($second_shift_pilot != '') {
                                                                                                                                                                    echo $second_shift_pilot; ?>-<?php echo $update[0]->hp_adm;
                                                                                                                                                                                                } ?>" value="<?php if ($update[0]->hp_adm != '') {
                                                                                                                                                                                                                    echo $update[0]->hp_adm;
                                                                                                                                                                                                                } ?>" type="text" tabindex="1" data-qr="clg_group=UG-FLEETDESK" placeholder="DM Name" <?php echo $view; ?>>
                        </div>
                    </div>

                </div>

            </div>
            <div class="width_25 margin_auto">
                <div class="button_field_row text_center">
                    <div class="button_box ">

                        <?php if (!(@$hp_action == 'view')) { ?>

                            <input type="hidden" name="sub_hp" value="user_registration" />

                            <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>base_location/<?php if ($update) { ?>edit_hp<?php } else { ?>add_hp<?php } ?>' data-qr='hp_id[0]=<?php echo base64_encode($update[0]->hp_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
</form>
</div>
</div>