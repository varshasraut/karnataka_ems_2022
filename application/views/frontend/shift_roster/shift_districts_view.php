<div class="field_row width100">
    <div class="width2 float_left">    
        <div class="field_lable float_left width_30"><label for="district">District <span class="md_field">*</span></label></div>
        <div class="filed_input float_left width70">

            <input type="text" name="gri[gc_district_code]" data-value="<?= @$grievance_data[0]->dst_name ?>" value="<?= @$grievance_data[0]->dst_code; ?>" class="mi_autocomplete filter_required"  data-href="<?php echo base_url() ?>auto/get_district/MP" data-errors="{filter_required:'District should not be blank!'}" placeholder="District" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?> data-callback-funct="get_base_location">
        </div>
    </div>

    <div class="width2 float_left">
        <div class="field_lable float_left width20"><label for="district">Base Location <span class="md_field">*</span></label></div>


        <div class="filed_input float_left width_78" id="amb_base_location">
            <input name="stat[sc_base_location]" tabindex="23" class="form_input filter_required" placeholder=" Base Location" type="text" data-base="search_btn" data-errors="{filter_required:'Base Location should not be blank!'}" value="<?= @$fuel_data[0]->hp_name; ?>" readonly="readonly"   <?php echo $update; ?>>




        </div>
    </div>

    <input name="schedule_week" type="hidden"  id="schedule_week" value="<?= @$schedule_week; ?>" >
    <input name="schedule_end_week"  type="hidden"  id="schedule_end_week" value="<?= $schedule_end_week; ?>" >
    <input name="schedule_start_week"  type="hidden" id="schedule_start_week"  value="<?= $schedule_start_week; ?>" >
    <input name="schedule_month"  type="hidden"  id="schedule_month" value="<?= $schedule_month; ?>" >
    <input name="schedule_date" type="hidden"  id="schedule_date" value="<?= @$schedule_date; ?>" >

</div>