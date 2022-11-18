<?php 
$user_name = $emp_info[0]->clg_first_name.' '.$emp_info[0]->clg_last_name;
?>

<div class="width33  float_left">
    <div class="width_30 float_left">User Name<span class="md_field">*</span> : </div>
    <div class="width70 float_left">
        <input name="crud[user_name]" tabindex="25" class="form_input filter_required" placeholder="User Name" type="text" data-base="search_btn" data-errors="{filter_required:'Doctor Name should not be blank!'}" value="<?= $user_name; ?>">
    </div>
</div>
<div class="width33">
    <div class="shift width_30 float_left">User Group<span class="md_field">*</span> : </div>

    <div class="shift width70 float_left">
        <input name="crud[user_group]" tabindex="25" class="form_input filter_required" placeholder="User Group" type="text" data-base="search_btn" data-errors="{filter_required:'User group should not be blank!'}" value="<?= $emp_info[0]->clg_group; ?>">
        <input name="emt_id" tabindex="25" class="form_input"  type="hidden" value="<?= $inc_emp_info[0]->amb_emt_id; ?>">
    </div>
</div>