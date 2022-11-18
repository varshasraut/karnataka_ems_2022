<?php
$CI = EMS_Controller::get_instance();
?>

<div class="breadcrumb float_left">

    <ul>

        <li class="sms">

           <a class="click-xhttp-request" data-href="{base_url}ind/ambulance_stock" data-qr="output_position=content&amp;inv_type=<?php echo $inv_type; ?>"> Inventory </a>

        </li>

        <li>
            <span>Equipment Listing</span>
        </li>

    </ul>

</div>


<div class="width2 float_right ">

<?php if($filters != 'no'){ ?>
    <input type="button" class="search_button click-xhttp-request float_right rst_flt" name="" value="Reset Filters" data-href="{base_url}Eqp/eqplist_amb" data-qr="output_position=content&amp;filters=reset&eqp_amb=amb"/>
<?php } ?>
</div>


<br>

<div class="box3">    




    <form method="post" name="mng_inveqp_form">


        <div id="eqp_filters">


        </div>


        <table class="table report_table">

            <tr>


                <th>Equipment Name</th>
                <th>Balance</th>

            </tr>

            <?php
            if (!empty($eqp_list)) {



                foreach ($eqp_list as $eqp) {
                    ?>

                    <tr>


                        <td class="width50"><?php echo stripslashes($eqp->eqp_name); ?></td>



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

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}eqp/eqplist_amb" data-qr="output_position=content&amp;flt=true">

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




