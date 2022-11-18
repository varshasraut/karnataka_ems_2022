
<div class="box_head text_align_center width100">
    <h3 class="txt_pro">PROBLEM REPORTING CALL</h3>
</div>

<div class="confirm_save width100">

    
    <div class="summary_info">

        <ul class="dtl_block">
            <li><span>Incident Id :</span>

                <?php echo $rcl_inc_ref_id; ?>

            </li>
<!--            <li><span> Standard Remark :</span><?php echo $re_name; ?></li>-->
            <li><span> ERO Summary :</span><?php echo $re_name; ?></li>
            <li><span>ERO Note : </span><?php echo $inc_ero_summary; ?></li>
        </ul>

    </div>

    




    <div class="save_btn_wrapper float_left beforeunload">

        <form name="com_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_all" value="<?php echo $forword;?>">
            <?php if($forword == 'no'){ ?>

            <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>probreportcall/save" data-qr="output_position=content" type="button" tabindex="15">
            <?php }else{?>
             <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>probreportcall/save" data-qr="output_position=content" type="button" tabindex="15">
            
            <?php } ?>

            <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="16">

        </form>


    </div>
</div>