<?php
$CI = EMS_Controller::get_instance();
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>

        <li><span>Manpower Issue</span></li>
    </ul>
</div>

<div class="width2 float_right">
    
     <?php if ($CI->modules->get_tool_config('MT-ADD-MAN-POW', 'M-AMB-MAINT', $this->active_module, true) != '') { ?>   
    <input class="add_button_amb click-xhttp-request float_right" name="add_amb" value="Add More" data-href="{base_url}ambulance_maintaince/man_power_add" data-qr="output_position=popup_div&amp;module_name=amb_maintaince" type="button" data-popupwidth="800" data-popupheight="700"> 
     <?php } ?>

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}ambulance_maintaince/man_power" data-qr="output_position=content&amp;filters=reset" type="button">

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
                                    <select name="search_status" tabindex="8"> 
                                        <option value="">Select Status</option>
                                        <option value="Approved" <?php if($search_status == 'Approved'){ echo "selected";}?>>Approved</option>
                                        <option value="Pending Approval" <?php if($search_status == 'Pending Approval'){ echo "selected";}?>>Pending Approval</option>
                                        <option value="Available" <?php if($search_status == 'Available'){ echo "selected";}?>>Closed</option> 
                                        <option value="Approval Rejected" <?php if($search_status == 'Approval Rejected'){ echo "selected";}?>>Approval Rejected</option>
                                         <option value="Under Process" <?php if($search_status == 'Under Process'){ echo "selected";}?>>Under Process</option>
                                         
                                    </select>
                                </div>
                                <div class="filed_input float_left width_20">
                                    <!--<input name="search1" type="text" class=" mi_calender " placeholder=" Search Date" ></div>-->
                                    <input name="from_date" tabindex="1" class="form_input width50" placeholder="From Date" type="text" data-base="search_btn" data-errors="{filter_required:'From Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $from_date;?>" readonly="readonly" id="from_date">
                                </div>
                                <div class="filed_input float_left width_20">
                                    <input name="to_date" tabindex="2" class="form_input width50" placeholder="To Date" type="text" data-base="search_btn" data-errors="{filter_required:'To Date should not be blank!',filter_time_hm:'Please enter valid time(H:i)'}" value="<?php echo $to_date;?>" readonly="readonly" id="to_date">
                                </div>
                                <div class="filed_input float_left width_20">                                    
                                    <input type="button" name="search_btn" value="Search" class="btn clg_search form-xhttp-request float_left pt-0" data-href="{base_url}ambulance_maintaince/man_power" data-qr="output_position=content&amp;filter_search=search&amp;module_name=clg&amp;tlcode=MT-CLG-ACTION-MULTI&amp;action_name=search_clgs" style="float:left !important;" >
                                   
                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>      
                        <!-- <th nowrap>Id</th> -->
                        <th nowrap>Sr.No</th>
                        <th nowrap>Request Id</th>
                        <th nowrap>District</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Ambulance Number</th>
                        <th nowrap>Request Status</th>
                        <th nowrap>Expected Onroad Date</th> 
                        <th nowrap>Offroad Date</th> 
                        <th nowrap>Added Date</th> 
                        <th nowrap>Approve Date</th> 
                        <th nowrap>Added by</th> 
                        <th nowrap>Action</th> 
                    </tr>

                    <?php
                    if (count($maintance_data) > 0) {
                        $count = 1;
                        $total = $total_count;
                        foreach ($maintance_data as $stat_data) { ?>
                       
                            <tr>
                            <td><?php echo $count; ?></td> 
                                <!-- <td><?php echo $stat_data->mt_id; ?></td>  -->
                                <td><?php echo $stat_data->mt_manpower_id; ?></td> 
                                <td><?php echo $stat_data->dst_name; ?></td> 
                                <td><?php echo $stat_data->hp_name; ?></td>
                                <td><?php echo $stat_data->mt_amb_no; ?></td>     
<!--                                <td><?php echo show_amb_status_name($stat_data->amb_status); ?></td>-->
                                <td><?php echo $stat_data->mt_ambulance_status; ?> </td>  
                                <td><?php echo $stat_data->mt_ontime_onroad_date; ?> </td>  
                                <td><?php echo $stat_data->mt_offroad_date; ?> </td>  
                                <td><?php echo $stat_data->added_date; ?> </td>  
                                <td><?php if($stat_data->approved_date != '' && $stat_data->approved_date != '1970-01-01 05:30:00' && $stat_data->approved_date != '0000-00-00 00:00:00'){ echo $stat_data->approved_date; } ?> </td>    
                                <td><?php echo $stat_data->added_by; ?> </td>

                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php if ($CI->modules->get_tool_config('MT-VIEW-MAN-POW', 'M-AMB-MAINT', $this->active_module, true) != '') { ?>   
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}ambulance_maintaince/manpower_view"  data-qr="output_position=popup_div&amp;tlcode=MT-PREV-MANT-VIEW&amp;module_name=amb_maintaince&amp;mt_id=<?php echo $stat_data->mt_id; ?>&amp;action_type=View" data-popupwidth="1000" data-popupheight="350">View</a></li>

                                                <?php
                                            }
                                            if ($CI->modules->get_tool_config('MT-UPDATE-MAN-POW', 'M-AMB-MAINT', $this->active_module, true) != '' && $stat_data->mt_isupdated == 0 &&  $stat_data->mt_approval == 1 ) {
                                                //if ($stat_data->mt_isupdated == 0 &&  $stat_data->mt_approval == 1 ) {
                                                ?>   


                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}ambulance_maintaince/man_power_add" data-qr="output_position=content&amp;module_name=amb_maintaince&amp;tlcode=MT-PREV-MANT-UPDATE&amp;mt_id=<?php echo $stat_data->mt_id; ?>&action_type=Update" data-popupwidth="1000" data-popupheight="450">Closure</a></li>          

                                             <?php }
                                             if ($CI->modules->get_tool_config('MT-APPROV-MAN-POW', 'M-AMB-MAINT', $this->active_module, true) != '' &&  $stat_data->mt_approval == 0) {
                                             //if ( $stat_data->mt_approval == 0) {
                                             ?>
                                             <li><a class="click-xhttp-request action_button" data-href="{base_url}ambulance_maintaince/man_power_add"  data-qr="output_position=content&amp;tlcode=MT-PREV-MANT-APP&amp;module_name=amb_maintaince&amp;mt_id=<?php echo $stat_data->mt_id; ?>&amp;action_type=Approve" data-popupwidth="1000" data-popupheight="350">Approve</a></li>
 
                                             <?php
                                             }
                                             ?>
                                            
                                         


                                        </ul> 
                                    </div>
                                </td>
                            </tr>
                        <?php
                        $count++;
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}ambulance_maintaince/preventive_maintaince" data-qr="output_position=content&amp;flt=true&search=<?php echo $search; ?>&search_status=<?php echo $search_status;?>&to_date=<?php echo $to_date ;?>&from_date=<?php echo $from_date;?>">

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
<style>
    input[name="search_btn"]{
        margin-top: 0px !important;
    }
    .mi_loader{
        display: none !important;
    }
</style>