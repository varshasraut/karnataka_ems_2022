<?php
$CI = EMS_Controller::get_instance();


$dispatch = $CI->modules->get_tool_config('MT-BIO-EQUP-DiS', 'M-BIOMEDICAL', true);


$receive = $CI->modules->get_tool_config('MT-BIO-EQUP-REV', 'M-BIOMEDICAL', true);

$send_request = $CI->modules->get_tool_config('MT-BIO-EQUP-ADD', 'M-BIOMEDICAL', true);

$approve = $CI->modules->get_tool_config('MT-BIO-EQUP-APP', 'M-BIOMEDICAL', true);
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Equipment Request Approve</span></li>
    </ul>
</div>

<div class="width2 float_right">


   

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}biomedical/equipment_approve" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">

                            <div class="group_action_field_btns">




                            </div>

                            <div class="field_row width100">
                                <div class="filed_input float_left width_25">

                                    <input type="text"  placeholder="Search Name" value="<?php echo @$search; ?>" name="search">
                                </div> 
<!--                                <div class="filed_input float_left width33">

                                    <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                    
                                    <div id="date_filter"></div>
                                <div class="filed_input float_left width_25">
                                    <label for="search_clg">

                                        <input type="button" name="search_btn1" value="Search" class="btn clg_search form-xhttp-request" data-href="{base_url}biomedical/equipment_approve" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >

                                    </label>

                                </div>

                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                

                        <th nowrap>Id</th>
                        <th nowrap>District</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Date / Time</th>
                        <!--<th nowrap>Available Qty In Ambulance</th>--> 
                        <th nowrap>Status</th> 
                        <th nowrap>Action</th> 

                    </tr>

                    <?php
                    if($equipment_data) {


                        $count = 1;

                        $total = count($equipment_data);

                        foreach ($equipment_data as $equipment_data) {
                           
                            ?>
                            <tr>

                                <td><?php echo $count++; ?></td>
                                <td><?php echo $equipment_data->dst_name; ?></td> 
                                <td><?php echo $equipment_data->req_amb_reg_no; ?></td>
                                <td><?php echo $equipment_data->hp_name; ?> </td>  
                                <td><?php echo $equipment_data->req_date; ?> </td>  
<!--                                <td><?php
                                    if ($equipment_data->in_stk > $equipment_data->out_stk) {

                                        echo $equipment_data->in_stk - $equipment_data->out_stk;
                                    } else {
                                        echo 0;
                                    }
                                    ?> </td>  -->
                                <td><?php
                            $status = "Pending";
                            if ($equipment_data->req_dis_by != '') {
                                $status = "Dispatched";
                            }
                            if ($equipment_data->req_rec_by != '') {
                                $status = "Received";
                            }
                            echo $status;
                                    ?>
                                </td>

                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                            <li><a class="onpage_popup action_button" data-href="{base_url}biomedical/view_eqp_details" data-qr="output_position=popup_div&amp;ind_emt_id=<?php echo base64_encode($equipment_data->req_emt_id); ?>&amp;req_id=<?php echo  base64_encode($equipment_data->req_id); ?>&amp;action=view&amp;req_type=<?php echo $equipment_data->req_type; ?>&amp;amb_no=<?php echo base64_encode($equipment_data->req_amb_reg_no); ?>" data-popupwidth="800" data-popupheight="700">View</a></li>

                                            <?php
                                            if ($dispatch != '' && $equipment_data->req_dis_by == '' && $equipment_data->req_is_approve == 1) {
                                                ?>
                                                <li><a class="onpage_popup action_button" data-href="{base_url}biomedical/view_eqp_details" data-qr="output_position=popup_div&amp;req_id=<?php echo  base64_encode($equipment_data->req_id); ?>&amp;req_type=<?php echo $equipment_data->req_type; ?>&amp;amb_no=<?php echo base64_encode($equipment_data->req_amb_reg_no); ?>&amp;action=dis" data-popupwidth="800" data-popupheight="700">Dispatch</a></li>

                                            <?php } ?>

                                            <?php
                                            if ($receive != '' && $equipment_data->req_dis_by != '' && $equipment_data->req_rec_by == '' && $equipment_data->req_is_approve == 1) {
                                                ?>


                                                <li><a class="onpage_popup action_button" data-href="{base_url}biomedical/view_eqp_details" data-qr="output_position=popup_div&amp;req_id=<?php echo  base64_encode($equipment_data->req_id); ?>&amp;amb_no=<?php echo base64_encode($equipment_data->req_amb_reg_no); ?>&amp;action=rec&amp;req_type=<?php echo $equipment_data->req_type; ?>" data-popupwidth="800" data-popupheight="700">Receive</a></li>

                                            <?php } ?>
                                            <?php
                                            if ($approve != '' && $equipment_data->req_is_approve == '0') {
                                                ?>
   <li><a class="onpage_popup action_button" data-href="{base_url}biomedical/view_eqp_details" data-qr="output_position=popup_div&amp;req_id=<?php echo  base64_encode($equipment_data->req_id); ?>&amp;amb_no=<?php echo base64_encode($equipment_data->req_amb_reg_no); ?>&amp;action=apr&amp;req_type=<?php echo $equipment_data->req_type; ?>" data-popupwidth="800" data-popupheight="700">Approve</a></li>

<!--                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/view_eqp_details" data-qr="req_id=<?php echo $equipment_data->req_id; ?>&ampreq_type=<?php echo $equipment_data->req_type; ?>" >Approve</a></li>-->

                                            <?php } ?>
                                        </ul> 
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

                    <?php } ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php
                    if (@$data) {
                        echo $data;
                    }
                    ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}biomedical/equipment_approve" data-qr="output_position=content&amp;flt=true">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php
                                    if (@$total_count) {
                                        echo $total_count;
                                    } else {
                                        echo"0";
                                    }
                                    ?> </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>