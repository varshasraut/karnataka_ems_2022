<?php
$CI = EMS_Controller::get_instance();

?>

<div class="breadcrumb float_left">

    <ul>

        <li class="sms">

           <a class="click-xhttp-request" data-href="{base_url}ind/ambulance_stock" data-qr="output_position=content&amp;inv_type=<?php echo $inv_type; ?>"> Inventory </a>

        </li>

        <li>
            <span>Medicines Listing</span>
        </li>

    </ul>

</div>

<div class="width2 float_right ">

<?php if($filters != 'no'){ ?>
    <input type="button" class="search_button click-xhttp-request float_right rst_flt" name="" value="Reset Filters" data-href="{base_url}Med/medlist_amb" data-qr="output_position=content&amp;filters=reset&med_amb=amb"/>
<?php } ?>

</div>


<br>

<div class="box3">    




    <form method="post" name="mng_invmed_form">


        <div id="med_filters">


        </div>

        <table class="table report_table">

            <tr>

                <th>Medicine Name</th>
                <th>Minimum Qty.</th>
                <th>Balance</th>
                <th>Unit Type</th>
                <th>Manufacture</th>
          

            </tr>

            <?php
            if (!empty($med_list)) {


               

                foreach ($med_list as $med) {
                    
                   
                    
                    ?>

                    <tr>

                       

                        
                        <td><?php echo stripslashes($med->med_title); ?></td>
                        <td><?php echo $med->med_base_quantity; ?></td> 


                        <td>

                            <?php
//                            $bal = 0;
//
//                            $stock = $med->in_stk - $med->out_stk;
//
//                            if ($stock > 0) {
//                                $bal = $stock;
//                            } else if ($med->in_stk > 0) {
//                                $bal = $med->in_stk;
//                            }
//
//                            echo $bal;
                            ?>
                               <?php
                            $args = array('inv_type'=>'MED','inv_id'=>$med->med_id,'inv_amb'=>$med_amb);
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

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}Med/medlist_amb" data-qr="output_position=content&amp;flt=true">

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




