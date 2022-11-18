     <ul class="float_left">
                                     <li class="dropdown msg_box">
                                    <a  class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count"><?php echo ero_notification_count(); ?></b> </a>
                                    <ul class="dropdown-content">
                                        <?php
                                        $notice_data = get_ero_notice();

                                        foreach ($notice_data as $value) {
                                          date('Y-m-d') == date("Y-m-d", strtotime($value->er_notice_date))
                                                ?>
                                                <li class="drop-down-list">
                                                    <a class="pSMS onpage_popup " href="{base_url}quality_forms/get_notice_ero_view" data-qr="output_position=popup_div&amp;id=<?php echo $value->id; ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>&amp;" data-name="view_profile" data-popupwidth="400" data-popupheight="300">
                                                        <div class="alert_wrapper float_left">
                                                            <?php if ($value->er_notice != '') { ?>
                                                            <span style="color:white;" class="header_alert_time_span">  <?php echo substr($value->er_notice, 0, 50); ?></span><br><span style="color:white;" class="header_alert_time_span"> <?php echo $value->er_notice_date; ?> </span>
                                                           <?php } else if ($value->inc_ref_id != ' ') { ?> 
                                                                <span style="color:white;" class="header_alert_time_span">
                                                                    Inc ref Id : <?php echo $value->inc_ref_id; ?> </span><br>
                                                                <span style="color:white;" class="header_alert_time_span">
                                                                 Remark : <?php echo $value->er_remark; ?>     </span><br>
                                                                <span style="color:white;" class="header_alert_time_span">
                                                                 Quality Score :  <?php echo $value->quality_score; ?>     
                                                                </span>    
                                                                <span style="color:white;" class="header_alert_time_span">
                                                                 Datetime :   <?php echo $value->er_notice_date; ?>     
                                                                </span>    
                                                            <?php } ?>
                                                        </div>
                                                        
                                                    </a>
                                                </li>
                                                <?php
                                             }
                                            
                                       
                                        ?> 

                                    </ul>

                                </li>
                            </ul>