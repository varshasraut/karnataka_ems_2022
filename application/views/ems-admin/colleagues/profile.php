<?php

$colleague_group = array("UG-ADMIN" => "Administrator", "UG-SLS" => "Sales", "UG-SPT" => "Support");

?>

<div class="sidebar_profile_view_container">
    
    <div class="sidebar_profile_view_block">
        
        <div class="profile_pic_div">
            
            <div class="user_profile_pic" style="background: white url('<?php echo "{base_url}".$image_path."/".$user_info->clg_photo;?>') no-repeat center center / cover;">
               
            </div>
            
        </div>
        
        <div class="user_profile_name float_left">
            
            <div><?php echo $user_info->clg_first_name." ".$user_info->clg_last_name;?>sfbejgae</div>
            
        </div>
        
        <div class="user_profile_group_name float_left">
            
            <div><?php echo $colleague_group[$user_info->clg_group];?>bjzdubghsae</div>
            
        </div>
        
        <div class="hr_line_div float_left">
            <div class='line'></div>
        </div>
        
    </div>
    
</div>

