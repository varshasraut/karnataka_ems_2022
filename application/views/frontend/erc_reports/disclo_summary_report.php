<div class="width100">
    <input type="hidden" data-base='details_report_type' name="divs" value="<?php echo $divs; ?>">
    <input type="hidden" data-base='details_report_type' name="dist"  value="<?php echo $dist; ?>">
    <div class="filed_select">
        <div class="field_row drg float_left">
            <div class="width100 float_left">
                <div class="style6 float_left">Select  Report : </div>
            </div>
            <div class="width80 float_left">  
                <select name="details_report_type"  class="change-base-xhttp-request"  data-href="{base_url}erc_reports/details_summary_report_form" data-qr="output_position=content">
                    <option selected="selected" value="">Select Report</option>
                    <option value="1">Datewise</option>
                    <!-- <option value="2">Month</option> -->
                    <!-- <option value="3">Districtwise</option> -->
                </select>
            </div>
        </div>
    </div>
    <div id="Sub_date_report_block_fields">
</div>

</div>