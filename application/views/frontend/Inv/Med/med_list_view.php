<?php
$CI = EMS_Controller::get_instance();

$med_status = get_status();

$sts = get_rev_status();
?>

<div class="breadcrumb float_left">

    <ul>

        <li class="sms">

            <a class="click-xhttp-request" data-href="{base_url}med/medlist" data-qr="output_position=content"> Inventory </a>

        </li>

        <li>
            <span>Medications Listing</span>
        </li>

    </ul>

</div>

<div class="width float_right ">

    <?= $CI->modules->get_tool_html('MT-ADD-INV-MD', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=500  data-popupheight=500"); ?>

    <?= $CI->modules->get_tool_html('MT-MNG-STOCK-MD', $CI->active_module, 'onpage_popup add_button_amb float_right', "", "data-popupwidth=500  data-popupheight=400"); ?>

<?php if($filters != 'no'){ ?>
    <input type="button" class="search_button click-xhttp-request float_right rst_flt" name="" value="Reset Filters" data-href="{base_url}Med/medlist" data-qr="output_position=content&amp;filters=reset"/>

<?php } ?>
</div>


<br>

<div class="box3">    




    <form method="post" name="mng_invmed_form">


        <div id="med_filters">


        </div>

        <table class="table report_table">

            <tr>

                <th>
                    <input type="checkbox" title="Select All Items" name="selectall" class="base-select" data-type="default">
                </th>
                <th>Sr No.</th>
                <th>Medicine Name</th>
                <th>Minimum Qty.</th>
                <th>Balance</th>
                <th>Unit Type</th>
                <th>Manufacture</th>
                 <th>Manufacture Date</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Action</th>

            </tr>

            <?php
            if (!empty($med_list)) {


                $view_per = $CI->modules->get_tool_config('MT-VIEW-INV-MD', $this->active_module, true);
                $edit_per = $CI->modules->get_tool_config('MT-EIDT-INV-MD', $this->active_module, true);
                $del_per = $CI->modules->get_tool_config('MT-DEL-INV-MD', $this->active_module, true);
                $upst_per = $CI->modules->get_tool_config('MT-UP-INV-MD-STS', $this->active_module, true);

                foreach ($med_list as $key=>$med) {
                    
                    //var_dump($med);
                    
                    ?>

                    <tr>

                        <td>

                            <input type="checkbox" data-base="selectall" class="base-select" name="med_id[<?= $med->med_id; ?>]" value="<?= $med->med_id; ?>" title="Select All Medicines"/>

                        </td>

                        <td><?php echo $key+1; ?></td>
                        <td><?php echo stripslashes($med->med_title); ?></td>
                        <td><?php echo $med->med_base_quantity; ?></td> 


                        <td>

                            <?php
//                            $bal = 0;
//
//                            $stock = $med->in_stk - $med->out_stk;
//
//                            if ($stock >= 0) {
//                                $bal = $stock;
//                            } else if ($med->in_stk > 0) {
//                                $bal = $med->in_stk;
//                            }
//
//                            echo $bal;
                            ?>
                               <?php
                            $args = array('inv_type'=>'MED','inv_id'=>$med->med_id);
                            $stock_data = get_inv_stock_by_id($args);
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

                        </td> 

                        <td><?php echo $med->unt_title; ?></td>
                        <td><?php echo ($med->man_name) ? $med->man_name : '-'; ?></td>
                        <?php
                        if( $med->med_manufacturing_date != '' && $med->med_manufacturing_date != 0000-00-00 ){  
                            $manu_date =  date('Y-m-d', strtotime($med->med_manufacturing_date));    
                        }else{
                             $manu_date = "";
                        }
                        ?> 
                        <td><?php echo $manu_date ? $manu_date : '-'; ?></td>
                        <td>
                        <?php if( $med->med_exp_date != '' && $med->med_exp_date != 0000-00-00 ){ 
                            $inv_exp_date=  date('Y-m-d', strtotime($med->med_exp_date));    
                        }else{
                            $inv_exp_date="";
                        }
                        ?> 
                            <?php echo ($inv_exp_date) ? $inv_exp_date : '-'; ?></td>
                        
                        <td><?php echo "<span class='" . $med_status[$med->med_status] . "'>" . $med_status[$med->med_status] . "</span>"; ?></td>
                        <td>


                            <div class="user_action_box">


                                <div class="colleagues_profile_actions_div"></div>


                                <ul class="profile_actions_list">


                                    <?php
                                    if ($view_per != '') {
                                        ?>    


                                        <li>

                                            <a class="onpage_popup action_button" data-href="{base_url}Med/edit"  data-qr="output_position=popup_div&amp;med_id=<?php echo $med->med_id; ?>&amp;med_action=view" data-popupwidth="500" data-popupheight="500">
                                                View

                                            </a>


                                        </li>

                                        <?php
                                    }

                                    if ($edit_per != '') {
                                        ?>

                                        <li>

                                            <a class="onpage_popup action_button" data-href="{base_url}Med/edit"  data-qr="output_position=popup_div&amp;med_id=<?php echo $med->med_id; ?>&amp;output_position=popup_div&amp;med_action=edit" data-popupwidth="500" data-popupheight="500">
                                                Edit

                                            </a>

                                        </li>


                                        <?php
                                    }

                                    if ($del_per != '') {
                                        ?>

                                        <li>

                                            <a class="action_button click-xhttp-request" data-href="{base_url}Med/del" data-qr="output_position=content&amp;med_id[0]=<?php echo $med->med_id; ?>&amp;action=del_med" data-confirm="yes" data-confirmmessage="Are you sure to delete this item ?">
                                                Delete
                                            </a>


                                        </li>

                                        <?php
                                    }

                                    if ($upst_per != '') {
                                        ?>

                                        <li>

                                            <a class="action_button click-xhttp-request" data-href="{base_url}Med/status" data-qr="output_position=content&amp;med_id=<?php echo $med->med_id; ?>&amp;med_sts=<?php echo $med->med_status; ?>&amp;action=up_status">


                                                <?php echo $sts[$med->med_status]; ?>


                                            </a>


                                        </li>


                                    <?php } ?>


                                </ul>


                            </div>

                        </td>

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


        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>


            <div class="width38 float_right">


                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}Med/medlist" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records : <?php echo ($med_total) ? $med_total : '0'; ?> </span>
                    </div>

                </div>

            </div>

        </div>

    </form>



</div>




