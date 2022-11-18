<div class="width_10 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/details_amb_onroad_offroad_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['dist']; ?>" name="onroad_report_type_dist">
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
    foreach ($inc_data as $key => $inc) {
       ($inc);
        ?>
        <tr>         
            <td><?php echo $count; ?></td>
            <td><?php echo $inc->div_name; ?></td>
            <td><?php echo $inc->dst_name; ?></td>
            <td><?php echo $inc->mt_amb_no; ?></td>           
            <td><?php echo $inc->ambt_name; ?></td>
            <td><?php if($inc->mt_stnd_remark == 'Ambulance_offroad'){ echo "Ambulance Off road"; }  ?></td>
            <td><?php echo date('Y-m-d',strtotime($inc->mt_offroad_datetime)); ?></td>
            <td><?php echo date('H:i:s',strtotime($inc->mt_offroad_datetime)); ?></td>
            <td><?php if($inc->mt_on_stnd_remark == 'ambulance_onroad'){ echo "Ambulance On road"; } ?></td>
            <td><?php echo date('Y-m-d',strtotime($inc->mt_onroad_datetime)); ?></td>
            <td><?php echo date('H:i:s',strtotime($inc->mt_onroad_datetime)); ?></td>
            <td><?php echo $inc->mt_remark; ?></td>
            <td><?php echo $inc->mt_added_date; ?></td>
            <td><?php echo $inc->mt_modify_date; ?></td>

        </tr>
        <?php
        $count++;
    }
    ?>

</table>