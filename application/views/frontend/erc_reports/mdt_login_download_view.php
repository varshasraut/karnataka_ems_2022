<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>master_report/mdt_login_report_view" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>  
<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px; font-size: 11px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;    
        ?>
        
        <tr style="font-size: 11px;">         
           <td><?php echo $count;?></td>
            <td><?php echo $log->vehicle_no; ?></td>
            <td><?php echo $log->amb_default_mobile; ?></td>
            <td><?php echo $log->hp_name; ?></td>
            <td><?php echo $log->ambt_name; ?></td>
            <td><?php echo $log->dst_name; ?></td>
            <td><?php echo $log->div_name; ?></td>
            <td><?php echo $log->login_time; ?></td>
            <td><?php echo $log->login_type; ?></td>
            <td><?php echo $log->status; ?></td>
             
        </tr>

        <?php
        $count++;
    ?>

</table>   