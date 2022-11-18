

<div class="box_head text_align_center width100">
    <h4 class="txt_pro">DISPATCH AMBULANCE</h4>
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
            
            <tr>
                <td style="width: 40%;">ERO Summary :</td>
                <td><?php echo $standard_remark[0]->re_name; ?><br><?php echo $inc_ero_summary;?></td>
            </tr>
            <tr>
                <td>Address </td>
                <td><?php echo $place; ?></td>
            </tr>
            
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
                 <td><?php echo $patient["age"];?> <?php echo $patient["age_type"];?></td>
                
            </tr>
            
            <tr>
                <td>Gender</td>
                <td><?php echo get_gen($patient["gender"]);?></td>
            </tr>
           
            
        </table>
        
    </div>
        
    <div class="width100 float_right">
        
        <span class="font_weight600">Ambulance Information</span>
        
         <table class="style3">
            <?php 
           
            foreach($get_amb_details as $amb){?>
            <tr>
                <td style="width: 40%;">RTO Registation no </td>
                <td><?php echo $amb[0]->amb_rto_register_no; ?></td>
            </tr>
            
            <tr>
                <td>Mobile No</td>
                 <td><?php echo $amb[0]->amb_default_mobile;?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $amb[0]->amb_default_mobile; ?>"></a></td>
                
            </tr>
            
            <tr>
                <td>Type of Ambulance</td>
                <td><?php echo $amb[0]->ambt_name; ?></td>
            </tr>
            
            <?php } ?>
            
        </table>
        
    </div>
        
    <div class="width100 float_right">
        
        <span class="font_weight600">Current facility</span>
        
         <table class="style3">
           
            <tr>
                <td style="width: 40%;">Current facility </td>
                <td><?php if(is_array($facility)) { echo $facility[0]->hp_name; }else{
                    echo $facility;
                } ?></td>
            </tr>
            
            <tr>
                <td>facility Mobile No</td>
                 <td><?php echo $facility[0]->hp_mobile;?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $facility[0]->hp_mobile; ?>"></a></td>
                
            </tr>
            
            <tr>
                <td>facility Address</td>
                <td><?php echo $facility[0]->hp_address; ?></td>
            </tr>
            
            <tr>
                <td>Reporting Doctor</td>
                <td><?php echo $inter_details['rpt_doc']; ?></td>
            </tr>
            
            <tr>
                <td>Mobile No</td>
                <td><?php echo $inter_details['mo_no']; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $inter_details['mo_no']; ?>"></a></td>
            </tr>
            

            
        </table>
        
    </div>
    <div class="width100 float_right">
        
        <span class="font_weight600">New facility</span>
        
         <table class="style3">
          

            <tr>
                <td style="width: 40%;">New facility </td>
                <td><?php
                
                //echo $new_facility[0]->hp_name;
                if(is_array($new_facility)) { echo $new_facility[0]->hp_name; }else{
                    echo $new_facility;
                } 
                ?></td>
            </tr>
            
            <tr>
                <td>facility Mobile No</td>
                 <td><?php echo $new_facility[0]->hp_mobile;?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $new_facility[0]->hp_mobile; ?>"></a></td>
                
            </tr>
            
            <tr>
                <td>facility Address</td>
                <td><?php echo $new_facility[0]->hp_address; ?></td>
            </tr>
            
            <tr>
                <td>Reporting Doctor</td>
                <td><?php echo $inter_details['new_rpt_doc']; ?></td>
            </tr>
            
            <tr>
                <td>Mobile No</td>
                <td><?php echo $inter_details['new_mo_no']; ?><a class="click-xhttp-request soft_dial_mobile" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content&mobile_no=0<?php echo $inter_details['new_mo_no']; ?>"></a></td>
            </tr>
            

            
        </table>
        
    </div>


    </div>
    <div class="save_btn_wrapper float_left beforeunload" style="margin-top: 0px;">

        <form name="com_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_com_call" value="yes">

         
      <?php 
    
      if($cl_type["cl_type"] == ''){ ?>
            
            <input name="" value="SUBMIT" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter" data-qr="output_position=content" type="button" tabindex="20">
            
     <?php }else if($cl_type["cl_type"] == 'transfer_108'){ ?>
            
            <input name="" value="Transfer To 108" class="inc_confirm_button accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter?cl_type=transfer_108" data-qr="output_position=content&cl_type=transfer_108" type="button" tabindex="20">
            
     <?php }else if($cl_type["cl_type"] == 'transfer_102'){?>
            
         <input name="" value="Transfer To 102" class="inc_confirm_button accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter?cl_type=transfer_102" data-qr="output_position=content&cl_type=transfer_102" type="button" tabindex="20">
         
     <?php }else{ ?>
         
            <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>inc/save_inter?cl_type=forword" data-qr="output_position=content" type="button" tabindex="20">
            
      <?php } ?>
               <input name="" tabindex="" value="CANCEL" class="cancel_btn style3"  type="button">
        </form>


    </div>

</div>