<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/drop_back_dist_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $amb_type; ?>" name="amb_type">
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
    $get_cl_count =0;
     $patient=0;
     $month=0;
     $total=0;

    foreach ($inc_data as $inc) {
       

        ?>
        <tr>  
       
           
            <td><?php echo $inc['dist_name']; ?></td>
            <td><?php echo $inc['get_cl_count'];
                     $get_cl_count= $get_cl_count + $inc['get_cl_count'];?></td>
            <td><?php echo $inc['patient'];
                     $patient= $patient + $inc['patient'];?></td>
            <td><?php echo $inc['month_patient'];
            $month= $month + $inc['month_patient']; ?></td>
            <td><?php echo $inc['total_patient']; 
            $total= $total + $inc['total_patient'];?></td>

        </tr>
    <?php } ?>

<tr>
<td><strong>Total</td>
<td><strong><?php echo $get_cl_count; ?></strong></td>
<td><strong><?php echo $patient; ?></strong></td>
<td><strong><?php echo $month; ?></strong></td>
<td><strong><?php echo $total; ?></strong></td>


</tr>
</table>