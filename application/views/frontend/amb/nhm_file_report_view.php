
<!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="field_row float_left width100">

            <div class="width_25 float_left">
                
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Year: </div>
                    </div>
                    <div class="width100 float_left" >

                        <select name="from_year" class="filter_required" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Year</option>
                         <option value="2022">2022</option>
                        </select>
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
<!--                            <option value="January">January</option> 
                            <option value="February">February</option>	 
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>	
                            <option value="June">June</option> 
                            <option value="July">July</option> -->
                            <option value="August">August</option>
                            <!--<option value="September">September</option>
                            <option value="October">October</option>                                 
                            <option value="November">November</option> 
                            <option value="December">December</option>-->
                        </select>
                    </div>
                </div>
            </div>

       
        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>amb/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search">
                </div>
            </div>
        </div>
            <div id="report_listing">
            </div>
    </form>
</div>