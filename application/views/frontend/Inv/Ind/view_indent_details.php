<?php
//if ($clg_group == 'UG-DM' || $clg_group == 'UG-ZM' || $clg_group == 'UG-EMT' || $clg_group == 'UG-HEALTH-SUP' || $this->clg->clg_group == 'UG-SICK-SUP' ||  $radmin) {
//
//    $act_url = "fleet/receive_quantity";
//
//    $act = "RECEIVE";
//} else {
//
//    $act_url = "fleet/dispatch_ambulance";
//
//    $act = "DISPATCH";
//}
?>
<?php
//if (($clg_group == 'UG-FleetManagement' || $clg_group == 'UG-ZM' || $clg_group == 'UG-EMT' || $clg_group == 'UG-HEALTH-SUP' || $radmin ) && $action_type == 'Receive Indent') {
if ( $action_type == 'Receive Indent') {
    $act_url = "fleet/receive_quantity";

    $act = "RECEIVE";
} elseif ($action_type == 'Approve Indent') {

    $act_url = "fleet/approve_ind";

    $act = "APPROVE";
} else if($action_type == 'Update Indent'){
     $act_url = "fleet/edit_indent_request";

    $act = "Update";
}else {

    $act_url = "fleet/dispatch_ambulance";

    $act = "DISPATCH";
}

if ($action == 'view' || $action == 'apr' || $action == 'dis' || $action == 'rec' || $action == 'Update') {
    $disabled = 'disabled';
}else{
     $disabled = '';
}


if ($action == 'view') {
    $dis = 'disabled';
}
if ($action == 'dis') {
    $dispacth = 'disabled';
}

?>




<div class="register_outer_block">
        <form action="<?php echo base_url(); ?>ind/download_link" method="post" enctype="multipart/form-data" target="form_frame">
                    <input type="hidden" value="<?php echo $result[0]->ind_req_id ?>" name="req_id">
