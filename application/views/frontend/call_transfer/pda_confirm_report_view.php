
<div class="box_head text_align_center width100">
    <h3 class="txt_pro">Call Transfer to PDA</h3>
</div>

<div class="confirm_save width100">

    
    <div class="summary_info">

        <ul class="dtl_block">
            <li><span>Incident Id :</span>

                <?php echo $rcl_inc_ref_id; ?>

            </li>
            <li><span> Standard Remark :</span><?php 
            if($re_name == 'address_the_complaint'){ 
                $remark='Addressed the complaint & case closed';
            }else if($re_name == 'forword_to_bike'){
                $remark='Forward to Bike for further action';
            }else if($re_name == 'forword_to_fleet'){
                $remark='Forward to Fleet for further action';
            }else if($re_name == 'forword_to_pda'){
                $remark='Forward to PDA for further action';
            }else if($re_name == 'forword_to_fda'){
                $remark='Forward to PDA for further action';
            }else if($re_name == 'forword_to_tdd'){
                $remark='Forward to TDD for further action';
            }else if($re_name == 'forword_to_situationaldesk'){
                $remark='Forward to Sitiational for further action';
            }
            echo $remark; ?></li>
             <li><span>ERO Summary:</span><?php echo $pda_std_summary; ?></li>
            <li><span>ERO Note : </span><?php echo $inc_ero_summary; ?></li>
        </ul>

    </div>

    




    <div class="save_btn_wrapper float_left beforeunload">

        <form name="com_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_all" value="<?php echo $forword;?>">
            <?php if($forword == 'no'){ ?>

            <input name="" value="SAVE" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>trans_call/pda_save" data-qr="output_position=content" type="button" tabindex="15">
            <?php }else{?>
             <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>trans_call/pda_save" data-qr="output_position=content" type="button" tabindex="15">
            
            <?php } ?>

            <input name="" value="CANCEL" class="cancel_btn style3"  type="button" tabindex="16">

        </form>


    </div>
</div>