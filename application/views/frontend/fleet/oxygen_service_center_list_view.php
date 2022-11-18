<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Oxygen Service Center</span></li>
    </ul>
</div>

<div class="width2 float_right">
    <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add Oxygen Service Center" data-href="{base_url}fleet/oxygen_center_registration_view" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=fleet" type="button" data-popupwidth="800" data-popupheight="600"> 

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}fleet/oxygen_service_center" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="group_action_field_btns">


                            </div>

                            <div class="search_btn_width">


                                <div class="srch_box_fuel">



                                    <input type="text" id="search_clg" placeholder="Search Name" value="<?php echo @$search; ?>" name="search">



                                    <label for="search_clg">



                                        <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request mt-0" data-href="{base_url}fleet/oxygen_service_center" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >



                                    </label>



                                </div>



                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                

                        <th nowrap>Oxygen Service Center</th>
                        <th nowrap>State</th>
                        <th nowrap>District</th>
                        <th nowrap>Address</th>
                        <th nowrap>Station Mobile No</th>
                        <th nowrap>Date Time</th>
                        <th>Action</th> 

                    </tr>

                    <?php
                    if (count($oxygen_center) > 0) {

                        foreach ($oxygen_center as $oxygen_center) {
                            ?>
                            <tr>
                                <td><?php echo $oxygen_center->os_oxygen_name; ?></td>
                                <td><?php echo $oxygen_center->st_name; ?></td>
                                <td><?php echo $oxygen_center->dst_name; ?></td> 
                                <td><?php echo $oxygen_center->os_address; ?></td>  
                                <td><?php echo $oxygen_center->os_station_mobile_no; ?> </td>
                                <td><?php echo $oxygen_center->os_added_date; ?> </td>     
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php if ($CI->modules->get_tool_config('MT-OXY-CEN-VIEW', 'M-FLTMNT', $this->active_module, true) != '') { ?>   
                                                <li><a class="onpage_popup action_button" data-href="{base_url}fleet/view_oxygen_center"  data-qr="output_position=content&amp;tlcode=MT-OXY-CEN-VIEW&amp;module_name=fleet&amp;os_id=<?php echo base64_encode($oxygen_center->os_id); ?>&amp;action_type=View Oxygen Service Center" data-popupwidth="800" data-popupheight="250">View</a></li>

                                                <?php
                                            }
                                            if ($CI->modules->get_tool_config('MT-CLG-EDIT', 'M-UPRO', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                                ?>   


                                                <li><a class="onpage_popup action_button" data-href="{base_url}fleet/oxygen_center_registration_view" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;os_id=<?php echo base64_encode($oxygen_center->os_id); ?>&amp;action=edit_data&amp;action_type=Update"  data-popupwidth="800" data-popupheight="350">Update</a></li>          


                                            <?php }
                                            ?>


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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}fleet/oxygen_service_center" data-qr="output_position=content&amp;flt=true">

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

            </div>
        </form>
    </div>
</div>