<div class="box_head text_align_center width100">
    <h3 class="txt_pro">CORONA CALLS</h3>
</div>

<div class="confirm_save width100">

    <div id="summary_div">
        
        <div class="width100 float_right">
        
            <span class="font_weight600">Incident Information</span>

            <table class="style3"  style="margin-bottom: 10px;">
               <tr>
                   <td style="width: 40%;">Incident Id </td>
                   <td><?php echo $inc_ref_id; ?></td>

               </tr>
               <tr>

                    <td>Address </td>
                    <td><?php echo  $patient["address"]; ?></td>
                </tr>
               <!-- <tr>
                    <td>ERO Summary :</td>
                     <td><?php echo $standard_remark;?></td>

                </tr>
                  <tr>
                    <td>ERO Note :</td>
                     <td><?php  echo $patient["inc_ero_summary"];?></td>

                </tr>-->

            </table>

        </div>
        <div class="width100 float_right">

            <span class="font_weight600">Patient Information</span>

             <table class="style3"  style="margin-bottom: 10px;">

                <tr>
                    <td style="width: 40%;">Patient Name</td>
                    <td><?php echo $patient["full_name"]; ?> <?php echo $patient["middle_name"]; ?> <?php echo $patient["last_name"]; ?></td>
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
    <div class="save_btn_wrapper float_left beforeunload"  style="margin-top: 0px;">

        <form name="com_call_fwd" method="post" id="">
           <?php 

           if($cl_type == 'transfer_hd'){ ?>
                <input name="" value="Transfer to HD" class="inc_confirm_button accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>corona/save_corona?cl_type=transfer_hd" data-qr="output_position=content&cl_type=transfer_hd" type="button" tabindex="20">
                 <?php }else{ ?>
             <input name="" value="Save" class="inc_confirm_button accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>corona/save_corona" data-qr="output_position=content" type="button" tabindex="20">
                   
                 <?php } ?>

                <input name="" tabindex="" value="CANCEL" class="cancel_btn style3"  type="button">
          
        </form>


    </div>

</div>





