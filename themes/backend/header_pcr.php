<?php
$CI = EMS_Controller::get_instance();
//$CI = get_instance(); 
$user_info = $CI->session->userdata('current_user');
$current_user = $CI->session->userdata('current_user');

?>

<!--<div id="popup_div"></div>   -->
<div id="custom_script"></div>
<div class="header_wrapper content_pan width100 float_left ">
    <div class="head float_left width100">
        <div class="content_wrapper margin_auto">

            <div class="outer_spero">
                <!-- <div class="header_left_block">
                    <div class="logo_content  float_left">
                        <div class="head_logo_img_wrapper width50 float_left">
                            <div class="head_logo"></div>
                        </div>
                    </div>
                </div> -->


                <div id="section_title" class="logo_label float_left">
                <span style="float: left;"><img class="header_image" src="<?php echo base_url(); ?>assets/images/108_logo.png"></span>
                    <span>
                    <?php echo "IRTS | " ?>
                        <?php if($current_user->clg_group=='UG_ERO'){echo "ERO 108";}else if($current_user->clg_group=='UG-DCO'){echo "DCO";}else{echo (get_EMS_title($current_user->clg_group)) ? get_EMS_title($current_user->clg_group) : "DCO System"; }?>
                    </span>
                </div>
            </div>


            <div class="header_right_block">
                <div class="profile_content float_left">
                <div class="float_right width05" style="">
                            <span style="float: right;"><img class="header_image1" src="<?php echo base_url(); ?>assets/images/NHM.png">
