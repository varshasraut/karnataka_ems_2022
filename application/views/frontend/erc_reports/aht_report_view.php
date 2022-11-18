<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_funtion ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['clg_group']; ?>" name="clg_group">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
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
    //$today =0;
    //$month =0;
    //$total =0;
   // var_dump($patient_data);die;
    foreach ($patient_data as $patient) {
       //var_dump($patient['ero_name']);die;
        ?>
        <tr>         
            <td><?php echo ucwords($patient['ero_name']); ?></td> 
            <td><?php echo $patient['clg_avaya_id']; ?></td> 
            <td><?php echo $patient['clg_group']; ?></td> 
            <td><?php echo $patient['em_call_count']?$patient['em_call_count']:0; ?></td> 
            <td><?php echo $patient['em_call_total']?$patient['em_call_total']:0; ?></td> 
             <td><?php echo $patient['hosp_count']?$patient['hosp_count']:0; ?></td> 
            <td><?php echo $patient['hosp_time_diff']?$patient['hosp_time_diff']:0; ?></td> 
            <td><?php echo $patient['nem_call_count']?$patient['nem_call_count']:0; ?></td> 
            <td><?php echo $patient['nem_time_diff']?$patient['nem_time_diff']:0; ?></td> 
            
            
            

        </tr>
        <?php
    }
    ?>

</table>