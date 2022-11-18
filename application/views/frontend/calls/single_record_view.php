<?php if ($inc_call_type) {
    // var_dump($facility_details);
?>

    <div class="width100 single_record">

        <div id="list_table">

            <table class="table report_table">

                <tr class="single_record_back">
                    <td colspan="8">Incident Call Type & Incident Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Call Type </td>
                    <td><?php //var_dump($inc_details[0]);
                        echo $inc_details[0]->pname;
                        if ($inc_details[0]->cl_name != '') {
                        ?> &nbsp; [ <?php echo ucwords($inc_details[0]->cl_name); ?> ] <?php } ?> </td>
                    <td class="width_16 strong">Incident Id</td>
                    <td class="width_16"><?php echo $inc_ref_no; ?></td>
                    <td class="width_16 strong">Incident Recording </td>

                    <td colspan="3">
                        <?php

                        $inc_datetime = date("Y-m-d", strtotime($inc['inc_datetime']));
                        $pic_path =  "{base_url}uploads/audio_files/" . $inc_details[0]->inc_audio_file;
                        $pic_path =   get_inc_recording($inc_details[0]->inc_avaya_uniqueid, $inc_datetime);
                        if ($pic_path != '') {
                        ?>

                            <audio controls controlsList="nodownload">
                                <source src="<?php echo $pic_path; ?>" type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                        <?php
                        }

                        ?>
                    </td>
                    <?php if ($inc_details[0]->incis_deleted == '2') { ?>
                        <td class="width_16 strong">Status</td>
                        <td class="width_16">Termination Call</td>
                    <?php } ?>
                </tr>

                <tr>

                    <td class="width_16 strong">Date & Time</td>
                    <td><?php echo $inc_details[0]->inc_datetime; ?></td>
                    <td class="width_16 strong">Call Duration</td>
                    <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>
                    <?php if (unserialize($inc_details[0]->inc_service) != '') { ?>
                        <td class="width_16 strong">Services</td>
                        <td colspan="3"><?php
                                        $services = unserialize($inc_details[0]->inc_service);
                                        foreach ($services as $key => $value) {
                                            if ($value == '1') {
                                                echo "Medical" ;
                                            }
                                            if ($value == '2') {
                                                echo ','."Police" ;
                                            }
                                            if ($value == '3') {
                                                echo ','."Fire";
                                            }
                                        }
                                        ?></td>
                    <?php } ?>
                </tr>

                <tr><?php if (trim($inc_details[0]->inc_type) == 'MCI' || trim($inc_details[0]->inc_type) == 'VIP_CALL') { ?>


                        <td class="width_25 strong">MCI Nature</td>
                        <td class="width_25"><?php echo ($inc_details[0]->ntr_nature) ? $inc_details[0]->ntr_nature : '-'; ?></td>

                    <?php } else if ($chief_complete_name != '') { ?>
                        <td class="width_16 strong">Chief Complaint</td>
                        <td class="width_16"><?php echo $chief_complete_name;
                                                if ($inc_details[0]->inc_complaint_other != '') {
                                                    echo '-' . ' ' . $inc_details[0]->inc_complaint_other;
                                                } ?></td>

                    <?php } ?>
                    <?php if ($po_ct_name != '') { ?>
                        <td class="width_16 strong">Police Complaint</td>
                        <td class="width_16"><?php echo $po_ct_name; ?></td>
                    <?php } ?>
                    <?php if ($fi_ct_name != '') { ?>
                        <td class="width_16 strong">Fire Complaint</td>
                        <td class="width_16"><?php echo $fi_ct_name; ?></td>
                    <?php } ?>
                    <?php if ($inc_details[0]->inc_patient_cnt > 0) { ?>
                        <td class="width_16 strong">Patient Count</td>
                        <td> <?php echo $inc_details[0]->inc_patient_cnt; ?></td>
                    <?php } ?>
                    <?php if ($ambt_name != '') { ?>
                        <td class="width_16 strong">Suggested Ambulance type</td>
                        <td><?php echo $ambt_name; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <?php if ($inc_details[0]->pre_inc_ref_id != '') { ?>
                        <td class="width_16 strong">Previous Incident Id</td>
                        <td class="width_16"><?php echo $inc_details[0]->pre_inc_ref_id; ?></td>
                    <?php } ?>

                </tr>
                <?php if ($questions) { ?> <tr>
                        <td colspan="8" class="single_record_back">Question & Answer</td>
                    </tr> <?php } ?>

                <?php
                if ($questions) {
                    foreach ($questions as $key => $question) {
                ?>
                        <tr>
                            <td colspan="4"><?php echo $question->que_question; ?>
                            </td>
                            <td colspan="4"> <?php
                                                if ($question->sum_que_ans == 'N') {
                                                    echo "No";
                                                } else {
                                                    echo "Yes";
                                                }
                                                ?></td>
                        </tr>
                <?php
                    }
                }
                ?>

                <?php if (($enq_que[0]['que']) != '' && ($inc_details[0]->inc_type == 'ENQ_CALL')) { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Enquiry Question & Answer </td>
                    </tr>
                    <?php  ?>

                    <?php
                    if ($enq_que) {
                        foreach ($enq_que as $enq_que) {
                    ?>
                            <tr>
                                <td colspan="4" class="strong"><?php echo $enq_que['que']; ?>
                                </td>
                                <td colspan="4"> <?php
                                                    echo $enq_que['ans'];
                                                    ?>
                                <td>
                            </tr>
                <?php
                        }
                    }
                }
                ?>


                <?php if ($facility_details) { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Inter Hospital Facility Details</td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Current Facility</td>
                        <td><?php

                            if ($facility_details[0]->facility == '0') {
                                echo "Other";
                            } else if ($facility_details[0]->facility == 'on_scene_care') {
                                echo "On scene care";
                            } else if ($facility_details[0]->facility == 'at_scene_care') {
                                echo "At Scene Care";
                            } else {
                                echo $facility_details[0]->current_facility;
                            } ?></td>
                        <td class="width_16 strong">Reporting Doctor</td>
                        <td><?php echo $facility_details[0]->rpt_doc; ?></td>
                        <td class="width_16 strong">Mobile Number</td>
                        <td colspan="3"><?php echo $facility_details[0]->mo_no; ?></td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">New Facility</td>
                        <td><?php

                            if ($facility_details[0]->new_facility_id == '0') {
                                echo "Other";
                            } else if ($facility_details[0]->new_facility_id == 'on_scene_care') {
                                echo "On scene care";
                            } else if ($facility_details[0]->new_facility_id == 'at_scene_care') {
                                echo "At Scene Care";
                            } else {
                                echo $facility_details[0]->new_facility;
                            }

                            ?></td>
                        <td class="width_16 strong">Reporting Doctor</td>
                        <td><?php echo $facility_details[0]->new_rpt_doc; ?></td>
                        <td class="width_16 strong">Mobile Number</td>
                        <td colspan="3"><?php echo $facility_details[0]->new_mo_no; ?></td>
                    </tr>

                <?php } ?>

                <?php if ($feed_questions) { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Feedback Details</td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Feedback Type</td>
                        <td><?php
                            if ($feedback_details[0]->fc_feedback_type == 'positive_feedback') {
                                echo 'Positive Feedback';
                            } else {
                                echo 'Negative Feedback';
                            }
                            ?></td>
                        <td class="width_16 strong">Date & Time</td>
                        <td><?php echo date('d-m-Y h:i:s', strtotime($feedback_details[0]->fc_added_date)); ?></td>
                        <td class="width_16 strong">Feedback Standard Remark</td>
                        <?php
                        $fc_standard_type = json_decode($feedback_details[0]->fc_standard_type);
                        if (is_array($fc_standard_type)) {
                            $fc_standard_type_nw = implode("','", $fc_standard_type);
                        }

                        ?>
                        <td colspan="3"><?php echo get_feedback_complaint($fc_standard_type_nw); ?></td>

                    </tr>
                    <tr>

                        <td class="width_16 strong">Employee Remark</td>
                        <td colspan="7"><?php echo $feedback_details[0]->fc_employee_remark; ?></td>

                    </tr>

                    <?php if ($feed_questions) { ?> <tr>
                            <td colspan="8" class="strong">Question & Answer</td>
                        </tr> <?php } ?>

                    <?php
                    if ($feed_questions) {
                        foreach ($feed_questions as $key => $question) {
                    ?>
                            <tr>
                                <td colspan="4"><?php echo $question->que_question; ?>
                                </td>
                                <td colspan="4"> <?php
                                                    if ($question->sum_que_ans == 'discharge') {
                                                        echo "Discharge/ Recovered";
                                                    } else if ($question->sum_que_ans == 'yes') {
                                                        echo "Yes";
                                                    } else if ($question->sum_que_ans == 'excellent') {
                                                        echo "Excellent";
                                                    } else if ($question->sum_que_ans == 'television') {
                                                        echo "Television";
                                                    } else if ($question->sum_que_ans == 'no') {
                                                        echo "No";
                                                    } else if ($question->sum_que_ans == 'treatment_inprogress') {
                                                        echo "Treatment Inprogress";
                                                    } else if ($question->sum_que_ans == 'dead') {
                                                        echo "Dead";
                                                    } else if ($question->sum_que_ans == 'good') {
                                                        echo "Good";
                                                    } else if ($question->sum_que_ans == 'average') {
                                                        echo "Average";
                                                    } else if ($question->sum_que_ans == 'news') {
                                                        echo "News";
                                                    } else if ($question->sum_que_ans == 'friends') {
                                                        echo "Friends";
                                                    } else if ($question->sum_que_ans == 'demotration') {
                                                        echo "Demostration";
                                                    } else if ($question->sum_que_ans == 'advertisment') {
                                                        echo "Advertisement";
                                                    } else if ($question->sum_que_ans == 'other') {
                                                        echo "Other";
                                                    }
                                                    ?>
                                <td>
                            </tr>
                    <?php
                        }
                    }
                    ?>


                <?php } ?>
                <?php if ($inc_details[0]->inc_address != '') { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Incident Address</td>
                    </tr>

                    <tr>
                        <!--<td class="width_16 strong">Country</td>
                        <td>India</td>
                        <td class="width_16 strong">State</td>
                        <td><?php //echo $state_name; ?></td>-->
                        <td class="width_16 strong">District</td>
                        <td ><?php echo $district_name; ?></td>
                        <td class="width_16 strong">Tehsil</td>
                        <td><?php echo $tahshil_name; ?></td>
                        <td class="width_16 strong">City / Village</td>
                        <td colspan="3"><?php echo $city_name; ?></td>
                    </tr>

                    <tr>

                        <td class="width_16 strong">Area / Location</td>
                        <td ><?php echo $inc_details[0]->inc_area; ?></td>
                        <td class="width_16 strong">Landmark</td>
                        <td ><?php echo $inc_details[0]->inc_landmark; ?></td>
                        <td class="width_16 strong">Incident Address</td>
                        <td colspan="3"><?php echo $inc_details[0]->inc_address; ?></td>
                    </tr>

                    <!-- <tr>
                         <td class="width_16 strong">Lane / Street</td>
                        <td><?php //echo $inc_details[0]->inc_lane; ?></td>
                        <td class="width_16 strong">House No</td>
                        <td><?php //echo //$inc_details[0]->inc_h_no; ?></td> 
                        <td class="width_16 strong">Landmark</td>
                        <td colspan="2"><?php //echo $inc_details[0]->inc_landmark; ?></td>
                        <td class="width_16 strong">Incident Address</td>
                        <td colspan="4"><?php //echo $inc_details[0]->inc_address; ?></td>
                    </tr>-->

                    <!-- <tr>
                        <td class="width_16 strong">Incident Address</td>
                        <td colspan="5"><?php echo $inc_details[0]->inc_address; ?></td>


                    </tr> -->

                <?php } ?>

                <?php if ($inc_details[0]->inc_system_type == '104') {?>
                    <tr class="single_record_back">
                        <td colspan="8">Address</td>
                    </tr>
                    <tr>
                        <!--<td class="width_16 strong">Country</td>
                        <td>India</td>-->
                        <td class="width_16 strong">State</td>
                        <td><?php echo $state_name; ?></td>
                        <td class="width_16 strong">District</td>
                        <td ><?php echo $district_name; ?></td>
                        <td class="width_16 strong">Tehsil</td>
                        <td><?php echo $tahshil_name; ?></td>
                        <td class="width_16 strong">Area / Location</td>
                        <td ><?php echo $inc_details[0]->inc_area; ?></td>
                    </tr>
                    <?php } ?>
                <?php if ($inc_details[0]->inc_system_type != '104') {?>
                <tr>
                    <td colspan="8" class="single_record_back">Hospital</td>
                </tr>
                
                <tr>
                    <td colspan="2">Priority One Hospital</td>
                    <td colspan="2"><?php echo $amb_data[0]->hp_one; ?>
                    </td>
                    <td colspan="2">Priority Two Hospital
                    </td>
                    <td colspan="2"><?php echo $amb_data[0]->hp_two; ?>
                    </td>
                </tr>

                <?php }?>
                <?php if($inc_details[0]->destination_hospital_other !=" " && $inc_details[0]->destination_hospital_other != NULL){?>
                <tr>
                    <td colspan="4">Other Hospital
                    </td>
                    <td colspan="4"><?php echo $inc_details[0]->destination_hospital_other; ?>
                    </td>
                </tr>
                <?php }?>
                <tr class="single_record_back">
                    <td colspan="8">Caller Details</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Caller No</td>
                    <td><?php echo $inc_details[0]->clr_mobile; ?></td>
                    <td class="width_16 strong">Caller Name</td>
                    <td><?php echo $inc_details[0]->clr_fname; ?> <?php echo $inc_details[0]->clr_mname; ?> <?php echo $inc_details[0]->clr_lname; ?></td>
                    <td class="width_16 strong">Caller Relation</td>
                    <td colspan="3"><?php echo $inc_details[0]->rel_name; ?></td>
                </tr>
                <?php if ($inc_details[0]->inc_system_type == '104') {?>
                <tr>
                    <td class="width_16 strong">Chief Complaint</td>
                    
                    <td colspan="3"><?php if ($inc_details[0]->help_desk_chief_complaint != '') {
                            echo help_chief_comp_types($inc_details[0]->help_desk_chief_complaint);
                        }
                        ?>
                        <?php echo $inc_details[0]->rel_name; ?></td>
                </tr>
                <?php } ?>
                <?php if ($audit_questions[0] != '') { ?>
                    <!-- Audit details -->
                    <tr class="single_record_back">
                        <td colspan="8">Audit Details</td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Opening Greeting</td>
                        <td><?php echo $audit_questions[0]->open_greet_marks; ?></td>
                        <td class="width_16 strong">Verification Matrix</td>
                        <td><?php echo $audit_questions[0]->ver_matrix_marks; ?></td>
                        <td class="width_16 strong">Complete call & system flow</td>
                        <td colspan="3"><?php echo $audit_questions[0]->comp_systm_marks; ?></td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Notification</td>
                        <td><?php echo $audit_questions[0]->notification_marks; ?></td>
                        <td class="width_16 strong">Hold procedure</td>
                        <td><?php echo $audit_questions[0]->hold_procedure_marks; ?></td>
                        <td class="width_16 strong">Communication Skill</td>
                        <td colspan="3"><?php echo $audit_questions[0]->commu_skill_marks; ?></td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Closing Greeting</td>
                        <td><?php echo $audit_questions[0]->closing_greet_marks; ?></td>
                        <td class="width_16 strong">Fatal Indicator</td>
                        <td><?php if ($audit_questions[0]->fetal_indicator == '{"fetal_indicator":"N"}') {
                                echo "No";
                            } else {
                                echo "Yes";
                            } ?></td>
                        <td class="width_16 strong">Fatal Error Indicator </td>
                        <td colspan="3"><?php echo $audit_questions[0]->fetal_error_indicator; ?></td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Quality Score</td>
                        <td><?php echo $audit_questions[0]->quality_score; ?></td>
                        <td class="width_16 strong">Performance Group</td>
                        <td><?php echo $audit_questions[0]->performer_group; ?></td>
                        <td class="width_16 strong">TNA</td>
                        <td colspan="3"><?php echo $audit_questions[0]->tna; ?></td>
                    </tr>
                    <!-- Audit details -->
                <?php } ?>

                <!--                <tr class="single_record_back">                                     
                            <td colspan="6">ERCP Deails</td>
                        </tr>
                        <tr>
                            <td class="width_16 strong">Caller No</td>
                            <td><?php echo $inc_details[0]->clr_mobile; ?></td>
                            <td class="width_16 strong">Caller Name</td>
                            <td><?php echo $inc_details[0]->clr_fname; ?> <?php echo $inc_details[0]->clr_lname; ?></td>
                            <td class="width_16 strong">Caller Relation</td>
                            <td><?php echo $inc_details[0]->rel_name; ?></td>
                        </tr>-->

                <tr class="single_record_back">
                    <td colspan="8">ERC Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">ERO ID</td>
                    <td colspan="3"><?php echo ucwords(strtolower($inc_details[0]->inc_added_by)); ?></td>
                    <td class="width_16 strong">ERO Name</td>
                    <td colspan="3"><?php echo ucwords(strtolower($inc_details[0]->clg_first_name)) . ' ' . ucwords(strtolower($inc_details[0]->clg_last_name)); ?></td>
                </tr>
                <tr>
                    <td class="width_16 strong">Call Received Time</td>
                    <td colspan="3"><?php echo $inc_details[0]->inc_recive_time; ?></td>
                    <td class="width_16 strong">Disconnected Time</td>
                    <td colspan="3"><?php echo $inc_details[0]->inc_datetime; ?></td>
                </tr>
                <tr>
                <tr>


                    <!--                <td class="width_16 strong" >Call Duration</td>
                                        <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>-->
                    <?php if ($inc_details[0]->inc_system_type != '104') {?>
                    <td class="width_16 strong">ERO Standard Remark </td>
                    <td><?php //echo $re_name;
                        if ($inc_details[0]->inc_ero_standard_summary != '') {
                            echo get_ero_remark($inc_details[0]->inc_ero_standard_summary);
                        }
                        ?></td>
                    <?php } else{?>
                        <td class="width_16 strong">ERO Standard Remark </td>
                    <td><?php //echo $re_name;
                        if ($inc_details[0]->help_standard_summary != '') {
                            echo get_ero_remark($inc_details[0]->help_standard_summary);
                        }
                        ?></td>
                        <?php }?>
                    <td class="width_16 strong">ERO Remark</td>
                    <td><?php echo $inc_details[0]->inc_ero_summary; ?></td>

                    <?php if ($inc_details[0]->inc_system_type != '104') {?>
                    <td class="width_16 strong">Shiftmanager Remark</td>
                    <td colspan="3"><?php echo $supervisor_remark[0]->supervisor_remark; ?></td>
                    <?php } else{?>
                        <td class="width_16 strong">Complaint Type</td>
                    <td colspan="3"><?php if ($inc_details[0]->help_complaint_type != '') {
                            echo help_complaints_types($inc_details[0]->help_complaint_type);
                       } ?></td>
                    <?php }?>
                </tr>
                <?php if ($folloup_details != '') { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Follow-Up Information</td>

                    </tr>
                    <tr>
                        <td class="width_16 strong">ERO Note</td>
                        <td class="width_16 strong">Case status</td>
                        <td colspan="2" class="width_16 strong">Call status remark </td>
                        <td class="width_16 strong">Follow-up By</td>
                        <td colspan="3" class="width_16 strong">Follow-up Date</td>
                    </tr>
                    <?php
                    foreach ($folloup_details as $folloup) { ?>
                        <tr>

                            <td><?php echo $folloup->inc_ero_followup_summary; ?></td>
                            <td><?php echo $folloup->inc_ero_followup_status; ?></td>
                            <td colspan="2"><?php echo $folloup->call_status_remark; ?></td>
                            <td><?php echo $folloup->inc_added_by; ?></td>
                            <td colspan="3"><?php echo $folloup->added_date; ?></td>
                        </tr>

                    <?php  } ?>
                <?php } ?>
                <?php if ($counslor_list != '') { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Counslor Information</td>

                    </tr>
                    <tr>
                        <td colspan="2" class="width_16 strong">Standard Remark</td>
                        <td colspan="2" class="width_16 strong">Note</td>
                        <td colspan="2" class="width_16 strong">Added By</td>
                        <td colspan="2" class="width_16 strong">Added Date</td>
                        </tr>
                    <?php
                    foreach ($counslor_list as $counslor_data) { ?>
                        <tr>

                            <td colspan="2"><?php echo $counslor_data->counslor_remark; ?></td>
                            <td colspan="2"><?php echo $counslor_data->cons_advice; ?></td>
                            <td colspan="2"><?php echo $counslor_data->cons_emt; ?></td>
                            <td colspan="2"><?php echo $counslor_data->cons_date; ?></td>
                        </tr>

                    <?php  } ?>
                <?php } ?>
                <?php if ($amb_data[0]->amb_rto_register_no != '') { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Ambulance Information</td>
                    </tr>
                    <?php
                    foreach ($amb_data as $amb_data) {
                        if ($amb_data->amb_rto_register_no != '') {
                    ?>



                            <tr>
                                <td class="width_16 strong">Base location Name</td>
                                <td colspan="7"><?php
                                                //echo get_amb_hp($amb_data->amb_rto_register_no);
                                                echo $amb_data->base_location_name;  ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="width_16 strong">Ambulance Name</td>
                                <td><?php echo $amb_data->amb_rto_register_no; ?></td>
                                <td class="width_16 strong">Ambulance Status</td>
                                <td><?php echo $amb_data->amb_status; ?></td>
                                <td class="width_16 strong">EMT Mobile No </td>
                                <td colspan="3"><?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></td>
                            </tr>
                            <tr>

                                <td class="width_16 strong">EMT Name</td>
                                <td><?php echo $amb_data->clg_first_name . ' ' . $amb_data->clg_mid_name . ' ' . $amb_data->clg_last_name; ?></td>
                                <td class="width_16 strong">Pilot Mobile No </td>
                                <td><?php echo get_amb_mob_pilot($amb_data->amb_rto_register_no); ?></td>
                                <td class="width_16 strong">Pilot Name</td>
                                <td colspan="3"><?php echo $amb_data->pilot_firstnm . ' ' . $amb_data->pilot_midnm . ' ' . $amb_data->pilot_lastnm; ?></td>
                            </tr>
                <?php
                        }
                    }
                }
                ?>
                <?php if ($inc_details[0]->inc_patient_cnt || $inc_details[0]->inc_type == 'AD_SUP_REQ') { ?>
                    <tr class="single_record_back">
                        <td colspan="8">Patient Information</td>
                    </tr>

                    <tr>
                        <td class="width_10 strong">Patient ID</td>
                        <td class="width_16 strong">First Name</td>
                        <td class="width_16 strong">Last Name</td>
                        <td class="width_10 strong">Age</td>
                        <td class="width_10 strong">Ayushman ID</td>
                        <td class="width_10 strong">Blood Group</td>
                        <td class="width_10 strong">Gender</td>
                        <td class="width_10 strong">Action</td>
                    </tr>

                    <?php
                    if ($ptn_details) {
                        foreach ($ptn_details as $ptn) {
                    ?><tr>
                                <td> <?php echo $ptn->ptn_id; ?> </td>
                                <td> <?php echo $ptn->ptn_fname; ?> </td>

                                <td><?php echo $ptn->ptn_lname; ?></td>
                                <td><?php echo $ptn->ptn_age . ' ' . $ptn->ptn_age_type; ?></td>
                                <td><?php echo $ptn->ayushman_id; ?></td>
                                <td><?php echo $ptn->bldgrp_name; ?></td>
                                <td><?php echo get_gen($ptn->ptn_gender) ?></td>
                                <td><a class="btn expand_button expand_btn ptn_view" data-target="<?php echo "pl" . $ptn->ptn_id; ?>">VIEW</a>
                                </td>
                            </tr>
                            <tr id="<?php echo "pl" . $ptn->ptn_id; ?>" style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan single_record_back">
                                <td class="no_before single_record_back" colspan="8">
                                    <table class="table report_table">
                                        <tr>
                                            <td class="single_record_back" colspan="8">DCO Filled Patient Information</td>
                                        </tr>
                                        <!--<tr>
                                    <td class="width_16">Patient Name : <?php echo $ptn->ptn_fname; ?>  <?php echo $ptn->ptn_lname; ?></td>
                                    <td class="width_16">Age : <?php echo $ptn->ptn_age . ' ' . $ptn->ptn_age_type; ?></td>
                                    <td class="width_16">Gender : <?php echo get_gen($ptn->ptn_gender) ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>-->
                                        <?php
                                        $pro_im_id = array('21', '41', '42', '44', '43', '52', '53');
                                        if ($epcr_inc_details) {
                                            foreach ($epcr_inc_details as $epcr) {
                                                if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {

                                        ?>
                                                    <tr>
                                                        <td class="width_25">Provider Impression : <?php if ($epcr->pro_name == '') {
                                                                                                        echo '-';
                                                                                                    } else {
                                                                                                        echo $epcr->pro_name;
                                                                                                    } ?></td>
                                                        <td class="width_25">LOC : <?php echo $epcr->level_type; ?> </td>
                                                        <td class="width_25">Name Of Receiving hospital :
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
                                                        <td class="width_25">Ambulance : <?php echo $epcr->amb_reg_id; ?></td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        } ?>
                                        <?php
                                        if ($epcr_inc_details) {
                                            foreach ($epcr_inc_details as $epcr) {
                                                if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                                    foreach ($driver_data as $driver) {
                                                        if ($epcr->id == $driver->dp_pcr_id) {
                                        ?>
                                                            <tr>
                                                                <td class="width_25">Start From Base :
                                                                    <?php
                                                                    if (date('Y-m-d H:i', strtotime($driver->start_from_base)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->start_from_base)) != '-0001-11-30 00:00') {
                                                                        echo date('Y-m-d H:i', strtotime($driver->start_from_base));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="width_25">At Scene :
                                                                    <?php
                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_started_base_loc)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_started_base_loc)) != '-0001-11-30 00:00') {
                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_started_base_loc));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="width_25">From Scene :
                                                                    <?php
                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_reach_on_scene)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_reach_on_scene)) != '-0001-11-30 00:00') {
                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_reach_on_scene));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="width_25">At Hospital :
                                                                    <?php
                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_hosp_time)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_hosp_time)) != '-0001-11-30 00:00') {
                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_hosp_time));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="width_25">Handover :
                                                                    <?php
                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_hand_time)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_hand_time)) != '-0001-11-30 00:00') {
                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_hand_time));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="width_25">Back To base :
                                                                    <?php
                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_back_to_loc)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_back_to_loc)) != '-0001-11-30 00:00') {
                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_back_to_loc));
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="width_25"></td>
                                                                <td class="width_25"></td>
                                                            </tr>
                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td class="width_25">Odometer Details</td>
                                            <td class="width_25">Previous Odometer : <?php echo $epcr_inc_details[0]->start_odometer; ?></td>
                                            <td class="width_25">Start Odometer : <?php echo $epcr_inc_details[0]->start_odometer; ?></td>
                                            <td class="width_25">End Odometer : <?php echo $epcr_inc_details[0]->end_odometer; ?></td>
                                        </tr>
                                        <?php
                                        if ($epcr_inc_details) {
                                            foreach ($epcr_inc_details as $epcr) {
                                                if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                        ?>
                                                    <tr>
                                                        <td class="width_25">Remark Details</td>
                                                        <td class="width_25">Standard Remark : </td>
                                                        <td class="width_25">DCO Remark : <?php echo $epcr->remark; ?></td>
                                                        <td class="width_25"></td>
                                                    </tr>
                                        <?php }
                                            }
                                        } ?>
                                        <?php
                                        if ($epcr_inc_details) {
                                            foreach ($epcr_inc_details as $epcr) {
                                                if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                        ?>
                                                    <tr>
                                                        <td class="width_25">Case Close Details</td>
                                                        <td class="width_25">Closed By : <?php echo $epcr->clg_first_name . ' ' . $epcr->clg_mid_name . ' ' . $epcr->clg_last_name; ?></td>
                                                        <td class="width_25">Closure Date & Time : <?php echo $epcr->added_date; ?></td>
                                                        <td class="width_25"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="width_25">Case Validate Details</td>
                                                        <td class="width_25">Validate By : <?php
                                                                                            if ($epcr->validate_by != '') {
                                                                                                echo get_clg_name_by_ref_id($epcr->validate_by);
                                                                                            } ?></td>
                                                        <td class="width_25">Validate Date & Time : <?php echo $epcr->validate_date; ?></td>
                                                        <td class="width_25"></td>
                                                    </tr>
                                        <?php }
                                            }
                                        } ?>
                                        <?php
                                        foreach ($er_inc_details as $ercp) {
                                            if ($ptn->ptn_id == $ercp->adv_cl_ptn_id) {
                                        ?>
                                                <tr>
                                                    <td class="width_25">Provider Impression <?php echo $ercp->adv_cl_pro_dia; ?></td>
                                                    <td class="width_25">Chief Complaint : <?php echo $ercp->que_question; ?></td>
                                                    <td class="width_25">Additional Information : <?php echo $ercp->adv_cl_addinfo;  ?></td>
                                                    <td class="width_25">ERCP Note : <?php echo $ercp->adv_cl_ercp_addinfo; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="width_25">ERCP Added By : <?php echo $ercp->adv_cl_added_by; ?></td>
                                                    <td class="width_25"></td>
                                                    <td class="width_25"></td>
                                                    <td class="width_25"></td>
                                                </tr>
                                        <?php }
                                        } ?>

                                        
                                    </table>
                                </td>
                            </tr>
                            <!--<tr id="<?php echo "pl" . $ptn->ptn_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">
                                
                                <td  class="no_before" colspan="7">
                                    

                                    <div class="dtl_block">
                                        <div class="strong" style="font-size: 16px;">                                     
                                            Patient Information:
                                        </div><div class="width1">
                                            <ul>
                                                <li class="float_left width_25 strong">Patient Name</li>
                                                <li class="float_left width_25"> <?php echo $ptn->ptn_fname; ?>  <?php echo $ptn->ptn_lname; ?> </li>
                                                <li class="float_left width_25 strong">Age</li>
                                                <li class="float_left width_25"><?php echo $ptn->ptn_age; ?></li>
                                                <li class="float_left width_25 strong">Gender</li>
                                                <li class="float_left width_25"><?php echo get_gen($ptn->ptn_gender) ?></li>
                                                <?php
                                                if ($epcr_inc_details) {
                                                    foreach ($epcr_inc_details as $epcr) {
                                                        if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                                ?>
                                                            <li class="float_left width_25 strong">LOC</li>
                                                            <li class="float_left width_25"> <?php echo $epcr->level_type; ?> </li>
                                                            <li class="float_left width_25 strong">Provider Impression</li>
                                                            <li class="float_left width_25"><?php
                                                                                            if ($epcr->pro_name == '') {
                                                                                                echo '-';
                                                                                            } else {
                                                                                                echo $epcr->pro_name;
                                                                                            }
                                                                                            ?></li>
                                                            <li class="float_left width_25 strong">Name Of Receiving hospital</li>
                                                            <li class="float_left width_25"><?php
                                                                                            /* if ($epcr->rec_hospital_name != "Other") {
                                                                    echo $epcr->hp_name;
                                                                } else {
                                                                    echo $epcr->other_receiving_host;
                                                                }*/
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
                                                                                            ?></li>
                                                            <li class="float_left width_25 strong">Name of Receiving Ambulance</li>
                                                            <li class="float_left width_25"><?php echo $epcr->amb_reg_id; ?></li>
                                                            <li class="float_left width_25 strong">Comsumables / Drug</li>
                                                            <li class="float_left width_25"></li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                            ?>
                                            </ul></div>
                                        <div class="strong " style="font-size: 16px; float: left;width:100%;">                                     
                                            Driver Parameters:
                                        </div>
                                        <div class="width1">
                                            <ul>
                                                <li class="float_left width_25 strong">Call Received</li>
                                                <li class="float_left width_25"> <?php echo date("H:i", strtotime($inc_details[0]->inc_datetime)); ?> </li>

                                                <?php
                                                if ($epcr_inc_details) {
                                                    foreach ($epcr_inc_details as $epcr) {
                                                        if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                                            foreach ($driver_data as $driver) {
                                                                if ($epcr->id == $driver->dp_pcr_id) {
                                                ?>
                                                                    <li class="float_left width_25 strong">Start From Base </li>
                                                                    <li class="float_left width_25"><?php
                                                                                                    if (date('Y-m-d H:i', strtotime($driver->start_from_base)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->start_from_base)) != '-0001-11-30 00:00') {
                                                                                                        echo date('Y-m-d H:i', strtotime($driver->start_from_base));
                                                                                                    } else {
                                                                                                        echo '-';
                                                                                                    }
                                                                                                    ?></li>
                                                                    <li class="float_left width_25 strong">At Scene</li>
                                                                    <li class="float_left width_25"><?php
                                                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_started_base_loc)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_started_base_loc)) != '-0001-11-30 00:00') {
                                                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_started_base_loc));
                                                                                                    } else {
                                                                                                        echo '-';
                                                                                                    }
                                                                                                    ?></li>
                                                                    <li class="float_left width_25 strong">From Scene </li>
                                                                    <li class="float_left width_25"> <?php
                                                                                                        if (date('Y-m-d H:i', strtotime($driver->dp_reach_on_scene)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_reach_on_scene)) != '-0001-11-30 00:00') {
                                                                                                            echo date('Y-m-d H:i', strtotime($driver->dp_reach_on_scene));
                                                                                                        } else {
                                                                                                            echo '-';
                                                                                                        }
                                                                                                        ?></li>
                                                                    <li class="float_left width_25 strong">At hospital / Ambulance</li>
                                                                    <li class="float_left width_25"><?php
                                                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_hosp_time)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_hosp_time)) != '-0001-11-30 00:00') {
                                                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_hosp_time));
                                                                                                    } else {
                                                                                                        echo '-';
                                                                                                    }
                                                                                                    ?></li>
                                                                    <li class="float_left width_25 strong">Handover </li>
                                                                    <li class="float_left width_25"><?php
                                                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_hand_time)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_hand_time)) != '-0001-11-30 00:00') {
                                                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_hand_time));
                                                                                                    } else {
                                                                                                        echo '-';
                                                                                                    }
                                                                                                    ?></li>
                                                                    <li class="float_left width_25 strong">Back To base </li>
                                                                    <li class="float_left width_25"><?php
                                                                                                    if (date('Y-m-d H:i', strtotime($driver->dp_back_to_loc)) != '1970-01-01 05:30' && date('Y-m-d H:i', strtotime($driver->dp_back_to_loc)) != '-0001-11-30 00:00') {
                                                                                                        echo date('Y-m-d H:i', strtotime($driver->dp_back_to_loc));
                                                                                                    } else {
                                                                                                        echo '-';
                                                                                                    }
                                                                                                    ?></li>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                                    ?>
                                            </ul>
                                        </div>
                                        <div class="strong " style="font-size: 16px; float: left;width:100%;">                                     
                                            Odometer Details:
                                        </div>
                                        <div class="width1">
                                            <ul>
                                                <li class="float_left width_25 strong">Previous Odometer</li>
                                                <li class="float_left width_25"> <?php echo $epcr_inc_details[0]->start_odometer; ?> </li>
                                                <li class="float_left width_25 strong">Start Odometer</li>
                                                <li class="float_left width_25"><?php echo $epcr_inc_details[0]->start_odometer; ?></li>
                                                <li class="float_left width_25 strong">End Odometer</li>
                                                <li class="float_left width_25"><?php echo $epcr_inc_details[0]->end_odometer; ?></li>
                                            </ul>
                                        </div>
                                        <div class="strong " style="font-size: 16px; float: left;width:100%;">                                     
                                            DCO Remark:
                                        </div>
                                        <div class="width1">
                                            <ul>
                                                <?php
                                                if ($epcr_inc_details) {
                                                    foreach ($epcr_inc_details as $epcr) {
                                                        if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                                ?>
                                                            <li class="float_left width_25 strong">Standard Remark</li>
                                                            <li class="float_left width_25"> </li>
                                                            <li class="float_left width_25 strong">DCO Remark</li>
                                                            <li class="float_left width_25"><?php echo $epcr->remark; ?></li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                            ?>
                                            </ul>
                                        </div>
                                        <div class="strong " style="font-size: 16px; float: left;width:100%;">Case Close:
                                        </div>
                                        <div class="width1">
                                            <ul> <?php
                                                    if ($epcr_inc_details) {
                                                        foreach ($epcr_inc_details as $epcr) {
                                                            if ($epcr->ptn_id == $ptn->ptn_id || in_array($epcr->provider_impressions, $pro_im_id)) {
                                                    ?>
                                                            <li class="float_left width_25 strong">Close By</li>
                                                            <li class="float_left width_25"> <?php echo $epcr->clg_first_name . ' ' . $epcr->clg_mid_name . ' ' . $epcr->clg_last_name; ?></li>
                                                            <li class="float_left width_25 strong">Close Date & Time</li>
                                                            <li class="float_left width_25"> <?php echo $epcr->added_date; ?></li>
                                                            <?php
                                                            }
                                                        }
                                                    }
                                                            ?>
                                            </ul>
                                        </div>
                                        <div class="strong " style="font-size: 16px; float: left;width:100%;">                                                                  ERCP Advice if taken:
                                        </div>
                                        <div class="width1">
                                            <ul>

                                                <?php
                                                foreach ($er_inc_details as $ercp) {

                                                    if ($ptn->ptn_id == $ercp->adv_cl_ptn_id) {
                                                ?>

                                                        <li class="float_left width_25 strong">Provider Impression</li>
                                                        <li class="float_left width_25"> <?php echo $ercp->adv_cl_pro_dia; ?> </li>
                                                        <li class="float_left width_25 strong">Chief Complaint</li>
                                                        <li class="float_left width_25"> <?php echo $ercp->que_question; ?> </li>
                                                        <li class="float_left width_25 strong">Additional Information</li>
                                                        <li class="float_left width_25"> <?php echo $ercp->adv_cl_addinfo; ?> </li>
                                                        <li class="float_left width_25 strong">ERCP Note</li>
                                                        <li class="float_left width_25"> <?php echo $ercp->adv_cl_ercp_addinfo; ?> </li>
                                                        <li class="float_left width_25 strong">ERCP Added By</li>
                                                        <li class="float_left width_25"> <?php echo $ercp->adv_cl_added_by; ?> </li>
                                                        
                                                        <?php
                                                    }
                                                }
                                                        ?>
                                            </ul>
                                        </div>


                                    </div>

                                </td>
                            </tr>-->
                <?php
                        }
                    }
                }
                ?>



            </table>
        </div>

    </div>
<?php } else { ?>
    <div class="width100">
        <div class="width100 strong"> No Record Founds </div>
    </div>
<?php
} ?>
<style>
    #colorbox {
        top: 40px !important;
        left: 90px !important;
        width: 1295px !important;
        height: 571px !important;
    }

    #cboxWrapper,
    #cboxLoadedContent,
    #cboxContent {
        float: left !important;
        width: 1295px !important;
        height: 571px !important;
    }
</style>