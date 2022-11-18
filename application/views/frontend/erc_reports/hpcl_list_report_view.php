<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function ?>" method="post" enctype="multipart/form-data" target="form_frame">
                        <?php //var_dump($report_args["system"]);?>
<!--                        <input type="hidden" value="<?php echo $report_args['district'];?>" name="incient_district">-->
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                           <input type="hidden" value="<?php echo $report_args['hpcl_amb'];?>" name="hpcl_amb">
                           <!--<input type="hidden" value="<?php echo $report_args['incient_district'];?>" name="incient_district">
                           <input type="hidden" value="<?php echo $report_args['system'];?>" name="system">-->
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
    foreach ($hpcl_data as $hpcl) { 
            // var_dump($hpcl['added_date']);    
                ?>
            <tr>  
            <td><?php echo (isset($hpcl['hpcl_id']) ? $hpcl['hpcl_id'] : 0);  ?></td>
           <!-- <td><?php //echo $hpcl['TerminalID']; ?></td>
            <td><?php// echo $hpcl['MerchantName']; ?></td>
            <td><?php //echo $hpcl['MerchantID']; ?></td>
            <td><?php// echo $hpcl['Location']; ?></td>
            <td><?php //echo $hpcl['CustomerID']; ?></td>
            <td><?php// echo $hpcl['BatchIDROC']; ?></td>-->
            <td><?php echo $hpcl['AccountNumber']; ?></td>
            <td><?php echo $hpcl['VehicleNoUserName']; ?></td>
            <td><?php echo $hpcl['TransactionDate']; ?></td>
            <!--<td><?php //echo $hpcl['TransactionType']; ?></td>-->
            <td><?php echo $hpcl['Product']; ?></td>
            <td><?php echo $hpcl['Price']; ?></td>
            <td><?php echo $hpcl['Volume']; ?></td>
            <!--<td><?php //echo $hpcl['Currency']; ?></td>
            <td><?php //echo $hpcl['ServiceCharge']; ?></td>-->
            <td><?php echo $hpcl['Amount']; ?></td>
            <!--<td><?php //echo $hpcl['Balance']; ?></td>-->
            <td><?php echo $hpcl['OdometerReading']; ?></td>
           <!-- <td><?php //echo $hpcl['Drivestars']; ?></td>
            <td><?php //echo $hpcl['RewardType']; ?></td>
            <td><?php //echo $hpcl['Status']; ?></td>
            <td><?php //echo $hpcl['UniqueTransactionID']; ?></td>
            <td><?php //echo $hpcl['ResponseMessage']; ?></td>
            <td><?php //echo $hpcl['ResponseCode']; ?></td>-->
            <td><?php echo $hpcl['added_date']; ?></td>
            </tr>

<?php } }else{
    ?>
    <tr> 
     <td  style="text-align: center;" colspan="10">Record Not Found</td>
     <tr> 
    <?php
} ?>


</table>