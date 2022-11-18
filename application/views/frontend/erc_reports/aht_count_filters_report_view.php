<!--<form>-->
<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>

<div class="width100">
<form enctype="multipart/form-data"  action="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" method="post">

        <div class="field_row float_left width69">
        <div class="filed_select">
        <div class="width30 drg float_left">
        <div class="width100 float_left">

        <div class="style6 float_left">Select System: </div>
        </div>
        <div class="width100 float_left">
<select name="clg_group"  class="change-base-xhttp-request" data-href="{base_url}erc_reports/<?php echo $submit_function; ?>" data-qr="output_position=list_table" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7"  >

                                        <option value="">Select Team Type</option>
                                        <option value="all_clg">All</option>
                                        <option value="UG-ERO-102">ERO 104</option>
                                        <option value="UG-ERO">ERO 108</option>
                                       
                                    </select>
                                    </div>
                                    </div>
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div>
                <div class="width30 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div>


            </div>

        </div>
        <div class=" float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

<!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit"  value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>erc_reports/<?php echo $submit_function; ?>" class="form-xhttp-request btn clg_search float_left" >
                    
                </div>
            </div>
        </div>
        <div >
        </form>
    </div>
<div class="box3">    

    <div class="permission_list group_list">

        <div id="list_table" >


        </div>
    </div>
</div>
<!--</form>-->

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