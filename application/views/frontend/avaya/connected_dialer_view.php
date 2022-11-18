    
<?php 
if($call_type_data == 'hold' && $call_type_data == ''){
    $hold_class = 'hide';
}else if($call_type_data == 'dialing'){
    $hold_class = '';
}else{
    $hold_class = 'hide';
}

if($call_type_data == 'dialing'){
    $dialing_class = 'hide';
}else{
    $dialing_class = '';
}

if($call_type_data == 'unhold'){
    $unhold_class = 'hide';
}else{
    $unhold_class = '';
}

if($call_type_data == 'conference'){
    $conference_class = 'hide';
}else{
    $conference_class = '';
}

if($call_type_data == 'merge'){
    $merge_class = 'hide';
}else{
    $merge_class = '';
}

?>
<div class="dialer_block_outer">
    <div class="dialer_block">
        <button type="button" id="dialer_close" ></button>
        <div class="width100 dialer_outer_block">
            <form enctype="multipart/form-data" action="#" method="post" id="soft_dial">
                <div class="width100 dialer_numbers" id="dialer_box">
                    <div class="dialer_msg">
                        <div class="dia-msg">
                            <?php
                            //var_dump($conf_mobile);
                            echo $call_data["DialNo"];
                          //  echo $soft_dial_mobile.'<br>';
                            if($conf_mobile){
                            foreach($conf_mobile as $conf){
                               // echo $conf."<br>";
                            } } ?>
                            <ul class="active_calls_with_status">
                            <?php 
                            $hold =0;
                            $active =0;
                            if($active_calls){
                                foreach($active_calls as $calls){
                                    if($calls['call_status'] == 'call_hold'){
                                        $hold++;
                                    }
                                    if($calls['call_status'] == 'active'){
                                        $active++;
                                    }
                                    ?>
                                <li class="<?php echo $calls['call_status'];?>"><?php echo $calls['mobile_no'];?></li> 
                              <?php  }
                            }
                            ?>
                            </ul>
                            
                            
                        </div>

                        <div class="width100 dial_no" id="dial_no_box">
                            <input class="no" type="text" value="<?php if (!empty($mobile_no)) {
                                echo $mobile_no;
                            } else {
                                echo '0';
                            } ?>" name="mobile_no">
            <!--                <span class="dialer_delete"></span>-->
                        </div>
                    </div>
                    <div class="dia_botton_block">
                        <ul>
                            <?php if($call_type_data != 'start_conference'){ ?>
                            <li class="dial_button"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/add_conference_call"></a></li>
                            <?php } ?>
                              <?php if($call_type_data == 'start_conference' || $call_type_data == 'add_conference' ){ ?>
                             <li class="call_conference_button"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/add_conference_call"></a></li>
                            <?php } ?>
                               <li class="disconnect_button" ><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/soft_dial_disconnect" data-qr='ActionID=<?php echo $call_data["ActionID"]; ?>&AgentID=<?php echo $call_data["AgentID"] ?>&AgentExtension=<?php echo $call_data["AgentExtension"]; ?>'></a></li>
                                <li class="call_hold_button <?php echo $hold_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/hold_call"></a></li>
                            <li class="call_unhold_button <?php echo $dialing_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>  <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/unhold_call"></a></li>
                             <?php if($call_type_data == 'dialing'){ ?>
<!--                             <li class="trans_dial_button"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/transfter_call"></a></li>-->
                              <li class="conference_button"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/start_conference_call"></a></li>
                             <?php } ?>
                             <?php 
                            
                           ?>
                            
                            
                            
                        </ul>
<!--                        <ul>
                            <li class="dial_button disabledbutton  <?php echo $hold_class; ?> <?php echo $unhold_class; ?> <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/conference_call"></a></li>
                            <li class="trans_dial_button  <?php echo $hold_class; ?> <?php echo $dialing_class; ?> <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/transfter_call"></a></li>
                            <li class="conference_button  <?php echo $hold_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/start_conference_call"></a></li>
                            <li class="call_conference_button <?php echo $dialing_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/add_conference_call"></a></li>

                            <li class="call_hold_button <?php echo $hold_class; ?> <?php echo $dialing_class; ?>  <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/hold_call"></a></li>
                            <li class="call_unhold_button <?php echo $dialing_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>  <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/unhold_call"></a></li>

                            <li class="call_merge_button <?php echo $dialing_class; ?>  <?php echo $unhold_class; ?> <?php echo $hold_class; ?> <?php echo $merge_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/conference_call"></a></li>
                            
                             <li class="call_merge_button <?php echo $dialing_class; ?>  <?php echo $unhold_class; ?> <?php echo $hold_class; ?> "><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/manage_call"></a></li>

                            <li class="call_transfer_button  <?php echo $hold_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>  <?php echo $merge_class; ?>"></li>
                            <li class="disconnect_button" ><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/soft_dial_disconnect" data-qr='ActionID=<?php echo $call_data["ActionID"]; ?>&AgentID=<?php echo $call_data["AgentID"] ?>&AgentExtension=<?php echo $call_data["AgentExtension"]; ?>'></a></li>

                        </ul>-->
                    </div>

                    <div class="dialer_buttons <?php //echo $dialing_class ?>">
                        <div class="dialer_button click_number" data-number="1">1</div>
                        <div class="dialer_button click_number" data-number="2">2</div>
                        <div class="dialer_button click_number" data-number="3">3</div>
                        <div class="dialer_button click_number" data-number="4">4</div>
                        <div class="dialer_button click_number" data-number="5">5</div>
                        <div class="dialer_button click_number" data-number="6">6</div>
                        <div class="dialer_button click_number" data-number="7">7</div>
                        <div class="dialer_button click_number" data-number="8">8</div>
                        <div class="dialer_button click_number" data-number="9">9</div>
                        <div class="dialer_button" style="visibility: hidden;">C</div>     
                        <div class="dialer_button click_number" data-number="0">0</div>
                        <div class="dialer_button" style="visibility: hidden;">D</div>
                    </div>
        <!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url(); ?>coral_avaya_api/soft_dial' data-qr='output_position=content'  TABINDEX="21">-->
        <!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url(); ?>coral_avaya_api/conf_call_dial' data-qr='output_position=content'  TABINDEX="21" style="margin-left: 0px;">-->
        <!--            <a class="dialer_button dialer_connect form-xhttp-request" data-href="<?php echo base_url(); ?>coral_avaya_api/soft_dial" data-qr="output_position=content"></a>   -->
                    <!--        <div class="dialer_button dialer_disconnect"></div>-->

                </div>
            </form>
        </div>
    </div>
</div>