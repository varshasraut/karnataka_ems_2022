<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/show_corona_call_summary" method="post" enctype="multipart/form-data" target="form_frame">
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
    <?php $inc = $data;
?>

        <tr>         

            <td><?php echo $inc['corona_date']; ?></td> 
            <td><?php echo $inc['out_calls']?$inc['out_calls']:0; ?></td> 
            <td><?php echo $inc['connected_calls']?$inc['connected_calls']:0; ?></td>
            <td><?php echo $inc['not_connected_calls']?$inc['not_connected_calls']:0; ?></td>
            <td><?php echo $inc['symptomatic_count']?$inc['symptomatic_count']:0; ?></td> 
            <td><?php echo $inc['asymptomatic']?$inc['asymptomatic']:0; ?></td> 


        </tr>

        <?php
  
    ?>

</table>