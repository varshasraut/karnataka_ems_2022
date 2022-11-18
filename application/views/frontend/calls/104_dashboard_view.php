<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
    .header_wrapper .profile_box {
  
    padding-top: 17px;
}
</style>
<!-- <?php
if ($clg_group == 'UG-ERO' || $clg_group == 'UG-REMOTE' || $clg_group == 'UG-BIKE-ERO' || $clg_group == 'UG-ERO-HD') {
    if ($_SERVER['HTTP_HOST'] != 'www.mhems.in') {
?>
        <script>
            start_incoming_call_event();
        </script>
<?php  }
}
?> -->

<?php $CI = EMS_Controller::get_instance();

$quality_marks = array();
$quality_marks['quality_score'] = 0;
$quality_marks['fetal_indicator'] = 0;
$quality_count = 0;



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
 ?>
<?php
if ($clg_group == 'UG-ERO-104') { ?>
    <div class="row contentrow">
    <div class="col-md-3">
    </div>
        <div class="col-md-3" style="padding-left: 0px;">
            <table class="table bg-white brradius2 tbltd">
                <thead class="table-borderless">
                    <tr>
                        <th colspan="2" class="brradius1" style="background: #BCA1F2;">Schedule Adherence (Today)</th>
                    </tr>
                </thead>
                <tbody class="tblheight table-bordered">
                    <?php
                    if($login_details){
                    foreach ($login_details as $inc) { ?>
                        <tr>
                            <td class="pt-2" >Login Time</td>
                            <td class="pt-2"><?php echo $inc->clg_login_time; ?></td>

                        </tr>
                    <?php } } ?>
                    <tr>
                        <td class="pt-2">Briefing / Feedback Break</td>
                        <td class="pt-2"> <?php echo $tea_break ? $tea_break : '00:00:00'; ?></td>

                    </tr>
                    <tr>
                        <td class="pt-2">Meal Break</td>
                        <td class="pt-2"><?php echo $meal_break ? $meal_break : '00:00:00'; ?></td>
                    </tr>
                    <tr>
                        <td class="pt-2">Bio Break</td>
                        <td class="pt-2"><?php echo $boi_break ? $boi_break : '00:00:00'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <div class="col-md-3">
            <table class="table bg-white brradius2 tbltd">
                <thead class="table-borderless">
                    <tr>
                        <th style="border-top-left-radius: 6px !important;background: #8786FB !important;" scope="col">Calls Info</th>
                        <th scope="col" style="background: #8786FB !important;">Today</th>
                        <th style="border-top-right-radius: 6px !important;background: #8786FB !important;" scope="col">MTD</th>
                    </tr>
                </thead>
                <tbody class="tblheight table-bordered">
                    <tr>
                        <td class="pt-2">Total Calls</td>
                        <td class="pt-2"><?php echo $today_month_call; ?></td>
                        <td class="pt-2"><?php echo $total_month_call; ?></td>

                    </tr>
                    <tr>
                        <td class="pt-2">Emergency</td>
                        <td class="pt-2"><?php echo $today_month_dispatch_call; ?></td>
                        <td class="pt-2"><?php echo $total_month_dispatch_call; ?></td>


                    </tr>
                    <tr>
                        <td class="pt-2">Non-Emergency </td>
                        <td class="pt-2"><?php
                            $non_eme_calls_todays = $today_month_call - $today_month_dispatch_call;
                            echo $non_eme_calls_todays; ?></td>
                        <td class="pt-2"><?php
                            $non_eme_calls_month = $total_month_call - $total_month_dispatch_call;
                            echo $non_eme_calls_month; ?></td>
                    </tr>
                    <tr>
                        <td class="pt-2">Emergency %</td>
                        <td class="pt-2"><?php
                            $eme_per = 0;
                            if ($today_month_call > 0) {
                                $eme_per = ($today_month_dispatch_call / $today_month_call) * 100;
                            }
                            echo round($eme_per, 2);
                            ?>%</td>
                        <td class="pt-2"><?php
                            $non_eme_per = 0;
                            if ($total_month_dispatch_call > 0) {
                                $non_eme_per = ($total_month_dispatch_call / $total_month_call) * 100;
                            }
                            echo round($non_eme_per, 2);
                            ?>%</td>
                    </tr>
                </tbody>
            </table>
        </div> -->
        <div class="col-md-3">
            <table class="table bg-white brradius2 tbltd">
                <thead class="table-borderless">
                    <tr>
                        <th style="background: #9EBEF1 !important;" colspan="4" class="brradius1">Quality Performance </th>
                    </tr>
                </thead>
                <tbody class="tblheight table-bordered">
                    <tr>
                        <td class="pt-2">Audit Count</td>
                        <?php //var_dump($quality_marks);
                        if ($quality_marks['quality_score'] > 0) {
                            $quality_score = number_format($quality_marks['quality_score'] / $quality_count, 2);
                        } ?>
                        <td class="pt-2"><?php echo $quality_count; ?></td>
                        <td class="pt-2">Quality Score</td>
                        <td class="pt-2"><?php if ($quality_count > 0) {
                                echo $quality_score;
                            } else {
                                echo "0";
                            } ?></td>

                    </tr>
                    <tr>
                        <td class="pt-2">Fatal Call</td>
                        <td class="pt-2"><?php echo $quality_marks['fetal_indicator']; ?></td>
                        <td class="pt-2">Fatal Score</td>
                        <td class="pt-2"><?php if ($quality_count > 0) {
                                echo number_format(($quality_marks['fetal_indicator'] / $quality_count) * 100, 2);
                            } else {
                                echo "0";
                            } ?>%</td>

                    </tr>
                    <tr>
                        <td colspan="2" class="text-center pt-2">Performer Group </td>
                        <td colspan="2" class="text-center pt-2"><?php if ($quality_score >= '91') {
                                                                                                    echo "Performer";
                                                                                                } elseif (($quality_score <= '90') && ($quality_score >= '85')) {
                                                                                                    echo "Intermediate";
                                                                                                } elseif (($quality_score <= '84.99') && ($quality_score >= '75')) {
                                                                                                    echo "Improver";
                                                                                                } elseif ($quality_score <= '74.99') {
                                                                                                    echo "Outlier";
                                                                                                }
                                                                                                ?></td>
                        <!-- <td >Feedback %</td>
                    <td >80.20 %</td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-3">
    </div>
        <!-- <div class="col-md-3" style="padding-right: 0px;">
            <table class="table bg-white brradius2 tbltd">
                <thead class="table-borderless">
                    <tr>
                        <th style="border-top-left-radius: 6px !important;background: #39CDAB!important;">AHT</th>
                        <th style="background: #39CDAB!important;">Today</th>
                        <th style="border-top-right-radius: 6px !important;background: #39CDAB!important;">MTD</th>
                    </tr>
                </thead>
                <tbody class="tblheight table-bordered">
                    <tr>
                        <td class="pt-2">Emergency</td>
                        <td class="pt-2"><?php
                            if ($today_month_dispatch_call > 0) {
                                $eme_aht = $emergency_aht[0]->timeSum ? $emergency_aht[0]->timeSum : '00:00:00';
                                $parsed = date_parse($eme_aht);
                                $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
                                $seconds = $seconds / $today_month_dispatch_call;
                                $seconds = round($seconds);
                                $output = sprintf('%02d:%02d:%02d', ($seconds / 3600), ($seconds / 60 % 60), $seconds % 60);
                                echo $output;
                                //echo $emergency_aht[0]->timeSum?$emergency_aht[0]->timeSum:'00:00:00';
                            } else {
                                echo '00:00:00';
                            }
                            ?></td>
                        <td class="pt-2"><?php
                            if ($total_month_dispatch_call > 0) {
                                $mdt_emergency = $mdt_emergency_aht[0]->timeSum ? $mdt_emergency_aht[0]->timeSum : '00:00:00';
                                $mdt_parsed = date_parse($mdt_emergency);
                                $mdt_seconds = $mdt_parsed['hour'] * 3600 + $mdt_parsed['minute'] * 60 + $mdt_parsed['second'];
                                $mdt_seconds = $mdt_seconds / $total_month_dispatch_call;
                                $mdt_seconds = round($mdt_seconds);
                                $mdt_output = sprintf('%02d:%02d:%02d', ($mdt_seconds / 3600), ($mdt_seconds / 60 % 60), $mdt_seconds % 60);
                                echo $mdt_output;
                            } else {
                                echo '00:00:00';
                            }

                            //$mdt_emergency_aht[0]->timeSum?$mdt_emergency_aht[0]->timeSum:'00:00:00'; 
                            ?></td>

                    </tr>
                    <tr>
                        <td class="pt-2">Non-Emergency </td>
                        <td class="pt-2"><?php
                            if ($non_eme_calls_todays > 0) {
                                $non_eme_aht =  $non_emergency_aht[0]->timeSum ? $non_emergency_aht[0]->timeSum : '00:00:00';
                                $mdt_non_parsed = date_parse($non_eme_aht);
                                $mdt_non_seconds = $mdt_non_parsed['hour'] * 3600 + $mdt_non_parsed['minute'] * 60 + $mdt_non_parsed['second'];
                                $mdt_non_seconds = $mdt_non_seconds / $non_eme_calls_todays;
                                $mdt_non_seconds = round($mdt_non_seconds);
                                $mdt_non_output = sprintf('%02d:%02d:%02d', ($mdt_non_seconds / 3600), ($mdt_non_seconds / 60 % 60), $mdt_non_seconds % 60);
                                echo $mdt_non_output;
                            } else {
                                echo '00:00:00';
                            }
                            // echo $non_emergency_aht[0]->timeSum?$non_emergency_aht[0]->timeSum:'00:00:00'; 
                            ?></td>
                        <td class="pt-2"><?php
                            if ($non_eme_calls_month > 0) {

                                $non_eme_aht_mdt =  $mdt_non_emergency_aht[0]->timeSum ? $mdt_non_emergency_aht[0]->timeSum : '00:00:00';

                                $mdt_non_parsed_aht = date_parse($non_eme_aht_mdt);
                                $mdt_non_seconds_aht = $mdt_non_parsed_aht['hour'] * 3600 + $mdt_non_parsed_aht['minute'] * 60 + $mdt_non_parsed_aht['second'];

                                // echo $non_eme_calls_month;
                                $mdt_non_seconds_ahtt = $mdt_non_seconds_aht / $non_eme_calls_month;
                                $mdt_non_seconds_aht1 = round($mdt_non_seconds_ahtt);

                                $mdt_non_output_aht = sprintf('%02d:%02d:%02d', ($mdt_non_seconds_aht1 / 3600), ($mdt_non_seconds_aht1 / 60 % 60), $mdt_non_seconds_aht1 % 60);

                                echo $mdt_non_output_aht;
                            } else {
                                echo '00:00:00';
                            }

                            //echo $mdt_non_emergency_aht[0]->timeSum?$mdt_non_emergency_aht[0]->timeSum:'00:00:00'; 
                            ?></td>

                    </tr>
                    <tr>
                        <td class="pt-2">Over All </td>
                        <td class="pt-2"><?php
                            //echo $total_aht[0]->timeSum?$total_aht[0]->timeSum:'00:00:00'; 
                            if ($today_month_call > 0) {
                                $total_aht =  $total_aht[0]->timeSum ? $total_aht[0]->timeSum : '00:00:00';
                                $total_parsed_aht = date_parse($total_aht);
                                $total_seconds_aht = $total_parsed_aht['hour'] * 3600 + $total_parsed_aht['minute'] * 60 + $total_parsed_aht['second'];
                                $total_seconds_aht = $total_seconds_aht / $today_month_call;
                                $total_seconds_aht = round($total_seconds_aht);
                                $total_output_aht = sprintf('%02d:%02d:%02d', ($total_seconds_aht / 3600), ($total_seconds_aht / 60 % 60), $total_seconds_aht % 60);
                                echo $total_output_aht;
                            } else {
                                echo '00:00:00';
                            }

                            ?></td>
                        <td class="pt-2"><?php
                            //echo $mdt_total_aht[0]->timeSum?$mdt_total_aht[0]->timeSum:'00:00:00'; 
                            if ($total_month_call > 0) {
                                $mdt_total_aht =  $mdt_total_aht[0]->timeSum ? $mdt_total_aht[0]->timeSum : '00:00:00';
                                $mdt_parsed_aht = date_parse($mdt_total_aht);
                                $mdt_seconds_aht = $mdt_parsed_aht['hour'] * 3600 + $mdt_parsed_aht['minute'] * 60 + $mdt_parsed_aht['second'];
                                $mdt_seconds_aht = $mdt_seconds_aht / $total_month_call;
                                $mdt_seconds_aht = round($mdt_seconds_aht);
                                $mdt_output_aht = sprintf('%02d:%02d:%02d', ($mdt_seconds_aht / 3600), ($mdt_seconds_aht / 60 % 60), $mdt_seconds_aht % 60);
                                echo $mdt_output_aht;
                            } else {
                                echo '00:00:00';
                            }

                            ?></td>
                    </tr>
                </tbody>
            </table>
        </div> -->
    </div>
<?php } ?>

