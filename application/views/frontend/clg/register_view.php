<div id="dublicate_id"></div>

<?php
if (@$view_clg == 'view') {
    $view = 'disabled';
}
?>
<script>
//        $('.mi_calender_new').datepicker( "destroy" );
//        $('.mi_calender_new').datepicker({
//            changeMonth: true,
//            changeYear: true,
//            showAnim: 'slideDown',
//            dateFormat: 'dd-mm-yy',
//            yearRange: "-100:+10"
//        });
//        $('.mi_calender_new').datepicker( "fast" );
</script>
<form enctype="multipart/form-data" action="#" method="post" id="add_colleague_registration_form">
    <div class="width1">
        <h2 class="txt_clr2 width1 txt_pro hheadbg"><?php
            if ($action_type) {
                echo $action_type;
            }
            ?></h2>
        <div class="joining_details_box">
            <div class="width100">

                <h3 class="txt_clr2 reg_title">Joining Details</h3>

                <div class="field_row">

                    <div class="field_lable float_left width_10"><label for="group">Group<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width_23">
                        <?php if($current_data[0]->clg_group == 'UG-PILOT'){
                            $current_data[0]->clg_group = 'UG-Pilot';
                        } ?>
                        <select  name="clg[clg_group]" id="user_group_id" data-base="<?= @$current_data[0]->clg_ref_id ?>"  class="filter_required "  data-qr="output_position=parent_member&amp;module_name=clg " data-errors="{filter_required:'Group name should not blank'}" TABINDEX="1"  <?php
                                               if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')  && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR')){

                        if (@$update) {
                            echo"disabled";
                        }}
                        ?>>
                            <option value="">Select Group</option>
                            <?php
                            $select_group[$current_data[0]->clg_group] = "selected = selected";


                            foreach ($group_info as $group) {
                                if (empty($update)) {
                                    if (($clg_group != $group->gparent) && !in_array($clg_group, $super_groups)) {
                                        continue;
                                    }
                                }
                                //if(trim($group->gparent) != ''){ continue; }


                                echo "<option value='" . $group->gcode . "'  ";
                                echo $select_group[$group->gcode];
                                echo" >" . $group->ugname;
                                echo "</option>";

                                foreach ($group_info as $group_l1) {

                                    if (trim($group->gcode) != trim($group_l1->gparent)) {
                                        continue;
                                    }


                                    echo "<option value='" . $group_l1->gcode . "'  ";
                                    echo $select_group[$group_l1->gcode];
                                    echo" >&mdash; " . $group_l1->ugname;
                                    echo "</option>";

                                    foreach ($group_info as $group_l2) {

                                        if (trim($group_l1->gcode) != trim($group_l2->gparent)) {
                                            continue;
                                        }


                                        echo "<option value='" . $group_l2->gcode . "'  ";
                                        echo $select_group[$group_l2->gcode];
                                        echo" >&mdash; &mdash; " . $group_l2->ugname;
                                        echo "</option>";

                                        foreach ($group_info as $group_l3) {

                                            if (trim($group_l2->gcode) != trim($group_l3->gparent)) {
                                                continue;
                                            }


                                            echo "<option value='" . $group_l3->gcode . "'  ";
                                            echo $select_group[$group_l3->gcode];
                                            echo" >&mdash; &mdash; &mdash; " . $group_l3->ugname;
                                            echo "</option>";
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="field_lable float_left width_10"><label for="ref_id">User ID<span class="md_field">*</span></label></div>
                    <div id="clg_user_id">
                        <div class="field_input float_left width_23">

                            <input id="clg_ref_id" type="text" name="clg[clg_ref_id]" class="<?php if (!$update) { ?>filter_required filter_string filter_is_exists<?php } ?>" data-errors="{filter_required:'Reference Id should not be blank', filter_string:'Invalid characters in Reference Id',filter_is_exists:'Reference Id already exists'}" data-base="<?= @$current_data[0]->clg_ref_id ?>" value="<?= @$current_data[0]->clg_ref_id ?>" TABINDEX="2" <?php
                                                  // if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')  && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR')){
if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR')  ){
                            if (@$update) {
                                echo"disabled";
                            }}
                            ?> data-exists="no"  <?php if(( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR')){ ?>readonly="readonly" <?php } ?>>

<?php if ($update) { ?>  

                                <input type="hidden" name="clg[clg_ref_id]" id="ud_clg_id" value="<?= @$current_data[0]->clg_ref_id ?>">

<?php } ?>

                        </div>
                    </div>
                    <div class="field_lable float_left width_10"><label for="joining_date">Joining Date<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_23">
                        <?php //var_dump($current_data[0]->clg_joining_date);?>

                        <input id="joining_date" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" value="<?php if($current_data[0]->clg_joining_date != '' && $current_data[0]->clg_joining_date != '0000-00-00' && $current_data[0]->clg_joining_date != '1970-01-01'){ echo date('d-m-Y', strtotime($current_data[0]->clg_joining_date)); } ?>" name="clg[clg_joining_date]" class="datepicker filter_required" data-errors="{filter_required:'Joining date should not be blank'}" TABINDEX="2" readonly="readonly" <?php
 if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-OP-HEAD') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')  && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
echo $view;
if (@$update) {
    echo"disabled";
}}
?>>
                    </div>


                </div>

                <div class="field_row width100">

                    <div class="filed_row" id="clg_avaya_agentid">
                        <?php if($current_data[0]->clg_group == 'UG-EMT' || $current_data[0]->clg_group == 'UG-Pilot'){?>
                        
                         <div class="field_lable float_left width_10"><label for="email">JAES EMP ID<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width_23">
                           

                            <input  type="text" data-base="<?= @$current_data[0]->clg_ref_id ?>"  name="clg[clg_jaesemp_id]" class="filter_required filter_minlength[5]"  maxlength="15" data-errors="{filter_required:'JAES EMP ID should not be blank',filter_minlength:'JAES EMP ID at min 5 digit long.'}" value="<?= @$current_data[0]->clg_jaesemp_id ?>" TABINDEX=""  <?php
 if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-OP-HEAD') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')  && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
echo $view;
if (@$update) {
    echo"disabled";
}}
?>>
                        </div>
                        <?php
                            
                        }else{?>
                        <div class="field_lable float_left width_10"><label for="email">Ameyo ID<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width_23">

                            <input  type="text" data-base="<?= @$current_data[0]->clg_ref_id ?>"  name="clg[clg_avaya_agentid]" class="filter_required"  data-errors="{filter_required:'Avaya should not be blank'}" value="<?= @$current_data[0]->clg_avaya_agentid ?>" TABINDEX="6"  <?php
 if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')  && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
echo $view;
if (@$update) {
    echo"disabled";
}}
?>>
                        </div>
                        <?php } ?>
                    </div>

                    <div id="senior_team_member">

                                    <?php 
                                    
                                    if($get_parent){
                                   // if ($current_data[0]->clg_senior != '') {
                                        
                                    ?>
                            <div class="filed_row">
                                <div class="field_lable float_left width_10"><label for="clg_senior">Select Supervisor</label></div>

                                <div class="filed_input float_left width_23">
                                    <select id="group" name="clg[clg_senior]" data-base="<?= @$current_data[0]->clg_ref_id ?>"  data-errors="{filter_required:'Parent Team Member should not blank'}" TABINDEX="7"  
                                    <?php echo $view;
                                    if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk')  && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
                                    if (@$update) {
                                    echo"disabled";
                                    } } ?>>

                                        <option value="">Select Parent Team Member</option>


                                            <?php
                                            if (count($get_parent) > 0) {

                                                foreach ($get_parent as $team_member) {
                                                    $select_group[$current_data[0]->clg_senior] = "selected = selected";
                                                    ?>

                                                <option value="<?php echo $team_member->clg_ref_id; ?>" <?php echo $select_group[$team_member->clg_ref_id]; ?>><?php echo $team_member->clg_first_name . " " . $team_member->clg_last_name;
                                                    ;
                                                    ?></option>

        <?php
        }
    }
    ?>
                                    </select>
                                </div>
                            </div>
                                    <?php //} 
                                    
                                                } ?>

                    </div>

                </div>




            </div>
        </div>

        <div class="joining_details_box">
            <h3 class="txt_clr2 reg_title">Personal Details</h3>
            <div>


                <div class="field_row width100">

                    <div class="filed_lable float_left width_10"><label for="first_name">First Name<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_23">
                      
                        

                        <input id="first_name" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_first_name]" class="filter_required"  data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$current_data[0]->clg_first_name ?>" TABINDEX="7"  <?php
                               echo $view;
                               if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk') && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
                               if (@$update) {
                                   echo"disabled";
                               }}
                               ?> >

                    </div>
                    <div class="field_lable float_left width_10"> <label for="middle_name">Middle Name</label></div>

                    <div class="filed_input float_left width_23">

                    <input id="middle_name" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_mid_name]" class="filter_if_not_blank" data-errors="{filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?= @$current_data[0]->clg_mid_name ?>" TABINDEX="8"   <?php
                               echo $view;
                               if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk') && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
                               if (@$update) {
                                   echo"disabled";
                               }}
                               ?>>

                    </div>
                    <div class="field_lable float_left width_10"><label for="last_name">Last Name</label></div>

                    <div class="filed_input float_left width_23">

                        <input id="last_name" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_last_name]" class=""  data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$current_data[0]->clg_last_name ?>" TABINDEX="9"   <?php
                               echo $view;
                               if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk') && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
                               if (@$update) {
                                   echo"disabled";
                               }}
                               ?>>

                    </div>

                </div>


                <div class="field_row width100">


                    <div class="field_lable float_left width_10"> <label for="mobile_no">Mobile No<span class="md_field">*</span></label></div>


                    <div class="filed_input float_left width_23">
                        <div id="mobile_error"></div>
                        <input id="clg_mobile_no" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_mobile_no]" class="filter_required filter_number filter_minlength[9] filter_maxlength[11] filter_no_whitespace"  data-errors="{filter_required:'Mobile number should not be blank', filter_number:'Mobile number should be in numeric characters only', filter_minlength:'Mobile number should be at least 10 digits long', filter_maxlength:'Mobile number should less then 11 digits.', filter_no_whitespace:'No spaces allowed'}" value="<?= @$current_data[0]->clg_mobile_no ?>" TABINDEX="10"  <?php echo $view; ?>>
                    </div>


                    <div class="field_lable float_left width_10"><label for="dob">Date of Birth<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_23">

