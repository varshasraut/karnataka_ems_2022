<?php
$CI = EMS_Controller::get_instance();

$inv_types = array('CA' => 'Consumables', 'NCA' => 'Non Consumables');
?>


<div class="breadcrumb float_left">
    <ul>
        <li class="sms">

            <a class="click-xhttp-request" data-href="{base_url}ind/ambulance_stock" data-qr="output_position=content&amp;inv_type=<?php echo $inv_type; ?>"> Inventory </a>

        </li>
        <li>
            <span> <?php echo $inv_types[$inv_type]; ?> Listing</span>
        </li>

    </ul>
</div>


<div class="width float_right ">

      <?php if($filters != 'no'){ ?>
    <input type="button" class="search_button click-xhttp-request float_right rst_flt" name="" value="Reset Filters" data-href="{base_url}Inv/invlist_amb" data-qr="output_position=content&amp;filters=reset&amp;inv_type=<?php echo $inv_type; ?>&inv_amb=amb"/>
      <?php } ?>


</div>

<br>


<div class="box3">    




    <form method="post" name="mng_inv_form">




        <div id="inv_filters">


        </div>



        <table class="table report_table">

            <tr>
                
                
                <th>Item Name</th>
                <th>Balance</th>
                <th>Unit Type</th>
                <th>Manufacture</th>
                 <th>Manufacture Date</th>
                <th>Expiry Date</th>
                
         
            </tr>

            <?php
            if (!empty($item_list)) {
                foreach ($item_list as $item) {
                   // var_dump($item);
                    ?>

                    <tr>
                        <td><?php echo stripslashes($item->inv_title); ?></td>
                        
                        <td>

                            <?php
                            
//                            $bal=0;
//                            
//                            $stock = $item->in_stk - $item->out_stk;
//
//                            if ($stock > 0) {
//                                $bal = $stock;
//                            } else if ($item->in_stk > 0) {
//                                $bal = $item->in_stk;
//                            }
//
//                            echo $bal;
                            ?>
                             <?php
                            $args = array('inv_type'=>$item->inv_type,'inv_id'=>$item->inv_id,'inv_amb'=>$inv_amb);
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
                        <td><?php echo $item->unt_title; ?></td>
                        <td><?php echo ($item->man_name) ? $item->man_name : '-'; ?></td>
                        <?php
                        if( $item->inv_manufacturing_date != '' && $item->inv_manufacturing_date != 0000-00-00 ){  
                            $manu_date =  date('Y-m-d', strtotime($item->inv_manufacturing_date));    
                        }else{
                            $manu_date ="";
                        }
                        ?> 
                        <td><?php echo $manu_date ? $manu_date : '-'; ?></td>
                        <td>
                        <?php if( $item->inv_exp_date != '' && $item->inv_exp_date != 0000-00-00 ){ 
                            $inv_exp_date=  date('Y-m-d', strtotime($item->inv_exp_date));    
                        }else{
                            $inv_exp_date ="";
                        }
                        ?> 
                            <?php echo ($inv_exp_date) ? $inv_exp_date : '-'; ?></td>

                      

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

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}Inv/invlist_amb" data-qr="output_position=content&amp;flt=true">

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




