<script>
    
      initAutocomplete();

</script>

<?php
  $arr=array(
                       'page_no'=>@$post_data['page_no'],
                       'page_records'=>@$page_records
                      
                 );
  
?>
<!--    <div class="breadcrumb">
        <ul>
            <li class="colleague"><a href="{base_url}clg/colleagues">Colleague</a></li>
            <li><span><?php if($update){ ?>Update <?php } ?>Profile</span></li>
        </ul>
    </div><br>-->
    <form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
        <div class="width1">
             <h2 class="txt_clr2 width1"><?php if($update){ ?>Update <?php } ?>Profile</h2>
            <div class="joining_details_box width2 float_left">
                <div class="width1">
                <h4 class="txt_clr2">Joining Details:</h4>

                        <div class="filed_input">
 <label for="ref_id">Ref ID*</label>
                            <input id="ref_id" type="text" name="clg[clg_ref_id]" class="<?php if(!$update){ ?>filter_required filter_string<?php } ?>" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id'}" data-base="<?=@$current_data[0]->clg_ref_id?>" value="<?=@$current_data[0]->clg_ref_id?>" TABINDEX="1" <?php if(@$update){echo"disabled";}?> >

                            <?php

                                if($update){

                                    ?>

                            <input type="hidden" name="clg[clg_ref_id]" value="<?=@$current_data[0]->clg_ref_id?>">
                                        <?php

                                }

                            ?>
                        </div>
                        <div class="filed_input">
                              <label for="password">Password*</label>
                            <input id="password" data-base="<?=@$current_data[0]->clg_ref_id?>" type="password" name="clg[clg_password]" class=" <?php if(!$update){?>filter_required filter_minlength[5]<?php } ?>" data-errors="{filter_required:'Password should not be blank', filter_minlength:'Password should be at least 6 characters long'}"
                                   <?php if($update){?>placeholder="Disabled for Update Form" disabled<?php } ?>  TABINDEX="3">

                        </div>

                        <div class="filed_input">
                            <label for="group">Group*</label>
                            <select id="group" name="clg[clg_group]" data-base="<?=@$current_data[0]->clg_ref_id?>"  class="filter_required change-xhttp-request" data-href="{base_url}clg/add_commission_view" data-qr="output_position=sales_commission&amp;module_name=clg " data-errors="{filter_required:'Group name should not blank'}" TABINDEX="5">
                                <option value="">Select Group</option>
                                <?php
                                    $select_group[$current_data[0]->clg_group] = "selected = selected"; 
                                    foreach ($group_info as $group) {
                                        echo "<option value='".$group->gcode."'  ";
                                        echo $select_group[$group->gcode];      
                                        echo" >".$group->ugname;
                                        echo "</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="filed_input">
                             <label for="joining_date">Joining Date*</label>
                            <input id="joining_date" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" value="<?=@$current_data[0]->clg_joining_date?>" name="clg[clg_joining_date]" class="mi_calender filter_required" data-errors="{filter_required:'Joining date should not be blank'}" TABINDEX="2">
                        </div>

                        <div class="field_lable">
                            <label for="current_salary">Current Salary*(INR)</label>
                        </div>
                        <div class="filed_input">
                            <input id="current_salary" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_current_salary]" class="filter_required filter_number" data-errors="{filter_required:'Salary should not be blank', filter_number:'Salary should be in digits only'}" value="<?=@$current_data[0]->clg_current_salary?>"  TABINDEX="4">
                        </div>
                        <div class="field_lable">
                            <label for="email">Email*</label>
                        </div>
                        <div class="filed_input">
                            <input id="email" type="text" data-base="<?=@$current_data[0]->clg_ref_id?>"  name="clg[clg_email]" class="filter_required filter_email"  data-errors="{filter_required:'Email should not be blank', filter_email:'Please enter a valid email'}" value="<?=@$current_data[0]->clg_email?>" TABINDEX="6">
                        </div>
                       </div>
                <div class="resume_box">
                
                        <div class="filed_input">