<?php $date = date('d-m-Y', strtotime(date('d-m-Y') . " - 18 year")); ?>


                        <input id="dob" type="text" name="clg[clg_dob]" class="datepicker filter_required filter_lessthan[<?php echo $date; ?>]" data-base="<?= @$current_data[0]->clg_ref_id ?>"  data-errors="{filter_required:'Date of birth should not be blank', filter_lower_date:'Birth date is less than today',filter_lessthan:'Colleague must be 18 years old.'}" value="<?php if($current_data[0]->clg_dob != '' || $current_data[0]->clg_dob != ''){ echo $current_data[0]->clg_dob;} ?>" TABINDEX="11"  <?php echo $view; ?> readonly="readonly">

                    </div>
                    <div class="field_lable float_left width_10"><label for="city">City<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_23">
                        <input id="pac-input"  data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_city]" data-href="" value="<?= @$current_data[0]->clg_city ?>" class="<?php echo(!$update) ? "filter_required" : ""; ?> controls" data-activeerror="" data-errors="{filter_required:'City should not be blank!'}" TABINDEX="13" placeholder=""  <?php echo $view; ?>>
                        <div id="result"><table id="sugg"></table></div>
                    </div>
                </div>
                <div class="field_row width100">
                    <div class="field_lable float_left width_10"><label for="city">Gender<span class="md_field">*</span></label></div>

                    <div class="filed_input float_left width_23">

