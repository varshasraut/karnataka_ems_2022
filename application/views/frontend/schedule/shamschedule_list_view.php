<?php $CI = EMS_Controller::get_instance();?>
  
<div class="breadcrumb float_left">
        <ul>
            <li class="sms">
                <a class="click-xhttp-request" data-href="{base_url}schedule/shamschedule_listing">Schedule</a>
            </li>
            <li>
                Preventive measures schedule for the quarter
            </li>

        </ul>
</div>

<div class="width2 float_right ">
        
   

</div>

<br><br>

<div class="box3">    
    
    <div class="permission_list group_list">
      
        <form method="post" name="shamschedule_form" id="shamschedule_list">  
            
        <div id="shamschedule_filters"></div>
            
            <div id="list_table">
            
            
                <table class="table report_table">

                    <tr>                
                        <th><input type="checkbox" title="Select All Users" name="selectall" class="base-select" data-type="default"></th>                        
                        <th nowrap>Sr No</th>
                        <th nowrap>Date</th>
                        <th nowrap>Time</th>
                        <th nowrap>School name</th>
                        <th nowrap>School ID</th>
                        <th nowrap>Head master name</th>
                        <th nowrap>School contact no</th>
                        <th nowrap>SHAM Approve</th>
                        <th>Action</th> 
                    </tr>

                    <?php  if(count($result)>0){  

                    $total = 0;
                    foreach($result as $value){  
						$asScheduleDatetime = explode(' ',$value->schedule_date);
						$asDate = explode('-',$asScheduleDatetime[0]);
                       ?>
                    <tr>
                        <td><input type="checkbox" data-base="selectall" class="base-select" name="schedule_id[<?= $value->schedule_id; ?>]" value="<?=base64_encode($value->schedule_id);?>" title="Select All Schedules"/></td><?php //}?>
                        <td><?php echo $value->schedule_id;?></td>
                        <td><?php echo date('d-M-Y',mktime(0,0,0,$asDate[1],$asDate[2],$asDate[0]));?></td>
                        <td><?php echo $asScheduleDatetime[1];?></td>
                        <td><?php echo $value->school_name;?></td>
                        <td><?php echo $value->school_id;?></td>
                        <td><?php echo $value->school_headmastername;?></td>
                        <td><?php echo $value->school_mobile;?></td>
                        <td>
						<?php 
						if($value->schedule_isapprove)
						{
							echo 'Yes';
						}
						else
						{
							echo 'No';
						}
						?>
						</td>
                        <td> 
                                
                            <div class="user_action_box">
                            
                                <div class="colleagues_profile_actions_div"></div>
                                
                                <ul class="profile_actions_list">
                                       
                                     <?php
										if($CI->modules->get_tool_config('MT-APPROVE-SCHEDULE',$this->active_module,true)!=''){ ?>

                                        <li> <a class="onpage_popup action_button" data-href="{base_url}schedule/approve_schedule" data-qr="output_position=popup_div&amp;schedule_id[0]=<?php echo base64_encode($value->schedule_id);?>&amp;schedule_action=approve" data-popupwidth="1000" data-popupheight="800"> Approve</a></li>

                                    <?php } ?>
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

                                <select name="pg_rec" class="dropdown_per_page float_left change-xhttp-request" data-href="{base_url}schedule/shamschedule_listing" data-qr="output_position=content&amp;flt=true">

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