
<div class="width100 float_left width69">
    <form enctype="multipart/form-data" action="#" method="post" id="reports_type">
        <div class="field_row float_left width50">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Date: </div>
                    </div>
                    <div class="width100 float_left" >
                        <input name="single_date" tabindex="20" class="form_input mi_calender filter_required" placeholder="Date" type="text"  data-errors="{filter_required:'Date should not be blank!'}" >
                    </div>
                </div>
            </div>

        </div>
        <div class=" float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left">
                    <?php if( $submit_function == 'incident_daily_hourly_report'){ ?>
                    <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}erc_reports/<?php echo $submit_function; ?>" data-qr="output_position=content&amp;flt=reset&reports=view" />
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>