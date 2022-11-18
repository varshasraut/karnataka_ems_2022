<?php
if ($action_type == 'Receive Tyre') {

    $act_url = "biomedical/receive_tyre";

    $act = "RECEIVE";
} elseif ($action_type == 'Approve Tyre') {

    $act_url = "biomedical/approve_tyre";

    $act = "APPROVE";
} else {

    $act_url = "biomedical/dispatch_tyre";

    $act = "DISPATCH";
}

if ($action == 'view' || $action == 'apr' || $action == 'dis' || $action == 'rec') {
    $disabled = 'disabled';
}

if ($action == 'view') {
    $dis = 'disabled';
}
?>


<?php // echo $action; ?>


<div class="register_outer_block">

    <div class="box3">

        <form method="post" action="" id="view_indent">   

            <input type="hidden" name="amb_no" id="amb_id" value="<?php echo base64_encode($indent_data[0]->req_amb_reg_no); ?>">

            <input type="hidden" name="ind_req_id" id="" value="<?php echo $result[0]->tyre_req_id; ?>">

            <input type="hidden" name="req_type" id="" value="<?php echo $result[0]->req_type; ?>">

            <h2 class="txt_clr2 width1 txt_pro"><?php
                if ($action_type) {
                    echo $action_type;
                }
                ?></h2>
            <!--<h3>Indents Details</h3>-->  
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50"> <div id="ambulance_state">



                            <?php
                            if ($indent_data[0]->req_state_code != '') {
                                $st = array('st_code' => $indent_data[0]->req_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $st = array('st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }


                            echo get_state_clo_comp_ambulance($st);
                            ?>

                        </div>

                    </div>

                </div>
                <div class="width2 float_left">    
                    <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <div id="incient_district">
                            <?php
                            if ($indent_data[0]->req_state_code != '') {
                                $dt = array('dst_code' => $indent_data[0]->req_district_code, 'st_code' => $indent_data[0]->req_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }

                            echo get_district_closer_amb($dt);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <div id="incient_ambulance">



                            <?php
                            if ($indent_data[0]->req_state_code != '') {
                                $dt = array('dst_code' => $indent_data[0]->req_district_code, 'st_code' => $indent_data[0]->req_state_code, 'amb_ref_no' => $indent_data[0]->req_amb_reg_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }


                            echo get_clo_comp_ambulance($dt);
                            ?>

                        </div>

                    </div>

                </div>
                <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50" id="amb_base_location">
                        <input name="req[req_base_location]" tabindex="23" class="form_input filter_required disabled" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $indent_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $disabled; ?>>

                    </div>


                </div>
                <div class="field_row width100">

                    <div class="field_lable float_left width_16"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_25">
                        <select name="ind[req_shift_type]" tabindex="8"  class="filter_required disabled" data-errors="{filter_required:'Supervisor Name should not be blank!'}"  <?php echo $disabled; ?>> 
                            <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                            <?php echo get_shift_type($indent_data[0]->req_shift_type); ?>
                        </select>

                    </div>



                </div>

                <?php
                $prev_type = "";
                
            //    var_dump($result);
                if (count($result) > 0) {
                    $count = 1;
                    $c = 0;
                    $total = count($result);
                    foreach ($result as $ind_details) {
                        $c++;
                        if ($ind_details->tyre_item_type == 'EQP') {
                            $item_name = $ind_details->tyre_title;
                            $sku = $ind_details->tyre_id;
                            $sku_name = "EQ";
                            $type = 'Tyre';
                        }


                        if ($prev_type != $type && $prev_type != "") {
                            ?>  
                            </table>

                            <?php
                            $count = 1;
                        }

                        if ($prev_type != $type) {
                            $count = 1;
                            ?>
                            <div class="field_row width100">
                                <h4> <?php echo $type; ?></h4>  
                                <table class="style3">
                                    <tr>   
                                        <td>Sr no</td>
                                        <td>#SKU</td>
                                        <td>Item Name</td>
                                        <!-- <td>Available Qty In Ambulance</td> -->

                                        <?php //if ($action == 'dis') { ?> 

                                            <td>Available stock</td>

                                        <?php //} ?>

                                        <td>Request Qty</td>

                                        <td>Dispatch Qty</td>

                                        <?php if ($action == 'view' || $action == 'rec' || $action == 'apr') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  
                                <?php } $prev_type = $type; ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $sku_name; ?><?php echo $sku; ?></td>
                                    <td class="width30"><?php echo stripslashes($item_name); ?></td>
                                    <!-- <td><?php 
                                       $args = array('inv_type'=>$ind_details->tyre_item_type,'inv_id'=> $ind_details->tyre_id,'inv_amb'=>$indent_data[0]->req_amb_reg_no);
                            $stock_data = get_inv_stock_by_id($args);
                            //var_dump($stock_data);
                            
                            $bal=0;
                            
                            $stock = $stock_data[0]->in_stk - $stock_data[0]->out_stk;

                            if ($stock > 0) {
                                $bal = $stock;
                            } else if ($stock_data[0]->in_stk > 0) {
                                $bal = $stock_data[0]->in_stk;
                            }

                           echo $bal;
                                                             
//                                        if ($ind_details->in_stk > $ind_details->out_stk) {
//
//                                            echo $ind_details->in_stk - $ind_details->out_stk;
//                                        } else {
//                                            echo $ind_details->in_stk;//0;
//                                        }
                                        ?> </td>-->

                                    <?php //if ($action == 'dis') { ?> 

                                        <td>

                                               <?php
        $bal = 0;

//        $stock = $ind_details->stk_total - $ind_details->in_stk;
//
//        if ($stock > 0) {
//            $bal = $stock;
//        } else if ($ind_details->in_stk > 0) {
//            $bal = $ind_details->in_stk;
//        }
//
//        echo $bal;
        
         $args_stock = array('inv_type'=>$ind_details->tyre_item_type,'inv_id'=> $ind_details->tyre_id);
                            $stock_data = get_inv_stock_by_id($args_stock);
                            //var_dump($stock_data);
                            
                            $bal=0;
                            
                            $stock = $stock_data[0]->in_stk - $stock_data[0]->out_stk;

                            if ($stock >= 0) {
                                $bal = $stock;
                            } else if ($stock_data[0]->in_stk > 0) {
                                $bal = $stock_data[0]->in_stk;
                            }

                            echo $bal;
        ?>
                                            <?php //echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->tyre_id; ?>" value="<?php echo $bal; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td><?php echo $ind_details->tyre_quantity; ?></td>



                                    <td>


                                        <?php
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr') {
                                            echo ($ind_details->tyre_dis_qty) ? $ind_details->tyre_dis_qty : '0';
                                        } else if ($action = "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->tyre_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->tyre_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>






                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->tyre_rec_qty) ? $ind_details->tyre_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->tyre_id; ?>" value="<?php echo $ind_details->tyre_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less than to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>


                                <?php
                                $count++;
                            }
                            if ($c == $total) {
                                ?>  
                            </table>
                        </div>
                        <?php
                    }
                }
                ?>          

                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">Expected Date of Delivery<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">

                            <input name="eqiup[req_expected_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Expected Date of Delivery should not be blank!'}" value="<?= @$indent_data[0]->req_expected_date_time; ?>"  <?php echo $disabled; ?>>

                        </div>
                    </div>

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">Current Date & Time<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">
                            <input name="eqiup[req_cur_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Current date & time should not be blank!'}" value="<?= @$indent_data[0]->req_cur_date_time; ?>"  <?php echo $disabled; ?>>
                        </div>
                    </div>



                </div>
                <div class="field_row width100">
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="supervisor">Supervisor<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="eqiup[req_supervisor]" tabindex="20" class="form_input  filter_required" placeholder="Supervisor" type="text"  data-errors="{filter_required:'Supervisor should not be blank!'}" value="<?= @$indent_data[0]->req_supervisor; ?>"   <?php echo $disabled; ?>>
                        </div>
                    </div>
                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">District Manager<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">

                            <input name="eqiup[req_district_manager]" tabindex="20" class="form_input  filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$indent_data[0]->req_district_manager; ?>"  <?php echo $disabled; ?>>

                        </div>
                    </div>



                </div>
                <div class="width100 float_left">

                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <select name="eqiup[req_standard_remark]" tabindex="8"  id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $disabled; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="request_send"  <?php
                                if (@$indent_data[0]->req_standard_remark == 'request_send') {
                                    echo "selected";
                                }
                                ?>>Tyre request send sucessfully.</option>  
                                <option value="other"  <?php
                                if (@$indent_data[0]->req_standard_remark == 'other') {
                                    echo "selected";
                                }
                                ?>>other</option> 
                            </select>
                        </div>
                    </div>
                    <?php if ($action == 'apr' || $action == 'dis' || $action == 'view') { ?>
                        <div class="filed_input float_left width2">

                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark"> Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">

                                <select name="eqiup[req_dispatch_remark]" tabindex="8"  id="standard_remark" class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"  <?php echo $dis; ?>> 
                                    <option value="">Select Remark</option>
                                    <?php if ($action == 'dis' || $action == 'view') { ?>
                                        <option value="request_dispatch"  <?php
                                        if (@$indent_data[0]->req_dispatch_remark == 'request_dispatch') {
                                            echo "selected";
                                        }
                                        ?>>Tyre request Dispatch sucessfully.</option> 
                                            <?php } ?>
                                            <?php if ($action == 'apr' || $action == 'view') { ?>
                                        <option value="request_approve"  <?php
                                        if (@$indent_data[0]->req_dispatch_remark == 'request_approve') {
                                            echo "selected";
                                        }
                                        ?>>Tyre request Approve sucessfully.</option>  
                                            <?php } ?>
                                </select>

                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="width100">
                    <?php if ($action == 'apr' || $action == 'view') { ?>

                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="amount">Approve Date & Time<span class="md_field">*</span></label></div>
                            <div class="width50 float_left">
                                <input name="eqiup[req_apr_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Approve date & time should not be blank!'}" value="<?php if (@$indent_data[0]->req_apr_date_time != '0000-00-00 00:00:00') {
                        echo @$indent_data[0]->req_apr_date_time;
                    } ?>"  <?php echo $dis; ?>>
                            </div>
                        </div>
<?php } ?>

                </div>

<?php if ($action != 'view') { ?>
    <?php // echo $act; ?>
                    <div class="save_btn_wrapper float_left">

                        <input type="hidden" name="ind_opt" value="yes">

                        <input name="" value="<?php echo $act; ?>" class="accept_btn form-xhttp-request" data-href="<?php echo base_url() . $act_url; ?>" data-qr="output_position=content&amp;req_id=<?php echo $result[0]->tyre_req_id; ?>" type="button" tabindex="">

                    </div>


<?php } ?>



        </form>  
    </div>
</div>