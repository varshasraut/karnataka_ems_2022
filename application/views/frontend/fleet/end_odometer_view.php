<?php
$odometer = $previous_odometer . '-' . $previous_odometer;

$filter_rangelength = "filter_rangelength[" . $odometer . "]";
?>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="previous_odometer">Previous Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="previous_odometer" value="<?= @$previous_odometer; ?>" class="filter_required filter_maxlength[8]" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Previous Odometer at max 7 digit long.'}" TABINDEX="8" readonly='readonly'>


    </div>
</div>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="in_odometer">In Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="in_odometer" value="" class="filter_required  <?php echo $filter_rangelength; ?> filter_maxlength[8]" placeholder="In Odometer" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'In Odometer should <?php echo $previous_odometer; ?>',filter_maxlength:'In Odometer at max 7 digit long.'}" TABINDEX="8">
    </div>
</div>
