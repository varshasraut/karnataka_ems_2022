<form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">
    <div class="width100">
        <div class="field_row float_left width69">
            <div  class="width_25 float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select Incident Report: </div>
                </div>
                <div class="width100 float_left"> 
                <input name="amb_reg_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>">
                </div>
            </div>
            <div class="width_25 float_left">

                <div class="filed_select">
                    <div class="field_row drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Select Incident Report: </div>
                        </div>
                        <div class="width100 float_left">  
                            <select name="report_type" >
                                <option value="">Select Report</option>
                                <option value="1">Medicines Report</option>
                                <option value="2">Consumable Report</option>
                                <option value="3">Non Consumable Report</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="width_25 float_left">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php
                            for ($i = 0; $i <= 1; $i++) {
                                $current_date = time();
                                $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));

                                echo '<option value="' . $month_value . '">' . $month . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>
            <div class=" float_left" style="margin-top: 10px;">
                <div class="button_field_row">
                    <div class="button_box">

    <!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                        <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left" >
                        <?php if( $submit_function == 'incident_weekly_hourly_report'){ ?>
    <!--                    <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}erc_reports/<?php echo $submit_function; ?>" data-qr="output_position=content&amp;flt=reset&reports=view" />-->
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="box3 width100">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>


<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
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