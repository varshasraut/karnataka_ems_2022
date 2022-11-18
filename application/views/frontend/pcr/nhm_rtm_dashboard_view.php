<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

?>

<!-- <?php //if($clg_group != 'UG-DCOSupervisor') { ?> -->
<!-- <div class="row contentrow"> -->
  
    <!-- <div class="col-md-4">
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
    </div> -->
    <!-- <div class="col-md-4">
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
                            <tr>
                    <td id="eroper">Average Closure Time</td>
                    <td>60</td>
                    <td>140</td>
                </tr>
                <tr>
                    <td class="pt-2">Total Cases Validated</td>
                    <td class="pt-2"><?php echo $today_validation; ?></td>
                    <td class="pt-2"> <?php echo $mdt_validation; ?></td>
                </tr>
            </tbody>
        </table>
    </div> -->

    <!-- <div class="col-md-4">
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
                     <td id="eroper2">Feedback %</td>
                    <td id="eroper3">80.20 %</td> 
                </tr>
            </tbody>
        </table>
    </div> -->
    <!-- <div class="col-md-1">
    </div> -->
<!-- </div> -->
<!-- <?php //}?> -->

<!--       <h3 class="txt_clr5 width2 float_left">Dashboard</h3><br>-->
    <div class="modal loginmodal" tabindex="-1" role="dialog" id="logindetails">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="font-weight: bold;">Remark</h5>

              <button type="button" class="close" onclick="hidepopup()" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body" style="margin: 17px;">
              <!-- <form method="post"> -->
              <div>
                <textarea name="remark" placeholder="Remark ..." id="remark" style="font-family:sans-serif;font-size:1.2em;"></textarea>
              </div>
              <input type="hidden" id="inc_id" name="inc_id">
              <input type="hidden" id="base_loc" name="base_loc">
              <input type="hidden" id="amb_no" name="amb_no">
              <input type="hidden" id="amb_aug" name="amb_aug">
              <input type="hidden" id="dis_time" name="dis_time">
              <input type="hidden" id="dst_name" name="dst_name">
              <input type="submit" name="save" value="Submit" onclick="submit_remark();">
              <!-- </form> -->
            </div>
          </div>
        </div>
      </div>
      <div class="modal loginmodal" tabindex="-1" role="dialog" id="remarkdetails">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" style="font-weight: bold;">Remark Details</h5>

              <button type="button" class="close" onclick="hidepopup()" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body" style="margin: 17px;">
              <div class="row">
                <b class="col-2" style="padding: 0;">Remark : </b>
                <div class="col-10" id="user_remark"></div><br />
              </div>
              <div class="row">
                <b class="col-4" style="padding: 0;">Remark Given By : </b>
                <div class="col-6" id="added_by"></div>
              </div>
              <div class="row">
                <b class="col-4" style="padding: 0;">Added Time : </b>
                <div class="col-8" id="added_date"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

<div id="data_inc_ids" style="display:none;">
    <?php echo $ambids; ?>
</div>

