<style>
    .background-color-new{
        background-color:#2F419B !important;
    }
    .button_color{
        padding: 4px 36px;
        background-color : #2f419b !important;
    }
    .button_color_reset{
        background-color : #2f419b !important;
    }
    .button_color:hover{
        background-color : #8786fb !important;
    }
    .button_color_reset:hover{
        background-color : #8786fb !important;
    }
</style>

<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.structure.css">
<link rel="stylesheet" type="text/css" href="{css_path}/jquery-ui.theme.css">
<link rel="stylesheet" type="text/css" href="{css_path}/colorbox.css">
<link href="{css_path}/style.css?t=1.5" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_pages.css" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_responsive_common.css" rel="stylesheet" type="text/css" />
<link href="{css_path}/style_responsive.css" rel="stylesheet" type="text/css" />
<link href="{css_path}/MonthPicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" > var base_url = '{base_url}'; </script>
<script type="text/javascript" src="{js_path}/jquery-1.12.1.js"></script>
<script type="text/javascript" src="{js_path}/jquery-ui.js"></script>
<script type="text/javascript" src="{js_path}/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="{js_path}/jquery.enhanced.cookie.js" ></script>
<script type="text/javascript" src="{js_path}/jquery.colorbox.js"></script>
<script type="text/javascript" src="{js_path}/ch_js.js?t=3.6"></script>
<script type="text/javascript" src="{js_path}/comman.js?t=2.4"></script>
<script type="text/javascript" src="{js_path}/custom.js?t=2.5"></script>
<script type="text/javascript" src="{js_path}/ms_map.js?t=2.4"></script>
<script type="text/javascript" src="{js_path}/inc_map_here.js?t=2.8"></script>
<script type="text/javascript" src="{js_path}/MonthPicker.js"></script>
<div id="container">
<div class="call_purpose_form_outer" id="mydivheader">

    <div class="head_outer background-color-new">
        <h3 class="txt_clr2 width1">Caller History</h3>
    </div>
 
    <form method="post" name="" id="call_dls_info">

        <div class="inline_fields width100">

            <div class="form_field width100 pos_rel">

                <div class="outer_id width100">

                    <div class="float_left width10 hide">
                        <h3>Caller Number <span class="md_field">*</span></h3>
                    </div>
                    <div class="input float_left width10">
                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo $mobile_no; ?>" name="mobile_no" tabindex="1" id="inc_ref_id" class="form_input " placeholder="Enter Caller Number" type="text" data-base="search_btn" data-errors="{filter_required:' Caller Number should not be blank!',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" autocomplete="off">
                    </div>
                    <div class="input float_left width10">
                        <input type="text" class="form_input filter_if_not_blank filter_word" name="search_caller_details" data-base="search_btn" placeholder="Enter Caller Details" tabindex="6" autocomplete="off" data-errors="{filter_required:'Caller Details should not be blank', filter_word:'Invalid input at Caller Details. Numbers and special characters not allowed.'}">
                    </div>
                    <!--<div class="width10 float_left">
                        <div class="width100 float_left">
                            <select name="h_call_status" placeholder="Select Call Status" class="form_input " style="color:#666666" data-errors="{filter_required:'Call Status should not blank'}" data-base="search_btn" tabindex="2">
                                <option value='all' selected>All call</option>
                                <option value='0'>Active</option>
                                <option value='2'>Terminated</option>

                            </select>
                        </div>
                    </div>-->
                    <div class="input float_left width10">

                        <select id="parent_call_purpose" name="h_call_purpose" class="form_input " data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn" tabindex="2" data-base="search_btn">
                            <option value=''>Select Purpose of call</option>
                            <option value='all' selected>All call</option>

                            <?php


                            foreach ($all_purpose_of_calls as $purpose_of_call) {
                                echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                echo $select_group[$purpose_of_call->pcode];
                                echo " >" . $purpose_of_call->pname;
                                echo "</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="input float_left width10">
                        <select id="clg_id" name="clg_id" class="form_input " data-base="search_btn" tabindex="2" data-base="search_btn">
                            <option value=''>Select ERO ID</option>


                            <?php


                            foreach ($clg_list as $clg_list_all) {
                                echo "<option value='" . $clg_list_all->clg_ref_id . "'  ";
                                echo $select_group[$clg_list_all->clg_ref_id];
                                echo " >" . $clg_list_all->clg_ref_id;
                                echo "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filed_input float_left width10">
                        <input name="h_from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $from_date; ?>" readonly="readonly" id="from_date">
                    </div>
                    <div class="filed_input float_left width10">
                        <input name="h_to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $to_date; ?>" readonly="readonly" id="to_date">
                    </div>
                    
                    <div class="width10 float_left ">
                        <input name="h_district_id" class="mi_autocomplete width97" data-href="<?php echo base_url(); ?>auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" data-base="search_btn">
                    </div>

                    <div class="float_left width_20 ">

                        <!--                    <div class="label">&nbsp;</div>-->
                        <!-- <input name="search_btn" value="Search" class="style3 base-xhttp-request float_left button_color" data-href="<?php echo base_url(); ?>calls/single_caller_history" data-qr="output_position=single_record_details" type="button" style="float:left; margin-top: 0px;"> -->
                        <input name="search_btn" value="Search" class="base-xhttp-request float_left button_color" data-href="<?php echo base_url(); ?>calls/single_caller_history" data-qr="output_position=single_record_details" type="button" style="float:left; margin-top: 0px;">
                        <!--                       <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request" data-href="http://mulikas4/spero_ems_2019/medadv/call_details" data-qr="output_position=content" type="button" tabindex="2" autocomplete="off">-->
                        <input name="reset_filter" tabindex="19" value="Reset Filter" class=" click-xhttp-request style3 float_left button_color_reset" data-href="<?php echo base_url(); ?>calls/caller_record_reset" data-qr="output_position=inc_details&amp;filter=true" type="reset" style=" margin-top: 0px;" autocomplete="off">

                    </div>
                </div>
            </div>
        </div>
    </form>
    <div id="caller_single_record_details">
    </div>
</div>
</div>
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