<<div class="field_row width100" id="maintance_distance_travelled">

<div class="width2 float_left">
     <div class="field_lable float_left width33"> <label for="distance_travelled">Distance Travelled<span class="md_field"></span></label></div>


     <div class="filed_input float_left width50 "  >
         <input name="dist_travel" tabindex="25" class="form_input" placeholder="Distance Travelled" type="text" data-base="search_btn" data-errors="{filter_required:'Previous Odometer should not be blank!',filter_maxlength:'Previous Odometer at max 7 digit long.'}" value="<?= @$fuel_data[0]->ff_previous_odometer; ?>"   <?php echo $update; ?>>
     </div>
</div>
<div class="width2 float_left">
  <div class="field_lable float_left width33"> <label for="kmpl">KMPL<span class="md_field"></span></label></div>


<div class="filed_input float_left width50">
   <input name="kmpl" tabindex="25" class="form_input" placeholder="KMPL" type="text" data-base="search_btn" data-errors="{filter_required:'Current Odometer should not be blank!',filter_maxlength:'Current Odometer at max 7 digit long.'}" value="<?= @$fuel_data[0]->ff_previous_odometer; ?>"   <?php echo $update; ?>>
</div>
</div>

</div>