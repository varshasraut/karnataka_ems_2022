<div class="width100 single_record">

    <div id="list_table">

        <table class="table report_table">

            <tr class="single_record_back">                                     
                <td colspan="6">Incident Call Type</td>
            </tr>
            <tr>
                <td class="width_16 strong">Call Type </td>
                <td colspan="5" ><?php echo ucwords($pname); ?></td>
            </tr>
            <tr class="single_record_back">                                     
                <td colspan="6">Incident Information</td>
            </tr>
            <tr>
                <td class="width_16 strong">Incident Id</td>
                <td class="width_16"><?php echo $inc_ref_no; ?></td>
                <td class="width_16 strong">Date & Time</td>
                <td><?php echo date('d-m-Y h:m:s', strtotime($inc_details[0]->inc_datetime)); ?></td> 
                <td class="width_16 strong">Call Duration</td>
                <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>
            </tr>
            <tr>
                <?php if ($chief_complete_name != '') { ?> 
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
            <tr>
                <td class="width_16 strong">Patient Count</td>
                <td> <?php echo $inc_details[0]->inc_patient_cnt; ?></td>
                <?php if ($inc_details[0]->pre_inc_ref_id != '') { ?>
                    <td class="width_16 strong">Previous Incident Id</td>
                    <td class="width_16"><?php echo $inc_details[0]->pre_inc_ref_id; ?></td>
                <?php } ?>
                <?php if ($ambt_name != '') { ?>
                    <td class="width_16 strong">Suggested Ambulance type</td>
                    <td><?php echo $ambt_name; ?></td>
                <?php } ?>
            </tr>
            <?php if ($questions) { ?>    <tr > <td colspan="6" class="strong">Question & Answer</td></tr> <?php } ?>

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

            <?php 
            if ($enq_que[0][que] != '') { ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Enquiry Question & Answer </td>
                </tr>
            <?php } ?>

            <?php
            if ($enq_que) {
                foreach ($enq_que as $enq_que) {
                    ?>
                    <tr><td colspan="3" class="strong"><?php echo $enq_que[que]; ?>
                        </td>
                        <td colspan="3"> <?php
                            echo $enq_que[ans];
                            ?><td>
                    </tr>
                    <?php
                }
            }
            ?>


            <?php if ($facility_details) { ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Facility Details</td>
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
            <tr class="single_record_back">                                     
                <td colspan="6">Incident Address</td>
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
                <td class="width_16 strong">City / Villege</td>
                <td><?php echo $city_name; ?></td>
                <td class="width_16 strong">Locality</td>
                <td></td>
            </tr>

            <tr>
                <td class="width_16 strong">Lane / Street</td>
                <td><?php echo $inc_details[0]->inc_lane; ?></td>
                <td class="width_16 strong">house No</td>
                <td><?php echo $inc_details[0]->inc_h_no; ?></td>
                <td class="width_16 strong">landmark</td>
                <td><?php echo $inc_details[0]->inc_landmark; ?></td>
            </tr>




            <tr class="single_record_back">                                     
                <td colspan="6">Caller Deails</td>
            </tr>
            <tr>
                <td class="width_16 strong">Caller No</td>
                <td><?php echo $inc_details[0]->clr_mobile; ?></td>
                <td class="width_16 strong">Caller Name</td>
                <td><?php echo $inc_details[0]->clr_fname; ?> <?php echo $inc_details[0]->clr_lname; ?></td>
                <td class="width_16 strong">Caller Relation</td>
                <td><?php echo $inc_details[0]->cl_relation; ?></td>
            </tr>

            <tr class="single_record_back">                                     
                <td colspan="6">ERC Information</td>
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


                <td class="width_16 strong" >Call Duration</td>
                <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>
                <td class="width_16 strong">ERO Standard Remark </td>
                <td><?php echo $re_name; ?></td>
                <td class="width_16 strong" >ERO Reamrk</td>
                <td><?php echo $inc_details[0]->inc_ero_summary; ?></td>

            </tr>



            <tr class="single_record_back">                                     
                <td colspan="6">Ambulance Information</td>
            </tr>
            <tr>
                <td class="width_16 strong">Base location Name</td>
                <td colspan="4"><?php echo $hp_name; ?></td>
            </tr><tr>
                <td class="width_16 strong">Ambulance Name</td>
                <td><?php echo $amb_data[0]->amb_rto_register_no; ?></td>
                <td class="width_16 strong">Ambulance Status</td>
                <td><?php echo $amb_data[0]->amb_status; ?></td>
                <td class="width_16 strong">Mobile No </td>
                <td colspan="5"><?php echo $amb_default_mobile; ?></td>
            </tr>
            <tr>

                <td class="width_16 strong">EMT Name</td>
                <td><?php echo $amb_data[0]->amb_emt_id; ?></td>
                <td class="width_16 strong">Pilot Name</td>
                <td colspan="3"><?php echo $amb_data[0]->amb_pilot_id; ?></td>
            </tr>

            <?php if ($inc_details[0]->inc_patient_cnt) { ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Patient Information</td>
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
                            <td><a class="btn expand_button expand_btn ptn_view" data-target="<?php echo "cl" . $ptn->ptn_id; ?>" >VIEW</a>
                            </td>
                        </tr>
                        <tr id="<?php echo "cl" . $ptn->ptn_id; ?>"  style="width:100%; position: relative; display:none;padding-left:20px;" class="expand_pan">

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
                                                        <li class="float_left width_25"><?php echo $epcr->hp_name; ?></li>
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