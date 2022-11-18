<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
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

<tr>         <td><?php echo $count++; ?></td> 
            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $inc['inc_datetime']; ?></td> 
            <td><?php echo $inc['inc_date']; ?></td>
            <td><?php echo $inc['inc_purpose']; ?></td>
            <!--<td><?php //echo $inc['parameter']; ?></td>-->
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['amb_type']; ?></td>

            <td><?php echo $inc['amb_base_location']; ?></td> 
           <!-- <td><?php echo $inc['wrd_location']; ?></td>-->
            <td><?php echo $inc['inc_ref_id'].''.$inc['patient_id']; ?></td>
            <td><?php echo $inc['amb_district']; ?></td>
            <td><?php echo $inc['patient_id']; ?></td>
            <td><?php echo $inc['patient_name']; ?></td> 
            <td><?php echo $inc['ptn_age']; ?></td> 
            <td><?php echo $inc['ptn_gender']; ?></td> 
            <td><?php echo $inc['caller_name']; ?></td> 
            <td><?php echo $inc['caller_mobile']; ?></td> 
            <td><?php echo $inc['district']; ?></td> 
            <td><?php echo $inc['locality']; ?></td> 
            <td><?php echo $inc['inc_area_type']; ?></td> 
            <td><?php echo $inc['emt_id']; ?></td> 
            <td><?php echo $inc['emt_name']; ?></td>
            <td><?php echo $inc['pilot_id']; ?></td> 
            <td><?php echo $inc['pilot_name']; ?></td>
            <td><?php echo $inc['level_type']; ?></td> 
            <td><?php echo $inc['ercp_advice']; ?></td>
            <td><?php echo $inc['ercp_advice_Taken']; ?></td>
            <!--<td><?php //echo $inc['case_name']; ?></td>-->
            <td><?php echo $inc['provier_img']; ?></td> 
            <td><?php echo $inc['other_provider_img']; ?></td> 
            <td><?php echo $inc['hos_district']; ?></td> 
            <td><?php echo $inc['base_location']; ?></td>   
            <td><?php echo $inc['hospital_code']; ?></td>   
            <td><?php echo $inc['other_receiving_host']; ?></td> 
            <td><?php echo $inc['start_odo']; ?></td> 
            <td><?php echo $inc['start_odo']; ?></td> 
            <td><?php echo $inc['scene_odometer']; ?></td> 
            <td><?php echo $inc['hospital_odometer']; ?></td> 
            <td><?php echo $inc['end_odo']; ?></td> 
            <td><?php echo $inc['total_km']; ?></td> 
            <td><?php echo $inc['responce_time_remark']; ?></td> 
            <td><?php echo $inc['odo_remark']; ?></td> 
            <td><?php echo $inc['remark']; ?></td> 
            <td><?php echo $inc['patinent_availability_status']; ?></td> 
            <td><?php echo ucwords($inc['dco_id']); ?></td>
            <td><?php echo ucwords($inc['ero_id']); ?></td>
            <!--<td><?php //echo $inc['thirdparty_name'];?></td>-->
            <td><?php echo $inc['b12_type'];?></td>
            <td><?php echo $inc['validation_done'];?></td>
            <td><?php echo $inc['is_validate'];?></td>
            <td><?php echo $inc['valid_remark'];?></td>
            <td><?php echo $inc['validate_date'];?></td>
        </tr>

        <?php
        $count++;
    }
    ?>

</table>