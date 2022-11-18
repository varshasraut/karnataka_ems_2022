<?php
$CI = EMS_Controller::get_instance();
?>

<div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>tdd_reports/ambulance_equipment_report" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $report_args['from_date'];?>" name="from_date">
                        <input type="hidden" value="<?php echo $report_args['to_date'];?>" name="to_date">
                        <input type="hidden" value="<?php echo $report_args['eqp_amb'];?>" name="amb_reg_id">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>
                
            </div>
</div>   

<div class="box3">    
    <form method="post" name="mng_inveqp_form">
        <table class="table report_table">

            <tr>
                <th style="line-height: 25px;">Name of Equipment</th>
                <th style="line-height: 25px;">Total numbers of<br> equipment's</th>
                <th style="line-height: 25px;">Total numbers of available equipment's</th>
                <th style="line-height: 25px;">Total numbers of functional equipment's</th>
                <th style="line-height: 25px;">Remarks</th>

            </tr>

            <?php
            if (!empty($eqp_list)) {



                foreach ($eqp_list as $eqp) { ?>

                    <tr>


                        <td class="width50"><?php echo stripslashes($eqp->eqp_name); ?></td>
                        <td class="width50"><?php echo $eqp->in_stk; ?></td>


                        <td>

                            <?php
                            $bal = 0;

                            $stock = $eqp->in_stk - $eqp->out_stk;

                            if ($stock > 0) {
                                $bal = $stock;
                            } else if ($eqp->in_stk > 0) {
                                $bal = $eqp->in_stk;
                            }

                            echo $bal;
                            ?>

                        </td> 
                        <td class="width50"><?php echo $eqp->eqp_base_quantity; ?></td>
                         <td class="width50"></td>



                    </tr>

                    <?php
                }
            } else {
                ?>

                <tr>
                    <td colspan="9" class="no_record_text">No record Found</td>
                </tr>

                <?php } ?>
        </table>
    </form>
</div>




