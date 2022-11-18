<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/dist_amb_type_patient_served_report" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                <input type="hidden" value="<?php echo $report_args['to_date']; ?>" name="to_date">
                <input type="hidden" value="<?php echo $amb_type; ?>" name="amb_type">
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
     $pta=0;
     $bls=0;
     $als=0;
     $grand_total=0;
    foreach ($inc_data as $inc) {
       

        ?>
        <tr>  
       
           
            <td><?php echo $inc['dist_name']; ?></td>
            
            <td><?php echo $inc['pta_type'];
                     $pta= $pta + $inc['pta_type'];?></td>
            <td><?php echo $inc['bls_type'];
            $bls= $bls + $inc['bls_type']; ?></td>
            <td><?php echo $inc['als_type']; 
            $als= $als + $inc['als_type'];?></td>
            <td><?php $total =$inc['pta_type']+$inc['bls_type']+$inc['als_type'];
            echo $total; 
            $grand_total= $grand_total + $total;?></td>
           


        </tr>
    <?php } ?>

<tr>
<td><strong>Total<strong></td>
<td><strong><?php echo $pta; ?></strong></td>
<td><strong><?php echo $bls; ?></strong></td>
<td><strong><?php echo $als; ?></strong></td>
<td><strong><?php echo $grand_total; ?></strong></td>

</tr>
</table>