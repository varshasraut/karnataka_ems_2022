<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?php
if($clg_group == 'UG-ERO' || $clg_group == 'UG-REMOTE' || $clg_group =='UG-BIKE-ERO' || $clg_group =='UG-ERO-HD'){
if($_SERVER['HTTP_HOST'] != 'www.mhems.in'){
?>
<script>
    start_incoming_call_event();
</script>
<?php  } 
}
?>

<?php $CI = EMS_Controller::get_instance();

$quality_marks = array();
$quality_marks['quality_score'] = 0;
$quality_marks['fetal_indicator'] = 0;
$quality_count = 0;

//if($_SERVER['remote_addr']=='43.224.172.126'){
//    var_dump($audit_details);
//}

if (!empty($audit_details)) {
    $quality_count = count($audit_details);


    foreach ($audit_details as $quality) {

        $quality_marks['quality_score'] = (int)$quality->quality_score + (int)$quality_marks['quality_score'];

        $fetal_indicator = json_decode($quality->fetal_indicator);
        if ($quality->quality_score == '0' || $quality->quality_score == 0) {
            $quality_marks['fetal_indicator'] =  $quality_marks['fetal_indicator']  + 1;
        }

        //$quality_marks['fetal_indicator'] = $quality->quality_score + $quality_marks['quality_score'];
    }
}

