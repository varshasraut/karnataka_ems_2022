<?php
$view = ($school_action == 'view') ? 'disabled' : '';

$CI = EMS_Controller::get_instance();

$title = ($school_action == 'edit') ? " Edit School Details " : (($school_action == 'view') ? "View School Details" : "Add School Details");
?>

 <form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">

<div class="register_outer_block">

    <div class="box3">
    <h2 class="txt_clr2"><?php echo $title; ?></h2>
       
        <div class="store_details_box">
                    <div class="width1 float_left">
                        <div class="field_row width5 float_left">
                                <div class="field_lable"><label for="state">State<span class="md_field">*</span></label></div>
                                <div id="school_dtl_state">
                                    <?php $st = array('st_code' => $update[0]->school_state, 'auto' => 'school_auto_addr', 'rel' => 'school_dtl', 'disabled' => $view); ?>
                                    <?php echo get_state($st); ?>
                                </div>   
                        </div>


                        <div class="field_row width5 float_left">
                            <div class="field_lable"><label for="district">District<span class="md_field">*</span></label></div>                  
                                <div id="school_dtl_dist">
                                    <?php $dt = array('dst_code' => $update[0]->school_district, 'st_code' => $update[0]->school_state, 'auto' => 'school_auto_addr', 'rel' => 'school_dtl', 'disabled' => $view); ?>
                                    <?php echo get_district($dt); ?>
                            </div>
                        </div>

                        <div class="field_row width5 float_left">
                            <div class="field_lable"><label for="cty_name">Enter City</label></div>
                            <div class="filed_input">
                                <div id="school_dtl_city">      

                                    <?php $ct = array('cty_id' => $update[0]->school_city, 'dst_code' => $update[0]->school_district, 'auto' => 'school_auto_addr', 'rel' => 'school_dtl', 'disabled' => $view); ?>

                                    <?php echo get_city($ct); ?>

                                </div>
                            </div>  
                        </div>  
                    </div>

                    <div class="width1 float_left">
                    <div class="width5 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">ATC: </div>
                        </div>
                        <div class="width100 float_left">
                              <input name="school[atc]" tabindex="17" class="mi_autocomplete form_input " placeholder="ATC " type="text" data-errors="" data-href="<?php echo base_url();?>auto/get_auto_atc" value="<?=@$atc_data[0]->atc_id; ?>" data-value="<?=@$atc_data[0]->atc_name; ?>" data-callback-funct="load_dash_po_by_atc" >
                        </div>
                    </div>
                     <div class="width5 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">PO : </div>
                        </div>
                        <div class="input top_left" id="get_auto_po_by_atc">
                            <input name="school[po]" tabindex="17" class="mi_autocomplete form_input " placeholder="PO " type="text" data-errors="" data-href="<?php echo base_url();?>auto/get_auto_po_by_atc/<?php echo $atc_data[0]->atc_id;?>"  value="<?=@$po_data[0]->po_id; ?>" data-value="<?=@$po_data[0]->po_name; ?>" data-qr="atc_id=<?php echo $atc_id;?>" data-callback-funct="load_cluster_by_po">
                        </div>
                    </div>
                    <div class="width5 drg float_left">
                        <div class="width100 float_left">
                            <div class="style6 float_left">Cluster : </div>
                        </div>
                        <div class="input top_left" id="get_auto_cluster_by_po">
                            <input  name="school[cluster_id]" value="<?=@$cluster_data[0]->cluster_id; ?>" class="mi_autocomplete width99" data-href="<?php echo base_url(); ?>auto/get_auto_cluster/<?php echo $po_data[0]->po_id;?>" data-base="" tabindex="7" data-value="<?php echo $cluster_data[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly" data-errors="" data-callback-funct="cluster_schools_list" >
                        </div>
                    </div>
                        <!-- <div class="width5 float_left">
                            <div class="field_lable"><label for="schedule_clusterid">Cluster<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <input  name="school[cluster_id]" value="<?= @$update[0]->cluster_id; ?>" class="mi_autocomplete width99 filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_cluster" data-base="" tabindex="7" data-value="<?php echo $update[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly"  <?php echo $view; ?> data-errors="{filter_required:'Cluster should not be blank'}">
                            </div>
                        </div>

                        <div class="width5 float_left">
                            <div class="field_lable"><label for="schedule_clusterid">PO<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <input  name="school[cluster_id]" value="<?= @$update[0]->cluster_id; ?>" class="mi_autocomplete width99 filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_cluster" data-base="" tabindex="7" data-value="<?php echo $update[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly"  <?php echo $view; ?> data-errors="{filter_required:'Cluster should not be blank'}">
                            </div>
                        </div>

                        <div class="width5 float_left">
                            <div class="field_lable"><label for="schedule_clusterid">Block<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <input  name="school[cluster_id]" value="<?= @$update[0]->cluster_id; ?>" class="mi_autocomplete width99 filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_cluster" data-base="" tabindex="7" data-value="<?php echo $update[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly"  <?php echo $view; ?> data-errors="{filter_required:'Cluster should not be blank'}">
                            </div>
                        </div> -->

                    </div>
                    <div class="width1 float_left">
                        <!-- <div class="field_row"> -->
                            <div class="width33 float_left">
                                <div class="field_row">
                                <div class="field_lable"><label for="school_name">School Name<span class="md_field">*</span></label></div>

                                <div class="filed_select">
                                    <input type="text" name="school['school_name']" value="<?php echo $update[0]->school_name; ?>" class="small half-text " data-errors="" <?php echo $view; ?> placeholder="School Name" TABINDEX="3">

                                </div>
                                </div>
                            </div>
                            <div class="width_66 float_left">
                                <div class="field_row">
                                    <div class="field_lable"> <label for="address">Address<span class="md_field">*</span></label></div>
                                    <div class="filed_input">
                                        <input name="school[school_address]" value="<?= @$update[0]->school_address ?>"<?php echo $view; ?>  class="hp_dtl  width97" TABINDEX="8" type="text" placeholder="Address" data-state="yes" data-dist="yes" data-city="yes" data-area="yes" data-lmark="yes" data-lane="yes" data-pin="yes" data-rel="school_dtl" data-auto="school_auto_addr" data-errors=""> 
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                        
                    </div>

        
                   
                </div>
                <!-- </div> -->
            <div class="width1 float_left ">
                <div class="store_details_box">

                    <div class="width5 float_left">
                        <div class="field_row">
                            <div class="field_lable"><label for="school_mobile">Mobile Number<span class="md_field">*</span></label></div>
                            <div class="filed_input">
                                <input type="text" name="school[school_mobile]" value="<?php echo $update[0]->school_mobile; ?>" class="small half-text filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_no_whitespace:'Mobile number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" <?php echo $view; ?> placeholder="Mobile Number" TABINDEX="3">
                            </div>
                        </div>
                    </div>  

                    <div class="width5 float_left">
                        <div class="field_row">
                            <div class="field_lable"><label for="email">Email ID</label></div>
                            <div class="filed_input">
                                <input id="email" type="text" name="school[school_email]" class="filter_email " value="<?= @$update[0]->school_email ?>" data-errors="{filter_email:'Email should be valid.'}" <?php echo $view; ?> TABINDEX="6" placeholder="Email">
                            </div>
                        </div>  
                    </div>  
                    <div class="width5 float_left">
                        <div class="field_row">
                            <div class="field_lable"><label for="school_url">School Website URL</label></div>
                            <div class="filed_input">
                                <input id="school_url" type="text" name="school[school_website]" value="<?php echo $update[0]->school_website; ?>" class="filter_url"  data-errors="{filter_url:'School URL should be valid.'}" <?php echo $view; ?> placeholder="https://www.yourwebsite.com" TABINDEX="7">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                            <!-- <hr class="new1">   -->
                        <div class="form_field width1 select float_left">
                            <div class="width5 float_left">
                            <div class="field_row">

                            <div class="field_lable"><label for="reg_no">Registration Number<span class="md_field">*</span></label></div>

                            <div class="filed_input">
                                <input type="text" name="school[school_reg_no]" value="<?php
                                if ($update) {
                                    echo $update[0]->school_reg_no;
                                }
                                ?>" class=""  data-errors=""  <?php echo $view; ?> TABINDEX="2" <?php
                                    if (@$update) {
                                        echo"disabled";
                                    }
                                    ?> placeholder="Registration Number">


                                <?php if ($update) { ?>                                        

                                    <input type="hidden" name="school[school_reg_no]" value="<?php echo $update[0]->school_reg_no; ?>">

                                <?php } ?>      
                            </div>
                            </div>
                            </div>

                            <div class="width5 float_left">
                                <div class="field_row">

                                    <div class="field_lable"><label for="reg_no">Registration Details</label></div>
                                    <div class="filed_input">
                                        <input id="" type="file" name="school[regi_details]" class="  no_ucfirst"  data-errors="" <?php echo $view; ?>  TABINDEX="7">
                                    </div>
                                </div>
                            </div>
                            <div class="width5 float_left">
                            <div class="form_field width100 select float_left">
                            <div class="field_lable"><label for="head_master">Management Name</label></div>
                            <div class="input top_left">
                                <?php //$head_master_name = $update[0]->clg_first_name . ' ' . $update[0]->clg_last_name; ?>

                                <input id="" type="text" name="school[mgmt_name]" value="<?php echo $update[0]->school_website; ?>" class=""  <?php echo $view; ?> placeholder="Management Name" TABINDEX="7">

                            </div>
                        </div>
                            
                        </div>
                        
                    </div>
                                
                      


                   

                    <!-- <div class="width1 float_left"> 
                    <div class="width2 float_left">                      

                        
                        <div class="field_row">
                        <div class="field_lable"><label for="health_sup">Health Supervisor</label></div>
                            <div class="input top_left">
                                <div class="field_input" id="schedule_clusterid">
                                    <select name="school[school_heathsupervisior][]" class="filter_required" data-errors="{filter_required:'Health Supervisor should not be blank'}" <?php echo $view; ?> TABINDEX="5" multiple="">
                                        <option value="">Select Health Supervisor</option>
                                        <?php //echo get_school_clg('UG-HEALTH-SUP', $update[0]->school_heathsupervisior); ?>
                                    </select>
                                </div>

                            </div>
                           
                        </div>
                        </div>
                       
                        <div class="width2 float_left">
                            <div class="field_lable"><label for="Warden">Warden</label></div>
                            <div class="input top_left">

                                <div class="field_input" id="schedule_clusterid">
                                    <select name="school[school_warden][]" class="filter_required" data-errors="{filter_required:'Warden should not be blank'}" <?php echo $view; ?> TABINDEX="5" multiple="">

                                        <option value="">Select Warden</option>

                                        <?php //echo get_school_clg('UG-WARDEN', $update[0]->school_warden); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div> -->

                        <div class="width1 float_left ">
                            <div class="store_details_box">
                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="school_url">Head Master Name:</label></div>
                                        <div class="filed_input">
                                            <input id="school_url" type="text" name="school[headmaster]" value="<?php echo $update[0]->school_website; ?>" class="filter_url"  data-errors="{filter_url:'School URL should be valid.'}" <?php echo $view; ?> placeholder="https://www.yourwebsite.com" TABINDEX="7">
                                        </div>
                                    </div>
                                </div>
                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="school_mobile">Mobile Number<span class="md_field">*</span></label></div>
                                        <div class="filed_input">
                                            <input type="text" name="school[head_m_mobile]" value="<?php echo $update[0]->school_mobile; ?>" class="small half-text filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_no_whitespace:'Mobile number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" <?php echo $view; ?> placeholder="Mobile Number" TABINDEX="3">
                                        </div>
                                    </div>
                                </div>  

                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="email">Email ID</label></div>
                                        <div class="filed_input">
                                            <input id="email" type="text" name="school[head_m_email]" class="filter_email" value="<?= @$update[0]->school_email ?>" data-errors="{filter_email:'Email should be valid.'}" <?php echo $view; ?> TABINDEX="6" placeholder="Email">
                                        </div>
                                    </div>  
                                </div>  
                                
                            </div>
                        </div>

                        <div class="width1 float_left ">
                            <div class="store_details_box">
                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="school_url">Warden Name:</label></div>
                                        <div class="filed_input">
                                            <input id="school_url" type="text" name="school[warden]" value="<?php echo $update[0]->school_website; ?>" class=""  <?php echo $view; ?> placeholder="Warden Name" TABINDEX="7">
                                        </div>
                                    </div>
                                </div>
                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="school_mobile">Mobile Number<span class="md_field">*</span></label></div>
                                        <div class="filed_input">
                                            <input type="text" name="school[warden_mobile]" value="<?php echo $update[0]->school_mobile; ?>" class="small half-text  filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace" data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only.', filter_minlength:'Mobile number should be at least 10 digits long',filter_maxlength:'Mobile number should less then 11 digits.',filter_no_whitespace:'Mobile number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" <?php echo $view; ?> placeholder="Mobile Number" TABINDEX="3">
                                        </div>
                                    </div>
                                </div>  

                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="email">Email ID</label></div>
                                        <div class="filed_input">
                                            <input id="email" type="text" name="school[warden_email]" class="filter_email no_ucfirst" value="<?= @$update[0]->school_email ?>" data-errors="{filter_email:'Email should be valid.'}" <?php echo $view; ?> TABINDEX="6" placeholder="Email">
                                        </div>
                                    </div>  
                                </div>  
                                
                            </div>
                        </div>
                        
                        <div class="width1 float_left ">
                            <div class="store_details_box">
                            <div class="width5 float_left ">
                                <div class="field_row">
                                        <div class="field_lable"><label for="school_url">Hostel Facilities</label></div>
                                        <div class="filed_input">
                                            <div class="radio_button_div">
                                                <input  type="radio" name="school[hostel_fac]" value="yes"  class=""  TABINDEX="14"  <?php echo $view; ?>> Yes
                                            </div>

                                            <div class="radio_button_div">
                                                <input  type="radio" name="school[hostel_fac]" value="no"   class="" TABINDEX="15"  <?php echo $view; ?>> No 
                                            </div>
                                        </div>
                                    </div>           
                            </div>
                            <!-- <div class="width2 float_left "> -->
                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="school_url">Classes From<span class="md_field">*</span></label></div>
                                        <div class="filed_input">
                                        <select name="school[class_frm]">
                                            <option value="">Select Classes From</option>
                                            <option value="Play Group">Play Group</option>
                                            <option value="LKG">LKG</option>
                                            <option value="UKG">UKG</option>
                                            <option value="SKG">SKG</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>

                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="width5 float_left">
                                    <div class="field_row">
                                        <div class="field_lable"><label for="school_mobile">Classes To<span class="md_field">*</span></label></div>
                                        <div class="filed_input">
                                        <select name="school[class_to]">
                                            <option value="">Select Classes To</option>
                                            <option value="Play Group">Play Group</option>
                                            <option value="LKG">LKG</option>
                                            <option value="UKG">UKG</option>
                                            <option value="SKG">SKG</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>

                                        </select>
                                        </div>
                                    </div>
                                </div>  
                            <!-- </div> -->
                            </div>
                        </div>

                        <div class="field_row">

                            <div class="field_lable"><label>&nbsp;</label></div>                  
                            <!-- <div class="empty_div">
                            </div> -->

                        </div>

                    </div>
                <!-- </div>  -->
                

                <?php if (!(@$school_action == 'view')) { ?>

                    <div class="width_25 margin_auto">
                        <div class="button_field_row">
                            <div class="button_box">
                                <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='<?php echo base_url(); ?>schools/<?php if ($update) { ?>update_school<?php } else { ?>save_school<?php } ?>' data-qr='school_id=<?php echo base64_encode($update[0]->school_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                                <input type="reset" name="reset" value="Reset" class="reset_btn" TABINDEX="13">
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>
        </form>