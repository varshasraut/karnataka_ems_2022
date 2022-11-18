<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>reports/export_district_wise" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['district'];?>" name="incient_district">
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
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


    <?php if(is_array($inc_data)){
    foreach ($inc_data as $key=>$inc) { 
     //print_r($inc_data);?>
        <tr>  
            <td><?php echo $inc['district']; ?></td>
            <td><?php echo $inc['no_amb']; ?></td>
            <td><?php echo $inc['total_km']; ?></td>
            <td><?php echo $inc['avg_km_amb']; ?></td>
            
            <td><?php echo $inc['trips']; ?></td>
            <td><?php echo $inc['avg_km']; ?></td>
            <td><?php 
            $avg = $inc['avg_veh_km'];
            echo number_format((float)$avg, 2, '.', ''); 
           ?></td>

        </tr>

<?php }}?>


</table>
