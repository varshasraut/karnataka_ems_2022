<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Suggestion</span></li>
    </ul>
</div>

<div class="width2 float_right">
    <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add Suggestion" data-href="{base_url}fleet/suggestion_registration" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=fleet" type="button" data-popupwidth="800" data-popupheight="600"> 

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}fleet/suggestion" data-qr="output_position=content&amp;filters=reset" type="button">

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


                                <?php if ($CI->modules->get_tool_config('MT-CLG-ACTION-MULTI', $this->active_module, true) != '') { ?>  

                                    <input type="button" name="Delete" value="Delete" id="del_clg" class="btn form-xhttp-request" data-href="{base_url}clg/delete_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action=delete&amp;page_no=<?php echo @$page_no; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete colleagues?">

                                <?php } ?>


                            </div>



                            <div class="field_row width100">
                                <div class="filed_input float_left width_25">



                                    <input type="text"  placeholder="Search Name" value="<?php echo @$search; ?>" name="search"></div> 
<!--                                <div class="filed_input float_left width33">

                                    <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" >
                                </div>-->
                                <div id="date_filter"></div>
                                
                                <div class="filed_input float_left width_25">
                                    <label for="search_clg">



                                        <input type="button" name="search_btn1" value="Search" class="btn clg_search form-xhttp-request mt-0" data-href="{base_url}fleet/suggestion" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >





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
                        <!--<th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>-->                        
                        <th nowrap>Type</th>
                        <th nowrap>Suggestion Remark</th>
                        <th nowrap>Date/Time</th>
                        <th>Action</th> 

                    </tr>

                    <?php
                    if (count($sugg_data) > 0) {

                        foreach ($sugg_data as $sugg_data) {
                            ?>
                            <tr>
<!--                                <td><input type="checkbox" data-base="selectall" class="base-select" name="ref_id[<?= $colleague->clg_ref_id; ?>]" value="<?= base64_encode($fuel_station->clg_ref_id) ?>" title="Select All Ambulance"/></td>-->
                                    <?php //} ?>

                                <td><?php echo $sugg_data->su_type; ?></td>
                                <td><?php echo $sugg_data->su_suggetion_remark; ?></td>
                                <td><?php echo $sugg_data->su_date_time; ?></td> 
                                <td> 

                                    <div class="user_action_box suggestion_action" >

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

        <?php if ($CI->modules->get_tool_config('MT-FLTMNT-VIEW-SUGG', 'M-FLTMNT', $this->active_module, true) != '') { ?>   
                                                <li><a class="onpage_popup action_button" data-href="{base_url}fleet/view_suggestion"  data-qr="output_position=content&amp;tlcode=MT-FLTMNT-VIEW-SUGG&amp;module_name=fleet&amp;su_id=<?php echo base64_encode($sugg_data->su_id); ?>&amp;action_type=View Work Station" data-popupwidth="800" data-popupheight="250">View</a></li>

        <?php
        }
        if ($CI->modules->get_tool_config('MT-CLG-EDIT', 'M-UPRO', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
            ?>   

                                                <!--
                                                                                                <li><a class="onpage_popup action_button" data-href="{base_url}fleet/suggestion_registration" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;su_id=<?php echo base64_encode($sugg_data->su_id); ?>&amp;action=edit_data&amp;action_type=Update"  data-popupwidth="1000" data-popupheight="300">Edit</a></li>          -->


                                            <?php }
                                            ?>


                                        </ul> 
                                    </div>
                                </td>
                            </tr>
                        <?php }
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}fleet/suggestion" data-qr="output_position=content&amp;flt=true">

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