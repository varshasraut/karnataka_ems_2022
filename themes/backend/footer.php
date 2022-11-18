<div class="footer width100">

    <?php $year = date('Y');
          $next_year = $year+1;
    ?>
    <span class="text_pan"> &COPY;Spero System <?php echo $year;?>-<?php echo $next_year;?></span>
<!--    <span id="siteseal" class="float_right"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=GptqfC2FKPHO1SKRQWCqkl7kzMpsGMsUpyplSw1eIWgXH2fvdL60NpMnOsKM"></script></span>-->
<!--    <span id="siteseal" style="float: right;"><script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=uGDf0LC2h9LSh1CqBzqfsT4N2vgSTjjOWbeOVa67WQMuyUCO72sKFtH0qQ2A"></script></span>-->

</div>

<script>
   keep_alive_clg();
</script>

<div id="attend_dialer_box" class="dialer_block_outer"  style="display: none">
    <div class="dialer_block">
        <button type="button" class="dialer_close" ></button>
        <div class="width100 dialer_outer_block">
            <form enctype="multipart/form-data" action="#" method="post">
                <div class="width100 dialer_numbers" >
                    <div class="dialer_msg">
                        <div class="dia-msg">
                        </div>

                        <div class="width100 dial_no dial_no_box">
                            <input class="no" type="text" value="" name="mobile_no">
            <!--                <span class="dialer_delete"></span>-->
                        </div>
                    </div>
                    <div class="dia_botton_block">
                        <ul>
                            <li class="dial_button">
<!--                                <a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/soft_dial"></a>-->
                            <a data-href="<?php echo base_url();?>calls/atnd_cls" data-qr="" class="click-xhttp-request" id="attend_call_btn"></a>
<!--                                <a data-href="#" data-qr="" class="click-xhttp-request" id="attend_call_btn"></a>-->
                            </li>

<!--                            <li class="disconnect_button" ><a class="click-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/disconnect_call" data-qr='output_position=content&ActionID=<?php echo time();?>&AgentID=<?php echo $ext_no;?>'></a></li>-->
                        </ul>
                    </div>

                    <div class="dialer_buttons">
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
                    <!--            <div class="after_call_connect">
                                    <div class="dia_botton_block">
                                        <ul>
                                            <li class="conference_button"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/conference_call"></a></li>
                                            <li class="call_transfer_button"><a class="form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/transfter_call"></a></li>
                                        </ul>
                                    </div>
                                </div>-->
                    <!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url(); ?>avaya_api/soft_dial' data-qr='output_position=content'  TABINDEX="21">-->
                    <!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url(); ?>avaya_api/conf_call_dial' data-qr='output_position=content'  TABINDEX="21" style="margin-left: 0px;">-->
                    <!--            <a class="dialer_button dialer_connect form-xhttp-request" data-href="<?php echo base_url(); ?>avaya_api/soft_dial" data-qr="output_position=content"></a>   -->
                    <!--        <div class="dialer_button dialer_disconnect"></div>-->

                </div>
            </form>
        </div>
    </div>
</div>