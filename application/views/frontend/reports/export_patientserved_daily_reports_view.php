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
                        <option value="2">00:01-02:00</option>
                        <option value="3">00:02-03:00</option>
                        <option value="4">00:03-04:00</option>
                        <option value="5">00:04-05:00</option>
                        <option value="6">00:05-06:00</option>
                        <option value="7">00:06-07:00</option>
                        <option value="8">00:07-08:00</option>
                        <option value="9">00:08-09:00</option>
                        <option value="10">00:09-10:00</option>
                        <option value="11">00:10-11:00</option>
                        <option value="12">00:11-12:00</option>
                        <option value="13">00:12-13:00</option>
                        <option value="14">00:13-14:00</option>
                        <option value="15">00:14-15:00</option>
                        <option value="16">00:15-16:00</option>
                        <option value="17">00:16-17:00</option>
                        <option value="18">00:17-18:00</option>
                        <option value="19">00:18-19:00</option>
                        <option value="20">00:19-20:00</option>
                        <option value="21">00:20-21:00</option>
                        <option value="22">00:21-22:00</option>
                        <option value="23">00:22-23:00</option>
                        <option value="24">00:23-24:00</option>
                    </select>
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