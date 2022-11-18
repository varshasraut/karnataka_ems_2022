<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/ambulance_logout_district_wise" method="post" enctype="multipart/form-data" target="form_frame">
                        <?php //var_dump($report_args["system"]);?>
<!--                        <input type="hidden" value="<?php echo $report_args['district'];?>" name="incient_district">-->
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                           <input type="hidden" value="<?php echo $report_args['incient_district'];?>" name="incient_district">
                           <!-- <input type="hidden" value="<?php echo $report_args['system'];?>" name="system"> -->
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
        <td style="text-align: center;"><?php echo $inc['sr_no']; ?></td>
        <td style="text-align: center;"><?php echo $inc['reg_no']; ?></td>
        <td style="text-align: center;"><?php echo $inc['mb_no']; ?></td>
        <td style="text-align: center;"><?php echo $inc['ambulance_type']; ?></td>
        <td style="text-align: center;"><?php echo $inc['base_location']; ?></td> 
        <td style="text-align: center;"><?php echo $inc['division']; ?></td>
        <td style="text-align: center;"><?php echo $inc['district']; ?></td>
        <td style="text-align: center;"><?php echo $inc['status']; ?></td>
        </tr>

<?php } ?>

</table>