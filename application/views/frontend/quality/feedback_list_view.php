<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Feedback List</span></li>
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
                                        <option value="all">All</option>
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
                                        <option value='all'>All call</option>

                                    </select>
                                </div>
                                <div class="float_left width_10">

                                    <select name="qa_id">
                                        <option value="">Select Quality</option>
                                        <option value='all'>All</option>
                                        <?php


                                        foreach ($qa as $qa) {
                                            echo "<option value='" . $qa->clg_ref_id . "'  ";

                                            echo " >" . $qa->clg_first_name . " " .$inc->clg_mid_name. " " . $qa->clg_last_name;
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

                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left mt-0" data-href="{base_url}quality_forms/quality_feedback" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;">
                                    <input class="search_button click-xhttp-request mt-0" style="" name="" value="Reset Filters" data-href="{base_url}quality_forms/quality_feedback" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="8" autocomplete="off">
                                </div>

                            </div>


                        </div>


                    </div>

                </div>

            </div>
        </form>
        <div class="width_25 float_right" style="margin-bottom: 10px;">
            <div class="button_field_row">
                <div class="button_box">
                    <form action="<?php echo base_url(); ?>quality_forms/quality_feedback_download" method="post" enctype="multipart/form-data" target="form_frame">
                        <input type="hidden" value="<?php echo $from_date; ?>" name="from_date">
                        <input type="hidden" value="<?php echo $to_date; ?>" name="to_date">
                        <input type="hidden" value="<?php echo $call_purpose; ?>" name="call_purpose">
                        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
                        <input type="hidden" value="<?php echo $search_chief_comp; ?>" name="search_chief_comp">
                        <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right">
                    </form>
                </div>

            </div>
        </div>
        <div class="breadcrumb float_left">
            <ul>

                <li><span>Feedback Listing</span></li>
            </ul>
        </div>
        <!-- <div id="list_table">



        </div> -->
        <table class="table report_table">
            <tr>
                <th>Sr.No</th>
                <!-- <th nowrap>Ameyo Id</th> -->
                <th nowrap>Ero Name</th>
                <th nowrap>Incident ID</th>
                <th nowrap>Call Type </th>
                <th nowrap>Call Time</th>
                <th nowrap>Audio File</th>
                <th nowrap>Audit Done By</th>
                <th nowrap>Quality Score</th>
                <th nowrap>Ero Meeting<br>Time</th>
                <th nowrap>Feedback<br>Status</th>
                <th nowrap>Feedback Option</th>
            </tr>
            <?php //var_dump($inc_info); 
            ?>
            <?php
            $counter = 0;
            if (count(@$inc_info) > 0) {
                $total = 0;

                foreach ($inc_info as $key => $inc) {
                    $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
            ?>
                    <tr>
                        <td style="text-align: left;"><?php echo ++$counter; ?></td>
                        <!-- <td><?php echo $inc->clg_avaya_agentid; ?></td> -->
                        <td><?php echo ucwords(strtolower($inc->clg_first_name . " " .$inc->clg_mid_name. "  " . $inc->clg_last_name)); ?></td>
                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo  $inc->inc_ref_id; ?></a></td>


                        <td><?php echo $inc->pname; ?></td>
                        <td><?php echo $inc->inc_dispatch_time; ?></td>
                        <td><?php
                            $inc_datetime = $inc->inc_datetime;
                            $pic_path = $inc->inc_audio_file;
                            //$pic_path =  get_inc_recording($inc->inc_avaya_uniqueid, $inc_datetime);
                            if ($pic_path != "") {
                            ?>
                                <audio controls controlsList="nodownload" style="width: 185px;">
                                    <source src="<?php echo $pic_path; ?>" type="audio/wav">
                                    Your browser does not support the audio element.
                                </audio>
                            <?php
                            } ?>
                        </td>
                        <td nowrap><?php echo $inc->added_by; ?></td>
                        <td nowrap><?php echo $inc->quality_score; ?></td>
                        <td><?php echo $inc->ero_meeting_time; ?></td>
                        <td><?php if ($inc->feedback_status) {
                                echo "Completed";
                            } else {
                                echo "Pending";
                            } ?></td>
                             <!-- <td><?php if($inc->feedback_status =='1'){echo "One-On-One";}elseif($inc->feedback_status =='2'){echo "Side-By-Side";}
                                            elseif($inc->feedback_status =='3'){echo "Feedback Given To TL";}elseif($inc->feedback_status =='4'){echo "Mass Feedback";}else{echo "Pending";} ?></td> -->

                        <td>
                            <?php if ($inc->inc_audit_status == '0') { ?>
                                <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/open_audit" data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php //echo $ref_id; 
                                                                                                                                                                                                                                                    ?><?php echo $inc->inc_added_by; ?>&user_type=<?php echo $user_type; ?>&user_quality=2&audit_inc_datetime=<?php echo  date("d-m-Y h:i:s", strtotime($inc->inc_datetime)) ?>&feedback=feedback" data-popupwidth="1000" data-popupheight="350">Action</a>
                            <?php } else { ?>
                                <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/open_audit" data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php //echo $ref_id; 
                                                                                                                                                                                                                                                    ?><?php echo $inc->inc_added_by; ?>&user_type=<?php echo $user_type; ?>&user_quality=2&type=edit&feedback=feedback" data-popupwidth="1000" data-popupheight="350">Edit</a>
                            <?php } ?>

                        </td>

                    </tr>
                <?php
                }
            } else {
                ?>

                <tr>
                    <td colspan="10" class="no_record_text">No history Found</td>
                </tr>

            <?php } ?>

        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <input type="hidden" name="submit_data" value="<?php
                                                            if (@$data) {
                                                                echo $data;
                                                            }
                                                            ?>">

            <div class="width38 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality_forms/quality_feedback" data-qr="output_position=content&amp;flt=true&ref_id=<?php echo $ref_id; ?>&team_type=<?php echo $team_type; ?>&to_date=<?php echo $to_date; ?>&from_date=<?php echo $from_date; ?>&pg_rec=<?php echo $pg_rec; ?>">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php
                                                if (@$total_count) {
                                                    echo $total_count;
                                                } else {
                                                    echo "0";
                                                }
                                                ?> </span>
                    </div>

                </div>

            </div>

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