<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['clg_group']; ?>" name="department_name">
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
    foreach ($inc_data as $inc) {
        ?>
        <tr>         
            <td><?php echo $inc['gc_date_time']; ?></td> 
            <td><?php echo $inc['gc_inc_ref_id']; ?></td>
            <td><?php
                if ($inc['gc_complaint_type'] == 'e-complaint') {
                    echo "E Complaint";
                } else if ($inc['gc_complaint_type'] == 'negative_news') {
                    echo "Negative News";
                } else if ($inc['gc_complaint_type'] == 'external') {
                    echo "External";
                } else if ($inc['gc_complaint_type'] == 'internal') {
                    echo "Internal";
                }
                ?></td>
            <td><?php
                if ($inc['gc_closure_status'] == 'complaint_pending') {
                    echo "Complaint Pending";
                } else if ($inc['gc_closure_status'] == 'complaint_close') {
                    echo "Complaint Close";
                } else if ($inc['gc_closure_status'] == 'complaint_open') {
                    echo "Complaint Open";
                }
                ?></td>
            <td><?php
                if ($inc['gc_closed_date'] == '0000-00-00 00:00:00' || $inc['gc_closed_date'] == '') {
                    echo '-';
                } else {
                    echo $inc['gc_closed_date'];
                }
                ?></td> 
            <td><?php echo $inc['gc_added_by']; ?></td>
            <td><?php
                if ($inc['gc_close_by'] == '') {
                    echo '-';
                } else {
                    echo $inc['gc_close_by'];
                }
                ?></td> 


        </tr>
        <?php
    }
    ?>

</table>