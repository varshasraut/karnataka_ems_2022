<?php
$CI = EMS_Controller::get_instance();


$dispatch = $CI->modules->get_tool_config('M-BIO-EQUP-DiS', 'M-BIOMEDICAL', true);


$receive = $CI->modules->get_tool_config('M-BIO-EQUP-REV', 'M-BIOMEDICAL', true);

$send_request = $CI->modules->get_tool_config('M-BIO-EQUP-ADD', 'M-BIOMEDICAL', true);

$approve = $CI->modules->get_tool_config('M-BIO-EQUP-APP', 'M-BIOMEDICAL', true);
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Equipment Maintenance</span></li>
    </ul>
</div>

<div class="width2 float_right">


    <?php // if ($send_request != '') { ?>
    <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add More" data-href="{base_url}biomedical/add_equipment_maintance" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=fleet" type="button" data-popupwidth="1000" data-popupheight="800">
    <?php // } ?>

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}biomedical/equipment" data-qr="output_position=content&amp;filters=reset" type="button">

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

                            <div class="field_row width100">
                                <div class="filed_input float_left width33">

                                    <input type="text"  placeholder="Search Name" value="<?php echo @$search; ?>" name="search"></div> <div class="filed_input float_left width33">

                                    <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>
                                <div class="filed_input float_left width33">
                                    <label for="search_clg">

                                        <input type="button" name="search_btn1" value="Search" class="btn clg_search form-xhttp-request" data-href="{base_url}biomedical/equipment" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >

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

                        <th nowrap>Sr. No</th>
                        <th nowrap>District</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Ambulance No</th>
                        <th nowrap> Date / Time</th>
<!--                        <th nowrap>Available Qty In Ambulance</th> 
                        <th nowrap>Status</th> -->
                        <th nowrap>Action</th> 

                    </tr>

                    <?php
                    if ($equipment_data){


                        $count = 1;

                        $total = count($equipment_data);

                        foreach ($equipment_data as $equipment_data) {
                            ?>
                            <tr>

                                <td><?php echo $count++; ?></td>
                                <td><?php echo $equipment_data->dst_name; ?></td> 
                                <td><?php echo $equipment_data->hp_name; ?> </td>  
                                <td><?php echo $equipment_data->eq_amb_ref_no; ?></td>
                                <td><?php echo $equipment_data->eq_added_date; ?> </td>  
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php if ($CI->modules->get_tool_config('MT-BIOMEDICAL_EQUP_VIEW', 'M-BIOMEDICAL', $this->active_module, true) != '') { ?>   
                                                <li><a class="onpage_popup action_button" data-href="{base_url}biomedical/equipment_maintaince_view"  data-qr="output_position=content&amp;tlcode=MT-BIOMEDICAL_EQUP_VIEW&amp;module_name=fleet&amp;eq_id=<?php echo base64_encode($equipment_data->eq_id); ?>&amp;action_type=View Work Station" data-popupwidth="1000" data-popupheight="400">View</a></li>

                                                <?php
                                            }
                                            if ($CI->modules->get_tool_config('MT-CLG-EDIT', 'M-UPRO', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                                if ($equipment_data->is_updated != '1' &&  $equipment_data->mt_approval== 1) {
                                                    ?>

                                                    <li><a class="onpage_popup action_button" data-href="{base_url}biomedical/add_equipment_maintance" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;eq_id=<?php echo base64_encode($equipment_data->eq_id); ?>&amp;action=edit_data&amp;action_type=Update"  data-popupwidth="1000" data-popupheight="580">Update</a></li>          


                                                    <?php
                                                }
                                            }
//                                            
                                            if ($CI->modules->get_tool_config('MT-BIOMEDICAL_APP', 'M-BIOMEDICAL', $this->active_module, true) != '' && $equipment_data->mt_isupdated == 0 &&  $equipment_data->mt_approval != 1) { ?>   
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/equipment_maintainance_approve" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-EQU-MANT-APP&amp;eq_id=<?php echo $equipment_data->eq_id; ?>&amp;action_type=Approve&amp;amb_rto_register_no=<?php echo base64_encode($equipment_data->eq_amb_ref_no); ?>" data-popupwidth="1000" data-popupheight="450">Approval</a></li>          
   
                                            <?php }  if ($CI->modules->get_tool_config('MT-BIOMEDICAL_APP', 'M-BIOMEDICAL', $this->active_module, true) != '' && $equipment_data->mt_isupdated == 0 &&  $equipment_data->mt_approval== 0) { ?>   
                                                 <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/equipment_maintainance_re_request" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-EQU-MANT-RE&amp;eq_id=<?php echo $equipment_data->eq_id; ?>&amp;action_type=Re_request&amp;amb_rto_register_no=<?php echo base64_encode($equipment_data->mt_amb_no); ?>" data-popupwidth="1000" data-popupheight="450">Re-Request</a></li>          
                                                
                                                 <?php } ?>


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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}biomedical/equipment" data-qr="output_position=content&amp;flt=true">

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