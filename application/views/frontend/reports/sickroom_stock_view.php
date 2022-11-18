<?php
$CI = EMS_Controller::get_instance();

$inv_types = array('CA' => 'Consumables', 'NCA' => 'Non Consumables');
?>

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>tdd_reports/sickroom_stock_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['inv_amb'];?>" name="school_id">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   
<div class="box3">    
        <table class="table report_table">

            <tr style="line-height: 25px;">
                <th style="line-height: 25px;">Name of Consumables</th>
                <th style="line-height: 25px;">Expected Stock</th>
                <th style="line-height: 25px;">Opening Stock 53 Sick Room</th>
                <th style="line-height: 25px;">Consumed During the month</th>
                <th style="line-height: 25px;">Replenishment During the Month</th>
                <th style="line-height: 25px;">Closing Stock </th>
            </tr>

            <?php
            if (!empty($item_list)) {
                foreach ($item_list as $item) {
                  
                    ?>

                    <tr>

                      

                        
                        <td><?php echo stripslashes($item->inv_title); ?></td>
                        <td><?php echo $item->inv_base_quantity; ?></td>
                        <td><?php echo $item->inv_base_quantity; ?></td>
                        
                        
                        <td>

                            <?php
                            
                             echo $item->out_stk;
                            ?>

                        </td> 
                        <td>
                                      <?php
                            
                            $bal=0;
                            
                            $stock = $item->in_stk - $item->out_stk;

                            if ($stock > 0) {
                                $bal = $stock;
                            } else if ($item->in_stk > 0) {
                                $bal = $item->in_stk;
                            }
                            $replenishment = $item->inv_base_quantity - $stock;

                            echo $stock;
                            ?>
                        </td>
                        <td><?php echo $bal ?></td>

                      

                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr>
                    <td colspan="9" class="no_record_text">No record Found</td>
                </tr>

                <?php
            }
            ?>
        </table>
</div>




