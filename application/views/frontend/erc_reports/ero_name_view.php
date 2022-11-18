<div class="width100">

    <div class="field_row">

        <div class="filed_select">
            <div class="width50 drg float_left">
                <div class="width100 float_left">
                    <div class="style6 float_left">Select User: </div>
                </div>
                <div class="width100 float_left">
              
<input name="user_id" class="mi_autocomplete" data-href="<?php echo base_url();?>auto/get_auto_clg?clg_group=<?php echo $system;?> "  data-value="<?php echo $clg_data->clg_ref_id;?>" value="<?php echo $clg_data->clg_ref_id;?>" type="text" tabindex="2" placeholder="User Name">
<?php //var_dump($stud_sickroom[0]->qa_name);?>
                </div>
                
            </div>
           

        
            <div class="filed_select">
                <div class="width20 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div>
                <div class="width20 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div>
        </div>


    </div>
      <div class="width10 float_left" style="margin-top: 10px;">
        <div class="button_field_row">
            <div class="button_box">

                    <!-- <input type="submit" name="submit" value="Submit" TABINDEX="3">    -->
                 <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search" >
            </div>
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