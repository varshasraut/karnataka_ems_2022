
<h2 class="txt_clr2 width1 txt_pro">Cross Audit</h2>
    <div class="width100 single_record">

        <div id="list_table">

            <table class="table report_table">

                <tr class="single_record_back">                                     
                    <td colspan="6">Incident Call Type</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Call Type </td>
                    <td colspan="5" ><?php
                        echo ucwords($pname);
                        if ($inc_details[0]->cl_name != '') {
                            ?> &nbsp; [ <?php echo $inc_details[0]->cl_name; ?> ] <?php } ?> </td>
                </tr>
                <tr class="single_record_back">                                     
                    <td colspan="6">Incident Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Incident Id</td>
                    <td class="width_16"><?php echo $inc_ref_no; ?></td>
                    <td class="width_16 strong">Date & Time</td>
                    <td><?php echo $inc_details[0]->inc_datetime; ?></td> 
                    <td class="width_16 strong">Call Duration</td>
                    <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>
                    
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
                <tr>
                        <td class="width_16 strong">Incident Recording </td>
                        <?php  
                        if($inc_details[0]->inc_avaya_uniqueid != ''){
                            $inc_datetime = date("Y-m-d", strtotime($inc_details[0]->inc_datetime));
                            $pic_path =   get_inc_recording($inc_details[0]->inc_avaya_uniqueid,$inc_datetime); ?>
                         <td colspan="5">
                            <audio controls controlsList="nodownload">
                              <source src="<?php echo $pic_path;?>" type="audio/wav">
                            Your browser does not support the audio element.
                            </audio> 
                        </td>
                        
                        <?php
                        }
                        
                        ?>
                        
                       


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
                if ($enq_que[0]['que'] != '' && ($inc_details[0]->inc_type == 'ENQ_CALL')){ ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6">Enquiry Question & Answer </td>
                    </tr>
                <?php } ?>

                <?php
               
                if ($enq_que[0]['que'] != '' && ($inc_details[0]->inc_type == 'ENQ_CALL')){  
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

                <?php if ($feed_questions) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6">Feedback Details</td>
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
                        <td><?php echo date('d-m-Y h:m:s', strtotime($feedback_details[0]->fc_added_date)); ?></td>
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
    

                <tr class="single_record_back">                                     
                    <td colspan="6">Caller Details</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Caller No</td>
                    <td><?php echo $inc_details[0]->clr_mobile; ?></td>
                    <td class="width_16 strong">Caller Name</td>
                    <td><?php echo $inc_details[0]->clr_fname; ?> <?php echo $inc_details[0]->clr_lname; ?></td>
                    <td class="width_16 strong">Caller Relation</td>
                    <td><?php echo $inc_details[0]->rel_name; ?></td>
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


    <!--                <td class="width_16 strong" >Call Duration</td>
                    <td><?php echo $inc_details[0]->inc_dispatch_time; ?></td>-->
                    <td class="width_16 strong">ERO Standard Remark </td>
                    <td class="width_30"><?php echo $re_name; ?></td>
                    <td class="width_16 strong" >ERO Remark</td>
                    <td colspan="3"><?php echo $inc_details[0]->inc_ero_summary; ?></td>

                </tr>
                <tr class="single_record_back">                                     
                    <td colspan="6">Ambulance Information</td>
                </tr>
                <?php
                if($amb_data){
                foreach ($amb_data as $amb_data) {
                    if ($amb_data->amb_rto_register_no != '') {
                        ?>



                        <tr>
                            <td class="width_16 strong">Base location Name</td>
                            <td colspan="4"><?php echo get_amb_hp($amb_data->amb_rto_register_no); ?></td>
                        </tr>
                        <tr>
                            <td class="width_16 strong">Ambulance Name</td>
                            <td><?php echo $amb_data->amb_rto_register_no; ?></td>
                            <td class="width_16 strong">Ambulance Status</td>
                            <td><?php echo $amb_data->amb_status; ?></td>
                            <td class="width_16 strong">Mobile No </td>
                            <td colspan="5"><?php echo get_amb_mob($amb_data->amb_rto_register_no); ?></td>
                        </tr>
                        <tr>

                            <!-- <td class="width_16 strong">EMT Name</td>
                            <td><?php echo $amb_data->amb_emt_id; ?></td> -->
                            <td class="width_16 strong">Pilot Name</td>
                            <td colspan="3"><?php echo $amb_data->amb_pilot_id; ?></td>
                        </tr>
                        <?php
                    }
                }
                }
                ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Audit Information</td>
                </tr>
                <tr class="single_record_back">                                     
                    <td colspan="6">Varification Matrix </td>
                </tr>
                <?php 
                $ver_mat_val = json_decode($quality_audit_data[0]->ver_mat,true);
                if($ero_ver_mat){
                foreach($ero_ver_mat as $ver_mat){?>
                
                    <tr>
                        <td colspan="4"><?php echo $ver_mat->qa_ques; ?></td>
                        <td colspan="2"><?php //if($ver_mat_val[$ver_mat->qa_ques_id] == 'Y'){ echo "Yes";}else{ echo "No"; } 
                        echo $quality_audit_data[0]->ver_matrix_marks;?></td>
                    </tr>
                <?php }  ?>
                    
                <tr class="single_record_back">                                     
                    <td colspan="6">Opening Greeting</td>
                </tr>
                <?php 
                $open_greet_val = json_decode($quality_audit_data[0]->open_greet_chk,true);
                if($ero_open_greet){
                foreach($ero_open_greet as $open_greet){ ?>
                
                    <tr>
                        <td colspan="4"><?php echo $open_greet->qa_ques; ?></td>
                        <td colspan="2"><?php //if($open_greet_val[$open_greet->qa_ques_id] == 'Y'){ echo "Yes";}else{ echo "No"; }
                        echo $quality_audit_data[0]->open_greet_marks;?></td>
                    </tr>
                <?php } } ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Complete call & system flow</td>
                </tr>
                <?php 
                $comp_systm_val = json_decode($quality_audit_data[0]->comp_systm_chk ,true);
                
                if($ero_comp_systm){
                foreach($ero_comp_systm as $comp_systm){ ?>
                
                    <tr>
                        <td colspan="4"><?php echo $comp_systm->qa_ques; ?></td>
<!--                        <td colspan="2"><?php echo $comp_systm_val[$comp_systm->qa_ques_id];?></td>-->
                        <td colspan="2"><?php //if($quality_audit_data[$comp_systm->qa_ques_id] == 'Y'){ echo "Yes";}else if($quality_audit_data[$comp_systm->qa_ques_id] == 'N'){ echo "No"; }else { echo "-";}
                        echo $quality_audit_data[0]->comp_systm_marks;?></td>
                    </tr>
                <?php } } ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Notification</td>
                </tr>
                <?php 
                $notification_val = json_decode($quality_audit_data[0]->notification_chk,true);
                if($ero_notification){
                foreach($ero_notification as $notification){ ?>
                
                    <tr>
                        <td colspan="4"><?php echo $notification->qa_ques; ?></td>
<!--                        <td colspan="2"><?php echo $notification_val[$notification->qa_ques_id];?></td>-->
                        <td colspan="2"><?php //if($notification_val[$notification->qa_ques_id] == 'Y'){ echo "Yes";}else if($notification_val[$notification->qa_ques_id] == 'N'){ echo "No"; }else { echo "-";}
                        echo $quality_audit_data[0]->notification_marks;?></td>
                    </tr>
                <?php } } ?>
                <tr class="single_record_back">                                     
                    <td colspan="6">Hold procedure</td>
                </tr>
                <?php 
                $hold_procedure_val = json_decode($quality_audit_data[0]->hold_procedure_chk,true);
                if($ero_hold_procedure){
                foreach($ero_hold_procedure as $hold_procedure){ ?>
                
                    <tr>
                        <td colspan="4"><?php echo $hold_procedure->qa_ques; ?></td>
<!--                        <td colspan="2"><?php //echo $hold_procedure_val[$hold_procedure->qa_ques_id];?></td>-->
                         <td colspan="2"><?php //if($hold_procedure_val[$hold_procedure->qa_ques_id] == 'Y'){ echo "Yes";}else if($hold_procedure_val[$hold_procedure->qa_ques_id] == 'N'){ echo "No"; }else { echo "-";}
                         echo $quality_audit_data[0]->hold_procedure_marks;?></td>
                    </tr>
                <?php } } ?>   
                    
                <tr class="single_record_back">                                     
                    <td colspan="6">Communication Skill</td>
                </tr>
                <?php 
                $commu_skill_val = json_decode($quality_audit_data[0]->commu_skill_chk ,true);
                if($ero_commu_skill){
                foreach($ero_commu_skill as $commu_skill){ ?>
                    <tr>
                        <td colspan="4"><?php echo $commu_skill->qa_ques; ?></td>
<!--                        <td colspan="2"><?php echo $commu_skill_val[$commu_skill->qa_ques_id]; ?></td>-->
                        <td colspan="2"><?php //if($commu_skill_val[$commu_skill->qa_ques_id] == 'Y'){ echo "Yes";}else if($commu_skill_val[$commu_skill->qa_ques_id] == 'N'){ echo "No"; }else { echo "-";}
                        echo $quality_audit_data[0]->commu_skill_marks;?></td>
                    </tr>
                <?php } } ?>
                    
                <tr class="single_record_back">                                     
                    <td colspan="6">Closing Greeting</td>
                </tr>
                <?php 
                $closing_greet_val = json_decode($quality_audit_data[0]->closing_greet_chk,true);
                if($ero_closing_greet){
                foreach($ero_closing_greet as $closing_greet){ ?>
                    <tr>
                        <td colspan="4"><?php echo $closing_greet->qa_ques; ?></td>
<!--                        <td colspan="2"><?php echo $closing_greet_val[$closing_greet->qa_ques_id];?></td>-->
                         <td colspan="2"><?php //if($closing_greet_val[$closing_greet->qa_ques_id] == 'Y'){ echo "Yes";}else if($closing_greet_val[$closing_greet->qa_ques_id] == 'N'){ echo "No"; }else { echo "-";}
                         echo $quality_audit_data[0]->closing_greet_marks;?></td>
                    </tr>
                <?php } 
                
                 } ?>
                    
                  <tr class="single_record_back">                                     
                    <td colspan="6">Fatal Indicator</td>
                </tr>
                <?php 
                $fetal_indicator_val = json_decode($quality_audit_data[0]->fetal_indicator_chk,true);
                if($ero_fetal_indicator){
                foreach($ero_fetal_indicator as $fetal_indicator){ ?>
                    <tr>
                        <td colspan="4"><?php echo $fetal_indicator->qa_ques; ?></td>
<!--                        <td colspan="2"><?php echo $ver_mat_val[$fetal_indicator_val->qa_ques_id];?></td>-->
                        
                        <td colspan="2"><?php if($ver_mat_val[$fetal_indicator_val->qa_ques_id] == 'Y'){ echo "Yes";}else if($ver_mat_val[$fetal_indicator_val->qa_ques_id] == 'N'){ echo "No"; }else { echo "-";}
                        ?></td>
                    </tr>
                <?php } 
                } ?>
                    
                <tr class="single_record_back">                                     
                    <td colspan="6">Audit Information</td>
                </tr>
                <tr>
                    <td class="width_30 strong">Fatal Error Indicator</td>
                    <td class="width_5"><?php if($quality_audit_data[0]->fetal_error_indicator != NULL){echo $quality_audit_data[0]->fetal_error_indicator;}else{echo "NA";} ?></td>
                    <td class="width_16 strong">Call Observation</td>
                    <td colspan="3" class="width70"><?php if($quality_audit_data[0]->call_observation != NULL){echo $quality_audit_data[0]->call_observation;}else{echo "NA";} ?></td>
                    
                </tr>
                <tr>
                    <td class="width_16 strong">Quality Score</td>
                    <td class="width_5"><?php echo $quality_audit_data[0]->quality_score; ?></td>
                    <td class="width_16 strong">Performer Group</td>
                    <td class="width70"><?php echo $quality_audit_data[0]->performer_group; ?></td>
                    
                </tr>
                <tr>
                    <td class="width_16 strong">Audit Method</td>
                    <td class="width_5"><?php echo $quality_audit_data[0]->audit_method; ?></td>
                    <td class="width_16 strong">Quality Remark</td>
                    <td colspan="3" class="width70"><?php echo $quality_audit_data[0]->quality_remark; ?></td>
                    
                </tr>
                <tr>
                <td class="width_16 strong">TNA</td>
                    <td class="width_5"><?php echo ucwords($quality_audit_data[0]->tna); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>

    </div>
<?php
}if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>
<div class="call_purpose_form_outer">

    <div class="width100">


        <div class="incident_details">

            <form enctype="multipart/form-data" action="#" method="post" id="add_inc_details">

                <div class="width100 float_left">
                    <div class="width100 form_field outer_smry">
                        <div class="width10 label blue float_left">Remark<span class="md_field">*</span>&nbsp;</div>
                        <div class="width50 float_left">
                           <input name="cross[cr_remark]" class="" value="<?php echo $audit_data[0]->cr_remark;?>"  type="text" tabindex="2" placeholder="Remark">
                            <input name="cross[cr_audit_id]" value="<?php echo $audit_id ;?>" type="hidden">
                            <input name="cross[inc_ref_id]" value="<?php echo $inc_ref_no;?>" type="hidden">
                            <input name="cross[cr_id]" value="<?php echo $audit_data[0]->cr_id;?>" type="hidden">
                            
                        </div>

                        
                    </div>
                </div>
                
            <?php if (!@$view_clg) { ?>
                
                    <div class="button_field_row width2 margin_auto">
                        <div class="button_box">
                            <input type="button" name="submit" value="<?php if ($audit_data) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url();?>quality_forms/<?php if ($audit_data) { ?>update_quality_remark<?php } else { ?>save_quality_remark<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=quality' TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">              
                            <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
                        </div>
                    </div>
            <?php } ?>
            </form>
        </div>
    </div>
</div>