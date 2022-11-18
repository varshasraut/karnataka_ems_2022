<?php
$CI = EMS_Controller::get_instance();
?>
<div class="width_25 float_right" style="margin-bottom: 10px;">
    <div class="button_field_row">
        <div class="button_box">
            <form action="<?php echo base_url(); ?>quality_forms/view_incidence_quality_download" method="post" enctype="multipart/form-data" target="form_frame">
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

<table class="table report_table table-bordered">
    <tr>
        <th nowrap>Date Time</th>
        <!-- <th nowrap>Avaya ID</th>  -->
        <th nowrap>Incident ID</th>
        <th nowrap>ERO Name</th>
        <th nowrap>District</th>
        <th nowrap>Caller Name</th>
        <th nowrap>Caller Number</th>
        <th nowrap>Call Type</th>
        <th nowrap>Chief Complaint</th>
        <th nowrap>Call Time</th>
        <th nowrap>Audio File</th>
        <th nowrap>Quality Audit</th>
    </tr>
    <?php //var_dump($inc_info); 
    ?>
    <?php
    if (count(@$inc_info) > 0) {
        $total = 0;

        foreach ($inc_info as $key => $inc) {
            // var_dump($inc);
            $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
    ?>
            <tr>
                <td><?php echo $inc->inc_datetime; ?></td>
                <!-- <td><?php echo $inc->clg_avaya_agentid; ?></td> -->
                <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;"><?php echo  $inc->inc_ref_id; ?></a></td>

                <td><?php echo ucwords($inc->clg_first_name . "  " . $inc->clg_last_name); ?></td>
                <td><?php if ($inc->dst_name) {
                        echo $inc->dst_name;
                    } else {
                        echo "NA";
                    } ?></td>
                <td><?php echo ucwords($caller_name); ?></td>
                <td><?php echo $inc->clr_mobile; ?></td>
                <td nowrap><?php echo ucwords($inc->pname); ?></td>
                <td><?php if ($inc->ct_type) {
                        echo $inc->ct_type;
                    } else {
                        echo "NA";
                    } ?></td>
                <td><?php echo $inc->inc_dispatch_time; ?></td>
                <td><?php
                    $inc_datetime = $inc->inc_datetime;
                    $pic_path =  $inc->inc_audio_file;
                    //$pic_path =  get_inc_recording($inc->inc_avaya_uniqueid);
                    if ($pic_path != "") {
                    ?>
                        <audio controls controlsList="nodownload" style="width: 185px;" onplay="pauseOthers(this);">
                            <source src="<?php echo $pic_path; ?>" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    <?php
                    } ?>
                </td>




                <td nowrap>
                    <?php if ($inc->inc_audit_status == '0') { ?>
                        <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/open_audit" data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php echo $inc->clg_ref_id; ?>&user_type=<?php echo $user_type; ?>&user_quality=1&audit_inc_datetime=<?php echo  date("d-m-Y h:i:s", strtotime($inc->inc_datetime)) ?>" data-popupwidth="1000" data-popupheight="350">Action</a>
                    <?php } else { ?>
                        <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/open_audit" data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php echo $inc->clg_ref_id; ?>&user_type=<?php echo $user_type; ?>&type=edit" data-popupwidth="1000" data-popupheight="350">Edit</a>
                    <?php } ?>

                </td>

            </tr>
        <?php
        }
    } else {
        ?>

        <tr>
            <td colspan="9" class="no_record_text">No history Found</td>
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

                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality_forms/view_incidence_quality" data-qr="output_position=content&amp;flt=true">

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