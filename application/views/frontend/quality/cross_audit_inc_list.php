<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Incident Listing</span></li>
    </ul>
</div>



<table class="table report_table">
    <tr>                
        <th nowrap>Incident ID</th>
        <th nowrap>Date time</th>
        <th nowrap>Caller Name</th>
        <th nowrap>Caller Number</th>
        <th nowrap>Call Type</th>
        <!-- <th nowrap>Chief Complaint</th> -->
        <th nowrap>Quality Score</th>
        <th nowrap>Audit Done By</th>
        <th nowrap>Quality Audit</th>
    </tr>

    <?php 
    if (count(@$inc_info) > 0) {
        $total = 0;

        foreach ($inc_info as $key => $inc) { 
//            var_dump($inc);
             $caller_name = $inc->clr_fname . "  " . $inc->clr_lname;
            ?>
            <tr>

                <td><?php echo $inc->inc_ref_id;?></td> 
                <td><?php echo date("d-m-Y h:m:i", strtotime($inc->inc_datetime)); ?></td>
                <td><?php echo ucwords($caller_name); ?></td>
                <td><?php echo $inc->clr_mobile; ?></td>
                <td nowrap><?php echo ucwords(get_purpose_of_call($inc->inc_type)); ?></td>
                <!-- <td nowrap><?php echo ucwords($inc->pname); ?></td> -->
                <td nowrap><?php echo $inc->quality_score; ?></td>
                <td nowrap><?php echo $inc->added_by; ?></td>
                <td nowrap>
                   
                    <a class="click-xhttp-request action_button btn" data-href="{base_url}quality_forms/single_record_view"  data-qr="output_position=content&inc_ref_id=<?php echo $inc->inc_ref_id; ?>&ref_id=<?php echo $ref_id;?>&user_type=<?php echo $user_type;?>&type=edit&audit_id=<?php echo $inc->qa_ad_id; ?>" data-popupwidth="1000" data-popupheight="350">View</a>
                  

                </td>
                
            </tr>
        <?php
        }
    } else { ?>

        <tr><td colspan="6" class="no_record_text">No history Found</td></tr>

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

                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality_forms/cross_audit_inc_list" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                </select>

            </div>

            <div class="float_right">
                <span> Total records: <?php
                    if (@$total_count) {
                        echo $total_count;
                    } else {
                        echo"0";
                    }
                    ?> </span>
            </div>

        </div>

    </div>

</div>
