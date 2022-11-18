<h3>A I Report </h3>						

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>file_nhm/a_i" method="post" enctype="multipart/form-data" target="form_frame">
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
            <th>Registration Number of the Ambulance</th>
            <th>Location</th>
            <th>Opening (First day of the Month)</th>
            <th>Closing (Last day of the Month)</th>
            <th>KM Run During the Month</th>
            <th>No of Patients/calls Attended</th>
<!--            <th>Remarks</th>-->
    </tr>					



    <?php if(is_array($report_info)){
    foreach ($report_info as $key=>$inc) { 
     //print_r($inc_data);?>
        <tr>  
            <td><?php echo $key+1 ?></td>
            <td><?php echo $inc['amb_rto_register_no']; ?></td>
            <td><?php echo $inc['Base_location']; ?></td>
            <td><?php echo $inc['Opening_odo']; ?></td>
            <td><?php echo $inc['Start_odo']; ?></td>      
            <td><?php echo $inc['Total_Km']; ?></td>
            <td><?php echo $inc['Total_patient']; ?></td>
<!--            <td><?php echo $inc['Remark']; ?></td>-->
           

        </tr>

<?php }}?>


</table>
