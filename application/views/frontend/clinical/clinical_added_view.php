<?php if ($inc_call_type) {
    // var_dump($facility_details);
?>


    <div class=" width100 single_record">
        <div class="width_25">
            <a class="previous" href="{base_url}clinical/clinical_list"">Previous</a>
    </div>
                <div id=" list_table">

                <table class="table report_table">
                    <?php foreach ($amb_data as $amb_data) { ?>
                        <tr class="single_record_back">
                            <td colspan="7">Clinical Governance Audit Form</td>
                        </tr>
                        <tr>
                            <td class="width_16 strong">Date of Incident</td>
                            <td colspan="2"><?php echo $inc_details[0]->inc_datetime; ?></td>
                            <td class="width_16 strong">Vehicle No</td>
                            <td class="width_16"><?php echo $amb_data->amb_rto_register_no; ?></td>
                            <td class="width_16 strong">Type of vehicle</td>
                            <td class="width_16"><?php echo $amb_data->ambt_name; ?></td>



                            <?php if ($inc_details[0]->incis_deleted == '2') { ?>
                                <td class="width_16 strong">Status</td>
                                <td class="width_16">Event Termination Call</td>
                            <?php } ?>
                        </tr>
                        <tr>

                            <td class="width_16 strong">Incident ID</td>
                            <td colspan="2"><?php echo $inc_ref_no; ?></td>
                            <td class="width_32 strong">Base Location</td>
                            <td colspan="3"><?php echo $amb_data->base_location_name; ?></td>

                        </tr>
                        <tr>
                            <td class="width_16 strong">EMT ID</td>
                            <td colspan="2"><?php echo $amb_data->clg_emso_id ?></td>
                            <td class="width_16 strong">EMT Name</td>
                            <td><?php echo $amb_data->clg_first_name . ' ' . $amb_data->clg_mid_name . ' ' . $amb_data->clg_last_name; ?></td>
                            <td class="width_16 strong">Mobile No </td>
                            <td><?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></td>
                        </tr>

                        <?php if ($inc_details[0]->inc_patient_cnt) { ?>
                            <tr class="single_record_back">
                                <td colspan="7">Patient Details</td>
                            </tr>

                            <tr>
                                <td class="width_16 strong">Patient Name</td>
                                <td class="width_10 strong">Age</td>
                                <td class="width_12 strong">Gender</td>
                                <td class="width_16 strong">Call Type by ERO</td>
                                <td class="width_16 strong">Chief Complaint by ERO</td>
                                <td class="width_16 strong">Ambulance Dispatch Time</td>

                                <td class="width_16 strong">Action</td>
                            </tr>

                            <?php
                            if ($ptn_details) {
                                foreach ($ptn_details as $ptn) {
                            ?><tr>
                                        <td><?php echo $ptn->ptn_fname . ' ' . $ptn->ptn_lname; ?></td>
                                        <td><?php echo $ptn->ptn_age . ' ' . $ptn->ptn_age_type; ?></td>
                                        <td><?php echo get_gen($ptn->ptn_gender) ?></td>

                                        <td><?php echo $amb_data->pname ?></td>

                                        <td class="width_16"><?php echo $chief_complete_name;
                                                                if ($inc_details[0]->inc_complaint_other != '') {
                                                                    echo '-' . ' ' . $inc_details[0]->inc_complaint_other;
                                                                } ?></td>

                                        <td><?php echo $amb_data->assigned_time ?></td>

                                        <td><a class="btn expand_button expand_btn ptn_view" data-target="<?php echo "pl" . $ptn->ptn_id; ?>">VIEW</a>
                                        </td>
                                    </tr>



                                    <tr id="<?php echo "pl" . $ptn->ptn_id; ?>" style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan single_record_back">
                                        <td class="no_before single_record_back" colspan="7">
                                            <table class="table report_table">
                                                <tr>
                                                    <td class="single_record_back" colspan="5">Medical Information</td>
                                                </tr>

                                                <?php
                                                $pro_im_id = array('21', '41', '42', '44', '43', '52', '53');
                                                // var_dump($epcr_inc_details);die();
                                                if ($epcr_inc_details) {
                                                    foreach ($epcr_inc_details as $epcr) {
                                                        // var_dump($epcr);die();
                                                        if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                                ?>
                                                            <tr>
                                                                <td class="width_25">Provider Impression :</td>
                                                                <td class="width_25"> <?php if ($epcr->pro_name == '') {
                                                                                            echo '-';
                                                                                        } else {
                                                                                            echo $epcr->pro_name;
                                                                                        } ?></td>
                                                                <td class="width_25">Medical Advice :</td>
                                                                <td class="width_25"><?php if ($epcr->ercp_advice == "advice_No") {
                                                                                            echo "No";
                                                                                        } else if ($epcr->ercp_advice == "advice_Yes") {
                                                                                            echo "Yes";
                                                                                        } else {
                                                                                            echo " ";
                                                                                        } ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">Case Type:</td>
                                                                <td class="width_25"> <?php echo $epcr->case_name ?></td>
                                                                <td class="width_25">Call Type:</td>
                                                                <td class="width_25"> <?php echo $epcr->epcr_call_type ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="single_record_back" colspan="5">Patient Initial Assessment</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">LOC:</td>
                                                                <td class="width_25"> <?php echo $epcr->level_type; ?></td>
                                                                <td class="width_25">Airway:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_airway ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">Breathing:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_breathing ?></td>
                                                                <td class="width_25">Circulation:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_cir_pulse_p ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="single_record_back" colspan="5">Vitals</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">Temp:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_con_temp ?></td>
                                                                <td class="width_25">Pulse:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_cir_pulse_p ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">RR:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_con_rr ?></td>
                                                                <td class="width_25">BP:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_bp_sysbp_txt ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">BSL:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_con_bsl ?></td>
                                                                <td class="width_25">O2Sat:</td>
                                                                <td class="width_25"> <?php echo $epcr->ini_oxy_sat_get_nf ?></td>

                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">Pupils:</td>
                                                                <td class="width_25">Left:- <?php if ($epcr->ini_con_pupils != '0' && $epcr->ini_con_pupils != ' ') {
                                                                                                echo $epcr->ini_con_pupils;
                                                                                            } else {
                                                                                                echo " ";
                                                                                            } ?>&nbsp;&nbsp; Right:- <?php if ($epcr->ini_con_pupils_right != '0' && $epcr->ini_con_pupils_right != ' ') {
                                                                                                                            echo $epcr->ini_con_pupils_right;
                                                                                                                        } else {
                                                                                                                            echo " ";
                                                                                                                        } ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="single_record_back" colspan="5">ERCP Details</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">ERCP Advice</td>
                                                                <td class="width_25"><?php
                                                                                        if ($epcr->ercp_advice == 'advice_Yes') echo "Yes";
                                                                                        else echo "No"; ?>
                                                                </td>
                                                                <td class="width_25">Remark</td>
                                                                <td class="width_25"><?php echo $epcr->remark; ?></td>
                                                            </tr>


                                                            <tr>
                                                                <td class="single_record_back" colspan="5">Destination Hospital Name</td>
                                                            </tr>
                                                            <tr>

                                                                <td colspan="2">Name Of Receiving hospital :-
                                                                </td>
                                                                <td colspan="2">
                                                                    <?php
                                                                    if ($epcr->rec_hospital_name == "Other" || $epcr->rec_hospital_name == "0" || $epcr->rec_hospital_name == " ") {
                                                                        $hos_name = 'Other -' . $epcr->other_receiving_host;
                                                                        echo $hos_name;
                                                                    } else if ($epcr->rec_hospital_name == "on_scene_care") {
                                                                        $hos_name = 'On Scene Care';
                                                                        echo $hos_name;
                                                                    } else if ($epcr->rec_hospital_name == "at_scene_care") {
                                                                        $hos_name = 'At Scene Care';
                                                                        echo $hos_name;
                                                                    } else {
                                                                        $hos_name = $epcr->hp_name;
                                                                        echo $hos_name;
                                                                    }
                                                                    ?>

                                                                </td>

                                                            </tr>


                                                            <tr>
                                                                <td class="single_record_back" colspan="5">Drugs and Consumable</td>
                                                            </tr>
                                                            <tr>
                                                            <td colspan="5"><?php 
                                                                                // var_dump($epcr->titles);
                                                                                $drug = json_decode('['.$epcr->titles.']');
                                                                                // var_dump($drug);
                                                                                echo $drug->med_title;
                                                                                ?>
                                                                </td>
                                                                <td colspan="5"><?php 
                                                                                // var_dump($epcr->inv_titles);
                                                                                $cons = json_decode('['.$epcr->inv_titles.']');
                                                                                // var_dump($cons);die;
                                                                                echo $cons->inv_title;
                                                                                ?>
                                                                </td>
                                                               

                                                            <tr>
                                                                <td class="single_record_back" colspan="5">Interventions</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5"><?php if ($epcr->name != " " || $epcr->name != NULL) {
                                                                                    echo $epcr->name;
                                                                                } else {
                                                                                    echo $epcr->other_ong_intervention;
                                                                                }; ?></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="single_record_back" colspan="5">Police Informed</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="5"><?php echo " "; ?></td>
                                                            </tr>



                                                <?php
                                                        }
                                                    }
                                                } ?>
                                            </table>
                                        </td>
                                    </tr>

                        <?php
                                }
                            }
                        } ?>
                    <?php

                    }
                    ?>
                </table>
        </div>
        <!-- <form method="post" action="<?= base_url() ?>Clinical/clinical_save"> -->
        <input class="" type="text" name="inc_ref_no" value=<?php echo $inc_ref_no ?> hidden>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Consent</div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width100 float_left">
                        <div class="field_lable float_left width20"> <label class="lblfont" for="">1.Consent: </label></div>
                        <div class="filed_input float_left width80" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->consent_rec == 'Transportation') { ?>
                                <input class="rad " type="radio" name="Transportation" value="Transportation" disabled>
                                <label class="movleft" for="yes1">Transportation</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consent_rec == 'TDT') { ?>
                                <input class="rad " type="radio" name="consent" value="TDT">
                                <label class="movleft" for="">Treatment During Transport</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consent_rec == 'HR') { ?>
                                <input class="rad " type="radio" name="consent" value="High Risk">
                                <label class="movleft" for="">High Risk</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consent_rec == 'SP') { ?>
                                <input class="rad " type="radio" name="consent" value="High Risk">
                                <label class="movleft" for="">Shifting to Private Hospital Refusal of Transport</label>
                            <?php } ?>


                        </div>
                    </div>

                </div><br>

                <div class="width100 float_left" style="margin-top: 30px;">
                    <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                    <div class="filed_input float_left width80">
                        <input name="" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->consent_remark; ?>" disabled>
                    </div>
                </div>

            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Intervention </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Intervention: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">

                            <?php if ($clinical_view[0]->inter_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->inter_rec == 'No') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->inter_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="dc_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->inter_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Drugs and Consumable </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Drugs and Consumable Used: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">

                            <?php if ($clinical_view[0]->consumable_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consumable_rec == 'No') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consumable_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="dc_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="dc_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->consumable_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Patient Assessment</div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width30 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Provider Impression: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->pro_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="pro_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->pro_rec == 'No') { ?>
                                <input class="rad " type="radio" name="pro_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->pro_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="pro_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="width30 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont">2.Pregnancy: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->pregnancy_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="pre_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->pregnancy_rec == 'No') { ?>
                                <input class="rad " type="radio" name="pre_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->pregnancy_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="pre_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="width30 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont">3.Initial Assessment: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->initial_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="ini_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->initial_rec == 'No') { ?>
                                <input class="rad " type="radio" name="ini_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->initial_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="ini_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>


                        </div>
                    </div>
                </div><br>
                <div class="field_row width100"><br>
                    <div class="width30 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">4.Baseline Vitals: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->Baseline_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="bas_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->Baseline_rec == 'No') { ?>
                                <input class="rad " type="radio" name="bas_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->Baseline_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="bas_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="width30 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont">5.Ongoing Vitals: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->ongoing_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="ong_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->ongoing_rec == 'No') { ?>
                                <input class="rad " type="radio" name="ong_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->ongoing_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="ong_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="width30 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont">6.Handover Vitals: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">

                            <?php if ($clinical_view[0]->handover_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="han_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->handover_rec == 'No') { ?>
                                <input class="rad " type="radio" name="han_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->handover_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="han_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>

                        </div>
                    </div>
                </div><br>

                <div class="width100 float_left" style="margin-top: 30px;">
                    <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                    <div class="filed_input float_left width80">
                        <input name="ptn_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->pro_remark; ?>" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;ERCP Advice</div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width100 float_left">
                        <div class="field_lable float_left width20"> <label class="lblfont" for="">1.ERCP Advice: </label></div>
                        <div class="filed_input float_left width80" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->ercp_rec == 'Advice taken and followed') { ?>
                                <input class="rad " type="radio" name="adv_btn" value="Advice taken and followed">
                                <label class="movleft" for="">Advice taken and followed</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->ercp_rec == 'Required but not taken') { ?>
                                <input class="rad " type="radio" name="adv_btn" value="Required but not taken" disabled>
                                <label class="movleft" for="yes1">Required but not taken</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->ercp_rec == 'Taken but not followed') { ?>
                                <input class="rad " type="radio" name="adv_btn" value="Taken but not followed" disabled>
                                <label class="movleft" for="no1">Taken but not followed</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->ercp_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="adv_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>

                        </div>
                    </div>

                </div><br>

                <div class="width100 float_left" style="margin-top: 30px;">
                    <div class="field_lable float_left width20"><label class="lblfont">RemarkComplete</label></div>
                    <div class="filed_input float_left width80">
                        <input name="ercp_adv_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->ercp_remark; ?>" disabled>
                    </div>
                </div>

            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Drugs and Consumable </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Drugs and Consumable Used: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">

                            <?php if ($clinical_view[0]->consumable_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consumable_rec == 'No') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->consumable_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="dc_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="dc_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->consumable_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Destination Hospital </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Destination Hospital: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">

                            <?php if ($clinical_view[0]->destination_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="dh_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->destination_rec == 'No') { ?>
                                <input class="rad " type="radio" name="dh_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->destination_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="dh_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="dh_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->destination_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Police Informed </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Police Informed: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">

                            <?php if ($clinical_view[0]->police_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->police_rec == 'No') { ?>
                                <input class="rad " type="radio" name="dc_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->police_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="dc_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->police_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Documentation Completed </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Documentation Completed: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->documentation_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="dh_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->documentation_rec == 'No') { ?>
                                <input class="rad " type="radio" name="dh_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->documentation_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="dh_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="doc_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->documentation_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Protocols and Guidelines followed </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Protocols and Guidelines followed: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->protocols_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="pg_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->protocols_rec == 'No') { ?>
                                <input class="rad " type="radio" name="pg_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->protocols_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="pg_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="width100 float_left" style="margin-top: 30px;">
                        <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                        <div class="filed_input float_left width80">
                            <input name="pg_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->protocols_remark; ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar_new " id="">
                <div class="width70 float_left ">
                    <div class="label float_left white strong" style="font-size: 16px;">&nbsp;&nbsp;Training Needed </div>
                </div>
                <div class="width30 float_left">
                    <div class=""></div>
                </div>
            </div><br>
            <div class="">
                <div class="field_row width100"><br>

                    <div class="width50 float_left">
                        <div class="field_lable float_left width50"> <label class="lblfont" for="">1.Training Needed: </label></div>
                        <div class="filed_input float_left width50" style="display: flex;flex-wrap: wrap;align-content: space-between;">
                            <?php if ($clinical_view[0]->training_rec == 'Yes') { ?>
                                <input class="rad " type="radio" name="pg_btn" value="Yes" disabled>
                                <label class="movleft" for="yes1">Yes</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->training_rec == 'No') { ?>
                                <input class="rad " type="radio" name="pg_btn" value="No" disabled>
                                <label class="movleft" for="no1">No</label>
                            <?php } ?>
                            <?php if ($clinical_view[0]->training_rec == 'NA') { ?>

                                <input class="rad " type="radio" name="pg_btn" value="NA" disabled>
                                <label class="movleft" for="na1">NA</label>
                            <?php } ?>
                        </div>

                        <div class="width100 float_left" style="margin-top: 30px;">
                            <div class="field_lable float_left width20"><label class="lblfont">Remark</label></div>
                            <div class="filed_input float_left width80">
                                <input name="tra_remark" tabindex="23" class="form_input " placeholder="Enter Remark" type="text" value="<?= @$clinical_view[0]->training_remark; ?>" disabled>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- <div class="width100" style="text-align: center;">
                <input type="submit" name="save" value="Submit" />
            </div> -->
            <!-- </form> -->

        <?php } else { ?>
            <div class="width100">
                <div class="width100 strong"> No Record Founds </div>
            </div>
        <?php
    } ?>

        <style>
            #colorbox {
                /* left: 200px !important;
                width: 1400px !important;
                height: 700px !important;
                top: 80px !important; */
            }

            #cboxWrapper,
            #cboxLoadedContent,
            #cboxContent {
                width: 1293px !important;
                height: 700px !important;
            }

            .previous {
                padding: 10px;
                background-color: #085b80;
                color: whitesmoke;
                font-weight: bold;
                margin-bottom: 10px !important;
            }

            .rad {
                margin: 7px 5px 5px 5px;
            }

            .movleft {
                margin-right: 10px;
                font-size: 16px;

            }

            .lblfont {
                font-size: 16px;
            }
        </style>