<script>

<?php echo $scrpt; ?>

</script>

<div class="inc_pt_info float_left width100">

    <div class="width100">

        <div class="width47 float_left">

            <span class="font_weight600">Incident Information</span>

            <table class="style3">
                

                <?php
                
               
                if (trim($pt_info[0]->ntr_nature) != '') { ?>

                    <tr>
                        <td class="width40">MCI Nature</td>
                        <td><?php echo ($pt_info[0]->ntr_nature) ? $pt_info[0]->ntr_nature : '-'; ?></td>

                    </tr>

                <?php } else if (trim($pt_info[0]->ct_type) != '') { ?>

                    <tr>
                        <td class="width40">Chief Complaint Name</td>
                        <td><?php echo ($pt_info[0]->ct_type) ? $pt_info[0]->ct_type : '-'; ?></td>
                    </tr>


                <?php } else if (trim($pt_info[0]->ptn_condition) != '') { ?>
                    <tr>
                        <td class="width40">Patient Condition</td>
                        <td><?php echo ($pt_info[0]->ptn_condition) ? $pt_info[0]->ptn_condition : '-'; ?></td>
                    </tr>
                <?php } ?>
              

                <tr>
                    <td class="width40">Caller Name</td>
                    <td><?php echo $pt_info[0]->clr_fname . " " . $pt_info[0]->clr_lname; ?></td>
                </tr>

               

                <tr>
                    <td>Incident Address</td>
                    <td><?php echo $pt_info[0]->inc_address; ?></td>
                </tr>
                <tr>
                    <td>ERO Note</td>
                    <td><?php echo ($pt_info[0]->inc_ero_summary) ? $pt_info[0]->inc_ero_summary : "-"; ?></td>
                </tr>
                <tr>
                    <td>District</td>
                    <td><?php echo $pt_info[0]->dst_name; ?></td>
                </tr>
                
                <tr>
                    <td>Call Type</td>
                    <td><?php echo ucwords(get_purpose_of_call($pt_info[0]->cl_purpose)); ?></td>
                </tr>

            </table>

        </div>



        <div class="width47 float_right">

            <span class="font_weight600">Patient Information</span>

            <table class="style3">
                 <tr>
                    <td>Patient Name</td>
                    <td><?php echo ($pt_info[0]->ptn_fname) ? $pt_info[0]->ptn_fname . " " . $pt_info[0]->ptn_lname : "-"; ?></td>
                </tr>
                 <tr>
                    <td>Patient Age</td>
                    <td><?php echo ($pt_info[0]->ptn_age) ? $pt_info[0]->ptn_age: "-"; ?></td>
                </tr>
                 <tr>
                    <td>Patient Gender</td>
                    <td><?php echo get_gen($pt_info[0]->ptn_gender);?></td>
                </tr>
            </table>

        </div>


    </div>


    <div class="width100">

        <?php if ($ambdtl) { 
      
            ?>

            <div class="width47">

                <span class="font_weight600">Ambulance Information</span>

                <table class="style3">
                    <?php foreach ($inc_amb as $amb) {?>
                    <tr>
                        <td>SHP Name</td>
                        <td><?php echo $amb->amb_emt_id . " " . $amb->amb_emt_id; ?></td>

                    </tr>
                     <tr>
                        <td>Ambulance Base Location</td>
                        <td><?php echo ($amb->hp_name) ? $amb->hp_name : '-'; ?></td>
                    </tr>
                    <tr>
                        <td class="width40">Ambulance Register No</td>
                        <td><?php echo $amb->amb_rto_register_no; ?></td>
                    </tr>
<!--                     <tr>
                        <td>Ambulance Status</td>
                        <td><?php echo $amb->amb_status; ?></td>
                    </tr>-->
                    <tr>
                        <td>Ambulance Mobile No</td>
                        <td><?php echo $amb->amb_default_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb->amb_default_mobile; ?>"></a></td>
                    </tr>
                     <tr>
                        <td>Ambulance Pilot No</td>
                        <td><?php echo $amb->amb_pilot_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb->amb_pilot_mobile; ?>"></a></td>
                    </tr>

                 <?php }?>

                </table>

            </div>

        <?php } ?>

    </div>


</div>




<input type="hidden" name="increfid" value="<?php echo $increfid; ?>">

<input type="hidden" name="ambregno" value="<?php echo $pt_info[0]->amb_rto_register_no; ?>">



