<?php
$district = get_district_by_id($inc_emp_info[0]->amb_district);
?>
<input name="base_location" tabindex="9" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= $district; ?>" readonly="readonly">
