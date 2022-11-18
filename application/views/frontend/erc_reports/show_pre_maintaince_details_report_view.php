<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/show_pre_maintaince_details_report" method="post" enctype="multipart/form-data" target="form_frame">
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
<?php //var_dump($data_report);?>

        <tr>         
            <td>Total Ambulances <b>Scheduled</b> For Preventive Maintenance </td> 
            <td><?php echo $data_report['till_date_schedule']; ?></td> 
            <td><?php echo $data_report['till_week_schedule']; ?></td> 
            <td><?php echo $data_report['till_month_schedule']; ?></td>
        </tr>
        <tr>         
            <td>Total Ambulances Preventive Maintenance <b>Completed</b></td> 
            <td><?php echo $data_report['till_date_completed']; ?></td> 
            <td><?php echo $data_report['till_week_completed']; ?></td> 
            <td><?php echo $data_report['till_month_completed']; ?></td>
        </tr>
        <tr>         
            <td>Total Ambulances <b>Pending</b> For Preventive Maintenance </td> 
            <td><?php echo $data_report['till_date_pending']; ?></td> 
            <td><?php echo $data_report['till_week_pending']; ?></td> 
            <td><?php echo $data_report['till_month_pending']; ?></td>
        </tr>

 
</table>