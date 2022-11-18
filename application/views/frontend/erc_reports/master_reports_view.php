<?php $CI = EMS_Controller::get_instance(); ?>
<div class="head_outer"><h3 class="txt_clr2 width1">  <?php echo $report_name ?> </h3> </div>
<div class="width100">

<!--    <form enctype="multipart/form-data" method="post">-->
<form action="<?php echo base_url(); ?>master_report/view_master_report" method="post" enctype="multipart/form-data" target="form_frame">
        <div class="width_20 drg float_left">

            <div class="width100 float_left">
                <div class="style6 float_left">Select Team Type </div>
            </div>
            <select id="team_type" name="team_type"  class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" <?php echo $view; ?> >

                <option value="">Select Team Type</option>
                <option value="all">All</option>
                <!--<option value="UG-ERO-102">ERO 102</option>-->
                <option value="UG-ERO">ERO 108</option>

                <!-- No Use in Report  -->

                <!-- <option value="UG-BIKE-ERO">Bike ERO</option>  -->

                <!-- No Use in Report  -->

            </select>
        </div> 
        
        <div class="width_20 drg float_left">
            <div class="width100 float_left">
                <div class="style6 float_left">Select User : </div>
            </div>
            <div class="width100 float_left" id="ero_list_outer_qality">
                <select name="ero" id="ero_list_qality">
                    <option value="">Select User</option>
                    <?php foreach ($ero_clg as $new) { ?>
                        <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name . " ".$new->clg_mid_name . " " . $new->clg_last_name . " " . $new->clg_ref_id; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>
        <div class="field_row float_left width_20">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From Date: </div>
                    </div>
                    <div class="width100 float_left" >
                        <input name="from_date" tabindex="20" class="form_input  filter_required" placeholder="Date" type="text"  data-errors="{filter_required:'Date should not be blank!'}" id="from_date">
                    </div>
                </div>
            </div>

        </div>
        <div class="field_row float_left width_20">

            <div class="filed_select">
                <div class="width100 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To Date: </div>
                    </div>
                    <div class="width100 float_left" >
                        <input name="to_date" tabindex="20" class="form_input filter_required" placeholder="Date" type="text"  data-errors="{filter_required:'Date should not be blank!'}"  id="to_date">
                    </div>
                </div>
            </div>

        </div>
            <div class="input float_left width_20">

            <div class="width100 float_left">
                <div class="style6 float_left">Select Purpose of call: </div>
            </div>
            <select name="call_purpose" placeholder="Select Purpose of call" class="form_input "  style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'purpose of call should not be blank.'}" data-base="search_btn"  tabindex="2" >

                <option value='' selected>Select Purpose of call</option>
                <option value='all' selected>All call</option>

                <?php
                foreach ($all_purpose_of_calls as $purpose_of_call) {
                    echo "<option value='" . $purpose_of_call->pcode . "'  ";
                    echo $select_group[$purpose_of_call->pcode];
                    echo" >" . $purpose_of_call->pname;
                    echo "</option>";
                }
                ?>
            </select>

        </div> 
         
        
        <div class="width_20 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">
<!--                    <input type="button" name="submit" value="Submit" data-qr="output_position=list_table&amp;reports=view&amp;module_name=reports&amp;showprocess=yes" data-href="<?php echo base_url(); ?>master_report/view_master_report" class="form-xhttp-request btn clg_search">-->
                    <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    <input type="reset"  value="Reset Filters">
                </div>
                
            </div>
        </div>

    </form>
</div>
<div class="box3">    

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