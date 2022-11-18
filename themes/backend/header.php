<?php
$CI = EMS_Controller::get_instance();

//$CI = get_instance(); 

$user_info = $CI->session->userdata('current_user');

$current_user = $CI->session->userdata('current_user');

$ind_call = array('UG-ERCP');


?>

<!--<div id="popup_div"></div>   -->

<div id="custom_script"></div>

<div class="header_wrapper content_pan width100 float_left common_header">

    <div class="head float_left width100">

        <div class="content_wrapper margin_auto">

            <div class="outer_spero">
                <div class="header_left_block">

                    <div class="logo_content  float_left">

                        <div class="head_logo_img_wrapper width50 float_left">

                            <div class="head_logo_NHM"></div>   

                        </div>

                    </div>

                </div>


                <div id="section_title" class="logo_label float_left">

                    <span>

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
                        } else {
                            echo (get_EMS_title($current_user->clg_group)) ? get_EMS_title($current_user->clg_group) : "ERO System";
                        } ?>
                    </span>

                </div>

            </div>

            <div class="header_right_block">

                <div class="profile_content float_left">

                    <?php
                    if ($user_info->clg_group != 'UG-FLEET-SUGARFCTORY' || $user_info->clg_group != 'UG-FleetManagement' && $user_info->clg_group != 'UG-SupplyChainManage' && $user_info->clg_group != 'UG-BioMedicalManager') {
                    ?>
                        <!-- <div class="login_icon_strip ">
                            <ul class="login_icon">

                                <?php
                                $clg_data = get_clg_data_by_ref_id($user_info->clg_ref_id);

                                if ($clg_data[0]->clg_break_type == 'RD') {
                                ?>
                                    <li class="drop-down-list answer_icon_red">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=NR" title="Not Ready"></a>
                                    </li>
                                <?php } else if ($clg_data[0]->clg_break_type == 'NR') { ?>
                                    <li  class="drop-down-list answer_icon">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=RD" title="Ready"></a>
                                    </li>
                                <?php } else { ?>
                                    <li  class="drop-down-list answer_icon">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=RD" title="Ready"></a>
                                    </li>
                                <?php }
                                if ($clg_data[0]->clg_break_type != 'BO') { ?>
                                    <li class="drop-down-list busy_icon">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=BI" title="Break In"></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="drop-down-list answer_icon_red">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=BO" title="Break In"></a>
                                    </li>
                                <?php } ?>
                                <?php if ($clg_data[0]->clg_break_type != 'WI') { ?>
                                    <li class="drop-down-list clerical_work_red">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=WI" title="Wrap In"></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="drop-down-list clerical_work">
                                        <a class="click-xhttp-request" href="{base_url}Clg/save_action_break" data-qr="output_position=content&break_action=WO" title="Wrap Out"></a>
                                    </li>
                                <?php } ?>
                            </ul></div> -->
                    <?php } ?>
                    <?php if ($user_info->clg_group == 'UG-FOLLOWUPERO' || $user_info->clg_group == 'UG-EROSupervisor' || $user_info->clg_group == 'UG-BIKE-ERO' || $user_info->clg_group == 'UG-SuperAdmin' || $user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-DCO' || $user_info->clg_group == 'UG-ERCP' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-FDA' || $user_info->clg_group == 'UG-Quality' || $user_info->clg_group == 'UG-QualityManager'  || $user_info->clg_group == 'UG-ShiftManager') { ?>

                        <div id="header_notice_reminder" style="right: 12%;
                             position: absolute;">
                            <ul class="float_left">
                                <li class="dropdown alert_box">
                                    <a class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count"><?php echo notification_count(); ?></b> </a>
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

                        </div> <?php }
                                ?>
                    <?php if ($user_info->clg_group ==  'UG-BIKE-ERO' || $user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO' || $user_info->clg_group == 'UG-ERO-102') { ?>

                        <div id="header_ero_notice" style="right: 10%;
                             position: absolute;">
                            <ul class="float_left">
                                <li class="dropdown msg_box">
                                    <a class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count"><?php echo ero_notification_count(); ?></b> </a>
                                    <ul class="dropdown-content">
                                        <?php
                                        $notice_data = get_ero_notice();
                                        //var_dump($notice_data); die();

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

                        </div> <?php }
                                ?>

                    <div class="profile_box">

                        <div class="head_prof_info float_right">

                            <span class="profile_user_name text_pan">Welcome <?php echo ucwords($user_info->clg_first_name); ?></span>

                            <a id="open_74181851" class="logout_open bg_logout_open head_logout_lnk  click-xhttp-request" data-href="{base_url}Clg/logout" data-popup-ordinal="0" data-qr="output_position=content"> <i class="fa fa-sign-out"></i> LOGOUT</a>

                            <!--                                                <a href="#" class="head_logout_lnk">LOGOUT</a>

                            -->
                            <div class="float_right">
                                <div class="eme_logo"></div>
                            </div>

                        </div>
                        
                       

                        <div class="head_links float_right">

                            <!--                         <a href="{base_url}dash" class="lnk_icon_btns dash_lnk">Dashboard</a>-->

                            <?php
                            if ($CI->modules->get_tool_config('MT-PCRJC', 'M-PCRJC', $this->active_module, true) != '') {

                                if ($user_info->clg_group != 'UG-ADMIN') {
                            ?>
                                    <a href="{base_url}job_closer/call_info" class="lnk_icon_btns call_lnk">Attend Call</a>
                            <?php
                                }
                            }

                            ?>
                            <?php if ($user_info->clg_group == 'UG-EMT') { ?>
                                <a href="{base_url}pcr" class="lnk_icon_btns dash_lnk">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-Quality') { ?>
                                <!--                               <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" href="#" style="background-color: #BCA1F2 !important;" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                            <?php } else if ($user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO' ||  $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-REMOTE' || $user_info->clg_group == 'UG-BIKE-ERO' || $user_info->clg_group == 'UG-ERCTRAINING') { ?>
                                <?php // if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') { 
                                ?>
                                <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" id="mt_atnd_calls">Attend Call</a>
                                <?php //} 
                                ?>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a href="{base_url}calls" class="lnk_icon_btns dash_lnk">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-ERCP') { ?>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a data-href="{base_url}ercp/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
                                <a href="{base_url}ercp" class="lnk_icon_btns dash_lnk">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-DCO') { ?>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a href="{base_url}job_closer" data-qr="filters=reset" class="lnk_icon_btns dash_lnk click-xhttp-request">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-ShiftManager') { ?>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a href="{base_url}supervisor" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-ADMIN') { ?>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a href="{base_url}dash" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-PDA') { ?>


                                <a href="{base_url}police_calls" class="lnk_icon_btns dash_lnk">Dashboard</a>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a data-href="{base_url}police_calls/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" id="atnd_new_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
                            <?php } elseif ($user_info->clg_group == 'UG-COMPLIANCE') {
                            ?>
                                <a href="{base_url}grievance" data-qr="filters=reset&output_position=content" class="lnk_icon_btns dash_lnk click-xhttp-request">Dashboard</a>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>

                                <a data-href="{base_url}grievance/search_grievance_call" data-qr="output_position=content&tool_code=mt_atnd_calls" id="mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>

                            <?php
                            } else if ($user_info->clg_group == 'UG-FDA') {
                            ?>


                                <a href="{base_url}fire_calls" class="lnk_icon_btns dash_lnk">Dashboard</a>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                <a data-href="{base_url}fire_calls/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" id="atnd_new_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
                            <?php } else if ($user_info->clg_group == 'UG-Grievance' || $user_info->clg_group == 'UG-GrievianceManager') { ?>

                                <a href="{base_url}grievance" data-qr="filters=reset&output_position=content" class="lnk_icon_btns dash_lnk click-xhttp-request" style="background-color: #9ED798 !important;">Dashboard</a>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" style="background-color: #BCA1F2 !important;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>

                                <a data-href="{base_url}grievance/search_grievance_call" data-qr="output_position=content&tool_code=mt_atnd_calls" id="mt_atnd_calls"style="background-color: #F38C91 !important;" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
                            <?php } else if ($user_info->clg_group == 'UG-Feedback') { ?>


                                <!--                                <a href="{base_url}grievance" data-qr="filters=reset" class="lnk_icon_btns dash_lnk">Dashboard</a>-->

                                <a href="{base_url}feedback/feedback_list" style="background-color: #9ED798 !important;" data-qr="filters=reset&output_position=content" class="lnk_icon_btns dash_lnk click-xhttp-request">Dashboard</a>
                                <!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
                                <a class="lnk_icon_btns" style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>


                            <?php } else if ($user_info->clg_group == 'UG-ERO-HD') { ?>
                                <?php if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') { ?>
                                    <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" id="mt_atnd_calls">Attend Call</a>
                                <?php } ?>

                                <a href="{base_url}corona/corona_list" class="lnk_icon_btns dash_lnk">Dashboard</a>

                            <?php } else if ($user_info->clg_group == 'UG-FOLLOWUPERO') {
                            ?>
                                <?php if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') { ?>
                                    <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" id="mt_atnd_calls">Attend Call</a>
                                <?php } ?>

                                <a href="{base_url}corona/corona_list" class="lnk_icon_btns dash_lnk">Dashboard</a>

                            <?php
                            } else { ?>
                                <a href="{base_url}dash" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk">Dashboard</a>
                            <?php } ?>
                            <ul class="float_left">
                                <li class="dropdown">
                                    <a class="lnk_icon_btns prof_lnk click-xhttp-request" style="background-color: #43CFCE !important;" data-qr="ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true" >Profile</a>
                                    <ul class="dropdown-content">
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
                                    <a class="lnk_icon_btns click-xhttp-request break_lnk" href="{base_url}Clg/clg_break" data-qr="output_position=popup_div" style="background-color: #FDA88B !important;" data-name="clg_break" data-popupwidth="500" data-popupheight="300">Break</a>
                                </li>
                            </ul>
                            <?php if ($user_info->clg_group != 'UG-REMOTE') { ?>
                                <ul class="float_left">
                                    <li class="dropdown ind_drp">

                                        <a class="lnk_icon_btns break_lnk onpage_popup" href="{base_url}amb/all_amb" target="_blank" data-qr="output_position=popup_div&showprocess=yes" style="background-color: #9EBEF1 !important;" data-name="clg_break" data-popupwidth="1000" data-popupheight="800">Map</a>

                                    </li>
                                </ul>
                                <ul class="float_left">
                                    <li class="dropdown ind_drp">

                                        <a class="lnk_icon_btns break_lnk onpage_popup" href="{base_url}schedule_crud/view_crud_dash" target="_blank" style="background-color: #F69FD6 !important;" data-qr="output_position=popup_div&showprocess=yes&clg_ref_id=<?php echo $user_info->clg_ref_id; ?>" data-name="clg_break" data-popupwidth="1000" data-popupheight="800">Schedule</a>

                                    </li>
                                </ul>
                            <?php } ?>
                            <?php if ($user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO' || $user_info->clg_group == 'UG-Quality' || $user_info->clg_group == 'UG-QualityManager' || $user_info->clg_group == 'UG-EROSupervisor' || $user_info->clg_group == 'UG-ShiftManager' || $user_info->clg_group == 'UG-ERCTRAINING' || $user_info->clg_group == 'UG-Grievance' || $user_info->clg_group == 'UG-GrievianceManager' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-BIKE-ERO') {
                            ?>
                                <ul class="float_left">
                                    <li class="dropdown ind_drp">

                                        <!--                                        <a data-href="{base_url}calls/caller_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Caller History</a>-->
                                        <a class="lnk_icon_btns" style=" background-color: #8786FB !important;" href="#" onclick="open_extend_map('{base_url}calls/caller_record');return false;" class="lnk_icon_btns call_lnk">Caller History</a>

                                    </li>
                                </ul>
                            <?php } ?>


                            <?php if ($user_info->clg_group == 'UG-ShiftManager' || $user_info->clg_group == 'UG-Supervisor') {
                            ?>
                                <a class="lnk_icon_btns onpage_popup break_lnk" href="{base_url}Clg/clg_supervisor_notice" style="background-color: #d86262 !important;" data-qr="output_position=popup_div" data-name="clg_break" data-popupwidth="400" data-popupheight="350">Notice</a>

                            <?php } elseif ($user_info->clg_group == 'UG-SuperAdmin' || $user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-DCO' || $user_info->clg_group == 'UG-ERCP' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-FDA' || $user_info->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO') {
                            ?>
                                <!--                                <a class="lnk_icon_btns onpage_popup break_lnk" href="{base_url}Clg/get_notice" data-qr="output_position=popup_div" data-name="clg_break" data-popupwidth="400" data-popupheight="300"><b style="color:red;"><?php echo notification_count(); ?></b> Notice/Remainder</a>-->
                                <!--
                                                                <ul class="float_right">
                                                                    <li class="dropdown alert_box">
                                                                        <a  class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count"><?php echo notification_count(); ?></b> </a>
                                                                        <ul class="dropdown-content">
                                <?php
                                $notice_data = get_clg_notice();

                                foreach ($notice_data as $value) {
                                    if (date('Y-m-d H:i:s') <= date("Y-m-d H:i:s", strtotime($value->notice_exprity_date))) {
                                ?>
                                                                                                                                                                                    <li class="drop-down-list">
                                                                                                                                                                                        <a class="pSMS onpage_popup " href="{base_url}Clg/get_notice" data-qr="output_position=popup_div&amp;nr_id=<?php echo $value->nr_id; ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>&amp;" data-name="view_profile" data-popupwidth="400" data-popupheight="300">
                                                                                                                                                                                            <div class="alert_wrapper float_left">
                                                                                                                                
                                                                                                                                                                                                <p class="float_left" style="color:white;"><?php echo substr($value->nr_notice, 0, 50); ?><br><span style="color:white;" class="header_alert_time_span"> <?php echo date("d-m-Y H:i:s", strtotime($value->notice_exprity_date)); ?> </span></p>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </a>
                                                                                                                                                                                    </li>
                                        <?php
                                    }
                                }
                                        ?> 
                                
                                                                        </ul>
                                
                                                                    </li>
                                                                </ul>-->
                            <?php }
                            ?>
                        </div>
                        

                    </div>
                    

                </div>

                <div class="" id="profile_view_popup_div">

                </div>

                <!--  <ul class="top_left_menu">

                    <li class="user_menu_box"> <a href="#" class="user_menu"><span class="black_down_arrow"></span></a>

                      <div class="first_box_dropdown top_navigation_dropdown_user">

                      <ul class="user_list" id="user_block_scroll">

                          <li><a class="onpage_popup" data-href="{base_url}Clg/profile" data-qr="output_position=profile_view_popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-UPDATE&amp;ref_id=<?= $current_user->clg_ref_id ?>&amp;action=view_profile"  data-popupwidth="900" data-popupheight="850" > <i class="fa fa-user"></i> My Profile </a> </li>

                          <li class="divider">&nbsp;</li>

                          <li><a href="#"> <i class="fa fa-gear"></i> Settings </a> </li>

                          <li><a href="#" id="lock_screen_btn" class="click-xhttp-request"><i class="fa fa-sign-out"></i>Lock Screen</a></li>

                          <li> <a id="open_74181851" class="logout_open" href="{base_url}Clg/logout" data-popup-ordinal="0"> <i class="fa fa-sign-out"></i> Logout</a> </li>

                        </ul>

                      </div>

                    </li>

                  </ul>-->

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

                        <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>

                        <?php if ($current_user->clg_group == 'UG-ERO' || $current_user->clg_group == 'UG-BIKE-ERO' || $current_user->clg_group == 'UG-ERO-HD') { ?>
                            <a class="show_photo_notification click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/show_photo_notification" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>

                        <?php if ($current_user->clg_group == 'UG-ERO' || $current_user->clg_group == 'UG-ERO-102' || $current_user->clg_group == 'UG-ERO-HD' || $user_info->clg_group == 'UG-FOLLOWUPERO') { ?>
                            <a class="avaya_incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/avaya_get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>
                        <?php if ($current_user->clg_group == 'UG-PDA') { ?>
                            <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/show_pda_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                        <?php } ?>


                    </div>


            <?php
                }
            }
            ?>
            <a class="keep_alive_button click-xhttp-request" style="visibility: hidden;" data-href="{base_url}clg/keep_alive_clg" data-qr="module_name=clg&amp;showprocess=no">refresh</a>

        </div>

    </div>

