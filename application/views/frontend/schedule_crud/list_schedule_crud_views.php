<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li>
            <span>Employee Schedule Listing</span>
        </li>
    </ul>
</div>


<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>calls/all_listing_filter" method="post" enctype="multipart/form-data" target="form_frame">
                <input type="hidden" value="<?php echo $from_date; ?>" name="from_date">
                <input type="hidden" value="<?php echo $call_purpose; ?>" name="call_purpose">
                <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                <input type="hidden" value="<?php echo $search_chief_comp; ?>" name="search_chief_comp">
                <input type="hidden" value="<?php echo $call_search; ?>" name="call_search">
                <input type="hidden" value="<?php echo $avaya; ?>" name="avaya">
                <input type="hidden" value="<?php echo $team_type; ?>" name="team_type">

                <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
            </form>
        </div>

    </div>
</div>
<form method="post" name="inc_list_form" id="inc_list">
    <!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
    <div class="width100">

        <div class="field_row  width100">

            <div class="filed_select">
                <div class="width20 drg float_left">

                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Team Type</div>
                    </div>
                    <select id="team_type" name="team_type" class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" <?php echo $view; ?>>

                        <option value="">Select Team Type</option>
                        <option value="all">All</option>
                        <option value="UG-ERO-102">ERO 102</option>
                        <option value="UG-ERO">ERO 108</option>

                    </select>
                </div>
                <div class="width200 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select Month: </div>
                    </div>
                    <div class="width100 float_left">

                        <select name="from_date" class="" data-errors="{filter_required:'Month should not be blank!'}">
                            <option value="">Select Month</option>
                            <?php
                            for ($i = 0; $i <= 1; $i++) {
                                $current_date = time();
                                $month = date('M Y', strtotime('-' . $i . ' Months', $current_date));
                                $month_value = date('Y-m-01', strtotime('-' . $i . ' Months', $current_date));
                                echo '<option value="' . $month_value . '">' . $month . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>
                <div class="width15 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Select User : </div>
                    </div>
                    <div class="width100 float_left" id="ero_list_outer_qality">
                        <!-- <input name="ero" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_eros_data" placeholder="Select ERO" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php //echo $clg_ref_id; 
                                                                                                                                                                                                                                                                                    ?>" data-value="<? php // echo $clg_ref_id; 
                                                                                                                                                                                                                                                                                                                                ?>"> -->
                        <select name="user_id" id="ero_list_qality">
                            <option value="">Select User</option>
                            <?php foreach ($ero_clg as $new) { ?>
                                <option value="<?php echo $new->clg_ref_id; ?>"><?php echo $new->clg_first_name . " " . $new->clg_last_name . " " . $new->clg_ref_id; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                </div>
                <div class="width15 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">Search : </div>
                    </div>
                    <div class="width100 float_left" id="ero_list_outer_qality">
                        <!-- <input name="ero" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_eros_data" placeholder="Select ERO" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php //echo $clg_ref_id; 
                                                                                                                                                                                                                                                                                    ?>" data-value="<? php // echo $clg_ref_id; 
                                                                                                                                                                                                                                                                                                                                ?>"> -->
                        <input type="text" class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search" />


                    </div>

                </div>

            </div>

        </div>

        <div class="width_25 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box">

                    <!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit" value="Submit" data-qr="output_position=content&amp;reports=view&amp;module_name=reports&amp;showprocess=yes&action=view" data-href="<?php echo base_url(); ?>schedule_crud/schedule_crud_filter" class="form-xhttp-request btn clg_search float_left">
                    <input type="reset" class="search_button btn float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}schedule_crud" data-qr="output_position=content&amp;flt=reset&amp;type=inc" />
                </div>
            </div>
        </div>
    </div>
    <iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
    <script>
        ;
        jQuery(document).ready(function() {

            var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function() {
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
    <div class="breadcrumb float_left">
        <ul>
            <li>
                <h3></h3>
            </li>
        </ul>
    </div>

    <div class="width2 float_right ">

        <?= $CI->modules->get_tool_html('MT-ADD-CRUD-SCHEDULE', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=800"); ?>
        <?= $CI->modules->get_tool_html('MT-IMPORT-CRUD', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=800"); ?>
    </div>

    <br><br>

    <div class="box3">

        <div class="permission_list group_list">

            <form method="post" name="shamschedule_form" id="shamschedule_list">

                <div id="shamschedule_filters"></div>

                <div id="list_table">


                    <table class="table report_table">

                        <tr>
                            <th nowrap>Sr No</th>
                            <th nowrap>User ID</th>
                            <th nowrap>User Name</th>
                            <th nowrap>User Group</th>
                            <th nowrap>Schedule Type</th>
                            <th nowrap>Schedule Month</th>
                            <th nowrap>Schedule Year</th>
                            <th nowrap>Added On</th>
                            <th>Action</th>
                        </tr>
                        <?php if (count($crud_data) > 0) {

                            $total = 0;
                            foreach ($crud_data as $key => $value) {

                                $asScheduleDatetime = explode(' ', $value->schedule_date);
                                $asDate = explode('-', $asScheduleDatetime[0]);

                                $total = 0;
                                $cur_page_sr = ($page_no - 1) * 20;
                        ?>
                                <tr>
                                    <td><?php echo $cur_page_sr + $key + 1; ?></td>
                                    <td><?php echo $value->user_id; ?></td>
                                    <td><?php echo $value->user_name; ?></td>
                                    <td><?php echo $value->user_group; ?></td>
                                    <td><?php echo $value->schedule_type; ?></td>
                                    <?php if ($value->schedule_month == "1") {
                                        $month = "January";
                                    } elseif ($value->schedule_month == "2") {
                                        $month = "February";
                                    } elseif ($value->schedule_month == "3") {
                                        $month = "March";
                                    } elseif ($value->schedule_month == "4") {
                                        $month = "April";
                                    } elseif ($value->schedule_month == "5") {
                                        $month = "May";
                                    } elseif ($value->schedule_month == "6") {
                                        $month = "June";
                                    } elseif ($value->schedule_month == "7") {
                                        $month = "July";
                                    } elseif ($value->schedule_month == "8") {
                                        $month = "August";
                                    } elseif ($value->schedule_month == "9") {
                                        $month = "September";
                                    } elseif ($value->schedule_month == "10") {
                                        $month = "October";
                                    } elseif ($value->schedule_month == "11") {
                                        $month = "November";
                                    } elseif ($value->schedule_month == "12") {
                                        $month = "December";
                                    } ?>
                                    <td><?php echo $month; ?></td>
                                    <td><?php echo $value->schedule_year; ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', strtotime($value->mt_added_date)); ?></td>
                                    <td>
                                        <div class="user_action_box">

                                            <div class="colleagues_profile_actions_div"></div>

                                            <ul class="profile_actions_list">

                                                <?php if ($CI->modules->get_tool_config('MT-VIEW-CRUD-SCH', $this->active_module, true) != '') { ?>

                                                    <li><a class="onpage_popup action_button" data-href="{base_url}schedule_crud/view_crud" data-qr="output_position=popup_div&amp;schedule_id=<?php echo $value->sc_cr_id; ?>&amp;amb_action=view" data-popupwidth="1000" data-popupheight="800">View</a></li>

                                                <?php }
                                                if ($CI->modules->get_tool_config('MT-UPDATE-CRUD-SCH', $this->active_module, true) != '') { ?>

                                                    <li> <a class="onpage_popup action_button" data-href="{base_url}schedule_crud/add_crud" data-qr="output_position=popup_div&amp;schedule_id=<?php echo $value->sc_cr_id; ?>&amp;amb_action=edit" data-popupwidth="1000" data-popupheight="800"> Update</a></li>

                                                <?php }
                                                if ($CI->modules->get_tool_config('MT-DELETE-CRUD-SCH', $this->active_module, true) != '') { ?>

                                                    <li><a class="action_button click-xhttp-request" data-href="{base_url}schedule_crud/delete_crud" data-qr="schedule_id=<?php echo $value->sc_cr_id; ?>&amp;output_position=content&amp;page_no=<?php echo @$page_no; ?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this schedule crud?"> Delete</a></li>

                                                <?php }  ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                        } else {   ?>

                            <tr>
                                <td colspan="9" class="no_record_text">No history Found</td>
                            </tr>

                        <?php } ?>

                    </table>

                    <div class="bottom_outer">

                        <div class="pagination"><?php echo $pagination; ?></div>

                        <input type="hidden" name="submit_data" value="<?php if (@$data) {
                                                                            echo $data;
                                                                        } ?>">

                        <div class="width38 float_right">

                            <div class="record_per_pg">

                                <div class="per_page_box_wrapper">

                                    <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                    <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}schedule_crud/schedule_crud_filter" data-qr="output_position=content&amp;flt=true">

                                        <?php echo rec_perpg($pg_rec); ?>

                                    </select>

                                </div>

                                <div class="float_right">
                                    <span> Total records: <?php echo (@$total_count) ?  $total_count : "0"; ?> </span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>