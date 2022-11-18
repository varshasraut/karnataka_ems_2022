<?php
$view = "";
//if($m_no != ''){ $view='disabled'; }
$CI = EMS_Controller::get_instance();
?>

<script>
    jQuery(document).ready(function() {
        // Warning
        jQuery(window).on('beforeunload', function() {
            return "Any changes will be lost";
        });

        // Form Submit
        jQuery('body').on("click", ".beforeunload .form-xhttp-request", function(event) {
            // disable warning
            //warnBeforeUnload = false;
            jQuery(window).off('beforeunload');
        });
    });
    jQuery("#call_purpose").focus();
</script>

<div class="caller_details" id="caller_details">
    <form enctype="multipart/form-data" action="#" method="post" id="add_caller_details">
        <div class="call_bx">
            <?php
            if (!isset($emt_details)) {
                $cl_class = "width_10";
            } else {

                $cl_class = "width_16";
            }

            ?>

            <div class="width100">
                <div class="<?php echo $cl_class; ?> float_left outer_caller_dl"> <label class="headerlbl">Caller Details</label>

                </div>

                <div class="input_call_outer">
                    <div class="<?php // echo $cl_class; 
                                ?> width_12 float_left">
                        <div id="parent_purpose_of_calls" class="input">
                            <select id="parent_call_purpose" name="caller[parent_purpose]" class="filter_required" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_mobile_number]" TABINDEX="1.1" onchange="change_purpose_call()">
                                <option value="">Purpose Of Calls</option>
                                <?php
                                if ($cl_purpose) {
                                    $select_group[$parent_purpose] = "selected = selected";
                                } else {
                                    $select_group['EMG'] = "selected = selected";
                                }

                                foreach ($purpose_of_calls as $purpose_of_call) {
                                    echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                    echo $select_group[$purpose_of_call->pcode];
                                    echo " >" . $purpose_of_call->pname;
                                    echo "</option>";
                                }
                                ?>
                            </select>

                        </div>


                    </div>
                    <?php if ($m_no == '') { ?>
                        <div class="<?php echo $cl_class; ?> lefterror float_left" style="position:relative;">
                            <!--<span class="mobile_prefix">+91</span>-->
                            <input style=" width: 80%;" id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>" placeholder="" class="small half-text filter_required filter_minlength[9] filter_maxlength[12] change-base-xhttp-request filter_no_whitespace float_left" data-errors="{filter_required:'Phone no should not be blank', filter_minlength:'Mobile number at least 10 digit long.',filter_maxlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}calls/get_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                            <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                            <a class="view_caller_details click-xhttp-request" data-href="{base_url}calls/caller_history" data-qr="mobile_no=<?php echo $m_no; ?>"></a>

                        </div>
                    <?php } else { ?>
                        <div class="<?php echo $cl_class; ?> lefterror float_left" style="position:relative;">
                            <!--<span class="mobile_prefix">+91</span>-->
                            <input style=" width: 80%;" id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>" placeholder="" class="small half-text filter_required filter_minlength[9] filter_maxlength[12] filter_no_whitespace change-base-xhttp-request float_left" data-errors="{filter_required:'Phone no should not be blank', filter_minlength:'Mobile number at least 10 digit long.',filter_maxlength:'Mobile number at least 10 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}calls/get_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes">
                            <a class="soft_dial_mobile click-xhttp-request" data-href="{base_url}avaya_api/soft_dial" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                            <a class="view_caller_details click-xhttp-request" data-href="{base_url}calls/caller_history" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                        </div>
                    <?php } ?>


                    <div id="clr_rcl">
                        <span></span>
                    </div>

                    <?php
                    if (!isset($emt_details)) { ?>


                        <div class="<?php echo $cl_class; ?> float_left input" id="caller_relation_div">
                            <select id="caller_relation" name="caller[cl_relation]" class="" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                <option value="">Select Relation</option>
                                <?php echo get_relation(); ?>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="first_name" type="text" name="caller[cl_firstname]" class=" ucfirst" data-errors="{filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_fname ?>" placeholder="First Name" TABINDEX="1.4">
                    </div>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="middle_name" type="text" name="caller[cl_middlename]" class=" ucfirst" data-errors="{filter_word:'Invalid input at middle name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_mname ?>" placeholder="Middle Name" TABINDEX=1.5">
                    </div>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <input id="last_name" type="text" name="caller[cl_lastname]" class="float_left ucfirst" data-errors="{filter_word:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_lname ?>" placeholder="Last Name" TABINDEX="1.6">

                        <input type="hidden" id="hidden_caller_id" name="caller[caller_id]" value="<?= @$caller_details->clr_id ?>" data-base="caller[cl_purpose]">
                        <input type="hidden" id="caller_call_id" name="caller[call_id]" value="<?= @$caller_details->cl_id ?>" data-base="caller[cl_purpose]">
                        <input type="button" id="caller_details_form" name="submit" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" class="form-xhttp-request" data-base="caller[cl_purpose]" style="visibility:hidden;">
                        <a id="submit_call" class="hide form-xhttp-request float_left" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&module_name=calls&showprocess=no"></a>
                    </div>

                    <div id="dis_timer_clock" class="<?php // echo $cl_class; 
                                                        ?> width_17  float_left input">
                        <input type='text' id="timer_clock" value="" readonly="readonly" name="incient[dispatch_time]" />

                        <div class="float_right input">
                            <div id="cur_date_time_clock"> <?php echo date('d-m-Y H:i:s', strtotime($attend_call_time)); ?></div>
                            <input type="hidden" name="caller[attend_call_time]" value="<?php echo $attend_call_time; ?>">
                        </div>
                    </div>
                    <div id="call_common_info">
                        <div class="call_common_info">
                            <div class="float_left width100">
                                <div class="width_11 float_left">
                                    <div class="label blue"><b>Patient Information</b></div>
                                </div>
                                <div class="width_11 float_left">
                                    <input id="ptn_first_name" type="text" name="patient[first_name]" class="filter_required ucfirst filter_if_not_blank filter_word" data-errors="{filter_required:'First name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?php if ($caller_details_data['clr_fname'] == '') {
                                                                                                                                                                                                                                                                                                                                            echo 'Unknown';
                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                            echo $caller_details_data['clr_fname'];
                                                                                                                                                                                                                                                                                                                                        } ?>" placeholder="First Name" TABINDEX="11" onchange="submit_caller_form()">
                                </div>
                                <div class="width_11 float_left">
                                    <input id="ptn_middle_name" type="text" name="patient[middle_name]" class="ucfirst filter_if_not_blank filter_word" data-errors="{filter_required:'Middle name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_mname']; ?>" placeholder="Middle Name" TABINDEX="12" onchange="submit_caller_form()">
                                </div>
                                <div class="width_11 float_left">
                                    <input id="ptn_last_name" type="text" name="patient[last_name]" class="ucfirst filter_if_not_blank filter_word" data-errors="{filter_required:'Last name should not be blank', filter_word:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_lname']; ?>" placeholder="Last Name" TABINDEX="13" onchange="submit_caller_form()">
                                </div>
                                <div class="width_11 float_left">
                                    <input id="ptn_dob" data-fname="patient[age]" type="text" name="patient[dob]" class="mi_cur_date" data-errors="{filter_required:'DOB should not be blank',filter_number:'Age should be in numbers'}" value="<?= @$caller_details_data['patient_age']; ?>" placeholder="DOB" TABINDEX="14" readonly="readonly" onchange="submit_caller_form()">
                                </div>
                                <div class="width_11 float_left" id="ptn_age_outer">
                                    <input id="ptn_age" type="text" name="patient[age]" class=" filter_rangelength[0-100]" data-errors="{filter_required:'Age should not be blank',filter_rangelength:'Age should be 0 to 100',filter_number:'Age should be in numbers'}" value="<?= @$caller_details_data['patient_age']; ?>" placeholder="Age" TABINDEX="14" onchange="submit_caller_form()">
                                </div>
                                <div class="width_11 float_left">
                                    <input id="ptn_ayu_id" type="text" name="patient[ayu_id]" class="" value="" placeholder="Ayushman ID" TABINDEX="13" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
                                </div>
                                <div class="width_11 float_left">
                                    <select id="ptn_bld_gp" name="patient[blood_gp]" class="" data-base="caller[cl_mobile_number]" TABINDEX="1.1" onchange="submit_caller_form()">
                                        <option value="">Blood Group</option>
                                        <?php
                                        foreach ($blood_gp as $bg) {
                                            echo '<option value="' . $bg->bldgrp_id . '">' . $bg->bldgrp_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="width_11 float_left" id="non_mci_patient_gender">
                                    <select id="patient_gender" name="patient[gender]" class="" <?php echo $view; ?> TABINDEX="15" onchange="submit_caller_form()" data-errors="{filter_required:'Gender should not be blank'}">
                                        <option value="">Gender</option>
                                        <option value="M" <?php if ($caller_details_data['patient_gender'] == 'Male' || $caller_details_data['patient_gender'] == 'M') {
                                                                echo "selected";
                                                            } ?>>Male</option>
                                        <option value="F" <?php if ($caller_details_data['patient_gender'] == 'Female' || $caller_details_data['patient_gender'] == 'F') {
                                                                echo "selected";
                                                            } ?>>Female</option>
                                        <option value="O" <?php if ($caller_details_data['patient_gender'] == 'Other' || $caller_details_data['patient_gender'] == 'O') {
                                                                echo "selected";
                                                            } ?>>Other</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="width33 float_left" style="clear:both;" id="child_purpose_of_calls">
                        <?php
                        if ($purpose_child_name == "") {
                            $purpose_child_name = "NON_MCI";
                        }

                        if ($purpose_child_name) { ?>


                            <div class="width30 float_left">
                                <label class="headerlbl">Type Of Call</label>
                            </div>
                            <div id="purpose_of_calls" class="input width70 float_left">
                                <select id="call_purpose" name="caller[cl_purpose]" class="filter_required" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_mobile_number]" TABINDEX="1.1" onchange="submit_caller_form()">
                                    <!--                                  <option value="">Purpose Of calls</option>-->
                                    <?php

                                    if ($cl_purpose) {
                                        $select_group[$purpose_child_name] = "selected = selected";
                                    } else {
                                        $select_group['NON_MCI'] = "selected = selected";
                                    }

                                    foreach ($child_purpose_of_calls as $purpose_child) {
                                        echo "<option value='" . $purpose_child->pcode . "'  ";
                                        echo $select_group[$purpose_child->pcode];
                                        echo " >" . $purpose_child->pname;
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        <?php } ?>

                    </div>
                </div>


            </div>
        </div>


    </form>

</div>

<div id="call_purpose_form">

</div>

<div id="common_call_script_view">


</div>
<?php $dispatch_time = $this->session->userdata('dispatch_time');
$current_time = time();
?>
<script>
    $AVAYA_INCOMING_CALL_FLAG = 0;
    StopTimerFunction();

    clock_timer('timer_clock', '<?php echo $dispatch_time; ?>', '<?php echo $current_time; ?>')
</script>