<div class="width100">
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Date<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
            <input name="odometer_date" tabindex="0" class="form_input filter_required mi_calender" placeholder="Date" type="text" data-base="search_btn" value=""  data-errors="{filter_required:'Date should not be blank!'}" readonly="readonly">
        </div>
    </div>
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Time<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
            <input name="odometer_time" tabindex="0" class="form_input filter_required mi_timepicker" placeholder="Time" type="text" data-base="search_btn" value=""  data-errors="{filter_required:'Time should not be blank!'}" readonly="readonly">
        </div>
    </div>
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Previous Odometer<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
            <input name="previous_odmeter" tabindex="0" class="form_input filter_required" placeholder="" type="text" data-base="search_btn" value="<?php echo $previous_odometer; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!'}" readonly="readonly">
        </div>
    </div>
    <?php
    if ($amb_status == '6') {
        $disable = "disabled";
        $start = $previous_odometer;
    } else {
        $disable = "";
        $start = "";
    }
    ?>
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">In Odometer<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">
            <input name="start_odmeter" tabindex="1" class="filter_required form_input filter_number filter_rangelength[<?php echo $previous_odometer; ?>-<?php echo $previous_odometer; ?>] filter_maxlength[8]"  placeholder="Enter Start Odometer" type="text" data-base="search_btn" value="<?php echo $start; ?>"  data-errors="{filter_required:'Start Odometer should not be blank!',filter_number:'Start Odometer should not be Number!',filter_rangelength:'Start Odometer should not be same as previous odometer!',,filter_maxlength:'IN Odometer at max 7 digit long.'}" <?php echo $disable; ?>>
        </div>
    </div>
    <?php if ($amb_status == '6') { ?>
        <div class="width50 drg float_left">
            <div class="width33 float_left">
                <div class=" float_left">End Odometer<span class="md_field">*</span> : </div>
            </div>
            <div class="width50 float_left">
                <input name="end_odmeter" tabindex="1" class="filter_required form_input filter_valuegreaterthan[<?php echo $previous_odometer; ?>] filter_maxlength[8]"  placeholder="Enter End Odometer" type="text" data-base="search_btn" value=""  data-errors="{filter_required:'End Odometer should not be blank!',filter_valuegreaterthan:'Start Odometer should not be Greater than previous odometer!',filter_maxlength:'END Odometer at max 7 digit long.'}" >
            </div>
        </div>
    <?php } ?>

    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left">Standard Remark<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">

            <input name="remark"  id="remark_input" class="mi_autocomplete filter_required" data-href="{base_url}auto/get_odometer_remark" data-value="" value="" type="text" tabindex="2" placeholder="Remark" data-callback-funct="show_other_odometer" data-errors="{filter_required:'Remark should not be blank!'}">
        </div>
    </div>
    <div class="width50 drg float_left">
        <div class="width33 float_left">
            <div class=" float_left"> Remark<span class="md_field">*</span> : </div>
        </div>
        <div class="width50 float_left">

            <input name="common_remark_other" class="filter_required"  value="" type="text" tabindex="2" placeholder=" Remark" data-errors="{filter_required:'  Remark should not be blank!'}" >
        </div>
    </div> 
</div>
<div class="field_row width100">
    <div id="odometer_remark_other_textbox">

    </div>
</div>

<div class="field_row width100">
    <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="off_road_date">Off-road  Date/Time<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >
            <input type="text" name="breakdown[mt_offroad_datetime]"  value="<?= @$preventive[0]->mt_offroad_datetime; ?>" class="filter_required mi_timecalender" id="offroad_datetime" placeholder="Off-Road  Date/Time" data-errors="{filter_required:'Off-Road  Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; ?>>



        </div>
    </div>
    <div class="width2 float_left">

        <div class="field_lable float_left width33"><label for="mt_ex_onroad_datetime">Expected Onroad Date/Time<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50" >
            <input type="text" name="breakdown[mt_ex_onroad_datetime]"  value="<?= @$preventive[0]->mt_ex_onroad_datetime; ?>" class="filter_required OnroadDate" placeholder="Expected On-Road Date/Time" data-errors="{filter_required:'Expected On-Road Date/Time should not be blank'}" TABINDEX="8" <?php echo $update; ?>>



        </div>
    </div>
</div>

<script>

    jQuery(document).ready(function () {
        var jsDate = $("#offroad_datetime").val();
        var $mindate = new Date(jsDate);


        $('#mt_onroad_datetime').datetimepicker({
            dateFormat: "yy-mm-dd",
            minDate: $mindate,
            // minTime: jsDate[1],

        });
        $("#offroad_datetime").change(function () {
            var jsDate = $("#offroad_datetime").val();
            var $mindate = new Date(jsDate);


            $('.OnroadDate').datetimepicker({
                dateFormat: "yy-mm-dd ",
                minDate: $mindate,
                // minTime: jsDate[1],

            });
        });
    });

</script>