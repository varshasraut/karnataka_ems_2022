<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['dist']; ?>" name="dist">
				<input type="hidden" value="<?php echo $report_type_new; ?>" name="report_type_new">
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
    <?php
    $count = 1;
    if(is_array($data)){
    foreach ($data as $key=>$report_data) 
    { //var_dump($maintenance_data);
        $amb_type = $report_data->amb_type;
            if($amb_type == '1')
            {
                $amb_type = 'JE';
            }
            elseif($amb_type == '2')
            {
                $amb_type = 'BLS';
            }
            elseif($amb_type == '3')
            {
                $amb_type = 'ALS';
            }
    ?>
    <tr>  
        <td><?php echo $count; ?></td>
        <td><?php echo $report_data->dst_name; ?></td>
        <td><?php echo $report_data->hp_name; ?></td>
        <td><?php echo $amb_type; ?></td>
        <td><?php echo $key; ?></td>
        <?php if($report_data->total_count=='')
        { ?>
            <td><?php echo '0'; ?></td>
 <?php       }
        else{ ?>
            <td><?php echo $report_data->total_count; ?></td>
  <?php      } ?>
  
           
  
        
        <!--<td><?php //echo $report_data->total_count; ?></td>-->
        
    </tr>
    <?php
    $count++; 
    }} ?>
</table>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
