     <ul class="float_left">
                                <li class="dropdown alert_box">
                                    <a  class="" data-qr="output_position=content&amp;ref_id=<?php echo base64_encode($current_user->clg_ref_id); ?>&amp;action=edit_data&amp;prof=true"><b class="header_leads_count"><?php echo notification_count(); ?></b> </a>
                                    <ul class="dropdown-content">
                                        <?php
                                        $notice_data = get_clg_notice();

                                        foreach ($notice_data as $value) {
                                            if (date('Y-m-d H:i:s') <= date("Y-m-d H:i:s", strtotime($value->notice_exprity_date))) {
                                                ?>
                                                <li class="drop-down-list">
                                                    <a class="pSMS onpage_popup " href="{base_url}Clg/get_notice" data-qr="output_position=popup_div&amp;nr_id=<?php echo $value->nr_id; ?>&amp;prof=true&amp;clg_view=view&amp;action_type=View&amp;clg_group=<?php echo $current_user->clg_group; ?>&amp;" data-name="view_profile" data-popupwidth="400" data-popupheight="300">
                                                        <div class="alert_wrapper float_left">

                                                            <p class="float_left" style="color:white;"><?php echo substr($value->nr_notice, 0, 50); ?><br><span style="color:white;" class="header_alert_time_span"> <?php echo date("d-m-Y H:i:s", strtotime($value->notice_exprity_date)); ?> </span></p>
                                                        </div>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?> 

                                    </ul>

                                </li>
                            </ul>