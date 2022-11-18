<form method="post" name="feedback_list_form" id="feedback_list">  
    <div class="head_outer float_left width100"><h4 class="txt_clr2 width100">Report View</h4> </div>
    <div class="single_record float_left width100"> 
        <div class="single_record_back">
            <div >Caller Information</div>
        </div>
    </div>

    <input   type="hidden" name="feedback[fc_inc_ref_id]"  value="<?= $inc_info[0]->inc_ref_id ?>"   >
    <input   type="hidden" name="feedback[fc_inc_type]"  value="<?= $inc_info[0]->inc_type ?>"   >
    <input   type="hidden" name="feedback[fc_caller_name]" value="<?= $inc_info[0]->clr_fname.' '.$inc_info[0]->clr_mname.' '.$inc_info[0]->clr_lname?>" >
    
    <div class="field_row width100">

        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="caller_number">Caller Number</label></div>

            <div class="filed_input float_left width50">
                <input   type="text" name="feedback[fc_caller_number]"  placholder="Caller Number" value="<?= $inc_info[0]->clr_mobile ?>" TABINDEX="1" <?php echo "disabled"; ?>>  
                <input   type="hidden" name="feedback[fc_caller_number]" value="<?= $inc_info[0]->clr_mobile ?>" >
            </div> 

            <a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?= $inc_info[0]->clr_mobile ?>"></a>
         

        </div>

        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="caller_name">Caller Name</label></div>

            <div class="filed_input float_left width50">

                <input   type="text" name="feedback[fc_caller_name]"  placholder="Caller Name"  value="<?= $inc_info[0]->clr_fname.' '.$inc_info[0]->clr_mname.' '.$inc_info[0]->clr_lname ?>" TABINDEX="2"  disabled="disabled">


            </div>


        </div>
        <?php if ($inc_info[0]->clr_ralation != '') { ?>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="relation">Relation</label></div>

                <div class="filed_input float_left width50">
                <!-- <?php// var_dump( $inc_info[0]->clr_ralation); ?> -->
                    <input   type="text" name="feedback[fc_caller_relation]" placholder="Relation"  value="<?php echo get_relation_by_id($inc_info[0]->clr_ralation); ?>" TABINDEX="3"  disabled="disabled">
                    <input   type="hidden" name="feedback[fc_caller_relation]"  value="<?php echo $inc_info[0]->clr_ralation; ?>" >

                </div>
            </div>
        <?php } ?>
    </div>

    <?php if ($inc_info[0]->ptn_id != '' && $inc_info[0]->pname == 'Test Call') { ?>
        <div class="single_record float_left width100"> 
            <div class="single_record_back">
                <div>Patient Details</div>
            </div>
        </div>
        <div class="field_row width100">
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="patient_name">Patient Name</label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="feedback[fc_ptn_name]"  placholder="Age"  value="<?= $inc_info[0]->ptn_fname; ?>" TABINDEX="4" disabled="disabled" >
                    <input   type="hidden" name="feedback[fc_ptn_name]"    value="<?= $inc_info[0]->ptn_fname; ?>" >
                </div>


            </div>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="age">Age</label></div>

                <div class="filed_input float_left width50">

                    <input   type="text" name="feedback[fc_ptn_age]"  placholder="Age"  value="<?= $inc_info[0]->ptn_age; ?>" TABINDEX="5" disabled="disabled" >
                    <input   type="hidden" name="feedback[fc_ptn_age]"   value="<?= $inc_info[0]->ptn_age; ?>"  >

                </div>


            </div>

            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="gender">Gender</label></div>

                <div class="filed_input float_left width50">
                    <input   type="text" name="feedback[fc_ptn_gender]"  placholder="Gender"  value="<?= $inc_info[0]->ptn_gender; ?>" TABINDEX="6"  disabled="disabled" >
                    <input   type="hidden" name="feedback[fc_ptn_gender]"    value="<?= $inc_info[0]->ptn_gender; ?>" >
                </div>
            </div>
        </div>

    <?php } ?>

    <div class="single_record float_left width100"> 
        <div class="single_record_back">
            <div>Incident Details</div>
        </div>
    </div>

    <div class="field_row width100">
        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="address">Incident Id</label></div>
            
            <div class="filed_input float_left width50">
                <input type="text" name="feedback[fc_inc_ref_id]"  placholder="Address"  value="<?= $inc_info[0]->inc_ref_id ?>" TABINDEX="7"  disabled="disabled">
                <input name="incident_id" class="" value="<?php echo $inc_ref_id; ?>" type="hidden" tabindex="2" placeholder="Incident ID">

            </div>


        </div>
        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="address">Purpose Of Call</label></div>
            
            <div class="filed_input float_left width50">
                <input type="text" name="feedback[fc_cl_purpose]"  placholder="Address"  value="<?= get_parent_purpose_of_call($inc_info[0]->inc_type)?>" TABINDEX="7"  disabled="disabled">
                <input name="cl_purpose" class="" value="<?php echo get_parent_purpose_of_call($inc_info[0]->inc_type); ?>" type="hidden" tabindex="2" placeholder="Incident ID">

            </div>


        </div>
        <?php if ($inc_info[0]->inc_address != '') { ?>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="address">Address</label></div>

                <div class="filed_input float_left width50">
                    <input   type="text" name="feedback[fc_inc_address]"  placholder="Address"  value="<?= $inc_info[0]->inc_address ?>" TABINDEX="7"  disabled="disabled">
                    <input   type="hidden" name="feedback[fc_inc_address]"   value="<?= $inc_info[0]->inc_address ?>" >
                </div>


            </div>
        <?php } ?>

        <?php
       // var_dump($inc_info[0]->inc_complaint);
        if ($inc_info[0]->inc_complaint != '') { ?>
            <div class="width2 float_left">
                <div class="filed_lable float_left width33"><label for="address">Chief Complaint</label></div>

                <div class="filed_input float_left width50">
                    <input   type="text" name="cheif_complaint"  placholder="Address"  value="<?= get_cheif_complaint($inc_info[0]->inc_complaint); ?>" TABINDEX="7"  disabled="disabled">

                </div>


            </div>
        <?php } ?>
        <div class="width2 float_left">   
            <div class=" blue float_left width33">Call type</div>
            <div class="input  top_left float_left width50" >
                <input   type="text" name="feedback[fc_call_type]"  placholder="Address"  value="<?= $inc_info[0]->pname ?>" TABINDEX="8"  disabled="disabled">
                <input   type="hidden" name="feedback[fc_call_type]"    value="<?= $inc_info[0]->pname ?>" >
            </div>
        </div>

        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="date_time">System Type</label></div>

            <div class="filed_input float_left width50">
                <input type="text" name=""   value="<?= $inc_info[0]->inc_system_type ?>"   placeholder="System Type"  disabled="disabled" TABINDEX="9">
            </div>


        </div>
        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="date_time">Dispatch Date & Time</label></div>

            <div class="filed_input float_left width50">
                <input type="text" name="feedback[fc_dispatch_date_time]"   value="<?= $inc_info[0]->inc_datetime ?>"   placeholder="Date & Time"  disabled="disabled" TABINDEX="9">
                <input type="hidden" name="feedback[fc_dispatch_date_time]"   value="<?= $inc_info[0]->inc_datetime ?>"  >
            </div>


        </div>
    </div>
    <!--incident details -->
    <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar " id="open_greet_ques_outer">
                <div class="width100 float_left">
                    <div class="quality_arrow_back" style=" font-weight: bold;">Incident Details</div>
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
                            ?> &nbsp; [ <?php echo ucwords($inc_details[0]->cl_name); ?> ] <?php } ?> </td>

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
                        
                             
                            $pic_path = $inc_details[0]->inc_audio_file;
                            //$inc_datetime = date("Y-m-d", strtotime($inc_details[0]->inc_datetime));
                            //$pic_path =   get_inc_recording($inc_details[0]->inc_avaya_uniqueid,$inc_datetime);
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
                            <td colspan="1"> <?php
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

                <?php if ($enq_que[0]['que'] != '' && ($inc_details[0]->inc_type=='ENQ_CALL')) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Enquiry Question & Answer </td>
                    </tr>
                <?php } ?>

                <?php
                if ($enq_que) {
                    foreach ($enq_que as $enq_que) {
                        ?>
                        <tr><td colspan="2" class="strong"><?php echo $enq_que['que']; ?>
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
                                        echo "Passed Away";
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
                    <td><?php echo $inc_details[0]->clr_fname; ?> <?php echo $inc_details[0]->clr_lname; ?></td>
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
                                                //var_dump($epcr_inc_details);
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
                                                                if ($epcr->rec_hospital_name == 'Other' || $epcr->rec_hospital_name == '0') {
                                                                    
                                                                    echo $epcr->other_receiving_host;
                                                                } else {
                                                                    echo $epcr->hp_name;
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
                                                 if ($er_inc_details) {
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
                                                } }
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
    <!--incident details -->
    <?php 
    foreach ($epcr_inc_details as $epcr) {
        if ($epcr->epcr_call_type == '1' ) {
            $Pt_available = 'Not-Available';
        }else{
            $Pt_available = 'Available';
        }
    }      
        
    if($clg_user_group!='UG-FeedbackManager'){
        if($Pt_available == 'Available'){
    ?>
    <div class="width97 form_field  ">
           <div class="single_record float_left width100"> 
        <div class="single_record_back">
            <div>Questions <span class="md_field">*</span></div>
        </div>
    </div>
        <!--<div class="label blue">Questions <span class="md_field">*</span></div>-->
        <?php
        if ($ques) {
            foreach ($ques as $key => $question) {
                ?>
                <div class="width97 questions_row feedback_question">
                    <div class="width33 float_left"><?php echo $question->que_question;?></div>
                    
                    <?php if ($question->que_id == 191) { ?>
                        <div class="width_60 float_right hide1">
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_dis" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_dis" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_dis,ques_<?php echo $question->que_id ?>_tret,ques_<?php echo $question->que_id ?>_dead]" value="discharge" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>  Discharge/ Recovered
                                </label>
                            </div>
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_tret" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_tret" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_dis,ques_<?php echo $question->que_id ?>_tret,ques_<?php echo $question->que_id ?>_dead]" value="treatment_inprogress" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="17" autocomplete="off">
                                    <span class="radio_check_holder"></span>Treatment Inprogress
                                </label>
                            </div>
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_dead" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_dead" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class="radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_dis,ques_<?php echo $question->que_id ?>_tret,ques_<?php echo $question->que_id ?>_dead]" value="dead" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="17" autocomplete="off">
                                    <span class="radio_check_holder"></span>Passed Away
                                </label>
                            </div></div>
                        
                    <?php } ?>
                    <?php if ($question->que_id == 193) { ?>
                        <div class="width_60 float_right hide2">
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_tl" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_tl" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot]" value="television" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Television
                                </label> 

                            </div>
                            <div class="width33 float_left">

                                <label for="ques_<?php echo $question->que_id ?>_ne" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_ne" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot]" value="news" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>News
                                </label> 


                            </div>
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_fr" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_fr" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot]" value="friends" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Friends
                                </label> 



                            </div><div class="width33 float_left">

                                <label for="ques_<?php echo $question->que_id ?>_de" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_de" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot]" value="demotration" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Demonstration
                                </label> 


                            </div><div class="width33 float_left">

                                <label for="ques_<?php echo $question->que_id ?>_ad" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_ad" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot]" value="advertisment" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Advertisement
                                </label> 


                            </div><div class="width33 float_left">

                                <label for="ques_<?php echo $question->que_id ?>_ot" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_ot" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_tl,ques_<?php echo $question->que_id ?>_ne,ques_<?php echo $question->que_id ?>_fr,ques_<?php echo $question->que_id ?>_de,ques_<?php echo $question->que_id ?>_ad,ques_<?php echo $question->que_id ?>_ot]" value="other" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Other
                                </label> 


                            </div>
                        </div>
                    <?php } ?>
                   
                    <?php if ($question->que_id == 192) { ?>
                        <div class="width_60 float_right hide3">
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_ex" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_ex" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_ex,ques_<?php echo $question->que_id ?>_gd,ques_<?php echo $question->que_id ?>_av]" value="excellent" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Excellent
                                </label> 
                            </div>
                            <div class="width33 float_left">

                                <label for="ques_<?php echo $question->que_id ?>_gd" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_gd" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_ex,ques_<?php echo $question->que_id ?>_gd,ques_<?php echo $question->que_id ?>_av]" value="good" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Good
                                </label>

                            </div>
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_av" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_av" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_ex,ques_<?php echo $question->que_id ?>_gd,ques_<?php echo $question->que_id ?>_av]" value="average" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>Average
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                    
                     <?php if ($question->que_id == 190) { ?>
                        <div class="width_60 float_right">
                            <div class="width33 float_left">
                                <label for="ques_<?php echo $question->que_id ?>_yes" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_yes" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_yes,ques_<?php echo $question->que_id ?>_no]" value="yes" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>  Yes
                                </label>
                            </div>
                            <div class="width33 float_left">   
                                <label for="ques_<?php echo $question->que_id ?>_no" class="radio_check width100 float_left">
                                    <input id="ques_<?php echo $question->que_id ?>_no" type="radio" name="feedback[ques][<?php echo $question->que_id ?>]" class=" radio_check_input filter_either_or[ques_<?php echo $question->que_id ?>_yes,ques_<?php echo $question->que_id ?>_no]" value="no" data-errors="{filter_either_or:'Answer is required'}" data-base="ques_btn" tabindex="16" autocomplete="off">
                                    <span class="radio_check_holder"></span>  No
                                </label>

                            </div>

                        </div>
                        
                    <?php } ?>

                    
                </div>
                <?php
            }
        }
        ?>

    </div>
    
    <div class="single_record float_left width100"> 
        <div class="single_record_back">
            <div>Feedback Details</div>
        </div>
    </div>
    <div class="field_row width100">
        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="feedback_type">Feedback Type <span class="md_field">*</span></label></div>

            <div class="filed_input float_left width50">

                <select name="feedback[fc_feedback_type]" tabindex="10"  id="feedback_type" class="filter_required" data-errors="{filter_required:'Feedback type  should not be blank!'}"  <?php echo $update; ?> > 
                    <option value="" <?php echo $disabled; ?>>Select Feedback Type</option>
                    <option value="negative_feedback"  <?php
                    if (@$demo_data[0]->fc_feedback_type == 'negative_feedback') {
                        echo "selected";
                    }
                    ?>   >Feedback For Improvement</option>
                    <option value="positive_feedback"  <?php
                    if (@$demo_data[0]->fc_feedback_type == 'positive_feedback') {
                        echo "selected";
                    }
                    ?>   >Positive Feedback</option>


                </select>

            </div>


        </div>
        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="station_name">Standard Remark<span class="md_field">*</span></label></div>

            <div class="filed_input float_left width60" id="feedback_standard_remark">

