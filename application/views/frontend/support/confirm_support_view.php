

<div class="box_head text_align_center width100">
    <h3>SUPPORT CALL</h3>
</div>

<div class="confirm_save width100">




    <div class="summary_info">

        <ul class="dtl_block">

            <?php   if(count($enq_que)>0){
                        foreach ($enq_que as $que_ans) { ?>


                            <li><span><?php echo $que_ans['que']; ?></span>

                                <p><?php echo ($que_ans['que_id'] == '166') ? $enq_other_que : $que_ans['ans']; ?></p> 

                            </li>

            <?php   }   } ?>
           



        </ul>

    </div>






    <div class="save_btn_wrapper float_left">

        <form name="enq_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_enq_call" value="yes">

            <input type="hidden" name="forword" value="<?php echo $forword; ?>">

            <input name="" value="Save" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>support/save_and_forword" data-qr="output_position=content" type="button" tabindex="21">

            <input name="" tabindex="22" value="CANCEL" class="cancel_btn style3"  type="button">

        </form>


    </div>

</div>





