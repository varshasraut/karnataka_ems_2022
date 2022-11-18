<h3>A II Report </h3>						

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>file_nhm/a_ii" method="post" enctype="multipart/form-data" target="form_frame">
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
            <th>Name of Medicines/Consumables</th>
            <th>Expected Stock as per Agreement</th>
            <th>Opening Stock-937 Ambulances</th>
            <th>Consumed During The Month</th>
            <th>Replenishment During the Month</th>
            <th>Closing Stock</th>
           <th>Deficiency as against Requirement</th>
    </tr>					



    <?php if(is_array($report_info)){
    foreach ($report_info as $key=>$inc) { 
     //print_r($inc_data);?>
        <tr>  
            <td><?php echo $key+1 ?></td>
            <td><?php echo $inc['indent']; ?></td>
            <td><?php echo $inc['min_stock']; ?></td>
            <td><?php echo $inc['opening_stock']; ?></td>
            <td><?php echo $inc['Consumed_stock']; ?></td>      
     
            <td><?php echo $inc['Replenishment']; ?></td>
            <td><?php echo $inc['Closing_stock']; ?></td>
            <td><?php echo $inc['Deficiency']; ?></td>
           

        </tr>

<?php }}?>


</table>
