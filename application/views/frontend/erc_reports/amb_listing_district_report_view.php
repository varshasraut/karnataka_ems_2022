<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/ambulance_listing_district_wise" method="post" enctype="multipart/form-data" target="form_frame">
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
        
        <td style="text-align: center;"><?php echo $inc['sr_no']; ?></td>
        <td><?php echo $inc['reg_no']; ?></td>
        <td><?php echo $inc['mb_no']; ?></td>
  
        <td><?php echo $inc['vehical_make']; ?></td>
        <td><?php echo $inc['division']; ?></td>
        <td><?php echo $inc['district']; ?></td>
        <td><?php echo $inc['tehsil']; ?></td>
        <td><?php echo $inc['model']; ?></td>

        <td><?php echo $inc['imei_no']; ?></td>
        <td><?php echo $inc['sim_no']; ?></td>
        <td><?php echo $inc['srn_no']; ?></td>
        <td><?php echo $inc['mdt_imei_no']; ?></td>
        <td><?php echo $inc['simcnt_no']; ?></td>
      
        <td><?php echo $inc['ambulance_type']; ?></td>
        <td><?php echo $inc['amb_category']; ?></td>
        <td><?php echo $inc['chases_new']; ?></td>

        <td><?php echo $inc['party']; ?></td>
        <td><?php echo $inc['base_location']; ?></td>
        
        <td><?php echo $inc['lat']; ?></td>
        <td><?php echo $inc['long']; ?></td>
        <td><?php echo $inc['area']; ?></td>
        <td><?php echo $inc['status']; ?></td>
        <td><?php echo $inc['added_by']; ?></td>
        <td><?php echo $inc['added_date']; ?></td>
        </tr>

<?php } ?>


</table>