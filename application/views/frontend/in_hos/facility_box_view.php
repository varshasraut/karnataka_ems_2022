
<?php //var_dump($hospital)?>

<input name="inter[<?php echo $facility;?>facility]" class="mi_autocomplete width100 filter_required" placeholder="Current Facility*" data-href="{base_url}auto/get_auto_hospital_new" type="text" data-errors="{filter_required:'Current Facility should not be blank'}" data-callback-funct="<?php echo $call_back_func;?>" id="current_facility" TABINDEX="13" data-value="<?php echo $hospital[0]->hp_name;?>" value="<?php echo $hospital[0]->hp_id;?>">