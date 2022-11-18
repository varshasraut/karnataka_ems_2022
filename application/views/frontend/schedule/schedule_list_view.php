<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}schedule/schedule_listing">Schedule</a>
            </li>
            <li>
                Screening Schedule Listing
            </li>

        </ul>
</div>

<div class="width2 float_right ">
        
     <?= $CI->modules->get_tool_html('MT-ADD-SCHEDULE', $CI->active_module, 'onpage_popup add_catalog_btn float_right', "", "data-popupwidth=1000  data-popupheight=800"); ?>

</div>


<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="schedule_form" id="schedule_list">  

            <div id="schedule_filters">
                <div class="filters_groups">                   
                <div class="search">
                    <div class="row list_actions">
                        <?php if($show_approve == 1){?>
                            <div class="float_left width20">
                                 <input type="button" class="search_button float_left form-xhttp-request" name="" value="Approve" data-href="{base_url}schedule/approve_schedule" data-qr="output_position=content&isaprove=1" />
                            </div>
                        <?php } ?>
                        <div class="float_left width40">
                            <div class="float_left width50">
                                <input type="text"  class="controls schedule_item" id="schedule_item" name="schedule_item" value="<?php echo @$schedule_item; ?>" placeholder="Search"/>  
                            </div>
                            <div class="width_33 float_left">
                                <input type="button" class="search_button float_right form-xhttp-request" name="" value="Search" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;flt=true" />
                            </div>
                        </div>
                        <div class="float_left width40">
                            <div class="float_left width50">
                               
                                <select name="filter">
                                    <option value="">Select Filter</option>
                                    <option value="0" <?php if($filter=='0'){ echo "selected"; } ?>>Not Approve</option>
                                    <option value="1"  <?php if($filter=='1'){ echo "selected"; } ?>>Approve</option>
                                </select>
                            </div>
                            <div class="width_33 float_left">
                                <input type="button" class="search_button float_right form-xhttp-request" name="" value="Filter" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;flt=true" />
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            </div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        
                        <th nowrap>Sr No</th>
                        <th nowrap>Date</th>
                        <th nowrap>Time</th>
                        <th nowrap>School name</th>
                        <th nowrap>Status</th>
<!--                        <th nowrap>Student list</th>-->
                        
                        <th>Action</th> 
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    $count = $offset;
                    foreach($result as $key=>$value){  
						$asScheduleDatetime = explode(' ',$value->schedule_date);
						$asDate = explode('-',$asScheduleDatetime[0]);
                       ?>
                    <tr>
                        <td><input type="checkbox" data-base="selectall" class="base-select" name="schedule_id[<?= $value->schedule_id; ?>]" value="<?=$value->schedule_id;?>" title="Select All Schedules"/></td>
                        <td><?php echo $count+$key+1;?></td>
                        <td><?php echo date('d-M-Y',strtotime($value->schedule_date));?></td>
                        <td><?php echo date('g:s A',strtotime($value->schedule_time));?></td>
                        <td><?php echo $value->school_name;?></td>
                        <td>
                            <?php if( $value->schedule_fwdshpm == '0' ){ echo 'Not Forwarded'; }else if($value->schedule_isaprove == '1' ){ echo "Approved";}else if($value->schedule_isaprove == '2'){ echo "Not Approved"; }else{ echo "Approval pending"; }?></td>
                        <td> 
                                
                            <div class="user_action_box">
                            
                                <div class="colleagues_profile_actions_div"></div>
                                
                                <ul class="profile_actions_list">
                                       
                                     <?php
                                    if($CI->modules->get_tool_config('MT-VIEW-SCHEDULE',$this->active_module,true)!=''){ ?>
                                       
                                        <li><a class="onpage_popup action_button" data-href="{base_url}schedule/edit_schedule" data-qr="output_position=popup_div&amp;schedule_id[0]=<?php echo base64_encode($value->schedule_id);?>&amp;schedule_action=view&amp;" data-popupwidth="1000" data-popupheight="800">View</a></li>

                                    <?php } if($CI->modules->get_tool_config('MT-EDIT-SCHEDULE',$this->active_module,true)!=''){ 
                                         if( ($value->schedule_isaprove == '0' && $value->schedule_fwdshpm != '1')){ 
                                        ?>

                                        <li> <a class="onpage_popup action_button" data-href="{base_url}schedule/edit_schedule" data-qr="output_position=popup_div&amp;schedule_id[0]=<?php echo base64_encode($value->schedule_id);?>&amp;schedule_action=edit" data-popupwidth="1000" data-popupheight="800"> Edit</a></li>

                                         <?php } } if($CI->modules->get_tool_config('MT-DEL-SCHEDULE',$this->active_module,true)!=''){ 
                                           
                                         if( (($value->schedule_isaprove == '0' && $value->schedule_fwdshpm == '0') || ($value->schedule_isaprove == '2') ) || ($value->schedule_fwdshpm == '0' )) {?>
                                       
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}schedule/del_schedule" data-qr="schedule_id[0]=<?php echo base64_encode($value->schedule_id);?>&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to delete this Schedule?"> Delete</a></li>

                                         <?php  } }  if($CI->modules->get_tool_config('MT-FWD-SHPM',$this->active_module,true)!=''){ 
                                        
                                        if( $value->schedule_fwdshpm == '0'){ ?>
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}schedule/forword_to_shpm" data-qr="schedule_id[0]=<?php echo base64_encode($value->schedule_id);?>&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to forward this Schedule to SHPM?"> Forward to SHPM</a></li>

                                        <?php } } if($CI->modules->get_tool_config('MT-APPROVE-SCHEDULE',$this->active_module,true)!=''){ 
                                         
                                             if( $value->schedule_isaprove == '0' || $value->schedule_isaprove == '2'){ ?>
                                           
                                    
                                        <li><a class="action_button click-xhttp-request" data-href="{base_url}schedule/approve_schedule" data-qr="schedule_id=<?php echo base64_encode($value->schedule_id);?>&isaprove=1&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to approve this Schedule?"> Approve</a></li>

                                        <?php }else{ ?>
                                            <li><a class="action_button click-xhttp-request" data-href="{base_url}schedule/approve_schedule" data-qr="schedule_id=<?php echo base64_encode($value->schedule_id);?>&isaprove=0&amp;output_position=content&amp;page_no=<?php echo @$page_no;?>" data-confirm="yes" data-confirmmessage="Are you sure to approve this Schedule?">Not Approve</a></li>
                                      <?php  } } ?>
                                </ul> 
                            </div>
                        </td>
                    </tr>
                     <?php } }else{   ?>

                    <tr><td colspan="9" class="no_record_text">No history Found</td></tr>
                    
                 <?php } ?>   

                </table>
                
                <div class="bottom_outer">
            
                    <div class="pagination"><?php echo $pagination; ?></div>

                    <input type="hidden" name="submit_data" value="<?php if(@$data){ echo $data; }?>">
 
                    <div class="width38 float_right">

                        <div class="record_per_pg">

                            <div class="per_page_box_wrapper">

                                <span class="dropdown_pg_txt float_left"> Records per page : </span>

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}schedule/schedule_listing" data-qr="output_position=content&amp;flt=true">

                                    <?php echo rec_perpg($pg_rec); ?>

                                </select>

                            </div>

                                <div class="float_right">
                                    <span> Total records: <?php echo (@$total_count) ?  $total_count : "0";?> </span>
                                </div>
                        </div>

                    </div>
                    
                </div>
      
            </div>
        </form>
    </div>
</div>