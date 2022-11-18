<?php $CI = EMS_Controller::get_instance(); ?>
<div style="display:none"><input id="maintenance_type" name="maintenance_type" value="<?php echo $maintenance_type; ?>"></input></div>
<div class="width100">
    <div class="filed_select">
        <div class="field_row drg float_left">
            <div class="width100 float_left">
                <div class="style6 float_left">Select Report Type: </div>
            </div>
            <div class="width100 float_left">  
                <select name="report_type" class="change-base-xhttp-request" data-base="report_type" data-href="{base_url}erc_reports/load_maintenance_sub_date_report_form" data-qr="output_position=content">
                    <option value="">Select Report</option>
                    <option value="1">Datewise </option>
                    <option value="2">Monthwise</option>
                </select>
            </div>
        </div>
    </div>
</div>