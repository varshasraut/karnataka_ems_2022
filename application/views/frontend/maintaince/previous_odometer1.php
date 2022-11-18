<?php
$odometer = $previous_odometer;
 $odometer_end =        $previous_odometer+300;

$filter_rangelength = "filter_rangelength[" . $odometer . "-".$odometer_end."]";
?>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="previous_odometer">Previous Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="previous_odometer" value="<?= @$previous_odometer; ?>" class="filter_required " placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer'}" TABINDEX="8" readonly='readonly'>


    </div>
</div>
<!-- <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="ex_onroad_datetime"  value="" class="filter_required mi_timecalender" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div> -->
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="in_odometer" value="" class="filter_required filter_maxlength[7] filter_number <?php echo $filter_rangelength;?>" placeholder="Current Odometer" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'Current Odometer should greater than or equal to Previous Odometer',filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'Enter only number only.',filter_rangelength:'END Odometer between range  <?php echo $previous_odometer ?> - <?php echo $previous_odometer+300; ?>'}" TABINDEX="8">
    </div>
</div>
