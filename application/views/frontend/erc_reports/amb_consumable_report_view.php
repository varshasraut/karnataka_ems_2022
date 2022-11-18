<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $function_name;?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['report_type']; ?>" name="report_type">
                <input type="hidden" value="<?php echo $report_args['hpcl_amb']; ?>" name="hpcl_amb">
                <input type="hidden" value="<?php echo $report_args['cons_dis']; ?>" name="cons_dis">
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
       // var_dump($inc);
        ?>

        <tr>         
            <td><?php echo $inc['Item_Code']; ?></td> 
            <td><?php echo $inc['item_title']; ?></td> 
            <td><?php echo $inc['consumed_stock']?$inc['consumed_stock']:0; ?></td>
        </tr>

        <?php
        $count++;
    }
    ?>

</table>