<?php $CI = EMS_Controller::get_instance(); ?>

<div class="width64 float_left ">

    <!-- <?= $CI->modules->get_tool_html('MT-ADD-INS', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1800  data-popupheight=1800"); ?> -->
    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}Inspection/ins_listing" data-qr="output_position=content&amp;filters=reset" type="button">

</div>

<br>
<br>
<div class="row"> </div>
<div class="box3">

    <div class="permission_list group_list">

        <form method="post" name="amb_form" id="amb_list">

            <div id="amb_filters"></div>

            <div id="list_table">


                <table class="table report_table table-responsive">

                    <tr>
                        <th nowrap>Date</th>
                        <th nowrap>Ambulace No</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>District</th>
                        <th>On/Off Road</th>
                        <th>GPS Status</th>
                        <th>Pilot</th>
                        <th>EMT</th>
                        <th>Action</th>
                    </tr>
                    <?php

                    if ($result > 0) {
                        foreach ($result as $key => $value) {
                    ?>
                            <tr>
                                <td><?php echo $value->added_date; ?></td>
                                <td><?php echo $value->ins_amb_no; ?></td>
                                <td><?php echo $value->ins_baselocation; ?></td>
                                <td><?php echo $value->dst_name; ?></td>
                                <?php
                                if ($value->ins_amb_current_status == 'amb_onroad') {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="ON-Road" /></a> </td>
                                <?php
                                } else {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="OFF-Road" /></a> </td>
                                <?php
                                }
                                ?>
                                <?php
                                if ($value->ins_gps_status == 'Yes') {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="Yes" /></a> </td>
                                <?php
                                } else {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="No" /></a> </td>
                                <?php
                                }
                                ?>
                                <?php
                                if ($value->ins_pilot == 'present') {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="Present" /></a> </td>
                                <?php
                                } else {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="Absent" /></a> </td>
                                <?php
                                }
                                ?>
                                <?php
                                if ($value->ins_emso == 'present') {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="Present" /></a> </td>
                                <?php
                                } else {
                                ?>
                                    <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="Absent" /></a> </td>
                                <?php
                                }
                                ?>
                                <td>

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                          
                                               <a class="onpage_popup action_button" data-href="{base_url}inspection/add_grievance" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;gri_action=add&amp;amb_no=<?php echo $value->ins_amb_no; ?>" data-popupwidth="500" data-popupheight="300">Add</a>


                                                <a class="onpage_popup action_button" data-href="{base_url}inspection/view_grievance" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;gri_action=view&amp;amb_no=<?php echo $value->ins_amb_no; ?>" data-popupwidth="500" data-popupheight="300">View</a>
                                                
                                        </ul>
                                    </div>
                                </td>
                                <!-- <td>

                                    <a href="{base_url}inspection/view_grievance" title="show">
                                        <i class="fa fa-eye text-green fa-sm"></i>
                                    </a
                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>
                                        <a class="onpage_popup action_button click-xhttp-request" data-href="{base_url}inspection/view_grievance" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;gri_action=view&amp;amb_no=<?php echo $value->ins_amb_no; ?>" data-popupwidth="500" data-popupheight="300">View</a>
                                        <a class="onpage_popup action_button click-xhttp-request" data-href="{base_url}inspection/add_grievance" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;gri_action=add&amp;amb_no=<?php echo $value->ins_amb_no; ?>" data-popupwidth="500" data-popupheight="300">Add</a></li>


                                    </div> 
                                </td> -->
                            </tr>
                        <?php }
                    } else { ?>

                        <tr>
                            <td colspan="9" class="no_record_text">No history Found</td>
                        </tr>

                    <?php } //} 
                    ?>

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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}inspection/gri_listing" data-qr="output_position=content&amp;flt=true">

                                    <?php echo rec_perpg_sup($pg_rec); ?>

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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<style>
    #ui-id-2 {
        height: 150% !important;
    }
</style>