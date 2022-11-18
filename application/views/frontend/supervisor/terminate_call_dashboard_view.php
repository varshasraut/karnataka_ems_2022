<div id="supervisor_container">
    <div id="calls_inc_list">

        <form method="post" name="inc_list_form" id="inc_list1">
            <div class="width100" id="ero_dash">
                <div id="amb_filters">
                    <div class="width100 float_left">
                    <div class="breadcrumb float_left">
                                    <ul>

                                        <li><span>Terminate Call</span></li>
                                    </ul>
                                </div>
                        <div class="search">

                            <div class="row">
                                
                                <div class="width100 float_left margin_top_10">
                                    <!-- <div class="width25 float_left">

                                        <h3 class="txt_clr2 ">Terminate Call</h3>
                                    </div> -->
                                    <div class="width20 float_left">
                                        <input type="text" class="controls amb_search" id="mob_no3" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search" />
                                    </div>

                                    <div class="width25 float_left">

                                        <input type="button" class="search_button form-xhttp-request" name="search" value="Search" data-href="{base_url}supervisor/terminate_list" data-qr="output_position=content&amp;flt=true&amp;type=inc" />

                                    </div>
                                    <div class="width20 float_left">


                                        <input class="search_button click-xhttp-request" style="margin-left: -40%;" name="" value="Reset Filters" data-href="{base_url}supervisor/terminate_list" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="2" autocomplete="off">
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="list_table">

                    <table class="table report_table">
                        <tr>
                            <th nowrap>Date / Time</th>
                            <th>Call Type</th>
                            <th nowrap> Caller Number </th>
                            <th nowrap>Caller Name</th>
                            <th nowrap>Incident ID</th>
                            <th nowrap>District </th>
                            <th nowrap>Ambulance No</th>
                            <th nowrap>Call Duration</th>
                            <th nowrap>ERO Name</th>
                            <th nowrap>Audio File</th>
                            <th nowrap>Action</th>

                        </tr>
                        <?php
                        if (count(@$inc_info) > 0) {



                            $total = 0;

                            foreach ($inc_info as $key => $inc) {



                                if (($inc->ptn_mname == '') && ($inc->ptn_fname == '')) {
                                    $inc->ptn_mname = "-";
                                    $inc->ptn_fname = "-";
                                }

                                if ($inc->ptn_fullname != '') {
                                    $patient_name = $inc->ptn_fullname;
                                } else {
                                    $patient_name = $inc->ptn_fname . " " . $inc->ptn_mname . " " . $inc->ptn_lname;
                                }

                                //                                    if ($inc->clr_fullname != '') {
                                //                                        $caller_name = $inc->clr_fullname;
                                //                                    } else {
                                $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
                                //                                    }
                        ?>

                                <tr>




                                    <td nowrap><?php echo date("d-m-Y H:m:i", strtotime($inc->inc_datetime)); ?></td>
                                    <td><?php echo ucwords($inc->pname); ?></td>
                                    <td nowrap><?php echo $inc->clr_mobile; ?></td>
                                    <td nowrap><?php echo ucwords($caller_name); ?></td>
                                    <td nowrap><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo $inc->inc_ref_id; ?></td>
                                    <td nowrap><?php echo $inc->dst_name; ?></td>
                                    <td nowrap><?php echo $inc->amb_rto_register_no; ?></td>

                                    <td nowrap><?php echo ($inc->inc_dispatch_time); ?></td>
                                    <td nowrap><?php echo ($inc->inc_added_by); ?></td>
                                    <td>
                                        <?php
                                        if ($inc_details[0]->inc_avaya_uniqueid != '') {

                                            $inc_datetime = date("Y-m-d", strtotime($inc_details[0]->inc_datetime));
                                            $pic_path = get_inc_recording($inc_details[0]->inc_avaya_uniqueid, $inc_datetime); ?>

                                            <audio controls controlsList="nodownload" style="width: 185px;">
                                                <source src="<?php echo $pic_path; ?>" type="audio/wav">
                                                Your browser does not support the audio element.
                                            </audio>
                                        <?php
                                        }

                                        ?>

                                    </td>
                                    <td> <a class="onpage_popup btn" data-href="{base_url}supervisor/terminate_calls?amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="300" data-popupheight="300">Action</a></td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>



                            <tr>
                                <td colspan="11" class="no_record_text">No Record Found</td>
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

                        <div class="width33 float_right">

                            <div class="record_per_pg">

                                <div class="per_page_box_wrapper">

                                    <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                    <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/terminate_list" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                        <?php echo rec_perpg($pg_rec); ?>

                                    </select>

                                </div>

                                <div class="float_right">
                                    <span> Total records: <?php
                                                            if (@$inc_total_count) {
                                                                echo $inc_total_count;
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?> </span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </form>
    </div>



</div>