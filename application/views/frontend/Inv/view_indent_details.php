<?php
if ($clg_group == 'UG-EMT') {

    $act_url = "ind/receive";

    $act = "RECEIVE";
} else {

    $act_url = "ind/dispatch";

    $act = "DISPATCH";
}
?>




<div class="register_outer_block">

    <div class="box3">

        <form method="post" action="" id="">   

            <input type="hidden" name="rto_no" id="amb_id" value="<?php echo $rto_no; ?>">

            <input type="hidden" name="ind_req_id" id="" value="<?php echo $result[0]->ind_req_id; ?>">



            <h3>Indents Details</h3>  

            <?php
            $prev_type = "";
            if (count($result) > 0) {
                $count = 1;
                foreach ($result as $ind_details) {

                    if ($ind_details->ind_item_type == 'CA') {
                        $item_name = $ind_details->inv_title;
                        $sku = $ind_details->inv_id;
                        $type = 'Consumable';
                        $sku_name = "CS";
                    } else if ($ind_details->ind_item_type == 'NCA') {
                        $item_name = $ind_details->inv_title;
                        $sku = $ind_details->ind_id;
                        $type = 'Non Consumable';
                        $sku_name = "NC";
                    } else if ($ind_details->ind_item_type == 'MED') {
                        $item_name = $ind_details->med_title;
                        $sku = $ind_details->med_id;
                        $sku_name = "MD";
                        $type = 'Medication';
                    } else if ($ind_details->ind_item_type == 'EQP') {
                        $item_name = $ind_details->eqp_name;
                        $sku = $ind_details->eqp_id;
                        $sku_name = "EQ";
                        $type = 'Equipment';
                    }


                    if ($prev_type != $type && $prev_type != "") {
                        ?>  
                        </table>

                        <?php
                        $count = 1;
                    }

                    if ($prev_type != $type) {
                        ?>

                        <h4>Indents details : <?php echo $type; ?></h4>  
                        <table class="style3">
                            <tr>   
                                <td>Sr no</td>
                                <td>#SKU</td>
                                <td>Item Name</td>

                                <?php if ($action == 'dis') { ?> 

                                    <td>Available stock</td>

                                <?php } ?>

                                <td>Request Qty</td>

                                <td>Dispatch Qty</td>

                                <?php if ($action == 'view' || $action == 'rec') { ?> 

                                    <td>Received Qty</td>

                                <?php } ?>

                            </tr>  
                        <?php } ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $sku_name; ?><?php echo $sku; ?></td>
                            <td class="width30"><?php echo stripslashes($item_name); ?></td>

                            <?php if ($action == 'dis') { ?> 

                                <td>

                                    <?php echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; ?>

                                    <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; ?>">

                                </td>


                            <?php } ?>

                            <td><?php echo $ind_details->ind_quantity; ?></td>



                            <td>


                                <?php
                                if ($action == 'view' || $action == 'rec') {
                                    echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                } else if ($action = "dis") {
                                    ?>

                                    <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock'}">


                                <?php } ?>

                            </td>






                            <?php
                            if ($action == 'view') {


                                echo "<td class='width20'>";

                                echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                echo "</td>";
                            } else if ($action == 'rec') {
                                ?>

                                <td class='width20'>


                                    <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                    <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less than dispath qty'}">

                                </td>

                            <?php } ?> 

                    </table>

                <?php } ?>

                </tr>
                <?php
                $prev_type = $type;
                $count++;
            }
            ?>          



            <?php if ($action != 'view') { ?>

                <div class="save_btn_wrapper float_left">

                    <input type="hidden" name="ind_opt" value="yes">

                    <input name="" value="<?php echo $act; ?>" class="accept_btn form-xhttp-request" data-href="<?php echo base_url() . $act_url; ?>" data-qr="output_position=content&amp;req_id=<?php echo $result[0]->ind_req_id; ?>" type="button" tabindex="">

                </div>


            <?php } ?>




        </form>                
    </div>       
</div>