<div class="breadcrumb float_left">
    <ul>
        <li>
            <span>Closed Calls</span>
        </li>

    </ul>
</div>

<form method="post" name="inc_list_form" id="inc_list">
    <!--<h2>Export <?php echo $report_name; ?> Details</h2> -->
    <div class="width100">
        <div class="field_row float_left width40">

            <div class="filed_select">
                <div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">From: </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="from_date" tabindex="1" class="form_input filter_required" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                    </div>
                </div>
                <div class="width50 drg float_left">
                    <div class="width100 float_left">
                        <div class="style6 float_left">To : </div>
                    </div>
                    <div class="width100 float_left">
                        <input name="to_date" tabindex="2" class="form_input filter_required" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                    </div>
                </div>


            </div>

        </div>
        <div class="width_30 float_left" style="margin-top: 10px;">
            <div class="button_field_row">
                <div class="button_box text_center">

                    <!--                    <input type="submit" name="submit" value="Submit" TABINDEX="3">  -->
                    <input type="button" name="submit" value="Submit" data-qr="output_position=content&amp;reports=view&amp;module_name=reports&amp;showprocess=no" data-href="<?php echo base_url(); ?>closed_calls" class="form-xhttp-request btn clg_search">
                    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}closed_calls" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="2" autocomplete="off">
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
                    defaultDate: null,
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    defaultDate: null,
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
    <div class="width100" id="ero_dash">



        <table class="table report_table">



            <tr>

                <th nowrap>Date</th>
                <th nowrap>Incident ID</th>
                <th nowrap>Incident Status</th>
                <th nowrap>Closure Status</th>
                <th nowrap>Caller Name</th>
                <th nowrap>District</th>
                <th nowrap>Caller Mobile No</th>
                <th nowrap>EMT Name</th>
                <th nowrap>EMT Mobile</th>
                <th>ERO Name</th>
                <th>Audio File</th>
                <th nowrap>Ambulance</th>
                <th nowrap>Call Time</th>

            </tr>



            <?php if (count(@$inc_info) > 0) {



                $total = 0;
                foreach ($inc_info as $key => $inc) {

                    // var_dump($inc['inc_pcr_status']);
                    if ($inc['clr_fullname'] != '') {
                        $caller_name = $inc['clr_fullname'];
                    } else {
                        $caller_name = $inc['clr_fname'] . " " . $inc['clr_mname'] . " " . $inc['clr_lname'];
                    }

            ?>

                    <tr>




                        <td><?php echo date("d-m-Y", strtotime($inc['inc_datetime'])); ?></td>

                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc['inc_ref_id']; ?>" style="color:#000;"><?php echo $inc['inc_ref_id']; ?></a></td>
                        <?php
                        if ($inc['incis_deleted'] == 0) {
                            $disptched = "Dispatched";
                        }
                        if ($inc['incis_deleted'] == 2) {
                            $disptched = "Terminated";
                        }
                        if ($inc['incis_deleted'] == 1) {
                            $disptched = "Deleted";
                        }
                        if ($inc['inc_pcr_status'] == '0' || $inc['inc_pcr_status'] == 0) {
                            $closer = "Closuer Pending";
                        } else {
                            $closer = "Closuer Done";
                        }
                        ?>
                        <td><?php echo $disptched; ?></td>
                        <td><?php echo $closer; ?></td>
                        <td><?php echo ucwords($caller_name); ?></td>

                        <td><?php echo $inc['dst_name']; ?></td>
                        <!--                           <td ><?php echo ucwords($patient_name); ?></td>-['
<!--                           <td  style="background: #FFD4A2;;"><?php echo $inc['inc_bvg_ref_number']; ?></td>-->
                        <td><?php echo $inc['clr_mobile']; ?></td>

                        <!--                           <td ><?php echo $inc['inc_address']; ?></td>-->


                        <td><?php echo $inc['amb_emt_id']; ?><?php //echo ucwords($inc['emt_first_name']." ".$inc['emt_last_name']);
                                                            ?></td>
                        <td nowrap><?php echo $inc['amb_default_mobile']; ?></td>
                        <!--                            <td ><?php echo $inc['amb_pilot_id']; ?><?php //echo ucwords($inc['clg_first_name']." ".$inc['clg_last_name']);
                                                                                                ?></td>
                     <td ><?php echo $inc['amb_pilot_mobile']; ?><?php //echo ucwords($inc['clg_first_name." ".$inc['clg_last_name);
                                                                ?></td>-->

                        <td nowrap><?php echo ucwords(strtolower($inc['clg_first_name'] . " " . $inc['clg_last_name'])); ?></td>
                        <td>
                            <?php
                            if ($inc['inc_avaya_uniqueid'] != '') {
                                $inc_datetime = date("Y-m-d", strtotime($inc['inc_datetime']));

                                $pic_path =   get_inc_recording($inc['inc_avaya_uniqueid'], $inc_datetime);
                            ?>

                                <audio controls controlsList="nodownload" style="width: 185px;">
                                    <source src="<?php echo $pic_path; ?>" type="audio/wav">
                                    Your browser does not support the audio element.
                                </audio>
                            <?php
                            }

                            ?>

                        </td>
                        <td nowrap><?php echo $inc['amb_rto_register_no']; ?></td>


                        <td><?php echo date("H:i:m", strtotime($inc['inc_datetime'])); ?></td>






                    </tr>

                <?php } ?>

            <?php } else {   ?>



                <tr>
                    <td colspan="13" class="no_record_text">No Record Found</td>
                </tr>



            <?php } ?>





        </table>



        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <input type="hidden" name="submit_data" value="<?php if (@$data) {
                                                                echo $data;
                                                            } ?>">

            <div class="width33 float_right">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}closed_calls/index" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                            <?php echo rec_perpg($pg_rec); ?>

                        </select>

                    </div>

                    <div class="float_right">
                        <span> Total records: <?php if (@$inc_total_count) {
                                                    echo $inc_total_count;
                                                } else {
                                                    echo "0";
                                                } ?> </span>
                    </div>
                </div>

            </div>

        </div>


    </div>
</form>