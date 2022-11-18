<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function;?>" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $report_args['amb_no']; ?>" name="amb_no">
                <input type="hidden" value="<?php echo $report_args['from_date']; ?>" name="from_date">
                 <input type="hidden" value="<?php echo $report_args['district']; ?>" name="incient_district">
                
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
if($inc_data){
    $total = 0;
    foreach($inc_data as $inc){
       
?>

        <tr>         

            <td><?php echo $inc['district_name']; ?></td> 
            <td><?php echo $inc['count'];
            $total = $total+$inc['count'];
            ?></td> 




        </tr>

    <?php } } ?>
         <tr>         

            <td><b>Total</b></td> 
            <td><?php echo $total ?></td> 




        </tr>
        



</table>