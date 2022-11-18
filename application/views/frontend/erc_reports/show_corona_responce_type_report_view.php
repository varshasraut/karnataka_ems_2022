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

            <td><?php echo $inc['call_answered']?$inc['call_answered']:0; ?></td> 
            <td><?php echo $inc['call_not_answered']?$inc['call_not_answered']:0; ?></td> 
            <td><?php echo $inc['incoming_not_available']?$inc['incoming_not_available']:0; ?></td>
            <td><?php echo $inc['not_connected_calls']?$inc['not_connected_calls']:0; ?></td>
            <td><?php echo $inc['not_reachable']?$inc['not_reachable']:0; ?></td> 
            <td><?php echo $inc['switch_off']?$inc['switch_off']:0; ?></td> 
            <td><?php echo $inc['wrong_no']?$inc['wrong_no']:0; ?></td> 
            <td><?php echo $inc['grand_total']?$inc['grand_total']:0; ?></td> 


        </tr>

        <?php
  
    ?>

</table>