<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?php
$CI = EMS_Controller::get_instance();
$this->clg = $this->session->userdata('current_user');
$closer_data = $closer_data;
$clg_group = $this->clg->clg_group;
//echo corel_encrypt_str('1113'); 
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
?>
<!-- <div class="margin_auto width70">
    <div class="dash_quality_marks text_align_center " >
		
		<strong>DCO CALL INFORMATION</strong><br>
		<table>
			<tr>
				<th style="text-align: center;">Total Closure <br>(This month)</th>
				<th style="text-align: center;">Total Victim Count<br> (This month)</th>
				<th style="text-align: center;">Average Closure Time<br> (This month)</th>
				<th style="text-align: center;">Total Closure<br> (Today)</th>
                <th style="text-align: center;">Total Victim Count<br> (Today)</th>
                <th style="text-align: center;">Average Closure Time<br> (Today)</th>
            </tr>
			<tr>
				<td><?php echo $total_month_closure; ?></td>
				<td><?php echo $total_month_Victim; ?></td>
				<td><?php echo ''; ?></td>
				<td><?php echo $total_today_closure; ?></td>
                <td><?php echo $total_today_Victim; ?></td>
				<td><?php echo ''; ?></td>
			</tr>
		</table>
		<span><?php //echo $audit_details[0]->quality_score;
                ?></span>
	</div>
</div> -->

<?php if($clg_group != 'UG-DCOSupervisor') { ?>
<div class="row contentrow">
  
    <div class="col-md-4">
        <table class="table bg-white brradius2 tbltd">
            <thead class=" table-borderless">
            <tr>
                <th colspan="2" class="brradius1" style="background: #BCA1F2;">Schedule Adherence (Today)</th>
            </tr>
            </thead>
            <tbody class="tblheight table-bordered">
                <?php foreach ($login_details as $inc) { ?>
                    <tr>
                        <td class="pt-2">Login Time</td>
                        <td class="pt-2"><?php echo $inc->clg_login_time; ?></td>

                    </tr>
                <?php } ?>
                <tr>
                    <td class="pt-2">Briefing / Feedback Break</td>
                    <td class="pt-2"><?php echo $tea_break ? $tea_break : '00:00:00'; ?></td>

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
    <div class="col-md-4">
        <table class="table bg-white brradius2 tbltd">
            <thead class="table-borderless">
                <tr>
                    <th style="border-top-left-radius: 6px !important;background: #8786FB !important;" scope="col" scope="col">Calls Info</th>
                    <th scope="col" style="background: #8786FB !important;">Today</th>
                    <th style="border-top-right-radius: 6px !important;background: #8786FB !important;" scope="col">MTD</th>
                </tr>
            </thead>
            <tbody class="tblheight table-bordered">
                <tr>
                    <td class="pt-2">Total Closure</td>
                    <td class="pt-2"><?php echo $total_today_closure; ?></td>
                    <td class="pt-2"><?php echo $total_month_closure; ?></td>

                </tr>
                <tr>
                    <td class="pt-2">Total Victim Count</td>
                    <td class="pt-2"><?php echo $total_today_Victim; ?></td>
                    <td class="pt-2"><?php echo $total_month_Victim; ?></td>

                </tr>
                <!--                <tr>
                    <td id="eroper">Average Closure Time</td>
                    <td>60</td>
                    <td>140</td>
                </tr>-->
                <tr>
                    <td class="pt-2">Total Cases Validated</td>
                    <td class="pt-2"><?php echo $today_validation; ?></td>
                    <td class="pt-2"> <?php echo $mdt_validation; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <table class="table bg-white brradius2 tbltd">
            <thead class="table-borderless">
                <tr>
                    <th style="background: #9EBEF1 !important;" colspan="4" class="brradius1" colspan="4">Quality Performance </th>
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
                    <!-- <td id="eroper2">Feedback %</td>
                    <td id="eroper3">80.20 %</td> -->
                </tr>
            </tbody>
        </table>
    </div>
    <!-- <div class="col-md-1">
    </div> -->
</div>
<?php }?>

<!--       <h3 class="txt_clr5 width2 float_left">Dashboard</h3><br>-->
<div id="data_inc_ids" style="display:none;">
    <?php echo $ambids; ?>
</div>

