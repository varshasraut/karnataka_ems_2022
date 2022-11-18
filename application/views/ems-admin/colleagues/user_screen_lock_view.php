<?php

$CI = MS_Controller::get_instance();

$user_info = $CI->session->userdata('current_user');
        
$image_path = $CI->config->item('upload_path');


if($CI->session->userdata("screen_locked") == 1){     
    
    $lock = "lock_screen";
    
}else{
    
    $lock = '';
    
}

$pic_path = FCPATH.$image_path."/colleague_profile/".$user_info->clg_photo;


?>



<div class="lock_screen_page_container <?php echo $lock; ?>">
    
    <?php


    if(file_exists($pic_path)){
        
        $pic_path = base_url().$image_path."/colleague_profile/".$user_info->clg_photo;

        
    }else{
        
        $pic_path = base_url()."themes/backend/images/blank_profile_pic.png";

        
    }
    
?>
    <div class="lock_screen_outer_block">
        
        <div class="width1 screen_lock_login_box">
            
            <div class="box3">
                
                <form method="post" name="screen_lock_form" id="screen_lock_form_id">

                    <div class="right_corner_icon">

                        <input type="button" name="rt_corner_btn" value="" class="click-xhttp-request" data-href="{base_url}ms-admin/clg/changeUser" data-qr="output_position=success_check_div&amp;module_name=clg">

                    </div>
                    <div class="sl_main_content_box">

                        <div class="user_image_box">

                            <div class="user_image" style="background: url('<?php echo $pic_path;?>') no-repeat center center / cover;">

                            </div>

                        </div>

                        <div class="user_name_email_text_box">

                            <h2><?php echo $user_info->clg_first_name." ".$user_info->clg_last_name;?></h2>
                            <h4><span><?php echo $user_info->clg_email;?></span></h4>
                            <h4><span>LOCKED</span></h4>

                        </div>
                        
                        <div id="success_check_div">
                         
                        </div>

                        <div class="pwd_fields_box">

                            <div class="pwd_fields">
                                
                                 <div class="break_timer">
                                     <input type='text' id="break_timer_clock" value="" readonly="readonly" name="break_timer_clock"/>
                                 </div>

                                <input type="password" name="password" value="" class="sl_pwd_field_input" autocomplete="off" >

                                <div class="vert_line_div"></div>

                                <input type="button" name="submit_sl_pwd" value="" id="submit_lc_pwd_btn" class="form-xhttp-request" data-href="{base_url}ms-admin/Colleagues/authenticate_lc_pwd" data-qr="output_position=success_check_div&amp;module_name=colleagues&amp;ref_id=<?php echo$user_info->clg_ref_id; ?>">

                            </div>


                        </div>

                    </div>

                </form>
                
            </div>
            
        </div>
                
    </div>
    
</div>
