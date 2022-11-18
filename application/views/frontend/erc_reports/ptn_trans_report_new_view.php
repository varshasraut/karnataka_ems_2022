<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/save_export_tans_patient_new" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['system'];?>" name="system">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">

                    <tr>                              
                        <?php foreach($header as $heading){?>
                        <th style="line-height: 20px;"><?php echo $heading;?></th>
                        <?php }?>
                    </tr>
                             
                    <?php 
                
                    $grand_total = 0;
                    foreach($inc_data as $inc){ ?>
                      
                      <tr>     
                        <td><?php echo $inc->call_purpose;?></td>
                        <td><?php echo $inc->total_call;
                        $grand_total = $grand_total + $inc->total_call;
                        ?></td>
                   
                       </tr>  
                        
                    <?php } ?>
                        
                         <tr>
                             <td><strong>Grand Total</strong></td>
                             <td><strong><?php echo $grand_total;?></strong></td>
                         </tr>

</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>