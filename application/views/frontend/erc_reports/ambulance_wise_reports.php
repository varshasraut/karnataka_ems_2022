<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/ambulance_report_form_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $amb_type; ?>" name="amb_type">
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

            <?php if($amb_type == '2'){?>
            <td><?php echo $inc['month']; ?></td>
            <?php } ?>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['min_odometer']; ?></td>
            <td><?php echo $inc['max_odometer']; ?></td>
            <td><?php echo $inc['max_odometer'] - $inc['min_odometer']; ?></td>
            <td><?php echo $inc['avg_km']; ?></td>
        </tr>
    <?php } ?>


</table>