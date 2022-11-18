<div class="login_content width100 height100">
    <div class="login_wrapper auto_margin">
        <div class="trans_box  margin_auto">
            <div class="width100">
               <!-- <div class="text_align_center">
                    <a href="{base_url}"> <div class="ems_logo margin_auto"></div>
                    </a>
                </div>-->
                <div class="text_align_center">
                    <h3>EMS LOGIN</h3>
                </div>

                <div class="login_inner_box">

                    <!--<h2></h2>-->

                    <?php
                    echo @$message;
                    echo "<form action='{base_url}clg/authenticate_password' method='post' class='login_form'>";
                    ?>
                    <div class="form_field">
                        <select name="user_group" id="user_group"  class="width_100">
                            ?>
                            <option value="">Users Group</option> 
                            <?php foreach ($users as $users_data): ?>
                            <option value="<?php echo $users_data->gcode; ?>" <?php echo @$selected_group[$users_data->gcode] ?> ><?php echo $users_data->ugname; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form_field">
                        <input type="text" class="filter_required filter_string" name="ref_id" placeholder="Ref.Id/Username" data-errors="{filter_required:'Reference id should not be blank!', filter_string:'Invalid reference id!'}"  class="width100"  data-style="line">
                    </div>

                    <div class="form_field">                                            
                        <input type="password" class="filter_required filter_minlength[5]" name="password" placeholder="Password" data-errors="{filter_required:'Password should not be blank!', filter_minlength:'Password should be at least 6 characters long!'}" class="width100"  data-style="line" >
                    </div>
                    <div class="text_align_center button_box">
                        <input type="submit" name="login[btn_submit]" value="Login" class="validate-form style1" >
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>