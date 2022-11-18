<?php
// $odometer = $previous_odometer . '-' . $previous_odometer;

// $filter_rangelength = "filter_rangelength[" . $odometer . "]";
?>
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="previous_odometer">Fuel Filling Previous Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >
        <input type="text" name="fuel[ff_fuel_previous_odometer]" id="fuel[ff_fuel_previous_odometer]" readonly="readonly" value="<?= @$current_odometer; ?>"  class="filter_required filter_maxlength[7] filter_number" placeholder="Previous Odometer" data-errors="{filter_required:'Please select Previous Odometer',filter_maxlength:'Fuel Filling Previous Odometer at max 6 digit long.',filter_number:'number shuold be integer'}" TABINDEX="8" id="previous_odometer">


    </div>
</div>
 <div class="width2 float_left">
                        
                        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Last Updated Odometer<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width50" >
                              <input type="text" name="previous_odometer" id="previous_odometer" onchange="sum();"  value="<?=@$previous_odometer;?>" class="filter_required filter_maxlength[7]" placeholder="Last Updated Odometer" data-errors="{filter_required:'Previous Odometer should not be blank',filter_maxlength:'Fuel Filling Previous Odometer at max 6 digit long.'}" TABINDEX="8" <?php echo $update; echo $approve; echo $rerequest;?> maxlength="6" readonly='readonly'>
                              
                           
                           
                        </div> 
 </div> 
<div class="width2 float_left">
    <div class="field_lable float_left width33"><label for="in_odometer">Current Odometer<span class="md_field">*</span></label></div>

    <div class="filed_input float_left width50" >

        <input type="text" name="in_odometer" id="in_odometer" value="" class="filter_required filter_maxlength[7] filter_number" id="end_odometer" onchange="sum();"  placeholder="Current Odometer" data-errors="{filter_required:'In odometer should not be blank',filter_valuegreaterthan:'Current Odometer should greater than or equal Previous Odometer' ,filter_maxlength:'Current Odometer at max 6 digit long.',filter_number:'number shuold be integer',filter_rangelength:'END Odometer between range  <?php echo $previous_odometer ?> - <?php echo $previous_odometer+1000; ?>'}" TABINDEX="8" maxlength="6">
    </div>
</div>
<script>
    

function sum() {
        var txtFirstNumberValue = document.getElementById('fuel[ff_fuel_previous_odometer]').value;
        var txtSecondNumberValue = document.getElementById('in_odometer').value;
        var lastupdateodo = document.getElementById('previous_odometer').value;
        if(((parseInt(txtFirstNumberValue) < parseInt(txtSecondNumberValue)) || (parseInt(txtFirstNumberValue) == parseInt(txtSecondNumberValue)))){
            var result = parseInt(txtSecondNumberValue) - parseInt(txtFirstNumberValue);
            if (!isNaN(result)) {
                document.getElementById('distance').value = result;
            }
        }else{
            alert("Current Odometer should be greater than Previous fuel filling Odometer.")
            document.getElementById('in_odometer').value = '';
        }

        var txtFirstNumberValue = document.getElementById('distance').value;
        var txtSecondNumberValue = document.getElementById('fuel').value;
        var result = (txtFirstNumberValue) / (txtSecondNumberValue);
        //var res = result.tofixed(2);
        if (!isNaN(result)) {
            if(result!=Infinity){
            // alert(res);
            //var res= Math.round( result,2);
            var res = Math.round(result * 100) / 100;
            document.getElementById('kmpl').value = res;
            //var res= result.tofixed(2);
            //alert(res);
            }
        }

       
    }
</script>