<!--                    <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">-->
                    <input type="button" name="print" value="Print" TABINDEX="3" class="float_right" onclick="printElem('indent_print');">
                </form>
    <div class="box3">


        <form method="post" action="" id="view_indent">   

            <input type="hidden" name="amb_no" id="amb_id" value="<?php echo $amb_no; ?>">

            <input type="hidden" name="ind_req_id" id="" value="<?php echo $result[0]->ind_req_id; ?>">

            <input type="hidden" name="req_type" id="" value="<?php echo $result[0]->req_type; ?>">

            <h2 class="txt_clr2 width1 txt_pro"><?php
                if ($action_type) {
                    echo $action_type;
                }
                ?></h2>
            <!--<h3>Indents Details</h3>-->  
            <div class="field_row width100">

                <div class="width2 float_left" hidden>
                    <div class="field_lable float_left width33"><label for="district">State<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50"> <div id="ambulance_state">



                            <?php
                            if ($indent_data[0]->req_state_code != '') {
                                $st = array('st_code' => $indent_data[0]->req_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $st = array('st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }


                            echo get_state_ambulance($st);
                            ?>

                        </div>

                    </div>

                </div>
                <div class="width2 float_left">    
                    <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <div id="incient_dist">
                            <?php
                            if ($indent_data[0]->req_state_code != '') {
                                $dt = array('dst_code' => $indent_data[0]->req_district_code, 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }

                            echo get_stat_dis($dt);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">Ambulance Number<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width50">
                        <div id="incient_ambulance">



                            <?php
                          //  var_dump($indent_data[0]);
                            if ($indent_data[0]->req_state_code != '') {
                                $dt = array('dst_code' => $indent_data[0]->req_district_code, 'st_code' => $indent_data[0]->req_state_code, 'amb_ref_no' => $indent_data[0]->req_amb_reg_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }


                            echo get_district_ambulance($dt);
                            ?>

                        </div>

                    </div>

                </div>
            </div>
            <div class="field_row width100">

                

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50" id="amb_base_location">
                        <input name="req[req_base_location]" tabindex="23" class="form_input filter_required disabled" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $indent_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $disabled; ?>>

                    </div>


                </div>
                <div class="width2 float_left">

                    <div class="field_lable float_left width33"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width50">
                        <select name="ind[req_shift_type]" tabindex="8"  class="filter_required disabled" data-errors="{filter_required:'Supervisor Name should not be blank!'}"  <?php echo $disabled; ?>> 
                            <option value="" <?php echo $disabled; ?>>Select Shift Type</option>
                            <?php echo get_shift_type($indent_data[0]->req_shift_type); ?>
                        </select>

                    </div>



                </div>

                <?php     
                
                if (count($result) > 0) {
                    $count = 1;
                    $c = 0;
                    $total = count($result);
                 
                    foreach ($result as $ind_details) {
                        
                        $c++;
                        if ($ind_details->ind_item_type == 'CA') {
                            
                            $item_name = $ind_details->inv_title;
                            $sku = $ind_details->inv_id;
                            $type = 'Consumable';
                            $sku_name = "CS";
                            $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['CA'][] = $ind_details;
                            
                        } else if ($ind_details->ind_item_type == 'NCA') {
                            $item_name = $ind_details->inv_title;
                            $sku = $ind_details->inv_id;
                            $type = 'Non Consumable';
                            $sku_name = "NC";
                            $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['NCA'][] = $ind_details;
                            
                        } else if ($ind_details->ind_item_type == 'MED') {
                            $item_name = $ind_details->med_title;
                            $sku = $ind_details->med_id;
                            $sku_name = "MD";
                            $type = 'Medication';
                             $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['MED'][] = $ind_details;
                            
                        } else if ($ind_details->ind_item_type == 'EQP') {
                            $item_name = $ind_details->eqp_name;
                            $sku = $ind_details->eqp_id;
                            $sku_name = "EQ";
                            $type = 'Equipment';
                             $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['EQP'][] = $ind_details;
                            
                        }
                        $args = array('inv_type'=>$ind_details->ind_item_type,'inv_id'=>$sku,'inv_amb'=>$indent_data[0]->req_amb_reg_no);
                       
                         $stock_ind = get_inv_stock_by_id($args);
                         
                         
                         $ind_details->in_stk =$stock_ind[0]->in_stk;
                         $ind_details->out_stk =$stock_ind[0]->out_stk;
                         
                         
                        $args_total = array('inv_type'=>$ind_details->ind_item_type,'inv_id'=>$sku);
                         
                        $stock_ind_total = get_inv_stock_by_id($args_total);
                        
                        $ind_details->stk_total_out =$stock_ind_total[0]->out_stk;
                        $ind_details->stk_total =$stock_ind_total[0]->in_stk;
                    }
                }
               ?>
                <?php if (!empty($ind_item['CA'])) { ?>
                 <div class="field_row width100">
                                <h4>Indents details : Consumable</h4>  
                                <table class="style3">
                                    <tr>   
                                        <td>Sr no</td>
                                        <td>#SKU</td>
                                        <td>Item Name</td>
                                          <td>Available Qty In Ambulance</td>
                                        <?php //if ($action == 'dis') { ?> 

                                            <td>Available stock</td>

                                        <?php //} 
                                       
                                        ?>

                                        <td>Request Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td>Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['CA'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $ind_details->sku_name;?><?php echo $ind_details->sku; ?></td>
                                    <td class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                      <td>
                                          <?php
                                            // var_dump($ind_details->in_stk);
                                            // var_dump($ind_details->out_stk);
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ 
                                    //var_dump($ind_details->stk_total);
                                    ?>

                                        <td>

                                            <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            }
                                           // echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; 
                                            ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td><?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>


                                    <?php  if( $action != 'Update'){?>
                                    <td>

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>
                                    <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>
                                  <?php
                                $count++;
                                ?>  
                                <?php } ?>


                              
                            </table>
                            </div>
                <?php } ?>
                <?php if (!empty($ind_item['NCA'])) { ?>
                 <div class="field_row width100">
                                <h4>Indents details : Non Consumable</h4>  
                                <table class="style3">
                                    <tr>   
                                        <td>Sr no</td>
                                        <td>#SKU</td>
                                        <td>Item Name</td>
                                          <td>Available Qty In Ambulance</td>
                                        <?php //if ($action == 'dis') { ?> 

                                            <td>Available stock</td>

                                        <?php //} 
                                       
                                        ?>

                                        <td>Request Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td>Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['NCA'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $ind_details->sku_name;?><?php echo $ind_details->sku; ?></td>
                                    <td class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                      <td>
                                          <?php
                                            // var_dump($ind_details->in_stk);
                                            // var_dump($ind_details->out_stk);
                                          
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ ?>

                                        <td>

                                            <?php //echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; 
                                            
                                            ?>
                                              <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td><?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>


                                    <?php  if( $action != 'Update'){?>
                                    <td>

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>
                                    <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>
                                  <?php
                                $count++;
                                ?>  
                                <?php } ?>


                              
                            </table>
                            </div>
                
                <?php } ?>
                <?php if (!empty($ind_item['MED'])) { ?>
                 <div class="field_row width100">
                                <h4>Indents details : Medication</h4>  
                                <table class="style3">
                                    <tr>   
                                        <td>Sr no</td>
                                        <td>#SKU</td>
                                        <td>Item Name</td>
                                          <td>Available Qty In Ambulance</td>
                                        <?php //if ($action == 'dis') { ?> 

                                            <td>Available stock</td>

                                        <?php //} 
                                       
                                        ?>

                                        <td>Request Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td>Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['MED'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $ind_details->sku_name;?><?php echo $ind_details->sku; ?></td>
                                    <td class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                      <td>
                                          <?php
                                            // var_dump($ind_details->in_stk);
                                            // var_dump($ind_details->out_stk);
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ ?>

                                        <td>

                                            <?php //echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; ?>

                                             <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td><?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>


                                    <?php  if( $action != 'Update'){?>
                                    <td>

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>
                                    <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>
                                  <?php
                                $count++;
                                ?>  
                                <?php } ?>


                              
                            </table>
                            </div>
                <?php } ?>
                <?php
                //var_dump($ind_item['EQP']);
                if (!empty($ind_item['EQP'])) { ?>
                    <div class="field_row width100">
                        <h4>Indents details : Equipment</h4>  
                        <table class="style3">
                            <tr>   
                                <td>Sr no</td>
                                <td>#SKU</td>
                                <td>Item Name</td>
                                <td>Available Qty In Ambulance</td>
                                <?php //if ($action == 'dis') { ?> 

                                <td>Available stock</td>

                                <?php //} 
                                ?>

                                <td>Request Qty</td>


                                <?php if ($action != 'Update') { ?>
                                    <td>Dispatch Qty</td>
                                <?php } ?>

                                <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                    <td>Received Qty</td>

                                <?php } ?>

                            </tr>  

                            <?php
                            $count = 1;

                            foreach ($ind_item['EQP'] as $ind_details) {   //var_dump($ind_details); 
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $ind_details->sku_name; ?><?php echo $ind_details->sku; ?></td>
                                    <td class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                    <td>
                                        <?php
                                        // var_dump($ind_details->in_stk);
                                        // var_dump($ind_details->out_stk);
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ ?>

                                    <td>

                                         <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                    </td>


                                    <?php //} ?>

                                    <td><?php
                                        //echo $ind_details->ind_quantity; 
                                        if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity; ?>">


                                        <?php
                                        } else {
                                            echo $ind_details->ind_quantity;
                                        }
                                        ?>
                                    </td>


                                        <?php if ($action != 'Update') { ?>
                                        <td>

                                            <?php
                                            if ($action == 'view' || $action == 'rec' || $action == 'apr') {
                                                echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                            } else if ($action == "dis") {
                                                ?>

                                                <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                        </td>
        <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                <?php } ?> 
                                </tr>
                                <?php
                                $count++;
                                ?>  
    <?php } ?>



                        </table>
                    </div>
                <?php } ?>


                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">Expected Date of Delivery<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">

                            <input name="eqiup[req_expected_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date Time" type="text"  data-errors="{filter_required:'Expected Date of Delivery should not be blank!'}" value="<?= @$indent_data[0]->req_expected_date_time; ?>"  <?php echo $disabled; ?>>

                        </div>
                    </div>
<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="supervisor">Supervisor<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="eqiup[req_supervisor]" tabindex="20" class="form_input  filter_required" placeholder="Supervisor" type="text"  data-errors="{filter_required:'Supervisor should not be blank!'}" value="<?= @$indent_data[0]->req_supervisor; ?>"   <?php echo $disabled; ?>>
                        </div>
                    </div>-->


                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">District Manager<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">

                            <input name="eqiup[req_district_manager]" tabindex="20" class="form_input  filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$indent_data[0]->whole_name; ?>"  <?php echo $disabled; ?>>

                        </div>
                    </div>
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            <select name="eqiup[req_standard_remark]" tabindex="8"  id="standard_remark" class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"  <?php echo $disabled; ?>> 
                                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                                <option value="request_send"  <?php
                                if (@$indent_data[0]->req_standard_remark == 'request_send') {
                                    echo "selected";
                                }
                                ?>>Equipment request send sucessfully.</option>  
                                <option value="other"  <?php
                                if (@$indent_data[0]->req_standard_remark == 'other') {
                                    echo "selected";
                                }
                                ?>>other</option> 
                            </select>
                        </div>
                    </div>


                </div>
                <div class="field_row width100">

                    <?php if (($indent_data[0]->req_apr_date_time != '0000-00-00 00:00:00' && $indent_data[0]->req_apr_date_time != '' && $action == 'view' ) || $action == 'apr' || $action == 'dis') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Approval Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="req_type[req_apr_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?php
                                if ($indent_data[0]->req_apr_date_time != '0000-00-00 00:00:00') {
                                    echo $indent_data[0]->req_apr_date_time;
                                }
                                ?>"   <?php echo $dis; ?> <?php echo $dispacth; ?>>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="width2 float_left">
                        <?php if (($action == 'apr' ) || ($indent_data[0]->req_approve_remark != '' && $action == 'view' || $action == 'dis')) { ?>


                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Approval Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">



                                <select name="req_type[req_approve_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"  <?php echo $dispacth; ?>  <?php echo $dis; ?>> 
                                    <option value="">Select Remark</option>

                                    <?php if ($action == 'apr' || $action == 'view' || $action == 'dis') { ?>
                                        <option value="request_approve"  <?php
                                        if ($indent_data[0]->req_approve_remark == 'request_approve') {
                                            echo "selected";
                                        }
                                        ?>>Indent request Approve sucessfully.</option>  
                                            <?php } ?>
                                </select>


                            </div>

                        <?php } ?>
                    </div>
                </div>
                <div class="field_row width100">

                    <?php if (($indent_data[0]->req_dispatch_date_time != '0000-00-00 00:00:00' && $indent_data[0]->req_dispatch_date_time != '' && $action == 'view' ) || $action == 'dis') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Dispatch Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="eqiup[req_dispatch_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?php
                                if ($indent_data[0]->req_dispatch_date_time != '0000-00-00 00:00:00') {
                                    echo $indent_data[0]->req_dispatch_date_time;
                                }
                                ?>"   <?php echo $dis; ?> >
                            </div>
                        </div>
                    <?php } ?>
                    <div class="width2 float_left">
                        <?php if ( ($indent_data[0]->req_dispatch_remark != '' && $action == 'view' || $action == 'dis')) { ?>


                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Dispatch Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">



                                <select name="eqiup[req_dispatch_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"   <?php echo $dis; ?>> 
                                    <option value="">Select Remark</option>

                                    <?php if ($action == 'dis' || $action == 'view') { ?>
                                        <option value="request_dispatch"  <?php
                                        if ($indent_data[0]->req_dispatch_remark == 'request_dispatch') {
                                            echo "selected";
                                        }
                                        ?>>Indent request Dispatch sucessfully.</option> 
                                            <?php } ?>
                                </select>


                            </div>

                        <?php } ?>
                    </div>
                </div>
 <div class="field_row width100">

                    <?php if (($indent_data[0]->req_receive_date_time != '0000-00-00 00:00:00' && $indent_data[0]->req_receive_date_time != '' && $action == 'view' ) || $action == 'rec') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Receive Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="eqiup[req_receive_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?php
                                if ($indent_data[0]->req_receive_date_time != '0000-00-00 00:00:00') {
                                    echo $indent_data[0]->req_receive_date_time;
                                }
                                ?>"   <?php echo $dis; ?> >
                            </div>
                        </div>
                    <?php } ?>
                    <div class="width2 float_left">
                        <?php if ( ($indent_data[0]->req_receive_remark != '' && $action == 'view' || $action == 'rec')) { ?>


                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Receive Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">



                                <select name="eqiup[req_receive_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"   <?php echo $dis; ?>> 
                                    <option value="">Select Remark</option>

                                    <?php if ($action == 'rec' || $action == 'view') { ?>
                                        <option value="request_receive"  <?php
                                        if ($indent_data[0]->req_receive_remark == 'request_receive') {
                                            echo "selected";
                                        }
                                        ?>>Indent request Receive sucessfully.</option> 
                                            <?php } ?>
                                </select>


                            </div>

                        <?php } ?>
                    </div>
                </div>


                <?php if ($action != 'view') { ?>

                    <div class="save_btn_wrapper float_left">

                        <input type="hidden" name="ind_opt" value="yes">

                        <input name="" value="<?php echo $act; ?>" class="accept_btn form-xhttp-request" data-href="<?php echo base_url() . $act_url; ?>" data-qr="output_position=content&amp;req_id=<?php echo @$indent_data[0]->req_id; ?>" type="button" tabindex="">

                    </div>


                <?php } ?>



    </div>
   </form>  
</div>
     <div class="hide" id="indent_print">
           <style type = "text/css">
            @media all {
                        .width_25 {
                            width: 25%;
                        }
                        .width40 {
                            width:35.6%;
                        }
                        .width33,
                        .width33 {
                            width: 30% !important;
                        }
                        .width_66 {
                            width: 66.68%;
                        }
                        .width_48 {
                            width: 48%;
                        }
                        .width50,
                        .width2{
                            width: 50%;
                        }
                        .width_60{
                            width: 60%;
                        }
                        .width100 {
                            width: 100% !important;
                            clear: both;
                        }
                        .float_left {
                            float:left;
                        }
                        .float_right {
                            float:right;
                        }
                        table {
                            color: #333333;
                            border-bottom: 5px solid #085b80;
                            width: 100%;
                            margin: 10px 0 25px;
                            margin-top: 10px;
                            border-collapse: collapse;
                        }
                        #indent_print table tr {
                            height: 44px;
                        }

                        #indent_print table{
                            width:100%;
                            border-bottom: none;
                             border: 2px solid #C0C0C0;
                        }
                         #indent_print table tr td {
                            border: 2px solid #C0C0C0;
                            height: 45px;
                            padding-left: 1%;
                        }
                        table > tbody > tr:nth-child(2n) > td {
                            background-color: #F3F3F3;
                        }

                        #indent_print ul {
                            width: 100%;
                            display: inline-block;
                            border: 1px solid gray;
                            list-style-type: none;
                            padding: 0px;
                        }
                        .healthcard_outer .healthcard_name li, .healthcard_outer .healthcard_registration li {
                            float: left;
                            border: 1px solid gray;
                            padding-left: 20px;
                        }
                        #indent_print .style3 tr {
                            border: 2px solid #C0C0C0;
                        }
                        h2, h3 {
                            color: #2acfca;
                        }
                        .row {
                            margin-top: 7px;
                            line-height: 25px;
                            min-height: 40px;
                            padding: 0px;
                            width: 100%;
                        }
                        .healthcard_outer .healthcard_gaud_info li {
                            float: left;
                            border: 1px solid #C0C0C0;
                            padding-left: 20px;
                        }
                         #indent_print .width3, #healthcard_print .width75 {
                            width:75%;
                        }
                         #indent_print .width70 {
                            width:70%;
                        }
                        #indent_print .width25 {
                            width: 23%;
                        }
                         #indent_print .width_60,
                         #indent_print .width60 {
                            width: 60%;
                        }
        }
        </style>



            <h2 class="txt_clr2 width1 txt_pro"><?php
                if ($action_type) {
                    echo $action_type;
                }
                ?></h2>
            <!--<h3>Indents Details</h3>-->  
            <div class="field_row width100">

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">State</label></div>
                    <div class="filed_input float_left width50"> <div id="ambulance_state">

                            <?php
                           
                                echo "Madhya Pradesh";
                          
                            ?>

                        </div>

                    </div>

                </div>
                <div class="width2 float_left">    
                    <div class="field_lable float_left width33"><label for="district">District<span class="md_field">*</span></label></div>   <div class="filed_input float_left width50">
                        <div id="incient_dist">
                            <?php

                            echo get_district_by_id($indent_data[0]->req_district_code);
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



                            echo  $indent_data[0]->req_amb_reg_no;
                            ?>

                        </div>

                    </div>

                </div>

                <div class="width2 float_left">
                    <div class="field_lable float_left width33"><label for="district">Base Location<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width50" id="amb_base_location">
                       <?= $indent_data[0]->hp_name; ?>
                    </div>


                </div>
                <div class="field_row width100">

                    <div class="field_lable float_left width_16"><label for="city">Shift Type<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_25">
                       
                            <?php echo show_shift_type_by_id($indent_data[0]->req_shift_type); ?>
                       

                    </div>



                </div>

                <?php     
                
                if (count($result) > 0) {
                    $count = 1;
                    $c = 0;
                    $total = count($result);
                 
                    foreach ($result as $ind_details) {
                        
                        $c++;
                        if ($ind_details->ind_item_type == 'CA') {
                            
                            $item_name = $ind_details->inv_title;
                            $sku = $ind_details->inv_id;
                            $type = 'Consumable';
                            $sku_name = "CS";
                            $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['CA'][] = $ind_details;
                            
                        } else if ($ind_details->ind_item_type == 'NCA') {
                            $item_name = $ind_details->inv_title;
                            $sku = $ind_details->inv_id;
                            $type = 'Non Consumable';
                            $sku_name = "NC";
                            $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['NCA'][] = $ind_details;
                            
                        } else if ($ind_details->ind_item_type == 'MED') {
                            $item_name = $ind_details->med_title;
                            $sku = $ind_details->med_id;
                            $sku_name = "MD";
                            $type = 'Medication';
                             $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['MED'][] = $ind_details;
                            
                        } else if ($ind_details->ind_item_type == 'EQP') {
                            $item_name = $ind_details->eqp_name;
                            $sku = $ind_details->eqp_id;
                            $sku_name = "EQ";
                            $type = 'Equipment';
                             $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$sku_name;
                            $ind_details->item_name=$item_name;
                            $ind_item['EQP'][] = $ind_details;
                            
                        }
                        $args = array('inv_type'=>$ind_details->ind_item_type,'inv_id'=>$sku,'inv_amb'=>$indent_data[0]->req_amb_reg_no);
                       
                         $stock_ind = get_inv_stock_by_id($args);
                         
                         
                         $ind_details->in_stk =$stock_ind[0]->in_stk;
                         $ind_details->out_stk =$stock_ind[0]->out_stk;
                         
                         
                        $args_total = array('inv_type'=>$ind_details->ind_item_type,'inv_id'=>$sku);
                         
                        $stock_ind_total = get_inv_stock_by_id($args_total);
                        
                        $ind_details->stk_total_out =$stock_ind_total[0]->out_stk;
                        $ind_details->stk_total =$stock_ind_total[0]->in_stk;
                    }
                }
               ?>
                <?php if (!empty($ind_item['CA'])) { ?>
                 <div class="field_row width100">
                                <h4>Indents details : Consumable</h4>  
                                <table class="style3" style="border: 2px solid #C0C0C0;">
                                    <tr style="border: 2px solid #C0C0C0;">   
                                        <td style="border: 2px solid #C0C0C0;">Sr no</td>
                                        <td style="border: 2px solid #C0C0C0;">#SKU</td>
                                        <td style="border: 2px solid #C0C0C0;">Item Name</td>
                                          <td style="border: 2px solid #C0C0C0;">Available Qty In Ambulance</td>
                                        <?php //if ($action == 'dis') { ?> 

                                            <td>Available stock</td>

                                        <?php //} 
                                       
                                        ?>

                                        <td style="border: 2px solid #C0C0C0;">Request Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td style="border: 2px solid #C0C0C0;">Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['CA'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr style="border: 2px solid #C0C0C0;">
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $count; ?></td>
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $ind_details->sku_name;?><?php echo $ind_details->sku; ?></td>
                                    <td style="border: 2px solid #C0C0C0;" class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                      <td style="border: 2px solid #C0C0C0;">
                                          <?php
                                            // var_dump($ind_details->in_stk);
                                            // var_dump($ind_details->out_stk);
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ 
                                    //var_dump($ind_details->stk_total);
                                    ?>

                                        <td style="border: 2px solid #C0C0C0;">

                                            <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            }
                                           // echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; 
                                            ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td style="border: 2px solid #C0C0C0;"><?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>


                                    <?php  if( $action != 'Update'){?>
                                    <td style="border: 2px solid #C0C0C0;">

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>
                                    <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td style="border: 2px solid #C0C0C0;" class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>
                                  <?php
                                $count++;
                                ?>  
                                <?php } ?>


                              
                            </table>
                            </div>
                <?php } ?>
                <?php if (!empty($ind_item['NCA'])) { ?>
                 <div class="field_row width100">
                                <h4>Indents details : Non Consumable</h4>  
                                <table class="style3" style="border: 2px solid #C0C0C0;">
                                    <tr style="border: 2px solid #C0C0C0;">   
                                        <td style="border: 2px solid #C0C0C0;">Sr no</td>
                                        <td style="border: 2px solid #C0C0C0;">#SKU</td>
                                        <td style="border: 2px solid #C0C0C0;">Item Name</td>
                                          <td style="border: 2px solid #C0C0C0;">Available Qty In Ambulance</td>
                                        <?php //if ($action == 'dis') { ?> 

                                            <td style="border: 2px solid #C0C0C0;">Available stock</td>

                                        <?php //} 
                                       
                                        ?>

                                        <td style="border: 2px solid #C0C0C0;">Request Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td style="border: 2px solid #C0C0C0;">Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td style="border: 2px solid #C0C0C0;">Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['NCA'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr style="border: 2px solid #C0C0C0;">
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $count; ?></td>
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $ind_details->sku_name;?><?php echo $ind_details->sku; ?></td>
                                    <td style="border: 2px solid #C0C0C0;" class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                      <td style="border: 2px solid #C0C0C0;">
                                          <?php
                                            // var_dump($ind_details->in_stk);
                                            // var_dump($ind_details->out_stk);
                                          
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ ?>

                                        <td style="border: 2px solid #C0C0C0;">

                                            <?php //echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; 
                                            
                                            ?>
                                              <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td style="border: 2px solid #C0C0C0;"><?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>


                                    <?php  if( $action != 'Update'){?>
                                    <td style="border: 2px solid #C0C0C0;">

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>
                                    <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td style="border: 2px solid #C0C0C0;" class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>
                                  <?php
                                $count++;
                                ?>  
                                <?php } ?>


                              
                            </table>
                            </div>
                
                <?php } ?>
                <?php if (!empty($ind_item['MED'])) { ?>
                 <div class="field_row width100">
                                <h4>Indents details : Medication</h4>  
                                <table class="style3" style="border: 2px solid #C0C0C0;">
                                    <tr style="border: 2px solid #C0C0C0;">   
                                        <td style="border: 2px solid #C0C0C0;">Sr no</td>
                                        <td style="border: 2px solid #C0C0C0;">#SKU</td>
                                        <td style="border: 2px solid #C0C0C0;">Item Name</td>
                                          <td style="border: 2px solid #C0C0C0;">Available Qty In Ambulance</td>
                                        <?php //if ($action == 'dis') { ?> 

                                            <td>Available stock</td>

                                        <?php //} 
                                       
                                        ?>

                                        <td style="border: 2px solid #C0C0C0;">Request Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td style="border: 2px solid #C0C0C0;">Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['MED'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr style="border: 2px solid #C0C0C0;">
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $count; ?></td>
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $ind_details->sku_name;?><?php echo $ind_details->sku; ?></td>
                                    <td class="width30" style="border: 2px solid #C0C0C0;"><?php echo stripslashes($ind_details->item_name); ?></td>
                                      <td style="border: 2px solid #C0C0C0;">
                                          <?php
                                            // var_dump($ind_details->in_stk);
                                            // var_dump($ind_details->out_stk);
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ ?>

                                        <td style="border: 2px solid #C0C0C0;">

                                            <?php //echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; ?>

                                             <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>


                                    <?php //} ?>

                                    <td style="border: 2px solid #C0C0C0;"><?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>


                                    <?php  if( $action != 'Update'){?>
                                    <td style="border: 2px solid #C0C0C0;">

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                    </td>
                                    <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td style="border: 2px solid #C0C0C0;" class='width20'>


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 
                                </tr>
                                  <?php
                                $count++;
                                ?>  
                                <?php } ?>


                              
                            </table>
                            </div>
                <?php } ?>
                <?php
                //var_dump($ind_item['EQP']);
                if (!empty($ind_item['EQP'])) { ?>
                    <div class="field_row width100">
                        <h4>Indents details : Equipment</h4>  
                        <table class="style3" style="border: 2px solid #C0C0C0;">
                            <tr style="border: 2px solid #C0C0C0;">   
                                <td style="border: 2px solid #C0C0C0;">Sr no</td>
                                <td style="border: 2px solid #C0C0C0;">#SKU</td>
                                <td style="border: 2px solid #C0C0C0;">Item Name</td>
                                <td style="border: 2px solid #C0C0C0;">Available Qty In Ambulance</td>
                                <?php //if ($action == 'dis') { ?> 

                                <td style="border: 2px solid #C0C0C0;">Available stock</td>

                                <?php //} 
                                ?>

                                <td style="border: 2px solid #C0C0C0;">Request Qty</td>


                                <?php if ($action != 'Update') { ?>
                                    <td style="border: 2px solid #C0C0C0;">Dispatch Qty</td>
                                <?php } ?>

                                <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                    <td style="border: 2px solid #C0C0C0;">Received Qty</td>

                                <?php } ?>

                            </tr>  

                            <?php
                            $count = 1;

                            foreach ($ind_item['EQP'] as $ind_details) {   //var_dump($ind_details); 
                                ?>
                                <tr style="border: 2px solid #C0C0C0;">
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $count; ?></td>
                                    <td style="border: 2px solid #C0C0C0;"><?php echo $ind_details->sku_name; ?><?php echo $ind_details->sku; ?></td>
                                    <td style="border: 2px solid #C0C0C0;" class="width30"><?php echo stripslashes($ind_details->item_name); ?></td>
                                    <td style="border: 2px solid #C0C0C0;">
                                        <?php
                                        if ($ind_details->in_stk > $ind_details->out_stk) {

                                            echo $ind_details->in_stk - $ind_details->out_stk;
                                        } else {
                                            echo 0;
                                        }
                                        ?> </td>

                                    <?php // if($action != 'Update'){ ?>

                                    <td style="border: 2px solid #C0C0C0;">

                                         <?php
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 0;
                                                 echo 0;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                    </td>


                                    <?php //} ?>

                                    <td style="border: 2px solid #C0C0C0;"><?php
                                        //echo $ind_details->ind_quantity; 
                                        if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity; ?>">


                                        <?php
                                        } else {
                                            echo $ind_details->ind_quantity;
                                        }
                                        ?>
                                    </td>


                                        <?php if ($action != 'Update') { ?>
                                        <td style="border: 2px solid #C0C0C0;">

                                            <?php
                                            if ($action == 'view' || $action == 'rec' || $action == 'apr') {
                                                echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                            } else if ($action == "dis") {
                                                ?>

                                                <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


                                        <?php } ?>

                                        </td>
        <?php } ?>





                                    <?php
                                    if ($action == 'view' || $action == 'apr') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_rec_qty) ? $ind_details->ind_rec_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'rec') {
                                        ?>

                                        <td class='width20' style="border: 2px solid #C0C0C0;">


                                            <input type="hidden" name="ds" id="<?php echo "dis_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_dis_qty; ?>">

                                            <input type="text" name="rec_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "dis_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to dispath qty',filter_number:'Qty should be in numbers'}">

                                        </td>

                                <?php } ?> 
                                </tr>
                                <?php
                                $count++;
                                ?>  
    <?php } ?>



                        </table>
                    </div>
                <?php } ?>


                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">Expected Date of Delivery</label></div>
                        <div class="width50 float_left">
