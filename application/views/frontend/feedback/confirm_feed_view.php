

<div class="box_head text_align_center width100">
    <h3>FEEDBACK CALL</h3>
</div>

<div class="confirm_save width100">


    <div class="summary_info">

        <ul class="dtl_block">

            <li><span>Type Of Feedback :</span><?php echo " " . $ftype[0]->fdt_type; ?></li>

            <li><span>Feedback Details :</span><?php echo " " . $fed_details; ?></li>

        </ul>

    </div>

    <div id="summary_div">


    </div>

    <div class="save_btn_wrapper float_left">


        <form name="fed_call_fwd" method="post" id="">


            <input type="hidden" name="fwd_fed_call" value="yes">

            <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>feedback/save" data-qr="output_position=content" type="button" tabindex="25">
            
             <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="26">
            

        </form>


    </div>

</div>





