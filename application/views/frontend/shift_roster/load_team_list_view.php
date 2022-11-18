<?php
$count = 1;
$start_days = 0;
for ($count = 1; $schedule_count >= $count; $count++) {
    //var_dump($start_date);
?>


    <div class="field_row width100">
        <div class="width2 float_left">
            <div class="shift width_30 float_left">

            </div>
            <div class="shift width70 float_left">

                <input name="manage_date[]" class="filter_required" value="<?php echo date('Y-m-d', strtotime($start_date . '+' . $start_days . ' days')); ?>" type="text" tabindex="2" placeholder="Date" data-errors="{filter_required:'Date should not blank'}" readonly="readonly">
            </div>
        </div>
        <div class="width2 float_left">
            <div class="shift width_20 float_left">
                <label for="sft2">Pilot Name<span class="md_field">*</span></label>

            </div>
            <div class="shift width_78 float_left">

                <input name="pilot[]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_clg/<?php echo $district_id ?>" data-value="<?php if ($second_shift_pilot != '') {
                                                                                                                                                                            echo $second_shift_pilot; ?>-<?php echo $second_shift_pilot_name;
                                                                                                                                                                                                } ?>" value="<?php if ($second_shift_pilot != '') {
                                                                                                                                                                                                                                                echo $second_shift_pilot;
                                                                                                                                                                                                                                            } ?>" type="text" tabindex="1" placeholder="Pilot Name" data-errors="{filter_required:'Pilot should not blank'}">
            </div>
        </div>



    </div>


    <!--<div class="shift width_30 float_left">                   

        <input name="emt[]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_clg/<?php echo $district_id ?>?emt=true" data-value="<?php if ($second_shift_emt != '') {
                                                                                                                                                                            echo $second_shift_emt; ?>-<?php echo $second_shift_emt_name;
                                                                                                                                                                                                    } ?>" value="<?php if ($second_shift_emt != '') {
                                                                                                                                                                                                                                                    echo $second_shift_emt;
                                                                                                                                                                                                                                                } ?>" type="text" tabindex="2" placeholder="EMT Name" data-errors="{filter_required:'EMT should not blank'}" >
    </div>

</div>-->
<?php
    $start_days++;
} ?>