
<div id="dublicate_id"></div>
<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>
<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro hheadbg"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>
        <div class="joining_details_box  ">
            <div>

                <h3 class="txt_clr2 reg_title">Joining Details</h3>

                <div class="field_row line_height width100">
                   
                    <div class="float_left width_10 strong">Group</div>
                    <div class="float_left width_23"> <?php
                        $select_group[$current_data[0]->clg_group] = "selected = selected";
                        foreach ($group_info as $group) {
                            if ($select_group[$group->gcode]) {
                                echo $group->ugname;
                            }
                        }
                        ?></div>
                     <div class="float_left width_10 strong">User ID</div>
                    <div class="float_left width_23">  <?php echo @$current_data[0]->clg_ref_id; ?>  </div>
                    
                    <div class="float_left width_10 strong">Joining Date</div>
                    <div  class="float_left width_23">   <?php if($current_data[0]->clg_joining_date != '' && $current_data[0]->clg_joining_date != '0000-00-00' && $current_data[0]->clg_joining_date != '1970-01-01'){ echo date('d-m-Y',strtotime($current_data[0]->clg_joining_date)); }else{ echo 'DNA'; } ?>  </div>
                </div>
                

                
                <div class="field_row line_height">
                     <div class="float_left width_10 strong">Ameyo Id</div>
                    <div  class="float_left width_23">   <?php echo @$current_data[0]->clg_avaya_id; ?>  </div>
                    
                </div>
                        
            </div>
        </div>

        <div class="  joining_details_box">
            <h3 class="txt_clr2 reg_title">Personal Details</h3>
            <div>
               <div class="field_row line_height">
                    <div class="float_left width_10 strong">Name</div>
                    <div class="float_left width_23">   <?php echo $current_data[0]->clg_first_name.' '.$current_data[0]->clg_mid_name.' '.$current_data[0]->clg_last_name; ?>                      </div>
                     <div class="float_left width_16 strong">Mobile No</div>
                    <div class="float_left width_16">   <?php echo $current_data[0]->clg_mobile_no; ?>  </div>
                     <div class="float_left width_10 strong">City</div>
                    <div class="float_left width_23 ">   <?php echo $current_data[0]->clg_city; ?>  </div>
                     
                </div>
             
                 <div class="field_row line_height">
                   
                     <div class="float_left width_10 strong">Status</div>
                      <?php $selected[@$current_data[0]->clg_is_active] = "selected=selected"; ?>   
                    <div  class="float_left width_23">   <?php  if($selected['0']){
                        echo 'Inactive';
                    }elseif ($selected['1']) {
                             echo 'Active';
                        }elseif ($selected['2']) {
                              echo 'Deleted';
                        } ?>  </div>
                      <div class="float_left width_16 strong">Marital status</div>
                    <div class="float_left width_16">   <?php  
                        echo ucwords($current_data[0]->clg_marital_status);
                   ?>  </div>
                </div>

                 <div class="field_row line_height">
                   
                    <div class="float_left width_10 strong">Gender</div>
                     
                    <div class="float_left width_23">   <?php  
                        echo ucwords($current_data[0]->clg_gender);
                   ?>  </div>
                     <div class="float_left width_10 strong">Email</div>
                    <div  class="float_left width_23"> <?php echo @$current_data[0]->clg_email; ?></div>
                    <div class="float_left width_16 strong">Address</div>
                    <div  class="float_left width_16">   <?php echo @$current_data[0]->clg_address; ?>  </div>
                    <div class="float_left width_10 strong">Employee Type</div>
                    <div  class="float_left width_23">   <?php echo @$current_data[0]->thirdparty_name ; ?>  </div>
                </div>
                <div class="field_row line_height width100">
                    <div class="float_left width_10 strong">Zone</div>
                    <div  class="float_left width_23"> <?php echo @$current_data[0]->zone_name; ?></div>
                    <div class="float_left width_16 strong">District</div>
                    <div  class="float_left width_23">   <?php 
                    if($clg_district_name){
                        $dist = implode(', ', $clg_district_name);
                    echo $dist;} ?>  </div>
                </div>
                  <div class="field_row width2 float_left">

                                <div class="resume_box">

                                    <div class="filed_input float_left ">
                                        <label for="group">Resume  ( extension allowed - .pdf, .doc, .docx ) </label>
                                    </div>
                                   

                                    <?php
                                    if ($current_data[0]->clg_resume != '') {
                                        $rsm_name = $current_data[0]->clg_resume;

                                        list($rsm_file_name, $rsm_file_ext) = explode(".", $rsm_name);

                                        $rsm_file_ext_image = array("doc" => "ext_doc.png", "docx" => "ext_doc.png", "pdf" => "ext_pdf.png");

                                        $rsm_path = FCPATH . "uploads/colleague_profile/resumes/" . $rsm_name;



                                      //  $rsm_download_link = "";
                                        
                                        //var_dump($rsm_path);

                                      //  if (file_exists($rsm_path)) {
                                            $rsm_download_link = base_url() . "uploads/colleague_profile/resumes/" . $rsm_name;
                                      //  }



                                        $rsm_icon_path = base_url() . "themes/backend/images/" . $rsm_file_ext_image[$rsm_file_ext];
                                        ?>


                                        <div style="float:left;z-index:1;">
<!--                                            <a class="style1" <?php if ($rsm_name != ""): ?> href="<?php echo base_url(); ?>clg/download_rsm/<?php echo $rsm_name; ?>" <?php endif; ?> target="_blank" style="color:#000;">Download Resume</a>-->
                                            <a class="style1" <?php if ($rsm_name != ""): ?> href="<?php echo $rsm_download_link; ?>" <?php endif; ?> target="_blank" style="color:#000;">Download Resume</a>
                                        </div>

                                                <?php } ?>                       

                                </div>    

                            </div>
   <div class="field_row width2 float_left">

                <label class="strong" for="photo">Photo</label>

                <div class="field_row filter_width">

                    <div class="field_lable">

<?php if ($current_data[0]->clg_photo) { ?>

                            <div class="prev_profile_pic_box">

                                <div class="clg_photo_field edit_form_pic_box">

                                    <?php
                                    $name = $current_data[0]->clg_photo;

                                    $pic_path = FCPATH . "uploads/colleague_profile/" . $name;

                                    if (file_exists($pic_path)) {
                                        $pic_path1 = base_url() . "uploads/colleague_profile/" . $name;
                                    }
                                    $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                                    ?>

                                </div>

                            </div>

                        </div>
<?php } ?>
                    <?php if ($current_data[0]->clg_photo) { ?>

                        <a class="clg_photo float_right" target="_blank" href="<?php
    if (file_exists($pic_path)) {
        echo $pic_path1;
    } else {
        echo $blank_pic_path;
    }
    ?>"  style="background: url('<?php
                        if (file_exists($pic_path)) {
                            echo $pic_path1;
                        } else {
                            echo $blank_pic_path;
                        }
                        ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>
            <?php } ?>

                </div>
    </div>
        </div>
    </div>

</form>

