<div class="colleagues_list">
    
    <div class="clg_profile_view">
        
        <form enctype="multipart/form-data" action="#" method="post" id="add_colleague">
            <div class="register_block">
                <h3 class="txt_clr5">Colleague Profile</h3>
                <div class="joining_details_box">
                    <h4 class="txt_clr2">Joining Details:</h4>
                    <div class="width2 float_left">
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="ref_id">Ref ID </label>
                                <input id="ref_id" type="text" name="clg[ref_id]" class="filter_required filter_string" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id'}" value="<?=$colleague[0]->clg_ref_id?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="group">Group </label>
                                <input id="group" type="text" name="clg[group]" class="filter_required"  data-errors="{filter_required:'Email should not be blank'}" value="<?=@$colleague[0]->clg_group?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="joining_date">Joining Date </label>
                                <input id="joining_date" type="date" value="<?=@$colleague[0]->clg_joining_date?>" name="clg[joining_date]" class="mi_calender filter_required" data-errors="{filter_required:'Joining date should not be blank'}" disabled >
                            </div>
                        </div>
                    </div>
                    <div class="width2 float_right">
                        <div class="field_row">
                            <div class="field_lable clg_photo_field">
                                <label for="photo" class="photo_label">Photo </label><br>
                                
                                
                <?php 
                    $name = $colleague[0]->clg_photo;

                    $pos = strrpos($name, '.');
                  
                    $pic_path = FCPATH."upload/colleague_profile/".$name;
                    
                    if(file_exists($pic_path)){
                         
                        $pic_path1 = base_url()."upload/colleague_profile/".$name;
                        
                    }
                    
                    $blank_pic_path = base_url()."themes/backend/images/blank_profile_pic.png";
                ?>
                
                <div class="clg_profile_pic" style="background: url('<?php if(file_exists($pic_path)){echo $pic_path1;}else{echo $blank_pic_path;}?>') no-repeat center center; background-size: cover;">
            </div>
                            </div>
                        </div>
                        
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="current_salary">Current Salary (INR)</label>
                                <input id="current_salary" type="text" name="clg[current_salary]" class="filter_required filter_number" data-errors="{filter_required:'Salary should not be blank', filter_number:'Salary should be in digits only'}" value="<?php echo @$colleague[0]->clg_current_salary;?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="personal_details_box">
                    <h4 class="txt_clr2">Personal Details:</h4>
                    <div class="width2 float_left">
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="first_name">First Name </label>
                            </div>
                            <div class="filed_input">
                                <input id="first_name" type="text" name="clg[first_name]" class="filter_required filter_string"  data-errors="{filter_required:'First name should not be blank', filter_string:'Invalid input at first name'}" value="<?=@$colleague[0]->clg_first_name?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="middle_name">Middle Name </label>
                            </div>
                            <div class="filed_input">
                                <input id="middle_name" type="text" name="clg[middle_name]" class="filter_required filter_string"  data-errors="{filter_required:'Middle name should not be blank', filter_string:'Invalid input at middle name'}" value="<?=@$colleague[0]->clg_mid_name?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="last_name">Last Name </label>
                            </div>
                            <div class="filed_input">
                                <input id="last_name" type="text" name="clg[last_name]" class="filter_required filter_string"  data-errors="{filter_required:'Last name should not be blank', filter_string:'Invalid input at last name'}" value="<?=@$colleague[0]->clg_last_name?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="mobile_no">Mobile No </label>
                            </div>
                            <div class="filed_input">
                                <input id="mobile_no" type="text" name="clg[mobile_no]" class="filter_required filter_number filter_minlength[9]"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long'}" value="<?=@$colleague[0]->clg_mobile_no?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="email">Email </label>
<!--                            </div>
                            <div class="filed_input">-->
                                <input id="email" type="text" name="clg[email]" class="filter_required filter_email"  data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}" value="<?=@$colleague[0]->clg_email?>" disabled>
                            </div>
                        </div>
                    </div>
                     <div class="width2 float_right">
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="dob">Date of Birth </label>
                            </div>
                            <div class="filed_input">
                                <input id="dob" type="date" name="clg[dob]" class="mi_calender filter_required" data-errors="{filter_required:'Date of birth should not be blank'}" value="<?=@$colleague[0]->clg_dob?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="gender">Gender </label>
                            </div>
                            <div class="filed_input">
                                <input id="gender" type="text" name="clg[gender]" class="" value="<?=@$colleague[0]->clg_gender?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="marital_status">Marital status </label>
                            </div>
                            <div class="filed_input">
                                <input id="marital_status" type="text" name="clg[marital_status]" class="" value="<?=@$colleague[0]->clg_marital_status?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="address">Address </label>
                            </div>
                            <div class="filed_input">
                                <input id="address" type="text" name="clg[address]" class="filter_required"  data-errors="{filter_required:'Address should not be blank'}" value="<?=@$colleague[0]->clg_address?>" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="city">City </label>
                            </div>
                            <div class="filed_input" id="cities_dropdown_list">
                                <input id="city" type="text" name="clg[city]" class="" value="<?php echo @$colleague[0]->clg_city; ?>" disabled>
                                
                            </div>
                        </div>                                                
                    </div>
                </div>
                <div class="educational_details_box">
                    <h4 class="txt_clr2">Educational Details:</h4>
                    <div class="width2 float_left">
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="degree">Degree </label>
                            </div>
                            <div class="filed_input">
                                <input id="degree" type="text" name="clg[degree]" value="<?=@$colleague[0]->clg_degree?>" class="filter_required filter_words"  data-errors="{filter_required:'Degree should not be blank', filter_words:'Invalid input at Degree.. Numbers not allowed..!!'}" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="university">University </label>
                            </div>
                            <div class="filed_input">
                                <input id="university" type="text" name="clg[university]" value="<?=@$colleague[0]->clg_university?>" class="filter_required filter_words"  data-errors="{filter_required:'University of degree should not be blank',  filter_words:'Invalid input at university.. Numbers not allowed..!!'}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="width2 float_right">
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="marks">Marks(%) </label>
                            </div>
                            <div class="filed_input">
                                <input id="marks" type="text" name="clg[marks]" value="<?=@$colleague[0]->clg_marks?>" class="filter_required filter_number"  data-errors="{filter_required:'Marks of last degree should not be blank', filter_number:'Marks in numbers only'}" disabled>
                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable">
                                <label for="year_of_passing">Year of Passing </label>
                            </div>
                            <div class="filed_input">
                                <input id="year_of_passing" type="text" name="clg[year_of_passing]" value="<?=@$colleague[0]->clg_year_of_passing?>" class="filter_required filter_number" data-errors="{filter_required:'Year of passing should not be blank', filter_number:'Invalid input at Year of passing.. Numbers are only allowed..!!'}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </form>
        
    </div>
    
</div>    