<?php $gender[@$current_data[0]->clg_gender] = "selected=selected"; ?>   

                        <select id="filter_dropdown"  name="clg[clg_gender]" class="add_clg_sts filter_required" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;flt=true" <?php echo $view; ?> data-errors="{filter_required:'Gender should not be blank!'}">

                            <option value="" >Select Gender</option>

                            <option value="male" <?php echo $gender['male']; ?>>Male</option>

                            <option value="female" <?php echo $gender['female']; ?>>Female</option>

                        </select>
                    </div>


                    <div class="field_lable float_left width_10"><label for="email">Email<span class="md_field"></span></label></div>

                    <div class="filed_input float_left width_23">

                        <input id="clg_email" type="text" data-base="<?= @$current_data[0]->clg_ref_id ?>"  name="clg[clg_email]" class="filter_email no_ucfirst"  data-errors="{ filter_email:'Please enter a valid email'}" value="<?= @$current_data[0]->clg_email ?>" TABINDEX="6"  <?php echo $view; ?> data-exists="no" >


                    </div>
                    <div class=" material_sts">

                    <div class="field_row">

<?php // if (@$update == 'true' && $current_data[0]->clg_group == 'UG-SuperAdmin') {  ?>


<?php if ((@$update == 'true' && $clg_group1 == 'UG-SuperAdmin') || (@$update == 'true' && $clg_group1 == 'UG-ShiftManager')) { ?>

                            <div class="field_lable float_left width_10"><label for="city">Status<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width_23">

    <?php $selected[@$current_data[0]->clg_is_active] = "selected=selected"; ?>   

                                <select id="filter_dropdown"  name="clg[clg_is_active]" class="add_clg_sts" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;flt=true" <?php echo $view; ?>>

                                    <option value="" >Select Status</option>

                                    <option value="1" <?php echo $selected['1']; ?>>Active</option>

                                    <option value="0" <?php echo $selected['0']; ?>>Inactive</option>



                                </select>
                            </div>


<?php } ?>
                    </div>

                    <div class="field_row">





                        <div class="field_lable float_left width_10"><label for="city">Marital status<span class="md_field">*</span></label></div>

                        <div class="filed_input float_left width_23">

