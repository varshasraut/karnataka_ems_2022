<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li class="sms">
            <a class="click-xhttp-request" data-href="{base_url}cq/cq_listing">CQ</a>
        </li>
        <li>
            <span><?php if ($verify_status == "unapprove") { ?>Unapproved<?php } ?>CQ Listing</span>
        </li>

    </ul>
</div>

<div class="width64 float_left ">

    <?= $CI->modules->get_tool_html('MT-ADD-CQ', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=500"); ?>
    
<!--<input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}cq/cq_listing" data-qr="output_position=content&amp;filters=reset" type="button">
-->
</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" name="amb_form" id="amb_list">  

            <div id="amb_filters"></div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                        <!--<th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th> -->                      
                        <th nowrap>Sr No</th>
                        <th nowrap>Ambulance Number</th>
                        <th nowrap>Message</th>
                        <th nowrap>Added Date</th>
                        <th>Action</th> 

                    </tr>
    
                    <?php
                    if (count($result) > 0) {
                        $count=1;
                        //$total = 0;
                        //$cur_page_sr = ($cur_page - 1) * 20;
                        foreach ($result as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $value->cq_vehicle; ?></td>
                                <td><?php echo $value->cq_msg ; ?></td>
                                <td><?php echo $value->cq_added_date; ?></td>
                                <td> 
                                    <div class="user_action_box">
                                        <div class="colleagues_profile_actions_div"></div>
                                        <ul class="profile_actions_list">
                                            <?php if ($CI->modules->get_tool_config('MT-VIEW-CQ', $this->active_module, true) != '') { ?>
                                                <li><a class="onpage_popup action_button" data-href="{base_url}cq/view_detail" data-qr="output_position=popup_div&amp;cq_id[0]=<?php echo base64_encode($value->cq_id); ?>&amp;action=view&amp;amb_dst='' " data-popupwidth="1000" data-popupheight="800">View Cq Details</a></li>
                                            <?php } ?>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}amb/amb_listing" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg_sup($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php echo (@$total_count) ? $total_count : "0"; ?> </span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>-->
        </form>
    </div>
</div>