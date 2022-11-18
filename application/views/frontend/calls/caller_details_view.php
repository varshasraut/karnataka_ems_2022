<?php
$view = "";
$CI = EMS_Controller::get_instance();
$lat = $app_call_details[0]->lat;
$lng = $app_call_details[0]->lng;
$latlng = '';

if ($lat != '' && $lng != '') {
    $latlng =  $lat . "," . $lng . ",250";
}
if($CallUniqueID != '' && $CallUniqueID != 'direct_atnd_call'){
    ?><script>
      get_lbs_data();  
      $('#procesing_lbs').html('Waiting for LBS location...');
    </script> <?php
}
?>

<script>
    init_autocomplete();
    //stop_incoming_call_event();
</script>

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
        // jQuery('body').on("click", ".beforeunload .remove_beforeunload", function(event){
        // disable warning
        //warnBeforeUnload = false;
        //jQuery(window).off('beforeunload');
        //});
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

            <div class="width100" style="margin-top: 40px;">
                <div class="<?php echo $cl_class; ?> float_left outer_caller_dl"> <label class="headerlbl">Caller Details</label>

                </div>

                <div class="input_call_outer">
                    <div class="<?php // echo $cl_class; 
                                ?> width_15 float_left">
                        <div id="parent_purpose_of_calls" class="input">
                            <select id="parent_call_purpose" name="caller[parent_purpose]" class="filter_required" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_mobile_number]" TABINDEX="1.1" onchange="change_purpose_call()">
                                <?php
                                //
                                //var_dump($parent_purpose);
                                if ($parent_purpose) {
                                    $select_group[$parent_purpose] = "selected = selected";
                                } else if ($clg_user_type == '102') {
                                    $select_group['DROP_BACK_CALL'] = "selected = selected";
                                } else if ($clg_user_type == 'hd') {
                                    $select_group['CORONA_CALLS'] = "selected = selected";
                                } else if ($clg_user_type == '104') {
                                    $select_group['HELP_EME_INFO'] = "selected = selected";
                                    // $select_group['HELP_EME_COMP'] = "selected = selected";
                                }else {
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

                            <input pattern="[7-9]{1}[0-9]{9}" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="Enter mobile no" style="width: 95%;padding: 5px;" id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>" placeholder="" class="small half-text filter_number filter_required filter_mobile filter_minlength[9] filter_maxlength[15] change-base-xhttp-request filter_no_whitespace float_left has_error" data-errors="{filter_required:'Phone no should not be blank', filter_minlength:'Mobile number at least 10 digit long.',filter_maxlength:'Mobile number at max 14 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.',filter_number:'number shuold be integer'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}calls/get_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes" maxlength="14">
                            <div id="procesing_lbs" style="font-size: 11px; color:#f00;">
                                <?php
                                if(isset($app_call_details) && $m_no != ''){
                                if($app_call_details[0]->lat != ''){ ?>
                                <b style="color:#009515;">LBS Data Found...</b>
                                 <?php }else{ ?>
                                
                                <?php } } ?>
                            </div>
                        </div>
                        <div class="<?php echo $cl_class; ?> lefterror float_left mt-1" style="position:relative;">
                            <a title="Dispose and Dial" class="soft_dial_mobile click-xhttp-request ml-4" data-href="{base_url}api_v2/dispose_soft_dial" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                            <a title="Call Record History" class="view_caller_details onpage_popup ml-4" data-href="{base_url}calls/caller_history_number" data-qr="mobile_no=<?php echo $m_no; ?>" data-popupwidth="1500" data-popupheight="800"></a>
                            <!-- <a title="What Three Word SMS" class="three_word click-xhttp-request" data-href="{base_url}calls/three_word_popup" data-qr="mobile_no=<?php echo $m_no; ?>"></a> -->
                        </div>
                    <?php } else { ?>
                        <div class="<?php echo $cl_class; ?> lefterror float_left" style="position:relative;">

                            <input pattern="[7-9]{1}[0-9]{9}" onkeyup="this.value=this.value.replace(/[^\d]/,'')" style=" width: 95%;padding: 5px;" id="caller_no" type="text" name="caller[cl_mobile_number]" value="<?php echo $m_no; ?>" placeholder="" class="small half-text filter_number filter_required filter_mobile filter_minlength[9] filter_maxlength[15] filter_no_whitespace filter_mobile change-base-xhttp-request float_left" data-errors="{filter_required:'Phone no should not be blank', filter_minlength:'Mobile number at least 10 digit long.',filter_maxlength:'Mobile number at max 14 digit long.',filter_no_whitespace:'Phone number should not be allowed blank space.', filter_mobile:'Phone number should be valid.',filter_number:'number shuold be integer'}" TABINDEX="1.2" data-base="caller[cl_purpose]" <?php echo $view; ?> data-href="{base_url}calls/get_caller_details" data-qr="output_position=content&amp;showprocess=no&amp;fcrel=yes" maxlength="14">
                            <div id="procesing_lbs" style="font-size: 11px; color:#f00;">
                                 <?php 
                                 if(isset($app_call_details) && $m_no != ''){
                                 if($app_call_details[0]->lat != ''){ ?>
                                <b style="color:#009515;">LBS Data Found...</b>
                                 <?php } else { ?>
                               
                                 <?php } } ?>
                            </div>
                        </div>
                        <div class="<?php echo $cl_class; ?> lefterror float_left mt-1" style="position:relative;">
                          
                            <a title="Dispose and Dial" class="soft_dial_mobile click-xhttp-request ml-4" data-href="{base_url}api_v2/dispose_soft_dial" data-qr="mobile_no=<?php echo $m_no; ?>"></a>
                       
                            &nbsp;&nbsp;<a title="Call Record History" class="view_caller_details onpage_popup ml-4" data-href="{base_url}calls/caller_history_number" data-qr="mobile_no=<?php echo $m_no; ?>" data-popupwidth="1500" data-popupheight="800"></a>
                            <!-- &nbsp;&nbsp;<a title="What Three Word SMS" class="three_word click-xhttp-request" data-href="{base_url}calls/three_word_popup" data-qr="mobile_no=<?php echo $m_no; ?>"></a> -->
                        </div>
                    <?php } ?>


                    <div id="clr_rcl">
                        <span></span>
                    </div>

                    <?php
                    if (!isset($emt_details)) { ?>



                    <?php } ?>
                    <?php if ($clg_user_type != 'hd') { ?>
                        <div class="<?php echo $cl_class; ?> float_left input">
                            <input id="first_name" type="text" name="caller[cl_firstname]" class="filter_words ucfirst filter_if_not_blank" data-errors="{filter_words:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?php if ($caller_details->clr_fname != '') {
                                                                                                                                                                                                                                                                echo $caller_details->clr_fname;
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                echo "";
                                                                                                                                                                                                                                                            } ?>" placeholder="First Name" TABINDEX="1.4" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
                        </div>
                    <?php }
                    if ($clg_user_type != 'hd') { ?>
                        <div class="<?php echo $cl_class; ?> float_left input">
                        </div>
                    <?php } ?>
                    <div class="<?php echo $cl_class; ?> float_left input">
                        <?php if ($clg_user_type != 'hd') { ?>
                            <input id="last_name" type="text" name="caller[cl_lastname]" class="float_left ucfirst filter_if_not_blank filter_words" data-errors="{filter_words:'Invalid input at last name. Numbers and special characters not allowed.'}" value="<?= @$caller_details->clr_lname ?>" placeholder="Last Name" TABINDEX="1.6" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">

                            <div id="hidden_caller_id_block">
                                <input type="hidden" id="hidden_caller_id" name="caller[caller_id]" value="<?= @$caller_details->clr_id ?>" data-base="caller[cl_purpose]">
                            </div>
                        <?php } ?>

                        <input type="hidden" id="caller_call_id" name="caller[call_id]" value="<?= @$caller_details->cl_id ?>" data-base="caller[cl_purpose]">
                        <input type="button" id="caller_details_form" name="submit" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" class="form-xhttp-request" data-base="caller[cl_purpose]" style="visibility:hidden;">
                        <a id="submit_call" class="hide form-xhttp-request float_left" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&module_name=calls&showprocess=no"></a>
                    </div>
                      <div class="<?php echo $cl_class; ?> float_left input" id="caller_relation_div">
                    <?php
              
                    if (!isset($emt_details)) { 


                        if($clg_user_type =='104'){ ?>
                       
                            <!-- <select id="caller_relation" name="caller[cl_relation]" class="" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                <option value="">Select Relation</option>
                                <?php echo get_relation(); ?>
                            </select>-->

                     <?php } else if($parent_purpose =='EMG' || $parent_purpose == ''){
                        ?>
                            <select id="caller_relation" name="caller[cl_relation]" class="filter_required1 has_error1" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                <option value="">Select Relation</option>
                                <?php echo get_relation(); ?>
                            </select>
                        
                    <?php }else{
                        ?>
                            <!-- <select id="caller_relation" name="caller[cl_relation]" class="" data-errors="{filter_required:'Caller relation should not be blank'}" <?php echo $view; ?> TABINDEX="1.3" data-qr="output_position=inc_details&amp;module_name=calls&amp;showprocess=no" data-href="{base_url}calls/save_call_details" onchange="submit_caller_form()">
                                <option value="">Select Relation</option>
                                <?php echo get_relation(); ?>
                            </select>-->
                        
                        <?php
                    } } ?>
                    </div>
                    <div id="dis_timer_clock" class="<?php // echo $cl_class; 
                                                        ?> width_24  float_left input ml-4">
                        <input class="mr-1 bgmain" type='text' id="timer_clock" value="" readonly="readonly" name="incient[dispatch_time]" />

                        <div class="float_right input">
                            <div id="cur_date_time_clock"> <?php echo date('d-m-Y H:i:s', strtotime($attend_call_time)); ?></div>
                            <input type="hidden" name="caller[attend_call_time]" value="<?php echo $attend_call_time; ?>">
                        </div>
                    </div>
                    <?php 
                    
                    // if($clg_user_type != "hd" && $clg_user_type != "104") {
                        if($clg_user_type != "hd") {
                    ?>
                        <div id="call_common_info">
                        <?php if($clg_user_type == "104"){?>
                            <div class="call_common_info">
                            <?php }else{?>
                                <div class="call_common_info">
                                    <?php } ?>
                                <div class="float_left width100">

                                    <div class="width_11 float_left">
                                        <div class="label blue mt-1" style="font-size: 14px;"><b>Patient Information</b></div>
                                    </div>

                                    <div class="width_11 float_left">
                                        <input id="ptn_first_name" type="text" name="patient[first_name]" class="filter_required ucfirst_letter  <?php if($clg_user_type != "104"){?>filter_if_not_blank filter_words<?php }?> <?php if ($m_no != '' && $caller_details_data['clr_fname'] == '') {
                                                                                                                                                                                        echo "has_error";
                                                                                                                                                                                    } ?>" data-errors="{filter_required:'First name should not be blank', filter_words:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?php if ($caller_details_data['clr_fname'] == '') {
                                                                                                                                                                                                                                                                                                                                                                echo '';
                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                echo $caller_details_data['clr_fname'];
                                                                                                                                                                                                                                                                                                                                                            } ?>" placeholder="First Name" TABINDEX="11" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
                                    </div>

                                    <div class="width_11 float_left">
                                        <input id="ptn_last_name" type="text" name="patient[last_name]" class="ucfirst_letter filter_if_not_blank filter_words" data-errors="{filter_required:'Last name should not be blank', filter_words:'Invalid input at first name. Numbers and special characters not allowed.'}" value="<?= @$caller_details_data['clr_lname']; ?>" placeholder="Last Name" TABINDEX="13" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
                                    </div>
                                    <div class="width_11 float_left">
                                        <input id="ptn_mob_no" type="text" pattern="[7-9]{1}[0-9]{9}" onkeyup="this.value=this.value.replace(/[^\d]/,'')" name="patient[ptn_mob_no]" class="" value="" placeholder="Alternate Mob No" TABINDEX="13" onchange="submit_caller_form()" data-base="caller[ptn_mob_no]" maxlength="10">
                                    </div>                                                                                                                                                                                                                                                                                                                        
                                    <div class="width_11 float_left" id="ptn_age_outer">
                                        <input onkeyup="this.value=this.value.replace(/[^\d]/,'')" maxlength="3" id="ptn_age" type="text" name="patient[age]" class="<?php if($clg_user_type == "104"){?>filter_required<?php }?><?php if ($m_no != '' && $caller_details_data['patient_age'] == '') {
                                                                                                                                                                            echo 'filter_required has_error filter_rangelength[0-120] ';
                                                                                                                                                                        } ?>" data-errors="{filter_required:'Age should not be blank',filter_rangelength:'Age should be 0 to 120',filter_number:'Age should be in numbers'}" value="<?= @$caller_details_data['patient_age']; ?>" placeholder="Age" TABINDEX="14" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
                                    </div>
                                    <div class="width_11 float_left">
                                        <select id="age_type" name="patient[age_type]" class="<?php if ($m_no != '' && $caller_details_data['age_type'] == '') {
                                                                                                    echo 'filter_required has_error';
                                                                                                } ?>" <?php echo $view; ?> TABINDEX="15" data-errors="{filter_required:'Gender should not be blank'}" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">

                                            <option value="Years" <?php if ($caller_details_data['age_type'] == 'Years' || $caller_details_data['age_type'] == 'Years') {
                                                                        echo "selected";
                                                                    } ?>>Years</option>
                                            <option value="Months" <?php if ($caller_details_data['age_type'] == 'Months' || $caller_details_data['age_type'] == 'Months') {
                                                                        echo "selected";
                                                                    } ?>>Months</option>
                                            <option value="Days" <?php if ($caller_details_data['age_type'] == 'Days' || $caller_details_data['age_type'] == 'Days') {
                                                                        echo "selected";
                                                                    } ?>>Days</option>
                                        </select>
                                    </div>
                                    <div class="width_11 float_left">
                                        <input id="ptn_ayu_id" type="text" name="patient[ayu_id]" class="" value="<?= @$caller_details_data['ayu_id']; ?>" placeholder="Ayushman ID" TABINDEX="13" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
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
                                        <select id="patient_gender" name="patient[gender]" class="<?php if($clg_user_type == "104"){?>filter_required<?php }?><?php if ($m_no != '' && $caller_details_data['patient_gender'] == '') {
                                                                                                        echo 'filter_required has_error';
                                                                                                    } ?>" <?php echo $view; ?> TABINDEX="15" data-errors="{filter_required:'Gender should not be blank'}" onchange="submit_caller_form()" data-base="caller[cl_mobile_number]">
                                            <option value="">Gender</option>
                                            <option value="M" <?php if ($caller_details_data['patient_gender'] == 'Male' || $caller_details_data['patient_gender'] == 'M') {
                                                                    echo "selected";
                                                                } ?>>Male</option>
                                            <option value="F" <?php if ($caller_details_data['patient_gender'] == 'Female' || $caller_details_data['patient_gender'] == 'F') {
                                                                    echo "selected";
                                                                } ?>>Female</option>
                                            <option value="O" <?php if ($caller_details_data['patient_gender'] == 'Other' || $caller_details_data['patient_gender'] == 'O') {
                                                                    echo "selected";
                                                                } ?>>Transgender</option>
                                        </select>
                                    </div>



                                </div>

                               
                            </div>

                             <?php if($clg_user_type == "104"){?>
                                <div class="addr_info">
                                <div class="width_11 float_left" style="margin-left:100px" id="">
                                    </div>
                                    <div class="width05 float_left"><label>State</label></div>
                                    <div class="width15 float_left"> 
                                            <div id="incient_state">
                                            <?php
                                                if($inc_details['state_id'] == ''){
                                                    $state_id = '';
                                                }else {
                                                    $state_id = $inc_details['state_id'];
                                                }
                                                
                                                // $st = array('st_code' => $state_id, 'auto' => 'incient_auto_addr', 'rel' => 'incient', 'disabled' => '');
                                                $st = array('st_code' => 'MP', 'auto' => 'incient_auto_addr', 'rel' => 'incient', 'disabled' => '');

                                                echo get_state_tahsil_104($st);
                                                ?>

                                        </div>

                                    </div>


<style>
    .disabled_div{
    pointer-events: none;
    opacity: 0.4;
}
.width05{width :5%;}
</style>



                                    <div class="width05 float_left hide_show"><label>District</label></div>
                                    <div class="width15 float_left hide_show">
                                    
                        <div id="incient_dist">
                            <?php
                            if($inc_details['district_id'] == '' || $inc_details['district_id'] == 0){
                                 $district_id = '';
                            }else {
                                $district_id = $inc_details['district_id'];
                            }
                            
                            $dt = array('dst_code' => $district_id, 'st_code' => 'MP', 'auto' => 'incient_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_district_tahsil($dt);
                            ?>
                        </div>
                    </div>
                    <div class="width05 float_left hide_show"><label>Tehsil</label></div>
                    <div class="width15 float_left hide_show">
                        <div id="incient_tahsil">
                            <?php
                            if($inc_details['tahsil_id'] == '' || $inc_details['tahsil_id'] == 0){
                                 $tahsil_id = '';
                            }else {
                                $tahsil_id = $inc_details['tahsil_id'];
                            }
                            $thl = array('thl_id' =>$tahsil_id, 'dst_code' => $district_id, 'st_code' => $state, 'auto' => 'incient_auto_addr', 'rel' => 'incient', 'disabled' => '');

                            echo get_tahshil($thl);
                            ?>
                        </div>
                    </div>
                    <div class="width05 float_left"><label>Area</label></div>
                                    <div class="width15 float_left" id="JE_area">
                        <input type="text" name="area" TABINDEX="73" value="<?=@$inc_details['area'];?>" class="filter_required stauto" data-errors="{filter_required:'Area/Location is required'}" placeholder="Area/Location" data-auto="" id="JE_location">
                    </div>
                        </div>
                        <script>
    function check_state(){
        var state = $("input[name='incient_state']").val();
        // alert(state);
        if(state!='MP')
        {
            $("input[name='incient_district']").prop( "disabled", true ); 
            // $('#incient_dist').addClass('disabled_div');
            $('#incient_dist').removeClass('field_error');
            $("input[name='incient_tahsil']").prop( "disabled", true );
            $("input[name='incient_district']").val('');
            $("input[name='incient_district']").removeClass('filter_required has_error'); 
            // $('#incient_tahsil').addClass('disabled_div');
            $('#incient_tahsil').removeClass('field_error');
            $('#incient_tahsil').removeClass('field_error_show');
            $("input[name='incient_tahsil']").val('');
            $("input[name='incient_tahsil']").removeClass('filter_required has_error');
            // $('#incient_dist').hide();
            // $('#incient_tahsil').hide();
            $('.hide_show').hide();

        }
        else
        {
            $("input[name='incient_district']").prop( "disabled", false );
            // $('#incient_dist').removeClass('disabled_div');
            $('#incient_dist').addClass('field_error');
            $("input[name='incient_tahsil']").prop( "disabled", false );
            // $('#incient_tahsil').removeClass('disabled_div');
            $('#incient_tahsil').addClass('field_error');
            $('#incient_tahsil').removeClass('field_error_show');
            // $('#incient_dist').show();
            // $('#incient_tahsil').show();
            $('.hide_show').show();
        }
    }
</script>
                                    <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="width33 float_left" style="clear:both;" id="child_purpose_of_calls">
                        <?php
                       
                        if ($purpose_child_name == "" ) {
                           
                            $purpose_child_name = "NON_MCI";
                        }


                        if ($purpose_child_name) {
                           
                            ?>
                            

                            <div class="width30 float_left">
                                <label class="headerlbl">Type Of Call</label>
                            </div>
                            <!-- <label style="font-weight: bold !important;font-size: 18px !important;">Type Of Call</label> -->
                            <div id="purpose_of_calls" class="input width70 float_left">
                                <select id="call_purpose" name="caller[cl_purpose]" class="filter_required" data-href="{base_url}calls/save_call_details" data-qr="output_position=content&amp;module_name=calls&amp;showprocess=no" data-errors="{filter_required:'Purpose of call should not blank'}" data-base="caller[cl_mobile_number]" TABINDEX="1.1" onchange="submit_caller_form()" >
<option value="">Type Of Calls</option>
                                    <?php
                                    //var_dump($clg_user_type);die();
                                    if ($cl_purpose) {
                                        $select_group[$cl_purpose] = "selected = selected";
                                    } else if ($clg_user_type == '102') {
                                        $select_group['DROP_BACK'] = "selected = selected";
                                    } else if ($clg_user_type == 'hd') {
                                        $select_group['CORONA'] = "selected = selected";
                                    }  else if ($clg_user_type == '104') {
                                        // $select_group['HELP_EME_INFO'] = "selected = selected";
                                        $select_group['HELP_EME_COMP'] = "selected = selected";
                                    }else {
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
        <input type="hidden" name="CallUniqueID" value="<?php echo $CallUniqueID; ?>">

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

    clock_timer('timer_clock', '<?php echo $dispatch_time; ?>', '<?php echo $current_time; ?>');
</script>
<?php //die(); 
?>
<style>
    .bgmain {
        background: #F3F1F1 !important;
    }
</style>