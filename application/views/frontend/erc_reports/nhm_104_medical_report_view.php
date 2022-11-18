<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <!-- <input type="hidden" value="<?php echo $report_args['district_code']; ?>" name="incient_district"> -->
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
        // print_r($inc);
        ?>
        <tr>  
            <td style="text-align: center;"><?php echo $inc['sr_no']; ?></td>        
            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $inc['recieve_time']; ?></td> 
            <td><?php echo $inc['end_time']; ?></td>
            <td><?php echo $inc['call_time']; ?></td>
            <td><?php echo $inc['ero_summary']; ?></td>
            <td><?php echo $inc['std_remark']; ?></td>
            <td><?php echo $inc['call_typ']; ?></td>
            <td><?php echo $inc['cheif_cmp']; ?></td>
            <td><?php echo $inc['ero_fullname']; ?></td>
            <td><?php echo $inc['added']; ?></td>
            <td><?php echo $inc['clr_no']; ?></td>
            <td><?php echo $inc['clr_fullname']; ?></td>
            <td><?php echo $inc['additional_info']; ?></td>
            <td><?php echo $inc['impression']; ?></td>
            <td><?php echo $inc['remark']; ?></td>   
            <td><?php echo $inc['ercp_cmp']; ?></td>
            <td><?php echo $inc['ercp_name']; ?></td>           
            <td><?php echo $inc['added_by_ercp']; ?></td>  
        </tr>

        <?php
        $count++;
    }
    ?>
</table>