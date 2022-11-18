<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                        
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                           <input type="hidden" value="<?php echo $report_args['system'];?>" name="system">
                            <input type="hidden" value="<?php echo $report_args['item_type'];?>" name="item_type">
                         
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
    </tr>

    <?php  ?>
    <?php 
    if($hpcl_data){
      
    foreach ($hpcl_data as $key=>$hpcl) { 
        
        //if($hpcl->ind_item_type == 'CA'){
            $item_name = get_inv_name(array('inv_id'=>$hpcl->ind_item_id,'inv_type'=>$hpcl->ind_item_type));
        //}
     
        ?>
            <tr>  
                <td><?php echo $key+1;  ?></td>
                <td><?php echo $hpcl->req_amb_reg_no; ?></td>
                <td><?php echo $hpcl->hp_name; ?></td>
                <td><?php echo $hpcl->dst_name; ?></td>
                <td><?php echo $hpcl->ind_item_type; ?></td>
                <td><?php echo $item_name; ?></td>
                <td><?php echo $hpcl->ind_quantity; ?></td>
                <td><?php echo $hpcl->req_date; ?></td>
                <td><?php echo $hpcl->ind_dis_qty; ?></td>
                <td><?php echo $hpcl->req_dis_date; ?></td>
                <td><?php echo $hpcl->ind_rec_qty; ?></td>
                <td><?php echo $hpcl->req_rec_date; ?></td>
            </tr>
<?php }?>
            
<?php 
    }else{
    ?>
    <tr> 
     <td  style="text-align: center;" colspan="17">Record Not Found</td>
     <tr> 
    <?php
} ?>


</table>