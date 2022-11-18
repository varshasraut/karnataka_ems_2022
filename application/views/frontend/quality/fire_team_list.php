<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Fire Team Listing</span></li>
    </ul>
</div>

<div class="width2 float_right">
    <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add More" data-href="{base_url}quality/fire_team" data-qr="output_position=popup_div&amp;module_name=amb_maintaince" type="button" data-popupwidth="800" data-popupheight="700"> 

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}quality/fire_team_list" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="search_btn_width">
                                
                                <div class="filed_input float_left width_20">
                                    <input class="form_input width100" type="text" id="search_clg" placeholder="Search Name" value="<?php echo @$search; ?>" name="search" style="width: 95% !important;">
                                </div>                              
                                <div class="filed_input float_left width_20">  
                                  
                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left" data-href="{base_url}quality/fire_team_list" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >
                                   
                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                        <th nowrap>QA Name</th>
                        <th nowrap>ERO Superwiser</th>
    
                    </tr>

                    <?php
                    if (count($maintance_data) > 0) {
                        $count = 1;
                        $total = $total_count;
                        foreach ($maintance_data as $stat_data) { ?>
                            <tr>
                                
                                <td><?php 
                                //echo $stat_data->qa_name;
                                $qa_name = get_clg_data_by_ref_id($stat_data->qa_name); 
                                echo $qa_name[0]->clg_first_name.' '.$qa_name[0]->clg_mid_name.' '.$qa_name[0]->clg_last_name; ?></td> 
                                <td><?php //echo $stat_data->ero_supervisor ; 
                                $ero_supervisor = get_clg_data_by_ref_id($stat_data->ero_supervisor); 
                                echo $ero_supervisor[0]->clg_first_name.' '.$ero_supervisor[0]->clg_mid_name.' '.$ero_supervisor[0]->clg_last_name; 
                                ?></td> 
<!--                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php //if ($CI->modules->get_tool_config('MT-PREV-MANT-VIEW', 'M-AMB-MAINT', $this->active_module, true) != '') { ?>   
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}quality/accidental_maintaince_view"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;module_name=amb_maintaince&amp;mt_id=<?php echo base64_encode($stat_data->mt_id); ?>&amp;action_type=View" data-popupwidth="1000" data-popupheight="350">View</a></li>

                                                <?php
                                           // }
                                           // if ($CI->modules->get_tool_config('MT-PREV-MANT-UPDATE', 'M-AMB-MAINT', $this->active_module, true) != '' && $stat_data->mt_isupdated == 0) {
                                                ?>   


                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}quality/accidental_maintaince_registrartion" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-PREV-MANT-UPDATE&amp;mt_id=<?php echo base64_encode($stat_data->mt_id); ?>&action_type=Update" data-popupwidth="1000" data-popupheight="450">Update</a></li>          


                                            <?php //}
                                            ?>


                                        </ul> 
                                    </div>
                                </td>-->
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}quality/fire_team_list" data-qr="output_position=content&amp;flt=true">

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

            </div>
        </form>
    </div>
</div>