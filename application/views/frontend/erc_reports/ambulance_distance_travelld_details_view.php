
<body>
<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/load_distance_report_form" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <!-- <input type="hidden" value="<?php echo $report_args['system']; ?>" name="system"> -->
                <!-- <input type="hidden" value="<?php echo $amb_type; ?>" name="amb_type"> -->
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
    <tr>  
    <!--<td> <?php //echo 'Catgory A' ?></td> -->
        <?php 
        // print_r($inc_data1);
        foreach ($inc_data as $inc) { ?>

            
            <td><?php echo $inc; ?></td>


        <?php } ?>
    </tr>

    <!-- <td>        <?php //echo 'Catgory A' ?></td> -->
        <?php 
        // print_r($inc_data1);
        foreach ($inc_data1 as $inc) { ?>

            
            <td><?php echo $inc; ?></td>


        <?php } ?>
    </tr>

    <tr>
    <!-- <td><?php //echo 'Catgory B' ?></td> -->
        <?php 
        
        foreach ($inc_data2 as $inc) { ?>

            
            <td><?php echo $inc; ?></td>



        <?php } ?>
    </tr>

    <tr>
    <!-- <td><?php //echo 'Catgory B' ?></td> -->
        <?php 
        
        foreach ($inc_data3 as $inc) { ?>

            
            <td><?php echo $inc; ?></td>



        <?php } ?>
    </tr>

    <!-- <tr> <td><?php //echo 'Catgory C' ?></td> -->
        <?php 
        
        foreach ($inc_data4 as $inc) { ?>

            
            <td><?php echo $inc; ?></td>



        <?php } ?>
    </tr>
    <tr>
    <!-- <td><?php //echo 'Catgory D' ?></td> -->
        <?php 
        
        foreach ($inc_data5 as $inc) { ?>

            
            <td><?php echo $inc; ?></td>



        <?php } ?>
    </tr> 

</table>      
</body>
