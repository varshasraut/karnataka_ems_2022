<div class="call_purpose_form_outer" id="general_enquiry_administartive">
    <div class="width100">
        <!-- <h3>General Enquiry : Administrative</h3> -->
        <label class="headerlbl">General Enquiry : Administrative</label>
    </div>
    <form enctype="multipart/form-data" action="#" method="post" id="corona_enquiry_call">
        <div class="width2 float_left">
            <div class="width100 form_field outer_smry">
                <div class="label blue float_left">ERO Note</div>
                    <div class="width97" id="ero_summary_other">
                        <textarea style="height:80px;" name="patient[inc_ero_summary]" class="" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'ERO Summary should not be blank'}"><?= @$inc_details['inc_ero_summary']; ?></textarea>
                    </div>
                </div>
            </div>
        <div class="width2 float_left form_field rt_side">
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
        <div id="fwdcmp_btn" class="width100">
            <input type="hidden" name="patient[inc_type]" id="inc_type" value="CORONA_GENERAL_ENQUIRY_AD">
            <input type="hidden" name="patient[caller_dis_timer]" id="caller_dis_timer" value="">
            <input type="hidden" name="patient[inc_recive_time]" value="<?php echo $attend_call_time;?>">
            <input type="hidden" name="patient[CallUniqueID]" value="<?php echo $CallUniqueID;?>">
            <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id;?>">
            <input type="button" name="submit" value="Save" class="btn submit_btnt form-xhttp-request" data-href='{base_url}corona/confirm_corona_enquiry' data-qr='output_position=content&amp;module_name=inc&amp;tlcode=MT-INC-ADD'  TABINDEX="21">
        </div>
   </form>
</div>
