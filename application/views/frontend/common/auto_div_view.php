<input name="<?php echo $dt_rel;?>_division" value="<?php echo $div_code; ?>" class="mi_autocomplete width97" data-href="<?php base_url();?>auto/get_division_district/MP" placeholder="Division" data-errors="{filter_required:\'Please select district from dropdown list\'}" data-base=""  data-value="<?php echo $div_name; ?>" data-auto="<?php echo $auto;?>" data-callback-funct="load_div_district" data-rel="<?php echo $dt_rel; ?>" <?php echo $disabled; ?> >