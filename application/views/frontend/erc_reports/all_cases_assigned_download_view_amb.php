<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>pending_reports/amb_wise_cases" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>

<table class="table report_table">

    <tr>                              
        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px; font-size: 11px;"><?php echo $heading; ?></th>
            <?php } ?>
    </tr>
    <?php
    $count = 1;

    
    
    foreach($inc_data as $inc_data1){
        ?>
            <tr style="font-size: 11px; text-align: center;"> 
            <td style="text-align: center;"><?php echo $count;?></td>
        
            <?php
        // foreach ($inc_data1 as $inc) {
       
            ?>
            
                    
               
                <td style="text-align: center;"><?php echo $inc_data1['district']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['amb_default_mobile']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['hp_name']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['dst_name']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['div_name']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['ambt_name']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['assign']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['closed']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['pendclose']; ?></td>
                <td style="text-align: center;"><?php echo $inc_data1['perc']." %"; ?></td>
               
            
    
            <?php
        //     $count++;
            
        // }
        ?> 
        </tr>
        <?php
        $count++;
    }
    ?>

</table>  
<style>
    td{
        text-align:center;
    }
</style>
   