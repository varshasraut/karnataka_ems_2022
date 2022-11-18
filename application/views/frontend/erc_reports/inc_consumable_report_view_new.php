<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/closure_consumable_report_new" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
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
    <?php
    $count = 1;
    if($inc_data){
    foreach ($inc_data as $inc) { ?>

        <tr>         
            <td><?php echo $inc['amb_rto_register_no']; ?></td> 
            <td><?php echo $inc['as_item_type']; ?></td> 
            <td><?php 
            $args = array('inv_type'=>$inc['as_item_type'],'inv_id'=>$inc['as_item_id']);
            echo get_inv_name_by_id($args); ?></td>
            <td><?php echo $inc['as_item_qty']; ?></td>
            <td><?php echo $inc['as_date']; ?></td>
        </tr>

        <?php
        $count++;
    }
    }
    ?>

</table>