<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width100">
    <div class="filed_select">
        <div class="field_row drg float_left">
            <div class="width100 float_left">
                <div class="style6 float_left">Select Type: </div>
            </div>
            <div class="width100 float_left">  
                <select name="date_report_type" class="change-base-xhttp-request  filter_required" data-href="{base_url}erc_reports/<?php echo $submit_function; ?>" data-qr="output_position=content" data-errors="{filter_required:'closuer date should not be blank!'}">
                    <option value="">Select Type</option>
                    <option value="1">Datewise </option>
                    <!-- <option value="2">Monthwise</option> -->
                </select>
            </div>
        </div>
    </div>
</div>

