

<div class="box_head text_align_center width100">
    <h3 class="txt_pro">FollowUP Call</h3>
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
        
         <table class="style3">
          
            <tr>
                <td style="width: 40%;">Incident Id </td>
                <td><?php echo $inc_ref_id; ?></td>
                
            </tr>
            <tr>
                <td style="width: 40%;">Chief Complaint </td>
                <td><?php echo $nature[0]->ct_type; ?></td>
            </tr>
            
            <tr>
                <td>Address </td>
                <td><?php echo $place; ?></td>
            </tr>
            
            <tr>
                <td>ERO Summary :</td>
                 <td><?php echo $inc_ero_summary;?></td>
                
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
            
        </table>
        
    </div>

<div class="width100 float_right">
        
        <span class="font_weight600">Patient Information</span>
        
         <table class="style3">

            <tr>
                <td style="width: 40%;">Patient Name</td>
                 <td><?php echo $patient["first_name"]; ?> <?php echo $patient["middle_name"]; ?> <?php echo $patient["last_name"]; ?></td>
            </tr>
            
            <tr>
                <td>Patient Age</td>
                 <td><?php echo $patient["age"];?></td>
                
            </tr>
            
            <tr>
                <td>Gender</td>
                <td><?php echo get_gen($patient["gender"]);?></td>
            </tr>
           
            
        </table>
        
    </div>
        
  


    </div>


    <form name="com_call_fwd" method="post" id="dispatch_call_forms">
        <div class="form_field width100">
            <div class="label blue float_left width30">Followup Reason<span class="md_field">*</span></div>
            <div class="input nature top_left float_left width_66">
            <input type="text" id="followup_reason" name="followup_reason" data-value="<?php if($inc_details['inc_ero_standard_summary'] != ''){ get_ero_remark($inc_details['inc_ero_standard_summary_id']); } ?>" value="<?= @$inc_details['inc_ero_standard_summary_id']; ?>" class="mi_autocomplete filter_required width2"  data-href="<?php echo base_url(); ?>auto/get_ero_standard_summary_followup?call_type=NON_MCI"  placeholder="ERO Folowup Remark" data-errors="{filter_required:'Please select ERO Summary from dropdown list'}" data-callback-funct="ero_standard_summary_change_followup" TABINDEX="8" data-qr="call_type=NON_MCI" >
                         
                         <!--<select name="followup_reason" id="followup_reason" class="filter_required" data-errors="{filter_required:'Please select Termination Reason from dropdown list'}">
                         <option value="">Select Followup Reason</option>
                             <option value="Ambulance Unavability">Ambulance Unavability</option>
                             <option value="Already Dispatched">Patient Confused</option>
                             <option value="Already Dispatched">Beds not vailable in Hospital</option>
                             <option value="Other">Other</option>
                         </select>-->
            </div>
        </div>
        <div class="form_field width100 hide" id="followup_reason_other">
            <div class="label blue float_left width30">Other Followup Reason</div>
            <div class="input nature top_left float_left width_66">
                <input type="text" name="followup_reason_other"  value="" class="" placeholder="Other Followup Reason" data-errors="{filter_required:'Other Termination Reason is required'}"   TABINDEX="73">
            </div>
        </div>


        <div class="beforeunload text_center">
            <input type="hidden" name="fwd_com_call" value="yes">
            <input name="" value="Forword In followup Queue" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_followup_nonmci_inc?cl_type=forword" data-qr="output_position=content" type="button" tabindex="20">
            <input name="" tabindex="" value="CANCEL" class="cancel_btn style3"  type="button">
        </div>

    </form>
</div>





