<form method="post">
<div class="width100">
    <div class="field_row float_left width69">
    <input type="hidden" value="<?php echo $report_type_new; ?>" name="report_type_new">
    <div class="width30 drg float_left">
    <div class="width100 float_left">
                    <div class="style6 float_left">District:</div>
                </div>
            <select name="dist" id="divs" class="change-base-xhttp-request" >
                    <option value="">All</option>
                        <?php foreach($district_data as $dvs){ ?>  
                        <option value="<?php echo $dvs->dst_code; ?>"><?php echo $dvs->dst_name;?></option>
                        <?php }?>
                    </select>
            </div>
        <div class="filed_select">
        
            <div class="width30 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">From:</div>
                </div>
                <div class="width100 float_left">
                    <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                </div>
            </div>
            <div class="width30 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">To : </div>
                </div>
                <div class="width100 float_left">
                    <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                </div>
            </div>


        </div>

    </div>
    <div class="width_25 float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >
            </div>
        </div>
    </div>
</div>
</form>

<!--<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>-->
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate:  new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 2
        })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });

</script>