<?php $marital_status[@$current_data[0]->clg_marital_status] = "selected=selected"; ?>   

                            <select id="filter_dropdown"  name="clg[clg_marital_status]" class="add_clg_sts filter_required" data-href="{base_url}clg/colleagues" data-qr="output_position=content&amp;flt=true" <?php echo $view; ?> data-errors="{filter_required:'Marital status should not be blank'}">

                                <option value="" >Select Status</option>

                                <option value="single" <?php echo $marital_status['single']; ?>>Unmarried</option>

                                <option value="married" <?php echo $marital_status['married']; ?>>Married</option>

                            </select>
                        </div>
<div class="width100 float_left"> 
<?php if (@$update == 'true' && $current_data[0]->clg_group == 'UG-SuperAdmin') { ?>
                            <div class="field_lable float_left width_10"><label for="address">Address<span class="md_field">*</span></label></div>

                            <div class="filed_input float_left width_55">
                                <input id="address" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_address]" class="filter_required filter_words"  data-errors="{filter_required:'Address should not be blank', filter_words:'Special characters not allowed'}" value="<?= @$current_data[0]->clg_address ?>" TABINDEX="12"  <?php echo $view; ?> style="width:100%;">
                    </div>              
<?php } else { ?>
                                <div class="field_lable float_left width_10"><label for="address">Address<span class="md_field">*</span></label></div>

                                <div class="filed_input float_left width_56">
                                    <input id="address" data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="text" name="clg[clg_address]" class="filter_required filter_words"  data-errors="{filter_required:'Address should not be blank', filter_words:'Special characters not allowed'}" value="<?= @$current_data[0]->clg_address ?>" TABINDEX="12"  <?php echo $view; ?>>
                                  </div>
                                    <?php } ?>                 
                         
                                <div id="designation_group">
                    <div class="field_lable float_left width_10"><label for="designation_group">Designation<span class="md_field">*</span></label></div>
                    <div class="filed_input float_left width_23">
                        <?php 
                        //var_dump($current_data[0]->clg_designation);
                        if($current_data[0]->clg_designation == '' && $current_data[0]->clg_group != '' ){
                            $current_data[0]->clg_designation = $current_data[0]->clg_group;
                            if($current_data[0]->clg_designation == 'EMT'){
                               $current_data[0]->clg_designation = 'EMT';
                            }
                        }
                      
                      
                        ?>
                        <select  name="clg[clg_designation]"  data-base="<?= @$current_data[0]->clg_ref_id ?>"  class="filter_required "  data-qr="output_position=parent_member&amp;module_name=clg " data-errors="{filter_required:'Designation name should not blank'}" TABINDEX="1"  <?php
                       if(( $clg_group1 != 'UG-SuperAdmin') && ( $clg_group1 != 'UG-ShiftManager') && ( $clg_group1 != 'UG-OperationHR') && ( $clg_group1 != 'UG-HelpDesk') && ( $clg_group1 != 'UG-FLD-OPE-DESK') && ( $clg_group1 != 'UG-HR') && $current_data[0]->clg_group != $clg_group1){
                       if (@$update) {
                        echo"disabled";
                        
                    }}
                        ?>>
                      <?php  if($current_data[0]->clg_designation !=''){
                          ?> 
                            <option value="<?php echo $current_data[0]->clg_designation; ?>"><?php echo $current_data[0]->clg_designation; ?></option>
 <?php
                      }else{ ?>
                            <option value="">Select Designation</option>
                            <?php
                            //  var_dump($current_data[0]->clg_designation);die();                     
                            $select_group_des[$current_data[0]->clg_designation] = "selected = selected";


                            foreach ($group_info as $group) {
//                                if (empty($update)) {
//                                    if (($clg_group != $group->gparent) && !in_array($clg_group, $super_groups)) {
//                                        continue;
//                                    }
//                                }
                                //if(trim($group->gparent) != ''){ continue; }


                                echo "<option value='" . $group->ugname . "'  ";
                                echo $select_group_des[$group->ugname];
                                echo" >" . $group->ugname;
                                echo "</option>";

                                foreach ($group_info as $group_l1) {

                                    if (trim($group->ugname) != trim($group_l1->gparent)) {
                                        continue;
                                    }


                                    echo "<option value='" . $group_l1->ugname . "'  ";
                                    echo $select_group_des[$group_l1->ugname];
                                    echo" > " . $group_l1->ugname;
                                    echo "</option>";

                                    foreach ($group_info as $group_l2) {

                                        if (trim($group_l1->ugname) != trim($group_l2->gparent)) {
                                            continue;
                                        }


                                        echo "<option value='" . $group_l2->ugname . "'  ";
                                        echo $select_group_des[$group_l2->ugname];
                                        echo" >" . $group_l2->ugname;
                                        echo "</option>";

                                        foreach ($group_info as $group_l3) {

                                            if (trim($group_l2->ugname) != trim($group_l3->gparent)) {
                                                continue;
                                            }


                                            echo "<option value='" . $group_l3->ugname . "'  ";
                                            echo $select_group_des[$group_l3->ugname];
                                            echo" > " . $group_l3->ugname;
                                            echo "</option>";
                                        }
                                    }
                                }
                            }
                        } 
                         ?>
                        </select>
                    </div>
                    </div>
