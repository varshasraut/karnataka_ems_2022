
<table class="table report_table">

    <tr>                
        <th nowrap><?php echo $qa_team_type; ?> User ID</th>
        <th nowrap><?php echo $qa_team_type; ?> Name</th>
        <th nowrap><?php echo $qa_team_type; ?> Mobile</th>
        <th nowrap><?php echo $qa_team_type; ?> Supervisor</th>
        <th nowrap>Action</th>

    </tr>

    <?php
    if (count($result_data) > 0) {
        $count = 1;
        $total = $total_count;
        foreach ($result_data as $stat_data) {
            ?>
            <tr>
                <td><?php echo $stat_data->clg_ref_id; ?></td>
                <td><?php
                    $qa_name = get_clg_data_by_ref_id($stat_data->clg_ref_id);
                    echo $qa_name[0]->clg_first_name . ' ' . $qa_name[0]->clg_mid_name . ' ' . $qa_name[0]->clg_last_name;
                    ?></td> 
                <td><?php echo $stat_data->clg_mobile_no; ?></td>
                <td><?php
                    $ero_supervisor = get_clg_data_by_ref_id($stat_data->ero_supervisor);
                    echo $ero_supervisor[0]->clg_first_name . ' ' . $ero_supervisor[0]->clg_mid_name . ' ' . $ero_supervisor[0]->clg_last_name;
                    ?></td> 
                <td> 

                    <div class="user_action_box shift_user_list">

                        <div class="colleagues_profile_actions_div"></div>

                        <ul class="profile_actions_list">


                            <li><a class="onpage_popup action_button" data-href="{base_url}shiftmanager/view_login_details"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;module_name=amb_maintaince&amp;ref_id=<?php echo $stat_data->clg_ref_id; ?>&amp;action_type=View" data-popupwidth="700" data-popupheight="600">View Login</a></li>
                            
                            <li><a class="onpage_popup action_button" data-href="{base_url}shiftmanager/view_break_form"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;module_name=amb_maintaince&amp;ref_id=<?php echo $stat_data->clg_ref_id; ?>&amp;action_type=View" data-popupwidth="700" data-popupheight="600">View Break</a></li>

                        </ul> 
                    </div>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>

        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

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

                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}shiftmanager/show_user_list" data-qr="output_position=content&amp;flt=true">

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