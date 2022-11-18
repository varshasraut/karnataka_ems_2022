<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
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
        // var_dump($inc);
        ?>

        <tr>         
        <td><?php echo $count; ?></td>
            <td><?php echo $inc['ff_gen_id']; ?></td> 
            <td><?php echo $inc['div_name']; ?></td>
            <td><?php echo $inc['District']; ?></td> 
            <td><?php echo $inc['ff_Ambulance_No']; ?></td> 
            <td><?php echo $inc['amb_default_mobile']; ?></td> 
            <td><?php echo $inc['amb_by_type']; ?></td> 
            <td><?php echo $inc['filling_case']; ?></td> 
            <td><?php echo $inc['base_location']; ?></td>
            <td><?php echo $inc['filling_date_time']; ?></td>
            <td><?php echo $inc['pilot_id']; ?></td>
            <td><?php echo $inc['pilot_name']; ?></td>
            <td><?php echo $inc['pilot_number']; ?></td>
            <td><?php echo $inc['fuel_station_name']; ?></td>
            <td><?php echo $inc['ff_other_fuel_station']; ?></td>
            <td><?php echo $inc['ff_fuel_mobile_no']; ?></td>
            <td><?php echo $inc['previous_odometer_filling']; ?></td> 
            <td><?php echo $inc['previous_odometer']; ?></td> 
            <td><?php echo $inc['refueling_odometer']; ?></td> 
            <td><?php echo $inc['end_odometer_after_fueling']; ?></td> 
            <td><?php echo $inc['total_KM_run']; ?></td>
            <td><?php echo $inc['fuel_filling_LTR']; ?></td>
            <td><?php echo $inc['KMPL']; ?></td>
            <td><?php echo $inc['fuel_rate']; ?></td> 
            <td><?php echo $inc['fuel_mount']; ?></td> 
            <td><?php echo $inc['payment_mode'];; ?></td> 
            <td><?php echo $inc['voucher_Card_No']; ?></td> 
            <td><?php echo $inc['ff_standard_remark']; ?></td> 
            <td><?php echo $inc['ff_other_remark']; ?></td> 
            <td><?php echo $inc['update_remark']; ?></td> 
            <td><?php echo $inc['ff_case_type_remark']; ?></td> 
            <td><?php echo ucwords($inc['enter_by']); ?></td> 
            <td><?php echo $inc['enter_by_name']; ?></td> 
            <td><?php echo $inc['update_date_time']; ?></td> 
             


        </tr>

        <?php
        $count++;
    }
    ?>

</table>