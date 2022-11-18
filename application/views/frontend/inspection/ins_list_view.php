<?php $CI = EMS_Controller::get_instance(); ?>

<div class="breadcrumb float_left">
    <ul>
        <li class="sms">
            <a class="click-xhttp-request" data-href="{base_url}Inspection/ins_listing">Inspection</a>
        </li>
        <li>
            <span><?php if ($verify_status == "unapprove") { ?>Unapproved<?php } ?>Inspection Listing</span>
        </li>

    </ul>
</div>

<div class="width64 float_left ">
 
    <?= $CI->modules->get_tool_html('MT-ADD-INS', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1800  data-popupheight=1800"); ?>
    <!-- <input class="search_button click-xhttp-request float_right" name="" value="Reset Filters" data-href="{base_url}Inspection/ins_listing" data-qr="output_position=content&amp;filters=reset" type="button"> -->

</div>

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
                        <td><?php echo $value->ins_added_date; ?></td>
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
                                <?php if ($CI->modules->get_tool_config('MT-VIEW-INS', $this->active_module, true) != '') { ?>

                                    <li><a class="onpage_popup action_button" data-href="{base_url}inspection/view_inspection" data-qr="output_position=popup_div&amp;ins_id=<?php echo $value->id; ?>&amp;amb_action=view&amp;amb_dst=<?php echo $value->amb_district; ?>" data-popupwidth="1000" data-popupheight="800">View</a></li>

                                <?php } ?>
                                </ul>
                            </div>
                          
                                </td>                         
                               <!-- <td> 

                                    <div class="user_action_box">

                                        <div class="colleagues_profile_actions_div"></div>

                                        <ul class="profile_actions_list">

        <?php if ($CI->modules->get_tool_config('MT-AMB-VIEW', $this->active_module, true) != '') { ?>

                <li><a class="onpage_popup action_button" data-href="{base_url}amb/edit_amb" data-qr="output_position=popup_div&amp;amb_id[0]=<?php echo base64_encode($value->amb_id); ?>&amp;amb_action=view&amp;amb_dst=<?php echo $value->amb_district; ?>" data-popupwidth="1000" data-popupheight="800">View</a></li>

        <?php } if ($CI->modules->get_tool_config('MT-EIDT-AMB', $this->active_module, true) != '') { ?>

                 <li> <a class="onpage_popup action_button" data-href="{base_url}amb/edit_amb" data-qr="output_position=popup_div&amp;amb_id[0]=<?php echo base64_encode($value->amb_id); ?>&amp;amb_dst=<?php echo $value->amb_district; ?>&amp;th_id=<?php echo $value->amb_tahshil; ?>&amp;amb_action=edit" data-popupwidth="1000" data-popupheight="800"> Edit</a></li>

        <?php } if ($CI->modules->get_tool_config('MT-DEL-AMB', $this->active_module, true) != '') { ?>

                    <li><a class="action_button click-xhttp-request" data-href="{base_url}amb/del_amb" data-qr="amb_id[0]=<?php echo base64_encode($value->amb_id); ?>&amp;output_position=content&amp;page_no=<?php echo @$page_no; ?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this ambulance?"> Delete</a></li>
                    <?php } if($CI->modules->get_tool_config('MT-ACTIVE-INACTIVE',$this->active_module,true)!=''){ ?> 
                                                <li><a class="click-xhttp-request action_button" data-href="{base_url}amb/up_amb_status" data-qr="output_position=popup_div&amp;amb_id=<?php echo $value->amb_id;?>&amp;amb_sts=<?php echo $value->amb_status;?>"><?php if($value->amb_status == '5'){ echo 'Active'; }else{ echo 'In-Active'; } ?></a> </li>

                                                 <?php } 
        
        if ($CI->modules->get_tool_config('MT-ODO-AMB', $this->active_module, true) != '') { ?>

                                                <li><a class="onpage_popup action_button" data-href="{base_url}amb/Odometerc_amb" data-qr="output_position=popup_div&amp;amb_id[0]=<?php echo base64_encode($value->amb_id); ?>&amp;amb_dst=<?php echo $value->amb_district; ?>&amp;th_id=<?php echo $value->amb_tahshil; ?>&amp;amb_action=edit" data-popupwidth="1000" data-popupheight="800">Odometer Change</a></li>

        <?php } if ($CI->modules->get_tool_config('MT-AMB-REPLACE', $this->active_module, true) != '') { ?>

                                                <li> <a class="onpage_popup action_button" data-href="{base_url}amb/replac_amb" data-qr="output_position=popup_div&amp;amb_id[0]=<?php echo base64_encode($value->amb_id); ?>&amp;amb_dst=<?php echo $value->amb_district; ?>&amp;th_id=<?php echo $value->amb_tahshil; ?>&amp;amb_action=edit" >Ambulance Replacement</a></li>

        
        <?php } if ($CI->modules->get_tool_config('MT-AMBID-REOPEN', $this->active_module, true) != '') { ?>

<li> <a class="onpage_popup action_button" data-href="{base_url}amb/reopen_ambid" data-qr="output_position=popup_div&amp;amb_id[0]=<?php echo base64_encode($value->amb_id); ?>&amp;amb_dst=<?php echo $value->amb_district; ?>&amp;th_id=<?php echo $value->amb_tahshil; ?>&amp;amb_action=edit" >Ambulance ID Reopen</a></li>


<?php } if ($CI->modules->get_tool_config('MT-AMB-MNG-TEAM', $this->active_module, true) != '') { ?>
 <li><a class="action_button click-xhttp-request" data-href="{base_url}amb/manage_team" data-qr="amb_id=<?php echo base64_encode($value->amb_id); ?>&amp;rto_no=<?php echo $value->amb_rto_register_no; ?>&amp;output_position=popup_div&amp;cty_name=<?php echo $cty_name; ?>&amp;amb_sts=<?php echo $ambs_name; ?>&amp;amb_type=<?php echo $ambt_name; ?>" data-popupwidth="600" data-popupheight="600">Manage Team</a></li>-->

        <?php } if($CI->modules->get_tool_config('MT-OFF-ON-ROAD-AMB',$this->active_module,true)!=''){ ?> 
                                                <li>

                                                     <a class="action_button click-xhttp-request" data-href="{base_url}amb/change_status" data-qr="amb_id=<?php echo base64_encode($value->amb_id);?>&amp;status=<?php echo $ambs_name;?>&output_position=popup_div" data-popupwidth="600" data-popupheight="600">On-road/Off-road</a>
                                                </li>
                                               

                                                 <?php }  ?>
                                        </ul> 
                                    </div>
                                </td>-->
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}inspection/ins_listing" data-qr="output_position=content&amp;flt=true">

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