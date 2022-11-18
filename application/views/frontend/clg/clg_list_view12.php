<?php
$CI = EMS_Controller::get_instance();

$clg_status = array('0' => 'Blocked', '1' => 'Unblocked', '2' => 'Suspended');
$sts = array('0' => 'Active', '1' => 'Inactive');
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>
        <li class="colleague"><a href="#">Colleagues</a></li>
        <li><span>Colleagues List</span></li>
    </ul>
</div>

<div class="width2 float_right">
    <input class="add_button_amb onpage_popup float_right" name="add_amb" value="Register Colleagues" data-href="{base_url}Clg/registration" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=clg" type="button" data-popupwidth="1000" data-popupheight="800"> 

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters"> </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        
                        <th nowrap>Clg Ref Id</th>
                        <th nowrap>Name</th>
                        <th nowrap>Mobile Number</th>
                        <th nowrap>Email</th>
                        <th>Group</th>
                        <th>Status</th> 
                        <th>Action</th> 

                    </tr>

                    <?php
                    if (count($colleagues) > 0) {

                        foreach ($colleagues as $colleague) {
                            ?>
                            <tr>
                                <td><input type="checkbox" data-base="selectall" class="base-select" name="ref_id[<?= $colleague->clg_ref_id; ?>]" value="<?= base64_encode($colleague->clg_ref_id) ?>" title="Select All Ambulance"/></td><?php //} ?>

                                <td><?php echo $colleague->clg_ref_id; ?></td>
                                <td><?php echo $colleague->clg_first_name . " " . $colleague->clg_last_name; ?></td>
                                <td><?php echo $colleague->clg_mobile_no; ?></td>                        
                                <td><?php echo $colleague->clg_email; ?> </td>     
                                <td><?php echo $colleague->clg_group; ?> </td>      
                                <td><?php echo $clg_status[$colleague->clg_is_active]; ?>


                                </td>       

                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php if ($CI->modules->get_tool_config('MT-CLG-VIEW', 'M-UPRO', $this->active_module, true) != '') { ?>   
                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/edit_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;ref_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=edit_data&amp;clg_view=view&amp;clg_group=<?php echo $colleague->clg_group; ?>&amp;clg_senior=<?php echo $colleague->clg_senior; ?>" data-popupwidth="900" data-popupheight="850">View</a></li>

                                            <?php }
                                            if ($CI->modules->get_tool_config('MT-CLG-EDIT', 'M-UPRO', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                                ?>   


                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/edit_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;ref_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=edit_data&amp;clg_group=<?php echo $colleague->clg_group; ?>&amp;clg_senior=<?php echo $colleague->clg_senior; ?>" name="<?php echo $colleague->clg_ref_id; ?>" data-popupwidth="900" data-popupheight="850">Edit</a></li>          


                                            <?php }

                                            if ($CI->modules->get_tool_config('MT-CLG-DELETE', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                                ?>  

                                                <li> <a class="click-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id; ?>" data-href="{base_url}clg/delete_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-DELETE&amp;ref_id[0]=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=delete&amp;page_no=<?php echo @$page_no; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete this user? ID :<?php echo $colleague->clg_ref_id; ?>"> Delete</a></li>     

                                            <?php
                                            }
//                                
                                            if (($CI->modules->get_tool_config('MT-CLG-PASSWORD', 'M-UPRO', $this->active_module, true) != '' && $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id)) {
                                                ?>  

                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id ?>&amp;action=change_password" data-popupwidth="480" data-popupheight="400"> Change Password</a></li>


        <?php }

        if (($CI->modules->get_tool_config('MT-CLG-CHNG-USER-PWD', $this->active_module, true) != '' && $CI->session->userdata('current_user')->clg_ref_id != $colleague->clg_ref_id)) {
            ?>  

                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id ?>&amp;action=change_user_password" data-popupwidth="480" data-popupheight="400"> Change User-Password</a></li>


        <?php }

//                                if($CI->modules->get_tool_config('MT-CLG-ADM-LGOUT',$this->active_module,true)!='' && $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id ){ 
        ?>  

        <!--<li><a class="click-xhttp-request logout_open action_button" data-href="{base_url}clg/logout" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ADM-LGOUT&amp;ref_id=//<?php echo $colleague->clg_ref_id; ?>" data-confirm='yes' data-confirmmessage="Are you sure to logout this user? ID :<?php echo $colleague->clg_ref_id; ?>">Logout</a></li>-->

                            <?php //}   ?> 

                                        </ul> 
                                    </div>
                                </td>
                            </tr>
    <?php }
} else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php if (@$total_count) {
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