<form method="post" name="epcr_inc_form" id="job_closer_inc_list">
    <a class="click-xhttp-request" style="visibility: hidden;" data-href="{base_url}job_closer" data-qr="output_position=content&showprocess=no">refresh</a>
    <div id="amb_filters">

        <div class="width100">

            <div class="width15 float_left">
                <h3 class="txt_clr5 width2 float_left" style="font-size:20px;"><b>Dashboard</b></h3>
            </div>
            <?php if ($clg_senior) { ?>
                <div class="width25 float_left">
                    <select id="dco_id" name="dco_id" class="" data-errors="{filter_required:'Please select PDA from dropdown list'}">
                        <option value="">Select DCO User</option>
                        <?php
                        foreach ($dco_clg as $purpose_of_call) {
                            if ($purpose_of_call->clg_ref_id == $dco_id) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }
                            echo "<option value='" . $purpose_of_call->clg_ref_id . "'  $selected";

                            echo " >" . $purpose_of_call->clg_ref_id . "-" . $purpose_of_call->clg_first_name . " " . $purpose_of_call->clg_first_name;
                            echo "</option>";
                        }
                        ?>
                    </select>
                </div>
            <?php } ?>
            <div class="width_15 float_left margin_left10">

                <select name="filter" class="dropdown_per_page width90" data-base="search" id="epcr_filter_list">
                    <option value="">Select</option>
                    <option value="inc_datetime" <?php if ($filter == 'inc_datetime') {
                                                        echo "selected";
                                                    } ?>>Date</option>
                    <option value="dst_name" <?php if ($filter == 'dst_name') {
                                                    echo "selected";
                                                } ?>>District</option>
                    <option value="hp_name" <?php if ($filter == 'hp_name') {
                                                echo "selected";
                                            } ?>>Base Location</option>
                    <!--    <option value="clg.clg_first_name"  <?php if ($filter == 'clg.clg_first_name') {
                                                                    echo "selected";
                                                                } ?>>EMT</option>-->
                    <option value="amb_reg_no" <?php if ($filter == 'amb_reg_no') {
                                                    echo "selected";
                                                } ?>>Ambulance No</option>
                    <option value="inc_ref_id" <?php if ($filter == 'inc.inc_ref_id') {
                                                    echo "selected";
                                                } ?>>Incident ID</option>
                    <option value="close_by_emt" <?php if ($filter == 'close_by_emt') {
                                                        echo "selected";
                                                    } ?>>Closed by EMT/Pilot</option>
                    <option value="reopen_id" <?php if ($filter == 'reopen_id') {
                                                    echo "selected";
                                                } ?>>Reopen Id</option>
                                                <option value="re_close_by_emt" <?php if ($filter == 're_close_by_emt') {
                                                        echo "selected";
                                                    } ?>>Revalidate Case</option>
                    <!--                     <option value="inc.inc_bvg_ref_number"  <?php if ($filter == 'inc.inc_bvg_ref_number') {
                                                                                            echo "selected";
                                                                                        } ?>>108 Ref ID</option>-->
                </select>
            </div>
            <?php // 
            ?>
            <div id="amb_list" class="width_10 float_left" style="<?php if ($amb_reg_id != '') {
                                                                        echo 'display:block;';
                                                                    } else {
                                                                        echo 'display:none;';
                                                                    } ?>">
                <input name="amb_reg_id" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>">

                <!--                <select name="amb_reg_id" class="dropdown_per_page width97" data-base="search" >
                    <option value="">Select Ambulance</option>
