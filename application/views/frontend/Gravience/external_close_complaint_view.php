<style>
    .txt_clr2{
        width:100% !important;
    }
</style>
<?php
if ($update == 'update') {
    $update = 'disabled';
}

if ($view == 'view') {
    $view = 'disabled';
}
?>

<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>


        <div class="field_row width100  fleet" ><div class="single_record_back">Previous  Information</div></div>
        <div class="field_row width100">
            <div class="width2 float_left mt-2">
                <div class="filed_lable float_left width33"><label for="station_name">Complaint Date Time<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">
                    <input name="gri[gc_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Start Date / Time" type="text"  data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$grievance_data[0]->gc_date_time; ?>"   <?php echo $update; ?>  <?php echo $view; ?>>
                    <input name="inc_datetime" class="" value="<?php echo $inc_call_type[0]->inc_datetime; ?>" type="hidden" tabindex="2" placeholder="Incident Date Time" >

                </div>


            </div>
            <div class="width2 float_left mt-2">
                <div class="filed_lable float_left width33"><label for="station_name">Complaint Register No<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">



                    <input name="gri[gc_inc_ref_id]" tabindex="20" class="form_input  filter_required" placeholder="Start Date / Time" type="text"  data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$grievance_data[0]->gc_inc_ref_id; ?>"   <?php echo $update; ?> <?php echo $view; ?>>
                    <input name="incident_id" class="" value="<?php echo $inc_ref_id; ?>" type="hidden" tabindex="2" placeholder="Incident ID">

                </div>


            </div>
            <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar " id="open_greet_ques_outer">
                <div class="width100 float_left">
                    <div class="quality_arrow_back" style=" font-weight:bold; padding-left:5px;">Incident Details</div>
                </div>
            </div>
            <div class="checkbox_div hide">
                <div class="width100  float_left">
                    <table class="table report_table">
                    <?php //var_dump($inc_details); ?>
                <tr class="single_record_back">                                     
                    <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Incident Call Type</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Call Type </td>
                    <td><?php
                        echo ucwords($pname[0]->pname);
                        if ($inc_details[0]->cl_name != '') {
                            ?> &nbsp; [ <?php echo $inc_details[0]->cl_name; ?> ] <?php } ?> </td>

                    <?php if ($inc_details[0]->incis_deleted == '2') { ?>
                        <td class="width_16 strong">Status</td>
                        <td class="width_16">Termination Call</td>
                    <?php } ?>
                </tr>
                <tr class="single_record_back">                                     
                    <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Incident Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Incident Id</td>
                   <?php //var_dump($inc_details[0]->inc_datetime);die;?>
                    <td class="width_16"><?php echo $inc_details[0]->inc_ref_id; ?></td>
                    <td class="width_16 strong">Date & Time</td>
                    <td><?php echo $inc_details[0]->inc_datetime; ?></td> 
                    <td class="width_16 strong">Call Duration</td>
                    <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>
                     
                </tr>
                <tr>
                        <td class="width_16 strong">Incident Recording </td>
                      
                        <td colspan="5">
                          <?php  
                        
                            $inc_datetime = date("Y-m-d", strtotime($inc_details[0]->inc_datetime));
                            $pic_path =  "{base_url}uploads/audio_files/".$inc_details[0]->inc_audio_file;
                            $pic_path =   get_inc_recording($inc_details[0]->inc_avaya_uniqueid,$inc_datetime);
                            if($pic_path != ''){
                            ?>
                            
                            <audio controls controlsList="nodownload">
                              <source src="<?php echo $pic_path;?>" type="audio/wav">
                            Your browser does not support the audio element.
                            </audio> 
                             <?php
                        }
                        
                        ?>
                        </td>
                       
                        
                </tr>
                <tr><?php if (trim($inc_details[0]->inc_type) == 'MCI' || trim($inc_details[0]->inc_type) == 'VIP_CALL') { ?>


                        <td class="width_25 strong">MCI Nature</td>
                        <td class="width_25"><?php echo ($inc_details[0]->ntr_nature) ? $inc_details[0]->ntr_nature : '-'; ?></td>

                    <?php } else if ($chief_complete_name != '') { ?> 
                        <td class="width_16 strong">Chief Complaint</td>
                        <td class="width_16"><?php echo $chief_complete_name; ?></td>
                    <?php } ?>
                    <?php if ($po_ct_name != '') { ?> 
                        <td class="width_16 strong" >Police Complaint</td>
                        <td class="width_16"><?php echo $po_ct_name; ?></td>
                    <?php } ?> 
                    <?php if ($fi_ct_name != '') { ?> 
                        <td class="width_16 strong">Fire Complaint</td>
                        <td class="width_16"><?php echo $fi_ct_name; ?></td>
                    <?php } ?> 
                </tr>
                <tr><?php if ($inc_details[0]->inc_patient_cnt > 0) { ?>
                        <td class="width_16 strong">Patient Count</td>
                        <td> <?php echo $inc_details[0]->inc_patient_cnt; ?></td>
                    <?php } ?>
                    <?php if ($inc_details[0]->pre_inc_ref_id != '') { ?>
                        <td class="width_16 strong">Previous Incident Id</td>
                        <td class="width_16"><?php echo $inc_details[0]->pre_inc_ref_id; ?></td>
                    <?php } ?>
                    <?php if ($ambt_name != '') { ?>
                        <td class="width_16 strong">Suggested Ambulance type</td>
                        <td><?php echo $ambt_name; ?></td>
                    <?php } ?>
                    <?php if (unserialize($inc_details[0]->inc_service) != '') { ?>
                        <td class="width_16 strong">Services</td>
                        <td><?php
                            $services = unserialize($inc_details[0]->inc_service);
                            foreach ($services as $key => $value) {
                                if ($value == '1') {
                                    echo "Medical" . ',';
                                }
                                if ($value == '2') {
                                    echo "Police" . ',';
                                }
                                if ($value == '3') {
                                    echo "Fire";
                                }
                            }
                            ?></td>
                    <?php } ?>

                </tr>
                <?php if ($questions) { ?>    
                <tr > <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Question & Answer</td></tr> <?php } ?>

                <?php
                if ($questions) {
                    foreach ($questions as $key => $question) {
                        ?>
                        <tr><td colspan="4"><?php echo $question->que_question; ?>
                            </td >
                            <td colspan="2"> <?php
                                if ($question->sum_que_ans == 'N') {
                                    echo "No";
                                } else {
                                    echo "Yes";
                                }
                                ?><td>
                        </tr>
                        <?php
                    }
                }
                ?>

                <?php if ($enq_que[0]['que'] != ''  && ($inc_details[0]->inc_type=='ENQ_CALL')) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Enquiry Question & Answer </td>
                    </tr>
                <?php } ?>

                <?php
                if ($enq_que) {
                    foreach ($enq_que as $enq_que) {
                        ?>
                        <tr><td colspan="3" class="strong"><?php echo $enq_que['que']; ?>
                            </td>
                            <td colspan="3"> <?php
                                echo $enq_que['ans'];
                                ?><td>
                        </tr>
                        <?php
                    }
                }
                ?>


                <?php if ($facility_details) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Facility Details</td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">Current Facility</td>
                        <td><?php echo $facility_details[0]->current_facility; ?></td>
                        <td class="width_16 strong">Reporting Doctor</td>
                        <td><?php echo $facility_details[0]->rpt_doc; ?></td>
                        <td class="width_16 strong">Mobile Number</td>
                        <td><?php echo $facility_details[0]->mo_no; ?></td>
                    </tr>
                    <tr>
                        <td class="width_16 strong">New Facility</td>
                        <td><?php echo $facility_details[0]->new_facility; ?></td>
                        <td class="width_16 strong">Reporting Doctor</td>
                        <td><?php echo $facility_details[0]->new_rpt_doc; ?></td>
                        <td class="width_16 strong">Mobile Number</td>
                        <td><?php echo $facility_details[0]->new_mo_no; ?></td>
                    </tr>

                <?php } ?>

                <?php if ($feed_questions) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Feedback Details</td>
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
                        <td><?php echo get_feedback_complaint($feedback_details[0]->fc_standard_type); ?></td>

                    </tr>
                    <tr>

                        <td class="width_16 strong">Employee Remark</td>
                        <td><?php echo $feedback_details[0]->fc_employee_remark; ?></td>

                    </tr>

                    <?php if ($feed_questions) { ?>    <tr > <td colspan="6" class="strong">Question & Answer</td></tr> <?php } ?>

                    <?php
                    if ($feed_questions) {
                        foreach ($feed_questions as $key => $question) {
                            ?>
                            <tr><td colspan="4"><?php echo $question->que_question; ?>
                                </td >
                                <td colspan="2"> <?php
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
                                    ?><td>
                            </tr>
                            <?php
                        }
                    }
                    ?>


                <?php } ?>
                <?php if ($inc_details[0]->inc_address != '') { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Incident Address</td>
                    </tr>

                    <tr>
                        <td class="width_16 strong">Country</td>
                        <td>India</td>

                        <td class="width_16 strong">State</td>
                        <td><?php echo $state_name; ?></td>
                        <td class="width_16 strong">District</td>
                        <td><?php echo $district_name; ?></td>

                    </tr>

                    <tr>
                        <td class="width_16 strong">Tehsil</td>
                        <td><?php echo $tahshil_name; ?></td>
                        <td class="width_16 strong">City / Village</td>
                        <td><?php echo $city_name; ?></td>
                        <td class="width_16 strong">Locality</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td class="width_16 strong">Lane / Street</td>
                        <td><?php echo $inc_details[0]->inc_lane; ?></td>
                        <td class="width_16 strong">House No</td>
                        <td><?php echo $inc_details[0]->inc_h_no; ?></td>
                        <td class="width_16 strong">Landmark</td>
                        <td><?php echo $inc_details[0]->inc_landmark; ?></td>
                    </tr>

                    <tr>
                        <td class="width_16 strong">Incident Address</td>
                        <td colspan="5"><?php echo $inc_details[0]->inc_address; ?></td>


                    </tr>

                <?php } ?>

                <tr class="single_record_back">                                     
                    <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Caller Details</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Caller No</td>
                    <td><?php echo $inc_details[0]->clr_mobile; ?></td>
                    <td class="width_16 strong">Caller Name</td>
                    <td><?php echo ucwords($inc_details[0]->clr_fname); ?> <?php echo ucwords($inc_details[0]->clr_lname); ?></td>
                    <td class="width_16 strong">Caller Relation</td>
                    <td><?php echo $inc_details[0]->rel_name; ?></td>
                </tr>

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
                      
                    <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">ERC Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">ERO ID</td>
                    <td colspan="1"><?php echo ucwords(strtolower($inc_details[0]->inc_added_by)); ?></td>
                    <td class="width_16 strong">ERO Name</td>
                    <td colspan="3"><?php echo ucwords(strtolower($inc_details[0]->clg_first_name)).' '.ucwords(strtolower($inc_details[0]->clg_last_name)); ?></td>
                </tr> 
                <tr> 
                    <td class="width_16 strong">Call Received Time</td>
                    <td td colspan="1"><?php echo $inc_details[0]->inc_recive_time; ?></td>
                    <td class="width_16 strong">Disconnected Time</td>
                    <td td colspan="3"><?php echo $inc_details[0]->inc_datetime; ?></td>
                </tr>
                <tr>
                <tr>


                        <!--                <td class="width_16 strong" >Call Duration</td>
                                        <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>-->
                    <td class="width_16 strong">ERO Standard Remark </td>
                    <td><?php echo $inc_details[0]->re_name; ?></td>
                    <td class="width_16 strong" >ERO Remark</td>
                    <td ><?php echo $inc_details[0]->inc_ero_summary; ?></td>
                     <td class="width_16 strong" >Shiftmanager Remark</td>
                    <td><?php echo $supervisor_remark[0]->supervisor_remark; ?></td>

                </tr>
                <?php if ($amb_data[0]->amb_rto_register_no != '') { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Ambulance Information</td>
                    </tr>
                    <?php
                    foreach ($amb_data as $amb_data) {
                        if ($amb_data->amb_rto_register_no != '') {
                            ?>



                            <tr>
                                <td class="width_16 strong">Base location Name</td>
                                <td colspan="4"><?php echo get_amb_hp($amb_data->amb_rto_register_no); ?></td>
                            </tr><tr>
                                <td class="width_16 strong">Ambulance Name</td>
                                <td><?php echo $amb_data->amb_rto_register_no; ?></td>
                                <td class="width_16 strong">Ambulance Status</td>
                                <td><?php echo $amb_data->amb_status; ?></td>
                                <td class="width_16 strong">Mobile No </td>
                                <td colspan="5"><?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></td>
                            </tr>
                            <tr>

                                <td class="width_16 strong">EMT Name</td>
                                <td><?php echo $amb_data->amb_emt_id; ?></td>
                                <td class="width_16 strong">Pilot Name</td>
                                <td colspan="3"><?php echo $amb_data->amb_pilot_id; ?></td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                <?php if ($inc_details[0]->inc_patient_cnt) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Patient Information</td>
                    </tr>

                    <tr>
                        <td class="width_16 strong">Patient ID</td>
                        <td class="width_16 strong">Patient First Name</td>
                        <td class="width_16 strong">Patient Last Name</td>
                        <td class="width_16 strong">Age</td>
                        <td class="width_16 strong">Gender</td>
                        <td class="width_16 strong">Action</td>
                    </tr>

                    <?php
                    if ($ptn_details) {
                        foreach ($ptn_details as $ptn) {
                            ?><tr>
                                <td>   <?php echo $ptn->ptn_id; ?>   </td>
                                <td>   <?php echo $ptn->ptn_fname; ?>   </td>

                                <td><?php echo $ptn->ptn_lname; ?></td>
                                <td><?php echo $ptn->ptn_age; ?></td>
                                <td><?php echo get_gen($ptn->ptn_gender) ?></td>
                                <td><a class="btn expand_button expand_btn ptn_view" data-target="<?php echo "pl" . $ptn->ptn_id; ?>" >VIEW</a>
                                </td>
                            </tr>
                            <tr id="<?php echo "pl" . $ptn->ptn_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                                <td  class="no_before" colspan="7">
                                    <!--<ul class="dtl_block">-->

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
                                                        if ($epcr->ptn_id == $ptn->ptn_id) {
                                                            ?>
                                                            <li class="float_left width_25 strong">LOC</li>
                                                            <li class="float_left width_25"> <?php echo $epcr->level_type; ?> </li>
                                                            <li class="float_left width_25 strong">Provider Impression</li>
                                                            <li class="float_left width_25"><?php echo $epcr->pro_name; ?></li>
                                                            <li class="float_left width_25 strong">Name Of Receiving hospital</li>
                                                            <li class="float_left width_25"><?php
                                                                if ($epcr->rec_hospital_name != "Other") {
                                                                    echo $epcr->hp_name;
                                                                } else {
                                                                    echo $epcr->other_receiving_host;
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
                                                        if ($epcr->ptn_id == $ptn->ptn_id) {
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
                                                        if ($epcr->ptn_id == $ptn->ptn_id) {
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
                                        <div class="strong " style="font-size: 16px; float: left;width:100%;">                                                                  Case Close:
                                        </div>
                                        <div class="width1">
                                            <ul> <?php
                                                if ($epcr_inc_details) {
                                                    foreach ($epcr_inc_details as $epcr) {
                                                        if ($epcr->ptn_id == $ptn->ptn_id) {
                                                            ?>
                                                            <li class="float_left width_25 strong">Close By</li>
                                                            <li class="float_left width_25"> <?php echo $epcr->operate_by; ?> </li>
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
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>


                                    </div>

                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>



            </table>
                </div>
            </div>
        </div>
            <div class="width2 float_left mt-2">
                <div class="filed_lable float_left width33"><label for="station_name">Caller Number<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_caller_number]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$grievance_data[0]->gc_caller_number ?>" TABINDEX="1"  <?php echo $update; ?> <?php echo $view; ?>>

<!--            <input   type="hidden" name="gri[caller_id]" class="filter_required" value="<?= @$pt_info[0]->clr_id ?>" TABINDEX="1">
            <input   type="hidden" name="gri[call_id]" class="filter_required" value="<?= @$pt_info[0]->cl_id ?>" TABINDEX="1">-->

                </div>


            </div>

            <div class="width2 float_left mt-2">
                <div class="filed_lable float_left width33"><label for="station_name">Caller Name<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_caller_name]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$grievance_data[0]->gc_caller_name ?>" TABINDEX="1"   <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
        </div>
        <div class="field_row width100">
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">District <span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input type="text" name="gri[gc_district_code]" data-value="<?= @$grievance_data[0]->dst_name ?>" value="<?= @$grievance_data[0]->dst_code; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_district/<?php echo $default_state;?>"  placeholder="District" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Ambulance Number<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_ambulance_no]"  placholder="Complaint Register No"  value="<?= @$grievance_data[0]->gc_ambulance_no ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>

            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Incident Number</label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_pre_inc_ref_id]"  placholder="Complaint Register No"  value="<?= @$grievance_data[0]->gc_pre_inc_ref_id ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?> >

                </div>


            </div>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Patient Name </label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_ptn_name]"  placholder="Call Receiver Name"  value="<?= @$grievance_data[0]->gc_ptn_name ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>   <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
        </div>
        <div class="field_row width100">

            <!--            <div class="width33 float_left">   
                            <div class=" blue float_left width33">Chief Complaint</div>
                            <div class="input  top_left float_left width50" >
                                <input type="text" name="gri[gc_chief_complaint]" id="chief_complete" data-value="<?= @$grievance_data[0]->ct_type; ?>" value="<?= @$grievance_data[0]->gc_chief_complaint; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_chief_complete"  placeholder="Chief Complaint" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?>>
                            </div>
                        </div>-->

            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Grievance Type<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input type="text" name="gri[gc_grievance_type]" id="chief_complete" data-value="<?= @$grievance_data[0]->grievance_type; ?>" value="<?= @$grievance_data[0]->gc_grievance_type; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_grievance_type"  placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Grievance Sub-Type <span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input type="text" name="gri[gc_grievance_sub_type]" id="chief_complete" data-value="<?= @$grievance_data[0]->grievance_sub_type; ?>" value="<?= @$grievance_data[0]->gc_grievance_sub_type; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_grievance_sub_type"  placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
        </div>
        <div class="field_row width100">

            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Grievance Details<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_grievance_details]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$grievance_data[0]->gc_grievance_details; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>

            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">EMT Name</label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_emso_name]"  placholder="Complaint Register No"  value="<?= @$grievance_data[0]->gc_emso_name; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?> >

                </div>


            </div>
        </div>

        <div class="field_row width100">
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Pilot Name </label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_pilot_name]"  placholder="Call Receiver Name"  value="<?= @$grievance_data[0]->gc_pilot_name; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Complaint Register By<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_complaint_register_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$grievance_data[0]->gc_complaint_register_by; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
        </div>
        <div class="field_row width100">
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Grievance Standerd Remark</label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_standard_remark]"  placholder="Standard Remark "  value="<?= @$grievance_data[0]->gc_standard_remark; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Grievance Remark<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_remark]" class="filter_required" placholder="Remark" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$grievance_data[0]->gc_remark; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
        </div>
        <div class="field_row width100">
        <?php if($grievance_data[0]->gc_emt_name_other != ''){
            ?>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Other EMT Name</label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_emt_name_other]"  placholder="Complaint Register No"  value="<?= @$grievance_data[0]->gc_emt_name_other; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?> >

                </div>


            </div>
            <?php
        } ?>
           <?php if($grievance_data[0]->gc_pilot_name_other != ''){
            ?> 
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Other Pilot Name </label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="gri[gc_pilot_name_other]"  placholder="Call Receiver Name"  value="<?= @$grievance_data[0]->gc_pilot_name_other; ?>" TABINDEX="1"  <?php
                    echo $view;
                    if (@$update) {
                        echo"disabled";
                    }
                    ?>  <?php echo $update; ?> <?php echo $view; ?>>

                </div>


            </div>
            <?php
        } ?>
         <div class="field_row width100">
         <div class="filed_lable float_left width8"><label for="station_name">Photo & documents</label></div>
        <div class="filed_input float_left width90">
         <?php 
         if ($his > 0) {
            foreach ($his as $stat_data) {
                $name = $stat_data->media_name;
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $pic_path = FCPATH . "uploads/grievance_files/" . $name;
                if (file_exists($pic_path)) {
                    $pic_path1 = base_url() . "uploads/grievance_files/" . $name;
                }
                $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
            <?php 
            if($ext=='pdf'){
                $pic_path_pdf = FCPATH . "uploads/grievance_files/pdf_img.png";
                $pic_path_pdf1 = base_url() . "uploads/grievance_files/pdf_img.png";
            ?>
            
                <a class="ambulance_photo" target="blank" href="<?php if (file_exists($pic_path)) { echo $pic_path1; } else { echo $blank_pic_path; } ?>" style="background: url('<?php if (file_exists($pic_path_pdf)) { echo $pic_path_pdf1;  } else { echo $blank_pic_path; }  ?>') no-repeat left center; background-size: contain; height: 75px; width:100px;margin:5px;float:left;"  <?php echo $view; ?>></a>  
            <?php }
            else if($ext=='doc' || $ext=='docx'){
                $pic_path_doc = FCPATH . "uploads/grievance_files/doc_img.png";
                $pic_path_doc1 = base_url() . "uploads/grievance_files/doc_img.png";
                ?>
                 <a class="ambulance_photo" target="blank" href="<?php if (file_exists($pic_path)) { echo $pic_path1; } else { echo $blank_pic_path; } ?>" style="background: url('<?php if (file_exists($pic_path_doc)) { echo $pic_path_doc1;  } else { echo $pic_path_doc; }  ?>') no-repeat left center; background-size: contain; height: 75px; width:100px;margin:5px;float:left;"  <?php echo $view; ?>></a>  
                <?php
            }
            else{
            ?>
            <a class="ambulance_photo" target="blank" href="<?php if (file_exists($pic_path)) { echo $pic_path1; } else { echo $blank_pic_path; } ?>" style="background: url('<?php if (file_exists($pic_path)) { echo $pic_path1;  } else { echo $blank_pic_path; }  ?>') no-repeat left center; background-size: contain; height: 75px; width:100px;margin:5px;float:left;"  <?php echo $view; ?>></a>  
                
            <?php
            }
            }
         }
         ?> 
         </div>
         </div>
         </div>
        <div class="width100 float_left">

   <?php  if (@$grievance_data[0]->gc_closure_status != 'complaint_open') {
                ?>


            <?php if (!empty($cl_dtl)) {
                ?>

                <ul class="dtl_block">
                    <li><h3 class="txt_clr2 width1 txt_pro">Previous Calls</h3></li>



                    <?php
                    $CALL = 1;

                    foreach ($cl_dtl as $cll_dtl) {
                        ?>

                        <li><a class=" expand_button expand_btn gri_view"  data-target="<?php echo "cl" . $cll_dtl->gc_id; ?>"><span><?php echo "CALL " . $CALL++; ?> : <?php ?></span></a></li>


                        <li id="<?php echo "cl" . $cll_dtl->gc_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

                            <div  class="" >
                                <div class="dtl_block">    <!--<ul class="dtl_block">-->

                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Reply from<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width50">


                                                <select name="gri[gc_reply_from]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $view; ?>  <?php echo $update; ?> > 
                                                    <option value="" <?php echo $disabled; ?>>Select Reply from</option>
                                                    <option value="ADM"  <?php
                                                    if ($cll_dtl->gc_reply_from == 'ADM') {
                                                        echo "selected";
                                                    }
                                                    ?>  >ADM </option>
                                                    <option value="ZM"  <?php
                                                    if ($cll_dtl->gc_reply_from == 'ZM') {
                                                        echo "selected";
                                                    }
                                                    ?>  >ZM </option>
                                                    <option value="DM"  <?php
                                                    if ($cll_dtl->gc_reply_from == 'DM') {
                                                        echo "selected";
                                                    }
                                                    ?>  >DM </option>
                                                    <option value="Supervisor"  <?php
                                                    if ($cll_dtl->gc_reply_from == 'Supervisor') {
                                                        echo "selected";
                                                    }
                                                    ?>  >Supervisor </option>

                                                </select>


                                            </div>


                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                        

                                                <input   type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= $cll_dtl->gc_emp_close_by; ?>" TABINDEX="1" 
                                                         <?php echo $view; ?>  <?php echo $update; ?>  >

                                            </div>

                                        </div>



                                    </div>
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Closure Status<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_closure_status]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $view; ?>  <?php echo $update; ?>  > 
                                                    <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>

                                                    <option value="complaint_close"  <?php
                                                    if ($cll_dtl->gc_closure_status == 'complaint_close') {
                                                        echo "selected";
                                                    }
                                                    ?>>Complaint Close</option> 
                                                    <option value="complaint_pending"  <?php
                                                    if ($cll_dtl->gc_closure_status == 'complaint_pending') {
                                                        echo "selected";
                                                    }
                                                    ?>>Complaint Pending</option> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                                            <div class="filed_input float_left width50">
                                                <select name="gri[gc_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $view; ?>  <?php echo $update; ?> > 
                                                    <option value="" >Select Grievance Remark</option>
                                                    <option value="complaint_close_sucessfully"  <?php
                                                    if ($cll_dtl->gc_standard_remark == 'complaint_close_sucessfully') {
                                                        echo "selected";
                                                    }
                                                    ?>  >Complaint Close Sucessfully </option>
                                                       <option value="complaint_pending_sucessfully"  <?php
                                                    if ($cll_dtl->gc_standard_remark == 'complaint_pending_sucessfully') {
                                                        echo "selected";
                                                    }
                                                    ?>  >Complaint Pending </option>
                                                </select>
                                            </div>
                                        </div>



                                    </div>


<!--                                    <div class="field_row width100">


                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder mail<span class="md_field">*</span></label></div>

                                            <div class="filed_input width50 float_left">
                                                               <label for="gender">Gender<span class="md_field">*</span></label>
                                                <?php $report[$cll_dtl->gc_reminder_mail] = "checked"; ?>

                                                <div class="radio_button_div1">
                                                    <label for="fire_y" class="radio_check float_left width50">  
                                                        <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" <?php echo $report['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n" class="radio_check float_left width50">  
                                                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" <?php echo $report['no']; ?> class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="width2 float_left">
                                            <div class="field_lable float_left width33"> <label for="mobile_no">Remainder call<span class="md_field">*</span></label></div>

                                            <div class="filed_input width2 float_left">
                                                               <label for="gender">Gender<span class="md_field">*</span></label>
                                                <?php $re[$cll_dtl->gc_reminder_call] = "checked"; ?>

                                                <div class="radio_button_div1">
                                                    <label for="fire_y1" class="radio_check float_left width50">  
                                                        <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_y1" type="radio" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" <?php echo $re['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                                                    </label>

                                                    <label for="fire_n1" class="radio_check float_left width50">  
                                                        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_n1" type="radio" value="no" <?php echo $re['no']; ?> class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder filter_required"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="field_row width100">

                                        <div class="width2 float_left">
                                            <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                                            <div class="filed_input float_left width2">

                                                <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Action should not be blank'}" <?php echo $view; ?>  <?php echo $update; ?> ><?= $cll_dtl->gc_action_taken; ?>  </textarea>

                                            </div>
                                        </div>
                                        <div class="width2 float_left">

                                            <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                                            <div class="filed_input float_left width50" >
                                                <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}"  <?php echo $view; ?>  <?php echo $update; ?> ><?= $cll_dtl->gc_caller_closure_remark; ?></textarea>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>


                    <?php }
                    ?>
                </ul>

            <?php } 
   }?>



        </div>

  <?php if ($view != 'disabled') { ?>
        <div class="field_row width100  fleet" ><div class="single_record_back">Current Information</div></div>
        <div class="field_row width100">


            <div class="width2 float_left mt-1">
                <div class="filed_lable float_left width33"><label for="station_name">Reply From<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width50">


                    <select name="gri[gc_reply_from]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $view; ?>> 
                        <option value="" <?php echo $disabled; ?>>Select Reply From</option>
                        <option value="ADM"  <?php
                        if ($grievance_data1[0]->gc_reply_from == 'ADM') {
                            echo "selected";
                        }
                        ?>  >ADM </option>
                        <option value="ZM"  <?php
                        if ($grievance_data1[0]->gc_reply_from == 'ZM') {
                            echo "selected";
                        }
                        ?>  >ZM </option>
                        <option value="DM"  <?php
                        if ($grievance_data[0]->gc_reply_from == 'DM') {
                            echo "selected";
                        }
                        ?>  >DM </option>
                        <option value="Supervisor"  <?php
                        if ($grievance_data1[0]->gc_reply_from == 'Supervisor') {
                            echo "selected";
                        }
                        ?>  >Supervisor </option>

                    </select>


                </div>


            </div>

            <div class="width2 float_left mt-1">
                <div class="field_lable float_left width33"> <label for="date_time">Employee Name<span class="md_field">*</span></label></div>
                <div class="filed_input float_left width50">
                <select name="gri[gc_emp_close_by]" tabindex="8" id="" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"    > 
                                                    <option value="" >Select Grievance Employee</option>
                                                    <?php
                                                    //var_dump($gr_clg);
                                                if ($gr_clg) {
                                                    foreach ($gr_clg as $clg) { ?>
                                                            <option value="<?php echo ucwords($clg->clg_first_name. " ".$clg->clg_last_name); ?>" ><?php echo ucwords($clg->clg_first_name. " ".$clg->clg_last_name); ?></option>
                                                   <?php } }?>
                                                </select>

                    <!-- <input   type="text" name="gri[gc_emp_close_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$grievance_data1[0]->gc_emp_close_by; ?>" TABINDEX="1" 
                             <?php echo $view; ?>  > -->

                </div>

            </div>

        </div>
        <div class="field_row width100">

            <div class="width2 float_left">
                <div class="field_lable float_left width33"> <label for="date_time">Closure status<span class="md_field">*</span></label></div>
                <div class="filed_input float_left width50">
                    <select name="gri[gc_closure_status]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $view; ?> > 
                        <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>

                        <option value="complaint_close"  <?php
                        if ($grievance_data1[0]->gc_closure_status == 'complaint_close') {
                            echo "selected";
                        }
                        ?>>Complaint Close</option> 
                        <option value="complaint_pending"  <?php
                        if ($grievance_data[10]->gc_closure_status == 'complaint_pending') {
                            echo "selected";
                        }
                        ?>>Complaint Pending</option> 

                    </select>
                </div>
            </div>
            <div class="width2 float_left">
                <div class="field_lable float_left width33"> <label for="date_time">Grievance Remark<span class="md_field">*</span></label></div>
                <div class="filed_input float_left width50">
                    <select name="gri[gc_standard_remark]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $view; ?>> 
                        <option value="" >Select Grievance Remark</option>
                        <option value="complaint_close_sucessfully"  <?php
                        if ($grievance_data1[0]->gc_standard_remark == 'complaint_close_sucessfully') {
                            echo "selected";
                        }
                        ?>  >Complaint Close Sucessfully </option>
                        <option value="complaint_pending_sucessfully"  <?php
                        if ($grievance_data1[0]->gc_standard_remark == 'complaint_pending_sucessfully') {
                            echo "selected";
                        }
                        ?>  >Complaint Pending</option>
                    </select>
                </div>
            </div>



        </div>


        <div class="field_row width100">


            <div class="width2 float_left">
                <div class="field_lable float_left width33"> <label for="mobile_no">Remainder Mail<span class="md_field">*</span></label></div>

                <div class="filed_input width50 float_left">
               <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                    <?php $report[$grievance_data1[0]->gc_reminder_mail] = "checked"; ?>

                    <div class="radio_button_div1">
                        <label for="fire_y" class="radio_check float_left width50">  
                            <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_y" type="radio" name="gri[gc_reminder_mail]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" <?php echo $report['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                        </label>

                        <label for="fire_n" class="radio_check float_left width50">  
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_n" type="radio" name="gri[gc_reminder_mail]" value="no" <?php echo $report['no']; ?> class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder filter_required"></span>No
                        </label>
                    </div>
                </div>
            </div>
            <div class="width2 float_left">
                <div class="field_lable float_left width33"> <label for="mobile_no">Remainder Call<span class="md_field">*</span></label></div>

                <div class="filed_input width2 float_left">
               <!--                    <label for="gender">Gender<span class="md_field">*</span></label>-->
                    <?php $re[$grievance_data1[0]->gc_reminder_call] = "checked"; ?>

                    <div class="radio_button_div1">
                        <label for="fire_y1" class="radio_check float_left width50">  
                            <input  data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_y1" type="radio" name="gri[gc_reminder_call]" value="yes" class="radio_check_input filter_required" data-errors="{filter_required:'>Report To HO not be blank'}" <?php echo $re['yes']; ?> TABINDEX="16" checked  <?php echo $view; ?>><span class="radio_check_holder"></span>Yes
                        </label>

                        <label for="fire_n1" class="radio_check float_left width50">  
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="fire_n1" type="radio" name="gri[gc_reminder_call]" value="no" <?php echo $re['no']; ?> class="radio_check_input" data-errors="{filter_required:'>Report To HO not be blank'}" TABINDEX="17"  <?php echo $view; ?>><span class="radio_check_holder filter_required"></span>No
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="field_row width100">

            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="station_name">Action Taken<span class="md_field">*</span></label></div>

                <div class="filed_input float_left width2">

                    <textarea style="height:60px;" name="gri[gc_action_taken]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Action should not be blank'}" <?php echo $view; ?>><?= @$grievance_data1[0]->gc_action_taken; ?>  </textarea>

                </div>
            </div>
            <div class="width2 float_left">

                <div class="field_lable float_left width33"> <label for="mt_on_remark">Caller satisfaction for closure remark<span class="md_field">*</span></label></div>


                <div class="filed_input float_left width50" >
                    <textarea style="height:60px;" name="gri[gc_caller_closure_remark]" class="filter_required" TABINDEX="16" data-maxlen="1600"  data-errors="{filter_required:'Caller satisfaction for closure remark should not be blank'}"  <?php echo $view; ?>><?= @$grievance_data1[0]->gc_caller_closure_remark; ?></textarea>

                </div>


            </div>
            <?php if ($grievance_data[0]->gc_closure_status == 'complaint_open') { ?>
                <input   type="hidden" name="gri[gc_id]"  value="<?= @$grievance_data[0]->gc_id ?>"  >
            <?php } ?>


            <input name="gri[gc_inc_ref_id]"  type="hidden"  value="<?= @$grievance_data[0]->gc_inc_ref_id; ?>" >

            <?php
            $start_date = date('Y-m-d h:i:s');
            ?>

            <input   type="hidden" name="gri[gc_time_required]"  value="<?= $start_date ?>"  >

            <?php if ($view != 'disabled') { ?>

                <div class="button_field_row  margin_auto float_left width100 text_align_center">
                    <div class="button_box">

                        <input type="button" name="submit" value="Save" class="btn submit_btnt form-xhttp-request mt-0 mb-0" data-href='<?php echo base_url(); ?>Grievance/<?php  if ($grievance_data[0]->gc_closure_status == 'complaint_open') {  ?>grievance_call_update<?php } else { ?>save_call<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>'  TABINDEX="23" >
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset mt-0  TABINDEX="24">        

                    </div>
                </div>

            <?php }
  }
            ?>
            </form>