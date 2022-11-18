
<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Call TO ERC</h3>
</div>

<div class="confirm_save width100">

    
    <div class="summary_info">

        <ul class="dtl_block">
            <li><span>Incident Id :</span>

                <?php echo $amb_erccl_inc_ref_id; ?>

            </li>
            <li><span> Standard Remark :</span><?php echo $re_name; ?></li>
            <li><span>ERO Note : </span><?php echo $inc_ero_summary; ?></li>
        </ul>

    </div>

    




    <div class="save_btn_wrapper float_left">

        <form name="com_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_all" value="yes">

            <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>ambercp/save" data-qr="output_position=content" type="button" tabindex="15">

            <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="16">

        </form>


    </div>
</div>