<div id="calls_inc_list">

    <form method="post" name="inc_list_form" id="inc_list">
        <div style="width: 20%; float:left;margin-top: 8px;" id="ero_dash">
            <div class="row search bg-white brradius2" id="amb_filters">
                <div class="col-md-12 brradius1" style="background: #43CFCE;">
                    <label class="txt_clr2 ">Call Details</label>
                </div>

                <!-- <?php if ($clg_senior) { ?>
                    <div class=" col-md-12 mt-2">

                        <select id="team_type" name="team_type" class="serchfnt" data-errors="{filter_required:'Team should not blank'}" TABINDEX="7" <?php echo $view; ?>>

                            <option value="">Select Team Type</option>
                            <option value='all' selected>All</option>
                            <option value="UG-ERO-102">ERO 102</option>
                            <option value="UG-ERO">ERO 108</option>

                        </select>
                    </div>
                    <div class="col-md-12 mt-2" id="ero_list_outer_qality">
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
                <?php } ?> -->
                <div class="filed_input col-md-12 mt-2">
                    <input name="from_date" tabindex="1" class="form_input serchfnt width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $from_date; ?>" readonly="readonly" id="from_date">
                </div>
                <div class="filed_input col-md-12">
                    <input name="to_date" tabindex="2" class="form_input serchfnt width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $to_date; ?>" readonly="readonly" id="to_date">
                </div>
                <div class="input col-md-12">
                    <select id="parent_call_purpose" name="call_purpose" placeholder="Select Purpose of call" class="form_input serchfnt" style="color:#666666" data-errors="{filter_required:'Purpose of call should not blank',filter_either_or:'Mobile numbers or purpose of call should not be blank.'}" data-base="search_btn" tabindex="2">
                        <option value='' selected>Select Purpose of call</option>
                        <option value='all' selected>All call</option>
                        <?php
                        foreach ($all_purpose_of_104_calls as $purpose_of_call) {
                            echo "<option value='" . $purpose_of_call->pcode . "'  ";
                            echo $select_group[$purpose_of_call->pcode];
                            echo " >" . $purpose_of_call->pname;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-12 mt-1">
                    <input type="text" class="controls amb_search serchfnt" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search" />
                </div>
                <div class="col-md-12">
                    <input name="district_id" class="mi_autocomplete width97 serchfnt" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" data-value="" value="">
                </div>
                <div class="col-md-6 mt-2 mb-4 ">
                    <input type="reset" class="search_button float_left form-xhttp-request mainbtn" style="color: #2F419B !important;" name="" value="Reset Filter" data-href="{base_url}calls" data-qr="output_position=content&amp;flt=reset&amp;type=inc" style="margin-top:0px;" />
                </div>
                <div class="col-md-6 mt-2 pl-0">
                    <input type="button" class="search_button float_left  form-xhttp-request mainbtn2 p-0 m-0"  name="" value="Search" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc" style="margin-top:0px !important;" />
                </div>
            </div>
        </div>

        <div style="width: 80%; float:right">
            <div class="row ml-2">
                <div class="col-md-12 p-0">
                    <div id="list_table" style="overflow: auto; max-height: 450px;" >

                        <table class="table report_table table-bordered tblclr width100">
                            <tr>

                                <th>Date & Time</th>
                                <th>Incident ID</th>
                                <th>Caller Name</th>
                                <th>Caller Mobile No</th>
                                <!-- <?php if ($clg_senior) { ?>
                                    <th>EMT Name</th>
                                    <th>EMT Mobile</th>
                                    <th>Pilot Name</th>
                                    <th>Pilot Mobile</th>
                                <?php } ?> -->
                                <th>ERO Name</th>
                                <th>Audio File</th>
                                <th>Call Duration</th>
                                <th>Call Type</th>

                                <!-- <th>Incident Status</th> -->
                                <!-- <th>Closure Status</th> -->


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
                                        <!-- <td><?php echo $inc->dst_name; ?></td> -->
                                        <!--                    <td ><?php echo ucwords($patient_name); ?></td>-->
                                        <!--                        <td  style="background: #FFD4A2;;"><?php echo $inc->inc_bvg_ref_number; ?></td>-->
                                        <td><a href="{base_url}calls/caller_history_number" class="onpage_popup" data-qr="output_position=popup_div&mobile_no=<?php echo $inc->clr_mobile; ?>" style="color:#000;" data-popupwidth="1900" data-popupheight="1700"><?php echo $inc->clr_mobile; ?></a></td>
                                        <!--                    <td ><?php echo $inc->inc_address; ?></td>-->
                                        <!-- <?php if ($clg_senior) { ?>
                                            <td><?php echo $inc->amb_emt_id; ?><?php //echo ucwords($inc->emt_first_name." ".$inc->emt_last_name);  
                                                                                ?></td>
                                            <td nowrap><?php echo $inc->amb_default_mobile; ?></td>
                                            <td><?php echo $inc->amb_pilot_id; ?><?php //echo ucwords($inc->clg_first_name." ".$inc->clg_last_name);  
                                                                                    ?></td>
                                            <td><?php echo $inc->amb_pilot_mobile; ?><?php //echo ucwords($inc->clg_first_name." ".$inc->clg_last_name);  
                                                                                        ?></td>
                                        <?php } ?> -->
                                        <!-- <td nowrap><?php echo $inc->amb_rto_register_no; ?></td> -->
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
                                        <!-- <td><a href="{base_url}calls/incident_Current_Status_Deatis" class="onpage_popup" data-qr="output_position=popup_div&dispatch_status=<?php echo $disptched; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>&inc_datetime=<?php echo $inc->inc_datetime; ?>" style="color:#000;" data-popupwidth="1300" data-popupheight="600"><?php echo $disptched; ?></a></td> -->
                                        <!-- <td><?php echo $closer; ?></td> -->
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



                        <div class="bottom_outer" style="bottom:0;">

                            <div class="pagination"><?php echo $pagination; ?></div>

                            <input type="hidden" name="submit_data" value="<?php
                                                                            if (@$data) {
                                                                                echo $data;
                                                                            }
                                                                            ?>">


                            <div class="record_per_pg row">
                                <div class="float_right col-md-2">
                                    <span class="btmspan"> Total records: <?php
                                                            if (@$inc_total_count) {
                                                                echo $inc_total_count;
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?> </span>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="per_page_box_wrapper col-md-4">
                                                              
                                    <span class="dropdown_pg_txt float_left btmspan "> Records per page : </span>

                                    <select name="pg_rec" class="dropdown_per_page  change-xhttp-request" data-href="{base_url}calls/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                        <?php echo rec_perpg($pg_rec); ?>

                                    </select>
                                    
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
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
    .table {
        border-bottom: 0px !important;
    }

    #content table tr {
        height: 0px;

    }

    .btmmar1 {
        padding-bottom: 15px !important;
    }

    .btmmar2 {
        padding-bottom: 30px !important;
    }

    .tblheight {
        height: 150px;
    }

    .pcr_contentpan {
        padding-top: 20px !important;
    }

    .brradius1 {
        border-top-left-radius: 6px !important;
        border-top-right-radius: 6px !important;
    }

    .brradius2 {
        border-radius: 6px;
    }

    .contentrow {
        margin-top: 50px !important;
        width: auto !important;
    }

    .contentrow2 {
        margin: 0px !important;
        width: auto !important;
    }

    .txt_clr2 {
        font-size: 15px;
        font-weight: 600;
        margin: 0px;
        padding: 10px 10px 10px 0px;
        color: white
    }

    .tblclr th {
        background-color: #E6EEF0 !important;
        color: black !important;
        font-weight: 600 !important;
        font-size: 13px;
    }
    .tblclr td {
        color: black !important;
        font-size: 13px;
    }

    .tbltd td {
        font-weight: 600 !important;
        font-size: 13px;
        padding-bottom: 0px;
        padding-top: 0px;

    }
    .tbltd th {
        font-weight: 600 !important;
        font-size: 15px;

    }

    .report_table td {
        border: 1px solid #dee2e6 !important;
    }
    .mainbtn{
        background-color: white !important;
        border-radius: 10px !important;
        border-color: #2F419B !important;
        color: #2F419B !important;
        border: 1px solid #2F419B !important;
        padding: 5px 12px !important;
        font-size: 13px !important;

    }
    .mainbtn2{
        background-color: #2F419B !important;
        border-radius: 10px !important;
        border-color: #2F419B !important;
        color: #2F419B !important;
        border: 1px solid #2F419B !important;
        padding: 5px 20px !important;
        font-size: 13px !important;
        margin-top: 5px !important;

    }
   .btmspan{
    font-weight: 600; font-size:13px;
   }
   .serchfnt{
    font-size: 13px;
   }
   table.report_table, table.report_table td {
    border: none;
    padding: 5px;
}

</style>    