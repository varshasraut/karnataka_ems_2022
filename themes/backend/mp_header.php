<?php
$CI = EMS_Controller::get_instance();

//$CI = get_instance(); 

$user_info = $CI->session->userdata('current_user');

$current_user = $CI->session->userdata('current_user');
$ind_call = array('UG-ERCP');


?>
<div id="custom_script"></div>
<div class="row m-0 pr-1 common_header">

    <div class="col-md-2">
        <div class="logo_label4 float_left">
            <span style="float: left;"><img class="header_image" src="<?php echo base_url(); ?>assets/images/108_logo.png"></span>
        </div>
        <?php if ($user_info->clg_group != 'UG-FOLLOWUPERO') { ?>
            <div id="section_title" class="logo_label2 float_left">

                <span class="mar">


                    <?php echo "IRTS | " ?>
                    <?php
                    if ($current_user->clg_group == 'UG-ERCP') {
                        echo "ERCP";
                    } elseif ($current_user->clg_group == 'UG-ERO') {
                        echo "ERO 108";
                    }
                    elseif ($current_user->clg_group == 'UG-ERCP-104') {
                        echo "ERCP 104";
                    } elseif ($current_user->clg_group == 'UG-ERO-HD') {
                        echo "ERO HD";
                    } elseif ($current_user->clg_group == 'UG-BIKE-ERO') {
                        echo "ERO Bike";
                    } elseif ($current_user->clg_group == 'UG-FOLLOWUPERO') {
                        echo "FOLLOWUP ERO";
                    }  elseif ($current_user->clg_group == 'UG-ERO-104') {
                        echo "Paramedic 104";
                    }else {
                        echo (get_EMS_title($current_user->clg_group)) ? get_EMS_title($current_user->clg_group) : "ERO System";
                    } ?>
                </span><br>

                <span class="logo_label3 profile_user_name text_pan mar">Welcome <?php echo ucwords($user_info->clg_first_name); ?></span>


            </div>
        <?php } else { ?>

            <div id="section_title" class="logo_label5 float_left">

                <span class="mar">


                    <?php echo "IRTS | " ?>
                    <?php
                    if ($current_user->clg_group == 'UG-ERCP') {
                        echo "ERCP";
                    } elseif ($current_user->clg_group == 'UG-ERO') {
                        echo "ERO 108";
                    } elseif ($current_user->clg_group == 'UG-ERO-HD') {
                        echo "ERO HD";
                    } elseif ($current_user->clg_group == 'UG-BIKE-ERO') {
                        echo "ERO Bike";
                    } elseif ($current_user->clg_group == 'UG-FOLLOWUPERO') {
                        echo "FOLLOWUP ERO";
                    } elseif ($current_user->clg_group == 'UG-ERO-104') {
                        echo "ERO 108";
                    }else {
                        echo (get_EMS_title($current_user->clg_group)) ? get_EMS_title($current_user->clg_group) : "ERO System";
                    } ?>
                </span><br>

                <span class="logo_label3 profile_user_name text_pan mar">Welcome <?php echo ucwords($user_info->clg_first_name); ?></span>


            </div>
        <?php }  ?>

    </div>
    <div class="col-md-8" style="text-align: center;padding:8px 0px 0px 0px;">
        <div class="head_links float_right mt-2">

            <!--                         <a href="{base_url}dash" class="lnk_icon_btns dash_lnk">Dashboard</a>-->

            <?php
            if ($CI->modules->get_tool_config('MT-PCRJC', 'M-PCRJC', $this->active_module, true) != '') {

                if ($user_info->clg_group != 'UG-ADMIN') {
            ?>
                    <a href="{base_url}job_closer/call_info" class="lnk_icon_btns call_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend Call</a>
            <?php
                }
            }

            ?>
            <?php if ($user_info->clg_group == 'UG-EMT') { ?>
                <a href="{base_url}pcr" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } else if ($user_info->clg_group == 'UG-Quality') { ?>
                <!--                               <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
            <?php } else if ($user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-104' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO' ||  $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-REMOTE' || $user_info->clg_group == 'UG-BIKE-ERO' || $user_info->clg_group == 'UG-ERCTRAINING') { ?>
                <?php // if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') { 
                ?>
                <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request Attend Call mar_right10" style="background-color: #F38C91 !important;" id="mt_atnd_calls"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend Call</a>
                <?php //} 
                ?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="margin-right:2px; background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request "><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a href="{base_url}calls" class="lnk_icon_btns dash_lnk " style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } else if ($user_info->clg_group == 'UG-ERCP') { ?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a data-href="{base_url}ercp/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" style="background-color: #F38C91 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend New Call</a>
                <a href="{base_url}ercp" class="lnk_icon_btns dash_lnk" style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                <?php } else if ($user_info->clg_group == 'UG-COUNSELOR-104') {?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a data-href="{base_url}ercp/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" style="background-color: #F38C91 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend New Call</a>
                <a href="{base_url}counselor104" class="lnk_icon_btns dash_lnk" style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php }else if ($user_info->clg_group == 'UG-ERCP-104') {?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a data-href="{base_url}ercp/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" style="background-color: #F38C91 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend New Call</a>
                <a href="{base_url}ercp104" class="lnk_icon_btns dash_lnk" style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } else if ($user_info->clg_group == 'UG-DCO') { ?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="margin-right:10px;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a href="{base_url}job_closer" data-qr="filters=reset" class="lnk_icon_btns dash_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } else if ($user_info->clg_group == 'UG-ShiftManager') { ?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="margin-right:10px;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a href="{base_url}supervisor" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } else if ($user_info->clg_group == 'UG-ADMIN') { ?>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a href="{base_url}dash" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } else if ($user_info->clg_group == 'UG-PDA') { ?>


                <a href="{base_url}police_calls" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a data-href="{base_url}police_calls/search_call" style="background-color: #F38C91 !important;" data-qr="output_position=content&tool_code=mt_atnd_calls" id="atnd_new_calls" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend New Call</a>
            <?php } elseif ($user_info->clg_group == 'UG-COMPLIANCE') {
            ?>
                <a href="{base_url}grievance" data-qr="filters=reset&output_position=content" class="lnk_icon_btns dash_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>

                <a data-href="{base_url}grievance/search_grievance_call" data-qr="output_position=content&tool_code=mt_atnd_calls" id="mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>

            <?php
            } else if ($user_info->clg_group == 'UG-FDA') {
            ?>


                <a href="{base_url}fire_calls" class="lnk_icon_btns dash_lnk" style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                <a data-href="{base_url}fire_calls/search_call" style="background-color: #F38C91 !important;" data-qr="output_position=content&tool_code=mt_atnd_calls" id="atnd_new_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
            <?php } else if ($user_info->clg_group == 'UG-Grievance' || $user_info->clg_group == 'UG-GrievianceManager') { ?>

                <a href="{base_url}grievance" data-qr="filters=reset&output_position=content" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a href="#" style="background-color: #BCA1F2 !important;" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>

                <a data-href="{base_url}grievance/search_grievance_call" style="background-color: #F38C91 !important;" data-qr="output_position=content&tool_code=mt_atnd_calls" id="mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend New Call</a>
            <?php } else if ($user_info->clg_group == 'UG-Feedback') { ?>


                <!--                                <a href="{base_url}grievance" data-qr="filters=reset" class="lnk_icon_btns dash_lnk">Dashboard</a>-->

                <a href="{base_url}feedback/feedback_list" style="background-color: #9ED798 !important;" data-qr="filters=reset&output_position=content" class="lnk_icon_btns dash_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                <a style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>


            <?php } else if ($user_info->clg_group == 'UG-ERO-HD') { ?>
                <?php if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') { ?>
                    <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request " id="mt_atnd_calls"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/attend_call.png">Attend Call</a>
                <?php } ?>

                <a href="{base_url}corona/corona_list" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>

            <?php } else if ($user_info->clg_group == 'UG-FOLLOWUPERO') {
            ?>
                <?php if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') { ?>
                    <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request " id="mt_atnd_calls">Attend Call</a>
                <?php } ?>

                <a href="{base_url}corona/corona_list" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>

            <?php
            } else { ?>
                <a href="{base_url}dash" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
            <?php } ?>
            <ul class="float_left">
                <li class="dropdown">
                    <a class="lnk_icon_btns prof_lnk click-xhttp-request mar_right10 profiletab" style="background-color: #43CFCE !important;" data-qr="ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/user.png">Profile</a>
                    <ul class="dropdown-content hulbg">
                        <?php if ($CI->modules->get_tool_config('MT-CLG-VIEW', 'M-UPRO', $this->active_module, true) != '') { ?>
                            <li class="drop-down-list">
                                <a class="pSMS click-xhttp-request " href="{base_url}Clg/edit_clg" data-qr="ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>" data-name="view_profile" data-popupwidth="1000" data-popupheight="350">View Profile</a>
                            </li>
                        <?php
                        }

                        if ($CI->modules->get_tool_config('MT-CLG-EDIT', 'M-UPRO', $this->active_module, true) != '') {
                        ?>

                            <li class="drop-down-list">

                                <a class="billing_system click-xhttp-request " href="{base_url}Clg/edit_clg" data-qr="output_position=popup_div&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;prof=true&amp;action_type=Update&amp;clg_group=<?php echo $current_user->clg_group; ?>" data-name="edit_profile" data-popupwidth="1000" data-popupheight="500">Edit Profile</a>

                            </li>

                        <?php
                        }

                        if ($CI->modules->get_tool_config('MT-CLG-PASSWORD', 'M-UPRO', $this->active_module, true) != '') {
                        ?>

                            <li class="drop-down-list">

                                <a class="billing_system onpage_popup " href="{base_url}Clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;ref_id=<?php echo $current_user->clg_ref_id; ?>" data-popupwidth="480" data-popupheight="320" data-name="chng_pwd">Change Password</a>

                            </li>

                        <?php } ?>

                    </ul>

                </li>
            </ul>
            <!--<a id="refresh_button" class="lnk_icon_btns refresh_lnk" onClick="window.location.reload()">Refresh</a>-->

            <ul class="float_left">
                <li class="dropdown ind_drp">
                    <a class="lnk_icon_btns click-xhttp-request break_lnk mar_right10" href="{base_url}Clg/clg_break" style="background-color: #FDA88B !important;" data-qr="output_position=popup_div" data-name="clg_break" data-popupwidth="500" data-popupheight="300"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/break.png">Break</a>
                </li>
            </ul>
            <?php if ($user_info->clg_group != 'UG-REMOTE' ) { ?>
                <?php if ($user_info->clg_group != 'UG-ERO-104' ) { ?>
                <ul class="float_left">
                    <li class="dropdown ind_drp">

                        <a class="lnk_icon_btns break_lnk onpage_popup mar_right10" href="{base_url}amb/all_amb" style="background-color: #9EBEF1 !important;" target="_blank" data-qr="output_position=popup_div&showprocess=yes" data-name="clg_break" data-popupwidth="1000" data-popupheight="800"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/map.png">Map</a>

                    </li>
                </ul>
                <?php } ?>
                <ul class="float_left">
                    <li class="dropdown ind_drp">

                        <a class="lnk_icon_btns break_lnk onpage_popup mar_right10" style="background-color: #F69FD6 !important;" href="{base_url}schedule_crud/view_crud_dash" target="_blank" data-qr="output_position=popup_div&showprocess=yes&clg_ref_id=<?php echo $user_info->clg_ref_id; ?>" data-name="clg_break" data-popupwidth="1000" data-popupheight="800"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/schedule.png">Schedule</a>

                    </li>
                </ul>
            <?php } ?>
            <?php if ($user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-104' || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO' || $user_info->clg_group == 'UG-Quality' || $user_info->clg_group == 'UG-QualityManager' || $user_info->clg_group == 'UG-EROSupervisor' || $user_info->clg_group == 'UG-ShiftManager' || $user_info->clg_group == 'UG-ERCTRAINING' || $user_info->clg_group == 'UG-Grievance' || $user_info->clg_group == 'UG-GrievianceManager' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-BIKE-ERO') {
            ?>
                <ul class="float_left">
                    <li class="dropdown ind_drp">

                        <!--                                        <a data-href="{base_url}calls/caller_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Caller History</a>-->
                        <a class="lnk_icon_btns mar_right10" href="#" style="background-color: #8786FB !important;" onclick="open_extend_map('{base_url}calls/caller_record');return false;" class="lnk_icon_btns call_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/call.png">Caller History</a>

                    </li>
                </ul>
            <?php } ?>


            <?php if ($user_info->clg_group == 'UG-ShiftManager' || $user_info->clg_group == 'UG-Supervisor') {
            ?>
                <a class="lnk_icon_btns onpage_popup break_lnk" href="{base_url}Clg/clg_supervisor_notice" data-qr="output_position=popup_div" data-name="clg_break" data-popupwidth="400" data-popupheight="350">Notice/Reminder</a>

            <?php } elseif ($user_info->clg_group == 'UG-SuperAdmin' || $user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-104' || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-DCO' || $user_info->clg_group == 'UG-ERCP' ||$user_info->clg_group == 'UG-ERCP-104' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-FDA' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO') {
            ?>

            <?php }
            ?>
        </div>
    </div>
    <div class="col-md-1 p-0">
        <div class="mt-2">
            <div class="align-items-center">

                <div class="profile_content float_left">
                    <?php if ($user_info->clg_group == 'UG-FOLLOWUPERO' || $user_info->clg_group == 'UG-EROSupervisor' || $user_info->clg_group == 'UG-BIKE-ERO' || $user_info->clg_group == 'UG-SuperAdmin' || $user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-104' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-DCO' || $user_info->clg_group == 'UG-ERCP' || $user_info->clg_group == 'UG-ERCP-104' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-FDA' || $user_info->clg_group == 'UG-Quality' || $user_info->clg_group == 'UG-QualityManager'  || $user_info->clg_group == 'UG-ShiftManager') { ?>

                        <div id="header_notice_reminder" style="margin-top:5px;margin-left:5px;position: absolute;">
                            <ul class="float_left">
                                <li class="dropdown alert_box">
                                    <a class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count hcalign"><?php echo notification_count(); ?></b> </a>
                                    <ul class="dropdown-content">
                                        <?php
                                        $notice_data = get_clg_notice();

                                        foreach ($notice_data as $value) {
                                            if (date('Y-m-d H:i:s') <= date("Y-m-d H:i:s", strtotime($value->notice_exprity_date))) {
                                        ?>
                                                <li class="drop-down-list">
                                                    <a class="pSMS onpage_popup " href="{base_url}Clg/get_notice" data-qr="output_position=popup_div&amp;nr_id=<?php echo $value->nr_id; ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>&amp;" data-name="view_profile" data-popupwidth="400" data-popupheight="300">
                                                        <div class="alert_wrapper float_left">

                                                            <p class="float_left" style="color:white;"><?php echo substr(strip_tags($value->nr_notice), 0, 200); ?><br><span style="color:white;" class="header_alert_time_span"> <?php //echo date("d-m-Y H:i:s", strtotime($value->notice_exprity_date)); 
                                                                                                                                                                                                                                    ?> </span></p>
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </ul>

                                </li>
                            </ul>

                        </div>
                    <?php }
                    ?>
                    <?php if ($user_info->clg_group ==  'UG-BIKE-ERO' || $user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-104' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO' || $user_info->clg_group == 'UG-ERO-102') { ?>

                        <div id="header_ero_notice" style="margin-left:70px; margin-top:5px;position: absolute;">
                            <ul class="float_left">
                                <li class="dropdown msg_box">
                                    <a class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count"><?php echo ero_notification_count(); ?></b> </a>
                                    <ul class="dropdown-content">
                                        <?php
                                        $notice_data = get_ero_notice();
                                        foreach ($notice_data as $value) {
                                            if (date('Y-m-d') == date("Y-m-d", strtotime($value->er_notice_date))) {
                                        ?>
                                                <li class="drop-down-list">
                                                    <a class="pSMS onpage_popup " href="{base_url}quality_forms/get_notice_ero_view" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>&amp;" data-name="view_profile" data-popupwidth="400" data-popupheight="300">
                                                        <div class="alert_wrapper float_left">
                                                            <p class="float_left" style="color:white;">
                                                                <?php if ($value->er_notice != '') { ?>
                                                                    <?php echo substr($value->er_notice, 0, 500); ?><br><span style="color:white;" class="header_alert_time_span">
                                                                        <?php //echo date("d-m-Y H:i:s", strtotime($value->er_notice_date)); 
                                                                        ?> </span>
                                                                <?php } else if ($value->inc_ref_id != ' ') { ?>
                                                                    <span style="color:white;" class="header_alert_time_span">
                                                                        Inc ref Id : <?php echo $value->inc_ref_id; ?> </span><br>
                                                                    <span style="color:white;" class="header_alert_time_span">
                                                                        Remark : <?php echo $value->er_remark; ?> </span><br>
                                                                    <span style="color:white;" class="header_alert_time_span">
                                                                        Quality Score : <?php echo $value->quality_score; ?>
                                                                    </span>
                                                                    <span style="color:white;" class="header_alert_time_span">
                                                                        Datetime : <?php echo $value->er_notice_date; ?>
                                                                    </span>
                                                                <?php } ?>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </ul>

                                </li>
                            </ul>
                        </div>
                    <?php }
                    ?>
                   

                </div>

                <div class="" id="profile_view_popup_div">
                </div>
            </div>

            <?php

            if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') {
                  
                if (is_avaya_active() || in_array($current_user->clg_group, $ind_call)) {
            ?>

                    <div id="incoming_call_nav_outer">

                        <div class="top_bubble_box" id="incoming_call_nav">

                        </div>
                        <?php if ($current_user->clg_group == 'UG-PDA') { ?>
                            <div class="top_bubble_box" id="pda_incoming_call_nav">

                            </div>
                        <?php } ?>
                        <?php if($user_info->clg_group != 'UG-COUNSELOR-104'){ ?>
                        <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                            <?php } ?>
                        <?php if ($current_user->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-104' || $current_user->clg_group == 'UG-BIKE-ERO' || $current_user->clg_group == 'UG-ERO-HD') { ?>
                            <a class="show_photo_notification click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/show_photo_notification" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>

                        <?php if ($current_user->clg_group == 'UG-ERO'  || $user_info->clg_group == 'UG-ERO-104' || $current_user->clg_group == 'UG-ERO-102' || $current_user->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO') { ?>
                            <a class="avaya_incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/avaya_get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>
                        <?php if ($current_user->clg_group == 'UG-PDA') { ?>
                            <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/show_pda_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>
                        <?php if ($user_info->clg_group == 'UG-COUNSELOR-104') { ?>
                            <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/show_counslor_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>


                    </div>


            <?php
                }
            }
            ?>
            <a class="keep_alive_button click-xhttp-request" style="visibility: hidden;" data-href="{base_url}clg/keep_alive_clg" data-qr="module_name=clg&amp;showprocess=no">refresh</a>

        </div>

    </div>

<div class="col-md-1 p-0">

    <div class="head_prof_info float_right">
        <a id="open_74181851" alt="Logout" class="logout_open click-xhttp-request" data-href="{base_url}Clg/logout" data-popup-ordinal="0" data-qr="output_position=content"><i class="fa fa-sign-out pt-2" alt="Logout" style="font-size:35px;color:white;padding-top:5px;" data-toggle="tooltip" data-placement="top" title="Logout"></i></a>

        <img class="header_image1" src="<?php echo base_url(); ?>assets/images/NHM.png">

    </div>

</div>

</div>
<style>
    .head_logout_lnk {
        background-color: none !important;

    }

    .mahaimg3 {
        margin-top: 10px;
        padding: 5px !important;
        height: 15vh !important;
    }

    .hcalign {
        margin: 1px 69px 0px 4px !important;
    }

    #container .alert_box {
        padding: 56px 87px 0px 5px !important;
    }

    .nopadding {
        padding: 0 !important;
        margin: 0 !important;
    }

    #headermb2 {
        display: flex;
        align-content: stretch;
        justify-content: space-between;
    }

    @media screen and (max-width: 500px) {
        #headermain {

            display: none !important;

        }
    }

    @media screen and (min-width: 500px) {
        #headermb {

            display: none !important;

        }
    }

    .pcr_contentpan {
        background-color: #F3F1F1 !important;
        height: auto !important;
    }

    .brg_clr6 {
        background-color: #2F419B;
    }

    .logo_label2 span {
        padding-left: 16px;
        font-size: 14px;
        font-weight: 600;
        color: #FFFFFF;
    }

    .logo_label4 span {
        padding-top: 12px;
        font-size: 18px;
        font-weight: 600;
        color: #FFFFFF;
    }

    .logo_label3 {
        font-size: 12px !important;
        font-weight: bold !important;
        color: #FFFFFF !important;

    }

    .logo_label2 {
        margin-top: 0px;
        padding: 2px 2% 13px 0px;
        width: auto;
        height: 52px;
        text-align: center;
    }

    .logo_label5 {
        margin-top: 3px;
        padding: 2px 2% 13px 0px;
        width: auto;
        height: 52px;
        text-align: center;
    }

    * {
        font-family: sans-serif;
    }

    .ul,
    .li,
    .a {
        border-bottom: 0px !important;

    }

    .header {
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.25);

    }

    a.lnk_icon_btns {

        border: 0px !important;
        text-align: center;
        border-radius: 10px !important;
        padding: 5px 13px 5px 13px;
        color: white !important;
        font-weight: 600;
    }

    .mar_right10 {
        margin-right: 7px;
        padding-top: 30px;

    }

    .lblclr2 {
        color: white;
        text-align: center;
    }

    .header {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;

    }

    a {
        text-decoration: none !important;
    }

    .hulbg {
        background: #43cfce9e;
    }

    .header_image {
        height: 55px;
        width: 52px;
        margin-top: -11px;
        margin-left: -10px;
    }

    .logo_label2 span {
        padding-left: 1px !important;
        font-size: 14px;
        font-weight: 600;
        color: #FFFFFF;
    }

    .logo_label5 span {
        padding-left: 1px !important;
        font-size: 12px;
        font-weight: 600;
        color: #FFFFFF;
    }


    .mar {
        margin-left: 5px;
    }

    .dash_icon {
        height: 12px;
        padding-left: 2px;
        margin-right: 5px;
    }

    .header_image1 {
        height: 55px;
        width: 52px;
        margin-top: -10px;
    }

    .dropdown-content {
        border-bottom: 0px !important;
    }
</style>