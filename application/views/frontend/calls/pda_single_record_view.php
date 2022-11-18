
<?php if ($pda_info) { ?>

    <div class="width100 single_record">

        <div id="list_table">

            <table class="table report_table">
                <tr class="single_record_back">                                     
                    <td colspan="6">Previous Call Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Call Type</td>
                    <td class="width_16"><?php echo ucwords($pname); ?></td>
                    <td class="width_16 strong">No Of Patienst</td>
                    <td><?php echo ($pt_info[0]->inc_patient_cnt) ? $pt_info[0]->inc_patient_cnt : '-'; ?></td> 
                    <?php if (trim($pt_info[0]->inc_type) == 'mci') { ?>      <td class="width_16 strong">MCI Nature</td>
                        <td> <?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></td>  <?php } else { ?>    
                        <td class="width_16 strong">Chief Complaint Name</td>
                        <td><?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?></td>   <?php } ?>

                </tr>
                <tr>
                    <td class="width_16 strong">Incident Id</td>
                    <td class="width_16"><?php echo ($pt_info[0]->inc_ref_id); ?></td>
                    <td class="width_16 strong">Incident Address</td>
                    <td><?php echo $pt_info[0]->inc_address;
            ; ?></td> 
                    <td class="width_16 strong">Dispatch Date /Time</td>
                    <td><?php echo $pt_info[0]->inc_datetime; ?></td> 
                </tr>
                <tr>
                    <td class="width_16 strong">Current Ambulance</td>
                    <td class="width_16"><?php echo $pt_info[0]->amb_rto_register_no; ?></td>
                    <td class="width_16 strong">Ambulance base location</td>
                    <td><?php echo ($pt_info[0]->hp_name); ?></td> 
                </tr>

                <tr class="single_record_back">                                     
                    <td colspan="6">PDA Information</td>
                </tr>
                <tr>
                    <td class="width_16 strong">Police Incident ID</td>
                    <td class="width_16"><?php echo $pda_info[0]->pc_inc_ref_id; ?></td>
                    <td class="width_16 strong">Police Call Assign Time</td>
                    <td><?php echo $pda_info[0]->pc_assign_time; ?></td> 
                    <td class="width_16 strong">Police Station Name</td>
                    <td><?php echo $pda_info[0]->police_station_name; ?></td> 
                </tr>
                <tr>
                    <td class="width_16 strong">Police Station Number</td>
                    <td><?php echo $pda_info[0]->pc_mobile_no; ?></td>
                    <td class="width_16 strong">Police station Receiver Name </td>
                    <td><?php echo $pda_info[0]->pc_call_receiver_name; ?></td>
                    <td class="width_16 strong">Police Chief Complaint</td>
                    <td><?php echo $pda_info[0]->po_ct_name; ?></td>
                </tr>
                <tr>
                    <td class="width_16 strong">Ambulance No</td>
                    <td><?php echo $pda_info[0]->amb_rto_register_no; ?></td>
                    <td class="width_16 strong">Standard Remark</td>
                    <td><?php
                      
                       // if ($pda_info[0]->pc_standard_remark == 'police_call_register') {
                            echo $pda_info[0]->pda_remark;
                     //   }
                        ?>
                    </td>
                    <td class="width_16 strong">Remark</td>
                    <td><?php echo $pda_info[0]->pc_remark; ?></td>
                </tr>
<!--                <tr class="single_record_back">                                     
                    <td class="width_16 strong" >Shiftmanager Remark</td>
                    <td colspan="5"><?php echo $supervisor_remark[0]->supervisor_remark; ?></td>
                </tr>-->
                <tr class="single_record_back">                                     
                    <td colspan="6">Caller Details</td>
                </tr>

                <tr>
                    <td class="width_16 strong">Caller No</td>
                    <td><?php echo $pda_info[0]->clr_mobile; ?></td>
                    <td class="width_16 strong">Caller Name</td>
                    <td ><?php echo $pda_info[0]->clr_fname; ?> </td>
                    <td class="width_16 strong">Caller Relation</td>
                    <td><?php echo get_relation_by_id($pda_info[0]->clr_ralation); ?></td>

                </tr>


            </table>
        </div>

    </div>
<?php } else { ?>
    <div class="width100">
        <div class="width100 strong"> No Record Founds </div>
    </div>
    <?php
}
?>