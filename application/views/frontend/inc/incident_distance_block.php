   <div class="width50">
<div class="width50 float_left">
    <div class="style6">Base Location To Incident Address Distance<span class="md_field">*</span></div>  
    <div id="distance_time">
<!--        <input type="text" value="<?php echo $price;?>" name="price">-->
        <input name="incient[base_to_inc_distance]" value="<?php echo $inc_base_road_distance?$inc_base_road_distance:0; ?>" id="pac-input3" class="home_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Base Location To Incident Address Distance" readonly="readonly"> 
    </div>
</div>

<div class="width50 float_left">
    <div class="style6">Incident Address To Hospital Distance<span class="md_field">*</span></div>  
    <div id="distance_time">
        <input name="incient[inc_to_hosp_distance]" value="<?php echo $base_hp_road_distance?$base_hp_road_distance:0; ?>" id="pac-input3" class="home_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Incident Address To Hospital Distance" readonly="readonly"> 
    </div>
</div>
   </div>
   <div class="width50 ">
<div class="width50 float_left">
    <div class="style6">Hospital To Base Location Distance<span class="md_field">*</span></div>  
    <div id="distance_time">
        <input name="incient[hp_to_base_distance]" value="<?php echo $hp_base_distance?$hp_base_distance:0; ?>" id="pac-input3" class="home_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Hospital To Base Location Distance" readonly="readonly"> 
    </div>
</div>
<div class="width50 float_left">
    <div class="style6">Total Distance<span class="md_field">*</span></div>  
    <div id="distance_time">
        <input name="incient[case_total_distance]" value="<?php echo $total_dist; ?>" id="pac-input3" class="home_dtl filter_required" data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Total Distance" readonly="readonly"> 
    </div>
</div>
   </div>
<div class="width50 ">
<div class="width50 float_left">
    <div class="style6">Total Amount<span class="md_field">*</span></div>  
    <div id="distance_time">
        <input name="incient[total_amount]" value="<?php echo $total_amount?$total_amount:0; ?>" id="pac-input3" class="home_dtl filter_required"  data-errors="{filter_required:'Address should not be blank'}"tabindex="16" type="text" placeholder="Hospital To Base Location Distance" readonly="readonly"> 
    </div>
</div>
   </div>
