

    <div class="field_lable float_left width33"><label for="mobile_no">Mobile No<span class="md_field"></span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="fuel_mobile_no" value="<?= @$fuel_station[0]->f_mobile_no; ?>" pattern="[7-9]{1}[0-9]{9}" maxlength="10" class="" placeholder="Mobile No" data-errors="{filter_required:'Mobile No should not be blank!'}" TABINDEX="8">
    </div>

