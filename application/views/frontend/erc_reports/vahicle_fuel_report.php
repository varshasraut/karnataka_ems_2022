<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                        
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
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

    <?php  ?>
    <?php 
    if($hpcl_data){
      
    foreach ($hpcl_data as $hpcl) { ?>
            <tr>  
            <td><?php echo $hpcl['sr_no'];  ?></td>
           <td><?php echo $hpcl['card_no']; ?></td>
            <td><?php echo $hpcl['state']; ?></td>
            <td><?php echo $hpcl['division']; ?></td>
             <td><?php echo $hpcl['district']; ?></td>
            <td><?php echo $hpcl['base_location_name']; ?></td>
            <td><?php echo $hpcl['vahicle_make']; ?></td>
            <?php foreach($date_range as $range_d){ ?>
            <td><?php echo $hpcl[$range_d.'_fcr']; ?></td>
            <?php } ?>
            <td><?php echo $hpcl['sum_fcr']; ?></td>
            <?php foreach($date_range as $range_d){ ?>
            <td><?php echo $hpcl[$range_d.'_hpcl']; ?></td>
            <?php } ?>
            <td><?php echo $hpcl['sum_hpcl']; ?></td>
            <td><?php echo $hpcl['difference']; ?></td>
            </tr>

<?php }?>
            
<?php 
    }else{
    ?>
    <tr> 
     <td  style="text-align: center;" colspan="17">Record Not Found</td>
     <tr> 
    <?php
} ?>


</table>