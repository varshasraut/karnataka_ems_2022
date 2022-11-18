<div class="call_purpose_form_outer">

    <h3>Grievance Call</h3>


    <form method="post" name="complnt_call_form" id="complnt_form">

        <input type="hidden" name="call_id" id="call_id" value="<?php echo $call_id; ?>">

        <input type="hidden" name="cl_purpose" id="" value="<?php echo $cl_purpose; ?>" data-base="search_btn">

        <input type="hidden" name="base_month"  value="<?php echo $cl_base_month; ?>" data-base="search_btn">

        <div class="width100 float_left">

            <div class="form_field width25">

                <div class="label">Type Of Complaint<span class="md_field">*</span></div>

                <div class="input top_left">

                    <input type="text" name="cmp_type" value="" id="cctype" class="mi_autocomplete filter_required"  data-href="{base_url}auto/get_cct_type"  placeholder="Incidence Complaint" data-errors="{filter_required:'Please select complaint from dropdown list'}">

                </div>

            </div> 

        </div>


        <div id="inc_filters">
        </div>


        <div id="inc_details">
        </div>


        <div class="width100 display_inlne_block pos_rel">

            <div class="width2 float_left">

                <div class="form_field">

                    <div class="label">Complaint Details<span class="md_field">*</span></div>

                    <div class="input">

                        <textarea tabindex="13" class="text_area width100 filter_required" name="cmp_details" rows="5" cols="30" data-errors="{filter_required:'Complaint details should not be blank!'}" data-maxlen="400"></textarea>

                    </div>

                </div> 

            </div>


            <div id="fwdcmp_btn">
            </div>

        </div>


    </form>


</div>