<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/b12_type_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args1['district'];?>" name="incient_district">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<?php //var_dump($inc_data);?>
<table class="table report_table">
    <tr>                              
        <?php if(is_array($header)){foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php }} ?>
    </tr>
    <?php 
    $Accident_data = 0;
    $assault_data = 0;
    $burn_data = 0;
    $attack_data = 0;
    $fall_data = 0;
    $poision_data = 0;
    $labour_data = 0;
    $light_data = 0;
    $mass_data = 0;
    $report_data = 0;
    $other_data = 0;
    $trauma_data = 0;
    $suicide_data = 0;
    $delivery_in_amb_data = 0;
    $pt_manage_on_veti_data = 0;
    $unavail_call_data = 0;
    if(is_array($inc_data)){
        foreach ($inc_data as $inc) {
            //var_dump($inc['medical']); ?>
        <tr>  
        <td><?php echo $inc['dist_name']; ?></td>
        <td><?php echo $inc['Accident_data'];
           $Accident_data = $Accident_data + $inc['Accident_data']; ?></td>
        <td><?php echo $inc['assault_data'];
        $assault_data= $assault_data + $inc['assault_data']; ?></td>
        <td><?php echo $inc['burn_data']; 
        $burn_data = $burn_data + $inc['burn_data'];?></td>
        <td><?php echo $inc['attack_data']; 
        $attack_data = $attack_data + $inc['attack_data'];?></td>
        <td><?php echo $inc['fall_data'];
        $fall_data = $fall_data + $inc['fall_data']; ?></td>
        <td><?php echo $inc['poision_data']; 
        $poision_data = $poision_data + $inc['poision_data'];?></td>
        <td><?php echo $inc['labour_data']; 
        $labour_data = $labour_data + $inc['labour_data'];?></td>
        <td><?php echo $inc['light_data']; 
        $light_data = $light_data + $inc['light_data'];?></td>
        <td><?php echo $inc['mass_data'];
        $mass_data = $mass_data + $inc['mass_data']; ?></td>
        <td><?php echo $inc['report_data'];
        $report_data = $report_data + $inc['report_data']; ?></td>
        <td><?php echo $inc['other_data']; 
        $other_data = $other_data + $inc['other_data'];?></td>
        <td><?php echo $inc['trauma_data']; 
        $trauma_data = $trauma_data + $inc['trauma_data'];?></td>
        <td><?php echo $inc['suicide_data']; 
        $suicide_data = $suicide_data + $inc['suicide_data'];?></td>
        <td><?php echo $inc['delivery_in_amb_data']; 
        $delivery_in_amb_data = $delivery_in_amb_data + $inc['delivery_in_amb_data'];?></td>
        <td><?php echo $inc['delivery_in_amb_data']; 
        $pt_manage_on_veti_data = $pt_manage_on_veti_data + $inc['pt_manage_on_veti_data'];?></td>
        <td><?php echo $inc['unavail_call_data']; 
        $unavail_call_data = $unavail_call_data + $inc['unavail_call_data'];?></td>
        
    </tr>
        <?php }}?>
        <tr>         
            <td><strong>Total</strong></td> 
            <td><strong><?php echo $Accident_data; ?></strong></td>
            <td><strong><?php echo $assault_data;?></strong></td>
            <td><strong><?php echo $burn_data;?></strong></td> 
            <td><strong><?php echo $attack_data; ?></strong></td>
            <td><strong><?php echo $fall_data; ?></strong></td>
            <td><strong><?php echo $poision_data; ?></strong></td>
            <td><strong><?php echo $labour_data; ?></strong></td>
            <td><strong><?php echo $light_data; ?></strong></td>
            <td><strong><?php echo $mass_data; ?></strong></td>
            <td><strong><?php echo $report_data; ?></strong></td>
            <td><strong><?php echo $other_data; ?></strong></td>
            <td><strong><?php echo $trauma_data; ?></strong></td>
            <td><strong><?php echo $suicide_data; ?></strong></td>
            <td><strong><?php echo $delivery_in_amb_data; ?></strong></td>
            <td><strong><?php echo $pt_manage_on_veti_data; ?></strong></td>
            <td><strong><?php echo $unavail_call_data; ?></strong></td>
        </tr>

</table>