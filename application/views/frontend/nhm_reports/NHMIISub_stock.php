<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>reports/NHMIISUB_Stockposition" method="post" enctype="multipart/form-data" target="form_frame">
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
            <td><?php echo $inc['inv_id']; ?></td>
            <td><?php echo $inc['inv_title']; ?></td>
            <td><?php echo $inc['inv_base_quantity']; ?></td>
            <td><?php echo $inc['opening_stock']; ?></td>
            <td><?php echo $inc['consume_during_month']; ?></td>
            <td><?php echo $inc['replenishment']; ?></td>
            <td><?php echo $inc['closing_stock']; ?></td>
            <td>0</td>
        </tr>

        <?php
        $count++;
    }
    ?>


</table>