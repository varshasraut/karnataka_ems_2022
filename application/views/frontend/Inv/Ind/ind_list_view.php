<?php
$CI = EMS_Controller::get_instance();

$dispatch = $CI->modules->get_tool_config('MT-DIS-IND-REQ', 'M-IND', true);


$receive = $CI->modules->get_tool_config('MT-REC-IND-REQ', 'M-IND', true);

$view = (@$clg_group != 'UG-ADMIN') ? $CI->modules->get_tool_config('MT-VIEW-IND', 'M-IND', true) : $CI->modules->get_tool_config('MT-VIEW-INV-LIST', 'M-INV', true);

if((@$clg_group == 'UG-ADMIN')){  ?>

<div class="breadcrumb float_left pad_btm">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}amb/amb_listing">Indent</a>
            </li>
            <li>
                <span><?php if($verify_status=="unapprove"){ ?>Unapproved<?php } ?> <?php if($req_type == 'sick_room'){ echo "Sick Room"; } else { echo "Ambulance";}?> Indent Listing</span>
            </li>

        </ul>
</div>

<?php }else{?>

<h3 class="txt_clr5 width2 float_left"><?php if($req_type == 'sick_room'){ echo "Sick Room"; } else { echo "Ambulance";}?> Indent Listing</h3><br>

<?php } ?>

<form method="post" name="ind_list" id="ind_list">  

    <div id="amb_filters"></div>

    <div id="list_table">
        
        <table class="table report_table">

            <tr>                                  
                <th>Request From</th>
                <th>EMT Name</th>
                                     
                <th>Base Location</th>
                <th>Date</th>
                <th>Approval Status</th>
                <th>Status</th>
                <th class="width79px">Action</th>
            </tr>

            <?php
            if (count($result) > 0) {

                $total = 0;
            
                foreach ($result as $ind_data) { 

                    $date_format = date_format(date_create($ind_data->req_date), "d-m-Y");?>

                    <tr>
                         <td><?php echo $ind_data->req_amb_reg_no . "-" . $ind_data->req_emt_id; ?></td>
                        <td><?php echo ($ind_data->hp_name != '') ? $ind_data->hp_name : "-"; ?></td>
                        <td><?php echo $date_format; ?></td>
                        <td><?php  
                        
                            if ($ind_data->req_is_approve == '0') {
                                $status = "Approval Pending";
                            }else if ($ind_data->req_is_approve == '1') {
                                $status = "Approved";
                            }else if ($ind_data->req_is_approve == '2') {
                                $status = "Not Approved";
                            }
                             echo $status;
                        ?></td>
                        <td><?php
                            $status = "Pending";

                            if ($ind_data->req_dis_by != '') {
                                $status = "Dispatched";
                            }
                            if ($ind_data->req_rec_by != '') {
                                $status = "Received";
                            }

                            echo $status;
                            ?>
                        </td>

                        <td>
                            <div class="user_action_box">

                                <div class="colleagues_profile_actions_div"></div>

                                <ul class="profile_actions_list">

                                    <?php if ($view != '') { ?>

                                        <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;ind_emt_id=<?php echo base64_encode($ind_data->req_emt_id); ?>&amp;req_id=<?php echo $ind_data->req_id; ?>&amp;action=view&amp;req_type=<?php echo $ind_data->req_type; ?>" data-popupwidth="800" data-popupheight="700">View</a></li>

                                    <?php } ?>

                                    <?php 
                                        
                                        if($ind_data->req_type == 'sick_room'){
                                            $amb_id = $ind_data->req_school_id ;
                                        }else{
                                            $amb_id = $ind_data->req_amb_reg_no;
                                        }
                                    if ($dispatch != '' && $ind_data->req_dis_by == '' && (@$clg_group == 'UG-ADMIN' || @$clg_group == 'UG-SUPP-CH') && $ind_data->req_is_approve == 1) { 
                            
                                       
                                        ?>
                                        <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;req_id=<?php echo $ind_data->req_id; ?>&amp;req_type=<?php echo $ind_data->req_type; ?>&amp;amb_no=<?php echo base64_encode($amb_id);?>&amp;action=dis" data-popupwidth="800" data-popupheight="700">Dispatch</a></li>

                                    <?php } ?>

                                    <?php //if ($receive != '' && $ind_data->req_dis_by != '' && $ind_data->req_rec_by == '' || ((@$clg_group == 'UG-EMT' || $ind_data->req_emt_id == '') && (@$clg_group == 'UG-HEALTH-SUP' || $ind_data->req_emt_id == ''))) { 
                                    if ($receive != '' && $ind_data->req_dis_by != '' && $ind_data->req_rec_by == '' && ((@$clg_group == 'UG-EMT') || (@$clg_group == 'UG-HEALTH-SUP' ) || (@$clg_group == 'UG-SICK-SUP' )) && $ind_data->req_is_approve == 1 ) { ?>


                                        <li><a class="onpage_popup action_button" data-href="{base_url}ind/view_ind_details" data-qr="output_position=popup_div&amp;req_id=<?php echo $ind_data->req_id; ?>&amp;amb_no=<?php echo base64_encode($amb_id);?>&amp;action=rec&amp;req_type=<?php echo $ind_data->req_type; ?>" data-popupwidth="800" data-popupheight="700">Receive</a></li>

                                    <?php } ?>
                                        <?php
                              
//if ($receive != '' && $ind_data->req_dis_by != '' && $ind_data->req_rec_by == '' || ((@$clg_group == 'UG-EMT' || $ind_data->req_emt_id == '') && (@$clg_group == 'UG-HEALTH-SUP' || $ind_data->req_emt_id == ''))) { 
                                    //if (($clg_group == 'UG-DM') && $ind_data->req_is_approve == '0') { ?>


                                        <li><a class="click-xhttp-request action_button" data-href="{base_url}ind/approve_ind_details" data-qr="req_id=<?php echo $ind_data->req_id; ?>&ampreq_type=<?php echo $ind_data->req_type; ?>" >Approve</a></li>

                                    <?php //} ?>
                                </ul> 
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>

                <tr><td colspan="7" class="no_record_text">No Record Found</td></tr>

            <?php } ?>   
                
        </table>

        <div class="bottom_outer">

            <div class="pagination"><?php echo $pagination; ?></div>

            <input type="hidden" name="submit_data" value="<?php if (@$data){ echo $data; } ?>">

            <div class="<?php if (@$clg_group == 'UG-ADMIN' || @$clg_group == 'UG-SUPP-CH') { ?>float_right width38 <?php } else { ?>float_right width30<?php } ?>">

                <div class="record_per_pg">

                    <div class="per_page_box_wrapper">

                        <span class="dropdown_pg_txt float_left"> Records per page : </span>

                        <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}ind/ind_list" data-qr="output_position=content&amp;flt=true"><?php echo rec_perpg($pg_rec); ?>
                        </select>
                    </div>

                    <div class="float_right">
                        <span> Total records: <?php if (@$total_count){ echo $total_count; }else{ echo"0"; } ?></span>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>