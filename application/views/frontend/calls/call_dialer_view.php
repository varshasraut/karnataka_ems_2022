<div class="width100 dialer_outer_block">

         <form enctype="multipart/form-data" action="#" method="post" id="soft_dial">
        <div class="width100 dialer_numbers" id="dialer_box">
            <div class="width100 dial_no" id="dial_no_box">
                <input class="no" type="text" value="<?php if(!empty($mobile_no)){echo $mobile_no;}else{ echo '0';}?>" name="mobile_no">
                <span class="dialer_delete"></span>
            </div>

            <div class="dialer_button click_number" data-number="1">1</div>
            <div class="dialer_button click_number" data-number="2">2</div>
            <div class="dialer_button click_number" data-number="3">3</div>
            <div class="dialer_button click_number" data-number="4">4</div>
            <div class="dialer_button click_number" data-number="5">5</div>
            <div class="dialer_button click_number" data-number="6">6</div>
            <div class="dialer_button click_number" data-number="7">7</div>
            <div class="dialer_button click_number" data-number="8">8</div>
            <div class="dialer_button click_number" data-number="9">9</div>
            <div class="dialer_button click_number" data-number="*">*</div>     
            <div class="dialer_button click_number" data-number="0">0</div>
            <div class="dialer_button click_number" data-number="#">#</div>
            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url();?>avaya_api/soft_dial' data-qr='output_position=content'  TABINDEX="21">
<!--            <input type="button" name="Dial" value="Dial" class="dialer_button dialer_connect form-xhttp-request" data-href='<?php echo base_url();?>avaya_api/conf_call_dial' data-qr='output_position=content'  TABINDEX="21" style="margin-left: 0px;">-->
<!--            <a class="dialer_button dialer_connect form-xhttp-request" data-href="<?php echo base_url();?>avaya_api/soft_dial" data-qr="output_position=content"></a>   -->
    <!--        <div class="dialer_button dialer_disconnect"></div>-->

        </div>
    </form>
</div>