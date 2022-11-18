<?php
$CI = EMS_Controller::get_instance();

$eqp_status = get_status();

$sts = get_rev_status();
?>

<div class="breadcrumb float_left">

    <ul>

        <li class="sms">

            <a class="click-xhttp-request" data-href="{base_url}eqp/eqplist" data-qr=""> Inventory </a>

        </li>

        <li>
            <span>Equipment Listing</span>
        </li>

    </ul>

</div>


<div class="float_right ">

    <?= $CI->modules->get_tool_html('MT-ADD-INV-EQP', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=500  data-popupheight=370"); ?>


    <?= $CI->modules->get_tool_html('MT-MNG-STOCK-EQP', $CI->active_module, 'onpage_popup add_button_amb float_right', "", "data-popupwidth=500  data-popupheight=400"); ?>
<?php
if($filters != 'no'){ ?>
    <input type="button" class="search_button click-xhttp-request float_right rst_flt" name="" value="Reset Filters" data-href="{base_url}Eqp/eqplist" data-qr="output_position=content&amp;filters=reset"/>
<?php } ?>
</div>


<br>

<div class="box3">    




    <form method="post" name="mng_inveqp_form">


        <div id="eqp_filters">


        </div>


        <table class="table report_table">

            <tr>
                <th>
                    <input type="checkbox" title="Select All Items" name="selectall" class="base-select" data-type="default">
                </th>
                <th>Sr No.</th>
                <th>Equipment Name</th>
                <th>Minimum Qty.</th>
                <th>Balance</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            if (!empty($eqp_list)) {


                $view_per = $CI->modules->get_tool_config('MT-VIEW-INV-EQP', $this->active_module, true);
                $edit_per = $CI->modules->get_tool_config('MT-EIDT-INV-EQP', $this->active_module, true);
                $del_per = $CI->modules->get_tool_config('MT-DEL-INV-EQP', $this->active_module, true);
                $upst_per = $CI->modules->get_tool_config('MT-UP-INV-EQP-STS', $this->active_module, true);

                foreach ($eqp_list as $key=>$eqp) {
                     $cur_page_sr = ($pg_no - 1) * $per_page;
                    ?>

                    <tr>

                        <td>

                            <input type="checkbox" data-base="selectall" class="base-select" name="eqp_id[<?= $eqp->eqp_id; ?>]" value="<?= $eqp->eqp_id; ?>" title="Select All Medicines"/>

                        </td>

                         <td><?php echo $cur_page_sr + $key + 1; ?></td>
                        <td class="width50"><?php echo stripslashes($eqp->eqp_name); ?></td>
                        <td><?php echo $eqp->eqp_base_quantity; ?></td> 


                        <td>

        <?php
        $bal = 0;

//        $stock = $eqp->in_stk - $eqp->out_stk;
//
//        if ($stock > 0) {
//            $bal = $stock;
//        } else if ($eqp->in_stk > 0) {
//            $bal = $eqp->in_stk;
//        }
//
//        echo $bal;
        $args = array('inv_type'=>'EQP','inv_id'=>$eqp->eqp_id);
                            $stock_data = get_inv_stock_by_id($args);
                            if($_SERVER['REMOTE_ADDR'] == '49.35.124.219'){
                            //var_dump( $stock_data[0]->in_stk );
                            //var_dump( $stock_data[0]->out_stk );
                                
                            }
                            
                            $bal=0;
                            
                            $stock = $stock_data[0]->in_stk - $stock_data[0]->out_stk;
                            if($_SERVER['REMOTE_ADDR'] == '49.35.124.219'){
                           // var_dump($stock);
                                
                            }

                            if ($stock >= 0) {
                                $bal = $stock;
                            } else if ($stock_data[0]->in_stk > 0) {
                                $bal = $stock_data[0]->in_stk;
                            }

                            echo $bal;
        ?>

                        </td> 


                        <td><?php echo "<span class='" . $eqp_status[$eqp->eqp_status] . "'>" . $eqp_status[$eqp->eqp_status] . "</span>"; ?></td>
                        <td>


                            <div class="user_action_box">


                                <div class="colleagues_profile_actions_div"></div>


                                <ul class="profile_actions_list">


        <?php
        if ($view_per != '') {
            ?>    


                                        <li>

                                            <a class="onpage_popup action_button" data-href="{base_url}Eqp/edit"  data-qr="output_position=popup_div&amp;eqp_id=<?php echo $eqp->eqp_id; ?>&amp;eqp_action=view" data-popupwidth="500" data-popupheight="370">
                                                View

                                            </a>


                                        </li>

            <?php
        }

        if ($edit_per != '') {
            ?>

                                        <li>

                                            <a class="onpage_popup action_button" data-href="{base_url}Eqp/edit"  data-qr="output_position=popup_div&amp;eqp_id=<?php echo $eqp->eqp_id; ?>&amp;output_position=popup_div&amp;eqp_action=edit" data-popupwidth="500" data-popupheight="370">
                                                Edit

                                            </a>


                                        </li>


            <?php
        }

        if ($del_per != '') {
            ?>

                                        <li>

                                            <a class="action_button click-xhttp-request" data-href="{base_url}Eqp/del" data-qr="output_position=content&amp;eqp_id[0]=<?php echo $eqp->eqp_id; ?>&amp;action=del_eqp" data-confirm="yes" data-confirmmessage="Are you sure to delete this equipment ?">
                                                Delete
                                            </a>


                                        </li>

            <?php
        }

        if ($upst_per != '') {
            ?>

                                        <li>

                                            <a class="action_button click-xhttp-request" data-href="{base_url}Eqp/status" data-qr="output_position=content&amp;eqp_id=<?php echo $eqp->eqp_id; ?>&amp;eqp_sts=<?php echo $eqp->eqp_status; ?>&amp;action=up_status">


            <?php echo $sts[$eqp->eqp_status]; ?>


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

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}eqp/eqplist" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">

                        <span> Total records : <?php echo ($eqp_total) ? $eqp_total : '0'; ?> </span>

                    </div>


                </div>

            </div>

        </div>

    </form>



</div>




