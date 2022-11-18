<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
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
    $count = 1;
    foreach ($inc_data as $inc) {
        ?>
        <tr>         
            <td><?php echo $count; ?></td> 
            <td><?php echo $inc['dist_name']; ?></td>
            <td><?php echo $inc['third_party']; ?></td>
            <td><?php echo $inc['dispatch_count']; ?></td> 
            <td><?php echo $inc['patient_count']; ?></td> 
            <td><?php echo $inc['amb_count']; ?></td> 
        </tr>
        <?php
        $count++;
    }
    ?>
       

</table>