<?php
if (@$type == 'edit') {
    $view = 'readonly';
}
?>
<div class="call_purpose_form_outer" style="position: relative; top:0px; bottom: 0px;">

    <div class="width100">

        <h2 class="txt_clr2 width1 txt_pro">Quality Audit Form</h2>

  
<div class="incident_details" style="margin-top:10px;">

            <form action="#" method="post" id="add_inc_details">
                
            

                <div class="width100 float_left">
                    <div class="width100 form_field outer_smry">

                        <div class="width2 float_left">         
                            <div class="width30 label blue float_left">ERO Name&nbsp;</div>
                            <div class="width70 float_left">
                                <?php $ero_name = get_clg_data_by_ref_id($inc_call_type[0]->inc_added_by); ?>
                                <input name="audit[ero_name]" class="" value="<?php echo $ero_name[0]->clg_first_name . ' ' . $ero_name[0]->clg_mid_name . ' ' . $ero_name[0]->clg_last_name; ?>"  type="text" tabindex="2" placeholder="ERO Name" disabled>
                            </div>
                        </div>

                        <div class="width2 float_left">
                            <div class="label blue float_left width30">Incident ID</div>

                            <div class="width2 float_left width70" >
                                <input name="audit[incident_id]" class="" value="<?php echo $inc_ref_id; ?>" type="text" tabindex="2" placeholder="Incident ID" disabled>
                                <input name="incident_id" class="" value="<?php echo $inc_ref_id; ?>" type="hidden" tabindex="2" placeholder="Incident ID">
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="width100 form_field outer_smry">

                        <div class="width2 float_left">         
                            <div class="width30 label blue float_left">Incident Date Time&nbsp;</div>
                            <div class="width70 float_left">
                                <input name="audit[inc_datetime]" class="" value="<?php echo $inc_call_type[0]->inc_datetime; ?>" type="text" tabindex="2" placeholder="Incident Date Time" disabled>
                                <input name="inc_datetime" class="" value="<?php echo $inc_call_type[0]->inc_datetime; ?>" type="hidden" tabindex="2" placeholder="Incident Date Time" >
                            </div>
                        </div>

                        <div class="width2 float_left">
                            <div class="label blue float_left width30">Caller No</div>

                            <div class="width2 float_left width70" >
                                <input name="audit[caller_no]" class="" value="<?php echo $inc_details[0]->clr_mobile; ?>" type="text" tabindex="2" placeholder="Caller No" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="width100 form_field outer_smry">
                         <div class="width2 float_left">
                            <div class="label blue float_left width30">Purpose Call</div>
                            <?php
                           // var_dump($inc_call_type[0]->inc_type);
                            if(!empty($inc_call_type[0]->inc_type)){
                                $purpose = get_parent_purpose_of_call( $inc_call_type[0]->inc_type);
                            }
                            // var_dump($purpose);
                            ?>

                            <div class="width2 float_left width70" >
                                <input name="audit[purpose_call]" class="" value="<?php  echo $purpose; ?>" type="text" tabindex="2" placeholder="Purpose Call" disabled>
                            </div>
                        </div>

                        <div class="width2 float_left">         
                            <div class="width30 label blue float_left">Call Type&nbsp;</div>
                            <div class="width70 float_left">
                                 <?php
                                 //var_dump($inc_call_type[0]->inc_type);
                            if(!empty($inc_call_type[0]->inc_type)){
                                $inc_type = ucwords(get_purpose_of_call( $inc_call_type[0]->inc_type));
                            }
                            // var_dump($inc_type);
                            ?>
                                <input name="audit[inc_calltype]" class="" value="<?php echo $inc_type;?>" type="text" tabindex="2" placeholder="Call Type" disabled>
                            </div>
                        </div>

                     
                    </div>
                    <div class="width100 form_field outer_smry">
                           <div class="width2 float_left">
                            <div class="label blue float_left width30">Chief Complaint</div>

                            <div class="width2 float_left width70" >
                                <input name="audit[caller_no]" class="" value="<?php echo $chief_complete_name; ?>" type="text" tabindex="2" placeholder="Chief Complaint" disabled>
                            </div>
                        </div>

                        <div class="width2 float_left">         
                            <div class="width30 label blue float_left">ERO Summary&nbsp;</div>
                            <div class="width70 float_left">
                                <textarea name="audit[inc_datetime]" class="" value="" type="text" tabindex="2" placeholder="ERO Summary" disabled><?php if($inc_details[0]->re_name==''){ echo $inc_details[0]->$inc_ero_standard_summary; }else{ echo $inc_details[0]->re_name; } ?></textarea>
                            </div>
                        </div>

                        
                    </div>
                 <div class="width100 form_field outer_smry">
                    <div class="width2 float_left">  
                             <div class="width100 float_left"> 
                            <div class="width30 label blue float_left">Incident Recording</div>
                            <div class="width70 float_left">
							<?php  
                           
                           
                            $inc_datetime = date("Y-m-d", strtotime($inc_details[0]->inc_datetime));
							$pic_path =  get_inc_recording($inc_details[0]->inc_avaya_uniqueid);
                            
      
                            if($pic_path != ''){  
							?>
								
								<audio controls controlsList="nodownload">
                                  <source src="<?php echo $pic_path;?>" type="audio/wav">
                                Your browser does not support the audio element.
                                </audio> 
								
								<?php
                            }

                            ?>
                                
                            </div>

                            </div>
                       
                        </div>
                      <div class="width2 float_left">
                            <div class="label blue float_left width30">ERO Note</div>

                            <div class="width2 float_left width70" >
                                <textarea name="audit[caller_no]" class="" value="" type="text" tabindex="2" placeholder="Summary" disabled><?php echo $inc_details[0]->inc_ero_summary; ?></textarea>
                            </div>
                        </div>
                       
                 </div>
                        <input name="ref_id" class="" value="<?php echo $ero_id; ?>" type="hidden" tabindex="2" placeholder="Feedback Remark" >
                        <!--                        <div  class="width2 float_left text_align_center">
                        
                                                    <a data-href='<?php echo base_url(); ?>quality_forms/save_ero_notice' class="click-xhttp-request style1" data-qr='ref_id=<?php echo $ero_id; ?>' >( Invite To ERO )</a>
                        
                        
                                                </div>-->

                    
                <div class="width100 float_left open_greet_quality">
            <div class="width100 float_left blue_bar " id="open_greet_ques_outer">
                <div class="width100 float_left">
                    <div class="quality_arrow_back" style="color:#fff; font-weight: bold;">Incident Details</div>
                </div>
            </div>
            <div class="checkbox_div hide">
                <div class="width100  float_left">
                    <table class="table report_table">

                <tr class="single_record_back">                                     
                    <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Incident Call Type</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Call Type </td>
                    <td><?php echo $inc_details[0]->pname; ?><?php
                        /*echo ucwords($pname[0]->pname);
                        if ($inc_details[0]->cl_name != '') {
                            ?> &nbsp; [ <?php echo $inc_details[0]->cl_name; ?> ] <?php } ?> </td>

                    <?php if ($inc_details[0]->incis_deleted == '2') { ?>
                        <td class="width_16 strong">Status</td>
                        <td class="width_16">Duplicate Event Terminate Call</td>
                    <?php } */ ?>
                </tr>
                <tr class="single_record_back">                                     
                    <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Incident Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Incident Id</td>
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
                        
                             
                            $pic_path =  $inc_details[0]->inc_audio_file;
                           // $inc_datetime = date("Y-m-d", strtotime($inc_details[0]->inc_datetime));
                           // $pic_path =   get_inc_recording($inc_details[0]->inc_avaya_uniqueid,$inc_datetime);
                            if($pic_path != ''){
                            ?>
                            
                            <audio controls controlsList="nodownload">
                              <source src="<?php echo $inc_details[0]->inc_audio_file;?>" type="audio/wav">
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
               // var_dump($questions);
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
                if ($enq_que[0]['que'] != '' && ($inc_details[0]->inc_type == 'ENQ_CALL')) { ?>
                    <tr class="single_record_back">                                     
                        <td colspan="6" style="background: beige;text-align: center;font-weight: bold;">Enquiry Question & Answer </td>
                    </tr>
                <?php } ?>

                <?php
                //var_dump($enq_que);
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
        <?php if($type == "edit" && $current_user_group == "UG-Quality"){ $read="disabled";}else{$read="";} ?>
                <div class="width100 float_left open_greet_quality">

                    <div class="width100 float_left blue_bar " id="open_greet_ques_outer">
                        <?php
                        $open_greet_ans = json_decode($audit_details[0]->open_greet);
                        ?>

                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Opening Greeting</div></div>
                        <div class="width33 float_left">
                            <label id="hdtna" onclick=" myFunction()" for="open_<?php echo $open_greet->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="open_<?php echo $open_greet->qa_ques_id; ?>_yes" <?php echo $read; ?> type="radio" name="audit[open_greet][open_greet]" class="radio_check_input filter_either_or[open_<?php echo $open_greet->qa_ques_id; ?>_yes,open_<?php echo $open_greet->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>" <?php
                                if ($open_greet_ans->open_greet == 'Y') {
                                    echo "checked=checked";
                                }
                                ?> >
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="open_<?php echo $open_greet->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="open_<?php echo $open_greet->qa_ques_id; ?>_no" type="radio" name="audit[open_greet][open_greet]" class="radio_check_input filter_either_or[open_<?php echo $open_greet->qa_ques_id; ?>_yes,open_<?php echo $open_greet->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>" <?php
                                if ($open_greet_ans->open_greet == 'N') {
                                    echo "checked=checked";
                                }
                                ?> <?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>

                    </div>
                    <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $open_greet_ans = json_decode($audit_details[0]->open_greet_chk);
                            foreach ($ero_open_greet as $open_greet) {
                                $open_ques_id = $open_greet->qa_ques_id;
                                $selected = $open_greet_ans->$open_ques_id;
                                ?>

                                <div class="width_48 float_left">
                                    <div class=" float_left" style="line-height:25px;"><?php echo $open_greet->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input " >

                                        <div class="width30 float_left">
                                            <label for="not_attended_<?php echo $open_greet->qa_ques_id; ?>"  class="chkbox_check">
                                                <input type="checkbox" name="audit[open_greet_chk][<?php echo $open_greet->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="not_attended_<?php echo $open_greet->qa_ques_id; ?>"   <?php echo $update; ?>  <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?> <?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="attended_<?php echo $open_greet->qa_ques_id; ?>" class="chkbox_check">
                                                <input type="checkbox" name="audit[open_greet_chk][<?php echo $open_greet->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="attended_<?php echo $open_greet->qa_ques_id; ?>"<?php echo $update; ?> <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?> <?php echo $read; ?>> 
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="need_imp_<?php echo $open_greet->qa_ques_id; ?>" class="chkbox_check">
                                                <input type="checkbox" name="audit[open_greet_chk][<?php echo $open_greet->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="need_imp_<?php echo $open_greet->qa_ques_id; ?>" <?php echo $update; ?> <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?> <?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 10</div>
                        <div class="width30 float_right">
                            <input name="audit[open_greet_marks]" id="open_greet_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->open_greet_marks ? $audit_details[0]->open_greet_marks : 0; ?>" type="text" tabindex="2" placeholder="Marks" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>

                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="varification_ques_outer">
                        <?php $ver_mat_ans = json_decode($audit_details[0]->ver_mat); ?>
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Verification Matrix&nbsp;</div></div>
                        <div class="width33 float_left">
                        
                            <label id="hdtna" onclick=" myFunction()" for="var_<?php echo $ver_mat->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="var_<?php echo $ver_mat->qa_ques_id; ?>_yes" type="radio" name="audit[ver_mat][ver_mat]" class="radio_check_input filter_either_or[var_<?php echo $ver_mat->qa_ques_id; ?>_yes,var_<?php echo $ver_mat->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php
                                if ($ver_mat_ans->ver_mat == 'Y') {
                                    echo "checked=checked";
                                }
                                ?> <?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="var_<?php echo $ver_mat->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="var_<?php echo $ver_mat->qa_ques_id; ?>_no" type="radio" name="audit[ver_mat][ver_mat]" class="radio_check_input filter_either_or[var_<?php echo $ver_mat->qa_ques_id; ?>_yes,var_<?php echo $ver_mat->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>" <?php
                                if ($ver_mat_ans->ver_mat == 'N') {
                                    echo "checked=checked";
                                }
                                ?> <?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>
                    </div>  <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $ver_mat_ans = json_decode($audit_details[0]->ver_mat_chk);
//var_dump($ver_mat);
                            foreach ($ero_ver_mat as $key => $ver_mat) {
                                $ques_id = $ver_mat->qa_ques_id;
                                $selected = $ver_mat_ans->$ques_id;
                                ?>
                                <div class="width_48 float_left">
                                    <div class=" float_left"><?php echo $ver_mat->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input " >
                                        <?php
                                        $informed_to = array();
                                        if ($preventive[0]->informed_to != '') {
                                            $informed_to = json_decode($preventive[0]->informed_to);
                                        }
                                        ?>
                                        <div class="width30 float_left">
                                            <label for="var_<?php echo $ver_mat->qa_ques_id; ?>_not_avialed" class="chkbox_check">
                                                <input type="checkbox" name="audit[ver_mat_chk][<?php echo $ver_mat->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="var_<?php echo $ver_mat->qa_ques_id; ?>_not_avialed" <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="var_<?php echo $ver_mat->qa_ques_id; ?>_avialed" class="chkbox_check">
                                                <input type="checkbox" name="audit[ver_mat_chk][<?php echo $ver_mat->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="var_<?php echo $ver_mat->qa_ques_id; ?>_avialed" <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="var_<?php echo $ver_mat->qa_ques_id; ?>_needs_imp" class="chkbox_check">
                                                <input type="checkbox" name="audit[ver_mat_chk][<?php echo $ver_mat->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="var_<?php echo $ver_mat->qa_ques_id; ?>_needs_imp" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 10</div>
                        <div class="width30 float_right">

                            <input name="audit[ver_matrix_marks]" id="ver_matrix_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->ver_matrix_marks ? $audit_details[0]->ver_matrix_marks : 0; ?>"  type="text" tabindex="36" placeholder="Marks" autocomplete="off" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>

                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="complete_call_system">
                        <?php
                        $comp_systm_ans = json_decode($audit_details[0]->comp_systm);
                        ?>
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Complete call & system flow</div></div>
                        <div class="width33 float_left"><?php // echo $comp_systm_ans->comp_systm; ?>
                            <label id="hdtna" onclick=" myFunction()" for="comp_<?php echo $comp_systm->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="comp_<?php echo $comp_systm->qa_ques_id; ?>_yes" type="radio" name="audit[comp_systm][comp_systm]" class="radio_check_input filter_either_or[comp_<?php echo $comp_systm->qa_ques_id; ?>_yes,comp_<?php echo $comp_systm->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($comp_systm_ans->comp_systm == 'Y') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="comp_<?php echo $comp_systm->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="comp_<?php echo $comp_systm->qa_ques_id; ?>_no" type="radio" name="audit[comp_systm][comp_systm]" class="radio_check_input filter_either_or[comp_<?php echo $comp_systm->qa_ques_id; ?>_yes,comp_<?php echo $comp_systm->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($comp_systm_ans->comp_systm == 'N') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>

                    </div>  <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $comp_systm_ans = json_decode($audit_details[0]->comp_systm_chk);
                            foreach ($ero_comp_systm as $comp_systm) {
                                $comp_systm_id = $comp_systm->qa_ques_id;
                                $selected = $comp_systm_ans->$comp_systm_id;
                                ?>
                                <div class="width_48 float_left">
                                    <div class="float_left" style="line-height:25px;" ><?php echo $comp_systm->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input " >
                                        <?php
                                        $informed_to = array();
                                        if ($preventive[0]->informed_to != '') {
                                            $informed_to = json_decode($preventive[0]->informed_to);
                                        }
                                        ?>
                                        <div class="width30 float_left">
                                            <label for="comp_<?php echo $comp_systm->qa_ques_id; ?>_not_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[comp_systm_chk][<?php echo $comp_systm->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_avialed"  id="comp_<?php echo $comp_systm->qa_ques_id; ?>_not_availed" <?php
                                                if ($selected == 'not_avialed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="comp_<?php echo $comp_systm->qa_ques_id; ?>_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[comp_systm_chk][<?php echo $comp_systm->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="comp_<?php echo $comp_systm->qa_ques_id; ?>_availed" <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="comp_<?php echo $comp_systm->qa_ques_id; ?>_need_improvement" class="chkbox_check">
                                                <input type="checkbox" name="audit[comp_systm_chk][<?php echo $comp_systm->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="comp_<?php echo $comp_systm->qa_ques_id; ?>_need_improvement" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvment<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 30</div>
                        <div class="width30 float_right">
                            <input name="audit[comp_systm_marks]" id="comp_systm_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->comp_systm_marks ? $audit_details[0]->comp_systm_marks : 0; ?>" type="text" tabindex="2" placeholder="Marks" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>


                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="notification_outer">
                        <?php $notification_ans = json_decode($audit_details[0]->notification);
                        ?>
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Notification</div></div>
                        <div class="width33 float_left">
                            <label id="hdtna" onclick=" myFunction()" for="not_<?php echo $notification->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="not_<?php echo $notification->qa_ques_id; ?>_yes" type="radio" name="audit[notification][notification]" class="radio_check_input filter_either_or[not_<?php echo $notification->qa_ques_id; ?>_yes,not_<?php echo $notification->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($notification_ans->notification == 'Y') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="not_<?php echo $notification->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="not_<?php echo $notification->qa_ques_id; ?>_no" type="radio" name="audit[notification][notification]" class="radio_check_input filter_either_or[not_<?php echo $notification->qa_ques_id; ?>_yes,not_<?php echo $notification->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($notification_ans->notification == 'N') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>

                    </div>  <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $notification_ans = json_decode($audit_details[0]->notification_chk);
                            foreach ($ero_notification as $notification) {
                                $notification_id = $notification->qa_ques_id;
                                $selected = $notification_ans->$notification_id;
                                ?>
                                <div class="width_48 float_left">
                                    <div class=" float_left " style="line-height:25px;"><?php echo $notification->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input " >

                                        <div class="width30 float_left">
                                            <label for="not_<?php echo $notification->qa_ques_id; ?>_not_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[notification_chk][<?php echo $notification->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="not_<?php echo $notification->qa_ques_id; ?>_not_availed" <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="not_<?php echo $notification->qa_ques_id; ?>_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[notification_chk][<?php echo $notification->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="not_<?php echo $notification->qa_ques_id; ?>_availed" <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span> Availed<br>
                                            </label>

                                        </div>
                                        <div class="width33 float_left">
                                            <label for="not_<?php echo $notification->qa_ques_id; ?>_needs_improvement" class="chkbox_check">
                                                <input type="checkbox" name="audit[notification_chk][<?php echo $notification->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="not_<?php echo $notification->qa_ques_id; ?>_needs_improvement" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>

                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 15</div>
                        <div class="width30 float_right">
                            <input name="audit[notification_marks]" id="notification_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->notification_marks ? $audit_details[0]->notification_marks : 0; ?>" type="text" tabindex="2" placeholder="Marks" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>


                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="hold_procedure_outer">
                        <?php
                        $hold_procedure_ans = json_decode($audit_details[0]->hold_procedure);
                        ?>
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Hold procedure</div></div>
                        <div class="width33 float_left">
                            <label id="hdtna" onclick=" myFunction()" for="hold_<?php echo $hold_procedure->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="hold_<?php echo $hold_procedure->qa_ques_id; ?>_yes" type="radio" name="audit[hold_procedure][hold_procedure]" class="radio_check_input filter_either_or[hold_<?php echo $hold_procedure->qa_ques_id; ?>_yes,hold_<?php echo $hold_procedure->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($hold_procedure_ans->hold_procedure == 'Y') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="hold_<?php echo $hold_procedure->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="hold_<?php echo $hold_procedure->qa_ques_id; ?>_no" type="radio" name="audit[hold_procedure][hold_procedure]" class="radio_check_input filter_either_or[hold_<?php echo $hold_procedure->qa_ques_id; ?>_yes,hold_<?php echo $hold_procedure->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($hold_procedure_ans->hold_procedure == 'N') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>
                    </div>  <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $hold_procedure_ans = json_decode($audit_details[0]->hold_procedure_chk);
                            foreach ($ero_hold_procedure as $hold_procedure) {

                                $hold_procedure_id = $hold_procedure->qa_ques_id;
                                $selected = $hold_procedure_ans->$hold_procedure_id;
                                ?>
                                <div class="width_48 float_left">
                                    <div class=" float_left "><?php echo $hold_procedure->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input " >

                                        <div class="width30 float_left">
                                            <label for="hold_<?php echo $hold_procedure->qa_ques_id; ?>_not_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[hold_procedure_chk][<?php echo $hold_procedure->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="hold_<?php echo $hold_procedure->qa_ques_id; ?>_not_availed" <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="hold_<?php echo $hold_procedure->qa_ques_id; ?>_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[hold_procedure_chk][<?php echo $hold_procedure->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="hold_<?php echo $hold_procedure->qa_ques_id; ?>_availed" <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="hold_<?php echo $hold_procedure->qa_ques_id; ?>_needs_improvement" class="chkbox_check">
                                                <input type="checkbox" name="audit[hold_procedure_chk][<?php echo $hold_procedure->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="hold_<?php echo $hold_procedure->qa_ques_id; ?>_needs_improvement" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 5</div>
                        <div class="width30 float_right">
                            <input name="audit[hold_procedure_marks]" id="hold_procedure_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->hold_procedure_marks ? $audit_details[0]->hold_procedure_marks : 0; ?>" type="text" tabindex="2" placeholder="Marks" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>



                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="commu_skill_outer">
                        <?php $commu_skill_ans = json_decode($audit_details[0]->commu_skill); ?> 
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Communication Skill</div></div>
                        <div class="width33 float_left">
                            <label id="hdtna" onclick=" myFunction()" for="com_<?php echo $commu_skill->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="com_<?php echo $commu_skill->qa_ques_id; ?>_yes" type="radio" name="audit[commu_skill][commu_skill]" class="radio_check_input filter_either_or[hold_<?php echo $commu_skill->qa_ques_id; ?>_yes,hold_<?php echo $commu_skill->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($commu_skill_ans->commu_skill == 'Y') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="com_<?php echo $commu_skill->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="com_<?php echo $commu_skill->qa_ques_id; ?>_no" type="radio" name="audit[commu_skill][commu_skill]" class="radio_check_input filter_either_or[hold_<?php echo $commu_skill->qa_ques_id; ?>_yes,hold_<?php echo $commu_skill->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}"  TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($commu_skill_ans->commu_skill == 'N') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>   <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>

                    </div>  <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $commu_skill_ans = json_decode($audit_details[0]->commu_skill_chk);
                            foreach ($ero_commu_skill as $commu_skill) {
                                $commu_skill_id = $commu_skill->qa_ques_id;
                                $selected = $commu_skill_ans->$commu_skill_id;
                                ?>
                                <div class="width_48 float_left">
                                    <div class=" float_left " style="line-height:24px;"><?php echo $commu_skill->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input " >

                                        <div class="width30 float_left">
                                            <label for="com_<?php echo $commu_skill->qa_ques_id; ?>_not_availaed" class="chkbox_check">
                                                <input type="checkbox" name="audit[commu_skill_chk][<?php echo $commu_skill->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="com_<?php echo $commu_skill->qa_ques_id; ?>_not_availaed" <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="com_<?php echo $commu_skill->qa_ques_id; ?>_availaed" class="chkbox_check">
                                                <input type="checkbox" name="audit[commu_skill_chk][<?php echo $commu_skill->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="com_<?php echo $commu_skill->qa_ques_id; ?>_availaed" <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="com_<?php echo $commu_skill->qa_ques_id; ?>_needs_improvement" class="chkbox_check">
                                                <input type="checkbox" name="audit[commu_skill_chk][<?php echo $commu_skill->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="com_<?php echo $commu_skill->qa_ques_id; ?>_needs_improvement" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 20</div>
                        <div class="width30 float_right">
                            <input name="audit[commu_skill_marks]" id="commu_skill_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->commu_skill_marks ? $audit_details[0]->commu_skill_marks : 0; ?>" type="text" tabindex="2" placeholder="Marks" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>


                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="closing_greeting_outer">
                        <?php $closing_greet_ans = json_decode($audit_details[0]->closing_greet); ?>
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Closing Greeting</div></div>
                        <div class="width33 float_left">
                            <label id="hdtna" onclick=" myFunction()" for="closing_<?php echo $closing_greet->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="closing_<?php echo $closing_greet->qa_ques_id; ?>_yes" type="radio" name="audit[closing_greet][closing_greet]" class="radio_check_input filter_either_or[closing_<?php echo $closing_greet->qa_ques_id; ?>_yes,closing_<?php echo $closing_greet->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($closing_greet_ans->closing_greet == 'Y') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label onclick=" myFunction()" for="closing_<?php echo $closing_greet->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="closing_<?php echo $closing_greet->qa_ques_id; ?>_no" type="radio" name="audit[closing_greet][closing_greet]" class="radio_check_input filter_either_or[closing_<?php echo $closing_greet->qa_ques_id; ?>_yes,closing_<?php echo $closing_greet->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($closing_greet_ans->closing_greet == 'N') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>
                    </div>  <div class="checkbox_div hide">

                        <div class="width100  float_left">
                            <?php
                            $closing_greet_ans = json_decode($audit_details[0]->closing_greet_chk);
                            foreach ($ero_closing_greet as $closing_greet) {
                                $closing_greet_id = $closing_greet->qa_ques_id;
                                $selected = $closing_greet_ans->$closing_greet_id;
                                ?>
                                <div class="width_48 float_left">
                                    <div class=" float_left style="line-height:25px;""><?php echo $closing_greet->qa_ques; ?></div>
                                </div>
                                <div class="width50 float_right">
                                    <div class="filed_input  " >
                                        <?php
                                        $informed_to = array();
                                        if ($preventive[0]->informed_to != '') {
                                            $informed_to = json_decode($preventive[0]->informed_to);
                                        }
                                        ?>
                                        <div class="width30 float_left">
                                            <label for="closing_<?php echo $closing_greet->qa_ques_id; ?>_not_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[closing_greet_chk][<?php echo $closing_greet->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="closing_<?php echo $closing_greet->qa_ques_id; ?>_not_availed" <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width30 float_left">
                                            <label for="closing_<?php echo $closing_greet->qa_ques_id; ?>_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[closing_greet_chk][<?php echo $closing_greet->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availaed"  id="closing_<?php echo $closing_greet->qa_ques_id; ?>_availed" <?php
                                                if ($selected == 'availaed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="closing_<?php echo $closing_greet->qa_ques_id; ?>_needs_improvement" class="chkbox_check">
                                                <input type="checkbox" name="audit[closing_greet_chk][<?php echo $closing_greet->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="closing_<?php echo $closing_greet->qa_ques_id; ?>_needs_improvement" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                            <?php } ?>
                        </div>
                        <!--</div>-->
                        <div class="width30 label blue float_left">Mark out of 10</div>
                        <div class="width30 float_right">
                            <input name="audit[closing_greet_marks]" id="closing_greet_marks" class="width_2 float_right" value="<?php echo $audit_details[0]->closing_greet_marks ? $audit_details[0]->closing_greet_marks : 0; ?>" type="text" tabindex="2" placeholder="Marks" <?php echo $read; ?>>
                        </div>
                    </div>
                </div>

                <div class="width100 float_left open_greet_quality">
                    <div class="width100 float_left blue_bar " id="fetal_indicator_outer">
                        <?php $fetal_indicator_ans = json_decode($audit_details[0]->fetal_indicator); ?>
                        <div class="width33 float_left ">  <div class="label  float_left   white strong">Fatal Indicator</div></div>
                        <div class="width33 float_left">
                            <label for="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_yes" class="radio_check width2 float_left">
                                <input id="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_yes" type="radio" name="audit[fetal_indicator][fetal_indicator]" class="radio_check_input filter_either_or[fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_yes,fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_no]" value="Y" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($fetal_indicator_ans->fetal_indicator == 'Y') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">Yes</span>
                            </label>
                            <label for="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_no" class="radio_check width2 float_left">
                                <input id="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_no" type="radio" name="audit[fetal_indicator][fetal_indicator]" class="radio_check_input filter_either_or[fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_yes,fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_no]" value="N" data-errors="{filter_either_or:'Answer is required'}" TABINDEX="10.<?php echo $key; ?>"  <?php
                                if ($fetal_indicator_ans->fetal_indicator == 'N') {
                                    echo "checked=checked";
                                }
                                ?><?php echo $read; ?>>
                                <span class="radio_check_holder" ></span><span class="white">No</span>
                            </label>
                        </div>  
                        <div class="width33 float_left">
                            <div class="quality_arrow_back"></div>
                        </div>
                    </div>  <div class="checkbox_div hide" >

                        <div class="width100  float_left" id="fetal_question_div">
                            <?php
                            $fetal_indicator_ans = json_decode($audit_details[0]->fetal_indicator_chk);
                            foreach ($ero_fetal_indicator as $fetal_indicator) {
                                $fetal_indicator_id = $fetal_indicator->qa_ques_id;
                                $selected = $fetal_indicator_ans->$fetal_indicator_id;
                                ?>
                            <div class="main_input_box width100">
                                <div class="width_52 float_left"  style="line-height:10px;">
                                    <div class=" float_left "><?php echo $fetal_indicator->qa_ques; ?></div>
                                </div>
                                <div class="width_48 float_right">
                                    <div class="filed_input " >

                                        <div class="width_25 float_left">
                                            <label for="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_not_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[fetal_indicator_chk][<?php echo $fetal_indicator->qa_ques_id; ?>]" class="check_input unit_checkbox" value="not_availed"  id="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_not_availed" <?php
                                                if ($selected == 'not_availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Not Availed<br>
                                            </label>
                                        </div>
                                        <div class="width_20 float_left">
                                            <label for="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_availed" class="chkbox_check">
                                                <input type="checkbox" name="audit[fetal_indicator_chk][<?php echo $fetal_indicator->qa_ques_id; ?>]" class="check_input unit_checkbox" value="availed"  id="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_availed" <?php
                                                if ($selected == 'availed') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Availed<br>
                                            </label>
                                        </div>
                                        <div class="width33 float_left">
                                            <label for="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_needs_improvement" class="chkbox_check">
                                                <input type="checkbox" name="audit[fetal_indicator_chk][<?php echo $fetal_indicator->qa_ques_id; ?>]" class="check_input unit_checkbox" value="needs_improvement"  id="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_needs_improvement" <?php
                                                if ($selected == 'needs_improvement') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Needs Improvement<br>
                                            </label>
                                        </div>
                                        <div class="width_20 float_left">
                                            <label for="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_ohter" class="chkbox_check">
                                                <input type="checkbox" name="audit[fetal_indicator_chk][<?php echo $fetal_indicator->qa_ques_id; ?>]" class="check_input unit_checkbox" value="ohter"  id="fetal_<?php echo $fetal_indicator->qa_ques_id; ?>_ohter" <?php
                                                if ($selected == 'other') {
                                                    echo "checked=checked";
                                                }
                                                ?>  <?php echo $update; ?><?php echo $read; ?>>
                                                <span class="chkbox_check_holder"></span>Other<br>
                                            </label>
                                        </div>
                                    </div>   
                                </div>
                                <div class="other_div width2 float_left hide">
                                    <input name="audit[fetal_indicator_chk][other_<?php echo $fetal_indicator->qa_ques_id; ?>]" class="" value="<?php echo $audit_details[0]->call_observation; ?>" type="text" tabindex="2" placeholder="Other" <?php echo $read; ?>>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>

                <div class="width100 form_field " >
                    <div class="width2 float_left" id="fatal_error_indicator" style="margin-top:10px;">         
                        <div class="width30 label blue float_left strong">Fatal Error Indicator&nbsp;</div>
                        <div class="width70 float_left">
                            <select id="fatal_group" name="audit[fetal_error_indicator]"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" <?php echo $read; ?> >


                                <option  value="">Select Fatal Error</option>
                                <option value="Behavioral" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Behavioral') {
                                    echo "selected";
                                }
                                ?>>Behavioral</option>
                                <option value="Incomplete information" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Incomplete information') {
                                    echo "selected";
                                }
                                ?>>Incomplete information</option>
                                <option value="Incorrect Information" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Incorrect Information') {
                                    echo "selected";
                                }
                                ?>>Incorrect Information</option>
                                <option value="Information Validations" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Information Validations') {
                                    echo "selected";
                                }
                                ?>>Information Validations</option>
                                <option value="Procedures" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Procedures') {
                                    echo "selected";
                                }
                                ?>>Procedures</option>
                                
                                <option value="Tagging" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Tagging') {
                                    echo "selected";
                                }
                                ?>>Tagging</option>
                                <option value="Verbiages" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'Verbiages') {
                                    echo "selected";
                                }
                                ?>>Verbiages</option>
                                <option value="other" <?php
                                if ($audit_details[0]->fetal_error_indicator == 'other') {
                                    echo "selected";
                                }
                                ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="width2 float_left">
                        <div  id='other_fatal_indicator'>

                            <?php
                           
                            if ($audit_details[0]->other_fatal_error_inc != '' && $audit_details[0]->other_fatal_error_inc != NULL) {
                                ?>
                                <div class="style6 float_left width30">Other Fatal Error Indicator </div>

                                <div class="width70  float_left">
                                    <input name="other_fatal_inc_error" class="" value="<?php echo $audit_details[0]->other_fatal_error_inc; ?>" type="text" tabindex="2" placeholder="Fatal Indicator Error" data-errors="{filter_required:'Fatal Indicator Error should not be blank!'}" <?php echo $read; ?>>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="width2 float_left" style="margin-top:10px;">
                        <div class="label blue float_left width30 strong">Call Observation</div>

                        <div class="width70 float_left" >
                            <textarea name="audit[call_observation]" class="" value="" type="text" tabindex="2" placeholder="Call Observation" <?php echo $read; ?>><?php echo $audit_details[0]->call_observation; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="width100 form_field ">
                    <div class="width2 float_left">
                        <div class="width30 label blue float_left strong">Quality Score</div>
                        <div class="width70 float_left">
                            <input name="audit[quality_score]" id="quality_score_marks" class="" onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="3" value="<?php echo $audit_details[0]->quality_score; ?>" type="text" tabindex="2" placeholder="Quality Score" <?php echo $read; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="width30 label blue float_left">Performer Group</div>
                        <div class="width70 float_left">
                            <input name="audit[performer_group]" id="performer_group" class="" value="<?php echo $audit_details[0]->performer_group; ?>" type="text" tabindex="2" placeholder="Performer group" <?php echo $read; ?>>
                        </div>
                    </div>

                </div>
                <div class="width100 form_field ">
                    <div class="width2 float_left" id="hideTNA">         
                        <div class="width30 label blue float_left strong">TNA&nbsp;</div>
                        <div class="width70 float_left">
                            <select id="group" name="audit[tna]"  class="" TABINDEX="7" <?php echo $read; ?>>
                                <option  value="">Select TNA</option>
                                <option value="Ameyo handling"  <?php
                                if ($audit_details[0]->tna == 'Ameyo handling') {
                                    echo "selected";
                                }
                                ?>>Avaya Handling</option>
                                <option value="call handling skill"  <?php
                                if ($audit_details[0]->tna == 'call handling skill') {
                                    echo "selected";
                                }
                                ?>>Call Handling Skill</option>
                                <option value="communication skill" <?php
                                if ($audit_details[0]->tna == 'communication skill') {
                                    echo "selected";
                                }
                                ?>>Communication Skill</option>
                                <option value="process knowledge"  <?php
                                if ($audit_details[0]->tna == 'process knowledge') {
                                    echo "selected";
                                }
                                ?>>Process Knowledge</option>
                                <option value="probing skill"  <?php
                                if ($audit_details[0]->tna == 'probing skill') {
                                    echo "selected";
                                }
                                ?>>Probing Skills</option>
                                <option value="Remark Writings"  <?php
                                if ($audit_details[0]->tna == 'Remark Writings') {
                                    echo "selected";
                                }
                                ?>>Remark Writings</option>
                                <option value="soft skills" <?php
                                if ($audit_details[0]->tna == 'soft skills') {
                                    echo "selected";
                                }
                                ?>>Soft Skills</option>
                                <option value="system navigation"  <?php
                                if ($audit_details[0]->tna == 'system navigation') {
                                    echo "selected";
                                }
                                ?>>System Navigation</option>
                                
                                
                            </select>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="width30 label blue float_left">Audit Method</div>
                        <div class="width70 float_left">
                            <select id="group" name="audit[audit_method]"  class="" data-errors="{filter_required:'Audit Method should not blank'}" TABINDEX="7" <?php echo $read; ?>>
                                <option value="">Select Audit Method</option>
                                <option value="Side by Side" <?php
                                if ($audit_details[0]->audit_method == 'Side by Side') {
                                    echo "selected";
                                }
                                ?>>Side by Side</option>
                                <option value="Voice log" <?php
                                if ($audit_details[0]->audit_method == ""){
                                    echo "selected";
                                }elseif($audit_details[0]->audit_method == 'Voice log') {
                                    echo "selected";
                                }
                                ?>>Voice Log</option>
                                <option value="Y-Jack" <?php
                                if ($audit_details[0]->audit_method == 'Y-Jack') {
                                    echo "selected";
                                }
                                ?>>Y-Jack</option>

                            </select>
                        </div>
                    </div>

                </div>
                <?php //echo $view; ?>
                <div class="width100 form_field ">

                    <div class="width2 float_left">
                        <div class="width30 label blue float_left">Quality Remark</div>
                        <div class="width70 float_left">
                            <textarea name="audit[quality_remark]" class="" value="" type="text" tabindex="2" placeholder="Quality Remark" <?php echo $read; ?>><?php echo $audit_details[0]->quality_remark; ?></textarea>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <!-- <div class="width30 label blue float_left">Remark</div>

                        <div class="width70 float_left">
                            <input name="audit[remark]"  value="<?php echo $audit_details[0]->remark; ?>" type="text"  placeholder="Remark">
                        </div> -->
                        <div class="width30 label blue float_left">ERO Meeting Time</div>
                        <div class="width70 float_left">
                            <input name="audit[ero_invite_time]" class=" mi_next_timecalender" value="<?php echo $audit_details[0]->ero_meeting_time; ?>" type="text" tabindex="2" placeholder="ERO Invite Date Time" data-base='invite_ero' data-errors="{filter_required:'ERO Invite Time should not blank'}" <?php echo $read; ?>>
                        </div>

                    </div>

                </div>
				<!-- <div class="width100 form_field ">

                    <div class="width2 float_left">
                       
                    </div>

                </div> -->
                <div class="width100 form_field ">

                    <!--                    <div  class="width2 float_left text_align_center">
                    
                                            <a data-href='<?php echo base_url(); ?>quality_forms/save_ero_notice' class="click-xhttp-request style1" data-qr='ref_id=<?php echo $ero_id; ?>' >( Invite To ERO )</a>
                    
                    
                                        </div>-->
                </div>
                                
                        <?php if (@$feedback == 'feedback' || @$type == 'edit') {?>
        <div class="width100 form_field">

                        <div class="width2 float_left">         
                            <div class="width30 label blue float_left">Date of feedback&nbsp;</div>
                            <div class="width70 float_left">
                                <?php //var_dump($feedback_details[0]->fc_added_date);?>
                                <input name="audit[feedback_added_date]" class="mi_next_timecalender" value="<?php echo $audit_details[0]->feedback_added_date; ?>" type="text" tabindex="2" placeholder="Date of feedback" >
                            </div>
                        </div>

                        <div class="width2 float_left">
                            <div class="label blue float_left width30">Feedback status</div>
                            <div class="width2 float_left width70" >
                                <input name="audit[feedback_status]" class="" value="<?php echo $audit_details[0]->feedback_status; ?>" type="text" tabindex="2" placeholder="Feedback status" >
                            </div>
                        </div>
                    </div>
        <div class="width100 form_field">
                        <div class="width2 float_left">  
                            <div class="width100 float_left">         
                                <div class="width30 label blue float_left">Feedback Remark&nbsp;</div>
                                <div class="width70 float_left">
                                    <input name="audit[feedback_remark]" class="" value="<?php echo $audit_details[0]->feedback_remark; ?>" type="text" tabindex="2" placeholder="Feedback Remark" >
                                </div>
                            </div>
                        </div>
        </div> 
        <?php } ?>
        
                <div class="button_field_row width33 margin_auto" style="clear:both;">
                    <div class="button_box">
<?php //var_dump($inc_call_type[0]->inc_added_by); ?>
                        <input name="qa_ad_id" class="" value="<?php echo $audit_details[0]->qa_ad_id; ?>" type="hidden" >
                       
                        <?php
                     
                        if($user_type == 'DCO'){
                           $dco_name = get_clg_data_by_ref_id($dco_info[0]->operate_by);
                            ?>
                         <input name="qa_ad_user_ref_id" class="" value="<?php echo $dco_info[0]->operate_by; ?>" type="hidden" >
                        <input name="qa_ad_user_group" class="" value="<?php echo $user_type; ?>" type="hidden" >
                        <input name="user_system_type" class="" value="<?php echo $dco_name[0]->clg_group; ?>" type="hidden" >
                        <?php }else{ ?>
                         <input name="qa_ad_user_ref_id" class="" value="<?php echo $inc_call_type[0]->inc_added_by; ?>" type="hidden" >
                         <input name="qa_ad_user_group" class="" value="<?php echo $user_type; ?>" type="hidden" >
                        <input name="user_system_type" class="" value="<?php echo $ero_name[0]->clg_group; ?>" type="hidden" >
                        <?php } ?>
                        <input name="qa_ad_inc_ref_id" class="" value="<?php echo $inc_ref_id; ?>" type="hidden" >

<!--                        <a data-href='<?php echo base_url(); ?>quality_forms/save_ero_notice' class="click-xhttp-request style1" data-qr='ref_id=<?php echo $ero_id; ?>' style="padding:10px;" >( Invite To ERO )</a>-->
						<?php 
                        if($open_audit == '1')
                        {
                            ?>
                            <input type="button" name="invite_ero" value="( Invite To ERO )" class="btn click-xhttp-request  action_button" data-href='<?php echo base_url(); ?>quality_forms/save_ero_notice' data-qr='ref_id=<?php echo $inc_call_type[0]->inc_added_by; ?>&inc_ref_id=<?php echo $inc_ref_id; ?>&amp;showprocess=yes'  TABINDEX="23" style="background:none; color:#085b80 !important;">
                            <?php
                        }
                        ?>
                        

                        <input type="button" name="submit" value="<?php if ($view) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>quality_forms/<?php if ($view) { ?>update_audit<?php } else { ?>save_audit<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=quality' TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>"> 
                        <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">             
                        <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
                    </div>
                </div>

        </form>

    </div>
</div>
<script>
    jQuery(document).ready(function () {
//        jQuery(document).on("click", ".blue_bar .quality_arrow_back", function () {
//            jQuery(this).parents('.open_greet_quality').find('.checkbox_div').slideToggle('slow');
//        });
        jQuery("input:checkbox").on('click', function () {
            // in the handler, 'this' refers to the box clicked on
            var $box = jQuery(this);
            if ($box.is(":checked")) {
                // the name of the box is retrieved using the .attr() method
                // as it is assumed and expected to be immutable
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                // the checked state of the group/box on the other hand will change
                // and the current value is retrieved using .prop() method
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    });
</script>
<script>
    function myFunction(){
        var quality_score = $("#quality_score_marks").val();
        // alert(quality_score);
        if(quality_score >= '90'){
        
        $('#hideTNA').hide();
     
        }
        else{
            $('#hideTNA').show();
        }

    }
</script>
