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

        <li><span>Equipment Audit</span></li>
    </ul> 
</div>

<div class="width2 float_right">


    <?php if ($send_request != '') { ?>
        <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add Equipment Audit" data-href="{base_url}biomedical/add_equipment_audit" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=fleet" type="button" data-popupwidth="800" data-popupheight="700">
    <?php } ?>

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}biomedical/equipment_audit" data-qr="output_position=content&amp;filters=reset" type="button">

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
                                    <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" >
                                </div>-->

<div id="date_filter"></div>
                                <div class="filed_input float_left width_25">
                                    <label for="search_clg">

                                        <input type="button" name="search_btn1" value="Search" class="btn clg_search form-xhttp-request" data-href="{base_url}biomedical/equipment_audit" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >

                                    </label>

                                </div>

                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <div id="list_table">


                <table class="table">

                    <tr>                

                        <th nowrap>Sr. no</th>
                        <th nowrap>District</th>
                        
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Audit Date</th>
<!--                        <th nowrap>Date / Time</th>
                        <th nowrap>Status</th> -->
                        <th nowrap>Action</th> 

                    </tr>

                    <?php
                    if($equipment_data) {


                        $count = 1;

                        //$total = count($equipment_data);
                        $cur_page_sr = ($cur_page - 1) * $per_page;
                         //var_dump($cur_page);
                         // var_dump($per_page);

                        foreach ($equipment_data as $key=>$equipment_data) {
                           // var_dump($equipment_data);
                           
                            ?>
                            <tr>

                                 <td><?php echo $cur_page_sr + $key + 1; ?></td>
                                <td><?php if($equipment_data->district_id != '' && $equipment_data->district_id != 0){ echo get_district_by_id($equipment_data->district_id); } ?></td> 
                                <td><?php echo $equipment_data->ambulance_no; ?></td>
                                <td><?php echo $equipment_data->base_location; ?> </td>  
                                <td><?php echo $equipment_data->current_audit_date; ?> </td>
<!--                                <td><?php echo $equipment_data->req_date; ?> </td>  
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
                                </td>-->

                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                            <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/view_eqp_audit_details" data-qr="output_position=popup_div&amp;req_id=<?php echo  base64_encode($equipment_data->id); ?>&amp;action=view" data-popupwidth="800" data-popupheight="700">View</a></li>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}biomedical/equipment" data-qr="output_position=content&amp;flt=true">

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