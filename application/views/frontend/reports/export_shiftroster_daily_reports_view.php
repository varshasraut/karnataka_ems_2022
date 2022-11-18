<form method="post">
<div class="width100">
    <div class="field_row float_left width69">

        <div class="filed_select">
            <div class="width50 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">From: </div>
                </div>
                <div class="width100 float_left">
                    <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                </div>
            </div>
            <div class="width50 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Hour : </div>
                </div>
                <div class="width100 float_left">
                    <select name="time"><option value="">Select Time</option>                       
                        <option value="1">00:00-01:00</option>
                        <option value="2">01:00-02:00</option>
                        <option value="3">02:00-03:00</option>
                        <option value="4">03:00-04:00</option>
                        <option value="5">04:00-05:00</option>
                        <option value="6">05:00-06:00</option>
                        <option value="7">06:00-07:00</option>
                        <option value="8">07:00-08:00</option>
                        <option value="9">08:00-09:00</option>
                        <option value="10">09:00-10:00</option>
                        <option value="11">10:00-11:00</option>
                        <option value="12">11:00-12:00</option>
                        <option value="13">12:00-13:00</option>
                        <option value="14">13:00-14:00</option>
                        <option value="15">14:00-15:00</option>
                        <option value="16">15:00-16:00</option>
                        <option value="17">16:00-17:00</option>
                        <option value="18">17:00-18:00</option>
                        <option value="19">18:00-19:00</option>
                        <option value="20">19:00-20:00</option>
                        <option value="21">20:00-21:00</option>
                        <option value="22">21:00-22:00</option>
                        <option value="23">22:00-23:00</option>
                        <option value="24">23:00-24:00</option>
                    </select>
                </div>
            </div>


        </div>

    </div>
    <div class=" float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >
                <?php //if( $submit_function == 'shift_roster_report_view'){ ?>
                    <input type="reset" class="search_button  form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}erc_reports/load_shift_roster_sub_option_report_form" data-qr="output_position=content&amp;flt=reset&reports=view&report_type=3" />

                            <?php// } ?>
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