</div>

<style>
    a.lnk_icon_btns {

border: 0px !important;
text-align: center;
border-radius: 10px !important;
padding: 5px 13px 5px 13px;
color: white !important;
font-weight: 600;
margin-left:5px;
}

.head_logo_NHM {
    width: 132px;
    height: 52px;
    background: url('{base_url}assets/images/108_logo.png')no-repeat;
    background-size: 100% 100%;
    background-size: contain;
    margin-top: 1px;

}

 .eme_logo{
    width:100px;
    height:52px;
    background:url('{base_url}assets/images/NHM.png') no-repeat;
    background-size:contain;
    margin-right: -97px;
    margin-top: -19px;
    margin-left: 10px;
}

.bg_clr1{
    background-color: #43CFCE !important;
}
.bg_clr2{
    background-color: #FDA88B !important;

}
.bg_clr3{
    background-color: #9EBEF1 !important;
}
.bg_clr4{
    background-color: #F69FD6 !important;

}
.bg_clr5{
    background-color: #8786FB !important;

}
.bg_clr6{
    background-color: #F38C91 !important;

}
.bg_clr7{
    background-color: #BCA1F2 !important;

}
.bg_clr8{
    background-color: #9ED798 !important;
   
}
.bg_clr8{
    background-color: #d86262 !important;
}
</style>