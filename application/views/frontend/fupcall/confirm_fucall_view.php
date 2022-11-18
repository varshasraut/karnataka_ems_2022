<div class="box_head text_align_center width100">
    <h4 class="txt_pro">DISPATCH AMBULANCE</h4>
</div>


<div class="confirm_save width100">




    <div class="summary_info">

        <ul class="dtl_block">

              <ul class="dtl_block">
            <li><span>Incident Id :</span>

                <?php echo $fcl_inc_id; ?>

            </li>
            <li><span> Standard Remark :</span><?php echo $re_name; ?></li>
            <li><span>ERO Note : </span><?php echo $inc_ero_summary; ?></li>
        </ul>


        </ul>

    </div>

    <div id="summary_div">


    </div>




    <div class="save_btn_wrapper float_left beforeunload ">

        <form name="fup_call_fwd" method="post" id="">

            <input type="hidden" name="fwd_fupcall_call" value="yes">

<!--            <input name="" value="FORWARD" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>fupcall/save" data-qr="output_position=content" type="button" tabindex="15">-->
            
             <input name="" value="Save" class="accept_btn form-xhttp-request" data-href="<?php echo base_url(); ?>fupcall/save" data-qr="output_position=content" type="button" tabindex="15">
            
            <input name=""  value="CANCEL" class="cancel_btn style3"  type="button" tabindex="16">

        </form>


    </div>

</div>





