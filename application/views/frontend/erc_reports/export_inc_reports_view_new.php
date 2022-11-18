<!--<form>-->
<div class="width100">
        <div class="width_25 float_left">
            <div class="filed_select">
                <!-- <div class="width100 field_row drg float_left"> -->
                   <!-- <div class="style6 float_left">Select System: </div> -->
                <!-- <div class="width100 drg float_left"> -->

                    <!-- <select id="system" name="system"  class="change-base-xhttp-request" data-href="{base_url}erc_reports/load_employee_calls_report" data-qr="output_position=content" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  > -->
                        <!--<option value="">Select System Type</option>-->
                        <!--<option value="all">All</option>-->
                        <!--<option value="102">102</option>-->
                        <!-- <option value="108">108</option> -->
                        <!--<option value="104"> 104</option>-->
                    <!-- </select> -->
                <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="width50  field_row float_left">
       
            <div class="filed_select">
                <!--<div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div>-->
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required StartDate" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div>


            </div>

        </div>
        <div class=" float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left" >
                    <?php if( $submit_function == 'incident_weekly_hourly_report'){ ?>
                    <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}erc_reports/<?php echo $submit_function; ?>" data-qr="output_position=content&amp;flt=reset&reports=view" />
                    <?php } ?>
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
<!--</form>-->

<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>;
    jQuery(document).ready(function () {


        $(document).on("focus", "#to_date", function () {
        var $st_base_dateime = $("#from_date").val();
        var $stdate = new Date($st_base_dateime);
        
        var startDay = new Date($st_base_dateime);
        var endDay = new Date();
   
        var millisBetween = startDay.getTime() - endDay.getTime();
        var days = millisBetween / (1000 * 3600 * 24);
   
    var $maxDate = 31 - Math.round(Math.abs(days));

       jQuery("#to_date").datepicker( "destroy" );
       jQuery("#to_date").last().datepicker('refresh');
        
       var dateFormat = "mm/dd/yy",
        to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
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