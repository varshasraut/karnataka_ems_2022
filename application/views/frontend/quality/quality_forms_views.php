<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Quality Forms</span></li>
    </ul>
</div>

<br>

<div class="box3">

    <div class="permission_list group_list">

        <form method="post" action="#" name="quality_forms" class="quality_forms">

            <div id="clg_filters">

                <div class="filters_groups">

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="search_btn_width">


                                <div class="filed_input float_left width_10">
                                    <select id="team_type" name="team_type" class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" <?php echo $view; ?>>

                                        <option value="">Select Team Type</option>
                                        <option value="UG-ERO,UG-ERO-102">All ERO</option>
                                        <option value="UG-DCO,UG-DCO-102">All DCO</option>
                                        <!-- <option value="UG-ERO-102">ERO 102</option> -->
                                        <option value="UG-ERO">ERO 108</option>
                                        <!-- <option value="UG-DCO-102">DCO 102</option> -->
                                        <option value="UG-DCO">DCO 108</option>

                                        <!--                                         <option value="ERO-102">ERO-102</option>
                                        <option value="DCO-102">DCO-102</option>-->
                                        <!-- <option value="ERCP">ERCP</option>
                                        <option value="Grieviance">GRIEVIANCE</option>
                                        <option value="FEEDBACK">FEEDBACK</option>
                                        <option value="FDA">FIRE</option>
                                        <option value="PDA">POLICE</option> -->
                                    </select>
                                </div>
                                <div class="float_left width_10" id="ero_list_outer_qality">

                                    <select name="ref_id" id="ero_list_qality">
                                        <option value="">Select ERO</option>
                                        <option value='all'>All</option>

                                    </select>
                                </div>
                                <div class="float_left width_10">

                                    <select name="qa_id">
                                        <option value="">Select Quality</option>
                                        <option value='all'>All</option>
                                        <?php


                                        foreach ($qa as $qa) {
                                            echo "<option value='" . $qa->clg_ref_id . "'  ";

                                            echo " >" . $qa->clg_first_name . " " . $qa->clg_last_name;
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="width_10 drg float_left">
                                    <div class="width100 float_left">

                                        <input name="from_date" tabindex="1" class="form_input" placeholder="From Date" type="text" value="" readonly="readonly" id="from_date">
                                    </div>
                                </div>

                                <div class="width_10 drg float_left">
                                    <div class="width100 float_left">

                                        <input name="to_date" tabindex="2" class="form_input" placeholder="To Date" type="text" data-base="search_btn" value="" readonly="readonly" id="to_date">
                                    </div>
                                </div>
                                <div class="input nature top_left float_left width_15" id="chief_complete_outer">
                                    <input type="text" name="search_chief_comp" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete" data-href="{base_url}auto/get_chief_complete" placeholder="Chief Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}" data-callback-funct="chief_complete_change" TABINDEX="8" data-base="ques_btn" <?php echo $autofocus; ?>>
                                </div>
                                <div class="input float_left width_10">

                                    <select id="parent_call_purpose" name="call_purpose" placeholder="Select Purpose of call" class="form_input " style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn" tabindex="2">

                                        <option value='' selected>Select Purpose of call</option>
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

                                <div class="filed_input float_left width_25">

                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left mt-0" data-href="{base_url}quality_forms/view_incidence_quality" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;">
                                    <input class="search_button click-xhttp-request mt-0" style="" name="" value="Reset Filters" data-href="{base_url}quality_forms/quality_forms" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="8" autocomplete="off">
                                </div>

                            </div>


                        </div>


                    </div>

                </div>

            </div>
        </form>
        <div class="breadcrumb float_left">
            <ul>

                <li><span>Incident Listing</span></li>
            </ul>
        </div>
        <div id="list_table">



        </div>


    </div>
    <script>
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
</div>