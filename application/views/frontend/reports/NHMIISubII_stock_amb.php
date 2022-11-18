<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/NHMIISUBII_Stockposition" method="post" enctype="multipart/form-data" target="form_frame">
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
                        if($inc['inv_title'] != NULL && $inc['med_title'] != NULL){
                            $title = $inc['inv_title'].' , '.$inc['med_title'];
                        }
                        elseif($inc['inv_title'] != NULL)
                        {
                            $title = $inc['inv_title']; 
                        }
                        elseif($inc['med_title'] != NULL)
                        {
                            $title = $inc['med_title']; 
                        }
                        else{
                            echo '';
                        }
                        if($inc['as_date'] != NULL){
                            $as_date1 = date('Y-m-d ', strtotime($inc['as_date']));
                            $as_time = date('H:i:s ', strtotime($inc['as_date']));
                               $as_date =$as_date1.' '.$as_time;
                            }
                            else{
                                $as_date=" ";
                            }
                     ?>
                        <tr>  
                        
                        <td><?php echo $count; ?></td>
                        <td><?php echo $inc['amb_district'];?></td>
						<td><?php echo $inc['hp_name']?></td>
						<td><?php echo $inc['amb_rto_register_no']; ?></td>
                        <td><?php echo $inc['inc_ref_id']; ?></td>
						<td><?php echo $title ; ?></td>
                        <td><?php echo $inc['inv_type']; ?></td>
                        
						<td><?php echo $inc['total_qty']; ?></td>
						<td><?php echo $as_date; ?></td>
					</tr>
					
                    <?php 
					$count++; }?>
                      

</table>