
<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/export_epcr_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">

                    <tr>                              
                        <?php foreach($header as $heading){?>
                        <th style="line-height: 20px;" nowrap><?php echo $heading;?></th>
                        <?php }?>
                    </tr>
                    <?php foreach($inc_data as $inc){ 
                                  
                        ?>
                         <tr>         
                        
                        <td><?php echo $inc['date'];?></td>
                        <td><?php echo $inc['inc_ref_id'];?></td> 
                        <td><?php echo $inc['response_time'];?></td> 
                        <td><?php echo $inc['amb_rto_register_no'];?></td>
                        <td><?php echo ucwords($inc['patient_name']);?></td>
                        <td><?php echo $inc['district'];?></td> 
                        <td><?php echo $inc['cty_name'];?></td> 
                        <td><?php echo $inc['locality'];?></td> 
                        
                        <td><?php echo $inc['provier_img'];?></td> 
                        <td><?php echo $inc['base_location'];?></td> 
                         <td><?php echo $inc['amb_base_location'];?></td> 
                         <td><?php echo ucwords($inc['operate_by']);?></td> 
                        <td><?php echo $inc['start_odo'];?></td> 
                        <td><?php echo $inc['end_odo'];?></td> 
                        <td><?php echo $inc['remark'];?></td> 
                        <td><?php echo $inc['total_km'];?></td> 
                        
                         </tr>
                    <?php }?>

</table>