if ($clg_group != 'UG-EROSupervisor' && $clg_group != 'UG-ERO') {
    if ($clg_group !== 'UG-ERO') { ?>


        <div class="margin_auto width70">
            <div class="dash_quality_marks dash_quality width2 text_align_center float_left">

                <strong>Calls Info</strong><br>
                <table>
                    <tr>
                        <th>Total Calls <br>(this month)</th>
                        <th>Total Dispatches<br> (this month)</th>
                        <th>Total Calls<br> (today)</th>
                        <th>Total Dispatches<br> (today)</th>
                    </tr>
                    <tr>
                        <td><?php echo $total_month_call; ?></td>
                        <td><?php echo $total_month_dispatch_call; ?></td>
                        <td><?php echo $today_month_call; ?></td>
                        <td><?php echo $today_month_dispatch_call; ?></td>
                    </tr>
                </table>
                <span><?php //echo $audit_details[0]->quality_score;
                        ?></span>
            </div>
            <div class="dash_quality_marks dash_quality width2 text_align_center float_right" style="height: 167px;">

                <strong>Quality</strong><br>
                <table>
                    <tr style="height: 45px;">
                        <th>Audit Count</th>
                        <th>Quality Score</th>
                        <th>Fatal Call</th>
                        <th>Fatal Score</th>
                        <th>Performer Group</th>
                    </tr>
                    <tr>
                        <?php //var_dump($quality_marks);
                        if ($quality_marks['quality_score'] > 0) {
                            $quality_score = number_format($quality_marks['quality_score'] / $quality_count, 2);
                        } ?>
                        <td><?php echo $quality_count; ?></td>
                        <td><?php if ($quality_count > 0) {
                                echo $quality_score;
                            } else {
                                echo "0";
                            } ?></td>
                        <td><?php echo $quality_marks['fetal_indicator']; ?></td>
                        <td><?php if ($quality_count > 0) {
                                echo number_format(($quality_marks['fetal_indicator'] / $quality_count) * 100, 2);
                            } else {
                                echo "0";
                            } ?>%</td>
                        <td><?php if ($quality_score >= '91') {
                                echo "Performer";
                            } elseif (($quality_score <= '90') && ($quality_score >= '85')) {
                                echo "Intermediate";
                            } elseif (($quality_score <= '84.99') && ($quality_score >= '75')) {
                                echo "Improver";
                            } elseif ($quality_score <= '74.99') {
                                echo "Outlier";
                            }
                            ?>
                        </td>

                    </tr>
                </table>
                <span><?php //echo $audit_details[0]->quality_score;
                        ?></span>
            </div>

        </div>
    <?php } else if ($clg_group == 'UG-REMOTE') {
    ?>
        <div class="margin_auto width70">
            <div class="dash_quality_marks   text_align_center ">

                <strong>Calls Info</strong><br>
                <table>
                    <tr>
                        <th>Total Calls <br>(this month)</th>
                        <th>Total Dispatches<br> (this month)</th>
                        <th>Total Calls<br> (today)</th>
                        <th>Total Dispatches<br> (today)</th>
                    </tr>
                    <tr>
                        <td><?php echo $total_month_call; ?></td>
                        <td><?php echo $total_month_dispatch_call; ?></td>
                        <td><?php echo $today_month_call; ?></td>
                        <td><?php echo $today_month_dispatch_call; ?></td>
                    </tr>
                </table>
                <span><?php //echo $audit_details[0]->quality_score;
                        ?></span>
            </div>


        </div>
    <?php
    } else {
    ?>

        <div class="margin_auto width70">
            <div class="dash_quality_marks dash_quality width2 text_align_center float_left">

                <strong>Calls Info</strong><br>
                <table>
                    <tr>
                        <th>Total Calls <br>(this month)</th>
                        <th>Total Dispatches<br> (this month)</th>
                        <th>Total Calls<br> (today)</th>
                        <th>Total Dispatches<br> (today)</th>
                    </tr>
                    <tr>
                        <td><?php echo $total_month_call; ?></td>
                        <td><?php echo $total_month_dispatch_call; ?></td>
                        <td><?php echo $today_month_call; ?></td>
                        <td><?php echo $today_month_dispatch_call; ?></td>
                    </tr>
                </table>
                <span><?php //echo $audit_details[0]->quality_score;
                        ?></span>
            </div>
            <div class="dash_quality_marks dash_quality width2 text_align_center float_right" style="height: 167px;">

                <strong>Quality</strong><br>
                <table>
                    <tr style="height: 45px;">
                        <th>Audit Count</th>
                        <th>Quality Score</th>
                        <th>Fatal Call</th>
                        <th>Fatal Score</th>
                        <th>Performer Group</th>
                    </tr>
                    <tr>
                        <td><?php echo $quality_count; ?></td>
                        <td><?php if ($quality_count > 0) {
                                echo number_format($quality_marks['quality_score'] / $quality_count, 2);
                            } else {
                                echo "0";
                            } ?></td>
                        <td><?php echo $quality_marks['fetal_indicator']; ?></td>
                        <td><?php if ($quality_count > 0) {
                                echo number_format(($quality_marks['fetal_indicator'] / $quality_count) * 100, 2);
                            } else {
                                echo "0";
                            } ?>%</td>
                        <td><?php if ($quality_marks['quality_score'] >= '91') {
                                echo "Performer";
                            } elseif (($quality_marks['quality_score'] <= '90') && ($quality_marks['quality_score'] >= '85')) {
                                echo "Intermediate";
                            } elseif (($quality_marks['quality_score'] <= '84.99') && ($quality_marks['quality_score'] >= '75')) {
                                echo "Improver";
                            } elseif ($quality_marks['quality_score'] <= '74.99') {
                                echo "Outlier";
                            } ?></td>
                    </tr>
                </table>
                <span><?php //echo $audit_details[0]->quality_score;
                        ?></span>
            </div>

        </div>
<?php }
} ?>
<?php 
if ($clg_group == 'UG-ERO') { ?>
<div class="row">
    <div class="col-md-2">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2" id="eroperh22">Schedule Adherence (Today)</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($login_details as $inc) { ?>
                <tr>
                    <td id="eroper10">Login Time</td>
                    <td><?php echo $inc->clg_login_time; ?></td>

                </tr>
                <?php }?>
                <tr>
                    <td id="eroper10">Tea Break</td>
                    <td><?php echo $tea_break?$tea_break:'00:00:00';?></td>

                </tr>
                <tr>
                    <td id="eroper10">Meal Break</td>
                    <td><?php echo $meal_break?$meal_break:'00:00:00';?></td>
                </tr>
                <tr>
                    <td id="eroper10">Bio Break</td>
                    <td><?php echo $boi_break?$boi_break:'00:00:00';?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" id="eroperh">Calls Info</th>
                    <th scope="col" id="eroperh">Today</th>
                    <th scope="col" id="eroperh">MTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="eroper">Total Calls</td>
                    <td><?php echo $today_month_call; ?></td>
                    <td><?php echo $total_month_call; ?></td>

                </tr>
                <tr>
                    <td id="eroper">Emergency</td>
                    <td><?php echo $today_month_dispatch_call; ?></td>
                    <td><?php echo $total_month_dispatch_call; ?></td>
                   

                </tr>
                <tr>
                    <td id="eroper">Non-Emergency </td>
                    <td><?php 
                    $non_eme_calls_todays = $today_month_call - $today_month_dispatch_call;
                    echo $non_eme_calls_todays; ?></td>
                    <td><?php
                    $non_eme_calls_month = $total_month_call - $total_month_dispatch_call;
                    echo $non_eme_calls_month; ?></td>
                </tr>
                <tr>
                    <td id="eroper">Emergency %</td>
                    <td><?php 
                    $eme_per =0;
                    if($today_month_call >0 ){
                        $eme_per = ($today_month_dispatch_call/$today_month_call)*100;
                    }
                    echo round($eme_per,2);
                    ?>%</td>
                    <td><?php 
                    $non_eme_per =0;
                    if($total_month_dispatch_call >0 ){
                        $non_eme_per = ($total_month_dispatch_call/$total_month_call)*100;
                    }
                    echo round($non_eme_per,2);
                    ?>%</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" id="eroperh">Quality Performance </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="eroper2">Audit Count</td>
                    <?php //var_dump($quality_marks);
                        if ($quality_marks['quality_score'] > 0) {
                            $quality_score = number_format($quality_marks['quality_score'] / $quality_count, 2);
                        } ?>
                    <td id="eroper3"><?php echo $quality_count; ?></td>
                    <td id="eroper2">Quality Score</td>
                    <td id="eroper3"><?php if ($quality_count > 0) {
                                echo $quality_score;
                            } else {
                                echo "0";
                            } ?></td>

                </tr>
                <tr>
                    <td id="eroper2">Fatal Call</td>
                    <td id="eroper3"><?php echo $quality_marks['fetal_indicator']; ?></td>
                    <td id="eroper2">Fatal Score</td>
                    <td id="eroper3"><?php if ($quality_count > 0) {
                                echo number_format(($quality_marks['fetal_indicator'] / $quality_count) * 100, 2);
                            } else {
                                echo "0";
                            } ?>%</td>

                </tr>
                <tr>
                    <td colspan="2" id="eroper2">Performer Group </td>
                    <td  colspan="2" style="font-weight: bold !important;" id="eroper3"><?php if ($quality_score >= '91') {
                                echo "Performer";
                            } elseif (($quality_score <= '90') && ($quality_score >= '85')) {
                                echo "Intermediate";
                            } elseif (($quality_score <= '84.99') && ($quality_score >= '75')) {
                                echo "Improver";
                            } elseif ($quality_score <= '74.99') {
                                echo "Outlier";
                            }
                            ?></td>
                    <!-- <td id="eroper2">Feedback %</td>
                    <td id="eroper3">80.20 %</td> -->
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th id="eroperh">AHT</th>
                    <th id="eroperh">Today</th>
                    <th id="eroperh">MTD</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="eroper2">Emergency</td>
                    <td id="eroper3"><?php 
                    if($today_month_dispatch_call > 0){
                    $eme_aht = $emergency_aht[0]->timeSum?$emergency_aht[0]->timeSum:'00:00:00';
                    $parsed = date_parse($eme_aht);
                    $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
                    $seconds = $seconds/$today_month_dispatch_call;
                    $seconds = round($seconds);
                    $output = sprintf('%02d:%02d:%02d', ($seconds/ 3600),($seconds/ 60 % 60), $seconds% 60);
                    echo $output;
                    //echo $emergency_aht[0]->timeSum?$emergency_aht[0]->timeSum:'00:00:00';
                    }else{
                        echo '00:00:00';
                    }
                    ?></td>
                    <td id="eroper3"><?php 
                    if($total_month_dispatch_call > 0){
                    $mdt_emergency = $mdt_emergency_aht[0]->timeSum?$mdt_emergency_aht[0]->timeSum:'00:00:00';
                    $mdt_parsed = date_parse($mdt_emergency);
                    $mdt_seconds = $mdt_parsed['hour'] * 3600 + $mdt_parsed['minute'] * 60 + $mdt_parsed['second'];
                    $mdt_seconds = $mdt_seconds/$total_month_dispatch_call;
                    $mdt_seconds = round($mdt_seconds);
                    $mdt_output = sprintf('%02d:%02d:%02d', ($mdt_seconds/ 3600),($mdt_seconds/ 60 % 60), $mdt_seconds% 60);
                    echo $mdt_output;
                    }else{
                        echo '00:00:00';
                    }
                    
                    //$mdt_emergency_aht[0]->timeSum?$mdt_emergency_aht[0]->timeSum:'00:00:00'; 
                    ?></td>

                </tr>
                <tr>
                    <td id="eroper2">Non-Emergency </td>
                    <td id="eroper3"><?php 
                    if($non_eme_calls_todays > 0){
                    $non_eme_aht =  $non_emergency_aht[0]->timeSum?$non_emergency_aht[0]->timeSum:'00:00:00';
                    $mdt_non_parsed = date_parse($non_eme_aht);
                    $mdt_non_seconds = $mdt_non_parsed['hour'] * 3600 + $mdt_non_parsed['minute'] * 60 + $mdt_non_parsed['second'];
                    $mdt_non_seconds = $mdt_non_seconds/$non_eme_calls_todays;
                    $mdt_non_seconds = round($mdt_non_seconds);
                    $mdt_non_output = sprintf('%02d:%02d:%02d', ($mdt_non_seconds/ 3600),($mdt_non_seconds/ 60 % 60), $mdt_non_seconds% 60);
                    echo $mdt_non_output;
                    }else{
                         echo '00:00:00';
                    }
                   // echo $non_emergency_aht[0]->timeSum?$non_emergency_aht[0]->timeSum:'00:00:00'; ?></td>
                    <td id="eroper3"><?php 
                    if($non_eme_calls_month > 0){
                      
                    $non_eme_aht_mdt =  $mdt_non_emergency_aht[0]->timeSum?$mdt_non_emergency_aht[0]->timeSum:'00:00:00';
                   
                    $mdt_non_parsed_aht = date_parse($non_eme_aht_mdt);
                    $mdt_non_seconds_aht = $mdt_non_parsed_aht['hour'] * 3600 + $mdt_non_parsed_aht['minute'] * 60 + $mdt_non_parsed_aht['second'];
                     
                    // echo $non_eme_calls_month;
                    $mdt_non_seconds_ahtt = $mdt_non_seconds_aht/$non_eme_calls_month;
                    $mdt_non_seconds_aht1 = round($mdt_non_seconds_ahtt);
                    
                    $mdt_non_output_aht = sprintf('%02d:%02d:%02d', ($mdt_non_seconds_aht1/ 3600),($mdt_non_seconds_aht1/ 60 % 60), $mdt_non_seconds_aht1% 60);
                    
                    echo $mdt_non_output_aht;
                    }else{
                         echo '00:00:00';
                    }
                    
                    //echo $mdt_non_emergency_aht[0]->timeSum?$mdt_non_emergency_aht[0]->timeSum:'00:00:00'; 
                    ?></td>

                </tr>
                <tr>
                    <td id="eroper2">Over All </td>
                    <td id="eroper3"><?php
                    //echo $total_aht[0]->timeSum?$total_aht[0]->timeSum:'00:00:00'; 
                    if($today_month_call > 0){
                    $total_aht =  $total_aht[0]->timeSum?$total_aht[0]->timeSum:'00:00:00';
                    $total_parsed_aht = date_parse($total_aht);
                    $total_seconds_aht = $total_parsed_aht['hour'] * 3600 + $total_parsed_aht['minute'] * 60 + $total_parsed_aht['second'];
                    $total_seconds_aht = $total_seconds_aht/$today_month_call;
                    $total_seconds_aht = round($total_seconds_aht);
                    $total_output_aht = sprintf('%02d:%02d:%02d', ($total_seconds_aht/ 3600),($total_seconds_aht/ 60 % 60), $total_seconds_aht% 60);
                    echo $total_output_aht;
                    }else{
                         echo '00:00:00';
                    }
                    
                    ?></td>
                    <td id="eroper3"><?php 
                    //echo $mdt_total_aht[0]->timeSum?$mdt_total_aht[0]->timeSum:'00:00:00'; 
                     if($total_month_call > 0){
                    $mdt_total_aht =  $mdt_total_aht[0]->timeSum?$mdt_total_aht[0]->timeSum:'00:00:00'; 
                    $mdt_parsed_aht = date_parse($mdt_total_aht);
                    $mdt_seconds_aht = $mdt_parsed_aht['hour'] * 3600 + $mdt_parsed_aht['minute'] * 60 + $mdt_parsed_aht['second'];
                    $mdt_seconds_aht = $mdt_seconds_aht/$total_month_call;
                    $mdt_seconds_aht = round($mdt_seconds_aht);
                    $mdt_output_aht = sprintf('%02d:%02d:%02d', ($mdt_seconds_aht/ 3600),($mdt_seconds_aht/ 60 % 60), $mdt_seconds_aht% 60);
                    echo $mdt_output_aht;
                     }else{
                         echo '00:00:00';
                    }
                    
                    ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php }?>
