<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/export_district_wise" method="post" enctype="multipart/form-data" target="form_frame">
                        <?php //var_dump($report_args["system"]);?>
<!--                        <input type="hidden" value="<?php echo $report_args['district'];?>" name="incient_district">-->
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                           <input type="hidden" value="<?php echo $report_args['incient_district'];?>" name="incient_district">
                           <input type="hidden" value="<?php echo $report_args['system'];?>" name="system">
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


    <?php foreach ($inc_data as $key=>$inc) { ?>
<?php //var_dump($inc_data);?>
        <tr>  
            <td><?php echo $inc['district']; ?></td>
            <td><?php echo $inc['no_amb']; ?></td>
            <td><?php echo $inc['total_km']; ?></td>
            <td><?php echo $inc['avg_km_amb']; ?></td>
            <td><?php echo $inc['trips']; ?></td>
            <td><?php echo $inc['avg_km']; ?></td>
            <td><?php
            if (strpos($inc['avg_veh_km'], '.') == TRUE) {
                echo number_format((float)$inc['avg_veh_km'], 2, '.', '');;
        }else{
            echo $inc['avg_veh_km'];}
            // echo $inc['avg_veh_km']; ?></td>

        </tr>

<?php } ?>


</table>