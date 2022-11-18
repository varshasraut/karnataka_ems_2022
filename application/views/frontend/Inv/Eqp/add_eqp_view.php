<?php

if ($eqp_action == 'view') {
    $ftype = 'disabled';
}

(empty($eqp[0])) ? $href = "add" : ($href = "edit") && ($data_qr .= "eqp_id=" . $eqp[0]->eqp_id . "&amp;action=edit_eqp");

?>


<div class="width1 float_left">

    <form action="#" method="post" id="">

        <div class="width1 float_left">

            <h2 class="txt_clr2 width1 txt_pro hheadbg"> <?php echo ucfirst($eqp_action); ?> Equipment</h2>




            <div class="field_row">

                <div class="field_lable">

                    <label> Equipment Name<span class="md_field">*</span> :</label>

                </div>

                <div class="filed_input">

                    <input type="text" name="eqp_title" tabindex="1" value='<?php echo stripslashes($eqp[0]->eqp_name); ?>' class="filter_required" data-errors="{filter_required:'Equipment name should not be blank'}" <?php echo $ftype; ?>>
                </div>

            </div>


            <div class="field_row">

                <div class="field_lable">

                    <label>Set Minimum Quantity<span class="md_field">*</span> :</label>

                </div>

                <div class="filed_input">
                    <input type="text" name="eqp_base_qty" tabindex="2" value="<?php echo $eqp[0]->eqp_base_quantity; ?>" class="filter_required filter_no_whitespace filter_number" data-activeerror="" data-errors="{filter_required:'Minimum quantity should not be blank','filter_number':'Equipment minimum quantity should be in numbers',filter_no_whitespace:'Item minimum should not be allowed blank space.'}" <?php echo $ftype; ?>>
                </div>

            </div>

            <div class="field_row">

                <div class="field_lable">

                    <label>Inventory Types<span class="md_field">*</span> :</label>

                </div>

                <div class="filed_input">
                <select name="eqpp_type" class="filter_required" data-errors="{filter_required:'Equipment name should not be blank'}" TABINDEX="1.1" <?php echo $ftype; ?>>
                <option value="" selected="" disabled>Inventory Types</option>

                                        <?php echo get_equpp_type($eqp[0]->eqp_type); ?>
                        
                </div>

            </div>




            <?php if ($ftype != 'disabled') { ?>

                <div class="width2 margin_auto">

                    <div class="button_field_row">

                        <div class="button_box">

                            <input type="hidden" name="submit_eqp" value="sub_eqp">

                            <input type="button" name="submit" id="btnsave" value="Submit" class="btn submit_btnt form-xhttp-request" data-href="{base_url}eqp/<?php echo $href; ?>" data-qr="<?php echo $data_qr; ?>">

                            <input type="reset" name="Reset" value="Reset" class="btn">

                        </div>

                    </div>

                </div>

            <?php } ?>




        </div>

    </form>

</div>