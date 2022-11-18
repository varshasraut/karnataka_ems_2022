
<?php if($f_id == 'Other'){  ?> <div class="field_lable float_left width33"><label for="address">Fuel Station Name<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="fuel[ff_other_fuel_station]" id="fuel[ff_other_fuel_station]" value="<?= @$fuel_station[0]->ff_other_fuel_station; ?>" class="filter_required" placeholder="Address" data-errors="{filter_required:'Address should not be blank!'}" TABINDEX="8">
    </div>
<?php
}?>
    <div class="field_lable float_left width33"><label for="address">Address<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="fuel[ff_fuel_address]" id="fuel[ff_fuel_address]" value="<?= @$fuel_station[0]->f_address; ?>" class="filter_required" placeholder="Address" data-errors="{filter_required:'Address should not be blank!'}" TABINDEX="8" <?php if($f_id != 'Other'){ echo "readonly='readonly'"; }?> >
    </div>

