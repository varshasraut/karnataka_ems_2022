<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/closure_consumable_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system">
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
    if($inc_data){
    foreach ($inc_data as $inc) { ?>

        <tr>         

            <td><?php echo $inc['inc_ref_id']; ?></td> 
            <td><?php echo $inc['inc_date']; ?></td> 
            <td><?php echo $inc['closer_date']; ?></td>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['baselocation']; ?></td>
            <td><?php echo $inc['dst_name']; ?></td>
            <td><?php echo $inc['ptn_id']; ?></td> 
            <td><?php echo $inc['patient_name']; ?></td> 
            <td><?php echo $inc['provier_img']; ?></td> 
            <td><?php echo $inc['consumable_quantity']; ?></td> 
            <td><?php echo $inc['other_units']; ?></td>
            <td><?php echo $inc['non_consumable_quantity']; ?></td>
             <td><?php echo $inc['other_non_units']; ?></td>
            <td><?php echo $inc['medicine_quantity']; ?></td>
            <td><?php echo $inc['thirdparty']; ?></td>
            <td><?php echo ucwords($inc['operate_by']); ?></td> 


        </tr>

        <?php
        $count++;
    }
    }
    ?>

</table>