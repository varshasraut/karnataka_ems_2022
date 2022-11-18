


<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Grievance CALL</h3>
</div>


<div class="confirm_save width100">




    <div class="summary_info">

        <ul class="dtl_block">

            <li><span>Type Of Complaint :</span><?php echo " " . $cmpl[0]->cct_type; ?></li>

            <li><span>Complaint Details :</span><?php echo " " . $cmpl_details; ?></li>

        </ul>

    </div>

    <div id="summary_div">


    </div>




    <div class="save_btn_wrapper float_left">

        <form name="com_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_com_call" value="yes">

            <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>complaint/save" data-qr="output_position=content" type="button" tabindex="15">

            <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="16">

        </form>


    </div>

</div>