<!--                <input type="text" name="feedback[fc_standard_type]"  data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required "  data-href="{base_url}auto/get_feedback_standard_remark" data-errors="{filter_required:'Standard Remark  should not be blank!'}"  placeholder="Standard Remark" TABINDEX="11" <?php echo $autofocus; ?>>-->
                
                <select name="feedback[fc_standard_type][]" tabindex="10"  class="filter_required" data-errors="{filter_required:'Standard Remark  should not be blank!'}"  <?php echo $update; ?> multiple="multiple" style="height: 180px !important;"> 
                    <option value="" <?php echo $disabled; ?>>Standard Remark</option>
                    
                    <?php foreach($feed_stand_remark as $feed){ //var_dump($feed);?>
                        
                    <option value="<?php echo $feed->fdsr_id ;?>"  <?php
                    if ($feed->fdsr_id == @$demo_data[0]->fc_standard_type) {
                        echo "selected";
                    }
                    ?>><?php echo $feed->fdsr_type ;?></option>
                    
                    <?php } ?>


                </select>
                

            </div>


        </div>
    </div>
    <div class="width100">
        <div class="width2 float_left">
            <div class="filed_lable float_left width33"><label for="station_name">Employee Remark</label></div>

            <div class="filed_input float_left width50">

                <input   type="text" name="feedback[fc_employee_remark]"  placholder="Employee Remark"  value="<?= @$inc_amb[0]->amb_emt_id ?>" TABINDEX="12"  <?php
                echo $view;
                if (@$update) {
                    echo"disabled";
                }
                ?> >
            </div>
        </div>
    </div>
    <?php } } ?>
