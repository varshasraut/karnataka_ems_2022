<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/response_time_reports_108" method="post" enctype="multipart/form-data" target="form_frame">
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
    foreach ($inc_data as $key=>$inc) {
        ?>

        <tr>         
            <td><?php echo $key+1; ?></td> 
            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $inc['inc_type']; ?></td>           
            <td><?php echo $inc['inc_date']; ?></td> 
            <td><?php echo $inc['inc_place']; ?></td> 
            <td><?php echo $inc['inc_district']; ?></td> 
            <td><?php echo $inc['closer_date']; ?></td>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['amb_base_location']; ?></td>
            <td><?php echo $inc['amb_district']; ?></td>
            <td><?php echo $inc['caller_name']; ?></td>
            <td><?php echo $inc['patient_name']; ?></td> 
            <td><?php echo $inc['inc_complaint']; ?></td> 
            <td><?php echo $inc['base_location']; ?></td> 
            <td><?php echo $inc['hp_district']; ?></td> 
            <td><?php echo $inc['inc_recive_date']; ?></td> 
            <td><?php echo $inc['inc_disconect_date']; ?></td> 
            <td><?php
           // var_dump($inc['start_from_base']);
                if ($inc['start_from_base'] != '' && $inc['start_from_base'] != '0000-00-00 00:00:00') {
                    echo $inc['start_from_base'];
                    //echo date("H:i:s", strtotime($inc['start_from_base']));
                } else {
                    echo '-';
                }
                ?>
            </td> 
            <td><?php
                if ($inc['dp_on_scene'] != '' && $inc['dp_on_scene'] != '0000-00-00 00:00:00') {
                    echo $inc['dp_on_scene'];
                } else {
                    echo '-';
                }
                ?>
            </td> 
             <td><?php
                if ($inc['dp_reach_on_scene'] != '' && $inc['dp_reach_on_scene'] != '0000-00-00 00:00:00') {
                    echo $inc['dp_reach_on_scene'];
                } else {
                    echo '-';
                }
                ?></td> 

            <td><?php
                if ($inc['dp_hosp_time'] != '' && $inc['dp_hosp_time'] != '0000-00-00 00:00:00') {
                    echo $inc['dp_hosp_time'];
                } else {
                    echo '-';
                }
                ?></td> 
             <td><?php
                if ($inc['dp_hand_time'] != '' && $inc['dp_hand_time'] != '0000-00-00 00:00:00') {
                    echo $inc['dp_hand_time'];
                } else {
                    echo '-';
                }
                ?></td>
           <td><?php
               
                 if ($inc['dp_back_to_loc'] != '' && $inc['dp_back_to_loc'] != '0000-00-00 00:00:00') {
                    echo $inc['dp_back_to_loc'];
                } else {
                    echo '-';
                }
                ?></td> 
            <td><?php
            $duration = date('H:i:s', strtotime($inc['responce_time']));
                echo $inc['responce_time']; ?></td> 
            <td><?php echo  $inc['division']; ?></td> 
            <td><?php echo  $inc['inc_area_type']; ?></td> 
            <td><?php echo $inc['amb_working_area']; ?></td> 
            <td><?php echo $inc['total_km']; ?></td> 
            
            <td><?php
                if ($inc['responce_time_remark'] != '') {
                    echo $inc['responce_time_remark'];
                }else{
                    echo '-';
                }
                ?>
            </td> 
            <td><?php echo ucwords($inc['end_odometer_remark']); ?></td> 
<!--            <td><?php echo ucwords($inc['inc_area_type']); ?></td> 
            <td><?php echo ucwords($inc['operate_by']); ?></td> 
            <td><?php echo ucwords($inc['inc_added_by']); ?></td> -->
            

        </tr>

        <?php
        $count++;
    }
    ?>

</table>