</span>
                        </div>
                    <!-- <div class="login_icon_strip">
                        <ul class="login_icon">

                            <?php
                            $clg_data = get_clg_data_by_ref_id($user_info->clg_ref_id);
                            ///var_dump($clg_data[0]->clg_break_type);

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
                            <?php } if ($clg_data[0]->clg_break_type != 'BO') { ?>
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
                        </ul>
                    </div> -->
                    <?php if ($user_info->clg_group == 'UG-SuperAdmin' || $user_info->clg_group == 'UG-ERO'  || $user_info->clg_group == 'UG-ERO-102' || $user_info->clg_group == 'UG-DCO' || $user_info->clg_group == 'UG-ERCP' || $user_info->clg_group == 'UG-PDA' || $user_info->clg_group == 'UG-FDA' || $user_info->clg_group == 'UG-ShiftManager' || $user_info->clg_group == 'UG-DCO-102' || $user_info->clg_group == 'UG-RTM') { ?>

                        <div id="header_notice_reminder" style="right: 15%;
                             position: absolute;">           
                            <ul class="float_left">
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

                                                            <p class="float_left" style="color:white;">><?php echo substr(strip_tags($value->nr_notice), 0, 200); ?>><br><span style="color:white;" class="header_alert_time_span"> <?php echo date("d-m-Y H:i:s", strtotime($value->notice_exprity_date)); ?> </span></p>
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
                        <?php }
                        ?>
                    </div>
                    <div class="profile_box">
                        <div class="head_prof_info float_right width05" style="margin-top:-15px;">
                            <a id="open_74181851" class="logout_open head_logout_lnk float_right click-xhttp-request" data-href="{base_url}Clg/logout" data-popup-ordinal="0" data-qr="output_position=content"> <i class="fa fa-sign-out"></i></a>
                        </div>
                        <div class="head_prof_info float_right width15">

                            <span class="profile_user_name text_pan"> Welcome <?php echo $user_info->clg_first_name; ?></span>
                           
                           <!-- <div class="float_right">
                                <div class="bvg_logo"></div>
                            </div>-->

                        </div>
                        

                        <div class="float_right width75" style="margin-top:-5px">
                            <?php
//if ($CI->modules->get_tool_config('MT-PCRJC', 'M-PCRJC', $this->active_module, true) != '') {
//
//    if ($user_info->clg_group != 'UG-ADMIN') {
//        
                            ?>
                            <!--                            <a href="{base_url}job_closer/call_info" class="lnk_icon_btns call_lnk">Attend Call</a>-->
                            <?php
//                                }
//                            }
                            ?>
                            <?php if ($user_info->clg_group == 'UG-EMT' ) { ?>
                                <a href="{base_url}job_closer" data-qr="filters=reset" class="lnk_icon_btns dash_lnk click-xhttp-request" style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
<!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
<a class="lnk_icon_btns" style="margin-right:10px;background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                            <?php }elseif($user_info->clg_group == 'UG-COMPLIANCE'){
                                ?>
                                <a href="{base_url}grievance" data-qr="filters=reset&output_position=content" class="lnk_icon_btns dash_lnk click-xhttp-request" style="background-color: #9ED798 !important;"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
<!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
<a class="lnk_icon_btns" style="margin-right:10px; background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>

                                <a data-href="{base_url}grievance/search_grievance_call" data-qr="output_position=content&tool_code=mt_atnd_calls"  id="mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
                           
                                <?php
                            }else if($user_info->clg_group == 'UG-Quality'){?>
<!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
<a class="lnk_icon_btns" style="margin-right:10px;background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                            <?php } else if ($user_info->clg_group == 'UG-ERO' || $user_info->clg_group == 'UG-ERO-102' ) { ?>
                                <?php if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') {
                                    ?>
                                    <!--                                    <a data-href="{base_url}calls/atnd_cls" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request" id="mt_atnd_calls">Attend New Call</a>-->

                                <?php } ?>
<!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
<a class="lnk_icon_btns" style="margin-right:10px;background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk click-xhttp-request"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                                <a href="{base_url}calls" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-DCO' || $user_info->clg_group == 'UG-DCO-102') { ?>    
                                <!--<a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->                       
                                <!--                                 <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>
                                                                <a href="{base_url}job_closer" data-qr="filters=reset" class="lnk_icon_btns dash_lnk click-xhttp-request">Dashboard</a>-->

<!--                                <a data-href="{base_url}calls/single_record" data-qr="output_position=popup_div" class="lnk_icon_btns call_lnk click-xhttp-request">Single</a>-->
<a class="lnk_icon_btns" style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                                <a href="{base_url}job_closer" data-qr="filters=reset" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                                  <a href="{base_url}supervisor" data-qr="filters=reset" style="margin-right:10px;background-color: #F38C91 !important;"  class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dispatch.png">Dispatch Closure</a>

                            <?php }else if( $user_info->clg_group == 'UG-ERO-HD'){ ?>
                                <a href="{base_url}corona/corona_list" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>
                            <?php } else if ($user_info->clg_group == 'UG-ERCP') { ?>

                                <a data-href="{base_url}ercp/search_call" data-qr="output_position=content&tool_code=mt_atnd_calls" class="lnk_icon_btns call_lnk click-xhttp-request">Attend New Call</a>
                            <?php } else if ($user_info->clg_group == 'UG-RTM') { ?>    
                                <a class="lnk_icon_btns" style="background-color: #BCA1F2 !important;" href="#" onclick="open_extend_map('{base_url}calls/single_record');return false;" class="lnk_icon_btns call_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/search.png">Single</a>
                                <a href="{base_url}job_closer/rtm" data-qr="filters=reset" style="background-color: #9ED798 !important;" class="lnk_icon_btns dash_lnk"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/dashboard_icon.png">Dashboard</a>

                            <?php } ?>

                            <ul class="float_left">
                                <li class="dropdown">
                                    <a  class="lnk_icon_btns prof_lnk click-xhttp-request mar_right10" style="background-color: #43CFCE !important;" data-qr="ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/user.png">Profile</a>


                                    <ul class="dropdown-content">

                                        <?php if ($CI->modules->get_tool_config('MT-CLG-VIEW', 'M-UPRO', $this->active_module, true) != '') { ?>   

                                            <li class="drop-down-list">
                                                <a class="SMS click-xhttp-request" href="{base_url}Clg/edit_clg" data-qr="ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>" data-name="view_profile" data-popupwidth="900" data-popupheight="350">View Profile</a>
                                            </li>

                                            <?php
                                        }

                                        if ($CI->modules->get_tool_config('MT-CLG-EDIT', 'M-UPRO', $this->active_module, true) != '') {
                                            ?>   

                                            <li class="drop-down-list">
                                                <a class="billing_system click-xhttp-request" href="{base_url}Clg/edit_clg" data-qr="output_position=popup_div&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;prof=true&amp;action_type=Update&amp;clg_group=<?php echo $current_user->clg_group; ?>&amp;call=pcr" data-name="edit_profile" data-popupwidth="1000" data-popupheight="500">Edit Profile</a>
                                            </li>

                                            <?php
                                        }

                                        if ($CI->modules->get_tool_config('MT-CLG-PASSWORD', 'M-UPRO', $this->active_module, true) != '') {
                                            ?>

                                            <li class="drop-down-list">
                                                <a class="billing_system onpage_popup " href="{base_url}Clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;ref_id=<?php echo $current_user->clg_ref_id; ?>" data-popupwidth="480" data-popupheight="300" data-name="chng_pwd">Change Password</a>
                                            </li>

                                        <?php } ?>

                                    </ul>
                                </li>
                            </ul>

                            <?php if ($current_user->clg_group == 'UG-EMT') { ?>
                                <ul class="float_left">
                                    <li class="dropdown ind_drp">

                                        <a  class="lnk_icon_btns ind_lnk click-xhttp-request" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>">Indent</a>

                                        <ul class="dropdown-content">



                                            <?php if ($CI->modules->get_tool_config('MT-SND-IND-REQ', 'M-IND', $this->active_module, true) != '') { ?>   


                                                <li class="drop-down-list">

                                                    <a class="click-xhttp-request" href="{base_url}ind/req" data-qr="output_position=content">Indent Request</a>

                                                </li>
                                                <?php
                                            }

                                            if ($CI->modules->get_tool_config('MT-IND-REQ_LIST', 'M-IND', $this->active_module, true) != '') {
                                                ?>   



                                                <li class="drop-down-list">

                                                    <a class="billing_system click-xhttp-request" href="{base_url}ind/ind_list" data-qr="output_position=content&amp;filters=reset">List</a>

                                                </li>
                                                <?php
                                            }



                                            if ($CI->modules->get_tool_config('MT-PRV-IND-REQ', 'M-IND', $this->active_module, true) != '') {
                                                ?>



                                                <li class="drop-down-list">

                                                    <a class="billing_system onpage_popup " href="{base_url}Clg/get_pwd_user_details" data-qr="output_position=popup_div&amp;ref_id=<?php echo $current_user->clg_ref_id; ?>" data-name="">Previous Request</a>

                                                </li>



                                            <?php } ?>



                                        </ul>

                                    </li>
                                </ul>
                            <?php } ?>
                            <ul class="float_left">
                                <li class="dropdown ind_drp">

                                    <a class="lnk_icon_btns click-xhttp-request break_lnk" style="background-color: #FDA88B !important;" href="{base_url}Clg/clg_break" data-qr="output_position=popup_div" data-name="clg_break" data-popupwidth="500" data-popupheight="300"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/break.png">Break</a>

                                </li>
                            </ul>

                            <ul class="float_left">
                                <li class="dropdown ind_drp">

                                    <a class="lnk_icon_btns break_lnk onpage_popup" target="_blank" style="background-color: #9EBEF1 !important;" href="{base_url}amb/all_amb" data-qr="output_position=popup_div&showprocess=yes" data-name="clg_break" data-popupwidth="500" data-popupheight="300"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/map.png">Map</a>

                                </li>
                            </ul>
                            <ul class="float_left">
                                <li class="dropdown ind_drp">

                                    <a class="lnk_icon_btns break_lnk onpage_popup" href="{base_url}schedule_crud/view_crud_dash" style="background-color: #F69FD6 !important;" target="_blank" data-qr="output_position=popup_div&showprocess=yes&clg_ref_id=<?php echo $user_info->clg_ref_id; ?>" data-name="clg_break" data-popupwidth="1000" data-popupheight="800"><img class="dash_icon" src="<?php echo base_url(); ?>assets/images/schedule.png">Schedule</a>

                                </li>
                            </ul>

                                


                        </div>
                    </div>

                </div>
                <div class="" id="profile_view_popup_div">


                </div>
            </div>
            <?php
         
            if ($CI->modules->get_tool_config('MT-ATND-CALLS', 'M-CALLS', $this->active_module, true) != '') {
                if (is_avaya_active()) {
                    ?>
                    <div id="incoming_call_nav_outer">
                        <div class="top_bubble_box" id="incoming_call_nav">

                        </div>
                                                <?php if($current_user->clg_group == 'UG-PDA'){?>
                          <div class="top_bubble_box" id="pda_incoming_call_nav">

                        </div>
                        <?php } ?>

                        <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                             <?php if($current_user->clg_group == 'UG-ERO' || $current_user->clg_group == 'UG-ERO-102'){?>
                        <a class="avaya_incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/avaya_get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                             <?php } ?>
                        
                        
                                                  <?php if($current_user->clg_group == 'UG-PDA'){?>
                        <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/show_pda_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
                       <?php }?>
    

                    </div>
                <?php
                }
            }
            ?>
 <a class="keep_alive_button click-xhttp-request" style="visibility: hidden;" data-href="{base_url}clg/keep_alive_clg" data-qr="module_name=clg&amp;showprocess=no">refresh</a>
        </div>
    </div>

</div>


<div id="pcr_top_steps">{pcr_top_steps}
    <!-- This view load form view/pcr/pcr_top_steps_view.php-->
</div>



<div id="pcr_progressbar">{pcr_progressbar}

</div>


<style>
 
* {
font-family: sans-serif;
}



a.lnk_icon_btns {

border: 0px !important;
text-align: center;
border-radius: 10px !important;
padding: 5px 13px 5px 13px;
color: white !important;
font-weight: 600;
margin-left:5px;
}

.mar_right10 {
margin-right: 7px;
padding-top: 30px;

}





.hulbg {
background: #43cfce9e;
}
.header_image {
height: 52px;
width: 50px;
margin-top: -12px;
margin-left: -10px;
}
.header_image1 {
height: 52px;
width: 50px;
margin-top: 1px;
margin-left: -10px;
}



.mar {
margin-left: 5px;
}

.dash_icon{
height:12px;
padding-left:2px;
margin-right:3px;
}
.header_right_block {
    /* float: right; */
    width: 80%;
}
.width22{
    width:22%;
}
.width05{
    width:5%;
}
.width78{
    width:78%;
}
.logo_label{
    width:20%;
}
.head_logout_lnk {
        background-color: #2F419B !important;
        color:white !important;
    }
    .head_logout_lnk i {
        background-color: #2F419B !important;
        color:white !important;
        font-size:30px;
    }
    .header_wrapper .profile_content{
        padding-right:unset;
    }
    a.lnk_icon_btns{
        text-decoration: none !important;
    }
</style>
