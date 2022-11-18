<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li class="sms">
            <a class="click-xhttp-request" data-href="{base_url}Inspection/ins_listing">Grievance</a>
        </li>
        <li>
            <span><?php if ($verify_status == "unapprove") { ?>Unapproved<?php } ?>Grievance Listing</span>
        </li>

    </ul>
</div>

<!--<div class="width64 float_left ">

    <?= $CI->modules->get_tool_html('MT-ADD-INS', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1800  data-popupheight=1800"); ?>
    <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}Inspection/ins_listing" data-qr="output_position=content&amp;filters=reset" type="button">

</div>-->

<br>
<br>
<div class="box3">    

    <div class="permission_list group_list">

        <form method="post" name="amb_form" id="amb_list">  

            <div id="amb_filters"></div>

            <div id="list_table">


                <table class="table report_table">

                    <tr>                
                        <!--<th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        
                        <th nowrap>Sr No</th>-->
                        <th nowrap>Date</th>
                        <th nowrap>Ambulace No</th>
                        <th nowrap>Base Location</th>
                        <th nowrap>District</th>
                        <th>On/Off Road</th>
                        <th>GPS Status</th>
                        <th>Pilot</th> 
                        <th>EMT</th> 
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
    <?php //var_dump($result);die(); ?>
                    <?php
                    //if (count($result) > 0) {
                    if ($result > 0) {
                       // $total = 0;
                       // $cur_page_sr = ($cur_page - 1) * 20;
                        foreach ($result as $key => $value) {
                            ?>
                            <tr>
                               <!-- <td><input type="checkbox" data-base="selectall" class="base-select" name="amb_id[<?= $value->amb_id; ?>]" value="<?= base64_encode($value->id ); ?>" title="Select All Inspection"/></td>
                        --> 
                        <?php $get_name =$value->clg_first_name.' '.$value->clg_mid_name.' '.$value->clg_last_name;?>

                        <td><?php echo $value->added_date; ?></td>
                        <td><?php echo $value->ins_amb_no; ?></td>
                                <td><?php echo $value->ins_baselocation; ?></td>
                                <td><?php echo $value->dst_name; ?></td>
                               <!-- <td><?php echo $value->ins_amb_model; ?></td> -->
                               <?php 
                               if($value->ins_amb_current_status == 'amb_onroad'){
                                ?>
                                <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="ON-Road"/></a> </td>
                                <?php
                               }else if($value->ins_amb_current_status == 'amb_offroad'){
                                   ?>
                                  <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="OFF-Road"/></a> </td>
                                   <?php
                               }else{ ?>
                                <td><?php echo "NULL"; ?></td>

                                <?php }
                               ?> 
                               <?php 
                               if($value->ins_gps_status == 'Yes'){
                                ?>
                                <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="Yes"/></a> </td>
                                <?php
                               }else if($value->ins_gps_status == 'No'){
                                   ?>
                                  <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="No"/></a> </td>
                                   <?php
                               }else{ ?>
                                <td><?php echo "NULL"; ?></td>

                                <?php }
                               ?> 
                                <?php 
                               if($value->ins_pilot == 'present'){
                                ?>
                                <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="Present"/></a> </td>
                                <?php
                               }else if($value->ins_pilot == 'absent'){
                                   ?>
                                  <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="Absent"/></a> </td>
                                   <?php
                               }else{ ?>
                                <td><?php echo "NULL"; ?></td>

                                <?php }
                               ?> 
                               <?php 
                               if($value->ins_emso == 'present'){
                                ?>
                                <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-sucess.png" alt="Present"/></a> </td>
                                <?php
                               }else if($value->ins_emso == 'absent'){
                                   ?>
                                  <td align="center"><a href="#"><img src="<?php echo base_url(); ?>assets/images/icon-inactive.jpg" alt="Absent"/></a> </td>
                                   <?php
                               }else{ ?>
                                <td><?php echo "NULL"; ?></td>

                                <?php }
                               ?>  
                                <td><?php echo $get_name; ?></td>
                                <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">
                                        <?php if ($CI->modules->get_tool_config('MT-ADD-GRI', $this->active_module, true) != '' && $value->is_deleted != '2' && $value->gri_status != '1')  { ?>

                                        <li><a class="onpage_popup action_button" data-href="{base_url}inspection/add_grievance" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;gri_action=add&amp;amb_no=<?php echo $value->ins_amb_no; ?>" data-popupwidth="500" data-popupheight="300">Add</a></li>

                                        <?php } ?>
                                        <?php if ($CI->modules->get_tool_config('MT-VIEW-GRI', $this->active_module, true) != '') { ?>

                                     <li><a class="onpage_popup action_button" data-href="{base_url}inspection/view_grievance" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;gri_action=view&amp;amb_no=<?php echo $value->ins_amb_no; ?>" data-popupwidth="500" data-popupheight="300">View</a></li>
`                                           
                                        <?php } ?>
                                        </ul> 
                                    </div>
                                </td>
                            </tr>
    <?php }
} else { ?>

                        <tr><td colspan="9" class="no_record_text">No history Found</td></tr>

<?php } //} ?>   

                </table>

                <div class="bottom_outer">

                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if (@$data) {
    echo $data;
} ?>">

                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <!-- <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}inspection/gri_listing" data-qr="output_position=content&amp;flt=true">

<?php echo rec_perpg_sup($pg_rec); ?>

                                </select> -->

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