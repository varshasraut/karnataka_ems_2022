<?php //$current_data = $CI->session->userdata('current_user');
//var_dump($ref_id);
//var_dump($current_data[0]);
if(isset($first)){
    $class = 'width50';
}else{
    $class = 'width1';
}
?>
<div class="<?php echo $class;?> change_password_form">
        
        <h2 class="changes_pwd txt_pro hheadbgpwd">Change Password</h2>
        
        <div class="chng_pwd_inner_box">
        
            <form enctype="multipart/form-data" action="#" method="post" id="change_colleague_password">

                <div class="form_field">

                    <input type="text" class="" name="ref_id" id="Ref_id_field" value="<?=$ref_id?>" placeholder="Ref.Id/Username" disabled >

                </div>
                
                <div class="form_field">

                    <input type="text" class="" name="Username" id="username" value="<?php echo $current_data[0]->clg_first_name." ".$current_data[0]->clg_last_name;?>" placeholder="Username" disabled >

                </div>
                <div class="form_field">

                     <input type="password" name="current_password" value="" placeholder="Current Password" class="filter_required filter_minlength[5]" data-errors="{filter_required:'Current password is required', filter_string:'spaces and special characters are not allowed',filter_password:'Minimum eight characters, at least one letter, one number and one special character', filter_minlength:'Current Password should be at least 8 characters long'}" >

                </div>

                <div class="form_field">
                    <div>
                     <input type="password" name="password" id="pwd" value="" placeholder="password" class="filter_required filter_minlength[5] filter_password" data-errors="{filter_required:'password is required', filter_string:'spaces and special characters are not allowed',filter_password:'Minimum six characters, at least one letter, one number and one special character', filter_minlength:'Password should be at least 6 characters long'}" >

                    </div>
                </div>

                <div class="form_field">

                     <input type="password" name="confirm_password" id="cnfrm_pwd" placeholder="Confirm Password" class="filter_required  filter_equalto[pwd]" data-errors="{filter_required:'Confirm password is required', filter_string:'spaces and special characters are not allowed', filter_equalto:'Confirm password is not matched'}" >

                </div>
                
                <div class="button_box text-center">
                    
                    

                    <input type="button" name="Change_pass" value="Change Password" class="form-xhttp-request hheadbg" data-href='{base_url}clg/change_clg_pwd' data-qr='output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-CHNG-PWD&amp;ref_id=<?php echo $ref_id;?>'>

                    <input type="reset" name="Reset" value="Reset" class="btn hheadbg rst_btn mt-0" >

                </div>

            </form>
            
        </div>
    
</div>

