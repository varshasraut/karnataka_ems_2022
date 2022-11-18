<?php $CI = GB_Controller::get_instance();?>
<div class="count_box"><?=$total_notification->total_notifications;?></div>
      <div class="alert_menu"></div>
      <div class="white_down_arrow"></div>
      <div class="alert_box_dropdown top_navigation_dropdown">
        <div class="mail_top_heading">
          <div class="title"><?=$total_notification->total_notifications;?> New Alerts</div>
        </div>
        <ul class="mail_list alert_box_scroll" id="mail_block_scroll">
        <?php    if(is_array($notifications)){
					   
						   foreach($notifications as $notification){
							  // $CI->modules->get_tool_config()
							   
							  // MT-EVT-VIEW-EVENTS
							   ?>
          <li>
            <div class="mail_right_text <?=strtolower($notification->nt_source_type)?>"> 
          
          <table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><?=$notification->nt_title?></td></tr>
    <tr>
    <td align="right"><em><?=$CI->format_seconds(time()-strtotime($notification->nt_time))?> ago</em></td>
  </tr>
</table>
 </div>
          </li>
          
          <?php }
		  
		}?>
      
        </ul>
        <div class="mail_bottom_box"> &nbsp; </div>
      </div>