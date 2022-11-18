<?php
$CI = EMS_Controller::get_instance();

$clg_status = array('0' => 'Inactive', '1' => 'Active', '2' => 'Deleted');
$sts = array('0' => 'Active', '1' => 'Inactive');
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>
        <li class="colleague"><a href="#">Employee</a></li>
        <li><span>Employee List</span></li>
    </ul>
</div>

<div class="width2 float_right">
    <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add Employee" data-href="{base_url}clg/registration" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=clg" type="button" data-popupwidth="800" data-popupheight="600"> 
   
    <?= $CI->modules->get_tool_html('MT-CLG-IMP', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=500"); ?>
        
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
                        <th nowrap>User Id</th>
                        <th nowrap>Name</th>
                        <th nowrap>Employee ID</th>
                        <th nowrap>Mobile Number</th>
                          <th nowrap>Email Id</th>
                        <!-- <th nowrap>Ameyo Id</th> -->
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

                                <td><?php echo strtoupper($colleague->clg_ref_id); ?></td>
                                <td><?php echo ucwords($colleague->clg_first_name . " " . $colleague->clg_last_name); ?></td>
                                <td><?php echo $colleague->clg_jaesemp_id; ?></td>        
                                <td><?php echo $colleague->clg_mobile_no; ?></td>        
                                <td><?php echo $colleague->clg_email; ?> </td>     
                                <!-- <td><?php echo $colleague->clg_avaya_id; ?> </td>      -->
                                <td><?php echo $colleague->clg_group; ?> </td>      
                                <td><?php echo $clg_status[$colleague->clg_is_active]; ?>


                                </td>       

                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php if ($CI->modules->get_tool_config('MT-CLG-USRVIEW', 'M-CLG', $this->active_module, true) != '') { ?>   
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}clg/edit_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;ref_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=edit_data&amp;clg_view=view&amp;clg_group=<?php echo $colleague->clg_group; ?>&amp;clg_senior=<?php echo $colleague->clg_senior; ?>&amp;action_type=View">View</a></li>

                                            <?php }
                                            if ($CI->modules->get_tool_config('MT-CLG-USREDIT', 'M-CLG', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                                ?>   


                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}clg/edit_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-EDIT&amp;ref_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=edit_data&amp;clg_group=<?php echo $colleague->clg_group; ?>&amp;clg_senior=<?php echo $colleague->clg_senior; ?>&amp;action_type=Update" name="<?php echo $colleague->clg_ref_id; ?>" >Edit</a></li>
<!--                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}clg/edit_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;ref_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;clg_group=<?php echo $colleague->clg_group; ?>&amp;clg_senior=<?php echo $colleague->clg_senior; ?>&amp;action_type=Update">EDIT</a></li>-->


                                            <?php }

                                            if ($CI->modules->get_tool_config('MT-CLG-DELETE', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                                ?>  

<!--                                                <li> <a class="click-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id; ?>" data-href="{base_url}clg/delete_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-DELETE&amp;ref_id[0]=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=delete&amp;page_no=<?php echo @$page_no; ?>" data-confirm='yes' data-confirmmessage="Are you sure to delete this user? ID :<?php echo $colleague->clg_ref_id; ?>"> Delete</a></li>     -->

                                            <?php
                                            }
//                                
                                            if (($CI->modules->get_tool_config('MT-CLG-CHNG-PWD', 'M-CLG', $this->active_module, true) != '' && $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id)) {
                                                ?>  

                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id ?>&amp;action=change_password" data-popupwidth="480" data-popupheight="320"> Change Password</a></li>


        <?php }

        if (($CI->modules->get_tool_config('MT-CLG-CHNG-USER-PWD', $this->active_module, true) != '' && $CI->session->userdata('current_user')->clg_ref_id != $colleague->clg_ref_id)) {
            ?>  

                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?php echo $colleague->clg_ref_id ?>&amp;action=change_user_password" data-popupwidth="480" data-popupheight="400"> Change User-Password</a></li>


        <?php }

//                                if($CI->modules->get_tool_config('MT-CLG-ADM-LGOUT',$this->active_module,true)!='' && $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id ){ 
        ?>  

        <!--<li><a class="click-xhttp-request logout_open action_button" data-href="{base_url}clg/logout" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-ADM-LGOUT&amp;ref_id=//<?php echo $colleague->clg_ref_id; ?>" data-confirm='yes' data-confirmmessage="Are you sure to logout this user? ID :<?php echo $colleague->clg_ref_id; ?>">Logout</a></li>-->

                            <?php //}   ?> 
                                                <?php if (($CI->modules->get_tool_config('MT-CLG-RESET-PWD', $this->active_module, true) != '' && $CI->session->userdata('current_user')->clg_ref_id != $colleague->clg_ref_id)) {
            ?>  

                                                <li><a class="onpage_popup action_button" data-href="{base_url}clg/reset_password" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-RESET-PWD&amp;ref_id=<?php echo $colleague->clg_ref_id ?>&amp;action=change_user_password" data-popupwidth="480" data-popupheight="400"> Reset Password</a></li>


        <?php } ?>
                                                 <?php 

                                            if ($CI->modules->get_tool_config('MT-CLG-INACTIVATE', $this->active_module, true) != '' || $CI->session->userdata('current_user')->clg_ref_id == $colleague->clg_ref_id) {
                                               // echo $colleague->clg_ref_id;
                                                if($colleague->clg_is_active == '1'){
                                                ?>  

                                                <li> <a class="click-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id; ?>" data-href="{base_url}clg/inactivate_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-DELETE&amp;ref_id[0]=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=delete&amp;page_no=<?php echo @$page_no; ?>&active=0" data-confirm='yes' data-confirmmessage="Are you sure to Inactive this user? ID :<?php echo $colleague->clg_ref_id; ?>"> Inactive</a></li>     

                                            <?php
                                                }else{ ?>
                                                 <li> <a class="click-xhttp-request action_button" name="<?php echo $colleague->clg_ref_id; ?>" data-href="{base_url}clg/inactivate_clg" data-qr="output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-DELETE&amp;ref_id[0]=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action=delete&amp;page_no=<?php echo @$page_no; ?>&active=1" data-confirm='yes' data-confirmmessage="Are you sure to Active this user? ID :<?php echo $colleague->clg_ref_id; ?>"> Activate</a></li>     
                                            <?php    }
                                            } ?>

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

                    <div class="width38 float_right">

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