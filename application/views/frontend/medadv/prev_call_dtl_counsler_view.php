<div class="call_purpose_form_outer">

<h3 class="txt_clr2 width1 txt_pro">COUNSELOR CALL DETAILS</h3>
<div class="inline_fields width100">

    <div class="form_field width17">

        <div class="label">Added Date</div>

        <div class="input">

            <input name="" value="<?php echo $cl_dtl[0]->cons_cl_date; ?>" tabindex="11" class="" placeholder="" type="text" disabled=""> 

        </div>

    </div> 

   <!-- <div class="form_field width15">

        <div class="label">Date</div>

        <div class="input">

            <?php
            $date = explode(' ', $cl_dtl[0]->cons_cl_date);

            echo date('d-m-Y', strtotime($date[0]));
            ?>

        </div>

    </div> -->
    </div> 

    <div class="inline_fields width100">
    

    <div class="form_field width50">

        <div class="label">Standard Remark</div>

        <div class="field_input">


            <input name="" value="<?php echo $cl_dtl[0]->counslor_remark; ?>" tabindex="14" class="" placeholder="Select Protocol"  type="text" disabled="">


        </div>

    </div>
    <div class="form_field width50">

        <div class="label">Counselor Note</div>

        <div class="field_input">

            <textarea rows="3"  name="" style="text-transform: lowercase;" disabled=""><?php echo $cl_dtl[0]->cons_counslor_note; ?></textarea>
</div>

    </div>

</div>

</div>

