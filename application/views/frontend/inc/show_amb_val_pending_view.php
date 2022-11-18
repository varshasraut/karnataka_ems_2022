<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Ambulance Validation Pending</h3>
</div>
 <div class="width100">
                <div class="width100 float_left">
       <?php // var_dump($amb_reg_no);die();       ?>         
                        <div class="field_lable float_left width33 strong"><label for="informed_to">Ambulance Registration No<span class="md_field"></span></label></div>

                        <div class="filed_input float_left width50" >
                            <?php echo $amb_reg_no; ?>
                        </div>
                    </div>
                    <div class="width100 float_left">
                        <div class="field_lable float_left width33 strong"><label for="mt_estimatecost">Base Location</label></div>
                        <div class="filed_input float_left width50" >
                        <?=@$amb[0]->hp_name;?>
                        </div>
                    </div>
                </div>
<table class="table report_table">
    <tr>                              
        <th style="line-height: 20px;">Incident Id</th>
        <th style="line-height: 20px;">Incident Date Time</th>
        <?php if($clg_group != 'UG-DM' && $clg_group != 'UG-ZM' && $clg_group != 'UG-REMOTE-SUPER-ADMIN'){
                                                        ?>
        <th style="line-height: 20px;">Validation</th>
        <?php } ?>
    </tr>
    <?php foreach($pending_incident as $incident){?>
    <tr>   
        
        <td><?php echo $incident->inc_ref_id;?></td> 
        <td><?php echo $incident->inc_datetime;?></td>
        <?php if($clg_group != 'UG-DM' && $clg_group != 'UG-ZM' && $clg_group != 'UG-REMOTE-SUPER-ADMIN'){
                                                        ?>
        <td><a href="{base_url}job_closer/epcr?inc_id=<?php echo base64_encode($incident->inc_ref_id); ?>" class="btn float_left click-xhttp-request onpage_popup " data-qr="output_position=content" data-popupwidth="1500" data-popupheight="850" >Validation</a></td>
        <?php } ?>
    </tr>
    <?php } ?>

</table>