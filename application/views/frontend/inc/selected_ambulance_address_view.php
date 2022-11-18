<style>
    .base{
        margin-top:-12px;
    }
   .input1{
        margin-left:-21px !important;
    }
    .width15{
        width:15% !important;
    }
    .input2{
        margin-left: 52px !important;
    }
    .category{
        width: 16% !important;
        margin: -10px 0 0 70px !important;
    }
    .input3{
        margin-left: -30px !important;
    }
    .rate{
        margin-top:-8px;
    }
    .input4{
        margin-left:-12px !important;
    }
</style>
<div class="width_100">
    <div class="width20 float_left base"><label>Base Location : <label></div>
    <div class="width80 float_left"><input name="incient[base_location_address]" value="<?php echo $amb_data[0]->hp_address; ?>" id="pac-input3" class=" filter_required input1"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Google location map address" Readonly></div> 
</div>
<div class="width_100">
    <div class="width10 float_left base"><label>Type : <label></div>
    <div class="width15 float_left"><input name="incient[type]" value="<?php echo $amb_data[0]->ambt_name; ?>" id="pac-input3" class=" filter_required input2"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Type" Readonly></div> 
    <div class="width10 float_left category"><label>Category : <label></div>
    <div class="width15 float_left"><input name="incient[category]" value="<?php echo $amb_data[0]->amb_category; ?>" id="pac-input3" class=" filter_required input3"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Category" Readonly></div> 
    <div class="width10 float_left rate"><label>Rate: <label></div>
    <div class="width15 float_left"><input name="incient[rate_per_km]" value="<?php echo $price; ?>" id="pac-input3" class=" filter_required input4"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Type" Readonly></div> 
    
</div>
<input type="hidden" id="base_lat" value="<?php echo $amb_data[0]->hp_lat; ?>" name="incient[base_lat]">
<input type="hidden" id="base_lng" value="<?php echo $amb_data[0]->hp_long; ?>" name="incient[base_lng]">
<input type="hidden" id="base_id" value="<?php echo $amb_data[0]->hp_id; ?>" name="incient[base_id]">
<input type="hidden" id="base_selected_amb" value="<?php echo $base_selected_amb; ?>" name="incient[base_selected_amb]">