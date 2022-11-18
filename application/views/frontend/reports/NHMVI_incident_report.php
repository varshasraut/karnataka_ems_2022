<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>reports/NHM6_incident_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
<!--                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >-->
<!--                    <a class="btn clg_search form-xhttp-request" data-href="<?php echo base_url(); ?>reports/save_export_inc" data-qr="output_position=list_table&amp;reports=download&amp;module_name=reports&amp;showprocess=no&amp;to_date=<?php echo $report_args['to_date']; ?>&amp;from_date=<?php echo $report_args['from_date']; ?>" target="_blank">Download</a>-->
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

            <td><?php echo $inc['inc_ref_id']; ?></td>
<!--            <td><?php echo $inc['inc_type']; ?></td>-->
            <td><?php echo $inc['clr_mobile']; ?></td> 
            <td><?php if($inc['inc_type'] == 'DISS_CON_CALL'){ echo 'TRUE'; }else{ echo 'FALSE';  } ?></td> 
            <td><?php if($inc['inc_type'] == 'NUS_CALL' || $inc['inc_type'] == 'ABUSED_CALL' ){ echo 'TRUE'; }else{ echo 'FALSE';  } ?></td> 
            <td><?php if($inc['inc_type'] == 'NUS_CALL' || $inc['inc_type'] == 'ABUSED_CALL' ){ echo 'TRUE'; }else{ echo 'FALSE';  } ?></td> 
            <td>FALSE</td> 
            <td>FALSE</td> 

        </tr>
    <?php } ?>

</table>