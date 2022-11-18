<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>master_report/view_pending_validation_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>  
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px; font-size: 11px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;
    foreach ($inc_data as $inc) {
       if($inc->amb_type == '1'){
        $amb_type= 'JE';
       }elseif($inc->amb_type == '2'){
            $amb_type= 'BLS';
           }
           else if($inc->amb_type == '3'){
            $amb_type= 'ALS';
           }
       if($inc->is_validate == '0'){
            $is_validate = 'Pending';
       }
       else{
        $is_validate = 'Validated';
       }
        ?>
        
        <tr style="font-size: 11px;">         
           <td><?php echo $count;?></td>
            <td><?php echo $inc->inc_ref_id; ?></td>
            <td><?php echo $inc->inc_datetime; ?></td>
            <td><?php echo $inc->epcr_date; ?></td>
            <td><?php echo $inc->epcr_time; ?></td>
            <td><?php echo $inc->amb_rto_register_no; ?></td>
            <td><?php echo $amb_type; ?></td>
            <td><?php echo $inc->hp_name; ?></td>
            <td><?php echo $inc->div_name; ?></td>
            <td><?php echo $inc->dst_name; ?></td>
            <td><?php echo strtoupper($inc->operate_by); ?></td>
            <td><?php echo ucwords($inc->operateby_full_name); ?></td>
            <td><?php echo strtoupper($inc->inc_added_by); ?></td>   
            <td><?php echo ucwords($inc->assignby_full_name); ?></td> 
            <td><?php echo $is_validate; ?></td> 
        </tr>

        <?php
        $count++;
    }
    ?>

</table>  
   