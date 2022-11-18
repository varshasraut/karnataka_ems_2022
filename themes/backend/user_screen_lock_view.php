<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$CI = EMS_Controller::get_instance();

$user_info = $CI->session->userdata('current_user');
        
$image_path = $CI->config->item('upload_path');
$break_type= $CI->session->userdata('break_type');

$break_type_name = $CI->session->userdata('break_type_name');


if($CI->session->userdata("screen_locked") == 1){
    
    $lock = "lock_screen";
    
}else{
    
    $lock = '';
    
}

$pic_path = FCPATH.$image_path."/colleague_profile/".$user_info->clg_photo;


?>

<div class="lock_screen_page_container <?php echo $lock; ?>">
    
    <?php
    
//    var_dump($pic_path);


    if(file_exists($pic_path)){
        
        $pic_path = base_url().$image_path."/colleague_profile/".$user_info->clg_photo;
//        echo"exists";
        
    }else{
        
        $pic_path = base_url()."themes/backend/images/blank_profile_pic.png";
//        echo "not exist";
        
    }
    
//    var_dump($pic_path);

    $dispatch_time =  $CI->session->userdata('break_time'); 
    $cuttent_time =  time(); 
   
 
    
  ?>  

    <div class="lock_screen_outer_block">
        
        <div class="width1 screen_lock_login_box">
            
            <div class="box3 box3_wrapper_div" style="display: block; visibility: visible; top: 196px; left: 50%; position: absolute; height: 368px; width: 586px; transform:translate(-50%,-50%)">
                
                <form method="post" name="screen_lock_form" id="screen_lock_form_id" action="{base_url}clg/authenticate_lc_pwd">

                    <div class="right_corner_icon">

                        <input type="button" name="rt_corner_btn" value="" class="form-xhttp-request" data-href="{base_url}clg/changeUser" data-qr="output_position=success_check_div&amp;module_name=clg">

                    </div>
                    <div class="sl_main_content_box text-center">

                        <div class="user_image_box">

                            <div class="user_image" style="background: url('<?php echo $pic_path;?>') no-repeat center center / cover;">

                            </div>

                        </div>

                        <div class="user_name_email_text_box">

                            <label class="bkheadlbl"><?php echo ucfirst($user_info->clg_first_name)." ".ucfirst($user_info->clg_last_name);?></label>
                            <!-- <h4><span><?php // echo $user_info->clg_email;?></span></h4> -->
                            <label class="headerlbl headerlbl2"><?php echo $user_info->clg_email;?></label>
                            <!-- <h4><span>Break Type: </span><span id="break_name_id"><?php // echo $break_type_name;?></span></h4> -->
                            <label class="headerlbl headerlbl2">Break Type: <span id="break_name_id"><?php  echo $break_type_name;?></span></label>
                            <div class="break_timer">
                                <input type='hidden' id="break_timer_clock" value="" readonly="readonly" name="break_timer_clock"/>
                                
                                <input type='text' id="break_total_timer_clock" value="" readonly="readonly" name="break_total_timer_clock"/>
                                <input type='hidden' id="session_break_time" value="<?php echo $dispatch_time;?>" readonly="readonly" name="session_break_time"/>
                                <input type='hidden' id="session_break_type" value="" readonly="readonly" name="break_type"/>
                                <input type='hidden' value="<?php echo$user_info->clg_ref_id; ?>" readonly="readonly" name="ref_id"/>
                                <input type='hidden' value="<?php echo$user_info->clg_group; ?>" readonly="readonly" name="user_group"/>
                            </div>
                            <!-- <h4><span>LOCKED</span></h4> -->
                            <label class="headerlbl headerlbl2">LOCKED</label>

                        </div>
                        
                        <div id="success_check_div">
                            <input type="hidden" name="success_check_field" value="">
                        </div>

                        <div class="pwd_fields_box">

                            <div class="pwd_fields screen_lock_accept_btn">

                               

                                <input type="password" name="password" value="" class="sl_pwd_field_input filter_required"  autocomplete="off" data-errors="{filter_required:'Password should not blank'}" >

                                <div class="vert_line_div"></div>

                                <input type="submit" name="submit_sl_pwd" value="Login" id="submit_lc_pwd_btn" class="inc_confirm_button form-xhttp-request" data-href="{base_url}clg/authenticate_lc_pwd" data-qr="output_position=success_check_div&amp;module_name=clg>">

                            </div>


                        </div>

                    </div>

                </form>
                
            </div>
            
        </div>
                
    </div>
    
</div>

<?php
$screen_lock = $CI->session->userdata('screen_locked');
if($screen_lock == 1){?>
<script>
       // clock_timer('break_timer_clock','<?php echo $dispatch_time; ?>',<?php echo $cuttent_time;?>);
        clock_timer('break_total_timer_clock','<?php echo $dispatch_time; ?>',<?php echo $cuttent_time;?>);
</script>
<?php } 
 //$break_total_time= $CI->session->userdata('break_total_time');
 
?>

<style>
    .right_corner_icon input[type="button"]:hover{
        background: transparent !important;
        
    }
    .bkheadlbl{
        text-align:center;
        padding-bottom:20px;
        font-size:30px;
    }
    #container .lock_screen_page_container .lock_screen_outer_block .screen_lock_login_box .box3 .right_corner_icon{
            /* justify-content: center; */
    text-align: center !important;
    /* position: absolute; */
    /* right: auto; */
    /* top: 5px; */
    position: unset !important;
    float: unset !important;
    min-height: 50px;
    min-width: 50px;
    }
    .headerlbl2{
        text-align:center;
    }
    
</style>
