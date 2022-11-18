

<div class="box_head text_align_center width100">
    <h3  class="txt_pro">MEDICAL ADVICE CALL</h3>
</div>

<div class="confirm_save width100">

    <ul class="dtl_block">
        <li><span>Previous Incident Id :</span>

            <?php echo $adv_inc_ref_id; ?>

        </li>
        <li><span>New Incident Id :</span>

            <?php echo $adv_new_inc_ref_id; ?>

        </li>
        <li><span> Standard Remark :</span><?php echo $re_name; ?></li>
        <li><span>ERO Note : </span><?php echo $inc_ero_summary; ?></li>
    </ul>

    <div id="summary_div">

    </div>




    <div class="save_btn_wrapper float_left beforeunload">

        <form name="medadv_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_medadv_call" value="yes">

            <input name="" value="Save" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>medadv/save" data-qr="output_position=content" type="button" tabindex="9">

            <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="10">

        </form>


    </div>

</div>





