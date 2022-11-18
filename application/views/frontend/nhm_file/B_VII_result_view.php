<h3>Annexure B-VII</h3>				
<h3>Vehicle Status Information Report</h3>				

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>file_nhm/B_VII" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" name="from_date" value="<?php echo $from_date;?>">
                        <input type="hidden" name="to_date" value="<?php echo $to_date;?>">
                        <input type="hidden" name="report_type" value="<?php echo $report_type;?>">
                         <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>

<table class="table report_table" style="border-collapse: collapse;">

    <tr>                              
       
             <th>Sr.NO</th>
            <th>Ambulance  Reg.No.</th>
            <th>Location</th>
            <th>No.of on-road hrs during month</th>
            <th>No.of off-road hrs during month</th>

             <th>Remarks</th>
       
    </tr>					



    <?php if(is_array($report_info)){
    foreach ($report_info as $key=>$inc) { 
     //print_r($inc_data);?>
        <tr>  
            <td><?php echo $key+1 ?></td>
            <td><?php echo $inc['amb_no']; ?></td>
            <td><?php echo $inc['location']; ?></td>
            <td><?php echo $inc['on_road_hrs']; ?></td>
            <td><?php echo $inc['off_road_hrs']; ?></td>      
     
            <td><?php echo $inc['remark']; ?></td>

        </tr>

<?php }}?>


</table>