</div>
                    
                    <div class="width100 float_left">  
                        <div class="width_33">
                            <?php// var_dump($current_data);?>
                          
                            <div class="field_lable float_left width_10"><label for="Zone">Division<span class="md_field"></span></label></div>
                            <div class="filed_input float_left width_23">

                                <input type="text" name="clg[clg_zone]" data-value="<?php echo $current_data[0]->zone_name; ?>" value="<?= @$current_data[0]->clg_zone; ?>" class="mi_autocomplete"  data-href="<?php echo base_url() ?>auto/get_division_district/MP"  placeholder="Division" TABINDEX="8" <?php echo $autofocus; ?> <?php echo $view; ?> data-errors="{filter_required:'Division name should not blank'}" data-callback-funct="load_district_on_div">
                            </div>
                        </div>

                        <div class="width_33">
                            <?php
                            // var_dump($current_data[0]->thirdparty_name);
                            if($current_data[0]->thirdparty_name == NULL && ($clg_group1 == 'UG-FLD-OPE-DESK' )){
                                $thirdparty_name = 'BVG';
                                $thirdparty = '1';
                            }else{
                                 $thirdparty_name = $current_data[0]->thirdparty_name;
                                $thirdparty = $current_data[0]->thirdparty;
                            } ?>
                          
                            <div class="field_lable float_left width_10"><label for="category">Employee Category<span class="md_field"></span></label></div>
                            <div class="filed_input float_left width_23">
                                
                            <input type="text" name="clg[thirdparty]"  value="<?php echo $thirdparty; ?>"  data-value="<?php echo $thirdparty_name; ?>" class="mi_autocomplete filter_required width2"  data-href="<?php echo base_url(); ?>auto/get_thirdparty?clg_group=<?php echo $clg_group1;?>"  placeholder="Select Employee Category" data-errors="{filter_required:'Please select Employee category  from dropdown list'}" TABINDEX="8" >
             
    
                              
                            </div>
                        </div>

                        
                    
                
                        <div class="width_33">
                            <div class="field_lable float_left width_10"><label for="district">District<span class="md_field"></span></label></div>
                            <div class="filed_input float_left width_23" id="div_district">

