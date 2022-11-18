<?php
$CI = EMS_Controller::get_instance();
$send_request = $CI->modules->get_tool_config('M-BRE-BIO-EQUP-ADD', 'M-EQU-MAIN', true);
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Breakdown Equipment Maintenance</span></li>
    </ul>
</div>

<div class="width2 float_right">


    <?php if ($send_request != '') { ?>
        <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add Breakdown Equipment" data-href="{base_url}biomedical/add_break_equipment" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=biomedicle" type="button" data-popupwidth="800" data-popupheight="700">
    <?php } ?>

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}biomedical/equipment_breakdown" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters">

                <div class="filters_groups">                   

                    <div class="search">
                        <div class="row list_actions clg_filt">
                            <div class="search_btn_width">

                                <div class="filed_input float_left width_20">
                                    <input class="form_input width100" type="text" id="search_clg" placeholder="Search Name" value="<?php echo @$search; ?>" name="search" style="width: 95%  !important;">
                                </div>
                                <div class="filed_input float_left width_20">
                                    <select name="search_status" tabindex="8" class="" data-errors="{filter_required:'Status should not be blank!'}"> 
                                        <option value="">Select Status</option>
                                        <option value="1">Available</option>
                                        <option value="6">On-road</option>
                                        <option value="7">Off-road</option>
                                    </select>
                                </div>
                                <div class="filed_input float_left width_20">
                                    <!--<input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                    <input name="from_date" tabindex="1" class="form_input  width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="from_date">
                                </div>
                                <div class="filed_input float_left width_20">
                                    <input name="to_date" tabindex="2" class="form_input  width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="" readonly="readonly" id="to_date">
                                </div>
                                <div class="filed_input float_left width_20">  

                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left" data-href="{base_url}biomedical/equipment_breakdown" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >

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
                        <th nowrap>Ambulance No</th>
                        <th nowrap>Base Location</th>
                      
                        <th nowrap>Ambulance Status</th>
                        <th nowrap>Added Date  Time</th>
                        <!--<th nowrap> SLA Duration</th> -->
                        <th nowrap>Action</th> 

                    </tr>

                    <?php
                    if($equipment_data) {


                        $count = 1;

                        $total = count($equipment_data);

                        foreach ($equipment_data as $equipment_data) {
                            ?>
                            <tr>

                                <td><?php echo $equipment_data->mt_ref_id;; ?></td>
                                <td><?php if($equipment_data->mt_district_id == 'Backup'){ echo "Backup"; }else{ echo $equipment_data->dst_name;} ?></td> 
                                <td><?php echo $equipment_data->mt_amb_no; ?></td>
                               
                                <td><?php echo $equipment_data->hp_name; ?> </td>  
                                 <td><?php echo $equipment_data->mt_ambulance_status; ?> </td>  
                                <td><?php echo $equipment_data->added_date; ?> </td>  
                                <!-- <td>--><?php
                                /*
                                if( $equipment_data->is_amb_offroad == 'yes'){
                    $start_date = new DateTime(date('Y-m-d h:i:s', strtotime($equipment_data->mt_offroad_datetime)));
                 
                    if ($equipment_data->mt_onroad_datetime != '' && $equipment_data->mt_onroad_datetime != '1970-01-01 05:30:00' && $equipment_data->mt_onroad_datetime != '0000-00-00 00:00:00') {
   
                        $end_date = new DateTime(date('Y-m-d h:i:s', strtotime($equipment_data->mt_onroad_datetime)));
                    } else {
                        $end_date = new DateTime(date('Y-m-d h:i:s'));
                    }
                    
                   // var_dump($equipment_data->mt_onroad_datetime);
                    $since_start = $start_date->diff($end_date);
                    
                    echo $since_start->days . ' days ' . $since_start->h . ' Hours ' . $since_start->i . ' Minutes ' . $since_start->s . ' Seconds';
                                }
                    //var_dump($equipment_data->is_amb_offroad);
                        */    ?> <!--</td> -->


                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                            <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/breakdown_equip_view"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-VIEW&amp;module_name=amb_maintaince&amp;mt_id=<?php echo base64_encode($equipment_data->mt_id); ?>&amp;action_type=View" data-popupwidth="1000" data-popupheight="350">View</a></li>
                                            
                                                 <?php if ($CI->modules->get_tool_config('MT-BIO-APP-EQUP-BREK', 'M-EQU-MAIN', $this->active_module, true) != '' && $equipment_data->mt_isupdated == 0 &&  $equipment_data->mt_approval== 1) { ?>   
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/add_break_equipment" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-PREV-MANT-UPDATE&amp;mt_id=<?php echo base64_encode($equipment_data->mt_id); ?>&amp;action_type=Update&amp;amb_rto_register_no=<?php echo base64_encode($equipment_data->mt_amb_no); ?>" data-popupwidth="1000" data-popupheight="450">Complaint Resolution</a></li>          
                                                 <?php 
                                                 }
                                                 if ($CI->modules->get_tool_config('MT-BIO-APP-EQUP-BREK', 'M-EQU-MAIN', $this->active_module, true) != '' && $equipment_data->mt_isupdated == 0 &&  $equipment_data->mt_approval != 1 &&  $equipment_data->is_amb_offroad == 'yes') { 
                                                // if ($equipment_data->mt_isupdated == 0 &&  $equipment_data->mt_approval != 1) { 
                                                 ?>   
                                                 <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/equipment_breakdown_maintainance_approve" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-EQU-BREAK-MANT-APP&amp;mt_id=<?php echo base64_encode($equipment_data->mt_id); ?>&amp;action_type=Approve&amp;amb_rto_register_no=<?php echo base64_encode($equipment_data->mt_amb_no); ?>" data-popupwidth="1000" data-popupheight="450">Approval</a></li>          
                                                 <?php }
                                                 if ($CI->modules->get_tool_config('MT-BIO-RE-REQ-EQUP-BREK', 'M-EQU-MAIN', $this->active_module, true) != '' && $equipment_data->mt_isupdated == 0 &&  $equipment_data->mt_approval== 0) { ?>   
                                                 <li><a class="click-xhttp-request action_button" data-href="{base_url}biomedical/equipment_breakdown_maintainance_rerequest" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-EQU-BREAK-MANT-RE&amp;mt_id=<?php echo base64_encode($equipment_data->mt_id); ?>&amp;action_type=Re_request&amp;amb_rto_register_no=<?php echo base64_encode($equipment_data->mt_amb_no); ?>" data-popupwidth="1000" data-popupheight="450">Re-Request</a></li>          
                                                
                                                 <?php } ?>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}biomedical/equipment_breakdown" data-qr="output_position=content&amp;flt=true">

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
<script>
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