
<?php
//if (($clg_group == 'UG-FleetManagement' || $clg_group == 'UG-ZM' || $clg_group == 'UG-EMT' || $clg_group == 'UG-HEALTH-SUP' || $radmin ) && $action_type == 'Receive Indent') {
if ( $action_type == 'Receive Maintenance Part') {
    $act_url = "maintenance_part/receive_maintenance_part";

    $act = "RECEIVE";
} elseif ($action_type == 'Approve Maintenance Part') {

    $act_url = "maintenance_part/approve_maintenance_part";

    $act = "APPROVE";
} else if($action_type == 'Update Indent'){
     $act_url = "maintenance_part/edit_indent_request";

    $act = "Update";
}else {

    $act_url = "maintenance_part/dispatch_maintenance_part";

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

    <div class="box3">

        <form method="post" action="" id="view_indent">   

            <input type="hidden" name="dst_code" id="dist_id" value="<?php echo $indent_data[0]->req_district_code; ?>">

            <input type="hidden" name="amb_reg_no" id="amb_id" value="<?php echo $indent_data[0]->req_amb_reg_no; ?>">

            <input type="hidden" name="ind_req_id" id="" value="<?php echo $result[0]->ind_req_id; ?>">

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
                                $dt = array('dst_code' => $indent_data[0]->req_district_code, 'st_code' => $indent_data[0]->req_state_code, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
                            } else {
                                $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'incient', 'disabled' => '');
                            }

                            echo get_stat_dis($dt);
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
                                if (@$indent_data[0]->req_amb_reg_no != '') {
                                    $dt = array('dst_code' => @$indent_data[0]->req_district_code, 'st_code' => @$indent_data[0]->req_state_code, 'amb_ref_no' => @$indent_data[0]->req_amb_reg_no, 'auto' => 'inc_auto_addr', 'rel' => 'incient', 'disabled' => 'disabled');
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

<?php //var_dump(@$indent_data[0]); ?>
                        <div class="filed_input float_left width50" id="amb_base_location">
                            <input name="req[req_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$indent_data[0]->req_base_location; ?>" readonly="readonly"   <?php echo $update; ?> <?php echo $disabled;?>>

                        </div>


                    </div>
                    
                    
                </div>
                <div class="field_row width100">
                    <div id="maintance_request_previous_odometer">
                        <div class="width2 float_left" >
                            <div class="field_lable float_left width33"><label for="current_odometer">Previous Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" name="previous_odometer" value="<?= @$indent_data[0]->previous_odometer; ?>" class="filter_required filter_number filter_maxlength[7]" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" <?php echo $disabled;?>>


                            </div>
                        </div>
                        <div class="width2 float_left" >
                            <div class="field_lable float_left width33"><label for="current_odometer">Current Odometer<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <input type="text" name="current_odometer" value="<?= @$indent_data[0]->current_odometer; ?>" class="filter_required filter_number filter_maxlength[7]" placeholder="Current Odometer" data-errors="{filter_required:'Please select Current Odometer',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" <?php echo $disabled;?>>


                            </div>
                        </div>
                         <div class="width2 float_left" >
                            <div class="field_lable float_left width33"><label for="current_odometer">Maintanance type<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width50" >
                                <select name="ind[req_maintanance_type]" tabindex="8" <?php echo $update; ?> id="maintance_type" class="filter_required" data-errors="{filter_required:'Please select Maintenance type'}" <?php echo $disabled;?>> 
                                    <option value="" <?php echo $disabled; ?>>Select Maintenance type</option>
                                    <option value="Preventive" <?php if($indent_data[0]->current_odometer == 'Preventive'){ echo "selected"; }?>>Preventive</option>
                                    <option value="Breakdown" <?php if($indent_data[0]->current_odometer == 'Breakdown'){ echo "selected"; }?>>Breakdown</option>
                                    <option value="Accidental" <?php if($indent_data[0]->current_odometer == 'Accidental'){ echo "selected"; }?>>Accidental</option>
                                    <option value="Tyre" <?php if($indent_data[0]->current_odometer == 'Tyre'){ echo "selected"; }?>>Tyre</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
            <div class="field_row width100">


                <?php     
                 //var_dump($result);
                if (count($result) > 0) {
                    $count = 1;
                    $c = 0;
                    $total = count($result);
                
                 
                    foreach ($result as $ind_details) {
                        //var_dump($ind_details->ind_item_type);
                       // var_dump($ind_details->mt_part_type);
                        
                        $c++;
                        if (strpos($ind_details->mt_part_type, 'Force') !== false) {
                            
                            $item_name = $ind_details->inv_title;
                            $sku = $ind_details->inv_id;
                            $type = 'Force';
                           
                            $ind_details->sku=$ind_details->Item_Code;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$ind_details->Item_Code;
                            $ind_details->item_name=$item_name;
                            $ind_item['Force'][] = $ind_details;
                           // var_dump($ind_details->mt_part_type);
                            
                        } else if(strpos($ind_details->mt_part_type,'Ashok Leyland')!== false) {
                            $item_name = $ind_details->inv_title;
                            $sku = $ind_details->inv_id;
                            $type = 'Ashok Leyland';
                            //$sku_name = "NC";
                            $ind_details->sku=$sku;
                            $ind_details->type=$type;
                            $ind_details->sku_name=$ind_details->Item_Code;
                            $ind_details->item_name=$item_name;
                            $ind_item['Ashok_Leyland'][] = $ind_details;
                            
                        } 
                                               // var_dump($ind_item);
                        $args = array('inv_type'=>$ind_details->ind_item_type,'inv_id'=>$sku,'inv_district_id'=>$indent_data[0]->req_district_code);
                       
                         $stock_ind = get_maintance_part_stock_by_id($args);
                         
                         
                         $ind_details->in_stk =$stock_ind[0]->in_stk;
                         $ind_details->out_stk =$stock_ind[0]->out_stk;
                         
                         
                        $args_total = array('inv_type'=>$ind_details->ind_item_type,'inv_id'=>$sku);
                         
                        $stock_ind_total = get_maintance_part_stock_by_id($args_total);
                        
                        $ind_details->stk_total_out =$stock_ind_total[0]->out_stk;
                        $ind_details->stk_total =$stock_ind_total[0]->in_stk;
                    }
                }
               ?>
                <?php if (!empty($ind_item['Force'])) { ?>
                 <div class="field_row width100">
                                <h4>Maintenance Part : Force</h4>  
                                <table class="style3">
                                    <tr>   
                                        <td>Sr no</td>
                                        <td>#SKU</td>
                                        <td>Item Name</td>
                                          <td>Available Qty In Ambulance</td>
                                      

<!--                                        <td>Available stock</td>-->

                                        

                                        <td>Request Qty</td>
                                        <td>Approve Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td>Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['Force'] as $ind_details){   //var_dump($ind_details); ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $ind_details->sku_name;?></td>
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

<!--                                        <td>

                                            <?php
                                            if($ind_details->stk_total_out == NULL){
                                                $ind_details->stk_total_out =0;
                                            }
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

                                        </td>-->


                                    <?php //} ?>

                                    <td>
                                        <input type="hidden" name="qty" id="<?php echo "qty_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_quantity; ?>">
                                        <?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>
                                    <?php
                                    if ($action == 'view' || $action == 'rec' || $action == 'dis') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_apr_qty) ? $ind_details->ind_apr_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'apr') {
                                        ?>

                                        <td class='width20'>

                                            <input type="text" name="apr_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "qty_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to avail stock',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 


                                    <?php  if( $action != 'Update'){?>
                                    <td>

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>
<input type="hidden" name="apr" id="<?php echo "apr_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_apr_qty ? $ind_details->ind_apr_qty : "0"; ?>">
                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "apr_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than Approve stock',filter_number:'Qty should be in numbers'}">


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
                <?php if (!empty($ind_item['Ashok_Leyland'])) { ?>
                 <div class="field_row width100">
                                <h4>Maintenance Part : Ashok Leyland</h4>  
                                <table class="style3">
                                    <tr>   
                                        <td>Sr no</td>
                                        <td>#SKU</td>
                                        <td>Item Name</td>
                                        <td>Available Qty In Ambulance</td>
<!--                                        <td>Available stock</td>-->


                                        <td>Request Qty</td>
                                        <td>Approve Qty</td>
                                       

                                        <?php if($action != 'Update'){ ?>
                                        <td>Dispatch Qty</td>
                                        <?php } ?>

                                        <?php if ($action == 'view' || $action == 'apr' || $action == 'rec' || $action != 'Update') { ?> 

                                            <td>Received Qty</td>

                                        <?php } ?>

                                    </tr>  

                                <?php 
                                $count=1;
                                foreach($ind_item['Ashok_Leyland'] as $ind_details){   //var_dump($ind_details); ?>
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

<!--                                        <td>

                                            <?php //echo ($ind_details->stk_total) ? $ind_details->stk_total : "0"; 
                                            
                                            ?>
                                              <?php
                                            
                                              if($ind_details->stk_total_out == NULL){
                                                $ind_details->stk_total_out =0;
                                            }
                                            
                                            if($ind_details->stk_total > $ind_details->stk_total_out){
                                                $stock = $ind_details->stk_total - $ind_details->stk_total_out;
                                                echo $ind_details->stk_total - $ind_details->stk_total_out;
                                            }else{
                                                $stock = 10;
                                                 echo 10;
                                            } ?>

                                            <input type="hidden" name="stk" id="<?php echo "stk_" . $ind_details->ind_id; ?>" value="<?php echo $stock ? $stock : "0"; ?>">

                                        </td>-->


                                    <?php //} ?>

                                    <td>
                                         <input type="hidden" name="qty" id="<?php echo "qty_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_quantity; ?>">
                                        <?php //echo $ind_details->ind_quantity; 
                                    if ($action == "Update") {
                                            ?>

                                            <input type="text" name="in_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Request qty should be less than avail stock',filter_number:'Qty should be in numbers'}" value="<?php echo $ind_details->ind_quantity;?>">


                                        <?php }else {
                                            echo $ind_details->ind_quantity; 
                                         } ?>
                                    </td>
                                    
                                      <?php
                                    if ($action == 'view' || $action == 'rec' || $action == 'dis') {


                                        echo "<td class='width20'>";

                                        echo ($ind_details->ind_apr_qty) ? $ind_details->ind_apr_qty : '0';

                                        echo "</td>";
                                    } else if ($action == 'apr') {
                                        ?>

                                        <td class='width20'>


<!--                                            <input type="text" name="apr_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "stk_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to avail stock',filter_number:'Qty should be in numbers'}">-->
                                             <input type="text" name="apr_qty[<?php echo $ind_details->ind_id; ?>]" class=" style1 filter_required filter_number filter_lessthan[<?php echo "qty_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Qty should be equal or less to avail stock',filter_number:'Qty should be in numbers'}">

                                        </td>

                                    <?php } ?> 


                                    <?php  if( $action != 'Update'){?>
                                    <td>

                                        <?php
                                       
                                        if ($action == 'view' || $action == 'rec' || $action == 'apr' ) {
                                            echo ($ind_details->ind_dis_qty) ? $ind_details->ind_dis_qty : '0';
                                        } else if ($action == "dis") {
                                            ?>
                                        <input type="hidden" name="apr" id="<?php echo "apr_" . $ind_details->ind_id; ?>" value="<?php echo $ind_details->ind_apr_qty ? $ind_details->ind_apr_qty : "0"; ?>">

                                            <input type="text" name="dis_qty[<?php echo $ind_details->ind_id; ?>]" class="width20 style1 filter_required filter_number filter_lessthan[<?php echo "apr_" . $ind_details->ind_id; ?>]" data-errors="{filter_required:'Qty should not be blank',filter_lessthan:'Dispatch qty should be less than avail stock',filter_number:'Qty should be in numbers'}">


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



<!--                    <div class="width2 float_left">
                        <div class="field_lable float_left width33"> <label for="amount">District Manager<span class="md_field">*</span></label></div>
                        <div class="width50 float_left">

                            <input name="eqiup[req_district_manager]" tabindex="20" class="form_input  filter_required" placeholder="District Manager" type="text"  data-errors="{filter_required:'District Manager should not be blank!'}" value="<?= @$indent_data[0]->req_district_manager; ?>"  <?php echo $disabled; ?>>

                        </div>
                    </div>-->
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



        </form>  
    </div>
</div>