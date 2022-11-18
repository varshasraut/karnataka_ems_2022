<?php 
if($id != '0'){?>
<input name="pilot_id" tabindex="25" class="form_input" placeholder="Pilot Name" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}" value="<?php echo $pilot_name; ?>" readonly="readonly">
<?php }else{ ?>
<input name="pilot_id" tabindex="25" class="form_input" placeholder="Pilot Name" type="text" data-base="search_btn" data-errors="{filter_required:'Pilot Name should not be blank!'}" value="<?php echo $pilot_name; ?>">
<?php } ?>
