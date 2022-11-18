<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>quality_forms/view_quality_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                 <input type="hidden" value="<?php echo $report_args['month_date']; ?>" name="month_date">
                <input type="hidden" value="<?php echo $report_args['system_type']; ?>" name="system_type">
                <input type="hidden" value="<?php echo $report_type; ?>" name="report_type">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>   
<table class="table student_screening">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr> 
    <?php foreach ($inc_data as $key=>$inc) { ?>
        <tr>         
           
            <td><?php echo $key+1; ?></td>
            <td><?php echo $inc->added_date;?></td>
            <td><?php 
           
            $u_name = get_clg_data_by_ref_id($inc->qa_ad_user_ref_id); 
            echo ucwords($u_name[0]->clg_first_name.' '.$u_name[0]->clg_mid_name.' '.$u_name[0]->clg_last_name); ?>
            </td> 
<!--            <td><?php 
            //echo $stat_data->qa_name;
            $qa_name = get_clg_data_by_ref_id($inc->added_by); 
            echo ucwords($qa_name[0]->clg_first_name.' '.$qa_name[0]->clg_mid_name.' '.$qa_name[0]->clg_last_name); ?>
            </td> -->
            <td><?php echo $inc->performer_group;?></td>

            <td><?php  echo $inc->qa_count; ?></td>
            <td><?php  if ($inc->fetal_error_indicator) {
                                        echo $inc->fetal_error_indicator;
                                    } else {
                                        echo "NA";
                                    } ?></td>
            <td><?php echo $inc->quality_score; ?></td>
            <td><?php echo $inc->quality_remark; ?></td>


        </tr>
    <?php } ?>

</table>