<?php
// $odometer = $previous_odometer . '-' . $previous_odometer;

// $filter_rangelength = "filter_rangelength[" . $odometer . "]";
?>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="previous_odometer">Tyre Maintenance Previous Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="accidental[mt_tyre_previos_odometer]" value="<?= @$current_odometer; ?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Accidental Maintenance Previous Odometer',filter_maxlength:'Accidental Maintenance Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" readonly='readonly'>


    </div>
</div>
 <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Previous Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="previous_odometer" id="previous_odometer" onkeyup="sum();"  value="<?=@$previous_odometer;?>" class="filter_required" placeholder="Previous Odometer" data-errors="{filter_required:'Previous Odometer should not be blank'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?>>
                              
                           
                           
                        </div> 
 </div> 
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="in_odometer" value="" class="filter_required filter_valuegreaterthan[<?=@$previous_odometer;?>] filter_maxlength[7] filter_number" id="end_odometer" onkeyup="sum();"placeholder="Current Odometer" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'Current Odometer should greater than or equal Previous Odometer' ,filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8">
    </div>
</div>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="in_odometer">Odo meter Difference<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" id="distance" name="odometer_diff" class="filter_maxlength[7] filter_number" id="end_odometer" placeholder="Odo meter Difference" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'Current Odometer should greater than or equal Previous Odometer' ,filter_maxlength:'Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8">
    </div>
</div>
<script>
function sum() {
      var txtFirstNumberValue = document.getElementById('previous_odometer').value;
      var txtSecondNumberValue = document.getElementById('end_odometer').value;
      var result = parseInt(txtSecondNumberValue) - parseInt(txtFirstNumberValue);
      if (!isNaN(result)) {
         document.getElementById('distance').value = result;
      }
}
</script>
