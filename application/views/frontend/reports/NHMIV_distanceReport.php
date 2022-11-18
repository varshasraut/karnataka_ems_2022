<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>reports/NHM4_Distance_report" method="post" enctype="multipart/form-data" target="form_frame">
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
    foreach ($inc_data as $inc) {
        ?>
        <tr>  

            <td><?php echo $count; ?></td>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['amb_base_location']; ?></div>
           <!-- <td><?php echo $inc['Start_date']; ?></td>
            <td><?php echo $inc['END_day']; ?></td>-->
            <td><?php echo $inc['total_km']; ?></td>
            <td><?php echo $inc['total_calls']; ?></td>
            <td></td>

        </tr>

        <?php $count++;
    }
    ?>


</table>