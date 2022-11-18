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
$srno = 1;
    foreach ($inc_data as $inc) {
        
        ?>
        <tr>       
        <td><?php echo $srno; ?></td>   
            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $inc['inc_datetime']; ?></td>
            <td><?php echo $inc['clr_mobile']; ?></td>
            <td><?php echo $inc['clr_fullname']; ?></td> 
            <td><?php echo $inc['fc_call_type']; ?></td>
            <td><?php
                if ($inc['fc_feedback_type'] == 'negative_feedback') {
                    echo "Negative Feedback";
                } else {
                    echo "Positive Feedback";
                }
                ?></td>
            <td><?php echo $inc['sum_que_ans1']; ?></td>
            <td><?php echo $inc['sum_que_ans2']; ?></td>
            <td><?php echo $inc['sum_que_ans3']; ?></td>
            <td><?php echo $inc['sum_que_ans4']; ?></td>
            <td><?php echo $inc['fc_standard_type']; ?></td>
            <td><?php echo $inc['fc_employee_remark']; ?></td>
            <td><?php echo $inc['fdsr_added_by']; ?></td>
            <td><?php echo $inc['fdsr_datetime']; ?></td>

        </tr>
        <?php
        $srno++;
    }
    ?>

</table>