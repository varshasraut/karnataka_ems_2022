<?php
$CI = EMS_Controller::get_instance();
defined('BASEPATH') or exit('No direct script access allowed');


$arr = array(
    'page_no' => @$page_no,
    'records_on_page' => @$page_load_count,
    'dashboard' => 'yes'
);

$data = json_encode($arr);
$data = base64_encode($data);
?>
<?php
//$step = array('INCIDENT', 'CNS', 'HIS', 'AS1', 'TRA', 'AS2', 'MG1', 'MG2', 'HPT', 'DPR');
//if(!$init_step){
//    foreach ($step as $stp) {
//
//        if ($step_com) {
//
//            if (!in_array($stp, $step_com)) {
//
//                $filter_step[$stp] = 'incomplete_step';
//            }
//        } else {
//            $filter_step[$stp] = 'incomplete_step';
//        }
//    }
//}
?>
<?php if ($clg_group != 'UG-DCO' && $clg_group != 'UG-FLD-OPE-DESK' && $clg_group != 'UG-DCO-102' && $clg_group != 'UG-BIKE-DCO' && $clg_group != 'UG-DCOSupervisor' && $clg_group != 'UG-DM' && $clg_group != 'UG-ZM' && $clg_group != 'UG-REMOTE-SUPER-ADMIN') { ?>
    <div class="width100" style="min-height: 200px;" id="supervisor_medicle">

        <!--        <a id="superAdmin_medicle_disptched_link" class="click-xhttp-request" style="visibility: hidden;" data-href="{base_url}supervisor/medical_dispatch" data-qr="output_position=content&showprocess=no">refresh</a>-->
        <div class="header_top_link">

            <ul id="incedence_steps">
                <li class='active_supervisor_nav headli1'><a class="click-xhttp-request " href="{base_url}supervisor/medical_dispatch" data-qr="output_position=content"> Medical Dispatch Queue</a></li>
                <li class="headli2"><a class="click-xhttp-request" href="{base_url}supervisor/police_dispatch" data-qr="output_position=content">Police Dispatch Queue</a></li>
                <li class="headli3"><a class="click-xhttp-request" href="{base_url}supervisor/fire_dispatch" data-qr="output_position=content"> Fire Dispatch Queue</a></li>
                <li class="headli4"><a id="supervisor_other_call" class="click-xhttp-request" href="{base_url}supervisor/other_calls" data-qr="output_position=content"> Other Calls</a></li>
                <div class="list_icon float_left"><img src="{base_url}themes/backend/images/icon_img.png" class="nav_icon" alt="Menu"> <a class="hide menu_titile">MENU</a></div>
            </ul>

        </div>


        <div id="supervisor_container">

            <div id="calls_inc_list">
                <form method="post" name="inc_list_form" id="inc_list1">
                    <div class="width100" id="ero_dash">
                        <div id="amb_filters">
                            <div class="width100 float_left">

                                <div class="search">

                                    <div class="row">

                                        <div class="width100 float_left">
                                            <div class="width_20 float_left">
                                                <h3 class="txt_clr2 ">Medical Dispatch Queue</h3>
                                            </div>
                                            <div class="width4 float_left">
                                                <input type="text" class="controls amb_search" id="mob_no3" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search" />
                                            </div>

                                            <div class="width_30 float_left">

                                                <input type="button" name="" value="Search" data-href="{base_url}supervisor/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc" tabindex="2" autocomplete="off" class="search_button float_righ  form-xhttp-request">
                                                <input name="" value="Reset Filters" data-href="{base_url}supervisor/medical_dispatch" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="3" autocomplete="off" class="search_button click-xhttp-request">
                                            </div>
                                            <!-- <div class="width_14 float_left">
                                            <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}supervisor/medical_dispatch" data-qr="output_position=content&amp;filters=reset" type="button" tabindex="2" autocomplete="off">
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="list_table">

                            <table class="table report_table">
                                <tr>
                                    <th nowrap>Date / Time</th>
                                    <th nowrap>Call Type</th>
                                    <th nowrap> Caller Number </th>
                                    <th nowrap>Caller Name</th>
                                    <th nowrap>Incident ID</th>
                                    <!--<th nowrap>Incident Address</th>-->
                                    <th nowrap>District </th>
                                    <th nowrap>Ambulance No</th>
                                    <th nowrap>Base Location</th>
                                    <th nowrap>Call Duration</th>
                                    <th nowrap>Ameyo ID</th>
                                    <th nowrap>ERO Name</th>


                                </tr>
                                <?php
                                if (!empty($inc_info) > 0) {



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

                                        //                                    if ($inc->clr_fullname != '') {
                                        //                                        $caller_name = $inc->clr_fullname;
                                        //                                    } else {
                                        $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
                                        //                                    }
                                ?>

                                        <tr>
                                            <td nowrap><?php echo date("d-m-Y h:i:s", strtotime($inc->inc_datetime)); ?></td>
                                            <td><?php echo ucwords($inc->pname); ?></td>
                                            <td nowrap><?php echo $inc->clr_mobile; ?></td>
                                            <td nowrap><?php echo ucwords($caller_name); ?></td>
                                            <td nowrap><?php echo $inc->inc_ref_id; ?></td>

                                            <!--<td ><?php echo $inc->inc_address; ?></td>-->
                                            <td nowrap><?php echo $inc->dst_name; ?></td>
                                            <td nowrap><?php echo $inc->amb_rto_register_no; ?></td>
                                            <td style="width:70%!important;"><?php echo $inc->hp_name; ?></td>

                                            <td nowrap><?php echo ($inc->inc_dispatch_time); ?></td>
                                            <td nowrap><?php echo ($inc->clg_avaya_id); ?></td>
                                            <td nowrap><?php echo ucwords(strtolower($inc->clg_first_name . " " . $inc->clg_last_name)); ?></td>

                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>
                                        <td colspan="11" class="no_record_text">No Record Found</td>
                                    </tr>
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

                                            <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/ero_dash" data-qr="output_position=content&amp;flt=true&amp;type=inc">
                                                <?php echo rec_perpg_sup($pg_rec); ?>



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
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php } ?>

