<!--<form>-->
<div class="width100">
    <div class="field_row float_left width30">
        <div class="filed_select">
            <!-- <div class="width25 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div> -->
            <!-- <div class="width25 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div> -->

            <div class="width100 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select District: </div>
                </div>
                <div class="width100 float_left">
                    <select name="incient_district" class="filter_required" data-errors="{filter_required:'District should not be blank!'}">
                        <option value="">Select District</option>
                        <option value="all">All</option>
                        <?php foreach ($dist as $dst) { ?>
                            <option value="<?php echo $dst->dst_code; ?>" <?php if ($dst->dst_code == '518') {
                                                                                echo "selected";
                                                                            } ?>><?php echo $dst->dst_name; ?></option>
                        <?php } ?>
                        <?php foreach ($district_data as $key) { ?>
                            <option value="<?php echo $key->dst_code ?>"><?php echo $key->dst_name ?></option>
                        <?php  }
                        ?>
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class=" float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">
                <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left">
             
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
<!-- <script>
    ;
    jQuery(document).ready(function() {

        var dateFormat = "mm/dd/yy",
            from = jQuery("#from_date")
            .datepicker({
                defaultDate: new Date(),
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1
            })
            .on("change", function() {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = jQuery("#to_date").datepicker({
                defaultDate: new Date(),
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1
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
    });
</script> -->