<?php
$view = ($school_action == 'view') ? 'disabled' : '';

$CI = EMS_Controller::get_instance();

$title = ($school_action == 'edit') ? " Edit School Details " : (($school_action == 'view') ? "View School Details" : "Add School Details");
?>



<div class="register_outer_block">

    <div class="box3">

        <form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
            <div class="width1 float_left ">

                <h2 class="txt_clr2"><?php echo $title; ?></h2>

                <div class="store_details_box">

                    <div class="width2 float_left">

                        <div class="field_row">

                            <div class="field_lable"><label for="school_name">School Name<span class="md_field">*</span></label></div>

                            <div class="filed_select">
                                <input type="text" name="school[school_name]" value="<?php echo $update[0]->school_name; ?>" class="small half-text filter_required" data-errors="{filter_required:'School Name should not be blank'}" <?php echo $view; ?> placeholder="School Name" TABINDEX="3">

                            </div>
                        </div>

                        <div class="field_row">

                            <div class="field_lable"><label for="school_mobile">Mobile Number<span class="md_field">*</span></label></div>

                            <div class="filed_input">
                                <input type="text" name="school[school_mobile]" value="<?php echo $update[0]->school_mobile; ?>" class="small half-text filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_no_whitespace:'Mobile number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" <?php echo $view; ?> placeholder="Mobile Number" TABINDEX="3">
                            </div>

                        </div>  


                        <div class="field_row">

                            <div class="field_lable"><label for="email">Email ID</label></div>

                            <div class="filed_input">
                                <input id="email" type="text" name="school[school_email]" class="filter_email filter_if_not_blank no_ucfirst" value="<?= @$update[0]->school_email ?>" data-errors="{filter_email:'Email should be valid.'}" <?php echo $view; ?> TABINDEX="6" placeholder="Email">
                            </div>

                        </div>
                        <div class="form_field width100 select float_left">
                            <div class="field_lable"><label for="health_sup">Health Supervisor</label></div>
                            <div class="input top_left">
                                <div class="field_input" id="schedule_clusterid">
                                    <select name="school[school_heathsupervisior][]" class="filter_required" data-errors="{filter_required:'Health Supervisor should not be blank'}" <?php echo $view; ?> TABINDEX="5" multiple="">
                                        <option value="">Select Health Supervisor</option>
                                        <?php echo get_school_clg('UG-HEALTH-SUP', $update[0]->school_heathsupervisior); ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="field_row">
                            <div class="field_lable"><label for="schedule_clusterid">Cluster<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <input  name="school[cluster_id]" value="<?= @$update[0]->cluster_id; ?>" class="mi_autocomplete width99 filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_cluster" data-base="" tabindex="7" data-value="<?php echo $update[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly"  <?php echo $view; ?> data-errors="{filter_required:'Cluster should not be blank'}">
                            </div>
                        </div>


                    </div>


                    <div class="width2 float_right">                      

                        <div class="field_row">

                            <div class="field_lable"><label for="reg_no">Register Number<span class="md_field">*</span></label></div>

                            <div class="filed_input">
                                <input type="text" name="school[school_reg_no]" value="<?php
                                if ($update) {
                                    echo $update[0]->school_reg_no;
                                }
                                ?>" class="filter_required"  data-errors="{filter_required:'Register number should not be blank'}"  <?php echo $view; ?> TABINDEX="2" <?php
                                       if (@$update) {
                                           echo"disabled";
                                       }
                                       ?> placeholder="Register Number">


                                <?php if ($update) { ?>                                        

                                    <input type="hidden" name="school[school_reg_no]" value="<?php echo $update[0]->school_reg_no; ?>">

                                <?php } ?>      
                            </div>
                        </div>
                        <div class="field_row">

                            <div class="field_lable"><label for="school_url">School Website URL</label></div>

                            <div class="filed_input">
                                <input id="school_url" type="text" name="school[school_website]" value="<?php echo $update[0]->school_website; ?>" class="filter_url filter_if_not_blank no_ucfirst"  data-errors="{filter_url:'School URL should be valid.'}" <?php echo $view; ?> placeholder="https://www.yourwebsite.com" TABINDEX="7">

                            </div>
                        </div>

                        <div class="form_field width100 select float_left">
                            <div class="field_lable"><label for="head_master">School Head-Master</label></div>
                            <div class="input top_left">
                                <?php $head_master_name = $update[0]->clg_first_name . ' ' . $update[0]->clg_last_name; ?>

                                <input name="school[school_headmastername]" class="mi_autocomplete" data-href="<?php echo base_url(); ?>auto/get_auto_school_clg?clg_group=UG-HEAD-MASTER&clg_ref_id=<?php echo $update[0]->school_headmastername; ?>"  data-value="<?php echo $head_master_name; ?>" value="<?php echo $update[0]->school_headmastername; ?>" type="text" tabindex="2" placeholder="School Head-Master">

                            </div>
                        </div>
                        <div class="form_field width100 select float_left">
                            <div class="field_lable"><label for="Warden">Warden</label></div>
                            <div class="input top_left">

                                <div class="field_input" id="schedule_clusterid">
                                    <select name="school[school_warden][]" class="filter_required" data-errors="{filter_required:'Warden should not be blank'}" <?php echo $view; ?> TABINDEX="5" multiple="">

                                        <option value="">Select Warden</option>

                                        <?php echo get_school_clg('UG-WARDEN', $update[0]->school_warden); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field_row">

                            <div class="field_lable"><label>&nbsp;</label></div>                  
                            <div class="empty_div">
                            </div>

                        </div>

                    </div>
                </div> 
                <div class="store_details_box">

                    <div class="width2 float_left">
                        <div class="field_row">

                            <div class="field_row">
                                <div class="field_lable"><label for="state">State<span class="md_field">*</span></label></div>
                                <div id="school_dtl_state">
                                    <?php $st = array('st_code' => $update[0]->school_state, 'auto' => 'school_auto_addr', 'rel' => 'school_dtl', 'disabled' => $view); ?>
                                    <?php echo get_state($st); ?>
                                </div>
                            </div>
                        </div>


                        <div class="field_row">

                            <div class="field_lable"><label for="cty_name">Enter City</label></div>

                            <div class="filed_input">

                                <div id="school_dtl_city">      


                                    <?php $ct = array('cty_id' => $update[0]->school_city, 'dst_code' => $update[0]->school_district, 'auto' => 'school_auto_addr', 'rel' => 'school_dtl', 'disabled' => $view); ?>

                                    <?php echo get_city($ct); ?>

                                </div>

                            </div>    

                        </div>
                    </div>
                    <div class="width2 float_left">

                        <div class="field_row">

                            <div class="field_lable"><label for="district">District<span class="md_field">*</span></label></div>                  
                            <div id="school_dtl_dist">

                                <?php $dt = array('dst_code' => $update[0]->school_district, 'st_code' => $update[0]->school_state, 'auto' => 'school_auto_addr', 'rel' => 'school_dtl', 'disabled' => $view); ?>

                                <?php echo get_district($dt); ?>

                            </div>

                        </div>
                        <div class="field_row">
                            <div class="width100">
                                <div class="field_row">
                                    <div class="field_lable"> <label for="address">Address<span class="md_field">*</span></label></div>
                                    <div class="filed_input">
                                        <input name="school[school_address]" value="<?= @$update[0]->school_address ?>"<?php echo $view; ?>  class="hp_dtl filter_required width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="school_dtl" data-auto="school_auto_addr" data-errors="{filter_required:'Address should not be blank.'}"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!(@$school_action == 'view')) { ?>

                    <div class="width_25 margin_auto">
                        <div class="button_field_row">
                            <div class="button_box">

                                <input type="hidden" name="submit_amb" value="amb_reg" />

                                <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>schools/<?php if ($update) { ?>update_school<?php } else { ?>save_school<?php } ?>' data-qr='school_id=<?php echo base64_encode($update[0]->school_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                                <input type="reset" name="reset" value="Reset" class="reset_btn" TABINDEX="13">
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </form>

        <?php if (!$update) { ?>  

        </div>

    <?php } ?>

</div>