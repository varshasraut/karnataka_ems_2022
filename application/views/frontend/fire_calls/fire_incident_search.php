<script>cur_pcr_step(1);</script>

<div class="call_purpose_form_outer">

    <div class="head_outer"><h4 class="txt_clr2 width1">CALL INFORMATION</h4> </div>

    <form method="post" name="" id="call_dls_info">

        <div class="inline_fields width100">

            <div class="form_field width100 pos_rel">

                <div class="outer_id width100">

                    <div class="float_left width_15"><h3>Incident Id <span class="md_field">*</span></h3></div>


                    <div class="input float_left width_16">

                        <input name="inc_ref_id" value="<?php echo date('Ymd'); ?>" tabindex="1" class="form_input filter_required" placeholder="Enter Incident Id" type="text" data-base="search_btn" data-errors="{filter_required:'Incident Id should not be blank!'}" >

                    </div>
                    <div class="float_left  ">

                        <input name="search_btn" value="SEARCH" class="style3 base-xhttp-request mt-0" data-href="{base_url}fire_calls/search_fire_call_details" data-qr="output_position=content" type="button">

                    </div> 
                </div>





            </div>

        </div>



    </form>


</div>
