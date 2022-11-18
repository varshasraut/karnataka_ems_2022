<?php
$view = ($amb_action == 'view') ? 'disabled' : '';

if ($amb_action == 'edit') {
    $edit = 'disabled';
}

$CI = EMS_Controller::get_instance();

$title = ($amb_action == 'edit') ? " Edit Employee Schedule " : (($amb_action == 'view') ? "View Employee Schedule" : "Add Employee Schedule");
?>

<div class="register_outer_block">


    <form method="post" action="" id="manage_team">

        <div class="text_align_center" style="margin-top: 5px;">
            <h2 class="txt_clr2 width1 txt_pro hheadbg"><?php echo $title; ?></h2>
        </div>
        <!-- <h1><?php echo $title; ?></h1>    -->

        <div class="field_row width100 float_left" style="margin-top: 5px;">
            <div class="field_lable float_left width_8"><label for="group">Group<span class="md_field">*</span>:</label></div>
            <div class="filed_input float_left width_23">
                <select name="clg[clg_group]" id="crud_user_group_id" data-base="<?= @$current_data[0]->clg_ref_id ?>" class="filter_required " data-qr="output_position=parent_member&amp;module_name=clg " data-errors="{filter_required:'Group name should not be blank'}" TABINDEX="1" <?php
                                                                                                                                                                                                                                                                                        if (($clg_group1 != 'UG-SuperAdmin') && ($clg_group1 != 'UG-ShiftManager') && ($clg_group1 != 'UG-OperationHR') && ($clg_group1 != 'UG-HelpDesk')) {

                                                                                                                                                                                                                                                                                            if (@$edit) {
                                                                                                                                                                                                                                                                                                echo "disabled";
                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                        ?>>
                    <option value="">Select Group</option>
                    <?php
                    //$select_group[$current_data[0]->clg_group] = "selected = selected";
                    $select_group[$inc_emp_info[0]->user_group] = "selected = selected";

                    foreach ($group_info as $group) {
                        if (empty($edit)) {
                            if (is_array($clg_group)) {
                                if (($clg_group != $group->gparent) && !in_array($clg_group, $super_groups)) {
                                    continue;
                                }
                            }
                        }
                        //if(trim($group->gparent) != ''){ continue; }


                        echo "<option value='" . $group->gcode . "'  ";
                        echo $select_group[$group->gcode];
                        echo " >" . $group->ugname;
                        echo "</option>";

                        foreach ($group_info as $group_l1) {

                            if (trim($group->gcode) != trim($group_l1->gparent)) {
                                continue;
                            }


                            echo "<option value='" . $group_l1->gcode . "'  ";
                            echo $select_group[$group_l1->gcode];
                            echo " >&mdash; " . $group_l1->ugname;
                            echo "</option>";

                            foreach ($group_info as $group_l2) {

                                if (trim($group_l1->gcode) != trim($group_l2->gparent)) {
                                    continue;
                                }


                                echo "<option value='" . $group_l2->gcode . "'  ";
                                echo $select_group[$group_l2->gcode];
                                echo " >&mdash; &mdash; " . $group_l2->ugname;
                                echo "</option>";

                                foreach ($group_info as $group_l3) {

                                    if (trim($group_l2->gcode) != trim($group_l3->gparent)) {
                                        continue;
                                    }


                                    echo "<option value='" . $group_l3->gcode . "'  ";
                                    echo $select_group[$group_l3->gcode];
                                    echo " >&mdash; &mdash; &mdash; " . $group_l3->ugname;
                                    echo "</option>";
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div id="load_user_by_group">
                <div class="float_left width_10">
                    <p>User ID<span class="md_field">*</span> : </p>
                </div>
                <div class="width_23 float_left">
                    <!-- <div class="shift width_30 float_left "><label for="sft2">User ID</label></div>                 -->

                    <!-- <div class="shift width70 float_left"> -->

                    <input name="crud[user_id]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_all_user?shiftmanger=<?php echo $shiftmanager; ?>" data-value="<?= $inc_emp_info[0]->user_id; ?>" value="<?= $inc_emp_info[0]->user_id; ?>" type="text" tabindex="1" placeholder="User ID" data-callback-funct="show_all_user_data" id="emt_list" data-errors="{filter_required:'User ID should not be blank!'}" <?php echo $view; ?> <?php echo $edit; ?>>

                    <!-- </div> -->
                </div>
            </div>
            <div id="show_all_user_data">
                <div class="float_left width_10">
                    <p>User Name<span class="md_field">*</span> :</p>
                </div>
                <div class="width_23  float_left">
                    <!-- <div class="shift width_30 float_left">User Name<span class="md_field">*</span> : </div> -->
                    <!-- <div class="shift width70 float_left"> -->
                    <input name="crud[user_name]" tabindex="25" class="form_input filter_required" placeholder="User Name" type="text" data-base="search_btn" data-errors="{filter_required:'User Name should not be blank!'}" value="<?= $inc_emp_info[0]->user_name; ?>" <?php echo $view; ?> <?php echo $edit; ?>>

                    <!-- </div> -->
                </div>

            </div>
        </div>



        <div class="field_row width100">

            <div class="filed_select width100 add_employee">
                <div class="width2 float_left">
                    <div class="shift width_18  float_left" style="margin-top: 20px;"><label for="sft1">Schedule Type:</label></div>

                    <div class="shift width69 float_left" style="margin-left: 50px;">
                        <input name="crud[schedule_type]" tabindex="25" class="form_input filter_required" placeholder="Monthly" type="text" data-base="search_btn" data-errors="{filter_required:'Doctor Name should not be blank!'}" value="<?php if ($inc_emp_info[0]->schedule_type == 'Monthly') {
                                                                                                                                                                                                                                                    echo "Monthly";
                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                    echo "Monthly";
                                                                                                                                                                                                                                                } ?>" <?php echo $view; ?> <?php echo $edit; ?>>
                        <?php if ($amb_action == 'edit') { ?>
                            <!--                        <select name="crud[schedule_type]" id="employee_schedule_type" class="filter_required" tabindex="8"  data-errors="{filter_required:'Register Number should not blank'}" <?php echo $view; ?> <?php echo $edit; ?>> 
                            <option value="">Select Status</option>
                            <option value="daily" <?php if ($inc_emp_info[0]->schedule_type  == 'daily') {
                                                        echo "selected";
                                                    } ?>>Daily</option>
                            <option value="weekly" <?php if ($inc_emp_info[0]->schedule_type  == 'weekly') {
                                                        echo "selected";
                                                    } ?>>Weekly</option>
                            <option value="monthly" <?php if ($inc_emp_info[0]->schedule_type  == 'Monthly' || $inc_emp_info[0]->schedule_type  == 'monthly') {
                                                        echo "selected";
                                                    } ?>>Monthly</option>
                        </select>-->
                        <?php } else { ?>
                            <!--                    <select name="crud[schedule_type]" id="employee_schedule_type" class="filter_required" tabindex="8"  data-errors="{filter_required:'Register Number should not blank'}" <?php echo $view; ?> <?php echo $edit; ?>> 
                            <option value="">Select Status</option>
                            <option value="daily" <?php if ($inc_emp_info[0]->schedule_type  == 'daily') {
                                                        echo "selected";
                                                    } ?>>Daily</option>
                            <option value="weekly" <?php if ($inc_emp_info[0]->schedule_type  == 'weekly') {
                                                        echo "selected";
                                                    } ?>>Weekly</option>
                            <option value="monthly" <?php if ($inc_emp_info[0]->schedule_type  == 'monthly') {
                                                        echo "selected";
                                                    } ?>>Monthly</option>
                        </select> -->
                        <?php } ?>
                        <!-- </div> -->
                    </div>

                </div>
            </div>
            <?php if ($amb_action != 'edit') { ?>
                <div class="filed_select width100 add_employee">
                    <div class="width2 float_left" id="canlender_div_outer">
                        <div class="width_32 float_left"><label for="sft1">Month Date<span class="md_field">*</span>:</label></div>

                        <div class="width80 float_left" style="padding-left: 60px;">
                            <input name="schedule_date" class="filter_required month-picker" value="<?php echo $details->amb_rto_register_no; ?>" type="text" tabindex="1" placeholder="Month Date" data-errors="{filter_required:'Month Date should not be blank'}" style="position: relative;" id="add_team_monthly_date">
                            <!--    <div class="month-picker"></div>-->

                        </div>

                    </div>
                </div>
                <div id="team_listing_block">
                </div>
            <?php } ?>
            <?php if ($amb_action == 'edit') { ?>
                <div class="filed_select width100">

                    <div class="width50 float_left">
                        <!-- <div class="width90 float_left">
                        <div class=" float_left">Schedule Date : </div>
                    </div> -->
                        <div class="width100 float_left">
                            <?php
                            foreach ($shift_schedule as $schedule) { ?>
                                <input style="padding: 5px;margin-bottom: 10px;" name="schedule_date[]" tabindex="2" class="form_input filter_required" placeholder="Schedule Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" readonly="readonly" id="" value="<?php echo $schedule->schedule_date; ?>" <?php echo $view; ?>>
                            <?php  } ?>
                        </div>
                    </div>
                    <div class="width50 float_left">
                        <!-- <div class="width90 float_left">
                        <div class="float_left">Date: </div>
                    </div> -->
                        <div class="width100 float_left">
                            <?php
                            foreach ($shift_schedule as $schedule) {
                                //echo '<option name="shift_value" class="form_input filter_required" placeholder="Shift" type="text"';
                                //echo  'value='.$schedule->shift_value.'>'; 
                            ?>
                                <input type="hidden" name=map_id[] value=<?php echo $schedule->map_id; ?>>
                                <select name="shift_value[]" class="" tabindex="8" data-errors="{filter_required:'Register Number should not blank'}" <?php echo $view; ?> <?php //echo $edit; 
                                                                                                                                                                            ?>>
                                    <option value="">Select Shift</option>
                                    <?php
                                    foreach ($shift_info as $shift) {
                                        if ($shift->shift_code  == $schedule->shift_value) {
                                            $selected =  "selected";
                                        } else {
                                            $selected =  "";
                                        }
                                        echo "<option " . $selected . " value='" . $shift->shift_code . "'  ";
                                        echo " > " . $shift->shift_name;
                                        echo "</option>";
                                    }
                                    ?>

                                </select>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            <?php } ?>
            <div class="filed_select width100">
                <div class="width50 float_left">
                    <div class="width_30 float_left">
                        <!-- <div class="float_left">Supervisor Name: </div> -->
                        <p>Supervisor Name<span class="md_field">*</span> : </p>
                    </div>
                    <div class="width69 float_left">
                        <!--                        <input name="crud[ero_supervisor]" tabindex="1" class="form_input filter_required" placeholder="ERO-Supervisor Name" type="text" data-base="search_btn" data-errors="{filter_required:'ERO-Supervisor Name should not be blank!'}" value="<?= $inc_emp_info[0]->ero_supervisor; ?>" <?php echo $view; ?> <?php echo $edit; ?>>-->
                        <input name="crud[ero_supervisor]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_auto_clg?clg_group=UG-EROSupervisor" data-value="<?= $inc_emp_info[0]->ero_supervisor; ?>" value="<?= $inc_emp_info[0]->user_id; ?>" type="text" tabindex="1" placeholder="ERO-Supervisor Name" data-errors="{filter_required:'ERO-Supervisor Name should not be blank!'}" <?php echo $view; ?> <?php echo $edit; ?> data-qr='clg_group=UG-EROSupervisor&amp;output_position=content'>
                    </div>
                </div>
                <div class="width50 float_left">
                    <div class="width_32 float_left">
                        <!-- <div class=" float_left">Shift-Manager Name: </div> -->
                        <p>Shift-Manager Name<span class="md_field">*</span> : </p>
                    </div>
                    <div class="width69 float_left" style="padding-left: 4px;">
                        <!--                        <input name="crud[shift_supervisor]" tabindex="2" class="form_input filter_required" placeholder="Shift-Manager Name" type="text" data-base="search_btn" data-errors="{filter_required:'Shift-Manager Name should not be blank!'}" value="<?= $inc_emp_info[0]->shift_supervisor; ?>" <?php echo $view; ?> <?php echo $edit; ?>>-->
                        <input name="crud[shift_supervisor]" class="mi_autocomplete filter_required" data-href="<?php echo base_url(); ?>auto/get_shiftmanager_data" data-value="<?= $inc_emp_info[0]->shift_supervisor; ?>" value="<?= $inc_emp_info[0]->user_id; ?>" type="text" tabindex="1" placeholder="Shift Manager" data-errors="{filter_required:'Shift-Manager should not be blank!'}" <?php echo $view; ?> <?php echo $edit; ?>>
                    </div>
                </div>
            </div>
            <div class="filed_select width100">
                <div class="width50 float_left">
                    <div class="width_30 float_left">
                        <div class="float_left">Remark: </div>
                    </div>
                    <div class="width69 float_left">
                        <input name="crud[remark]" tabindex="1" class="form_input " placeholder="Remark" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!'}" value="<?= $inc_emp_info[0]->remark; ?>" <?php echo $view; ?> <?php echo $edit; ?>>
                    </div>
                </div>
            </div>

            <div class="field_row width100">
                <div class="width100 margin_auto">
                    <div class="button_field_row">
                        <div class="button_box text_center">
                            <!--                            <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>schedule_crud/save_crud' data-qr='page_no=<?php echo @$page_no; ?>&amp;output_position=content' >-->
                            <input type="reset" name="reset" value="Reset" class="btn reset_btn register_view_reset">

                            <input type="button" name="submit" value="Submit" class="btn submit_btnt form-xhttp-request" data-href='<?php echo base_url(); ?>schedule_crud/<?php if ($inc_emp_info) { ?>edit_crud<?php } else { ?>save_crud<?php } ?>' data-qr='schedule_id=<?php echo $inc_emp_info[0]->sc_cr_id; ?>&amp;page_no=<?php echo $page_no; ?>&amp;output_position=content' TABINDEX="12">
                        </div>
                    </div>
                </div>
            </div>

    </form>
</div>

<script>
    ;
    jQuery(document).ready(function() {

        var dateFormat = "mm/dd/yy",
            from = jQuery("#from_date")
            .datepicker({
                defaultDate: new Date(),
                changeMonth: true,
                numberOfMonths: 1
            })
            .on("change", function() {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = jQuery("#to_date").datepicker({
                defaultDate: new Date(),
                changeMonth: true,
                numberOfMonths: 1
            })
            .on("change", function() {
                from.datepicker("option", "maxDate", getDate(this));
            });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }
            return date;
        }
    });
</script>

<script type="text/javascript">
    //$( ".month-picker" ).datepicker("destroy");
    $('.month-picker').MonthPicker({
        MinMonth: 0,
        ShowIcon: false
    });
</script>