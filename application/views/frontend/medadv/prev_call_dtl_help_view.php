<div class="call_purpose_form_outer">

<h3 class="txt_clr2 width1 txt_pro">CALL DETAILS</h3>
<div class="inline_fields width100">

    <div class="form_field width17">

        <div class="label">Added By</div>

        <div class="input">

            <input name="" value="<?php echo $cl_dtl[0]->adv_cl_added_by; ?>" tabindex="11" class="" placeholder="" type="text" disabled=""> 

        </div>

    </div> 

    <div class="form_field width15">

        <div class="label">Date</div>

        <div class="input">

            <?php
            $date = explode(' ', $cl_dtl[0]->adv_cl_date);

            echo date('d-m-Y', strtotime($date[0]));
            ?>

        </div>

    </div> 
    </div> 

    <div class="inline_fields width100">
    <div class="form_field width50">

        <div class="label">Impressions</div>

        <div class="field_input">

            <input name="" value="<?php echo $cl_dtl[0]->adv_cl_pro_dia; ?>" tabindex="12" class="" placeholder="" type="text" disabled=""> 


        </div>

    </div>

    <div class="form_field width50">

        <div class="label">Chief Complaint</div>

        <div class="field_input">


            <input name="" value="<?php echo $cl_dtl[0]->ct_type; ?>" tabindex="14" class="" placeholder="Select Protocol"  type="text" disabled="">


        </div>

    </div>
    <div class="form_field width50">

        <div class="label">Additional Information</div>

        <div class="field_input">

            <textarea rows="3"  name="" style="text-transform: lowercase;" disabled=""><?php echo $cl_dtl[0]->adv_cl_addinfo; ?></textarea>
<!--                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_addinfo; ?>" tabindex="13" class="" placeholder="" type="text" disabled=""> -->

        </div>

    </div>
    <div class="form_field width50">

        <div class="label">ERCP Additional Information</div>

        <div class="field_input">

<!--                <input name="" value="<?php echo $cl_dtl[0]->adv_cl_ercp_addinfo; ?>" tabindex="15" class="" placeholder="" type="text" disabled=""> -->
            <textarea rows="3" name="" style="text-transform: lowercase;" disabled=""><?php echo $cl_dtl[0]->adv_cl_ercp_addinfo; ?></textarea>

        </div>

    </div>


    <?php if ($cl_dtl[0]->adv_cl_madv_que == '243' || $cl_dtl[0]->adv_cl_madv_que == '246') { ?>
        <div class="width50 float_left">
            <div class="form_field width97">

                <div class="label">Chief Complaint Other</div>

                <div class="field_input">
                    <input name="" value="<?php echo $cl_dtl[0]->adv_cl_madv_que_other; ?>" tabindex="14" class="width100" placeholder="Chief Complaint Other"  type="text" disabled="">

                </div>

            </div>
        </div>
    <?php } ?>



</div>

</div>

