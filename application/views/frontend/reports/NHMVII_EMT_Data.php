<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/NHM7_EMT_Staff_data" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
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
					$count=1;
                    foreach($inc_data as $inc){
						//var_dump($inc);
                        
                     ?>
                        <tr>  
                        
                        <td><?php echo $count; ?></td>
                        <td><?php echo $inc['dst_name']; ?></td>
						<td><?php echo ucwords($inc['clg_first_name'].' '.$inc['clg_mid_name'].' '.$inc['clg_last_name']); ?></td>
						<td><?php echo $inc['clg_emso_id']; ?></td>
						<td><?php echo $inc['patient_count']; ?></td>
					</tr>
					
                    <?php 
					$count++; }?>
                      

</table>