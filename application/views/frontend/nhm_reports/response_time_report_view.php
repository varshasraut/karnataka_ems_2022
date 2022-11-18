<div class="head_outer">
    <h3 class="txt_clr2 width1"><?php echo $report_name;?></h3> 
</div>
<!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="field_row float_left width50">

            <div class="filed_select">
                
                <div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_date" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php
                            for ($i = 0; $i <= 20; $i++) {
                                $current_date = time();
                                $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));

                                echo '<option value="' . $month_value . '">' . $month . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>

                <!-- <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Ambulance Type: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="amb_type" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Ambulance Type</option>
                            <option value="4">ALS</option>
                            <option value="3">BLS</option>

                        </select>
                    </div>
                </div> -->

                <div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select system: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="system_type" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Ambulance Type</option>
                            <option value="108">108</option>
                            <option value="102">102</option>

                        </select>
                    </div>
                </div>

                <!-- <div class="width25 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select area: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="working_area" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Area</option>
                            <option value="1">Rural</option>
                            <option value="2">Urban</option>

                        </select>
                    </div>
                </div> -->

            </div>

        </div>
        <div class="width_30 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" style="width:100%; overflow-x: scroll;">


        </div>
    </div>
</div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>