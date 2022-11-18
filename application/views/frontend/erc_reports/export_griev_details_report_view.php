<form action="<?php echo base_url(); ?>erc_reports/save_export_grivience_report" method="post"
    enctype="multipart/form-data">
    <div class="width100">
        <div class="width_25 float_left">
            <div class="filed_select">

            </div>
        </div>
    </div>
    <div class="width50  field_row float_left">

        <div class="filed_select">
            <div class="width50 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">From: </div>
                </div>
                <div class="width100 float_left">
                    <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date"
                        type="text" data-base="search_btn"
                        data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"
                        value="" readonly="readonly" id="from_date">
                </div>
            </div>
            <div class="width50 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">To : </div>
                </div>
                <div class="width100 float_left">
                    <input name="to_date" tabindex="2" class="form_input filter_required StartDate"
                        placeholder="To Date" type="text" data-base="search_btn"
                        data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}"
                        value="" readonly="readonly" id="to_date">
                </div>
            </div>
        </div>
    </div>

    <div class="float_left" style="margin-top: 12px;">
        <div class="button_field_row">
            <div class="button_box">
                <input type="reset" value="Reset Filters" class="float_right">
                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </div>
        </div>
    </div>
    </div>
    <!-- <div class="box3 width100">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>-->
</form>

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>
;
jQuery(document).ready(function() {


    $(document).on("focus", "#to_date", function() {
        var $st_base_dateime = $("#from_date").val();
        var $stdate = new Date($st_base_dateime);

        var startDay = new Date($st_base_dateime);
        var endDay = new Date();

        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);

        var $maxDate = 31 - Math.round(Math.abs(days));

        jQuery("#to_date").datepicker("destroy");
        jQuery("#to_date").last().datepicker('refresh');

        var dateFormat = "mm/dd/yy",
            to = jQuery("#to_date").datepicker({
                defaultDate: new Date(),
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                minDate: $stdate,
                maxDate: $maxDate
            });
    });
    var dateFormat = "mm/dd/yy",
        from = jQuery("#from_date")
        .datepicker({
            defaultDate: new Date(),
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            maxDate: 0
        })
        .on("change", function() {
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
    //  $(document).on("change", "#to_date", function () {
    //         var $st_dateime = $("#from_date").val();
    //         var $to_dateime = $("#to_date").val();

    //         var startDay = new Date($st_dateime);
    //         var endDay = new Date($to_dateime);

    //         var millisBetween = endDay.getTime() - startDay.getTime();
    //         var days = millisBetween / (1000 * 3600 * 24);
    //         if(days > 1){
    //              $(this).parents('form').attr('target',"form_frame");
    //              $('#Sub_date_report_block_fields .clg_search ').attr('type',"submit");
    //              $('#Sub_date_report_block_fields .clg_search ').removeClass('form-xhttp-request');
    //               $(this).parents('form').attr('enctype',"multipart/form-data");

    //              $(this).parents('form').append('<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>');
    //         }
    //         console.log(days);
    //  });
});
</script>