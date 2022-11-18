<?php
$odometer = $previous_odometer . '-' . $previous_odometer;

$filter_rangelength = "filter_rangelength[" . $odometer . "]";
?>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="previous_odometer">Current Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="previous_odometer" value="<?= @$previous_odometer; ?>" class="filter_required filter_number filter_maxlength[7]" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" readonly='readonly'>


    </div>
</div>
<div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="ex_onroad_datetime"  value="" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div>
<!-- <div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="in_odometer" value="" class="filter_required  <?php echo $filter_rangelength; ?>" placeholder="Current Odometer" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'In Odometer should greater than or equlto Previous Odometer',filter_rangelength:'In Odometer should <?php echo $previous_odometer; ?>'}" TABINDEX="8">
    </div>
</div> -->
