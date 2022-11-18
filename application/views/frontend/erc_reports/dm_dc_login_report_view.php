<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>report_data/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <!-- <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date"> -->
				<input type="hidden" value="<?php echo $maintenance_type; ?>" name="maintenance_type">
                
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>  

<div class="width100"><lable><?php echo $maint_type; ?></label></div>
<table class="table report_table">
    <tr>                              
        <?php foreach ($header as $heading) { ?>
        <th style="line-height: 20px;"><?php echo $heading; ?></th>
        <?php } ?>
    </tr>
    <?php
    $count = 1;
    
    foreach($inc_data as $inc_data1){ 
    //    print_r($inc_data1);die();
      ?>  
        <tr>  
            <td><?php echo $count; ?></td>
            <td><?php echo $inc_data1['dist']; ?></td>
            <td><?php echo $inc_data1['zone']; ?></td>
            <td><?php echo $inc_data1['amb_count']; ?></td>
            <td><?php echo $inc_data1['id']; ?></td>
            <td><?php echo $inc_data1['name']; ?></td>            
            <td><?php if($inc_data1['login']){echo $inc_data1['login'];}else{echo '-';} ?></td>
            <td><?php if($inc_data1['login']){echo $inc_data1['logout'];}else{echo '-';}?></td>

            
           
        </tr>
        <?php
        $count++;
    }
    
    ?>
</table>
<style> 
td{
    text-align:center
}
</style>
