<?php
$CI = EMS_Controller::get_instance();

$tyre_status = get_status();

$sts = get_rev_status();

?>


<div class="breadcrumb float_left">
    <ul>
        <li class="sms">

            <a class="click-xhttp-request" data-href="{base_url}inv/tyrelist" data-qr="output_position=content&amp;inv_type=<?php echo $inv_type; ?>"> Inventory </a>

        </li>
        <li>
            <span> <?php echo $inv_types[$inv_type]; ?> Listing</span>
        </li>

    </ul>
</div>


<div class="width float_right ">

    <?= $CI->modules->get_tool_html('MT-ADD-TYRE', $CI->active_module, 'onpage_popup add_button_amb float_right', "", "data-popupwidth=500  data-popupheight=500"); ?>

   <?= $CI->modules->get_tool_html('MT-MNG-STOCK-TYRE', $CI->active_module, 'onpage_popup add_button_amb float_right', "", "data-popupwidth=500  data-popupheight=400"); ?>

    

    <?php if($filters != 'no'){ ?>
    <!--<input type="button" class="search_button click-xhttp-request float_right rst_flt" name="" value="Reset Filters" data-href="{base_url}Inv/tyrelist" data-qr="output_position=content&amp;filters=reset&amp;inv_type=<?php //echo $inv_type; ?>"/>-->
    <?php }?>


</div>

<br>


<div class="box3">    




    <form method="post" name="mng_inv_form">




        <div id="inv_filters">


        </div>



        <table class="table report_table">

            <tr>
                <th>
                    <!--<input type="checkbox" title="Select All Items" name="selectall" class="base-select" data-type="default">-->
                </th>
                <th>Sr No.</th>
                <th>Item Name</th>
                <th>Min Qty.</th>
                <th>Balance</th>
                <th>Manufacture</th>
                <th>Manufacture Date</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php
            if (!empty($item_list)) {


                $view_per = $CI->modules->get_tool_config('MT-VIEW-TYRE', $this->active_module, true);
                $edit_per = $CI->modules->get_tool_config('MT-EIDT-TYRE', $this->active_module, true);
                $del_per = $CI->modules->get_tool_config('MT-DEL-TYRE', $this->active_module, true);
                $upst_per = $CI->modules->get_tool_config('MT-UP-TYRE-STS', $this->active_module, true);

                foreach ($item_list as $item) {
                    //var_dump($item);
                    ?>

                    <tr>

                        <td>

                            <input type="checkbox" data-base="selectall" class="base-select" name="invid[<?= $item->inv_id; ?>]" value="<?= $item->inv_id; ?>" title="Select All Medicines"/>

                        </td>

                        <td><?php echo $item->tyre_id_new; ?></td>
                        <td><?php echo stripslashes($item->tyre_title); ?></td>
                        <td><?php echo $item->tyre_base_quantity; ?><?php //echo $item->inv_type;?></td> 
                        <td><?php echo '-'; ?><?php //echo $item->inv_type;?></td> 
                        <td><?php echo ($item->man_name) ? $item->man_name : '-'; ?></td>
                         <?php
                        if( $item->tyre_manufacturing_date != '' && $item->tyre_manufacturing_date != 0000-00-00 ){  
                            $manu_date =  date('Y-m-d', strtotime($item->tyre_manufacturing_date));    
                        }else{
                            $manu_date ="";
                        }
                        ?> 
                        <td><?php echo $manu_date ? $manu_date : '-'; ?></td>
                        <td>
                        <?php if( $item->tyre_exp_date != '' && $item->tyre_exp_date != 0000-00-00 ){ 
                            $tyre_exp_date=  date('Y-m-d', strtotime($item->tyre_exp_date));    
                        }else{
                            $tyre_exp_date ="";
                        }
                        ?> 
                            <?php echo ($tyre_exp_date) ? $tyre_exp_date : '-'; ?></td>
                        

                        <td><?php echo "<span class='" . $tyre_status[$item->tyreis_status] . "'>" . $tyre_status[$item->tyreis_status] . "</span>"; ?></td>
                        <td>


                            <div class="user_action_box">


                                <div class="colleagues_profile_actions_div"></div>


                                <ul class="profile_actions_list">


                                    <?php
                                    if ($view_per != '') {
                                        ?>    


                                        <li>

                                            <a class="onpage_popup action_button" data-href="{base_url}Inv/edit_tyre"  data-qr="output_position=popup_div&amp;tyre_id_new=<?php echo $item->tyre_id_new; ?>&amp;action=view" data-popupwidth="500" data-popupheight="500">
                                                View

                                            </a>


                                        </li>

                                        <?php
                                    }

                                    if ($edit_per != '') {
                                        ?>

                                        <li>

                                            <a class="onpage_popup action_button" data-href="{base_url}Inv/edit_tyre"  data-qr="output_position=popup_div&amp;tyre_id_new=<?php echo $item->tyre_id_new; ?>&amp;output_position=popup_div&amp;action=edit" data-popupwidth="500" data-popupheight="500">
                                                Edit

                                            </a>


                                        </li>


                                        <?php
                                    }

                                    if ($del_per != '') {
                                        ?>

                                        <li>

                                            <a class="action_button click-xhttp-request" data-href="{base_url}Inv/del_tyre" data-qr="output_position=content&amp;tyre_id_new[0]=<?php echo $item->tyre_id_new; ?>&amp;totrec=<?php echo $item_total; ?>&amp;action=del_inv" data-confirm="yes" data-confirmmessage="Are you sure to delete this item ?">
                                                Delete
                                            </a>


                                        </li>

                                        <?php
                                    }

                                    if ($upst_per != '') {
                                        ?>

                                        <li>

                                            <a class="action_button click-xhttp-request" data-href="{base_url}Inv/status" data-qr="output_position=content&amp;tyre_id_new=<?php echo $item->tyre_id_new; ?>&amp;inv_sts=<?php echo $item->tyreis_status; ?>&amp;action=up_status">


                                                <?php echo $sts[$item->inv_status]; ?>


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

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}Inv/invlist" data-qr="output_position=content&amp;flt=true">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records : <?php echo $item_total; ?> </span>
                    </div>

                </div>

            </div>

        </div>

    </form>



</div>




