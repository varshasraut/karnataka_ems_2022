    
<?php if($call_type_data == 'hold'){
    $hold_class = 'hide';
}else{
    $hold_class = '';
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
if( $call_type_data == 'transfer'){
    $transfer_class = 'hide';
}else{
    $transfer_class = '';
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
                            //var_dump($call_data); die();
                            echo $call_data["DialNo"];
                            ?>
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
                            <li class="dial_button disabledbutton  <?php echo $hold_class; ?> <?php echo $unhold_class; ?> <?php echo $conference_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" title="Make Call"></a></li>
                             <li class="make_trans_dial_button  <?php echo $hold_class; ?> <?php echo $unhold_class; ?> <?php echo $conference_class; ?> <?php echo $dialing_class;?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/make_transfter_call" title="Make Call"></a></li>
                            <li class="trans_dial_button  <?php echo $hold_class; ?> <?php echo $dialing_class; ?> <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/transfter_call" data-qr="showprocess=no" title="transfer call"></a></li>
                            <li class="conference_button  <?php echo $hold_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>"></li>
                            <li class="call_conference_button <?php echo $dialing_class; ?> "><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/conference_call" data-qr="showprocess=no" title="Conference Call"></a></li>

                            <li class="call_hold_button <?php echo $hold_class; ?> <?php echo $dialing_class; ?>  <?php echo $conference_class; ?>  <?php echo $transfer_class;?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/hold_call" data-qr="showprocess=no" title="Hold Call"></a></li>
                            <li class="call_unhold_button <?php echo $dialing_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>  <?php echo $conference_class; ?>  <?php echo $transfer_class;?>"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/unhold_call" data-qr="showprocess=no" title="Unhold Call"></a></li>

                            <li class="call_merge_button <?php echo $dialing_class; ?>  <?php echo $unhold_class; ?> <?php echo $hold_class; ?> "><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/merge_call" title="Merge Call"></a></li>

                            <li class="call_transfer_button  <?php echo $hold_class; ?>  <?php echo $unhold_class; ?>  <?php echo $conference_class; ?>" title="Start Transfer"></li>
                            <li class="disconnect_button" ><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/disconnect_call" data-qr='ActionID=<?php echo $call_data["ActionID"]; ?>&AgentID=<?php echo $call_data["AgentID"] ?>&AgentExtension=<?php echo $call_data["AgentExtension"]; ?>&showprocess=no' title="Disconnect Call"></a></li>

                        </ul>
                    </div>

                    <div class="dialer_buttons <?php echo $dialing_class ?>">
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
        <!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url(); ?>avaya_api/soft_dial' data-qr='output_position=content'  TABINDEX="21">-->
        <!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url(); ?>avaya_api/conf_call_dial' data-qr='output_position=content'  TABINDEX="21" style="margin-left: 0px;">-->
        <!--            <a class="dialer_button dialer_connect form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content"></a>   -->
                    <!--        <div class="dialer_button dialer_disconnect"></div>-->

                </div>
            </form>
        </div>
    </div>
</div>