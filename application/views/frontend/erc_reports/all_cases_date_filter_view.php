<?php $CI = EMS_Controller::get_instance(); ?>
<!-- <div class="head_outer">
    <h3 class="txt_clr2 width1"> <?php echo $report_name ?> </h3>
</div> -->
<div class="width100">

    <form action="<?php echo base_url(); ?>pending_reports/zone_wise_cases" method="post" enctype="multipart/form-data"
        target="form_frame">
        <div class="field_row float_left width_20">               
            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From Date: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="20" class="form_input  filter_required" placeholder="Date"
                            type="text" data-errors="{filter_required:'Date should not be blank!'}" id="from_date">
                    </div>
                </div>
            </div>

        </div>
        <div class="field_row float_left width_20">

<div class="filed_select">
    <div class="width100 drg float_left">
        <div class="width100 float_left">
            <div class="style6 float_left">To Date: </div>
        </div>
        <div class="width100 float_left">
            <input name="to_date" tabindex="20" class="form_input filter_required" placeholder="Date"
                type="text" data-errors="{filter_required:'Date should not be blank!'}" id="to_date">
        </div>
    </div>
</div>

</div>

<input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>pending_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search"  style="margin-top: 23px;" >
    
</div>
</div>
</form>
</div>
<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 1
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
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