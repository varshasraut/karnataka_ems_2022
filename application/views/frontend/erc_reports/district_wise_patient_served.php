<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
            <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system">
            <!-- <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system"> -->
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
    $today =0;
    $month =0;
    $total =0;
    foreach ($patient_data as $patient) {
        ?>
        <tr>         
            <td><?php echo $patient['dist_name']; ?></td> 
            <td><?php echo $patient['today']; 
            $today = $today + $patient['today'];
            ?></td>
            <td><?php echo $patient['month'];
             $month = $month+ $patient['month'];
            ?></td>
            <td><?php echo $patient['total'];
             $total = $total + $patient['total'];
            ?></td> 
        </tr>
        <?php
    }
    ?>
        <tr>         
            <td><strong>Total</strong></td> 
            <td><strong><?php echo $today; ?></strong></td>
            <td><strong><?php echo $month;?></strong></td>
            <td><strong><?php echo $total;?></strong></td> 
        </tr>

</table>