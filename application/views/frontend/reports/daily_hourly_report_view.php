
<!--<h2>Export <?php echo $report_name;?> Details</h2> -->
<div class="width100">
        <div class="field_row float_left width50">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Date: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="mi_calender form_input filter_required" placeholder="Select Date" type="text" data-base="search_btn" data-errors="{filter_required:'Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly">
                    </div>
                </div>
            </div>
        </div>
        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>reports/<?php echo $submit_function;?>" class="form-xhttp-request btn clg_search" >
                </div>
            </div>
        </div>
</div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>
<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>