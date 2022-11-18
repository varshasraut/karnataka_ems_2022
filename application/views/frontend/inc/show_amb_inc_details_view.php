<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Ambulance Closure Pending</h3>
</div>
 <div class="width100">
                <div class="width100 float_left">
                        
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
    </tr>
    <?php foreach($pending_incident as $incident){?>
    <tr>   
        
        <td><?php echo $incident->inc_ref_id;?></td> 
        <td><?php echo $incident->inc_datetime;?></td>
    </tr>
    <?php } ?>

</table>