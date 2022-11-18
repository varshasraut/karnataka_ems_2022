<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function;?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['amb_no']; ?>" name="amb_no">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                 <input type="hidden" value="<?php echo $report_args['district']; ?>" name="incient_district">
                
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

?>

        <tr>         

            <td><?php echo $data_value; ?></td> 
            <td><?php echo $ambulance; ?></td> 




        </tr>


        



</table>