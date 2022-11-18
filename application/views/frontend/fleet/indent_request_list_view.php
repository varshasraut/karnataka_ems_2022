<?php
$CI = EMS_Controller::get_instance();


$dispatch = $CI->modules->get_tool_config('MT-DIS-IND-REQ', 'M-FLTMNT', true);


$receive = $CI->modules->get_tool_config('MT-REC-IND-REQ', 'M-FLTMNT', true);

$send_request = $CI->modules->get_tool_config('MT-SND-IND-REQ', 'M-FLTMNT', true);
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Indent Request</span></li>
    </ul>
</div>

<div class="width2 float_right">


    <?php //if ($send_request != '') { ?>
        <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add Indent Request" data-href="{base_url}fleet/indent_request_registrartion" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=fleet" type="button" data-popupwidth="1300" data-popupheight="700">
    <?php //} ?>

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}fleet/indent_request" data-qr="output_position=content&amp;indr_filters=reset" type="button">

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

                                    <input type="text"  placeholder="Search Name" value="<?php echo @$search; ?>" name="search"></div> 
<!--                                <div class="filed_input float_left width33">

                                    <input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" >
                                </div>-->
                                    
                                     <div id="date_filter"></div>
                                <div class="filed_input float_left width_25">
                                    <label for="search_clg">

                                        <input type="button" name="search_btn1" value="Search" class="btn clg_search form-xhttp-request mt-0" data-href="{base_url}fleet/indent_request" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" >

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

                        <th nowrap>Sr No</th>
                        <th nowrap>District</th>
                       
                        <th nowrap>Ambulance No</th>
                         <th nowrap>Base Location</th>
                        <th nowrap>Date / Time</th>
                        <!--<th nowrap>Available Qty In Ambulance</th>--> 
                        <th nowrap>Status</th>
                        <th nowrap>Action</th> 

                    </tr>

<?php
if (count($indent_data) > 0) {
   

    $count = 1;

    $total = count($indent_data);

    foreach ($indent_data as $indent_data) {
        ?>
                            <tr>

                                <td><?php echo $count++; ?></td>
                                <td><?php echo $indent_data->dst_name; ?></td> 
                                <td><?php echo $indent_data->req_amb_reg_no; ?></td>
                                <td><?php echo $indent_data->hp_name; ?> </td>  
                                <td><?php echo $indent_data->req_date; ?> </td>  

<!--                                <td><?php
                                    if ($indent_data->in_stk > $indent_data->out_stk) {

                                        echo $indent_data->in_stk - $indent_data->out_stk;
                                    } else {
                                        echo 0;
                                    }
                                    ?> </td>  -->
                                
                                   <td><?php
                                    $status = "Pending";
                                   // var_dump($indent_data);
                                    if( $indent_data->req_is_approve == 0){
                                         $status = "Approval Pending";
                                    }else if($indent_data->req_dis_by == '' && $indent_data->req_rec_by == '' && $indent_data->req_is_approve == 1){
                                        $status = "Dispatch Pending";
                                    }else if($indent_data->req_dis_by != '' && $indent_data->req_rec_by == '' && $indent_data->req_is_approve == 1){
                                        $status = "Receive Pending";
                                    }else{
                                        $status = "Received";
                                    }
                                    echo $status;
                                    ?>
                                </td>
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">


        <?php // if ($view != '') { ?>

                                                <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;ind_emt_id=<?php echo base64_encode($indent_data->req_emt_id); ?>&amp;req_id=<?php echo base64_encode($indent_data->req_id); ?>&amp;action=view&amp;req_type=<?php echo $indent_data->req_type; ?>&amp;amb_no=<?php echo base64_encode($indent_data->req_amb_reg_no); ?>" data-popupwidth="1300" data-popupheight="700">View</a></li>
                                                <?php  if($indent_data->req_is_approve == 0){ ?>
                                                <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;ind_emt_id=<?php echo base64_encode($indent_data->req_emt_id); ?>&amp;req_id==<?php echo base64_encode($indent_data->req_id); ?>&amp;action=Update&amp;req_type=<?php echo $indent_data->req_type; ?>&amp;amb_no=<?php echo base64_encode($indent_data->req_amb_reg_no); ?>" data-popupwidth="1300" data-popupheight="700">Edit</a></li>

                                            <?php  } ?>

        <!-- <?php  if ($dispatch != '' && $indent_data->req_dis_by == '' && (@$clg_group != 'UG-EMT') && $indent_data->req_is_approve == 1){ ?>
                                                <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;req_id=<?php echo base64_encode($indent_data->req_id); ?>&amp;req_type=<?php echo $indent_data->req_type; ?>&amp;amb_no=<?php echo base64_encode($indent_data->req_amb_reg_no); ?>&amp;action=dis" data-popupwidth="1300" data-popupheight="700">Dispatch</a></li>

                                            <?php } ?> -->

                                            <?php
                                         // var_dump($receive);
                                            if ($receive != '' && $indent_data->req_dis_by != '' && $indent_data->req_rec_by == '' && $indent_data->req_is_approve == 1) {
                                                ?>


                                                <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;req_id=<?php echo  base64_encode($indent_data->req_id); ?>&amp;amb_no=<?php echo base64_encode($indent_data->req_amb_reg_no); ?>&amp;action=rec&amp;req_type=<?php echo $indent_data->req_type; ?>" data-popupwidth="1300" data-popupheight="700">Receive</a></li>

                                            <?php } ?>
        <?php
        if (($clg_group == $group_info[0]->gcode ) && $indent_data->req_is_approve == '0') {
            ?>


<!--                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}fleet/approve_ind" data-qr="req_id=<?php echo $indent_data->req_id; ?>&ampreq_type=<?php echo $indent_data->req_type; ?>" >Approve</a></li>-->

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}fleet/indent_request" data-qr="output_position=content&amp;flt=true">

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


<iframe name="form_frame" style="height: 1px; width: 1px; border:0px; background: none;"></iframe>
<script>;
    jQuery(document).ready(function () {

        var dateFormat = "mm/dd/yy",
                from = jQuery("#from_date")
                .datepicker({
                    defaultDate:  new Date(),
                    changeMonth: true,
                    numberOfMonths: 2
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
                to = jQuery("#to_date").datepicker({
            defaultDate:  new Date(),
            changeMonth: true,
            numberOfMonths: 2
        })
                .on("change", function () {
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