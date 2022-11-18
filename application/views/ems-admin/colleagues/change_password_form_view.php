
<div class="width1 change_password_form">
        
        <h2 class="changes_pwd">Change Password</h2>
        
        <div class="chng_pwd_inner_box">
        
            <form enctype="multipart/form-data" action="#" method="post" id="change_colleague_password">

                <div class="form_field">

                    <input type="text" class="" name="ref_id" id="Ref_id_field" value="<?=$ref_id?>" placeholder="Ref.Id/Username" disabled >

                </div>
                
                <div class="form_field">

                    <input type="text" class="" name="Username" id="Ref_id_field" value="<?php echo$current_data[0]->clg_first_name." ".$current_data[0]->clg_last_name;?>" placeholder="Username" disabled >

                </div>

                <div class="form_field">

                     <input type="password" name="password" id="pwd" value="" placeholder="password" class="filter_required filter_string filter_minlength[5]" data-errors="{filter_required:'password is required', filter_string:'spaces and special characters are not allowed', filter_minlength:'Password should be at least 6 characters long'}" >

                </div>

                <div class="form_field">

                     <input type="password" name="confirm_password" id="cnfrm_pwd" placeholder="Confirm Password" class="filter_required filter_string  filter_equalto[pwd]" data-errors="{filter_required:'Confirm password is required', filter_string:'spaces and special characters are not allowed', filter_equalto:'Confirm password is not matched'}" >

                </div>
                
                <div class="button_box">

                    <input type="button" name="Change_pass" value="Change Password" class="form-xhttp-request" data-href='{base_url}clg/change_clg_pwd' data-qr='output_position=content&amp;module_name=clg&amp;tlcode=MT-CLG-CHNG-PWD&amp;reference_id=<?php echo $ref_id;?>'>

                    <input type="reset" name="Reset" value="Reset" class="btn rst_btn">

                </div>

            </form>
            
        </div>
    
</div>

