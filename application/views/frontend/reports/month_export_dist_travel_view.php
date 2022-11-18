<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>reports/save_export_dist_travel" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system">
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
        //var_dump($inc);
        ?>
        <tr>  

            <td><?php echo $inc['month']; ?></td>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['min_odometer']; ?></td>
            <td><?php echo $inc['max_odometer']; ?></td>
            <td><?php echo $inc['total_km']; ?></td>
            <td><?php echo $inc['avg_km']; ?></td>
            

        </tr>
    <?php } ?>


</table>