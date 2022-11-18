<?php
$CI = EMS_Controller::get_instance();

//$CI = get_instance(); 

$user_info = $CI->session->userdata('current_user');

$current_user = $CI->session->userdata('current_user');


?>

<div class="container">
    <div class="row" style="background-color: #117864;" >
        <div class="col-md-1 align-items-left"> 
            <a href="#">
                <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="National Health Mission"  />
            </a>  
        </div>
        <div class="col-md-8 align-items-right" style="text-align: center"> 
            <label style="padding-top:10px;text-align: center;font-size:25px;color:#F4F6F7;">MP EMERGENCY MEDICAL SERVICES</label> 
        </div>
        <div class="col-md-3" style="padding-top:15px"> 
            <span style="padding-top:50px;color: #F4F6F7;font-size:15px;" class="clock" id='ct' > </span>
        </div>
        
        <!--<div class="col-md-1 align-items-right"> 
            <a href="#">
                    <img src="<?php echo base_url(); ?>assets/images/bvg_logo.png" alt="National Health Mission"  />
                </a>  
        </div>-->
    </div>
</div>
<!--<div id="popup_div">
</div>-->


<!---
    <div class="col-md-3 align-items-center">
        <div class="header__logo align-items-center">
        <a href="#">
            <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="J & K National Health Mission"  />
        </a>
        </div>
    </div>
    <div class="col-md-3 align-items-center">
    <label class="navbar-brand" href="#">Madhya Pradesh EMERGENCY MEDICAL SERVICES</label>
    </div>
    <div class="col-md-3">
        <div class="align-items-right text-right" >
            <span style="color: black;font-size:15px;" class="clock" id='ct' > </span>
        </div>
    </div>-->
    <!--<a id="open_74181851" class="logout_open head_logout_lnk" href="{base_url}Clg/logout" data-popup-ordinal="0"> <i class="fa fa-sign-out"></i> LOGOUT</a>-->
    <!---<div class="col-md-3 align-items-center">
        <div class="header__logo align-items-center">
        <a href="#">
            <img src="<?php echo base_url(); ?>assets/images/bvg_logo.png" alt="J & K National Health Mission"  />
        </a>
        </div>
    </div>
-->


<!---
<div id="custom_script"></div>

<div class="header_wrapper content_pan width100 float_left common_header">

    <div class="head float_left width100">

        <div class="content_wrapper margin_auto">

            <div class="outer_spero">
                <div class="header_left_block">

                    <div class="logo_content  float_left">

                        <div class="head_logo_img_wrapper width50 float_left">

                            <div class="head_logo"></div>

                        </div>

                    </div>

                </div>


                

            </div>
            
            <div class="header_right_block">
            
                <div class="profile_content float_left">

                 

                    <div class="profile_box">

                        <div class="head_prof_info float_right">
                        <span style="color: white;font-size:15px;" class="clock" id='ct'> </span>
                           

                            <a id="open_74181851" class="logout_open head_logout_lnk" href="{base_url}Clg/logout" data-popup-ordinal="0"> <i class="fa fa-sign-out"></i> LOGOUT</a>

                                                                       <a href="#" class="head_logout_lnk">LOGOUT</a>

                
                            <div class="float_right">
                                <div class="bvg_logo"></div>
                            </div>

                        </div>
                        

                        <label style="color: white;font-size:20px;">Madhya Pradesh EMERGENCY MEDICAL SERVICE</label>
                       
                    </div>

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

                        <a class="incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>

                       <?php if($current_user->clg_group == 'UG-ERO' || $current_user->clg_group == 'UG-ERO-102' || $current_user->clg_group == 'UG-ERO-HD'){?>
                        <a class="avaya_incoming_call_refresh click-xhttp-request" style="visibility: hidden;" data-href="{base_url}calls/avaya_get_incoming_calls" data-qr="module_name=calls&amp;showprocess=no">refresh</a>
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
-->
<script src="<?php echo base_url(); ?>assets/js/functions.js"></script> 