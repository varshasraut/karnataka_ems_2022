<script>

<?php echo $scrpt; ?>

</script>

<div class="inc_pt_info float_left width100">

    <div class="width100">

        <div class="width47 float_left">

            <span class="font_weight600"> Incident Information
            </span>


            <table class="style3">

                <tr>
                    <td class="width40">Incident Id</td>
                    <td class="width_16"><?php echo $increfid; ?></td>
                </tr>

                <tr>
                    <td>Call Type</td>
                    <td><?php echo ucwords(get_purpose_of_call($cl_dtl[0]->inc_type)); ?></td> 
                </tr>

                <tr>
                    <td>Incident Address</td>
                    <td><?php echo $cl_dtl[0]->inc_address; ?><?php echo ( $cl_dtl[0]->inc_address) ? $cl_dtl[0]->inc_address : "-"; ?></td>
                </tr>
                <tr>
                    <td>Remark from Feedback</td>
                    <td><?php echo ( $fd_dtl[0]->fc_employee_remark) ? $fd_dtl[0]->fc_employee_remark : "-"; ?></td>
                </tr>
                <tr>
                    <td>Added By</td>
                    <td><?php echo ( $cl_dtl[0]->clg_first_name.' '.$cl_dtl[0]->clg_last_name) ? $cl_dtl[0]->clg_first_name.' '.$cl_dtl[0]->clg_last_name : "-"; ?></td>
                </tr>
                <tr>
                    <td>Added DateTime</td>
                    <td><?php echo ( $cl_dtl[0]->inc_datetime) ? $cl_dtl[0]->inc_datetime : "-"; ?></td>
                </tr>


            </table>

        </div>


        <div class="width47 float_right">

            <span class="font_weight600">Caller Information</span>


            <table class="style3">

                <tr>
                    <td class="width40 ">Caller No</td>
                    <td><?php echo $cl_dtl[0]->clr_mobile; ?></td>
                </tr>


                <tr>
                    <td class="width40 ">Caller Name</td>
                    <td><?php echo $cl_dtl[0]->clr_fname; ?></td>
                </tr>

                <tr>
                    <td class="width40">Caller Relation</td>
                    <td><?php echo $cl_dtl[0]->rel_name; ?><?php echo ( $cl_dtl[0]->rel_name) ? $cl_dtl[0]->rel_name : "-"; ?></td>
                </tr>



            </table>

        </div>
    </div>

    <div class="width100">

        <?php if ($ambdtl) { ?>

            <div class="width47 float_left">

                <span class="font_weight600">Ambulance Information</span>

                <table class="style3">
                    <?php foreach ($inc_amb as $amb) { ?>
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
                            <td><?php echo $amb->amb_default_mobile; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb->amb_default_mobile; ?>"></a></td>
                        </tr>

                    <?php } ?>

                </table>

            </div>

        <?php } ?>

        <?php if ($pt_info) { 
            if($pt_info[0]->ptn_gender=='F'){
                $gender='Female';
            }else if($pt_info[0]->ptn_gender=='M'){
                $gender='Male';
            }else if($pt_info[0]->ptn_gender == 'O'){
                $gender='Transgender';
            }else{
                $gender = '-';
            }
            ?>

            <div class="width47 float_right">

                <span class="font_weight600">Patient Information</span>


                <table class="style3">

                    <tr>
                        <td class="width40 ">Patient Name</td>
                        <td><?php echo $pt_info[0]->ptn_fname; ?></td>
                    </tr>


                    <tr>
                        <td class="width40 ">Patient Age</td>
                        <td><?php echo $pt_info[0]->ptn_age .' '.$pt_info[0]->ptn_age_type; ?></td>
                    </tr>

                    <tr>
                        <td class="width40">Patient gender</td>
                        <td><?php echo $gender; ?></td>
                    </tr>



                </table>

            </div>

        <?php } ?>

    </div>


</div>




<input type="hidden" name="increfid" value="<?php echo $increfid; ?>">

<input type="hidden" name="ambregno" value="<?php echo $pt_info[0]->amb_rto_register_no; ?>">