<form method="post" name="epcr_inc_form" id="job_closer_inc_list" class="mt-3">
    <a class="click-xhttp-request" style="visibility: hidden;" data-href="{base_url}job_closer/nhm_closure_data_rtm" data-qr="output_position=content&showprocess=no">refresh</a>
    <div id="amb_filters">

        <div class="width100">

            <div class="width15 float_left">
                <h3 class="txt_clr5 width2 float_left" style="font-size:20px;"><b>Dashboard</b></h3>
            </div>
            <?php// if ($clg_senior) { ?>
                <!-- <div class="width25 float_left">
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
                </div> -->
            <?php //} ?>
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
                    <!-- <option value="close_by_emt" <?php if ($filter == 'close_by_emt') {
                                                        echo "selected";
                                                    } ?>>Closed by EMT/Pilot</option> -->
                    <!-- <option value="reopen_id" <?php if ($filter == 'reopen_id') {
                                                    echo "selected";
                                                } ?>>Reopen Id</option> -->
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
                <input type="button" class="search_button float_left form-xhttp-request mainbtn2 mt-0" name="" value="Search" data-href="{base_url}job_closer/nhm_closure_data_rtm" data-qr="output_position=content&amp;flt=true" id="job_closer_autoload" />
                <input class="search_button click-xhttp-request float_right mainbtn mt-0" style="color: #2F419B !important;" name="" value="Reset Filters" data-href="{base_url}job_closer/nhm_closure_data_rtm" data-qr="output_position=content&amp;filters=reset" type="button">
                <!--Daily SMS <input class="search_button click-xhttp-request float_right" name="" value="SMS" data-href="{base_url}job_closer/send_daily_sms_template" data-qr="output_position=content&amp;filters=reset" type="button">-->
            </div>
        </div>

    </div>

    <div id="list_table" class="">


        <!-- <table class="table report_table tblclr table-responsive"> -->
        <table class="table report_table tblclr">
            <tr>
                <th>Date</th>
                <th>Incident ID</th>
                <th nowrap>Base Location</th>
                <th nowrap>Ambulance No</th>
                <th nowrap> District Name</th>
                <th nowrap> Ambulance CUG No</th>
                 <th nowrap>Type</th> 
                <!-- <th nowrap>Patient Count</th> -->
                <th nowrap> Dispatch Time</th>
                <th nowrap>Start From</th>
                <th nowrap>On Scene</th>
                <th nowrap>Back To Base</th>
                <th nowrap> Incident Status</th>
                <!--<th nowrap> Caller Number</th>
                <th nowrap> Caller Name</th>-->
                <th nowrap>ERO Name</th>
                <th nowrap>GPS Action</th>
             
                <th>Action</th>
                
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
                                echo date('d-m-y h:m:s', strtotime($inc->inc_datetime));
                            } else {
                                echo date('d-m-y', strtotime($inc->date));
                            }
                            ?></td>
                        <td><a href="{base_url}calls/single_record_view" class="onpage_popup" data-qr="output_position=popup_div&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" style="color:#000;" data-popupwidth="2100" data-popupheight="1700"> <?php echo $inc->inc_ref_id; ?></a></td>

                           
                        <td><?php echo $inc->base_location_name; ?></td>

                        <td><?php echo $inc->amb_reg_id; ?></a></td>
                        <td><?php echo $inc->dst_name; ?></td>
                        <td><?php echo $inc->amb_default_mobile; ?></td>
                        <td><?php echo $inc->pname?></td>
                        <td><?php echo $inc->inc_datetime ?></td>
                        <td><?php echo $inc->dp_started_base_loc ?></td>
                        <td><?php echo $inc->dp_on_scene ?></td>
                        <td><?php echo $inc->dp_back_to_loc ?></td>
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
                                        
                                        ?>
                                        <td><a href="{base_url}calls/incident_Current_Status_Deatis" class="onpage_popup" data-qr="output_position=popup_div&dispatch_status=<?php echo $disptched; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>&inc_datetime=<?php echo $inc->inc_datetime; ?>" style="color:#000;" data-popupwidth="1300" data-popupheight="600"><?php echo $disptched; ?></a></td>
                                        <!--<td><?php echo $inc->clr_mobile; ?></td>
                                        <?php
                                        $caller_name = $inc->clr_fname . "  " . $inc->clr_mname . "  " . $inc->clr_lname;
                                        ?>
                                        <td><?php echo ucwords($caller_name); ?></td>-->
                                        <td nowrap><?php echo ucwords(strtolower($inc->clg_first_name . " " . $inc->clg_last_name)); ?></td>
   
                                        <td class="text-center"><i class='fa fa-map-marker' style='font-size:30px;cursor: pointer;' Onclick='gps_status("<?php echo date("d-m-Y H:m:s",strtotime($inc->inc_recive_time));?>","<?php echo date("d-m-Y H:m:s",strtotime($inc->inc_datetime));?>","<?php echo $inc->amb_reg_id;?>")'></i><br>
                                            
                                        <!-- <td class="text-center"><a href="http://13.235.213.74/jsp/VehicleTracking.jsp?vehicle_no=<?php echo $amb_veh_no?>&from_datetime=<yyyy-MM-dd%20HH:mm>&to_datetime=<yyyy-MM-dd%20HH:mm>" target="_blank"  Onclick='gps_status("<?php echo $inc->amb_rto_register_no; ?>");'><i class='fa fa-map-marker' style='font-size:30px;cursor: pointer;' ></i></a></td> -->
                                        <td class="text-center"><i class='fa fa-comments ' style='font-size:30px;cursor: pointer;' Onclick='saveremark("<?php echo $inc->inc_ref_id;?>","<?php echo $inc->amb_rto_register_no;?>","<?php echo $inc->hp_name; ?>","<?php echo $inc->amb_default_mobile; ?>","<?php echo $inc->inc_datetime;?>","<?php echo $inc->dst_name; ?>")'></i><br>
                                        <!-- <i class='fa fa-eye' style='font-size:25px;cursor: pointer;color:green;' aria-hidden='true' Onclick='displayremark("<?php echo $inc->inc_ref_id; ?>")'></i></td> -->
                       
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

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request width20" data-href="{base_url}job_closer/nhm_closure_data_rtm" data-qr="output_position=content&amp;flt=true"><?php echo rec_perpg($pg_rec); ?>
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
<script>
    function saveremark(inc_id,amb_no,base_loc,amb_aug,dis_time,dst_name) {
    // alert(dis_time);
    $('#inc_id').val(inc_id);
    $('#base_loc').val(base_loc);
    $('#amb_no').val(amb_no);
    $('#amb_aug').val(amb_aug);
    $('#dis_time').val(dis_time);
    $('#dst_name').val(dst_name);
    $('#logindetails').show();
    $("input[type=text], textarea").val("");

  }
  function displayremark(inc_id) {
    // alert(amb_id)
    // $('#remarkdetails').show();

    $.post('<?= site_url('Job_closer/show_remark_data') ?>', {
    inc_id
    }, function(data) {
        // alert(data);
      var new_var = JSON.parse(data);
     
      // var remark = data['remark'];
      console.log(new_var);  
      // console.log(data);
      var added_by = new_var.clg_first_name + " " + new_var.clg_mid_name + " " + new_var.clg_last_name;
      var not_added_by = new_var.clg_first_name + new_var.clg_mid_name + new_var.clg_last_name;
      var added_date = new_var.added_date;
      var remark = new_var.remark + "<br>" + "<br>";
      var remarkgiven = new_var.remark;

      var nullremark = 'Remark Not Given Yet..!';
      //  alert(added_by);
      if (remarkgiven == " " || remarkgiven == null) {
        var remarknew = nullremark;
      } else {

        var remarknew = remark;
      }

      var nulladdedby = '';
      if (not_added_by == " " || not_added_by == null) {
        var addedbynew = nulladdedby;
      } else {
        var addedbynew = added_by;
      }

      $('#added_by').html(addedbynew);
      $('#added_date').html(added_date);
      $('#user_remark').html(remarknew);

      $('#remarkdetails').show();
    });
  }

  function hidepopup() {
    $("#logindetails").hide();
    $("#remarkdetails").hide();
  }
  function submit_remark() {
    // alert('ff');
    var inc_id = $('#inc_id').val();
    var base_loc = $('#base_loc').val();
    var amb_no = $('#amb_no').val();
    var amb_aug = $('#amb_aug').val();
    var dis_time = $('#dis_time').val();
    var dst_name = $('#dst_name').val();
    var remark = $('#remark').val();
    if (remark == "") {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please Enter Remark!',
      })
    } else {
      $.post('<?= site_url('Job_closer/save_remark_data') ?>', {
        inc_id,
        base_loc,
        amb_no,
        amb_aug,
        dis_time,
        dst_name,
        remark
      }, function(data) {
        //  alert(data);
        $('#logindetails').hide();
        // Swal.fire('Remark Save Successfully..!!');

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Remark Saved Successfully..!!',
          showConfirmButton: false,
          timer: 2000
        });

      });
      document.getElementsByClassName("fa fa-eye")[0].style.color = "red";
    }

  }
  function gps_status(inc_recive_time,inc_datetime,amb_reg_no){
    var amb_reg_no = amb_reg_no;
    amb_reg_no = amb_reg_no.replace (/-/g, "");

    // alert(inc_recive_time);
    amb_reg_no = "CG04NR7738";
    // inc_recive_time = "01-09-2022 10:53:27";
    // inc_datetime = "01-09-2022 11:10:57";
    window.open('http://13.235.213.74/webservice?token=redirectToShowpathJSP&vehicle_no='+ amb_reg_no +'&from_date='+ inc_recive_time +'&to_date='+ inc_datetime +'');
    
    // window.open('http://13.235.213.74/jsp/VehicleTracking.jsp?vehicle_no='+ amb_reg_no +'&from_datetime='+ inc_recive_time +'&to_datetime='+ inc_datetime +'');
  }

</script>