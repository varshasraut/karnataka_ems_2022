
<!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
<div style="display:none"><input id="maintenance_type" name="maintenance_type" value="<?php echo $maintenance_type; ?>"></input></div>
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="field_row float_left width50">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php
                            for ($i = 0; $i <= 20; $i++) {
                                $current_date = time();
                                 $current_date = strtotime(date('Y-m-01'));
                              
                                $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));
                                echo '<option value="' . $month_value . '">' . $month . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                </div>
            </div>
        </div>
    </form>
</div>