</div>

<?php 
if($clg_user_group!='UG-FeedbackManager'){ 
    if($Pt_available == 'Available'){ ?>
<div class="button_field_row  margin_auto float_left width100 text_align_center">
   
    <div class="float_left width100" id="feed_sub_btn">
        
        <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request width20 " data-href="{base_url}feedback/save_feedback" data-qr="" type="button" tabindex="16">
    
    </div>
    <div class="float_left width100" id="feedback_button" style="display:none;" >

        <input name="fwd_all" value="FORWARD TO GRIEVANCE" class="style5 form-xhttp-request width20 " data-href="{base_url}feedback/save_feedback" data-qr="forword=yes" type="button" tabindex="8">


    </div>
</div> <?php } }?>
</form>

<script>
      $('#ques_190_no').click(function(){
 $('.hide1').hide();
 $('.hide2').hide();
 $('.hide3').hide();
 $('input').removeClass('has_error');
 $('input').removeClass('filter_either_or[ques_191_dis,ques_191_tret,ques_191_dead]');
 $('input').removeClass('filter_either_or[ques_192_ex,ques_192_gd,ques_192_av]');
 $('input').removeClass('filter_either_or[ques_193_tl,ques_193_ne,ques_193_fr,ques_193_de,ques_193_ad,ques_193_ot]');
   });
   $('#ques_190_yes').click(function(){
 $('.hide1').show();
 $('.hide2').show();
 $('.hide3').show();
//  $('input').addClass('has_error');
 $('input').addClass('filter_either_or[ques_191_dis,ques_191_tret,ques_191_dead]');
 $('input').addClass('filter_either_or[ques_192_ex,ques_192_gd,ques_192_av]');
 $('input').addClass('filter_either_or[ques_193_tl,ques_193_ne,ques_193_fr,ques_193_de,ques_193_ad,ques_193_ot]');
   });
</script>