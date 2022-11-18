<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post" enctype="multipart/form-data" target="form_frame">
             
                          <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                           <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                           <input type="hidden" value="<?php echo $report_args['hpcl_amb'];?>" name="hpcl_amb">
                         
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div> 
 <table class="table">

                    <tr>                
                       
                        <?php foreach ($header as $heading) { ?>
            <th style="line-height: 20px;"><?php echo $heading; ?></th>
            <?php } ?>

                    </tr>

                    <?php
                    if ($result) {
        $volume = 0;
        $Amount= 0;
        $Price = 0;
                        foreach ($result as $key => $value) {
                            $volume = $volume+$value['volume'];
                            $Amount= $Amount+$value['amount'];
                            $Price = $Price+$value['rate'];
                            
                   

                            ?>
                            <tr>

                                
                                <td><?php echo $value['bpcl_id']; ?> </td>
                                <td><?php echo $value['amb_rto_register_no']; ?> </td>
                                <td><?php echo $value['base_location_name']; ?> </td>
                                <td><?php echo $value['dist_name']; ?> </td>
                                <td><?php echo $value['cardId']; ?></td>
                                <td><?php echo $value['cardName']; ?> </td>
                                <td><?php echo $value['roName']; ?> </td>
                                <td><?php echo $value['createdDT']; ?> </td>
                                <td><?php echo $value['product']; ?> </td>
                                <td><?php echo $value['rate']; ?> </td>
                                <td><?php echo $value['volume']; ?> </td>
                                <td><?php echo $value['amount']; ?> </td>
                                <td><?php echo '-'; ?> </td>
                                <td><?php echo $value['added_date']; ?> </td>
                            </tr>
    <?php } ?>
                              <tr>  
            <td style="text-align: center;" colspan="9"><strong>Total</strong></td>
            <td></td>
            <td><?php echo $volume; ?></td>
            <td><?php echo $Amount; ?></td>
            <td></td>
            <td></td>
            </tr>
                            <?php
} else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

<?php } ?>   

                </table>

                