<label for="group">Resume  ( extension allowed - .pdf, .doc, .docx ) </label>
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="profile_photo"  class="<?php if(!$update){?>filter_required" data-errors="{filter_required:'Resume is necessary '}"<?php }else{ echo ' " '; }?>  type="file" name="clg_resume" TABINDEX="18" style="float: left;">

                            <?php
                                    if(@$update){
                                                    $rsm_name = $current_data[0]->clg_resume;

                                                    list($rsm_file_name, $rsm_file_ext) = explode(".", $rsm_name);

                                                    $rsm_file_ext_image = array("doc"=>"ext_doc.png", "docx"=>"ext_doc.png", "pdf"=>"ext_pdf.png");

                                                    $rsm_path = FCPATH."upload/colleague_profile/resumes/".$rsm_name;



                                                    $rsm_download_link = "";

                                                    if(file_exists($rsm_path)){

                                                        $rsm_download_link = base_url()."upload/colleague_profile/resumes/".$rsm_name;

                                                    }      



                                                    $rsm_icon_path = base_url()."themes/backend/images/".$rsm_file_ext_image[$rsm_file_ext];                            ?>


                                                <div style="background: url('<?php echo $rsm_icon_path; ?>') no-repeat left center;height: 32px;width: 32px;padding-left: 35px;float:left;">
                                                 <a <?php if($rsm_download_link != ""): ?> href="<?php echo $rsm_download_link; ?>" <?php endif; ?> target="_blank"><?php echo $rsm_name; ?></a>
                                         </div>



                                                <?php

                                    }

                                ?>
                       
                  
                </div>    



            </div>
            </div>

            <div class="personal_details_box width2 float_left">
                <h4 class="txt_clr2">Personal Details:</h4>
                <div class="width1">
                  
                        <div class="filed_input">
                            <label for="first_name">First Name*</label>
                            <input id="first_name" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_first_name]" class="filter_required filter_word"  data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?=@$current_data[0]->clg_first_name?>" TABINDEX="7">
                        </div>
                    
                    <div class="field_row">
                        <div class="field_lable">
                            <label for="middle_name">Middle Name*</label>
                        </div>
                        <div class="filed_input">
                            <input id="middle_name" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_mid_name]" class="filter_required filter_word"  data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?=@$current_data[0]->clg_mid_name?>" TABINDEX="8">
                        </div>
                    </div>
                    <div class="field_row">
                        <div class="field_lable">
                            <label for="last_name">Last Name*</label>
                        </div>
                        <div class="filed_input">
                            <input id="last_name" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_last_name]" class="filter_required filter_word"  data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?=@$current_data[0]->clg_last_name?>" TABINDEX="9">
                        </div>
                    </div>
                    <div class="field_row">
                        <div class="field_lable">
                            <label for="mobile_no">Mobile No*</label>
                        </div>
                        <div class="filed_input">
                            <input id="mobile_no" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_mobile_no]" class="filter_required filter_number filter_minlength[9] filter_maxlength[13] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 12 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?=@$current_data[0]->clg_mobile_no?>" TABINDEX="10">
                        </div>
                    </div>
                    <div class="field_row">
                        <div class="field_lable">
                            <label for="dob">Date of Birth*</label>
                        </div>
                        <div class="filed_input">
                            <?php
                                  $date = date('Y-m-d',strtotime(date('Y-m-d') . " - 18 year"));

                            ?>
                            <input id="dob" type="text" name="clg[clg_dob]" class="mi_calender filter_required filter_lessthan[<?=$date?>]" data-base="<?=@$current_data[0]->clg_ref_id?>"  data-errors="{filter_required:'Date of birth should not be blank', filter_lower_date:'Birth date is less than today',filter_lessthan:'Colleague must be 18 years old.'}" value="<?=@$current_data[0]->clg_dob?>" TABINDEX="11">
                            <!--  filter_required"  data-errors="{filter_required:'required date of birth', filter_date:'date format is y-m-d'} -->
                        </div>
                    </div>
                </div>
                <div class="width1">
                    <div class="field_row">
                        <div class="field_lable">
                            <label for="address">Address*</label>
                        </div>
                        <div class="filed_input">
                            <input id="address" data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_address]" class="filter_required"  data-errors="{filter_required:'Address should not be blank', filter_words:'Special characters not allowed'}" value="<?=@$current_data[0]->clg_address?>" TABINDEX="12">
                        </div>
                    </div>
                     <div class="field_row">
                        <div class="field_lable">
                            <label for="city">City*</label>
                        </div>
                        <div class="filed_input">
                            <input id="pac-input"  data-base="<?=@$current_data[0]->clg_ref_id?>"  type="text" name="clg[clg_city]" data-href="" value="<?=@$current_data[0]->clg_city?>" class="<?php echo(!$update)? "filter_required" : ""; ?> controls" data-activeerror="" data-errors="{filter_required:'City should not be blank!'}" TABINDEX="13" placeholder="">


                        </div>
                    </div>
                   
                        <div class="filed_input width2 float_left">
                             <label for="marital_status">Marital status*</label>
                            <?php

                                $marital_status[@$current_data[0]->clg_marital_status] = "checked";

                            ?>
                            <div class="radio_button_div">
                                <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="marital_status" type="radio" name="clg[clg_marital_status]" value="single" <?php echo @$marital_status['single']; ?> class="" data-errors="{}" TABINDEX="14" checked>Single
                            </div>
                            <div class="radio_button_div">
                                <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="marital_status" type="radio" name="clg[clg_marital_status]" value="married" <?php echo @$marital_status['married']; ?>  class="" data-errors="{filter_required:'Marital status should not be blank'}" TABINDEX="15">Married
                            </div>
                        </div>
                    
                        <div class="filed_input width2 float_left">
                             <label for="gender">Gender*</label>
                            <?php
                                $gender[@$current_data[0]->clg_gender] = "checked";
                            ?>
                            <div class="radio_button_div">

                                <input  data-base="<?=@$current_data[0]->clg_ref_id?>"  id="gender" type="radio" name="clg[clg_gender]" value="male" class="" data-errors="{}" <?php echo $gender['male'];?> TABINDEX="16" checked>Male
                            </div>
                            <div class="radio_button_div">
                                <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="gender" type="radio" name="clg[clg_gender]" value="female" <?php echo $gender['female'];?> class="" data-errors="{filter_required:'Gender should not be blank'}" TABINDEX="17">Female
                            </div>
                        </div>
                   
                    <div class="field_row filter_width margin_top_10 width100">
                        <div class="field_lable">
                            <label for="photo">Photo*</label>

                                <?php

                                    if(@$update){

                                        ?>

                                <div class="prev_profile_pic_box">

                                    <div class="clg_photo_field edit_form_pic_box">



                                                <?php 

                                                    $name = $current_data[0]->clg_photo;

                                                    $pic_path = FCPATH."upload/colleague_profile/".$name;

                                                    if(file_exists($pic_path)){


                                                        $pic_path1 = base_url()."upload/colleague_profile/".$name;

                                                    }              
                                                    $blank_pic_path = base_url()."themes/backend/images/blank_profile_pic.png";
                                                ?>

                                             
                                            </div>

                                        </div>

                                </div>
                                        <?php

                                    }

                                ?>

                       
                        <div class="filed_input">
                            <input type="hidden" name="prev_photo" value="<?=@$current_data[0]->clg_photo?>" />
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="profile_photo" type="file" name="profile_photo" accept="image/jpg,image/jpeg" class=" <?php if(!$update){?>filter_required" data-errors="{filter_required:'Profile photo should not be blank'}"<?php }else{ echo ' " '; }?> TABINDEX="18">
                            
                            <div class="clg_photo float_right" style="background: url('<?php if(file_exists($pic_path)){echo $pic_path1;}else{echo $blank_pic_path;}?>') no-repeat left center; background-size: cover; min-height: 75px;"></div>

                        
                    </div>
                         </div>
                </div>
            </div>
        </div>
            <div class="educational_details_box width1">
                <h4 class="txt_clr2 width1">Educational Details:</h4>
                <div class="width2 float_left">
                    
                        
                        <div class="filed_input">
                             <label for="degree">Degree*</label>
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="degree" type="text" name="clg[clg_degree]" value="<?php if($update){ echo $current_data[0]->clg_degree;}?>" class="filter_required"  data-errors="{filter_required:'Degree should not be blank', filter_words:'Invalid input at Degree.. Numbers not allowed..!!'}" TABINDEX="19">
                        </div>
                        <div class="filed_input">
                            <label for="university">University*</label>
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="university" type="text" name="clg[clg_university]" value="<?php if($update){ echo $current_data[0]->clg_university;}?>" class="filter_required filter_words"  data-errors="{filter_required:'University of degree should not be blank',  filter_words:'Invalid input at university.. Numbers not allowed..!!'}"  TABINDEX="21">
                        </div>
                    
                </div>
                <div class="width2 float_left">
                        <div class="filed_input">
                            <label for="marks">Marks(%)*</label>
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="marks" type="text" name="clg[clg_marks]" value="<?php if($update){ echo $current_data[0]->clg_marks;}?>" class="filter_required filter_number"  data-errors="{filter_required:'Marks of last degree should not be blank', filter_number:'Marks in numbers only'}"  TABINDEX="20">
                        </div>
                        <div class="filed_input">
                            <label for="year_of_passing">Year of Passing*</label>
                            <input data-base="<?=@$current_data[0]->clg_ref_id?>"  id="year_of_passing" type="text" name="clg[clg_year_of_passing]" value="<?php if($update){ echo $current_data[0]->clg_year_of_passing;}?>" class="filter_required filter_number" data-errors="{filter_required:'Year of passing should not be blank', filter_number:'Invalid input at Year of passing.. Numbers are only allowed..!!'}"  TABINDEX="22">
                        </div>
                    </div>
                </div>
                 <div class="button_field_row width_25 margin_auto">
                    <div class="button_box">
                    <input type="hidden" name="hasfiles" value="yes" />
                     <input type="hidden" name="formid" value="add_colleague_registration" />
                     <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='{base_url}clg/<?php if($update){ ?>update_colleague_data<?php }else{ ?>register_colleague<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof;?>&amp;module_name=clg&amp;tlcode=<?php if($update){ ?>MT-CLG-UPDATE<?php }else{ ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no;?>'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                      <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset"  TABINDEX="24">                           <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
                    </div>
                </div>
            </div>

    </form>

