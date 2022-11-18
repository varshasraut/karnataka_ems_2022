<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/ambulance_wise_cons_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['report_type']; ?>" name="report_type">
                <input type="hidden" value="<?php echo $report_args['amb_reg_id']; ?>" name="amb_reg_id">
                
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
    foreach ($inc_data as $inc) { ?>

        <tr>         

            <td><?php echo $inc['item_title']; ?></td> 
            <td><?php echo $inc['base_quantity']?$inc['base_quantity']:0; ?></td> 
            <td><?php echo $inc['opening_stock']?$inc['opening_stock']:0; ?></td>
            <td><?php echo $inc['consumed_stock']?$inc['consumed_stock']:0; ?></td>
            <td><?php echo $inc['balanced_stock']?$inc['balanced_stock']:0; ?></td> 


        </tr>

        <?php
        $count++;
    }
    ?>

</table>