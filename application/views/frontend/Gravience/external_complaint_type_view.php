
<input type="hidden" name="gri[gc_inc_call_type]"  value="<?= @$gc_inc_call_type; ?>"   >


<div class="field_row width100">
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Date & Time <span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">



            <input name="gri[gc_date_time]" tabindex="20" class="form_input mi_cur_timecalender filter_required" placeholder="Start Date / Time" type="text"  data-errors="{filter_required:'Start Date / Time should not be blank!'}" value="<?= @$cl_dtl[0]->cl_datetime; ?>"   <?php echo $update; ?>>

        </div>


    </div>
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Caller Number<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">
            
           

            <input   type="text" name="gri[gc_caller_number]" placholder="Complaint Register No" class="form_input filter_if_not_blank filter_number filter_minlength[9] filter_maxlength[11]"   data-errors="{filter_number:'Caller number should be in numeric characters only.', filter_minlength:'Caller number should be at least 10 digits long',filter_maxlength:'Caller number should less then 11 digits.'}" value="<?= @$cl_dtl[0]->clr_mobile ?>" TABINDEX="1">



        </div>


    </div>

    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Caller Name<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="gri[gc_caller_name]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$cl_dtl[0]->clr_fname ?>" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>


    </div>
</div>
<div class="field_row width100">
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">District <span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">
            <div id="maintaince_district">
                <?php
                if (@$cl_dtl[0]->gc_district_code != '') {
                    $dt = array('dst_code' => $cl_dtl[0]->inc_district_id, 'st_code' => 'MP', 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');
                } else {
                    $dt = array('dst_code' => '', 'st_code' => 'MP', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');
                }

                echo get_district_closer_amb_gri($dt);
                ?>
            </div>
        </div>


    </div>
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Ambulance Number</label></div>

        <div class="filed_input float_left width50">
            <div id="maintaince_ambulance">



                <?php
                if ($amb_reg_id != '') {
                    $dt = array('dst_code' => @$cl_dtl[0]->inc_district_id, 'st_code' => 'MP', 'amb_ref_no' => @$cl_dtl[0]->gc_ambulance_no, 'auto' => 'inc_auto_addr', 'rel' => 'maintaince', 'disabled' => 'disabled');

                    echo get_break_maintaince_ambulance($dt);
                } else {
                    $dt = array('dst_code' => '', 'st_code' => '', 'auto' => 'amb_auto_addr', 'rel' => 'maintaince', 'disabled' => '');

                    echo get_clo_comp_ambulance($dt);
                }
                ?>

            </div>
        </div>


    </div>

    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Incident Number</label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="gri[gc_pre_inc_ref_id]"  placholder="Complaint Register No" value="<?= @$cl_dtl[0]->inc_ref_id ?>" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>


    </div>
</div>
<div class="field_row width100">
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Patient Name</label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="gri[gc_ptn_name]"  placholder="Call Receiver Name"  value="<?= @$pt_info[0]->ptn_fname ?>" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>


    </div>
    <!--    <div class="width33 float_left">   
            <div class=" blue float_left width33">Chief Complaint</div>
            <div class="input  top_left float_left width50" >
                <input type="text" name="gri[gc_chief_complaint]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete "  data-href="{base_url}auto/get_chief_complete"  placeholder="Chief Complaint" TABINDEX="8" <?php echo $autofocus; ?>>
            </div>
        </div>-->

    <!--<div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Grievance type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input type="text" name="gri[gc_grievance_type]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required"  data-errors="{filter_required:'Grievance type should not be blank'}"  data-href="{base_url}auto/get_grievance_type"  placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>>

        </div>


    </div>
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Grievance Sub-type <span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input type="text" name="gri[gc_grievance_sub_type]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_grievance_sub_type"  data-errors="{filter_required:'District should not be blank'}" placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>>

        </div>


    </div>-->
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Grievance Type<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input type="text" name="gri[gc_grievance_type]" id="Gri_sub_type" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required" data-errors="{filter_required:'Grievance type should not be blank'}"  data-href="{base_url}auto/get_grievance_type"  data-callback-funct="show_sub_type_gri" placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>>

        </div>


    </div>
    <div class="width33 float_left" id="gri_sub_type">
        <div class="filed_lable float_left width33"><label for="station_name">Grievance Sub-Type <span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <!--<input type="text" name="gri[gc_grievance_sub_type]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required" data-errors="{filter_required:'Grievance Sub-type should not be blank'}"  data-href="{base_url}auto/get_grievance_sub_type"  placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>>
            -->
            <input type="text" name="gri[gc_grievance_sub_type]" id="chief_complete" data-value="<?= @$inc_details['chief_complete']; ?>" value="<?= @$inc_details['chief_complete_id']; ?>" class="mi_autocomplete filter_required" data-errors="{filter_required:'Grievance Sub-type should not be blank'}"   placeholder="Grievance type" TABINDEX="8" <?php echo $autofocus; ?>>
        </div>


    </div>
</div>
<div class="field_row width100">

    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Grievance Details<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="gri[gc_grievance_details]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>


    </div>

    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">EMT Name</label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="gri[gc_emso_name]" class="mi_autocomplete" placholder="Complaint Register No"  value="<?= @$inc_amb[0]->amb_emt_id ?>" data-href="{base_url}auto/get_emp" TABINDEX="1" data-callback-funct="show_emso_name" id="emso_name" <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>


    </div>
    <div class="width33 float_left" id="emt_other_textbox">
    </div>
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Pilot Name </label></div>

        <div class="filed_input float_left width50">


            <input   type="text" name="gri[gc_pilot_name]" class="mi_autocomplete" placholder="Complaint Register No"  value="<?= @$inc_amb[0]->amb_pilot_id ?>" data-href="{base_url}auto/get_clg_pilot" data-callback-funct="show_pilot_name" id="pilot_name" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >

        </div>


    </div>
    <div class="width33 float_left" id="pilot_other_textbox">
    </div>
</div>

<div class="field_row width100">

    <!--    <div class="width33 float_left">
            <div class="filed_lable float_left width33"><label for="station_name">Complaint register by<span class="md_field">*</span></label></div>
    
            <div class="filed_input float_left width50">
    
                <input   type="text" name="gri[gc_complaint_register_by]" class="filter_required" placholder="Complaint Register No" data-errors="{filter_required:'Station name should not be blank'}" value="<?= @$inc_amb[0]->police_station_name ?>" TABINDEX="1"  <?php
    echo $view;
    if (@$update) {
        echo"disabled";
    }
    ?> >
    
            </div>
    
    
        </div>-->

    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Standard Remark<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">


            <select name="gri[gc_standard_remark]" tabindex="8"  class="filter_required" data-errors="{filter_required:'Standard Remark should not be blank!'}"   <?php echo $update; ?>> 
                <option value="" <?php echo $disabled; ?>>Select Standard Remark</option>
                <option value="complaint_register"  <?php
                if ($grievance_data[0]->gc_standard_remark == 'complaint_register') {
                    echo "selected";
                }
                ?> >Complaint Register Sucessfully </option>
            </select>

        </div>
    </div>
        <div class="width33 float_left">
            <div class="filed_lable float_left width33"><label for="station_name">Grievance Remark<span class="md_field">*</span></label></div>

            <div class="filed_input float_left width50">

                <input   type="text" name="gri[gc_remark]" class="filter_required" placholder="Grievance remark" data-errors="{filter_required:'Grievance remark should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
                echo $view;
                if (@$update) {
                    echo"disabled";
                }
                ?> >
            </div>
        </div>
        <?php if($comp_type == 'e-complaint'){
        ?>
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">E-Complaint No<span class="md_field">*</span></label></div>

        <div class="filed_input float_left width50">

            <input   type="text" name="gri[gc_e_complaint_no]" class="filter_required" placholder="Enter E-Complaint No" data-errors="{filter_required:'Ecomplaint No should not be blank'}" value="<?= @$police_station[0]->police_station_name ?>" TABINDEX="1"  <?php
            echo $view;
            if (@$update) {
                echo"disabled";
            }
            ?> >
        </div>
    </div>
    <?php }
    ?>
    </div>
    <div class="field_row width100">
    <div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Document(extension allowed-.pdf,.doc,.docx)<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50">
        <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="file" name="gri_doc[]" TABINDEX="18" style="float: left;"  <?php echo $view; ?> class="file_clg" multiple="multiple" >
        <?php
        if (@$update && !$view && $current_data[0]->gri_doc != '') {
        $rsm_name = $current_data[0]->gri_doc;
   

        list($rsm_file_name, $rsm_file_ext) = explode(".", $rsm_name);

        $rsm_file_ext_image = array("doc" => "ext_doc.png", "docx" => "ext_doc.png", "pdf" => "ext_pdf.png");

        $rsm_path = FCPATH . "uploads/colleague_profile/resumes/" . $rsm_name;

        $rsm_download_link = base_url() . "uploads/colleague_profile/resumes/" . $rsm_name;
        
        $rsm_icon_path = base_url() . "themes/backend/images/" . $rsm_file_ext_image[$rsm_file_ext];
        ?>
        <div style="float:left;z-index:1;">
            <a class="style1" <?php if ($rsm_name != ""): ?> href="<?php echo $rsm_download_link; ?>" <?php endif; ?> target="_blank" style="color:#000;">Download Resume</a>
        </div>
        <?php } ?>  
        </div>
    </div>

    <!--<div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Photo Upload<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50">
        <div class="field_row filter_width">

<div class="field_lable">

<?php if (@$update) { ?>

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

</div>
<div class="filed_input outer_clg_photo">
<input type="hidden" name="prev_photo" value="<?= @$current_data[0]->clg_photo ?>" />
<input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="grievance_photo" type="file" name="grievance_photo" accept="image/jpg,image/jpeg" TABINDEX="18"  <?php echo $view; ?>>

<?php if ($update) { ?>

<div class="clg_photo float_right" style="background: url('<?php
if (file_exists($pic_path)) {
echo $pic_path1;
} else {
echo $blank_pic_path;
}
?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></div>


<?php } ?>

</div>
        </div>
    </div>-->
</div>
<div class="field_row width100">
<div class="width33 float_left">
        <div class="filed_lable float_left width33"><label for="station_name">Photo Upload<span class="md_field">*</span></label></div>
        <div class="filed_input float_left width50">
        <div class="field_row width100 float_left">
	<div class="field_row width100 float_left">
		<div class="field_row filter_width width100">
			<div class="field_lable">
			<?php 	
					if (@$update) 
					{ 
			?>
						<div class="prev_profile_pic_box">
						<div class="clg_photo_field edit_form_pic_box">
						<?php
                            $name = $preventive[0]->mt_amb_photo;
							$pic_path = FCPATH . "uploads/ambulance/" . $name;
							if (file_exists($pic_path)) 
							{
                                $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                            }
                            $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
                        ?>
						</div>
						</div>
				<?php 
					} 
				?>
			</div>
        </div>
    </div>
    <div class="filed_input outer_clg_photo width100">
        
        <div class="images_main_block width1" id="images_main_block">
            <div class="upload_images_block">
                <div class="images_upload_block">
                
                    <input type="file" name="grievance_photo[]" accept="image/jpg,image/jpeg,image/png" TABINDEX="18"    class="files_amb_photo" multiple="multiple">
				</div>
            </div>
        </div>
          <?php if ($media) {
            foreach($media as $img) {
                $name = $img->media_name;
                $pic_path = FCPATH . "uploads/ambulance/" . $name;
				if (file_exists($pic_path)) {
                    $pic_path1 = base_url() . "uploads/ambulance/" . $name;
                }
                $blank_pic_path = base_url() . "themes/backend/images/blank_profile_pic.png";
            ?>
			<div class="images_block" id="image_<?php echo $img->id;?>">
            <?php 
            if($approve != 'disabled' && $rerequest != 'disabled' && $update != 'disabled' ){ ?>
            <a class="remove_images click-xhttp-request" style="color:#000;" data-href="<?php echo base_url();?>ambulance_maintaince/remove_images" data-qr="id=<?php echo $img->id; ?>&output_position=image_<?php echo $img->id;?>"></a>
            <?php } ?>
            <a class="ambulance_photo float_left" target="blank" href="<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
            echo $blank_pic_path;
            }
            ?>" style="background: url('<?php
            if (file_exists($pic_path)) {
                echo $pic_path1;
            } else {
                echo $blank_pic_path;
            }
            ?>') no-repeat left center; background-size: cover; min-height: 75px;"  <?php echo $view; ?>></a>

			</div>

        <?php } } ?>
	</div>
</div>
        </div>
</div>
</div>
</div>

<div class="field_row width100">

    <!--
        <div class="width33 float_left">
            <div class="filed_lable float_left width33"><label for="station_name">Status<span class="md_field">*</span></label></div>
    
            <div class="filed_input float_left width50">
    
    
                <select name="gri[gc_closure_status]" tabindex="8" id="standard_remark" class="filter_required" data-errors="{filter_required:'Status should not be blank!'}"   <?php echo $update; ?>> 
                    <option value="" <?php echo $disabled; ?>>Select Status</option>
                    <option value="complaint_open"  <?php
    if ($grievance_data[0]->gc_closure_status == 'complaint_open') {
        echo "selected";
    }
    ?>  >Complaint Open </option>
    
    
                </select>
    
            </div>
    
    
        </div>-->

</div>

<div class="save_btn_wrapper">
    <input name="save_btn" value="SUBMIT" class="style5 form-xhttp-request" data-href="{base_url}grievance/save_call" data-qr="" type="button" tabindex="16">
    <a class="click-xhttp-request ercp_dash" data-href="{base_url}ercp" data-qr="output_position=content"></a>
</div>
