<div class="field_row width2">

    <div class="field_lable float_left width33"> <label for="mt_amb_status">Ambulance Status<span class="md_field">*</span></label></div>
    <div class="filed_select width50 float_left">
        

        <select name="amb_status" class="amb_status filter_required" data-errors="{filter_required:'Ambulance status should not be blank'}" <?php echo $view; ?> TABINDEX="6" id="update_amb_status_eqp">

            <option value="">Select Status</option>
            <option value="13">In maintenance-OFF Road</option>

            <?php //echo get_amb_status($status); ?>
            <?php //echo get_amb_status_list($status); ?>
        </select>
<input type="hidden" name="amb_reg_no" id="amb_reg_no" value="<?php echo $get_amb_details[0]->amb_rto_register_no; ?>">
    </div>

</div>
<div class="field_row" id="ambu_start_end_record">

</div>