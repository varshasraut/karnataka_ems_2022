<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Bed Booking</h3>
</div>

<div class="confirm_save width100">




    <div class="summary_info">

<!--        <ul class="dtl_block">

            <li><span>Type Of MCI Nature :</span><?php echo " " . $nature[0]->ntr_nature; ?></li>

            <li><span>ERO Summary :</span><?php echo " " . $inc_ero_summary; ?></li>

        </ul>-->

    </div>

    <div id="summary_div">
        

        <div class="width100 float_right">

            <span class="font_weight600">Incident Information</span>

            <table class="style3" style="margin-bottom: 10px;">
                <tr>
                    <td style="width: 40%;">Incident Id </td>
                    <td><?php echo $inc_ref_id; ?></td>

                </tr>
                 <tr>
                    <td style="width: 40%;">Caller Mobile No </td>
                    <td><?php echo $caller_details['clr_mobile']; ?></td>

                </tr> 
                <tr>
                    <td style="width: 40%;">Caller Name </td>
                    <td><?php echo $caller_details['clr_fname']; ?> <?php echo $caller_details['clr_lname']; ?></td>

                </tr>
                <tr>
                    <td style="width: 40%;">Assign Time </td>
                    <td><?php echo $inc_datetime; ?></td>
                </tr>
                <tr>
                   <td style="width: 40%;">Chief Complaint </td>
                   <td><?php echo $nature[0]->ct_type; ?></td>
                </tr>
                <?php if($inc_details['police_chief_complete'] != ''){ 
                    if($police_chief[0]->po_ct_name != 'Other'){
                    ?>
                <tr>
                   <td style="width: 40%;">Police Chief Complaint </td>
                   <td><?php echo $police_chief[0]->po_ct_name; ?></td>
                </tr>
                <?php }else{ ?>
                     <tr>
                   <td style="width: 40%;">Police Chief Complaint </td>
                   <td><?php echo $inc_details['police_chief_complete_other']; ?></td>
                </tr>
                <?php } 
                }?>

                <?php if($inc_details['fire_chief_complete'] != ''){ 
                    if($fire_chief[0]->fi_ct_name != 'Other'){
                    ?>
                <tr>
                   <td style="width: 40%;">Fire Chief Complaint </td>
                   <td><?php echo $fire_chief[0]->fi_ct_name; ?></td>
                </tr>
                <?php }else{ ?>
                     <tr>
                   <td style="width: 40%;">Police Chief Complaint </td>
                   <td><?php echo $inc_details['fire_chief_complete_other']; ?></td>
                </tr>
                <?php } 
                }?>

                <tr>
                    <td>Address </td>
                    <td><?php echo $place; ?></td>
                </tr>

                <tr>
                    <td>ERO Summary :</td>
                     <td><?php echo $standard_remark[0]->re_name; ?><br><?php echo $inc_ero_summary;?></td>

                </tr>

            </table>

        </div>

        <div class="width100 float_right">

            <span class="font_weight600">Patient Information</span>

             <table class="style3"  style="margin-bottom: 10px;">

                <tr>
                    <td style="width: 40%;">Patient Name</td>
                    <td><?php echo $patient["first_name"]; ?> <?php echo $patient["middle_name"]; ?> <?php echo $patient["last_name"]; ?></td>
                </tr>

                <tr>
                    <td>Patient Age</td>
                     <td><?php echo $patient["age"];?> <?php echo $patient["age_type"];?></td>

                </tr>

                <tr>
                    <td>Gender</td>
                    <td><?php echo get_gen($patient["gender"]);?></td>
                </tr>


            </table>

        </div>

       


    </div>




    <div class="save_btn_wrapper float_left beforeunload"  style="margin-top: 0px;">

        <form name="com_call_fwd" method="post" id="">



      
    
      
            <input name="" value="Bed Book" class="inc_confirm_button accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_nonmci_withoutamb_inc" data-qr="output_position=content&cl_type=dispatch" type="button" tabindex="20">
    
             <input name="" tabindex="" value="CANCEL" class="cancel_btn style3"  type="button">
        </form>


    </div>

</div>





