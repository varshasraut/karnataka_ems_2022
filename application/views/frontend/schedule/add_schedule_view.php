<?php
$view = ($schedule_action == 'view') ? 'disabled' : '';

$CI = EMS_Controller::get_instance();
$title = ($schedule_action == 'edit') ? " Edit Schedule Details " : (($schedule_action == 'view') ? "View Schedule Details" : "Add Schedule Details");
?>



<div class="register_outer_block" style="position: relative;">

    <div class="box3">

        <form enctype="multipart/form-data" action="#" method="post" id="usr_ad_form">
            <div class="width1 float_left ">

                <h2 class="txt_clr2"><?php echo $title; ?></h2>

                <div class="store_details_box">

                    <div class="width2 float_left">

                    <div class="width100 float_left">
                        <div class="field_row width2 float_left">

                            <div class="field_lable"><label for="schedule_date">schedule date<span class="md_field">*</span></label></div>

                            <div class="filed_input">
                                <?php $date = date('d-m-Y', strtotime(date('d-m-Y'))); ?>
								<input id="schedule_date" type="text" name="schedule_date" class="mi_calender filter_required"   data-errors="{filter_required:'schedule date should not be blank'}" value="<?=@$update[0]->schedule_date ?>" TABINDEX="11"  <?php echo $view; ?> placeholder="schedule date">
                            </div>
                        </div>  
                         <div class="field_row width2 float_left">

                            <div class="field_lable"><label for="schedule_time">Schedule Time<span class="md_field">*</span></label></div>   

                            <div class="field_input">
								<input id="schedule_time" type="text" name="schedule_time" class="filter_required controls mi_timepicker"  data-errors="{filter_required:'schedule time should not be blank'}" value="<?=@$update[0]->schedule_time ?>"<?php echo $view; ?> placeholder="Schedule time" TABINDEX="1">                                
                            </div>

                        </div>  
                    </div>
					<div class="field_row">
                           <div class="field_lable"><label for="schedule_clusterid">Cluster<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <input  name="schedule_clusterid" value="<?=@$update[0]->schedule_clusterid;?>" class="mi_autocomplete width99 filter_required" data-href="{base_url}auto/get_auto_cluster_by_user" data-base="" tabindex="7" data-value="<?php echo $update[0]->cluster_name; ?>" data-nonedit="yes" readonly="readonly" data-errors="{filter_required:'Cluster should not be blank'}" data-callback-funct="cluster_schools_list" id="clusterid" <?php echo $view; ?>>
                            </div>
					</div>

                    </div>  
					<div class="width2 float_right">
                       
                        <div class="field_row">

                            <div class="field_lable"><label for="schedule_type">Schedule Type<span class="md_field">*</span></label></div>   

                            <div class="field_input">
                                <select name="schedule_type" class="filter_required" data-errors="{filter_required:'Schedule type should not be blank'}" <?php echo $view; ?> TABINDEX="5">
                                    <option value="">Select Schedule type</option>
                                    <option value="2" <?php if($update[0]->schedule_type == '2'){ echo "selected";};?>>Screening Schedule</option>
                                    <option value="1" <?php if($update[0]->schedule_type == '1'){ echo "selected";};?>>Preventive Health Schedule</option>
                                    <option value="3" <?php if($update[0]->schedule_type == '3'){ echo "selected";};?>>Holiday Schedule</option>
                                    
                                    
                                </select>
                            </div>

                        </div>  
                        <div class="field_row" >

                            <div class="field_lable"><label for="schedule_schoolid">School Name<span class="md_field">*</span></label></div>   

                            <div class="field_input" id="schedule_clusterid">
                                <select name="schedule_schoolid" class="filter_required" data-errors="{filter_required:'School should not be blank'}" <?php echo $view; ?> TABINDEX="5">

                                    <option value="">Select School</option>

                                    <?php echo get_school_type($update[0]->school_name); ?>
                                </select>
                            </div>

						</div>

					</div>
                    <div id="student_check_list">
                        
                    </div>

                <?php if (!(@$schedule_action == 'view')) { ?>

                    <div class="width25 margin_auto" style="clear:both;">
                        <div class="button_field_row">
                            <div class="button_box">

                                <input type="hidden" name="submit_schedule" value="schedule_registration" />

                                <input type="button" name="submit" value="Submit" class="form-xhttp-request" data-href='{base_url}schedule/<?php if ($update) { ?>edit_schedule<?php } else { ?>add_schedule<?php } ?>' data-qr='schedule_id[0]=<?php echo base64_encode($update[0]->schedule_id); ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">

                                <input type="reset" name="reset" value="Reset" class="reset_btn" TABINDEX="13">
                            </div>
                        </div>
                    </div>

                <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>