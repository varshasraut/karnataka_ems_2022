<div class="container my-4">
<div class="row">
    <div class="col-12">
        <table class="table table-sm table-striped table-bordered hosp-table text-center text-nowrap">
        <thead class="">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Patient</th>
            <th scope="col">Incident ID</th>
            <th scope="col">Ambulance</th>
            <th scope="col">Complaint</th>
<!--            <th scope="col">Arrived At</th>-->
            <th scope="col">Status</th>
            <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="align-middle">
      
        <?php $i=1;
        if($inc){
         foreach($inc as $inc) { 
            $epcr_details = get_inc_details_handover($inc->inc_ref_id);
            //var_dump($epcr_details);
            ?>
            <?php                      
                            $str = preg_replace('/\D/', '', $duration);
                            $newtimestamp = strtotime(''.$inc->admitted_time .' + '.$str.' minute');
                            $arrival_time =  $inc->admitted_time; ?>
            
                    <tr data-toggle="collapse" data-target="<?php echo "#".$i; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $inc->ptn_fname." ".$inc->ptn_lname; ?></td>
                        <td><?php echo $inc->inc_ref_id; ?></td>
                        <td><?php echo $inc->amb_rto_register_no; ?></td>
                        <td style="white-space:normal;"><?php echo $inc->ct_type; ?></td>
<!--                        <td><?php  ?></td>-->
                        <td><?php echo $inc->admitted_status ?></td>
                        <td><button class="btn btn-xl btn-warning" data-hp_lat='<?php echo $hosp[0]->hp_lat; ?>' data-hp_lng='<?php echo $hosp[0]->hp_long;?>' data-inc_lat='<?php echo $inc->inc_lat; ?>' data-inc_lng='<?php echo $inc->inc_long;?>' >View</button></td>
                    </tr>
               
            
                <tr id="<?php echo $i; ?>" class="collapse hosp-info">
                <td></td>
                    <td colspan="1">
                   

                    <div class="card bg-info text-white">
                    <div class="card-header bg-dark">Patient Information</div>
                        <div class="card-body">
                        
                        <div class="col">Patient Name: <?php echo $inc->ptn_fname." ".$inc->ptn_lname; ?></div>
                        
                        <div class="col">Patient Age: <?php echo $inc->ptn_age; ?></div>
                        <div class="col">Patient Complaint: <?php echo $inc->ct_type; ?></div>
                        
                        <div class="col">Patient Condition: <?php echo $inc->ptn_condition?: 'Not Available';  ?></div>
                        </div>
                    </div>
                    <div class="card bg-danger text-white">
                    <div class="card-header bg-dark">Incident Information</div>
                        <div class="card-body">
                        
                        <div class="col">Incident ID: <?php echo $inc->inc_ref_id; ?></div>
                        <div class="col">Chief Complaint: <?php echo $inc->ct_type; ?></div>
                        
                        <div class="col">Dispatch Time: <?php echo $inc->inc_datetime; ?></div>
                        <!--<div class="col">Admitted Time: <?php echo $inc->admitted_time;  ?></div>-->
                        <div class="col">Admitted Time: <?php echo $inc->admitted_time;  ?></div>
                        </div>
                    </div>
                    </td>
                    
                    <td colspan="6">
                    <div class="card bg-secondary text-white">
                    <div class="card-header bg-dark">Handover Condition</div>
                        <div class="card-body">
                        
                            <div class="row text-left">
                                <div class="col-2">LOC: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->level_type; ?></div>
                                <div class="col-2">RR: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con_rr; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">Oxy Sat: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_oxy_sat_get_nf.'/'.$epcr_details[0]->hc_oxy_sat_get_nf_txt; ?></div>
                                <div class="col-2">GCS: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con_gcs; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">Airway: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_airway; ?></div>
                                <div class="col-2">Skin: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con_skin; ?></div>
                            </div>

                            <div class="row text-left">
                                <div class="col-2">Breathing: </div>
                                <?php if($epcr_details[0]->hc_breathing != ''){ ?>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_breathing.'/'.$epcr_details[0]->hc_breathing_txt; ?></div>
                                <?php } ?>
                                <?php if($epcr_details[0]->hc_con_pupils != ''){ ?>
                                <div class="col-4">Pupils-Right-Left: </div>
                                <div class="col-6"><?php echo $epcr_details[0]->pp_type_left.'/'.$epcr_details[0]->pp_type_right; ?></div>
                                <?php } ?>
                            </div>

                            <div class="row text-left">
                                <div class="col-2">Pulse: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_cir_pulse_p.'/'.$epcr_details[0]->hc_cir_pulse_p_txt; ?></div>
                                <div class="col-2">Status: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->pt_status; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">Repiression: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con_respiression; ?></div>
                                <div class="col-2">Cardiac: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_cardiac; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">Cap Refill Sec: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_cir_cap_refill_great_t; ?></div>
                                <div class="col-2">Patient Handover: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hi_pat_handover; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">BP Sys-dia: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_bp_sysbp_txt.'/'.$epcr_details[0]->hc_bp_dibp_txt; ?></div>
                                <div class="col-2">OPD ID: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->opd_no_txt; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">PI TXT: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_pi_txt; ?></div>
                                <div class="col-2">BSL: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con__bsl; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">Cir. Radial: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con_circulation_radial.'/'.$epcr_details[0]->hc_con_circulation_carotid; ?></div>
                                <div class="col-2">Temp: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->hc_con_temp; ?></div>
                            </div>
                            <div class="row text-left">
                                <div class="col-2">Pro.Immpression: </div>
                                <div class="col-4"><?php echo $epcr_details[0]->pro_name; ?></div>
                            </div>
                        </div>
                    </div>
                    </td>
                </tr>
           
            
          <?php $i++; } }else{ ?>
                <tr>
                <td  colspan="7">No Records Found</td>
                </tr>
          <?php } ?>
       
        </tbody>
        </table>
    </div>
</div>