<!--                                <input type="text" name="clg[clg_district_id]" data-value="<?= @$current_data[0]->dst_name ?>" value="<?= @$current_data[0]->clg_district_id; ?>" class="mi_autocomplete filter_required"  data-href="<?php echo base_url() ?>auto/get_district/MH"  placeholder="District" TABINDEX="8" <?php echo $autofocus; ?>  <?php echo $update; ?> <?php echo $view; ?> data-errors="{filter_required:'District name should not blank'}">-->
                                <?php 

                                
                                ?>
                                <select id="group" name="clg[clg_district_id][]" data-base="<?= @$current_data[0]->clg_ref_id ?>"  class="filter_required" data-errors="{filter_required:'District name should not blank'}" TABINDEX="7" > 

                                        <option value=""> Select District </option>

                                            <?php
                                            if (count($district_list) > 0) {

                                                foreach ($district_list as $district) {
                                                    
                                                    $selected_dist = json_decode($current_data[0]->clg_district_id);
                                                    if(is_array($selected_dist)){
                                                    if(in_array($district->dst_code, $selected_dist)){
                                                        $select_group[$district->dst_code] = "selected = selected";
                                                    }
                                                    }
                                                    ?>

                                                <option value="<?php echo $district->dst_code; ?>" <?php echo $select_group[$district->dst_code]; ?>><?php echo $district->dst_name; ?></option>

        <?php
        }
    }
    ?>
                                    </select>
                            </div>
                        </div>

                    </div>

                        <div class="width100">
                            <div class="field_row width2 float_left">

                                <div class="resume_box">

                                    <div class="filed_input float_left ">
                                        <label for="group">Resume  ( extension allowed - .pdf, .doc, .docx ) </label>
                                    </div>
                                    <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  type="file" name="clg_resume" TABINDEX="18" style="float: left;"  <?php echo $view; ?> class="file_clg">

                                    <?php
                                    if (@$update && !$view && $current_data[0]->clg_resume != '') {
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
                            <div class="field_row width2 float_right">

                                <label for="photo">Photo</label>

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
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="profile_photo" type="file" name="profile_photo" accept="image/jpg,image/jpeg" TABINDEX="18"  <?php echo $view; ?>>

<?php if ($update) { ?>

                            <a class="clg_photo float_right" target="_blank" href="<?php
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


            <?php } ?>

                        </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
                </div>

                
            </div>


            <!--    <div class="educational_details_box width1">
            
                    <h4 class="txt_clr2 width1">Educational Details:</h4>
            
                    <div class="width2 float_left">    
            
                        <div class="filed_label"><label for="degree">Degree<span class="md_field">*</span></label></div>
            
                        <div class="filed_input">
            
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="degree" type="text" name="clg[clg_degree]" value="<?php
            if ($update) {
                echo $current_data[0]->clg_degree;
            }
            ?>" class="filter_required"  data-errors="{filter_required:'Degree should not be blank', filter_words:'Invalid input at Degree.. Numbers not allowed..!!'}" TABINDEX="19"  <?php echo $view; ?>>
                        </div>
            
                        <div class="filed_label"><label for="university">University<span class="md_field">*</span></label></div>
                        <div class="filed_input">
            
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="university" type="text" name="clg[clg_university]" value="<?php
            if ($update) {
                echo $current_data[0]->clg_university;
            }
            ?>" class="filter_required filter_words"  data-errors="{filter_required:'University of degree should not be blank',  filter_words:'Invalid input at university.. Numbers not allowed..!!'}"  TABINDEX="21"  <?php echo $view; ?>>
                        </div>
            
                    </div>
            
            
                    <div class="width2 float_left">
            
                        <div class="filed_lable"><label for="marks">Marks(%)<span class="md_field">*</span></label></div>
            
                        <div class="filed_input">
            
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="marks" type="text" name="clg[clg_marks]" value="<?php
            if ($update) {
                echo $current_data[0]->clg_marks;
            }
            ?>" class="filter_required filter_float"  data-errors="{filter_required:'Marks of last degree should not be blank', filter_float:'Marks in numbers only'}"  TABINDEX="20"  <?php echo $view; ?>>
                        </div>
            
            
                        <div class="filed_lable"><label for="year_of_passing">Year of Passing<span class="md_field">*</span></label></div>
            
                        <div class="filed_input">
            
                            <input data-base="<?= @$current_data[0]->clg_ref_id ?>"  id="year_of_passing" type="text" name="clg[clg_year_of_passing]" value="<?php
            if ($update) {
                echo $current_data[0]->clg_year_of_passing;
            }
            ?>" class="filter_required filter_number" data-errors="{filter_required:'Year of passing should not be blank', filter_number:'Invalid input at Year of passing.. Numbers are only allowed..!!'}"  TABINDEX="22"  <?php echo $view; ?>>
            
                        </div>
            
                    </div>
            
                </div>-->

<?php if (!@$view_clg) { ?>
            <div class="button_field_row width_25 margin_auto " style="clear:both;"> 
                    <div class="button_box">
                        <input type="hidden" name="hasfiles" value="yes" />
                        <input type="hidden" name="formid" value="add_colleague_registration" />
                        <input type="button" name="submit" value="<?php if ($update) { ?>Update<?php } else { ?>Submit<?php } ?>" class="btn submit_btnt mb-4 form-xhttp-request float_left hheadbg" data-href='<?php echo base_url(); ?>clg/<?php if ($update) { ?>update_colleague_data<?php } else { ?>register_colleague<?php } ?>' data-qr='output_position=content&amp;prof=<?php echo @$prof; ?>&amp;module_name=clg&amp;tlcode=<?php if ($update) { ?>MT-CLG-UPDATE<?php } else { ?>MT-CLG-ADD<?php } ?>&amp;page_no=<?php echo @$page_no; ?>&ampshowprocess=yes'  TABINDEX="23" id="<?php echo @$current_data[0]->clg_ref_id; ?>">
                        <input type="reset" name="reset" value="Reset" class="btn hheadbg reset_btn register_view_reset float_right mb-4"  TABINDEX="24">              <input type="hidden" name="clg_data" value=<?php echo $data; ?>>
                    </div>
                </div>
                <div class="mb-4">

</div>
<?php } ?>


            
        </div>      
    </div>
</form>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: "-50:+10"
    });
  } );
  </script>