<?php foreach ($amb_list as $amb) { ?>
                        <option value="<?php echo $amb->amb_rto_register_no ?>" <?php if ($amb_reg_id == $amb->amb_rto_register_no) {
                                                                                    echo 'selected';
                                                                                } ?>><?php echo $amb->amb_rto_register_no ?></option>
<?php } ?>
                </select>     -->
            </div>

            <div id="district_list" class="width_10 float_left " style="<?php if ($district_id != '' || $filter == 'close_by_emt') {
                                                                            echo 'display:block;';
                                                                        } else {
                                                                            echo 'display:none;';
                                                                        } ?>"><?php if ($district_id != '') {
                                                                                    $district_name = get_district_by_id($district_id);
                                                                                } ?>


                <input name="district_id" class="mi_autocomplete width97" data-href="{base_url}auto/get_district/<?php echo $default_state; ?>" placeholder="District" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" data-value="<?php echo $district_name; ?>" value="<?php echo $district_id; ?>">
            </div>
            <div id="baselocation_list" class="width_10 float_left " style="<?php if ($hp_id != '') {
                                                                                echo 'display:block;';
                                                                            } else {
                                                                                echo 'display:none;';
                                                                            } ?>">

                <?php if ($hp_id != '') {
                    $hp_data = get_base_location_by_id($hp_id);
                    $hp_name = $hp_data[0]->hp_name;
                } ?>
                <input name="hp_id" tabindex="7.2" class="mi_autocomplete form_input " placeholder="Base Location" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" data-href="{base_url}auto/get_hospital_with_ambu" data-value="<?php echo $hp_name; ?>" value="<?php echo $hp_id; ?>">
            </div>
            <div id="date_box" class="width_10 float_left " style="<?php if ($inc_date != '') {
                                                                        echo 'display:block;';
                                                                    } else {
                                                                        echo 'display:none;';
                                                                    } ?>">
                <input name="inc_date" tabindex="7.2" class="mi_calender form_input" placeholder="Date" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" value="<?php echo $inc_date; ?>">
            </div>
            <div id="inc_id_box" class="width_10 float_left " style="<?php if ($inc_ref_id != '' || $filter == 'close_by_emt') {
                                                                            echo 'display:block;';
                                                                        } else {
                                                                            echo 'display:none;';
                                                                        } ?>">
                <input name="inc_id" tabindex="7.2" class=" form_input" placeholder="Incident ID" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" value="<?php echo $inc_ref_id; ?>">
            </div>
            <div id="close_by_emt1" class="width_10 float_left" style="<?php if ($amb_reg_id_new != '' || $filter == 'close_by_emt') {
                                                                            echo 'display:block;';
                                                                        } else {
                                                                            echo 'display:none;';
                                                                        } ?>">
                <input name="amb_reg_id_new" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id_new; ?>" data-value="<?php echo $amb_reg_id_new; ?>">
            </div>
            <div id="amb_list_re" class="width_10 float_left" style="<?php if ($filter == 're_close_by_emt') {
                                                                        echo 'display:block;';
                                                                    } else {
                                                                        echo 'display:none;';
                                                                    } ?>">
            <input name="inc_id_re" tabindex="7.2" class=" form_input" placeholder="Incident ID" type="text" data-errors="{filter_required:'Please select hospital from dropdown list'}" value="<?php echo $inc_ref_id; ?>">
            <!-- <input name="amb_reg_id_re" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_id; ?>" data-value="<?php echo $amb_reg_id; ?>"> -->
            </div>


            <div id="epcr_call_type" class="width_10 float_left" style="<?php if ($epcr_call_types != '' || $filter == 'close_by_emt') {
                                                                            echo 'display:block;';
                                                                        } else {
                                                                            echo 'display:none;';
                                                                        } ?>">
                <?php
                if ($epcr_call_types == 1) {
                    $call_type  = "Patient Not Available";
                } elseif ($epcr_call_types == 2) {
                    $call_type  = "Patient Available";
                } elseif ($epcr_call_types == 3) {
                    $call_type  = "On Scene Care";
                }
                ?>
                <input name="epcr_call_type" tabindex="4" class="mi_autocomplete form_input " placeholder="Call Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?php echo @$epcr_call_types; ?>" data-value="<?php echo $call_type; ?>" data-href="{base_url}auto/get_call_type_epcr" data-qr="reopen=<?php echo $reopen; ?>" id="epcr_call_type">
            </div>
            <div id="provider_casetype" class="width_10 float_left" style="<?php if ($provider_casetype != '' || $filter == 'close_by_emt') {
                                                                                echo 'display:block;';
                                                                            } else {
                                                                                echo 'display:none;';
                                                                            } ?>">
                <?php if (@$provider_casetype != '') {
                    $provider_case = get_provider_case_type($provider_casetype);
                } ?>
                <input name="provider_casetype" tabindex="4" class="mi_autocomplete form_input " placeholder="Case Type" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select Case type from dropdown list'}" value="<?= @$provider_casetype; ?>" data-value="<?= @$provider_case; ?>" data-href="{base_url}auto/get_providercase_type" data-qr="" id="provider_casetype">
            </div>
            <div id="provider_impression" class="width_10 float_left" style="<?php if ($provider_impression != '' || $filter == 'close_by_emt') {
                                                                                    echo 'display:block;';
                                                                                } else {
                                                                                    echo 'display:none;';
                                                                                } ?>">
                <?php if (@$provider_impressions != '') {
                    $provider_impressions_data = get_provider_impression(@$provider_impressions);
                } ?>

                <input name="provider_impressions" tabindex="4" class="mi_autocomplete form_input " placeholder="Provider Impressions" type="text" data-base="search_btn" data-errors="{filter_required:'Plase select provider from dropdown list'}" value="<?= @$provider_impressions; ?>" data-value="<?php echo $provider_impressions_data; ?>" data-href="{base_url}auto/get_provider_imp" data-qr="">
            </div>

            <div class="float_left">
                <input type="button" class="search_button float_left form-xhttp-request mainbtn2 mt-0" name="" value="Search" data-href="{base_url}job_closer" data-qr="output_position=content&amp;flt=true" id="job_closer_autoload" />
                <input class="search_button click-xhttp-request float_right mainbtn mt-0" style="color: #2F419B !important;" name="" value="Reset Filters" data-href="{base_url}job_closer" data-qr="output_position=content&amp;filters=reset" type="button">
                <!--Daily SMS <input class="search_button click-xhttp-request float_right" name="" value="SMS" data-href="{base_url}job_closer/send_daily_sms_template" data-qr="output_position=content&amp;filters=reset" type="button">-->
            </div>
        </div>

    </div>

    <div id="list_table" class="">


        <!-- <table class="table report_table tblclr table-responsive"> -->
        <table class="table report_table tblclr">
            <tr>
                <th style="width:80px">Date</th>
                <th>Incident ID</th>
                <th nowrap>Base Location</th>
                <th nowrap>Ambulance No</th>
                <th nowrap> District Name</th>
                <?php
                if (!isset($close_by_emt)) { ?>
                    <th nowrap>EMT Name</th>
                <?php } ?>
                <th nowrap> Mobile No 1</th>
                <th nowrap> Mobile No 2</th>
                <th nowrap>Patient Count</th>
                <?php
                if ($close_by_emt == '1') {
                ?>
                    <th nowrap>Call Type</th>
                    <th nowrap>Closed By</th>
                    <th nowrap>Remark</th>
                    <th nowrap>Patient Availability</th>
                <?php
                } ?>
                <?php
                if (!isset($close_by_emt)) { ?>
                    <th>Closure</th>
                    <th>Pending</th>
                <?php } ?>
                <?php if($clg_group != 'UG-DCOSupervisor') { ?>
                <th>Action</th>
                <?php } ?>
            </tr>



            <?php
            $closure_button = array();
            $validate_button = array();
            if (count(@$inc_info) > 0) {
                $inc_offset = $inc_offset + 1;
                $total = 0;
                foreach ($inc_info as $key => $inc) {
            ?>
                    <tr id="<?php echo $inc->inc_ref_id; ?>">


                        <td><?php
                            if ($inc->inc_datetime) {
                                echo date('d-m-y', strtotime($inc->inc_datetime));
                            } else {
                                echo date('d-m-y', strtotime($inc->date));
                            }
                            ?></td>
                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;" data-popupwidth="2100" data-popupheight="1700"> <?php echo $inc->inc_ref_id; ?></a></td>


                        <td><?php echo $inc->hp_name; ?></td>

                        <!--<td><a  href="{base_url}job_closer/show_ambulance_closer_details" class="click-xhttp-request" data-qr="output_position=popup_div&amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>" style="color:#000;"><?php echo $inc->amb_rto_register_no; ?></a></td>-->
                        <td><a href="{base_url}job_closer/show_ambulance_closer_details" class="click-xhttp-request" data-qr="output_position=popup_div&amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>" style="color:#000;"><?php echo $inc->amb_rto_register_no; ?></a></td>
                        <td><?php echo $inc->dst_name; ?></td>




                        <?php
                        if (!isset($close_by_emt)) { ?>
                            <td><?php echo $inc->clg_first_name; ?> <?php echo $inc->clg_last_name; ?></td>
                        <?php } ?>
                        <td><?php echo $inc->amb_default_mobile; ?></td>
                        <td><?php echo $inc->amb_pilot_mobile; ?></td>
                        <?php
                        //$epcr_cnt = epcr_count($inc->inc_ref_id);
                        $epcr_cnt = epcr_dco_count($inc->inc_ref_id);
                        $ptn_count = ptn_count($inc->inc_ref_id);
                        ?>
                        <td align="Center"><?php echo $ptn_count; ?> </td>
                        <?php
                        if ($close_by_emt == '1') {
                            $oper = explode(',', $inc->epcr_operateby);
                            $operateby = array();
                            foreach ($oper as $op) {

                                $operateby[] = get_clg_name_by_ref_id($op);
                            }

                        ?>
                            <td align="Center"><?php echo $inc->pname; ?></td>
                            <td align="Center"><?php echo implode(',', $operateby); ?> </td>
                            <td align="Center"><?php echo $inc->remark; ?></td>

                            <?php
                            if ($inc->patient_ava_or_not != '') {
                                $epcr_call_type = $inc->patient_ava_or_not;
                            } else {
                                $epcr_call_type = $inc->epcr_call_type;
                            }
                            if ($epcr_call_type == 'no') {
                                $e_call_typ = "Patient Not Available";
                            } else if ($epcr_call_type == 'yes') {
                                $e_call_typ = "Patient Available";
                            } else if ($epcr_call_type == '3') {
                                $e_call_typ = "On Scene Care";
                            }

                            ?>
                            <td align="Center"><?php echo $e_call_typ; ?><div class="hide"><?php echo $epcr_call_type; ?></div>
                            </td>
                        <?php
                        } ?>
                        <?php
                        if (!isset($close_by_emt)) { ?>
                            <td align="Center"><?php echo $epcr_cnt; ?> </td>
                            <td align="Center"><?php echo $ptn_count - $epcr_cnt; ?> </td>
                        <?php } ?>
                        <!--                        <td style="background: #FFD4A2;"><?php echo $inc->inc_bvg_ref_number; ?></td>-->
                        <?php if($clg_group != 'UG-DCOSupervisor') { ?>
                        <td class="clouser_btn">
                            <div style="position:relative;">
                                <div class="actions_div"></div>
                                <ul class="actions_list">
                                    <?php if ($close_by_emt == '1' || $filter == 'reopen_id') {
                                        if (!in_array($inc->amb_rto_register_no, $validate_button) &&  ($inc->amb_status != 6 || $inc->amb_status != 8 || $inc->amb_status != 9 || $inc->amb_status != 10)) {

                                                //if (isset($closer_data[$inc->inc_ref_id]) && ($inc->amb_status != 6 || $inc->amb_status != 8 || $inc->amb_status != 9 || $inc->amb_status != 10)){
                                                //if (isset($closer_data[$inc->inc_ref_id])) {
                                                array_push($validate_button, $inc->amb_rto_register_no);
                                    ?>
                                        <li>
                                            <a style="width:135px !important;" href="{base_url}job_closer/epcr?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>" class="btn click-xhttp-request attend_call" data-qr="output_position=content&reopen=y">Validate </a>
                                        </li>
                                    <?php
                                        }
                                    } ?>

                                    <?php

                                    if ($CI->modules->get_tool_config('MT-PCRJC', 'M-PCRJC', $this->active_module, true) != '') {


                                        if ($this->clg->clg_group != 'UG-ADMIN' && $this->clg->clg_group != 'UG-DCO') {

                                            if (!in_array($inc->amb_rto_register_no, $closure_button) &&  ($inc->amb_status != 6 || $inc->amb_status != 8 || $inc->amb_status != 9 || $inc->amb_status != 10)) {

                                                //if (isset($closer_data[$inc->inc_ref_id]) && ($inc->amb_status != 6 || $inc->amb_status != 8 || $inc->amb_status != 9 || $inc->amb_status != 10)){
                                                //if (isset($closer_data[$inc->inc_ref_id])) {
                                                array_push($closure_button, $inc->amb_rto_register_no);
                                    ?>
                                                <!--                         <li><a href="{base_url}pcr/epcr?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>" class="btn click-xhttp-request attend_call" data-qr="output_position=content">Dispatch Closure </a> </li>-->
                                                <?php
                                                    if($revalidate_by_emt == '1'){
                                                ?>
                                                <a style="width:135px !important;" href="{base_url}job_closer/epcr_revalidate?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>" class="btn click-xhttp-request attend_call" data-qr="output_position=content&reopen=y"> Revalidate </a>
                                                <?php
                                                    }else{
                                                ?>
                                                <li><a href="{base_url}job_closer/epcr?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>&reopen_case=<?php echo $reopen_case; ?>" class="btn click-xhttp-request attend_call tblbtn" style="color: black !important;" data-qr="output_position=content"> Closure</a> </li>
                                                <?php
                                                    }
                                                ?>
                                            <?php
                                            }
                                        } else if (($this->clg->clg_group == 'UG-DCO' || $this->clg->clg_group == 'UG-EMT') && $close_by_emt != '1') {
                                            //if (isset($closer_data[$inc->inc_ref_id]) && ($inc->amb_status != 6 || $inc->amb_status != 8 || $inc->amb_status != 9 || $inc->amb_status != 10)){
                                            if (!in_array($inc->amb_rto_register_no, $closure_button) && ($inc->amb_status != 6 || $inc->amb_status != 8 || $inc->amb_status != 9 || $inc->amb_status != 10)) {
                                                array_push($closure_button, $inc->amb_rto_register_no);
                                                // var_dump($closure_button);
                                            ?>

<!-- <li><a href="{base_url}job_closer/epcr?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>&reopen_case=<?php echo $reopen_case; ?>" class="btn click-xhttp-request attend_call tblbtn" style="color: black !important;" data-qr="output_position=content"> Closure</a> </li> -->
<?php
                                                    if($revalidate_by_emt == '1'){
                                                ?>
                                                <a style="width:135px !important;" href="{base_url}job_closer/epcr_revalidate?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>" class="btn click-xhttp-request attend_call" data-qr="output_position=content&reopen=y"> Revalidate </a>
                                                <?php
                                                    }else{
                                                ?>
                                                <li><a href="{base_url}job_closer/epcr?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>&reopen_case=<?php echo $reopen_case; ?>" class="btn click-xhttp-request attend_call tblbtn" style="color: black !important;" data-qr="output_position=content"> Closure</a> </li>
                                                <?php
                                                    }
                                                ?>
                                                
                                    <?php
                                            }
                                        }
                                    }
                                    ?>

                                </ul>
                        </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            <?php } else { ?>

                <tr>
                    <td colspan="14" class="no_record_text">No Record Found</td>
                </tr>
            <?php } ?>


        </table>

        <div class="bottom_outer">

            <div class="pagination mb-4"><?php echo $pagination; ?></div>

            <input type="hidden" name="submit_data" value="<?php if (@$data) {
                                                                echo $data;
                                                            } ?>">


            <div class="width25 float_right">


                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left btmspan pt-1">Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request width20" data-href="{base_url}job_closer" data-qr="output_position=content&amp;flt=true"><?php echo rec_perpg($pg_rec); ?>
                        </select>

                    </div>

                    <div class="float_right btmspan pt-1">
                        <span>Total records : <?php if (@$total_count) {
                                                    echo $total_count;
                                                } else {
                                                    echo "0";
                                                } ?></span>


                    </div>
                </div>

            </div>



        </div>


</form>

<style>
    .table {
        border-bottom: 0px !important;
    }

    #content table tr {
        height: 0px;

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
        background-color: #39CDAB !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 13px;
        text-align: center;
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

    .mainbtn {
        background-color: white !important;
        border-radius: 10px !important;
        border-color: #2F419B !important;
        color: #2F419B !important;
        border: 1px solid #2F419B !important;
        padding: 5px 12px !important;
        font-size: 13px !important;

    }

    .mainbtn2 {
        background-color: #2F419B !important;
        border-radius: 10px !important;
        border-color: #2F419B !important;
        color: #2F419B !important;
        border: 1px solid #2F419B !important;
        padding: 5px 20px !important;
        font-size: 13px !important;
        /* margin-top: 5px !important; */

    }

    .btmspan {
        font-weight: 600;
        font-size: 13px;
    }

    .serchfnt {
        font-size: 13px;
    }

    table.report_table,
    table.report_table td {
        border: none;
        padding: 5px;
    }

    .tblht {
        overflow: auto;
        max-height: 370px;
    }

    .tblbtn {
        padding: 4px !important;
        background: #edd8da !important;

    }

    .width20 {
        width: 20% !important;
    }

    .margin_left10 {
        margin-left: 10px;
    }
</style>