<div class="width100">
    <div id="list_table">



        <!-- 
                            $closure_pending_count ="Total Diapatch Count";
                        $zero_to_two="Between 0 to 2 Hours";
                        $two_to_six="Between 2 to 6 Hours"; 
                        $six_to_twelve="Between 6 to 12 Hours"; 
                        $twelve_to_eighteen="Between 12 to 18 Hours";
                        $eighteen_to_twenty_four="Between 18 to 24 Hours";
                        $more_than_twenty_four="More than 24 Hours";   
                        -->



        <table class="table report_table tblclr table-responsive">
            <tr>
                <th>Total Closure Pending Count</th>

                <th nowrap>Between 0 to 2 Hours</th>
                <th nowrap>Between 2 to 6 Hours</th>
                <th nowrap>Between 6 to 12 Hours</th>
                <th nowrap>Between 12 to 18 Hours</th>
                <th nowrap>Between 18 to 24 Hours</th>
                <th nowrap>More than 24 Hours</th>
            </tr>

            <tr>

                <td class="text_align_center"><?php echo $closure_pending_count; ?></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/closure_pending_popup" data-qr="output_position=content&amp;filter_time=0_2" data-popupwidth="1500" data-popupheight="900">
                        <?php echo $zero_to_two; ?></a></td>

                <td class="text_align_center"> <a class="single onpage_popup" data-href="{base_url}supervisor/closure_pending_popup" data-qr="output_position=content&amp;filter_time=2_6" data-popupwidth="1500" data-popupheight="900"><?php echo $two_to_six; ?> </a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/closure_pending_popup" data-qr="output_position=content&amp;filter_time=6_12" data-popupwidth="1500" data-popupheight="900"><?php echo $six_to_twelve; ?></a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/closure_pending_popup" data-qr="output_position=content&amp;filter_time=12_18" data-popupwidth="1500" data-popupheight="900"><?php echo $twelve_to_eighteen; ?></a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/closure_pending_popup" data-qr="output_position=content&amp;filter_time=18_24" data-popupwidth="1600" data-popupheight="900"><?php echo $eighteen_to_twenty_four; ?></a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/closure_pending_popup" data-qr="output_position=content&amp;filter_time=24_more" data-popupwidth="1600" data-popupheight="900"><?php echo $more_than_twenty_four; ?></a></td>
            </tr>
        </table>
        <table class="table report_table tblclr table-responsive">
            <tr>
                <th>Total Validation Pending Count</th>

                <th nowrap>Between 0 to 2 Hours</th>
                <th nowrap>Between 2 to 6 Hours</th>
                <th nowrap>Between 6 to 12 Hours</th>
                <th nowrap>Between 12 to 18 Hours</th>
                <th nowrap>Between 18 to 24 Hours</th>
                <th nowrap>More than 24 Hours</th>
            </tr>
            <tr>

                <td class="text_align_center"><?php echo $validation_pending_count; ?></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/validation_pending_popup" data-qr="output_position=content&amp;filter_time=0_2" data-popupwidth="1500" data-popupheight="900">
                        <?php echo $validation_zero_to_two; ?></a></td>

                <td class="text_align_center"> <a class="single onpage_popup" data-href="{base_url}supervisor/validation_pending_popup" data-qr="output_position=content&amp;filter_time=2_6" data-popupwidth="1500" data-popupheight="900"><?php echo $validation_two_to_six; ?> </a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/validation_pending_popup" data-qr="output_position=content&amp;filter_time=6_12" data-popupwidth="1500" data-popupheight="900"><?php echo $validation_six_to_twelve; ?></a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/validation_pending_popup" data-qr="output_position=content&amp;filter_time=12_18" data-popupwidth="1500" data-popupheight="900"><?php echo $validation_twelve_to_eighteen; ?></a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/validation_pending_popup" data-qr="output_position=content&amp;filter_time=18_24" data-popupwidth="1600" data-popupheight="900"><?php echo $validation_eighteen_to_twenty_four; ?></a></td>

                <td class="text_align_center"><a class="single onpage_popup" data-href="{base_url}supervisor/validation_pending_popup" data-qr="output_position=content&amp;filter_time=24_more" data-popupwidth="1600" data-popupheight="900"><?php echo $validation_more_than_twenty_four; ?></a></td>
            </tr>
        </table>
        <table class="table report_table tblclr table-responsive">
            <tr>
                <th>Total Pending Count</th>

                <th nowrap>Between 0 to 2 Hours</th>
                <th nowrap>Between 2 to 6 Hours</th>
                <th nowrap>Between 6 to 12 Hours</th>
                <th nowrap>Between 12 to 18 Hours</th>
                <th nowrap>Between 18 to 24 Hours</th>
                <th nowrap>More than 24 Hours</th>
            </tr>
            <tr>

                <td class="text_align_center"><?php echo $validation_pending_count+$closure_pending_count; ?></td>

                <td class="text_align_center"><?php echo $validation_zero_to_two+$zero_to_two; ?></a></td>

                <td class="text_align_center"><?php echo $validation_two_to_six+$two_to_six; ?></td>

                <td class="text_align_center"><?php echo $validation_six_to_twelve+$six_to_twelve; ?></td>

                <td class="text_align_center"><?php echo $validation_twelve_to_eighteen+$twelve_to_eighteen; ?></td>

                <td class="text_align_center"><?php echo $validation_eighteen_to_twenty_four+ $eighteen_to_twenty_four; ?></td>

                <td class="text_align_center"><?php echo $validation_more_than_twenty_four+$more_than_twenty_four; ?></td>
            </tr>
        </table>

        <!-- <div class="bottom_outer">

            <div class="pagination"><?php echo $amb_pagination; ?></div>

            <input type="hidden" name="submit_data" value="<?php
                                                            if (@$data) {
                                                                echo $data;
                                                            }
                                                            ?>">


        </div> -->
    </div>
    <div class="header_top_link">

        <ul id="ambulance_steps">

            <?php if ($clg_group != 'UG-FLD-OPE-DESK') { ?>
                <li class='active_supervisor_nav headli1'><a class="click-xhttp-request" href="{base_url}supervisor/assign_ambulance_list" data-qr="output_position=content">Assign Ambulance List</a></li>

            <?php } ?>
            <li class="headli2"><a class="click-xhttp-request" href="{base_url}supervisor/available_ambulance_list" data-qr="output_position=content">Available Ambulance List</a></li>

            <li class="headli3"><a class="click-xhttp-request" href="{base_url}supervisor/other_ambulance_list" data-qr="output_position=content"> Off-road Ambulance</a></li>
            <div class="list_icon float_left"><img src="{base_url}themes/backend/images/icon_img.png" class="nav_icon" alt="Menu"> <a class="hide menu_titile">MENU</a></div>
        </ul>

    </div>
    <div id="supervisor_container_amb">

        <!--<h3 class="txt_clr5 width2 float_left">ERO Dashboard</h3><br>-->

        <div id="calls_inc_list_amb">


            <div class="width100" id="ero_dash">


                <div id="amb_filters">
                    <div class="width80 float_left">

                        <div class="search">

                            <div class="row">

                                <div class="width100 float_left">
                                    <div class="width20 float_left">
                                        <h3 class="txt_clr2 ">Assign Ambulance List</h3>
                                    </div>
                                    <form method="post" name="inc_list_form" id="inc_list">
                                        <div class="width20 float_left">
                                            <input type="text" class="controls amb_search" id="mob_no" name="call_search" value="<?php echo @$rg_no; ?>" placeholder="Search" />
                                        </div>
                                        <?php if ($clg_group != 'UG-DM') { ?>
                                        <div class="width20  float_left">

                                            <!-- <select name="dist_search" class="filter_required" data-errors="{filter_required:'District should not be blank!'}"> -->
                                            <select name="dist_search_assign">
                                                <option value="">Select District</option>
                                                <?php foreach ($district_data as $key) { ?>
                                                    <option value="<?php echo $key->dst_code ?>"><?php echo $key->dst_name ?></option>
                                                <?php  } ?>

                                            </select>
                                        </div>
                                      

                                        <div class="width20  float_left">

                                            <input name="amb_no_search_assign" class="mi_autocomplete dropdown_per_page width97" data-href="{base_url}auto/get_ambulance" placeholder="Select Ambulance" data-errors="{filter_required:'Please select state from dropdown list'}" tabindex="15" autocomplete="off" value="<?php echo $amb_reg_no; ?>" data-value="<?php echo $amb_reg_no; ?>">

                                            <input type="hidden" name="req_type" value="amb">

                                        </div>
                                        <?php  } ?>
                                        <div class="width11 float_left">
                                            <input type="button" class="search_button float_right mainbtn2 form-xhttp-request" name="" value="Search" data-href="{base_url}supervisor/assign_ambulance_list" data-qr="output_position=content&amp;flt=true&amp;type=inc" />
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="width20 float_left">

                        <form action="<?php echo base_url(); ?>supervisor/download_assign_ambulance_list" method="post" enctype="multipart/form-data" target="form_frame">
                            <input type="hidden" value="<?php echo $report_args['call_search']; ?>" name="call_search">
                            <input type="hidden" value="<?php echo $report_args['dist_search_assign']; ?>" name="dist_search_assign">
                            <input type="hidden" value="<?php echo $report_args['amb_no_search_assign']; ?>" name="amb_no_search_assign">
                            <input type="submit" name="submit" value="Download" TABINDEX="3" class="float_right mainbtn2">
                        </form>
                        <iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
                    </div>
                </div>

                
                <div id="list_table">

                    <table class="table report_table tblclr">

                        <tr>
                            <th>Sr.No</th>
                            <th nowrap>Ambulance No</th>
                            <th nowrap>Last assign time</th>
                            <th nowrap>Base Location</th>
                            <th nowrap>District </th>
                            <th nowrap>Ambulance Type</th>
                            <th nowrap>Incident ID</th>
                            <th nowrap>Incident Address</th>
                            <th nowrap>Caller Number-Name </th>
                            <th nowrap>Chief Complaint</th>
                            <th nowrap>Closure Pending From</th>
                            <?php if ($clg_group != 'UG-DM' && $clg_group != 'UG-ZM' && $clg_group != 'UG-REMOTE-SUPER-ADMIN') {
                            ?>
                                <th nowrap>Action</th>
                            <?php } ?>
                            <th nowrap>Changes</th>
                        </tr>

                        <?php
                        if (!empty($result) > 0) {

                            $total = 0;
                            $cur_page_sr = ($cur_page - 1) * 20;
                            foreach ($result as $key => $inc) {

                                $current_time = date('Y-m-d H:i:s');

                                $first_date = new DateTime($current_time);

                                $second_date = new DateTime($inc->timestamp);

                                $interval = $first_date->diff($second_date);

                                $days_passed = $interval->format('%a');
                                $hours_diff = $interval->format('%H');
                                $min = $interval->format('%I');
                                $sec = $interval->format('%S');

                                $diff_time = ($days_passed * 24 + $hours_diff) . ':' . $min . ':' . $sec;

                                if ($inc->clr_fullname != '') {
                                    $caller_name = $inc->clr_fullname;
                                } else {
                                    $caller_name = $inc->clr_fname . " " . $inc->clr_mname . " " . $inc->clr_lname;
                                }
                        ?>

                                <tr>
                                    <td><?php echo $cur_page_sr + $key + 1; ?></td>
                                    <td nowrap><?php echo $inc->amb_rto_register_no; ?></td>
                                    <td><?php
                                        if ($inc->timestamp) {
                                            echo date("d-m-Y h:i:s", strtotime($inc->timestamp));
                                        } else {
                                            echo "-";
                                        }
                                        ?></td>
                                    <td><?php echo $inc->hp_name; ?></td>
                                    <td><?php echo $inc->dst_name; ?></td>
                                    <td><?php echo $inc->ambt_name; ?></td>

                                    <td>
                                        <a class="single onpage_popup" data-href="{base_url}calls/single_record_view?inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="1500" data-popupheight="900"><?php echo $inc->inc_ref_id; ?>
                                        </a>
                                    </td>





                                    <td><?php echo $inc->inc_address; ?></td>

                                    <td><?php
                                        echo $inc->clr_mobile;
                                        echo "-";
                                        echo ucwords($caller_name);
                                        ?></td>

                                    <?php if ($inc->inc_mci_nature != '') { ?>
                                        <td><?php echo $inc->ct_type; //get_mci_nature_service($inc->inc_mci_nature); 
                                            ?></td>
                                    <?php } else { ?>
                                        <td><?php echo $inc->ct_type; ?></td>
                                    <?php } ?>
                                    <td><?php echo $diff_time; ?></td>



                                    <?php if ($clg_group != 'UG-DM' && $clg_group != 'UG-ZM' && $clg_group != 'UG-REMOTE-SUPER-ADMIN') {
                                    ?>
                                        <td> <a class="click-xhttp-request onpage_popup btn" data-href="{base_url}supervisor/remark?amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="300" data-popupheight="300">Action</a>
                                        <?php } ?>
                                        </td>

                                        <td>
                                            <?php if ($clg_group != 'UG-DM' && $clg_group != 'UG-ZM' && $clg_group != 'UG-REMOTE-SUPER-ADMIN') {
                                            ?>
                                                <a class="onpage_popup float_left btn" data-href="{base_url}supervisor/release?amb_rto_register_no=<?php echo $inc->amb_rto_register_no; ?>&inc_ref_id=<?php echo $inc->inc_ref_id; ?>" data-qr="output_position=popup_div" data-popupwidth="300" data-popupheight="300">Release</a>

                                            <?php

                                            } ?>

                                            <a class="click-xhttp-request onpage_popup btn float_left" data-href="{base_url}inc/show_amb_clo_pending" data-qr="output_position=popup_div&amb_reg_no=<?php echo $inc->amb_rto_register_no; ?>">Pending</a>

                                            <!-- <a href="{base_url}job_closer/epcr?inc_id=<?php echo base64_encode($inc->inc_ref_id); ?>" class="btn float_left click-xhttp-request" data-qr="output_position=content" >Closure</a> -->
                                        </td>
                                </tr>
                            <?php } ?>

                        <?php } else { ?>

                            <tr>
                                <td colspan="11" class="no_record_text">No Record Found</td>
                            </tr>



                        <?php } ?>




                    </table>



                    <div class="bottom_outer">

                        <div class="pagination"><?php echo $amb_pagination; ?></div>

                        <input type="hidden" name="submit_data" value="<?php
                                                                        if (@$data) {
                                                                            echo $data;
                                                                        }
                                                                        ?>">

                        <div class="width33 float_right">

                            <div class="record_per_pg">

                                <div class="per_page_box_wrapper">

                                    <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                    <select name="pg_rec_amb" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}supervisor/assign_ambulance_list" data-qr="output_position=content&amp;flt=true&amp;type=inc">

                                        <?php echo rec_perpg_sup($pg_rec); ?>

                                    </select>

                                </div>

                                <div class="float_right">
                                    <span> Total records: <?php
                                                            if (@$amb_total_count) {
                                                                echo $amb_total_count;
                                                            } else {
                                                                echo "0";
                                                            }
                                                            ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
    table.report_table,
    table.report_table td {
        border: none;
        padding: 5px;
    }

    .tblclr th {
        background-color: #39CDAB !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 13px;
        text-align: center;
        padding: 10px 5px;
    }

    .tblclr td {
        color: black !important;
        font-size: 13px;
        border: 1px solid #dee2e6 !important;

    }

    .header_top_link ul .headli1 {
        background: #BCA1F2 !important;
    }

    .header_top_link ul .headli2 {
        background: #8786FB !important;
    }

    .header_top_link ul .headli3 {
        background: #9EBEF1 !important;
    }
    .header_top_link ul .headli4 {
        background: #a5edac !important;
    }

    li.active_supervisor_nav a {
        color: whitesmoke !important;
        font-weight: bold;
    }

    .mainbtn2 {
        background-color: #2F419B !important;
        border-radius: 10px !important;
        border-color: #2F419B !important;
        color: #2F419B !important;
        border: 1px solid #2F419B !important;
        padding: 5px 20px !important;
        font-size: 13px !important;
        margin-top: 0px !important;
        margin-bottom: 0px !important;

    }

    .scrollit {
        overflow: scroll;
        height: 500px;
        ;
    }
</style>