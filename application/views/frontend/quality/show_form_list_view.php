
<table class="table report_table">

                    <tr>                
                        <th nowrap><?php echo $qa_team_type;?> User ID</th>
                        <th nowrap><?php echo $qa_team_type;?> Name</th>
                        <th nowrap><?php echo $qa_team_type;?> Mobile</th>
                        <th nowrap><?php echo $qa_team_type;?> Supervisor</th>
                        <th nowrap>Action</th>
    
                    </tr>

                    <?php
                    if (count($maintance_data) > 0) {
                        $count = 1;
                        $total = $total_count;
                        foreach ($maintance_data as $stat_data) {?>
                            <tr>
                                <td><?php echo $stat_data->clg_ref_id;?></td>
                                <td><?php 
                                $qa_name = get_clg_data_by_ref_id($stat_data->clg_ref_id); 
                                echo $qa_name[0]->clg_first_name.' '.$qa_name[0]->clg_mid_name.' '.$qa_name[0]->clg_last_name; ?></td> 
                                <td><?php echo $stat_data->clg_mobile_no;?></td>
                                <td><?php
                                $ero_supervisor = get_clg_data_by_ref_id($stat_data->ero_supervisor); 
                                echo $ero_supervisor[0]->clg_first_name.' '.$ero_supervisor[0]->clg_mid_name.' '.$ero_supervisor[0]->clg_last_name; 
                                ?></td> 
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}quality_forms/view_<?php echo strtolower($qa_team_type); ?>_incidence_quality" data-qr="output_position=content&amp;ref_id=<?php echo $stat_data->clg_ref_id; ?>&amp;action_type=View&user_type=<?php echo $qa_team_type;?>" data-popupwidth="1000" data-popupheight="350">View</a></li>

                                        </ul> 
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                    } else { ?>

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality_forms/show_form_list" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php
                                    if (@$total_count) {
                                        echo $total_count;
                                    } else {
                                        echo"0";
                                    } ?> </span>
                            </div>

                        </div>

                    </div>

                </div>