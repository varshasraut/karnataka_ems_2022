<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['district_code']; ?>" name="incient_district">
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

            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $inc['fc_assign_time']; ?></td> 
            <td><?php echo $inc['clr_mobile']; ?></td>
            <td><?php echo $inc['clr_fullname']; ?></td>
            <td><?php echo $inc['dst_name']; ?></td>
            <td><?php echo get_cheif_complaint($inc['inc_complaint']); ?></td>
            <td><?php echo $inc['fi_ct_name']; ?></td> 
            <td><?php echo $inc['fire_station_name']; ?></td> 
            <td><?php echo $inc['f_station_mobile_no']; ?></td> 
            <td><?php echo $inc['fc_call_receiver_name']; ?></td>
            <td><?php echo $inc['fc_assign_call']; ?></td>
            <td><?php echo $inc['inc_dispatch_time']; ?></td> 


        </tr>

        <?php
        $count++;
    }
    ?>

</table>