<?= @$indent_data[0]->req_expected_date_time; ?>
                        </div>
                    </div>
<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="supervisor">Supervisor<span class="md_field">*</span></label></div>
                        <div class="filed_input float_left width50">
                            <input name="eqiup[req_supervisor]" tabindex="20" class="form_input  filter_required" placeholder="Supervisor" type="text"  data-errors="{filter_required:'Supervisor should not be blank!'}" value="<?= @$indent_data[0]->req_supervisor; ?>"   <?php echo $disabled; ?>>
                        </div>
                    </div>-->


                </div>
                <div class="field_row width100">

                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">District Manager</label></div>
                        <div class="width50 float_left">

                           <?= @$indent_data[0]->req_district_manager; ?>

                        </div>
                    </div>
                    <div class="filed_input float_left width2">

                        <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Standard Remark<span class="md_field">*</span></label></div>


                        <div class="filed_input float_left width50">
                            
                            <?php echo @$indent_data[0]->req_standard_remark; ?>
                            
                        </div>
                    </div>


                </div>
                <div class="field_row width100">

                    <?php if (($indent_data[0]->req_apr_date_time != '0000-00-00 00:00:00' && $indent_data[0]->req_apr_date_time != '' && $action == 'view' ) || $action == 'apr' || $action == 'dis') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Approval Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <?php
                                if ($indent_data[0]->req_apr_date_time != '0000-00-00 00:00:00') {
                                    echo $indent_data[0]->req_apr_date_time;
                                }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="width2 float_left">
                        <?php if (($action == 'apr' ) || ($indent_data[0]->req_approve_remark != '' && $action == 'view' || $action == 'dis')) { ?>


                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Approval Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">



                                 <?php
                                        if ($indent_data[0]->req_approve_remark == 'request_approve') {
                                            echo "Indent request Approve sucessfully.";
                                        }
                                        ?>
                               

                            </div>

                        <?php } ?>
                    </div>
                </div>
                <div class="field_row width100">

                    <?php if (($indent_data[0]->req_dispatch_date_time != '0000-00-00 00:00:00' && $indent_data[0]->req_dispatch_date_time != '' && $action == 'view' ) || $action == 'dis') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Dispatch Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="eqiup[req_dispatch_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?php
                                if ($indent_data[0]->req_dispatch_date_time != '0000-00-00 00:00:00') {
                                    echo $indent_data[0]->req_dispatch_date_time;
                                }
                                ?>"   <?php echo $dis; ?> >
                            </div>
                        </div>
                    <?php } ?>
                    <div class="width2 float_left">
                        <?php if ( ($indent_data[0]->req_dispatch_remark != '' && $action == 'view' || $action == 'dis')) { ?>


                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Dispatch Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">



                                <select name="eqiup[req_dispatch_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"   <?php echo $dis; ?>> 
                                    <option value="">Select Remark</option>

                                    <?php if ($action == 'dis' || $action == 'view') { ?>
                                        <option value="request_dispatch"  <?php
                                        if ($indent_data[0]->req_dispatch_remark == 'request_dispatch') {
                                            echo "selected";
                                        }
                                        ?>>Indent request Dispatch sucessfully.</option> 
                                            <?php } ?>
                                </select>


                            </div>

                        <?php } ?>
                    </div>
                </div>
 <div class="field_row width100">

                    <?php if (($indent_data[0]->req_receive_date_time != '0000-00-00 00:00:00' && $indent_data[0]->req_receive_date_time != '' && $action == 'view' ) || $action == 'rec') { ?>
                        <div class="width2 float_left">
                            <div class="field_lable float_left width33"> <label for="dard_time">Receive Date / Time<span class="md_field">*</span></label></div>
                            <div class="filed_input float_left width50">
                                <input name="eqiup[req_receive_date_time]" tabindex="20" class="form_input mi_timecalender filter_required" placeholder="Date/Time" type="text"  data-errors="{filter_required:'Date/Time should not be blank!'}" value="<?php
                                if ($indent_data[0]->req_receive_date_time != '0000-00-00 00:00:00') {
                                    echo $indent_data[0]->req_receive_date_time;
                                }
                                ?>"   <?php echo $dis; ?> >
                            </div>
                        </div>
                    <?php } ?>
                    <div class="width2 float_left">
                        <?php if ( ($indent_data[0]->req_receive_remark != '' && $action == 'view' || $action == 'rec')) { ?>


                            <div class="field_lable float_left width33"> <label for="mt_stnd_remark">Receive Remark<span class="md_field">*</span></label></div>


                            <div class="filed_input float_left width50">



                                <select name="eqiup[req_receive_remark]" tabindex="8" class="filter_required" data-errors="{filter_required:'Remark should not be blank!'}"   <?php echo $dis; ?>> 
                                    <option value="">Select Remark</option>

                                    <?php if ($action == 'rec' || $action == 'view') { ?>
                                        <option value="request_receive"  <?php
                                        if ($indent_data[0]->req_receive_remark == 'request_receive') {
                                            echo "selected";
                                        }
                                        ?>>Indent request Receive sucessfully.</option> 
                                            <?php } ?>
                                </select>


                            </div>

                        <?php } ?>
                    </div>
                </div>
    </div>
   
</div>
    </div>