<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>master_report/ambulance_dist_travel_filter" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <!-- <input type="hidden" value="<?php echo $amb_type; ?>" name="amb_type"> -->
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
    foreach ($inc_data as $inc) {
        ?>
        <tr>  

      
            <td><?php echo $inc['count']; ?></td>
            <td>Category <?php echo $inc['amb_category']; ?></td>
            <td><?php echo $inc['chases_no']; ?></td>
            <?php if($inc['vendor_name'] != ''){?>
            <td><?php echo $inc['vendor_name']; ?></td>
            <?php } else{?>
            <td><?php echo '-' ?></td>
            <?php } ?>
            <td><?php echo $inc['ambt_name']; ?></td>
            <td><?php echo $inc['ar_name']; ?></td>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['max_odometer'] - $inc['min_odometer']; ?></td>
            <td><?php echo $inc['rate']; ?></td>
            <td><?php echo $inc['total_amount']; ?></td>
        </tr>
    <?php } ?>


</table>