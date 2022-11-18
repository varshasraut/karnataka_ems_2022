<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['clg_group']; ?>" name="department_name">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['provider_imp']; ?>" name="provide_imp">
                <input type="hidden" value="<?php echo $report_args['system_type']; ?>" name="system_type">

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
    $count=1;
    $total_patient=0;
    $total_month=0;
    $total_till_date=0;

    foreach ($inc_data as $inc) {
        //var_dump($inc_data);
        ?>
        <tr>         
            <td><?php echo $count; ?></td> 
            <td><?php echo $inc['district']; ?></td>
            <td><?php echo $inc['total_patient']; $total_patient= $total_patient + $inc['total_patient'];?></td>
            <td><?php echo $inc['total_month']; $total_month= $total_month + $inc['total_month'];?></td> 
            <td><?php echo $inc['total_till_date']; $total_till_date= $total_till_date + $inc['total_till_date']; ?></td>
           

        </tr>
        <?php
        $count++;
    }
    ?>
     <tr>
<td><strong>Total<strong></td>
<td><strong><?php ?></strong></td>
<td><strong><?php echo $total_patient; ?></strong></td>
<td><strong><?php echo $total_month; ?></strong></td>
<td><strong><?php echo $total_till_date; ?></strong></td>
</tr>
</table>