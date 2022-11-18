<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$CI = EMS_Controller::get_instance();

$user_info =  $CI->session->userdata('current_user');


$image_path = $CI->config->item('upload_path');

//var_dump($CI);
$colleague_group = array("UG-ADMIN" => "Administrator", "UG-SLS" => "Sales", "UG-SPT" => "Support");
?>
<!--<div class="sidebar_profile_view_container">
    
    <div class="sidebar_profile_view_block">
        
        <div class="profile_pic_div">
            <?php
            
            $pic_path = FCPATH.$image_path."/colleague_profile/".$user_info->clg_photo;
            
            if(file_exists($pic_path)){

                    $pic_path1 = base_url().$image_path."/colleague_profile/".$user_info->clg_photo;
                   
                }
//exit;                    
                $blank_pic_path = base_url()."themes/backend/images/blank_profile_pic.png";

                    ?>
            
            <div class="user_profile_pic" style="background: white url('<?php if(file_exists($pic_path)){echo $pic_path1;}else{echo $blank_pic_path;}?>') no-repeat center center / cover;">
               
            </div>
            
        </div>
        
        <div class="user_profile_name float_left" style="color: white;">
            
            <div><?php echo $user_info->clg_first_name." ".$user_info->clg_last_name;?></div>
            
        </div>
        
        <div class="user_profile_group_name float_left">
            
            <div><?php echo $colleague_group[$user_info->clg_group];?></div>
            
        </div>
        
        <div class="hr_line_div float_left">
            <div class='line'></div>
        </div>
        
    </div>
    
</div>-->

