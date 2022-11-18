<?php
$CI = EMS_Controller::get_instance();

$med_status = get_status();

$sts = get_rev_status();
?>

<div class="box3">    

    <form method="post" name="mng_invmed_form">


        <table class="table report_table">

            <tr>
                <th>Medicine Name</th>
                <th>Balance</th>
                <th>Unit Type</th>
                <th>Manufacture</th>

            </tr>

            <?php
            if (!empty($med_list)) {


                foreach ($med_list as $med) {?>

                    <tr>
                        <td><?php echo stripslashes($med->med_title); ?></td>


                        <td>

                            <?php
                            $bal = 0;

                            $stock = $med->in_stk - $med->out_stk;

                            if ($stock > 0) {
                                $bal = $stock;
                            } else if ($med->in_stk > 0) {
                                $bal = $med->in_stk;
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



    </form>



</div>




