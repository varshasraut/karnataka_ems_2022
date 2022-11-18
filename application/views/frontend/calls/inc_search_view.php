<style>
    .button_color{
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
    .padding-top-5 {
    padding-top: 5px;
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
<div class="movpopup" id="content">
    <div class="call_purpose_form_outer">
    <?php
    if ($clg_group == 'UG-GrievianceManager' || $clg_group == 'UG-Grievance') {
    ?>
        <form method="post" name="" id="call_dls_info">
            <div class="head_outer">
                <h3 class="txt_clr2 width1">Single Record</h3>
            </div>

            <div id="single_dst_name" class="width_16 float_left ">
                <input name="district_id" class="mi_autocomplete width97" data-href="<?php echo base_url(); ?>auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off">
            </div>
            <div id="single_incident_id" class="width_16 float_left ">
                <input name="incident_id" tabindex="7.2" class=" form_input" placeholder="Enter Incident ID" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}">
            </div>
            <div id="single_date" class="width_16 float_left ">
                <input name="date_serach" tabindex="7.2" class=" form_input mi_cur_timecalender " placeholder="Select Date" type="text" data-errors="{filter_required:'Please select date'}">
            </div>
            <div id="single_Caller_Number" class="width_16 float_left ">
                <input name="Caller_Number" tabindex="7.2" class=" form_input  " placeholder="Enter Caller Number" type="text" data-errors="{filter_required:'Please select date'}">
            </div>

            <input name="search_btn" tabindex="12" value="Search" class="form-xhttp-request btn clg_search float_left" data-href="<?php echo base_url(); ?>grievance/single_pt_inc_list" data-qr="output_position=inc_details" type="button">
        </form>
        <div id="inc_details">
        </div>
        <div id="single_record_details">
        </div>
    <?php
    } else {
    ?>
        <form method="post" name="" id="call_dls_info">

            <div class="inline_fields width100">

                <div class="form_field width100 pos_rel">

                    <div class="outer_id width100">

                        <div class="float_left width_15 padding-top-5">
                            <h3>Incident Id <span class="md_field">*</span></h3>
                        </div>
                        <div class="input float_left width_18 padding-top-5">
                            <input value="<?php echo date('Ymd'); ?>" name="inc_ref_id" tabindex="1" id="inc_ref_id" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn1" data-errors="{filter_required:'Incident Id should not be blank!'}" autocomplete="off">
                        </div>
                        <div class="width_50 float_left" style="">
                            <div class="button_field_row">
                                <div class="">

                                    <input type="button" name="search_btn1" value="Search" data-qr="output_position=single_record_details&amp;reports=view&amp;module_name=reports&amp;showprocess=yes&action=view" data-href="<?php echo base_url(); ?>calls/single_record_view" class="form-xhttp-request btn clg_search button_color float_left margin_top_5">

                                    <input type="reset" class="search_button btn button_color_reset float_left form-xhttp-request margin_top_5" name="" value="Reset Filter" data-href="{base_url}calls/left_single_record" data-qr="output_position=content&amp;flt=reset&amp;type=inc" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div id="single_record_details">
        </div>
    <?php
    }
    ?>
</div>
</div>
</div>
