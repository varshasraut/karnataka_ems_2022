<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>reports/save_export_inc" method="post" enctype="multipart/form-data" target="form_frame">
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
    <?php foreach ($inc_data as $inc) { ?>
        <tr>         

            <td><?php echo $inc['inc_id']; ?></td>
            <td><?php echo $inc['clr_mobile']; ?></td> 

            <td><?php echo $inc['transport_amb']; ?></td> 
            <td><?php echo $inc['transport_amb_no']; ?></td> 
            <td><?php echo $inc['patient_name']; ?></td> 
            <td><?php echo $inc['patient_age']; ?></td> 
            <td><?php echo $inc['ct_type']; ?></td> 

            <td><?php echo $inc['summary']; ?></td> 
            <td><?php echo $inc['operator_id']; ?></td> 
            <td><?php
                if ($inc['incis_deleted'] == '0') {
                    $status = 'Active';
                } else if ($inc['incis_deleted'] == '1') {
                    $status = 'Deleted';
                } else if ($inc['incis_deleted'] == '2') {
                    $status = 'Terminated';
                }
                echo $status;
                ?></td> 


        </tr>
    <?php } ?>

</table>