<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">
        <div class="width100" id="ero_dash">
            <div id="amb_filters">
                <div class="width100 float_left">

                    <div class="search">

                        <div class="row">
                            <label class="txt_clr2 " style="font-weight: bold;margin-left: 15px;">Call Details</label>
                        </div>





                        <?php if ($clg_senior) { ?>
                            <div class="width10 float_left">

                                <select id="team_type" name="team_type" class="" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" <?php echo $view; ?>>

                                    <option value="">Select Team Type</option>
                                    <option value='all' selected>All</option>
                                    <option value="UG-ERO-102">ERO 102</option>
                                    <option value="UG-ERO">ERO 108</option>

                                </select>
                            </div>
                            <div class="width10 float_left" id="ero_list_outer_qality">
                                <select id="ero_id" name="user_id" class="" data-errors="{filter_required:'Please select ERO from dropdown list'}">
                                    <option value="">Select ERO User</option>
                                    <option value="all">All User</option>
                                    <?php
                                    foreach ($ero_clg as $purpose_of_call) {
                                        if ($purpose_of_call->clg_ref_id == $feedback_id) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected";

                                        echo " >" . $purpose_of_call->clg_ref_id . "-" . $purpose_of_call->clg_first_name . " " . $purpose_of_call->clg_last_name;
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        <?php } ?>
                        <div class="filed_input float_left width10">
                            <!-- <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div> -->
                            <input name="from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $from_date; ?>" readonly="readonly" id="from_date">
                        </div>
                        <div class="filed_input float_left width10">
                            <input name="to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $to_date; ?>" readonly="readonly" id="to_date">
                        </div>
                        <!--<div class="width10 float_left">
                            <div class="width100 float_left">
                                <select name="call_status" placeholder="Select Call Status" class="form_input "  style="color:#666666" data-errors="{filter_required:'Call Status should not blank'}" data-base="search_btn"  tabindex="2" >
                                    <option value='all' selected>All call</option>
                                    <option value='0'>Active</option>
                                    <option value='2'>Terminated</option>

                                </select>
                            </div> 
                        </div>-->
                        <div class="input float_left width10">

                            <select id="parent_call_purpose" name="call_purpose" placeholder="Select Purpose of call" class="form_input " style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn" tabindex="2">

                                <option value='' selected>Select Purpose of call</option>
                                <option value='all' selected>All call</option>

                                <?php


                                foreach ($all_purpose_of_calls as $purpose_of_call) {
                                    echo "<option value='" . $purpose_of_call->pcode . "'  ";
                                    echo $select_group[$purpose_of_call->pcode];
                                    echo " >" . $purpose_of_call->pname;
                                    echo "</option>";
                                }
                                ?>
                            </select>

                        </div>

                        <div class="width10 float_left">
                            <input type="text" class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search" />
                        </div>
                        <div class="width10 float_left ">
                            <input name="district_id" class="mi_autocomplete width97" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" data-value="" value="">
                        </div>

                        <div class="width10 float_left">
                            <div class="width100 float_left">
                                <select name="incident_status" placeholder="Select Incident Status" class="form_input " style="color:#666666" data-errors="{filter_required:'Call Status should not blank'}" data-base="search_btn" tabindex="2">
                                    <option value=' ' selected>Select Incident Status</option>
                                    <option value='1'>Call Assigned</option>
                                    <option value='2'>Start From Base</option>
                                    <option value='3'>At Scene</option>
                                    <option value='4'>From Scene</option>
                                    <option value='5'>At Hospital</option>
                                    <option value='6'>Patient Handover</option>
                                    <option value='7'>Back To Base</option>
                                </select>
                            </div>
                        </div>

                        <div class="width25 float_left">

                            <input type="button" class="search_button float_left  form-xhttp-request" name="" value="Search" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc" style="margin-top:0px;" />
                            <input type="reset" class="search_button float_left form-xhttp-request" name="" value="Reset Filter" data-href="{base_url}calls" data-qr="output_position=content&amp;flt=reset&amp;type=inc" style="margin-top:0px;" />
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div id="list_table">

            <table class="table report_table">
                <tr>

                    <th>Date & Time</th>
                    <th>Incident ID</th>
                    <th>Caller Name</th>
                    <th>District Name</th>
                    <!--                       <th nowrap>Patient Name</th>-->
                    <!--                    <th nowrap>108 Ref ID</th>-->
                    <th>Caller Mobile No</th>
                    <!--                    <th width="18%">Incident Address</th>-->
                    <?php if ($clg_senior) { ?>
                        <th>EMT Name</th>
                        <th>EMT Mobile</th>
                        <th>Pilot Name</th>
                        <th>Pilot Mobile</th>
                    <?php } ?>
                    <th>Ambulance No</th>
                    <th>ERO Name</th>
                    <th>Audio File</th>
                    <th>Call Duration</th>
                    <th>Call Type</th>

                    <th>Incident Status</th>
                    <th>Closure Status</th>


                </tr>
                <?php //print_r($inc_info); die;
                //if($this->clg->clg_ref_id != 'ERO-1'){

                if ($inc_info) {



                    $total = 0;

                    foreach ($inc_info as $key => $inc) {



                        if (($inc->ptn_mname == '') && ($inc->ptn_fname == '')) {
                            $inc->ptn_mname = "-";
                            $inc->ptn_fname = "-";
                        }

                        if ($inc->ptn_fullname != '') {
                            $patient_name = $inc->ptn_fullname;
                        } else {
                            $patient_name = $inc->ptn_fname . " " . $inc->ptn_mname . " " . $inc->ptn_lname;
                        }

                        //        if ($inc->clr_fullname != '') {
                        //            $caller_name = $inc->clr_fullname;
                        //        } else {
                        $caller_name = $inc->clr_fname . "  " . $inc->clr_mname . "  " . $inc->clr_lname;
                        //        }
                ?>

                        <tr>
                            <td><?php echo date("d-m-Y H:i:s", strtotime($inc->inc_datetime)); ?></td>
                            <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;" data-popupwidth="1900" data-popupheight="1700"><?php echo $inc->inc_ref_id; ?></a></td>
                            <td><?php echo ucwords($caller_name); ?></td>
                            <td><?php echo $inc->dst_name; ?></td>
                            <!--                    <td ><?php echo ucwords($patient_name); ?></td>-->
                            <!--                        <td  style="background: #FFD4A2;;"><?php echo $inc->inc_bvg_ref_number; ?></td>-->
                            <td><a href="{base_url}calls/caller_history_number" class="onpage_popup" data-qr="output_position=popup_div&mobile_no=<?php echo $inc->clr_mobile; ?>" style="color:#000;" data-popupwidth="1900" data-popupheight="1700"><?php echo $inc->clr_mobile; ?></a></td>
                            <!--                    <td ><?php echo $inc->inc_address; ?></td>-->
                            <?php if ($clg_senior) { ?>
                                <td><?php echo $inc->amb_emt_id; ?><?php //echo ucwords($inc->emt_first_name." ".$inc->emt_last_name);  
                                                                    ?></td>
                                <td nowrap><?php echo $inc->amb_default_mobile; ?></td>
                                <td><?php echo $inc->amb_pilot_id; ?><?php //echo ucwords($inc->clg_first_name." ".$inc->clg_last_name);  
                                                                        ?></td>
                                <td><?php echo $inc->amb_pilot_mobile; ?><?php //echo ucwords($inc->clg_first_name." ".$inc->clg_last_name);  
                                                                            ?></td>
                            <?php } ?>
                            <td nowrap><?php echo $inc->amb_rto_register_no; ?></td>
                            <td nowrap><?php echo ucwords(strtolower($inc->clg_first_name . " " . $inc->clg_last_name)); ?></td>

                            <td>
                                <?php
                                // var_dump($clg_group);

                                //$pic_path =  $inc->inc_audio_file;
                                if ($inc->inc_avaya_uniqueid != 'direct_atnd_call' && $inc->inc_avaya_uniqueid != '') {
                                    //$inc_datetime = date("Y-m-d", strtotime($inc->inc_datetime));
                                    //$pic_path =  get_inc_recording($inc->inc_avaya_uniqueid, $inc_datetime);
                                    $pic_path = $inc->inc_audio_file;
                                    if ($pic_path != "") {
                                        if ($clg_senior) {
                                            $width = "width: 185px;";
                                        } else {
                                            $width = "width: 50px;";
                                        }
                                ?>
                                        <audio controls controlsList="nodownload" style="<?php echo $width; ?>">
                                            <source src="<?php echo $pic_path; ?>" type="audio/wav">
                                            Your browser does not support the audio element.
                                        </audio>
                                <?php
                                    }
                                }

                                ?>

                            </td>
                            <td><?php echo ($inc->inc_dispatch_time); ?></td>
                            <td><?php echo $inc->pname; ?></td>

                            <?php //if($clg_senior){
                            if ($inc->incis_deleted == 0) {
                                if ($inc->parameter_count == '2') {
                                    $time = $inc->start_from_base_loc;
                                    $status = 'Start From Base';
                                } elseif ($inc->parameter_count == '3') {
                                    $time = $inc->at_scene;
                                    $status = 'At Scene';
                                } elseif ($inc->parameter_count == '4') {
                                    $time = $inc->from_scene;
                                    $status = 'From Scene';
                                } elseif ($inc->parameter_count == '5') {
                                    $time = $inc->at_hospital;
                                    $status = 'At Hospital';
                                } elseif ($inc->parameter_count == '6') {
                                    $time = $inc->patient_handover;
                                    $status = 'Patient Handover';
                                } elseif ($inc->parameter_count == '7') {
                                    $time = $inc->back_to_base_loc;
                                    $status = 'Available';
                                } else {
                                    $time = $inc->assigned_time;
                                    $status = 'Call Assigned';
                                }
                                $disptched = $status;
                            }
                            if ($inc->incis_deleted == 2) {
                                $disptched = "Terminated";
                            }
                            if ($inc->incis_deleted == 1) {
                                $disptched = "Deleted";
                            }
                            if ($inc->inc_pcr_status == 0) {
                                $closer = "Closure Pending";
                            } else {
                                $closer = "Closure Done";
                            }
                            ?>
                            <td><a href="{base_url}calls/incident_Current_Status_Deatis" class="onpage_popup" data-qr="output_position=popup_div&dispatch_status=<?php echo $disptched; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>&inc_datetime=<?php echo $inc->inc_datetime; ?>" style="color:#000;" data-popupwidth="1300" data-popupheight="600"><?php echo $disptched; ?></a></td>
                            <td><?php echo $closer; ?></td>
                            <?php //} 
                            ?>
                        </tr>

                    <?php } ?>

                <?php }

                //  } 
                else { ?>


                    <?php if ($clg_senior) { ?>
                        <tr>
                            <td colspan="16" class="no_record_text">No Record Found</td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="16" class="no_record_text">No Record Found</td>
                        </tr>
                    <?php } ?>



                <?php } ?>





            </table>



            <div class="bottom_outer">

                <div class="pagination"><?php echo $pagination; ?></div>

                <input type="hidden" name="submit_data" value="<?php
                                                                if (@$data) {
                                                                    echo $data;
                                                                }
                                                                ?>">

                <div class="width33 float_right">

                    <div class="record_per_pg">

                        <div class="per_page_box_wrapper">

                            <span class="dropdown_pg_txt float_left"> Records per page : </span>

                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                <?php echo rec_perpg($pg_rec); ?>

                            </select>

                        </div>

                        <div class="float_right">
                            <span> Total records: <?php
                                                    if (@$inc_total_count) {
                                                        echo $inc_total_count;
                                                    } else {
                                                        echo "0";
                                                    }
                                                    ?> </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </form>
</div>
<div class="hide">
    <?php echo $clg_senior; ?>
</div>
<?php if ($clg_senior) { ?>
    <script>
        jQuery(document).ready(function() {

            var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: -1,
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date()
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date()
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
<?php } else { ?>

    <script>
        jQuery(document).ready(function() {

            var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate: -1,
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date(),
                    minDate: '-1d',
                })
                .on("change", function() {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
                    defaultDate: new Date(),
                    changeMonth: true,
                    numberOfMonths: 1,
                    maxDate: new Date(),
                    minDate: '-1d',
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
<?php } ?>


<style>
    #eroper {
        font-weight: bold !important;
        text-align: left !important;
    }
    #eroper10 {
        font-weight: bold !important;
        text-align: left !important;
        width: 50% !important;
        /* padding-left: 0px !important; */
        padding-right: 0px !important;
    }
    #eroperh{
        text-align: center !important;
        font-size: 15px !important;
    }
    #eroperh22{
        text-align: center !important;
        font-size: 14px !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    .table-bordered td{
        text-align: center !important;
        padding:8px !important;
    }
    #eroper2{
        font-weight: bold !important;
        text-align: left !important;
        padding:14px !important;
    }
    #eroper3{
        padding:16px !important;
    }

</style>