<?php
$CI = EMS_Controller::get_instance();

$clg_status = array('0' => 'Inactive', '1' => 'Active', '2' => 'Deleted');
$sts = array('0' => 'Active', '1' => 'Inactive');
?>

<div class="msg"><?php echo $res; ?></div>
<div class="breadcrumb float_left">
    <ul>
        <li class="colleague"><a href="#">Battery Life Module</a></li>
        <li><span>Battery Life List</span></li>
    </ul>
</div>

<div class="width2 float_right">
    <input class="add_button_amb onpage_popup float_right" name="add_amb" value="Add 
Battery Life" data-href="{base_url}battery/add_battery_life" data-qr="output_position=popup_div&amp;tool_code=mt_clg_add&amp;module_name=clg" type="button" data-popupwidth="1300" data-popupheight="600"> 

    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}battery/battery_listing" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" action="#" name="colleagues_list_form" class="colleagues_list_form">  

            <div id="clg_filters"> </div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                                             
                        <th nowrap>District</th>
                        <th nowrap>Ambulance Number</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>Approved By</th>
                        <th nowrap>Added By</th>
                        <th nowrap>Offorad Date and Time</th>
                        <th>Action</th> 

                    </tr>

                    <?php
                    if (count($inc_info) > 0) {

                        foreach ($inc_info as $colleague) {
                            ?>
                            <tr>


                                <td><?php echo strtoupper($colleague->dst_name); ?></td>
                                <td><?php echo $colleague->amb_ref_no; ?></td>
                                <td><?php echo $colleague->hp_name; ?></td>        
                                <td><?php echo $colleague->approved_by_name; ?></td>   
                                <td><?php echo $colleague->added_by; ?></td>     
                                 <td><?php echo $colleague->offroad_datetime; ?> </td>     
                                </td>       

                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                                            <?php if ($CI->modules->get_tool_config('MT-VIEW-BATTERY', 'M-BATTERY', $this->active_module, true) != '') { ?>   
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}battery/edit_clg" data-qr="output_position=popup_div&amp;module_name=clg&amp;tlcode=MT-CLG-VIEW&amp;bt_id=<?php echo base64_encode($colleague->clg_ref_id); ?>&amp;action_type=View">View</a></li>

                                            <?php }
                                            if ($CI->modules->get_tool_config('MT-APPROVE-BATTERY', 'M-BATTERY', $this->active_module, true) != '' && $colleague->mt_approval == '0') {
                                                ?>   


                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}battery/approve_battery_life" data-qr="output_position=popup_div&amp;module_name=battery&amp;tlcode=MT-APPROVE-BATTERY&amp;bt_id=<?php echo base64_encode($colleague->bt_id); ?>&amp;action_type=Approve" name="<?php echo $colleague->clg_ref_id; ?>" >Approve</a></li>



                                            <?php  } 
                                            if ($CI->modules->get_tool_config('MT-UPDATE-BATTERY', 'M-BATTERY', $this->active_module, true) != '' && $colleague->mt_approval == '1') {
                                                ?>   


                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}battery/add_battery_life" data-qr="output_position=popup_div&amp;module_name=battery&amp;tlcode=MT-UPDATE-BATTERY&amp;bt_id=<?php echo base64_encode($colleague->bt_id); ?>&amp;action_type=Update" name="<?php echo $colleague->clg_ref_id; ?>" >Update</a></li>



                                            <?php  }  
                                            //if ($CI->modules->get_tool_config('MT-UPDATE-REPLACE-BATTERY', 'M-BATTERY', $this->active_module, true) != '' && $colleague->mt_approval == '1') {
                                                ?>   


                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}battery/add_battery_life" data-qr="output_position=popup_div&amp;module_name=battery&amp;tlcode=MT-UPDATE-BATTERY&amp;bt_id=<?php echo base64_encode($colleague->bt_id); ?>&amp;action_type=Update_replace" name="<?php echo $colleague->clg_ref_id; ?>" >Update After Replacement</a></li>



                                            <?php // } ?>


                                        </ul> 
                                    </div>
                                </td>
                            </tr>
    <?php }
} else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

<?php } ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if (@$data) {
    echo $data;
} ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}battery/battery_listing" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php if (@$total_count) {
    echo $total_count;
} else {
    echo"0";
} ?> </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>