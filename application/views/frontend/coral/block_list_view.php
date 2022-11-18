<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li>
            <span>Block Number Listing</span>
        </li>

    </ul>
</div>

<div class="width64 float_left ">

    <?= $CI->modules->get_tool_html('MT-ADD-CORAL-BLOCKED', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=500"); ?>

<!--    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}amb/amb_listing" data-qr="output_position=content&amp;filters=reset" type="button">-->

</div>

<br>

<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" name="amb_form" id="amb_list">  

            <div id="amb_filters"></div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                                      

                        <th nowrap>Mobile Number</th>
                        <th>Status</th> 
                        <th>Action</th> 

                    </tr>

                    <?php
                    if (count($result) > 0) {

                        $total = 0;
                        $cur_page_sr = ($cur_page - 1) * 20;
                        foreach ($result as $key => $value) {
                            ?>
                            <tr>




                                <td><?php echo $value->block_number; ?></td>
                                <td>Blocked</td>
                                  
                                <td style="width: 50px;"> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

                <?php if ($CI->modules->get_tool_config('MT-CORAL-UNBLOCKED', $this->active_module, true) != '') { ?>
                    <li><a class="click-xhttp-request action_button" data-href="{base_url}coral/un_blocked_number" data-qr="output_position=popup_div&amp;id=<?php echo base64_encode($value->id); ?>&amp;mobile_number=<?php echo $value->block_number; ?>">Unblock</a></li>
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

<?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                            <div class="float_right">
                                <span> Total records: <?php echo (@$total_count) ? $total_count : "0"; ?> </span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>
</div>