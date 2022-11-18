<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                     <?php if($function_name){
                        $submit_function = 'annex_biii_patient_details';
                     }else{
                        $submit_function = 'save_export_patient';
                     }  ?>
                    <form action="<?php echo base_url(); ?>reports/<?php echo $submit_function;?>" method="post" enctype="multipart/form-data" target="form_frame">
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
                        <th style="line-height: 20px;"><?php echo $heading;?></th>
                        <?php }?>
                    </tr>
                    <?php foreach($inc_data as $inc){
                        //var_dump($inc);die;
                            $duration = date('H:i:s', strtotime($inc['responce_time']));
                     ?>
                         <tr>    
                             <?php if($inc['inc_ref_id']){?>
                        <td><?php echo $inc['inc_ref_id'];?></td>
                             <?php } ?>
                        <td><?php echo $inc['clr_mobile'];?></td>
                        <td><?php echo $inc['call_dis_time'];?></td> 
                        <td><?php echo $inc['amb_reach_time'];?></td>
                        <td><?php echo $duration;?></td>
                        <td><?php echo $inc['respond_amb_no'];?></td> 
                        <td><?php echo $inc['respond_amb_base'];?></td> 
                        <td><?php echo $inc['inc_address'];?></td> 
                        <td><?php echo $inc['hospital'];?></td> 
<!--                        <td><?php echo $inc['code_no_hos'];?></td> -->
                        <td><?php echo $inc['amb_type'];?></td> 
                        
                         </tr>
                    <?php }?>

</table>