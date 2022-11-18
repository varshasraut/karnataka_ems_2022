
<div class="box_head text_align_center width100">
    <h3>UNRECOGNIZED CALL</h3>
</div>

<div class="confirm_save width100">

    <div class="summary_info">

        <ul class="dtl_block">

            <li><span>Type Of Call : </span><?php echo $cl_type[0]->cl_type; ?></li>
            <li><span>ERO Notes : </span><?php echo $ucl_ero_note; ?></li>
        </ul>

    </div>

    <div class="save_btn_wrapper float_left">

        <form name="unrec_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_unrec_call" value="yes">

            <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>unrecog/save" data-qr="output_position=content" type="button" tabindex="11">

            <input name="" tabindex="12" value="CANCEL" class="cancel_btn style3"  type="button">

        </form>


    </div>

</div>





